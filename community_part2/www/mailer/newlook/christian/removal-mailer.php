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
include_once($varRootPath."/mailer/newlook/christian/removal-tmpl.php");

//OBJECT DECLARATION
$objMailManager = new MailManager;

for($i=0; $i<1; $i++){
	
	//CONTROL STATEMENT
	$varAllDetails	= file($varRootPath.'/mailer/newlook/christian/userinfo.txt');
	$varSleepCount  = 0;

	foreach($varAllDetails as $varSingleDetail)
	{
		$varNewMatriId	= '';
		$varToEmail		= '';
		$varServerUrl	= '';
		$varCasteTxt	= '';
		$varSubject		= '';
		$varDomain		= '';
		$varFrom		= '';
		$varFromEmail	= '';
		$varContent		= '';
		$varReplyToEmail= '';

		$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
		$varNewMatriId	= $varUserInfo[1];
		$varToEmail		= $varUserInfo[3];
		$varMatriIdPref	= substr($varNewMatriId, 0, 3);

		//VARIABLE DECLARATION
		$varDomain		= $arrPrefixDomainList[$varMatriIdPref];;
		$varFrom		= ucfirst($varDomain);
		$varFromEmail	= "info@".$varDomain;
		$varServerUrl	= 'http://www.'.$varDomain;
		$varCasteTxt	= ucfirst(substr($arrPrefixDomainList[$varMatriIdPref],0,-13));
		
		$varContent		= stripslashes($varTemplate);
		$varMessage2	= str_replace('<--SERVERURL-->',$varServerUrl,$varContent);
		
		$varSubject		= 'More features will be added to your profile soon.';
		$varReplyToEmail= 'helpdesk@'.$varDomain;
		print $varToEmail.'----'.$varMatriIdPref.'----'.$varReplyToEmail."\n";

		$objMailManager->sendEmail($varFrom,$varFromEmail,$varNewMatriId,$varToEmail,$varSubject,$varMessage2,$varReplyToEmail);	
		if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
		$varSleepCount++;
	}//foreach
}

//UNSET OBJECT
UNSET($objMailManager);
?>