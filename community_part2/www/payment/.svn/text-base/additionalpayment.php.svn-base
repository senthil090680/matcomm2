<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2006-06-19
# End Date		: 2006-06-19
# Project		: MatrimonyProduct
# Module		: Payment Option Page
#=============================================================================================================

//VARIABLE DECLARATIONS
$varCountryCode		= trim($_REQUEST['countryCode']);

if ($varCountryCode!='98' && $varCountryCode !="") { $varCountryCode='222'; $varUseCountryCode='222';  }

$varRootBasePath = '/home/product/community';
//INCLUDE FILES
include_once($varRootBasePath."/www/payment/paymentprocess.php");

//CHECK GATEWAY
if ($varUseCountryCode!=98) { $varCountryCode='222'; $varUseCountryCode='222';  }

if ($varUseCountryCode==98 && $varInrGateWayAvailable==1) { $varGateWay = 1;}
else if ($varUseCountryCode!=98 && $varUsdGateWayAvailable==1) { $varGateWay = 3; }

//VARIABLE DECLARATION
$sessMatriId	= $varGetCookieInfo['MATRIID'];

$varAddLocation	= $varCountryCode ? $varCountryCode : $arrCountryCurrency[$varIPLocation];

$localCurrOfferRate		= $arrConversionRate;
$localCurrOriginalRate	= $arrRate[$varUseCountryCode];
$varAstroPayment		= $_REQUEST["astro"];
$varProHighlighter		= $_REQUEST["proHighlighter"];

if ($varAstroPayment=='1'){
	$varLabel			= 'for 50 Astro Matches.';
	$varProductId		= '110';
	$varCheckedLabel	= ''; 
}elseif($varProHighlighter == '1'){
	$varLabel			= 'for 2 Months.';
	$varProductId		= '120';
	$varCheckedLabel	= 'CHECKED';
	$varAstroPayment	= '0';
}else {
	$varLabel			= '';
	$varAstroPayment	= '0';
	$varProductId		= '100';
	$varCheckedLabel	= 'CHECKED';
}


?>
<script language='javascript'>
	function funValidatePayment() {

		var frmPaymentOption = document.frmPaymentOption;
       
		if (frmPaymentOption.astroPayment.value!='0') {
			if(!(frmPaymentOption.category[0].checked) && !(frmPaymentOption.category[1].checked) && !(frmPaymentOption.category[2].checked))
			{
				alert("Please select the membership package.");
				frmPaymentOption.category[0].focus();
				return false;
			}//if
		}
		if(!(frmPaymentOption.paymentMode[0].checked) && !(frmPaymentOption.paymentMode[1].checked) && !(frmPaymentOption.paymentMode[2].checked)) {
			alert("Please select your payment mode.");
			frmPaymentOption.paymentMode[0].focus();
			return false;
		}//if
		
		if (frmPaymentOption.matriId.value !="") {

			if (frmPaymentOption.paymentMode[0].checked==true) { //[ ICICI Gateway ]

				frmPaymentOption.action ='<?=$varIciciGatewayUrl_VBV?>';

			} else if (frmPaymentOption.paymentMode[1].checked==true) {

				frmPaymentOption.action ='<?=$varCCAvenueRedirectUrl?>'; //[ CCAvenue ]

			} else if (frmPaymentOption.paymentMode[2].checked==true) {

				frmPaymentOption.action ='index.php?act=doorstep'; //[ DOOR STEP ]

			}
			else { frmPaymentOption.action ='<?=$varCCAvenueRedirectUrl?>'; } //[ CCAvenue ]
		}
		return true;
	}//funValidatePayment


function showdivs(divid,link,pref)
{
	var i;
	var divid1,link1;
	var cl="",cl1="";
	for(i=1;i<=7;i++)
	{
		if(pref=="sc"){divid1="cdv"+i;link1="clk"+i;cl="clr bld";cl1="clr1";}
		else if(pref=="sa"){divid1="dv"+i;link1="lk"+i;cl="divbox normtxt clr bld";cl1="divbox normtxt clr1";}
		if(link==link1){document.getElementById(divid1).style.display="block";document.getElementById(link1).className=cl;}
		else {document.getElementById(divid1).style.display="none";document.getElementById(link1).className=cl1;}
	}
}
</script>

<div class="rpanel fleft">
  <center>
	<div class="rpanelinner padt10">
		<div class="normtxt1 clr bld">
			1. Select Membership Package
		</div>
		<br clear="all" />

		<div style="width:500px;">
		<form method="POST" name="frmPaymentOption" action="<?=($sessMatriId=='') ? $confValues['SERVERURL']. '/login/' : $varCCAvenueRedirectUrl;?>" onSubmit="return funValidatePayment();">
		<input type="hidden" name="domainFolder" value="<?=substr($varDomainPart2,0,-9);?>">
		<input type="hidden" name="gateWay" value="<?=$varGateWay;?>">
		<input type="hidden" name="countryCode" value="<?=$varUseCountryCode;?>">
		<input type="hidden" name="frmPaymentSubmit" value="yes">
		<input type="hidden" name="matriId" value="<?=$sessMatriId;?>">
		<input type="hidden" name="offerAvailable" value="0">
		<input type="hidden" name="astroPayment" value="<?=$varAstroPayment?>">
		<input type="hidden" name="phPayment" value="<?=$varAstroPayment?>">



		<table width="400" align="center" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td class="normtxt clr smalltxt"><input type="radio" name="category" <?=$varCheckedLabel?> value="<?=$varProductId?>">&nbsp;<?=$varCurrencyCode.' '.$localCurrOfferRate[$varProductId].' '.$varLabel;?></td>
				</tr>
				<? if ($varAstroPayment=='1') { ?>
				<tr>
					<td class="normtxt clr smalltxt"><input type="radio" name="category" value="111">&nbsp;<?=$varCurrencyCode.' '.$localCurrOfferRate[111];?> for 100 Astro Matches.</td>
				</tr>
				<tr>
					<td class="normtxt clr smalltxt"><input type="radio" name="category" value="112">&nbsp;<?=$varCurrencyCode.' '.$localCurrOfferRate[112];?> for 150 Astro Matches.</td>
				</tr>
				<? } ?>
			</tbody>
		</table>
	</div><br clear="all"/>

		<!-- select membership package  end-->

		<!-- Select Payment Modes start-->
		<div class="normtxt1 clr bld">
			2. Select Payment Mode
		</div><br clear="all" />

		<div style="width:500px;">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="440">
			<tr>
				<td width="2%" class="normtxt tlright clr1 padr10" valign="bottom">&nbsp;</td>
				<td width="8%" valign="top"><input type="radio" name="paymentMode" value="varIciciGatewayUrl_VBV"> </td>
				<td width="90%" class="normtxt clr bld" style="line-height:25px;">Visa / Master Credit Card<br><img src="<?=$confValues['IMGSURL']?>/visa-card.gif" />&nbsp; <img src="<?=$confValues['IMGSURL']?>/master-card.gif"/></td>
			</tr>
			<tr>
				<td height="30" class="normtxt tlright clr1 padr10">&nbsp;</td>
				<td width="8%"><input type="radio" name="paymentMode" value="varCCAvenueRedirectUrl"></td>
				<td class="normtxt clr bld">Other Credit Cards/Netbanking Accounts</td>
			</tr>
			<tr>
				<td height="30" class="normtxt tlright clr1 padr10">&nbsp;</td>
				<td width="5%" valign="top"><input type="radio" name="paymentMode" value="payAtDoorStep" > </td>
				<td class="normtxt clr"><b>Pay at your Doorstep</b><br>
					<div style="width:400px;" class="tlleft padt5">
					<font class="clr3"><b>Request by e-mail</b></font><br>
					E-mail your address, phone number and convenient time for payment collection to <a href="mailto:doorstep@<?=strtolower($confValues['PRODUCTNAME'])?>.com" class="clr1">doorstep@<?=strtolower($confValues['PRODUCTNAME'])?>.com</a><br><br>
					<font class="clr3"><b>Request by Phone</b></font><br>
					You can also call 1-800-3000-2222 from anywhere in India and we'll have a representative from the nearest office in your city to collect the payment.
					</div><br clear="all">
				</td>
			</tr>
		</table>
		</div>
		<div class="rpanelinner tlright padtb10"><input type="submit" class="button" value="Pay Now" /></div>
		</form>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"/>
		
</div>
	</center>
</div><br clear="all">
<? include_once($varRootBasePath."/www/payment/paymentpagetracking.php"); ?>