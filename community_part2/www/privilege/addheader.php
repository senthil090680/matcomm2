<?
$url = "www.communitymatrimony.com";
if($sessRMUsername == '') { header("location:http://".$url."/privilege/mainindex.php"); }

$varMemidRminter = $_REQUEST['MEMID_RMINTER'];
$varMemId		 = $_REQUEST['MEMID'];

?>

<script>
function hide(){
	 document.getElementById("memcom").style.display='';
	 document.getElementById("before").style.display='none';
	 document.getElementById("after").style.display='block';
	 document.getElementById("phonediv").style.display='none';
	 document.getElementById("afterph").style.display='none';
	 document.getElementById("beforeph").style.display='block';
 }

 function showphone(){																	   
	document.getElementById("phonediv").style.display='block';
	document.getElementById("afterph").style.display='block';
	document.getElementById("beforeph").style.display='none';
	document.getElementById("memcom").style.display='none';
    document.getElementById("before").style.display='block';
	 document.getElementById("after").style.display='none';
 }

 function delete_cookie (cookie_name,url)
{ 
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
  var url = '<? echo $url;?>';
  location.href="http://"+url+"/privilege/mainindex.php";
}
</script>
<? if($_GET['p']==0){ $partial=""; $varPartial = '&p=0'; $width='420'; }
else{ $partial="show"; $varPartial = '&p=1'; $width='650'; }

if (($varAct=='rmhome') || ($varAct=='rmpartnerlist' && $varMemidRminter=='')) { $width='220'; }

?>

<tr>
	<td align="right">
	<table border="0" width="<?=$width?>" cellpadding="2" cellspacing="0">
	<tr><td height="22" class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?MEMID_RMINTER=<?=$varMemidRminter.$varPartial;?>" class="clr1">Home</a></td>

	<? if ($varMemidRminter !='' && $varAct !='rmhome') { ?>
	<td class="smalltxt">|</td>
	<td class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmcontactdet&MEMID_RMINTER=<?=$varMemidRminter?>&val=1<?=$varPartial?>" class="clr1">Member Communication</a></td>

<? } ?>
	<td class="smalltxt">|</td>
	<td class="smalltxt"><a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmpartnerlist&MEMID_RMINTER=<?=$varMemidRminter.$varPartial?>" class="clr1">Partner Match Configuration</a></td>
<?

	if($partial!='show'){ 
		if ($varMemidRminter !=''  && $varAct !='rmhome') { 
?>
	<td class="smalltxt">|</td>
	<td align="center" class="smalltxt"><a href="http://<?=$url?>/privilege/rmprofiledetails.php?MEMID_RMINTER=<?=$varMemidRminter?>" class="clr1">Profile View</a></td>
		<? } ?>
		<td class="clr2">|</td>

<?} else{
	
		if ($varAct!='rmhome') {

	if(($varMemId=="")&&($_REQUEST['p']==1)) { $memid=$varMemidRminter; }
			else{ if($varMemidRminter!="") { $memid=$varMemidRminter; } else{ $memid=$varMemId; } } ?>
		<td class="smalltxt">|</td><!--MEMID-->
		<td  class="smalltxt"><a href="http://<?=$url?>/privilege/rmpartial.php?MEMID=<?=$memid?>&p=1" class="clr1">Search</a></td>
		<td class="smalltxt">|</td>
		 <td class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmviewprofile&MEMID_RMINTER=<?=$memid?>&p=1" class="clr1">View Profile By Id</a></td>
		<td class="smalltxt">|</td>
		 <td class="smalltxt"><a href="http://<?=$url?>/privilege/rmlistall.php?MEMID_RMINTER=<?=$memid?>&p=1" class="clr1">Short List</a></td>
			<td class="smalltxt">|</td>
		  <td class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmmatriphonelist&MEMID_RMINTER=<?=$memid?>&p=1"class="clr1">Phone Number</a></td>
		   <td class="smalltxt">|</td>


<? } } if($_REQUEST['val'] != 1)
	$style = 'style="display:none"';
	else $style = '';
?>
<td class="smalltxt"><a href="http://www.communitymatrimony.com/privilege/mainindex.php?act=rmlogout" class="clr1">Logout</a></td>
</tr>


<? if (($varAct=='rmcontactdet') || ($varAct=='rmsendmail') || ($varAct=='rmmemcomunicate')) { ?>

	<td colspan="15">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="right">
			<tr>
		 		<td style="padding-left:0px;"> 
				<div style="background-color: rgb(154, 154, 154);">
					<table border="0" cellpadding="0" cellspacing="0" align="right" style="border-top:1px solid #cbcbcb;">
						<tr bgcolor="#EFEFEF">
							<td align="center" style="border-left: 1px solid #9A9A9A;border-right: 1px solid #9A9A9A;"><div  style="padding:2px 2px;"><span class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmcontactdet&MEMID_RMINTER=<?=$varMemidRminter?>&val=1<?=$varPartial?>" class="clr1">Member ContactInfo</a></span></div> </td>
						
							<td align="center" style="border-right: 1px solid #9A9A9A;"> <div  style="padding:2px 2px;"> <span class="smalltxt"><a href="http://<?=$url?>/privilege/rmmailpartial.php?MEMID=<?=$varMemidRminter?>&val=1<?=$varPartial?>" class="clr1">Send Message to member</a></span></div></td>
								 
							<td style="border-right: 1px solid #9A9A9A;"><div  style="padding:2px 2px;"><span class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmmemcomunicate&MEMID_RMINTER=<?=$varMemidRminter?>&val=1<?=$varPartial?>" class="clr1">Sent Mail to member</a></span></div></td>
						</tr>
					</table>	
				</div>
				</td>
			</tr>
		</table>
	</td>


<? }
	
	if (($varAct=='rmmatriphonelist') || ($varAct=='rmviewphonelog')) { ?>
	<td colspan="15" align="right"> 
		<table border="0" width="100%" cellpadding="0" cellspacing="0" align="right">
			<tr>
		 		<td style="padding-left:0px;"> 
				<div style="background-color: rgb(154, 154, 154);">
					<table border="0" cellpadding="0" cellspacing="0" align="right" style="border-top:1px solid #cbcbcb;">
						<tr bgcolor="#EFEFEF">


							<td align="center" style="border-top: 1px solid #9A9A9A;border-left: 1px solid #9A9A9A;border-right: 1px solid #9A9A9A;"><div  style="padding:2px 2px;"><span class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmmatriphonelist&MEMID_RMINTER=<?=$memid;?>&p=1" class="clr1">View Phone Number</a></span></div> </td>
							<td align="center" style="border-top: 1px solid #9A9A9A;border-right: 1px solid #9A9A9A;"> <div  style="padding:2px 2px;"> <span class="smalltxt"><a href="http://<?=$url?>/privilege/mainindex.php?act=rmviewphonelog&MEMID_RMINTER=<?=$memid;?>&p=1" class="clr1">Phone Log Summary</a></span></div></td>
						</tr>
					</table>
				</div>
				</td>
			</tr>
		</table>
	</td>
	<? } //} ?>
</tr>
</table>
</td></tr>