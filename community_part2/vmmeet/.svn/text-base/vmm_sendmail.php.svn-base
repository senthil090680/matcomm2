<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Text File Creation for VMM Mailer.
#=============================================================================================================
$varRootBasePath = '/home/product/community'; 
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/cityarray.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

$BasePath  = "/home/product/community/vmmeet/www/mailers/vmmdata/";
$HTMLpath  = "/home/product/community/vmmeet/www/mailers/";
ini_set("memory_limit","1024M");

//$SplittedFile = $_SERVER['argv'][1];
$SplittedFile = 'VMM-09Jul10.txt';
$startDate	  = date('Y-m-d H:i:s');
$countdate    = date('y');
if($SplittedFile=="") {
	echo "Please provide the splitted file name as arugment. Eg: sendmail.php prcase1-06feb2010_SPT_aa.txt";
	exit;
}
$TxtFileName  = $BasePath.$SplittedFile;

    $date     = date("Y-m-d");

	$ReportHeaders  =  "";
	$ReportHeaders .= "From: info@communitymatrimony.com\n";
	$ReportHeaders .= "X-Mailer: PHP mailer\n";
	$ReportHeaders .= "Content-type: text/html; charset=iso-8859-1\n";
	$ReportHeaders .= "Sender: communitymatrimony.com<info@communitymatrimony.com>\n";
	

if(file_exists($TxtFileName)) {
	$TotalCount    = 0;
	$lines=file($TxtFileName); 
	foreach($lines as $line) {	//for each Line... read the replacable elements 
	  	$Name				= '';
		$MatriId			= '';		
		$Email				= '';
		$Caste				= '';
		$Count				= '';
		$HTMLContent		= '';		
		$ReportSubject      = '';	
		$ReportContent      = ''; 
		$headers            = '';


		$fields					= explode('\n',$line);
		$vmmmember			    = trim($fields[0]);
		$vmmmemberdetail        = explode('~~',$vmmmember);
		$MatriId                = trim($vmmmemberdetail[1]); //MatriId
		$Entrytype              = trim($vmmmemberdetail[2]); //PaidStatus
		$Country				= trim($vmmmemberdetail[3]); //Country
		$Name					= trim($vmmmemberdetail[4]); //Name
		//$Email					= trim($vmmmemberdetail[5]); //Email
		$Email					= 'srinivasn.c@bharatmatrimony.com'; //Email
		$CasteId				= trim($vmmmemberdetail[6]); //CasteId
		$Religion				= trim($vmmmemberdetail[7]); //Religion
		$EventTitle             = trim($vmmmemberdetail[8]); //EventTitle
		$TitleDet               = explode('-',$EventTitle);  //EventTitle
		$Title                  = $TitleDet[1];  //Title
		$EventDate				= trim($vmmmemberdetail[9]); //EventDate
		$EventStartTime			= trim($vmmmemberdetail[10]);//EventStartTime
		$EventEndTime			= trim($vmmmemberdetail[11]);//EventEndTime
		$EventId    			= trim($vmmmemberdetail[12]);//EventId
		$CommunityId   			= trim($vmmmemberdetail[13]);//CommunityId
        
		/*echo "<pre>";  
		print_r($vmmmemberdetail);
		echo "</pre>";*/
		//$Entrytype ="R";
       	if($Entrytype == "F") {
		    		$newsletter = $HTMLpath."Free-index.html";
		} elseif($Entrytype == "R") {
					$newsletter = $HTMLpath."paid-index.html";
		}
		
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
		$headers .= "Reply-To: no-reply@communitymatrimony.com\n";

		//////////////////////////////
		$newlink = fopen ($newsletter, "r");
		$contents = fread($newlink,filesize($newsletter));
		$msg = $contents;

		$varMatriIdPrefix	= substr($MatriId,0,3);
        $varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
        
		$landurl     = "meet.communitymatrimony.com/vmlogin.php?evid=".$EventId;
		$domainurl   = "communitymatrimony";
		$domain_logo = 'http://img.'.$varDomainName.'/images/logo/'.$arrFolderNames[$varMatriIdPrefix]."_logo.gif";
		$EventDate_disp = date('jS F Y',strtotime($EventDate));
		$EventStartTime_disp = date("h:i:s A",strtotime($EventStartTime));
		$EventEndTime_disp = date("h:i:s A",strtotime($EventEndTime));
		$paymentLink = 'http://www.'.$varDomainName.'/payment/';
		$loginLink = 'http://meet.communitymatrimony.com/vmlogin.php?evid='.$EventId.'&matriid='.$MatriId;
		$unsubscibeLink	= $varDomainName."/login/index.php?redirect=".$varDomainName."/profiledetail/index.php?act=mailsetting";
		
		$msg = str_replace("#DOMAINLOGO",$domain_logo,$msg);
		$msg = str_replace("#TITLE",$Title,$msg);
		$msg = str_replace("#DATE",$EventDate_disp,$msg);
		$msg = str_replace("#STARTTIME",$EventStartTime_disp,$msg);
		$msg = str_replace("#ENDTIME",$EventEndTime_disp,$msg);
		$msg = str_replace("#PAYMENTLINK",$paymentLink,$msg);
		$msg = str_replace("#LOGINLINK",$loginLink,$msg);
		$msg = str_replace("#UNSUBSCRIBE_LINK",$unsubscibeLink,$msg);
		
			
		$subtxt = $EventTitle." Virtual Matrimony Meet, ".$EventDate;

		echo $msg;

		if($Email) {
			//$ok = mail($Email,$subtxt,$msg,$headers);
		}					

		if($ok) {
			$TotalCount=$TotalCount+1;
			$file = fopen("/home/product/community/vmmeet/www/mailers/countlog/".$SplittedFile.'-'.$countdate.".txt","w");
			$noofmailsend = "DATE : ".$startDate.":Total Mail Sent # ".$TotalCount.", Last sent MatriId : ".$MatriId;			
			fwrite($file,$noofmailsend);
		}	
		//////////////////////////////
		
		break;
	}
	$endDate  = date('Y-m-d H:i:s');
	$DiffMsg  =	getDifference($startDate,$endDate); 
	echo "DATE : ".$endDate." : Total Mail Sent # ".$TotalCount."  Started:".$startDate."  Ends on:".$endDate." DiffMsg:".$DiffMsg."\n\n\n";

	$ReportSubject  = "VMM MAILER DETAILS - ".$date." - FileName - ".$SplittedFile;
	$ReportContent="<HTML><BODY><table border=1 style='font:normal 12px arial;color:#000000;'><tr><td align='center' bgcolor=#DADADA colspan='2'> VMM MAILER DETAILS </td></tr><tr><td bgcolor=#DADADA>VMM MAILER - FILE NAME : </td><td> ".$SplittedFile." </td></tr><tr><td bgcolor=#DADADA> The Total Count is </td><td>".$TotalCount." </td></tr><tr><td bgcolor=#DADADA> Started on : </td><td>".$startDate." </td></tr><tr><td bgcolor=#DADADA> Ends on : </td><td>".$endDate." </td></tr><tr><td colspan='2'>".$DiffMsg."</td></tr></table></BODY></HTML>";		
	
	mail('srinivasan.c@bharatmatrimony.com',$ReportSubject,$ReportContent,$ReportHeaders);exit;
} else {
	echo "\nInput file - $TxtFileName does not exist! Pls check.";
	$ReportSubject = "VMM Mailer - Failed to Read File";
	$ReportContent="<HTML><BODY><table border=1 style='font:normal 12px arial;color:#000000;'><tr><td bgcolor=#DADADA>VMM mailer Triggered on </td><td> ".$date." </td></tr><tr><td colspan=2 > Input File - ".$TxtFileName." does not exist! Pls check </td></tr></table></BODY></HTML>";		
	mail('srinivasan.c@bharatmatrimony.com',$ReportSubject,$ReportContent,$ReportHeaders);
}
function getDifference($SDate,$EDate) { 
	list($date,$time) = explode(' ',$SDate); 
	$startdate = explode("-",$date); 
	$starttime = explode(":",$time); 
	list($date,$time) = explode(' ',$EDate); 
	$enddate = explode("-",$date); 
	$endtime = explode(":",$time); 
	$secondsDifference = mktime($endtime[0],$endtime[1],$endtime[2], 
	$enddate[1],$enddate[2],$enddate[0]) - mktime($starttime[0], 
	$starttime[1],$starttime[2],$startdate[1],$startdate[2],$startdate[0]);
	$seconds=floor($secondsDifference);
	$minutes=floor($secondsDifference/60); 
	$hours=floor($secondsDifference/60/60); 
	$days=floor($secondsDifference/60/60/24); 
	if($hours >0) {
		$tot = "Total Time taken to complete the entire mailer is ".$hours." Hrs";
	} else if($minutes >0) {
		$tot = "Total Time taken to complete the entire mailer is ".$minutes." Minutes";
	} else {
		$tot = "Total Time taken to complete the entire mailer is ".$seconds." seconds";
	}
    return $tot;                 
} 



?>