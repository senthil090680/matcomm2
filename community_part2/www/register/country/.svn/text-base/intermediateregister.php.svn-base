<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-18
# End Date		: 2008-07-18
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsSearch.php');
include_once($varRootBasePath.'/conf/cityarray.inc');
include_once($varRootBasePath.'/www/search/srchcommonfuns.php');

//OBJECT DECLARTION
$objRegister	= new clsRegister;
$objCommon		= new clsCommon;
$objDomainInfo	= new domainInfo;
$objSearch	    = new Search;

$varUseReligion			= $objDomainInfo->useReligion();
$varUseDenomination		= $objDomainInfo->useDenomination();
$varUseCaste			= $objDomainInfo->useCaste();
$varUseSubcaste			= $objDomainInfo->useSubcaste();
$varIsCasteMandatory	= $objDomainInfo->isCasteMandatory();
$varIsSubcasteMandatory	= $objDomainInfo->isSubcasteMandatory();
$varUseMotherTongue		= $objDomainInfo->useMotherTongue();
$varMaleStartAge		= $objDomainInfo->getMStartAge();
$varFemaleStartAge		= $objDomainInfo->getFStartAge();
$varUseMaritalStatus	= $objDomainInfo->useMaritalStatus();
//$varUseRaasi			= $objDomainInfo->useRaasi();
$varUseHoroscope		= $objDomainInfo->useHoroscope();
$varUseDosham			= $objDomainInfo->useDosham();
$varUserGothram			= $objDomainInfo->useGothram();
$varUserGothramOption	= $objDomainInfo->getGothramOption();
$arrRetMaritalStatus	= $objDomainInfo->getMaritalStatusOption();
$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);

//CONNECT DATABASE
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);

//FOR INTER MEDIATE PAGE
$varCategory	= $_REQUEST['category'];
$varReqTemplate	= $_REQUEST['req'];
$varOppId		= $_REQUEST['oppositeId'];


//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPPAge		= $varGetCookieInfo['PPAGE'];
$sessPPHeight	= $varGetCookieInfo['PPHEIGHT'];
$sessGender     = $varGetCookieInfo['GENDER'];
if($sessGender == 1) {
  $varPartnerStartAge = $varFemaleStartAge;
}
else {
  $varPartnerStartAge = $varMaleStartAge;
}
$varPartnerAge				= split('~', $sessPPAge);
$varPartnerHt				= split('~', $sessPPHeight);
$varPartnerLookingStatus	= $varGetCookieInfo['PPLOOKINGFOR'];
$varPhysicalStatus	        = $varGetCookieInfo['PPPHYSICALSTATUS'];
$varPartnerMotherTongue		= $varGetCookieInfo['PPMOTHERTONGUE'];
$varPartnerReligion			= $varGetCookieInfo['PPRELIGION'];
$varPartnerDenomination		= $varGetCookieInfo['PPDENOMINATION'];
$varPartnerCaste			= $varGetCookieInfo['PPCASTE'];
$varPartnerSubcaste			= $varGetCookieInfo['PPSUBCASTE'];
$varPartnerCountry			= $varGetCookieInfo['PPCOUNTRY'];
$varPartnerFoodChoice		= $varGetCookieInfo['PPEATHABITS'];
$varEducation				= $varGetCookieInfo['PPEDUCATION'];
$varPartnerCitizenshipId    = $varGetCookieInfo['PPCITIZENSHIP'];
$varCommunityId             = $confValues['DOMAINCASTEID'];




//echo "<pre>";
//print_r($varGetCookieInfo);
$varCurrentDate	= date('Y-m-d H:i:s');
$varWeightUnit	= 'kg';
$varChkformAvail= 0;
$varTabIndex = 1;

if ($_POST['intRegister']=='yes') {
	//UPDATE
	$varCondition	= " MatriId='".$sessMatriId."'";
	$varFields = array('Weight','Weight_Unit','Body_Type','Complexion','Blood_Group','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Eating_Habits','Smoke','Drink');
	$varFieldsValues = array("'".$_REQUEST['weightKgs']."'","'".$varWeightUnit."'","'".$_REQUEST['bodyType']."'","'".$_REQUEST['complexion']."'","'".$_REQUEST['bloodGroup']."'","0","'".$_REQUEST['horoscopeMatch']."'","'".$_REQUEST['chevvaiDosham']."'","'".addslashes(strip_tags(trim($_REQUEST['educationDetail'])))."'","'".addslashes(strip_tags(trim($_REQUEST['occupationDetail'])))."'","'".$_REQUEST['eatingHabits']."'","'".$_REQUEST['smokingHabits']."'","'".$_REQUEST['drinkingHabits']."'");

	$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

	$varFields = array('Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family','Date_Updated');

	$varFieldsValues = array("'".addslashes(strip_tags(trim($_REQUEST['fatherOccupation'])))."'","'".addslashes(strip_tags(trim($_REQUEST['motherOccupation'])))."'","'".addslashes(strip_tags(trim($_REQUEST['familyOrgin'])))."'","'".$_REQUEST['numOfBrothers']."'","'".$_REQUEST['brothersMarried']."'","'".$_REQUEST['numOfSisters']."'","'".$_REQUEST['sistersMarried']."'","'".addslashes(strip_tags(trim($_REQUEST['aboutFamily'])))."'","'".$varCurrentDate."'");

	$objRegister->update($varTable['MEMBERFAMILYINFO'],$varFields,$varFieldsValues,$varCondition);

	//PARTNER DETAILS
	$varFromAge			= $_REQUEST['fromAge'];
	$varToAge					= $_REQUEST['toAge'];
	if($_REQUEST['FROMINCOME']!="0"){
	$varStIncome				= $_REQUEST['FROMINCOME'];
	}else if($_REQUEST['FROMUSCOME']!="0"){
		$varStIncome			= $_REQUEST['FROMUSCOME'];
	}
	if($_REQUEST['TOINCOME']!="0"){
	$varEndIncome				= $_REQUEST['TOINCOME'];
	}elseif($_REQUEST['TOUSCOME']!="0"){
		$varEndIncome			= $_REQUEST['TOUSCOME'];
	}
	$varHeightFrom				= $_REQUEST['heightFrom'];
	$varHeightTo				= $_REQUEST['heightTo'];
	$varPartnerLookingStatus	= ($_REQUEST['lookingStatus']!='')?join('~',$_REQUEST['lookingStatus']):'';
	$varPartnerHavechild		= $_REQUEST['partnerHavechild'];
	$varPartnerMotherTongue		= ($_REQUEST['motherTongue']!='')?join('~',$_REQUEST['motherTongue']):'';
	$varPartnerReligion			= ($_REQUEST['partnerReligion']!='')?join('~',$_REQUEST['partnerReligion']):'';
	$varPartnerDenomination	    = ($_REQUEST['partnerDenomination']!='')?join('~',$_REQUEST['partnerDenomination']):'';
	$varCheckCaste				= $_REQUEST['checkCaste'];
	$varPartnerCaste			= ($_REQUEST['partnerCaste']!='')?join('~',$_REQUEST['partnerCaste']):'';
	$varPartnerSubcaste			= ($_REQUEST['partnerSubcaste']!='')?join('~',$_REQUEST['partnerSubcaste']):'';
	$varPartnerStar				= ($_REQUEST['partnerStar']!='')?join('~',$_REQUEST['partnerStar']):'';
	$varPartnerCitizenShip		= ($_REQUEST['citizenship']!='')?join('~',$_REQUEST['citizenship']):'';
	$varPartnerCountry			= ($_REQUEST['countryLivingIn']!='')?join('~',$_REQUEST['countryLivingIn']):'';
	$varResidingIndia			= ($_REQUEST['residingIndia']!='')?join('~',$_REQUEST['residingIndia']):'';
	$varResidingCity			= ($_REQUEST['residingCity']!='')?join('~',$_REQUEST['residingCity']):'';
	$varResidingUSA				= ($_REQUEST['residingUSA']!='')?join('~',$_REQUEST['residingUSA']):'';
	$varResidingSrilanka		= ($_REQUEST['residingSrilanka']!='')?join('~',$_REQUEST['residingSrilanka']):''; //srilanka added
	$varResidingPakistan		= ($_REQUEST['residingPakistan']!='')?join('~',$_REQUEST['residingPakistan']):''; //Pakistan added
	$varResidingPakCity			= ($_REQUEST['pakistanCity']!='')?join('~',$_REQUEST['pakistanCity']):''; //pakistan city added
	$varPartnerDhosam			= ($_REQUEST['partnerDhosam']!='')?join('~',$_REQUEST['partnerDhosam']):'';
	//$varResidentStatus		= ($_REQUEST['residentStatus']!='')?join('~',$_REQUEST['residentStatus']):'';
	$varPartnerFoodChoice		= ($_REQUEST['partnerFoodChoice']!='')?join('~',$_REQUEST['partnerFoodChoice']):'';
	$varPartnerSmokeChoice	    = ($_REQUEST['partnerSmokeChoice']!='')?join('~',$_REQUEST['partnerSmokeChoice']):'';
	$varPartnerDrinkChoice	    = ($_REQUEST['partnerDrinkChoice']!='')?join('~',$_REQUEST['partnerDrinkChoice']):'';
	$varIncludeOtherReligion	= $_REQUEST['IncludeOtherReligion'];
	$varEducation				= ($_REQUEST['education']!='')?join('~',$_REQUEST['education']):'';
	$varOccupation				= ($_REQUEST['occupation']!='')?join('~',$_REQUEST['occupation']):'';
	$varPartnerDescription		= $_REQUEST['partnerDescription'];
    $varpartnerGothram			= ($_REQUEST['partnerGothram']!='')?join('~',$_REQUEST['partnerGothram']):'';

	$varFields		 = array('Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Mother_Tongue','Religion','Denomination','CasteId','SubcasteId','Star','Chevvai_Dosham','Eating_Habits','Drinking_Habits','Smoking_Habits','Education','Occupation','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_Srilanka_State','Resident_Pakistan_State','Resident_Pakistan_District','Resident_District','Resident_Status','IncludeOtherReligion','Date_Updated','StIncome','EndIncome','Partner_Description','GothramId');

	$varFieldsValues = array("'".$varFromAge."'","'".$varToAge."'","'".$varPartnerLookingStatus."'","'".$varPartnerHavechild."'","'".$varHeightFrom."'","'".$varHeightTo."'","'".$varPartnerMotherTongue."'","'".$varPartnerReligion."'","'".$varPartnerDenomination."'","'".$varPartnerCaste."'","'".$varPartnerSubcaste."'","'".$varPartnerStar."'","'".$varPartnerDhosam."'","'".$varPartnerFoodChoice."'","'".$varPartnerSmokeChoice."'","'".$varPartnerDrinkChoice."'","'".$varEducation."'","'".$varOccupation."'","'".$varPartnerCitizenShip."'","'".$varPartnerCountry."'","'".$varResidingIndia."'","'".$varResidingUSA."'","'".$varResidingSrilanka."'","'".$varResidingPakistan."'","'".$varResidingPakCity."'","'".$varResidingCity."'","0","'".$varIncludeOtherReligion."'","'".$varCurrentDate."'","'".$varStIncome."'","'".$varEndIncome."'",
	"'".addslashes(strip_tags(trim($varPartnerDescription)))."'","'".$varpartnerGothram."'");

	
	$objRegister->update($varTable['MEMBERPARTNERINFO'],$varFields,$varFieldsValues,$varCondition);
    
	$varFields 			= array('Partner_Set_Status');
	$varFieldsValues	= array(1);
	$varCondition		= "MatriId = '".$sessMatriId."'";
	$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

	// INSERT MEMBERHOBBIESINFO
	$varSpokenLanguages	= ($_REQUEST['spokenLanguages']!='')?join('~',$_REQUEST['spokenLanguages']):'';
	$varInterests		= ($_REQUEST['interests']!='')?join('~',$_REQUEST['interests']):'';
	$varHobbies			= ($_REQUEST['hobbies']!='')?join('~',$_REQUEST['hobbies']):'';
	$varFavourites		= ($_REQUEST['favourites']!='')?join('~',$_REQUEST['favourites']):'';
	$varSports			= ($_REQUEST['sports']!='')?join('~',$_REQUEST['sports']):'';
	$varFood			= ($_REQUEST['food']!='')?join('~',$_REQUEST['food']):'';

	if($varSpokenLanguages != '' || $varInterests != '' || $varHobbies != '' || $varFavourites != '' || $varSports != '' || $varFood != '') {
		$varFields			= array('MatriId','Hobbies_Selected','Interests_Selected','Music_Selected','Sports_Selected','Food_Selected','Languages_Selected','Date_Updated');
		$varFieldsValues	= array("'".$sessMatriId."'","'".$varHobbies."'","'".$varInterests."'","'".$varFavourites."'","'".$varSports."'","'".$varFood."'","'".$varSpokenLanguages."'",'NOW()');
		$objRegister->insertIgnore($varTable['MEMBERHOBBIESINFO'],$varFields,$varFieldsValues);

		$varFields 			= array('Interest_Set_Status');
		$varFieldsValues	= array(1);
		$varCondition		= "MatriId = '".$sessMatriId."'";
		$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
	}


	$varPartnerDetails	= $varFromAge.'~'.$varToAge.'^|'.$varHeightFrom.'~'.$varHeightTo.'^|'.$varPartnerLookingStatus.'^|'.$varPhysicalStatus.'^|'.$varPartnerMotherTongue.'^|'.$varPartnerReligion.'^|'.$varPartnerCaste.'^|'.$varPartnerFoodChoice.'^|'.$varEducation.'^|'.$varCitizenship.'^|'.$varPartnerCountry.'^|'.$varResidingIndia.'^|'.$varResidingUSA.'^|'.$varResidentStatus.'^|'.$varPartnerSmokeChoice.'^|'.$varPartnerDrinkChoice.'^|'.$varPartnerSubcaste.'^|'.$varPartnerDenomination.'^|'.$varPartnerHavechild.'^|0^|'.$varOccupation.'^|'.$varpartnerGothram.'^|'.$varPartnerStar.'^|0^|'.$varPartnerDhosam.'^|'.$varResidingCity.'^|'.$varIncludeOtherReligion.'^|'.$varStIncome.'^|'.$varEndIncome.'^|'.$varResidingSrilanka;
	setrawcookie("partnerInfo","$varPartnerDetails", "0", "/",$confValues['DOMAINNAME']);

	if($_REQUEST['weightKgs']!=0 && $_REQUEST['bodyType']!=0 && $_REQUEST['complexion']!=0 && $_REQUEST['bloodGroup']!=0 && $_REQUEST['spokenLanguages'][0]!='' && $_REQUEST['horoscopeMatch']!=0 && $_REQUEST['doshamOption']!=0 && $_REQUEST['chevvaiDosham']!=0 && $_REQUEST['educationDetail']!='' && $_REQUEST['occupationDetail']!='' && $_REQUEST['eatingHabits']!=0 && $_REQUEST['drinkingHabits']!=0 && $_REQUEST['smokingHabits']!=0 && $_REQUEST['interests'][0]!='' && $_REQUEST['hobbies'][0]!='' && $_REQUEST['favourites'][0]!=0 && $_REQUEST['sports'][0]!='' && $_REQUEST['food'][0]!='' &&  $_REQUEST['familyOrgin']!='' && $_REQUEST['motherOccupation']!='' &&  $_REQUEST['fatherOccupation']!='' && $_REQUEST['numOfBrothers']!=0 && $_REQUEST['brothersMarried']!=0 && $_REQUEST['numOfSisters']!=0 && $_REQUEST['sistersMarried']!=0 && $_REQUEST['aboutFamily']!='' && $_REQUEST['fromAge']!=0 && $_REQUEST['toAge']!=0 && $_REQUEST['heightFrom']!=0 && $_REQUEST['heightTo']!=0 && $_REQUEST['partnerDescription']!=''){ 
	    $varFields 			= array('Complete_Now');
		$varFieldsValues	= array(1);
		$varCondition		= "MatriId = '".$sessMatriId."'";
		$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);
    }

	header("Location: ".$confValues['SERVERURL'].'/profiledetail/');exit;

}

if($varCompleteNow == 1) {
	echo "<script>window.location='".$confValues['SERVERURL'].'/profiledetail/'."'</script>";
} else {
	//get gender
	$argCondition			= "WHERE MatriId='".$sessMatriId."'";
	$argFields 				= array('Gender');
	$varSelectGenderInfo	= $objRegister->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varSelectGenderInfoRes	= mysql_fetch_assoc($varSelectGenderInfo);
	?>
	<style>
	select.inputtext {width:215px;}
	select.srchselect {font-family:arial;font-size:11px;width:180px;}
	select.select1 {width:80px;}
	</style>
	<!--<script>var starmtage=<?=$varMaleStartAge?>,starfmtage=<?=$varFemaleStartAge?></script>-->
    <script>var partnerage=<?=$varPartnerStartAge?>,mstatuscnt=<?=$varSizeMaritalStatus?></script>

	<script language=javascript src="<?=$confValues["JSPATH"];?>/<?=$_IncludeFolder?>interregs.js"></script>
	<form name="frmRegister" method="POST" style="padding:0px;margin:0px;" onSubmit="return interValidate();">
	<input type="hidden" name="intRegister" value="yes">
	<input type="hidden" name="category" value="<?=$varCategory?>">
	<input type="hidden" name="req" value="<?=$varReqTemplate?>">
	<input type="hidden" name="oppositeId" value="<?=$varOppId?>">
	<?if($varFromPage==1){?>
		<!--<input type="hidden" name="useRaasi" value="<?=$varUseRaasi?>">Commented the raasi not to be present	-->
		<input type="hidden" name="useDosham" value="<?=$varUseDosham?>">
		<input type="hidden" name="useHoroscope" value="<?=$varUseHoroscope?>">
		<input type="hidden" name="useMotherTongue" value="<?=$varUseMotherTongue?>">
		<input type="hidden" name="useReligion" value="<?=$varUseReligion?>">
		<input type="hidden" name="useDenomination" value="<?=$varUseDenomination?>">
		<input type="hidden" name="useCaste" value="<?=$varUseCaste?>">
		<input type="hidden" name="useSubcaste" value="<?=$varUseSubcaste?>">
		<input type="hidden" name="oldEduDet" value="<?=$varEducationDetail?>">
		<input type="hidden" name="oldOccDet" value="<?=$varOccupationDetail?>">
		<input type="hidden" name="oldFatOcc" value="<?=$varFatherOccupation?>">
		<input type="hidden" name="oldMotOcc" value="<?=$varMotherOccupation?>">
		<input type="hidden" name="oldFamOri" value="<?=$varFamilyOrigin?>">
		<input type="hidden" name="OldAboutFamily" value="<?=$varAboutFamily?>">
	<?}?>
    <div style="width:560px !important;width:557px;">
	<div class="fleft">
	<div class="fleft clr bld padb5" style="font-size:17px;">Just a few more details and your profile will be just perfect.</div>
	<div class="fright normtxt tlright"><a href="/profiledetail/" class="clr1 bld">Skip this page</a></div>
	<br clear="all" />
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		<br clear="all" />
			<div class="padb10">
				<!--|| ($varUseRaasi==1 && $varRaasi==0) Removed this from raasi-->
				<?if($varWeightKgs==0 || $varBodyType==0 || $varComplexion==0 || $varLanguagesSelected==''  || ($varUseHoroscope==1 && $varHoroscopeMatch==0) || ($varUseDosham==1 && $varChevvaiDosham==0) || $varEducationDetail=='' || $varOccupationDetail=='' || $varEatingHabits==0 || $varSmokeHabits==0 || $varDrinkHabits==0 || $varInterestsSelected=='' || $varHobbiesSelected=='' || $varMusicSelected=='' || $varSportsSelected=='' || $varFoodSelected==''	) { $varChkformAvail=1;?>
				<div class="bld clr" style="font-size:17px;">More about you</div>
				<?}?>
				<?if($varWeightKgs==0) {?>
				<div class="srchdivlt normtxt bld fleft">Weight</div>
				<div class="srchdivrt normtxt fleft" id="stateList">
					<select name="weightKgs" tabindex="<?=$varTabIndex++?>" class="select1"><?=$objCommon->getValuesFromArray($arrWeightKgsList, "--Kgs--", "0", "");?></select><br><span id="weightspan" class="errortxt"></span>
				</div><br clear="all"/>
				<?}else{?>
					<input type="hidden" name="weightKgs" value="<?=$varWeightKgs?>">
				<?}?>

				<?if($varBodyType==0) {?>
				<div class="srchdivlt normtxt bld fleft">Body Type</div>
				<div class="srchdivrt normtxt fleft">
					<?=$objCommon->displayRadioOptions($arrBodyTypeList, "bodyType", $varBodyType, "normtxt",'',$varTabIndex++);?>
				<? $varTabIndex =  (count($arrBodyTypeList)+$varTabIndex-1); ?>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="bodyType" value="<?=$varBodyType?>">
				<?}?>

				<?if($varComplexion==0) {?>
				<div class="srchdivlt normtxt bld fleft">Complexion</div>
				<div class="srchdivrt normtxt fleft">
					<?=$objCommon->displayRadioOptions($arrComplexionList, "complexion", $varComplexion, "normtxt",'',$varTabIndex++);?>
				<? $varTabIndex =  (count($arrComplexionList)+$varTabIndex-1);?>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="complexion" value="<?=$varComplexion?>">
				<?}?>

				<?if($varLanguagesSelected=='') {?>
				<div class="srchdivlt normtxt bld fleft">Spoken Languages</div>
				<div class="srchdivrt normtxt fleft">
					<select class="inputtext" name="spokenLanguages[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrSpokenLangList, '--- Select Languages ---', '', '');?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="spokenLanguages[]" value="<?=$varLanguagesSelected?>">
				<?}?>

				<!-- commented <? if($varUseRaasi==1) {
					if($varRaasi==0) {?>
					<div class="srchdivlt normtxt bld fleft"><?=$objDomainInfo->getRaasiLabel()?></div>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="raasi" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($objDomainInfo->getRaasiOption(), "--- Select Raasi/Moon Sign ---", "0", $varRaasi);?></select>
					</div>
					<br clear="all"/>
					<?}else{?>
						<input type="hidden" name="raasi" value="<?=$varRaasi?>">
					<?}?>
				<? } ?>-->

				<?if($varUseHoroscope==1) {
					if($varHoroscopeMatch==0) {?>
					<div class="srchdivlt normtxt bld fleft">Want Horoscope Match?</div>
					<div class="srchdivrt normtxt fleft">
						<?=$objCommon->displayRadioOptions($objDomainInfo->getHoroscopeOption(), "horoscopeMatch", "Required", "normtxt",'',$varTabIndex++);?>
					</div>
					<? $varTabIndex =  (count($objDomainInfo->getHoroscopeOption())+$varTabIndex-1);?>
					<br clear="all"/>
					<?}else{?>
						<input type="hidden" name="horoscopeMatch" value="<?=$varHoroscopeMatch?>">
					<?}?>
				<? } ?>

				<?if($varUseDosham==1) {
					$arrDoshamOption	= $objDomainInfo->getDoshamOption();
					$varSizeDosham		= sizeof($arrDoshamOption);
					?>
					<input type="hidden" name="doshamOption" value="<?=$varSizeDosham?>">
					<? if($varSizeDosham==1) { ?>
					<input type="hidden" name="chevvaiDosham" value="<?=key($arrDoshamOption)?>">
					<?} else {
						if($varChevvaiDosham==0 && $varSizeDosham>1) {?>
						<div class="srchdivlt normtxt bld fleft"><?=$objDomainInfo->getDoshamLabel()?></div>
						<div class="srchdivrt normtxt fleft">
							<?=$objCommon->displayRadioOptions($arrDoshamOption, "chevvaiDosham", 'No', 'normtxt','','');?>
						</div>
						<br clear="all"/>
						<?}else{?>
							<input type="hidden" name="chevvaiDosham" value="<?=$varChevvaiDosham?>">
						<?}
					}?>
				<? } ?>

				<?if($varEducationDetail=='') {?>
				<div class="srchdivlt normtxt bld fleft">Education in Detail</div>
				<div class="srchdivrt normtxt fleft">
					<input type="text" name="educationDetail" size="37" class="inputtext" tabindex="<?=$varTabIndex++?>" value=""/>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="educationDetail" value="<?=$varEducationDetail?>">
				<?}?>


				<?if($varOccupationDetail=='') {?>
				<div class="srchdivlt normtxt bld fleft">Occupation in Detail</div>
				<div class="srchdivrt normtxt fleft">
					<input type="text" name="occupationDetail" size="37" class="inputtext" tabindex="<?=$varTabIndex++?>" value=""/>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="occupationDetail" value="<?=$varOccupationDetail?>">
				<?}?>

				<?if($varEatingHabits==0 || $varSmokeHabits==0 || $varDrinkHabits==0) {?>
					<div class="srchdivlt normtxt bld fleft">Habits</div>

					<?if($varEatingHabits==0){?>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="eatingHabits" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrEatingHabitsList, "--- Select Eating Habits ---", "0", "");?></select>
					</div>
					<br>
					<div class="srchdivlt normtxt bld fleft"></div>
					<?}else{?>
						<input type="hidden" name="eatingHabits" value="<?=$varEatingHabits?>">
					<?}?>

					<?if($varDrinkHabits==0){?>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="drinkingHabits" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrDrinkList, "--- Select Drinking Habits ---", "0", "");?></select>
					</div>
					<BR>
					<div class="srchdivlt normtxt bld fleft"></div>
					<?}else{?>
						<input type="hidden" name="drinkingHabits" value="<?=$varDrinkHabits?>">
					<?}?>

					<?if($varSmokeHabits==0){?>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="smokingHabits" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrSmokeList, "--- Select Smoking Habits ---", "0", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="smokingHabits" value="<?=$varSmokeHabits?>">
					<?}?>
					<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="eatingHabits" value="<?=$varEatingHabits?>">
					<input type="hidden" name="drinkingHabits" value="<?=$varDrinkHabits?>">
					<input type="hidden" name="smokingHabits" value="<?=$varSmokeHabits?>">
				<?}?>

				<?if($varInterestsSelected=='') {?>
				<div class="srchdivlt normtxt bld fleft">Interests</div>
				<div class="srchdivrt normtxt fleft">
					<select class="inputtext" name="interests[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrInterestList, "--- Select Interests ---", "", "");?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="interests[]" value="<?=$varInterestsSelected?>">
				<?}?>

				<?if($varHobbiesSelected=='') {?>
				<div class="srchdivlt normtxt bld fleft">Hobbies</div>
				<div class="srchdivrt normtxt fleft">
					<select class="inputtext" name="hobbies[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrHobbiesList, "--- Select Hobbies ---", "", "");?></select>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="hobbies[]" value="<?=$varHobbiesSelected?>">
				<?}?>

				<?if($varMusicSelected=='' || $varSportsSelected=='' || $varFoodSelected=='' ){?>
					<div class="srchdivlt normtxt bld fleft">Favourites</div>
					<?if($varMusicSelected=='') {?>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="favourites[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrMusicList, "--- Select Favourites Music ---", "", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="favourites[]" value="<?=$varMusicSelected?>">
					<?}?>

					<?if($varSportsSelected=='') {?>
					<br clear="all">
					<div class="srchdivlt normtxt bld fleft">&nbsp;</div>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="sports[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrSportsList, "--- Select Favourites Sports ---", "", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="sports[]" value="<?=$varSportsSelected?>">
					<?}?>

					<?if($varFoodSelected=='') {?>
					<br clear="all">
					<div class="srchdivlt normtxt bld fleft">&nbsp;</div>
					<div class="srchdivrt normtxt fleft">
						<select class="inputtext" name="food[]" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrFoodList, "--- Select Favourites Food ---", "", "");?></select>
					</div>
					<?}else{?>
						<input type="hidden" name="food[]" value="<?=$varFoodSelected?>">
					<?}?>
					<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="favourites[]" value="<?=$varMusicSelected?>">
					<input type="hidden" name="sports[]" value="<?=$varSportsSelected?>">
					<input type="hidden" name="food[]" value="<?=$varFoodSelected?>">
				<?}?>


				<?if($varFamilyOrigin=='' || $varMotherOccupation=='' || $varFatherOccupation=='' || ($varBrothers==0 && $varBrothersMarried==0) || ($varSisters==0 && $varSistersMarried==0) || $varAboutFamily=='') { $varChkformAvail=1;?>
				<div class="bld clr">More about your family</div>
				<?}?>
				<?if($varFamilyOrigin=='') {?>
				<div class="srchdivlt normtxt bld fleft">Ancestral Family Origin</div>
				<div class="srchdivrt normtxt fleft">
					<input type="text" name="familyOrgin" size="38" class="inputtext" tabindex="<?=$varTabIndex++?>"/>
					<br><span id="nicknamespan" class="errortxt clr1"></span>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="familyOrgin" value="<?=$varFamilyOrigin?>">
				<?}?>

				<?if($varMotherOccupation=='') {?>
				<div class="srchdivlt normtxt bld fleft">Mother's Occupation</div>
				<div class="srchdivrt normtxt fleft">
					<input type="inputtext" tabindex="<?=$varTabIndex++?>" name="motherOccupation" class="inputtext" size="38">
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="motherOccupation" value="<?=$varMotherOccupation?>">
				<?}?>

				<?if($varFatherOccupation=='') {?>
				<div class="srchdivlt normtxt bld fleft">Father's Occupation</div>
				<div class="srchdivrt normtxt fleft">
					<input type="inputtext" tabindex="<?=$varTabIndex++?>" name="fatherOccupation" class="inputtext" size="38">
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="fatherOccupation" value="<?=$varFatherOccupation?>">
				<?}?>

				<?if($varBrothers==0 && $varBrothersMarried==0) {?>
				<div class="srchdivlt normtxt bld fleft">No. of Brothers</div>
				<div class="srchdivrt normtxt fleft">
					<select name="numOfBrothers" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidateChk();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select No. of Brothers ---", "0", "");?></select>
				</div>
				<br clear="all"/>

				<div class="srchdivlt normtxt bld fleft">Brothers Married</div>
				<div class="srchdivrt normtxt fleft">
					<select name="brothersMarried" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidateChk();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select Brothers Married ---", "0", "");?></select><br><span id="marriedbrothersspan" class="errortxt clr1"></span>
				</div>
				<br clear="all"/>
				<input type="hidden" name="numOfBrothersChk" value="1">
				<?}else{?>
					<input type="hidden" name="numOfBrothers" value="<?=$varBrothers?>">
					<input type="hidden" name="brothersMarried" value="<?=$varBrothersMarried?>">
					
				<?}?>

				<?if($varSisters==0 && $varSistersMarried==0) {?>
				<div class="srchdivlt normtxt bld fleft">No. of Sisters</div>
				<div class="srchdivrt normtxt fleft">
					<select name="numOfSisters" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidateChk();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select No. of Sisters ---", "", "");?></select>
				</div>
				<br clear="all"/>

				<div class="srchdivlt normtxt bld fleft">Sisters Married</div>
				<div class="srchdivrt normtxt fleft">
					<select name="sistersMarried" size="1" tabindex="<?=$varTabIndex++?>" class="inputtext" onChange="interValidateChk();"><?=$objCommon->getValuesFromArray($arrNumSiblings, "--- Select Sisters Married ---", "", "");?></select><br><span id="marriedsistersspan" class="errortxt clr1"></span>
				</div>
				<br clear="all"/>
				<input type="hidden" name="numOfSistersChk" value="1">
				<?}else{?>
					<input type="hidden" name="numOfSisters" value="<?=$varSisters?>">
					<input type="hidden" name="sistersMarried" value="<?=$varSistersMarried?>">
					
				<?}?>

				<?if($varAboutFamily=='') {?>
				<div class="srchdivlt normtxt bld fleft">Few lines about your family</div>
				<div class="srchdivrt normtxt fleft">
					<textarea name="aboutFamily" rows="4" tabindex="<?=$varTabIndex++?>" class="srchselect"></textarea>
				</div>
				<br clear="all"/>
				<?}else{?>
					<input type="hidden" name="aboutFamily" value="<?=$varAboutFamily?>">
				<?}?>

				<?
				if($varUseCaste==1) {
					$arrGetCasteOption = $objDomainInfo->getCasteOption();
					$varSizeCaste	= sizeof($arrGetCasteOption);
					echo '<input type="hidden" name="castesize" value="'.$varSizeCaste.'">';
				}

				if($varUseSubcaste==1) {
					$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
					$varSizeSubcaste	= sizeof($arrGetSubcasteOption);
					echo '<input type="hidden" name="subcastesize" value="'.$varSizeSubcaste.'">';
				}
				?>
				
				<?php if($varPPStatus!=1){?>

                <div class="bld clr tlleft padb10">More about your partner<br clear="all"/><font class="normtxt notbld">The fields marked with a (<img src="http://img.communitymatrimony.com/images/prmok.jpg" />) will form your MatchWatch criteria. You will receive daily matches based on your MatchWatch criteria.</font></div>
                <div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Age</div>

				<div class="srchdivrt normtxt fleft">
					From: <input type="text" name="fromAge" size="2" tabindex="<?=$varTabIndex++?>" maxlength=2 class="inputtext" value="<?=$varPartnerAge[0]?>">
					To: <input type="text" name="toAge" size="2" tabindex="<?=$varTabIndex++?>" maxlength=2 class="inputtext" value="<?=$varPartnerAge[1]?>"><br><span id="stage" class="errortxt"></span>
				</div>
				<br clear="all"/>
				
				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Height</div>
				<div class="srchdivrt normtxt fleft">
					<select style="width:110px" class="select1" name="heightFrom" tabindex="<?=$varTabIndex++?>" size="1"><?=$objCommon->getValuesFromArray($arrHeightList, "", "",  $varPartnerHt[0]);?></select>&nbsp;<font class="mediumtxt"> &nbsp;to&nbsp; </font>
					<select style="width:110px" class="select1" name="heightTo" tabindex="<?=$varTabIndex++?>" size="1"><?=$objCommon->getValuesFromArray($arrHeightList, "", "", $varPartnerHt[1]);?></select><br><span id="stheight" class="errortxt"></span>
				</div><br clear="all"/>  

				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Physical Status</div>
				<div class="srchdivrt normtxt fleft" >
					<? $index=1; foreach($arrPhysicalStatusList as $key=>$value){
						$varChecked = ($key == $varPhysicalStatus)?'checked':'';
						if($index > 3) echo "<br>";
						echo '<input type="radio" name=physicalStatus value="'.$key.'"  id="physicalStatus'.$key.'" '.$varChecked.'><font class="normtxt" style="padding-right: 10px;">'.$value.'</font>';
					$index++;}?>
				</div><br clear="all"/>

				<? if($varUseMaritalStatus==1) {
					$arrRetMaritalStatus	= $objDomainInfo->getMaritalStatusOption();
                    if($varSelectGenderInfoRes['Gender'] == 1 && $confValues["DOMAINCASTEID"]==2503) {
		            unset($arrRetMaritalStatus[5]);
	                } else if($varSelectGenderInfoRes['Gender'] == 2 && $confValues["DOMAINCASTEID"]==2006) {
		            unset($arrRetMaritalStatus[6]);
	                }
					?>
					<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomainInfo->getMaritalStatusLabel()?></div>
					<div class="srchdivrt normtxt fleft"><div class="fleft">
					<div style="width:120px;" class="fleft"><input type="checkbox"  name="lookingStatus[]"  id="lookingStatus" value='0' onClick="(partnerHaveChildnp());maritalstany(1);"><font class='normtxt' style="padding-left:5px;">Any&nbsp;</font></div>
					<?php foreach($arrRetMaritalStatus as $key=>$value){
						$varChecked = ($key == $varPartnerLookingStatus)?'checked':'';
						echo '<div style="width:120px !important;width:120px;float:left"><input style="padding-right:10px;" type="checkbox" name="lookingStatus[]" value="'.$key.'"  id="lookingStatus" onClick="partnerHaveChildnp();maritalstany(2);" '.$varChecked.'><font class="normtxt" style="padding-left: 5px;">'.$value.'</font></div>';
					}?>
					</div>
					</div>
					<br clear="all"/>
				<? } ?>
				<div id="hchild" style="display:none;">
				<div class="srchdivlt normtxt bld fleft">Have Children</div>
				<div class="srchdivrt normtxt fleft" >
					<? $index=1; foreach($arrPartnerChilrenLivingStatusList as $key=>$value){
						$varChecked = ($key == $varHaveChilrenStatus)?'checked':'';
						if($index > 3) echo "<br>";
						echo '<input type="radio" name=partnerHavechild value="'.$key.'"  id="haveChilrenStatus'.$key.'" '.$varChecked.'><font class="normtxt" style="padding-right: 10px;">'.$value.'</font>';
					$index++;}?>
				</div><br clear="all"/>
				</div>

				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Mother Tongue</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="motherTongueTemp" name="motherTongueTemp[]" size="4" ondblclick="moveOptions(this.form.motherTongueTemp, this.form.motherTongue)" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrMotherTongueList, "Doesn't Matter", "0", "0");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.motherTongueTemp, this.form.motherTongue)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.motherTongue, this.form.motherTongueTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="motherTongue" name="motherTongue[]" tabindex="11" ondblclick="moveOptions(this.form.motherTongue, this.form.motherTongueTemp)"><? echo $objSearch->getOpionalValues($varPartnerMotherTongue, $arrMotherTongueList); ?></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>

				<? if($varUseReligion) {
					$arrGetReligionOption = $objDomainInfo->getReligionOption();
					if (sizeof($arrGetReligionOption)>1) {
						?>
						<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomainInfo->getReligionLabel()?></div>
						<div class="srchdivrt normtxt fleft"><div class="fleft">
							<select class="srchselect" id="partnerReligionTemp" name="partnerReligionTemp[]" ondblclick="moveOptions(this.form.partnerReligionTemp, this.form.partnerReligion)" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrGetReligionOption, "Doesn't Matter", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerReligionTemp, this.form.partnerReligion)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerReligion, this.form.partnerReligionTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerReligion" name="partnerReligion[]" tabindex="11" ondblclick="moveOptions(this.form.partnerReligion, this.form.partnerReligionTemp)">
							<? echo $objSearch->getOpionalValues($varPartnerReligion, $arrGetReligionOption); ?>
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else {
						echo '<input type="hidden" name="partnerReligion[]" value="'.key($arrGetReligionOption).'">';
					}
				} ?>
            <div style="width:400px !important;width:550px;float:left;padding-left:135px;">
			<? $isReligion = $objDomainInfo->useReligion();
			if($isReligion==1 && $varCommunityId !=2500 && $varCommunityId !=2503 && $varCommunityId !=2502 && $varCommunityId !=2501 && $varCommunityId !=2504 && $varCommunityId !=2007 && $varCommunityId !=2008) {
                $isMoreReligion = $objDomainInfo->getReligionOption();
				if(count($isMoreReligion) > 1){
					echo '<input type="checkbox" tabindex="'.($varTabIndex++).'" name="IncludeOtherReligion" value="1"><font class="normtxt">Include matching profile from other religion also</font>';
				}else{
					echo '<input type="hidden" name="IncludeOtherReligion" value="0">';
				}
				$showBr = '<br clear="all"/>';
			}else{
				$showBr = '';
			}?>
               </div>
				<? if($varUseDenomination) {
					$arrGetDenominationOption = $objDomainInfo->getDenominationOption();
					if (sizeof($arrGetDenominationOption)>1) {
						?>
						<div class="srchdivlt normtxt bld fleft"><?=$showBr;?><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomainInfo->getDenominationLabel()?></div>
						<div class="srchdivrt normtxt fleft"><div class="fleft">
							<select class="srchselect" id="partnerDenominationTemp" name="partnerDenominationTemp[]" ondblclick="moveOptions(this.form.partnerDenominationTemp, this.form.partnerDenomination)" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrGetDenominationOption, "Doesn't Matter", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerDenominationTemp, this.form.partnerDenomination)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerDenomination, this.form.partnerDenominationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerDenomination" name="partnerDenomination[]" tabindex="11" ondblclick="moveOptions(this.form.partnerDenomination, this.form.partnerDenominationTemp)"><? echo $objSearch->getOpionalValues($varPartnerDenomination, $arrGetDenominationOption); ?> 
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
				<? } else {
						echo '<input type="hidden" name="partnerDenomination[]" value="'.key($arrGetDenominationOption).'">';
					}
				} ?>

				<? if($varUseCaste && $varIsCasteMandatory == 1) {
					$arrGetCasteOption = $objDomainInfo->getCasteOption();
					if (sizeof($arrGetCasteOption)>1) {
						?>
						<div class="srchdivlt normtxt bld fleft"><?=$showBr;?><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomainInfo->getCasteLabel();?></div>
						<div class="srchdivrt normtxt fleft"><div class="fleft">
							<select class="srchselect" size="4" tabindex="<?=$varTabIndex++?>" ondblclick="moveOptions(this.form.partnerCasteTemp, this.form.partnerCaste)" multiple id="partnerCasteTemp" name="partnerCasteTemp[]"> <?=$objCommon->getValuesFromArray($arrGetCasteOption, "Doesn't Matter", "0", "");?> </select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerCasteTemp, this.form.partnerCaste)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerCaste, this.form.partnerCasteTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerCaste" name="partnerCaste[]" tabindex="11" ondblclick="moveOptions(this.form.partnerCaste, this.form.partnerCasteTemp)">
							<? echo $objSearch->getOpionalValues($varPartnerCaste, $arrGetCasteOption); ?>
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="partnerCaste[]" value="<?=key($arrGetCasteOption)?>">
					<? }
				}?>
					<?php
					if($objDomainInfo->useStar() == 1) {
					$arrGetStarOption = $objDomainInfo->getStarOption();
				if (sizeof($arrGetStarOption)>1) {
						?>
				<div class="srchdivlt normtxt bld fleft"><?=$showBr;?>Star</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" size="4" tabindex="<?=$varTabIndex++?>" id="partnerstarTemp" multiple name="partnerstarTemp[]" ondblclick="moveOptions(this.form.partnerstarTemp, this.form.partnerStar)"> <?=$objCommon->getValuesFromArray($arrGetStarOption, "Doesn't Matter", "0", "");?> </select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerstarTemp, this.form.partnerStar)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerStar, this.form.partnerstarTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerStar" name="partnerStar[]" tabindex="11" ondblclick="moveOptions(this.form.partnerStar, this.form.partnerstarTemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				<? } else {
					echo '<input type="hidden" name="partnerStar[]" value="'.key($arrGetStarOption).'">';
					} }?>

				<? if($varUseSubcaste && $varIsSubcasteMandatory==1) {
					$arrGetSubcasteOption = $objDomainInfo->getSubcasteOption();
					if (sizeof($arrGetSubcasteOption)>1) {
						?>
						<div class="srchdivlt normtxt bld fleft"><?=$showBr;?>Sub caste</div>
						<div class="srchdivrt normtxt fleft"><div class="fleft">
							<select class="srchselect" size="4" tabindex="<?=$varTabIndex++?>" id="partnerSubcasteTemp" multiple name="partnerSubcasteTemp[]" ondblclick="moveOptions(this.form.partnerSubcasteTemp, this.form.partnerSubcaste)"> <?=$objCommon->getValuesFromArray($arrGetSubcasteOption, "Doesn't Matter", "0", "");?> </select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerSubcasteTemp, this.form.partnerSubcaste)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerSubcaste, this.form.partnerSubcasteTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerSubcaste" name="partnerSubcaste[]" tabindex="11" ondblclick="moveOptions(this.form.partnerSubcaste, this.form.partnerSubcasteTemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
				<? } else {
					echo '<input type="hidden" name="partnerSubcaste[]" value="'.key($arrGetSubcasteOption).'">';
					}
				}?>

				<?  if($varUserGothram == 1 && count($varUserGothramOption)>1) {
				$arrGetGothramOption	= $objDomainInfo->getGothramOption();
				$varGothramCount		= sizeof($arrGetGothramOption);
				echo '<input type="hidden" name="gothramOption" value="'.$varGothramCount.'">';
			    ?>

				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Gothra</div>
				<div class="srchdivrt normtxt fleft">
					<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" size="4" tabindex="<?=$varTabIndex++?>" id="partnerGothramTemp" multiple name="partnerGothramTemp[]" ondblclick="moveOptions(this.form.partnerGothramTemp, this.form.partnerGothram)"> <?=$objCommon->getValuesFromArray($arrGetGothramOption, "Doesn't Matter", "0", "");?> </select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerGothramTemp, this.form.partnerGothram)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerGothram, this.form.partnerGothramTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerGothram" name="partnerGothram[]" tabindex="11" ondblclick="moveOptions(this.form.partnerGothram, this.form.partnerGothramTemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font></div>

				<? } ?>
				</div>
				<br clear="all"/>





				<? if($_FeatureDosham == 1) {
					$arrTmpDoshamList	= $objDomainInfo->getDoshamOption();
					unset($arrTmpDoshamList['3']);
					$varPartnerSizeDosham= sizeof($arrTmpDoshamList);

					if($varPartnerSizeDosham == 1) {?>
						<input type="hidden" name="partnerDhosam" value="<?=key($arrTmpDoshamList)?>">
					<?} else {
						if($varPartnerChevvaiDosham==0 && $varPartnerSizeDosham>1) {?>
						<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Chevvai Dosham</div>
						<div class="srchdivrt normtxt fleft"><div class="fleft">
							<input type="checkbox" name="partnerDhosam[]"  id="partnerDhosam"value='0' checked><font class='normtxt'>Doesn't matter&nbsp;</font>
							<?php foreach($arrTmpDoshamList as $key=>$value){
							    echo '<input type="checkbox" name="partnerDhosam[]" value="'.$key.'"  id="partnerDhosam"><font class="normtxt" style="padding-right: 10px;" >'.$value.'</font>';
							}?>
							</div><br clear="all">
						</div><br clear="all"/>
						<!--<div class="srchdivrt normtxt fleft">
							<?=$objCommon->displayRadioOptions($arrTmpDoshamList, "partnerDhosam", "No", "normtxt",'','');?>
							<input type=radio name=partnerDhosam value='0' checked><font class='normtxt'>Doesn't matter&nbsp;</font>
						</div>-->
						<br clear="all"/>
						<?}else{?>
							<input type="hidden" name="partnerDhosam" value="<?=$varPartnerChevvaiDosham?>">
						<?}
					}?>
				<? } ?>

                        <!--<div class="srchdivlt normtxt bld fleft"><?=$objDomainInfo->getGothramLabel()?></div>
						<div class="srchdivrt normtxt fleft"><div class="fleft">
							<select class="srchselect" id="partnerGothramTemp" name="partnerGothramTemp[]" size="4" ondblclick="moveOptions(this.form.partnerGothramTemp, this.form.partnerGothram)" <?=$objCommon->getValuesFromArray($arrGothramList, "Doesn't Matter", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.partnerGothramTemp, this.form.partnerGothram)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.partnerGothram,this.form.partnerGothramTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="partnerGothram" name="partnerGothram[]" tabindex="11" ondblclick="moveOptions(this.form.partnerGothram,this.form.partnerGothramTemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>	-->

				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Food habits</div>
				<div class="srchdivrt normtxt fleft">
					<div style="width:135px;" class="fleft"><input type="checkbox" name="partnerFoodChoice[]"  id="partnerFoodChoice"value='0' checked onClick="eatingHabitschk(1);"><font class='normtxt' style="padding-left:5px;padding-right:10px;">Doesn't matter&nbsp;</font></div>
					<?php foreach($arrEatingHabitsList as $key=>$value){
						echo '<div style="width:135px !important;width:135px;float:left"><input type="checkbox" name="partnerFoodChoice[]" value="'.$key.'"  id="partnerFoodChoice" onClick="eatingHabitschk(2);"><font class="normtxt" style="padding-left:5px;">'.$value.'</font></div>';
					}?>
					<!--<select class="inputtext" name="partnerFoodChoice" size="1" tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrEatingHabitsList, "Doesn't Matter", "0", "");?></select>-->
				</div><br clear="all"/>

				<div class="srchdivlt normtxt bld fleft">Smoking Habits</div>
				<div class="srchdivrt normtxt fleft">
					<div style="width:135px;" class="fleft"><input type="checkbox" name="partnerSmokeChoice[]"  id="partnerSmokeChoice"value='0' checked onClick="smokingHabitschk(1);"><font class='normtxt' style="padding-left:5px;">Doesn't matter&nbsp;</font></div>
					<?php foreach($arrSmokeList as $key=>$value){
						echo '<div style="width:140px !important;width:140px;float:left"><input type="checkbox" name="partnerSmokeChoice[]" value="'.$key.'"  id="partnerSmokeChoice" onClick="smokingHabitschk(2);"><font class="normtxt" style="padding-left:5px;">'.$value.'</font></div>';
					}?>
				</div><br clear="all"/>

				<div class="srchdivlt normtxt bld fleft">Drinking Habits</div>
				<div class="srchdivrt normtxt fleft">
					<div style="width:135px;" class="fleft"><input type="checkbox" name="partnerDrinkChoice[]"  id="partnerDrinkChoice"value='0' checked onClick="drinkingHabitschk(1);">
					<font class='normtxt' style="padding-left: 5px;">	Doesn't matter&nbsp;</font></div>
					<?php foreach($arrDrinkList as $key=>$value){
						echo '<div style="width:140px !important;width:140px;float:left"><input type="checkbox" name="partnerDrinkChoice[]" value="'.$key.'"  id="partnerDrinkChoice" onClick="drinkingHabitschk(2);"><font class="normtxt" style="padding-left: 5px;">'.$value.'</font></div>';
					}?>
				</div><br clear="all"/>

				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Education</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="educationTemp" name="educationTemp[]" size="4" multiple tabindex="<?=$varTabIndex++?>" ondblclick="moveOptions(this.form.educationTemp, this.form.education)" ><?=$objCommon->getValuesFromArray($arrEducationList, "Doesn't Matter", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.educationTemp, this.form.education)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.education, this.form.educationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="education" name="education[]" tabindex="11" ondblclick="moveOptions(this.form.education, this.form.educationTemp)">
					<? echo $objSearch->getOpionalValues($varEducation, $arrEducationList); ?>
					</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>

				<? if($confValues["DOMAINCASTEID"] == 2006 && $sessGender==1) {
					$arrTotalOccupationList = $arrFemaleDefenceOccupationList;
				} else if($confValues["DOMAINCASTEID"] == 2006 && $sessGender==2) {
					$arrTotalOccupationList = $arrDefenceOccupationList;
				}?>
				<div class="srchdivlt normtxt bld fleft">Occupation</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="occupationTemp" name="occupationTemp[]" size="4" ondblclick="moveOptions(this.form.occupationTemp, this.form.occupation)" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrTotalOccupationList, "Doesn't Matter", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.occupationTemp, this.form.occupation)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.occupation, this.form.occupationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="occupation" name="occupation[]" tabindex="11" ondblclick="moveOptions(this.form.occupation, this.form.occupationTemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>

				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Citizenship</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="citizenshipTemp" name="citizenshipTemp[]" ondblclick="moveOptions(this.form.citizenshipTemp, this.form.citizenship)" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrCountryList, "Doesn't Matter", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.citizenshipTemp, this.form.citizenship)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.citizenship, this.form.citizenshipTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="citizenship" name="citizenship[]" tabindex="11" ondblclick="moveOptions(this.form.citizenship, this.form.citizenshipTemp);">
					<?  echo $objSearch->getOpionalValues($varPartnerCitizenshipId, $arrCountryList); ?>
					</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>

				<? if($confValues["DOMAINCASTEID"] == 2006) { ?>
				<select class='srchselect' name='countryLivingIn[]' id='countryLivingIn' multiple size='5' style="display:none">
			          <option value="98" selected>India</option>
				</select>
                <? } else { ?>
				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Country Living In</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="countryLivingInTemp" name="countryLivingInTemp[]" ondblclick="moveOptions(this.form.countryLivingInTemp, this.form.countryLivingIn);changeincome();" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrCountryList, "Doesn't Matter", "0", "0");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.countryLivingInTemp, this.form.countryLivingIn);changeincome();"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="change_state1();moveOptions(this.form.countryLivingIn, this.form.countryLivingInTemp);changeincome();"></div><div class="fleft"><select class="srchselect" size="4" multiple id="countryLivingIn" name="countryLivingIn[]" tabindex="11" ondblclick="change_state1();moveOptions(this.form.countryLivingIn, this.form.countryLivingInTemp);changeincome();"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>
               <? } ?>
			   <div id="indstate" style="display:none;">
				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing India State</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="residingIndiaTemp" name="residingIndiaTemp[]" ondblclick="moveOptions(this.form.residingIndiaTemp, this.form.residingIndia);ajaxinterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex?>);change_citycount();" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrResidingStateList, "Select residing India state", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingIndiaTemp, this.form.residingIndia);ajaxinterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex?>);change_citycount();"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingIndia, this.form.residingIndiaTemp);ajaxinterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex?>);change_citycount();"></div><div class="fleft"><select class="srchselect" size="4" multiple id="residingIndia" name="residingIndia[]" tabindex="11" ondblclick="moveOptions(this.form.residingIndia, this.form.residingIndiaTemp);ajaxinterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex?>);change_citycount();"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>
				 </div>
				 <div id="cityInterList">
				 </div>
               
				<div id="usstate" style="display:none;">
				<? if($confValues["DOMAINCASTEID"] != 2006) { ?>
				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing USA State</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="residingUSATemp" name="residingUSATemp[]" size="4" ondblclick="moveOptions(this.form.residingUSATemp, this.form.residingUSA)" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrUSAStateList, "Select residing USA state", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingUSATemp, this.form.residingUSA)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingUSA, this.form.residingUSATemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="residingUSA" name="residingUSA[]" tabindex="11" ondblclick="moveOptions(this.form.residingUSA, this.form.residingUSATemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>
				<? } ?>
				</div>
			
				<!-- Srilanka state Maping -->
				<div id="srilankastate" style="display:none;">
				<? if($confValues["DOMAINCASTEID"] != 2006) { ?>
				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing Sri Lanka State</div>
				<div class="srchdivrt normtxt fleft"><div class="fleft">
					<select class="srchselect" id="residingSrilankaTemp" name="residingSrilankaTemp[]" size="4" ondblclick="moveOptions(this.form.residingSrilankaTemp, this.form.residingSrilanka)" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrResidingSrilankanList, "Select residing Sri Lanka state", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingSrilankaTemp, this.form.residingSrilanka)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingSrilanka, this.form.residingSrilankaTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="residingSrilanka" name="residingSrilanka[]" tabindex="11" ondblclick="moveOptions(this.form.residingSrilanka, this.form.residingSrilankaTemp)"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>
				<? } ?>
				</div>

				<!-- Pakistani state and city maping -->
				<div id="pakistanstate" style="display:none;">
				<div class="srchdivlt normtxt bld fleft"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing Pakistan State</div>
				<div class="srchdivrt normtxt fleft">
				<div class="fleft">
					<select class="srchselect" id="residingPakistanTemp" name="residingPakistanTemp[]" ondblclick="moveOptions(this.form.residingPakistanTemp, this.form.residingPakistan);ajaxPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php',<?=$varTabIndex?>);change_citycount1();" size="4" multiple tabindex="<?=$varTabIndex++?>"><?=$objCommon->getValuesFromArray($arrResidingPakistaniList, "Select residing Pakistan state", "0", "");?></select>
				</div>
				<div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingPakistanTemp, this.form.residingPakistan);ajaxPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php',<?=$varTabIndex?>);change_citycount1();"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingPakistan, this.form.residingPakistanTemp);ajaxPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php',<?=$varTabIndex?>);change_citycount1();"></div><div class="fleft"><select class="srchselect" size="4" multiple id="residingPakistan" name="residingPakistan[]" tabindex="11" ondblclick="moveOptions(this.form.residingPakistan, this.form.residingPakistanTemp);ajaxPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php',<?=$varTabIndex?>);change_citycount1();"></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div>
				<br clear="all"/>
				 
				</div>
				<div id="cityPakistanList">
				</div>

				





				<div id="inddiv" style="display:block;">
				<div class="srchdivlt normtxt bld fleft">Annual Income</div>
				<div class="srchdivlt1 normtxt fleft" id="incomeList" style="padding-left:5px;">
					<select name="FROMINCOME" id="FROMINCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onchange="return annualincomevalidation();" >
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEINRHASH, "", "", "");?></select>
				</div>
				<div class="srchdivlt1 normtxt fleft" id="annualincometo" style="display:none;padding-left:40px;">
					<select name="TOINCOME" id="TOINCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onblur="return amountrange();">
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEINRHASH, "", "", "");?></select><br><span id="stincome" class="errortxt"></span>
				</div>
				</div>

				<div id="otherdiv" style="display:none;">
				<div class="srchdivlt normtxt bld fleft">Annual Income</div>
				<div class="srchdivlt1 normtxt fleft" id="incomeusList" style="padding-left:5px;">
					<select name="FROMUSCOME" id="FROMUSCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onchange="return annualincomevalidation();">
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEDOLLARHASH, "", "", "");?></select>
				</div>
				<div class="srchdivlt1 normtxt fleft" id="annualuscometo" style="display:none;padding-left:40px;">
					<select name="TOUSCOME" id="TOUSCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onblur="return amountrange();">
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEDOLLARHASH, "", "", "");?></select><br><span id="stuscome" class="errortxt"></span>
				</div>
				</div>

				<br clear="all"/>
				<div class="srchdivlt normtxt bld fleft">Few lines about my partner</div>
				<div class="srchdivrt normtxt fleft" ><textarea class="tareareg" name="partnerDescription" style="resize: none;"></textarea><br />
				</div><br clear="all">

				<? }else{ ?>
				<input type="hidden" name="fromAge" value="<?=$varPartnerAge[0];?>">
				<input type="hidden" name="toAge" value="<?=$varPartnerAge[1];?>">
				<? } ?>

				<?if($varChkformAvail==1) {?>
				<div class="tlright"><input type="submit" tabindex="<?=$varTabIndex++?>" class="button" value="Submit" /></div>
				<?}else{
					echo "<script>window.location='".$confValues['SERVERURL'].'/profiledetail/'."'</script>";
				}?>
				<br clear="all"/>
            </div>
	</div>
	<br clear="all"/>
    </div>
	</form>
	<script language="javascript">document.frmRegister.weightKgs.focus();</script>
<?}?>
<script>
function eatingHabitschk(status){
    var frmProfile = document.frmRegister;

	if(status==1){
	var i;
		if (frmProfile.partnerFoodChoice[0].checked) {		
			for(i=1; i<=4; i++) {
				frmProfile.partnerFoodChoice[i].checked=false;
			}
		}
    }else{
		frmProfile.partnerFoodChoice[0].checked=false;
	}
}
function smokingHabitschk(status){
    var frmProfile = document.frmRegister;

	if(status==1){
	var i;
		if (frmProfile.partnerSmokeChoice[0].checked) {		
			for(i=1; i<=3; i++) {
				frmProfile.partnerSmokeChoice[i].checked=false;
			}
		}
    }else{
		frmProfile.partnerSmokeChoice[0].checked=false;
	}
}
function drinkingHabitschk(status){
    var frmProfile = document.frmRegister;

	if(status==1){
	var i;
		if (frmProfile.partnerDrinkChoice[0].checked) {		
			for(i=1; i<=3; i++) {
				frmProfile.partnerDrinkChoice[i].checked=false;
			}
		}
    }else{
		frmProfile.partnerDrinkChoice[0].checked=false;
	}
}
function GetAllValues(selobj){
  var myArray="";
  var numlen=selobj.options.length;
  for(var i=0; i<selobj.options.length; i++){
    myArray += selobj.options[i].value + "~";
  }
  myArray=myArray.substring(0,myArray.length-1);
  return myArray;
}

function partnerHaveChildnp()
{
		for (var i=0; i < document.frmRegister.lookingStatus.length; i++){
		if (document.frmRegister.lookingStatus[i].checked)
      {
     if(document.frmRegister.lookingStatus[i].value==1){
		 document.getElementById('hchild').style.display='none';
	 }
	 else{
		 document.getElementById('hchild').style.display='block';
	 }
      }
	}
}

function maritalstany(status){

	var frmProfile = document.frmRegister;

	if(status==1){
	var i;
		if (frmProfile.lookingStatus[0].checked) {
			for(i=1; i<=mstatuscnt; i++) {
				frmProfile.lookingStatus[i].checked=false;
			}
		}
    }else{
		frmProfile.lookingStatus[0].checked=false;
	}
}
function maritalst(){
	var frmProfile = document.frmRegister;
	var i,allchked=1;
	for(i=1; i<=mstatuscnt; i++) {
		if(frmProfile.lookingStatus[i].checked) {
			continue;
		} else {
			allchked = 0;
			break;
		}
	}
	if(allchked==1){
		frmProfile.lookingStatus[0].checked=true;
		for(i=1; i<=mstatuscnt; i++) {
			frmProfile.lookingStatus[i].checked=false;
		}
	} else {
		frmProfile.lookingStatus[0].checked=false;
	}

}


function changeincome() {
	var counval=document.getElementById('countryLivingIn');
    var arrCountry=new Array();
		
	for(var i=0; i<counval.options.length; i++){
		arrCountry[i]=counval.options[i].value;
	}
      
	if(checkValueInArray(arrCountry,98) == true){
		document.getElementById('inddiv').style.display='block';
		document.getElementById('otherdiv').style.display='none';
		document.getElementById('indstate').style.display='block';
	} else {
		document.getElementById('inddiv').style.display='none';
		document.getElementById('otherdiv').style.display='block';
	}
	if(checkValueInArray(arrCountry,222) == true)
		document.getElementById('usstate').style.display='block';
	
	if(checkValueInArray(arrCountry,195) == true) {
		document.getElementById('srilankastate').style.display='block';
	} else {
		document.getElementById('srilankastate').style.display='none';
	}
	if(checkValueInArray(arrCountry,162) == true) {
		document.getElementById('pakistanstate').style.display='block';
	} else {
		document.getElementById('pakistanstate').style.display='none';
	}
}

function change_state1() {
	var counval1=document.getElementById('countryLivingIn');
	var counval2=counval1.selectedIndex;
	if($("countryLivingIn").options[counval2].value==98){
		document.getElementById('indstate').style.display='none';
		document.getElementById('cityInterList').style.display='none';
	}
	if($("countryLivingIn").options[counval2].value==162){
		document.getElementById('pakistanstate').style.display='none';
		document.getElementById('cityPakistanList').style.display='none';
	}
	if($("countryLivingIn").options[counval2].value==222){
		document.getElementById('usstate').style.display='none';
	}
}

function change_citycount() {
	var citycount1=document.getElementById('residingIndia');
	var residingcount1=citycount1.options.length;
	if(residingcount1 > 0){
		document.getElementById('cityInterList').style.display='block';
	} else {
		document.getElementById('cityInterList').style.display='none';
	}
}
 
function change_citycount1() {
	var citycount1=document.getElementById('residingPakistan');
	var residingcount1=citycount1.options.length;
	if(residingcount1 > 0){
		document.getElementById('cityPakistanList').style.display='block';
	} else {
        document.getElementById('cityPakistanList').style.display='none';
    }
}


function annualincomevalidation(){
  var ind_annual_notin=new Array(0,1,29);
  var us_annual_notin=new Array(0,1,16);
  var counval=GetAllValues(document.getElementById('countryLivingIn'));
  var stincomevals=document.getElementById('FROMINCOME').value;
  var stuscomevals=document.getElementById('FROMUSCOME').value;
    var array=new Array();
  var stat,showhide=0,hideshow=0;
  var RsFlag=0, iRightLen=$("countryLivingIn").length;

  for(i=0; i < iRightLen; i++){
    if($("countryLivingIn").options[i].value==98 || $("countryLivingIn").options[i].value==0)
      RsFlag=1;
  }
  if(RsFlag==1)
    stat=1;
  else
    stat=0;

  if(counval==''){stat=1;}
  if(stat==1){
    array=ind_annual_notin;
  }else{
    array=us_annual_notin;
  }
  for(var i=0;i<array.length;i++){
    if(array[i]==stincomevals){
      showhide=1;
    }
	 if(array[i]==stuscomevals){
      hideshow=1;
    }
  }
  if(showhide==1){
    document.getElementById('annualincometo').style.display="none";
    document.getElementById('TOINCOME').value=0;
  }else{
    document.getElementById('annualincometo').style.display="block";
    document.getElementById('TOINCOME').value=0;
  }

  if(hideshow==1){
    document.getElementById('annualuscometo').style.display="none";
    document.getElementById('TOUSCOME').value=0;
  }else{
    document.getElementById('annualuscometo').style.display="block";
    document.getElementById('TOUSCOME').value=0;
  }
  return false;
}
</script>