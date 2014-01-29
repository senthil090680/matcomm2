<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : profileinboxview.php
#=====================================================================================================================================
# Description : display information of inbox detail.
#=====================================================================================================================================

$varShowCloseDiv	= $_REQUEST['showCloseDiv'];

if($varShowCloseDiv=='yes') {
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath."/conf/privilege.cil14");
include_once($varRootBasePath.'/lib/clsBasicview.php');
include_once($varRootBasePath.'/www/mymessages/framebasicstrip.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];

//REQUEST VARIABLES
$varCurrPgNo		= $_REQUEST['cpno']?$_REQUEST['cpno']:0;
$varDefaultTab		= $_REQUEST['defaultTab'];

$varMatriId 			= ($_REQUEST['id']!='')?strtoupper(trim($_REQUEST['id'])):$sessMatriId;
$varCondition			= " WHERE MatriId='".$varMatriId."' AND ".$varWhereClause;

}

$varModule			= $varModule ? $varModule : 'no';

//OBJECT DECLARATION

#included this condition for search module [ refer bv_action.php ] (20101110) Dhanapal.
if (empty($objProfileDetail)){

$objProfileDetail		= new ProfileDetail;

//CONNECT DATABASE
$objProfileDetail->dbConnect('M',$varDbInfo['DATABASE']);

}

//VARIABLE DECLARATION
$varMessageFlag	= $_REQUEST['msgfl'];
$varMessageId	= $_REQUEST['msgid'];
$varMessageType	= $_REQUEST['msgty'];
$varButtonName	= "Send Message";
//$varMessageFlag	= '';
//$varMessageId	= '46691';
$varCurrentDate		= date('Y-m-d H:i:s');

if($varMessageFlag != '') {

		if($varMessageType == 'R') {
			switch($varMessageFlag) { //Interest & Mail Received Part
				//mail received
				case 1:
						$varInbFields	= array('Mail_Message','Replied_Message','Status','Delete_Status');
						$varInbCondition= "WHERE Mail_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['MAILRECEIVEDINFO'];
						break;
				//interest received
				case 2:
						$varInbFields	= array('Interest_Option','Declined_Option','Status','Delete_Status');
						$varInbCondition= "WHERE Interest_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['INTERESTRECEIVEDINFO'];
						break;
				//request received
				case 3:
						$varInbFields	= array('RequestFor','SenderId','RequestDate');
						$varInbCondition= "WHERE RequestId=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND ReceiverId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND SenderId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['REQUESTINFORECEIVED'];
						break;
			}

			//FETCHING RECORD FROM CORRESPONDING TABLE
			$varInboxInfoResultSet	= $objProfileDetail->select($varTableName,$varInbFields,$varInbCondition,0);
			$varInboxInfo			= mysql_fetch_assoc($varInboxInfoResultSet);

			//Getting message
			$varFrame		= 0;
			$varinnerCont	= '';
			$varSpamOpt		= 0;
			$varMarkasSpam	= '';

			if($varMessageFlag==1) {
				$varInbStatus		= $varInboxInfo['Status'];
				$varInbMessage		= $varInboxInfo['Mail_Message'];
				$varSenderDelStatus = $varInboxInfo['Delete_Status'];
				$varOppMatriId		= $varMatriId;

				if($varInbStatus == 0 || $varInbStatus == 1){
					$varSpamCond	= 'WHERE MessageId='.$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail);
					$varSpamOpt		= $objProfileDetail->numOfRecords($varTable['SPAMMSG'], 'MessageId', $varSpamCond);
				}

				if($varInbStatus == 0) {//not read

					$objMessage = $objProfileDetail;
					include_once $varRootBasePath."/www/mymessages/msgstatus.php";
					$varMsgStatusContent= 'This member has sent you a message.<br clear="all">If you do not reply, you may keep the member in anticipation.';
					$varButton	= '<input type="button" class="button" value="Reply" onclick="showRlyDiv()"/> &nbsp;
					<input type="button" class="button" value="Decline" onclick="showDecDiv('.$varMessageId.',\'\');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>';
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					$varFrame = 1;
					$varMarkasSpam = $varSpamOpt==0 ? '<a href="javascript:;" class="clr1" onclick="markasSpam(\''.$varMessageId.'\', \'\');show_box(event,\'div_box'.$varCurrPgNo.'\');">Mark as spam</a>' : '';

				} elseif($varInbStatus==1) { //read, not replied

					$varMsgStatusContent= 'This member has sent you a message.<br clear="all">If you do not reply, you may keep the member in anticipation.';
					$varButton	= '<input type="button" class="button" value="Reply" onclick="showRlyDiv()"/> &nbsp;
					<input type="button" class="button" value="Decline" onclick="showDecDiv('.$varMessageId.',\'\');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>';
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. $varInbMessage.'</div>';
					$varFrame = 1;
					$varMarkasSpam = $varSpamOpt==0 ? '<a href="javascript:;" class="clr1" onclick="markasSpam(\''.$varMessageId.'\', \'\');show_box(event,\'div_box'.$varCurrPgNo.'\');">Mark as spam</a>' : '';

				} elseif($varInbStatus==2){ //replied

					$varMsgStatusContent= 'You have replied to this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
																	
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n','<br>',$varInboxInfo['Replied_Message']))."<BR> ----- Original Message ----- <BR>From: ".$varMatriId."<BR>To: ". $sessMatriId."<BR><BR>". stripslashes(str_replace('\n','<br>',$varInboxInfo['Mail_Message'])).'</div>';

				} elseif($varInbStatus==3) { //declined

					$varMsgStatusContent= 'You have declined this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';

				} elseif($varInbStatus==13) { //declined
					$varMsgStatusContent= 'This member has declined to your message.<br clear="all">Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
				} else { //deleted
					$varMsgStatusContent= 'You have deleted the member\'s message. Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
				}
			}else if($varMessageFlag==2) {
				$varInbStatus	= $varInboxInfo['Status'];
				$varInbMessage	= $arrExpressInterestList[$varInboxInfo['Interest_Option']];
				if($varInbStatus == 0) {//new interest

					$varMsgStatusContent= 'This member has sent you a message.<br clear="all">If you do not reply, you may keep the member in anticipation.';
					$varButton	= '<input type="button" class="button" value="Accept" onclick="intAccCall('.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');"> &nbsp;
					<input type="button" class="button" value="Decline" onclick="intDecCall('.$varMessageId.','.$varCurrPgNo.',\'0\'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==1) { //interest accepted

					$varMsgStatusContent= 'You have accepted this member\'s message.';
					if($sessPaidStatus == 1){
						$varDispalyMsgPart	= 1;
					} else  {
						$varMsgStatusContent.= '<br clear="all">Become a premium member to contact this member directly.<br clear="all"><a href="'.$confValues['SERVERURL'].'/payment/" class="clr1">Click here to <font class="bld">PAY NOW</font></a>';
						$varButton			= '';
					}
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==3) { //interest declined

					$varMsgStatusContent= 'You have declined this member\'s message.<br clear="all">Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==21) { //declined

					$varMsgStatusContent= 'This member has accepted your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} elseif($varInbStatus==23) { //declined

					$varMsgStatusContent= 'This member has declined to your message.<br clear="all">Move ahead in your partner search and start contacting other profiles.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton			= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));

				} else {  // deleted 
					$varMsgStatusContent= 'You have already contacted this member. Below is the last message you sent.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varMsgStatusContent.= 'Become a premium member to contact this member directly. Click here to <a href="'.$confValues['SERVERURL'].'/payment/" class="clr1"><font class="bld">PAY NOW</font></a>';
						$varButton			= '';
					}				
				}
			}else if($varMessageFlag==3) {

				$varFields	= array('Photo_Set_Status', 'Phone_Verified', 'Horoscope_Available');
				$varCond	= "WHERE MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail);
				$varStatusInfo	= $objProfileDetail->select($varTable['MEMBERINFO'],$varFields,$varCond,1);

				$varInbMessage ='';
				$varReqFor	= $varInboxInfo['RequestFor'];
				$varReqMsg	= strtolower($arrRequestList[$varReqFor]);
				$varMsgStatusContent= 'You have received a '.$varReqMsg.' request.';

				if($varReqFor == 1 && $varStatusInfo[0]['Photo_Set_Status']==0){
					$varinnerCont = '<div class="fright"><input type="button" class="button" value="Add Photo" onclick="javascript:window.location.href=\''.$confValues['IMAGEURL'].'/photo/\';"></div>';
				}elseif($varReqFor == 3 && $varStatusInfo[0]['Phone_Verified']==0){
					$varinnerCont = '<div class="fright"><input type="button" class="button" value="Add Phone" onclick="javascript:window.location.href=\''.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo\';"></div>';
				}else if($varReqFor == 5 && $varStatusInfo[0]['Horoscope_Available']==0){
					$varinnerCont = '<div class="fright"><input type="button" class="button" value="Add Horoscope" onclick="window.location.href=\''.$confValues['IMAGEURL'].'/horoscope/\';"></div>';
				}

			}


		} else if($varMessageType == 'S') {
	
			//Request related add Button
			$varinnerCont	= '';

			switch($varMessageFlag) { //Interest & Mail Sent Part
				//mail sent
				case 1:
						$varInbFields	= array('Mail_Message','Replied_Message','Status');
						$varInbCondition= "WHERE Mail_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['MAILSENTINFO'];
						break;
				//interest sent
				case 2:
						$varInbFields	= array('Interest_Option','Declined_Option','Status','Delete_Status');
						$varInbCondition= "WHERE Interest_Id=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['INTERESTSENTINFO'];
						break;
				//request sent
				case 3:
						$varInbFields	=  array('RequestFor','ReceiverId','RequestDate');
						$varInbCondition	= "WHERE RequestId=".$objProfileDetail->doEscapeString($varMessageId,$objProfileDetail)." AND SenderId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND ReceiverId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
						$varTableName	= $varTable['REQUESTINFOSENT'];
						break;
			}

			//FETCHING RECORD FROM CORRESPONDING TABLE
			$varInboxInfoResultSet	= $objProfileDetail->select($varTableName,$varInbFields,$varInbCondition,0);
			$varInboxInfo			= mysql_fetch_assoc($varInboxInfoResultSet);

			$varInbStatus	= $varInboxInfo['Status'];

			if($varMessageFlag==1){
				$varInbMessage	= $varInboxInfo['Mail_Message'];
				if($varInbStatus == 0){//not read

					$varMsgStatusContent= 'You have sent this member a message.<br clear="all">Member hasn\'t replied, you can send a reminder.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Reminder";
					} else {
						$varButton			= '<input type="button" class="button" value="Send Reminder" onclick="sendreminder('.$varMessageFlag.', '.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					}
					$varInbMessage		= '<div style="height:25px;"><b>Your Earlier Message :</b></div><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';

				}else if($varInbStatus == 1){

					$varMsgStatusContent= 'You have sent this member a message.<br clear="all">If the member hasn\'t replied, you can send a reminder.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Reminder";
					} else {
						$varButton			= '<div style="margin-right:15px;"><input type="button" class="button" value="Send Reminder" onclick="sendreminder('.$varMessageFlag.', '.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');"></div>';
					}
					$varInbMessage		= '<div style="height:25px;"><b>Your Earlier Message :</b></div><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';

				}else if($varInbStatus == 2){

					$varMsgStatusContent= 'This member has replied to your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Message";
					} else {
						$varButton			= '';
					}
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;">'. stripslashes(str_replace('\n', '<br>', $varInboxInfo['Replied_Message']))."<BR> ----- Original Message ----- <BR>From: ".$sessMatriId."<BR>To: ". $varMatriId."<BR><BR>".stripslashes(str_replace('\n', '<br>', $varInboxInfo['Mail_Message'])).'</div>';

				}else if($varInbStatus == 3){

					$varMsgStatusContent= 'This member has declined to your message.<br clear="all">Move ahead in your partner search and start contacting other profiles';
					$varInbMessage		= '<b>Your Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Message";
					} else {
						$varButton			= '';
					}

				}else if($varInbStatus == 13) {

					$varMsgStatusContent= 'You have declined this member\'s message';
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Message";
					} else {
						$varButton			= '';
					}

				} else {  // Deleted
					$varMsgStatusContent= 'You have already contacted this member. Below is the last message you sent.';
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Message";
					} else {
						$varMsgStatusContent.= 'Become a premium member to contact this member directly. Click here to <a href="'.$confValues['SERVERURL'].'/payment/" class="clr1"><font class="bld">PAY NOW</font></a>';
						$varButton			= '';
					}

				}
			}else if($varMessageFlag==2) {
				$varInbStatus	= $varInboxInfo['Status'];
				$varInbMessage	= $arrExpressInterestList[$varInboxInfo['Interest_Option']];
				if($varInbStatus == 0){//new interest
					$varMsgStatusContent= 'You have sent this member a message.<br clear="all">Member hasn\'t replied, you can send a reminder.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Reminder";
					} else {
						$varButton		= '<input type="button" class="button" value="Send Reminder" onclick="sendreminder('.$varMessageFlag.', '.$varMessageId.','.$varCurrPgNo.'); show_box(event,\'div_box'.$varCurrPgNo.'\');">';
					}
					$varInbMessage	= '<b>Your Earlier Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==1){ //interest accepted
					$varMsgStatusContent= 'This member has accepted your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varMsgStatusContent.= 'Become a premium member to contact this member directly. Click here to <a href="'.$confValues['SERVERURL'].'/payment/" class="clr1"><font class="bld">PAY NOW</font></a>';
						$varButton	= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==3){ //interest declined
					$varMsgStatusContent= 'This member has declined to your message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Your Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==21){ //declined
					$varMsgStatusContent= 'You have accepted this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				}elseif($varInbStatus==23){ //declined
					$varMsgStatusContent= 'You have declined this member\'s message.';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
					} else {
						$varButton	= '';
					}
					$varInbMessage	= '<b>Member\'s Message :</b> <br clear="all">'.stripslashes(str_replace('\n', '<br>',$varInbMessage));
				} else if($varInbStatus ==5) { //deleted
					$varMsgStatusContent= 'You have already contacted this member. Below is the last message you sent';
					$varInbMessage		= '<b>Member\'s Message :</b> <br clear="all"><div class="pad10 brdr clr" style="height:75px;overflow:auto;" >'.stripslashes(str_replace('\n', '<br>',$varInbMessage)).'</div>';
					if($sessPaidStatus==1) {
						$varDispalyMsgPart	= 1;
						$varSenderSideFn	= "swapdiv('0','1','".$varSwapInt."')";
						$varButtonName		= "Send Message";
					} else {
						$varMsgStatusContent.= '<br clear="all">Become a premium member to contact this member directly. Click here to <a href="'.$confValues['SERVERURL'].'/payment/" class="clr1"><font class="bld">PAY NOW</font></a>';
						$varButton			= '';
					}
				} 
			}else if($varMessageFlag==3) {
				$varInbMessage ='';
				$varReqFor	= $varInboxInfo['RequestFor'];
				$varReqMsg	= strtolower($arrRequestList[$varReqFor]);
				$varMsgStatusContent= 'You have sent a '.$varReqMsg.' request.';
			}
		}
}
if ($varModule=='no') {
?>
<script language="javascript">
function selclose()
	{
	document.getElementById('fade').style.display='none';
	document.getElementById('div_box0').style.display='none';
	document.getElementById('div_box0').style.visibility='hidden';
	}
</script>
 
<?


if($varShowCloseDiv == 'yes') {
  echo '<div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" onclick="hide_box();nullDivBox('.$varCurrPgNo.');" href="javascript:;" class="pntr" /></div>';
}
?>

<div class="tlleft bgclr2" id="actiondiv<?=$varCurrPgNo?>">
	<center>
		<div style="width:497px;" id="mnprf">
			<?if($varMessageFlag != '' && $varMessageType!=''){ ?>
			<!-- Inbox Message Starts-->
			<div id="msg2div<?=$varCurrPgNo?>" class="tlleft">
				<div id="msgdispdiv<?=$varCurrPgNo;?>" class="tlleft">
					<div class="padb10">
						<div class="statusarea fleft tlleft"><?=$varMsgStatusContent;?></div>
						<?=$varinnerCont;?>
					</div>
					<br clear="all">
					<div class="dotsep3" style="margin-top:5px !important;padding-top:5px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="2"></div>
					<div class="normtxt clr lh16" style="margin-top:5px;"><?=$varInbMessage;?></div>
					<div id="spam<?=$varCurrPgNo?>" class="fleft padt10"><?=$varMarkasSpam;?></div>
					<div class="fright padt10"><?=$varButton;?></div>
				</div>
				<?if($varFrame == 1){?>
				<div id="replyDiv<?=$varCurrPgNo?>" class="disnon">
					<div><iframe width="500" height="105" contentEditable="true" frameborder="0" src="<?=$confValues['SERVERURL'];?>/mymessages/sendmail.php?currrec=<?=$varCurrPgNo?>&msgid=<?=$varMessageId?>" style="margin:0px;padding:0px" id="parentrte<?=$varCurrPgNo?>" name="parentrte<?=$varCurrPgNo?>" class="bgclr2"></iframe></div>
					<div class="fright padt10" id="buttonSub" class="bgclr2"><input type="button" class="button" value="Send Message" onclick="javascript:RTESubmit('reply');show_box(event,'div_box<?=$varCurrPgNo?>');"/></div>
				</div>
				<?}else{?>
				<div id="replyDiv<?=$varCurrPgNo?>" class="disnon"></div>
				<?}?>
			</div><br clear="all">
		</div>
		<!-- Inbox Message Ends-->
		<?}
		if($varDispalyMsgPart==1 || ($varMessageFlag=='' && $varMessageType=='')){ //For Search Part?>
		<!-- Search Options Starts-->
    
		<div class="fright padb5">
			<div id="firstct<?=$varCurrPgNo?>" class="disblk">
				<div style="margin-right:15px;">
			    <input type="button" class="button" value="<?=$varButtonName?>" onclick="showOption('<?=$varCurrPgNo?>');<?=$varSenderSideFn;?>;" /></div>
			</div>
		</div><br clear="all">
		<div id="msg1div<?=$varCurrPgNo?>" class="disnon">
			<div id="replyDiv<?=$varCurrPgNo?>"></div>
			<!--Interest Action Area Part-->
            <!--<div class="dotsep3 wdth450 fleft" style="margin-left:17px;margin-top:8px;display:inline"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>-->
			<div class="smalltxt tlleft fleft" style="width:475px;height:100px !important;height:120px;">
				<div class="smalltxt clr bld " style="padding-left:10px;"><input type="radio" name="msgtype<?=$varCurrPgNo?>" id="msgtype1" <?php if($sessPaidStatus == 0){echo 'checked';}?> onclick="swapdiv('<?=$varCurrPgNo?>','2','<?=$varSwapInt?>');"> Send templated message</div>
				<center>
				<!--<div class="dotsep3" style="width:410px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1"></div>--></center>
                <div class="bgclr2" style="height:75px !important;height:90px;width:460px;float:left;margin-top:4px;margin-left:17px;padding-top:7px;display:inline;">
					<div id="radio2div<?=$varCurrPgNo?>" class="disblk" style="padding-left:10px;">
						<div class="fleft">
							<div class="radiodiv2 lh16">
							<? foreach($arrExpressInterestList as $key=>$value){
								$varChecked = ($key == 1) ? 'Checked' : '';
								echo '<div class="fleft tlright" style="width:30px;padding-top:8px !important;padding-top:5px;display:inline"><input type="radio" class="frmelements" name="intopt'.$varCurrPgNo.'" value="'.$key.'"  id="intopt'.$key.'" '.$varChecked.'></div><div class="fleft" style="width:410px;padding-top:7px;padding-left:5px;">'.$value.'</div><br clear="all">';
							}?>
							</div>
						</div>
					</div>
                </div>
			</div>
			<!--Interest Action Area Part Ends-->
			<!--Richtext Area Part-->
			<div class="smalltxt tlleft fleft" style="width:450px !important;width:454px;height:135px !important;height:125px;">
				<div class="smalltxt clr bld" style="margin-top:10px !important;margin-top:0px;padding-left:10px;height:30px;"><input type="radio" name="msgtype<?=$varCurrPgNo?>" id="msgtype2" <?php if($sessPaidStatus == 1){echo 'checked';}?>  <?php if($sessPaidStatus == 0){echo 'disabled';}?> onclick="swapdiv('<?=$varCurrPgNo?>','1','<?=$varSwapInt?>');"> Send personalized message</div>
				<div id="radio1div<?=$varCurrPgNo?>" class="disblk tlleft" style="padding-left:5px;">
				<?
				if($sessPaidStatus == 1 && $sessPublish==1){
					$varButtonVal = '<input type="button" class="button" value="Send Message" onclick="javascript:RTESubmit(\'\');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>'; 
				?>
					<div style="margin-left:17px;"><iframe width="455" height="82" frameborder="0" src="<?=$confValues['SERVERURL'];?>/mymessages/sendmail.php?currrec=<?=$varCurrPgNo?>" style="margin-left:15px;" id="parentrte<?=$varCurrPgNo?>" name="parentrte<?=$varCurrPgNo?>" contentEditable="true"></iframe></div>
					<?	}else if($sessPaidStatus == 1 && $sessPublish==2){
					$varButtonVal = '<input type="button" class="button" value="Send Message"/>';
					?>
					<div class="padl25">
						<div><br>Currently your profile is hidden. To send message, you must <a href="<?=$confValues['SERVERURL'];?>/profiledetail/index.php?act=profilestatus" class='clr1'>click here to unhide</a> your profile.<br></div>
				</div>
				<?  }else{
				$varButtonVal = '<input type="button" class="button" value="Send Message" onClick="javascript:sendInterest('.$varCurrPgNo.');show_box(event,\'div_box'.$varCurrPgNo.'\');"/>';
				?>
				<div style="margin-left:30px;width:459px;background:#ffffff;">
					<div class="normtxt" style="background:url(http://img.communitymatrimony.com/images/freember-bg.jpg) no-repeat;height:80px;"><center><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="50">To send message in your own words <a class="clr1 bld" href="<?=$confValues['SERVERURL']?>/payment/">Become A Premium Member.</a></center></div>
						<!--<div style="border:1px solid red;" class="radiodiv1a normtxt"><br><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="50"><br>To send message in your<br> own words <a class="clr1 bld" href="<?=$confValues['SERVERURL']?>/payment/">Pay Now.</a></div>-->
				</div>
				<?}?>
			</div>
			<!--Richtext Area Part Ends-->
		</div>
		
		<!-- message action div starts-->
        <div style="width:450px;float:left;margin-left:40px;display:inline;height:25px;">
			<div class="fright" id="buttonSub<?=$varCurrPgNo?>"><?=$varButtonVal;?></div>
        </div><br clear="all">
		<!--<div class="fright" id="buttonSub<?=$varCurrPgNo?>"><?=$varButtonVal;?></div>-->
    </div>
	<!-- Search Options Ends-->
	<? }?>

	</center>
</div><div class="cleard"></div><span style="margin-left:40px;" class="fleft errortxt" id="errorDisplay"></span>
<?php
}
?>