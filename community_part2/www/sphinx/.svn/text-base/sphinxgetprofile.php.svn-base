<?php
// COMMENTED FOR TESTING
$varRootPath		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varRootPath);

include_once($varRootBasePath."/lib/sphinxapi.php"); 
include_once($varRootBasePath."/conf/sphinxclass.cil14");
include_once($varRootBasePath."/conf/sphinxgenericfunction.cil14");
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/ip.cil14");
include_once($varRootBasePath.'/lib/clsDomain.php');

//Get Domain related informations
$ObjDomain = new domainInfo();

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

$arrOption	= array();
$arrFaceting= array();

$varOptCnt	= count($retArr['Religion']);
if($retFea['Religion'] == 1){ 
	$arrFaceting['Religion'] = 1;
	if($varOptCnt>1){$arrOption['Religion'] = 1;}
}

$varOptCnt	= count($retArr['Denomination']);
if($retFea['Denomination'] == 1){
	$arrFaceting['Denomination'] = 1;
	if($varOptCnt>1){$arrOption['Denomination'] = 1;}
}

$varOptCnt	= count($retArr['Caste']);
if($retFea['Caste'] == 1){
	$arrFaceting['Caste'] = 1;
	if($varOptCnt>1){$arrOption['Caste'] = 1;}
}

$varOptCnt	= count($retArr['Subcaste']);
if($retFea['Subcaste'] == 1){
	$arrFaceting['Subcaste'] = 1;
	if($varOptCnt>1){$arrOption['Subcaste'] = 1;}
}

$varOptCnt	= count($retArr['Star']);
if($retFea['Star'] == 1){
	$arrFaceting['Star'] = 1;
	if($varOptCnt>1){$arrOption['Star'] = 1;}
}

$varOptCnt	= count($retArr['Gothram']);
if($retFea['Gothram'] == 1){
	$arrFaceting['Gothram'] = 1;
	if($varOptCnt>1){$arrOption['Gothram'] = 1;}
}

if($retFea['Dosham'] == 1){ $arrFaceting['Dosham'] = 1;}

function getQueryVal($argArray){
	$varReturn = array();
	if($argArray != ''){
		if(is_array($argArray))
			return $argArray;
		else if(is_numeric($argArray) || preg_match("/~/", $argArray) || preg_match("/[0-9]+\#[0-9]+/", $argArray))
			return split('~', trim($argArray,'~'));
	}else{
		return $varReturn;
	}
}

function getSimilerProfiles($argArrConds, $argCommunityId, $argGender){
	global $arrFaceting, $arrOption, $varSphinx;
	
	$varGender			= $argArrConds["gender"];
	$varMatriId			= substr($argArrConds["matriid"],3);	
	$varAgeFrom			= $argArrConds["ageFrom"];	
	$varAgeTo			= $argArrConds["ageTo"];
	$varHeightFrom		= $argArrConds['heightFrom'];	
	$varHeightTo		= $argArrConds['heightTo'];
	$varPhysicalStatus	= $argArrConds["physicalStatus"];
	$varMaritalStatus	= $argArrConds["maritalStatus"];
	$varMotherTongue	= $argArrConds["motherTongue"];
	$varReligion		= $argArrConds["religion"];	
	$varDenomination	= $argArrConds["denomination"];
	$varCaste			= $argArrConds["caste"];
	$varSubcaste		= $argArrConds["subcaste"];
	$varGothram			= $argArrConds["gothram"];
	$varEducation		= $argArrConds["education"];
	$varCountry			= $argArrConds["country"];

	$arrMaritalStatus	= getQueryVal($varMaritalStatus);
	$arrDenomination	= getQueryVal($varDenomination);
	$arrCaste			= getQueryVal($varCaste);
	$arrSubcaste		= getQueryVal($varSubcaste);
	$arrGothram			= getQueryVal($varGothram);
	$arrEducation		= getQueryVal($varEducation);
	$arrMotherTongue	= getQueryVal($varMotherTongue);
	$arrCountry			= getQueryVal($varCountry);

	//Get Sphinx IndexName
	$arrSphinxIdxName = getSphinxIndexName($argCommunityId, $argGender);
	$funSphinxIdxName = $arrSphinxIdxName['sphinxmemberinfo'];

	//Sphinx Connection
	$s= new sphinxdb();
	$s->SphinxConnect($varSphinx['IP'], $varSphinx['PORT'], 'SPH_MATCH_FULLSCAN', '30');

	//error log for connection
	$searchderr = $s->GetLastError();
	if(trim($searchderr)<>''){		
		$file_content = "\n MatriId : ".$argArrConds["matriid"]."IP : ".$varSphinx['IP']." PORT : ".$varSphinx['PORT']." SearchdErr : ".$searchderr." Time ".date("H:i:s:u")." Connection; Sphinx Obj : "; 
        $file_name = "/var/log/cbslog/sphinxlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."sphinxgetprofilelog.txt";
        $fp = fopen($file_name,"a");
        @fwrite($fp, $file_content);
        fclose($fp);
        
		// Searchd returned error
		$arrProfiles = array();
		return $arrProfiles;
	}

	$s->SetArrayResult(true);

	//SET ORDER BY
	$s->SetSortMode(SPH_SORT_ATTR_DESC, "Last_Login");

	// SET Publish=1 & not deleted ids
	$s->SetFilter("Publish",array(1));
	$s->SetFilter("Deleted",array(0));

	$s->SetFilter("Photo_Set_Status",array(1));
	$s->SetFilter("Protect_Photo_Set_Status",array(0));

	// SET Age & Height
	$s->SetFilterRange("Age",$varAgeFrom,$varAgeTo);
	if($varHeightFrom>0 && $varHeightTo>0 && $varHeightFrom<=$varHeightTo){
		$s->SetFilterFloatRange("Height",floor($varHeightFrom),ceil($varHeightTo));
	}
	
	// SET MatriId
	if($varMatriId!=''){
		$s->SetFilter("ProfileIndex",array($varMatriId),true);
	}

	// SET Physical status
	if($varPhysicalStatus>0){
		$arrPhysicalStatus = array($varPhysicalStatus);
		$s->SetFilter("Physical_Status",$arrPhysicalStatus);
	}

	// SET Marital status
	if(count($arrMaritalStatus)>0){
		$s->SetFilter("Marital_Status",$arrMaritalStatus);
	}

	// SET Mother tongue
	if(count($arrMotherTongue)>0){
		$s->SetFilter("Mother_TongueId",$arrMotherTongue);
	}

	// SET Religion
	if($varReligion>0){
		$s->SetFilter("Religion",array($varReligion));
	}

	// SET Denomination
	if($arrFaceting["Denomination"]==1 && $arrOption['Denomination']==1) {
		$s->SetFilter("Denomination",$arrDenomination);
	}

	// SET Caste
	if($arrFaceting["Caste"]==1 && $arrOption['Caste']==1 && count($arrCaste)>0){
		$s->SetFilter("CasteId",$arrCaste);
	}

	// SET Subcaste
	if($arrFaceting["Subcaste"]==1 && $arrOption['Subcaste']==1 && count($arrSubcaste)>0){
		$s->SetFilter("SubcasteId",$arrSubcaste);
	}

	// SET Education
	if(count($arrEducation)>0){
		$s->SetFilter("Education_Category",$arrEducation);
	}

	// SET GothramId
	if(count($arrGothram)>0 && $varGothram>0){
		$s->SetFilter("GothramId", $arrGothram, true);	
	}

	// SET GothramId
	if(count($arrCountry)>0 && $varCountry==98){
		$s->SetFilter("Country", $arrCountry);	
	}else if(count($arrCountry)>0){
		$arrCountry = array('98');
		$s->SetFilter("Country", $arrCountry, true);	
	}
	
	$s->SetMatchMode(SPH_MATCH_FULLSCAN);
	$s->setMaxQueryTime(10000);

	$s->SetSortMode(SPH_SORT_EXTENDED, "@random");
	$s->SetLimits(0,4);

	$s->AddQuery($varQuery,$funSphinxIdxName);
	
	$varResult=$s->RunQueries();

	$searchderr=$s->GetLastError();
	if(trim($searchderr)<>''){		
		$file_content = "\n MatriId : ".$argArrConds["matriid"]."IP : ".$varSphinx['IP']." PORT : ".$varSphinx['PORT']." SearchdErr : ".$searchderr." Time ".date("H:i:s:u")." Getting results : "; 
		$file_name = "/var/log/cbslog/sphinxlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."sphinxgetprofilelog.txt";
		$fp = fopen($file_name,"a");
		@fwrite($fp, $file_content);
		fclose($fp);
		
		// Searchd returned error
		$arrProfiles = array();
		return $arrProfiles;
	}

	$arrTotalResult = array();
	if($varResult[0]['total']>0){
		$arrTotalResult = getParseValuesAsArray($varResult, array('profileindex', 'communityid', 'publish', 'paid_status', 'special_priv', 'gender', 'age', 'height', 'mother_tongueid', 'physical_status', 'religion', 'denomination', 'casteid', 'subcasteid', 'gothramid', 'star', 'raasi', 'chevvai_dosham', 'country', 'citizenship', 'eating_habits', 'smoke', 'drink', 'body_type', 'appearance', 'complexion', 'residing_state', 'residing_district', 'resident_status', 'education_category', 'education_subcategory', 'photo_set_status', 'horoscope_available', 'protect_photo_set_status', 'horoscope_protected', 'marital_status', 'phone_verified', 'last_login', 'occupation', 'no_of_children', 'caste_nobar', 'subcaste_nobar', 'partner_set_status','onlinestatus','date_created'),$argCommunityId);
	}
	return $arrTotalResult;
}
?>