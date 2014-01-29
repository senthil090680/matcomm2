<?php
//error_reporting( E_ALL ^ E_NOTICE );
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
# Description	: 
#	this is cron file, send the mail to partner preference member
#=============================================================================================================
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.cil14');
include_once($varServerBasePath.'/conf/config.cil14');
include_once($varServerBasePath.'/conf/cityarray.cil14');
include_once($varServerBasePath.'/conf/emailsconfig.cil14');
include_once($varServerBasePath.'/conf/domainlist.cil14');
include_once($varServerBasePath.'/lib/clsMailerMatchWatch.php');

function GetTodayMatriId($objRMInterface,$argCurrentDate) {
	global $TABLE,$varCbsRminterfaceDbInfo;

	$varRMPartnerPrefTbl	= $varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'];	
	$argFields				= array('RMUserid','MatriId','Message','ScheduleDate');
	$argCondition			= " WHERE date(ScheduleDate)='".date($argCurrentDate)."' AND Status=2";
	$arrMatriIdResultSet	= $objRMInterface->select($varRMPartnerPrefTbl, $argFields, $argCondition, 0);

	$varCnt=0;
	while($arrMatriIdResult		= mysql_fetch_array($arrMatriIdResultSet)) {
		$arrTodayMatriIds[$varCnt][0]=$arrMatriIdResult['RMUserid'];
		$arrTodayMatriIds[$varCnt][1]=$arrMatriIdResult['MatriId'];
		$arrTodayMatriIds[$varCnt][2]=$arrMatriIdResult['Message'];
		$arrTodayMatriIds[$varCnt][3]=$arrMatriIdResult['ScheduleDate'];
		$varCnt++;
	}
	return $arrTodayMatriIds;
}

function getPartnerDetail($varCommunityId,$varMatriId,$objMailerMatchWatch) {

	global $varTable;
	//COMPATIBILTY BAR ARRAY VALUES
	$argCondition		= "WHERE CommunityId = ".$varCommunityId." AND MatriId='".$varMatriId."'";

	$funFields			= array('MatriId', 'Age_From', 'Age_To', 'Looking_Status', 'Height_From', 'Height_To', 'Physical_Status', 'Education', 'Religion', 'Denomination', 'CasteId', 'SubcasteId', 'Citizenship', 'Country', 'Resident_India_State', 'Resident_USA_State', 'Resident_Status', 'Mother_Tongue',  'Eating_Habits', 'Drinking_Habits', 'Smoking_Habits', 'Date_Updated');
	$funarrPPDetResSet	= $objMailerMatchWatch->select($varTable['MEMBERPARTNERINFO'], $funFields, $argCondition, 0);
	$funarrPPDet		= mysql_fetch_assoc($funarrPPDetResSet);
	return $funarrPPDet;
}


function getPhotoDetails($varCommunityId,$matriid,$obj) {
	global $varTable,$varDbInfo;
	$memberinfotbl=$varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];	

	$argFields			= array('MatriId','Photo_Set_Status','Protect_Photo_Set_Status');
	$argCondition		= " WHERE CommunityId=".$varCommunityId." AND MatriId = '".$matriid."'";
	$arrPhotoResultSet	= $obj->select($memberinfotbl, $argFields, $argCondition, 0);
	$arrPhotoResult		= mysql_fetch_assoc($arrPhotoResultSet);

	//Get Photo Details Starts -->
	if($arrPhotoResult['Photo_Set_Status']==0)
	{
		$varReturnPhDetail = '';
	}
	else if($arrPhotoResult['Photo_Set_Status']==1 && $arrPhotoResult['Protect_Photo_Set_Status']==1)
	{
		$varReturnPhDetail = 'PP';
	}
	else if($arrPhotoResult['Photo_Set_Status']==1 && $arrPhotoResult['Protect_Photo_Set_Status']==0)
	{
		$funFields		= array('MatriId','Normal_Photo1','Thumb_Small_Photo1','Photo_Status1','Normal_Photo2','Thumb_Small_Photo2','Photo_Status2','Normal_Photo3','Thumb_Small_Photo3','Photo_Status3','Normal_Photo4','Thumb_Small_Photo4','Photo_Status4','Normal_Photo5','Thumb_Small_Photo5','Photo_Status5','Normal_Photo6','Thumb_Small_Photo6','Photo_Status6','Normal_Photo7','Thumb_Small_Photo7','Photo_Status7','Normal_Photo8','Thumb_Small_Photo8','Photo_Status8','Normal_Photo9','Thumb_Small_Photo9','Photo_Status9','Normal_Photo10','Thumb_Small_Photo10','Photo_Status10');
		$funCondition	= "WHERE MatriId = '".$matriid."'";
		$resPhotoIdsDetRes = $obj->select($varTable['MEMBERPHOTOINFO'], $funFields, $funCondition, 0);
		$resPhotoIdsDet		= mysql_fetch_assoc($resPhotoIdsDetRes);
		$varReturnPhDetail = $resPhotoIdsDet['Normal_Photo1'].'~'.$resPhotoIdsDet['Thumb_Small_Photo1'];
	}
	//Get Photo Details Ends -->

	

   return $varReturnPhDetail;
}

function ProfileIamLookingFor($varCommunityId,$varMatriId,$argGender,$ppval,$objMailerMatchWatch)
{
	global $varTable,$varDbInfo,$arrCountryList;

	$varGender			= $argGender==2?'1':'2';
	$varMatchWatchTable	= 'memberinfo_mw';
	$arrProIdsDet		= array();

	$funStAge		= $ppval['Age_From'];
	$funEndAge		= $ppval['Age_To'];
	$funStHeight	= $ppval['Height_From'];
	$funEndHeight	= $ppval['Height_To'];
	$funLookingfor	= $ppval['Looking_Status'];
	$funPhStatus	= $ppval['Physical_Status'];
	$funMotherTongue= $ppval['Mother_Tongue'];
	$funReligion	= $ppval['Religion'];
	$funDenomination= $ppval['Denomination'];
	$funCasteId		= $ppval['CasteId'];
	$funSubcasteId	= $ppval['SubcasteId'];
	$funEatingHabit	= $ppval['Eating_Habits'];
	$funEducation	= $ppval['Education'];
	$funCitizenship	= $ppval['Citizenship'];
	$funCountry		= $ppval['Country'];
	$funIndiaState	= $ppval['Resident_India_State'];
	$funUSAState	= $ppval['Resident_USA_State'];
	//$funResidentSt	= $ppval['Resident_Status'];
	$funSmokingHabit= $ppval['Smoking_Habits'];
	$funDrinkHabit	= $ppval['Drinking_Habits'];

	if($funStAge != 0) {
		$funQuery		= " WHERE CommunityId = ".$varCommunityId." AND ";
		
		$funQuery		.= " Gender=".$varGender." AND Age >=".$funStAge." AND Age <=".$funEndAge." AND Height >=".floor($funStHeight)." AND Height <=".ceil($funEndHeight);
		
		if($funPhStatus != 0) { $funQuery	.= ' AND Physical_Status = '.$funPhStatus;	 }//if 
		if($funEatingHabit != 0) { $funQuery	.= ' AND Eating_Habits = '.$funEatingHabit;	 }//if
		if($funSmokingHabit != 0) { $funQuery	.= ' AND Smoke = '.$funSmokingHabit;	 }//if
		if($funDrinkHabit != 0) { $funQuery	.= ' AND Drink = '.$funDrinkHabit;	 }//if

		if($funLookingfor != '' && $funLookingfor !=0)
		{ $funQuery	.= ' AND Marital_Status IN('.preg_replace('/(~)+/', ',', trim($funLookingfor,'~')).')'; }//if

		if($funMotherTongue != "" && $funMotherTongue !=0)
		{ $funQuery	.= ' AND Mother_TongueId IN('.preg_replace('/(~)+/', ',', trim($funMotherTongue,'~')).')';	 }//if

		if($funReligion != "" && $funReligion !=0)
		{ $funQuery	.= ' AND Religion IN('.preg_replace('/(~)+/', ',', trim($funReligion,'~')).')';	 }//if

		if($funDenomination != "" && $funDenomination !=0)
		{ $funQuery	.= ' AND Denomination IN('.preg_replace('/(~)+/', ',', trim($funDenomination,'~')).')';	 }//if

		if($objMailerMatchWatch->funCasteArrayFeature>0) {
			if($funCasteId != "" && $funCasteId !=0) { 
				$funQuery	.= ' AND CasteId IN('.preg_replace('/(~)+/', ',', trim($funCasteId,'~')).')';
			}
		}

		if($objMailerMatchWatch->funSubcasteArrayFeature>0) {
			if($funSubcasteId != "" && $funSubcasteId !=0) { 
				$funQuery	.= ' AND SubcasteId IN('.preg_replace('/(~)+/', ',', trim($funSubcasteId,'~')).')';	 
			}
		}

		if($funEducation != "" && $funEducation !=0)
		{ $funQuery	.= ' AND Education_Category IN('.preg_replace('/(~)+/', ',', trim($funEducation,'~')).')';	 }//if

		if($funCitizenship != "" && $funCitizenship !=0)
		{ $funQuery	.= ' AND Citizenship IN('.preg_replace('/(~)+/', ',', trim($funCitizenship,'~')).')';	 }//if

		$arrCountry = array();
		if($funCountry != "" && $funCountry !=0)
		{ 
			$arrCountry	= Split('~',$funCountry);
			$funQuery	.= ' AND Country IN('.preg_replace('/(~)+/', ',', trim($funCountry,'~')).')';
		}//if

		if($funIndiaState != "" && $funIndiaState !=0)
		{
			if (count($arrCountry) >0 && in_array(98,$arrCountry))
			{ $funQuery	.= ' AND Residing_State IN('.preg_replace('/(~)+/', ',', trim($funIndiaState,'~')).')';	 }//if
		}

		if($funUSAState != "" && $funUSAState !=0)
		{
			if (count($arrCountry) >0 && in_array(222,$arrCountry))
			{ $funQuery	.= ' AND Residing_State IN('.preg_replace('/(~)+/', ',', trim($funUSAState,'~')).')';	 }//if
		}
			
		
		//echo $funQuery."<BR>";
		$funNoOfRecs	= $objMailerMatchWatch->numOfRecords($varMatchWatchTable, 'MatriId', $funQuery);	

		if ($funNoOfRecs > 0)
		{
			$funQuery	.= ' ORDER BY Date_Created DESC';
			$funFields	= array('MatriId');


			$funReultSet = $objMailerMatchWatch->select($varMatchWatchTable, $funFields, $funQuery, 0);

			$i = 0;
			while($row = mysql_fetch_assoc($funReultSet)) {
				$arrProIdsDet[$i]	= "'".$row['MatriId']."'";
				$i++;
			}
		} else {
			$arrProIdsDet = array();
		}
	} else {
		$arrProIdsDet = array();
	}
	return $arrProIdsDet;
}


function GetPartnerEmail($partnerids,$obj) {
    global $varTable,$varDbInfo;

	$memlogininfo = $varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'];

	$argFields				= array('MatriId','Email');
	$argCondition			= " WHERE MatriId IN (".join($partnerids,",").")";
	$arrEmailIdResultSet	= $obj->select($memlogininfo, $argFields, $argCondition, 0);

	$varCnt=0;
	while($arrEmailIdResult	= mysql_fetch_array($arrEmailIdResultSet)) {
		$arrPartnerEmailIds[$varCnt][0]=$arrEmailIdResult['MatriId'];
		$arrPartnerEmailIds[$varCnt][1]=$arrEmailIdResult['Email'];
		$varCnt++;
	}

	return $arrPartnerEmailIds;
} 

function GetPartnerName($partnerids,$obj) {
    global $varTable,$varDbInfo;

	$memlogininfo = $varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];

	$argFields				= array('Nick_Name','Name');
	$argCondition			= " WHERE MatriId IN (".join($partnerids,",").")";
	$arrNameResultSet		= $obj->select($memlogininfo, $argFields, $argCondition, 0);

	$varCnt=0;
	while($arrNameResult	= mysql_fetch_array($arrNameResultSet)) {
		$arrPartnerNames[$varCnt][0]=$arrNameResult['Nick_Name'];
		$arrPartnerNames[$varCnt][1]=$arrNameResult['Name'];
		$varCnt++;
	}

	return $arrPartnerNames;
} 

function sendmailtopartner($rmuserinfo,$varBasicDetails,$message,$toemail,$oppmatriid,$oppname,$varUserPhotoDetail,$varPhotoUrl,$obj) {
  global $varTable,$varDbInfo;

		$funMatriId				= $varBasicDetails[0]['ID'];
		$varBasicUserName		= $varBasicDetails[0]['UN'];
		$varBasicName			= ($varBasicDetails[0]['NN']!='') ? $varBasicDetails[0]['NN']:$varBasicDetails[0]['N'];
		$varBasicGender			= $varBasicDetails[0]['G'] == 1?'Male':'Female';
		$arrDetail				= explode("^~^",$varBasicDetails[0]['DE']);
		$varBasicAge			= $arrDetail[0];
		$varBasicCountry		= $arrDetail[10];
		$varBasicReligion		= $arrDetail[7];
		$varContentState		= $arrDetail[11];
		$varBasicResCity		= $arrDetail[12];
		$varBasicCasteDiv		= $arrDetail[8];
		$varBasicSubcaste		= $arrDetail[9];
		$varBasicEduDet			= $arrDetail[4];
		$varBasicOccDet			= $arrDetail[6];
		$varBasicHtUnit			= $arrDetail[1];

		//religion & subcaste part
		if($arrDetail[14] == '1') {
			$cas_no_cont	= '(CasteNoBar)';
		} else {
			$cas_no_cont	= '';
		}

		if($arrDetail[15] == '1') {
			$sub_cas_no_cont	= '(SubcasteNoBar)';
		} else {
			$sub_cas_no_cont	= '';
		}

		if($arrDetail[7] !='') {
			$varBasicReligionSubcaste	= $arrDetail[7];
		} else {
			$varBasicReligionSubcaste	= '';
		}

		if($varBasicReligionSubcaste !='' && $arrDetail[16]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[16];
		} else if($varBasicReligionSubcaste =='' && $arrDetail[16]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[16];
		} else if($varBasicReligionSubcaste =='' && $arrDetail[16]=='') {
			$varBasicReligionSubcaste	.= '';
		}

		if($varBasicReligionSubcaste !='' && $arrDetail[8]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[8].$cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[8]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[8].$cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[8]=='') {
			$varBasicReligionSubcaste	.= '';
		}

		if($varBasicReligionSubcaste !='' && $arrDetail[9]!='') {
			$varBasicReligionSubcaste	.= ', '.$arrDetail[9].$sub_cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[9]!='') {
			$varBasicReligionSubcaste	.= $arrDetail[9].$sub_cas_no_cont;
		} else if($varBasicReligionSubcaste =='' && $arrDetail[9]=='') {
			$varBasicReligionSubcaste	.= '';
		}

		//Country part
		if($varBasicCountry != '' && $arrDetail[11] !='' && $arrDetail[11] !='0') {
			$ctry_stat			= $arrDetail[11].', '.$varBasicCountry;
		} else {
			$ctry_stat			= $varBasicCountry;
		}

		if($varBasicCountry != '' && $arrDetail[12] !='' && $arrDetail[12] !='0') {
			$ctry_st_ci			= $arrDetail[12].', '.$ctry_stat;
		} else {
			$ctry_st_ci			= $ctry_stat;
		}
		$varBasicCountry		= $ctry_st_ci;

		//Education Part
		if($arrDetail[3]!='') {
			$varContentEdu		= $arrDetail[3];
		} else {
			$varContentEdu		= '';
		}

		if($varContentEdu !='' && $arrDetail[4]!='') {
			$varContentEdu	.= ', '.$arrDetail[4];
		} else if($varContentEdu =='' && $arrDetail[4]!='') {
			$varContentEdu	.= $arrDetail[4];
		} else if($varContentEdu =='' && $arrDetail[4]=='') {
			$varContentEdu	.= '';
		}
		
		//Occupation part
		/*if($arrDetail[5]!='Others' && $arrDetail[5]!='') {
			$varContentOcc		= $arrDetail[5];
		} else {
			$varContentOcc		= '';
		}

		if($varContentOcc !='' && $arrDetail[6]!='') {
			$varContentOcc	.= ', '.$arrDetail[6];
		} else if($varContentOcc =='' && $arrDetail[6]!='') {
			$varContentOcc	.= $arrDetail[6];
		} else if($varContentOcc =='' && $arrDetail[6]=='') {
			$varContentOcc	.= '';
		}*/

		if($varContentEdu!=''&&$varContentOcc!='') {
			$varContentEduOcc	= $varContentEdu.', '.$varContentOcc;
		} else if($varContentEdu!=''&&$varContentOcc=='') {
			$varContentEduOcc	= $varContentEdu;
		} else if($varContentEdu==''&&$varContentOcc!='') {
			$varContentEduOcc	= $varContentOcc;
		}





	$varBasicView			= $obj->funMailerTplPath."/partnerpref.tpl"; //do change (template file)
	$mailermsg	= $obj->getContentFromFile($varBasicView);

	$funServerUrl	= $obj->funServerUrl;
	$funProductName	= $obj->funProductName;
	$funLogoPath	= $obj->funLogoPath;
	$funMailerImgsPath	= $obj->funMailerImgPath;

	if($varUserPhotoDetail == 'PP') {
		$varReplacePhUrl	= $obj->funImgsServerPath.'/images/img85_pro.gif';
	} else if($varUserPhotoDetail != '') {
		$arrUserPhotoDetail = explode('~',$varUserPhotoDetail);
		$varReplacePhUrl	= $varPhotoUrl.'/'.$funMatriId{3}.'/'.$funMatriId{4}.'/'.$arrUserPhotoDetail[0];
	} else {
		$varGenderImg		= ($varBasicDetails[0]['G']==1)?'img85_phnotadd_m.gif':'img85_phnotadd_f.gif';
		$varReplacePhUrl	= $obj->funImgsServerPath.'/images/'.$varGenderImg;
	}
	$varProfileViewLink		= $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=viewprofile~id=".$funMatriId;
	$unsubscibeLink = $funServerUrl."/login/index.php?redirect=".$funServerUrl."/profiledetail/index.php?act=mailsetting";

	$mailermsg = str_replace("<--PHOTOURL-->",$varReplacePhUrl,$mailermsg);
	$mailermsg = str_replace("<--NAME-->",ucwords($varBasicName),$mailermsg);
	$mailermsg = str_replace("<--OPPNAME-->",ucwords($oppname),$mailermsg);
	$mailermsg = str_replace("<--OPPMATRIID-->",ucwords($oppmatriid),$mailermsg);
	$mailermsg = str_replace("<--AGE-->",$varBasicAge,$mailermsg);
	$mailermsg = str_replace("<--HEIGHT-->",$varBasicHtUnit,$mailermsg);
	$mailermsg = str_replace("<--RELIGIOUS-->",$varBasicReligionSubcaste,$mailermsg);
	$mailermsg = str_replace("<--COUNTRY-->",$varBasicCountry,$mailermsg);
	$mailermsg = str_replace("<--EDUOCC-->",$varContentEduOcc,$mailermsg);
	$mailermsg = str_replace("<--PROFILEURL-->",$varProfileViewLink,$mailermsg);
	$mailermsg = str_replace("<--MATRIID-->",$funMatriId,$mailermsg);
	$mailermsg = str_replace('<--PRODUCT_NAME-->',$funProductName,$mailermsg);
	$mailermsg = str_replace('<--LOGO-->',$funLogoPath,$mailermsg);
	$mailermsg = str_replace('<--MAILERIMGSPATH-->',$funMailerImgsPath,$mailermsg);
	$mailermsg = str_replace('<--UNSUBSCRIBE_LINK-->',$unsubscibeLink,$mailermsg);
  
	//RM Details
	$mailermsg = str_replace("<--MESSAGE-->",$message,$mailermsg);
	$mailermsg = str_replace("<<EMAIL>>",$toemail,$mailermsg);

	$rmuserdet=explode("$",$rmuserinfo);

	$mailermsg = str_replace("<--RMNAME-->",ucwords($rmuserdet[0]),$mailermsg);
	$mailermsg = str_replace("<--RMEMAIL-->",$rmuserdet[1],$mailermsg);
	$mailermsg = str_replace("<--RMPHONE-->",$rmuserdet[2],$mailermsg);
	$mailermsg = str_replace("<--RMTIME-->","9:00 AM TO 06:00PM",$mailermsg);
	$prevurl=$funServerUrl."/payment/privilege-service.php";
	$mailermsg = str_replace("<--PREVURL-->",$prevurl,$mailermsg);

	  $from		= 'info@'.$obj->funSiteName;
	  //$from = "info@bharatmatrimony.com";
	  $from = str_replace("/\r/", "", $from); 
	  $from = str_replace("/\n/", "", $from);

	  $from_header = "MIME-Version: 1.0\n";
	  $from_header .= "Content-type: text/html; charset=iso-8859-1\n";
	  $from_header .= "From: ".$obj->funProductName.".com <".$from.">\n";
	  $from_header .= "Reply-To: ".$rmuserdet[1]." \n";


	 // putenv("MAILUSER=bharat"); 
	 // putenv("MAILHOST=server.bharatmatrimony.com");

	  $toemail = str_replace("/\r/", "", $toemail); 
	  $toemail = str_replace("/\n/", "", $toemail);
	  $subtxt=ucwords($varBasicName)." has been specially chosen for you  by our Relationship Manager";

	 // $stat=mail($toemail, $subtxt, $mailermsg, $from_header, "-fbharat@server.bharatmatrimony.com"); //mail sending function...
	  $stat=mail($toemail, $subtxt, $mailermsg, $from_header); //mail sending function...
	  //$stat=mail("s.ganesh@bharatmatrimony.com,padmanaban@consim.com", $subtxt, $mailermsg, $from_header, "-fbharat@server.bharatmatrimony.com"); //mail sending function...
	  return;
}

function Updatememlist($obj,$count,$matriid) {
	global $TABLE,$varCbsRminterfaceDbInfo;
	$partnerpreftbl=$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'];	

	$argFields 		= array('Status','TotalSentCount');
	$argFieldsValues= array('3',$count);
	$argCondition	= "MatriId='".$matriid."'";
	$varUpdateId	= $obj->update($partnerpreftbl,$argFields,$argFieldsValues,$argCondition);
	return '';
}


//OBJECT DECLARATION
$objRMInterface= new MailerMatchWatch;
$objMailerMatchWatch= new MailerMatchWatch;
$objRMInterfaceMaster= new MailerMatchWatch;

//Connect DB
$objRMInterface->dbConnect('S',$varCbsRminterfaceDbInfo['DATABASE']);
$objMailerMatchWatch->dbConnect('S',$varDbInfo['DATABASE']);
$objRMInterfaceMaster->dbConnect('M',$varCbsRminterfaceDbInfo['DATABASE']);

//Variable Declaration
$arrFlippedMatriIdPre	= array_flip($arrMatriIdPre);
$varCurrentDateOnly		= date('Y-m-d');
$varCurrentDate			= date('Y-m-d H:i:s');

$todaymatrid			= GetTodayMatriId($objRMInterface,$varCurrentDateOnly);	 //return today schduled matriid.

for($mid=0;$mid<count($todaymatrid);$mid++) {

	$matriid=$todaymatrid[$mid][1];
	$rmuserid=$todaymatrid[$mid][0];
	$message=$todaymatrid[$mid][2];
	$varMailerSetMembersCnt = 0;
	$arrUserDetail			= array();
	$arrProfileMatchId		= array();
	$varPrefix				= '';
	$varCommunityId			= '';

	//Find community id and domain prefix
	$varPrefix				= substr($matriid,0,3);
	$varCommunityId			= $arrFlippedMatriIdPre[$varPrefix];
	//echo $varPrefix.'----'.$varCommunityId.'<BR><BR>';

	//get community wise details
	$objMailerMatchWatch->getCommunityWiseDtls($varPrefix);

	//getPhotoUel
	$varPhotoUrl = 'http://img.'.$objMailerMatchWatch->funSiteName.'/membersphoto/'.$arrFolderNames[$varPrefix];

	//get user detail
	$arrUserDetail	= $objMailerMatchWatch->selectDetails(array(0=>"'".$matriid."'"));
    //print_r($arrUserDetail);

	//get gender detail
	$MatriGender=$arrUserDetail[0]['G'];

	//Get Photo details
	$varUserPhotoDetail	= getPhotoDetails($varCommunityId,$matriid,$objMailerMatchWatch);

	//get Partner details
	$ppval=getPartnerDetail($varCommunityId,$matriid,$objMailerMatchWatch);

	//Getting Profile Match MatriId
	$arrProfileMatchId=ProfileIamLookingFor($varCommunityId,$matriid,$MatriGender,$ppval,$objMailerMatchWatch);	  //Return the profile match matriid for
	$varMatchProfileCnt = '';
	$varMatchProfileCnt	= sizeof($arrProfileMatchId);
	/*echo $matriid;
	print_r($arrProfileMatchId);
	echo "<BR><BR>";*/
	if($varMatchProfileCnt != 0) {
		$partneremail=GetPartnerEmail($arrProfileMatchId,$objMailerMatchWatch);	//Return the partner match email id
		//print_r($partneremail);

		$partnername=GetPartnerName($arrProfileMatchId,$objMailerMatchWatch);	//Return the partner match email id
		//print_r($partnername);

		for($varMatchIdCnt=0;$varMatchIdCnt<count($partneremail);$varMatchIdCnt++) {
			if (!array_key_exists($rmuserid,$rmuser))	 {
				$varRMDetailTbl			= $varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'];	
				$argFields				= array('Name','Email','Mobile');
				$argCondition			= " WHERE RMUserid='".$rmuserid."'";
				$arrRMDetailResultSet	= $objRMInterface->select($varRMDetailTbl, $argFields, $argCondition, 0);
				$arrRMDetailResult		= mysql_fetch_assoc($arrRMDetailResultSet);
				$value=$arrRMDetailResult["Name"]."$".$arrRMDetailResult["Email"]."$".$arrRMDetailResult["Mobile"];
				$rmuser[$rmuserid]=$value;
			}
			//echo $rmuser[$rmuserid].','.$matriid.','.$message.','.$partneremail[$varMatchIdCnt][1].','.$partneremail[$varMatchIdCnt][0].'<BR>';
			$sendmessage=sendmailtopartner($rmuser[$rmuserid],$arrUserDetail,$message,$partneremail[$varMatchIdCnt][1],$partneremail[$varMatchIdCnt][0],$partnername[$varMatchIdCnt][1],$varUserPhotoDetail,$varPhotoUrl,$objMailerMatchWatch); //send the mail to partner member
		}
	}

	$partnertoid=join($arrProfileMatchId,", ");
	$partnertotcount=$varMatchProfileCnt;
	$todaysdate=$todaymatrid[$mid][3];
	$headers .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
	$headers .= "X-Mailer: PHP mailer\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$mailcontent="<p style='padding-top:10px;padding-left:20px; font:normal 13px arial; color:#4E4E4E;'><b>Date :</b>".$todaysdate."<br><b>Matriid :</b>".$matriid."<br><b>Partner Id : </b>".$partnertoid."<br><b>Total Count :</b>".$partnertotcount."<br></p>";
	 mail("greennjk@gmail.com","Partner Preference Query",$mailcontent,$headers);
	 $updatelist=Updatememlist($objRMInterfaceMaster,$partnertotcount,$matriid);
 }
?>
