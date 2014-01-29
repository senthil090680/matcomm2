<?php
	
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
	
	//FILE INCLUDES
	include_once($varRootBasePath.'/conf/config.inc');

	// SESSION VARIABLE
	$varMatriId	= $varGetCookieInfo['MATRIID'];

	//OBJECT DECLARTION
	$objCommMaster	= new DB;
	$objTMMaster	= new DB;

	//CONNECTION ESTABILISH
	$objCommMaster->dbConnect('M',$varDbInfo['DATABASE']);
	$objTMMaster->dbConnect('M','cbstminterface');

	$varCondition	= " WHERE MatriId=".$objCommMaster->doEscapeString($varMatriId,$objCommMaster);
	$varFields		= array('Last_Payment','Valid_Days','Expiry_Date','Paid_Status');
	$varExecute1	= $objCommMaster->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
	$varPaymentInfo	= mysql_fetch_assoc($varExecute1);

	$varLastPayment		= trim($varPaymentInfo["Last_Payment"]);
	$varValidDays		= trim($varPaymentInfo["Valid_Days"]);
	$varExpiryDate		= trim($varPaymentInfo["Expiry_Date"]);
	$varPaidStatus		= trim($varPaymentInfo["Paid_Status"]);

	if ($varPaidStatus==1 && $varValidDays > 0 && $varLastPayment !='0000-00-00 00:00:00'){

		//UPDATE LAST LOGIN INTO memberinfo TABLE
		$varEntryType	= 'R';
		$varCondition	= " MatriId=".$objTMMaster->doEscapeString($varMatriId,$objTMMaster);
		$varFields		= array('LastPayment','ValidDays','ExpiryDate','EntryType');
		$varFieldsValue	= array("'".$varLastPayment."'","'".$varValidDays."'","'".$varExpiryDate."'","'".$varEntryType."'");
		$objTMMaster->update('cbstmprofiledetails', $varFields, $varFieldsValue, $varCondition);

	}//if

	$objCommMaster->dbClsoe();
	$objTMMaster->dbClsoe();

	//UNSET OBJECT
	UNSET($objCommMaster);
	UNSET($objTMMaster);
?>