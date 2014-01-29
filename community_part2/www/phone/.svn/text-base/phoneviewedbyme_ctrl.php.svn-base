<?php
#===================================================================================================================
# Author 		: Gokilavanan
# Date	        : 31-03-2011
# Project		: Community Matrimony Product
# Filename	    : phoneviewedbyme.php
# Description   : It's list in search result format, the "Phone viewed by" the Logged in Member
#				  This program particularly fetch the data's from db to show in Phone viewed by me result page
#====================================================================================================================

//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/lib/clsPhone.php');
include_once($varBaseRoot.'/lib/clsBasicview.php');

//Object Decleration
$objPhone	  = new Phone();
$objBasicView = new BasicView();

//DB Connection
$objPhone->dbConnect('S', $varDbInfo['DATABASE']);
$objBasicView->dbConnect('S', $varDbInfo['DATABASE']);

//Variable Decleration
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPP			= $_COOKIE['partnerInfo'];

$varViews		= trim($_POST['view'])!='' ? trim($_POST['view']) : 1;
$varPageNo		= (trim($_POST['Page']) != '' && trim($_POST['Page'])>0) ? trim($_POST['Page']) : 1;
$varNoOfRec		= $varViews*10;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

$varWhereQuery	= '';
$varTotalRecs	= 0;
if($sessMatriId != ''){
	$varTotalRecs	= $objPhone->getPhNoViewedByMe($sessMatriId, $varStartRec, $varNoOfRec);
}

//Paging Calculation starts here
$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

if($varTotalRecs > 0) {
	$varOppIds		= $objPhone->arrViewedPhoneNoByMe;
	$varNoOfOppIds	= count($varOppIds);

	//Basic View Related Functionality Starts Here
	$varMatriIds	= "'".join("', '", $varOppIds)."'";
	$varWhereCond	= 'WHERE MatriId IN('.$varMatriIds.')';
	$varCondition['CNT']	= $varWhereCond;
	$varCondition['LIMIT']	= $varWhereCond;

	//Get Records
	$arrResult		= $objBasicView->selectDetails($varCondition, 'Y');

	if($varNoOfOppIds > $arrResult['TOT_CNT'])
	{
		unset($arrResult['TOT_CNT']);
		$varTotMissedIdsDet = array();
		$varMissedIds = array_diff($varOppIds, $objBasicView->clsBVMatriIds);
		$varDelIds	  = "'".join("', '", $varMissedIds)."'";
		$varDelIdsDet = $objBasicView->getDeletedIdsDet($varDelIds);

		if(count($varMissedIds) > count($objBasicView->clsDelMatriIds))
		{
			$varTotMissedIds	= array_diff($varMissedIds, $objBasicView->clsDelMatriIds);

			foreach($varTotMissedIds as $singVal)
			{
				$varTotMissedIdsDet[$singVal]['PU'] = 'TD';
				$varTotMissedIdsDet[$singVal]['UN'] = '';
				$varTotMissedIdsDet[$singVal]['G']  = '';
			}
		}
		$arrMergedIds1 = array_merge($varDelIdsDet, $varTotMissedIdsDet);
		$arrMergedIds2 = array_merge($arrMergedIds1, $arrResult);
		$arrBVResult = $arrMergedIds2;
	} else {
		unset($arrResult['TOT_CNT']);
		$arrBVResult = $arrResult;
	}

	$arrFinalBVRes = array();
	foreach($varOppIds as $varSingleId){
		$arrFinalBVRes[] = $arrBVResult[$varSingleId];
	}
	//Unset Object
	$objPhone->dbClose();
	$objBasicView->dbClose();
	unset($objPhone);
	unset($objBasicView);

	print $varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/phone/phoneviewedbyme_ctrl.php#^~^#'. json_encode($arrFinalBVRes).'#^~^#MPHV';
} else {
	print '1#^~^#0#^~^#0#^~^#1#^~^#/phone/phoneviewedbyme_ctrl.php#^~^##^~^#MPHV';
}

?>