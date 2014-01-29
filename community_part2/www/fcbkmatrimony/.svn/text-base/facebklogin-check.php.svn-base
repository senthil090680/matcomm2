<?php
#=============================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================
//FILE INCLUDES
include_once('../includes/config.php');
include_once('../includes/dbConn.php');
include_once('../registration/includes/registration-array-values.php');
require_once('includes/clsProductFacebook.php');

//CONFIG VALUES
$confDomainName	= $confValues["DomainName"];

//OBJECT DECLARTION
$objBasicRegistration = new QuickSearch;


//VARIABLE DECLARATIONS
$varCurrentDate							= date('Y-m-d H:i:s');
$varUsername							= trim($_REQUEST["idEmail"]);
$varPassword							= trim($_REQUEST["password"]);
$varCheckLogin							= 0;
$varChooseLogin							= 'no';
$varFacebook							= $_REQUEST["facebook"];

//CONTROL STATEMENTS
$objBasicRegistration->clsTable			= "memberlogininfo";

$objBasicRegistration->clsPrimary		= array('User_Name','Password');
$objBasicRegistration->clsPrimaryValue	= array($varUsername,md5($varPassword));
$objBasicRegistration->clsPrimaryKey	= array('AND','AND');
$objBasicRegistration->clsCountField	= 'User_Name';
$varCheckLogin							= $objBasicRegistration->numOfResults();

if($varCheckLogin==1) {
$objBasicRegistration->clsFields	= array('MatriId','User_Name','Password','Paid_Status','Valid_Days','Date_Paid');
$objBasicRegistration->clsPrimary		= array('User_Name');
$objBasicRegistration->clsPrimaryValue	= array($varUsername);
$varSelectLoginInfo					= $objBasicRegistration->selectListSearchResult();
$varMatriId							= $varSelectLoginInfo["MatriId"];
$varUsername						= $varSelectLoginInfo["User_Name"];
$varDBPassword						= $varSelectLoginInfo["Password"];

#SELECT Gender, Publish & Last Login
$objBasicRegistration->clsTable			= "memberinfo";
$objBasicRegistration->clsFields		= array('Last_Login','Publish','Gender');
$objBasicRegistration->clsPrimary		= array('User_Name');
$objBasicRegistration->clsPrimaryValue	= array($varUsername);
$varSelectMemberInfo					= $objBasicRegistration->selectListSearchResult();
$varLastLogin							= $varSelectMemberInfo['Last_Login'];
$varGender								= $varSelectMemberInfo['Gender'];
$varPublish								= $varSelectMemberInfo["Publish"];


//LOGIN INFO DETAILS
$varPaidDate							= $varSelectLoginInfo['Date_Paid'];
$varPaidStatus							= $varSelectLoginInfo['Paid_Status'];
$varValidDays							= $varSelectLoginInfo["Valid_Days"];

if ($varPublish==3){ echo '<script language="javascript">document.location.href="index.php?act=suspend-profile&sid='.$varUsername.'"</script>';exit; }//if
if($varPaidStatus==1)			
{
	$objBasicRegistration->clsTable		= "memberlogininfo";
	if(($varPaidDate !='0000-00-00 00:00:00') && ($varPaidDate !=''))
	{
		$varTodayDate			= date('m-d-Y');
		$varPaidDate			= date('m-d-Y',strtotime($varPaidDate));
		$varNumOfDays			= $objBasicRegistration->dateDiff("-",$varTodayDate,$varPaidDate);

		if($varNumOfDays > $varValidDays)
		{
			$varPaidStatus = 0;
			$objBasicRegistration->clsFields		= array('Paid_Status','Valid_Days','Date_Paid');
			$objBasicRegistration->clsFieldsValues	= array($varPaidStatus,'0','0000-00-00 00:00:00');
			$objBasicRegistration->updateQuickSearch();
		}
	}
	elseif($varPaidDate =='0000-00-00 00:00:00')
	{
		$varPaidStatus = 0;
		$objBasicRegistration->clsFields		= array('Paid_Status','Valid_Days');
		$objBasicRegistration->clsFieldsValues	= array($varPaidStatus,'0');
		$objBasicRegistration->updateQuickSearch();
	}//else
}//if


#UPDATE LAST LOGIN INTO memberinfo TABLE
$objBasicRegistration->clsTable			= "memberinfo";
$objBasicRegistration->clsFields		= array('Last_Login');
$objBasicRegistration->clsFieldsValues	= array($varCurrentDate);
$objBasicRegistration->updateQuickSearch();

#SET COOKIE
$varCrypt1	= crypt($varMatriId,$varSalt1);
$varCryptId	= crypt($varCrypt1,$varSalt2);
setcookie("LoginInfo","MatriId=$varMatriId&Gender=$varGender&Username=$varUsername&LastLogin=$varLastLogin&PaidStatus=$varPaidStatus&Publish=$varPublish&MyId=$varCryptId", "0", "/",$confDomainName);
//header("Set-Cookie: LoginInfo=MatriId=$varMatriId&Gender=$varGender&Username=$varUsername&LastLogin=$varLastLogin&PaidStatus=$varPaidStatus&Publish=$varPublish;path=/;domain=$confDomainName;");

//SELECT MESSAGE AND EXPRESS INTEREST DETAILS
$objBasicRegistration->clsTable			= "memberstatistics";
$objBasicRegistration->clsFieldsValues	= array($varMatriId);
$objBasicRegistration->clsPrimary		= array('MatriId');
$objBasicRegistration->clsPrimaryValue	= array($varMatriId);
$objBasicRegistration->clsCountField	= 'MatriId';
$varNoOfRecord							= $objBasicRegistration->numOfResults();

if ($varNoOfRecord==1)
{
	$objBasicRegistration->clsFields	= array('Interest_Pending_Received', 'Interest_Accept_Received', 'Interest_Declined_Received', 'Mail_Read_Received', 'Mail_UnRead_Received', 'Mail_Replied_Received', 'Mail_Declined_Received');
	$varSelectMyMessagesInfo			= $objBasicRegistration->selectListSearchResult();

	//INTEREST
	$varInterestPending		= $varSelectMyMessagesInfo['Interest_Pending_Received'];
	$varInterestAccept		= $varSelectMyMessagesInfo['Interest_Accept_Received'];
	$varInterestDeclined	= $varSelectMyMessagesInfo['Interest_Declined_Received'];
	$varTotalInterest		= ($varInterestPending + $varInterestAccept + $varInterestDeclined);

	//MAIL
	$varReadMail			= $varSelectMyMessagesInfo['Mail_Read_Received'];
	$varUnReadMail			= $varSelectMyMessagesInfo['Mail_UnRead_Received'];
	$varRepliedMail			= $varSelectMyMessagesInfo['Mail_Replied_Received'];
	$varDeclinedMail		= $varSelectMyMessagesInfo['Mail_Declined_Received'];
	$varTotalMail			= ($varReadMail + $varUnReadMail + $varRepliedMail + $varDeclinedMail);
	//echo 'if::';exit;
	$varMessagesInfo		= "NewMail=$varUnReadMail&TotalMail=$varTotalMail&NewInterest=$varInterestPending&TotalInterest=$varTotalInterest";
}//if
else
{
	//echo 'else::';exit;
	$objBasicRegistration->clsFields	= array('MatriId');
	//$objBasicRegistration->addQuickSearch();
	$varMessagesInfo	=	"NewMail=0&TotalMail=0&NewInterest=0&TotalInterest=0"; 
}//else

setrawcookie("MessagesInfo",$varMessagesInfo, "0", "/",$confDomainName);


//SELECT SAVED SEARCH DETAILS
$objBasicRegistration->clsTable			= "searchsavedinfo";
$objBasicRegistration->clsCountField	= 'Search_Id';
$objBasicRegistration->clsFieldsValues	= array($varMatriId);
$varNoOfRecord							= $objBasicRegistration->numOfResults();
if ($varNoOfRecord > 1)
{
	$objBasicRegistration->clsFields	= array('Search_Id','Search_Name','Search_Type');
	$varSelectSavedSearchInfo			= $objBasicRegistration->multiSelectListSearchResult();
	$varSavedSearchInfo					= '';
	for ($i=0;$i<$varNoOfRecord;$i++)
	{
		$varSearchId		= $varSelectSavedSearchInfo[$i]["Search_Id"];
		$varSearchType		= $varSelectSavedSearchInfo[$i]["Search_Type"];
		$varSearchName		= $varSelectSavedSearchInfo[$i]["Search_Name"];
		$varSavedSearchInfo	.= $varSearchId.'|'.$varSearchType.'|'.$varSearchName.'~';
	}//for
	setcookie("SavedSearchInfo",$varSavedSearchInfo, "0", "/",$confDomainName);
}//if

//	echo "sssssssss".$varSavedSearchInfo;exit;
if($varFacebook == 'yes')
{
	echo '<script language="javascript">document.location.href="../fcbkmatrimony/mypage.php"</script>';exit;
}
}
else { echo '<script language="javascript">document.location.href="../fcbkmatrimony/fckblogin.php?checklogin=0&frmLoginSubmit=yes"</script>';exit; }
?>