<?php
#====================================================================================================
# File			: index.php
# Author		: Dhanapal
# Date			: 23-Aug-2008
# Description	:
#====================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

//VARIABLE DECLARATIONS
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$varModule	= 'payment';

?>
<html>
<head>
	<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - Payment Options</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimonials : Online Matrimony - Membership rates. Became Paid Member & Contact our Profiles.">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/payment.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
</head>
<body>
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
			<div class="innerdiv">
				<?php if($varAct!='profilehightlight'){ include_once('../template/leftpanel.php'); }?>
				<div class="rpanel fleft">
					<?php
						if($varAct != "")
							{
								$varAct	= preg_replace("'\.\./'", '', $varAct);
								if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
								else{ include_once('payment.php'); }
							}else{ include_once('payment.php'); }
					?>
				</div>
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
