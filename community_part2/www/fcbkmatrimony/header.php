<?php
ini_set('display_errors','On');
require_once('appinclude.php');
require_once('../includes/config.php');
require_once('../includes/dbConn.php');
require_once('../registration/includes/registration-array-values.php');
require_once('includes/clsProductFacebook.php');

//CONFIG VALUES
$confDomainName	= $confValues["DomainName"];
$confServerURL  = $confValues["ServerURL"];

//SESSION OR COOKIE VALUES
$sessMatriId	= $confValues["sessMatriId"];
$sessGender		= $confValues["sessGender"];
$sessPaidStatus	= $confValues["sessPaidStatus"];
$sessPublish	= $confValues["sessPublish"];
$sessLastLogin	= trim($confValues["sessLastLogin"]);
$sessUsername	= $confValues["sessUsername"];

$varPath = explode('/',$_SERVER['REQUEST_URI']);
$varFileName = explode('.',$varPath[2]);
//echo '<pre>'; print_r($varFileName); echo '</pre>';
if(($varFileName[0]=='facelogout') || ($varCryptId != $confMyId))
{
	//IF USER LOGOUT CLEAR THE COOKIE VALUES
	setcookie("LoginInfo",'', '0', '/',$confDomainName);
	setrawcookie("MessagesInfo",'', '0', '/',$confDomainName);
	$sessMatriId	= '';
	$sessGender		= '';
	$sessUsername	= '';
	$sessLastLogin	= '';
	$sessPaidStatus	= '';
	$sessPublish	= '';
}

$js_br="";
$br = $_SERVER['HTTP_USER_AGENT'];
if(strpos(' '.strtolower($br),'safari')) {
	$js_br = "S";
}
else if(strpos(' '.strtolower($br),'netscape')) {
	$js_br = "N";
}
else if(strpos(' '.strtolower($br),'firefox')) {
	$js_br = "F";
}
else if(strpos(' '.strtolower($br),'opera')) {
	$js_br = "O";
}
else {
	$js_br = "I";
}
if($js_br =="I")
{
	$varVersionFrmHttp = explode(';',$br);
	$varVersionFrmMSIE = explode(' ',$varVersionFrmHttp[1]);
	$varVersion = $varVersionFrmMSIE[2];
}

//echo 'SessionMatriId::'.$sessMatriId;
?>
<title>Muslim Matrimonial, Muslim Matrimonials, Muslim Matrimony</title>
<meta name="description" content="Muslim Matrimonial, Muslim Matrimonials, Muslim Matrimony. Searching For A Muslim Bride Or Muslim Groom ? Register FREE At Our Islamic Marriage Website.">
<meta name="keywords" content="Muslim Matrimonial, Muslim Matrimonials, Muslim Matrimony">
<meta name="abstract" content="Muslim marriage services provider.">
<meta name="Author" content="Ahmad, Islamic advisor at Muslim matrimonial">
<meta name="copyright" content="&copy;2009 Muslim matrimonial">
<meta name="Distribution" content="general">
<link rel="stylesheet" href="<?=$confValues['ServerURL']?>/stylesheet/bmstyle.css">
<link rel="stylesheet" href="<?=$confValues['ServerURL']?>/stylesheet/style.css">
<link rel="stylesheet" href="<?=$confValues['ServerURL']?>/stylesheet/mm_style.css">

<style>
.formborderclr	{border-width: 1px; border-color: #C3E07B; border-style: solid;}
.normaltxt2  	  {  font-family: verdana, MS Sans serif, Arial, Verdana, Helvetica, sans-serif; font-size: 10px; font-style: normal; text-transform: none; color: #000000; font-weight: normal;  text-decoration: none;}
.smalltxt	{font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; font-weight: normal; text-decoration: none}
.smalltxt2 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #FF802C; FONT-STYLE: normal; FONT-FAMILY: Verdana, MS Sans serif; TEXT-DECORATION: none;}
.smallttxtnormal  	  {  font-family: verdana, Arial, MS Sans serif, Arial, Verdana, Helvetica, sans-serif; font-size: 11px; font-style: normal; text-transform: none; color: #000000; font-weight: normal;  text-decoration: none;}
a.onlinetxt	{font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; font-weight: bold; text-decoration: none;}
.grsearchtxt	{font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px; color: #286769; font-weight: normal; text-decoration: none;}
.facetxt { FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; FONT-STYLE: normal; FONT-FAMILY: Verdana, MS Sans serif; TEXT-DECORATION: none; }
.tableborder { border:1px solid #3B5998; }
.facetxtbox { FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; FONT-STYLE: normal; FONT-FAMILY: Verdana, MS Sans serif; TEXT-DECORATION: none;border:1px solid #3B5998; }
.menutdborder { border-left:1px solid #B7B7B7;}
.bluetxt	{font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px; color: #3B5998; font-weight: normal; text-decoration: none;}
.tableth { font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; text-decoration: none;text-align:center; }
.tabletd { font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; font-weight: normal; text-decoration: none;border-bottom:1px solid #B7B7B7; }
.pagetxtsp { font-family: verdana, MS Sans serif, Arial, Verdana, Helvetica, sans-serif; font-size: 11px; font-style: normal; text-transform: none; color: #1470AF; font-weight: normal;  text-decoration: none;} 
a.pagetxtsp { text-decoration:none;cursor:hand; }
</style>
<script language="javascript" src="<?=$confServerURL?>/search/includes/advanced-search.js" type="text/javascript"></script>
<script language="javascript" src="<?=$confServerURL?>/search/includes/mouseoverimage.js" type="text/javascript"></script>
<script language="javascript" src="<?=$confServerURL?>/fcbkmatrimony/includes/facebook.js"></script>
