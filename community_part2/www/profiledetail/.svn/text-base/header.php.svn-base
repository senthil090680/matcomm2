<?php
#===================================================================================================================
# Author		: Dhanapal N, Ashok kumar
# Filename		: header.php
# Project		: MatrimonyProduct
# Date			: 28-Feb-2008
#===================================================================================================================
# Description	: Header part it holds Logo, first level menu strip and second level menu strip
#===================================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//File Includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath."/conf/payment.cil14");

//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$varPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$varGender		= $varGetCookieInfo['GENDER'];
$varLogoName	= $arrDomainInfo[$varDomain][2];
if ($varLogoName=='') { $varLogoName	= 'community'; }

$varTotalMsgCnt =  $varTotMsgRcevCnt + $varTotMsgSentCnt + $varTotIntRecvCnt + $varTotIntSentCnt + $varTotReqRecvCnt + $varTotReqSentCnt;
$varTotalRecd = $varTotMsgRcevCnt + $varTotIntRecvCnt + $varTotReqRecvCnt;
$varTotalSent = $varTotMsgSentCnt + $varTotIntSentCnt + $varTotReqSentCnt;

//if (($varPhotoStatus==1) && ($sessMatriId !="")) {
if ($sessMatriId !="") {
	$varPhotoImgTag ='<img src="'.$confValues['IMGSURL'].'/noimg50_m.gif" width="50" height="50">'; //MALE
	if ($varGender==2){
		$varPhotoImgTag ='<img src="'.$confValues['IMGSURL'].'/noimg50_f.gif" width="50" height="50">';
	}//FEMALE

	$varSplit		= array();
	$varSplit		= split('~', trim($varGetCookieInfo['PHOTO']));
	$varPhotoName	= trim($varSplit[0]);
	$varPhotoAvailable	= trim($varSplit[1]);

	if (trim($varPhotoName) != '' && trim($varPhotoName) != '0' && count($varSplit) > 0) {
		if ($varPhotoAvailable == 1 and trim($varPhotoName)!='') {
			$varPhotoFolder = $varGetCookieInfo['MATRIID']{3}.'/'.$varGetCookieInfo['MATRIID']{4}.'/';
			$varPhotoUrl = $confValues['PHOTOURL'].'/'.$varPhotoFolder.$varPhotoName;
			$varPhotoImgTag = '<img src="'.$varPhotoUrl.'" width="50" height="50">';
		} elseif (($varPhotoAvailable == 0 or $varPhotoAvailable == 2) and (trim($varPhotoName)!='')) {
			$varPhotoUrl = $confValues['PHOTOURL'].'/crop75/'.$varPhotoName;
			$varPhotoImgTag = '<img src="'.$varPhotoUrl.'" width="50" height="50">';
		}
	}
}
// echo $varPhotoImgTag;

// MEMBER SINCE & PAID OR FREE MEMBER CALCULATION //
$varMemberSince = '';
$varPaidMemberSince = '';
$varPaidExpire = '';
if (trim($varGetCookieInfo['TIMECREATED']) != '') {
	$varMemberSince = date("F 'y",strtotime($varGetCookieInfo['TIMECREATED']));
}
if (trim($varGetCookieInfo['LASTPAYMENT']) != '') {
	$varPaidMemberSince = date("jS F",strtotime($varGetCookieInfo['LASTPAYMENT']));
}
if (trim($varGetCookieInfo['EXPIRYDATE']) != '') {
	$varPaidExpire = date("jS F Y",strtotime($varGetCookieInfo['EXPIRYDATE']));
}
$varPaidStatusInfo = "Free member since $varMemberSince <br /> <a href=\"".$confValues['SERVERURL']."/payment/\" class=\"clr1\">Pay Now to enjoy more benefits >></a>";
if (trim($varGetCookieInfo['PAIDSTATUS']) == 1) {
	$varPaidStatusInfo = "Paid member since $varPaidMemberSince "; //'Paid membership valid for '.$varGetCookieInfo['VALIDDAYSLEFT'].' days';
	if ($varGetCookieInfo['VALIDDAYSLEFT'] <= 15) {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | <a href="'.$confValues['SERVERURL'].'/payment/" class="smalltxt">Renewal</a> pending on '.$varPaidExpire.'</font>';
	} else {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | Membership ends on '.$varPaidExpire.'</font>';
	}
}

?>

<script>
function srch_getposOffset(overlay, offsettype){
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function quicklinkdisp()
{
	if (document.getElementById){
	var curobj=document.getElementById('quicklinkdisp');
	var srch_saveobj=document.getElementById('quicklinkdis');

	var browser=navigator.appName;
	var b_version=navigator.appVersion;
	var version=parseFloat(b_version);
	if (browser=="Microsoft Internet Explorer")
	{
	  	srch_saveobj.style.left=srch_getposOffset(curobj, "left")-54+"px";
		srch_saveobj.style.top=srch_getposOffset(curobj, "top")+15+"px";
	}
	else
	{
		srch_saveobj.style.left=srch_getposOffset(curobj, "left")-52+"px";
		srch_saveobj.style.top=srch_getposOffset(curobj, "top")+14+"px";
	}
	srch_saveobj.style.display="block";
	showquick();
	}
}

function showquick()
{
  var p = document.getElementById('quicklinkdisp');
  var c = document.getElementById('quicklinkdis');
  p["phone_parent"]     = p.id;
  c["phone_parent"]     = p.id;
  p["phone_child"]      = c.id;
  c["phone_child"]      = c.id;
  p["phone_position"]   = "y";
  c["phone_position"]   = "y";
  c.style.position   = "absolute";
  c.style.visibility = "visible";
  showtype="click";
  cursor="default";
  if (cursor != undefined) p.style.cursor = cursor;
   p.onclick     = quicklinkdisp;
   p.onmouseout  = quicklinkout;
   c.onmouseover = quicklinkdisp;
   c.onmouseout  = quicklinkout;
}

function quicklinkout()
{
	document.getElementById('quicklinkdis').style.visibility="hidden";
}
</script>

<script language="javascript" src="<?=$confValues['JSPATH']?>/fontvar.js" ></script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css" >
<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/small.css" title="smf" />
<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/medium.css" title="mdf" />
<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/large.css" title="lrg" />

<div class="fleft logodiv"><a href="<?=$confValues['SERVERURL']?>/<?=$sessMatriId ? 'profiledetail/' : ''?>"><img src="<?=$confValues['IMGSURL']?>/logo/<?=$varLogoName?>_logo.gif" alt="<?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony" border="0" /></a></div>

<div class="fright">

<!--- Top Menu Part -->
<div class="smalltxt clr2 topdiv" id="main"><font class="clr">
	<?
	if ($sessMatriId =="" && $varTopMenu!='login') {
		echo 'Already a Member? &nbsp;<a href="'.$confValues['SERVERURL'].'/login/" class="clr1">Login</a>';
	} elseif ($sessMatriId!='') { ?>
		<?=$varGetCookieInfo['NAME']?> (<?=$varGetCookieInfo['MATRIID']?>) &nbsp; <a class="<?=($varTopMenu=='profiledetail' || $varTopMenu=='photo' || $varTopMenu=='horoscope')?'clr bld':'clr1'?>" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo">Settings </a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?=$confValues['SERVERURL']?>/login/logout.php" class="clr1">Logout</a>
	<? } else { echo '&nbsp;';} ?></font>
</div>
<div class="cleard"></div>

<!--- Top Menu Part -->

<!--- Main Menu Part -->
<div class="normtxt clr2 padt20">

	<? if ($sessMatriId !="") { ?>
	<div class="fleft rbrdr" style="width:60px;"><a class="<?=$varTopMenu=='profiledetail' ? 'clr bld' : 'clr1';?>" href="<?=$confValues['SERVERURL']?>/profiledetail/">My Home </a></div><div class="fleft rbrdr tlcenter" id="menumsg" style="width:90px;"><a class="<?=$varTopMenu=='mymessages' ? 'clr bld' : 'clr1';?>" onclick="showhidediv('messagediv'); return true;" onmouseover="document.getElementById('menumsg').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menumsg').className='tlcenter fleft rbrdr';">Messages <img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft rbrdr tlcenter" id="menusrch" style="width:70px;"><a class="<?=$varTopMenu=='search' ? 'clr bld' : 'clr1';?>" onclick="showhidediv('searchdiv'); return true;" onmouseover="document.getElementById('menusrch').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';">Search <img src="<?=$confValues['IMGSURL']?>/arrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft tlcenter" style="width:70px;"><a class="<?=$varTopMenu=='payment' ? 'clr bld' : 'clr1';?>" href="<?=$confValues['SERVERURL']?>/payment/">Pay Now</a></div><!-- <div class="fleft tbrdr tlcenter" id="menuquick" style="width:87px;"><a title="Quick Links" style="border: 0px none ; cursor: pointer;" onclick="javascript:quicklinkdisp(this, 'quicklinkdis');" href="javascript:void(0)" id="quicklinkdisp" onmouseover="document.getElementById('menuquick').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menuquick').className='fleft tlcenter tbrdr1';" class="clr1 normtxt" >Quick Links</a></div> -->
	<? } else { ?>
	<a class="clr1" href="<?=$confValues['SERVERURL']?>/">Home&nbsp&nbsp;</a> |&nbsp;&nbsp; <a class="<?=$varTopMenu=='search' ? 'clr bld' : 'clr1';?>" href="<?=$confValues['SERVERURL']?>/search/">Search </a> &nbsp&nbsp;|&nbsp;&nbsp; <a class="<?=$varTopMenu=='payment' ? 'clr bld' : 'clr1';?>" href="<?=$confValues['SERVERURL']?>/payment/">Pay Now</a> &nbsp&nbsp;|&nbsp;&nbsp; <a href="<?=$confValues['SERVERURL']?>/register/" class="clr1">Register</a>
	<? } ?>
</div><div class="cleard"></div>

<!-- Message menu content -->
<div style="padding-left:60px !important;padding-left:59px;">
	<div id="messagediv" class="layer" style="display:none;width:69px !important;width:91px;" onmouseout="document.getElementById('menumsg').className='tlcenter fleft rbrdr';hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv');document.getElementById('menumsg').className='tlcenter fleft mbrdr1';">
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/mymessages/" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Received</a><br>
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Sent</a>
	</div>
</div>
<!-- Message menu content -->

<!-- Search menu content -->
<div style="padding-left:151px !important;padding-left:149px;">
	<div id="searchdiv" class="layer" style="display:none;width:70px !important;width:90px;" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv');document.getElementById('menusrch').className='tlcenter fleft mbrdr1';">
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/search/" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">In Detail</a><br>
	<a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/search/index.php?act=memidsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">By Member Id</a>
	</div>
</div>
<!-- Search menu content -->

<div class="layer" style="padding:0px; position: absolute; visibility: hidden; z-index: 1001; width: 127px !important;width:130px; cursor: default;" id="quicklinkdis" onmouseout="document.getElementById">
	<div class="linesep" style="width:40px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
	<div style="padding:5px 10px 5px 10px;"><a class="smalltxt clr1" href="">Upload Photo</a><br>
	<a class="smalltxt clr1" href="">Change Password</a><br>
	<a class="smalltxt clr1" href="">View new messages</a><br>
	<a class="smalltxt clr1" href="">View favourites</a><br>
	<a class="smalltxt clr1" href="">Delete Profile</a></div>
</div>

<!--- Main Menu Part -->

</div>
<br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<div class="fright padt5 clr2" style="height:30px;">
	<form name="fontvariant" action="GET">
		<div style="width:15px;height:20px;padding-top:3px;" class="fleft">
			<div style="width:15px;height:17px;" class="brdr tlcenter"><a id="small" href="javascript:;" class="clr1" onclick="smallfont();fontchg('sm');" value="smf" style="font-size:11px;">A</a></div>
		</div><div class="fleft" style="width:4px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="4" /></div>
		<div style="width:18px;height:20px;padding-top:2px;" class="fleft">
			<div style="width:17px;height:18px;" class="brdr tlcenter"><a id="med" href="javascript:;" class="clr1" onclick="medfont();fontchg('md');" value="mdf" style="font-size:14px;">A</a></div>
		</div><div class="fleft" style="width:4px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="4" /></div>
		<div style="width:20px;height:20px;" class="fleft">
			<div style="width:20px;height:18px !important;height:20px;padding-top:2px;" class="brdr tlcenter"><a id="large" href="javascript:;" class="clr1" onclick="larfont(); fontchg('lg');" value="lrg" style="font-size:17px;">A</a></div>
		</div>
	</form>
</div><br clear="all">

<? if ($sessMatriId!='' && $varTopMenu =='profiledetail' && $_REQUEST['act']=='') { ?>
<!-- get twitter id-->
<div><img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="gettwitterid('<?=$sessMatriId?>')" style="text-align:center;" \></div>
<!-- get twitter id-->
<div class="fleft photodiv">

	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoImgTag?></a>
	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoStatus==1 ? 'Manage' : 'Add'?>&nbsp;photos</a>
</div>
<!-- <div class="fleft textdiv normtxt clr"> -->
<div class="fleft normtxt clr" style="width:400px; padding:10px 0px 0px 0px;line-height:17px;">
	<font class="clr3">Hi <?=(trim($varGetCookieInfo['USERNAME'])!=''?trim($varGetCookieInfo['USERNAME']):trim($varGetCookieInfo['NAME']))?>, </font> Welcome to <?=$confValues['PRODUCTNAME']?><br/>
		Membership Status: Your ID: <?=$varGetCookieInfo['MATRIID']?>. <?=$varPaidStatusInfo?>
</div>

<div class="fright padt10" id="twitinputdiv" style="display:block;">
	 <div class="fleft padt5 smalltxt" style="background: url(<?=$confValues['IMGSURL']?>/twit-left.gif) no-repeat top left ; height:62px;">
			<div class="pad10a"><b>Got Twitter Account?</b><br> <a class="clr1" href="/profiledetail/index.php?act=primaryinfo">Click here to add your Twitter ID</a><br/><div class="padtb3" style="padding-left:110px;"><a class="clr1" href="/site/index.php?act=twithelp">How it works?</a></div></div>
	 </div><div class="fleft" style="background: url(<?=$confValues['IMGSURL']?>/twit-right.gif) no-repeat; height:62px;width:51px;"></div><br clear="all" />

</div>

<br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<br clear="all" />
<? } ?>
