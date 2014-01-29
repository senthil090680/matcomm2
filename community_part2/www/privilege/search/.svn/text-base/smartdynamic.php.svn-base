<?php
/***************************************************************************
 FILENAME			: smartcommoninc.php  
 AUTHOR			    : SARAVANNAN, ANDAL.V	
 Date				: 02-Jan-2008
 DESCRIPTION		: This includes common files to display search results.
***************************************************************************/

include_once "smartcommoninc.php";

if(trim($_REQUEST["SEARCH_TYPE"])=="KEYWORD") {	
	$xml_filename = $DOCROOTBASEPATH."/bmconf/bmvarsviewprofilelabel.inc";
	require_once "parsexml.php";
	include("smartparser.php");
	exit;
}

if((trim($_POST["STAGE"])=="" && trim($_GET['ID'])=="") && $_REQUEST["SEARCH_TYPE"]!="members_online") {
	$data['err_no']=30;
	$data['error_msg'] = $data['no_records'];
	throwErrorJson($data['error_msg']);
}

if($data['pagesperrequest']=="" && $data['profilesperpage']=="") {
	$data['err_no']=33;
	$data['error_msg'] = $data['no_records'];
	throwErrorJson($data['error_msg']);
}
smartGetDbConnection();

if($data['error_msg']!="") {
	$data['err_no']=31;
	$data['error_msg'] = $data['no_records'];
	throwErrorJson($data['error_msg']);
}

preffix_where_caluse();
showCookieName();
genWhereQuery($_REQUEST['ID']);

if($data['error_msg']!="") {
	$data['err_no']=32;
	$data['error_msg'] = $data['no_records'];
	throwErrorJson($data['error_msg']);
}

if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
	getContactIgnoreids();
}

genXml();
?>