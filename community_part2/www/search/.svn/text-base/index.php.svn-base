<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/srchcontent.cil14");
include_once($varRootBasePath."/conf/cityarray.cil14");
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == "logout"){ clearCookie(); }//if

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessHoroscopeAvailable	= $varGetCookieInfo["HOROSCOPESTATUS"];
$sessMotherTongue= $varGetCookieInfo["MOTHERTONGUE"];

//FOR PRIVILEGE PURPOSE..
$varPartialFlag	= '0';

//Unset lastlogin cookie
setcookie('lltimestamp', '', time()-3600, '/');
?>
<html>
<head>
	<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - Find <?=ucfirst($arrDomainInfo[$varDomain][2])?> Brides & Grooms</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony, the Perfect Place to search for a  <?=ucfirst($arrDomainInfo[$varDomain][2])?> partner. View 1000s of profiles from <?=ucfirst($arrDomainInfo[$varDomain][2])?> community. Register Now for Free!">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<style>.facetdot{ margin-left:15px;width:160px;background:url(<?=$confValues['IMGSURL'];?>/dotbg2.gif) repeat-x;height:1px;}</style>

	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
	<script language="javascript">
	//<!--
	var cook_id = '<?=$sessMatriId?>', cook_publish='<?=$sessPublish?>',cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';
	//-->
	</script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/facet.js" ></script>
</head>
<body onselectstart="return false" ondragstart="return false" oncontextmenu="return false">
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
		<div class="main">
			<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
					include_once($confValues['HEADERTEMPLATEPATH']."/header.php");
				}
			?>
			<div class="innerdiv" id="centerpartdiv">
			<?php
				if($varAct == 'srchresult'){
					echo '<div style="float:left;width:210px;">
					<div style="float:left;width:210px;" id="sidemenupart"></div>
					<div class="fleft" style="margin-top:10px;border: 1px solid #DBDBDB;width:190px;"><div style="margin-top:15px;margin-bottom:15px;" align="center"><iframe src="http://c1.zedo.com/jsc/c1/ff2.html?n=1405;c=1837;s=355;d8=;d5=;da=;d6=;d2=;d7=;d4=;d9=;d=7;w=160;h=600" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=160 height=600></iframe></div></div></div>';					

				}else{	include_once('../template/leftpanel.php'); }

				if($varAct != "")
				{
					$varAct	= preg_replace("'\.\./'", '', $varAct);
					if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
					else{ include_once('search.php'); }
				}else{ include_once('search.php'); }
			?>
			<br clear="all" />
			</div>
			<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
					include_once('../template/footer.php'); 
				}
			?>
		</div>
	</div>
</div>
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/footer.php");
	}
?>
</center>
</body>
</html>