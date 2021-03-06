<?php

//FILE INCLUDES
include_once('/home/product/community/conf/dbinfo.cil14');
include_once('/home/product/community/conf/ip.cil14');
include_once('/home/product/community/conf/domainlist.cil14');
include_once('/home/product/community/lib/clsMailManager.php');
include_once('/home/product/community/lib/clsCryptDetail.php');

//OBJECT DECLARATION
$objMailManager	= new MailManager;

//VARIABLE DECLARATION
$varCurrentDateTime	= date('Y-m-d H:i:s');
$varCurrentDate	= date('Ymd');
$varSubject			= "We haven't seen you online for a long time!";
$varTrackDtls		= "trackid=00410000005&type=internal&formfeed=y";

$varContentFile	= 'Login_Reminder';
$varFileName	= '';
if($argv[1]!='') {
	$varFileName	= '/home/product/community/remindermailer/loginreminder/'.$argv[1];
}else{
	"please give input text file name";
}

// Counter Log file
$varSendFilename= '/home/product/community/remindermailer/loginreminder/'.date('dmY').'_'.$varContentFile.'_'.date('H:i:s').'_MailSent.txt';


function sendFreeToPaidEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress) {
	$funValue				= '';
	$funheaders				= '';
	$argFrom				= preg_replace("/\n/", "", $argFrom);
	$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
	$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
	$argMessage				= preg_replace("/<--TO_EMAIL-->/", $argToEmailAddress, $argMessage);
	$funheaders				.= "MIME-Version: 1.0\n";
	$funheaders				.= "X-Mailer: PHP\n";
	$funheaders				.= "Content-type: text/html\n";
	$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
	$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
	$funheaders				.= "Return-Path:<noreply@bounces.communitymatrimony.com>\n";
	$funheaders				.= "Sender: info@communitymatrimony.com\n";
	$argheaders				= $funheaders;
	$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);

	if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if

	return $funValue;
}

//CONNECT MYSQL
$objMailManager->dbConnect('S2',$varDbInfo['DATABASE']);

$varFileName		= file($varFileName);
$i = 0;
$varLRMailStartDt = date('d-m-Y h:i:s');
foreach($varFileName as $varFileInfo) {
	$varMatriId			= '';
	$varToEmailAddress	= '';
	$varDomaiId			= '';
	$varPaidStatus		= '';
	$varName			= '';
	$varMsgPendingCnt	= '';
	$varMsgPendingCnt	= '';
	$varMessage			= '';
	$varFrom			= '';
	$emailfrom			= '';
	$replyto			= '';
	$varTo				= '';
	$varPassword		= '';
	$varDomainDetails	= array();
	$varDomainFolder	= array();
	
	$varFileArray		= split('~', $varFileInfo);
	$varSerialNo		= trim($varFileArray[0]);
	$varMatriId			= trim($varFileArray[1]);
	$varToEmailAddress	= trim($varFileArray[2]);
	$varPassword		= trim($varFileArray[3]);
	$varDomaiId			= trim($varFileArray[4]);
	$varPaidStatus		= trim($varFileArray[5]);
	$varName			= trim($varFileArray[6]);
	$varMsgPendingCnt	= trim($varFileArray[7]);
	$varIntPendingCnt	= trim($varFileArray[8]);
	$varTo				= $varMatriId;
	
	//GET DOMAIN DETAILS
	$varDomainDetails	= $objMailManager->getDomainDetails($varMatriId);
	$varDomainFolder	= $objMailManager->getFolderName($varMatriId);
	$varTollFreeCont	= $objMailManager->getINDTollFree($varMatriId);
	
	$varDomaiPrefix		= trim($arrMatriIdPre[$varDomaiId]);
	$varDomainName		= trim($arrPrefixDomainList[$varDomaiPrefix]);
	$varShortName		= ucwords(str_replace("matrimony.com","",$varDomainName));
	 
	if ($varDomainName !='') {
		$varMatriIdPrefix = substr($varMatriId,0,3);

		$varSpecFolder	= ($arrMailerTplFolder[$varMatriIdPrefix]!='')?($arrMailerTplFolder[$varMatriIdPrefix]).'/':'';
		include($varSpecFolder.'login_reminder_tpl.php');

		$varMessage		= stripslashes($varTemplate);

		$varLogoPath	= $varDomainDetails['IMGURL'].'/logo/'.$arrFolderNames[$varDomaiPrefix];
		$varImgPath		= $varDomainDetails['IMGURL'];
		$varServerUrl	= $varDomainDetails['SERVERURL'];
		$varMailerImgPath= $varDomainDetails['MAILERIMGURL'];
		$varProductName	= $varShortName.'Matrimony';
		$unsubscibeLink	= $varServerUrl."/login/index.php?redirect=".$varServerUrl."/profiledetail/index.php?act=mailsetting";
		$varPendingDtl	= '';
		
		//For CBS-Autologin	--> GOKILAVANAN.R(Mar-29-2011)
		$varAutoLogin	  = CryptDetail::mclink($varMatriId,'lrem'); // For autologin
		$funLoginURL			= $varServerUrl.'/login/intermediatelogin.php?'.$varTrackDtls.'&'.$varAutoLogin.'&redirect=';

		if($varMsgPendingCnt>0 || $varIntPendingCnt>0) {
			$varPendingDtl.='<tr>
								<td valign="top" width="496" style="font:bold 12px arial;color:#333333;text-align:justify;padding-top:30px;padding-left:10px;padding-right:10px;padding-bottom:10px;">PENDING � WAITING FOR YOUR REPLY</td>
							</tr>
							<tr>
								<td valign="top" width="496" style="padding-left:10px;" align="left">
									<table border="0" cellpadding="0" cellspacing="0" width="395" height="51" bgcolor="#efefef" style="border:1px solid #dbdbdb;font:normal 12px arial;color:#333333;" align="left">
									<tr>
										<td style="font:normal 12px arial;color:#333333;padding-left:10px;padding-top:10px;padding-bottom:10px;line-height:18px;">';
										if($varMsgPendingCnt>0){
											$varPendingDtl.='<img src="'.$varImgPath.'/arrow1.gif" border="0" alt="" hspace=5><b>'.$varMsgPendingCnt.'</b> members have sent you <b>Personalized Messages</b>.<br />';
										}
										if($varIntPendingCnt>0){
											$varPendingDtl.='<img src="'.$varImgPath.'/arrow1.gif" border="0" alt="" hspace=5><b>'.$varIntPendingCnt.'</b> Members have sent you <b>Express Interest</b>.<br />';
										}
						$varPendingDtl.='Please don\'t keep them waiting. Reply today.</td></tr></table></td></tr>';
		}

		$varMessage		= str_replace('<--TOLLFREE-->',$varTollFreeCont,$varMessage);
		$varMessage		= str_replace('<--LOGO-->',$varLogoPath,$varMessage);
		$varMessage		= str_replace('<--MATRIID-->',$varMatriId,$varMessage);
		$varMessage		= str_replace('<--PASSWORD-->',$varPassword,$varMessage);
		$varMessage		= str_replace('<--NAME-->',$varName,$varMessage);
		$varMessage		= str_replace('<--TRACK_DETAIL-->',$varTrackDtls,$varMessage);
		$varMessage		= str_replace('<--PENDING_DETAIL-->',$varPendingDtl,$varMessage);
		$varMessage		= str_replace('<--MAILERIMGSPATH-->',$varMailerImgPath,$varMessage);
		$varMessage		= str_replace('<--IMGSPATH-->',$varImgPath,$varMessage);
		$varMessage		= str_replace('<--PRODUCT_NAME-->',$varProductName,$varMessage);
		$varMessage		= str_replace('<--UNSUBSCRIBE_LINK-->',$unsubscibeLink,$varMessage);
		$varMessage		= str_replace('<--SERVERURL-->',$varServerUrl,$varMessage);
		$varMessage		= str_replace('<--LOGINURL-->',$funLoginURL,$varMessage);

		$varFrom		= $varShortName.'Matrimony.com';
		$emailfrom		= strtolower('info@'.$varShortName.'matrimony.com');
		$replyto		= strtolower('noreply@'.$varShortName.'matrimony.com');

		if(sendFreeToPaidEmail($varFrom,$emailfrom,$varTo,$varToEmailAddress,$varSubject,$varMessage,$replyto)){
			$varTrackDetails	= $i.'~'.$varSerialNo.'~'.$varToEmailAddress;
			$varSendHandler		= fopen($varSendFilename,"w+");
			fwrite($varSendHandler,$varTrackDetails);
			fclose($varSendHandler);
			$i++;
		}
	}
}

//DISCONNECT MYSQL
$objMailManager->dbClose();

//CONNECT MYSQL
$mysql_connection	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

//Update into cbsmailer report table
$varInsertQuery	= "INSERT INTO cbsmailer_report (MailerType,Count,SentOn) VALUES ('".$varContentFile."',".$i.",'".$varCurrentDateTime."')";
$varInsertId	= mysql_query($varInsertQuery) or die('insert_error');

$varFrom			= 'CommunityMatrimony';
$varFromEmail		= 'CommunityMatrimony.Com';
$emailfrom			= 'info@communitymatrimony.com';
$replyto			= 'noreply@communitymatrimony.com';
$varSubject			= $varContentFile.' Completed';
$varMessage			= 'Start Date : '.$varLRMailStartDt.'<br>'. 'Total Count ='.$i. '<br>'. 'End Date : '. date('d-m-Y h:i:s');
$varToEmailAddress	= 'ashokkumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com, jeyakumar@bharatmatrimony.com, sai@bharatmatrimony.com, vijayasunitha@bharatmatrimony.com';
//$varToEmailAddress	= 'greennjk@gmail.com';
//$varToEmailAddress = 'gokilavanan.r@bharartmatrimony.com';
if(sendFreeToPaidEmail($varFrom,$emailfrom,$varTo,$varToEmailAddress,$varSubject,$varMessage,$replyto)){
	echo "Login reminder mails sent successfully";
}

mysql_close($mysql_connection) or die('error');
?>
