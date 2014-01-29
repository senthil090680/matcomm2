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
		echo"<div style='padding: 5px 10px 5px 10px;'><div class='smalltxt divborder' style='padding: 5px 10px 5px 10px;'>Your session has expired or you have loggedout please <a href=\"http://".$GETDOMAININFO['domainmodule']."/login/login.php\" class='clr1'>Click here to login again.</A></div></div>";
		exit;
	}
$MEMBERID = $COOKIEINFO['LOGININFO']['MEMBERID'];

$domaininfoarr = getDomainInfo(1,$MEMBERID);		//Logged Member..,
$dbslave = new db();
$domainlang = $dbslave->dbConnById(2,$MEMBERID,"S",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);

$bookmarktbl = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[$domainlang]['RMBOOKMARKED'];
$ignoretbl =  $DBNAME['MATRIMONY'].".".$DOMAINTABLE[$domainlang]['IGNORED'];
$dbprofiletable_cross = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE'];

$type = $_REQUEST['type'];
$bookmarkedid = $_REQUEST['bookmarkedid'];
$operation = $_REQUEST['operation'];
$divname_search  =  $_REQUEST['divname'];
$divname_ig  =  $_REQUEST['divname_1'];
$divname_link  =  $_REQUEST['shlink'];

if(isset($_GET['bookmarkedid'])) {
	if($type == "b") {
	     $bookmarkinfo = getShortlistDetails($MEMBERID,$bookmarkedid,$dbslave,$bookmarktbl);
		 $event ="Shortlist";
		  $event1 = "Shortlist.";
		  $icon_disp = "<div class=\"useracticonsimgs shortlist fleft\"  title=\"This member is currently in your Shortlist.\" ></div>"; 
		  $del_content = "Are you sure you want to delete this member from your Shortlist?";

	}
	if($type == "i") {
         $bookmarkinfo = getIgnoreDetails($MEMBERID,$bookmarkedid,$dbslave,$ignoretbl);
		 $event ="Ignore";
		 $event1 ="Ignore List.";
		 $icon_disp = "<div class=\"useracticonsimgs ignore fleft\" style=\"padding: 0px 0px 0px 3px;\"></div>";
		  $del_content = "Are you sure you want to delete this member from your Ignore List?";
	}
}


?>

<div id="list">
<?
if((count($bookmarkinfo) > 0) && $operation == 'a') {

	if($bookmarkinfo["Comments"] == "")
	{
		$comments_disp = $bookmarkedid."&nbsp; has been added to your ".$event1;
	}
	else {
		$comments_disp = $bookmarkinfo["Comments"];
	}
?>
	<?
	$sel_gender_query="select Name from ".$dbprofiletable_cross." where MatriId='".$bookmarkedid."'";

	 if($dbslave->select($sel_gender_query)){
		$row1	= $dbslave->fetchArray();
		$bookmarked_name = $row1['0'];
	 }?>
	 <div style='width:375px;'>

    <div style="padding: 5px 8px 5px 10px;">
		<div id="useracticons">
		<div id="useracticonsimgs">
			<div class='fleft mediumtxt boldtxt clr3'><?=$event?> <?=strToTitle($bookmarked_name)?> (<?=$bookmarkedid?>)</div>		
			<div class="fleft" style="padding-left:5px;"><!-- <?=$icon_disp?> --></div>
		</div>
		</div><br clear="all">

	<div style="padding:2px;"></div>
   <div style="border: 1px solid #ccc;">
    <div style="padding:2px;">
   <div class="smalltxt boldtxt" style='padding:5px'><font class='mediumtxt boldtxt'> Comments:</font></div>
   <div class="smalltxt" style='padding:5px'><font class='smalltxt'><?=$comments_disp?></font></div>
 
     </div>
    </div>
     </div>
 
  <!-- <div class="fright" style="padding:5px 10px 0px 0px;"><input type='button' name='Button1' value='Edit' class='button' onclick="bookmarkedit('u','<?=$type?>','<?=$bookmarkedid?>','<?=$divname_search?>','<?=$divname_link?>');">
  <input type='button' name='Button2' value='Delete' class='button' onclick="bookmarkedit('d','<?=$type?>','<?=$bookmarkedid?>','<?=$divname_search?>','<?=$divname_link?>');"></div> --><br clear="all">
<?
}
else if($operation == 'a') { 
	$sel_gender_query="select Name from ".$dbprofiletable_cross." where MatriId='".$bookmarkedid."'";

	 if($dbslave->select($sel_gender_query)){
		$row1	= $dbslave->fetchArray();
		$bookmarked_name = $row1['0'];
	 }
?>
	
	 
	 
  <div style='width:375px;'>
  <form id='smart_pop_frm' name='smart_pop_frm' method="post" style="margin:0px;">
    <div style="padding: 5px 10px 5px 10px;"><font class='mediumtxt boldtxt clr3'><?=$event?> <?=strToTitle($bookmarked_name)?> (<?=$bookmarkedid?>)</font>
   <div style="border: 1px solid #ccc;">
    <div style="padding:12px;">
      <div class="smalltxt boldtxt">Comments</div>
     <input type='hidden' name='hid_label' value="<?=$operation?>" class="inputtext">
	<input type='hidden' name='pop_type'value="<?=$type?>" class="inputtext">
      <div><textarea name='Comments' cols='57' rows='5' id='Comments' class='inputtext' style="width:328px;" wrap="soft"></textarea></div>
     </div>
    </div>
     </div>
   <div style="padding:0 10 3px 0px;float:right;"><input type='button' name='Button' value='Submit' class="button" onclick="smart_pop_submit('<?=$bookmarkedid?>','<?=$divname_search?>','<?=$divname_ig?>',
	'<?=$divname_link?>');"></div><br clear="all">
   </form>
  </div>
 
<?
}
else if($operation == 'u') {
	 $sel_gender_query="select Name from ".$dbprofiletable_cross." where MatriId='".$bookmarkedid."'";

	 if($dbslave->select($sel_gender_query)){
		$row1	= $dbslave->fetchArray();
		$bookmarked_name = $row1['0'];
	 }
?>
	
	
		<div style='width:375px;'>
  <form id='smart_pop_frm' name='smart_pop_frm' method="post" style="margin:0px;">
    <div style="padding: 7px 10px 5px 10px;"><font class='mediumtxt boldtxt clr3'><?=$event?> <?=strToTitle($bookmarked_name)?> (<?=$bookmarkedid?>)</font>
   <div style="border: 1px solid #ccc;">
    <div style="padding:12px;">
      <div class="smalltxt boldtxt">Comments</div><!-- <div id="commentserr" class="errortxt"></div> -->
     <input type='hidden' name='hid_label' value="<?=$operation?>" class="inputtext">
	<input type='hidden' name='pop_type'value="<?=$type?>" class="inputtext">
      <div><textarea name='Comments' cols='57' rows='5' id='Comments' class='inputtext' style="width:328px;" wrap="soft"><?=$bookmarkinfo["Comments"]?></textarea></div>
     </div>
    </div>
     </div>
   <div style="padding:0 10 3px 0px;float:right;"><input type='button' name='Button' value='Update' class="button"onclick="smart_pop_submit('<?=$bookmarkedid?>','<?=$divname_search?>','<?=$divname_ig?>','<?=$divname_link?>');"></div>
   </form>
  </div>
	<?	
}
else if($operation == 'd') {

	 $sel_gender_query="select Name from ".$dbprofiletable_cross." where MatriId='".$bookmarkedid."'";

	 if($dbslave->select($sel_gender_query)){
		$row1	= $dbslave->fetchArray();
		$bookmarked_name = $row1['0'];
	 }
?>
	
	<div style='width:375px;'>
    <div style="padding: 5px 7px 5px 10px;">
	<div id="useracticons">
		<div id="useracticonsimgs">
		<?if($event == "Ignore"){$event ="Ignore List";}?>
			<div class='fleft mediumtxt boldtxt clr3'>Delete <?=strToTitle($bookmarked_name)?> (<?=$bookmarkedid?>) from <?=$event?></div>		
			<div class="fleft" style="padding-left:5px;"><!-- <?=$icon_disp?> --></div>
		</div>
		</div><br clear="all">
	<div style="padding:2px;"></div>
   <div style="border: 1px solid #ccc;">
    <div style="padding:10px;">
   <div class="smalltxt" style='padding:2px'><font class="smalltxt"><?=$del_content?></font></div>
     </div>
    </div>
     </div>
 
   <div class="fright" style="padding:5px 10px 0px 0px"><input type='button' name='Button1' value='Yes' class='button' onclick="smart_del_submit('<?=$bookmarkedid?>','<?=$type?>','<?=$operation?>','<?=$divname_search?>','<?=$divname_link?>');">
   <input type='button' name='Button2' value='No' class='button' onclick="close_div();"></div>
 
  </div>
<?
}
?>
</div>
<?
function getShortlistDetails($matriid,$bid,$dblink,$tablename) {
    $sql = "SELECT date_format(TimeBookmarked,'%d-%b-%Y') as TimeBookmarked, Comments FROM $tablename where MatriId='$matriid' and BookmarkedId='$bid'";
	$recCount = $dblink->select($sql);
	if($recCount > 0) {
		$resArr = $dblink->fetchArray();
	}
	else {
		$resArr = Array();
	}
	return $resArr;
}

function getIgnoreDetails($matriid,$bid,$dblink,$tablename) {
	$sql = "select date_format(TimeIgnored,'%d-%b-%Y') as TimeIgnored, Comments from $tablename where MatriId='$matriid' and IgnoredId='$bid'";
	$recCount = $dblink->select($sql);
	if($recCount > 0) {
		$resArr = $dblink->fetchArray();
	}
	else {
		$resArr = Array();
	}
	return $resArr;
}
?>