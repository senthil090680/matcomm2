<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-23
# End Date		: 2008-07-23
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');

//VARIABLE DECLARITON
$varErrorLanding	= 'yes';
?><br clear="all">
<table border="0" cellpadding="2" cellspacing="0" border="0" width="732" style="font: normal 11px verdana; color:#000000;border:1px solid #cbcbcb;" align="center">
	<tr><td><img src="<?=$confValues["IMGSURL"];?>/trans.gif" height="3" border="0" title=""></td></tr>
	<tr><td valign="top"><img src="<?=$confValues["IMGSURL"];?>/trans.gif" height="12" width="7" border="0" title=""></td>
	<td class="errortxt"><p style="margin:0px;">Sorry, the page you requested was not found. <a href="<?=$confValues["SERVERURL"];?>/login/index.php" class="smalltxt clr1"><u>Click here</u></a> to login if you're a registered member or use the form below to register FREE and find a <?=$confValues['PRODUCT']?> life partner.</p></td></tr>
</table><br>
<?php include_once('addbasic.php'); ?>