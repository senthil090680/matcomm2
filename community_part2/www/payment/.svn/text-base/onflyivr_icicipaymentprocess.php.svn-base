<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2011-01-13
# End Date		: 2011-01-13
# Project		: MatrimonyProduct
# Module		: IVR PAYMENT REDIRECT FROM ICICI FAILURE
#=============================================================================================================

##  ONFLY IVR INRORMATION FROM ONLINETOIVRCONVERSIONPAYMENTDETAILS
$varCondition			= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
$varFields				= array('AES_DECRYPT(CVV,"password") As CVV','AES_DECRYPT(Card_Number,"password") As CardNo','Expiry_Month','Expiry_Year');
$varExecute				= $objDB->select($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varFields, $varCondition, 0);
$varIVRPaymentInfo		= mysql_fetch_array($varExecute);


$varMerchantId			= '00100200';
$varOrderId			    =  trim($varOrderId);
$varSecureSecret		= '96509D7BA51421043406C3DC8D3959B4';
$varAccessCode			= 'E8738983';
$varCreditcardNumber	= trim($varIVRPaymentInfo["CardNo"]);
$varExpMonth			= trim($varIVRPaymentInfo["Expiry_Month"]);
$varExpYear				= trim($varIVRPaymentInfo["Expiry_Year"]);
$varCVV					= trim($varIVRPaymentInfo["CVV"]);
$varCardFirstDigit		= substr($varCreditcardNumber,0,1);

$varNoOfRecords			= $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

##########################################################################################

if ($varNoOfRecords>0){
	$varDisplayMessage	= "You have made a payment recently";

} else {

	$varFields		= array('MatriId','User_Name','Product_Id','Package_Cost','Currency','Amount_Paid','Date_Captured');
	$varExecute		= $objDB->select($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varFields, $varCondition, 0);
	$varPaymentInfo	= mysql_fetch_array($varExecute);

	$varTotalDays		= '0';
	$varFailureProcess	= 'no';
	$sessMatriId		= $varPaymentInfo['MatriId'];
	$varUserName		= $varPaymentInfo['User_Name'];
	$varCategory		= $varPaymentInfo['Product_Id'];
	$varAmount			= $varPaymentInfo['Amount_Paid'];
	$varCurrency		= $varPaymentInfo['Currency'];
	$varPackageCost		= $varPaymentInfo['Package_Cost'];
	$varValidDays		= $arrPkgValidDays[$varCategory];
	$varTotalDays		= $arrPkgValidDays[$varCategory];

	$virtualPaymentClientURL	= "https://migs.mastercard.com.au/vpcdps";
	$gatetitle					= "PHP VPC 2-Party with CSC";
	$vpc_Amount					= round($varAmount*100);
    ## $iciciorderid			= $sessMatriId."-".$varOrderId."-".date("YmdHis");
	$iciciorderid				= $varOrderId;
	$vpc_MerchTxnRef			= $iciciorderid;
	$vpc_OrderInfo				= $iciciorderid;

	
    ##  CREATE A VARIABLE TO HOLD THE POST DATA INFORMATION AND CAPTURE IT
	$postData = "";
	$ampersand = "";
	$postData = "vpc_Version=1&vpc_Command=pay&vpc_AccessCode=".$varAccessCode."&vpc_MerchTxnRef=".$vpc_MerchTxnRef."&vpc_Merchant=".$varMerchantId."&vpc_OrderInfo=".$vpc_OrderInfo."&vpc_Amount=".$vpc_Amount."&vpc_CardNum=".$varCreditcardNumber."&vpc_CardExp=".$varExpYear.$varExpMonth."&vpc_CardSecurityCode=".$varCVV."&vpc_TxSource=MOTO";
	$ampersand = "&";


	##  Get a HTTPS connection to VPC Gateway and do transaction
	##  turn on output buffering to stop response going to browser
	ob_start();

	##  initialise Client URL object
	$ch = curl_init();

	##  set the URL of the VPC
	curl_setopt ($ch, CURLOPT_URL, $virtualPaymentClientURL);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);

	##  connect
	curl_exec ($ch);

	##  get response
	$response = ob_get_contents();
	

	##  turn output buffering off.
	ob_end_clean();

	##  set up message paramter for error outputs
	$message = "";

	##  serach if $response contains html error code
	if(strchr($response,"<html>") || strchr($response,"<html>")) {;
		$message = $response;
	} else {
		##  check for errors from curl
		if (curl_error($ch))
			$message = "%s: s". curl_errno($ch) . "<br/>" . curl_error($ch);
		}

	##  close client URL
	curl_close ($ch);


	##  Extract the available receipt fields from the VPC Response
	##  If not present then let the value be equal to 'No Value Returned'
	$map = array();

	##  process response if no errors
	if (strlen($message) == 0) {
		$pairArray = split("&", $response);
		foreach ($pairArray as $pair) {
			$param = split("=", $pair);
			$map[urldecode($param[0])] = urldecode($param[1]);
		}
		$message = null2unknown($map, "vpc_Message");
	} 


##  Define Variables
##  ----------------
##  Extract the available receipt fields from the VPC Response
##  If not present then let the value be equal to 'No Value Returned'

##  Standard Receipt Data

	$amountvpc       = null2unknown($map, "vpc_Amount");
	$locale          = null2unknown($map, "vpc_Locale");
	$batchNo         = null2unknown($map, "vpc_BatchNo");
	$command         = null2unknown($map, "vpc_Command");
	$version         = null2unknown($map, "vpc_Version");
	$cardType        = null2unknown($map, "vpc_Card");
	$orderInfo       = null2unknown($map, "vpc_OrderInfo");
	$receiptNovpc	 = null2unknown($map, "vpc_ReceiptNo");
	$merchantID      = null2unknown($map, "vpc_Merchant");
	$authorizeID     = null2unknown($map, "vpc_AuthorizeId");
	$transactionNo   = null2unknown($map, "vpc_TransactionNo");
	$acqResponseCode = null2unknown($map, "vpc_AcqResponseCode");
	$txnResponseCode = null2unknown($map, "vpc_TxnResponseCode");


	###############################
    if ($txnResponseCode['vpc_TxnResponseCode']=='0') {
        $varMessage	  = '';
		$varSubject   = '';
        $varPackage   = '';
		$varProductId = $varCategory;

		if ($varProductId==48) { $varDuration=3; $varPackage = 'BL'; }
		else if($varProductId==9 || $varProductId==6 || $varProductId==3) { $varDuration=9; }
		else if($varProductId==8 || $varProductId==5 || $varProductId==2) { $varDuration=6; }
		else if($varProductId==7 || $varProductId==4 || $varProductId==1) { $varDuration=3; }

		if ($varProductId==1 || $varProductId==2 || $varProductId==3) {  $varPackage = 'GL'; }
		else if ($varProductId==4 || $varProductId==5 || $varProductId==6) {  $varPackage = 'SL'; }
		else if ($varProductId==7 || $varProductId==8 || $varProductId==9) {  $varPackage = 'PL';  }

		
		$varDisplayMessage	= $objUpgradeProfile->CBS_upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS']);

		## IVR PREPAYMENT TRACKING PURPOSE ONLINETOIVRCONVERSIONPAYMENTDETAILS....
		$varFields		= array('MatriId','OrderId','Gateway','Date_Captured','Date_Paid','Charge_Source');
		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varOrderId,$objDB),"4","NOW()","NOW()","1");
		$objDB->insert($varTable['ONLINETOIVRCONVERSIONLOG'], $varFields, $argFieldsValue);

		## DELETE BEFORE VALIDATION TBALE
		$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->delete('onlinepaymentfailures', $varCondition12);

		$varCondition12		= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$objDB->delete($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varCondition12);

	} else {

		if ($txnResponseCode['vpc_TxnResponseCode']=='F') {

			## UPDATE SECURE FAILURE
			$varFields12		= array('3dSecureFailure');
			$varFieldsValue12	= array('1');
			$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
			$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);

		}## if
		    
			$varCondition12		= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
			$objDB->delete($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varCondition12);

			## IVR PAYMENT CONVERSION LOG PURPOSE ONLINETOIVRCONVERSIONLOG....
			$varFields		= array('MatriId','OrderId','Gateway','Date_Captured','Charge_Source');
			$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varOrderId,$objDB),"4","NOW()","0");
			$objDB->insert($varTable['ONLINETOIVRCONVERSIONLOG'], $varFields, $argFieldsValue);

            $varDisplayMessage	= $varFailureMsg;
	}## else

}

?>