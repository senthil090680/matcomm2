<?php
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		:
#================================================================================================================
   # Description	:
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/lib/clsMailManager.php");

$objSlaveDB			= new MailManager;
$objMasterDB		= new MailManager;

$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$varOppositeMatriId	= $_POST['problemid'];
$varPhoneDetail		= str_replace("~","-",trim($_POST['phonedetail']));
$varSenderId		= $_POST['senderid'];
$varComplaint		= trim($_POST['complaint']);
$varDateTime		= date("Y-m-d H:i:s");

//check complaint already posted or not
$varCondition		= " WHERE Complaint_On =".$objSlaveDB->doEscapeString($varOppositeMatriId,$objSlaveDB)."  AND Complaint_By=".$objSlaveDB->doEscapeString($varSenderId,$objSlaveDB)." AND Request_Closed=0";
$varTotComplRecords	= $objSlaveDB->numOfRecords($varTable['PHONENOTWORK_LOG'], $argPrimary='Id', $varCondition);

if($varTotComplRecords==0) {
	$varFields			= array('Complaint_On','Complaint_By','Complaint_Tag','Request_Received');
	$varFieldsValues	= array($objMasterDB->doEscapeString($varOppositeMatriId,$objMasterDB),$objMasterDB->doEscapeString($varSenderId,$objMasterDB),$objMasterDB->doEscapeString($varComplaint,$objMasterDB),"'".$varDateTime."'");
	$varResult	= $objMasterDB->insert($varTable['PHONENOTWORK_LOG'], $varFields, $varFieldsValues);
}

if ($varComplaint ==1 ) {
	$varContent.="Thank you for bringing to our notice that the phone number of $varOppositeMatriId is not working. We will look into the issue and get it sorted out at the earliest.";
} elseif ($varComplaint ==2 ) {
	$varContent.="Thank you for bringing to our notice that the phone number of $varOppositeMatriId has changed. We will look into the issue and get it sorted out at the earliest.";
} elseif ($varComplaint ==3 ) {
	$varContent.="Thank you for bringing to our notice that the member has already got married.";
}
echo "<div class='normtxt'>".$varContent."<div>";

$objSlaveDB->dbClose();
$objMasterDB->dbClose();
UNSET($objSlaveDB);
UNSET($objMasterDB);
?>