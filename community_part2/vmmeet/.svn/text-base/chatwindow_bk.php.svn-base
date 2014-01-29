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

$evid=trim($_REQUEST['evid']);
$member_id=$_COOKIE['Memberid'];
$gender=$_COOKIE['Gender'];
$myid=$member_id;
$recpid=trim($_GET['recpid']);
$upload_dir = "uploads/";
if (isset($_POST['fileframe'])) 
{
    $result = 'ERROR';
    $result_msg = 'No FILE field found';

    if (isset($_FILES['file']))  // file was send from browser
    {
        if ($_FILES['file']['error'] == UPLOAD_ERR_OK)  // no error
        {
            $filename = $_FILES['file']['name']; // file name 
            move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir.'/'.$filename);
            // main action -- move uploaded file to $upload_dir 
            $result = 'OK';
        }
        elseif ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE)
            $result_msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        else 
            $result_msg = 'Unknown error';

        // you may add more error checking
        // see http://www.php.net/manual/en/features.file-upload.errors.php
        // for details 
    }

    // outputing trivial html with javascript code 
    // (return data to document)

    // This is a PHP code outputing Javascript code.
    // Do not be so confused ;) 
    echo '<html><head><title>-</title></head><body>';
    echo '<script language="JavaScript" type="text/javascript">'."\n";
    echo 'var parDoc = window.parent.document;';
    // this code is outputted to IFRAME (embedded frame)
    // main page is a 'parent'

    if ($result == 'OK')
    {
        // Simply updating status of fields and submit button
        echo 'parDoc.getElementById("upload_status").value = "file successfully uploaded";';
        echo 'parDoc.getElementById("filename").value = "'.$filename.'";';
        echo 'parDoc.getElementById("filenamei").value = "'.$filename.'";';
        echo 'parDoc.getElementById("upload_button").disabled = false;';
    }
    else
    {
        echo 'parDoc.getElementById("upload_status").value = "ERROR: '.$result_msg.'";';
    }

    echo "\n".'</script></body></html>';

    exit(); // do not go futher 
}
// FILEFRAME section END

// just userful functions
// which 'quotes' all HTML-tags and special symbols 
// from user input 
function safehtml($s)
{
    $s=str_replace("&", "&amp;", $s);
    $s=str_replace("<", "&lt;", $s);
    $s=str_replace(">", "&gt;", $s);
    $s=str_replace("'", "&apos;", $s);
    $s=str_replace("\"", "&quot;", $s);
    return $s;
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
 <script language="javascript1.3" type="text/javascript">

 
function entsub(e) 
{   
	var agt, isIe, isGecko, key;
	var keychar;
	var splcheck;
	agt = navigator.userAgent.toLowerCase();
	isIE    = ((agt.indexOf("msie")  != -1) && (agt.indexOf("opera") == -1));
	isGecko = ((agt.indexOf('gecko') != -1) && (agt.indexOf("khtml") == -1));

	if (isIE)
	{
		key = window.event.keyCode;
		if (key == 13)
		{ addEvent();event.keyCode = 0;}
	}

	if(isGecko)
	{
		key = e.which;
		if (key == 13)
		{addEvent();(e.which) ? e.which : 0;return false;}
	}

	keychar = String.fromCharCode(key)
	splcheck = /\'|\"/
	return !splcheck.test(keychar);
	
}

function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "textarea")
	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0) {
		return true;
		} else {
			return false;
		}
	}
}

function writeMsg(newMsg,stat)
{
	//alert("writ msg "+newMsg);
	printMsg(document.frm.recpid.value,newMsg,2);
	if(stat=='b'){bflag=1;blockarea();}
}
function addEvent()
{  
	if(document.getElementById('blocked').value=="")
	{
	if(!IsEmpty(document.frm.msg,'text'))
	{    
		printMsg(document.frm.myid.value,document.frm.msg.value,1);
		//alert("input msg: "+document.frm.msg.value);
		window.opener.sendMsg(document.frm.recpid.value+"~"+escape(document.frm.msg.value));
		document.frm.msg.value="";clearmsg="";
	}
	}
	else
	{
	   alert('User has been blocked you.you cant send msg until he unblock.');
	}
	document.frm.msg.focus();
	
	
}




function printMsg(id,mess,tcolor)
{   
	if(tcolor==1)
	{txtcolor="green";}
	else
	{txtcolor="red";}
	var ni = document.getElementById('myDiv');
	var numi = document.getElementById('theValue');
	var num = (document.getElementById("theValue").value -1)+ 2;
	numi.value = num;
	var divIdName = "my"+num+"Div";
	var newdiv = document.createElement('div');
	newdiv.setAttribute("id",divIdName);
	mess=mess.replace(/SYSMSG/,"<font color='#ff0000'><b>");
	mess=mess.replace(/CSYSMSG/,"</b></font>");
	//alert(finalmsg);
	newdiv.innerHTML ="<div class='apclass'><font color='"+txtcolor+"'><b>"+id.toUpperCase()+"</b>:</font>"+unescape(mess)+"</div>";
	ni.appendChild(newdiv);
	
	document.getElementById('myDiv').scrollTop = 99999;
	document.frm.msg.focus();
}

function blockmem()
{ 
	var stay=confirm("Are you sure want to block this member?")
        

	   if(stay == true)
	{
		window.opener.addblock(document.frm.recpid.value);
		window.self.close();
	}
	else
	{


	}
	
}

function photo_req(status,imgPath)
{ 
	if(status==1){
		var stay=confirm("Are you sure want to send photo request?")
	}else if(status==2){
        var stay=confirm("Are you sure want to send photo password request?")
	}else{
        stay =false; 
		window.open(imgPath+"/photo/viewphoto.php?ID="+document.frm.recpid.value,'','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');
	}
        

	if(stay == true)
	{
		window.opener.send_photo_req(document.frm.recpid.value,status);
		
	}
	
	
}




function win_closed()
{

//window.opener.sendMsg(document.frm.recpid.value+"~"+escape('<?php echo $member_id ?> has closed the chat'));

}

function blockedflag() {

document.getElementById('blocked').value='1';

}
function unblockedflag() {

document.getElementById('blocked').value='';

}



/*function typing() {

msg = 'typing';
window.opener.sendMsg(document.frm.recpid.value+"~"+escape(msg));

}
function typingflag() {

document.getElementById('typing').innerHTML = 'typing...';


}*/

//-->
			
			
		</script>


</head>
<body onunload="close_w()">
<input type="hidden" value="<?php echo $_COOKIE['username'];?>" id="username" name="username">
<input type="hidden" value="<?php echo $_COOKIE['password'];?>" id="password" name="password">
<input type="hidden" value="" id="blocked" name="blocked">
<input type="hidden" value="0" id="theValue" />
<input type="hidden" name="filenamei" id="filenamei" value="" >
<input type="hidden" name="filename" id="filename" value="" >
<input type="hidden" name="upload_button" id="upload_button" value="" >
<div style="width:496px;position:relative;">
	<div style="position:absolute;">
		<div style="float:left;background-image: url('http://imgs.bharatmatrimony.com/bmimages/grn-lft-curve.gif'); width:4px; height:29px;"></div>	
		<div style="float:left;width:488px;background: url(http://imgs.bharatmatrimony.com/bmimages/topnav-bg-off.gif) repeat-x;height:29px;">
			<div style="padding: 5px 0px 0px 115px;" class="fleft mediumhdtxt boldtxt clr4">Matrimony Messenger</div>
		</div>		
		<div style="float:left;background-image: url('http://imgs.bharatmatrimony.com/bmimages/grn-right-curve.gif');	width:4px; height:29px;"></div>
	</div>
	<!--{ Middle Area -->
	<div style="position:absolute;margin-top:29px;background:#E0F2C8;width:494px !important;width:496px;border-left: 1px solid #358E47;border-right: 1px solid #358E47;">
		<div class="fleft" style="width:490px;">
			<div class="fleft" style="padding: 8px 0px 3px 7px;">
		
			<? include_once "chatprofilechatview.php";?>
				
				<div class="fleft" style="padding-top:7px;">
					<div class="fleft" id="myDiv" style="width:478px !important;width:480px;height:98px !important;height:100px;overflow:auto;border: 1px solid #86CA8C;background:#ffffff;">
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
		</div> <br clear="all">	
		<div style="padding: 0px 6px 2px 8px;">
			<div style="background:#CEE0E1;height:25px;">
				<div style="padding: 4px;" class="fleft"><img src="http://imgs.bharatmatrimony.com/bmimages/chat-photo.gif" width="14" height="17" border="0" alt=""></div>
				<div class="fleft" style="padding: 2px 0px 0px 5px;;">
					<form action="<?=$PHP_SELF?>" target="upload_iframe" method="post" enctype="multipart/form-data" style="margin:0px">
		<input type="hidden" name="fileframe" value="true"  id="fileframe">
		<input type="hidden" name="upload_status" value="true" id="upload_status" >
		<input type="file" name="file" id="file" onChange="jsUpload(this)"  style="border: 1px solid #86CA8C;">
		</form></div>
			</div>
		</div>
		

		<div style="background:#E0F2C8;height:82px; padding: 0px 0px 0px 7px;">
			<div class="fleft"><form name="frm"  >
		<textarea name="msg" id="msg" rows="3" cols="40" style="width:390px;height:80px;border: 1px solid #86CA8C;" onKeyPress="return entsub(event)" ></textarea> 
		<input type="hidden" name=recpid value=<?=$recpid?>><input type="hidden" name=myid value=<?=$myid?>><input type="hidden" name=latest value=""><input type="hidden" value="0" id="theValue" /></form>
		
		</form> </div><div class="fleft" style="margin-top:1px !important;margin-top:2px;height:78px;background:#fff;border: 1px solid #86CA8C;border-left:0px;"><div  style="padding: 25px 0px 0px 0px;width:88px;text-align:center;"><input type="button" class="button" value="Send" onClick="addEvent()"></div></div>
		</div>
	</div>
	
	<!-- Middle Area }-->
	<div style="position:absolute;margin-top:342px !important;margin-top:350px;">
		<div class="fleft" style="background: url(http://imgs.bharatmatrimony.com/bmimages/chat-curv-left.gif);width:6px;height:6px;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="6" height="6" border="0" alt=""/></div>
		
		<div class="fleft" style="width:484px;background:#E0F2C8;border-bottom: 1px solid #358E47;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5" border="0" alt=""/></div>

		<div class="fleft" style="background: url(http://imgs.bharatmatrimony.com/bmimages/chat-curv-right.gif);width:6px;height:6px;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="6" height="6" border="0" alt=""/></div>
	</div>


	<div class="fleft" style="position:absolute;padding-left:7px;"><div style="background: url(http://imgs.bharatmatrimony.com/bmimages/chat-bm-logo.png); width:103px; height:35px;"></div></div>

</div>

</body>
</html>
<script type="text/javascript">
/* This function is called when user selects file in file dialog */

function get_name_from_path(str_filepath) {    
 var obj_re = new RegExp(/([^\/\\]+)$/);    
  var str_name = obj_re.exec(str_filepath);    
   if (str_name == null)     
   {         return null;    
    }     else     
	{        
	
 return str_name[0];     
	 }
	 }


//For sending files
function jsUpload(upload_field)
{  
    if(document.getElementById('blocked').value=="")
	{
    var re_text = /\.xml/i;

    var filename = upload_field.value;

var fil = filename.substring(filename.length-3,filename.length);

  fil = fil.toLowerCase();
  
  if((fil.indexOf("txt") == -1) && (fil.indexOf("rtf") == -1) && (fil.indexOf("doc") == -1) && (fil.indexOf("gif") == -1)  && (fil.indexOf("png") == -1) && (fil.indexOf("jpg") == -1) && (fil.indexOf("peg") == -1))
  {
   
   alert("Invalid File");
upload_field.form.reset();
return false;
  
  }
  else {



  }



   /* if (filename.search(re_text) == -1)
    {
        alert("File does not have text(txt, xml, zip) extension");
        upload_field.form.reset();
        return false;
    }*/
    var name= document.getElementById('filenamei').value;

    upload_field.form.submit();
    
   
	var file_name = get_name_from_path(filename);
	if(file_name!="" || file_name!='null') {
	printMsg(document.frm.myid.value,''+escape("<a href='http://meet.communitymatrimony.com/download.php?f="+file_name+"'><font color=blue><b>"+file_name+"<b></font></a> file has been sent")+'',1);
	
	
	window.opener.sendMsg(document.frm.recpid.value+"~"+escape("<a href='http://meet.communitymatrimony.com/download.php?f="+file_name+"'><font color=blue><b>"+file_name+"<b></font></a> file received"));
	

	}
	document.frm.msg.value="";clearmsg="";
	document.frm.msg.focus();
	upload_field.form.reset();
    return true;
	}
	else
	{
	
	alert('User has blocked you.you cant send msg until the user  unblock.');
	
	}
	
}

document.getElementById('msg').focus();



function close_w() {

var id = '<?php echo $recpid; ?>';
window.opener.close_win(id);

}
</script>


<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;">
</iframe>
