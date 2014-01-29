<?php
require_once('header.php');
require_once('navinc.php');

//OBJECT DECLARTION
$objProductFacebook = new QuickSearch;

//CONTROL STATEMENT
$varGetStatus	= $_GET['pageName']==""?"pending":$_GET['pageName'];
$varPageName	= $_GET['pageName']==""?"pending":$_GET['pageName'];

$varCurrentDate	= Date('Y-m-d H:i:s');
if($_REQUEST['page'] == '') { if($_REQUEST['pg'] == ''){ $pageNum = 1; }else{ $pageNum = $_REQUEST['pg']; } }
else{ $pageNum = $_REQUEST['page']; }

if ($_REQUEST['frmMessageSentSubmit']=='yes')
{
	$objProductFacebook->clsPrimaryKey	= array('AND');
	$varMessageIds = explode(",",substr($_REQUEST["messageIds"],0,-1));
	for ($i=0;$i<count($varMessageIds);$i++)
	{
		//SELECT INTEREST INFO BEFORE UPDATE Sender_Status
		$objProductFacebook->clsTable			= 'interestsentinfo';
		$objProductFacebook->clsPrimary		= array('Interest_Id');
		$objProductFacebook->clsPrimaryValue	= array($varMessageIds[$i]);
		$objProductFacebook->clsFields		= array('Status');
		$varInterestPrevInfo			= $objProductFacebook->selectListSearchResult();
				
		if(($varInterestPrevInfo['Status']!=5) && ($varInterestPrevInfo['Status'] !=''))
		{
			$objProductFacebook->clsFieldsValues	= array(5, $varCurrentDate);
			$objProductFacebook->clsFields		= array('Status', 'Date_Deleted');
			$objProductFacebook->updateQuickSearch();
			
			//UPDATE  DELETE STATUS INTO interestreceivedinfo
			$objProductFacebook->clsTable			= 'interestreceivedinfo';
			$objProductFacebook->clsFields		= array('Delete_Status');
			$objProductFacebook->clsFieldsValues	= array(1);
			$objProductFacebook->updateQuickSearch();

			//UPDATE ACCEPT COUNT IN memberstatistics
			#sender side only
			$objProductFacebook->clsTable			= "memberstatistics";
			$objProductFacebook->clsPrimary		= array('MatriId');
			$objProductFacebook->clsPrimaryValue	= array($sessMatriId);

			if($varInterestPrevInfo['Status'] == 0)
			{
				$objProductFacebook->clsFields		= array('Interest_Pending_Sent');	
				$objProductFacebook->clsFieldsValues	= array('Interest_Pending_Sent-1');
				$objProductFacebook->updateMyMessageCount();
			}
			elseif($varInterestPrevInfo['Status'] == 1)
			{
				$objProductFacebook->clsFields		= array('Interest_Accept_Sent');	
				$objProductFacebook->clsFieldsValues	= array('Interest_Accept_Sent-1');
				$objProductFacebook->updateMyMessageCount();
			}
			else
			{
				$objProductFacebook->clsFields		= array('Interest_Declined_Sent');	
				$objProductFacebook->clsFieldsValues	= array('Interest_Declined_Sent-1');
				$objProductFacebook->updateMyMessageCount();
			}
		}//if
	}//for
}//if

//Select Count Details from memberstatistics
$objProductFacebook->clsFields	= array('Interest_Pending_Sent', 'Interest_Accept_Sent', 'Interest_Declined_Sent');
$objProductFacebook->clsTable		= "memberstatistics";
$objProductFacebook->clsPrimary	= array('MatriId'); 
$objProductFacebook->clsPrimaryValue	= array($sessMatriId);
$varStatisticsInfo				= $objProductFacebook->selectListSearchResult();

$varNoOfPendingList = $varStatisticsInfo['Interest_Pending_Sent'];
$varNoOfAcceptList  = $varStatisticsInfo['Interest_Accept_Sent'];
$varNoOfDeclineList = $varStatisticsInfo['Interest_Declined_Sent'];

//SET ZERO FOR UNPUBLIHED USERS
if($varStatisticsInfo['Interest_Pending_Sent'] == '')
{
	$varNoOfPendingList = 0;
	$varNoOfAcceptList  = 0;
	$varNoOfDeclineList = 0;
}


if($varPageName == 'accept')
{
	$varSenderStatus	= 1;
	$varNoOfRecords		= $varNoOfAcceptList ;
}
elseif($varPageName == 'decline')
{
	$varSenderStatus	= 3;
	$varNoOfRecords		= $varNoOfDeclineList ;
}
else
{
	$varSenderStatus	= 0;
	$varNoOfRecords		= $varNoOfPendingList ;
}

$objProductFacebook->clsStart	= ($pageNum-1) * $objProductFacebook->clsLimit;

if ($varReceiverStatus != "0") { $objProductFacebook->clsInterestActivity1=""; }//if
else  { $objProductFacebook->clsLinkSymbol="yes"; }//if

$varNumOfPages		= ceil($varNoOfRecords/$objProductFacebook->clsLimit);

$varArrExpressInterest		= array(4=>"I am interested in your profile. If you are interested in my profile, please contact me.",5=>"I have gone through your details and feel we have lot in common.  Would sure like to know your opinion on this?",6=>"You are someone special I wish to know better. Please contact me at the earliest.",7=>"We found your profile to be a good match. Please contact us to proceed further.",8=>"You are the kind of person we were searching for. Please send us your contact details.");

$objProductFacebook->clsPlaceHolders	= array('<--MESSAGE-ID-->','<--MATRIMONY-ID-->', '<--USERNAME-->','<--INTEREST-MSG-->','<--DECLINED-MSG-->', '<--RECEIVED-DATE-->', '<--PHOTOS-->', '<--AGE-->', '<--HEIGHT-->', '<--RELIGION-->', '<--SUB-CASTE-->', '<--CITY-->', '<--COUNTRY-->', '<--EDUCATION-->', '<--OCCUPATION-->','<--DESCRIPTION-->', '<--SIMILAR-PROFILE-URL-->','<--INTEREST-ACTIVITY1-->', '<--INTEREST-ACTIVITY2-->','<--LAST-LOGIN-->','<--LAST-ACTION-->','<--ACCEPTED-DATE-->','<--ONLINE-->');

$objProductFacebook->clsPlaceHoldersValues	= array('Interest_Id','MatriId','Username','Interest_Option','Declined_Option','Date_Updated','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','ViewSimilar','Interest_Activity1','Interest_Activity2','Last_Login','Last_Action','Date_Accepted','Online');

$objProductFacebook->clsTextConversion	= array('Interest_Id','MatriId','Username','Interest_Option','Declined_Option','Date_Updated','Photo','Age','Height','Religion','Subcaste','Residing_City','Country','Education_Category','Occupation','About_Myself','ViewSimilar','Interest_Activity1','Interest_Activity2','Last_Login','Last_Action','Date_Accepted','Online');

$objProductFacebook->clsFields	= array('Interest_Id','Opposite_MatriId AS Exp_MatriId', 'Interest_Option', 'Declined_Option', 'eii.Date_Sent AS Exp_Date_Updated','Date_Accepted');

$objProductFacebook->clsTable		= 'interestsentinfo';

if ($varPageName == 'accept') //get accept list
{
	$objProductFacebook->clsDisplayMessage	= 'Currently you have no accepted salaams';
	$objProductFacebook->clsPrimary			= array('eii.MatriId', 'Status'); //Interest_Status 0=>Pending, 1=>Accepted, 2=>Declined
	$objProductFacebook->clsPrimaryValue		= array($sessMatriId, $varSenderStatus);
	$objProductFacebook->clsPrimaryKey		= array('AND');
	
}//if
else if ($varPageName == 'decline') //get decline list
{
	$objProductFacebook->clsAcceptMsg			= 'Declined on: ';
	$objProductFacebook->clsDisplayMessage	= 'Currently you have no declined salaams';
	$objProductFacebook->clsPrimary			= array('eii.MatriId','Status'); //Interest_Status 0=>Pending, 1=>Accepted, 2=>Declined
	$objProductFacebook->clsPrimaryValue		= array($sessMatriId, $varSenderStatus);
	$objProductFacebook->clsPrimaryKey		= array('AND');

}//else if
else  //get pending list
{
	$objProductFacebook->clsDisplayMessage	= 'Currently you have no pending salaams';
	$objProductFacebook->clsPrimary			= array('eii.MatriId','Status');//Interest_Status 0=>Pending, 1=>Accepted, 2=>Declined
	$objProductFacebook->clsPrimaryValue		= array($sessMatriId, $varSenderStatus);
	$objProductFacebook->clsPrimaryKey		= array('AND');

}//else

$objProductFacebook->clsFieldsToDisplay = array('MatriId', 'Opposite_MatriId', 'Interest_Option', 'Interest_Status');
#-----------------------------------------------------------------------------------------------------
?>
<script language="javascript" src="<?=$confServerURL?>/my-messages/includes/interest-sent.js" type="text/javascript"></script>
<script language="javascript">
	var argPlaceHolderId;
	function funShowPhoto(argSpanId, argPhotoName)
	{
		argPlaceHolderId='id'+argSpanId;
		document.getElementById(argPlaceHolderId).src = '../membersphoto/'+argPhotoName;
	}//showPhoto
</script>
<!-- Calling Ajax Function To Display Photo Ends Here -->
<!--View Similar Profiles starts here-->
<form name="frmViewSimilarProfiles" action="../search/index.php" target="_blank" method="post" onSubmit="return false;" style="display:none">
<input type="hidden" name="act" value="star-search-results">
<input type="hidden" name="displayFormat" value="B">
<input type="hidden" name="gender" value="<?=$sessGender==2 ? 1 : 2;?>">
<input type="hidden" name="religion">
<input type="hidden" name="caste">
<input type="hidden" name="star">
<input type="hidden" name="city">
<input type="hidden" name="viewSimilarMatriId">
<input type="hidden" name="page" value="1">
<input type="hidden" name="paidStatus" value="<?=$sessPaidStatus;?>">
<input type="hidden" name="sessGender" value="<?=$sessGender;?>">
</form>
<!--View Similar Profiles ends here-->
<!-- form starts here -->
<form name="frmMessageSent" method="post" onSubmit="return false;">
<div style="display:none">
<input type="hidden" name="frmMessageSentSubmit" value="yes">
<input type="hidden" name="act" value="interest-sent">
<input type="hidden" name="messageIds" value="">
<input type="hidden" name="page" value="1">
<input type="hidden" name="pageName" value="<?=$varGetStatus?>">
</div>
<!-- Heading Table starts here -->
<table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td>
			<div style="padding-left:5px;padding-top:5px;padding-bottom:0px;">
			<?php if($varPageName=="pending"){ ?>
			<font class="heading">Salaams Sent - Pending
			<?php }elseif($varPageName=="accept"){ ?>
			<font class="heading">Salaams Sent - Accepted
			<?php }else{ ?>
			<font class="heading">Salaams Sent - Declined
			<?php } ?>
			</div>
		<td>
	</tr>
</table>
<!-- Heading Table ends here -->

<!-- Content Table starts here -->
<table bgcolor="#ffffff" border=0 cellspacing=0 cellpadding="0" width="100%" align=center>
	<tr>
		<td valign="top">
		<?php if ($varPageName=="pending"){?>
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr><td valign="top" class="smalltxt"><p align="justify" style="line-height: 18px;">Listed below are members you have sent Salaams to and awaiting response from. Go ahead and send them a reminder.</p></td></tr>
			</table>
		<?}?>
		</td>
	</tr>
</table><br>
<!-- Content Table ends here -->
<!-- salaam received and salaam sent links starts here -->
<table class="memonlsbg4" border=0 cellspacing=0 cellpadding="0" height="20" style="border:solid 1px #C3E07B" width="98%" align="center">
	<tr>
		<td valign="middle" width="145"><font class="smallttxtnormal">&nbsp;&nbsp;&nbsp;<a href="interest-received.php" class="smalltxt" style="text-decoration:none">Salaams Received</a>&nbsp;|</font></td>
		<td valign="middle" width="100"><font class="smallttxtnormal"><a href="interest-sent.php" class="smalltxt" style="text-decoration:none"><b>Salaams Sent</b></a></font></td>
		<td valign="middle" class="smallttxtnormal" width="350" align="right">
		
		</td>
	</tr>
</table><br>

<!-- salaam received and salaam sent links ends here -->

<!-- pending,Accepted, declined menus starts here -->
<table bgcolor="#FFFFFF" border="0" cellspacing=0 cellpadding="0" width="98%" align="center">
	<tr>
		<td valign="top" width="280"><img src="<?=$confServerURL?>/images/trans.gif" height="21" border="0"></td>
		<td valign="top" align="left" width="100">
			<?php if ($varPageName=="pending") { ?>
			<div style="float:left;width:94;height:21px;text-align:center">
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:84px"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Pending (<b><?=$varNoOfPendingList?></b>)</div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			</div>
			<?php }else{ ?>
			<div style="float:left;width:94;height:21px;text-align:center">
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:84px"><a href="interest-sent.php?pageName=pending" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Pending (<b><?=$varNoOfPendingList?></b>)</a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			</div>
			<?php }?>
		</td>
		<td valign="top" width="98">
			<?php if ($varPageName=="accept") { ?>
			<div style="float:left;width:101;height:21px;text-align:center">
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:91px"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Accepted (<b><?=$varNoOfAcceptList?></b>)</div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
			</div>
			<?php }else{ ?>
			<div style="float:left;width:101;height:21px;text-align:center">
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:91px"><a href="interest-sent.php?pageName=accept" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Accepted (<b><?=$varNoOfAcceptList?></b>)</a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
			</div>
			<?php }?>	
		</td>
		<td valign="top" align="left"  width="85">
			<?php if ($varPageName=="decline") { ?>
			<div style="float:left;width:102;height:21px;text-align:center">
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="7" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none;width:88px"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Declined (<b><?=$varNoOfDeclineList?></b>)</div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="7" height="21"></div>
			</div>
			<?php }else{ ?>
			<div style="float:left;width:102;height:21px;text-align:center">
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="7" height="21" border="0"></div>
				<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none;width:88px"><a href="interest-sent.php?pageName=decline" style="text-decoration:none;"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Declined (<b><?=$varNoOfDeclineList?></b>)</a></div>
				<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="7" height="21"></div>
			</div>
			<?php }?>	
		</td>
	</tr>
</table>
<!-- pending,Accepted, declined menus starts here -->

<table border="0" cellspacing=0 cellpadding="0" width="98%" align="center" style="border:1px solid #C3E07B;">
	<!--Express Interest & Forward & Paging Table starts here-->
	<tr class="memonlsbg4"><td valign="top" colspan="6" width="100%">
		<div id="hideButtonsTop">
		<?php if($varNoOfRecords != 0){?>
		<table border="0" cellpadding="0" cellspacing="0">
			<tr><td width="75%">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
					<td valign="middle"><input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.interestSent,this.form.checkName,'0');"></td>
					<?php if($varPageName=="pending"){?>
					<td align="right" valign="top"><div id="sendReminderTop">
						<input type="image" src="<?=$confServerURL?>/images/sendareminder-button.gif" width="124" height="25" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.interestSent,1);"></div>
					</td>
					<?php } ?>
					<td align="left" valign="top">
						<input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="0" onClick="funConfirmMessage(this.form,this.form.interestSent,2);">
					</td>
					</tr>
				</table>
				</td>
				<td width="25%">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<!-- page navigation starts here -->
					<?=$objProductFacebook->pageNavigation($varNoOfRecords, $pageNum, $varNumOfPages, "yes")?>
					<!-- page navigation ends here -->
					</table>
				</td>
			</tr>
		</table>
		<?php }?>
		</div>
	</td></tr>
	<!--Express Interest & Forward & Paging Table ends here-->
	<tr><td>&nbsp;</td></tr>
	<tr><td>
<!--Search Results Tables starts here-->
<table border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
	<?php
	if($varNoOfRecords == 0)
	{
		$funDisplay	.= '<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center">';
		$funDisplay .= '<tr><td align="center" valign="middle" class="errorMsg" height="30">';
		$funDisplay .= $objProductFacebook->clsDisplayMessage;
		$funDisplay .= '<br></td></tr>';
		echo $funDisplay .= '</table>';
	}
	else
	{
		$objProductFacebook->clsMemberYouContacted	= "Opposite_MatriId";
		$varTemplate	= $objProductFacebook->getContentFromFile('templates/salaams-received.tpl');
		$objProductFacebook->clsListTemplate	= $varTemplate;
		$objProductFacebook->clsOrderBy		= array('Date_Sent');
		$varMessageInfo					= $objProductFacebook->listMyMessage('IS');
	}
	?>

<!--Search Results Tables starts here-->
</td></tr>

<tr><td valign="bottom">
<!--Express Interest & Forward & Paging Table starts here-->
<div id="hideButtonsBottom">
<?php if($varNoOfRecords != 0){?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
	<tr class="memonlsbg4">
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="75%">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td valign="middle"><input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.interestSent,this.form.checkName,'1');"></td>
						<?php if($varPageName=="pending"){ ?>
						<td align="right" valign="top"><div id="sendReminderBottom">
							<input type="image" src="<?=$confServerURL?>/images/sendareminder-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.interestSent,1);"></div>
						</td>
						<?php } ?>
						<td align="left" valign="top">
							<input type="image" src="<?=$confServerURL?>/images/delete-button.gif" vspace="5" hspace="0" onClick="funConfirmMessage(this.form,this.form.interestSent,2);">
						</td>
						</tr>
					</table>
				</td>
				<td width="25%">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<!-- page navigation starts here -->
					<?=$objProductFacebook->pageNavigation($varNoOfRecords, $pageNum, $varNumOfPages, "yes")?>
					<!-- page navigation ends here -->
					</table>
				</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
<?php }?>
</td></tr>
</table><br>
<?php
//UNSET OBJECT
unset($objProductFacebook);
?>
</form>