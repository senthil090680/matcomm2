<?php
/****************************************************************************************************
File	: horoscopeprotect.php
Author	: Senthilnathan
********************************************************************************************************/
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
$varMatriId			= $varGetCookieInfo['MATRIID'];

//Object initialization
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;;

//CONNECTION DECLARATION
$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);
$varOption			= $_POST['option'];
$varPassword		= md5(trim($_POST['password']));
$varRepassword		= md5(trim($_POST['repassword']));
$varErrorMode		= 0;
$varSuccessMsg		= '';

if ($varOption	== 'add' || $varOption == 'remove' || $varOption == 'change')  {
	$varCondition		= " WHERE MatriId = '".$varMatriId."'";
	$varFields			= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
	$varMemberinfo		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0, $varOwnProfileMCKey);
	$varHoroscopeAvailable	= $varMemberinfo['Horoscope_Available'];
	$varVideoProtected	= trim($varMemberinfo['Horoscope_Protected']);
	$varFields			= array('Horoscope_Protected_Password');
	$varResult			= $objSlaveDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$varVideoInfo 		= mysql_fetch_assoc($varResult);
	$varFields			= array('Password');
	$varResult			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
	$varloginArray	 	= mysql_fetch_assoc($varResult);
	$varLoginPassword	= $varloginArray['Password'];

	if ($varLoginPassword == $varPassword){
		$varErrorMode	= 1;
		$varErrorMsg	= "Your Horoscope-Password can't be same as your Profile Password. Please choose a different Horoscope-Password.";
	} else if ($varHoroscopeAvailable != 1) {
			$varErrorMode	= 1;
			$varErrorMsg	= "you can protect your horoscope only after it is uploaded & validated.";
	} else if ($varPassword != $varRepassword ) {
			$varErrorMode	= 1;
			$varErrorMsg	= "The Horoscope Password and Confirm Photo Password Should be Same.";
	} 

	if ($varErrorMode	== 0 ) {
		$varFieldsValues1= ($varOption	== 'add' || $varOption == 'change')? array("1",$objMasterDB->doEscapeString($varPassword,$objMasterDB),"NOW()") :array("0","''","NOW()");
		$varFieldsValues2= ($varOption	== 'add' || $varOption == 'change')  ? array("1","NOW()") :array("0","NOW()");
		$varCondition	= "  MatriId= '".$varMatriId."'";
		$varFields		= array('Horoscope_Protected','Horoscope_Protected_Password','Horoscope_Date_Updated');
		$varUpdate		= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldsValues1, $varCondition);
		$varFields		= array('Horoscope_Protected','Date_Updated');
		$varUpdate		= $objMasterDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValues2, $varCondition, $varOwnProfileMCKey);
		$varResult		= ($varOption	== 'add' || $varOption == 'change')  ? 1 : 2;
	}

	if ($varUpdate) 
		echo $varResult."~";
	else
		echo "0~".$varErrorMsg;
}
?>