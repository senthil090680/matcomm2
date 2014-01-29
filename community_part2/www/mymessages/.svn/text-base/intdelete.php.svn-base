<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 07 Oct 2008
# Project		: MatrimonyProduct
# Module		: Interest - Delete
#=============================================================================================================

//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE THE FILES
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once $varRootBasePath."/lib/clsDB.php";

//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];

//OBJECT DECLARATION
$objMasterDB	= new DB();
$objSlaveDB		= new DB();

$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
$objSlaveDB->dbConnect('M', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varCurrentDate		= date('Y-m-d H:i:s');
$varDeleteConfirm	= $_REQUEST['interestDelete'];
$varForm			= $_REQUEST["frmnam"];
$varElem			= $_REQUEST["elemid"];
$varInterestIds		= str_replace("~",",",trim($_REQUEST["id"], '~'));
$varPurpose			= $_REQUEST["purp"];
$varDeleteId		= $_REQUEST["delid"];//For single record purpose...
$varOppName			= $_REQUEST["oppName"];//For single record purpose...
if ($varDeleteId==0 && $varDeleteConfirm !='yes') { $varInterestIds = $_REQUEST["elemid"]; }

//4=>Interest Received Pending delete,
//6=>Interest Received Accept delete,
//7=>Interest Received Declined delete,
//5=>Interest Sent delete,

if($varPurpose=='IRN') { $varStatus		= 4; $varContent	= ''; }
elseif($varPurpose=='IRA') { $varStatus	= 6; $varContent	= 'Accepted';}
elseif($varPurpose=='IRD') { $varStatus	= 7; $varContent	= 'Declined'; }

$varTableName	= ($varPurpose{1}=='R')?$varTable['INTERESTRECEIVEDINFO']:$varTable['INTERESTSENTINFO'];

if($varDeleteId==1) {
	$varLoadJs		= 1;
	$varHeading		= 'Delete Express Interest';
	$varConfirMsg	= 'Are you sure you want to remove this from your list of '.$varContent.' Interest?';
	$varConfHead	= 'Express Interest Deleted';
	$varSuccMsg		= 'You have successfully deleted the member\'s Interest.';
} else if($varDeleteId==0){
	$varLoadJs		= 0;
	if($varDeleteConfirm !='yes'){
	$varCondition	= " WHERE Interest_Id=".$objSlaveDB->doEscapeString($varInterestIds,$objSlaveDB);
	$varFields		= array('Opposite_MatriId');
	$varSelectInfo	= $objSlaveDB->select($varTableName,$varFields,$varCondition,1);
	$varOppMatid	= $varSelectInfo[0]['Opposite_MatriId'];
	$varMemCond		= " WHERE MatriId='".$varOppMatid."'";
	$varFields		= array('User_Name','Name');
	$varMemInfo		= $objSlaveDB->select($varTable['MEMBERINFO'],$varFields,$varMemCond,1);
	$varHeading		= "Delete interest of  ".$varMemInfo[0]['Name']."(".$varMemInfo[0]['User_Name'].")";
	$varConfirMsg	= "Are you sure you want to delete this member's interest?";
	$varOppName		= addslashes($varMemInfo[0]['Name']."(".$varMemInfo[0]['User_Name'].")");
	}
	$varConfHead	= "Express Interest Deleted";
	$varSuccMsg		= 'You have successfully deleted '.stripslashes($varOppName).' Interest.';
}
if($varDeleteConfirm=='yes') {
	$varLoadJs		= 0;
	if($varPurpose{1}=='R') {

		if($varPurpose{2}=='N') {
			$varCntFields		= array('Interest_Pending_Received');
			$varPrevStatus		= 0;
		} else if($varPurpose{2}=='A') {
			$varCntFields		= array('Interest_Accept_Received');
			$varPrevStatus		= 1;

		} else if($varPurpose{2}=='D') {
			$varCntFields		= array('Interest_Declined_Received');
			$varPrevStatus		= 3;
		}

		$varCondition		= " MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB)." AND Interest_Id IN (".$varInterestIds.") AND Status=".$varPrevStatus;
		$varFields			= array('Status','Date_Deleted');
		$varFieldsValues	= array($varStatus,"'".$varCurrentDate."'");
		$varUpdateAct		= $objMasterDB->update($varTableName,$varFields,$varFieldsValues,$varCondition);

		$varUpdateVal		= $varCntFields[0].'-'.$varUpdateAct;
		$varCntFieldsValues	= array("($varUpdateVal)");

		$varCondition		= "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varCntFields, $varCntFieldsValues, $varCondition);

	} else if($varPurpose{1}=='S') {

		if($varPurpose{2}=='N') {
			$varCntFields		= array('Interest_Pending_Sent');
			$varPrevStatus		= 0;
		} else if($varPurpose{2}=='A') {
			$varCntFields		= array('Interest_Accept_Sent');
			$varPrevStatus		= 1;

		} else if($varPurpose{2}=='D') {
			$varCntFields		= array('Interest_Declined_Sent');
			$varPrevStatus		= 3;
		}

		$varCondition		= " MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB)." AND Interest_Id IN (".$varInterestIds.") AND Status=".$varPrevStatus;
		$varFields			= array('Status','Delete_Status','Date_Deleted');
		$varFieldsValues	= array(5, 1, "'".$varCurrentDate."'");
		$varUpdateAct		= $objMasterDB->update($varTableName,$varFields,$varFieldsValues,$varCondition);

		$varRecTableName	= $varTable['INTERESTRECEIVEDINFO'];
		$varCondition		= "Opposite_MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB)." AND Interest_Id IN (".$varInterestIds.")";
		$varFields			= array('Delete_Status');
		$varFieldsValues	= array(1);
		$objMasterDB->update($varRecTableName,$varFields,$varFieldsValues,$varCondition);

		$varUpdateVal		= $varCntFields[0].'-'.$varUpdateAct;
		$varCntFieldsValues	= array("($varUpdateVal)");

		$varCondition		= "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$objMasterDB->update($varTable['MEMBERSTATISTICS'], $varCntFields, $varCntFieldsValues, $varCondition);
	}
}
//UNSET OBJECT
$objSlaveDB->dbClose();
$objMasterDB->dbClose();
?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<link href="<?=$confValues['CSSPATH']?>/global-style.css" rel="stylesheet" type="text/css"/>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/position.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
	<script>
	function populateId() {
		var a;a=selectedids('~','<?=$varForm?>','<?=$varElem?>');
		document.intfrm.id.value = a;
		//alert(a);
	}
	</script>
</head>
<body <? if ($varDeleteId==1) { ?> onload="if(<?=$varLoadJs?>==1) { populateId(); }" <? } ?>>
<? if($_REQUEST['interestDelete']=='yes') { ?>
  <div style='width:470px;'>
    <div style="padding: 5px 10px 5px 10px;"><font class='mediumtxt boldtxt clr3'><?=$varConfHead?></font>
    <div class="divborder"><div style="padding:10px;">
		<div class="smalltxt boldtxt" style='padding-top:5px'><font class="smalltxt"><?=$varSuccMsg?></font></div>
     </div></div>
     </div>
   <div class="fright" style="padding-top:5px; padding-right:7px;">
   <input type='button' name='close' value='Close' class='button' onclick="javascript:parent.reLoadMyHome('/mymessages/interest_ctrl.php','<?=$varPurpose?>',1,1);"></div>
  </div>
  <script language="javascript" src="<?=$confValues['SERVERURL']?>/login/updatemessagescookie.php"></script>
<? } else { ?>
<form name="intfrm">
<input type="hidden" name="interestDelete" value="yes">
<input type="hidden" name="id" value="<?=$varInterestIds?>">
<input type="hidden" name="frmnam" value="<?=$varForm?>">
<input type="hidden" name="purp" value="<?=$varPurpose?>">
<input type="hidden" name="delid" value="<?=$varDeleteId?>">
<input type="hidden" name="oppName" value="<?=$varOppName?>">
 <div id="msgdel">
  <div style='width:470px;'>
    <div style="padding: 5px 10px 5px 10px;"><font class='mediumtxt boldtxt clr3'><?=$varHeading?></font>
    <div class="divborder"><div style="padding:10px;">
		<div class="smalltxt boldtxt" style='padding-top:5px'><font class="smalltxt"><?=$varConfirMsg?></font></div>
     </div></div>
     </div>
   <div class="fright" style="padding-top:5px; padding-right:7px;"><input type='submit' value='Yes' class='button'>&nbsp;&nbsp;<input type='button' name='Button2' value='No' class='button' onclick="javascript:parent.closeIframe('iframeicon','icondiv');"></div>
  </div>
 </div>
</form>
<? } ?>
</body>
</html>