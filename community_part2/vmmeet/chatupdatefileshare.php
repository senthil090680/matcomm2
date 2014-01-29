<?php

include_once "chatfunctions.php";
$from_id = $_GET["Sender_Id"];
$to_id = $_GET["Receiver_Id"];
$evid = $_GET["evid"];
$message = urldecode($_GET["mess"]);
//authenication of url
if($_GET)
	write_chat_mesg($from_id,$to_id,$message,$evid);

echo "1".$message;
?>