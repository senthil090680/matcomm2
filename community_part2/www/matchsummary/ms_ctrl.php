<?php
/****************************************************************************************************
File		: fetchresultprofiles.php
Author		: Jeyakumar N
*****************************************************************************************************
Description	: Used to Display output in msummaryshowall page
********************************************************************************************************/
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');

include_once($varBaseRoot.'/lib/clsDB.php');
include_once($varBaseRoot.'/lib/clsBasicviewCommon.php');
include_once($varBaseRoot.'/lib/clsSrchBasicView.php');
include_once($varServerRoot.'/sphinx/mssphinxprocess.php');

//OBJECT DECLARTION
$objSrchBasicView	= new SrchBasicView();
$objBasicComm		= new BasicviewCommon();
$objMasterDB		= new DB();

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGothram	= $varGetCookieInfo['GOTHRAM'];
$sessGender 	= $varGetCookieInfo["GENDER"];
$partnerGender	= ($sessGender=='1') ? 2 : 1;
$varCondition   = $_POST['wc'];
$varFacetingUsed= $_POST['faceAdd'];
$varViewType	= $_POST['viewtype'];
$varViewAddedType= $_REQUEST['vat'];
$varCommunityId	= $confValues['DOMAINCASTEID'];
$varImgsURL		= $confValues['IMGSURL'];
$varCookLasLogin= $_POST['Page']=='0' ? '' : $_COOKIE['lltimestamp'];

//Get already contact info
$varPostValues			= $objBasicComm->decryptData($varCondition);

//CONNECT DATABASE
$objSrchBasicView->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varViews		= $_POST['view']!='' ? $_POST['view'] : 1;
$varPageNo		= ($_POST['Page'] != '' && $_POST['Page']>0) ? $_POST['Page'] : 1;
$varNoOfRec		= $varViews*20;
$varStartRec	= ($varPageNo-1)*$varNoOfRec;


if($sessMatriId == '') {
	echo $displaythisonscreen="<br>You are either logged off or your session is timed out. <a href=\"http://".$confValues['SERVERURL']."/login/login.php\" class=\"linktxt\"> Click here</a> to login.<br><br>";
	exit;
}

//delete unwanted values
unset($_POST['wc']);

if($varPostValues != ''){
	$objBasicComm->getPostValues($varPostValues);
}
//print_r($_POST);

//Get Records
$arrSphinxIdx		= getSphinxIndexName($varCommunityId, $partnerGender);

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
	$arrBVResult = getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId, $varViewType, '', '', $varViewAddedType);
	if($arrBVResult['totalcnt'] > 0){
		//get feature profile detail starts 
		$varFPTotalRecs	= $arrBVResult['fptotalcnt'];
		if($varFPTotalRecs>0) {
			$arrFPResult	= $objSrchBasicView->selectBVDetails($arrBVResult['fpids']);
		}
		//get feature profile detail ends

		$varTotalRecs = $arrBVResult['totalcnt'];
		$arrResult	  = $objSrchBasicView->selectBVDetails($arrBVResult['ids']);
		if($varStartRec==0 && count($arrBVResult['facet'])>0 && $varCookLasLogin==''){
			$varFacetingCont = $objSrchBasicView->getFacetingContent($arrBVResult['facet']);
		}
	}else{
		$varFacetingCont = '<table border="0" cellpadding="0" cellspacing="0" id="src_main">
							<tr><td valign="top" id="navearea">
								<div style="float:left; width:190px; height:490px; border:1px solid #DBDBDB;margin-top:10px;">
									<div id="panel">
										<div style="padding-left: 12px; padding-top: 9px;" class="normtxt1 clr fnt17 bld">Refine search</div>
										<dl><dt class="mediumtxt boldtxt"><font class="clr3">No results found</font></dt><dl>
										</div>
									</div>
									<div style="clear:both;">
								</div>
							</td></tr></table>';
	}
}


$varTotalPgs  = ($varTotalRecs > 0) ? ceil($varTotalRecs / $varNoOfRec) : 0;
$varPageNo	  = ($varTotalRecs > 0) ? $varPageNo : 0;

//Unset Object
$objSrchBasicView->dbClose();
unset($objMasterDB);
unset($objSrchBasicView);
unset($objBasicComm);

print $varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/matchsummary/ms_ctrl.php#^~^#'. json_encode($arrResult).'#^~^#'.$varFacetingCont.'#^~^#'.$varFPTotalRecs.'#^~^#'.json_encode($arrFPResult);
?>