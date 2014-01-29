<?php
ini_set("memory_limit","1024M");
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/conf/dbainfo.cil14');
include_once($varBaseRoot.'/conf/domainlist.cil14');
include_once($varBaseRoot."/lib/clsDataConversion.php");

//OBJECT DECLARTION
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

//1=>Muslim, 2=>Christian, 3=>Sikh, 4=>Jain, 5=>Buddhist, 6=>Divorcee

$varPublishedDate = date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-30, date('Y')));
$varPublishedDate2 = date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-1, date('Y')));
for($II=1; $II<=11; $II++){

$varCond			= '';
$varReligion		= 0;
$varDomainId		= '';
$arrDenomination	= array();
$arrDenomination2	= array();
$arrCaste			= array();

if($II == 1){
	//MUSLIM RELIGION 
	
	$varCond		= "WHERE mp.MatriId=li.MatriId  AND Religion IN(2, 10, 11) AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";

	//$varCond		= "WHERE mp.MatriId=li.MatriId  AND Religion IN(2, 10, 11) AND mp.ProfilePublishedOn>='2009-10-12 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	$varReligion	= 2;
	$varDomainId	= 2503;
	$arrDenomination	= array(2=>9997,10=>2,11=>1);
	$arrCaste			= array(406=>1000,410=>1001,419=>1002);

}else if($II == 2){
	//CHRISTIAN RELIGION
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion IN(3, 12, 13, 14) AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";

	//$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion IN(3, 12, 13, 14) AND mp.ProfilePublishedOn>='2009-10-22 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	$varReligion	= 3;
	$varDomainId	= 2500;
	$arrDenomination	= array(3=>9997,12=>12,13=>29,14=>31);
	$arrDenomination2	= array(501=>9,502=>10,503=>14,504=>16,505=>17,506=>12,507=>12,508=>17,509=>20, 510=>23,511=>24,512=>9997,513=>30,514=>12,515=>35,516=>17,517=>29,518=>34,519=>9997);
	$arrCaste			= array(109=>109,111=>111,116=>12,125=>125,137=>137,176=>176,214=>214,63=>63,2=>2,8=>58,506=>506,507=>507,508=>508);

}else if($II == 3){
	//SIKH RELIGION
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion=4 AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";

	//$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion=4 AND mp.ProfilePublishedOn>='2009-11-02 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	$varReligion	= 4;
	$varDomainId	= 2502;
	$arrCaste		= array(0=>9998,651=>651,652=>652,653=>653,654=>654,655=>655,656=>656,657=>657,658=>658,659=>659,660=>660, 
    661=>661,662=>661,663=>663,664=>664,665=>665,666=>666,667=>667,668=>9997,999=>9997);

}else if($II == 4){
	//JAIN RELIGION
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion IN(5, 15, 16) AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";

	//$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion IN(5, 15, 16) AND mp.ProfilePublishedOn>='2009-11-02 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	$varReligion	= 5;
	$varDomainId	= 2501;
	$arrDenomination	= array(16=>36,15=>37,5=>9997);
	$arrCaste			= array(601=>1016,602=>1021,603=>1022,604=>1017,605=>1018,606=>1021,607=>1023,608=>1019,609=>1021,610=>1020,611=>1023,612=>1021,999=>1021);

}else if($II == 5){
	//BUDDHIST RELIGION
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion=7 AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	
	//$varCond		= "WHERE mp.MatriId=li.MatriId AND Religion=7 AND mp.ProfilePublishedOn>='2009-11-02 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	$varReligion	= 7;
	$varDomainId	= 2504;
}else if($II == 6){
	//DIVORCEE RELIGION
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND MaritalStatus IN(3, 4) AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	
	//$varCond		= "WHERE mp.MatriId=li.MatriId AND  MaritalStatus IN(3, 4) AND mp.ProfilePublishedOn>='2009-09-01 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	$varDomainId	= 2001;
}else if($II == 7){
	//ABILITY MATRIMONY
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND SpecialCase=1 AND mp.ProfilePublishedOn>='".$varPublishedDate2." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate2." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	//$varCond		= "WHERE mp.MatriId=li.MatriId AND SpecialCase=1 AND mp.ProfilePublishedOn>='2010-04-12 00:00:00' AND mp.ProfilePublishedOn<='2010-05-05 23:59:59' ORDER BY ProfilePublishedOn ASC";
	
	$varDomainId	= 2002;
}else if($II == 8){
	//MANGLIK MATRIMONY
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND Dosham=1 AND Religion IN(1,4,5,8,9,15,16) AND mp.ProfilePublishedOn>='".$varPublishedDate2." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate2." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	//$varCond		= "WHERE mp.MatriId=li.MatriId AND Dosham=1 AND Religion IN(1,4,5,8,9,15,16) AND mp.ProfilePublishedOn>='2010-04-27 00:00:00' AND mp.ProfilePublishedOn<='2010-05-05 23:59:59' ORDER BY ProfilePublishedOn ASC";

	$varDomainId	= 2003;
}else if($II == 9){
	//ANYCASTE MATRIMONY
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND mp.Caste=0 AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	
	$varDomainId	= 2004;
}else if($II == 10){
	//40PLUS MATRIMONY
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND ((mp.Gender='M' AND mp.Age>=40) OR (mp.Gender='F' AND mp.Age>=35)) AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	
	$varDomainId	= 2000;
}else if($II == 11){
	//DEFENCE MATRIMONY
	
	$varCond		= "WHERE mp.MatriId=li.MatriId AND mp.OccupationCategory=2 AND mp.CountrySelected=98 AND mp.OccupationSelected IN(53,54,55) AND mp.ProfilePublishedOn>='".$varPublishedDate2." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate2." 23:59:59' ORDER BY ProfilePublishedOn ASC";
	
	$varDomainId	= 2006;
}



for($JJ=0; $JJ<1; $JJ++){

$varRecsCnt		= 100000;
$varStartLimit  = $JJ*$varRecsCnt;

$varFirstWhereCond	= $varCond.' LIMIT '.$varStartLimit.', '.$varRecsCnt;

#SELECT DATAS FROM matrimonyprofile
$varBMTable		= $varDbaInfo['DATABASE'].'.bm_matrimonyprofile mp, '.$varDbaInfo['DATABASE'].'.bm_logininfo li';

$varFields		= array('mp.MatriId', 'Status', 'Authorized', 'Validated', 'EntryType', 'SpecialPriv', 'Name', 'Age', 'DayOfBirth', 'MonOfBirth', 'YearOfBirth', 'Gender', 'MaritalStatus', 'NoOfChildren', 'ChildrenLivingStatus', 'InCms', 'Height', 'BodyType', 'Complexion', 'BloodGroup', 'InLbs', 'Weight', 'SpecialCase', 'MotherTongue', 'MotherTongueOthers', 'Religion', 'Caste', 'CasteOthers', 'SubCaste', 'SubCasteId', 'CasteNoBar', 'Gothra', 'GothraId', 'Star', 'Raasi', 'Dosham', 'EatingHabits', 'SmokingHabits', 'DrinkingHabits', 'EducationSelected', 'EducationId', 'Education', 'OccupationCategory', 'OccupationSelected', 'Occupation', 'IncomeCurrency', 'AnnualIncome', 'Citizenship', 'CountrySelected', 'ResidentStatus', 'ResidingState', 'ResidingArea', 'ResidingDistrict', 'ResidingCity', 'PhoneProtected', 'ProfileDescription', 'HobbiesAvailable', 'FiltersAvailable', 'MobileAlertsAvailable', 'PhotoAvailable', 'PhotoProtected', 'HoroscopeAvailable', 'HoroscopeProtected', 'BirthDetailsAvailable', 'HoroscopeMatch', 'PartnerPrefSet', 'LastLogin', 'TimePosted', 'NumberOfPayments', 'LastPayment', 'ValidDays', 'ExpiryDate', 'TimeCreated', 'ByWhom', 'ReferredBy', 'IpAddress', 'Comments', 'ActivityRank', 'Password', 'Email');

$varFields1		= array('MatriId', 'Status', 'Authorized', 'Validated', 'EntryType', 'SpecialPriv', 'Name', 'Age', 'DayOfBirth', 'MonOfBirth', 'YearOfBirth', 'Gender', 'MaritalStatus', 'NoOfChildren', 'ChildrenLivingStatus', 'InCms', 'Height', 'BodyType', 'Complexion', 'BloodGroup', 'InLbs', 'Weight', 'SpecialCase', 'MotherTongue', 'MotherTongueOthers', 'Religion', 'Caste', 'CasteOthers', 'SubCaste', 'SubCasteId', 'CasteNoBar', 'Gothra', 'GothraId', 'Star', 'Raasi', 'Dosham', 'EatingHabits', 'SmokingHabits', 'DrinkingHabits', 'EducationSelected', 'EducationId', 'Education', 'OccupationCategory', 'OccupationSelected', 'Occupation', 'IncomeCurrency', 'AnnualIncome', 'Citizenship', 'CountrySelected', 'ResidentStatus', 'ResidingState', 'ResidingArea', 'ResidingDistrict', 'ResidingCity', 'PhoneProtected', 'ProfileDescription',  'HobbiesAvailable', 'FiltersAvailable',  'MobileAlertsAvailable', 'PhotoAvailable', 'PhotoProtected', 'HoroscopeAvailable', 'HoroscopeProtected', 'BirthDetailsAvailable', 'HoroscopeMatch', 'PartnerPrefSet', 'LastLogin', 'TimePosted', 'NumberOfPayments', 'LastPayment', 'ValidDays', 'ExpiryDate', 'TimeCreated', 'ByWhom', 'ReferredBy', 'IpAddress', 'Comments', 'ActivityRank', 'Password', 'Email');

$varBMMPDetails	= $objDC->select($varBMTable, $varFields, $varFirstWhereCond, 0);

$i = 0;
$arrBMDetails	= array();
while($row = mysql_fetch_assoc($varBMMPDetails))
{
	foreach($varFields1	as $varSingVal)
	{
		$arrBMDetails[$i][$varSingVal] = $row[$varSingVal];
	}
	$i++;
}
$varNoOfRecords	= $i; 

//Create txt file for get photos from BM db
$varBMPhotoFile	= $varRootPath.'/data-conversion/photo-lists/bm-photos-list'.$JJ.'.txt';
$varBMHoroFile	= $varRootPath.'/data-conversion/photo-lists/bm-horoscope-list'.$JJ.'.txt';
$varProductFile	= $varRootPath.'/data-conversion/photo-lists/product-photos-list'.$JJ.'.txt';
$varProInfoFile = $varRootPath.'/data-conversion/pro-user-info'.$JJ.'.txt';
$varProtectFile	= $varRootPath.'/data-conversion/photo-protect-info'.$JJ.'.txt';
$varHoroFile	= $varRootPath.'/data-conversion/horoscope-info'.$JJ.'.txt';

$varCurrentDate	= date('Y-m-d');
//Delete photo based txt files
if($II == 1){
	if(file_exists($varBMPhotoFile) && date("Y-m-d", filemtime($varBMPhotoFile)) != $varCurrentDate)
	@unlink($varBMPhotoFile);
	if(file_exists($varBMHoroFile) && date("Y-m-d", filemtime($varBMHoroFile)) != $varCurrentDate)
	@unlink($varBMHoroFile);
	if(file_exists($varProductFile) && date("Y-m-d", filemtime($varProductFile)) != $varCurrentDate)
	@unlink($varProductFile);
	if(file_exists($varProInfoFile) && date("Y-m-d", filemtime($varProInfoFile)) != $varCurrentDate)
	@unlink($varProInfoFile);
	if(file_exists($varProtectFile) && date("Y-m-d", filemtime($varProtectFile)) != $varCurrentDate)
	@unlink($varProtectFile);
	if(file_exists($varHoroFile) && date("Y-m-d", filemtime($varHoroFile)) != $varCurrentDate)
	@unlink($varHoroFile);
}

$varBMPhotoFileHandler = fopen($varBMPhotoFile,'a');
$varBMHoroFileHandler  = fopen($varBMHoroFile,'a');
$varProductFileHandler = fopen($varProductFile,'a');
$varProUserFileHandler = fopen($varProInfoFile,'a');
$varProtectFileHandler = fopen($varProtectFile,'a');
$varHoroFileHandler	   = fopen($varHoroFile,'a');

//INSERTION AREA STARTS HERE
for($i=0;$i<$varNoOfRecords;$i++)
{
	//Initiate variables for each time
	$varDob			= '';
	$varProUserInfo	= '';
	$varCurrDateTime= date('Y-m-d H:i:s');

	if($varDomainId == ''){ continue;}

	//Get paid status and valid days
	$varDatePaid	= '0000-00-00 00:00:00';
	$varPaidStatus	= 0;
	$varExpiryDate	= '0000-00-00 00:00:00';
	$varSpecialPriv = 0;
	$varValidDays	= 0;
	$varBMPaidStat	= $arrBMDetails[$i]['EntryType'];
	$varOldMatriId	= $arrBMDetails[$i]['MatriId'];
	
	//CHECK ALREADY ADDED OR NOT
	$varCheckAlreadyAdded	= $objDC->checkAlreadyAdded($varOldMatriId, $varDomainId);
	
	if($varCheckAlreadyAdded == 'no'){
	//CREATE username
	$varNewUsername	= '';
	$varNewUsername	= $arrMatriIdPre[$varDomainId].'-'.$varOldMatriId;

	//CREATE Password
	$varPassword	= '';
	//$varPassword	= $objDC->createPassword();
	$varPassword	= $arrBMDetails[$i]['Password'];

	//Generate MatriId
	$varNewMatriId	= '';
	$varNewMatriId	= $objDC->generateMatriId($varDomainId, $arrMatriIdPre[$varDomainId]);

	if(strlen($varNewMatriId)>=9){
	//Member's Email
	$varEmail		= $arrBMDetails[$i]['Email'];

	//INSERT INTO memberinfo
	$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberlogininfo';
	$varFields		= array('MatriId', 'Email', 'Password', 'User_Name', 'Date_Updated', 'CommunityId');
	$varFieldsValues= array("'".$varNewMatriId."'", "'".$varEmail."'", "'".$varPassword."'", "'".$varNewUsername."'", "'".$varCurrDateTime."'", "'".$varDomainId."'");
	$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	
	
	//Write Old & New BM migrated profile informations
	$varProUserInfo	= $varOldMatriId.'~'.$varNewMatriId.'~'.$arrBMDetails[$i]['Name'].'~'.$varPassword.'~'. $varEmail.'~'.$varPaidStatus."\n";
	fwrite($varProUserFileHandler, $varProUserInfo);
	
	#SELECT DATAS FROM contactinfo
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_assuredcontact';
	$varFields		= array('PinNo', 'TimeGenerated', 'CountryCode', 'AreaCode', 'PhoneNo', 'MobileNo', 'PhoneNo1', 'PhoneStatus1', 'ContactPerson1', 'Relationship1', 'Timetocall1', 'DateConfirmed', 'VerifiedFlag', 'Description', 'VerificationSource', 'ThruRegistration');
	$varBMCond		= "WHERE MatriId='".$varOldMatriId."'";
	$varSelContDet	= $objDC->select($varBMTable, $varFields, $varBMCond, 1);

	$varPhoneVerified	= 0;
	if(count($varSelContDet)==1){$varPhoneVerified	= 1;}
	
	#SELECT DATAS FROM matchwatch
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_matchwatch';
	$varFields		= array('StAge','EndAge','MatchMaritalStatus','HavingChildren', 	'StHeight','EndHeight','PhysicalStatus','MotherTongue','MatchReligion','MatchCaste','PartnerDescription', 'MatchEducation','EatingHabitsPref','MatchCitizenship','MatchCountry','MatchResidentStatus','MatchIndianStates','MatchUSStates', 'SysStAge', 'SysEndAge', 'SysStHeight', 'SysEndHeight', 'SysMatchEducation', 'SysMatchCitizenship', 'SysMatchCountry', 'SysMotherTongue', 'SysMatchMaritalStatus', 'SysHavingChildren', 'SysPhysicalStatus', 'SysMatchResidentStatus', 'SysMatchIndianStates', 'SysMatchUSStates', 'SysMatchReligion', 'SysMatchCaste');
	$varMatchWatchDetails	= $objDC->select($varBMTable, $varFields, $varBMCond, 1);

	#SELECT DATAS FROM horodetails
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_horodetails';
	$varFields		= array('BirthDay','BirthMonth','BirthYear');
	$varSelectDobDetails	= $objDC->select($varBMTable, $varFields, $varBMCond, 1);
	
	#SELECT DATAS FROM familyinfo
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_familyinfo';
	$varFields		= array('FamilyValue', 'FamilyType', 'FamilyStatus', 'FatherOccupation', 'MotherOccupation', 'AncestralOrigin', 'Brothers', 'Sisters', 'BrothersMarried', 'SistersMarried', 'Familydescription');
	$varSelectFamilyInfoDetails	= $objDC->select($varBMTable, $varFields, $varBMCond, 1);

	#SELECT DATAS FROM hobbiesinfo
	$varSelectHobbiesInfoDetails= array();
	$varHobbiesFlag= $arrBMDetails[$i]['HobbiesAvailable'];
	if($varHobbiesFlag == 1){
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_hobbiesinfo';
	$varFields		= array('HobbiesSelected', 'HobbiesOthers', 'InterestsSelected', 'InterestsOthers', 'MusicSelected', 'MusicOthers', 'BooksSelected', 'BooksOthers', 'MoviesSelected', 'MoviesOthers', 'SportsSelected', 'SportsOthers', 'FoodSelected', 'FoodOthers', 'DressStyleSelected', 'DressStyleOthers', 'LanguagesSelected', 'LanguagesOthers');
	$varSelectHobbiesInfoDetails= $objDC->select($varBMTable, $varFields, $varBMCond, 1);
	}
	
	$varMobileAltFlag = 0;
	#SELECT DATAS FROM mobilealerts
	$varSelectMoblieAlertsInfo= array();
	$varMobileAltFlag	= $arrBMDetails[$i]['MobileAlertsAvailable'];
	if($varMobileAltFlag == 1){
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_mobilealerts';
	$varFields		= array('Service','MobileNo','MatchWatchEnabled','NewMsgEnabled','NewInterestEnabled','Status','DateRegistered');
	$varSelectMoblieAlertsInfo= $objDC->select($varBMTable, $varFields, $varBMCond, 1);
	}

	#SELECT DATAS FROM photoinfo
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_photoinfo';
	$varFields		= array('PhotoURL1', 'PhotoURL2', 'PhotoURL3', 'PhotoURL4', 'PhotoURL5', 'PhotoURL6', 'PhotoURL7', 'PhotoURL8', 'PhotoURL9', 'PhotoURL10', 'ThumbImgs1', 'ThumbImgs2', 'ThumbImgs3', 'ThumbImgs4', 'ThumbImgs5', 'ThumbImgs6', 'ThumbImgs7', 'ThumbImgs8', 'ThumbImgs9', 'ThumbImgs10', 'ThumbImg1','ThumbImg2','ThumbImg3', 'ThumbImg4','ThumbImg5','ThumbImg6', 'ThumbImg7','ThumbImg8','ThumbImg9', 'ThumbImg10', 'PhotoStatus1', 'PhotoStatus2', 'PhotoStatus3', 'PhotoStatus4', 'PhotoStatus5', 'PhotoStatus6', 'PhotoStatus7', 'PhotoStatus8', 'PhotoStatus9', 'PhotoStatus10', 'PhotoDescription1', 'PhotoDescription2', 'PhotoDescription3', 'PhotoDescription4', 'PhotoDescription5', 'PhotoDescription6', 'PhotoDescription7', 'PhotoDescription8', 'PhotoDescription9', 'PhotoDescription10', 'PhotoProtected', 'Photo_ProtectedPassword', 'Horoscope_ProtectedPassword', 'HoroscopeDescription', 'HoroscopeURL', 'HoroscopeStatus', 'HoroscopeProtected', 'DateUpdated');
	$varSelectPhotoInfoDetails	= $objDC->select($varBMTable, $varFields, $varBMCond, 1);

	#SELECT DATAS FROM filterinfo
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_filterinfo';
	$varFields		= array('Religion','Caste','MaritalStatus','AgeAbove','AgeBelow','Country','MotherTongue','DateUpdated');
	$varSelectFilterInfoDetails	= $objDC->select($varBMTable, $varFields, $varBMCond, 1);
	
	#------------------------------memberinfo STARTS HERE-------------------------------------#
   	$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberinfo';
	$varFields		= array('MatriId', 'User_Name', 'BM_MatriId', 'BM_Paid_Status', 'Name', 'Age', 'Dob', 'Gender', 'Height', 'Height_Unit', 'Weight', 'Weight_Unit', 'Body_Type', 'Complexion', 'Physical_Status', 'Blood_Group', 'Marital_Status', 'No_Of_Children', 'Children_Living_Status', 'Education_Category', 'Education_Subcategory', 'Education_Detail', 'Employed_In', 'Occupation', 'Occupation_Detail', 'Income_Currency', 'Annual_Income', 'Religion', 'Denomination', 'CommunityId', 'CasteId', 'Caste_Nobar', 'SubcasteId', 'SubcasteText', 'Mother_TongueId', 'Mother_TongueText', 'GothramId', 'GothramText', 'Star', 'Raasi', 'Horoscope_Match', 'Chevvai_Dosham', 'Resident_Status', 'Country', 'Citizenship', 'Residing_State', 'Residing_Area', 'Residing_District', 'Residing_City', 'Contact_Address', 'Contact_Phone', 'Contact_Mobile', 'About_Myself', 'Eating_Habits', 'Smoke', 'Drink', 'IPAddress', 'Profile_Created_By', 'Profile_Referred_By', 'Publish', 'Paid_Status', 'Special_Priv', 'Last_Login', 'Phone_Verified', 'Phone_Protected', 'Hobbies_Available', 'Mobile_Alerts_Available', 'Birth_Details_Available', 'Date_Created', 'Time_Posted', 'Last_Payment', 'Valid_Days', 'Expiry_Date', 'Activity_Rank', 'Date_Updated', 'Support_Comments', 'Partner_Set_Status');

	$varAge	= $arrBMDetails[$i]['Age'];
		
	//CALCULATE AGE USING DOB
	$varDay		= $varSelectDobDetails[0]['BirthDay'];
	$varMonth	= $varSelectDobDetails[0]['BirthMonth'];
	$varYear	= $varSelectDobDetails[0]['BirthYear'];
	if(checkdate($varMonth,$varDay,$varYear))
	{
		$varDob		= $varYear.'-'.$varMonth.'-'.$varDay;
		/*$varArrCurrentDate	= explode('-',$varCurrentDate);
		$varYearDiff		= $varArrCurrentDate[0] - $varYear;
		$varMonthDiff		= $varArrCurrentDate[1] - $varMonth;
		$varDayDiff			= $varArrCurrentDate[2] - $varDay;
		$varMonthDiff		= $varMonthDiff != 0 ? $varMonthDiff :($varDayDiff < 0) ? -1 : 1;
		$varAge				= $varMonthDiff < 0 ? $varYearDiff : ($varYearDiff+1);*/
	}

	//GENDER CONVERSION
	$varGender = $arrBMDetails[$i]['Gender']=='M' ? 1 : 2; 

	$varAge		= ($varAge<18 && $varGender==2) ? 18 : $varAge;
	$varAge		= ($varAge<21 && $varGender==1) ? 21 : $varAge;
	
	//HIGHT & WEIGHT CONVERSION
	$varHeight		= $arrBMDetails[$i]['Height']; 
	$varHeightUnit	= $arrBMDetails[$i]['InCms'] ? 'cm' :'feet-inches';
	$varWeight		= $arrBMDetails[$i]['Weight']; 
	$varWeightUnit	= $arrBMDetails[$i]['InLbs'] ? 'lbs' :'kg';
	if($varWeightUnit == 'kg')
	{
		$varWeight	= round($varWeight / 2.2);
	}
	
	$varMaritalStatus		= $arrBMDetails[$i]['MaritalStatus']; 
	$varEducationSelected	= $arrBMDetails[$i]['EducationSelected']; 
	$varEducationId			= $arrBMDetails[$i]['EducationId']; 
	$varOccupationSelected	= $arrBMDetails[$i]['OccupationSelected'];

	//Religion changes
	$varReligion	= ($varReligion == 0) ? $arrBMDetails[$i]['Religion'] : $varReligion;

	//Denomination & Caste changes
	if($II>=1 && $II <=5){
		//Denimination
		if($II!=2){
			$varDenomination = $arrDenomination[$arrBMDetails[$i]['Religion']];
		}else{
			$varDenomination = $arrDenomination2[$arrBMDetails[$i]['Caste']];
			if($varDenomination==''){
				$varDenomination = $arrDenomination[$arrBMDetails[$i]['Religion']];
			}
		}
		
		if($varDenomination==''){
			$varDenomination = 0;
		}

		//Caste
		$varCaste	= $arrCaste[$arrBMDetails[$i]['Caste']];

		if($varCaste==''){
			$varCaste = 0;
		}

	}else{
		$varReligion = $arrBMDetails[$i]['Religion'];
		$varDenomination	= 0;
		$varCaste	= $arrBMDetails[$i]['Caste'];
	}


	$varCasteNobar		= $arrBMDetails[$i]['CasteNoBar'];
	$varSubcasteTxt		= addslashes(stripslashes($arrBMDetails[$i]['SubCaste']));
	$varSubcasteId		= $arrBMDetails[$i]['SubCasteId'];
	$varMotherTongue	= $arrBMDetails[$i]['MotherTongue'];
	$varMotherTongueTxt	= $arrBMDetails[$i]['MotherTongueOthers'];
	$varGothramId		= $arrBMDetails[$i]['GothraId'];
	$varGothramText		= addslashes(stripslashes($arrBMDetails[$i]['Gothra']));
	$varStar			= $arrBMDetails[$i]['Star']; 
	$varRaasi			= $arrBMDetails[$i]['Raasi']; 
	$varHoroscopeMatch	= $arrBMDetails[$i]['HoroscopeMatch']; 
	$varChevvaiDosham	= $arrBMDetails[$i]['Dosham'];
	$varResidentStatus	= $arrBMDetails[$i]['ResidentStatus'];
	$varBirthDetAvail	= $arrBMDetails[$i]['BirthDetailsAvailable'];


	//GET COUNTRY, RESIDING STATE AND RESIDING CITY 
	$varCountry			= $arrBMDetails[$i]['CountrySelected'];
	$varResidingState	= $arrBMDetails[$i]['ResidingState'];
	$varResidingDist	= $arrBMDetails[$i]['ResidingDistrict'];
	$varResidingCity	= addslashes(stripslashes($arrBMDetails[$i]['ResidingCity']));
	$varResidingArea	= addslashes(stripslashes($arrBMDetails[$i]['ResidingArea']));
	$varResidingCity	= ("$varResidingCity"=='0')?'':$varResidingCity;

	//GET PUBLISH VALUE
	$varStatus		= $arrBMDetails[$i]['Status'];
	$varAuthorized	= $arrBMDetails[$i]['Authorized'];
	$varValidated	= $arrBMDetails[$i]['Validated'];

	if($varAuthorized==1 && $varValidated==1 && $varStatus==0)
	{
		$varPublish = 1;
	}
	elseif($varAuthorized==1 && $varValidated==1 && $varStatus==1)
	{
		$varPublish = 2;
	}
	else
	{
		$varPublish = 0;
	}

	//NOT CHANGEABLE DATAS
	$varName					= addslashes(stripslashes($arrBMDetails[$i]['Name']));
	$varBodyType				= $arrBMDetails[$i]['BodyType'];
	$varComplexion				= $arrBMDetails[$i]['Complexion'];
	$varSpecialCase				= $arrBMDetails[$i]['SpecialCase'];
	$varBloodGroup				= $arrBMDetails[$i]['BloodGroup'];
	$varEducation				= addslashes(stripslashes($arrBMDetails[$i]['Education']));
	$varNoOfChildren			= $arrBMDetails[$i]['NoOfChildren'];
	$varOccupation				= addslashes(stripslashes($arrBMDetails[$i]['Occupation']));
	$varAnnualIncome			= $arrBMDetails[$i]['AnnualIncome'];
	$varIncomeCurrency			= $arrBMDetails[$i]['IncomeCurrency'];
	$varChildrenLivingStatus	= $arrBMDetails[$i]['ChildrenLivingStatus']>0 ? ($arrBMDetails[$i]['ChildrenLivingStatus']-1) : 0;
	$varOccupationCategory		= $arrBMDetails[$i]['OccupationCategory'];
	$varCitizenship				= $arrBMDetails[$i]['Citizenship'];
	$varProfileDesc				= addslashes(stripslashes($arrBMDetails[$i]['ProfileDescription']));
	$varEatingHabit				= $arrBMDetails[$i]['EatingHabits'];
	$varSmokingHabit			= $arrBMDetails[$i]['SmokingHabits'];
	$varDrinkingHabit			= $arrBMDetails[$i]['DrinkingHabits'];
	$varIpAddress				= $arrBMDetails[$i]['IpAddress'];
	$varByWhom					= $arrBMDetails[$i]['ByWhom'];
	$varReferredBy				= $arrBMDetails[$i]['ReferredBy'];
	$varActivityRank			= $arrBMDetails[$i]['ActivityRank'];
	$varComments				= addslashes(stripslashes($arrBMDetails[$i]['Comments']));
	$varPartnerSetStatus		= $arrBMDetails[$i]['PartnerPrefSet'];
	$varPhotoFlag				= $arrBMDetails[$i]['PhotoAvailable'];
	$varHoroFlag				= $arrBMDetails[$i]['HoroscopeAvailable'];
	$varPhoneProtected			= $arrBMDetails[$i]['PhoneProtected']=='N'? 0 : 1;
	

	//CONTACT INFO INFORMATIONS
	$varContactPhone	= ''; 
	$varContactAddress	= '';
	$varMobileNo		= '';
	
	$varFieldsValues	= array("'".$varNewMatriId."'", "'".$varNewUsername."'", "'".$varOldMatriId."'", "'".$varBMPaidStat."'", "'".$varName."'", $varAge, "'".$varDob."'", $varGender, "'".$varHeight."'", "'".$varHeightUnit."'", "'".$varWeight."'", "'".$varWeightUnit."'", $varBodyType, $varComplexion, $varSpecialCase, $varBloodGroup, $varMaritalStatus, $varNoOfChildren, $varChildrenLivingStatus, $varEducationSelected, $varEducationId, "'".$varEducation."'", $varOccupationCategory, $varOccupationSelected, "'".$varOccupation."'", $varIncomeCurrency, "'".$varAnnualIncome."'", $varReligion, $varDenomination, $varDomainId, $varCaste, $varCasteNobar, $varSubcasteId, "'".$varSubcasteTxt."'", $varMotherTongue, "'".$varMotherTongueTxt."'", $varGothramId, "'".$varGothramText."'", $varStar, $varRaasi, $varHoroscopeMatch, $varChevvaiDosham, $varResidentStatus, $varCountry, $varCitizenship, $varResidingState, "'".$varResidingArea."'", $varResidingDist, "'".$varResidingCity."'", "'".$varContactAddress."'", "'".$varContactPhone."'", "'".$varMobileNo."'", "'".$varProfileDesc."'", $varEatingHabit, $varSmokingHabit, $varDrinkingHabit, "'".$varIpAddress."'", $varByWhom, $varReferredBy, $varPublish, $varPaidStatus, $varSpecialPriv, "'".$varCurrDateTime."'", $varPhoneVerified, $varPhoneProtected, $varHobbiesFlag, $varMobileAltFlag, $varBirthDetAvail, "'".$varCurrDateTime."'", "'".$varCurrDateTime."'", "'".$varDatePaid."'", $varValidDays, "'".$varExpiryDate."'", $varActivityRank, "'".$varCurrDateTime."'", "'".$varComments."'", $varPartnerSetStatus);
	$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	#------------------------------memberinfo ENDS HERE-------------------------------------------#

	#------------------------------memberpartnerinfo STARTS HERE-----------------------------------#
	
	if(count($varMatchWatchDetails) > 0){
	$varPartnerStAge		= $varMatchWatchDetails[0]['StAge'];
	$varPartnerEndAge		= $varMatchWatchDetails[0]['EndAge'];
	$varPartnerStHeight		= $varMatchWatchDetails[0]['StHeight'];
	$varPartnerEndHeight	= $varMatchWatchDetails[0]['EndHeight'];
	$varPartnerEducation	= $varMatchWatchDetails[0]['MatchEducation'];
	$varPartnerCitizenship	= $varMatchWatchDetails[0]['MatchCitizenship'];
	$varPartnerCountry		= $varMatchWatchDetails[0]['MatchCountry'];
	$varPartnerDateUpdated	= $varMatchWatchDetails[0]['DateUpdated'];
	$varPartnerMotherTongue	= $varMatchWatchDetails[0]['MotherTongue'];
	$varPartnerDescription	= addslashes(stripslashes($varMatchWatchDetails[0]['PartnerDescription']));
	$varPartnerMaritalStatus	= $varMatchWatchDetails[0]['MatchMaritalStatus'];
	$varPartnerHavingChildren	= $varMatchWatchDetails[0]['HavingChildren'];
	$varPartnerPhysicalStatus	= $varMatchWatchDetails[0]['PhysicalStatus'];
	$varPartnerEatingHabitsPref	= is_numeric($varMatchWatchDetails[0]['EatingHabitsPref']) ? $varMatchWatchDetails[0]['EatingHabitsPref'] : 0;
	$varPartnerResidentStatus	= $varMatchWatchDetails[0]['MatchResidentStatus'];
	$varPartnerIndiaStates		= $varMatchWatchDetails[0]['MatchIndianStates'];
	$varPartnerUSAStates		= $varMatchWatchDetails[0]['MatchUSStates'];
	
	//Get Systamatic values
	if($varPartnerStAge==0 && $varPartnerEndAge==0){
	$varPartnerStAge		= $varMatchWatchDetails[0]['SysStAge'];
	$varPartnerEndAge		= $varMatchWatchDetails[0]['SysEndAge'];
	$varPartnerStHeight		= $varMatchWatchDetails[0]['SysStHeight'];
	$varPartnerEndHeight	= $varMatchWatchDetails[0]['SysEndHeight'];
	$varPartnerEducation	= $varMatchWatchDetails[0]['SysMatchEducation'];
	$varPartnerCitizenship	= $varMatchWatchDetails[0]['SysMatchCitizenship'];
	$varPartnerCountry		= $varMatchWatchDetails[0]['SysMatchCountry'];
	$varPartnerMotherTongue	= $varMatchWatchDetails[0]['SysMotherTongue'];
	$varPartnerMaritalStatus	= $varMatchWatchDetails[0]['SysMatchMaritalStatus'];
	$varPartnerHavingChildren	= $varMatchWatchDetails[0]['SysHavingChildren'];
	$varPartnerPhysicalStatus	= $varMatchWatchDetails[0]['SysPhysicalStatus'];
	$varPartnerResidentStatus	= $varMatchWatchDetails[0]['SysMatchResidentStatus'];
	$varPartnerIndiaStates		= $varMatchWatchDetails[0]['SysMatchIndianStates'];
	$varPartnerUSAStates		= $varMatchWatchDetails[0]['SysMatchUSStates'];
	}

	//Religion changes
	$varPartnerReligion	= $varMatchWatchDetails[0]['MatchReligion'];
	$varPartnerCaste	= $varMatchWatchDetails[0]['MatchCaste'];

	if($varPartnerReligion=='' && $varPartnerCaste==''){
	$varPartnerReligion	= $varMatchWatchDetails[0]['SysMatchReligion'];
	$varPartnerCaste	= $varMatchWatchDetails[0]['SysMatchCaste'];
	}

	$varConvertedDenom	= '';
	$varConvertedCaste	= '';
	if($II>=1 && $II<=5){
		
		if($II==2){
			//Denimination
			$arrOldReligionVal	= split('~', $varPartnerReligion);
			$arrTempConDenom	= array();
			foreach($arrOldReligionVal as $varSinReligionVal){
				if($arrDenomination[$varSinReligionVal] != ''){
				$arrTempConDenom[] = $arrDenomination[$varSinReligionVal];
				}
			}
			
			//Caste
			$arrOldCasteVal	   = split('~', $varPartnerCaste);
			foreach($arrOldCasteVal as $varSinCasteVal){
				if($arrCaste[$varSinCasteVal] != ''){
				$varConvertedCaste = $arrCaste[$varSinCasteVal].'~';
				}

				if($arrDenomination2[$varSinCasteVal] != ''){
				$arrTempConDenom[] = $arrDenomination2[$varSinCasteVal];
				}
			}

			$varConvertedCaste = trim($varConvertedCaste, '~');
			$varConvertedDenom = join('~',array_unique($arrTempConDenom));

		}else{
			//Denimination
			$arrOldReligionVal	= split('~', $varPartnerReligion);
			$arrTempConDenom	= array();
			foreach($arrOldReligionVal as $varSinReligionVal){
				if($arrDenomination[$varSinReligionVal] != ''){
				$arrTempConDenom[] = $arrDenomination[$varSinReligionVal];
				}
			}
			$varConvertedDenom = join('~',array_unique($arrTempConDenom));

			//Caste
			$arrOldCasteVal	   = split('~', $varPartnerCaste);
			foreach($arrOldCasteVal as $varSinCasteVal){
				if($arrCaste[$varSinCasteVal] != ''){
				$varConvertedCaste = $arrCaste[$varSinCasteVal].'~';
				}
			}
			$varConvertedCaste = trim($varConvertedCaste, '~');
		}

		$varPartnerReligion	= '';
	}else{
		$varConvertedCaste	= $varPartnerCaste;
	}
		
	$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberpartnerinfo';
	$varFields		= array('MatriId','CommunityId','Age_From','Age_To','Looking_Status','Have_Children', 'Height_From', 'Height_To', 'Physical_Status','Mother_Tongue','Religion','Denomination','CasteId','Education', 'Partner_Description', 'Eating_Habits', 'Citizenship','Country','Resident_India_State','Resident_USA_State', 'Resident_Status','Date_Updated');
	$varFieldsValues= array("'".$varNewMatriId."'",$varDomainId,$varPartnerStAge,$varPartnerEndAge, "'".$varPartnerMaritalStatus."'", $varPartnerHavingChildren, "'".$varPartnerStHeight."'", "'".$varPartnerEndHeight."'", $varPartnerPhysicalStatus, "'".$varPartnerMotherTongue."'", "'".$varPartnerReligion."'", "'".$varConvertedDenom."'", "'".$varConvertedCaste."'", "'".$varPartnerEducation."'", "'".$varPartnerDescription."'", "'".$varPartnerEatingHabitsPref."'", "'".$varPartnerCitizenship."'", "'".$varPartnerCountry."'", "'".$varPartnerIndiaStates."'", "'".$varPartnerUSAStates."'", "'".$varPartnerResidentStatus."'", "'".$varCurrDateTime."'");
	$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	}//if 
	#------------------------------memberpartnerinfo ENDS HERE-------------------------------------#

	#------------------------------memberfamilyinfo STARTS HERE-----------------------------------#
	if(count($varSelectFamilyInfoDetails) > 0){
	$varFamilyValue	= $varSelectFamilyInfoDetails[0]['FamilyValue'];
	$varFamilyType	= $varSelectFamilyInfoDetails[0]['FamilyType'];
	$varFamilyStatus= $varSelectFamilyInfoDetails[0]['FamilyStatus'];
	$varFatherOccupation= addslashes(stripslashes($varSelectFamilyInfoDetails[0]['FatherOccupation']));
	$varMotherOccupation= addslashes(stripslashes($varSelectFamilyInfoDetails[0]['MotherOccupation']));
	$varAncestralOrigin	= addslashes(stripslashes($varSelectFamilyInfoDetails[0]['AncestralOrigin']));
	$varBrothers		= $varSelectFamilyInfoDetails[0]['Brothers'];
	$varSisters			= $varSelectFamilyInfoDetails[0]['Sisters'];
	$varBrothersMarried	= $varSelectFamilyInfoDetails[0]['BrothersMarried'];
	$varSistersMarried	= $varSelectFamilyInfoDetails[0]['SistersMarried'];
	$varFamilydescription=addslashes(stripslashes($varSelectFamilyInfoDetails[0]['Familydescription']));

	$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberfamilyinfo';
	$varFields		= array('MatriId', 'Family_Value', 'Family_Type', 'Family_Status', 'Father_Occupation', 'Mother_Occupation', 'Family_Origin', 'Brothers', 'Brothers_Married', 'Sisters', 'Sisters_Married', 'About_Family', 'Date_Updated');
	$varFieldsValues= array("'".$varNewMatriId."'", $varFamilyValue, $varFamilyType, $varFamilyStatus, "'".$varFatherOccupation."'", "'".$varMotherOccupation."'", "'".$varAncestralOrigin."'", $varBrothers, $varBrothersMarried, $varSisters, $varSistersMarried, "'".$varFamilydescription."'", "'".$varCurrDateTime."'");

	$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	}
	#------------------------------memberfamilyinfo ENDS HERE-------------------------------------#

	#------------------------------memberfilterinfo STARTS HERE-----------------------------------#
	if(count($varSelectFilterInfoDetails) > 0){
	$varFilterReligion		= $varSelectFilterInfoDetails[0]['Religion'];
	$varFilterCaste			= $varSelectFilterInfoDetails[0]['Caste'];
	$varFilterMaritalStatus	= $varSelectFilterInfoDetails[0]['MaritalStatus'];
	$varFilterMotherTongue	= $varSelectFilterInfoDetails[0]['MotherTongue'];
	$varFilterAgeAbove		= $varSelectFilterInfoDetails[0]['AgeAbove'];
	$varFilterAgeBelow		= $varSelectFilterInfoDetails[0]['AgeBelow'];
	$varFilterCountry		= $varSelectFilterInfoDetails[0]['Country'];

	if($II>=1 && $II<=5){
	$varFilterReligion		= '';
	$varFilterCaste			= '';
	}

	$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberfilterinfo';
	$varFields		= array('MatriId','Religion','CasteId','Marital_Status','Age_Above','Age_Below','Country','Mother_Tongue','Date_Updated');
	$varFieldsValues= array("'".$varNewMatriId."'", "'".$varFilterReligion."'", "'".$varFilterCaste."'", "'".$varFilterMaritalStatus."'", $varFilterAgeAbove, $varFilterAgeBelow, "'".$varFilterCountry."'", "'".$varFilterMotherTongue."'", "'".$varCurrDateTime."'");
	$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	}//if
	#------------------------------memberfilterinfo ENDS HERE-------------------------------------#

	#------------------------------memberhobbiesinfo STARTS HERE-------------------------------------#
	if(count($varSelectHobbiesInfoDetails) > 0)
	{
		$varHobHobbiesSelected	= $varSelectHobbiesInfoDetails[0]['HobbiesSelected'];
		$varHobHobbiesOthers	= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['HobbiesOthers']));
		$varHobInterestsSelected= $varSelectHobbiesInfoDetails[0]['InterestsSelected'];
		$varHobInterestsOthers	= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['InterestsOthers']));
		$varHobMusicSelected	= $varSelectHobbiesInfoDetails[0]['MusicSelected'];
		$varHobMusicOthers		= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['MusicOthers']));
		$varHobBooksSelected	= $varSelectHobbiesInfoDetails[0]['BooksSelected'];
		$varHobBooksOthers		= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['BooksOthers']));
		$varHobMoviesSelected	= $varSelectHobbiesInfoDetails[0]['MoviesSelected'];
		$varHobMoviesOthers		= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['MoviesOthers']));
		$varHobSportsSelected	= $varSelectHobbiesInfoDetails[0]['SportsSelected'];
		$varHobSportsOthers		= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['SportsOthers']));
		$varHobFoodSelected		= $varSelectHobbiesInfoDetails[0]['FoodSelected'];
		$varHobFoodOthers		= addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['FoodOthers']));
		$varHobDressStyleSelected= $varSelectHobbiesInfoDetails[0]['DressStyleSelected'];
		$varHobDressStyleOthers	 = addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['DressStyleOthers']));
		$varHobLanguagesSelected = $varSelectHobbiesInfoDetails[0]['LanguagesSelected'];
		$varHobLanguagesOthers	 = addslashes(stripslashes($varSelectHobbiesInfoDetails[0]['LanguagesOthers']));
		
		$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberhobbiesinfo';
		$varFields		= array('MatriId', 'Hobbies_Selected', 'Hobbies_Others', 'Interests_Selected', 'Interests_Others', 'Music_Selected', 'Music_Others', 'Books_Selected', 'Books_Others', 'Movies_Selected', 'Movies_Others', 'Sports_Selected', 'Sports_Others', 'Food_Selected', 'Food_Others', 'Dress_Style_Selected', 'Dress_Style_Others', 'Languages_Selected', 'Languages_Others', 'Date_Updated');
		$varFieldsValues= array("'".$varNewMatriId."'", "'".$varHobHobbiesSelected."'", "'".$varHobHobbiesOthers."'", "'".$varHobInterestsSelected."'", "'".$varHobInterestsOthers."'", "'".$varHobMusicSelected."'", "'".$varHobMusicOthers."'", "'".$varHobBooksSelected."'", "'".$varHobBooksOthers."'", "'".$varHobMoviesSelected."'", "'".$varHobMoviesOthers."'", "'".$varHobSportsSelected."'", "'".$varHobSportsOthers."'", "'".$varHobFoodSelected."'", "'".$varHobFoodOthers."'", "'".$varHobDressStyleSelected."'", "'".$varHobDressStyleOthers."'", "'".$varHobLanguagesSelected."'", "'".$varHobLanguagesOthers."'", "'".$varCurrDateTime."'");
		$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	}
	#------------------------------memberhobbiesinfo ENDS HERE-------------------------------------#

	#------------------------------mobilealerts STARTS HERE-------------------------------------#
	if($varMobileAltFlag == 1 && count($varSelectMoblieAlertsInfo)>0)
	{
		$varService	= $varSelectMoblieAlertsInfo[0]['Service'];
		$varMobile	= $varSelectMoblieAlertsInfo[0]['MobileNo'];
		$varMWEnable= $varSelectMoblieAlertsInfo[0]['MatchWatchEnabled']=='N'? 0 : 1;
		$varNewMsg	= $varSelectMoblieAlertsInfo[0]['NewMsgEnabled']=='N'? 0 : 1;
		$varNewInt	= $varSelectMoblieAlertsInfo[0]['NewInterestEnabled']=='N'? 0 : 1;
		$varStatus	= $varSelectMoblieAlertsInfo[0]['Status'];

		$varCMTable		= $varDbaInfo['DATABASE'].'.comm_mobilealerts';
		$varFields		= array('MatriId', 'Service', 'Mobile_No', 'MatchWatch_Enabled', 'NewMsg_Enabled', 'NewInterest_Enabled', 'Status', 'Date_Registered');
		$varFieldsValues= array("'".$varNewMatriId."'", "'".$varService."'", "'".$varMobile."'", $varMWEnable, $varNewMsg, $varNewInt, $varStatus, "'".$varCurrDateTime."'");
		$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	}

	#------------------------------mobilealerts ENDS HERE-------------------------------------#

	#------------------------------memberphotoinfo STARTS HERE------------------------------------------#

	if(($varPhotoFlag==1 || $varHoroFlag == 1) && count($varSelectPhotoInfoDetails)>0)
	{
		$varDateUpdated		  = $varSelectPhotoInfoDetails[0]['DateUpdated'];
		$varProtectPasswd     = $varSelectPhotoInfoDetails[0]['Photo_ProtectedPassword'];
		$varPhotoProtStatus   = $varSelectPhotoInfoDetails[0]['PhotoProtected'];
		$varHoroProtectPasswd = $varSelectPhotoInfoDetails[0]['Horoscope_ProtectedPassword'];
		$varHoroscopeURL	  = $varSelectPhotoInfoDetails[0]['HoroscopeURL'];
		$varHoroscopeDesc	  = $varSelectPhotoInfoDetails[0]['HoroscopeDescription'];
		$varHoroStatus		  = $varSelectPhotoInfoDetails[0]['HoroscopeStatus'];
		$varHoroProtectStatus = $varSelectPhotoInfoDetails[0]['HoroscopeProtected'];

		//Text file contents for bm-photos-list.txt & product-photos-list.txt 
		$varBMPhotosTxtContent		= '';
		$varBMHoroscopeTxtContent	= '';
		$varProductPhotosTxtContent	= '';
		$varProtectPhotoTxtContent  = '';
		$varHoroscopeTxtContent		= '';
		
		//Get BM photo path
		$varNormalPath	= $varLangArray[strtoupper($varOldMatriId{0})].'/www/photos/'. $varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
		$varSourcePath	= $varLangArray[strtoupper($varOldMatriId{0})].'/www/photosorg/'. $varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
		$varSourcePath2	= $varLangArray[strtoupper($varOldMatriId{0})].'/www/photosorg/';

		if($varPhotoFlag==1){
		for($j=1; $j<=10; $j++)
		{
			$varNormalPhoto	= $varSelectPhotoInfoDetails[0]['ThumbImgs'.$j];
			$varPhotoStatus	= $varSelectPhotoInfoDetails[0]['PhotoStatus'.$j]; //0-validated, 1-pending, 2-changed, 

			//Change photo status
			$varPhotoStatus		= ($varPhotoStatus==0 || $varPhotoStatus==2)? 1 : 0; 
			
			if($varNormalPhoto!= '' && $varPhotoStatus==1)
			{
				$varPhotoDesc		= $varSelectPhotoInfoDetails[0]['PhotoDescription'.$j];
				$varArrPhotoTypes	= array('NL','TS','TB');
				
				foreach($varArrPhotoTypes as $varPhotoType)
				{
					$varBMPhotoName	= '';
					switch($varPhotoType)
					{
						case 'NL': 
							$varBMPhotoName		= $varNormalPhoto;
							break;
						case 'TS': 
							$varThumbSmallPhoto	= 'ThumbImg'.$j;
							$varBMPhotoName		= $varSelectPhotoInfoDetails[0][$varThumbSmallPhoto];
							break;
						case 'TB':
							$varThumbBigPhoto	= 'PhotoURL'.$j;
							$varBMPhotoName		= $varSelectPhotoInfoDetails[0][$varThumbBigPhoto];
							break;
					}//switch

					if($varPhotoType == 'NL'){
					$varBMPhotosTxtContent   .= $varNormalPath.$varBMPhotoName."\n";
					}else{
					$varBMPhotosTxtContent   .= $varSourcePath.$varBMPhotoName."\n";
					$varBMPhotosTxtContent   .= $varSourcePath2.$varBMPhotoName."\n";
					}


					$varProductPhotosTxtContent.= $varBMPhotoName.'~'.$varNewMatriId.'~'.$varPhotoType.'~'.$j. 							'~'.$varPhotoStatus.'~'.$varPhotoDesc."\n";
				}//foreach
			}//if
		}//for
		

		//SAVE PHOTO PROTECT PASSWORD
		if($varProtectPasswd != '' && $varPhotoProtStatus=='Y')
		{
			$varProtectPhotoTxtContent = $varNewMatriId.'~'.$varOldMatriId.'~'.$varProtectPasswd."\n";
			fwrite($varProtectFileHandler, $varProtectPhotoTxtContent);
		}//if
		}//if - PHOTO

		if($varHoroFlag == 1){
			$varHoroImgPath	= $varLangArray[strtoupper($varOldMatriId{0})].'/www/photos/'. $varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
			$varHoroHtmlPath= $varLangArray[strtoupper($varOldMatriId{0})].'/www/horoscopegen/'. $varOldMatriId{1}.'/'.$varOldMatriId{2}.'/';
			$varHoroInfo	= split('\.', $varHoroscopeURL);
			//SAVE HOROSCOPE DETAILS
			if($varHoroscopeURL != '' && ($varHoroStatus == 0))
			{
				$varHoroPath	= (strtolower($varHoroInfo[1]) == 'html') ? $varHoroHtmlPath : $varHoroImgPath;
				$varHoroscopeTxtContent = $varNewMatriId.'~'.$varOldMatriId.'~'.$varHoroscopeURL.'~'.$varHoroProtectPasswd.'~'. $varHoroscopeDesc.'~'.$varDateUpdated.'~'.$varHoroProtectStatus."\n";
				$varBMHoroscopeTxtContent .= $varHoroPath.$varHoroscopeURL."\n";
				fwrite($varHoroFileHandler, $varHoroscopeTxtContent);
				fwrite($varBMHoroFileHandler, $varBMHoroscopeTxtContent);
			}//if
		}
		if($varBMPhotosTxtContent != '')
		fwrite($varBMPhotoFileHandler, $varBMPhotosTxtContent);

		if($varProductPhotosTxtContent != '')
		fwrite($varProductFileHandler, $varProductPhotosTxtContent);
	}//if
	#------------------------------memberphotoinfo ENDS HERE--------------------------------------------#
	}//if --- CHECK NEW MatriId's LENGTH >=9 
	}//if -- CHECK BM MatriId ALREADY ADDED OR NOT
}//for

//Close file handlers
fclose($varBMPhotoFileHandler);
fclose($varBMHoroFileHandler);
fclose($varProductFileHandler);
fclose($varProUserFileHandler);
fclose($varProtectFileHandler);
fclose($varHoroFileHandler);
}//for

}//for - Main Loop 
//UNSET OBJECT
$objDC->dbClose();
unset($objDC);
?>
