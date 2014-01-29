<?php
/****************************************************************************************************
File	: deletehoroscope.php
Author	: Senthilnathan
********************************************************************************************************/
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/basefunctions.cil14");

if($_REQUEST['myact'] === 'HWKASGL23' && $sessMatriId != '') {

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey		= 'ProfileInfo_'.$sessMatriId;
	$varDeleteHoroscopeMsg	= '';

	if ($varHoroscopeURL != '') {
		if($varHoroscopeStatus == '0' || $varHoroscopeStatus == '2') {
			$varTempPath	= $varRootBasePath."/www/pending-horoscopes/".$arrDomainInfo[$varDomain][2].'/';
		} else {
			$varTempPath	= $varRootBasePath."/www/membershoroscope/".$arrDomainInfo[$varDomain][2].'/'.$sessMatriId{3}."/".$sessMatriId{4}."/";
		}
		
		if(file_exists($varTempPath.$varHoroscopeURL)) {
			unlink($varTempPath.$varHoroscopeURL);
		}

		$varCondition		= "  MatriId = '".$sessMatriId."'";
		$varFields			= array('HoroscopeURL','HoroscopeDescription','HoroscopeStatus','Horoscope_Protected','Horoscope_Protected_Password','Horoscope_Date_Updated');
		$varFieldsValues 	= array("''","''",'0','0',"''","NOW()");

		$varMIFields		= array('Horoscope_Available','Horoscope_Protected','Date_Updated');
		$varMIFieldsValues 	= array('0','0',"NOW()");
		
		$varUpdate			= $objMasterDB->update($varTable['MEMBERPHOTOINFO'], $varFields, $varFieldsValues, $varCondition);
		$varUpdate			= $objMasterDB->update($varTable['MEMBERINFO'], $varMIFields, $varMIFieldsValues, $varCondition, $varOwnProfileMCKey);
		
		//MEMBERTOOL LOGIN
		$varMatriId = $sessMatriId;
		$varType  = 3;
		$varField = 0;

		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
		$varnewCmd = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';

		escapeexec($varnewCmd,$varlogFile);

		
		if ($varUpdate) {
			$varDeleteHoroscopeMsg	=   "Horoscope has been deleted successfully from your profile.";

		} else {
			$varDeleteHoroscopeMsg	=	"Could not process your request at the moment. Please try after some time.";
		}
	} else {
		$varDeleteHoroscopeMsg		= "Could not find Horoscope";
	}
	if ($varDeleteHoroscopeMsg !='') { 
		echo '<center><div class="alerttxt" style="padding-top:10px;padding-bottom:0px;">'.$varDeleteHoroscopeMsg.'</div></center>';
		$varHoroscopeURL	= '';
		$varHoroscopeStatus	= '';
	}//if
}
?>