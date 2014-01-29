<?php
#==========================================================================================================
# Author 		: Dhanapal, Srinivasan
# Date	        : 01 Jan 2010
# Project		: Community Matrimony RM Interface
# Filename		: rmheader.php
#==========================================================================================================
# Description   : Main
#==========================================================================================================

//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';	
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/www/privilege/include/rmclass.php');

if(isset($_POST['submit']))
{
	$rmclass=new rmclassname();
	$rmclass->init();
	$rmclass->rmConnect();
	$rmclass->username=mysql_escape_string($_POST['adusername']);
	$rmclass->password=mysql_escape_string($_POST['adpassword']);
	$affectrows=$rmclass->loginvalidation();
    $pos = strpos($rmclass->username, '@'); 
	   	if($affectrows>=1){
			 if($pos === false){
				setcookie("rmusername", $_POST['adusername'], time()+3600);
				header("location:rmindex.php");
			 }else{
			     $getid=$rmclass->getrmid();
				 setcookie("rmusername", $getid, time()+3600);
				 header("location:rmindex.php");
			 }
	} else { $Message="Invalid Username/Password"; }

	$rmclass->dbClose();
	UNSET($rmclass);
}
include_once($varRootBasePath.'/www/privilege/include/rmheader.php');
?>
<form name="login" method="post">
<tr>
	<td align="center">
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr><td colspan="2"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="50"></td></tr>
			<tr>
				<td width="250">&nbsp;</td>
				<td width="260">
						<table width="260" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #279C3F;font-family:arial;font-size:12px;">
							<tr>
								   <td height="25" align="left" style="border-bottom:1px solid #279C3F;" colspan="3"><span class="normalText1">&nbsp;Login</span></td>
							</tr>
							<tr><td height="20"></td></tr>
							<?if($Message!=""){?>
							 <tr><td height="25" colspan="3" valign="top" align="center"><span class="errortext4"><?=$Message;?></span></td></tr>
							<?}?>
							<tr>
									<td width="130" style="padding-left:5px;padding-right:5px;"><span class="normalText1">Username</span></td>
									<td width="10"><span class="normalText1">:</span></td>
									<td width="150" style="padding-left:5px;padding-right:5px;"><input type="text" name="adusername" value="" style="width:130px;" class="loginText"></td>
							</tr>
							<tr><td height="8"></td></tr>
							 <tr>
									<td width="130" style="padding-left:5px;padding-right:5px;"><span class="normalText1">Password</span></td>
									<td width="10"><span class="normalText1">:</span></td>
									<td width="150" style="padding-left:5px;padding-right:5px;"><input type="password" name="adpassword" value="" style="width:130px;" class="normalText1"></td>
							</tr>
							<tr><td height="8"></td></tr>
							<tr>
									<td colspan="3" style="padding-left:95px;padding-right:5px;">
									<input type="submit" name="submit" value="Submit"></td>
							</tr>
							<tr><td height="20"></td></tr>
						</table>
				</td>
				<td width="270">&nbsp;</td>
			</tr>
			<tr><td><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="50"></td></tr>
		</table>
	</td>
</tr>
</table>
<? include_once($varRootBasePath.'/www/privilege/include/rmfooter.php'); ?>
</form>
</body>
</html>
