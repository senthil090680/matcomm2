<?php
/***************************************************************************
 FILENAME			: smartquery.php  
 AUTHOR			    : SARAVANNAN, ANDAL.V	
 Date				: 02-Jan-2008
 DESCRIPTION		: This includes query functions to display search results.
***************************************************************************/

function genQueryPerferenceMatch($id,$gender,$partnerprefcookievalue) {
	
	global $COOKIEINFO,$DOMAINTABLE,$MERGETABLE,$DBCONIP,$DBINFO,$DBNAME,$TABLE;
	if($partnerprefcookievalue==''){
		$memberid		= $COOKIEINFO['LOGININFO']['MEMBERID'];
		$mempartinfo	= preg_replace('/~/',',',$_COOKIE['PP']);
		$gender			= $COOKIEINFO['LOGININFO']['GENDER'];
	}else{
		$memberid		= $id;
		$mempartinfo	= preg_replace('/~/',',',$partnerprefcookievalue);
	}
		
	if($mempartinfo != ''){
	$ppValues	= split('\|', $mempartinfo);
	$ageValues	= split(',', $ppValues[0]); 
	$htValues	= split(',', $ppValues[1]);

	$ppInfo['Gender']				= $gender; 	
	$ppInfo['StAge']				= $ageValues[0];
	$ppInfo['EndAge']				= $ageValues[1];	
	$ppInfo['StHeight']				= $htValues[0];
	$ppInfo['EndHeight']			= $htValues[1];
	$ppInfo['MatchMaritalStatus']	= $ppValues[2];
	$ppInfo['PhysicalStatus']		= $ppValues[3];
	$ppInfo['MatchMotherTongue']	= $ppValues[4];
	$ppInfo['MatchReligion']		= $ppValues[5];
	$ppInfo['Manglik']				= $ppValues[6];	
	$ppInfo['MatchCaste']			= $ppValues[7];
	$ppInfo['EatinghabitsPref']		= $ppValues[8];
	$ppInfo['MatchEducation']		= $ppValues[9];
	$ppInfo['MatchCountry']			= $ppValues[11];
	$ppInfo['MatchIndianStates']	= $ppValues[12];
	$ppInfo['MatchUSStates']		= $ppValues[13];
	$ppInfo['MatchLanguage']		= $ppValues[15];
		
	$query = ' Authorized=1 AND Validated=1 AND Status=0 AND';

	if(trim($ppInfo['MatchLanguage']) != "" && trim($ppInfo['MatchLanguage'])!="0" ) { // Checking condition for Language
		$query .= ' Language IN('.trim($ppInfo['MatchLanguage'],',').') AND ';
	} 
	
	if($ppInfo['Gender']=='M') // Checking condition for Gender 
		$query .= " (Gender='F')";
	else
		$query .= " (Gender='M')";

	$query .= " AND (Age >= ".$ppInfo['StAge']." AND Age <= ".$ppInfo['EndAge'].") AND (Height >= ".$ppInfo['StHeight']." AND Height <= ".$ppInfo['EndHeight'].") "; // Checking condition for Height and Age
			
	if(trim($ppInfo['MatchReligion']) != "" && trim($ppInfo['MatchReligion']) != "0" ) {
		$query .= ' AND Religion IN('.trim($ppInfo['MatchReligion'],',').')';
	} 

	if(trim($ppInfo['MatchMaritalStatus']) != "" && trim($ppInfo['MatchMaritalStatus']) != "0" ) {
		$query .= ' AND MaritalStatus IN('.trim($ppInfo['MatchMaritalStatus'],',').')';
	}

	if(trim($ppInfo['MatchCaste']) != "" && $ppInfo['MatchCaste'] != 0 && $ppInfo['MatchCaste'] != 998 ) { // Checking condition for Match Caste
		$query .= ' AND Caste IN('.trim($ppInfo['MatchCaste'],',').')';
	}
	
	if(trim($ppInfo['MatchMotherTongue']) != "" && $ppInfo['MatchMotherTongue'] != 0) { // Checking condition for Match Mother Tongue
		$query .= ' AND MotherTongue IN('.trim($ppInfo['MatchMotherTongue'],',').')';		
	} 

	if(trim($ppInfo['PhysicalStatus']) != "" && $ppInfo['PhysicalStatus'] != 0 ) { // Checking condition for Physical Status
		$query .= " AND ( SpecialCase = ".$ppInfo['PhysicalStatus']." ) ";
	}
		
	if(trim($ppInfo['Manglik']) != ""  && trim($ppInfo['Manglik']) != 0) { // Checking condition for Manglik
		$query .= "  AND ( Dosham = ".$ppInfo['Manglik']." or Dosham = 3 )";
	} 
		
	if(trim($ppInfo['MatchEducation']) != "" && trim($ppInfo['MatchEducation']) != 0) { // Checking condition for Match Education
		$query .= ' AND EducationSelected IN('.trim($ppInfo['MatchEducation'],',').')';		
	} 
	
	if(trim($ppInfo['EatinghabitsPref']) != ""  && trim($ppInfo['EatinghabitsPref']) != 0) { // Checking condition for EatinghabitsPref
		$query .= "  AND ( EatingHabits = ".$ppInfo['EatinghabitsPref']." or EatingHabits is null )";
	} 
	
	if(trim($ppInfo['MatchCountry']) != "" && trim($ppInfo['MatchCountry']) != 0) { // Checking condition for Match Country
		$query .= ' AND CountrySelected IN('.trim($ppInfo['MatchCountry'],',').')';			
			
		if(strstr($ppInfo['MatchCountry'],"98")!="" && strstr($ppInfo['MatchIndianStates'],'0')=="")	{			
			$query .= ' AND ResidingState IN('.trim($ppInfo['MatchIndianStates'],',').')';					
		}

		if(strstr($ppInfo['MatchCountry'],"222")!="" && strstr($ppInfo['MatchUSStates'],'0')=="") 	{			
				$query .= ' AND ResidingState IN('.trim($ppInfo['MatchUSStates'],',').')';
		}
	}
	
	dispDebugValue($query);
	$qry[2] = $query;
	$qry[1] = $query;
	$qry[0] = '';
	}else {
		$qry[0] = "";
		$data['err_no']=20;
		$qry[1] = '';
		$qry[2] = '';
		$qry[4] = 0;
	}
	return $qry;
}

function genQueryProfileMatch($from=0,$to=100) {
	global $COOKIEINFO,$DBCONIP,$DBINFO,$DBNAME,$TABLE,$data,$GETDOMAININFO;
	$memberid = $COOKIEINFO['LOGININFO']['MEMBERID'];
	$dbprofilematch = $DBNAME['MATRIMONYMS'].".".$TABLE['PROFILEMATCH'];
	$db6slave = new db();
	//$db6slave->dbConnById(2,$memberid,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$db6slave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	
	$q = "select MatriId,Gender,Height,Age,Language,Religion,Maritalstatus,Caste,MotherTongue,SpecialCase,Dosham,Educationselected,Eatinghabits,CountrySelected,ResidingState from ".$dbprofilematch." where MatriId='".$memberid."'";

	$data['genQueryWhoIsLookingForMe_query_1'] = $q;

	dispDebugValue($q);

	$db6slave->query = $q;
	$db6slave->select($db6slave->query);
	$num_selected_rows = $db6slave->getNumRows();

	if($num_selected_rows >= 1 ) {
		$row =  $db6slave->fetchArray(); // Iamlookingfor Query Genration //

		$cquery = "Select count(MatriId) FROM ".$dbprofilematch." where";
		$mquery = "Select MatriId FROM ".$dbprofilematch." where";

		$query  = ' Authorized=1 AND Validated=1 AND Status=0 AND';

		if($row['Gender']=='M')
			$query .= " (Gender='F')";
		else
			$query .= " (Gender='M')";

		$query .= " AND (StHeight <= ".$row['Height']." AND EndHeight >= ".$row['Height'].") AND (StAge <= ".$row['Age']." AND EndAge >= ".$row['Age'].")  ";
		
		if(trim($row['Language']) != "" ) {			
			$query .= " AND ( matchLanguage = ".$row['Language']." or  matchlanguage like '%".$row['Language'].",%' or   matchlanguage like '%,".$row['Language']."%' or matchLanguage = 0  )";
		}

		if(trim($row['Maritalstatus']) != "" ) {			
			$query .= " AND ( MatchMaritalStatus = ".$row['Maritalstatus']." or  MatchMaritalStatus like '%".$row['Maritalstatus'].",%' or  MatchMaritalStatus like '%,".$row['Maritalstatus']."%'  or MatchMaritalStatus = 0 )";
		}

		if(trim($row['Religion']) != "" ) {			
			$query .= " AND ( MatchReligion = ".$row['Religion']." or  MatchReligion like '%".$row['Religion'].",%' or  MatchReligion like '%,".$row['Religion']."%' or  MatchReligion = 0 )";
		}

		if(trim($row['Caste']) != "" && $row['Caste'] != "0" ) {
			$query .= " AND ( MatchCaste = ".$row['Caste']." or  MatchCaste like '%".$row['Caste'].",%' or  MatchCaste like '%,".$row['Caste']."%' or  MatchCaste = 0 )";
		}	

		if(trim($row['MotherTongue']) != "" ) {
			$query .= " AND ( MatchMotherTongue = ".$row['MotherTongue']." or  MatchMotherTongue like '%".$row['MotherTongue'].",%'  or  MatchMotherTongue like '%,".$row['MotherTongue']."%' or  MatchMotherTongue = 0 )";
		}
		
		if(trim($row['Dosham']) != ""  && trim($row['Dosham']) != '3') {
			$query .= "  AND ( Manglik = ".$row['Dosham']." or Manglik = 0 )";
		}

		if(trim($row['Educationselected']) != "" ) {
			$query .= " AND ( MatchEducation = ".$row['Educationselected']." or  MatchEducation like '%".$row['Educationselected'].",%' or  MatchEducation like '%,".$row['Educationselected']."%' or  MatchEducation = 0  )";
		}

		if(trim($row['Eatinghabits']) != ""  && trim($row['Eatinghabits']) != '0') {
				$query .= "  AND ( EatinghabitsPref = ".$row['Eatinghabits']."  or EatinghabitsPref = 0 )";
		} 

		if(trim($row['SpecialCase']) != "" && trim($row['SpecialCase']) != '0' ) {
				$query .= "  AND ( PhysicalStatus = ".$row['SpecialCase']." or PhysicalStatus = 0 ) ";
		} 

		if(trim($row['CountrySelected']) != "" ) {
			$query .= " AND ( MatchCountry = ".$row['CountrySelected']." or  MatchCountry like '%".$row['CountrySelected'].",%'  or  MatchCountry like '%,".$row['CountrySelected']."%' or  MatchCountry = 0 )";
		}

		if(strstr($row['CountrySelected'],"98")!="" && strstr($row['ResidingState'],'0')=="")	{
			$query .= " AND ( MatchIndianStates = ".$row['ResidingState']." or  MatchIndianStates like '%".$row['ResidingState'].",%'  or  MatchIndianStates like '%,".$row['ResidingState']."%' or  MatchIndianStates = 0  )";
		}

		if(strstr($row['CountrySelected'],"222")!="" && strstr($row['MatchUSStates'],'0') =="")	{
			$query .= " AND ( MatchUSStates = ".$row['ResidingState']." or  MatchUSStates like '%".$row['ResidingState'].",%' or  MatchUSStates like '%,".$row['ResidingState']."%' or  MatchUSStates = 0 )";
		}

		$orderBy	= ' ORDER BY TimeCreated DESC';
		$SearchQueryReturn[1] = $cquery.$query;
		$SearchQueryReturn[0] = $mquery.$query.$orderBy;

		dispDebugValue($SearchQueryReturn);
		$qry[0] = "";
	} 
	else {
		$qry[0] = '';
		$qry[1] = '';
		$qry[2] = '';
		$qry[4] = 0;
		dispDebugValue($qry);	
		return $qry;
	}
	//print $SearchQueryReturn[1];exit;
	if($_COOKIE['PROCNT']==''){
	$db6slave->select($SearchQueryReturn[1]);
	$rows = $db6slave->fetchArray();
	$qry[4] = $rows[0];

	$proDom= $GETDOMAININFO['domainnamelong'].'.com';
	setrawcookie('PROCNT', $rows[0], "0", "/", $proDom);
	}
	else
	{
		$qry[4] = $_COOKIE['PROCNT'];
	}

	

	if($qry[4] > 0) {
		$SearchQueryReturn[0].= " limit ".$from." , ".$to;
		$db6slave->select($SearchQueryReturn[0]);

		while($rows=$db6slave->fetchArray()){	
			$tp[] = $rows[0];
		}

		if($tp!="") {
			$qry[1] = $tp;
			$qry[0] = "";
		}
		else {
			$qry[0] = '';
			$data['err_no']=21;
		}
	} 
	else {
		$qry[0] = '';
		$data['err_no']=22;
		$qry[1] = '';
		$qry[2] = '';
		$qry[4] = 0;
	} 
	dispDebugValue($qry);
	$db6slave->dbClose();
	unset($db6slave);
	return $qry;
}

function genQueryWhoIsOnline($from=0,$to=100) {
	global $COOKIEINFO,$DOMAINTABLE,$MERGETABLE,$DBCONIP,$DBINFO,$DBNAME,$TABLE,$data;

	$db6slave = new db();
	$db6slave->connect($DBCONIP['DB6'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);

	$qry[0] = "";
	// Variable declaration of post fields...
	$Search_Type		= trim($_POST['SEARCH_TYPE']);
	$Gender				= trim($_POST['GENDER']);
	$StAge				= trim($_POST['STAGE']);
	$EndAge				= trim($_POST['ENDAGE']);
	$PhotoAvailable		= trim($_POST['PHOTO_OPT']);
	$PerPage			= trim($_POST['PERPAGE']);
	$HoroscopeAvailable = trim($_POST['HOROSCOPE_OPT']);


	seperateFormValues($StAge,$EndAge);

	// Query assigning starts...
	$SQuery1 = "select mp.MatriId as MatriId from ".$DBNAME["MATRIMONYMS"].".".$MERGETABLE["MATRIMONYPROFILE"]." mp, ".$DBNAME["MESSENGER"].".".$TABLE["ICSTATUS"]." ic where mp.MatriId = ic.MatriId and ic.Status = 1 ";

	$SQuery2 =  "select count(mp.MatriId) from ".$DBNAME["MATRIMONYMS"].".".$MERGETABLE["MATRIMONYPROFILE"]." mp, ".$DBNAME["MESSENGER"].".".$TABLE["ICSTATUS"]." ic where mp.MatriId = ic.MatriId and ic.Status = 1 ";
	
	$SearchQuery = "";

	// Language checking...
	if (is_array($_POST['LANGUAGE'])) {
		$chkzero = 0;
		foreach($_POST['LANGUAGE'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$Language = " Language=1 or Language=2 or Language=3 or Language=4 or Language=5 or Language=6 or Language=7 or Language=8 or Language=9 or Language=10 or Language=11 or Language=12 or Language=13 or Language=14 or Language=15 ";
				break;
			} else {
				$Language .= " Language = $val or ";
			}
		}
		if ($chkzero != 1) {
			$Language = substr ($Language, 0, strlen($Language)-3);
		}
	} elseif (trim($_POST['LANGUAGE']) != '') {
		if ($_POST['LANGUAGE'] > 0 ) {
			$Language = " Language = '". $_POST['LANGUAGE'] . "' ";
		} elseif (trim($_POST['LANGUAGE']) == 0) {
			$Language = " Language=1 or Language=2 or Language=3 or Language=4 or Language=5 or Language=6 or Language=7 or Language=8 or Language=9 or Language=10 or Language=11 or Language=12 or Language=13 or Language=14 or Language=15 ";
		}
	}

	// Language checking...
	if (trim($Language) != '') {
		$SearchQuery .= " and ($Language) ";
	}

	// Gender checking...
	if (trim($Gender) != '' && trim($Gender) != '0') {
		$SearchQuery .= " and mp.Gender = '$Gender' ";
	}

	// Caste checking...
	if (is_array($_POST['CASTE1'])) {
		$chkzero = 0;
		$Castenobar = 0;		
		foreach($_POST['CASTE1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$Caste = "";
				break;
			} elseif ($val == 998) {
				$Castenobar = 1;
			} else {
				$Caste .= " Caste = $val or ";
			}
		}
		if ($Castenobar == 1) {
				$Caste .= " CasteNoBar = 1 or Caste = 0 or ";
		}
		if ($chkzero != 1) {
			$Caste = substr ($Caste, 0, strlen($Caste)-3);
		}
	} elseif (trim($_POST['CASTE1']) != '') {
		if ($_POST['CASTE1'] > 0 ) {
			$Caste = " Caste = '". $_POST['CASTE1'] . "' ";
		} elseif (trim($_POST['CASTE1']) == 0) {
			$Caste = "";
		}
	}

	// Caste checking...
	if (trim($Caste) != '') {
		$SearchQuery .= " and ($Caste) ";
	}

	// Religion checking...
	if (is_array($_POST['RELIGION1'])) {
		$chkzero = 0;
		$muslimreligion = 0;
		$christianreligion = 0;
		$jainreligion = 0;
		foreach($_POST['RELIGION1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$Religion = " Religion=1 or Religion=2 or Religion=3 or Religion=4 or Religion=5 or Religion=6 or Religion=7 or Religion=8 or Religion=9 or Religion=10 or Religion=11 or Religion=12 or Religion=13 or Religion=14 or Religion=15 or Religion=16 ";
				break;
			} elseif ($val == 2) {
				$muslimreligion = 1;
			} elseif ($val == 3) {
				$christianreligion = 1;
			} elseif ($val == 5) {
				$jainreligion = 1;
			} else {
				$Religion .= " Religion = $val or ";
			}
		}
		if ($muslimreligion == 1) {
		$Religion .= " Religion=2 or Religion=10 or Religion=11 or ";
		}
		if ($christianreligion == 1) {
		$Religion .= " Religion=3 or Religion=12 or Religion=13 or Religion=14 or ";
		}
		if ($jainreligion == 1) {
		$Religion .= " Religion=5 or Religion=15 or Religion=16 or ";
		}
		if ($chkzero != 1) {
			$Religion = substr ($Religion, 0, strlen($Religion)-3);
		}
	} elseif (trim($_POST['RELIGION1']) != '') {
		if ($_POST['RELIGION1'] > 0 ) {
			$Religion = " Religion = '". $_POST['RELIGION1'] . "' ";
		} elseif (trim($_POST['RELIGION1']) == 2) {
			$Religion = " Religion=2 or Religion=10 or Religion=11 ";
		} elseif (trim($_POST['RELIGION1']) == 3) {
			$Religion = " Religion=3 or Religion=12 or Religion=13 or Religion=14 ";
		} elseif (trim($_POST['RELIGION1']) == 5) {
			$Religion = " Religion=5 or Religion=15 or Religion=16 ";
		} elseif (trim($_POST['RELIGION1']) == 0) {
			$Religion = " Religion=1 or Religion=2 or Religion=3 or Religion=4 or Religion=5 or Religion=6 or Religion=7 or Religion=8 or Religion=9 or Religion=10 or Religion=11 or Religion=12 or Religion=13 or Religion=14 or Religion=15 or Religion=16 ";
		}
	}

	// Religion checking...
	if (trim($Religion) != '') {
		$SearchQuery .= " and ($Religion) ";
	}

	// Marital Status checking...
	if (is_array($_POST['MARITAL_STATUS'])) {
		$chkzero = 0;
		foreach($_POST['MARITAL_STATUS'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$MaritalStatus = " MaritalStatus=1 or MaritalStatus=2 or MaritalStatus=3 or MaritalStatus=4 ";
				break;
			} else {
				$MaritalStatus .= " MaritalStatus = $val or ";
			}
		}
		if ($chkzero != 1) {
			$MaritalStatus = substr ($MaritalStatus, 0, strlen($MaritalStatus)-3);
		}
	} elseif (trim($_POST['MARITAL_STATUS']) != '') {
		if ($_POST['MARITAL_STATUS'] > 0 ) {
			$MaritalStatus = " MaritalStatus = '". $_POST['MARITAL_STATUS'] . "' ";
		} elseif (trim($_POST['MARITAL_STATUS']) == 0) {
			$MaritalStatus = " MaritalStatus=1 or MaritalStatus=2 or MaritalStatus=3 or MaritalStatus=4 ";
		}
	}

	// MaritalStatus checking...
	if (trim($MaritalStatus) != '') {
		$SearchQuery .= " and ($MaritalStatus) ";
	}

	// Age checking...
	if (trim($StAge) != '' && trim($EndAge) != '') {
		$SearchQuery .= " and Age >= $StAge and Age <= $EndAge ";
	}

	// CountrySelected checking...
	if (is_array($_POST['COUNTRY1'])) {
		$chkzero = 0;

		foreach($_POST['COUNTRY1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$CountrySelected = "";
				break;
			} else {
				if (count($_POST['COUNTRY1']) > 30) {
					echo "Error Country Loop....";
					exit;
				}
				$CountrySelected .= " CountrySelected = $val or ";
			}
		}
		if ($chkzero != 1) {
			$CountrySelected = substr ($CountrySelected, 0, strlen($CountrySelected)-3);
		}
	} elseif (trim($_POST['COUNTRY1']) != '') {
		if ($_POST['COUNTRY1'] > 0 ) {
			$CountrySelected = " CountrySelected = '". $_POST['COUNTRY1'] . "' ";
		} elseif (trim($_POST['COUNTRY1']) == 0) {
			$CountrySelected = "";
		}
	}

	// Country checking...
	if (trim($CountrySelected) != '') {
		$SearchQuery .= " and ($CountrySelected) ";
	}

	// With Photo checking...
	if ($PhotoAvailable != '' && $PhotoAvailable == 'Y') {
		$SearchQuery .= " and mp.PhotoAvailable = 1 ";
	}
	if ($HoroscopeAvailable != '' && $HoroscopeAvailable == 'Y') {
		$SearchQuery .= " and mp.HoroscopeAvailable = 1 ";
	}
	// Includes Status, Validated, Authorized in query...
	$SearchQuery .= " and mp.Status=0 and mp.Validated=1 and mp.Authorized=1 ";

	// Limiting and Order By the Query...
	$SearchQuery .= " order by mp.LastLogin";

	// Framed Search Query is return here...
	$SearchQueryReturn[0] = $SQuery1 . $SearchQuery;
	$SearchQueryReturn[1] = $SQuery2 . $SearchQuery;
	
	dispDebugValue($SearchQueryReturn);	

	$db6slave->select($SearchQueryReturn[1]);

	$rows= $db6slave->fetchArray();
	$qry[4] = $rows[0];
	if($qry[4] > 0) {
		$SearchQueryReturn[0].= " limit ".$from.",".$to;

		$db6slave->select($SearchQueryReturn[0]);

		while($rows=$db6slave->fetchArray()){	
			$tp .= "'".$rows[0]."',";
		}

		if($tp!="") {
			$qry[1] = " MatriId in ( ";
			$qry[1] .= $tp;
			$qry[1] = substr($qry[1],0,-1);
			$qry[1] .= " ) ";
			$qry[0] = "";
		}
		else {
			$qry[0] = $data['no_records'];
			$data['err_no']=23;
		}
	} 
	else {
		$qry[0] = $data['no_records'];
		$data['err_no']=24;
		$qry[1] = '';
		$qry[2] = '';
		$qry[4] = 0;
	}
	dispDebugValue($qry);
	$db6slave->dbClose();
	unset($db6slave);
	return $qry;
}

function genQueryMutualMatch($from=0,$to=100) {
	global $memberid,$COOKIEINFO,$DOMAINTABLE,$MERGETABLE,$DBCONIP,$DBINFO,$DBNAME,$TABLE,$data,$GETDOMAININFO;
	$memberid = $COOKIEINFO['LOGININFO']['MEMBERID'];
	$dbprofilematch = $DBNAME['MATRIMONYMS'].".".$TABLE['PROFILEMATCH'];
	
	$db6slave = new db();
	//$db6slave->dbConnById(2,$memberid,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$db6slave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);

	$db6slave->query = "select MatriId, Gender, Height, StHeight, EndHeight, Age, StAge, EndAge, Language, MatchLanguage,Religion,MatchReligion,Maritalstatus, MatchMaritalStatus, Caste, MatchCaste, MotherTongue, MatchMotherTongue, SpecialCase, PhysicalStatus, Dosham, Manglik, Educationselected, MatchEducation, Eatinghabits, EatinghabitsPref, CountrySelected, MatchCountry, ResidingState, MatchIndianStates, MatchUSStates  from ". $dbprofilematch." where MatriId='".$memberid."'";

	$query = "";
	$db6slave->select($db6slave->query);
	dispDebugValue($db6slave->query);

	$num_selected_rows = $db6slave->getNumRows();

	if($num_selected_rows >= 1 ) {
		$row =  $db6slave->fetchArray(); // Iamlookingfor Query Genration //			
		$cquery = "Select count(MatriId) FROM ".$dbprofilematch." where";
		$mquery = "Select MatriId FROM ".$dbprofilematch." where";

		$query  = ' Authorized=1 AND Validated=1 AND Status=0 AND';

		if($row['Gender']=='M')
			$query .= " (Gender='F')";
		else
			$query .= " (Gender='M')";

		$query .= " AND (Height >= ".$row['StHeight']." AND Height <= ".$row['EndHeight'].") AND (StHeight <=".$row['Height']." AND EndHeight>=".$row['Height'].") AND (Age >= ".$row['StAge']." AND Age <= ".$row['EndAge'].") AND (StAge<=".$row['Age']." AND EndAge>=".$row['Age'].")";

		$query .= " AND (concat(',',MatchLanguage,',') like '%,".$row['Language'].",%' or MatchLanguage = '0' or MatchLanguage IS NULL)";
		
		if($row['MatchLanguage']!=0 && $row['MatchLanguage']!='')
		$query .= " AND (Language in (".trim($row['MatchLanguage'],',')."))";

		if($row['MatchReligion']!=0 && $row['MatchReligion']!='')
		$query .= " AND (Religion in (".trim($row['MatchReligion'],',')."))";
		
		$query .= " AND (concat(',',MatchReligion,',') like '%,".$row['Religion'].",%' OR MatchReligion = '0' or MatchReligion IS NULL)";

		if($row['MatchMaritalStatus']!='0' && $row['MatchMaritalStatus']!='')
		$query .= " AND (Maritalstatus in (".trim($row['MatchMaritalStatus'],',')."))";
		
		$query .= " AND (concat(',',MatchMaritalStatus,',') like '%,".$row['Maritalstatus'].",%' OR MatchMaritalStatus ='0' or MatchMaritalStatus IS NULL)";

		if($row['MatchCaste']!='0' && $row['MatchCaste']!='' && $row['MatchCaste'] !='998')
		$query .=" AND (Caste in (".trim($row['MatchCaste'],',')."))";
		
		$query .= " AND (concat(',',MatchCaste,',') like '%,".$row['Caste'].",%' OR MatchCaste = '0' or MatchCaste IS NULL)";
		
		if($row['MatchMotherTongue']!='0' && $row['MatchMotherTongue']!='')
		$query .= " AND (MotherTongue in (".trim($row['MatchMotherTongue'],',')."))";
		
		$query .= " AND (concat(',',MatchMotherTongue,',') like '%,".$row['MotherTongue'].",%' OR MatchMotherTongue = '0' or MatchMotherTongue IS NULL)";

		if($row['PhysicalStatus']!=0 && $row['PhysicalStatus']!='')
		$query .= " AND (SpecialCase = ".$row['PhysicalStatus'].")";
		
		$query .= " AND (PhysicalStatus = ".$row['SpecialCase']." OR PhysicalStatus = 0 or PhysicalStatus IS NULL)";
		
		if($row['Manglik']!=0 && $row['Manglik']!='')
		$query .= " AND (Dosham = ".$row['Manglik'].")";
		
		$query .= " AND (Manglik=".$row['Dosham']." OR Manglik = 0 or Manglik IS NULL)";

		if($row['MatchEducation']!=0 && $row['MatchEducation']!='')
		$query .= " AND (Educationselected in (".trim($row['MatchEducation'],',')."))";
		
		$query .= " AND (concat(',',MatchEducation,',') like '%,".$row['Educationselected'].",%' OR MatchEducation = '0' or MatchEducation IS NULL)";

		if($row['EatinghabitsPref']!=0 && $row['EatinghabitsPref']!='')
		$query .= " AND (Eatinghabits=".$row['EatinghabitsPref'].")";
		
		$query .= " AND (".$row['Eatinghabits']."=EatinghabitsPref OR EatinghabitsPref=0 or EatinghabitsPref IS NULL)";

		if($row['MatchCountry']!=0 && $row['MatchCountry']!='')
		$query .= " AND CountrySelected in (".trim($row['MatchCountry'],',').")";
		if(strstr($row['MatchCountry'],"98")!="") {
			if($row['MatchIndianStates']!=0 && $row['MatchIndianStates']!='')
			$query .= " AND (ResidingState in (".trim($row['MatchIndianStates'],',')."))";							
			
			if(strstr($row['MatchCountry'],"222")!="" && $row['MatchUSStates']!=0 && $row['MatchUSStates']!='') {
				$query .= " AND (ResidingState in (".trim($row['MatchUSStates'],',')."))";
			}
		}
		
		$query .= " AND (concat(',',MatchCountry,',') like '%,".trim($row['CountrySelected'],',').",%' OR MatchCountry = '0' OR MatchCountry IS NULL)";
		if($row['CountrySelected']==98) {
			$query .= " AND (concat(',',MatchIndianStates,',') like '%,".trim($row['ResidingState'],',').",%' OR MatchIndianStates = '0' OR MatchIndianStates IS NULL)";
		}

		if($row['CountrySelected']==222) {
			$query .= " AND (concat(',',MatchUSStates,',') like '%,".trim($row['ResidingState'],',').",%' OR MatchUSStates = '0' OR MatchUSStates IS NULL)";
		}

		 $orderBy	= ' ORDER BY TimeCreated DESC';
		 $SearchQueryReturn[1] = $cquery.$query;	
		 $SearchQueryReturn[0] = $mquery.$query.$orderBy;
		 dispDebugValue($SearchQueryReturn);
	} 
	else {
		$qry[0] = $data['no_records'];
		$data['err_no']=25;
		dispDebugValue($qry);		
		return $qry;
	}
	//print $SearchQueryReturn[1];exit;
	if($_COOKIE['MUTCNT']==''){
	$db6slave->select($SearchQueryReturn[1]);
	$rows = $db6slave->fetchArray();
	$qry[4] = $rows[0];
	$mutDom = $GETDOMAININFO['domainnamelong'].'.com';
	setrawcookie('MUTCNT', $rows[0], "0", "/", $mutDom);
	}
	else
	{
		$qry[4] = $_COOKIE['MUTCNT'];
	}
	if($qry[4] > 0) {
		$SearchQueryReturn[0].= " limit ".$from." , ".$to;
		$db6slave->select($SearchQueryReturn[0]);

		while($rows=$db6slave->fetchArray()){	
			$tp[]= $rows[0];
		}

		if($tp!="") {
			$qry[1] = $tp;
			$qry[0] = "";
		}
		else {
			$qry[0] = '';
			$data['err_no']=26;
			$qry[1] = '';
			$qry[2] = '';
			$qry[4] = 0;
		}
	} 
	else {
		$qry[0] = '';
		$data['err_no']=27;
		$qry[1] = '';
		$qry[2] = '';
		$qry[4] = 0;
	}
	dispDebugValue($qry);
	$db6slave->dbClose();
	unset($db6slave);
	return $qry;
}

function genQueryMembersOnline($from=0,$to=100) {
	global $COOKIEINFO,$DOMAINTABLE,$MERGETABLE,$DBCONIP,$DBINFO,$DBNAME,$TABLE,$data;
	
	$db6slave = new db();
	$db6slave->connect($DBCONIP['DB6'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$qry[0] = "";
	
	if (trim($COOKIEINFO['LOGININFO']['MEMBERID']) != '') {
		if (trim($COOKIEINFO['LOGININFO']['GENDER'])=='M') {
			$gendertochk = 'F';
		} elseif (trim($COOKIEINFO['LOGININFO']['GENDER'])=='F') {
			$gendertochk = 'M';
		}
		$gender_qry = " and mp.Gender = '$gendertochk' ";
	} else {
		$gen = trim($_REQUEST['gen']);
		if ($gen == '') {
			$gen = "F";
		}		
		$gender_qry = " and mp.Gender = '$gen' ";
	}

	$search_count_query = "select count(mp.MatriId) from ".$DBNAME["MATRIMONYMS"].".".$MERGETABLE["MATRIMONYPROFILE"]." as mp, ".$DBNAME["MESSENGER"].".".$TABLE["ICSTATUS"]." as ic where mp.MatriId = ic.MatriId and ic.Status = 1 and mp.Status = 0 and mp.Validated = 1 and mp.Authorized = 1 and mp.MatriId != '".$COOKIEINFO['LOGININFO']['MEMBERID']."' and mp.Language >= 1 $gender_qry order by mp.LastLogin";

	$search_result_query = "select mp.MatriId as MatriId from ". $DBNAME["MATRIMONYMS"].".".$MERGETABLE["MATRIMONYPROFILE"]." as mp, ".$DBNAME["MESSENGER"].".".$TABLE["ICSTATUS"]." as ic where mp.MatriId = ic.MatriId and ic.Status = 1 and mp.Status = 0 and mp.Validated = 1 and mp.Authorized = 1 and mp.MatriId != '".$COOKIEINFO['LOGININFO']['MEMBERID']."' and mp.Language >= 1 $gender_qry order by mp.LastLogin";

	$SearchQueryReturn[1] = $search_count_query;
	$SearchQueryReturn[0] = $search_result_query;

	dispDebugValue($SearchQueryReturn);

	$db6slave->select($SearchQueryReturn[1]);
	$rows= $db6slave->fetchArray();
	$qry[4] = $rows[0];

	if($qry[4] > 0) {
		$SearchQueryReturn[0].= " limit ".$from." , ".$to;
		$db6slave->select($SearchQueryReturn[0]);

		while($rows=$db6slave->fetchArray()){	
			$tp .= "'".$rows[0]."',";
		}	
		if($tp!="") {
			$qry[1] = " MatriId in ( ";
			$qry[1] .= $tp;
			$qry[1] = substr($qry[1],0,-1);
			$qry[1] .= " ) ";
			$qry[0] = "";
		}
		else {
			$qry[0] = 'Currently there are no profiles that fall under this category.';
			$data['err_no']=28;
		}
	} 
	else {
		$qry[0] = $data['no_records'];
		$data['err_no']=29;
		$qry[1] = '';
		$qry[2] = '';
		$qry[4] = 0;
	}

	dispDebugValue($qry);

	$db6slave->dbClose();
	unset($db6slave);
	return $qry;
}

function splitFormValue($form_arr) {
	if($form_arr!="" && (!(is_array($form_arr)))) {
		if(preg_match("/~/",$form_arr)) {
			return explode("~", $form_arr);
		}
		else {
			$tp[0] = $form_arr;
			return $tp;
		}
	} else {
		return $form_arr;
	}
}

function splitCountryStateIds($statearr,$RESIDINGINDIANAMES,$RESIDINGUSANAMES) {
	global $frm, $data;
	foreach($statearr as $key=>$val) {
		$india_val=substr($val,0,2);
		$usa_val=substr($val,0,3);
		if($usa_val==222) {
			$result_usa_val=substr($val,3,strlen($val));
			foreach($RESIDINGUSANAMES as $k=>$v) {
				if($k==$result_usa_val)
					$usa_state_arr_id[]=$result_usa_val;
			}
		}
		if($india_val==98)	 {
			$result_ind_val=substr($val,2,strlen($val));
			foreach($RESIDINGINDIANAMES as $k=>$v) {		
				if($k==$result_ind_val)
					$india_state_arr_id[]=$result_ind_val;
			}
		}
	}
	$usa_sta_id=getArr($usa_state_arr_id);
	$ind_sta_id=getArr($india_state_arr_id);	
	$state_ids=$ind_sta_id."###".$usa_sta_id;  
	return $state_ids;
} 

function removeLastChar($str='',$replace_char=',') {
	global $frm, $data;
	$str = preg_replace("/".$replace_char."$/","",$str);
	return $str;
}

function getArr($state_arr_id) {
	global $frm, $data;
	$sta_id='';
	for($i=0;$i<count($state_arr_id);$i++)	{
		if($i==0) {
			$sta_id.=$state_arr_id[0];
		} else {
			$sta_id.="~".$state_arr_id[$i];
        }
	} return $sta_id;
}


function seperateFormValues($StAge,$EndAge) {

	chkUndefinedValue('EDUCATION1');
	chkUndefinedValue('COUNTRY1');
	chkUndefinedValue('OCCUPATION1');
	chkUndefinedValue($StAge,20);
	chkUndefinedValue($EndAge,40);
	if(isset($_POST['LANGUAGE'])) { $_POST['LANGUAGE'] = splitFormValue($_POST['LANGUAGE']); } else { $_POST['LANGUAGE']=0; }
	if(isset($_POST['RELIGION1'])) { $_POST['RELIGION1'] = splitFormValue($_POST['RELIGION1']); }
	if(isset($_POST['CASTE1'])) { $_POST['CASTE1'] = splitFormValue($_POST['CASTE1']); }
	if(isset($_POST['MARITAL_STATUS'])) { $_POST['MARITAL_STATUS'] = splitFormValue($_POST['MARITAL_STATUS']); }
	if(isset($_POST['MOTHERTONGUE1'])) { $_POST['MOTHERTONGUE1'] = splitFormValue($_POST['MOTHERTONGUE1']); }
	if(isset($_POST['BODY_TYPE'])) { $_POST['BODY_TYPE'] = splitFormValue($_POST['BODY_TYPE']); }
	if(isset($_POST['COMPLEXION'])) { $_POST['COMPLEXION'] = splitFormValue($_POST['COMPLEXION']); }
	if(isset($_POST['EDUCATION1'])) { $_POST['EDUCATION1'] = splitFormValue($_POST['EDUCATION1']); }
	if(isset($_POST['CITIZENSHIP1'])) { $_POST['CITIZENSHIP1'] = splitFormValue($_POST['CITIZENSHIP1']); }
	if(isset($_POST['COUNTRY1'])) { $_POST['COUNTRY1'] = splitFormValue($_POST['COUNTRY1']); }
	if(isset($_POST['RESIDINGINDIA1'])) { $_POST['RESIDINGINDIA1'] = splitFormValue($_POST['RESIDINGINDIA1']); }
	if(isset($_POST['RESIDINGUSA1'])) { $_POST['RESIDINGUSA1'] = splitFormValue($_POST['RESIDINGUSA1']); }
	if(isset($_POST['RESIDENTSTATUS1'])) { $_POST['RESIDENTSTATUS1'] = splitFormValue($_POST['RESIDENTSTATUS1']); }
	if(isset($_POST['RESIDINGCITY1'])) { $_POST['RESIDINGCITY1'] = splitFormValue($_POST['RESIDINGCITY1']); }
	if(isset($_POST['RESIDINGSTATE1'])) { $_POST['RESIDINGSTATE1'] = splitFormValue($_POST['RESIDINGSTATE1']); }
	if(isset($_POST['OCCUPATION1'])) { $_POST['OCCUPATION1'] = splitFormValue($_POST['OCCUPATION1']); }
	if(isset($_POST['STAR1'])) { $_POST['STAR1'] = splitFormValue($_POST['STAR1']); }

	}

function doSearch() {
	global $HEIGHTSRCHHASH, $mid, $dblanglink, $langidto_conn;
	global $data, $frm, $RESIDINGINDIANAMES,$RESIDINGUSANAMES, $GLOBALS, $COOKIEINFO, $GETDOMAININFO;
	
	$get_domain_id= array_search($GETDOMAININFO['domainnameshort'], $GLOBALS['DOMAINNAME']);

	$logpath = "/var/log/bmlog/sskeylog/".$_SERVER['SERVER_ADDR']."_smart_search_subcaste.log";
	$logpath1 = "/var/log/bmlog/sskeylog/".$_SERVER['SERVER_ADDR']."_smart_search_desc.log";
	$err_string="\n\n<br><br>Note: For multiple selections please do not select more than 30 categories.";

	$Gender			= trim($_POST['GENDER']);
	$StAge			= trim($_POST['STAGE']);
	$EndAge			= trim($_POST['ENDAGE']);
	$StHeight		= trim($_POST['STHEIGHT']);
	$EndHeight		= trim($_POST['ENDHEIGHT']);
	$PhotoAvailable	= trim($_POST['PHOTO_OPT']);
	$HoroscopeAvailable	= trim($_POST['HOROSCOPE_OPT']);
		
	$Search_Type	= trim($_POST['SEARCH_TYPE']);
	$DateOpt		= trim($_POST['DATE_OPT']);
	$SubCaste		= trim($_POST['SUBCASTE']);
	$Days			= trim($_POST['DAYS']);
	$StMonth		= trim($_POST['ST_MONTH']);
	$StDay			= trim($_POST['ST_DAY']);
	$StYear			= trim($_POST['ST_YEAR']);
	$IgnoreOpt		= trim($_POST['IGNORE_OPT']);
	$ContactOpt		= trim($_POST['CONTACT_OPT']);
	$PerPage		= trim($_POST['PERPAGE']);
	$OtherCity		= trim($_POST['OTHER_CITY']);
	$HavingChildren	= trim($_POST['HAVECHILDREN']);
	$PhysicalStatus	= trim($_POST['PHYSICAL_STATUS']);
	$Manglik		= trim($_POST['MANGLIK']);
	$EatingHabits	= trim($_POST['EATINGHABITS']);
	$Keywords		= trim($_POST['KEYWORDS']);
	$DrinkingHabits	= trim($_POST['DRINKING']);
	$SmokingHabits	= trim($_POST['SMOKING']);
	$IncomeCurrency	= trim($_POST['INCOME_CURRENCY']);
	$AnnualIncome	= trim($_POST['AMOUNT']);

	seperateFormValues($StAge,$EndAge);	

	// Query assigning starts...
	$SearchQuery = " ";

	$bharat_Language= " Language=1 or Language=2 or Language=3 or Language=4 or Language=5 or Language=6 or Language=7 or Language=8 or Language=9 or Language=10 or Language=11 or Language=12 or Language=13 or Language=14 or Language=15 ";

	// Language checking...
	if (is_array($_POST['LANGUAGE'])) {
		$chkzero = 0;
		foreach($_POST['LANGUAGE'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$Language = $bharat_Language;
				break;
			} else {
				$Language .= " Language = $val or ";
			}
		}
		if ($chkzero != 1) {
			$Language = substr ($Language, 0, strlen($Language)-3);
		}
	} elseif (trim($_POST['LANGUAGE']) != '') {
		if ($_POST['LANGUAGE'] > 0 ) {
			$Language = " Language = ". $_POST['LANGUAGE'] . " ";
		} elseif (trim($_POST['LANGUAGE']) == 0) {
			$Language = $bharat_Language;
		}
	}

	// Language checking...
	if (trim($Language) != '') {
		$SearchQuery .= " ($Language) ";
	} else {
		if($GETDOMAININFO['domainnameshort']=="bharat") {
			$SearchQuery .= " ($bharat_Language) "; 
		} else {
			$SearchQuery .= " (Language = ".$get_domain_id.") ";
		}
	}
	
	// Gender checking...
	if(trim($Gender) != '' && trim($Gender) != '0') {
		$SearchQuery .= " and Gender = '$Gender' ";
	}
	else {
		$SearchQueryReturn[0] = "nine";
		$data['err_no']=10;
		return $SearchQueryReturn;
	}

	// Religion checking...
	if(is_array($_POST['RELIGION1'])) {
		asort($_POST['RELIGION1']);
		$chkzero = 0;
		$muslimreligion = 0;
		$christianreligion = 0;
		$jainreligion = 0;
		foreach($_POST['RELIGION1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$Religion = " Religion=1 or Religion=2 or Religion=3 or Religion=4 or Religion=5 or Religion=6 or Religion=7 or Religion=8 or Religion=9 or Religion=10 or Religion=11 or Religion=12 or Religion=13 or Religion=14 or Religion=15 or Religion=16 ";
				break;
			} elseif($val==2) {
				$muslimreligion = 1;
			}elseif($val==3) {
				$christianreligion = 1;
			}elseif($val==5) {
				$jainreligion = 1;
			} else {
				$Religion .= " Religion = $val or ";
			}
		}
		if($muslimreligion==1) {
		$Religion .= " Religion=2 or Religion=10 or Religion=11 or ";
		}
		if($christianreligion==1) {
		$Religion .= " Religion=3 or Religion=12 or Religion=13 or Religion=14 or ";
		}
		if($jainreligion==1) {
		$Religion .= " Religion=5 or Religion=15 or Religion=16 or ";
		}
		if($chkzero != 1) {
			$Religion = substr ($Religion, 0, strlen($Religion)-3);
		}
	} elseif(trim($_POST['RELIGION1']) != '') {
		if(trim($_POST['RELIGION1'])==2) {
			$Religion = " Religion=2 or Religion=10 or Religion=11 ";
		} elseif(trim($_POST['RELIGION1'])==3) {
			$Religion = " Religion=3 or Religion=12 or Religion=13 or Religion=14 ";
		} elseif(trim($_POST['RELIGION1'])==5) {
			$Religion = " Religion=5 or Religion=15 or Religion=16 ";
		} elseif(trim($_POST['RELIGION1'])==0) {
			$Religion = " Religion=1 or Religion=2 or Religion=3 or Religion=4 or Religion=5 or Religion=6 or Religion=7 or Religion=8 or Religion=9 or Religion=10 or Religion=11 or Religion=12 or Religion=13 or Religion=14 or Religion=15 or Religion=16 ";
		} elseif($_POST['RELIGION1'] > 0 ) {
			$Religion = " Religion = ". $_POST['RELIGION1'] . " ";
		}
	} else { // If RELIGION1 is not set - Any
		$Religion = " Religion=1 or Religion=2 or Religion=3 or Religion=4 or Religion=5 or Religion=6 or Religion=7 or Religion=8 or Religion=9 or Religion=10 or Religion=11 or Religion=12 or Religion=13 or Religion=14 or Religion=15 or Religion=16 ";
	}

	// Religion checking...
	if(trim($Religion) != '') {
		$SearchQuery .= " and ($Religion) ";
	}

	// Age checking...
	if(trim($StAge) != '' && trim($EndAge) != '') {
		$SearchQuery .= " and Age >= $StAge and Age <= $EndAge ";
	}

	if(count($_POST['CASTE1']) > 30) {
		$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 castes in your search criteria.".$err_string;
		$data['err_no']=11;
		return $SearchQueryReturn;
	}
	// Caste checking...
	if(is_array($_POST['CASTE1'])) {
		asort($_POST['CASTE1']);
		$chkzero = 0;
		$Castenobar = 0;
		foreach($_POST['CASTE1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$Caste = "";
				break;
			} elseif($val==998) {
				$Castenobar = 1;
			} else {
				$Caste .= " Caste = $val or ";
			}
		}
		if($Castenobar==1) {
			$Caste .= " CasteNoBar = 1 or Caste = 0 or ";
		}
		if($chkzero != 1) {
			$Caste = substr($Caste, 0, strlen($Caste)-3);
		}
	} elseif(trim($_POST['CASTE1']) != '') {
		if($_POST['CASTE1'] > 0 ) {
			if($_POST['CASTE1']==998) {
				$Caste = " CasteNoBar = 1 or Caste = 0 ";
			} else {
				$Caste = " Caste = ". $_POST['CASTE1'] . " ";
			}
		} 
		elseif(trim($_POST['CASTE1'])==0) {
			$Caste = " Caste >= 0 ";
		}
	} else {
		$Caste = " Caste >= 0 ";
	}

	if(trim($Caste) != '') {
		$SearchQuery .= " and ($Caste) ";
	}

	// Marital Status checking...
	if(is_array($_POST['MARITAL_STATUS'])) {
		$chkzero = 0;
		foreach($_POST['MARITAL_STATUS'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$MaritalStatus = " MaritalStatus=1 or MaritalStatus=2 or MaritalStatus=3 or MaritalStatus=4 ";
				break;
			} else {
				$MaritalStatus .= " MaritalStatus = $val or ";
			}
		}
		if($chkzero != 1) {
			$MaritalStatus = substr ($MaritalStatus, 0, strlen($MaritalStatus)-3);
		}
	} elseif(trim($_POST['MARITAL_STATUS']) != '') {
		if($_POST['MARITAL_STATUS'] > 0 ) {
			$MaritalStatus = " MaritalStatus = ". $_POST['MARITAL_STATUS'] . " ";
		} elseif(trim($_POST['MARITAL_STATUS'])==0) {
			$MaritalStatus = " MaritalStatus=1 or MaritalStatus=2 or MaritalStatus=3 or MaritalStatus=4 ";
		}
	}

	// MaritalStatus checking...
	if(trim($MaritalStatus) != '') {
		$SearchQuery .= " and ($MaritalStatus) ";
	}

	// HavingChildren checking...
	if($HavingChildren != '') {
		if($HavingChildren==1) {
			$SearchQuery .= " and ChildrenLivingStatus = 0 ";
		} elseif($HavingChildren==2) {
			$SearchQuery .= " and ChildrenLivingStatus = 1 ";
		} elseif($HavingChildren==3) {
			$SearchQuery .= " and ChildrenLivingStatus = 2 ";
		}
	}

	// Height Checking...
	if($StHeight != '' && $EndHeight != '') {
		$stheight1=floor($HEIGHTSRCHHASH[$StHeight]);
		$endheight1=ceil($HEIGHTSRCHHASH[$EndHeight]);
		$SearchQuery .= " and Height >= $stheight1 and Height <= $endheight1 ";
	}

	// PHYSICAL_STATUS checking...
	//if PhysicalStatus=2 it is doesnt matter. dont form query for specialcase 
	if($PhysicalStatus != '') {
		if($PhysicalStatus==0) {
			$SearchQuery .= " and SpecialCase = 0 ";
		} elseif($PhysicalStatus==1) {
			$SearchQuery .= " and SpecialCase = 1 ";
		}
	}

	// MotherTounge checking...
	if(is_array($_POST['MOTHERTONGUE1'])) {
		$chkzero = 0;
		foreach($_POST['MOTHERTONGUE1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$MotherTongue = "";
				break;
			} else {
				$MotherTongue .= " MotherTongue = $val or ";
			}
		}
		if($chkzero != 1) {
			$MotherTongue = substr ($MotherTongue, 0, strlen($MotherTongue)-3);
		}
	} elseif(trim($_POST['MOTHERTONGUE1']) != '') {
		if($_POST['MOTHERTONGUE1'] > 0 ) {
			$MotherTongue = " MotherTongue = ". $_POST['MOTHERTONGUE1'] . " ";
		} elseif(trim($_POST['MOTHERTONGUE1'])==0) {
			$MotherTongue = "";
		}
	}

	// MotherTounge checking...
	if(trim($MotherTongue) != '') {
		$SearchQuery .= " and ($MotherTongue) ";
	}

	// SubCaste checking...
	if(trim($SubCaste) != '') {
		$SearchQuery .= " and SubCaste like '%$SubCaste%' ";
	}

	if($SubCaste!="") {
		$SubCaste_track = $SubCaste."~";
	}

	// MANGLIK checking...
	if($Manglik != '') {
		if($Manglik==1) {
			$SearchQuery .= " and Dosham = 1 ";
		} elseif($Manglik==2) {
			$SearchQuery .= " and (Dosham=2 or Dosham=0 ) ";
		}
	}

	// EatingHabits checking...
	if($EatingHabits != '') {
		if($EatingHabits==1) {
			$SearchQuery .= " and EatingHabits = 1 ";
		} elseif($EatingHabits==2) {
			$SearchQuery .= " and EatingHabits = 2 ";
		}
	}

	// Bodytype checking...
	if(is_array($_POST['BODY_TYPE'])) {
		$chkzero = 0;
		foreach($_POST['BODY_TYPE'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$BodyType = "";
				break;
			} else {
				$BodyType .= " BodyType = $val or ";
			}
		}
		if($chkzero != 1) {
			$BodyType = substr ($BodyType, 0, strlen($BodyType)-3);
		}
	} elseif(trim($_POST['BODY_TYPE']) != '') {
		if($_POST['BODY_TYPE'] > 0 ) {
			$BodyType = " BodyType = ". $_POST['BODY_TYPE'] . " ";
		} elseif(trim($_POST['BODY_TYPE'])==0) {
			$BodyType = "";
		}
	}

	// BodyType checking...
	if(trim($BodyType) != '') {
		$SearchQuery .= " and ($BodyType) ";
	}

	// Complexion checking...
	if(is_array($_POST['COMPLEXION'])) {
		$chkzero = 0;
		foreach($_POST['COMPLEXION'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$Complexion = "";
				break;
			} else {
				$Complexion .= " Complexion = $val or ";
			}
		}
		if($chkzero != 1) {
			$Complexion = substr ($Complexion, 0, strlen($Complexion)-3);
		}
	} elseif(trim($_POST['COMPLEXION']) != '') {
		if($_POST['COMPLEXION'] > 0 ) {
			$Complexion = " Complexion = ". $_POST['COMPLEXION'] . " ";
		} elseif(trim($_POST['COMPLEXION'])==0) {
			$Complexion = "";
		}
	}

	// Complexion checking...
	if(trim($Complexion) != '') {
		$SearchQuery .= " and ($Complexion) ";
	}

	if(is_array($_POST['EDUCATION1'])) {
		$chkzero = 0;
		foreach($_POST['EDUCATION1'] as $key => $val) {
			if(trim($val)!="") {
				if($val==0) {
					$chkzero = 1;
					$EducationSelected = "";
					break;
				} else {
					$EducationSelected .= " EducationSelected = $val or ";
				}
			}
		}
		if($chkzero != 1) {
			$EducationSelected = substr ($EducationSelected, 0, strlen($EducationSelected)-3);
		}
	} elseif(trim($_POST['EDUCATION1']) != '') {
		if($_POST['EDUCATION1'] > 0 ) {
			$EducationSelected = " EducationSelected = ". $_POST['EDUCATION1'] . " ";
		} elseif(trim($_POST['EDUCATION1'])==0) {
			$EducationSelected = "";
		}
	}

	// EducationSelected checking...
	if(trim($EducationSelected) != '') {
		$SearchQuery .= " and ($EducationSelected) ";
	}

	if(count($_POST['CITIZENSHIP1']) > 30) {
		$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 citizenships in your search criteria.".$err_string;
		$data['err_no']=12;
		return $SearchQueryReturn;
	}
	// Citizenship checking...
	if(is_array($_POST['CITIZENSHIP1'])) {
		$chkzero = 0;
		foreach($_POST['CITIZENSHIP1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$Citizenship = "";
				break;
			} else {
				$Citizenship .= " Citizenship = $val or ";
			}
		}
		if($chkzero != 1) {
			$Citizenship = substr ($Citizenship, 0, strlen($Citizenship)-3);
		}
	} elseif(trim($_POST['CITIZENSHIP1']) != '') {
		if($_POST['CITIZENSHIP1'] > 0 ) {
			$Citizenship = " Citizenship = ". $_POST['CITIZENSHIP1'] . " ";
		} elseif(trim($_POST['CITIZENSHIP1'])==0) {
			$Citizenship = "";
		}
	}

	// Citizenship checking...
	if(trim($Citizenship) != '') {
		$SearchQuery .= " and ($Citizenship) ";
	}

	if(count($_POST['COUNTRY1']) > 30) {
		$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 countries in your search criteria.".$err_string;
		$data['err_no']=13;
		return $SearchQueryReturn;
	}
	// CountrySelected checking...
	$countryindia = 0;
	$countryus = 0;
	if(is_array($_POST['COUNTRY1'])) {
		$chkzero = 0;		
		$othercountry = 0;
		$iscountry = '';
		foreach($_POST['COUNTRY1'] as $key => $val) {
			if(trim($val)!="") {
				if($val==0) {
					$chkzero = 1;
					$CountrySelected = "";
					$iscountry = 'any';
					break;
				} else {
					if($val==98 || $val==222) {
						if($val==98) {
							$countryindia = 1;
						} 
						if($val==222) {
							$countryus = 1;
						}
					} else {
						$CountrySelected .= " CountrySelected = $val or ";
						$othercountry = 1;
					}
				}
			}
		}
		if($chkzero != 1) {
			$CountrySelected = substr ($CountrySelected, 0, strlen($CountrySelected)-3);
		}
	} elseif(trim($_POST['COUNTRY1']) != '') {
		if($_POST['COUNTRY1'] > 0 ) {
			if($_POST['COUNTRY1']==98) 
				$countryindia = 1;						 
			if($_POST['COUNTRY1']==222) 
				$countryus = 1;
		   $CountrySelected = " CountrySelected = ". $_POST['COUNTRY1'] . " ";
		} elseif(trim($_POST[$country_name])==0) {
			$CountrySelected = "";
		}
	}

	if($_POST['SEARCH_TYPE']=="ADVANCESEARCH") {
		if(count($_POST['RESIDINGSTATE1']) > 30) {
			$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 resident states in your search criteria.".$err_string;
			$data['err_no']=14;
			return $SearchQueryReturn;
		}
		if(($countryindia==1 || $countryus==1) && isset($_POST['RESIDINGSTATE1'])) {
			$res_arr = split("###",splitCountryStateIds($_POST['RESIDINGSTATE1'],$RESIDINGINDIANAMES,$RESIDINGUSANAMES));
			$_POST['RESIDINGINDIA1'] = $res_arr[0];
			$_POST['RESIDINGUSA1'] = $res_arr[1];
			if(isset($_POST['RESIDINGINDIA1'])) { $_POST['RESIDINGINDIA1'] = splitFormValue($_POST['RESIDINGINDIA1']); }
			if(isset($_POST['RESIDINGUSA1'])) { $_POST['RESIDINGUSA1'] = splitFormValue($_POST['RESIDINGUSA1']); }
		}
	}	

	if(count($_POST['RESIDINGINDIA1']) > 30) {
		$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 resident states in your search criteria.".$err_string;
		$data['err_no']=15;
		return $SearchQueryReturn;
	}
	if($countryindia==1) {
	// ResidingIndia checking...
	if(is_array($_POST['RESIDINGINDIA1'])) {
		$chkzero = 0;
		foreach($_POST['RESIDINGINDIA1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$ResidingState = "";
				break;
			} else {
				$ResidingState .= " ResidingState = $val or ";
			}
		}
		if($chkzero != 1) {
			$ResidingState = substr ($ResidingState, 0, strlen($ResidingState)-3);
		}
	} elseif(trim($_POST['RESIDINGINDIA1']) != '') {
		if($_POST['RESIDINGINDIA1'] > 0 ) {
			$ResidingState = " ResidingState = ". $_POST['RESIDINGINDIA1'] . " ";
		} elseif(trim($_POST['RESIDINGINDIA1'])==0) {
			$ResidingState = "";
		}
	}

	// ResidingIndia checking...
	if(trim($ResidingState) != '') {

			// City Checking //
			if(count($_POST['RESIDINGCITY1']) > 30) {
				$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 cities in your search criteria.".$err_string;
				$data['err_no']=16;
				return $SearchQueryReturn;
			}
			// City checking...
			if(is_array($_POST['RESIDINGCITY1'])) {
				$chkzero = 0;
				foreach($_POST['RESIDINGCITY1'] as $key => $val) {
					if($val==0) {
						$chkzero = 1;
						$City = "";
						break;
					} else {
						$val = substr($val, 2);
						$City .= " ResidingDistrict = $val or ";
					}
				}
				if($chkzero != 1) {
					$City = substr ($City, 0, strlen($City)-3);
				}
			} elseif(trim($_POST['RESIDINGCITY1']) != '') {
				if($_POST['RESIDINGCITY1'] > 0 ) {
					$_POST['RESIDINGCITY1'] = substr($_POST['RESIDINGCITY1'], 2);
					$City = " ResidingDistrict = ". $_POST['RESIDINGCITY1'] . " ";
				} elseif(trim($_POST['RESIDINGCITY1'])==0) {
					$City = "";
				}
			}

			// City checking...
			if(trim($City) != '') {
				$CityQuery = " and ($City) ";
			} else {
				$CityQuery = "";
			}

		if($othercountry==1) {
			$indiaSearchQuery = " or (CountrySelected =98 and ($ResidingState) $CityQuery ) ";
		} else {
			$indiaSearchQuery = " (CountrySelected =98 and ($ResidingState) $CityQuery ) ";
		}
	} else {
		if($othercountry==1) {
			$indiaSearchQuery = " or (CountrySelected =98) ";
		} else {
			$indiaSearchQuery = " (CountrySelected =98) ";
		}
	}
	}

	if(count($_POST['RESIDINGUSA1']) > 30) {
		$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 cities in your search criteria.".$err_string;
		$data['err_no']=17;
		return $SearchQueryReturn;
	}
	if($countryus==1) {
	// Residingusa checking...
	if(is_array($_POST['RESIDINGUSA1'])) {
		$chkzero = 0;
		foreach($_POST['RESIDINGUSA1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$ResidingUsState = "";
				break;
			} else {
				$ResidingUsState .= " ResidingState = $val or ";
			}
		}
		if($chkzero != 1) {
			$ResidingUsState = substr ($ResidingUsState, 0, strlen($ResidingUsState)-3);
		}
	} elseif(trim($_POST['RESIDINGUSA1']) != '') {
		if($_POST['RESIDINGUSA1'] > 0 ) {
			$ResidingUsState = " ResidingState = ". $_POST['RESIDINGUSA1'] . " ";
		} elseif(trim($_POST['RESIDINGUSA1'])==0) {
			$ResidingUsState = "";
		}
	}

	// RESIDINGUSA checking...
	if(trim($ResidingUsState) != '') {
		if($othercountry==1 || $countryindia==1) {
			$usSearchQuery = " or (CountrySelected = 222 and ($ResidingUsState)) ";
		} else {
			$usSearchQuery = " (CountrySelected = 222 and ($ResidingUsState)) ";
		}
	} else {
		if($othercountry==1 || $countryindia==1) {
			$usSearchQuery = " or (CountrySelected = 222) ";
		} else {
			$usSearchQuery = " (CountrySelected = 222) ";
		}
	}
	}

	// Country checking...
	if(trim($CountrySelected) != '') {
		if($countryindia != 1 && $countryus != 1) {
			$SearchQuery .= " and ($CountrySelected) ";
		} else {
			$SearchQuery .= " and ($CountrySelected".$indiaSearchQuery.$usSearchQuery.") ";
		}
	} else {
		if(($_POST['COUNTRY1'] != '') && ($indiaSearchQuery!='' || $usSearchQuery!='')) {
			if($iscountry != 'any') {
				$SearchQuery .= " and (".$CountrySelected.$indiaSearchQuery.$usSearchQuery.") ";
			}
		}
	}

	// RESIDENTSTATUS checking...
	if(is_array($_POST['RESIDENTSTATUS1'])) {
		$chkzero = 0;
		foreach($_POST['RESIDENTSTATUS1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$ResidentStatus = "";
				break;
			} else {
				$ResidentStatus .= " ResidentStatus = $val or ";
			}
		}
		if($chkzero != 1) {
			$ResidentStatus = substr ($ResidentStatus, 0, strlen($ResidentStatus)-3);
		}
	} elseif(trim($_POST['RESIDENTSTATUS1']) != '') {
		if($_POST['RESIDENTSTATUS1'] > 0 ) {
			$ResidentStatus = " ResidentStatus = ". $_POST['RESIDENTSTATUS1'] . " ";
		} elseif(trim($_POST['RESIDENTSTATUS1'])==0) {
			$ResidentStatus = "";
		}
	}

	// RESIDENTSTATUS checking...
	if(trim($ResidentStatus) != '') {
		$SearchQuery .= " and ($ResidentStatus) ";
	}

	if(count($_POST['OCCUPATION1']) > 30) {
		$SearchQueryReturn[0] = "Sorry, you're not permitted to select more than 30 occupations in your search criteria.".$err_string;
		$data['err_no']=18;
		return $SearchQueryReturn;
	}
	// Occupation checking...
	if(is_array($_POST['OCCUPATION1'])) {
		$chkzero = 0;
		foreach($_POST['OCCUPATION1'] as $key => $val) {
			if(trim($val)!="") {
				if($val==99) {
					$chkzero = 1;
					$OccupationSelected = "";
					break;
				} else {
					$OccupationSelected .= " OccupationSelected = $val or ";
				}
			}
		}
		if($chkzero != 1) {
			$OccupationSelected = substr ($OccupationSelected, 0, strlen($OccupationSelected)-3);
		}
	} elseif(trim($_POST['OCCUPATION1']) != '') {
		if($_POST['OCCUPATION1'] != 99 ) {
			$OccupationSelected = " OccupationSelected = ". $_POST['OCCUPATION1'] . " ";
		} elseif(trim($_POST['OCCUPATION1'])==99) {
			$OccupationSelected = "";
		}
	}

	//Occupation category checking....
	if(trim($_POST['OCCCAT'])!=0) {
		$SearchQuery .= " and OccupationCategory=".$_POST['OCCCAT']." ";
	}
	
	// Occupation checking...
	if(trim($OccupationSelected) != '') {
		$SearchQuery .= " and ($OccupationSelected) ";
	}

	// Currency Mode Checking
	if($IncomeCurrency != '' && $IncomeCurrency != 0) {
		$SearchQuery .= " and IncomeCurrency = $IncomeCurrency ";		
	}
	
	// Annual Income Checking
	if($AnnualIncome != '' && $AnnualIncome != 0) {
		$annualinc = explode("-",$AnnualIncome);
		$fromincome = trim($annualinc[0]);
		$toincome = trim($annualinc[1]);
		$SearchQuery .= " and AnnualIncome >= $fromincome and AnnualIncome <= $toincome ";		
	}

	// Star checking...
	if(is_array($_POST['STAR1'])) {
		$chkzero = 0;
		foreach($_POST['STAR1'] as $key => $val) {
			if($val==0) {
				$chkzero = 1;
				$Star = "";
				break;
			} else {
				$Star .= " Star = $val or ";
			}
		}
		if($chkzero != 1) {
			$Star = substr ($Star, 0, strlen($Star)-3);
		}
	} elseif(trim($_POST['STAR1']) != '') {
		if($_POST['STAR1'] > 0 ) {
			$Star = " Star = ". $_POST['STAR1'] . " ";
		} elseif(trim($_POST['STAR1'])==0) {
			$Star = "";
		}
	}

	// Star checking...
	if(trim($Star) != '') {
		$SearchQuery .= " and ($Star) ";
	}

	// Keywords checking...
	if($Keywords != '') {
		$Keywords = str_replace(",", " ", $Keywords);
		$keywordcheck = explode(" ", $Keywords);
		foreach($keywordcheck as $key => $value) {
			$SearchQuery .= " and ProfileDescription like '%$value%' ";
			$track_val .= $value.",";
		}
	}

	// With OtherCity checking...
	if($CountrySelected != '' || $usSearchQuery != '') {
		if(trim($OtherCity) != '') {
			$SearchQuery .= " and ResidingCity like '$OtherCity%' ";
		}
	}

	// With Photo checking... 
	if($PhotoAvailable=='Y') {
		$SearchQuery .= " and PhotoAvailable = 1 ";
	}

	// With Horoscope checking...
	if($HoroscopeAvailable != '' && $HoroscopeAvailable=='Y') {
		$SearchQuery .= " and (HoroscopeAvailable = 1 or HoroscopeAvailable = 2 or HoroscopeAvailable = 3) ";
	}

	// DrinkingHabits checking...
	if ($DrinkingHabits != 0) {
		$SearchQuery .= " and DrinkingHabits = $DrinkingHabits ";
	}

	// SmokingHabits checking...
	if ($SmokingHabits != 0) {
		$SearchQuery .= " and SmokingHabits = $SmokingHabits ";
	}

	// Ignore Checking...
	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && (trim($_REQUEST['SEARCH_TYPE'])=="ADVANCESEARCH" || trim($_REQUEST['SEARCH_TYPE'])=="REGULARSEARCH") ) {
		if($IgnoreOpt=='Y') {
			$SearchQuery .= " <<IGNOREID>> ";
		}
	}

	// Alredy contacted profiles Checking...
	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && (trim($_REQUEST['SEARCH_TYPE'])=="ADVANCESEARCH" || trim($_REQUEST['SEARCH_TYPE'])=="REGULARSEARCH")) {
		if($ContactOpt=='Y') {
			$SearchQuery .= " <<CONTACTID>> ";
		}
	}


	//last login query

	if($DateOpt=="2") {
		$SearchQuery .= " and LastLogin  >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ";
	} else if($DateOpt=="3") {
		$SearchQuery .= " and LastLogin >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL 7 DAY),INTERVAL 1 MONTH)  and LastLogin <=DATE_SUB(CURDATE(), INTERVAL 7 DAY) " ;
	} else if($DateOpt=="4") {
		$SearchQuery .= " and LastLogin >=DATE_SUB(CURDATE(), INTERVAL 4 MONTH) and LastLogin <=DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ";
	} else if($DateOpt=="5") {
		$SearchQuery .= " and LastLogin <=DATE_SUB(CURDATE(), INTERVAL 3 MONTH) ";
	} 



	// Includes Status, Validated, Authorized in query...
	$SearchQuery .= " and Status=0 and Validated=1 and Authorized=1 ";

	// Posted Date Checking...
	if($Days != '') {
		if($Days=='P') {
			if($StDay < 10) {
				$StDay = '0'.$StDay;
			}
			if($StMonth < 10) {
				$StMonth = '0'.$StMonth;
			}
			$PostedDate = $StYear."-".$StMonth."-".$StDay;
		}

		if($Days=='A' && $DateOpt=='C') {
			$OrderBy = " TimeCreated desc ";
		} elseif($Days=='P' && $DateOpt=='C') {
			$SearchQuery .= " and DATE(TimeCreated) > '$PostedDate'  ";
			$OrderBy = " TimeCreated desc ";
		} elseif($Days=='A' && $DateOpt=='U') {
			if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] != '' && $COOKIEINFO['LOGININFO']['ENTRYTYPE']=='F') {
				$OrderBy = " LastLogin desc ";
			} else {
				$OrderBy = " TimePosted desc ";
			}
		} elseif($Days=='P' && $DateOpt=='U') {
			if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] != '' && $COOKIEINFO['LOGININFO']['ENTRYTYPE']=='F') {
				$SearchQuery .= " and DATE(TimePosted) > '$PostedDate'  ";
				$OrderBy = " LastLogin desc ";
			} else {
				$SearchQuery .= " and DATE(TimePosted) > '$PostedDate'  ";
				$OrderBy = " TimePosted desc ";
			}
		}elseif($Days=='A' && $DateOpt=='L') {
			$OrderBy = " LastLogin desc ";
		} elseif($Days=='P' && $DateOpt=='L') {
			$SearchQuery .= " and DATE(LastLogin) > '$PostedDate'  ";
			$OrderBy = " LastLogin desc ";
		} else {
			$OrderBy = " LastLogin desc ";
		}
	} else {
		if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] != '' && $COOKIEINFO['LOGININFO']['ENTRYTYPE']=='F') {
			$OrderBy = " LastLogin desc ";
		} else {
			$OrderBy = " TimePosted desc ";
		}
	}

	// Limiting and Order By the Query...
	$SearchQueryReturn[2] = " order by $OrderBy ";
	$SearchQueryReturn[0] = "";
	$SearchQueryReturn[1] = $SearchQuery;	

	return $SearchQueryReturn;
}

function genQueryForViewSimilarProfile($Similar_Id,$contact=false,$dbcon_from_ei_inbox='',$tablename_from_ei_inbox='') {
	global $dbcon, $langidto_conn, $data, $frm, $matrimonyprofile;

	if($dbcon_from_ei_inbox!="" && $tablename_from_ei_inbox!="") {
		$MemberInfo = getMatrimonyProfileOfUser($Similar_Id,$dbcon_from_ei_inbox,$tablename_from_ei_inbox);
	}
	else {
		$MemberInfo = getMatrimonyProfileOfUser($Similar_Id,$dbcon,$data['matrimonyprofile']);
	}

	if(($MemberInfo != '') && (is_array($MemberInfo)) ) {
		$SimilarGender	 = $MemberInfo['Gender'];
		$SimilarAge      = $MemberInfo['Age'];
		$SimilarHeight   = $MemberInfo['Height'];
		$SimilarCaste    = $MemberInfo['Caste'];
		$SimilarReligion = $MemberInfo['Religion'];
		$SimilarCountry  = $MemberInfo['CountrySelected'];
		$SimilarLanguage = $MemberInfo['Language'];
		$SimilarMotherTongue = $MemberInfo['MotherTongue'];

		// Language checking...
		if(trim($SimilarLanguage) != '' && trim($SimilarLanguage) != '0') {
			$SearchQuery .= " Language = $SimilarLanguage and ";
		}
		// Gender checking...
		if(trim($SimilarGender) != '' && trim($SimilarGender) != '0') {
			$SearchQuery .= " Gender = '$SimilarGender' ";
		}
		// Caste Checking...
		if($SimilarCaste != '' && $SimilarCaste != 0) {
			$SearchQuery .= " and Caste = $SimilarCaste ";
		}
		// Religion Checking...
		if($SimilarReligion != '' && $SimilarReligion != 0) {
			$SearchQuery .= " and Religion = $SimilarReligion ";
		}
		// Age checking...
		$StAge = $SimilarAge - 3;   //
		$EndAge = $SimilarAge + 3;  // 
		if(trim($StAge) != '' && trim($EndAge) != '') {
			$SearchQuery .= " and Age >= $StAge and Age <= $EndAge ";
		}
		// Height Checking...
		$stheight1 = $SimilarHeight - 3;   //
		$endheight1 = $SimilarHeight + 3;  //
		if($stheight1 != '' && $endheight1 != '') {
			$SearchQuery .= " and Height >= $stheight1 and Height <= $endheight1 ";
		}
		// SimilarMotherTongue checking...
		if(trim($SimilarMotherTongue) != '' && trim($SimilarMotherTongue) != '0') {
			$SearchQuery .= " and MotherTongue = $SimilarMotherTongue ";
		}
		// Country Checking...
		if($SimilarCountry != '' && $SimilarCountry != 0) {
			$SearchQuery .= " and CountrySelected = $SimilarCountry ";
		}

		$SearchQuery .= " and MatriId != '$Similar_Id' ";
		$SearchQuery .= " and Status=0 and Validated=1 and Authorized=1";

		$SearchQueryReturn[0] = "";
		$SearchQueryReturn[1] = $SearchQuery;
		$SearchQueryReturn[2] = " order by LastLogin desc";

		dispDebugValue($SearchQueryReturn);		

		return $SearchQueryReturn;
	}
	else {
		$SearchQueryReturn[0] = $data['no_records'];
		$SearchQueryReturn[1] = "";
		$data['err_no']=19;
		dispDebugValue($SearchQueryReturn);
		return $SearchQueryReturn;
	}
}
?>