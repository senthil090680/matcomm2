<?php
/*******************************************************************************************************************
File    : addprivilege.php
Author  : Baranidharan. S.
Date    : 03-Sept-2010
********************************************************************************************************************
Description:
This page contains the record insertion in privilege matrimony details database.
********************************************************************************************************/
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//file includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsReport.php');

//OBJECT DECLARTION
$objRegister	= new DB;
$objReport	    = new Report;

//CONNECT DATABASE
$objRegister->dbConnect('PRIVILEGE',$varPrivilegeDbInfo['DATABASE']);

$varName	= trim($_POST["name"]);
$varPhone	= trim($_POST["phone"]);
$varCity	= trim($_POST["city"]);
if($varName != '' && $varName != 'Name' && $varPhone != '' && $varPhone != 'Phone number' && $varCity != '' && $varCity != 'City') {
	if($_COOKIE['INTERESTED']!=1){
		setcookie("INTERESTED",1,time()+600);
		$mailSent=sentMailToUser($varName,$varPhone,$varCity,$objReport);
		$varFields		= array('Matriid','Name','City','MobileNo','RequestedFrom','InvitedDate','EmailSent');
		$varFieldsValues = array($objRegister->doEscapeString($varGetCookieInfo["MATRIID"],$objRegister),$objRegister->doEscapeString($varName,$objRegister),$objRegister->doEscapeString($varCity,$objRegister),$objRegister->doEscapeString($varPhone,$objRegister),"'".$varUcDomain." Matrimony'",'NOW()',$mailSent);
		$res=$objRegister->insert($varTable['BMPINVITEINFO'],$varFields,$varFieldsValues);
	}
}

function sentMailToUser($varName,$varPhone,$varCity,$objReport) {
global $varDomain,$varUcDomain;
$argFrom = $varUcDomain." Matrimony";
$varDomain = $varDomain."matrimony.com";
$argFromEmailAddress  	= "info@$varDomain";
$argTo					= "Privilege Matrimony";

	$argToEmailAddress 		= "subha@bharatmatrimony.com,dimple@bharatmatrimony.com";
	//$argToEmailAddress = "padmanaban@consim.com,baranidharan.m@bharatmatrimony.com";
	$argSubject		   		= "Interested in Privilege Membership";
$argReplyToEmailAddress = $argFromEmailAddress;
$varMessage= "Dear Team <br><br>";
     $varMessage.="<b>Congrats! Someone is interested in our PrivilegeMembership.</b><br><br>
     We have provided the details of the interested person below. Please go through it and initiate the         process.<br><br>"; 
     $varMessage.=" Name of the interested person: $varName  <br>\n Mobile No:$varPhone <br>\n City: $varCity <br><br>Best of luck! <br> Community Matrimony Team</br>";
$varMailSend			= $objReport->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$varMessage,$argReplyToEmailAddress);
if($varMailSend == 'yes')
 return 1;
else
 return 0;
}

$objRegister->dbClose();
UNSET($objRegister);
UNSET($objReport);
?>