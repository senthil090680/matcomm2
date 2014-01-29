<?php
require_once('header.php');
require_once('navinc.php');
//OBJECT DECLARATION
$objProductFacebook = new QuickSearch;

//VARIABLE DECLARATION
$varCurrentDate								= date('Y-m-d H:i:s');
$objProductFacebook->clsDisplayMsgFlag		= 0;
$objProductFacebook->clsPaidStatus			= $sessPaidStatus;
$objProductFacebook->clsSessionMatriId		= $sessMatriId;
$objProductFacebook->clsPrimaryKey			= array('AND');
$objProductFacebook->clsPrimarySymbol		= array('=','=');
$objProductFacebook->clsCountField			= 'Mail_Id';
$objProductFacebook->clsSessionGender		= $sessGender;

#--------------------------------------------------------------------------------------------------------------
#PAGING CODE
if($_REQUEST['page'] == '') { if($_REQUEST['pg'] == ''){ $pageNum = 1; }else{ $pageNum = $_REQUEST['pg']; } }
else{ $pageNum = $_REQUEST['page']; }
$objProductFacebook->clsStart			= ($pageNum-1) * $objProductFacebook->clsLimit;
#--------------------------------------------------------------------------------------------------------------
#DISPLAY TEXT
$objProductFacebook->clsMailAction			= 'outbox';
$objProductFacebook->clsFormName			= 'frmMessageSent';
$objProductFacebook->clsLastAction			= 'yes';
$objProductFacebook->clsPendingMsg			= 'Sent on: ';
$objProductFacebook->clsAcceptMsg			= 'Read on: ';
$objProductFacebook->clsDeclinedMsg			= 'Declined on: ';
#--------------------------------------------------------------------------------------------------------------
if ($_REQUEST['frmMessageSentSubmit']=='yes')
{
	$varMessageIds							= explode(',',substr($_POST['messageIds'],0,-1));
	$varCurrentDate							= date('Y-m-d H:i:s');
	for($i=0; $i<count($varMessageIds); $i++)
	{
		$objProductFacebook->clsTable		= 'mailsentinfo';
		$objProductFacebook->clsPrimary		= array('Mail_Id');
		$objProductFacebook->clsPrimaryValue= array($varMessageIds[$i]);
		$objProductFacebook->clsFields		= array('Status', 'Date_Deleted');
		$varPreviousSenderStatus			= $objProductFacebook->selectListSearchResult();
		if(($varPreviousSenderStatus['Status']!=5) && ($varPreviousSenderStatus['Status']!='')){

		//UPDATE DELETE STATUS IN mailsentinfo
		$objProductFacebook->clsFieldsValues	= array('5', $varCurrentDate);
		$objProductFacebook->updateQuickSearch();

		//UPDATE SENDER SIDE DELETE STATUS INTO RECEIVER SIDE
		$objProductFacebook->clsTable			= 'mailreceivedinfo';
		$objProductFacebook->clsFields			= array('Sender_Deleted');
		$objProductFacebook->clsFieldsValues	= array(1);
		$objProductFacebook->updateQuickSearch();

		$varSubtractField		= '';
		$varSubtractFieldValue	= '';
		switch($varPreviousSenderStatus['Status'])
		{
			case 0:
					$varSubtractField			= 'Mail_UnRead_Sent';
					$varSubtractFieldValue		= 'Mail_UnRead_Sent-1';break;
			case 1:
					$varSubtractField			= 'Mail_Read_Sent';
					$varSubtractFieldValue		= 'Mail_Read_Sent-1';break;
			case 2:
					$varSubtractField			= 'Mail_Replied_Sent';
					$varSubtractFieldValue		= 'Mail_Replied_Sent-1';break;
			case 3:
					$varSubtractField			= 'Mail_Declined_Sent';
					$varSubtractFieldValue		= 'Mail_Declined_Sent-1';break;
		}
		//SUBTRACT DELETED RECORDS COUNT IN memberstatistics
		#only subtract in sender side- (logged user side)
		$objProductFacebook->clsTable			= 'memberstatistics';
		$objProductFacebook->clsPrimary			= array('MatriId');
		$objProductFacebook->clsPrimaryValue	= array($sessMatriId);
		$objProductFacebook->clsFields			= array($varSubtractField);	
		$objProductFacebook->clsFieldsValues	= array($varSubtractFieldValue);
		$objProductFacebook->updateMyMessageCount();

		}//if

	}//for
}//if
$objProductFacebook->clsTable					= 'mailsentinfo';
$varReceiverStatus								= $_REQUEST['rid'] ? $_REQUEST['rid'] : 0;
$objProductFacebook->clsPrimaryKey				= array('AND','AND');
$objProductFacebook->clsPrimarySymbol			= array('=','=','=');
$objProductFacebook->clsPrimary					= array('mailsentinfo.MatriId','mailsentinfo.Status');
$objProductFacebook->clsPrimaryValue			= array($sessMatriId, 0);
$objProductFacebook->clsFields					= array('Mail_Follow_Up','Mail_Id','mailsentinfo.Opposite_MatriId','Mail_Message','mailsentinfo.Date_Sent');
$objProductFacebook->clsFieldsToDisplay			= array('Mail_Follow_Up','Mail_Id','Opposite_MatriId','Mail_Message','Date_sent');
$objProductFacebook->clsInterestActivity1		= '';
$objProductFacebook->clsInterestActivity2		= 'Delete';
$objProductFacebook->clsListTemplate			= $objProductFacebook->getContentFromFile('templates/mail-sent.tpl');
$objProductFacebook->clsPlaceHolders			= array('<--MESSAGE-ID-->','<--MATRIMONY-ID-->','<--USERNAME-->','<--FORM-NAME-->','<--CHECKBOX-NAME-->', '<--PHOTOS-->' ,'<--AGE-->', '<--HEIGHT-->', '<--RELIGION-->', '<--SUB-CASTE-->', '<--CITY-->', '<--COUNTRY-->', '<--EDUCATION-->', '<--OCCUPATION-->', '<--DESCRIPTION-->','<--FULL-MESSAGE-->', '<--SIMILAR-PROFILE-URL-->','<--INTEREST-MSG-->','<--DECLINED-MSG-->','<--LAST-LOGIN-->','<--RECEIVED-DATE-->', '<--ACCEPTED-DATE-->','<--DECLINED-DATE-->','<--LAST-ACTION-->','<--ONLINE-->','<---->','<--INTEREST-ACTIVITY1-->', '<--INTEREST-ACTIVITY2-->');

$objProductFacebook->clsPlaceHoldersValues		= array('Mail_Id','MatriId','Username','FormNmae','CheckBoxName','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','InterestMessage','ViewSimilar' ,'InterestMessage','','Last_Login','Date_Updated','Date_Read','Date_Declined','Last_Action','Online','Publish','','');

$objProductFacebook->clsTextConversion			= array('Mail_Id','MatriId','Username','FormNmae','CheckBoxName','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','InterestMessage','ViewSimilar','InterestMessage','','Last_Login','Date_Updated','Date_Read','Date_Declined','Last_Action','Online');

#---------------------------------------------------------------------------------------------------------------
#get message count 
$objProductFacebook->clsTable					= 'memberstatistics';
$objProductFacebook->clsFields					= array('Mail_Read_Sent','Mail_UnRead_Sent','Mail_Replied_Sent','Mail_Declined_Sent');
$objProductFacebook->clsPrimary					= array('MatriId'); 
$objProductFacebook->clsPrimaryValue			= array($sessMatriId);
$objProductFacebook->clsOrderBy					= array();
$varStatisticsInfo								= $objProductFacebook->selectListSearchResult();

$varMailSentReadCount							= $varStatisticsInfo['Mail_Read_Sent'];
$varMailSentRepliedCount						= $varStatisticsInfo['Mail_Replied_Sent'];
$varMailSentNotReadCount						= $varStatisticsInfo['Mail_UnRead_Sent'];
$varMailSentDeclinedCount						= $varStatisticsInfo['Mail_Declined_Sent'];

$objProductFacebook->clsTable					= 'mailfolderinfo';
$objProductFacebook->clsCountField				= 'Folder_Id';
$objProductFacebook->clsPrimary					= array('MatriId');
$objProductFacebook->clsPrimaryValue			= array($sessMatriId);
$objProductFacebook->clsFields					= array('Folder_Id', 'MatriId', 'Folder_Name');
$objProductFacebook->clsOrderBy					= array('Folder_Id');
$varFolderResults								= $objProductFacebook->multiSelectListSearchResult();

#DISPLAY ORDER BY
if($vaSortBy=='2'){ $varOrderBy = 'Mail_Follow_Up'; }//if
else{ $varOrderBy = 'Date_Sent'; }//else
$objProductFacebook->clsOrderBy					= array($varOrderBy);

if($varStatisticsInfo['Mail_Read_Sent'] == '')
{
$varMailSentReadCount		= 0;
$varMailSentNotReadCount	= 0;
$varMailSentDeclinedCount	= 0;
$varMailSentRepliedCount	= 0;
}//if
#------------------------------------------------------------------------------------------------------
?>
<script language="javascript" src="<?=$confServerURL?>/my-messages/includes/message-sent.js" type="text/javascript"></script>
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argSpanId,argPhotoName)
	{
		argPlaceHolderId="id"+argSpanId;
		document[argPlaceHolderId].src = '../membersphoto/'+argPhotoName;
	}//showPhoto
	function doProductNext(argPgNum)
	{
		document.frmMessageSent.page.value = argPgNum;
		document.frmMessageSent.submit();
	}//funDoNextAdvanced
</script>
<!-- Heading Table starts here -->
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td valign="middle" class="grtxtbold1"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Personalized Messages - Sent</font></div>
		</td>
	</tr>
	<tr><td height="2"></td></tr>
	<tr><td class="smalltxt" style="padding-left:5px;">This folder displays the mails you've sent to other members.</td></tr>
	<tr><td height="10"></td></tr>
</table>
<!-- Heading Table ends here -->
<!-- Menu Table starts here -->
<!--View Similar Profiles starts here-->
<form name="frmViewSimilarProfiles" action="../search/index.php" target="_blank" method="post" onSubmit="return false;">
<input type="hidden" name="act" value="star-search-results">
<input type="hidden" name="displayFormat" value="B">
<input type="hidden" name="gender" value="<?=$sessGender==2 ? 1 : 2;?>">
<input type="hidden" name="religion">
<input type="hidden" name="caste">
<input type="hidden" name="star">
<input type="hidden" name="city">
<input type="hidden" name="viewSimilarMatriId">
<input type="hidden" name="page" value="1">
</form>
<!--View Similar Profiles ends here-->
<table border=0 cellspacing=0 cellpadding="0" width="100%">
<!-- form starts here -->
<form name="frmMessageSent" method="post" onSubmit="return false;" align="center">
<input type="hidden" name="frmMessageSentSubmit" value="yes">
<input type="hidden" name="doAction">
<input type="hidden" name="fid" value="">
<input type="hidden" name="messageIds" value="">
<input type="hidden" name="page" value="<?=$pageNum?>">
<input type="hidden" name="rid" value="<?=$varReceiverStatus?>">
	<tr>
		<td valign="top">
			<table class="memonlsbg4" border="0" cellspacing=0 cellpadding="0" width="98%" align="center" style="border:solid 1px #C3E07B">
				<tbody><tr><td colspan="2" height="5"></td></tr>
					<tr class="smallttxtnormal">
					<td align="center" width="20" style="padding-top:5px">*</td>
					<td valign="middle"><b>Read :</b> This folder displays the mails sent by you, which the members have read.</td>
					</tr>
					<tr class="smallttxtnormal">
					<td align="center" width="20" style="padding-top:5px">*</td>
					<td valign="middle"><b>Not Read :</b> This folder displays the mails sent by you, which the members have not read.</td>
					</tr>
					<tr class="smallttxtnormal">
					<td align="center" width="20" style="padding-top:5px">*</td>
					<td valign="middle"><b>Declined :</b> This folder displays the mails sent by you, which the members have declined.</td>
					</tr>				
				</tbody>
			</table>
		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr><td>
	<table class="memonlsbg4" border="0" cellspacing=0 cellpadding="0" height="20" style="border:solid 1px #C3E07B" width="98%" align="center">
		<tr>
			<td valign="middle" width="145"><font class="smallttxtnormal">&nbsp;&nbsp;&nbsp;<a href="message-received.php" class="smalltxt" style="text-decoration:none"><b>Messages Received</b></a>&nbsp;|</font></td>
			<td valign="middle" width="100"><font class="smallttxtnormal"><a href="message-sent.php" class="smalltxt" style="text-decoration:none">Messages Sent</a></font></td>
			<td valign="middle" class="smallttxtnormal" width="350" align="right"></td>
		</tr>
	</table><br>
	</td></tr>
	<tr><td height="10"></td></tr>
	<tr>
	<td valign="top">
	<!--Mail Sent count starts here -->
	<table bgcolor="#FFFFFF" border="0" cellspacing=0 cellpadding="0" width="98%" align="center">
		<tr>
			<td valign="top" width="190"><img src="<?=$confServerURL?>/images/trans.gif" height="21" border="0"></td>
			<td valign="top">
				<? if ($varReceiverStatus==2) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:80px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Replied (<b><?= $varMailSentRepliedCount?></b>)</font></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
				<?php }else { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:80px;text-align:center"><a href="message-sent.php?rid=2" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Replied (<b><?= $varMailSentRepliedCount?></b>)</font></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21" border="0"></a></div>
				<?php
				}
				//if?>
			</td>
			<td valign="top">
				<? if ($varReceiverStatus==1) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:80px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Read (<b><?= $varMailSentReadCount?></b>)</font></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
				<?php }else { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:80px;text-align:center"><a href="message-sent.php?rid=1" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Read (<b><?= $varMailSentReadCount?></b>)</font></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21" border="0"></a></div>
				<?php
				}
				//if?>
			</td>
			<td valign="top">
				<? if ($varReceiverStatus==0) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:100px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Not Read (<b><?= $varMailSentNotReadCount?></b>)</font></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
				<?php }else { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:100px;text-align:center"><a href="message-sent.php?rid=0" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Not Read (<b><?= $varMailSentNotReadCount?></b>)</font></a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
				<?php }//else?>
			</td>
			<td valign="top" align="right">
				<? if ($varReceiverStatus==3) { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;width:95px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff">Declined (<b><?= $varMailSentDeclinedCount?></b>)</font></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
				<?php }else { ?>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:95px;text-align:center"><a href="message-sent.php?rid=3" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Declined(<b><?= $varMailSentDeclinedCount?></b>)</font></a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
				<?php }//else?>
			 </td>
		</tr>
	</table>
	<!--Mail Sent count ends here -->
   </td>
</tr>
<?php
$objProductFacebook->clsMemberYouContacted	= "Opposite_MatriId";
if ($varReceiverStatus==1)
{
	$objProductFacebook->clsDisplayMessage	= "Currently you have no messages in your 'Read' Folder"; 
	$varNoOfRecords							= $varMailSentReadCount;
}//Get Read Records
elseif ($varReceiverStatus==2)
{
	$objProductFacebook->clsDisplayMessage	= "Currently you have no messages in your 'Replied' Folder"; 
	$varNoOfRecords							= $varMailSentRepliedCount;
}//Get Read Records
elseif ($varReceiverStatus==0)
{
	$objProductFacebook->clsDisplayMessage	= "Currently you have no messages in your 'Not Read' Folder";
	$varNoOfRecords							= $varMailSentNotReadCount;
}//Get Not Read Records
elseif ($varReceiverStatus==3)
{
	$objProductFacebook->clsDisplayMessage	= "Currently you have no messages in your 'Declined' Folder"; 
	$varNoOfRecords							= $varMailSentDeclinedCount;
}//Get Declined Records
$varCurrentPage								= $pageNum;
$varNumOfPages								= ceil($varNoOfRecords/$objProductFacebook->clsLimit);
?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="border:solid 1px #C3E07B";>
	<?php if($varNoOfRecords > 0) { ?>
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" align=center class="memonlsbg4" height="30">
				<td valign="middle" width="75%" height="20">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td valign="middle" width=15>
											<input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.interestSent,this.form.checkName,'0');">
										</td>
										<td valign="middle"><input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="5" border="0" onClick="funConfirmMessage(this.form,this.form.interestSent,1);"></td>
										<td valign="middle" class="smallttxtnormal" width="350" align="right">&nbsp;&nbsp;</td>
									</tr>
								</table>
					</td>
					<td width="25%"><table border="0" cellpadding="0" cellspacing="0" width="100%">
					<!-- page navigation starts here -->
						<?=$objProductFacebook->pageNavigation($varNoOfRecords, $varCurrentPage, $varNumOfPages, "yes")?>
					<!-- page navigation ends here -->
				</table>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="15"></td></tr>
	<?php }//if?>
	<tr>
		<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
			<?php
			if($varNoOfRecords > 0)
			{
				$objProductFacebook->clsTable			= 'mailsentinfo';
				$objProductFacebook->clsPrimaryKey		= array('AND');
				$objProductFacebook->clsPrimary			= array('eii.MatriId', 'Status');
				$objProductFacebook->clsPrimaryValue	= array($sessMatriId, $varReceiverStatus);
				$objProductFacebook->clsFields			= array('eii.Mail_Id AS Mail_Id','eii.Opposite_MatriId AS Exp_MatriId', 'eii.Date_Sent AS Exp_Date_Updated','eii.Mail_Message AS InterestMessage', 'Date_Read', 'Date_Declined');
				$objProductFacebook->listMyMessage('MS');
			}
			else
			{
				$funDisplay .= '<tr><td align="center" valign="middle" class="errorMsg" height="30">';
				$funDisplay .= $objProductFacebook->clsDisplayMessage;
				$funDisplay .= '</td></tr>';
				echo $funDisplay;
			}
			?>
		</table>
		</td>
	</tr>
<?php if($varNoOfRecords > 0) {?>	
<tr><td>
<!-- Action Table starts here -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" align=center class="memonlsbg4" height="30">
<tr>
	<td valign="middle" width="75%" height="20">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td valign="middle" width=15>
								<input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.interestSent,this.form.checkName,'1');">
							</td>
							<td valign="middle"><input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="5" border="0" onClick="funConfirmMessage(this.form,this.form.interestSent,1);"></td>
							<td valign="middle" class="smallttxtnormal" width="350" align="right">&nbsp;&nbsp;</td>
						</tr>
					</table>
	</td>
	<td width="25%">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<!-- page navigation starts here -->
			<?=$objProductFacebook->pageNavigation($varNoOfRecords, $varCurrentPage, $varNumOfPages, "yes")?>
		<!-- page navigation ends here -->
		</table>
	</td>
</tr>
</table>
<!-- Action Table ends here -->
</td></tr>
<?php }//if ?>
<!-- form starts here -->
</form>
</table>
</td></tr>
</table><br>
<?php
//UNSET OBJECT
unset($objProductFacebook);
?>