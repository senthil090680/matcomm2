<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-12-10
# End Date		: 2010-12-10
# Project		: MatrimonyProduct
# Module		: Optimal Payment Gatway
#=============================================================================================================

## Merchant Account Information 
$varAccountNum = '99942638';
$varStoreID    = 'ded9199fa-7be0-USD';
$varStorePwd   = 'rabclWsz';

$POSTURL= "https://webservices.optimalpayments.com/creditcardWS/CreditCardServlet/v1";

function generateXML(XMLWriter $xml, $data){
    foreach($data as $key => $value){
        if(is_array($value)){
            $xml->startElement($key);
            generateXML($xml, $value);
            $xml->endElement();
            continue;
        }
        $xml->writeElement($key, $value);
    }
}

function curlfunctioncall($POSTVARS)
{
	global $POSTURL;
	$ch="";
	$ch = curl_init($POSTURL);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTVARS);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
	curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
	return curl_exec($ch);
}

//Purchase function Starts
function OptimalPurchase($varOptimalParms)
{
	global $varAccountNum,$varStoreID,$varStorePwd,$POSTURL;

	$xml = new XmlWriter();
	$xml->openMemory();

	$varOptMerchantRefNum		= $varOptimalParms['transactionorderid'];
	$varOptAmount				= $varOptimalParms['Opt_Amount'];
	$varOptCardType				= $varOptimalParms['Opt_CardType'];
	$varOptCardNum				= $varOptimalParms['Opt_CardNum'];
	$varOptMonth				= $varOptimalParms['cardExpiryMonth'];
	$varOptYear					= $varOptimalParms['cardExpiryYear'];
	$varOptCardSecurityCode		= $varOptimalParms['Opt_CardSecurityCode'];
	$varOptAdditionalData		= $varOptimalParms['OptAdditionalData'];
	
	if($varOptMerchantRefNum!="" && $varOptAmount!="" && $varOptCardNum!="" && $varOptMonth!="" && $varOptYear!="" && $varOptAdditionalData!=""){

		$varPurchaseArgs=array();
		$accountNumArr["accountNum"]		= $varAccountNum;
		$storeIDArr["storeID"]				= $varStoreID;
		$storePwdArr["storePwd"]			= $varStorePwd;
		$varPurchaseArgs["merchantAccount"] = $accountNumArr+$storeIDArr+$storePwdArr;
		$varPurchaseArgs["merchantRefNum"]  = $varOptMerchantRefNum;
		$varPurchaseArgs["amount"]			= number_format($varOptAmount, 2, '.', '');
		$cardNum["cardNum"]					= $varOptCardNum;
		$cardExpiry["month"]				= $varOptMonth;
		$cardExpiry["year"]					= $varOptYear;
		$cardExpiryval['cardExpiry']		= $cardExpiry;
		$cardType["cardType"]				= $varOptCardType;
		$varUserCardType					= 1;

		if($varOptCardSecurityCode){
			$cvdIndicator["cvdIndicator"]		= 1; //Optional
			$cvd["cvd"]							= $varOptCardSecurityCode; 
			//Conditional - if cvdIndicator=1 then conditional else optinal

			if($varUserCardType)
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval+$cardType+$cvdIndicator+$cvd;
			else
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval+$cvdIndicator+$cvd;
		}else{
			if($varUserCardType)
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval+$cardType;
			else
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval;
		}

		if($authenticationAvail){
			$indicator["indicator"]				= $OptIndicator;
			$cavv["cavv"]						= $OptCavv;
			$xid["xid"]							= $OptXid;
			$varPurchaseArgs["authentication"]	= $indicator+$cavv+$xid; // all are optional
		}

		$cardPayMethod["cardPayMethod"]			= "WEB"; 
		$zip["zip"]						        = "NA";
		$varPurchaseArgs["billingDetails"]		= $cardPayMethod+$zip;

		//all the below are optional
		if($varOptAdditionalData){
			$addendumData1["tag"]				= "MERCHANTPARAMS";
			$addendumData1["value"]				= $varOptAdditionalData;
			$temp1["addendumData"]				= $addendumData1;
			$varPurchaseArgs[]					= $temp1;
		}
        
		generateXML($xml, $varPurchaseArgs);
		$xml->endElement();
		$txnRequest = '<ccAuthRequestV1 xmlns="http://www.optimalpayments.com/creditcard/xmlschema/v1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.optimalpayments.com/creditcard/xmlschema/v1">'.$xml->outputMemory(true).'</ccAuthRequestV1>';

		$POSTVARS = "txnMode=ccPurchase&txnRequest=".$txnRequest;
		$result=curlfunctioncall($POSTVARS);
	}else{
		$result = "Failure";
	}

	return $result;
}
//Purchase function Ends

//Purchase function Starts
function OptimalPurchaseAutoRenewal($varOptimalParms)
{
	global $varAccountNum,$varStoreID,$varStorePwd,$POSTURL;

	$xml = new XmlWriter();
	$xml->openMemory();

	$varOptMerchantRefNum		= $varOptimalParms['transactionorderid'];
	$varOptAmount				= $varOptimalParms['Opt_Amount'];
	$varOptCardType				= $varOptimalParms['Opt_CardType'];
	$varOptCardNum				= $varOptimalParms['Opt_CardNum'];
	$varOptMonth				= $varOptimalParms['cardExpiryMonth'];
	$varOptYear					= $varOptimalParms['cardExpiryYear'];
	$varOptCardSecurityCode		= $varOptimalParms['Opt_CardSecurityCode'];
	$varOptAdditionalData		= $varOptimalParms['OptAdditionalData'];
	
	if($varOptMerchantRefNum!="" && $varOptAmount!="" && $varOptCardNum!="" && $varOptMonth!="" && $varOptYear!="" && $varOptAdditionalData!=""){

		$varPurchaseArgs=array();
		$accountNumArr["accountNum"]		= $varAccountNum;
		$storeIDArr["storeID"]				= $varStoreID;
		$storePwdArr["storePwd"]			= $varStorePwd;
		$varPurchaseArgs["merchantAccount"] = $accountNumArr+$storeIDArr+$storePwdArr;
		$varPurchaseArgs["merchantRefNum"]  = $varOptMerchantRefNum;
		$varPurchaseArgs["amount"]			= number_format($varOptAmount, 2, '.', '');
		$cardNum["cardNum"]					= $varOptCardNum;
		$cardExpiry["month"]				= $varOptMonth;
		$cardExpiry["year"]					= $varOptYear;
		$cardExpiryval['cardExpiry']		= $cardExpiry;
		$cardType["cardType"]				= $varOptCardType;
		$varUserCardType					= '';

		if($varOptCardSecurityCode){
			$cvdIndicator["cvdIndicator"]		= 1; //Optional
			$cvd["cvd"]							= $varOptCardSecurityCode; 
			//Conditional - if cvdIndicator=1 then conditional else optinal

			if($varUserCardType)
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval+$cardType+$cvdIndicator+$cvd;
			else
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval+$cvdIndicator+$cvd;
		}else{
			if($varUserCardType)
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval+$cardType;
			else
				$varPurchaseArgs["card"]		= $cardNum+$cardExpiryval;
		}

		if($authenticationAvail){
			$indicator["indicator"]				= $OptIndicator;
			$cavv["cavv"]						= $OptCavv;
			$xid["xid"]							= $OptXid;
			$varPurchaseArgs["authentication"]	= $indicator+$cavv+$xid; // all are optional
		}

		$cardPayMethod["cardPayMethod"]			= "WEB"; 
		$zip["zip"]						        = "NA";
		$varPurchaseArgs["billingDetails"]		= $cardPayMethod+$zip;

		//all the below are optional
		if($varOptAdditionalData){
			$addendumData1["tag"]				= "MERCHANTPARAMS";
			$addendumData1["value"]				= $varOptAdditionalData;
			$temp1["addendumData"]				= $addendumData1;
			$varPurchaseArgs[]					= $temp1;
		}
        
		generateXML($xml, $varPurchaseArgs);
		$xml->endElement();
		$txnRequest = '<ccAuthRequestV1 xmlns="http://www.optimalpayments.com/creditcard/xmlschema/v1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.optimalpayments.com/creditcard/xmlschema/v1">'.$xml->outputMemory(true).'</ccAuthRequestV1>';

		$POSTVARS = "txnMode=ccPurchase&txnRequest=".$txnRequest;
		$result=curlfunctioncall($POSTVARS);
	}else{
		$result = "Failure";
	}

	return $result;
}
//Auto Renewal Purchase function Ends


//Credit function Starts
function OptimalCredit($varOptimalParms)
{
	global $varAccountNum,$varStoreID,$varStorePwd,$POSTURL;

	$xml = new XmlWriter();
	$xml->openMemory();

	$varPurchaseArgs=array();
	$accountNumArr["accountNum"]			= $varAccountNum;
	$storeIDArr["storeID"]					= $varStoreID;
	$storePwdArr["storePwd"]				= $varStorePwd;
	$varPurchaseArgs["merchantAccount"]		= $accountNumArr+$storeIDArr+$storePwdArr;

	$varPurchaseArgs["confirmationNumber"]	= $varOptimalParms['confirmationnumber'];
	$varPurchaseArgs["merchantRefNum"]		= $varOptimalParms['transactionorderid'];
	$varPurchaseArgs["amount"]		        = number_format($varOptimalParms['amount'], 2, '.', '');

	if($varOptimalParms['confirmationnumber'] != "" && $varOptimalParms['transactionorderid']!=""){
 
		generateXML($xml, $varPurchaseArgs);
		$xml->endElement();
		$txnRequest = '<ccPostAuthRequestV1 xmlns="http://www.optimalpayments.com/creditcard/xmlschema/v1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.optimalpayments.com/creditcard/xmlschema/v1">'.$xml->outputMemory(true).'</ccPostAuthRequestV1>';

		$POSTVARS   = "txnMode=ccCredit&txnRequest=".$txnRequest;
		$result     = curlfunctioncall($POSTVARS);
	}else{
		$result     = "Failure";
	}

	return $result;
}
//Credit function Ends




?>
