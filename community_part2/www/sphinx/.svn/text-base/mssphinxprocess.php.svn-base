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
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/www/matchsummary/msummarytools.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsCache.php');

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

function getExcludeCond($argField,$arrExludeFields) {

	$varReturnVal	= (in_array($argField,$arrExludeFields))?true:'';
	return $varReturnVal;
}

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

//getResultsfromSphinx(indexname, groupby_field,CommunityId,viewtype,purpose)
//$argViewType=1=>yet to be viewed,2=>viewed & not contacted
//$argPurpose=1=>get total count,2=>my home recommended purpose,3=>tools purpose
function getResultsfromSphinx($argSphinxIdxName, $argGroupbyField='',$argCommunityId='',$argViewType,$argPurpose='', $argEndLimit='', $argViewAddedType=''){
	global $sessMatriId,$sessGender,$sessGothram,$objMasterDB,$objSrchBasicView,$varTable,$varRootPath;
	global $arrFaceting, $arrOption, $varSphinx, $varStartRec;
	global $arrHeightFeetList;

	$varTempTable			= $varTable['SEARCHFILTERLIST'];
	$arrExludeFields		= array();

	if($_POST['excludefields']!='') {
		$arrExludeFields		= explode("|",$_POST['excludefields']);
	}

	if($sessMatriId!='')
		$varGender	= $sessGender==2 ? 1 : 2;
	else
		$varGender	= $_POST["gender"]!='' ? $_POST["gender"] : 2;
			
	$varAgeFrom			= trim($_POST["ageFrom"]);	
	$varAgeTo			= trim($_POST["ageTo"]);
	if($varGender==1){ 
		$varAgeFrom	= ($varAgeFrom<21 || $varAgeFrom>70) ? 21 : $varAgeFrom;
		$varAgeTo	= ($varAgeTo<21 || $varAgeTo>70)? 33 : $varAgeTo;
	}else{
		$varAgeFrom	= ($varAgeFrom<18 || $varAgeFrom>70) ? 18 : $varAgeFrom;
		$varAgeTo	= ($varAgeTo<18 || $varAgeTo>70)? 21 : $varAgeTo;
	}

	$varHeightFrom	= ($_POST['heightFrom']=="")?'121.92':$_POST["heightFrom"];	
	$varHeightTo	= ($_POST['heightTo']=="")?'241.30':$_POST["heightTo"];

	$varHaveChildren	= $_POST["haveChildren"];
	$varPhysicalStatus	= $_POST["physicalStatus"];
	$varAnnualIncome	= $_POST["annualIncome"];
	$varAnnualIncome1	= $_POST["annualIncome1"];
	$varManglik			= $_POST["manglik"];
	$varComplexion		= $_POST["complexion"];
	$varBodyType		= $_POST["bodyType"];
	$varEatingHabits	= $_POST["eating"];
	$varDrinking		= $_POST["drinking"];
	$varSmoking			= $_POST["smoking"];
	$varMaritalStatus	= $_POST["maritalStatus"];
	$varReligion		= $_POST["religion"];	
	$varDenomination	= $_POST["denomination"];
	$varCaste			= $_POST["caste"];
	$varSubcaste		= $_POST["subcaste"];
	$varOccupationCat	= $_POST["occupationCat"];
	$varEducation		= $_POST["education"];
	$varOccupation		= $_POST["occupation"];
	$varMotherTongue	= $_POST["motherTongue"];
	$varResidingState	= $_POST["residingState"];
	$varResidingCity	= $_POST["residingCity"];
	$varResidentStatus	= $_POST["residentStatus"];
	$varCitizenship		= $_POST["citizenship"];
	$varCountry			= $_POST["country"];
	$varGothram			= $_POST["gothram"];
	$varStar			= $_POST["star"];
	$varRaasi			= $_POST["raasi"];
	$varActive			= $_POST["active"];
	$varCreatedBy		= $_POST["createdBy"];
	$varCasteTxt		= addslashes($_POST["casteTxt"]);
	$varSubcasteTxt		= addslashes($_POST["subcasteTxt"]);
	$varMotherTongTxt	= addslashes($_POST["motherTongueTxt"]);
	$varGothramTxt		= addslashes($_POST["gothramTxt"]);
	
	$varPhotoOpt		= $_POST["photoOpt"]==1 ? 1 : 0;
	$varProtectPhotoOpt	= $_POST["protectphotoOpt"]==1 ? 1 : 0;
	$varHoroscopeOpt	= $_POST["horoscopeOpt"]==1 ? 1 : 0;
	$varViewedOpt		= $_POST["alreadyViewedOpt"]==1 ? 1 : 0;
	$varContactOpt		= $_POST["alreadyContOpt"]==1 ? 1 : 0;
	$varShortlistOpt	= $_POST["shortlistOpt"]==1 ? 1 : 0;
	$varPostPg			= $_POST["Page"];

	$arrMaritalStatus	= getQueryVal($varMaritalStatus);

	$arrDenomination	= getQueryVal($varDenomination);
	$arrCaste			= ($varCasteTxt=='yes') ? $varCaste : getQueryVal($varCaste);
	$arrSubcaste		= ($varSubcasteTxt=='yes') ? $varSubcaste : getQueryVal($varSubcaste);
	
			
	$arrGothram			= ($varGothramTxt=='yes') ? $varGothram : getQueryVal($varGothram);
	$arrStar			= getQueryVal($varStar);
	$arrRaasi			= getQueryVal($varRaasi);
	$arrManglik			= getQueryVal($varManglik);

	$arrOccupationCat	= getQueryVal($varOccupationCat);
	$arrEducation		= getQueryVal($varEducation);
	$arrOccupation		= getQueryVal($varOccupation);
	
	$arrMotherTongue	= getQueryVal($varMotherTongue);

	$arrCitizenship		= getQueryVal($varCitizenship);
	$arrCountry			= getQueryVal($varCountry);
	$arrResidentStatus	= getQueryVal($varResidentStatus);
	$arrResidingState	= getQueryVal($varResidingState);
	$arrResidingCity	= getQueryVal($varResidingCity);

	$arrComplexion		= getQueryVal($varComplexion);
	$arrBodyType		= getQueryVal($varBodyType);
	$arrEatingHabits	= getQueryVal($varEatingHabits);
	$arrDrinking		= getQueryVal($varDrinking);
	$arrSmoking			= getQueryVal($varSmoking);

	$arrCreatedBy	= getQueryVal($varCreatedBy);

	//To set start limit for query.
	if($argPurpose==3) {
	$varEndRec	= $argEndLimit;
	} else {
	$varEndRec	= 20;
	}
	$isExtended = 0;
	$varQuery	= '';

	//Sphinx Connection
	$s= new sphinxdb();
	$s->SphinxConnect($varSphinx['IP'], $varSphinx['PORT'], 'SPH_MATCH_FULLSCAN', '30');

	//error log for connection
	$searchderr = $s->GetLastError();
	if(trim($searchderr)<>''){		
		$file_content = "\n MatriId : ".$sessMatriId."IP : ".$varSphinx['IP']." PORT : ".$varSphinx['PORT']." SearchdErr : ".$searchderr." Time ".date("H:i:s:u")." Connection; Sphinx Obj : "; 
        $file_name = "/var/log/cbslog/sphinxlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."ms_sphinxprocesslog.txt";
        $fp = fopen($file_name,"a");
        @fwrite($fp, $file_content);
        fclose($fp);
        
		// Searchd returned error
		$arrSrchProfiles['err']=1;
		return $arrSrchProfiles;
	}

	$s->SetArrayResult(true);

	//For featured profile (Profile highlighter) Starts

	// SET Publish=1 & not deleted ids
	$s->SetFilter("Publish",array(1));
	$s->SetFilter("Deleted",array(0));
	$s->SetFilter("Profile_Highlighter",array(1));

	// SET Age & Height
	$s->SetFilterRange("Age",$varAgeFrom,$varAgeTo);
	
	if($varHeightFrom>0 && $varHeightTo>0 && $varHeightFrom<=$varHeightTo){
		$s->SetFilterFloatRange("Height",floor($varHeightFrom),ceil($varHeightTo));
	}

	// SET Matrital Status & Have children
	if(count($arrMaritalStatus)==1 && $arrMaritalStatus[0] == 1){
		// SET if Marital status is Unmarried only
		$s->SetFilter("Marital_Status",$arrMaritalStatus);
	}else {
		if(!in_array(0,$arrMaritalStatus)){
			$s->SetFilter("Marital_Status",$arrMaritalStatus);
		}
			
		if(isset($varHaveChildren) && $varHaveChildren>0)
		{
			if($varHaveChildren > 1){
				$varHaveChildren = $varHaveChildren-2;
				$arrHaveChildren = array($varHaveChildren);
				if(in_array(1, $arrMaritalStatus) || count($arrMaritalStatus)==0){
				$arrHaveChildren[] = 100;
				}
				$s->SetFilter("Children_Living_Status",$arrHaveChildren);
			}else if($varHaveChildren == 1){
				$s->SetFilter("No_Of_Children", array('0'));
			}
		}
	}

	// SET Religion
	if($varReligion > 0 && $arrFaceting["Religion"]==1 && $arrOption['Religion']==1){
		$arrReligion = array($varReligion);
		$s->SetFilter("Religion",$arrReligion);
	}

	// SET Caste
	$casteQuery = '';
	if($varCaste!='' && $varCasteTxt=='' && $arrFaceting["Caste"]==1 && $arrOption['Caste']==1 && !in_array(0,$arrCaste)){
		$s->SetFilter("CasteId",$arrCaste);
	}else if($arrFaceting['Caste']==1 && $varCasteTxt == 'yes' && strlen(trim($varCaste)) >= 3){
		$casteQuery.=" @CasteText '*".$varCaste."*' ";
		$isExtended = 1;
	}

	// SET Subcaste
	$subcasteQuery = '';
	if($varSubcaste!='' && $varSubcasteTxt=='' && $arrFaceting["Subcaste"]==1 && $arrOption['Subcaste']==1 && !in_array(0,$arrSubcaste)){
		$s->SetFilter("SubcasteId",$arrSubcaste);
	}else if($arrFaceting['Subcaste']==1 && $varSubcasteTxt == 'yes' && strlen(trim($varSubcaste)) >= 3){
		$subcasteQuery.=" @SubcasteText '*".$varSubcaste."*' ";
		$isExtended = 1;
	}

	// SET Mother tongue
	if(count($arrMotherTongue)>0 && !in_array(0, $arrMotherTongue) && $varMotherTongTxt==''){
		$s->SetFilter("Mother_TongueId", $arrMotherTongue);
	}

	// SET Gothram
	$gothramQuery = '';
	if($varGothram!='' && $varGothramTxt=='' && $arrFaceting["Gothram"]==1 && $arrOption['Gothram']==1){
		if(in_array(99, $arrGothram) && $sessMatriId !=''){
			//Get logged ids gothram from cookie
			if($sessGothram!=''){
				$s->SetFilter("GothramId", array($sessGothram), true);
			}			
		}else if(count($arrGothram)>0){
			$s->SetFilter("GothramId", $arrGothram);	
		}
	}else if($arrFaceting['Gothram']==1 && $varGothramTxt == 'yes' && strlen(trim($varGothram)) >= 3){
		$gothramQuery.=" @GothramText '*".$varGothram."*' ";
		$isExtended = 1;
	}

	// SET Education
	if($varEducation!='' && !in_array(0, $arrEducation)){
		$s->SetFilter("Education_Category",$arrEducation);
	}

	// SET Country
	if($varCountry!='' && !in_array(0,$arrCountry)){
		if((in_array(98, $arrCountry) || in_array(222, $arrCountry)) && count($arrResidingState) > 0){
			//need to work here
			$varCountryQuery = getCountryQuery($arrCountry,$arrResidingState,$arrResidingCity);
			$s->SetSelect ("*, ".$varCountryQuery." AS locationfilter");
			$s->SetFilter("locationfilter",array(1));
		}else{
			$s->SetFilter("Country",$arrCountry);
		}
	}

	// SET Caste
	$casteQuery = '';
	if($varCaste!='' && $varCasteTxt=='' && $arrFaceting["Caste"]==1 && $arrOption['Caste']==1 && !in_array(0,$arrCaste)){
		$s->SetFilter("CasteId",$arrCaste);
	}else if($arrFaceting['Caste']==1 && $varCasteTxt == 'yes' && strlen(trim($varCaste)) >= 3){
		$casteQuery.=" @CasteText '*".$varCaste."*' ";
		$isExtended = 1;
	}

	if($isExtended == 1){
		$varQuery = getQueriesConcat($subcasteQuery,$gothramQuery,$casteQuery);
		//$s->AddQuery($varQuery, $argSphinxIdxName);

		$s->SetMatchMode(SPH_MATCH_BOOLEAN);
		$s->setMaxQueryTime(10000);
	}else{
		$s->SetMatchMode(SPH_MATCH_FULLSCAN);
		$s->setMaxQueryTime(10000);
	}

	$s->SetSortMode(SPH_SORT_EXTENDED , "@random");
	$s->SetLimits(0,1);
	$s->AddQuery($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId." - Featured Profile Query");
	$varFPResult=$s->RunQueries();
	
	$searchderr=$s->GetLastError();
	
	if(trim($searchderr)<>''){		
		$file_content = "\n MatriId : ".$sessMatriId."IP : ".$varSphinx['IP']." PORT : ".$varSphinx['PORT']." SearchdErr : ".$searchderr." Time ".date("H:i:s:u")." Getting Feature profile results : "; 
		$file_name = "/var/log/cbslog/sphinxlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."sphinxprocesslog.txt";
		$fp = fopen($file_name,"a");
		@fwrite($fp, $file_content);
		fclose($fp);
		
		// Searchd returned error
		$arrSrchProfiles['err']=1;
		return $arrSrchProfiles;
	}

	$arrFPTotalResult = getParseValues($varFPResult);
	
	$varFPTotCount	= $arrFPTotalResult[0];
	$arrSrchProfiles['fptotalcnt'] = $varFPTotCount;
	if(!empty($varFPResult[0]['matches']) && $argGroupbyField=='')
	{
		$arrFPResult = getParseValuesAsArray($varFPResult, array('profileindex', 'communityid', 'publish', 'paid_status', 'special_priv', 'gender', 'age', 'height', 'mother_tongueid', 'physical_status', 'religion', 'denomination', 'casteid', 'subcasteid', 'gothramid', 'star', 'raasi', 'chevvai_dosham', 'country', 'citizenship', 'eating_habits', 'smoke', 'drink', 'body_type', 'appearance', 'complexion', 'residing_state', 'residing_district', 'resident_status', 'education_category', 'education_subcategory', 'photo_set_status', 'horoscope_available', 'protect_photo_set_status', 'horoscope_protected', 'marital_status', 'phone_verified', 'last_login', 'occupation', 'no_of_children', 'caste_nobar', 'subcaste_nobar', 'partner_set_status','onlinestatus','date_created','profile_highlighter'),$argCommunityId);
		$arrSrchProfiles['fpids']     = $arrFPResult;
	}

	if($argViewAddedType=='fp') {
		return $arrSrchProfiles;
	}
	//For featured profile (Profile highlighter) Ends

	//Eliminate Already viewed, Contacted and Shortlisted Ids
	$s->ResetFilterbyAttr("Profile_Highlighter");
	if($sessMatriId != ""){
		if($varStartRec==0 && $varPostPg==0 && $argViewAddedType!='') {
			$reqTypeVal = ($_REQUEST['req']!='')?$_REQUEST['req']:$_POST['profiletype'];
			
			if($reqTypeVal==1) {
				$addedToolsKey	= 'MSPrefToolsAdded_'.$sessMatriId;
			} else if($reqTypeVal==2) {
				$addedToolsKey	= 'MSRecomToolsAdded_'.$sessMatriId;
			} else if($reqTypeVal==3) {
				$addedToolsKey	= 'MSMatchToolsAdded_'.$sessMatriId;
			}

			$arrTotalViewsAdded = Cache::getData($addedToolsKey);
			//print_r($arrTotalViewsAdded);
			if($argViewAddedType=='p') {
				$arrTotalViewedAddedIds = $arrTotalViewsAdded['photo'][1];
			} else if($argViewAddedType=='pn') {
				$arrTotalViewedAddedIds = $arrTotalViewsAdded['phone'][1];
			} else if($argViewAddedType=='h') {
				$arrTotalViewedAddedIds = $arrTotalViewsAdded['horoscope'][1];
			}
			//print_r($arrTotalViewedAddedIds);
			$varTotalViewedAddedIdsCnt = count($arrTotalViewedAddedIds);
			if($varTotalViewedAddedIdsCnt>14000 && $varMemLimitSet!=1){
				ini_set("memory_limit","64M");
			}	
		
			if($varTotalViewedAddedIdsCnt > 0){

				/*$varPage = ($_POST['Page']>0)?$_POST['Page']:1;
				$varStRec = ($varPage-1)*20;
				$varFinalRec = $varStRec+19;
				
				$arrViewedAddedIds = array();
				if($varTotalViewedAddedIdsCnt<20) {
					$arrViewedAddedIds = $arrTotalViewedAddedIds;
				} else {
					for($i=$varStRec;$i<=$varFinalRec;$i++) {
						if($arrTotalViewedAddedIds[$i]=='') {
							break;
						}
						$arrViewedAddedIds[] = $arrTotalViewedAddedIds[$i];
					}
				}*/
				
				
				$s->SetFilter("ProfileIndex",$arrTotalViewedAddedIds);

				//Cache Part for viewed & contacted ids
				$varTotalIds = join(',' , $arrTotalViewedAddedIds);

				if(count($arrTotalViewedAddedIds) < 20000){
					Cache::deleteData('SPHX_'.$sessMatriId);
					Cache::setData('SPHX_'.$sessMatriId, $varTotalIds);
				}else{
					$arrDBFields	= array('MatriId', 'FilterList');
					//$arrDBFieldVals = array("'".$sessMatriId."'", "'".trim($varTotalIds, ',')."'");
					$arrDBFieldVals = array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB), $objMasterDB->doEscapeString($varTotalIds,$objMasterDB));
					$objMasterDB->insertOnDuplicate($varTempTable,$arrDBFields,$arrDBFieldVals,'MatriId');
					$objMasterDB->dbClose();
				}
			}

		} else if($varStartRec==0 && $varPostPg==0 && $argViewType==1){	
			//Already Viewed
			$arrViewedIds = array();
			if($varViewedProfileCount>14000){
				ini_set("memory_limit","64M");
				$varMemLimitSet = 1;
			}
			$arrProfileViewed = GetSphinxProfilenotesResultSet($sessMatriId,1);
			//echo $arrProfileViewed['viewedlist'].'===1<BR>';
			if($arrProfileViewed['viewedlist']!=''){
				$arrViewedIds = split(',', $arrProfileViewed['viewedlist']);
			}
			
			//Already Contacted
			$arrContactedIds = array();
			$varContactProfileCount=($varTotalIntSent + $varTotalIntRecv + $varTotalMsgSent + $varTotalMsgRecv);

			if($varContactProfileCount>14000 && $varMemLimitSet!=1){
				ini_set("memory_limit","64M");
				$varMemLimitSet = 1;
			}				
			$arrContactList = GetSphinxProfilenotesResultSet($sessMatriId,2);//3->ignore, 4->shortlist
			//echo $arrContactList['contactedlist'].'===2<BR>';
			if($arrContactList['contactedlist']!=''){
				$arrContactedIds = split(',', $arrContactList['contactedlist']);
			}				


			$arrTotalIds = array_merge($arrViewedIds, $arrContactedIds);
			$arrTotalIds = array_unique($arrTotalIds);
			if(count($arrTotalIds)>14000 && $varMemLimitSet!=1){
				ini_set("memory_limit","64M");
			}			
			
			if(count($arrTotalIds) > 0){				
				$s->SetFilter("ProfileIndex",$arrTotalIds, true);
				
				//Cache Part for viewed & contacted ids
				$varTotalIds = join(',' , $arrTotalIds);

				if(count($arrTotalIds) < 20000){
					Cache::deleteData('SPHX_'.$sessMatriId);
					Cache::setData('SPHX_'.$sessMatriId, $varTotalIds);
				}else{
					$arrDBFields	= array('MatriId', 'FilterList');
					//$arrDBFieldVals = array("'".$sessMatriId."'", "'".trim($varTotalIds, ',')."'");
					$arrDBFieldVals = array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB), $objMasterDB->doEscapeString($varTotalIds,$objMasterDB));
					$objMasterDB->insertOnDuplicate($varTempTable,$arrDBFields,$arrDBFieldVals,'MatriId');
					$objMasterDB->dbClose();
				}
			}
		} else if($varStartRec==0 && $varPostPg==0 && $argViewType==2){	
			//Already Viewed
			$arrViewedIds = array();
			if($varViewedProfileCount>14000){
				ini_set("memory_limit","64M");
				$varMemLimitSet = 1;
			}
			$arrProfileViewed = GetSphinxProfilenotesResultSet($sessMatriId,1);
			//echo $arrProfileViewed['viewedlist'].'===1<BR>';
			if($arrProfileViewed['viewedlist']!=''){
				$arrViewedIds = split(',', $arrProfileViewed['viewedlist']);
			}

			//Already Contacted
			$arrContactedIds = array();
			$varContactProfileCount=($varTotalIntSent + $varTotalIntRecv + $varTotalMsgSent + $varTotalMsgRecv);

			if($varContactProfileCount>14000 && $varMemLimitSet!=1){
				ini_set("memory_limit","64M");
				$varMemLimitSet = 1;
			}				
			$arrContactList = GetSphinxProfilenotesResultSet($sessMatriId,2);//3->ignore, 4->shortlist
			//echo $arrContactList['contactedlist'].'===2<BR>';
			if($arrContactList['contactedlist']!=''){
				$arrContactedIds = split(',', $arrContactList['contactedlist']);
			}				

			$arrTotalIds = array_diff($arrViewedIds, $arrContactedIds);
			$arrTotalIds = array_unique($arrTotalIds);
			if(count($arrTotalIds)>14000 && $varMemLimitSet!=1){
				ini_set("memory_limit","64M");
			}			

			if(count($arrTotalIds) > 0){				
				$s->SetFilter("ProfileIndex",$arrTotalIds);
				
				//Cache Part for viewed & contacted ids
				$varTotalIds = join(',' , $arrTotalIds);

				if(count($arrTotalIds) < 20000){
					Cache::deleteData('SPHX_'.$sessMatriId);
					Cache::setData('SPHX_'.$sessMatriId, $varTotalIds);
				}else{
					$arrDBFields	= array('MatriId', 'FilterList');
					//$arrDBFieldVals = array("'".$sessMatriId."'", "'".trim($varTotalIds, ',')."'");
					$arrDBFieldVals = array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB), $objMasterDB->doEscapeString($varTotalIds,$objMasterDB));
					$objMasterDB->insertOnDuplicate($varTempTable,$arrDBFields,$arrDBFieldVals,'MatriId');
					$objMasterDB->dbClose();
				}
			} else {
				$arrSrchProfiles['totalcnt'] = 0;
				$arrSrchProfiles['ids'] = '';
				return $arrSrchProfiles;
			}
		} else {
			$varTotalIds=Cache::getData('SPHX_'.$sessMatriId);	

			if($varTotalIds == ''){
				//$varDBFilterCond = "WHERE MatriId='".$sessMatriId."'";
				$varDBFilterCond = "WHERE MatriId=".$objSrchBasicView->doEscapeString($sessMatriId,$objSrchBasicView);
				$arrDBFields	 = array('FilterList');
				$arrResFilterRes = $objSrchBasicView->select($varTempTable, $arrDBFields, $varDBFilterCond, 1);
				$varTotalIds	 = $arrResFilterRes[0]['FilterList'];
			}

			$varTotalIdsCnt = substr_count($varTotalIds, ',');
			if($varTotalIdsCnt>14000){
				ini_set("memory_limit","64M");
			}

			// Convert String to array
			$arrTotalIds=explode(",",$varTotalIds);
			if(count($arrTotalIds) > 0){
				if($argViewAddedType!='') {
					$arrTotalViewedAddedIds = split(',',$varTotalIds);
					/*$varPage = ($_POST['Page']>0)?$_POST['Page']:1;
					$varStRec = ($varPage-1)*20;
					$varFinalRec = $varStRec+19;
					
					$arrViewedAddedIds = array();

					for($i=$varStRec;$i<=$varFinalRec;$i++) {
						if($arrTotalViewedAddedIds[$i]=='') {
							break;
						}
						$arrViewedAddedIds[] = $arrTotalViewedAddedIds[$i];
					}*/
					$s->SetFilter("ProfileIndex",$arrTotalViewedAddedIds);
				} else if($argViewType==1) {
					$s->SetFilter("ProfileIndex",$arrTotalIds, true);
				} else if($argViewType==2) {
					$s->SetFilter("ProfileIndex",$arrTotalIds);
				}
			}
		}
	}

	//SET ORDER BY
	$s->SetSortMode(SPH_SORT_ATTR_DESC, "Last_Login");

	// SET Publish=1 & not deleted ids
	$s->SetFilter("Publish",array(1));
	$s->SetFilter("Deleted",array(0));

	// SET Age & Height
	$s->SetFilterRange("Age",$varAgeFrom,$varAgeTo);
	if($varHeightFrom>0 && $varHeightTo>0 && $varHeightFrom<=$varHeightTo){
		$s->SetFilterFloatRange("Height",floor($varHeightFrom),ceil($varHeightTo));
	}

	// SET Physical status
	if($varPhysicalStatus!=2 && $varPhysicalStatus!=''){
		$arrPhysicalStatus = array($varPhysicalStatus);
		$s->SetFilter("Physical_Status",$arrPhysicalStatus);
	}

	//Active status
	$weekts = mktime(0,0,0,date("n"),date("j")-7,date("Y"));					
	$monthts = mktime(0,0,0,date("n"),date("j")-30,date("Y"));
	if($_COOKIE['lltimestamp']==''){
		$currdatetimets = mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"));
		setcookie('lltimestamp', $currdatetimets, 0, '/');
	}else{
		$currdatetimets = $_COOKIE['lltimestamp'];
	}

	if(is_numeric($varActive) && $varActive>=0 && $varActive<=2){
		if($varActive==0){ $s->SetFilter("OnlineStatus",array(1)); }
		else if($varActive==1){$s->SetFilterRange("Last_Login",$weekts,$currdatetimets); }
		else if($varActive==2){$s->SetFilterRange("Last_Login",$monthts,$currdatetimets); }
	}else{
		$s->SetFilterRange("Last_Login",0,$currdatetimets);
	}

	// SET Matrital Status & Have children
	if(count($arrMaritalStatus)==1 && $arrMaritalStatus[0] == 1){
		// SET if Marital status is Unmarried only
		$s->SetFilter("Marital_Status",$arrMaritalStatus);
	}else {
		if(!in_array(0,$arrMaritalStatus)){
			$s->SetFilter("Marital_Status",$arrMaritalStatus);
		}
			
		if(isset($varHaveChildren) && $varHaveChildren>0)
		{
			if($varHaveChildren > 1){
				$varHaveChildren = $varHaveChildren-2;
				$arrHaveChildren = array($varHaveChildren);
				if(in_array(1, $arrMaritalStatus) || count($arrMaritalStatus)==0){
				$arrHaveChildren[] = 100;
				}
				$varExcludeCond = getExcludeCond('Children_Living_Status',$arrExludeFields);
				$s->SetFilter("Children_Living_Status",$arrHaveChildren,$varExcludeCond);
			}else if($varHaveChildren == 1){
				$s->SetFilter("No_Of_Children", array('0'));
			}
		}
	}

	// SET Religion
	if($varReligion > 0 && $arrFaceting["Religion"]==1 && $arrOption['Religion']==1){
		$arrReligion = array($varReligion);
		$s->SetFilter("Religion",$arrReligion);
	}

	// SET Denomination
	if($varDenomination!='' && $arrFaceting["Denomination"]==1 && $arrOption['Denomination']==1) {
		$s->SetFilter("Denomination",$arrDenomination);
	}

	// SET Caste
	$casteQuery = '';
	if($varCaste!='' && $varCasteTxt=='' && $arrFaceting["Caste"]==1 && $arrOption['Caste']==1 && !in_array(0,$arrCaste)){
		$s->SetFilter("CasteId",$arrCaste);
	}else if($arrFaceting['Caste']==1 && $varCasteTxt == 'yes' && strlen(trim($varCaste)) >= 3){
		$casteQuery.=" @CasteText '*".$varCaste."*' ";
		$isExtended = 1;
	}

	// SET Subcaste
	$subcasteQuery = '';
	if($varSubcaste!='' && $varSubcasteTxt=='' && $arrFaceting["Subcaste"]==1 && $arrOption['Subcaste']==1 && !in_array(0,$arrSubcaste)){
		$s->SetFilter("SubcasteId",$arrSubcaste);
	}else if($arrFaceting['Subcaste']==1 && $varSubcasteTxt == 'yes' && strlen(trim($varSubcaste)) >= 3){
		$subcasteQuery.=" @SubcasteText '*".$varSubcaste."*' ";
		$isExtended = 1;
	}

	// SET Mother tongue
	if(count($arrMotherTongue)>0 && !in_array(0, $arrMotherTongue) && $varMotherTongTxt==''){
		$s->SetFilter("Mother_TongueId", $arrMotherTongue);
	}

	// SET Gothram
	$gothramQuery = '';
	if($varGothram!='' && $varGothramTxt=='' && $arrFaceting["Gothram"]==1 && $arrOption['Gothram']==1){
		if(in_array(99, $arrGothram) && $sessMatriId !=''){
			//Get logged ids gothram from cookie
			if($sessGothram!=''){
				$s->SetFilter("GothramId", array($sessGothram), true);
			}			
		}else if(count($arrGothram)>0){
			$s->SetFilter("GothramId", $arrGothram);	
		}
	}else if($arrFaceting['Gothram']==1 && $varGothramTxt == 'yes' && strlen(trim($varGothram)) >= 3){
		$gothramQuery.=" @GothramText '*".$varGothram."*' ";
		$isExtended = 1;
	}
	
	// SET Star
	if($varStar!='' && $arrFaceting["Star"]==1 && $arrOption['Star']==1 && !in_array(0, $arrStar)){
		$varExcludeCond = getExcludeCond('Star',$arrExludeFields);
		$s->SetFilter("Star",$arrStar,$varExcludeCond);
	}

	// SET Raasi
	if($varRaasi!=''  && $arrFaceting["Star"]==1 && $arrOption['Star']==1 && !in_array(0, $arrRaasi)){
		$varExcludeCond = getExcludeCond('Raasi',$arrExludeFields);
		$s->SetFilter("Raasi",$arrRaasi,$varExcludeCond);
	}
	
	// SET Manglik
	if($varManglik!=''  && $arrFaceting['Dosham']==1 && !in_array(0, $arrManglik)){
		/*if(count($arrManglik)==1 && $arrManglik[0]==2){
			$arrManglik	= array(2,0);
		}else if(count($arrManglik)==1 && $arrManglik[0]==99){
			$arrManglik	= array(0);
		}else if(count($arrManglik)>1 && in_array(2,$arrManglik)){
			if(in_array(99,$arrManglik)){
				$manglikKey = array_search(99, $arrManglik);
				$arrManglik[$manglikKey]=0;
			}else{ $arrManglik[]=0; }
		}else if(count($arrManglik)>1 && in_array(99,$arrManglik)){
			$manglikKey = array_search(99, $arrManglik);
			$arrManglik[$manglikKey]=0;
		}*/

		if(count($arrManglik)==1 && $arrManglik[0]==99){
			$arrManglik	= array(0);
		}else if(count($arrManglik)>1 && in_array(99,$arrManglik)){
			$manglikKey = array_search(99, $arrManglik);
			$arrManglik[$manglikKey]=0;
		}

		$varExcludeCond = getExcludeCond('Chevvai_Dosham',$arrExludeFields);
		$s->SetFilter("Chevvai_Dosham",$arrManglik,$varExcludeCond);
	}

	// SET Citizenship
	if($varCitizenship!='' && !in_array(0, $arrCitizenship)){
		$varExcludeCond = getExcludeCond('Citizenship',$arrExludeFields);
		$s->SetFilter("Citizenship",$arrCitizenship,$varExcludeCond);
	}

	// SET Complexion
	if($varComplexion!='' && !in_array(0, $arrComplexion)){
		$s->SetFilter("Complexion",$arrComplexion);
	}

	// SET Body type
	if($varBodyType!='' && !in_array(0, $arrBodyType)){
		$s->SetFilter("Body_Type",$arrBodyType);
	}

	// SET EatingHabits
	if($varEatingHabits!='' && !in_array(0, $arrEatingHabits)){
		if(count($arrEatingHabits)==1 && $arrEatingHabits[0]==99){
			$arrEatingHabits	= array(0);
		}else if(count($arrEatingHabits)>1 && in_array(99,$arrEatingHabits)){
			$eatingKey = array_search(99, $arrEatingHabits);
			$arrEatingHabits[$eatingKey]=0;
		}
		$s->SetFilter("Eating_Habits",$arrEatingHabits);
	}
	
	// SET Drinking
	if($varDrinking!='' && !in_array(0, $arrDrinking)){
		if(count($arrDrinking)==1 && $arrDrinking[0]==99){
			$arrDrinking	= array(0);
		}else if(count($arrDrinking)>1 && in_array(99,$arrDrinking)){
			$drinkingKey = array_search(99, $arrDrinking);
			$arrDrinking[$drinkingKey]=0;
		}
		$varExcludeCond = getExcludeCond('Drink',$arrExludeFields);
		$s->SetFilter("Drink",$arrDrinking,$varExcludeCond);
	}
	
	// SET Smoking
	if($varSmoking!='' && !in_array(0, $arrSmoking)){
		if(count($arrSmoking)==1 && $arrSmoking[0]==99){
			$arrSmoking	= array(0);
		}else if(count($arrSmoking)>1 && in_array(99,$arrSmoking)){
			$smokingKey = array_search(99, $arrSmoking);
			$arrSmoking[$smokingKey]=0;
		}
		$varExcludeCond = getExcludeCond('Smoke',$arrExludeFields);
		$s->SetFilter("Smoke",$arrSmoking,$varExcludeCond);
	}

	// SET Photo set status 
	if($varPhotoOpt>0){
		$s->SetFilter("Photo_Set_Status", array(1));
	}

	// SET Photo set status $varProtectPhotoOpt
	if($varProtectPhotoOpt>0){
		$s->SetFilter("Protect_Photo_Set_Status", array(0));
	}

	// SET Horoscope set status
	if($varHoroscopeOpt>0){
		$s->SetFilter("Horoscope_Available", array(1,3));
	}

	// SET Resident status
	if($varResidentStatus!='' && !in_array(0, $arrResidentStatus)){
		if(in_array(1,$arrResidentStatus)){
				$arrResidentStatus[] = 100;
		}
		$varExcludeCond = getExcludeCond('Resident_Status',$arrExludeFields);
		$s->SetFilter("Resident_Status2",$arrResidentStatus,$varExcludeCond);
	}

	// SET Education
	if($varEducation!='' && !in_array(0, $arrEducation)){
		$s->SetFilter("Education_Category",$arrEducation);
	}

	// SET Occupation
	if($varOccupation!='' && !in_array(0, $arrOccupation)){
		$varExcludeCond = getExcludeCond('Occupation',$arrExludeFields);
		$s->SetFilter("Occupation",$arrOccupation,$varExcludeCond);
	}

	// SET Employed_In
	if($varOccupationCat!='' && !in_array(0, $arrOccupationCat)){
		$s->SetFilter("Employed_In",$arrOccupationCat);
	}

	// SET Profile_Created_By
	if($varCreatedBy!='' && !in_array(0, $arrCreatedBy)){ 
		$s->SetFilter("Profile_Created_By",$arrCreatedBy);
	}

	// SET Country
	if($varCountry!='' && !in_array(0,$arrCountry)){
		$varExcludeCond = getExcludeCond('Country',$arrExludeFields);
		if((in_array(98, $arrCountry) || in_array(222, $arrCountry)) && count($arrResidingState) > 0){
			//need to work here
			$varCountryQuery = getCountryQuery($arrCountry,$arrResidingState,$arrResidingCity);
			$s->SetSelect ("*, ".$varCountryQuery." AS locationfilter");
			$s->SetFilter("locationfilter",array(1),$varExcludeCond);
		}else{
			$s->SetFilter("Country",$arrCountry,$varExcludeCond);
		}
	}

	// SET AnnualIncome INR
	if($varAnnualIncome!='' && $varAnnualIncome>0){ 
		if($varAnnualIncome == 0.49){
			$varAnnualIncome=1; $varAnnualIncome1='50000';
		}else if($varAnnualIncome == 101){
			$varAnnualIncome='10000000'; $varAnnualIncome1='4294967295';
		}else if($varAnnualIncome>=1 && $varAnnualIncome1<=101 && $varAnnualIncome1>$varAnnualIncome){
			$varAnnualIncome	= $varAnnualIncome*100000; 
			$varAnnualIncome1	= $varAnnualIncome1==101 ? 4294967295 : $varAnnualIncome1*100000;
		}
		
		if($varAnnualIncome>0 && $varAnnualIncome1>0 && $varAnnualIncome<=$varAnnualIncome1){
			$varExcludeCond = getExcludeCond('Annual_Income_INR',$arrExludeFields);
			$s->SetFilterRange("Annual_Income_INR",$varAnnualIncome,$varAnnualIncome1,$varExcludeCond);
		}
	}

	if($isExtended == 1){
		$varQuery = getQueriesConcat($subcasteQuery,$gothramQuery,$casteQuery);
		//$s->AddQuery($varQuery, $argSphinxIdxName);

		$s->SetMatchMode(SPH_MATCH_BOOLEAN);
		$s->setMaxQueryTime(10000);
	}else{
		$s->SetMatchMode(SPH_MATCH_FULLSCAN);
		$s->setMaxQueryTime(10000);
	}

	if($argPurpose==2) { // myhome recommended match purpose
		$s->SetSortMode(SPH_SORT_EXTENDED, "@random");
		$s->SetLimits(0,4);
	} else {
		// Limit end value while exceeding 1000 gets into issue.
		if($varStartRec+$varEndRec >= 999){
			$maxLimit = $varStartRec+$varEndRec+1;
			$s->SetLimits($varStartRec,$varEndRec,$maxLimit);
		}else{
			$s->SetLimits($varStartRec,$varEndRec);
		}
	}

	$s->AddQuery($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId." - BaseQuery");
	$varResult=$s->RunQueries();

	$searchderr=$s->GetLastError();
	if(trim($searchderr)<>''){		
		$file_content = "\n MatriId : ".$sessMatriId."IP : ".$varSphinx['IP']." PORT : ".$varSphinx['PORT']." SearchdErr : ".$searchderr." Time ".date("H:i:s:u")." Getting results : "; 
		$file_name = "/var/log/cbslog/sphinxlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."ms_sphinxprocesslog.txt";
		$fp = fopen($file_name,"a");
		@fwrite($fp, $file_content);
		fclose($fp);
		
		// Searchd returned error
		$arrSrchProfiles['err']=1;
		return $arrSrchProfiles;
	}

	$arrTotalResult = getParseValues($varResult);
	$varTotCount	= $arrTotalResult[0];
	$arrSrchProfiles['totalcnt'] = $varTotCount;

	if($argPurpose==1) {
		return $arrSrchProfiles;
	}
	if(!empty($varResult[0]['matches']) && $argGroupbyField=='')
	{
		$arrResult = getParseValuesAsArray($varResult, array('profileindex', 'communityid', 'publish', 'paid_status', 'special_priv', 'gender', 'age', 'height', 'mother_tongueid', 'physical_status', 'religion', 'denomination', 'casteid', 'subcasteid', 'gothramid', 'star', 'raasi', 'chevvai_dosham', 'country', 'citizenship', 'eating_habits', 'smoke', 'drink', 'body_type', 'appearance', 'complexion', 'residing_state', 'residing_district', 'resident_status', 'education_category', 'education_subcategory', 'photo_set_status', 'horoscope_available', 'protect_photo_set_status', 'horoscope_protected', 'marital_status', 'phone_verified', 'last_login', 'occupation', 'no_of_children', 'caste_nobar', 'subcaste_nobar', 'partner_set_status','onlinestatus','date_created'),$argCommunityId);
		$arrSrchProfiles['ids']     = $arrResult;
	}
	
	if($argPurpose==2 || $argPurpose==3) {
		return $arrSrchProfiles;
	}

	// Faciting Part
	if($varTotCount > 0 && ($varStartRec==0 || $argGroupbyField!=''))
	{
		$argGroupbyField = ($argGroupbyField=='') ? "Faceting" : $argGroupbyField;
		$facetingArray = array();	//Declare array
		$facetNameArr = array();		
				
		include_once($varRootPath.'/sphinx/facetingsearch.php');
		
		if($argGroupbyField == "Faceting"){
			$facetResult = $s->RunQueries();
			$searchderr  =$s->GetLastError();
			$facetingCount = getCountValueFaceting($facetResult,$facetNameArr);
			
			//for Resident_Status
			$facetingCount["Resident_Status"][1] += $facetingCount["Resident_Status"][100];
			unset($facetingCount["Resident_Status"][100], $facetingCount["Resident_Status"][0]);
			arsort($facetingCount["Resident_Status"]);
			
			//for Employed in
			unset($facetingCount["Employed_In"][0], $facetingCount["Employed_In"][4], $facetingCount["Employed_In"][5]);

			$arrSrchProfiles['facet'] = array_merge($facetingCount, $facetingArray);
			$arrSrchProfiles['facet']['activetotal'][0]= $varTotCount;

			if(trim($searchderr)<>''){		
				$file_content = "\n MatriId : ".$sessMatriId."IP : ".$varSphinx['IP']." PORT : ".$varSphinx['PORT']." SearchdErr : ".$searchderr." Time ".date("H:i:s:u")." After faceting : "; 
				$file_name = "/var/log/cbslog/sphinxlog/".date('d-m-Y')."_".$_SERVER['SERVER_ADDR']."ms_sphinxprocesslog.txt";
				$fp = fopen($file_name,"a");
				@fwrite($fp, $file_content);
				fclose($fp);
				
				// Searchd returned error
				$arrSrchProfiles['err']=1;
				return $arrSrchProfiles;
			}
		}
		
	}
	return $arrSrchProfiles;
}
?>