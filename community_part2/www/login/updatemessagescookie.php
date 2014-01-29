<?php

//FILE INCLUDES

$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

$varDomainName = $confValues['DOMAINNAME'];

//OBJECT DECLARTION
$objUpdateMasterDB	= new DB;

//DB CONNECTION
$objUpdateMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//set message and list related cookies
function setMessagesCookie($varMatriId,$objName) {
  global $varTable,$objUpdateMasterDB,$confValues;
  $argCondition	= " WHERE MatriId=".$objName->doEscapeString($varMatriId,$objName);
  $varNoOfRecord	= $objName->numOfRecords($varTable['MEMBERSTATISTICS'], 'MatriId', $argCondition);

  if ($varNoOfRecord==1) {
	//FOR MESSAGES AND INTEREST
	$argFields		= array('Interest_Pending_Received','Interest_Accept_Received','Interest_Declined_Received','Interest_Pending_Sent','Interest_Accept_Sent', 'Interest_Declined_Sent','Mail_Read_Received','Mail_UnRead_Received','Mail_Replied_Received','Mail_Declined_Received','Mail_Read_Sent','Mail_UnRead_Sent','Mail_Replied_Sent','Mail_Declined_Sent','ProfilesBookmarked','ProfilesBlocked','ProfilesIgnored','ViewedByVisitor');
	$varExecute		= $objName->select($varTable['MEMBERSTATISTICS'], $argFields, $argCondition,0);
	$varStatInfo	= mysql_fetch_assoc($varExecute);

	$varTotalRequest	= 0;
	$varMessagesInfo	= $varStatInfo['Mail_UnRead_Received'].'^|'.$varStatInfo['Mail_Read_Received'].'^|'.$varStatInfo['Mail_Replied_Received'].'^|'.$varStatInfo['Mail_Declined_Received'].'^|'.$varStatInfo['Mail_UnRead_Sent'].'^|'.$varStatInfo['Mail_Read_Sent'].'^|'.$varStatInfo['Mail_Replied_Sent'].'^|'.$varStatInfo['Mail_Declined_Sent'].'^|'.$varStatInfo['Interest_Pending_Received'].'^|'.$varStatInfo['Interest_Accept_Received'].'^|'.$varStatInfo['Interest_Declined_Received'].'^|'.$varStatInfo['Interest_Pending_Sent'].'^|'.$varStatInfo['Interest_Accept_Sent'].'^|'.$varStatInfo['Interest_Declined_Sent'].'^|'.$varTotalRequest;

	$varListInfo	= $varStatInfo['ProfilesBookmarked'].'^|'.$varStatInfo['ProfilesBlocked'].'^|'.$varStatInfo['ProfilesIgnored'];
	
	$varViewedByVisitorinfo	= $varStatInfo['ViewedByVisitor'];

   } else {

	$argFields		= array('MatriId');
	$argFieldsValue	= array($objUpdateMasterDB->doEscapeString($varMatriId,$objUpdateMasterDB));
	$objUpdateMasterDB->insert($varTable['MEMBERSTATISTICS'], $argFields, $argFieldsValue);
	$varMessagesInfo	= '0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0^|0';
    $varListInfo	= '0^|0^|0';
   }//else
   setrawcookie("messagesInfo",$varMessagesInfo, "0", "/",$confValues['DOMAINNAME']);
   setrawcookie("listInfo",$varListInfo, 0, "/",$confValues['DOMAINNAME']);
   setrawcookie("viewedbyvisitorinfo",$varViewedByVisitorinfo, 0, "/",$confValues['DOMAINNAME']);
}

//set request received(photo,phone,horoscope) cookies
function setRequestReceivedCookie($varMatriId,$objName) {
	global $varTable,$confValues;
	$varDomainName	= $confValues["DOMAINNAME"];

	//SELECT RECV REQUEST COUNT
	$varFields		= array('RequestFor', 'COUNT(ReceiverId) AS CNT');
	$argCondition	= " WHERE ReceiverId=".$objName->doEscapeString($varMatriId,$objName)." AND Delete_Status=0 GROUP BY RequestFor";
	$varReqRecvRes	= $objName->select($varTable['REQUESTINFORECEIVED'], $varFields, $argCondition, 0);

	$varPhotoCnt=0; $varPhoneNoCnt=0; $varRefCnt=0; $varVoiceCnt=0; $varHoroCnt=0;
	while($varRow = mysql_fetch_assoc($varReqRecvRes))
	{
		switch($varRow['RequestFor'])
		{
			case 1: $varPhotoCnt	= $varRow['CNT'];break;
			//case 2: $varRefCnt		= $varRow['CNT'];break;
			case 3: $varPhoneNoCnt	= $varRow['CNT'];break;
			//case 4: $varVoiceCnt	= $varRow['CNT'];break;
			case 5: $varHoroCnt		= $varRow['CNT'];break;
		}
	}

	$varRequestReceivedValue	= $varPhotoCnt.'^|'.$varPhoneNoCnt.'^|'.$varHoroCnt;
	setrawcookie("requestReceivedInfo",$varRequestReceivedValue, "0", "/",$varDomainName);
}

//set request sent(photo,phone,horoscope) cookies
function setRequestSentCookie($varMatriId,$objName) {
	global $varTable,$confValues;
	$varDomainName	= $confValues["DOMAINNAME"];

	//SELECT SENT REQUEST COUNT
	$varFields		= array('RequestFor', 'COUNT(SenderId) AS CNT');
	$argCondition	= " WHERE SenderId=".$objName->doEscapeString($varMatriId,$objName)." AND Delete_Status=0 GROUP BY RequestFor";
	$varReqSentRes	= $objName->select($varTable['REQUESTINFOSENT'], $varFields, $argCondition, 0);

	$varPhotoCnt=0; $varPhoneNoCnt=0; $varRefCnt=0; $varVoiceCnt=0; $varHoroCnt=0;
	while($varRow = mysql_fetch_assoc($varReqSentRes))
	{
		switch($varRow['RequestFor'])
		{
			case 1: $varPhotoCnt	= $varRow['CNT'];break;
			//case 2: $varRefCnt		= $varRow['CNT'];break;
			case 3: $varPhoneNoCnt	= $varRow['CNT'];break;
			//case 4: $varVoiceCnt	= $varRow['CNT'];break;
			case 5: $varHoroCnt		= $varRow['CNT'];break;
		}
	}

	$varRequestSentValue	= $varPhotoCnt.'^|'.$varPhoneNoCnt.'^|'.$varHoroCnt;
	setrawcookie("requestSentInfo",$varRequestSentValue, "0", "/",$varDomainName);
}

function setViewsInfoCookie($varMatriId,$objName) {
	global $varTable,$varDbInfo,$confValues; //viewsInfo

	$varDomainName	= $confValues["DOMAINNAME"];

	//GET PHONE NUMBER VIEWED BY ME
	$argCondition		= "WHERE Opposite_MatriId=".$objName->doEscapeString($varMatriId,$objName);
	$varPhoneByMeCnt	= $objName->numOfRecords($varTable['PHONEVIEWLIST'], 'Opposite_MatriId', $argCondition);

	//GET PHONE NUMBER VIEWED BY OTHER
	$argCondition		= "WHERE MatriId=".$objName->doEscapeString($varMatriId,$objName);
	$varPhoneByOtherCnt	= $objName->numOfRecords($varTable['PHONEVIEWLIST'], 'MatriId', $argCondition);

	$varViewsValue	= $varPhoneByMeCnt.'^|'.$varPhoneByOtherCnt.'^|'.$varProfileViewedCnt;
	setrawcookie("phoneviewsInfo",$varViewsValue, "0", "/",$varDomainName);
} 

?>