<?php
#================================================================================================================
# Author 	: Srinivasan
# Date		: 20-May-2010
# Project	: MatrimonyProduct
# Filename	: generateHoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

$countryname = $_GET["country"];
$statename = $_GET["states"];
$cityname = $_GET["city"];
$gender = $_GET["gender"];
$memberid = $_GET["memid"];

$objSlaveDB = new db();
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

if(!$objSlaveDB->error){

function selectArrayHashNew($countryid,$stateid,$cityid,$memberid,$objSlaveDB) 
{   
	global $varTable;
   
	$varFields					= array('City_Name','Longitude','Latitude','Timezone');
	$varCondition	            = " where State_Id= ".$objSlaveDB->doEscapeString($stateid,$objSlaveDB)." and City_Id=".$objSlaveDB->doEscapeString($cityname,$objSlaveDB);
	$districtResult				= $objSlaveDB->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
	$datastro                   = mysql_fetch_array($districtResult);
	

	$placename = $datastro["City_Name"];
	$longiarray = explode(".",$datastro["Longitude"]);
	$longitudedeg = $longiarray[0];
	$longitudemin = substr($longiarray[1],0,2);
	$longdir = substr($longiarray[1],2,1);
	$latiarray = explode(".",$datastro["Latitude"]);
	$latitudedeg = $latiarray[0];
	$latitudemin = substr($latiarray[1],0,2);
	$latdir = substr($latiarray[1],2,1);
	$timezone = $datastro["Timezone"];
	$out = $placename."~".$longitudedeg."~".$longitudemin."~".$longdir."~".$latitudedeg."~".$latitudemin."~".$latdir."~".$timezone;
	return ($out);
}
echo selectArrayHashNew($countryname,$statename,$cityname,$memberid,$objSlaveDB);
$objSlaveDB->dbClose(); // Slave Connection Closed Here...
}
else{
?>
  <div class="smalltxt" style="margin-left:5px;">
    <div class="mediumtxt1 boldtxt" style="padding-left:25px;padding-right:10px;"><?=$ERRORMSG?></div>
  </div>
<?php
}
?>