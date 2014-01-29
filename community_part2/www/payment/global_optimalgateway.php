<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

##FILE INCLUDES
$_SERVER["HTTP_HOST"] = 'www.'.$_REQUEST['domainFolder'].'matrimony.com';
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.inc');
include_once($varRootBasePath."/conf/payment.inc");
include_once($varRootBasePath."/conf/vars.inc");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath.'/lib/clsCommon.php');

##VARIABLLE DECLARATIONS
$varPaymentSubmit	= $_REQUEST['frmPaymentSubmit'];
$varCategory		= $_REQUEST['category'];
$sessMatriId		= $_REQUEST['matriId'];
$varCountryCode		= $_REQUEST['countryCode'];
$varGateWay			= $_REQUEST['gateWay'];
$varCheckOffer      = $_REQUEST['checkOffer'];
$varGateWay			= $varGateWay ? $varGateWay : '3';##DEFAULT US

##CHECK USER LOGGED OR NOT
if($sessMatriId =='') { header ("Location:".$confValues['SERVERURL']."/login/"); exit; }##if

include_once($varRootBasePath."/www/payment/paymentprocess.php");

if ($sessMatriId !="") {

##OBJECT DECLARATION
$objMasterDB		= new DB;
$objCommon			= new clsCommon;

$varProcess	= 'yes';
$varOnLoad	= '';
$varOrderId	= $sessMatriId.'-'.substr(microtime(true),0,10);
if ($varCountryCode==162) {
	$varCurrency	= 'Rs';
	$varActualAmount= $arrInrGatewayConver[$varCategory];##$varAmount;

} else if ($varCountryCode==21) {
	$varCurrency	= 'EURO';
	$varActualAmount= $varAmount;

} else if ($varCountryCode==220) {
	$varCurrency	= 'AED';
	$varActualAmount= $varAmount;
} else if ($varCountryCode==221) {
	$varCurrency	= 'GBP';
	$varActualAmount= $varAmount;
}else if ($varCountryCode==98) {
	$varCurrency	= 'Rs';
	$varActualAmount= $varAmount;
} else {
	$varCurrency	= 'USD';
	$varActualAmount= $varAmount;
}
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);


##CHECK DISCOUNT FOR THIS MEMBER
$varOfferAvailable	= $_REQUEST['offerAvailable'];
$varOfferCategoryId = $_REQUEST['offerCategoryId'];

if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112') {

	if ($varOfferAvailable=='1' && ($varOfferCategoryId != $varRenewalOfferCategoryId)) { 

		##SELECT OFFERCODEINFO##
		$varCondition	= " WHERE MatriId='".$sessMatriId."'";
		$varFields		= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation');
		$varExecute			= $objMasterDB->select($varTable['OFFERCODEINFO'], $varFields, $varCondition,0);
		$varMemberInfo		= mysql_fetch_array($varExecute);

		$varMemberDiscountINRFlatRate   = trim($varMemberInfo["MemberDiscountINRFlatRate"]);
		$varMemberDiscountAEDFlatRate   = trim($varMemberInfo["MemberDiscountAEDFlatRate"]);
		$varMemberDiscountUSDFlatRate	= trim($varMemberInfo["MemberDiscountUSDFlatRate"]);
		$varMemberDiscountEUROFlatRate	= trim($varMemberInfo["MemberDiscountEUROFlatRate"]);
		$varMemberDiscountGBPFlatRate	= trim($varMemberInfo["MemberDiscountGBPFlatRate"]);

		if ($varMemberDiscountINRFlatRate !="") {
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountINRFlatRate); 
			$varDiscountAmount		= '1';
			$varDiscountAvail		= '98';
		} else if ($varMemberDiscountAEDFlatRate !="") {
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountAEDFlatRate); 
			$varDiscountAmount		= '1';
			$varDiscountAvail		= '220';
		}else if ($varMemberDiscountUSDFlatRate !="") {
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountUSDFlatRate);
			$varDiscountAmount		= '1';
			$varDiscountAvail		= '222';
		}else if ($varMemberDiscountEUROFlatRate !="") {
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountEUROFlatRate);
			$varDiscountAmount		= '1';
			$varDiscountAvail		= '21';
		}else if ($varMemberDiscountGBPFlatRate !="") {
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountGBPFlatRate);
			$varDiscountAmount		= '1';
			$varDiscountAvail		= '221';
		}

		$arrSplitDiscount	= array();
		for($i=0;$i<count($varSplitFlatDiscount);$i++) {

			$varSplitDiscount			= split('~',trim($varSplitFlatDiscount[$i]));
			$varKey						= trim($varSplitDiscount[0]);

			if ($varDiscountAvail==$varUseCountryCode) {
				$varValue			= trim($varSplitDiscount[1]);
			} else {
				$varDiscountAvailCurrency	= $arrCurrCode[$varDiscountAvail];
				if ($varDiscountAvailCurrency=='Rs.'){ $varDiscountAvailCurrency ='Inr'; }
				$varDiscountConvertCurrency	= $arrCurrCode[$varUseCountryCode];
				if ($varDiscountConvertCurrency=='Rs.'){ $varDiscountConvertCurrency ='Inr'; }
				$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

				if ($varDiscountAvail=='220'&& $varUseCountryCode=='98') {

					$varValue1	= 'varCurrAedToInr';
					$varValue	= round(($$varValue1*$varSplitDiscount[1]));

				} else {

					$varValue = round(($varSplitDiscount[1]*$$varGetDiscount));
				}

			}
			$arrSplitDiscount[$varKey]	= $varValue;
		}
		ksort($arrSplitDiscount);

		$varDiscountRate	= 0;
		$varDiscountRate	= trim($arrSplitDiscount[$varCategory]);
		if ($varDiscountRate > 0) { 
			
			$varPackageCost			= $varActualAmount;
			$varDiscountFlatRate	= $varDiscountRate;
			$varActualAmount		= ($varActualAmount - $varDiscountRate); }

	}##if
	else if($varOfferAvailable == 0  || ($varOfferAvailable ==1 && ($varOfferCategoryId == $varRenewalOfferCategoryId))) { ## start by barani sept17-2010

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
 
$varMergeFields   = array_merge($varOfferFields,$arrDiscountFields);
$varMergeFieldsValues = array_merge($varOfferFieldsValues, $$varCheckOffer);
$varFields    = array_values($varMergeFields);
$varFieldsValues  = array_values($varMergeFieldsValues);

$objMasterDB->insertOnDuplicate($varTable['OFFERCODEINFO'],$varFields,$varFieldsValues,'MatriId');

$varFields = array('OfferAvailable','OfferCategoryId');
$varFieldsValues = array(1,$varRenewalOfferCategoryId);
$varCondition		= "MatriId = '".$sessMatriId."'";
$varUpdateId	=$objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

$varDiscountFlatRate=0;
$varDiscountPercentage=0;
$varYouSavePercentageValue=0;
$varPackageCost = $varActualAmount;
 if($varCheckOffer == 'arrFlatDiscountValues') {
   $varDiscountFlatRate=$varSpecialOfferDiscountAmount;
   $varActualAmount = $varActualAmount - $varDiscountFlatRate;
 }
 else if($varCheckOffer == 'arrPercentageValues') {
  $varDiscountPercentage	=(($varActualAmount * $varDiscountPercentageValue) / 100);
  $varActualAmount = round($varActualAmount - $varDiscountPercentage);
  $varYouSavePercentageValue=round($varDiscountPercentage);
  $varDiscountPercentage = $varDiscountPercentageValue;
 }
 else if($varCheckOffer == 'arrNextLevelValues') {
   $arrOfferArrayList		= $$varCheckOffer;
   $varReplaceString	= str_replace("'","",$arrOfferArrayList[3])."|".str_replace("'","",$arrOfferArrayList[1]);
   $varExplode			= explode("|",$varReplaceString);
	foreach($varExplode	as	$varKey => $varValue) {
		$varExplde1	= explode("~",$varValue);
		$arrNextLevelMapping[$varExplde1[0]]	= $varExplde1[1];
    }
   $varUpgradedNextLevelOffer = $arrNextLevelMapping[$varCategory]; 
 }
} ## end by barani

}

$varActualAmount		= round($varActualAmount);
$varPackageCost			= round($varPackageCost);
$varDiscountFlatRate	= round($varDiscountFlatRate);
$varYouSave				= $varDiscountFlatRate ? $varDiscountFlatRate : $varYouSavePercentageValue;

##CHECK IF MEMBER HAS ALREADY PAID OR NOT
$varFields		= array('User_Name','Valid_Days','Paid_Status','Last_Payment','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as DaysLeft');
$varCondition	= " WHERE MatriId ='".$sessMatriId."'";
$varExecute		= $objMasterDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$varPaidInfo	= mysql_fetch_array($varExecute);
$varCurrDays	= $varPaidInfo["Valid_Days"];
$varPaidStatus	= $varPaidInfo["Paid_Status"];
$varDatePaid	= $varPaidInfo["Last_Payment"];
$varDaysLeft	= $varPaidInfo["DaysLeft"] ? $varPaidInfo["DaysLeft"] : 0;
$varUserName	= $varPaidInfo["User_Name"];
$varNoOfDays	= ($varCurrDays-$varDaysLeft);

##if(($varNoOfDays <= 10) && ($varPaidStatus == 1)) {
if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varPaidStatus == '1' && $varNoOfDays <= 10){

	$varProcess	= 'no';

	##PAYMENT MADE RECENTLY AND TRYING TO UPGRADE EITHER TO SAME MEMBERSHIP OR ALREADY PREMIUM MEMBER
	$varMessage	= 'You have recently made payment for Matrimony Id <b>'.$sessMatriId.'</b>. <br>The last payment was made on <b>'.$varDatePaid.'</b>. <br>A minimum of 10 days is required for subsequent payments. Please renew your membership after this period.';

} else {
		##PREPAYMENT TRACKING PURPOSE....
		
		$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Package_Cost','Amount_Paid','Discount','DiscountFlatRate','Currency','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
		$argFieldsValue	= array("'".$varOrderId."'","'".$sessMatriId."'","'".$varUserName."'","'".$varCategory."'","'".$varPackageCost."'","'".$varActualAmount."'","'".$varDiscountPercentage."'","'".$varDiscountFlatRate."'","'".$varCurrency."'",'\'5\'','NOW()',"'".$varCurrency."'","'".$varActualAmount."'","'".$varPackageCost."'");
		$objMasterDB->insert($varTable['PREPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

		
		if(($varCurrency=='EUR') || ($varCurrency=='EURO')){ 
				$varShowAmount = $varActualAmount * $arrCurrToUsd[21];## EURO - EUR [ EUROPE COUNTRIES 21 ]
				$varShowAmount = round($varShowAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[21]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[21]);
		}elseif($varCurrency=='AED'){
				$varShowAmount = $varActualAmount * $arrCurrToUsd[220];## UAE - AED [ UNITED ARAB EMIRATES 220 ]
				$varShowAmount = round($varShowAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[220]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[220]);
		}elseif($varCurrency=='GBP'){
				$varShowAmount = $varActualAmount * $arrCurrToUsd[221];## UK - GBP [ UNITED KINGDOM 221 ]
				$varShowAmount = round($varShowAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[221]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[221]);
		}elseif($varCurrency=='PKR'){
				$varShowAmount = $varActualAmount * $arrCurrToUsd[162];## PK - PKR [ PAKISTAN 162 ]
				$varShowAmount = round($varShowAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[162]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[162]);
		}elseif($varCurrency=='Rs'){
				$varShowAmount = $varActualAmount * $arrCurrToUsd[98];## RS - RS [ INDIA 98 ]
				$varShowAmount = round($varShowAmount);
				$varConvertedPackageAmount = round($varPackageCost * $arrCurrToUsd[98]);
				$varDiscountFlatRate		=  round($varDiscountFlatRate * $arrCurrToUsd[98]);
		} else { 
			$varShowAmount = round($varActualAmount);
			$varConvertedPackageAmount = $varPackageCost; 
		}

		##PREOPTIMALPAYMENT TRACKING PURPOSE....
		$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Package_Cost','Amount_Paid','Discount','DiscountFlatRate','Currency','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
		$argFieldsValue	= array("'".$varOrderId."'","'".$sessMatriId."'","'".$varUserName."'","'".$varCategory."'","'".$varConvertedPackageAmount."'","'".$varShowAmount."'","'".$varDiscountPercentage."'","'".$varDiscountFlatRate."'","'USD'",'\'5\'','NOW()',"'".$varCurrency."'","'".$varActualAmount."'","'".$varPackageCost."'");
		$objMasterDB->insert($varTable['PREOPTIMALPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);
}

include_once($varRootBasePath.'/www/template/paymentheader.php');

?>

<SCRIPT LANGUAGE="JAVASCRIPT">
function validateCreditcard() {

	var frmCreditCard=this.document.frmCreditCard;
	var n=document.getElementById('vpc_CardNum').value;
	var n1;var n2;var n3;
	n1=n.substring(0,1);
	n2=n.substring(1);
	n3=n.substring(0,4);

	if(IsEmpty(document.frmCreditCard.cardHolderName,'text')) {
		alert("Please enter name of the card holder");
		frmCreditCard.cardHolderName.focus();
		return false;
	}

	if(!document.frmCreditCard.vpc_card[0].checked && !document.frmCreditCard.vpc_card[1].checked) {
		alert("Please select card type");
		frmCreditCard.vpc_card[0].focus();
		return false;
	}

	if (IsEmpty(document.frmCreditCard.vpc_CardNum,'text')) {
		alert("Please enter credit card number");
		frmCreditCard.vpc_CardNum.focus();
		return false;
	}

	if (!ValidateNo(document.frmCreditCard.vpc_CardNum.value, "0123456789 " )) {
		alert("Invalid credit card Number "+frmCreditCard.vpc_CardNum.value);
		frmCreditCard.vpc_CardNum.focus();
		return false;
	}
	if(n1==3) {
		if(n2.length < 13) {
			alert("Your credit card number must contain 14 digits");
			frmCreditCard.vpc_CardNum.focus();
			return false;
		}
	}

	if(n1==4 || n1==5) {
		if(n2.length < 15) {
			alert("Your credit card number must contain 16 digits");
			frmCreditCard.vpc_CardNum.focus();
			return false;
		}
	}

	if(n3==5081) {
		alert("Invalid credit card number");
		frmCreditCard.vpc_CardNum.focus();
		return false;
	}
	if((frmCreditCard.cardExpiryMonth.value == "")&&(frmCreditCard.cardExpiryYear.value == "")) {
		alert("Please select card expiry date");
		frmCreditCard.cardExpiryMonth.focus();
		return false;
	}

	if (frmCreditCard.cardExpiryMonth.value=="") {
		alert("Please select month and year of expiry");
		frmCreditCard.cardExpiryMonth.focus();
		return false;
	}
			
	if (frmCreditCard.cardExpiryYear.value=="") {
		alert("Please select month and year of expiry");
		frmCreditCard.cardExpiryYear.focus();
		return false;
	}
	if (IsEmpty(document.frmCreditCard.vpc_CardSecurityCode,'text')) {
		alert ("Please enter card verification number");
		frmCreditCard.vpc_CardSecurityCode.focus();
		return false;
	}

	if (IsEmpty(document.frmCreditCard.phoneNumber,'text')) {
		alert ("Please enter phone number");
		frmCreditCard.phoneNumber.focus();
		return false;
	}
	if (IsEmpty(document.frmCreditCard.address,'text')) {
		alert ("Please enter address");
		frmCreditCard.address.focus();
		return false;
	}
	if (IsEmpty(document.frmCreditCard.city,'text')) {
		alert ("Please enter city");
		frmCreditCard.city.focus();
		return false;
	}
	if (frmCreditCard.USState.value=="" && IsEmpty(document.frmCreditCard.otherstate,'text')) {
		alert("Please select/enter state");
		frmCreditCard.USState.focus();
		return false;
	}
	if (frmCreditCard.country.value=="") {
		alert("Please select country");
		frmCreditCard.country.focus();
		return false;
	}


return true;
}//validateCreditcard

function IsEmpty(obj, obj_type) {
	if (obj_type == "text")	{
		var objValue;
		objValue = obj.value.replace(/\s+\$/,"");
		if (objValue.length == 0) {
			obj.focus();
			return true;
		} else {
			return false;
		}
	} else if (obj_type == "select") {
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) {
				if(obj.options[i].value == "") {
					obj.focus();
					return true;
				} else {
					return false;
				}
			}
		}
		return true;	
	} else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			} else {
				obj.focus();
				return true;	
			}
		} else {
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			obj[0].focus();
			return true;
		}
	} else {
		return false;
	}
}
function ValidateNo( NumStr, String ) {
	for( var Idx = 0; Idx < NumStr.length; Idx ++ )
	{
		 var Char = NumStr.charAt( Idx );
		 var Match = false;

			for( var Idx1 = 0; Idx1 < String.length; Idx1 ++) 
			{
				 if( Char == String.charAt( Idx1 ) ) 
				 Match = true;
			}

			if ( !Match ) 
				return false;
	}

	return true;
}


</SCRIPT>

<form name="frmCreditCard" method="POST" action="<?=$varGlobalOptimalDoURL;?>" onSubmit="return validateCreditcard();" style="margin:0px;">
<!--------- FOR ICICI MIGS Payment Gateway Purpose ---------------->
<input type="hidden" name="domainFolder" value="<?=$_REQUEST['domainFolder'];?>">
<input type="hidden" name="matriId" value="<?=$sessMatriId?>">
<input type="hidden" name="category" value="<?=$varCategory?>">
<input type="hidden" name="countryCode" value="<?=$varCountryCode?>">
<input type="hidden" name="gateWay" value="<?=$varGateWay?>">
<input type="hidden" name="vpc_MerchTxnRef" value="<?=$varOrderId?>" size="20" maxlength="40">
<input type="hidden" name="vpc_OrderInfo" value="<?=$varOrderId?>" size="20" maxlength="34">
<input type="hidden" name="actualAmount" value="<?=$varActualAmount?>">
<!--------- FOR ICICI MIGS Payment Gateway Purpose ---------------->

<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>    
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF">
        <table border="0"  cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding-left:10px;" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<? if ($varProcess	== 'no') { echo '<td class="smalltxt">'.$varMessage.'<br><br><center><a href="'.$confValues['SERVERURL'].'/profiledetail/" style="text-decoration: none;" class="smalltxt clr1">Back to My Home</a></center></td>'; } else { ?>

							<td class="smalltxt">Thank you for choosing to become a paid member. You have opted for:</td>
							<td class="smalltxt" align="right"><div><img src="images/paycc_verisignicon.gif"  height="28" border="0" alt="" align="absbottom"> <br><font class="smalltxt1">Secured Online Payment</font></div></td>
						</tr>
						</table>
					</td>

				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="10">
						<tr><td  height="25" style="padding:0px 10px 0px 10px;" class="brdr" align="center"><font class="smalltxt">
						<font class="normtxt bld">Chosen Package  : </font><font class="smalltxt">  <?=$arrPrdPackages[$varCategory];?>   </font><font class="smalltxt"></font></td>
						
						
                        <? if($varCheckOffer == 'arrNextLevelValues') { ?>
						   <td  height="25" style="padding:0px 10px 0px 10px;" class="brdr" align="center">
						   <? if(array_key_exists($varUpgradedNextLevelOffer,$arrPrdPackages)) {
						    echo '<font class="normtxt bld">Package upgraded to : </font><font class="smalltxt">'.$arrPrdPackages[$varUpgradedNextLevelOffer];
						   }
						   else {
   							  if($varCategory!='48') {
							 echo '<font class="normtxt bld">Offer Value : </font><font class="smalltxt"> '.$varUpgradedNextLevelOffer." Extra Phone Nos"; 
							  }
						   }
						   echo '</font></td>';
					       ?>
						<? } else if((($varCheckOffer == 'arrPercentageValues') || ($varCheckOffer == 'arrFlatDiscountValues')) || $varOfferCategoryId =='1') { ?>
						<td  height="25" style="padding:0px 10px 0px 10px;" class="brdr" align="center"><font class="normtxt bld">You Save : </font><font class="smalltxt"><? if ($varCountryCode=='162') { echo 'Rs'; } else { echo $arrCurrCode[$varCountryCode]; } ?> <?=$varYouSave ? $varYouSave : $varSpecialOfferDiscountAmount?></font></td>
                        <? } ?>
						
						<td  height="25" style="padding:0px 10px 0px 10px;" class="brdr" align="center"><font class="normtxt bld">Payable Amount  : </font><font class="smalltxt">
						<? if ($varCountryCode=='162') { 
							echo 'Rs'; 
							}else{
								echo $arrCurrCode[$varCountryCode];
							} ?>
							<?=$varActualAmount?> <? if($varCountryCode!='222'){ echo "/ USD ".$varShowAmount;}?></font></td>
						
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding-left:10px;">
					<table border="0" cellpadding="0" cellspacing="0" class="brdr">
					<tr>
						<td colspan="3" height="22" style="padding-left:15px;"><font class="normtxt1 bld">Credit Card Details</font></td>
					</tr>
					<tr>
						<td height="40" width="30%" style="padding-left:15px;border-top:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;"><font class="smalltxt">Card holder name</font></td>
						<td style="border-top:1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;border-right: 1px solid #cbcbcb;padding-left:39px;" width="70%"><input type="text" size="19" value="" name="cardHolderName" id="cardHolderName"  class="inputtext"></td>
						<td rowspan="7" valign="top" style="padding-top:32px;_padding-top:31px;"><img src="images/verification_num.jpg"  height="175" border="0" alt=""></td>
					</tr>
					<tr>
						<td height="40" style="padding-left:15px;border-bottom:1px solid #cbcbcb;"><font class="smalltxt">Card type</font></td>
						<td valign="middle" style="border-right: 1px solid #cbcbcb;border-bottom:1px solid #cbcbcb;padding-left:34px;">
						<div>
							<div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="AM"></div><div style="width:50px !important;width:40px;float:left;"><IMG SRC="<?=$confValues['IMGSURL']?>/pay-amex.gif"></div>
                            <div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="DI"></div><div style="width:50px !important;width:40px;float:left;"><IMG SRC="<?=$confValues['IMGSURL']?>/pay-dis.gif"></div>
                        </div>
                            </td>

					</tr>
                    <tr>
						<td height="40" width="35%" style="padding-left:15px;border-bottom:1px solid #cbcbcb;"><font class="smalltxt">Credit card number</font></td>
						<td style="border-bottom: 1px solid #cbcbcb;border-right: 1px solid #cbcbcb;padding-left:39px;"><input type="text" size="19" value="" name="vpc_CardNum" id="vpc_CardNum" class="inputtext"></td>
						<td>&nbsp;</td>
					</tr>

					<tr>
						<td height="47" style="padding-left:15px;border-bottom: 1px solid #cbcbcb;"><font class="smalltxt">Card expiry date</font></td>
						<td style="border-bottom: 1px solid #cbcbcb;border-right: 1px solid #cbcbcb;padding-left:39px;"><SELECT class="smalltxt" NAME="cardExpiryMonth" size="1" >
				<OPTION value="">-Month-</OPTION>
				<option value = "01">1</option>
				<option value = "02">2</option>

				<option value = "03">3</option>
				<option value = "04">4</option>
				<option value = "05">5</option>
				<option value = "06">6</option>
				<option value = "07">7</option>
				<option value = "08">8</option>

				<option value = "09">9</option>
				<option value = "10">10</option>
				<option value = "11">11</option>
				<option value = "12">12</option>
							</SELECT>
							<SELECT name="cardExpiryYear" class="smalltxt" >
				<OPTION value="">-Year-</OPTION> 
				<option value="10">2010</option>
				<option value="11">2011</option>
				<option value="12">2012</option>
				<option value="13">2013</option>
				<option value="14">2014</option>
				<option value="15">2015</option>
				<option value="16">2016</option>
				<option value="17">2017</option>
				<option value="18">2018</option>
				<option value="19">2019</option>
				<option value="20">2020</option>
				<option value="21">2021</option>
				<option value="22">2022</option>
				<option value="23">2023</option>
				<option value="24">2024</option>
				<option value="25">2025</option>
				<option value="26">2026</option>
				<option value="27">2027</option>
				<option value="28">2028</option>
				<option value="29">2029</option>
				<option value="30">2030</option>
				<option value="31">2031</option>
				<option value="32">2032</option>
				<option value="33">2033</option>
				<option value="34">2034</option>
				<option value="35">2035</option>
				<option value="36">2036</option>
				<option value="37">2037</option>
				<option value="38">2038</option>
				<option value="39">2039</option>
				<option value="40">2040</option>
</SELECT>

						</td>
					</tr>
					<tr>
						<td colspan="2" height="47" style="padding-left:15px;border-bottom: 1px solid #cbcbcb;">
						
							<div>
								<div style="float:left;padding-top:6px;"><font class="smalltxt">Card verification number</font></div>
								<div style="width:70px;float:left;padding-top:6px;padding-left:25px;"><input type="password" size="8" maxlength="3" value="" name="vpc_CardSecurityCode" class="inputtext"></div ><div style="float:right"><img src="images/payccline.gif"  height="35" border="0" alt=""></div>
							</div></td>
					</tr>

					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;" height="47"><font class="smalltxt">Phone number </font></td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;"><input size="19" value="" name="phoneNumber" id="phoneNumber" class="inputtext" type="text"></td>
					</tr>

					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;" height="47"><font class="smalltxt">Address </font></td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;"><input size="19" value="" name="address" id="address" class="inputtext" type="text"></td>
					</tr>
					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;" height="60"><font class="smalltxt">City </font></td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;"><input size="19" value="" name="city" id="city" class="inputtext" type="text"><br><font class="opttxt">If you reside in US, select the State from the list below. Else, enter your State in the "Other State" field.</font></td>
					</tr>
					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;line-height:20px;" height="65"><font class="smalltxt">State <br>Other state</td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;">
							<select NAME = "USState" class="smalltxt" onChange="document.frmCreditCard.otherstate.value='';">
								<option value = "" selected>- Select US State -</option>
								<option value = "AK">Alaska</option>
								<option value = "AL">Alabama</option>
								<option value = "AR">Arkansas</option>
								<option value = "AZ">Arizona</option>
								<option value = "CA">California</option>
								<option value = "CO">Colorado</option>
								<option value = "CT">Connecticut</option>
								<option value = "DC">District of Columbia</option>
								<option value = "DE">Delaware</option>
								<option value = "FL">Florida</option>
								<option value = "GA">Georgia</option>
								<option value = "HI">Hawaii</option>
								<option value = "IA">Iowa</option>
								<option value = "ID">Idaho</option>
								<option value = "IL">Illinois</option>
								<option value = "IN">Indiana</option>
								<option value = "KS">Kansas</option>
								<option value = "KY">Kentucky</option>
								<option value = "LA">Louisiana</option>
								<option value = "MA">Massachusetts</option>
								<option value = "MD">Maryland</option>
								<option value = "ME">Maine</option>
								<option value = "MI">Michigan</option>
								<option value = "MN">Minnesota</option>
								<option value = "MO">Missouri</option>
								<option value = "MS">M ssissippi</option>
								<option value = "MT">Montana</option>
								<option value = "NC">North Carolina</option>
								<option value = "ND">North Dakota</option>
								<option value = "NE">Nebraska</option>
								<option value = "NH">New Hampshire</option>
								<option value = "NJ">New Jersey</option>
								<option value = "NM">New Mexico</option>
								<option value = "NV">Nevada</option>
								<option value = "NY">New York</option>
								<option value = "OH">Ohio</option>
								<option value = "OK">Oklahoma</option>
								<option value = "OR">Oregon</option>
								<option value = "PA">Pennsylvania</option>
								<option value = "RI">Rhode Island</option>
								<option value = "SC">South Carolina</option>
								<option value = "SD">South Dakota</option>
								<option value = "TN">Tennessee</option>
								<option value = "TX">Texas</option>
								<option value = "UT">Utah</option>
								<option value = "VA">Virginia</option>
								<option value = "VT">Vermont</option>
								<option value = "WA">Washington</option>
								<option value = "WI">Wisconsin</option>
								<option value = "WV">West Virginia</option>
								<option value = "WY">Wyoming</option>
							</select><br><img src="images/trans.gif" width="1" height="5" /><br>
							<input type="text" name="otherstate" class="inputtext" size="19" onBlur="if(this.value != '')document.frmCreditCard.USState.value='';" />
						</td>
					</tr>
					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;" height="47"><font class="smalltxt">ZipCode </font></td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;"><input size="19" value="" name="zipCode" id="zipCode" class="inputtext" type="text">&nbsp;&nbsp;&nbsp;<font class="smalltxt">Optional</font></td>
					</tr>
					<tr>

						<td style="border-bottom: 1px solid rgb(203, 203, 203); padding-left: 15px;" height="47"><font class="smalltxt">Country </font></td>

						<td style="border-right: 1px solid rgb(203, 203, 203); border-bottom: 1px solid rgb(203, 203, 203); padding-left: 39px;">
						
							<select NAME = "country" class="smalltxt">
								<option value = "" selected>- Select Country -</option>
									<?=$objCommon->getValuesFromArray($arrCountryList, "", "", $varCountry);?>
							</select><br><img src="images/trans.gif" width="1" height="5" /><br>

						</td>
					</tr>



					<tr>
						<td colspan="2" align="center" height="75"><input type="submit" name="SubButL" class="button pntr" value="Pay Now!"><br><font class="smalltxt">(Click only once.)</font></td>
						<td style="border-top: 1px solid #cbcbcb;">&nbsp;</td>
					<? } ?>
					</tr>
					</table>
					</td>
				</tr>
				<? if ($varProcess	== 'yes') { ?>
				<tr>
					<td class="smalltxt" style="padding:10px 0px 0px 10px;"><B>Note:</B> Your credit card information will go through the Verisign secured server and may take a few seconds for authorization. So kindly wait for confirmation.</td>
				</tr>
				<? } ?>
				</table>
				<!-- CONTENT ENDS HERE -->
            </td>
			</tr>
		</table>
    </td>
    <td valign="top" class="borderclr" ><img src="images/trans.gif"  height="1"></td>
  </tr>

</table>
			
				</form><br clear="all">
				<!-- CONTENT ENDS HERE -->
<?php 
	$objMasterDB->dbClose();
	UNSET($objMasterDB);
	include_once($varRootBasePath.'/www/template/paymentfooter.php');
}##if 
?>