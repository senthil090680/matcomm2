<?php
#=============================================================================================================
# Author 		: Mahul
# Project		: CommunityMatrimony
# Module		: Doorstep Payment Page
#=============================================================================================================

//INCLUDE FILES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/payment.cil14');
include_once($varRootBasePath."/www/payment/paymentprocess.php");
include_once($varRootBasePath."/lib/clsDB.php");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsMailManager.php');
include_once($varRootBasePath.'domainslist/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');

//OBJECT DECLARTION
$objCommon		= new clsCommon;
$objMailManager = new MailManager;
$objDomainInfo  = new domainInfo;
$objEPR			= new DB;
$objSlaveDB		= new DB;
$objMasterDB	= new DB;

//CONNECT DATABASE
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M',$varDbInfo['DATABASE']);
$objEPR->dbConnect('ODB4',$varDbInfo['EPRDATABASE']);
//echo"<pre>";
//echo print_r($_REQUEST);

//VARIABLE DECLARATION
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$varSubmit			= $_POST["doorStepSubmit"];
$varCategory		= $_REQUEST['category'];
$varAct				= $_REQUEST['act'];
$varError			= 'no';
$varErrorField		= '';
$varEntryFrom		= 9;

if((isset($sessMatriId))&&($sessMatriId != '')) {

$varFields		= array('AppointmentDate','EntryFrom','RequestNo');
$varCondition	= "WHERE MatriId=".$objEPR->doEscapeString($sessMatriId,$objEPR)." and AutoClose=0 order by RequestNo desc limit 1";
$varLastLogin	= $objEPR->select($varTable['EASYPAYINFO'],$varFields,$varCondition,0);
$varLastInfo	= mysql_num_rows($varLastLogin);
$varlastFetch   = mysql_fetch_array($varLastLogin);
$varRequestNo   = $varlastFetch['RequestNo'];
}else{
	$varLastInfo="0";
}


$arrConsolidatedPrdOffering = array();
$lx = 1;
for ($ix=1;$ix<=3;$ix++) {
	for ($jx=1;$jx<=3;$jx++) {
		$arrConsolidatedPrdOffering[$lx++] = $arrPrdPackages[$ix]." ".$arrPrdTime[$jx];
	}
}

if ($varSubmit=='yes') {
$varCategory		= $_REQUEST['category'];
$varName			= trim($_REQUEST['name']);
$varMatriId			= trim($_REQUEST['matriId']);
$varCity			= trim($_REQUEST['city']);
$varContactPerson	= trim($_REQUEST['contactPerson']);
$varContactNumber	= trim($_REQUEST['contactNumber']);
$varAddress			= trim($_REQUEST['address']);
$varToDate			= trim($_REQUEST['todate']);
$varFromTime		= trim($_REQUEST['fromTime']);
$varToTime			= trim($_REQUEST['toTime']);
$varEmail			= trim($_REQUEST['email']);
$varAge				= trim($_REQUEST['age']);
$varGender			= trim($_REQUEST['gender']);
$varFrmSrc  		= trim($_REQUEST['frmsrc']);

foreach($timeRangeFromAndToKey as $key=>$value){
	if($value==$varFromTime){
		$varJoinTime=$value;
		$varFromTimeInserted=$key;
	}
}
foreach($timeRangeFromAndToKey as $key=>$value){
	if($value==$varToTime){
		$varToTimeInserted=$key;
	}
}

if ($varGender=='1') { $varGender='M';  }
else if ($varGender=='2') { $varGender='F';  }


$varMessage	= 'Category = '.$arrPrdPackages[$varCategory];
$varMessage	.= '<br>Name = '.$varName;
$varMessage	.= '<br>MatriId = '.$varMatriId;
$varMessage	.= '<br>City = '.$arrDoorStepCities[$varCity];
$varMessage	.= '<br>Contact Person = '.$varContactPerson;
$varMessage	.= '<br>Contact No. = '.$varContactNumber;
$varMessage	.= '<br>Address = '.$varAddress;
$varMessage	.= '<br>Appointment Date = '.$varToDate;
$varMessage	.= '<br>From Time = '.$varFromTime;
$varMessage	.= '<br>To Time = '.$varToTime;
$varMessage	.= '<br>Email = '.$varEmail;
$varSubject	= 'Door Step Payment';
$varToEmail	= 'doorstep@communitymatrimony.com';

//$varFields	= array('MatriId','Name','Product_Id','Contact_Person','Contact_Number','Email','City','Address','Time_From','Time_To','EntryFrom','Date_Created');
//$varFieldsValues	= array("'".$varMatriId."'","'".$varName."'","'".$varCategory."'","'".$varContactPerson."'","'".$varContactNumber."'","'".$varEmail."'","'".$varCity."'","'".$varAddress."'","'".$varFromTime."'","'".$varToTime."'",'9','NOW()');

$varFields			= array('AppointmentDate','EntryFrom','RequestNo');
$varCondition		= "WHERE MatriId=".$objEPR->doEscapeString($varMatriId,$objEPR)." and AutoClose=0 order by RequestNo desc limit 1";
$varExecute			= $objEPR->select($varTable['EASYPAYINFO'],$varFields,$varCondition,0);
$varRequestInfo		= mysql_num_rows($varExecute);
$varRequestFetch    = mysql_fetch_array($varExecute);
//$varRequestNo		= $varLoginFetch['RequestNo'];


if ($varFrmSrc=='f2p') {
	$varEntryFrom = 13;
}
if (($varCategory=='0' || $varCategory=='')) {
	$varError	= 'yes';
	$varErrorField	.= 'Category, ';
}
if ($varContactNumber=='') {
	$varError	= 'yes';
	$varErrorField	.= 'Contact number, ';
}
/* if ($varCity=='') {
	$varError	= 'yes';
	$varErrorField	.= 'City, ';
}*/
if ($varContactPerson=='') {
	$varError	= 'yes';
	$varErrorField	.= 'contact person name, ';
}
if ($varError=='yes' && $varErrorField!='') {
	$varContent = '<font color="red">! Please enter '.rtrim(trim($varErrorField),',').'</font>';
	$varError	= 'yes';
} if($varRequestInfo ==1){
	$varContent1 = '<font color="red"> You have already made a doorstep payment request. Your Customer ID is '.$varMatriId.'.</font>';
	$varContent2 = '<font color="red">Request No is '.$varRequestNo.'.</font>';
	$varContent3 = '<font color="red">We will contact you soon regarding collection of payment. </font>';
	if((isset($sessMatriId))&&($sessMatriId != '')) {
		$varContent=$varContent1.' '.$varContent2.' '.$varContent3;
	}else{
		$varContent=$varContent1.' '.$varContent3;
	}
	$varError	= 'yes';

}else {

	$varFields	= array('MatriId','ContactName','ContactPhone','ContactMobile','PreferredPackage','EMail','ResidingDistrict','Address','AppointmentDate','EntryFrom','RequestDate','Gender','Age','AppointmentTime');
	$varAppoinmentDate		= $varToDate.' '.$varJoinTime;
	$varFieldsValues	= array($objEPR->doEscapeString($varMatriId,$objEPR),$objEPR->doEscapeString($varContactPerson,$objEPR),$objEPR->doEscapeString($varContactNumber,$objEPR),$objEPR->doEscapeString($varContactNumber,$objEPR),$objEPR->doEscapeString($varCategory,$objEPR),$objEPR->doEscapeString($varEmail,$objEPR),$objEPR->doEscapeString($varCity,$objEPR),$objEPR->doEscapeString($varAddress,$objEPR),$objEPR->doEscapeString($varAppoinmentDate,$objEPR),
	$objEPR->doEscapeString($varEntryFrom,$objEPR),"NOW()",$objEPR->doEscapeString($varGender,$objEPR),$objEPR->doEscapeString($varAge,$objEPR),"'".$varFromTimeInserted." to ".$varToTimeInserted."'");
	$varRequestNo	= $objEPR->insert($varTable['EASYPAYINFO'],$varFields,$varFieldsValues);
	$varContent = 'Thank you for using the  Pay at Doorstep  facility. One of our  customer care  representatives  will contact you shortly. Please use this Request No. '.$varRequestNo.' for future reference.';
}
//$objMailManager->sendEmail($arrEmailsList['ADMINEMAIL'],$confValues['PRODUCTNAME'],$confValues['PRODUCTNAME'],$varToEmail,$varSubject,$varMessage,$varToEmail);
} else {

	if ($sessMatriId !="") {
		$varFields		= array('MatriId','Email');
		$varCondition	= "WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varExecute		= $objSlaveDB->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,0);
		$varLoginInfo	= mysql_fetch_array($varExecute);
		$varMatriId		= $varLoginInfo['MatriId'];
		$varEmail		= $varLoginInfo['Email'];


		//MEMBERINFO
		$varFields		= array('Name','Nick_Name','Age','Gender');
		$varCondition	= "WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varExecute		= $objSlaveDB->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);
		$varMemberInfo	= mysql_fetch_array($varExecute);
		$varName		= trim($varMemberInfo['Name']);
		$varNickName	= trim($varMemberInfo['Nick_Name']);
		$varNickName	= $varNickName ? $varNickName : $varName;
		$varAge			= trim($varMemberInfo['Age']);
		$varGender		= trim($varMemberInfo['Gender']);


		$varFields		= array('MobileNo','PhoneNo1');
		$varCondition	= "WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varExecute		= $objSlaveDB->select($varTable['ASSUREDCONTACT'],$varFields,$varCondition,0);
		$varContactInfo	= mysql_fetch_array($varExecute);
		$varMobile		= trim($varContactInfo['MobileNo']);
		$varPhone		= trim($varContactInfo['PhoneNo1']);
		$varPhoneNo		= $varMobile ? $varMobile : $varPhone;
	}
}

if($_REQUEST['offerAvailable'] == 0 || ($_REQUEST['offerAvailable'] ==1 && ($_REQUEST['offerCategoryId'] == $varRenewalOfferCategoryId))) {
$varOfferFields = array(
      20=>'MatriId',
      21=>'OfferCategoryId',
      22=>'OfferCode',
      23=>'OfferStartDate',
      24=>'OfferEndDate',
      25=>'DateUpdated',
	  26=>'OfferAvailedStatus');

$varOfferFieldsValues = array(
      20=>"'".$varMatriId."'",
      21=>"'".$varRenewalOfferCategoryId."'",
      22=>"'".$varMatriId."'",
      23=>'NOW()',
      24=>'DATE_ADD(NOW(),INTERVAL 3 DAY)',
      25=>'NOW()',
	  26=>'0');

$varMergeFields       = array_merge($varOfferFields,$arrDiscountFields);
$varMergeFieldsValues = array_merge($varOfferFieldsValues, $$_REQUEST['checkOffer']);
$varFields            = array_values($varMergeFields);
$varFieldsValues      = array_values($varMergeFieldsValues);
$varResult =$objMasterDB->insertOnDuplicate($varTable['OFFERCODEINFO'],$varFields,$varFieldsValues,'MatriId');

	if($_REQUEST['offerType']=='arrNextLevelValues' || $_REQUEST['offerType']=='arrPercentageValues'){
    $offer_comments = '';
    if($_REQUEST['offerType']=='arrNextLevelValues'){$offer_comments = 'Next Level Offer';}
	elseif($_REQUEST['offerType']=='arrPercentageValues'){$offer_comments = '10% Discount Offer';}

    $varFields       = array('Comments');
	$varFieldsValues = array("'".$offer_comments."'");
	$varCondition	 = "MatriId = ".$objEPR->doEscapeString($varMatriId,$objEPR);
	$varUpdateId	 = $objEPR->update($varTable['EASYPAYINFO'],$varFields,$varFieldsValues,$varCondition);
	}

	if($varResult === true) {
	$varFields       = array('OfferAvailable','OfferCategoryId');
	$varFieldsValues = array(1,$varRenewalOfferCategoryId);
	$varCondition	 = "MatriId = ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$varUpdateId	 = $objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
	}
}
?>
<script language="javascript" type="text/javascript">

var currenttime = '<? print date("F d, Y H:i:s", time())?>'
</script>

<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
<script language=javascript src="<?=$confValues["JSPATH"];?>/common.js"></script>
<script language=javascript src="<?=$confValues["IMGURL"];?>/scripts/payment.js"></script>
<script language="javascript" src="<?=$confValues['IMGURL']?>/scripts/datetimepicker_css.js"></script>

<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5">
		<font class="clr bld">Pay at your doorstep </font> <font class="clr">(Easy Payment Facility)</font>
	</div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<br clear="all"/>
	<? if ($varSubmit=='yes' && $varError=='no') { echo $varContent; } else {
	?>
	<?php if($varLastInfo == 0){?>
	<div class="fleft padt5">
	<div class="normtxt1 clr">
		This is an exclusive service from <?=$confValues['PRODUCTNAME']?> to make it easy for you to make payments. All you have to do is complete the form below and our representative will come and collect the payment from wherever you are.
	</div>
	<br clear="all" />
	</div>
	<?php }?>
	<? if ($varError=='yes'){ ?>
		<br clear="all" />
		<center>
			<div class="alerttxt clr3 brdr" style="background-color:#efefef;padding:1px 10px; width:450px;">
				<? echo $varContent; ?>
			</div>
		</center>
		<br clear="all" />
	<? }
              if($_FeatureHoroscope==0) {
					unset($arrPrdPackages[110]);
					unset($arrPrdPackages[111]);
					unset($arrPrdPackages[112]);
				}
				if($_FeatureHoroscope==1){
					  $arrPrdPackages[110]=$arrPrdPackages[110].' '.'('.$arrAstroPackage[110].')';
					  $arrPrdPackages[111]=$arrPrdPackages[111].' '.'('.$arrAstroPackage[111].')';
					  $arrPrdPackages[112]=$arrPrdPackages[112].' '.'('.$arrAstroPackage[112].')';
				}
	?>
		<!-- Form -->
		<?php if($varLastInfo == 0){?>
	<form name="doorStep" action="index.php" method="post" onSubmit="return funDoorStep();">
		<input type="hidden" name="act" value="doorstep"/>
		<input type="hidden" name="doorStepSubmit" value="yes"/>
		<input type="hidden" name="offerType" value="<?=$_REQUEST['checkOffer'];?>"/>

		<input type="hidden" name="age" value="<?=$varAge?>"/>
		<input type="hidden" name="gender" value="<?=$varGender?>"/>

		<div class="pfdivlt smalltxt fleft tlright">Select Category</div>
		<div class="pfdivrt smalltxt fleft">
			<select class="srchselect" name="category" size="1" tabindex="1" onBlur="funCategory();"><?=$objCommon->getValuesFromArray($arrPrdPackages, "--- Select a category ---", '0', $varCategory);?></select><br><span id="categoryspan" class="errortxt"></span></div><br clear="all"/>
		</div>
		<br clear="all"/>
		<div class="pfdivlt smalltxt fleft tlright">Matrimony ID</div>
		<div class="pfdivrt smalltxt fleft"><?=($sessMatriId=='') ? '' : $sessMatriId?>
			<input type="<?=($sessMatriId=='') ? 'text' : 'hidden'?>" name="matriId" size="37" class="inputtext" value="<?=$sessMatriId?>" onBlur="funMatriID();" tabindex="3" /><br><span id="matriidspan" class="errortxt" ></span>
		</div>
		<br clear="all"/>
		<div class="pfdivlt smalltxt fleft tlright">City</div>
		<div class="pfdivrt smalltxt fleft">
			<select class="srchselect" name="city" size="1" tabindex="4" onBlur="funCity();">
				 <option value=""> - Select City - </option>
				 <optgroup label="- Assam -">
					<option value="37">Guwahati</option>
				 </optgroup>
			 <optgroup label="- Gujarat -">
				<option value="3">Ahmedabad</option>
				<option value="83">Rajkot</option>
				<option value="106">Vadodara(Baroda)</option>
				<option value="62">Mehasana</option>
				<option value="7">Anand</option>
				<option value="107">Valsad</option>
				<option value="92">Surat</option>
				<option value="238">Amreli</option>
				<option value="239">BanasKantha</option>
				<option value="240">Bhavnagar</option>
				<option value="241">Dohad</option>
				<option value="242">Gandhinagar</option>
				<option value="243">Jamnagar</option>
				<option value="244">Junagadh</option>
				<option value="245">Kachchh</option>
				<option value="246">Kheda</option>
				<option value="247">Narmada</option>
				<option value="248">Panch Mahals</option>
				<option value="249">Patan</option>
				<option value="250">Porbandar</option>
				<option value="251">Sabar Kantha</option>
				<option value="252">Surendranagar</option>
				<option value="253">Bharuch</option>
				<option value="254">Navsari</option>
				<option value="255">The Dangs</option>
				<option value="256">Vapi</option>
 			 </optgroup>
			<optgroup label="- Bihar -">
				 <option value="74">Patna</option>
				 <option value="85">Ranchi</option>
			</optgroup>
			 <optgroup label="- Madhya Pradesh -">
				 <option value="16">Bhopal</option>
				 <option value="38">Gwalior</option>
				 <option value="44">Jabalpur</option>
				 <option value="43">Indore</option>
				 <option value="194">Dastar</option>
				 <option value="195">Dantewada</option>
				 <option value="196">Dhantari</option>
				 <option value="197">Janghir/Champa</option>
				 <option value="198">Jashpur</option>
				 <option value="199">Kanker</option>
				 <option value="200">Kawardha</option>
				 <option value="201">Mahasamundh</option>
				 <option value="202">Surguja</option>
				 <option value="234">Billaspur</option>
				<option value="271">Anuppur</option>
				<option value="272">Ashoknagar</option>
				<option value="273">Balaghat</option>
				<option value="274">Barwani</option>
				<option value="275">Betul</option>
				<option value="276">Bhind</option>
				<option value="277">Burhanpur</option>
				<option value="278">Chhatarpur</option>
				<option value="279">Chhindwara</option>
				<option value="280">Damoh</option>
				<option value="281">Datia</option>
				<option value="282">Dewas</option>
				<option value="283">Dhar</option>
				<option value="284">Dindori</option>
				<option value="285">Guna</option>
				<option value="286">Harda</option>
				<option value="287">Hoshangabad</option>
				<option value="288">Jhabua</option>
				<option value="289">Katni</option>
				<option value="290">Khandwa</option>
				<option value="291">Khargone</option>
				<option value="292">Mandla</option>
				<option value="293">Mandsaur</option>
				<option value="294">Morena</option>
				<option value="295">Narsinghpur</option>
				<option value="296">Neemuch</option>
				<option value="297">Panna</option>
				<option value="298">Raisen</option>
				<option value="299">Rajgarh</option>
				<option value="300">Ratlam</option>
				<option value="301">Rewa</option>
				<option value="302">Sagar</option>
				<option value="303">Satna</option>
				<option value="304">Sehore</option>
				<option value="305">Seoni</option>
				<option value="306">Shahdol</option>
				<option value="307">Shajapur</option>
				<option value="308">Sheopur</option>
				<option value="309">Shivpuri</option>
				<option value="310">Tikamgarh</option>
				<option value="311">Ujjain</option>
				<option value="312">Umaria</option>
				<option value="313">Vidisha</option>
				<option value="317">Madya</option>
				<option value="327">Sidhi</option>
			</optgroup>
			<optgroup label="- Chhattisgarh -">
				<option value="18">Bilaspur</option>
				<option value="81">Raipur</option>
				<option value="185">Durg/Bhillai</option>
				<option value="186">Korba </option>
			</optgroup>
				<optgroup label="- Rajasthan -">
				<option value="45">Jaipur</option>
				<option value="103">Udaipur</option>
			</optgroup>
			<optgroup label="- Orissa -">
				<option value="17">Bhubaneswar</option>
				<option value="345">Cuttack</option>
				<option value="86">Rourkela</option>
			</optgroup>
			<optgroup label="- Jharkhand -">
				<option value="46">Jamshedpur</option>
				<option value="28">Dhanbad</option>
			</optgroup>
			<optgroup label="- Karnataka -">
				<option value="13">Bangalore</option>
				<option value="61">Mangalore</option>
				<option value="65">Mysore</option>
				<option value="40">Hubli</option>
				<option value="213">Belgaum</option>
				<option value="213">Belgaum</option>
				<option value="214">Bidar</option>
				<option value="215">Gulbarga</option>
				<option value="216">Bijapur</option>
				<option value="217">Raichur</option>
				<option value="218">Bagalkot</option>
				<option value="219">Koppal</option>
				<option value="220">Gadag</option>
				<option value="221">Dharwad</option>
				<option value="222">Uttarkannada</option>
				<option value="223">Chitradurga</option>
				<option value="224">Davangere</option>
				<option value="225">Bellary</option>
				<option value="314">Kolar</option>
				<option value="315">Tumkur</option>
				<option value="318">Coorg</option>
				<option value="319">Chamrajnagar</option>
				<option value="320">udupi</option>
				<option value="321">Chikkamangalore</option>
				<option value="322">Shivmoga</option>
				<option value="323">Hassan</option>
				<option value="328">Haveri</option>
			</optgroup>
			<optgroup label="- Tamil Nadu -">
				<option value="9">Ariyalur</option>
				<option value="24">Chennai</option>
				<option value="29">Dindugul</option>
				<option value="30">Erode</option>
				<option value="26">Coimbatore</option>
				<option value="50">Kanyakumari</option>
				<option value="51">Karaikudi</option>
				<option value="52">Karur</option>
				<option value="56">Kumbakonam</option>
				<option value="59">Madurai</option>
				<option value="88">Salem</option>
				<option value="91">Sivaganga</option>
				<option value="64">Musiri</option>
				<option value="66">Nagercoil</option>
				<option value="69">Namakal</option>
				<option value="94">Thanjavur</option>
				<option value="95">Theni</option>
				<option value="96">Thirunelveli</option>
				<option value="101">Trichy</option>
				<option value="102">Tuticorin</option>
				<option value="76">Peramblur</option>
				<option value="79">Pudukottai</option>
				<option value="82">Rajapalyam</option>
				<option value="79">Ramanathapuram</option>
				<option value="78">Pondicherry</option>
				<option value="109">Vellore</option>
				<option value="111">Virdhunagar</option>
				<option value="128">Cudallore</option>
				<option value="129">Chidambaram</option>
				<option value="130">Vadalur</option>
				<option value="131">Panruti</option>
				<option value="132">Nellikuppam</option>
				<option value="133">Neyveli</option>
				<option value="134">Kattumannarkoil</option>
				<option value="135">Mantharakuppam</option>
				<option value="136">Villupuram</option>
				<option value="137">Tindivanam</option>
				<option value="138">Nagapattinam</option>
				<option value="139">Sirghazi</option>
				<option value="140">Karaikal</option>
				<option value="141">Ulundurpet</option>
				<option value="142">Kallakurichi</option>
				<option value="143">Thiruvannamalai</option>
				<option value="144">Palani</option>
				<option value="145">Mayiladuthurai</option>
				<option value="146">Tiruvarur</option>
				<option value="147">Dharmapuri</option>
				<option value="148">Krishnagiri</option>
				<option value="149">Nilgiris</option>
				<option value="150">Pollachi</option>
				<option value="151">Udumalaipet</option>
				<option value="152">Dharapuram</option>
				<option value="153">Tirupur</option>
				<option value="154">Avinashi</option>
				<option value="155">Thiruvallur</option>
				<option value="156">Arakkonam</option>
				<option value="157">Chengalpet</option>
				<option value="158">Kanchipuram</option>
				<option value="159">Gummudipoondy</option>
			</optgroup>
			<optgroup label="- Kerala -">
				<option value="1">Adoor</option>
				<option value="4">Alappuzha</option>
				<option value="20">Calicut</option>
				<option value="25">Cochin</option>
				<option value="36">Guruvayur</option>
				<option value="42">Idukki</option>
				<option value="48">Kannur</option>
				<option value="55">Kottayam</option>
				<option value="54">Kollam</option>
				<option value="60">Malappuram</option>
				<option value="72">Palakkad</option>
				<option value="73">Pathanamthitta</option>
				<option value="98">Thiruvananthapuram</option>
				<option value="97">Thiruvalla</option>
				<option value="99">Thrissur</option>
				<option value="113">Waynadu</option>
				<option value="338">Cochin MG Road</option>
				<option value="340">Vadakara</option>
			</optgroup>
			<optgroup label="- Delhi -">
				<option value="70">New Delhi</option>
				<option value="120">Meerut</option>
				<option value="119">Mathura</option>
			</optgroup>
			<optgroup label="- Uttar Pradesh -">
				<option value="2">Agra</option>
				<option value="5">Allahabad</option>
				<option value="15">Bareilly</option>
				<option value="32">Ghaziabad</option>
				<option value="34">Gorakhpur</option>
				<option value="57">Lucknow</option>
				<option value="71">Noida</option>
				<option value="108">Varanasi</option>
				<option value="49">Kanpur</option>
			</optgroup>
			<optgroup label="- Andhra Pradesh -">
				<option value="8">Anantapur</option>
				<option value="41">Hyderabad</option>
				<option value="112">Vishakhapatnam</option>
				<option value="47">Kakinada</option>
				<option value="100">Tirupati</option>
				<option value="110">Vijayawada</option>
				<option value="316">Hospet</option>
			</optgroup>
			<optgroup label="- West Bengal -">
				<option value="10">Asansol</option>
				<option value="14">Bardhaman</option>
				<option value="19">Bokaro</option>
				<option value="343">Durgapur</option>
				<option value="344">Howrah</option>
				<option value="53">Kolkata</option>
				<option value="342">Kankurgachi(Kolkata)</option>
				<option value="90">Siliguri</option>
			</optgroup>
				<optgroup label="- Maharashtra -">
				<option value="11">Aurangabad</option>
				<option value="63">Mumbai</option>
				<option value="80">Pune</option>
				<option value="67">Nagpur</option>
				<option value="89">Sangli</option>
				<option value="180">Akola</option>
				<option value="181">Chandrapur</option>
				<option value="182">Yavatmal</option>
				<option value="183">Wardha</option>
				<option value="184">Bhandara</option>
				<option value="187">Amaravathi</option>
				<option value="188">Dhule</option>
				<option value="189">Jalgao</option>
				<option value="190">Nanded</option>
				<option value="191">Koria</option>
				<option value="192">Raigadh</option>
				<option value="193">Rajnandgao</option>
				<option value="226">Hingoli Nagpur</option>
				<option value="227">Washim</option>
				<option value="228">Gadchiroli</option>
				<option value="229">Buldhana</option>
				<option value="230">Gondia</option>
				<option value="231">Parbani</option>
				<option value="235">Navi Mumbai</option>
				<option value="236">Thane</option>
				<option value="237">Bandra Suburban</option>
				<option value="258">Solapur</option>
				<option value="259">Sindhudurg</option>
				<option value="260">Satara</option>
				<option value="261">Ratnagiri</option>
				<option value="262">Parbhani</option>
				<option value="263">Osmanabad</option>
				<option value="264">Nashik</option>
				<option value="265">Nandurbar</option>
				<option value="266">Latur</option>
				<option value="267">Kolhapur</option>
				<option value="268">Jalna</option>
				<option value="269">Beed</option>
				<option value="270">Ahmednagar</option>
				<option value="324">Hingoli Pune</option>
				<option value="325">Jalgaon</option>
				<option value="326">Raigadh Pune</option>
			</optgroup>
			<optgroup label="- Chatisgarh -">
				<option value="232">Karwadha</option>
				<option value="233">Koria</option>
			</optgroup>
			<optgroup label="- Haryana &amp; Punjab -">
				<option value="23">Chandigarh</option>
				<option value="58">Ludhiana</option>
				<option value="31">Faridabad</option>
				<option value="35">Gurgaon</option>
				<option value="114">Hissar</option>
				<option value="115">Jind</option>
				<option value="116">Kaithal</option>
				<option value="117">Karnal</option>
				<option value="118">Kurukshtra</option>
				<option value="121">Panipat</option>
				<option value="122">Rohtak</option>
				<option value="123">Sonipat</option>
				<option value="124">YamunaNagar</option>
				<option value="203">Rewari</option>
				<option value="204">Bhadurgarh</option>
				<option value="205">Sirsa</option>
				<option value="206">Fatehabad</option>
				<option value="207">Bhivanai</option>
				<option value="208">Jhajhar</option>
				<option value="209">Haryana</option>
			</optgroup>
			<optgroup label="- Uttarakhand -">
				<option value="27">Dehradun</option>
				<option value="39">Haridwar</option>
				<option value="6">Almora</option>
				<option value="12">Bageshwar</option>
				<option value="21">Chamoli</option>
				<option value="22">Champawat</option>
				<option value="68">Nainital</option>
				<option value="75">Pauri Garhwal</option>
				<option value="77">Pithoragarh</option>

				<option value="87">Rudrapyag</option>
				<option value="93">Tehri Garwal</option>
				<option value="104">UddhamSingh Nagar</option>
				<option value="105">Uttarkashi</option>
			</optgroup></select><br><span id="cityspan" class="errortxt"></span>
		</div>
		<br clear="all"/>
		<div class="pfdivlt smalltxt fleft tlright">Contact Person's Name</div>
		<div class="pfdivrt smalltxt fleft">
			<input type="text" name="contactPerson" size="37" class="inputtext" tabindex="5"  value="<?=$varContactPerson?>" onBlur="funPerson();"/><br><span id="conpersonspan" class="errortxt"></span>
		</div>
		<br clear="all"/>
		<div class="pfdivlt smalltxt fleft tlright">Contact Number</div>
		<div class="pfdivrt smalltxt fleft">
			<input type="text" name="contactNumber" size="37" class="inputtext" tabindex="6" value="<?=$varContactNumber?>"  onBlur="funConNumber();" onkeypress="return allowNumeric(event);" maxlength="15"/><br><span id="connumberspan" class="errortxt"></span>
		</div>
		<br clear="all"/>
		<div class="pfdivlt smalltxt fleft tlright">Address</div>
		<div class="pfdivrt smalltxt fleft">
			<textarea name="address" rows="4" cols="35" class="inputtext" tabindex="7"/><?=$varAddress?></textarea>
		</div><br><span id="addressspan" class="errortxt"></span>
		<br clear="all"/>
		
		<div class="pfdivlt smalltxt fleft tlright">Collection Date</div>
		<!--<div class="pfdivrt smalltxt fleft">
			<input type="text" name="todate" readonly="" value="" style="width:120px" onclick="displayDatePicker('todate', document.doorStep.todate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		<span id="fromdatespan" class="errortxt"></span>
		</div>-->
		<div class="pfdivrt smalltxt fleft" >
			<div id="doorstepcalender">
			<input type="text" name="todate" id="todate" readonly="" value="" style="width:120px" >
			&nbsp;&nbsp;<img src="<?=$confValues['IMGSURL']?>/cal.gif" id="m_calendar" width="16" height="16" alt="Pick a date" onclick='popUpCalendar(this,doorStep.todate, "dd-mm-yyyy")'></a></div>
		<span id="fromdatespan" class="errortxt"></span>
		</div>
		
		<br clear="all"/>

		<div class="pfdivlt smalltxt fleft tlright">Collection Time</div>
		<div class="pfdivrt smalltxt fleft">
			<select class="inputtext" name="fromTime" onBlur="funFromTime();">
			<option value="0">From</option>
			<?php foreach($timeRangeFromAndToKey as $key=>$value){ ?>

			<option value="<?=$value;?>"><?=$key;?></option>
			<?php }?>
			</select>
			&nbsp;&nbsp;&nbsp;
			<select class="inputtext" name="toTime" onBlur="funToTime();">
			<option value="0">To</option>
			<?php foreach($timeRangeFromAndToKey as $key=>$value){ ?>
			<option value="<?=$value;?>"><?=$key;?></option>
			<?php }?>
			</select>
			<span id="fromspan" class="errortxt"></span>
		</div>
		<br clear="all"/>
		<input type="hidden" name="frmsrc" value="<?=$_REQUEST['src']?>">
		<div class="rpanelinner tlright padtb10"><input type="submit" class="button" tabindex="11" value="Submit" /></div>
		<?php }else if(($varLastInfo == 1)&&($varSubmit!='yes' )){ ?>
		<br clear="all"/>
		<div >
			You have already made a doorstep payment request. <br clear="all"/><br clear="all"/>
			Your Customer ID is <font color="#ff0000"><?php echo $varMatriId;?></font><br clear="all"/>
			Your Request No is  <font color="#ff0000"><?php echo $varRequestNo;?></font>
			<br clear="all"/><br clear="all"/>We will contact you soon regarding collection of payment

		</div>


		 <?php }?>
		 <br clear="all"/>
		 <div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
		 <br clear="all"/>

		<div class="normtxt1 clr bld">Other ways to make a request for doorstep payment</div><br clear="all" />
		<div class="normtxt1 clr">
			You can also call any of our offices and we will have a representative collect your payment. <br>
		</div>
		<div class="normtxt1 clr">
			Request by Phone
			You can also call 1-800-3000-2222 (Toll Free) for payment collection.
		</div>
		<br clear="all" />
		<? } ?>
	</form>
</div>
<?
UNSET($objCommon);
UNSET($objMailManager);
UNSET($objEPR);
include_once($varRootBasePath."/www/payment/paymentpagetracking.php");
?>