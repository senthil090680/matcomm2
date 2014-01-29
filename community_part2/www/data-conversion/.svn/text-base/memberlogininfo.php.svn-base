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

for($II=1; $II<=4; $II++){

$varCond			= '';
$varPublishedDate	= '';

if($II == 1){
	//A & B - Grade
	$varPublishedDate = date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-30, date('Y')));
	$varCond = "WHERE mp.MatriId=li.MatriId AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' AND Caste IN (3, 9, 49, 27, 28, 82, 85, 87, 106, 133, 135, 170, 218, 229, 123, 165, 281, 10, 12, 13, 14, 15, 22, 34, 37, 43, 67, 77, 81, 83, 89, 90, 99, 109, 132, 138, 142, 331, 156, 171, 178, 198, 225, 226, 236, 237, 239, 5, 7, 18, 23, 30, 42, 44, 50, 250, 60, 62, 65, 29, 79, 93, 101, 107, 113, 114, 116, 117, 124, 134, 136, 139, 153, 162, 175, 176, 293, 179, 200, 207, 208, 213, 220, 221, 232, 2, 35, 74, 270, 292, 285, 261, 254, 20, 240, 269, 40, 291, 242, 271, 63, 251, 241, 273, 283, 255, 248, 100, 252, 253, 275, 243, 121, 264, 258, 256, 247, 259, 244, 341, 277, 278, 342, 231, 233, 234) ORDER BY Caste,TimeCreated ASC";
}else if($II == 2){
	$varPublishedDate = date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-1, date('Y')));
	$varCond = "WHERE mp.MatriId=li.MatriId AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' AND Caste IN(17, 33, 36, 71, 97, 329, 146, 149, 161, 173, 202, 210, 212, 357, 1, 6, 8, 11, 295, 297, 16, 19, 298, 21, 24, 31, 32, 339, 39, 41, 45, 46, 47, 303, 48, 51, 52, 53, 55, 304, 56, 57, 306, 308, 61, 310, 311, 312, 64, 314, 66, 317, 68, 69, 70, 72, 73, 75, 78, 80, 84, 321, 326, 86, 91, 92, 94, 323, 95, 96, 98, 324, 325, 102, 103, 108, 110, 111, 112, 115, 118, 119, 120, 125, 328, 126, 127, 128, 129, 131, 330, 141, 143, 144, 145, 333, 147, 148, 334, 150, 151, 152, 155, 157, 158, 336, 358, 163, 164, 166, 167, 168, 169, 338, 172, 174, 340, 177, 197, 344, 201, 203, 204, 205, 206, 209, 211, 346, 348, 215, 216, 217, 219, 350, 222, 223, 227, 228, 351, 230, 353, 355, 238, 356, 294, 296, 301, 38, 302, 307, 26, 313, 320, 160, 343, 122, 315, 305, 318, 335, 235, 54, 88, 214, 309, 673, 260, 267, 286, 287, 272, 299, 288, 319, 322, 274, 105, 327, 130, 263, 289, 246, 284, 257, 268, 276, 265, 280, 347, 249, 349, 224, 354, 266, 337) ORDER BY Caste,TimeCreated ASC";
}else if($II == 3){
	$varPublishedDate = date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-30, date('Y')));
	$varCond = "WHERE mp.MatriId=li.MatriId AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' AND Caste IN(260, 261, 254, 267, 286, 269, 270, 290, 291, 262, 26, 287, 271, 272, 27, 28, 288, 240, 273, 274, 283, 255, 241, 242, 243, 275, 263, 282, 258, 264, 292, 244, 245, 289, 256, 257, 284, 246, 247, 268, 276, 259, 278, 279, 280, 277, 265, 285, 266, 248, 249, 299, 316, 332, 337, 354) ORDER BY Caste,TimeCreated ASC";
}else if($II == 4){
	//Updation for goundarmatrimony.com - 59 (87 - kongu, 355 - vettuva)    
	$varUpdateWhere	= ' Caste IN(87, 355)';
	$varFields		= array('Caste');
	$varFieldsValues= array(59);
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_matrimonyprofile';
	$objDC->update($varBMTable, $varFields, $varFieldsValues, $varUpdateWhere);

	//Updation for kapunaidumatrimony.com - 76 (121 - munnuru, 348 - turupu)    
	$varUpdateWhere	= ' Caste IN(121, 348)';
	$varFields		= array('Caste');
	$varFieldsValues= array(76);
	$varBMTable		= $varDbaInfo['DATABASE'].'.bm_matrimonyprofile';
	$objDC->update($varBMTable, $varFields, $varFieldsValues, $varUpdateWhere);

	$varPublishedDate	= date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-30, date('Y')));
	$varCond = "WHERE mp.MatriId=li.MatriId AND mp.ProfilePublishedOn>='".$varPublishedDate." 00:00:00' AND mp.ProfilePublishedOn<='".$varPublishedDate." 23:59:59' AND Caste IN(59, 76) ORDER BY Caste,TimeCreated ASC";
}


for($JJ=0; $JJ<1; $JJ++){

$varRecsCnt		= 100000;
$varStartLimit  = $JJ*$varRecsCnt;

$varFirstWhereCond	= $varCond.' LIMIT '.$varStartLimit.', '.$varRecsCnt;

#SELECT DATAS FROM matrimonyprofile
$varBMTable		= $varDbaInfo['DATABASE'].'.bm_matrimonyprofile mp, '.$varDbaInfo['DATABASE'].'.bm_logininfo li';

$varFields		= array('mp.MatriId', 'Status', 'Authorized', 'Validated', 'EntryType', 'SpecialPriv', 'Name', 'Age', 'DayOfBirth', 'MonOfBirth', 'YearOfBirth', 'Gender', 'MaritalStatus', 'NoOfChildren', 'ChildrenLivingStatus', 'InCms', 'Height', 'BodyType', 'Complexion', 'BloodGroup', 'InLbs', 'Weight', 'SpecialCase', 'MotherTongue', 'MotherTongueOthers', 'Religion', 'Caste', 'CasteOthers', 'SubCaste', 'SubCasteId', 'CasteNoBar', 'Gothra', 'GothraId', 'Star', 'Raasi', 'Dosham', 'EatingHabits', 'SmokingHabits', 'DrinkingHabits', 'EducationSelected', 'EducationId', 'Education', 'OccupationCategory', 'OccupationSelected', 'Occupation', 'IncomeCurrency', 'AnnualIncome', 'Citizenship', 'CountrySelected', 'ResidentStatus', 'ResidingState', 'ResidingArea', 'ResidingDistrict', 'ResidingCity', 'PhoneProtected', 'ProfileDescription', 'HobbiesAvailable', 'FiltersAvailable', 'MobileAlertsAvailable', 'PhotoAvailable', 'PhotoProtected', 'HoroscopeAvailable', 'HoroscopeProtected', 'BirthDetailsAvailable', 'HoroscopeMatch', 'PartnerPrefSet', 'LastLogin', 'TimePosted', 'NumberOfPayments', 'LastPayment', 'ValidDays', 'ExpiryDate', 'TimeCreated', 'ByWhom', 'ReferredBy', 'IpAddress', 'Comments', 'ActivityRank', 'Password', 'Email');

$varFields1		= array('MatriId', 'Status', 'Authorized', 'Validated', 'EntryType', 'SpecialPriv', 'Name', 'Age', 'DayOfBirth', 'MonOfBirth', 'YearOfBirth', 'Gender', 'MaritalStatus', 'NoOfChildren', 'ChildrenLivingStatus', 'InCms', 'Height', 'BodyType', 'Complexion', 'BloodGroup', 'InLbs', 'Weight', 'SpecialCase', 'MotherTongue', 'MotherTongueOthers', 'Religion', 'Caste', 'CasteOthers', 'SubCaste', 'SubCasteId', 'CasteNoBar', 'Gothra', 'GothraId', 'Star', 'Raasi', 'Dosham', 'EatingHabits', 'SmokingHabits', 'DrinkingHabits', 'EducationSelected', 'EducationId', 'Education', 'OccupationCategory', 'OccupationSelected', 'Occupation', 'IncomeCurrency', 'AnnualIncome', 'Citizenship', 'CountrySelected', 'ResidentStatus', 'ResidingState', 'ResidingArea', 'ResidingDistrict', 'ResidingCity', 'PhoneProtected', 'ProfileDescription', 'HobbiesAvailable', 'FiltersAvailable',  'MobileAlertsAvailable', 'PhotoAvailable', 'PhotoProtected', 'HoroscopeAvailable', 'HoroscopeProtected', 'BirthDetailsAvailable', 'HoroscopeMatch', 'PartnerPrefSet', 'LastLogin', 'TimePosted', 'NumberOfPayments', 'LastPayment', 'ValidDays', 'ExpiryDate', 'TimeCreated', 'ByWhom', 'ReferredBy', 'IpAddress', 'Comments', 'ActivityRank', 'Password', 'Email');

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

//Delete photo based txt files
if($II == 1){
@unlink($varBMPhotoFile);
@unlink($varBMHoroFile);
@unlink($varProductFile);
@unlink($varProInfoFile);
@unlink($varProtectFile);
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
	$varCurrentDate	= date('Y-m-d');
	$varCurrDateTime= date('Y-m-d H:i:s');

	$varDomainId	= '';
	switch($II){
		case 1:
			//Caste based sites - A & B
			$varDomainId = $arrBMDetails[$i]['Caste'];
			break;
		case 2:
			//Caste based sites - C & D
			$varDomainId = $arrBMDetails[$i]['Caste'];
			break;
		case 3:
			//BRAHMIN
			$varDomainId = 25;
			break;
		case 4:
			//Goundarmatrimony & Kapunaidumatrimony
			$varDomainId = $arrBMDetails[$i]['Caste'];
			break;
		default :
			$varDomainId = '';
			break;
	}

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
	$varFields		= array('MatriId', 'User_Name', 'BM_MatriId', 'BM_Paid_Status', 'Name', 'Age', 'Dob', 'Gender', 'Height', 'Height_Unit', 'Weight', 'Weight_Unit', 'Body_Type', 'Complexion', 'Physical_Status', 'Blood_Group', 'Marital_Status', 'No_Of_Children', 'Children_Living_Status', 'Education_Category', 'Education_Subcategory', 'Education_Detail', 'Employed_In', 'Occupation', 'Occupation_Detail', 'Income_Currency', 'Annual_Income', 'Religion', 'CommunityId', 'CasteId', 'Caste_Nobar', 'SubcasteId', 'SubcasteText', 'Mother_TongueId', 'Mother_TongueText', 'GothramId', 'GothramText', 'Star', 'Raasi', 'Horoscope_Match', 'Chevvai_Dosham', 'Resident_Status', 'Country', 'Citizenship', 'Residing_State', 'Residing_Area', 'Residing_District', 'Residing_City', 'Contact_Address', 'Contact_Phone', 'Contact_Mobile', 'About_Myself', 'Eating_Habits', 'Smoke', 'Drink', 'IPAddress', 'Profile_Created_By', 'Profile_Referred_By', 'Publish', 'Paid_Status', 'Special_Priv', 'Last_Login', 'Phone_Verified', 'Phone_Protected', 'Hobbies_Available', 'Mobile_Alerts_Available', 'Birth_Details_Available', 'Date_Created', 'Time_Posted', 'Last_Payment', 'Valid_Days', 'Expiry_Date', 'Activity_Rank', 'Date_Updated', 'Support_Comments', 'Partner_Set_Status');

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

	$varReligion		= $arrBMDetails[$i]['Religion'];
	$varCaste			= $arrBMDetails[$i]['Caste'];
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
	
	$varFieldsValues	= array("'".$varNewMatriId."'", "'".$varNewUsername."'", "'".$varOldMatriId."'", "'".$varBMPaidStat."'", "'".$varName."'", $varAge, "'".$varDob."'", $varGender, "'".$varHeight."'", "'".$varHeightUnit."'", "'".$varWeight."'", "'".$varWeightUnit."'", $varBodyType, $varComplexion, $varSpecialCase, $varBloodGroup, $varMaritalStatus, $varNoOfChildren, $varChildrenLivingStatus, $varEducationSelected, $varEducationId, "'".$varEducation."'", $varOccupationCategory, $varOccupationSelected, "'".$varOccupation."'", $varIncomeCurrency, "'".$varAnnualIncome."'", "'".$varReligion."'", $varDomainId, $varCaste, $varCasteNobar, $varSubcasteId, "'".$varSubcasteTxt."'", $varMotherTongue, "'".$varMotherTongueTxt."'", $varGothramId, "'".$varGothramText."'", $varStar, $varRaasi, $varHoroscopeMatch, $varChevvaiDosham, $varResidentStatus, $varCountry, $varCitizenship, $varResidingState, "'".$varResidingArea."'", $varResidingDist, "'".$varResidingCity."'", "'".$varContactAddress."'", "'".$varContactPhone."'", "'".$varMobileNo."'", "'".$varProfileDesc."'", $varEatingHabit, $varSmokingHabit, $varDrinkingHabit, "'".$varIpAddress."'", $varByWhom, $varReferredBy, $varPublish, $varPaidStatus, $varSpecialPriv, "'".$varCurrDateTime."'", $varPhoneVerified, $varPhoneProtected, $varHobbiesFlag, $varMobileAltFlag, $varBirthDetAvail, "'".$varCurrDateTime."'", "'".$varCurrDateTime."'", "'".$varDatePaid."'", $varValidDays, "'".$varExpiryDate."'", $varActivityRank, "'".$varCurrDateTime."'", "'".$varComments."'", $varPartnerSetStatus);
	$objDC->insert($varCMTable, $varFields, $varFieldsValues);
	#------------------------------memberinfo ENDS HERE-------------------------------------------#

	#------------------------------memberpartnerinfo STARTS HERE-----------------------------------#
	
	if(count($varMatchWatchDetails) > 0){
	$varPartnerStAge		= $varMatchWatchDetails[0]['StAge'];
	$varPartnerEndAge		= $varMatchWatchDetails[0]['EndAge'];
	$varPartnerStHeight		= $varMatchWatchDetails[0]['StHeight'];
	$varPartnerEndHeight	= $varMatchWatchDetails[0]['EndHeight'];
	$varPartnerReligion		= $varMatchWatchDetails[0]['MatchReligion'];
	$varPartnerCaste		= $varMatchWatchDetails[0]['MatchCaste'];
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
	$varPartnerReligion			= $varMatchWatchDetails[0]['SysMatchReligion'];
	$varPartnerCaste			= $varMatchWatchDetails[0]['SysMatchCaste'];
	}

	$varCMTable		= $varDbaInfo['DATABASE'].'.comm_memberpartnerinfo';
	$varFields		= array('MatriId','CommunityId','Age_From','Age_To','Looking_Status','Have_Children', 'Height_From', 'Height_To', 'Physical_Status','Mother_Tongue','Religion','CasteId','Education', 'Partner_Description', 'Eating_Habits', 'Citizenship','Country','Resident_India_State','Resident_USA_State', 'Resident_Status','Date_Updated');
	$varFieldsValues= array("'".$varNewMatriId."'",$varDomainId,$varPartnerStAge,$varPartnerEndAge, "'".$varPartnerMaritalStatus."'", $varPartnerHavingChildren, "'".$varPartnerStHeight."'", "'".$varPartnerEndHeight."'", $varPartnerPhysicalStatus, "'".$varPartnerMotherTongue."'", "'".$varPartnerReligion."'", "'".$varPartnerCaste."'", "'".$varPartnerEducation."'", "'".$varPartnerDescription."'", "'".$varPartnerEatingHabitsPref."'", "'".$varPartnerCitizenship."'", "'".$varPartnerCountry."'", "'".$varPartnerIndiaStates."'", "'".$varPartnerUSAStates."'", "'".$varPartnerResidentStatus."'", "'".$varCurrDateTime."'");
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
