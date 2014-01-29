<? if (trim($varGetCookieInfo['MATRIID']) !="") { ?>
	<script>var msgn_myid='<?=$varGetCookieInfo['MATRIID']?>';</script>
	<script src='<?=$confValues['JSPATH']?>/al.js'></script><script>anonConnection();</script>
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
<div align="center">
<?
if($varDomainPart2 == 'pakistanimatrimony') { ?>
<div align="center" style="width:773px;padding-bottom:10px;" class="nav mgt20 clr10 smalltxt pdt10">
		<a class="clr9" href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus">About Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr9" href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr9" href="<?=$confValues['SERVERURL']?>/site/index.php?act=privacypolicy">Privacy Policy</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr9" href="<?=$confValues['SERVERURL']?>/payment/">Pay Now</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr9" href="http://image.pakistanimatrimony.com/successstory/index.php?act=success">Post Success Story</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr9" href="<?=$confValues['SERVERURL']?>/site/index.php?act=termsandconditions">Terms and Conditions</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr9" href="<?=$confValues['SERVERURL']?>/matrimonials/">Popular Matrimony Searches</a>
		</div>
		<div align="center" class="smalltxt clr paddt5">Copyright &copy; 2011 PakistaniMatrimony.com All rights reserved. </div>
<? } else if($varDomainPart2 == 'srilankanmatrimony') { ?>
		<center>
		<div style="width:775px;">
		<div class="fleft"><img src="http://img.srilankanmatrimony.com/images/srilankan/flft-bg.jpg" /></div>
		<div class="fleft footer-bg" style="width:725px;">
		<ul class="foot"><li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus">About Us</a></li><li style="color:#555555">|</li><li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback">Contact Us</a></li><li style="color:#555555">|</li><li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=privacypolicy">Privacy Policy</a></li><li style="color:#555555">|</li><li><a href="<?=$confValues['SERVERURL']?>/payment/">Pay Now</a></li><li style="color:#555555">|</li><li><a href="http://image.srilankanmatrimony.com/successstory/index.php?act=success">Post Success Story</a></li><li style="color:#555555">|</li><li><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=termsandconditions">Terms and Conditions</a></li></li><li style="color:#555555">|</li><li><a href="<?=$confValues['SERVERURL']?>/matrimonials/">Popular Matrimony Searches </a></li></ul>

		</div>
		<div class="fleft"><img src="http://img.srilankanmatrimony.com/images/srilankan/frgt-bg.jpg" /></div><div style="clear:both;"></div>
		</div>
		<div align="center" class="smalltxt clr7">Copyright &copy; 2011 SrilankanMatrimony.com All rights reserved. </div>
		</center>
<? } else { ?>

<div class="mywdt">
<div class="fleft tlleft bgclr3 mywdt" style="height:95px;">
<div class="mymgnt18 mymgnl10 fleft disline">
 <div class="fleft"><img src="<?=$confValues['IMGSURL']?>/footbg.jpg" height="60" width="6" /></div>
 <div class="fleft normdiv hgt60 normtxt mywdt387">
  <div class="fleft smalltxt clr1 tlleft" style="margin-top:6px;margin-left:6px;display:inline;"><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=aboutus" class="smalltxt clr1">About Us</a><br><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=contactus" class="smalltxt clr1">Contact Us</a> <br><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=feedback" class="smalltxt clr1">Feedback</a> </div>
  <div style="margin-left:20px;display:inline;margin-top:6px;" class="fleft smalltxt clr1 tlleft">
  <? if($varDomainPart2 != 'communitymatrimony') { ?>
   <a href="<?=$confValues['SERVERURL']?>/payment/" class="smalltxt clr1">Pay Now</a><br>
  <?}?>
  <a href="<?=$confValues['SERVERURL']?>/site/index.php?act=<?=$vartermcond?>" class="smalltxt clr1">Terms and Conditions</a><br><a href="<?=$confValues['SERVERURL']?>/site/index.php?act=<?=$varprivacy?>" class="smalltxt clr1">Privacy Policy</a></div>
  <div style="margin-left:30px;display:inline;margin-top:6px;" class="fleft smalltxt clr1 tlleft">
  <? if($varDomainPart2 != 'communitymatrimony') { ?>
  <a href="<?=$confValues['IMAGEURL']?>/successstory/index.php?act=success" class="smalltxt clr1">Post Success Story</a><br>
  <a href="<?=$confValues['SERVERURL']?>/matrimonials/" class="smalltxt clr1">Popular Matrimony Searches</a>
  <?}?>
 </div>
 </div>
 <div class="fleft mymgnl5 normdiv hgt60" style="width:50px;">
 <div style="padding-left:15px;padding-top:13px;">
 <?
 if($varDomainPart2 != 'communitymatrimony'){ ?>
 <a href="<?=$confValues['SERVERURL']?>/feeds/"><img src="<?=$confValues['IMGSURL']?>/rss.jpg" height="39" width="26" style="border:0px;" /></a>
<?}?>
</div>
 </div>

  <div class="fleft"><img src="<?=$confValues['IMGSURL']?>/footbg1.jpg" height="60" width="6" /></div>
</div>
<div class="mymgnt30 mymgnl10 fleft"><font class="smalltxt clr"><?=$confPageValues["COPYRIGHT"]?> <br><?=ucfirst($varDomainPart2)?> is part of <a href="http://www.communitymatrimony.com" class="clr">CommunityMatrimony.com</a></font></div>
</div>
<div class="fleft tlleft bgclr4 mywdt fclr" style="padding-top: 5px; padding-bottom: 5px;">
<center>
				<font class="smalltxt fclr">
				<span style="font: bold 11px arial;" class="fclr">Our Networks :</span>&nbsp;&nbsp;
				<a class="smalltxt fclr" target="_blank" href="http://www.bharatmatrimony.com">Matrimony</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?
				if($varDomainPart2 != 'communitymatrimony'){ ?>	
				<a class="smalltxt fclr" target="_blank" href="http://www.communitymatrimony.com">CommunityMatrimony</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?}?>
				<a class="smalltxt fclr" target="_blank" href="http://www.clickjobs.com">Jobs</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="smalltxt fclr" target="_blank" href="http://www.indiaproperty.com">Property</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="smalltxt fclr" target="_blank" href="http://www.indialist.com">Classifieds</a></font>
			</center>

</div>
</div>
<? } ?>
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

}
</script>

<?

$varLiveHelpNo	= $_COOKIE['liveHelpNo'];
 if($varDomainPart2 != 'srilankanmatrimony' && $varDomainPart2 != 'pakistanimatrimony'){
   if ($varLiveHelpNo !="") {
	//echo '<script>';
	//echo 'funDisplayNo(\''.$varLiveHelpNo.'\');';
	//echo '</script>';
	echo '<script>funLiveHelpNo();</script>';
   } else { echo '<script>funLiveHelpNo();</script>'; }
 }
}
?>
