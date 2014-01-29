<?php
#================================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-02-12
# End Date		: 2010-02-12
# Project		: CommunityMatrimony
# Module		: Login Remainder Text File Creation
#================================================================================================================

//FILE INCLUDES
include_once('/home/product/community/conf/config.cil14');
include_once('/home/product/community/conf/ip.cil14');
include_once('/home/product/community/conf/dbinfo.cil14');
include_once('/home/product/community/lib/clsDB.php');

//VARIABLE DECLARATION
$cnt=0;
$finc=0;
$varContent	= '';
$fileNames	= '';


//OBJECT DECLARATION
$objDB		= new DB;
$objDB->dbConnect('S', $varDbInfo['DATABASE']);

//CHECK DB CONECTION STATUS
if($objDB->clsErrorCode){
	echo "DataBase Connection Error.";
	exit;
}

//Query to get the records from memberinfo and memberlogininfo
$before15days  = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-15,date("Y")));
//$before6months = date("Y-m-d",mktime(0,0,0,date("m")-6 ,date("d"),date("Y")));
$yesterday     = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-1,date("Y")));
$today         = date("Y-m-d");
if($argv[1]=='LoginRemainder'){
	//$varQuery	= "SELECT A.Email,A.Password,A.MatriId, B.Nick_Name, B.Name,B.CommunityId,B.Paid_Status FROM communitymatrimony.memberlogininfo A, communitymatrimony.memberinfo B WHERE A.MatriId=B.MatriId AND B.Publish<=2 AND B.CommunityId NOT IN (2007,2008) AND  B.Last_Login >='".$before15days." 00:00:00' AND B.Last_Login <='".$before15days." 23:59:59'";
	$varQuery	= "SELECT A.Email,A.Password,A.MatriId, B.Nick_Name, B.Name,B.CommunityId,B.Paid_Status FROM communitymatrimony.memberlogininfo A, communitymatrimony.memberinfo B WHERE A.MatriId=B.MatriId AND B.Publish<=2 AND B.CommunityId NOT IN (2007,2008) AND DATE(B.Last_Login)!=DATE(NOW()) AND MOD(DATEDIFF(NOW(), B.Last_Login),15)=0";
}

//Query to get the records from interestreceivedinfo
if($argv[1]=='ExpressInterest'){
	$varQuery	= "SELECT MatriId,Interest_Pending_Received FROM memberstatistics WHERE Interest_Pending_Received>0";
}

//Query to get the records from mailreceivedinfo
if($argv[1]=='PersonalizedMessages'){
	$varQuery	= "SELECT MatriId,Mail_UnRead_Received FROM memberstatistics WHERE Mail_UnRead_Received>0";
}

if($varQuery){
	$varResult  = mysql_query($varQuery) OR die('error');
	$varNo		= mysql_num_rows($varResult);


	while($row = mysql_fetch_assoc($varResult)) {
		$cnt++;

		//LOGIN REMAINDER LOGIC PART START HERE
		if($argv[1]=='LoginRemainder'){
				$varNickName	= $row['Nick_Name'];
				$varName		= $varNickName ? $varNickName : $row['Name'];

				//Get all opposite matriid
				$argFields				= array('Opposite_MatriId');
				$argCondition			= " WHERE MatriId='".$row['MatriId']."' AND Status=0";
				$mailreceivedDB			= $objDB->select('communitymatrimony.mailreceivedinfo', $argFields, $argCondition, 0);
				$varOppositeMatriIdCnt	= mysql_num_rows($mailreceivedDB);

				$arrOppositeMatriId		= array();
				$arrNotPublishedMatriId = array();
				if($varOppositeMatriIdCnt>0) {

					while($resMailreceivedDB	= mysql_fetch_assoc($mailreceivedDB)) {
						$arrOppositeMatriId[]	= $resMailreceivedDB['Opposite_MatriId'];
					}
					$strOppositeMatriId	= "'".implode("','",$arrOppositeMatriId)."'";

					//get mail received count for not published profile
					$funCondition				= " WHERE MatriId IN (".$strOppositeMatriId.") AND Publish!=1";
					$varNotPublishedMatriIdCnt	= $objDB->numOfRecords('communitymatrimony.memberinfo', 'MatriId', $funCondition);

					if($varNotPublishedMatriIdCnt>0) {
						//get not published matriids
						$argFields					= array('MatriId');
						$argCondition				= " WHERE MatriId IN (".$strOppositeMatriId.") AND Publish!=1";
						$varNotPublishedMatriIds	= $objDB->select('communitymatrimony.memberinfo', $argFields, $argCondition, 0);
						while($varNotPublishedMatriIdsRes = mysql_fetch_assoc($varNotPublishedMatriIds)) {
							$arrNotPublishedMatriId[] = $varNotPublishedMatriIdsRes['MatriId'];
						}
					}

					$varMailPendingCount = count(array_diff($arrOppositeMatriId,$arrNotPublishedMatriId));
				} else {
					$varMailPendingCount = 0;
				}

				//Get all opposite matriid
				$argFields					= array('Opposite_MatriId');
				$argCondition				= " WHERE MatriId='".$row['MatriId']."' AND Status=0";
				$interestreceivedDB			= $objDB->select('communitymatrimony.interestreceivedinfo', $argFields, $argCondition, 0);
				$varOppositeMatriIdIntCnt	= mysql_num_rows($interestreceivedDB);

				$arrOppositeMatriIdInt		= array();
				$arrNotPublishedMatriIdInt	= array();
				if($varOppositeMatriIdIntCnt>0) {

					while($resInterestReceivedDB = mysql_fetch_assoc($interestreceivedDB)) {
						$arrOppositeMatriIdInt[] = $resInterestReceivedDB['Opposite_MatriId'];
					}
					$strOppositeMatriIdInt	= "'".implode("','",$arrOppositeMatriIdInt)."'";

					//get mail received count with profile status 1
					$funCondition				= " WHERE MatriId IN (".$strOppositeMatriIdInt.") AND Publish!=1";
					$varNotPublishedMatriIdIntCnt= $objDB->numOfRecords('communitymatrimony.memberinfo', 'MatriId', $funCondition);

					if($varNotPublishedMatriIdIntCnt>0) {
						//get not published matriids
						$argFields					= array('MatriId');
						$argCondition				= " WHERE MatriId IN (".$strOppositeMatriIdInt.") AND Publish!=1";
						$varNotPublishedMatriIdsInt	= $objDB->select('communitymatrimony.memberinfo', $argFields, $argCondition, 0);
						while($varNotPublishedMatriIdsIntRes = mysql_fetch_assoc($varNotPublishedMatriIdsInt)) {
							$arrNotPublishedMatriIdInt[] = $varNotPublishedMatriIdsIntRes['MatriId'];
						}
					}

					$varInterestPendingCount = count(array_diff($arrOppositeMatriIdInt,$arrNotPublishedMatriIdInt));
				} else {
					$varInterestPendingCount = 0;
				}

				//CONTENT FORMATION
				$varContent .= $cnt.'~'.$row['MatriId'].'~'.$row['Email'].'~'.$row['Password'].'~'.$row['CommunityId'].'~'.$row['Paid_Status'].'~'.$varName.'~'.$varMailPendingCount.'~'.$varInterestPendingCount."\n";

				//$varFilename= "LoginReminder_count_".date('Ymd').'.txt';
				$varFilename= "/home/product/community/remindermailer/loginreminder/LoginReminder_".date('Ymd').'_count.txt';


		}
		//LOGIN REMAINDER LOGIC PART END HERE

		//EXPRESS INTEREST LOGIC PART START HERE
		if($argv[1]=='ExpressInterest'){

				//QUERY TO GET THE RECORDS FROM memberinfo
				$memberinfoQuery	= "SELECT CommunityId,Nick_Name,Name,Last_Login,Paid_Status FROM communitymatrimony.memberinfo WHERE MatriId='".$row['MatriId']."'";
				$memberinfoDB     = mysql_query($memberinfoQuery) OR die('error');
				$memberinfoResult = mysql_fetch_assoc($memberinfoDB);
				$varNickName	= $memberinfoResult['Nick_Name'];
				$varName		= $varNickName ? $varNickName : $memberinfoResult['Name'];

				//QUERY TO GET THE RECORDS FROM memberlogininfo
				$memberLogininfoQuery	= "SELECT Email FROM communitymatrimony.memberlogininfo WHERE MatriId='".$row['MatriId']."'";
				$memberLogininfoDB		= mysql_query($memberLogininfoQuery) OR die('error');
				$memberLogininfoResult	= mysql_fetch_assoc($memberLogininfoDB);

				$argFields	= array('Opposite_MatriId','Interest_Id');
				$argCondition	= " WHERE MatriId='".$row['MatriId']."' AND Status=0 ORDER BY Interest_Id DESC";
				$interestreceivedinfoQuery	= $objDB->select('communitymatrimony.interestreceivedinfo', $argFields, $argCondition, 0);
				$varOppositeMatriIdCnt	= mysql_num_rows($interestreceivedinfoQuery);

				$arrOppositeMatriId		= array();
				$arrNotPublishedMatriId = array();
				$arrInterestRecvdId		= array();

				if($varOppositeMatriIdCnt>0) {

					while($resInterestReceivedInfo	= mysql_fetch_assoc($interestreceivedinfoQuery)) {
						$arrOppositeMatriId[]	= $resInterestReceivedInfo['Opposite_MatriId'];
						$arrInterestRecvdId[]	= $resInterestReceivedInfo['Interest_Id'];
					}
					$strOppositeMatriId	= "'".implode("','",$arrOppositeMatriId)."'";

					//get interest received count for not published profile
					$funCondition				= " WHERE MatriId IN (".$strOppositeMatriId.") AND Publish!=1";
					$varNotPublishedMatriIdCnt	= $objDB->numOfRecords('communitymatrimony.memberinfo', 'MatriId', $funCondition);

					if($varNotPublishedMatriIdCnt>0) {
						//get not published matriids
						$argFields					= array('MatriId');
						$argCondition				= " WHERE MatriId IN (".$strOppositeMatriId.") AND Publish!=1";
						$varNotPublishedMatriIds	= $objDB->select('communitymatrimony.memberinfo', $argFields, $argCondition, 0);
						while($varNotPublishedMatriIdsRes = mysql_fetch_assoc($varNotPublishedMatriIds)) {
							$arrNotPublishedMatriId[] = $varNotPublishedMatriIdsRes['MatriId'];
						}
					}

					$varInterestPendingRecvdCount = count(array_diff($arrOppositeMatriId,$arrNotPublishedMatriId));
				} else {
					$varInterestPendingRecvdCount = 0;
				}

				if($varInterestPendingRecvdCount>0 && $varOppositeMatriIdCnt>0) {

					foreach($arrOppositeMatriId as $key=>$varRecentOppositeMatriId) {
						//cehck publish condition for recent profile
						$funCondition				= " WHERE MatriId ='".$varRecentOppositeMatriId."' AND Publish=1";
						$varRecentPublishedMatriIdCnt	= $objDB->numOfRecords('communitymatrimony.memberinfo', 'MatriId', $funCondition);

						if($varRecentPublishedMatriIdCnt>0) {
							$varLatestOppositeMatriId = $varRecentOppositeMatriId;
							$varLatestInterestIdRecvd = $arrInterestRecvdId[$key];
							break;
						}
					}

					//CONTENT FORMATION
					$varContent .= $cnt.'~'.$row['MatriId'].'~'.$memberLogininfoResult['Email'].'~'.$memberinfoResult['Last_Login'].'~'.$varInterestPendingRecvdCount.'~'.$varLatestOppositeMatriId.'~'.$memberinfoResult['CommunityId'].'~'.$varName.'~'.$memberinfoResult['Paid_Status'].'~'.$varLatestInterestIdRecvd."\n";
				}

				//$varFilename= "ExpressInterest_count_".date('Ymd').'.txt';
				$varFilename= "/home/product/community/remindermailer/expintpending/ExpressInterest_".date('Ymd').'_count.txt';


		}
		//EXPRESS INTEREST LOGIC PART END HERE

		//PERSONALIZED MESSAGES LOGIC PART START HERE
		if($argv[1]=='PersonalizedMessages'){

				//QUERY TO GET THE RECORDS FROM memberinfo
				$memberinfoQuery	= "SELECT CommunityId,Nick_Name,Name,Last_Login,Paid_Status FROM communitymatrimony.memberinfo WHERE MatriId='".$row['MatriId']."'";
				$memberinfoDB     = mysql_query($memberinfoQuery) OR die('error');
				$memberinfoResult = mysql_fetch_assoc($memberinfoDB);
				$varNickName	= $memberinfoResult['Nick_Name'];
				$varName		= $varNickName ? $varNickName : $memberinfoResult['Name'];

				//QUERY TO GET THE RECORDS FROM memberlogininfo
				$memberLogininfoQuery	= "SELECT Email FROM communitymatrimony.memberlogininfo WHERE MatriId='".$row['MatriId']."'";
				$memberLogininfoDB		= mysql_query($memberLogininfoQuery) OR die('error');
				$memberLogininfoResult	= mysql_fetch_assoc($memberLogininfoDB);

				$argFields	= array('Opposite_MatriId','Mail_Id');
				$argCondition	= " WHERE MatriId='".$row['MatriId']."' AND Status=0 ORDER BY Mail_Id DESC";
				$mailreceivedinfoQuery	= $objDB->select('communitymatrimony.mailreceivedinfo', $argFields, $argCondition, 0);
				$varOppositeMatriIdCnt	= mysql_num_rows($mailreceivedinfoQuery);

				$arrOppositeMatriId		= array();
				$arrNotPublishedMatriId = array();
				$arrMailRecvdId			= array();

				if($varOppositeMatriIdCnt>0) {

					while($resMailReceivedInfo	= mysql_fetch_assoc($mailreceivedinfoQuery)) {
						$arrOppositeMatriId[]	= $resMailReceivedInfo['Opposite_MatriId'];
						$arrMailRecvdId[]	= $resMailReceivedInfo['Mail_Id'];
					}
					$strOppositeMatriId	= "'".implode("','",$arrOppositeMatriId)."'";

					//get interest received count for not published profile
					$funCondition				= " WHERE MatriId IN (".$strOppositeMatriId.") AND Publish!=1";
					$varNotPublishedMatriIdCnt	= $objDB->numOfRecords('communitymatrimony.memberinfo', 'MatriId', $funCondition);

					if($varNotPublishedMatriIdCnt>0) {
						//get not published matriids
						$argFields					= array('MatriId');
						$argCondition				= " WHERE MatriId IN (".$strOppositeMatriId.") AND Publish!=1";
						$varNotPublishedMatriIds	= $objDB->select('communitymatrimony.memberinfo', $argFields, $argCondition, 0);
						while($varNotPublishedMatriIdsRes = mysql_fetch_assoc($varNotPublishedMatriIds)) {
							$arrNotPublishedMatriId[] = $varNotPublishedMatriIdsRes['MatriId'];
						}
					}

					$varMailPendingRecvdCount = count(array_diff($arrOppositeMatriId,$arrNotPublishedMatriId));
				} else {
					$varMailPendingRecvdCount = 0;
				}

				if($varMailPendingRecvdCount>0 && $varOppositeMatriIdCnt>0) {

					foreach($arrOppositeMatriId as $key=>$varRecentOppositeMatriId) {
						//cehck publish condition for recent profile
						$funCondition				= " WHERE MatriId ='".$varRecentOppositeMatriId."' AND Publish=1";
						$varRecentPublishedMatriIdCnt	= $objDB->numOfRecords('communitymatrimony.memberinfo', 'MatriId', $funCondition);

						if($varRecentPublishedMatriIdCnt>0) {
							$varLatestOppositeMatriId = $varRecentOppositeMatriId;
							$varLatestMailIdRecvd = $arrMailRecvdId[$key];
							break;
						}
					}


					//CONTENT FORMATION
					$varContent .= $cnt.'~'.$row['MatriId'].'~'.$memberLogininfoResult['Email'].'~'.$memberinfoResult['Last_Login'].'~'.$varMailPendingRecvdCount.'~'.$varLatestOppositeMatriId.'~'.$memberinfoResult['CommunityId'].'~'.$varName.'~'.$memberinfoResult['Paid_Status'].'~'.$varLatestMailIdRecvd."\n";
				}

				//$varFilename= "PersonalizedMessages_count_".date('Ymd').'.txt';
				$varFilename= "/home/product/community/remindermailer/msgpending/PersonalizedMessages_".date('Ymd').'_count.txt';


		}
		//PERSONALIZED MESSAGES LOGIC PART END HERE

		if($cnt==$varNo){
			$part_cnt=$varNo;
		}else{
			$part_cnt=800000;
		}
		if(($cnt%$part_cnt)==0){//800000
			//CREATE FILE
			$finc++;
			$varFilename=str_replace('count',$finc,$varFilename);
			$varFileHandler	= fopen($varFilename,"w");
			fwrite($varFileHandler,$varContent);
			fclose($varFileHandler);
			$varContent ='';
			$fileNames	.=$varFilename."<br>";

		}
	}
}
?>