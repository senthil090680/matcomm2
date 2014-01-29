<?php
$varLiveHelp	= '1';
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

if($sessMatriId!=''){
if($sessPaidStatus == 0){$varRedirectUrl = $confValues['SERVERURL'].'/payment/index.php?act=payment&phstatus=1';}
else{$varRedirectUrl = $confValues['SERVERURL'].'/payment/index.php?act=additionalpayment&proHighlighter=1';}
}else{
$varRedirectUrl = $confValues['SERVERURL'].'/payment/index.php?act=payment&phstatus=1';
}

if($confValues["DOMAINCASTEID"] == '2500'){
	$varBgimg = 'prfpg-img1_cm.gif';
}else{
	$varBgimg = 'prfpg-img1.gif';
}

if($confValues["DOMAINCASTEID"] == '2503'){
	$varBgimg1 = 'prfpg-img2_mm.jpg';
}elseif($confValues["DOMAINCASTEID"] == '2500'){
	$varBgimg1 = 'prfpg-img2_cm.jpg';
}else{
	$varBgimg1 = 'prfpg-img2.jpg';
}
?>
	<!-- New design starts -->
	<form name="profileHighlighter" method="post" action="<?=$varRedirectUrl;?>">
	<div class="bgclr2 padb10" style="width:775px;">
		<div align="left" style="padding:12px 10px 5px 10px;" class="normtxt fnt17 clr bld">Profile Highlighter</div>
		<div align="left" class="bgclr5" style="margin:8px 10px;padding-left:30px;padding-top:20px;">
            <div style="width:695px;">
				<div class="fleft" style="width:347px;">
				<div style="width:287px;">
					<table cellspacing="0" cellpadding="0" border="0" align="center" width="287">
      				<tr>
					<td align="left" height="25" valign="top" class="normtxt clr bld">Feature your profile for better visibility</td>
					</tr>
					<tr>
					<td align="left" valign="top" class="smalltxt clr" style="text-align:justify">Get your profile highlighted on the home page of potential prospects and in search results in the form of an ad to get more visibility. This authenticates your profile and drives traffie to your profile.</td>
					</tr>
					<tr><td height="20"></td></tr>
					<tr>
					<td height="25" align="left" valign="top" style="font: bold 11px arial; color: rgb(58, 1, 72);">
					<div style="padding-top: 0px;" class="fleft"><img height="11" width="5" src="<?=$confValues['IMGSURL'];?>/prf-hgt-arrw.gif"></div>
					<div style="padding-left: 15px;width:250px;" class="fleft">Increase response from potential matches</div>
					</td>
					</tr>
					<tr>
					<td height="40" align="left" valign="top" style="font: bold 11px arial; color: rgb(58, 1, 72);">
					<div style="padding-top: 0px;" class="fleft"><img height="11" width="5" src="<?=$confValues['IMGSURL'];?>/prf-hgt-arrw.gif"></div>
					<div style="padding-left: 15px;width:250px;" class="fleft">Fastest way to get maximum results in a short span</div>
					</td>
					</tr>
					<tr>
					<td align="left" valign="top" class="dotsep2"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" width="287" height="1" /></td>
					</tr>
					<tr>
					<td align="left" valign="top" class="bgclr6 normtxt bld" style="padding:10px 10px;">Get Profile Highlighter at Rs.1200 for 2 months</td>
					</tr>
					<tr>
					<td align="left" valign="top" class="dotsep2"><img src="<?=$confValues['IMGSURL'];?>/trans.gif" width="287" height="1" /></td>
					</tr><tr><td height="20"></td></tr>
					<tr>
					<td align="left" valign="top" style="background:url(<?=$confValues['IMGSURL'];?>/<?=$varBgimg;?>) left top no-repeat;height:135px;">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td align="left" valign="top" class="smalltxt" style="padding-top:20px;padding-left:76px;">Profile Highligther is an Add-On package
								and cannot be availed independently.</td>
							</tr>
							<tr>
								<td align="left" valign="top" class="smalltxt" style="padding-top:10px;padding-left:76px;"><input type="submit" value="Go to Payment Options" class="button"></td>
							</tr>
						</table>
					</td>
					</tr>
      			  </table>
				</div>
			</div>
			<div class="fleft">
			<table cellspacing="0" cellpadding="0" border="0" width="348">
				<tr>
					<td align="left" valign="top"><img src="<?=$confValues['IMGSURL'];?>/<?=$varBgimg1;?>" width="348" height="299" /></td>
				</tr>
				<tr>
					<td align="center" valign="top">
					<div style="width:278px;padding:10px 10px;" class="bgclr6 normtxt bld">For further details about this service,<br><div class="fleft" style="padding-left:80px;">Call </div><div id="livehelpno2" class="fleft bld" style="color:#000;padding-left:4px;"></div><br clear="all"></div>
					</td>
					</tr>
						</table>

			</div>
			<br clear="all"><br clear="all"><br clear="all">
            </div>
		</div>
	</div></form>
<!-- New design ends -->