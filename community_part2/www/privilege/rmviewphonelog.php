<?

include_once "include/rmclass.php";
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();

$affectrows=$rmclass->RMUserlog($_COOKIE['rmusername'],$_REQUEST['MEMID'],'2');	

if(isset($_POST['submit'])){
	   $memid = $_POST['memid'];
	   $from  = $_POST['datefrom'];
	   $to    = $_POST['dateto'];
	   echo "<script>document.location.href='mainindex.php?act=rmviewphonesummary&from=$from&to=$to&MEMID_RMINTER=$memid&p=1';</script>"; 
	   //header("location:mainindex.php?act=rmviewphonesummary&from=$from&to=$to&MEMID_RMINTER=$memid&p=1"); exit;  
} 

?>
<script language="javascript"  src="include/CalendarPopup.js"></script>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr><td height="20"></td></tr>
			<tr>
			<td width="100%" style="padding-left:20px;">
				<form name="viewprofile" method="post">
					<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								   <td valign="top" align="left" height="30" colspan="3">
								   <span class="bld normtxt1">Phone Log Summary</span></td>	 
								   <input type="hidden" name="memid" value="<?=$_REQUEST['MEMID_RMINTER'];?>">
							</tr>
							<tr>
									<td width="150"  class="tdleft"><span class="normtxt">Date Wise</span></td>
									  <td width="10"  class="tdleft"><span class="normtxt">:</span></td>
									<td width="450"  class="tdright"><script language="JavaScript" id="js2">
										var cal2 = new CalendarPopup();
										cal2.showYearNavigation();
										</script>
										<!-- <input type="text" name="chqdate" value="" maxlength="25" class="normtxt"> </span><span id="errpassword"></span> -->
										
										<input name="datefrom" value="" size="25" type="text" style="width:80px;" class="normtxt" onBlur="checkdate(this)">
										<a href="#" onclick="cal2.select(document.forms[0].datefrom,'fromlink','yyyy-MM-dd'); return false;"  name="fromlink" id="fromlink" class="normtxt"><img src="<?=$confValues['IMGSURL']?>/cal.gif"></a>
										 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input name="dateto" value="" size="25" type="text" style="width:80px;" class="normtxt" onBlur="checkdate(this)">
										<a href="#" onclick="cal2.select(document.forms[0].dateto,'tolink','yyyy-MM-dd'); return false;"  name="tolink" id="tolink" class="normtxt"><img src="<?=$confValues['IMGSURL']?>/cal.gif"></a>
										<div id="caldiv" style="position: absolute; visibility: hidden; background-color: white;"></div>
										 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="submit" name="submit" value="Submit" class="button" onclick="return rmvalidation();">
								</td>
							</tr>
							<tr><td height="20">&nbsp;</td></tr>
					</table>
				</form>
			</td>
		</table>

<script language="javascript">
	function rmvalidation(){
		if(document.viewprofile.datefrom.value==""){
			  alert("Choose the From Date");
			  return false;
		}
		if(document.viewprofile.dateto.value==""){
			  alert("Choose the To Date");
			  return false;
		}
	}	
</script>
	
