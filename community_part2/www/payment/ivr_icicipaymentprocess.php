<?php

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

$varMerchantId			= '00100200';
$varOrderId				= trim($_REQUEST["ORDERID"]);
$varSecureSecret		= '96509D7BA51421043406C3DC8D3959B4';
$varAccessCode			= 'E8738983';
$varCreditcardNumber	= trim($_REQUEST["CREDITCARDNUMBER"]);
$varExpMonth			= trim($_REQUEST["EXPMON"]);
$varExpYear				= trim($_REQUEST["EXPYEAR"]);
$varCVV					= trim($_REQUEST["CVV"]);
$varCardFirstDigit		= substr($varCreditcardNumber,0,1);

//OBJECT DECLARATION
$objDB		= new MemcacheDB;
$objPayment = new Payment;
$objUpgradeProfile	= new UpgradeProfile;

//CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

$varCondition	= " WHERE OrderId ='".$varOrderId."'";
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

	$varFields		= array('MatriId','User_Name','Product_Id','Package_Cost','Currency','Amount_Paid','Date_Paid');
	$varExecute		= $objDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
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

	$virtualPaymentClientURL	="https://migs.mastercard.com.au/vpcdps";
	$gatetitle					= "PHP VPC 2-Party with CSC";
	$vpc_Amount					= round($varAmount*100);
	$iciciorderid				= $sessMatriId."-".$varOrderId."-".date("YmdHis");
	$vpc_MerchTxnRef			= $iciciorderid;
	$vpc_OrderInfo				= $iciciorderid;

	if ($varCategory==0){
		$varXML	= "<STATUS>FAILED</STATUS>";
		displayMessage($varXML);
		exit;
	}

//$ivrsdate_time=date("YmdHis");
//$orderno=$sessMatriId."-".$ivrsdate_time;

// CREATE A VARIABLE TO HOLD THE POST DATA INFORMATION AND CAPTURE IT
	$postData = "";
	$ampersand = "";
	$postData = "vpc_Version=1&vpc_Command=pay&vpc_AccessCode=".$varAccessCode."&vpc_MerchTxnRef=".$vpc_MerchTxnRef."&vpc_Merchant=".$varMerchantId."&vpc_OrderInfo=".$vpc_OrderInfo."&vpc_Amount=".$vpc_Amount."&vpc_CardNum=".$varCreditcardNumber."&vpc_CardExp=".$varExpYear.$varExpMonth."&vpc_CardSecurityCode=".$varCVV."&vpc_TxSource=MOTO";
	$ampersand = "&";


	// Get a HTTPS connection to VPC Gateway and do transaction
	// turn on output buffering to stop response going to browser
	ob_start();

	// initialise Client URL object
	$ch = curl_init();

	// set the URL of the VPC
	curl_setopt ($ch, CURLOPT_URL, $virtualPaymentClientURL);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);

	// connect
	curl_exec ($ch);

	// get response
	$response = ob_get_contents();
	

	// turn output buffering off.
	ob_end_clean();

	// set up message paramter for error outputs
	$message = "";

	// serach if $response contains html error code
	if(strchr($response,"<html>") || strchr($response,"<html>")) {;
		$message = $response;
	} else {
		// check for errors from curl
		if (curl_error($ch))
			$message = "%s: s". curl_errno($ch) . "<br/>" . curl_error($ch);
		}

	// close client URL
	curl_close ($ch);


	// Extract the available receipt fields from the VPC Response
	// If not present then let the value be equal to 'No Value Returned'
	$map = array();

	// process response if no errors
	if (strlen($message) == 0) {
		$pairArray = split("&", $response);
		foreach ($pairArray as $pair) {
			$param = split("=", $pair);
			$map[urldecode($param[0])] = urldecode($param[1]);
		}
		$message = null2unknown($map, "vpc_Message");
	} 


// Define Variables
// ----------------
// Extract the available receipt fields from the VPC Response
// If not present then let the value be equal to 'No Value Returned'

// Standard Receipt Data
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

/*
	if ($txnResponseCode=='0') {
		$dispmsg	= upgradeprofile();
	} else {
		$errcode	= getResponseDescription($txnResponseCode);
		$varXML		= "<STATUS>FAILED</STATUS>";
		displayMessage($varXML);

		## Send mail to support team with details
		$message="Matrimony ID : $sessMatriId\n";
		$message.="Charge Total  : $varAmount\n";
		$message.="Membership : $maillabel\n";
		$message.="Card Number   : $cardnumber\n";
		$message.="Card Exp. Date : $expmon - $expyear\n";
		$message.="Card CVV No. : $cvv\n";
		$mailprog="/usr/sbin/sendmail";
		$subj="Credit Card Transaction - $sessMatriId - INR payment";
		$frommail="webmaster\@bharatmatrimony.com";

		$headers = "MIME-Version: 1.0\n";	
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: frommail\n";
		$ademail=CREDITCARDADMINEMAIL;
		mail($ademail,$subj,$message,$headers); 
	}
*/

	###############################

	if ($txnResponseCode=='0') {


		$varPackage = '';
		if ($varProductId==48) { $varDuration=3; $varPackage = 'BL'; }
		else if($varProductId==9 || $varProductId==6 || $varProductId==3) { $varDuration=9; }
		else if($varProductId==8 || $varProductId==5 || $varProductId==2) { $varDuration=6; }
		else if($varProductId==7 || $varProductId==4 || $varProductId==1) { $varDuration=3; }

		if ($varProductId==1 || $varProductId==2 || $varProductId==3) {  $varPackage = 'GL'; }
		else if ($varProductId==4 || $varProductId==5 || $varProductId==6) {  $varPackage = 'SL'; }
		else if ($varProductId==7 || $varProductId==8 || $varProductId==9) {  $varPackage = 'PL';  }

		$varXML = "<STATUS>SUCCESS</STATUS>";
		$varXML .= "<PACKAGE>".$varPackage."</PACKAGE>";
		$varXML .=  "<DURATION>".$varDuration."</DURATION>";
		$varXML .= "<PAYMENTTYPE>CL</PAYMENTTYPE>";
		$varXML .=  "<CURRENCY>INR</CURRENCY>";
		$varXML .=  "<PRICE>".$varAmount."</PRICE>";
		displayMessage($varXML);

		//$varDisplayMessage	= upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment);

		$varDisplayMessage	= $objUpgradeProfile->CBS_upgradeProfile($sessMatriId,$varOrderId,$varCategory,$varAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment,$varIPLocation,$varTable['PREPAYMENTHISTORYINFO']);

		//DELETE BEFORE VALIDATION TBALE
		$varCondition12		= " MatriId ='".$sessMatriId."'";
		$objDB->delete('onlinepaymentfailures', $varCondition12);

	} else {

		//$errcode	= getResponseDescription($txnResponseCode);
		$varXML		= "<STATUS>FAILED</STATUS>";
		displayMessage($varXML);
		if ($txnResponseCode=='F') {

			//UPDATE SECURE FAILURE
			$varFields12		= array('3dSecureFailure');
			$varFieldsValue12	= array('1');
			$varCondition12		= " MatriId ='".$sessMatriId."'";
			$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);

		}//if

	}//else

}

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
function null2unknown($map, $key) {
    if (array_key_exists($key, $map)) {
        if (!is_null($map[$key])) {
            return $map[$key];
        }
    } 
    return "No Value Returned";
}
/*function null2unknown($data) {
    if ($data == "") {
        return "No Value Returned";
    } else {
        return $data;
    }
}*/



function upgradeProfile($argMatriId,$argOrderId,$argCategory,$argAmount,$objDB,$varTotalDays,$varMessage,$varSubject,$varCurrency,$objPayment) {
		global $arrPhonePackage,$varTable,$arrPrdPackages,$varDomainName;
		$sessMatriId	= $argMatriId;
		$varOrderId		= $argOrderId;
		$varCategory	= $argCategory;
		$varAmount		= $argAmount;
		$varProcess		= 'yes';

		//SETING MEMCACHE KEY
		$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

		//CHECK OFFER
		include_once($varRootBasePath."/www/payment/offerinfo.php");

		if(($varPaidDays < 10) && (strlen($varPaidDays) > 0) && $varDatePaid !='0000-00-00 00:00:00') {
		$varProcess = 'no';
		$varDisplayMessage	= "You have made a payment recently on ".$varDatePaid;
		}//if

		if ($varProcess == 'yes') {
		//CHECK DUPLICATE ORDER ID.
		$varCondition	= " WHERE OrderId ='".$varOrderId."'";
		$varNoOfRecords = $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
		$varDisplayMessage		= "Duplicate Order Id <b>".$varOrderId.'</b>';
		if ($varNoOfRecords==1) { $varProcess		= 'no'; }
		}


	if ($varNoOfRecords == 0 && $varProcess == 'yes') {

	if ($varCategory !='100') {

	//CALCULATE CURRENT TOTAL VALID DAYS
	$varFields		= array('Valid_Days','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as CurrentValidDays');
	$varCondition	= " WHERE MatriId ='".$sessMatriId."'";
	$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varDaysInfo	= mysql_fetch_array($varValidInfo);
	$varCurrentValidDays	= $varDaysInfo['CurrentValidDays'];
	if (($varCurrentValidDays >0) && ($varCurrentValidDays !="")) { $varTotalDays = ($varCurrentValidDays + $varTotalDays); }//if

	$varIPLocation = getIptoLocation();
	$varUSPaidFlag = '0';
	if ($varIPLocation!='IN' && $varNumberOfPayments=='0' && $varDatePaid=='0000-00-00 00:00:00'){
		$varUSPaidFlag = '1';
	}


	//UPDATE VALID DAYS
	$varCondition	= " MatriId ='".$sessMatriId."'";
	$varFields		= array('Last_Payment','Valid_Days','Paid_Status','Phone_Verified','Publish','Number_Of_Payments','Expiry_Date','Date_Updated','Special_Priv','US_Paid_Validated');
	$varFieldsValue	= array('NOW()',$varTotalDays,'1','1','1','Number_Of_Payments+1','DATE_ADD(NOW(),INTERVAL '.$varTotalDays.' DAY)','NOW()',$varSpecialPrev,$varUSPaidFlag);
	$objDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition, $varOwnProfileMCKey);

	}

	//INSERT PAYMENT TABLE
	$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Offer_Product_Id','Amount_Paid','DiscountFlatRate','Package_Cost','Currency','Payment_Type','Payment_Mode','Date_Paid');
	$argFieldsValue	= array("'".$varOrderId."'","'".$sessMatriId."'","'".$varUserName."'","'".$varCategory."'","'".$varOfferProductId."'","'".$varAmount."'","'".($varPackageCost-$varAmount)."'","'".$varPackageCost."'","'".$varCurrency."'",'50','1','NOW()');
	$objDB->insert($varTable['PAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

	//INSERT paymentauthorization TABLE
	$varFields			= array('Gateway','OrderNumber','MatriId','User_Name','Product_Id','Amount_Paid','Date_Paid');
	$varFieldsValue	= array('1',"'".$varOrderId."'","'".$sessMatriId."'","'".$varUserName."'","'".$varCategory."'","'".$varAmount."'",'NOW()');
	$objDB->insert($varTable['PAYMENTAUTHORIZATION'], $varFields, $varFieldsValue);

	//INSERT PHONE NUMBER
	$varFields			= array('MatriId','TotalPhoneNos','NumbersLeft');
	$varFieldsValues	= array("'".$sessMatriId."'","TotalPhoneNos+".($arrPhonePackage[$varDisPlayId]+$varExtraPhone),"NumbersLeft+".($arrPhonePackage[$varDisPlayId]+$varExtraPhone));
	$objDB->insertOnDuplicate($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId');

	if ($varCategory !='100') {

	$varFields		= array('Email');
	$varCondition	= " WHERE MatriId ='".$sessMatriId."'";
	$varExecute		= $objDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
	$varEmailInfo	= mysql_fetch_array($varExecute);
	$varEmail	= $varEmailInfo['Email'];


	//CHECK LAST PAYMENT TIME
	$varFields		= array('Last_Payment','Name','Nick_Name','Expiry_Date');
	$varCondition	= " WHERE MatriId ='".$sessMatriId."'";
	$varSelect		= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varMemberInfo	= mysql_fetch_array($varSelect);
	$varLastPayment	= $varMemberInfo['Last_Payment'];
	$varName		= $varMemberInfo['Name'];
	$varNickName	= $varMemberInfo['Nick_Name'];
	$varName		= $varNickName ? $varNickName : $varName;
	$varSplitExpiry	= split(" ",trim($varMemberInfo['Expiry_Date']));

	$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varDisPlayId]."<br><br><b>Validity period :</b> ".$varTotalDays." days<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr></table>";

	/* Added by Ashok - To show offer links to avail only for India & Not for Christian till 9th Apr*/
	/*if ($varDomainName!='christianmatrimony') {
		//$varIPLocation = getIptoLocation();
		if ($varIPLocation=='IN') {
		$varDisplayMessage    .= "<br><a target='_blank' class='clr1' href='http://www.matrimonyday.org/homeindex.php?id=".$sessMatriId."'>Click here</a> to add your views on Matrimony Day and win a Titan Watch or an Estelle Necklace Set.";
		$varDisplayMessage    .= "<br><br>We also have tons of offers and discounts from leading brands exclusively for you.<br><a class='clr1' target='_blank' href='http://www.".$varDomainName.".com/site/index.php?act=matrimonyday-offers'>Click here to avail them.</a>";
		}
	}*/
	/* Added by Ashok - To show offer links to avail only for India */

	//SEND MAIL
	//sendEmail($varFrom,$varFromEmailAddress,$varEmail,$varMessage,$varSubject);

		$varPaymentMode		= 0;
		$varPaymentType		= 1;
		$varAmountWithCurr	= $varCurrency.' '.$varAmount;
		$varExpiryDate		= 'From '.date('Y-m-d').' To '.$varSplitExpiry[0];
		$varTotalPhone		= ($arrPhonePackage[$varDisPlayId]+$varExtraPhone);
		$objPayment->paymentConfirmation($sessMatriId,$varName,$varEmail,$varCategory,$varAmountWithCurr,$varPaymentMode,$varPaymentType,$varExpiryDate,$varIPLocation,$varOfferProductId,$varTotalPhone);
	}

	if ($varCategory =='100') {

		$varDisplayMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Phone Count :</b> ".$arrPhonePackage[$varCategory]."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr></table>";
	}

		//PRIVILEGE MAIL
		if ($varCategory=='48'){

		//INSERT RMMEMBERINFO TABLE
		$varPrivilege1			= array('MatriId','MemberName','ProductId','ValidDays','ExpiryDate','PrivStatus','PaidStatus','TimeCreated');
		$varPrivilegeValues1	= array("'".$sessMatriId."'","'".$varName."'","'".$varCategory."'","'".$varTotalDays."'",'DATE_ADD(NOW(),INTERVAL '.$varTotalDays.' DAY)','2','1','NOW()');
		$objDB->insertOnDuplicate('cbsrminterface.rmmemberinfo', $varPrivilege1, $varPrivilegeValues1, 'MatriId');

		$objPayment->privilegeMail($sessMatriId,$varName,$varEmail,date('Y-m-d'));

		}//if

		}

		return $varDisplayMessage;

	}//upgradeProfile

?>