<?php
#=============================================================================================================
# Author 		: N Dhanapal
# Start Date	: 2009-11-19
# End Date		: 2009-11-19
# Project		: CBS
# Module		: Campaingn - Redirection to specific community domain
#=============================================================================================================

$varPartnerLanding		= $_REQUEST['partnerLanding'];
$varTrackId				= trim($_REQUEST['trackid']);
$varFormFeed			= trim($_REQUEST['formfeed']);
$varCommunity			= trim($_REQUEST['community']);

$varName				= trim($_REQUEST['name']);
$varGender				= $_REQUEST['gender'];
$varMonth				= $_REQUEST['dobMonth'];
$varDay					= $_REQUEST['dobDay'];
$varYear				= $_REQUEST['dobYear'];
$varAge					= trim($_REQUEST['age']);
$varCountry				= $_REQUEST['country'];
$varCountryCode			= trim($_REQUEST['countryCode']);
$varAreaCode			= trim($_REQUEST['areaCode']);
$varPhoneNo				= trim($_REQUEST['phoneNo']);
$varMobileNo			= trim($_REQUEST['mobileNo']);
$varEmail				= trim($_REQUEST['email']);
$varPassword			= trim($_REQUEST['password']);

?>
<html>
<head>
	<script language="javascript">
		function funCampaign() {
			var funFrm		= document.campaignRegister;
			var community	= funFrm.community.value;
			var URL			= 'http://www.communitymatrimony.com/';
			if (community!='') { URL = 'http://www.'+community+'matrimony.com/register/'; }
			funFrm.action = URL;funFrm.submit();

		}//funCampaign
	</script>
</head>
<body onLoad="funCampaign();">
	<form name='campaignRegister' method="post" style="padding:0px;margin:0px;">
		<input type="hidden" name="partnerLanding" value="<?=$varPartnerLanding?>">
		<input type="hidden" name="trackid" value="<?=$varTrackId?>">
		<input type="hidden" name="formfeed" value="<?=$varFormFeed?>">
		<input type="hidden" name="community" value="<?=$varCommunity?>">

		<input type="hidden" name="name" value="<?=$varName?>">
		<input type="hidden" name="gender" value="<?=$varGender;?>">
		<input type="hidden" name="dobMonth" value="<?=$varMonth;?>">
		<input type="hidden" name="dobDay" value="<?=$varDay;?>">
		<input type="hidden" name="dobYear" value="<?=$varYear?>">
		<input type="hidden" name="age" value="<?=$varAge?>">
		<input type="hidden" name="country" value="<?=$varCountry;?>">
		<input type="hidden" name="countryCode" value="<?=$varCountryCode?>">
		<input type="hidden" name="areaCode" value="<?=$varAreaCode?>">
		<input type="hidden" name="phoneNo" value="<?=$varPhoneNo?>">
		<input type="hidden" name="mobileNo" value="<?=$varMobileNo?>">
		<input type="hidden" name="email" value="<?=$varEmail?>">
		<input type="hidden" name="password" value="<?=$varPassword?>">

	</form>
</body>
</html>