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
$varFFWidth = '130px';
$varIEWidth = '140px';
$varSrchPleftm = '191px';
$varSrchPleftie = '191px';

if($_COOKIE["savedSearchInfo"] !=''){
$arrSavedSearch	= split('~', $_COOKIE["savedSearchInfo"]);
$varSavedCnt= 0;
foreach($arrSavedSearch as $varSinSearch){
	$arrSrchInfo = split('\|', $varSinSearch);
	$varFFWidth = '245px';
	$varIEWidth = '260px';
	$varSrchPleftm = '191px';
	$varSrchPleftie = '195px';
	if($varSavedCnt==0){
		$varSrchCont .= '<div class="fleft" style="background:url('.$confValues['IMGSURL'].'/versep2.gif) repeat-y;height:80px;width:1px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="1" /></div><div class="fleft" style="padding-left:10px;line-height:16px;"><div class="menclr1 bld" style="padding-bottom:5px;">Saved search(s)</div>'; 
	}
	if($varSavedCnt <=2){
		$varEditLink = ($argSrchArray['Search_Type']==2) ? $arrSrchInfo[0].'&act=advsearch' : $arrSrchInfo[0];
		$varSrchCont .= '<img src="'.$confValues['IMGSURL'].'/oarrow.gif" hspace="5" /><a class="menclr1" href="'.$confValues['SERVERURL'].'/search/index.php?act=srchresult&srchId='.$varEditLink.'" onclick="hidediv(\'searchdiv\');return true;" onmouseover="showdiv(\'searchdiv\'); return true;">'.$arrSrchInfo[2].'</a><br clear="all">';
	}
	$varSavedCnt++;
}
if($varSrchCont!=''){
	$varSrchCont .= '<div class="fleft padt5" style="padding-left:15px;"><a class="menclr1" href="'.$confValues['SERVERURL'].'/search/index.php?act=savesearch">More>></a></div></div>'; 
}
}
?>
<link rel="alternate" type="application/rss+xml" title="RSS Feeds" href="<?=$confValues['SERVERURL']?>/feeds/" />
 
<script language="javascript">
function imgchange(imname)
{
	if(imname=='mimg'){$('mimg').className='pntr';$('mimg1').className='pntr disnon';}
	if(imname=='mimg1'){$('mimg1').className='pntr';$('mimg').className='pntr disnon';}
	if(imname=='simg'){$('simg').className='pntr';$('simg1').className='pntr disnon';}
	if(imname=='simg1'){$('simg1').className='pntr';$('simg').className='pntr disnon';}

}
</script>
<div style="overflow:auto;">
	<div style="width:772px;height:75px;" class="topbgclr">
		<div class="fleft logodiv" style="padding-left:15px;"><a href="<?=$confValues['SERVERURL']?>/<?=$sessMatriId ? 'profiledetail/' : ''?>"><img src="<?=$confValues['IMGSURL']?>/logo/muslimlogo.gif" alt="<?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony" border="0" /></a></div>
		
		<div class="fright" style="padding-top:20px;padding-right:7px;">
			<div class="hgt33" style="background:url(http://img.communitymatrimony.com/images/livehelpnewbg.gif) no-repeat;width:379px;">
				<div class="pdt8 pdl10 fleft"><font style="font-size:14px;font-weight:bold;">24/7</font> &nbsp;<font style="color:#666666;">Toll Free:</font></div>
				<div class="fleft" style="padding-left:5px;padding-top:9px;"><iframe src="/site/livehelpnohome.php" style="height:18px;width:107px !important;width:107px;text-align:left;" frameborder="0" scrolling="no"></iframe></div>
				<div class="fleft clr normtxt" style="padding-top:9px;">|&nbsp;&nbsp;<a href="/site/index.php?act=LiveHelp" class="clr1 normtxt">Live Help</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/site/index.php?act=contactus" class="clr1 normtxt">Contact Us</a></div>
			</div>
		</div>
	</div><div class="cleard"></div>
	<div class="fleft" style="width:100%;height:45px;background:url(http://img.muslimmatrimony.com/images/musmenbg.gif);">
	<!--- Main Menu Part -->
		<div style="width:772px;">
			<div class="normtxt clr2 fleft" style="width:475px;">
				<? if ($sessMatriId !="") { ?>
					<div onclick="window.location.href='<?=$confValues['SERVERURL']?>/profiledetail/'" class="<?=($varTopMenu=='profiledetail') && ($varAct=='') ? 'tlcenter clract fleft menust2' : 'tlcenter menclr fleft menust1';?>" id="myhome" onmouseover="document.getElementById('myhome').className='tlcenter fleft menust2';" onmouseout="document.getElementById('myhome').className='<?=(($varTopMenu=='profiledetail') && ($varAct=='')) ? 'tlcenter fleft clract fleft menust2' : 'tlcenter fleft menust1'?>';" style="cursor:pointer;"><a class="padlr10 menclr" >My Home </a></div><div onclick="showhidediv('messagediv');hidediv('searchdiv'); return true;" class="<?=$varTopMenu=='mymessages' ? 'clract fleft tlcenter menust1' : 'menclr fleft tlcenter menust1';?>" class="fleft tlcenter menust1" id="menumsg" onmouseover="document.getElementById('menumsg').className='tlcenter fleft menust2';imgchange('mimg1');" onmouseout="document.getElementById('menumsg').className='<?=$varTopMenu=='mymessages' ? 'tlcenter fleft clract fleft menust2':'tlcenter fleft menust1'?>';imgchange('<?=$varTopMenu=='mymessages' ? 'mimg1':'mimg'?>');" style="cursor:pointer;"><a class="padlr10 menclr">Messages <span id="mimg" class="<?=$varTopMenu=='mymessages' ? 'pntr disnon' : 'pntr';?>" class="fleft tlcenter menust1" id="menumsg" onmouseover="document.getElementById('menumsg').className='tlcenter fleft menust2';"><img src="<?=$confValues['IMGSURL']?>/mmenuarr1.gif" border="0" /></span><span id="mimg1" class="<?=$varTopMenu=='mymessages' ? 'pntr' : 'pntr disnon';?>"><img src="<?=$confValues['IMGSURL']?>/mmenuarr2.gif" border="0"/></span></a></div><div onclick="showhidediv('searchdiv');hidediv('messagediv');return true;" class="<?=$varTopMenu=='search' ? 'clract fleft tlcenter menust1' : 'menclr fleft tlcenter menust1';?>" class="fleft tlcenter menust1" id="menusrch" onmouseover="document.getElementById('menusrch').className='tlcenter fleft menust2';imgchange('simg1');" onmouseout="document.getElementById('menusrch').className='<?=$varTopMenu=='search' ? 'tlcenter fleft clract fleft menust2':'tlcenter fleft menust1'?>';imgchange('<?=$varTopMenu=='search' ? 'simg1':'simg'?>');" style="cursor:pointer;"><a class="padlr10 menclr">Search <span id="simg" class="<?=$varTopMenu=='search' ? 'pntr disnon' : 'pntr';?>" class="fleft tlcenter menust1" id="menumsg" onmouseover="document.getElementById('menumsg').className='tlcenter fleft menust2';"><img src="<?=$confValues['IMGSURL']?>/mmenuarr1.gif" border="0" /></span><span id="simg1" class="<?=$varTopMenu=='search' ? 'pntr' : 'pntr disnon';?>"><img src="<?=$confValues['IMGSURL']?>/mmenuarr2.gif" border="0"/></span></a></div><div onclick="window.location.href='<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=primaryinfo'" class="<?=($varAct!='' && $varTopMenu=='profiledetail') || ($varTopMenu=='photo' || $varTopMenu=='horoscope')?'clract fleft tlcenter menust1 ':'menclr fleft tlcenter menust1'?>"  id="epro" onmouseover="document.getElementById('epro').className='tlcenter fleft menust2';" onmouseout="document.getElementById('epro').className='<?=($varAct!='' && $varTopMenu=='profiledetail') || ($varTopMenu=='photo' || $varTopMenu=='horoscope') ? 'tlcenter fleft clract fleft menust2' : 'tlcenter fleft menust1'?>';" style="cursor:pointer;"><a class="padlr10 menclr">Edit Profile</a></div><div onclick="window.location.href='<?=$confValues['SERVERURL']?>/payment/'" class="<?=$varTopMenu=='payment' ? 'clract fleft tlcenter menust1' : 'menclr fleft tlcenter menust1';?>" id="pnow" onmouseover="document.getElementById('pnow').className='tlcenter fleft menust2';" onmouseout="document.getElementById('pnow').className='<?=$varTopMenu=='payment' ? 'tlcenter fleft clract fleft menust2':'tlcenter fleft menust1'?>';" style="cursor:pointer;"><a class="padlr10 menclr">Pay Now</a></div>
				<? } else if ($varDomainPart2!='communitymatrimony'){ ?>
					
					<div onclick="window.location.href='<?=$confValues['SERVERURL']?>/'" class="<?=($varTopMenu=='profiledetail') && ($varAct=='') ? 'clract fleft menust1' : 'menclr fleft menust1';?>" id="myhome" onmouseover="document.getElementById('myhome').className='tlcenter fleft menust2';" onmouseout="document.getElementById('myhome').className='<?=(($varTopMenu=='profiledetail') && ($varAct=='')) ? 'tlcenter fleft menust1 clract fleft menust2' : 'tlcenter fleft menust1'?>';" style="cursor:pointer;"><a class="padlr10 menclr">Home&nbsp;&nbsp;</a></div>
					
					<div onclick="showhidediv('searchdiv');hidediv('messagediv');return true;" class="<?=$varTopMenu=='search' ? 'clract fleft tlcenter menust1' : 'menclr fleft tlcenter menust1';?>" class="fleft tlcenter menust1" id="menusrch" onmouseover="document.getElementById('menusrch').className='tlcenter fleft menust2';imgchange('simg1');" onmouseout="document.getElementById('menusrch').className='<?=$varTopMenu=='search' ? 'tlcenter fleft clract fleft menust2':'tlcenter fleft menust1'?>';imgchange('<?=$varTopMenu=='search' ? 'simg1':'simg'?>');" style="cursor:pointer;"><a class="padlr10 menclr">Search <span id="simg" class="<?=$varTopMenu=='search' ? 'pntr disnon' : 'pntr';?>" class="fleft tlcenter menust1" id="menumsg" onmouseover="document.getElementById('menumsg').className='tlcenter fleft menust2';"><img src="<?=$confValues['IMGSURL']?>/mmenuarr1.gif" border="0" /></span><span id="simg1" class="<?=$varTopMenu=='search' ? 'pntr' : 'pntr disnon';?>"><img src="<?=$confValues['IMGSURL']?>/mmenuarr2.gif" border="0"/></span></a></div>
 
					<div onclick="window.location.href='<?=$confValues['SERVERURL']?>/payment/'" class="<?=$varTopMenu=='payment' ? 'clract fleft tlcenter menust1' : 'menclr fleft tlcenter menust1';?>" id="pnow" onmouseover="document.getElementById('pnow').className='tlcenter fleft menust2';" onmouseout="document.getElementById('pnow').className='<?=$varTopMenu=='payment' ? 'tlcenter fleft clract fleft menust2':'tlcenter fleft menust1'?>';" style="cursor:pointer;"><a class="padlr10 menclr">Pay Now</a></div>
 
					<div onclick="window.location.href='<?=$confValues['SERVERURL']?>/register/'" class='fleft tlcenter menust1'; id="regis" onmouseover="document.getElementById('regis').className='tlcenter fleft menust2';" onmouseout="document.getElementById('regis').className='<?=$varTopMenu=='register' ? 'tlcenter fleft clract fleft menust2':'tlcenter fleft menust1'?>';" style="cursor:pointer;"><a class="padlr10 menclr">&nbsp;&nbsp;Register</a></div>
				
				<? } ?>
			</div>
			<div class="smalltxt clr2 topdiv fleft tlright" id="main" style="width:290px;"><font class="menclr1">
			<?
				if ($sessMatriId =="" && $varTopMenu!='login') {
				$varSrchPleftm = '68px';
				$varSrchPleftie = '68px';
				echo 'Already a Member? &nbsp;<a href="'.$confValues['SERVERURL'].'/login/" class="menclr1 bld">Login</a>';
			} elseif ($sessMatriId!='') { ?>
				<?=$varGetCookieInfo['NAME']?> (<?=$varGetCookieInfo['MATRIID']?>)  &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?=$confValues['SERVERURL']?>/login/logout.php" class="menclr1 bld">Logout</a>
			<? } else { $varSrchPleftm = '68px';$varSrchPleftie = '68px';echo '&nbsp;';} ?></font>
		   </div><br clear="all">
		</div>
	</div>
	
	<!--- Main Menu Part -->
</div>

<!-- Message menu content -->
	<div style="padding-left:84px !important;padding-left:87px;position:absolute;top:113px;">
		<div id="messagediv" class="layer" style="display:none;width:260px !important;width:275px;" onmouseout="document.getElementById('menumsg').className='<?=$varTopMenu=='mymessages' ? 'tlcenter fleft menust1 clract fleft menust2':'tlcenter fleft menust1'?>';imgchange('<?=$varTopMenu=='mymessages' ? 'mimg1':'mimg'?>');hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv');document.getElementById('menumsg').className='tlcenter fleft menust2';">			
			<div class="fleft" style="width:80px;">
				<font class="menclr1 bld">Messages</font><br><img src="<?=$confValues['IMGSURL']?>/oarrow.gif" hspace="5" />
				<a class="menclr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RMALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Received</a><br><img src="<?=$confValues['IMGSURL']?>/oarrow.gif" hspace="5" />
				<a class="menclr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Sent</a>
			</div>
			<div class="fleft" style="background:url(<?=$confValues['IMGSURL']?>/versep2.gif) repeat-y;height:60px;width:1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>


			<div class="fleft" style="width:80px !important;width:90px;padding-left:10px;">
				<font class="menclr1 bld">Interests</font><br><img src="<?=$confValues['IMGSURL']?>/oarrow.gif" hspace="5" />
				<a class="menclr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RIALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Received</a><br><img src="<?=$confValues['IMGSURL']?>/oarrow.gif" hspace="5" />
				<a class="menclr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SIALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Sent</a>
			</div>
			<div class="fleft" style="background:url(<?=$confValues['IMGSURL']?>/versep2.gif) repeat-y;height:60px;width:1px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>


			<div class="fleft" style="width:75px !important;width:85px;padding-left:10px;">
				<font class="menclr1 bld">Requests</font><br><img src="<?=$confValues['IMGSURL']?>/oarrow.gif" hspace="5" />
				<a class="menclr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Received</a><br><img src="<?=$confValues['IMGSURL']?>/oarrow.gif" hspace="5" />
				<a class="menclr1" href="<?=$confValues['SERVERURL']?>/mymessages/?part=SRALL" onclick="hidediv('messagediv'); return true;" onmouseover="showdiv('messagediv'); return true;">Sent</a>
			</div>
	
		</div>
	</div>
	<!-- Message menu content -->

	<!-- Saved Search menu content -->
	<div style="padding-left:<?=$varSrchPleftm;?> !important;padding-left:<?=$varSrchPleftie;?>;position:absolute;top:113px;">
		<div id="searchdiv" class="smalltxt layer" style="display:none;width:<?=$varFFWidth?> !important;width:<?=$varIEWidth?>;padding-right:0px;" onmouseout="document.getElementById('menusrch').className='<?=$varTopMenu=='search' ? 'tlcenter fleft menust1 clract fleft menust2':'tlcenter fleft menust1'?>';imgchange('<?=$varTopMenu=='search' ? 'simg1':'simg'?>');hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv');document.getElementById('menusrch').className='tlcenter fleft menust2';">
		<div class="fleft" style="padding-right:5px;"><font class="bld menclr1">Search options</font><br><a class="menclr1" href="<?=$confValues['SERVERURL']?>/search/" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Regular search</a><br>
		<a class="menclr1" href="<?=$confValues['SERVERURL']?>/search/index.php?act=advsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">Advanced search</a><br>
		<a class="menclr1" href="<?=$confValues['SERVERURL']?>/search/index.php?act=memidsearch" onclick="hidediv('searchdiv'); return true;" onmouseover="showdiv('searchdiv'); return true;">By Member Id search</a></div>
		<?=$varSrchCont;?>
		</div>
	</div>
	<!-- Search menu content -->

<br clear="all" />