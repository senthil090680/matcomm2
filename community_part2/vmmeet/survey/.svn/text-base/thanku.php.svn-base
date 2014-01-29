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
<center>
<!-- main body starts here -->
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<div class="fleft logodiv"><a href="http://www.<?=$arrFolderNames[$varMatriIdPrefix];?>matrimony.com/"><img src="<?=$domain_logo;?>" alt="AgarwalMatrimony" border="0" /></a></div>
			
			<br clear="all" />
			<div class="linesep"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" height="1" width="1" /></div>
			<br clear="all">
			<div class="innerdiv"><center>
				<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/thankuimg.jpg" vspace="10" /></center>
			</div>
			<br clear="all"/><br>
			<!-- ////////// -->
			<?php include_once("../footer.php"); ?>
			<!-- /////////////// -->
		</div>
	</div>
</div>
</center>
</body>
</html>
