<?php
#====================================================================================================
# File			: index.php
# Author		: Rohini
# Date			: 15-July-2008
#*****************************************************************************************************
# Description	:
#********************************************************************************************************/
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath."/conf/ip.cil14");
include_once($varRootBasePath.'/lib/clsCache.php');

$varDomainName = $confValues['DOMAINNAME'];

if($varGetCookieInfo['MATRIID']!='') {
	$varOpenIp		= $varChat['OPENFIRE'];
	$varCasteId		= $confValues['DOMAINCASTEID'];
	$sessMatriId	= $varGetCookieInfo['MATRIID'];
	$sessGender		= $varGetCookieInfo['GENDER'];
	$sessGender		= $sessGender==1 ? 'M' : 'F';

	//Set ONLINE Status in Cache for sphinx
	if(Cache::getData('SPHX_ROTATEINDEX_ON')=='1') {
	$varOnlineCacheSph	= ($sessGender=='M') ? 'SPHX_ONLINE_DETAIL_MALE' : 'SPHX_ONLINE_DETAIL_FEMALE';
	$arrOldMatriIdDets	= Cache::getData("$varOnlineCacheSph");	
	if(!is_array($arrOldMatriIdDets)){$arrOldMatriIdDets=array();}
	//$arrNewMatriIdDet	= array("$sessMatriId"=>0);	
	//$arrNewMatriIdDet	= array_merge($arrOldMatriIdDets, $arrNewMatriIdDet);
	$arrNewMatriIdDet		= array();
	$arrNewMatriIdDet[substr($sessMatriId, 3)]['sphinxmemberinfo_'.$confValues['DOMAINCASTEID'].'_'.$varGetCookieInfo['GENDER']]=0;
	Cache::setData("$varOnlineCacheSph", $arrNewMatriIdDet);
	}
   	$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
	escapeexec("php logout_curl.php $varCasteId $sessMatriId $sessGender $varOpenIp",$varlogFile);

}//if

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

setrawcookie("browsertime",false,time() - 36, "/",$varDomainName);
setrawcookie("loginInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("profileInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("partnerInfo",false, time() - 36, "/",$varDomainName);
setrawcookie("messagesInfo",false, time() - 36, "/",$varDomainName);
setrawcookie("savedSearchInfo",false,time() - 36,"/",$varDomainName);
setrawcookie("lastViewProfile",false,time() - 36, "/",$varDomainName);
setrawcookie("requestReceivedInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("requestSentInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("listInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("viewsInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("offerInfo",false,time() - 36, "/",$varDomainName);
setrawcookie("onlinePaymentInfo",false,time() - 36, "/",$varDomainName);

$_COOKIE['loginInfo']			= '';
$_COOKIE['profileInfo']			= '';
$_COOKIE['partnerInfo']			= '';
$_COOKIE['messagesInfo']		= '';
$_COOKIE['savedSearchInfo']		= '';
$_COOKIE['lastViewProfile']		= '';
$_COOKIE['requestReceivedInfo']	= '';
$_COOKIE['requestSentInfo']		= '';
$_COOKIE['listInfo']			= '';
$_COOKIE['viewsInfo']			= '';
$_COOKIE['offerInfo']			= '';
$_COOKIE['onlinePaymentInfo']   = '';
$varGetCookieInfo['MATRIID']	= '';

?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css" />
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css" />
	<script language="javascript" src="<?=$confValues['JSPATH']?>/login.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript">
	 function callpop()
	 {
		 window.open('http://www.privilegematrimony.com','','width=750,height=650,scrollbars=yes');
	 }
	</script>
</head>
<body onload="callpop();">
<center>
<!-- main body starts here -->
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/header.php");
	}
?>
<div id="maincontainer">
	<div id="container">
		<div style="width: 772px;">
		<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
					include_once($confValues['HEADERTEMPLATEPATH']."/header.php");
				}
		?>

<div class="logdivlt padt10 padb10">
	<div class="normtxt bld clr">Logged Out</div>
	<div class="smalltxt padtb10">You have logged out from <?=$confValues['PRODUCTNAME']?>.com. Thank you for using our services!</div>
	<br clear="all">

	<center><div class="normtxt bld clr tlleft" style="padding-bottom:5px;width:380px;">Member Login</div>
	<div class="linesep" style="width:380px;"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div></center>
	<br clear="all">

	<form name="frmLogin"  method="post" action="index.php">
		<input type="hidden" name="frmLoginSubmit" value="yes">
		<input type="hidden" name="act" value="logincheck">

		<div class="logdivlta smalltxt">Matrimony ID / E-mail</div>
		<div class="logdivltb">
			<input type="text" name="idEmail" id="idEmail" value="" 
				class="inputtext" tabindex="1" size="30">
		</div>

		<div class="logdivlta smalltxt">Password</div>
		<div class="logdivltb">
			<input type="password" name="password" id="password" value="" class="inputtext" tabindex="2" size="30"><br><span id="error" class="errortxt" style="padding: 0px 0px 0px 0px;display:block"><?=$varErrorMessage;?></span>
		</div>

		<div class="logdivlta">&nbsp;</div>
		<div class="logdivltb">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="128" height="1" />
			<input type="submit" value="Login" class="button" tabindex="3" onClick="return funLogin();">
		</div>
		<br clear="all">
	</form>
</div>

<div class="logdivrt padt10"><iframe src="http://c1.zedo.com/jsc/c1/ff2.html?n=1405;c=1837;s=355;d8=;d5=;da=;d6=;d2=;d7=;d4=;d9=;d=9;w=300;h=250" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=300 height=250></iframe></div>

<div style="float:left;width:35px"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="35" height="1"></div><div style="float:left;width:425px" id='bannerdiv'></div>
<br clear="all">
<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
					include_once('../template/footer.php'); 
				}
			?></div>
</div>
</div>
<!--<div id="fade" class="bgfadediv"></div>-->
<!-- main body ends here -->
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/footer.php");
	}
?>
</center>
</body>
</html>
