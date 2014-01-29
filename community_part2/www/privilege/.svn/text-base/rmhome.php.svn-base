<?php

//SESSION CHECK
if($sessRMUsername==""){ header("location:mainindex.php"); exit; }

//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/www/privilege/include/rmclass.php');

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
  location.href="http://www.communitymatrimony.com/privilege/mainindex.php";
}
</script>
<?
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
$affectrows=$rmclass->Showmembername($sessRMUsername);	
?>
 <tr><td style="padding-left:320px;padding-top:10px;" class="normtxt1">&nbsp;</td></tr>
<tr>
	<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<td width="100%" style="padding-left:20px;"> 
				<table border="0" cellpadding="0" cellspacing="0" width="97%">
						<tr>
							 <td valign="top" align="left" height="15" colspan="4"><span class="normtxt1 bld"><b>Hi <?=$sessRMUsername;?> ! </b></span></td>
					    </tr>
						<tr>
							 <td valign="top" align="left" colspan="4" style="padding-bottom:20px;padding-top:10px;"><span class="normtxt1">Here's the list of members personally assigned to your care.To view a member's details click on the member's ID. </span></td>
					    </tr>
						 
						<tr>
							   <td align="left" height="25" colspan="4" bgcolor="#dbdbdb" style="padding-left:10px;"><span class="normtxt1 bld">Member List</span></td>
					    </tr>
						<tr>
								<td width="330" class="mbrdr mbrdr2" style="padding-left:10px;" height="25"><span class="smalltxt"><b>Member Name/ID</b></span></td>
								<td width="120" class="mbrdr1" style="border-bottom:1px solid #cbcbcb;padding-left:10px;"><span class="smalltxt"><b>Payment Date</b></span></td>
								<td width="120" style="border-bottom:1px solid #cbcbcb;padding-left:10px;" class="mbrdr1"><span class="smalltxt"><b>Expiry Date</b></span></td>
								<td width="80" class="mbrdr1" style="border-bottom:1px solid #cbcbcb;padding-left:10px;"><span class="smalltxt"><b>Access</b></span></td>
						</tr>
						<?
							$affectrows=$rmclass->Showmemberlist($sessRMUsername);
						  	for($mem=0;$mem<count($affectrows);$mem++){
						?>
						 <tr>
								<td height="25" style="border-left:1px solid #cbcbcb;border-right:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;padding-left:10px;"><a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmviewprofile&memid=rmi&matriid=<?=$affectrows[$mem][0];?>&print=yes" class='normtxt clr1 bld' target="_blank"><?=$affectrows[$mem][1]."/".$affectrows[$mem][0];?></a></td>
								<td style="padding-left:8px;border-right:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;"><span class='normtxt'>&nbsp;<?=$affectrows[$mem][4]?></span></td>
								<td style="border-right:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;padding-left:10px;"><span class='normtxt'><?=$affectrows[$mem][5]?></span></td>
								<td style="border-right:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;padding-left:10px;">
								<?if($affectrows[$mem][3]==1){
								?>
									<a href="#" onclick="javascript:showdet('<?=$mem;?>','<?=count($affectrows)?>')" class='clr1 normtxt'> Full</a>
									</td>
								</tr>
								<tr>
									<td colspan="4">
									<table border="0" cellpadding="0" cellspacing="0" width="700" align="right">
										<tr style="display:none;" id=<?=$mem;?> >
										<td align="right" style="width:700px;height:25px;"> <div class="fright clr2 normtxt" style="padding:2px 15px;"> <a href="http://www.communitymatrimony.com/privilege/rmprofiledetails.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>"  class='smalltxt clr1' onmouseout="hidetip();" onmouseover="showhint('Click on the \'Profile View\' to view member\'s full profile',this,event,'170');"><b>Profile View</b></a>&nbsp;&nbsp;|&nbsp;&nbsp; <span class='smalltxt'><a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmcontactdet&MEMID_RMINTER=<?=$affectrows[$mem][0]?>&val=1" onmouseout="hidetip();" onmouseover="showhint('Click on \'Member Communication\' to view all the communication you\'ve sent a member',this,event,'170');" class="clr1"><b>Member Communication</b></a></div><br clear="all"><div id="hintbox"></div>
										</td></tr>	
									</table>
									</td>
								</tr>
								
								<?}else{?>
									<a href="#" onclick="javascript:showdet('<?=$mem;?>','<?=count($affectrows)?>')" class='normtxt clr1'>Partial</a>
									</td>
								</tr>
								<tr>
									<td colspan="4">
									<table border="0" cellpadding="0" cellspacing="0" width="700">
										<tr style="display:none;" id=<?=$mem;?> >
										<td align="right" style="width:700px;height:25px;" class="smalltxt clr2">
										<a href="http://www.communitymatrimony.com/privilege/rmpartial.php?MEMID=<?=$affectrows[$mem][0]?>&val=1&p=1"  class='smalltxt clr1' onmouseout="hidetip();" onmouseover="showhint('Click on the \'Search/Saved Search\' to start searching on behalf of the member.',this,event,'190');"><b>Search</b></a></span>&nbsp;&nbsp;|&nbsp;&nbsp; 
										<a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmviewprofile&MEMID_RMINTER=<?=$affectrows[$mem][0]?>&p=1"  class='smalltxt clr1' onmouseout="hidetip();" onmouseover="showhint('Click on \'View Profile by ID\' to view the profile of a member',this,event,'190');"><b>View Profile By Id</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;
										<a href="http://www.communitymatrimony.com/privilege/rmlistall.php?MEMID_RMINTER=<?=$affectrows[$mem][0]?>&val=1&p=1"  class='smalltxt clr1' onmouseout="hidetip();" onmouseover="showhint('Click on \'Shortlist\' to shortlist a profile',this,event,'190');"><b>Short List</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;
										<a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmcontactdet&MEMID_RMINTER=<?=$affectrows[$mem][0]?>&val=1&p=1"  class='smalltxt clr1' onmouseout="hidetip();" onmouseover="showhint('Click on \'Member Communication\' to view the contact details of the member and the communication you\'ve sent the member',this,event,'170');"><b>Member Communication</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;
										<a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmmatriphonelist&MEMID_RMINTER=<?=$affectrows[$mem][0]?>&p=1"  class='smalltxt clr1' onmouseout="hidetip();" onmouseover="showhint('Click on \'Phone Number\' to view the phone number and phone log summary details of the member and the communication you\'ve sent the member',this,event,'170');"><b>Phone Number</b></a>
										</td></tr>						
									</table>
									</td>
								</tr>
								 <?}
							}?>
					   <tr><td height="30">&nbsp;</td></tr>
				</table>	
			</td>
		</table>
	</td>
</tr>
<? $rmclass->CloseDB(); ?>
</body>
</html>