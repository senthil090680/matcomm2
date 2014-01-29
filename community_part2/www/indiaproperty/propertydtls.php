<?
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/lib/clsXMLReader.php");

$varCurrentCondition	= $varCondition['LIMIT'];
$varCurrentCondition	= $objBasicComm->decryptData($varCurrentCondition);
$arrCondiotonDetail		= $objBasicComm->getTempPostValues($varCurrentCondition);
$varCountrySplitted		= explode("~",$arrCondiotonDetail['country']);
$varStateSplitted		= explode("~",$arrCondiotonDetail['residingState']);
$varCitySplitted		= explode("~",$arrCondiotonDetail['residingCity']);

if(count($varCountrySplitted)!=1) {
	$varIPCityName	= 'Any';
	$varIndexNum	= 0;
} else if(count($varStateSplitted)!=1) {
	$varIPCityName	= 'Any';
	$varIndexNum	= 0;
} else if($varStateSplitted[0]==18) {
	$varIPCityName	= 'Kerala';
	$varIndexNum	= 10;
} else {
	if(count($varCitySplitted)!=1) {
		$varIPCityName	= 'Any';
		$varIndexNum	= 0;
	} else if(count($varCitySplitted)==1){
		$arrPassedCity	= explode("#",$varCitySplitted[0]);
		$arrIPCityIndex = array(122,314,221,472,4,338,591,126,100);
		$arrIPCityNames = array(122=>'Delhi',314=>'Mumbai',221=>'Bangalore',472=>'Chennai',4=>'Hyderabad',338=>'Pune',591=>'Kolkata',126=>'Ahmedabad',100=>'Chandigarh');
		$arrIPIndexNum = array(122=>1,314=>2,221=>3,472=>4,4=>5,338=>6,591=>7,126=>8,100=>9);
		
		if(in_array($arrPassedCity[1],$arrIPCityIndex)) {
			$varIPCityName	= $arrIPCityNames[$arrPassedCity[1]];
			$varIndexNum	= $arrIPIndexNum[$arrPassedCity[1]];
		} else {
			$varIPCityName	= 'Any';
			$varIndexNum	= 0;
		}
	} else {
		$varIPCityName	= 'Any';
		$varIndexNum	= 0;
	}
}

$varXMLUrl			= "http://173.203.191.117/xmlfeeds/forbm/bm_ip_integration.xml";
$objXMLReader		= new UserXMLreader();
$varGetxmlreader	= $objXMLReader->get_xml_url($varXMLUrl);
$arrXMLOutput		= $objXMLReader->parse();


$varIPDetail		= $arrXMLOutput["listings"]["#"]["city"];
$varIPName			= $varIPDetail[$varIndexNum]["#"]["name"][0]["#"];
$varIPName			= ($varIPName=='Any')?'India':$varIPName;
$varTotalListing	= $varIPDetail[$varIndexNum]["#"]["totallistings"][0]["#"];
$varIPNewProjects	= $varIPDetail[$varIndexNum]["#"]["newprojects"][0]["#"];
$varIPPaidListing	= $varIPDetail[$varIndexNum]["#"]["paidlistings"][0]["#"];


if($varIPNewProjects==0) {
	$varIPName			= 'India';
	$varTotalListing	= $varIPDetail[0]["#"]["totallistings"][0]["#"];
	$varIPNewProjects	= $varIPDetail[0]["#"]["newprojects"][0]["#"];
	$varIPPaidListing	= $varIPDetail[0]["#"]["paidlistings"][0]["#"];
}

$varIPLink			= 'http://www.indiaproperty.com/all-new-properties.html';

if($varIPName=='India') {
	$varIPLink			= 'http://www.indiaproperty.com/all-new-properties.html';
} else {
	$varIPLink			= 'http://www.indiaproperty.com/new-properties-'.strtolower($varIPName).'.html';
}

?>