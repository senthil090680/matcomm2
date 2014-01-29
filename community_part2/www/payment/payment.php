<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2006-06-19
# End Date		: 2006-06-19
# Project		: MatrimonyProduct
# Module		: Payment Option Page
#=============================================================================================================

//VARIABLE DECLARATIONS
$varFormSubmit		= $_POST["frmPaymentSubmit"];
$varCountryCode		= trim($_REQUEST['countryCode']); // from mailer country code
//$varCountryCode		= '';
$varCategory		= trim($_REQUEST['category']); // Product Id
$varSoureFrom		= trim($_REQUEST['soureFrom']);
$varSoureFrom		= $varSoureFrom ? $varSoureFrom : 2;
$varDiv				= 'no';
$varDiscountRate	= '0';
$varPrivilegeDiscountRate	= '0';
$varCheckRenewalOffer	    = 0;
$varBakridOffer             = 'no';
$varNRIRenewal				= 0;

//echo "<pre>";print_r($varGetCookieInfo);
//INCLUDE FILES
include_once($varRootBasePath."/www/payment/paymentprocess.php");

//CHECK GATEWAY
if ($varUseCountryCode==98 && $varInrGateWayAvailable==1) { $varGateWay = 1;}
else if ($varUseCountryCode!=98 && $varUsdGateWayAvailable==1) { $varGateWay = 3; }

//VARIABLE DECLARATION
$sessMatriId		= $varGetCookieInfo['MATRIID'];
$sessUsername		= $varGetCookieInfo['USERNAME'];
$varOfferAvailable	= $varGetCookieInfo['OFFERAVAILABLE'];
$varOfferCategoryId = $varGetCookieInfo['OFFERCATEGORYID'];
$varMotherTongueId	= $varGetCookieInfo['MOTHERTONGUE'];
$varReligion		= $varGetCookieInfo['RELIGION'];
$varSpecialOffer1	= '';
$varSpecialOffer2	= '';
$varSpecialOffer3	= '';
$varSelectOfferName	= 2;
$varDiscountContent	= 'Get<br />'.$varDiscountPercentageValue.'% discount';

$varAddLocation	    = $varCountryCode ? $varCountryCode : $arrCountryCurrency[$varIPLocation];
$varRenewalImage	= 'sp-img1';

$varMotherTongueId		= $varMotherTongueId ? $varMotherTongueId : trim($_REQUEST["mtid"]);
$varCheckRenewalOffer	= trim($_REQUEST["mtype"]);
$varCheckRenewalOffer	= $varCheckRenewalOffer ? $varCheckRenewalOffer : 0;
$varPhStatus			= $_REQUEST['phstatus'] ? 'CHECKED' : '';

if ($sessMatriId !='') {
	$objMasterDB= new DB;
	$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);

	$varFields		     = array('Mother_TongueId','Profile_Created_By','Number_of_payments');
	$varCondition	     = " WHERE MatriId =".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varExecute1         = $objMasterDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	$varMemberInfo12     = mysql_fetch_array($varExecute1);
	$varMotherTongueId   = $varMemberInfo12["Mother_TongueId"];
	$varProfileCreatedBy = $varMemberInfo12["Profile_Created_By"];
	$varNumberOfPayments = $varMemberInfo12["Number_of_payments"];

	$varFields		= array('MatriId','Source_From','Date_Captured','Product_Id','Paid_Status','IP_Address','IP2Location');
	$varFieldsValue	= array($objMasterDB->doEscapeString($sessMatriId,$objMasterDB),$objMasterDB->doEscapeString($varSoureFrom,$objMasterDB),'NOW()',$objMasterDB->doEscapeString($varCategory,$objMasterDB),$objMasterDB->doEscapeString($varPaidStatus,$objMasterDB),$objMasterDB->doEscapeString($_SERVER['REMOTE_ADDR'],$objMasterDB),$objMasterDB->doEscapeString($varIPLocation,$objMasterDB));
	$objMasterDB->insert($varTable['PREPAYMENTTRACKINFO'], $varFields, $varFieldsValue);

	if ($varOfferAvailable=='1') {
		//SELECT OFFERCODEINFO//
		$varCondition	= " WHERE MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varFields		= array('MatriId','OfferCategoryId','OfferCode','OfferStartDate','OfferEndDate','OfferAvailedStatus','OfferAvailedOn','OfferSource','MemberExtraPhoneNumbers','MemberDiscountPercentage','MemberDiscountINRFlatRate','MemberDiscountUSDFlatRate','MemberDiscountEUROFlatRate','MemberDiscountAEDFlatRate','MemberDiscountGBPFlatRate','MemberAssuredGift','AssuredGiftSelected','MemberNextLevelOffer','MemberExtraDays','DateUpdated','OmmParticipation');
		$varExecute			= $objMasterDB->select($varTable['OFFERCODEINFO'], $varFields, $varCondition,0);
		$varMemberInfo		= mysql_fetch_array($varExecute);
		$varMemberDiscountINRFlatRate	= trim($varMemberInfo["MemberDiscountINRFlatRate"]);
		$varMemberDiscountAEDFlatRate	= trim($varMemberInfo["MemberDiscountAEDFlatRate"]);
		$varMemberDiscountUSDFlatRate	= trim($varMemberInfo["MemberDiscountUSDFlatRate"]);
		$varMemberDiscountEUROFlatRate	= trim($varMemberInfo["MemberDiscountEUROFlatRate"]);
		$varMemberDiscountGBPFlatRate	= trim($varMemberInfo["MemberDiscountGBPFlatRate"]);
		$varMemberDiscountPercentage	= trim($varMemberInfo["MemberDiscountPercentage"]);
		$varMemberNextLevelOffer		= trim($varMemberInfo["MemberNextLevelOffer"]);
		$varMemberExtraDays				= trim($varMemberInfo["MemberExtraDays"]);

		if (($varMemberDiscountINRFlatRate !="") || ($varMemberDiscountAEDFlatRate !="") || ($varMemberDiscountUSDFlatRate !="") || ($varMemberDiscountEUROFlatRate !="") || ($varMemberDiscountGBPFlatRate !="")){
			$varSelectOfferName	= 1;
			$varSpecialOffer1 = 'CHECKED';

		}
		else if ($varMemberDiscountPercentage !=""){
			$varSelectOfferName	= 2;
			$varSpecialOffer1	= 'CHECKED';
			$varDiscountContent	= 'Get<br />'.$varDiscountPercentageValue.'% discount';

		}
		elseif ($varMemberNextLevelOffer !=""){ $varSpecialOffer2 = 'CHECKED'; }
		else if ($varMemberExtraDays !=""){ $varSpecialOffer3 = 'CHECKED'; }

		if($varSpecialOffer1 =='' && $varSpecialOffer2=='' && $varSpecialOffer3=='' &&  $varNumberOfPayments>0)         $varSpecialOffer2 = 'CHECKED';


	}else{
		if($varSpecialOffer1 =='' && $varSpecialOffer2=='' && $varSpecialOffer3=='' &&  $varNumberOfPayments>0)         $varSpecialOffer2 = 'CHECKED';
	}

	if ($varOfferAvailable=='1' && ($varOfferCategoryId != $varRenewalOfferCategoryId)) {
		if ($varMemberDiscountINRFlatRate !="") {
			$varSplitFlatDiscount	= split('\|',$varMemberDiscountINRFlatRate);
			$varDiscountAmount		= '1';
			$varDiscountAvail		= '98';
			$varDiscountContent		= 'Flat discount for each package';
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
	} else {
		// Default offer - ie. Renewal offer //
		$varCondition	= " WHERE ((DATEDIFF(NOW(),Last_Payment) > 10 AND Paid_Status=1) OR (Number_Of_Payments > 0 AND Paid_Status=0)) AND (OfferAvailable = 0 OR (OfferCategoryId = 1053 AND OfferAvailable = 1)) AND MatriId =".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
		$varCheckRenewalOffer = $objMasterDB->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varCondition);
		if ($varUseCountryCode!=98 && $varCheckRenewalOffer >0) { $varCheckRenewalOffer = 0; $varNRIRenewal=1;  }
    }
	$objMasterDB->dbClose();
}//if

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

		$varValue = round(($varSplitDiscount[1]*$$varGetDiscount));

	}
	$arrSplitDiscount[$varKey]	= $varValue;
}
ksort($arrSplitDiscount);

$arrCountryPayments		= array(98=>'India',222=>'USA',220=>'DUBAI, UAE');
$localCurrOfferRate		= $arrConversionRate;
$localCurrOriginalRate	= $arrRate[$varUseCountryCode];
$arrDomainSegmentOffer	= $arrOffRate[$varUseCountryCode];

if($varUseCountryCode=='98'){
	$varSubmitFunction	= 'funValidatePaymentRI();';
}else if($varUseCountryCode=='162'){
	$varSubmitFunction	= 'funValidatePaymentPKR();';
}else{
	$varSubmitFunction	= 'funValidatePaymentNRI();';
}


?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/opacity.js" ></script>
<script language='javascript'>
var submitbtcon='<div class="fright" align="center"><input type="submit" class="button pntr" id="continuepayment" name="continue" value="Continue"></div>';

var arr_cbspackage = new Array();
arr_cbspackage[1]="Gold";
arr_cbspackage[2]="Gold";
arr_cbspackage[3]="Gold";
arr_cbspackage[4]="Super Gold";
arr_cbspackage[5]="Super Gold";
arr_cbspackage[6]="Super Gold";
arr_cbspackage[7]="Platinum";
arr_cbspackage[8]="Platinum";
arr_cbspackage[9]="Platinum";
arr_cbspackage[48]="Privilege";

function payoptsubbtn()
	{
		var frmPaymentOption = document.frmPaymentOption;
		var objlen = frmPaymentOption.paymentMode.length;
		var divnamebtn;
		$('div_payment_common_submit').style.display="none";
		for(i=0;i<objlen;i++)
		{
			if(frmPaymentOption.paymentMode[i].name=="paymentMode")
			{
				divnamebtn=frmPaymentOption.paymentMode[i].id+'BTNDIV';
				if(frmPaymentOption.paymentMode[i].checked==true){
					document.getElementById(divnamebtn).innerHTML=submitbtcon;
					document.getElementById('continuepayment').focus();
					//SetpaybuttonCookie("PAYBUTTONCOOKIE",frmPaymentOption.paymentMode.id);
				}else{
					document.getElementById(divnamebtn).innerHTML='';
				}

			}
		}


	}
	function SetpaybuttonCookie(cookieName,cookieValue) {
	 var today = new Date();
	 var expire = new Date();
	 expire.setTime(today.getTime() + 3600000*24);
	 document.cookie = cookieName+"="+escape(cookieValue)+";path=/;domain=agarwalmatrimony.com;expires="+expire.toGMTString();
	}
	function getpaybuttonCookie(c_name)
	{
      alert(c_name);
	  if (document.cookie.length>0)
	  {
		  c_start=document.cookie.indexOf(c_name + "=");
		  if (c_start!=-1)
			{
			c_start=c_start + c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			var cookgetpayval= unescape(document.cookie.substring(c_start,c_end));
			document.getElementById(cookgetpayval).checked=true;
			var divnamegetbtn=cookgetpayval+'BTNDIV';
			document.getElementById(divnamegetbtn).innerHTML=submitbtcon;
			$('div_payment_common_submit').style.display="none";
			}
	  }
	}
	function funValidatePaymentRI() {

		var frmPaymentOption = document.frmPaymentOption;
        var renewalOffer = frmPaymentOption.renewalOffer.value;

	    if(renewalOffer > 0) {
          if(funCheckRenewalOffer() == false) {
			alert("Please select the offer");
            frmPaymentOption.checkOffer[0].focus();
			return false;
		  }
		}

		if(!(frmPaymentOption.category[0].checked) && !(frmPaymentOption.category[1].checked) && !(frmPaymentOption.category[2].checked) && !(frmPaymentOption.category[3].checked) && !(frmPaymentOption.category[4].checked) && !(frmPaymentOption.category[5].checked) && !(frmPaymentOption.category[6].checked) && !(frmPaymentOption.category[7].checked) && !(frmPaymentOption.category[8].checked) && !(frmPaymentOption.category[9].checked))
		{
			alert("Please select the membership package.");
			frmPaymentOption.category[0].focus();
			return false;
		}//if
		if(!(frmPaymentOption.paymentMode[0].checked) && !(frmPaymentOption.paymentMode[1].checked) && !(frmPaymentOption.paymentMode[2].checked) && !(frmPaymentOption.paymentMode[3].checked) && !(frmPaymentOption.paymentMode[4].checked) && !(frmPaymentOption.paymentMode[5].checked)) {
			alert("Please select your payment mode.");
			frmPaymentOption.paymentMode[0].focus();
			return false;
		}//if
		if (frmPaymentOption.matriId.value !="") {

			if (frmPaymentOption.paymentMode[0].checked==true) {

				frmPaymentOption.action ='<?=$varMigsURL_INR?>'; //[ ICICI Gateway ]

			} else if (frmPaymentOption.paymentMode[1].checked==true) {

				frmPaymentOption.action ='<?=$varCCAvenueURL?>';//[ CCAvenue ]

			} else if (frmPaymentOption.paymentMode[2].checked==true) {

				frmPaymentOption.action ='index.php?act=doorstep'; //[ DOOR STEP ]

			} else if (frmPaymentOption.paymentMode[3].checked==true) {

				frmPaymentOption.action ='<?=$varCommuityOfficeURL?>'; //[ Community Office ]

			} else if(frmPaymentOption.paymentMode[4].checked==true) {

				frmPaymentOption.action ='<?=$varIVRS?>'; //[ IVRS PAYMENT ]

			} else if(frmPaymentOption.paymentMode[5].checked==true) {

				frmPaymentOption.action ='<?=$varBankURL?>'; //[ Pay at bank ]
			} else { frmPaymentOption.action ='<?=$varCCAvenueURL?>'; } //[ CCAvenue ]

		} else if (frmPaymentOption.paymentMode[2].checked==true) {

				frmPaymentOption.action ='index.php?act=doorstep'; //[ DOOR STEP ]

		} else if (frmPaymentOption.paymentMode[3].checked==true) {

				frmPaymentOption.action ='<?=$varCommuityOfficeURL?>'; //[ Community Office ]

		} else if(frmPaymentOption.paymentMode[5].checked==true) {

				frmPaymentOption.action ='<?=$varBankURL?>'; //[ Pay at bank ]
		}
		return true;
	}//funValidatePaymentRI

	function funValidatePaymentNRI() {

		var frmPaymentOption = document.frmPaymentOption;
        var renewalOffer = document.frmPaymentOption.renewalOffer.value;

	    if(renewalOffer > 0) {
          if(funCheckRenewalOffer() == false) {
			alert("Please select the offer");
            frmPaymentOption.checkOffer[0].focus();
			return false;
		  }
		}

		if(!(frmPaymentOption.category[0].checked) && !(frmPaymentOption.category[1].checked) && !(frmPaymentOption.category[2].checked) && !(frmPaymentOption.category[3].checked) && !(frmPaymentOption.category[4].checked) && !(frmPaymentOption.category[5].checked) && !(frmPaymentOption.category[6].checked) && !(frmPaymentOption.category[7].checked) && !(frmPaymentOption.category[8].checked) && !(frmPaymentOption.category[9].checked))
		{
			alert("Please select the membership package.");
			frmPaymentOption.category[0].focus();
			return false;
		}//if

		if(!(frmPaymentOption.paymentMode[0].checked) && !(frmPaymentOption.paymentMode[1].checked) && !(frmPaymentOption.paymentMode[2].checked) && !(frmPaymentOption.paymentMode[3].checked) && !(frmPaymentOption.paymentMode[4].checked)) {
			alert("Please select your payment mode.");
			frmPaymentOption.paymentMode[0].focus();
			return false;
		}//if
		if (frmPaymentOption.matriId.value !="") {

			if (frmPaymentOption.paymentMode[0].checked==true) { //[ ICICI Gateway ]
				frmPaymentOption.action ='<?=$varMigsURL?>';
			}else if(frmPaymentOption.paymentMode[1].checked==true) {
				frmPaymentOption.action ='<?=$varOptimalURL?>'; //[ Optimal ]
			}else if(frmPaymentOption.paymentMode[2].checked==true) {
				frmPaymentOption.action ='<?=$varCCAvenueURL?>'; //[ CCAvenue ]
			} else if(frmPaymentOption.paymentMode[3].checked==true) {
				frmPaymentOption.action ='<?=$varCommuityOfficeURL?>'; //[ Community Office ]
			}else if(frmPaymentOption.paymentMode[4].checked==true) {
				frmPaymentOption.action ='<?=$varBankURL?>'; //[ Pay at bank ]
			} else { frmPaymentOption.action ='<?=$varCCAvenueURL?>'; } //[ CCAvenue ]

		} else if(frmPaymentOption.paymentMode[3].checked==true) {
				frmPaymentOption.action ='<?=$varCommuityOfficeURL?>'; //[ Community Office ]
		}else if(frmPaymentOption.paymentMode[4].checked==true) {
				frmPaymentOption.action ='<?=$varBankURL?>'; //[ Pay at bank ]
		}
		return true;
	}//funValidatePaymentNRI

	function funValidatePaymentPKR() {

		var frmPaymentOption = document.frmPaymentOption;
        var renewalOffer = document.frmPaymentOption.renewalOffer.value;

	    if(renewalOffer > 0) {
          if(funCheckRenewalOffer() == false) {
			alert("Please select the offer");
            frmPaymentOption.checkOffer[0].focus();
			return false;
		  }
		}

		if(!(frmPaymentOption.category[0].checked) && !(frmPaymentOption.category[1].checked) && !(frmPaymentOption.category[2].checked) && !(frmPaymentOption.category[3].checked) && !(frmPaymentOption.category[4].checked) && !(frmPaymentOption.category[5].checked) && !(frmPaymentOption.category[6].checked) && !(frmPaymentOption.category[7].checked) && !(frmPaymentOption.category[8].checked) && !(frmPaymentOption.category[9].checked))
		{
			alert("Please select the membership package.");
			frmPaymentOption.category[0].focus();
			return false;
		}//if

		if(!(frmPaymentOption.paymentMode[0].checked) && !(frmPaymentOption.paymentMode[1].checked) && !(frmPaymentOption.paymentMode[2].checked) && !(frmPaymentOption.paymentMode[3].checked)) {
			alert("Please select your payment mode.");
			frmPaymentOption.paymentMode[0].focus();
			return false;
		}//if
		if (frmPaymentOption.matriId.value !="") {

			if (frmPaymentOption.paymentMode[0].checked==true) { //[ ICICI Gateway ]
				frmPaymentOption.action ='<?=$varMigsURL?>';
			}else if(frmPaymentOption.paymentMode[1].checked==true) {
				frmPaymentOption.action ='<?=$varCCAvenueURL?>'; //[ CCAvenue ]
			} else if(frmPaymentOption.paymentMode[2].checked==true) {
				frmPaymentOption.action ='<?=$varCommuityOfficeURL?>'; //[ Community Office ]
			}else if(frmPaymentOption.paymentMode[3].checked==true) {
				frmPaymentOption.action ='<?=$varBankURL?>'; //[ Pay at bank ]
			} else { frmPaymentOption.action ='<?=$varCCAvenueURL?>'; } //[ CCAvenue ]

		} else if(frmPaymentOption.paymentMode[2].checked==true) {
				frmPaymentOption.action ='<?=$varCommuityOfficeURL?>'; //[ Community Office ]
		}else if(frmPaymentOption.paymentMode[3].checked==true) {
				frmPaymentOption.action ='<?=$varBankURL?>'; //[ Pay at bank ]
		}
		return true;
	}//funValidatePaymentNRI

	function funPayment()
	{
		window.open("indonesia-payment.html", "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=640,height=600,status=no,scrollbars=no");
	}//funPayment

	function funCheckRenewalOffer() {
     	var i =0;var selectOffer=false;
		var offerLen = frmPaymentOption.checkOffer.length;
		  for(i=0;i < offerLen;i++) {
		    if(frmPaymentOption.checkOffer[i].checked == true) {
			 selectOffer = true;
			 break;
			}
		  }
		  return selectOffer;
  	}


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

function sel(divid){
		document.getElementById(divid).style.display='block';
		document.getElementById('fade').style.display='block';
		llcom();floatdiv(divid,lpos,100).floatIt();
	}

function selclose(evId){
document.getElementById(evId).style.display='none';
document.getElementById('fade').style.display='none';
}


///////////////////Profile highlighter validation////////////////////
function delete_addon(addon){
	var PayMemberpack = this.document.frmPaymentOption;
	if(addon==1){
		PayMemberpack.proHighlighter.checked=false;
		$('spn_addon_ph').style.display="none";
	}
	set_payment_total();
}
function set_payment_total(){
	var PayMemberpack = this.document.frmPaymentOption;
	if(PayMemberpack.proHighlighter.checked==false){
		$('spn_addon_defult_msg').style.display="block";
	}else{
		$('spn_addon_defult_msg').style.display="none";
	}
	var package_chked_value=getRadioCheckedValue(PayMemberpack.category);
	var cap_opt_id = 'hid_'+package_chked_value;

	var package_amt=parseInt(document.getElementById(cap_opt_id).value);
	if(PayMemberpack.proHighlighter.checked==true){
			package_amt+=parseInt(PayMemberpack.proHighlighter.value);
	}
	$('spn_total_amt').innerHTML=package_amt; 

}
function getRadioCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	
	if(radioLength == undefined)
		if(radioObj.checked)
			return "";
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}
function add_addon(){
	var PayMemberpack = this.document.frmPaymentOption;
	var package_chked_value=getRadioCheckedValue(PayMemberpack.category);
	
	if(package_chked_value!=null && package_chked_value!="undefined" && package_chked_value!=undefined)	{}
	else{
		alert('Please select the membership package');
		return false;
	}
	if(PayMemberpack.proHighlighter.checked==true){
		$('spn_addon_ph').style.display="block";
	}else{
		$('spn_addon_ph').style.display="none";
	}
	
	set_payment_total();
	set_package_name();
}
function pay_assit(){  	
	var PayMemberpack			= this.document.frmPaymentOption;
	var package_chked_value		= getRadioCheckedValue(PayMemberpack.category);
   
	set_package_name();
	set_payment_total();
}
function set_package_name(){
	var PayMemberpack = this.document.frmPaymentOption;
	var package_chked_value=getRadioCheckedValue(PayMemberpack.category);
	$('spn_package').innerHTML=arr_cbspackage[package_chked_value];
}

</script>

<div class="rpanel fleft">
  <form method="POST" name="frmPaymentOption" action="<?=($sessMatriId=='') ? $confValues['SERVERURL'].'/login/' : $varCCAvenueURL;?>" onSubmit="return <?=$varSubmitFunction?>">
  <center>
  <div>
  
  <? if($varAct=='register_payment'){ 
	   echo $varBannerContent;
   }else{ 

  if ($varCheckRenewalOffer >0) { ?>

  <? if($confValues['DOMAINCASTEID']==2500 && (date('Y-m-d')=='2011-04-23' || date('Y-m-d')=='2011-04-24' || date('Y-m-d')=='2011-04-25')){?>
  <!--New Easter Offer Banner Stats HERE -->
  <table cellpadding="0" cellspacing="0" width="557">
	<tr>
	<td align="left" width="557" valign="top">
	<table cellpadding="0" cellspacing="0" width="557">
		  <tr><td align="left" width="557" valign="top" background="<?=$confValues['IMGSURL']?>/easter/pay-img1-easren.jpg" height="67"></td></tr>
          <tr><td align="left" valign="top" background="<?=$confValues['IMGSURL']?>/easter/pay-img2-easren.jpg" height="128">
            <table cellpadding="0" cellspacing="0" width="557">
                <tr><td align="left" valign="top" style="padding-top:15px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="557">
            		  <tr>
					  <td width="10"></td>
                      <td align="left" valign="top" width="107">
            			  <table cellpadding="0" cellspacing="0" width="97"><tr><td align="center" valign="top" height="22"><input type="radio" name="checkOffer" <?=$varSpecialOffer1?> value="<?=$arrDiscountLevel[$varSelectOfferName]?>"></td></tr>
            			  <tr><td align="center" valign="top" style="padding-top:10px;font:bold 20px Arial;color:#ffffff">Avail 10%<br />Discount</td></tr>
                          </table>
            		  </td>
            		  <td align="left" valign="top" width="257">
            		  <table cellpadding="0" cellspacing="0" width="236"><tr><td align="center" valign="top" height="22"><input type="radio" name="checkOffer" <?=$varSpecialOffer2?> value="<?=$arrDiscountLevel[3]?>"></td></tr>
            		  <tr><td align="left" valign="top" style="font:bold 20px Arial;color:#ffffff;padding-left:10px;">Next Level Upgrade</td></tr>
            		  <tr><td align="left" valign="top" style="font:12px Arial;color:#3E3E3E;padding-top:5px;">
            		   <table cellpadding="0" cellspacing="0" width="236">
					  <tr><td align="left" valign="top" height="10" width="10"><img src="<?=$confValues['IMGSURL']?>/easter/arrow.gif" width="6" height="7" alt="" vspace="3" /></td><td align="left" valign="top" style="font:11px arial;color:#ffffff" width="226">Pay for Gold & get SuperGold Membership</td></tr>
					  <tr><td align="left" valign="top" height="10" width="10"><img src="<?=$confValues['IMGSURL']?>/easter/arrow.gif" width="6" height="7" alt="" vspace="3" /></td><td align="left" valign="top" style="font:11px arial;color:#ffffff" width="226">Pay for Super Gold & get Platinum Membership</td></tr>
					  <tr><td align="left" height="10" width="10"><img src="<?=$confValues['IMGSURL']?>/easter/arrow.gif" width="6" height="7" alt="" vspace="3" /></td><td align="left" valign="top" style="font:11px arial;color:#ffffff" width="226">Pay for Platinum & get Extra Phone Numbers<font style="color:#000000">*</font></td></tr>
					  </table>
            		  </td></tr>
            		  </table>
            		  </td>
                      </tr>
		            </table>
                </td>
                </tr>                
            </table>
          </td></tr>
          <tr><td align="left" valign="top" background="<?=$confValues['IMGSURL']?>/easter/pay-img3-easren.jpg" width="557" height="45">
          <table cellpadding="0" cellspacing="0" width="557" border="0">
          <tr><td valign="top" align="left" style="padding-left:10px;padding-top:10px;font: 11px arial; color: #ffffff;"><span style="color:#000000">*</span> Platinum ( 3 months ) - 15 extra phone nos.  |  Platinum ( 6 months ) - 20 extra phone nos.<br><font style="padding-left:120px;">Platinum ( 9 months ) - 25 extra phone nos.</font></td>
		</tr>
          </table>
          </td></tr>
	</table>
	</td>
	</tr>		
  </table><br clear="all">
  <!--New Easter Offer Banner Ends HERE -->

  <?}else{?>
  <!-- NEW Renewal Offer banner - Starts -->
  <div>
  <table border="0" cellpadding="0" cellspacing="0" width="557">
  <tr><td align="left" background="<?=$confValues['IMGSURL']?>/special/sp_renew1.gif" height="54">
  <table border="0" cellpadding="0" cellspacing="0" width="557"><tr><td align="right" valign="middle" style="font:13px arial;color:#FDB335;padding-right:10px;">
  <b>Hurry!</b> Offer ends  
  <? if($varGetCookieInfo['OFFERENDDATE']!=0){echo 'on '.date("jS F Y", strtotime($varGetCookieInfo['OFFERENDDATE']));}else{echo 'today';}?>
  
  </td></tr></table></td></tr>
  <tr><td align="left" valign="top" background="<?=$confValues['IMGSURL']?>/special/splrenew2.gif" height="127">
	  <table border="0" cellpadding="0" cellspacing="0" width="557">
	  <tr><td align="left" valign="top" width="50">&nbsp;</td><td align="left" valign="top" width="120" style="padding-top:18px;">
		  <table cellpadding="0" cellspacing="0" width="120"><tr><td align="center" valign="top" height="22"><input type="radio" name="checkOffer" <?=$varSpecialOffer1?> value="<?=$arrDiscountLevel[$varSelectOfferName]?>"></td></tr>
		  <tr><td align="center" valign="top" style="font:bold 18px Arial;color:#ffffff"><?=$varDiscountContent?></td></tr></table>
	  </td>
	  <td align="left" valign="top" width="100">&nbsp;</td><td align="left" valign="top" width="257" style="padding-top:18px;">
		  <table cellpadding="0" cellspacing="0" width="257"><tr><td align="center" valign="top" height="22"><input type="radio" name="checkOffer" <?=$varSpecialOffer2?> value="<?=$arrDiscountLevel[3]?>"></td></tr>
		  <tr><td align="center" valign="top" style="font:bold 18px Arial;color:#ffffff">Next Level Upgrade</td></tr>
		  <tr><td align="center" valign="top" style="font:12px Arial;color:#ffffff;padding-top:5px;">
		  Pay for Gold & get Super Gold Membership<br>
		  Pay for Super Gold & get Platinum Membership<br>
		  Pay for Platinum & get Extra Phone Numbers<span style="color:#FDE835">*</span>
		  </td></tr>
		  </table>
	  </td>
	  <td align="left" valign="top" width="30">&nbsp;</td>
	  </tr>
	  </table>
  </td></tr>
  <tr><td align="center" valign="top" style="font:11px arial;color:#EDE26E;padding-top:5px;" bgcolor="#910A00" height="39">
  * Platinum ( 3 months ) - 15 extra phone nos. | Platinum ( 6 months ) - 20 extra phone nos.<br> Platinum ( 9 months ) - 25 extra phone nos.</td>
  </tr>
  </table>
  </div><br clear="all"><br>
  <!-- NEW Renewal Offer banner - ends -->

  <? } ?>


  <? } elseif(($varGetCookieInfo['PAIDSTATUS']==0 && $varNumberOfPayments==0 && $varOfferCategoryId!=1) || ($varNRIRenewal==1)) { ?>

  <? if($confValues['DOMAINCASTEID']==2500  && (date('Y-m-d')=='2011-04-23' || date('Y-m-d')=='2011-04-24' || date('Y-m-d')=='2011-04-25')){?>
  <input type="hidden" name="checkOffer" <?=$varSpecialOffer2?> value="<?=$arrDiscountLevel[3]?>">
  <!--New Easter Offer Banner starts HERE -->
  <table cellpadding="0" cellspacing="0" width="557">
	<tr><td align="left" valign="top" width="557" background="<?=$confValues['IMGSURL']?>/easter/pay-img1-easfr.jpg" height="67"></td></tr>
	<tr><td align="left" valign="top" width="557" background="<?=$confValues['IMGSURL']?>/easter/pay-img2-easfr.jpg" height="132">
	<table cellpadding="0" cellspacing="0" width="557" border="0">
	<tr><td align="left" valign="top" style="padding-top:15px;padding-left:65px;">
	<table cellpadding="0" cellspacing="0" width="482">
	     		  <tr><td align="left" valign="top" style="font:bold 20px Arial;color:#FFFFFF;padding-left:35px;">Next Level Upgrade</td></tr>

            		  <tr><td align="left" valign="top" style="font:12px Arial;color:#FFFFFF;padding-top:5px;">
            		   <table cellpadding="0" cellspacing="0" width="280">
						<tr><td align="center" valign="top" style="font:13px arial;color:#FFFFFF">Pay for Gold & get SuperGold Membership</td></tr>
						<tr><td align="center" valign="top" style="font:13px arial;color:#FFFFFF">Pay for Super Gold & get Platinum Membership</td></tr>
						<tr><td align="center" valign="top" style="font:13px arial;color:#FFFFFF">Pay for Platinum & get Extra Phone Numbers*</td></tr>
						<tr><td align="center" valign="top" style="font:bold 14px Arial;color:#000000;padding-top:8px;">Offer valid till monday</td></tr>
					</table>
            		  </td></tr>
            		  </table>
	</td></tr>
	</table>
	</td></tr>
	<tr><td align="left" valign="middle" width="557" style="font:11px arial;color:#ffffff;padding-left:10px;" background="<?=$confValues['IMGSURL']?>/easter/pay-img3-easfr.jpg" height="41">
	* Platinum ( 3 months ) - 15 extra phone nos.  |  Platinum ( 6 months ) - 20 extra phone nos.<br><font style="padding-left:120px;">   
  Platinum ( 9 months ) - 25 extra phone nos.</font>
	</td></tr></table><br clear="all">
  <!--New Easter Offer Banner Ends HERE -->

  <?}else{?>
  <!-- NEW Special OFfer banner - starts -->
	<input type="hidden" name="checkOffer" <?=$varSpecialOffer2?> value="<?=$arrDiscountLevel[3]?>">
	<div>
	<table cellpadding="0" cellspacing="0" width="557" align="left">
		<tr><td align="left"  background="<?=$confValues['IMGSURL']?>/special/sp_offer1.gif" height="55" width="557">
		<table border="0" cellpadding="0" cellspacing="0" width="557"><tr><td align="right" valign="middle" style="font:13px arial;color:#FDB335;padding-right:10px;">
		<b>Hurry!</b> Offer ends <?if($varOfferEndDate!=0){echo 'on '.date("jS F Y", strtotime($varOfferEndDate));}else{echo 'today';}?></td></tr></table>
		</td></tr>
		<tr><td align="left" valign="top" background="<?=$confValues['IMGSURL']?>/special/spoffer2.gif" height="97" width="557"></td></tr>
		<tr><td align="center" valign="top" style="font:11px arial;color:#EDE26E;" bgcolor="#910A00" height="35">* Platinum ( 3 months ) - 15 extra phone nos. | Platinum ( 6 months ) - 20 extra phone nos.<br> Platinum ( 9 months ) - 25 extra phone nos.</td>
		</tr>
	</table>
	</div><br clear="all"><br>
	<!-- NEW Special Offer banner - ends -->
    <?}?>
    
	<? } } ?>
	</div>

	<!-- New design starts -->
	<div class="rpanel bgclr2 padb10">
		<div class="pad10" style="height:16px !important;height:30px;">
			<div class="normtxt fnt17 clr bld fleft">Select Membership Package</div>
			<div class="fright"><a class="clr1 notbld normtxt" onclick="sel('lightpic1');">[Compare Packages]</a></div>
		</div>
		<center>
		<div class="bgclr5" style="width:540px;">
			<div style="width:520px;">
				<input type="hidden" name="domainFolder" value="<?=substr($varDomainPart2,0,-9);?>">
				<input type="hidden" name="gateWay" value="<?=$varGateWay;?>">
				<input type="hidden" name="countryCode" value="<?=$varUseCountryCode;?>">
				<input type="hidden" name="frmPaymentSubmit" value="yes">
				<input type="hidden" name="matriId" value="<?=$sessMatriId;?>">
				<input type="hidden" name="offerAvailable" value="<?=$varOfferAvailable;?>">
				<input type="hidden" name="offerCategoryId" value="<?=$varOfferCategoryId;?>">
				<input type="hidden" name="renewalOffer" value="<?=$varCheckRenewalOffer;?>">

				<table width="520" cellspacing="0" cellpadding="0" border="0" align="center">
				<tr><td height="15" colspan="7"></td></tr>
				<tr><td width="26%" height="30"></td><td width="1" background="<?=$confValues['IMGSURL']?>/versep1.gif"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td><td width="24%" class="normtxt clr padl25">3 months</td><td width="1" background="<?=$confValues['IMGSURL']?>/versep1.gif"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td>
					<td width="24%" class="normtxt clr padl25">6 months</td><td width="1" background="<?=$confValues['IMGSURL']?>/versep1.gif"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td>
					<td width="25%" class="normtxt clr padl25">9 months</td>
				</tr>
				<tr><td class="dotsep2" height="1" colspan="7"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>

			<?
			$varStartId		= 7;
			$varPackageName	= 3;
			for ($row=1;$row<4;$row++) { ?>
			<tr><td width="29%" height="55" class="normtxt tlright alerttxt padr10">
			<? if($varPackageName == '3' || $varPackageName == '2'){		
			?>
			<div style="width:155px;">
			<div class="fleft">
			<?php 
			if ($varReebokOffer==1 && $varUseCountryCode=='98' && $varGetCookieInfo['OFFERTYPE'] !=''){ ?>
				<img src="<?=$confValues['IMGSURL']?>/reebok1.gif" width="87" height="44"/>
				<?php } else { echo '<img src="'.$confValues['IMGSURL'].'/trans.gif" width="87" height="44"/>';  } ?>
			</div><div class="fleft" style="padding-left:3px;padding-top:13px;"><?=$arrPackageName[$varPackageName]?></div>
			</div>
			<?} else{?><?=$arrPackageName[$varPackageName]?><?}?>
			
			</td>
			<td width="1" background="<?=$confValues['IMGSURL']?>/versep1.gif"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td>
			<?
			for ($ix=$varStartId;($varStartId+3)>$ix;$ix++) {
					//$varDiscountRate	= round(($localCurrOriginalRate[$ix]*trim($arrSplitDiscount[$ix]))/100);
    				$varDiscountRate	= trim($arrSplitDiscount[$ix]);
			?>

			<td width="25%" class="normtxt clr pdl10">
			<? if ($varDiscountAmount != 0) {  ?>

			<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="20" height="1">
			<font class="clr"><?=$varCurrencyCode?> <?=($localCurrOfferRate[$ix]-$varDiscountRate)?></font><br>
			<input type="hidden" name="hid_pakage_amt" id="hid_<?=$ix?>" value="<?=$localCurrOriginalRate[$ix]?>" >
			<input type="radio" name="category" id="category_<?=$ix?>" <? if($ix==9){echo "checked";}?> value="<?=$ix?>" onclick="pay_assit(<?=$ix?>);"><del style="text-decoration:strikethru;color:#ff0000;"><font class="clr"><?=$varCurrencyCode?> <?=$localCurrOriginalRate[$ix]?></font></del>
				<? if($ix==8){ ?>
				<br><img src="<?=$confValues['IMGSURL']?>/mostpopular.gif" />
				<?}else if($ix==9) {?>
				<br><img src="<?=$confValues['IMGSURL']?>/bestpackage.gif" />

			<? }} else  { ?>
            <input type="hidden" name="hid_pakage_amt" id="hid_<?=$ix?>" value="<?=$localCurrOriginalRate[$ix]?>" >
			<input type="radio" name="category" id="category_<?=$ix?>" <? if($ix==9){echo "checked";}?>  value="<?=$ix?>" onclick="pay_assit(<?=$ix?>);"><?=$varCurrencyCode?> <?=$localCurrOriginalRate[$ix]?>
				<? if($ix==8){ ?>
				<br><img src="<?=$confValues['IMGSURL']?>/mostpopular.gif" />
				<?}else if($ix==9) {?>
				<br><img src="<?=$confValues['IMGSURL']?>/bestpackage.gif" />
			<? }} ?>
			</td>
            <? if($ix!=3 && $ix!=6 && $ix!=9){ ?>
			<td width="1" background="<?=$confValues['IMGSURL']?>/versep1.gif">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" />
			</td>
			<? }}
					$varPackageName--;
					$varStartId = ($varStartId-3);
					//for ix ?>
			</tr>
			<tr><td class="dotsep2" height="1" colspan="7"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
			<? } // for row = 1 to 3 (should be till numOfPackages ?>

			</table>
			<table width="520" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#efefef">
			<tr><td colspan="2" height="5"></td></tr>
			<tr><td width="183" height="55" class="normtxt tlright alerttxt padr10 padt10" valign="top">Privilege Matrimony</td><td width="1" background="<?=$confValues['IMGSURL']?>/versep1.gif"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td><td width="422" class="normtxt clr pdl10 padt10" valign="top">

			<div class="fleft">
			<input type="hidden" name="hid_pakage_amt" id="hid_48" value="<?=$localCurrOriginalRate['48']?>" >
			<input type="radio" name="category" value="48" id="category_48" onclick="pay_assit(<?=$ix?>);">&nbsp;
				<?
					$varPrivilegeDiscountRate = $arrSplitDiscount['48'];
					if ($varDiscountAmount=='1' && $varPrivilegeDiscountRate >'0') {
						echo '<font class="clr">'.$varCurrencyCode.' ';
						echo ($localCurrOriginalRate['48']-$varPrivilegeDiscountRate);
						echo '</font>';
						echo '<br><img src="'.$confValues['IMGSURL'].'/trans.gif" height="1" width="27"><del style="text-decoration:strikethru;color:#ff0000;"><font class="clr">'.$varCurrencyCode.' '.$localCurrOriginalRate['48'].'</del>';

					} else {echo $varCurrencyCode.' '.$localCurrOriginalRate['48'];  }
				?>
			</div>

			<div class="fleft padt5 padl"><img src="<?=$confValues['IMGSURL']?>/or_larrow.gif" /></div><div class="fleft bld padlr5" style="padding-top:3px;">An Assisted Matchmaking Service.</div><br clear="all"><div class="clr2 padlr5 lh16">Get a Relationship Manager with expertise in matchmaking<br> to Search, Shortlist and Initiate Contacts on your behalf.<br><br></div></td></tr>
			</table>
			</div>
			<div style="height:10px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="10" /></div>
		</div>
		</center>
	</div><br clear="all">

	<!-- Profile Highlighter Part Start Here -->
	<div class="rpanel bgclr2 padb10">
		<div style="height: 16px ! important;" class="pad10">
			<div class="normtxt fnt15 clr bld fleft">Select ADD-ON Package</div>			
		</div>
		<center>
		<div style="width: 540px;" class="bgclr5">
			<div style="width: 520px;"><img src="<?=$confValues['IMGSURL']?>/prf-hgtbg.gif" width="520" height="14"/></div>
			<div style="width: 520px;height:35px;" class="pad10">
				<div align="left" class="normtxt1 clr3 fleft"><b>Profile Highlighter</b><br>
					<font class="smalltxt clr" style="line-height:25px;">Get better visibility with a special profile AD.</font> <a href="#" onclick="sel('lightpic2')" class="smalltxt clr1 bld" style="line-height:25px;">More &gt;&gt;</a>
				</div>
				<div class="fleft pad10 padl clr"><input onclick="add_addon();" name="proHighlighter" id="proHighlighter" <?=$varPhStatus;?> type="checkbox" value="<?=$localCurrOriginalRate['120'];?>"/>&nbsp;&nbsp;<?=$varCurrencyCode?> <?=$localCurrOriginalRate['120'];?> for 2 months</div>
			</div>
			<div style="height: 10px;"><img height="10" width="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></div>
		</div>
		</center>
	</div>

	<div class="rpanel padb10" style="margin-top:10px;background:#B7ECBA">
		<div style="height: 16px ! important;" class="pad10">
			<div class="normtxt fnt15 clr bld fleft">Select ADD-ON Package</div>			
		</div>
		<center>
		<div style="width: 540px;" class="bgclr5">
			<div style="width: 520px;"><img src="<?=$confValues['IMGSURL']?>/prf-hgtbg1.gif" width="520" height="14"/></div>
			<div style="width: 520px;height:35px;" class="pad10">
				<div align="left" style="width:140px;padding-left:15px;" class="normtxt1 clr fleft" id="addon_cur_membership_display"><b>Membership</b><br>
					<font class="smalltxt clr" style="line-height:25px;">
					<span id="spn_package">Platinum</span>
					</font>
				</div>
				<div align="left" style="width:140px !important;width:160px;padding-left:10px;border-right:1px dotted #000000" class="normtxt1 clr fleft"><b>Add-on package</b><br clear="all">
				    
					<span style="display: block;" id="spn_addon_defult_msg">
					<div class="fleft smalltxt" style="width: 100px;padding-top:8px;">No Add-on selected</div>
					<div class="cleardiv"></div>
					</span>
				    
					<span id="spn_addon_ph" style="display: none;">
					<div class="smalltxt clr fleft" style="padding-top:8px;">Profile Highlighter</div>
					<div class="fleft" style="padding-top:12px;padding-left:6px;">
					<a href="javascript:void(0);" id="spn_ph_del_img" onclick="delete_addon(1);"><img src="<?=$confValues['IMGSURL']?>/prf-hgtd.gif" width="7" height="9" /></a>
					</div>
					</span>
                				                  


				</div>
				<div align="left" style="padding-left:20px;" class="fnt15 clr fleft bld" id="PriceDisplayPart">Your Total:
				<font class="clr" style="font:bold 22px arial;"><?=$varCurrencyCode?>
				<span id="spn_total_amt"> <?=$localCurrOriginalRate['9'];?></span>
				</font></div>
			</div>
			<div style="height: 10px;"><img height="10" width="1" src="<?=$confValues['IMGSURL']?>/trans.gif"></div>
		</div>
		</center>
	</div><br clear="all">
	<!-- Profile Highlighter Part Ends Here -->

	

	<div class="rpanel bgclr2 padb10">
		<div class="pad10" style="height:16px !important;height:30px;">
			<div class="normtxt fnt17 clr bld fleft">Select Payment Mode</div>
		</div>
		<center>
		<div class="bgclr5" style="width:540px;">
			<div style="width:520px;">
				<table width="520" cellspacing="0" cellpadding="0" border="0" align="center">
                    
				    <!--Visa / MasterCard Credit Card Start -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio" name="paymentMode" id="PAYMENTOPT2" value="varMigsURL" onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><div class="fnt14 bld padb5">Visa / MasterCard Credit Card</div><img src="<?=$confValues['IMGSURL']?>/visa-card.gif" />&nbsp; <img src="<?=$confValues['IMGSURL']?>/master-card.gif"/><br>Make Online Payment. It's the most safe, secure and quickest mode of payment.<br><br></td>
					</tr>
					<tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT2BTNDIV'></div></td></tr>
					<!--Visa / MasterCard Credit Card End -->

					<? if ($varUseCountryCode!='98' && $varUseCountryCode!='162') { ?>
					<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>

					<!--American express / Discover Credit Card Start -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio" name="paymentMode" id="PAYMENTOPT7" value="varOptimalURL" onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><div class="fnt14 bld padb5">American express / Discover Credit Card</div><img src="<?=$confValues['IMGSURL']?>/pay-amex.gif" />&nbsp; <img src="<?=$confValues['IMGSURL']?>/pay-dis.gif"/><br>Make Online Payment. It's the most safe, secure and quickest mode of payment.<br><br></td>
					</tr>
					<tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT7BTNDIV'></div></td></tr>
					<!--American express / Discover Credit Card End -->
					<? }?>

					<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>

					<!--Other Credit Cards Start -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio" name="paymentMode" id="PAYMENTOPT3" value="varCCAvenueURL" onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><div class="fnt14 bld padb5">Other Credit Cards / Debit Cards / Net Banking Accounts</div><? if ($varUseCountryCode=='98') { ?>American Express,<? }?> Citibank Suvidha Online, IDBI iNet-Banking, Diners Club International / Citibank eCards, JCB Cards, ICICI Infinity Net-Banking, OBC ibank Net-Banking, Citibank Bank Account Online, HDFC Net-Banking, Centurion Bank ePay, Citibank NRI Rupee Checking A/C, AXIS iConnect Net-Banking, Federal Bank FedNeT, Kotak Mahindra Bank, PNB Internet banking, IndusInd Bank.<br><br></td>
					</tr>
                    <tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT3BTNDIV'></div></td></tr>
					<!--Other Credit Cards End -->

					<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>

					<? if ($varUseCountryCode=='98') { ?>
					<!--Pay at your Doorstep Start -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio" name="paymentMode" id="PAYMENTOPT1" value="payAtDoorStep" onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><font class="fnt14 bld">Pay at your Doorstep</font> <font class="opttxt">(325 locations in India)</font><br><div class="fleft">Place an online request or call &nbsp;</div><div id="livehelpno3" class="bld fleft" style="color:#000"></div> &nbsp;(Toll Free) to have your payment collected from your doorstep by our representative free of cost within 24 hours.<br><br></td>
					</tr>
					<tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT1BTNDIV'></div></td></tr>
					<!--Pay at your Doorstep End -->

					<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
					<? } ?>

					 <!--CommunityMatrimony Offices Start -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio" value="varCommunityOfficeURL" name="paymentMode" id="PAYMENTOPT4"  onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><div class="fnt14 bld padb5">CommunityMatrimony Offices</div>Visit any of our <a class="clr1" href="/site/index.php?act=contactus" target="_blank">CommunityMatrimony.com offices</a> located in various cities in India and pay by Cheque / DD in favor of "CommunityMatrimony.com".<br><br></td>
					</tr>
					<tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT4BTNDIV'></div></td></tr>
					<!--CommunityMatrimony Offices End -->


					<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
                    <? if ($varUseCountryCode=='98') { ?>
					<!--Pay through phone Start -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio" name="paymentMode" id="PAYMENTOPT5" value="varIVRS" onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><div class="fnt14 bld padb5">Pay through phone <font class="opttxt">(Absolutely Safe and Secure)</font></div>You will receive a call from our Automated Telephone Payment System to your number. Key in your credit card number, card expiry date and CVV and your payment gets processed through a 128 bit VeriSign Secured payment gateway right away.<br><br></td>
					</tr>
					<tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT5BTNDIV'></div></td></tr>
					<!--Pay through phone End -->


					<tr><td class="dotsep2" height="1" colspan="2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></td></tr>
                    <? } ?>

					<!--Pay at Banks Start  -->
					<tr><td width="30" align="right" valign="top" class="padt10"><input type="radio"  name="paymentMode" id="PAYMENTOPT6" value="varBankURL" onclick="javascript:payoptsubbtn()"></td>
						<td width="490" class="clr lh16 normtxt padlr5" valign="top" style="padding-top:12px;"><div class="fnt14 bld padb5">Pay at Banks</div>
						<div class="fleft">
						Visit any of the State Bank of India or HDFC Bank branches across India to make Cash, <div class="fleft">Cheque / DD payments. After depositing the Cheque / DD, call &nbsp;</div><div id="livehelpno2" class="bld fleft" style="color:#000"></div> &nbsp;(Toll Free) with your Cheque / DD details.</div> <br><br></td>
					</tr>
					<tr><td colspan="2" align="right" class="padb10"><div id='PAYMENTOPT6BTNDIV'></div></td></tr>
                    <!--Pay at Banks End -->

				</table>
				<div id="div_payment_common_submit">
				<input type="submit" class="button" value="Continue">
				</div><br clear="all">
			</div>
		</div>
		</center>
	</div>

	<!-- New design ends -->

    

</center>
<div id="lightpic1" class="frdispdiv posabs" style="width: 560px !important;width: 560px;overflow:auto;">
                <div class="bgclr2 brdr1" style="padding-top:15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="530" align="center" class="brdr bgclr5">
      				<tr><td colspan="7" align="right" height="18" style="padding-right:5px;"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="selclose('lightpic1');" /></td></tr>
      				<tr><td width="20" height="20">&nbsp;</td>
      					<td width="165" height="20" class="bld smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Features</td>

      					<td width="95" class="bld smalltxt" align="center" style="border-right:1px solid #dbdbdb;">Gold</td>
      					<td width="95" class="bld smalltxt" align="center" style="border-right:1px solid #dbdbdb;">Super Gold</td>
      					<td width="95" class="bld smalltxt" align="center" style="border-right:1px solid #dbdbdb;">Platinum</td>
                        <td width="50" class="bld smalltxt" align="center">Free</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" bgcolor="#dbdbdb" colspan="5"></td><td></td></tr>
      				<tr><td height="40">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">View other members photo</td>
                        <td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center"  style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
                        <td class="smalltxt" align="center">1</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="60">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Phone number package</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">3 months - 40<br> 6 months - 55<br>9 months - 70</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">3 months - 50<br> 6 months - 70<br>9 months - 90</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">3 months - 80<br> 6 months - 110<br>9 months - 140</td>
                        <td class="smalltxt" align="center">No</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="60">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Profile tagged as Premium<br />
                        Member in Search Results & Full View Profile Page</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">No</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
                        <td class="smalltxt" align="center">No</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
                    <tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="40">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Protect Photo
      					<? if ($_FeatureHoroscope==1) { echo '/ Horoscope'; } ?> / Phone
      					</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
                        <td class="smalltxt" align="center">No</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="60">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Send message in own words</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">3 months - 3000<br> 6 months - 6000<br>9 months - 9000</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">3 months - 3000<br> 6 months - 6000<br>9 months - 9000</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">3 months - 3000<br> 6 months - 6000<br>9 months - 9000</td>
                        <td class="smalltxt" align="center">No</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="40">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Add to favourites</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">1000</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">1000</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">1000</td>
                        <td class="smalltxt" align="center">3</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="40">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Block Profiles</td>
                        <td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">1000</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">1000</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;">1000</td>
                        <td class="smalltxt" align="center">1</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="40">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Members profile & contact details in printable format</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
                        <td class="smalltxt" align="center">No</td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      				<tr><td></td><td height="1" colspan="5" class="dotsep3"></td><td></td></tr>
      				<tr><td height="40">&nbsp;</td>
      					<td class="smalltxt" align="left" style="border-right:1px solid #dbdbdb;">Matching profiles through <br>e-mail</td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center" style="border-right:1px solid #dbdbdb;"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td class="smalltxt" align="center"><img src="<?=$confValues['IMGSURL']?>/yes.gif" ></td>
      					<td width="20" class="bld smalltxt">&nbsp;</td>
      				</tr>
      			  </table>
                  <table border="0" cellpadding="0" cellspacing="0" width="530">
      				<tr><td colspan="7" align="right" height="15"><img src="<?=$confValues['IMGSURL']?>/trans.gif" /></td></tr>
                    </table>
                </div>

		</div>
		<div id="lightpic2" class="posabs bgclr2 brdr1" style="display: none;position: absolute;margin:0;width:462px !important;width:462px; z-index:1002;">
                <table cellspacing="0" cellpadding="0" border="0" align="center" width="460">
      				<tbody>
					<tr><td height="18" valign="top" align="right" style="padding-top:10px;padding-right: 5px;" colspan="7">
					<div class="fright"><img onclick="selclose('lightpic2');" class="pntr" src="http://img.agarwalmatrimony.com/images/close.gif"></div><div class="fright" style="padding-right:5px;"><a href="#" class="clr3 normtxt" onclick="selclose('lightpic2');">Close</a></div></td></tr>     		<tr>
					<td align="left" valign="top" style="padding-left:20px;">
					<table cellspacing="0" cellpadding="0" border="0" width="420">
					<tr>
					<td align="left" height="35" valign="top" style="font:bold 17px arial;color:#F26A26">Profile Highlighter</td>
					</tr>
					<tr>
					<td align="left" height="35" valign="top" style="font:12px arial;color:#3A0148">Get noticed with maximum profile views
</td>
					</tr>
					<tr>
					<td align="left" height="35" valign="top" style="font:bold 12px arial;color:#3A0148">
					<div class="fleft" style="padding-top:2px;"><img src="http://img.agarwalmatrimony.com/images/prf-hgt-arrw.gif" width="5" height="11" /></div><div class="fleft" style="padding-left:15px;">Feature your profile on the homepage of matching prospects.</div></td>
					</tr>
					<tr>
					<td align="left" height="50" valign="top" style="font:bold 12px arial;color:#3A0148">
					<div class="fleft" style="padding-top:2px;"><img src="http://img.agarwalmatrimony.com/images/prf-hgt-arrw.gif" width="5" height="11" /></div><div class="fleft" style="padding-left:15px;">Get an attractive highlighter and appear at the top of search<br>results when a member searches for someone with your criteria.</div></td>
					</tr>
					<tr>
					<td align="left" height="20" valign="top" style="border:1px solid #DDD9B6;background:#F8F7EA;font:bold 12px arial;color:#3A0148;padding:10px 10px;">Avail Profile Highlighter at <?=$varCurrencyCode?> <?=$localCurrOriginalRate['120'];?> for 2 months					
					</td>
					</tr>
					<tr>
					<td align="left" height="35" valign="top" style="padding-top:10px;font:12px arial;color:#3A0148">For more details about this service, call Toll Free:<b> 1-800-3000-2222</b></td>
					</tr>
					<tr>
					<td align="left" height="35" valign="top" style="padding-top:10px;font:bold 13px arial;color:#8B8A89">SAMPLE BANNER AD</td>
					</tr>
					</table>
					</td>
					</tr>
					<tr><td align="center"><img src="http://img.agarwalmatrimony.com/images/sample-profile-highlight.gif" width="442" height="171" />
					</td></tr>
      				
      			  </tbody></table>
                  <table cellspacing="0" cellpadding="0" border="0" width="420">
      				<tbody><tr><td height="15" align="right" colspan="7"><img src="http://img.agarwalmatrimony.com/images/trans.gif"></td></tr>
                    </tbody></table>
                </div>
		<div id="fade" class="bgfadediv"></div>
	</div>
	</center>
</div><br clear="all">
<? include_once($varRootBasePath."/www/payment/paymentpagetracking.php"); ?>
<script>
add_addon();
</script>
<!-- BEGIN LiveEngage -->
<script language="JavaScript1.2">
if (typeof(lpCV) == "undefined") lpCV = "";
lpEngageSeconds = 120; // seconds before invitation sent
lpNumber = "45118402"; // Account number
lpServerName = "server.iad.liveperson.net"; // Site server
lpCV+="&SESSIONVAR!Call=LiveEngageInvite"; // LiveEngage type : Proactive Invitation Button
</script>
<script src="https://server.iad.liveperson.net/hcp/html/liveengage1.js"></script>

<!-- End LiveEngage -->
<!-- BEGIN Invitation Positioning  -->
<script language="javascript" type="text/javascript">
var lpPosY = 100;
var lpPosX = 100;
</script>
<!-- END Invitation Positioning  -->

<!-- BEGIN LivePerson Monitor. --><script language='javascript'> var lpMTagConfig = {'lpServer' : "server.iad.liveperson.net",'lpNumber' : "45118402",'lpProtocol' : "https"}; function lpAddMonitorTag(src){if(typeof(src)=='undefined'||typeof(src)=='object'){src=lpMTagConfig.lpMTagSrc?lpMTagConfig.lpMTagSrc:'/hcp/html/mTag.js';}if(src.indexOf('http')!=0){src=lpMTagConfig.lpProtocol+"://"+lpMTagConfig.lpServer+src+'?site='+lpMTagConfig.lpNumber;}else{if(src.indexOf('site=')<0){if(src.indexOf('?')<0)src=src+'?';else src=src+'&';src=src+'site='+lpMTagConfig.lpNumber;}};var s=document.createElement('script');s.setAttribute('type','text/javascript');s.setAttribute('charset','iso-8859-1');s.setAttribute('src',src);document.getElementsByTagName('head').item(0).appendChild(s);} if (window.attachEvent) window.attachEvent('onload',lpAddMonitorTag); else window.addEventListener("load",lpAddMonitorTag,false);</script><!-- END LivePerson Monitor. -->