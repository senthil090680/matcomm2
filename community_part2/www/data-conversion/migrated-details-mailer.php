<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//FILE INCLUDES
include_once($varBaseRoot."/conf/domainlist.cil14");
include_once($varBaseRoot."/lib/clsMailManager.php");
include_once($varRootPath."/data-conversion/migrated-details-tmpl.php");
include_once($varRootPath."/data-conversion/migrated-details-abltmpl.php");
include_once($varRootPath."/data-conversion/migrated-details-fpmtmpl.php");
include_once($varRootPath."/data-conversion/migrated-details-deftmpl.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;

//CONTROL STATEMENT
$varAllDetails	= file($varRootPath.'/data-conversion/pro-user-info0.txt');
$varSleepCount  = 0;
$arrNewTemplate = array('ABL','FPM','DEF');
foreach($varAllDetails as $varSingleDetail)
{
	$varNewMatriId	= '';
	$varToEmail		= '';
	$varMessage		= '';
	$varMailImgsUrl	= '';
	$varServerUrl	= '';
	$varLogoUrl		= '';
	$varDomainName	= '';
	$varSubject		= '';
	$varDomain		= '';
	$varFrom		= '';
	$varFromEmail	= '';
	$varContent		= '';
	$varReplyToEmail= '';

	$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
	$varNewMatriId	= $varUserInfo[1];
	$varName		= $varUserInfo[2];
	$varToEmail		= $varUserInfo[4];
	$varMatriIdPref	= substr($varNewMatriId, 0, 3);

	//VARIABLE DECLARATION
	$varDomain		= $arrPrefixDomainList[$varMatriIdPref];
	$varFrom		= ucfirst($varDomain);
	$varFromEmail	= "info@".$varDomain;
	$varMailImgsUrl	= 'http://www.'.$varDomain.'/mailer/images';
	$varServerUrl	= 'http://www.'.$varDomain;
	$varLogoUrl		= 'http://img.'.$varDomain.'/images/logo/'.$arrFolderNames[$varMatriIdPref].'_logo.gif';
	$varDomainName	= ucfirst(substr($varDomain,0,-13));
	
	$varNewTemplate = 'var'.$varMatriIdPref.'Template';
	$varContent		= in_array($varMatriIdPref, $arrNewTemplate) ? stripslashes($$varNewTemplate) : stripslashes($varTemplate); 

	$varMessage	= str_replace('<--LOGO-->',$varLogoUrl,$varContent);
	$varMessage	= str_replace('<--MAILERIMGPATH-->',$varMailImgsUrl,$varMessage);
	$varMessage	= str_replace('<--SERVERURL-->',$varServerUrl,$varMessage);
	$varMessage	= str_replace('<--DOMAIN-->',$varDomainName,$varMessage);
	$varMessage	= str_replace('<--NAME-->',$varName,$varMessage);
	$varMessage	= str_replace('<--EMAIL-->',$varToEmail,$varMessage);

	if($varContent != ''){
	$varSubject		= 'Your login information on '.$varDomainName.'Matrimony.com';
	$varReplyToEmail= 'helpdesk@'.$varDomain;
	
	$objMailManager->sendEmail($varFrom,$varFromEmail,$varNewMatriId,$varToEmail,$varSubject,$varMessage,$varReplyToEmail);	
	}

	if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
	//print $varToEmail.'~'.$varNewMatriId.'~'.$varFrom."\n";
	$varSleepCount++;
}//foreach

//UNSET OBJECT
UNSET($objMailManager);
?>
