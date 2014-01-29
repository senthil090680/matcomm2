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
include_once($varRootBasePath.'/lib/clsDB.php');
include_once "chatfunctions.php";

ini_set('display_errors',1);
error_reporting(E_ALL);

//OBJECT DECLARATION
$objSlave = new DB;

//DB CONNECTION
$objSlave-> dbConnection('192.168.1.11','fireuser','firepass','openfire');

$evid=100;

/*$qry="select distinct(fromUsername) as SenderId from ".$varOnlineSwayamvaramOpenfireDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE'];
$result = $objSlave->ExecuteQryResult($qry,0);
while($value  = mysql_fetch_assoc($result)){
    echo "<br><font  class='normaltxt1' style='color:#F06600'><B>Memberid : ".$memberid = $value['SenderId'];
	echo "</B></font><br>==========================<br>";
	$receive_memsql="select distinct(toUsername) as receiver from ".$varOnlineSwayamvaramOpenfireDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where fromUsername='$memberid' and eventID=$evid and toUsername in (SELECT fromUsername FROM ".$varOnlineSwayamvaramOpenfireDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." WHERE toUsername='$memberid')";
    $resultarr = $objSlave->ExecuteQryResult($receive_memsql,1);
	foreach($resultarr as $key=>$value){
	$receiverid = $value;
	

			$receive_sql="select fromUsername as SenderId,toUsername as ReceiverId,message as ChatMessages from ".$varOnlineSwayamvaramOpenfireDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where (fromUsername='$memberid' and toUsername='$receiverid') or (toUsername='$memberid' and fromUsername='$receiverid') and eventID=".$evid." order by chatDate";
			$resultset = $objSlave->ExecuteQryResult($receive_sql,0);
            $content='';
			while($values = mysql_fetch_assoc($resultset)){
				
				$SenderId       = $values['SenderId'];
				$ReceiverId     = $values['ReceiverId'];
				$ChatMessages   = $values['ChatMessages'];

				if($SenderId == $memberid)
				{
					$Id = "<font  class='normaltxt1' style='color:#F06600'><B>".$SenderId."</B> :</font>";
				}
				else if($ReceiverId == $memberid)
				{
					$Id = "<font  class='normaltxt1' style='color:#006600'><B>".$SenderId."</B> :</font>";
				}
				    $content.=$Id."<font  class='normaltxt1' style='color:#000000'>".$ChatMessages."</font><br>";
			}
			echo $content;

    }
	
}*/
$qry="select distinct(fromUsername) as SenderId from ".$varOnlineSwayamvaramOpenfireDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE'];
$result = $objSlave->ExecuteQryResult($qry,0);
while($value  = mysql_fetch_assoc($result)){
    echo "<br><br>".$memberid = $value['SenderId'];
	$receiverid = $value['SenderId'];
	echo "<br>";
	
	

			$receive_sql="select fromUsername as SenderId,toUsername as ReceiverId,message as ChatMessages from ".$varOnlineSwayamvaramOpenfireDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where (fromUsername='$memberid' or toUsername='$receiverid') and eventID=".$evid." order by chatDate";
			$resultset = $objSlave->ExecuteQryResult($receive_sql,0);
            $content='';
			while($values = mysql_fetch_assoc($resultset)){
				
				$SenderId       = $values['SenderId'];
				$ReceiverId     = $values['ReceiverId'];
				$ChatMessages   = $values['ChatMessages'];

				if($SenderId == $memberid)
				{
					$Id = "<font  class='normaltxt1' style='color:#F06600'><B>".$SenderId."</B> :</font>";
				}
				else if($ReceiverId == $memberid)
				{
					$Id = "<font  class='normaltxt1' style='color:#006600'><B>".$SenderId."</B> :</font>";
				}
				    $content.=$Id."<font  class='normaltxt1' style='color:#000000'>".$ChatMessages."</font><br>";
			}
			echo $content;

   
	
}
