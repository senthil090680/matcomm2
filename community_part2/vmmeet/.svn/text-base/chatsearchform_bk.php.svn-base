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

$evid=trim($_GET['evid']);

$HEIGHTVALUE = array("121","124","127","129","132","134","137","139","142","144","147","149","152","154","157","160","162","165","167","170","172","175","177","180","182","185","187","190","193","195","198","200","203","205","208","210","213","215","218","221","223","226","228","231","233","236","238","241");


$HEIGHTDISPLAYPARTNER = array("4ft - 121 cm","4ft 1in - 124cm","4ft 2in - 127cm","4ft 3in - 129cm","4ft 4in - 132cm","4ft 5in - 134cm","4ft 6in - 137cm","4ft 7in - 139cm","4ft 8in - 142cm","4ft 9in - 144cm","4ft 10in - 147cm","4ft 11in - 149cm","5ft - 152cm","5ft 1in - 154cm","5ft 2in - 157cm","5ft 3in - 160cm","5ft 4in - 162cm","5ft 5in - 165cm","5ft 6in - 167cm","5ft 7in - 170cm","5ft 8in - 172cm","5ft 9in - 175cm","5ft 10in - 177cm","5ft 11in - 180cm","6ft - 182cm","6ft 1in - 185cm","6ft 2in - 187cm","6ft 3in - 190cm","6ft 4in - 193cm","6ft 5in - 195cm","6ft 6in - 198cm","6ft 7in - 200cm","6ft 8in - 203cm","6ft 9in - 205cm","6ft 10in - 208cm","6ft 11in - 210cm","7ft - 213cm","7ft 1in - 215cm","7ft 2in- 218cm","7ft 3in- 221cm","7ft 4in- 223cm","7ft 5in- 226cm","7ft 6in- 228cm","7ft 7in- 231cm","7ft 8in- 233cm","7ft 9in- 236cm","7ft 10in- 238cm","7ft 11in- 241cm");

?>
<script>


function chkClickedEducation() {

var f = document.getElementById("EDUCATION1");
var cnt=0;
for (var i=0;i<f.length;i++)
{
        if(document.MEETSRCH["EDUCATION[]"][i].selected)
		{ 
		   cnt = eval(parseInt(cnt)+1)
		   
		}
}

return cnt;
}

function chkClickedCountry() {

var f = document.getElementById("COUNTRY1");
var cnt=0;
for (var i=0;i<f.length;i++)
{
        if(document.MEETSRCH["COUNTRY[]"][i].selected)
		{ 
		   cnt = eval(parseInt(cnt)+1)
		   
		}
}

return cnt;
}
 



</script>
<!--Search Form-->
<FORM name="MEETSRCH" METHOD=POST ACTION="dosearch.php?evid=<?=$evid?>&ln=" target="_blank" onsubmit="">
<table border="0" cellpadding="0" cellspacing="0" width="360">
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Marital status</td>
<td valign="top" class="normaltxt1">
<input type="checkbox" id="MARITAL_STATUS1" name="MARITAL_STATUS1" value="Any" onclick="martial_any();" checked>Any <input type="checkbox" id="MARITAL_STATUS2" name="MARITAL_STATUS2" value="Unmarried" onclick="martial_other();">Unmarried <input type="checkbox" name="MARITAL_STATUS3" id="MARITAL_STATUS3" value="Widow/Widower" onclick="martial_other();">Widow / Widower <br><input type="checkbox" id="MARITAL_STATUS4"  name="MARITAL_STATUS4" value="Divorced " onclick="martial_other();">Divorced <input type="checkbox" id="MARITAL_STATUS5" name="MARITAL_STATUS5" value="Separated" onclick="martial_other();">Separated</td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Age</td>
<td valign="top" class="normaltxt1"><input type=text name="STAGE" value="18" maxlength="2" class="addtextfiled" size="3" id="STAGE"> to <input type=text name="ENDAGE" id="ENDAGE" value="30" maxlength="2" class="addtextfiled" size="3"></td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Height</td>
<td valign="top" class="normaltxt1">
<select style="width:115px;font-family: veredana,arial;font-size : 8pt" class="for_language" NAME="STHEIGHT" id="STHEIGHT" size="1">
		<?php for($i=0;$i<count($HEIGHTVALUE);$i++) {
               ?>
                     <option value="<?php echo  str_replace(" ","_",$HEIGHTVALUE[$i]);?>"><?php echo  $HEIGHTDISPLAYPARTNER[$i];?></option>

			   <?
          

           }
		
		
		
		?>
		</select> to <select style="width:115px;font-family: veredana,arial;font-size : 8pt" class="for_language" NAME="ENDHEIGHT" id="ENDHEIGHT" size="1">
				<?php for($i=0;$i<count($HEIGHTVALUE);$i++) {
               
			   if($i == count($HEIGHTVALUE)-1 ) {
			    $selected = 'selected="selected"';
			   
			   }
			   else {
			   $selected ='';
			   
			   }
			   
			   ?>
                     <option value="<?php echo  $HEIGHTVALUE[$i]?>" <?php echo $selected; ?> ><?php echo  $HEIGHTDISPLAYPARTNER[$i];?></option>

			   <?
          

           }
		
		
		
		?>
		</select></td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Subcaste</td>
<td valign="top" class="normaltxt1"><input type=text name="SUBCASTE" id="SUBCASTE" value="" maxlength="40" class="addtextfiled" size="20"></td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Education</td>
<td valign="top" class="normaltxt1">
<select style="width:250px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt" class="for_language" NAME="EDUCATION[]" id="EDUCATION1" MULTIPLE size="5" >
	<option value="Any" selected>Any</option>

	<?php
	 
 for($i=1;$i<count($arrEducationList);$i++)
 {
?>
<option value="<?php echo str_replace(" ","_",$arrEducationList[$i]); ?>" onclick="chkClickedEducation()"><?php echo $arrEducationList[$i]; ?></option>
<?

    

 }


	?>
	</select></td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Citizenship</td>
<td valign="top" class="normaltxt1">
<SELECT style="width:250px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt" NAME="CITIZENSHIP1" id="CITIZENSHIP1" size="1" >
<option value="Any" selected>Any</option>
<?php
	 
 for($i=1;$i<count($arrResidentStatusList);$i++)
 {
?>
<option value="<?php echo str_replace(" ","_",$arrResidentStatusList[$i]); ?>" ><?php echo $arrResidentStatusList[$i]; ?></option>
<?

    

 }


	?>
	</select>


	<!--<SELECT type="hidden" style="width:250px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt" NAME="RELIGION" id="RELIGION" size="1" >
<option value=""></option>
	</select>-->
</td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr>
<td valign="top" class="normaltxt1" style="padding-top:3px">&nbsp;&nbsp;Country living in&nbsp;&nbsp;</td>
<td valign="top" class="normaltxt1">
<select style="width:250px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt" class="for_language" NAME="COUNTRY[]" id="COUNTRY1" MULTIPLE size="5">
	<option value="Any" selected>Any</option>
	<?php
	 
 for($i=1;$i<count($arrCountryList);$i++)
 {
?>
<option value="<?php echo str_replace(" ","_",$arrCountryList[$i]); ?>" onclick="chkClickedCountry()"><?php echo $arrCountryList[$i]; ?></option>
<?

    

 }


	?>
	</select>
</td>
</tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<tr><td valign="top" class="formsepline" colspan="2"><img src="images/trans.gif" width="1" height="1"></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>
<input type="hidden" name="SEARCH_TYPE" value="DOSEARCH" id="SEARCH_TYPE">
<tr><td valign="top"><img src="images/trans.gif" width="1" height="4"></td><td valign="top" class="normaltxt1">
<input type=checkbox name="PHOTO_OPT" id="PHOTO_OPT" value="Y"> Show with photo</td></tr>

<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

<tr><td valign="top"><img src="images/trans.gif" width="1" height="4"></td>
<td valign="top" class="normaltxt1"> 
<img src="http://imgs.bharatmatrimony.com/bmimages/button-search.gif" border="0" style="cursor:pointer" onClick="searchInitiate()">

<!--<input type="image" src="http://imgs.bharatmatrimony.com/bmimages/button-search.gif" name="submit" value="submit">--></td></tr>
<tr><td valign="top" colspan="2"><img src="images/trans.gif" width="1" height="4"></td></tr>

</form></table>
<!--Search Form-->