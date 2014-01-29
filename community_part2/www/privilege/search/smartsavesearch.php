<?php

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
$debug_it['br'] = "<br/><br/>";
include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc");
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";

if($_GET['delete_search_id']!="" && isset($_GET['delete_search_id'])) { // for deleting save search
	echo delete_save_search();
	exit;
}

function setsavesearchcookie($cookievalue) { // set the save search cookie value
	global $GETDOMAININFO;

	$dm1=$GETDOMAININFO['domainnamelong'].".com";
	setrawcookie("SAVESEARCH",$cookievalue, "0", "/",$dm1);
}

function parse_cookie() { // returns the savesearch cookie value as array
	global $COOKIESAVESEARCHINFO, $COOKIESAVESEARCH, $COOKIEINFO;

	list($COOKIESAVESEARCH['savesearch1'], $COOKIESAVESEARCH['savesearch2'], $COOKIESAVESEARCH['savesearch3']) = split("~", $COOKIEINFO['SAVESEARCH']['SAVESEARCH'], 3);

	for($inc=1;$inc<=count($COOKIESAVESEARCH);$inc++) {
		$savenum = "savesearch".$inc ;
		if($COOKIESAVESEARCH[$savenum] != "") {
			list($COOKIESAVESEARCHINFO[$savenum]['encodedsearchid'], $COOKIESAVESEARCHINFO[$savenum]['searchname'], $COOKIESAVESEARCHINFO[$savenum]['searchtype']) = split("\|", $COOKIESAVESEARCH[$savenum], 3);

			$COOKIESAVESEARCHINFO[$savenum]['searchid'] = base64_decode($COOKIESAVESEARCHINFO[$savenum]['encodedsearchid']) ;
			$COOKIESAVESEARCHINFO[$savenum]['searchname'] = urldecode($COOKIESAVESEARCHINFO[$savenum]['searchname']) ;
		}
	}
}

function reset_savesearch_cookie($action,$cookievalue='',$searchid='') { // reset actions of savesearch cookie

	global $COOKIEINFO, $COOKIESAVESEARCHINFO, $COOKIESAVESEARCH;

	if($action == "insert") {
		parse_cookie();
		//$savesearchcookievalue = $COOKIEINFO['SAVESEARCH']['SAVESEARCH'];
		if(is_array($COOKIESAVESEARCHINFO)) {
			$savesearchcookievalue = "";
			foreach($COOKIESAVESEARCHINFO as $SAVENUM=>$SEARCHARRAY) {
				$oldvalues = savesearchcookievalueformation($SEARCHARRAY['searchid'],$SEARCHARRAY['searchname'],$SEARCHARRAY['searchtype']);
				if($savesearchcookievalue != "") {
					$savesearchcookievalue .="~".$oldvalues;
				} else {
					$savesearchcookievalue = $oldvalues;
				}
			}
		} 
		if ($cookievalue != "") { 	
			if($savesearchcookievalue != ""){
				$savesearchcookievalue.="~".$cookievalue;
			} else {
				$savesearchcookievalue = $cookievalue;
			}
		}
		
		setsavesearchcookie($savesearchcookievalue);

	}  elseif($action == "edit") {
			
		parse_cookie();
		if ($cookievalue != "") { 

			foreach($COOKIESAVESEARCHINFO as $SAVENUM=>$SEARCHARRAY) {
				$updatecookievalues = savesearchcookievalueformation($SEARCHARRAY['searchid'],$SEARCHARRAY['searchname'],$SEARCHARRAY['searchtype']);
				if($SEARCHARRAY['searchid'] == $searchid) {
					$updatecookievalues = $cookievalue;
				}

				if($editcookievalue != ""){
					$editcookievalue.="~". $updatecookievalues;
				} else {
					$editcookievalue =  $updatecookievalues;
				}
			}
			setsavesearchcookie($editcookievalue);
		}

	} elseif($action == "delete") {

		parse_cookie();
		foreach($COOKIESAVESEARCHINFO as $SAVENUM=>$SEARCHARRAY) {
			$oldvalues = savesearchcookievalueformation($SEARCHARRAY['searchid'],$SEARCHARRAY['searchname'],$SEARCHARRAY['searchtype']);
			if($SEARCHARRAY['searchid'] != $searchid) {			
				if($deletecookievalue != ""){
					$deletecookievalue.="~". $oldvalues;
				} else {
					$deletecookievalue =  $oldvalues;
				}
			}
		}
		setsavesearchcookie($deletecookievalue);

	}
}


function savesearchcookievalueformation($searchid,$searchname,$searchtype) { // returns the values as cookievalue format
	$cookiesearchid=base64_encode($searchid);
	$cookiesearchname=urlencode(substr($searchname,0,10));
	$cookiesearchtype=strtoupper($searchtype);

	return $cookiesearchid."|".$cookiesearchname."|".$cookiesearchtype;
}


function delete_save_search() {  // deleting the save search
	global $GETDOMAININFO, $DOMAINTABLE, $COOKIEINFO, $DBINFO, $DBNAME, $debug_it;
	$table_savename = $DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['SAVESEARCH'];

	if(isset($_GET['delete_search_id'])) {
		$delete_search_id=base64_decode($_GET['delete_search_id']);
		$db = new db;
		$db->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],"M",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);

		dispDebugValue($db->getDebugParam());		

		$debug_it['err'] .= $debug_it['br'] .$query = "delete from ".$DBNAME['MATRIMONY'].".".$table_savename." where MatriId = '".$COOKIEINFO['LOGININFO']['MEMBERID']."' and SearchId = ".$delete_search_id."";
		$db->del($query);
		dispDebugValue($query);
		$db->dbClose();
		reset_savesearch_cookie('delete','',$delete_search_id);
		return "<font class='smalltxt'>Saved Search deleted successfully</font>";
	}
}


function getSaveSearchNames($rmid='') { // get the savesearch names display in right side

	global $COMMONVARS,$debug_it, $COOKIESAVESEARCHINFO, $COOKIEINFO;
	
	parse_cookie();

	if($COOKIEINFO['LOGININFO']['MEMBERID'] != "") {	
		
		$advance_search_form_link = "search.php?typ=ad";
		$regular_search_form_link = "search.php?";
		$save_search_dropdown = "<select name='search_name' id='search_name' class='inputtext' style='width:204px;font-family:Verdana, arial, Verdana, sans-serif;' size='1'>";
		$save_search_content = "";

		if($COOKIEINFO['SAVESEARCH']['SAVESEARCH'] != "") {
			$save_search_content .= getSavedSearchHiddenquery();	
		}
		
		if(count($COOKIESAVESEARCHINFO)>0) {
			foreach($COOKIESAVESEARCHINFO as $SAVENUM=>$COOKIESEARCHARRAY) {
				if($COOKIESEARCHARRAY['searchtype'] == "A") {
					$h_link = $advance_search_form_link."&sid=".$COOKIESEARCHARRAY['encodedsearchid'];
				}
				else {
					$h_link = $regular_search_form_link."&sid=".$COOKIESEARCHARRAY['encodedsearchid'];
				}
				$save_search_content .= "<div><div id='savedsearch_".$COOKIESEARCHARRAY['searchid']."'><div class='smalltxt'>".stripslashes($COOKIESEARCHARRAY['searchname'])."</div>";
				if($rmid!="rmi"){
				$save_search_content .= "<div class='fright smalltxt' style='padding-left:10px;'><a href='javascript:;' onclick=\"deletesavedsearch_ajax('".$COOKIESEARCHARRAY['encodedsearchid']."', 'savedsearch_".$COOKIESEARCHARRAY['searchid']."')\" class='clr1'>Delete</a> </div><div class='fright smalltxt' style='padding-left:10px;'><a href=\"/search/".$h_link."\" class='clr1'>Edit</a> </div>";
				}
				$save_search_content .="<div class='fright smalltxt'><a href='javascript:savesearchsubmit(\"".$COOKIESEARCHARRAY['searchid']."\",\"".$rmid."\")' class='clr1'>Search</a> </div>";			

				$save_search_content .="<br clear='all'></div></div>";
				$save_search_dropdown .= "<option value='".$COOKIESEARCHARRAY['searchid']."'>".$COOKIESEARCHARRAY['searchname']."</option>";
			}
		}

		$save_search_dropdown .= "</select>";
	}
	$saveret[0] = $save_search_content;
	$saveret[1] = count($COOKIESAVESEARCHINFO);
	$saveret[2] = $save_search_dropdown;
	return $saveret;
}

function populateSaveSearchContent() {
	global $COOKIEINFO, $sid,$savesrch_slave_con,$DBNAME,$DOMAINTABLE,$DBINFO,$data,$ERRORMSG,$GETDOMAININFO, $debug_it;

	$sid = base64_decode($_GET['sid']);
	$chk = is_numeric($sid);

	$savesrch_slave_con = new db;	$savesrch_slave_con->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	dispDebugValue($savesrch_slave_con->getDebugParam());
	if($savesrch_slave_con->error) {
			 errorLanding($ERRORMSG,"smartsavesearch.php");
	}	
	if($chk==true) {
		$debug_it['err'] .= $debug_it['br'] .$savequery = "select MatriId, SearchId, SearchType, SearchName, Language, Gender, MaritalStatus, HaveChildren, StAge, EndAge, StHeight, EndHeight, Religion, Caste, SubCaste, Manglik, Star, Raasi, EatingHabits, MotherTongue, PhysicalStatus, Education, OccupationCategory,OccupationSelected ,Citizenship, Country, ResidingIndia, ResidingDistrict,ResidingUSA, ResidentStatus, Keywords, Days, PostedAfter, DateOpt, PhotoOpt, HoroscopeOpt, IgnoreOpt, ContactOpt, DisplayFormat, PerPage, BodyType, Complexion, IncomeCurrency ,AnnualIncome, Drinking, Smoking, Divstatus from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['SAVESEARCH']." where MatriId='".$COOKIEINFO['LOGININFO']['MEMBERID']."' and SearchId=".$sid."";
		dispDebugValue($savequery);
		$num=$savesrch_slave_con->select($savequery);
		if($num>0) {
			$rec = $savesrch_slave_con->fetchArray();
		}
	} else {
		$sid = "";
	}	
	$savesrch_slave_con->dbClose();
	return $rec;
}


function getSavedSearchHiddenquery() { // returns the query to get hidden forms of saved search

	global $data, $l_top_savesearch_title,$COOKIEINFO,$savesrch_slave_con,$DBNAME,$DOMAINTABLE,$DBINFO,$ERRORMSG,$GETDOMAININFO;
	global $COMMONVARS,$debug_it, $COOKIESAVESEARCHINFO;

	$savesrch_slave_con = new db;		$savesrch_slave_con->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);

	dispDebugValue($savesrch_slave_con->getDebugParam());
	if($savesrch_slave_con->error) {
		 errorLanding($ERRORMSG,"smartsavesearch.php");
	 }

	$debug_it['err'] .= $debug_it['br'] .$QUERY = "select MatriId, SearchId, SearchType, SearchName, Language, Gender, MaritalStatus, HaveChildren, StAge, EndAge, StHeight, EndHeight, Religion, Caste, SubCaste, Manglik, Star, Raasi, EatingHabits, MotherTongue, PhysicalStatus, Education, OccupationCategory,OccupationSelected ,Citizenship, Country, ResidingIndia, ResidingDistrict,ResidingUSA, ResidentStatus, Keywords, Days, PostedAfter, DateOpt, PhotoOpt, HoroscopeOpt, IgnoreOpt, ContactOpt, DisplayFormat, PerPage, BodyType, Complexion, IncomeCurrency ,AnnualIncome, Drinking, Smoking, Divstatus from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['SAVESEARCH']." where MatriId = '".$COOKIEINFO['LOGININFO']['MEMBERID']."'";

	dispDebugValue($QUERY);

	$snum=$savesrch_slave_con->select($QUERY);
	$save_search_content = "";
	if($snum>0) {
		while($SV_ROW = $savesrch_slave_con->fetchArray()) {
			$save_search_content .= getSavedSearchHidden($SV_ROW);				
		}
	}
	$savesrch_slave_con->dbClose();
	return $save_search_content;
}


function getSavedSearchHidden($SV_ROW) { // returns the values of savesearch hidden forms
	global $COMMONVARS;	

	$residingIndia = prefixCountryCode($SV_ROW['ResidingIndia'], '98');
	$residingUsa = prefixCountryCode($SV_ROW['ResidingUSA'], '222');
	$residingState = $residingIndia."~".$residingUsa;
	$residingState = removeLastChar($residingState, "~");
	$residingCity = prefixCountryCode($SV_ROW['ResidingDistrict'], '98');
	$OccupationSelected = $SV_ROW['OccupationSelected'];
	$Education = $SV_ROW['Education'];
	if($SV_ROW['SearchType'] == "A") {
		$searchType = "ADVANCESEARCH";
	}
	else {
		$searchType = "REGULARSEARCH";
	}
	//$OccupationSelected = $SV_ROW['OccupationSelected']?$SV_ROW['OccupationSelected']:"";
	//$Education = $SV_ROW['Education']?$SV_ROW['Education']:"";

	$savedHidden = "<form name='frm_".$SV_ROW['SearchId']."' id='frm_".$SV_ROW['SearchId']."' method=\"post\" action='/search/smartsearch.php?t=".$SV_ROW['SearchType']."'>
	<input type=hidden name=GENDER value='".$SV_ROW['Gender']."'>
	<input type=hidden name=STAGE value='".$SV_ROW['StAge']."'>
	<input type=hidden name=ENDAGE value='".$SV_ROW['EndAge']."'>
	<input type=hidden name=MARITAL_STATUS value='".$SV_ROW['MaritalStatus']."'>
	<input type=hidden name=LANGUAGE value='".$SV_ROW['Language']."'>	
	<input type=hidden name=RELIGION1 value='".$SV_ROW['Religion']."'>
	<input type=hidden name=CASTE1 value='".$SV_ROW['Caste']."'>
	<input type=hidden name=SUBCASTE value='".$SV_ROW['SubCaste']."'>
	<input type=hidden name=STHEIGHT value='".$SV_ROW['StHeight']."'>
	<input type=hidden name=ENDHEIGHT value='".$SV_ROW['EndHeight']."'>	
	<input type=hidden name=CITIZENSHIP1 value='".$SV_ROW['Citizenship']."'>
	<input type=hidden name=COUNTRY1 value='".$SV_ROW['Country']."'>		
	<input type=hidden name=EDUCATION1 value='".$Education."'>";	

	if($SV_ROW['SearchType'] == "A") {
		if($SV_ROW['MaritalStatus']!=0) {
			$savedHidden.="<input type=hidden name=HAVECHILDREN value='".$SV_ROW['HaveChildren']."'>";
		}
		$savedHidden.="<input type=hidden name=MOTHERTONGUE1 value='".$SV_ROW['MotherTongue']."'>
		<input type=hidden name=PHYSICAL_STATUS value='".$SV_ROW['PhysicalStatus']."'>
		<input type=hidden name=RESIDENTSTATUS1 value='".$SV_ROW['ResidentStatus']."'>
		<input type=hidden name=RESIDINGSTATE1 value='".$residingState."'>
		<input type=hidden name=RESIDINGCITY1 value='".$residingCity."'>
		<input type=hidden name=OCCCAT value='".$SV_ROW['OccupationCategory']."'>
		<input type=hidden name=OCCUPATION1 value='".$OccupationSelected."'>
		<input type=hidden name=STAR1 value='".$SV_ROW['Star']."'>
		<input type=hidden name=MANGLIK value='".$SV_ROW['Manglik']."'>
		<input type=hidden name=EATINGHABITS value='".$SV_ROW['EatingHabits']."'>
		<input type=hidden name=DRINKING value='".$SV_ROW['Drinking']."'>
		<input type=hidden name=SMOKING value='".$SV_ROW['Smoking']."'>";
	}

	$savedHidden.="<input type=hidden name=DATE_OPT value='".$SV_ROW['DateOpt']."'>
	<input type=hidden name=PHOTO_OPT value='".$SV_ROW['PhotoOpt']."'>
	<input type=hidden name=HOROSCOPE_OPT value='".$SV_ROW['HoroscopeOpt']."'>
	<input type=hidden name=IGNORE_OPT value='".$SV_ROW['IgnoreOpt']."'>
	<input type=hidden name=CONTACT_OPT value='".$SV_ROW['ContactOpt']."'>
	<input type=hidden name=DISPLAY_FORMAT value='one'>
	<input type=hidden name='randid'>
	<input type=hidden name=but_save value=''>
	<input type=hidden name=SEARCH_TYPE value='".$searchType."'>
	<input type=hidden name=SEARCH_ID value='".$SV_ROW['SearchId']."'>";	
	if($_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]==$COMMONVARS['SMART_DEBUG_VAL'] && $_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]!="") {
	$savedHidden.= '<input type=hidden name="'.$COMMONVARS['SMART_DEBUG_PARAM'].'" value="'.$COMMONVARS['SMART_DEBUG_VAL'].'">'; 
	}

	$savedHidden.="</form>";
	return $savedHidden;
}

function prefixCountryCode($stateval, $countryCode) {
	$stateArr = explode("~", $stateval);
	$newStateVal = '';
	foreach($stateArr as $key => $value) {
		if($value) {
			$newStateVal .= $countryCode.$value."~";
		}
	}
	return removeLastChar($newStateVal, "~");
}

function updatesavesearch() { // perform insert or delete action of savesearch
	global $COOKIEINFO, $DOMAINTABLE, $DBNAME, $DBINFO, $dbcon_save,$table_savename,$debug_it;

	$dmarr = getDomainInfo(1, trim($COOKIEINFO['LOGININFO']['MEMBERID']));
	$domainname = strtoupper($dmarr['domainnameshort']); //language

	$dbcon_save = new db;
	$dbcon_save->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	dispDebugValue($dbcon_save->getDebugParam());
	$table_savename = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[$domainname]['SAVESEARCH'];

	if($_POST['search_name']!='') {

		$search_name=$_POST['search_name'];
		$search_escape_name=$dbcon_save->dbEscapeQuotes($search_name);

		if($_POST['SEARCH_ID'] != "") {
			$SearchId = $_POST['SEARCH_ID'];
			$update = save_performaction($SearchId);

		} else {
	
			$debug_it['err'] .= $debug_it['br'] .$selectsavequery ="select MatriId, SearchId, SearchType, SearchName from ".$table_savename." where MatriId = '".$COOKIEINFO['LOGININFO']['MEMBERID']."' group by SearchId";
			dispDebugValue($selectsavequery);	
			$cnt = $dbcon_save->select($selectsavequery);
			
			if($cnt > 0) {
				$as1=array(1,2,3);
				$as2= $as3 = $availablesearchnames = array();
				while($total=$dbcon_save->fetchArray()) {
					array_push($as2,$total['SearchId']);
					//$availablesearchnames[$total['SearchId']] = $total['SearchName'];
				}
				$as3=array_diff($as1,$as2);
				asort($as3);
				reset($as3);
				$total_save=current($as3);
			} 

			if(isset($total_save)) {
				$SearchId=$total_save;
			} else {
				$SearchId=1;
			}
		}
	

		$name_exists = checkSearchNameExists ($SearchId,$search_escape_name);

		$ERR_MSG = perform_savesearch($name_exists,$update,$SearchId,$cnt,$table_savename,$search_escape_name);
	} else {

		$ERR_MSG="The search name can not be empty.";

	}
	$dbcon_save->dbClose();
	return $ERR_MSG;
}

function perform_savesearch($name_exists,$update,$SearchId,$cnt,$table_savename,$search_escape_name) {

	global $COOKIEINFO, $DBINFO, $DBNAME;

	$ERR_MSG="The following are search results based on your Saved Search criteria.";

	if($name_exists == 1) {
		$ERR_MSG="You have already with this name, Please try with different search name.";
	} 
	else {			
		$db_mas = new db;
		$db_mas->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],"M",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
		dispDebugValue($db_mas->getDebugParam());

		if($update=='Y') {
			updatesavequery($table_savename,$db_mas,$SearchId,$search_escape_name);
		} 
		else {
			if($cnt<3) {
				insertsavequery($table_savename,$db_mas,$SearchId,$search_escape_name);
			}					
			else {
				$ERR_MSG="Your search has not been saved as you have reached the maximum limit of searches that can be saved. If you would like to save more searches in the future, please delete one of your existing saved searches.";
			}
		}					
		$db_mas->dbClose();	
	}
	return $ERR_MSG;
}



function insertsavequery($table_savename,$db_mas,$SearchId,$search_escape_name) { // inserting the save search
	global $COOKIEINFO, $debug_it;

	list($dbfields,$savesearchvalues,$save_type) = split("#######",queryformation('insert',$SearchId,$search_escape_name));

	$debug_it['err'] .= $debug_it['br'] .$sql = "insert into ".$table_savename."(".$dbfields.") values(".$savesearchvalues.")";
	dispDebugValue($sql);
	$db_mas->insert($sql);

	$cookievalue = savesearchcookievalueformation($SearchId,$search_escape_name,$save_type);
	
	reset_savesearch_cookie('insert',$cookievalue);
}

function updatesavequery($table_savename,$db_mas,$SearchId,$search_escape_name) {// updating the save search

	global $COOKIEINFO, $debug_it;

	list($updatevalues, $save_type) = split("#######",queryformation('update',$SearchId,$search_escape_name));

	$debug_it['err'] .= $debug_it['br'] .$sql="update ".$table_savename." set ".$updatevalues." where MatriId = '".$COOKIEINFO['LOGININFO']['MEMBERID']."' and SearchId =".$SearchId;
	dispDebugValue($sql);
	$db_mas->update($sql);

	$cookievalue = savesearchcookievalueformation($SearchId,$search_escape_name,$save_type);

	reset_savesearch_cookie('edit',$cookievalue,$SearchId);
}


function queryformation($action,$SearchId,$search_escape_name) {// return the posted save search values and query values

	global $COOKIEINFO, $RESIDINGINDIANAMES, $RESIDINGUSANAMES;

	$save_type=$_POST['SAVE_TYPE'];

	$gender         = $_POST['GENDER'];
	$stage          = $_POST['STAGE'];
	$endage         = $_POST['ENDAGE'];
	$stheight       = $_POST['STHEIGHT'];
	$endheight      = $_POST['ENDHEIGHT'];
	$subcaste       = $_POST['SUBCASTE'];
	$days           = $_POST['DAYS'];
	$display_format = $_POST['DISPLAY_FORMAT'];

	if($days=='P') {
		$stmonth=$_POST['ST_MONTH'];
		$stday=$_POST['ST_DAY'];
		$styear=$_POST['ST_YEAR'];
		$postdate=$styear."-".$stmonth."-".$stday;
	}
	$dateopt=$_POST['DATE_OPT'];
	$photoopt=$_POST['PHOTO_OPT'];
	if($photoopt!='Y') {
		$photoopt='N';
	}
	$horoscope=$_POST['HOROSCOPE_OPT'];
	if($horoscope!='Y') {
		$horoscope='N';
	}
	$ignoropt=$_POST['IGNORE_OPT'];
	if($ignoropt!='Y') {
		$ignoropt='N';
	}
	$contactopt=$_POST['CONTACT_OPT'];
	if($contactopt!='Y') {
		$contactopt='N';
	}
	$perpage=$_POST['PERPAGE']?$_POST['PERPAGE']:'0';

	$marital   = getArrayFldVal('MARITAL_STATUS');
	$language  = getArrayFldVal('LANGUAGE');
	$religion  = getArrayFldVal('RELIGION1');
	$caste     = getArrayFldVal('CASTE1');
	$education = getArrayFldVal('EDUCATION1');
	$citizen   = getArrayFldVal('CITIZENSHIP1');
	$country   = getArrayFldVal('COUNTRY1');

	// ONLY FOR ADVANCE SEARCH //
	$havechildren='';
	if($save_type=='A') {
		$havechildren=$_POST['HAVECHILDREN'];
		if(!isset($havechildren)) {
			$havechildren=1;
		}
	}
	$manglik=$_POST['MANGLIK'];
	$eating=$_POST['EATINGHABITS'];
	$drinking=$_POST['DRINKING'];
	$smoking=$_POST['SMOKING'];
	$star=getArrayFldVal('STAR1');
	$_status=$_POST['Divstatus'];	
	$occupation_cat=$_POST['OCCCAT'];//occupation category
	$mothertongue=getArrayFldVal('MOTHERTONGUE1');
	$physical_status=$_POST['PHYSICAL_STATUS'];

	$occupation=getArrayFldVal('OCCUPATION1');

	$res_states=split("~~~",savesearchStateIds($_POST['RESIDINGSTATE1'],$RESIDINGINDIANAMES,$RESIDINGUSANAMES));
	$res_india=$res_states[0];
	$res_usa=$res_states[1];

	if($_POST['RESIDINGCITY1']) {
		$res_city=$_POST['RESIDINGCITY1']; 
		if(is_array($res_city)) {
			foreach($res_city as $key=>$val) {
				$city_arr_id[]=substr($val,2,strlen($val));
			}
			$res_city=saveSearchGetArray($city_arr_id);
		}
	}

	$res_status=getArrayFldVal('RESIDENTSTATUS1');
	$keyword=$_POST['KEYWORDS'];

	if($action == "update") {

		if($save_type == 'R') {

			$queryvalues = "SearchName = '".$search_escape_name."',Language ='".$language."',Gender ='".$gender."',MaritalStatus = '".$marital."',StAge = ".$stage.",EndAge = ".$endage.",StHeight='".$stheight."',EndHeight='".$endheight."',Religion='".$religion."',Caste='".$caste."',SubCaste='".$subcaste."',Education='".$education."',Citizenship='".$citizen."',Country='".$country."',Days='".$days."',PostedAfter='".$postdate."',DateOpt='".$dateopt."',PhotoOpt='".$photoopt."',HoroscopeOpt='".$horoscope."',IgnoreOpt='".$ignoropt."',ContactOpt='".$contactopt."',DisplayFormat='".$display_format."',PerPage=".$perpage;

		} else {

			$queryvalues = "SearchName = '".$search_escape_name."',Language='".$language."',Gender='".$gender."',MaritalStatus='".$marital."',HaveChildren=".$havechildren.",StAge=".$stage.",EndAge=".$endage.",StHeight='".$stheight."',EndHeight='".$endheight."',Religion='".$religion."',Caste='".$caste."',SubCaste='".$subcaste."',Manglik='".$manglik."',EatingHabits='".$eating."',Drinking='".$drinking."',Smoking='".$smoking."',MotherTongue='".$mothertongue."',PhysicalStatus='".$physical_status."',Education='".$education."',OccupationCategory='".$occupation_cat."',OccupationSelected='".$occupation."',Citizenship='".$citizen."',Country='".$country."',ResidingIndia='".$res_india."',ResidingUSA='".$res_usa."',ResidingDistrict='".$res_city."',Star='".$star."',ResidentStatus='".$res_status."',Keywords='".$keyword."',Days='".$days."',PostedAfter='".$postdate."',DateOpt='".$dateopt."',PhotoOpt='".$photoopt."',HoroscopeOpt='".$horoscope."',IgnoreOpt='".$ignoropt."',ContactOpt='".$contactopt."',DisplayFormat='".$display_format."',PerPage=".$perpage." ,Divstatus='".$_status."'";
		}

		return $queryvalues."#######".$save_type;

	} elseif($action == "insert") {

		if($save_type == 'R') {

			$dbfields = "MatriId,SearchId,SearchType,SearchName,Language,Gender,MaritalStatus,StAge,EndAge,StHeight,EndHeight,Religion,Caste,SubCaste,Education,Citizenship,Country,Days,PostedAfter,DateOpt,PhotoOpt,HoroscopeOpt,IgnoreOpt,ContactOpt,DisplayFormat,PerPage";
			
			$savesearchvalues = "'".$COOKIEINFO['LOGININFO']['MEMBERID']."',".$SearchId.",'".$save_type."','".$search_escape_name."','".$language."','".$gender."','".$marital."',".$stage.",".$endage.",'".$stheight."','".$endheight."','".$religion."','".$caste."','".$subcaste."','".$education."','".$citizen."','".$country."','".$days."','".$postdate."','".$dateopt."','".$photoopt."','".$horoscope."','".$ignoropt."','".$contactopt."','".$display_format."',".$perpage;


		} else {
			$dbfields = "MatriId,SearchId,SearchType,SearchName,Language,Gender,MaritalStatus,HaveChildren,StAge,EndAge,StHeight,EndHeight,Religion,Caste,SubCaste,Manglik,EatingHabits,Drinking,Smoking,MotherTongue,PhysicalStatus,Education,OccupationCategory,OccupationSelected,Citizenship,Country,ResidingIndia,ResidingUSA,ResidingDistrict,Star,ResidentStatus,Keywords,Days,PostedAfter,DateOpt,PhotoOpt,HoroscopeOpt,IgnoreOpt,ContactOpt,DisplayFormat,PerPage,Divstatus";

			$savesearchvalues = "'".$COOKIEINFO['LOGININFO']['MEMBERID']."',".$SearchId.",'".$save_type."','".$search_escape_name."','".$language."','".$gender."','".$marital."',".$havechildren.",".$stage.",".$endage.",'".$stheight."','".$endheight."','".$religion."','".$caste."','".$subcaste."','".$manglik."','".$eating."','".$drinking."','".$smoking."','".$mothertongue."','".$physical_status."','".$education."','".$occupation_cat."','".$occupation."','".$citizen."','".$country."','".$res_india."','".$res_usa."','".$res_city."','".$star."','".$res_status."','".$keyword."','".$days."','".$postdate."','".$dateopt."','".$photoopt."','".$horoscope."','".$ignoropt."','".$contactopt."','".$display_format."',".$perpage.",'".$_status."'";

		}
		return $dbfields."#######".$savesearchvalues."#######".$save_type;
	}		
}

function checkSearchNameExists ($search_id_up,$search_escape_name) { // check whether the savesearch name exist already
	global $COOKIESAVESEARCHINFO;

	parse_cookie();
	$search_arrayname = array();
	
	foreach($COOKIESAVESEARCHINFO as $savenum=>$searchcookie) {	
		$search_arrayname[$searchcookie['searchid']] = $searchcookie['searchname'];
	}

	if(is_array($search_arrayname)) {
		$searchidkey = array_search($search_escape_name, $search_arrayname);		
		if(($searchidkey !== false) && ($searchidkey != $search_id_up)) {		
			return 1;
		} else {
			return 0;
		}	
	} else {
		return 0;
	}
}

function save_performaction($search_id_update) {// decide insert or update the search
	global $COOKIESAVESEARCHINFO;
	parse_cookie();
	$save_action = "N";
	$searchidarray = array();

	foreach($COOKIESAVESEARCHINFO as $savenum=>$searchcookie) {
		array_push($searchidarray,$searchcookie['searchid']);
	}

	$key = array_search($search_id_update, $searchidarray);	
	if($key !== false){
		$save_action = "Y";
	}

	return $save_action;
}

function saveSearchStateIds($statearr,$RESIDINGINDIANAMES,$RESIDINGUSANAMES) {	
	if(is_array($statearr)) {
		foreach($statearr as $key=>$val) {
			$india_val=substr($val,0,2);
			$usa_val=substr($val,0,3);
			if($usa_val==222) {
				$result_usa_val=substr($val,3,strlen($val));
				foreach($RESIDINGUSANAMES as $k=>$v) {
					if($k==$result_usa_val) {
						$usa_state_arr_id[]=$result_usa_val;
					}
				}
			}
			if($india_val==98) {
				$result_ind_val=substr($val,2,strlen($val));
				foreach($RESIDINGINDIANAMES as $k=>$v) {
					if($k==$result_ind_val) {
						$india_state_arr_id[]=$result_ind_val;
					}
				}
			}
		}
		$ind_sta_id='';$usa_sta_id='';
		$usa_sta_id=saveSearchGetArray($usa_state_arr_id);
		$ind_sta_id=saveSearchGetArray($india_state_arr_id);
		$state_ids=$ind_sta_id."~~~".$usa_sta_id;  	
		return $state_ids; 
	}
} 

function saveSearchGetArray($state_arr_id) {
	$sta_id='';
	for($i=0;$i<count($state_arr_id);$i++) {
		if($i==0) {
			$sta_id.=$state_arr_id[0];
		}
		else {
			$sta_id.="~".$state_arr_id[$i];
        }
	} 
	return $sta_id;
}
?>