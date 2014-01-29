<?php

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath	= '/home/product/community';
$_SERVER["HTTP_HOST"] = 'www.'.$_REQUEST['domainFolder'].'matrimony.com';
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath."/conf/payment.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

##SESSION VARIABLE
$sessMatriId			= $_POST['matriId'];
$varCountryCode			= $_REQUEST["countryCode"];
$varAddress				= addslashes(strip_tags(trim($_REQUEST["address"])));
$varCity				= addslashes(strip_tags(trim($_REQUEST["city"])));
$varUSState				= addslashes(strip_tags(trim($_REQUEST["USState"]))); 
$varOtherState			= addslashes(strip_tags(trim($_REQUEST["otherstate"]))); 
$varZipCode				= addslashes(strip_tags(trim($_REQUEST["zipCode"]))); 
$varCountry				= trim($_REQUEST["country"]); 
$varState				= $varUSState ? $varUSState : $varOtherState;


if($sessMatriId =='') { header ("Location:".$confValues['SERVERURL']."/login/"); exit; }##if

##OBJECT DECLARATION
$objDB = new DB;
 
##CONNECT DB
$objDB->dbConnect('M',$varDbInfo['DATABASE']);


##INSERT PHONE NUMBER 
$varFields			= array('MatriId','PhoneNo','PaymentGateway','PaymentSource','Date_Captured');
$varFieldsValues	= array("'".$sessMatriId."'","'".$_POST["phoneNumber"]."'",'3','1','NOW()');
$objDB->insertOnDuplicate('onlinepaymentfailures', $varFields, $varFieldsValues, 'MatriId');

$varAmount			   = $_REQUEST["actualAmount"];
if($varCountryCode==21){ 
		$varShowAmount = $varAmount * $arrCurrToUsd[21];## EURO - EUR [ EUROPE COUNTRIES 21 ]
		$varShowAmount = round($varShowAmount);
}elseif($varCountryCode==220){
		$varShowAmount = $varAmount * $arrCurrToUsd[220];## UAE - AED [ UNITED ARAB EMIRATES 220 ]
		$varShowAmount = round($varShowAmount);
}elseif($varCountryCode==221){
		$varShowAmount = $varAmount * $arrCurrToUsd[221];## UK - GBP [ UNITED KINGDOM 221 ]
		$varShowAmount = round($varShowAmount);
}elseif($varCountryCode==162){
		$varShowAmount = $varAmount * $arrCurrToUsd[162];## PK - PKR [ PAKISTAN 162 ]
		$varShowAmount = round($varShowAmount);
}elseif($varCountryCode==98){
		$varShowAmount = $varAmount * $arrCurrToUsd[98];## Rs - Rs [ INDIA 98 ]
		$varShowAmount = round($varShowAmount);
} else { $varShowAmount = round($varAmount); }

##INSERT maxmindpaymentcapture TABLE
$varFields			= array('OrderId','MatriId','Product_Id','Currency','Amount_Paid','IP_Address','Billing_City','Billing_Region','Billing_Country','IP_ISP','Date_Captured');
$varFieldsValue	= array("'".$_REQUEST["vpc_MerchTxnRef"]."'","'".$sessMatriId."'","'".$_REQUEST["category"]."'","'USD'","'".$varShowAmount."'","'".$varAddress."'","'".$varCity."'","'".$varState."'","'".$varCountry."'","'".$varZipCode."'",'NOW()');
$objDB->insert('maxmindpaymentcapture', $varFields, $varFieldsValue);

$varCardExpiryYear	= $_POST['cardExpiryYear'];
$varCardExpiryMonth	= $_POST['cardExpiryMonth']; 
$_POST['vpc_CardExp']=$varCardExpiryYear.$varCardExpiryMonth; ##New Line


##RENEWAL PAYMENT
    if($_REQUEST["vpc_card"]=='AM'){$varCardType='AmericanEx';}else{$varCardType='Discover';}

	$varRenewalFields		= array('MatriId','OrderId','Product_Id','Currency','Amount_Paid','Card_Number','Expiry_Month','Expiry_Year','Payment_Gateway','IP_Address','Date_Captured','Card_Type');

	$varRenewalFieldsValues	= array("'".$sessMatriId."'","'".$_REQUEST["vpc_OrderInfo"]."'","'".$_REQUEST["category"]."'","'USD'","'".$varShowAmount."'",'AES_ENCRYPT('.str_replace(" ","",$_REQUEST["vpc_CardNum"]).',"password")',"'".$varCardExpiryMonth."'","'".$varCardExpiryYear."'",'5',"'".$_SERVER['REMOTE_ADDR']."'",'NOW()',"'".$varCardType."'");
	$objDB->insertOnDuplicate('onlinepaymentdetails', $varRenewalFields, $varRenewalFieldsValues, 'MatriId'); 


## FINISH TRANSACTION - Redirect the customers using the Digital Order
## ===================================================================

$varOnLoad = 'onLoad="javascript:document.frmRedirection.submit();"';
include_once($varRootBasePath.'/www/template/paymentheader.php');
?>
<form name="frmRedirection" action="<?=$varGlobalOptimalProcess?>" method="post" style="margin:0px;">
<?	
	## Add all the fields from the input form, except for the Submit Button and the VPCURL.
	##For Each item In Request.Form
	foreach($_POST as $key => $value) {
		if (strlen($value) > 0) {
?>
        	<input type="hidden" name="<?=$key?>" value="<?=str_replace(" ","",trim($value))?>"/>
<?             
    	}
	}
	
?>
<!-- attach SecureHash -->
<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="margin:0px;">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td valign="middle" class="textsmallbold">
						<table border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF">
							<tr>
								<td>&nbsp;</td><td class="smalltxt clr" style="line-height:18px;">
									<table border="0" cellspacing="0" cellpadding="0" width="693" align="center">
										<tr>
											<td valign="top" style="padding-top:20px;padding-left:25px;line-height:15px;">
												<table border="0" cellspacing="0" cellpadding="0" width="500">
													<tr>
														<td valign="top" class="brdr">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr> 
																	<td valign="top" class="normtxt1 clr3"  style="padding-left:12px;padding-top:6px;padding-bottom:5px;"><b><?=$confValues["PRODUCTNAME"]?>.Com</b></td>
																	<td valign="top" style="padding-top:8px;font:normal 11px verdana,arial;">&nbsp;Redirecting to payment gateway....</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
											<td></td>
										</tr>
										<tr>
										<td valign="top" colspan="2" style="padding-top:15px;font:normal 11px verdana,arial;line-height:15px;"><ul><li>&nbsp;&nbsp;You shall be taken to the payment gateway page to make payment.</li></ul></td>
										</tr>
										<tr>
											<td valign="top" colspan="2" style="padding-top:5px;padding-bottom:45px;font:normal 11px verdana,arial;line-height:15px;"><ul><li>&nbsp;&nbsp;If you are unable to connect to the payment gateway page, please <input type="button" class="button" value="Click" onClick="document.frmRedirection.submit()"> here.</li></ul></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	  </tr>
	</table>
</form> <br><Br>
<? include_once($varRootBasePath.'/www/template/paymentfooter.php');
UNSET($objDB);
?>