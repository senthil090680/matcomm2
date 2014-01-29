<?php
$varMsgRadioDis	= 'disabled';
$varMsgRadioSel = '';
$varIntRadioSel = 'checked="checked"';
$varMsgDispCont	= '<center><div class="radiodiv1a normtxt"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="50"><br>To send message in your own words <br><a class="clr1 bld" href="'.$confValues['SERVERURL'].'/payment/">Become A Premium Member.</a></div></center>';
if($sessPaidStatus==1){
$varMsgRadioDis = '';
$varMsgRadioSel = 'checked="checked"';
$varMsgDispCont	= '<div id="radio1div0" class="disblk tlleft" style="padding-left:10px;"><iframe src="'.$confValues['SERVERURL'].'/mymessages/sendmail.php?currrec=99&type=mul&cont=search" style="margin: 0px; padding: 0px;" id="parentrte99" name="parentrte99" width="260" contenteditable="true" frameborder="0" height="140"></iframe></div>';
}
?>
<div id="msg1div99" class="disblk bgclr2" style="padding-left:8px;">
	<div id="replyDiv99"></div>
	<!--Interest Action Area Part-->
	<div class="smalltxt tlleft padtb10 fleft brdr bgclr2" style="width:245px;height:180px !important;height:210px;">
		<div class="smalltxt clr bld padb5" style="padding-left: 10px;"><input name="msgtype99" value="2" type="radio" <?=$varIntRadioSel;?>> Send templated message</div>
		<center>
		<div class="dotsep2" style="width: 210px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1"></div></center>
			<div id="radio2div99" class="disblk">
				<div class="fleft">
					<div class="radiodiv2 lh16" style="padding-top:8px;">
						<div class="fleft tlright" style="width:30px;padding-top:8px !important;"><input name="intopt99" value="1" id="intopt1" checked="checked" type="radio"></div><div class="fleft" style="width:200px !important;width:205px; padding-top:7px;padding-left: 5px;">I like your profile and I want to get in touch with you. Please Accept if interested too.</div><br clear="all">
						<div class="fleft tlright" style="width: 30px; padding-top: 8px ! important;"><input name="intopt99" value="2" id="intopt2" type="radio"></div><div class="fleft" style="width: 205px; padding-top: 7px; padding-left: 5px;">We have a lot in common and could make a good pair. Awaiting your reply.</div><br clear="all">
						<div class="fleft tlright" style="width: 30px; padding-top: 8px ! important;"><input name="intopt99" value="3" id="intopt3" type="radio"></div><div class="fleft" style="width: 205px; padding-top: 7px; padding-left: 5px;">Our children's profiles match. Can we contact you? Please reply.</div><br clear="all">
					</div>
				</div>
			</div>
		</div><div class="fleft" style="width: 5px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="5" height="1"></div>
		<!--Richtext Area Part-->
		<div class="smalltxt tlleft fleft brdr padtb10 bgclr2" style="width:270px !important;width:274px;height:180px !important;height:210px;">
		<div class="smalltxt clr bld padb5" style="padding-left: 10px;"><input name="msgtype99" value="1" type="radio" <?=$varMsgRadioDis?><?=$varMsgRadioSel;?>> Send personalized message</div>
		<?=$varMsgDispCont;?>
		<!--Richtext Area Part Ends-->
	</div>
	<div style="background-color: #FFF0D3;"><div class="fright padt10 padb5" style="padding-right:8px;" id="buttonSub99"><input class="button" value="Send Message" onclick="javascript:sendMulMsg();stylechange(1);" type="button"></div></div>
</div>
<!-- Search Options Ends-->
<br clear="all">