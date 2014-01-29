<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : deleteconfirmation.php
#=====================================================================================================================================
# Description : display	profile delete confirmation message. 
#=====================================================================================================================================
$varRootBasePath= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessUsername	= $varGetCookieInfo["USERNAME"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARATION
$objDBMaster	= new MemcacheDB;
$objMailManager	= new MailManager;

$objMailManager->dbConnect('S',$varDbInfo['DATABASE']);
$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varDomainName	= $confValues['DOMAINNAME'];
$varCurrentDate	= date('Y-m-d H:i:s');
$argCondition	= "WHERE MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
$varReason		= $_REQUEST["reason"];
$varComments	= $_REQUEST["comments"];

if($sessMatriId == ""){ echo '<script language="javascript">document.location.href="index.php"</script>'; }//if



//SETING MEMCACHE KEY
$varOwnProfileMCKey		= 'ProfileInfo_'.$sessMatriId;

if($_REQUEST['updatestatus'] == 'yes') {

	//SELECT MEMBERLOGIN INFO
	$argFields					= array('Email','Password','User_Name');
	$varSelectLoginInfoResult	= $objDBMaster->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	if(mysql_num_rows($varSelectLoginInfoResult)==1){
		$varSelectLoginInfo			= mysql_fetch_array($varSelectLoginInfoResult);

		//SELECT MEMBER FAMILY INFO
		$argFields					= array('Family_Value','Family_Type','Family_Status');
		$varSelectFamilyInfoResult	= $objDBMaster->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
		$varSelectFamilyInfo		= mysql_fetch_array($varSelectFamilyInfoResult);

		//SELECT MEMBERINFO
		$argFields					= array('Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_TongueId','Residing_State','Residing_Area','Residing_City','Residing_District','About_Myself','Profile_Created_By','Support_Comments','Date_Created','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments','Publish','Special_Priv','Body_Type','Complexion','Blood_Group','CommunityId','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','GothramId','GothramText','Star','Raasi','Chevvai_Dosham','Eating_Habits','Smoke','Drink','Income_Currency','Annual_Income','Residing_Area','Residing_District','Phone_Verified','Family_Set_Status','Interest_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Horoscope_Available','Horoscope_Protected','Horoscope_Match','Partner_Set_Status','Match_Watch_Email','Last_Login','Date_Updated','Time_Posted','Profile_Referred_By','Weight','Weight_Unit','Appearance','Denomination','Contact_Phone','Contact_Mobile');
		$varSelectMemberInfoResult	= $objDBMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMemberInfo		= mysql_fetch_array($varSelectMemberInfoResult);
        
        // added by barani to get phone no of member //
		// start //
		$argFields = array('PhoneNo1');
        if($varSelectMemberInfo['Phone_Verified'] == 1) {
		  $varExecute = $objDBMaster->select($varTable['ASSUREDCONTACT'], $argFields, $argCondition, 0);   
		}
	    else {
		  $varExecute = $objDBMaster->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'], $argFields, $argCondition, 0);
		}
        $varResRow=mysql_fetch_assoc($varExecute);
		$varPhone1 = $varResRow['PhoneNo1'];
		// end //


		if ($varSelectMemberInfo['Country']==98 || $varSelectMemberInfo['Country']==222) { $varResidingState = $varMemberInfo['Residing_State'];} //if
		else {$varResidingState = $varMemberInfo['Residing_Area'];} 

		if($varSelectMemberInfo["Country"]==98) { $varCityValue = $varSelectMemberInfo["Residing_District"]; } else { $varCityValue = $varSelectMemberInfo["Residing_City"]; }
		
		//INSERT ALL SELECTED TO memberdeletedinfo TABLE
		$varIPAddress = getenv('REMOTE_ADDR');
		$argFields 			= array('MatriId','Email','Password','Date_Created','Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_Tongue','Residing_State','Residing_City','About_Myself','Profile_Created_By','Family_Value','Family_Type','Family_Status','Deleted_Reason','Deleted_Comments','Support_Comments','Date_Deleted','User_Name','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments','IPAddress','Publish','Special_Priv','Body_Type','Complexion','Blood_Group','CommunityId','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','GothramId','GothramText','Star','Raasi','Chevvai_Dosham','Eating_Habits','Smoke','Drink','Income_Currency','Annual_Income','Residing_Area','Residing_District','Phone_Verified','Family_Set_Status','Interest_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Horoscope_Available','Horoscope_Protected','Horoscope_Match','Partner_Set_Status','Match_Watch_Email','Last_Login','Date_Updated','Time_Posted','Profile_Referred_By','Weight','Weight_Unit','Appearance','Denomination','Contact_Mobile','Contact_Phone','PhoneNo1');
		$argFieldsValues	= array("'".$sessMatriId."'","'".$varSelectLoginInfo["Email"]."'","'".$varSelectLoginInfo["Password"]."'","'".$varSelectMemberInfo["Date_Created"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Name"])))."'","'".$varSelectMemberInfo["Age"]."'","'".$varSelectMemberInfo["Dob"]."'","'".$varSelectMemberInfo["Gender"]."'","'".$varSelectMemberInfo["Marital_Status"]."'","'".$varSelectMemberInfo["No_Of_Children"]."'","'".$varSelectMemberInfo["Children_Living_Status"]."'","'".$varSelectMemberInfo["Religion"]."'","'".$varSelectMemberInfo["Country"]."'","'".$varSelectMemberInfo["Resident_Status"]."'","'".$varSelectMemberInfo["Citizenship"]."'","'".$varSelectMemberInfo["Employed_In"]."'","'".$varSelectMemberInfo["Height"]."'","'".$varSelectMemberInfo["Height_Unit"]."'","'".$varSelectMemberInfo["Physical_Status"]."'","'".$varSelectMemberInfo["Education_Category"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Education_Detail"])))."'","'".$varSelectMemberInfo["Occupation"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Occupation_Detail"])))."'","'".$varSelectMemberInfo["Mother_TongueId"]."'","'".addslashes(strip_tags(trim($varResidingState)))."'","'".addslashes(strip_tags(trim($varCityValue)))."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["About_Myself"])))."'","'".$varSelectMemberInfo["Profile_Created_By"]."'","'".$varSelectFamilyInfo["Family_Value"]."'","'".$varSelectFamilyInfo["Family_Type"]."'","'".$varSelectFamilyInfo["Family_Status"]."'","'".addslashes(strip_tags(trim($varReason)))."'","'".addslashes(strip_tags(trim($varComments)))."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Support_Comments"])))."'","'".$varCurrentDate."'","'".addslashes(strip_tags(trim($varSelectLoginInfo["User_Name"])))."'","'".$varSelectMemberInfo["Paid_Status"]."'","'".$varSelectMemberInfo["Valid_Days"]."'","'".$varSelectMemberInfo["Last_Payment"]."'","'".$varSelectMemberInfo["Number_Of_Payments"]."'","'".$varIPAddress."'","'".$varSelectMemberInfo["Publish"]."'","'".$varSelectMemberInfo["Special_Priv"]."'","'".$varSelectMemberInfo["Body_Type"]."'","'".$varSelectMemberInfo["Complexion"]."'","'".$varSelectMemberInfo["Blood_Group"]."'","'".$varSelectMemberInfo["CommunityId"]."'","'".$varSelectMemberInfo["CasteId"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["CasteText"])))."'","'".$varSelectMemberInfo["Caste_Nobar"]."'","'".$varSelectMemberInfo["SubcasteId"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["SubcasteText"])))."'","'".$varSelectMemberInfo["Subcaste_Nobar"]."'","'".$varSelectMemberInfo["GothramId"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["GothramText"])))."'","'".$varSelectMemberInfo["Star"]."'","'".$varSelectMemberInfo["Raasi"]."'","'".$varSelectMemberInfo["Chevvai_Dosham"]."'","'".$varSelectMemberInfo["Eating_Habits"]."'","'".$varSelectMemberInfo["Smoke"]."'","'".$varSelectMemberInfo["Drink"]."'","'".$varSelectMemberInfo["Income_Currency"]."'","'".$varSelectMemberInfo["Annual_Income"]."'","'".addslashes(strip_tags(trim($varSelectMemberInfo["Residing_Area"])))."'","'".$varSelectMemberInfo["Residing_District"]."'","'".$varSelectMemberInfo["Phone_Verified"]."'","'".$varSelectMemberInfo["Family_Set_Status"]."'","'".$varSelectMemberInfo["Interest_Set_Status"]."'","'".$varSelectMemberInfo["Photo_Set_Status"]."'","'".$varSelectMemberInfo["Protect_Photo_Set_Status"]."'","'".$varSelectMemberInfo["Horoscope_Available"]."'","'".$varSelectMemberInfo["Horoscope_Protected"]."'","'".$varSelectMemberInfo["Horoscope_Match"]."'","'".$varSelectMemberInfo["Partner_Set_Status"]."'","'".$varSelectMemberInfo["Match_Watch_Email"]."'","'".$varSelectMemberInfo["Last_Login"]."'","'".$varSelectMemberInfo["Date_Updated"]."'","'".$varSelectMemberInfo["Time_Posted"]."'","'".$varSelectMemberInfo["Profile_Referred_By"]."'","'".$varSelectMemberInfo["Weight"]."'","'".$varSelectMemberInfo["Weight_Unit"]."'","'".$varSelectMemberInfo["Appearance"]."'","'".$varSelectMemberInfo["Denomination"]."'","'".$varSelectMemberInfo["Contact_Mobile"]."'","'".$varSelectMemberInfo["Contact_Phone"]."'","'".$varPhone1."'");
		$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERDELETEDINFO'],$argFields,$argFieldsValues);

		if($varReason == 1) {
			$objMailManager->sendProfileDeletedMail($sessMatriId,$varSelectMemberInfo['Name'],$confValues['SERVERURL']);
			
			$mailResult = $objMailManager->sendProfileMarriageConfirmMail($sessMatriId,$varSelectMemberInfo['Name'],$confValues['SERVERURL'],$varReason,$varSelectMemberInfo['Gender']); 
		}

		$argCondition		= "MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
		
		//DELETE memberfamilyinfo INFO
		$objDBMaster->delete($varTable['MEMBERFAMILYINFO'],$argCondition);

		//DELETE memberhobbiesinfo INFO
		$objDBMaster->delete($varTable['MEMBERHOBBIESINFO'],$argCondition);

		//DELETE memberinfo INFO
		$objDBMaster->delete($varTable['MEMBERINFO'],$argCondition,$varOwnProfileMCKey);

		//DELETE memberlogininfo INFO
		$objDBMaster->delete($varTable['MEMBERLOGININFO'],$argCondition);

		//DELETE memberpartnerinfo INFO
		$objDBMaster->delete($varTable['MEMBERPARTNERINFO'],$argCondition);

		//DELETE memberphotoinfo INFO
		$objDBMaster->delete($varTable['MEMBERPHOTOINFO'],$argCondition);
		
		//DELETE memberupdatedinfo INFO
		$objDBMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);

		//execute php file from backend which is used for deleting msges in receiver side and sender side

		$varCmd	= "php ".$varRootBasePath."/bin/deleteprofile_step1.php ".$sessMatriId;
		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';

		escapeexec($varCmd,$varlogFile);
		

		//DELETE from sphnixmemberinfo
		include_once($varRootBasePath."/www/sphinx/sphinxdeleteinfo.php");
		
	}
	$varDisplayMessage	= 'Your profile has been successfully deleted. Thank you for using our services.';
	$varDisplayButton	= '<input type="button" class="button pntr" value="Close" onclick="redirectLogin(\''.$varReason.'\');">';

	setrawcookie("browsertime",false,time() - 36, "/",$varDomainName);
	setrawcookie("loginInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("profileInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("partnerInfo",false, time() - 36, "/",$varDomainName);
	setrawcookie("messagesInfo",false, time() - 36, "/",$varDomainName);
	setrawcookie("savedSearchInfo",false,time() - 36,"/",$varDomainName);
	setrawcookie("lastViewProfile",false,time() - 36, "/",$varDomainName);
	setrawcookie("requestReceivedInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("requestSentInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("listInfo",false,time() - 36, "/",$varDomainName);
	setrawcookie("viewsInfo",false,time() - 36, "/",$varDomainName);

	$_COOKIE['loginInfo']			= '';
	$_COOKIE['profileInfo']			= '';
	$_COOKIE['partnerInfo']			= '';
	$_COOKIE['messagesInfo']		= '';
	$_COOKIE['savedSearchInfo']		= '';
	$_COOKIE['lastViewProfile']		= '';
	$_COOKIE['requestReceivedInfo']	= '';
	$_COOKIE['requestSentInfo']		= '';
	$_COOKIE['listInfo']			= '';
	$_COOKIE['viewsInfo']			= '';
	$varGetCookieInfo['MATRIID']	= '';
}

//Close Slave Db Connection
$objMailManager->dbClose();
$objDBMaster->dbClose();
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/changepass.js"></script>
<!-- <link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css"> -->
<?if($_COOKIE['loginInfo'] == '') { ?>
<script language="javascript">
parent.document.getElementById('closeicon').innerHTML = '';
</script>

<div class="brdr pad10 alerttxt">
	<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="hidediv('confirm');" ></div><br clear="all">
	<div class="pad5 smalltxt"><?=$varDisplayMessage?></div><br clear="all">
	<div class="fright"><?=$varDisplayButton?>	</div><br clear="all">
</div>
	
<? }?>