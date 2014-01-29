<?php
error_reporting( E_ALL ^ E_NOTICE );
/****************************************************************************************************
File		:  Expirecron.php
Author	:  Ganesh.S
Date		:  11-Mar-2009
*****************************************************************************************************
Description	: 
	this is cron file, send the mail to partner preference member
********************************************************************************************************/
$DOCROOTBASEPATH = "/home/profilebharat/"; // for local
//$DOCROOTBASEPATH = "/home/profilebharat/"; // for live
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14";
include_once $DOCROOTBASEPATH."/bmconf/bmip.cil14";
include_once $DOCROOTBASEPATH."/bmconf/bmdbinfo.cil14";
include_once $DOCROOTBASEPATH."/bmconf/bmvars.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14"; // This includes MySQL Class details
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmmailerfunctions.cil14";

$db14slave = new db();
$db14slave->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['BMSUPPORT']);

$TodayDate=date('Y-m-d');
//Fetch the Today Expired Matriid 
echo $Sql="select MatriId from ".$DBNAME['BMSUPPORT'].".".$TABLE['BMASSISTMEMBERINFO']." where date(ExpiryDate)<='$TodayDate'";
$numrows=$db14slave->select($Sql);
echo "<br>";
while($rows=$db14slave->fetchArray()) {
	$expirematriid[]=$rows['MatriId'];		 //Format the ids like 'M224175','M22222','
}

$expirematriid = implode("','",$expirematriid);

if($numrows>=1) {
	//Today expired matriid move to BMASSISTMEMBERINFOBKUP Table
	echo $Sql="insert into ".$DBNAME['BMSUPPORT'].".".$TABLE['BMASSISTMEMBERINFOBKUP']." select * from ".$DBNAME['BMSUPPORT'].".".$TABLE['BMASSISTMEMBERINFO']." where MatriId in('".$expirematriid."')";	
	//$Query=$db14slave->insert($Sql);
	echo "<br>";
	//Delete the today expired matriid  from  BMASSISTMEMBERINFO Table
	echo $Sql="delete from ".$DBNAME['BMSUPPORT'].".".$TABLE['BMASSISTMEMBERINFO']." where MatriId in('".$expirematriid."')";	
	//$Query=$db14slave->del($Sql);
}
$db14slave->dbClose();
?>