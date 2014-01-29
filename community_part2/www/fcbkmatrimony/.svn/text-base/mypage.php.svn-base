<?php
#=============================================================================================================
# Author 		: S Rohini
# Start Date	: 2007-08-04
# End Date		: 2007-08-04
# Project		: MatrimonyProduct
# Module		: Facebook My page
#=============================================================================================================
//FILE INCLUDES
require_once('header.php');
require_once('navinc.php');

if($sessMatriId == ""){ echo '<script language="javascript">document.location.href="index.php"</script>'; }//if

//OBJECT DECLARTION
$objProductFacebook			= new QuickSearch;

//VARIABLE DECLARATION
$varSenderStatus							= $_REQUEST["senderstatus"];
$varReceiverStatus							= $_REQUEST["receiverstatus"];
$objProductFacebook->clsPaidStatus			= $sessPaidStatus;
$objProductFacebook->clsSessionMatriId		= $sessMatriId;
$objProductFacebook->clsPrimary				= array('MatriId');
$objProductFacebook->clsCountField			= "MatriId";
$objProductFacebook->clsPrimaryValue		= array($sessMatriId);
$objProductFacebook->clsDisplayFormat		= 'T'; // display format
if ($sessLastLogin !="0000-00-00 00:00:00") { $sessLastLogin = date("d-M-Y",strtotime($sessLastLogin)); }//if

//MEMBERSHIP OFFER CODE STARTS HERE (*ND 20070130)
$varProvideOffer	= 'no';
if ($sessPaidStatus==0)
{
	$varTotalOfferCount						= 10;
	$objProductFacebook->clsTable			= "memberofferinfo";
	$objProductFacebook->clsFields			= array('Contact_Count');
	$varSelectOfferInfo						= $objProductFacebook->selectListSearchResult();
	$varContactedCount						= $varSelectOfferInfo["Contact_Count"];
	$varRemainingCount						= ($varTotalOfferCount - $varContactedCount);
	if ($varContactedCount !="" && $varContactedCount < 10) { $varProvideOffer = 'yes'; }//if
}//if
//MEMBERSHIP OFFER CODE STARTS HERE

$objProductFacebook->clsTable				= "memberinfo";
$objProductFacebook->clsFields				= array('Name','Date_Updated','Profile_Viewed','Photo_Set_Status','Partner_Set_Status','Date_Created');
$varSelectMemberInfo						= $objProductFacebook->selectListSearchResult();
$varDateUpdated								= $varSelectMemberInfo["Date_Updated"];
$varDateCreated								= $varSelectMemberInfo["Date_Created"];
$varPhotoSetStatus							= $varSelectMemberInfo["Photo_Set_Status"];
$varPartnerSetStatus						= $varSelectMemberInfo["Partner_Set_Status"];

if ($varDateUpdated != $varDateCreated) { $varLastEditedDate = date("d-M-Y", strtotime($varDateUpdated)); }//if
if ($varDateCreated !="0000-00-00 00:00:00") { $varCreatedDate	  = date("d-M-Y", strtotime($varDateCreated)); }//if

//Calculate Valid days for Paid members
if($sessPaidStatus==1)
{
	$objProductFacebook->clsTable			= "memberlogininfo";
	$objProductFacebook->clsFields			= array('Valid_Days','Date_Paid');
	$varLoginInfo							= $objProductFacebook->selectListSearchResult();
	$varPaidDate							= $varLoginInfo["Date_Paid"];
	//Calculate Valid days for Paid members
	$varTodayDate							= date('m-d-Y');
	$varPaidDate							= date('m-d-Y',strtotime($varPaidDate));
	$varNumOfDays							= $objProductFacebook->dateDiff("-",$varTodayDate,$varPaidDate);
	$varRemainingDays						= $varLoginInfo["Valid_Days"]- $varNumOfDays;
}//if


//Get photo info from memberbasicinfo 
$objProductFacebook->clsTable				= "memberphotoinfo";
$objProductFacebook->clsFields				= array('Normal_Photo1','Photo_Status1');
$varSelectPersonalImage						= $objProductFacebook->selectListSearchResult();
$varPhotoName								= $varSelectPersonalImage['Normal_Photo1'];
$varPhotoStatus								= $varSelectPersonalImage['Photo_Status1'];
$varPhotoInfo								= 1;

if($varPhotoStatus == '')
{
	$varPhotoInfo							= 0;
	$varImageFileName						= '/membersphoto/addphotoimg-75x75.gif'; 
}
else
{
	$varFolderName							= ($varPhotoStatus != 1) ? '/pending-photos/':'/membersphoto/'.$sessMatriId{1}.'/'.$sessMatriId{2}.'/'; 								
	$varImageFileName	= $varFolderName.$varPhotoName;
		
}//else


#Getting Received Interest & Mail count Info
$objProductFacebook->clsTable				= "memberstatistics";
$objProductFacebook->clsPrimary				= array('MatriId');
$objProductFacebook->clsPrimaryValue		= array($sessMatriId);
$objProductFacebook->clsFields				= array('Interest_Pending_Sent','Interest_Accept_Sent', 'Interest_Declined_Sent', 'Interest_Pending_Received', 'Interest_Accept_Received', 'Interest_Declined_Received', 'Mail_Read_Sent', 'Mail_UnRead_Sent', 'Mail_Replied_Sent', 'Mail_Declined_Sent', 'Mail_Read_Received', 'Mail_UnRead_Received', 'Mail_Replied_Received', 'Mail_Declined_Received');
$varCountInfo								= $objProductFacebook->selectListSearchResult();
$varLastReceivedInfo						= $objProductFacebook->getLastConactCount($sessMatriId);
$varLastSentInfo							= $objProductFacebook->getLastConactCount($sessMatriId,'yes');

$varReceivedActionId	= '';
$varSentActionId		= '';
$varReceivedActionId	= $varLastReceivedInfo['Opposite_MatriId'];
$varSentActionId		= $varLastSentInfo['Opposite_MatriId'];
$varSentDate			= $varLastSentInfo[1]?date('d-M-Y',strtotime($varLastSentInfo[1])):'';
$varSentStatus			= $varLastSentInfo[2];
$varActionSent			= $varLastSentInfo[3];
$varReceivedDate		= $varLastReceivedInfo[1]?date('d-M-Y',strtotime($varLastReceivedInfo[1])):'';
$varReceivedStatus		= $varLastReceivedInfo[2];
$varActionReceived		= $varLastReceivedInfo[3];
if($varActionSent==1)
{
	if($varSentStatus==0)
		$varSentStatusText = 'Pending';
	if($varSentStatus==1 || $varSentStatus==6)
		$varSentStatusText = 'Accepted';
	if($varSentStatus==3 || $varSentStatus==7)
		$varSentStatusText = 'Declined';
	if($varSentStatus==5)
		$varSentStatusText = 'Deleted';
}
if($varActionSent==2)
{
	if($varSentStatus==0 || $varSentStatus==6)
		$varSentStatusText = 'Pending';
	if($varSentStatus==1 || $varSentStatus==7)
		$varSentStatusText = 'Not Replied';
	if($varSentStatus==2 || $varSentStatus==8)
		$varSentStatusText = 'Replied';
	if($varSentStatus==3 || $varSentStatus==9)
		$varSentStatusText = 'Declined';
	if($varSentStatus==5)
		$varSentStatusText = 'Deleted';
}
if($varActionReceived==1)
{
	if($varReceivedStatus==0)
		$varReceivedStatusText = 'Pending';
	if($varReceivedStatus==1 || $varReceivedStatus==6)
		$varReceivedStatusText = 'Accepted';
	if($varReceivedStatus==3 || $varReceivedStatus==7)
		$varReceivedStatusText = 'Declined';
	if($varReceivedStatus==5)
		$varReceivedStatusText = 'Deleted';
}
if($varActionReceived==2)
{
	if($varReceivedStatus==0 || $varReceivedStatus==6)
		$varReceivedStatusText = 'Pending';
	if($varReceivedStatus==1 || $varReceivedStatus==7)
		$varReceivedStatusText = 'Not Replied';
	if($varReceivedStatus==2 || $varReceivedStatus==8)
		$varReceivedStatusText = 'Replied';
	if($varReceivedStatus==3 || $varReceivedStatus==9)
		$varReceivedStatusText = 'Declined';
	if($varReceivedStatus==5)
		$varReceivedStatusText = 'Deleted';
}

//Count Values
#Mail sent
$varMailSentReadCount		= $varCountInfo['Mail_Read_Sent'];
$varMailSentRepliedCount	= $varCountInfo['Mail_Replied_Sent'];
$varMailSentNotReadCount	= $varCountInfo['Mail_UnRead_Sent'];
$varMailSentDeclinedCount	= $varCountInfo['Mail_Declined_Sent'];
$varMailSentTotalCount		= ($varMailSentReadCount + $varMailSentNotReadCount + $varMailSentDeclinedCount + $varMailSentRepliedCount);

$varMailSentReadCount		= $varMailSentReadCount ? $varMailSentReadCount : 0;
$varMailSentRepliedCount	= $varMailSentRepliedCount ? $varMailSentRepliedCount : 0;
$varMailSentNotReadCount	= $varMailSentNotReadCount ? $varMailSentNotReadCount : 0;
$varMailSentDeclinedCount	= $varMailSentDeclinedCount ? $varMailSentDeclinedCount : 0;
$varMailSentTotalCount		= $varMailSentTotalCount ? $varMailSentTotalCount : 0;

#Mail received
$varReceivedInfo			= $varCountInfo['Mail_UnRead_Received'];
$varNotRepliedInfo			= $varCountInfo['Mail_Read_Received'];
$varRepliedInfo				= $varCountInfo['Mail_Replied_Received'];
$varDeclindInfo				= $varCountInfo['Mail_Declined_Received'];
$varTotalPersonalizedMsgReceived = ($varReceivedInfo+$varNotRepliedInfo+$varRepliedInfo+$varDeclindInfo);

$varReceivedInfo			= $varReceivedInfo ? $varReceivedInfo : 0;
$varNotRepliedInfo			= $varNotRepliedInfo ? $varNotRepliedInfo : 0 ;
$varRepliedInfo				= $varRepliedInfo ? $varRepliedInfo : 0;
$varDeclindInfo				= $varDeclindInfo ? $varDeclindInfo : 0;
$varTotalPersonalizedMsgReceived = $varTotalPersonalizedMsgReceived ? $varTotalPersonalizedMsgReceived : 0;

#Salaam sent
$varNoOfSentPendingList		= $varCountInfo['Interest_Pending_Sent'];
$varNoOfSentAcceptList		= $varCountInfo['Interest_Accept_Sent'];
$varNoOfSentDeclineList		= $varCountInfo['Interest_Declined_Sent'];
$varTotalSalaamsSent		= ($varNoOfSentPendingList + $varNoOfSentAcceptList + $varNoOfSentDeclineList);

$varNoOfSentPendingList		= $varNoOfSentPendingList ? $varNoOfSentPendingList : 0;
$varNoOfSentAcceptList		= $varNoOfSentAcceptList ? $varNoOfSentAcceptList : 0;
$varNoOfSentDeclineList		= $varNoOfSentDeclineList ? $varNoOfSentDeclineList	: 0;
$varTotalSalaamsSent		= $varTotalSalaamsSent ? $varTotalSalaamsSent : 0;

#Salaam received
$varNoOfPendingListReceived	= $varCountInfo['Interest_Pending_Received'];
$varNoOfAcceptListReceived	= $varCountInfo['Interest_Accept_Received'];
$varNoOfDeclineListReceived	= $varCountInfo['Interest_Declined_Received'];
$varTotalMessageReceived	= ($varNoOfPendingListReceived + $varNoOfAcceptListReceived + $varNoOfDeclineListReceived);

$varNoOfPendingListReceived	= $varNoOfPendingListReceived ? $varNoOfPendingListReceived : 0;
$varNoOfAcceptListReceived	= $varNoOfAcceptListReceived ? $varNoOfAcceptListReceived : 0;
$varNoOfDeclineListReceived	= $varNoOfDeclineListReceived ? $varNoOfDeclineListReceived : 0;
$varTotalMessageReceived	= $varTotalMessageReceived ? $varTotalMessageReceived : 0;
?>
<!-- My Matrimony starts here -->
<script language="javascript" src="<?=$confValues['ServerURL']?>/registration/includes/my-matrimony.js"></script>
<script language="javascript" src="<?=$confValues['ServerURL']?>/registration/includes/tooltip.js"></script>

<!-- Calling Ajax Function To Display Photo Starts Here -->
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argSpanId, argPhotoName)
	{
		argPlaceHolderId="id"+argSpanId;
		document.getElementById(argPlaceHolderId).src = '../membersphoto/'+argPhotoName;
	}//showPhoto
</script>
<!-- Calling Ajax Function To Display Photo Ends Here -->
<!--View Similar Profiles starts here-->
<table border="0" cellpadding="0" cellspacing="0" width="589" align="center" height="1">
<tr>
<td valign="top">
	<form name="frmViewSimilarProfiles" action="../search/index.php" target="_blank" method="post" onSubmit="return false;">
	<input type="hidden" name="act" value="star-search-results">
	<input type="hidden" name="displayFormat" value="B">
	<input type="hidden" name="gender" value="<?=$sessGender=="2" ? "1" : "2";?>">
	<input type="hidden" name="religion">
	<input type="hidden" name="caste">
	<input type="hidden" name="star">
	<input type="hidden" name="city">
	<input type="hidden" name="viewSimilarMatriId">
	<input type="hidden" name="page">

	<input type="hidden" name="paidStatus" value="<?=$sessPaidStatus;?>">
	<input type="hidden" name="sessGender" value="<?=$sessGender;?>">
	</form>
</td></tr></table>
<!--View Similar Profiles ends here-->

<!-- Start of My Profile -->
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td valign="bottom"><img src="images/myprofile-leftcurve.gif" height="10" width="40"></td>
			<td valign="bottom"><img src="images/myprofile-icontxt.gif" height="38" width="115"></td>
			<td valign="bottom"><img src="images/myprofile-toptile.gif" height="11" width="300"></td>
			<td valign="bottom"><img src="images/myprofile-phtopcurve1.gif" height="10" width="6"></td>
			<td valign="bottom"><img src="images/myprofile-phtoptile.gif" height="11" width="113"></td>
			<td valign="bottom"><img src="images/myprofile-phtopcurve2.gif" height="11" width="13"></td>
	</tr>
</tbody></table>

<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td bgcolor="#BFDBF5" valign="top" width="4"><img src="<?=$confValues['ServerURL']?>/registration/images/trans_003.gif" height="1" width="4"></td>
			<td valign="top">
					<div style="width: 577px; padding-top: 0px; padding-bottom: 0px;">

							<table border="0" cellpadding="0" cellspacing="0">
							<tbody><tr>
							<td style="padding-left: 19px;" valign="top">
							<div style="width: 205px; float: left; padding-top: 2px; text-align: left;">
									<div class="smalltxt" style="padding-top: 8px; padding-right: 15px; text-align: justify;">
										<div style="padding-top: 8px; text-align: left;">Name : <?=$varSelectMemberInfo["Name"];?></div>
										<div style="padding-top: 8px; text-align: left;">Membership : <?=$sessPaidStatus==0 ? "  Free" : "  Paid"?></div>
										<?php if($sessLastLogin!='0000-00-00 00:00:00') { ?>
										<div style="padding-top: 8px;">Last Login : <?=$sessLastLogin;?></div>
										<?php }//if ?>
									</div>
							</div>
					</td>
					<td valign="top">
							<div style="width: 5px; float: left;"><div style="background-color: rgb(255, 255, 255);"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="5"></div></div></td>
					<td valign="top">
							<div style="width: 220px; float: left; padding-top: 2px; text-align: left;">
									<div style="padding-top: 8px; padding-right: 15px; text-align: justify;" class="smalltxt">
												<div style="padding-top: 8px;">User Name : <a href="profile-view.php?matrimonyId=<?=$sessMatriId?>"><font color="#1470AF" ><b><?= $sessUsername ?></b></font></a></div>
												<div style="padding-top: 8px;">Profile created on : <?=$varCreatedDate?></div>
												<?if ($varLastEditedDate !="") {?>
												<div style="padding-top: 8px;">Profile last edited : <?=$varLastEditedDate?> <?php } ?></div>
												<div style="padding-top: 8px;" class="smalltxt">
												<?php if ($sessPaidStatus==1) { 
													print"Valid Days : ".$varRemainingDays;
												 }//if ?>
												</div>
									</div>
							</div>
			</td>
			<td valign="top">
							<div style="width: 1px; float: left;"><div style="background-color: rgb(255, 255, 255);"></div></div></td>
			<td colspan="1" rowspan="2" bgcolor="#eff7e3" valign="top">
							<div style="background:#E5F1F8; height: 117px; width: 127px; float: left; padding-top: 2px; text-align: center;">

								<div style="padding-top: 8px; text-align: center;" class="smalltxt"><a href="../photo/index.php"><img src="<?=$confValues['ServerURL']?><?=$varImageFileName?>" border="0" height="75" vspace="5" width="75"></a><br><a href="../photo/" class="pagetxtsp" title="<?=$varPhotoName=="" ? 'Upload ' : 'Manage'?> Photo" target="_blank"><u><?=$varPhotoName=="" ? 'Upload' : 'Manage'?> Photo</u></a></div>
			
							</div>
			</td></tr>
			<tr>
							<td colspan="4" rowspan="1" valign="top">
							<div style="padding-top: 8px; text-align: left; padding-left: 19px;" class="smalltxt">
							<?php if ($sessPaidStatus==0) { ?>
								<a href="../payment/" class="pagetxtsp"  target="_blank"><u>Click here</u></a> to become a PAID member
							<?php }//if ?>
							</div>
							</td>
			</tr>		
				
	</tbody></table>
					</div>

			</td>
			<td bgcolor="#BFDBF5" valign="top" width="4"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="4"></td>
	</tr>
</tbody></table>
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td valign="bottom"><img src="images/myprofile-botcurve.gif" height="9" width="14"></td>
			<td valign="bottom"><img src="images/myprofile-bottile.gif" height="9" width="442"></td>
			<td valign="bottom"><img src="images/myprofile-phbotcurve.gif" height="9" width="131"></td>
	</tr>
</tbody></table>
<!-- End of My Profile -->

<br>
<!-- Start of Check List -->
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td valign="bottom"><img src="images/chklist-leftcurve.gif" height="11" width="38"></td>
			<td valign="bottom"><img src="images/chklist-icontxt.gif" height="32" width="118"></td>
			<td valign="bottom"><img src="images/chklist-toptile.gif" height="11" width="417"></td>
			<td valign="bottom"><img src="images/chklist-rightcurve.gif" height="12" width="12"></td>
	</tr>
</tbody></table>

<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td bgcolor="#b0cbe4" valign="top" width="4"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="4"></td>
			<td valign="top">
					<div style="width: 577px; padding-top: 0px; padding-bottom: 0px;">

							<div style="width: 10px; float: left;"><div style="background-color: rgb(255, 255, 255);"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="10"></div></div>

							<div style="width: 260px; float: left; padding-top: 2px; text-align: left;">
								<div style="padding-top: 8px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/chklist-<?=$varPhotoInfo ? "tik" : "cross";?>.gif" height="9" hspace="4" width="9"><a href="../photo/"  class="pagetxtsp" onMouseover="mytip('Add multiple photos to your profile and increase the responses by 20 times.')"; onMouseout="hidemytip()"  target="_blank">Photo</font></a> (Get 20 times more responses)</div>
							</div>							
							<div style="width: 300px; float: left; padding-top: 2px; text-align: left;">
								<div style="padding-top: 8px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/chklist-<?=$varPartnerSetStatus ? "tik" : "cross";?>.gif" height="9" hspace="4" width="9"><a href="../registration/index.php?act=edit-partner"  class="pagetxtsp" onMouseover="mytip('Set your partner preference and get the right kind of proposals.')"; onMouseout="hidemytip()"  target="_blank">Partner Preference</font></a> (Set your partner criteria)</div>
							</div>

							<div style="width: 1px; float: left;"><div style="background-color: rgb(255, 255, 255);"></div></div>
					</div>
			</td>
			<td bgcolor="#b0cbe4" valign="top" width="4"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="4"></td>
	</tr>
	<tr><td colspan="3" valign="bottom"><img src="images/chklist-bottomcurve.gif" height="10" width="585"></td></tr>
</tbody></table>
<!-- End of Check List -->


<br>

<!-- Start of My Messages -->
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td valign="bottom"><img src="images/chklist-leftcurve.gif" height="11" width="38"></td>
			<td valign="bottom"><img src="images/mymsg-icontxt.gif" height="32" width="146"></td>
			<td valign="bottom"><img src="images/chklist-toptile.gif" height="11" width="389"></td>
			<td valign="bottom"><img src="images/chklist-rightcurve.gif" height="12" width="12"></td>
	</tr>
</tbody></table>
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tbody><tr>
			<td bgcolor="#b0cbe4" valign="top" width="4"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="4"></td>
			<td valign="top">
					<div style="width: 577px; padding-top: 0px; padding-bottom: 0px;">
							<div style="width: 20px; float: left;"><div style="background-color: rgb(255, 255, 255);"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="20"></div></div>
							<div style="width: 280px; float: left; padding-top: 2px; text-align: left;">
										<div style="padding-top: 8px; text-align: left;"><font class="pagetxtsp"><b>Personalized Message Received (<?=$varTotalPersonalizedMsgReceived?>)</b></font></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-received.php?status=0"  class="pagetxtsp" >New Mail (<?=$varReceivedInfo;?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-received.php?status=1"  class="pagetxtsp" >Not Replied (<?=$varNotRepliedInfo;?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-received.php?status=2"  class="pagetxtsp" >Replied (<?=$varRepliedInfo;?>)</font></a></div>
										<div style="padding-top: 5px; padding-bottom: 10px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-received.php?status=3"  class="pagetxtsp" >Declined (<?=$varDeclindInfo;?>)</font></a></div>

										<div style="padding-top: 8px; text-align: left;"><font class="pagetxtsp"><b>Salaam Received (<?=$varTotalMessageReceived;?>)</b></font></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="interest-received.php?status=0"  class="pagetxtsp" >Pending (<?=$varNoOfPendingListReceived?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="interest-received.php?status=1"  class="pagetxtsp" >Accepted (<?=$varNoOfAcceptListReceived?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="interest-received.php?status=3"  class="pagetxtsp" >Declined (<?=$varNoOfDeclineListReceived?>)</font></a></div>

										<div style="padding-top: 15px; text-align: left;" class="smalltxt"><font color="#E23929"><b>Members who viewed my profile: <?=$varSelectMemberInfo["Profile_Viewed"];?></b></font></div>

							</div>

							<div style="width: 270px; float: left; padding-top: 2px; text-align: left;">
										<div style="padding-top: 8px; text-align: left;"><font class="pagetxtsp""><b>Personalized Message Sent (<?=$varMailSentTotalCount;?>)</b></font></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-sent.php?rid=2"  class="pagetxtsp" >Replied (<?=$varMailSentRepliedCount?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-sent.php?rid=1"  class="pagetxtsp" >Read (<?=$varMailSentReadCount?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-sent.php?rid=0"  class="pagetxtsp" >Not Read (<?=$varMailSentNotReadCount?>)</font></a></div>
										<div style="padding-top: 5px; padding-bottom: 10px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="message-sent.php?rid=3"  class="pagetxtsp" >Declined (<?=$varMailSentDeclinedCount?>)</font></a></div>

										<div style="padding-top: 8px; text-align: left;"><font class="pagetxtsp"><b>Salaam Sent (<?=$varTotalSalaamsSent;?>)</b></font></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="interest-sent.php?pageName=accept"  class="pagetxtsp" >Accepted (<?=$varNoOfSentAcceptList?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="interest-sent.php?pageName=decline"  class="pagetxtsp" >Declined (<?=$varNoOfSentDeclineList?>)</font></a></div>
										<div style="padding-top: 5px; text-align: left;" class="smalltxt"><img src="<?=$confValues['ServerURL']?>/images/mymsg-arrow.gif" height="5" hspace="4" width="3"><a href="interest-sent.php?pageName=pending"  class="pagetxtsp" >Pending (<?=$varNoOfSentPendingList?>)</font></a></div>

							</div>

							<div style="width: 1px; float: left;"><div style="background-color: rgb(255, 255, 255);"></div></div>
					</div>
			</td>
			<td bgcolor="#b0cbe4" valign="top" width="4"><img src="<?=$confValues['ServerURL']?>/images/trans_003.gif" height="1" width="4"></td>
	</tr>
	<tr><td colspan="3" valign="bottom"><img src="images/chklist-bottomcurve.gif" height="10" width="585"></td></tr>
</tbody></table>
<!-- My Profile Statistics ends here -->
<br>

<!-- content ends here -->
<?php
//UNSET OBJECT
unset($objProductFacebook);
?>