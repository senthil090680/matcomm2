<?php
/****************************************************************************************************
File	: videodelete.php
Author	: Senthilnathan
********************************************************************************************************/
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
$varMatriId		= $varGetCookieInfo['MATRIID'];

if($_POST['frmDeleteHoroscopeSubmit'] == 'yes' && $varMatriId != '')
{
	//Object initialization
	$objMasterDB	= new MemcacheDB;

	//CONNECTION DECLARATION
	$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey= 'ProfileInfo_'.$varMatriId;

	$varCondition		= " WHERE MatriId = ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
	$varFields			= array('HoroscopeURL','HoroscopeStatus');
	$varResult			= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition,0);
	$varMemberinfo	 	= mysql_fetch_assoc($varResult);
	$varHRAvailable		= $varMemberinfo['HoroscopeURL'];
	$varHRStatus		= $varMemberinfo['HoroscopeStatus'];

	if ($varHRAvailable != '') {
		if($varHRStatus == 0 || $varHRStatus == 2) {
			$varTempPath	= $varRootBasePath."/www/pending-horoscopes/".$arrDomainInfo[$varDomain][2].'/';
		} else {
			$varTempPath	= $varRootBasePath."/www/membershoroscope/".$arrDomainInfo[$varDomain][2].'/'.$varMatriId{3}."/".$varMatriId{4}."/";
		}
		
		if(file_exists($varTempPath.$varHRAvailable)) {
			unlink($varTempPath.$varHRAvailable);
		}

		$varCondition		= "  MatriId =  ".$objMasterDB->doEscapeString($varMatriId,$objMasterDB);
		if($varHRStatus == 1 || $varHRStatus == 0) {
			$varFields			= array('HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Protected','Horoscope_Protected_Password','Horoscope_Date_Updated');
			$varFieldsValues 	= array("''","''",0,0,"''","NOW()");
			$varMIFields		= array('Horoscope_Available','Horoscope_Protected','Date_Updated');
			$varMIFieldsValues 	= array(0,0,"NOW()");
		} else if($varHRStatus == 2) {
			$varFields			= array('HoroscopeStatus','Horoscope_Date_Updated');
			$varFieldsValues 	= array(1,"NOW()");

			$varMIFields		= array('Horoscope_Available','Date_Updated');
			$varMIFieldsValues 	= array(1,"NOW()");
		}
		
		$varUpdate			= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldsValues, $varCondition);
		$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varMIFields, $varMIFieldsValues, $varCondition, $varOwnProfileMCKey);

		if ($varUpdate) {
			$varMessage	=   "Horoscope has been deleted successfully from your profile.";

		} else {
			$varMessage	=	"Could not process your request at the moment. Please try after some time.";
		}
	} else {
		$varMessage		= "Could not find Horoscope";
	}
	echo '<link rel="stylesheet"	href="'.$confValues['CSSPATH'].'/global-style.css"><div><div style="padding: 0px 20px 0px 20px;"><div style="padding:5px;" class="mediumtxt boldtxt clr3">Delete Photo</div> <div style="padding:10px;" class="divborder">'.$varMessage.'</div></div>';exit;

	//UNSET OBJ
	$objMasterDB->dbClose();
	unset($objMasterDB);
}
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/global-style.css">
<div id="block">
	<form name="frmDeleteConfirmation" method="post" >
	<input type = "hidden" name="frmDeleteHoroscopeSubmit" value="yes">
		<div style="padding-left:10px;width:410px;">
			<div ><font class="mediumtxt boldtxt clr3">Delete Horoscope</font></div>
				<div class="divborder fleft" style="width:407px;">
					<div>
						<div class="fleft" style="padding-top:15px;padding-left:15px;"><font class="smalltxt">Are You Sure You Want To Delete This Horoscope ?</font>&nbsp;&nbsp;&nbsp;
							<input type="submit" name="Yes" value="Yes" class="button">
							<input type="button" name="No" value="No" onclick="window.parent.closeIframe('iframeicon','icondiv');"  class="button" >
						</div><br clear="all">
						<div class="bheight"></div>
					</div>
				</div>
			</div>
		 </div>
	</form>
</div>
