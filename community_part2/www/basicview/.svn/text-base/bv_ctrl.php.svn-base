<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');

include_once($varBaseRoot.'/lib/clsBasicviewCommon.php');
include_once($varBaseRoot.'/lib/clsSrchBasicView.php');
include_once($varServerRoot.'/sphinx/sphinxprocess.php');

//Object Decleration
$objBasicComm		= new BasicviewCommon();
$objSrchBasicView	= new SrchBasicView();
$objMasterDB		= new DB();

//Variable Decleration
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessGothram	= $varGetCookieInfo['GOTHRAM'];
$varCondition   = $_POST['wc'];
$varFacetingUsed= $_POST['faceAdd'];
$varCommunityId	= $confValues['DOMAINCASTEID'];
$varImgsURL		= $confValues['IMGSURL'];
$varCookLasLogin= $_POST['Page']=='0' ? '' : $_COOKIE['lltimestamp'];
$varTempTable	= $varTable['SEARCHFILTERLIST'];

//Get already contact info
$varPostValues	= $objBasicComm->decryptData($varCondition);

//Get Connection
$objSrchBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varViews		= $_POST['view']!='' ? $_POST['view'] : 1;
$varPageNo		= ($_POST['Page'] != '' && $_POST['Page']>0) ? $_POST['Page'] : 1;
$varNoOfRec		= $varViews*20;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;

if($_POST['srchId']!='' && is_numeric($_POST['srchId'])){
	$varSaveSearchCook	= $_COOKIE['savedSearchInfo'];
	if(preg_match("/~?".$_POST['srchId']."\\|/", $varSaveSearchCook) && $_POST['oldsrchName']!=''){
		$varSaveSrchOldVal	= $_POST['oldsrchName'];
		$varSaveSrchNewVal	= $_POST['srchName'];
		$varSavedSearchInfo = preg_replace("/".$varSaveSrchOldVal."/", $varSaveSrchNewVal, $varSaveSearchCook);
		$varSavedSearchInfo = trim($varSavedSearchInfo, '~');
	}else{
		$varSavedSearchInfo = trim($_COOKIE['savedSearchInfo'].'~'.$_POST['srchId'].'|'.$_POST['srchType'].'|'.$_POST['srchName'], '~');
	}
	setcookie("savedSearchInfo",$varSavedSearchInfo, "0", "/",$confValues['DOMAINNAME']);
}

//delete unwanted values
unset($_POST['wc']);
unset($_POST['srchId'], $_POST['srchType'], $_POST['srchName']);

if($varPageNo>5 && $sessMatriId ==''){header("Location:".$confValues['SERVERURL'].'/register/');}

if($varPostValues != ''){
	$objBasicComm->getPostValues($varPostValues);
}

//Get Records
$arrSphinxIdx		= getSphinxIndexName($varCommunityId, $_POST['gender']);

//for commercial sites need to remove star, horoscope based on religion
$varFeaHoroscope = 1;
if($varCommunityId>=2000 && $varCommunityId<=2009){
	$arrCommercialRels	= array(2, 10, 11, 3, 12, 13, 14);
	$varReligion	= $_POST['religion'];
	$varCaste		= $_POST['caste'];
	if($varReligion>0 && in_array($varReligion, $arrCommercialRels)){
		$varFeaHoroscope= 0;
	}else if($varCaste != ''){
		$arrCommCaste	= getQueryVal($varCaste);
		foreach($arrCommCaste as $varCasteKey=>$varCasteVal){
			//checking muslim & christian castes
			if(($varCasteVal>=400 && $varCasteVal<=423) || ($varCasteVal>=501 && $varCasteVal<=519)){
				unset($arrCommCaste[$varCasteKey]);
			}
		}
		if(count($arrCommCaste)==0){$varFeaHoroscope= 0;}
	}
}

$varMISphinxIdxName		= $arrSphinxIdx['sphinxmemberinfo'];
$varSPHINXVIEWIDXNAME	= $arrSphinxIdx['sphinxmemberprofileviews'];
$varSPHINXCONTACTIDXNAME= $arrSphinxIdx['sphinxmemberactioninfo'];

$varTotalRecs	= 0;
$varFPTotalRecs	= 0;
$arrResult		= array();
$arrFPResult	= array();
$varFacetingCont= '';
if($varMISphinxIdxName != ''){
	$arrBVResult = getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId);
	if($arrBVResult['totalcnt'] > 0){
		//get feature profile detail starts 
		$varFPTotalRecs	= $arrBVResult['fptotalcnt'];
		if($varFPTotalRecs>0) {
			$arrFPResult	= $objSrchBasicView->selectBVDetails($arrBVResult['fpids']);
		}
		//get feature profile detail ends

		$varTotalRecs	= $arrBVResult['totalcnt'];
		$arrResult		= $objSrchBasicView->selectBVDetails($arrBVResult['ids']);
		if($varStartRec==0 && count($arrBVResult['facet'])>0 && $varCookLasLogin==''){
			$varFacetingCont = $objSrchBasicView->getFacetingContent($arrBVResult['facet']);
		}
	}
}


$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

//Unset Object
$objSrchBasicView->dbClose();
unset($objMasterDB);
unset($objSrchBasicView);
unset($objBasicComm);

print $varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/basicview/bv_ctrl.php#^~^#'. json_encode($arrResult).'#^~^#'.$varFacetingCont.'#^~^#'.$varFPTotalRecs.'#^~^#'.json_encode($arrFPResult);
?>