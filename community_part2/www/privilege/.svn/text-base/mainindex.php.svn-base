<?php
#==========================================================================================================
# Author 		: Dhanapal, Srinivasan
# Date	        : 01 Jan 2010
# Project		: Community Matrimony RM Interface
# Filename		: rmheader.php
#==========================================================================================================
# Description   : Main
#==========================================================================================================

//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';	
include_once($varRootBasePath.'/conf/config.cil14');
$varAct			= $_REQUEST["act"];

if ($varAct=='rmlogout') { 
	$_COOKIE['rmusername'] = '';
	setrawcookie("rmusername",false,time() - 36, "/",'www.'.$varDomainName);
	setrawcookie("rmusername", false,time() - 36);
	UNSET($_COOKIE['rmusername']);

 }
 
$sessRMUsername	= $_COOKIE['rmusername'];

if ($varAct=='rmlogincheck'){ include_once('rmlogincheck.php');}
if ($varAct=='' && $sessRMUsername=='') { $varAct='login'; }
if ($varAct=='' && $sessRMUsername!='') { $varAct='rmhome'; }

include_once($varRootBasePath.'/www/privilege/include/mainheader.php');

if($varAct != "") {

	$varAct	= preg_replace("'\.\./'", '', $varAct);
	if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
	else{ include_once('login.php'); }
}else{ include_once('login.php'); }

include_once($varRootBasePath.'/www/privilege/include/mainfooter.php');
?>
</form>
</body>
</html>
