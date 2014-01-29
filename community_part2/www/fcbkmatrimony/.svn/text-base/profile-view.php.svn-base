<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 2007-08-25
# End Date		: 2007-08-25
# Project		: MatrimonyProduct
# Module		: Registration - Facebook
#=============================================================================================================
//FILE INCLUDES
require_once('header.php');
require_once('navinc.php');

//OBJECT DECLARATION
$objProductFacebook = new QuickSearch;

//VARIABLE DECLARATION
$varMatriId 						= $_REQUEST['matrimonyId'];
$varSearchbyId						= $_REQUEST['searchbyid'];
$varCurrentDate						= date('Y-m-d H:i:s');
$varFilterMaritalStatus				= 'yes';
$varFilterAgeStatus					= 'yes';
$varFilterCountryStatus				= 'yes';
$varMailId							= '';
$varMailReceivedSentInfo			= array();
//$varOfferExists						= $objProductFacebook->getOfferExists($sessMatriId);
$objProductFacebook->clsCountField		= 'MatriId';
$objProductFacebook->clsAllowedLimit	= 'no';
if ($varSearchbyId=='yes') { $objProductFacebook->clsPrimary	= array('User_Name'); }//if
else { $objProductFacebook->clsPrimary	= array('MatriId'); }//else

$objProductFacebook->clsPrimaryValue	= array($varMatriId);
$objProductFacebook->clsPrimarySymbol	= array('=');

#Getting login information for the selected profile
$objProductFacebook->clsTable	= 'memberlogininfo';
$objProductFacebook->clsFields	= array('MatriId','User_Name','Email','Paid_Status','Valid_Days','Date_Paid');
$varCheckProfileId			= $objProductFacebook->numOfResults();
if ($varCheckProfileId > 0 )
{
	$varLoginInfo			= $objProductFacebook->selectListSearchResult();
	$varUsername			= $varLoginInfo['User_Name'];
	$varPaidDate			= $varLoginInfo['Date_Paid'];
	$varValidDays			= $varLoginInfo['Valid_Days'];

	if ($varSearchbyId=='yes')
	{
		// if username search is come
		$varMatriId								= $varLoginInfo['MatriId'];
		$objProductFacebook->clsPrimaryValue	= array($varMatriId);
		$objProductFacebook->clsPrimary			= array('MatriId');
	}//if


	#Getting member information for the selected profile
	$objProductFacebook->clsTable	= 'memberinfo';
	$objProductFacebook->clsFields	= array('Name','Age','Dob','Gender','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Complexion','Eye_Color','Hair_Color','Physical_Status','Blood_Group','Marital_Status','No_Of_Children','Children_Living_Status','Education_Category','Education_Detail','Employed_In','Occupation','Occupation_Detail','Income_Currency','Annual_Income','Religion','Subcaste','Mother_Tongue','Religious_Values','Ethnicity','Resident_Status','Country','Citizenship','Residing_State','Residing_City','Contact_Address','Contact_Phone','Contact_Mobile','About_Myself','Eating_Habits','Smoke','Drink','Profile_Viewed','Profile_Created_By','Profile_Referred_By','Publish','Last_Login','Photo_Set_Status','Protect_Photo_Set_Status','Filter_Set_Status','Video_Set_Status','Partner_Set_Status','Family_Set_Status','Interest_Set_Status','Date_Created','Date_Updated');
	$varMemberInfo				= $objProductFacebook->selectListSearchResult();

	$varPublish					= $varMemberInfo['Publish'];
	$varLastLogin				= $varMemberInfo['Last_Login'];
	$varPhotoSetStatus			= $varMemberInfo['Photo_Set_Status'];
	$varProtectPhotoSetStatus	= $varMemberInfo['Protect_Photo_Set_Status'];
	$varFilterSetStatus			= $varMemberInfo['Filter_Set_Status'];
	$varVideoSetStatus			= $varMemberInfo['Video_Set_Status'];
	$varPartnerSetStatus		= $varMemberInfo['Partner_Set_Status'];
	$varFamilySetStatus			= $varMemberInfo['Family_Set_Status'];
	$InterestSetStatus			= $varMemberInfo['Interest_Set_Status'];
	$DateCreated				= $varMemberInfo['Date_Created'];
	$DateUpdated				= $varMemberInfo['Date_Updated'];
	$varCountry					= $varMemberInfo['Country'];
	$varResidingState			= $varMemberInfo['Residing_State'];
	$varResidingStateId			= $varMemberInfo['Residing_State'];
	$varGender					= $varMemberInfo['Gender'];
	$varHeight						= $objProductFacebook->getHeightUnit($varMemberInfo['Height'].'~'.$varMemberInfo['Height_Unit']);
	$varStateID = ($varResidingState-1);
	if ($varCountry==98)	{ $varResidingState = $varArrResidingStateList[$varResidingState];} //if
	elseif ($varCountry==222){ $varResidingState = $varArrResidingUSAStateList[$varResidingState];}//elseif
	else { $varResidingState = $varResidingState; } 

}//if

if ($varMatriId!="" || $varSearchbyId!="") { 
?>

<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr>
		<td valign="middle" class="grtxtbold1"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px !important;padding-bottom:10px"><font class="heading">View Profile</font></div>
		</td>
	</tr>
</table>

<?
}

#Compare with Filter settings
if (($varCheckProfileId==1 && $varPublish==1) || (($sessMatriId == $varMatriId) && ($sessMatriId !="")))
{
	#Getting family information for the selected profile
	$objProductFacebook->clsTable	= 'memberfamilyinfo';
	$objProductFacebook->clsFields	= array('Family_Value');
	$varFamilyInfo				= $objProductFacebook->selectListSearchResult();

	#update profile view count
	if($varMatriId != $sessMatriId && $sessMatriId!="") { $objProductFacebook->updateProfileViewedCount($varMatriId); }//if

	#update profile view details
	if ($sessMatriId !='' && $varMatriId != $sessMatriId)
	{
		$objProductFacebook->clsTable			= 'memberprofileviewedinfo';
		$objProductFacebook->clsFields			= array('MatriId','Opposite_MatriId','Date_Viewed');
		$objProductFacebook->clsFieldsValues	= array($sessMatriId,$varMatriId,$varCurrentDate);
		$objProductFacebook->addQuickSearch();
	}//if


	#Getting partner preference information for the selected profile
	if($varPartnerSetStatus == 1)
	{
		$objProductFacebook->clsTable	= 'memberpartnerinfo';
		$objProductFacebook->clsFields	= array('MatriId','Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Height_Unit','Physical_Status','Education','Religion','Citizenship','Country','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Caste_Or_Division','Date_Updated');
		$varPartnerInfo	= $objProductFacebook->selectListSearchResult();
		$varAgeFrom		= $varPartnerInfo['Age_From'];
		$varAgeTo		= $varPartnerInfo['Age_To'];
		$varHeightFrom	= round($varPartnerInfo['Height_From']);
		$varHeightTo	= round($varPartnerInfo['Height_To']);
		$varPartnerHeightFrom = $objProductFacebook->getHeightUnit($varPartnerInfo['Height_From'].'~'.$varPartnerInfo['Height_Unit']);
		$varPartnerHeightTo	  = $objProductFacebook->getHeightUnit($varPartnerInfo['Height_To'].'~'.$varPartnerInfo['Height_Unit']);

	}//if

	//CHECK IF MEMBER HAS PAID GET REMAINING DAYS
	if($sessPaidStatus==1)
	{
		$varTodayDate		= date('m-d-Y');
		$varPaidDate		= date('m-d-Y',strtotime($varPaidDate));
		$varNumOfDays		= $objProductFacebook->dateDiff('-',$varTodayDate,$varPaidDate);
		$varRemainingDays	= $varValidDays - $varNumOfDays;
	}//if

	#Getting add-notes information for the selected profile
	/*if ($sessMatriId !='' && $varAction=='inbox')
	{
		$objProductFacebook->clsTable		= 'mailreceivedinfo';
		$objProductFacebook->clsPrimary		= array('Mail_Id');
		$objProductFacebook->clsFields		= array('Notes');
		$objProductFacebook->clsPrimaryValue= array($varMiddleId);
		$varAddNotesInfo		= $objProductFacebook->selectListSearchResult();
		if ($varAddNotesInfo['Notes'] != '') { $varNotesInfo	= 'yes'; }//if
	}//if*/
	
	$varFilterMatchedProfile				=	'yes';
	if($sessMatriId != $varMatriId)
	{
		#Check Filter Settings.
		$objProductFacebook->clsTable			= 'memberfilterinfo';
		$varNoOfFilterRecords				= $varFilterSetStatus;
		if ($varNoOfFilterRecords==1)
		{
			$objProductFacebook->clsPrimary		= array('MatriId');
			$objProductFacebook->clsPrimaryValue= array($varMatriId);
			$objProductFacebook->clsFields		= array('Marital_Status','Age_Above','Age_Below','Country');
			$varSelectFilterInfo			= $objProductFacebook->selectListSearchResult();
			$objProductFacebook->clsPrimaryValue= array($sessMatriId);
			$objProductFacebook->clsTable		= 'memberinfo';
			$objProductFacebook->clsFields		= array('Marital_Status','Age','Country');
			$varSelectOppositeInfo			= $objProductFacebook->selectListSearchResult();
			$varFilterCountryStatus			= 'yes';
			$varFilterAgeStatus				= 'yes';
			$varFilterMaritalStatus			= 'yes';


			$varFilterInfoMaritalStatus		= $varSelectFilterInfo['Marital_Status'];
			$varFilterInfoAgeAbove			= $varSelectFilterInfo['Age_Above'];
			$varFilterInfoAgeBelow			= $varSelectFilterInfo['Age_Below'];
			$varFilterInfoCountry			= $varSelectFilterInfo['Country'];
			
			#Check with Marital Status
			if ($varFilterInfoMaritalStatus !='' && $varFilterInfoMaritalStatus !=0)
			{
				$argOppositeGender		= array();
				$argFilterGender		= array();
				$argOppositeGender		= $varSelectOppositeInfo['Marital_Status'];
				$argFilterGender		= $varFilterInfoMaritalStatus;
				$varFilterMaritalStatus	= $objProductFacebook->selectFilterInfo($argFilterGender,$argOppositeGender);
			}
			
			#check with Age
			if ($varFilterInfoAgeAbove !='' && $varFilterInfoAgeBelow !=0)
			{
				if (($varSelectOppositeInfo['Age'] >= $varFilterInfoAgeAbove) && ($varSelectOppositeInfo['Age'] <= $varFilterInfoAgeBelow))
				{ $varFilterAgeStatus	= 'yes'; } else { $varFilterAgeStatus	= 'no'; }

			}//if

			#Check with Country..
			if ($varFilterInfoCountry !='' && $varFilterInfoCountry !=0)
			{
				$argOppositeCountry			= array();
				$argFilterCountry			= array();
				$argOppositeCountry			= $varSelectOppositeInfo['Country'];
				$argFilterCountry			= $varFilterInfoCountry;
				$varFilterCountryStatus		= $objProductFacebook->selectFilterInfo($argFilterCountry,$argOppositeCountry);
			}
			if ($varFilterCountryStatus=='no' || $varFilterAgeStatus=='no' || $varFilterMaritalStatus=='no')
			{ 
				$varFilterMatchedProfile  = 'no';
			}//if
		}//if
	}//if

#Getting bookmarked,ignored,blocked information for the selected profile
if ($sessMatriId !='')
{
	$varMyListInfo		= $objProductFacebook->checkMyListViewProfile($varMatriId,$sessMatriId);
}//if


#Getting protectedinfo for the selected profile
if($varPhotoSetStatus == 1)
{
	//CHECK PHOTO PROTECT
	if ($varProtectPhotoSetStatus==1 && $varMatriId != $sessMatriId)
	{
		$varPhotoName= '../images/protectedphotoimg-150X150.gif';
		$varFileName="javascript: funProtectedPhoto('".$varMatriId."')";
		$varFunction="funProtectedPhoto('".$varMatriId."')";
	}//if
	else
	{
		//SELECT PHOTOS FROM memberphotoinfo
		$objProductFacebook->clsTable			= 'memberphotoinfo';
		$objProductFacebook->clsFields			= array('Thumb_Small_Photo1','Photo_Status1', 'Thumb_Small_Photo2','Photo_Status2','Thumb_Small_Photo3','Photo_Status3');
		$objProductFacebook->clsPrimary			= array('MatriId');
		$objProductFacebook->clsPrimaryValue	= array($varMatriId);
		$varSelectPhotosList				= $objProductFacebook->selectListSearchResult();

		$varDisplayAddedPhotos = '';
		$varPhotoInfo		   = '';
		$funPhotoPaging		   = '';
		$funPhotoCount = 0;
		for($i=1;$i<4;$i++)
		{
			$varPhotoStatus	= 'Photo_Status'.$i;
			if($varSelectPhotosList[$varPhotoStatus] == 1 || $varSelectPhotosList[$varPhotoStatus] == 2)
			{
				$varSmallPhoto	= 'Thumb_Small_Photo'.$i;
				$varPhotoInfo[$funPhotoCount]['Thumb_Small_Photo']= $varSelectPhotosList[$varSmallPhoto];
				$funPhotoCount++;
			}//if
		}//for

		$varNormalPhotoName		= $varPhotoInfo!=''?$varPhotoInfo[0]['Thumb_Small_Photo']:'';

		if ($varNormalPhotoName !="")
		{
			//display first photo
			$funPhotoPaging		= "";
			$varPhotoPath		= $confValues['PhotoReadURL'].'/membersphoto/'.$varMatriId{1}.'/'.$varMatriId{2}.'/';
			$varPhotoName		= $varPhotoPath.$varNormalPhotoName;
			$varFileName		= "javascript: funViewPhoto('".$varMatriId."')";
			$varFunction		= "funViewPhoto('".$varMatriId."')";

			//photo paging here
			if ($funPhotoCount > 1)
			{
				$funPhotoPaging		.= '<div style="padding-top:3px;">';
				for ($i=0;$i<$funPhotoCount;$i++)
				{
					$funPhotoName	 = $varPhotoInfo[$i]['Thumb_Small_Photo'];
					$funPhotoPaging	.= '<a href="javascript: ';
					$funPhotoPaging	.= "funShowPhoto('".$varPhotoPath.$funPhotoName."','".$varMatriId."');\" class=\"smalltxt\">";
					$funPhotoPaging	.= '<font color="#94663E"><u>'.($i+1).'</u></font></a> ';
				}//for
				$funPhotoPaging		.= '</div>';
			}//if
		}//else if
	}//if
}//if
else
{
	if ($sessMatriId == $varMatriId)
	{
		$varPhotoName	= '../images/addphotoimg-150x150.gif';
		$varFileName	= "javascript: addPhoto();";
		$varFunction	= "addPhoto();";
	}//if
	else 
	{
		$varPhotoName	= '../images/viewphotonotfoundimg.gif';
		if($sessMatriId=="")
			$varFileName	= $confValues['ServerURL']."/profiles/".$varMatriId."/request-photo/";
		else {
			$varFileName	= "javascript: showrequest('".$varMatriId."')";
			$varFunction	= "showrequest('".$varMatriId."')";
		}
	}//else
}//else


//OFFER FOR FREE MEMBERS TO CONTACT 10 PAID MEMBERS-->ROHINI-->19 Jan 2007-->Starts Here
if($sessMatriId!= "" && $sessPaidStatus==0)
{  
	/*if($varOfferExists==1)
	{
		$varContactCnt						= $objProductFacebook->getContactCount($sessMatriId);
		if($varContactCnt >=10)//OFFER FOR FREE MEMBERS TO CONTACT 10 PAID MEMBERS-->ROHINI-->19 Jan 2007-->Ends Here
			$varDisplayLink= '../payment/payment-options.php?matrimonyId='.$sessMatriId;
		//OFFER FOR FREE MEMBERS TO CONTACT 10 PAID MEMBERS-->ROHINI-->19 Jan 2007-->Starts Here	
		else
			$varDisplayLink= "javascript: funContct('".$varMatriId."')";
	}
	if($varOfferExists==0)*/
	$varDisplayLink= $confValues['ServerURL'].'/payment/matrimonyId='.$sessMatriId.'/';
}//if	
//OFFER FOR FREE MEMBERS TO CONTACT 10 PAID MEMBERS-->ROHINI-->19 Jan 2007-->Ends Here

$objProductFacebook->clsTable		= 'memberactioninfo';
$objProductFacebook->clsCountField	= 'MatriId';
$objProductFacebook->clsPrimary		= array('MatriId','Opposite_MatriId');
$objProductFacebook->clsPrimaryKey	= array('AND');
$objProductFacebook->clsPrimaryValue= array($sessMatriId,$varMatriId);
$objProductFacebook->clsFields		= array('Mail_Id_Sent','Mail_Sent','Mail_Sent_Date','Mail_Sent_Status','Mail_Id_Received','Mail_Received','Mail_Received_Date','Mail_Received_Status','Receiver_Replied','Receiver_Replied_Date','Receiver_Declined','Receiver_Declined_Date','Sender_Replied','Sender_Replied_Date','Sender_Declined','Sender_Declined_Date','Interest_Id_Sent','Interest_Sent','Interest_Sent_Date','Interest_Sent_Status','Interest_Id_Received','Interest_Received','Interest_Received_Date','Interest_Received_Status','Date_Updated');
$varLastActionInfo				= $objProductFacebook->selectListSearchResult();
$varLastActionCnt				= $objProductFacebook->numOfResults();
if($varLastActionCnt==1) 
{
	if ($varLastActionInfo["Date_Updated"] !="0000-00-00 00:00:00") 			 
		$varMessageDate				=$objProductFacebook->getDateMothYear('d-M-Y',$varLastActionInfo["Date_Updated"]);
	
	$varArrayDate = array('Mail_Sent' => $varLastActionInfo['Mail_Sent_Date'],'Mail_Received'=>$varLastActionInfo['Mail_Received_Date'],Interest_Received=>$varLastActionInfo['Interest_Received_Date'],'Interest_Sent'=>$varLastActionInfo['Interest_Sent_Date'],'Sender_Declined'=>$varLastActionInfo['Sender_Declined_Date'],'Sender_Replied'=>$varLastActionInfo['Sender_Replied_Date'],'Receiver_Replied'=>$varLastActionInfo['Receiver_Replied_Date'],'Receiver_Declined'=>$varLastActionInfo['Receiver_Declined_Date']);
	$varArray		= arsort($varArrayDate);
	$varArrayKeys	= array_keys($varArrayDate);
	$varArrayKey	= $varArrayKeys[0];
	$varArrayVal	= $varArrayDate[$varArrayKey];

	if($varArrayKey=='Mail_Sent')
	{
		if($varLastActionInfo['Mail_Sent_Status']==0) 
			$varMessageHead			= 'This member is yet to read your mail.';
		elseif($varLastActionInfo['Mail_Sent_Status']==1) 
			$varMessageHead			= 'Your Mail to this member is read.';
	}
	elseif($varArrayKey=='Mail_Received')
	{
		if($varLastActionInfo['Mail_Received_Status']==0) 
		{
			$varMessageHead		= "This member has sent you mail. Your reply is pending.";
			$varMailId			= $varLastActionInfo['Mail_Id_Received'];
		}
		elseif($varLastActionInfo['Mail_Received_Status']==1) 
			$varMessageHead			= "Your reply to this member's mail is pending.";
		$varMessageButton			= 'yes';
	}
	elseif($varArrayKey=='Interest_Received')
	{
		if($varLastActionInfo['Interest_Received_Status']==0) 
			$varMessageHead			= 'This member has sent salaam to you. Your reply is pending.';
		elseif($varLastActionInfo['Interest_Received_Status']==1) 
			$varMessageHead			= "You have accepted this members's salaam.";
		elseif($varLastActionInfo['Interest_Received_Status']==3) 
			$varMessageHead			= "Your have declined this member's salaam.";
		$varInterestButton = 'yes';
		$objProductFacebook->clsTable		= 'interestreceivedinfo';
		$objProductFacebook->clsPrimary		= array('MatriId','Opposite_MatriId','Interest_Id');
		$objProductFacebook->clsPrimaryKey	= array('AND','AND');
		$objProductFacebook->clsPrimaryValue= array($sessMatriId,$varMatriId,$varLastActionInfo['Interest_Id_Received']);
		$objProductFacebook->clsFields		= array('Interest_Option');
		$varInterestReceivedinfo		= $objProductFacebook->selectListSearchResult();
		$varMessageContent				= $varArrSendSalamList[$varInterestReceivedinfo['Interest_Option']];
	}
	elseif($varArrayKey=='Interest_Sent')
	{
		if($varLastActionInfo['Interest_Sent_Status']==0) 
			$varMessageHead			= 'You have sent salaam to this member. The reply is pending.';
		elseif($varLastActionInfo['Interest_Sent_Status']==1) 
			$varMessageHead			= "This member has accepted your salaam.";
		elseif($varLastActionInfo['Interest_Sent_Status']==3) 
			$varMessageHead			= "This member has declined your salaam.";
		$objProductFacebook->clsTable		= 'interestsentinfo';
		$objProductFacebook->clsPrimary		= array('MatriId','Opposite_MatriId','Interest_Id');
		$objProductFacebook->clsPrimaryKey	= array('AND','AND');
		$objProductFacebook->clsPrimaryValue= array($sessMatriId,$varMatriId,$varLastActionInfo['Interest_Id_Sent']);
		$objProductFacebook->clsFields		= array('Interest_Option');
		$varInterestsentinfo			= $objProductFacebook->selectListSearchResult();
		$varMessageContent				= $varArrSendSalamList[$varInterestsentinfo['Interest_Option']];
		$varRemainderButton='yes';
	}
	elseif($varArrayKey=='Sender_Replied')
	{
		$varMessageHead			= 'This member has replied your mail.';
	}
	elseif($varArrayKey=='Receiver_Replied')
	{
		$varMessageHead			= 'You have replied to the mail received from this member.';
	}
	elseif($varArrayKey=='Sender_Declined')
	{
		$varMessageHead			= 'This member has declined your mail.';
	}
	elseif($varArrayKey=='Receiver_Declined')
	{
		$varMessageHead			= 'You have declined mail from this member.';
	}

	if($varArrayKey=='Sender_Replied' || $varArrayKey=='Mail_Sent' || $varArrayKey=='Sender_Declined')
	{		
		$objProductFacebook->clsTable		= 'mailsentinfo';
		$objProductFacebook->clsPrimary		= array('MatriId','Opposite_MatriId','Mail_Id');
		$objProductFacebook->clsPrimaryKey	= array('AND','AND');
		$objProductFacebook->clsPrimaryValue= array($sessMatriId,$varMatriId,$varLastActionInfo['Mail_Id_Sent']);
		$objProductFacebook->clsFields		= array('Mail_Message');
		$varMailSentinfo				= $objProductFacebook->selectListSearchResult();
		$varMessageContent				= $varMailSentinfo['Mail_Message'];
	}
	if($varArrayKey=='Receiver_Replied' || $varArrayKey=='Mail_Received' || $varArrayKey=='Receiver_Declined')
	{		
		$objProductFacebook->clsTable		= 'mailreceivedinfo';
		$objProductFacebook->clsPrimary		= array('MatriId','Opposite_MatriId','Mail_Id');
		$objProductFacebook->clsPrimaryKey	= array('AND','AND');
		$objProductFacebook->clsPrimaryValue= array($sessMatriId,$varMatriId,$varLastActionInfo['Mail_Id_Received']);
		$objProductFacebook->clsFields		= array('Mail_Message');
		$varMailReceivedinfo			= $objProductFacebook->selectListSearchResult();
		$varMessageContent				= $varMailReceivedinfo['Mail_Message'];
	}
}//if

#Getting Mail Received & Sent information for the selected profile
if ($sessMatriId !='' && $varMailId !='')
{
	$objProductFacebook->clsTable			= 'mailreceivedinfo';
	$objProductFacebook->clsPrimary			= array('Mail_Id');
	$objProductFacebook->clsCountField		= 'Mail_Id';
	$objProductFacebook->clsPrimaryValue	= array($varMailId);

	#update mail status
	$objProductFacebook->clsFields			= array('MatriId','Opposite_MatriId','Mail_Id','Mail_Message', 		'Date_Received','Status','Date_Read','Date_Replied','Message_Read','Sender_Deleted');
	$varMailReceivedSentInfo			= $objProductFacebook->selectListSearchResult();
}//if

if ($varMailId!='' && ($varMailReceivedSentInfo['Status']==0))
{
	// Update Status in mailreceivedinfo
	$objProductFacebook->clsFields			= array('Date_Read','Status');
	$objProductFacebook->clsFieldsValues	= array($varCurrentDate,1);
	$objProductFacebook->updateQuickSearch();
	
	if($varMailReceivedSentInfo['Sender_Deleted'] == 0 && ($varMailReceivedSentInfo['Message_Read']==0))
	{
		//UPDATE IN STATUS mailsentinfo
		$objProductFacebook->clsTable			= 'mailsentinfo';
		$objProductFacebook->clsFields			= array('Date_Read','Status');
		$objProductFacebook->clsFieldsValues	= array($varCurrentDate,1);
		$objProductFacebook->updateQuickSearch();
	}//if

	//UPDATE NOT REPLIED STATUS IN TO LAST ACTION TABLE
	#sender side
	$objProductFacebook->clsTable			= 'memberactioninfo';
	$objProductFacebook->clsPrimaryKey		= array('AND');
	$objProductFacebook->clsPrimaryValue	= array($varMailId, $sessMatriId);
	if($varMailReceivedSentInfo['Message_Read'] == 0)
	{
		$objProductFacebook->clsPrimary		= array('Mail_Id_Sent', 'Opposite_MatriId');
		$objProductFacebook->clsFields		= array('Mail_Sent_Status','Date_Updated');
		$objProductFacebook->clsFieldsValues= array(1,$varCurrentDate);
		$objProductFacebook->updateQuickSearch();
	}
	#receiver side	
	$objProductFacebook->clsPrimary			= array('Mail_Id_Received', 'MatriId');
	$objProductFacebook->clsFields			= array('Mail_Received_Status','Date_Updated');
	$objProductFacebook->clsFieldsValues	= array(1,$varCurrentDate);
	$objProductFacebook->updateQuickSearch();

	//UPDATE MAIL PENDING COUNT IN memberstatistics
	#sender side
	$objProductFacebook->clsTable			= 'memberstatistics';
	$objProductFacebook->clsPrimary			= array('MatriId');
	if(($varMailReceivedSentInfo['Sender_Deleted'] == 0) && ($varMailReceivedSentInfo['Message_Read'] == 0))
	{
		$objProductFacebook->clsPrimaryValue	= array($varMailReceivedSentInfo['Opposite_MatriId']);
		$objProductFacebook->clsFields			= array('Mail_UnRead_Sent','Mail_Read_Sent');	
		$objProductFacebook->clsFieldsValues	= array('Mail_UnRead_Sent-1','Mail_Read_Sent+1');
		$objProductFacebook->updateMyMessageCount();
	}//if

	#receiver side
	$objProductFacebook->clsPrimaryValue	= array($sessMatriId);
	$objProductFacebook->clsFields			= array('Mail_UnRead_Received','Mail_Read_Received');	
	$objProductFacebook->clsFieldsValues	= array('Mail_UnRead_Received-1','Mail_Read_Received+1');
	$objProductFacebook->updateMyMessageCount();
}//if
?>
<script language="javascript" src="<?=$confValues['ServerURL']?>/search/includes/profile-view.js" type="text/javascript"></script>
<script language="javascript" src="../registration/includes/add-physical.js" type="text/javascript"></script>

<!-- Calling Ajax Function To Display Photo Starts Here -->
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argPhotoName,argMatriId)
	{
		argPlaceHolderId="id" + argMatriId;
		document.getElementById(argPlaceHolderId).src = argPhotoName;
	}//showPhoto
</script>
<!-- Calling Ajax Function To Display Photo Ends Here -->

<!--DISPLAY FILTER SETTINGS STARTS HERE-->
<?php if ($varFilterMatchedProfile == "no" && $varPublish==1 ) { ?><br>
<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594">
	<tr><td valign="top" colspan="4" class="viewheading"></td></tr>
	<tr bgcolor="#FFFFFF">
		<td valign="top" class="smalltxt" align="center" height="25" style="padding-top:5px;padding-left:5px;padding-bottom:3px;">
			<?php 
				if($sessMatriId !="")
				{
					echo "Username - <b>".$varUsername."</b>'s filter settings does not match with you.So, please try another profile.";
				}
				else
				{
					echo "Sorry, Username - <b>".$varUsername."</b> is set filters. <br>If you want to see his/her profile details, please click here to <a href='".$confValues['ServerURL']."/login/' class='grSearchtxt'><b>Login</b></a>";
				}
			?>
			</td>
	</tr>
</table><br><br>
<?php }//if ?>
<!--DISPLAY FILTER SETTINGS ENDS HERE-->

<!--DISPLAY DISABLED STARTS HERE-->
<?php if ($varPublish==2 && (($sessMatriId != $varMatriId) ||$sessMatriId == "")) {$varFilterMatchedProfile = "no"; ?><br>
	<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594">
		<tr><td valign="top" colspan="4" class="viewheading"></td></tr>
		<tr bgcolor="#FFFFFF">
			<td valign="top" class="smalltxt" align="center" height="25" style="padding-top:5px;padding-left:5px;padding-bottom:3px;">Username <?=$varUsername?> is hidden and cannot be viewed by others.</td>
		</tr>
	</table><br><br>
<?php }//if?>
<!--DISPLAY DISABLED ENDS HERE-->

<!--View Similar Profiles form starts here-->
<form name="frmViewSimilarProfiles" action="facebook-search-results.php" target="_blank" method="post" onSubmit="return false;" style="display:none">
<input type="hidden" name="act" value="star-search-results">
<input type="hidden" name="starSearch" value="yes">
<input type="hidden" name="displayFormat" value="B">
<input type="hidden" name="gender" value="<?=$varMemberInfo['Gender'];?>">
<input type="hidden" name="religion" value="<?=$varMemberInfo['Religion'];?>">
<input type="hidden" name="caste" value="<?=$varMemberInfo['Subcaste'];?>">
<input type="hidden" name="star">
<input type="hidden" name="city" value="<?=$varResidingStateId;?>">
<input type="hidden" name="viewSimilarMatriId" value="<?=$varMatriId;?>">
<input type="hidden" name="paidStatus" value="<?=$sessPaidStatus;?>">
<input type="hidden" name="page" value="1">
<input type="hidden" name="sessGender" value="<?=$sessGender;?>">
</form>
<form name="frmInterestReceived" method="post" style="display:none">
<input type="hidden" name="messageIds" value="">
</form>
<form name="frmSendReminder" method="post" style="display:none">
<input type="hidden" name="matriIds" value="">
</form>

<!--View Similar Profiles form ends here-->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="grtxtbold1" bgcolor="#FFFFFF">
			<?php if (($varPublish==1 || $sessMatriId == $varMatriId) && $varFilterMatchedProfile !="no") { ?>

<!-- START OF DISPLAY FOR ENGLISH VIEW PROFILE -->
<div style="text-align: right;">
<table border="0" cellpadding="0" cellspacing="0" width="594" align="center"><tbody><tr><td align="right" valign="top"><div style="position: relative; top: 27px; left: 5px; z-index: 1; padding-right: 15px;"><img src="../images/view-options-arrow.gif" align="absmiddle" border="0" height="5" hspace="5" width="5"><a href="javascript:void(0);" onclick="javascript:funForwardProfileFace('<?=$varMatriId;?>'); return false;" class="grsearchtxt" style="text-decoration: none;" target="_blank">Forward Profile</a>&nbsp;&nbsp;&nbsp;<img src="../images/viewprofileicon.gif" align="absmiddle" border="0" height="12" hspace="3" width="11"><a href="<?=$confValues['ServerURL']?>/print/<?=$varMatriId;?>/" class="grsearchtxt" style="text-decoration: none;" target="_blank">Print profile</a>&nbsp;</div></td></tr></tbody></table>
</div>
<!-- Start of My Profile -->
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td valign="bottom"><img src="../images/meminfo-leftcurve.gif" height="21" width="38"></td>
			<td valign="bottom"><img src="../images/meminfo-icontxt.gif" height="49" width="134"></td>
			<td valign="bottom"><img src="../images/meminfo-toptile.gif" height="21" width="405"></td>

			<td valign="bottom"><img src="../images/meminfo-rightcurve.gif" height="22" width="17"></td>
	</tr>
</tbody></table>
<!-- Start of 150 x 150 Thumbnail Photo Display -->

<table border="0" cellpadding="0" cellspacing="0" width="594" align="center">
	<tbody><tr>
			<td bgcolor="#E8EBC9" valign="top" width="4"><img src="../images/trans.gif" height="1" width="4"></td>
			<td bgcolor="#ffffff" valign="top" width="577">
				<table border="0" cellpadding="0" cellspacing="0" width="577">
					<tbody><tr>

						<td bgcolor="#F7F9E3" valign="top" width="168">
								<div style="background-color: rgb(247, 248, 232); width: 181px; float: left; padding-top: 2px; text-align: center;">
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="181">
								<tbody><tr>
									<td align="center" valign="top">
									<div style="padding-top: 5px;">
									<a href="<?=$varFileName;?>" GALLERYIMG="no" oncontextmenu="return false"><img border="0"
									src="<?=$varPhotoName;?>"  width="150" height="150" vspace="2" hspace="2" id="id<?=$varMatriId;?>"><!-- </a> --></a>
									<?
									echo isset($funPhotoPaging)?$funPhotoPaging:''; ?></a>
									</div>
																		
									<div style="padding-bottom: 5px;" class="smalltxt">
									<?php
								$funFileStatus = $objProductFacebook->getOnlinetime($varMatriId);
								if ($funFileStatus =='yes' && $sessMatriId != $varMatriId)
								{
									if ($sessPaidStatus==0 && $sessMatriId!='')
									{
										?>
										<b><a href="<?=$confValues['ServerURL']?>/payment/id=<?=$varMatriId?>/"><font color="#000000">Online</font></a></b>
									<?php 
									}//if
									elseif($sessMatriId=='') {
									?>
									<b><a href="<?=$confValues['ServerURL'];?>/profiles/<?=$varMatriId?>/payment/"><font color="#000000">Online</font></a></b>
									<?php
									}
									else
									{?>
										<b><a href="javascript:openindex();"><font color="#000000">Online</font></a></b>
									<?php }
									echo '<br>';
								}
								if (isset($varMyListInfo) && $varMyListInfo !="") { ?>
									<?=$varMyListInfo?>
							    <?php }//if?>
								</div></div>

									</td>
									</tr>
								</tbody></table>
							<div>
						</div></div></td>

<td bgcolor="#ffffff" valign="top" width="396">

<table style="float: left;" border="0" cellpadding="0" cellspacing="0" width="396">
<tbody><tr>
	<td valign="top">

		<div style="padding-left: 20px; padding-top: 8px; text-align: justify;" class="smalltxt">
			<div style="padding-top: 1px;">UserName: <font color="#007A00"><b><?=$varLoginInfo["User_Name"]//$varLoginInfo['MatriId']?></b></font></div>
			<div style="padding-top: 9px;"><?=$varMemberInfo['Gender']==1 ? "Male" : "Female"?> - <?=$varArrGenderList[$varMemberInfo['Marital_Status']];?></div>
			<div style="padding-top: 8px;">Profile created by: <?=$varArrProfileCreatedByList[$varMemberInfo['Profile_Created_By']];?></div>
			<div style="padding-top: 8px;">Last Login: <b><?=$objProductFacebook->getDateMothYear('d-M-Y',$varLastLogin);?></b></div>
			<?php if(($sessPaidStatus==1)&&($sessMatriId == $varMatriId)) { ?>
			<div style="padding-top: 8px;">Valid Days:: <?=$varRemainingDays;?></div>
			<?}?>
		</div>

	</td>
	<td valign="top"><div style="padding-left: 15px; text-align: left;" class="smalltxt">
	<?php if ($sessMatriId != $varMatriId && $sessGender != $varGender) { ?>
<!-- Send Mail -->
	<div style="padding-top: 8px; text-align: left;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle">
	<a href="
	<?php 
	if($sessMatriId=="" && $sessPaidStatus==0) 
	{ 
		echo $confValues['ServerURL']."/profiles/".$varMatriId."/contact/"; 
	}
	else if($sessMatriId!= "" && $sessPaidStatus==0) {  echo $varDisplayLink; }//else if			
	else if ( $sessPaidStatus==1) {  echo "javascript: funContct('".$varMatriId."')"; } 
	?> 
	" class="grsearchtxt" target="_blank">Send Mail<?=$sessPaidStatus==1 ?  "" : " - Paid"?></a></div>
<!-- Send Mail -->
	<?php if ($sessPaidStatus==0) { ?>
<!-- Send Salaam -->
	<div style="padding-top: 8px; text-align: left;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle">
	<a href="<?php if ($sessMatriId !="") { echo "javascript:showInterest('".$varMatriId."');"; }else { echo $confValues['ServerURL']."/profiles/".$varMatriId."/send-a-salaam/"; }?>"  class="grsearchtxt"  target="_blank">Send a Salaam - FREE</a></div>
<!-- Send Salaam -->
	<?php }//if?>

<!-- Add to Favorites -->	
	<div style="padding-top: 8px; text-align: left;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle"><?php if($sessMatriId== "") { ?><a href="<?=$confValues['ServerURL'];?>/profiles/<?=$varMatriId?>/favorite/" class="grsearchtxt">
	<?php } else { ?> <a href="javascript:void(0);"  target="_blank"  onClick="javascript:myList('<?=$confValues[ServerURL]?>/my-list/bookmark-add.php?bookMarkId=<?=$varMatriId;?>'); return false;" class="grsearchtxt"><?php } ?>Add to Favorites</a></div>
<!-- Add to Favorites -->	
<!-- Ignore this Profile -->	
	<div style="padding-top: 8px; text-align: left;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle"><?php if($sessMatriId== "") { ?><a href="<?=$confValues['ServerURL'];?>/profiles/<?=$varMatriId?>/Ignore/" class="grsearchtxt">
	<?php } else { ?> <a href="javascript:void(0);"  target="_blank"  onClick="javascript:myList('<?=$confValues[ServerURL]?>/my-list/ignore-add.php?ignoreId=<?=$varMatriId;?>'); return false;" class="grsearchtxt"><?php } ?>Ignore this Profile</a></div>
<!-- Ignore this Profile -->	
<!-- Block this Profile -->	
	<div style="padding-top: 8px; text-align: left;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle"><?php if($sessMatriId== "") { ?><a href="<?=$confValues['ServerURL'];?>/profiles/<?=$varMatriId?>/block/" class="grsearchtxt">
	<?php } else { ?> <a href="javascript:void(0);"  target="_blank"  onClick="javascript:blockMember('<?=$confValues[ServerURL]?>/my-list/block-add.php?blockId=<?=$varMatriId; ?>'); return false;" class="grsearchtxt"><?php } ?>Block this Profile</a></div>
<!-- Block this Profile -->	

	</div>
	<? }//if ?>
</td>
</tr>
</tbody></table>

<table style="float: left;" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="396">
<tbody><tr>
<td valign="top">
	<div style="float: left; padding-top: 5px; padding-bottom: 5px; padding-left: 17px;">

		</div>
</td>
</tr>
<tr>
	<td valign="top">
		<div style="float: left; padding-top: 2px; padding-bottom: 2px; padding-left: 19px;"><img src="../images/trans.gif" height="5" width="1"></div>
	</td>
</tr>
</tbody></table>
<? if( $sessMatriId != $varMatriId ){ ?>
<table style="float: left;" border="0" cellpadding="0" cellspacing="0" width="405">
		<tbody><tr><td bgcolor="#ffffff" valign="top"><div style="padding-top: 1px;"><img src="../images/trans.gif" alt="" height="20" hspace="5" width="16"></div></td></tr>

		<tr><td bgcolor="#cbe5a2" valign="top"><img src="../images/trans.gif" height="3" width="1"></td></tr>
		<tr><td style="padding-left: 1px; padding-top: 5px;" valign="top">
		<img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle"><a href="javascript:funViewSimilarProfiles();" class="grsearchtxt">View similar profiles</a>
		</td></tr>

</tbody></table>
<?php } ?>
</td></tr></tbody></table> 


						</td>
			<td bgcolor="#E8EBC9" valign="top" width="4"><img src="../images/trans.gif" height="1" width="4"></td>
	</tr>
</tbody></table>


<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td valign="bottom"><img src="../images/meminfo-botcurve.gif" height="11" width="16"></td>
			<td valign="bottom"><img src="../images/meminfo-bottile1.gif" height="11" width="169"></td>

			<td valign="bottom"><img src="../images/meminfo-bottile2.gif" height="11" width="398"></td>
			<td valign="bottom"><img src="../images/meminfo-botcurve1.gif" height="11" width="11"></td>
	</tr>
</tbody></table>
			
			<br>
			<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tbody><tr><td>
			<?php if ($sessMatriId != $varMatriId && $sessGender != $varGender) { ?>
			<!-- 3rd Table starts here-->
			<? if ($sessMatriId == "") { ?>
			<div style="padding:5px 0px 5px 10px;width:580px !important;width:592px;background-color: rgb(247, 248, 232);border: 1px solid #8FCD62;" class="smalltxt"><b>Register Free</b><br>
			<div class="smalltxt" style="border: 1px solid #C3E07B; width:97%;background-color:#FFFFFF;padding:5px 0px 8px 20px;font-style: normal; text-transform: none; color: #000000;text-align:left;margin-top:5px;"><a href="<?=$confValues['ServerURL'];?>/register/" class="grsearchtxt"  target="_blank">Register FREE</a> to contact this member</div><br></div><br>
			<? }//if ?>

			<!-- 3rd Table starts here-->
			<? if ($varLastActionCnt==0 && $sessMatriId !="" && $sessMatriId !=$varMatriId) { ?>
			<div style="padding:5px 0px 5px 10px;width:580px !important;width:592px;background-color: rgb(247, 248, 232);border: 1px solid #8FCD62;" class="smalltxt"><b>Register Free</b><br>
			<div class="smalltxt" style="border: 1px solid #C3E07B; width:97%;background-color:#FFFFFF;padding-top:5px;padding-bottom:5px;font-style: normal; text-transform: none; color: #000000;text-align:center;margin-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<td valign="middle"><p style="padding-left: 5px; padding-top: 0px; padding-bottom: 5px;"><font class="smalltxt">Interested in this member?</font></p></td><td align="right" valign="middle">
			<? if($sessPaidStatus==0) { ?>
			<a href="javascript:showInterest('<?=$varMatriId;?>');"><img src="../images/sendsalaam-button.gif"style="cursor:hand;cursor:pointer;" border="0"></a>&nbsp;&nbsp;
			<? } if($sessPaidStatus==1) { ?>
				<a href="javascript:funContct('<?=$varMatriId;?>');"><img src="../images/contact.gif"style="cursor:hand;cursor:pointer;" border="0" valign="absmiddle"></a>&nbsp;&nbsp;
			<? } ?></td></tr>
			<? if($sessPaidStatus==0) { ?>
			<tr><td colspan="2" valign="middle"><p style="padding-left: 5px; padding-top: 0px; padding-bottom: 5px;"><a href="<?=$confValues['ServerURL'];?>/payment/" class="grsearchtxt"  target="_blank"><p style="padding-left: 5px; padding-top: 0px; padding-bottom: 5px;">Become a paid member</a><font class="smalltxt"> to send personalized messages, which gets better responses.</font></p></td></tr>
			<? } ?>
			</table></div></div>
			<? }//if ?>
			<? if ($varLastActionCnt==1 && $sessMatriId !="") { ?>
			<div style="padding-bottom: 5px; padding-top: 8px;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle"><font class="smalltxt">&nbsp;Below is the last action between this member and you. Click</font> <a href="javascript:funProfileHistory('<?=$varMatriId;?>');" class="grsearchtxt">Contact Summary</a><font class="smalltxt"> for the entire history.</font></div>

			<table style="border: 1px solid #C3E07B;background-color: rgb(239, 247, 227);width:592px !important;width:592px;" cellpadding="0" cellspacing="0">
			<tbody><tr><td colspan="3" height="20" valign="top" width="100%">
			<table border="0" cellpadding="0" cellspacing="0" height="20" width="100%">
			<tbody><tr>
			<td nowrap="nowrap" valign="top"><font style="font-family: verdana; font-size: 11px; font-weight: bold;">&nbsp;<?= $varMessageHead; ?></font></td>
			<td style="padding-right: 5px;" align="right" valign="top"><font style="font-family: verdana; font-size: 10px;"><img src="../images/view-options-arrow.gif" width="5" height="5" hspace="5" align="absmiddle"> <?= $varMessageDate; ?></font></td>
			</tr>
			</tbody></table>
			</td></tr>
			<tr><td valign="top" width="5"></td>
			<td align="center" valign="top" width="100%">
				<table style="border: 1px solid #C3E07B;" align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="98%">
				<tbody><tr><td valign="top"><div style="width: 100%; height: 100px;"><div style="overflow: auto; height: 95px; padding-left: 5px; padding-right: 5px; padding-top: 5px;"><font style="font-family: verdana; font-size: 11px;"><b>Member's message :</b><br><br><div style='height:100;' class='normaltxt1'><?= $varMessageContent; ?></div></font></div></div></td></tr>
				<tr><td valign="top" width="100%">
						<table align="center" style="background-color: rgb(239, 247, 227);" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
						<? if($varMessageButton=='yes') { ?>
						<tr>
						<td colspan="2" valign="top" align="right" style="padding:5px 0px 5px 0px;background:#ffffff;border-top:1px solid #C3E07B;">
							<a href="javascript: funReply('<?=$varLastActionInfo["Mail_Id_Received"];?>');" class="grtxt"><img src="../images/reply.gif"style="cursor:hand;cursor:pointer;" border="0"></a>&nbsp;&nbsp;<a href="javascript: funDeclineMessage('<?=$varLastActionInfo["Mail_Id_Received"];?>');"><img src="../images/decline-button.gif"style="cursor:hand;cursor:pointer;" border="0"></a>&nbsp;&nbsp;
						</td>
						</tr>
						<? } ?>
						<? if($varInterestButton=='yes' && $varLastActionInfo["Interest_Received_Status"]==0) { ?>
						<tr>
						<td colspan="2" valign="top" align="right">
							<a href="javascript: funInterestAccept('<?=$varLastActionInfo["Interest_Id_Received"];?>');" class="grtxt"><img src="../images/accept-button.gif"style="cursor:hand;cursor:pointer;" border="0"></a>&nbsp;&nbsp;<a href="javascript: funInterestDecline('<?=$varLastActionInfo["Interest_Id_Received"];?>');"><img src="../images/decline-button.gif"style="cursor:hand;cursor:pointer;" border="0"></a>&nbsp;&nbsp;
						</td>
						</tr>
						<? } ?>
						<? if($varRemainderButton=='yes' && $varLastActionInfo["Interest_Sent_Status"]==0) { ?>
						<tr>
						<td colspan="2" valign="top" align="right">
							<a href="javascript: funSendReminderPopup('<?=$varLastActionInfo["Interest_Id_Sent"];?>');" class="grtxt"><img src="../images/sendareminder-button.gif"style="cursor:hand;cursor:pointer;" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						</tr>
						<? } ?>

						<?php if($varMessageButton=='yes' && $sessPaidStatus==0) { ?>
						<tr><td colspan="2" valign="top"><p style="padding-left: 5px; padding-top: 0px; padding-bottom: 5px;"><font class="smalltxt">Did you know that personalized messages will get you more positive responses? <br><a href="<?=$confValues['ServerURL'];?>/payment/" class="grsearchtxt"  target="_blank"> Become a paid member now.</a></font></p></td></tr>
						<? } ?>
						</tbody></table>
				</td></tr>
				<tr><td height="3" valign="top"></td></tr>
				</tbody></table>
			</td>
			<td valign="top" width="5"></td>
			</tr>
			<tr><td colspan="3" height="10" valign="top"></td></tr>
			</tbody></table>
			</td></tr></table>
			<!-- Inbox view div tag -->
			<?php } ?>
			<? }//if ?>
			<!--DISPLAY MAIL SECTION STARTS HERE-->
			<br><br>
			<?php } ?>
			<!--DISPLAY MAIL SECTION ENDS HERE-->
<?php if($varFilterMatchedProfile == "yes"){ ?>
<!-- BASIC INFORMATION STARTS HERE-->
			<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594"  align="center">
				<tr class="viewbgclr">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">
					<div style="float: left;" class="viewheading">Basic Information</div>
					<? if( $sessMatriId == $varMatriId ){ ?>
					<div style="float: right; margin-right: 5px;"><a href="<?=$confValues['ServerURL'];?>/register/edit-basic/" class="grsearchtxt" target="_blank">Edit</a></div>
					<? } ?>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Name:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
						<?=($varMemberInfo['Name']!="")? $varMemberInfo['Name'] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Age:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
						<?=$varMemberInfo['Age'] ? $varMemberInfo['Age'] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sect :</td>
					<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Religion'] ? $varArrReligionList[$varMemberInfo['Religion']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Division:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?	if(array_key_exists($varMemberInfo['Subcaste'],$varArrCasteDivisionList))
							{
								print $varArrCasteDivisionList[$varMemberInfo['Subcaste']];
							}
							else
							{
								$varDivision = $varMemberInfo['Subcaste']!="" ? $varMemberInfo['Subcaste']: "-";
								print $varDivision;
							}
						?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Citizenship :</td>
					<td valign="top" width="165" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Citizenship'] ? $varArrCountryList[$varMemberInfo['Citizenship']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Country living in :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varCountry ? $varArrCountryList[$varCountry] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC">
					<td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top"  class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident status :</td>
					<td valign="top"  class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Resident_Status'] ? $varArrResidentStatusList[$varMemberInfo['Resident_Status']] : "-";?>
					</td>
					<?php if($varMemberInfo['Marital_Status']!=1) { ?>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Children:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['No_Of_Children'] ? $varMemberInfo['No_Of_Children'] : "No";?>
					</td>
					<? } else {?>
					<td colspan="2">&nbsp;</td>
					<? } ?>
				</tr>
				<?php if($varMemberInfo['Marital_Status']!=1) { ?>
				<tr bgcolor="#D1E7EC">
					<td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top"  class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Children living status :</td>
					<td valign="top"  class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?php 
							if ($varMemberInfo['Children_Living_Status'] == 1 && $varMemberInfo['No_Of_Children'] !="0") { echo "Not living with me"; }
							else{
								if ($varMemberInfo['No_Of_Children'] !="0"){ echo 'Living with me'; }//if
								else { echo '-'; };//else
								}
						?>
					</td>
				</tr>
				<? } ?>
			</table><br>
<!-- BASIC INFORMATION STARTS HERE-->
			<!-- About myself Information starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594"  align="center">
				<tr class="viewbgclr"><td valign="top" style="padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;text-align:justify;">
					<div style="float: left;" class="viewheading">About myself</div>
					<? if( $sessMatriId == $varMatriId ){ ?>
					<div style="float: right; margin-right: 5px;"><a href="<?=$confValues['ServerURL'];?>/register/edit-basic/" class="grsearchtxt" target="_blank">Edit</a></div>
					<? } ?>
				</td></tr>
				<tr bgcolor="#FFFFFF">
				   <td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
						<?=$varMemberInfo['About_Myself'] ? str_replace("''","'",$varMemberInfo['About_Myself']) : "-";?>
				   </td>
				</tr>
			</table><br>
			<!-- About myself Information ends here -->
			<!-- My Appearance starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594"  align="center">
				<tr class="viewbgclr">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">
					<div style="float: left;" class="viewheading">My Appearance</div>
					<? if( $sessMatriId == $varMatriId ){ ?>
					<div style="float: right; margin-right: 5px;"><a href="<?=$confValues['ServerURL'];?>/register/edit-basic/" class="grsearchtxt" target="_blank">Edit</a></div>
					<? } ?>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Complexion:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
						<?=$varMemberInfo['Complexion']!="0" ? $varArrComplexionList[$varMemberInfo['Complexion']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Physical status:</td>
					<td valign="top" width="200" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
						<?=$varMemberInfo['Physical_Status'] ? $varArrPhysicalStatusList[$varMemberInfo['Physical_Status']] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?= $varHeight?$varHeight:'-'; ?></td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Weight :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Weight']!=0 ? str_replace(".00","",$varMemberInfo['Weight'])." ".$varMemberInfo['Weight_Unit'] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Body type :</span></td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Body_Type']!="0" ? $varArrBodyTypeList[$varMemberInfo['Body_Type']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Blood group :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=($varMemberInfo['Blood_Group']!="0")? $varArrBloodGroupList[$varMemberInfo['Blood_Group']] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Hair color : </span></td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Hair_Color']!="0" ? $varArrHairColorList[$varMemberInfo['Hair_Color']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eye color :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Eye_Color']!="0"? $varArrEyeColorList[$varMemberInfo['Eye_Color']] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Eating_Habits'] ? $varArrPartnerFoodList[$varMemberInfo['Eating_Habits']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Drink'] ? $varArrPartnerDrinkingList[$varMemberInfo['Drink']] : "-";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" colspan="3">
						<?=$varMemberInfo['Smoke'] ? $varArrPartnerSmokingList[$varMemberInfo['Smoke']] : "-";?>
					</td>
				</tr>
			</table><br>
			<!-- My Appearance ends here -->
			<!-- My LifeStyle starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594" align="center">
				<tr class="viewbgclr">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">
					<div style="float: left;" class="viewheading">My LifeStyle</div>
					<? if( $sessMatriId == $varMatriId ){ ?>
					<div style="float: right; margin-right: 5px;"><a href="<?=$confValues['ServerURL'];?>/register/edit-occupational/" class="grsearchtxt" target="_blank">Edit</a></div>
					<? } ?>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Education :</td>
					<td valign="top" class="smalltxt" width="25%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varMemberInfo['Education_Category']!=10 ? $varArrEducationCategoryList[$varMemberInfo['Education_Category']] : "Not specified";?>
					</td>
					<td valign="top" width="25%" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education in detail :</td>
					<td valign="top" class="smalltxt" width="25%" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?
						if($varMemberInfo['Education_Detail']!='')
							echo wordwrap($varMemberInfo['Education_Detail'], 20, "<br>");
						else
						 echo "-";
					?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Employed in :</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Employed_In'] ? $varArrEmployedInList[$varMemberInfo['Employed_In']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=($varMemberInfo['Occupation']!="0" && $varMemberInfo['Occupation']!="60")? ltrim($varArrOccupationList[$varMemberInfo['Occupation']],'&nbsp;&nbsp;') : "Not specified";?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Occupation in detail :</td>
					<td valign="top" class="smalltxt"  style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?
						if($varMemberInfo['Occupation_Detail']!='')
							echo wordwrap($varMemberInfo['Occupation_Detail'], 20, "<br>");
						else
						 echo "-";
					?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Annual Income :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Annual_Income'] !="0.00" ? $varArrCurrencyList[$varMemberInfo['Income_Currency']].' '.$varMemberInfo['Annual_Income'] : "-";?>
					</td>
				</tr>
			</table><br>
			<!-- My LifeStyle ends here -->			
			<!-- Home Truths starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594" align="center">
				<tr class="viewbgclr">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">
					<div style="float: left;" class="viewheading">Home Truths</div>
					<? if( $sessMatriId == $varMatriId ){ ?>
					<div style="float: right; margin-right: 5px;"><a href="<?=$confValues['ServerURL'];?>/register/edit-locationdetails/" class="grsearchtxt" target="_blank">Edit</a></div>
					<? } ?>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" width="25%" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Family values :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varArrFamilyValuesList[$varFamilyInfo['Family_Value']]? $varArrFamilyValuesList[$varFamilyInfo['Family_Value']] : "-";?></td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="25%">Religious Values</span>:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="25%">
					<?=$varArrReligiousList[$varMemberInfo['Religious_Values']]? $varArrReligiousList[$varMemberInfo['Religious_Values']] : "-";?></td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing state :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varResidingState ? $varResidingState : "-"; ?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Residing city / district :</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?php
						if ($varCountry==98 && $varMemberInfo['Residing_City'] !="" )
						{
							echo '<span id="residingAreaId"></span>';
							echo '<script language="javascript">';
							echo 'var cityArrayList	= residingcity['.$varStateID.'];';
							echo "funResidingArea(cityArrayList,'".$varMemberInfo['Residing_City']."');";
							echo '</script>';
						}//if
						else
						{ echo $varMemberInfo['Residing_City'] ? $varMemberInfo['Residing_City'] : "-"; }//else
					?>
					</td>
				</tr>
				<tr bgcolor="#D1E7EC">
					<td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td>
				</tr>
				<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="4"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Native language:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=($varMemberInfo['Mother_Tongue']!="0")? $varArrMotherTongueList[$varMemberInfo['Mother_Tongue']] : "-";?>
					</td>
					<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Ethnicity:</td>
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
						<?=$varMemberInfo['Ethnicity']!="0"? $varArrEthnicityList[$varMemberInfo['Ethnicity']] : "-";?>
					</td>
				</tr>
			</table>
			<!--Home Truths ends here-->
			<!-- Partner Preference Specifications starts here -->
			<table border="0" cellpadding="0" cellspacing="0" class="viewpgborderclr" width="594" align="center">
				<tr class="viewbgclr">
					<td valign="top" colspan="4" style="padding-left:5px;padding-top:5px;padding-right:1px;padding-bottom:5px;">
					<div style="float: left;" class="viewheading">My Partner Preference</div>
					<? if( $sessMatriId == $varMatriId ){ ?>
					<div style="float: right; margin-right: 5px;"><a href="<?=$confValues['ServerURL'];?>/register/edit-partner/" class="grsearchtxt" target="_blank">Edit</a></div>
					<? } ?>
					</td>
				</tr>
			<?php if ($varPartnerSetStatus == 0) { ?>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">Partner Preference not set by the member</td>
				</tr>
			<br> <? } else { ?> <br>
			<!-- Start of Primary Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;" width="35%">Looking for :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;" width="65%">
				<?=$varLookingStatus ? $objProductFacebook->displaySelectedValuesFromArray($varArrGenderList,$varLookingStatus) : "Any";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Age :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					Between <?=$varAgeFrom ? $varAgeFrom : "-";?> and <?=$varAgeTo ? $varAgeTo : "-";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Height :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?= $varHeightFrom?$varPartnerHeightFrom : "-";?> <b>to</b> <?= $varHeightTo?$varPartnerHeightTo : "-";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Physical status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Physical_Status'] ? $varArrPhysicalStatusList[$varPartnerInfo['Physical_Status']] : "-";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Native language:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Mother_Tongue'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrMotherTongueList,$varPartnerInfo['Mother_Tongue']) : "Any";
				?>
				</td>
			</tr>
			<!-- End of Primary Preference -->
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Socio-Religious Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Sect :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Religion'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrReligionList,$varPartnerInfo['Religion']) : "Any";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Division :</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
			<?=$varPartnerInfo['Caste_Or_Division'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrCasteDivisionList,$varPartnerInfo['Caste_Or_Division']) : "Caste No Bar";?>
			</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Eating habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Eating_Habits']!="")? $varArrPartnerFoodList[$varPartnerInfo['Eating_Habits']] : "-";?>
			</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Drinking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Drinking_Habits']!="")? $varArrPartnerDrinkingList[$varPartnerInfo['Drinking_Habits']] : "-";?>
			</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Smoking habits:</td>
			<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=($varPartnerInfo['Smoking_Habits']!="")? $varArrPartnerSmokingList[$varPartnerInfo['Smoking_Habits']] : "-";?>
			</td>
			</tr>
			<!-- End of Socio-Religious Preference -->
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of Educational Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Education:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Education'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrPartnerEducationList,$varPartnerInfo['Education']) : "Any";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<!-- End of Educational Preference -->
			<!-- Start of Location Preference -->
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Citizenship:</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Citizenship'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrCountryList,$varPartnerInfo['Citizenship']) : "Any";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Country living in :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
					<?=$varPartnerInfo['Country'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrCountryList,$varPartnerInfo['Country']) : "Any";?>
				</td>
			</tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<tr bgcolor="#FFFFFF">
				<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">Resident status :</td>
				<td valign="top" class="smalltxt" style="padding-top:5px;padding-left:0px;padding-bottom:3px;">
				<?=$varPartnerInfo['Resident_Status'] ? $objProductFacebook->displaySelectedValuesFromArray($varArrResidentStatusList,$varPartnerInfo['Resident_Status']) : "Any";?>
				</td>
			</tr>
			<!-- End of Location Preference -->
			<tr bgcolor="#D1E7EC"><td width="10" valign="top" height="1" colspan="2"><img src="../images/trans.gif" width="100%" height="1"></td></tr>
			<!-- Start of About my partner -->
			<tr bgcolor="#FFFFFF">
			<td valign="top" class="grtxt2" style="padding-top:5px;padding-left:10px;padding-bottom:3px;">About my partner :</td>
			<td valign="top" class="smalltxt"  style="padding-top:5px;padding-right:10px;padding-bottom:10px;line-height:15px;text-align:justify;">
				<?=$varPartnerInfo['Partner_Description'] ? $varPartnerInfo['Partner_Description'] : "-";?>
			</td>
			</tr>
			<!-- End of About my partner -->
			<? } ?>
			</table><br>
	<!-- Partner Preference Specifications ends here -->
	<?php
	 }//if
	 if ($sessMatriId == "")
	 {
		 ?>
			<div style="padding-bottom:5px;"></div>
			<div class="smalltxt" style="border: 1px solid #C3E07B; width:594px;background-color:#FFFFFF;padding-top:5px;padding-bottom:5px;font-style: normal; text-transform: none; color: #000000;text-align:center;"><font class="smalltxt">Not a member?&nbsp;<a href="<?=$confValues['ServerURL'];?>/register/" class="grsearchtxt" target="_blank">Register FREE</a> to contact this member</div><br>
	<?
	 }//if
	?>
	</td></tr>
<tr><td height="10"><img src="../images/trans.gif"></td></tr>
</table>
<?
 }//if
 else
 {
?>
<table width="594" align="left">
	<tr>
		<td valign="top" class="smalltxt" align="center"><br><br><br>
		<?php
			$varInvalidInput = 'no';
			$varUsername = $varUsername ? $varUsername : $varMatriId;
			$funRgExpPat = "/^[a-zA-Z][a-zA-Z0-9_.]{4,18}[a-zA-Z0-9]$/";
			if(!preg_match($funRgExpPat , $varUsername)) { $varInvalidInput ='yes'; }
			if($varCheckProfileId==0)
			{
				//Matrimony Id $varUsername has been deleted or does not exist.

				if ($sessMatriId !="")
				{
					if ($varInvalidInput=='yes') { echo 'Invalid Input.'; }//if
					else { echo "Username ".$varUsername." has been deleted or does not exist."; }
				}
				else{echo "<script language=\"javascript\">window.location.href='".$confValues['ServerURL']."/register/error-landing/'</script>"; exit; }
			}
			else if ($varPublish==0)
			{ echo 'Username <b>'.$varUsername.'</b> is not yet authorized'; }//if
			else if ($varPublish==2) {  echo 'Username <b>'.$varUsername.'</b> is Hidden'; }
			else if ($varPublish==3) {  echo 'Username <b>'.$varUsername.'</b> has been suspended'; }
			else { echo 'Username <b>'.$varUsername.'</b> has been deleted or does not exist.';}//else
		?>
		</td>
	</tr>
</table>
<?	
 }
?>
