<?

$varIVRSPhoneNo	= $argv[1];
$varCountryCode	= $argv[2];
$varIVRSOrderId	= $argv[3];

if($varIVRSPhoneNo!='' && $varCountryCode!='' && $varIVRSOrderId!=''){

ini_set('default_socket_timeout', 5);

$sIvrUrl = file_get_contents("http://ivrs.bharatmatrimony.com/click2call.php?visitor=$varIVRSPhoneNo&customer=9006&id=$varIVRSOrderId&bu=15&duration=3600000");

$sIvrUrl = trim(strip_tags($sIvrUrl));

}

 ?>