<?
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 1);

include_once($varBaseRoot.'/lib/clsBasicviewCommon.php');
include_once($varBaseRoot.'/lib/clsCache.php');
include_once($varBaseRoot."/conf/sphinxgenericfunction.cil14");
include_once($varBaseRoot."/conf/vars.cil14");
include_once($varBaseRoot."/conf/cityarray.cil14");
include_once($varBaseRoot."/conf/domainlist.cil14");
include_once($varBaseRoot.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varBaseRoot.'/lib/clsDomain.php');
include_once($varBaseRoot.'/lib/clsCache.php');
include_once($varBaseRoot.'/lib/clsDB.php');

//Object Decleration
$objDomainInfo	= new domainInfo();
$objBasicComm	= new BasicviewCommon();
$objSrchBasicView = new DB();
$objMasterDB	= new DB();

$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender 	= $varGetCookieInfo["GENDER"];

//CONNECT DATABASE
$objSrchBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//getting old conditions
//SORT CONF ARRAYS
asort($arrEducationList);
asort($arrCountryList);
asort($arrTotalOccupationList);

//VARIABLE DECLARATION
$varCurrentDate		= date('Y-m-d H:i:s');
$varSrchOldWC		= trim($_POST["wc"]);
$varSrchFWC			= trim($_POST["fwc"]);
$varSrchfwcEnab		= trim($_POST["fwcEnab"]);
$varSrchNewWC		= trim($_POST["newval"]);
$varProfileType		= trim($_POST["profiletype"]);
$varViewType		= trim($_POST["viewtype"]);
$varViewAddedType	= trim($_REQUEST["vat"]);
$varDomainId		= $confValues['DOMAINCASTEID'];

if($_POST["wc"]==''){
include_once($varServerRoot."/matchsummary/getpartnerdtls.php");
}

include_once($varServerRoot.'/matchsummary/msummarytop.php');

$varMStAge	= $objDomainInfo->getMStartAge();
$varMEdAge	= $objDomainInfo->getMEndAge();
$varFMStAge	= $objDomainInfo->getFStartAge();
$varFMEdAge	= $objDomainInfo->getFEndAge();

$sessGender 	= $varGetCookieInfo["GENDER"];
if ($sessGender !=''){
	$partnerGender	= ($sessGender=='1') ? 2 : 1;
	
}

function getPartnerDetails($retArr) {
	global $varGetCookieInfo;
	$sessGender 	= $varGetCookieInfo["GENDER"];

	if ($sessGender !=''){
		$partnerGender	= ($sessGender=='1') ? 2 : 1;
	}

	//print_r($varGetCookieInfo);
	$varPartnerDetails	.= 'gender='.$partnerGender.'#^#';
	if ($varGetCookieInfo['PPAGE'] !=''){
		$varSplitAge = split('~',$varGetCookieInfo['PPAGE']);
		if($varSplitAge[0]!='' && $varSplitAge[0]!=0 && $varSplitAge[1]!='' && $varSplitAge[1]!=0) {
			$varPartnerDetails	.= 'ageFrom='.$varSplitAge[0].'#^#';
			$varPartnerDetails	.= 'ageTo='.$varSplitAge[1].'#^#';
		} else {
			if($sessGender==1){ 
				$varPartnerDetails	.= 'ageFrom=21#^#';
				$varPartnerDetails	.= 'ageTo=33#^#';
			}else{
				$varPartnerDetails	.= 'ageFrom=18#^#';
				$varPartnerDetails	.= 'ageTo=21#^#';
			}
		}
		$arrFetchingFields[]	= 'Age';
	}

	if ($varGetCookieInfo['PPHEIGHT'] !=''){
		$varSplitHeight = split('~',$varGetCookieInfo['PPHEIGHT']);
		if($varSplitHeight[0]!='' && $varSplitHeight[0]!=0.00 && $varSplitHeight[1]!='' && $varSplitHeight[1]!=0.00) {
		$varPartnerDetails	.= 'heightFrom='.$varSplitHeight[0].'#^#';
		$varPartnerDetails	.= 'heightTo='.$varSplitHeight[1].'#^#';
		} else {
			$varPartnerDetails	.= 'heightFrom=121.92#^#';
			$varPartnerDetails	.= 'heightTo=241.30#^#';
		}
		$arrFetchingFields[]	= 'Height';
	}

	if ($varGetCookieInfo['PPLOOKINGFOR'] !='' && $varGetCookieInfo['PPLOOKINGFOR'] !=0){
		$varPartnerDetails	.= 'maritalStatus='.$varGetCookieInfo['PPLOOKINGFOR'].'#^#';
		$arrFetchingFields[]	= 'Marital_Status';
	}

	if ($varGetCookieInfo['PPPHYSICALSTATUS'] !='' && $varGetCookieInfo['PPPHYSICALSTATUS'] !=0){
		$varPartnerDetails	.= 'physicalStatus='.$varGetCookieInfo['PPPHYSICALSTATUS'].'#^#';
		$arrFetchingFields[]	= 'Physical_Status';
	}

	if ($varGetCookieInfo['PPMOTHERTONGUE'] !='' && $varGetCookieInfo['PPMOTHERTONGUE'] !=0){
		$varPartnerDetails	.= 'motherTongue='.$varGetCookieInfo['PPMOTHERTONGUE'].'#^#';
		$arrFetchingFields[]	= 'Mother_Tongue';
	}

	if (sizeof($retArr['Religion'])>1 && $varGetCookieInfo['PPRELIGION'] !='' && $varGetCookieInfo['PPRELIGION'] !=0 && $varGetCookieInfo['PPINCLUDEOTHERRELIGION']==0){
		$varPartnerDetails	.= 'religion='.$varGetCookieInfo['PPRELIGION'].'#^#';
		$arrFetchingFields[]	= 'Religion';
	}

	if ($varGetCookieInfo['PPCASTE'] !='' && $varGetCookieInfo['PPCASTE'] !=0){
		$varPartnerDetails	.= 'caste='.$varGetCookieInfo['PPCASTE'].'#^#';
		$arrFetchingFields[]	= 'Caste';
	}

	if ($varGetCookieInfo['PPEATHABITS'] !='' && $varGetCookieInfo['PPEATHABITS'] !=0){
		$varPartnerDetails	.= 'eating='.$varGetCookieInfo['PPEATHABITS'].'#^#';
		$arrFetchingFields[]	= 'Eating_Habits';
	}

	if ($varGetCookieInfo['PPEDUCATION'] !='' && $varGetCookieInfo['PPEDUCATION'] !=0){
		$varPartnerDetails	.= 'education='.$varGetCookieInfo['PPEDUCATION'].'#^#';
		$arrFetchingFields[]	= 'Education';
	}

	if ($varGetCookieInfo['PPCITIZENSHIP'] !='' && $varGetCookieInfo['PPCITIZENSHIP'] !=0){
		$varPartnerDetails	.= 'citizenship='.$varGetCookieInfo['PPCITIZENSHIP'].'#^#';
		$arrFetchingFields[]	= 'Citizenship';
	}

	if ($varGetCookieInfo['PPCOUNTRY'] !='' && $varGetCookieInfo['PPCOUNTRY'] !=0){
		$varPartnerDetails	.= 'country='.$varGetCookieInfo['PPCOUNTRY'].'#^#';
		$arrFetchingFields[]	= 'Country';
	}

	if ($varGetCookieInfo['PPINDIASTATE'] !='' && $varGetCookieInfo['PPINDIASTATE'] !=0 && $varGetCookieInfo['PPUSASTATE'] !='' && $varGetCookieInfo['PPUSASTATE'] !=0){
		$varPartnerDetails	.= 'residingState='.$varGetCookieInfo['PPINDIASTATE'].'~'.$varGetCookieInfo['PPUSASTATE'].'#^#';
		$arrFetchingFields[]	= 'Resident_India_State';
		$arrFetchingFields[]	= 'Resident_USA_State';
	} else if ($varGetCookieInfo['PPINDIASTATE'] !='' && $varGetCookieInfo['PPINDIASTATE'] !=0){
		$varPartnerDetails	.= 'residingState='.$varGetCookieInfo['PPINDIASTATE'].'#^#';
		$arrFetchingFields[]	= 'Resident_India_State';
	} else if ($varGetCookieInfo['PPUSASTATE'] !='' && $varGetCookieInfo['PPUSASTATE'] !=0){
		$varPartnerDetails	.= 'residingState='.$varGetCookieInfo['PPUSASTATE'].'#^#';
		$arrFetchingFields[]	= 'Resident_USA_State';
	}

	if ($varGetCookieInfo['PPRESIDENTSTATUS'] !='' && $varGetCookieInfo['PPRESIDENTSTATUS'] !=0){
		$varPartnerDetails	.= 'residentStatus='.$varGetCookieInfo['PPRESIDENTSTATUS'].'#^#';
		$arrFetchingFields[]	= 'Resident_Status';
	}

	if ($varGetCookieInfo['PPSMOKEHABITS'] !='' && $varGetCookieInfo['PPSMOKEHABITS'] !=0){
		$varPartnerDetails	.= 'smoking='.$varGetCookieInfo['PPSMOKEHABITS'].'#^#';
		$arrFetchingFields[]	= 'Smoke';
	}

	if ($varGetCookieInfo['PPDRINKHABITS'] !='' && $varGetCookieInfo['PPDRINKHABITS'] !=0){
		$varPartnerDetails	.= 'drinking='.$varGetCookieInfo['PPDRINKHABITS'].'#^#';
		$arrFetchingFields[]	= 'Drink';
	}

	if ($varGetCookieInfo['PPSUBCASTE'] !='' && $varGetCookieInfo['PPSUBCASTE'] !=0){
		$varPartnerDetails	.= 'subcaste='.$varGetCookieInfo['PPSUBCASTE'].'#^#';
		$arrFetchingFields[]	= 'Subcaste';
	}

	if ($varGetCookieInfo['PPDENOMINATION'] !='' && $varGetCookieInfo['PPDENOMINATION'] !=0){
		$varPartnerDetails	.= 'denomination='.$varGetCookieInfo['PPDENOMINATION'].'#^#';
		$arrFetchingFields[]	= 'Denomination';
	}

	if ($varGetCookieInfo['PPHAVECHILDREN'] !='' && $varGetCookieInfo['PPHAVECHILDREN'] !=0){
		$varPartnerDetails	.= 'haveChildren='.$varGetCookieInfo['PPHAVECHILDREN'].'#^#';
		$arrFetchingFields[]	= 'Children_Living_Status';
	}

	if ($varGetCookieInfo['PPEMPLOYEDIN'] !='' && $varGetCookieInfo['PPEMPLOYEDIN'] !=0){
		$varPartnerDetails	.= 'occupationCat='.$varGetCookieInfo['PPEMPLOYEDIN'].'#^#';
		$arrFetchingFields[]	= 'Employed_In';
	}

	if ($varGetCookieInfo['PPOCCUPATION'] !='' && $varGetCookieInfo['PPOCCUPATION'] !=0){
		$varPartnerDetails	.= 'occupation='.$varGetCookieInfo['PPOCCUPATION'].'#^#';
		$arrFetchingFields[]	= 'Occupation';
	}

	if ($varGetCookieInfo['PPGOTHRAMID'] !='' && $varGetCookieInfo['PPGOTHRAMID'] !=0){
		$varPartnerDetails	.= 'gothram='.$varGetCookieInfo['PPGOTHRAMID'].'#^#';
		$arrFetchingFields[]	= 'Gothram';
	}

	if ($varGetCookieInfo['PPSTAR'] !='' && $varGetCookieInfo['PPSTAR'] !=0){
		$varPartnerDetails	.= 'star='.$varGetCookieInfo['PPSTAR'].'#^#';
		$arrFetchingFields[]	= 'Star';
	}

	if ($varGetCookieInfo['PPRAASI'] !='' && $varGetCookieInfo['PPRAASI'] !=0){
		$varPartnerDetails	.= 'raasi='.$varGetCookieInfo['PPRAASI'].'#^#';
		$arrFetchingFields[]	= 'Raasi';
	}

	if ($varGetCookieInfo['PPCHEVVAIDOSHAM'] !='' && $varGetCookieInfo['PPCHEVVAIDOSHAM'] !=0){
		$varPartnerDetails	.= 'manglik='.$varGetCookieInfo['PPCHEVVAIDOSHAM'].'#^#';
		$arrFetchingFields[]	= 'Chevvai_Dosham';
	}

	if ($varGetCookieInfo['PPRESIDENTDISTRICT'] !='' && $varGetCookieInfo['PPRESIDENTDISTRICT'] !=0){
		$arrDitrict	= split('~', trim($varGetCookieInfo['PPRESIDENTDISTRICT'],'~'));
		foreach($arrDitrict as $k=>$v) {
			$varstatecityval	= $arrCityStateMapping[$v].'#'.$v.'~';
		}
		$varPartnerDetails	.= 'residingCity='.trim($varstatecityval,'~').'#^#';
		$arrFetchingFields[]	= 'Resident_District';
	}

	/*if ($varGetCookieInfo['PPINCLUDEOTHERRELIGION'] !='' && $varGetCookieInfo['PPINCLUDEOTHERRELIGION'] !=0){
		$varPartnerDetails	.= 'incle='.$varGetCookieInfo['PPINCLUDEOTHERRELIGION'].'#^#';
	}*/

	if ($varGetCookieInfo['PPSTINCOME'] !='' && $varGetCookieInfo['PPSTINCOME'] !=0){
		$varPartnerDetails	.= 'annualIncome='.$varGetCookieInfo['PPSTINCOME'].'#^#';
		$arrFetchingFields[]	= 'Annual_Income_INR';
	}

	if ($varGetCookieInfo['PPENDINCOME'] !='' && $varGetCookieInfo['PPENDINCOME'] !=0){
		$varPartnerDetails	.= 'annualIncome1='.$varGetCookieInfo['PPENDINCOME'].'#^#';
		$arrFetchingFields[]	= 'Annual_Income_INR';
	}
	$arrReturnFetchingFields[0]	= $varPartnerDetails;
	$arrReturnFetchingFields[1]	= $arrFetchingFields;

	return $arrReturnFetchingFields;
}

if($_POST["wc"]=='' && $varSrchfwcEnab == 0) {
	$_POST["excludefields"]	= '';
	$varProfileType	= $_REQUEST['req'];
	$varViewType	= $_REQUEST['viewtype'];
	if ($sessGender !=''){
		$partnerGender	= ($sessGender=='1') ? 2 : 1;
		
	}

	$retFea['Religion']		= $objDomainInfo->useReligion();
	$retFea['Denomination']	= $objDomainInfo->useDenomination();
	$retFea['Caste']		= $objDomainInfo->useCaste();
	$retFea['Subcaste']		= $objDomainInfo->useSubcaste();
	$retFea['Star']			= $objDomainInfo->useStar();
	$retFea['MaritalStatus']= $objDomainInfo->useMaritalStatus();
	$retFea['Gothram']		= $objDomainInfo->useGothram();
	$retFea['Dosham']		= $objDomainInfo->useDosham();

	$retArr['Religion']		= array();
	$retArr['Denomination']	= array();
	$retArr['Caste']		= array();
	$retArr['Subcaste']		= array();
	$retArr['Star']			= array();
	$retArr['MaritalStatus']= array();
	$retArr['Gothram']		= array();
	$retArr['Dosham']		= array();

	if($retFea['Religion'])
		$retArr['Religion']		= $objDomainInfo->getReligionOption();
	if($retFea['Denomination'])
		$retArr['Denomination'] = $objDomainInfo->getDenominationOption();
	if($retFea['Caste'])
		$retArr['Caste']		= $objDomainInfo->getCasteOption();
	if($retFea['Subcaste'])
		$retArr['Subcaste']		= $objDomainInfo->getSubcasteOption();
	if($retFea['Star'])
		$retArr['Star']			= $objDomainInfo->getStarOption();
	if($retFea['MaritalStatus'])
		$retArr['MaritalStatus']= $objDomainInfo->getMaritalStatusOption();
	if($retFea['Gothram'])
		$retArr['Gothram']		= $objDomainInfo->getGothramOption();
	if($retFea['Dosham'])
		$retArr['Dosham']		= $objDomainInfo->getDoshamOption();

	

	$arrMatchwatchExludeFields	= array(0=>'Smoke',1=>'Drink',2=>'Children_Living_Status',3=>'Occupation',4=>'Star',5=>'Raasi');

	$arrRecommendedExcludeFields= array(0=>'Smoke',1=>'Drink',2=>'Children_Living_Status',3=>'Occupation',4=>'Star',5=>'Raasi',6=>'Chevvai_Dosham',7=>'Citizenship', 8=>'Country', 9=>'Resident_India_State', 10=>'Resident_USA_State', 11=>'Resident_District', 12=>'Resident_Status', 13=>'Annual_Income_INR');

	$arrPartnerDetail	= getPartnerDetails($retArr);
	$varPartnerDetails	= $arrPartnerDetail[0];
	$varCondition['LIMIT']	= $objBasicComm->encryptData($varPartnerDetails);
	$arrTotalFields		= $arrPartnerDetail[1];

	$arrExludeFields	= array();
	if($varProfileType==1) {
		if($varGetCookieInfo['PARTNERSTATUS']==0) {
			$varPreferedCount	= 0;
		} else {
			$arrExludeFields	= array();
		}
	} else if($varProfileType==3) {

		if($varGetCookieInfo['PARTNERSTATUS']==1) {
			$arrReturn1	= getExcludeFields($arrTotalFields,$arrMatchwatchExludeFields);

			if(count($arrReturn1)==0) {
					$varMatchwatchCount = 0;
			} else {
				$arrExludeFields	= $arrReturn1;
			}

		} else {
			$arrExludeFields	= array();
		}
		
	} else if($varProfileType==2) {

		if($varGetCookieInfo['PARTNERSTATUS']==1) {
			$arrReturn1	= getExcludeFields($arrTotalFields,$arrMatchwatchExludeFields);
			$arrReturn2	= getExcludeFields($arrTotalFields,$arrRecommendedExcludeFields);

			if(count($arrReturn1)==0 && count($arrReturn2)==0) {
				$varRecommendedCount = 0;
			} else {
				$arrResult = array_diff($arrReturn2, $arrReturn1);
				if(count($arrResult)==0) {
					$varRecommendedCount = 0;
				} else {
					$arrExludeFields	= $arrResult;
				}
			}

		} else {
			$arrReturn1	= getExcludeFields($arrTotalFields,$arrRecommendedExcludeFields);

			if(count($arrReturn1)==0) {
					$varRecommendedCount = 0;
			} else {
				$arrExludeFields	= $arrReturn1;
			}
		}
	}

	$varExludeFields	= '';
	if(sizeof($arrExludeFields)>0) {
		$varExludeFields	= implode("|",$arrExludeFields);
	}
} else {
	$varExludeFields	= trim($_POST["excludefields"]);
	$varDomainName	= $confValues['DOMAINNAME'];
	$varErrorMsg	= "";
	$varContIds		= "";

	if($_POST['gender'] == 1 || $sessGender==2){
	$varOppGen	= 1;
	$varMaleChk = 'checked';
	$varStAge	= $varMStAge;
	$varEdAge	= $varMEdAge;
	}else{
	$varFemaleChk= 'checked';
	$varOppGen	= 2;
	$varStAge	= $varFMStAge;
	$varEdAge	= $varFMEdAge;
	}

	//Gender based occupation changes for Defence matrimony
	if($varDomainId == 2006){
		asort($arrMaleDefenceOccupationList);
		asort($arrFemaleDefenceOccupationList);
		$arrTotalOccupationList = $varOppGen==2 ? $arrFemaleDefenceOccupationList : ($varOppGen==1 ? $arrMaleDefenceOccupationList : $arrFemaleDefenceOccupationList);
	}

	//Unset lastlogin cookie
	setcookie('lltimestamp', '', time()-3600, '/');


	if($varSrchOldWC!='' && $varSrchNewWC!=''){
		$varSrchOldWC = $objBasicComm->decryptData($varSrchOldWC);
		$arrOldValues = $objBasicComm->getTempPostValues($varSrchOldWC);
		$arrMoreVals    = split('#\^#', $varSrchNewWC);
		foreach($arrMoreVals as $varSinMoreVal){
			if($varSinMoreVal!='' && preg_match("/=/", $varSinMoreVal)){
			$arrNewVal	= split('=', $varSinMoreVal);
			$arrOldValues[$arrNewVal[0]] = trim($arrNewVal[1], '~');

			if($arrNewVal[0]=='country'){
				if($arrOldValues['residingState']!='' || $arrOldValues['residingCity']!=''){
					unset($arrOldValues['residingState']); unset($arrOldValues['residingCity']);
				}
			}else if($arrNewVal[0]=='residingState'){
				//Check India or US State
				$arrFaceStates = split('~', $arrNewVal[1]);
				$varINDEnal = 0;
				$varUSAEnal = 0;
				
				foreach($arrFaceStates as $sinFaceState){
					if($sinFaceState>100){$varUSAEnal = 1;}else{$varINDEnal = 1;}
				}
				
				if($varINDEnal==1 || $varUSAEnal==1){
					if($varINDEnal==1){$arrOldCountries[]=98;}
					if($varUSAEnal==1){$arrOldCountries[]=222;}
					$varModifiedCtry = join('~', $arrOldCountries);
					$arrOldValues['country'] = $varModifiedCtry;
				}else{
					$arrOldValues['country'] = '';
				}

				if($arrOldValues['residingCity']!=''){
					unset($arrOldValues['residingCity']);
				}
			}else if($arrNewVal[0]=='residingCity'){
				//Check India or US State
				$arrFaceCities = split('~', $arrNewVal[1]);
				$varINDEnal = 0;
				$varUSAEnal = 0;
				
				$arrStateDet = array();
				foreach($arrFaceCities as $sinFaceState){
					$arrCityDet = split('#', $sinFaceState);
					$arrStateDet[$arrCityDet[0]]='';
				}
				$arrSelectedStates = array_keys($arrStateDet);
				
				if(count($arrSelectedStates)>0){
					$arrOldValues['residingState'] = join('~', $arrSelectedStates);
					$arrOldValues['country'] = '98';
				}
			}
			}
			$varFaceAdded = 1;
		}
		$varResponse = '';
		foreach($arrOldValues as $key=>$val){

			$varResponse .= $key.'='.$val.'#^#';
		}
		$varResponse = trim($varResponse, '#^#');
		$varCondition['LIMIT']	= $objBasicComm->encryptData($varResponse);
	}else if($varSrchfwcEnab == 1){
		$varSrchOldWC=='';
		$varCondition['LIMIT']	= $varSrchFWC;
	}
	
}

$varFirstWC	= ($varSrchOldWC=='') ? $varCondition['LIMIT'] : $_POST["fwc"];

?>
<script>
	var imgs_url= '<?=$confValues["IMGSURL"]?>',MStAge=<?=$varMStAge;?>, MEdAge=<?=$varMEdAge;?>, FMStAge=<?=$varFMStAge;?>, FMEdAge=<?=$varFMEdAge;?>, selGender=<?=($_POST['gender']!='')? $_POST['gender'] : $varOppGen;?>;
	var rspgcnt = 'search';
</script>
<div class="rpanel fleft">
	
	<form name='frmSearchConds' method="post" action="" style="margin:0px;padding:0px;">
		<input type="hidden" name="htype_search" Value="<?=$_REQUEST['htype_search']?>">
		<input type="hidden" name="wc" value="<?=$varCondition['LIMIT'];?>">
		<input type="hidden" name="fwc" Value="<?=$varFirstWC;?>">
		<input type="hidden" name="fwcEnab" Value="0">
		<input type="hidden" name="faceAdded" Value="<?=$varFaceAdded;?>">
		<input type="hidden" name="profiletype" value="<?=$varProfileType;?>">
		<input type="hidden" name="viewtype" value="<?=$varViewType;?>">
		<input type="hidden" name="excludefields" value="<?=$varExludeFields;?>">
		<input type="hidden" name="newval" Value="">
		<input type="hidden" name="casteTxt" Value="<?=$_POST['casteTxt'];?>">
		<input type="hidden" name="subcasteTxt" Value="<?=$_POST['subcasteTxt'];?>">
		<input type="hidden" name="gothramTxt" Value="<?=$_POST['gothramTxt'];?>">
		<input type="hidden" name="vat" Value="<?=$varViewAddedType?>">
		<input type="hidden" name="disppgval" Value="2">
		<input type="hidden" name="act" Value="msummaryshowall">
	</form>


    <div class="padt10">
		<div id='search_div'>
		<form name="buttonfrm" method="post" target="_blank" style="margin:0px;">
		<div id="srinnertopbt">
			<div id="total_div" class="fleft bld myclr fntsize padtb10"></div>
			<div id="prevnext" class="padtb10 fright" style="width:200px;"></div><br clear="all">
		</div>
		<?
			if($varDomainId==2503 || $varDomainId==2500){
			$topvalue='top:285px !important;top:282px;';
			}else if($varDomainId==2006){
			$topvalue='top:266px !important;top:265px;';
			}else {
			$topvalue='top:285px !important;top:282px;';
			}
		?>

		<div id="contalldiv" class="disnon brdr1 tlleft pad10 posabs bgclr2" style="width:540px !important;width:560px;left:220px;<?=$topvalue?>">
			<div class="fright tlright"><img onclick="hidediv('contalldiv');stylechange(1);" class="pntr" src="<?=$confValues['IMGSURL']?>/close.gif"/></div><br clear="all">
			<?include_once($varRootBasePath.'/www/search/contactall.php');?>
		</div>

		<div id="serResArea" style="border-bottom:1px solid #cbcbcb;">
		<? if($objSearch->clsSearchErr == 0){ ?>
		<img src='<?=$confValues['IMGSURL']?>/trans.gif' width="1" height="1" onload="getMatchResult('1');">
		<?}else{ echo '<font class="smalltxt">'.$varResponse.'</font><BR><BR>';}?>
	    </div>
		</form><br clear="all" />
		<div id="prevnext1" class="padtb10"></div>
		</div>
	</div>
	</div><br clear="all" />
</div>
<?
unset($objMasterDB);
?>