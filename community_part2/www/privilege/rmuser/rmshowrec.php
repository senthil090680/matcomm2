<?php
/****************************************************************************************************
File		: rmuseradminindex.php
Author	: Chitra.S
Date		: 06-Aug-2008
*****************************************************************************************************
Description	: 
	This is Rmuser addition & segregation home page
********************************************************************************************************/

// Includes header information
include_once "include/rmuserheader.php";
include_once "include/common_vars.php";
include_once "include/rmclass.php";

$rmlogininfo = new srmclassname();
$rmlogininfo->srminit();
$rmlogininfo->srmConnect();
$page_name="rmshowrec.php";
$start=$_REQUEST['start'];
if(!isset($start)) {                         // This variable is set to zero for the first page
$start = 0;
}

$eu = ($start - 0); 
$limit = 20;                                 // No of records to be shown per page.
$this1 = $eu + $limit; 
$back = $eu - $limit; 
$next = $eu + $limit; 

//$count = "select MatriId,PrivStatus from rminterface.rmmemberinfo Where RMUserid !='rmuser1'";
//$nume=$rmlogininfo->select($count);// print_r($rmlogininfo);

$varActFields	= array("MatriId","PrivStatus");
$varActCondtn	= " Where RMUserid !='rmuser1' order by TimeCreated asc";
$cnt		= $rmlogininfo->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
$nume=count($cnt);


/**$selectrec = "select MatriId,PrivStatus from rminterface.rmmemberinfo Where RMUserid !='rmuser1' limit $eu,$limit";
$rmlogininfo->select($selectrec);//print_r($rmlogininfo);*/

$varActFields	= array("MatriId","PrivStatus");
$varActCondtn	= " Where RMUserid !='rmuser1' order by TimeCreated asc limit $eu,$limit ";
$rows		= $rmlogininfo->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,0);

?>
<tr>
	<td>
<table border="0" align="center" width="400" id='rmaccessarea1' style="display:none" >
 <tr >
		<td ><span  class="normaltext3" id='rmaccessarea2'></span></td>
	</tr> 
	<tr height="40" >
		<td ><span  class="errortext4" id='rmaccessarea'></span></td>
	</tr>
	
</table><BR><BR>

<table border="0" align="center" cellpadding="0" cellspacing="0"  width="400"  id='allvalue' style="border-top:solid 1px #A196BF;">
	<tr><td class="Rtdleft Rtdright" colspan="3"><span class="normaltext3"><b>Conversion</b></span></td></tr>
	<tr>
		<td width="80" class="Rtdleft"><span class="normaltext2"><b>MatriId</b></span></td>
		<td width="80" class="Rtdright"><b>Convert</b></td>			
	</tr>
	<?
		while($rec = mysql_fetch_assoc($rows)){
		
			$matriid = $rec['MatriId'];
			$access  = $rec['PrivStatus'];
	    		if($access == 1){
					$msg = "Partial"; $value =1;
				}else if($access == 2){
					$msg = "Full";$value =2;
				}

 
?>
<script language="javascript" src="http://www.communitymatrimony.com/privilege/rmuser/include/rmupdateaccess.js"></script> 
 <tr>
   <td width="80" class="Rtdleft"><span class="normaltext2"><?=$matriid?></span></td>
   <td width="80" class="Rtdright"><a href='#' onclick="return UpdateAccess('http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmupdates.php?access=<?=$value?>&matriid=<?=$matriid?>','<?=$matriid?>');" class='normaltext2'><?=$msg?></a></td>			
 </tr>
 
<?}?> 
<tr>
	<td colspan="3">
		<?
			if($nume>20) {
				if($back >=0) { 
					print "<a href='$page_name?start=$back'><font face='Verdana' size='2'>PREV</font></a>"; 
				} 
				$i=0;
				$l=1;
				for($i=0;$i < $nume;$i=$i+$limit){
					if($i <> $eu){
						echo " <a href='$page_name?start=$i'><font face='Verdana' size='2'>$l</font></a> ";
					}else { echo "<font face='Verdana' size='4' color=red>".$l."</font>";}       
							$l=$l+1;
					}
					if($this1 < $nume) { 
						print "<a href='$page_name?start=$next'><font face='Verdana' size='2'>NEXT</font></a>";} 
					}
		?>
		</td>									
		</tr>
</table></td></tr></table><? include_once "include/rmfooter.php"; ?>