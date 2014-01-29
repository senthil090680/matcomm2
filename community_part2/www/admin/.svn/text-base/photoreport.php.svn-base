<?php
$varRootPath = $_SERVER['DOCUMENT_ROOT'];
$varBasePath = dirname($varRootPath);

include_once($varBasePath.'/www/admin/includes/userLoginCheck.php');
include_once($varBasePath.'/www/admin/includes/admin-privilege.inc');
include_once($varBasePath.'/conf/dbinfo.inc');
include_once($varBasePath.'/lib/clsDB.php');

$cookValue		= split('&', $_COOKIE['adminLoginInfo']);
$varUsername	= $cookValue[1];
$varSupportTable= 'support_validation_report';
$varAdminTable	= $varTable['ADMINLOGININFO'];
$varResultCont  = '';

$varWholeReport = array_key_exists($varUsername, $arrManageUsers) ? 'yes' : 'no';

$objSlaveDB	= new DB;

$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

if($varWholeReport == 'yes'){
	$varUsersList	= '';
	$varWhereCond	= '';
	$arrFields		= array('User_Name');
	$varResultSet	= $objSlaveDB->select($varAdminTable, $arrFields, $varWhereCond, 0);
	while($row = mysql_fetch_assoc($varResultSet)){
		$varUsersList .= '<option value="'.$row['User_Name'].'">'.$row['User_Name'].'</option>';
	}
}

if($_POST['frmSubmit']=='yes'){
	$varFromdate	= $_POST['fromdate'].' '.$_POST['fromHour'].':'.$_POST['fromMin'].':00';
	$varTodate		= $_POST['todate'].' '.$_POST['toHour'].':'.$_POST['toMin'].':59';
	$arrFields		= array('userid', 'SUM(notifycustomer) AS reject', 'SUM(profilestatus) AS added');
	$varWhereCond	= '';
	if($varWholeReport == 'yes'){
		if(in_array('all', $_POST['userids'])){
			$varWhereCond = "WHERE reporttype=3 AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid";
			$varHoroWhereCond = "WHERE reporttype=5 AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid";
			$varProfileWhereCond = "WHERE reporttype=1 AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid,profilestatus";
		}else if(count($_POST['userids'])>1){
			$varUserIds	  = join("', '", $_POST['userids']);
			$varWhereCond = "WHERE reporttype=3 AND userid IN('".$varUserIds."') AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid IN('".$varUserIds."') AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid IN('".$varUserIds."') AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid,profilestatus";
		}else if(count($_POST['userids'])==1){
			$varWhereCond = "WHERE reporttype=3 AND userid='".$_POST['userids'][0]."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."'";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid='".$_POST['userids'][0]."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."'";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid='".$_POST['userids'][0]."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid,profilestatus";
		}else{
			$varWhereCond = "WHERE reporttype=3 AND userid='".$varUsername."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."'";
			$varHoroWhereCond = "WHERE reporttype=5 AND userid='".$varUsername."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."'";
			$varProfileWhereCond = "WHERE reporttype=1 AND userid='".$varUsername."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid,profilestatus";
		}
	}else{
		$varWhereCond = "WHERE reporttype=3 AND userid='".$varUsername."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."'";
		$varHoroWhereCond = "WHERE reporttype=5 AND userid='".$varUsername."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."'";
		$varProfileWhereCond = "WHERE reporttype=1 AND userid='".$varUsername."' AND validateddate>='".$varFromdate."' AND validateddate<'".$varTodate."' GROUP BY userid,profilestatus";
	}
	
	//Photo Validation Report
	$varResultSet = $objSlaveDB->select($varSupportTable, $arrFields, $varWhereCond, 0);
	$varResultCont  = '<br><br><br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="3"><b>Photo Validation Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Added</td><td>Rejected</td></tr>';
	if(mysql_num_rows($varResultSet)>0){
		$varTotalAdded	= 0;
		$varTotalReject	= 0;
		while($row=mysql_fetch_assoc($varResultSet)){
			$varResultCont .= '<tr class="mediumtxt"><td>'.$row['userid'].'</td><td>'.$row['added'].'</td><td>'.$row['reject'].'</td></tr>';
			$varTotalReject = $varTotalReject+$row['reject'];
			$varTotalAdded = $varTotalAdded+$row['added'];
		}
		if($varTotalAdded > 0 || $varTotalReject>0){
			$varResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalAdded.'</td><td>'.$varTotalReject.'</td></tr>';
		}
		
	}else{
		$varResultCont .= '<tr><td colspan="3" align="center">Records not available</td></tr>';
	}
	$varResultCont .= '</table>';


	//Horoscope Validation Report
	$varHoroResultSet = $objSlaveDB->select($varSupportTable, $arrFields, $varHoroWhereCond, 0);
	$varHoroResultCont= '<br><br><br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="3"><b>Horoscope Validation Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Added</td><td>Rejected</td></tr>';
	if(mysql_num_rows($varHoroResultSet)>0){
		$varTotalAdded	= 0;
		$varTotalReject	= 0;
		while($row=mysql_fetch_assoc($varHoroResultSet)){
			$varHoroResultCont .= '<tr class="mediumtxt"><td>'.$row['userid'].'</td><td>'.$row['added'].'</td><td>'.$row['reject'].'</td></tr>';
			$varTotalReject = $varTotalReject+$row['reject'];
			$varTotalAdded = $varTotalAdded+$row['added'];
		}
		if($varTotalAdded > 0 || $varTotalReject>0){
			$varHoroResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalAdded.'</td><td>'.$varTotalReject.'</td></tr>';
		}
		
	}else{
		$varHoroResultCont .= '<tr><td colspan="3" align="center">Records not available</td></tr>';
	}
	$varHoroResultCont .= '</table>';


	//Profile Validation Report
	$arrFields		= array('userid', 'profilestatus', 'COUNT(profilestatus) AS Cnt');
	$varProfileResultSet = $objSlaveDB->select($varSupportTable, $arrFields, $varProfileWhereCond, 0);

	$varProfileResultCont  = '<br><br><table width="542" cellspacing="2" cellpadding="2" border="1" style="border:1px solid"><tr><td colspan="4"><b>Profile Validation Report</b></td></tr><tr class="mediumtxt boldtxt"><td>Username</td><td>Approved</td><td>Ignored</td><td>Rejected</td></tr>';

	if(mysql_num_rows($varProfileResultSet)>0){
		while($row=mysql_fetch_assoc($varProfileResultSet)){
			//if($row['profilestatus']=='') {echo "Hai";$row['profilestatus']='X';}
			$arrUserDet[$row['userid']][$row['profilestatus']] = $row['Cnt'];
		}

		$varTotalApproved	= 0;
		$varTotalIgnored	= 0;
		$varTotalRejected	= 0;
		$varTotalTimeouted	= 0;
		//$varTotalNothingDone= 0;

		foreach($arrUserDet as $key=>$arrSingle) {
			$arrSingle['A'] = $arrSingle['A']==''?0:$arrSingle['A'];
			$arrSingle['I'] = $arrSingle['I']==''?0:$arrSingle['I'];
			$arrSingle['R'] = $arrSingle['R']==''?0:$arrSingle['R'];
			//$arrSingle['Z'] = $arrSingle['Z']==''?0:$arrSingle['Z'];
			//$arrSingle['X'] = $arrSingle['X']==''?0:$arrSingle['X'];

			$varProfileResultCont .= '<tr class="mediumtxt"><td>'.$key.'</td><td>'.$arrSingle['A'].'</td><td>'.$arrSingle['I'].'</td><td>'.$arrSingle['R'].'</td><td>'.$arrSingle['Z'].'</td></tr>';

			$varTotalApproved	= $varTotalApproved+$arrSingle['A'];
			$varTotalIgnored	= $varTotalIgnored+$arrSingle['I'];
			$varTotalRejected	= $varTotalRejected+$arrSingle['R'];
			//$varTotalTimeouted	= $varTotalTimeouted+$arrSingle['Z'];
			//$varTotalNothingDone= $varTotalNothingDone+$arrSingle['X'];
		}
		
		if($varTotalApproved>0 || $varTotalIgnored>0 || $varTotalRejected>0 || $varTotalTimeouted>0 || $varTotalNothingDone>0){
			$varProfileResultCont .= '<tr class="mediumtxt boldtxt"><td>Total</td><td>'.$varTotalApproved.'</td><td>'.$varTotalIgnored.'</td><td>'.$varTotalRejected.'</td></tr>';
		}
		$varProfileResultCont .= '</table>';
	}else{
		$varProfileResultCont .= '<tr><td colspan="4" align="center">Records not available</td></tr>';
	}
	$varProfileResultCont .= '</table>';
}

function getselectbox($argSelName, $argSelVal){
	$varOptions	= '<select style="border:1px solid #B3B3B3;font-size:11px;font-weight:normal;" name="'.$argSelName.'">';
	for($i=0; $i<$argSelVal; $i++){
		$varDispVal	= ($i < 10) ? "0".$i : $i;
		$varOptions.= '<option value="'.$varDispVal.'">'.$varDispVal.'</option>'; 
	}
	$varOptions .= '</select>';
	return $varOptions;
}
?>
<br clear="all">
<script language="javascript" src="<?=$confValues['JSPATH']?>/calenderJS.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js"></script>
<script>
function validate(){
	if(document.frmReport.fromdate.value == ''){
		alert('Please select the from date');
		return false;
	}else if(document.frmReport.todate.value == ''){
		alert('Please select the to date');
		return false;
	}
	return true;
}

function selectUser() {
	var totleng = document.frmReport.userids.length;
	for(i=0; i<totleng; i++) {
		document.frmReport.userids.options[i].selected = true;
	}
	return true;
}
</script>

<table width="542" cellspacing="2" cellpadding="2">
	<tr class="mediumtxt boldtxt"><td colspan="4">User wise report</td></tr>
	<form name="frmReport" method="post" onsubmit="return validate();">
	<? if($varWholeReport == 'yes'){?>
	<tr class="mediumtxt">
		<td>Select User</td>
		<td width="40"><select style="border:1px solid #B3B3B3;font-size:11px;font-weight:normal;width:170px;" name="tempuserids" multiple size="4" ><option value="all">All Users</option><?=$varUsersList;?></select></td>
		<td width="10" align="center">
			<input class="button" type="button" onclick="moveOptions(this.form.tempuserids, this.form.userids);" value=">"><br><br>
			<input class="button" type="button" onclick="moveOptions(this.form.userids, this.form.tempuserids);" value="<">
		</td>
		<td width="40"><select style="border:1px solid #B3B3B3;font-size:11px;font-weight:normal;width:170px;" name="userids[]" id="userids" multiple size="4"></select></td>
	</tr>
	<? } ?>
	<tr class="mediumtxt">
		<td>From date</td>
		<td colspan="3">
		<input type="text" name="fromdate" readonly="" value="" style="width:120px" onclick="displayDatePicker('fromdate', document.frmReport.fromdate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		<?=getselectbox('fromHour', 24);?>
		<?=getselectbox('fromMin', 60);?>
		</td>
	</tr>
	<tr class="mediumtxt">
		<td>To date</td>
		<td colspan="3">
		<input type="text" name="todate" readonly="" value="" style="width:120px" onclick="displayDatePicker('todate', document.frmReport.todate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		<?=getselectbox('toHour', 24);?>
		<?=getselectbox('toMin', 60);?>
		</td>
	</tr>
	<tr class="mediumtxt">
		<td colspan="4" align="right">
			<input type="hidden" name="frmSubmit" value="yes">
			<input class="button" type="submit" name="submit" value="Submit" onClick="return selectUser();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
<?=$varResultCont;?>
<?=$varHoroResultCont;?>
<?=$varProfileResultCont;?>