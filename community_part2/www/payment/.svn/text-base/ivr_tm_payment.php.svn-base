<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2010-05-11
# End Date		: 2010-05-21
# Project		: Community
# Module		: Payment - IVRS integration
#=============================================================================================================

$varRootBasePath	= '/home/product/community';
$varBaseRoot		= $varRootBasePath;

//VARIABLLE DECLARATIONS
$varCountryCode		= '98';
$varMatriId			= trim($_REQUEST['matriid']);
$varPrefixMatriId	= substr($varMatriId,0,3);
$varOrderId			= trim($_REQUEST['orderId']);
$varGateWay			= '1';
$varPaidCurrency	= 'Rs';
$varPercentageDiscount	= 'no';

//FILE INCLUDES
include_once($varRootBasePath.'/conf/domainlist.cil14');
$_SERVER["HTTP_HOST"]='www.'.$arrPrefixDomainList[$varPrefixMatriId];
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARATION
$objMasterDB= new DB;

$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

//CHECK IF MEMBER HAS ALREADY PAID OR NOT
$varFields			 = array('OrderId','MatriId','Product_Id','Display_Currency');
$varCondition		 = " WHERE OrderId=".$objMasterDB->doEscapeString($varOrderId,$objMasterDB);
$varExecute			 = $objMasterDB->select($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
$varPaidInfo		 = mysql_fetch_array($varExecute);
$varOrderId			 = $varPaidInfo["OrderId"];
$varMatriId			 = $varPaidInfo["MatriId"];
$varCategory		 = $varPaidInfo["Product_Id"];
$varDisplayCurrency  = $varPaidInfo["Display_Currency"];

if($varDisplayCurrency!='Rs'){
	$varGateWay		= '3';
	$varPaidCurrency= 'USD';
    $varCountryCode	= $arrAutoRenewCurrencyList[$varDisplayCurrency];
}

include_once($varRootBasePath."/www/payment/paymentprocess.php");

if ($varOrderId!="" && $varMatriId!="") {

		//SELECT OFFERCODEINFO//
		$varCondition	= " WHERE MatriId=".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		$varFields		= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','DateUpdated','OmmParticipation');
		$varExecute			= $objMasterDB->select($varTable['OFFERCODEINFO'], $varFields, $varCondition,0);
		$varMemberInfo		= mysql_fetch_array($varExecute);

		$varMemberDiscountINRFlatRate   = trim($varMemberInfo["MemberDiscountINRFlatRate"]);
		$varMemberDiscountAEDFlatRate   = trim($varMemberInfo["MemberDiscountAEDFlatRate"]);
		$varMemberDiscountUSDFlatRate	= trim($varMemberInfo["MemberDiscountUSDFlatRate"]);
		$varMemberDiscountEUROFlatRate	= trim($varMemberInfo["MemberDiscountEUROFlatRate"]);
		$varMemberDiscountGBPFlatRate	= trim($varMemberInfo["MemberDiscountGBPFlatRate"]);
		$varMemberDiscountPercentage	= trim($varMemberInfo["MemberDiscountPercentage"]);

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
		}else if ($varMemberDiscountPercentage !="") {
			$varPercentageDiscount	= 'yes';
			$varDiscountAvail		= $varUseCountryCode;
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountPercentage);
		}

		$arrSplitDiscount			= array();
		for($i=0;$i<count($varSplitFlatDiscount);$i++) {

			$varSplitDiscount		= split('~',trim($varSplitFlatDiscount[$i]));
			$varKey					= trim($varSplitDiscount[0]);

			if (($varUseCountryCode=='222') || ($varUseCountryCode=='98'))  { 
				$varValue	= trim($varSplitDiscount[1]);
			} else {
				$varDiscountAvailCurrency	= $arrCurrCode[$varDiscountAvail];
				if ($varDiscountAvailCurrency=='Rs.'){ $varDiscountAvailCurrency ='Inr'; }

				$varDiscountConvertCurrency	= $arrCurrCode[222];
				if ($varDiscountConvertCurrency=='Rs.'){ $varDiscountConvertCurrency ='Inr'; }

				$varGetDiscount	= 'varCurr'.ucwords(strtolower($varDiscountAvailCurrency)).'To'.ucwords(strtolower($varDiscountConvertCurrency));

				if ($varDiscountAvail=='220' && $varUseCountryCode=='98') {

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


	if (($varUseCountryCode=='98') || ($varUseCountryCode=='222')){
		$varActualAmount		= $arrRate[$varUseCountryCode][$varCategory];
	} else { $varActualAmount	= $arrUsdGatewayConver[$varCategory]; }


	if ($varPercentageDiscount=='yes'){
				
				$varDiscountPercentage	= (($varActualAmount * $varDiscountRate) / 100);
				$varActualAmount		= round($varActualAmount - $varDiscountPercentage);
	} else {
			if ($varDiscountRate > 0) { 
				$varPackageCost			= $varActualAmount;
				$varActualAmount		= ($varActualAmount - $varDiscountRate); 
			}

		}//else


//PREPAYMENT TRACKING PURPOSE....
$varCondition	  = " OrderId=".$objMasterDB->doEscapeString($varOrderId,$objMasterDB);
$varFields		  = array('Amount_Paid','Currency','Gateway','Payment_Mode','Date_Paid');
$varFieldsValues  = array($objMasterDB->doEscapeString($varActualAmount,$objMasterDB),"'".$varPaidCurrency."'",'\'4\'','\'1\'','NOW()');
$objMasterDB->update($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varFieldsValues,$varCondition);


}//if



$objMasterDB->dbClose();
UNSET($objMasterDB);
?>