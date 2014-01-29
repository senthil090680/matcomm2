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
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

$evid=trim($_REQUEST['evid']);
//OBJECT DECLARATION
$objSlave = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);


function fle_decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);
	for($i=0; $i<strlen($string); $i++) {
	 $char = substr($string, $i, 1);
	 $keychar = substr($key, ($i % strlen($key))-1, 1);
	 $char = chr(ord($char)-ord($keychar));
	 $result.=$char;
	}
	return $result;
}
$red_val=$_GET['mem'];
$opp_id = $_GET['Toid'];
$memberid=$red_val;//fle_decrypt($red_val,'ec3hk4bo1u6n4ce19');
$receiverid=$opp_id;


$receive_memsql="select fromUsername as SenderId,toUsername as ReceiverId,message as ChatMessages from ".$varOnlineSwayamvaramDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where (fromUsername='$memberid' and toUsername='$receiverid') or (toUsername='$memberid' and fromUsername='$receiverid') and eventID=".$evid." order by chatDate";
$result = $objSlave->ExecuteQryResult($receive_memsql,0);

while($value = mysql_fetch_assoc($result)){
	
	$SenderId       = $value['SenderId'];
	$ReceiverId     = $value['ReceiverId'];
	$ChatMessages   = $value['ChatMessages'];

	if($SenderId == $memberid)
	{
		$Id = "<font  class='normtxt clr1 bld'>".$SenderId." :</font>";
	}
	else if($ReceiverId == $memberid)
	{
		$Id = "<font  class='normtxt clr1 bld'>".$SenderId." :</font>";
	}
	echo $Id."<font  class='normtxt clr'>".$ChatMessages."</font><br>";
}
$objSlave->dbClose();
?>