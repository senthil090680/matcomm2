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
$conn = $rmlogininfo->getDebugParam();

$debug_it['err'] .= $debug_it['br'] .$conn['host']['S'];

$action = $_REQUEST['action'];

// Pagination details of members display
if(!isset($_GET['page'])) {
	$page = 1;
} else {
	$page = $_GET['page'];
	$act = $_GET['act'];
}
$max_results = 10;
$from = (($page * $max_results) - $max_results);


// rminterface db connection
/*$rmlogininfo = new srmclassname();
$rmlogininfo->srminit();
$rmlogininfo->srmConnect();*/


if(isset($_REQUEST['Submit'])) {

	if($_REQUEST['perform'] == "edit") { // perform the edit action
		
		$email=$rmlogininfo->CheckEmail($_POST['email'],trim($_REQUEST['userid']));
		if($email==0){
			$officialid = checkofficialid($_POST['email']);
			if($officialid == "Y") {
				 update_rmlogininfo();
				 $act = "Given users has been updated successfully";
				 $action = "view";
			} else {
				$msg="The e-mail id should be bharatmatrimony or consim id";				
				$title = "Edit";
				$action = "edit";
			}
		} else{
			$msg="This e-mail id already exist!";
			$title = "Edit";
			$action = "edit";
		}
	} else { // perform the add action
		$email=$rmlogininfo->CheckEmail($_POST['email']);
		
		if($email==0){
			$officialid = checkofficialid($_POST['email']);
			if($officialid == "Y") {
				 insert_rmlogininfo();
				 $act = "Given users has been added successfully";
				 $action = "view";
			} else {
					$msg="The e-mail id should be bharatmatrimony or consim id";
					
			}
		} else{
			    $msg="This e-mail id already exist!";				
		}
	}
} elseif($_REQUEST['act'] == "delete") {// perform the delete action

	$rmlogininfo->deleteuser($_REQUEST['id']);
	$act = "The user has been deleted successfully";

} elseif($_REQUEST['action'] == "edit") {// perform the edit action
	$editmemberdet = $rmlogininfo->selectRmuserdetail($_REQUEST['userid']);
	$title = "Edit";	
}

?>
<script language="javascript" src="js/common_validation.js"></script>
<script language="javascript" src="js/rmuseraddition.js"></script>

<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<!-- <td width="200"  style="border-right:solid 1px #9BD6E5"><? include_once "../template/ansadminleft.php"; ?></td> -->
			<td width="100%" style="padding-left:20px;padding-top:5px;"> 
			

				<?
				if($action == "view") { // display the rmuser details
						
				?>
				<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
				<?
				 if($act != "") {
				?>
					<tr>
						<td valign="middle" align="center" height="30" colspan="4" style="padding-top:5px;"><span class="normaltext3"><?=$act?></span></td>
					 </tr>
					   
				<?
				} 
				echo Allmemberslist();
				?>
						
					 <tr><td height="50">&nbsp;</td></tr>
					</table>
				<?
				 } else { // display edit or add form
					 if($action == "edit") {
				?>
					  <form name="rmuseraddition" method="post" action="rmuseraddition.php?perform=edit">
						 <? } else {?>
						 
						<form name="rmuseraddition" method="post" action="rmuseraddition.php">
						<?}?>
						<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
						<tr>
							<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3"><?if($title != ""){ echo $title;} else {echo "Add";}?> Rmuser</span></td>
					    </tr>
						<?if($msg!="") {?>
					   <tr>
							<td valign="middle" align="center" height="30" colspan="4" style="padding-top:50px;"><span class="normaltext3"><?echo $msg;?></span></td>
					   </tr>
					 
					   <?}

					   if($action == "edit") {
							if($_REQUEST['perform']) {
									$userid = $_POST['userid'];
									$name = $_POST['name'];
									$email = $_POST['email'];
									$mobile = $_POST['mobileno'];
							} else {
									$userid = $_REQUEST['userid'];
									$name = $editmemberdet[$_REQUEST['userid']]['name'];
									$email = $editmemberdet[$_REQUEST['userid']]['email'];
									$mobile = $editmemberdet[$_REQUEST['userid']]['mobile'];
							}

					   ?>

					   <tr>
						<td width="80" class="tdleft"><span class="normaltext2">UserID</span></td>
						<td width="80" class="tdright"><input type="hidden" name="userid" id="userid" value="<?=$userid;?>" readonly><span class="normaltext2"><?echo "<b>".strtoupper($userid)."</b>";?></span></td>			
						</tr>
						<input type="hidden" name="perform" value="edit">
						<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">Name</span></td>
								<td width="80" class="Rtdright"><input type="text" name="name" id="name" value="<?=$name;?>" maxlength="60"></td>			
						</tr>
						<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">EmailId</span></td>
								<td width="80" class="Rtdright"><input type="text" name="email" id="email" value="<?=$email;?>" maxlength="70"></td>			
						</tr>
						<!--<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">Phone - (Landline)</span></td>
								<td width="80" class="Rtdright"><input type="text" name="areacode" id="areacode" size="4" maxlength="10" value="<?=$_POST['areacode'];?>">&nbsp;&nbsp;<input type="text" name="phoneno" id="phoneno" maxlength="16" value="<?=$_POST['phoneno'];?>"></td>			
						</tr>-->
						<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">Mobile</span></td>
								<td width="80" class="Rtdright"><input type="text" name="mobileno" id="mobileno" maxlength="15" value="<?=str_replace("91~","",$mobile);?>"></td>			
						</tr>
						<?
						} else {

							    $rmuserid = GenerateuserId();
						?>
					   
						<tr>
								<td width="80" class="tdleft"><span class="normaltext2">UserID</span></td>
								<td width="80" class="tdright"><input type="hidden" name="userid" id="userid" value="<?=$rmuserid?>" readonly><span class="normaltext2"><?echo "<b>".strtoupper($rmuserid)."</b>";?></span></td>			
						</tr>
						<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">Name</span></td>
								<td width="80" class="Rtdright"><input type="text" name="name" id="name" value="<?=$_POST['name'];?>" maxlength="60"></td>			
						</tr>
						<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">EmailId</span></td>
								<td width="80" class="Rtdright"><input type="text" name="email" id="email" value="<?=$_POST['email'];?>" maxlength="70"></td>			
						</tr>
						<!--<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">Phone - (Landline)</span></td>
								<td width="80" class="Rtdright"><input type="text" name="areacode" id="areacode" size="4" maxlength="10" value="<?=$_POST['areacode'];?>">&nbsp;&nbsp;<input type="text" name="phoneno" id="phoneno" maxlength="16" value="<?=$_POST['phoneno'];?>"></td>			
						</tr>-->
						<tr>
								<td width="80" class="Rtdleft"><span class="normaltext2">Mobile</span></td>
								<td width="80" class="Rtdright"><input type="text" name="mobileno" id="mobileno" maxlength="15" value="<?=$_POST['mobileno'];?>"></td>			
						</tr>
						<?}?>				
						
						<tr>
								<td colspan="2" align="center" style="height:30px;"><span class="normaltext2"><input type="submit" value="Submit" name="Submit" class="SubmitButton"  onclick="return Validation();"></span></td>										
						</tr>
						  <tr><td height="50">&nbsp;</td></tr>
				</table>
				</form>
						<?}?>
					 
			</td>
		</table>
	</td>
</tr>
<?
$rmlogininfo->dbClose();
include_once "include/rmfooter.php";
?>
</body>
</html>

<?
function GenerateuserId() {
	global $rmlogininfo;	
	$userid = $rmlogininfo->Generateuserid('RMUserid','rmuser');

	if($userid != "") {
		return "rmuser".$userid;
	} else {
		return "rmuser1";
	}
}

function checkofficialid($email) {
	if($email != "") {
		$emaillist = split("@",$email);
		if(($emaillist[1] != "bharatmatrimony.com") && ($emaillist[1] != "consim.com")) {
			return "N";
		} else {
			return "Y";
		}
	}
}


function insert_rmlogininfo() {
	global $rmlogininfo;	

	$password = createRandomPassword();	

	//$phone = trim($_REQUEST['areacode'])."~".trim($_REQUEST['phoneno']);
	$phone = "";
	$mobileno="91~".$_REQUEST['mobileno'];
	$affectrows=$rmlogininfo->InsertRmlogininfo(trim($_REQUEST['userid']),trim($_REQUEST['email']),$phone,trim($mobileno),trim($_REQUEST['name']),$password);
	$val=1;
	sendmail(trim($_REQUEST['name']),trim($_REQUEST['email']),trim($_REQUEST['userid']),$password);
	sendadminmail(trim($_REQUEST['name']),trim($_REQUEST['userid']));
	return $val;
}

function update_rmlogininfo() {
	global $rmlogininfo;	
	$affectrows=$rmlogininfo->UpdateRmlogininfo(trim($_REQUEST['userid']),trim($_REQUEST['email']),trim($_REQUEST['mobileno']),trim($_REQUEST['name']));
	return;
}

function createRandomPassword() {
	  $chars = "abcdefghijkmnopqrstuvwxyz023456789";
	  srand((double)microtime()*1000000);
	  $i = 0;
	  $pass = '' ;
	   while ($i <= 7) {
		 $num = rand() % 33;
		 $tmp = substr($chars, $num, 1);
		 $pass = $pass . $tmp;
		 $i++;
	 }
	 return $pass;
}

function sendmail($name,$to,$userid,$password){


	$subject = "Regarding Login Details For RM Interface";

	$message = "Hi ".ucwords(strtolower($name)).",<br><br>\n\n";
	$message.="You have been activated to use Rm Interface, You can access the interface using the UserId: ".$userid." and Password: ".$password."<br><br>\n\n";	
	$message.= "Thanks,<br>\n";
	$message.= "Support Team";	

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: support@communitymatrimony.com <support@communitymatrimony.com>\n";	
    //$to='bmtest01@gmail.com'; 
	$mail1 = mail($to, $subject, $message, $headers);	
}

function sendadminmail($name,$userid){
	global $adminemail;
	$subject = "RM Interface New User";

	$message = "Hi Admin,<br><br>\n\n";
	$message.= "New User ".$name." - ".$userid." has been added to Rm Interface<br><br>\n\n";	
	$message.= "Thanks,<br>\n";
	$message.="BM Tech";	

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: support@communitymatrimony.com <support@communitymatrimony.com>\n";	
    //$adminemail='bmtest02@gmail.com';
	$mail2 = mail($adminemail, $subject, $message, $headers);	
}

function Allmemberslist() {
	
	global $rmlogininfo, $page, $max_results, $from;
	
	//find total no of records
	$tot = $rmlogininfo->Rmalluserdetails('','','totpage');
	
	// fetch datas with limit
	$rmmemberslist = $rmlogininfo->Rmalluserdetails($from,$max_results);

	if(is_array($rmmemberslist) && count($rmmemberslist) >0) {
		
		$html =  '<tr>
					<td valign="middle" align="center" height="30" colspan="4"><span class="normaltext3">Rmusers Detail</span></td>
				</tr>
				<tr>
				   <td align="left" class="tdleft"><span class="normaltext2"><b>RmUserId</b></span></td>
				   <td align="left" class="tdleft"><span class="normaltext2"><b>Name</b></span></td>
				   <td align="left" class="tdleft"><span class="normaltext2"><b>Email Id</b></span></td>
				   <td align="left" class="tdright"><span class="normaltext2"><b>Mobile</b></span></td>
				</tr>';	
		
		foreach($rmmemberslist as $rmuser=>$detailarray) {						
				$html .=  '<tr>
							<td align="left" class="Rtdleft"><span class="normaltext2">'.strtoupper($rmuser).'</span></td>
							<td align="left" class="Rtdleft"><span class="normaltext2">'.ucwords(strtolower($detailarray['name'])).'</span></td>
							<td align="left" class="Rtdleft"><span class="normaltext2">'.$detailarray['email'].'</span></td>
							<td align="left" class="Rtdright"><span class="normaltext2">'.$detailarray['mobile'].'</span>&nbsp;<a href="http://www.communitymatrimony.com/privilege/rmuser/rmuseraddition.php?action=edit&userid='.strtoupper($rmuser).'" class="normallinkText">Edit</a></td></tr>';	
						
		}
		 $tot_result = ceil($tot / $max_results);
		 if($tot_result >1){
			  $html .= pagination($tot_result,$page);
		}
	}
	return $html;
}

function pagination($tot,$page) {
	
	$prev = $page-1;
	$next = $page+1;
	
	$html .= "<tr bgcolor='#ffffff'><td colspan=6 style='padding-top:10px;'><table width=300px cellspacing=0 cellpadding=2 border=0 align=center style='padding-top:2px; padding-bottom:2px;'><tr bgcolor='#ffffff'><td colspan=6 class='normaltext' style='text-align:center;'><b>Select page</b></td></tr><tr>";	
	if($page >1){
		$html .= "<td width=100px align=center><a href='".$_SERVER['PHP_SELF']."?page=1&action=view' class='normallinkText'>First</a>&nbsp;&nbsp;<a href='".$_SERVER['PHP_SELF']."?page=".$prev."&action=view' class='normallinkText'>Previous</a>&nbsp;</td>";
	}
	for($t=1;$t<=$tot;$t++) {
		if($t == $page) {
			$html .= "<td width=20px align=center><span class='normaltext2'><b>".$t."</b></span>&nbsp;<span  class='smalltxt'>|</span>&nbsp;</td>";
		} elseif(($t < ($page+5)) && ($t > ($page-5))) {
			$html .= "<td width=20px align=center><span class='smalltxt'><a href='".$_SERVER['PHP_SELF']."?page=".$t."&action=view'  class='normallinkText'>".$t."</a>&nbsp;|</span>&nbsp;</td>";
		}
	}
	if($page <$tot){
		$html .= "<td width=100px align=center><a href='".$_SERVER['PHP_SELF']."?page=".$next."&action=view' class='normallinkText'>Next</a>&nbsp;&nbsp;<a href='".$_SERVER['PHP_SELF']."?page=".$tot."&action=view' class='normallinkText'>Last</a>&nbsp;</td>";
	}
	$html .= "</tr></table></td></tr>";
	return $html;
}
?>