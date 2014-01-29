<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Login
#=============================================================================================================
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');

$evid      = trim($_GET['evid']);
$gender    = $_COOKIE['Gender'];
if($gender=='M'){
$sage =18;
$eage =30;
}else{$sage =21;$eage =33;}
$HEIGHTVALUE = array("121","124","127","129","132","134","137","139","142","144","147","149","152","154","157","160","162","165","167","170","172","175","177","180","182","185","187","190","193","195","198","200","203","205","208","210","213","215","218","221","223","226","228","231","233","236","238","241");


$HEIGHTDISPLAYPARTNER = array("4ft - 121 cm","4ft 1in - 124cm","4ft 2in - 127cm","4ft 3in - 129cm","4ft 4in - 132cm","4ft 5in - 134cm","4ft 6in - 137cm","4ft 7in - 139cm","4ft 8in - 142cm","4ft 9in - 144cm","4ft 10in - 147cm","4ft 11in - 149cm","5ft - 152cm","5ft 1in - 154cm","5ft 2in - 157cm","5ft 3in - 160cm","5ft 4in - 162cm","5ft 5in - 165cm","5ft 6in - 167cm","5ft 7in - 170cm","5ft 8in - 172cm","5ft 9in - 175cm","5ft 10in - 177cm","5ft 11in - 180cm","6ft - 182cm","6ft 1in - 185cm","6ft 2in - 187cm","6ft 3in - 190cm","6ft 4in - 193cm","6ft 5in - 195cm","6ft 6in - 198cm","6ft 7in - 200cm","6ft 8in - 203cm","6ft 9in - 205cm","6ft 10in - 208cm","6ft 11in - 210cm","7ft - 213cm","7ft 1in - 215cm","7ft 2in- 218cm","7ft 3in- 221cm","7ft 4in- 223cm","7ft 5in- 226cm","7ft 6in- 228cm","7ft 7in- 231cm","7ft 8in- 233cm","7ft 9in- 236cm","7ft 10in- 238cm","7ft 11in- 241cm");

?>
<!--Search Form-->
<FORM name="MEETSRCH" METHOD=POST ACTION="dosearch.php?evid=<?=$evid?>&ln=" target="_blank" onsubmit="">
<div class="dotsep2"><img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="1" /></div><br clear="all">
	<div class="smalltxt fleft tlright" style="width:125px;">Marital status</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
        <input type="checkbox" id="MARITAL_STATUS1" name="MARITAL_STATUS1" value="" onclick="martial_any();" checked>Any <input type="checkbox" id="MARITAL_STATUS2" name="MARITAL_STATUS2" value="Unmarried" onclick="martial_other();">Unmarried <input type="checkbox" name="MARITAL_STATUS3" id="MARITAL_STATUS3" value="Widow/Widower" onclick="martial_other();">Widow / Widower <br><input type="checkbox" id="MARITAL_STATUS4"  name="MARITAL_STATUS4" value="Divorced" onclick="martial_other();">Divorced <input type="checkbox" id="MARITAL_STATUS5" name="MARITAL_STATUS5" value="Separated" onclick="martial_other();">Separated
	</div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>

	<div class="smalltxt fleft tlright" style="width:125px;">Age</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
	<input type="text" class="inputtext" name="STAGE" value="<?=$sage;?>" maxlength="2" size="2" tabindex="3" id="STAGE" onblur="validateAge(this.form,'<?=$gender;?>');"/>&nbsp;&nbsp;to&nbsp;&nbsp;<input type="text" name="ENDAGE" id="ENDAGE" class="inputtext" tabindex="4" value="<?=$eage;?>" maxlength="2" size="2" onblur="validateAge(this.form,'<?=$gender;?>');"/>
	</div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>
	
	<div class="smalltxt fleft tlright" style="width:125px;">Height</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
	<select class="inputtext" style="width: 110px;" tabindex="5" size="1" NAME="STHEIGHT" id="STHEIGHT">
	<?php for($i=0;$i<count($HEIGHTVALUE);$i++) { ?>
                     <option value="<?php echo  str_replace(" ","_",$HEIGHTVALUE[$i]);?>"><?php echo  $HEIGHTDISPLAYPARTNER[$i];?></option>
	<?}?>
		</select> to <select class="inputtext" style="width: 110px;" tabindex="6" size="1" NAME="ENDHEIGHT" id="ENDHEIGHT" size="1">
				<?php for($i=0;$i<count($HEIGHTVALUE);$i++) {
               
					if($i == count($HEIGHTVALUE)-1 ) {
					$selected = 'selected="selected"';
					}
				   else {$selected ='';}
				   ?>
                     <option value="<?php echo  $HEIGHTVALUE[$i]?>" <?php echo $selected; ?> ><?php echo  $HEIGHTDISPLAYPARTNER[$i];?></option>

			   <? } ?>
		</select>
	</div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>
	
	<? if (sizeof($arrGetSubcasteOption)>1) { ?>
	<div class="smalltxt fleft tlright" style="width:125px;">Subcaste</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
	<select class="inputtext" style="width: 215px !important;width: 214px;" NAME="SUBCASTE" id="SUBCASTE">
	<option value="" selected>Any</option>
	<?php foreach($arrGetSubcasteOption as $varKey=>$varVal){?>
	<option value="<?=str_replace(" ","_",$varVal);?>"><?=$varVal?></option>
	<?}?>
	</select></div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>
	<? } ?>

	<div class="smalltxt fleft tlright" style="width:125px;">Education</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
	<select class="inputtext" style="width: 215px !important;width: 214px;" NAME="EDUCATION" id="EDUCATION">
	<option value="" selected>Any</option>
	<?php foreach($arrEducationList as $varKey=>$varVal){?>
	<option value="<?=str_replace(" ","_",$varVal);?>"><?=$varVal?></option>
	<?}?>
	</select>
	</div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>

	<div class="smalltxt fleft tlright" style="width:125px;">Citizenship</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
	<select class="inputtext" style="width: 215px !important;width: 214px;" NAME="CITIZENSHIP" id="CITIZENSHIP">
	<option value="" selected>Any</option>
	<?php foreach($arrCountryList as $varKey=>$varVal){?>
	<option value="<?=str_replace(" ","_",$varVal);?>"><?=$varVal?></option>
	<? } ?>
	</select>
	</div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>

	<div class="smalltxt fleft tlright" style="width:125px;">Country living in</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;">
	<select class="inputtext" style="width: 215px !important;width: 214px;" NAME="COUNTRY" id="COUNTRY">
	<option value="" selected>Any</option>
	<?php  foreach($arrCountryList as $varKey=>$varVal){?>
	<option value="<?=str_replace(" ","_",$varVal)?>"><?=$varVal?></option>
	<? } ?>
	</select>
	</div><br clear="all">
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif"	width="1" height="9" /><br>

	<div class="smalltxt fleft tlright" style="width:125px;">&nbsp;</div>
	<div class="smalltxt fleft" style="width:240px !important;width:250px;padding-left:10px;"><font class="smalltxt">
	<input type="hidden" name="SEARCH_TYPE" value="DOSEARCH" id="SEARCH_TYPE">
	<input type="checkbox" name="PHOTO_OPT" id="PHOTO_OPT" value="Y"/> Show with photo</font>
	<img src="http://<?=$_SERVER[SERVER_NAME];?>/images/trans.gif" width="50" height="1" />
	<input type="button" class="button" value="Submit" onClick="searchInitiate()">
	</div>
</form>
<!--Search Form-->