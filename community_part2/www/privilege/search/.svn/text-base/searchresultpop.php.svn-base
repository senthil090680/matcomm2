<?php
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";


if($_REQUEST['getp']=="refine"  && $_REQUEST['type']=="agerange") {
	displayCont("Enter age range.");	
	exit;
}

if($_REQUEST['getp']=="sendm") {	
	displayCont("Please select the profile(s) you would like to contact.");	
	exit;
}
if($_REQUEST['getp']=="exp" && $_REQUEST['t']=="") {
	displayCont("For you to express interest, you must select at least one profile.");
	exit;
} else if($_REQUEST['getp']=="exp" && $_REQUEST['t']=="f") {
	displayCont("Please select the profile(s) you would like to express interest in.");
	exit;
}

if($_REQUEST['getp']=="fwd" && $_REQUEST['t']=="") {
	displayCont("Please select atleast one profile to Forward.");
	exit;
} else if($_REQUEST['getp']=="fwd" && $_REQUEST['t']=="f") {
	displayCont("Please select the profile(s) you would like to forward.");
	exit;
}

if($_REQUEST['getp']=="rect" && $_REQUEST['t']=="s") {
	displayCont("Select checkbox to delete the Recently Viewed profiles.");
	exit;
}
else if($_REQUEST['getp']=="rect" && $_REQUEST['t']=="f") {
	displayCont("Please select the profile(s) you would like to delete from your recently viewed list.");
	exit;
}

if($_REQUEST['getp']=="sd") {
	displayConfirm("Are you sure you want to delete this saved search?");
	exit;
}

if($_REQUEST['getp']=="lv" && $_REQUEST['t']=="s") {
	displayRecentViewConfirm("Are you sure you want to delete?");
	exit;
}
else if($_REQUEST['getp']=="lv" && $_REQUEST['t']=="f") {
	displayRecentViewConfirm("Are you sure you want to delete the profile(s) from your recently viewed list?");
}
function displayCont($str){
?>
<div style="padding: 0px 20px 0px 20px;">	   
   <div style="border: 1px solid #ccc;">
		  <div style="padding:10px;">
		  <div class="smalltxt"><?=$str;?></div>
		  </div>
   </div>
	<div class="fright" style="padding-top:10px;"><input type="button" class="button" value="Close" onclick="javascript:close_div();"></div>
  </div>
<?php }

function displayConfirm($str){
?>
<div style="padding: 0px 20px 0px 20px;">	 
<div class="mediumhdtxt boldtxt clr3" style="padding-bottom:3px;"> Saved Search</div>
   <div style="border: 1px solid #ccc;" >
		  <div style="padding:10px;">
		  <div class="smalltxt" id="contd"><?=$str;?></div>
		  </div>
   </div>
	<div class="fright" style="padding-top:5px;" id="yesnodiv"><input type="button" class="button" value="Yes" onclick="javascript:delsavesearchajaxreq('<?=$_REQUEST['sval'];?>','<?=$_REQUEST['saved_divname'];?>');">&nbsp;<input type="button" class="button" value="No" onclick="javascript:close_div();"></div>
	<div class="fright" style="display:none;padding-top:10px;" id="clsdiv"><input type="button" class="button" value="Close" onclick="javascript:close_div();"></div>
  </div>
<?php }
function displayRecentViewConfirm($str){
?>
<div style="padding: 0px 20px 0px 20px;">	 
<div class="mediumhdtxt boldtxt clr3" style="padding-bottom:3px;"> Recently viewed profiles</div>
   <div style="border: 1px solid #ccc;" >
		  <div style="padding:10px;">
		  <div class="smalltxt" id="contd"><?=$str;?></div>
		  </div>
   </div>
	<div class="fright" style="padding-top:5px;" id="yesnodiv"><input type="button" class="button" value="Yes" onclick="javascript:deleteRecentlyviewed(<?=$_REQUEST['p'];?>,'<?=$_REQUEST['c'];?>');">&nbsp;<input type="button" class="button" value="No" onclick="javascript:close_div();"></div>
	<div class="fright" style="display:none;padding-top:10px;" id="clsdiv"><input type="button" class="button" value="Close" onclick="javascript:close_div();"></div>
  </div>
<?php }
?>

