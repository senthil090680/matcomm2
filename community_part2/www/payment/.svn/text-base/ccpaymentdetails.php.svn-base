<?php
#===========================================================================================#
# Name   : Iyyappan. N																		#
# Date   : 11-Jan-2011																		#
# Module : Credit Card Details Captured														#
#===========================================================================================#
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//INCLUDE FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//GET SESSION VALUES
$sessMatriId = $varGetCookieInfo['MATRIID'];

//OBJECT DECLARATION
$objDB = new DB;

if($_POST['frmSubmit'] =='yes' && $sessMatriId!="") {
	//CONNECT DB
	$objDB->dbConnect('M',$varDbInfo['DATABASE']);

	$varCardNo			= trim($_POST['vpc_CardNum']);
	$varCardType		= trim($_POST['vpc_card']);
	$varExpMonth		= trim($_POST['cardExpiryMonth']);
	$varExpYear			= trim($_POST['cardExpiryYear']);
	$varFields			= array('Card_Number','Card_Type','Expiry_Month','Expiry_Year','IP_Address','Date_Captured');
	$varFieldValues		= array('AES_ENCRYPT('.str_replace(" ","",$varCardNo).',"'.$varAesKeyword.'")',"'".$varCardType."'","'".$varExpMonth."'","'".$varExpYear."'","'".$_SERVER['REMOTE_ADDR']."'",'NOW()');
	$varCondition		= " MatriId =".$objDB->doEscapeString($sessMatriId,$objDB);
	$objDB->update($varTable['ONLINEPAYMENTDETAILS'],$varFields,$varFieldValues,$varCondition);
	$objDB->dbClose();
}

?>
<SCRIPT LANGUAGE="JAVASCRIPT">
function validateCreditcard() {
	var frmCreditCard=this.document.frmCreditCard;
	var n=document.getElementById('vpc_CardNum').value;
	var n1;var n2;var n3;
	n1=n.substring(0,1);
	n2=n.substring(1);
	n3=n.substring(0,4);
	if(!document.frmCreditCard.vpc_card[0].checked && !document.frmCreditCard.vpc_card[1].checked && !document.frmCreditCard.vpc_card[2].checked && !document.frmCreditCard.vpc_card[3].checked) {
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
return true;
}

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
	for( var Idx = 0; Idx < NumStr.length; Idx ++ ){
		 var Char = NumStr.charAt( Idx );
		 var Match = false;
			for( var Idx1 = 0; Idx1 < String.length; Idx1 ++) {
				 if( Char == String.charAt( Idx1 ) ) 
				 Match = true;
			}
			if ( !Match ) 
				return false;
	}
	return true;
}
</SCRIPT>

<html>
<title>Credit card details</title>
<body>
<form name="frmCreditCard" method="POST" action="<?=($sessMatriId=='') ? $confValues['SERVERURL'].'/login/index.php?redirect='.$confValues['SERVERURL'].'/payment/index.php?act=ccpaymentdetails' : ''?>" onSubmit="return validateCreditcard();">
<input type="hidden" name="frmSubmit" value="yes"/>
 <?php if (isset($_REQUEST['frmSubmit'])) {?>
	<table border="0" width="520" cellpadding="0" cellspacing="0"><tr><td width="550" align="center" class="normtxt" height="40" style="border:1px solid #cbcbcb">Your credit card details updated successfully.</td></tr></table>
<?php } else {?>
	<div class="normtxt fnt17 clr  pad10 bgclr5">Please update your new credit card information here.</div>
	<div class="rpanel bgclr2 padb10">
	<div class="pad10" style="height:16px !important;height:30px;">
	<div class="normtxt fnt15 clr bld fleft">Credit Card Details</div>
	</div>
	<center>
	<div class="bgclr5" style="width:540px;">
		<div style="width:520px;">
 <table border="0" width="500" cellpadding="0" cellspacing="0">
  <tr>    
  <td class="normtxt" align="left" height="50">Card type</td>
  <td align="left"><div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="Visa"></div><div style="width:50px;float:left;"><IMG SRC="images/pay-visa.gif" ></div><div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="Mastercard"></div><div style="width:50px;float:left;"><IMG SRC="images/pay-master.gif"></div>
  <div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="AmericanEx"></div><div style="width:50px !important;width:40px;float:left;"><IMG SRC="images/pay-amex.gif"></div>
  <div style="width:20px;float:left;padding-top:3px;"><input type="radio" name="vpc_card" value="Discover"></div><div style="width:50px !important;width:40px;float:left;"><IMG SRC="images/pay-dis.gif"></div>
  </td>
  </tr>
  <tr><td colspan="2" class="dotsep2" height="1"></td></tr>
 <tr>    
    <td class="normtxt" align="left" height="40">Credit card number</td>
	<td align="left"><input type="text" size="19" value="" name="vpc_CardNum" id="vpc_CardNum" class="inputtext"></td>
 </tr>
 <tr><td colspan="2" class="dotsep2" height="1"></td></tr>
 <tr>    
    <td class="normtxt" align="left" height="40">Card expiry date</td>
		 <td align="left"><SELECT class="smalltxt" NAME="cardExpiryMonth" size="1" >
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
							</SELECT></td>
  </tr>
  <tr><td colspan="2" class="dotsep2" height="1"></td></tr>
  <tr><td colspan="2" class="dotsep2" height="1"></td></tr>
  <tr>    
    <td height="40"></td>
	<td align="left" ><input type="submit" name="SubButL" class="button pntr" value="Submit"></td>
  </tr>
</table>
</div>
<div style="height:10px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="10" /></div>
	</div>
	</center>
</div>
 <? }?>
</form><br clear="all">
</body>
</html>