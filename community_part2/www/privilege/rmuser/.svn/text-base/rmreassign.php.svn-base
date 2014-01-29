<?php
/****************************************************************************************************
File		: Rmmembersegregation.php
Author	: Chitra.S
Date		: 06-Aug-2008
*****************************************************************************************************
Description	: 
	This is Rmuser addition & segregation home page
********************************************************************************************************/
/*$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14"; // This includes MySQL Class details
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14"; // This includes all common functions
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.cil14"; 
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";//This includes all common functions
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.cil14";*/
include_once "include/rmuserheader.php";
include_once "include/common_vars.php";
include_once "include/rmclass.php";
$memberinfo			   = $TABLE['RMMEMBERINFO'];
$rmlogininfo		   = $TABLE['RMLOGININFO'];
$rmmember = new srmclassname();
$rmmember->srminit();
$rmmember->srmConnect();

$test = $rmmember->getDebugParam();
$debug_it['err'] .= $debug_it['br'] .$test['host']["S"];

$DBDOMAINGROUPS = array(7,10,2,1);

$segregatenum = 25;
$selectedrmname = $_REQUEST['rmuser'];
if(isset($_REQUEST['Submit'])) {
	$action = reassigntorm($_REQUEST['rmuser'], $_REQUEST['rermuser'],$_REQUEST['members']);
	//print_r($_REQUEST['members']);
 } else { 
	list($rmuserlist,$hiddenval) = split("###",selectrmusers('1'));
}
//echo $_REQUEST['rmuser'];
?>
<script language="javascript" src="js/common_validation.js"></script>
<script language="javascript" src="js/memsegregation.js"></script>
<script language="javascript" src="js/ajax.js"></script>
<script >
function reassignMemValidation(){		
		
		var memsegregation;
		var div1 = document.getElementById("submitactive");
		var div2 = document.getElementById("submitdisactive");
		
		memsegregation=document.memsegregation;
 		if(!isselectChecked(document.getElementById("rmuser"),' Rmuser'))
		return false;	
		if(!isselectChecked(document.getElementById("rermuser"),' Re assign Rmuser'))
		return false;	
  
		if(document.getElementById("rmuser").value == document.getElementById("rermuser").value){
			alert("Please Change Re assign rm user");
			return false;
		}
 		if(!isCheckboxChecked(document.getElementsByName('members[]'),' members'))
		return false;

		var checkedcount = isCheckedcount(document.getElementsByName('members[]'));
		
	 

		div1.style.display = 'none';
		div2.style.display = '';

		return true;
}
</script>
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
							<td valign="middle" align="center" height="30" colspan="4" style="padding-top:50px;"><span class="normaltext3"><?=$action?> - Members has been Assigned</span></td>
						 </tr>
						 <tr>
							<td valign="middle" align="center" height="30" colspan="4" style="padding-top:50px;"><span class="normaltext3"><a href="#" onclick="javascript:document.memsegregation.submit();" class="normaltext3">Back</a></span></td>
						 </tr>
					<?
					 } else {
					?>
					<tr>
							<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3">Member Segregations</span></td>
					    </tr>
						<tr>
								<td width="20%" align="center" class="tdleft"><span class="normaltext2">Select RMusers</span></td>
								<td width="80%" align="left" class="tdright"><select name="rmuser" id="rmuser" class="normaltext2" style="width:220px;"  onchange='javascript:document.memsegregation.submit();'>
								<option value="0">-Select-</option>
								<?=$rmuserlist;?>
								</select></td>			
						</tr>
						<?=$hiddenval;
					    if($selectedrmname != ''){ ?>
						<tr>
						<td align="center" class="Rtdleft" valign="top" style="padding-top:10px;"><span class="normaltext2">Select Members</span></td>
								<td  style="padding-top:5px;"  align="left" class="Rtdright">
								<table width="95%" cellspacing="0" cellpadding="4" border="0" style="border:0px solid #A196BF;" >
								<?
 									list($html,$act) = split("###",memberdisplay($_REQUEST['rmuser']));
									echo $html;
								?>
								</table>								
								</td>
						</tr><? }
								?>
						 <? list($rmuserlist,$hiddenval1) = split("###",selectrmusers('2')); 
								if($act == "Y") {?>
							<tr>
								<td width="20%" align="center" class="tdleft"><span class="normaltext2">Select Re Assign RMusers</span></td>
								<td width="80%" align="left" class="tdright"><select name="rermuser" id="rermuser" class="normaltext2" style="width:220px;"  >
								<option value="0">-Select-</option>
								 
 								<?=$rmuserlist;?>
								</select></td>			
						</tr>
						
						<tr>
								<td colspan="2" align="center" style="height:30px;" class="normaltext2">
								<div id="submitactive"  align="center" >
								<input type="submit" value="Submit" name="Submit" class="SubmitButton"  onclick="return reassignMemValidation();"></div>
								<div id="submitdisactive" style="display:none"  align="center" >
								<input type="submit" value="Submit" name="Submit12" class="SubmitButton"></div>
								</div>
								</td>										
						</tr>
						
						<?}
						}
						?>
						
					   <tr><td height="50">&nbsp;</td></tr>
				</table>
				</form>
			</td>
		</table>
	</td>
</tr>
<?
$rmmember->dbClose();
$msg = $debug_it['err'];
sendrptmail($msg);
include_once "include/rmfooter.php";
?>
</body>
</html>

<?
function selectrmusers($val) {
	global $rmmember, $Rmusers, $SegregatedRmusers,$selectedrmname;	
	
	$SegregatedRmusers = $rmmember->ExistingRmusers();	

	//$userremove = separateusers($SegregatedRmusers);	

	$Rmusers = $rmmember->SelectRmusers($userremove);

	if(is_array($Rmusers) && count($Rmusers) >0) {
		$selectbox = "";
		foreach($Rmusers as $users=>$name) {
			if($SegregatedRmusers[$users] != ""){ 
				$count = $SegregatedRmusers[$users];
			} else {
				$count = 0;
			}
			  if($val == 1){
			if($selectedrmname == $users)
				$selectcont = "SELECTED";
			else 
				$selectcont = '';}
			$hidden .= "<input type=\"hidden\"  name=\"rermuser\" id=\"".$users."\" value=\"".$count."\" >";
			$selectbox .= "<option value='".$users."' ".$selectcont.">".ucwords(strtolower($name))." [".$users."] [".$count."]</option>";
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

function memberdisplay($rmuser) {
	global $rmmember,$PROFILECREATEDHASH,$segregatenum;

	$unsegregatedmem = $rmmember->unsegregatedmember($rmuser);
	   
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
			/*$domaininfo = getDomainInfo(1,$members);			
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


 function reassigntorm($rmid,$toassign,$matriid){
	global $rmmember,$rmlogininfo,$memberinfo,$varCbsRminterfaceDbInfo,$varDbInfo,$TABLE,$varTable,$DBINFO;
	$assureid = '';
	for($i=0;$i < count($matriid);$i++){
		$explodeids .="'". $matriid[$i]."',";
	}
	$dispmatriid = substr_replace($explodeids, '' , -1, 1);
	// Get array result - To Assign Rm user
	/*$reassigndet = "Select * from ".$rmlogininfo." where RMUserid='".$toassign."'";
	$getnum=$rmmember->select($reassigndet);
	$getrow = $rmmember->fetchArray(); //print_r($rmmember);*/

    $varActCondtn	= " where RMUserid='".$toassign."'";
    $rows		    = $rmmember->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$rmlogininfo,$varActCondtn,0);
	$getrow         = mysql_fetch_assoc($rows);
	

	//$showqry = $reassigndet."\n";

	/*$selectrmdetails = "Select * from ".$memberinfo." where MatriId in(".$dispmatriid.") and RMUserid='".$rmid."'";
	$num=$rmmember->select($selectrmdetails); 
	$showqry .= $selectrmdetails."\n";
	$total = $rmmember->getResultArray();*/

	$varActCondtn	= " where MatriId in(".$dispmatriid.") and RMUserid='".$rmid."'";
    $numCnt		    = $rmmember->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo,$varActCondtn,1);
    $num=count($numCnt);
	$rows		    = $rmmember->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo,$varActCondtn,0);
	$total[]         = mysql_fetch_assoc($rows);

	// Update Rmuser 
	/*$update = "update ".$memberinfo." set RMUserid='".$toassign."' where MatriId in(".$dispmatriid.") and RMUserid='".$rmid."'";  
	$updateaffect = $rmmember->update($update);    //print_r($rmmember);*/


	$varUpdateFields	=array("RMUserid");
	$varUpdateVal	= array("'".$toassign."'");
	$varUpdateCondtn	= " MatriId in(".$dispmatriid.") and RMUserid='".$rmid."'";
	$rmmember->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

	

	$showqry .= $update."\n";
	foreach($total as $row){ //$row['PrivStatus']."<br>";
	// If Full Access Means , do below process....
	
		if($row['PrivStatus'] == 1){
			//$senderdomaininfo   = getDomainInfo(1,$row['MatriId']); 
			//$senderdomainname   = strtoupper($senderdomaininfo['domainnameshort']);
			$logininfotable     = $varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'];
			$assureid .= $row['MatriId'].",";

			/*$masterconn = new db();
			$masterconn->dbConnByIdMergeMaster(2, $row['MatriId'],'M',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);

 			$updatelogininfo = "update ".$logininfotable." set Email='".$getrow['Email']."',DateUpdated=NOW() where MatriId='".$row['MatriId']."'";
			$logininfoaffected = $rmmember->master->update($updatelogininfo);//print_r($masterconn);
			$showqry .= $updatelogininfo."\n";*/

			$varUpdateFields	=array("Email","Date_Updated");
			$varUpdateVal	= array("'".$getrow['Email']."'","NOW()");
			$varUpdateCondtn	= " MatriId='".$row['MatriId']."'";
			$rmmember->master->update($logininfotable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

		}
 	}
    
	$updateassureid = substr_replace($assureid, '' , -1, 1);
	if($assureid != ''){
		/*$db5= new db();
		$db5->connect($DBCONIP['DB5'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ASSUREDCONTACT']);*/
		$tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'];

		/*$updateassuredet = "update ".$tblname." set PhoneNo1='".$getrow['Mobile']."' , ContactPerson1='".$getrow['Name']."' , Relationship1='7' , Timetocall1='Office hours between 10 am to 5 pm' where MatriId in('".$updateassureid."')";
		$assuredetaffectaffected = $db5->update($updateassuredet);//print_r($db5);
		$showqry .= $updateassuredet."\n";*/

		$varUpdateFields	=array("PhoneNo1","ContactPerson1","Relationship1","Timetocall1");
		$varUpdateVal	= array("'".$getrow['Mobile']."'","'".$getrow['Name']."'","7","'Office hours between 10 am to 5 pm'");
		$varUpdateCondtn	= " MatriId in('".$updateassureid."')";
		$rmmember->master->update($tblname, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

	}
	if($dispmatriid != '' || $assureid != ''){
		$content = "Matriid ('".$dispmatriid."') assign from  Rmid('".$rmid."') to '".$toassign."'";
	}else {
			$content = "Already Done Thanks!";
	}
	 mail("srinivasan.c@bharatmatrimony.com","Rminterface Reassign Querys",$showqry);
	return $content;
 }
 
 
 
 
?>