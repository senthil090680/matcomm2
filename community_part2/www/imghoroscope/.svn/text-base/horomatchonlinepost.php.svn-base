<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: generateHoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/horoscope.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION VARIABLES
$memberid   	= 'AGR126890';//$varGetCookieInfo['MATRIID'];
$callpage="http://www.astrovisiononline.com/BharathMatrimony/test/";
?>

<script language="javascript">
/////////
//To alert user on page close / refreshing
/////////
window.onbeforeunload = function (event) {
			var flagHid = document.getElementById('isPageLoaded');
			if(flagHid.value != "1")
			{
			//white space space is added for aligning the text in center
			var alert_text = "            Your horoscope is being matched.";
			var browser=navigator.appName;
			var bAgt = navigator.userAgent.toLowerCase();
			var is_opr = (bAgt.indexOf("opera") != -1);
			var is_msie = (bAgt.indexOf("msie") != -1) && document.all && !is_opr;
			var is_msie5 = (bAgt.indexOf("msie 5") != -1) && document.all && !is_opr;

			if(is_msie || is_msie5 ||!event)
				{
				event=window.event;
				}
			if(event)
				{
				if(is_msie || is_msie5)
					{
					event.returnValue=alert_text;
					}
				return alert_text;
				}
			}
};
function hidediv()
{
	var d = document.getElementById('mydiv');	
	d.style.display = "none";

	//Update page loaded status
	var flagHid = document.getElementById('isPageLoaded');
	flagHid.value = "1";
}
</script>

<table border="0" cellpadding="0" cellspacing="0" width="610" bgcolor="#FFFFFF" height="100%">
<tr><td>
<?php
//check for cookie
if(isset($memberid)) 
{
	$strtext = trim($_GET["xdata"]);
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<div id='mydiv'><center><br/><br/><img src="<?=$confValues['IMGSURL']?>/logo/<?=$arrDomainInfo[$varDomain][2]?>_logo.gif" alt="<?=$confValues['PRODUCTNAME']?>" border="0"/><br/><img src='<?php echo $confValues["IMAGEURL"]; ?>/images/loading-icon.gif'><br/><font class='smalltxt'><b>Matching Horoscopes ...</b><br/><br/>Horoscope Matching report will be available in a few minutes.</font><br/></center></div>
<!------Hidden flag to hold the status of page load----->
<input type="hidden" id="isPageLoaded" value="0"> 
<iframe src="<?=$callpage?>inserttodb.php?data=<?=urlencode($strtext)?>" frameborder=0 marginheight=0 marginwidth=0 width="670" height="600" onLoad="javascript:hidediv();"></iframe>
<?php
}
else { echo "<div class='smalltxt'>You are either logged off or your session timed out. <a href='http://".$_SERVER['SERVER_NAME']."/login/loginform.php' target='_blank'>Click here</a> to login.</div>"; }
?>
</td>
</tr>
</table>