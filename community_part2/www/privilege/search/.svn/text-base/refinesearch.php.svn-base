<?php
if($_POST['SEARCH_TYPE']=="ADVANCESEARCH" || $_POST['SEARCH_TYPE']=="KEYWORD" || $_POST['SEARCH_TYPE']=="REGULARSEARCH" || $_POST['SEARCH_TYPE']=="QUICK") {
	echo '<div id="useracticons" style="margin-bottom:10px;">';
}
else {
	echo '<div id="useracticons">';
}
?>

<form name="smartform" id="smartform" method="post" onSubmit="return chk_RS();" style="margin:0px;padding:0px;">

<?php
echo $frm['hidden_fields'];

if($_POST['SEARCH_TYPE']=="ADVANCESEARCH" || $_POST['SEARCH_TYPE']=="KEYWORD" || $_POST['SEARCH_TYPE']=="REGULARSEARCH" || $_POST['SEARCH_TYPE']=="QUICK") {
	if($_POST['SEARCH_TYPE']!="KEYWORD") {
		$checkbox_array = get_advancesearch_checkboxs();
	}
?> 

<div class="upgrade1"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" height="1"></div>
		<div class="upgrade3" id="useracticonsimgs">	
			<div style="width:197px; padding-bottom:5px;">
				<div style="margin:0px; padding: 0px 0px 5px 15px;" class="rigpanel bigtxt">Refine your search</div>
					<div style="padding-left:7px;">
						<div class="eg-bar" style="border:1px solid #CCCCCC;">
							<div style="padding-left:0px;">
								<div class="smalltxt" style="padding-left:5px;padding-top:5px;padding-bottom:5px;width:178px;">Age:&nbsp;&nbsp;<font class="smalltxt">&nbsp;&nbsp;&nbsp;From</font>&nbsp;&nbsp;<input type="text" name="STAGE" maxlength="2" value="<?=$STAGE;?>" class="inputtext" style="width:25px;" onBlur="validateAge(this.form,'ageerr',this.form.GENDER.value);" ><font class="smalltxt">&nbsp;&nbsp;to&nbsp;</font><input type="text" name="ENDAGE" 	maxlength="2" value="<?=$ENDAGE;?>" class="inputtext" style="width:25px;" onBlur="validateAge(this.form,'ageerr',this.form.GENDER.value);"> <font class="smalltxt">years</font></div>								
								<div id="ageerr" class="errortxt" style="padding-left:5px;display:none;"></div>
								<div id="heightsel">
								<div class="smalltxt" style="padding-left:5px;padding-bottom:5px;width:178px;">Height:&nbsp;&nbsp;From&nbsp;<select class="inputtext" NAME="STHEIGHT" size="1" onBlur="validateHeight(this.form,'heighterr')" style="width:100px;"><?=selectArrayHash('SHOWHEIGHT',$STHEIGHT);?></select></div>
								<div class="smalltxt" style="padding-bottom:5px;width:178px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to&nbsp;&nbsp;&nbsp;<select style="width:100px;" class="inputtext" NAME="ENDHEIGHT" onBlur="validateHeight(this.form,'heighterr')" size="1"><?=selectArrayHash('SHOWHEIGHT',$ENDHEIGHT);?></select></div>
								</div>
								<div id="heighterr" class="errortxt fleft" style="display:none;padding-left:5px;"></div>

					<?php if($_POST['SEARCH_TYPE']=="ADVANCESEARCH" || $_POST['SEARCH_TYPE']=="REGULARSEARCH" || $_POST['SEARCH_TYPE']=="QUICK") {?>
					 <?/* //adsearch */?>
					 <div style="padding-left:5px;">
					 <div class="fleft">
							<?/* //Education */?>
							<div class="smalltxt fleft pntr"><font onClick="showslide('div_E','div_O','div_C','E','O','C');"><IMG SRC="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" WIDTH="12" HEIGHT="12" BORDER="0" id="E">&nbsp;Education</font></div>		
							
							<?php
							/*<div id="div_E" style="z-index:100; margin-top:15px; padding: 1 1 1 1;display:none;background-color:#DEEBBA;width:178px;">								
							<div class="fleft" style="text-align:center;padding-top:5px;"><b>&nbsp;Education</b></div>
							<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px' onClick="srchblocking('div_E','E');"></div></div><br clear="all">'.$checkbox_array['E'].'<div class="fright" style="padding:7px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_E','E');"></div></div> 
							*/?>

							<?/* //occupation */?>
							<div class="smalltxt fleft pntr" style="padding-left:20px;"><font onClick="showslide('div_O','div_E','div_C','O','E','C');"><IMG SRC="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" WIDTH="12" HEIGHT="12" BORDER="0" id="O">&nbsp;Occupation</font></div>

							<div id="div_E" class="fleft" style="padding: 1 1 1 1; display:none; background-color:#DEEBBA; width:168px !important; width:173px;">	
								<div style="padding:5px;">
									<div class="fleft boldtxt" style="padding-top:4px;">&nbsp;Education</div>
									<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px;' onClick="srchblocking('div_E','E');"></div></div><br clear="all"><?=$checkbox_array['E']?>
									<div class="fright" style="padding:5px 0px 5px 0px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_E','E');"></div>
								</div>
							</div>

							<div id="div_O" class="fleft" style="padding: 1 1 1 1; display:none; background-color:#DEEBBA; width:168px !important; width:173px;">
								<div style="padding:5px;">
									<div class="fleft boldtxt" style="padding-top:4px;">&nbsp;Occupation</div>
									<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px;' onClick="srchblocking('div_O','O');"></div></div><br clear="all">
									<div style="overflow:auto;height:200px;">
									<?=$checkbox_array['O'];?>
									</div>
									<div class="fright" style="padding:5px 0px 5px 0px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_O','O');"></div>
								</div>
							</div>

						</div><br clear="all">

							<?/* //country */?>
								<div class="smalltxt pntr" style="width:178px;padding-top:5px;"><font onClick="showslide('div_C','div_E','div_O','C','E','O');"><IMG SRC="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" WIDTH="12" HEIGHT="12" BORDER="0" id="C">&nbsp;Country living in</font></div>
								
								<div id="div_C" class="fleft" style="padding: 1 1 1 1; display:none; background-color:#DEEBBA; width:168px !important; width:173px;">
									<div style="padding:5px;">														
										<div class="fleft boldtxt" style="padding-top:4px;">&nbsp;Country</div>		
										<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px;' onClick="srchblocking('div_C','C');"></div></div><br clear="all">
										<div style="overflow:auto;height:200px;">
										<?=$checkbox_array['C'];?>
										</div><div class="fright" style="padding:5px 0px 5px 0px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_C','C');"></div>
									</div>
								</div>
				  </div>
				  <?/* //adsearch */?>
				 <?php } 
				 else if($_POST['SEARCH_TYPE']=="KEYWORD") { ?>

<div id="chkboxes_cont" style="display:none;">
<div>
				<div id="sp_E" style="float:left;padding-left:5px;padding-top:5px;width:90px;">
					<font class="smalltxt fleft pntr" onClick="showslideforkey('div_E','div_O','div_C','div_Ca','E','O','C','Ca');"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" id="E" >&nbsp;Education</font>			
				</div>

				<?/* Occupation */?>
				<div id="sp_O" style="float:left;padding-left:5px;padding-top:5px;">
					<font class="smalltxt fleft pntr" onClick="showslideforkey('div_O','div_E','div_C','div_Ca','O','E','C','Ca');"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" id="O">&nbsp;Occupation</font>
				</div>

				<div id="div_E" class="fleft" style="padding:5; display:none; background-color:#DEEBBA; width:170px !important; width:178px;">			
					<div class="fleft" style="text-align:center;padding-top:5px;"><b>&nbsp;Education</b></div>
					<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px' onClick="srchblocking('div_E','E');"></div></div><br clear="all">
					<div style="overflow:auto;height:200px;" id='EDUCATION_cb_div'></div>		
					<div class="fright" style="padding:10px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_E','E');"></div>
				</div>

				<div id="div_O" class="fleft" style="padding:5; display:none; background-color:#DEEBBA; width:170px !important; width:178px;">
					<div class="fleft" style="text-align:center;padding-top:5px;">&nbsp;<b>Occupation</b></div>
					<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px' onClick="srchblocking('div_O','O');"></div></div><br clear="all">
					<div style="overflow:auto;height:200px;" id='OCCUPATION_cb_div'></div>		
					<div class="fright" style="padding:10px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_O','O');"></div>
				</div>				

				<?/* Occupation */?>
		</div>


			<?/* Country */?>
			<div id="sp_C" style="float:left;padding-left:5px;padding-top:5px;padding-bottom:5px;">
				<font class="smalltxt fleft pntr" onClick="showslideforkey('div_C','div_E','div_O','div_Ca','C','E','O','Ca');"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" id="C">&nbsp;Country living in</font>
			</div>
			<?/* Country */?>

			<?/* caste */?>
			<div id="sp_Ca" style="float:left;padding-left:5px;padding-top:5px;padding-bottom:5px;">
				<font class="smalltxt fleft pntr" onClick="showslideforkey('div_Ca','div_E','div_O','div_C','Ca','E','O','C');"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif" id="Ca">&nbsp;Caste</font>				
			</div> 

			<div id="div_C" class="fleft" style="padding:5; margin-bottom:10px; display:none; background-color:#DEEBBA; width:170px !important; width:178px;">
				<div class="fleft" style="text-align:center;padding-top:5px;">&nbsp;<b>Country</b></div>
				<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px' onClick="srchblocking('div_C','C');"></div></div><br clear="all">
				<div style="overflow:auto;height:200px;" id='COUNTRY_cb_div'></div>
				<div class="fright" style="padding:10px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_C','C');"></div>
			</div>

			<div id="div_Ca" class="fleft" style="padding:5; margin-bottom:10px; display:none; background-color:#DEEBBA; width:170px !important; width:178px;">
				<div class="fleft" style="text-align:center;padding-top:5px;">&nbsp;<b>Caste</b></div>
				<div class="fright"><div class='useracticonsimgs closeicon' style='cursor:pointer;height:20px' 	onClick="srchblocking('div_Ca','Ca');"></div></div>
				<br clear="all">
				<div style="overflow:auto;height:200px;" id="CASTE_cb_div"></div>
				<div class="fright" style="padding:10px;"><INPUT TYPE="button" class="button button-border" value="Submit" onClick="srchblocking('div_Ca','Ca');"></div>
			</div>
			<?/* caste */?>

			<br clear="all">
				</div>
		
				<div style="background-color:#E0EDC2; BORDER: #CAD6AE 1px solid;padding-bottom:5px;">
				
				<div>
				<div class="mediumtextbld fleft" style="padding-top:9px; padding-left:7px;">Keyword</div>
				<div style="padding-top:8px;padding-left:14px;" class="fleft"><input type=text name=keytext size=44 style="width:104px;" class="inputtext" value="<?=$keytext;?>" onBlur="validateKeyword(this.form,'keyerr');"></div>
				<div id="keyerr" class="errortxt" style="padding-left:5px;display:none;"></div>
				</div>

				<div style="padding-top:8px;padding-left:4px;"><input type="radio" name="wdmatch1" value="A" class='frmelements' tabindex="7" id="ch_any" <?=($wdmatch=="A")?"checked":"";?>><font onclick="chkbox_check('ch_any','radio');" class="cstyle" class="smalltxt" >Any word</font>&nbsp;			
				<input type="radio" class='frmelements' name="wdmatch1" tabindex="8" value="E" id="ch_all" <?=($wdmatch=="E")?"checked":"";?>><font onclick="chkbox_check('ch_all','radio');" class="smalltxt">All words</font>&nbsp;<br>			
				<input type="radio" class='frmelements' name="wdmatch1" tabindex="9" value="EX" id="ch_exact" <?=($wdmatch=="EX")?"checked":"";?>><font onclick="chkbox_check('ch_exact','radio');" class="cstyle" class="smalltxt">Exact phrase</font>
				</div>
				<div id="wdmatcherr" class="errortxt fleft" style="padding-left:5px;display:none;"></div>
				</div>

				 <?php }?>

				<?/* //horo checkboxes */?>			
				<div class="smalltxt" style="width:178px;padding-top:7px;padding-left:4px;">
				<font class="smalltxt"><input type="checkbox" class="frmchkbox" name="PHOTO_OPT1" value="Y" id="photo_chk_box" <?=($PHOTO_OPT=='Y')?("checked"):("");?> ><label for="photo_chk_box">With Photo</label>&nbsp;&nbsp;<input type="checkbox" class="frmchkbox" name="HOROSCOPE_OPT1" value="Y" id="horo_chk_box" <?=($HOROSCOPE_OPT=='Y')?("checked"):("");?> ><label for="horo_chk_box">With Horoscope</label></font>
				</div>

				<div style="padding:10px;">
				<div class="divbutton fright">
				<INPUT TYPE="SUBMIT" class="button" value="Search">
				</div>
				</div>
				</div>
				<br clear="all">
					</div>
				</div>
				<input type="hidden" name="PHOTO_OPT" value="<?=$PHOTO_OPT?>"><input type="hidden" name="HOROSCOPE_OPT" value="<?=$HOROSCOPE_OPT?>"><input type="hidden" name="EDUCATION1" value="<?=$EDUCATION1?>"><input type="hidden" name="OCCUPATION1" value="<?=$OCCUPATION1?>"><input type="hidden" name="COUNTRY1" value="<?=$COUNTRY1?>"><input type="hidden" name="CASTE1" value="<?=$CASTE1?>"><input type="hidden" name="update_cbs" value=0><input type="hidden" name="tex_tot"><input type="hidden" name="wdmatch" value=<?=$wdmatch;?>>
			</div>
		</div>		
	<div class="upgrade2" ><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" height="1"></div>

<?php
}

echo '</form>';
call_ajax();
echo '</div>';

if($_POST['SEARCH_TYPE']=="ADVANCESEARCH" || $_POST['SEARCH_TYPE']=="KEYWORD" || $_POST['SEARCH_TYPE']=="REGULARSEARCH" || $_POST['SEARCH_TYPE']=="QUICK") {
?>
	<script language=javascript src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/searchcommonform.js"></script>
	<script type="text/javascript">
		var Jsg_coll="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-minus-icon.gif";
		var Jsg_exp="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/hob-plus-icon.gif";
	</script>
	<script language=javascript src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/refinesearch.js"></script>
<?php
}

function get_advancesearch_checkboxs() {
	global $EDUCATION1, $EDUCATIONHASHFORDISPLAY, $OCCUPATION1, $REFINESEARCHOCCUPATIONLIST, $COUNTRY1, $SEARCHCOUNTRYHASH, $REFINESEARCHCOUNTRYARRAY;
	
	if($EDUCATION1=="") { $EDUCATION1=""; }
	$spl_E = split("~",$EDUCATION1);
	if($spl_E[(count($spl_E)-1)]=="") { unset($spl_E[(count($spl_E)-1)]); }
	$EDUCATIONHASHFORDISPLAY= array(0=>"Any")+$EDUCATIONHASHFORDISPLAY;
	if(is_array($EDUCATIONHASHFORDISPLAY)) {
		foreach($EDUCATIONHASHFORDISPLAY as $k=>$v) {
			$checked=""; if(in_array($k,$spl_E)) { $checked="checked"; }
			$E_checkboxs .= '<div><input type=checkbox class="frmchkbox" id="E_'.$k.'" name=EDUCATION_cb value="'.$k.'" '.$checked.'><span onClick="chkbox_check(\'E_'.$k.'\')" valign="middle"><font class="smalltxt">'.$v.'</font></span></div>';
		}
	}

	if($OCCUPATION1=="") { $OCCUPATION1=""; }
	$spl_O = split("~",$OCCUPATION1);
	if($spl_O[(count($spl_O)-1)]=="") { unset($spl_O[(count($spl_O)-1)]); }

	if(is_array($REFINESEARCHOCCUPATIONLIST)) {
		foreach($REFINESEARCHOCCUPATIONLIST as $k=>$v) {
			$checked=""; if(in_array($k,$spl_O)) { $checked="checked"; }
			$O_checkboxs .= '<div><input type=checkbox class="frmchkbox" id="O_'.$k.'" name=OCCUPATION_cb value="'.$k.'" '.$checked.'><span onClick="chkbox_check(\'O_'.$k.'\')"><font class="smalltxt">'.$v.'</font></span></div>';
		}
	}

	if($COUNTRY1=="") { $COUNTRY1=""; }
	$spl_C = split("~",$COUNTRY1); 
	if($spl_C[(count($spl_C)-1)]=="") { unset($spl_C[(count($spl_C)-1)]); }

	if(is_array($SEARCHCOUNTRYHASH)) {
		foreach($SEARCHCOUNTRYHASH as $k=>$v) {
			if(in_array($k,$REFINESEARCHCOUNTRYARRAY)) {
				$checked=""; if(in_array($k,$spl_C)) { $checked="checked"; }	
				if($k==222) {
					$v="USA";
				}
				$C_checkboxs .= '<div><input type=checkbox class="frmchkbox" id="C_'.$k.'" name=COUNTRY_cb value="'.$k.'" '.$checked.'><span onClick="chkbox_check(\'C_'.$k.'\')"><font class="smalltxt">'.$v.'</font></span></div>';			
			}
		}
	}

	if($CASTE1=="") { $CASTE1=""; }
	$spl_Ca = split("~",$CASTE1);
	if($spl_Ca[(count($spl_Ca)-1)]=="") { unset($spl_Ca[(count($spl_Ca)-1)]); }
	if(is_array($CASTEHASH)) {
		foreach($CASTEHASH as $k=>$v) {
			$checked=""; if(in_array($k,$spl_Ca)) { $checked="checked"; }
			$Ca_checkboxs .= '<div><input type=checkbox class="frmchkbox" id="Ca_'.$k.'" name=CASTE_cb value="'.$k.'" '.$checked.'><span onClick="chkbox_check(\'Ca_'.$k.'\')"><font class="smalltxt">'.$v.'</font></span></div>';			
		}
	}	

	$chk["E"] = $E_checkboxs;
	$chk["O"] = $O_checkboxs;
	$chk["C"] = $C_checkboxs;
	$chk["Ca"] = $Ca_checkboxs;
	return $chk;
}
?>