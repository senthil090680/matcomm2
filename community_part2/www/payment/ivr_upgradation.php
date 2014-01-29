<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-12-31
# End Date		: 2010-12-31
# Project		: Community
# Module		: Payment - IVRS integration
#=============================================================================================================

## FILE INCLUDES
$varRootBasePath		= '/home/product/community';
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.inc');
include_once($varRootBasePath.'/conf/payment.inc');
include_once($varRootBasePath."/conf/vars.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsPayment.php");
include_once($varRootBasePath."/lib/clsUpgrade.php");
include_once($varRootBasePath."/www/payment/paymentprocess.php");


## INPUT FROM IVRS
$varOrderId				= trim($_REQUEST["ORDERID"]);
$varMobilePassword		= trim($_REQUEST['OTP']);
$varCreditcardNumber	= trim($_REQUEST["CREDITCARDNUMBER"]);
$varExpMonth			= trim($_REQUEST["EXPMON"]);
$varExpYear				= trim($_REQUEST["EXPYEAR"]);
$varCVV					= trim($_REQUEST["CVV"]);
$varCardType            = checkCreditCardType($varCreditcardNumber);
$varRequestId           = $_REQUEST['REQUESTID'];
$varResponseId          = $_REQUEST['RESPONSEID'];
$varCardFirstDigit		= substr($varCreditcardNumber,0,1);
$varStrMerchantId		= "00005183"; //?

## OBJECT DECLARATION
$objDB					= new MemcacheDB;
$objPayment				= new Payment;
$objUpgradeProfile		= new UpgradeProfile;

## CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varCondition	 = " WHERE OrderId ='".$varOrderId."'";
$varNoOfRecords  = $objDB->numOfRecords($varTable['PREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

$varCheckOrderId = $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

function displayMessage($argMessage){
 	 header("Content-type: text/xml");
	 echo "<TRANSACTION>";
	 echo $argMessage;
	 echo "</TRANSACTION>";
}

if ($varCheckOrderId>0){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(strlen($varCreditcardNumber) == 0){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(($varCardFirstDigit != 3)&&($varCardFirstDigit != 4)&&($varCardFirstDigit != 5)){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}  

if(($varCardFirstDigit == 3)&&(strlen($varCardFirstDigit) != 14)){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
} 
if((($varCardFirstDigit == 4) || ($varCardFirstDigit == 5)) && (strlen($varCreditcardNumber) != 16)){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(substr($varCreditcardNumber,0,4) == '5081'){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(strlen($varExpMonth) == 0){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(strlen($varExpYear) == 0){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(strlen($varCVV) == 0){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

if(strlen($varCVV) != 3){
	$varXML="<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;
}

#################################### IVRS UPGRDATION ######################################################

if ($varNoOfRecords==0){
	$varXML	= "<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;

} else {

	$varFields		= array('MatriId','User_Name','Product_Id','Package_Cost','Currency','Amount_Paid','Date_Paid');
	$varExecute		= $objDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
	$varPaymentInfo	= mysql_fetch_array($varExecute);
	
	$sessMatriId		= $varPaymentInfo['MatriId'];
	$varCategory		= $varPaymentInfo['Product_Id'];
	$varAmount			= floor($varPaymentInfo['Amount_Paid']);
	$varCurrency		= $varPaymentInfo['Currency'];
	$varPackageCost		= $varPaymentInfo['Package_Cost'];
	$varValidDays		= $arrPkgValidDays[$varCategory];
	$varTotalDays		= $arrPkgValidDays[$varCategory];
	$varAmount			= sprintf("%.2f",$varAmount);
	$varMessage         = '';
	$varSubject         = '';
	$varIPLocation      = '';


	## IVRS Components include
	$varIncludePath="/home/product/community/www/payment/ivrspayment/";
	include($varIncludePath."Sfa/BillToAddress.php");
	include($varIncludePath."Sfa/CardInfo.php");
	include($varIncludePath."Sfa/Merchant.php");
	include($varIncludePath."Sfa/MPIData.php");
	include($varIncludePath."Sfa/ShipToAddress.php");
	include($varIncludePath."Sfa/PGResponse.php");
	include($varIncludePath."Sfa/PostLibPHP.php");
	include($varIncludePath."Sfa/PGReserveData.php");
	include($varIncludePath."Sfa/Address.php");
	include($varIncludePath."Sfa/SessionDetail.php");
	include($varIncludePath."Sfa/CustomerDetails.php");
	include($varIncludePath."Sfa/MerchanDise.php");
	include($varIncludePath."Sfa/AirLineTransaction.php");

	$oMPI 		            = 	new MPIData();
	$oCI		            =	new	CardInfo();
	$oPostLibphp            =	new	PostLibPHP();
	$oMerchant	            =	new	Merchant();
	$oBTA		            =	new	BillToAddress();	
	$oSTA		            =	new	ShipToAddress();
	$oPGResp	            =	new	PGResponse();
	$oPGReserveData         =   new PGReserveData();

    ## Bharosa Object

	$oSessionDetails   		=  new SessionDetail();
	$oCustomerDetails   	=  new CustomerDetails();
	$oOfficeAddress      	=  new Address();
	$oHomeAddress    		=  new Address();
	$oMerchanDise       	=  new MerchanDise();
	$oAirLineTransaction 	=  new AirLineTransaction();
   
    $varSendRequestURL		= "https://3dsecure.payseal.com/MPIXMLService/authenticate";
	ob_start();
    $varCurl				= curl_init();
    $varSendRequestPostDetails="xmlData=<req-auth>
									<request-id>".$varRequestId."</request-id>
									<response-id>".$varResponseId."=</response-id>
									<req-type>1002</req-type>
									<auth-data>
									     <field name='OTP2' value='".$varMobilePassword."' />
									</auth-data>
							  </req-auth>";

	curl_setopt ($varCurl, CURLOPT_URL, $varSendRequestURL);
	curl_setopt ($varCurl, CURLOPT_POST, 1);
	curl_setopt ($varCurl, CURLOPT_POSTFIELDS, $varSendRequestPostDetails);
	curl_exec ($varCurl);
	curl_close ($varCurl);
	$varSendRequestResult = ob_get_contents();
    ob_end_clean();

	/*
	//OUTPUT
	//eci SUCCESS CODE  02 -> FOR MASTER CARD   05 -> FOR VISA CARD
	//SUCCESS FOR MASTER CARD 	
	<res-auth>
	    <request-id>628340984</request-id>
		<response-id>NjU3Mjg2Mjc=</response-id>
		<action-code>0</action-code>
		<status-code>2</status-code>
		<auth-result>
		   <error-code>0</error-code>
		   <error-description>success</error-description>
		   <error-play-message>success</error-play-message>
		   <cavv>jPla0WVqCWUaCBECTH3XBJgAAAA=</cavv>
		   <eci>02</eci>
		   <xid>TVBJWElENndONnRRNnNPMm1QMnM=</xid>
		   <message-hash></message-hash>
		 </auth-result>
	</res-auth>
	*/

	
	$varGetXMLResponce  = simplexml_load_string($varSendRequestResult);
	$varECI				= $varGetXMLResponce->xpath('/res-auth/auth-result/eci');
	$varXID				= $varGetXMLResponce->xpath('/res-auth/auth-result/xid');
	$varCavv			= $varGetXMLResponce->xpath('/res-auth/auth-result/cavv');
	$varErrorCodes		= $varGetXMLResponce->xpath('/res-auth/auth-result/error-code');

	if((($varCardType =='VISA' && $varECI[0]=='05') || ($varCardType =='MC' && $varECI[0]=='02')) && $varErrorCodes[0] == '0'){
		$oMerchant->setMerchantDetails($varStrMerchantId,"","",GetRemoteAddress(),$varOrderId,"","","POST","INR","","req.Preauthorization",$varAmount,"","","","","","");
	    $oCI->setCardDetails($varCardType,$varCardNumber,$varCVV,$varExpYear,$varExpMonth,"","CREDI");
	    $oMPI->setMPIResponseDetails  ($varECI, $varXID, "Y",$varCavv,"",$varAmount,"356");

	}else{

		$varXML="<STATUS>FAILED</STATUS>";
		displayMessage($varXML);
		exit;
	}
	

	$oBTA				= null;
	$oSTA				= null;	
	$oPGReserveData		= null;
	$oCustomerDetails	= null;
	$oSessionDetails	= null;
	$oAirLineTransaction= null;
	$oMerchanDise		= null;

 	$oPGResp=$oPostLibphp->postMOTO($oBTA,$oSTA,$oMerchant,$oMPI,$oCI,$oPGReserveData,$oCustomerDetails,$oSessionDetails,$oAirLineTransaction,$oMerchanDise);	

	$varMotoRespCode		= java_values($oPGResp->getRespCode());
	$varMotoRespMessage 	= java_values($oPGResp->getRespMessage());
	$varMotoTxnId			= java_values($oPGResp->getTxnId());
	$varMotoEpgTxnId		= java_values($oPGResp->getEpgTxnId());
	$varMotoAuthIdCode		= java_values($oPGResp->getAuthIdCode());
	$varMotoRRN				= java_values($oPGResp->getRRN());
	$varMotoCVRespCode		= java_values($oPGResp->getCVRespCode());
    $varMotoFDMSScore		= java_values($oPGResp->getFDMSScore());
	$varMotoFDMSResult		= java_values($oPGResp->getFDMSResult());   
	$varMotoCookie			= java_values($oPGResp->getCookie());


	if($varMotoRespCode=='0'){

		$varDisplayMessage	= $objUpgradeProfile->CBS_upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$varTable['PREPAYMENTHISTORYINFO']);

		## DELETE BEFORE VALIDATION TBALE
		$varCondition12		= " MatriId ='".$sessMatriId."'";
		$objDB->delete('onlinepaymentfailures', $varCondition12);
	}
	else{
     
		## UPDATE SECURE FAILURE
		$varFields12		= array('3dSecureFailure');
		$varFieldsValue12	= array('1');
		$varCondition12		= " MatriId ='".$sessMatriId."'";
		$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);

		
		$varErrorCodes     = getResponseDescription($varMotoRespCode);
		$varXML            = "<STATUS>FAILED</STATUS>";
		displayMessage($varXML);

		## Send mail to support team with details
		$message="Matrimony ID : $sessMatriId\n";
		$message.="Charge Total  : $varAmount\n";
		$message.="Membership : $varCategory\n";
		$message.="Card Number   : $varCardNumber\n";
		$message.="Card Exp. Date : $varExpMonth - $varExpYear\n";
		$message.="Card CVV No. : $varCVV\n";
		$mailprog="/usr/sbin/sendmail";
		$subject="Credit Card Transaction - $id - INR payment";
		$frommail="webmaster\@bharatmatrimony.com";

		$headers = "MIME-Version: 1.0\n";	
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: $frommail\n";
		mail("dhanapal@bharatmatrimony.com,srinivasan.c@bharatmatrimony.com",$subject,$varErrorCodes."**".$varMotoRespCode,$headers);
	}	

}


function checkCreditCardType($varCardNumber) {

		if(preg_match('/^[0-9]$/{1,}', $varCardNumber) && strlen($varCardNumber)=='16' && (substr($varCardNumber,0,2)=='51' || substr($varCardNumber,0,2)=='52' || substr($varCardNumber,0,2)=='53' || substr($varCardNumber,0,2)=='54' || substr($varCardNumber,0,2)=='55')){
			return 'MC';
		}
		elseif(preg_match('/^[0-9]$/{1,}', $varCardNumber) && (strlen($varCardNumber)=='13' || strlen($varCardNumber)=='16') && substr($varCardNumber,0,1)=='4'){
			return 'VISA';
		}
		else{
			return 'NONE';
		}

}
function getResponseDescription($varResponseCode) {

    switch ($varResponseCode) {
        case "0" : $result = "Transaction Successful"; break;
        case "?" : $result = "Transaction status is unknown"; break;
        case "1" : $result = "Unknown Error"; break;
        case "2" : $result = "Bank Declined Transaction"; break;
        case "3" : $result = "No Reply from Bank"; break;
        case "4" : $result = "Expired Card"; break;
        case "5" : $result = "Insufficient funds"; break;
        case "6" : $result = "Error Communicating with Bank"; break;
        case "7" : $result = "Payment Server System Error"; break;
        case "8" : $result = "Transaction Type Not Supported"; break;
        case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
        case "A" : $result = "Transaction Aborted"; break;
        case "C" : $result = "Transaction Cancelled"; break;
        case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
        case "F" : $result = "3D Secure Authentication failed"; break;
        case "I" : $result = "Card Security Code verification failed"; break;
        case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
        case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
        case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
        case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
        case "S" : $result = "Duplicate SessionID (OrderInfo)"; break;
        case "T" : $result = "Address Verification Failed"; break;
        case "U" : $result = "Card Security Code Failed"; break;
        case "V" : $result = "Address Verification and Card Security Code Failed"; break;
        default  : $result = "Unable to be determined";
    }
    return $result;
}

?>