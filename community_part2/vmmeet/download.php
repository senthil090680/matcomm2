<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/domainlist.inc");

$varFileName	= $_GET['f'];
$varMatriIdPre	= substr($varFileName, 0, 3);
$varFoldername	= $arrFolderNames[$varMatriIdPre];
$varFullPath	= $varRootBasePath.'/www/vmmeet/uploads/'.$varFoldername.'/'.$varFileName;
//set headers
if(file_exists($varFullPath)) 
{
	$arrFileinfo	= split('\.', $varFileName);
	header("Content-Type: ". $arrFileinfo[1]);
	header("Content-Length: ". filesize($varFullPath));
	header("Content-Disposition: attachment; filename=\"".$varFileName."\"");
	readfile($varFullPath);
}else{	echo 'Not allowed to download.';}
?>