<?php
#=========================================================================================================================
# Author 		: Ashok kumar
# Date	        : 01 June 2009
# Project		: Community Matrimony Product
# Filename		: cbstmpackagedetail.php
#=========================================================================================================================
# Description   : It retrives Package details and output to CBS-TM
#=========================================================================================================================

// Error Reporting ON | OFF //
error_reporting(0);

// Default Includes //
include_once "/home/product/community/conf/domainlist.cil14";

$varMatriId				= (trim($_GET['matriid'])!=''?trim($_GET['matriid']):'');
$varDomainId			= (trim($_GET['domain'])!=''?trim($_GET['domain']):'');
$varGetPackage			= '';
$varGetFolder			= '';
$varGetPrefix			= '';
$varOfflineCurrency		= array('98'=>'RS.','US$'=>'222','AED'=>'220','GBP'=>'221','EUR'=>'21','PKR'=>'162');
$varOfflineCurrencyId	= $varOfflineCurrency[trim(strtoupper(strtolower($_REQUEST["currency"])))];
$varOfflineCurrencyId	= $varOfflineCurrencyId ? $varOfflineCurrencyId : '98';
$varCountryCode			= $_REQUEST["upgradeCountry"];
$varOfflineCurrencyId	= $varCountryCode ? $varCountryCode : $varOfflineCurrencyId;
$varUseCountryCode		= $varCountryCode; 
//$varCountryCode			= $varOfflineCurrencyId;

//CHECK GATEWAY
if ($varCountryCode==98){  $varGateWay = 1;  }
else if ($varCountryCode==162){ $varGateWay = 3; $varUsdGateWayAvailable = 1; }
else { $varGateWay = 3; $varUsdGateWayAvailable	= 1; }

if ($varOfflineCurrencyId=='98'){ $varPrivilege1Month = '6999'; }
else if ($varOfflineCurrencyId=='222'){ $varPrivilege1Month = '175'; }
else { $varPrivilege1Month=''; }

if ($varOfflineCurrencyId=='98'){ $varPrivilege6Month = '36000'; }
else { $varPrivilege6Month=''; }

// Identifying is MatriId belongs to CBS or Product and Gets the Folder Name //
$varGetPrefix = strtoupper(substr(trim($varMatriId),0,3));
if (array_key_exists($varGetPrefix, $arrFolderNames)) {
	$varGetFolder = $arrFolderNames[$varGetPrefix];
	$varGetPackage = 'CBS';
}

// INCLUDES //
include_once "/home/product/community/domainslist/$varGetFolder/conf.cil14";
include_once "/home/product/community/conf/payment.cil14";
include_once("/home/product/community/www/payment/paymentprocess.php");

if ($varOfferStatus	== 1) { $varPriceArray = $arrTagDiscount[$casteTag]; } else { $varPriceArray = 0; }

if ($varCountryCode==162) {
	$varPKR = ' PKR ';
	$varCost1 = $varPKR.$arrRate[$varOfflineCurrencyId][1];
	$varCost2 = $varPKR.$arrRate[$varOfflineCurrencyId][2];
	$varCost3 = $varPKR.$arrRate[$varOfflineCurrencyId][3];
	$varCost4 = $varPKR.$arrRate[$varOfflineCurrencyId][4];
	$varCost5 = $varPKR.$arrRate[$varOfflineCurrencyId][5];
	$varCost6 = $varPKR.$arrRate[$varOfflineCurrencyId][6];
	$varCost7 = $varPKR.$arrRate[$varOfflineCurrencyId][7];
	$varCost8 = $varPKR.$arrRate[$varOfflineCurrencyId][8];
	$varCost9 = $varPKR.$arrRate[$varOfflineCurrencyId][9];
	$varCost48 = $varPKR.$arrRate[$varOfflineCurrencyId][48];

	UNSET($arrRate);
	$arrRate		= array();
	$arrRate[162]	= $arrUsdGatewayConver;

}

//print_r($arrRate);


// Returning XML Output of Package details to CBS-TM Interface //
echo "<PACKDATA>
<P1>
<COST>".$arrRate[$varOfflineCurrencyId][1]."</COST>
<PNAME>".$arrPrdPackages[1].$varCost1."</PNAME>
</P1>
<P2>
<COST>".$arrRate[$varOfflineCurrencyId][2]."</COST>
<PNAME>".$arrPrdPackages[2].$varCost2."</PNAME>
</P2>
<P3>
<COST>".$arrRate[$varOfflineCurrencyId][3]."</COST>
<PNAME>".$arrPrdPackages[3].$varCost3."</PNAME>
</P3>
<P4>
<COST>".$arrRate[$varOfflineCurrencyId][4]."</COST>
<PNAME>".$arrPrdPackages[4].$varCost4."</PNAME>
</P4>
<P5>
<COST>".$arrRate[$varOfflineCurrencyId][5]."</COST>
<PNAME>".$arrPrdPackages[5].$varCost5."</PNAME>
</P5>
<P6>
<COST>".$arrRate[$varOfflineCurrencyId][6]."</COST>
<PNAME>".$arrPrdPackages[6].$varCost6."</PNAME>
</P6>
<P7>
<COST>".$arrRate[$varOfflineCurrencyId][7]."</COST>
<PNAME>".$arrPrdPackages[7].$varCost7."</PNAME>
</P7>
<P8>
<COST>".$arrRate[$varOfflineCurrencyId][8]."</COST>
<PNAME>".$arrPrdPackages[8].$varCost8."</PNAME>
</P8>
<P9>
<COST>".$arrRate[$varOfflineCurrencyId][9]."</COST>
<PNAME>".$arrPrdPackages[9].$varCost9."</PNAME>
</P9>

<P48>
<COST>".$arrRate[$varOfflineCurrencyId][48]."</COST>
<PNAME>".$arrPrdPackages[48].$varCost48."</PNAME>
</P48>

<P56>
<COST>".$varPrivilege1Month."</COST>
<PNAME>Privilege 1 Month</PNAME>
</P56>

<P80>
<COST>".$varPrivilege6Month."</COST>
<PNAME>Privilege 6 Month</PNAME>
</P80>
<P10><CATEGORY>".$casteTag."</CATEGORY></P10>
<P100><DOMAINNAME>".str_replace("matrimony.com","",$arrPrefixDomainList[$varGetPrefix])."</DOMAINNAME></P100>
</PACKDATA>";

?>