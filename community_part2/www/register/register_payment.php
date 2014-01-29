<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2011-03-15
# End Date		: 2011-03-15
# Project		: MatrimonyProduct
# Module		: Registration - Payment
#=============================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//INCLUDE FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

$varPrefix		= substr($sessMatriId,0,3);
$varDomainName  = $arrPrefixDomainList[$varPrefix];

//VARIABLE DECLARATIONS
$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$varModule	= 'payment';
?>
<div class="rpanel fleft">
<div class="normtxt lh16"><b>Congrats!</b> You have taken one step towards a lifetime of happiness. You can make your partner search<br> easier and faster by upgrading to Premium Membership.
<br><br>
</div>
<?
 
$varBannerContent ='<input type="hidden" name="checkOffer" '.$varSpecialOffer2.' value="'.$arrDiscountLevel[3].'">
   <div>
		<table cellpadding="0" cellspacing="0" width="557" align="left">
			<tr>
				<td align="left" background="'.$confValues['IMGSURL'].'/inter-title.gif" height="39" width="557">
					<table border="0" cellpadding="0" cellspacing="0" width="557">
						<tr>
							<td align="right" valign="middle" style="font:13px arial; color:#FDB335; padding-right:10px; padding-top:10px;"><b>Hurry!</b> Offer ends ';
							if($varOfferEndDate!=0){
								$varBannerContent .='on '.date("jS F Y", strtotime($varOfferEndDate));
						    }else{$varBannerContent .='today';}
							$varBannerContent .='</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" background="'.$confValues['IMGSURL'].'/inter-bg.gif" height="67" width="557">
					<table cellpadding="0" cellspacing="0" border="0" width="557" align="left" style="padding-left:45px; padding-top:10px;">
						<tr>
							<td align="center" style="font:bold 18px arial; color:#fff;">Next Level<br />Upgrade</td>
							<td style="font:normal 13px arial; color:#fff;padding-left:70px;">Pay for Gold & get SuperGold Membership<br />Pay for Super Gold & get Platinum Membership<br />Pay for Platinum & get Extra Phone Numbers<span style="color:#FDE835;">*</span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" background="'.$confValues['IMGSURL'].'/inter-bot.gif" height="34" width="557" style="font:11px arial;color:#EDE26E; padding-top:5px;">* Platinum ( 3 months ) - 15 extra phone nos. | Platinum ( 6 months ) - 20 extra phone nos.<br> Platinum ( 9 months ) - 25 extra phone nos.</td>
			</tr>
		</table>
	</div><br clear="all"><br clear="all">'; 
	?>

<?
include_once($varRootBasePath.'/www/payment/payment.php');
?>
</div>