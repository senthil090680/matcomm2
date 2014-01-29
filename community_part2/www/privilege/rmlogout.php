<?php
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

	//FILE INCLUDES
	include_once($varRootBasePath."/conf/config.cil14");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	setrawcookie("rmusername",false,time() - 36, "/",'www.'.$varDomainName);
	$_COOKIE['rmusername'] = '';
	UNSET($_COOKIE['rmusername']);
	UNSET($_COOKIE);
	
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="20"></td></tr>
	<tr>
	<td width="100%" style="padding-left:20px;">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr><td><span class="normtxt">You have successfully logged out. <a href="mainindex.php">Back to Home</a></span></td></tr>
				<tr><td height="20">&nbsp;</td></tr>
			</table>
	</td>
</table>