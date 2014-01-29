<?php
/***************************************************************************************************************************************
File		: bmsparser.php
Author		 : Yuva
Date		 : 08-Jan-2008
Modified By  : Sathish prabu.N
Date         : 25-03-2008
***************************************************************************************************************************************
Description	: Frame Keywrod search Query, send send to solr server, get the data from solrserver and parse the data into json format.
***************************************************************************************************************************************/

global $tag_name;
$tag_name = array();
$tag_name["responseHeader"] = "bm_results";
$tag_name["response"] = "profiles";

include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";

/*   0 - success
 2 json data empty
  3- keyword empty
  4- num or records zero
  6 - parse error
max debug no is 6  */

// solr run path  is assigned to the following variable $solr_query->solr_run_path in line no :30 . if want to change the path change this variable value.

if(trim($_REQUEST['keytext'])!="") {
	$solr_query = new query4solr();
	$solr_query->solr_run_path="http://172.20.100.234:8080/bmnew/select";
	$jsondata = $solr_query->getResults($_REQUEST,$data['pagesperrequest'],$data['profilesperpage']);

	if($jsondata=="") {
		echo "2#~^*^~#".get_debug_val()."#~^*^~#0#~^*^~#1";
		exit;
	}

	echo appendLoginUser($jsondata);
	exit;
}
else {
	echo "3#~^*^~#".get_debug_val()."#~^*^~#0#~^*^~#2";
	exit;
}

function formatJsontagNames() {
	global $tmp, $tag_name;

	$tmp[$tag_name['responseHeader']] = $tmp['responseHeader'];
	$tmp[$tag_name['response']] = $tmp['response'];

	$tmp[$tag_name['response']][$tag_name['docs']] = $tmp[$tag_name['response']]['docs'];

	if($tmp[$tag_name['response']]['numFound']==0 || $tmp[$tag_name['response']]['numFound']=="") {
		echo "4#~^*^~#".get_debug_val()."#~^*^~#0#~^*^~#3";
		exit;
	}

	unset($tmp[$tag_name['response']]['docs']);
	unset($tmp['response']);
	unset($tmp['responseHeader']);
}

function to_fix_horoscope_issue($jsondata) {
	$pat = "\"HoroscopeProtected\":N";
	$rep = "\"HoroscopeProtected\":\"N\"";

	$pat1 = "\"HoroscopeProtected\":Y";
	$rep1 = "\"HoroscopeProtected\":\"Y\"";

	$jsondata = str_replace($pat, $rep, $jsondata);
	$jsondata = str_replace($pat1, $rep1, $jsondata);

	return $jsondata;
}

function appendLoginUser($jsondata) {
	global $COMMONVARS, $tmp, $dbcon, $tag_name,$religion_val, $caste_val,$country_val, $education_val,$occupation_val, $heightcal,$COUNTRYHASH,$data,$COOKIEINFO, $jsonRslt, $solr_query;
	global $MARITALSTATUSHASH, $MOTHERTONGUEHASH, $RELIGIONHASH, $MANGLIKHASH, $CASTEHASH, $EATINGHABITSHASH, $EDUCATIONHASH, $COUNTRYHASH, $COUNTRYHASH, $RESIDINGINDIANAMES, $RESIDENTSTATUSHASH, $PHYSICALSTATUS;

	$data['err_no']=0;

	$jsondata = to_fix_horoscope_issue($jsondata);

	$tmp = json_decode($jsondata,true);

	if(!is_array($tmp)) {
		echo "6#~^*^~#".get_debug_val()."#~^*^~#0#~^*^~#1";
		exit;
	}

	formatJsontagNames();

	$cnt = $tmp[$tag_name['responseHeader']]['params']['rows'];
	$tmp[$tag_name['responseHeader']]['stime'] = $tmp[$tag_name['responseHeader']]['QTime'];

	$doc = array();
	$data1 = array();
	$jsonRslt = array();

	if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
		$total_matriids_array = array();
		for($i=0;$i<$cnt;$i++) {
			$total_matriids_array[] = $tmp[$tag_name['response']][$tag_name['docs']][$i]['MatriId'];		
		}
		//$total_ids_contact_summary = lastAction($COOKIEINFO['LOGININFO']['MEMBERID'],$total_matriids_array,$dbcon);
	}

	for($i=0;$i<$cnt;$i++) {
		$doc="";
		$pp_val=0;

		$MatriId = $tmp[$tag_name['response']][$tag_name['docs']][$i]['MatriId'];

		if($MatriId==''){
			break;
		}

		$Gender=$tmp[$tag_name['response']][$tag_name['docs']][$i]['Gender'];
		$SpecialPriv=$tmp[$tag_name['response']][$tag_name['docs']][$i]['SpecialPriv'];
		$EntryType=$tmp[$tag_name['response']][$tag_name['docs']][$i]['EntryType'];
		$TimeCreated=$tmp[$tag_name['response']][$tag_name['docs']][$i]['TimeCreated'];
		$LastLogin=$tmp[$tag_name['response']][$tag_name['docs']][$i]['LastLogin'];
		$PhoneVerified=$tmp[$tag_name['response']][$tag_name['docs']][$i]['PhoneVerified'];
		$HoroscopeAvailable=$tmp[$tag_name['response']][$tag_name['docs']][$i]['HoroscopeAvailable'];
		$HoroscopeProtected=$tmp[$tag_name['response']][$tag_name['docs']][$i]['HoroscopeProtected'];
		$VideoAvailable=$tmp[$tag_name['response']][$tag_name['docs']][$i]['VideoAvailable'];
		$PhotoAvailable=$tmp[$tag_name['response']][$tag_name['docs']][$i]['PhotoAvailable'];
		$PhotoProtected=$tmp[$tag_name['response']][$tag_name['docs']][$i]['PhotoProtected'];
		$ProfileVerified=$tmp[$tag_name['response']][$tag_name['docs']][$i]['ProfileVerified'];
		$VoiceAvailable=$tmp[$tag_name['response']][$tag_name['docs']][$i]['VoiceAvailable'];
		$ReferenceAvailable = $tmp[$tag_name['response']][$tag_name['docs']][$i]['ReferenceAvailable'];
		$VideoProtected = $tmp[$tag_name['response']][$tag_name['docs']][$i]['VideoProtected'];

		$heightcal = calRevFloatHeight($tmp[$tag_name['response']][$tag_name['docs']][$i]['Height']);

		$tmp[$tag_name['response']][$tag_name['docs']][$i]['TD'] = formatTitleValue($tmp[$tag_name['response']][$tag_name['docs']][$i]['Age'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Height'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Religion'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Caste'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['SubCaste'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Gothra'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Religion'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Star'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['CountrySelected'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['ResidingDistrict'], 
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['ResidingState'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['ResidingArea'],
						'',
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['CountrySelected'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['EducationSelected'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Education'],
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['OccupationSelected'],
						$heightcal,
						$tmp[$tag_name['response']][$tag_name['docs']][$i]['Occupation'], $_REQUEST['DISPLAY_FORMAT'],$_REQUEST["SEARCH_TYPE"]);

		$user_photos = getUserPhotoDetails($MatriId,$PhotoAvailable,$PhotoProtected,$tmp[$tag_name['response']][$tag_name['docs']][$i],$Gender);

		if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {

			$pp_ms = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['MaritalStatus'], $MARITALSTATUSHASH);
			$pp_mt = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['MotherTongue'], $MOTHERTONGUEHASH);
			$pp_rel = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['Religion'], $RELIGIONHASH);
			//$pp_dos = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['Dosham'], $MANGLIKHASH);
			$pp_cas = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['Caste'], $CASTEHASH);
			$pp_et = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['EatingHabits'], $EATINGHABITSHASH);
			$pp_es = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['EducationSelected'], $EDUCATIONHASH);
			$pp_c = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['Citizenship'], $COUNTRYHASH);
			$pp_cs = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['CountrySelected'], $COUNTRYHASH);
			$pp_rs = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['ResidingState'], $RESIDINGINDIANAMES);
			$pp_rs1 = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['ResidentStatus'], $RESIDENTSTATUSHASH);
			$pp_sp = array_search($tmp[$tag_name['response']][$tag_name['docs']][$i]['SpecialCase'], $PHYSICALSTATUS);

			$pp_val = getPpBarValues($tmp[$tag_name['response']][$tag_name['docs']][$i]['Age'],$tmp[$tag_name['response']][$tag_name['docs']][$i]['Height'],$pp_ms,$pp_sp,$pp_mt,$pp_rel,$tmp[$tag_name['response']][$tag_name['docs']][$i]['Dosham'],$pp_cas,$pp_et,$pp_es,$pp_c,$pp_cs,$pp_rs,$pp_rs1);

			$pp_val = $pp_val + 5;
			if($pp_val>95) {
				$pp_val=95;
			}
		}

		$final_icons = appendAttr($MatriId,$Gender,$SpecialPriv,$EntryType,$LastLogin,$TimeCreated,$PhoneVerified,$HoroscopeAvailable,$HoroscopeProtected,$VideoAvailable,$ProfileVerified,$VoiceAvailable,$ReferenceAvailable, $VideoProtected);

		$jsonRslt[$i]['MId'] = $tmp[$tag_name['response']][$tag_name['docs']][$i]['MatriId'];
		$jsonRslt[$i]['N'] = urlencode(strToTitle(freeTextWordCut($tmp[$tag_name['response']][$tag_name['docs']][$i]['Name'], "Name")));
		if(trim($jsonRslt[$i]['N'])=="") {
			$jsonRslt[$i]['N']=" ";
		}
		$jsonRslt[$i]['P'] = $user_photos['P75'];
		$jsonRslt[$i]['PP'] = $pp_val;
		$jsonRslt[$i]['EP'] = $user_photos['P150'];

		//0~phoneverified ^1~horscope ^2~Reference ^3~ProfileVerified ^4~VoiceAvailable ^5~VideoAvailable ^6~Bookmarked ^7~Blocked ^8~Ignored ^9~LastAction ^10~borderstyle ^11~memonline ^12~ExpressInterest

		$jsonRslt[$i]['ICO'] = $final_icons["UI"]."^".$final_icons["CI"]."^".$final_icons["BO"];
		$jsonRslt[$i]['LE'] = $final_icons["LL"];
		$jsonRslt[$i]['TD'] = $tmp[$tag_name['response']][$tag_name['docs']][$i]['TD'];
	}	

	formatFacedFields();

	if(!(is_array($jsonRslt))) {
		echo "5#~^*^~#".get_debug_val()."#~^*^~#0#~^*^~#4";
		exit;
	}

	$jsonData = json_encode(array("profiles" => $jsonRslt));
	return $data['err_no']."#~^*^~#".get_debug_val('s')."#~^*^~#".$tmp[$tag_name['response']]['numFound']."#~^*^~#".$jsonData;
}

function get_debug_val($t='') {
	global $COMMONVARS, $solr_query, $data, $COOKIEINFO;
	if($t=="") {
		$solrqry = urlencode($data['no_records']);
	}
	if($_POST[$COMMONVARS['SMART_DEBUG_PARAM']] == $COMMONVARS['SMART_DEBUG_VAL']) {
		$solrqry .= "======".$solr_query->url;
	}
	return $solrqry;
}

function formatFacedFields() {
	global $tmp, $jsonRslt, $SEARCHJOB1, $CASTEHASH, $EDUCATIONHASH, $COUNTRYHASH, $COMMONVARS, $tag_name;

	foreach($tmp['facet_counts']['facet_fields'] as $k=>$v) {
		switch($k) {
			case "CountrySelected_f":
			$jsonRslt['chks']['C'] = getReformatedFactitValue($v,$COUNTRYHASH);
			break;
			case "Caste_f":
			$jsonRslt['chks']['Ca'] = getReformatedFactitValue($v,$CASTEHASH);
			break;
			case "EducationSelected_f":
			$jsonRslt['chks']['E'] = getReformatedFactitValue($v,$EDUCATIONHASH);
			break;
			case "OccupationSelected_f":
			$jsonRslt['chks']['O'] = getReformatedFactitValue($v,$SEARCHJOB1);
			break;
		}
	}
	unset($tmp[$tag_name['responseHeader']]['QTime']);
	unset($tmp[$tag_name['responseHeader']]['status']);
	unset($tmp[$tag_name['responseHeader']]['params']);
	unset($tmp[$tag_name['response']]['start']);
	unset($tmp['facet_counts']);
}

function getReformatedFactitValue($faced_array,$array_name) {
	foreach($array_name as $k=>$v) {
		$formatted_key_value = formatSingleWord($v);
		foreach($faced_array as $fv) {
			if($formatted_key_value==$fv) {
				$tp .= $array_name[$k]."^".$formatted_key_value."~";
				break;
			}
		}
	}
	if($tp!=""){
		return $tp;
	}else{
		return "";
	}
	
}

function formatSingleWord($text) {
	$pattern="/[^a-z0-9]/is";
	$replacement="";
	$text= preg_replace($pattern,$replacement,$text);
	return $text;
}

function appendAttr($MatriId,$Gender,$SpecialPriv,$EntryType,$LastLogin,$TimeCreated,$PhoneVerified,$HoroscopeAvailable,$HoroscopeProtected,$VideoAvailable,$ProfileVerified,$VoiceAvailable,$ReferenceAvailable, $VideoProtected) {

	global $COOKIEINFO, $tag_name, $GETDOMAININFO, $DBINFO, $DBNAME, $data, $dbcon;

	if($COOKIEINFO['LOGININFO']['MEMBERID']!="" && $Gender!=$COOKIEINFO['LOGININFO']['GENDER']) {
		$dbcon=new db();
		$dbcon->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);

		$CS_array = lastAction($COOKIEINFO['LOGININFO']['MEMBERID'],$MatriId,$dbcon);
		$final_ContactIcons = profileNoteChecking($CS_array);
	}
	else{
		$final_ContactIcons="N^N^N^N";
	}

	checkExpressInterestLink($Gender); /*to get the express interest link*/
	checkEntryType($EntryType,$SpecialPriv); /*to get the table border style*/	

	$final_borderstyle_online = $data['border_style']."^".checkMemonline($Gender,$MatriId)."^".$data['Express_Interest_Link'];

	$level1 = crypt($MatriId,"RPH");
	$lastlogin = getLastLoginInfo($LastLogin,$TimeCreated,$MatriId);

	$final_Lastlogin_encode = $lastlogin."^".base64_encode($MatriId)."^".crypt($level1,"BM");

	$final_UpperIcons = getUpperIcons($PhoneVerified,$HoroscopeAvailable,$HoroscopeProtected,$VideoAvailable,$ProfileVerified,$VoiceAvailable, $ReferenceAvailable, $VideoProtected);

	$final["UI"] = $final_UpperIcons;
	$final["CI"] = $final_ContactIcons;
	$final["BO"] = $final_borderstyle_online;
	$final["LL"] = $final_Lastlogin_encode;
	return $final;
}

class query4solr {
	var $offset = 0;
	var $solr_run_path = "";
	var $result_set = array();
	var $use_query_type=false;
	var $boost_field=false;
	var $query_type = "bm";
	var $field_list= "MatriId,Name,Gender,Age,Height,Religion,Language,Star,Caste,ThumbImgs1,ThumbImg1,PhotoStatus1,ThumbImgs2,ThumbImg2,PhotoStatus2,ThumbImgs3,ThumbImg3,PhotoStatus3,Caste,PhotoAvailable,PhotoProtected,SubCaste,CountrySelected,ResidingState,ResidingDistrict,LastLogin,TimeCreated,OccupationSelected,Occupation,EducationSelected,Education,ResidingArea,MaritalStatus,VideoAvailable,HoroscopeAvailable,HoroscopeProtected,ProfileVerified,PhoneVerified,VoiceAvailable,MotherTongue,CasteNoBar,ReferenceAvailable,SpecialCase,Dosham,EatingHabits,Citizenship,ResidentStatus";
	// to be removed - ThumbImgs2,ThumbImg2,PhotoStatus2,ThumbImgs3,ThumbImg3,PhotoStatus3,

	var $httppost = false;
	var $debug = false;
	var $solr_query = NULL;
	var $query_node = "";
	var $solr_version="2.2";
	var $total_records_found=0;
	var $query_time=0;
	var $facet=true;
	var $facet_default=array("CountrySelected_f","Caste_f","EducationSelected_f","OccupationSelected_f");
	var $facet_zeros="false";
	var $facet_limit=10;
	var $facet_mincount=10;
	var $facet_counts=array();
	var $city_array=array();
	var $query_string=NULL;
	var $highlight=false;
	var $highlight_field=array("MatriId","Age");
	var $search_type="keyword";
	var $num_pages=0;
	var $successivo="";
	var $precedente="";
	var $number_type="number";
	var $a, $theNext;
	var $show_pages_number="yes";
	var $url;

	var $facet_mapping_array = array("CountrySelected_f"=>"COUNTRY1","Caste_f"=>"CASTE1","EducationSelected_f"=>"EDUCATION1","OccupationSelected_f"=>"OCCUPATION1");

	function __construct() {

	}

	function __destruct() {

	}

	function findLimit($page,$pagesperrequest,$resultperpage) {
		$cblock	 = ceil($page / $pagesperrequest);
		$limit_from	 = (($cblock-1) * $pagesperrequest) * $resultperpage; /*build query limit from, to*/ 
		$this->limit = $pagesperrequest * $resultperpage;

		if($limit_from && $limit_from>0) {
			$this->offset = $limit_from;
		} 
		else {
			$this->offset = 0;
		}
	}

	function getResults($request_vars,$pagesperrequest,$resultperpage) {

		$this->findLimit($request_vars['cpage'],$pagesperrequest,$resultperpage);

		$this->prepareQuery($request_vars);

		$this->appendQueryString($request_vars);
		
		$result=$this->executeQuery();	

		if(strlen($result)<=0) {
			return "null";
		}
		return $result;
	}
	
	function prepareQuery($request_vars) {   
		global $SHOWHEIGHT;

		$keytext = $this->removeSpecialChars(urldecode($request_vars["keytext"]));

		$StAge=$request_vars['STAGE'];
		$EndAge=$request_vars['ENDAGE'];

		if($request_vars['GENDER']!="") {
			$this->query_string="(Gender:".$request_vars['GENDER'].")" ;
		}
		if($request_vars['STAGE']>=18 && $request_vars['ENDAGE']>=18) {
			$this->query_string.=" AND (Age:[".$StAge." TO ".$EndAge."])";
		}
		if($request_vars['STHEIGHT'] && $request_vars['ENDHEIGHT']) {
			$stheight=$SHOWHEIGHT[$request_vars['STHEIGHT']];
			$endheight=$SHOWHEIGHT[$request_vars['ENDHEIGHT']];
			$sth=explode("-",$stheight);
			$endh=explode("-",$endheight);	
			$sh=str_replace("cm","",$sth[1]);
			$eh=str_replace("cm","",$endh[1]);
			$this->query_string.=" AND (Height:[".trim($sh)." TO ".trim($eh)."])";
		}			
		if($request_vars['PHOTO_OPT']=="Y") {
			$this->query_string.=" AND (PhotoAvailable:1)";
		}
		if($request_vars['HOROSCOPE_OPT']=="Y") {
			$this->query_string.=" AND (HoroscopeAvailable:1 OR HoroscopeAvailable:2 OR HoroscopeAvailable:3)";
		}

		if($request_vars['keytext']!="") {
			if($request_vars['wdmatch']=="E") {  // All Word's Match
				$keytext = $this->formatKeyText($keytext);
				$this->query_string .= ' AND '.$keytext;
			}else if($request_vars['wdmatch']=="EX") { // Exact Word's  Match 
				$this->query_string.='( collectall:"'.trim($keytext).'"^10 )';
			}else {					// Any Word's  Match
				$this->query_string.=" AND (collectall:".$keytext.")";
			}
		}
		
		$this->query_string .= $this->updateCbValues($request_vars);

		if($_REQUEST['df']=="P") {
			$this->query_string .= " AND (PhotoAvailable:1) AND (PhotoProtected:N) ";
		}
		$this->query_string .= " AND (Status:0)  AND (Validated:1) AND (Authorized:1) ";
	}

	function formatKeyText($k) {
		$ret = "";
		$keywords = split(" ", $k);
		foreach($keywords as $v) {
			if(trim($v)!="")
				$ret .= '( collectall:'.trim($v).'^10 ) AND ';
		}
		$ret = rtrim($ret," AND ");
		return $ret;
	}

	function updateCbValues($request_vars) {
		foreach($this->facet_mapping_array as $factedname=>$inputname) {
			if($request_vars[$inputname]!="") {
				$arr = split("~",$request_vars[$inputname]);
				$C="";
				foreach($arr as $v) {
					if($v!="")
						$C .= " ".$factedname.": ".$v." OR ";
				}
				$C = rtrim($C," OR ");
				$facted_q_values .= " AND (". $C .")";
			}
		}
		return $facted_q_values;
	}

	function removeSingleQuote($str) {
		return str_replace("\'","",$str);
	}

	function appendSort() {
		$sort="";
		if($_REQUEST['cs']!="") {
			$sort .= "CountrySelected+".$_REQUEST['cs'].",";
		}
		if($_REQUEST['es']!="") {
			$sort .= "EducationSelected+".$_REQUEST['es'].",";
		}
		if($_REQUEST['os']!="") {
			$sort .= "OccupationSelected+".$_REQUEST['os'].",";
		}
		if($_REQUEST['cas']!="") {
			$sort .= "Caste+".$_REQUEST['cas'].",";
		}
		$sort .= "LastLogin+desc";
		return $sort;
	}

	function appendQueryString($request_vars) {
		if(isset($request_vars["page"])) {
			$this->offset=$this->limit*($request_vars["page"]-1);
		}

		$this->solr_query = "q=".urlencode($this->query_string);

		$this->solr_query .= "&sort=".$this->appendSort();

		$this->solr_query.="&indent=on&start=".$this->offset."&rows=".$this->limit."&version=".$this->solr_version;

		if($this->use_query_type) {
			$this->solr_query.="&qt=".$this->query_type;
		}
			
		if($this->field_list) {
			$this->solr_query.="&fl=".$this->field_list;
		}
		if($this->facet) {
			foreach($this->facet_default as $face_value){
				$face_field.="facet.field=".$face_value."&";
			}
			$face_field=rtrim($face_field,"&");
			$this->solr_query.="&facet=true&".$face_field."&facet.mincount=".$this->facet_mincount."&facet.limit=".$this->facet_limit;
		}
		$this->solr_query.="&wt=json";
	}
	
	function result_fetched_time() {
		return $this->query_time;
	}
	
	function executeQuery() {
		$url = $this->solr_run_path;
		if (!$this->httppost) {
			$url .= "/?".$this->solr_query;
		}
		$this->url = $url;
		$ch = curl_init($this->solr_run_path);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$this->solr_query);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function removeSpecialChars($word) {
		$pattern=array(",",".","+","/","_",":","&",";","-");
		$word=str_replace($pattern, " ", $word);
		return preg_replace('/[^a-z0-9\ ]/is', '',$word);
	}
	
	function escapeChars($string) {
		$string = str_replace('&amp;', '&', $string);
		$string = str_replace('&lt;', '<', $string);
		$string = str_replace('&gt;', '>', $string);
		$string = str_replace('&#39;', '\'', $string); 
		$string = str_replace('&quot;', '"', $string); 
		return $string;
	}
}

function getSolrRequestValues(){
	foreach($_REQUEST as $varname => $varval) {
		$vars .= $varname."=>".$varval."\n";
	}
	return $vars;
}
?>