<?
#====================================================================================================
# File			: index.php
# Author		: Dhanapal N
# Date			: 15-July-2008
# Module		: CommunityMatrimony Login
#********************************************************************************************************/

//BASE ROOT
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

//OBJECT DECLARTION
$objDB	= new DB;

//DB CONNECTION
$objDB->dbConnect('S',$varDbInfo['DATABASE']);


$varEventId	= $_REQUEST["evid"];
//$varVMMURL	= "http://meet.communitymatrimony.com/vmlogin.php?evid=".$varEventId;

//CHECK WHETHER THE EVID ID IS NUMBER.IF NOT, REDIRECT TO EVENTS LIST PAGE
if(is_numeric($varEventId) != 1) {  header("Location: /login/");exit; }

if ($sessMatriId!="" && $sessGender !=""  && $sessPublish !="") {

	$varFields		= array('MatriId','Password');
	$varCondition	= " WHERE ".$varWhereClause." AND MatriId=".$objDB->doEscapeString($sessMatriId,$objDB);
	$varExecute		= $objDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
	$varLoginInfo	= mysql_fetch_assoc($varExecute);
	$varMatriId		= $varLoginInfo["MatriId"];
	$varPassword	= $varLoginInfo["Password"];
	//echo "Login Details MatriId=".$varMatriId.'=Password='.$varPassword;

if ($varMatriId!="" && $varPassword !="") { ?>

	<form name="vmmLogin" method="post" action="http://meet.communitymatrimony.com/vmlogin.php">
		<input type="hidden" name="evid" value="<?=$varEventId?>">
		<input type="hidden" name="matriid" id="matriid" value="<?=$varMatriId?>">
		<input type="hidden" name="password" id="password" value="<?=$varPassword?>">
		<input type="hidden" name="submitdirect" value="yes">
	</form>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" border="0" />
	<script>document.vmmLogin.submit();</script>
<? } else { header("Location: ".$varVMMURL); } 

} else { header("Location: ".$varVMMURL); }

$objDB->dbClose();
UNSET($objDB);
?>