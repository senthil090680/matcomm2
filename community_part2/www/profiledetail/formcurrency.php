<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : primaryinfodesc.php
#=====================================================================================================================================
# Description : display information of primary info. It has primary info form and update function primary information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');


ini_set('display_errors',1);
error_reporting(E_ALL);

//OBJECT DECLARTION
$objDBSlave	= new DB;


//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

$argFields		= array('BaseCurrency','ConvertedINRvalue');
$argCondition	= "where BaseCurrency > 0";
$iInrCnt  =$objDBSlave->select($varTable['CURRENCYCONVERSIONRATES'],$argFields,$argCondition,1);


foreach($iInrCnt as $value){
	//print_r($value);
	echo "<br>"."update memberinfo set Temp_Annual_Income=Annual_Income*".$value['ConvertedINRvalue']." WHERE Annual_Income>0 AND Income_Currency=".$value['BaseCurrency'];
}
  



?>