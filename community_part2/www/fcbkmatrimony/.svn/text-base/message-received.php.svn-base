<?php
//FILE INCLUDES
require_once('header.php');
require_once('navinc.php');

//OBJECT DECLARTION
$objProductFacebook = new QuickSearch;

//VARIABLE DECLARATION
if($_REQUEST['page'] == "") { if($_REQUEST['pg'] == ""){ $pageNum = 1; }else{ $pageNum = $_REQUEST['pg']; } }
else{ $pageNum = $_REQUEST['page']; }

$objProductFacebook->clsStart			= ($pageNum-1) * $objProductFacebook->clsLimit;
$varCurrentDate							= date('Y-m-d H:i:s');
$objProductFacebook->clsPrimaryKey		= array('AND','AND');
$objProductFacebook->clsPrimarySymbol	= array('=','=','=');
$varMailStatus							= $_REQUEST["status"] ? $_REQUEST["status"] : "0";
$varChangeStatus						= '';
$objProductFacebook->clsTable			= 'mailreceivedinfo';
$objProductFacebook->clsCountField		= 'Mail_Id';
$objProductFacebook->clsSessionMatriId	= $sessMatriId;
$objProductFacebook->clsDisplayMsgFlag	= 1;
$varFolderId							= $_REQUEST['fid'];
$vaSortBy								= $_REQUEST['sort'];
$varDoAction							= $_REQUEST['doAction'];
$varMoveToFolder						= $_REQUEST['moveToFolder'];
$varMarkStatus							= 'no';
$varSubtractCountField					= '';
$objProductFacebook->clsSessionGender	= $sessGender;

//GET DELETE STATUS 
switch ($varMailStatus)
{
	case 0: $varChangeStatus = 6; 
			$objProductFacebook->clsDisplayMessage	= "Currently you have no New Mail messages";
			$varSubtractCountField					= 'Mail_UnRead_Received';
			break;

	case 1: $varChangeStatus = 7; 
			$objProductFacebook->clsDisplayMessage	= "Currently you have no Not Replied messages";
			$varSubtractCountField					= 'Mail_Read_Received';
			break;
	
	case 2: $varChangeStatus = 8;
			$objProductFacebook->clsDisplayMessage	= "Currently you have no Replied messages";
			$varSubtractCountField					= 'Mail_Replied_Received';
			break;

	case 3: $varChangeStatus = 9; 
			$objProductFacebook->clsDisplayMessage	= "Currently you have no Declined messages";
			$varSubtractCountField					= 'Mail_Declined_Received';
			break;
}//switch

if($vaSortBy=="1"){ $varOrderBy	= 'Status'; }//if
elseif($vaSortBy=="2"){ $varOrderBy	= 'Mail_Follow_Up'; }//else if
else{ $varOrderBy	= 'Date_Received'; }//else
$objProductFacebook->clsOrderBy		= array($varOrderBy);
if ($_REQUEST["frmMessageReceivedSubmit"]=="yes")
{
	$varmessageIds				= explode(",",substr($_POST['messageIds'],0,-1));
	$objProductFacebook->clsPrimary	= array('Mail_Id');
	
	// FOR MOVE MAIL ONE FOLDER TO ANOTHER
	if ($varMoveToFolder =='yes')
	{
		$objProductFacebook->clsFields				= array('Mail_Folder');
		$objProductFacebook->clsFieldsValues		= array($varFolderId);
	}//if
	else
	{
		if ($varDoAction=='SetFlag')
		{
			$objProductFacebook->clsFields			= array('Mail_Follow_Up');
			$objProductFacebook->clsFieldsValues	= array(1);
			$varFolderId							= $_GET["fid"];
		} //Set Flag
		else if ($varDoAction=='ClearFlag')
		{ 
			$objProductFacebook->clsFields			= array('Mail_Follow_Up');
			$objProductFacebook->clsFieldsValues	= array(0);
			$varFolderId							= $_GET['fid'];
		} //Clear Flag
		else if ($varDoAction=='Unread')
		{
			$objProductFacebook->clsFields			= array('Status','Message_Read');
			$objProductFacebook->clsFieldsValues	= array(0,1);
		} //Unread
		else if ($varDoAction==1)
		{
			$objProductFacebook->clsFields			= array('Status','Message_Read');
			$objProductFacebook->clsFieldsValues	= array(1,1);
		}//Mark as Read
		else
		{
			if($varDoAction == '')
			{
				//DELETE MESSAGES - CHANGE Status 
				$varMarkStatus						= 'yes';
			}
			else
			{
				$objProductFacebook->clsFields		= array('Status'); 
				$objProductFacebook->clsFieldsValues= array($_REQUEST['status']?$_REQUEST['status']:$varDoAction);
			}//else
		}//else
	}//else

	#SEND MAIL CODE
	if ($varDoAction=='sendMail')
	{
		$objProductFacebook->clsTable				= 'memberlogininfo';
		$objProductFacebook->clsCountField			= 'MatriId';
		$objProductFacebook->clsFields				= array('User_Name','Email');
		$objProductFacebook->clsPrimary				= array('MatriId');
		$objProductFacebook->clsPrimaryValue		= array($sessMatriId);
		$objProductFacebook->clsOrderBy				= array();
		$varReceiverInfo							= $objProductFacebook->selectListSearchResult();
		$varTo										= $varReceiverInfo['User_Name'];
		$varToEmailAddress							= $varReceiverInfo['Email'];

		for($i=0; $i<count($varmessageIds); $i++)
		{
			$objProductFacebook->clsTable			= 'mailreceivedinfo';
			$objProductFacebook->clsCountField		= 'Mail_Id';
			$objProductFacebook->clsFields			= array('Mail_Message','Date_Forwarded','MatriId');
			$objProductFacebook->clsPrimary			= array('Mail_Id');
			$objProductFacebook->clsPrimaryValue	= array($varmessageIds[$i]);
			$varSenderMailInfo						= $objProductFacebook->selectListSearchResult();
			$varMessage								= $varSenderMailInfo['Mail_Message'];
			$varDateForwarded						= $varSenderMailInfo['Date_Forwarded'];
			$varSenderMatriId						= $varSenderMailInfo['MatriId'];

			$objProductFacebook->clsTable			= 'memberlogininfo';
			$objProductFacebook->clsCountField		= 'MatriId';
			$objProductFacebook->clsFields			= array('User_Name','Email');
			$objProductFacebook->clsPrimary			= array('MatriId');
			$objProductFacebook->clsPrimaryValue	= array($varSenderMatriId);
			$varSenderInfo							= $objProductFacebook->selectListSearchResult();
			$varFrom								= $varSenderInfo['User_Name'];
			$varFromEmailAddress					= $varSenderInfo['Email'];
			$varSubject								= 'You have a forward from '.$varFrom;


			$varMessage	='<table><tr><td class="smalltxt">From: '.$varFrom.'</td></tr><tr><td class="smalltxt">To: '.$varTo.'</td></tr><tr><td class="smalltxt">Date: '.$varDateForwarded.'</td></tr><br><tr><td class="smalltxt">Hi,</td></tr><br><tr><td class="smalltxt">'.$varMessage.'</td></tr></table>'; 
			$varSendMail = $objProductFacebook->sendEmail($varFrom,$varFromEmailAddress,$varTo,$varToEmailAddress,$varSubject,$varMessage);
		
		}//for

	}//if

	//UPDATE STATUS
	$varUpdateFields		= $objProductFacebook->clsFields;
	$varUpdateFieldsValues	= $objProductFacebook->clsFieldsValues;
	
	for($i=0; $i<count($varmessageIds); $i++)
	{
		$objProductFacebook->clsTable			= 'mailreceivedinfo';
		$objProductFacebook->clsPrimary			= array('Mail_Id');
		$objProductFacebook->clsPrimaryValue	= array($varmessageIds[$i]);
		$objProductFacebook->clsFieldsValues	= $varUpdateFieldsValues;
		$objProductFacebook->clsFields			= $varUpdateFields;
		if($varDoAction== 'ClearFlag' || $varDoAction=='SetFlag' || $varMoveToFolder =='yes')
		{ 
			$objProductFacebook->updateQuickSearch();
		}//if
		elseif($varDoAction == 'Unread' || $varDoAction == 1 || $varMarkStatus =='yes') 
		{
			$varPrevStatus		= '';
			$varSubtractField   = '';
			$objProductFacebook->clsFields= array('Opposite_MatriId','Message_Read','Status','Sender_Deleted');
			$varSelectStatus		= $objProductFacebook->selectListSearchResult();
			$varPrevStatus			= $varSelectStatus['Status'];
			$varPrevReadStatus		= $varSelectStatus['Message_Read'];
			$varOppositeMatriId		= $varSelectStatus['Opposite_MatriId'];
			$varSenderDeleted		= $varSelectStatus['Sender_Deleted'];
			
			//CHECK ALREADY READ MAIL OR NOT
			if($varDoAction == 1 && $varPrevReadStatus == 0)
			{
				$objProductFacebook->clsFields	   = array('Status','Message_Read');
				$objProductFacebook->clsFieldsValues = array(1,1);
			}//if
			elseif($varDoAction == 1 || $varDoAction == 'Unread')
			{
				$objProductFacebook->clsFields	   = array('Status','Message_Read');
				if($varPrevStatus == 2 && $varDoAction == 1)
				{
					$objProductFacebook->clsFieldsValues	= array(2,1);
				}//if
			}//elseif
			elseif($varMarkStatus == 'yes')
			{
				//DELETE MESSAGES 
				$objProductFacebook->clsFields		= array('Mail_Folder','Status','Date_Deleted');
				$objProductFacebook->clsFieldsValues	= array('0',$varChangeStatus,$varCurrentDate);
			}
			
			//IF change unread messages as mark as read we should not update in to table 
			if(($varDoAction=='Unread') && ($varPrevStatus==0))
			{
				$varAffectedRows = 0;
			}
			elseif(($varDoAction==1) && ($varPrevStatus==1 || $varPrevStatus==2))
			{
				$varAffectedRows = 0;
			}
			else
			{
				//UPDATE STATUS HERE
				$varAffectedRows = $objProductFacebook->updateQuickSearch();
			}
			
			if($varAffectedRows > 0 )
			{
				switch($varPrevStatus)
				{
					case 0: $varSubtractField = 'Mail_UnRead_Received'; break;
					case 1: $varSubtractField = 'Mail_Read_Received'; break;
					case 2: $varSubtractField = 'Mail_Replied_Received'; break;
					case 3: $varSubtractField = 'Mail_Declined_Received'; break;
				}
				//CHEANGE UNREAD / READ COUNT IN memberstatistics
				$objProductFacebook->clsTable				= 'memberstatistics';
				$objProductFacebook->clsPrimary				= array('MatriId');
				$objProductFacebook->clsPrimaryValue		= array($sessMatriId);
				
				if($varDoAction == 'Unread')
				{
					$objProductFacebook->clsFields			= array('Mail_UnRead_Received',$varSubtractField);
					$objProductFacebook->clsFieldsValues	= array('Mail_UnRead_Received+1',"$varSubtractField-1");
				}
				elseif($varDoAction == 1)
				{
					$objProductFacebook->clsFields			= array($varSubtractField,'Mail_Read_Received');
					$objProductFacebook->clsFieldsValues	= array("$varSubtractField-1",'Mail_Read_Received+1');
				}//elseif
				elseif($varMarkStatus=="yes")
				{
					$objProductFacebook->clsFields			= array($varSubtractCountField);
					$objProductFacebook->clsFieldsValues	= array("$varSubtractCountField-1");
				}//elseif

				$objProductFacebook->updateMyMessageCount();

				//Mark as Read - applied for unread messages 
				if(($varDoAction==1)&&($varPrevReadStatus==0)&&($varSenderDeleted==0)&&($varPrevStatus==0))
				{
					//UPDATE COUNT IN SENDER SIDE
					$objProductFacebook->clsPrimaryValue	= array($varOppositeMatriId);
					$objProductFacebook->clsFields			= array('Mail_Read_Sent','Mail_UnRead_Sent');
					$objProductFacebook->clsFieldsValues	= array('Mail_Read_Sent+1','Mail_UnRead_Sent-1');
					$objProductFacebook->updateMyMessageCount();

					//UPDATE STATUS IN mailsentinfo
					$objProductFacebook->clsTable			= 'mailsentinfo';
					$objProductFacebook->clsPrimary			= array('Mail_Id');
					$objProductFacebook->clsPrimaryValue	= array($varmessageIds[$i]);
					$objProductFacebook->clsFields			= array('Status');
					$objProductFacebook->clsFieldsValues	= array(1);
					$objProductFacebook->updateQuickSearch();
				}//if
			}//if
		}//elseif
	}//for
}//if

$objProductFacebook->clsTable				= "mailreceivedinfo";
$objProductFacebook->clsOrderBy				= array($varOrderBy);
$varMoveFolderPrimaryValue					= $varFolderId ? $varFolderId : 0;
$objProductFacebook->clsCountField			= 'Mail_Id';
$objProductFacebook->clsFields				= array('Mail_Follow_Up','Mail_Id','Opposite_MatriId','Mail_Message','Date_Received');
$objProductFacebook->clsFieldsToDisplay		= array('Mail_Follow_Up','Mail_Id','Opposite_MatriId', 'Mail_Message','Date_Received');
$objProductFacebook->clsPrimary				= array('MatriId','Mail_Folder','Status');
$objProductFacebook->clsPrimaryKey			= array('AND','AND');
$objProductFacebook->clsPrimarySymbol		= array('=','=','=');

if($varMailStatus == 0)
{
	$objProductFacebook->clsPrimaryValue	= array($sessMatriId,$varMoveFolderPrimaryValue,0);
}//if
else
{
	$objProductFacebook->clsPrimaryValue	= array($sessMatriId,$varMoveFolderPrimaryValue,$varMailStatus);
}//else

if($varMailStatus==0 || $varMailStatus==1)
{
	$objProductFacebook->clsListTemplate	= '';
	$varMessageReceivedResult				= $objProductFacebook->listMail($varMailStatus);
}
else
{
	$varMessageReceivedResult				= 'yes';
}
$objProductFacebook->clsTable				= 'mailfolderinfo';
$objProductFacebook->clsCountField			= 'Folder_Id';
$objProductFacebook->clsStart				= '';
$objProductFacebook->clsLimit				= '';
$objProductFacebook->clsPrimary				= array('MatriId');
$objProductFacebook->clsPrimaryValue		= array($sessMatriId);
$objProductFacebook->clsFields				= array('Folder_Id', 'MatriId', 'Folder_Name');
$objProductFacebook->clsOrderBy				= array('Folder_Id');
$varNoOfFolders								= $objProductFacebook->numOfResults();
if($varNoOfFolders > 0)
{
	$varFolderResults	= $objProductFacebook->multiSelectListSearchResult();

	//IF FolderId DIDN'T MENTIONED ASSIGN INBOX VALUE
	if($varFolderId == ''){ $varFolderId = 0; }//if
	
	$objProductFacebook->clsTable			= 'mailreceivedinfo';
	$objProductFacebook->clsCountField		= 'Mail_Id';
	$objProductFacebook->clsPrimary			= array('Mail_Folder','Status','MatriId');
	
	//GET UNREAD MAIL COUNT
	$objProductFacebook->clsPrimaryValue	= array($varFolderId,0,$sessMatriId);
	$varNewMessageCount						= $objProductFacebook->numOfResults();

	//GET UNREPLIED MAIL COUNT
	$objProductFacebook->clsPrimaryValue	= array($varFolderId,1,$sessMatriId);
	$varNotRepliedCount						= $objProductFacebook->numOfResults();

	//GET REPLIED MAIL COUNT
	$objProductFacebook->clsPrimaryValue	= array($varFolderId,2,$sessMatriId);
	$varRepliedCount						= $objProductFacebook->numOfResults();
	
	//GET DECLINED MAIL COUNT
	$objProductFacebook->clsPrimaryValue	= array($varFolderId,3,$sessMatriId);
	$varDeclineCount						= $objProductFacebook->numOfResults();
}
else
{
	//Select Count Details from memberstatistics
	$objProductFacebook->clsTable			= 'memberstatistics';
	$objProductFacebook->clsFields			= array('Mail_Read_Received','Mail_UnRead_Received','Mail_Replied_Received','Mail_Declined_Received');
	$objProductFacebook->clsTable			= 'memberstatistics';
	$objProductFacebook->clsPrimary			= array('MatriId'); 
	$objProductFacebook->clsPrimaryValue	= array($sessMatriId);
	$objProductFacebook->clsOrderBy			= array();
	$varStatisticsInfo						= $objProductFacebook->selectListSearchResult();

	$varNewMessageCount = $varStatisticsInfo['Mail_UnRead_Received'];
	$varNotRepliedCount = $varStatisticsInfo['Mail_Read_Received'];
	$varRepliedCount	= $varStatisticsInfo['Mail_Replied_Received'];
	$varDeclineCount	= $varStatisticsInfo['Mail_Declined_Received'];
	if($varStatisticsInfo['Mail_UnRead_Received'] == '')
	{
		$varNewMessageCount = 0;
		$varNotRepliedCount = 0;
		$varRepliedCount	= 0;
		$varDeclineCount	= 0;
	}
}//else

//GET NO OF RECORDS STATUS 
switch ($varMailStatus)
{
	case 0: $varNoOfRecords = $varNewMessageCount; break;

	case 1: $varNoOfRecords = $varNotRepliedCount; break;
	
	case 2: $varNoOfRecords = $varRepliedCount; break;

	case 3: $varNoOfRecords = $varDeclineCount; break;
}
#select folder name
if ($varFolderId !="")
{
	$objProductFacebook->clsTable			= 'mailfolderinfo';
	$objProductFacebook->clsPrimary			= array('Folder_Id');
	$objProductFacebook->clsPrimaryValue	= array($varFolderId);
	$objProductFacebook->clsFields			= array('Folder_Name');
	$varFolderInfo							= $objProductFacebook->selectListSearchResult();
	$varFolderName							= $varFolderInfo["Folder_Name"];
}//if
#get inbox count
$objProductFacebook->clsTable				= 'mailreceivedinfo';
$objProductFacebook->clsCountField			= 'Mail_Id';
$objProductFacebook->clsPrimary				= array('MatriId','Mail_Folder','Status');
$objProductFacebook->clsPrimaryKey			= array('AND','AND');
$objProductFacebook->clsPrimarySymbol		= array('=','=','<');
$objProductFacebook->clsPrimaryValue		= array($sessMatriId,0,4);
$varInboxCount		= $objProductFacebook->numOfResults();
//CALCULATE NO OF PAGES
$varCurrentPage		= $pageNum;
$varNumOfPages		= ceil($varNoOfRecords/10);
#------------------------------------------------------------------------------------------------------
?>
<script language="javascript" src="<?=$confServerURL?>/my-messages/includes/mail-received.js"></script>
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argSpanId,argPhotoName)
	{
		argPlaceHolderId="id"+argSpanId;
		document[argPlaceHolderId].src = '../membersphoto/'+argPhotoName;
	}//showPhoto
	function doProductNext(argPgNum)
	{
		document.frmMessageReceived.page.value = argPgNum;
		document.frmMessageReceived.submit();
	}//funDoNextAdvanced

</script>
<!-- Heading Table starts here -->
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td valign="middle" class="grtxtbold1"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Personalized Messages Received</font></div></td>
	</tr>
	<tr><td height="2"></td></tr>
	<tr><td class="smalltxt" style="padding-left:5px">This folder displays the mails you've received from members.</td></tr>
	<tr><td height="10"></td></tr>
</table>
<!-- Heading Table Ends here -->
<!-- Menu Table starts here -->
<table  border="0" cellspacing="0" cellpadding="0" width="100%">
<!-- form starts here -->
<form name="frmMessageReceived" method="post" onSubmit="return false;">
<input type="hidden" name="frmMessageReceivedSubmit" value="yes">
<input type="hidden" name="doAction">
<input type="hidden" name="pfid" value="">
<input type="hidden" name="fid" value="<?=$varFolderId?>">
<input type="hidden" name="moveToFolder" value="">
<input type="hidden" name="messageIds" value="">
<input type="hidden" name="page" value="<?=$pageNum?>">
	<tr>
		<td valign="top">
			<table class="memonlsbg4" border="0" cellspacing=0 cellpadding="0" width="98%" style="border:solid 1px #C3E07B" align="center">
				<tbody><tr><td colspan="2" height="5"></td></tr>
				<tr class="smallttxtnormal">
				<td align="center" width="20" style="padding-top:5px">*</td>
				<td valign="middle"><b>New Mail :</b> This folder displays your unread mails. Please read and reply at the earliest.</td>
				</tr>
				<tr class="smallttxtnormal">
				<td align="center" width="20" valign="middle" style="padding-top:5px">*</td>
				<td valign="middle"><b>Not Replied :</b> This folder displays the mails you've read but haven't replied.</td>
				</tr>
				<tr class="smallttxtnormal">	
				<td align="center" width="20" valign="middle" style="padding-top:5px">*</td>
				<td valign="middle"><b>Replied :</b> This folder displays the mails you've read and replied.</td>
				</tr>

				<tr class="smallttxtnormal">
				<td align="center" width="20" valign="middle" style="padding-top:5px">*</td>
				<td valign="middle"><b>Declined :</b> This folder displays the mails you've read and declined.</td>
				</tr>
				<tr><td colspan="2" height="5"></td></tr>
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
	<tr><td valign="top" width="98%">
	<!--Mail Received count starts here -->
	<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
	<tr>
		<td valign="top" width="160" class="smalltxt"><b><?=$varFolderName ? "Selected Folder: ".$varFolderName : "";?> </b><img src="<?=$confServerURL?>/my-messages/images/trans.gif" height="21" border="0"></td>
		<td valign="top" align="right">
			<? if ($varMailStatus==0) { ?>
			<div style="float:left;height:21px">
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:97px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">New Mail (<b><?=$varNewMessageCount?></b>)</font></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else { ?>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:97px;text-align:center"><a href="message-received.php?status=0&fid=<?=$varFolderId;?>" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">&nbsp;New Mail (<b><?=$varNewMessageCount?></b>)</font></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21" border="0"></a></div></div>
			<?php
			}
			//if?>
		</td>
		<td valign="top" align="right">
			<? if ($varMailStatus==1) { ?>
			<div style="float:left;height:21px">
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:117px !important;width:122px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Not Replied (<b><?=$varNotRepliedCount?></b>)</font></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else { ?>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:117px !important;width:122px;text-align:center"><a href="message-received.php?status=1&fid=<?=$varFolderId;?>&did=7" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Not Replied (<b><?=$varNotRepliedCount?></b>)</font></a></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			<?php }//else?></div>
		</td>
		<td valign="top" align="right">
			<? if ($varMailStatus==2) { ?>
			<div style="float:left;height:21px">
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;width:97px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff">Replied (<b><?=$varRepliedCount?></b>)</font></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else { ?>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:97px;text-align:center"><a href="message-received.php?status=2&fid=<?=$varFolderId;?>&did=8" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Replied (<b><?=$varRepliedCount?></b>)</font></a></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			<?php }//else?></div>
		 </td>
		<td valign="top" align="right">
			<? if ($varMailStatus==3) { ?>
			<div style="float:left;height:21px">
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;width:97px;text-align:center"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff">Declined (<b><?=$varDeclineCount?></b>)</font></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			<?php }else { ?>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
			<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:97px;text-align:center"><a href="message-received.php?status=3&fid=<?=$varFolderId;?>&did=9" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Declined (<b><?=$varDeclineCount?></b>)</font></a></div>
			<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			<?php }//else?></div>
		 </td>
		 <td width="5"></td>
	</tr>
</table>
<!--Mail Received count ends here -->
<!-- Message Sent Results Starts Here -->
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="formborderclr" align="center">
	<?php if ($varMessageReceivedResult !="no") { ?>
	<tr>
		<td>
			<table width="100%" cellspacing="3" cellpadding="3" align="center" class="memonlsbg4">
				<?if($varMailStatus==0 || $varMailStatus==1){?>
				<tr>
					<td width="5"></td>
					<td class="smalltxt" width="100" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Username</b></td>
					<td class="smalltxt" width="280" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Message</b></td>
					<td class="smalltxt" width="170" align="center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received Date</b></td>
				</tr>
				<?}elseif($varNoOfRecords > 0){?>
				<tr>
					<td width="100%">&nbsp;</td>
				</tr>
				<?}?>
			</table>
		</td>
	</tr>
	<?php }//if ?>
	<tr>
		<td class="errorMsg" valign="middle" align="center">
		<br>
			<?php
				if ($varNoOfRecords == 0) { echo $objProductFacebook->clsDisplayMessage;}//if
				else
				{
					if($varMailStatus==0 || $varMailStatus==1)
					{
						echo $varMessageReceivedResult;
					}
					else
					{
					$objProductFacebook->clsMemberYouContacted = 'Opposite_MatriId';
					$objProductFacebook->clsLimit			= 10;
					$objProductFacebook->clsStart			= ($pageNum-1) * $objProductFacebook->clsLimit;
					$objProductFacebook->clsPrimary		= array('eii.MatriId','Mail_Folder','Status');
					$objProductFacebook->clsPrimaryValue	= array($sessMatriId,$varMoveFolderPrimaryValue,$varMailStatus);
					$objProductFacebook->clsOrderBy		= array('Date_Received');
					$objProductFacebook->clsInterestActivity1 = ($varMailStatus==2)?'Decline':'Reply';
					$objProductFacebook->clsInterestActivity3 = ($varMailStatus==2)?'declineMessage':'funReply';
					$objProductFacebook->clsPlaceHolders	= array('<--MESSAGE-ID-->','<--MATRIMONY-ID-->','<--USERNAME-->','<--FORM-NAME-->', '<--CHECKBOX-NAME-->', '<--PHOTOS-->', '<--AGE-->', '<--HEIGHT-->', '<--RELIGION-->',  '<--SUB-CASTE-->', '<--CITY-->', '<--COUNTRY-->', '<--EDUCATION-->', '<--OCCUPATION-->', '<--DESCRIPTION-->','<--SIMILAR-PROFILE-URL-->','<--FULL-MESSAGE-->', '<--INTEREST-MSG-->', '<--INTEREST-ACTIVITY3-->','<--INTEREST-ACTIVITY2-->','<--LAST-LOGIN-->', '<--RECEIVED-DATE-->','<--ADD-NOTES-->','<--ACCEPTED-DATE-->','<--LAST-ACTION-->','<--ONLINE-->');

					$objProductFacebook->clsPlaceHoldersValues	= array('Mail_Id','MatriId','Username','FormNmae','CheckBoxName','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','ViewSimilar','InterestMessage','InterestMessage','','','Last_Login','Date_Updated','Notes','Date_Deleted','Last_Action','Online');

					$objProductFacebook->clsTextConversion	= array('Mail_Id','MatriId','Username','FormNmae','CheckBoxName','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','ViewSimilar','InterestMessage','InterestMessage','','','Last_Login','Date_Updated','Notes','Date_Deleted','Last_Action','Online');

					//$objProductFacebook->clsFields	= array('Mail_Id','eii.Opposite_MatriId AS Exp_MatriId', 'eii.Date_Received AS Exp_Date_Updated', 'Age','Religion','Country', 'Last_Login','CONCAT(Height,\' ~\',Height_Unit) AS Height', 'CONCAT(Country,\'~\',Residing_State) AS Residing_City', 'Subcaste', 'About_Myself', 'Education_Category','Occupation','eii.Mail_Message AS InterestMessage','Date_Read','Notes', 'Date_Deleted','User_Name As Username','IF (Photo_Set_Status=1,IF (Protect_Photo_Set_Status=1,2,1),0) AS Photo','Publish');

					$objProductFacebook->clsFields	= array('Mail_Id','eii.Opposite_MatriId AS Exp_MatriId', 'eii.Date_Received AS Exp_Date_Updated','eii.Mail_Message AS InterestMessage', 'Date_Read','Notes', 'Date_Deleted');
					
					$objProductFacebook->clsListTemplate	= $objProductFacebook->getContentFromFile('templates/mail-received.tpl');
					$objProductFacebook->listMyMessage('MR');
					}
				}//else
			?>
		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
	<td>
<!-- Action Table starts here -->
<?php if($varNoOfRecords > 0) {?>
<!-- Action Table starts here -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" align=center class="memonlsbg4">
	<tr>
	<td valign="top" width="75%">
		<table border="0" cellpadding="0" cellspacing="0" class="memonlsbg4" width="100%">
			<tr>
				<td valign="middle"><input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.searchResults,this.form.checkName,'0');"></td>
				<td valign="top"><input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="5" border="0" onClick="funConfirmMessage(this.form,this.form.searchResults,1);"><input type="image" src="<?=$confServerURL?>/images/forwardtopersonalid-button.gif" vspace="5" hspace="0" border="0" onClick="funConfirmMessage(this.form,this.form.searchResults,2);"></td>
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
<?php }//if ?>
<!-- Action Table ends here -->
</td></tr>
<!-- form starts here -->
</form>
</table>
<br>
<?php

//UNSET OBJECT
unset($objProductFacebook);
?>