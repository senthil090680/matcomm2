<?
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
$objMaster = new DB;

//DB CONNECTION
$objMaster-> dbConnect('M',$varDbInfo['DATABASE']);

	$ommMatriId	= addslashes(trim($_POST["matriid"]));
	$ommEventId	= addslashes(trim($_POST["eventid"]));
	if($_POST["concept"]) 
	{
		 $ommConcept = "I think the concept of Online Matrimony Meets is ~ ".addslashes(trim($_POST["concept"]));
	}
	$ommDayToConduct = addslashes(trim($_POST["daytoconduct"]));
	$ommTimePreference = addslashes(trim($_POST["timepreference"]));
	$ommTimetoConduct = addslashes(trim($_POST["timetoconduct"]));
	if($ommDayToConduct) {	
		 $ommCondDetails="According to me, the Online Matrimony Meet will be convenient if conducted on ~ ".$ommDayToConduct ." ".$ommTimePreference ." ".$ommTimetoConduct;
	}
	if($_POST["profilematch"]) {
		 $ommProfileMatch = "I found the number of matching profiles to be ~ ".addslashes(trim($_POST["profilematch"]));
	}
	if($_POST["opinion"]) {
		 $ommOpinion = "In my opinion, the Online Matrimony Meet was ~ ".addslashes(trim($_POST["opinion"]));
	}
	if($_POST["comments"]) {
		 $ommComments = "If I were to comment on the Online Matrimony Meet, I would say ~ ".addslashes(trim($_POST["comments"]));
	}
	echo $insert = "insert into ".$varOnlineSwayamvaramDbInfo['DATABASE'].".".$varTable['OMMSURVEY']."(MatriId,EventId,QA1,QA2,QA3,QA4,QA5,DateRegistered) Values ('$ommMatriId','$ommEventId','$ommConcept','$ommCondDetails','$ommProfileMatch','$ommOpinion','$ommComments',now())";
	$result = $objMaster->ExecuteQryResult($insert,0);
 
	header('Location:thanku.php?evid='.$ommEventId);
	$objMaster->dbClose();
?>