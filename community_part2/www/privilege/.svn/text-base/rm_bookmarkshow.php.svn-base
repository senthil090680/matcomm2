<?php
/****************************************************************************************************
	File		: bookmarkshow.php
	Author		: PadmaLatha.P				
	Date		: 07-March-2008			
	*****************************************************************************************************
	Description	:
		Show bookmark info on view profile page.,
********************************************************************************************************/
//Include the files .,
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($DOCROOTPATH);
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14";
include_once $DOCROOTBASEPATH."/bmconf/bmvars.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";	// For getDomainInfo().,
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14";

// Checking Cookie Set.,
	if(!(isset($_COOKIE['LOGININFO']['MEMBERID']))) {
		//header('Location: http://'.$GETDOMAININFO['domainmodule'].'/login/login.php');
		echo"<div style='padding: 5px 10px 5px 10px;'><div class='smalltxt divborder' style='padding: 5px 10px 5px 10px;'>Your session has expired or you have loggedout please <a href=\"http://".$GETDOMAININFO['domainmodule']."/login/login.php\" class='clr1'>Click here to login again.</A></div></div>";
		exit;
	}

// Vars.,
$memberid			=	$COOKIEINFO['LOGININFO']['MEMBERID'];
$domainarray_mid	= getDomainInfo(1,$COOKIEINFO['LOGININFO']['MEMBERID']);		//Logged Member..,

$db_slave			= new db();
$db_slave->dbConnById(2,$memberid,"S",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);

$dbprofiletable_bookmark = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['RMBOOKMARKED'];
$dbprofiletable_ignore = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['IGNORED'];
$dbprofiletable_block = $DBNAME['MATRIMONYLOG'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['BLOCKED'];

 $typesent= $_REQUEST['type'];
 $bookmarkedid = $_REQUEST['bookmarkedid'];


if($typesent=="b"){
   $event ="Shortlist";
   $bookmarkinfo = getBookmarkInfo($memberid,$bookmarkedid,$db_slave,$dbprofiletable_bookmark);
}
if($typesent == "i"){
   $event ="Ignore";
   $bookmarkinfo = getIgnoreInfo($memberid,$bookmarkedid,$db_slave,$dbprofiletable_ignore);
}
if($typesent == "block"){
   $event ="Block Member";
   $bookmarkinfo = getBlockInfo($memberid,$bookmarkedid,$db_slave,$dbprofiletable_block);
}

?>
 <div style="padding-left:5px;padding-right:3px;">
     <div style="padding: 5px 10px 5px 10px;"><font class='mediumtxt boldtxt clr3'><?=$event?> Member</font>
	 <div style="border: 1px solid #ccc;">
    <div style="padding:10px;">

		 <div class="smalltxt boldtxt"><font class='mediumtxt boldtxt'><?=$event?> Date </font></div>
        <?
        if(trim($bookmarkinfo[0])=="" || trim($bookmarkinfo[0])==" "){
	    echo "<div class='smalltxt' style='padding-top:5px'><font class='smalltxt'>-</font></div>";
        }
        else{
	    echo "<div class='smalltxt' style='padding-top:5px'><font class='smalltxt'>".$bookmarkinfo[0]."</font></div>";
        }?>
      <!-- <div class='poppadding poppadding1'> -->
	  <div class="smalltxt boldtxt"style='padding-top:5px'><font class='mediumtxt boldtxt'>Comments</font></div>
   <?
     if(trim($bookmarkinfo[1])=="" || trim($bookmarkinfo[1])==" "){            	// Check If NULL
	 echo "<div class='smalltxt' style='padding-top:5px'><font class='smalltxt'>-</font></div>";
     }
    else{
    echo "<div class='smalltxt' style='padding-top:5px'><font class='smalltxt'>".$bookmarkinfo[1]."</font></div>";
    }
   ?>
 </div>
    </div>
     </div>
      <div class='fright'style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:close_div();'></div>
  </div>
<?
//Function for bookmark
function getBookmarkInfo($matriid,$bid,$dblink,$tablename) {
    $sql="SELECT date_format(TimeBookmarked,'%d-%b-%Y') AS TimeBookmarked, Comments FROM $tablename WHERE MatriId='$matriid' and BookmarkedId='$bid'";
    if ($dblink->select($sql)> 0) {
       return $dblink->fetchArray();
     } 
    else 
      return '';
  }
//Function for ignore
function getIgnoreInfo($matriid,$bid,$dblink,$tablename) {
    $selectsql="select date_format(TimeIgnored,'%d-%b-%Y') AS TimeIgnored, Comments from $tablename where MatriId='$matriid' and IgnoredId='$bid'";
    if ($dblink->select($selectsql)> 0) {
         return $dblink->fetchArray();
       }  
    else 
       return '';  
     }

//Function for block
function getBlockInfo($matriid,$bid,$dblink,$tablename) {
    $selectsql="select date_format(TimeBlocked,'%d-%b-%Y') AS TimeBlocked, Comments from $tablename where MatriId='$matriid' and BlockedId='$bid'";
    if ($dblink->select($selectsql)> 0) {
         return $dblink->fetchArray();
       }  
    else 
       return '';  
     }


	?>