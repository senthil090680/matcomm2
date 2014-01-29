<?php

/* -----------------------------------------------------------------------------

 Version 2.0

------------------ Disclaimer --------------------------------------------------

Copyright 2004 Dialect Holdings.  All rights reserved.

This document is provided by Dialect Holdings on the basis that you will treat
it as confidential.

No part of this document may be reproduced or copied in any form by any means
without the written permission of Dialect Holdings.  Unless otherwise expressly
agreed in writing, the information contained in this document is subject to
change without notice and Dialect Holdings assumes no responsibility for any
alteration to, or any error or other deficiency, in this document.

All intellectual property rights in the Document and in all extracts and things
derived from any part of the Document are owned by Dialect and will be assigned
to Dialect on their creation. You will protect all the intellectual property
rights relating to the Document in a manner that is equal to the protection
you provide your own intellectual property.  You will notify Dialect
immediately, and in writing where you become aware of a breach of Dialect's
intellectual property rights in relation to the Document.

The names "Dialect", "QSI Payments" and all similar words are trademarks of
Dialect Holdings and you must not use that name or any similar name.

Dialect may at its sole discretion terminate the rights granted in this
document with immediate effect by notifying you in writing and you will
thereupon return (or destroy and certify that destruction to Dialect) all
copies and extracts of the Document in its possession or control.

Dialect does not warrant the accuracy or completeness of the Document or its
content or its usefulness to you or your merchant customers.   To the extent
permitted by law, all conditions and warranties implied by law (whether as to
fitness for any particular purpose or otherwise) are excluded.  Where the
exclusion is not effective, Dialect limits its liability to $100 or the
resupply of the Document (at Dialect's option).

Data used in examples and sample data files are intended to be fictional and
any resemblance to real persons or companies is entirely coincidental.

Dialect does not indemnify you or any third party in relation to the content or
any use of the content as contemplated in these terms and conditions.

Mention of any product not owned by Dialect does not constitute an endorsement
of that product.

This document is governed by the laws of New South Wales, Australia and is
intended to be legally binding.

-------------------------------------------------------------------------------

Following is a copy of the disclaimer / license agreement provided by RSA:

Copyright (C) 1991-2, RSA Data Security, Inc. Created 1991. All rights reserved.

License to copy and use this software is granted provided that it is identified
as the "RSA Data Security, Inc. MD5 Message-Digest Algorithm" in all material
mentioning or referencing this software or this function.

License is also granted to make and use derivative works provided that such
works are identified as "derived from the RSA Data Security, Inc. MD5
Message-Digest Algorithm" in all material mentioning or referencing the
derived work.

RSA Data Security, Inc. makes no representations concerning either the
merchantability of this software or the suitability of this software for any
particular purpose. It is provided "as is" without express or implied warranty
of any kind.

These notices must be retained in any copies of any part of this documentation
and/or software.

--------------------------------------------------------------------------------

This example assumes that a form has been sent to this example with the
required fields. The example then processes the command and displays the
receipt or error to a HTML page in the users web browser.

NOTE:
=====
  You may have installed the libeay32.dll and ssleay32.dll libraries
  into your x:\WINNT\system32 directory to run this example.

--------------------------------------------------------------------------------

 @author Dialect Payment Solutions Pty Ltd Group

------------------------------------------------------------------------------*/

// *********************
// START OF MAIN PROGRAM
// *********************

// Define Constants
// ----------------
// This is secret for encoding the MD5 hash
// This secret will vary from merchant to merchant
// To not create a secure hash, let SECURE_SECRET be an empty string - ""
// $SECURE_SECRET = "secure-hash-secret";
//$SECURE_SECRET = "9FA5E196033FA2D058103229569BC4B3";

$varMerchantId		= trim($_REQUEST["vpc_Merchant"]);
$varOrderId			= trim($_REQUEST["vpc_OrderInfo"]);
$varSplitOrderId	= split("-",$varOrderId);
$varMatriIdPrefix	= substr($varSplitOrderId[0],0,3);

if ($varMerchantId=='00100182') { //INR
	$SECURE_SECRET = "68162176590E85539F66405FCC32D79F";
} else if ($varMerchantId=='00100184') { //EURO
	$SECURE_SECRET = "C93DFE8B8B53A83F035D88900E1E12DF";
} else if ($varMerchantId=='00100185') { //AED
	$SECURE_SECRET = "2F37CF65295BC5F728F81D42305A2F41";
} else if ($varMerchantId=='00100195'){ //UK
	$SECURE_SECRET = "AE263B73310D72CACFCFA6F1906071F2";
} else { //US
	$SECURE_SECRET = "01E99B05BE15BDE0753AA6E41D58E51B";
}

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

//CHECK USER LOGGED OR NOT
if($varOrderId =='') { header ("Location:".$confValues['SERVERURL']."/login/"); exit; }//if

//OBJECT DECLARATION
$objDB				= new MemcacheDB;
$objPayment			= new Payment;
$objUpgradeProfile	= new UpgradeProfile;

//CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
$varNoOfRecords = $objDB->numOfRecords($varTable['PREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

if ($varNoOfRecords==1) {


	$varFields		= array('MatriId','User_Name','Product_Id','Package_Cost','Currency','Amount_Paid','Date_Paid','Discount','DiscountFlatRate','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
	$varExecute		= $objDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
	$varPaymentInfo	= mysql_fetch_array($varExecute);

	$varTotalDays			= 0;
	$varFailureProcess		= 'no';
	$sessMatriId			= $varPaymentInfo['MatriId'];
	$varUserName			= $varPaymentInfo['User_Name'];
	$varCategory			= $varPaymentInfo['Product_Id'];
	$varAmount				= $varPaymentInfo['Amount_Paid'];
	$varCurrency			= $varPaymentInfo['Currency'];
	$varPackageCost			= $varPaymentInfo['Package_Cost'];
	$varDiscountPercentage	= $varPaymentInfo['Discount'];
	$varDiscountFlatRate	= $varPaymentInfo['DiscountFlatRate'];
	$varDisplayCurrency	    = $varPaymentInfo['Display_Currency'];
	$varDisplayAmountPaid	= $varPaymentInfo['Display_Amount_Paid'];
	$varDisplayPackageCost	= $varPaymentInfo['Display_Package_Cost'];
	$varValidDays			= $arrPkgValidDays[$varCategory];
	$varTotalDays			= $arrPkgValidDays[$varCategory];


// If there has been a merchant secret set then sort and loop through all the
// data in the Virtual Payment Client response. While we have the data, we can
// append all the fields that contain values (except the secure hash) so that
// we can create a hash and validate it against the secure hash in the Virtual
// Payment Client response.

// NOTE: If the vpc_TxnResponseCode in not a single character then
// there was a Virtual Payment Client error and we cannot accurately validate
// the incoming data from the secure hash. */

// get and remove the vpc_TxnResponseCode code from the response fields as we
// do not want to include this field in the hash calculation
$vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
unset($_GET["vpc_SecureHash"]);

// set a flag to indicate if hash has been validated
$errorExists = false;

if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {

    $md5HashData = $SECURE_SECRET;

    // sort all the incoming vpc response fields and leave out any with no value
    foreach($_GET as $key => $value) {
        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
            $md5HashData .= $value;
        }
    }

    // Validate the Secure Hash (remember MD5 hashes are not case sensitive)
	// This is just one way of displaying the result of checking the hash.
	// In production, you would work out your own way of presenting the result.
	// The hash check is all about detecting if the data has changed in transit.
    if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(md5($md5HashData))) {
        // Secure Hash validation succeeded, add a data field to be displayed
        // later.
        $hashValidated = "<FONT color='#00AA00'><strong>CORRECT</strong></FONT>";
    } else {
        // Secure Hash validation failed, add a data field to be displayed
        // later.
        $hashValidated = "<FONT color='#FF0066'><strong>INVALID HASH</strong></FONT>";
        $errorExists = true;
    }
} else {
    // Secure Hash was not validated, add a data field to be displayed later.
    $hashValidated = "<FONT color='orange'><strong>Not Calculated - No 'SECURE_SECRET' present.</strong></FONT>";
}

// Define Variables
// ----------------
// Extract the available receipt fields from the VPC Response
// If not present then let the value be equal to 'No Value Returned'

// Standard Receipt Data
$amount          = null2unknown($_GET["vpc_Amount"]);
$locale          = null2unknown($_GET["vpc_Locale"]);
$batchNo         = null2unknown($_GET["vpc_BatchNo"]);
$command         = null2unknown($_GET["vpc_Command"]);
$message         = null2unknown($_GET["vpc_Message"]);
$version         = null2unknown($_GET["vpc_Version"]);
$cardType        = null2unknown($_GET["vpc_Card"]);
$orderInfo       = null2unknown($_GET["vpc_OrderInfo"]);
$receiptNo       = null2unknown($_GET["vpc_ReceiptNo"]);
$merchantID      = null2unknown($_GET["vpc_Merchant"]);
$authorizeID     = null2unknown($_GET["vpc_AuthorizeId"]);
$merchTxnRef     = null2unknown($_GET["vpc_MerchTxnRef"]);
$transactionNo   = null2unknown($_GET["vpc_TransactionNo"]);
$acqResponseCode = null2unknown($_GET["vpc_AcqResponseCode"]);
$txnResponseCode = null2unknown($_GET["vpc_TxnResponseCode"]);

// 3-D Secure Data
$verType         = array_key_exists("vpc_VerType", $_GET)          ? $_GET["vpc_VerType"]          : "No Value Returned";
$verStatus       = array_key_exists("vpc_VerStatus", $_GET)        ? $_GET["vpc_VerStatus"]        : "No Value Returned";
$token           = array_key_exists("vpc_VerToken", $_GET)         ? $_GET["vpc_VerToken"]         : "No Value Returned";
$verSecurLevel   = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
$enrolled        = array_key_exists("vpc_3DSenrolled", $_GET)      ? $_GET["vpc_3DSenrolled"]      : "No Value Returned";
$xid             = array_key_exists("vpc_3DSXID", $_GET)           ? $_GET["vpc_3DSXID"]           : "No Value Returned";
$acqECI          = array_key_exists("vpc_3DSECI", $_GET)           ? $_GET["vpc_3DSECI"]           : "No Value Returned";
$authStatus      = array_key_exists("vpc_3DSstatus", $_GET)        ? $_GET["vpc_3DSstatus"]        : "No Value Returned";

// *******************
// END OF MAIN PROGRAM
// *******************

// FINISH TRANSACTION - Process the VPC Response Data
// =====================================================
// For the purposes of demonstration, we simply display the Result fields on a
// web page.

// Show 'Error' in title if an error condition
$errorTxt = "";

// Show this page as an error page if vpc_TxnResponseCode equals '7'
############################### Commanded by Dhanapal...
/*if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
    $errorTxt = "Error ";
	$varDisplayMessage	= $varFailureMsg;
}*/
###############################
//$txnResponseCode='0';
//$errorExists=false;
if ($txnResponseCode=='0' && $errorExists==false) {

	//SELECT Card Number...
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

		//INSERT maxmindpaymentcapture TABLE
		$varFields				= array('VPC_TransactionNo','Risk_Score');
		$varFieldsValues		= array("'".$_REQUEST["vpc_TransactionNo"]."'","'".$varRiskScore."'");
		$varOrderIdCondition	= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$objDB->update('maxmindpaymentcapture', $varFields, $varFieldsValues, $varOrderIdCondition);

		$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Your payment status is currently under validation. Kindly await e-mail confirmation from us to start contacting prospects.</td></tr></table>";

	} else {

		$varDisplayMessage	= $objUpgradeProfile->CBS_upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$varTable['PREPAYMENTHISTORYINFO']);

	}//upgradeProfile


	//DELETE BEFORE VALIDATION TBALE
	$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$objDB->delete('onlinepaymentfailures', $varCondition12);

	$varCondition12		= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$objDB->delete($varTable['ONLINETOIVRCONVERSIONPAYMENTDETAILS'], $varCondition12);

} else {

		//UPDATE SECURE FAILURE
		$varFields12		= array('3dSecureFailure');
		$varFieldsValue12	= array('1');
		$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);

		$varCondition123= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$varFields		= array('Gateway_Status','Reason_Of_Failure');
		$varFieldsValue	= array($objDB->doEscapeString($_REQUEST["vpc_TxnResponseCode"],$objDB),$objDB->doEscapeString($_REQUEST["vpc_Message"],$objDB));
		$objDB->update($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varFieldsValue, $varCondition123);
        
		if($varCurrency!='Rs'){
		## OPTIMAL GATEWAY REDIRECT START##
       	$varCondition   = "WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$varFields		= array('AES_DECRYPT(Card_Number,"password") As Card_Number','Expiry_Month','Expiry_Year','Card_Type');
	    $varExecute		       = $objDB->select('onlinepaymentdetails', $varFields, $varCondition, 0);
		$varOnlinePaymentInfo  = mysql_fetch_array($varExecute);
		$varCardType		   = $varOnlinePaymentInfo['Card_Type'];

		if($varCardType=='Visa'){
			$varCardType='VI';
		}else{
			$varCardType='MC';
		}

		$varFields		       = array('Billing_City','Billing_Region','Billing_Country','IP_ISP','IP_Address');
	    $varExecute		       = $objDB->select('maxmindpaymentcapture', $varFields, $varCondition, 0);
	    $varMaxMindInfo        = mysql_fetch_array($varExecute);

		##Basic Payments Tables Insert start here##
        
		if(($varCurrency=='EUR') || ($varCurrency=='EURO')){ 

			$varConvertedAmount = $varAmount * $arrCurrToUsd[21];// EURO - EUR [ EUROPE COUNTRIES 21 ]
			$varConvertedAmount = round($varConvertedAmount);
			$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[21]);
			$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[21]);

		}elseif($varCurrency=='AED'){
				$varConvertedAmount = $varAmount * $arrCurrToUsd[220];// UAE - AED [ UNITED ARAB EMIRATES 220 ]
				$varConvertedAmount = round($varConvertedAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[220]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[220]);
		}elseif($varCurrency=='GBP'){
				$varConvertedAmount = $varAmount * $arrCurrToUsd[221];// UK - GBP [ UNITED KINGDOM 221 ]
				$varConvertedAmount = round($varConvertedAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[221]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[221]);
		}elseif($varCurrency=='PKR'){
				$varConvertedAmount = $varAmount * $arrCurrToUsd[162];// PK - PKR [ PAKISTAN 162 ]
				$varConvertedAmount = round($varConvertedAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[162]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[162]);
		} else {
			$varConvertedAmount = round($varAmount); 
			$varConvertedPackageAmount = $varPackageCost; 
		}

		## ASSIGN DEFAULT CURRENCY AS USD.
		$varCurrency = "USD"; 

		##PREPAYMENT TRACKING PURPOSE....
		$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Package_Cost','Amount_Paid','Discount','DiscountFlatRate','Currency','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
		$argFieldsValue	= array($objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varUserName,$objDB),$objDB->doEscapeString($varCategory,$objDB),$objDB->doEscapeString($varConvertedPackageAmount,$objDB),$objDB->doEscapeString($varConvertedAmount,$objDB),$objDB->doEscapeString($varDiscountPercentage,$objDB),$objDB->doEscapeString($varDiscountFlatRate,$objDB),"'USD'",'\'5\'','NOW()',$objDB->doEscapeString($varDisplayCurrency,$objDB),$objDB->doEscapeString($varDisplayAmountPaid,$objDB),$objDB->doEscapeString($varDisplayPackageCost,$objDB));
		$objDB->insert($varTable['PREOPTIMALPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

		##Update maxmindpaymentcapture TABLE
		$varFields				= array('Currency','Amount_Paid');
		$varFieldsValues		= array("'USD'",$objDB->doEscapeString($varConvertedAmount,$objDB));
		$varOrderIdCondition	= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$objDB->update('maxmindpaymentcapture', $varFields, $varFieldsValues, $varOrderIdCondition);

		## UPDATE onlinepaymentdetails 
		$varFields12		= array("OrderId","Payment_Gateway","Currency","Amount_Paid");
		$varFieldsValue12	= array($objDB->doEscapeString($varOrderId,$objDB),"5","'USD'",$objDB->doEscapeString($varConvertedAmount,$objDB));
		$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$objDB->update('onlinepaymentdetails', $varFields12, $varFieldsValue12, $varCondition12);

        ##Basic Payments Tables Insert Ends here##

		$varOnLoad             = 'onLoad="javascript:document.frmRedirectionOptimal.submit();"';
		?>

		<form name="frmRedirectionOptimal" action="<?=$varOptimalProcess;?>" method="post" style="margin:0px;">
        <input type="hidden" name="cardHolderName" value=""/>
		<input type="hidden" name="vpc_card" value="<?=$varCardType;?>"/>
		<input type="hidden" name="vpc_CardNum" value="<?=$varOnlinePaymentInfo['Card_Number'];?>"/>
		<input type="hidden" name="vpc_CardExp" value="<?=$varOnlinePaymentInfo['Expiry_Year'].$varOnlinePaymentInfo['Expiry_Month'];?>"/>
		<input type="hidden" name="vpc_CardSecurityCode" value=""/>
		<input type="hidden" name="city" value="<?=$varMaxMindInfo['Billing_City'];?>"/>
		<input type="hidden" name="USState" value="<?=$varMaxMindInfo['Billing_Region'];?>"/>
		<input type="hidden" name="otherstate" value="<?=$varMaxMindInfo['Billing_Region'];?>"/>
		<input type="hidden" name="zipCode" value="<?=$varMaxMindInfo['IP_ISP'];?>"/>
		<input type="hidden" name="country" value="<?=$varMaxMindInfo['Billing_Country'];?>"/>
		
		<?	
			// Add all the fields from the input form, except for the Submit Button and the VPCURL.
			//For Each item In Request.Form
			
			foreach($_GET as $key => $value) {
				if (strlen($value) > 0) {?>
				<input type="hidden" name="<?=$key?>" value="<?=str_replace(" ","",trim($value))?>"/>
		<? }}
		?></form>
        <?
		}else{

            //IVR REDIRECT   
			include_once($varRootBasePath."/www/payment/onflyivr_icicipaymentprocess.php");
			
		}
        ## OPTIMAL GATEWAY REDIRECT END##
}


// This is the display title for 'Receipt' page
$title = $_GET["Title"];

// The URL link for the receipt to do another transaction.
// Note: This is ONLY used for this example and is not required for
// production code. You would hard code your own URL into your application
// to allow customers to try another transaction.
//TK//$againLink = URLDecode($_GET["AgainLink"]);

// End Processing

// This method uses the QSI Response code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code
//
// @param $responseCode String containing the QSI Response Code
//
// @return String containing the appropriate description
//
} else { $varDisplayMessage	= ' Could not find the OrderId '; }

function getResponseDescription($responseCode) {

    switch ($responseCode) {
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

//  -----------------------------------------------------------------------------

// This method uses the verRes status code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code

// @param statusResponse String containing the 3DS Authentication Status Code
// @return String containing the appropriate description

function getStatusDescription($statusResponse) {
    if ($statusResponse == "" || $statusResponse == "No Value Returned") {
        $result = "3DS not supported or there was no 3DS data provided";
    } else {
        switch ($statusResponse) {
            Case "Y"  : $result = "The cardholder was successfully authenticated."; break;
            Case "E"  : $result = "The cardholder is not enrolled."; break;
            Case "N"  : $result = "The cardholder was not verified."; break;
            Case "U"  : $result = "The cardholder's Issuer was unable to authenticate due to some system error at the Issuer."; break;
            Case "F"  : $result = "There was an error in the format of the request from the merchant."; break;
            Case "A"  : $result = "Authentication of your Merchant ID and Password to the ACS Directory Failed."; break;
            Case "D"  : $result = "Error communicating with the Directory Server."; break;
            Case "C"  : $result = "The card type is not supported for authentication."; break;
            Case "S"  : $result = "The signature on the response received from the Issuer could not be validated."; break;
            Case "P"  : $result = "Error parsing input from Issuer."; break;
            Case "I"  : $result = "Internal Payment Server system error."; break;
            default   : $result = "Unable to be determined"; break;
        }
    }
    return $result;
}

//  -----------------------------------------------------------------------------

// If input is null, returns string "No Value Returned", else returns input
function null2unknown($data) {
    if ($data == "") {
        return "No Value Returned";
    } else {
        return $data;
    }
}

include_once($varRootBasePath.'/www/template/paymentheader.php');
if (($txnResponseCode=='0' && $errorExists==false)  || ($varCurrency=='Rs')) {
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
include_once($varRootBasePath.'/www/template/paymentfooter.php');
UNSET($objDB);
}else{?>
<div style="text-align:center;"><img src="<?=$confValues['IMGSURL'];?>/loading-icon.gif" height="38" width="45"></div>
<?
}
?>