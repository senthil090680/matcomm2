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

$objSlave = new DB;
//$objSlave1 = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);
//$objSlave1-> dbConnection('192.168.1.11','fireuser','firepass','openfire');

$evid               = trim($_REQUEST['evid']);
$EventInfo			= get_event_info($evid);
$event_date			= $EventInfo['event_date'];
$event_starttime	= strtolower($EventInfo['event_starttime']);
$event_endtime		= strtolower($EventInfo['event_endtime']);
$event_language		= $EventInfo['EventLanguage'];
$varMatriIdPrefix	= $arrMatriIdPre[$event_language];
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
$domain_logo        = 'http://img.'.$varDomainName.'/images/logo/'.$arrFolderNames[$varMatriIdPrefix]."_logo.gif";


$EventDate_disp      = date('jS F Y',strtotime($event_date));
$EventStartTime_disp = date("h:i:s A",strtotime($event_starttime));
$EventEndTime_disp   = date("h:i:s A",strtotime($event_endtime));

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
if($_GET["memid"])
	{
	//$member_id=base64_decode($_GET["memid"]);
	$memberid = $_GET["memid"];//$member_id;//fle_decrypt($member_id,'at9je6xtpz2m5oi56');
	$memberid = fle_decrypt($memberid,'ec3hk4bo1u6n4ce19');
	}
else
	{$memberid = $_COOKIE['Memberid'];}


$receive_memsql="select distinct(toUsername) as receiver from ".$varOnlineSwayamvaramDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where fromUsername='$memberid' and eventID=$evid and toUsername in (SELECT fromUsername FROM ".$varOnlineSwayamvaramDbInfo['DATABASE'].".".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." WHERE toUsername='$memberid')";
if($_REQUEST['debug']==1){
echo $receive_memsql;
}
$result   = $objSlave->ExecuteQryResult($receive_memsql,0);
$userscnt = mysql_num_rows($result);

$mem_list='';
while($value = mysql_fetch_assoc($result)){
	$receiver = $value['receiver'];
	$mem_list .= "&nbsp;<a href='javascript:void(0)' class='normtxt bld clr1' onclick='showMatrimonyMeetList(\"$memberid\",\"$receiver\",\"$evid\")'><B>".$receiver."</B></a><br>";
}
?>
<html>
<head>
	<title>VMM</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="abstract" content="">
	<meta name="Author" content="">
	<meta name="copyright" content="Copyright &copy; 2010 Consim Info Pvt Ltd. All rights reserved.">
	<meta name="Distribution" content="Matrimony, Matrimony, Indian Matrimony">
	<link rel="stylesheet" href="http://img.agarwalmatrimony.com/styles/global-style.css">
		
<script language="javascript">

var http_request = false;

// This is the function used to get the Host(Wedsite) Name
function getServerName()
{
    var str = window.location.protocol + '//' + window.location.hostname;
    return str;
}
function setWindStatus() // set window status to hide the hyperlinks mouse over
{
window.status = "Online Matrimony Meet";
}
setInterval('setWindStatus()',1000);
// Initialise the AJAX Object
function AJAXRequest() {
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
			http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	if (!http_request) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
}

// This function is used to send the id information to server
function showMatrimonyMeetList(Mid,ToId,evid) {
	url = getServerName() + "/chatconversationread.php?mem=" +Mid+"&Toid="+ToId+"&evid="+evid;
	AJAXRequest();
	http_request.onreadystatechange = writeMatrimonyMeetList;
	http_request.open('GET', url, true);
	http_request.send(null);
	}

// This function is used to get the result from AJAX Request page
function writeMatrimonyMeetList() 
{
	if (http_request.readyState == 4) 
	{
		if (http_request.status == 200) 
		{
			httpContent = http_request.responseText;
			//alert(httpContent);
			document.getElementById("AJAXmatmeetContent").innerHTML = "<BR>"+httpContent;
		} else {
			alert('There is a problem with the request.');
		}
	}
	else {
     document.getElementById("AJAXmatmeetContent").innerHTML = "<BR><font style='font-family:verdana\;color:#006600'>  <b>Loading...</b></font>";
	}
}
</script>
</head>

<body>
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			    <!-- ////////// -->
			    <?php include_once("header.php"); ?>
				<!-- /////////////// -->
				
<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" bgcolor="#FFFFFF">
<tr>
<td valign="top" ><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" width="1" height="1"></td>
<td valign="top">

<div class="bld padtb10" style="font-size:16px;"><?=$event_title?> Online Matrimony Meet&nbsp;&nbsp;
<font style="font-family:verdana;font-size:11px;"><?=$event_date?> (<?=$event_starttime?> - <?=$event_endtime?> IST)</font></div>

<center>
<div style="padding-bottom:10px;"><div style="background-color:#FDEAF0;"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" width="1" height="1"></div></div>

<div style="width:750px;text-align:left;line-height:15px"><font class="normaltxt1">Thank you for participating in the <?=ucfirst($arrFolderNames[$varMatriIdPrefix]);?> Virtual Matrimony Meet. Given below is your chat transcript. Click on the Matrimony ID of the member to view the contents. This information will be available only for 7 days from the close of event. We wish you luck in your partner search.
<br><br>
We appreciate your co-operation and response to the Virtual Matrimony Meet. Please mail your feedback to <a href="mailto:virtualmatrimonymeet@<?=$arrPrefixDomainList[$varMatriIdPrefix];?>" class="clr1">virtualmatrimonymeet@<?=$arrPrefixDomainList[$varMatriIdPrefix];?></a><br>
</div><BR><BR>

</center>

<TABLE width='100%' cellpadding="2" cellspacing="0" class='brdr'>
<!-- <tr>
  <td colspan=2>&nbsp;</td>
</tr> -->
<?php

if($userscnt!=0)
	{
?>
<TR>
	<TD width='200px' valign='top'>
	<div style='overflow:scroll;width:200px;height:500px;'>
	<BR>
	<a href="#"></a>
	<?php
		echo $mem_list;
	?>
	</div>
	</TD>
	<TD valign='top' align='left'>
<div id="AJAXmatmeetContent" align='left' style='overflow:scroll;height:500px;width:100%;'>
</div>

</TD>
</TR>
<?php
		}
	else
		{
		?>
		<TR>
			<TD colspan="2" style="padding-top:10px;padding-bottom:10px"><font class="normtxt">Sorry! No chat transcript is available for you. The reason could be that you have not chatted with any member during the event or no member has responded to your chat.</font></TD>
		</TR>
		<?php
		}
	?>
</TABLE>
</td>
<td valign="top" ><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" width="1" height="1"></td>
</tr></table>
			
			<!-- ////////// -->
			<?php include_once("footer.php"); ?>
			<!-- /////////////// -->
		</div>
	</div>
</div>
</center>
</body>
</html>
