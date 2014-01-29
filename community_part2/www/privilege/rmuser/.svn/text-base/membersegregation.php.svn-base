<?php
/****************************************************************************************************
File		: Rmmembersegregation.php
Author	: Chitra.S
Date		: 06-Aug-2008
*****************************************************************************************************
Description	: 
	This is Rmuser addition & segregation home page
********************************************************************************************************/

// Includes header information
include_once "include/rmuserheader.php";
include_once "include/common_vars.php";
include_once "include/rmclass.php";
//include_once "home/product/community/conf/vars.cil14";

$rmmember = new srmclassname();
$rmmember->srminit();
$rmmember->srmConnect();

$test = $rmmember->getDebugParam();
$debug_it['err'] .= $debug_it['br'] .$test['host']['S'];

$DBDOMAINGROUPS = array(7,10,2,1);

$segregatenum = 50;

if(isset($_REQUEST['Submit'])) {
	$act = update_rmuser();
	$msg = $debug_it['err'];
	sendrptmail($msg);	
} else {
	list($rmuserlist,$hiddenval) = split("###",selectrmusers());
	
}
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?>
<script language="javascript" src="js/common_validation.js"></script>
<script language="javascript" src="js/memsegregation.js"></script>
<script language="javascript" src="js/ajax.js"></script>
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<!-- <td width="200"  style="border-right:solid 1px #9BD6E5"><? include_once "../template/ansadminleft.php"; ?></td> -->
			<td width="100%" style="padding-left:20px;"> 
			<form name="memsegregation" method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">

					<?
					if(isset($_REQUEST['Submit'])) {						
					?>
						<tr>
							<td valign="middle" align="center" height="30" colspan="4" style="padding-top:50px;"><span class="normaltext3"><?=formatarrformsg($_REQUEST['members']);?> - Members has been Assigned</span></td>
						 </tr>
					<?
					 } else {
					?>

						<tr>
							<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3">Member Segregations</span></td>
					    </tr>
						<tr>
								<td width="20%" align="center" class="tdleft"><span class="normaltext2">Select RMusers</span></td>
								<td width="80%" align="left" class="tdright"><select name="rmuser" id="rmuser" class="normaltext2" style="width:220px;">
								<option value="0">-Select-</option>
								<?=$rmuserlist;?>
								</select></td>			
						</tr>
						<?=$hiddenval;?>
						
						<tr>
						<td align="center" class="Rtdleft" valign="top" style="padding-top:10px;"><span class="normaltext2">Select Members</span></td>
								<td  style="padding-top:5px;"  align="left" class="Rtdright">
								<table width="95%" cellspacing="0" cellpadding="4" border="0" style="border:0px solid #A196BF;" >
								<?
								list($html,$act) = split("###",memberdisplay());
								echo $html;
								?>
								</table>								
								</td>
						</tr>
						
						<?if($act == "Y") {?>
						<tr>
								<td colspan="2" align="center" style="height:30px;" class="normaltext2">
								<div id="submitactive"  align="center" >
								<input type="submit" value="Submit" name="Submit" class="SubmitButton"  onclick="return MemValidation();"></div>
								<div id="submitdisactive" style="display:none"  align="center" >
								<input type="submit" value="Submit" name="Submit12" class="SubmitButton"></div>
								</div>
								</td>										
						</tr>
						
						<?}
						}?>
						
					   <tr><td height="50">&nbsp;</td></tr>
				</table>
				</form>
			</td>
		</table>
	</td>
</tr>
<?
$rmmember->dbClose();
include_once "include/rmfooter.php";
?>
</body>
</html>

<?
function selectrmusers() {
	global $rmmember, $Rmusers, $SegregatedRmusers;	
	
	$SegregatedRmusers = $rmmember->ExistingRmusers();	
	$userremove = separateusers($SegregatedRmusers);
	$Rmusers = $rmmember->SelectRmusers($userremove);
	if(is_array($Rmusers) && count($Rmusers) >0) {
		$selectbox = "";
		foreach($Rmusers as $users=>$name) {
			if($SegregatedRmusers[$users] != ""){ 
				$count = $SegregatedRmusers[$users];
			} else {
				$count = 0;
			}
			$hidden .= "<input type=\"hidden\" name=\"".$users."\" id=\"".$users."\" value=\"".$count."\">";
			$selectbox .= "<option value='".$users."'>".ucwords(strtolower($name))." [u".$users."] [".$count."]</option>";
		}
		
		return $selectbox."###".$hidden;
	}
}

function separateusers($SegregatedRmusers){
	global $segregatenum;
	if(is_array($SegregatedRmusers)) {
		$inc = 0;
		foreach($SegregatedRmusers as $users=>$count) {
			if($count >  $segregatenum) {
				$separatedarr[$inc] =  $users;
				$inc++;
			}
		}
	}
	
	if(is_array($separatedarr) && count($separatedarr) >0) {
		if(count($separatedarr) >1) {
			$userremove = implode("','",$separatedarr);
		} else {
			$userremove = $separatedarr[0];
		}
	}
	return $userremove;
}

function memberdisplay() {
	global $rmmember,$PROFILECREATEDHASH,$segregatenum;

	$unsegregatedmem = $rmmember->unsegregatedmem();
	    
	$html = "";
	if(is_array($unsegregatedmem) && count($unsegregatedmem) > 0) {

		$mids = formatarr($unsegregatedmem);

		if($mids != "") {
			$profilecreatedby = $rmmember->findbywhomprofilecreated($mids); // find profile created by whom
		}
        
		foreach($unsegregatedmem as $members) {
			$members = trim($members);
			$hiddenmids = formatarrformsg($unsegregatedmem);
			
			$html .= '<tr><td><input type="hidden" name="mids" id="mids" value="'.$hiddenmids.'"></td></tr>';
			/**$domaininfo = getDomainInfo(1,$members);			
			$linkurl = $domaininfo['domainmodule'];
			$domainname = ucwords($domaininfo['domainnamelong']);*/
			$linkurl='http://www.communitymatrimony.com/privilege/mainindex.php?act=rmviewprofile&memid=rmi&matriid='.$members.'&print=yes';
			$members."-".$profilecreatedby[$members]."<br/>";
			
			if($profilecreatedby[$members] != "") {
			$arrProfileCreatedByList= array(1=>"Self",2=>"Parents",3=>"Sibling",4=>"Relative",5=>"Friend",7=>"Others");
			$View_ByWhom = $arrProfileCreatedByList[$profilecreatedby[$members]];
				//$View_ByWhom = getFromArryhash('PROFILECREATEDHASH',$profilecreatedby[$members]);
			} else {
				$View_ByWhom = "";
			}
			
			
			$html .= '<tr>
						<td align="left" width="10%" class="normaltext2"><input type="checkbox" name="members[]" value="'.$members.'"></td><td align="left" width="90%" class="normaltext2"><a href="'.$linkurl.'" class="normallinkText" target="_blank">'.$members.'</a> - Profile created by '.$View_ByWhom.' - '.$domainname.' - <a href="" class="normallinkText" onclick="return ajax_action(\''.$members.'\',\''.$members.'\');">Get Phone No </a></td>
					 </tr><tr><td colspan="2" class="normaltext2" style="padding-left:55px;"><div id="'.$members.'"></div></td></tr>';
		}

		$act = "Y";
	} else {
		$html .= '<tr>
					<td align="left" class="normaltext2">No members are available</td>
				 </tr>';
		$act = "N";
	}
	return $html."###".$act;
}
function update_rmuser() {
	global $rmmember, $IDSTARTLETTERHASH, $DOMAINTABLE,$debug_it;	
	$members = $_REQUEST['members'];
    $matriid = formatarr($members);	
	$updatemember = $rmmember->UpdateRmusers($_REQUEST['rmuser'],$matriid);
    
	$mememails[] = $rmmember->Emailbackup($matriid);
	$phonevstatus[] = $rmmember->phonestatus($matriid);
 
    $Backupemails = formatdomainarr($mememails);	
	$phoneverifiedstatus = formatdomainarr($phonevstatus);	
	$rmuserdetails = $rmmember->selectRmuserdetail($_REQUEST['rmuser']);
	
	sendmail_user($Backupemails,$rmuserdetails,$members);
	sendmail_rmuser($members,$rmuserdetails);
	//sendsms_to_rmuser($assignedmids,$rmuserdetails);
	return;
}

function formatdomainarr($array) {

	foreach($array as $domainid=>$array1) {
		foreach($array1 as $matriid=>$value) {
			$returnarr[$matriid] = $value;
		}		
	}
	return $returnarr;
}

function formatassignedarr($array) {	
	$inc = 0;
	foreach($array as $domainid=>$array1) {
		foreach($array1 as $key=>$mid) {
			foreach($mid as $matriid) {
				$assignid[$inc] = $matriid;
				$inc++;
			}
		}		
	}
	return $assignid;
}


function formatmids($phoneverifiedstatus) {
	$inc = 0;
	foreach($phoneverifiedstatus as $mid=>$status) {		
		$formatids[$inc] = $mid;
		$inc++;
	}
	return $formatids;
}

function formatarr($array) {
	if(is_array($array) && count($array) >0) {
		if(count($array) >1) {
			$matriid = implode("','",$array);
		} else {
			$matriid = $array[0];
		}
	}
	return $matriid;
}

function formatarrformsg($array) {
	if(is_array($array) && count($array) >0) {
		if(count($array) >1) {
			$matriid = implode(", ",$array);
		} else {
			$matriid = $array[0];
		}
	}
	return $matriid;
}

function domainbased_onmatriid($domainid) {
	global $domainlangarraylong, $domaininfo;
	$domaininfo = getDomainInfo(2,$domainid);
	$domainlangarraylong = strtoupper($domaininfo['domainnameshort']);
	return $domainlangarraylong;
}

function domainwisegroup($members) {
	global $rmmember, $IDSTARTLETTERHASH, $DOMAINTABLE;	
	$IDSTARTLETTERHASH=array(7=>"B",6=>"R",5=>"G",8=>"P",10=>"H",9=>"S",4=>"K",3=>"E",2=>"T",1=>"M",14=>"D",12=>"C",13=>"A",11=>"Y",15=>"U");
	
	foreach($IDSTARTLETTERHASH as $key=>$startletter){
		
		$inc =0;
		foreach($members as $memmatriid){
			$mid_startletter = substr ($memmatriid, 0,1);
			if($mid_startletter == $startletter){				
				$domain_separateid[$key][$inc] = $memmatriid;
				$inc++;
			}
		}
		
	}
	return $domain_separateid;
}

function groupmids($domain_separateid) {
	global $rmmember, $IDSTARTLETTERHASH, $DOMAINNAME,$LANGGROUP1,$LANGGROUP2,$LANGGROUP3,$LANGGROUP4,$DBDOMAINGROUPS;	
	$add = 0;
	for($i=1;$i<=4;$i++){
		$group = "LANGGROUP".$i;
		foreach($$group as $domainid) {			
			foreach($domain_separateid as $separatedid=>$memmatriidarr){	
				if($domainid == $separatedid){
					$group_separateid[$DBDOMAINGROUPS[$add]][$separatedid] = $memmatriidarr;
				}
			}
		}
		$add++;
	}
	return $group_separateid;
}


function assureddetails($phoneverifiedstatus,$conn='') {
	global $DBCONIP,$DBINFO,$DBNAME,$TABLE,$rmmember,$debug_it;

	$conn4 = $conn->getDebugParam();
	$debug_it['err'] .= $debug_it['br'] .$conn4['host']['S'];

	$assuredmids = findverifiedmids($phoneverifiedstatus);
	if(is_array($assuredmids) && count($assuredmids) >0) {
		if(count($assuredmids) >1) {
			$Amatriid = implode("','",$assuredmids);
		} else {
			$Amatriid = $assuredmids[0];
		}
		
		$assuredarr = $conn->assured_details($Amatriid);
		$conn->dbClose();
		return $assuredarr;
	}
}

function updateassuredcontacts($verifiedmids,$rmuserdetails,$assuredcontactdb='') {
	global $DBCONIP,$DBINFO,$DBNAME,$TABLE,$rmmember,$debug_it;


	/*$assuredcontactdb = new srmclassname();
	$assuredcontactdb->srmConnect1($DBCONIP['DB5'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ASSUREDCONTACT']);*/

	$conn5 = $assuredcontactdb->getDebugParam();
	$debug_it['err'] .= $debug_it['br'] .$conn5['host']['S'];
	if(is_array($verifiedmids) && count($verifiedmids) >0) {

		$contactno = formatphoneno($rmuserdetails[$_REQUEST['rmuser']]['phone'],$rmuserdetails[$_REQUEST['rmuser']]['mobile']);
		$assuredcontactdb->updateassureddetails($verifiedmids,$contactno,$rmuserdetails[$_REQUEST['rmuser']]['name'],7,'Office hours between 10 am to 5 pm');
		//$assuredcontactdb->dbClose();
		return;
	}
}

function findverifiedmids($phoneverifiedstatus) {
	$inc = $sum =0;
	$assuredmids=array();
	foreach($phoneverifiedstatus as $mid=>$status) {
		if($status == 1 || $status == 3) {
			$assuredmids[$inc] = $mid;
			$inc++;
		} else {
			$othermids[$sum] = $mid;
			$sum++;
		}
	}
	return $assuredmids;
}

function formatphoneno($phone,$mobile) {
	if($mobile != "") {
		$contactno = "91~".$mobile;
	} elseif($phone != "") {
		$contactno = "91~".$phone;
	}
	return $contactno;
}

function sendmail_user($memberemails,$rmuserdetails,$assignedmids){
	global $rmmember;
	if(is_array($memberemails) && count($memberemails)  >0 ) {

		$mids = formatarr($assignedmids);
		
		$memname = $rmmember->findmembername($mids); // find member name	
				
		foreach($memberemails as $matriid=>$mememail) {
			sendadminmailer($matriid,$mememail,$rmuserdetails,$memname); // mail from admin to member
			sendrmmailer($matriid,$mememail,$rmuserdetails,$memname);// mail from rmuser to member
		}
	}
}

function sendadminmailer($matriid,$mememail,$rmuserdetails,$memname){
	global $adminemail, $adminname,$confValues,$arrPrefixDomainList,$arrFolderNames;

		$subject = "It's a privilege to serve you personally!";

		$mailer1 = "mailer/adminmailer.html";

		$newlink = fopen ($mailer1, "r");
		$contents = fread($newlink,filesize($mailer1));
		$msg = $contents;
        $varMatriIdPrefix	= substr($matriid,0,3);
        $varDomainName		= $arrFolderNames[$varMatriIdPrefix];

		$msg = str_replace("#RMNAME",$rmuserdetails[$_REQUEST['rmuser']]['name'],$msg);				
		$msg = str_replace("#RMMOBILE",$rmuserdetails[$_REQUEST['rmuser']]['mobile'],$msg);
		$msg = str_replace("#MEMBERNAME",$memname[$matriid],$msg);
		$msg = str_replace("#MATRIID",$matriid,$msg);
		$msg = str_replace("#ADMINEMAIL",$adminemail,$msg);
		$msg = str_replace("#ADMINNAME",$adminname,$msg);
		$msg = str_replace("#LOGO",$confValues["IMGSURL"].'/logo/'.$varDomainName,$msg);
		$msg = str_replace("#DOMAIN",$varDomainName,$msg);

		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: ".$adminemail." <".$adminemail.">\n";	
 
		//$mememail = "srinivasan.c@bharatmatrimony.com";
		//$mememail = "bmtestemails@yahoo.co.in,bmtesting@rediffmail.com,bmtesting@hotmail.com,bmtestemails@gmail.com";
		//$mememail='bmtest03@gmail.com';
		$mail1 = mail($mememail, $subject, $msg, $headers);	
		
}

function sendrmmailer($matriid,$mememail,$rmuserdetails,$memname){
        global $arrPrefixDomainList,$arrFolderNames,$confValues;
		$subject = "Your personal matchmaker from CommunityMatrimony";

		$mailer2 = "mailer/rmusermailer.html";

		$newlink2 = fopen ($mailer2, "r");
		$contents = fread($newlink2,filesize($mailer2));
		$msg = $contents;

		$varMatriIdPrefix	= substr($matriid,0,3);
        $varDomainName		= $arrFolderNames[$varMatriIdPrefix];

		$msg = str_replace("#RMNAME",$rmuserdetails[$_REQUEST['rmuser']]['name'],$msg);				
		$msg = str_replace("#RMMOBILE",$rmuserdetails[$_REQUEST['rmuser']]['mobile'],$msg);
		$msg = str_replace("#MEMBERNAME",$memname[$matriid],$msg);
		$msg = str_replace("#MATRIID",$matriid,$msg);	
		$msg = str_replace("#LOGO",$confValues["IMGSURL"].'/logo/'.$varDomainName,$msg);
		$msg = str_replace("#DOMAIN",$varDomainName,$msg);

		$headers1 = "MIME-Version: 1.0\n";
		$headers1 .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers1 .= "From: ".$rmuserdetails[$_REQUEST['rmuser']]['email']." <".$rmuserdetails[$_REQUEST['rmuser']]['email'].">\n";

		//$mememail = "chitraselvendran@gmail.com";
		//$mememail = "bmtestemails@yahoo.co.in,bmtesting@rediffmail.com,bmtesting@hotmail.com,bmtestemails@gmail.com";
		//$mememail='bmtest03@gmail.com';
		$mail2 = mail($mememail, $subject, $msg, $headers1);	
		
}

function sendmail_rmuser($members,$rmuserdetails){ // send assigned members to rmusers

	$subject = "Members Assigned through RM Interface";

	$message = "Hi ".$rmuserdetails[$_REQUEST['rmuser']]['name'].",<br><br>\n\n";
	$message.= "The Members - ".formatarrformsg($members)." are assigned to you on ".date("F d, Y h:i a")."<br><br>\n\n";	
	$message.= "Please take action immediately<br><br>\n\n";	
	$message.= "Thanks,<br>\n";
	$message.= "Support Team";	

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: support@communitymatrimony.com <support@communitymatrimony.com>\n";	
    //$rmuserdetails[$_REQUEST['rmuser']]['email']='bmtest24@gmail.com'; 
	$mail3 = mail($rmuserdetails[$_REQUEST['rmuser']]['email'], $subject, $message, $headers);	
	
}

function sendsms_to_rmuser($members,$rmuserdetails){ // send assigned members to rmusers
	global $DBCONIP, $TABLE, $DBINFO, $DBNAME;
	if(is_array($members) && count($members) >0 ) {

		$smsdb = new srmclassname();
		$smsdb->srmConnect1($DBCONIP['SMSDB'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['WAY2SMSDB0']);

		foreach($members as $matriid) {
			$smsmessage = $matriid." has been assigned to you. Please take action immediately";
			$sendsms = $smsdb->sendsms($smsmessage,$rmuserdetails[$_REQUEST['rmuser']]['mobile']);		
		}
	}
}
function sendrptmail($msg){ // send report mail

	$subject = "RM Imterface Member segregation query";

	$message = "Hi,<br><br>\n\n";
	$message.= $msg;	
	$message.= "Thanks,<br>\n";
	$message.= "Support Team";	

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: info@communitymatrimony.com <info@communitymatrimony.com>\n";	

	$mail3 = mail('srinivasan.c@bharatmatrimony.com', $subject, $message, $headers);
	
}
?>
