<?php
#=================================================================================================================
# Author 	  : Baranidharan M
# Date		  : 2010-06-23
# Project	  : MatrimonyProduct
# Filename	  : sendMail.php
#=================================================================================================================
# Description : read the details from text files and send a respective mailer to members. 
#=================================================================================================================

$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');

//OBJECT DECLARATION
$objMailManager	= new MailManager;

$arrSubject	= array(1=>'Login to Keep your profile active',2=>'Login or your profile may be removed',3=>'Activate your profile now');
$arrInactiveDays	= array(1=>181,2=>187,3=>194);
$varCurrentDate		= date('Y-m-d H:i:s');
$varInactivePeriod	= trim($_SERVER['argv'][1]);
$varTextFilename	= date('Y-m-d').'_'.$arrInactiveDays[$varInactivePeriod].'.txt';
$varSubject			= $arrSubject[$varInactivePeriod];
//$varTextFilename	= trim($_SERVER['argv'][2]);

if ($varInactivePeriod=="") { echo 'Enter Period'; exit; } else {

$varMessage = '<table width="400" border = "1" cellspace="2" style="background-color:#E9EAC8;" align="center"><tr style="font: normal 11:px verdana,tahoma;padding-bottom:15px;background-color:#73C03B;"><td colspan="3" align="center"><b>Date :</b>'.$varCurrentDate.'</td></tr><tr style="font: normal 15:px verdana,tahoma;padding-bottom:15px;"><td align="center">Mailer Type<B></b></td><td  align="center"><B>Total Count</b></td><td  align="center"><b>Sent Count</b></td></tr>';

  $varMailerType	= 'inactive'.$varInactivePeriod;
  $varTemplateFile	= $varMailerType.".tpl";
  $varFileName		= file("/home/product/community/inactive/log/".$varTextFilename);
  $varLogContent	= $varMailerType." : Total Count = ".count($varFileName);
  $varSentCount		= 0;
	foreach($varFileName as $varFileInfo) { //each member

		$varMatriId	    = '';
		$varName	    = '';
		$varEmail		= '';
		$varPassword	= '';
		$varSentStatus	= '';

		$varFileArray	= split('~', $varFileInfo);
		$varMatriId	    = trim($varFileArray[0]);
		$varName		= trim($varFileArray[1]);
		$varEmail	    = trim($varFileArray[2]);
		$varPassword	= trim($varFileArray[3]);

		$varSentStatus = $objMailManager->sendInactiveMail($varTemplateFile,$varName,$varMatriId,$varPassword,$varEmail,$varSubject); 	      
		if($varSentStatus == 'yes') { 
			$varLastMatriId	= $varMatriId;
			$varSentCount	= $varSentCount+1;
		}//if
  }//foreach
  
	$objMasterDB	= new DB;
	$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

	// FOR DATABASE
	$varFieldsFields		= array('MailerType','Count','SentOn');
	$varFieldsFieldsValues	= array("'".$varMailerType."'",$varSentCount,"'".$varCurrentDate."'");
	$objMasterDB->insert('cbsmailer_report',$varFieldsFields,$varFieldsFieldsValues);
  
	// FOR LOG
	$varLogContent .=" ,Sent Count = ".$varSentCount;
	$varLogContent .= " ,Last Email Sent To = ".$varLastMatriId."\n";
  
  // for email 
  $varMessage.='<tr style="font: normal 11px verdana,tahoma;padding-bottom:15px;padding-top:10px;" ><td width="50%" align="center">'.$varMailerType.'</td><td width="50%" align="center">'.count($varFileName).'</td><td width="50%" align="center">'.$varSentCount.'</td></tr>';

$varMessage.='</table>';

//FILE NAME
$varLogFilename= 'inactivecount._'.date('Y-m-d').'txt';

//DELETE FILE
@unlink("/home/product/community/inactive/log/".$varLogFilename);

//CREATE FILE
$varFileHandler	= fopen("/home/product/community/inactive/log/".$varLogFilename,"w");
fwrite($varFileHandler,$varLogContent);
fclose($varFileHandler);

$varFieldsFrom = "webmaster";
$varFieldsFromEmailAddress  	= "admin@communitymatrimony.com";
$varFieldsTo					= "Community Matrimony report";
$varFieldsToEmailAddress 		= "ashokkumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com";
$varFieldsSubject		   		= "[Community Matrimony - CBS]".strftime("%d-%B-%Y",strtotime($varCurrentDate))."][Inactive Profile Details]";
$varFieldsReplyToEmailAddress = "webmaster@communitymatrimony.com";

$objMailManager->sendEmail($varFieldsFrom,$varFieldsFromEmailAddress,$varFieldsTo,$varFieldsToEmailAddress,$varFieldsSubject,$varMessage,$varFieldsReplyToEmailAddress);

}
?>