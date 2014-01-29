<?php
#=============================================================================================================
# Author 		: Jeyakumar N
# Start Date	: 18 Sep 2008
# End Date	    : 18 Sep 2008
# Project		: MatrimonyProduct
# Module		: Lists - Delete
#=============================================================================================================
//Base Path //
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
// Include the files //
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");


// Object Declaration //
$objDb	= new DB();
$objDb1	= new DB();
$objDb->dbConnect('S', $varDbInfo['DATABASE']);
$objDb1->dbConnect('M', $varDbInfo['DATABASE']);

//Variable Declaration
$varSessionId	= mysql_real_escape_string($varGetCookieInfo['MATRIID']);
$varDisplayMsg	= "";

//VARIABLE DECLARATION
$varListIds		= mysql_real_escape_string($_REQUEST["id"]);
$varMatriIds	= "'".str_replace("~","','",$varListIds)."'";
$varPurpose		= $_REQUEST["purp"];
$varListDisp	= ($varPurpose=='SL')?'Favourites':'Block';
$varStatField = ($varPurpose=='SL')?'ProfilesBookMarked':'ProfilesBlocked';

$varListTable	= ($varPurpose=='SL')?$varTable['BOOKMARKINFO']:$varTable['BLOCKINFO'];
$varListField	= ($varPurpose=='SL')?'Bookmarked':'Blocked';
$varListFields	= array($varListField);
$varListFieldVal= array(0);
$varListCond	= " MatriId=".$objDb1->doEscapeString($varSessionId,$objDb1)." AND Opposite_MatriId IN (".$varMatriIds.")";
$varDelete		= $objDb1->delete($varListTable,$varListCond);
$varUpdateAct	= $objDb1->update($varTable['MEMBERACTIONINFO'],$varListFields,$varListFieldVal,$varListCond);


// Update Member statistics table //

$argCondition	= " WHERE MatriId=".$objDb1->doEscapeString($varSessionId,$objDb1)." AND ".$varListField."=1";
$varTotalListCnt	= $objDb1->numOfRecords($varListTable, 'MatriId', $argCondition);

$varStatFields = array($varStatField,'DateUpdated');
$varStatFieldsValues = array($varTotalListCnt,'NOW()');
$varSatCond = " MatriId =".$objDb1->doEscapeString($varSessionId,$objDb1);
$varUpdateAct	= $objDb1->update($varTable['MEMBERSTATISTICS'],$varStatFields,$varStatFieldsValues,$varSatCond);

include($varRootBasePath."/www/login/updatemessagescookie.php");
setMessagesCookie($varSessionId,$objDb);

echo "<div class='viewdiv1 fright tlright' style='width:440px;'><img src='".$confValues['IMGSURL']."/close.gif' class='pntr' onclick='hidediv(\"errorDiv\");funListMain(\"".$varPurpose."\");'/></div><br clear='all'> This member has been removed from your ".$varListDisp." List.";

//UNSET OBJECT
$objDb->dbClose();
$objDb1->dbClose();
unset($objDb);
unset($objDb1);
?>
