<?php
/* ______________________________________________________________________________________________________________________*/
/* Author		: Ashokkumar, Dhanapal
/* Filename		: execute.php
/* Date			: 25 June 2009
/* Project      : Community Product Matrimony
/* ______________________________________________________________________________________________________________________*/
/* Description	: creates caste domain respective config files
/* ______________________________________________________________________________________________________________________*/

/* Error Reporting On | Off */
ini_set('display_errors','On');

/* Doc Path Setting */
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath	= '/home/product/community';

/* Include Files */
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath.'/conf/domainlist.inc');
include_once($varRootBasePath.'/conf/vars.inc');

/* Create Object To Connect Database */
$objDB = new DB;
$objDB->dbConnect('M','communityproduct');

/* Variable Declaration */
$varDomainId	='';

// 68 caste domain config $varCondition	= " WHERE DomainKey IN (260,261,254,267,20,240,269,286,270,40,291,242,245,287,271,272,63,299,288,251,319,241,273,322,283,274,255,248,100,105,252,253,327,275,243,130,263,121,264,258,292,289,246,337,256,284,257,268,247,276,259,244,341,277,265,278,342,280,347,249,349,285,224,231,354,233,234,266)";
$varCondition	= " WHERE DomainKey IN (137,159)";
$varFields 		= array('Id','DomainName','CategoryId','DomainKey','MatriIdPrefix','DomainFolder');
$varExecute		= $objDB->select('domaininfo',$varFields,$varCondition,0);

while($varDomainInfo	= mysql_fetch_array($varExecute)) {

	/* Create Domain Specific Folder, Config Files */
	$varDomainId		= '';
	$varDomainKey		= '';
	$varDomainFolder	= '';
	$varDomainConf		= '';
	$varFileHandle		= '';
	$varDomainId		= $varDomainInfo['Id'];
	$varDomainKey		= $varDomainInfo['DomainKey'];
	$varDomainFolder	= $varDomainInfo['DomainFolder'];
	$varDomainListFolder= $varRootBasePath."/domainslist_2";
	$varDomainConf		= $varDomainListFolder."/".$varDomainFolder."/conf.inc";
	echo $varDomainListFolder."/".$varDomainFolder;

	if (!is_dir($varDomainListFolder."/".$varDomainFolder)) {
		mkdir($varDomainListFolder."/".$varDomainFolder, 0777, true)  or die("can't create folder");
	}
	$varFileHandle		= fopen($varDomainConf, 'w+') or die("can't open file");

	/* Method Calls */
	$varFeaturesList	= getDomainFeature($objDB,$varDomainId,$varRootBasePath);
	$varSubCasteInfo	= subCasteInfo($objDB,$varDomainKey,$varRootBasePath);
	$varMotherTongueInfo= getMotherTongueArray($objDB,$varDomainKey,$varRootBasePath);
	//$varGothramInfo   = gothramInfo($objDB,$varDomainKey,$varRootBasePath);
	//$varStarInfo		= starInfo($objDB,$varDomainKey,$varRootBasePath);
	//$varRaasiInfo		= raasiInfo($objDB,$varDomainKey,$varRootBasePath);

	/** Writing into File is starts **/

    /* PHP <? Tag opening */
	$varDomainConf	= "<?php\n";

	/* Author Comment Inclusion */
	$varDomainConf .= "/* ______________________________________________________________________________________________________________________*/\n";
	$varDomainConf .= "/* Author 		: Ashok kumar \n";
	$varDomainConf .= "/* Date	        : ".date('d M Y')."\n";
	$varDomainConf .= "/* Project		: Community Product Matrimony \n";
	$varDomainConf .= "/* Filename		: $varDomainFolder/conf.inc \n";
	$varDomainConf .= "/* ______________________________________________________________________________________________________________________*/\n";
	$varDomainConf .= "/* Description  : Auto generated community (or) domain config file : $varDomainFolder domain \n";
	$varDomainConf .= "/* ______________________________________________________________________________________________________________________*/\n";
	$varDomainConf	.= "\n";

	/* Domain Segement & Discount Setting */
	//$varDomainConf	.= "/* Segment & Discount */ \n";
	//$varDomainConf	.= "$casteTag	= 'A1'; // Segement \n";
	//$varDomainConf	.= "$DiscountTag = '25'; // Discount in % \n";
	//$varDomainConf	.= "\n";

	/* Male & Female Age Setting */
	//$varDomainConf	.= "/* Male Age Setting */ \n";
	//$varDomainConf	.= "\n";
	//$varDomainConf	.= "/* Female Age Setting */ \n";
	//$varDomainConf	.= "\n";

	/* Domain Features Settings */
	$varDomainConf	.= $varFeaturesList;
	$varDomainConf	.= "\n";

    /* Subcaste Array */
	$varDomainConf	.= "/* Subcaste Array */";
	$varDomainConf	.= "\n";
	$varDomainConf	.= '$arrDomainSubCaste	= array();';
	$varDomainConf	.= "\n";
	if (trim($varSubCasteInfo[0])=='') {
		$varDomainConf	.= '$arrSubcasteList	= array(); // e.g. for registration usage';
	} else {
		$varDomainConf	.= $varSubCasteInfo[0];
		$varDomainConf	.= "\n";
		$varDomainConf	.= '$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don\'t wish to specify",9999=>"Don\'t know my sub-caste"); // e.g. for registration usage';
	}
	$varDomainConf	.= "\n";
	$varDomainConf	.= '$arrDomainSubCaste[9998] = \'Not Specified\';//Don\'t wish to specify';
	$varDomainConf	.= "\n";
	$varDomainConf	.= 'unset($arrDomainSubCaste[9999]);//Don\'t know my sub-caste';
	$varDomainConf	.= "\n";
	$varDomainConf	.= 'unset($arrDomainSubCaste['.$varSubCasteInfo[1].']);//Others';
	$varDomainConf	.= "\n";
	$varDomainConf	.= '$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values';
	$varDomainConf	.= "\n";
	$varDomainConf	.= "\n";

    /* Mother Tongue Display Order Array */
	$varDomainConf	.= "/* Mother Tongue Array */";
	$varDomainConf	.= "\n";
	$varDomainConf	.= '$arrMTDisplayOrder	= array();';
	$varDomainConf	.= "\n";
	if (trim($varMotherTongueInfo)!='') {
		$varDomainConf	.= $varMotherTongueInfo;
		$varDomainConf	.= "\n";
	}
	$varDomainConf	.= 'if(!is_array($arrMotherTongueList)) {'."\n";
	$varDomainConf	.= '  $arrMotherTongueList = array();'."\n";
	$varDomainConf	.= '}'."\n";
	$varDomainConf	.= '$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;';
	$varDomainConf	.= "\n";

	/* Gothram */
	//$varDomainConf	.= $varGothramInfo;
	//$varDomainConf	.= "\n";

	/* Star */
	//$varDomainConf	.= $varStarInfo;
	//$varDomainConf	.= "\n";

	/* Raasi */
	//$varDomainConf	.= $varRaasiInfo;
	//$varDomainConf	.= "\n\n";

    /* PHP <? Tag closing */
	$varDomainConf	.= "\n?>";

	fwrite($varFileHandle, $varDomainConf);
	fclose($varFileHandle);
}

/* Obj DB Connection Closed */
$objDB->dbClose();

/* ________________________________________________________________________________________________________________________ */
/* ** Functions ** */

function getDomainFeature($objDB,$varDomainId,$varRootBasePath) {

	/* Select Domin Feature Information From Table */
	$varCondition		= " WHERE Id=".$varDomainId;
	$varFields 			= array('DomainKey','DomainFolder','Religion','ReligionTxt','ReligionMultiple','Caste','CasteTxt','CasteMultiple','Subcaste','SubcasteTxt','SubcasteMultiple','Gothram','GothramTxt','GothramMultiple','Star','Raasi','Dosham','Horoscope','RPSuccessStory','RPZedo','RPAdsense','Segment','Discount','MaritalStatusLabel','ReligionLabel','CasteLabel','SubcasteLabel','GothramLabel','MotherTongueLabel','StarLabel','RaasiLabel','HoroscopeLabel','DoshamLabel','MaleStartAge','MaleEndAge','FemaleStartAge','FemaleEndAge','MaritalStatus','MaritalStatusTxt','MaritalStatusMultiple');
	$varExecute			= $objDB->select('domaininfo',$varFields,$varCondition,0);
	$varGetDomainInfo	= mysql_fetch_array($varExecute);

	$varGetDomainFolder			= $varGetDomainInfo["DomainFolder"];
	$varGetDomainKey			= $varGetDomainInfo["DomainKey"];
	$varGetDomainReligion		= $varGetDomainInfo["Religion"];
	$varGetDomainCaste			= $varGetDomainInfo["Caste"];
	$varGetDomainSubcaste		= $varGetDomainInfo["Subcaste"];
	$varGetDomainSubcasteTxt	= $varGetDomainInfo["SubcasteTxt"];
	$varGetDomainGothram		= $varGetDomainInfo["Gothram"];
	$varGetDomainGothramTxt		= $varGetDomainInfo["GothramTxt"];
	$varGetDomainStar			= $varGetDomainInfo["Star"];
	$varGetDomainRaasi			= $varGetDomainInfo["Raasi"];
	$varGetDomainDosham			= $varGetDomainInfo["Dosham"];
	$varGetDomainHoroscope		= $varGetDomainInfo["Horoscope"];
	$varGetDomainRPSuccessStory	= $varGetDomainInfo["RPSuccessStory"];
	$varGetDomainRPZedo			= $varGetDomainInfo["RPZedo"];
	$varGetDomainRPAdsense		= $varGetDomainInfo["RPAdsense"];
	$varGetDomainSegment		= $varGetDomainInfo["Segment"];
	$varGetDomainDiscount		= $varGetDomainInfo["Discount"];

	/* Create Domain Specific Config File */
	#set permission to domainlist folder
	/*$varFeatureList			= '';
	$varDomainListFolder	= $varRootBasePath."/domainslistbak";
	if (!is_dir($varDomainListFolder."/".$varGetDomainFolder)) {
		mkdir($varDomainListFolder."/".$varGetDomainFolder, 0777)  or die("can't create folder");
		chmod($varDomainListFolder,0777);
	}*/

	/* Domain Segement & Discount Setting */
	$varFeatureList	.= "/* Segment & Discount */ \n";
	$varFeatureList	.= '$casteTag	= \''.trim($varGetDomainSegment).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$DiscountTag = '.trim($varGetDomainDiscount).'; // Discount in %';
	$varFeatureList	.= "\n\n";

	/* Male & Female Age Setting */
	$varFeatureList	.= "/* Male Age Setting */ \n";
	$varFeatureList	.= "\n";
	$varFeatureList	.= "/* Female Age Setting */ \n";
	$varFeatureList	.= "\n";

	/* Features List Settings */
	$varFeatureList	.= "/* Features Setting */ \n";
	$varFeatureList	.= '$_FeatureMaritalStatus	= 1;';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureReligion	= '.$varGetDomainReligion.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureReligionTxt= 0;';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureCaste		= '.$varGetDomainCaste.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureCasteTxt	= 0;';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureSubcaste	= '.$varGetDomainSubcaste.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureSubcasteTxt= '.$varGetDomainSubcasteTxt.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureGothram	= '.$varGetDomainGothram.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureGothramTxt	= '.$varGetDomainGothramTxt.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureStar		= '.$varGetDomainStar.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureRaasi		= '.$varGetDomainRaasi.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureHoroscope	= '.$varGetDomainHoroscope.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_FeatureDosham		= '.$varGetDomainDosham.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";

	/* Right Panel Features List Settings */
	$varFeatureList	.= '/* Right Panel Feature */';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_RPSuccessStory	= '.$varGetDomainRPSuccessStory.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_RPZedoPanel		= '.$varGetDomainRPZedo.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_RPGoogleAdsense	= '.$varGetDomainRPAdsense.';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";

	/* Label List Settings */
	$varFeatureList	.= '/* Label Name Settings */';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelMaritalStatus	= \''.trim($varGetDomainInfo["MaritalStatusLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelReligion	= \''.trim($varGetDomainInfo["ReligionLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelCaste		= \''.trim($varGetDomainInfo["CasteLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelSubcaste	= \''.trim($varGetDomainInfo["SubcasteLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelGothram	= \''.trim($varGetDomainInfo["GothramLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelMotherTongue		= \''.trim($varGetDomainInfo["MotherTongueLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelStar		= \''.trim($varGetDomainInfo["StarLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelRaasi		= \''.trim($varGetDomainInfo["RaasiLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelHoroscope	= \''.trim($varGetDomainInfo["HoroscopeLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= '$_LabelDosham		= \''.trim($varGetDomainInfo["DoshamLabel"]).'\';';
	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";

	$varFeatureList	.= '/* Arrays */';
	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";
	$varFeatureList	.= '/* Religion Array */';

	// Religion Array Generation
	if ($varGetDomainReligion == 1){
		$varRegCondition		= " WHERE DomainKey=$varGetDomainKey";
		$varRegFields 			= array('DomainKey','ReligionId');
		$varRegExecute			= $objDB->select('domainreligionmapinfo',$varRegFields,$varRegCondition,0);

		$varFeatureList	.= "\n";
		$varFeatureList	.= '$arrReligionList	= array(';

		while ($varRegGetDomainInfo	= mysql_fetch_array($varRegExecute)) {
			$varRegGetDomainInfo['DomainKey'];
			$varRegGetDomainInfo['ReligionId'];

			$varReg1Condition		= " WHERE ReligionId=".$varRegGetDomainInfo['ReligionId'];
			$varReg1Fields 			= array('ReligionName','ReligionId');
			$varReg1Execute			= $objDB->select('domainreligioninfo',$varReg1Fields,$varReg1Condition,0);
			$varReg1GetDomainInfo	= mysql_fetch_array($varReg1Execute);

			$VarReligionFrameArray .= $varRegGetDomainInfo['ReligionId']."=>'".$varReg1GetDomainInfo['ReligionName']."',";
			echo $VarReligionFrameArray;
		}
		$VarReligionFrameArray = substr($VarReligionFrameArray,0,-1);
		$varFeatureList	.= $VarReligionFrameArray.');';
	}

	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";

	$varFeatureList	.= '/* Caste Array */';

	// Caste Array Generation
	if ($varGetDomainCaste == 1){
		$varCasteCondition		= " WHERE DomainKey=$varGetDomainKey";
		$varCasteFields 			= array('DomainKey','CasteId');
		$varCasteExecute			= $objDB->select('domaincasteinfo',$varCasteFields,$varCasteCondition,0);
		//$varCasteRowCount			= $objDB->numOfRecords('domaincasteinfo', $argPrimary='Id', $varCasteCondition);

		$varFeatureList	.= "\n";
		$varFeatureList	.= '$arrCasteList	= array(';

		while ($varCasteGetDomainInfo	= mysql_fetch_array($varCasteExecute)) {
			$varCasteGetDomainInfo['DomainKey'];
			$varCasteGetDomainInfo['CasteId'];

			$varCaste1Condition		= " WHERE CasteId=".$varCasteGetDomainInfo['CasteId'];
			$varCaste1Fields 			= array('CasteName','CasteId');
			$varCaste1Execute			= $objDB->select('casteinfo',$varCaste1Fields,$varCaste1Condition,0);
			$varCaste1GetDomainInfo	= mysql_fetch_array($varCaste1Execute);

			$VarCasteFrameArray .= $varCaste1GetDomainInfo['CasteId']."=>'".$varCaste1GetDomainInfo['CasteName']."',";
		}
		$VarCasteFrameArray = substr($VarCasteFrameArray,0,-1);
		$varFeatureList	.= $VarCasteFrameArray.');';
	}

	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";

	/* Religion wise Caste map Array Frame */
	//$varFeatureList	.= '/* Religion Wise Caste Map Array */';
	/*if ($varGetDomainReligion == 1){
		$varReg2Condition		= " WHERE DomainKey=$varGetDomainKey";
		$varReg2Fields 			= array('DomainKey','ReligionId');
		$varReg2Execute			= $objDB->select('domainreligionmapinfo',$varReg2Fields,$varReg2Condition,0);

		$varFeatureList	.= "\n";
		$varFeatureList	.= '$arrReligionCasteMap	= array(';

		while ($varReg2GetDomainInfo	= mysql_fetch_array($varReg2Execute)) {
			$varReg2GetDomainInfo['DomainKey'];
			$varReg2GetDomainInfo['ReligionId'];

			$VarReligionCasteFrameArray .= $varReg2GetDomainInfo['ReligionId']."=>array(".$VarCasteFrameArray."),";
		}
		$VarReligionCasteFrameArray = substr($VarReligionCasteFrameArray,0,-1);
		$varFeatureList	.= $VarReligionCasteFrameArray.');';
	}

	$varFeatureList	.= "\n";
	$varFeatureList	.= "\n";*/
	/* Religion wise Caste map Array Frame - Ends */

	$varFeatureList	.= '/* Gothram Array */';
	$varFeatureList	.= "\n";
	if (trim($varGetDomainInfo["GothramTxt"])==1) {
		$varFeatureList	.= '$arrGothramList = array();';
	} elseif (trim($varGetDomainInfo["GothramTxt"])==0) {
		$varFeatureList	.= '/** Derive from vars.inc **/';
	}
	$varFeatureList	.= "\n";

	return $varFeatureList;
}

function subCasteInfo($objDB,$varDomainKey,$varRootBasePath) {

    $varGetOtherIndex = 9997;
	//GENERATE SUBCASTE LIST
	$varCondition		= " WHERE DomainKey=".$varDomainKey." AND (SubcasteId != 9998 AND SubcasteId != 9999) order by SubcasteName";
	$varFields 			= array('SubcasteId','SubcasteName');
	$varExecute			= $objDB->select('domainsubcasteinfo',$varFields,$varCondition,0);
	$varSubcasteCount	= $objDB->numOfRecords('domainsubcasteinfo', $argPrimary='Id', $varCondition);
	$varSubCasteList	= '';

	if ($varSubcasteCount > 0) {
		$arrSubCasteList	= '$arrDomainSubCaste	= array(';

		while($varSubCasteInfo	= mysql_fetch_array($varExecute)){

			$varSubCasteId		= $varSubCasteInfo["SubcasteId"];
			$varSubCasteName	= $varSubCasteInfo["SubcasteName"];
			if ($varSubCasteInfo["SubcasteName"]=='Others') {
				//$varGetOtherIndex = $varSubCasteInfo["SubcasteId"];
				$varGetOtherIndex = 9997;
				continue;
			}
			$arrSubCasteList	.= $varSubCasteId. "=>\"".stripslashes($varSubCasteName)."\",";

		}//foreach
		$arrSubCasteList	.= $varGetOtherIndex. "=>\"Others\",";
		$varTrimSubCasteList	= trim(chop($arrSubCasteList,','));
		$varSubCasteList		= $varTrimSubCasteList.');';
	}
	$arrSubCasteInfo[0] = $varSubCasteList;
	$arrSubCasteInfo[1] = $varGetOtherIndex;
	return $arrSubCasteInfo;
}//subCasteInfo



function raasiInfo($objDB,$varDomainKey,$varRootBasePath) {

	//GENERATE RAASI LIST
	$varCondition		= " WHERE DomainKey=".$varDomainKey;
	$varFields 			= array('RaasiId','RaasiName');
	$varExecute			= $objDB->select('domainraasiinfo',$varFields,$varCondition,0);
	$varRaasiCount		= $objDB->numOfRecords('domainraasiinfo', $argPrimary='Id', $varCondition);
	$varRaasiList		= '';

	if ($varRaasiCount >0) {
		$arrRaasiList	= '$arrRaasiList	= array(';

		while($varRaasiInfo	= mysql_fetch_array($varExecute)){

			$varRaasiId		= $varRaasiInfo["RaasiId"];
			$varRaasiName	= $varRaasiInfo["RaasiName"];
			$arrRaasiList	.= $varRaasiId. "=>\"".stripslashes($varRaasiName)."\",";

		}//foreach

		$varTrimRaasiList	= trim(chop($arrRaasiList,','));
		$varRaasiList		= $varTrimRaasiList.');';
	}
	return $varRaasiList;
}

function starInfo($objDB,$varDomainKey,$varRootBasePath) {
		//GENERATE STAR LIST
	$varCondition	= " WHERE DomainKey=".$varDomainKey;
	$varFields 		= array('StarId','StarName');
	$varExecute		= $objDB->select('domainstarinfo',$varFields,$varCondition,0);
	$varStarCount	= $objDB->numOfRecords('domainstarinfo', $argPrimary='Id', $varCondition);
	$varStarList	= '';

	echo '<br>Count=='.$varStarCount;
	if ($varStarCount > 0) {

		$arrStarList	= '$arrStar	= array(';

		while($varStarInfo	= mysql_fetch_array($varExecute)){

			$varStarId		= $varStarInfo["StarId"];
			$varStarName	= $varStarInfo["StarName"];
			$arrStarList	.= $varStarId. "=>\"".stripslashes($varStarName)."\",";

		}//foreach

		$varTrimStarList	= trim(chop($arrStarList,','));
		$varStarList		= $varTrimStarList.');';
	}
	return $varStarList;
}

function gothramInfo($objDB,$varDomainKey,$varRootBasePath) {

	//GENERATE GOTHRAM LIST
	$varCondition		= " WHERE DomainKey=".$varDomainKey;
	$varFields 			= array('GothramId','GothramName');
	$varExecute			= $objDB->select('domaingothraminfo',$varFields,$varCondition,0);
	$varGothramCount	= $objDB->numOfRecords('domaingothraminfo', $argPrimary='Id', $varCondition);
	$varGothramList		= '';

	echo '<br>Count=='.$varGothramCount;

	if ($varGothramCount > 0){

		$arrGothramList	= '$arrGothramList	= array(';

		while($varGothramInfo	= mysql_fetch_array($varExecute)){

			$varGothramId		= $varGothramInfo["GothramId"];
			$varGothramName	= $varGothramInfo["GothramName"];
			$arrGothramList	.= $varGothramId. "=>\"".stripslashes($varGothramName)."\",";

		}//foreach

		$varTrimGothramList	= trim(chop($arrGothramList,','));
		$varGothramList = $varTrimGothramList.');';
	}
	return $varGothramList;
}//gothramInfo

function getMotherTongueArray($objDB,$varDomainKey,$varRootBasePath) {

	global $arrMotherTongueList;

	//GENERATE GOTHRAM LIST
	$varCondition		= " WHERE DomainKey=".$varDomainKey;
	$varFields 			= array('MotherTongueId');
	$varExecute			= $objDB->select('domainmothertongueinfo',$varFields,$varCondition,0);
	$varMTDOCount	    = $objDB->numOfRecords('domainmothertongueinfo', $argPrimary='Id', $varCondition);
	$varMTDOList		= '';

	echo '<br>Count=='.$varMTDOCount;

	if ($varMTDOCount > 0){

		$varMTDOList	= '$arrMTDisplayOrder = array(';

		while($varGothramInfo	= mysql_fetch_array($varExecute)){

			$varMotherTongueId	= $varGothramInfo["MotherTongueId"];
			$varMotherTongueValue	= $arrMotherTongueList[$varMotherTongueId];
			$varMTDOList	.= $varMotherTongueId. "=>\"".stripslashes($varMotherTongueValue)."\",";

		}//foreach

		$varTrimMTDOList	= trim(chop($varMTDOList,','));
		$varMTDOList = $varTrimMTDOList.');';
	}
	return $varMTDOList;
}//gothramInfo

?>