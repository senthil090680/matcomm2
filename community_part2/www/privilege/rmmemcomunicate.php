<?
include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();
$rmclass->rmConnect();
include_once "include/rmuserheader.php";

if($_REQUEST['MEMID_RMINTER']!= ''){ 
	$varActCondtn	= " where RMUserid=".$rmclass->slave->doEscapeString($_COOKIE['rmusername'],$rmclass->slave)." and MatriId=".$rmclass->slave->doEscapeString($_REQUEST['MEMID_RMINTER'],$rmclass->slave)." order By TimeCreated DESC";
	$cntrow		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMAIL'],$varActCondtn,0);
   
}
?>

	<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<td width="100%" style="padding-left:20px;"> 
				<table border="0" cellpadding="0" cellspacing="0" width="97%">
						<tr><td colspan="4" height="20"></td></tr>
						<tr>
							   <td align="left" height="30" colspan="4"><span class="normtxt1 bld">Here is a summary of the mails you've sent <?=$msgname?></span></td>
					    </tr>
						<tr><td colspan="4" height="10"></td></tr>
						<tr><td colspan="5" height="1" bgcolor="#cbcbcb"></td></tr>
						<tr>
								<!-- <td width="80" class="tdleft"><span class="normtxt">RMID</span></td> -->
								<td width="30%" height="25" style="border-left:1px solid #cbcbcb;border-right:1px solid #cbcbcb;padding-left:10px;"><span class="normtxt bld">To Id</span></td>
								<td width="15%" style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class="normtxt bld">Subject</span></td>
								<td width="20%" style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class="normtxt bld">Message</span></td>
								<td width="15%" style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class="normtxt bld">Attach File</span></td>
								<td width="20%" style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class="normtxt bld">Date Sent</span></td>
						</tr>
						<tr><td colspan="5" height="1" bgcolor="#cbcbcb"></td></tr>
						<?
							if(empty($cntrow)){
						?>
							 <tr align="center">
								<td width='230' colspan="5" class="brdr" style="padding:10px;"><span class='normtxt'>No Communication</span></td>
							</tr>				  
						<?
						} else {
							while($rows = mysql_fetch_assoc($cntrow)){
							                          
								if($rows['AttachFile'] == ''){
									$values = '-';
								}else {
									$values = "<a class='clr1' href='http://img.communitymatrimony.com/privilege/uploads/".$rows['AttachFile']."' target='_BLANK'>".$rows['AttachFile']."</a>";
								}
							 
						?>
						 <tr>
								<!-- <td width='100' ><span class='normtxt'><?=strtoupper($rows['RMUserid']);?></span></td> -->
								<td height="25" style="border-left:1px solid #cbcbcb;border-right:1px solid #cbcbcb;padding-left:10px;" ><span class='normtxt'><?=$rows['ToId'];?></span></td>
								<td style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class='normtxt'><?if($rows['Subject']!=""){echo $rows['Subject'];}else{echo "&nbsp;";}?></span></td>
								<td style="border-right:1px solid #cbcbcb;padding-left:10px;">
								 <span class='normtxt'>
								<?if($rows['Message']!=""){echo substr($rows['Message'],0,20)."...";}else{echo "&nbsp;";}?>
								</SPAN>
								<?$id=$rows['id'];?>
								<a href="#" onClick="myPopup2('<?echo "rmshowmsg.php?id=".$rows['id'];?>')"  class='normtxt1 clr1'>More</a></td>
								<td style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class='normtxt'><?=$values;?></a></td>
								<td style="border-right:1px solid #cbcbcb;padding-left:10px;"><span class='normtxt'><?=$rows['TimeCreated']?></span></td>
								</tr><tr><td colspan="5" height="1" bgcolor="#cbcbcb"></td></tr> 
						<?
							}
						}?>

					   <tr><td height="20">&nbsp;</td></tr>
				</table>	
			</td>
		</table>
	</td>
</tr>
	<?
$rmclass->CloseDB();
?>
</body>
</html>
<script type="text/javascript">
function myPopup2(urlpath) {
	window.open(urlpath,"myWindow","status = 1,scrollbars=1,height = 430,width = 500,resizable = 0" )
}
</script>

	
