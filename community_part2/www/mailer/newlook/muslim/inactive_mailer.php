<?php

//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//FILE INCLUDES
include_once($varBaseRoot."/conf/domainlist.inc");
include_once($varBaseRoot."/lib/clsMailManager.php");
include_once($varRootPath."/mailer/newlook/muslim/inactive_tmpl.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;

for($i=0; $i<1; $i++){
	
	//CONTROL STATEMENT
	$varAllDetails	= file($varRootPath.'/mailer/newlook/muslim/inactive_test.txt');
	$varSleepCount  = 0;

	//VARIABLE DECLARATION
	$varFrom		= "MuslimMatrimony.Com";
	$varFromEmail	= "info@muslimmatrimony.com";
	$varServerUrl	= 'http://www.muslimmatrmony.com';
	$varSubject		= 'More membership benefits with the revamp of MuslimMatrimony.com!';
	$varReplyToEmail= 'helpdesk@muslimmatrmony.com';
	$varContent		= stripslashes($varTemplate);

	foreach($varAllDetails as $varSingleDetail)
	{
		$varToEmail		= '';

		$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
		$varUserName	= $varUserInfo[0];
		$varToEmail		= $varUserInfo[1];
		
		print $varToEmail.'----'.$varReplyToEmail."\n";

		$objMailManager->sendEmail($varFrom,$varFromEmail,$varUserName,$varToEmail,$varSubject,$varContent,$varReplyToEmail);	
		if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
		$varSleepCount++;
	}//foreach
}

//UNSET OBJECT
UNSET($objMailManager);
?>