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

$evid=trim($_REQUEST['evid']);
$EventInfo=get_event_info($evid);
$event_date=$EventInfo['event_date'];
$event_title=$EventInfo['EventTitle'];
$event_starttime=strtolower($EventInfo['event_starttime']);
$event_endtime=strtolower($EventInfo['event_endtime']);
$event_opendate=$EventInfo['event_opendate'];
$event_closedate=$EventInfo['event_closedate'];
$ip=$IPADDRESS;
$ufilename="http://www.bharatmatrimony.com/cgi-bin/getip2country.cgi?IP=$ip";
$cc = file_get_contents($ufilename);
if(($cc=="BH")||($cc=="CY")||($cc=="EG")||($cc=="IR")||($cc=="IQ")||($cc=="IL")||($cc=="JO")||($cc=="KW")||($cc=="LB")||($cc=="OM")||($cc=="QA")|| ($cc=="SA")||($cc=="SY")||($cc=="TR")||($cc=="AE")||($cc=="YE")){
$pay_str="rupees";
$cl_val=".com";
}else
if(($cc=="AL")||($cc=="AD")||($cc=="AT")||($cc=="BY")||($cc=="BE")||($cc=="BA")||($cc=="BG")||($cc=="HR")||($cc=="CZ")||($cc=="DK")||($cc=="EE")|| ($cc=="FI")||($cc=="FR")||($cc=="DE")||($cc=="GR")||($cc=="HU") || ($cc=="IS")||($cc=="IE")||($cc=="IT")||($cc=="LV")||($cc=="LI")||($cc=="LU")||($cc=="MO")||($cc=="MT")||($cc=="MD")||($cc=="MC")||($cc=="NL")|| ($cc=="PL")||($cc=="PT")||($cc=="RO")||($cc=="RU")||($cc=="SM") || ($cc=="SK")||($cc=="SI")||($cc=="ES")||($cc=="SE")||($cc=="CH")||($cc=="TR")||($cc=="UA")){
$pay_str="dihrams";
$cl_val=" LLC";
}else{
$pay_str="dollors";
$cl_val=".com";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Online Matrimony Meet</TITLE>
</HEAD>
<link rel="stylesheet" href="http://www.communitymatrimony.com/styles/bmstyle.css">
<BODY style="margin:0px;">

<table border="0" cellspacing="0" cellpadding="0" width="548" style="border:solid 1px #80CAE5;font:normal 11px verdana;line-height:15px;text-align:justify;">
	<tr>
		<td valign="top" style="font:bold 14px verdana;padding:20px;">Terms and Conditions</td>
		<td valign="top" align="right" style="padding-right:20px;padding-top:10px;"><a href="javascript:window.close()" style="font:bold 12px arial,verdana,MS Sans serif;color:#F68633;text-decoration:none;">Close X</a></td>
	
	<tr>
		<td valign="top"><IMG SRC="http://www.communitymatrimony.com/images/onmm-text.gif" WIDTH="373" HEIGHT="92" BORDER="0" ALT=""></td>
		<td valign="top" rowspan="3"><IMG SRC="http://www.communitymatrimony.com/images/onmm-girl.jpg" WIDTH="175" HEIGHT="220" BORDER="0" ALT=""></td>
	</tr>
	<tr>
		<td valign="top" background="http://www.communitymatrimony.com/images/onmm-mouse.jpg" WIDTH="373" HEIGHT="128" BORDER="0" ALT=""><BR><BR><BR><BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="45" HEIGHT="1" BORDER="0" ALT=""><IMG SRC="http://www.communitymatrimony.com/images/onmm-bullet.gif" WIDTH="5" HEIGHT="5" BORDER="0" ALT="">&nbsp;&nbsp;<font color="#FFFFFF">One of a kind Virtual Swayamvar<BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="45" HEIGHT="13" BORDER="0" ALT=""><IMG SRC="http://www.communitymatrimony.com/images/onmm-bullet.gif" WIDTH="5" HEIGHT="5" BORDER="0" ALT="">&nbsp;&nbsp;Enjoy real time one-to-one chat<BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="45" HEIGHT="13" BORDER="0" ALT=""><IMG SRC="http://www.communitymatrimony.com/images/onmm-bullet.gif" WIDTH="5" HEIGHT="5" BORDER="0" ALT="">&nbsp;&nbsp;Connect with members of your <br><img src="http://www.communitymatrimony.com/images/trans.gif" height=1 width=58>community from across the world</font></td>
	</tr>
	<tr>
		<td valign="top" colspan="2" style="padding-left:15px;padding-top:20px;">
			<table border="0" cellspacing="0" cellpadding="0" width="460" style="font:normal 11px verdana;text-align:justify;">
				<tr>
					<td valign="top" WIDTH="12" style="padding-top:5px;"><IMG SRC="http://www.communitymatrimony.com/images/onmm-orangebullet.gif" WIDTH="4" HEIGHT="7" BORDER="0" ALT=""></td>
					<td valign="top" width="448" style="line-height:15px;">The Online Matrimony Meet for the <?=$event_title?> community organized by BharatMatrimony.com will be held on<BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="12" HEIGHT="15" BORDER="0" ALT=""><B>Date:</B> <?=$event_date?><BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="12" HEIGHT="15" BORDER="0" ALT=""><B>Time:</B> <?=$event_starttime?> - <?=$event_endtime?> IST</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td valign="top" colspan="2" style="padding-left:15px;padding-top:20px;padding-bottom:30px;">
			<table border="0" cellspacing="0" cellpadding="0" width="520" style="font:normal 11px verdana;text-align:justify;">
				<tr>
					<td valign="top" WIDTH="12" style="padding-top:5px;"><IMG SRC="http://www.communitymatrimony.com/images/onmm-orangebullet.gif" WIDTH="4" HEIGHT="7" BORDER="0" ALT=""></td>
					<td valign="top" width="508" style="line-height:15px;">Registration for the Online Matrimony Meet<BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="1" HEIGHT="7" BORDER="0" ALT=""><br>
Registration is FREE for paid members and free members are charged a special fee that is non-refundable and payment made in <?=$pay_str?> is payable by Credit Card, Cheque or DD at any of our <a href="http://www.bharatmatrimony.com/contact.shtml" class="linktxt" target="_blank">offices</a> across the globe. Cheque or DD should be drawn in favor of <b>'Consim Info Pvt. Ltd'</b>.<br><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="12" HEIGHT="15" BORDER="0" ALT=""><br><font style="font:normal 10px verdana;color:#666666;">Those who wish to make offline payments must register and pay one day in advance.</font><BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="12" HEIGHT="15" BORDER="0" ALT=""><br><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="12" HEIGHT="15" BORDER="0" ALT="">Registration opens on: <?=$event_opendate?><BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="12" HEIGHT="15" BORDER="0" ALT="">Closes On: <?=$event_closedate?> for payments made online<BR></font></td>
				</tr>
				<tr height="15"><td colspan="2"></td></tr>
				<tr>
					<td valign="top" WIDTH="12" style="padding-top:5px;"><IMG SRC="http://www.communitymatrimony.com/images/onmm-orangebullet.gif" WIDTH="4" HEIGHT="7" BORDER="0" ALT=""></td>
					<td valign="top" width="493" style="line-height:15px;">Only the registered members will be allowed to participate. All participants can login just before the event.</td>
				</tr>
				<tr height="15"><td colspan="2"></td></tr>
				<tr>
				<td valign="top" bgcolor="#FBFAF1" width="520" colspan="2" style="padding-top:5px;padding-left:15px;padding-right:15px;padding-bottom:15px;"><B>During the event:</B><BR><IMG SRC="http://www.communitymatrimony.com/images/trans.gif" WIDTH="1" HEIGHT="12" BORDER="0" ALT=""><BR>
				<li style="padding-left:15px;">Communication with members is only through Chat.</li>
				<li style="padding-left:15px;padding-top:15px;">Male participants can contact female participants who are not more than 10<br>&nbsp;&nbsp;&nbsp;&nbsp;years younger and 3 years older to them.</li>
				<li style="padding-left:15px;padding-top:15px;">Female participants can contact male participants who are not more than 10 <br>&nbsp;&nbsp;&nbsp;&nbsp;years older and 3 years younger to them.</li>
				<li style="padding-left:15px;padding-top:15px;">All participants are expected to conduct themselves in an appropriate manner <br>&nbsp;&nbsp;&nbsp;&nbsp;during the event.</li>				
				<li style="padding-left:15px;padding-top:15px;">In the chat room people have only two ways of judging what you're thinking. <br>&nbsp;&nbsp;&nbsp;&nbsp;One is by the words you choose and the other is by the manners you use. So <br>&nbsp;&nbsp;&nbsp;&nbsp;be as polite as possible and choose your words wisely. Please do not use <br>&nbsp;&nbsp;&nbsp;&nbsp;abusive or foul language.</li>				
				<li style="padding-left:15px;padding-top:15px;">BharatMatrimony reserves the right to ask anyone who behaves otherwise to <br>&nbsp;&nbsp;&nbsp;&nbsp;leave the chat room immediately.</li>	
				</td>
				


				</tr>
				<tr height="15"><td colspan="2"></td></tr>
				<tr>
					<td valign="top" WIDTH="12" style="padding-top:5px;"><IMG SRC="http://www.communitymatrimony.com/images/onmm-orangebullet.gif" WIDTH="4" HEIGHT="7" BORDER="0" ALT=""></td>
					<td valign="top" width="493" style="line-height:15px;">BharatMatrimony.com does not guarantee on the number of participants or on matching prospects participating in the Online Matrimony Meet.</td>
				</tr>
				<tr height="15"><td colspan="2"></td></tr>
				<tr>
					<td valign="top" WIDTH="12" style="padding-top:5px;"><IMG SRC="http://www.communitymatrimony.com/images/onmm-orangebullet.gif" WIDTH="4" HEIGHT="7" BORDER="0" ALT=""></td>
					<td valign="top" width="493" style="line-height:15px;">BharatMatrimony.com reserves the right to cancel the Online Matrimony Meet, in case of any unforeseen circumstances. If event is cancelled, the registration fee, if already paid, will be refunded.</td>
				</tr>
				<tr height="15"><td colspan="2"></td></tr>
				<tr>
					<td valign="top" WIDTH="12" style="padding-top:5px;"><IMG SRC="http://www.communitymatrimony.com/images/onmm-orangebullet.gif" WIDTH="4" HEIGHT="7" BORDER="0" ALT=""></td>
					<td valign="top" width="493" style="line-height:15px;">BharatMatrimony.com does not vouch for or subscribe to the claims and representation made by other members regarding particulars of status, age, income, character, etc. Any dispute shall be subject to the exclusive jurisdiction of courts in Chennai only.</td>
				</tr>
			</table>
		</td>
</table>
</BODY>
</HTML>
