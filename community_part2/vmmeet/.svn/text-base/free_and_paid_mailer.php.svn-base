<?php
$varRootBasePath = '/home/product/community';
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');


//OBJECT DECLARATION
$objSlave = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);

$debug_it['br'] = "<br/><br/>";

if(!$objSlave->clsErrorCode) {
	
	//Variable Declaration
	$totsendcnt = array();

	// To select the Matrimony meet EventID... 
	$ommconfigtbl = $varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['ONLINESWAYAMVARAMCHATCONFIGURATIONS'];

	$debug_it['err'] .= $debug_it['br'] .$eidselectqry = "select EventId,EventTitle,DATE_FORMAT(EventDate,'%D %M %Y') as event_date,TIME_FORMAT(EventStartTime,'%l' '%p') as event_starttime,TIME_FORMAT(EventEndTime,'%l' '%p') as event_endtime, EventCaste, EventLanguage,EventReligion, INR_Rate, USD_Rate, AED_Rate, EURO_Rate, GBP_Rate from ".$ommconfigtbl." where DATEDIFF(EventDate,now())=0";

	$confresult = $objSlave->ExecuteQryResult($eidselectqry,1);
	$affcnt = count($confresult);

	if(!empty($confresult)) {

		$resultrow[]  = $confresult;
		foreach($resultrow as $resulteventid) {
			$sendmailcnt = 0;
			$eid = $resulteventid['EventId'];			    // Event ID
			$etitle = $resulteventid['EventTitle'];		    // Event TItle 
			$edate = $resulteventid['event_date'];		    // Event Date
			$estime = $resulteventid['event_starttime'];	// Event Start Time
			$eetime = $resulteventid['event_endtime'];	    // Event End Time 
			$ecaste = $resulteventid['EventCaste'];	        // Event Caste
			$ereligion = $resulteventid['EventReligion'];	// Event Religion
			$elanguage = $resulteventid['EventLanguage'];	// Event Language
			$etime = $estime . " - " . $eetime;

			$ommprofiletbl = $varTable['MEMBERINFO'];

			$midselectqry  = "select Paid_Status,MatriId,Country,Name from ".$ommprofiletbl." where (Publish=1 or Publish=2) limit 5";

			if($elanguage != "") {
				$midselectqry .= " and communityId in (".$elanguage.")";
			}

			if($ereligion != "") {
				$midselectqry .= " and Religion in (".$ereligion.")";
			}

			if($ecaste != "") {
				if($ecaste == 998) {
					$midselectqry .= " and (CasteId=998 OR Caste_Nobar=1) ";
				}
				else {
					$midselectqry .= " and CasteId in(".$ecaste.")";
				}
			}

			$debug_it['err'] .= $debug_it['br'] .$midselectqry;
            $memresult = $objSlave->ExecuteQryResult($midselectqry,1);
            $affcnt    = count($memresult);
			$midselectqryresult[]  = $memresult;

			if(!empty($midselectqryresult)) {

				foreach($midselectqryresult as $resultids) {
					$membermid  = $resultids['MatriId'];	
					$membername = $resultids['Name'];	
					$entrytype  = $resultids['Paid_Status']?'R':'F';
					

					/************ Commented by chitra as it not necessary ****************************************
					$countryselected = $resultids['CountrySelected'];
				
					if($countryselected == 98) {
						$einr = round($resulteventid['INR_Rate']) . " INR";	// If India
					}
					elseif($countryselected == 220) { 
						$einr = $resulteventid['AED_Rate'] . " AED";	// If UAE
					}
					elseif($countryselected == 221) { 
						$einr = $resulteventid['GBP_Rate'] . " GBP";	// If UK
					}
					elseif($countryselected == 222) { 
						$einr = $resulteventid['USD_Rate'] . " USD";	// If USA
					}
					elseif($countryselected == 5 || $countryselected == 14 || $countryselected == 20 || $countryselected == 27 || $countryselected == 34 || $countryselected == 53 || $countryselected == 56 || $countryselected == 57 || $countryselected == 67 || $countryselected == 72 || $countryselected == 73 || $countryselected == 80 || $countryselected == 83 || $countryselected == 96 || $countryselected == 97 || $countryselected == 102 || $countryselected == 104 || $countryselected == 117 || $countryselected == 122 || $countryselected == 123 || $countryselected == 124 || $countryselected == 126 || $countryselected == 132 || $countryselected == 140 || $countryselected == 141 || $countryselected == 150 || $countryselected == 160 || $countryselected == 170 || $countryselected == 171 || $countryselected == 175 || $countryselected == 176 || $countryselected == 183 || $countryselected == 190 || $countryselected == 191 || $countryselected == 194 || $countryselected == 202 || $countryselected == 203 || $countryselected == 214 || $countryselected == 219 || $countryselected == 226) { 
						$einr = $resulteventid['EURO_Rate'] . " EURO";	// If Euro Countries
					}
					
					// Query to check matriid already register for matrimony meet
					$debug_it['err'] .= $debug_it['br'] .$selectmemexist = "select MatriId from ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAM']." where MatriId='".$membermid."'";
					$resultexist = $db14conn->select($selectmemexist);

									
					if($resultexist == 0) {
					****************************************************************************************************************/

					// Query to select the Email of the member...
					$varCondition		= " where MatriId='".$membermid."'";
				    $varFields			= array('Email');
				    $varMemLogDet	    = $objSlave->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
				    $mememail           = $varMemLogDet[0]['Email'];

					// send test mailer to the following Ids
					//$mememail="bmtestemails@yahoo.co.in,bmtestemails@gmail.com,bmtesting@rediffmail.com,bmtesting@hotmail.com";
					
					
										
					//URL of OMM HTML page.
					//$newsletter = "/var/home2/mailmanager/mailer/ommmailers/registrationmailer10days.html"; 
					if($entrytype == "F") {
						$newsletter = $varRootBasePath."/www/mailers/vmm10day.html";
					} elseif($entrytype == "R") {
						$newsletter = $varRootBasePath."/www/mailers/vmm10daypaid.html";
					} 
				
					// Send email
					$headers  = "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\n";
					$headers .= "From: BharatMatrimony.com <info@bharatmatrimony.com>\n";
					$headers .= "Reply-To: no-reply@bharatmatrimony.com\n";

					$newlink = fopen ($newsletter, "r");
					$contents = fread($newlink,filesize($newsletter));
					$msg = $contents;

					$landurl = "meet.communitymatrimony.com/vmlogin.php?evid=".$eid;

					$domainurl = "communitymatrimony";

					$msg = str_replace("#DOMAINSMALL",$domainpath,$msg);				
					$msg = str_replace("#EventTitle",$etitle,$msg);
					$msg = str_replace("#MATRIID",$membermid,$msg);
					$msg = str_replace("#EventDate",$edate,$msg);
					$msg = str_replace("#EventTime",$etime,$msg);
					
					if($entrytype == "F") {
						if(strpos(strtolower($etitle),strtolower($domainpath))===false)
							$msg = str_replace("#DOMAINCAPS",ucwords(strtolower($domainpath)),$msg);
						else
							$msg = str_replace("#DOMAINCAPS",'',$msg);
						$msg = str_replace("#DOMAIN",$domainurl,$msg);
						$msg = str_replace("#NAME",$membername,$msg);
					}elseif($entrytype == "R") {
						$msg = str_replace("#MeetURL",$landurl,$msg);
					} 
					
					$subtxt = $etitle." Virtual Matrimony Meet, ".$edate;

					echo $msg;

					if($mememail) {
						$ok = mail($mememail,$subtxt,$msg,$headers);
					}					

					if($ok) {
						$totsendcnt[$eid] = $totsendcnt[$eid] + 1;
					}				
				 // } - check matriid already register for matrimony meet
				}
			}
			
			// Send sample mail
			if(mail("srinivasan.c@bharatmatrimony.com",$subtxt,$msg,$headers)) {
				echo "mail sent";
			}							
			$confmsg = $confmsg . "Total Mail sent for ".$etitle." is ".$totsendcnt[$eid]." <br><br>";
		}
	}
	
	// Send confirmation email
	if(count($totsendcnt)>=1) {
		$headers1  = "MIME-Version: 1.0\n";
		$headers1 .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers1 .= "From: BharatMatrimony.com <info@bharatmatrimony.com>\n";
		$headers1 .= "Reply-To: no-reply@bharatmatrimony.com\n";
		$subtxt	=	"OMM Mailer 10 day left mail sent count";
		$mememail="srinivasan.c@bharatmatrimony.com";
		mail($mememail,$subtxt,$confmsg,$headers1);
	}

	$objSlave->dbClose();

	//echo $debug_it['err'] ;
}
?>
