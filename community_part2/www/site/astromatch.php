<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.inc');
?>

<div class="rpanel fleft">
		<div class="normtxt1 clr2 padb5 fleft" style="width:250px;"><font class="clr bld">Astro Match</font></div>
			<br clear="all">
		<div class="linesep"><img src="images/trans.gif" height="1" width="1" /></div>
			<div class="padt20 padl25">
				<div class="rpanelinner tljust">
					<div class="normtxt clr lh16">
						<b>AstroMatch</b> enables you to match horoscope to find out how compatible you are with a prospective life partner based on Birth Stars, Papasamya, Kujadosha and Dasasandhi. You can get your reports in North, South and West formats in English, Tamil, Malayalam, Hindi, Kannada and Telugu.<br><br>
						AstroMatch is a paid service and costs <b>Rs. 500 / US$ 15 for 50 AstroMatches</b> or <b>Rs. 750 / US$ 23 for 100 AstroMatches.</b><br><br>
						To do an AstroMatch we need the place, date and time of birth of both you and the person with whom you wish to match your horoscope.
					</div><br>
					<div class="normtxt clr lh16 fleft" style="width:350px !important;width:380px;padding-right:30px;">Denotes a horoscope generated by member. To match against this member just click on Match Horoscope to get real time Astro report.</div>
					<div class="fleft" style="height:50px;width:1px;background:url(<?=$confValues['IMGSURL']?>/versep.gif)"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="fleft padl25"><img src="<?=$confValues['IMGSURL']?>/astro-horos1.gif" /></div><br clear="all"><br>
					<div class="normtxt clr lh16 fleft" style="width:350px !important;width:380px;padding-right:30px;">Denotes a scanned horoscope added by member. To match against this member you need to enter his/her details available in scanned horoscope or you can request member for details.</div>
					<div class="fleft" style="height:50px;width:1px;background:url(<?=$confValues['IMGSURL']?>/versep.gif)"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="fleft padl25"><img src="<?=$confValues['IMGSURL']?>/astro-horos2.gif" /></div><br clear="all"><br>
					<div class="fright"><input type="button" class="button" value="Subscribe Now" onclick="javascript:window.location.href='<?=$confValues['SERVERURL']?>/payment/index.php?act=additionalpayment';" /></div>
				</div>
			</div>
		</div>