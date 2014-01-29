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
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
//Object initialization
$objMasterDB		= new MemcacheDB;
$varMasterConn		= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

$sessMatriId		= $varGetCookieInfo['MATRIID'];
$varGender			= $varGetCookieInfo["GENDER"];
$varMemberStatus 	= $varGetCookieInfo['PUBLISH'];

$varPhoneStatus 	= $_REQUEST['phnval'];

//SETING MEMCACHE KEY
$varOwnProfileMCKey	= 'ProfileInfo_'.$sessMatriId;
$varCondition		= $varWhereClause." AND MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);

if($varPhoneStatus==1) { //hide phone no
	$varFields 		= array('Phone_Protected','Date_Updated');
	$varFieldsValues= array(1,"NOW()");
	$varUpdateId	= $objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);
	$varMessage		= "Your phone number is hidden and will not be visible to paid members.";
} else if($varPhoneStatus==2) { //unhide phone no
	$varFields 		= array('Phone_Protected','Date_Updated');
	$varFieldsValues= array(0,"NOW()");
	$varUpdateId	= $objMasterDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition,$varOwnProfileMCKey);
	$varMessage		= "Your phone number is now open and will be visible to paid members.";
} else {
	$varMessage		= "Please check internet connetion";
}
echo "<div class='fright tlright'><img src='".$confValues['IMGSURL']."/close.gif' class='pntr' onclick='phhidelnkswap(".$varPhoneStatus.")'></div><br clear='all'>".$varMessage."<br clear='all'><div class='fright'><input type='button' class='button' value='Close' onClick='phhidelnkswap(".$varPhoneStatus.")'></div>";

$objMasterDB->dbClose();
unset($objMasterDB);
?>
