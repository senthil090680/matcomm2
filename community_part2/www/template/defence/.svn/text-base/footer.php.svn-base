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
            <ul>
                <li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus" class="smalltxt clr1">About Us</a></li>
                <li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=contactus" class="smalltxt clr1">Contact Us</a></li>
                <li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=<?=$varprivacy?>" class="smalltxt clr1">Privacy Policy</a></li>
                <li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=<?=$vartermcond?>" class="smalltxt clr1">Terms and Conditions</a></li>
                <li><a href="<?=$confValues['SERVERURL']?>/payment/" class="smalltxt clr1">Pay Now</a></li>
                <li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback" class="smalltxt clr1">Feedback</a></li>
                <li style="background: none;"><a href="<?=$confValues['IMAGEURL']?>/successstory/index.php?act=success" class="smalltxt clr1">Post Success Story</a></li>
            </ul>
        </div>
    </div>
	<div></div>
	<div style="clear:both;"></div>
	<div style="width: 720px;">
		<center>
		<font class="smalltxt" style="color:#000000;">
		<span class="clrw" style="font:bold 11px arial;color:#000000;">Our Networks:</span>&nbsp;&nbsp;
		<a href="http://www.bharatmatrimony.com" target="_blank" class="smalltxt" style="color:#000000;">Matrimony</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.communitymatrimony.com" target="_blank" class="smalltxt" style="color:#000000;">CommunityMatrimony</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.clickjobs.com" target="_blank" class="smalltxt" style="color:#000000;">Jobs</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.indiaproperty.com" target="_blank" class="smalltxt" style="color:#000000;">Property</a>&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="http://www.indialist.com" target="_blank" class="smalltxt" style="color:#000000;">Classifieds</a></font>
		</center>		
		</div><div style="clear:both;"></div>
    <div id="defma" style="padding-top:5px;">
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
		//document.getElementById('livehelpno').innerHTML = tollFreeNo;
		if(document.getElementById('livehelpno1')){
			document.getElementById('livehelpno1').innerHTML = tollFreeNo;
		}
		if(document.getElementById('livehelpno2')){
			document.getElementById('livehelpno2').innerHTML = tollFreeNo;
		}
		if(document.getElementById('livehelpno3')){
			document.getElementById('livehelpno3').innerHTML = tollFreeNo;
		}
	}
}

function funDisplayNo(argNo) {

	document.getElementById('livehelpno').innerHTML = argNo;
	if(document.getElementById('livehelpno1')){
		document.getElementById('livehelpno1').innerHTML = argNo;
	}

}//funDisplayNo

//funLiveHelpNo();

</script>

<?

$varLiveHelpNo	= $_COOKIE['liveHelpNo'];
if ($varLiveHelpNo !="") {
	//echo '<script>';
	//echo 'funDisplayNo(\''.$varLiveHelpNo.'\');';
	//echo '</script>';
	echo '<script>funLiveHelpNo();</script>';
 } else { echo '<script>funLiveHelpNo();</script>'; }

}


?>