<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Chat Functions
#=============================================================================================================

function get_event_info($evid) {
	global $objSlave,$varOnlineSwayamvaramDbInfo,$varTable;
	
	$varCondition		= " where EventId=$evid";
    $varFields			=  array("EventId","EventTitle","EventReligion","EventDate","DATE_FORMAT(EventDate,'%D %M %Y')","TIME_FORMAT(EventStartTime,'%l' '%p')","TIME_FORMAT(EventEndTime,'%l' '%p')","EventCaste","EventStatus","DATEDIFF(EventDate,now())","EventEndTime","DATE_FORMAT(EventOpenDate,'%D %M %Y')","DATE_FORMAT(EventCLoseDate,'%D %M %Y')","EventDate","DATE_FORMAT(EventDate,'%d/%m/%Y')","TIME_FORMAT(EventStartTime,'%h/%i/%s')","TIME_FORMAT(EventEndTime,'%h/%i/%s')","EventLanguage","INR_Rate","USD_Rate","AED_Rate","EURO_Rate","GBP_Rate","Jabberip","bindurl","EventStatus","EventCloseDate");
    $varConfDet	    = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields,$varCondition,1);

	//print_r($objSlave);

	if (count($varConfDet) > 0) {
        $row['EventId']			= $varConfDet[0]['EventId'];
		$row['EventTitle']		= $varConfDet[0]['EventTitle'];
		$row['EventReligion']	= $varConfDet[0]['EventReligion'];
		$row['evt_date']		= $varConfDet[0]['EventDate'];
		$row['evt_closedate']	= $varConfDet[0]['EventCloseDate'];
		$row['event_date']		= $varConfDet[0]["DATE_FORMAT(EventDate,'%D %M %Y')"];
		$row['event_starttime']	= $varConfDet[0]["TIME_FORMAT(EventStartTime,'%l' '%p')"];
		$row['event_endtime']   = $varConfDet[0]["TIME_FORMAT(EventEndTime,'%l' '%p')"];
		$row['EventCaste']		= $varConfDet[0]['EventCaste'];
		$row['EventStatus']		= $varConfDet[0]['EventStatus'];
		$row['diffdate']		= $varConfDet[0]['DATEDIFF(EventDate,now())'];
		$row['EventEndTime']	= $varConfDet[0]['EventEndTime'];
		$row['event_opendate']	= $varConfDet[0]["DATE_FORMAT(EventOpenDate,'%D %M %Y')"];
		$row['event_closedate'] = $varConfDet[0]["DATE_FORMAT(EventCLoseDate,'%D %M %Y')"];
		$row['EventDate']		= $varConfDet[0]['EventDate'];
		$row['EvtDate']			= $varConfDet[0]["DATE_FORMAT(EventDate,'%d/%m/%Y')"];
		$row['EvtStartTime']	= $varConfDet[0]["TIME_FORMAT(EventStartTime,'%h/%i/%s')"];
		$row['EvtEndTime']		= $varConfDet[0]["TIME_FORMAT(EventEndTime,'%h/%i/%s')"];
		$row['EventLanguage']	= $varConfDet[0]['EventLanguage'];
		$row['EventStatus']	    = $varConfDet[0]['EventStatus'];
		$row['INR_Rate']		= $varConfDet[0]['INR_Rate'];
		$row['USD_Rate']		= $varConfDet[0]['USD_Rate'];
		$row['AED_Rate']		= $varConfDet[0]['AED_Rate'];
		$row['EURO_Rate']		= $varConfDet[0]['EURO_Rate'];
		$row['GBP_Rate']		= $varConfDet[0]['GBP_Rate'];
		$row['Jabberip']		= $varConfDet[0]['Jabberip'];
		$row['bindurl']			= $varConfDet[0]['bindurl'];
		return $row;
	} else {
		return '';
	}
}

/*Write Messages Funtion*/
/*function write_chat_mesg($from,$to,$msgs,$evid){
global $db,$DBNAME,$TABLE;
$insert_sql="insert into ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATLOG']." (EventId,SenderId,ReceiverId,ChatMessages,ChatLogTime) Values ('$evid','$from','$to','$msgs',now())";
$db->insert($insert_sql);
$arcinsert_sql="insert into ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMARCHIVELOG']." (EventId,SenderId,ReceiverId,ChatMessages,ChatLogTime) Values ('$evid','$from','$to','$msgs',now())";
$db->insert($arcinsert_sql);
}*/


/*Read Messages Funtion*/
/*function read_chat_mesg($to,$evid){
global $db,$DBNAME,$TABLE;
$value="";
$sel_sql="select LogId,SenderId,ChatMessages from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATLOG']." where  ReceiverId='$to' and EventId=$evid order by LogId";
$db->select($sel_sql);
while($sel_res=$db->fetchArray()){
	if($value != "")
		$value.= "#~#";
    $value.=$sel_res['SenderId']."~".$sel_res['ChatMessages'];
$del_sql="delete from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATLOG']." where LogId=".$sel_res['LogId']." and EventId=$evid";
$db->del($del_sql);
}
return $value;
}*/

/*Read Blocked Ids*/
/*function read_block_mesg($to,$evid){
global $db,$DBNAME,$TABLE;
$value="";
$bl_sql="select SenderId from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." where  ReceiverId='$to' and  BlockStatus=1 and EventId=$evid";
$db->select($bl_sql);
while($bl_res=$db->fetchArray()){
	if($value != "")
		$value.= "/";
    $value.=$bl_res['SenderId'];
}
return $value;
}*/

/*Read Blocked Ids*/
/*function read_close_mesg($to,$evid){
global $db,$DBNAME,$TABLE;
$value="";
$cl_sql="select SenderId from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." where  ReceiverId='$to' and CloseStatus=1 and EventId=$evid";
$db->select($cl_sql);
while($cl_res=$db->fetchArray()){
	if($value != "")
		$value.= "/";
    $value.=$cl_res['SenderId'];
}
return $value;
}*/

/*Block Messages Funtion*/
/*function block_chat_member($from,$to,$evid){
global $db,$DBNAME,$TABLE;
$block_sql="insert into ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." (SenderId,ReceiverId,BlockStatus,EventId,BlockDate) Values ('$from','$to','1',$evid,now()) ON DUPLICATE KEY UPDATE BlockStatus=1,BlockDate=now()";
$db->insert($block_sql);
}*/
/*Close Chat Window*/
/*function close_chat_member($from,$to,$evid){
global $db,$DBNAME,$TABLE;
$cl_sql="insert into ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." (SenderId,ReceiverId,CloseStatus,EventId,CloseDate) Values ('$from','$to',1,$evid,now()) ON DUPLICATE KEY UPDATE CloseStatus=1,CloseDate=now()";
$db->insert($cl_sql);
}*/
/*UnBlock Messages Funtion*/
/*function unblock_chat_member($from,$to,$evid){
global $db,$DBNAME,$TABLE;
$unblock_sql="Update ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." set BlockStatus=0 where SenderId='$from' and ReceiverId='$to' and EventId=$evid";
$db->update($unblock_sql);
}*/

/*UnClose Messages Funtion*/
/*function unclose_chat_member($from,$to,$evid){
global $db,$DBNAME,$TABLE;
$unclose_sql="Update ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." set CloseStatus=0 where CloseStatus=1 and EventId=$evid and (SenderId='$from' and ReceiverId='$to') or (SenderId='$to' and ReceiverId='$from')";
$db->update($unclose_sql);
}*/

/*function read_unblock_mesg($to,$evid){
global $db,$DBNAME,$TABLE;
$ulvalue="";
$ulbl_sql="select SenderId from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." where  ReceiverId='$to' and  BlockStatus=0 and EventId=$evid";
$db->select($ulbl_sql);
while($ulbl_res=$db->fetchArray()){
	if($ulvalue != "")
		$ulvalue.= "/";
    $ulvalue.=$ulbl_res['SenderId'];
}
return $ulvalue;
}*/

?>