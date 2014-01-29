<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : partnerinfodesc.php
#=====================================================================================================================================
# Description : display information of partner info. It has partner info form and update function partner information.
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId= $varGetCookieInfo["MATRIID"];
$sessPublish= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objDBMaster= new MemcacheDB;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['partnerinfosubmit'];

if($varUpdatePrimary == 'yes') {
	$varEditedFromAge			= $_REQUEST["fromAge"];
	$varEditedToAge				= $_REQUEST["toAge"];
	$varEditedLookingStatus		= $_REQUEST["lookingStatus"];
	$varEditedHaveChildren		= $_REQUEST["partnerHavechild"];
	$varEditedHeightFrom		= $_REQUEST["heightFrom"];
	$varEditedHeightTo			= $_REQUEST["heightTo"];
	$varEditedPhysicalStatus	= $_REQUEST["physicalStatus"];
	$varEditedIncludeReligion	= $_REQUEST["IncludeOtherReligion"];
	
	$varEditedMotherTongue		= ($_REQUEST['motherTongue']!='' && !in_array(0,$_REQUEST['motherTongue']))?join('~',$_REQUEST['motherTongue']):'0';
	$varEditedPartnerDescription= addslashes(strip_tags(trim($_REQUEST["partnerDescription"])));
	$varEditedReligion			= ($_REQUEST['religion']!='' && !in_array(0,$_REQUEST['religion']))?join('~',$_REQUEST['religion']):'0';
	$varEditedDenomination		= ($_REQUEST['denomination']!='' && !in_array(0,$_REQUEST['denomination']))?join('~',$_REQUEST['denomination']):'0';
	$varEditedCasteDivision		= ($_REQUEST['casteDivision']!='' && !in_array(0,$_REQUEST['casteDivision']))?join('~',$_REQUEST['casteDivision']):'0';
	$varEditedsubCaste			= ($_REQUEST['subCaste']!='' && !in_array(0,$_REQUEST['subCaste']))?join('~',$_REQUEST['subCaste']):'0';
	//$varEthnicity		= $_REQUEST["ethnicity"];  // removed from db
	 $varEditedManglik		    = join('~',$_REQUEST['manglik']);
	 $varEditedEatingHabits		= join('~',$_REQUEST['eatingHabits']);	
	//$varEditedEatingHabits		= $_REQUEST["eatingHabits"];
	 $varEditedSmokingHabits		= join('~',$_REQUEST['smokingHabits']);	
	//$varEditedSmokingHabits		= $_REQUEST["smokingHabits"];
	$varEditedDrinkingHabits		= join('~',$_REQUEST['drinkingHabits']);
	//$varEditedDrinkingHabits	= $_REQUEST["drinkingHabits"];
	$varEditedEducation			= ($_REQUEST['education']!='' && !in_array(0,$_REQUEST['education']))?join('~',$_REQUEST['education']):'0';
	$varEditedCitizenship		= ($_REQUEST['citizenship']!='' && !in_array(0,$_REQUEST['citizenship']))?join('~',$_REQUEST['citizenship']):'0';
	$varEditedCountryLivingIn	= ($_REQUEST['countryLivingIn']!='' && !in_array(0,$_REQUEST['countryLivingIn']))?join('~',$_REQUEST['countryLivingIn']):'0';
	$varEditedResidingIndia		= ($_REQUEST['residingIndia']!='')?join('~',$_REQUEST['residingIndia']):'0';
	$varEditedResidingUSA		= ($_REQUEST['residingUSA']!='')?join('~',$_REQUEST['residingUSA']):'0';	
	$varEditedResidingSrilanka	= ($_REQUEST['residingSrilanka']!='')?join('~',$_REQUEST['residingSrilanka']):'0'; //Added for srilanka
	$varEditedResidingPakistan	= ($_REQUEST['residingPakistan']!='')?join('~',$_REQUEST['residingPakistan']):'0'; //Added for Pakistan
	$varEditedPakistanDistrict  = ($_REQUEST['pakistanCity']!='')?join('~',$_REQUEST['pakistanCity']):'0';  //pakistan city
	$varEditedResidentStatus	= ($_REQUEST['residentStatus']!='' && !in_array(0,$_REQUEST['residentStatus']))?join('~',$_REQUEST['residentStatus']):'0';
    
   $varEditedResidentDistrict	= ($_REQUEST['residingCity']!='')?join('~',$_REQUEST['residingCity']):'0';
	$varPatternMatch	= '/[0-9]+#/';
	$varEditedResidentDistrict		= preg_replace($varPatternMatch, '', $varEditedResidentDistrict);
    /*$valStats='';
	$varEditedResidingIndia = '';
	$varEditedResidingUSA   = '';
	foreach($_REQUEST['residingIndia'] as $valStat) {
		    $valStats = $valStat;
			if($valStat<=100){
				$varEditedResidingIndia.= $valStats."~";
			}
			else {
				$varEditedResidingUSA.= $valStats."~";
			}
	}
	$varEditedResidingIndia = substr($varEditedResidingIndia,0,-1);
	$varEditedResidingUSA   = substr($varEditedResidingUSA,0,-1);*/
    
	$varEditedEmployedIn	= ($_REQUEST['employedIn']!='' && !in_array(0,$_REQUEST['employedIn']))?join('~',$_REQUEST['employedIn']):'0';
	$varEditedOccupation	= ($_REQUEST['occupation']!=''  && !in_array(0,$_REQUEST['occupation']))?join('~',$_REQUEST['occupation']):'0';
	$varEditedGothram	= ($_REQUEST['gothram']!=''  && !in_array(0,$_REQUEST['gothram']))?join('~',$_REQUEST['gothram']):'';
	$varEditedStar	= ($_REQUEST['star']!=''  && !in_array(0,$_REQUEST['star']))?join('~',$_REQUEST['star']):'0';
	$varEditedRaasi	= ($_REQUEST['raasi']!=''  && !in_array(0,$_REQUEST['raasi']))?join('~',$_REQUEST['raasi']):'0';
    
	$varCountryChk = explode('~',$varEditedCountryLivingIn);
	if(trim($_REQUEST['FROMINCOME'])!= 0 && in_array(98,$varCountryChk)){
	    $varStIncome			= $_REQUEST['FROMINCOME'];
	}else if(trim($_REQUEST['FROMUSCOME'])!= 0){
		$varStIncome			= $_REQUEST['FROMUSCOME'];
	}
	if(trim($_REQUEST['TOINCOME'])!= 0 && in_array(98,$varCountryChk)){
	    $varEndIncome			= $_REQUEST['TOINCOME'];
	}else if(trim($_REQUEST['TOUSCOME'])!= 0 ){
		$varEndIncome			= $_REQUEST['TOUSCOME'];
	}



	//CONTROL STATEMENT
    $varEditedLookingStatusValue= join('~',$varEditedLookingStatus);	
 	if($sessMatriId != '')
	{
		
		//find member has partner info or not
		$argFields				= array('MatriId');
		$argCondition			= "WHERE MatriId='".$sessMatriId."'";
		$varChkMemberResultSet	= $objDBSlave->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
		$varChkMemberInfo		= mysql_fetch_array($varChkMemberResultSet);

		if($varChkMemberInfo['MatriId'] == '') {
			$argFields 			= array('MatriId');
			$argFieldsValues	= array("'".$sessMatriId."'");
			$varInsertedId		= $objDBMaster->insert($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues);
		}

		if($varEditedCountryLivingIn == 0){
            $varEditedResidingIndia    = 0;
			$varEditedResidingUSA      = 0;
			$varEditedResidentDistrict = 0;

		}
        
		//Direct updatation for array field
		$argFields 				= array('Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Physical_Status','Education','Religion','Denomination','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country',		'Resident_India_State','Resident_USA_State','Resident_Srilanka_State','Resident_Pakistan_State','Resident_Pakistan_District','Resident_Status','IncludeOtherReligion','Mother_Tongue','Eating_Habits','Drinking_Habits','Smoking_Habits','Date_Updated','Resident_District','Employed_In','Occupation','GothramId','Star','Raasi','StIncome','EndIncome');
		$argFieldsValues		= array("'".$varEditedFromAge."'","'".$varEditedToAge."'","'".$varEditedLookingStatusValue."'","'".$varEditedHaveChildren."'","'".$varEditedHeightFrom."'","'".$varEditedHeightTo."'","'".$varEditedPhysicalStatus."'","'".$varEditedEducation."'","'".$varEditedReligion."'","'".$varEditedDenomination."'","'".$varEditedCasteDivision."'","'".$varEditedsubCaste."'","'".$varEditedManglik."'","'".$varEditedCitizenship."'","'".$varEditedCountryLivingIn."'","'".$varEditedResidingIndia."'","'".$varEditedResidingUSA."'","'".$varEditedResidingSrilanka."'","'".$varEditedResidingPakistan."'","'".$varEditedPakistanDistrict."'","'".$varEditedResidentStatus."'","'".$varEditedIncludeReligion."'","'".$varEditedMotherTongue."'","'".$varEditedEatingHabits."'","'".$varEditedDrinkingHabits."'","'".$varEditedSmokingHabits."'",'NOW()',"'".$varEditedResidentDistrict."'","0","'".$varEditedOccupation."'","'".$varEditedGothram."'","'".$varEditedStar."'","0","'".$varStIncome."'","'".$varEndIncome."'");		
		$argCondition			= "MatriId = '".$sessMatriId."'";
		//update1($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);
	    $varUpdateId			= $objDBMaster->update($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);
		//echo $argFieldsValues;
		
		//Direct updatation for array field
		$argFields 			= array('Partner_Set_Status');
		$argFieldsValues	= array(1);
		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		// NOT VALIDATED MEMBER COMMIT OTHER DETAILS DIRECTLY
		if($sessPublish == 0 || $sessPublish == 4) {
			$argFields 			= array('Partner_Description');
			$argFieldsValues	= array("'".$varEditedPartnerDescription."'");
			$argCondition		= "MatriId = '".$sessMatriId."'";
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues,$argCondition);

			if($sessPublish == 4) {
				$argFields		= array('Publish');
				$argFieldsValues= array('0');
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
			}
		} else {	
			if(trim($_REQUEST['oldpartnerdesc']) != trim($varEditedPartnerDescription)) {
				$argFields 			= array('MatriId');
				$argFieldsValues	= array("'".$sessMatriId."'");
				$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

				$argFields 			= array('Partner_Description','Date_Updated');
				$argFieldsValues	= array("'".$varEditedPartnerDescription."'",'NOW()');
				$argCondition		= "MatriId = '".$sessMatriId."'";
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

				$argFields 			= array('Pending_Modify_Validation','Partner_Set_Status');
				$argFieldsValues	= array(1,1);
				$argCondition		= "MatriId = '".$sessMatriId."'";
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}
		}

		$argFields 			= array('Date_Updated','Time_Posted');
		$argFieldsValues	= array('NOW()','NOW()');
		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
		
		if($varEditedLookingStatusValue==1){
           $varEditedHaveChildren = 0;
		}
		$varPartnerDetails	= $varEditedFromAge.'~'.$varEditedToAge.'^|'.$varEditedHeightFrom.'~'.$varEditedHeightTo.'^|'.$varEditedLookingStatusValue.'^|'.$varEditedPhysicalStatus.'^|'.$varEditedMotherTongue.'^|'.$varEditedReligion.'^|'.$varEditedCasteDivision.'^|'.$varEditedEatingHabits.'^|'.$varEditedEducation.'^|'.$varEditedCitizenship.'^|'.$varEditedCountryLivingIn.'^|'.$varEditedResidingIndia.'^|'.$varEditedResidingUSA.'^|'.$varEditedResidentStatus.'^|'.$varEditedSmokingHabits.'^|'.$varEditedDrinkingHabits.'^|'.$varEditedsubCaste.'^|'.$varEditedDenomination.'^|'.$varEditedHaveChildren.'^|0^|'.$varEditedOccupation.'^|'.$varEditedGothram.'^|'.$varEditedStar.'^|0^|'.$varEditedManglik.'^|'.$varEditedResidentDistrict.'^|'.$varEditedIncludeReligion.'^|'.$varStIncome.'^|'.$varEndIncome.'^|'.$varEditedResidingSrilanka;

		setrawcookie("partnerInfo",$varPartnerDetails, "0", "/",$confValues['DOMAINNAME']);
		
		header("Location: index.php?act=partnerinfodesc&editpartner=yes");
		exit;
	}
}
$objDBSlave->dbClose();
$objDBMaster->dbClose();
?>