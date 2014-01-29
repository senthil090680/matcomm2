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

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);
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
	<link rel="alternate stylesheet" href="http://img.agarwalmatrimony.com/styles/small.css" title="smf" />
	<link rel="alternate stylesheet" href="http://img.agarwalmatrimony.com/styles/medium.css" title="mdf" />
	<link rel="alternate stylesheet" href="http://img.agarwalmatrimony.com/styles/large.css" title="lrg" />
	<script src="http://img.agarwalmatrimony.com/scripts/global.js" language="javascript"></script>
	<script src="http://img.agarwalmatrimony.com/scripts/fontvar.js" language="javascript"></script>
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

				<div class="bld padtb10">Terms and Conditions</div>
				<div class="dotsep2"><img src="http://img.agarwalmatrimony.com/images/trans.gif" width="1" height="1" /></div><br clear="all"/>
				<div class="lh16 normtxt clr">
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20"><li>The <b>Virtual Matrimony Meet for the <?=ucfirst($arrFolderNames[$varMatriIdPrefix])?></b> community organized by CommunityMatrimony.com will be held on<br>
					<b>Date:</b> <?=$EventDate_disp;?><br>
					<b>Time:</b> <?=$EventStartTime_disp;?> - <?=$EventEndTime_disp;?> IST</li>
					</ul>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20">
					<li><b>Who can participate?</b><br>
					All members can participate. Paid members can initiate contact and chat with anyone they choose. As a free member, you cannot initiate contact but you can reply to the chat messages initiated by paid members. Become a paid member today to enjoy full participation and gain maximum benefit.</li>
					</ul>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20">
					<li>Only the registered members will be allowed to participate. All participants can login just before the event.</li>
					</ul>
					<div class="brdr" style="background-color:#F7F7F7;padding:15px;"><b>During the event</b><br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">Communication with members is only through chat.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">If you're a paid member you can initiate chat and also send instant e-mails if you wish.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">If you're a free member you can reply to the chat conversations and e-mails sent by paid members.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">Male participants can contact female participants who are not more than 10 years younger and 3 years older to them.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">Female participants can contact male participants who are not more than 10 years older and 3 years younger to them.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">All participants are expected to conduct themselves in an appropriate manner during the event.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">In the chat room people have only two ways of judging what you are thinking. One is by the words you choose and the other is by the <img src="images/trans.gif" width="23" height="1" />manners you use. So be as polite as possible and choose your words wisely. Please do not use abusive or foul language.<br><img src="images/trans.gif" width="1" height="6" /><br>
					<img src="http://img.agarwalmatrimony.com/images/arrow1.gif" hspace="10">CommunityMatrimony.com reserves the right to ask anyone who behaves otherwise to leave the chat room immediately.
					</div>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20"><li>CommunityMatrimony.com does not guarantee on the number of participants or on matching prospects participating in the Virtual Matrimony Meet.</li></ul>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20">
					<li>CommunityMatrimony.com reserves the right to cancel the Virtual Matrimony Meet, in case of any unforeseen circumstances. If the event is cancelled, the registration fee, if already paid, will be refunded.</li>
					</ul>
					<ul style="margin-left: 10px ! important; padding-left: 5px ! important;" class="lh20">
					<li>CommunityMatrimony.com does not vouch for or subscribe to the claims and representation made by other members regarding particulars of status, age, income, character, etc. Any dispute shall be subject to the exclusive jurisdiction of courts in Chennai only.</li>
					</ul>					
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
