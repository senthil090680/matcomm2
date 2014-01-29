<?php
#=================================================================================================================
# Author 	  : Baranidharan M
# Date		  : 2010-06-23
# Project	  : MatrimonyProduct
# Filename	  : txtFileCreater.php
#=================================================================================================================
# Description : Execute the query to fetch the details of inactive members and write into three text files . 
#=================================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

$objDB		= new DB;
$objDB->dbConnect('S2', $varDbInfo['DATABASE']);
$varInactivePeriod	= trim($_SERVER['argv'][1]);

if ($varInactivePeriod=="") { echo 'Enter Period'; exit; } else {

$arrInactiveDays	= array(1=>181,2=>187,3=>194);
$varInterval		= $arrInactiveDays[$varInactivePeriod];
$varLoginDate		= date('Y-m-d',mktime(0, 0, 0, date("m"), date("d")-$varInterval, date("Y")));

$varQuery = "SELECT MatriId,Name,Nick_Name FROM memberinfo WHERE CommunityId IN (3,2004,281,9,240,25,2504,35,2500,270,2001,49,60,27,28,2501,67,74,76,82,85,87,99,106,107,113,2003,123,133,135,2503,137,142,292,149,156,159,165,170,2502,212,285,218,229,236,237,239,2,261,10,12,13,14,15,254,20,22,178,34,37,269,40,291,242,59,271,63,251,241,77,273,83,283,89,90,255,248,100,252,253,275,243,121,264,138,331,258,256,171,247,259,244,341,277,278,198,342,231,233,234,2000,5,7,18,23,30,42,44,50,250,62,65,29,79,93,101,114,116,117,124,134,136,139,153,162,175,176,293,179,200,207,208,213,220,221,232,2002,260,673,17,267,33,36,38,286,43,54,309,26,287,272,299,288,319,71,81,322,88,274,97,105,327,109,130,263,132,289,246,161,284,257,173,268,276,265,214,280,202,210,347,249,349,224,225,226,354,266,1,6,8,11,295,297,16,19,298,21,24,31,32,339,39,41,45,46,47,303,48,51,52,53,55,304,56,57,306,308,61,310,311,312,64,314,66,317,68,69,70,72,73,75,78,80,84,321,326,86,91,92,94,323,95,96,98,324,325,102,103,108,110,111,112,115,118,119,120,125,328,126,127,128,129,131,330,141,143,144,145,333,147,148,334,150,151,152,155,157,158,336,358,163,164,166,167,168,169,338,172,174,340,177,197,344,201,203,204,205,206,209,211,346,348,215,356,216,217,219,350,222,223,227,228,351,230,353,355,238) AND Publish <=2 AND Paid_Status=0 AND Last_Login >='".$varLoginDate." 00:00:00' AND Last_Login <='".$varLoginDate." 23:59:59'";
//echo $varQuery;exit;

$varResult = mysql_query($varQuery) OR die('error in query');

//FILE NAME
$varFilename	= date('Y-m-d').'_'.$varInterval.'.txt';
$varContent		= '';

//DELETE FILE
@unlink($varFilename);

//CREATE FILE
$varFileHandler	= fopen("/home/product/community/inactive/log/".$varFilename,"w");

while($row = mysql_fetch_assoc($varResult)) {


	$varMatriId	 = '';
	$varNickName = '';
	$varName	 = '';
	$varEmail	 = '';
	$varPassword = '';
	$varQuery2	 = '';
	$varExecute	 = '';
	$varResults	 = '';

	$varMatriId	= trim($row['MatriId']);
	$varNickName= ucwords(strtolower(trim(stripslashes($row['Nick_Name']))));
	$varName	= ucwords(strtolower(trim(stripslashes($row['Name']))));
	$varNickName= $varNickName ? $varNickName : $varName;

	$varQuery2	= "SELECT Email,Password FROM memberlogininfo WHERE MatriId='".$varMatriId."'";
	$varExecute	= mysql_query($varQuery2) OR die('error in query');
	$varResults	= mysql_fetch_array($varExecute);
	$varEmail	= $varResults["Email"];
	$varPassword= $varResults["Password"];

	$varContent .= $varMatriId."~".$varNickName."~".$varEmail."~".$varPassword."\n";
}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);
$objDB->dbClose();

}
?>