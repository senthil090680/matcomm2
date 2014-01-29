<?php
/* ************************************************************************************************** */
/* File		: horomatchonline.php
/* Author	: Mano Emerson
/* Date		: 10-Dec-2007
/* MasterSlave Modification By : Hameed.J (16-12-2007)
/* ************************************************************************************************** */
/* Description	: 
/*     This file is used to generate the match horoscopes
/* ************************************************************************************************** */
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc"; // This includes error reporting functionalities
include_once $DOCROOTBASEPATH."/bmconf/bmvars.inc";
include_once $DOCROOTBASEPATH."/bmconf/horoastrovisionurl.inc";
$memberid = $COOKIEINFO['LOGININFO']['MEMBERID'];
$domainarr = getDomainInfo(1,$memberid);
$domainimgspath	 = $domainarr["domainnameimgs"];  // imgs Path

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
<div id='mydiv'><center><br/><br/><img src='http://<?php echo $domainimgspath; ?>/bmimages/loading-icon.gif'><br/><font class='smalltxt'><b>Matching Horoscopes ...</b><br/><br/>Horoscope Matching report will be available in a few minutes.</font><br/></center></div>
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