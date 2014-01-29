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

$sn         = $_REQUEST["statename"];
$sn         = str_replace('***',' & ',$sn);
$objSlaveDB = new db(); // For Slave Connection...

if (isset($_REQUEST["ID"]) && $_REQUEST["ID"]!="") {
	$memid = $_REQUEST["ID"];
	
	$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
	if(!$objSlaveDB->error){
	
	$varFields					= array('StateId','StateName');
	$varCondition	            = " order by StateName";
	$stateResult				= $objSlaveDB->select($varTable['HOROINDIANSTATES'], $varFields, $varCondition,1);
	$options = ""; 
	
	foreach($stateResult as $key=>$row) {
		if ( $row['StateName'] == $sn ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}

		$options .= "<option value=\"".$row['StateId']."\" ".$selected.">".$row['StateName']."</option>";
	}
	echo $options;
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