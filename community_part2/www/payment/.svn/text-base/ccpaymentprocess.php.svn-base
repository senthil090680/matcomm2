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
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/lib/clsCCAvenue.php");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath."/www/payment/paymentprocess.php");
include_once($varRootBasePath."/lib/clsPayment.php");
include_once($varRootBasePath."/www/payment/ip2location.php"); // Added by Ashok to show offer link for India alone

//VARIABLLE DECLARATIONS
$sessMatriId		= $varGetCookieInfo["MATRIID"];

//SETING MEMCACHE KEY
$varOwnProfileMCKey		= 'ProfileInfo_'.$sessMatriId;

//CHECK ALREADY LOGGED USER
if($sessMatriId =='') { header ("Location:../login/"); exit; }//if

//OBJECT DECLARATION
$objDB	= new MemcacheDB;
$objCCAvenue	= new CCAvenue;
$objPayment		= new Payment;

//VARIABLLE DECLARATIONS
$varProcess						= 'yes';
$varTotalDays					= 0;
$varAmount						= $_REQUEST["Amount"];
$varOrderId						= $_REQUEST["Order_Id"];
$varAuthDesc					= $_REQUEST["AuthDesc"];
$varCheckSum1					= $_REQUEST["Checksum"];
$varMerchantParam				= $_REQUEST["Merchant_Param"];
$varSplit						= split("-",$varMerchantParam);
$varCategory					= trim($varSplit[1]);
$varTotalDays					= trim($varSplit[2]);
$varCountryCode					= trim($varSplit[3]);
$varPackageCost					= $arrRate[$varCountryCode][$varCategory];
if ($varCategory >=4 && $varCategory<=6) { $varSpecialPrev = 1; }
else if ($varCategory >=7 && $varCategory<=9) { $varSpecialPrev = 2; }
else { $varSpecialPrev = 0; }

//OFFER PRPDUCT ID
$varOfferGiven		= 0;

$varCheckSum					= $objCCAvenue->verifychecksum($varMerchantId,$varOrderId,$varAmount,$varAuthDesc,$varCheckSum1,$varWorkingKey);


//DB CONNECTION
$objDB->dbConnect('M',$varDbInfo['DATABASE']);


//CHECK OFFER
include_once($varRootBasePath."/www/payment/offerinfo.php");


global $arrPrdPackages, $arrPhonePackage;

#$varCheckSum = "true";
#$varAuthDesc = "Y";

if(($varCheckSum == "true") && ($varAuthDesc == "Y")) {

		if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

		if(($varPaidDays < 10) && (strlen($varPaidDays) > 0) && $varDatePaid !='0000-00-00 00:00:00') {
			$varProcess = 'no';
			$varMessage	= "You have made a payment recently on ".$varDatePaid;
		}//if
	}

	if ($varProcess == 'yes') {
		//CHECK DUPLICATE ORDER ID.
		$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$varNoOfRecords = $objDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
		if ($varNoOfRecords=='1') { 
			$varMessage		= "Duplicate Order Id <b>".$varOrderId.'</b>';
			$varProcess		= 'no';
		}
	}
	if ($varProcess == 'yes') {
		//CHECK DUPLICATE ORDER ID.
		$varCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
		$varNoOfRecords = $objDB->numOfRecords($varTable['ADDONPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
		if ($varNoOfRecords=='1') { 
			$varMessage		= "Duplicate Order Id <b>".$varOrderId.'</b>';
			$varProcess		= 'no';
		}
	}

	if ($varNoOfRecords == '0' && $varProcess == 'yes') {

	if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

	//CALCULATE CURRENT TOTAL VALID DAYS
	$varFields		= array('Valid_Days','Valid_Days-(TO_DAYS(NOW())-TO_DAYS(Last_Payment)) as CurrentValidDays');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varDaysInfo	= mysql_fetch_array($varValidInfo);
	
	$varCurrentValidDays	= $varDaysInfo['CurrentValidDays'];
	if (($varCurrentValidDays >0) && ($varCurrentValidDays !="")) { $varTotalDays = ($varCurrentValidDays + $varTotalDays); }//if

	$varIPLocation = getIptoLocation();
	$varUSPaidFlag = '0';
	if ($varIPLocation!='IN' && $varNumberOfPayments=='0' && $varDatePaid=='0000-00-00 00:00:00'){
		$varUSPaidFlag = '1';
	}

	//UPDATE VALID DAYS
	$varCondition	= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varFields		= array('OfferAvailable','Last_Payment','Valid_Days','Paid_Status','Publish','Number_Of_Payments','Expiry_Date','Date_Updated','Special_Priv','US_Paid_Validated');
	$varFieldsValue	= array('0','NOW()',$varTotalDays,'1','1','Number_Of_Payments+1','DATE_ADD(NOW(),INTERVAL '.$varTotalDays.' DAY)','NOW()',$varSpecialPrev,$varUSPaidFlag);
	$objDB->update($varTable['MEMBERINFO'], $varFields, $varFieldsValue, $varCondition,$varOwnProfileMCKey);

	}

	//SELECT Package_Cost and Gateway FROM prepaymenthistoryinfo
	$varPrepaymentFields	= array('Package_Cost','Discount','Gateway','DiscountFlatRate','Display_Currency','Display_Amount_Paid','Display_Package_Cost','Product_Id','Amount_Paid');
	$varOrderIdCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varPrepaymentTrackinfo	= $objDB->select($varTable['PREPAYMENTHISTORYINFO'], $varPrepaymentFields, $varOrderIdCondition, 0);
	$varPaymentTrackInfo	= mysql_fetch_array($varPrepaymentTrackinfo);
	$varProductId	      	= $varPaymentTrackInfo["Product_Id"];
	$varAmount		      	= $varPaymentTrackInfo["Amount_Paid"];
	$varGatewayPackageCost	= $varPaymentTrackInfo["Package_Cost"];
	$varGateway				= $varPaymentTrackInfo["Gateway"];
	$varDiscount			= $varPaymentTrackInfo["Discount"];
	$varDiscountFlatRate	= $varPaymentTrackInfo["DiscountFlatRate"];
	$varDisplayCurrency		= $varPaymentTrackInfo["Display_Currency"];
	$varDisplayAmountPaid	= $varPaymentTrackInfo["Display_Amount_Paid"];
	$varDisplayPackageCost	= $varPaymentTrackInfo["Display_Package_Cost"];

    if($varProductId!=120){
	//INSERT PAYMENT TABLE
	$varFields		= array('OrderId','MatriId','User_Name','Product_Id','Offer_Product_Id','Amount_Paid','Discount','DiscountFlatRate','Package_Cost','Currency','Payment_Type','Payment_Mode','Offer_Given','Date_Paid','Payment_Gateway','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
	$argFieldsValue	= array($objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varUserName,$objDB),$objDB->doEscapeString($varCategory,$objDB),$objDB->doEscapeString($varOfferProductId,$objDB),$objDB->doEscapeString($varAmount,$objDB),$objDB->doEscapeString($varDiscount,$objDB),$objDB->doEscapeString($varDiscountFlatRate,$objDB),$objDB->doEscapeString($varGatewayPackageCost,$objDB),'\'Rs\'','1','1',$objDB->doEscapeString($varOfferGiven,$objDB),'NOW()',$objDB->doEscapeString($varGateway,$objDB),$objDB->doEscapeString($varDisplayCurrency,$objDB),$objDB->doEscapeString($varDisplayAmountPaid,$objDB),$objDB->doEscapeString($varDisplayPackageCost,$objDB));
	$objDB->insert($varTable['PAYMENTHISTORYINFO'], $varFields, $argFieldsValue);
	}


    $varCondition		 = " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varAddonNoOfRecords = $objDB->numOfRecords($varTable['ADDONPREPAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);

	$varMatriIdPrefix	= substr($sessMatriId,0,3);
	$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
    
	## -------------------- Profile Highlighter Part Start-------------------------------------##
	## ADDON PACKAGE(PROFILE HIGHLIGHTER) DETAILS UPDATED IN DB
	$varAddonAmountPaid = '';
	if($varAddonNoOfRecords>0){

    $varPrepaymentFields	= array('Amount_Paid','Package_Cost','Product_Id','Gateway','Display_Currency','Display_Amount_Paid','Display_Package_Cost','Currency');
	$varOrderIdCondition	= " WHERE OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varPrepaymentTrackinfo	= $objDB->select($varTable['ADDONPREPAYMENTHISTORYINFO'], $varPrepaymentFields, $varOrderIdCondition, 0);
	$varPaymentTrackInfo		= mysql_fetch_array($varPrepaymentTrackinfo);
	$varAddonProductId			= $varPaymentTrackInfo["Product_Id"];
	$varAddonCurrency			= $varPaymentTrackInfo["Currency"];
	$varAddonAmountPaid			= $varPaymentTrackInfo["Amount_Paid"];
	$varAddonGatewayPackageCost	= $varPaymentTrackInfo["Package_Cost"];
	$varAddonGateway			= $varPaymentTrackInfo["Gateway"];
	$varAddonDisplayCurrency	= $varPaymentTrackInfo["Display_Currency"];
	$varAddonDisplayAmountPaid	= $varPaymentTrackInfo["Display_Amount_Paid"];
	$varAddonDisplayPackageCost	= $varPaymentTrackInfo["Display_Package_Cost"];

	$varFields		= array('Gender','Photo_Set_Status','Protect_Photo_Set_Status');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varDaysInfo	= mysql_fetch_array($varValidInfo);

	## INSERT ADDON PAYMENT TABLE
	$varFields		= array('OrderId','MatriId','Product_Id','Amount_Paid','Package_Cost','Currency','Payment_Type','Payment_Mode','Date_Paid','Payment_Gateway','Display_Currency','Display_Amount_Paid','Display_Package_Cost');
	$argFieldsValue	= array($objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),"'".$varAddonProductId."'","'".$varAddonAmountPaid."'","'".$varAddonGatewayPackageCost."'","'".$varAddonCurrency."'",'1','1','NOW()',"'".$varGateway."'","'".$varAddonDisplayCurrency."'","'".$varAddonDisplayAmountPaid."'","'".$varAddonDisplayPackageCost."'");
	$objDB->insert($varTable['ADDONPAYMENTHISTORYINFO'], $varFields, $argFieldsValue);
    
	## Check Package Already Purchased
	$varFields			 = array('Expiry_Date');
	$varCondition		 = " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varAddonPacRecord   = $objDB->select($varTable['PROFILEHIGHLIGHTDET'], $varFields, $varCondition,1);
	
	## INSERT ADDON PACKAGE DETAILS TABLE
	$varHighlightStatus = 0;
	$varFields		    = array('MatriId','Gender','Date_Paid','Expiry_Date','Highlight_Status','Date_Updated');
		if($varDaysInfo['Photo_Set_Status'] == 1 ){
			
			if(!empty($varAddonPacRecord)){
				$varAddonValidDays = 'DATE_ADD("'.$varAddonPacRecord[0]['Expiry_Date'].'",INTERVAL 60 DAY)';
			}else{
				$varAddonValidDays = 'DATE_ADD(NOW(),INTERVAL 60 DAY)';
			}
			if($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 0){
				$varHighlightStatus = 1;
			}elseif($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 1){
				$varHighlightStatus = 0;
			}

		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',$varAddonValidDays,$varHighlightStatus,'NOW()');
		}else{ ## Put mail to customer care team for follow customer to upload photo
		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',"'0000-00-00 00:00:00'",$varHighlightStatus,'NOW()');
		}
	$objDB->insertOnDuplicate($varTable['PROFILEHIGHLIGHTDET'], $varFields, $argFieldsValue,'MatriId');
	
	if($varHighlightStatus==0){
		sendProfileHighlighterRemaindermail($sessMatriId,$varCBSDomainName,$varDaysInfo['Protect_Photo_Set_Status']);
	}

    }elseif($varCategory == 48 || ($varCategory>=7 && $varCategory<=9)){
        ## Privilege Packages and Platinum has default profile highlighter package
        
		$varFields		= array('Gender','Photo_Set_Status','Protect_Photo_Set_Status');
		$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$varValidInfo	= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
		$varDaysInfo	= mysql_fetch_array($varValidInfo);

		## Check Package Already Purchased
		$varFields			 = array('Expiry_Date');
		$varCondition		 = " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
		$varAddonPacRecord   = $objDB->select($varTable['PROFILEHIGHLIGHTDET'], $varFields, $varCondition,1);

		if(!empty($varAddonPacRecord)){
			$varValiddays='"'.$varAddonPacRecord[0]['Expiry_Date'].'"';
		}else{$varValiddays='NOW()';}

        $varHighlightStatus  = 0;
		if($varCategory>=7 && $varCategory<=9){
				$varAddonValidDays = 'DATE_ADD('.$varValiddays.',INTERVAL 2 WEEK)';
		}else{
				$varAddonValidDays = 'DATE_ADD('.$varValiddays.',INTERVAL 60 DAY)';
		}
        ## INSERT ADDON PACKAGE DETAILS TABLE
		$varFields		= array('MatriId','Gender','Date_Paid','Expiry_Date','Highlight_Status','Date_Updated');
		if($varDaysInfo['Photo_Set_Status'] == 1 ){
			
			if($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 0){
				$varHighlightStatus = 1;
			}elseif($varDaysInfo['Photo_Set_Status'] == 1 && $varDaysInfo['Protect_Photo_Set_Status'] == 1){
				$varHighlightStatus = 0;
			}

		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',$varAddonValidDays,$varHighlightStatus,'NOW()');
		}else{ ## Put mail to customer care team for follow customer to upload photo
		$argFieldsValue	= array($objDB->doEscapeString($sessMatriId,$objDB),$varDaysInfo['Gender'],'NOW()',"'0000-00-00 00:00:00'",$varHighlightStatus,'NOW()');
		}
		$objDB->insertOnDuplicate($varTable['PROFILEHIGHLIGHTDET'], $varFields, $argFieldsValue,'MatriId');
		
		if($varHighlightStatus==0){
		sendProfileHighlighterRemaindermail($sessMatriId,$varCBSDomainName,$varDaysInfo['Protect_Photo_Set_Status']);
	    }
	
	}
   ## -------------------- Profile Highlighter Part End-------------------------------------##


	//INSERT paymentauthorization TABLE
	$varFields			= array('Gateway','OrderNumber','MatriId','User_Name','Product_Id','Amount_Paid','Date_Paid');
	$varFieldsValue	= array('1',$objDB->doEscapeString($varOrderId,$objDB),$objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varUserName,$objDB),$objDB->doEscapeString($varCategory,$objDB),$objDB->doEscapeString($varAmount,$objDB),'NOW()');
	$objDB->insert($varTable['PAYMENTAUTHORIZATION'], $varFields, $varFieldsValue);


	if ($varCategory !='110' && $varCategory !='111' && $varCategory !='112') {

	$varActualPhone		= $arrPhonePackage[$varDisPlayId];
	$varActualPhoneCnt	= $varActualPhone ? $varActualPhone : 0;
	$varTotalPhoneCnt	= ($varActualPhoneCnt + $varExtraPhone);

	//INSERT PHONE NUMBER
	$varFields			= array('MatriId','TotalPhoneNos','NumbersLeft');
	$varFieldsValues	= array($objDB->doEscapeString($sessMatriId,$objDB),"TotalPhoneNos+".$varTotalPhoneCnt,"NumbersLeft+".$varTotalPhoneCnt);
	$objDB->insertOnDuplicate($varTable['PHONEPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId');

	}

	if (($varCategory =='110') || ($varCategory =='111') || ($varCategory =='112') || ($varCheckHoroscopeOffer=='extrahoroscope')) {

	$varActualHoro		= $arrAstroPackage[$varCategory];
	$varActualCount		= $varActualHoro ? $varActualHoro : 0;
	$varTotalHoroCnt	= ($varActualHoro + $varExtraHoroscope);

	//INSERT PHONE NUMBER
	$varFields			= array('MatriId','TotalMatchNos','NumbersLeft');
	$varFieldsValues	= array($objDB->doEscapeString($sessMatriId,$objDB),"TotalMatchNos+".$varTotalHoroCnt,"NumbersLeft+".$varTotalHoroCnt);
	$objDB->insertOnDuplicate($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varFieldsValues, 'MatriId');

	}


	if ($varCategory !='100' && $varCategory !='110' && $varCategory !='111' && $varCategory !='112' && $varCategory !='120') {

	$varFields		= array('Email');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varExecute		= $objDB->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition, 0);
	$varEmailInfo	= mysql_fetch_array($varExecute);
	$varEmail	= $varEmailInfo['Email'];

	//CHECK LAST PAYMENT TIME
	$varFields		= array('Last_Payment','Name','Nick_Name','Expiry_Date');
	$varCondition	= " WHERE MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$varSelect		= $objDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varMemberInfo	= mysql_fetch_array($varSelect);
	$varLastPayment	= $varMemberInfo['Last_Payment'];
	$varName		= $varMemberInfo['Name'];
	$varNickName	= $varMemberInfo['Nick_Name'];
	$varName		= $varNickName ? $varNickName : $varName;
	$varSplitExpiry	= split(" ",trim($varMemberInfo['Expiry_Date']));

	$varOfferContent = '';	
	$varIPLocation	 = getIptoLocation();
	if(in_array($varCategory,$varReebokOfferCatIds) && $varIPLocation=='IN' && $varReebokOffer==1) {

		$varOfferContent = '<tr><td align="left" class="fleft smalltxt">Please provide your <a href="'.$confValues["SERVERURL"].'/site/index.php?act=paymentgift" target="_blank" class="clr5">Postal Address</a>, we will deliver your Reebok Watch within 7 days. In case you have any questions or queries, please contact our Customer care at 1-800-3000-2222.</td></tr>';
	}

	$varMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varDisPlayId];
	if($varAddonNoOfRecords>0){
		$varMessage		.=' with '.$arrPrdPackages[120];
		$varProfileHighlighter   = 1;
	}
	$varMessage		.="<br><br><b>Validity period :</b> ".$varTotalDays." days".$varExtraHoroCnt."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr>".$varOfferContent."</table>";

	if($varAddonAmountPaid>0){
			$varAmount = $varAmount + $varAddonAmountPaid;
    }
   
	//SEND MAIL
	$varPaymentMode		= 0;
	$varPaymentType		= 1;
	$varAmountWithCurr	= 'Rs. '.$varAmount;
	$varExpiryDate		= 'From '.date('Y-m-d').' To '.$varSplitExpiry[0];
	//$varTotalPhone		= ($arrPhonePackage[$varDisPlayId]+$varExtraPhone);
	$varActualPhone1	= $arrPhonePackage[$varDisPlayId];
	$varActualPhoneCnt1	= $varActualPhone1 ? $varActualPhone1 : 0;
	$varTotalPhone		= ($varActualPhoneCnt1 + $varExtraPhone);

		$objPayment->paymentConfirmation($sessMatriId,$varName,$varEmail,$varCategory,$varAmountWithCurr,$varPaymentMode,$varPaymentType,$varExpiryDate,$varIPLocation,$varOfferProductId,$varTotalPhone,$varProfileHighlighter);
	}

	if ($varCategory =='100') {

		$varMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Phone Count :</b> ".$arrPhonePackage[$varCategory]."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr></table>";
	}


	if (($varCategory =='110') || ($varCategory =='111') || ($varCategory =='112')) {

		$varMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Astro Count :</b> ".($arrAstroPackage[$varCategory]+$varExtraHoroscope)."<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr></table>";
	}
	if (($varCategory =='120')) {

		$varMessage		= "<table cellpadding=0 cellspacing=0 width='675'><tr><td align=left><div class='fleft smalltxt'>Thank you for making payment. Your membership details are as follows.<br><br><b>Membership type :</b> ".$arrPrdPackages[$varCategory]."<br><br><b>Validity period :</b> ".$varTotalDays." days<br><br><b>Date last upgraded :</b> ".date('d-m-Y')."<br><br></td></tr>".$varOfferContent."</table>";
	}

	}

	//DELETE BEFORE VALIDATION TBALE
	$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$objDB->delete('onlinepaymentfailures', $varCondition12);

	$objDB->dbClose();

	//PRIVILEGE MAIL
	if ($varCategory=='48'){

	$objPrivilege	= new MemcacheDB;
	$objPrivilege->dbConnect('M','cbsrminterface');

	//INSERT RMMEMBERINFO TABLE
	$varPrivilege1			= array('MatriId','MemberName','ProductId','ValidDays','ExpiryDate','PrivStatus','PaidStatus','TimeCreated');
	$varPrivilegeValues1	= array($objDB->doEscapeString($sessMatriId,$objDB),$objDB->doEscapeString($varName,$objDB),$objDB->doEscapeString($varCategory,$objDB),"'".$varTotalDays."'",'DATE_ADD(NOW(),INTERVAL '.$varTotalDays.' DAY)','2','1','NOW()');
	$objPrivilege->insertOnDuplicate('rmmemberinfo', $varPrivilege1, $varPrivilegeValues1, 'MatriId');
	$objPrivilege->dbClose();
	UNSET($objPrivilege);

	$objPayment->privilegeMail($sessMatriId,$varName,$varEmail,date('Y-m-d'));

	}//if




} else {

	$varFileName = '';
	if ($varCategory=='100') { $varFileName = '?act=additionalpayment';  }
	if (($varCategory=='110') || ($varCategory=='111') || ($varCategory=='112')) { $varFileName = '?act=additionalpayment&astro=1';  }
	$varMessage	= '<font class="smalltxt">Thank you for your interest in making payment. Sorry, your payment has failed due to one of the following reasons: <ul><li>Incorrect credit card details</li><li>Credit card expired</li><li>Insufficient funds</li></ul><a href="'.$confValues["SERVERURL"].'/payment/'.$varFileName.'" class="smalltxt clr1">Click here</a> if you wish to try again.<br><br>For any queries you can contact our <a href="'.$confValues["SERVERURL"].'/site/index.php?act=feedback" class="clr1" target="_blank">24x7 customer support</a> team.';

	$varCondition	= " OrderId =".$objDB->doEscapeString($varOrderId,$objDB);
	$varFields		= array('Gateway_Status','Reason_Of_Failure');
	$varFieldsValue	= array($objDB->doEscapeString($varAuthDesc,$objDB),$objDB->doEscapeString($varCheckSum,$objDB));
	$objDB->update($varTable['PREPAYMENTHISTORYINFO'], $varFields, $varFieldsValue, $varCondition);

	$varFields12		= array('3dSecureFailure');
	$varFieldsValue12	= array('1');
	$varCondition12		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$objDB->update('onlinepaymentfailures', $varFields12, $varFieldsValue12, $varCondition12);


	$objDB->dbClose();
}
function sendProfileHighlighterRemaindermail($sessMatriId,$varDomainName,$varProtectedStatus){ 
	$subject = "Profile Highlighter Package Member Folloup Mail";
	$message = "Hi Team,<br><br>\n\n";
	if($varProtectedStatus==0){
	$message.= "The member($sessMatriId) bought profile highlighter package but photo is not uploaded so kindly contact and make them to uploade the photo.";
	}else{
    $message.= "The member($sessMatriId) bought profile highlighter package but photo protected status is ON so kindly contact and make them to set photo protected status OFF.";
	}
	$message.= "<br><br>Thanks,<br>\n";
	$message.= ucwords($varDomainName)." Team";	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: info@".$varDomainName." <info@".$varDomainName.">\n";	

	$mail3 = mail('nazir@bharatmatrimony.com', $subject, $message, $headers);
   }

include_once($varRootBasePath.'/www/template/paymentheader.php');
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="700" bgcolor=#FFFFFF>
	<tr>
		<td valign="top" width="700" bgcolor="#FFFFFF"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="normtxt1 clr bld">Payment Confirmation</font></div>
			<table border="0" width="650" cellpadding="5" cellspacing="0">
				<tr>
					<td valign="top" width="20"></td>
					<td valign="middle" class="smalltxt"><?=$varMessage;?><br><br></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td align="center" style="padding-bottom:10px;"><input type="button" class="button pntr" onClick="javscript:window.location='<?=$confValues["SERVERURL"];?>/payment/csetredirect.php';" value="Back to My Home"></td></tr>
 </table>
<?php include_once($varRootBasePath.'/www/template/paymentfooter.php'); ?>
<script src="<?=$confValues['SERVERURL']?>/login/updateprofilecookie.php"></script>