<?php
//error_reporting(0);For Error Printing
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']); 
$DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
$db = new db();
$db->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ONLINESWAYAMVARAM']);
$language=getDomainInfo();
$domain_language=$language["domainnameshort"];
include_once "chatfunctions.php";
$evid=trim($_REQUEST['evid']);

//Check whether the evid id is number.if not, Redirect to events list page
if(is_numeric($evid) != 1) {
         echo "<script>alert('Invalid Event Id.');	window.location = 'http://www.bharatmatrimony.com/events.php';</script>";
	exit;
 } 
else {
$EventInfo=get_event_info($evid);
$evt_date=$EventInfo['evt_date'];
$event_date=$EventInfo['event_date'];
$event_title=$EventInfo['EventTitle'];
$event_starttime=strtolower($EventInfo['event_starttime']);
$event_endtime=strtolower($EventInfo['event_endtime']);
$remain_date=$EventInfo['diffdate'];
$event_caste=$EventInfo['EventCaste'];
$event_religion=$EventInfo['EventReligion'];
$event_language=$EventInfo['EventLanguage'];

$nowdate=date("jS F Y");
$date_checking=date("Y-m-d");
$time_date_checking=date("Y-m-d H:i:s");
// Get Event details from table
$reg_query="select EventId  from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATCONFIGURATIONS']." where EventId=$evid";
$reg_value=$db->select($reg_query);

if(isset($_POST["submit"]))
{ 
$matriid=mysql_escape_string(trim($_POST["matriid"]));	
$password=mysql_escape_string(trim($_POST["password"]));
$cdomain = $_SERVER['SERVER_NAME'];
// Logging with Matrimony ID connect to the respective slave server
$fid=substr(ucfirst($matriid),0,1);
if (in_array($fid,$GLOBALS['IDSTARTLETTERHASH']) && (stristr($matriid,"@") == FALSE)&&(stristr($matriid,".") == FALSE))
{
$db->dbClose();
$db = new db();
$db->dbConnById(2,$matriid,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);	
if ($db->error) 
{
echo $ErrMsg=$ERRORMSG;
$db->dbClose();
exit;
} 
// Take values from individual domain tables
$currentlangarray = getDomainInfo(1,$matriid);
$profiletable=$DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($currentlangarray['domainnameshort'])]['MATRIMONYPROFILE'];
$logintable=$DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($currentlangarray['domainnameshort'])]['LOGININFO'];
}
else
{
// Logging with Email id. Based on the event language connect to the respective slave server
if($event_language!="" && $event_language!=0) {
$languageVal = substr($event_language,0,1);
$db=new db();
$db->dbConnById(1, $languageVal,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
}
$profiletable=$DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE'];
$logintable=$DBNAME['MATRIMONYMS'].".".$MERGETABLE['LOGININFO'];
}
// Authenticate user information
$query="select MatriId from ".$logintable."  where (MatriId='$matriid' or Email='$matriid') and password='$password'";
$password=strtolower($password);
$value=$db->select($query);
if($value>0)
{
// User found proceed further
	$matriidStr  = $db->fetchArray();
    $matriidVal  = strtoupper($matriidStr['MatriId']);
$query = "select MatriId,EntryType,Gender,Caste,Language,CasteNoBar,Religion from ".$profiletable."  where MatriId='$matriidVal' and Validated=1 and Authorized = 1 and Status<2";
$aff_row=$db->select($query);
$res=$db->fetchArray(); 


if($aff_row > 0 ) 
{
// Profile details found 
$eventcastedisplay=$res['Caste'];

echo "event_Caste=".$event_caste; echo "<br>";

echo "CasteNoBar=".$res["CasteNoBar"];echo "<br>";
if(($event_caste == 998)&&($res["CasteNoBar"]=="1"))
{
$eventcastedisplay=998;
}


echo $qry = "select EventId,EventTitle,DATE_FORMAT(EventDate,'%D %M %Y') as event_date,TIME_FORMAT(EventStartTime,'%l' '%p') as event_starttime,TIME_FORMAT(EventEndTime,'%l' '%p') as event_endtime, CASE WHEN EventLanguage<>'' THEN FIND_IN_SET('".$res['Language']."',EventLanguage) ELSE 1 END AS eventlanguagecondition, CASE WHEN EventCaste<>'' THEN FIND_IN_SET('".$eventcastedisplay."',EventCaste) ELSE 1 END AS eventcastecondition, CASE WHEN EventReligion<>'' THEN FIND_IN_SET('".$res['Religion']."',EventReligion) ELSE 1 END AS eventreligioncondition  from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATCONFIGURATIONS']." where EventId='".$evid."' having eventlanguagecondition>0 and eventcastecondition>0 and eventreligioncondition>0";
$row=$db->select($qry);

$res_set=$db->fetchArray(); 
if($row !=0) {
$cdomain = $_SERVER['SERVER_NAME'];
$cdomain = str_replace(array("www","bmser"),"",$cdomain);
setcookie("username",$matriidVal,0,"/",$cdomain);
setcookie("password",$password,0,"/",$cdomain);
setcookie("Memberid",$matriidVal,0,"/",$cdomain);
setcookie("Gender",$res['Gender'],0,"/",$cdomain);
$member_id=$matriidVal;
$gender=$res['Gender']; 
//header("Location:memberonline_test.php?evid=$evid");
header("Location:memberonline_test.php?evid=$evid");
}
else 
{
$ErrMsg = "Sorry, this Virutal Matrimony Meet is only for the $event_title Community. You are not eligible to participate in it. <a href='http://www.bharatmatrimony.com/events.php'>Click here</a> to view the list of other forthcoming matrimony meets.";
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

<script language="javascript" src="http://<?=$GETDOMAININFO['domainmodule']?>/scripts/ajax.js" ></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainmodule']?>/template/headerjs.php" ></script>	
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/ST_common.js" ></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/div-opacity.js" ></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/equal-div.js"></script>

<META name="description" content="Indian Matrimony - Free Matrimonial - Register for FREE, Bharatmatrimony.com - Free matrimonials add your profile.">
<META name="keywords" content="Indian matrimony, free matrimonial, Add Profile, matrimonials, Telugu, tamil, sindhi, assamese, gujarati, malayalee, hindu, christian, muslim, register profile, matrimonial, add profile, success stories, search profiles, matrimonial website, Indian matrimony, marwadi, oriya, kannada, hindi, Free matrimonials, matrimony, desi match maker, match maker, online matrimony">
<TITLE>Indian Matrimony - Free Matrimonial - Register for FREE</TITLE>
<style>
ul#ommlist {margin:0;padding:0;list-style-type:none;width:auto; display:block;}
ul#ommlist li{ margin:0;background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-gbullet.gif) no-repeat center left; display: float; padding: 5px 5px 2px 10px;margin-top:px;}
</style>
<link rel="stylesheet" href="http://imgs.bharatmatrimony.com/bmstyles/global-style.css"></head>
<body>
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

	<div id="rndcorner" class="fleft">
		<div style="float:left;width:772px;background-color:#EEE">
		<?if($remain_date > 0) {?>
			<div style="padding-right:25px;" class="fright clr"><?=$remain_date?> days to Virtual Matrimony Meet</div><br clear="al">
			<?}?>
			<!-- Content Area-1-->
			<div style="width:761px;padding-top:5px;">
			<div class="middiv-pad">		
					<div class="bl"><div class="br"><div class="tl"><div class="tr">
					<div class=" smalltxt clr" style="padding:5px 15px 0px 15px;">
						<div style="padding:15px;">
								<div style="padding-bottom:5px;"><font class="bigtxt"><?=$event_title?> Virtual Matrimony Meet -</font> <?=$event_date?> (<?=$event_starttime?> - <?=$event_endtime?>  IST)</div>

								<div class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">

								<div style="position:relative;height:550px;">
									<div class="content" style="position:absolute;">
										<div style="width:375px;">
										Virtual Matrimony Meet a Virtual Swayamvar from BharatMatrimony.com will create a platform for singles from around the world of a particular caste or community to meet, interact and hopefully find a life partner at just the click of a mouse.<br><br>

										BharatMatrimony.com is organizing an Virtual Matrimony Meet for the <?=$event_title?> community. The meet will be held on <?=$event_date?> between <?=$event_starttime?> and <?=$event_endtime?> IST. <br><br>

										If you belong to the above caste this is a wonderful opportunity for you to interact with prospective partners from your own community. Don't miss out.</div>
										<div style="padding: 25px 0px 10px 0px;">
										<font class="mediumtxt boldtxt">How it works?</font>
										<div class="vdotline1" style="width:375px;margin-top:5px;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">
										<ul id="ommlist">
										<li>Both free and paid members can participate.</li>
										<li>The event is held for a duration of 2 hours.
										<li>Login to the events page to view the list of members participating in the event


										
										
										<li >The list of participants will be displayed on the events page. During the <br>event you can chat with any member.
										<li>If you are a paid member you can initiate chat and also send instant e-mails if you wish.
										<li>If you are a free member you can reply to the chat conversations and e-mails initiated by paid members.
										<li>You can search based on various criteria and identify members with whom you wish to chat.
										<li>You can block any member with whom you do not wish to communicate.
										<li>If your filter settings is ON during the event, we suggest you TURN IT OFF.
										<li>We recommend you add your photo and horoscope prior to the event.
										<li>At the end of the event, the chat transcript that includes all the communication exchanged between you and members you have chatted with will be sent to you by e-mail.</ul>
										
										
										</div><br clear="all">
										<!--<div style="padding-bottom:5px;"><a href="onlinemeetloginform.php?evid=<?=$evid?>" class="clr1 boldtxt"><u>Click here to participate in the Online Matrimony Meet FREE</u></a></div>
										-->

										<div class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">
										<div style="text-align:left;">If you have any ideas or suggestions regarding the Virtual Matrimony Meet, please feel free to e-mail us at <a href="mailto:onlinematrimonymeet@bharatmatrimony.com">onlinematrimonymeet@bharatmatrimony.com</a></div>

										
										<div style="padding-bottom:5px;padding-top:3px;"><a href="JavaScript:void(0)" onClick="javascript:terms(<?=$evid?>)" class="clr1" style="line-height:9px;">Terms and Conditions</a></div>
								
									</div>

									<div style="position:absolute;padding-left:390px;">
									<!--greay area-->
									<?  if($reg_value=="0"){?>
									<div id="loginarea" style="background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-loginimg.gif) no-repeat; width:301px; height:276px;">
										<div style="padding:50px 0px 0px 38px;">
												<div style="width:205px;">Login to the <b><?=$event_title?></b> Virtual Matrimony Meet</div>
												
												<div style="width:205px;padding: 5px 0px;"><b>Date:</b> <?=$event_date?> <br>
												<b>Event times:</b> <?=$event_starttime?> - <?=$event_endtime?> IST</div>
										</div>
									
									</div>
									<? }?>
									<!--greay area-->
									
									<!--{ Member Login -->
									<?if($reg_value!="0"){?>
										<div id="rndcorner" style="float:left;width:300px;">
										<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
											<div style="padding:5px 0px 5px 11px;">
												<div style="float:left;">
													<div style="float:left;background:url(http://imgs.tamilmatrimony.com/bmimages/tab-curve-bg.gif) repeat-x;height:41px;width:267">

													<div style="float:left;"><img src="http://imgs.tamilmatrimony.com/bmimages/tab-clr-lft.gif" width="6" height="41"></div>
													<div style="float:left;background:url(http://imgs.tamilmatrimony.com/bmimages/tab-clr-right.gif) no-repeat top right;height:41px;"><div style="padding:5px 20px 0 10;" class="mediumtxt1 boldtxt clr4">Member Login</div></div>
													</div>

													<div style="float:left;background:url(http://imgs.tamilmatrimony.com/bmimages/tr-3.gif) no-repeat;width:10;height:41px;border:0px solid #000000;"></div>
												</div>									
												<!-- Content Area -->
												<div style="width:277px;" id='log'>
												<div class="bl" >
													<div class="br" >
															<div style="padding: 0px 0px 0px 40px;" class="smalltxt">								
															<FORM name="ClassifiedForm" action="vmlogin_test.php?evid=<?=$evid?>" method=post onSubmit="return validate();">
<input type=hidden name="evid" value="<?=$evid?>">
															<?}?>
															<?php
															if(isset($ErrMsg))
															{
															echo "<div><font class='normaltxt1'><font color='#ff0000'>$ErrMsg</font></font></div>";
															}
															?>
															<?if($reg_value!="0"){?>

															<div style="padding-left:4px;"><?=$_GET['ErrMsg'];?></div>
															<div style="width:205px;">Login to the <b><?=$event_title?></b> Online Matrimony Meet</div>
															
															<div style="width:205px;padding: 5px 0px;"><b>Date:</b> <?=$event_date?> <br>
															<b>Event times:</b> <?=$event_starttime?> - <?=$event_endtime?> IST</div>
															
															
															<div style="width:205px;">
															<span id='error' class="errortxt" style="display:none"></span>
															<font class="smalltxt boldtxt"><label for="ID">Matrimony ID / E-mail</label></font><br><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="1" height="3"><br><input type="text" name="matriid" id="matriid" value="" tabindex="1" size="32" class="inputtext" onKeyUp=""></div>

															<div style="padding-top:5px;width:205px"><font class="smalltxt boldtxt"><label for="PASSWORD">Password</label></font><br><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="1" height="3"><br><input type="password" name="password" id="password" value="" maxlength=8  tabindex="2" size="32" class="inputtext" onKeyUp=""></div>
															<div style="width:188px;padding-top:0px;text-align:right"><!--<a href="JavaScript:void(0)" onClick="JavaScript:fade('rndcorner','fadediv','dispdiv','450','','','http://<?=$GETDOMAININFO['domainmodule']?>/login/forgotpasswdconfirm.php','','GET','','');errorclear('e');" class="smalltxt clr1" tabindex="3">Forgot Password?</a>--></font></div>
															<div style="width:188px;padding-top:5px;text-align:right"><input type="submit" value="Submit" class="button"  name="submit" tabindex="4" onClick="return validate();"></div>
															
															<br clear="all"></form>
															</div>						
													</div>
												</div>
												</div>

												<!-- Content Area -->
											</div>
											<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
										</div>
										<?}?>									
									<!-- Member Login }-->
									
									</div>
								</div><br clear="all">
								
						</div>						 
					</div><br clear="all">					
					</div></div>	</div></div>
			</div></div>
			<!-- Content Area-1 }-->
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div></div>

	</div>
</div><br clear="all">
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

<? } ?>

