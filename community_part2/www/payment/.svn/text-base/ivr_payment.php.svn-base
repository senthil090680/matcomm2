<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2010-05-11
# End Date		: 2010-05-21
# Project		: Community
# Module		: Payment - IVRS integration
#=============================================================================================================

//DOC ROOT PATH DECLARATION
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//VARIABLLE DECLARATIONS
$varCountryCode		= $_REQUEST["countryCode"];
$varPaymentSubmit	= $_REQUEST['frmPaymentSubmit'];
$varCategory		= $_REQUEST['category'];
$varAddonCategory	= 120;
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varGateWay			= 1;
$varCheckOffer      = $_REQUEST['checkOffer'];
$varProcess			= 'yes';
$varProHighlighter  = $_REQUEST['proHighlighter'] ? $_REQUEST['proHighlighter'] : '0';

//CHECK ALREADY LOGGED USER
//if($sessMatriId =='') { header ("Location:../login/"); exit; }//if
include_once($varRootBasePath."/www/payment/paymentprocess.php");

//OBJECT DECLARATION
$objMasterDB= new DB;
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//CBS OFFLINE DB CON to GEN ORDER ID - Starts Ashok//
$objOrderIdGen = new DB;
$objOrderIdGen->dbConnect('ODB4_offlinecbs',$varOfflineCbsDbInfo['DATABASE']); //LIVE Connection
//$objOrderIdGen->dbConnection($varDbIP['ODB4_offlinecbs'],'communitypay','community4dump',$varOfflineCbsDbInfo['DATABASE']); //LOCAL CONNECTION
//CBS OFFLINE DB CON to GEN ORDER ID - End Ashok//

//CHECK IF MEMBER HAS ALREADY PAID OR NOT
$varFields			= array('Valid_Days','Paid_Status','Last_Payment','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as DaysLeft','Phone_Verified','Contact_Phone','Contact_Mobile');
$varCondition		= " WHERE MatriId =".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
$varExecute			= $objMasterDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
$varPaidInfo		= mysql_fetch_array($varExecute);
$varCurrDays		= $varPaidInfo["Valid_Days"];
$varPaidStatus		= $varPaidInfo["Paid_Status"];
$varDatePaid		= $varPaidInfo["Last_Payment"];
$varDaysLeft		= ($varPaidInfo["DaysLeft"]>0)?$varPaidInfo["DaysLeft"]:0;
$varPhoneVerified	= $varPaidInfo["Phone_Verified"];
$varContactPhone	= $varPaidInfo["Contact_Phone"];
$varContactMobile	= $varPaidInfo["Contact_Mobile"];
$varNoOfDays		= ($varCurrDays-$varDaysLeft);

//CHECK DISCOUNT FOR THIS MEMBER
$varOfferAvailable	= $varGetCookieInfo['OFFERAVAILABLE'];
$varOfferCategoryId = $varGetCookieInfo['OFFERCATEGORYID'];

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
	} else if ($varMemberDiscountAEDFlatRate !="") {
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

	$arrSplitDiscount	= array();
	for($i=0;$i<count($varSplitFlatDiscount);$i++) {
		$varSplitDiscount = split('~',trim($varSplitFlatDiscount[$i]));
		$varKey = trim($varSplitDiscount[0]);
		if ($varDiscountAvail==$varUseCountryCode && $varDiscountAvail=='98') {
			$varValue = trim($varSplitDiscount[1]);
		} else {
			$varDiscountAvailCurrency	= $arrCurrCode[$varDiscountAvail];
			if ($varDiscountAvailCurrency=='Rs.'){ $varDiscountAvailCurrency ='Inr'; }
			$varDiscountConvertCurrency	= $arrCurrCode[$varUseCountryCode];
			if ($varDiscountConvertCurrency=='Rs.'){ $varDiscountConvertCurrency ='Inr'; }
			$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));
			if ($varDiscountAvail=='98') {
				$varValue1	= round(($varSplitDiscount[1]*$$varGetDiscount));
				$varConver	= 'varCurr'.ucwords(strtolower($arrCurrCode[$varUseCountryCode])).'ToInr';
				$varValue	= round($varValue1*$$varConver);
			} elseif ($varDiscountAvail=='220' || $varDiscountAvail=='222' || $varDiscountAvail=='221' || $varDiscountAvail=='21') {
				$varCurrencyName = ucwords(strtolower($arrCurrCode[$varUseCountryCode]));
				if ($varCurrencyName=='Rs.'){ $varCurrencyName ='Inr'; }
				if ($varUseCountryCode=='98') {
					$varValue = round(($varSplitDiscount[1]*$$varGetDiscount));
				} else {
					if ($varUseCountryCode=='220') {
						$varAed220Discount = 'varCurr'.$varCurrencyName.'ToInr';
						$varValue = round(($varSplitDiscount[1]*$$varAed220Discount));
					} elseif ($varUseCountryCode=='221') {
						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));
						$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
						$varGBPToInr = 'varCurrGbpToInr';
						$varValue = round(($varValue1*$$varGBPToInr));
					} elseif ($varUseCountryCode=='21') {
						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));
						$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
						$varEurToInr = 'varCurrEurToInr';
						$varValue = round(($varValue1*$$varEurToInr));
					} elseif ($varUseCountryCode=='222') {
						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));
						$varValue1 = round(($varSplitDiscount[1]*$$varGetDiscount));
						$varUsdToInr = 'varCurrUsdToInr';
						$varValue = round(($varValue1*$$varUsdToInr));
					} else {
						//$varAed220Discount = 'varCurr'.$varCurrencyName.'ToInr';
						//$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));
						//echo $varValue	= round(($varSplitDiscount[1]/$$varGetDiscount));
						$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));
						$varValue = round(($varSplitDiscount[1]*$$varGetDiscount));
					}
				}
				$localCurrOriginalRate	= $arrRate[$varUseCountryCode];
			}
		}
		$arrSplitDiscount[$varKey]	= $varValue;
	}
	ksort($arrSplitDiscount);
	$varInrDiscountAmount	= round($arrSplitDiscount[$varCategory]);
	if ($varInrDiscountAmount > 0) {
		$varPackageCost			= $varAmount;
		$varDiscountFlatRate	= $varInrDiscountAmount;
		$varAmount				= ($varAmount - $varInrDiscountAmount);
	}
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

$objMasterDB->insertOnDuplicate($varTable['OFFERCODEINFO'],$varFields,$varFieldsValues,'MatriId');

$varFields			  = array('OfferAvailable','OfferCategoryId');
$varFieldsValues	  = array(1,$varRenewalOfferCategoryId);
$varCondition		  = "MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
$varUpdateId		  = $objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);

$varDiscountFlatRate  = 0;
$varDiscountPercentage= 0;
$varPackageCost		  = $varAmount;

 if($varCheckOffer == 'arrFlatDiscountValues') {
   $varDiscountFlatRate = $varSpecialOfferDiscountAmount;
   $varAmount           = $varAmount - $varDiscountFlatRate;
 }
 else if($varCheckOffer == 'arrPercentageValues') {
  $varDiscountPercentage =(($varAmount * $varDiscountPercentageValue) / 100);
  $varAmount             = $varAmount - $varDiscountPercentage;
  $varDiscountPercentage = $varDiscountPercentageValue;
 }
} // end by barani

if(($varNoOfDays <= 10) && ($varPaidStatus == '1')) {
	$varProcess	= 'no';
	//PAYMENT MADE RECENTLY AND TRYING TO UPGRADE EITHER TO SAME MEMBERSHIP OR ALREADY PREMIUM MEMBER
	$varMessage	= '<br clear="all"><div class="smalltxt clr padb5">You have recently made payment for Matrimony Id <b>'.$sessMatriId.'</b>.</div> <div class="smalltxt clr padb5">The last payment was made on <b>'.$varDatePaid.'</b>.</div> <div class="smalltxt clr padb5">A minimum of 10 days is required for subsequent payments. Please renew your membership after this period.</div>';
} else {
	if($varCategory==9 || $varCategory==6 || $varCategory==3) { $varDuration=9; }
	else if($varCategory==8 || $varCategory==5 || $varCategory==2) { $varDuration=6; }
	else if($varCategory==7 || $varCategory==4 || $varCategory==1) { $varDuration=3; }

	$varIVRSInfo	= IVRSPaymentTracking($objMasterDB,$sessMatriId,$varPhoneVerified,$varContactMobile,$varContactPhone,$varProHighlighter);
	$varSplit		= split("##",$varIVRSInfo);
	$varIVRSOrderId	= $varSplit[0];
	$varIVRSPhoneNo	= $varSplit[1];

	IVRCall($varIVRSPhoneNo,$varIVRSOrderId);
}

function IVRCall($varIVRSPhoneNo,$varIVRSOrderId) {
	$varIVRSPhoneNo = preg_replace('/\D/','',$varIVRSPhoneNo);
	if(strlen($varIVRSPhoneNo)>=5){
		$varExecCommand = "php ivr_autocall.php $varIVRSPhoneNo 91 $varIVRSOrderId";
		$varLogFileName = 'ivr_autocall.txt';
		escapeexec($varExecCommand,$varLogFileName);
	}
}

//GENERATES AUTO-INCREMENTED IVR ORDER ID FROM CBS OFFLINE DB TABLES - ASHOK//
function genIVROrderId($objOrderIdGen='') {
	global $varTable;
	$varTable['GENERATEORDERIDS'] = 'cm_generateorderids';
	$varFields		= array('Status');
	$argFieldsValue	= array('1');
	$varGetIVROrderId = $objOrderIdGen->insert($varTable['GENERATEORDERIDS'], $varFields, $argFieldsValue);
	return $varGetIVROrderId;
}
//GENERATES AUTO-INCREMENTED IVR ORDER ID FROM CBS OFFLINE DB TABLES - ENDS - ASHOK//

function IVRSPaymentTracking($objMasterDB,$sessMatriId,$varPhoneVerified,$varContactMobile,$varContactPhone,$varProHighlighter) {

	global $varTable,$varCategory,$varAmount,$objOrderIdGen,$varPackageCost,$varDiscountPercentage,$varDiscountFlatRate,$varAddonCategory,$varAddonAmount;

	if ($objOrderIdGen->clsDBLink) {
		$varOrderId		= genIVROrderId($objOrderIdGen);
	} else {
		$varOrderId		= microtime();//$sessMatriId.'-'.time();
		$varOrderId		= substr($varOrderId,-5);
	}

	$varPhoneNo1	= '0';

	//PREPAYMENT TRACKING PURPOSE....
	$varFields		= array('OrderId','MatriId','Product_Id','Package_Cost','Amount_Paid','Discount','DiscountFlatRate','Currency','Payment_Mode','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
	$argFieldsValue	= array($objMasterDB->doEscapeString($varOrderId,$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$objMasterDB->doEscapeString($varCategory,$objMasterDB),$objMasterDB->doEscapeString($varPackageCost,$objMasterDB),$objMasterDB->doEscapeString($varAmount,$objMasterDB),$objMasterDB->doEscapeString($varDiscountPercentage,$objMasterDB),$objMasterDB->doEscapeString($varDiscountFlatRate,$objMasterDB),'\'Rs\'','1','\'4\'','NOW()','\'Rs\'',$objMasterDB->doEscapeString($varAmount,$objMasterDB),$objMasterDB->doEscapeString($varPackageCost,$objMasterDB));
	$objMasterDB->insert($varTable['PREPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

	if($varProHighlighter >0){

        $varFields		= array('OrderId','MatriId','Product_Id','Package_Cost','Amount_Paid','Currency','Gateway','Date_Paid','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
		$argFieldsValue	= array($objMasterDB->doEscapeString($varOrderId,$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$objMasterDB->doEscapeString($varAddonCategory,$objMasterDB),$objMasterDB->doEscapeString($varAddonAmount,$objMasterDB),$objMasterDB->doEscapeString($varAddonAmount,$objMasterDB),'\'Rs\'','\'4\'','NOW()','\'Rs\'',$objMasterDB->doEscapeString($varAddonAmount,$objMasterDB),$objMasterDB->doEscapeString($varAddonAmount,$objMasterDB));
		$objMasterDB->insert($varTable['ADDONPREPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);

		$varAmount = $varAmount + $varAddonAmount;
	}

	if (($varPhoneVerified=='1') || ($varPhoneVerified=='3')) {
		$varCondition	= " WHERE MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFields		= array('PhoneNo1');
		$varExecute		= $objMasterDB->select($varTable['ASSUREDCONTACT'], $varFields, $varCondition,0);
		$varMemberInfo	= mysql_fetch_array($varExecute);
		$varPhoneNo1	=  $varMemberInfo["PhoneNo1"];
	}

	if ($varPhoneNo1!='') {
		$varSplitPhoneNo1	= split("~",$varPhoneNo1);
		$varSplitCount		= count($varSplitPhoneNo1);
		if ($varSplitCount=='2') { $varPhoneNo1		= $varSplitPhoneNo1[1]; }
		else { $varPhoneNo1		= $varSplitPhoneNo1[2];  }
	} else {
		if ($varContactMobile !="") {
			$varSplitMobile		= split("~",$varContactMobile);
			if (count($varSplitMobile) > 0) { $varPhoneNo1	= trim($varSplitMobile[1]); }
			else { $varPhoneNo1	= $varContactMobile;  }
		} else {
			if ($varContactPhone !="") {
				$varSplitPhone	= split("~",$varContactPhone);
				$varPhoneNo1	= trim($varSplitPhone[1]).trim($varSplitPhone[2]);
			}
		}

	}

	return $varOrderId.'##'.$varPhoneNo1;
}   //getPhoneNumber

?>
<div class="rpanel fleft">
	<div class="normtxt1 clr padb5 bld">Pay through Phone</div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<center>
	<div class="rpanelinner">
		<? if ($varProcess=='yes') { ?>
		<div class="normtxt clr padb5 bld lh20" style="padding-top:20px;">Please keep your card details ready. You will receive a call from us shortly.</div> <br clear="all"><br>
		<div class="smalltxt clr padb5">You have chosen:</div>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFF0D3" class="brdr">
			<tr><td class="rbrdr smalltxt clr" height="35" align="center"><b>Package: </b> <?=$arrPrdPackages[$varCategory]?></td>
				<td class="rbrdr smalltxt clr" align="center"><b>Duration: </b> <?=$arrPkgValidDays[$varCategory]?> Days</td>
				<td class="rbrdr smalltxt clr" align="center"><b>Amount: </b> Rs. <?=$varAmount?></td>
				<td class="smalltxt clr" align="center"><b>Order ID: </b> <?=$varIVRSOrderId?></td>
			</tr>
		</table><br>
		<div class="smalltxt clr padtb10 bld">Follow the steps below to make your payment:</div>
		<div class="smalltxt clr padb5 bld">Step 1</div>
		<div class="smalltxt clr padb10">You will receive a call shortly from us to the number you have provided at the time of registration.<br>If you do not receive a call from us, please call <font class="normtxt clr3 bld">1800-3000-2222</font> (Toll Free) for making payment.</div>
		<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		<div class="smalltxt clr padt10 bld">Step 2</div>
		<div class="smalltxt clr padb10">You will be asked for your credit card number, card expiry date and CVV.</div>
		<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		<div class="smalltxt clr padt10 bld">Step 3</div>
		<div class="smalltxt clr padb10">Upon submission of your details your transaction will be processed.</div>
		<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all"><br>
		<div class="opttxt clr padb5">Note: We assure you the highest level of safety and security.</div>
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		<? } else { echo $varMessage; } ?>
	</div>
	</center>
</div>
<?
	$objMasterDB->dbClose();
	UNSET($objMasterDB);
?>