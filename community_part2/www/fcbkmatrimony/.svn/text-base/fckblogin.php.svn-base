<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 2007-08-1
# End Date		: 2007-08-1
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
require_once('header.php');
require_once('navinc.php');
$varCheckLogin	=	$_REQUEST['checklogin'];
$varFrmSubmit	=	$_REQUEST['frmLoginSubmit'];
?>
<script language="javascript">
	function Validate()
	{
		var frmLoginDetails=this.document.frmLogin;
		if(frmLoginDetails.idEmail.value == "")
		{
			alert("Please enter Username / E-mail");
			frmLoginDetails.idEmail.focus();
			return false;
		}
		if(frmLoginDetails.password.value == "")
		{
			alert("Please enter Password");
			frmLoginDetails.password.focus();
			return false;
		}
	return true;
	}
</script>
<!--main table starts here-->
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
		<td width="154" background="<?=$confValues['ServerURL']?>/images/paid-model.jpg" height="204" style="padding-left:10px;"></td>
		<td background="<?=$confValues['ServerURL']?>/images/paid-bground.jpg" width="400" style="font: normal 11px verdana; color:#333333;padding-top:20px;">
			<p style="margin:0px;font: bold 20px times new roman; color:#286769;padding-left:10px;">There is no better structure founded in Islam other than marriage<br><font style="margin:0px;font: normal 16px arial; color:#146BAD;padding-left:220px;">- The Prophet of Islam (PBUH)</font></p><br>
			</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
	<tr><td colspan="2">
		<? if ($varCheckLogin==0 && $varFrmSubmit=='yes') { ?>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#E6F2D5" align="center">
			<tr><td class="registtxt1" width='100' align='center'><img src='<?=$confValues['ServerURL']?>/images/alert.gif'></td><td class="registtxt1">Invalid username or incorrect password. Make sure that the "Caps Lock" or "A" light is switched off on your keyboard before trying again.</TD></TR>
			</table>
		<? }//if?>
	</td></tr>
	<tr><td width="75%" bgcolor="#E6F2D5" class="formborderclr">
		<p style="margin:0px;padding:0px 10px 0px 10px;text-align:justify;font: normal 11px verdana; color:#333333;"><font style="font-size:12px"><b>Everyone dreams of a beautiful Nikah</b></font><br><br>Insha'Allah, a life partner with whom one can share a common way of life!<br><br>We at MuslimMatrimony.com hope to make your search easy as well as thorough. With thousands of Muslim profiles available from around the world, you can have access to the profiles of an eligible partner at the click of a button.</p>
	</td>
	<td width="25%">
	<table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" class="formborderclr" bgcolor="#E6F2D5">
	<!--form starts here-->
	<form name="frmLogin" method="post" onSubmit="return Validate();" action="facebklogin-check.php">
	<input type="hidden" name="frmLoginSubmit" value="yes">
	<input type="hidden" name="facebook" value="yes">
		<tr><td valign="top">
			<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center">
				<tr><td class="smalltxt"> Username :</td></tr>
				<tr><td align="left"><input type="text" name="idEmail" style="width: 125px;"></td></tr>
				<tr><td valign="top" class="smalltxt"> Password :</td></tr>
				<tr><td valign="top" align="left"><input type="password" name="password" style="width: 125px;"></td></tr>
				<tr>
				<td valign="top" align="center">
				<input type="hidden" name="frmLoginSubmit" value="yes"><input type="image" src="<?=$confValues['ServerURL']?>/images/login.gif" alt="" border="0" align="absmiddle"></td></tr>
			</table>
		</td></tr>
		</form>
		</table>
	</td></tr>
</table>

<SCRIPT LANGUAGE="JAVASCRIPT">
document.frmLogin.idEmail.focus();
</SCRIPT>