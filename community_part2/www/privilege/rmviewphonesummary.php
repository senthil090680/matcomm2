<?
include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
include "include/rmuserheader.php";


$partial='show';

$page_name="rmviewphonesummary.php"; //  If you use this code with a different page ( or file ) name then change this 
$start=$_REQUEST['start'];
if(!isset($start)) {                         // This variable is set to zero for the first page
$start = 0;
}

$eu = ($start - 0); 
$limit = 20;                                 // No of records to be shown per page.
$this1 = $eu + $limit; 
$back = $eu - $limit; 
$next = $eu + $limit; 


$varActFields	= array("OppositeMatriId","RmUserId","MatriId","DateViewed");
$varActCondtn	= " where MatriId=".$rmclass->slave->doEscapeString($_REQUEST['MEMID_RMINTER'],$rmclass->slave)." and RmUserId=".$rmclass->slave->doEscapeString($_COOKIE['rmusername'],$rmclass->slave)." and date(DateViewed)>=".$rmclass->slave->doEscapeString($_REQUEST['from'],$rmclass->slave)." and date(DateViewed)<=".$rmclass->slave->doEscapeString($_REQUEST['to'],$rmclass->slave);
$numrows		= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMVIEWPHONELOG'],$varActFields,$varActCondtn,1);
$nume=count($numrows);


$varActFields	= array("OppositeMatriId","RmUserId","MatriId","DateViewed");
$varActCondtn	= " where MatriId=".$rmclass->slave->doEscapeString($_REQUEST['MEMID_RMINTER'],$rmclass->slave)." and RmUserId=".$rmclass->slave->doEscapeString($_COOKIE['rmusername'],$rmclass->slave)." and date(DateViewed)>=".$rmclass->slave->doEscapeString($_REQUEST['from'],$rmclass->slave)." and date(DateViewed)<=".$rmclass->slave->doEscapeString($_REQUEST['to'],$rmclass->slave)." order by DateViewed DESC limit $eu,$limit";
$numrows		= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMVIEWPHONELOG'],$varActFields,$varActCondtn,0);

	
?>
<script language="javascript"  src="include/CalendarPopup.js"></script>
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<td width="100%" style="padding-left:20px;">
				<form name="viewprofile" method="post">
					<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								   <td valign="top" align="left" height="30" colspan="3">
								   <span class="normaltext3">Phone Log Summary</span></td>	 
								   <input type="hidden" name="memid" value="<?echo $_REQUEST['MEMID_RMINTER'];?>">
							</tr>
							<?if(!empty($nume)){?>
							<tr>
								<!-- <td width="80" class="tdleft"><span class="normaltext2">RMID</span></td> -->
								<td width="100" class="tdleft"><span class="normaltext2"><b>Matrimony Id</b></span></td>
								<td width="200" class="tdright"><span class="normaltext2"><b>Date Viewed</b></span></td>
								
							</tr>
							<?
							
							while($phonelog = mysql_fetch_assoc($numrows)) {
								//print_r($phonelog);exit;
								?>
							<tr>
								  <td width="100" class="Rtdleft"><span class="normaltext2"><?echo strtotitle($phonelog['OppositeMatriId']);?></span></td>
									<td width="200" class="Rtdright"><span class="normaltext2"><?echo $phonelog['DateViewed'];?></span></td>
								   <td></td>
							</tr>
							<?}} else {?>
							 <tr>
								<td width="300" colspan="2" height="100"><span class="errortext4">No Record Found</span></td>
							</tr>
							<?}?>
							<tr>
									<td colspan="3">
											<?
											if($nume>20) {
												if($back >=0) { 
													print "<a href='$page_name?start=$back&from=".$_REQUEST['from']."&to=".$_REQUEST['to']."&MEMID_RMINTER=".$_REQUEST['MEMID_RMINTER']."'><font face='Verdana' size='2'>PREV</font></a>"; 
												} 
											
												$i=0;
												$l=1;
												for($i=0;$i < $nume;$i=$i+$limit){
													if($i <> $eu){
														echo " <a href='$page_name?start=$i&from=".$_REQUEST['from']."&to=".$_REQUEST['to']."&MEMID_RMINTER=".$_REQUEST['MEMID_RMINTER']."'><font face='Verdana' size='2'>$l</font></a> ";
													}
													else { echo "<font face='Verdana' size='4' color=red>".$l."</font>";}       
													$l=$l+1;
												}

												if($this1 < $nume) { 
													print "<a href='$page_name?start=$next&from=".$_REQUEST['from']."&to=".$_REQUEST['to']."&MEMID_RMINTER=".$_REQUEST['MEMID_RMINTER']."'><font face='Verdana' size='2'>NEXT</font></a>";} 
											}
											?>
									</td>									
							</tr>
							<tr>
								   <td height="100">&nbsp;</td>
							</tr>
					</table>
				</form>
			</td>
		</table>
	</td>
</tr>
<?
	//include_once "include/rmfooter.php"; 
?>
</body>
</html>

	
