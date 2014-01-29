<?php
/****************************************************************************************************
File		: viewphonelog.php
Author	    : Chitra.S
Date		: 03-Aug-2008
*****************************************************************************************************
Description	: 
	This is Rmmember phonelog details
********************************************************************************************************/

// Includes header information
include_once "include/rmuserheader.php";
include_once "include/rmclass.php";


$rmuserdb = new srmclassname();
$rmuserdb->srminit();
$rmuserdb->srmConnect();

$conn = $rmuserdb->getDebugParam();

$debug_it['err'] .= $debug_it['br'] .$conn['host']['S'];

if(isset($_REQUEST['act'])) {	

	if(!isset($_GET['page'])) {
		$page = 1;
		$rmuser = $_REQUEST['rmuser'];
		$fromdate = $_REQUEST['fromdate'];
		$todate = $_REQUEST['todate'];

	} else {
		$page = $_GET['page'];
		list($rmuser, $fromdate, $todate) = split("&", base64_decode($_GET['value']));
	}
	$passingvalue = $rmuser."&".$fromdate."&".$todate;
	$pass = base64_encode($passingvalue);

	$max_results = 20;
	$from = (($page * $max_results) - $max_results); 


	$rmuserphlogdetails = $rmuserdb->Rmuserphlogdetails($rmuser,$fromdate,$todate,$from,$max_results);

	$tot =  $rmuserdb->totallogcount($rmuser,$fromdate,$todate);

}
?>
<script language="javascript" src="js/common_validation.js"></script>
<script language="javascript" src="js/phonelog.js"></script>

<!--<link type="text/css" rel="stylesheet" href="calender/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
<script type="text/javascript" src="calender/dhtmlgoodies_calendar.js?random=20060118"></script>-->


<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<!-- <td width="200"  style="border-right:solid 1px #9BD6E5"><? include_once "../template/ansadminleft.php"; ?></td> -->
			<td width="100%" style="padding-left:20px;"> 
			
						<?
						if(isset($_REQUEST['act'])) {

						?>
						<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
						<tr>
							<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3">View Rmuser Phone Log Details</span></td>
					    </tr>

						<tr>
						<td colspan="3" align="left" style="padding-bottom:5px;"><span class="normaltext3"><b>From Date:</b>&nbsp;<?=$fromdate?>&nbsp;&nbsp;&nbsp;<b>To Date:</b>&nbsp;<?=$todate?></span></td>
						</tr>

						<?=displayresult($rmuser, $rmuserphlogdetails,$tot,$pass);?>
						
						 <tr><td height="50">&nbsp;</td></tr>
						</table>
						<?

						} else {

						?>
						<form name="rmuserdetail" method="post" action="<?=$_SERVER['PHP_SELF']?>?act=view">
						<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
						<tr>
							<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3">View Rmuser Phone Log Details</span></td>
					    </tr>
						<tr>
								<td width="40%" align="left" class="tdleft"><span class="normaltext2">Select RMuser</span></td>
								<td width="60%" align="left" class="tdright"><select name="rmuser" id="rmuser" class="normaltext2" style="width:170px;">
								<option value="0">-Select-</option>
								<?=selectrmusers();?>
								</select></td>			
						</tr>
						<tr>
							<td width="40%" class="Rtdleft"><span class="normaltext2">Enter From Date</span></td>
							<td width="60%" class="Rtdright">
							<input class="textbox" name="fromdate" id="fromdate" style="width:140px;" readonly>&nbsp;
						    <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.rmuserdetail.fromdate);return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="calender/calbtn.gif" border="0" alt=""></a>						
							</td>			
						</tr>
						<tr>
							<td  class="Rtdleft"><span class="normaltext2">Enter To Date</span></td>
							<td class="Rtdright">
							<input class="textbox" name="todate" id="todate" style="width:140px;" readonly>&nbsp;
						    <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.rmuserdetail.todate);return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="calender/calbtn.gif" border="0" alt=""></a>							
							</td>			
						</tr>										
						

						<tr>
							<td colspan="2" align="center" style="height:30px;"><span class="normaltext2"><input type="submit" value="Submit" name="selectLog" class="SubmitButton"  onclick="return Validationphonelog();"></span></td>		
						</tr>
						<tr><td height="50">&nbsp;</td></tr>
						</table>
						</form>
						<?
						}
						?>
						
					  
			</td>
		</table>
	</td>
</tr>
<iframe width=199 height=178 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<?
$rmuserdb->dbClose();
include_once "include/rmfooter.php";
?>
</body>
</html>

<?
function selectrmusers() {
	global $rmuserdb, $Rmusers;	

	$Rmusers = $rmuserdb->SelectRmusers();

	if(is_array($Rmusers) && count($Rmusers) >0) {
		$selectbox = "<option value='all'>All</option>";
		foreach($Rmusers as $users=>$name) {

			$selectbox .= "<option value='".$users."'>".ucwords(strtolower($name))." [".$users."] </option>";
		}
		return $selectbox;
	}
}

function displayresult($rmuser, $rmuserphlogdetails,$tot, $pass) {
	global $page, $max_results;

	$html = "";

	if(is_array($rmuserphlogdetails) && count($rmuserphlogdetails) >0) {

		$html .=  '<tr>
					   <td align="left" class="tdleft"><span class="normaltext2"><b>Login By MatriId</b></span></td>
					   <td align="left" class="tdleft"><span class="normaltext2"><b>Viewed MatriId</b></span></td>
					   <td align="left" class="tdright"><span class="normaltext2"><b>Viewed Date</b></span></td>
				  </tr>';		
		foreach($rmuserphlogdetails as $rmuser=>$logarray) {
			$html .=  '<tr>
						 <td colspan="3" align="left" class="Rtdleft" style="border-right:1px solid #A196BF;" ><span class="normaltext2"><b>Rmuser:</b> '.strtoupper($rmuser).'</span></td>
					 </tr>';				
			foreach($logarray as $key=>$details) {				
				$html .=  '<tr>
							<td width="30%" align="left" class="Rtdleft"><span class="normaltext2">'.$details['loginmid'].'</span></td>
							<td width="30%" align="left" class="Rtdleft"><span class="normaltext2">'.$details['viewedmid'].'</span></td>
							<td width="40%" align="left" class="Rtdright"><span class="normaltext2">'.$details['date'].'</span></td>
						</tr>';			
			}
		}
		 $tot_result = ceil($tot / $max_results); 
		 if($tot_result >1){
			  $html .= pagination($pass,$tot_result,$page);
		}
	} else {
		$html =  '<tr>
				   <td colspan="3" align="left" class="tdleft" style="border-right:1px solid #A196BF;"><span class="normaltext2">No result found</span></td>
				 </tr>';
	}
	return $html;
}

function pagination($pass,$tot,$page) {

	$prev = $page-1;
	$next = $page+1;
	
	$html .= "<tr bgcolor='#ffffff'><td colspan=3 style='padding-top:10px;'><table width=300px cellspacing=0 cellpadding=2 border=0 align=center style='padding-top:2px; padding-bottom:2px;'><tr bgcolor='#ffffff'><td colspan=3 class='normaltext' style='text-align:center;'><b>Select page</b></td></tr><tr>";	
	if($page >1){
		$html .= "<td width=100px align=center><a href=".$_SERVER['PHP_SELF']."?page=1&act=view&value=".$pass." class='normallinkText'>First</a>&nbsp;&nbsp;<a href=".$_SERVER['PHP_SELF']."?page=".$prev."&act=view&value=".$pass." class='normallinkText'>Previous</a>&nbsp;&nbsp;</td>";
	}
	for($t=1;$t<=$tot;$t++) {
		if($t == $page) {
			$html .= "<td width=20px align=center><span class='normaltext2'><b>".$t."</b></span>&nbsp;&nbsp;&nbsp;<span  class='smalltxt'>|</span>&nbsp;&nbsp;&nbsp;</td>";
		} elseif(($t < ($page+5)) && ($t > ($page-5))) {
			$html .= "<td width=20px align=center><span class='smalltxt'><a href=".$_SERVER['PHP_SELF']."?page=".$t."&act=view&value=".$pass."  class='normallinkText'>".$t."</a>&nbsp;&nbsp;&nbsp;|</span>&nbsp;&nbsp;&nbsp;</td>";
		}
	}
	if($page <$tot){
		$html .= "<td width=100px align=center><a href=".$_SERVER['PHP_SELF']."?page=".$next."&act=view&value=".$pass." class='normallinkText'>Next</a>&nbsp;&nbsp;<a href=".$_SERVER['PHP_SELF']."?page=".$tot."&act=view&value=".$pass." class='normallinkText'>Last</a>&nbsp;</td>";
	}
	$html .= "</tr></table></td></tr>";
	return $html;
}
?>
