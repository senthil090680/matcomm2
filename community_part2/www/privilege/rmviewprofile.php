<?php

$varMatriId	= $_REQUEST['matriid'];
$memid		= $_REQUEST['MEMID'] ? $_REQUEST['MEMID'] : $_REQUEST['memid'];
$varPrint	= $_REQUEST['print'];
if($_COOKIE['rmusername']==""){ 
	header("location:http://www.communitymatrimony.com/privilege/mainindex.php");
}
if($varMatriId !="" && $memid!="" ){
	$varMatriIdPrefix	= substr($varMatriId,0,3);
	$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];
?>
<script>
var matriId   = '<? echo $varMatriId;?>';
var MEMID = '<? echo $memid;?>';
var domain = '<? echo $varDomainName;?>';
var print = '<? echo $varPrint?>';
var concat = '&print='+print;
var MEMID_RMINTER = '<? echo $_REQUEST["MEMID_RMINTER"];?>';

document.location.href='http://www.'+domain+'/privilege/mainindex.php?act=rmviewprofilebyid&matriid='+matriId+'&MEMID='+MEMID+'&p=1'+concat+'&MEMID_RMINTER='+MEMID_RMINTER;
</script>

<?  exit; } $memid = $memid ? $memid : 'rmi';  ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr><td height="20"></td></tr>
			<tr>
			<td width="100%" style="padding-left:20px;">
				<form name="viewprofile" method="post">
					<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								   <td valign="top" align="left" height="30" colspan="4"><span class="normtxt1 bld">View Profile By Id</span></td><input type="hidden" name="memid" value="<?=$memid;?>">
							</tr>
							<tr>
									<td width="220"><span class="normtxt">Matrimony Id </span></td>
									<td width="400">
									<input type="text" name="matriid" value="">&nbsp;&nbsp;
									<span id="errmatriid"></span>
									<input type="submit" name="submit" value="View Profile" class="button" onclick="return rmvalidation();">
									</td>
							</tr>
							<tr><td height="20">&nbsp;</td></tr>
					</table>
				</form>
			</td>
		</table>
<script language="javascript">
	function rmvalidation(){
		if(document.viewprofile.matriid.value==""){
			  alert("Fill the MatriId");
			  return false;
		}
	}	
</script>