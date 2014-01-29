<?
#==========================================================================================================
# Author 		: Dhanapal, Srinivasan
# Date	        : 01 Jan 2010
# Project		: Community Matrimony RM Interface
# Filename		: rmheader.php
#==========================================================================================================
# Description   : Main
#==========================================================================================================

//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/lib/clsRMDB.php");
include_once($varRootBasePath.'/www/privilege/config/config.cil14');

//OBJECT DECLARATION
$objDB = new DB;
$objDB->dbConnect('S',$varDbInfo['DATABASE']);


$sessRMUsername = $_COOKIE['rmusername'];
if(!$sessRMUsername){
	header("location:http://www.communitymatrimony.com/privilege/mainindex.php");
}

//userlist function
$varFields			= array('MatriId');
$varCondition		= " WHERE RMUserid = ".$objDB->doEscapeString($sessRMUsername,$objDB)." ORDER BY MatriId";
$varExecute			= $objDB->select($varCbsRminterfaceDbInfo['DATABASE'].".".$tbl['RMMEMBERINFO'], $varFields, $varCondition,0);
$generateqry = '';
while($searchlist = mysql_fetch_assoc($varExecute)){
			$generateqry.="'".$searchlist['MatriId']."',";
}
$userlist = $generateqry;



//userpartnerlist function
$partnerarr = array();
if($userlist){
	$varFields			= array('MatriId','Partner_Set_Status');
	$varCondition		= " where MatriId IN(".substr($userlist,0,strlen($userlist)-1).") order by MatriId";
	$varExecute			= $objDB->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'], $varFields, $varCondition,0);
	$cnt=0;
	while($partner = mysql_fetch_assoc($varExecute)){
				$partnerarr[$cnt][0] = $partner['MatriId'];
				$partnerarr[$cnt][1] = $partner['Partner_Set_Status'];
				$cnt++;
	}
}
$partnerlist=$partnerarr;

//getpartnerstatus function
$partnerarrr = array();
if($userlist){
$varFields			= array('MatriId','Status','TimeCreated','ScheduleDate');
$varCondition		= " where MatriId IN(".substr($userlist,0,strlen($userlist)-1).") order by MatriId";
$varExecute			= $objDB->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'], $varFields, $varCondition,0);
$cnt=0;
while($partnerr = mysql_fetch_assoc($varExecute)){
			$partnerarrr[$partnerr['MatriId']] = $partnerr['Status']."$".$partnerr['TimeCreated']."$".$partnerr['ScheduleDate'];
}
}

$getmemberstatus=$partnerarrr;
//For Paging Purpose
$nume=count($partnerlist);
$endloop=$strtloop+$limit;
if($endloop>=count($partnerlist)) {
	$endloop=$endloop-$nume;
	$strtloop=$endloop+1;
	$endloop=$_REQUEST['start']+1;
}

?>
<Script Language="JavaScript">

function load(matriid,status) {
//var url="mainindex.php?act=rmmempartnermail&memid="+matriid+"&status="+status;
var url="rmmempartnermail.php?memid="+matriid+"&status="+status;
var load = window.open(url,'','scrollbars=no,menubar=no,height=500,width=500,resizable=yes,toolbar=no,location=no,status=no');
}

</Script>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td width="100%" style="padding-left:20px;">
		<table border="0" cellpadding="0" cellspacing="0" width="97%">
				<tr><td colspan="4" height="20">&nbsp;</td></tr>
				<tr>
					   <td align="left" height="30" colspan="4" bgcolor="#dbdbdb" style="padding-left:10px;"><span class="normtxt1 bld">Member Partner Preference Status</span></td>
				</tr>
				<tr>
					   <td align="left" height="30" colspan="4" style="padding-left:10px;"><span class="normtxt">If you would like to make changes to the information, please make the changes in the relevant fields and save.</span></td>
				</tr>
				<tr>
					  <td>	
						<form name="contactdet" method="post">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="brdr">
									<tr><td width="25%" style="padding:5px 10px;border-right:1px solid #cbcbcb;"><span class="normtxt bld">Member Id</span></td>
											<td width="25%" style="padding:5px 10px;border-right:1px solid #cbcbcb;"><span class="normtxt bld">Configure E-Mail</span></td>
											<td width="25%" style="padding:5px 10px;border-right:1px solid #cbcbcb;"><span class="normtxt bld">Test Mail Triggered Date</span></td>
											<td width="25%" style="padding:5px 10px;"><span class="normtxt bld">Scheduled Date</span></td>
									</tr>
									<tr><td colspan="4" bgcolor="#cbcbcb" height="1"></td></tr>
									<?
									//if(count($getmemberstatus)>=1) {	//Any one matriid configured or testmail triggered.
									for($member=0;$member<count($partnerlist);$member++) {	 //List the all segregation matriid for corresponding rmuserid
									?>
									<tr>
										   <td style="padding:5px 10px;border-right:1px solid #cbcbcb;"><span class="normtxt"><?=$partnerlist[$member][0];?></span></td>
										   <td style="padding:5px 10px;border-right:1px solid #cbcbcb;" ><span class="normtxt">
										   <?
												//show the link only partner preferenece true matriid's only
												if(($partnerlist[$member][1]==1))	 {
													 //Matriid Status(Ex: Already Trigger or Full Configured. 1- Test Maill send,2-Fully Configured)
														$memdet=$getmemberstatus[$partnerlist[$member][0]];	
														$memdet=explode("$",$memdet);
														 if($memdet[0]==1) {	 //Already Triggered Test mail
															  echo $configlink="<a href=\"javascript:load('".$partnerlist[$member][0]."','".$memdet[0]."')\" class=normtxt >Waiting For Approval</a>";
														 }	 else if($memdet[0]==2) {		//Fully Configured and scheduled
															   echo $configlink="Fully Configured";
														 }  else if($memdet[0]==0) {
																 echo $configlink="<a href=\"javascript:load('".$partnerlist[$member][0]."','0')\" class='normtxt clr1' >To Configure E-Mail</a>";
														 }
														
												}  else {
													echo "&nbsp;";
												}
												
										  ?>
										   </span>
										   </td>
										   <td style="padding:5px 10px;border-right:1px solid #cbcbcb;" >
										   <span class="normtxt">
										   <?if($memdet[1]==""){echo "&nbsp;";}else{echo $memdet[1];}?>
										   </span>
										   </td>
										   <td style="padding:5px 10px;" ><span class="normtxt">  <?if($memdet[2]==""){echo "&nbsp;";}else{echo $memdet[2];}?></span></td>
									</tr>
									<?}?>											
									<tr>
									<td colspan="3">
									<?/*
									if($nume>4) {
										if($back >=0) { 
											print "<a href='$page_name?start=$back'><font face='Verdana' size='2'>PREV</font></a>"; 
										} 
									
										$i=0;
										$l=1;
										for($i=0;$i < $nume;$i=$i+$limit){
											if($i <> $strtloop){
												echo " <a href='$page_name?start=$i'><font face='Verdana' size='2'>$l</font></a> ";
											}
											else { echo "<font face='Verdana' size='4' color=red>".$l."</font>";}       
											$l=$l+1;
										}

										if($this1 < $nume) { 
											print "<a href='$page_name?start=$next'><font face='Verdana' size='2'>NEXT</font></a>";} 
									}*/
									?>
							</td>									
					</tr>
								</table>
						  </form>
					  </td>
				</tr>
			   <tr><td height="20">&nbsp;</td></tr>
		</table>	
	</td>
</table>