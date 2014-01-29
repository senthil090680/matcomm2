<?php

include_once "include/common_vars.php";
include_once "include/rmclass.php";

$memberinfo	 = $TABLE['RMMEMBERINFO'];
$rmlogininfo	 = $TABLE['RMLOGININFO'];
$memberinfobkup = $TABLE['MEMBERCONTACTINFOBKUP'];

$wsmemClient = new WSMemcacheClient;
$rmmember = new srmclassname();
$rmmember->srminit();
$rmmember->srmConnect();

$test = $rmmember->getDebugParam();
$debug_it['err'] .= $debug_it['br'] .$test['host']['S'];

$DBDOMAINGROUPS = array(7,10,2,1);

$segregatenum = 25;
$selectedrmname = $_REQUEST['rmuser'];
if(isset($_REQUEST['rmids'])) {

	$action = deletefromBmp($_REQUEST['rmuser'],$_REQUEST['rmids'],$wsmemClient);

	//print_r($_REQUEST['members']);
 } else { include_once "include/rmuserheader.php";
	list($rmuserlist,$hiddenval) = split("###",selectrmusers('1'));
}
//echo $_REQUEST['rmuser'];
?>
<script language="javascript" src="js/common_validation.js"></script>
<script language="javascript" src="js/memsegregation.js"></script>
<script language="javascript" src="js/ajax.js"></script>
 
<tr >
	<td width="100%" ><div id="karthik">
		<table border="0" cellpadding="0" cellspacing="0" width="900" >
			<tr>
			<!-- <td width="200"  style="border-right:solid 1px #9BD6E5"><? include_once "../template/ansadminleft.php"; ?></td> -->
			<td width="100%" style="padding-left:20px;"> 
			<form name="memsegregation" method="post" >
				<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center" >
				<?
					if(isset($_REQUEST['rmids'])) {						
				?>
						<tr>
							<td valign="middle" align="center" height="30" colspan="4" style="padding-top:50px;"><span class="normaltext3"><?=$action?></span></td>
						 </tr>
						 <tr>
							<td valign="middle" align="center" height="30" colspan="4" style="padding-top:50px;"><span class="normaltext3"><a href="#" onclick="javascript:document.memsegregation.submit();" class="normaltext3">Back</a></span></td>
						 </tr>
					<?
					 } else {
					?>
					<tr>
							<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3">Delete Member</span></td>
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
								<td colspan="2" align="center" style="height:30px;" class="normaltext2">
								<div id="submitactive"  align="center" >
								<input type="submit" value="Delete" name="Submit" class="SubmitButton"  onclick="return deleteRecord('karthik');"></div>
								<div id="submitdisactive" style="display:none"  align="center" >
								<input type="submit" value="Delete" name="Submit12" class="SubmitButton"></div>
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
		</table></div>
	</td>
</tr><div id="disp" style="display:none"> </div>
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


 function deletefromBmp($rmid,$matriid,$wsmemClient){ 
	global $rmmember,$rmlogininfo,$memberinfobkup,$memberinfo,$varCbsRminterfaceDbInfo,$varDbInfo,$TABLE,$varTable,$DBINFO;
	$content = '';

	$getmatriids = explode("~",$matriid);
	for($i=0;$i < count($getmatriids);$i++){
		$explodeids .="'". $getmatriids[$i]."',";
	}
	$dispmatriid = substr_replace($explodeids, '' , -1, 1);

	/*$selectrmdetails = "Select PrivStatus,MatriId from ".$memberinfo." where MatriId in(".$dispmatriid.") and RMUserid='".$rmid."'"; 
	$num=$rmmember->select($selectrmdetails); 
	$showqry .= $selectrmdetails."\n";
	$total = $rmmember->getResultArray();*/

	$varActFields	= array("PrivStatus","MatriId");
	$varActCondtn	= " where MatriId in(".$dispmatriid.") and RMUserid='".$rmid."'";
	$total		= $rmmember->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo,$varActFields,$varActCondtn,1);
   
	
	/*$db5= new db();
	$db5->connect($DBCONIP['DB5'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ASSUREDCONTACT']);*/

	$tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'];
	
	foreach($total as $row){ 
		// If Full Access Means , do below process....
		//print_r($row);exit;
		if($row['PrivStatus'] == 1){

			/*$getmemberdet = "select * from ".$memberinfobkup." where MatriId='".trim($row['MatriId'])."'";
			$num=$rmmember->select($getmemberdet); 
			$showqry .= $getmemberdet."\n";
			$getrecval = $rmmember->fetchArray();*/

			$varActCondtn	= " where MatriId='".trim($row['MatriId'])."'";
			$rows		    = $rmmember->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfobkup,$varActCondtn,0);
			$getrecval         = mysql_fetch_assoc($rows);
			            
			/*$senderdomaininfo   = getDomainInfo(1,trim($row['MatriId'])); 
			$senderdomainname   = strtoupper($senderdomaininfo['domainnameshort']);*/

			$logininfotable     = $varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'];
			$loginprofiletable  = $varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];

			/*$masterconn = new db();
			$masterconn->dbConnByIdMergeMaster(2, trim($row['MatriId']),'M',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);*/

			if($getrecval['Email']) {	
				
 			/*$updatelogininfo = "update ".$logininfotable." set Email='".$getrecval['Email']."',DateUpdated=NOW() where MatriId='".trim($row['MatriId'])."'";
			$logininfoaffected = $masterconn->update($updatelogininfo);//print_r($masterconn);
			$showqry .= $updatelogininfo."\n"; */

			$varUpdateFields	=array("Email","Date_Updated");
			$varUpdateVal	= array("'".$getrecval['Email']."'","NOW()");
			$varUpdateCondtn	= " MatriId='".trim($row['MatriId'])."'";
			$rmmember->master->update($logininfotable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
			}
				
			/*$updateSP = "update ".$loginprofiletable." set specialpriv=2,DateUpdated=NOW() where MatriId='".$row['MatriId']."'";
			$loginpro_affected = $masterconn->update($updateSP);//print_r($masterconn);
			$showqry .= $updateSP."\n";	*/
			
			$varUpdateFields	=array("special_priv","Date_Updated");
			$varUpdateVal	= array("2","NOW()");
			$varUpdateCondtn	= " MatriId='".$row['MatriId']."'";
			$rmmember->master->update($loginprofiletable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
            $wsmemClient->processRequest($row['MatriId'],"memberinfo");
			
			if($getrecval['PhoneVerified'] == 0){
				/*$updatePV = "update ".$loginprofiletable." set PhoneVerified=0,DateUpdated=NOW() where MatriId='".$row['MatriId']."'";
				$logininfoaffected = $masterconn->update($updatePV);//print_r($masterconn);
				$showqry .= $updatePV."\n";
				$phoneveriaff = $masterconn->getAffectedRows();*/

				$varUpdateFields	=array("Phone_Verified","Date_Updated");
			    $varUpdateVal	= array("0","NOW()");
			    $varUpdateCondtn	= " MatriId='".$row['MatriId']."'";
			    $phoneveriaff=$rmmember->master->update($loginprofiletable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
                $wsmemClient->processRequest($row['MatriId'],"memberinfo");

				if($phoneveriaff > 0){
					/*$deleteassure = "delete from ".$tblname." where MatriId='".trim($row['MatriId'])."'";
					$db5->del($deleteassure);
					$showqry .= $deleteassure."\n";*/

					$argTblName=$tblname;
					$argCondition	= " MatriId='".trim($row['MatriId'])."'";
					$rmmember->master->delete($argTblName, $argCondition);
				}
			}
			else if($getrecval['PhoneVerified'] == 1){
				/*$updateassuredet = "update ".$tblname." set CountryCode='".$getrecval['CountryCode']."',AreaCode='".$getrecval['AreaCode']."',PhoneNo='".$getrecval['PhoneNo']."',MobileNo='".$getrecval['MobileNo']."',PhoneNo1='".$getrecval['PhoneNo1']."' , ContactPerson1='".$getrecval['ContactPerson1']."' , Relationship1='".$getrecval['Relationship1']."' , Timetocall1='".$getrecval['Timetocall1']."' where MatriId='".trim($row['MatriId'])."'";
				$assuredetaffectaffected = $db5->update($updateassuredet);//print_r($db5);
				$showqry .= $updateassuredet."\n";*/

				$varUpdateFields	=array("CountryCode","AreaCode","PhoneNo","MobileNo","PhoneNo1","ContactPerson1","Relationship1","Timetocall1");
			    $varUpdateVal	= array("'".$getrecval['CountryCode']."'","'".$getrecval['AreaCode']."'","'".$getrecval['PhoneNo']."'","'".$getrecval['MobileNo']."'","'".$getrecval['PhoneNo1']."'","'".$getrecval['ContactPerson1']."'","'".$getrecval['Relationship1']."'","'".$getrecval['Timetocall1']."'");
			    $varUpdateCondtn	= " MatriId='".trim($row['MatriId'])."'";
			    $phoneveriaff=$rmmember->master->update($tblname, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
			}
			
			$insertbktbl = "insert into ".$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFOBKUP']." select * from ".$varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo." where MatriId='".trim($row['MatriId'])."' and PrivStatus=1";
			$showqry .= $insertbktbl."\n";
			//$insertbk =$rmmember->insert($insertbktbl);

			$rmmember->master->ExecuteQry($insertbktbl);
			
			/*$detrec = "delete from ".$memberinfo." where MatriId='".trim($row['MatriId'])."' and PrivStatus=1";
			$showqry .= $detrec."\n";
			$delrecord =$rmmember->del($detrec);*/

			$argTblName=$varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo;
			$argCondition	= " MatriId='".trim($row['MatriId'])."' and PrivStatus=1";
			$rmmember->master->delete($argTblName, $argCondition);

			

		  }else {
				$insertbktbl = "insert into ".$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFOBKUP']." select * from ".$varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo." where MatriId='".trim($row['MatriId'])."' and PrivStatus=2";
				$showqry .= $insertbktbl."\n";
				//$insertbk =$rmmember->insert($insertbktbl);
				$rmmember->master->ExecuteQry($insertbktbl);
			
					/*$detrec = "delete from ".$memberinfo." where MatriId='".trim($row['MatriId'])."' and PrivStatus=2";
					$showqry .= $detrec."\n";
					$delrecord =$rmmember->del($detrec);*/
					$argTblName=$varCbsRminterfaceDbInfo['DATABASE'].".".$memberinfo;
			        $argCondition	= " MatriId='".trim($row['MatriId'])."' and PrivStatus=2";
			        $rmmember->master->delete($argTblName, $argCondition);

			  }
}
		
	if($dispmatriid != '' && $content == ''){
		$content = "List of matriid(s) ('".$dispmatriid."') deleteted from our interface";
	} 

	
	//echo $showqry;
	 mail("srinivasan.c@bharatmatrimony.com","Rminterface Delete Querys",$showqry);
	return $content;
 }
 
 
 
 
?>