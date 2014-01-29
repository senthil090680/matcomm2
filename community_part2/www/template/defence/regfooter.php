<? if (trim($varGetCookieInfo['MATRIID']) !="") { ?>
	<script>var msgn_myid='<?=$varGetCookieInfo['MATRIID']?>';</script>
	<script src='<?=$confValues['JSPATH']?>/al.js'></script><script>//anonConnection();</script>
<? }
//SEO ORGANIC TRACK CODE...
if(!empty($_SERVER['HTTP_REFERER'])) {
	$varOrgAct	= $_REQUEST['act'] ? '/'.$_REQUEST['act'].'.php' : '';
?>
	<iframe src="http://www.communitymatrimony.com/googlecamp/seo/seoorganictrack.php?ref=<?=urlencode($_SERVER['HTTP_REFERER'])?>&ip=<?=urlencode($_SERVER['REMOTE_ADDR'])?>&page=<?=$_SERVER['PHP_SELF'].$varOrgAct?>&matriid=<?=trim($varGetCookieInfo['MATRIID'])?>" width="0" height="0" frameborder="0"></iframe>
<?	} ?>
<br clear="all" />
<?
$varprivacy='';
$vartermcond='';
if($varDomainPart2 == 'communitymatrimony') {
	$varprivacy='privacypolicy_com';
	$vartermcond='termsandconditions_com';
}else if($varDomainPart2 == 'muslimmatrimony') {
	$varprivacy='privacypolicy';
	$vartermcond='mus_terms';
}else if($varDomainPart2 == 'christianmatrimony') {
	$varprivacy='privacypolicy';
	$vartermcond='chris_terms';
}else {
	$varprivacy='privacypolicy';
	$vartermcond='termsandconditions';
}

?>

<div class="deffoot" align="center">
    <div style="width:772px;" align="left">
        <div class="deffooter">
            &nbsp;
        </div>
    </div>
    <div id="defma">
        <div id="defft"><?=$confPageValues["COPYRIGHT"]?></div>
    </div>
</div>

<?

/* Campaign LMS Click track call statements */
/* Query string parameters */
$varCampTrackId	 = addslashes(strip_tags(trim($_REQUEST['trackid'])));
$varCampType	 = addslashes(strip_tags(trim($_REQUEST['type'])));
$varCampFormFeed = addslashes(strip_tags(trim($_REQUEST['formfeed'])));

/* Campaign LMS Click Track */
if ($varCampTrackId!="" && $varCampFormFeed=='y') {
 echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/clicktrack.php?trackid=".$varCampTrackId."&type=".$varCampType."&formfeed=y\"></script>";
}

if ($varSplitDomain[0]=='image') { $varLiveHelpURL	= $confValues['IMAGEURL']; } else {
$varLiveHelpURL	= $confValues['SERVERURL']; }

if ($varLiveHelp=='1') { ?>

<script language="javascript">

function funLiveHelpNo(){

		objLiveHelp = AjaxCall();
		var parameters	= Math.random();
		var liveHelpURL	= '<?=$varLiveHelpURL;?>' + "/site/livehelpno.php";
		objLiveHelp.onreadystatechange = funLiveHelp;
		objLiveHelp.open('POST', liveHelpURL, true);
		objLiveHelp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objLiveHelp.setRequestHeader("Content-length", parameters.length);
		objLiveHelp.setRequestHeader("Connection", "close");
		objLiveHelp.send(parameters);
		return objLiveHelp;
}

function funLiveHelp() {
	if (objLiveHelp.readyState == 4 && objLiveHelp.status == 200) {
		var tollFreeNo = objLiveHelp.responseText;
		if(document.getElementById('livehelpno1')){
			document.getElementById('livehelpno1').innerHTML = tollFreeNo;
		}
	}
}

</script>

<?	

$varLiveHelpNo	= $_COOKIE['liveHelpNo'];
if ($varLiveHelpNo !="") {
	echo '<script>funLiveHelpNo();</script>';
 } else { echo '<script>funLiveHelpNo();</script>'; }
	 
}
?>