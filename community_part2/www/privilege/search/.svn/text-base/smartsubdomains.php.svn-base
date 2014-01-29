<?php
/****************************************************************************************************
File		: smartsubdomains.php
Author		: Saravavanan, Andal.V
Date		: 03-Jan-2008
*****************************************************************************************************
Description	: This includes functions for subdomains
********************************************************************************************************/

$common_server_name = strtolower($_SERVER['SERVER_NAME']);
$common_subdomain_name = smartSubdomainName();

// Array settings //
$cobrandhash= array (1=>"dinakaran",2=>"andhraprabha",3=>"rajasthanpatrika",4=>"dainikjagran",5=>"sysindia");
$cobrandheader = array (1=>"dinakaranheader.inc",2=>"andhraprabhaheader.inc",3=>"rajasthanpatrikaheader.inc",4=>"dainikjagranheader.inc",5=>"sysindiaheader.inc");

$bharat_subdomains = array("yahoo"=>"yahoo.bharatmatrimony.com","galatta"=>"galatta.tamilmatrimony.com");

// Yahoo
$common_subdomains['page_title']['yahoo'] = "Yahoo! India";
$common_subdomains['css_link']['yahoo'] = '<style type="text/css">@import url("http://'.$common_server_name.'/ybm.css");</style><link rel="stylesheet" href="http://'.$COMMONVARS['AKKAMI_SERVER_PREFFIX'].".".$GETDOMAININFO['domainnameshort'].'matrimony.com/bmstyles/bmstyle.css">';
$common_subdomains['header']['yahoo'] = "../ybmheader.html";
$common_subdomains['leftmenu']['yahoo'] = "../ybmleftmenu.html";
$common_subdomains['footer']['yahoo'] = "../ybmfooter.html";
$common_subdomains['refinesearch_div_top_px']['yahoo'] = 411;

function smartGetDbConnection() {
	global $data, $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains,$dbcon,$DBCONIP,$DBINFO,$DBNAME,$MERGETABLE;

	if(in_array($common_server_name,$bharat_subdomains)) {
		$db_slave = new db();
		$db_slave->connect($DBCONIP['DB6'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
		$data['matrimonyprofile']	= $DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE'];
		$data['photoinfo']		    = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO'];
		$dbcon						= $db_slave;
	} 
	else {
		$dbconnect					= newSmartDbConn();
		$data['matrimonyprofile']	= $dbconnect[0];
		$data['photoinfo']		    = $dbconnect[1];
		$dbcon						= $dbconnect[2];
	}
} 

function smartGetCssFiles() {
	global $COMMONVARS, $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains, $data, $GETDOMAININFO;
	if(in_array($common_server_name,$bharat_subdomains)) {
		return $common_subdomains['css_link'][$common_subdomain_name];
	}
	else {
		return;
		//return '<link rel="stylesheet" href="http://'.$COMMONVARS['AKKAMI_SERVER_PREFFIX'].".".$GETDOMAININFO['domainnameshort'].'matrimony.com/bmstyles/bmstyle.css">';
	}
}

function smartGetPageTitle() {
	global $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains, $data, $GETDOMAININFO;
	if(in_array($common_server_name,$bharat_subdomains)) {
		return $common_subdomains['page_title'][$common_subdomain_name];
	}
	else {
		return ucfirst($GETDOMAININFO['domainnameshort']);
	}
}

function smartGetHeaderFile() {
	global $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains, $cobrandheader, $headerfile,$COOKIEINFO,$HEADER;

	$c_header = $HEADER['DEFAULT'];
	if (isset($_REQUEST['SITE']) && $_REQUEST['SITE'] != '') {
		if (file_exists($cobrandheader[$headerfile])) {
			$header_file = $cobrandheader[$headerfile];
		} 
		else {
			$header_file = $c_header; 
		}
	} 
	elseif(in_array($common_server_name,$bharat_subdomains)) {
		include_once $common_subdomains['header'][$common_subdomain_name];
	} 
	else {
		include_once $c_header;
	}
}

function smartGetLeftMenuFile() {
	global $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains;
	if(in_array($common_server_name,$bharat_subdomains)) {
		include_once $common_subdomains['leftmenu'][$common_subdomain_name];
	} else {
		include_once "../template/leftmenu.php";
	}
}

function smartGetFooterFile() {
	global $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains;
	if(in_array($common_server_name,$bharat_subdomains)) {
		include_once $common_subdomains['footer'][$common_subdomain_name];
	} else {
		include_once "../template/footer.html";
	}
}

function smartSubdomainName() {
	global $common_server_name,$common_subdomain_name, $common_subdomains, $bharat_subdomains;
	$p[0]='/.bharatmatrimony.com/'; $p[1]='/.tamilmatrimony.com/'; $p[2]="/\//"; $p[3]='/.vipmatrimony.com/';
	return preg_replace($p,"",$common_server_name);
}
?>