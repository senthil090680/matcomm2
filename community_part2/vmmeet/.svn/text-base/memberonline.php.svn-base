<?
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
include_once($varRootBasePath.'/conf/cityarray.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once "chatfunctions.php";

//OBJECT DECLARATION
$objSlave         = new DB;
$masterobjdbclass = new DB;
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);
$masterobjdbclass-> dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$member_id = $_COOKIE['Memberid'];
$password  = $_COOKIE['password'];
$gender    = $_COOKIE['Gender'];
$cdomain   = $_SERVER['SERVER_NAME'];

if($member_id == "") {   $member_id = trim($_REQUEST['Memberid']); 
setcookie("Memberid",$member_id,0,"/",$cdomain);
setcookie("username",$member_id,0,"/",$cdomain);
}
if($password == "") {    $password = trim($_REQUEST['password']); 
setcookie("password",$password,0,"/",$cdomain);
}
if($gender == "") {    $gender = trim($_REQUEST['Gender']);  
setcookie("Gender",$gender,0,"/",$cdomain);
}
$evid=trim($_REQUEST['evid']);
if(($member_id == "" || $_REQUEST['Memberid'] == "") && ($password == "" || $_REQUEST['password']=="") && ($gender == "" || $_REQUEST['Gender']=="")){
header("Location :http://meet.communitymatrimony.com/vmlogin.php?evid=".$evid);
}

 
include_once"timertip.php";

$EventInfo       = get_event_info($evid);
$event_date      = $EventInfo['event_date'];
$event_title     = $EventInfo['EventTitle'];
$event_starttime = strtolower($EventInfo['event_starttime']);
$event_endtime   = strtolower($EventInfo['event_endtime']);
$event_endtimeval= $EventInfo['EventEndTime'];
$event_language	 = $EventInfo['EventLanguage'];
$event_jabber_ip = $EventInfo['Jabberip'];
$event_bind_url  = $EventInfo['bindurl'];

if($event_bind_url=='http-bind1'){
$openfire_server = "http://".$event_jabber_ip.":9090";
}else{
$openfire_server = "http://".$event_jabber_ip.":9092";
}

///////////Login from Mail/////////////
$varMatriIdPrefix	= $arrMatriIdPre[$event_language];
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
$domain_logo        = 'http://img.'.$varDomainName.'/images/logo/'.$arrFolderNames[$varMatriIdPrefix]."_logo.gif";
//$domain           = 'http://www.'.$varDomainName
///////////////////////////////////////

$varMatriIdPrefix	= substr($member_id, 0, 3);
$varCommunityFolder	= $arrFolderNames[$varMatriIdPrefix];
$domain_value       = $varCommunityFolder;

$confValues['DOMAINCONFFOLDER'] = 'domainslist/'.$varCommunityFolder;
include_once($varRootBasePath.'/lib/clsDomain.php');
$objDomainInfo		= new domainInfo;
$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
unset($arrGetSubcasteOption[9998]);
unset($arrGetSubcasteOption[9999]);
if($arrGetSubcasteOption[9997]='Others'){$arrGetSubcasteOption[9997] = 'Not specified';}

//Jabber process
include "jabber.php";
if($member_id==""){
header("location:vmlogin.php?evid=$evid");
}
else{
$endtime_val=date("H:i:s");

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
	<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/global-style.css">
	<link rel="alternate stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/small.css" title="smf" />
	<link rel="alternate stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/medium.css" title="mdf" />
	<link rel="alternate stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/large.css" title="lrg" />
	<script src="http://<?=$_SERVER[SERVER_NAME];?>/js/global.js" language="javascript"></script>
	<script src="http://<?=$_SERVER[SERVER_NAME];?>/js/fontvar.js" language="javascript"></script>

	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/sha1.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/xmlextras.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/JSJaCConnection.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/JSJaCPacket.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/JSJaCHttpPollingConnection.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/JSJaCHttpBindingConnection.js"></script>

	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/omm_search.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/omm_soundex.js"></script>

<style>
.linktxt_blk	{ 
	 display: none;
	}

</style>

<style type="text/css">
#chattooltip{position: absolute;width: 200px;border: 1px solid #E3B79C;padding: 5px;background-color: white;visibility: hidden;z-index: 100;line-height:15px;
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}
</style>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/bmstyle.css">


<style>
ul#ommlist {margin:0;padding:0;list-style-type:none;width:auto; display:block;}
ul#ommlist li{ margin:0;background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-gbullet.gif) no-repeat center left; display: float; padding: 5px 5px 2px 10px;margin-top:px;}
</style>
</head>
<body>
<input type="hidden" value="<?php echo strtolower($_REQUEST['Memberid']);?>" id="username" name="username">
<input type="hidden" value="<?php echo $_REQUEST['password'];?>" id="password" name="password">
<input type="hidden" value="<?php echo $evid;?>" id="evid" name="evid">
<input type="hidden" value="<?php echo $sex;?>" id="opposite_gender" name="opposite_gender">
<input type="hidden" value="" id="opened_windows" name="opened_windows">
<input type="hidden" value="" id="log" name="log">
<input type="hidden" value="" id="fMsg" name="fMsg">
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
        	<!-- ////////// -->
			<?php include_once("header.php"); ?>
			<!-- /////////////// -->
			<?
				if(($endtime_val>$event_endtimeval))
				{

				$varUpdateFields	=array("EventStatus");
				$varUpdateVal	    = array(1);
				$varUpdateCondtn	= " EventId='".$evid."'";
				$masterobjdbclass->update($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

				echo '<center><div style="padding-bottom:10px;"><div style="background-color:#FDEAF0;width:750px"><img src="../images/trans.gif" width="1" height="1"></div></div><div style="width:750px;text-align:left;line-height:15px"><font class="normaltxt1">Thank you for participating in the Virtual Matrimony Meet for '.$event_title.'. We hope it has helped you in locating your ideal partner. <br><br>We appreciate your co-operation and response to the Virtual Matrimony Meet. Please mail your feedback to <a href="mailto:virtualmatrimonymeet@'.$arrFolderNames[$varMatriIdPrefix].'matrimony.com" class="linktxt">virtualmatrimonymeet@'.$arrFolderNames[$varMatriIdPrefix].'matrimony.com</a><br></div><BR><BR></center>';
				
     		    include_once("footer.php");
			
				exit;
				}?>
				<div class="bld padtb10 fleft" style="font-size:16px;">Welcome to the <?=ucfirst($arrFolderNames[$varMatriIdPrefix]);?> Virtual Matrimony Meet</div>
				<div class="fright padtb10" style="padding-right:10px;"><a href="vmlogout.php?evid=<?=$evid?>" class="clr1" onClick="javascript:close_child()">Logout</a></div><div style="clear:both"></div>
				<div class="dotsep2"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" width="1" height="1" /></div>			
				
				<br clear="all"/>
				<div class="normtxt padb10">The list of all participating members is displayed below. Please use the scroll to see the complete list of participants. Fill in the form below to refine your search for the participants for chatting.</div>
				<div style="width:310px !important;width:350px;height:500px !important;height:530px;padding:15px;background-color:#F7F7F7;" class="fleft normtxt tljust lh16 brdr">
					Do not click refresh &nbsp;<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/refresh.gif" />&nbsp; while the chat is on<br><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" height="5" width="1" /><br>
					<div class="dotsep2"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="1" /></div>

					<!--div class="fleft" style="padding:10px 5px;"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/camera1.gif"></div>
					<div class="fleft" style="padding:8px 5px;width:80px !important;width:90px;"><a href="#" class="clr1 bld">ARY117101</a></div>
					<div class="fleft" style="padding:8px 5px;width:45px !important;width:55px;">34 yrs</div>
					<div class="fleft" style="padding:8px 5px;width:55px !important;width:65px;">5 Ft 4 In</div>
					<div class="fleft" style="padding:8px 5px;"><a href="" class="clr1">Chat</a> </div>
					<div class="fleft" style="padding-top:4px;"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif"></div><br clear="all"-->

					<!--{ Chat -->
					<div>
												<div id="page_link" class='smalltxt boldtxt'></div>
												<div id="total_users"  class='smalltxt boldtxt'></div>
												<div id="latest_users"  class='smalltxt boldtxt clr1'></div>
												<input type="hidden" name="start" id="start" value="">
												<input type="hidden" name="end" id="end" value="">
												<div id="show_all" style='display:none'><b><a href="javascript:AjaxCall()"  class='clr1'>Show All</a></b></div>

												<div class="vdotline1" style="margin:5px 0px;"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" height="1" width="100%"/></div>

					<!--Member Listing-->
												<div id="loading">
												<img src="images/loader.gif">
												</div>

									<div id="presence_pane" style="display:none;">
												<div class="fleft normtxt tljust lh16" id="searchiResp" name="searchiResp" style="width:300px;">
												</div>
												<form name="frmUserAct" method="post">
												<input type="hidden" name="ini_chat" value="">
												<input type="hidden" name="send_msg" value="">
												<input type="hidden" name="block_chat" value="">
												<input type="hidden" name="unblock_chat" value="">
												
												<input type="hidden" name="stored_users" id="stored_users" value="">
												<input type="hidden" name="left_users" id="left_users" value="">
												
												
												</form>

                                    </div>
					   <!--Member Listing-->	
									</div>
									<!--} Chat -->
					

					<div class="dotsep2"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="1" /></div>
				</div>
				<div style="width:380px !important;width:410px;height:290px !important;height:320px;padding:15px;background-color:#F7F7F7;" class="fright normtxt tljust lh16 brdr">
					<b>Search</b><br><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" height="5" width="1" /><br>
					
					<!--Search Form-->
					<? include_once "chatsearchform.php";?>
					<!--Search Form-->
				</div><br clear="all"/><br>

				<div class="lh16 normtxt clr">
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20"><li>Click on the Matrimony ID to view the profile details of a member.</li>
					<li>Click on the Chat link to chat with the member.</li>
					<li>While chatting, if you wish to block a member, use the block option provided in the chat window</li>
					</ul>
					<font class="smalltxt clr2">Note: At the end of the event the chat transcript of the communication exchanged between you and all the members you have chatted with will be available in the "My Home" section for the next 1 month.</font><br><br>
					<b>Chat Do's and Don'ts</b><br>
					In the  Virtual Matrimony Meet, the members in the chat room have only two ways of judging what you are thinking. One is by the words you choose and the other is by the words you use. So be as polite as possible and choose your words wisely.<br><br>
					<b>Do's</b>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20"><li>Do get to the point straight as some people have many messages to read.</li>
					<li>Do check your spelling, grammar, and punctuation.</li>
					<li>Do think twice before using sarcasm.</li>
					<li>Do stay calm when you get a rude message. Avoid responding to such messages</li>
					</ul>
					<b>Don'ts</b>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20"><li>Don't type in UPPERCASE it means you're shouting</li>
					<li>Don't use slang or rude language</li>
					<li>Don't forget you're chatting with real people, even though you may not know them face to face.</li>
					<li>Don't ask people for information you know is not safe to give out</li>
					<li>Don't ask personal questions that you would not ask face to face</li>
					<li>Don't send blank screen messages</li>
					</ul><br>
					If you have any ideas or suggestions regarding the Virtual Matrimony Meet,<br> please feel free to e-mail us at <a href="mailto:virtualmatrimonymeet@<?=$arrFolderNames[$varMatriIdPrefix];?>matrimony.com" class="clr1">virtualmatrimonymeet@<?=$arrFolderNames[$varMatriIdPrefix];?>matrimony.com.</a><br><br>
					<a href="http://meet.communitymatrimony.com/terms.php?evid=<?=$evid;?>" target="_blank" class="clr1">Terms and Conditions</a>
    			</div>
			</div>
			<br clear="all"/><br>
			
			
			<!-- ////////// -->
			<?php include_once("footer.php"); ?>
			<!-- /////////////// -->
		</div>
	</div>
</div>
</center>
<div id="chattooltip"></div>
<script language="javascript" type="text/javascript">

var popWin = new Array();
var cur_id = '<?php echo $member_id?>';
var domain_value ='<?php echo $domain_value;?>';
var evid = '<?php echo $evid; ?>';
var openfire_server = "<?php echo $event_jabber_ip; ?>";
var css_class = '<?php echo $class;?>';
var opposite_gender='<?php echo $sex;?>';
var url ="<?php echo $url;?>";
var bind = '<?php echo $event_bind_url;?>';
var xhr=null;var xmlHttp=null;var xmlHttp_cou=null;
var current_pg=1;											 
var online_users = new Array();
var curruserarr = new Array();
var recsperpage  = 20;
var totrecs      = 0;
var totalpgs     = 0;
var dispshowall  = 0;
var srchenabled  = 0;
												
function htmlEnc(str) 
{
	if (!str)
	return null;
	
	str = str.replace(/&/g,"&amp;");
	str = str.replace(/</g,"&lt;");
	str = str.replace(/>/g,"&gt;");
	str = str.replace(/\"/g,"&quot;");
	str = str.replace(/\n/g,"<br />");
	return str;
}
																		
function popblocker() 
{
	var popTest=window.open("","testwindow","menubar=0,resizable=0,width=50,height=50");
	if(popTest==null) {alert("Your popup blocker is on.Please turn it off." );}
	else {popTest.close();}
}

function heightVal(heightStr) 
{
	heightStr = Math.round(parseInt(heightStr));
	var height_arr= {"121":"4ft","122":"4ft","123":"4ft","124":"4ft 1in","125":"4ft 1in","126":"4ft 1in","127":"4ft 2in","128":"4ft 2in","129":"4ft 3in","130":"4ft 3in","131":"4ft 3in","132":"4ft 4in","133":"4ft 5in","134":"4ft 5in","135":"4ft 5in","136":"4ft 5in","137":"4ft 6in","138":"4ft 6in","139":"4ft 7in","140":"4ft 7in","141":"4ft 7in","142":"4ft 8in","143":"4ft 8in","144":"4ft 9in","145":"4ft 9in","146":"4ft 9in","147":"4ft 10in","148":"4ft 10in","149":"4ft 11in","150":"4ft 11in","151":"4ft 11in","152":"5ft","153":"5ft","154":"5ft 1in","155":"5ft 1in","156":"5ft 1in","157":"5ft 2in","158":"5ft 2in","159":"5ft 2in","160":"5ft 3in","161":"5ft 3in","162":"5ft 4in","163":"5ft 4in","164":"5ft 4in","165":"5ft 5in","166":"5ft 5in","167":"5ft 6in","168":"5ft 6in","169":"5ft 6in","170":"5ft 7in","171":"5ft 7in","172":"5ft 8in","173":"5ft 8in","174":"5ft 8in","175":"5ft 9in","176":"5ft 9in","177":"5ft 10in","178":"5ft 10in","179":"5ft 10in","180":"5ft 11in","181":"5ft 11in","182":"6ft","183":"6ft","184":"6ft","185":"6ft 1in","186":"6ft 1in","187":"6ft 2in","188":"6ft 2in","189":"6ft 2in","190":"6ft 3in","191":"6ft 3in","192":"6ft 3in","193":"6ft 4in","194":"6ft 4in","195cm":"6ft 5in","196cm":"6ft 5in","197cm":"6ft 5in","198":"6ft 6in","199":"6ft 6in","200":"6ft 7in","201":"6ft 7in","202":"6ft 7in","203":"6ft 8in","204":"6ft 8in","205":"6ft 9in","206":"6ft 9in","207":"6ft 9in","208":"6ft 10in","209":"6ft 10in","210":"6ft 11in","211":"6ft 11in","212":"6ft 11in","213":"7ft","214":"7ft","215":"7ft 1in","216":"7ft 1in","217":"7ft 1in","218":"7ft 2in","219":"7ft 2in","220":"7ft 2in","221":"7ft 3in","222":"7ft 3in","223":"7ft 4in","224":"7ft 4in","225":"7ft 4in","226":"7ft 5in","227":"7ft 5in","228":"7ft 6in","229":"7ft 6in","230":"7ft 7in","231":"7ft 7in","232":"7ft 7in","233":"7ft 8in","234":"7ft 8in","235":"7ft 8in","236":"7ft 9in","237":"7ft 9in","238":"7ft 10in","239":"7ft 10in","240":"7ft 11in"};

	return height_arr[heightStr];
}

function vm_createajax()
{
	if (window.XMLHttpRequest) {return new XMLHttpRequest();} 
	else if(window.ActiveXObject) {return new ActiveXObject("Microsoft.XMLHTTP");} 
	else {alert('Status: Cound not create XmlHttpRequest Object.  Consider upgrading your browser.');}
}

function genNumbers() {
  var d=new Date();
  var rand_flag = "vmm"+d.getSeconds()+"ph";
  return rand_flag;
}

function AjaxCall()
{
   srchenabled = 0;
   dispshowall=0;
   current_pg=1;
   xhr=vm_createajax();
   var evid = document.getElementById("evid").value;
   var opposite_gender = document.getElementById("opposite_gender").value;
   xhr.open('GET', "getdata.php?evid="+evid+"&opposite_gender="+opposite_gender+"&openfire="+openfire_server+"&trand="+genNumbers(), true);
   xhr.onreadystatechange =launchmsg;
   xhr.send(null);
}
												
function launchmsg()
{
	if(xhr.readyState  == 4)
	{
		if(xhr.status  ==200) {
			if(xhr.responseText!=null && xhr.responseText!=""){
			document.getElementById('searchiResp').innerHTML="";
			addingUserArray(xhr.responseText);current_pg=1;
			}else{
			document.getElementById('searchiResp').innerHTML="No Records Found";
			document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users(0)</b></font>";
			}
		}else {alert("Error code " + xhr.status);}
	}
}

function addingUserArray(data)
{	
	if(data!="" && data!=null && data!="undefined" && data!="null")
	{
	document.getElementById('stored_users').value = "";
	 var initialReqData = data.split(',');
	 for(var k=0;k<initialReqData.length;k++)
	 {if(initialReqData[k] !="") {online_users[k] = initialReqData[k];}}
	}
	if(online_users.length > recsperpage) 
	{ first_call(online_users,'1',recsperpage);}else{first_call(online_users,'1',online_users.length);}
	curruserarr = online_users;
	getPagingDet();
}

function getPagingDet(){
	totrecs  = curruserarr.length;
	totalpgs = Math.ceil(totrecs/recsperpage);
	current_pg = (current_pg > totalpgs) ? totalpgs : current_pg;
	current_pg = (current_pg < 1) ? 1 : current_pg;
	startnum = (current_pg>1) ? ((current_pg-1)*recsperpage)+1 : 1;
	endnum   = (current_pg*recsperpage) > totrecs ? totrecs : (current_pg*recsperpage);
	document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users("+totrecs+')</b></font>';
	prevlnk  = (current_pg > 1) ? "<a class='clr1' href='javascript:prevfun("+(current_pg-1 )+");'><<</a>" : '';
	nextlnk  = (totalpgs>current_pg) ? "<a class='clr1' href='javascript:nextfun("+(current_pg+1)+");'>>></a>" : '';
	pg_cont	 = (totalpgs>1) ? "<font class='smalltxt boldtxt'><b>"+prevlnk+startnum+' to '+endnum+nextlnk+'</b></font>' : '';
	document.getElementById("page_link").innerHTML = pg_cont;
}

function nextfun(pgval){
document.getElementById('left_users').value = '';
current_pg = pgval;
current_pg = (current_pg > totalpgs) ? totalpgs : current_pg;
current_pg = (current_pg < 1) ? 1 : current_pg;
startnum = (current_pg>1) ? ((current_pg-1)*recsperpage)+1 : 1;
endnum   = (current_pg*recsperpage);
first_call(curruserarr,startnum,endnum);
getPagingDet();
}

function prevfun(pgval){
document.getElementById('left_users').value = '';
current_pg = pgval;
current_pg = (current_pg > totalpgs) ? totalpgs : current_pg;
current_pg = (current_pg < 1) ? 1 : current_pg;
startnum = (current_pg>1) ? ((current_pg-1)*recsperpage)+1 : 1;
endnum   = (current_pg*recsperpage);
first_call(curruserarr,startnum,endnum);
getPagingDet();
}

//Initial user display 0 - 20
function first_call(curruserarr,startRecord,endRecord)
{
var html ='';
var online= curruserarr.toString();
if(dispshowall == 0){document.getElementById('show_all').style.display = "none";}
document.getElementById('searchiResp').innerHTML = "";
document.getElementById('stored_users').value = "";

var startRecord =eval(parseInt(startRecord)-1);
var endRecord =parseInt(endRecord);

if(curruserarr.length != 0) 
{ 
if(endRecord > curruserarr.length){endRecord = curruserarr.length;}

for(var i=startRecord;i<endRecord;i++)
{    
	if(curruserarr[i] != "" && curruserarr[i] != "undefined" && curruserarr[i] != null) 
	{  
		if(curruserarr[i].indexOf("#")!=-1)
		{ 
			var first_array = curruserarr[i].split("#");
			var matriId = first_array[0];
			var details = first_array[1].split('~');
			
			if(details[12] == "-" || details[12] == "" ){var ph_ico="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif";}

			matriId = (matriId).replace(/^\s*|\s*$/g,'');						
			curruserarr[i] = (curruserarr[i]).replace(/^\s*|\s*$/g,'');
			
			if(document.getElementById('stored_users').value == '')  
			{  
			document.getElementById('stored_users').value = matriId;
						
			html +="<div id='M-"+matriId+"' class='dotsep2'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif'	width='1' height='1' /></div>";
            
			if(details[12] == "-" || details[12] == ""){
			html +="<div id='"+matriId+"' class='fleft' style='padding:10px 5px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera.gif'></div>";
			}else{
            html +="<div id='"+matriId+"' class='fleft' style='padding:10px 5px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera1.gif'></a></div>";  
			}
            
           
            //Mouseover Content disp
			html +="<div  class='fleft' style='padding:8px 5px;width:80px !important;width:90px;'><a class='clr1 bld' href='http://www."+domain_value+"matrimony.com/login/index.php?redirect=http://www."+domain_value+"matrimony.com/profiledetail/index.php?act=fullprofilenew~id="+matriId.toUpperCase()+"' target='_blank' onmouseover=\"ddrivetip('"+curruserarr[i]+"');\" onmouseout=\"hideddrivetip();\">"+matriId.toUpperCase()+"</a></div><div class='fleft' style='padding:8px 5px;width:40px !important;width:50px;'>"+details[2]+" yrs</div><div class='fleft' style='padding:8px 5px;width:50px !important;width:60px;'>"+ heightVal(details[3])+"</div>";

		
            //chat
			if(url == "chat") {
			html +="<div id='ch-"+matriId+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='clr1'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>"; } 
			else {
            html +="<div id='ch-"+matriId+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href='"+url+"' class='clr1' onClick='return log()'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>";
			}
			
			//left the chat 
            html += "<div id='lg-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'>Left the chat</font></div>";

            //blocked
			html += "<div id='bb-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'><b>blocked</b></font></div>";

			//Unblock
			html += "<div id='bl-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='clr1'>Unblock</a></div><br clear='all'>";
														
			document.getElementById('searchiResp').innerHTML = html; 
			}
			else 
			{  
				document.getElementById('stored_users').value = document.getElementById('stored_users').value+'~'+matriId;
				
				if(matriId !="" && matriId !=null)  
				{  
					
					height = details[3].replace(/_/g, "  ");
                    
					//////////
					html +="<div id='M-"+matriId+"' class='dotsep2'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif'	width='1' height='1' /></div>";
            
					if(details[12] == "-" || details[12] == ""){
					html +="<div id='"+matriId+"' class='fleft' style='padding:10px 5px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera.gif'></div>";
					}else{
					html +="<div id='"+matriId+"' class='fleft' style='padding:10px 5px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera1.gif'></a></div>";  
					}

					//Mouseover Content disp
					html +="<div  class='fleft' style='padding:8px 5px;width:80px !important;width:90px;'><a class='clr1 bld' href='http://www."+domain_value+"matrimony.com/login/index.php?redirect=http://www."+domain_value+"matrimony.com/profiledetail/index.php?act=fullprofilenew~id="+matriId.toUpperCase()+"' target='_blank' onmouseover=\"ddrivetip('"+curruserarr[i]+"');\" onmouseout=\"hideddrivetip();\">"+matriId.toUpperCase()+"</a></div><div class='fleft' style='padding:8px 5px;width:40px !important;width:50px;'>"+details[2]+" yrs</div><div class='fleft' style='padding:8px 5px;width:50px !important;width:60px;'>"+ heightVal(details[3])+"</div>";

					//chat
					if(url == "chat") {
					html +="<div id='ch-"+matriId+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='clr1'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>"; } 
					else {
					html +="<div id='ch-"+matriId+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href='"+url+"' class='clr1' onClick='return log()'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>";
					}
			
					//left the chat 
					html += "<div id='lg-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'>Left the chat</font></div>";

					//blocked
					html += "<div id='bb-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'><b>blocked</b></font></div>";

					//Unblock
					html += "<div id='bl-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='clr1'>Unblock</a></div><br clear='all'>";
					
					document.getElementById('searchiResp').innerHTML = html; 		
				}
			//}
		 }
		}
	}
  }
}
//funcall close
}

function handleMessage(aJSJaCPacket) 
{  
	try
	{
	var html = '';
	var to_name = aJSJaCPacket.getFrom();
	var name = to_name.split("@");
	var msg = aJSJaCPacket.getBody();
	if(msg != null && msg != 'null')
	msg = msg.replace(/^\s*|\s*$/g,'');
	var winind = name[0];
	var id = name[0];
	var evid = document.getElementById("evid").value;
   if(msg != null && msg != 'null'){
	   
		if((msg.indexOf("#")==-1) && (msg.indexOf('bl123abc')==-1) )
		{ 
		  if( id != null && id != 'null'){
		   if(id.indexOf(".") != -1){
			   document.getElementById('lightpic').style.display='block';
			   document.getElementById('fade').style.display='block';
			   document.getElementById('message_from_admin').style.display='block';
			   document.getElementById('message_from_admin').innerHTML='<b>Message from Communitymatrimony :</b>'+msg;
			   ll();
			   floatdiv('lightpic',lpos,100).floatIt();
			   
		   }
		   else{
			var winstat=openPop(winind,id,msg,evid);
			}
		  }
	} 
	else 
	{  
		if(msg == 'bl123abc')
		{     
			if(popWin[winind]) 
			{
				if(popWin[winind]!="0") 
				{
					popWin[winind].blockedflag();
					msg = "<font color=blue>&nbsp;<b>This user has  blocked you!!</b></font>";
					popWin[winind].setTimeout("writeMsg('"+escape(msg)+"',' ')",1000);
				}
			}

			if(document.getElementById(eval("'"+"ch-"+winind+"'")))  {
			document.getElementById(eval("'"+"ch-"+winind+"'")).style.display = 'none'; }
			if(document.getElementById(eval("'"+"lg-"+winind+"'")))  {
			document.getElementById(eval("'"+"lg-"+winind+"'")).style.display = 'none'; }
			if(document.getElementById(eval("'"+"bb-"+winind+"'")))  {
			document.getElementById(eval("'"+"bb-"+winind+"'")).style.display = ''; }
												
		}//Block End
		
		//UnBlock Start
		else if(msg == 'ubl123abc')
		{    
			if(popWin[winind]) 
			{													
				if(popWin[winind]!="0")
				{
					popWin[winind].unblockedflag();
					msg = "<font color=blue>&nbsp;<b>This user has unblocked you.Now you can chat!!</b></font>";
					popWin[winind].setTimeout("writeMsg('"+escape(msg)+"',' ')",1000);
				}
			}
			
			if(document.getElementById(eval("'"+"ch-"+winind+"'")))  {
			document.getElementById(eval("'"+"ch-"+winind+"'")).style.display = ''; }
			if(document.getElementById(eval("'"+"lg-"+winind+"'")))  {
			document.getElementById(eval("'"+"lg-"+winind+"'")).style.display = 'none'; }
			if(document.getElementById(eval("'"+"bb-"+winind+"'")))  {
			document.getElementById(eval("'"+"bb-"+winind+"'")).style.display = 'none'; }
		}	
		//UnBlock End
		
		//Other Activite Start
		else
		{   
			
			if(msg.indexOf("$#")!=-1)
			{
				var split_msg = msg.split("$#");
				var matriId = split_msg[0].split('@');
				var details = split_msg[1].split('~');
				
				if(details[12] == "-" || details[12] == ""){var ph_ico = "http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif";}

				original_msg1=msg.split('@');
				original_msg2=msg.split('$#');
				
				//ID with Content
				var original = original_msg1[0]+"#"+original_msg2[1];
                
				//Left the Chat Start
				if(split_msg[2] == "logged out!") 
				{
				 matriId = split_msg[0].split('@');
				 matriId[0] = (matriId[0]).replace(/^\s*|\s*$/g,'');
							
				if(document.getElementById(eval("'"+"bl-"+matriId[0]+"'"))) {
				document.getElementById(eval("'"+"bl-"+matriId[0]+"'")).style.display = 'none'; }
				if(document.getElementById(eval("'"+"bb-"+matriId[0]+"'")))  {
				document.getElementById(eval("'"+"bb-"+matriId[0]+"'")).style.display = 'none'; }
				if(document.getElementById(eval("'"+"ch-"+matriId[0]+"'"))) {
				document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = 'none'; }
				if(document.getElementById(eval("'"+"lg-"+matriId[0]+"'"))) {
				document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = ''; }

				//To replace loggedout id			
				var replace_id = matriId[0];
				var stored_id = document.getElementById('stored_users').value;
				document.getElementById('stored_users').value = stored_id.replace(replace_id, "");
				
				//To add left users 
				/*if(document.getElementById('left_users').value == '')  {document.getElementById('left_users').value = matriId[0];}
				else{document.getElementById('left_users').value = document.getElementById('left_users').value +"~"+matriId[0];}*/
				
				//  Removing element from array
				var online = online_users.toString();
			
				//For paging
				if(online_users.length>=1 && online_users!=null)
				{
					for(var i=0;i<=online_users.length-1;i++) 
					{	
						if(online_users[i]!=null && online_users[i]!="" && online_users[i]!="undefined")
						{   
							if(online_users[i].indexOf(matriId[0]) != -1){
							online_users[i] = 'null';
							online_users.splice(i,1);
							}
						}
					}
				}
				//To send notification to the chat users
					left_chat(original_msg1[0]);
					if(srchenabled == 0){
					curruserarr = online_users;
					curruserlen = curruserarr.length;
					if((totalpgs-1)==current_pg){
					getPagingDet();
					startnum = (current_pg*recsperpage)-(recsperpage-1);
					endnum   = curruserarr.length<(current_pg*recsperpage) ? curruserarr.length : current_pg*recsperpage;
					first_call(curruserarr,startnum,endnum);
					}else if(totalpgs==current_pg && curruserlen>((totalpgs-1)*recsperpage)){
					getPagingDet();
					startnum = ((totalpgs-1)*recsperpage)+1;
					endnum   = curruserarr.length;
					first_call(curruserarr,startnum,endnum);
					}else if(totalpgs==current_pg && curruserlen==((totalpgs-1)*recsperpage)){
					current_pg = current_pg-1;
					getPagingDet();
					startnum = (current_pg*recsperpage)-(recsperpage-1);
					endnum   = curruserarr.length;
					first_call(curruserarr,startnum,endnum);
					}else if(totalpgs==1 && curruserlen==0){
					totalpgs = 0;
					document.getElementById('searchiResp').innerHTML="No Records Found";
					document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users(0)</b></font>";
					}
					}//for search
				}
				else 	
				{
					
					//for new logged in member adding into the array
					var online = online_users.toString();  
                    original_msg1 =  msg.split('@');
					original_msg2 =  msg.split('$#');
					var original  =  original_msg1[0]+"#"+original_msg2[1];
					if(online.indexOf(msg) == -1)
					{  
						if(online.indexOf("null") == -1)
						{  
							if(online_users.length<1) 
							{      online_users[0] = original;
						    }else {
								   online_users.push(original);
						    } //If online user array is having ids
						}
						else
						{
							for (var i=0;i<online_users.length-1;i++){
								if(online_users[i]=="null"){online_users[i]=original;break;}
							}
						}
					}
					if(srchenabled == 0){
					curruserarr = online_users;
					getPagingDet();
					}

					if(document.getElementById('stored_users').value == '') 
					{   
						document.getElementById('searchiResp').innerHTML="";
						document.getElementById('stored_users').value = matriId[0];
						if(matriId !=""  && (online=="" || online_users.length <= recsperpage)) 
						{ 
							if(document.getElementById('left_users').value.search(matriId[0])==-1)
							{ 
							height = details[3].replace(/_/g, "  ");
                        	html +="<div id='M-"+matriId[0]+"' class='dotsep2'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif'	width='1' height='1' /></div>";
            
							if(details[12] == "-" || details[12] == ""){
							html +="<div id='"+matriId[0]+"' class='fleft' style='padding:10px 5px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera.gif'></div>";
							}else{
							html +="<div id='"+matriId[0]+"' class='fleft' style='padding:10px 5px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera1.gif'></a></div>";  
							}
							
							//Mouseover Content disp
							html +="<div  class='fleft' style='padding:8px 5px;width:80px !important;width:90px;'><a class='clr1 bld' href='http://www."+domain_value+"matrimony.com/login/index.php?redirect=http://www."+domain_value+"matrimony.com/profiledetail/index.php?act=fullprofilenew~id="+matriId[0].toUpperCase()+"' target='_blank' onmouseover=\"ddrivetip('"+original+"');\" onmouseout=\"hideddrivetip();\">"+matriId[0].toUpperCase()+"</a></div><div class='fleft' style='padding:8px 5px;width:40px !important;width:50px;'>"+details[2]+" yrs</div><div class='fleft' style='padding:8px 5px;width:50px !important;width:60px;'>"+ heightVal(details[3])+"</div>";

							//chat
							if(url == "chat") {
							html +="<div id='ch-"+matriId[0]+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href=\"javascript:openchat('c-"+matriId[0]+"','"+evid+"');\" class='clr1'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>"; } 
							else {
							html +="<div id='ch-"+matriId[0]+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href='"+url+"' class='clr1' onClick='return log()'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>";
							}

							

							//left the chat 
							html += "<div id='lg-"+matriId[0]+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'>Left the chat</font></div>";

							//blocked
							html += "<div id='bb-"+matriId[0]+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'><b>blocked</b></font></div>";

							//Unblock
							html += "<div id='bl-"+matriId[0]+"' class='fleft' style='display:none;padding-top:7px;'><a href=\"javascript:openchat('u-"+matriId[0]+"','"+evid+"');\" class='clr1'>Unblock</a></div><br clear='all'>";
							document.getElementById('searchiResp').innerHTML += html;
							}else {
								if(document.getElementById(eval("'"+"ch-"+matriId[0]+"'"))) { 
								document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = ''; }
								if(document.getElementById(eval("'"+"lg-"+matriId[0]+"'"))) { 
								document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = 'none'; }

								if(popWin[matriId[0]]) 
								{
									if(popWin[matriId[0]]!="0") 
									{popWin[matriId[0]].setTimeout("writeMsg('<font color=blue><b>Logged In</b></font>',' ')",1000);}
								}
							}
						}
					}
					else 
					{
							document.getElementById('stored_users').value = document.getElementById('stored_users').value+'~'+matriId[0];
							if(matriId !="" && (online=="" || online_users.length <= (current_pg*recsperpage)))
							{ 
								if(document.getElementById('left_users').value.search(matriId[0])==-1)
								{ 
									height = details[3].replace(/_/g, "  ");
                                    
									/////////////////////////////////////////////////
									html +="<div id='M-"+matriId[0]+"' class='dotsep2'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif'	width='1' height='1' /></div>";
            
									if(details[12] == "-" || details[12] == ""){
									html +="<div id='"+matriId[0]+"' class='fleft' style='padding:10px 5px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera.gif'></div>";
									}else{
									html +="<div id='"+matriId[0]+"' class='fleft' style='padding:10px 5px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera1.gif'></a></div>";  
									}

									
									//Mouseover Content disp
									html +="<div  class='fleft' style='padding:8px 5px;width:80px !important;width:90px;'><a class='clr1 bld' href='http://www."+domain_value+"matrimony.com/login/index.php?redirect=http://www."+domain_value+"matrimony.com/profiledetail/index.php?act=fullprofilenew~id="+matriId[0].toUpperCase()+"' target='_blank' onmouseover=\"ddrivetip('"+original+"');\" onmouseout=\"hideddrivetip();\">"+matriId[0].toUpperCase()+"</a></div><div class='fleft' style='padding:8px 5px;width:40px !important;width:50px;'>"+details[2]+" yrs</div><div class='fleft' style='padding:8px 5px;width:50px !important;width:60px;'>"+ heightVal(details[3])+"</div>";

									//chat
									if(url == "chat") {
									html +="<div id='ch-"+matriId[0]+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href=\"javascript:openchat('c-"+matriId[0]+"','"+evid+"');\" class='clr1'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>"; } 
									else {
									html +="<div id='ch-"+matriId[0]+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href='"+url+"' class='clr1' onClick='return log()'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>";
									}

									//left the chat 
									html += "<div id='lg-"+matriId[0]+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'>Left the chat</font></div>";

									//blocked
									html += "<div id='bb-"+matriId[0]+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'><b>blocked</b></font></div>";

									//Unblock
									html += "<div id='bl-"+matriId[0]+"' class='fleft' style='display:none;padding-top:7px;'><a href=\"javascript:openchat('u-"+matriId[0]+"','"+evid+"');\" class='clr1'>Unblock</a></div><br clear='all'>";
									
									document.getElementById('searchiResp').innerHTML += html;
								}
								else 
								{	
									if(document.getElementById(eval("'"+"ch-"+matriId[0]+"'"))) { 
									document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = ''; }
									if(document.getElementById(eval("'"+"lg-"+matriId[0]+"'"))) { 
									document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = 'none'; }
									if(popWin[matriId[0]]) {popWin[matriId[0]].setTimeout("writeMsg('<font color=blue><b>Logged In</b></font>',' ')",1000);}
								}
							}
						//}
					}
				}
			}
		}
	  }
	}
		
	}
	catch (e) {
		//alert("Please contact administrator.Unable to login!");
		location.reload(true);
		return false;
		document.getElementById('login_err').innerHTML = e.toString();
	} finally {return false;}
	

}

function chk(matriid){if((!popWin[matriid]) || (popWin[matriid].closed) || (popWin[matriid]=="0")){return false;}else{return true;}}

function pause(millis)
{
  var date = new Date();
  var curDate = null;
  do { curDate = new Date(); }
  while(curDate-date < millis)
}
//Open pop with check												
function openPop(matriId,id,firstmsg,evid)
{   
	if((matriId!="") && (matriId!=null))
	{
		if(chk(matriId)==true)
		{popWin[matriId].setTimeout("writeMsg('"+escape(firstmsg)+"',' ')",1000);popWin[matriId].focus();return true;}
		else
		{   
			addwin(id);
			xhr=vm_createajax();
			var enc_matid='';
			//////////
			xhr.open("GET","getencvalue.php?matriid="+id+"&type=enc");
		    xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
				enc_matid = xhr.responseText;

				var myurl="/chatwindow.php?recpid="+enc_matid+"&msg="+escape(firstmsg)+"&evid="+evid;
				var opened_win = document.getElementById('opened_windows').value;

				if(opened_win=="") {document.getElementById('opened_windows').value = id;}
				else {if(opened_win.search(id)==-1){document.getElementById('opened_windows').value = id+"~";}}
				
				popWin[matriId]=window.open(myurl,matriId,"menubar=0,resizable=0,toolbar=0,location=0, directories=0, status=0, menubar=0,scrollbars=0,width=498,height=400,left=0,top=0");
				return false;

				}
			}
			xhr.send(null);
						
			
		}
	}
}

function addwin(id)
{if(document.frmUserAct.ini_chat.value!=""){document.frmUserAct.ini_chat.value+="/"+id;}else{document.frmUserAct.ini_chat.value=id;}}

function openchat(mid,evid)
{       
	var matid=mid.split('-');
	if(matid[0]!='u'){var winind=matid[1];openPop(winind,matid[1],'',evid);}
	else
	{
		if(document.getElementById(eval("'"+"bl-"+matid[1]+"'")) ) {document.getElementById(eval("'"+"bl-"+matid[1]+"'")).style.display = 'none'; }
		if(document.getElementById(eval("'"+"ch-"+matid[1]+"'"))) { document.getElementById(eval("'"+"ch-"+matid[1]+"'")).style.display = ''; }
		var unblock_msg = matid[1]+"~"+"ubl123abc";
		sendMsg(unblock_msg);
	}	
}

//Add Block List												
function addblock(id)
{   
	if(document.getElementById(eval("'"+"bl-"+id+"'")) ) {document.getElementById(eval("'"+"bl-"+id+"'")).style.display = '';  }
	if(document.getElementById(eval("'"+"ch-"+id+"'"))) { document.getElementById(eval("'"+"ch-"+id+"'")).style.display = 'none'; }
	var block_msg = id+"~"+"bl123abc";
	sendMsg(block_msg);
}

//Send photo request
function send_photo_req(id,status){
	if(status==1)
	var req_msg = id+"~"+"Member is requesting photo";
	else
    var req_msg = id+"~"+"Member is requesting photo password";

	sendMsg(req_msg);
}

function sendMsg(newMsg)
{  
	
	if(newMsg!=null && newMsg!=""){
	var newVal =newMsg.split("~");
	sendTo = newVal[0];
	msg = unescape(newVal[1]);
	sendFrom = document.getElementById('username').value;

	var aMsg = new JSJaCMessage();
	//alert("to address: "+sendTo+"@"+openfire_server)
	aMsg.setTo(sendTo+"@"+openfire_server);
	//alert("from address: "+sendFrom+"@"+openfire_server);
	aMsg.setFrom(sendFrom+"@"+openfire_server);
	aMsg.setType('chat');
	aMsg.setBody(msg);
	//alert("messg: "+aMsg);
	con.send(aMsg);

	} //startTime = new Date().getTime();
}
																								
function handleEvent(aJSJaCPacket) {
document.getElementById('iResp').innerHTML += "IN (raw):<br/>" +htmlEnc(aJSJaCPacket.xml()) + '<hr noshade size="1"/>';
}

function handleConnected() {
document.getElementById('presence_pane').style.display = '';
document.getElementById('loading').style.display = 'none';
con.send(new JSJaCPresence());
}  
												
function handleError(e) {
if(e.getAttribute('code')<500)
{alert("Couldn't connect. Please try again...<br />"+"Error Code: "+e.getAttribute('code')+"\nType: "+e.getAttribute('type')+"\nCondition: "+e.firstChild.nodeName+"<br />"+"Please Contact Administrator");}
}

function doLogin() 
{  
	try 
	{ 
		// setup args for contructor
		oArgs = new Object();
		oArgs.httpbase = "http://meet.communitymatrimony.com/"+bind+"/";

		//alert(oArgs.httpbase);
		oArgs.timerval = 2000;
		
		if (typeof(oDbg) != 'undefined')oArgs.oDbg = oDbg;
		con = new JSJaCHttpBindingConnection(oArgs);
		con.registerHandler('message',handleMessage);
		con.registerHandler('iq',handleEvent);
		con.registerHandler('onconnect',handleConnected);
		con.registerHandler('onerror',handleError);
		// setup args for connect method
		oArgs          = new Object();
		oArgs.domain   = openfire_server;
		oArgs.username = document.getElementById('username').value;
		oArgs.resource = 'CBS_VMM';
		oArgs.pass     = document.getElementById('password').value;
		//alert(oArgs.username);
		//alert(oArgs.pass);
		//oArgs.pass = document.getElementById('username').value;
		con.connect(oArgs);
		return true;


	} catch (e) {alert("Please contact administrator.Unable to login");return false;document.getElementById('login_err').innerHTML = e.toString();} finally {return false;}

}
			
function init() 
{
	//Jabber entry call
	doLogin(); 
	popblocker();
	//Initial Ajax call to get presence from jabber
	AjaxCall();
	if (typeof(Debugger) == 'function') {oDbg = new Debugger(4,'simpleclient');oDbg.start();}
}

window.onload = init;
window.onunload = function() { if (typeof(con) != 'undefined' && con.disconnect) con.disconnect();};


var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false;
if (ie||ns6)
var tipobj=document.all? document.all["chattooltip"] : document.getElementById? document.getElementById("chattooltip") : "";

function ietruebody(){return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body}

function ddrivetip(msg_str)
{
if(msg_str!="" && msg_str!=null && msg_str!="undefined")
{
	if(msg_str.indexOf("#")!=-1)
	{
		var tip_msg = msg_str.split("#");

                   if(tip_msg[1]!="undefined") {
					tip_details = tip_msg[1].split('~');
					//tip_details = tip_details.replace("_", " ");
				    age = tip_details[2];
                    //height = tip_details[3].replace(/_/g, "  ");

                    height = heightVal(tip_details[3]);
                    religion  = tip_details[4];
					caste  = tip_details[5];
					subcaste  = tip_details[6];
					religionStr = religion;
					religionStr = religionStr.replace(/_/g, " ");
                   
                    if(caste!='-') { religionStr += "-"+caste; }
                    if(subcaste!='-') { religionStr += "-"+subcaste; }
                    religionStr = religionStr.replace(/_/g, " ");
                    tip_locationStr  = "";

                    if(tip_details[7]!='-') { tip_locationStr += tip_details[9]; }
                    if(tip_details[9]!='-') { tip_locationStr += "-"+tip_details[10]; }

                     tip_locationStr = tip_locationStr.replace(/_/g, "  ");
                  
					if(tip_details[8])
					{education = tip_details[8];
                    education = education.replace(/_/g, " ");}
					
					if(tip_details[13])
					{occupation = tip_details[13].replace(/_/g, " ");}

                    if(age == "" || age == "-") {  age="-"; }
                    if(height == ""|| height == "-") {  height="-"; }
                    if(religionStr == ""|| religionStr == "-") {  religionStr="-"; }
					if(tip_locationStr == ""|| tip_locationStr == "-") {  tip_locationStr="-"; }
                    if(education == ""|| education == "-") {  education="-"; }
				    if(occupation == ""|| occupation == "-") {  occupation="-"; }

chattooltip.innerHTML="<font style='font-family:verdana;font-size:11px'><b><font color='#E45103'>"+tip_msg[0].toUpperCase()+"";
if(age != "-"){chattooltip.innerHTML+="<br><b>Age: </b>"+age+"yrs"; }
if(height != "-"){chattooltip.innerHTML+=" <b>Height: </b>"+height;}
if(religionStr != "-"){chattooltip.innerHTML+="<br><b>Religion: </b>"+religionStr;}
if(tip_locationStr != "-"){chattooltip.innerHTML+="<br><b>Location: </b>"+tip_locationStr;}
if(education != "-"){chattooltip.innerHTML+="<br><b>Education: </b>"+education;}
if(occupation != "-"){chattooltip.innerHTML+="<br><b>Occupation: </b>"+occupation+"</font>";}

if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
	//memdet="<div><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/loading_new.gif'></div>";
	//tipobj.innerHTML=memdet;
	enabletip=true
	return false
	}
}
}
}
}

function ddrivetipImg(thetext, thecolor, thewidth)
{
	chattooltip.innerHTML="<IMG src='"+thetext+"' border='0'>";
	if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor;enabletip=true;return false
	}
}


function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+75+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint-10+"px"
else
tipobj.style.top=curY+offsetypoint-10+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip()
{
if (ns6||ie){enabletip=false;tipobj.style.visibility="hidden";tipobj.style.left="-1000px";tipobj.style.backgroundColor='';tipobj.style.width='';}
}

document.onmousemove=positiontip;

//search code
var maritalQuery='';
function martial_other() 
{		
	if(document.getElementById("MARITAL_STATUS2").checked==true || document.getElementById("MARITAL_STATUS3").checked==true || document.getElementById("MARITAL_STATUS4").checked==true || document.getElementById("MARITAL_STATUS5").checked==true)
	{document.getElementById("MARITAL_STATUS1").checked=false;maritalQuery="";}

	if(document.getElementById("MARITAL_STATUS2").checked)
	{
		if(maritalQuery!=""){maritalQuery +="~"+document.getElementById("MARITAL_STATUS2").value;}else{maritalQuery=document.getElementById("MARITAL_STATUS2").value;}
	}

	if(document.getElementById("MARITAL_STATUS3").checked)
	{
		if(maritalQuery!=""){maritalQuery +="~"+document.getElementById("MARITAL_STATUS3").value;}else{maritalQuery=document.getElementById("MARITAL_STATUS3").value;}
	}

	if(document.getElementById("MARITAL_STATUS4").checked)
	{
		if(maritalQuery!=""){maritalQuery +="~"+document.getElementById("MARITAL_STATUS4").value;}else{maritalQuery=document.getElementById("MARITAL_STATUS4").value;}
	}

	 if(document.getElementById("MARITAL_STATUS5").checked)
	{
		if(maritalQuery!=""){maritalQuery +="~"+document.getElementById("MARITAL_STATUS5").value;}else{maritalQuery=document.getElementById("MARITAL_STATUS5").value;}
	 }
}	

function martial_any() 
{
	if(document.getElementById("MARITAL_STATUS1").checked==true)
	{
	maritalQuery=document.getElementById("MARITAL_STATUS1").value;
	document.getElementById("MARITAL_STATUS2").checked=false;
	document.getElementById("MARITAL_STATUS3").checked=false;
	document.getElementById("MARITAL_STATUS4").checked=false;
	document.getElementById("MARITAL_STATUS5").checked=false;
	}
}
/////////Validating Age functions////////
function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "password" || obj_type == "textarea" || obj_type == "file")	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0) {
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select" || obj_type == "select-one") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) 
				{
					if(obj.options[i].value==" ") 
					{return true;obj.focus();} else {return false;}
					
					if(obj.options[i].value == "0") 
					{
						if(obj.options[i].seletedIndex == "0") 
						{return true;obj.focus();}
					} else {return false;}
				}
			
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			return true;
		}
	} else {
		return false;
	}
}

function $(obj) {
   if(document.getElementById) {
        if(document.getElementById(obj)!=null) {
            return document.getElementById(obj)
        } else {
           return "";
       }
    } else if(document.all) {
        if(document.all[obj]!=null) {
            return document.all[obj]
        } else  {
          return "";
       }
    }
} 
function CompareValue( NumStr, pattern )
{
	for( var Idx = 0; Idx < NumStr.length; Idx ++ )
	{
		 var Char = NumStr.charAt( Idx );
		 var Match = false;

		for( var Idx1 = 0; Idx1 < pattern.length; Idx1 ++)
		{
		 if( Char == pattern.charAt( Idx1 ) )
		 Match = true;
		}
		if ( !Match )
		return false;
 	}
   	return true;
}

function validateAge(sf,gender) {
	var minage=0;
	stAge=sf.STAGE.value;
	endAge=sf.ENDAGE.value;	
	
	(gender=='M') ? minage=18 : minage=21;			
	var FINALAGE=parseInt(endAge)-parseInt(stAge);
	
	if(IsEmpty(sf.STAGE,"text")) {
		alert("Please enter the age range.");
		sf.STAGE.focus();
		return false;
	} else if(!(CompareValue(sf.STAGE.value,"0123456789"))) {
		alert("Sorry, Invalid Age "+stAge+".");
		sf.STAGE.focus();
		return false;
	} else if(IsEmpty(sf.ENDAGE, "text")) {
		alert("Please enter the age range.");
		sf.ENDAGE.focus();
		return false;
	}  else if(!(CompareValue(sf.ENDAGE.value,"0123456789"))) {
		alert("Sorry, Invalid Age "+endAge+".");
		sf.ENDAGE.focus();
		return false;
	} else if(stAge!=0 && endAge<stAge) {
		alert("Sorry, Invalid age range. "+stAge+" to "+endAge+".");
		sf.STAGE.focus();
		return false;
	} else if(stAge < minage || stAge > 70) {
		alert( "Sorry, invalid age "+stAge+" (Min. age is "+minage+". Max. age is 70).");
		sf.STAGE.focus();
		return false;
	} else if(parseInt(endAge)<minage || parseInt(endAge)>70) {
		alert("Sorry, invalid age "+endAge+" (Min. age is "+minage+". Max. age is 70).");	
		sf.STAGE.focus();
		return false;
	} else if(parseInt(FINALAGE)>22) {
		alert("The difference between a partner's \"From\" and \"To\" age should not exceed 22 years.");
		sf.ENDAGE.focus();
		return false;	
	} else {
		
		return true;
	}	
}
/////////////////////////////////////////

function searchInitiate() 
{
document.getElementById('stored_users').value = "";

if(document.getElementById("MARITAL_STATUS1").checked==false && document.getElementById("MARITAL_STATUS2").checked==false && document.getElementById("MARITAL_STATUS3").checked==false && document.getElementById("MARITAL_STATUS4").checked==false && document.getElementById("MARITAL_STATUS5").checked==false){alert("Please select martialstatus");return false;document.getElementById("MARITAL_STATUS1").focus();}
else{
	if(document.getElementById("MARITAL_STATUS1").checked){
		maritalQuery=document.getElementById("MARITAL_STATUS1").value;
	}else{martial_other();}
}

if(document.getElementById('STAGE').value==''){
	alert("Please enter the Age.");
	document.getElementById('STAGE').focus();
	return false;
}
if(document.getElementById('ENDAGE').value==''){
	alert("Please enter the Age.");
    document.getElementById('ENDAGE').focus();
	return false;
}
if(document.getElementById('STAGE').value > document.getElementById('ENDAGE').value){
	alert("Please enter the valid Age.");
    document.getElementById('STAGE').focus();
	return false;
}
if(document.getElementById('STHEIGHT').value>document.getElementById('ENDHEIGHT').value){
	alert("Please select the valid height.");
    document.getElementById('STHEIGHT').focus();
	return false;

}
var ageQuery = document.getElementById('STAGE').value+'~'+document.getElementById('ENDAGE').value;
var heightQuery = document.getElementById('STHEIGHT').value+'~'+document.getElementById('ENDHEIGHT').value;
var subcaste = '';
if(document.getElementById('SUBCASTE')!=null){
 subcaste = document.getElementById('SUBCASTE').value;
}
var eduQuery = document.getElementById('EDUCATION').value;
var citizenQuery = document.getElementById('CITIZENSHIP').value;
var countryQuery = document.getElementById('COUNTRY').value;
var wPhotoQuery = 'no';
if(document.getElementById("PHOTO_OPT").checked != false){wPhotoQuery =  'Yes';}
var rQuery = "false";
var search ="";
search = searchMembers( online_users, rQuery, ageQuery, heightQuery, citizenQuery, countryQuery, eduQuery, maritalQuery, wPhotoQuery, subcaste);
srchenabled = 1;
if(search.length == 0 || search==null || search=="null")
{
	document.getElementById('searchiResp').innerHTML="No Records Found";
	document.getElementById('page_link').innerHTML="";
	document.getElementById("latest_users").innerHTML = "";
	document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users(0)</b></font>";
}else if(search.length<recsperpage){
	curruserarr = search;
	document.getElementById('page_link').innerHTML="";first_call(curruserarr,1,curruserarr.length);current_pg=1;getPagingDet();
}else{
	curruserarr = search;
	first_call(curruserarr,1,recsperpage);
	current_pg=1;getPagingDet();
}
document.getElementById('show_all').style.display="";dispshowall=1;
}


function showSearchResults(search,startRecord,endRecord)
{
	srchenabled = 1;
	document.getElementById('searchiResp').innerHTML = "";
	search = search.toString();
    //alert('hai');
	startRecord =eval(parseInt(startRecord)-1);
	endRecord =parseInt(endRecord);

	if(endRecord > online_users.length){endRecord = online_users.length;}
	str_search = search.split(',');

	//Total User count
	document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users("+str_search.length+")</b></font>";

	//Latest users
	if(str_search.length > 2 ) 
	{
	var pg_val=str_search.length%10;
	if(pg_val==0){var pg_start_val=(str_search.length-10)+1;}else{var pg_start_val=(str_search.length-10)}
	
	//document.getElementById("latest_users").innerHTML = "<font class='smalltxt boldtxt'><b><a href='javascript:;' onClick=\"javascript:PagingAjaxCall('"+pg_start_val+"','"+str_search.length+"','"+search+"')\"  class='clr1'>Latest Users</a>";	
	}
	else {document.getElementById("latest_users").innerHTML = "";}

	if(search!="" && search!=null && search!="null") 
	{
		for(var i=startRecord;i<endRecord;i++)
		{   
        var html ='';
		search_array = online_users[str_search[i]];
		if(search_array.indexOf("#")!=-1)
		{
			var first_array = search_array.split("#");
			matriId = first_array[0];
			var  evid ='<?php echo $evid;?>';
			var details = first_array[1].split('~');
			if(details[12] == "-" || details[12] == ""){var ph_ico = "http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif";}
			if(matriId !="" && matriId !=null) 
			{  
				height = details[3].replace(/_/g, "  ");
                
				/////////////////////////////////////////////////
				html +="<div id='M-"+matriId+"' class='dotsep2'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif'	width='1' height='1' /></div>";

				if(details[12] == "-" || details[12] == ""){
				html +="<div id='"+matriId+"' class='fleft' style='padding:10px 5px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera.gif'></div>";
				}else{
				html +="<div id='"+matriId+"' class='fleft' style='padding:10px 5px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera1.gif'></a></div>";  
				}

			
				//Mouseover Content disp
				html +="<div  class='fleft' style='padding:8px 5px;width:80px !important;width:90px;'><a class='clr1 bld' href='http://www."+domain_value+"matrimony.com/login/index.php?redirect=http://www."+domain_value+"matrimony.com/profiledetail/index.php?act=fullprofilenew~id="+matriId.toUpperCase()+"' target='_blank' onmouseover=\"ddrivetip('"+online_users[str_search[i]]+"');\" onmouseout=\"hideddrivetip();\">"+matriId.toUpperCase()+"</a></div><div class='fleft' style='padding:8px 5px;width:40px !important;width:50px;'>"+details[2]+" yrs</div><div class='fleft' style='padding:8px 5px;width:50px !important;width:60px;'>"+ heightVal(details[3])+"</div>";

				//chat
				if(url == "chat") {
				html +="<div id='ch-"+matriId+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='clr1'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>"; } 
				else {
				html +="<div id='ch-"+matriId+"' class='fleft'><div  class='fleft' style='padding:8px 5px;'><a href='"+url+"' class='clr1' onClick='return log()'>Chat</a></div><div class='fleft' style='padding-top:4px;'><img src='http://<?=$_SERVER[SERVER_NAME];?>/images/chatbubble.gif'></div></div>";
				}
				

				//left the chat 
				html += "<div id='lg-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'>Left the chat</font></div>";

				//blocked
				html += "<div id='bb-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><font class='clr1'><b>blocked</b></font></div>";

				//Unblock
				html += "<div id='bl-"+matriId+"' class='fleft' style='display:none;padding-top:7px;'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='clr1'>Unblock</a></div>";

				document.getElementById('searchiResp').innerHTML += html;
			}
		}
	}
 }
}

function left_chat(left_id) 
{ 
	if(popWin[left_id]){
	if(popWin[left_id]!="0") {popWin[left_id].setTimeout("writeMsg('&nbsp;<font color=blue><b>Left the chat</b></font>',' ')",1000);}
	}
}


function close_child() 
{
   document.getElementById('log').value=1;
   var opened_win = document.getElementById('opened_windows').value;
   var opend_w = opened_win.split('~');
	for(var i=0;i<opend_w.length;i++) 
	{if(opend_w[i]!="") {popWin[opend_w[i]].close();}}
}

function close_win(val) {popWin[val] = "0";}

function log() {
var answer = confirm("Sorry, as a free member you cannot initiate chat with another member. You can only reply to chat messages initiated by paid members.Become a paid member right away to initiate chat. Click here to pay.Note: After you make payment, please re-login to the event");
if(answer){return true;}else{return false;}
}

//End chat Process
var m_request=null;var hour;var minutes;var seconds;

</script>
</body>
</html>
<? } ?>
<script language="javascript">
var lpos;
function ll()
{
	lpos=document.body.clientWidth/2 - parseInt(document.getElementById('lightpic').style.width)/2;
}

</script>

<script type="text/javascript">
var ns = (navigator.appName.indexOf("Netscape") != -1);
var d = document;
function floatdiv(id, sx, sy)
{
	var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	if(d.layers)el.style=el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};

	el.floatIt=function()
	{
		var pX, pY;
		pX = (this.sx >= 0) ? 0 : ns ? innerWidth : 
		document.documentElement && document.documentElement.clientWidth ? 
		document.documentElement.clientWidth : document.body.clientWidth;
		pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ? 
		document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0) 
		pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ? 
		document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/8;
		this.sP(this.cx, this.cy);
		setTimeout(this.id + "_obj.floatIt()", 1);
	}
	return el;
}
</script>

<style type="text/css">
.bgfadediv{ display: none;position: absolute;top: 0;left: 0;width: 1000px;height: 1450px;background-color: #000;z-index:1001;-moz-opacity: 0.8; opacity:0.80;filter: alpha(opacity=80);}

 .frdispdiv{display: none;position: absolute;margin: 0 auto; width: 85%;padding: 5px;border: 0px;background-color: white;z-index:1002;}
</style>
<div id="lightpic" class="frdispdiv" style="width: 500px;"><div style="display:none" id="message_from_admin"></div><br />
<a style="cursor: pointer; text-decoration: none;color: #ff0000;" onclick = "document.getElementById('lightpic').style.display='none';document.getElementById('fade').style.display='none';" >close</a>
</div>
<div id="fade" class="bgfadediv"></div>