<?php
#===================================================================================================
# File		   : myhome.php
# Author	   : Dhanapal, Senthilnathan
# Date		   : 29-Feb-2008
# Description  : MyHomePage.
#====================================================================================================

include_once($varRootBasePath."/conf/vmmconfig.cil14");
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/profilehome.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/opacity.js"></script>

<script type="text/javascript">

function changetab(tab,mode)
{
	if(tab=='mrec' && mode=='rcact')
	{
		$('mrec').className='fleft rcact';
		$('msnt').className='fleft stinact';
	}
	else if(tab=='msnt' && mode=='stinact')
	{
		$('mrec').className='fleft rcinact';
		$('msnt').className='fleft stact';
	}
	else if(tab=='mrec1' && mode=='rcact1')
	{
		$('mrec1').className='fleft rcact';
		$('msnt1').className='fleft stinact';
	}
	else if(tab=='msnt1' && mode=='stinact1')
	{
		$('mrec1').className='fleft rcinact';
		$('msnt1').className='fleft stact';
	}
	else if(tab=='mrec2' && mode=='rcact2')
	{
		$('mrec2').className='fleft rcact';
		$('msnt2').className='fleft stinact';
	}
	else if(tab=='msnt2' && mode=='stinact2')
	{
		$('mrec2').className='fleft rcinact';
		$('msnt2').className='fleft stact';
	}
}

</script>

<!-- NEW MyHome Starts -->
<?
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsLists.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/lib/clsPhone.php');

//OBJECT DECLARTION
$objCommon			= new clsCommon;
$objProfileDetail	= new ProfileDetail;
$objPhone			= new Phone;
$objClsDomain		= new domainInfo;

//$varTotalMsgCnt	=  $varTotMsgRcevCnt + $varTotMsgSentCnt + $varTotIntRecvCnt + $varTotIntSentCnt + $varTotReqRecvCnt + $varTotReqSentCnt;
//$varTotalRecd	= $varTotMsgRcevCnt + $varTotIntRecvCnt + $varTotReqRecvCnt;
//$varTotalSent	= $varTotMsgSentCnt + $varTotIntSentCnt + $varTotReqSentCnt;

$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$varPhotoStatus	= $varGetCookieInfo['PHOTOSTATUS'];
$varGender		= $varGetCookieInfo['GENDER'];
$sessPP			= $_COOKIE['partnerInfo'];

// PHOTO DISPLAY - STARTS //
//if (($varPhotoStatus==1) && ($sessMatriId !="")) {
if ($sessMatriId !="") {
	$varPhotoImgTag ='<img src="'.$confValues['IMGSURL'].'/noimg50_m.gif" width="75" height="75">'; //MALE
	if ($varGender==2){
		$varPhotoImgTag ='<img src="'.$confValues['IMGSURL'].'/noimg50_f.gif" width="75" height="75">';
	}//FEMALE

	$varSplit		= array();
	$varSplit		= split('~', trim($varGetCookieInfo['PHOTO']));
	$varPhotoName	= trim($varSplit[0]);
	$varPhotoAvailable	= trim($varSplit[1]);

	if (trim($varPhotoName) != '' && trim($varPhotoName) != '0' && count($varSplit) > 0) {
		if ($varPhotoAvailable == 1 and trim($varPhotoName)!='') {
			$varPhotoFolder = $varGetCookieInfo['MATRIID']{3}.'/'.$varGetCookieInfo['MATRIID']{4}.'/';
			$varPhotoUrl = $confValues['PHOTOURL'].'/'.$varPhotoFolder.$varPhotoName;
			$varPhotoImgTag = '<img src="'.$varPhotoUrl.'" width="75" height="75">';
		} elseif (($varPhotoAvailable == 0 or $varPhotoAvailable == 2) and (trim($varPhotoName)!='')) {
			$varPhotoUrl = $confValues['PHOTOIMGURL'].'/crop75/'.$varPhotoName;
			$varPhotoImgTag = '<img src="'.$varPhotoUrl.'" width="75" height="75">';
		}
	}
}
// echo $varPhotoImgTag;
// PHOTO DISPLAY -END //

// MEMBER SINCE & PAID OR FREE MEMBER CALCULATION - STARTS //
// MEMBER SINCE & PAID OR FREE MEMBER CALCULATION //
$varMemberSince = '';
$varPaidMemberSince = '';
$varPaidExpire = '';
if (trim($varGetCookieInfo['TIMECREATED']) != '') {
	$varMemberSince = date("F Y",strtotime($varGetCookieInfo['TIMECREATED']));
}
if (trim($varGetCookieInfo['LASTPAYMENT']) != '') {
	$varPaidMemberSince = date("jS F Y",strtotime($varGetCookieInfo['LASTPAYMENT']));
}
if (trim($varGetCookieInfo['EXPIRYDATE']) != '') {
	$varPaidExpire = date("jS F Y",strtotime($varGetCookieInfo['EXPIRYDATE']));
}
$varPaidStatusInfo = "Member since $varMemberSince.<div style='margin-top:2px;'>For best results & to contact prospects directly, <a href=\"".$confValues['SERVERURL']."/payment/\" class=\"clr1\"><b>become a Paid Member!</b></a></div>";
if (trim($varGetCookieInfo['PAIDSTATUS']) == 1) {
	$varPaidStatusInfo = "Member since $varPaidMemberSince. "; //'Paid membership valid for '.$varGetCookieInfo['VALIDDAYSLEFT'].' days';
	$varPrdPackageName = substr($arrPrdPackages[$varGetCookieInfo['PRODUCTID']],0,-8);
	/*if ($varGetCookieInfo['VALIDDAYSLEFT'] <= 15) {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | <a href="'.$confValues['SERVERURL'].'/payment/" class="smalltxt clr1">Renewal</a> pending on '.$varPaidExpire.'</font>';
	} else {
		 $varPaidStatusInfo .= '<br /><font class="smalltxt">Membership Type: '.$arrPrdPackages[$varGetCookieInfo['PRODUCTID']].' | Membership ends on '.$varPaidExpire.'</font>';
	}*/
	if ($varGetCookieInfo['VALIDDAYSLEFT'] <= 15) {
		 $varExpirepaidInfo .= 'Renewal due date : '.$varPaidExpire.'. &nbsp;<a href="'.$confValues['SERVERURL'].'/payment/" class="smalltxt clr1">Renew NOW</a></font>';
	} else {
		 $varExpirepaidInfo .= 'Renewal due date : '.$varPaidExpire.'';
	}
}
// MEMBER SINCE & PAID OR FREE MEMBER CALCULATION -ENDS //

// Getting Profile Info details - Complete_Now value
$arrProfileInfo = $objProfileDetail->getProfileInfo($sessMatriId);
// Getting Profile pending tools details
$varPendingToolLink = $objProfileDetail->profilePendingTools();

?>
<input type='hidden' id='partval' value=''>
 <? if ($sessMatriId!='') { ?>
<div style="width:558px;" class="bgclr2 fleft">
    <div align="left" class="fleft mymgnl10 mymgnt9 mymgnb10" style="display:inline;">
        <div align="center" style="width:85px;height:81px;padding-top:5px;" class="bgclr5">
            <a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoImgTag?></a>
        </div>
        <div align="center" class="mymgnt5"><a href="<?=$confValues['IMAGEURL']?>/photo/" class="smalltxt clr1"><?=$varPhotoStatus==1 ? 'Edit' : 'Add'?>&nbsp;Photos</a></div>
    </div>
    <div class="fleft" style="width:19px;">&nbsp;</div>
    <div class="fleft mymgnt10">
        <div style="height:25px; padding-top:5px">Hi! <b><?=(trim($varGetCookieInfo['USERNAME'])!=''?trim($varGetCookieInfo['USERNAME']):trim($varGetCookieInfo['NAME']))?> (<?=$varGetCookieInfo['MATRIID']?>),</b> Welcome to <?=$confValues['PRODUCTNAME']?></div>
        <div class="smalltxt">
            <table cellpadding="0" cellspacing="0" class="normtxt">
                <tr>
                    <td align="left" valign="top"><?=$varPaidStatusInfo?> <?php if (trim($varGetCookieInfo['PAIDSTATUS']) == 1) { echo $varPrdPackageName.' Membership valid for '.$varGetCookieInfo['VALIDDAYSLEFT'].' days' ; } ?></td>
                </tr>
				<?php if (trim($varGetCookieInfo['PAIDSTATUS']) == 1) {?>
                <tr>
                    <td align="left" valign="top"><?=$varExpirepaidInfo?>
					&nbsp;<a class="clr1 normtxt bld"
					href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=account">
					(Details)</a>
					</td>
                </tr>
				<?php }?>
            </table>
        </div>
    </div>
    <? if ($arrProfileInfo['Complete_Now']==0 || $varPendingToolLink != '') { ?>
           
			<!--- New design starts --->
			 <div id="warningdiv" class="fleft mymgnl10 bgclr5" style="width:538px;display:inline;">
				<div class="mymgnb10 mymgnt10 mymgnl10">
					<div class="fleft" style="width:25px;"><img src="<?=$confValues['IMGSURL']?>/myhomeinfo_img.gif"></div>
					<div class="fleft clr5 bld normtxt fnt14">A Complete Profile Will Qualify You For Marriage!&nbsp; <?php if($arrProfileInfo['Complete_Now']==0){ ?><a class="clr1 normtxt bld" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=completenow&ppstatus=1">
					Complete Now</a><?}?></div>
					<div class="fright padr10"><img src="<?=$confValues['IMGSURL']?>/close.gif" border="0" class="pntr" onclick="hidediv('warningdiv');" /></div><br clear="all">
					<?php if ($varPendingToolLink != '') {?>
					<div class="dotsep2" style="width:500px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div><br clear="all">
					<div class="fleft normtxt" style="width:95px;background:url(<?=$confValues['IMGSURL']?>/myhomeimg1.gif) no-repeat;height:29px;padding:6px 0px 0px 10px;">You need to</div>
					<? echo $objProfileDetail->profilePendingTools(); ?><br clear="all"/>
					<? } ?>
				</div>
			</div>
			<!-- New Design ends -->

			<? } ?>
    <div style="height:10px;width:523px;" class="fleft"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
</div>
<?}?>
<div class="rpanel mymgnt18 fleft">
<? if ($_FeatureMatchSummary==1) { ?>
<div id='msummary'>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="getMatchSummaryCount();"/>
</div>
<? } ?>
<div style="width:550px;float:left;height:20px;">&nbsp;</div>
<div style="width:290px;float:left;">
<div class="fleft">
<div class="mymgnt10 fleft mymgnl10" style="display:inline;">
   <div class="fleft" style="height:24px;">
        <div style="padding-top:5px;" class="normtxt1 bld">Messages</div>
   </div>
</div>
<div class="mymgnt10 fleft rcactr" id="rcactr">
   <div class="fleft rcact" id="mrec">
        <div align="center" style="padding-top:5px;"><a href="javascript:;" onclick="sitetab('Ldiv1',2);changetab('mrec','rcact');" id="L1" class="clr">Received</a></div>
   </div>
</div>
<div class="mymgnt10 fleft rcacts" id="rcacts">
   <div class="fleft stinact" id="msnt">
        <div align="center" style="padding-top:5px;"><a href="javascript:;" onclick="sitetab('Ldiv2',2);changetab('msnt','stinact');" id="L2" class="clr1">Sent</a></div>
   </div>
</div>
</div>
<div class="disblk fleft" style="width:290px;" id="Ldiv1">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
            <div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RMUNREAD" class="<?=($varGetCookieInfo['MAILRECEIVEDNEW']>0)?'clr1':'clr2 nopntr'?>">Unread Messages</a> (<?=$varGetCookieInfo['MAILRECEIVEDNEW']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RMREAD" class="<?=($varGetCookieInfo['MAILRECEIVEDREAD']>0)?'clr1':'clr2 nopntr'?>">Read Messages</a> (<?=$varGetCookieInfo['MAILRECEIVEDREAD']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RMREPLIED" class="<?=($varGetCookieInfo['MAILRECEIVEDREPLIED']>0)?'clr1':'clr2 nopntr'?>">Replied By Me</a> (<?=$varGetCookieInfo['MAILRECEIVEDREPLIED']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RMDECLINED" class="<?=($varGetCookieInfo['MAILRECEIVEDDECLINED']>0)?'clr1':'clr2 nopntr'?>">Declined By Me</a> (<?=$varGetCookieInfo['MAILRECEIVEDDECLINED']?>)</div>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
<div class="disnon fleft" style="width:270px;" id="Ldiv2">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
            <div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMUNREAD" class="<?=($varGetCookieInfo['MAILSENTNEW']>0)?'clr1':'clr2 nopntr'?>">Unread Messages</a> (<?=$varGetCookieInfo['MAILSENTNEW']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMREAD" class="<?=($varGetCookieInfo['MAILSENTREAD']>0)?'clr1':'clr2 nopntr'?>">Read Messages</a> (<?=$varGetCookieInfo['MAILSENTREAD']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMREPLIED" class="<?=($varGetCookieInfo['MAILSENTREPLIED']>0)?'clr1':'clr2 nopntr'?>">Replied By Members</a> (<?=$varGetCookieInfo['MAILSENTREPLIED']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SMDECLINED" class="<?=($varGetCookieInfo['MAILSENTDECLINED']>0)?'clr1':'clr2 nopntr'?>">Declined By Members</a> (<?=$varGetCookieInfo['MAILSENTDECLINED']?>)</div>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
</div>
<div style="float:left;width:270px;">
  <div class="fleft" style="width:270px;">
    <div class="mymgnt10 fleft mymgnl10" style="display:inline;">
       <div class="fleft" style="height:24px;">
            <div style="padding-top:5px;" class="normtxt1 bld">Interests</div>
       </div>
    </div>
    <div class="mymgnt10 fleft rcactr" id="icactr">
       <div class="fleft rcact" id="mrec1">
            <div align="center" style="padding-top:5px;"><a href="javascript:;" onclick="sitetab1('Ldivs1',2);changetab('mrec1','rcact1');" id="Ls1" class="clr">Received</a></div>
       </div>
    </div>
    <div class="mymgnt10 fleft rcacts" id="icacts">
       <div class="fleft stinact" id="msnt1">
            <div align="center" style="padding-top:5px;"><a href="javascript:;" onclick="sitetab1('Ldivs2',2);changetab('msnt1','stinact1');" id="Ls2" class="clr1">Sent</a></div>
       </div>
    </div>
</div>
<div class="disblk fleft" style="width:270px;" id="Ldivs1">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
            <div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RIPENDING" class="<?=($varGetCookieInfo['INTERESTRECEIVEDNEW']>0)?'clr1':'clr2 nopntr'?>">Reply Pending</a> (<?=$varGetCookieInfo['INTERESTRECEIVEDNEW']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RIACCEPTED" class="<?=($varGetCookieInfo['INTERESTRECEIVEDACCEPT']>0)?'clr1':'clr2 nopntr'?>">Accepted By Me</a> (<?=$varGetCookieInfo['INTERESTRECEIVEDACCEPT']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RIDECLINED" class="<?=($varGetCookieInfo['INTERESTRECEIVEDDECLINED']>0)?'clr1':'clr2 nopntr'?>">Declined By Me</a> (<?=$varGetCookieInfo['INTERESTRECEIVEDDECLINED']?>)</div>
            <div class="normtxt mymgnt5">&nbsp;</div>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
</div>
<div class="disnon fleft" style="width:270px;" id="Ldivs2">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
            <div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SIPENDING" class="<?=($varGetCookieInfo['INTERESTSENTNEW']>0)?'clr1':'clr2 nopntr'?>">Pending Interests</a> (<?=$varGetCookieInfo['INTERESTSENTNEW']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SIACCEPTED" class="<?=($varGetCookieInfo['INTERESTSENTACCEPT']>0)?'clr1':'clr2 nopntr'?>">Accepted Interests</a> (<?=$varGetCookieInfo['INTERESTSENTACCEPT']?>)</div>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SIDECLINED" class="<?=($varGetCookieInfo['INTERESTSENTDECLINED']>0)?'clr1':'clr2 nopntr'?>">Declined Interests</a> (<?=$varGetCookieInfo['INTERESTSENTDECLINED']?>)</div>
            <div class="normtxt mymgnt5">&nbsp;</div>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
<div style="width:550px;float:left;height:20px;">&nbsp;</div>
<div style="width:290px;float:left;">
<div class="fleft">
<div class="mymgnt10 fleft mymgnl10" style="display:inline;">
   <div class="fleft" style="height:24px;">
        <div style="padding-top:5px;" class="normtxt1 bld">Requests</div>
   </div>
</div>
<div class="mymgnt10 fleft rcactr" id="recactr">
   <div class="fleft rcact" id="mrec2">
        <div align="center" style="padding-top:5px;"><a href="javascript:;" onclick="sitetab2('Ldivse1',2);changetab('mrec2','rcact2');" id="Lse1" class="clr">Received</a></div>
   </div>
</div>
<div class="mymgnt10 fleft rcacts" id="recacts">
   <div class="fleft stinact" id="msnt2">
        <div align="center" style="padding-top:5px;"><a href="javascript:;" onclick="sitetab2('Ldivse2',2);changetab('msnt2','stinact2');" id="Lse2" class="clr1">Sent</a></div>
   </div>
</div>
</div>
<div class="disblk fleft" style="width:290px;" id="Ldivse1">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
            <div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRPHOTO" class="<?=($varGetCookieInfo['REQRECVPHOTOCNT']>0)?'clr1':'clr2 nopntr'?>">Photo Requests</a> (<?=$varGetCookieInfo['REQRECVPHOTOCNT']?>)</div>
			<? if ($confValues['DOMAINCASTEID'] != 2007 && $confValues['DOMAINCASTEID'] != 2008) { ?>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRPHONE" class="<?=($varGetCookieInfo['REQRECVPHONECNT']>0)?'clr1':'clr2 nopntr'?>">Phone Number Requests </a> (<?=$varGetCookieInfo['REQRECVPHONECNT']?>)</div>
			<? } ?>
			<? if ($objClsDomain->useHoroscope()==1) { ?>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=RRHOROSCOPE" class="<?=($varGetCookieInfo['REQRECVHOROSCOPECNT']>0)?'clr1':'clr2 nopntr'?>">Horoscope Requests</a> (<?=$varGetCookieInfo['REQRECVHOROSCOPECNT']?>)</div>
			<? } ?>
            <div class="normtxt mymgnt5">&nbsp;</div>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
<div class="disnon fleft" style="width:270px;" id="Ldivse2">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
            <div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SRPHOTO" class="<?=($varGetCookieInfo['REQSENTPHOTOCNT']>0)?'clr1':'clr2 nopntr'?>">Photo Requests</a> (<?=$varGetCookieInfo['REQSENTPHOTOCNT']?>)</div>
			<? if ($confValues['DOMAINCASTEID'] != 2007 && $confValues['DOMAINCASTEID'] != 2008) { ?>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SRPHONE" class="<?=($varGetCookieInfo['REQSENTPHONECNT']>0)?'clr1':'clr2 nopntr'?>">Phone Number Requests </a> (<?=$varGetCookieInfo['REQSENTPHONECNT']?>)</div>
			<? } ?>
			<? if ($objClsDomain->useHoroscope()==1) { ?>
            <div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/mymessages/?part=SRHOROSCOPE" class="<?=($varGetCookieInfo['REQSENTHOROSCOPECNT']>0)?'clr1':'clr2 nopntr'?>">Horoscope Requests</a> (<?=$varGetCookieInfo['REQSENTHOROSCOPECNT']?>)</div>
			<? } ?>
            <div class="normtxt mymgnt5">&nbsp;</div>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
</div>
<div style="float:left;width:270px;">
  <div class="fleft" style="width:270px;">
    <div class="mymgnt10 fleft mymgnl10" style="display:inline;">
       <div class="fleft" style="height:24px;">
            <div style="padding-top:5px;"  class="normtxt1 bld">Lists <? if ($confValues['DOMAINCASTEID'] != 2007 && $confValues['DOMAINCASTEID'] != 2008) { ?>/ Views<? } ?></div>
       </div>
    </div>
</div>
<div class="disblk fleft" style="width:270px;">
    <div><img src="<?=$confValues['IMGSURL']?>/mss1.gif" /></div>
    <div style="background:url(<?=$confValues['IMGSURL']?>/mss2.gif) left top repeat-y;">
        <div style="padding-left:20px;">
			<div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/list/index.php?act=listshowall&listtype=SL" class="<?=($varGetCookieInfo['SHORTLISTCNT']>0)?'clr1':'clr2 nopntr'?>">Favourites</a> (<?=$varGetCookieInfo['SHORTLISTCNT']?>)</div>
			<div class="normtxt mymgnt5"><a href="<?=$confValues['SERVERURL']?>/list/index.php?act=listshowall&listtype=BK" class="<?=($varGetCookieInfo['BLOCKLISTCNT']>0)?'clr1':'clr2 nopntr'?>">Blocked Profiles</a> (<?=$varGetCookieInfo['BLOCKLISTCNT']?>)</div>
			<? if ($confValues['DOMAINCASTEID'] != 2007 && $confValues['DOMAINCASTEID'] != 2008) { ?>
            <div class="dotsep2 mymgnt10" style="width:220px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
            <div class="normtxt mymgnt5" style="height:24px;"><a href="<?=$confValues['SERVERURL']?>/phone" class="<?=($varGetCookieInfo['VIEWSPHONEBYOTHERCNT']>0)?'clr1':'clr2 nopntr'?>">Who Viewed My Phone Number</a> (<?=$varGetCookieInfo['VIEWSPHONEBYOTHERCNT']?>)</div>
			
			<div class="normtxt" style="height:24px;"><a href="<?=$confValues['SERVERURL']?>/phone/index.php?act=phoneviewedbyme" class="<?=($varGetCookieInfo['VIEWSPHONEBYMECNT']>0)?'clr1':'clr2 nopntr'?>">Phone Number Viewed By Me</a> (<?=$varGetCookieInfo['VIEWSPHONEBYMECNT']?>)</div>

			<div class="normtxt"><a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=whoviewdmyprofile" class="<?=($varGetCookieInfo['VIEWSPROFILEBYOTHERCNT']>0)?'clr1':'clr2 nopntr'?>">Who Viewed My Profile</a> (<?=$varGetCookieInfo['VIEWSPROFILEBYOTHERCNT']?>)</div>

			<? } ?>
        </div>
    </div>
    <div><img src="<?=$confValues['IMGSURL']?>/mss3.gif" /></div>
</div>
</div>
<div style="width:550px;float:left;height:20px;">&nbsp;</div>
<div class="dotsep2" style="width:550px;float:left;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<div>
<? if ($_FeatureMatchSummary==1) { ?>
<br clear="all">
<div id='recomsummary'>
</div>
<? } ?>
</div>
<div style="width:550px;float:left;height:20px !important;height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
<div class="rpanelinner" id="twitinputdiv" style="display:block;">
		<div class="fleft padt5 smalltxt" style="width:50px;height:50px;"><img src="<?=$confValues['IMGSURL']?>/mytwtt.jpg" /></div>
		<div class="fleft tlleft normtxt" style="padding-top:5px;"><b>Got Twitter Account?</b><br> <a class="clr1" href="/profiledetail/index.php?act=primaryinfo">Add it to your profile</a> and let members know what you're up to! &nbsp;|&nbsp; <a class="clr1" href="/site/index.php?act=twithelp">How it works?</a></div>
	</div>
    <br clear="all" /><br clear="all" /><br clear="all" />
</div>
</div>
<? if ($confValues['DOMAINCASTEID'] == 2007 || $confValues['DOMAINCASTEID'] == 2008) { $_GET["promo"]='no'; } ?>
<?if ($_GET["promo"]=='yes') { ?>
	
	<!-- Renewal Offer -->
	<div id="lightpic1" class="frdispdiv" style="width: 500px;">
		<?if($confValues['DOMAINCASTEID'] == 2500 && (date('Y-m-d')=='2011-04-23' || date('Y-m-d')=='2011-04-24' || date('Y-m-d')=='2011-04-25')) {?>
		<table cellpadding="0" cellspacing="0" width="458">
			<tr><td align="left" valign="top" width="458" background="<?=$confValues['IMGSURL']?>/easter/sys-img1-easren.jpg" height="84">
			<table cellpadding="0" cellspacing="0" border="0" width="458">
			<tr><td align="right" valign="top" style="padding-right:5px;padding-top:5px;"><a onclick="document.getElementById('lightpic1').style.display='none'; document.getElementById('fade').style.display='none';" style="outline:none;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" style="display: inline;" width="50" valign="top" border="0" height="13"></a></td></tr>    
			</table>
			</td></tr>

			<tr><td align="left" valign="top" width="458" background="<?=$confValues['IMGSURL']?>/easter/sys-img2-easren.jpg" height="156">
			<table cellpadding="0" cellspacing="0" width="458">
			<tr><td align="left" valign="top" style="padding-top:10px;">
			<table cellpadding="0" cellspacing="0" width="458" border="0">
			 <tr>
			  <td align="left" valign="top" width="10">&nbsp;</td>
					  <td align="left" valign="top" width="127">
				  <table cellpadding="0" cellspacing="0" width="127">
				  <tr><td align="center" valign="top" style="font:bold 18px Arial;color:#ffffff">Avail<br /><?=$varGetCookieInfo['OFFERPERCENTAGEVALUE']?>%<br>Discount</td></tr>

			  </table>
			  </td>
			  <td align="left" valign="top" width="237" style="padding-left:10px;">
			  <table cellpadding="0" cellspacing="0" width="236">
			  <tr><td align="left" valign="top" style="font:bold 18px Arial;color:#ffffff;padding-left:10px;">Next Level Upgrade</td></tr>
			  <tr><td align="left" valign="top" style="font:12px Arial;color:#ffffff;padding-top:5px;">
			   <table cellpadding="0" cellspacing="0" width="236">
					  <tr><td align="left" valign="top" height="10" width="10"><img src="<?=$confValues['IMGSURL']?>/easter/arrow.gif" width="6" height="7" alt="" vspace="3" /></td><td align="left" valign="top" style="font:11px arial;color:#ffffff" width="226">Pay for Gold & get SuperGold Membership</td></tr>

					  <tr><td align="left" valign="top" height="10" width="10"><img src="<?=$confValues['IMGSURL']?>/easter/arrow.gif" width="6" height="7" alt="" vspace="3" /></td><td align="left" valign="top" style="font:11px arial;color:#ffffff" width="226">Pay for Super Gold & get Platinum Membership</td></tr>
					  <tr><td align="left" height="10" width="10"><img src="<?=$confValues['IMGSURL']?>/easter/arrow.gif" width="6" height="7" alt="" vspace="3" /></td><td align="left" valign="top" style="font:11px arial;color:#ffffff" width="226">Pay for Platinum & get Extra Phone Numbers<font style="color:#ffffff">*</font></td></tr>
					  </table>
			  </td></tr>
			  </table>
			  </td>

			  
			  </tr>
			</table>
			</td></tr>
			<tr><td align="center" valign="top" style="padding-top:10px;"><a href="<?=$confValues['SERVERURL']?>/payment/" target="_blank"><img src="<?=$confValues['IMGSURL']?>/easter/sys-renew.gif" border="0"/></a></td></tr>
				<tr><td align="center" valign="top" style="font:bold 13px arial;color:#000000;">Offer valid till monday</td></tr>
			</table>
			</td>
			</tr>

			<tr><td valign="top" align="left" style="padding-left:10px;padding-top:5px;font: 11px arial; color: #000000;" background="<?=$confValues['IMGSURL']?>/easter/sys-img3-easren.jpg" height="38"><span style="color:#ffffff">*</span> Platinum ( 3 months ) - 15 extra phone nos.  |  Platinum ( 6 months ) - 20 extra phone nos.<br><center>Platinum ( 9 months ) - 25 extra phone nos.</center></td>
				</tr>
		</table>
		<?}else{?>
		<div style="width:458px;background-color:#910A00;">
			<div style="padding:0px 9px 10px 9px;">
				<div style="background:url(<?=$confValues['IMGSURL']?>/pop-renoffer.jpg);width:438px;height:70px;" valign="top"><a onclick="document.getElementById('lightpic1').style.display='none'; document.getElementById('fade').style.display='none';"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="55" height="17" align="right" /></a></div>
				<div style="background: url(<?=$confValues['IMGSURL']?>/sys-pop-offer-bg.gif) no-repeat;width:438px;height:199px;">
					<div class="tlcenter">
						<div style="padding:25px 0px 10px 0px;font-size:20px;color:#FFFFFF;font-weight:bold;">Get <?=$varGetCookieInfo['OFFERPERCENTAGEVALUE']?>% discount</b></font></div>
						<div style="padding:0px;font-size:20px;color:#FDB335;">or</font></div>
						<div style="padding:10px 0px 20px 0px;font-size:20px;color:#FFFFFF;font-weight:bold;">Next Level Upgrade</b></font></div>
						<div><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/sys-pop-avail-button.gif" width="148" height="42" border="0" alt="Avail Offer Now" title="Avail Offer Now"></a></div>
						<div style="padding:10px 0px 10px 0px;font-size:12px;color:#FDB335;font-weight:normal;"><b>Hurry!</b> Offer ends <?if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on '.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo 'today';}?></div>
					</div>
				</div>
				</div>
                <div style="padding:5px 0px 5px 10px;color:#EDE26E;" class="smalltxt"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
			</div>
		<?}?>
	</div>

	<!-- Renewal Offer -->

	<!-- Special Offer -->
	<div id="lightpic2" class="frdispdiv" style="width: 500px;">
		<?if($confValues['DOMAINCASTEID'] == 2500  && (date('Y-m-d')=='2011-04-23' || date('Y-m-d')=='2011-04-24' || date('Y-m-d')=='2011-04-25')) {?>
			<table cellpadding="0" cellspacing="0" width="458">
				<tr><td align="left" valign="top" width="458" background="<?=$confValues['IMGSURL']?>/easter/sys-img1-easfr.jpg" height="111">
				<table cellpadding="0" cellspacing="0" border="0" width="458">
				<tr><td align="right" valign="top" style="padding-right:5px;padding-top:5px;"><a onclick="document.getElementById('lightpic2').style.display='none'; document.getElementById('fade').style.display='none';" style="outline:none;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" style="display: inline;" width="50" valign="top" border="0" height="13"></a></td></tr>    
				</table>
				</td></tr>

				<tr><td align="left" valign="top" width="458" background="<?=$confValues['IMGSURL']?>/easter/sys-img2-easfr.jpg" height="167">
				<table cellpadding="0" cellspacing="0" width="458">
				<tr><td align="left" valign="top"  style="padding-top:13px;">
				<table cellpadding="0" cellspacing="0" width="458" border="0">
				<tr><td align="left" valign="top" style="font:bold 22px Arial;color:#ffffff;padding-left:50px;">Next Level Upgrade</td></tr>
				 <tr><td align="left" valign="top"  style="padding-left:70px;">
					<table cellpadding="0" cellspacing="0" width="348" border="0">
					<tr><td align="left" valign="top" style="padding-top:10px;"><a href="<?=$confValues['SERVERURL']?>/payment/" target="_blank"><img src="<?=$confValues['IMGSURL']?>/easter/sys-avail.gif" border="0"/></a></td></tr>

					<tr><td align="left" valign="top" style="padding-left:10px;padding-top:5px;font:bold 14px arial;color:#000000;">Offer valid till monday</td></tr>
					</table>
				</td></tr>
				</table>
				</td></tr>
				</table>
				</td>
				</tr>

				<tr><td align="left" valign="top" width="458" background="<?=$confValues['IMGSURL']?>/easter/sys-img3-easfr.jpg" height="23"></td></tr>
			</table>
		<?}else{?>
		<div style="width:458px;background-color:#910A00;">
			<div style="padding:0px 9px 0px;">
				<div style="background:url(<?=$confValues['IMGSURL']?>/pop-offer.jpg);width:438px;height:70px;" valign="top"><a onclick="document.getElementById('lightpic2').style.display='none'; document.getElementById('fade').style.display='none';"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="55" height="17" align="right" /></a></div>
				<div style="background: url(<?=$confValues['IMGSURL']?>/sys-pop-offer-bg.gif) no-repeat;width:438px;height:199px;">
					<div style="padding-left:75px;color:#FFF;" class="normtxt1">
						<div style="padding:20px 0px 10px 0px;font-size:20px;color:#FFFFFF;font-weight:bold;">Next Level Upgrade</b></font></div>
							<div style="padding:3px 0px;"><img src="<?=$confValues['IMGSURL']?>/sys-pop-bullet.gif" width="6" height="7" hspace="4">Pay for Gold & get SuperGold Membership</div>
							<div style="padding:3px 0px;"><img src="<?=$confValues['IMGSURL']?>/sys-pop-bullet.gif" width="6" height="7" hspace="4">Pay for Super Gold & get Platinum Membership</div>
							<div style="padding:3px 0px;"><img src="<?=$confValues['IMGSURL']?>/sys-pop-bullet.gif" width="6" height="7" hspace="4">Pay for Platinum & get Extra Phone Numbers<font color="#EDE26E">*</font></div>
					</div>
						<div class="tlcenter">
							<div style="padding-top:10px;"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/sys-pop-avail-button.gif" width="148" height="42" border="0" alt="Avail Offer Now" title="Avail Offer Now"></a></div>
							<div style="padding:10px 0px 10px 0px;font-size:12px;color:#FDB335;font-weight:normal;"><b>Hurry!</b> Offer ends <?if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on '.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo 'today';}?></div>
						</div>
					</div>
				</div>
				<div style="padding:5px 0px 5px 10px;color:#EDE26E;" class="smalltxt">* Platinum ( 3 months ) - 15 extra phone nos.&nbsp;&nbsp;|&nbsp;&nbsp;Platinum ( 6 months ) - 20 extra phone nos.<br>&nbsp;&nbsp;Platinum ( 9 months ) - 25 extra phone nos.</font>
				</div>
			</div>
		<?}?>
	</div>
	<!-- Special Offer -->

<!---- Reebok Offer starts here---->
<div id="lightpic4" class="frdispdiv" style="background: url(<?=$confValues['IMGSURL']?>/sys-popup-icc-bg.gif) no-repeat; width:468px; height:282px;">
<div style="float:right;padding-right:35px;"><a onclick="document.getElementById('lightpic4').style.display='none'; document.getElementById('fade').style.display='none';"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="55" height="17" align="right" /></a></div><div style='clear:both;'></div>
	<div style="padding: 35px 20px 0px 50px; text-align:center;">
			<div style="font: bold 19px arial;color:#FFF; padding:10px 0px 25px 85px; text-align:left; ">
			<div style="font: normal 18px arial;" >Pay Online Today &</div>
			Get <span style="font-size:28px;">Reebok</span> Watch FREE For<br/><span style="font-size:13px;color:#FCFF00;">Platinum & Super Gold 3,6,9 Months Membership</span></div>
	<? 	
	
		$varReebokOfferButton = 1;
		if ($varGetCookieInfo['OFFERTYPE']==1) { $varReebokOfferButton = 2;  }
	?>
		<a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/sys-popup-icc-button<?=$varReebokOfferButton?>.gif" width="147" height="46" border="0" alt=""></a><br/>
		<span style="color:#FFF;font:bold 16px arial;">Hurry! Offer valid ONLY TODAY</span>		
	</div>
	<center>
	<div style="padding:5px 30px 0px 0px;font:9px arial;line-height:13px;color:#ffffff;">Note: Reebok Watch delivery only in India.&nbsp;Applicable only for Online Payment. </div></center><br clear="all">
</div>

<!---- Reebok Offer ends here---->


	<!-- Offer available person (ex:TME offer person) -->
	<div id="lightpic3" class="frdispdiv" style="width: 500px;">
		<div style="width:458px;background-color:#910A00;">
			<div style="padding:0px 9px 0px;">
				<div style="background:url(<?=$confValues['IMGSURL']?>/pop-offer.jpg);width:438px;height:70px;" valign="top"><a onclick="document.getElementById('lightpic3').style.display='none'; document.getElementById('fade').style.display='none';"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="55" height="17" align="right" /></a></div>
				<div style="background: url(<?=$confValues['IMGSURL']?>/sys-pop-offer-bg.gif) no-repeat;width:438px;height:199px;">
					<?if($varGetCookieInfo['OFFERSUBTYPE']==1){?>
					<div style="padding-left:0px;color:#FFF;" class="normtxt1">
						<div style="padding:20px 0px 10px 0px;font-size:20px;color:#FFFFFF;font-weight:bold;"><center><b>Flat Discount</b></center></font></div>
						<div style="padding:20px 0px 10px 0px;font-size:20px;color:#FFFFFF;font-weight:bold;"><center><b>Save upto <?if($varGetCookieInfo['OFFERCURRENCYBASE']==98){ echo 'Rs. '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else if($varGetCookieInfo['OFFERCURRENCYBASE']==220){echo 'AED '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else if($varGetCookieInfo['OFFERCURRENCYBASE']==21){echo 'EURO '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else if($varGetCookieInfo['OFFERCURRENCYBASE']==222){echo 'USD '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else{echo 'GBP '.$varGetCookieInfo['OFFERPACKAGEVALUE'];}?></b></center></font></div>
					</div>
					<?}else{?>
					<div class="tlcenter">
						<div style="padding:25px 0px 10px 0px;font-size:20px;color:#FFFFFF;font-weight:bold;">Get <?=$varGetCookieInfo['OFFERPERCENTAGEVALUE']?>% discount</b></font></div>
					</div>
					<?}?>

					<div class="tlcenter">
						<div style="padding-top:10px;"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/sys-pop-avail-button.gif" width="148" height="42" border="0" alt="Avail Offer Now" title="Avail Offer Now"></a></div>
						<div style="padding:10px 0px 10px 0px;font-size:12px;color:#FDB335;font-weight:normal;"><b>Hurry!</b> Offer ends <?if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on '.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo 'today';}?></div>
					</div>
				</div>
			</div>
            <div style="padding:5px 0px 5px 10px;color:#EDE26E;" class="smalltxt"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
		</div>
	</div>
	<?//}?>

	<div id="fade" class="bgfadediv"></div>


	 <br clear="all" />

	<!-- NEW MyHome Ends -->

	<script language="javascript">
	function sel(divid){
		document.getElementById(divid).style.display='block';
		document.getElementById('fade').style.display='block';
		llcom();floatdiv(divid,lpos,100).floatIt();
	}
	function selclose(evId){
	document.getElementById(divid).style.display='none';
	document.getElementById('fade').style.display='none';
	}
	</script>

	<?

	//FOR CHECKING Reebok offer checking
	include_once($varRootBasePath.'/www/payment/ip2location.php');
	$varIPLocation = getIptoLocation(); // Returns like IN, BD, UK, US etc
	if ($varReebokOffer==1 && $varIPLocation=='IN' && $varGetCookieInfo['OFFERTYPE'] !=''){
		echo "<script>sel('lightpic4');</script>"; 

	}
	else if($varGetCookieInfo['OFFERTYPE']==1) {
		echo "<script>sel('lightpic1');</script>"; 
	} else if($varGetCookieInfo['OFFERTYPE']==2 || ($varGetCookieInfo['OFFERTYPE']==3 && $varGetCookieInfo['OFFERSUBTYPE']==3)) {
		echo "<script>sel('lightpic2');</script>"; 
	} else if($varGetCookieInfo['OFFERTYPE']==3) {
		echo "<script>sel('lightpic3');</script>"; 
	}
}
unset($objCommon);

include_once $varRootBasePath .'/www/cl/getoffers.php';
?>