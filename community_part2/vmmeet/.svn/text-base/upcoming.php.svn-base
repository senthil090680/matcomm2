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
				<div style="background:url(images/upcomingbg.gif);height:65px;width:774px;">
				<div class="fleft" style="width:250px;"><img src="images/trans.gif" width="200" height="1" /></div>
				<div class="fleft smalltxt" style="width:150px;padding-top:15px;"><b>Meet Name:</b><br><?=ucfirst($arrFolderNames[$varMatriIdPrefix]);?> Matrimony Meet</div>
				<div class="fleft" style="width:45px;"><img src="images/trans.gif" width="45" height="1" /></div>
				<div class="fleft smalltxt" style="width:125px;padding-top:15px;"><b>Community</b><br><?=ucfirst($arrFolderNames[$varMatriIdPrefix]);?></div>
				<div class="fleft" style="width:40px;"><img src="images/trans.gif" width="40" height="1" /></div>
				<div class="fleft smalltxt" style="width:150px;padding-top:15px;"><b>Date & Time:</b><br><?=$EventDate_disp;?><br><?=$EventStartTime_disp;?> - <?=$EventEndTime_disp;?></div>
				</div><br>
				<div class="normtxt tljust lh16" style="padding-left:1px;">
				<b>What is Virtual Matrimony Meet?</b><br>
				Virtual Matrimony Meet is an online event that provides a platform for members of a specific community to meet and interact with other members from the same community. During the event members can exchange their views, share their interests,        hobbies, expectations etc., for the sole purpose of finding a suitable life partner.<br><br>
				<b>How it works?</b><br>
				During the event the members would be able to view the list of all other members who are participating in the event. They can do a search based on various criteria to identify the potential partners they wish to communicate with. The tools provided for 
				communication include web alerts, chat and e-mail. Members will also be given the option to block any member they do not wish to communicate with.<br><br>
				<b>Who can participate?</b><br>
				All members can participate. Paid members can initiate contact and chat with anyone they choose. Free members cannot initiate contact but they can reply to the chat messages initiated by paid members.<br><br>
				<b>What happens after the event?</b><br>
				Post the event members can login and view the communication exchanged between the member and other members during the event. The transcript of the communication will be available only for a limited period of time after which the communication may not be available for viewing.
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
