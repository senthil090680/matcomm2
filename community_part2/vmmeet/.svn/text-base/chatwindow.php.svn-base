<?php
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/domainlist.inc");
include_once($varRootBasePath.'/conf/vars.inc');

$evid		= $_GET['evid'];
$member_id	= strtoupper(strtolower(trim($_COOKIE['Memberid'])));
$gender		= $_COOKIE['Gender'];
$myid		= $member_id;
$_GET['recpid'] = fle_decrypt($_GET['recpid'],'ec3hk4bo1u6n4ce19');
$recpid		= strtoupper(strtolower(trim($_GET['recpid'])));

if($member_id == ''){
	header("Location: http://meet.communitymatrimony.com/vmlogin.php?evid=".$evid);
}

$varMatriIdPrefix	= substr($recpid, 0, 3);
$domain_value		= $arrPrefixDomainList[$varMatriIdPrefix];
$foldername			= $arrFolderNames[$varMatriIdPrefix];
$domain_imgpath     = 'http://img.'.$domain_value.'/images';


$upload_dir = "uploads/";
if(isset($_POST['fileframe'])) 
{
	$result		= 'ERROR';
	if (isset($_FILES['file'])){
		if ($_FILES['file']['error']==UPLOAD_ERR_OK && $_FILES['file']['size']<=2097152){
			$filename		= $_FILES['file']['name'];
			$varFileName	= $member_id.'_'.time().'_'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir.$varFileName);
			$result		= 'OK';
			//Moving to Image server
			$varCurlObj = curl_init();
			$varfileloc = $varRootBasePath.'/www/'.$upload_dir.$varFileName;
			$arrPost    = array('name'=>$varFileName, 'file'=>'@'.$varfileloc);
			curl_setopt($varCurlObj, CURLOPT_URL, 'http://image.'.$domain_value.'/vmmeet/fileUpload.php');
			curl_setopt($varCurlObj, CURLOPT_POST, 1);
			curl_setopt($varCurlObj, CURLOPT_POSTFIELDS, $arrPost);
			curl_exec($varCurlObj);
			unlink($varfileloc);
		}else if($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE){
			$result = 'SIZE_ERR';
		}
	}
	echo '<script language="JavaScript" type="text/javascript">';
    if($result == 'OK'){
        echo 'window.parent.dispFileMsg("'.$filename.'","'.$varFileName.'");';
    }else if($result == 'SIZE_ERR'){
        echo 'window.parent.filesizealt();';
    }
    echo '</script>'; exit();
}
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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> <?php echo $member_id."vs".$recpid; ?> </title>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/global-style.css"/>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/useractions-sprites.css">
<script src="http://<?=$_SERVER[SERVER_NAME];?>/js/blockkeys.js"></script>
<script src="http://<?=$_SERVER[SERVER_NAME];?>/js/disright.js"></script>
<script language="JavaScript" type="text/javascript" src="js/sha1.js"></script>
<script language="JavaScript" type="text/javascript" src="js/xmlextras.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCPacket.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCHttpPollingConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCHttpBindingConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/uploadfile.js"></script>
</head>
<body onunload="close_w()" onload="dischatlink();document.frm.msg.focus();" onKeyDown="return disableCtrlKeyCombination(event);" onmousedown = "return false;">
<input type="hidden" value="<?php echo $_COOKIE['username'];?>" id="username" name="username">
<input type="hidden" value="<?php echo $_COOKIE['password'];?>" id="password" name="password">
<input type="hidden" value="" id="blocked" name="blocked">
<input type="hidden" value="0" id="theValue" />
<input type="hidden" name="filename" id="filename" value="" >
<input type="hidden" name="upload_button" id="upload_button" value="" >
<div style="width:496px;position:relative;" id="mainblock">
	<div style="position:absolute;">
		<div style="float:left;background-image: url('<?=$domain_imgpath?>/top_left_curve.gif'); width:4px; height:29px;"></div>	
		<div style="float:left;width:488px;background: url(<?=$domain_imgpath?>/chat_bg.gif) repeat-x;height:29px;">
			<div style="padding: 3px 0px 0px 5px;color:#868686;width:227px;" class="fleft"><img src="<?=$domain_imgpath?>/chatlogo/<?=$foldername?>_logo.gif" height="26" /></div>
			<div style="padding-top: 5px;color:#868686;" class="fleft normtxt bld">VMM Matrimony Messenger</div>
			<div class="fright padt5"><a href="javascript:window.close();" class="smalltxt clr1">Close</a></div>
		</div>
		<div style="float:left;background-image: url('<?=$domain_imgpath?>/top_right_curve.gif');width:4px; height:29px;"></div>
	</div>
	<!--{ Middle Area -->
	<div style="position:absolute;margin-top:29px;background:#F5F5F5;width:494px !important;width:496px;border-left: 1px solid #CECECE;border-right: 1px solid #CECECE;">
		<div class="fleft" style="width:490px;">
			<div class="fleft" style="padding: 8px 0px 3px 7px;">
			<? include_once "chatprofilechatview.php";?>
			</div>
			<br clear="all">
			<div class="fleft" style="padding-top:4px;">
			<div style="float:right;text-align:right;" class="smalltxt"><a href="javascript:blockmem()" class="smalltxt clr1 fright bld">Block this member</a>&nbsp;</div>
				<div class="fleft" style="padding-top:7px;padding-left:4px;">
				<div class="fleft brdr" id="myDiv" style="width:478px !important;width:480px;height:98px !important;height:100px;overflow:auto;background:#ffffff;">
					<!-- Text  -->
				<? if ($_GET['msg']!=""){?>
				<div class="apclass" id="myDiv1" >
					<font style="font-family:verdana;font-size:11px;color:red"><b><?=ucfirst($recpid)."</b>:"?></font><?=$_GET['msg']?>
					<!-- Text  -->
				
				</div>	
				<?php } ?>	
				
				</div>				
			</div>
		</div> 
		<br clear="all">
		<div style="padding: 0px 6px 2px 0px;">
			<div style="background:#CBCBCB;height:25px;">
				<div style="padding: 4px;" class="fleft"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/chat-photo.gif" width="14" height="17" border="0" alt=""></div>
				<div class="fleft" style="padding: 2px 0px 0px 5px;;">
				<form action="<?=$PHP_SELF?>" target="upload_iframe" method="post" enctype="multipart/form-data" style="margin:0px">
				<input type="hidden" name="fileframe" value="true"  id="fileframe">
				<input type="hidden" name="upload_status" value="true" id="upload_status" >
				<input type="file" name="file" id="file" onChange="jsUpload(this)" class="brdr">&nbsp;&nbsp;&nbsp;<b>Upload Photo</b>
				</form></div>
			</div>
		</div>
		<!-- Middle Area }-->
		<div style="background:#EFEFEF;height:82px; padding: 0px 0px 0px 7px;">
			<div class="fleft">
				<form name="frm">
				<textarea name="msg" id="msg" rows="3" cols="40" style="width:390px;height:80px;" class="brdr" onKeyPress="return entsub(event)" tabindex="1" onKeyDown="limitText(this.form.msg,this.form.countdown,500);" onKeyUp="limitText(this.form.msg,this.form.countdown,500);"></textarea> 
				<input type="hidden" name=recpid value=<?=$recpid?>><input type="hidden" name=myid value=<?=$myid?>>
				<input type="hidden" name=latest value=""><input type="hidden" value="0" id="theValue" />
				<input readonly type="hidden" name="countdown" size="3" value="500">
				</form>
			</div>
			<div class="fleft brdr" style="margin-top:1px !important;margin-top:2px;height:78px;background:#fff;border-left:0px;">
				<div  style="padding: 25px 0px 0px 0px;width:88px;text-align:center;">
				<input type="button" class="button" value="Send" onClick="addEvent()">
				</div>
			</div>
		</div>
		<div style="margin-top:350px !important;margin-top:328px;border:1px solid #ff0000;">
			<div class="fleft" style="background: url(<?=$domain_imgpath?>/chat-curv-left.gif);width:6px;height:6px;">
			<img src="<?=$domain_imgpath?>/trans.gif" width="6" height="6" border="0" alt=""/>
			</div>
			<div class="fleft" style="width:484px;background:#F5F5F5;border-bottom: 1px solid #CECECE;border:1px solid #ff0000;">
			<img src="<?=$domain_imgpath?>/trans.gif" width="1" height="5" border="0" alt=""/>
			</div>
			<div class="fleft" style="background: url(<?=$domain_imgpath?>/chat-curv-right.gif);width:6px;height:6px;">
			<img src="<?=$domain_imgpath?>/trans.gif" width="6" height="6" border="0" alt=""/>
			</div>
		</div>
</div>
</body>
</html>
<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;"></iframe>