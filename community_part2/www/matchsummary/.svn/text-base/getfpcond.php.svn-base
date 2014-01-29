<?
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath."/lib/sphinxapi.php"); 
include_once($varRootBasePath.'/lib/clsCache.php');
include_once($varRootBasePath."/conf/sphinxclass.cil14");
include_once($varRootBasePath."/conf/sphinxgenericfunction.cil14");
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/www/sphinx/mssphinxprocess.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender 	= $varGetCookieInfo["GENDER"];
$partnerGender	= ($sessGender=='1') ? 2 : 1;

//OBJECT DECLARTION
$ObjDomain			= new domainInfo;

$arrRevMatriIdPre		= array_flip($arrMatriIdPre);
$varMatriPrefix			= substr($sessMatriId,0,3);
$varCommunityId			= $arrRevMatriIdPre[$varMatriPrefix];
$arrProfIndex			= getSphinxIndexName($varCommunityId, $partnerGender);
$varBOOKMARKEDINDEX		= $arrProfIndex['sphinxbookmarked'];
$varBLOCKEDINDEX		= $arrProfIndex['sphinxblocked'];
$varMISphinxIdxName		= $arrProfIndex['sphinxmemberinfo'];
$varSPHINXVIEWIDXNAME	= $arrProfIndex['sphinxmemberprofileviews'];
$varSPHINXCONTACTIDXNAME= $arrProfIndex['sphinxmemberactioninfo'];
$varSPHINXTOOLSIDXNAME	= $arrProfIndex['sphinxmembertools'];

$retFea['Religion']		= $ObjDomain->useReligion();
$retFea['Denomination']	= $ObjDomain->useDenomination();
$retFea['Caste']		= $ObjDomain->useCaste();
$retFea['Subcaste']		= $ObjDomain->useSubcaste();
$retFea['Star']			= $ObjDomain->useStar();
$retFea['MaritalStatus']= $ObjDomain->useMaritalStatus();
$retFea['Gothram']		= $ObjDomain->useGothram();
$retFea['Dosham']		= $ObjDomain->useDosham();

$retArr['Religion']		= array();
$retArr['Denomination']	= array();
$retArr['Caste']		= array();
$retArr['Subcaste']		= array();
$retArr['Star']			= array();
$retArr['MaritalStatus']= array();
$retArr['Gothram']		= array();
$retArr['Dosham']		= array();

if($retFea['Religion'])
	$retArr['Religion']		= $ObjDomain->getReligionOption();
if($retFea['Denomination'])
	$retArr['Denomination'] = $ObjDomain->getDenominationOption();
if($retFea['Caste'])
	$retArr['Caste']		= $ObjDomain->getCasteOption();
if($retFea['Subcaste'])
	$retArr['Subcaste']		= $ObjDomain->getSubcasteOption();
if($retFea['Star'])
	$retArr['Star']			= $ObjDomain->getStarOption();
if($retFea['MaritalStatus'])
	$retArr['MaritalStatus']= $ObjDomain->getMaritalStatusOption();
if($retFea['Gothram'])
	$retArr['Gothram']		= $ObjDomain->getGothramOption();
if($retFea['Dosham'])
	$retArr['Dosham']		= $ObjDomain->getDoshamOption();

//print_r($varGetCookieInfo);
$_POST['gender']=$partnerGender;
if ($varGetCookieInfo['PPAGE'] !=''){
	$varSplitAge = split('~',$varGetCookieInfo['PPAGE']);
	if($varSplitAge[0]!='' && $varSplitAge[0]!=0 && $varSplitAge[1]!='' && $varSplitAge[1]!=0) {
	$_POST['ageFrom']	= $varSplitAge[0];
	$_POST['ageTo']	= $varSplitAge[1];
	} else {
		if($sessGender==1){ 
			$_POST['ageFrom']	= 21;
			$_POST['ageTo']	= 33;
		} else {
			$_POST['ageFrom']	= 18;
			$_POST['ageTo']	= 21;
		}
	}
}

if ($varGetCookieInfo['PPHEIGHT'] !=''){
	$varSplitHeight = split('~',$varGetCookieInfo['PPHEIGHT']);
	if($varSplitHeight[0]!='' && $varSplitHeight[0]!=0.00 && $varSplitHeight[1]!='' && $varSplitHeight[1]!=0.00) {
	$_POST['heightFrom']	= $varSplitHeight[0];
	$_POST['heightTo']	= $varSplitHeight[1];
	} else {
		$_POST['heightFrom']	= '121.92';
		$_POST['heightTo']	= '241.30';
	}
}

if ($varGetCookieInfo['PPLOOKINGFOR'] !='' && $varGetCookieInfo['PPLOOKINGFOR'] !=0){
	$_POST['maritalStatus']	= $varGetCookieInfo['PPLOOKINGFOR'];
}

if ($varGetCookieInfo['PPPHYSICALSTATUS'] !='' && $varGetCookieInfo['PPPHYSICALSTATUS'] !=0){
	$_POST['physicalStatus']	= $varGetCookieInfo['PPPHYSICALSTATUS'];
}

if ($varGetCookieInfo['PPMOTHERTONGUE'] !='' && $varGetCookieInfo['PPMOTHERTONGUE'] !=0){
	$_POST['motherTongue']	= $varGetCookieInfo['PPMOTHERTONGUE'];
}

if (sizeof($retArr['Religion'])>1 && $varGetCookieInfo['PPRELIGION'] !='' && $varGetCookieInfo['PPRELIGION'] !=0 && $varGetCookieInfo['PPINCLUDEOTHERRELIGION']==0){
	$_POST['religion']	= $varGetCookieInfo['PPRELIGION'];
}

if ($varGetCookieInfo['PPCASTE'] !='' && $varGetCookieInfo['PPCASTE'] !=0){
	$_POST['caste']	= $varGetCookieInfo['PPCASTE'];
}

if ($varGetCookieInfo['PPEDUCATION'] !='' && $varGetCookieInfo['PPEDUCATION'] !=0){
	$_POST['education']	= $varGetCookieInfo['PPEDUCATION'];
}

if ($varGetCookieInfo['PPCOUNTRY'] !='' && $varGetCookieInfo['PPCOUNTRY'] !=0){
	$_POST['country']	= $varGetCookieInfo['PPCOUNTRY'];
}

if ($varGetCookieInfo['PPSUBCASTE'] !='' && $varGetCookieInfo['PPSUBCASTE'] !=0){
	$_POST['subcaste']	= $varGetCookieInfo['PPSUBCASTE'];
}

if ($varGetCookieInfo['PPGOTHRAMID'] !='' && $varGetCookieInfo['PPGOTHRAMID'] !=0){
	$_POST['gothram']	= $varGetCookieInfo['PPGOTHRAMID'];
}
?>