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


//OBJECT DECLARATION
$objSlave = new DB;
$objOpen  = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);
$objOpen-> dbConnection('192.168.1.11','fireuser','firepass','openfire');

	$sendMailCnt = 0;

	// To select the Matrimony meet EventID...
	// Query to be executed when this file is going to run in cron
	$varCondition		= " where DATEDIFF(NOW(),EventDate)=0";
    $varFields			=  array("EventId","EventTitle");
    $varConfDet	        = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'],$varFields,$varCondition,1);

	// Query to be executed when this file is going to run Manually
	//$eIdSelectQry = "select EventId,EventTitle from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATCONFIGURATIONS']." where EventDate between '2008-11-15' and '2008-11-16'";
	$affCnt = count($varConfDet);
	
	if($affCnt > 0) 
	{
		$resultEventIds = $varConfDet;
		foreach($resultEventIds as  $resultEventId)
		{
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
				$resultIdss = array_merge($resultIdss1, $resultIdss2);
			}else 
			{
				$resultIdss = $resultIdss1;
			}

			foreach($resultIdss as $memberMId) 
			{
				// Query to select the Email of the member...
				$matriid            = trim(strtoupper($memberMId));
				$varCondition		= " where MatriId='".$matriid."'";
				$varFields			= array('Email');
				$varMemLogDet	    = $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
				$mememail           = $varMemLogDet[0]['Email'];
			
				$newsLetter = $varRootBasePath."/www/mailers/ThankyouMailer-vmm.html"; //URL of News Letter.
				//send email
				$HEADERS  = "MIME-Version: 1.0\n";
				$HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
				$HEADERS .= "From: BharatMatrimony.com <info@bharatmatrimony.com>\n";
				$HEADERS .= "Reply-To: info@bharatmatrimony.com\n";

				$newLink = fopen ($newsLetter, "r");
				$contents = fread($newLink,filesize($newsLetter));
				$msg = $contents;
                
				$CHATURL ="http://www.communitymatrimony.com/chatmyconversation.php?evid=".$EId;
				
				$msg = eregi_replace("#EMAILID",$mememail,$msg);
				$msg = eregi_replace("#EVENTTITLE",$ETitle,$msg);
				$msg = eregi_replace("#MATRIID",strtoupper($matriid),$msg);
				$msg = eregi_replace("#EVID",$EId,$msg);
				$msg = eregi_replace("#CHATURL",$CHATURL,$msg);

				$subtxt="Thank you for participating in the Virtual Matrimony Meet. Watch out for more meets!";
				//$mememail="hamtam4jobs@gmail.com,hameed@bharatmatrimony.com,hameedjunaideen@yahoo.co.in,bmtestemails@gmail.com,bmtestemails@yahoo.com,bmtesting@hotmail.com,bmtesting@rediiff.com";
				echo $msg;exit;
				
			    $ok=mail($mememail,$subtxt,$msg,$HEADERS);
				//echo "mail sent to".$mememail;

				if($ok)
				{
					$sendMailCnt++;
   				}
			}
				$subtxtcount="Thank you Mailer Sent Count for Virtual Matrimony Meet.";
				$noofmailsent = $sendMailCnt;
				$vmmtitlesent = "Number of mail sent to VMM Thankyou Mailer <b>".$ETitle."</b> is <b>".$sendMailCnt.'</b><BR><BR>';
				$vmmcnt .= $vmmtitlesent;
				$sentmailto = 'srinivasan.c@bharatmatrimony.com';
				$sendMailCnt = 0;
		}
				$okcnt = mail($sentmailto,$subtxtcount,$vmmcnt,$HEADERS);
				
	}
?>