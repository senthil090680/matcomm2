<?php
include_once "chatfunctions.php";
$sourceid=trim($_REQUEST['memid']);
$send_msg=mysql_escape_string(trim($_REQUEST['send_msg']));
$ini_chat=trim($_REQUEST['ini_chat']);
$quit_msg=trim($_REQUEST['quit_chat']);
$block_msg=trim($_REQUEST['block_chat']);
$unblock_msg=trim($_REQUEST['unblock_chat']);
$evid=trim($_REQUEST['evid']);

if($send_msg!=""){
$send_msge=explode("#~#",$send_msg);
foreach ($send_msge as $msg)
	{
    list($to_id,$msg)=explode("~",$msg);
    write_chat_mesg($sourceid,$to_id,$msg,$evid);
    }
}

if($block_msg!=""){
$block_msge=explode("/",$block_msg);
foreach ($block_msge as $blk)
	{
    block_chat_member($sourceid,$blk,$evid);
    }
}

if($unblock_msg!=""){
$unblock_msge=explode("/",$unblock_msg);
foreach ($unblock_msge as $unblk)
	{
    unblock_chat_member($sourceid,$unblk,$evid);
    }
}

if($quit_msg!=""){
$quit_msge=explode("/",$quit_msg);
foreach ($quit_msge as $cls)
	{
    close_chat_member($sourceid,$cls,$evid);
    }
}

$blockid=read_block_mesg($sourceid,$evid);
$closeid=read_close_mesg($sourceid,$evid);
$read_message=read_chat_mesg($sourceid,$evid);
$unblockid=read_unblock_mesg($sourceid,$evid);
echo $blockid."#*#".$closeid."#*#".$read_message."#*#".$unblockid;

?>