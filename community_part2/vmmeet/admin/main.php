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

//OBJECT DECLARATION
$objSlave = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLLE DECLARATIONS
$adminusername  = $_COOKIE['adminusername'];
$adminpassword  = $_COOKIE['adminpassword'];

if(!$adminusername || !$adminpassword){
	echo "<script>window.location = 'http://meet.communitymatrimony.com/admin/';</script>";
	exit;
}
$VMMdets = '';
if(isset($_POST)){
	if($_POST['type']==1){
		$VMMdets = getVMMStatistics($_POST['eventid']);
	}elseif($_POST['type']==2){
		$VMMdets = getVMMFeedbacks($_POST['eventid']);
	}elseif($_POST['type']==3){
		$VMMdets = "<font class='smalltxt'><b>http://meet.communitymatrimony.com/vmlogin.php?evid=".$_POST['eventid']."</b></font>";
	}
}

$varDomainName = 'communitymatrimony.com';
$domain_logo   = 'http://img.communitymatrimony.com/images/logo/community_logo.gif';

?>
<html>
<head>
<title>VMM Admin</title>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/global-style.css">
<script>
function validatesearch()
{
	var SearchForm = this.document.SearchForm;
	// Check E-mail
	if(SearchForm.eventid.value == "0" )
	{
	alert( "Please select community" );
	SearchForm.eventid.focus( );
	return false;
	}

	// Check Password

	if(SearchForm.type.value == "0" )
	{
	alert( "Please select type." );
	SearchForm.type.focus( );
	return false;
	}
	return true;
}
</script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer" >
	<div id="container">
		<div class="main" >
			    
			    <div class="fleft logodiv">
				<a href="http://www.<?=$varDomainName;?>/"><img src="<?=$domain_logo;?>" alt="<?=$varDomainName;?>" border="0" /></a></div>
				<br clear="all" />
				<div class="innerdiv" >
				<img src="http://meet.communitymatrimony.com/images/headerimg.jpg" vspace="10" /><br><br>
				
				<center>
				<div class="fright" style="width:771px;border:1px solid #EEEEEE">
				<FORM name="SearchForm" action="main.php" method=post onSubmit="return validatesearch();">
     			<table cellpadding="0" cellspacing="0" border="0" height="100" width="770">
				<tr>
				<td class="smalltxt" ><b>&nbsp;&nbsp;Welcome Admin</b></td>
				<td class="smalltxt" align="right"><a href="logout.php" >Logout&nbsp;&nbsp;</a></td>
				</tr>
				<tr><td class="smalltxt" colspan="2">&nbsp;</td></tr>
				<tr>
				    <td class="smalltxt" colspan="2">
					    <table align="center" cellpadding="0" cellspacing="0" border="0" height="100" width="670">
						<tr>
						<td class="smalltxt" align="center" colspan="2">&nbsp;Select Community :
						<select name="eventid" id="eventid">
						<option value="0">Select Community</option>
						<?php echo getCommunityNames($_POST['eventid']);?>
						</select>&nbsp;Select Type :
						<select name="type" id="type">
						<option value="0">Select Type</option>
						<option value="1" <?php if($_POST['type']==1) echo "selected"; ?>>VMM Statistics</option>
						<option value="2" <?php if($_POST['type']==2) echo "selected";?>>Feedback</option>
						<option value="3" <?php if($_POST['type']==3) echo "selected";?>>Event URL</option>
						</select>
						<input type="submit" name="submit" value="Go" class="button">
						</td>
						</tr>
						<tr><td class="smalltxt" colspan="2">&nbsp;</td></tr>
						<tr><td class="smalltxt" colspan="2" align='center'>
						<?php if($VMMdets){echo $VMMdets;}
						else {echo "<center><font color='red'>No Records Found</font></center>";}?>
						</td></tr>
						</table>
				    </td></tr>
				</table>
				</div></center>
				
			</div>
			<br clear="all"/><br>
			<div class="footdiv" style="background:url(http://img.<?=$varDomainName;?>/images/footerbg.gif) repeat-x;">
				<div class="footdiv1 padt10"><font class="smalltxt clr">	
					</font>
				</div>
				<div><center><font class="opttxt clr">Copyright &copy; 2010 Consim Info Pvt Ltd. All rights reserved.</font></center></div>
			</div>
		</div>
	</div>
</div>
</center>
</body>
</html>
</center>
</body>
</html>
<?php

function getCommunityNames($id){
global $objSlave,$varOnlineSwayamvaramDbInfo,$varTable;

$varCondition		= " where EventStatus=1";
$varFields			= array('EventId','EventTitle');
$varCommDet 	    = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields,$varCondition,0);
$opt='';

while($commrs = mysql_fetch_assoc($varCommDet)){
	    if($id==$commrs['EventId'])
		$selected='selected';
		else
		$selected='';

	$opt .="<option value='".$commrs['EventId']."' ".$selected.">".$commrs['EventTitle']."</option>";
}
return $opt;
}

function getVMMStatistics($eventId){
global $objSlave,$varOnlineSwayamvaramDbInfo,$varTable;

$varCondition1		= " where EventId=$eventId";
$varFields1			= array('EventTitle');
$varEveDet 	        = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields1,$varCondition1,1);
$EventTitle = $varEveDet[0]['EventTitle'];

$varCondition		= " where name=$eventId";
$varFields			= array('username');
$varCommDet 	    = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['VMMUSERS'],$varFields,$varCondition,1);
$opt='';
$usersarr      = '';
$totaluserscnt = count($varCommDet);  
foreach($varCommDet as $key=>$value){
	$usersarr.="'".$value['username']."',";
}
$usersids      = substr($usersarr, 0, -1);

$varCondition		= " where MatriId IN($usersids) group by paid_status";
$varFields			= array('count(paid_status)','paid_status');
$varPaidDet 	    = $objSlave->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);

$varCondition		= " where MatriId IN($usersids) group by gender";
$varFields			= array('count(gender)','gender');
$varGenDet 	        = $objSlave->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);

$rs="<center><div style='width:371px;border:1px solid #EEEEEE'><table align='center' cellpadding='0' class='smalltxt' cellspacing='0' border='0' width='350'>
      <tr><td colspan='2' align='center' height='10'></td></tr>
      <tr bgcolor='#DDDDDD'><td colspan='2' align='center' height='20'><b>Event Title   : ".$EventTitle."</b></td></tr>
	  <tr><td width='175' align='center'>Paid Members  :</td><td align='center'>".$varPaidDet[1]['count(paid_status)']."</td></tr>
	  <tr><td align='center'>Free Members  :</td><td align='center'>".$varPaidDet[0]['count(paid_status)']."</td></tr>
	  <tr><td align='center'>Male Count    :</td><td align='center'>".$varGenDet[0]['count(gender)']."</td></tr>
	  <tr><td align='center'>Female Count  :</td><td align='center'>".$varGenDet[1]['count(gender)']."</td></tr>
	  <tr><td align='center'><b>Total Members :</b></td><td align='center'><b>".$totaluserscnt."</b></td></tr>
	  <tr><td align='center'>&nbsp;</td></tr>
	  </table></div></center><br><br>";

return $rs;
}
function getVMMFeedbacks($eventId){
global $objSlave,$varOnlineSwayamvaramDbInfo,$varTable;

$varCondition1		= " where EventId=$eventId";
$varFields1			= array('EventTitle');
$varEveDet 	        = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields1,$varCondition1,1);
$EventTitle = $varEveDet[0]['EventTitle'];

$varCondition		= " where EventId=$eventId";
$varFields			= array('MatriId','QA1','QA2','QA3','QA4','QA5','QA6','QA7','DateRegistered');
$varSurveyDet 	    = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['OMMSURVEY'],$varFields,$varCondition,0);
$cnt = mysql_num_rows($varSurveyDet);
$rs = '';
if($cnt >1){
$rs = "<center><div style='width:720px;border:1px solid #EEEEEE'><b>Event Title   : ".$EventTitle."</b>";
while($survyDets = mysql_fetch_assoc($varSurveyDet)){
    $QA1 = explode('~',$survyDets['QA1']);
	$QA2 = explode('~',$survyDets['QA2']);
	$QA3 = explode('~',$survyDets['QA3']);
	$QA4 = explode('~',$survyDets['QA4']);
	$QA5 = explode('~',$survyDets['QA5']);

	if($QA1[0] || $QA2[0] || $QA3[0] || $QA4[0] || $QA5[0])
	$rs.="<table align='center' cellpadding='0' class='smalltxt' cellspacing='0' border='0' width='700'>
      <tr bgcolor='#DDDDDD'><td width='175' align='center' ><b>MatriId  :</b></td><td align='center'><b>".$survyDets['MatriId']."</b></td></tr>";
	  if($QA1[0])
	  $rs.="<tr><td align='left' nowrap>".$QA1[0]."  :</td><td align='left'>".$QA1[1]."</td></tr>";
	  if($QA2[0])
	  $rs.="<tr><td align='left' nowrap>".$QA2[0]."  :</td><td align='left'>".$QA2[1]."</td></tr>";
	  if($QA3[0])
	  $rs.="<tr><td align='left' nowrap>".$QA3[0]."  :</td><td align='left'>".$QA3[1]."</td></tr>";
	  if($QA4[0])
	  $rs.="<tr><td align='left' nowrap>".$QA4[0]."  :</td><td align='left'>".$QA4[1]."</td></tr>";
	  if($QA5[0])
  	  $rs.="<tr><td align='left' nowrap>".$QA5[0]."  :</td><td align='left'>".$QA5[1]."</td></tr>";
	  if($QA1[0] || $QA2[0] || $QA3[0] || $QA4[0] || $QA5[0])
	  $rs.="<tr><td align='left' nowrap>Date Registered  :</td><td align='left'>".$survyDets['DateRegistered']."</td></tr>
	  <tr><td align='center'>&nbsp;</td></tr>
	  </table>";


	
}
$rs.="</div></center><br>";
}
return $rs;


}

?>

