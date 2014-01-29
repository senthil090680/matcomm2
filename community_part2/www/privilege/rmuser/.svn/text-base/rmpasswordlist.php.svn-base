<?php
/****************************************************************************************************
File		: rmuseradminindex.php
Author	: Chitra.S
Date		: 06-Aug-2008
*****************************************************************************************************
Description	:
	This is Rmuser addition & segregation home page
********************************************************************************************************/

include_once "include/common_vars.php";
include_once "include/rmclass.php";
include_once "../config/config.cil14";

global $tbl;
$rmlogininfo = new srmclassname();
$rmlogininfo->srminit();
$rmlogininfo->srmConnect();

$start=$_REQUEST['start'];
if(!isset($start)) {                         // This variable is set to zero for the first page
$start = 0;
}

$eu = ($start - 0);
$limit = 20;                                 // No of records to be shown per page.
$this1 = $eu + $limit;
$back = $eu - $limit;
$next = $eu + $limit;

if($_REQUEST['rmuser']=="All") {

	/*$count = "select RMUserid,Name,Password from ".$tbl['RMLOGININFO']." order by RMUserid ASC";
	$nume=$rmlogininfo->select($count);// print_r($rmlogininfo);
	$selectrec = "select RMUserid,Name,Password from ".$tbl['RMLOGININFO']." limit $eu,$limit";
	$rmlogininfo->select($selectrec);//print_r($rmlogininfo);*/

	$varActFields	= array("RMUserid","Name","Password");
	$varActCondtn	= " order by RMUserid ASC";
	$numeCnt		= $rmlogininfo->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
    $nume=count($numeCnt);

	$varActFields	= array("RMUserid","Name","Password");
	$varActCondtn	= " limit $eu,$limit";
	$rows		= $rmlogininfo->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,0);




} else {
   /*$count = "select RMUserid,Name,Password from ".$tbl['RMLOGININFO']." where RMUserid='".$_REQUEST['rmuser']."' order by RMUserid ASC";
   $nume=$rmlogininfo->select($count);// print_r($rmlogininfo);
   $selectrec = "select RMUserid,Name,Password from ".$tbl['RMLOGININFO']." where RMUserid='".$_REQUEST['rmuser']."' limit $eu,$limit";
   $rmlogininfo->select($selectrec);//print_r($rmlogininfo);*/

   $varActFields	= array("RMUserid","Name","Password");
   $varActCondtn	= " where RMUserid='".$_REQUEST['rmuser']."' order by RMUserid ASC";
   $numeCnt		= $rmlogininfo->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
   $nume=count($numeCnt);

   $varActFields	= array("RMUserid","Name","Password");
   $varActCondtn	= " where RMUserid='".$_REQUEST['rmuser']."' limit $eu,$limit";
   $rows		= $rmlogininfo->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,0);





}
?>

		<?
			if($nume>20) {
				if($back >=0) {
					print "<a href='#'  onclick=\"return paging_ajax('passwordlist','".$_REQUEST['rmuser']."','".$back."')\"><font face='Verdana' size='2'>PREV</font></a>";
				}
				$i=0;
				$l=1;
				for($i=0;$i < $nume;$i=$i+$limit){
					if($i <> $eu){
						echo " <a href='#'  onclick=\"return paging_ajax('passwordlist','".$_REQUEST['rmuser']."','".$i."')\"><font face='Verdana' size='2'>$l</font></a> ";
					}else { echo "<font face='Verdana' size='4' color=red>".$l."</font>";}
							$l=$l+1;
					}
					if($this1 < $nume) {
						print "<a href='#' onclick=\"return paging_ajax('passwordlist','".$_REQUEST['rmuser']."','".$next."')\"><font face='Verdana' size='2'>NEXT</font></a>";}
				}
		?>
		<br><br>
<table border="0" align="left" cellpadding="0" cellspacing="0"  width="500"  style="border-top:solid 1px #A196BF;">

	<tr><td class="Rtdleft Rtdright" colspan="3"><span class="normaltext3"><b>RM Password List</b></span></td></tr>

	<tr>
		<td width="80" class="Rtdleft"><span class="normaltext2"><b>Rmuser Id</b></span></td>
		<td width="200" class="Rtdleft"><span class="normaltext2"><b>Name</b></span></td>
		<td width="80" class="Rtdright"><b>Password</b></td>
	</tr>
	<?	while($rec = mysql_fetch_assoc($rows)){?>
	<tr>
	    <td width="80" class="Rtdleft"><span class="normaltext2"><?echo strtoupper($rec['RMUserid']);?></span></td>
		<td width="200" class="Rtdleft"><span class="normaltext2"><?=strtotitle($rec['Name']);?></span></td>
		<td width="80" class="Rtdright"><span class="normaltext2"><?=$rec['Password'];?></span></td>
	 </tr>
	<?}?>

	<tr>
	<td colspan="3">
		<?
			if($nume>20) {
				if($back >=0) {
					print "<a href='$page_name?start=$back&rmuser=".$_REQUEST['rmuser']."'><font face='Verdana' size='2'>PREV</font></a>";
				}
				$i=0;
				$l=1;
				for($i=0;$i < $nume;$i=$i+$limit){
					if($i <> $eu){
						echo " <a href='$page_name?start=$i&rmuser=".$_REQUEST['rmuser']."'><font face='Verdana' size='2'>$l</font></a> ";
					}else { echo "<font face='Verdana' size='4' color=red>".$l."</font>";}
							$l=$l+1;
					}
					if($this1 < $nume) {
						print "<a href='#' onclick=\"return paging_ajax('passwordlist','".$_REQUEST['rmuser']."','".$next."')\"><font face='Verdana' size='2'>NEXT</font></a>";}
				}
		?>
		</td>
		</tr>
</table>