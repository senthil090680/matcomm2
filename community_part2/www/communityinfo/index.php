<?php
#====================================================================================================
# Author 		: Prakash N
# Start Date	: 09 Mar 2010
# End Date		: 09 Mar 2010
# Project		: MatrimonyProduct
# Module		: Community Information - Static pages Index
#====================================================================================================
//ini_set("display_errors","1");
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/srchcontent.inc");
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == "logout"){ clearCookie(); }//if

	$titletag = $confPageValues['PAGETITLE'];
	$metadesc = $confPageValues['PAGEDESC'];

?>
<html>
<head>
	<title><?=$titletag?></title>
	<meta name="description" content="<?=$metadesc?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js"></script>
	<script language="JavaScript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>	
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
				<?php include_once('../template/leftpanel.php'); ?>
				<?php
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('LiveHelp.php'); }
						}else{ include_once('LiveHelp.php'); }
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