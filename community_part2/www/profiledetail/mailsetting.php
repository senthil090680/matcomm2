<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-20
# Project	  : MatrimonyProduct
# Filename	  : changepassword.php
#=====================================================================================================================================
# Description : Password change Here
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];

//OBJECT DECLARATION
$objDBSlave	= new DB;
$objDBMaster= new DB;


//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['mailset'];

if($sessMatriId==""){
	$varMessage='You are either logged off or your session timed out. <a href="http://'.$confValues['SERVERURL'].'/login/login.php" class="clr1">Click here</a> to login.';exit;
} else if($varUpdatePrimary == 'yes') {
	//$varMatchWatchFreq	= ($_REQUEST['matchWatch']==1)?$_REQUEST['matchWatchFreq']:0;
	$varMatchWatchFreq	= $_REQUEST['matchWatch'];
	$varIntPromoAlert	= $_REQUEST['generalPromo'];	
	$varThirdParty		= $_REQUEST['externalPromo'];
	$varSplFeatureAlert	= $_REQUEST['splFeatureAlert'];	
	$varMobileAlert		= $_REQUEST['mobilealert'];
	$varAutologinAlert	= $_REQUEST['autologin'];
	$varCurrentDate		= date('Y-m-d H:i:s');

	//CONNECT DATABASE
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$argFields			= array('CommunityId','MatriId','Matchwatch','SpecialFeatures','Promotions','ThirdParty','MobileAlert','Date_Updated');
	$argFieldsValues	= array($confValues['DOMAINCASTEID'],$objDBMaster->doEscapeString($sessMatriId,$objDBMaster),$objDBMaster->doEscapeString($varMatchWatchFreq,$objDBMaster),$objDBMaster->doEscapeString($varSplFeatureAlert,$objDBMaster),$objDBMaster->doEscapeString($varIntPromoAlert,$objDBMaster),$objDBMaster->doEscapeString($varThirdParty,$objDBMaster),$objDBMaster->doEscapeString($varMobileAlert,$objDBMaster),"'".$varCurrentDate."'");
	$varInsertId		= $objDBMaster->insertOnDuplicate($varTable['MAILMANAGERINFO'],$argFields,$argFieldsValues,'MatriId');

	$argFields			= array('Email_Status','Date_Updated');
	$argFieldsValues	= array($objDBMaster->doEscapeString($varAutologinAlert,$objDBMaster),"'".$varCurrentDate."'");
	$argCondition		= " MatriId=".$objDBMaster->doEscapeString($sessMatriId,$objDBMaster);
	$varUpdateId		= $objDBMaster->update($varTable['MEMBERLOGININFO'],$argFields,$argFieldsValues,$argCondition);
	
	$varMessage = 'yes';
	//CLOSE DATABASE
	$objDBMaster->dbClose();
} else {
	//CONNECT DATABASE
	$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);	

	//getting auto login
	$argFields					= array('Email_Status');
	$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varAutoLoginResultSet		= $objDBSlave->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
	$varAutoLoginResult			= mysql_fetch_assoc($varAutoLoginResultSet);
	$varEnableAutoLogin			= $varAutoLoginResult['Email_Status'];

	$argFields					= array('Matchwatch','SpecialFeatures','Promotions','ThirdParty','MobileAlert');
	$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varMWFreqResultSet			= $objDBSlave->select($varTable['MAILMANAGERINFO'],$argFields,$argCondition,0);
	$varMWFreqResult			= mysql_fetch_assoc($varMWFreqResultSet);

	//Getting matach freq alert
	$varMWFrequency				= $varMWFreqResult['Matchwatch'];
	$varSplFeatureAlert			= $varMWFreqResult['SpecialFeatures'];
	$varIntPromoAlert			= $varMWFreqResult['Promotions'];
	$varThirdParty				= $varMWFreqResult['ThirdParty'];
	$varMobileAlert				= $varMWFreqResult['MobileAlert'];

	//Getting Sms Alert
	$argFields					= array('Phone_Verified');
	$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varphoneverfiedResultSet	= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varphoneverfiedResult		= mysql_fetch_assoc($varphoneverfiedResultSet);	
	$varPhoneVerfied            = $varphoneverfiedResult['Phone_Verified'];	
	
	$argFields					= array('PhoneNo1');
	$argCondition				= "WHERE MatriId=".$objDBSlave->doEscapeString($sessMatriId,$objDBSlave);
	$varMobileResultSet			= $objDBSlave->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
	$varMobileResult			= mysql_fetch_assoc($varMobileResultSet);
	$varPhoneNo				    = $varMobileResult['PhoneNo1'];
	$varSeparatePhoneNo			= explode("~",$varMobileResult['PhoneNo1']);
	$varCountPhoneNo            = count($varSeparatePhoneNo);
	
	//CLOSE DATABASE
	$objDBSlave->dbClose();
}
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<div><? include_once('settingsheader.php');?></div>
<div class="padt10 smalltxt">
<?if($varUpdatePrimary == 'yes') { ?>
		<div class='fleft' style='width:490px;'>
			Your mail alerts have been successfully updated.
		</div>
		<? } else {?>

<div class="fleft">
<form name="frmMailAlert" method="post" style="margin: 0px;">
		<input type='hidden' name='act' value='mailsetting'>
		<input type='hidden' name='mailset' value='yes'>


		<div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;">Auto Login</div>
        <div class="fleft tlleft" style="width:450px;padding-left:30px;padding-top:5px;">
			<div>Auto-login saves you the process of logging into your account with your e-mail id and password when you click the link on an e-mail from us.</div>
            <div style="padding-top:5px;">
			<input type="radio" name="autologin" value="0" <?if($varEnableAutoLogin=='' || $varEnableAutoLogin==0) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp;
			<input type="radio" name="autologin" value="1" <?if($varEnableAutoLogin!='' && $varEnableAutoLogin!=0) { echo "checked"; }?> class="frmelements"><font class="clr">Off</font>
            </div>
        </div>

        <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">E-mail Alerts</div>
        <div class="fleft tlleft" style="width:450px;padding-left:30px;padding-top:5px;">You will receive e-mail alerts when members send you the following communication:</div>
        <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">Member to member communication</div>
        <div class="fleft tlleft" style="width:450px;padding-left:30px;padding-top:5px;">
        <ul style="margin:0px;padding:0px;padding-left:15px;"><li>Template Message or Personalised Message</li>
		<li>Request for photo<? if ($_FeatureHoroscope==1){ ?>, horoscope <?}?>& phone number<br clear="all"></li>
		<li>When members have added photo<? if ($_FeatureHoroscope==1){ ?>, horoscope <?}?>& phone number based on your request</li></ul>
        </div>
        <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">Daily MatchWatch</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">You will receive e-mail updates whenever we launch a new product or service</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">
            <input type="radio" name="matchWatch" value="1" <?if($varMWFrequency!='' && $varMWFrequency!=0) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp;
			<input type="radio" name="matchWatch" value="0" <?if($varMWFrequency=='' || $varMWFrequency==0) { echo "checked"; }?> class="frmelements"><font class="clr">Off</font>
         </div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">Product Feature E-mail</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">You will receive e-mail updates whenever we launch a new product or service</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">
            <input type="radio" name="splFeatureAlert" value="1" <?if($varSplFeatureAlert==1) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="splFeatureAlert" value="0" <?if($varSplFeatureAlert==0 || $varSplFeatureAlert=='') { echo "checked"; }?> class="frmelements"><font class="clr">Off</font>
         </div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">Group Promotions</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">You can receive promotions and offers from our other group portals.</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;"><input type="radio" name="generalPromo" value="1" <?if($varIntPromoAlert==1) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="generalPromo" value="0" <?if($varIntPromoAlert==0 || $varIntPromoAlert=='') { echo "checked"; }?> class="frmelements"><font class="clr">Off</font></div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">Third Party Offers</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">Receive 3rd party offers (from our group)</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;"><input type="radio" name="externalPromo" value="1" <?if($varThirdParty==1) { echo "checked"; }?> class="frmelements"><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="externalPromo" value="0" <?if($varThirdParty==0 || $varThirdParty=='') { echo "checked"; }?> class="frmelements"><font class="clr">Off</font></div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">SMS Alerts</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">
            <?php if($varPhoneVerfied==0){
    			echo'Please verify your <a href="'.$confValues[SERVERURL].'/profiledetail/index.php?act=primaryinfo" class="clr1">mobile number</a> to receive the following SMS alerts';
    		    }else if((($varPhoneVerfied==1)||($varPhoneVerfied==3))&&($varCountPhoneNo==2)){
    		    echo'You will receive the following SMS alerts on your mobile : <font class="alerttxt">'.$varSeparatePhoneNo[1].'</font>';
    		    } else if((($varPhoneVerfied==1)||($varPhoneVerfied==3))&&($varCountPhoneNo==3)){
    		    echo'To receive the following SMS alerts you must
    		    <a href="'.$confValues[SERVERURL].'/profiledetail/index.php?act=primaryinfo" class="clr1">add and verify your mobile number</a><br>Note: Once you verify your mobile number, the same will be shown to prospective members as verified contact number.';
    		 }?>
         </div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">New Message Alert</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">You will receive a SMS alert whenever a member sends you a personalised message. </div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">New Interest Alert</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">You will receive a SMS alert whenever a member sends you an Interest.</div>
         <div class="smalltxt clr bld fleft" style="padding-left:10px;width:450px;padding-top:10px;">Interest Accepted Alert</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;">You will receive a SMS alert whenever a member accepts your Interest.</div>
         <div class="smalltxt clr fleft" style="padding-left:30px;width:450px;padding-top:5px;"><input type="radio" name="mobilealert" value="1" class="frmelements" <?if($varMobileAlert==1){echo "checked";}?>><font class="clr">On</font> &nbsp;&nbsp; <input type="radio" name="mobilealert" value="0" class="frmelements"<?if($varMobileAlert==0 || $varMobileAlert==''){echo "checked";}?>><font class="clr">Off</font></div>
         <div align="left" class="smalltxt clr fleft" style="width:450px;padding-top:20px;">
            <div align="right"><input type="submit" class="button" value="Subscribe"></div>
         </div>
         <div style="width:450px;float:left;height:30px;">&nbsp;</div>
		</form>

</div>
<? } ?>
</div>
