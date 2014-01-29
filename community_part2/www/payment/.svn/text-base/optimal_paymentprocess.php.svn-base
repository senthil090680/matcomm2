<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-12-10
# End Date		: 2010-12-10
# Project		: MatrimonyProduct
# Module		: Optimal Payment Gatway
#=============================================================================================================

$varMerchTxnRef		= trim($_REQUEST["vpc_MerchTxnRef"]);
$varOrderId			= trim($_REQUEST["vpc_OrderInfo"]);
$varSplitOrderId	= split("-",$varOrderId);
$varMatriIdPrefix	= substr($varSplitOrderId[0],0,3);

$varRootBasePath		= '/home/product/community';
include_once($varRootBasePath.'/conf/domainlist.cil14');
$_SERVER["HTTP_HOST"] = 'www.'.$arrPrefixDomainList[$varMatriIdPrefix];
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsPayment.php");
include_once($varRootBasePath."/lib/clsUpgrade.php");
include_once($varRootBasePath."/www/payment/paymentprocess.php");
include_once($varRootBasePath."/www/payment/ip2location.php"); // Added by Ashok to show offer link for India alone
include_once($varRootBasePath."/www/payment/cbsoptimalpaymentfunctions.php");



//CHECK USER LOGGED OR NOT
if($varOrderId =='') { header ("Location:".$confValues['SERVERURL']."/login/"); exit; }//if

//OBJECT DECLARATION
$objDB				= new MemcacheDB;
$objPayment			= new Payment;
$objUpgradeProfile	= new UpgradeProfile;

//CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
$varNoOfRecords = $objDB->numOfRecords($varTable['PREOPTIMALPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

if ($varNoOfRecords==1) {
    
	$varFields		 = array('MatriId','User_Name','Product_Id','Package_Cost','Currency','Amount_Paid','Date_Paid');
	$varExecute		    = $objDB->select($varTable['PREOPTIMALPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
	$varPaymentInfo	    = mysql_fetch_array($varExecute);
	$varTotalDays		= 0;
	$sessMatriId		= $varPaymentInfo['MatriId'];
	$varUserName		= $varPaymentInfo['User_Name'];
	$varCategory		= $varPaymentInfo['Product_Id'];
	$varAmount			= $varPaymentInfo['Amount_Paid'];
	$varCurrency		= $varPaymentInfo['Currency'];
	$varPackageCost		= $varPaymentInfo['Package_Cost'];
	$varValidDays		= $arrPkgValidDays[$varCategory];
	$varTotalDays		= $arrPkgValidDays[$varCategory];
	$varCnCode			= trim($_POST['countryCode']);
    $varCountry			= $varCnCode;
	$varBillingName		= trim($_POST['cardHolderName']);
	$varCreditCardType	= trim($_POST['vpc_card']);
	$varCreditCardNumber1= trim($_POST['vpc_CardNum']);
	$varCreditCardNumber= str_replace(" ","",$varCreditCardNumber1);
	$varExpMon			= trim(substr($_POST['vpc_CardExp'],-2));
	$varExpYear			= trim(substr($_POST['vpc_CardExp'],0,2));
	$varExpYearFourDigit= substr(date('Y'),0,2).$varExpYear;
	$varCreditCardCvv	= trim($_POST['vpc_CardSecurityCode']);
	$varBillingAddr     = trim($_POST['address']);
	$varBillingCity     = trim($_POST['city']);
	$varUsState			= trim($_POST['USState']);
	$varOtherState		= trim($_POST['otherstate']);
	$varZipcode			= trim($_POST['zipCode']);
	$varBillingCountry	= trim($_POST['country']);
	$varProductId		= $varCategory;
    
	## ASSIGN DEFAULT CURRENCY AS USD.
	$varCurrency = "USD";

	    
	##SERVRE SIDE VALIDATION FOR FORM FIELDS
	if($sessMatriId==""){
		$varDisplayMessage="Could not get Matrimony ID.";
	}
	else
	{       
		    $transactionorderid = $varMerchTxnRef;
            if($varBillingCountry=="222"){
			$varBillingState	= $varUsState;
			}else{
			$varBillingState	= $varOtherState;
			}


		    //Optimal Starts - Added by Kanagaraj
			$optimalParms=array();
			$optimalParms['transactionorderid']		= $transactionorderid;
			$optimalParms['Opt_Amount']				= $varAmount;
			$optimalParms['Opt_CardType']           = $varCreditCardType;
			$optimalParms['Opt_CardNum']			= $varCreditCardNumber;
			$optimalParms['cardExpiryMonth']		= $varExpMon;
			$optimalParms['cardExpiryYear']			= $varExpYearFourDigit;
			$optimalParms['Opt_CardSecurityCode']	= $varCreditCardCvv;
			$optimalParms['OptAdditionalData']		= $sessMatriId."_".$varCategory;
          
			$txnResponseCode = '';
			$XMLresponse     = OptimalPurchase($optimalParms);
            
			if(strtoupper($XMLresponse) != "FAILURE")
			{
				$varResposeXML         = simplexml_load_string($XMLresponse);
				$varConfirmationNumber = $varResposeXML->confirmationNumber;
				$varDecision		   = $varResposeXML->decision; //Accepted,Error,Declined
				$varTxnResponseCode	   = $varResposeXML->code;
				$varActionCode		   = $varResposeXML->actionCode; // C,D,M,R
				$varDescription		   = $varResposeXML->description;
				$varTxnTime			   = $varResposeXML->txnTime;
			}

			#$varDecision			= "Accepted"; //TEST
		    #$varTxnResponseCode	    = 0; //TEST

			if (($varTxnResponseCode=='0' && strtoupper($varDecision) == 'ACCEPTED')){
                
				//SELECT Card Number...
				$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
				$varCardFields	= array('AES_DECRYPT(Card_Number,"password") As CardNo');
				$varExecute1	= $objDB->select('onlinepaymentdetails', $varCardFields, $varCondition, 0);
				$varCardInfo	= mysql_fetch_array($varExecute1);
				$varCardNo		= substr($varCardInfo["CardNo"],0,6);

				$varMaxMindFields	= array('IP_Address','Billing_City','Billing_Region','Billing_Country','IP_ISP','Date_Captured');
				$varExecute12	= $objDB->select('maxmindpaymentcapture', $varMaxMindFields, $varCondition, 0);
				$varBillingInfo	= mysql_fetch_array($varExecute12);
				$varAddress		= $varBillingInfo["IP_Address"];
				$varCity		= $varBillingInfo["Billing_City"];
				$varState		= $varBillingInfo["Billing_Region"];
				$varCountry		= $varBillingInfo["Billing_Country"];
				$varZipCode		= $varBillingInfo["IP_ISP"];
				$varCountry		= $arrCountryList[$varCountry]; 

				//CHECK MAXMIND OPTION HERE
				include_once($varRootBasePath."/www/payment/maxmind/maxmind.php");

				$varMaxMind			= getMaxmindRiskScore($varCity,$varState,$varZipCode,$varCountry,$varCardNo);
				$varOutputKeys		= array_keys($varMaxMind);
				$varNoOfOutputKeys	= count($varMaxMind);
				$varIPLocation		= getIptoLocation();

				for ($i = 0; $i < $varNoOfOutputKeys; $i++) {
					
					$key = $varOutputKeys[$i];
					$value = $varMaxMind[$key];

				}//for

				$varScore				= $varMaxMind['score'];
				$varRiskScore			= round($varMaxMind['riskScore']);
				$varHighRiskCountry		= $varMaxMind['highRiskCountry'];
				$varBinMatch			= $varMaxMind['binMatch'];
				$varRecommendation		= addslashes($varMaxMind['explanation']);
				$varCountryMatch		= $varMaxMind['countryMatch'];
				$varCountryCodeFromIP	= $varMaxMind['countryCode'];
				$varIP_ISP				= $varMaxMind['ip_isp'];
				$varIP_City				= $varMaxMind['ip_city'];
				$varIP_Region			= $varMaxMind['ip_region'];

				if ($varRiskScore >'30') {

					//Update maxmindpaymentcapture TABLE
					$varFields				= array('VPC_TransactionNo','Risk_Score');
					$varFieldsValues		= array("'".$_REQUEST["vpc_TransactionNo"]."'","'".$varRiskScore."'");
					$varOrderIdCondition	= " OrderId ='".$varOrderId."'";
					$objDB->update('maxmindpaymentcapture', $varFields, $varFieldsValues, $varOrderIdCondition);

					$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Your payment status is currently under validation. Kindly await e-mail confirmation from us to start contacting prospects.</td></tr></table>";

				} else {
                    $varDisplayMessage	= $objUpgradeProfile->CBS_upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$varTable['PREOPTIMALPAYMENTHISTORYINFO']);
                    
					##Update preoptimalpaymenthistoryinfo TABLE
					$varCondition123= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
					$varFields		= array("Confirmation_Number");
					$varFieldsValue	= array($objDB->doEscapeString($varConfirmationNumber,$objDB));
					$objDB->update($varTable['PREOPTIMALPAYMENTHISTORYINFO'], $varFields, $varFieldsValue, $varCondition123);



				}//upgradeProfile


				//DELETE BEFORE VALIDATION TBALE
				$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
				$objDB->delete('onlinepaymentfailures', $varCondition12);
			   }else {
                    
					//UPDATE SECURE FAILURE
					$varFields12		= array('3dSecureFailure');
					$varFieldsValue12	= array('1');
					$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
					$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);
					
					$varCondition123= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
					$varFields		= array('Gateway_Status','Reason_Of_Failure','Confirmation_Number');
					$varFieldsValue	= array($objDB->doEscapeString($varTxnResponseCode,$objDB),$objDB->doEscapeString($varDescription,$objDB),$objDB->doEscapeString($varConfirmationNumber,$objDB));
					$objDB->update($varTable['PREOPTIMALPAYMENTHISTORYINFO'], $varFields, $varFieldsValue, $varCondition123);
                    					
    				$varDisplayMessage	= $varFailureMsg;
			}
	}
	
}else { $varDisplayMessage	= ' Could not find the OrderId '; }



include_once($varRootBasePath.'/www/template/paymentheader.php');
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="700" bgcolor=#FFFFFF>
	<tr>
		<td valign="top" width="700" bgcolor="#FFFFFF"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="normtxt1 clr bld">Payment Confirmation</font></div>
			<table border="0" width="650" cellpadding="5" cellspacing="0">
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
include_once($varRootBasePath.'/www/template/paymentfooter.php');
UNSET($objDB);
?>