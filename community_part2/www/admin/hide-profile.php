<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-09-24
# End Date		: 2008-09-24
# Project		: MatrimonyProduct
# Module		: Admin
#=============================================================================================================
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/basefunctions.inc');
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//OBJECT DECLARTION
$objMaster		= new MemcacheDB;
$objMailManager = new MailManager;

//DB CONNECTION
$objMailManager->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

//VARIABLE DECLERATION
 $varUsernameId			= $_REQUEST['username'];
 $varPrimary			= $_REQUEST['primary'];
 $varThroughViewProfile	= $_REQUEST['tvprofile'];
 $varCurrentDate = date('y-m-d H:i:s');

$varProfileStatus = array('1'=>'Opened','2'=>'Hided','3'=>'Suspended','4'=>'Rejected','Delete'=>'Deleted');

if (($_REQUEST["profileStatusSubmit"]=="yes")||($varThroughViewProfile=="yes"))
{
	if ($varPrimary=="User_Name")
	{
		 //GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsernameId."'";
		$argFields 				= array('MatriId','Publish');
		$varSelectMatriIdRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
		$varStatus				= $varSelectMatriId["Publish"];
	}//if
	else
	{
			//SETING MEMCACHE KEY
		$varProfileMCKey		= 'ProfileInfo_'.$varUsernameId;

		$argCondition			= "WHERE MatriId='".$varUsernameId."'";

		$argFields 				= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Gender','Dob','Height','Height_Unit','Religion','Denomination','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Star','Country','Residing_State','Residing_Area','Residing_City','Residing_District','Education_Category','Employed_In','Occupation','Eye_Color','Hair_Color','Contact_Phone','Contact_Mobile','Pending_Modify_Validation','Publish','Email_Verified','CommunityId','Marital_Status','No_Of_Children','Children_Living_Status','Weight','Weight_Unit','Body_Type','Complexion','Physical_Status','Blood_Group','Appearance','Mother_TongueId','Mother_TongueText','Religion','GothramId','GothramText','Raasi','Horoscope_Match','Chevvai_Dosham','Education_Detail','Occupation_Detail','Income_Currency','Annual_Income','Country','Citizenship','Resident_Status','About_Myself','Eating_Habits','Smoke','Drink','Religious_Values','Ethnicity','About_MyPartner','Profile_Created_By','When_Marry','Last_Login','Phone_Verified','Horoscope_Available','Horoscope_Protected','Partner_Set_Status','Interest_Set_Status','Family_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Profile_Viewed','Filter_Set_Status','Video_Set_Status','Voice_Available','Paid_Status','Special_Priv','Date_Created','Date_Updated');
		$varSelectMatriId		= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);
		$varStatus				= $varSelectMatriId["Publish"];
		$varMatriId				= $varUsernameId;
	}//

}//if

if($_REQUEST["hideProfileSubmit"] == "yes")
{
	$varnotifyCustomer			= $_REQUEST["notifyCustomer"];
	$varStatus					= $_REQUEST['status'];

	if ($varPrimary=="User_Name")
	{
		//GET MatriId FROM Username
		$argCondition			= "WHERE User_Name='".$varUsernameId."'";
		$argFields 				= array('MatriId');
		$varSelectMatriIdRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
		$varSelectMatriId		= mysql_fetch_assoc($varSelectMatriIdRes);
		$varMatriId				= $varSelectMatriId["MatriId"];
	}//if
	else
	{
		$varMatriId				= $varUsernameId;
	}//

	//SETING MEMCACHE KEY
	$varProfileMCKey		= 'ProfileInfo_'.$varMatriId;

	//get folder name
	$varFolderName			= $objMailManager->getFolderName($varMatriId);
	$arrDomainDtls			= $objMailManager->getDomainDetails($varMatriId);

	$argCondition				= "WHERE MatriId='".$varMatriId."'";

	//SELECT EMAIL
	if ($varnotifyCustomer=="yes")
	{
		$argFields 				= array('User_Name','Email');
		$varSelectUserNameRes	= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
		$varSelectUserName		= mysql_fetch_assoc($varSelectUserNameRes);
		$varUserName			= $varSelectUserName['User_Name'];
		$varEmail				= $varSelectUserName['Email'];
	}//if
	
	$varNoOfRecords				= $objMailManager->numOfRecords($varTable['MEMBERINFO'],'MatriId',$argCondition);

	if($varNoOfRecords == 1)
	{
		$varCommentwithAdmin		= '--'.$varCurrentDate.'--'.$_REQUEST['adminLogin'].'--'.addslashes(strip_tags(trim($_REQUEST['comments'])));	
		
		//SELECT E-Mail to Notify customer
		if ($varnotifyCustomer=="yes")
		{
			if($varStatus == 0 || $varStatus == '') {
				$varSubject				= "Your Profile has been inactivated From ".$arrDomainDtls['PRODUCTNAME']." Matrimony"; 
			} else {
				$varSubject				= "Your Profile has been ".$varProfileStatus[$varStatus]." From ".$arrDomainDtls['PRODUCTNAME']." Matrimony"; 
			}
			$varComments	= 'Dear <b>'.$varMatriId.'</b>,<br><br>';
			$varComments	.= "Your Profile has been inactivated From ".$arrDomainDtls['PRODUCTNAME']."Matrimony.Com<br><br>";
			$varComments	.= '<b>Admin comments</b> :';
			$varComments	.= $_REQUEST["comments"];
			$varComments	.= '<br><br>Thanking you, <br>Team - '.$arrDomainDtls['PRODUCTNAME'].'Matrimony.Com';
			$retValue		= $objMailManager->sendNotifyEmail($varEmail,$varComments,$varSubject,$varMatriId);
		}//if

		if($varStatus != "Delete")
		{
			$argCondition			= "MatriId='".$varMatriId."'";
			$argFields				= array("Publish");
			$argFieldsValues		= array("'".$varStatus."'");
			$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);

			$varResult				= "Status updated to ".$varProfileStatus[$varStatus];

			//INSERT SUPPORT COMMENTS HERE
			$argCondition			= "WHERE MatriId='".$varMatriId."'";
			$argFields 				= array('Support_Comments');
			$varadminCommentsRes	= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
			$varadminComments		= mysql_fetch_assoc($varadminCommentsRes);
			$varComment				= $varadminComments['Support_Comments'].$varCommentwithAdmin;
			$argFieldsValues		= array("'".$varComment."'");
			$argCondition			= "MatriId='".$varMatriId."'";
			$varUpdateId			= $objMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varProfileMCKey);
		}
		else
		{
			#-------------------------------------------------------------------------------------------------
			//SELECT MEMBERLOGIN INFO
			$argFields 				= array('Email','Password','User_Name');
			$varSelectLoginInfoRes	= $objMailManager->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
			$varSelectLoginInfo		= mysql_fetch_assoc($varSelectLoginInfoRes);


			$argToolsCondition		= "MatriId='".$varMatriId."'";
			$varToolsFields			= array('PhotoAddedOn');
			$argToolsFieldsValues	= array('0000-00-00 00:00:00');
			$objMaster->update('membertoolslog',$varToolsFields,$argToolsFieldsValues,$argToolsCondition,$varProfileMCKey);

			#--------------------------------------------------------------------------------------------------
			//SELECT MEMBERBASIC INFO
			$argFields					= array('Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_TongueId','Residing_State','Residing_Area','Residing_City','Residing_District','About_Myself','Profile_Created_By','Support_Comments','Date_Created','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments','Publish','Special_Priv','Body_Type','Complexion','Blood_Group','CommunityId','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','GothramId','GothramText','Star','Raasi','Chevvai_Dosham','Eating_Habits','Smoke','Drink','Income_Currency','Annual_Income','Residing_Area','Residing_District','Phone_Verified','Family_Set_Status','Interest_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Horoscope_Available','Horoscope_Protected','Horoscope_Match','Partner_Set_Status','Match_Watch_Email','Last_Login','Date_Updated','Time_Posted','Profile_Referred_By','Weight','Weight_Unit','Appearance','Denomination','Contact_Phone','Contact_Mobile');
			$varSelectBasicInfo	= $objMaster->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varProfileMCKey);

			$argFields = array('PhoneNo1');
			if($varSelectBasicInfo['Phone_Verified'] == 1) {
			  $varExecute = $objMaster->select($varTable['ASSUREDCONTACT'], $argFields, $argCondition, 0);   
			}
			else {
			  $varExecute = $objMaster->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'], $argFields, $argCondition, 0);
			}
			$varResRow=mysql_fetch_assoc($varExecute);
			$varPhone1 = $varResRow['PhoneNo1'];

			if ($varSelectBasicInfo['Country']==98 || $varSelectBasicInfo['Country']==222) { $varResidingState = $varSelectBasicInfo['Residing_State'];} //if
			else {$varResidingState = $varSelectBasicInfo['Residing_Area'];} 

			if($varSelectBasicInfo["Country"] == 98) { $varCityValue = $varSelectBasicInfo["Residing_District"]; } else { $varCityValue = $varSelectBasicInfo["Residing_City"]; }

			#---------------------------------------------------------------------------------------------------
			//SELECT FAMILY INFO
			$argFields 				= array('Family_Value','Family_Type','Family_Status');
			$varSelectFamilyInfoRes	= $objMailManager->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
			$varSelectFamilyInfo	= mysql_fetch_assoc($varSelectFamilyInfoRes);
			
			#--------------------------------------------------------------------------------------------------
			$varIPAddress = getenv('REMOTE_ADDR');
			//INSERT ALL SELECTED TO memberdeletedinfo TABLE
			$argFields 			= array('MatriId','Email','Password','Date_Created','Name','Age','Dob','Gender','Marital_Status','No_Of_Children','Children_Living_Status','Religion','Country','Resident_Status','Citizenship','Employed_In','Height','Height_Unit','Physical_Status','Education_Category','Education_Detail','Occupation','Occupation_Detail','Mother_Tongue','Residing_State','Residing_City','About_Myself','Profile_Created_By','Family_Value','Family_Type','Family_Status','Deleted_Reason','Deleted_Comments','Support_Comments','Date_Deleted','User_Name','Paid_Status','Valid_Days','Last_Payment','Number_Of_Payments','IPAddress','Publish','Special_Priv','Body_Type','Complexion','Blood_Group','CommunityId','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','GothramId','GothramText','Star','Raasi','Chevvai_Dosham','Eating_Habits','Smoke','Drink','Income_Currency','Annual_Income','Residing_Area','Residing_District','Phone_Verified','Family_Set_Status','Interest_Set_Status','Photo_Set_Status','Protect_Photo_Set_Status','Horoscope_Available','Horoscope_Protected','Horoscope_Match','Partner_Set_Status','Match_Watch_Email','Last_Login','Date_Updated','Time_Posted','Profile_Referred_By','Weight','Weight_Unit','Appearance','Denomination','Contact_Mobile','Contact_Phone','PhoneNo1');
			$argFieldsValues		= array("'".$varMatriId."'","'".$varSelectLoginInfo["Email"]."'","'".$varSelectLoginInfo["Password"]."'","'".$varSelectBasicInfo["Date_Created"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["Name"])))."'","'".$varSelectBasicInfo["Age"]."'","'".$varSelectBasicInfo["Dob"]."'","'".$varSelectBasicInfo["Gender"]."'","'".$varSelectBasicInfo["Marital_Status"]."'","'".$varSelectBasicInfo["No_Of_Children"]."'","'".$varSelectBasicInfo["Children_Living_Status"]."'","'".$varSelectBasicInfo["Religion"]."'","'".$varSelectBasicInfo["Country"]."'","'".$varSelectBasicInfo["Resident_Status"]."'","'".$varSelectBasicInfo["Citizenship"]."'","'".$varSelectBasicInfo["Employed_In"]."'","'".$varSelectBasicInfo["Height"]."'","'".$varSelectBasicInfo["Height_Unit"]."'","'".$varSelectBasicInfo["Physical_Status"]."'","'".$varSelectBasicInfo["Education_Category"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["Education_Detail"])))."'","'".$varSelectBasicInfo["Occupation"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["Occupation_Detail"])))."'","'".$varSelectBasicInfo["Mother_TongueId"]."'","'".addslashes(strip_tags(trim($varResidingState)))."'","'".addslashes(strip_tags(trim($varCityValue)))."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["About_Myself"])))."'","'".$varSelectBasicInfo["Profile_Created_By"]."'","'".$varSelectFamilyInfo["Family_Value"]."'","'".$varSelectFamilyInfo["Family_Type"]."'","'".$varSelectFamilyInfo["Family_Status"]."'","'".addslashes(strip_tags(trim($_REQUEST["reason"])))."'","'".addslashes(strip_tags(trim($varAllComments)))."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["Support_Comments"])))."'","'".$varCurrentDate."'","'".$varSelectLoginInfo["User_Name"]."'","'".$varSelectBasicInfo["Paid_Status"]."'","'".$varSelectBasicInfo["Valid_Days"]."'","'".$varSelectBasicInfo["Last_Payment"]."'","'".$varSelectBasicInfo["Number_Of_Payments"]."'","'".$varIPAddress."'","'".$varSelectBasicInfo["Publish"]."'","'".$varSelectBasicInfo["Special_Priv"]."'","'".$varSelectBasicInfo["Body_Type"]."'","'".$varSelectBasicInfo["Complexion"]."'","'".$varSelectBasicInfo["Blood_Group"]."'","'".$varSelectBasicInfo["CommunityId"]."'","'".$varSelectBasicInfo["CasteId"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["CasteText"])))."'","'".$varSelectBasicInfo["Caste_Nobar"]."'","'".$varSelectBasicInfo["SubcasteId"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["SubcasteText"])))."'","'".$varSelectBasicInfo["Subcaste_Nobar"]."'","'".$varSelectBasicInfo["GothramId"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["GothramText"])))."'","'".$varSelectBasicInfo["Star"]."'","'".$varSelectBasicInfo["Raasi"]."'","'".$varSelectBasicInfo["Chevvai_Dosham"]."'","'".$varSelectBasicInfo["Eating_Habits"]."'","'".$varSelectBasicInfo["Smoke"]."'","'".$varSelectBasicInfo["Drink"]."'","'".$varSelectBasicInfo["Income_Currency"]."'","'".$varSelectBasicInfo["Annual_Income"]."'","'".addslashes(strip_tags(trim($varSelectBasicInfo["Residing_Area"])))."'","'".$varSelectBasicInfo["Residing_District"]."'","'".$varSelectBasicInfo["Phone_Verified"]."'","'".$varSelectBasicInfo["Family_Set_Status"]."'","'".$varSelectBasicInfo["Interest_Set_Status"]."'","'".$varSelectBasicInfo["Photo_Set_Status"]."'","'".$varSelectBasicInfo["Protect_Photo_Set_Status"]."'","'".$varSelectBasicInfo["Horoscope_Available"]."'","'".$varSelectBasicInfo["Horoscope_Protected"]."'","'".$varSelectBasicInfo["Horoscope_Match"]."'","'".$varSelectBasicInfo["Partner_Set_Status"]."'","'".$varSelectBasicInfo["Match_Watch_Email"]."'","'".$varSelectBasicInfo["Last_Login"]."'","'".$varSelectBasicInfo["Date_Updated"]."'","'".$varSelectBasicInfo["Time_Posted"]."'","'".$varSelectBasicInfo["Profile_Referred_By"]."'","'".$varSelectBasicInfo["Weight"]."'","'".$varSelectBasicInfo["Weight_Unit"]."'","'".$varSelectBasicInfo["Appearance"]."'","'".$varSelectBasicInfo["Denomination"]."'","'".$varSelectBasicInfo["Contact_Mobile"]."'","'".$varSelectBasicInfo["Contact_Phone"]."'","'".$varPhone1."'");
			$varInsertId			= $objMaster->insert($varTable['MEMBERDELETEDINFO'],$argFields,$argFieldsValues);

			#------------------------------------------------------------------------------------------------
			$argCondition			= "MatriId='".$varMatriId."'";
			
			//DELETE from sphnixmemberinfo
			include_once($varRootBasePath."/www/sphinx/sphinxdeleteinfo.php");

			//DELETE memberfamilyinfo INFO
			$objMaster->delete($varTable['MEMBERFAMILYINFO'],$argCondition);

			//DELETE memberhobbiesinfo INFO
			$objMaster->delete($varTable['MEMBERHOBBIESINFO'],$argCondition);

			//DELETE memberinfo INFO
			$objMaster->delete($varTable['MEMBERINFO'],$argCondition,$varOwnProfileMCKey);

			//DELETE memberlogininfo INFO
			$objMaster->delete($varTable['MEMBERLOGININFO'],$argCondition);

			//DELETE memberpartnerinfo INFO
			$objMaster->delete($varTable['MEMBERPARTNERINFO'],$argCondition);

			//DELETE memberphotoinfo INFO
			$objMaster->delete($varTable['MEMBERPHOTOINFO'],$argCondition);
			
			//DELETE memberupdatedinfo INFO
			$objMaster->delete($varTable['MEMBERUPDATEDINFO'],$argCondition);

			//execute php file from backend which is used for deleting msges in receiver side and sender side
			$varCmd	= "php ".$varRootBasePath."/bin/deleteprofile_step1.php ".$varMatriId;
			
				$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
				escapeexec($varCmd,$varlogFile);
			
			$varFormResult="You have successfully deleted your profile. Thank you for being a member of ".$arrDomainDtls['PRODUCTNAME']." Matrimony. We wish you all the best.";
		}
	}
	else
	{
		$varResult = 'This '.str_replace("_"," ",$varPrimary).' doesn\'t exist.';
	}
	$objMaster->dbClose();
}

$objMailManager->dbClose();
?>
<script language="javascript">
function funValidate()
{
	var frmName = document.hideProfile;
	if(frmName.username.value == "")
	{
		alert("Please enter Username / Matrimony Id");
		frmName.username.focus();
		return false;
	}//if

	if (!(frmName.primary[0].checked==true || frmName.primary[1].checked==true))
	{
		alert("Please select Username / Matrimony Id");
		frmName.primary[0].focus();
		return false;
	}//if

	if(frmName.status.value == "")
	{
		alert("Please select status");
		frmName.status.focus();
		return false;
	}

	if(frmName.status.value == 4)
	{
		alert("Please enter comments for reject profile");
		frmName.comments.focus();
		return false;
	}

	if(frmName.status.value == "Delete")
	{
		result = confirm("Do you want to delete this profile");
		if(result == "true")
		{
			//frmName.submit();
			return true;
		}
	}//if
	return true;

}//funValidate
</script>
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="542" align="left">
	<tr><td class="heading" style="padding-left:10px;padding-top:10px;">Hide / Open / Suspend profiles</td></tr>
	<tr><td height="10"></td></tr>
	<?php if ($_REQUEST["hideProfileSubmit"]=="yes")
	{ echo'<tr><td class="errorMsg">&nbsp;'.$varResult.'</td></tr><tr><td height="10"></td></tr>'; } ?>
	<tr><td>
	<table border="0" cellspacing="0" cellpadding="0" width="522" align="center">
	<form name="hideProfile" action="index.php?act=hide-profile" method="post" onSubmit=" return funValidate();">
	<input type="hidden" name="hideProfileSubmit" value="yes">
	<?php if(isset($varThroughViewProfile)){?>
	<input type="hidden" name="tvprofile" value="yes">
	<?php }?>
	<tr><td height="10" colspan="3"></td></tr>
	<tr class="tabpadding">
		<td width="30%" class="textsmallbolda">Username *</td>
		<td width="25%"><input class="smalltxt" type="text" name="username" size="20" value="<?=$varUsernameId;?>"></td>
		<td width="45%" class="smalltxt" align="left"><input type="radio" name="primary" value="User_Name" <?=$varPrimary=="User_Name" ? "checked" : "";?>> Username<input type="radio" name="primary" value="MatriId" <?=$varPrimary=="MatriId" ? "checked" : "";?>> Matrimony Id</td>
	</tr>
	<tr class="tabpadding">
		<td class="textsmallbolda">Status *</td>
		<td colspan="2">
		<select name="status" class="combobox" style="width:136px;font-family: Verdana, arial, sans-serif;font-size : 8pt">
		<option value="">- Select status -</option>
		<option value="1" <?=$varStatus==1 ? "selected" : "";?>>Open</option>
		<option value="2" <?=$varStatus==2 ? "selected" : "";?>>Hide</option>
		<option value="3" <?=$varStatus==3 ? "selected" : "";?>>Suspend</option>
		<option value="4" <?=$varStatus==4 ? "selected" : "";?>>Reject</option>
		<option value="0" <?if ($varStatus=="0" ) { echo "selected";}//if ?>>Inactive</option>
		<option value="Delete">Ignore</option>
		</select>
		</td>
	</tr>
	<tr class="tabpadding">
		<td class="textsmallbolda">Comments</td>
		<td colspan="2"><textarea cols="30" rows="6" name="comments"></textarea>
		</td>
	</tr>
	<tr class="tabpadding">
		<td class="textsmallbolda">Name of the Person doing the change</td>
		<td colspan="2"><input type="text" name="adminLogin" value="">
		</td>
	</tr>
	<tr class="tabpadding">
		<td></td>
		<td colspan="2" class="smalltxt"><input type="checkbox" name="notifyCustomer" class="smalltxt" value="yes" align="absmiddle"> <b>Notify customer</b> <input type="submit" value="Submit" class="button" align="absmiddle"></td>
	</tr>
	<tr><td height="10" colspan="3"></td></tr>
	</form>
	</table>
	</td></tr>
	<tr><td height="10"></td></tr>
</table>
<br>