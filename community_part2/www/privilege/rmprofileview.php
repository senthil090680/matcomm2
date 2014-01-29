<?php ob_start();
	if($_GET['c']==1){
	$partial="show";
}

$redirect_page=base64_decode($_GET['ps']);
$domain = strstr($redirect_page, 'GOTO1');
if($domain == "GOTO1=login/myhome.php") $profile =1;
else if($domain == "GOTO1=search/search.php?RMIID=rmi") $profile =2;
else $profile =3;
include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();

include "include/rmheader.php";
include "addheader.php";

?>
<tr><td height="15" style="border-top:1px solid #cbcbcb;" colspan="10">&nbsp;</td></tr>
<tr><td colspan="10"><center>
<IFRAME border="0" width="800" height="1500" src="<?=$redirect_page?>" frameborder="0"> </IFRAME>
</center></td></tr>
</table>
<? include_once($varRootBasePath.'/www/privilege/include/mainfooter.php'); ?>