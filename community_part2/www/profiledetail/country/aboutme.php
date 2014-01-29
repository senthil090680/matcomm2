<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : primaryinfodesc.php
#=====================================================================================================================================
# Description : display information of primary info. It has primary info form and update function primary information.
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/cookieconfig.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/cityarray.inc');
include_once($varRootBasePath.'/conf/ppinfo.inc');
include_once($varRootBasePath.'/conf/tblfields.inc');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessGender 	= $varGetCookieInfo["GENDER"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;
$objDomain	= new domainInfo;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['aboutmesubmit'];

//Domain Related information
$varAppearanceFeature		= $objDomain->useAppearance();
$varMatritalStatusFeature	= $objDomain->useMaritalStatus();
$varMotherTongueFeature		= $objDomain->useMotherTongue();
$varReligionFeature			= $objDomain->useReligion();

// newly added features
$varCasteFeature		= $objDomain->useCaste();
$varIsCasteMandatory	= $objDomain->isCasteMandatory();
$varUseEmployedIn		= $objDomain->useEmployedIn();

// Array for showing religious value option 
$varReligiosValueforReligion = array("2","10","11","20","21","22","23");

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
function displaySelectedValuesFromArray($argArrName,$argSelectedValue) {
	$funArrSelectedValue	= explode("~", $argSelectedValue);
	foreach($argArrName as $funIndex => $funValues)
	{
		if (in_array($funIndex, $funArrSelectedValue))
		{ $funOptions .= '<option value="'.$funIndex.'"  selected>'.$funValues.'</option>';}
		else
		{ $funOptions .= '<option value="'.$funIndex.'">'.$funValues.'</option>';}
	}//for
	return $funOptions;

}//displaySelectedValuesFromArray

if($varUpdatePrimary == 'yes') {

	//ONJECT CREATION & CONNECT DATABASE
	$objDBMaster = new MemcacheDB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varEditedMaritalStatus			= $_REQUEST["maritalStatus"];
	$varEditedNoOfChildren			= $_REQUEST["noOfChildren"];
	$varEditedChildrenLivingStatus	= $_REQUEST["childLivingWithMe"];
	$varEditedWeightKgs				= $_REQUEST["weightKgs"];
	$varEditedWeightLbs				= $_REQUEST["weightLbs"];
	$varEditedHeightFeet		    = $_REQUEST["heightFeet"];
	$varEditedHeightCms			    = $_REQUEST["heightCms"];
	$varEditedBodyType				= $_REQUEST["bodyType"];
	$varEditedComplexion			= $_REQUEST["complexion"];
    $varEditedBloodGroup			= $_REQUEST["bloodGroup"];
	$varEditedPhysicalStatus		= $_REQUEST["physicalStatus"];
	$varEditedAppearance			= $_REQUEST["appearance"];
	$varEditedMotherTongueId		= $_REQUEST["motherTongue"];
    $varEditedSpokenLanguages =  join('~',$_REQUEST["spokenLanguages"]);
	
	$varEditedMotherTongueText		= addslashes(strip_tags(trim($_REQUEST["motherTongueTxt"])));
	$varEditedReligion				= $_REQUEST["religion"];
    $varEditedReligionText		    = addslashes(strip_tags(trim($_REQUEST["religionOthers"])));

	if(isset($_REQUEST["casteOthers"]) && $_REQUEST["casteOthers"] != '' ) {
	 $varEditedCasteTxt			= addslashes(strip_tags(trim($_REQUEST["casteOthers"])));
	}
	else {
	 $varEditedCasteTxt			= addslashes(strip_tags(trim($_REQUEST["casteText"])));
	}
	$varEditedCasteId			= $_REQUEST["caste"];
	$varEditedCasteNoBar		= $_REQUEST["casteNoBar"];
	$varEditedHoroscope				= $_REQUEST["horoscope"];

    $varEducationSubcategory	    = $_REQUEST['educationCategory'];
	$varEducationCategory	        = $arrEducationMapping[$varEducationSubcategory];
	$varEmployedIn			        = $_REQUEST['employmentCategory'];
	$varOccupation			        = $_REQUEST['occupation'];

	$varEditedEducationInDetail		= addslashes(strip_tags(trim($_REQUEST["educationInDetail"])));
	$varEditedOccupationInDetail	= addslashes(strip_tags(trim($_REQUEST["occupationInDetail"])));
	$varEditedIncomeCurrency		= $_REQUEST["annualIncomeCurrency"];
	//$varEditedAnnualIncome			= addslashes(strip_tags(trim($_REQUEST["annualIncome"])));
	$varEditedAnnualIncome		= addslashes(strip_tags(str_replace(',','',trim($_REQUEST['annualIncome']))));

    $varEditedCountry			= $_REQUEST["country"];
	$varEditedResidingState		= addslashes(strip_tags(trim($_REQUEST["residingState"])));
	$varEditedResidingCity		= addslashes(strip_tags(trim($_REQUEST["residingCity"])));
	$varOtherState				= $_REQUEST["otherState"];
	$varOtherCity				= $_REQUEST["otherCity"];
	$varEditedCountryOfBirth    = $_REQUEST["placeofbirth"];
    if($varEditedCountry == 98) {
	  $varEditedCitizenship	 = 98; }
	else {
 	  $varEditedCitizenship			= $_REQUEST["citizenship"]; }
	  $varEditedResidentStatus	= $_REQUEST["residentStatus"];
	  $varEditedAboutMySelf			= addslashes(strip_tags(trim($_REQUEST["DESCDET"])));

	if ($varEditedWeightKgs != 0 && $varEditedWeightKgs != '') {
		$varEditedWeight		= $varEditedWeightKgs;
		$varEditedWeightUnit	= 'kg';
	} elseif ($varEditedWeightLbs != 0 && $varEditedWeightLbs != '') {
		$varEditedWeight		= $varEditedWeightLbs;
		$varEditedWeightUnit	= 'lbs';
	}//if
    
    if($varEditedHeightFeet != 0 && $varEditedHeightFeet != '') {
		$varEditedHeight  		= $varEditedHeightFeet;
		$varEditedHeightUnit	= 'feet-inches';
	} elseif($varEditedHeightCms != 0) { 
		$varEditedHeight		= $varEditedHeightCms;
		$varEditedHeightUnit	= 'cm';
	}

	if($sessMatriId != '') {
		//Direct updatation for array field
		$argFields 			= array('Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Height','Height_Unit','Body_Type','Complexion','Physical_Status','Appearance','Horoscope_Match','Education_Category','Education_Subcategory','Employed_In','Occupation','Citizenship','Resident_Status','Country_Of_Birth','Date_Updated');
		$argFieldsValues	= array("'".$varEditedMaritalStatus."'","'".$varEditedNoOfChildren."'","'".$varEditedChildrenLivingStatus."'","'".$varEditedWeight."'","'".$varEditedWeightUnit."'","'".$varEditedHeight."'","'".$varEditedHeightUnit."'","'".$varEditedBodyType."'","'".$varEditedComplexion."'","'".$varEditedPhysicalStatus."'","'".$varEditedAppearance."'","'".$varEditedHoroscope."'","'".$varEducationCategory."'","'".$varEducationSubcategory."'","'".$varEmployedIn."'","'".$varOccupation."'","'".$varEditedCitizenship."'","'".$varEditedResidentStatus."'","'".$varEditedCountryOfBirth."'",'NOW()');

        
		if($varCasteFeature==1 && $varEditedCasteId!=9997) { 
			//drop down value and selected value should not "others"
			
			if ($varEditedCasteId > 0){
			array_push($argFields,'CasteId');
			array_push($argFieldsValues,"'".$varEditedCasteId."'");
			}
			array_push($argFields,'CasteText');
			array_push($argFieldsValues,"''");
		}

		if($varMotherTongueFeature==1 && $varEditedMotherTongueId!=9997) { 
			//drop down value and selected value should not "others"
			
			if ($varEditedMotherTongueId > 0){
			array_push($argFields,'Mother_TongueId');
			array_push($argFieldsValues,"'".$varEditedMotherTongueId."'");
			}
			array_push($argFields,'Mother_TongueText');
			array_push($argFieldsValues,"''");
		}

		if($varReligionFeature==1 && $varEditedReligion!=23) { 
			//drop down value and selected value should not "others"
			
			if ($varEditedReligion > 0){
			array_push($argFields,'Religion');
			array_push($argFieldsValues,"'".$varEditedReligion."'");
			}
			array_push($argFields,'ReligionText');
			array_push($argFieldsValues,"''");
		}

        if($varEditedCountry == 98 || $varEditedCountry == 162) {
				array_push($argFields,'Country');
				array_push($argFieldsValues,"'".$varEditedCountry."'");
				array_push($argFields,'Residing_State');
				array_push($argFieldsValues,"'".$varEditedResidingState."'");
				array_push($argFields,'Residing_District');
				array_push($argFieldsValues,"'".$varEditedResidingCity."'");
				array_push($argFields,'Residing_Area');
				array_push($argFieldsValues,"''");
				array_push($argFields,'Residing_City');
				array_push($argFieldsValues,"''");
		}
      // Condition for resetting religious value option 
       	if(!in_array($varEditedReligion, $varReligiosValueforReligion)){
			array_push($argFields,'Religious_Values');
			array_push($argFieldsValues,'0');
			}
		

		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

        $argFields 			= array('Matriid','Languages_Selected');
		$argFieldsValues	= array("'".$sessMatriId."'","'".$varEditedSpokenLanguages."'");
        $objDBMaster->insertOnDuplicate($varTable['MEMBERHOBBIESINFO'],$argFields,$argFieldsValues,'MatriId'); 

		// IF NOT VALIDATED MEMBER, COMMIT OTHER DETAILS DIRECTLY
		if($sessPublish == 0 || $sessPublish == 4) {
			$argFields 			= array('Mother_TongueId','Mother_TongueText','CasteId','CasteText','Education_Detail','Occupation_Detail','Annual_Income','Income_Currency','About_Myself','Religion','ReligionText');
			$argFieldsValues	= array("'".$varEditedMotherTongueId."'","'".$varEditedMotherTongueText."'","'".$varEditedCasteId."'","'".$varEditedCasteTxt."'","'".$varEditedEducationInDetail."'","'".$varEditedOccupationInDetail."'","'".$varEditedAnnualIncome."'","'".$varEditedIncomeCurrency."'","'".$varEditedAboutMySelf."'","'".$varEditedReligion."'","'".$varEditedReligionText."'");
			
			if($sessPublish == 4) {
				array_push($argFields,'Publish');
				array_push($argFieldsValues,'0');
			}
            
            if($varEditedCountry == 98 || $varEditedCountry == 162) { }
				else {
					if($varEditedCountry == 222 || $varEditedCountry == 195) {
						array_push($argFields,'Residing_State');
						array_push($argFieldsValues,"'".$varEditedResidingState."'");
						array_push($argFields,'Residing_Area');
						array_push($argFieldsValues,"''");
					} else {
						array_push($argFields,'Residing_State');
						array_push($argFieldsValues,"''");
						array_push($argFields,'Residing_Area');
						array_push($argFieldsValues,"'".$varEditedResidingState."'");
					}
					array_push($argFields,'Country');
					array_push($argFieldsValues,"'".$varEditedCountry."'");
					array_push($argFields,'Residing_District');
					array_push($argFieldsValues,"''");
					array_push($argFields,'Residing_City');
					array_push($argFieldsValues,"'".$varEditedResidingCity."'");
			}
            
			$argCondition		= "MatriId = '".$sessMatriId."'";
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
		}
		else {
			if(trim($_REQUEST['oldedudet']) != trim($varEditedEducationInDetail) || trim($_REQUEST['oldoccdet']) != trim($varEditedOccupationInDetail) || trim($_REQUEST['oldincome']) != trim($varEditedAnnualIncome) || trim($_REQUEST['oldcurrency']) != trim($varEditedIncomeCurrency) || trim($_REQUEST['oldaboutme']) != trim($varEditedAboutMySelf) || ($varMotherTongueFeature==1 && (trim($_REQUEST['oldmothertongueTxt']) != $varEditedMotherTongueText)) || ($varCasteFeature==1 && (trim($_REQUEST['oldothCaste']) != $varEditedCasteTxt)) || ($varOtherState == 1 && trim($_REQUEST['oldstate']) != trim($varEditedResidingState) && trim($_REQUEST['oldstatearea']) != trim($varEditedResidingState)) || ($varOtherCity == 1 && trim($_REQUEST['oldcity']) != trim($varEditedResidingCity)) || ($varReligionFeature == 1 && trim( $_REQUEST['oldreligionTxt']) != trim($varEditedReligionText))) {
				$argFields 			= array('MatriId');
				$argFieldsValues	= array("'".$sessMatriId."'");
				$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

				$argFields 			= array('Date_Updated');
				$argFieldsValues	= array('NOW()');

                if(trim($_REQUEST['oldedudet']) != $varEditedEducationInDetail) {
					array_push($argFields,'Education_Detail');
					array_push($argFieldsValues,"'".$varEditedEducationInDetail."'");
				}

				if(trim($_REQUEST['oldoccdet']) != $varEditedOccupationInDetail) {
					array_push($argFields,'Occupation_Detail');
					array_push($argFieldsValues,"'".$varEditedOccupationInDetail."'");
				}

				if((trim($_REQUEST['oldincome']) != $varEditedAnnualIncome) || (trim($_REQUEST['oldcurrency']) != trim($varEditedIncomeCurrency))) {
					array_push($argFields,'Annual_Income');
					array_push($argFieldsValues,"'".$varEditedAnnualIncome."'");
					array_push($argFields,'Income_Currency');
					array_push($argFieldsValues,"'".$varEditedIncomeCurrency."'");
				}

				if(trim($_REQUEST['oldaboutme']) != trim($varEditedAboutMySelf)) {
					array_push($argFields,'About_Myself');
					array_push($argFieldsValues,"'".$varEditedAboutMySelf."'");
				}

				if($varMotherTongueFeature==1 && (trim($_REQUEST['oldmothertongueTxt']) != $varEditedMotherTongueText)) {
					if($varEditedCasteId==9997) {
						array_push($argFields,'Mother_TongueId');
						array_push($argFieldsValues,"'".$varEditedMotherTongueId."'");
					}
					array_push($argFields,'Mother_TongueText');
					array_push($argFieldsValues,"'".$varEditedMotherTongueText."'");
				}

				if($varReligionFeature == 1 && (trim($_REQUEST['oldreligionTxt']) != $varEditedReligionText)) {
					if($varEditedReligion==23) {
						array_push($argFields,'Religion');
						array_push($argFieldsValues,"'".$varEditedReligion."'");
					}
					array_push($argFields,'ReligionText');
					array_push($argFieldsValues,"'".$varEditedReligionText."'");
				}

				if($varCasteFeature==1 && (trim($_REQUEST['oldothCaste']) != $varEditedCasteTxt)) {
						if(($varEditedCasteId==9997) || ($varEditedDenomination == 9997)) {
							array_push($argFields,'CasteId');
							array_push($argFieldsValues,"'".$varEditedCasteId."'");
						}
						array_push($argFields,'CasteText');
						array_push($argFieldsValues,"'".$varEditedCasteTxt."'");
				}

               if(($varOtherState == 1 && trim($_REQUEST['oldstate']) != trim($varEditedResidingState) && trim($_REQUEST['oldstatearea']) != trim($varEditedResidingState)) || ($varOtherCity == 1 && trim($_REQUEST['oldcity']) != trim($varEditedResidingCity))) {
						array_push($argFields,'Country');
						array_push($argFieldsValues,"'".$varEditedCountry."'");
						array_push($argFields,'Residing_State');
						array_push($argFieldsValues,"'".$varEditedResidingState."'");
						array_push($argFields,'Residing_City');
						array_push($argFieldsValues,"'".$varEditedResidingCity."'");
			    }
                
				$argCondition		= "MatriId = '".$sessMatriId."'";
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

				$argFields 			= array('Pending_Modify_Validation');
				$argFieldsValues	= array(1);
				$argCondition		= "MatriId = '".$sessMatriId."'";
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}
		}

		$argFields 			= array('Date_Updated','Time_Posted');
		$argFieldsValues	= array('NOW()','NOW()');
		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		$objDBMaster->dbClose();
	}

} else {
	
	$argFields			= $arrMEMBERINFOfields;
	$argCondition		= "WHERE MatriId='".$sessMatriId."' AND ".$varWhereClause;
	
	$varMemberInfo		= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);
	$argFields				= array('Languages_Selected');
	$argCondition			= "WHERE MatriId='".$sessMatriId."'";
	$varHobbiesInfo			= $objDBSlave->select($varTable['MEMBERHOBBIESINFO'],$argFields,$argCondition,1);		
    
	$varAbsWeight = str_replace(".00","",$varMemberInfo['Weight']);
	if($varAbsWeight!=0) {
		if($varMemberInfo['Weight_Unit'] == 'kg') {
			$varWeightKgPass	= round($varMemberInfo['Weight']);
			$varWeightLbsPass	= '';
		} else {
			$varWeightLbsPass	= round($varMemberInfo['Weight']);
			$varWeightKgPass	= '';
		}
	}
    
    $varAbsHeight			= $varMemberInfo['Height'];
	$arrHt					= explode(".",$varAbsHeight);
	if($varMemberInfo['Height_Unit'] == 'feet-inches') {
		if($arrHt[1] == '00') {
			$varAbsHeight	= str_replace(".00","",$varAbsHeight);
			$varHeightPass	= $arrParHeightList[$varAbsHeight];
		} else {
			$varHeightPass	= $varAbsHeight;
		}
		$varHeightPassCm	= '';
	} else {
		$varHeightPassCm	= (int)(round($varAbsHeight));
		$varHeightPass		= '';
	}
 
 	$varCommunityId				= $varMemberInfo['CommunityId'];
	$varGender					= $varMemberInfo['Gender'];
	$varCasteId					= $varMemberInfo['CasteId'];
	$varMaritalStatus			= $varMemberInfo['Marital_Status'];
	$varNoOfChildren			= $varMemberInfo['No_Of_Children'];
	$varChildrenLivingStatus	= $varMemberInfo['Children_Living_Status'];
	$varBodyType				= $varMemberInfo['Body_Type'];
	$varComplexion				= $varMemberInfo['Complexion'];
	$varBloodGroup              = $varMemberInfo['Blood_Group'];  
	$varPhysicalStatus			= $varMemberInfo['Physical_Status'];
	$varAppearance				= $varMemberInfo['Appearance'];
	$varMotherTongueId			= $varMemberInfo['Mother_TongueId'];
	$varMotherTongueText		= $varMemberInfo['Mother_TongueText'];
	$varReligion				= $varMemberInfo['Religion'];
	$varHoroscopeMatch			= $varMemberInfo['Horoscope_Match'];
	$varEducationSubcategory	= $varMemberInfo['Education_Subcategory'];
	$varEducationDetail			= $varMemberInfo['Education_Detail'];
	$varEmployedIn			    = $varMemberInfo['Employed_In'];
	$varOccupation			    = $varMemberInfo['Occupation'];
	$varOccupationDtl			= $varMemberInfo['Occupation_Detail'];
	$varIncomeCurrency			= $varMemberInfo['Income_Currency'];
	$varAbsAnnualIncome = str_replace(".00","",$varMemberInfo['Annual_Income']);
	$varReligionText			= $varMemberInfo['ReligionText'];
	$varCountryOfBirth  		= $varMemberInfo['Country_Of_Birth'];
	if($varAbsAnnualIncome != '0') { 
		$varCurrencyVal = $varAbsAnnualIncome;
	} else {
		$varCurrencyVal = '';
	}
	echo "<script>var gender=$varGender</script>";

	$varCountry					= $varMemberInfo['Country'];
	$varCitizenship				= $varMemberInfo['Citizenship'];
	$varResident_Status			= $varMemberInfo['Resident_Status'];
	$varAboutMyself				= trim($varMemberInfo['About_Myself']);

	$varReligionId				= $varMemberInfo['Religion'];
	$varCasteId					= $varMemberInfo['CasteId'];
	$varCasteText				= $varMemberInfo['CasteText'];
	
	$varSpokenLanguagesString    = $varHobbiesInfo[0]['Languages_Selected'];
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/<?=$_IncludeFolder?>aboutme.js" ></script>
<link rel="stylesheet" type="text/css" href="<?=$confValues['CSSPATH']?>/spellchecker.css">

		<? include_once('settingsheader.php');?>
		<center>
			<div class="padt10">
				<?if($varUpdatePrimary == 'yes') { ?>
				<div class='fleft' style='width:490px;'>
					Your about me information has been modified successfully.
					<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
				</div>
				<? } else { ?>
				<form method='post' name='frmProfile' onSubmit='return aboutmeValidate();' style="padding:0px; margin:0px;">
				<input type="hidden" name="communityId" value="<?=$varCommunityId?>">
				<input type='hidden' value='aboutme' name='act'>
				<input type='hidden' value='yes' name='aboutmesubmit'>
				<input type="hidden" name="oldmothertongueTxt" value="<?=addslashes(strip_tags(trim($varMotherTongueText)))?>">
				<input type="hidden" name="appearanceFeature" value="<?=$varAppearanceFeature?>">
				<input type="hidden" name="maritalstatusfeature" value="<?=$varMatritalStatusFeature?>">
				<input type="hidden" name="mothertonguefeature" value="<?=$varMotherTongueFeature?>">
				<input type="hidden" name="religionfeature" value="<?=$varReligionFeature?>">
				<input type="hidden" name="oldreligionTxt" value="<?=addslashes(strip_tags(trim($varReligionText)))?>">
				<input type="hidden" name="empinfeature" value="<?=$varUseEmployedIn?>">
				<input type='hidden' name='oldedudet' value="<?=addslashes(strip_tags(trim($varEducationDetail)));?>">
				<input type='hidden' name='oldoccdet' value="<?=addslashes(strip_tags(trim($varOccupationDtl)));?>">
				<input type='hidden' name='oldincome' value="<?=addslashes(strip_tags(trim($varMemberInfo['Annual_Income'])))?>">
				<input type='hidden' name='oldcurrency' value="<?=addslashes(strip_tags(trim($varIncomeCurrency)));?>">
				<input type='hidden' name='oldaboutme' value="<?=addslashes(strip_tags(trim($varAboutMyself)))?>">
				<input type='hidden' name='countryid' value="<?=$varCountry?>">

                <input type='hidden' name='oldstate' value='<?=addslashes(strip_tags(trim($varMemberInfo['Residing_State'])))?>'>
			    <input type='hidden' name='oldstatearea' value='<?=addslashes(strip_tags(trim($varMemberInfo['Residing_Area'])))?>'>
		    	<input type='hidden' name='oldcity' value='<?=addslashes(strip_tags(trim($varOldCityValue)))?>'>
			    <input type='hidden' name='emaildup' value=''>

				<input type='hidden' name='occupationid' value="<?=$varOccupation?>">
				<input type="hidden" name="castefeature" value="<?=$varCasteFeature?>">
			    <input type="hidden" name="castemandatory" value="<?=$varIsCasteMandatory?>">
			    <input type="hidden" name="oldothCaste" value="<?=addslashes(strip_tags(trim($varCasteText)))?>">
				<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">
				<div class="normtxt clr bld fleft padl25">Basic Information</div><br clear="all"/>

				<?if($varMatritalStatusFeature) { 
					$arrRetMaritalStatus	= $objDomain->getMaritalStatusOption();
					if($varCommunityId==2008 && $varGender == 2) {
						unset($arrRetMaritalStatus[5]);
					}
					$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
					?>
					<input type="hidden" name="maritaltxtfeature" value="<?=$varSizeMaritalStatus;?>">
					<?
					if($varSizeMaritalStatus==1) {?>
						<input type="hidden" name="maritalStatus" value="<?=key($arrRetMaritalStatus)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getMaritalStatusLabel()?><span class="clr3">*</span></div>
						<div class="fleft pfdivrt tlleft">
							<select class='srchselect' NAME='maritalStatus' size='1' onChange='return HaveChildnp(this)' onblur='ChkEmpty(document.frmProfile.maritalStatus, "select", "mstatus","Please select the marital status of the prospect");'>
								<?=$objCommon->getValuesFromArray($arrRetMaritalStatus, "- Select -", "0", $varMaritalStatus);?>
							</select>
							<br><span id="mstatus" class="errortxt"></span>
						</div><br clear="all"/>

						<!--Have to work-->
						<div class="pfdivlt fleft">&nbsp;</div>
						<div class="fleft pfdivrt tlleft">
						<div class='smalltxt'>No. of Children&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Children living status</font> <br>
							<select class='inputtext' NAME='noOfChildren' size='1' onChange='return HaveChildnp(this)'>
							<?if($varMaritalStatus > 1) {?>
							<?=$objCommon->getValuesFromArray($arrNoOfChildrenList, "- Select -", "", $varNoOfChildren);?>
							</select>
							
							<?if($varNoOfChildren >= 1) {?>
								<input type=radio name='childLivingWithMe' value='0' <?if($varChildrenLivingStatus==0) { echo 'checked';}?> id='childLivingWithMe'><font class='smalltxt'>Living with me</font>&nbsp; 
								<input type=radio name='childLivingWithMe' value='1' onFocus='if(disabled)blur();' <?if($varChildrenLivingStatus==1){ echo 'checked';}?> id='childLivingWithMe'><font class='smalltxt'>Not living with me</font>
							<?} else { ?>
								<input type=radio name='childLivingWithMe' value='0'><font class='smalltxt' id='childLivingWithMe'>Living with me</font>&nbsp; <input type=radio name='childLivingWithMe' value='1' onFocus='if(disabled)blur();'><font class='smalltxt' id='childLivingWithMe'>Not living with me</font>
							<?}
							} else {?>
							<?=$objCommon->getValuesFromArray($arrNoOfChildrenList, "- Select -", "", $varNoOfChildren);?>
							</select>
							&nbsp; 
							<input type=radio name='childLivingWithMe' value='0'><font class='smalltxt'>Living with me</font>&nbsp; <input type=radio name='childLivingWithMe' value='1' onFocus='if(disabled)blur();' id='childLivingWithMe'><font class='smalltxt'>Not living with me</font>
							<?}?>
						</div></div><br clear="all"/>
						<!--Have to work-->
					<? } 
				} ?>
				
				<div class="smalltxt fleft tlright pfdivlt" >Weight</div>
				<div class="fleft pfdivrt tlleft"><select class='inputtext' NAME='weightKgs' size='1' onChange='return onKGS()'>
						<?=$objCommon->getValuesFromArray($arrWeightKgsList, "--Kgs-- ", "0", $varWeightKgPass);?>
					</select>
					&nbsp;&nbsp;or&nbsp;&nbsp;<!-- <font class='mediumtxt mediumtxt boldtxt'></font> -->
					<select class='inputtext' NAME='weightLbs' size='1' onChange='return onLBS()'>
						<?=$objCommon->getValuesFromArray($arrWeightLbsList, "--Lbs-- ", "0", $varWeightLbsPass);?>
					</select>
				</div><br clear="all"/>
                
               
			    <div class="smalltxt fleft tlright pfdivlt">Height<span class="clr3">*</span></div>
			    <div class="fleft pfdivrt tlleft"><select class='inputtext' NAME='heightFeet' size='1' onChange='return onFEET();' onblur='heightChk();'>
					<?=$objCommon->getValuesFromArray($arrHeightFeetList, "-- Feet/Inches --", "0", $varHeightPass);?>
				</select>
				<!-- or <b>Cms</b> -->
				<select class='inputtext' NAME='heightCms' size='1' onChange='return onCMS()' onblur='heightChk();'>
					<option value=0>- Select -</option>
					<?for($i = 121; $i <= 241; $i++) {
						if($i == $varHeightPassCm)
							echo "'<option value=$i selected>$i cm</option>'";
						else
							echo "'<option value=$i>$i cm</option>'";
					}?> 
				</select><br><span id="height" class="errortxt"></span>
			  </div><br clear="all"/>



				<div class="smalltxt fleft tlright pfdivlt" >Body Type</div>
				<div class="fleft pfdivrt tlleft">
					<? foreach($arrBodyTypeList as $key=>$value){
						$varChecked = ($key == $varBodyType)?'checked':'';
						echo '<input type="radio" name=bodyType value="'.$key.'"  id="bodyType'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright pfdivlt" >Complexion</div>
				<div class="fleft pfdivrt tlleft">
					<? foreach($arrComplexionList as $key=>$value){
						$varChecked = ($key == $varComplexion)?'checked':'';
						echo '<input type="radio" name=complexion value="'.$key.'"  id="complexion'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright pfdivlt" >Physical Status<span class="clr3">*</span></div>
				<? unset($arrPhysicalStatusList[2]);?>
				<input type="hidden" name="PhysicalStatusCnt" value="<?=sizeof($arrPhysicalStatusList)?>">
				<div class="fleft pfdivrt tlleft">
					<? foreach($arrPhysicalStatusList as $key=>$value){
						$varChecked = ($key == $varPhysicalStatus)?'checked':'';
						echo '<input type="radio" name=physicalStatus value="'.$key.'"  id="physicalStatus'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					}?>
				</div><br clear="all"/>

				<?if($varAppearanceFeature) { 
					$arrRetAppearance	= $objDomain->getAppearanceOption();
					$varSizeAppearance	= sizeof($arrRetAppearance);
					?>
					<input type="hidden" name="appearancetxtfeature" value="<?=$varSizeAppearance;?>">
					<?
					if($varSizeAppearance==1) {?>
						<input type="hidden" name="appearance" value="<?=key($arrRetAppearance)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getAppearanceLabel()?><span class="clr3">*</span></div>
						<div class="fleft pfdivrt tlleft">
							<? if($varSizeAppearance>1){
								foreach($arrRetAppearance as $key=>$value){
									$varChecked = ($key == $varAppearance)?'checked':'';
									echo '<input type="radio" class="frmelements" name=appearance value="'.$key.'"  id="appearance'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
								}
							} ?><br><span id="spanappearance" class="errortxt"></span>
						</div><br clear="all"/>
					<? } 
				} ?>

				<? if($varMotherTongueFeature) {
					$arrRetMotherTongue	= $objDomain->getMotherTongueOption();
					$varSizeMotherTongue= sizeof($arrRetMotherTongue);
					?>
					<input type="hidden" name="mothertonguetxtfeature" value="<?=$varSizeMotherTongue;?>">
					<?
					if($varSizeMotherTongue==1) {?>
						<input type="hidden" name="motherTongue" value="<?=key($arrRetMotherTongue)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getMotherTongueLabel()?><span class="clr3">*</span></div>
						 <div class="fleft pfdivrt tlleft">
							<div class="fleft">
							<?  if($varSizeMotherTongue>1){?>
							<select class='srchselect' NAME='motherTongue' size='1' onblur='ChkEmpty(document.frmProfile.motherTongue, "select", "mothertong","Please select the mother tongue of the prospect");' onchange="motherTongueOther(this.value)">
								<?=$objCommon->getValuesFromArray($arrRetMotherTongue, "- Select -", "0", $varMotherTongueId);?>
							</select>
							<? } else { ?>
							<input type="text" name="motherTongueTxt" value="<?=$varMotherTongueText?>" size="30" maxlength="60" class="inputtext" onblur='ChkEmpty(document.frmProfile.motherTongueTxt, "text", "mothertong","Please enter the mother tongue of the prospect");'>
							<? } ?>
							</div>
						    <div id="motherTongueBranchDiv" class="fleft" style="display:<?=($varMotherTongueId==9997) ? block:none ?>; padding-left:10px;">
							 <div class="fright"> 
							   <input type="text" tabindex="<?=$varTabIndex++?>" onblur="motherothersChk();" name="motherTongueTxt" class="inputtext" value="<?=$varMotherTongueText?>">
							 </div>
						    </div>
						    <br clear="all"><span id="mothertong" class="errortxt"></span>
                         </div>
					   <br clear="all"/>
					<? } 
				}
			    ?>	
				
		
				<div class="pfdivlt smalltxt fleft tlright">Spoken Languages</div>
				<div class="fleft pfdivrt tlleft" ><select class='srchselect' NAME='spokenLanguages[]' size='5' MULTIPLE >
				<?=displaySelectedValuesFromArray($arrSpokenLangList, $varSpokenLanguagesString);?>
				</select><br><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				<br clear="all"/>
          		
		    		
				<? //if($varCommunityId != '2504') {?>
				<div class="normtxt clr bld fleft padl25 padt10">Cultural background</div><br clear="all"/>
				<? //} ?>
				
                
			    <?  if($varReligionFeature) {
				  $arrGetReligionOption = $objDomain->getReligionOption();
				  echo '<input type="hidden" name="religionOption" value="'.sizeof($arrGetReligionOption).'">';
				  if (sizeof($arrGetReligionOption)==1) { //For Hidden

					 echo '<input type="hidden" name="religion" value="'.key($arrGetReligionOption).'">';

				  } else { ?>
					<div class="pfdivlt smalltxt fleft tlright"><?=$objDomain->getReligionLabel()?><font class="clr3">*</font></div>
					<div class="pfdivrt smalltxt fleft tlleft">

					<? if (sizeof($arrGetReligionOption)>1) { ?>
					<select name="religion" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect fleft" onChange="funReligion();" onblur="religionChk();">
					<?=$objCommon->getValuesFromArray($arrGetReligionOption, "--- Select ---", "0", $varReligionId);?>
					</select><div class="fleft" style="display:<?=($varReligionId == 23)?"block":"none"?>" id="religionDivText" style="padding-left:10px;">&nbsp;&nbsp;&nbsp;<input type="text" name="religionOthers" onblur="religionOthersChk();" size="16" class="inputtext" value="<?=$varReligionText?>" tabindex="<?=$varTabIndex++?>" /></div>
					<? } else { ?><input type="text" name="religionText" tabindex="<?=$varTabIndex++?>" value=""><? } ?><br clear="all"><span id="religionspan" class="errortxt"></span></div><br clear="all"/>

			    <? } } ?>                

               <?
               if($varCasteFeature) {
                $arrRetReligion	= $objDomain->getReligionOption();
				if(sizeof($arrRetReligion)>1) {
					$arrGetCasteOption= $objDomain->getCasteOptionsForReligion($varReligionId);
				} else {
					$arrGetCasteOption= $objDomain->getCasteOption();
				}
				$varSizeCaste	= sizeof($arrGetCasteOption);
				echo '<input type="hidden" name="casteOption" value="'.$varSizeCaste.'">';
          
				if ($varSizeCaste==1) { //For Hidden

				echo '<input type="hidden" class="inputtext" size="35" name="caste" value="'.key($arrGetCasteOption).'" tabindex="'.$varTabIndex++.'">';

				} else {
				$varCasteLabel	= $objDomain->getCasteLabel();
				echo '<input type="hidden" name="castelabel" value="'.strtolower($varCasteLabel).'">';?>
				<div id="casteBlockDivId" style="display:<?=(($varReligion==2 && $varCommunityId==2007) || ($varReligion==6 && $varCommunityId==2008) || $varReligion==23)?"none":"block"?>">
				<div class="pfdivlt smalltxt fleft tlright">
					<? echo '<span id="branchDiv">'.$varCasteLabel.'</span>'; if($varIsCasteMandatory==1){echo '<font class="clr3">*</font>'; $varCasteOnBlur='onBlur="casteChk();"';}?>
				</div>
				<div class="pfdivrt smalltxt fleft tlleft">
				<? if ($varSizeCaste>1) { ?>
				<div class="fleft" id="casteDivId"><select class="srchselect" tabindex="<?=$varTabIndex++?>" name="caste" <?=$varCasteOnBlur?> onChange="funCaste('');casteOthersChk();">
				<?=$objCommon->getValuesFromArray($arrGetCasteOption, "--- Select ---", "0", $varCasteId);?>
				</select></div><div class="fleft disnon" id="casteDivText" style="display:<?=($varCasteId=='9997')?'block':'none'?>;padding-left:10px;"><input type="text" name="casteOthers" size="16" class="inputtext" style="width:215px;" value="<?=$varCasteText?>" tabindex="<?=$varTabIndex++?>" /></div><br clear="all">
				<? } else { ?> <div class="fleft" id="casteDivId"><input type="text" name="casteText" class="inputtext" size="35" value="<?=$varCasteText?>" tabindex="<?=$varTabIndex++?>" style="display:<?=($varReligionId>0)?'block':'none'?>"></div><div class="fleft disnon" id="casteDivText" style="display:none;padding-left:10px;"><input type="text" name="casteOthers" size="16" class="inputtext" style="width:215px;" value="" tabindex="<?=$varTabIndex++?>" /></div><br clear="all"> <? } ?><span id="castespan" class="errortxt"></span></div><br clear="all"/></div>
			<? }  }else{echo '<input type="hidden" name="casteOption" value=""><div class="fleft" id="casteDivId"></div>';} ?>

                <? if($objDomain->useHoroscope()) {
					$arrRetHoroscope	= $objDomain->getHoroscopeOption(); ?>
					<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getHoroscopeLabel()?></div>
					<div class="fleft pfdivrt tlleft">
						<? foreach($arrRetHoroscope as $key=>$value){
							$varChecked = ($key == $varHoroscopeMatch)?'checked':'';
							echo '<input type="radio" name=horoscope value="'.$key.'"  id="horoscope'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
						}?>
					</div><br clear="all"/>
				<? } ?>

				<div class="normtxt clr bld fleft padl25 padt10">Career</div><br clear="all"/>
				
                <div class="pfdivlt smalltxt fleft tlright">Education<font class="clr3">*</font></div>
			    <div class="pfdivrt smalltxt fleft tlleft">
				 <select name="educationCategory" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(educationCategory, 'select','educationcategoryspan','Please select the education category of the prospect');">
				   <option value="0">--- Select ---</option>
				<?
				foreach($arrEducationList as $key1 => $value1) {
	             echo "<optgroup label='".$value1."'>";
                 foreach( $arrEducationMapping as $key2 => $value2 ) {
                  if($value2 == $key1 ) {
	                if($key2 == $varEducationSubcategory) {
		              echo "<option value=$key2 selected>".$arrEducationSubList[$key2]."</option>";
		            }
	                else {
		              echo "<option value=$key2>".$arrEducationSubList[$key2]."</option>";
		            }
		          }
	             }
	             echo "</optgroup>";
                } ?>
				 </select><br><span id="educationcategoryspan" class="errortxt"></span>
			    </div><br clear="all">

				<div class="smalltxt fleft tlright pfdivlt"  >Education in Detail</div>
				<div class="fleft pfdivrt tlleft" ><input type=text name=educationInDetail size=32 maxlength=80 tabindex="<?=$varTabIndex++?>" value='<?=$varEducationDetail?>' class='inputtext'>
				</div><br clear="all"/>

			    <?php 
		        unset($arrGroupOccupationList['u']);unset($arrGroupOccupationList['v']);unset($arrGroupOccupationList['w']);
				?>
                <div class="smalltxt fleft tlright pfdivlt">Occupation<font class="clr3">*</font></div>
			    <div class="fleft pfdivrt tlleft"><div id='occdiv'>
					<select class='srchselect' NAME='occupation' size='1'  tabindex="<?=$varTabIndex++?>" onblur="ChkEmpty(occupation, 'select','occupationspan','Please select the occupation of the prospect');" onchange="selectOccupation(this.value);"> <option value="0">--- Select ---</option>
					  <?
					  foreach($arrGroupOccupationList as $key => $value) {
                        $Tmp_arrOccupationMapping = $arrOccupationMapping[$key];
	                    echo "<optgroup label='".$value."'>";
                        foreach( $Tmp_arrOccupationMapping as $value ) {
	                     if($value == $varOccupation) {
	                     	echo "<option value=$value selected>".$arrTotalOccupationList[$value]."</option>";
	                     }
		                 else {
		                    echo "<option value=$value>".$arrTotalOccupationList[$value]."</option>";
		                 }
	                    }
	                    echo "</optgroup>";
                     }?>	
					</select><br><span id="occupationspan" class="errortxt"></span>
				</div>
			    </div>


				<div class="smalltxt fleft tlright pfdivlt"  >Occupation in Detail</div>
				<div class="fleft pfdivrt tlleft" ><input type=text name='occupationInDetail' size=32 maxlength=80 value='<?=$varOccupationDtl;?>' class='inputtext' tabindex="<?=$varTabIndex++?>">
				</div><br clear="all"/>


				<? if($varUseEmployedIn) {
					$arrRetEmployedIn	= $objDomain->getEmployedInOption();
					$varSizeEmployedIn	= sizeof($arrRetEmployedIn);
					?>
					<input type="hidden" name="employedinOption" value="<?=$varSizeEmployedIn;?>">
					<?
					if($varSizeEmployedIn==1) {?>
						<input type="hidden" name="employmentCategory" value="<?=key($arrRetEmployedIn)?>">
					<?} else {?>
						<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getEmployedInLabel()?><font class="clr3">*</font></div>
						<div class="fleft smalltxt pfdivrt tlleft">
							<?	foreach($arrRetEmployedIn as $key=>$value){
									$varChecked = ($key == $varEmployedIn)?'checked':'';
									echo '<input type="radio" name=employmentCategory value="'.$key.'" id="employmentCategory'.$key.'" '.$varChecked.' onBlur="checkEmployment();" onClick="checkEmployment();"   onKeyPress="checkEmployment();" tabindex='.$varTabIndex++.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>&nbsp;&nbsp;&nbsp;';
							} ?>
							<br><span id="employmentCategoryspan" class="errortxt"></span>
						</div><br clear="all"/>
					<? }
				} ?>
                
				<? $varCurrencyDefaultValue ="- Select - "; ?>
				<div class="pfdivlt smalltxt fleft tlright">Annual income<font class="clr3">*</font></div>
			    <div class="pfdivrt smalltxt fleft tlleft">
				<select name="annualIncomeCurrency" size="1" tabindex="<?=$varTabIndex++?>" class="select1" onBlur="occupationChk();" style="width:180px;">
				<?=$objCommon->getValuesFromArray($arrSelectCurrencyList,$varCurrencyDefaultValue , "0", $varIncomeCurrency);?>
				</select>&nbsp; &nbsp;&nbsp;<input type="text" tabindex="<?=$varTabIndex++?>" name="annualIncome" value="<?=$varCurrencyVal?>" size="20" class="inputtext"  onKeypress="return allowNumeric(event);" onBlur="amountChk();"><br><span id="annualincomespan" class="errortxt"></span><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="112" height="1" /><span id="amountspan" class="errortxt"></span>
			    </div><br clear="all"/>
				<div class="smalltxt clr2 tlleft">Please add your income as it is considered one of the deciding factors for marriage. Please add digits only. You can use commas as separators. For Eg: 6,00,000 or 600000.</div><br clear="all"/>
               

             
			  <div class="normtxt clr bld fleft padl25 padt10" >Location</div><br clear="all"/>
				

			   <? if($varCommunityId=="2007") {?>
              <div class="smalltxt fleft tlright pfdivlt">Place Of Birth<font class="clr3">*</font></div>
			<div class="fleft pfdivrt tlleft">
				<select name="placeofbirth" size="1" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="placeofbirthChk();">
					<option value="0">--- Select ---</option>
					<option value="98" <?=$varCountry=='98' ? 'selected' : '';?>>India</option>
					<option value="222" <?=$varCountry=='222' ? 'selected' : '';?>>United States of America</option>
					<option value="195" <?=$varCountry=='195' ? 'selected' : '';?>>Sri Lanka</option>
					<option value="162" <?=$varCountry=='162' ? 'selected' : '';?>>Pakistan</option>
					<option value="220" <?=$varCountry=='220' ? 'selected' : '';?>>United Arab Emirates</option>
					<option value="129" <?=$varCountry=='129' ? 'selected' : '';?>>Malaysia</option>
					<option value="221" <?=$varCountry=='221' ? 'selected' : '';?>>United Kingdom</option>
					<option value="13" <?=$varCountry=='13' ? 'selected' : '';?>>Australia</option>
					<option value="185" <?=$varCountry=='185' ? 'selected' : '';?>>Saudi Arabia</option>
					<option value="39" <?=$varCountry=='39' ? 'selected' : '';?>>Canada</option>
					<option value="189" <?=$varCountry=='189' ? 'selected' : '';?>>Singapore</option>
					<option value="114" <?=$varCountry=='114' ? 'selected' : '';?>>Kuwait</option>
					<option value="">-------------------------</option>
					<?=$objCommon->getValuesFromArray($arrCountryList, "", "", $varCountryOfBirth);?>
				</select><br><span id="placeofbirthspan" class="errortxt"></span>
			</div><br clear="all"/>
             <? }?> 

			   <div class="smalltxt fleft tlright pfdivlt">Country Living in<span class="clr3">*</span></div>
			   <div class="fleft pfdivrt tlleft"><select name='country' class='srchselect' onChange='countryChk();'>
					<?
					  echo $objCommon->getValuesFromArray($arrCountryList, '- Select - ', '0', $varMemberInfo['Country']); 
				    ?>
				</select><br><span id="loccountry" class="errortxt"></span>
			   </div><br clear="all"/>

			   <div id='statecitydiv' class="fleft">
               <? if($varMemberInfo['Country'] == 195) { $varStateLable='District'; }   else {$varStateLable='Residing state';}?>
			   <div class="smalltxt fleft tlright pfdivlt" id="residspan"><?=$varStateLable?><span class="clr3">*</span></div>
			   <div class="fleft pfdivrt tlleft"><?if($varMemberInfo['Country'] == 98) { ?>
					<select name='residingState' id='residingState' class='srchselect' onChange='modrequestnew("<?=$varMemberInfo['Country']?>",this.value);' onblur='ChkEmpty(document.frmProfile.residingState, "select", "locresidingstate","Please select the resident state of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrResidingStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);?>
					</select>
				<? }
              else if($varMemberInfo['Country'] == 162) { ?>
					<select name='residingState' id='residingState' class='srchselect' onChange='modrequestnew("<?=$varMemberInfo['Country']?>",this.value);' onblur='ChkEmpty(document.frmProfile.residingState, "select", "locresidingstate","Please select the resident state of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrResidingPakistaniList, '- Select - ', '0', $varMemberInfo['Residing_State']);?>
					</select>
				<? }

			   else if($varMemberInfo['Country'] == 222) { ?>
					<select name='residingState' id='residingState' class='srchselect' onblur='ChkEmpty(document.frmProfile.residingState, "select", "locresidingstate","Please select the resident state of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrUSAStateList, '- Select - ', '0', $varMemberInfo['Residing_State']);?>
					</select>
				<? } 
			   
			   else if($varMemberInfo['Country'] == 195) { ?>
					<select name='residingState' id='residingState' class='srchselect' onblur='ChkEmpty(document.frmProfile.residingState, "select", "locresidingstate","Please select the district of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrResidingSrilankanList, '- Select - ', '0', $varMemberInfo['Residing_State']);?>
					</select>
				<? }
			   else { ?>
					<input type=hidden name='otherState' value='1'>
					<input type=text name='residingState' size=32 maxlength=40 id='residingState' class='inputtext' value='<?=$varMemberInfo['Residing_Area']?>' onblur='ChkEmpty(document.frmProfile.residingState, "text", "locresidingstate","Please enter the resident state of the prospect");'>
				<? } ?><br><span id="locresidingstate" class="errortxt"></span>
			</div><br clear="all"/>
			
			<? if($varMemberInfo['Country'] == 98 || $varMemberInfo['Country'] == 162) { $varLable='Residing City/District'; }   else {$varLable='Residing City';}?>
			<div class="smalltxt fleft tlright pfdivlt" id="residcitydist"><?=$varLable?><span class="clr3">*</span></div>
			<div class="fleft pfdivrt tlleft"><?if($varMemberInfo['Country'] == 98) { $varTmpState = ${$residingCityStateMappingList[$varMemberInfo['Residing_State']]}; ?>
					<select name='residingCity' id='residingCity' class='srchselect'  onblur='ChkEmpty(document.frmProfile.residingCity, "select", "locresidingcity","Please select the residing city of the prospect");'>
						<?=$objCommon->getValuesFromArray($varTmpState, '- Select - ', '0', $varMemberInfo['Residing_District']);?>
					</select>
				
				<? } else if($varMemberInfo['Country'] == 162) { $varTmpState = ${$residingPakiCityStateMappingList[$varMemberInfo['Residing_State']]}; ?>
					<select name='residingCity' id='residingCity' class='srchselect'  onblur='ChkEmpty(document.frmProfile.residingCity, "select", "locresidingcity","Please select the residing city of the prospect");'>
						<?=$objCommon->getValuesFromArray($varTmpState, '- Select - ', '0', $varMemberInfo['Residing_District']);?>
					</select>
				
				<? } else { ?>
				 <input type=hidden name='otherCity' value='1'>
				 <input type=text name='residingCity' id='residingCity' size=32 maxlength=40 class='inputtext' value='<?=$varMemberInfo['Residing_City']?>' onblur='ChkEmpty(document.frmProfile.residingCity, "text", "locresidingcity","Please enter the residing city of the prospect");'>
				
				<? } ?>
			    <br><span id="locresidingcity" class="errortxt"></span></div><br clear="all"/>
			    </div>


                <div id="showCitizenship" style="display:<?echo ($varMemberInfo['Country'] != 98)?'block;':'none;' ?>">
                <div class="smalltxt fleft tlright pfdivlt" >Citizenship<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft" ><select name='citizenship' class='srchselect' onblur='ChkEmpty(document.frmProfile.citizenship, "select", "loccitizenship","Please select the citizenship of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrCountryList, '- Select - ', '0', $varCitizenship);?>
					</select><br><span id="loccitizenship" class="errortxt"></span>
				</div><br clear="all"/>
				</div>

                <div id="showResidentStatus" style="display:<?echo ($confValues["DOMAINCASTEID"] != 2006)?'block;':'none;' ?>">
				<div class="smalltxt fleft tlright pfdivlt">Resident status<span class="clr3">*</span></div>
				<div class="fleft pfdivrt tlleft">
					<select name='residentStatus' class='srchselect' onblur='ChkEmpty(document.frmProfile.residentStatus, "select", "locresident","Please select the resident status of the prospect");'>
						<?=$objCommon->getValuesFromArray($arrResidentStatusList, '- Select - ', '0', $varResident_Status);?>
					</select><br><span id="locresident" class="errortxt"></span>
				</div><br clear="all"/>
				</div>
				
				<div class="smalltxt fleft tlright pfdivlt bld">A few lines about me</div>
				<div class="fleft pfdivrt tlleft">
						<!-- <font class="smalltxt tlleft"> Check Spelling &amp preview</font><br /> -->
						<textarea title='spellcheck' accesskey='<?=$confValues['SERVERURL']?>/spellchecker/spellchecker.php' style="resize: none;" id='description1' name='DESCDET' class='clr tareareg smalltxt' onfocus="alen=this.value;document.getElementById('desccount').innerHTML=alen.length;" onkeyup='alen=this.value;document.getElementById("desccount").innerHTML=alen.length;' onblur="ChkEmpty(document.frmProfile.DESCDET, 'textarea', 'aboutmyselfspan','Please enter your description.');alen=this.value;document.getElementById('desccount').innerHTML=alen.length;" /><?=$varAboutMyself?></textarea><span class="opttxt">Min. 50 characters</span><span id="desccount" style="padding-left:30px;" class="opttxt">0</span><span class="opttxt"> Characters typed</span><br><span id='aboutmyselfspan' class='errortxt'></span>
				</div><br clear="all"/>	

				<img src='<?=$confValues['IMGSURL']?>/trans.gif' width='1' height='1' onload='HaveChildnp(this);'>
				<div class="tlright padr20 padt10"><input type="submit" name='sbutton' value='Save' class='button'> &nbsp;
					<input type="reset" class="button" value="Reset">
				</div>
				
				
				</form><br>
				<? 
				// Edited By Mariyappan 
				if($varReligionFeature) {
					 if (sizeof($arrGetReligionOption)>1) {
					    echo '<script>funEditReligion();</script>';
					 }
				  }
				  if($varOccupation) {
					 echo '<script>selectOccupation(document.frmProfile.occupation.value);</script>';
				  }

				?>
				<? } ?>
			</div>
			<div style="display: none;">
				<font class="smalltxt">
				<script src="<?=$confValues['SERVERURL'];?>/spellchecker/cpaint/cpaint2.inc.compressed.js" type="text/javascript"></script>
				<script src="<?=$confValues['JSPATH']?>/spell_checker_compressed.js" type="text/javascript"></script>		
				</font>
			</div>
		</center>