<?php
// INCLUDES //
header('Content-type: text/xml');
echo "<?xml version=\"1.0\"?>";
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objMasterDB= new DB;

$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varOrderId	    = trim($_REQUEST['ORDERID']);
$varCondition	= " WHERE OrderId=".$objMasterDB->doEscapeString($varOrderId,$objMasterDB);

// Order Id Empty return error message
if(strlen($varOrderId)=='0') {
	echo "<ORDERDET>";
	echo "<ORDERID>INVALID</ORDERID>";
	echo "</ORDERDET>";
	exit;
}

	
	$varCheckOrderId=$objMasterDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
	if ($varCheckOrderId>0){
		echo "<ORDERDET>";
		echo "<ORDERID>INVALID</ORDERID>";
		echo "</ORDERDET>";
		exit;
	}


	$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Offer_Given','Offer_Product_Id','Package_Cost','Currency','Discount','Amount_Paid','Date_Paid','Gateway');
	$varNoOfRecords = $objMasterDB->numOfRecords($varTable['PREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

//echo "varNoOfRecords=".$varNoOfRecords;
	// Num rows 0 return error message
	if($varNoOfRecords == 0) {

		echo "<ORDERDET>";
		echo "<ORDERID>INVALID</ORDERID>";
		echo "</ORDERDET>";
		exit;
	}
	$varExecute		= $objMasterDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition,0);
	$varPaymentInfo	= mysql_fetch_array($varExecute);

	$varMatriId		= $varPaymentInfo['MatriId'];
	$varProductId	= $varPaymentInfo['Product_Id'];
	$varCurrency	= $varPaymentInfo['Currency'];
	$varAmountPaid	= $varPaymentInfo['Amount_Paid'];

	$varCondition		 = " WHERE OrderId =".$objMasterDB->doEscapeString($varOrderId,$objDB);
	$varAddonNoOfRecords = $objMasterDB->numOfRecords($varTable['ADDONPREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
	
	if($varAddonNoOfRecords>0){

    $varPrepaymentFields	= array('Amount_Paid');
	$varOrderIdCondition	= " WHERE OrderId =".$objMasterDB->doEscapeString($varOrderId,$objDB);
	$varPrepaymentTrackinfo	= $objMasterDB->select($varTable['ADDONPREPAYMENTHISTORYINFO'], $varPrepaymentFields, $varOrderIdCondition, 0);
	$varPaymentTrackInfo		= mysql_fetch_array($varPrepaymentTrackinfo);
	$varAddonAmountPaid			= $varPaymentTrackInfo["Amount_Paid"];
	$varAmountPaid				= $varAmountPaid + $varAddonAmountPaid;
	}

	if($varCurrency == 'Rs') { $varCurrency="INR"; }

$objMasterDB->dbClose();
UNSET($objMasterDB);
   

$varPackage = '';
if ($varProductId==48) { $varDuration=3; $varPackage = 'BL'; }
else if($varProductId==9 || $varProductId==6 || $varProductId==3) { $varDuration=9; }
else if($varProductId==8 || $varProductId==5 || $varProductId==2) { $varDuration=6;}
else if($varProductId==7 || $varProductId==4 || $varProductId==1) { $varDuration=3; }

if ($varProductId==1 || $varProductId==2 || $varProductId==3) {  $varPackage = 'GL'; }
else if ($varProductId==4 || $varProductId==5 || $varProductId==6) {  $varPackage = 'SL'; }
else if ($varProductId==7 || $varProductId==8 || $varProductId==9) {  $varPackage = 'PL';  }




echo "<ORDERDET>";
echo "<ORDERID>VALID</ORDERID>";
echo "<MATRIID>".$varMatriId."</MATRIID>";
echo "<PACKAGE>".$varPackage."</PACKAGE>";
echo "<DURATION>".$varDuration."</DURATION>";
echo "<CURRENCY>".$varCurrency."</CURRENCY>";
echo "<PRICE>".$varAmountPaid."</PRICE>";
 
echo "</ORDERDET>";
?>
