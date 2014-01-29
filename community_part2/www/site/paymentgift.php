<?php
//FILE INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//HEADER INCLUDE
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath.'/lib/clsError.php');
include_once($varRootBasePath.'/lib/clsValidate.php');
//OBJECT DECLARATION
$objDBSlave		= new DB;
$objDBMaster	= new DB;
$objValidate	= new clsValidate;

$objDBSlave->dbConnect('S', $varDbInfo['DATABASE']);
$objDBMaster->dbConnect('M', $varDbInfo['DATABASE']);

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessionName	= $varGetCookieInfo["NAME"];

$varErrorPage	= 'no';
$varSuccessPage	= 'no';
$varTabIndex	= 1;
// && $sessMatriId =='';
if($sessMatriId !='') {
if($_REQUEST['frmAddressSubmit']=='yes') {

	$varName				=	trim($_REQUEST['name']);
	$varPhoneNo				=	trim($_REQUEST['phoneNo']);
	$varCountryCode			=	trim($_REQUEST['countryCode']);
	$varAreaCode			=	trim($_REQUEST['areaCode']);
	$varMobileNo			=	trim($_REQUEST['mobileNo']);
	$varAddress				=	trim($_REQUEST['address']);
	$varCheck				=	"M"; 
	
	$objValidate->isInputNull($varName,'Enter your name');
	if($varCountryCode=='' || $varAreaCode=='' || $varPhoneNo=='')
	$objValidate->isInputNull($varMobileNo,'Enter your phone number');
	if($varCountryCode=='' && $varAreaCode=='' && $varPhoneNo==''){$varCheck = "P";}
	$objValidate->isInputNull($varAddress,'Enter your address');

	if(count($errors) == '0') {
		$argFields		= array('MatriId','Name','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneCheck','Address','DateCreated');
		$argFieldsValues= array($objDBMaster->doEscapeString($sessMatriId,$objDBMaster),$objDBMaster->doEscapeString($varName,$objDBMaster),$objDBMaster->doEscapeString($varCountryCode,$objDBMaster),$objDBMaster->doEscapeString($varAreaCode,$objDBMaster),$objDBMaster->doEscapeString($varPhoneNo,$objDBMaster),$objDBMaster->doEscapeString($varMobileNo,$objDBMaster),$objDBMaster->doEscapeString($varCheck,$objDBMaster),$objDBMaster->doEscapeString($varAddress,$objDBMaster),'now()');
		$objDBMaster->insertOnDuplicate('communitymatrimony.offeraddressinfo',$argFields,$argFieldsValues,'MatriId');
		$varName				=	"";
		$varPhoneNo				=	"";
		$varCountryCode			=	"";
		$varAreaCode			=	"";
		$varMobileNo			=	"";
		$varAddress				=	"";
		$varSuccessPage	= 'yes';
	}
	else {
		$varErrorPage	= 'yes';
	}
}
else
{
		$argFields			= array('MatriId','Nick_Name','Name');
		$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
		$varMemberInfoRes	= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition);
		$varMemberInfo		= mysql_fetch_assoc($varMemberInfoRes); 
		
		$argFields					= array('PhoneNo1','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneStatus1','PinNo');
		$varAssuredContactInfoRes	= $objDBSlave->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
		$varAssuredContactInfo		= mysql_fetch_assoc($varAssuredContactInfoRes);                                    

		if($varAssuredContactInfo['MobileNo'] != '' || $varAssuredContactInfo['PhoneNo']!='' ) {
			$varAssuredNo	= $varAssuredContactInfo['PhoneNo1'];
			$varCountryCode	= $varAssuredContactInfo['CountryCode'];
			$varAreaCode	= $varAssuredContactInfo['AreaCode'];
			$varPhoneNo		= $varAssuredContactInfo['PhoneNo'];
			$varMobileNo	= $varAssuredContactInfo['MobileNo'];
			$varPhoneStatus	= $varAssuredContactInfo['PhoneStatus1'];
			$varSelPinNo	= $varAssuredContactInfo['PinNo'];
		} else {
			$argFields					= array('PhoneNo1','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneStatus1','PinNo');
			$varAssuredContactInfoRes	= $objDBSlave->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,0);
			$varAssuredContactInfo		= mysql_fetch_assoc($varAssuredContactInfoRes);
			$varAssuredNo				= $varAssuredContactInfo['PhoneNo1'];
			$varCountryCode				= $varAssuredContactInfo['CountryCode'];
			$varAreaCode				= $varAssuredContactInfo['AreaCode'];
			$varPhoneNo					= $varAssuredContactInfo['PhoneNo'];
			$varMobileNo				= $varAssuredContactInfo['MobileNo'];
			$varPhoneStatus				= $varAssuredContactInfo['PhoneStatus1'];
		}
		/*if($varPhoneNo=='' && $varMobileNo=='')
		{
			$varMobileNo	= $varMemberInfo['MobileNo']
			$varPhoneNo	= $varMemberInfo['PhoneNo']
		}*/

		$varName	= ($varMemberInfo['Name']!='')?$varMemberInfo['Name'] : $varMemberInfo['Nick_Name'];
	}
}
else{
	$varRedirect = $confValues['SERVERURL']."/login/index.php?act=login";	
	echo "<script>window.location.href='".$varRedirect."'</script>";
}
$objDBSlave->dbClose();
$objDBMaster->dbClose();
unset($objDBSlave);
unset($objDBMaster);
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/address.js" ></script>

<div class="rpanel fleft"><div class="fright"><a class="clr1 smalltxt" href="<?=$confValues['SERVERURL'].'/profiledetail/'?>">Click here to home</a></div>
	<div class="normtxt1 clr2 padb5"><font class="clr bld">Address</font></div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	
	<br clear="all">
	<center>
		<div class="rpanel padt10">
		<? if ($varErrorPage=='yes') { ?>
			<div class="clr3 pad10 brdr" style="background-color:#efefef;"><?php Error::showErrors(); ?> </div>
		<? } elseif($varSuccessPage=='yes') { ?>
			<div class="" style="">Thanks, your address information added successfully</div>
		<? } ?>
	
		<br clear="all">
		<?	 if($_REQUEST['frmAddressSubmit']!='yes' || $varErrorPage=='yes') { ?>
		<form method="POST" action="" name="addressform"  onSubmit="return validateForm();">
			<input type="hidden" name="frmAddressSubmit" value="yes">
			<div class="srchdivlt fleft tlright smalltxt">Name</div>
			<div class="srchdivrt fleft">
				<input type="text" name="name" size="35" class="inputtext" value="<?=htmlentities($varName,ENT_QUOTES);?>" tabindex="<?=$varTabIndex++?>" maxlength="50"><br clear="all"><span id="errorname" class="errortxt"></span>
			</div>
			<br clear="all">
			
			<div class="srchdivlt fleft tlright smalltxt">Mobile number</div>
			<div class="srchdivrt fleft">
				<input type="text" name="mobileNo" size=35 onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>"  class="inputtext"  tabindex="2" value="<?=htmlentities($varMobileNo,ENT_QUOTES);?>" maxlength="16">
				<br clear="all">
				<span id="errormobile" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Phone number</div>
			<div class="srchdivrt fleft">
				<input style="width:40px;" type="text" onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>" class="inputtext" size="2" name="countryCode" value="<?=htmlentities($varCountryCode,ENT_QUOTES);?>" maxlength="4" >
				<input style="width:50px;" type="text" onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>" class="inputtext" size="2" name="areaCode" value="<?=htmlentities($varAreaCode,ENT_QUOTES)?>" maxlength="6">
				<input style="width:110px;" type="text" onKeypress="return allowNumeric(event);" tabindex="<?=$varTabIndex++?>" class="inputtext" size="13" name="phoneNo" value="<?=htmlentities($varPhoneNo,ENT_QUOTES);?>" maxlength="10">
				<br clear="all">
				<span id="errorphone" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">Address</div>
			<div class="srchdivrt fleft">
				<textarea class="tareareg" style="width:205px;" name="address" tabindex="<?=$varTabIndex++?>"><?=htmlentities($varAddress,ENT_QUOTES);?></textarea><br>
				<span id="erroraddress" class="errortxt"></span>
			</div>
			<br clear="all">

			<div class="srchdivlt fleft tlright smalltxt">&nbsp;</div>
			<div class="srchdivrt fleft">
				<div class="fleft">
					<input type="submit" value="Submit" class="button" tabindex="<?=$varTabIndex++?>">
				</div>
			</div>
		</form>
		<? } ?>
	</div>
	</center>
</div>

