<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Login
#=============================================================================================================

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/lib/clsPrivilege.php');


$objDB = new Privilege;
$objDB->dbConnect('S',$varDbInfo['DATABASE']);

//$member_id=$_COOKIE['Memberid']; 
//$gender=$_COOKIE['Gender'];
/*
if($_REQUEST['recpid']!=""){
$oppo_memid=trim(strtoupper($_REQUEST['recpid']));
$exp_memid=explode('@',$oppo_memid);
  $opposite_memid = $exp_memid[0];
}else{
$opposite_memid=$msgeb[0];
}*/

$arrProfileMatchId = array("'".$recpid."'");
$varMatriIdPrefix = substr($recpid,0,3);
$objDB->getCommunityWiseDtls($varMatriIdPrefix);
$varProfileBasicResultSet = $objDB->selectDetails($arrProfileMatchId,'1');
echo $varProfileBasicView= $objDB->getChatVMMRegularDetails('match',$varProfileBasicResultSet,'');
?>