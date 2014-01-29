<?
#================================================================================================================
   # Author 		: Baskaran
   # Date			: 29-July-2008
   # Project		: MatrimonyProduct
   # Filename		: 
#================================================================================================================
   # Description	: 
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/conf/tblfields.cil14');
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
//Object initialization
$objSlaveDB			= new MemcacheDB;
$objMasterDB		= new MemcacheDB;

$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varGender			= $varGetCookieInfo["GENDER"];
$varMemberStatus 	= $varGetCookieInfo['PUBLISH'];
$varOppsiteId		= trim($_REQUEST['id']);
$varDivName			= trim($_REQUEST['divnname']);
$varPgNo			= trim($_REQUEST['curpgno']);
$varPageName		= trim($_REQUEST['pgename']);

//SETING MEMCACHE KEY
$varOppositeProfileMCKey= 'ProfileInfo_'.$varOppsiteId;

$varCondition		= " WHERE MatriId=".$objSlaveDB->doEscapeString($varOppsiteId,$objSlaveDB);
//$varCondition		= $varWhereClause." AND MatriId=".$objSlaveDB->doEscapeString($varOppsiteId,$objSlaveDB);
$varFields			= $arrMEMBERINFOfields;
$varMemberInfo		= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0, $varOppositeProfileMCKey);
$varOppsiteUName	= $varMemberInfo['User_Name'];	

if($sessMatriId == $varMemberInfo['MatriId'] ) { 
	
	if($varMemberInfo['Phone_Verified'] == 1 || $varMemberInfo['Phone_Verified'] == 3) {
		$varTableName	= $varTable['ASSUREDCONTACT'];
	} else {
		$varTableName	= $varTable['ASSUREDCONTACTBEFOREVALIDATION'];
	}
	//Get Phone No
	$argFields				= array('CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','VerificationSource');
	$argCondition			= " WHERE MatriId=".$objSlaveDB->doEscapeString($varMemberInfo['MatriId'],$objSlaveDB);
	$varAssuredContactResSet= $objSlaveDB->select($varTableName,$argFields,$argCondition,0);
	$varAssuredContact		= mysql_fetch_assoc($varAssuredContactResSet);
	$varSelPhone			= $varAssuredContact["PhoneNo1"];
	
	if(trim($varSelPhone) != ''){ ?>
	<div class="tlright vpdiv6 padtb3 fleft">Phone Number :</div>
	<div class="vpdiv6a padl310 fleft"><?=eregi_replace("~","-",eregi_replace("~~","~",$varSelPhone))?></div>
	<br clear="all">
	<?}?>

<? } elseif($varMemberInfo['Gender'] == $varGender && $sessMatriId != $varMemberInfo['MatriId']) {?>
	 Sorry, only members of the opposite gender can view the phone number of <?=$varOppsiteUName;?>
<?} elseif($sessMatriId != '' && $sessMatriId != $varMemberInfo['MatriId'] && ($varMemberInfo['Phone_Verified'] == 1 || $varMemberInfo['Phone_Verified'] == 3)) {
	$varCondition		= " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
	$varFields			= array('TotalPhoneNos','NumbersLeft');
	$varResult			= $objSlaveDB->select($varTable['PHONEPACKAGEDET'], $varFields, $varCondition, 0);
	$varPhoneInfo 		= mysql_fetch_assoc($varResult);

	//CHECK ALREADY VIEWED OR NOT
	$varCondition	= " WHERE Opposite_MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)." AND  MatriId = ".$objSlaveDB->doEscapeString($varMemberInfo['MatriId'],$objSlaveDB);
	$varTotRecords	= $objSlaveDB->numOfRecords($varTable['PHONEVIEWLIST'], $argPrimary='MatriId', $varCondition);
	
	if ($varTotRecords==0){
		if ($varPhoneInfo['NumbersLeft'] == 0 ) {
			echo 'Sorry, you have exhausted the number of phone numbers available as part of your subscription package. If you wish to view more phone numbers, please subscribe for the Additional Phone Number package. <a href="'.$confValues['SERVERURL'].'/payment/?act=additionalpayment" target="_blank" class="clr1">Click here</a>';exit;
		}
		$varViewCount	= $varPhoneInfo['NumbersLeft'] -1;
		$varPhoneViewed	= $varPhoneInfo['TotalPhoneNos']-$varViewCount;
	} else if($varTotRecords==1) {
		$varViewCount	= $varPhoneInfo['NumbersLeft'];
		$varPhoneViewed		= $varPhoneInfo['TotalPhoneNos']-$varPhoneInfo['NumbersLeft'];
	}

	$varFields 			= array('MatriId','Opposite_MatriId','Date_Viewed');
	$varFieldValues		= array($objMasterDB->doEscapeString($varMemberInfo['MatriId'],$objMasterDB),$objMasterDB->doEscapeString($sessMatriId,$objMasterDB),"NOW()");
	$varFormResult		= $objMasterDB->insertOnDuplicate($varTable['PHONEVIEWLIST'], $varFields, $varFieldValues, $varCondition);

	//Update phone package detail when record is not available in phoneview list
	$varFields			= array('NumbersLeft');
	$varFieldValues		= array($objMasterDB->doEscapeString($varViewCount,$objMasterDB));
	$varCondition		= " MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
	$varUpdate			= $objMasterDB->update($varTable['PHONEPACKAGEDET'], $varFields, $varFieldValues, $varCondition);

	//Get Phone No
	$argFields				= array('CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','VerificationSource');
	$argCondition			= " WHERE MatriId=".$objSlaveDB->doEscapeString($varMemberInfo['MatriId'],$objSlaveDB);
	$varAssuredContactResSet= $objSlaveDB->select($varTable['ASSUREDCONTACT'],$argFields,$argCondition,0);
	$varAssuredContact		= mysql_fetch_assoc($varAssuredContactResSet);

	if(trim($varAssuredContact["PhoneNo1"]) != ''){ 
		$respMessage	.= '<div class="fright" style="padding-right:50px;">Phone Numbers: Viewed '.$varPhoneViewed.'&nbsp;|&nbsp;Left &nbsp;'.$varViewCount.'</div><br clear="all"><br clear="all">';
		if(trim($varAssuredContact["VerificationSource"])==2) {
			$varPhoneNo = '';
			if(trim($varAssuredContact["MobileNo"])!='') {
				$respMessage	.= '<div class="tlright vpdiv6 padtb3 fleft">Mobile Number :</div><div class="vpdiv6a padl310 fleft">'.eregi_replace("~","",$varAssuredContact["CountryCode"]).'-'.eregi_replace("~","",$varAssuredContact["MobileNo"]).'</div>';
				$varPhoneNo	.= eregi_replace("~","",$varAssuredContact["CountryCode"]).'-'.eregi_replace("~","",$varAssuredContact["MobileNo"]).' , ';
			}
			if(trim($varAssuredContact["PhoneNo"])!='') {
				$respMessage	.= '<div class="tlright vpdiv6 padtb3 fleft">Landline Number :</div><div class="vpdiv6a padl310 fleft">'.eregi_replace("~","",$varAssuredContact["CountryCode"]).'-'.eregi_replace("~","",$varAssuredContact["AreaCode"]).'-'.eregi_replace("~","",$varAssuredContact["PhoneNo"]).'</div>';
				$varPhoneNo	.= eregi_replace("~","",$varAssuredContact["CountryCode"]).'-'.eregi_replace("~","",$varAssuredContact["AreaCode"]).'-'.eregi_replace("~","",$varAssuredContact["PhoneNo"]);
			}
		} else {
			$respMessage	.= '<div class="pad5 fleft brdr" style="width:100%">Phone Number :'.eregi_replace("~","-",eregi_replace("~~","~",$varAssuredContact["PhoneNo1"])).'</div>';
			$varPhoneNo .= eregi_replace("~","-",eregi_replace("~~","~",$varAssuredContact["PhoneNo1"]));
		}

		if($sessMatriId != $varMemberInfo['MatriId'] && $varPageName!='fp') {
			$respMessage	.= "<br clear='all'><br clear='all'><div id='phonecomplaindiv".$varPgNo."'></div><div style='padding-top:5px;height:20px;'><b>Not a valid phone number? Let us know.</b></div><span id='error".$varPgNo."' class='smalltxt errortxt'></span><div style='padding-top:2px;' class='fleft'><select id='complaint".$varPgNo."' name='complaint".$varPgNo."' class='inputtext' style='width:190px;'><option value=''>- Select reasons -&nbsp;</option><option value='1'>Phone number is not working</option><option value='2'>Phone number has changed</option><option value='3'>Member has got married</option></select></div><div style='padding:2px 0px 0px 10px;' class='fleft'><input type='button' value='submit' class='button' onClick='javascript:fnphonecomplaint(".$varPgNo.");'></div><br clear='all'><span id='phonethanks'></span><div class='opttxt clr'><b>Note:</b> Kindly use the above drop down only if the phone number is not working, phone number has changed or if the member has got married. Please do not report if the phone is ringing or is unanswered. </div><input type='hidden' name='problemid".$varPgNo."' value=".$varMemberInfo['MatriId']."><input type='hidden' name='phonedetail".$varPgNo."' value='".$varPhoneNo."'><input type='hidden' name='senderid".$varPgNo."' value=".$sessMatriId."><input type='hidden' name='phnediv".$varPgNo."' value=".$varDivName.">";
		}

		echo $respMessage;
	}?>
	<br clear="all">
	<?
}

$objSlaveDB->dbClose();
$objMasterDB->dbClose();

unset($objSlaveDB);
unset($objMasterDB);
?>
