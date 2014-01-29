<?php
	include_once($xml_filename);
	switch ($ln) {
		case "ta":
			$lang_xml = "tamil";
		break;
		case "hi":
			$lang_xml = "hindi";
		break;
		case "te":
			$lang_xml =	 "telugu";
		break;
		case "kn";
			$lang_xml = "kannada";
		break;
		case "mr":
			$lang_xml = "marathi";
		break;
		case "bn":
			$lang_xml = "bengali";
		break;
		case "gu":
			$lang_xml = "gujarati";
		break;
		case "ml":
			$lang_xml = "kerala";
		break;
		default:
			$lang_xml = "english";
	}
	$lang_xml = strtoupper($lang_xml);
	foreach($$lang_xml as $k =>$v) { 
		$$k=$v; 
	}
?>