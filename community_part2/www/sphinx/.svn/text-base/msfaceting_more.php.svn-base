<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/conf/vars.cil14');
include_once($varBaseRoot.'/conf/cityarray.cil14');
include_once($varBaseRoot.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');

include_once($varBaseRoot.'/lib/clsBasicviewCommon.php');
include_once($varBaseRoot.'/lib/clsSrchBasicView.php');
include_once($varServerRoot.'/sphinx/mssphinxprocess.php');
include_once($varServerRoot.'/sphinx/sphinxarray.php');
include_once($varServerRoot.'/sphinx/sphinx_morefunction.php');

//Object Decleration
$objBasicComm = new BasicviewCommon();
$objSrchBasicView = new SrchBasicView();

//Variable Decleration
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessGothram	= $varGetCookieInfo['GOTHRAM'];
$varCondition   = $_POST['wc'];
$varViewType	= $_POST['viewtype'];
$varRefineBy	= $_POST['srchby'];
$varViewAddedType= ($_REQUEST['vat']!='')?$_REQUEST['vat']:'';
$varCommunityId	= $confValues['DOMAINCASTEID'];
$varImgsURL		= $confValues['IMGSURL'];

$varPostValues	= $objBasicComm->decryptData($varCondition);

//delete unwanted values
unset($_POST['wc']);

if($varPostValues != ''){
	$objBasicComm->getPostValues($varPostValues);
}

//Get Records
$arrSphinxIdx	= getSphinxIndexName($varCommunityId, $_POST['gender']);

$varMISphinxIdxName		= $arrSphinxIdx['sphinxmemberinfo'];
$varSPHINXVIEWIDXNAME	= $arrSphinxIdx['sphinxmemberprofileviews'];
$varSPHINXCONTACTIDXNAME= $arrSphinxIdx['sphinxmemberactioninfo'];

$varStartRec		= 0;
$arrResult			= array();
$varFacetingCont	= '';
$varExceptGothram   = 0;

$varFaceGroupByLbl	 = $arrFacetingDetails[$varRefineBy][0];
$varFaceGroupByField = $arrFacetingDetails[$varRefineBy][1];
$varFaceGroupByName  = substr($arrFacetingDetails[$varRefineBy][2], 1);
$varFaceGroupByArray = $arrFacetingDetails[$varRefineBy][3];
$varFaceGroupByType  = $arrFacetingDetails[$varRefineBy][4];

if($varMISphinxIdxName != '' && $varFaceGroupByField!=''){
	if($varRefineBy!='age' && $varRefineBy!='height'){
		if($varRefineBy == 'profiletype'){ 
			$varOldVal = $_POST['photoOpt'].'~'.$_POST['horoscopeOpt'];
			unset($_POST['photoOpt']); unset($_POST['horoscopeOpt']);
		}else{ 
			$varOldVal = $_POST[$varRefineBy]; 
			if($varRefineBy!='annualIncome'){
				if($varRefineBy=='gothram' && preg_match("/99/", $_POST[$varRefineBy])){
					//do not need to reset gothram value for except my gothra
					$varExceptGothram = 1;
				}else{
					unset($_POST[$varRefineBy]);
				}
				if($varRefineBy=='country' && ($_POST['residingState']!='' || $_POST['residingCity']!='')){
					unset($_POST['residingState']);unset($_POST['residingCity']);
				}else if($varRefineBy=='residingState' && $_POST['residingCity']!=''){
					unset($_POST['residingCity']);
				}
			}
		}
		$arrBVResult = getResultsfromSphinx($varMISphinxIdxName, $varFaceGroupByField, $varCommunityId,$varViewType,'','',$varViewAddedType);
		$arrFinal    = $arrBVResult['groupcnt'][$varFaceGroupByField];

		if($varExceptGothram==1){
			unset($arrFinal[$sessGothram]);
		}
	}else{
		$arrBVResult['totalcnt']=1;
	}
	
	if($arrBVResult['totalcnt']>0){
		if($varRefineBy =='age'){ $varOldVal = $_POST['ageFrom'].'~'.$_POST['ageTo'];}
		else if($varRefineBy =='height'){ $varOldVal = $_POST['heightFrom'].'~'.$_POST['heightTo'];}
		else if($varRefineBy =='annualIncome'){ $varOldVal = $_POST['annualIncome'].'~'.$_POST['annualIncome1'];}
		$varFacetingCont = getFacetingMoreContent($varRefineBy, $arrFinal, $varFaceGroupByLbl, $varFaceGroupByName, $varFaceGroupByArray, $varFaceGroupByType, $varOldVal);
	}
}

//Unset Object
unset($objSrchBasicView);
unset($objBasicComm);

print $varFacetingCont;
?>