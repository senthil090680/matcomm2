<?php
/***********************************************************************************************************
 FILENAME			: smartcommoninc.php  
 AUTHOR			    : SARAVANNAN,ANDAL.V	
 Date				:  03-Jan-2008
 *****************************************************************************************************
Description	: 
This includes common files to display search results.
***********************************************************************************************************/

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvars.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearch.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";

include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearchformarren.inc";

include_once "smartquery.php";
include_once "smartsubdomains.php";

$data['log_search']=0;
assign_vars_basedon_display_format();

$data['split_char']			= "#~^*^~#";
$data['recordperquery']		= $data['pagesperrequest'] * $data['profilesperpage'];
$data['desccount']			= 130;
$data['already_contacted']	= 3000;
$data['already_ignored']	= 3000;
$data['no_records']			= "Sorry, we couldn't find any results to suit your search criteria. Perhaps your search was too specific? Try choosing broader categories. If after refining your search criteria you continue to face similar problems, Kindly clear your cache or refresh your browser.";

$data['bmimage'] = "srch_image";
$data['en_img']	= "en_img";
$data['Jsg_br'] = getBrowserDetails();
if($data['Jsg_br']=="O") { /* img tag change opera browser */
	$data['bmimage'] = "img";
	$data['en_img']	= "img";
}

function newSmartDbConn() {
	global $DBINFO,$COOKIEINFO,$DBNAME,$MERGETABLE,$GLOBALS,$DOMAINARRAY,$DOMAINTABLE, $data,$ERRORMSG,$COMMONVARS, $GETDOMAININFO;
	$search_langid = splitFormValue($_POST['LANGUAGE']); 

	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID'] != "") {/*logged in member*/
		$db_slave = new db;	
		$db_slave->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
		if(is_array($search_langid) && $GETDOMAININFO['domainid']==$search_langid[0] && count($search_langid)==1) { /*same domain search(single domain)*/
			$db[0] = $DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['MATRIMONYPROFILE'];
			$db[1] = $DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['PHOTOINFO']; 
			$db[2] = $db_slave;
		}
		else {  /*cross/multiple domain search*/
			$db[0] = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE']; 
			$db[1] = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO']; 
			$db[2] = $db_slave;			
		}
	} 
	else { /* visitor */
		$dm_short_name="";
		if(count($search_langid)==1 ) {
			$dm_short_name = $GLOBALS['DOMAINNAME'][$search_langid[0]];
		}
		if(is_array($search_langid) && count($search_langid)==1 && $search_langid[0]!=0 && $dm_short_name!="" && $dm_short_name!='bharat') { /*single domain search*/
			$db_slave=new db;
			$db_slave->dbConnById(3,$dm_short_name,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
			$db[0] = $DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($dm_short_name)]['MATRIMONYPROFILE']; 
			$db[1] = $DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($dm_short_name)]['PHOTOINFO']; 
			$db[2] = $db_slave;
		}
		else { 
			$db_slave=new db; /*any domain (more than one domain*/			
			$db_slave->dbConnById(3,$GETDOMAININFO['domainnameshort'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
			$db[0] = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE'];
			$db[1] = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO'];
			$db[2] = $db_slave;
		}
    }

	if($db_slave->error) {
		$data['err_no']=2;
		$data['error_msg'] = "We are currently experiencing technical difficulties. Please try again later.<span onclick=\"javascript:$load_currentpage('one','imgonload')\"><font class=\"cstyle\">Sorry, Server response time is very low. Please <b>click here</b> to try again.</font></span>";

		dispDebugValue($db_slave->getDebugParam());

		return throwErrorJson($data['error_msg']);
	}
	else {
		return $db;
	}
}

function formValuesValidation() {
	global $frm;
	if(!(isset($_REQUEST['randid']))) { 
		$_REQUEST['randid'] = rand(1000000,9999999);
		
		$frm['hidden_fields'] .= "<input type='hidden' name='randid' value='".$_REQUEST['randid']."'>";
	}
	if($_POST) {
		if(!isset($_POST['STHEIGHT']) || $_POST['STHEIGHT']=="") 
			$_POST['STHEIGHT']=1;
		if(!isset($_POST['ENDHEIGHT']) || $_POST['ENDHEIGHT']=="") 
			$_POST['ENDHEIGHT']=37;
	}

	if(trim($_REQUEST['DISPLAY_FORMAT'])=="" || $_REQUEST['DISPLAY_FORMAT']=="undefined") { $_REQUEST['DISPLAY_FORMAT']="one"; }
}

function showCookieName() {
	global $data;
	if($_REQUEST['SEARCH_TYPE']=="ADVANCESEARCH") {
		$data['cname_preffix']	 = "bmw_A_";
		$data['page_preffix']	 = "page_A_";
		$data['search_type']	 = "Advanced";
		$data['search_form_page']="search.php?typ=ad";
	} 
	else if($_REQUEST['SEARCH_TYPE']=="REGULARSEARCH") {
		$data['cname_preffix']	 = "bmw_R_";
		$data['page_preffix']	 = "page_R_";
		$data['search_type']	 = "Regular";
		$data['search_form_page']="search.php";
	}
	else if($_REQUEST['SEARCH_TYPE']=="SIMILAR") {
		$data['cname_preffix']	 = "bmw_S_";
		$data['page_preffix']	 = "page_S_";
		$data['search_type']	 = "Similar Profiles";
		$data['search_form_page']="search.php";
	} 
	else if($_REQUEST['SEARCH_TYPE']=="KEYWORD") {
		$data['cname_preffix']	 = "bmw_K_";
		$data['page_preffix']	 = "page_K_";
		$data['search_type']	 = "Keyword";
		$data['search_form_page']="smartkeywordsearch.php";
	} 
	else if($_REQUEST['SEARCH_TYPE']=="members_online" || $_REQUEST['SEARCH_TYPE']=="whos_online") {
		$data['cname_preffix']	 = "bmw_M_";
		$data['page_preffix']	 = "page_M_";
		$data['search_type']	 = "Members online";
		$data['search_form_page']="smartmembersonline.php";
	} 
	else {
		$data['cname_preffix']	 = "bmw_Q_";
		$data['page_preffix']	 = "page_Q_";
		$data['search_type']	 = "Quick";
		$data['search_form_page']="search.php";
	}

	$data['cname'] = $data['cname_preffix'].$_REQUEST['randid'];
	
	$data['cblock']	 = ceil($_GET['cpage'] / $data['pagesperrequest']);

	$data['orderby_varname'] = 'orderby_'.$_REQUEST['randid'];

	$data['limit_from']	 = (($data['cblock']-1) * $data['pagesperrequest']) * $data['profilesperpage']; /*to build the query limit */ 

	if($data['limit_from'] && $data['limit_from']>0) {
		$data['limit'] = " LIMIT ".$data['limit_from']." , ".$data['recordperquery']; 
	} 
	else {
		$data['limit'] = " LIMIT 0, ".$data['recordperquery'];
	} 

	switch($_POST['DATE_OPT']) {
		case "U":
			$data['orderby'] = " order by TimePosted desc";
			break;
		case "L":
			$data['orderby'] = " order by LastLogin desc";
			break;
		case "C":
			$data['orderby'] = " order by TimeCreated desc";
			break;
		default:
			$data['orderby'] = " order by LastLogin desc";
	}
}

function throwErrorJson($error_msg) { //0=>no error (+ or -) 1=> postivie error >1 negative error
	global $data;
	if($error_msg!="") {
		$tp = $data['err_no'].$data['split_char'].urlencode($error_msg);
		if($data['debug_val']!="") {
			$tp .= $data['split_char'].$data['debug_val'];
		}
		echo $tp; exit;
	}
}

function getTotalRecords() {
	global $data, $frm, $dbcon, $COOKIEINFO, $COMMONVARS;

	//$count_query = "select count(MatriId) as num from ".$data['matrimonyprofile']." where ".$data['where'];
	//$dbcon->query=$count_query;
	//$dbcon->execute();
	
	$count_query = "select count(MatriId) as num from ".$data['matrimonyprofile']." where ".$data['where'];
	$dbcon->select($count_query);

	dispDebugValue($count_query);

	$total_profiles_sql = $dbcon->fetchArray();
	if(!$total_profiles_sql) {
		$data['err_no'] = 4;		
		$data['error_msg'] = $count_query;
	}
	return $total_profiles_sql['num'];
}

function profileNoteChecking($icon_row='') {/* Profile Note checking for LastAction */
	$temp['Bookmarked'] = "N";
	$temp['Blocked'] = "N";
	$temp['Ignored'] = "N";
	
	if(trim($icon_row['Bookmarked'])==1) {// Bookmark Icon Checking //
		$temp['Bookmarked'] = "Y";
	}		
	if($icon_row['Blocked']==1) {// Blocked Icon Checking //
		$temp['Blocked'] = "Y";
	}		
	if($icon_row['Ignored']==1) {// Ignore Icon Checking //
		$temp['Ignored'] = "Y";
	}		
	if ($icon_row['IntRec'] == 'Y') {/* Contact Summary Icon Checking */
		$temp['LastAction'] = "IR";
	} 
	elseif ($icon_row['IntSen'] == 'Y') {
		$temp['LastAction'] = "IS";
	} 
	elseif ($icon_row['MsgSen'] == 'Y') {
		$temp['LastAction'] = "MS";
	} 
	elseif ($icon_row['MsgRec'] == 'Y') {
		$temp['LastAction'] = "MR";
	} 
	elseif ($icon_row['MsgRep'] == 'Y') {
		$temp['LastAction'] = "MP";
	} 
	elseif($icon_row['MsgDec'] == 'Y') {
		$temp['LastAction'] = "MD";
	} 
	else {
		$temp['LastAction'] = "N";
	}
	$CI = $temp['Bookmarked']."^".$temp['Blocked']."^".$temp['Ignored']."^".$temp['LastAction'];
	if($CI=="") { $CI = "N^N^N^N"; }
	return $CI;
}

function replaceSymbols($res='') {
	$res = str_replace("&lt;![","<![",$res);
	$res = str_replace("]]&gt;","]]>",$res);
	$res = str_replace("&#13;","",$res);
	$res = str_replace("&amp;lt;![","<![",$res);
	$res = str_replace("]]&amp;gt;","]]>",$res);
	$res = str_replace("\n","",$res);
	return $res;
}

function dateFormatFunc ($dttime='') {
	return date ("d-M-Y", mktime($dttime[3],$dttime[4],0,$dttime[1],$dttime[2],$dttime[0]));
}

function checkEntryType($db_EntryType='',$db_SpecialPriv='') {
	global $data;
	if($db_EntryType=='R') {
		if($db_SpecialPriv==1) {
			$data['border_style'] = $db_SpecialPriv;
		}
		else if($db_SpecialPriv==2) {
			$data['border_style'] = $db_SpecialPriv;
		}
		else {
			$data['border_style'] = 0;
		}
	}
	else {
		$data['border_style'] = 0;
	}
}

function checkExpressInterestLink($Gender) {
	global $data, $COOKIEINFO;
	if($COOKIEINFO['LOGININFO']['ENTRYTYPE']=='' && $COOKIEINFO['LOGININFO']['MEMBERID']=='') {
		$data['Express_Interest_Link'] = 0;			
	} 
	else if($COOKIEINFO['LOGININFO']['ENTRYTYPE']!='F') {
		$data['Express_Interest_Link'] = 2;
	} 
	else if($COOKIEINFO['LOGININFO']['ENTRYTYPE']=='F') {
		$data['Express_Interest_Link'] = 1;
	} 

	if($Gender==$COOKIEINFO['LOGININFO']['GENDER']) {
		$data['Express_Interest_Link'] = 3;
	}
}

function getContactIgnoreids() {
	global $data, $COOKIEINFO;

	if(preg_match("/<<IGNOREID>>/",$data['where'])) {
		$ids = getIgnoreDetails();
				
		if($ids != '') {
			$QRY = " and MatriId NOT IN ($ids) ";
			$data['where'] = str_replace("<<IGNOREID>>",$QRY,$data['where']);
		} 
		$data['where'] = str_replace("<<IGNOREID>>","",$data['where']);
	}

	if(preg_match("/<<CONTACTID>>/",$data['where'])) {
		$ids = getContactDetails();
		if($ids != '') {
			$QRY = " and MatriId NOT IN ($ids) ";
			$data['where'] = str_replace("<<CONTACTID>>",$QRY,$data['where']);
		} 
		$data['where'] = str_replace("<<CONTACTID>>","",$data['where']);
	}

	$data['where'] = str_replace("<<CONTACTID>>","",$data['where']);
	$data['where'] = str_replace("<<IGNOREID>>","",$data['where']);
}

function getIgnoreDetails() {/* Get Ignore Details...*/
	global $dbcon,$data,$DOMAINTABLE,$COOKIEINFO,$DBNAME,$GETDOMAININFO;

	if($COOKIEINFO['LOGININFO']['MEMBERID'] != '') {
		$ignoredids="";
	 	$sql = "select PartnerId from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['PROFILENOTES']." where MatriId = '".$COOKIEINFO['LOGININFO']['MEMBERID']."' and Ignored = 1";
		$num_rows=$dbcon->select($sql);	

		dispDebugValue($sql);

		if($num_rows>$data['already_ignored']) {
			$data['upper_ig_limit']="e";
			return "";
		} 
		else {
			while($row = $dbcon->fetchArray()) {
				$ignoredids .= "'".$row['PartnerId']."',";
			}
			return substr ($ignoredids, 0, strlen($ignoredids)-1);
		}
	}
}

function getContactDetails() { /* Get already contacted Details...*/
	global $dbcon,$data,$DBNAME,$DOMAINTABLE,$COOKIEINFO,$DBNAME,$GETDOMAININFO;

	if($COOKIEINFO['LOGININFO']['MEMBERID'] != '') {	
		$contactids="";
		$sql = "select PartnerId as sentid from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['PROFILENOTES']." where MatriId = '".$COOKIEINFO['LOGININFO']['MEMBERID']."' and (InterestReceived=1 or MessageReceived=1 or InterestSent=1 or MessageSent=1)";
		$num_rows=$dbcon->select($sql);

		dispDebugValue($sql);

		if($num_rows>$data['already_contacted']) {
			$data['upper_con_limit']="e";			
			return "";
		} 
		else {
			while($row = $dbcon->fetchArray()) {
				$a=substr_count($contactids,$row['sentid']);
				if($a==0) {
					$contactids .= "'".$row['sentid']."',";
				}
			}
			return substr ($contactids, 0, strlen($contactids)-1);
		}
	}
}

function chkUndefinedValue($name,$ageflag='') {
	if($_POST[$name]=="undefined" || $_POST[$name]==undefined) { 
		if($ageflag!='') {
			$_POST[$name] = $ageflag;
		} 
		else {
			$_POST[$name] = "";
		}
	}
}

function microtimeFloat() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

function smartGetPhotoInfoOfUser($id='') {
	global $data,$dbcon;
	$photo_array=""; $phots=0;
	if(is_array($id)) {
		$ids = "in (";
		foreach($id as $id1) {
			$phots = 1;
			$ids .= "'".trim($id1)."',";
		}
		$ids = removeLastChar($ids,",");
		$ids .= ")";
	} 
	else {
		$ids = "= '".$ids."'";
	}

	$sql = "SELECT MatriId,PhotoProtected, ThumbImgs1,ThumbImgs2,ThumbImgs3,ThumbImgs4,ThumbImgs5,ThumbImgs6,ThumbImgs7,ThumbImgs8,ThumbImgs9,ThumbImgs10,PhotoStatus1,PhotoStatus2,PhotoStatus3,PhotoStatus4,PhotoStatus5,PhotoStatus6,PhotoStatus7,PhotoStatus8,PhotoStatus9,PhotoStatus10"; 

	if($_REQUEST['DISPLAY_FORMAT']=="one") {
		$sql .= ",ThumbImg1,ThumbImg2,ThumbImg3,ThumbImg4,ThumbImg5,ThumbImg6,ThumbImg7,ThumbImg8,ThumbImg9,ThumbImg10";
	}	
	
	$sql .= " from ".$data['photoinfo']." where MatriId ".$ids;
	if($ids!="" && $id!="" && $phots==1) {
		//$dbcon->query=$sql;
		//$dbcon->execute();
		//$numrows=$dbcon->getNumRows();
		$numrows=$dbcon->select($sql);
	}

	dispDebugValue($sql);

	if($numrows > 0) {
		$photo_array = array();
		while($row = $dbcon->fetchArray()) {
			$row['MatriId'] = trim(strtoupper($row['MatriId']));
			$photo_array[$row['MatriId']] = $row;
		}
	}
	return $photo_array;
}

function getJsVarBasedOnSubDomain() {
	global $common_server_name,$common_subdomain_name, $common_subdomains,$data,$bharat_subdomains,$GETDOMAININFO,$COMMONVARS;
	$sn = $GETDOMAININFO['domainnameshort']."matrimony.com";
	echo "var Jsg_serv_name=\"".$sn."\";";
	echo "var Jsg_subdomain=true;";
	echo "var Jsg_qry=0;";

	if(in_array($common_server_name,$bharat_subdomains)) {
		$sub_domain = smartSubDomainName();
		$sn = $sub_domain.".".$sn;
		echo "Jsg_viewprofile_link=\"http://".$sn."/profiledetail/viewprofile.php?id=\";";
		echo "var Jsg_requesturl=\"http://".$sn."/privilege/search/smartdynamic.php?ID=".$_REQUEST['ID']."&\";";
	}  
	else {
		echo "var Jsg_subdomain=false;";
		echo "Jsg_viewprofile_link=\"http://".$GETDOMAININFO['domainmodule']."/profiledetail/viewprofile.php?id=\";";
		echo "var Jsg_requesturl=\"http://".$GETDOMAININFO['domainmodule']."/privilege/search/smartdynamic.php?ID=".$_REQUEST['ID']."&\";";
	}
}

function getFormPostValues() {
	global $frm, $data;
	global $STAGE,$ENDAGE,$STHEIGHT,$ENDHEIGHT,$EDUCATION1,$OCCUPATION1,$COUNTRY1,$CASTE1, $HOROSCOPE_OPT, $PHOTO_OPT,$keytext,$wdmatch;

	foreach($_POST as $varname => $varval) {
		$varval1="";
		if(is_array($varval)) {
			foreach($varval as $val) {
				$varval1 .= $val."~";
			} 
			$varval = removeLastChar($varval1,"~");
		}

		if(!(in_array($varname, $frm['rs_field_array']))) {
			$frm['hidden_fields'] .= "<input type='hidden' name='".$varname."' value='".$varval."'>";
			$fieldlist .= "'".$varname."',";
		}
		else {
			$$varname=$varval;
		}
		$varval="";
	}
	foreach($frm['rs_field_array'] as $v) {
		$fieldlist .= 	"'".$v."',";
	}

	$frm['field_array_forjs'] = removeLastChar($fieldlist);
}

function getFormGetValues() {
	global $frm;
	foreach($_GET as $varname => $varval) {		
		$frm['hidden_fields'] .= "<input type='hidden' name='".$varname."' value='".$varval."'>";
		$fieldlist .= "'".$varname."',";
	}
	$frm['field_array_forjs'] = removeLastChar($fieldlist);
}

function formatFreeText($text){
	$pattern="/[^A-Za-z0-9\\\"\ ]/";
	$replacement="";
	$text= preg_replace($pattern,$replacement,$text);
	$text = preg_replace("/[\s]+/"," ",$text);
	return $text;
}

function keywordLogIt($domain,$method,$data) {
	$filename = "/home/bharat/keylog/".$domain."/".date("Y-M-d").".log";
	$fp = fopen($filename, $method);
	fwrite($fp, $data);
	fclose($fp);
}

function assign_vars_basedon_display_format() {
	global $data, $COOKIEINFO;
	if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
		$data['onearr_1']=5; $data['onearr_2']=1; $data['onearr_3']=10;
	}
	else {
		$data['onearr_1']=5; $data['onearr_2']=1; $data['onearr_3']=10;
	}
	$data['twoarr_1']=6; $data['twoarr_2']=1; $data['twoarr_3']=20;
	$data['fourarr_1']=3; $data['fourarr_2']=1; $data['fourarr_3']=40;
	$data['sixarr_1']=2; $data['sixarr_2']=1; $data['sixarr_3']=60;

	switch($_REQUEST['DISPLAY_FORMAT']) {	  
		case "one":
			$data['pagesperrequest']	= $data['onearr_1']; 
			if($_REQUEST['total_record']=="true") { $data['pagesperrequest'] = $data['onearr_2']; }
			$data['profilesperpage']	= $data['onearr_3'];
			break;
		case "two":
			$data['pagesperrequest']	= $data['twoarr_1']; 
			if($_REQUEST['total_record']=="true") { $data['pagesperrequest'] = $data['twoarr_2']; }
			$data['profilesperpage']	= $data['twoarr_3'];
			break;
		case "four":
			$data['pagesperrequest']	= $data['fourarr_1']; 
			if($_REQUEST['total_record']=="true") { $data['pagesperrequest'] = $data['fourarr_2']; }
			$data['profilesperpage']	= $data['fourarr_3'];
			break;
		case "six":
			$data['pagesperrequest']	= $data['sixarr_1']; 
			if($_REQUEST['total_record']=="true") { $data['pagesperrequest'] = $data['sixarr_2']; }
			$data['profilesperpage']	= $data['sixarr_3'];
			break;
	}
}

function genWhereQuery($id='') {
	global $data, $COOKIEINFO, $dbcon;
	$data['error_msg'] = "";
	$data['result_count'] = "";

	if($id!="") {
		$SearchQuery = genQueryForViewSimilarProfile($id);
	}
	else {
		if($data['limit_from']<=0) { $from = 0;	} else { $from = $data['limit_from']; }

		if($_REQUEST['SEARCH_TYPE']=="iamlookingfor") {
			$SearchQuery = genQueryProfileMatch();
		}
		else if($_REQUEST['SEARCH_TYPE']=="peoplelookingfor") {
			$SearchQuery = genQueryPerferenceMatch($from);
		}
		else if($_REQUEST['SEARCH_TYPE']=="twoway") {
			$SearchQuery = genQueryMutualMatch($from);
		}
		else if($_REQUEST['SEARCH_TYPE']=="whos_online") {
			$SearchQuery = genQueryWhoIsOnline($from,$data['recordperquery']); //from members online search form
		}
		else if($_REQUEST['SEARCH_TYPE']=="members_online") {
			$SearchQuery = genQueryMembersOnline($from,$data['recordperquery']);
		}
		else if($_POST) {
			$SearchQuery = doSearch();
		}
		else {
			$data['err_no']=7;
			return throwErrorJson($data['no_records']);
		}
	}

	$data['error_msg'] = $SearchQuery[0];
	$data['where']	   = $SearchQuery[1];
	$data['mailwhere'] = $SearchQuery[1];
	$data['result_count'] = $SearchQuery[4];

	if($data['error_msg']!="") {
		return throwErrorJson($data['error_msg']);
	}

	if($data['where']=="") {
		$data['err_no']=9;
		return throwErrorJson($data['no_records']);
	}
}

function preffix_where_caluse() {
	global $data;
	$data['MainQuery'] = "select MatriId, Name, Language, Age, Gender, EntryType, InCms, Height, Religion, Caste, SubCaste, CasteNoBar, Gothra, EducationSelected, Education, OccupationCategory, OccupationSelected, Occupation, CountrySelected, ResidingState, ResidingArea, ResidingDistrict, PhotoAvailable, PhotoProtected, LastLogin, TimeCreated, MaritalStatus, Star, PhoneVerified, HoroscopeAvailable, HoroscopeProtected, VideoAvailable, VideoProtected, SpecialPriv, ProfileVerified, MotherTongue, VoiceAvailable, SpecialCase, Dosham, EatingHabits, Citizenship, ResidentStatus, ReferenceAvailable, HealthProfileAvailable, PhoneProtected from ".$data['matrimonyprofile']." where ";
}

function getUpperIcons($PhoneVerified, $HoroscopeAvailable, $HoroscopeProtected,$VideoAvailable, $ProfileVerified, $VoiceAvailable, $ReferenceAvailable, $VideoProtected,$PhoneProtected) {
	global $user_lang1,$data;
	$uppericons = ""; /*to get the upper icons*/


	if($PhoneVerified==1 || $PhoneVerified==3) {//phone verified
		if($PhoneProtected=='Y') {
				$uppericons .= "PY";
		} else {
			$uppericons .= "Y";
		}	
	} else {
		$uppericons .= "N";
	}	

	$uppericons .= "^";//horscope
	
	if($HoroscopeAvailable==1 || $HoroscopeAvailable==2) { //manually uploaded - Globe icon || //support validated horo - comp icon
		if($HoroscopeProtected=="Y")
			$uppericons .= "UYP";
		else
			$uppericons .= "UY";
	} else if($HoroscopeAvailable==3) { //computer generated - comp icon
		if($HoroscopeProtected=="Y")
			$uppericons .= "GYP";
		else 
			$uppericons .= "GY";
	}
	else {
		$uppericons .= "GN";
	}
	$uppericons .= "^";//Reference
	
	if($ReferenceAvailable==1) {
		$uppericons .= "Y";
	}
	else {
		$uppericons .= "N";
	}
	$uppericons .= "^";//Verification
	
	if(($ProfileVerified==1) || ($ProfileVerified==4) || ($ProfileVerified==6) || ($ProfileVerified==9) || ($ProfileVerified==5) ||  ($ProfileVerified==8)) {
		$uppericons .= "Y";
	}
	else {
		$uppericons .= "N";
	}
	$uppericons .= "^";
	if($VoiceAvailable == 1) {
		$uppericons .= "Y";
	}
	else {
		$uppericons .= "N";
	}
	$uppericons .= "^";

	if($VideoAvailable == 1) {
		if($VideoProtected=='Y') {
			$uppericons .= "YP";
		} 
		else {
			$uppericons .= "Y";
		}
	} 
	else {
		$uppericons .= "N";
	}

	return $uppericons;
}

function zeroRecLog($where) {
	global $GETDOMAININFO,$COOKIEINFO;		
	if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
		$logfile = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/loggedin_zerorec_".$GETDOMAININFO['domainnameshort'].".log";
		$logcontent = date("Y-m-d H:i:s")." ~ ".$COOKIEINFO['LOGININFO']['MEMBERID']." ~ ".$where." ~ ".$_SERVER['REMOTE_ADDR']."\n";	
	} else {
		$logfile = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/visitor_zerorec_".$GETDOMAININFO['domainnameshort'].".log";
		$logcontent = date("Y-m-d H:i:s")." ~ ".$where." ~ ".$_SERVER['REMOTE_ADDR']."\n";	
	}
	txt_LogIt($logfile,'a',$logcontent);
	return;
}

function checkDir() {
	if(!(is_dir("/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']))) {
		mkdir("/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR'], 0777);
	}
}

function totalRecLog() { //unique search
	global $GETDOMAININFO,$COOKIEINFO,$data;
	if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {	
		$logfile = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/loggedin_gettotrec_".$GETDOMAININFO['domainnameshort'].".log";	
		$logfile2 = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/loggedin_gettotrec_query_".$GETDOMAININFO['domainnameshort'].".log";	
	} else {
		$logfile = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/visitor_gettotrec_".$GETDOMAININFO['domainnameshort'].".log";	
		$logfile2 = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/visitor_gettotrec_query_".$GETDOMAININFO['domainnameshort'].".log";	
	}	
	recordsCountLogIt($logfile);
	if($data['log_search']==0) {
		$logcontent = date("Y-m-d H:i:s")." ~ ".$data['where']." ~ ".$_SERVER['REMOTE_ADDR']."\n";	
		txt_LogIt($logfile2,'a',$logcontent);
	}
	return;
}

function totalSearchLog() {  //all saerch results including paging
	global $GETDOMAININFO,$COOKIEINFO;
	if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
		$logfile = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/loggedin_totsearch_".$GETDOMAININFO['domainnameshort'].".log";	
	} else {
	$logfile = "/var/log/bmlog/norecordslog/".date("YMd")."_".$_SERVER['SERVER_ADDR']."/visitor_totsearch_".$GETDOMAININFO['domainnameshort'].".log";	
	} 
	recordsCountLogIt($logfile);
	return;
}

function recordsCountLogIt($filename) {
	checkDir();
	if (!$fp = fopen($filename, 'a+')) {
	}
	$fcount = fread($fp,filesize($filename));	
	fclose($fp);
	if (!$nfp = fopen($filename, 'r+')) {
	}
       ($fcount=="") ? $fcount=1 : $fcount++;
       fwrite($nfp, $fcount);
	fclose($nfp);	
}

function txt_LogIt($filename,$method,$logit) {
	checkDir();
	if (!$fp = fopen($filename, $method)) {
	}
	fwrite($fp, $logit);
	fclose($fp);
}

function genXml() {
	global $data, $frm, $dbcon, $dbcon1, $matrimonyprofile, $COOKIEINFO, $COMMONVARS;
	$matrids_content="";

	// members online and whos online, profiles has to displayed in a decending order. so we are assigning null value to orderby var
	if($_REQUEST['SEARCH_TYPE']=="members_online" || $_REQUEST['SEARCH_TYPE']=="whos_online") {
		$data['orderby']="";
	}

	if($data['result_count']=="") {
		$to_json = $data['MainQuery'].$data['where'].$data['orderby'].$data['limit'];
	}
	else {
		$to_json = $data['MainQuery'].$data['where'].$data['orderby'];
	}

	if($_REQUEST['total_record']=="true" && $data['result_count']=="") {		
		$data['result_count'] = getTotalRecords();		
	    totalRecLog();		
		if($data['result_count']==0) {
			zeroRecLog($data['where']);
		}

		if($data['err_no']==4) {
			return throwErrorJson($data['no_records']);
		}
		else if($data['result_count']=="" || $data['result_count']==0) {
			if($data['search_form_page'] == "") {
				$data['err_no']=3;
				return throwErrorJson($data['no_records']);
			} else {
				$data['err_no']=34;
				return throwErrorJson($data['no_records']);
			}
		}
	}

	if($data['where']=="") {		
		$data['err_no']=5;
		return throwErrorJson($data['error_msg']);
	}
	//$dbcon->query=$to_json;
	dispDebugValue($to_json);
	//$dbcon->execute();
	$dbcon->select($to_json);

	$qryresource=$dbcon->resource;

	if(!$qryresource) {
		$data['err_no']=6;
		return throwErrorJson($data['error_msg']);
	}

	$total_matriids_array = array();
	while($profiles_row = $dbcon->fetchArray()) {
		$total_matriids_array[] = $profiles_row['MatriId'];
	}
	$dbcon->dataSeek(0,$qryresource);	
	$photo_array = smartGetPhotoInfoOfUser($total_matriids_array);
	
	if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
		$total_ids_contact_summary = lastAction($COOKIEINFO['LOGININFO']['MEMBERID'],$total_matriids_array,$dbcon);
	}
	
	$data['Express_Interest_Link']="";
	$jsonRslt = array();
	$profileInc = 0;

	while($profiles_row = $dbcon->fetchArray('',$qryresource)) {
		$Occupation=""; $jsonRslt[$profileInc]["PP"]=0;
		stripslashes(extract($profiles_row));
		
		$user_photos = getUserPhotoDetails($MatriId,$PhotoAvailable,$PhotoProtected,$photo_array[$MatriId],$Gender);
		$jsonRslt[$profileInc]['P'] = $user_photos['P75'];
		$jsonRslt[$profileInc]['EP'] = $user_photos['P150'];

		$CI = "N^N^N^N";
		if($COOKIEINFO['LOGININFO']['MEMBERID']!="" && $Gender!=$COOKIEINFO['LOGININFO']['GENDER']) {
			$CI = profilenoteChecking($total_ids_contact_summary[$MatriId]);

			$jsonRslt[$profileInc]["PP"] = getPpBarValues($Age, $Height,$MaritalStatus,$SpecialCase, $MotherTongue,$Religion,$Dosham,$Caste,$EatingHabits,$EducationSelected,$Citizenship, $CountrySelected, $ResidingState, $ResidentStatus);
		}

		$UI = getUpperIcons($PhoneVerified, $HoroscopeAvailable, $HoroscopeProtected, $VideoAvailable, $ProfileVerified, $VoiceAvailable, $ReferenceAvailable, $VideoProtected, $PhoneProtected);

		/*to build the title value*/
		$formated_fields_array = formatDbValues($Height, $ResidingState, $ResidingDistrict, $Caste, $Religion, $EducationSelected, $MaritalStatus, $CountrySelected, $MotherTongue, $OccupationSelected, $Language, $Star, $Occupation, $CasteNoBar,$MatriId);

		$jsonRslt[$profileInc]['TD'] = formatTitleValue($Age, $Height, $formated_fields_array['Religion'], $formated_fields_array['Caste'], $SubCaste, $Gothra, $Religion, $formated_fields_array['Star'], $CountrySelected, $ResidingDistrict, $ResidingState, $ResidingArea, '', $formated_fields_array['Country'], $formated_fields_array['Education'], $Education, $formated_fields_array['Occupation'], $formated_fields_array['Height'],$Occupation,$_REQUEST['DISPLAY_FORMAT'],$_REQUEST["SEARCH_TYPE"]);

		if($data['Express_Interest_Link']=="") {
			checkExpressInterestLink($Gender); /*to get the express interest link*/
		}

		checkEntryType($EntryType,$SpecialPriv); /*to get the table border style*/	

		$jsonRslt[$profileInc]['LE'] = getLastLoginInfo($LastLogin,$TimeCreated,$MatriId)."^".base64_encode($MatriId)."^".urlencode (crypt(crypt($MatriId,"RPH"),"BM"));

		$jsonRslt[$profileInc]['MId'] = $MatriId;
		$jsonRslt[$profileInc]['N'] = urlencode(strToTitle(freeTextWordCut($Name, "Name")));
		if(trim($jsonRslt[$profileInc]['N'])=="") 
			$jsonRslt[$profileInc]['N']=" ";

		//0~phoneverified ^1~horscope ^2~Reference ^3~ProfileVerified ^4~VoiceAvailable ^5~VideoAvailable ^6~Bookmarked ^7~Blocked ^8~Ignored ^9~LastAction ^10~borderstyle ^11~memonline ^12~ExpressInterest^healthicon
		
		
		if($HealthProfileAvailable==1)
			$healthicon="Y";
		else
			$healthicon="N";		

		$jsonRslt[$profileInc]['ICO'] = $UI."^".$CI."^".$data['border_style']."^".checkMemonline($Gender,$MatriId,$LastLogin,$TimeCreated)."^".$data['Express_Interest_Link']."^".$healthicon;

		$matrids_content .= "'".$MatriId."',";
		$profileInc++;
		$photo_array[$MatriId]="";
	}

	$jsonTotRslt = array("profiles" => $jsonRslt);
	$jsonData = json_encode($jsonTotRslt);

	$data['err_no']=0;	
	if($data['upper_ig_limit']=="e" && $data['upper_con_limit']=="e") {
		$data['error_msg']="Sorry, you will be able to see all the profiles you have already contacted and ignored as you have exceeded the maximum number.";
		$data['err_no']=1;
	} else if($data['upper_con_limit']=="e") {
		$data['error_msg']="Sorry, you will be able to see all the profiles you have already contacted as you have exceeded the maximum number.";
		$data['err_no']=1;
	} else if($data['upper_ig_limit']=="e") {
		$data['error_msg']="Sorry, you will be able to see all the profiles you have ignored as you have exceeded the maximum number.";
		$data['err_no']=1;
	}	

	$jsonData = $data['err_no'].$data['split_char'].$data['error_msg'].$data['split_char'].$data['result_count'].$data['split_char'].$jsonData;	
	//$jsonData = $data['err_no'].$data['split_char'].$data['error_msg'].$data['split_char'].$data['result_count'].$data['split_char'].$jsonData;	

	if($data['debug_val']!="") {		
		$jsonData .= $data['split_char'].$data['debug_val'];		
	}

	if($jsonData=="") {
		$data['err_no']=35;
		throwErrorJson($data['no_records']);
	}

	if($data['err_no']<3) {
		totalSearchLog();
	}
	echo $jsonData;
	exit;
}

function getUserPhotoDetails($MatriId,$PhotoAvailable,$PhotoProtected,$Member_PhotoInfo,$Gender) {
	global $data, $COMMONVARS;
	if($PhotoAvailable == 1 && is_array($Member_PhotoInfo) && trim($Member_PhotoInfo['ThumbImgs1']!="")) {
		if($Member_PhotoInfo['PhotoProtected'] == "Y") {
			if($Gender == 'M') {
				$user_photos['P75']="PM";
			}
			else {
				$user_photos['P75']="PF";
			}
		}
		else {
			return formatphotos($Member_PhotoInfo);
		}
	}
	else {
		if($Gender == 'M') {
			$user_photos['P75']="RM";
		}
		else {
			$user_photos['P75']="RF";
		}
	}
	return $user_photos;
}

function formatphotos($Member_PhotoInfo) {
	global $data;
	$user_photos="";
	if($_REQUEST['SEARCH_TYPE']=="remove_KEYWORD") {
		$PhotoStatus_array = split("^",$Member_PhotoInfo['PhotoStatus1']);
		$ThumbImgs_array = split("^",$Member_PhotoInfo['ThumbImgs1']);
		$ThumbImg_array = split("^",$Member_PhotoInfo['ThumbImg1']);

		for($i=1;$i<=count($ThumbImgs_array);$i++) {
			if(($PhotoStatus_array[$i]==0 || $PhotoStatus_array[$i]==2) && $ThumbImgs_array[$i]!="") {
				$user_photos['P75'] .= $ThumbImgs_array[$i];
				if($_REQUEST['DISPLAY_FORMAT']=="one") {
					$user_photos['P150'] .= $ThumbImg_array[$i];
				}
				$user_photos['P75'] .= "^";
				$user_photos['P150'] .= "^";
			}
		}
	}
	else {
		for($i=1;$i<=10;$i++) {
			if(trim($Member_PhotoInfo['ThumbImgs'.$i]) != "") {
				if($Member_PhotoInfo['PhotoStatus'.$i]==0 || $Member_PhotoInfo['PhotoStatus'.$i]==2) {
					$user_photos['P75'] .= $Member_PhotoInfo['ThumbImgs'.$i];
					if($_REQUEST['DISPLAY_FORMAT']=="one") {
						$user_photos['P150'] .= $Member_PhotoInfo['ThumbImg'.$i];
					}
				}
				$user_photos['P75'] .= "^";
				$user_photos['P150'] .= "^";
			}
		}
	}
	return $user_photos;
}

function deleteOldCookie() {
	global $data;
	foreach($_COOKIE as $k => $v) {
		if(strstr($k, $data['page_preffix']) && $data['page_preffix'].$_REQUEST['randid']!=$k && $data['page_preffix']!="page_S_") {
			clearCookie($k);
		}
		if(strstr($k, $data['cname_preffix']) && $data['cname']!=$k && $data['cname_preffix']!="bmw_S_") {
			clearCookie($k);
		}
	}
}

function clearCookie($cname) {
	$_COOKIE[$cname]=""; setrawcookie($cname, "", time() -3600);
}

function getDebugParameter() {
	global $data, $COMMONVARS;
	if($_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]==$COMMONVARS['SMART_DEBUG_VAL'] && $_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]!="") {
		echo "var Jsg_d_val=\"".$_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]."\", Jsg_d_param=\"".$COMMONVARS['SMART_DEBUG_VAL']."\";";
	} else {
		echo "var Jsg_d_val='v'; var Jsg_d_param='p'; ";
	}
}
?>