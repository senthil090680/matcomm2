<?php
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']); 
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
$db = new db();
$db->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ONLINESWAYAMVARAM']);
$evid=trim($_GET['evid']);
$memberid=$_COOKIE['Memberid'];
$language=getDomainInfo(1,$memberid);
$domain_language=$language["domainnameshort"];


$logout_query="update ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAM']." set Status=0 where MatriId='$memberid' and EventId=$evid";
$db->update($logout_query);
$cookieexpire = $_SERVER['SERVER_NAME'];
$cookieexpire = str_replace(array("www","bmser"),"",$cookieexpire);
setcookie("Memberid"," ",0,"/",$cookieexpire);
setcookie("password"," ",0,"/",$cookieexpire);
setcookie("Gender"," ",0,"/",$cookieexpire);

$db->dbClose();
header('Location:vmlogin_test.php?evid='.$evid.'');
?>
