<?php
#=============================================================================================================
# Author   : S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date : 2006-06-19
# End Date  : 2006-06-21
# Project  : MatrimonyProduct
# Module  : Registration - Basic
#=============================================================================================================
if($_REQUEST["frmLoginSubmit"]=="yes")
{
 //FILE INCLUDES
 include_once($varRootBasePath."/conf/dbinfo.cil14");
 include_once($varRootBasePath."/conf/memcache.cil14");
 
 include_once($varRootBasePath."/conf/basefunctions.cil14");
 include_once($varRootBasePath."/lib/clsDB.php");
 include_once($varRootBasePath."/lib/clsInactive.php");
 include_once($varRootBasePath.'/lib/clsCache.php');
 include_once($varRootBasePath."/lib/clsLogin.php");
 
 
 //OBJECT DECLARTION
 $objMasterDB = new Login;
 $objSlaveDB  = new Login;
 $objInactive = new Inactive;
 

 //DB CONNECTION
 $objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
 $objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
 
 
 //VARIABLE DECLARATIONS
 $varCurrentDate = date('Y-m-d H:i:s');
 $varUsername = trim($_REQUEST["idEmail"]);
 $varPassword = trim($_REQUEST["password"]);
 $varCheckLogin = 0;
 $varDomainName = $confValues["DOMAINNAME"];
 $varRedirect = trim($_REQUEST['redirect']);
 $varRedirect = $varRedirect ? $varRedirect.'&auto=1' : $confValues['SERVERURL'].'/profiledetail/?promo=yes';
 $varCountryCode = trim($_REQUEST['countryCode']);
 $varOpenIp  = $varChat['OPENFIRE'];
 
 //PRIMARY VALUES
 if ($_POST['chooseLogin']=='yes') { 
	$argCondition = ' WHERE '.$varWhereClause." AND MatriId=".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB);
 }
 else {
	 if (strpos($varUsername, '@')) {  $varPrimary = 'Email'; } else { $varPrimary = 'MatriId'; }//else
	$argCondition = ' WHERE '.$varWhereClause.' AND '.$varPrimary."=".$objSlaveDB->doEscapeString($varUsername,$objSlaveDB)." AND Password=".$objSlaveDB->doEscapeString($varPassword,$objSlaveDB);



 }
 $varCheckLogin = $objSlaveDB->numOfRecords($varTable['MEMBERLOGININFO'], 'MatriId', $argCondition);
 
 // INACTIVE ENABLED CODE added Barani and Dhanapal (2010-08-09) // 
 if($varCheckLogin == 0) {

	$varCheckLogin = $objSlaveDB->numOfRecords($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'], 'MatriId', $argCondition);

   if($varCheckLogin > 0) {

		if ($varPrimary == 'Email') {

		$argFields   = array('MatriId');
		$varExecute   = $objSlaveDB->select($varInactiveDbInfo['DATABASE'].'.'.$varTable['MEMBERLOGININFO'], $argFields, $argCondition,0);
		$varSelectInactiveInfo= mysql_fetch_assoc($varExecute);
		$varMatriId   = $varSelectInactiveInfo["MatriId"];

		} else { $varMatriId = $varUsername; }

		$objInactive->moveFromInactiveToActive($varWhereClause,$varMatriId,$objMasterDB);
   }
 }
 // END INACTIVE CODE//

 //IF MULTIPLE LOGIN COMES USING EMAIL WITH SAME PASSWORD
 if ($varCheckLogin > 1) { $varAct   = 'chooselogin'; }
 else if ($varCheckLogin==1) {  //USERNAME && MATRIID NOT AVAILABLE IN DB (*ND 20060926)
  //SELECT MatriId
  $argFields   = array('MatriId');
  $varExecute   = $objSlaveDB->select($varTable['MEMBERLOGININFO'], $argFields, $argCondition,0);
  $varSelectLoginInfo1= mysql_fetch_assoc($varExecute);
  $varMatriId   = $varSelectLoginInfo1["MatriId"];
 

  $argFields   = array('User_Name','MatriId','BM_MatriId','Name','Nick_Name','Paid_Status','Gender','Last_Login','Status','Publish',' TO_DAYS(NOW())-TO_DAYS(Date_Created) as CreatedWithin','Valid_Days',' (Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment))) as ValidDaysLeft','Date_Created','Religion','CasteId','GothramId','Marital_Status','Age','Photo_Set_Status','Partner_Set_Status','Video_Set_Status','Horoscope_Available','Last_Payment','UNIX_TIMESTAMP(Last_Login) as LastLoginTimeStamp','Country','Web_Notification','Number_Of_Payments','Phone_Verified','Family_Set_Status','Reference_Set_Status','Special_Priv','DATE_FORMAT(DATE_ADD(Last_Payment, interval Valid_Days day), "%D %M %Y") as ExpiryDate','Education_Category','Residing_State','Residing_Area','Residing_City','US_Paid_Validated','DATE_ADD(Last_Payment',' interval Valid_Days day) as DateofExpiry','Profile_Created_By','Expiry_Date','Default_View','Activity_Rank','Profile_Verified','Interest_Set_Status','Voice_Available','Phone_Verified','OfferAvailable','OfferCategoryId','Mother_TongueId');
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varExecute   = $objSlaveDB->select($varTable['MEMBERINFO'], $argFields, $argCondition,0);
  $varSelectLoginInfo = mysql_fetch_assoc($varExecute);
 
  //FOR mem cache integration
  //$objSlaveMemcache->clearLogData();
  //$varSelectLoginInfo = $objSlaveMemcache->select($varTable['MEMBERINFO'], $argFields, $argCondition, 0, Login_MemberInfo);
  //echo $objSlaveMemcache->getLogData();
 
  $varMatriId   = $varSelectLoginInfo["MatriId"];
  $varName   = $varSelectLoginInfo["Name"];
  $varNickName  = $varSelectLoginInfo["Nick_Name"];
  $varUsername  = $varSelectLoginInfo["User_Name"];
  $varPaidStatus  = $varSelectLoginInfo['Paid_Status'];
  $varGender   = $varSelectLoginInfo['Gender'];
  $varLastLogin  = $varSelectLoginInfo['Last_Login'];
  $varStatus   = $varSelectLoginInfo['Status'];
  $varPublish   = $varSelectLoginInfo["Publish"];
  $varCreatedWithin = $varSelectLoginInfo['CreatedWithin'];
  $varValidDaysLeft = $varSelectLoginInfo['ValidDaysLeft'];
  $varDateCreated  = $varSelectLoginInfo['Date_Created'];
  $varReligion  = $varSelectLoginInfo['Religion'];
  $varCasteOrDivision = $varSelectLoginInfo['CasteId'];
  $varGothram = $varSelectLoginInfo['GothramId'];
  $varMaritalStatus = $varSelectLoginInfo['Marital_Status'];
  $varAge    = $varSelectLoginInfo['Age'];
  $varPhotoSetStatus = $varSelectLoginInfo['Photo_Set_Status'];
  $varActivityRank = $varSelectLoginInfo['Activity_Rank'];
  $varExpiryDate  = $varSelectLoginInfo['Expiry_Date'];
  $varNumberOfPayments= $varSelectLoginInfo['Number_Of_Payments'];
  $varBMMatriId  = $varSelectLoginInfo['BM_MatriId'];
  $varUSPaidValidated	= $varSelectLoginInfo['US_Paid_Validated'];
 
 
  $varPartnerSetStatus = $varSelectLoginInfo['Partner_Set_Status'];
  $varVideoSetStatus  = $varSelectLoginInfo['Video_Set_Status'];
  $varHoroscopeAvailable = $varSelectLoginInfo['Horoscope_Available'];
  $varPaidDate   = $varSelectLoginInfo['Last_Payment'];
  $varLastLoginTimeStamp = $varSelectLoginInfo['LastLoginTimeStamp'];
  $varCountry    = $varSelectLoginInfo['Country'];
  $varWebNotification  = $varSelectLoginInfo['Web_Notification'];
  $varValidDays   = $varSelectLoginInfo["Valid_Days"];
 

  $varFamilySetStatus  = $varSelectLoginInfo['Family_Set_Status'];
  $varHobbiesAvailable = $varSelectLoginInfo['Interest_Set_Status'];
  $varPartnerSetStatus = $varSelectLoginInfo['Partner_Set_Status'];
  $varPhotoSetStatus  = $varSelectLoginInfo['Photo_Set_Status'];
  $varVideoSetStatus  = $varSelectLoginInfo['Video_Set_Status'];
  $varVoiceAvailable  = $varSelectLoginInfo['Voice_Available'];
  $varReferenceSetStatus = $varSelectLoginInfo['Reference_Set_Status'];
  $varPhoneVerified  = $varSelectLoginInfo['Phone_Verified'];
  $varOfferAvailable  = $varSelectLoginInfo['OfferAvailable'];
  $varOfferCategoryId  = $varSelectLoginInfo['OfferCategoryId'];
  $varMotherTongue  = $varSelectLoginInfo['Mother_TongueId'];

 
 
  //LOGIN INFO DETAILS
  if ($varPublish==3){ echo '<script language="javascript">document.location.href="index.php?act=suspendprofile&sid='.$varMatriId.'"</script>';exit; }//if
 
	$varProductId	= 0;
	if($varPaidStatus==1 ) { //&& $varBMMatriId==''

		$argFields				= array('Product_Id','Offer_Product_Id');
		$argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB)." AND Product_Id<100 ORDER BY Date_Paid DESC LIMIT 1";
		$varExecute				= $objSlaveDB->select($varTable['PAYMENTHISTORYINFO'], $argFields, $argCondition,0);
		$varSelectProductInfo	= mysql_fetch_assoc($varExecute);
		$varProductId		= $varSelectProductInfo["Product_Id"];
		$varOfferProductId	= $varSelectProductInfo["Offer_Product_Id"];
		if ($varOfferProductId > 0 ) { $varProductId = $varOfferProductId;  }

	}//if
 
  //UPDATE LAST LOGIN INTO memberinfo TABLE
  if($_COOKIE['partialflag']==0 || !$_COOKIE['partialflag']){
  $argFields  = array('Last_Login');
  $argFieldsValue = array("'".$varCurrentDate."'");
  $argCondition = " MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
  $objMasterDB->update($varTable['MEMBERINFO'], $argFields, $argFieldsValue, $argCondition);
  }
 
  $argCondition	= " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $argFields	= array('Normal_Photo1','Photo_Status1');
  $varExecute	= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $argFields, $argCondition,0);
  $varPhotoInfo	= mysql_fetch_assoc($varExecute);
  $varPhotoName	= $varPhotoInfo["Normal_Photo1"].'~'.$varPhotoInfo["Photo_Status1"];
 
  //SET COOKIE
  $varCryptSalt    = crypt($varMatriId,$varSalt);
  $varDefaultView   = 0;
  $profile_completeval = 'PC';
  $varEducation   = 'EDU';
  $varState    = 'STATE';
  $varCity    = 'CITY';
  $messagecookievalue  = 'MSG';
  $profilecompleteness = 0;
  $profcreatedwithin  = 1;
  $profilematchcookvalue = 1;
  $caste     = 1;
 
  $varBookMarkCnt = 0;$varBlockCnt=0;
  
  //SELECT PHONE COUNT
  $argCondition = " WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varPhoneCnt  = $objSlaveDB->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $argCondition);
 
  $varCookieValue = $varMatriId.'^|'.$varGender.'^|'.$varStatus.'^|'.$varLastLogin.'^|'.$varPublish.'^|'.$varCryptSalt.'^|'.$varPaidStatus.'^|'.$varExpiryDate.'^|'.$varDefaultView.'^|'.$varActivityRank.'^|'.$varName.'^|'.$varNickName.'^|'.$profile_completeval.'^|'.$varPhotoName.'^|'.$varEducation.'^|'.$varState.'^|'.$varCity.'^|'.$messagecookievalue.'^|'.$profilecompleteness.'^|'.$varReligion.'^|'.$varValidDaysLeft.'^|'.$varDateCreated.'^|'.$varCreatedWithin.'^|'.$profcreatedwithin.'^|'.$messagecookievalue.'^|'.$profilematchcookvalue.'^|'.$caste.'^|'.$varOfferAvailable.'^|'.$varOfferCategoryId.'^|'.$varAge.'^|'.$varMotherTongue.'^|'.$varGothram;
  header("set-cookie:loginInfo=$varCookieValue;path=/;domain=$varDomainName");

  //UPDATE LIST COOKIE
  $varProfileValue = $varPublish.'^|'.$varPaidStatus.'^|'.urlencode($varExpiryDate).'^|'.urlencode($varPhotoName).'^|'.$varFamilySetStatus.'^|'.$varHobbiesAvailable.'^|'.$varPartnerSetStatus.'^|'.$varPhotoSetStatus.'^|'.$varVideoSetStatus.'^|'.$varVoiceAvailable.'^|'.$varReferenceSetStatus.'^|'.$varBookMarkCnt.'^|'.$varPhoneCnt.'^|'.$varPhoneVerified.'^|'.$varProductId.'^|'.urlencode($varPaidDate).'^|'.$varNumberOfPayments.'^|'.$varValidDaysLeft.'^|'.$varHoroscopeAvailable.'^|'.$varUSPaidValidated.'^|'.$varBlockCnt;
  setrawcookie("profileInfo","$varProfileValue", "0", "/",$confValues['DOMAINNAME']);
 
  //offer detail
  include_once($varRootBasePath."/www/login/offerpopup.php");
 
  //CHECK PARTNER PREFERENCE COOKIES
 
  $argFields  = array('Email_Type','Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Height_Unit','Weight_From','Weight_To','Physical_Status','Education','Religion','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_USA_State','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Denomination','Employed_In','Occupation','GothramId','Star','Raasi','Resident_District','IncludeOtherReligion','StIncome','EndIncome');
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
  $varExecute  = $objSlaveDB->select($varTable['MEMBERPARTNERINFO'], $argFields, $argCondition,0);
  $varPartnerInfo = mysql_fetch_assoc($varExecute);
  $varPartnerDetails=$varPartnerInfo['Age_From'].'~'.$varPartnerInfo['Age_To'].'^|'.$varPartnerInfo['Height_From'].'~'.$varPartnerInfo['Height_To'].'^|'.$varPartnerInfo['Looking_Status'].'^|'.$varPartnerInfo['Physical_Status'].'^|'.$varPartnerInfo['Mother_Tongue'].'^|'.$varPartnerInfo['Religion'].'^|'.$varPartnerInfo['CasteId'].'^|'.$varPartnerInfo['Eating_Habits'].'^|'.$varPartnerInfo['Education'].'^|'.$varPartnerInfo['Citizenship'].'^|'.$varPartnerInfo['Country'].'^|'.$varPartnerInfo['Resident_India_State'].'^|'.$varPartnerInfo['Resident_USA_State'].'^|'.$varPartnerInfo['Resident_Status'].'^|'.$varPartnerInfo['Smoking_Habits'].'^|'.$varPartnerInfo['Drinking_Habits'].'^|'.$varPartnerInfo['SubcasteId'].'^|'.$varPartnerInfo['Denomination'].'^|'.$varPartnerInfo['Have_Children'].'^|'.$varPartnerInfo['Employed_In'].'^|'.$varPartnerInfo['Occupation'].'^|'.$varPartnerInfo['GothramId'].'^|'.$varPartnerInfo['Star'].'^|'.$varPartnerInfo['Raasi'].'^|'.$varPartnerInfo['Chevvai_Dosham'].'^|'.$varPartnerInfo['Resident_District'].'^|'.$varPartnerInfo['IncludeOtherReligion'].'^|'.$varPartnerInfo['StIncome'].'^|'.$varPartnerInfo['EndIncome'];
  setrawcookie("partnerInfo","$varPartnerDetails", "0", "/",$confValues['DOMAINNAME']);
 
  //UPDATE COOKIE
  $sessMatriId = $varMatriId;
  include_once($varRootBasePath."/www/login/updatemessagescookie.php");
  setMessagesCookie($sessMatriId,$objSlaveDB);
  setRequestReceivedCookie($sessMatriId,$objSlaveDB);
  setRequestSentCookie($sessMatriId,$objSlaveDB);
  setViewsInfoCookie($sessMatriId,$objSlaveDB);

  //SELECT SAVED SEARCH DETAILS
  $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB)." ORDER BY Date_Updated DESC LIMIT 0,3";
  $varNoOfRecord = $objSlaveDB->numOfRecords($varTable['SEARCHSAVEDINFO'], 'Search_Id', $argCondition);
  if ($varNoOfRecord > 0){
   $argFields     = array('Search_Id', 'Search_Name', 'Search_Type');
   $varResSelSavedSearchInfo = $objSlaveDB->select($varTable['SEARCHSAVEDINFO'], $argFields, $argCondition, 0);
   $varSavedSearchInfo   = '';
   while($row=mysql_fetch_assoc($varResSelSavedSearchInfo)){
    $varSavedSearchInfo .= $row['Search_Id'].'|'.$row['Search_Type'].'|'.$row['Search_Name'].'~';
   }//for
   $varSavedSearchInfo = trim($varSavedSearchInfo,'~');
   setcookie("savedSearchInfo","$varSavedSearchInfo", "0", "/",$confValues['DOMAINNAME']);
  }//if
  
  //Set ONLINE Status in Cache for sphinx
  if(Cache::getData('SPHX_ROTATEINDEX_ON')=='1') {
	  $varOnlineCacheSph	= ($varGender==1) ? 'SPHX_ONLINE_DETAIL_MALE' : 'SPHX_ONLINE_DETAIL_FEMALE';
	  $arrOldMatriIdDets	= Cache::getData("$varOnlineCacheSph");
	  if(!is_array($arrOldMatriIdDets)){$arrOldMatriIdDets=array();}
	  $arrNewMatriIdDet		= array();
	  $arrNewMatriIdDet[substr($varMatriId, 3)]['sphinxmemberinfo_'.$confValues['DOMAINCASTEID'].'_'.$varGender]=1;
	  //$arrNewMatriIdDet		= array("$varMatriId"=>1);
	  //$arrNewMatriIdDet		= array_merge($arrOldMatriIdDets, $arrNewMatriIdDet);
	  Cache::setData("$varOnlineCacheSph", $arrNewMatriIdDet);
  }

  //WRITE LOG FILE
  $varClientIP = getenv('REMOTE_ADDR');
  $varServerIP = getenv('SERVER_ADDR');
  $argFields  = array('MatriId','Logged_In_At','Client_IP','Server_IP');
  $argFieldsValue = array($objMasterDB->doEscapeString($varMatriId,$objMasterDB),"'".$varCurrentDate."'","'".$varClientIP."'","'".$varServerIP."'");
  $objMasterDB->insert($varTable['MEMBERLOGINLOG'], $argFields, $argFieldsValue);
  
  $objMasterDB->dbClose();
  $objSlaveDB->dbClose();
 
  UNSET($objMasterDB);
  UNSET($objSlaveDB);

  //Auto Redirect to card details page with offer..
  if ($varAutoRedirection!='') { $varRedirect = $varRedirect.$varAutoRedirection; }
 
  $varRedirect = preg_replace('/~/', '&', $varRedirect);
 
  if(trim($varMatriId)!='' && trim($varGender)!='') {
 
   $varCasteId = $confValues['DOMAINCASTEID'];
   $varGender = $varGender==1 ? 'M' : 'F';
    //echo "php memlogin_curl.php $varCasteId $varMatriId $varOpenIp $varGender";exit;
   $varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
   escapeexec("php memlogin_curl.php $varCasteId $varMatriId $varGender $varOpenIp",$varlogFile);
  }
 
  if($varPublish=='5') { $varRedirect = $confValues['SERVERURL'].'/register/?act=cbsregister'; }
 
  if ($varCountryCode !="") { header("Location: ".$varRedirect.'&matriId='.$varMatriId); exit; }
  else { header("Location: ".$varRedirect); exit; }
 
 }//if
 else {
  $varAct    = 'login';
  $varErrorMessage = 'Invalid Username / E-mail OR Incorrect Password';
 }//else
} else { $varAct = ''; }
?>