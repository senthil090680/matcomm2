<?php


//===================================================================================
# Name        : Iyyappan. N
# Date        : 25-Mar-2011
# File Name   : textfile_3rdparty.php
# Description : Generate text file for 3rd party mailers 
//=====================================================================================

error_reporting(0);

//FILE INCLUDES
include_once('/home/product/community/conf/config.cil14');
include_once('/home/product/community/conf/ip.cil14');
include_once('/home/product/community/conf/dbinfo.cil14');
include_once('/home/product/community/lib/clsDB.php');

//VARIABLE DECLARATION
$varTotal   =1;
$varContant ='';

//OBJECT DECLARTION
$objDB	= new DB;

$objDB->dbConnect('S2', $varDbInfo['DATABASE']);

//CONNECT DATABASE
if($objDB->clsErrorCode) {
	echo "DB connection Error!.Please Check the connection.\n";
	exit;
}

//QUERY
$varQuery	= "SELECT A.MatriId, A.Name, A.CasteId, A.Age, A.Gender, A.CommunityId, A.Religion, A.Country, B.Email FROM memberinfo A, memberlogininfo B WHERE A.MatriId=B.MatriId AND A.Paid_Status=1 AND A.CommunityId NOT IN (2002,2500,2503) AND A.MatriId NOT IN ( SELECT MatriId FROM profilehighlightdet )";
$varResult  = $objDB->ExecuteQryResult($varQuery,0);

if($objDB->clsErrorCode) {
	echo "\n Please check the Selection Query! \n";
	exit;
}


while($varMemberInfo  = mysql_fetch_assoc($varResult)) {
	$varMatriId		  = $varMemberInfo['MatriId'];
	$varEmail		  = $varMemberInfo['Email'];
	$varName          = $varMemberInfo['Name'];
	$varCasteId       = $varMemberInfo['CasteId'];
	$varCommunityId   = $varMemberInfo['CommunityId'];

	$varContant.= $varTotal.",".trim($varMemberInfo['Email']).",".trim($varMemberInfo['Name']).",".trim($varMemberInfo['MatriId']).",".trim($varMemberInfo['Age']).",".trim($varMemberInfo['Gender']).",,".trim($varMemberInfo['CommunityId']).",".trim($mailrow['CasteId']).",".trim($varMemberInfo['Country']).",".date("Y-m-d H:i:s") ."\n";


	$varTotal++;
}

$objDB->dbClose();

//FILE NAME
$varFilename= date('Ymd').'_General.txt';

if(!$varFileHandler = fopen($varFilename,"w+") ) {
	echo "File cannot able to open. check the Filename & path. \n";
	exit;
} else if (fwrite($varFileHandler,$varContant) === FALSE) {
	echo "Cannot write to file ...\n";
	exit;
}
echo "\n Text File generated : Filename :".$varFilename." \n Count :".$varTotal." \n";

?>