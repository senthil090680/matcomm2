<?php
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvars.inc");
$body="err_msg : ".$_REQUEST['err_msg']." e : ".$_REQUEST['e'];
mail("andal.venkat@gmail.com,tosaravanan@gmail.com", "Search Error", "\n\nDomain: ".$GETDOMAININFO['domainnameshort']."\n\n Error: ".$body."\n\n User IP: ".$_SERVER['REMOTE_ADDR']."\n\n Date: ".date("l dS of F Y h:i:s A"));
exit;
?>