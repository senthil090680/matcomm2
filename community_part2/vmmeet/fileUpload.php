<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/domainlist.inc");

$varFileName	= $_POST['name'];
$varMatriIdPre	= substr($varFileName, 0, 3);
$varFoldername	= $arrFolderNames[$varMatriIdPre];
if($varFoldername != '') 
{
	$varFileName = 'uploads/'.$varFoldername.'/'.$varFileName;
	move_uploaded_file($_FILES['file']['tmp_name'], $varFileName);
}