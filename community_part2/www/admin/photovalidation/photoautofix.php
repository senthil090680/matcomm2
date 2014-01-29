<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varPath		= "/home/product/community/www/brightness_backup/";
include_once($varRootBasePath.'/conf/basefunctions.inc');
$varSourcePath	= $varPath.$_REQUEST['imagename'];

$varAutofixCommand = "autolevel -c luminance ".$varSourcePath." ".$varSourcePath;

$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
escapeexec($varAutofixCommand,$varlogFile);
?>