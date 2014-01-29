<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRootPath = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRootPath."/lib/clsDataConversion.php");
include_once($varBaseRootPath.'/conf/dbainfo.cil14');

//OBJECT DECLARTION
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

//GET DATAS FROM TEXT FILE - ('protect-photos-list.txt')
$varFileContent	= file($varRootPath.'/data-conversion/getNewlyAddedPhotos/photo-protect-info.txt');
$varNoOfLines	= count($varFileContent);

for($i=0; $i<$varNoOfLines; $i++)
{
	$varProtectInfo	= split('~',$varFileContent[$i]);
	$varNewMatriId	= $varProtectInfo[0];
	$varPasswd		= trim($varProtectInfo[2],"\n");

	$varUpdateCond	= "MatriId='".$varNewMatriId."'";

	$varTableName	= $varDbaInfo['DATABASE'].'.comm_memberphotoinfo_missed';
	$varFields		= array('Photo_Protect_Password', 'Photo_Protected');
	$varFieldsValues= array("'".$varPasswd."'", 1);
	$objDC->update($varTableName, $varFields, $varFieldsValues, $varUpdateCond);
}//for

//UNSET OBJECT
$objDC->dbClose();
unset($objDC);
?>