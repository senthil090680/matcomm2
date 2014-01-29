<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-07-23
# End Date		: 2008-07-23
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
//ini_set('display_errors',1);
//FILE INCLUDES

$varRootBasePath='/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/ppinfo.inc');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/lib/clsRegister.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsSvrValidation.php');
include_once($varRootBasePath.'/lib/clsValidate.php');

//OBJECT DECLARTION
$objRegister	= new clsRegister;
$objmailManager	= new MailManager;
$objCommon		= new clsCommon;
$objValidate    = new clsValidate;

//CONNECT DATABASE
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);

$varErrorPage	= 'no';
$varCategory	= trim($_REQUEST['category']); // For payment purpose.
$varPayFrom		= trim($_REQUEST['payFrom']);

//Get Pinno
function getPinNo($objMasterDBConn,$phonePinTable) {

	$funQuery	= "LOCK TABLES ".$phonePinTable." WRITE";
	mysql_query($funQuery);

	$argFields			= array('PinNo');
	$argCondition		= "WHERE UsedStatus=0 LIMIT 0,1";
	$varPinInfoResultSet= $objMasterDBConn->select($phonePinTable,$argFields,$argCondition,0);
	$varPinInfoResult	= mysql_fetch_assoc($varPinInfoResultSet);

	$varPhonePinNo		= $varPinInfoResult["PinNo"];

	$argFields 			= array('UsedStatus');
	$argFieldsValues	= array(1);
	$argCondition		= " PinNo=".$varPhonePinNo;
	$varUpdateId		= $objMasterDBConn->update($phonePinTable,$argFields,$argFieldsValues,$argCondition);

	$funQuery	= "UNLOCK TABLES";
	mysql_query($funQuery);

	return $varPhonePinNo;
}

//Get Partner age
function getPPAge($argAge,$argGender){
   global $varMStartAge, $varFStartAge;
   if($argGender==1){
   $funAge	= $argAge-7;
   if($argAge==39)
    $funAge	= $argAge-8;
   elseif($argAge>39 && $argAge<51)
    $funAge	= $argAge-9;
   elseif($argAge==51)
    $funAge	= $argAge-10;
   elseif($argAge==52)
    $funAge	= $argAge-11;
   elseif($argAge>52 && $argAge<64)
    $funAge	= $argAge-12;
   elseif($argAge==64)
    $funAge	= $argAge-13;
   elseif($argAge==65)
    $funAge	= $argAge-14;
   elseif($argAge>65)
    $funAge	= $argAge-15;

   $funAge	= ($funAge<$varFStartAge) ? $varFStartAge : $funAge;
  }else{
   $funAge	= $argAge+7;
   if($argAge>30 && $argAge<41)
    $funAge	= $argAge+9;
   elseif($argAge>40 && $argAge<51)
    $funAge	= $argAge+12;
   elseif($argAge>50)
    $funAge = $argAge+15;
   if($funAge>70)
    $funAge	= 70;

   $funAge	= ($funAge<$varMStartAge) ? $varMStartAge : $funAge;
  }
  return $funAge;
}


//CONTROL STATEMENT
if ($_POST['addRegister']=='yes') {

	$varRedirectDomain		= '';
	$varSubCasteText		= '';
	$varGothramText			= '';
	$varPublish				= '0';
	$varCurrentDate			= date('Y-m-d H:i:s');
	$varMainDomainName		= $_REQUEST['domainName'];

	if ($varMainDomainName !='0' && $varMainDomainName !="") { $varPublish = '5'; }

	$varPartlyId			= $_REQUEST['partlyId'];
	$varName				= addslashes(strip_tags(trim($_REQUEST['name'])));
	$varNickName			= addslashes(strip_tags(trim($_REQUEST['nickName'])));
	$varGender				= $_REQUEST['gender'];
	$varMonth				= $_REQUEST['dobMonth'];
	$varDay					= $_REQUEST['dobDay'];
	$varYear				= $_REQUEST['dobYear'];
	$varAge					= trim($_REQUEST['age']);
	$varAge					= ($varAge=='Age') ? '' : $varAge;
	$varMaritalStatus		= $_REQUEST['maritalStatus'];
	$varNoOfChildren		= $_REQUEST['noOfChildren'];
	$varChildLivingStatus	= $_REQUEST['childrenLivingWithMe'];
	$varHeightFeet			= $_REQUEST['heightFeet'];
	$varHeightUnit			= 'feet-inches';
	$varPhysicalStatus		= $_REQUEST['physicalStatus'];
	$varAppearance			= $_REQUEST['appearance'];
	$varEducationSubcategory= $_REQUEST['educationCategory'];
	$varEducationCategory	= $arrEducationMapping[$varEducationSubcategory];
	$varEmploymentCategory	= $_REQUEST['employmentCategory'];
	$varOccupation          = $_REQUEST['occupation'];
	$varAnnualIncomeCurrency= $_REQUEST['annualIncomeCurrency'];
	$varAnnualIncome		= addslashes(strip_tags(str_replace(',','',trim($_REQUEST['annualIncome']))));
	$varProfileCreatedBy	= $_REQUEST['profileCreatedBy'];
	$varGetMarried			= $_REQUEST['getMarried'];
	$varReligion			= $_REQUEST['religion'];
    $varReligionOthers			= addslashes(strip_tags(trim($_REQUEST['religionOthers'])));
	$varCaste				= $_REQUEST['caste'];
	$varCasteOthers			= addslashes(strip_tags(trim($_REQUEST['casteOthers'])));
	$varCasteText			= addslashes(strip_tags(trim($_REQUEST['casteText'])));

	$varCasteText			= $varCasteText ? $varCasteText : $varCasteOthers;

	$varMotherTongue		= $_REQUEST['motherTongue'];
	$varMotherTongueText	= addslashes(strip_tags(trim($_REQUEST['Mother_TongueText'])));
	$varFamilyValue			= $_REQUEST['familyValue'];
	$varFamilyType			= $_REQUEST['familyType'];
	$varFamilyStatus		= $_REQUEST['familyStatus'];
	$varReligiousValues		= $_REQUEST['religious'];
	$varEthnicity			= $_REQUEST['ethnicity'];
	$varCountry				= $_REQUEST['country'];
	$varCitizenship			= $_REQUEST['citizenship'];
	$varPlaceOfBirth		= $_REQUEST['placeofbirth'];
	
	
	if ($varCountry==98) { $varCitizenship = '98'; }//if
	$varResidingState		= addslashes(strip_tags(trim($_REQUEST['residingState'])));
	$varResidingCity		= addslashes(strip_tags(trim($_REQUEST['residingCity'])));	
	$varCountryCode			= addslashes(strip_tags(trim($_REQUEST['countryCode'])));
	$varCountryCode			= ($varCountryCode != 'ISD' && $varCountryCode != '')?$varCountryCode:'';
	$varAreaCode			= addslashes(strip_tags(trim($_REQUEST['areaCode'])));
	$varAreaCode			= ($varAreaCode != 'STD' && $varAreaCode != '')?$varAreaCode:'';
	$varPhoneNo				= addslashes(strip_tags(trim($_REQUEST['phoneNo'])));
	$varPhoneNo				= ($varPhoneNo != 'Telephone number' && $varPhoneNo != '')?$varPhoneNo:'';
	$varMobileNo			= addslashes(strip_tags(trim($_REQUEST['mobileNo'])));
	$varMobileNo			= ($varMobileNo != 'Mobile number' && $varMobileNo != '')?$varMobileNo:'';
	$varEmail				= addslashes(strip_tags(trim($_REQUEST['email'])));
	$varPassword			= addslashes(strip_tags(trim($_REQUEST['password'])));
	$varConfirmPassword			= addslashes(strip_tags(trim($_REQUEST['confirmPassword'])));
	$varAboutMyself			= addslashes(strip_tags(trim($_REQUEST['DESCDET'])));
	$varPartnerPreference	= addslashes(strip_tags(trim($_REQUEST['partnerPreference'])));
	$varAboutMyPartner		= addslashes(strip_tags(trim($_REQUEST['aboutMyPartner'])));
	$varTermsAndConditions		= $_REQUEST['termsAndConditions'];

    $varDOB					= $varYear.'-'.$varMonth.'-'.$varDay;
	if($varAreaCode != '') { $varPhoneNumber = $varCountryCode.'~'.$varAreaCode.'~'.$varPhoneNo; }
	if ($varMobileNo !='') { $varMobileNumber = $varCountryCode.'~'.$varMobileNo; }

	// started by barani on may13-2010
    // server side validation
	//ini_set('display_errors',1);
	
	if(isset($_REQUEST['domainName'])) {  
	   $objValidate->isInputNull($varMainDomainName,'Select the domain of the prospect');
	}
	$objValidate->isInputNull($varProfileCreatedBy,'Select your relationship with the prospect');
    $objValidate->isInputNull($varNickName,'Enter the display name of the prospect');
    $objValidate->isInputNull($varGender,'Select the gender of the prospect');
	
	$varTempAge = 1;
	if($varDOB == '0-0-0' && $varAge == 0) {
	  $varTempAge = 0;
	}
	$objValidate->isInputNull($varTempAge,'Enter the age or select the date of birth of the prospect');
    $objValidate->isInputNull($varMaritalStatus,'Select the marital status of the prospect');
	$objValidate->isInputNull($varHeightFeet,'Select the height of the prospect');
	$objValidate->isInputNull($varEducationSubcategory,'Please select the education category of the prospect');
	$objValidate->isInputNull($varOccupation,'Select the occupation of the prospect');
	if($varOccupation != 888) {
      $objValidate->isInputNull($varEmploymentCategory,'Select the employment category of the prospect');
	  if($varEmploymentCategory != 5) {
	   $objValidate->isInputNull($varAnnualIncomeCurrency,'Please select the Annual Income Currency'); 
	   $objValidate->isInputNull($varAnnualIncome,'Please select Annual Income');
	  }
	}
	$objValidate->isInputNull($varCountry,'Select the country of living of the prospect');
	//$objValidate->isInputNull($varResidingState,'Select the residing state of the prospect');
	//$objValidate->isInputNull($varResidingCity,'Select the residing District of the prospect');
	
	$objValidate->validateEmail($varEmail);
    
	if(empty($varCountryCode)) {
	  $varTempPhone = 0;
	}
	else {
	  if($varMobileNo) {
	    $varTempPhone = 1;
	  }
	  else if($varAreaCode && $varPhoneNo) {
	    $varTempPhone = 1;
	  }
	  else {
	    $varTempPhone = 0;
	  }
	}
	$objValidate->isInputNull($varTempPhone,'Please enter a valid contact number else members will not be able to contact you. If you&rsquo;re adding a landline number, ensure that you add the correct STD/ISD code.');
    $objValidate->isInputNull($varMotherTongue,'Select the mother tongue of the prospect');
	if($varMotherTongue=="9997")
	{
	  if($varMotherTongueText=="")
		 {
          $objValidate->isInputNull($varMotherTongueText,'Enter the mother tongue of the prospect');
	     }
	}
	$objValidate->isInputNull($varFamilyValue,'Please select the family value of the prospect');
	$objValidate->isInputNull($varFamilyType,'Please select the family type of the prospect');
	$objValidate->isInputNull($varFamilyStatus,'Please select the family status of the prospect');
	$objValidate->isInputNull($varPassword,'Enter your password');
    $objValidate->isInputNull($varConfirmPassword,'Enter your confirm password');
	$objValidate->isInputNull($varAboutMyself,'Enter a profile description in not less than 50 characters');
	$objValidate->isInputNull($varAboutMyPartner,'Please enter partner details of the prospect');
	$objValidate->isInputNull($varGetMarried,'Select the how soon you want to get married of the prospect');
	$objValidate->isInputNull($varTermsAndConditions,'Please accept Terms and Conditions');
	// ended by barani //
    
	//include_once($varRootBasePath.'/www/register/registerSvrValidation.php');
	//if($clsSvrValidation -> errorFlag == "")
	//{
      if(count($errors) == '0') {
		
		$varNoOfTimeOccurs='0';
		//CHECK ONE EMAIL PER ID
		$argTblName			= $varTable['MEMBERLOGININFO'].' mli,'. $varTable['MEMBERINFO'] .' mi';
		$argCondition		= " WHERE mli.".$varWhereClause." AND mli.Email='".$varEmail."' AND mli.MatriId = mi.MatriId";
		$varNoOfTimeOccurs	= $objRegister->numOfRecords($argTblName, $argPrimary='mli.MatriId', $argCondition);
       
		if ($varNoOfTimeOccurs=='0')  { //maximum 1 same emails allowed 

		//GENERATE 'MatriId'
		$varFields			= array('CommunityId');
		$varFieldsValues	= array("'".$confValues['DOMAINCASTEID']."'");
		$VarMatriIdNo		= $objRegister->insert($varTable['MATRIIDINFO'],$varFields,$varFieldsValues);
		$varMatriId			= $arrDomainInfo[$varDomain][1].$VarMatriIdNo;
		$varCryptSalt = crypt($varMatriId,$varSalt);

		//GET IPADDRESS
		$varIPAddress			= $objRegister->getIPAddress();

		if ($varAge !="") {  $varAge = $varAge; $varDOB="";}
		else { $varAge = $objCommon->ageCalculate($varYear, $varMonth, $varDay); }//else

		//GETTING PARTNER INFORMATION
		if($varGender==1){
			$funPartnerStartAge		= getPPAge($varAge, $varGender);
			$funPartnerEndAge		= $varAge;
			$funPartnerStartHeight	= $varHeightFeet-30.48; 
			if($varAge>=39)
			$funPartnerStartHeight	= $varHeightFeet-45.72; 
			if($funPartnerStartHeight<121.92)
			$funPartnerStartHeight	= 121.92;
			$funPartnerEndHeight	= $varHeightFeet;
			$funPartnerEducation	= $arrPPMaleEducation[$arrEducationMapping[$varEducationSubcategory]];
		}else{
			$funPartnerStartAge		= $varAge<$varMStartAge ? $varMStartAge : $varAge;
			$funPartnerEndAge		= getPPAge($varAge, $varGender);
			$funPartnerStartHeight	= $varHeightFeet;
			$funPartnerEndHeight	= $varHeightFeet+30.48;
			if($varAge>=31)
			$funPartnerEndHeight	= $varHeightFeet+45.72; 
			if($funPartnerEndHeight>241.30) 
			$funPartnerEndHeight	= 241.30;
			$funPartnerEducation	= $arrPPFemaleEducation[$arrEducationMapping[$varEducationSubcategory]];
		}//else
		$funPartnerMaritalStatus	= $arrPPMaritalStatus[$varMaritalStatus];
		$funPartnerCitizenship		= $varCitizenship;
		$funPartnerMotherTongue		= $varMotherTongue;
		$funPartnerPhysicalStatus	= $varPhysicalStatus;
		
		$funPartnerReligion			= '';
		$funPartnerDenomination		= '';
		$funPartnerCaste			= '';
		$funPartnerSubcaste			= '';
		$funPartnerHaveChildren     = '';   
		$funPartnerEmployed_In      = '';   
		$funPartnerOccupation       = '';   
		$funPartnerGothramId        = '';   
		$funPartnerStar             = '';   
		$funPartnerRaasi            = '';   
		$funPartnerChevvai_Dosham   = '';   
		$funPartnerResident_District= '';   
		$funPartnerIncludeOtherReligion= '';
		$funPartnerStIncome         = '';   
		$funPartnerEndIncome        = ''; 
		$varCommunityId				= $confValues['DOMAINCASTEID'];

		if($varCommunityId>=2000 && $varCommunityId<=2006){
		//Fortyplus / Divorcee / Anycaste / Ability / Manglik / Doctors/ Defence
		$funPartnerReligion			= $arrPPReligion[$varReligion];
		}else{
		$funPartnerReligion			= $varReligion;
		}
		$funPartnerDenomination		= $varDenomination;
		$funPartnerCaste			= $varCaste;
		$funPartnerSubcaste			= $varSubCaste;

		if($varAnnualIncomeCurrency!=98) {
			$income_inr = round(getInrValue($objRegister, $varAnnualIncomeCurrency, $varAnnualIncome));
		} else {
			$income_inr=$varAnnualIncome;
		}

		//INSERT RECORDS INTO memberinfo TABLE
		$argFields				= array('MatriId','User_Name','Name','Nick_Name','Age','Dob','Gender','Height','Height_Unit','Physical_Status','Marital_Status','No_Of_Children','Children_Living_Status','Education_Category','Education_Subcategory','Occupation','Employed_In','Income_Currency','Annual_Income','Religion','ReligionText','CommunityId','CasteId','CasteText','Mother_TongueId','Mother_TongueText','Country','Citizenship','Contact_Phone','Contact_Mobile','About_Myself','About_MyPartner','IPAddress','Profile_Created_By','When_Marry','Partner_Set_Status','Family_Set_Status','Appearance','Religious_Values','Ethnicity','Publish','Last_Login','Date_Created','Date_Updated','Temp_Annual_Income','Country_Of_Birth');

		$argFieldsValues		= array("'".$varMatriId."'","'".$varMatriId."'","'".$varName."'","'".$varNickName."'","'".$varAge."'","'".$varDOB."'","'".$varGender."'","'".$varHeightFeet."'","'".$varHeightUnit."'","'".$varPhysicalStatus."'","'".$varMaritalStatus."'","'".$varNoOfChildren."'","'".$varChildLivingStatus."'","'".$varEducationCategory."'","'".$varEducationSubcategory."'","'".$varOccupation."'","'".$varEmploymentCategory."'","'".$varAnnualIncomeCurrency."'","'".$varAnnualIncome."'","'".$varReligion."'","'".$varReligionOthers."'","'".$confValues['DOMAINCASTEID']."'","'".$varCaste."'","'".$varCasteText."'","'".$varMotherTongue."'","'".$varMotherTongueText."'","'".$varCountry."'","'".$varCitizenship."'","'".$varPhoneNumber."'","'".$varMobileNumber."'","'".$varAboutMyself."'","'".$varAboutMyPartner."'","'".$varIPAddress."'","'".$varProfileCreatedBy."'","'".$varGetMarried."'",'0','1',"'".$varAppearance."'","'".$varReligiousValues."'","'".$varEthnicity."'","'".$varPublish."'","'".$varCurrentDate."'","'".$varCurrentDate."'","'".$varCurrentDate."'","'".$income_inr."'","'".$varPlaceOfBirth."'");

		if($varCountry == 98 || $varCountry == 222 || $varCountry == 195 || $varCountry == 162){
			array_push($argFields,'Residing_State');
			array_push($argFieldsValues,"'".$varResidingState."'");
		} else {
			array_push($argFields,'Residing_Area');
			array_push($argFieldsValues,"'".$varResidingState."'");
		}

		$varTollFreeNo = '';
		if($varCountry == 98 || $varCountry == 162){
			array_push($argFields,'Residing_District');
			array_push($argFieldsValues,"'".$varResidingCity."'");
			$varMatriIdPre	= substr($varMatriId,0,3);
			$varLinkClr		= array_key_exists($varMatriIdPre, $arrMailerLinkClr) ? $arrMailerLinkClr[$varMatriIdPre] : '#FF6000'; 
			$varTollFreeNo = '<tr><td width="536"><table border="0" cellspacing="0" cellpadding="0" width="477" align="center">
		   <tr><td background="<--MAILERIMGSPATH-->/tollfree.gif" height="61" style="padding-left:85px;font:normal 12px arial;color:#606060;">Need help? Call <font style="font-size:20px;font-weight:bold;">1800-3000-2222</font> (Toll Free)<br>or <a href="<--SERVERURL-->/site/index.php?act=LiveHelp" style="color:'.$varLinkClr.';text-decoration:none;">Chat Live</a> with a customer care person.</td></tr></table></td></tr><tr><td height="15"></td></tr>';
		} else {
			array_push($argFields,'Residing_City');
			array_push($argFieldsValues,"'".$varResidingCity."'");
		}
		$objRegister->insert($varTable['MEMBERINFO'],$argFields,$argFieldsValues);

		//INSERT RECORD INTO memberlogininfo TABLE
		$argFields 				= array('MatriId','User_Name','Email','Password','Date_Updated','CommunityId');
		$argFieldsValues		= array("'".$varMatriId."'","'".$varMatriId."'","'".$varEmail."'","'".$varPassword."'","'".$varCurrentDate."'","'".$confValues['DOMAINCASTEID']."'");
		$objRegister->insert($varTable['MEMBERLOGININFO'],$argFields,$argFieldsValues);

		//INSERT RECORD INTO assuredcontactbeforevalidation TABLE
		$varPinNo		= getPinNo($objRegister,$varTable['ASSUREDCONTACTPINNOSERIES']);
		$argFields		= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneStatus1');
		$argFieldsValues= array("'".$varPinNo."'","'".$varMatriId."'","NOW()","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'0'");
		if($varMobileNumber != ''){
			array_push($argFields,'PhoneNo1');
			array_push($argFieldsValues,"'".$varMobileNumber."'");
		} else if($varPhoneNumber != ''){
			array_push($argFields,'PhoneNo1');
			array_push($argFieldsValues,"'".$varPhoneNumber."'");
		}
		$varInsertId	= $objRegister->insert($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argFieldsValues);

		//INSERT RECORD INTO memberfamilyinfo TABLE
		$argFields 				= array('MatriId','Family_Value','Family_Type','Family_Status','Date_Updated');
		$argFieldsValues		= array("'".$varMatriId."'","'".$varFamilyValue."'","'".$varFamilyType."'","'".$varFamilyStatus."'","'".$varCurrentDate."'");
		$objRegister->insert($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues);

		//INSERT RECORD INTO memberpartnerinfo TABLE
		$argFields				= array('CommunityId','MatriId','Age_From','Age_To','Height_From','Height_To','Looking_Status','Physical_Status','Education', 'Religion','Denomination','CasteId','SubcasteId','Citizenship','Mother_Tongue','Date_Updated');
		$argFieldsValues		= array("'".$confValues['DOMAINCASTEID']."'", "'".$varMatriId."'", "'".$funPartnerStartAge."'", "'".$funPartnerEndAge."'", "'".$funPartnerStartHeight."'", "'".$funPartnerEndHeight."'", "'".$funPartnerMaritalStatus."'", "'".$funPartnerPhysicalStatus."'", "'".$funPartnerEducation."'", "'".$funPartnerReligion."'", "'".$funPartnerDenomination."'", "'".$funPartnerCaste."'", "'".$funPartnerSubcaste."'", "'".$funPartnerCitizenship."'", "'".$funPartnerMotherTongue."'", "'".$varCurrentDate."'");
		$objRegister->insert($varTable['MEMBERPARTNERINFO'],$argFields,$argFieldsValues);

		//INSERT PAYMENT TRACKING TABLE
		if ($varCategory !="") {
			$argFields			= array('MatriId','Source_From','Date_Captured','Date_Registered','Product_Id','Paid_Status');
			$argFieldsValues	= array("'".$varMatriId."'",'1',"'".$varCurrentDate."'","'".$varCurrentDate."'","'".$varCategory."'",'0');
			$objRegister->insert($varTable['PREPAYMENTTRACKINFO'],$argFields,$argFieldsValues);
		}

		//CREATE SESSION MatriId FOR LOGIN VALIDATION
		$varLastLogin		= '0000-00-00 00:00:00';
		$varPaidStatus		= 0;
		$varOfferAvailable	= 0;
		$varCookieName		= $varNickName ? $varNickName : $varName;

		header('Set-Cookie: loginInfo='.$varMatriId.'^|'.$varGender.'^|'.$varStatus.'^|'.$varLastLogin.'^|'.$varPublish.'^|'.$varCryptSalt.'^|'.$varPaidStatus.'^|'.$varExpiryDate.'^|'.$varDefaultView.'^|'.$varActivityRank.'^|'.$varCookieName.'^|'.$varNickName.'^|'.$PCV["profile_completeval"].'^|'.$varPhoto.'^|'.$varEducation.'^|'.$varState.'^|'.$varCity.'^|'.$messagecookievalue[0].'^|'.$PCV["profilecompleteness"].'^|'.$varReligion.'^|'.$varValidDaysLeft.'^|'.$varCurrentDate.'^|'.$profcreatedwithin.'^|'.$profcreatedwithin.'^|'.$messagecookievalue[1].'^|'.$profilematchcookvalue.'^|'.$varCasteDivision.'^|'.$varOfferAvailable.'^|'.$varAge.'^|'.$varMotherTongue.'^|'.$varGothram.';path=/;domain='.$confValues['DOMAINNAME'].';');

		$varPartnerDetails	= $funPartnerStartAge.'~'.$funPartnerEndAge.'^|'.$funPartnerStartHeight.'~'.$funPartnerEndHeight.'^|'. $funPartnerMaritalStatus.'^|'.$funPartnerPhysicalStatus.'^|'.$funPartnerMotherTongue.'^|'.$funPartnerReligion. '^|'.$funPartnerCaste.'^|0^|'.$funPartnerEducation.'^|'.$funPartnerCitizenship.'^|0^|0^|0^|0^|0^|0^|'.$funPartnerSubcaste.'^|'. $funPartnerDenomination.'^|'.$funPartnerHaveChildren.'^|'.$funPartnerEmployed_In.'^|'.$funPartnerOccupation.'^|'.$funPartnerGothramId.'^|'.$funPartnerStar.'^|'.$funPartnerRaasi.'^|'.$funPartnerChevvai_Dosham.'^|'.$funPartnerResident_District.'^|'.$funPartnerIncludeOtherReligion.'^|'.$funPartnerStIncome.'^|'.$funPartnerEndIncome;
		setrawcookie("partnerInfo","$varPartnerDetails", "0", "/",$confValues['DOMAINNAME']);

 		$varMessagesInfo	= '0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0';
		setrawcookie("messagesInfo",$varMessagesInfo, "0", "/",$confValues['DOMAINNAME']);

		setrawcookie("savedSearchInfo","", "0", "/",$confValues['DOMAINNAME']);

		$varProfileValue	= $varPublish.'^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0';
		setrawcookie("profileInfo",$varProfileValue, "0", "/",$confValues['DOMAINNAME']);

		$varRequestReceivedValue	= '0^|0^|0^|0';
		setrawcookie("requestReceivedInfo",$varRequestReceivedValue, "0", "/",$confValues['DOMAINNAME']);

		$varRequestSentValue	= '0^|0^|0^|0';
		setrawcookie("requestSentInfo",$varRequestSentValue, "0", "/",$confValues['DOMAINNAME']);

		$varListValue	= '0^|0^|0';
		setrawcookie("listInfo",$varListValue, "0", "/",$confValues['DOMAINNAME']);

		$varViewsValue	= '0^|0^|0';
		setrawcookie("viewsInfo",$varViewsValue, "0", "/",$confValues['DOMAINNAME']);

		//SEND MAIL
		//$varEmail	= 'dhanapal.n@gmail.com';
		$objmailManager->sendRegistrationConfirmationMail($varName,$varMatriId,$varPassword,$varEmail,$confValues['SERVERURL'],$varTollFreeNo);

		//CLOSE DATABASE CONNECTION
		$objRegister->dbClose();
		UNSET($objRegister);
		UNSET($objmailManager);
		UNSET($objCommon);
		UNSET($objDomainInfo);
		

	$varDomainRedirectURL = "index.php?act=congrats&partlyId=".$varPartlyId;
	if ($varMainDomainName !=""){ $varDomainRedirectURL	= $varRedirectDomain."index.php?act=cbsregister&partlyId=".$varPartlyId; }

		header("Location: ".$varDomainRedirectURL);exit;
		//header("Location: ".$varMainDomainURL."&partlyId=".$varPartlyId);exit;
		

		//} else { $varAct = 'addbasic'; $varErrorPage='yes';}//else
		} else { $varAct = 'addbasic'; $errors[] = "You have already registered on ".$confValues["PRODUCTNAME"].".com using the same E-mail ID.";$varErrorPage='yes';}
	  }
	  else {
	     $varAct = 'addbasic';$varErrorPage='yes';
      }
}
function getInrValue($dbslave, $iCurrencyCode, $income){
  global $DBNAME,$varTable;
  $argFields		= array('ConvertedINRvalue');
  $argCondition	    = "where BaseCurrency='".$iCurrencyCode."'";
  $iInrCnt          = $dbslave->select($varTable['CURRENCYCONVERSIONRATES'],$argFields,$argCondition,0);
  $datInr	        = mysql_fetch_assoc($iInrCnt);
  
  if(!empty($datInr)){
    if($income)
      $iInrIncome = $income* $datInr['ConvertedINRvalue'];
    if(empty($iInrIncome))
      $iInrIncome = 0;
  }else{
    $iInrIncome = 0;
  }
  return $iInrIncome;
}
?>