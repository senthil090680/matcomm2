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

//OBJECT DECLARATION
$objSlave = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);
$evid     = trim($_REQUEST['evid']);


//Check whether the evid id is number.if not, Redirect to events list page test
if(is_numeric($evid) != 1) {
    echo "<script>alert('Invalid Event Id.');	window.location = 'http://meet.communitymatrimony.com/upcoming.php?evid=".$evid."';</script>";
	exit;
 } 
else {
//VARIABLLE DECLARATIONS	
$EventInfo			= get_event_info($evid);
$evt_date			= $EventInfo['evt_date'];
$evt_closedate		= $EventInfo['evt_closedate'];
$event_date			= $EventInfo['event_date'];
$event_title		= $EventInfo['EventTitle'];
$event_starttime	= strtolower($EventInfo['event_starttime']);
$event_endtime		= strtolower($EventInfo['event_endtime']);
$remain_date		= $EventInfo['diffdate'];
$event_caste		= $EventInfo['EventCaste'];
$event_religion		= $EventInfo['EventReligion'];
$event_language		= $EventInfo['EventLanguage'];
$event_status		= $EventInfo['EventStatus'];

$evt_date_new		= explode(' ',$evt_date);
$nowdate			= date("jS F Y");
$date_checking		= date("Y-m-d");
$time_date_checking = date("Y-m-d H:i:s");

$EventDate_disp      = date('jS F Y',strtotime($event_date));
$EventStartTime_disp = date("h:i A",strtotime($event_starttime));
$EventEndTime_disp   = date("h:i A",strtotime($event_endtime));

///////////Login from Mail/////////////
$varMatriIdPrefix	= $arrMatriIdPre[$event_language];
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
$domain_logo        = 'http://img.'.$varDomainName.'/images/logo/'.$arrFolderNames[$varMatriIdPrefix]."_logo.gif";
//$domain           = 'http://www.'.$varDomainName
///////////////////////////////////////



// Get Event details from table
$varCondition		= " where CURDATE()='".$evt_date_new[0]."' and (time('".$time_date_checking."')>=SUBTIME(EventStartTime,'00:30:00') and time('".$time_date_checking."')<=EventEndTime) and  EventId=$evid";
$varFields			= array('EventId');
$varEveDet  	    = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields,$varCondition,1);
$reg_value          = count($varEveDet);

if(isset($_POST["submit"]) || isset($_POST["submitdirect"]))
{

	if($reg_value == 0){
		echo "<script>window.location = 'http://meet.communitymatrimony.com/vmlogin.php?evid=".$evid."';</script>";
		exit;
	}

$matriid  = mysql_escape_string(trim(strtoupper(strtolower($_POST["matriid"]))));	
$password = mysql_escape_string(trim($_POST["password"]));
$cdomain  = $_SERVER['SERVER_NAME'];
//AND communityId IN(106,170)
$varCondition		= " where communityId='$event_language' AND ((MatriId='$matriid') or (Email='$matriid')) and password='$password'";
$varFields			= array('MatriId');
$varMemLoginDet	    = $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
$password           = strtolower($password);

if($_REQUEST['debug']==1){
	echo $varCondition; exit;
}

if(count($varMemLoginDet)>0)
{
// User found proceed further

$matriidVal         = strtoupper($varMemLoginDet[0]['MatriId']);
$varCondition		= " WHERE MatriId='".$matriidVal."' and Publish=1";
$varFields			= array('MatriId','Paid_Status','Gender','CasteId','communityId','Religion','Caste_Nobar');
$varMemDet	        = $objSlave->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);
$varGender          = ($varMemDet[0]['Gender']==1)?'M':'F';
$varPaidStatus      = $varMemDet[0]['Paid_Status']?'R':'F';
if(count($varMemDet) > 0 ){
// Profile details found 
$eventcastedisplay = $varMemDet[0]['CasteId'];

if(($event_caste == 998)&&($varMemDet[0]["Caste_Nobar"]=="1")){
$eventcastedisplay = 998;
}

//and EventCaste='".$eventcastedisplay."' 
$qry = "select EventId,EventTitle,DATE_FORMAT(EventDate,'%D %M %Y') as event_date,TIME_FORMAT(EventStartTime,'%l' '%p') as event_starttime,TIME_FORMAT(EventEndTime,'%l' '%p') as event_endtime from ".$varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS']." where date(EventDate)=CURDATE() and EventId='".$evid."' and EventLanguage='".$varMemDet[0]['communityId']."'";
$row = $objSlave->ExecuteQryResult($qry,1);

if(!empty($row)) {
$cdomain = $_SERVER['SERVER_NAME'];
$cdomain = str_replace(array("www","bmser"),"",$cdomain);
setcookie("username",$matriidVal,0,"/",$cdomain);
setcookie("password",$password,0,"/",$cdomain);
setcookie("Memberid",$matriidVal,0,"/",$cdomain);
setcookie("Gender",$varGender,0,"/",$cdomain);
$member_id=$matriidVal;
$gender=$varGender;
header("Location: memberonline.php?evid=$evid");

exit;
}
else 
{
$ErrMsg = "Sorry, this Virutal Matrimony Meet is only for the $event_title Community. You are not eligible to participate in it.";// <a href='http://meet.communitymatrimony.com/upcoming.php?evid=".$evid."'>Click here</a> to view the list of other forthcoming matrimony meets.";
}
}
else 
{
   $ErrMsg = "Sorry. This Matrimony Id is invalid or inactive";
}
}
else
{
   $ErrMsg = "Matrimony Id/Email or Password is invalid ";
}
}
?>
<html>
<head>
<SCRIPT language=Javascript>
<!--
function ValidateNo( NumStr, String )
{
for( var Idx = 0; Idx < NumStr.length; Idx ++ )
{
var Char = NumStr.charAt( Idx );
var Match = false;
for( var Idx1 = 0; Idx1 < String.length; Idx1 ++)
{
if( Char == String.charAt( Idx1 ) )
Match = true;
}
if ( !Match )
return false;
}
return true;
}

function InitArray()
{
this.length = InitArray.arguments.length
for (var i = 0; i < this.length; i++)
this[i+1] = InitArray.arguments[i]
}

// Function to validate all the inputs
function validate(  )
{
var ClassifiedForm = this.document.ClassifiedForm;
// Check E-mail
if ( ClassifiedForm.matriid.value == "" )
{
alert( "Please Enter matriid" );
ClassifiedForm.matriid.focus( );
return false;
}
// Check Password
if ( ClassifiedForm.password.value == "" )
{
alert( "Please type your password." );
ClassifiedForm.password.focus( );
return false;
}
return true;
}

function terms(evid)
{
 var win;
 var turl="/online-meet-tc.php?evid="+evid;
 win=window.open(turl,"Termsandconditions","menubar=0,resizable=0,scrollbars=1,width=800,height=600")
}
//  -->
</SCRIPT>


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
<script language="javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/ajax.js" ></script>
<script language="javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/ST_common.js" ></script>
<script language="javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/div-opacity.js" ></script>
<script language="javascript" src="http://<?=$_SERVER[SERVER_NAME];?>/js/equal-div.js"></script>
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
				<div style="background:url(images/upcomingbg.gif) no-repeat;height:65px;width:774px;">
					<div class="fleft" style="width:20px;"><img src="images/trans.gif" width="20" height="1" /></div>
					<div class="fleft smalltxt bld lh20" style="width:190px;font-size:16px;padding-top:10px;"><?if($event_date==$nowdate){?><b>Today<br><?}else{?><b>Upcoming<br><?}?> Virtual Matrimony Meet</b></div>
					<div class="fleft" style="width:40px;"><img src="images/trans.gif" width="40" height="1" /></div>
					<div class="fleft smalltxt" style="width:150px;padding-top:15px;"><b>Meet Name:</b><br><?=ucfirst($event_title);?> Matrimony Meet</div>
					<div class="fleft" style="width:45px;"><img src="images/trans.gif" width="45" height="1" /></div>
					<div class="fleft smalltxt" style="width:125px;padding-top:15px;"><b>Community</b><br><?=ucfirst($event_title);?></div>
					<div class="fleft" style="width:40px;"><img src="images/trans.gif" width="40" height="1" /></div>
					<div class="fleft smalltxt" style="width:150px;padding-top:15px;"><b>Date & Time:</b><br><?=$EventDate_disp;?><br><?=$EventStartTime_disp;?> - <?=$EventEndTime_disp;?></div>
				</div><br clear="all"><br>
				<div style="width:340px;padding-left:1px;" class="fleft normtxt tljust lh16">
				<b>What is Virtual Matrimony Meet?</b><br>
				Virtual Matrimony Meet is an online event that provides a platform for members of a specific community to meet and interact with other members from the same community. During the event members can exchange their views, share their interests, hobbies, expectations etc., for the sole purpose of finding a suitable life partner.<br><br>
				<b>How it works?</b><br>
				During the event the members would be able to view the list of all other members who are participating in the event. They can do a search based on various criteria to identify the potential partners they wish to communicate with. The tools provided for communication include web alerts, chat and e-mail. Members will also be given the option to block any member they do not wish to communicate with.			</div>
				<?  if($reg_value=="0"){
					if($event_status==0){
					?>
               	<div class="fright" style="background:url(images/log_deactimg.gif);height:253px;width:404px;">
				<div style="padding-top:75px;padding-left:37px;"><font style="color:#C3C3C3;">Login to the <b><?=ucfirst($event_title);?></b> Virtual Matrimony Meet</font></div>
				</div>
				 <?}elseif($event_status==1){?>
                 <div class="fright" style="background:url(images/log_deactimg_thank.gif);height:253px;width:404px;">
				<div style="padding-top:75px;padding-left:37px;"><font style="color:#C3C3C3;">Login to the <b><?=ucfirst($event_title);?></b> Virtual Matrimony Meet</font></div>
				</div>
				<? }}?>
								
				<!--{ Member Login -->
				<?if($reg_value!="0"){?>
				<FORM name="ClassifiedForm" action="vmlogin.php?evid=<?=$evid?>" method=post onSubmit="return validate();">
                <input type=hidden name="evid" value="<?=$evid?>">
                <div class="fright" style="background:url(images/log_actimg.gif) no-repeat;width:404px;overflow:auto;">
     				<div style="padding-left:4px;"><?=$_GET['ErrMsg'];?></div>
					
					<div style="padding-top:85px;padding-left:37px;">Login to the <b><?=ucfirst($event_title);?></b> Virtual Matrimony Meet</div><br>
					<?php
					if(isset($ErrMsg))
					{
					echo "<div style='padding:0px 38px;padding-bottom:10px;'><font class='smalltxt clr1'>$ErrMsg</font></div>";
					}
					?>
					
                    <div style="padding-left:45px;padding-bottom:10px;" class="smalltxt"><b>Date:</b> <?=$event_date?> <br><b>Event times:</b> <?=$event_starttime?> - <?=$event_endtime?> IST</div>   
					<div style="padding-left:45px;padding-bottom:10px;" class="smalltxt"><b>Matrimony ID / E-mail</b>&nbsp;&nbsp;<input type="text" class="inputtext" style="width:180px;" name="matriid" id="matriid" value="" tabindex="1" onKeyUp=""/></div>
					<div style="padding-left:103px;padding-bottom:10px;" class="smalltxt"><b>Password</b>&nbsp;&nbsp;<input type="password" class="inputtext" style="width:180px;" name="password" id="password" value="" maxlength=25  tabindex="2" size="32"/></div>
					<div style="padding-left:165px;padding-bottom:10px;" class="smalltxt"><a href="http://www.<?=$varDomainName;?>/login/index.php?act=forgotpwd" target="_blank" class="clr1" tabindex="4">Forgot password?</a><img src="images/trans.gif" width="34" height="1" /><input type="submit" class="button" name="submit" value="Submit" tabindex="3"/></div>
					<div style="background-color:#dbdbdb;height:1px;"><img src="images/trans.gif" width="1" height="1" /></div>
				</div>
                <?}?>									
				<!-- Member Login }-->

				
				<br clear="all"/><br>
				<div class="normtxt tljust lh16" style="padding-left:1px;">
				<b>Who can participate?</b><br>
				All members can participate. Paid members can initiate contact and chat with anyone they choose. Free members cannot initiate contact but they can reply to the chat messages initiated by paid members.<br><br>
				<b>What happens after the event?</b><br>
				Post the event, members will be sent an e-mail with a link to view the Chat Transcript, i.e. the communication exchanged between the member and other members during the event. The Chat Transcript will be available only for 7 days from the close of event.<br><br>
					If you have any ideas or suggestions regarding the Virtual Matrimony Meet,<br> please feel free to e-mail us at <a href="mailto:virtualmatrimonymeet@<?=$arrPrefixDomainList[$varMatriIdPrefix];?>" class="clr1">virtualmatrimonymeet@<?=$arrPrefixDomainList[$varMatriIdPrefix];?>.</a><br><br>
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
</body>
</html>
<script>
//setwload();
var url=location.href;
var findstr=url.indexOf('www.');
if(findstr != -1){
if($('spacedivmid') && rp_equaldiv!="2")
{makeequal1('middlediv','rightnavh');}
}
</script>
</center>
</body>
</html>

<? 
/* Campaign LMS Track */
$varTrackId			= addslashes(strip_tags(trim($_REQUEST['trackid'])));
$varFormFeed		= addslashes(strip_tags(trim($_REQUEST['formfeed'])));

if ($varTrackId!="" && $varFormFeed=='y') {
 echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/clicktrack.php?trackid=".$varTrackId."&formfeed=y\"></script>";
}
} ?>
