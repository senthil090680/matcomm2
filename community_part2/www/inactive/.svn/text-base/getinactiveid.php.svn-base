<?php
#=================================================================================================================
# Author 	  : Baranidharan M
# Date		  : 2010-10-18
# Project	  : MatrimonyProduct
# Filename	  : getinactiveid.php
#=================================================================================================================
# Description : getting inactive matriid from table. 
#=================================================================================================================

$varRootBasePath = '/home/product/community';
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath."/conf/basefunctions.cil14");

$objDBInactiveSlave = new DB;
$objDBInactiveSlave->dbConnect('S', $varInactiveDbInfo['DATABASE']);

//SELECT MATRIID FROM MEMBERINFO TABLE FROM CBSINACTIVE DATABASE
$varFields   = array('MatriId');
$varCondition  = '';
$varSelectMatriId = $objDBInactiveSlave->select($varTable['INACTIVEIDS'],$varFields,$varCondition,0);
 
while($varRow = mysql_fetch_assoc($varSelectMatriId)) {
 //execute php file from backend which is used for deleting msges in receiver side and sender side
 $varCmd = "php ".$varRootBasePath."/bin/deleteprofile_step1.php ".$varRow['MatriId'];
 $varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
 escapeexec($varCmd,$varlogFile);
 //exec($varCmd);
}
$objDBInactiveSlave->dbClose();
?>