<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: generateHoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/horoscope.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsHoroscope.php");

//SESSION VARIABLES

$sessMatriId	= 'YDV100377';//$_REQUEST['Id'] ? $_REQUEST['Id'] : $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessGender		= $varGetCookieInfo["GENDER"];
//Object initialization
$objSlaveDB			= new Horoscope;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

$varAstroURL = $objSlaveDB->generateHoroscope($sessMatriId,$varLanguage);
//exit;
	echo '<script> var astrourl="'.$confValues["IMAGEURL"].'/horoscope/sendhorodetailsTest.php?xdata='.$varAstroURL.'";';
	echo 'function detectPopupBlocker() {';
	echo 'var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0,location=no");';
	echo 'if (!myTest) {';
	echo 'alert("A popup blocker was detected.");';
	echo '} else {';
	echo 'myTest.close();';
	echo '} }';
	echo 'detectPopupBlocker();';
	echo " var mywin002=window.open(astrourl,'mywindow1','location=0,status=0,scrollbars=0,toolbar=0,menubar=0,resizable=0,width=720,height=600'); ";
	echo " mywin002.moveTo(200,200); </script".">";
			//end new code Mano
	ob_start();
	?>
		<div class="vc1 fleft">
		<div class="innertabbr1 fleft"></div>
		<div class="fleft innertabbg">
			</div>
	<div class="fleft innertabbr1"></div>
	</div>