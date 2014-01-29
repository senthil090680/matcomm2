<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-12-10
# End Date		: 2010-12-10
# Project		: MatrimonyProduct
# Module		: Optimal Payment Gatway
#=============================================================================================================

include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsPayment.php");
include_once($varRootBasePath."/lib/clsUpgrade.php");
include_once($varRootBasePath.'/lib/clsReport.php');
#include_once($varRootBasePath."/www/payment/paymentprocess.php");
#include_once($varRootBasePath."/www/payment/ip2location.php"); // Added by Ashok to show offer link for India alone
include_once($varRootBasePath."/www/payment/cbsoptimalpaymentfunctions.php");

//SESSION VARIABLE
$sessMatriId		= $varGetCookieInfo["MATRIID"];

//VARIABLE DECLARATION
$varMatriIdPrefix	= substr($sessMatriId,0,3);
$varOrderId			= base64_decode($_REQUEST['orderId']);
$varDisplayMessage	= '';
$varRefundFlag		= 0;

//CHECK USER LOGGED OR NOT
if($sessMatriId =='') { header ("Location:".$confValues['SERVERURL']."/login/"); exit; }//if

//OBJECT DECLARATION
$objDB				= new MemcacheDB;
$objDowngradeProfile= new UpgradeProfile;
$objDBOffline		= new MemcacheDB;
$objSlaveRM			= new MemcacheDB();
$objReport	        = new Report;

//CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

##LIVE OFFLINE CONNECTION
$objDBOffline->dbConnect('ODB4_offlinecbs',$varOfflineCbsDbInfo['DATABASE']);

## RM DB CONNECTION
//$objDBOffline->dbConnection($varDbIP['ODB4_offlinecbs'],'communitypay','community4dump',$varOfflineCbsDbInfo['DATABASE']);
$objSlaveRM->dbConnect('S',$varCbsRminterfaceDbInfo['DATABASE']);

if($sessMatriId!='' && $varOrderId !=""){

	$varFields	= array('Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) AS ValidDaysLeft','Paid_Status','Last_Payment','Status','DATE(Last_Payment) AS Last_Payment_Date','Special_Priv');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varExecute		= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varNoOfRecords	= $objDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

	# CHECK MatriId EXIST in MEMBERINFO and MEMBERLOGININFO
	if($varNoOfRecords == 0){
		$varDisplayMessage	= "Matrimony Id not found in the database. Please contact our <a href=\"http://".$confValues['SERVERNAME']."/site/index.php?act=LiveHelp\" class=\"linktxt\">Support Desk</a>.";
		$varRefundFlag	= 1;
	}

	# GET MEMBERINFO DETAILS
	$varMemberInfo		= mysql_fetch_array($varExecute);
	$varStatus			= $varMemberInfo['Status'];
	$varPaidStatus		= $varMemberInfo['Paid_Status'];
	$varDaysLeft		= $varMemberInfo['ValidDaysLeft'];
	$varLastPayment		= $varMemberInfo['Last_Payment'];
	$varLastPaymentDate	= $varMemberInfo['Last_Payment_Date'];
	$varSpecialPriv		= $varMemberInfo['Special_Priv'];
    
	#Check Profile Suspended or not.
	if($varStatus == 3) {
		# Profile suspended.
		$varDisplayMessage	= "Your profile has been suspended. Please contact our <a href=\"http://".$confValues['SERVERNAME']."/site/index.php?act=LiveHelp\" class=\"linktxt\">Support Desk</a>.";
		$varRefundFlag	= 1;
	}
	if($varPaidStatus == 0){
		# Free Profile.
		$varDisplayMessage	= "Unable to cancel payment. Your profile is in free membership.";
		$varRefundFlag		= 1;
	}
	if($varDaysLeft <=0){
		# Profile expired.
		$varDisplayMessage	= "Unable to cancel payment. Your paid membership has expired.";
		$varRefundFlag		= 1;
	}

    ## CHECK MEMBER MESSAGE DETAILS
	$varCondition   	  = " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB)." AND Date_Sent>'$varLastPaymentDate 23:59:59'";
    $varNoOfMessageSent   = $objDB->numOfRecords($varTable['MAILSENTINFO'], $argPrimary='MatriId', $varCondition);
	if($varNoOfMessageSent > 0){
		$varDisplayMessage	= "You cannot cancel your payment now as you have already started utilizing our paid services. Cancellation can be done only if you have not used any of our paid services since renewal.";
		$varRefundFlag		= 1;
	}

	## CHECK MEMBER PHONE VIEWED DETAILS
	$varCondition   	  = " WHERE Opposite_MatriId =".$objDB->doEscapeString($sessMatriId,$objDB)." AND Date_Viewed>'$varLastPaymentDate 23:59:59'";
    $varNoOfPhoneViewed   = $objDB->numOfRecords($varTable['PHONEVIEWLIST'], $argPrimary='MatriId', $varCondition);
	if($varNoOfPhoneViewed > 0){
		$varDisplayMessage	= "You cannot cancel your payment now as you have already started utilizing our paid services. Cancellation can be done only if you have not used any of our paid services since renewal.";
		$varRefundFlag		= 1;
	}
   
    //SELECT Online Payment Details...
	$varPayFields	    = array('OrderId','Product_Id','Currency','Amount_Paid','Payment_Gateway');
	$varCondition		= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB)." AND Payment_Type=1 AND Payment_Mode=1 AND Payment_Gateway IN(3,5)";
	$varPaymentInfo		= $objDB->select($varTable['PAYMENTHISTORYINFO'], $varPayFields, $varCondition, 1);

	$varOrderId         = $varPaymentInfo[0]['OrderId'];
	$varAmountPaid      = $varPaymentInfo[0]['Amount_Paid'];
	$varProductId       = $varPaymentInfo[0]['Product_Id'];
	$varOrderId         = $varPaymentInfo[0]['OrderId'];
    $varPaymentGateway  = $varPaymentInfo[0]['Payment_Gateway'];
    
	if(!empty($varPaymentInfo) && $varRefundFlag==0){	
		$argFrom				= "CBS Auto Renewal";
		$argFromEmailAddress	= "payment@communitymatrimony.com";
		$argTo					= "Auto Renewal";
		$argToEmailAddress 		= "dhanapal@bharatmatrimony.com,srinivasan.c@bharatmatrimony.com,baranidharan.m@bharatmatrimony.com";
		$argSubject		   		= "Auto Renewal Refund";
		$argReplyToEmailAddress = $argFromEmailAddress;
		$varMessage= "Dear Team <br><br>";
		$varMessage.="Following member has tried for auto renewal refund.<br><br>"; 
		$varMessage.=" Matri Id: $sessMatriId  <br>\n Order Id: $varOrderId<br>\n Amount(USD): $varAmountPaid<br>\n Payment Gateway: $varPaymentGateway <br><br>Regards <br> Community Matrimony Team</br>";
		$objReport->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$varMessage,$argReplyToEmailAddress);

		if($varPaymentGateway == 5) {
			## SELECT Payment Details...
			$varTxnResponseCode = '';
			$varOptimalParms	= array();
			$varFields			= array('Confirmation_Number');
			$varCondition		= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
			$varPaymentDets		= $objDB->select($varTable['AUTORENEWCHARGE'], $varFields, $varCondition, 1);

			$varOptimalParms['transactionorderid']		= $varOrderId;
			$varOptimalParms['confirmationnumber']		= $varPaymentDets[0]['Confirmation_Number'];
			$varOptimalParms['amount']		            = $varAmountPaid;

			$XMLresponse        = OptimalCredit($varOptimalParms);

			if(strtoupper($XMLresponse) != "FAILURE"){
			$ResposeXML				= simplexml_load_string($XMLresponse);
			$varConfirmationNumber	= $ResposeXML->confirmationNumber;
			$varDecision			= $ResposeXML->decision; //Accepted,Error,Declined
			$varTxnResponseCode		= $ResposeXML->code;
			$varActionCode			= $ResposeXML->actionCode; // C,D,M,R
			$varDescription			= $ResposeXML->description;
			$varTxnTime				= $ResposeXML->txnTime;
		}
		$varReasonForCancellation = 'OPTIMAL - ONILNE PAYMENT REFUNDED ';
	}
	else if($varPaymentGateway == 3) {
	  //getting maxmind payment capture details
      $varFields		= array('VPC_TransactionNo');
      $varCondition		= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
      $varExecute		= $objDB->select($varTable['AUTORENEWCHARGE'], $varFields, $varCondition, 0);
      $varAutoRenewInfo	= mysql_fetch_array($varExecute);
      $vpc_TransNo		= $varAutoRenewInfo['VPC_TransactionNo'];
	  $varHdfcResponse  = refundMIGS($vpc_TransNo,$varAmountPaid,$varOrderId,'');
	  $varReasonForCancellation = 'ICICI - ONILNE PAYMENT REFUNDED ';
	}

	 #RAISE REFUND REQUEST FOR ONLINE PAYMENT
	 $varCurrentDate			= date('d-m-Y h:i:s');
     $varReasonForCancellation	= $varReasonForCancellation.$varCurrentDate;
	 $varFields		= array('MatriId','ProductId','OrderId','AmountRaised','AmountApproved','ReasonForCancellation','RequestRaisedOn','BranchId','UserID','RefundType','Status');
	 $argFieldsValue	= array($objDBOffline->doEscapeString($sessMatriId,$objDBOffline),$objDBOffline->doEscapeString($varProductId,$objDBOffline),$objDBOffline->doEscapeString($varOrderId,$objDBOffline),$objDBOffline->doEscapeString($varAmountPaid,$objDBOffline),$objDBOffline->doEscapeString($varAmountPaid,$objDBOffline),$objDBOffline->doEscapeString($varReasonForCancellation,$objDBOffline),"NOW()","1","0","1","3");
	 $varRefundRequestId	=	$objDBOffline->insert($varOfflineCbsDbInfo['DATABASE'].'.'.$varTable['CBSPAYMENTSREFUND'], $varFields, $argFieldsValue);

	## Based on the transaction result perform operation here
	if((strtoupper($varHdfcResponse) == 'APPROVED' && $varRefundFlag==0) || ($varTxnResponseCode=='0' && strtoupper($varDecision) == 'ACCEPTED' && $varRefundFlag==0)){
		    		
		$objDowngradeProfile->downgradeProfile($sessMatriId,$varProductId,$varRefundRequestId,$varSpecialPriv,$objDB,$objSlaveRM,$objDBOffline);
		$varDisplayMessage = "Your Paid Membership auto renewal has been cancelled successfully. You are now a free member on our site.";

	}else{
			if(!$varDisplayMessage)
			$varDisplayMessage = "Unable to cancel payment. Please try after some time.";
    	}
   }else{
       if(!$varDisplayMessage) 
	   $varDisplayMessage = "Unable to cancel payment. Your profile is in free membership.";
   }

}else{
	$varDisplayMessage	= ' You are not allowed to initiate refund process!';
}

#=================================================================================================

// REFUND AMOUNT FOR ICICI PAYMENT
function refundMIGS($vpc_TransNo,$vpc_Amount,$vpc_MerchTxnRef,$vpc_TicketNumber) {
	global $varHdfcUsdMerchantIdRecurring,$varHdfcUsdAccessCodeRecurring,$varHdfcRecurringUsername,$varHdfcRecurringPassword;
	$virtualPaymentClientURL='https://migs.mastercard.com.au/vpcdps';
	$vpc_Version=1;
	$vpc_Command='refund';
	$postData="virtualPaymentClientURL=".$virtualPaymentClientURL."&vpc_Version=".$vpc_Version."&vpc_Command=".$vpc_Command."&vpc_AccessCode=".$varHdfcUsdAccessCodeRecurring."&vpc_MerchTxnRef=".$vpc_MerchTxnRef."&vpc_Merchant=".$varHdfcUsdMerchantIdRecurring."&vpc_TransNo=".$vpc_TransNo."&vpc_Amount=".round($vpc_Amount*100)."&vpc_User=".$varHdfcRecurringUsername."&vpc_Password=".$varHdfcRecurringPassword."&vpc_TicketNumber=".$vpc_TicketNumber;
	ob_start();
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $virtualPaymentClientURL);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);
	curl_exec ($ch);
	
	$response	= ob_get_contents();
	ob_end_clean();
	$message = "";
	if(strchr($response,"<html>") || strchr($response,"<html>")) { $message = $response; } else {
		if (curl_error($ch))
		$message = "%s: s". curl_errno($ch) . "<br/>" . curl_error($ch);
	 }
	 curl_close ($ch);
	 $map = array();
	 if (strlen($message) == 0) { $pairArray = split("&", $response);
		foreach ($pairArray as $pair) {
			$param = split("=", $pair);
			$map[urldecode($param[0])] = urldecode($param[1]);
		}
	 }
	$txnResponseCode = null2Unknown($map, "vpc_TxnResponseCode");
	 if($txnResponseCode=='0'){ return "APPROVED"; }else{ return "FAILED"; }
}

function null2Unknown($map, $key) {
	if (array_key_exists($key, $map)) {
		if (!is_null($map[$key])) {
			return $map[$key];
		}
	} 
	return "No Value Returned";
}

#=================================================================================================

?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="550" bgcolor=#FFFFFF>
	<tr>
		<td valign="top" width="700" bgcolor="#FFFFFF"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="normtxt1 clr bld">Refund Process</font></div>
			<table border="0" width="450" cellpadding="5" cellspacing="0">
				<tr>
					<td valign="top" width="20"></td>
					<td valign="middle" class="smalltxt"><?=$varDisplayMessage;?><br><br></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td align="center" style="padding-bottom:10px;"><input type="button" class="button pntr" onClick="javscript:window.location='<?=$confValues["SERVERURL"];?>/payment/csetredirect.php';" value="Back to My Home"></td></tr>
 </table>

<?
$objDB->dbClose();
$objDBOffline->dbClose();
$objSlaveRM->dbClose();
UNSET($objDB);
UNSET($objDBOffline);
UNSET($objSlaveRM);
?>
