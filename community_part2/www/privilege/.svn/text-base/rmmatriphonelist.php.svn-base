<?php
include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
include_once "include/rmuserheader.php";
if($_COOKIE['rmusername']==""){ 
	header("location:http://www.communitymatrimony.com/privilege/mainindex.php");
}
function getPhonenumber($matriid,$phonenotable,$conn,$check){
		global $tbl; 
		$varActCondtn	= " where MatriId='".$matriid."'";
	    $row		    = $conn->selectAll($phonenotable,$varActCondtn,1);
		
 			if($check ==1){
				   $getval  = $row['PhoneNo1'];
 			}
			else if($check ==2){
				if($row['MobileNo'] == '')
					$getval  = $row['CountryCode']."/".$row['AreaCode']."/".$row['PhoneNo'];
				else 
					 $getval  = $row['MobileNo'];
 			}
		
		return $getval;

	}

if(isset($_POST['submit'])){
   $phonedet = 0;
   $matriid=$_POST['matriid'];
   $senderprofiletable=$varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];

   $contact=$rmclass->ContactInfobkup($matriid,$senderprofiletable,$rmclass->slave);
    if($contact != 0){
		$val =1;
 		$tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'];

		$getval = getPhonenumber($matriid,$tblname,$rmclass->slave,$val);
		$phonedet = 1;
   }
   else if ($contact == 0){
	   $val =2;
	   $tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACTBEFOREVALIDATION'];

 	   $db5 = $slaveconn;
	   $getval = getPhonenumber($matriid,$tblname,$rmclass->slave,$val);
	   $phonedet = 1;
   }
   else {
		 $phonedet = 1;
   }

} 
if ($phonedet == 1){
	$today = date("Y-m-d");  
	
    $varActCondtn	= " where RmUserId='".$_COOKIE['rmusername']."' and MatriId='".$rows[0]['MatriId']."' and OppositeMatriId='".$matriid."' and date(DateViewed)='".$today."'";
    $numrows		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMVIEWPHONELOG'],$varActCondtn,1);

	if(empty($numrows)){
		$varInsertFields	= array("RMUserid","MatriId","OppositeMatriId","DateViewed");
	    $varInsertVal	= array("'".$_COOKIE['rmusername']."'","'".$rows[0]['MatriId']."'","'".$matriid."'",'NOW()');
	    $insertedid = $rmclass->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMVIEWPHONELOG'], $varInsertFields, $varInsertVal);
	}  
 		echo '<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0" width="400">
					<tr>
					<td width="100%" style="padding-left:20px;">
						<form name="viewprofile" method="post">
							<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										   <td valign="top" align="left" height="30" colspan="4"><span class="normtxt1">View Phone Number By Id</span></td>	  
									</tr>

									<tr>
											<td width="220" class="tdleft"><span class="normtxt">'.$matriid.' </span></td>
											<td width="400" class="tdright"><span class="normtxt">'.str_replace("~","-",$getval).' </span>
										 
											<span id="errmatriid"></span>
											 
											</td>
									</tr>
									<tr><td height="50">&nbsp;</td></tr>
							</table>
						</form>
					</td>
				</table>
			</td>
		</tr>';
 
}
if(!isset($_POST['submit'])){
?>
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr><td height="20"></td></tr>
			<tr>
			<td width="100%" style="padding-left:20px;">
				<form name="viewprofile" method="post">
					<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								   <td valign="top" align="left" height="30" colspan="4"><span class="normtxt1 bld">View Phone Number By Id</span></td>	 <input type="hidden" name="memid" value="<?=$_REQUEST['MEMID'];?>">
							</tr>

							<tr>
									<td width="220" class="tdleft"><span class="normtxt">Matrimony Id </span></td>
									<td width="400" class="tdright">
									<input type="text" name="matriid" value="">&nbsp;&nbsp;
									<span id="errmatriid"></span>
									<input type="submit" name="submit" value="View Phone Number" class="button" onclick="return rmvalidation();">
									</td>
							</tr>
							<tr><td height="20">&nbsp;</td></tr>
					</table>
				</form>
			</td>
		</table>
	</td>
</tr>
<? } ?>
</body>
</html>
<script language="javascript">
	function rmvalidation(){
		if(document.viewprofile.matriid.value==""){
			  alert("Fill the MatriId");
			  return false;
		}
	}	
</script>
	
