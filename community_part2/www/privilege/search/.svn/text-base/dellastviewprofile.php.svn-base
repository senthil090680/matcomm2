<?php
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";

if($COOKIEINFO['LOGININFO']['MEMBERID']!="" && $_POST['chk_val']!="") {
	$matrid=split("~",$_POST['chk_val']);
	$succ=clearRecentViewedFromDb($matrid);	
	echo $succ;
	exit;
} 

function clearRecentViewedFromDb($matrid) {
	global $data,$DOMAINTABLE,$DBINFO,$DBNAME,$COOKIEINFO,$ERRORMSG,$GETDOMAININFO;	
	$db_mas = new db;
	$db_mas->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],"M",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	foreach($matrid as $matid) {
		if($matid!="") {
			$ins_sql = "insert into ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['VIEWHISTORYARCHIVE']." select MatriId, ViewerId, DateViewed FROM ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['VIEWHISTORY']." where MatriId='".$matid."' and  ViewerId ='".$COOKIEINFO['LOGININFO']['MEMBERID']."'"; 
			$db_mas->insert($ins_sql);
			$sqlDelete="delete from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['VIEWHISTORY']." where MatriId='".$matid."' and  ViewerId ='".$COOKIEINFO['LOGININFO']['MEMBERID']."'";	
			$db_mas->del($sqlDelete);
			$suc="s";
		}
	}
	$db_mas->dbClose();	
	return $suc;
}
?>