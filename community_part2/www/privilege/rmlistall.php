<?php

include_once "include/rmclass.php";

$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();

$varMatriId			= $_REQUEST['MEMID_RMINTER'];
$rmclass->RMUserlog($_COOKIE['rmusername'],$varMatriId,'2');
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];

if($varMatriId!= ''){

	$varActFields	= array("Password");
	$varActCondtn	= " where MatriId=".$rmclass->slave->doEscapeString($varMatriId,$rmclass->slave);
	$loginrow		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'],$varActFields,$varActCondtn,1);
	$password	= $loginrow[0]['Password'];
	$rmclass->dbClose();

	$memLoginPage = 'http://www.'.$varDomainName."/privilege/rmintermediate.php?MEMID_RMINTER=".$varMatriId."&rmuserid=".$_COOKIE['rmusername']."&rmpass='".base64_encode($password)."'&path=list/rmindex.php?listtype=SL&MEMID_RMINTER=".$_REQUEST['MEMID_RMINTER'];
	header("location:$memLoginPage");

}

?>