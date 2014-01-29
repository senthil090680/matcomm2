<html>
<head><link rel="stylesheet" href="include/rmstyles.css"></head>
<?
include_once "include/rmclass.php";

if($_REQUEST['id']!= ''){
	$rmclass=new rmclassname();
	$rmclass->init();
	$rmclass->rmConnect();
	$varActCondtn	= " where id=".$_REQUEST['id']."";
	$cntrow		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMAIL'],$varActCondtn,0);
	
}	

 ?>
  <body><table border="0" cellpadding="0" cellspacing="0" width="100%"> 
	<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<!-- <td width="200"  style="border-right:solid 1px #9BD6E5"><? include_once "../template/ansadminleft.php"; ?></td> -->
			<td width="100%" style="padding-left:5px;padding-right:5px;"> 
				<table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;padding:5px 5px 5px 5px;">
						<tr>
							   <td valign="top" align="left" height="30" colspan="4"><span class="normaltext3">Sent Mail to Member</span></td>
					    </tr>
						 <tr>
								<td>&nbsp;</td>
						 </tr>
						  <?
							while($rows = mysql_fetch_assoc($cntrow)){
								if($rows['AttachFile'] == ''){
									$values = '-';
								}else {
									$values = "<a href='http://img.communitymatrimony.com/privilege/uploads/".$rows['AttachFile']."' target='_BLANK'>".$rows['AttachFile']."</a>";
								} 
							?>
						 <tr>
								<td width="150"><span class="normaltext2">RMID</span></td>
								<td width="10">:</td>
								<td width="300"><span class="normaltext2"><?=strtoupper($rows['RMUserid']);?></span></td>
						 </tr>
						 <tr>
								<td width="150"><span class="normaltext2">ToId</span></td>
								<td width="10">:</td>
								<td width="300"><span class="normaltext2"><?=$rows['ToId'];?></span></td>
						 </tr>
						 <tr>
								<td width="150"><span class="normaltext2">Subject</span></td>
								<td width="10">:</td>
								<td width="300" class="normaltext2"><?echo wordwrap($rows['Subject'], 30, "<br />\n");?></td>
						 </tr>
						 <tr>
								<td width="150"><span class="normaltext2">Message</span></td>
								<td width="10">:</td>
								<td width="300" class="normaltext2"><?echo wordwrap($rows['Message'], 30, "<br />\n");?></td>
						 </tr>
						 <tr>
								<td width="150"><span class="normaltext2">Attach File</span></td>
								<td width="10">:</td>
								<td width="300"><span class="normaltext2"><?echo $values;?></span></td>
						 </tr>
						   <tr>
								<td width="150"><span class="normaltext2">Date Sent</span></td>
								<td width="10">:</td>
								<td width="300"><span class="normaltext2"><?echo $rows['TimeCreated'];?></span></td>
						 </tr>
						 
						 <?}?>
						 
					</table>	
			</td>
		</table>
	</td>
</tr>
<tr>
	   <td>&nbsp;</td>
</tr>
<tr>
	  <td  align="center"><input type="button" name="Close" value="Close" onclick="javascript:window.close();"></td>
</tr>
</table>
	<?
$rmclass->CloseDB();
?>
</body>
</html>


	
