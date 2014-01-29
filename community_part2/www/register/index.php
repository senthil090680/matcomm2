<?php
#====================================================================================================
# File			: index.php
# Author		: JeyaKumar
# Date			: 15-July-2008
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#********************************************************************************************************/
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES

include_once($varRootBasePath."/lib/clsDomain.php");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//CHECK AUTHETICATION
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == 'logout'){ clearCookie(); }//if
if($varAct == 'addedbasic'){ include_once('addedbasic.php'); }//if
if($_POST['intRegister'] == 'yes') { include_once('intermediateregister.php'); }//if

$varLogoName	= $arrDomainInfo[$varDomain][2];
$varLogoName	= $varLogoName ? $varLogoName : $varDomain;

?>
<html>
<head>
<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - <?=ucfirst($arrDomainInfo[$varDomain][2])?> Brides & Grooms - Free Registration</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - Free <?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimonial & Matrimonials - Add your profile now & get <?=ucfirst($arrDomainInfo[$varDomain][2])?> matches. <?=ucfirst($arrDomainInfo[$varDomain][2])?> Bride / Groom - Free Registration!">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
	<link rel="stylesheet" type="text/css" href="<?=$confValues['CSSPATH']?>/spellchecker.css">
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/common.js"></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/register.js"></script>
	<script language=javascript src="<?=$confValues["JSPATH"];?>/ajax.js"></script>
	<script src="<?=$confValues["SERVERURL"];?>/spellchecker/cpaint/cpaint2.cil14.compressed.js" type="text/javascript"></script>
	<script src="<?=$confValues['JSPATH']?>/spell_checker_compressed.js" type="text/javascript"></script>
</head>
<body>
<center>
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/regheader.php");
	}
?>
<div id="maincontainer">
	<div id="container">
	<center>
		<div class="main">
			<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
			?>
			<div class="fleft logodiv padb5"><a href="<?=$confValues['SERVERURL']?>" ><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varLogoName?>_logo.gif" alt="communitymatrimony" border="0"/></a></div>
			<br clear="all" />
			<?php if($varAct!='register_payment'){ ?>
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

			<? }else{ if($arrDomainInfo[$varDomain][2]=="christian"){$varBg = 'chrmenbg';}elseif($arrDomainInfo[$varDomain][2]=="muslim"){$varBg = 'musmenbg';}else{$varBg = 'commenbg';}?>
			<br clear="all" />
			<div style="width: 100%; height: 45px; background: url('<?=$confValues['IMGSURL']?>/<?=$varBg?>.gif') repeat;" class="fleft">
				<div style="width: 772px;">
					<div style="width: 475px;color:#ffffff;" class="fnt17 bld fleft padt10 padl">
						Upgrade to Premium Membership
					</div>
					<div class="fright padt10 padr10" style=""><a href="/profiledetail/" class="normtxt" style="color:#ffffff;">Skip to My Home >></a></div>
					<br clear="all">
				</div>
			</div>
			<?}?>


			<? } ?>
			<br clear="all">

		   <!-- Google Landing Header Starts-->
		   <? if (trim($_GET['source'])=='inorganic') { ?>
		   <div class="brdr fleft main">
			<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/googlelandimg.jpg"></div>
			<div class="fleft clr3 padl25"><br><br><font style="font:30px georgia,times new roman,arial;">Find a <?=$varUcDomain?> Life Partner<br><font class="clr" style="font-size:25px;">Register FREE & Receive FREE Matches</font></font>
			</div>
		   </div><div class="cleard"></div><br clear="all">
		   <? } ?>
		   <!-- Google Landing Header Ends -->
			<div class="innerdiv">
			<?php
				if ($varAct != "congrats" && $varAct != "congrats1") { include_once('../template/leftpanel.php'); }
			if($varAct != "")
			{
				$varAct	= preg_replace("'\.\./'", '', $varAct);
				if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
				else{ include_once('addbasic.php'); }
			}else{ include_once('addbasic.php'); }
			?><br clear="all">
			</div>
			
			<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
			?>
			<div class="linesep footdiv"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
			<div class="footdiv">
				<center><div class="fleft footdiv2"><font class="smalltxt clr"><?=$confPageValues["COPYRIGHT"]?></font></div></center>
			</div>
			<? } ?>
		</div>
		</center>
	</div>
</div>
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/regfooter.php");
	}
?>
</center>

<? if(!empty($_SERVER['HTTP_REFERER'])) { $varOrgAct = $_REQUEST['act'] ? '/'.$_REQUEST['act'].'.php' : '';  ?>
	<iframe src="http://www.communitymatrimony.com/googlecamp/seo/seoorganictrack.php?ref=<?=urlencode($_SERVER['HTTP_REFERER'])?>&ip=<?=urlencode($_SERVER['REMOTE_ADDR'])?>&page=<?=$_SERVER['PHP_SELF'].$varOrgAct?>&matriid=<?=trim($varGetCookieInfo['MATRIID'])?>" width="0" height="0" frameborder="0"></iframe>

<?	}  if ($varAct != "congrats") {  
if ($varLiveHelp=='1') { ?>

<script language="javascript">

function funLiveHelpNo(){
		objLiveHelp = AjaxCall();
		var parameters	= Math.random();
		var liveHelpURL	= '<?=$varLiveHelpURL;?>' + "/site/livehelpno.php";
		objLiveHelp.onreadystatechange = funLiveHelp;
		objLiveHelp.open('POST', liveHelpURL, true);
		objLiveHelp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objLiveHelp.setRequestHeader("Content-length", parameters.length);
		objLiveHelp.setRequestHeader("Connection", "close");
		objLiveHelp.send(parameters);
		return objLiveHelp;
} //funLiveHelpNo()

function funLiveHelp() {
	if (objLiveHelp.readyState == 4 && objLiveHelp.status == 200) {
		var tollFreeNo = objLiveHelp.responseText;
		if(document.getElementById('livehelpno')){
			document.getElementById('livehelpno').innerHTML = tollFreeNo;
		}
		if(document.getElementById('livehelpno1')){
			document.getElementById('livehelpno1').innerHTML = tollFreeNo;
		}
	}
}//funLiveHelpNo();

function funDisplayNo(argNo) {
	if(document.getElementById('livehelpno')){
		document.getElementById('livehelpno').innerHTML = argNo;
	}
	if(document.getElementById('livehelpno1')){
		document.getElementById('livehelpno1').innerHTML = argNo;
	}

}//funDisplayNo



</script>

<?	
$varLiveHelpNo	= $_COOKIE['liveHelpNo'];
if ($varLiveHelpNo !="") {
	echo '<script>';
	echo 'funDisplayNo(\''.$varLiveHelpNo.'\');';
	echo '</script>';
} else { echo '<script>funLiveHelpNo();</script>'; }
}
} ?>
</body>
</html>
