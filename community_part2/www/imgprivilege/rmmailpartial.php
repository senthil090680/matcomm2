<?php
 
include_once "include/rmclass.php";

$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();

$varMatriId			= $_REQUEST['MEMID'];
//$rmclass->RMUserlog($_COOKIE['rmusername'],$varMatriId,'2');
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];

if($_REQUEST['MEMID']!= ''){

	$varActFields	= array("Password");
	$varActCondtn	= " where MatriId='".$_REQUEST['MEMID']."'";
	$loginrow		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'],$varActFields,$varActCondtn,1);
	$password	= $loginrow[0]['Password'];
	$rmclass->dbClose();

	$memLoginPage = 'http://image.'.$varDomainName."/privilege/rmintermediate.php?MEMID_RMINTER=".$_REQUEST['MEMID']."&rmuserid=".$_COOKIE['rmusername']."&img_path=1&rmpass='".base64_encode($password)."'&path=search/rmindex.php?RMIID=rmi";
	header("location:$memLoginPage");

}

?>