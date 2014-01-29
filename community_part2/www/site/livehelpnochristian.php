<?
#================================================================================================================
# Author 		: Dhanapal N
# Date	        : 2009-12-15
# Project		: CBS
# Filename		: livehelpno.php
#================================================================================================================
# Description   :
#================================================================================================================

$varRootBasePath	= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varRootBasePath);
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/www/payment/ip2location.php');
$$varCountry	= '222';

$arrLiveHelpCountries = array ('IN'=>98, 'US'=>222,'UK'=>221,'BH'=>220,'CY'=>220,'EG'=>220,'IR'=>220,'IQ'=>220,'IL'=>220,'JO'=>220,'KW'=>220,'LB'=>220,'OM'=>220,'QA'=>220,'SY'=>220,'TR'=>220,'AE'=>220,'YE'=>220);

$arrLiveHelpNo	= array(98=>'1-800-3000-2222',221=>'8081683096',222=>'8668076684');

$varIPLocation = getIptoLocation(); // Returns like IN, BD, UK, US etc

if (array_key_exists($varIPLocation, $arrLiveHelpCountries)) {
		$$varCountry = $arrLiveHelpCountries[$varIPLocation];
}//if

$varLiveHelpNo	= $arrLiveHelpNo[$$varCountry];

setrawcookie("liveHelpNo","$varLiveHelpNo", "0", "/",$confValues['DOMAINNAME']);
?>
<style>
body{
  margin: 0px;padding: 0px;background:url(http://img.christianmatrimony.com/images/pm/ch-bg.jpg);
}
</style>
<html>
<body>

<?
echo '<font style="color:#fff;font-weight:bold;font-family:Arial;font-size:17px;">'.$varLiveHelpNo.'</font>';
?>

</body>
</html>