<?php

include_once "include/rmclass.php";

$varMemidRminter	= $_REQUEST['MEMID_RMINTER'];
$varMatriIdPrefix	= substr($varMemidRminter,0,3);
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];

$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
$password=$rmclass->Getmemberpassword($_COOKIE['rmusername']);
$rmclass->RMUserlog($_COOKIE['rmusername'],$varMemidRminter,'1');
if($varMemidRminter!= ''){
		$memLoginPage = 'http://www.'.$varDomainName."/privilege/rmintermediate.php?MEMID_RMINTER=".$varMemidRminter."&rmuserid=".$_COOKIE['rmusername']."&rmpass=".base64_encode($password)."";
		header("location:$memLoginPage");exit;
}

?>