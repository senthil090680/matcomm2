<?
error_reporting(0);
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']); 
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";

function getDomainLang($MatriId)
{
	global $lang,$idstartletterhash,$domain_language;
	
	$firstdigit=substr($MatriId,0,1);
	$firstdigit=strtoupper($firstdigit); 
	//$dblanguage=array_search($firstdigit,$idstartletterhash);
	$dblanguage=array_search($firstdigit,$GLOBALS['IDSTARTLETTERHASH']);
	$host=strtolower($lang[$dblanguage]);
	$dblanguage=str_replace("matrimony","",$host);
	$dblanguage=str_replace("matrimonial","",$dblanguage);
	return $domain_language;
}

include_once "chatfunctions.php";
$member_id=$_COOKIE['Memberid'];
$password=$_COOKIE['password'];
$gender=$_COOKIE['Gender'];
$cdomain = $_SERVER['SERVER_NAME'];

$db = new db();
$fid=substr(ucfirst($member_id),0,1);

$db->dbConnById(2,$member_id,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);	

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
 
include_once"timertip.php";
$language=getDomainInfo(1,$member_id);
$domain_language=$language["domainnameshort"];

$domain_value=getDomainLang($member_id);

$EventInfo=get_event_info($evid);
$event_date=$EventInfo['event_date'];
$event_title=$EventInfo['EventTitle'];
$event_starttime=strtolower($EventInfo['event_starttime']);
$event_endtime=strtolower($EventInfo['event_endtime']);
$event_endtimeval=$EventInfo['EventEndTime'];

 $event_jabber_ip=$EventInfo['Jabberip'];
 $event_bind_url=$EventInfo['bindurl'];

$openfire_server = "http://".$event_jabber_ip.":9090";

//Total Count
$count = file_get_contents("http://".$event_jabber_ip.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=count");


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
<META name="description" content="Indian Matrimony - Free Matrimonial - Register for FREE, Bharatmatrimony.com - Free matrimonials add your profile.">
<META name="keywords" content="Indian matrimony, free matrimonial, Add Profile, matrimonials, Telugu, tamil, sindhi, assamese, gujarati, malayalee, hindu, christian, muslim, register profile, matrimonial, add profile, success stories, search profiles, matrimonial website, Indian matrimony, marwadi, oriya, kannada, hindi, Free matrimonials, matrimony, desi match maker, match maker, online matrimony">
<TITLE>Indian Matrimony - Free Matrimonial - Register for FREE</TITLE>
<!-- Jabber client script files-->
<script language="JavaScript" type="text/javascript" src="js/sha1.js"></script>
<script language="JavaScript" type="text/javascript" src="js/xmlextras.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCPacket.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCHttpPollingConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCHttpBindingConnection.js"></script>

<script language="JavaScript" type="text/javascript" src="js/omm_search.js"></script>
<script language="JavaScript" type="text/javascript" src="js/omm_soundex.js"></script>
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
<link rel="stylesheet" href="http://imgs.bharatmatrimony.com/bmstyles/bmstyle.css">


<style>
ul#ommlist {margin:0;padding:0;list-style-type:none;width:auto; display:block;}
ul#ommlist li{ margin:0;background: url(http://<?=$_SERVER[SERVER_NAME];?>/vmm/images/omm-gbullet.gif) no-repeat center left; display: float; padding: 5px 5px 2px 10px;margin-top:px;}
</style>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/vmm/styles/global-style.css"></head>
<body>
<?
//$endtime_val = 1;
//if(($endtime_val!=1))
if(($endtime_val>$event_endtimeval))
{
echo '<center><div style="padding-bottom:10px;"><div style="background-color:#FDEAF0;width:750px"><img src="../images/trans.gif" width="1" height="1"></div></div><div style="width:750px;text-align:left;line-height:15px"><font class="normaltxt1">Thank you for participating in the Online Matrimony Meet for '.$event_title.'. We hope it has helped you in locating your ideal partner. <br><br>We appreciate your co-operation and response to the Online Matrimony Meet. Please mail your feedback to <a href="mailto:onlinematrimonymeet@bharatmatrimony.com" class="linktxt">onlinematrimonymeet@bharatmatrimony.com</a><br></div><BR><BR></center>';
exit;
}?>

<input type="hidden" name="message_cnt" value="1" id="message_cnt">
<input type="hidden" value="<?php echo strtolower($_REQUEST['Memberid']);?>" id="username" name="username">
<input type="hidden" value="<?php echo $_REQUEST['password'];?>" id="password" name="password">
<input type="hidden" value="<?php echo $evid;?>" id="evid" name="evid">
<input type="hidden" value="<?php echo $sex;?>" id="opposite_gender" name="opposite_gender">
<input type="hidden" value="" id="opened_windows" name="opened_windows">
<input type="hidden" value="" id="log" name="log">
<input type="hidden" value="" id="fMsg" name="fMsg">
<center>
<div id="maincontainer">
	<div id="container">
		
		<div id="rndcorner" class="fleft">
		<div style="float:left;width:772px;">

			<!-- Content Area-1-->
			<div style="width:761px;padding-top:5px;">
			<div class="middiv-pad">		
					
					<div class="fleft" style="margin-bottom:5px;">
					<div class="fleft" style="background: url(http://imgs.bharatmatrimony.com/bmimages/omm-top-img1-new.jpg) no-repeat; width:470px; height:159px;">
						<div class="fleft smalltxt" style="padding: 0px 0px 0px 15px;margin-top:60px">
								<div  class="clr4"><img width="4" hspace="5" height="7" src="http://imgs.bharatmatrimony.com/bmimages/vmm-arrow.gif"/>Modern day Virtual Swayamvar<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="3" hspace="5"/><br/>
								<img width="4" hspace="5" height="7" src="http://imgs.bharatmatrimony.com/bmimages/vmm-arrow.gif"/>Connect with members of your community from across the world<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="3" hspace="5"/><br/>
								<img width="4" hspace="5" height="7" src="http://imgs.bharatmatrimony.com/bmimages/vmm-arrow.gif"/>Chat and Interact real time<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="3" hspace="5"/><br/>
								<img width="4" hspace="5" height="7" src="http://imgs.bharatmatrimony.com/bmimages/vmm-arrow.gif"/>Over 50 Virtual Matrimony Meets Every Month
								</div>
							</div><br clear="all">	
					</div>
					<div class="fleft" style="background: url(http://imgs.bharatmatrimony.com/bmimages/omm-top-img2-new.jpg) no-repeat; width:279px; height:159px;"></div>							
					</div><br clear="all">					
			
			</div></div>
			<!-- Content Area-1 }-->
	</div></div>
    <div id="tarea">
	<div id="rndcorner" class="fleft">
		<div style="float:left;width:772px;background-color:#EEE">
			<!--<div style="padding-right:25px;" class="fright clr">10 days to Online Matrimony Meet</div><br clear="al">-->
			<!-- Content Area-1-->
			<div style="width:761px;padding-top:5px;">
			<div class="middiv-pad">		
					<div class="bl"><div class="br"><div class="tl"><div class="tr">
					<div class=" smalltxt clr" style="padding:5px 15px 0px 15px;">
					    
						<div style="padding:15px;">
								<!--{ Content -->
											
								

								
								<!--count down area-->
								<div class="fright" style="padding-right:30px;"><a href="vmlogout.php?evid=<?=$evid?>" class="clr1" onClick="javascript:close_child()">logout</a></div><br clear="all">
								
						
									
								<div style="padding-bottom:5px;" class="bigtxt clr3">Welcome to the <?=$event_title?> Online Matrimony Meet</div>								
					
								<div class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">

								<div class="content" >
								The list of all participating members is displayed below. Please use the scroll to see the complete list of participants. You can search among the participants and identify potential prospects that match your partner criteria and chat with them.	
								</div>

								
								<div style="width:680px;">
									<!--{ Chat -->
									<div class="fleft" style="width:285px;">
										<div class="innertabbr1 fleft"></div>
										<div style="float:left; width:283px; height:50px; background:url(http://imgs.bharatmatrimony.com/bmimages/inner-tab-bg.gif) repeat-x;"><div class="fright" style="padding:33px 15px 0px 0px">Do not click refresh <img src="http://imgs.bharatmatrimony.com/bmimages/omm-refresh.gif" width="11" height="13" border="0" alt=""> while the chat is on</div>
										</div>
										<div class="innertabbr1 fleft"></div>
										<div style="width:283px !important;width:285px;border: 1px solid #C9D4AE;border-top:0px;">
											<div style="padding: 0px 10px 0px 10px;">
												<div id="page_link" class='smalltxt boldtxt'></div>
												<div id="total_users"  class='smalltxt boldtxt'></div>
												<div id="latest_users"  class='smalltxt boldtxt clr1'></div>
												<input type="hidden" name="start" id="start" value=""><input type="hidden" name="end" id="end" value="">
												<div id="show_all" style='display:none'><b><a href="javascript:AjaxCall()"  class='clr1'>Show All</a></b></div>

												<div class="vdotline1" style="margin:5px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div>

													<!--Member Listing-->
												<div id="loading">
												<img src="images/loader.gif">
												</div>

																<div id="presence_pane" style="display:none;">
													
													<div style="width:260;height:400px;overflow:auto;" id="searchiResp" name="searchiResp" >
													
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
										</div>
									</div>
									<!--{ Chat -->

									<div class="fleft" style="width:7px;">&nbsp;</div>

									
									<!--{ Search -->
									<div class="fleft" style="width:385px;">
										<div class="innertabbr1 fleft"></div>
										<div style="float:left; width:383px; height:50px; background:url(http://imgs.bharatmatrimony.com/bmimages/inner-tab-bg.gif) repeat-x;"><div class="mediuntxt boldtxt" style="padding:33px 0px 0px 10px">Search</div>
										</div>
										<div class="innertabbr1 fleft"></div>
										<div style="width:383px !important;width:385px;height:500px !important;height:445px;border: 1px solid #C9D4AE;border-top:0px;">
										
											<div style="padding: 0px 10px 0px 10px;">
											<div class="vdotline1" style="margin:5px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">
													<!--Search Form-->
															<? include_once "chatsearchform.php";?>
													<!--Search Form-->
											</div>
										</div>
									</div>
									<!-- Search }-->
								
								</div><br clear="all">
	<div style="line-height:17px;padding-top:5px;padding-bottom:5px" class="smalltxt ">
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Click on the Matrimony ID to view the profile details of a member<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Click on the Chat link to chat with the member<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> While chatting if you wish to block a member use the block option provided in the chat window<br><br>
Note: At the end of the event the chat transcript of the communication exchanged between you and all the members you have chatted with will be available in the "My Matrimony" section for the next 1 month.</font>
</div>
<div style="width:680px;line-height:17px;text-align:left;padding-top:5px;padding-bottom:5px" class="smalltxt ">

<b>Chat Dos and Don'ts </b><br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5"><br>
In the chat room people have only two ways of judging what you're thinking. One is by the words you choose and the other is by the manners you use. So be as polite as possible and choose your words wisely.<br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5"><br>

<b>Dos for any message</b><br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5"><br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Do get right to the point-some people have many messages to read<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Do check your spelling, grammar, and punctuation<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Do think twice before using sarcasm<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Do stay calm when you get a rude message. Avoid responding to such messages<br><br>


<b>Don'ts for any message</b><br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5"><br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Don't type in UPPERCASE-it means you're shouting<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Don't use slang or rude language<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Don't forget you're chatting with real live people, even though you may not know them face-to-face<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Don't ask people for information you know is not safe to give out<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Don't ask personal questions that you would not ask face to face<br>
&nbsp;<font style="font-family:verdana;font-size:11px">&#149</font> Don't send blank screen messages<br>

</div>
							<!-- content }-->	
						</div>	
										 
					</div><br clear="all">					
					</div></div>	</div></div>
			</div></div>
			<!-- Content Area-1 }-->
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div></div>
    </div>
	</div>
</div><br clear="all">
</center>

<div id="chattooltip"></div>
<script language="javascript" type="text/javascript">
<!--
var popWin = new Array();
var cur_id = '<?php echo $member_id?>';
var domain_value ='<?php echo $domain_value;?>';
var evid = '<?php echo $evid; ?>';
var openfire_server = "<?php echo $event_jabber_ip; ?>";
var css_class = '<?php echo $class;?>';
var opposite_gender='<?php echo $sex;?>';
var url ="<?php echo $url;?>";
var bind = '<?php echo $event_bind_url;?>';
	var xhr=null;var xmlHttp=null;var xmlHttp_cou=null;var current_pg=1;											 
var online_users = new Array();
												
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



//Count Ajx
function countAjaxCall(curpg)
{
	xmlHttp_cou=vm_createajax();
	var parameters_cnt;
	
	var count_url="count.php?";
	if (xmlHttp_cou==null){alert ("Your browser does not support AJAX!");return;}
	count_url=count_url+"opposite_gender="+opposite_gender+"&evid="+evid+"&openfire="+openfire_server+"&trand="+genNumbers()+"&currentpage="+curpg;
	xmlHttp_cou.open("GET",count_url,true);
	xmlHttp_cou.onreadystatechange=stateChangedCnt;
	xmlHttp_cou.send(null);
}

function stateChangedCnt(){
	if (xmlHttp_cou.readyState==4){
															
	if(xmlHttp_cou.status==200)
	{
		if(xmlHttp_cou.responseText!=null && xmlHttp_cou.responseText!="")
		{
			//alert(xmlHttp_cou.responseText);
			if(document.getElementById("page_link")){document.getElementById("page_link").innerHTML="";}
			var count_response=xmlHttp_cou.responseText;
			cont_response=count_response.split('~');

			document.getElementById("total_users").innerHTML = cont_response[2]+" "+cont_response[4]+" to "+cont_response[5]+" "+cont_response[1]+"<br>"+cont_response[0];
			current_pg=parseInt(cont_response[3]);
		}
	}
}
}

function next_count()
{
	current_pg=parseInt(current_pg)+1;
	countAjaxCall(current_pg);
}

function prev_count()
{
	if(parseInt(current_pg)>1)
	{current_pg=parseInt(current_pg)-1;countAjaxCall(current_pg);}
}

//end here
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
		if(xhr.status  ==200) {if(xhr.responseText!=null && xhr.responseText!=""){addingUserArray(xhr.responseText);current_pg="";}}
		else {alert("Error code " + xhr.status);}
	}
}

// When Ajaxcall execute adding the user into Array
function addingUserArray(data)
{	
	if(data!="" && data!=null && data!="undefined" && data!="null")
	{
	document.getElementById('stored_users').value = "";
	 var initialReqData = data.split(',');
	 for(var k=0;k<initialReqData.length;k++)
	 {if(initialReqData[k] !="") {online_users[k] = initialReqData[k];}}
	}
	
	
	
	if(online_users.length > 20) 
	{
	first_call('1','20');
	var stat_val=21;
	var end_val=stat_val+19;
	
	
	if(end_val>online_users.length){end_val=online_users.length}
//document.getElementById("page_link").innerHTML = "<font class='smalltxt boldtxt'><b><a href=\"javascript:PagingAjaxCall('"+(stat_val)+"','"+end_val+"','null')\" class='clr1'>>></a> 1 to 20";
	}
	else{first_call('1',online_users.length);}

}

function PagingAjaxCall(start,end,search)
{
	document.getElementById("message_cnt").value ="";
	xmlHttp=vm_createajax();
	var parameters;
	var paging_url="paging.php";
	if (xmlHttp==null){alert ("Your browser does not support AJAX!");return;}

	if(search=="" || search=="null")
	{
		first_call(start,end);
		parameters="start="+start+"&end="+end+"&total="+online_users.length+"&opposite_gender="+opposite_gender+"&evid="+evid+"&openfire="+openfire_server+"&search=null&trand="+genNumbers();
		xmlHttp.open("POST",paging_url,true);
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", parameters.length);
	xmlHttp.setRequestHeader("Connection", "close");
	xmlHttp.send(parameters);
	}
	else
	{
	   showSearchResults(search,start,end);
       search = search.toString();
	   searchlen = search.split(',');
	   //parameters="start="+start+"&end="+end+"&total="+searchlen.length+"&search="+search+"&trand="+genNumbers(); 
	parameters="start="+start+"&end="+end+"&total="+searchlen.length+"&opposite_gender="+opposite_gender+"&evid="+evid+"&openfire="+openfire_server+"&search="+search+"&trand="+genNumbers(); 	  
		xmlHttp.open("POST",paging_url,true);
	xmlHttp.onreadystatechange=stateChanged_srch;
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", parameters.length);
	xmlHttp.setRequestHeader("Connection", "close");
	xmlHttp.send(parameters);
	}
	
	//xmlHttp.send(null);
}

function stateChanged()
{
	if (xmlHttp.readyState==4)
	{ 
		//alert(xmlHttp.responseText);
		if(xmlHttp.responseText!=null && xmlHttp.responseText!="")
		{
			//document.getElementById("page_link").innerHTML = xmlHttp.responseText;
			if(document.getElementById("latest_users")){document.getElementById("latest_users").innerHTML="";}
		} 
	}
}

function stateChanged_srch()
{
	if (xmlHttp.readyState==4)
	{ 
		//alert(xmlHttp.responseText);
		if(xmlHttp.responseText!=null && xmlHttp.responseText!="")
		{
			document.getElementById("page_link").innerHTML = xmlHttp.responseText;
			if(document.getElementById("latest_users")){document.getElementById("latest_users").innerHTML="";}
		} 
	}
}
//Initial user display 0 - 20
function first_call(startRecord,endRecord)
{
var html ='';
var online= online_users.toString();
countAjaxCall(current_pg);
document.getElementById('show_all').style.display = "none";
document.getElementById('searchiResp').innerHTML = "";
document.getElementById('stored_users').value = "";

var startRecord =eval(parseInt(startRecord)-1);
var endRecord =parseInt(endRecord);
//if(online != "" || online != 'null') { 
if(online_users.length != 0) 
{ 
if(endRecord > online_users.length){endRecord = online_users.length;}

for(var i=startRecord;i<endRecord;i++)
{    
	if(online_users[i] != "" && online_users[i] != "undefined" && online_users[i] != null) 
	{  
		if(online_users[i].indexOf("#")!=-1)
		{ 
			var first_array = online_users[i].split("#");

			var matriId = first_array[0];

			var details = first_array[1].split('~');

			if(details[12] == "-" || details[12] == "" ){var ph_ico="http://<?=$_SERVER[SERVER_NAME];?>/vmm/images/trans.gif";}

			matriId = (matriId).replace(/^\s*|\s*$/g,'');						
			online_users[i] = (online_users[i]).replace(/^\s*|\s*$/g,'');
			
			if(document.getElementById('stored_users').value == '')  
			{  
			document.getElementById("message_cnt").value = 1;document.getElementById('stored_users').value = matriId;            

			html += "<div id='M-"+matriId+"' class='smalltxt'>";

			if(details[12] == "-" || details[12] == "")
			{html += "<div id='"+matriId+"' class='fleft' style='width:30px;'><img src='"+ph_ico+"' width='16' height='12' border='0'></div>";}
			else
			{
				html += "<div id='"+matriId+"' class='fleft' style='width:30px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://imgs.bharatmatrimony.com/bmimages/omm-ph-icon.gif' width='16' height='12' border='0' alt=''  ></a></div>";
			}
			
			//Mouseover Content disp
			//alert(online_users[i]);
			html +="<div class='fleft' style='width:70px;'><a href='http://profile."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId.toUpperCase()+"' class='clr1 boldtxt' target='_blank' onmouseover=\"ddrivetip('"+online_users[i]+"');\" onmouseout=\"hideddrivetip();\">"+matriId.toUpperCase()+"</a></div>	<div class='fleft' style='width:50px;'>"+details[2]+" yrs  </div>	<div class='fleft' style='width:50px;'>"+ heightVal(details[3])+"</div>";

			//chat
			if(url == "chat") {   html += "<div id='ch-"+matriId+"'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; } 
			else { html += "<div id='ch-"+matriId+"'><a href='"+url+"' class='clr1' onClick='log()'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; }

			//left the chat
			html += "<div id='lg-"+matriId+"' style='display:none'><font class='clr1'>left the chat</font>&nbsp;&nbsp;</div>";
			//blocked
			html += "<div id='bb-"+matriId+"' style='display:none'><font class='clr1'><b>blocked</b></font></div>";
			//Unblock
			html += "<div id='bl-"+matriId+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='clr1'>Unblock</a></div>";
			html +="<div class='vdotline1' style='margin:5px 0px;'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' height='1' width='100%'/></div>";
			html += "</div>";
												
			document.getElementById('searchiResp').innerHTML = html; 
			}
			else 
			{  
				//var str=matriId;
			//if(document.getElementById('stored_users').value.search(matriId)==-1) 
			//{ 
				document.getElementById('stored_users').value = document.getElementById('stored_users').value+'~'+matriId;
				
				if(matriId !="" && matriId !=null)  
				{  
					
					height = details[3].replace(/_/g, "  ");
                    
					html += "<div id='M-"+matriId+"' class='smalltxt'>";
					
					if(details[12] == "-" || details[12] == "")
					{html += "<div id='"+matriId+"' class='fleft' style='width:30px;'><img src='"+ph_ico+"' width='16' height='12' border='0'></div>";}
					else
					{
						html += "<div id='"+matriId+"' class='fleft' style='width:30px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75');\" onmouseout=\"hideddrivetip();\"><img src='http://imgs.bharatmatrimony.com/bmimages/omm-ph-icon.gif' width='16' height='12' border='0' alt=''  ></a></div>";
					}
					
					html +="<div class='fleft' style='width:70px;'><a href='http://profile."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId.toUpperCase()+"' class='clr1 boldtxt' target='_blank' onmouseover=\"ddrivetip('"+online_users[i]+"');\" onmouseout=\"hideddrivetip();\">"+matriId.toUpperCase()+"</a></div>	<div class='fleft' style='width:50px;'>"+details[2]+" yrs  </div>	<div class='fleft' style='width:50px;'>"+ heightVal(details[3])+"</div>";
					
					//chat
					if(url == "chat") {   html += "<div id='ch-"+matriId+"'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; } 
					else { html += "<div id='ch-"+matriId+"'><a href='"+url+"' onClick='log()'  class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; }
					//left the chat
					html += "<div id='lg-"+matriId+"' style='display:none'><font class='clr1'>left the chat</font>&nbsp;&nbsp;</div>";
					//blocked
					html += "<div id='bb-"+matriId+"' style='display:none'><font class='clr1'><b>blocked</b></font></div>";
					//Unblock
					html += "<div id='bl-"+matriId+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='clr1'>Unblock</a></div>";
					html +="<div class='vdotline1' style='margin:5px 0px;'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' height='1' width='100%'/></div>";
					html += "</div>";
												
					document.getElementById('searchiResp').innerHTML = html; 		
					document.getElementById("message_cnt").value = eval(parseInt(document.getElementById("message_cnt").value) + 1);					
				}
			//}
		 }
		}
	}
  }
}
//funcall close
}

var cur_page=1;

//var disp_user_count=20;
//var stat_page=1;
//var noof_pages;
												
function handleMessage(aJSJaCPacket) 
{  
	//countAjaxCall();
	var html = '';
	var to_name = aJSJaCPacket.getFrom();
	var name =to_name.split("@");
	var msg = '';
	var msg = aJSJaCPacket.getBody();
	//msg ='test msg'; 
	if(aJSJaCPacket.getBody())
		msg = msg.replace(/^\s*|\s*$/g,'');
	var winind = name[0];
	var id = name[0];
	var evid = document.getElementById("evid").value;
	//var str="#";
	   
	if((msg.indexOf("#")==-1) && (msg.indexOf('bl123abc')==-1) )
	{ var winstat=openPop(winind,id,msg,evid);}																									
	else 
	{  
		//Block Start
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
				
				if(details[12] == "-" || details[12] == ""){var ph_ico = "http://<?=$_SERVER[SERVER_NAME];?>/vmm/images/trans.gif";}

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
				if(document.getElementById('left_users').value == '')  {document.getElementById('left_users').value = matriId[0];}
				else{document.getElementById('left_users').value = document.getElementById('left_users').value +"~"+matriId[0];}
															
				//  Removing element from array
				var online = online_users.toString();
				//For paging
			
				
				
				if(online_users.length>1 && online_users!=null)
				{
					for(var i=0;i<=online_users.length-1;i++) 
					{	
						if(online_users[i]!=null && online_users[i]!="" && online_users[i]!="undefined")
						{if(online_users[i].indexOf(matriId[0]) != -1) {online_users[i] = 'null';}}
					}
				}
						//To send notification to the chat users
						left_chat(original_msg1[0]);
				}
				else 	
				{
					//for new logged in member adding into the array
					var online = online_users.toString();  

					original_msg1 =  msg.split('@');
					original_msg2 =    msg.split('$#');
					var original = original_msg1[0]+"#"+original_msg2[1];
					
					if(online.indexOf(msg) == -1)
					{  
						 if(online.indexOf("null") == -1)
						{  
							if(online_users.length<1) 
							{online_users[0] = original;countAjaxCall(current_pg);} //If online user array is empty then

							else {online_users.push(original);countAjaxCall(current_pg);} //If online user array is having ids

							//Latest users
							/*if(online_users.length > disp_user_count ) 
							{
								noof_pages=online_users.length/disp_user_count;

								//if((online_users.length % disp_user_count) != 0){$noof_pages =noof_pages + 1;}
								noof_pages=Math.round(noof_pages);

								if(noof_pages==1)
								{document.getElementById("latest_users").innerHTML = "<font class='smalltxt boldtxt'><b><a		href=\"javascript:PagingAjaxCall('"+parseInt((disp_user_count) +1)+"','"+online_users.length+"','null')\" class='clr1'>>></a>";
								}

							}*/

						}
						else
						{
							 // alert("replace");
							for (var i=0;i<online_users.length-1;i++){if(online_users[i]=="null"){online_users[i]=original;break;}}
						}
					}	

					if(document.getElementById('stored_users').value == '') 
					{   
						document.getElementById('stored_users').value = matriId[0];
						document.getElementById("message_cnt").value = 1;
						 if(matriId !=""  && (online=="" || online_users.length < 20)) 
						{ 
							if(document.getElementById('left_users').value.search(matriId[0])==-1)
							{ 
							height = details[3].replace(/_/g, "  ");
							html += "<div id='M-"+matriId[0]+"' class='smalltxt'>";

							if(details[12] == "-" || details[12] == "")
							{html += "<div id='"+matriId[0]+"' class='fleft' style='width:30px;'><img src='"+ph_ico+"' width='16' height='12' border='0'></div>";}
							else
							{
								html += "<div id='"+matriId[0]+"' class='fleft' style='width:30px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75');\" onmouseout=\"hideddrivetip();\"><img src='http://imgs.bharatmatrimony.com/bmimages/omm-ph-icon.gif' width='16' height='12' border='0' alt=''  ></a></div>";
							}
							
							//Mouseover text disp
							html+="<div class='fleft' style='width:70px;'><a href='http://profile."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId[0].toUpperCase()+"' class='clr1 boldtxt' target='_blank' onmouseover=\"ddrivetip('"+original+"');\" onmouseout=\"hideddrivetip();\">"+matriId[0].toUpperCase()+"</a></div>	<div class='fleft' style='width:50px;'>"+details[2]+" yrs  </div>	<div class='fleft' style='width:50px;'>"+ heightVal(details[3])+"</div>";																	
							//chat
							if(url == "chat") {   html += "<div id='ch-"+matriId[0]+"'><a href=\"javascript:openchat('c-"+matriId[0]+"','"+evid+"');\" class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; } 
							else { html += "<div id='ch-"+matriId[0]+"'><a href='"+url+"' onClick='log()' class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; }

							//left the chat
							html += "<div id='lg-"+matriId[0]+"' style='display:none'><font class='clr1'>left the chat</font>&nbsp;&nbsp;</div>";
							//blocked
							html += "<div id='bb-"+matriId[0]+"' style='display:none'><font class='clr1'><b>blocked</b></font></div>";
							//Unblock
							html += "<div id='bl-"+matriId[0]+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId[0]+"','"+evid+"');\" class='clr1'>Unblock</a></div>";
							html +="<div class='vdotline1' style='margin:5px 0px;'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' height='1' width='100%'/></div>";
							html += "</div>";
							document.getElementById('searchiResp').innerHTML += html;
							}
							
							else 
							{
								if(document.getElementById(eval("'"+"ch-"+matriId[0]+"'"))) { 
								document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = ''; }
								if(document.getElementById(eval("'"+"lg-"+matriId[0]+"'"))) { 
								document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = 'none'; }

								//id=matriId[0];
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
					 //alert(document.getElementById('stored_users').value);
						//if(document.getElementById('stored_users').value.search(matriId[0])==-1) 
						//{
							document.getElementById('stored_users').value = document.getElementById('stored_users').value+'~'+matriId[0];
							
							if(matriId !="" && (online=="" || online_users.length < 20  || document.getElementById("message_cnt").value <20)) 
							{ 
								if(document.getElementById('left_users').value.search(matriId[0])==-1)
								{ 
									document.getElementById("message_cnt").value=eval(parseInt(document.getElementById("message_cnt").value) + 1);
									height = details[3].replace(/_/g, "  ");
									
									html += "<div id='M-"+matriId[0]+"' class='smalltxt'>";
									
									if(details[12] == "-" || details[12] == "")
									{
										html += "<div id='"+matriId[0]+"' class='fleft' style='width:30px;'><img src='"+ph_ico+"' width='16' height='12' border='0'></div>";
									}
									else
									{
										html += "<div id='"+matriId[0]+"' class='fleft' style='width:30px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75');\" onmouseout=\"hideddrivetip();\"><img src='http://imgs.bharatmatrimony.com/bmimages/omm-ph-icon.gif' width='16' height='12' border='0' alt=''  ></a></div>";
									}

									html+="<div class='fleft' style='width:70px;'><a href='http://profile."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId[0].toUpperCase()+"' class='clr1 boldtxt' target='_blank' onmouseover=\"ddrivetip('"+original+"');\" onmouseout=\"hideddrivetip('"+online_users[i]+"');\">"+matriId[0].toUpperCase()+"</a></div>	<div class='fleft' style='width:50px;'>"+details[2]+" yrs  </div>	<div class='fleft' style='width:50px;'>"+ heightVal(details[3])+"</div>";
									
									//chat
									if(url == "chat") {   html += "<div id='ch-"+matriId[0]+"'><a href=\"javascript:openchat('c-"+matriId[0]+"','"+evid+"');\" class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; } 
									else { html += "<div id='ch-"+matriId[0]+"'><a href='"+url+"' class='clr1' onClick='log()'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; }

									//left the chat
									html += "<div id='lg-"+matriId[0]+"' style='display:none'><font class='clr1'>left the chat</font>&nbsp;&nbsp;</div>";
									//blocked
									html += "<div id='bb-"+matriId[0]+"' style='display:none'><font class='clr1'><b>blocked</b></font></div>";
									//Unblock
									html += "<div id='bl-"+matriId[0]+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId[0]+"','"+evid+"');\" class='clr1'>Unblock</a></div>";
									html +="<div class='vdotline1' style='margin:5px 0px;'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' height='1' width='100%'/></div>";
									html += "</div>";
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

function chk(matriid){if((!popWin[matriid]) || (popWin[matriid].closed) || (popWin[matriid]=="0")){return false;}else{return true;}}

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
			var myurl="/chatwindow.php?recpid="+id+"&msg="+escape(firstmsg)+"&evid="+evid;
			var opened_win = document.getElementById('opened_windows').value;

			if(opened_win=="") {document.getElementById('opened_windows').value = id;}
			else {if(opened_win.search(id)==-1){document.getElementById('opened_windows').value = id+"~";}}
			
			popWin[matriId]=window.open(myurl,matriId,"menubar=0,resizable=0,width=498,height=365");
			return false;
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
function send_photo_req(id){var req_msg = id+"~"+"Member is requesting photo";sendMsg(req_msg);}

function sendMsg(newMsg)
{  
	alert("opener : "+newMsg);
	if(newMsg!=null && newMsg!=""){
	var newVal =newMsg.split("~");
	sendTo = newVal[0];
	msg = unescape(newVal[1]);
	sendFrom = document.getElementById('username').value;
	var aMsg = new JSJaCMessage();
	aMsg.setTo(sendTo+"@"+openfire_server);
	aMsg.setFrom(sendFrom+"@"+openfire_server);
	aMsg.setType('chat');
	aMsg.setBody(msg);
	con.send(aMsg);
	} //startTime = new Date().getTime();
}
																								
function handleEvent(aJSJaCPacket) {document.getElementById('iResp').innerHTML += "IN (raw):<br/>" +htmlEnc(aJSJaCPacket.xml()) + '<hr noshade size="1"/>';}

function handleConnected() {document.getElementById('presence_pane').style.display = '';document.getElementById('loading').style.display = 'none';con.send(new JSJaCPresence());}  
												
function handleError(e) {
if(e.getAttribute('code')<500)
{alert("Couldn't connect. Please try again...<br />"+"Error Code: "+e.getAttribute('code')+"\nType: "+e.getAttribute('type')+"\nCondition: "+e.firstChild.nodeName+"<br />"+"Please Contact Administrator");}}

function doLogin() 
{  
	try 
	{ 
		// setup args for contructor
		oArgs = new Object();
		oArgs.httpbase = "http://matrimonymeet.bharatmatrimony.com/"+bind+"/";
		oArgs.timerval = 2000;
		
		if (typeof(oDbg) != 'undefined')oArgs.oDbg = oDbg;
		con = new JSJaCHttpBindingConnection(oArgs);
		con.registerHandler('message',handleMessage);
		con.registerHandler('iq',handleEvent);
		con.registerHandler('onconnect',handleConnected);
		con.registerHandler('onerror',handleError);
		// setup args for connect method
		oArgs = new Object();
		oArgs.domain = openfire_server;
		oArgs.username = document.getElementById('username').value;
		oArgs.resource = 'BM_Messenger';
		oArgs.pass = document.getElementById('password').value;
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

chattooltip.innerHTML="<font style='font-family:verdana;font-size:11px'><b><font color='#E45103'>"+tip_msg[0].toUpperCase()+"</font><br>Age: </b>"+age+"yrs <b>Height: </b>"+height+"<br><b>Religion: </b>"+religionStr+"<br><b>Location: </b>"+
tip_locationStr+"<br><b>Education: </b>"+education+"<br><b>Occupation: </b>"+occupation+"</font>";

if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
	//memdet="<div><img src='http://imgs.bharatmatrimony.com/bmimages/loading_new.gif'></div>";
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

function searchInitiate() 
{
//alert("search clicked");
document.getElementById('stored_users').value = "";
if(document.getElementById("MARITAL_STATUS1").checked==false && document.getElementById("MARITAL_STATUS2").checked==false && document.getElementById("MARITAL_STATUS3").checked==false && document.getElementById("MARITAL_STATUS4").checked==false && document.getElementById("MARITAL_STATUS5").checked==false){alert("Please select martialstatus");return false;document.getElementById("MARITAL_STATUS1").focus();}
else{
	if(document.getElementById("MARITAL_STATUS1").checked){maritalQuery=document.getElementById("MARITAL_STATUS1").value;}else{martial_other();}
}
	
var ageQuery = document.getElementById('STAGE').value+'~'+document.getElementById('ENDAGE').value;
var heightQuery = document.getElementById('STHEIGHT').value+'~'+document.getElementById('ENDHEIGHT').value;
var subcaste="";
if(document.getElementById('SUBCASTE').value == ""){subcaste = 'Any';}else{subcaste=document.getElementById('SUBCASTE').value;}

//education send
if(chkClickedEducation() > 5 ){alert("Education Selection limit is 5");return false;}

var eduQuery="";
var EDUCATION1 = document.getElementById('EDUCATION1');
	 
	for (var i = 0; i < EDUCATION1.options.length; i++)
	{
			if (EDUCATION1.options[i].selected)
			{ 
				if(eduQuery==""){eduQuery=EDUCATION1.options[i].value;}else{eduQuery=eduQuery+"~"+EDUCATION1.options[i].value;}
			}
	}
     	
if(eduQuery==""){eduQuery="Any";}

var citizenQuery=document.getElementById('CITIZENSHIP1').value;
var countryQuery="";

if(chkClickedCountry() > 5 ){alert("Country Selection limit is 5");return false;}
	
var COUNTRY1 = document.getElementById('COUNTRY1');
	
	for (var i = 0; i < COUNTRY1.options.length; i++)
	{
		if (COUNTRY1.options[i].selected)
		{ 
			if(countryQuery==""){countryQuery=COUNTRY1.options[i].value;}else{countryQuery=countryQuery+"~"+COUNTRY1.options[i].value;}
		}
	}

	if(countryQuery==""){countryQuery="Any";}
	var wPhotoQuery = 'no';
	if(document.getElementById("PHOTO_OPT").checked != false){wPhotoQuery =  'Yes';}

	var rQuery = "false";
	var search ="";
	//alert(eduQuery);
	search = searchMembers( online_users, rQuery, ageQuery, heightQuery, citizenQuery, countryQuery, eduQuery, maritalQuery, wPhotoQuery, subcaste)
//alert(search);
	if(search.length == 0 || search==null || search=="null")
	{
		document.getElementById('searchiResp').innerHTML="No Records Found";
		document.getElementById('page_link').innerHTML="";
		document.getElementById("latest_users").innerHTML = "";
		document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users(0)</b></font>";
	}
	else if(search.length<20) 
	{document.getElementById('page_link').innerHTML="";PagingAjaxCall(1,search.length,search);}
	else{PagingAjaxCall(1,20,search);}
	document.getElementById('show_all').style.display="";
}


function showSearchResults(search,startRecord,endRecord)
{
	document.getElementById('searchiResp').innerHTML = "";
	search = search.toString();

	startRecord =eval(parseInt(startRecord)-1);
	endRecord =parseInt(endRecord);

	if(endRecord > online_users.length){endRecord = online_users.length;}
	str_search = search.split(',');

	//Total User count
	document.getElementById("total_users").innerHTML = "<font class='smalltxt boldtxt'><b>Total Users("+str_search.length+")</b></font>";

	//Latest users
	if(str_search.length > 20 ) 
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
			if(details[12] == "-" || details[12] == ""){var ph_ico = "http://<?=$_SERVER[SERVER_NAME];?>/vmm/images/trans.gif";}
			if(matriId !="" && matriId !=null) 
			{  
				 height = details[3].replace(/_/g, "  ");
				html += "<div id='M-"+matriId+"' class='smalltxt'>";

				//for photo
				if(details[12] == "-" || details[12] == "")
				{html += "<div id='"+matriId+"' class='fleft' style='width:30px;'><img src='"+ph_ico+"' width='16' height='12' border='0'></div>";}
				else
				{
					html += "<div id='"+matriId+"' class='fleft' style='width:30px;'><a href='#' class='clr1' target='_blank' onmouseover=\"ddrivetipImg('"+details[12]+"','','75')\" onmouseout=\"hideddrivetip();\"><img src='http://imgs.bharatmatrimony.com/bmimages/omm-ph-icon.gif' width='16' height='12' border='0' alt=''  ></a></div>";
				}
				
				//height
				html+="<div class='fleft' style='width:70px;'><a href='http://profile."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId+"' class='clr1 boldtxt' target='_blank' onmouseover=\"ddrivetip('"+online_users[str_search[i]]+"');\" onmouseout=\"hideddrivetip();\">"+matriId.toUpperCase()+"</a></div>	<div class='fleft' style='width:50px;'>"+details[2]+" yrs  </div>	<div class='fleft' style='width:50px;'>"+ heightVal(details[3])+"</div>";
																																
				//chat
				if(url == "chat") {   html += "<div id='ch-"+matriId+"'><a href=\"javascript:f('c-"+matriId+"','"+evid+"');\" class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; } 
				else { html += "<div id='ch-"+matriId+"'><a href='"+url+"' onClick='log()' class='clr1'>Chat <img src='http://imgs.bharatmatrimony.com/bmimages/omm-chat-icon.gif' width='16' height='15' border='0' alt=''></a></div>"; }


				//left the chat
				html += "<div id='lg-"+matriId+"' style='display:none'><font class='clr1'>left the chat</font>&nbsp;&nbsp;</div>";
				//blocked
				html += "<div id='bb-"+matriId+"' style='display:none'><font class='clr1'><b>blocked</b></font></div>";
				//Unblock
				html += "<div id='bl-"+matriId+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='clr1'>Unblock</a></div>";
				html +="<div class='vdotline1' style='margin:5px 0px;'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' height='1' width='100%'/></div>";
				html += "</div>";

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

function log() {alert(
"Sorry, as a free member you cannot initiate chat with another member. You can only reply to chat messages initiated by paid members.Become a paid member right away to initiate chat. Click here to pay.Note: After you make payment, please re-login to the event");
}

//End chat Process
var m_request=null;var hour;var minutes;var seconds;

//t='<?=$timertip?>';
/* alert(t);
var t1=t.split(" ");
var t2=t1[0].split(":")

thour=t2[0].indexOf('0')
if(thour==0){t2[0]=t2[0].replace('0','')}
tmins=t2[1].indexOf('0')
if(tmins==0){t2[1]=t2[1].replace('0','')}
tsec=t2[2].indexOf('0')
if(tsec==0){t2[2]=t2[2].replace('0','')}

hour=parseInt(t2[0]);
minutes=parseInt(t2[1]);
seconds=parseInt(t2[2]);

function countdown()
{
	if(minutes==0)
	{	minutes=59;
		if(hour==0)
		{
			m_request = vmm_createajax();
			url = "http://matrimonymeet.bharatmatrimony.com/chatend.php?evid=<?=$evid?>";
			m_request.onreadystatechange = closeChat;
			m_request.open('GET', url, true);
			m_request.send(null);
		}
		else
		{hour=hour-1;}
	}
	else
	{minutes=minutes-1;}	
}

function closeChat()
{try{
	if (m_request.readyState == 4) 
	{if (m_request.status == 200) {document.getElementById('tarea').innerHTML=m_request.responseText;}}
	}catch(e){}
}
setInterval('countdown()',60000);
*/
</script>
</body>
</html>

<? 
}

?>