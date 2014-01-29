<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2010-12-02
# Project	  : offerpopup
# Filename	  : offerpopup.php
#=====================================================================================================================================
# Description : display offer popup when offer is available
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');

//SETING MEMCACHE KEY
$varRenewalOffer	= '';
$varSpecialOffer	= '';
$varOfferType		= '';//1=>renewal,2=>special,3=>offer avaialble person
$varOfferSubType	= '';//1=>flat,2=>percentage,3=>next level
$varAutoRedirection	= ''; //  This variable used for auto redirect to credit card details page with offer details

//get offer detail
$argFields			= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberExtraHoroscope','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','MemberExtraDays');
$argCondition		= " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB);
$varofferInfoRes	= $objSlaveDB->select($varTable['OFFERCODEINFO'],$argFields,$argCondition,0);
$varofferInfo		= mysql_fetch_assoc($varofferInfoRes);


//get online payment details
$argFields			= array('Currency','Auto_Renew');
$varOnlinePaymentInfoRes	= $objSlaveDB->select($varTable['ONLINEPAYMENTDETAILS'],$argFields,$argCondition,0);
$varOnlinePaymentInfo		= mysql_fetch_assoc($varOnlinePaymentInfoRes);
$varOnlinePaymentInfo = $varOnlinePaymentInfo['Currency'].'^|'.$varOnlinePaymentInfo['Auto_Renew'];

if($varSelectLoginInfo['OfferAvailable']==1 && $varofferInfo['MatriId']!='') {

	$varOfferCategoryCode		= trim($varofferInfo['OfferCategoryId']);
	$varOfferAvailEndDate		= trim($varofferInfo['OfferEndDate']);
	$varExtraPhoneNumbers		= trim($varofferInfo['MemberExtraPhoneNumbers']);
	$varExtraHoroscope			= trim($varofferInfo['MemberExtraHoroscope']);
	$varDiscountPercentageOffer	= trim($varofferInfo['MemberDiscountPercentage']);
	$varINRFlatRateOffer		= trim($varofferInfo['MemberDiscountINRFlatRate']);
	$varUSDFlatRateOffer		= trim($varofferInfo['MemberDiscountUSDFlatRate']);
	$varEUROFlatRateOffer		= trim($varofferInfo['MemberDiscountEUROFlatRate']);
	$varAEDFlatRateOffer		= trim($varofferInfo['MemberDiscountAEDFlatRate']);
	$varGBPFlatRateOffer		= trim($varofferInfo['MemberDiscountGBPFlatRate']);
	$varNextLevelOffer			= trim($varofferInfo['MemberNextLevelOffer']);
	
	if ($varINRFlatRateOffer!="" || $varUSDFlatRateOffer!="" || $varEUROFlatRateOffer!="" || $varAEDFlatRateOffer!="" || $varGBPFlatRateOffer!="") {
		$varOfferType		= 3;
		$varOfferSubType	= 1;
		if ($varINRFlatRateOffer !="") {
			$varSplitFlatDiscount	= split('\|',$varINRFlatRateOffer);
			$varCurrencyBase		= 98;
		} else if ($varAEDFlatRateOffer !="") {
			$varSplitFlatDiscount	= split('\|',$varAEDFlatRateOffer);
			$varCurrencyBase		= 220;
		} else if ($varEUROFlatRateOffer !="") {
			$varSplitFlatDiscount	= split('\|',$varEUROFlatRateOffer);
			$varCurrencyBase		= 21;
		} else if ($varUSDFlatRateOffer !="") {
			$varSplitFlatDiscount	= split('\|',$varUSDFlatRateOffer);
			$varCurrencyBase		= 222;
		} else if ($varGBPFlatRateOffer !="") {
			$varSplitFlatDiscount	= split('\|',$varGBPFlatRateOffer);
			$varCurrencyBase		= 221;
		}

		$arrSplitDiscount	= array();
		for($i=0;$i<count($varSplitFlatDiscount);$i++) {
			$varSplitDiscount			= array();
			$varSplitDiscount			= split('~',trim($varSplitFlatDiscount[$i]));
			$varKey						= trim($varSplitDiscount[0]);
			$varValue					= trim($varSplitDiscount[1]);
			$arrSplitDiscount[$varKey]	= $varValue;
		}
		//arsort($arrSplitDiscount);
		foreach ($arrSplitDiscount as $key => $val) {
			//echo "$key = $val\n";
			$varPackageType = $key;
			$varPackageVal	= $val;
			break;
		}

		$varOfferEndDate	= date("Y-m-d",strtotime($varOfferAvailEndDate));
		$varOfferDetail = $varOfferType.'^|'.$varOfferSubType.'^|'.$varPackageType.'^|'.$varPackageVal.'^|'.$varCurrencyBase.'^|'.$varOfferEndDate.'^|^|^|^|';
		$varAutoRedirection	= '&checkOffer='.$arrDiscountLevel[1].'&offerAvailable='.$varSelectLoginInfo['OfferAvailable'].'&offerCategoryId='.$varSelectLoginInfo['OfferCategoryId'];

	} else if($varDiscountPercentageOffer!='') {

		$varOfferType		= 3;
		$varOfferSubType	= 2;

		$varSplitPercentageDiscount	= split('\|',$varDiscountPercentageOffer);

		$arrSplitDiscount	= array();
		for($i=0;$i<count($varSplitPercentageDiscount);$i++) {
			$varSplitDiscount			= array();
			$varSplitDiscount			= split('~',trim($varSplitPercentageDiscount[$i]));
			$varKey						= trim($varSplitDiscount[0]);
			$varValue					= trim($varSplitDiscount[1]);
			$arrSplitDiscount[$varKey]	= $varValue;
		}
		//arsort($arrSplitDiscount);

		foreach ($arrSplitDiscount as $key => $val) {
			//echo "$key = $val\n";
			$varPercentageVal	= $val;
			break;
		}

		$varOfferEndDate	= date("Y-m-d",strtotime($varOfferAvailEndDate));
		$varOfferDetail = $varOfferType.'^|'.$varOfferSubType.'^|^|^|^|'.$varOfferEndDate.'^|'.$varPercentageVal.'^|^|^|'; //need percentage
		$varAutoRedirection	= '&checkOffer='.$arrDiscountLevel[2].'&offerAvailable='.$varSelectLoginInfo['OfferAvailable'].'&offerCategoryId='.$varSelectLoginInfo['OfferCategoryId'];
	} else if($varNextLevelOffer!='') {
		$varOfferType		= 3;
		$varOfferSubType	= 3;
		if($varExtraPhoneNumbers!='') {
			$varSplitExtraPhoneNos	= split('\|',$varExtraPhoneNumbers);
			
			$arrExtraPhoneNumbers	= array();
			for($i=0;$i<count($varSplitExtraPhoneNos);$i++) {
				$varExtraPhNos					= array();
				$varExtraPhNos					= split('~',trim($varSplitExtraPhoneNos[$i]));
				$varKey							= trim($varExtraPhNos[0]);
				$varValue						= trim($varExtraPhNos[1]);
				$arrExtraPhoneNumbers[$varKey]	= $varValue;
			}
		}

		$varOfferEndDate	= date("Y-m-d",strtotime($varOfferAvailEndDate));
		$varOfferDetail = $varOfferType.'^|'.$varOfferSubType.'^|^|^|^|'.$varOfferEndDate.'^|^|'.$arrExtraPhoneNumbers[7].'^|'.$arrExtraPhoneNumbers[8].'^|'.$arrExtraPhoneNumbers[9];
		$varAutoRedirection	= '&checkOffer='.$arrDiscountLevel[3].'&offerAvailable='.$varSelectLoginInfo['OfferAvailable'].'&offerCategoryId='.$varSelectLoginInfo['OfferCategoryId'];
	}

} else if($varPaidStatus==1 && $varValidDaysLeft<='30' && $varExpiryDate!='0000-00-00 00:00:00') {
	$varOfferType = 1; //renewal offer
	$varOfferDetail = $varOfferType.'^|^|^|^|^|'.$varOfferEndDate.'^|'.$varDiscountPercentageValue.'^|^|^|'; //need percentage
	$varAutoRedirection	= '&checkOffer='.$arrDiscountLevel[3].'&offerAvailable='.$varSelectLoginInfo['OfferAvailable'].'&offerCategoryId='.$varSelectLoginInfo['OfferCategoryId'];
} else if($varPaidStatus==0 && $varNumberOfPayments>0) {
	$varOfferType = 1; //renewal offer
	$varOfferDetail = $varOfferType.'^|^|^|^|^|'.$varOfferEndDate.'^|'.$varDiscountPercentageValue.'^|^|^|'; //need percentage
	$varAutoRedirection	= '&checkOffer='.$arrDiscountLevel[3].'&offerAvailable='.$varSelectLoginInfo['OfferAvailable'].'&offerCategoryId='.$varSelectLoginInfo['OfferCategoryId'];
} else if($varPaidStatus==0 && $varNumberOfPayments==0) {
	$varOfferType = 2; //special offer (first time offer)
	$varOfferDetail = $varOfferType.'^|^|^|^|^|'.$varOfferEndDate.'^|^|'.$varPlatinum3MonthExtraPhoneCnt.'^|'.$varPlatinum6MonthExtraPhoneCnt.'^|'.$varPlatinum9MonthExtraPhoneCnt;
	$varAutoRedirection	= '&checkOffer='.$arrDiscountLevel[3].'&offerAvailable='.$varSelectLoginInfo['OfferAvailable'].'&offerCategoryId='.$varSelectLoginInfo['OfferCategoryId'];
}

setrawcookie("offerInfo","$varOfferDetail", "0", "/",$confValues['DOMAINNAME']);
setrawcookie("onlinePaymentInfo","$varOnlinePaymentInfo", "0", "/",$confValues['DOMAINNAME']);
?>