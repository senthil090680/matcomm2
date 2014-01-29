<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 06 January 2010
/* Project		: Community Matrimony Product
/* Filename		: paymentpagetracking.php
/* ______________________________________________________________________________________________________________________*/
/* Description  :

		This file tracks the user navigation towards payment page from different lead source
		Eg. Payment Link - Lead source from MatchWatch, ExpressInterest, Free2Paid, Personalized Message mailers etc.
/* ______________________________________________________________________________________________________________________*/

/* Doc Path Setting */
//$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

/* Includes */
//include_once($varRootBasePath."/conf/config.cil14");
//include_once($varRootBasePath."/conf/cookieconfig.cil14");
//include_once($varRootBasePath."/conf/dbinfo.cil14");
//include_once($varRootBasePath."/lib/clsDB.php");

/* Request (Get/Post) Variable Handling */
$varProfileId = ((isset($_REQUEST['pamid']) && trim($_REQUEST['pamid'])!='') ? trim($_REQUEST['pamid']) : '');
$varLeadSource = ((isset($_REQUEST['palead']) && trim($_REQUEST['palead'])!='') ? trim($_REQUEST['palead']) : 2);
/* Campaign LMS Query string parameters */
$varTrackId				= addslashes(strip_tags(trim($_REQUEST['trackid'])));
$varFormFeed			= addslashes(strip_tags(trim($_REQUEST['formfeed'])));

/* Payment Page Tracking */
/*if ($varProfileId != '' && $varLeadSource>0) {
	$objPPTrackMaster = new DB;
	$objPPTrackMaster->dbConnect('M',$varDbInfo['DATABASE']);
	if ($objPPTrackMaster->clsDBLink) {
		$PayPageTrackArgs = array('MatriId','Source_From','Date_Captured');
		$PayPageTrackValues = array("'".mysql_real_escape_string($varProfileId)."'",mysql_real_escape_string($varLeadSource),"NOW()");
		$objPPTrackMaster->insert($varTable['PREPAYMENTTRACKINFO'], $PayPageTrackArgs, $PayPageTrackValues);
	}
	$objPPTrackMaster->dbClose();
	unset($objPPTrackMaster);
}*/

/* Payment Assistance Lead Track */
payPageTrack($varProfileId, $varLeadSource);

/* Campaign LMS Track */
if ($varTrackId!="" && $varFormFeed=='y') {
 echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/clicktrack.php?trackid=".$varTrackId."&formfeed=y\"></script>";
}

function payPageTrack($varProfileId, $varLeadSource) {

	global $varDbInfo, $varTable;

	$varErrorFlag = 0;

	if ($varProfileId != '' && $varLeadSource>0) {
		$objPPTrackMaster = new DB;
		$objPPTrackMaster->dbConnect('M',$varDbInfo['DATABASE']);
		if ($objPPTrackMaster->clsDBLink) {
			$PayPageTrackArgs = array('MatriId','Source_From','Date_Captured');
			$PayPageTrackValues = array($objPPTrackMaster->doEscapeString($varProfileId,$objPPTrackMaster),$objPPTrackMaster->doEscapeString($varLeadSource,$objPPTrackMaster),"NOW()");
			$objPPTrackMaster->insert($varTable['PREPAYMENTTRACKINFO'], $PayPageTrackArgs, $PayPageTrackValues);
			$varErrorFlag = 1;
			$objPPTrackMaster->dbClose();
		}
		unset($objPPTrackMaster);
	}
	return $varErrorFlag;
}

?>