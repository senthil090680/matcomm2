<?php

include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();
$rmclass->rmConnect();
include_once "include/rmuserheader.php";

$varActFields	= array("Email");
$varActCondtn	= " where MatriId='".$_REQUEST['MEMID_RMINTER']."'";
$rows		= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMATRIUSERCONTACT'],$varActFields,$varActCondtn,1);

$mailid = $rows[0]['Email'];
if($mailid==""){

	$varActFields	= array("Email");
	$varActCondtn	= " where MatriId='".$_REQUEST['MEMID_RMINTER']."'";
	$rows		= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'],$varActFields,$varActCondtn,1);
	$mailid = $rows[0]['Email'];
}
$varActFields	= array("Email");
$varActCondtn	= " where RMUserid='".$_COOKIE['rmusername']."'";
$loginrow		= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
$rmmailid = $loginrow[0]['Email'];


 if(isset($_REQUEST['do_submit'])){ 
	$photoname = $_FILES["PHOTO1"]["name"];
	if($_FILES["PHOTO1"]["name"] != ''){
		$filepaths1 = "/home/product/community/www/privilege/uploads/";
		$filepaths2 = $_FILES["PHOTO1"]["tmp_name"];
		$attachfilepath=time()."_".$_FILES["PHOTO1"]["name"];
		$photo_error = $_FILES["PHOTO1"]["error"];
			if($photo_error==1){
				$errormsg = "Over Limit.";
			}else{
			  if(move_uploaded_file($_FILES["PHOTO1"]["tmp_name"],$filepaths1.$attachfilepath)){
					chmod($filepaths1.$attachfilepath,0777); 
 					$fileformat =$filepaths1.$attachfilepath;
					$fromId = 'info@communitymatrimony.com <info@communitymatrimony.com>';
			 		$toId = $_POST['toid'];
					$ccId = '';
					$replyid = $rmmailid;
					$subject = mysql_real_escape_string($_POST['subject']);
					$message =mysql_real_escape_string($_POST['message']);
					$attachment_array[] = $fileformat;
					$message=nl2br($message);
					$message=str_replace('\r\n','',$message);
					$errormsg = send_report_mail($fromId, $toId, $ccId, $subject, $message, $replyid,$attachment_array);
					$errormsg = "The mail was successfully sent to ".$_POST['toid']."! \r\n"; 
				}
			}
	  }else {
 		  $HEADERS = "MIME-Version: 1.0\n";
		  $HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
		  $HEADERS .= "From: info@communitymatrimony.com <info@communitymatrimony.com>\n";
		  $HEADERS .= "Reply-To: ".$rmmailid."\n";
		  $toId = $_POST['toid'];
		  $subject = mysql_real_escape_string($_POST['subject']);
		  $_POST['message'] = nl2br($_POST['message']);
		  $message = mysql_real_escape_string($_POST['message']);
		  $message=str_replace('\r\n','',$message);
		  
          //$toId="bmtest01@gmail.com";
		  if(mail($toId,$subject,$message,$HEADERS))
			  $errormsg = "The mail was successfully1 sent to $toId! \r\n"; 
		  else 
			  $errormsg = "Sorry! But the email could not be sent to $toId! \r\n";
	}
	
	$varInsertFields	= array("RMUserid","MatriId","ToId","Subject","Message","AttachFile","TimeCreated");
	$varInsertVal	= array("'".$_COOKIE['rmusername']."'","'".$_POST['usrmatriid']."'","'".$_POST['toid']."'","'".$subject."'","'".$message."'","'".mysql_real_escape_string($attachfilepath)."'",'NOW()');
	$insertedid = $rmclass->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMAIL'], $varInsertFields, $varInsertVal);


	$errormsg = "The mail was successfully sent to ".$_POST['toid']."! \r\n"; 
}


function send_report_mail($fromId, $toId, $ccId, $subject, $message, $replyid, $attachment_array) {
	$email_from = $fromId; // Who the email is from 
	$email_subject = $subject; // The Subject of the email 
	$email_txt = $message; // Message that the email has in it 
	$email_to = $toId; // Who the email is too 
	$email_cc = $ccId;
	$email_reply = $replyid;
	$headers  = "From: ".$email_from."\n"; 
	$headers .= "Cc: ".$email_cc."\n"; 
	$headers .= "Reply-To: ".$email_reply."\n";
	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	$headers .= "MIME-Version: 1.0\n" . 
	"Content-Type: multipart/mixed;\n" . 
	" boundary=\"{$mime_boundary}\""; 
	$email_message = "";
	$email_message .= $email_txt."\n\n";
	$email_message .= "This is a multi-part message in MIME format.\n\n" . 
	"--{$mime_boundary}\n" . 
	"Content-Type:text/html; charset=\"iso-8859-1\"\n" . 
	"Content-Transfer-Encoding: 7bit\n\n" . 
	$email_message . "\n\n"; 
	foreach($attachment_array as $filename){
		$fileatt = $filename; // Path to the file 
		$fileatt_type = "application/octet-stream"; // File Type 
		$fileatt_name = $filename; // Filename that will be used for the file as the attachment 
		$file = fopen($fileatt,'rb'); 
		$data = fread($file,filesize($fileatt)); 
		fclose($file); 
		$data = chunk_split(base64_encode($data)); 
		$fileatt_name=str_replace('/home/product/community/www/privilege/uploads/','',$fileatt_name);
        $email_message .= "--{$mime_boundary}\n" . 
		"Content-Type: {$fileatt_type};" . 
		" name=\"{$fileatt_name}\"\n" . 
  		"Content-Transfer-Encoding: base64\n\n" . 
		$data . "\n\n";
 	}
	$email_message .="--{$mime_boundary}--\n\n";
	//$email_to="bmtest01@gmail.com";
	$ok = @mail($email_to, $email_subject, $email_message, $headers); 
	if($ok) { 
		$RET = "The mail was successfully sent to $toId! \r\n"; 
	} else 	{ 
		$RET = "Sorry! But the email could not be sent to $toId! \r\n";
	} 
	return $RET; 
}
$rmclass->CloseDB();
?>
<script>
function validateFile(){
	//document.getElementById("errormsgs").innerHTML="";
 	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = document.mailform.toid.value;
	if(reg.test(address) == false) {
	   alert('Invalid Email Address');
	   document.mailform.toid.focus();
	   return false;
	}
	if(document.mailform.subject.value==""){
		alert("Please Give Subject");
		document.mailform.subject.focus();
		return false;
	}
	if(document.mailform.message.value==""){
		alert("Please Give Message");
		document.mailform.message.focus();
		return false;
	}
	
}
</script>
<!--Middle Area Start-->		
<form method="post" name="mailform" action="mainindex.php?act=rmsendmail&MEMID_RMINTER=<?=$_REQUEST['MEMID_RMINTER']?>&val=1&p=<?=$_REQUEST['p']?>" enctype ="multipart/form-data" onsubmit="return validateFile();"> 
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" >
			<tr>
			<td width="100%" style="padding-left:20px;"> 
				<table border="0" cellpadding="0" cellspacing="0" align="left" width="97%" >
					<tr><td colspan="4" height="20"></td></tr>
						<tr>
							   <td align="left" height="30" colspan="4"><span class="normtxt1 bld">Would you like to send a message to <?=$msgname?>? </span></td>
					    </tr>
						<tr>
							   <td align="left" height="30" colspan="4"><span class="normtxt">Please type your message in the form below and click "Send". </span></td>
					    </tr>
						<tr><td colspan="4" height="10"></td></tr>
						<? if($errormsg != ''){?>
							<tr>							 
								 <td colspan="4" style="padding:10px;border:1px solid #A196BF" align="center"><span class="normtxt clr3 bld"><?=$errormsg?></span><br><br>&nbsp;
								 <a href="mainindex.php?act=rmsendmail&MEMID_RMINTER=<?=$_REQUEST['MEMID_RMINTER']?>&val=1&p=<?=$_REQUEST['p']?>"  class="normtxt1 clr1">Back to Send Mail</td>
							</tr>
							<tr>
								<td height="30">&nbsp;</td>
							</tr>
						<? }else{ ?>
						<tr>
								<td height="25" width="20%" align="right" style="padding-right:10px;"><span class="normtxt"><b>To Id</b></span></td>
								 <td width="50%"><span class="normtxt"><?if($mailid!=""){echo $mailid;}else{echo "<span class='normtxt clr3'>E-Mail Address Not Available</span>";}?><input type="hidden" name="toid" value="<?=$mailid?>" class="inputtext"></span></td>
						</tr>
						 <tr>
									<td height="30" style="padding-right:10px;" align="right"><span class="normtxt"><b>Subject&nbsp;:</b></span></td>
									<td><span class="normtxt"><input type="text" name="subject" class="inputtext"></span></td>
						</tr>
						<tr>
									<td style="padding-right:10px;" align="right"><span class="normtxt"><b>Message&nbsp;:</b></span></td>
									<td ><span class="normtxt">
									<TEXTAREA name="message" ROWS="10" COLS="35" ></TEXTAREA></span></td>
						</tr>
						<tr><td colspan="4" height="15"></td></tr>
						<tr >
									<td  colspan="2" width="100%" style="border:1px solid #A196BF"><div class="normtxt" style="padding: 5px;" id="attach">Click on <a href="#" onclick="javascript:hide('1')" class="clr1"><b>"Attachments"</b></a> if you would like to attach a file</div></td>
 						</tr>
						<tr><td colspan="2" style="border:1px solid #A196BF"><table id="attachhere" style="display:none">
							
						<tr>
									<td colspan="2" style="padding:5px 10px;"><span class="normtxt">(Click Add attach your selected file to the message)
									</span></td>
 						</tr>
						<input type="hidden" name="usrmatriid" value="<?=$_REQUEST['MEMID_RMINTER'];?>">
						<tr >
									<td width="25%" align="right" style="padding-right:10px;" ><span class="normtxt"><b>File&nbsp;:</b></span></td>
									<td width="60%"><span class="normtxt">
									<input type="file" name="PHOTO1" ></span></td>
									<td width="10%" ><span class="normtxt"><a href="#" onclick="javascript:hide('2')" class="clr1"><b>Hide</b></a></span></td>
						</tr>
						</table>
						</td></tr>
							<tr><td></td><td style="padding-top:25px;"><div class="fleft" style="padding-right:5px;"><input type="Submit" name="do_submit" value="Send" class="button" <?if($mailid==""){echo "disabled";}?>></div><div class="fleft"><input type="reset" name="cancel" value="Reset" class="button"></div></td></tr>
							<tr>
							 <td height="30">&nbsp;</td>
						</tr>
						<?}?>
				</table>	
			</td>
		</table>
	</td>
</tr>
</Form>
<script> function hide(value){ 
							if(value ==1){
								document.getElementById("attach").style.display='none';
								document.getElementById("attachhere").style.display='block';
							}
							if(value ==2){document.getElementById("attachhere").style.display='none';
								document.getElementById("attach").style.display='block';
								
							}
						}
							</script>