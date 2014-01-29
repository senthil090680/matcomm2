<?php
$varCommunityId=$confValues['DOMAINCASTEID'];
$varLiveHelp	= '1';
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$varPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

//AJAX CALL
$varMatriId = trim($_REQUEST['id']);

if ($sessMatriId != '') {
	$varPending		= '';
	$arrTools		= array();
	$arrTools		= $varPromotion['PENDINGTOOLS'];
	//print_r($arrTools);
	for ($i=sizeof($arrTools);$i>0;$i--){
		if (trim($arrTools[$i]) != ''){
			$varPending	.= $i."~";
		}
	}
	$varPending	=	trim($varPending,"~");
	$varTotal	= explode("~",$varPending);
	$arrContent= array();
	$arrContent['Voice'] ="Voice Adds Life ~ Voice makes your profile more convincing. Most prospects will be thrilled to hear you. Add your voice, get better chances of finding the right person in your life.~".$confValues['SERVERURL']."/tools/index.php?add=voice";
	$arrContent['Photo'] = "Photos Create Interest~Even if members aren't only interested in looks, they may end up looking at profiles with photos.~".$confValues['SERVERURL']."/tools/index.php?add=photo";
	$arrContent['Reference'] = "Reference Adds Value~Get your relatives and friends to add references about you. This will go a long way to give an authentic picture about you and will speed your match search.~".$confValues['SERVERURL']."/tools/index.php?add=reference";
	$arrContent['Video'] = "Get Noticed Instantly~A picture speaks a thousand words and a moving picture definitely a thousand more. Add FREE video now and make your profile more delightful!~".$confValues['SERVERURL']."/tools/index.php?add=video";
	$arrContent['PartPref'] = "Add Partner Details~It does a lot of good to set your partner preferences. It will help to focus your search for your perfect life partner. Set them today and get the best results! ~".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=ppedit&inview=2";
	$arrContent['Family'] = "Add Family Details~By adding details about your family you will make your profile more complete. So add information now and make it interesting for those who view your profile.~".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=familyedit&inview=2";
	$arrContent['Hobbies'] = "Fine Tune Your Profile~What are your hobbies? Every little detail about yourself is needed to make your profile complete. These details help to determine how perfect a partner you are. Add details on your pastime activity and fine tune your profile.~".$confValues['SERVERURL']."/profiledetail/index.php?act=myprofile&myid=yes&vtab=2&inname=hobbiesedit&inview=2";
	$varDisplay1	= '';
	$varDisplay2	= '';
	if (sizeof($varTotal)==2){
		$varDisplay1	= $arrContent[$arrTools[$varTotal[1]]];
	}elseif (sizeof($varTotal)>=3){
		$varDisplay1	= $arrContent[$arrTools[$varTotal[1]]];
		$varDisplay2	= $arrContent[$arrTools[$varTotal[2]]];
	}
}

?>
<div class="lpanel fright">
<center>

	<?php if($_REQUEST['act']=='fullprofilenew' && $sessMatriId!=$varMatriId ) {?>
		<div id="viewsimilardetails">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="getViewSimilarProfile('<?=$varMatriId?>');"/>
		</div>
	<?}?>


	<? if ($varPaidStatus ==1) { ?>
    <div class="fright">
	<div>
		<center>
         <?
        if($arrDomainInfo[$varDomain][2] == "muslim" || $arrDomainInfo[$varDomain][2] == "christian" || $arrDomainInfo[$varDomain][2] == "sikh" || $arrDomainInfo[$varDomain][2] == "Buddhist")
    	{
        ?>
        <img src="<?=$confValues['IMAGEURL']?>/images/paid_righthoroscope.gif" width="192" height="334" />
        <?php } else{?>
        <img src="<?=$confValues['IMAGEURL']?>/images/paid_right.gif" width="192" height="334" />
        <?}?>
	</center>
	</div>
    </div>
    <div style="margin-top:5px;width:190px;float:right;">&nbsp;</div>
	<br clear="all"/>
	<? } else { 
		
		?>
    <div class="fright wdth192" style="display:inline">
		<?if($varGetCookieInfo['MATRIID']=='' && $varDomain!='community'){?>
         <div class="fleft bgclr9 wdth192">
            <div class="fleft wdth192 bld fnt14" style="height:40px !important;height:50px;padding-top:10px;color:#ffffff"><center>Premium Membership <br />Benefits</center></div>
            <div class="wdth192 fleft mgnb7">
                <div class="disline fleft bgclr8" style="margin-left:10px;width:172px;">
                <div class="fleft"><img src="<?=$confValues['IMGSURL']?>/free-member-topbg.jpg"  width="172" height="9"/></div>
                <div class="wdth172 fleft bgclr10">
                    <div class="fleft mgnl15 mymgnt10 disline">
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div class="fleft clr8 bld normtxt" align="left" style="width:127px;">Send E-mails</div></div>
                        <div class="fleft dotsep6 padb5 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div align="left" class="fleft clr8 bld normtxt" style="width:127px;">Chat With Prospects</div></div>
                        <div class="fleft dotsep6 padb5 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div align="left" class="fleft clr8 bld normtxt" style="width:127px;">Contact Members<br />Directly</div></div>
                        <div class="fleft dotsep6 padb5 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <?
                         if($arrDomainInfo[$varDomain][2] == "muslim" || $arrDomainInfo[$varDomain][2] == "christian" || $arrDomainInfo[$varDomain][2] == "sikh" || $arrDomainInfo[$varDomain][2] == "buddhist")
    	                 {
                        ?>
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div align="left" class="fleft clr8 bld normtxt" style="width:127px;">Protect Photo / Phone </div></div>
                        <div class="fleft dotsep6 padb5 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <?}else{?>
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div align="left" class="fleft clr8 bld normtxt" style="width:127px;">View Horoscopes</div></div>
                        <div class="fleft dotsep6 padb5 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div align="left" class="fleft clr8 bld normtxt" style="width:127px;">Protect Photo / Horoscope / Phone</div></div>
                        <div class="fleft dotsep6 padb5 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <?}?>
                        <div class="fleft wdth150 padb5"><div class="fleft payimg1">&nbsp;</div><div align="left" class="fleft clr8 bld normtxt" style="width:127px;">Participate in Virtual Matrimony Meets</div></div>
                        <div class="fleft dotsep6 paydot1"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" /></div>
                        <div align="center" class="fleft mymgnt10 mymgnl10 disline" style="width:118px;">

                        <?
                        if($arrDomainInfo[$varDomain][2] == "muslim")
                    	{
                        ?>
                        <a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/musim_payfreebg.jpg" style="border:0px;" /></a>
                        <?}
                        elseif($arrDomainInfo[$varDomain][2] == "christian"){
                        ?>
                        <a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/chris_payfreebg.jpg" style="border:0px;" /></a>
                        <?}else{
                        ?>
                        <a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/payfreebg.jpg" style="border:0px;" /></a>
                        <?}?>
                        </div>
                    </div>
                </div>
                <div class="fleft"><img src="<?=$confValues['IMGSURL']?>/free-member-bttn-bg.jpg"  width="172" height="10"/></div>

                </div>
                <div class="wdth178 disline fleft mgnl7">
                    <div class="fleft mgnl15 mymgnt10 disline padb10">
                        <div class="fleft padb5" style="color:#ffffff">For payment related queries,<br /><div align="center"  class="fleft normtxt1 bld" style="padding-left:10px;padding-right:10px;">Call:</div><font class="normtxt1 bld"> <div id="livehelpno1" class="bld clr fleft" style="color:#ffffff"></div></font></div>
                    </div>
                </div>
            </div>
        </div>
		<? } else {
			if($arrDomainInfo[$varDomain][2] == "muslim") { $bgclass='mm';$col='#900A00';$tcol='#F5A62F';}
			else if($arrDomainInfo[$varDomain][2] == "christian") { $bgclass='cm';$col='#900A00';$tcol='#F5A62F';}
			else { $bgclass='cbs';$col='#900A00';$tcol='#F5A62F';}
		if ($varReebokOffer==1 && $varGetCookieInfo['OFFERTYPE'] !='' && trim($_COOKIE['liveHelpNo']) =='1-800-3000-2222' && (basename(dirname($_SERVER['PHP_SELF']))!='payment')){
		$varReebokOfferButton = 1;
		if ($varGetCookieInfo['OFFERTYPE']==1) { $varReebokOfferButton = 2;  }			
			?>

		<div style="background: url(<?=$confValues['IMGSURL']?>/rp-val-offer-bg.gif) no-repeat;width:178px;height:254px;border:1px solid #333;">
			<div style="position:absolute;margin-left:0px;width:178px;height:254px;"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="178" height="254" border="0"></a></div>
			<div style="padding:120px 0px 0px 0px;font-family:arial, tahoma;font-size:16px;text-align:center;line-height:16px;color:#FCFF00;"><b>Platinum & Super Gold<br><font style="letter-spacing:-1px; font-size:14px;">3,6,9 Months Membership</font></b></div>
			<div style="text-align:center;padding-top:8px;"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/rp-val-offer-button<?=$varReebokOfferButton?>.gif" width="112" height="28" alt="Upgrade Avail Offer" title="Upgrade Avail Offer" border="0"></a></div>
			<div style="padding:5px 0px 7px 0px;text-align:center;"><font style="font-family:Arial, Tahoma;font-size:11px;color:#FFF;"><b>Hurry! Offer valid ONLY TODAY</b></font></div>
			<div style="font:9px arial;line-height:11px;text-align:left;color:#ffffff;padding-left:10px;">Note: Reebok Watch delivery only <br>in India. Applicable only for Online<br> Payment.</div>
		</div>



		<? } else if($varGetCookieInfo['OFFERTYPE']==1  && (basename(dirname($_SERVER['PHP_SELF']))!='payment')) { 
			if($varCommunityId==2500  && (date('Y-m-d')=='2011-04-23' || date('Y-m-d')=='2011-04-24' || date('Y-m-d')=='2011-04-25')) {?>
			<table cellpadding="0" cellspacing="0" width="192">
				<tr><td align="left" valign="top" width="192" background="<?=$confValues['IMGSURL']?>/easter/rgt-img1-easren.jpg" height="81"></td></tr>
				<tr><td align="left" valign="top" width="192" background="<?=$confValues['IMGSURL']?>/easter/rgt-img2-easren.jpg" height="213">
				<table cellpadding="0" cellspacing="0" width="192" border="0">
				<tr><td align="center" valign="top" style="padding-top:8px;font:bold 20px arial;color:#ffffff;line-height:24px;">
				Avail <?=$varGetCookieInfo['OFFERPERCENTAGEVALUE']?>%<br>Discount<br><font style="color:#000000">Or</font><br>Next Level<br>Upgrade</td></tr>

				<tr><td align="center" valign="top"  style="padding-top:5px;">
				<a href="<?=$confValues['SERVERURL']?>/payment/" target="_blank">
				<img src="<?=$confValues['IMGSURL']?>/easter/renew.gif" border="0" /></a></td></tr>
				<tr><td align="center" valign="top" style="font:bold 13px arial;color:#000000;line-height:14px;">
				Offer valid till monday</td></tr>
				</table>
				</td></tr>
				<tr><td align="center" valign="top" background="<?=$confValues['IMGSURL']?>/easter/rgt-img3-easren.jpg" height="34" style="font:12px Arial;color:#ffffff;">For payment related queries<br /><div align="center"  class="fleft normtxt1 bld" style="padding-left:32px;padding-right:10px;color:#ffffff">Call:</div><font class="normtxt1 bld" color="#ffffff"> <div id="livehelpno1" class="bld fleft"></div></font></td></tr>    
			</table>
			<?}else{?>
			<!-- Percentage discount offer -->
			 <div class="wdth192" id="">
				<div class="cbsrenoffer">
					 <table border="0" cellpadding="0" cellspacing="0" width="150" align="center">
						<tr><td height="100" colspan="2"></td></tr>
						<tr><td align="center" class="menclr" colspan="2" style="font-size:20px;">Get <?=$varGetCookieInfo['OFFERPERCENTAGEVALUE']?>%<br> discount <br> <font style="color:#FDB335;font-weight:normal;">or</font> <br> Next Level <br>Upgrade</td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td colspan="2" align="center"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/special/availoffer_but_cbs.gif" border="0" /></a></td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td colspan="2" align="center" class="lh16" style="color:#FFFFFF;font-size:13px;"><b>Hurry! </b>Offer ends <?if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on <BR>'.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo '<BR>today';}?></td></tr>
					 </table>
				</div>
				<div class="fleft" style="width:192px; background-color:<?=$col?>">
                    <div class="fleft mgnl15 disline padb5">
                        <div class="fleft padb5" style="text-align:center; color:<?=$tcol?>">For payment related queries<br /><div align="center"  class="fleft normtxt1 bld" style="padding-left:10px;padding-right:10px;color:<?=$tcol?>">Call:</div><font class="normtxt1 bld" color="<?=$tcol?>"> <div id="livehelpno1" class="bld fleft"></div></font></div>
                    </div>
                </div>
			 </div>
			<!-- Percentage discount offer -->
			<?}?>
		<? } else if(($varGetCookieInfo['OFFERTYPE']==2 || ($varGetCookieInfo['OFFERTYPE']==3 && $varGetCookieInfo['OFFERSUBTYPE']==3)) && (basename(dirname($_SERVER['PHP_SELF']))!='payment')) {
			if($varCommunityId==2500  && (date('Y-m-d')=='2011-04-23' || date('Y-m-d')=='2011-04-24' || date('Y-m-d')=='2011-04-25')) {?>
			<table cellpadding="0" cellspacing="0" width="192">
				<tr><td align="left" valign="top" width="192" background="<?=$confValues['IMGSURL']?>/easter/rgt-img1-easfr.jpg" height="74"></td></tr>
				<tr><td align="left" valign="top" width="192" background="<?=$confValues['IMGSURL']?>/easter/rgt-img2-easfr.jpg" height="210">
				<table cellpadding="0" cellspacing="0" width="192" border="0">
				<tr><td align="center" valign="top" style="font:bold 16px arial;color:#F5FE08;padding-top:9px;">Next Level Upgrade</td></tr>

				<tr><td align="left" valign="top" style="padding-left:40px;font:11px arial;color:#ffffff;padding-top:7px;">Pay for Gold &<br> 
			get Super Gold Membership
			</td></tr>
				<tr><td align="left" valign="top" style="padding-left:40px;font:11px arial;color:#ffffff;padding-top:4px;">Pay for Super Gold &<br>
			get Platinum Membership
			</td></tr>
			<tr><td align="left" valign="top" style="padding-left:40px;font:11px arial;color:#ffffff;padding-top:4px;">Pay for Platinum &<br>
			get Extra Phone Numbers *
			</td></tr>

				<tr><td align="center" valign="top" style="padding-top:8px;">
				<a href="<?=$confValues['SERVERURL']?>/payment/" target="_blank">
				<img src="<?=$confValues['IMGSURL']?>/easter/avail.gif" border="0" /></a></td></tr>
				<tr><td align="center" valign="top" style="font:bold 12px arial;color:#000000;">
				Offer valid till monday</td></tr>
				<tr><td align="right" valign="top" style="padding-right:10px;font:9px arial;color:#ffffff;"><font style="color:#ffffff">*</font> Conditions Apply</td></tr>
				</table>

				</td></tr>
				<tr><td align="center" valign="middle"  background="<?=$confValues['IMGSURL']?>/easter/rgt-img3-easfr.jpg" height="44">
				<table cellpadding="0" cellspacing="0" width="192" border="0">
				<tr><td align="center" valign="top" style="font:12px Arial;color:#ffffff;">For payment related queries<br /><div align="center"  class="fleft normtxt1 bld" style="padding-left:32px;padding-right:10px;color:#ffffff">Call:</div><font class="normtxt1 bld" color="#ffffff"> <div id="livehelpno1" class="bld fleft"></div></font></td></tr>
				</table>
				</td></tr>
			</table>
			<?}else{?>
			<!-- Special offer -->
			<div class="wdth192" id="">
				<div class="cbsoffer">
					 <table border="0" cellpadding="0" cellspacing="0" width="150" align="center">
						<tr><td height="90" colspan="2"></td></tr>
						<tr><td align="left" class="menclr fnt15" colspan="2">Next Level Upgrade</td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td width="10" valign="top"><img src="<?=$confValues['IMGSURL']?>/special/banner_arrow.gif" vspace="3" /></td>
							<td width="140" class="menclr1 padb5" valign="top">Pay for Gold & get SuperGold Membership</td>
						</tr>
						<tr><td width="10" valign="top"><img src="<?=$confValues['IMGSURL']?>/special/banner_arrow.gif" vspace="3" /></td>
							<td width="140" class="menclr1 padb5" valign="top">Pay for Super Gold & get Platinum Membership</td>
						</tr>
						<tr><td width="10" valign="top"><img src="<?=$confValues['IMGSURL']?>/special/banner_arrow.gif" vspace="3" /></td>
							<td width="140" class="menclr1 padb5" valign="top">Pay for Platinum & get Extra Phone Numbers</td>
						</tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td colspan="2" align="center"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/special/availoffer_but_cbs.gif" border="0" /></a></td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td colspan="2" align="center" class="lh16" style="color:#FFFFFF;font-size:13px;"><b>Hurry! </b>Offer ends <?if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on <BR>'.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo '<BR>today';}?></td></tr>
					 </table>
				</div>
				<div class="fleft" style="width:192px; background-color:<?=$col?>">
                    <div class="fleft mgnl15 disline padb5">
                        <div class="fleft padb5" style="text-align:center; color:<?=$tcol?>">For payment related queries<br /><div align="center"  class="fleft normtxt1 bld" style="padding-left:10px;padding-right:10px;color:<?=$tcol?>">Call:</div><font class="normtxt1 bld" color="<?=$tcol?>"> <div id="livehelpno1" class="bld fleft"></div></font></div>
                    </div>
                </div>
			</div>
			<!-- Special offer -->
			<?}?>
		<? } else if($varGetCookieInfo['OFFERTYPE']==3  && (basename(dirname($_SERVER['PHP_SELF']))!='payment')) {?>
			<div class="wdth192" id="">
				<div class="cbsoffer">
					 <table border="0" cellpadding="0" cellspacing="0" width="150" align="center">
						<tr><td height="90" colspan="2"></td></tr>
						<?if($varGetCookieInfo['OFFERSUBTYPE']==1){?>
						<tr><td align="center" class="menclr" colspan="2" style="font-size:23px;">Flat <br> Discount</td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td align="center" class="menclr" colspan="2" style="font-size:23px;">Save up to<br> <?if($varGetCookieInfo['OFFERCURRENCYBASE']==98){ echo 'Rs. '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else if($varGetCookieInfo['OFFERCURRENCYBASE']==220){echo 'AED '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else if($varGetCookieInfo['OFFERCURRENCYBASE']==21){echo 'EURO '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else if($varGetCookieInfo['OFFERCURRENCYBASE']==222){echo 'USD '.$varGetCookieInfo['OFFERPACKAGEVALUE'];
						}else{echo 'GBP '.$varGetCookieInfo['OFFERPACKAGEVALUE'];}?></td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<?} else {?>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td align="center" class="menclr" colspan="2" style="font-size:23px;">Get <?=$varGetCookieInfo['OFFERPERCENTAGEVALUE']?>%<br> discount</td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<?}?>
						<tr><td colspan="2" align="center"><a href="<?=$confValues['SERVERURL']?>/payment/"><img src="<?=$confValues['IMGSURL']?>/special/availoffer_but_cbs.gif" border="0" /></a></td></tr>
						<tr><td height="10" colspan="2"></td></tr>
						<tr><td colspan="2" align="center" class="lh16" style="color:#FFFFFF;font-size:13px;"><b>Hurry! </b>Offer ends <?if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on <BR>'.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo '<BR>today';}?></td></tr>
					 </table>
				</div>
				<div class="fleft" style="width:192px; background-color:<?=$col?>">
                    <div class="fleft mgnl15 disline padb5">
                        <div class="fleft padb5" style="text-align:center; color:<?=$tcol?>">For payment related queries<br /><div align="center"  class="fleft normtxt1 bld" style="padding-left:10px;padding-right:10px;color:<?=$tcol?>">Call:</div><font class="normtxt1 bld" color="<?=$tcol?>"> <div id="livehelpno1" class="bld fleft"></div></font></div>
                    </div>
                </div>
			 </div>
		<?}}?>
    </div>
    <div class="fright wdth192" style="margin-top:5px;display:inline">
        &nbsp;
    </div>
	<? }?>
	
	<?if(basename(dirname($_SERVER['PHP_SELF']))=='profiledetail' && ($varAct=='myhome' || $varAct=='')) {
		include_once($varRootBasePath."/www/matchsummary/fphighlighter.php");
	}
	?>

	<?php if(($varCommunityId!=2007)&&($varCommunityId!=2008)){?>
	<div class="fright wdth192" style="display:inline;margin-bottom:10px;">
    <iframe src="<?=$confValues['IMAGEURL']?>/template/sucess.php" scrolling="no"  width="192" height="237" frameborder="0" id="succ_fra"></iframe>

    </div>
	<?php }?>
    <div class="fright wdth192" style="display:inline;">
    <div class="fright">
    <?if (($varAct!='register' && basename(dirname($_SERVER['PHP_SELF']))!='register') && (basename(dirname($_SERVER['PHP_SELF']))!='payment' && basename(dirname($_SERVER['PHP_SELF']))!='photo' && basename(dirname($_SERVER['PHP_SELF']))!='horoscope' && basename(dirname($_SERVER['PHP_SELF']))!='profiledetail')) { ?>
	<div class="lpanelinner1 brdr" style="padding-top:15px;padding-bottom:15px;">
		<center>
		<div class="lpanelinner1b">
		
	<iframe src="http://c1.zedo.com/jsc/c1/ff2.html?n=1405;c=1837;s=355;d8=;d5=;da=;d6=;d2=;d7=;d4=;d9=;d=7;w=160;h=600" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=160 height=600></iframe>

		</div>
		</center>
	</div><br clear="all">
<? } ?>
    </div>
    </div><br clear="all">
	<div class="fright wdth192" style="display:inline;">
    <div class="fright">
    	<div class="lpanelinner1 brdr" style="padding-top:15px;padding-bottom:15px;">
		<center>
		<div class="lpanelinner1b">
			<iframe src="/site/160x600-banner.html" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" allowTransparency="true" width="160" height="605"></iframe>
		</div>
		</center>
		</div><br clear="all"/>
	</div>
	</div>
</center>
</div>