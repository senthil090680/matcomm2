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

$in         = $_REQUEST["in"];
$objSlaveDB = new db(); // For Slave Connection...

if (isset($_REQUEST["ID"]) && $_REQUEST["ID"]!="" && strlen(trim($_REQUEST["ID"])) > 0) {
	$memid = $_REQUEST["ID"];
	$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

	if(!$objSlaveDB->clsErrorCode) {
	$options = ""; 
    
	if (isset($_REQUEST["SID"]) && $_REQUEST["SID"]!="" && strlen(trim($_REQUEST["SID"])) > 0) {
		$whereid = $_REQUEST["SID"];
		$varFields					= array('District');
	    $varCondition	            = " where StateId= ".$objSlaveDB->doEscapeString($whereid,$objSlaveDB)." order by District";
	    $districtResult				= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, $varCondition,1);

		foreach($districtResult as $key=>$row) {
			if ( $row['District'] == $in ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$options .= "<option value=\"".$row['District']."\" $selected>".$row['District']."</option>";
		}
		echo $options;
	}
	elseif (isset($_REQUEST["con"]) && $_REQUEST["con"]=="others") {

		$varFields					= array('City');
	    $varCondition	            = " order by City";
	    $CityResult 				= $objSlaveDB->select($varTable['HOROALLCOUNTRIESCITIES'], $varFields, $varCondition,1);

		foreach($CityResult as $key=>$row) {
			if ( $row['City'] == $in ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$options .= "<option value=\"".$row['City']."\" ".$selected.">".$row['City']."</option>";
		}
		echo $options;
	}
}
else{
?>
  <div class="smalltxt" style="margin-left:5px;">
    <div class="mediumtxt1 boldtxt" style="padding-left:25px;padding-right:10px;"><?=$ERRORMSG?></div>
  </div>
<?php
}
}
 $objSlaveDB->dbClose(); // Slave Connection Closed Here...
?>