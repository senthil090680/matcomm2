<?php
/****************************************************************************************************
File	: bookmarked_list.php
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
		echo"<div class='smalltxt divborder' style='padding: 5px 10px 5px 10px;'>Your session has expired or you have loggedout please <a href=\"http://".$GETDOMAININFO['domainmodule']."/login/login.php\"  class='clr1'>Click here to login again.</A></div>";
		exit;
	}
// $_REQUEST['MEMID_RMINTER'] value get from rm interface. 
$rm_matriid = $_REQUEST['MEMID_RMINTER'];
$MEMBERID = $COOKIEINFO['LOGININFO']['MEMBERID'];
$GENDER = $COOKIEINFO['LOGININFO']['GENDER'] ;
$domaininfoarr = getDomainInfo();

$dbslave = new db();
$domainlang = $dbslave->dbConnById(2,$MEMBERID,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
if($dbslave->error) $ERRORFLAG = 1;

if($_GET["loadpage"]) {

	 $curpage = $_GET["loadpage"];
}
else {
	$curpage = 1;
}
$endlimit = 10;
$startlimit = round(($curpage-1)*$endlimit);

$bookmarktbl = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[$domainlang]['RMBOOKMARKED'];
$selqry = "select BookmarkedId, TimeBookmarked, Comments from ".$bookmarktbl." where MatriId='".$MEMBERID."'";
$extrafield = " order by TimeBookmarked desc limit ".$startlimit.",".$endlimit;

$totalRec = $dbslave->select($selqry);
$selqry = $selqry . $extrafield;
$total = $dbslave->select($selqry);
$resultrow  = $dbslave->getResultArray();
if($total > 0) {
	foreach($resultrow as $rs) {
		$markedid = $rs['BookmarkedId'];
		$markedTime[$markedid] = $rs['TimeBookmarked'];
		$comments[$markedid] = $rs['Comments'];
		$markedIdArr[] = $markedid; 
		if(strlen($rs['Comments']) > 25) {
			$body2 = substr($rs['Comments'],0,25);
			$comments[$markedid] = html_entity_decode($body2);
			$overflow[$markedid] = 1;
		}
		else {
			$comments[$markedid] = $rs['Comments'];
			$overflow[$markedid] = 0;
		}
	}
	$totpages = ceil($totalRec/$endlimit);
}
echo $totpages."|~|".$curpage."|~|rm_bookmarklist.php|~|".$totalRec."|~|";
if($total > 0) {
	if($_REQUEST['MEMID_RMINTER']==''){ 
?>
 <div style="padding: 3px 12px 0px 5px;display:block;" class="smalltxt" id="con">This folder displays the list of members short-listed by you. If you want to remove a member from this list, click on the "Delete" link.
</div><br clear="all">
<? } ?>
<div style="width:506px;"><!-- 506 -->
	<form name="bkfrm" style="margin:0px;">
	<? if($_REQUEST['MEMID_RMINTER']==''){ ?>
	<div class="smalltxt">
		<div class="fleft"><input type="checkbox" name="selall" onclick="selallcheckBk();"></div> 
		<div class="fleft" style="padding-top:2px;">Select All </div>
		<div class="fleft errortxt" id="errdiv" style="padding-left:10px;padding-top:2px;"></div>
		<div class="smalltxt" style="float:right; padding:5px;"><a href="javascript:unblockall('basicview_0',1)" class="clr1">Delete All</a></div><br clear="all">
	</div>
	<!--{ Basic View Template -->
<?}
	$usrArr = basicView($markedIdArr, 1, $dbslave);
	for($i=0;$i<count($markedIdArr);$i++) { 
		
?>
<div id="basicview_<?=$i?>" style="padding-bottom:20px;">
<?  if($_REQUEST['MEMID_RMINTER']==''){ ?>
			<div style="padding-left:2px;"><div class="borderline" style="width:500px;"><img src="http://<?=$domaininfoarr['domainnameimgs']?>/bmimages/trans.gif" height="1"></div></div><br clear="all"><!-- 508 -->

			<div class="fleft" style="width:500px;"><!-- middiv2 -->
				<div class="fleft"><input type="checkbox" name="del[]" value="<?=$markedIdArr[$i]?>" id="delid<?=$i?>" onclick="checkallcheckBk();"></div> 
				<div class="fleft vc6pd-top smalltxt1">Select this profile </div>
				<div class="fright">
					  <div class="fleft smalltxt"><a href="javascript:;" class="clr1"onclick="unblockselected('delid<?=$i?>','basicview_<?=$i?>',1);">Delete</a></div> 
					<?if($usrArr[$markedIdArr[$i]."_status".$i] == 0) { ?>
					<div class="fleft smalltxt" style="padding-left:10px;"><a href="http://<?=$domaininfoarr['domainmodule']?>/search/smartsearch.php?t=S&DISPLAY_FORMAT=one&ID=<?=$markedIdArr[$i]?>&SEARCH_TYPE=SIMILAR&GENDER=<?=($GENDER=='F')?'M':'F'?>" target="_blank" class="clr1">Similar Profiles</a></div>
				    <? } ?>
				</div><? } ?>
 			</div><br clear="all">
<?
			echo $usrArr[$markedIdArr[$i]."_".$i];
			echo "<br clear=\"all\">";
?>
			<div style="float:left; border:1px solid #CFCFCF;">
				<div style=" width:500px;"><!-- 504px -->
					<div class="smalltxt" style="float:left; padding: 3px 0px 0px 10px;"><b>Comments</b>: <?=$comments[$markedIdArr[$i]]?>  
					<?
					if($overflow[$markedIdArr[$i]] == 1) {
					?> 
						... <a href="javascript:;" class="clr1" onclick="javascript:fade('basicview_<?=$i?>','fadediv','dispdiv','500','','','http://<?=$domaininfoarr['domainmodule']?>/privilege/rm_bookmarkshow.php?type=b&ran=<?=genRandom()?>&bookmarkedid=<?=$markedIdArr[$i]?>','','dispcontent','','refreshDiv');">More</a>
					<?
					}
					?>
					</div>
				</div>
			</div><br clear="all">			
		</div>
<?
	}
?>
	</form>
	 <!-- Short list Content End -->
<?
}
else {
?>
 <div style="float:left;padding-left:5px;">
      <div class="smalltxt" style="padding-top:10px;width:504px; height:30px; text-align:left;">The profiles short-listed by you will be displayed here.</div>
</div> <br clear="all">
	<!-- <div style="float:left;padding-left:15px;"> -->
	<div style="float:left;padding-left:5px;">
	      <div class="smalltxt" style="padding-top:15px;width:504px; height:60px; text-align:left;"><b>Currently there are no profiles in this folder.</b></div>
   	  </div><br clear="all">
<?
} ?></div>