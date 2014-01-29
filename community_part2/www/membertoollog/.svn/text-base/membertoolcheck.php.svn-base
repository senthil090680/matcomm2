<?php
#============================================================================================================
# Author 		: Naresh.S
# Start Date	: 29 Oct 2010
# End Date		: 29 Oct 2010
# Project		: MatrimonialProduct
# Module		: Adding Value According to the verfication
#============================================================================================================

//FILE INCLUDES
//$varRootBasePath  = dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath ='/home/product/community/';
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//ASSIGN INPUT ARGUMENTS TO VALUES
$argMatrid	   = trim($_SERVER['argv'][1]);
$varType	   = trim($_SERVER['argv'][2]);
$argaffvalue   = trim($_SERVER['argv'][3]);


// OBJECT DECLARATION
$objDB	   = new DB;

//CONNECTION DECLARATION
$varConn  = $objDB->dbConnect('M', $varDbInfo['DATABASE']);

//CHECK TYPE   // 1- PHONE, 2- PHOTO, 3- HOROSCOPE
switch($varType) {
	case 1 : //PHONE
		if($argaffvalue==1 || $argaffvalue==3) {	
			$argFields				= array('MatriId','PhoneNumberVerifiedOn');
			$argFieldsValues		= array($objDB->doEscapeString($argMatrid,$objDB),'NOW()');
			$varInsertId			= $objDB->insertOnDuplicate('membertoolslog',$argFields,$argFieldsValues,'MatriId');
		} else {
			$argFields				= array('MatriId','PhoneNumberVerifiedOn');
			$argFieldsValues		= array($objDB->doEscapeString($argMatrid,$objDB),"'0000-00-00 00:00:00'");
			$varInsertId			= $objDB->insertOnDuplicate('membertoolslog',$argFields,$argFieldsValues,'MatriId');
		}
		break;

	case 2 : //PHOTO
		if($argaffvalue==1) {
			$argFields				= array('MatriId','PhotoAddedOn');
			$argFieldsValues		= array($objDB->doEscapeString($argMatrid,$objDB),'NOW()');
			$varInsertId			= $objDB->insertOnDuplicate('membertoolslog',$argFields,$argFieldsValues,'MatriId');
		} else {
			$argFields				= array('MatriId','PhotoAddedOn');
			$argFieldsValues		= array($objDB->doEscapeString($argMatrid,$objDB),"'0000-00-00 00:00:00'");
			$varInsertId			= $objDB->insertOnDuplicate('membertoolslog',$argFields,$argFieldsValues,'MatriId');
		}
		break;

	case 3 :  //HOROSCOPE
		if($argaffvalue==1 || $argaffvalue==3){
			$argFields				= array('MatriId','HoroscopeAddedOn');
			$argFieldsValues		= array($objDB->doEscapeString($argMatrid,$objDB),'NOW()');
			$varInsertId			= $objDB->insertOnDuplicate('membertoolslog',$argFields,$argFieldsValues,'MatriId');
		}else{
			$argFields				= array('MatriId','HoroscopeAddedOn');
			$argFieldsValues		= array($objDB->doEscapeString($argMatrid,$objDB),"'0000-00-00 00:00:00'");
			$varInsertId			= $objDB->insertOnDuplicate('membertoolslog',$argFields,$argFieldsValues,'MatriId');
		}
		break;

}


?>