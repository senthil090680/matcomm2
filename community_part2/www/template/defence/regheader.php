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
		<?php if($_REQUEST['act']=='register_payment'){ ?>
		<div class="padr10" style="padding-top:45px;"><a href="/profiledetail/" class="normtxt" style="color:#ffffff;">Skip to My Home >></a></div>
		<? } ?>
		</div>
	</div>

</div>


