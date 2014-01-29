<?php
/****************************************************************************************************
File		: smartadvancesearch.php
Author		: Andal.V
Date		: 25-Dec-2007
*****************************************************************************************************
Description	: 
			 This file will populate the caste based on religion selection
********************************************************************************************************/

error_reporting(0);
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvars.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearcharrinc".$ln.".inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearchformarr".$ln.".inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarsviewarr".$ln.".inc");
$xml_filename = $DOCROOTBASEPATH."/bmconf/bmvarsviewprofilelabel.inc";
require_once "parsexml.php";

$domain = $_GET['domain'];
$ajax_langid = $_GET['sid'];
$ln = $_GET['ln'];
$stype = $_GET['stype'];
$religion_id = $_GET['rid'];

if($_GET['width']!="") {
	$width = $_GET['width']."px";
} else {
	$width ="200px" ;
}
$fontwidth = $_GET['fntwidth'];
$selectbox_fontfamily = $_GET['selectbox_fontfamily'];


$hp = $_GET['hp'];
forLanguageWiseFontSize($ln);

if($hp==1) {
	if($ln=="bn") { $selectbox_fontsize = 13; }
	$fontwidth = $selectbox_fontsize;
	$selectbox_fontfamily = $selectbox_fontfamily;
}
else {
	$fontwidth = $_GET['fntwidth'];
	$selectbox_fontfamily = $_GET['selectbox_fontfamily'];
}

$reglion_val = strtolower(getFromArryHash("RELIGIONHASH",$religion_id));
$broswer_type = getBrowserDetails();

$opt_val='';
if($stype=="qs") {
	if($ajax_langid=="bharat") {		
		$reglion_val = $GLOBALS['DOMAINNAME'][$religion_id];
		$caste_arrayname = "SEARCH".strtoupper($reglion_val)."CASTEHASH";
		echo casteSelectBox($$caste_arrayname,$width,$fontwidth,$broswer_type,$religion_id,$ajax_langid);
		exit;
	}
	if($religion_id==1) {
		$caste_arrayname = "SEARCH".strtoupper($ajax_langid)."CASTEHASH".strtoupper($reglion_val);
	}
	else if($religion_id==6) {
		$caste_arrayname = "SEARCH".strtoupper($reglion_val)."CASTEHASHQS";	
	}
	else if($religion_id==8 || $religion_id==9) {
		$caste_arrayname = "CASTEHASH";
	}
	else if($religion_id==2 || $religion_id==10 || $religion_id==11) {
		$caste_arrayname = "SEARCHMUSLIMCASTEHASH";
	}
	else {
		$caste_arrayname = "SEARCH".strtoupper($reglion_val)."CASTEHASH";
	}	
	echo casteSelectBox($$caste_arrayname,$width,$fontwidth,$broswer_type,$religion_id,$ajax_langid);
	exit;
}
else {
	$dmarr=getDomainInfo();
	$domain_name=$dmarr['domainnameshort'];

	switch ($religion_id) {
		case 1:  //hindu
			$option_val = "<option value='0'>".$l_any."</option>";	
			$caste_arrayname = "SEARCHCASTEHASHHINDU";
			break;
		case 2:  //muslim
		case 10:
		case 11:
			$option_val = "<option value='0'>".$l_any."</option>";	
			$opt_val=$option_val;
			$caste_arrayname = "SEARCHMUSLIMCASTEHASH";
			break;
		case 3: //christian
		case 12:		
		case 13:
		case 14:
			$option_val = "<option value='0'>".$l_any."</option>";	
			$opt_val=$option_val;
			$caste_arrayname = "SEARCHCHRISTIANCASTEHASH";
			break;     
		case 5://jain
		case 15:
		case 16:
			$option_val = "<option value='0'>".$l_any."</option>";	
			$opt_val=$option_val;
			$caste_arrayname = "SEARCHJAINCASTEHASH";
			break;
		case 8:  //no-religion,any,inter-religion
		case 9:
		case 0:
			$caste_arrayname = "SEARCHCASTEHASH";
			break;	
		case 6:  //parsi
			$option_val = "<option value='0'>".$l_any."</option>";	
			$caste_arrayname = "SEARCHPARSICASTEHASHQS";	
			break;	
		case 4: //sikh
			$option_val = "<option value='0'>".$l_any."</option>";	
			$opt_val=$option_val;
			$caste_arrayname = "SEARCHSIKHCASTEHASH";  
			break;	
		case 7:  //budddhist
			$opt_val=$option_val;
			$caste_arrayname = "SEARCHBUDDHISTCASTEHASH";  
			break;
	}
	if($_GET['regular_search']=='true') {
		$ch_language=strtolower($domainlang[$ajax_langid]);
		$religion_arrayname = strtoupper("SEARCH".$ch_language."RELIGIONHASH");
		$caste_arrayname= strtoupper("SEARCH".$ch_language."CASTEHASH");
	}
	else {
		$religion_arrayname = "SEARCH".strtoupper($domain_name)."RELIGIONHASH"; }
	
	$occ_arrayname = "SEARCHJOB".strtoupper($ajax_langid);
}

if($stype=="") {
		/* -- For Caste Select Box -- */
			$caste_selectbox = '<select style="width:'.$width.';" NAME="CASTE[]" id="CASTE" MULTIPLE size="5" class="inputtext" ondblclick="moveOptions(document.MatriForm.CASTE, document.MatriForm.CASTE1);">';
			$caste_selectbox .= $opt_val;

			$caste_arrayname = $$caste_arrayname;
			asort($caste_arrayname);

			if(is_array($caste_arrayname)) {
				if(array_key_exists(0,$caste_arrayname))
					$caste_selectbox.= "<option value='0'>Any</option>";
				if(array_key_exists(998,$caste_arrayname))
					$caste_selectbox.= "<option value='998'>Caste no bar</option>";
			}

			foreach($caste_arrayname as $key=>$val) {
				if($key!=0 && $key!=998) {
					$caste_selectbox .= "<option value=".$key.">".$val."</option>";
				}		
			}

			$caste_selectbox .= "</select>";
			$final_output =  $caste_selectbox;
			//for regular search
             if($_GET['regular_search']=='true' )
			{
			/* -- For Religion Select Box -- */		
			$religion_selectbox = '<select style="width:'.$width.';" NAME="RELIGION[]" id="RELIGION" MULTIPLE size="5" class="inputtext">';

			foreach($$religion_arrayname as $key=>$val) {
				$religion_selectbox .= "<option value=".$key.">".$val."</option>";
			}
			$religion_selectbox .= "</select>"; 
			$final_output = $religion_selectbox."~~".$caste_selectbox;
			}
}
else {
		/* -- For Occupation Select Box -- */
			$final_output = '<SELECT style="width:'.$width.';" NAME="OCCUPATION[]" id="OCCUPATION" size="5" multiple class="inputtext">';			

			foreach($$occ_arrayname as $key=>$val) {
				$final_output .= "<option value=".$key.">".$val."</option>";
			}
			$final_output .= '</SELECT>';
}
echo $final_output;

function casteSelectBox($caste_arrayname,$width,$fontwidth,$broswer_type,$religion_id,$ajax_langid) {
	global $stype,$ln;
  	$caste_selectbox = '<SELECT NAME="CASTE1[]" id="CASTE1" style="width:'.$width.';" class="inputtext">';
	if($religion_id!=1 && $religion_id!=6 && $religion_id!=7 && $ajax_langid!="bharat") {
			Switch($ln) {
			Case "en":
				$caste_selectbox .= "<option value='0'>Any</option>";
				break;
			Case "ta":	
				$caste_selectbox .= "<option value='0'>&#x0b8f;&#x0ba4;&#x0bbe;&#x0bb5;&#x0ba4;&#x0bca;&#x0ba9;&#x0bcd;&#x0bb1;&#x0bc1;</option>";
				break;
			Case "mr":	
				$caste_selectbox .= "<option value='0'>&#x0915;&#x094b;&#x0923;&#x0924;&#x0940;&#x0939;&#x0940;</option>";
				break;
			Case "bn":	
				$caste_selectbox .= "<option value='0'>&#x0995;&#x09cb;&#x09a8;</option>";
				break;
			Case "gu":	
				$caste_selectbox .= "<option value='0'>&#x0a95;&#x0acb;&#x0a88;&#x0aaa;&#x0aa3;</option>";
				break;
			Case "ml":	
				$caste_selectbox .= "<option value='0'>&#x0d0f;&#x0d24;&#x0d46;&#x0d19;&#x0d4d;&#x0d15;&#x0d3f;&#x0d32;&#x0d41;&#x0d02;</option>";
				break;
			Case "kn":	
				$caste_selectbox .= "<option value='0'>&#x0caf;&#x0cbe;&#x0cb5;&#x0cc1;&#x0ca6;&#x0cc7;</option>";
				break;
			Case "hi":	
				$caste_selectbox .= "<option value='0'>&#x0915;&#x094b;&#x0908</option>";
				break;
			Case "te":	
				$caste_selectbox .= "<option value='0'>&#x0c0f;&#x0c26;&#x0c48;&#x0c28;&#x0c3e;</option>";
				break;
		}
	}

	if($religion_id==1 && $stype=="qs") { /* for any issue */
		$caste_selectbox .= "<option value='0'>Any</option>";
	}
	
	  foreach($caste_arrayname as $key=>$val) {
		if($stype=="qs" && $ajax_langid=="bharat") {
			//$val = bharatFormatCasteVal($val);
		}
		else if($stype=="qs"){
			$val = formatCasteVal($val);
		}
		if(trim($ln)!= "en") {
			if(preg_match("/-/",$val)) {
				$caste_split = explode("-",$val);
				if(trim($caste_split[1]) != "") {
					$caste_selectbox .= "<option value=".$key.">".$caste_split[1]."</option>";
				}
			}
			else {
				$caste_selectbox .= "<option value=".$key.">".$val."</option>";
			}
		} else {
			$caste_selectbox .= "<option value=".$key.">".$val."</option>";
		}

	}
	$caste_selectbox .= '</SELECT><input type="hidden" id="bversion" name="bversion" value="'.$broswer_type.'">';
	return $caste_selectbox;
}
?>