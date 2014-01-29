<?php

//FILE INCLUDES
include_once("/home/product/community/www/mailer/newlook/christian/inactive_tmpl.php");

function sendFreeToPaidEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress)
	{
		$funValue				= '';
		$funheaders				= '';
		$argFrom				= preg_replace("/\n/", "", $argFrom);
		$argFromEmailAddress	= preg_replace("/\n/", "", $argFromEmailAddress);
		$argReplyToEmailAddress	= preg_replace("/\n/", "", $argReplyToEmailAddress);
		$funheaders				.= "MIME-Version: 1.0\n";
		$funheaders				.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders				.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
		$funheaders				.= "Reply-To: ".$argFrom."<".$argReplyToEmailAddress.">\n";
		$funheaders				.= "Return-Path:<noreply@bounces.communitymatrimony.com>\n";
		$funheaders				.= "Sender:".$argFrom."<".$argFromEmailAddress.">\n";
		$argheaders				= $funheaders;
		$argToEmailAddress		= preg_replace("/\n/", "", $argToEmailAddress);

		if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders)) { $funValue = 'yes'; }//if

		return $funValue;
	}

for($i=0; $i<1; $i++){
	
	//CONTROL STATEMENT
	$varAllDetails	= file('/home/product/community/www/mailer/newlook/christian/inactive_user.txt');
	$varSleepCount  = 0;

	//VARIABLE DECLARATION
	$varFrom		= 'ChristianMatrimony.Com';
	$varFromEmail	= "info@christianmatrimony.com";
	$varServerUrl	= 'http://www.christianmatrimony.com';
	$varSubject		= 'More membership benefits with the revamp of ChristianMatrimony.com!';
	$varReplyToEmail= 'helpdesk@christianmatrimony.com';
	$varContent		= stripslashes($varTemplate);

	foreach($varAllDetails as $varSingleDetail)
	{
		$varToEmail		= '';

		$varUserInfo	= split('~',trim($varSingleDetail, "\n"));
		$varUserName	= $varUserInfo[0];
		$varToEmail		= $varUserInfo[1];
		
		print $varToEmail.'----'.$varMatriIdPref.'----'.$varReplyToEmail."\n";

		sendFreeToPaidEmail($varFrom,$varFromEmail,$varUserName,$varToEmail,$varSubject,$varContent,$varReplyToEmail);	
		if ($varSleepCount==1000) { sleep('5'); $varSleepCount=0;}//if
		$varSleepCount++;
	}//foreach
}

?>