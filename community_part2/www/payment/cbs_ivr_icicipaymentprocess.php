<?php
#=============================================================================================================
# Author 		: Srinivasan C
# Start Date	: 2011-02-11
# End Date		: 2011-02-11
# Project		: MatrimonyProduct
# Module		: IVR First Level Authentication file
#=============================================================================================================

$varRootBasePath		= '/home/product/community';
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsPayment.php");
include_once($varRootBasePath."/lib/clsUpgrade.php");
include_once($varRootBasePath."/www/payment/paymentprocess.php");

$varPaySealMerchantId   = 'M00000000005182'; //?
$varOrderId				= trim($_REQUEST["ORDERID"]);
$varCreditcardNumber	= trim($_REQUEST["CREDITCARDNUMBER"]);
$varExpMonth			= trim($_REQUEST["EXPMON"]);
$varExpYear				= trim($_REQUEST["EXPYEAR"]);
$varExpYear             = "20".$varExpYear;
$varCVV					= trim($_REQUEST["CVV"]);
$varMobileNumber		= trim($_REQUEST['MOBILENUMBER']); //?Extra Field
$varCardFirstDigit		= substr($varCreditcardNumber,0,1);


## OBJECT DECLARATION
$objDB					= new MemcacheDB;
$objPayment				= new Payment;
$objUpgradeProfile		= new UpgradeProfile;

## CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
$varNoOfRecords = $objDB->numOfRecords($varTable['PREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

$varCheckOrderId=$objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

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

##########################################################################################

if ($varNoOfRecords==0){
	$varXML	= "<STATUS>FAILED</STATUS>";
	displayMessage($varXML);
	exit;

} else {

	$varFields		= array('MatriId','User_Name','Product_Id','Package_Cost','Currency','Amount_Paid','Date_Paid','Discount','DiscountFlatRate');
	$varExecute		= $objDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
	$varPaymentInfo	= mysql_fetch_array($varExecute);
	
	$sessMatriId			= $varPaymentInfo['MatriId'];
	$varUserName			= $varPaymentInfo['User_Name'];
	$varCategory			= $varPaymentInfo['Product_Id'];
	$varAmount				= floor($varPaymentInfo['Amount_Paid']);
	$varCurrency			= $varPaymentInfo['Currency'];
	$varPackageCost			= $varPaymentInfo['Package_Cost'];
	$varDiscount			= $varPaymentInfo['Discount'];
	$varDiscountFlatRate	= $varPaymentInfo['DiscountFlatRate'];
	$varValidDays			= $arrPkgValidDays[$varCategory];
	$varTotalDays			= $arrPkgValidDays[$varCategory];
	
	
	if ($varCategory==0){
		$varXML	= "<STATUS>FAILED</STATUS>";
		displayMessage($varXML);
		exit;
	}

	## Begin First Level Authentication
	$varCardExprMonthYear       = sprintf('%02d',$varExpMonth).substr($varExpYear,2,2);//0713
	$virtualPaymentClientURL	= "https://3dsecure.payseal.com/MPIXMLService/authenticate";
    
    $varSendReqPostDetails		= "xmlData=<req-auth>
									<request-id>".time()."</request-id>
									<req-type>1001</req-type>
									<card-details>
										<card-number>".$varCreditcardNumber."</card-number>
										<expiry>".$varCardExprMonthYear."</expiry>
									</card-details>
									<txn-details>
										<merchant-name>Bharatmatrimony</merchant-name>
										<mid>".$varPaySealMerchantId."</mid>
										<amount>".$varAmount."</amount>
										<currency>356</currency>
										<order-description>Test</order-description>
										<device-category-id>1</device-category-id>
										<device-id format='D'>".$varMobileNumber."</device-id>
										<itp-rule>no</itp-rule>
										<avail-auth-channel>SMS</avail-auth-channel>
										<user-agent>Nokia</user-agent>
									</txn-details>
								</req-auth>";
								
    ob_start();
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $virtualPaymentClientURL);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $varSendReqPostDetails);
	curl_exec ($ch);
	curl_close ($ch);
	$varSendRequestedResult = ob_get_contents();
	## turn output buffering off.
	ob_end_clean();
    	
    $varGetXMLResponce          = simplexml_load_string($varSendRequestedResult);
	$varReceiveIvrRequestId		= $varGetXMLResponce->xpath('/res-auth/request-id');
	$varReceiveIvrResponceId	= $varGetXMLResponce->xpath('/res-auth/response-id');
	$varActionCode				= $varGetXMLResponce->xpath('/res-auth/action-code');
	$varStatusCode				= $varGetXMLResponce->xpath('/res-auth/status-code');

	$varFields		= array('MatriId','User_Name','OrderId','Product_Id','Currency','Package_Cost','Amount_Paid','Discount','DiscountFlatRate','Display_Currency','Display_Amount_Paid','Display_Package_Cost','Date_Captured','Gateway','Card_Number','CVV','Expiry_Month','Expiry_Year','Request_Id','Response_Id');

	$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varUserName,$objDB),$objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($varCategory,$objDB),$objDB->doEscapeString($varCurrency,$objDB),$objDB->doEscapeString($varPackageCost,$objDB),$objDB->doEscapeString($varAmount,$objDB),$objDB->doEscapeString($varDiscount,$objDB),$objDB->doEscapeString($varDiscountFlatRate,$objDB),$objDB->doEscapeString($varCurrency,$objDB),$objDB->doEscapeString($varAmount,$objDB),$objDB->doEscapeString($varPackageCost,$objDB),"NOW()","4",'AES_ENCRYPT('.str_replace(" ","",$objDB->doEscapeString($varCreditcardNumber,$objDB)).',"password")','AES_ENCRYPT('.str_replace(" ","",$objDB->doEscapeString($varCVV,$objDB)).',"password")',$objDB->doEscapeString($varExpMonth,$objDB),substr($varExpYear,2,2),$objDB->doEscapeString($varReceiveIvrRequestId[0],$objDB),$objDB->doEscapeString($varReceiveIvrResponceId[0],$objDB));
	$objDB->insertOnDuplicate($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varFields, $argFieldsValue, 'MatriId');
  
	if($varActionCode[0] == '0' && $varStatusCode[0] == '1'){
		$varXML = "<STATUS>SUCCESS</STATUS>";
		$varXML.= "<ORDERID>".$varOrderId."</ORDERID>";
		$varXML.= "<REQUESTID>".$varReceiveIvrRequestId[0]."</REQUESTID>";
		$varXML.= "<RESPONSEID>".$varReceiveIvrResponceId[0]."</RESPONSEID>";
		displayMessage($varXML);
	}else{
		$varXML= "<STATUS>FAILED</STATUS>";
		displayMessage($varXML);
		exit;
	}
}


?>