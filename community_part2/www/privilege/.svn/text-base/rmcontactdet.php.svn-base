<?
include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();
$rmclass->rmConnect();
include_once "include/rmuserheader.php";
if($_COOKIE['rmusername']==""){ 
	header("location:http://www.communitymatrimony.com/privilege/mainindex.php");
}		
global $RELATIONSHIP,$COOKIEINFO,$TABLE,$varCbsRminterfaceDbInfo;

if($_REQUEST['MEMID_RMINTER']!= ''){
		$firstname=$rows[0]['Name'];
		$rmclass=new rmclassname();
		$rmclass->init();
		$rmclass->rmConnect();
		
		$varActCondtn	= " where MatriId=".$rmclass->slave->doEscapeString($_REQUEST['MEMID_RMINTER'],$rmclass->slave);
		$rows		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMATRIUSERCONTACT'],$varActCondtn,1);

		if(empty($rows)){
			
			$varActCondtn	= " where MatriId=".$rmclass->slave->doEscapeString($_REQUEST['MEMID_RMINTER'],$rmclass->slave);
		    $rows		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'],$varActCondtn,1);
            
			$phone=str_replace("~","-",$rows['PhoneNo1']);
			$phones=str_replace("~","-",$rows['PhoneNo1']);
			$email=$rows['Email'];
		}else{
		   
			//$rows = $rmclass->fetchArray();
			
			$firstname=$rows['Firstname'];
			$lastname=$rows['Lastname'];
			$phone=$rows['Phone'];
			$phones=$rows['Phone'];
			$mobile=$rows['Mobile'];
			$address=$rows['Address'];
			$city=$rows['City'];
			$state=$rows['State'];
			$zipcode=$rows['Zipcode'];
			$notes=$rows['Notes'];
			$email=$rows['Email'];
		}

		$rmclass->RMUserlog($_COOKIE['rmusername'],$_REQUEST['MEMID_RMINTER'],'3');
		//$row = $rmclass->fetchArray();
}

if(isset($_POST['submit'])){
	
	$firstname=trim($_POST['fname']);
	$lastname=trim($_POST['lname']);
	$phone=trim($_POST['phone']);
	$phones=trim($_POST['phone']);
	$mobile=trim($_POST['mobile']);
	$address=trim($_POST['address']);
	$city=trim($_POST['city']);
	$state=trim($_POST['state']);
	$zipcode=trim($_POST['zipcode']);
	$notes=trim($_POST['notes']);
	$email=trim($_POST['email']);
	$rmuserid=trim($_POST['rmuserid']);
	$matriid=trim($_POST['matriid']);

	$varActCondtn	= " where MatriId=".$rmclass->slave->doEscapeString($_REQUEST['MEMID_RMINTER'],$rmclass->slave);
	$rows		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMATRIUSERCONTACT'],$varActCondtn,1);

	
	if(empty($rows)){

		 $varInsertFields	= array("RMUserid","MatriId","Firstname","Lastname","Email","Phone","Mobile","Address","City","State","Zipcode","Notes","TimeCreated");
	     $varInsertVal	= array($rmclass->master->doEscapeString($rmuserid,$rmclass->master),$rmclass->master->doEscapeString($matriid,$rmclass->master),$rmclass->master->doEscapeString($firstname,$rmclass->master),$rmclass->master->doEscapeString($lastname,$rmclass->master),$rmclass->master->doEscapeString($email,$rmclass->master),$rmclass->master->doEscapeString($phone,$rmclass->master),$rmclass->master->doEscapeString($mobile,$rmclass->master),$rmclass->master->doEscapeString($address,$rmclass->master),$rmclass->master->doEscapeString($city,$rmclass->master),$rmclass->master->doEscapeString($state,$rmclass->master),$rmclass->master->doEscapeString($zipcode,$rmclass->master),$rmclass->master->doEscapeString($notes,$rmclass->master),'NOW()');
	     $insertedid = $rmclass->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMATRIUSERCONTACT'], $varInsertFields, $varInsertVal);


		 $msg="Contact Information Updated";
	}else{

		 $varUpdateFields	= array("Firstname","Lastname","Email","Phone","Mobile","Address","City","State","Zipcode","Notes");
		 $varUpdateVal	= array($rmclass->master->doEscapeString($firstname,$rmclass->master),$rmclass->master->doEscapeString($lastname,$rmclass->master),$rmclass->master->doEscapeString($email,$rmclass->master),$rmclass->master->doEscapeString($phone,$rmclass->master),$rmclass->master->doEscapeString($mobile,$rmclass->master),$rmclass->master->doEscapeString($address,$rmclass->master),$rmclass->master->doEscapeString($city,$rmclass->master),$rmclass->master->doEscapeString($state,$rmclass->master),$rmclass->master->doEscapeString($zipcode,$rmclass->master),$rmclass->master->doEscapeString($notes,$rmclass->master));
	     $varUpdateCondtn	= " MatriId=".$rmclass->master->doEscapeString($matriid,$rmclass->master);
	     $updateid = $rmclass->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMATRIUSERCONTACT'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
		 $msg="Contact Information Updated";
	}
}


 ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td width="100%" style="padding-left:20px;">
		<table border="0" cellpadding="0" cellspacing="0" >
		<tr><td colspan="4" height="20"></td></tr>
				<tr>
					   <td align="left" height="30" colspan="4"><span class="normtxt1 bld">Here are the contact details of  <?=$msgname?></span></td>
				</tr>
				<tr>
					   <td align="left" height="25" colspan="4"><span class="normtxt">If you would like to make changes to the information, please make the changes in the relevant fields and save.</span></td>
				</tr>
				<tr><td colspan="4" height="15"></td></tr>
				<tr>
					  <td>	<form name="contactdet" method="post">
								<table border="0" cellpadding="2" cellspacing="0">
									<?if($msg!=""){?>
									  <tr>
											 <td colspan="3" align="center"  height="35" class="alerttxt"><?=$msg;?></td>
									  </tr>
									<?}?>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">First Name</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="fname" value="<?=$firstname;?>" maxlength="30">
										  <input type="hidden" name="matriid" value="<?=$_REQUEST['MEMID_RMINTER']?>">			 <input type="hidden" name="rmuserid" value="<?=$_COOKIE['rmusername'];?>">							 
										  </td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">Last Name</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="lname" value="<?=$lastname;?>" maxlength="30"></td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">Phone</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="phone" value="<?=$phones;?>" ></td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">Mobile</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="mobile" value="<?=$mobile;?>" ></td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">E-Mail</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="email" value="<?=$email;?>" ></td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">Address</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="address" value="<?=$address;?>" maxlength="60"></td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">City</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="city" value="<?=$city;?>" maxlength="30"></td>
									</tr>
									<tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">State</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="state" value="<?=$state;?>" maxlength="30"></td>
									</tr>
									 <tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">Zip Code</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><input type="text" name="zipcode" value="<?=$zipcode;?>" maxlength="10"></td>
									</tr>
									 <tr>
										  <td valign="top" align="right" width="150"><span class="normtxt">Notes</span></td>
										  <td valign="top" align="left" width="10"><span class="normtxt">:</span></td>
										  <td valign="top" align="left" width="150"><textarea name="notes" value="" class="normtxt" rows="5" cols="40" ><?=$notes;?></textarea></td>
									</tr>
									 <tr>
										 <td colspan="2"></td><td align="left">
												<input type="submit" name="submit" value="Save" class="button">
										 </td>
									</tr>
									
								</table></form>
					  </td>
				</tr>
			   <tr><td height="50">&nbsp;</td></tr>
		</table>	
	</td>
</table>