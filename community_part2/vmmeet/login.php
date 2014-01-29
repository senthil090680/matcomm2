<?php
//error_reporting(0);
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
$EventInfo=get_event_info($evid);


$event_date=$EventInfo['event_date'];
$event_title=$EventInfo['EventTitle'];
$event_starttime=strtolower($EventInfo['event_starttime']);
$event_endtime=strtolower($EventInfo['event_endtime']);
$remain_date=$EventInfo['diffdate'];
$event_caste=$EventInfo['EventCaste'];
$ind_rate=round($EventInfo['INR_Rate'],0);
$us_rate=round($EventInfo['USD_Rate'],0);
$aed_rate=round($EventInfo['AED_Rate'],0);
$euro_rate=round($EventInfo['EURO_Rate'],0);
$gbp_rate=round($EventInfo['GBP_Rate'],0);
$nowdate=date("jS F Y");
$date_checking=date("Y-m-d");
$time_date_checking=date("Y-m-d H:i:s");

if (getenv(HTTP_X_FORWARDED_FOR)) {
$IPADDRESS = getenv(HTTP_X_FORWARDED_FOR);
} else {
$IPADDRESS = getenv(REMOTE_ADDR);
}
$ip=$IPADDRESS;
$ufilename="http://www.bharatmatrimony.com/cgi-bin/getip2country.cgi?IP=$ip";
//$cc = file_get_contents($ufilename);
$cc="US";
if($cc == "IN")
{
$pay_value="Rs. ".$ind_rate;
}else if(($cc=="UK") || ($cc=="GB")){
$pay_value="GBP ".$gbp_rate;
}else if(($cc=="BH")||($cc=="CY")||($cc=="EG")||($cc=="IR")||($cc=="IQ")||($cc=="IL")||($cc=="JO")||($cc=="KW")||($cc=="LB")||($cc=="OM")||($cc=="QA")|| ($cc=="SA")||($cc=="SY")||($cc=="TR")||($cc=="AE")||($cc=="YE")){
$pay_value="AED ".$aed_rate;
}else
if(($cc=="AL")||($cc=="AD")||($cc=="AT")||($cc=="BY")||($cc=="BE")||($cc=="BA")||($cc=="BG")||($cc=="HR")||($cc=="CZ")||($cc=="DK")||($cc=="EE")|| ($cc=="FI")||($cc=="FR")||($cc=="DE")||($cc=="GR")||($cc=="HU") || ($cc=="IS")||($cc=="IE")||($cc=="IT")||($cc=="LV")||($cc=="LI")||($cc=="LU")||($cc=="MO")||($cc=="MT")||($cc=="MD")||($cc=="MC")||($cc=="NL")|| ($cc=="PL")||($cc=="PT")||($cc=="RO")||($cc=="RU")||($cc=="SM") || ($cc=="SK")||($cc=="SI")||($cc=="ES")||($cc=="SE")||($cc=="CH")||($cc=="TR")||($cc=="UA")){
$pay_value=$euro_rate." Euro";
}else{
$pay_value="US$ ".$us_rate;
}



$reg_query="select EventId  from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATCONFIGURATIONS']." where date(now())='".$date_checking."' and (time('".$time_date_checking."')>=SUBTIME(EventStartTime,'00:30:00') and time('".$time_date_checking."')<=EventEndTime) and  EventId=$evid";
$reg_value=$db->select($reg_query);

if(isset($_POST["submit"]))
{ echo "3333333333submited333333";
$matriid=mysql_escape_string(trim($_POST["matriid"]));	
$password1=mysql_escape_string(trim($_POST["password"]));
$cdomain = $_SERVER['SERVER_NAME'];
setcookie("username",$matriid,0,"/",$cdomain);
setcookie("password",$password1,0,"/",$cdomain);
$password=substr($password1,0,8);

$paid_query = "select MatriId,EntryType,Gender from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE']."  where MatriId='$matriid' and Caste in($event_caste)";
$paid_aff_row=$db->select($paid_query);
$paid_res=$db->fetchArray();
$entry_type=$paid_res['EntryType'];
$paid_gender=$paid_res['Gender'];
$paid_mem_id=$paid_res['MatriId'];

if($entry_type=='R'){
	$insert_matrimonymeet="insert ignore into ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAM']." (MatriId,EventId,Gender,PaymentReceived,Comments) values ('$paid_mem_id','$evid','$paid_gender','1','BM Member')";	
	$db->insert($insert_matrimonymeet);
}

//$query="select MatriId from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['LOGININFO']."  where (MatriId='$matriid' or //Email='$matriid') and password='$password'";
//$value=$db->select($query);
//$res=$db->fetchArray();
//$memberid= $res['MatriId'];		
$memberid = $matriid;
echo $query1="select MatriId,EventId from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAM']."  where MatriId='$memberid' and EventId=$evid";
$value1=$db->select($query1);
if($value==1)
{
$ErrMsg = "Email or Password is invalid or inactive";
}else if($value1==0){
$ErrMsg = "You are not the Authorized Person For Chat";
}
else
{

$cookie_query= "select MatriId,Gender from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAM']."  where MatriId='$memberid' and EventId=$evid";
$db->select($cookie_query);
$cookie_res=$db->fetchArray();

$cdomain = $_SERVER['SERVER_NAME'];
$cdomain = str_replace(array("www","bmser"),"",$cdomain);
setcookie("Memberid",$cookie_res['MatriId'],0,"/",$cdomain);
setcookie("Gender",$cookie_res['Gender'],0,"/",$cdomain);
$member_id=$_COOKIE['Memberid'];
$gender=$_COOKIE['Gender'];
$update_query="update ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAM']." set Status=1,LastActivity=now() where MatriId='$memberid' and EventId=$evid";
$db->update($update_query);
header("location:memberonline.php?evid=$evid");
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
 win=window.open(turl,"Termsandconditions","menubar=0,resizable=0,scrollbars=1,width=570,height=450")
}
//  -->
</SCRIPT>
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
					<div class="bl"><div class="br"><div class="tl"><div class="tr">
					<div  style="padding:0px 15px 0px 15px !important;padding:1px 15px 0px 15px;">
						<div class="fleft" style="padding-bottom:15px !important;padding-bottom:0px;">
						 <div class="fleft " style="padding: 15px 25px 0px 25px;">
							<div style="background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-top-img.gif) no-repeat; width:470px; height:134px;"></div>
						 </div>
						 
						 <div class="fleft dotline smalltxt" style="padding: 20px 0px 30px 20px;margin-top:20px">
							<div style="width:180px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-orng-arrow.gif" width="4" height="7" hspace="5"/>It is a Virtual Swayamvar<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="8" hspace="5"/><br/>
							<img src="http://imgs.bharatmatrimony.com/bmimages/hp-orng-arrow.gif" width="4" height="7" hspace="5"/>Connect with members of your <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;community from across the world<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="8" hspace="5"/><br/>
							<img src="http://imgs.bharatmatrimony.com/bmimages/hp-orng-arrow.gif" width="4" height="7" hspace="5"/>Chat and Interact real time 
							</div>

						 </div><br clear="all">			
					   </div>
					</div><br clear="all">					
					</div></div>	</div></div>
			</div></div>
			<!-- Content Area-1 }-->
	</div></div>

	<div id="rndcorner" class="fleft">
		<div style="float:left;width:772px;background-color:#EEE">
			<div style="padding-right:25px;" class="fright clr">10 days to Online Matrimony Meet</div><br clear="al">
			<!-- Content Area-1-->
			<div style="width:761px;padding-top:5px;">
			<div class="middiv-pad">		
					<div class="bl"><div class="br"><div class="tl"><div class="tr">
					<div class=" smalltxt clr" style="padding:5px 15px 0px 15px;">
						<div style="padding:15px;">
								<div style="padding-bottom:5px;"><font class="bigtxt"><?=$event_title?> Online Matrimony Meet -</font> <?=$event_date?> (<?=$event_starttime?> - <?=$event_endtime?>  IST)</div>

								<div class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">

								<div style="position:relative;height:550px;">
									<div class="content" style="position:absolute;">
										<div style="width:375px;">
										Online Matrimony Meet a Virtual Swayamvar from BharatMatrimony.com will create a platform for singles from around the world of a particular caste or community to meet, interact and hopefully find a life partner at just the click of a mouse.<br><br>

										BharatMatrimony.com is organizing an Online Matrimony Meet for the <?=$event_title?> community. The meet will be held on <?=$event_date?> between <?=$event_starttime?> and <?=$event_endtime?> IST. <br><br>

										If you belong to the above caste this is a wonderful opportunity for you to interact with prospective partners from your own community. Don't miss out.</div>
										<div style="padding: 25px 0px 10px 0px;">
										<font class="mediumtxt boldtxt">How it works?</font>
										<div class="vdotline1" style="width:375px;margin-top:5px;"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">
										<ul id="ommlist">
										<li>Both free and paid members can participate.</li>
										<li>The event is held for a duration of 3 hours.
										<li >The list of participants will be displayed on the events page. During the <br>event you can chat with any member.
										<li>If you are a paid member you can initiate chat and also send instant e-mails if you wish.
										<li>If you are a free member you can reply to the chat conversations and e-mails initiated by paid members.
										<li>You can search based on various criteria and identify members with whom you wish to chat.
										<li>You can block any member with whom you do not wish to communicate.
										<li>If your filter settings is ON during the event, we suggest you TURN IT OFF.
										<li>We recommend you add your photo and horoscope prior to the event.
										<li>At the end of the event, the chat transcript that includes all the communication exchanged between you and members you have chatted with will be available in "My Home" for the next one month.</ul>
										
										
										</div><br clear="all"><br>
										<div style="padding-bottom:5px;"><a href="onlinemeetloginform.php?evid=<?=$evid?>" class="clr1 boldtxt"><u>Click here to participate in the Online Matrimony Meet FREE</u></a></div>

										<div class="vdotline1"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" height="1" width="100%"/></div><br clear="all">
										<div style="text-align:left;">If you have any ideas or suggestions regarding the Online Matrimony Meet, please feel free to e-mail us at <a href="mailto:onlinematrimonymeet@bharatmatrimony.com">onlinematrimonymeet@bharatmatrimony.com</a></div>

								
									</div>

									<div style="position:absolute;padding-left:390px;">
									<!--greay area-->
									<?  if($reg_value=="0"){?>
									<div id="loginarea" style="background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-loginimg.gif) no-repeat; width:301px; height:276px;">
										<div style="padding:50px 0px 0px 38px;">
												<div style="width:205px;">Login to the <b><?=$event_title?></b> Online Matrimony Meet</div>
												
												<div style="width:205px;padding: 5px 0px;"><b>Date:</b> <?=$event_date?> <br>
												<b>Event times:</b> <?=$event_starttime?> - <?=$event_endtime?> IST</div>
										</div>
									
									</div>
									<? }?>
									<!--greay area-->
									
									<!--{ Member Login -->
									<? if($reg_value=="0"){ ?>
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
<FORM name="ClassifiedForm" action="login.php?evid=<?=$evid?>" method=post onSubmit="return validate();">
<input type=hidden name="evid" value="<?=$evid?>">


<? }?>
															<?php
															if(isset($ErrMsg))
															{
															echo "<div><font class='normaltxt1'><font color='#ff0000'>$ErrMsg</font></font></div>";
															}
															?>
															<? if($reg_value=="0"){?>

															<div style="padding-left:4px;"><?=$_GET['ErrMsg'];?></div>
															<div style="width:205px;">Login to the <b><?=$event_title?></b> Online Matrimony Meet</div>
															
															<div style="width:205px;padding: 5px 0px;"><b>Date:</b> <?=$event_date?> <br>
															<b>Event times:</b> <?=$event_starttime?> - <?=$event_endtime?> IST</div>
															
															
															<div style="width:205px;">
															<span id='error' class="errortxt" style="display:none"></span>
															<font class="smalltxt boldtxt"><label for="ID">Matrimony ID / E-mail</label></font><br><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="1" height="3"><br><input type="text" name="matriid" id="matriid" value="" tabindex="1" size="32" class="inputtext" onKeyUp=""></div>

															<div style="padding-top:5px;width:205px"><font class="smalltxt boldtxt"><label for="PASSWORD">Password</label></font><br><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="1" height="3"><br><input type="password" name="password" id="password" value="" maxlength=8  tabindex="2" size="32" class="inputtext" onKeyUp="errorclear(this.value);"></div>
															<div style="width:188px;padding-top:0px;text-align:right"><a href="JavaScript:void(0)" onClick="JavaScript:fade('rndcorner','fadediv','dispdiv','450','','','forgotpasswdconfirm.php','','GET','','');errorclear('e');" class="smalltxt clr1" tabindex="3">Forgot Password?</a></font></div>
															<div style="width:188px;padding-top:5px;text-align:right"><input type="submit" value="Submit" class="button" name="submit" tabindex="4" onClick="return validate();"></div>
															
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
</center>
</body>
</html><script src="http://server.bharatmatrimony.com/campaign/Aff_client_track.php?matriid=M1366899"></script>

