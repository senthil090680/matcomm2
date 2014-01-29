<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Survey
#=============================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once "../chatfunctions.php";


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

 $ommMId = $_GET['matriid'];
 $ommEID = $_GET['evid'];
 $ommTit = $_GET['etitle'];
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
</head>

<body>
<form name="ommForm" method="POST" action="/survey/ommServePage.php">
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			 <!-- ////////// -->
			    <?php include("../header.php"); ?>
				<!-- /////////////// -->
				<div class="bld padtb10">Your feedback is important to us</div>
				<div class="dotsep2"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" width="1" height="1" /></div><br clear="all"/>
				<div class="lh16 normtxt clr">
					Thank you for participating in the '<?=ucfirst($arrFolderNames[$varMatriIdPrefix]);?> Virtual Online Matrimony Meet'. Please take some time to answer the following questions for us to provide better service for future Virtual Matrimony Meets.
    			</div><br>
				<div style="width:270px;" class="smalltxt tlright fleft">I think the concept of Virtual Matrimony Meets is</div>
				<div style="width:480px;padding-left:10px;" class="smalltxt fleft lh20"><input type="radio" class="frmelements" name="concept" value="Good, I can chat with members from around the world">Good, I can chat with members from around the world<br>
				<input type="radio" class="frmelements" name="concept" value="Okay, but there is nothing like meeting personally">Okay, but there is nothing like meeting personally<br>
				<input type="radio" class="frmelements" name="concept" value="It would be better if you enabled a voice chat service">It would be better if you enabled a voice chat service<br>
				<input type="radio" class="frmelements" name="concept" value="It's a waste of time">It's a waste of time</div><br clear="all"><br>

				<div style="width:270px;" class="smalltxt tlright fleft">According to me, the Virtual Matrimony Meet will be convenient if conducted on</div>
				<div style="width:490px;padding-left:10px;" class="smalltxt fleft lh20"><input type="radio" class="frmelements" name="daytoconduct" value="Monday">Monday<img src="images/trans.gif" width="25" height="1" />
				<input type="radio" class="frmelements" name="daytoconduct" value="Tuesday">Tuesday<img src="images/trans.gif" width="25" height="1" />
				<input type="radio" class="frmelements" name="daytoconduct" value="Wednesday">Wednesday<img src="images/trans.gif" width="25" height="1" />
				<input type="radio" class="frmelements" name="daytoconduct" value="Thursday">Thursday<img src="images/trans.gif" width="25" height="1" /><input type="radio" class="frmelements" name="daytoconduct" value="Friday">Friday<br><input type="radio" class="frmelements" name="daytoconduct" value="Saturday">Saturday<img src="images/trans.gif" width="23" height="1" /><input type="radio" class="frmelements" name="daytoconduct" value="Sunday">Sunday<br>
				&nbsp;&nbsp;Enter your time preference &nbsp;<input type="text" name="timepreference" class="inputtext" id="timepreference">&nbsp;&nbsp;<input type="radio" class="frmelements" name="timetoconduct" id="am">AM<img src="images/trans.gif" width="10" height="1" /><input type="radio" class="frmelements" name="timetoconduct" id="pm">PM (starting time IST)
				</div><br clear="all"><br>

				<div style="width:270px;" class="smalltxt tlright fleft">I found the number of matching profiles to be</div>
				<div style="width:490px;padding-left:10px;" class="smalltxt fleft lh20"><input type="radio" class="frmelements" name="profilematch" value="Enough">Enough<img src="images/trans.gif" width="25" height="1" />
				<input type="radio" class="frmelements" name="profilematch" value="Not enough">Not enough<img src="images/trans.gif" width="25" height="1" />
				<input type="radio" class="frmelements" name="profilematch" value="More than I expected">More than I expected<br>
				<input type="radio" class="frmelements" name="profilematch" value="I couldn't find even a single matching profile">I couldn't find even a single matching profile
				</div><br clear="all"><br>

				<div style="width:270px;" class="smalltxt tlright fleft">In my opinion, the Virtual Matrimony Meet was</div>
				<div style="width:490px;padding-left:10px;" class="smalltxt fleft lh20"><input type="radio" class="frmelements" name="opinion" value="Excellent">Excellent<img src="images/trans.gif" width="20" height="1" />
				<input type="radio" class="frmelements" name="opinion" value="VeryGood">Very Good<img src="images/trans.gif" width="20" height="1" />
				<input type="radio" class="frmelements" name="opinion" value="Good">Good<img src="images/trans.gif" width="20" height="1" />
				<input type="radio" class="frmelements" name="opinion" value="Bad">Bad<img src="images/trans.gif" width="20" height="1" /><input type="radio" class="frmelements" name="opinion" value="Poor">Poor
				</div><br clear="all"><br>

				<div style="width:270px;" class="smalltxt tlright fleft">If i were to comment on the Virtual Matrimony Meet,<br> I would say</div>
				<div style="width:490px;padding-left:10px;" class="smalltxt fleft lh20">&nbsp;&nbsp;<textarea name="comments" id ="comment" class="inputtext" rows="1" cols="5" style="width:320px;height:100px;"></textarea><br>&nbsp;&nbsp;Please type your opinion
				</div><br clear="all">

				<div class="fright padtb10" style="padding-right:50px;"><input type="submit" class="button" value="Submit" /></div>
			</div>
			<br clear="all"/><br>
			
			
			<!-- ////////// -->
			<?php include_once("../footer.php"); ?>
			<!-- /////////////// -->
		</div>
	</div>
</div>
</center>
<input type='hidden' name='matriid' value="<?=$ommMId?>">
<input type='hidden' name='eventid' value="<?=$ommEID?>">
</form>
</body>
</html>
