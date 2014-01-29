<?php
error_reporting(E_ALL ^ E_NOTICE);
/*
*******************************************************************************
AUTHOR      : Pradeep.G,Karthikeyan.S

(DESCRIPTION GOES HERE)
DESCRIPTION : 
             Chat Window Codings.
MODIFICATION HISTORY:
****************************************************************************** 
| Version |	Date        | Author	                    | Remarks													 	
******************************************************************************
| 0.1     | 30-JUN-2007 | Pradeep.G,Karthikeyan.S	    | Initial Version                 
******************************************************************************
*/
header("Pragma: no-cache");
header("Content-type: text/html");
include_once"chatfunctions.php";
$evid=trim($_REQUEST['evid']);
$member_id=$_COOKIE['Memberid'];
$gender=$_COOKIE['Gender'];
$myid=$member_id;
$recpid=trim($_GET['recpid']);
$openchat_win=unclose_chat_member($member_id,$recpid,$evid);

?>
<html>
<title>Online Matrimony Meet-<?=$recpid;?></title>
<style>
.apclass{margin-left:3px;margin-bottom:5px;width:530px;}
</style>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/bmstyle.css">
<script src="http://<?=$_SERVER[SERVER_NAME];?>/js/blockkeys.js"></script>
<script src="http://<?=$_SERVER[SERVER_NAME];?>/js/disright.js"></script>
<body style="margin:0px" onload="dischatlink();document.frm.msg.focus();" onKeyDown="return disableCtrlKeyCombination(event);">
<table border="0" cellspacing="0" cellpadding="0" width="590" height="418" style="border:4px solid #F68633"><tr><td valign="top">

<table border="0" cellspacing="0" cellpadding="0" width="582">
<tr><td valign="top" align="center" style="padding-top:10px"><?include_once "chatprofilechatview.php";?></td></tr>
<tr><td valign="top" align="center">
<br>
		<table border="0" cellspacing="0" cellpadding="0" width="560" align="center"><tr><td valign="top" width="570" align="center" style="padding-bottom:10px;">
		<input type="hidden" value="0" id="theValue" />
		<div id="myDiv" style="border:1px solid #000000;overflow:auto;width:560px;height:150px;text-align:left;background-color:#ffffff;font-family:verdana;font-size:11px">
		<? if ($_GET['msg']!=""){?>
		<div id="myDiv1" style="padding-left:3px;padding-bottom:5px;"><font style="font-family:verdana;font-size:11px;color:red"><b><?=$recpid."</b>:"?></font><?=$_GET['msg']?></div>
		<?}?>
		</div></td></tr>
		</table>

	<table border="0" cellspacing="0" cellpadding="0" width="560" align="center">
	<tr><form name="frm" method="post">
	<td valign="top" width="560">
	<div style="width:560px;display:block" id="enterarea">
	<div style="float:left;width:410px"><input type="text" name="msg" tabindex="1" style="border:1px solid #000000;width:400px;height:30px;font-family:verdana;font-size:11px" maxlength="100"  onkeypress="return entsub(event)"></div>
	<div style="float:left;width:150px"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/onmm-submit.gif" onclick="addEvent()" id='subbut' name="subbut" style='cursor:pointer;disabled:false' tabindex="2" width="64" height="30" /> <img src="http://<?=$_SERVER[SERVER_NAME];?>/images/onmm-block.gif" onclick="blockmem()" hspace="5" style='cursor:pointer' tabindex="3" width="64" height="30" /><input type="hidden" name="evid" value=<?=$evid?>>
	<!-- <input type="hidden" name="blocksat" value="0"> -->
	</div>
	</div></td>
	</tr>
	<input type="hidden" name=recpid value=<?=$recpid?>><input type="hidden" name=myid value=<?=$myid?>><input type="hidden" name=latest value=""><input type="hidden" value="0" id="theValue" /></form>
	</table>
</td></tr></table>

<table border="0" cellpadding="0" cellspacing="0"><tr><td valign="top"><div id="pharea" style="width:560px;display:block">
<table border="0" cellpadding="2" cellspacing="2">
<tr><form name="phfrm" method="post" action="http://<?=$_SERVER[SERVER_NAME];?>/chatsharingimages.php" enctype="multipart/form-data" target="photoshare">
<td valign="top" colspan="2" style="padding-top:10px;font: normal 11px verdana;text-align:left">&nbsp;&nbsp;&nbsp;Attach Image / File :<input type=file name="userfile"></td>
<td valign="top" style="padding-top:10px;text-align:left"><input type="submit" value="upload" style="border:1px solid;button-size:20px"><br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="10" border="0"></td>
<input type="hidden" name=receiverid value=<?=$recpid?>><input type="hidden" name=senderid value=<?=$myid?>><input type="hidden" name=evid value=<?=$evid?>>
</form></tr>
</table></div></td></tr></table>
<Iframe name="photoshare" id='photoshareID' style="display:none;"></Iframe>
</td></tr></table>
<script type="text/javascript">
var bflag=0;
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

function checkKey(e)
{
	var keynum
	var keychar
	var splcheck

	if(window.event) // IE
	{
	keynum = e.keyCode
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
	keynum = e.which
	}
	keychar = String.fromCharCode(keynum)
	splcheck = /\'|\"/
	return !splcheck.test(keychar);
}

function clearst(st)
{
	var tempstr = new String(st);
	tempstr = tempstr.replace(/[^a-zA-Z 0-9.!@#$%/\^&?*():\'\",_-]+/g,' ');
	return tempstr
}

function addEvent()
{
	if(!IsEmpty(document.frm.msg,'text'))
	{
		printMsg(document.frm.myid.value,document.frm.msg.value,1);
		window.opener.sendMsg(document.frm.recpid.value+"~"+escape(document.frm.msg.value));
		document.frm.msg.value="";clearmsg="";
	}
	document.frm.msg.focus();
}

function addPhoto(photoMsg)
{
	if(photoMsg != "")
	{
		if(photoMsg == "1")
		{
			alert('Exceeded allowed file size (500KB)');
		}
		else if(photoMsg == "2")
		{
			alert('You can upload a file in JPG / GIF and doc format only.');
		}
		else if(photoMsg == "3")
		{
			alert('Your file could not be uploaded. Please try again.');
		}
		else
		{
			printMsg(document.frm.myid.value,"Your file has been uploaded successfully.",1);
			window.opener.sendMsg(document.frm.recpid.value+"~"+escape(photoMsg));
			document.frm.msg.value="";clearmsg="";
		}
	}
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
	newdiv.innerHTML ="<div class='apclass'><font color='"+txtcolor+"'><b>"+id+"</b>:</font>"+unescape(mess)+"</div>";
	ni.appendChild(newdiv);
	document.getElementById('myDiv').scrollTop = 99999;
}

function writeMsg(newMsg,stat)
{
	printMsg(document.frm.recpid.value,newMsg,2);
	if(stat=='b'){bflag=1;blockarea();}
}

function blockmem()
{
	var stay=confirm("Are you sure want to block this member?")
	var bid="c-"+document.frm.recpid.value;
	if(stay==true)
	{
		bflag=1;
		window.opener.addblcok(document.frm.recpid.value);
		window.self.close();
	}
}

function blockarea()
{
	var barea=document.getElementById("enterarea");
	var parea=document.getElementById("pharea");
	barea.style.display="none";
	parea.style.display="none";
}

function dischatlink()
{
	var dmid="c-"+document.frm.recpid.value;
	window.opener.document.getElementById(dmid).innerHTML="<font class='normaltxt1'>Chat</font>";
}

/*var cint=0;
function bclose()
{
	if(document.frm.blocksat.value==1)
	{printMsg(document.frm.recpid.value,"Member has blocked you",2);bflag=1;blockarea();}
	clearInterval(cint);
}
setInterval('bclose()',1000);*/
</script>
<!-- <script src="/js/bunload.js"></script> -->
<script>
var evid=document.frm.evid.value;
var matid="c-"+document.frm.recpid.value;
var rpid=document.frm.recpid.value;

window.onbeforeunload = function (event) {
if(bflag!=1){
var alert_text = rettxt();
	var browser=navigator.appName;
	var bAgt = navigator.userAgent.toLowerCase();
	var is_opr = (bAgt.indexOf("opera") != -1);
	var is_msie = (bAgt.indexOf("msie") != -1) && document.all && !is_opr;
	var is_msie5 = (bAgt.indexOf("msie 5") != -1) && document.all && !is_opr;

	if(is_msie || is_msie5 ||!event)
	{event=window.event;}

	if(event)
	{
		if(is_msie || is_msie5)
		{event.returnValue=alert_text;}
		return alert_text;
	}
}
}


function rettxt()
{
	//if (bflag==0)
	//{
		var txt="Your chat has been closed.";//}
	//else
	//{var txt="You successfully block this member.";}
	return txt
}

window.onunload =function ()
{
	if(bflag==0)
	{
		window.opener.addclosed(rpid);
		window.opener.document.getElementById(matid).innerHTML="<a href=\"javascript:openchat('"+matid+"','"+evid+"')\" class='linktxt'>Chat</a>";
	}
}
function doit()
{
/*
    var oIframe = document.getElementById("photoshareID");
    var oDoc = oIframe.contentWindow || oIframe.contentDocument;
    if (oDoc.document) {
        oDoc = oDoc.document;
    }
    //oDoc.body.style.backgroundColor = "#00f";
	document.getElementById('mon').innerHTML="a:"+oDoc.body.innerHTML;
	*/
	document.getElementById('mon').innerHTML=window.frames['photoshare'].document.getElementById('foo').innerHTML;
}
//setInterval('doit()',30000);
</script>
<div id='mon'></div>
</body>
</html>