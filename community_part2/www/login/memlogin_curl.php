<?php

// INCLUDES //
include_once("/home/product/community/conf/dbinfo.cil14");
include_once("/home/product/community/lib/clsDB.php");
include_once('/home/product/community/lib/sphinxapi.php');
include_once('/home/product/community/conf/sphinxclass.cil14');
include_once("/home/product/community/conf/sphinxgenericfunction.cil14");
include_once("/home/product/community/lib/clsCache.php");

if($argv[1] != '') {$varCommunityId	= trim($argv[1]);}
if($argv[2] != '') {$varMatriId	= trim($argv[2]);}
if($argv[3] != '') {$varGender	= trim($argv[3]);}
if($argv[4] != '') {$varIP	= trim($argv[4]);}
$varCurrentDate = date('Y-m-d H:i:s');

$POSTURL= "http://".$varIP.":9090/plugins/multipledomainmessenger/mdinterface?";
//$POSTURL= "http://messenger.communitymatrimony.com/plugins/multipledomainmessenger/mdinterface?";
$POSTVARS="type=login&domainname=".$varCommunityId."&username=".ucfirst($varMatriId)."&gender=".$varGender;

$ch="";
$ch = curl_init($POSTURL);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTVARS);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
$login = curl_exec($ch);

// POWERPACKSTATUS SET TO '1' IN MEMBERINFO TABLE
$objMasterDB	= new DB;
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
$argFields		= array('PowerPackStatus','Last_Login');
$argFieldsValue = array('1',"'".$varCurrentDate."'");
$argCondition	= " MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
$objMasterDB->update($varTable['MEMBERINFO'], $argFields, $argFieldsValue, $argCondition);
$objMasterDB->dbClose();


//UPDATE STATUS TP SPHINX TABLE
if(Cache::getData('SPHX_ROTATEINDEX_ON')=='') {
$varTime			= strtotime($varCurrentDate);
$arrFields			= array('OnlineStatus','Last_Login');
$arrFieldsValues	= array('1',$varTime);
$varGender			= ($varGender=='M') ? 1 : 2;
$varIndexName		= 'sphinxmemberinfo_'.$varCommunityId.'_'.$varGender;
fnUpdateSphinx($varMatriId,$varIndexName,$arrFields,$arrFieldsValues);
}
?>