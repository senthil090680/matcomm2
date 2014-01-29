<?
/****************************************************************************************************
File	: list.php
Author	: PadmaLatha .P
Date	: 02-March-2008
*****************************************************************************************************
Description	: 
	Description here
********************************************************************************************************/

// Include the files //
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";
include_once $DOCROOTPATH."/inbox/basictemplate.php"; 

// Checking Cookie Set.,
if(!(isset($_COOKIE['LOGININFO']['MEMBERID']))) {
		//header('Location: http://'.$GETDOMAININFO['domainmodule'].'/login/login.php');
		echo "<div class='smalltxt' style='padding: 5px 10px 5px 10px;'>Your session has expired or you have loggedout please <a href=\"http://".$GETDOMAININFO['domainmodule']."/login/login.php\" class='clr1'>Click here to login again.</A></div>";
		exit;
}

$MEMBERID = $COOKIEINFO['LOGININFO']['MEMBERID'];
$domaininfoarr = getDomainInfo();

//URL for Shortlist for RM interface
if($_GET["id"] == 1 && $_GET["MEMID_RMINTER"]) {
	$url = "http://".$domaininfoarr['domainmodule']."/privilege/rm_bookmarklist.php?MEMID_RMINTER=".$_GET["MEMID_RMINTER"]."&rand=".genRandom();
	$heading = "Shortlist";
}
//URL for Shortlist for BM
else if($_GET["id"] == 1) {
	$url = "http://".$domaininfoarr['domainmodule']."/memberlist/bookmarklist.php?rand=".genRandom();
	$heading = "Shortlist";
}
elseif($_GET["id"] == 2) { //URL for Ignore
	$url = "http://".$domaininfoarr['domainmodule']."/memberlist/ignorelist.php?rand=".genRandom();
	$heading = "Ignore List";
}
else { //URL for Block
	$url = "http://".$domaininfoarr['domainmodule']."/memberlist/blocklist.php?rand=".genRandom();
	$heading = "Block List";
}

?>

<img src="http://<?=$domaininfoarr['domainnameimgs']?>/bmimages/trans.gif" height="1" onload="javascript:SendHTTPRequestBK('<?=$url?>',bkBasicView)" style="display:none;">

<div style="float:left; width:506px;" ><!-- 506 -->
     <!-- <div style="float:left;"> -->
           <div class="fleft mediumtxt boldtxt clr3" style="padding: 0px 0px 0px 10px;"><?=$heading?></div> 
	<!--  </div> -->
	
	      <!-- <div style="width:510px;" class="smalltxt"> --><!-- 506 -->
		     <!--  <div class="fright" style="padding: 0px 0px 0px 0px;"> -->
			      <div class="fright" id="bkpaging" style="padding: 0px 0px 0px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/loading-icon.gif"></div>
		<!-- </div> -->
	<!-- </div> -->
</div>
<div style="float:left;padding-left:5px;" id='bkarea'></div>