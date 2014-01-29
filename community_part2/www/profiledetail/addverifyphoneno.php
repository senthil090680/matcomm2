<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-04
# Project	  : MatrimonyProduct
# Filename	  : addverifyphoneno.php
#=====================================================================================================================================
# Description : display form which is adding phone no for verification
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new DB;
$objDBMaster= new DB;
$objCommon	= new clsCommon;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION
$varAddFrmSubmit	= $_REQUEST['addverifyphnoSubmit'];

function getPinNo($objMasterDBConn,$phonePinTable){

	$funQuery	= "LOCK TABLES ".$phonePinTable." WRITE";
	mysql_query($funQuery);

	$argFields			= array('PinNo');
	$argCondition		= "WHERE UsedStatus=0 LIMIT 0,1";
	$varPinInfoResultSet= $objMasterDBConn->select($phonePinTable,$argFields,$argCondition,0);
	$varPinInfoResult	= mysql_fetch_assoc($varPinInfoResultSet);

	$varPhonePinNo		= $varPinInfoResult["PinNo"];

	$argFields 			= array('UsedStatus');
	$argFieldsValues	= array(1);
	$argCondition		= " PinNo=".$varPhonePinNo;
	$varUpdateId		= $objMasterDBConn->update($phonePinTable,$argFields,$argFieldsValues,$argCondition);

	$funQuery	= "UNLOCK TABLES";
	mysql_query($funQuery);

	return $varPhonePinNo;
}

if($varAddFrmSubmit == 'yes') {
	//CONNECT DATABASE
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varCountryCode	= $arrIsdCountryCode[$_REQUEST['assuredcountry']];
	$varAreaCode	= trim($_REQUEST['areano']);
	$varTmpPhoneNo	= trim($_REQUEST['phoneno']);
	$varTmpMobileNo	= trim($_REQUEST['mobileno']);
	if($varTmpPhoneNo == '') {
		$varPhoneNo	= $varCountryCode.'~'.$varTmpMobileNo;
	} else {
		$varPhoneNo		= $varCountryCode.'~'.$varAreaCode.'~'.$varTmpPhoneNo;
	}
	$varPersonType	= $_REQUEST['contacttype'];
	$varPersonName	= trim($_REQUEST['personname']);
	$varContactTime	= trim($_REQUEST['time']);
	$varComments	= trim($_REQUEST['comments']);
	$varPinNo		= getPinNo($objDBMaster,$varTable['ASSUREDCONTACTPINNOSERIES']);

	//CHECK WHETHER RECORD IS AVAILABLE OR NOT FOR THIS USER
	$argCondition	= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varRecordAvail	= $objDBSlave->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriId',$argCondition);

	if($varRecordAvail == 1) {
		//Check Phone no details modified or other details modified
		//UPDATE assuredcontactbeforevalidation
		$argFields 			= array('ContactPerson1','Relationship1','Timetocall1','Description');
		$argFieldsValues	= array($objDBMaster->doEscapeString($varPersonName,$objDBSlave),$objDBMaster->doEscapeString($varPersonType,$objDBSlave),$objDBMaster->doEscapeString($varContactTime,$objDBSlave),$objDBMaster->doEscapeString($varComments,$objDBSlave));
		
		if($_REQUEST['oldassuredcountry'] != $varCountryCode || $_REQUEST['oldareano'] != $varAreaCode || $_REQUEST['oldphoneno'] != $varTmpPhoneNo || $_REQUEST['oldmobileno'] != $varTmpMobileNo ) {
			$argFields 			= array('TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1');
			$argFieldsValues	= array("NOW()",$objDBMaster->doEscapeString($varCountryCode,$objDBMaster),$objDBMaster->doEscapeString($varAreaCode,$objDBMaster),$objDBMaster->doEscapeString($varTmpPhoneNo,$objDBMaster),$objDBMaster->doEscapeString($varTmpMobileNo,$objDBMaster),$objDBMaster->doEscapeString($varPhoneNo,$objDBMaster));
		}

		$varUpdateId	= $objDBMaster->update($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argFieldsValues,$argCondition);
	} else {
		//INSERT INTO assuredcontactbeforevalidation 
		$argFields		= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','Description','VerificationSource');
		$argFieldsValues= array($objDBMaster->doEscapeString($varPinNo,$objDBMaster),$objDBMaster->doEscapeString($sessMatriId,$objDBMaster),"NOW()",$objDBMaster->doEscapeString($varCountryCode,$objDBMaster),$objDBMaster->doEscapeString($varAreaCode,$objDBMaster),$objDBMaster->doEscapeString($varTmpPhoneNo,$objDBMaster),$objDBMaster->doEscapeString($varTmpMobileNo,$objDBMaster),$objDBMaster->doEscapeString($varPhoneNo,$objDBMaster),"'0'",$objDBMaster->doEscapeString($varPersonName,$objDBMaster),$objDBMaster->doEscapeString($varPersonType,$objDBMaster),$objDBMaster->doEscapeString($varContactTime,$objDBMaster),$objDBMaster->doEscapeString($varComments,$objDBMaster),"''");
		$varInsertId	= $objDBMaster->insert($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argFieldsValues);
	}
	
	$varAddedPhoneNo= 1;
	unset($objDBMaster);
} else {
	$varAddedPhoneNo=0;

	//GETTING PHONE VERIFIED FLAG FROM memberinfo
	$argFields			= array('Phone_Verified');
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varPhoneVerifiedSet= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varPhoneVerified	= mysql_fetch_assoc($varPhoneVerifiedSet);

	if($varPhoneVerified['Phone_Verified'] == 1) {
		$varTableName	= $varTable['ASSUREDCONTACT'];
	} else {
		$varTableName	= $varTable['ASSUREDCONTACTBEFOREVALIDATION'];
	}

	//GETTING VALUES FROM assuredcontactbeforevalidation
	$argFields			= array('CountryCode','AreaCode','PhoneNo','MobileNo','ContactPerson1','Relationship1','Timetocall1','Description');
	$argCondition		= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varContactDetailSet= $objDBSlave->select($varTableName,$argFields,$argCondition,0);
	$varContactDetail	= mysql_fetch_assoc($varContactDetailSet);

	$arrTempCountry		= array_flip($arrIsdCountryCode);
	$varCountryCode		= $arrTempCountry[$varContactDetail['CountryCode']];
	$varAreaCode		= $varContactDetail['AreaCode'];
	$varLandLineNo		= $varContactDetail['PhoneNo'];
	$varMobileNo		= $varContactDetail['MobileNo'];
	
	$varContactPerson	= $varContactDetail['ContactPerson1'];
	$varContactType		= $varContactDetail['Relationship1'];
	$varTImeToCall		= $varContactDetail['Timetocall1'];
	$varComments		= $varContactDetail['Description'];
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/verifyphone.js" ></script>

<form name="frmAssuredContact" method="post" onSubmit="return verifyphValidation();">
<input type="hidden" name="act" value="addverifyphoneno">
<input type="hidden" name="addverifyphnoSubmit" value="yes">
<input type="hidden" name="oldassuredcountry" value="<?=$varCountryCode?>">
<input type="hidden" name="oldareano" value="<?=$varAreaCode?>">
<input type="hidden" name="oldphoneno" value="<?=$varLandLineNo?>">
<input type="hidden" name="oldmobileno" value="<?=$varMobileNo?>">
<!-- Content Area for phone addition-->
	<? if($varAddedPhoneNo == 1) {?>
    <div id="assuredcontactresult">
		<div style="margin: 10px 10px 0px;"><div class="smalltxt">
			<div style="padding-left: 20px; padding-right: 20px;">
				<div class="normalrow" style="padding: 0px 0px 10px;">
					<div class="mediumhdtxt boldtxt clr3" style="padding-bottom: 5px;">Verify Phone Number</div>
					<div class="smalltxt"> Thank you for adding your phone number. Please follow the steps given below to verify your phone number.</div><br clear="all">
					<div class="vdotline1" style="height: 1px;"><img src="http://imgs.oriyamatrimony.com/bmimages/trans.gif" height="1"></div>
					<div style="padding: 10px 0px 0px;"><font class="mediumhdtxt boldtxt">Steps to verify your phone number:</font><br></div>
				</div>
				<div class="normalrow" style="padding: 0px 0px 10px;">
					<div style="height: 40px;">
						<font class="mediumhdtxt boldtxt">Verification through phone:</font><br>
						Follow these simple steps to verify your phone number:</div>
						<div class="smalltxt" style="padding: 0px 0px 0px 25px;">
							<div class="fleft"><b>Step 1:</b></div><br clear="all"><div class="fleft" style="padding-left: 5px; padding-top: 5px;">Call <b>1-800-3000-3344 / 1-800-425-3344 </b>(BSNL/MTNL Users) from <b>9884099999.</b><br><br></div><br clear="all">
							<div class="fleft"><b>Step 2:</b></div><br clear="all"><div class="fleft" style="padding-left: 5px;"> Enter the PIN Number <font class="mediumhdtxt boldtxt clr3"><?=$varPinNo?><!--161909--></font> when prompted by the phone verification system.</div> <br clear="all">
						</div>
						<br clear="all"><div class="smalltxt1" style="padding-bottom: 5px;"> Note: If you're calling from outside India, please do not use calling cards.</div><div class="vdotline1" style="height: 1px;"><img src="http://imgs.oriyamatrimony.com/bmimages/trans.gif" height="1"></div>
					</div>
					<div class="normalrow" style="padding-bottom: 5px;">
						<div class="smalltxt">Need help? Contact <a href="mailto:phonesupport@bharatmatrimony.com" class="smalltxt clr1" target="_blank">phonesupport@bharatmatrimony.com</a></div>
					</div>
					<div class="vdotline1" style="height: 1px;"><img src="http://imgs.oriyamatrimony.com/bmimages/trans.gif" height="1"></div>
					<div style="width: 475px;">
						<div class="fright" style="padding: 5px 0px 0px;"><input class="button" name="btnclose" value="Close" type="button"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<? } else { ?>
    <div id="assuredcontact" style="display: <?=$varAssuredContactDisp?>;">
      <div class="smalltxt" style="margin-left: 15px;">
        <div class="fleft vc1"><div class="mediumhdtxt boldtxt clr3">Add/Verify Phone Number<br clear="all"></div>
          <div class="smalltxt" style="padding-top: 10px;">
            It's important that you add/verify your phone number because:
            <ul class="smalltxt" style="margin: 0px; padding-top: 2px; padding-left: 30px;">
              <li>Only verified phone numbers are displayed on the site.</li>
              <li>It shows that you're genuine.</li>
              <li>It helps members to contact you directly.</li>
            </ul>
          </div>
          <div style="padding-top: 5px;">Only paid members can view your phone number and you will also get to know the members who have viewed your number. This means that you will only be contacted by members who are really interested in you.</div>
          <div style="padding-top: 5px;">
            Given below are your contact details. Please make changes if any and click on "Continue".</div>
          </div>
          <div class="fleft vc1">
            <div class="fleft inntabbr1"></div>
            <div class="fleft inntabbg"><div class="smalltxt1" style="float: right; padding-top: 10px;">All fields marked with <font class="clr1 mediumtxt boldtxt">*</font> are mandatory.</div></div>
            <div class="fleft inntabbr1"></div>
          </div><br clear="all">
	<!-- Middle Content -->
     <div class="vc1">
      <div class="fleft inntabbr2"></div>
      <div class="fleft middiv2">
          <div style="padding: 0px 10px 0px 15px;">
            <div class="normalrow" style="padding-bottom: 10px;">
              <div class="smalltxt">
                <div style="width: 155px;" class="fleft smalltxt"><span id="countryspan" class="errortxt"></span><br><b>Country </b><font class="clr1 boldtxt">*</font> &nbsp;<br>
                  <select class="inputtext" style="width: 155px;" name="assuredcountry" id="assuredcountry" size="1" onblur="assuredCountryChk();">

                    <?=$objCommon->getValuesFromArray($arrCountryList, '- Select - ', '0', $varCountryCode);?>

                </select><br><br><div class="mediumtxt1 boldtxt" style="padding-top: 10px;">Contact Preferences</div></div>
                <div style="padding-left: 10px;" class="fleft smalltxt boldtxt"><span id="areaspan" class="errortxt"></span><span id="errphoneno" class="errortxt"></span><span id="errmobileno" class="errortxt"></span><br>Area Code <span class="clr4" id="areaoptional">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Landline <font class="clr1 boldtxt">*</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile Number <font class="clr1 boldtxt">*</font><br><input name="areano" class="inputtext" value="<?=$varAreaCode?>" type="text" onblur="phoneChk();" >&nbsp;&nbsp;&nbsp;&nbsp;<input name="phoneno" class="inputtext" value="<?=$varLandLineNo?>" type="text">&nbsp;&nbsp;or&nbsp;&nbsp;<input name="mobileno" class="inputtext" value="<?=$varMobileNo?>" type="text"></div><br clear="all">
            <!-- maxlength is set to 11 for users who enter mobile no with 0 or not -->
                <div class="vdotline1" style="height: 1px;"><img src="http://imgs.oriyamatrimony.com/bmimages/trans.gif" height="1"></div>

                <div class="fleft smalltxt" style="width: 245px;"><span id="ctypespan" class="errortxt"></span><br><b>Whom to contact </b><font class="clr1 boldtxt">*</font>&nbsp;<br>
                  <select name="contacttype" style="width: 235px;" class="inputtext" onblur="contactChk();">

                    <?=$objCommon->getValuesFromArray($arrWhomToContactList, '- Select - ', '', $varContactType);?>

                  </select>
                </div>
                <div class="fleft smalltxt boldtxt" style="padding-bottom: 5px;"><span id="cpnamespan" class="errortxt"></span><br>Contact person's name <font class="clr1 boldtxt">*</font>&nbsp;<br><input name="personname" size="41" class="inputtext" onblur="personChk();" type="text" value="<?=$varContactPerson?>"></div><br clear="all">
                <div style="width: 150px;" class="fleft smalltxt boldtxt"><span id="timespan" class="errortxt"></span><br>Convenient time to call <font class="clr1 boldtxt">*</font>&nbsp;<br>
                  <input name="time" size="41" class="inputtext" onblur="timeChk();" type="text" value="<?=$varTImeToCall?>">
                </div><br clear="all">
                <div style="width: 250px; padding-top: 10px;" class="fleft smalltxt boldtxt">Comments&nbsp;<br>
                  <div style="float: left;"><textarea name="comments" id="comments" cols="50" rows="5" class="inputtext" style="width: 480px;"><?=$varComments?></textarea></div>
                </div><br clear="all">
              </div>
            </div>
            <div class="smalltxt" style="padding-top: 10px;">
              <div class="fleft" style="padding-left: 400px;"><input value="Continue" class="button" type="submit"></div>
          </div><br clear="all">
          <div style="padding-top: 10px;"></div>
          <div class="vdotline1" style="height: 1px;"><img src="http://imgs.oriyamatrimony.com/bmimages/trans.gif" height="1"></div>
          <div style="padding-top: 10px;"></div><font class="smalltxt boldtxt">The "Assured Contact" process copyrighted.<br>Copyright Registration no.L-25088/2005 for ASSURED CONTACT</font>
      </div>
    </div>
    <div class="fleft inntabbr2"></div>
  </div>
  </div><br clear="all">
  <!-- Middle Contant }-->
  </div>
  <? } ?>
</form>