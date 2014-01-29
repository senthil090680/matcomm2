<?php
/****************************************************************************************************
File		: ansadminindex.php
Author	: Ganesh.S
Date		: 06-Aug-2008
*****************************************************************************************************
Description	: 
	This is Admin home page
********************************************************************************************************/

//SESSION CHECK
header("location:mainindex.php"); exit;
if($_COOKIE['rmusername']==""){ header("location:index.php"); exit; }

//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/www/privilege/include/rmclass.php');
include_once($varRootBasePath.'/www/privilege/include/rmheader.php');

?>
<script>
function showdet(divname,totrec){
for(var i=0;i <= totrec; i++){
	if(document.getElementById(i))
		document.getElementById(i).style.display='none';
}
		document.getElementById(divname).style.display='block';
}

function delete_cookie ( cookie_name )
{ 
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
  location.href="index.php";
}
</script>
<?
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
$affectrows=$rmclass->Showmembername($_COOKIE['rmusername']);	
?>
 <tr><td style="padding-left:320px;padding-top:10px;" class="normaltext3"></td> </tr>
  <tr>
		<td align="right" style="padding-left:480px;padding-top:10px;" class="normaltext3">
		<a href="rmpartnerlist.php" class="normaltext3">Partner Match Configuration</a>&nbsp;&nbsp;<span class="normaltext2">|&nbsp;&nbsp;</span>
		<a href="#" onclick="return delete_cookie ('rmusername');" class="normaltext3">Logout</a></td>
 </tr>
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" height="300">
			<tr>
			<td width="100%" style="padding-left:20px;"> 
				<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							 <td valign="top" align="left" height="15" colspan="4"><span class="bigtxt"><b>Hi <?=$_COOKIE['rmusername'];?> ! </b></span></td>
					    </tr>
						<tr>
							 <td valign="top" align="left" colspan="4" style="padding-bottom:20px;padding-top:10px;"><span class="normaltext2">Here's the list of members personally assigned to your care.To view a member's details click on the member's ID. </span></td>
					    </tr>
						 
						<tr>
							   <td valign="top" align="left" height="30" colspan="4"><span class="normaltext3">Member List</span></td>
					    </tr>
						<tr>
								<td width="330" class="tdleft"><span class="normaltext2"><b>Member Name/ID</b></span></td>
								<td width="80" class="tdleft"><span class="normaltext2"><b>Payment Date</b></span></td>
								<td width="80" class="tdleft"><span class="normaltext2"><b>Expiry Date</b></span></td>
								<td width="80" class="tdright"><span class="normaltext2"><b>Access</b></span></td>
						</tr>
						<?
							$affectrows=$rmclass->Showmemberlist($_COOKIE['rmusername']);
							
							
						  	for($mem=0;$mem<count($affectrows);$mem++){
												
						?>
						 <tr>
								<td width='330' class='Rtdleft'><a href="../profiledetail/viewprofile.php?MEMID=rmi&print=yes&id=<?echo $affectrows[$mem][0];?>" class='normaltext2' target="_blank"><?echo $affectrows[$mem][1]."/".$affectrows[$mem][0];?></a></td>
								<td width='150' class='Rtdleft'><span class='normaltext2'><?=$affectrows[$mem][4]?></span></td>
								<td width='100' class='Rtdleft'><span class='normaltext2'><?=$affectrows[$mem][5]?></span></td>
								<td width='100' class='Rtdright'>
								<?if($affectrows[$mem][3]==1){
								?>
									<a href="#" onclick="javascript:showdet('<?=$mem;?>','<?=count($affectrows)?>')" class='normaltext2'> Full</a>
									</td>
								</tr>
								<tr>
									<td colspan="4" style="border-left:1px  solid #A196BF; border-right:1px  solid #A196BF; border-bottom:1px  solid #A196BF;">
									<table border="0" cellpadding="0" cellspacing="0" width="700">
										<tr style="display:none;" id=<?=$mem;?> >
										<td align="right" style="width:700px;"> <div class="right" style="padding:2px 15px;"> <a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmprofiledetails.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on the \'Profile View\' to view member\'s full profile',this,event,'170');"><b>Profile View</b></a>&nbsp;&nbsp;&nbsp; <span class='normaltext3'><a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmcontactdet.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>&val=1"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on \'Member Communication\' to view all the communication you\'ve sent a member',this,event,'170');"><b>Member Communication</b></a></div></td></tr>						
									</table>
									</td>
								</tr>
								
								<?}else{?>
									<a href="#" onclick="javascript:showdet('<?=$mem;?>','<?=count($affectrows)?>')" class='normaltext2'>Partial</a>
									</td>
								</tr>
								<tr>
									<td colspan="4" style="border-left:1px  solid #A196BF; border-right:1px  solid #A196BF; border-bottom:1px  solid #A196BF;">
									<table border="0" cellpadding="0" cellspacing="0" width="700">
										<tr style="display:none;" id=<?=$mem;?> >
										<td align="right" style="width:700px;height:25px;">
										<a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmpartial.php?MEMID=<?=$affectrows[$mem][0]?>&val=1&p=1"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on the \'Search/Saved Search\' to start searching on behalf of the member.',this,event,'190');"><b>Search</b></a></span>&nbsp;&nbsp;&nbsp; 
										<a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmviewprofile.php?MEMID=<?=$affectrows[$mem][0]?>&val=1&p=1"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on \'View Profile by ID\' to view the profile of a member',this,event,'190');"><b>View Profile By Id</b></a>&nbsp;&nbsp;&nbsp;
										<a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmlistall.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>&p=1"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on \'Shortlist\' to shortlist a profile',this,event,'190');"><b>Short List</b></a>&nbsp;&nbsp;&nbsp;
										<a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmcontactdet.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>&val=1&p=1"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on \'Member Communication\' to view the contact details of the member and the communication you\'ve sent the member',this,event,'170');"><b>Member Communication</b></a>
										<a href="http://<?=$_SERVER['SERVER_NAME']?>/privilege/rmmatriphonelist.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>&p=1"  class='normaltext3' onmouseout="hidetip();" onmouseover="showhint('Click on \'Phone Number\' to view the phone number and phone log summary details of the member and the communication you\'ve sent the member',this,event,'170');"><b>Phone Number</b></a>

										</td></tr>						
									</table>
									</td>
								</tr>
								 <?}
							}?>
					   <tr><td height="50">&nbsp;</td></tr>
				</table>	
			</td>
		</table>
	</td>
</tr>
<?
$rmclass->CloseDB();
include_once($varRootBasePath.'/www/privilege/include/rmfooter.php');?>
</body>
</html>