<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot."/lib/clsMailManager.php");

//Object Decleration
$objMailManager = new MailManager;

//Connect DB
$objMailManager->dbConnect('S', 'communitydba');

$varCurrDate	= date('Y-m-d');
$varWhereCond	= "WHERE Photo_Date_Updated>='".$varCurrDate." 00:00:00' AND Photo_Date_Updated<='".$varCurrDate." 23:59:59'";
$varPhotoCnt	= $objMailManager->numofrecords('comm_memberphotoinfo_missed', 'MatriId', $varWhereCond);

$varCurrDate	= date('Y-m-d', mktime(0, 0 , 0, date('m'), date('d')-1, date('Y')));
$varWhereCond	= "WHERE DateConfirmed>='".$varCurrDate." 00:00:00' AND DateConfirmed<='".$varCurrDate." 23:59:59'";
$varPhoneCnt	= $objMailManager->numofrecords('comm_assuredcontact_missed', 'MatriId', $varWhereCond);


$varContent		= '<table border="1"><tr><th>Feature</th><th>Count</th></tr>';
$varContent		.= '<tr><td>Photo</td><td>'.$varPhotoCnt.'</td></tr>'; 
$varContent		.= '<tr><td>Phone</td><td>'.$varPhoneCnt.'</td></tr></table>';

$varToMails			= array('Senthilnathan~senthilnathan@bharatmatrimony.com', 'Dhanapal~dhanapal@bharatmatrimony.com', 'Ashok~ashokkumar@bharatmatrimony.com');
$varCurrentDt		= date('jS M Y');
$varFrom			= "CommunityMatrimony.Com";
$varFromEmail		= "info@communitymatrimony.com";
$varReplyToEmail	= "info@communitymatrimony.com";
$varSubject			= $varCurrentDt." - Newly added Photo & Phone migration information";
foreach($varToMails as $varSingleDetail)
{
	$varUsername	= '';
	$varUserInfo	= '';
	$varMessage		= '';
	$varToEmail		= '';

	$varUserInfo	= split('~',$varSingleDetail);
	$varUsername	= $varUserInfo[0];
	$varToEmail		= $varUserInfo[1];	
	$varMessage		= "Dear ".$varUsername.", <BR><BR>".$varContent."<BR><BR>Thanks,<BR>CommunityMatrimony Team.";
	$objMailManager->sendEmail($varFrom,$varFromEmail,$varUsername,$varToEmail,$varSubject,$varMessage, $varReplyToEmail);	
}


//UNSET OBJECT
$objMailManager->dbClose();
UNSET($objMailManager);
?>
