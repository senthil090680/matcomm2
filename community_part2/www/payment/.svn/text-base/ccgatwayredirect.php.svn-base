<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/lib/clsCCAvenue.php");
include_once($varRootBasePath."/lib/clsDB.php");

//VARIABLLE DECLARATIONS
$varPaymentSubmit	= $_REQUEST['frmPaymentSubmit'];
$varCategory		= $_REQUEST['category'];
$varAddonCategory	= 120;
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varCountryCode		= $_REQUEST['countryCode'];
$varGateWay			= $_REQUEST['gateWay'];
$varCheckOffer      = $_REQUEST['checkOffer'];
$varProHighlighter  = $_REQUEST['proHighlighter'] ? $_REQUEST['proHighlighter'] : '0';
$varGateWay			= $varGateWay ? $varGateWay : '1';

//echo "<pre>";print_r($_REQUEST);exit;
include_once($varRootBasePath."/www/payment/paymentprocess.php");

//CHECK ALREADY LOGGED USER
if($sessMatriId =='') { header ("Location:../login/"); exit; }//if

if ($sessMatriId !="") {

//OBJECT DECLARATION
$objMasterDB= new DB;
$objCCAvenue= new CCAvenue;

$varProcess	= 'yes';
$varOnLoad	= '';

$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//CHECK IF MEMBER HAS ALREADY PAID OR NOT
$varFields		= array('User_Name','Valid_Days','Paid_Status','Last_Payment','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as DaysLeft','Name','Country','Residing_State','Contact_Address','Contact_Phone','Contact_Mobile');
$varCondition	= " WHERE MatriId =".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
$varExecute		= $objMasterDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$varPaidInfo	= mysql_fetch_array($varExecute);
$varCurrDays	= $varPaidInfo["Valid_Days"];
$varPaidStatus	= $varPaidInfo["Paid_Status"];
$varDatePaid	= $varPaidInfo["Last_Payment"];
$varDaysLeft	= ($varPaidInfo["DaysLeft"]>0)?$varPaidInfo["DaysLeft"]:0;
$varName		= $varPaidInfo["Name"];
$varCountryId	= $varPaidInfo["Country"];
$varCountryName	= $arrCountryList[$varCountryId];
$varState		= $varPaidInfo["Residing_State"];
$varAddress		= $varPaidInfo["Contact_Address"];
$varOrderId		= $sessMatriId.'-'.time();
$varPhone		= $varPaidInfo["Contact_Phone"];
$varTel			= $varPhone ? $varPhone : $varPaidInfo["Contact_Mobile"];
$varNoOfDays	= ($varCurrDays-$varDaysLeft);
$varMerchantParam	= $sessMatriId.'-'.$varCategory.'-'.$arrPkgValidDays[$varCategory].'-'.$varUseCountryCode;

//CHECK DISCOUNT FOR THIS MEMBER
$varOfferAvailable	= $varGetCookieInfo['OFFERAVAILABLE'];
$varOfferCategoryId = $varGetCookieInfo['OFFERCATEGORYID'];

if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

	if ($varOfferAvailable=='1' && ($varOfferCategoryId != $varRenewalOfferCategoryId)) {

			//SELECT OFFERCODEINFO//
			$varCondition	= " WHERE MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
			$varFields		= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation');
			$varExecute			= $objMasterDB->select($varTable['OFFERCODEINFO'], $varFields, $varCondition,0);
			$varMemberInfo		= mysql_fetch_array($varExecute);

			$varMemberDiscountINRFlatRate	= trim($varMemberInfo["MemberDiscountINRFlatRate"]);
			$varMemberDiscountAEDFlatRate	= trim($varMemberInfo["MemberDiscountAEDFlatRate"]);
			$varMemberDiscountUSDFlatRate	= trim($varMemberInfo["MemberDiscountUSDFlatRate"]);
			$varMemberDiscountEUROFlatRate	= trim($varMemberInfo["MemberDiscountEUROFlatRate"]);
			$varMemberDiscountGBPFlatRate	= trim($varMemberInfo["MemberDiscountGBPFlatRate"]);

			if ($varMemberDiscountINRFlatRate !="") {
				$varSplitFlatDiscount	= split('\|',$varMemberDiscountINRFlatRate); 
				$varDiscountAvail		= '98';
			} else if ($varMemberDiscountAEDFlatRate !="")  {
				$varSplitFlatDiscount	= split('\|',$varMemberDiscountAEDFlatRate); 
				$varDiscountAvail		= '220';
			} else if ($varMemberDiscountUSDFlatRate !="")  {
				$varSplitFlatDiscount	= split('\|',$varMemberDiscountUSDFlatRate);
				$varDiscountAvail		= '222';
			} else if ($varMemberDiscountEUROFlatRate !="") {
				$varSplitFlatDiscount	= split('\|',$varMemberDiscountEUROFlatRate);
				$varDiscountAvail		= '21';
			} else if ($varMemberDiscountGBPFlatRate !="")  {
				$varSplitFlatDiscount	= split('\|',$varMemberDiscountGBPFlatRate);
				$varDiscountAvail		= '221';
			}


			$arrSplitDiscount			= array();
			$arrDisplatAmountDiscount	= array();
			for($i=0;$i<count($varSplitFlatDiscount);$i++) {

				$varSplitDiscount			= split('~',trim($varSplitFlatDiscount[$i]));
				$varKey						= trim($varSplitDiscount[0]);

				if ($varDiscountAvail==$varUseCountryCode && $varDiscountAvail=='98') {

					$varValue			= trim($varSplitDiscount[1]);
				} else {

					$varDiscountAvailCurrency	= $arrCurrCode[$varDiscountAvail];
					if ($varDiscountAvailCurrency=='Rs.'){ $varDiscountAvailCurrency ='Inr'; }

					$varDiscountConvertCurrency	= $arrCurrCode[$varUseCountryCode];
					if ($varDiscountConvertCurrency=='Rs.'){ $varDiscountConvertCurrency ='Inr'; }

					$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

					if ($varDiscountAvail=='98'){
						$varValue1	= round(($varSplitDiscount[1]*$$varGetDiscount));
						$varConver	= 'varCurr'.ucwords(strtolower($arrCurrCode[$varUseCountryCode])).'ToInr';
						$varValue	= round($varValue1*$$varConver);

					} elseif ($varDiscountAvail=='220' || $varDiscountAvail=='222' || $varDiscountAvail=='221' || $varDiscountAvail=='21'){

						$varCurrencyName	= ucwords(strtolower($arrCurrCode[$varUseCountryCode]));
						if ($varCurrencyName=='Rs.'){ $varCurrencyName ='Inr'; }

						if ($varUseCountryCode=='98') {
							$varValue	= round(($varSplitDiscount[1]*$$varGetDiscount));
						} else {

							if ($varUseCountryCode=='220') {
								$varAed220Discount = 'varCurr'.$varCurrencyName.'ToInr';
								$varValue			= round(($varSplitDiscount[1]*$$varAed220Discount));
						}  else if($varUseCountryCode=='221'){

							$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

							$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
							$varGBPToInr	= 'varCurrGbpToInr';
							$varValue = round(($varValue1*$$varGBPToInr));

						}  else if($varUseCountryCode=='21'){

							$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

							$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
							$varEurToInr	= 'varCurrEurToInr';
							$varValue = round(($varValue1*$$varEurToInr));

						}  else if($varUseCountryCode=='222'){

							$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

							$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
							$varUsdToInr	= 'varCurrUsdToInr';
							$varValue = round(($varValue1*$$varUsdToInr));

						}else {
							$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

							$varValue = round(($varSplitDiscount[1]*$$varGetDiscount));
						}

					}

					$localCurrOriginalRate	= $arrRate[$varUseCountryCode];

					}

				}
				$arrSplitDiscount[$varKey]			= $varValue;
				$arrDisplatAmountDiscount[$varKey]	= $varValue1;
			}
			ksort($arrSplitDiscount);
			ksort($arrDisplatAmountDiscount);

	$varInrDiscountAmount			= round($arrSplitDiscount[$varCategory]);
	$varOtherCurrencyDiscountAmount	= round($arrDisplatAmountDiscount[$varCategory]);
	$varPackageCost					= $varAmount;
	if ($varInrDiscountAmount > 0) {
			$varAmount				= ($varAmount - $varInrDiscountAmount);
	
	if ($varUseCountryCode==98){ $varDisplayAmountPaid	= $varAmount; } else {
		$varDisplayAmountPaid	= ($arrRate[$varUseCountryCode][$varCategory]-$varOtherCurrencyDiscountAmount);
	}


			$varDiscountFlatRate	= $varInrDiscountAmount;
	}

	/*echo $varAmount;
	echo '<br>varOtherCurrencyToInr='.$$varOtherCurrencyToInr;
	echo '<br>InrDiscountAmount='.$varInrDiscountAmount;
	echo '<br>Final Amount='.$varAmount;exit;*/


	}//if
    else if($varOfferAvailable == 0 || ($varOfferAvailable ==1 && ($varOfferCategoryId == $varRenewalOfferCategoryId))) { // start by barani sept17-2010
$varOfferFields = array(
      20=>'MatriId',
      21=>'OfferCategoryId',
      22=>'OfferCode',
      23=>'OfferStartDate',
      24=>'OfferEndDate',
      25=>'DateUpdated',
	  26=>'OfferAvailedStatus');
 
$varOfferFieldsValues = array(
      20=>"'".$sessMatriId."'",
      21=>"'".$varRenewalOfferCategoryId."'",
      22=>"'".$sessMatriId."'",
      23=>'NOW()',
      24=>'DATE_ADD(NOW(),INTERVAL 3 DAY)',
      25=>'NOW()',
	  26=>'0');
 
$varMergeFields       = array_merge($varOfferFields,$arrDiscountFields);
$varMergeFieldsValues = array_merge($varOfferFieldsValues, $$varCheckOffer);
$varFields			  = array_values($varMergeFields);
$varFieldsValues	  = array_values($varMergeFieldsValues);


$varResult = $objMasterDB->insertOnDuplicate($varTable['OFFERCODEINFO'],$varFields,$varFieldsValues,'MatriId');

if($varResult === true) {
$varFields		 = array('OfferAvailable','OfferCategoryId');
$varFieldsValues = array(1,$varRenewalOfferCategoryId);
$varCondition	 = "MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
$varUpdateId	 = $objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
}

$varDiscountFlatRate	= 0;
$varDiscountPercentage	= 0;
$varPackageCost			= $varAmount;
 if($varCheckOffer == 'arrFlatDiscountValues') {
   $varDiscountFlatRate=$varSpecialOfferDiscountAmount;
   $varAmount				= $varAmount - $varDiscountFlatRate;
   $varDisplayAmountPaid	= $varAmount;
 }
 else if($varCheckOffer == 'arrPercentageValues') {
	$varDiscountPercentage  = (($varAmount * $varDiscountPercentageValue) / 100);
	$varAmount				= round($varAmount - $varDiscountPercentage);
	$varDiscountPercentage	= $varDiscountPercentageValue;

	$varActualDisplayAmountPaid	= ((($arrRate[$varUseCountryCode][$varCategory]) * $varDiscountPercentageValue) / 100);
	$varDisplayAmountPaid	= round(($arrRate[$varUseCountryCode][$varCategory]) - $varActualDisplayAmountPaid);

 }
} // end by barani

}

if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varPaidStatus == '1' && $varCategory !='120' && $varNoOfDays <= 10){

	$varProcess	= 'no';

	//PAYMENT MADE RECENTLY AND TRYING TO UPGRADE EITHER TO SAME MEMBERSHIP OR ALREADY PREMIUM MEMBER
	$varMessage	= 'You have recently made payment for Matrimony Id <b>'.$sessMatriId.'</b>. <br>The last payment was made on <b>'.$varDatePaid.'</b>. <br>A minimum of 10 days is required for subsequent payments. Please renew your membership after this period.';

} else {
		//SELECT CONTACT DETAILS
		$varAmount		= round($varAmount);
		$varFields		= array('Email');
		$varCondition	= " WHERE MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varSelectEmail	= $objMasterDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
		$varLoginInfo	= mysql_fetch_array($varSelectEmail);
		$varEmail		= $varLoginInfo['Email'];
        
		
		if ($varCountryId==222) { $varState = $arrUSAStateList[$varState]; }
		else if ( $varCountryId==98){ $varState = $arrResidingStateList[$varState]; }

		if($varUseCountryCode==222){ 
			$varPackageCost			 =  round($arrRate[$varUseCountryCode][$varCategory] * $arrCurrToInr[222]);
			$varDiscountFlatRate	 =  round($varOtherCurrencyDiscountAmount * $arrCurrToInr[222]);

		} else if($varUseCountryCode==21){ 
			$varPackageCost			 =  round($arrRate[$varUseCountryCode][$varCategory] * $arrCurrToInr[21]);
			$varDiscountFlatRate	 =  round($varOtherCurrencyDiscountAmount * $arrCurrToInr[21]);

		}else if($varUseCountryCode==220){
				$varPackageCost		 =  round($arrRate[$varUseCountryCode][$varCategory] * $arrCurrToInr[220]);
				$varDiscountFlatRate =  round($varOtherCurrencyDiscountAmount * $arrCurrToInr[220]);
		}else if($varUseCountryCode==221){
				$varPackageCost		 =  round($arrRate[$varUseCountryCode][$varCategory] * $arrCurrToInr[221]);
				$varDiscountFlatRate =  round($varOtherCurrencyDiscountAmount * $arrCurrToInr[221]);
		}else if($varUseCountryCode==162){
				$varPackageCost		 =  round($arrRate[$varUseCountryCode][$varCategory] * $arrCurrToInr[162]);
				$varDiscountFlatRate =  round($varOtherCurrencyDiscountAmount * $arrCurrToInr[162]);
		}

		$varDisplayAmountPaid = $varDisplayAmountPaid ? $varDisplayAmountPaid : $arrRate[$varUseCountryCode][$varCategory];

		$varDisplayAddonAmountPaid = $varDisplayAddonAmountPaid ? $varDisplayAddonAmountPaid : $arrRate[$varUseCountryCode][$varAddonCategory];

		//PREPAYMENT TRACKING PURPOSE....
		$varFields		= array('OrderId','MatriId','Product_Id','Package_Cost','Amount_Paid','Discount','DiscountFlatRate','Currency','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
		$argFieldsValue	= array($objMasterDB->doEscapeString($varOrderId,$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$objMasterDB->doEscapeString($varCategory,$objMasterDB),$objMasterDB->doEscapeString(round($varPackageCost),$objMasterDB),$objMasterDB->doEscapeString($varAmount,$objMasterDB),$objMasterDB->doEscapeString($varDiscountPercentage,$objMasterDB),$objMasterDB->doEscapeString($varDiscountFlatRate,$objMasterDB),'\'Rs\'','\'1\'','NOW()',$objMasterDB->doEscapeString($arrCurrCode[$varUseCountryCode],$objMasterDB),$objMasterDB->doEscapeString($varDisplayAmountPaid,$objMasterDB),$objMasterDB->doEscapeString($arrRate[$varUseCountryCode][$varCategory],$objMasterDB));
		$objMasterDB->insert($varTable['PREPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

		if($varProHighlighter >0 || $varCategory =='120'){

        $varFields		= array('OrderId','MatriId','Product_Id','Package_Cost','Amount_Paid','Currency','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
		$argFieldsValue	= array($objMasterDB->doEscapeString($varOrderId,$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$objMasterDB->doEscapeString($varAddonCategory,$objMasterDB),$objMasterDB->doEscapeString($varAddonAmount,$objMasterDB),$objMasterDB->doEscapeString($varAddonAmount,$objMasterDB),'\'Rs\'','\'1\'','NOW()',$objMasterDB->doEscapeString($arrCurrCode[$varUseCountryCode],$objMasterDB),$objMasterDB->doEscapeString($varDisplayAddonAmountPaid,$objMasterDB),$objMasterDB->doEscapeString($varDisplayAddonAmountPaid,$objMasterDB));
		$objMasterDB->insert($varTable['ADDONPREPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);
        if($varCategory !='120'){$varAmount = $varAmount + $varAddonAmount;}
		}

		$varCheckSum	= $objCCAvenue->getCheckSum($varMerchantId,$varAmount,$varOrderId,$varCCAvenueGatewayUrl,$varWorkingKey);

		//INSERT PHONE NUMBER 
		$varFields12			= array('MatriId','PaymentGateway','PaymentSource','Date_Captured');
		$varFieldsValues12	    = array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB),'1','1','NOW()');
		$objMasterDB->insertOnDuplicate('onlinepaymentfailures', $varFields12, $varFieldsValues12, 'MatriId');

}
if ($varProcess=='yes') { $varOnLoad = 'onLoad="javascript:document.frmRedirection.submit();"'; } //if

include_once($varRootBasePath.'/www/template/paymentheader.php');
?>

<form name='frmRedirection' method="post" action="https://www.ccavenue.com/shopzone/cc_details.jsp">

<input type="hidden" name="STATE" value="<?=$varState?>">
<input type="hidden" name="NAME" value="<?=$varName;?>">
<input type="hidden" name="COUNTRY" value="<?=$varCountryName;?>">
<input type="hidden" name="ADDR" value="<?=$varAddress;?>">
<input type="hidden" name="MatriId" value="<?=$sessMatriId?>">

<input type="hidden" name="Merchant_Id" value="<?=$varMerchantId?>">
<input type="hidden" name="Amount" value="<?=$varAmount;?>">
<input type="hidden" name="Order_Id" value="<?=$varOrderId?>">
<input type="hidden" name="Redirect_Url" value="<?=$varCCAvenueGatewayUrl?>">
<input type="hidden" name="Checksum" value="<?=$varCheckSum?>">
<input type="hidden" name="billing_cust_name" value="<?=$varName?>">
<input type="hidden" name="billing_cust_address" value="<?=$varState?>">
<input type="hidden" name="billing_cust_country" value="<?=$varCountryName?>">
<input type="hidden" name="billing_cust_tel" value="<?=str_replace("~","-",$varTel);?>">
<input type="hidden" name="billing_cust_email" value="<?=$varEmail?>">
<input type="hidden" name="delivery_cust_name" value="<?=$varName?>">
<input type="hidden" name="delivery_cust_address" value="<?=$varAddress?>">
<input type="hidden" name="delivery_cust_tel" value="<?=str_replace("~","-",$varTel);?>">
<input type="hidden" name="billing_cust_notes" value="">
<input type="hidden" name="Merchant_Param" value="<?=$varMerchantParam?>">

<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td valign="middle" class="textsmallbold">
						<table border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF">
							<tr>
								<td>&nbsp;</td><td class="smalltxt clr" style="line-height:18px;">
								<?php if ($varProcess=='no') { echo $varMessage; } else { ?>
								
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
										<td valign="top" colspan="2" style="padding-top:15px;font:normal 11px verdana,arial;line-height:15px;"><ul><li>&nbsp;&nbsp;You shall be taken to the payment gateway page to make payment in Indian Rupees.</li></ul></td>
										</tr>
										<tr>
											<td valign="top" colspan="2" style="padding-top:5px;padding-bottom:45px;font:normal 11px verdana,arial;line-height:15px;"><ul><li>&nbsp;&nbsp;If you are unable to connect to the payment gateway page, please <input type="button" class="button" value="Click" onClick="document.frmRedirection.submit()"> here.</li></ul></td>
										</tr>
									</table>
								<?php } ?>
								</td>
							</tr>
							<?php if ($varProcess=='no') { ?>
							<tr><td align="center" colspan="2" height="15"><IMG SRC="<?=$confValues["IMGSURL"];?>/trans.gif" HEIGHT="15" BORDER="0" ALT=""></td></tr>

							<tr><td align="center" colspan="2"><a href="<?=$confValues["SERVERURL"];?>/profiledetail/" style="text-decoration: none;" class="smalltxt clr1">Back to My Home</a></td></tr>
							<?php }?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	  </tr>
	</table>
</form>
<?php 
	$objMasterDB->dbClose();
	UNSET($objMasterDB);
	UNSET($objCCAvenue);
	include_once($varRootBasePath.'/www/template/paymentfooter.php');

}//if 
?>