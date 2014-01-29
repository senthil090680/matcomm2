<?php
require_once('header.php');
require_once('navinc.php');

//FILE INCLUDES
include_once('../mailer/includes/clsMailManager.php');

//OBJECT DECLARTION
$objMailManager = new MailManager;
$objProductFacebook = new QuickSearch;

//VARIABLE DECLARATION
$varMessageId	= $_REQUEST["messageId"];
$varCurrentDate	= date('Y-m-d H:i:s');
$varMailId		= $_REQUEST["mailId"];
$varDeclinedId  = $_REQUEST["declinedId"];
$varNoOfPendingListReceived = '';
$varNoOfAcceptListReceived  = '';
$varNoOfDeclineListReceived = '';

$objProductFacebook->clsPaidStatus		= $sessPaidStatus;
$objProductFacebook->clsSessionMatriId	= $sessMatriId;
$objProductFacebook->clsFilename = 'yes';
//CONTROL STATEMENT
$varGetStatus = $_GET['status']==""?0:$_GET['status'];
if($_REQUEST['page'] == '') { if($_REQUEST['pg'] == ''){ $pageNum = 1; }else{ $pageNum = $_REQUEST['pg']; } }
else{ $pageNum = $_REQUEST['page']; }

if ($_REQUEST['frmInterestReceivedSubmit']=='yes' && $_REQUEST['frmPopupSubmit']=='no')
{
	$varCurrentUpdateStatus	= $_REQUEST["currentStatus"];
	$varMessageIds			= explode(",",substr($_REQUEST["messageIds"],0,-1));
	$varNoOfRecs			= count($varMessageIds);
	for ($i=0; $i<$varNoOfRecs; $i++)
	{
		if($varMessageIds[$i] !='')
		{
		$varPreviousInfo['Status']		= '';
		$objProductFacebook->clsTable			= 'interestreceivedinfo';
		$objProductFacebook->clsPrimary		= array('Interest_Id');
		$objProductFacebook->clsPrimaryValue	= array($varMessageIds[$i]);
		$objProductFacebook->clsFields		= array('Status','Date_Deleted');
		$varPreviousInfo				= $objProductFacebook->selectListSearchResult();
				
		//SUBTRACT DELETED COUNT IN ACCEPT OR DECLINE AREA IN memberstattistics
		if($varPreviousInfo['Status']==1 || $varPreviousInfo['Status']==3 || $varPreviousInfo['Status']==0)
		{
			$objProductFacebook->clsFieldsValues	= array($varCurrentUpdateStatus,$varCurrentDate);
			$varAffectedRows				= $objProductFacebook->updateQuickSearch();
			#receiver side only
			$objProductFacebook->clsTable			= 'memberstatistics';
			$objProductFacebook->clsPrimary		= array('MatriId');
			$objProductFacebook->clsPrimaryValue	= array($sessMatriId);

			if($varPreviousInfo['Status'] == 1)
			{
				$objProductFacebook->clsFields		= array('Interest_Accept_Received');	
				$objProductFacebook->clsFieldsValues	= array('Interest_Accept_Received-1');	
			}
			elseif($varPreviousInfo['Status'] == 3)
			{
				$objProductFacebook->clsFields		= array('Interest_Declined_Received');	
				$objProductFacebook->clsFieldsValues	= array('Interest_Declined_Received-1');
			}//elseif
			else
			{
				$objProductFacebook->clsFields		= array('Interest_Pending_Received');	
				$objProductFacebook->clsFieldsValues	= array('Interest_Pending_Received-1');
			}
			$objProductFacebook->updateMyMessageCount();
		}//if
		}//if
	}//for
	$_REQUEST['frmInterestReceivedSubmit'] = '';
	$_REQUEST['frmPopupSubmit']			   = '';
}//if
?>
<script language="javascript" src="<?=$confServerURL?>/my-messages/includes/interest-received.js" type="text/javascript"></script>
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argSpanId, argPhotoName)
	{
		argPlaceHolderId="id"+argSpanId;
		document.getElementById(argPlaceHolderId).src = '../membersphoto/'+argPhotoName;
	}//showPhoto
	function doProductNext(argPgNum)
	{
		document.frmInterestReceived.page.value = argPgNum;
		document.frmInterestReceived.submit();
	}//funDoNextAdvanced
</script>
<!-- Calling Ajax Function To Display Photo Ends Here -->

<?php
$objProductFacebook->clsPendingMsg		= "Received on: ";
$objProductFacebook->clsAcceptMsg			= "Accepted on: ";
$objProductFacebook->clsDeclinedMsg		= "Declined on: ";

if($_GET["status"] == ""){ $varInterestStatus = 0; }//if
else{ $varInterestStatus = $_GET["status"]; }//else

$objProductFacebook->clsStart	= ($pageNum-1) * $objProductFacebook->clsLimit;

//Select Count Details from memberstatistics
$objProductFacebook->clsFields	= array('Interest_Pending_Received', 'Interest_Accept_Received', 'Interest_Declined_Received');
$objProductFacebook->clsTable			= "memberstatistics";
$objProductFacebook->clsPrimary		= array('MatriId'); 
$objProductFacebook->clsPrimaryValue	= array($sessMatriId);
$varStatisticsInfo				= $objProductFacebook->selectListSearchResult();

$varNoOfPendingListReceived = $varStatisticsInfo['Interest_Pending_Received'];
$varNoOfAcceptListReceived  = $varStatisticsInfo['Interest_Accept_Received'];
$varNoOfDeclineListReceived = $varStatisticsInfo['Interest_Declined_Received'];

if($varStatisticsInfo['Interest_Pending_Received'] == '')
{
	$varNoOfPendingListReceived = 0;
	$varNoOfAcceptListReceived  = 0;
	$varNoOfDeclineListReceived = 0;
}

$varArrExpressInterest		= array(4=>"I am interested in your profile. If you are interested in my profile, please contact me.",5=>"I have gone through your details and feel we have lot in common.  Would sure like to know your opinion on this?",6=>"You are someone special I wish to know better. Please contact me at the earliest.",7=>"We found your profile to be a good match. Please contact us to proceed further.",8=>"You are the kind of person we were searching for. Please send us your contact details.");

$objProductFacebook->clsPlaceHolders	= array('<--MESSAGE-ID-->','<--MATRIMONY-ID-->', '<--USERNAME-->', '<--INTEREST-MSG-->','<--DECLINED-MSG-->', '<--RECEIVED-DATE-->', '<--PHOTOS-->', '<--AGE-->', '<--HEIGHT-->', '<--RELIGION-->', '<--SUB-CASTE-->', '<--CITY-->', '<--COUNTRY-->', '<--EDUCATION-->', '<--OCCUPATION-->', '<--DESCRIPTION-->', '<--SIMILAR-PROFILE-URL-->', '<--INTEREST-ACTIVITY1-->', '<--INTEREST-ACTIVITY2-->', '<--LAST-LOGIN-->','<--LAST-ACTION-->','<--ACCEPTED-DATE-->','<--ONLINE-->');

$objProductFacebook->clsPlaceHoldersValues	= array('Interest_Id','MatriId','Username','Interest_Option','Declined_Option','Date_Updated','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','ViewSimilar','Interest_Activity1','Interest_Activity2','Last_Login','Last_Action','Date_Accepted','Online');

$objProductFacebook->clsTextConversion	= array('Interest_Id','MatriId','Username','Interest_Option','Declined_Option','Date_Updated','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','ViewSimilar','Interest_Activity1','Interest_Activity2','Last_Login','Last_Action','Date_Accepted','Online');

$objProductFacebook->clsFields	= array('Interest_Id','eii.Opposite_MatriId AS Exp_MatriId', 'Interest_Option', 'Declined_Option', 'eii.Date_Received AS Exp_Date_Updated','Date_Accepted');

$objProductFacebook->clsTable					= 'interestreceivedinfo';
$objProductFacebook->clsPrimary				= array('eii.MatriId', 'Status');
$objProductFacebook->clsPrimaryValue			= array($sessMatriId, $varInterestStatus);
$objProductFacebook->clsPrimaryKey			= array('AND');
$objProductFacebook->clsMemberYouContacted	= 'Opposite_MatriId';

$objProductFacebook->clsInterestActivity1 = 'Accept';
if ($varInterestStatus == 0)
{
	$varNoOfRecords   = $varNoOfPendingListReceived;
	$objProductFacebook->clsLinkSymbol='yes';
	$objProductFacebook->clsInterestActivity2 = 'Decline';
	$objProductFacebook->clsDisplayMessage	= 'Currently you have no pending salaams';
}//if
else if ($varInterestStatus == 3)
{
	$varNoOfRecords   = $varNoOfDeclineListReceived;
	$objProductFacebook->clsAcceptMsg			= 'Declined on: '; 
	$objProductFacebook->clsLinkSymbol		= 'yes'; 
	$objProductFacebook->clsInterestActivity2 = 'Delete'; 
	$objProductFacebook->clsDeleteFlag		= 1;
	$objProductFacebook->clsDisplayMessage	= 'Currently you have no declined salaams';
}//else if
else if ($varInterestStatus == 1)
{
	$varNoOfRecords   = $varNoOfAcceptListReceived;
	$objProductFacebook->clsDeleteFlag		= 1;
	$objProductFacebook->clsInterestActivity1 = '';
	$objProductFacebook->clsInterestActivity2 = 'Delete'; 
	$objProductFacebook->clsDisplayMessage	= 'Currently you have no accepted salaams';
}//els if
else { $objProductFacebook->clsInterestActivity2 = ''; }//else

$varTemplate = $objProductFacebook->getContentFromFile('templates/salaams-received.tpl');
$objProductFacebook->clsListTemplate	= $varTemplate;

$varNumOfPages		= ceil($varNoOfRecords/$objProductFacebook->clsLimit);
#---------------------------------------------------------------------------------------------------------
?>
<!--View Similar Profiles starts here-->
<form name="frmViewSimilarProfiles" action="../search/" target="_blank" method="post" onSubmit="return false;" style="display:none">
<input type="hidden" name="act" value="star-search-results">
<input type="hidden" name="displayFormat" value="B">
<input type="hidden" name="gender" value="<?=$sessGender==2 ? 1 : 2;?>">
<input type="hidden" name="religion">
<input type="hidden" name="caste">
<input type="hidden" name="star">
<input type="hidden" name="city">
<input type="hidden" name="viewSimilarMatriId">
<input type="hidden" name="page" value="<?=$pageNum?>">
<input type="hidden" name="paidStatus" value="<?=$sessPaidStatus;?>">
<input type="hidden" name="sessGender" value="<?=$sessGender;?>">
</form>
<!--View Similar Profiles ends here-->


<!-- form starts here -->
<form name="frmInterestReceived" method="post" onSubmit="return false;">
<div style="display:none">
<input type="hidden" name="frmInterestReceivedSubmit" value="yes">
<input type="hidden" name="frmPopupSubmit" value="no">
<input type="hidden" name="pendingListCount" value="<?=$varNoOfPendingList;?>">
<input type="hidden" name="acceptListCount" value="<?=$varNoOfAcceptList?>">
<input type="hidden" name="declineListCount" value="<?=$varNoOfDeclineList?>">
<input type="hidden" name="currentStatus" value="">
<input type="hidden" name="page" value="<?=$pageNum?>">
<input type="hidden" name="status" value="<?=$varGetStatus?>">
<!--for mail purpose-->
<input type="hidden" name="mailid" value="<?=$varMailId?>">
<input type="hidden" name="messageId" value="<?=$varMessageId?>">
<input type="hidden" name="declinedId" value="<?=$varDeclinedId?>">
<!--mail purpose ends-->
<input type="hidden" name="act" value="interest-received">
<input type="hidden" name="messageIds" value="">
</div>

<!-- Heading Table starts here  -->
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="heading">
			<div style="padding-left:5px;padding-top:5px;padding-bottom:0px;">Salaams Received - 
			<?if($varInterestStatus == "0"){?>Pending
			<?}else if($varInterestStatus == "1"){?>Accepted
			<?}else{?>Declined<?}?>
			</div>
		<td>
	</tr>
</tr>
</table>
<!-- Heading Table ends here -->

<!-- Content Table starts here -->
<table bgcolor="#ffffff" border=0 cellspacing=0 cellpadding="0" width="100%" align=center>
	<tr>
		<td valign="top">
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr><td valign="top" class="smalltxt"><p align="justify" style="line-height: 18px;">
				<?php if ($varInterestStatus == "0"){?>
				<span id="PendingListMessage" style="padding-left:5px">Listed below are members who have sent Salaams and awaiting your response. Go ahead and send them <br>&nbsp;a reply, don't keep them guessing. If a member's profile does not interest you, kindly decline their salaam.</span>
				<?php }?>
				</p></td></tr>
			</table>
		</td>
	</tr>
</table><br>
<!-- Content Table ends here -->
<!-- Salaam send & salaam Received ends here -->
<table class="memonlsbg4" border="0" cellspacing=0 cellpadding="0" height="20" style="border:solid 1px #C3E07B" width="98%" align="center">
	<tr>
		<td valign="middle" width="145"><font class="smallttxtnormal">&nbsp;&nbsp;&nbsp;<a href="interest-received.php" class="smalltxt" style="text-decoration:none"><b>Salaams Received</b></a>&nbsp;|</font></td>
		<td valign="middle" width="100"><font class="smallttxtnormal"><a href="interest-sent.php" class="smalltxt" style="text-decoration:none">Salaams Sent</a></font></td>
		<td valign="middle" class="smallttxtnormal" width="350" align="right">
	
		</td>
	</tr>
</table><br>
<!-- Salaam send & salaam Received ends here -->
<!-- Pending,Accept,Declied menus with count Table starts here -->
<table bgcolor="#FFFFFF" border="0" cellspacing=0 cellpadding="0" width="98%" align="center">
	<tr>
		<td valign="top" width="376"><img src="<?=$confServerURL?>/images/trans.gif" height="21" border="0"></td>
		<td valign="top" align="left" width="100">
			<?php if ($varInterestStatus==0) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Pending (<b><?=$varNoOfPendingListReceived;?></b>)</div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else {?>	
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none"><a href="interest-received.php?status=0" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="5" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Pending (<b><?=$varNoOfPendingListReceived;?></b>)</a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			<? }//else?>
		</td>
		<td valign="top" width="98">
			<?php if ($varInterestStatus==1) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Accepted (<b><?=$varNoOfAcceptListReceived;?></b>)</div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else {?>	
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none"><a href="interest-received.php?status=1" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Accepted (<b><?=$varNoOfAcceptListReceived;?></b>)</a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			<? }//else?>
		</td>
		
		<td valign="top" align="left"  width="85">
			<?php if ($varInterestStatus==3) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Declined (<b><?=$varNoOfDeclineListReceived;?></b>)</div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else {?>	
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none"><a href="interest-received.php?status=3" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Declined (<b><?=$varNoOfDeclineListReceived;?></b>)</a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			<?php }//else?>
		</td>
	</tr>
</table>
<!-- Pending,Accept,Declied menus with count Table ends here -->

<table border="0" cellspacing=0 cellpadding="0" width="98%" align="center" style="border:1px solid #C3E07B;">
<!-- Pending,Accept,Declied buttons Table starts here -->
	<tr class="memonlsbg4"><td valign="top" width="75%">
		<?php if($varNoOfRecords != 0){?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="left">
					<table border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td valign="middle"><input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.interestSent,this.form.checkName,'0');"></td>
						<td align="right" valign="top">
							<?php if ($varInterestStatus !="1") { ?>
							<input type="image" src="<?=$confServerURL?>/images/accept-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.interestSent,1);">
							<?php }//if ?>
						</td>
						<td align="left" valign="top">
							<?php if ($varInterestStatus !="0") { ?>
								<input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="0" onClick="funConfirmMessage(this.form,this.form.interestSent,3);">
							<?php }//if?>
							<?php if ($varInterestStatus =="0") { ?>
							<input type="image" src="<?=$confServerURL?>/images/decline-button.gif" vspace="5" hspace="0" onClick="funConfirmMessage(this.form,this.form.interestSent,2);">
							<?php }//if?>
						</td>
					</tr>
					</table>
				</td>
				<td width="23%" align="right">
						<table border="0" cellpadding="0" cellspacing="0" width="98%">
						<!-- page navigation starts here -->
						<?=$objProductFacebook->pageNavigation($varNoOfRecords, $pageNum, $varNumOfPages, "yes")?>
						<!-- page navigation ends here -->
						</table>
				</td>
				<td width="2%"></td>
			</tr>
		</table>
		<?php }?>
	</td></tr>
<!-- Pending,Accept,Declied buttons Table ends here -->

<!-- Results starts here -->
<tr><td><br>

<!--Search Results Tables starts here-->
<table border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
<?php
	if($varNoOfRecords == 0)
	{
		$funDisplay	.= '<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">';
		$funDisplay .= '<tr><td align="center" valign="middle" class="errorMsg" height="30">';
		$funDisplay .= $objProductFacebook->clsDisplayMessage;
		$funDisplay .= '<br></td></tr>';
		echo $funDisplay .= '</table>';
	}
	else
	{
		$objProductFacebook->clsOrderBy = array('eii.Date_Received');
		$objProductFacebook->listMyMessage('IR'); 
	}//else
?>
</table>
<!--Search Results Tables starts here-->
</td></tr>
<!-- Results ends here  -->
<tr><td>
<!-- bottom pending,Accept,decline buttons starts here -->
<?php if($varNoOfRecords != 0){?>
<table border="0" cellpadding="0" cellspacing="0" width="98%">
	<tr class="memonlsbg4">
		<td valign="top" width="75%">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="left">
						<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="left"><input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.interestSent,this.form.checkName,'1');"></td>
							<td align="right" valign="top">
								<?php if ($varInterestStatus !="1") { ?>
								<input type="image" src="<?=$confServerURL?>/images/accept-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.interestSent,1);">
								<?php }//if ?>
							</td>
							<td valign="top">
								<?php if ($varInterestStatus !="0") { ?>
								<input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="0" onClick="funConfirmMessage(this.form,this.form.interestSent,3);">
								<?php }//if ?>
								<?php if ($varInterestStatus =="0") { ?>
								<input type="image" src="<?=$confServerURL?>/images/decline-button.gif" vspace="5" hspace="0" onClick="funConfirmMessage(this.form,this.form.interestSent,2);">
								<?php }//if ?>
							</td>
						</tr>
						</table>
					</td>
					<td width="23%" align="right">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<!-- page navigation starts here -->
						<?=$objProductFacebook->pageNavigation($varNoOfRecords, $pageNum, $varNumOfPages, "yes")?>
						<!-- page navigation ends here -->
						</table>
					</td>
					<td width="2%"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php }?>
<!-- bottom pending,Accept,decline buttons ends here -->
</td></tr></table><br>
<?php
//UNSET OBJECT
unset($objProductFacebook);
?>
</form>