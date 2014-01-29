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
	$arrTotalFields[]	= 'Age';
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
	$arrTotalFields[]	= 'Height';
}

if ($varGetCookieInfo['PPLOOKINGFOR'] !='' && $varGetCookieInfo['PPLOOKINGFOR'] !=0){
	$_POST['maritalStatus']	= $varGetCookieInfo['PPLOOKINGFOR'];
	$arrTotalFields[]	= 'Marital_Status';
}

if ($varGetCookieInfo['PPPHYSICALSTATUS'] !='' && $varGetCookieInfo['PPPHYSICALSTATUS'] !=0){
	$_POST['physicalStatus']	= $varGetCookieInfo['PPPHYSICALSTATUS'];
	$arrTotalFields[]	= 'Physical_Status';
}

if ($varGetCookieInfo['PPMOTHERTONGUE'] !='' && $varGetCookieInfo['PPMOTHERTONGUE'] !=0){
	$_POST['motherTongue']	= $varGetCookieInfo['PPMOTHERTONGUE'];
	$arrTotalFields[]	= 'Mother_Tongue';
}

if (sizeof($retArr['Religion'])>1 && $varGetCookieInfo['PPRELIGION'] !='' && $varGetCookieInfo['PPRELIGION'] !=0 && $varGetCookieInfo['PPINCLUDEOTHERRELIGION']==0){
	$_POST['religion']	= $varGetCookieInfo['PPRELIGION'];
	$arrTotalFields[]	= 'Religion';
}

if ($varGetCookieInfo['PPCASTE'] !='' && $varGetCookieInfo['PPCASTE'] !=0){
	$_POST['caste']	= $varGetCookieInfo['PPCASTE'];
	$arrTotalFields[]	= 'Caste';
}

if ($varGetCookieInfo['PPEATHABITS'] !='' && $varGetCookieInfo['PPEATHABITS'] !=0){
	$_POST['eating']	= $varGetCookieInfo['PPEATHABITS'];
	$arrTotalFields[]	= 'Eating_Habits';
}

if ($varGetCookieInfo['PPEDUCATION'] !='' && $varGetCookieInfo['PPEDUCATION'] !=0){
	$_POST['education']	= $varGetCookieInfo['PPEDUCATION'];
	$arrTotalFields[]	= 'Education';
}

if ($varGetCookieInfo['PPCITIZENSHIP'] !='' && $varGetCookieInfo['PPCITIZENSHIP'] !=0){
	$_POST['citizenship']	= $varGetCookieInfo['PPCITIZENSHIP'];
	$arrTotalFields[]	= 'Citizenship';
}

if ($varGetCookieInfo['PPCOUNTRY'] !='' && $varGetCookieInfo['PPCOUNTRY'] !=0){
	$_POST['country']	= $varGetCookieInfo['PPCOUNTRY'];
	$arrTotalFields[]	= 'Country';
}

if ($varGetCookieInfo['PPINDIASTATE'] !='' && $varGetCookieInfo['PPINDIASTATE'] !=0 && $varGetCookieInfo['PPUSASTATE'] !='' && $varGetCookieInfo['PPUSASTATE'] !=0){
	$_POST['residingState']	= $varGetCookieInfo['PPINDIASTATE'].'~'.$varGetCookieInfo['PPUSASTATE'];
	$arrTotalFields[]	= 'Resident_India_State';
	$arrTotalFields[]	= 'Resident_USA_State';
} else if ($varGetCookieInfo['PPINDIASTATE'] !='' && $varGetCookieInfo['PPINDIASTATE'] !=0){
	$_POST['residingState']	= $varGetCookieInfo['PPINDIASTATE'];
	$arrTotalFields[]	= 'Resident_India_State';
} else if ($varGetCookieInfo['PPUSASTATE'] !='' && $varGetCookieInfo['PPUSASTATE'] !=0){
	$_POST['residingState']	= $varGetCookieInfo['PPUSASTATE'];
	$arrTotalFields[]	= 'Resident_USA_State';
}

if ($varGetCookieInfo['PPRESIDENTSTATUS'] !='' && $varGetCookieInfo['PPRESIDENTSTATUS'] !=0){
	$_POST['residentStatus']	= $varGetCookieInfo['PPRESIDENTSTATUS'];
	$arrTotalFields[]	= 'Resident_Status';
}

if ($varGetCookieInfo['PPSMOKEHABITS'] !='' && $varGetCookieInfo['PPSMOKEHABITS'] !=0){
	$_POST['smoking']	= $varGetCookieInfo['PPSMOKEHABITS'];
	$arrTotalFields[]	= 'Smoke';
}

if ($varGetCookieInfo['PPDRINKHABITS'] !='' && $varGetCookieInfo['PPDRINKHABITS'] !=0){
	$_POST['drinking']	= $varGetCookieInfo['PPDRINKHABITS'];
	$arrTotalFields[]	= 'Drink';
}

if ($varGetCookieInfo['PPSUBCASTE'] !='' && $varGetCookieInfo['PPSUBCASTE'] !=0){
	$_POST['subcaste']	= $varGetCookieInfo['PPSUBCASTE'];
	$arrTotalFields[]	= 'Subcaste';
}

if ($varGetCookieInfo['PPDENOMINATION'] !='' && $varGetCookieInfo['PPDENOMINATION'] !=0){
	$_POST['denomination']	= $varGetCookieInfo['PPDENOMINATION'];
	$arrTotalFields[]	= 'Denomination';
}

if ($varGetCookieInfo['PPHAVECHILDREN'] !='' && $varGetCookieInfo['PPHAVECHILDREN'] !=0){
	$_POST['haveChildren']	= $varGetCookieInfo['PPHAVECHILDREN'];
	$arrTotalFields[]	= 'Children_Living_Status';
}

if ($varGetCookieInfo['PPEMPLOYEDIN'] !='' && $varGetCookieInfo['PPEMPLOYEDIN'] !=0){
	$_POST['occupationCat']	= $varGetCookieInfo['PPEMPLOYEDIN'];
	$arrTotalFields[]	= 'Employed_In';
}

if ($varGetCookieInfo['PPOCCUPATION'] !='' && $varGetCookieInfo['PPOCCUPATION'] !=0){
	$_POST['occupation']	= $varGetCookieInfo['PPOCCUPATION'];
	$arrTotalFields[]	= 'Occupation';
}

if ($varGetCookieInfo['PPGOTHRAMID'] !='' && $varGetCookieInfo['PPGOTHRAMID'] !=0){
	$_POST['gothram']	= $varGetCookieInfo['PPGOTHRAMID'];
	$arrTotalFields[]	= 'Gothram';
}

if ($varGetCookieInfo['PPSTAR'] !='' && $varGetCookieInfo['PPSTAR'] !=0){
	$_POST['star']	= $varGetCookieInfo['PPSTAR'];
	$arrTotalFields[]	= 'Star';
}

if ($varGetCookieInfo['PPRAASI'] !='' && $varGetCookieInfo['PPRAASI'] !=0){
	$_POST['raasi']	= $varGetCookieInfo['PPRAASI'];
	$arrTotalFields[]	= 'Raasi';
}

if ($varGetCookieInfo['PPCHEVVAIDOSHAM'] !='' && $varGetCookieInfo['PPCHEVVAIDOSHAM'] !=0){
	$_POST['manglik']	= $varGetCookieInfo['PPCHEVVAIDOSHAM'];
	$arrTotalFields[]	= 'Chevvai_Dosham';
}

if ($varGetCookieInfo['PPRESIDENTDISTRICT'] !='' && $varGetCookieInfo['PPRESIDENTDISTRICT'] !=0){
	$arrDitrict	= split('~', trim($varGetCookieInfo['PPRESIDENTDISTRICT'],'~'));
	foreach($arrDitrict as $k=>$v) {
		$varstatecityval	= $arrCityStateMapping[$v].'#'.$v.'~';
	}
	$_POST['residingCity']	= trim($varstatecityval,'~');
	$arrTotalFields[]	= 'Resident_District';
}

if ($varGetCookieInfo['PPSTINCOME'] !='' && $varGetCookieInfo['PPSTINCOME'] !=0){
	$_POST['annualIncome']	= $varGetCookieInfo['PPSTINCOME'];
	$arrTotalFields[]	= 'Annual_Income_INR';
}

if ($varGetCookieInfo['PPENDINCOME'] !='' && $varGetCookieInfo['PPENDINCOME'] !=0){
	$_POST['annualIncome1']	= $varGetCookieInfo['PPENDINCOME'];
	$arrTotalFields[]	= 'Annual_Income_INR';
}

$arrMatchwatchExludeFields	= array(0=>'Smoke',1=>'Drink',2=>'Children_Living_Status',3=>'Occupation',4=>'Star',5=>'Raasi');

$arrRecommendedExcludeFields= array(0=>'Smoke',1=>'Drink',2=>'Children_Living_Status',3=>'Occupation',4=>'Star',5=>'Raasi',6=>'Chevvai_Dosham',7=>'Citizenship', 8=>'Country', 9=>'Resident_India_State', 10=>'Resident_USA_State', 11=>'Resident_District', 12=>'Resident_Status', 13=>'Annual_Income_INR');
?>