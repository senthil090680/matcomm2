<?
/* ************************************************************************************************** */
/* File		: horoloadstatesmatch.php
/* Author	: Mano Emerson
/* Date		: 10-Dec-2007
/* MasterSlave Modification By : Hameed.J (16-12-2007)
/* ************************************************************************************************** */
/* Description	: 
/*     This file is used populate the states from the db
/* ************************************************************************************************** */
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14"; // This includes MySQL Class details
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14"; // This includes all common functions
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14";

$sn = $_REQUEST["statename"];
$sn = str_replace('***',' & ',$sn);
$db1 = new db(); // For Slave Connection...
if (isset($_REQUEST["ID"]) && $_REQUEST["ID"]!="") {
	$memid = $_REQUEST["ID"];
	$domainarr = getDomainInfo(1,$memid);
	$domainlang = strtoupper($domainarr["domainnameshort"]);
	$db1->dbConnById(2,$memid,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	if(!$db1->error){
	$sqlhoroindianstatetbl = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[$domainlang]['HOROINDIANSTATES'];
	$sql = "select StateId,StateName from ".$sqlhoroindianstatetbl;
	$res = $db1->select($sql);
	$options = ""; 
	
	while ($row = $db1->fetchArray() ) {
		if ( $row['StateName'] == $sn ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}

		$options .= "<option value=\"".$row['StateId']."\" ".$selected.">".$row['StateName']."</option>";
	}
	echo $options;
}
else{
?>
  <div class="smalltxt" style="margin-left:5px;">
    <div class="mediumtxt1 boldtxt" style="padding-left:25px;padding-right:10px;"><?=$ERRORMSG?></div>
  </div>
<?php
}
}
 $db1->dbClose(); // Slave Connection Closed Here...
?>