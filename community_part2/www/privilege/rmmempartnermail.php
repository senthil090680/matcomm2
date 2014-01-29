<?
//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/emailsconfig.cil14');
include_once($varRootBasePath.'/conf/domainlist.cil14');
//include_once($varRootBasePath."/lib/clsDBtest.php");
include_once($varRootBasePath.'/lib/clsPrivilege.php');
include_once($varRootBasePath.'/www/privilege/config/config.cil14');
//include_once($varRootBasePath.'/www/privilege/include/rmclass.php');

//OBJECT DECLARATION
$objDB = new Privilege;
$objDB->dbConnect('S',$varDbInfo['DATABASE']);

$objMasterDB = new Privilege;
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);



$sessRMUsername = $_COOKIE['rmusername'];
if(!$sessRMUsername){
	header("location:http://www.communitymatrimony.com/privilege/index.php");
}

if(isset($_POST['trigger'])) { // This function used for Trigger the testing mail.
	
	$rmuserid=$_COOKIE['rmusername'];
	$message=$_POST['comments'];
	$matriid=$_POST['matriid'];
	mempartnerpref($rmuserid,$matriid,$message,$objMasterDB); //Save the Test mail Details for corresponding matriid
	sendmailtopartner($rmuserid,$matriid,$message,$objDB);
	echo "<script>document.location.href='rmmempartnermail.php?id=2';</script>";
	}  else {
	if($_REQUEST['status']==1) { // This function used for already sent a test mail to BMP and waiting for approval.
  	$partnermsg=GetMessage($_REQUEST['memid'],$objDB);	  //Get the Message for corresponding matriid
	}
}

if(isset($_POST['save'])) { // This function used for scheduled the date for sending a PartnerPref Mailer to all members.

	$rmuserid=$_COOKIE['rmusername'];
	$message=$_POST['comments'];
	$matriid=$_POST['matriid'];
	$schdate=$_POST['date'];
	mempartnerprefschedule($rmuserid,$matriid,$message,$schdate,$objMasterDB);	  //Save the Schedule Details for corresponding matriid
	echo "<script>document.location.href='rmmempartnermail.php?id=1';</script>";
	
 }
?>
<html>
<head>
<title> CommunityMatrimony.com </title>
<head>
<link rel="stylesheet" href="include/rmstyles.css">
<script language="javascript"  src="include/CalendarPopup.js"></script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center"  >
<?if($_REQUEST['id']=="") {?>
	<tr align="center">
		<td bgcolor="#ffffff" valign="top" ><div style="width: 200px;" id="logo"><img src='http://imgs.communitymatrimony.com/images/logo/community_logo.gif'></div>			<div style="padding-left:100px;float:left;padding-bottom:20px;"><font class="normaltext5">RM Interface</font><br><font class="normaltext"></font></div>  
		 </td>
	</tr>
	<tr>
		   <td>&nbsp;</td>
	</tr>
	<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		
			<tr>
			<!-- <td width="200"  style="border-right:solid 1px #9BD6E5"><? include_once "../template/ansadminleft.php"; ?></td> -->
			<td width="100%" style="padding-left:20px;">
				<table border="0" cellpadding="0" cellspacing="0" >
						<tr>
							   <td valign="top" align="left" height="30" colspan="4"><span class="normaltext3">Member Partner Mailer Scheduler</span></td>
					    </tr>
						<tr>
							   <td valign="top" align="left" height="30" colspan="4"><span class="normaltext2">If you would like to make changes to the information, please make the changes in the relevant fields and save.</span></td>
					    </tr>
						<tr>
							  <td>	
								<form name="contactdet" method="post">
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
													<td width="150" valign="top"><span class="normaltext2">Personalised Message</span></td>
													<td width="10" valign="top"><span class="normaltext2">:</span></td>
													<td width="250" >
														<textarea name="comments" cols="35" rows="6" class="normaltext2" onkeyup="return update();"><?=$partnermsg;?></textarea>
														<input type="hidden" name="matriid" value="<?=$_REQUEST['memid'];?>">
													</td>
											</tr>
										   <?if($_REQUEST['status']==1) {//Already Triggered Test Mail?>
										   <input type="hidden" name="curdate" value="<?=date('Y-m-d');?>">
											<tr>
												   <td colspan="3">
														<div id="content" style="display:none;">
														<a href="#" onclick="return hide();" class="normaltext2">Are you Like to schedule.</a>
														</div>
														<div id="schedule" style="display:block;">
														<br>
															<script language="JavaScript" id="js2">
																var cal2 = new CalendarPopup();
																cal2.showYearNavigation();
																</script>
															   <span class="normaltext2">Schedule Date &nbsp;&nbsp;&nbsp;: </span>
																<input name="date" value="" size="25" type="text" style="width:80px;" class="normaltext2">
																<a href="#" onclick="cal2.select(document.forms[0].date,'fromlink','yyyy-MM-dd'); return false;"  name="fromlink" id="fromlink" class="normaltext2"><img src="<? echo $confValues["IMGSURL"];?>/cal.gif" border="0"></a>
														</div>

												   </td>
											</tr>
											<?}?>
											<tr>
												   <td>&nbsp;</td>
											</tr>
											<tr>
													<td colspan="3" style="padding-left:50px;">
													 <?if($_REQUEST['status']==1) {?>
													 <input type="submit" name="save" value="Save" class="button" onclick="return schedulevalidation();">
													<?} else {?>
													  <input type="submit" name="trigger" value="Trigger" class="button" onclick="return triggervalidation();">
													<?}?>
													</td>
											</tr>
										</table>
								  </form>
							  </td>
						</tr>
					   
					   
					   <tr><td height="50">&nbsp;</td></tr>
				</table>	
			</td>
		</table>
	</td>
</tr>
<?} else {?>
<tr>
	  <td height="100">&nbsp;</td>
</tr>
<tr>
	<td>
	<span class="errortext4">Schedule Save Successfully</span>
	<a href="#" onclick="return parent();" class="normaltext2">Close </a>
	</td>
</tr>
<tr>
	  <td height="100">&nbsp;</td>
</tr>
<?}?>
</body>
</html>
<Script Language="JavaScript">

function hide() {
	document.getElementById('content').style.display="none";
	document.getElementById('schedule').style.display="block";
}

function parent() {
 window.opener.location.href = window.opener.location.href;
 window.opener.location.reload();
 window.close();
}
 
function update() {
  var str=document.contactdet.comments.value;
  if(document.contactdet.comments.value.length > 200) {
   alert("Allow only 200 character only");
   document.contactdet.comments.value=str.substring(0,200);
   return false;
  }
}

function triggervalidation() {
   if(document.forms.contactdet.comments.value=="") {
		alert("Fill the Personalised Message");
		return false;
   }
	
}


function schedulevalidation()
    {
    var SDate = document.contactdet.curdate.value;    	
    var EDate =  document.contactdet.date.value;
       
          
    var alertReason1 =  'Choose the Feature Date.' 


  	if(document.forms.contactdet.comments.value=="") {
		alert("Fill the Personalised Message");
		return false;
   }
    else if(SDate != '' && EDate != '' && SDate > EDate)
    {
	    alert(alertReason1);
	    return false;
    }
   else if(EDate == '')	
    {
        alert("Choose the Schedule Date");
        return false;
    }
	//return false;
}

</Script>
	
<?php

function sendmailtopartner($rmuserid,$matriid,$message,$mailer) {
	    global $varDbInfo,$varTable,$TABLE,$varCbsRminterfaceDbInfo;

      	$arrProfileMatchId	= array("'".$matriid."'");
		$varMatriIdPrefix	= substr($matriid,0,3);
        $mailer->getCommunityWiseDtls($varMatriIdPrefix);
        $varProfileBasicResultSet = $mailer->selectDetails($arrProfileMatchId);
		
		$varProfileBasicView= $mailer->getMatchWatchRmRegularDetails('',$varProfileBasicResultSet,'');
       	$mailermsg_top =$varProfileBasicView;

		$varFields			= array('Email');
		$varCondition		= " where MatriId=".$mailer->doEscapeString($matriid,$mailer);
		$matriemail			= $mailer->select($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'], $varFields, $varCondition,1);
		$toemail=$matriemail[0]['Email'];

		$varFields			= array('Email');
		$varCondition		= " where MatriId=".$mailer->doEscapeString($matriid,$mailer);
		$rmuserdet			= $mailer->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'], $varFields, $varCondition,1);
		if(!empty($rmuserdet['Email'])){$useremail=$rmuserdet[0]['Email'];}
		
		$varFields			= array('Name','Email','Mobile');
		$varCondition		= " where RMUserid=".$mailer->doEscapeString($rmuserid,$mailer);
		$rmuserdet			= $mailer->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'], $varFields, $varCondition,1);

		
		$mailermsg = eregi_replace("<<EMAIL>>",$toemail,$mailermsg_top);
		$mailermsg = eregi_replace("<--RMNAME-->",ucwords($rmuserdet[0]["Name"]),$mailermsg);
		$mailermsg = eregi_replace("<--RMEMAIL-->",$rmuserdet[0]["Email"],$mailermsg);
		$mailermsg = eregi_replace("<--RMPHONE-->",$rmuserdet[0]["Mobile"],$mailermsg);
		$mailermsg = eregi_replace("<--MESSAGE-->",$message,$mailermsg);
		$mailermsg = eregi_replace("<--RMTIME-->","9:00 AM TO 06:00PM",$mailermsg);
	    $prevurl="http://www.communitymatrimony.com/payment/index.php?act=privilege-service";
	    $mailermsg = eregi_replace("<--PREVURL-->",$prevurl,$mailermsg);
		
		$from = "info@communitymatrimony.com";
		$from = preg_replace("/\r/", "", $from); 
		$from = preg_replace("/\n/", "", $from);

		$from_header = "MIME-Version: 1.0\n";
		$from_header .= "Content-type: text/html; charset=iso-8859-1\n";
		$from_header .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
		$from_header .= "Reply-To: ".$rmuserdet[0]["Email"]." \n";
		  
		 
	    //putenv("MAILUSER=bharat"); 
	    //putenv("MAILHOST=server.bharatmatrimony.com");
	    if($useremail==""){$useremail=$toemail;}
	    $useremail = preg_replace("/\r/", "", $useremail); 
	    $useremail = preg_replace("/\n/", "", $useremail);
	    $subtxt=$varProfileBasicResultSet[0]['N']." has been specially chosen for you  by our Relationship Manager";
	    //$mailermsg=$mailermsg_top.$mailermsg;
	    $mailermsg=$mailermsg;
	    $useremail.=",srinivasan.c@bharatmatrimony.com";
	    //$stat=mail($useremail, $subtxt, $mailermsg, $from_header, "-fbharat@server.bharatmatrimony.com"); //mail 
	    //$stat=mail($rmuserdet[0]["Email"], $subtxt, $mailermsg, $from_header, "-fbharat@server.bharatmatrimony.com");
        //$useremail='bmtest24@gmail.com';
	    $stat=mail($useremail, $subtxt, $mailermsg, $from_header); //mailsending function...
	    //$useremail='csvaas@gmail.com';
	    $stat=mail($rmuserdet[0]["Email"], $subtxt, $mailermsg, $from_header);

		return;
		
}
function mempartnerpref($rmuserid,$matriid,$message,$masterObj){ 
		 global $TABLE,$varCbsRminterfaceDbInfo;	

		 /*$InsertQuery="Insert Into ".$TABLE['MEMPARTNERPREF']." (RMUserid,MatriId,Message,Status,TimeCreated) values('".$rmuserid."','".$matriid."','".mysql_real_escape_string($message)."',1,NOW())";		
		 db::insert($InsertQuery);*/

         $varInsertFields	= array("RMUserid","MatriId","Message","Status","TimeCreated");
	     $varInsertVal	= array($masterObj->doEscapeString($rmuserid,$masterObj),$masterObj->doEscapeString($matriid,$masterObj),$masterObj->doEscapeString($message,$masterObj),1,'NOW()');
	     $insertedid = $masterObj->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'], $varInsertFields, $varInsertVal);

         
		 //$this->sendmailtopartner($rmuserid,$matriid,$message);
		 return;
	}
function GetMessage($matriid,$slaveObj) {	 //Get the shedule msg for the matriid
	    global $varCbsRminterfaceDbInfo,$TABLE;
		 /*$Sql="Select Message from ".$DBNAME['RMINTERFACE'].".".$TABLE['MEMPARTNERPREF']." where MatriId='".$matriid."' order by MatriId";
		 db::select($Sql);
		 $message = db::fetchArray();*/
		 $varFields			= array('Message');
		 $varCondition		= " where MatriId=".$masterObj->doEscapeString($matriid,$masterObj)." order by MatriId";
		 $message			= $slaveObj->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'], $varFields, $varCondition,1);
		 $message=$message[0]['Message'];
		 return $message;
	}
function mempartnerprefschedule($rmuserid,$matriid,$message,$schdate,$masterObj){
		 global $TABLE,$varCbsRminterfaceDbInfo;	
		 /*$Update="update ".$TABLE['MEMPARTNERPREF']." set Message='".mysql_real_escape_string($message)."',ScheduleDate='".$schdate."',Status=2 where MatriId='".$matriid."'";
		 $lastdid=db::update($Update);*/

		 $varUpdateFields	= array("Message","ScheduleDate","Status");
	     $varUpdateVal	= array($masterObj->doEscapeString($message,$masterObj),"'".$schdate."'","2");
	     $varUpdateCondtn	= " MatriId=".$masterObj->doEscapeString($matriid,$masterObj);
	     $masterObj->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
		 return;
	}
?>