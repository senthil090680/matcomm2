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
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath."/conf/basefunctions.inc");
include_once($varRootBasePath."/conf/payment.inc");

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

//Saved Searches info
$varSrchCont = '';
$varFFWidth = '120px';
$varIEWidth = '135px';
$varSrchPleftm = '131px';
$varSrchPleftie = '129px';

if($_COOKIE["savedSearchInfo"] !=''){
$arrSavedSearch	= split('~', $_COOKIE["savedSearchInfo"]);
$varSavedCnt= 0;
foreach($arrSavedSearch as $varSinSearch){
	$arrSrchInfo = split('\|', $varSinSearch);
	$varFFWidth = '235px';
	$varIEWidth = '250px';
	$varSrchPleftm = '60px';
	$varSrchPleftie = '59px';
	if($varSavedCnt==0){
		$varSrchCont .= '<div class="fleft" style="background:url('.$confValues['IMGSURL'].'/versep.gif) repeat-y;height:80px;width:1px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="1" /></div><div class="fleft tlleft" style="padding-left:5px;line-height:16px;"><div class="bld" style="padding-bottom:5px;">Saved search(s)</div>'; 
	}
	if($varSavedCnt <=2){
		$varEditLink = ($argSrchArray['Search_Type']==2) ? $arrSrchInfo[0].'&act=advsearch' : $arrSrchInfo[0];
		$varSrchCont .= '<img src="'.$confValues['IMGSURL'].'/darrow1.gif" hspace="5" /><a class="wclr" href="'.$confValues['SERVERURL'].'/search/index.php?act=srchresult&srchId='.$varEditLink.'" onclick="hidediv(\'searchdiv\');return true;" onmouseover="showdiv(\'searchdiv\'); return true;">'.$arrSrchInfo[2].'</a><br clear="all">';
	}
	$varSavedCnt++;
}
if($varSrchCont!=''){
	$varSrchCont .= '<div class="fright padt5"><a class="wclr" href="'.$confValues['SERVERURL'].'/search/index.php?act=savesearch">More>></a></div></div>'; 
}
}

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
	$varPaidMemberSince = date("jS F Y",strtotime($varGetCookieInfo['LASTPAYMENT']));
}
if (trim($varGetCookieInfo['EXPIRYDATE']) != '') {
	$varPaidExpire = date("jS F Y",strtotime($varGetCookieInfo['EXPIRYDATE']));
}
$varPaidStatusInfo = "Free member since $varMemberSince <br /> <a href=\"".$confValues['SERVERURL']."/payment/\" class=\"clr1\">Pay Now to enjoy more benefits >></a>";
if (trim($varGetCookieInfo['PAIDSTATUS']) == 1) {
	$varPaidStatusInfo = "Paid member since $varPaidMemberSince "; //'Paid membership valid for '.$varGetCookieInfo['VALIDDAYSLEFT'].' days';
	if ($varGetCookieInfo['VALIDDAYSLEFT'] <= 15) {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | <a href="'.$confValues['SERVERURL'].'/payment/" class="smalltxt clr1">Renewal</a> pending on '.$varPaidExpire.'</font>';
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

<!-- <script language="javascript" src="<?=$confValues['JSPATH']?>/fontvar.js" ></script>
<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/small.css" title="smf" />
<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/medium.css" title="mdf" />
<link rel="alternate stylesheet" href="<?=$confValues['CSSPATH']?>/large.css" title="lrg" /> -->
<link rel="alternate" type="application/rss+xml" title="RSS Feeds" href="<?=$confValues['SERVERURL']?>/feeds/" />
<div style="background-color:#8F2311;height:76px;width:100%;">
	<div style="width:772px;">
		<div class="fleft" style="padding-top:24px;"><a href="<?=$confValues['SERVERURL']?>/<?=$sessMatriId ? 'profiledetail/' : ''?>"><img src="<?=$confValues['IMGSURL']?>/defence_logo.gif" alt="<?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony" border="0" /></a></div>
		<div class="fright">
		
		<!--- Top Menu Part -->
			<div class="smalltxt clr2 topdiv" id="main"><font class="sclr">
				<?
				if ($sessMatriId =="" && $varTopMenu!='login') {
					$varSrchPleftm = '40px';
					$varSrchPleftie = '40px';
					echo 'Already a Member? &nbsp;<a href="'.$confValues['SERVERURL'].'/login/" class="wclr">Login</a>';
				} elseif ($sessMatriId!='') { ?>
					<?=$varGetCookieInfo['NAME']?> (<?=$varGetCookieInfo['MATRIID']?>) <!--&nbsp;  <a class="<?=($varTopMenu=='profiledetail' || $varTopMenu=='photo' || $varTopMenu=='horoscope')?'clr bld':'clr1'?>" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo">Settings </a> --> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?=$confValues['SERVERURL']?>/login/logout.php" class="wclr">Logout</a>
				<? } else { $varSrchPleftm = '40px';$varSrchPleftie = '40px';echo '&nbsp;';} ?></font>
			</div>
			<div class="cleard"></div>

		<!--- Top Menu Part -->

		<!--- Main Menu Part -->
			<div class="normtxt clr2" style="padding-top:28px;">
				<? if ($sessMatriId !="") { ?>
					<div class="fleft rbrdr" style="width:60px;"><a class="<?=($varTopMenu=='profiledetail') && ($varAct=='') ? 'wclr bld' : 'wclr';?>" href="<?=$confValues['SERVERURL']?>/profiledetail/">My Home </a></div><div class="fleft rbrdr tlcenter" id="menumsg" style="width:70px;"><a class="<?=$varTopMenu=='mymessages' ? 'wclr bld' : 'wclr';?>" onclick="showhidediv('messagediv'); return true;" onmouseover="document.getElementById('menumsg').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menumsg').className='tlcenter fleft rbrdr';">Inbox <img src="<?=$confValues['IMGSURL']?>/darrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft rbrdr tlcenter" id="menusrch" style="width:70px;"><a class="<?=$varTopMenu=='search' ? 'wclr bld' : 'wclr';?>" onclick="showhidediv('searchdiv'); return true;" onmouseover="document.getElementById('menusrch').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';">Search <img src="<?=$confValues['IMGSURL']?>/darrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft rbrdr tlcenter" style="width:80px;"><a class="<?=($varAct!='' && $varTopMenu=='profiledetail') || ($varTopMenu=='photo' || $varTopMenu=='horoscope')?'wclr bld':'wclr'?>" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo">Edit Profile</a></div><div class="fleft tlcenter" style="width:70px;"><a class="<?=$varTopMenu=='payment' ? 'wclr bld' : 'wclr';?>" href="<?=$confValues['SERVERURL']?>/payment/">Pay Now</a></div>
				<? } else if ($varDomainPart2!='communitymatrimony'){
				?>
					<div class="fleft rbrdr"><a class="wclr" href="<?=$confValues['SERVERURL']?>/">Home&nbsp;&nbsp;</a></div><div class="fleft rbrdr tlcenter" id="menusrch" style="width:70px;"><a class="<?=$varTopMenu=='search' ? 'wclr bld' : 'wclr';?>" onclick="showhidediv('searchdiv'); return true;" onmouseover="document.getElementById('menusrch').className='tlcenter fleft mbrdr1';" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';">Search&nbsp;&nbsp;<img src="<?=$confValues['IMGSURL']?>/darrow.gif" border="0" class="pntr" vspace="2" /></a></div><div class="fleft rbrdr"><a class="<?=$varTopMenu=='payment' ? 'wclr bld' : 'wclr';?>" href="<?=$confValues['SERVERURL']?>/payment/">&nbsp;&nbsp;Pay Now&nbsp;&nbsp;</a></div><a href="<?=$confValues['SERVERURL']?>/register/" class="wclr">&nbsp;&nbsp;Register</a>
				<? } ?>
			</div><div class="cleard"></div>

			<!-- Message menu content -->
			<div style="padding-left:60px !important;padding-left:59px;">
				<div id="messagediv" class="dlayer1 tlleft" style="display:none;width:50px !important;width:71px;" onmouseout="document.getElementById('menumsg').className='tlcenter fleft rbrdr';hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv');document.getElementById('menumsg').className='tlcenter fleft mbrdr1';">
				<a class="smalltxt wclr" href="<?=$confValues['SERVERURL']?>/mymessages/" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Received</a><br>
				<a class="smalltxt wclr" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Sent</a><br>
				<a class="smalltxt wclr" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Request</a>
				</div>
			</div>
			<!-- Message menu content -->

			<!-- Saved Search menu content -->
			<div style="padding-left:<?=$varSrchPleftm;?> !important;padding-left:<?=$varSrchPleftie;?>;">
				<div id="searchdiv" class="smalltxt dlayer tlleft" style="display:none;width:<?=$varFFWidth?> !important;width:<?=$varIEWidth?>;padding-right:0px;" onmouseout="document.getElementById('menusrch').className='tlcenter fleft rbrdr';hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv');document.getElementById('menusrch').className='tlcenter fleft mbrdr1';">
					<div class="fleft tlleft" style="padding-right:5px;"><a class="wclr" href="<?=$confValues['SERVERURL']?>/search/" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Basic search</a><br>
					<a class="wclr" href="<?=$confValues['SERVERURL']?>/search/index.php?act=advsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Advanced search</a><!-- <br>
					<a class="smalltxt wclr" href="<?=$confValues['SERVERURL']?>/search/index.php?act=whoisonline" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Members online search</a> --><br>
					<a class="wclr" href="<?=$confValues['SERVERURL']?>/search/index.php?act=memidsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">By Member Id search</a></div>
					<?=$varSrchCont;?>
				</div>
			</div>
			<!-- Search menu content -->

			<!--- Main Menu Part -->
		</div>
	</div>

</div>
<!--
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
</div> --><br clear="all">

<? // if ($sessMatriId!='' && $varTopMenu =='profiledetail' && $_REQUEST['act']=='') { ?>
<!-- <div style="width:772px;">
<div class="fleft photodiv">

	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoImgTag?></a>
	<a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoStatus==1 ? 'Manage' : 'Add'?>&nbsp;photos</a>
</div> -->
<!-- <div class="fleft textdiv normtxt clr"> -->
<!-- <div class="fleft normtxt clr tlleft" style="width:450px; padding:10px 0px 0px 0px;line-height:17px;">
	<font class="clr bld">Hi <?=(trim($varGetCookieInfo['USERNAME'])!=''?trim($varGetCookieInfo['USERNAME']):trim($varGetCookieInfo['NAME']))?> (<?=$varGetCookieInfo['MATRIID']?>),</font> Welcome to <?=$confValues['PRODUCTNAME']?><br/>
		Membership Status: <?=$varPaidStatusInfo?>
</div><!-- <div class="fright" style="padding-top:50px;"><a href="/site/index.php?act=newfeatures"><img src="<?=$confValues['IMGSURL']?>/features_bt.gif" border="0" /></a></div> -->
<!-- </div><div class="cleard"></div>
<div class="linesep" style="width:772px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<br clear="all" /> -->
<? //} ?>