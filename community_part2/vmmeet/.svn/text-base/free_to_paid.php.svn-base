<?
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Login
#=============================================================================================================

$varRootBasePath = '/home/product/community';
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');


$debug_it['br'] = "<br/><br/>";

//OBJECT DECLARATION
$objSlave = new DB;
$objOpen  = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);
$objOpen-> dbConnection('192.168.1.11','fireuser','firepass','openfire');

if(!$objSlave->clsErrorCode) {

	// To select the Matrimony meet EventID...
	// Query to be executed when this file is going to run in cron
	$varCondition		= " where DATEDIFF(NOW(),EventDate)=0";
    $varFields			=  array("EventId","EventTitle");
    $varConfDet	        = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields,$varCondition,1);
	
	// Query to be executed when this file is going to run Manually
	
	$affCnt = count($varConfDet);
	$sendMailCnt = 0;	
	if($affCnt > 0)	{
		
		$resultEventIds = $varConfDet;
		foreach($resultEventIds as  $resultEventId)	{
			$EId = $resultEventId['EventId'];			 // Event ID
			$ETitle = $resultEventId['EventTitle'];		 // Event TItle

			$debug_it['err'] .= $debug_it['br'] .$midSelectQry1 = "select distinct fromUsername from ".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where EventId=$EId and chatDate!='0000-00-00 00:00:00'";
			$chatresult = $objOpen->ExecuteQryResult($midSelectQry1,0);
			$rec_count1 = mysql_num_rows($chatresult);
			while($chatvalue  = mysql_fetch_assoc($chatresult)){
			   $resultIdss1[] = $chatvalue['fromUsername'];
			}

			$debug_it['err'] .= $debug_it['br'] .$midSelectQry2 = "select distinct toUsername from ".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where EventId=$EId and chatDate!='0000-00-00 00:00:00' and toUsername not in (select distinct fromUsername from ".$varTable['ONLINESWAYAMVARAMIBALLCHATMESSAGE']." where EventId=$EId and chatDate!='0000-00-00 00:00:00')";
			$chatresult2 = $objOpen->ExecuteQryResult($midSelectQry2,0);
			$rec_count2  = mysql_num_rows($chatresult2);
			while($chatvalue2  = mysql_fetch_assoc($chatresult2)){
			     $resultIdss2[] = $chatvalue2['toUsername'];
			}
			
			if($rec_count2 > 0) 
			{
				if($rec_count1 > 0) {
					$resultIdss = array_merge($resultIdss1, $resultIdss2);
				} else {
					$resultIdss = $resultIdss2;
				}
			} else {
				$resultIdss = $resultIdss1;
			}
			
			if(count($resultIdss) > 0) {
				
				foreach($resultIdss as $memberMId) {
					$matriid            = trim(strtoupper($memberMId));
					$varCondition		= " where MatriId='".$matriid."'";
					$varFields			= array('Name','Paid_Status');
					$varMemDet	        = $objSlave->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);
					$varName            = $varMemDet[0]['Name'];
					$varPaidStatus      = $varMemDet[0]['Paid_Status']?'R':'F';
					
					if($varPaidStatus == 'F') {
						$membername = $varName;
						// Query to select the Email of the member...
						$varCondition		= " where MatriId='".$matriid."'";
					    $varFields			= array('Email');
					    $varMemLogDet	    = $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
					    //$mememail           = $varMemLogDet[0]['Email'];
						$mememail           = "srinivasan.c@bharatmatrimony.com";



						$newsLetter = $varRootBasePath."/www/mailers/free-paid-thanq-vmm.html"; //URL of News Letter.

						
						//send email
						$HEADERS  = "MIME-Version: 1.0\n";
						$HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
						$HEADERS .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
						$HEADERS .= "Reply-To: payment@communitymatrimony.com\n";

						$newLink = fopen ($newsLetter, "r");
						$contents = fread($newLink,filesize($newsLetter));
						$msg = $contents;	
						
						$domainurl = "communitymatrimony";					
						$msg = eregi_replace("#MATRIID",strtoupper($memberMId),$msg);
						$msg = eregi_replace("#MEMNAME",$membername,$msg);
						$msg = eregi_replace("#DOMAIN",$domainurl,$msg);
						$msg = eregi_replace("#EVENTTITLE",$ETitle,$msg);

						$subtxt = "Best way to participate in Virtual Matrimony Meets";
						
						$ok=mail($mememail,$subtxt,$msg,$HEADERS);
						
						if($ok)	{
							$sendMailCnt++;
						}
					}
					
				}
				mail("srinivasan.c@bharatmatrimony.com",$subtxt,$msg,$HEADERS);
				$confmsg = $confmsg . "Total Mail sent for Free to paid thank you mailer for ".$ETitle." is ".$sendMailCnt." <br><br>";
				$sendMailCnt = 0;	
			}
		}
		$headers1  = "MIME-Version: 1.0\n";
		$headers1 .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers1 .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
		$headers1 .= "Reply-To: payment@communitymatrimony.com\n";
		$subtxt = "VMM Mailer Free Members thank you mail sent count";
		$mememail= "srinivasan.c@bharatmatrimony.com";
		mail($mememail,$subtxt,$confmsg,$headers1);
}

// Send confirmation email
	//if($sendMailCnt>=1) {


	$objSlave->dbClose();
	$objOpen->dbClose();
}
?>