<?php
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvars.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once "smartcommoninc.php";
include_once "smartform.php";

$Jsg_exp = $COMMONVARS['IM_SERVER_PREFFIX']."/bmimages/expanded.gif";
$Jsg_coll = $COMMONVARS['IM_SERVER_PREFFIX']."/bmimages/collapsed.gif";

if($COOKIEINFO['LOGININFO']['GENDER']=="F")
  $Gender="M";
else
  $Gender="F";

if($wdmatch=="") 
 $wdmatch="A";

if(trim($stheight_val)=="") { $stheight_val=1;}
if(trim($endheight_val)=="") { $endheight_val=37;}

$rec['StAge']=18;$rec['EndAge']=40;
$rec['StHeight']=0;$rec['EndHeight']=count($SHOWHEIGHT);

if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID'] != "") {	
	dataFromMatchWatch();
}

$PAGEVARS['PAGETITLE']= smartGetPageTitle()." Matrimony - Keyword Search";

include_once("../template/headertop.php");
?>
<style type="text/css">
.iconclass{position: absolute;visibility:visible;-moz-opacity: 0.80; opacity:0.80;filter: alpha(opacity=80);}
</style>
<script>var Jsg_memberid="<?=$COOKIEINFO['LOGININFO']['MEMBERID']?>",Jsg_loggedin_gender="<?=$COOKIEINFO['LOGININFO']['GENDER']?>";</script>
<script type="text/javascript">
function chk_RS() { 
	var sf=document.smartform;
	if(!validateGender(sf,'gendererr')) {
		return false;
	}
	if(!validateAge(sf,'ageerr')) {
		return false;
	}
	if(!validateHeight(sf,'heighterr')) {
		return false;
	}
	if(!validateKeyword(sf,'keyerr','')) {
		return false;
	}
	if(IsEmpty(sf.wdmatch,"radio")) {
		$('wdmatcherr').style.display="block";
		$('wdmatcherr').innerHTML="Please select any one.";
		sf.wdmatch[0].focus();
		return false;
	}
	else{
		$('wdmatcherr').style.display="none";		
		return true;
	}
	return true;
}
</script>

<?php
include_once("../template/header.php");
?>

<script src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/searchcommon.js" language="javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/searchcommonform.js" language="javascript"></script>

<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
	<div>
		<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>

			<div class="middiv-pad">
								<div class="fleft">
								<div class="tabcurbg fleft">
								<div class="fleft">
									<div class="fleft tabclrleft"></div>
									<div class="fleft tabclrrtsw">	
										<div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Keyword Search</font>&nbsp;</div>
									</div>
								</div>
								</div>
								<div class="fleft tr-3"></div>
								</div>

				<div class="middiv1">
				<div class="bl">
					<div class="br">
						<div class="middiv-pad1">
								<div><?=keywordsearchContent();?></div>

								<div style="padding-bottom:5px;"></div>
						
							<!-- Content Area -->

						  <form name="smartform" id="smartform" method="post" action="smartsearch.php" style="margin:0px;">
						  <input type="hidden" name=SEARCH_TYPE value="KEYWORD">
						  <input type="hidden" name=DISPLAY_FORMAT value="one">
						  <input type="hidden" name=ppage value=<?=$rec['StAge'];?>>
						  <?=createBmsHiddenField();?>
							<div style="width:506px;BORDER: #CAD6AE 1px solid;">

							 <div class="fleft" style="background-color:#E0EDC2;BORDER-bottom: #CAD6AE 1px solid;">
								<div class="mediumtxt boldtxt middiv-pad fleft">Basic Search Criteria</div>
								<div class="fright middiv-pad"><font class="smalltxt1">All fields marked with&nbsp;<font class="clr1 mediumtxt boldtxt">*</font>&nbsp;are mandatory.&nbsp;</font></div>
							</div><br clear="all">

								 <?=displayGender("Looking For",$rec,3,4,"document.smartform");?>

								<div style="padding:0px 0px 0px 10px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
									<?=displayAge($rec['StAge'],$rec['EndAge'],5,6);?>					

								<div style="padding:4px 0px 0px 10px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<?=displayHeight($rec['StHeight'],$rec['EndHeight'],7,8) ;?>

								<div style="padding:5px 0px 5px 10px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								 <div style="background-color:#E0EDC2;BORDER: #CAD6AE 1px solid;">
									<div class="mediumtxtbld fleft" style="padding-top:7px;padding-left:14px;">
										<B>Enter Keywords</B>&nbsp;<font class="clr1 mediumtxt boldtxt">*</font>
									</div>
									<div id="keyerr" class="errortxt fleft" style="display:none;padding: 7px 0px 0px 9px; "></div><br clear="all">
									<div style="padding-top:8px;padding-left:14px;">
										<input type="text" name="keytext" id="keytext" size=44 maxlength=50 class="inputtext" onBlur="validateKeyword(this.form,'keyerr','t');" tabindex="9">
									</div>
									<div style="padding-bottom:10px;padding-top:8px;padding-left:14px;" class="mediumtxt">
											<div class="fleft">
											<input type="radio" name="wdmatch" value="A" id="ch_any" tabindex="10" <?=($wdmatch=="A")?"checked":"";?> onClick="$BN('wdmatcherr','n');">
											<font onclick="chkbox_check('ch_any','radio');$BN('wdmatcherr','n')" class="smalltxt">Any word</font>&nbsp;

											<input type="radio" name="wdmatch" value="E" id="ch_all" tabindex="11" <?=($wdmatch=="E")?"checked":"";?> onClick="$BN('wdmatcherr','n');"><font onclick="chkbox_check('ch_all','radio');$BN('wdmatcherr','n')" class="smalltxt">All words</font>&nbsp;
											
											<input type="radio" name="wdmatch" value="EX" id="ch_exact" tabindex="12" <?=($wdmatch=="EX")?"checked":"";?> onClick="$BN('wdmatcherr','n');">
											<font onclick="chkbox_check('ch_exact','radio');$BN('wdmatcherr','n')" class="smalltxt">Exact phrase</font>
											</div>
											<div id="wdmatcherr" class="errortxt fleft" style="display:none;padding: 4px 0px 0px 9px; "></div>
									</div><br clear="all">
									
								</div> 

										<div>
											 <div  class="fleft">

												<div style="padding:5px 0px 5px 10px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

												<div style="padding:0px 0px 0px 10px;" class="mediumtxt boldtxt">Show profiles with</div>
												<div style="padding:5px 0px 5px 10px;"><?=displayShow();?></div>

												<div style="padding:5px 0px 5px 10px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

											</div> 

											<div style="padding:0px 10px 10px 10px;" class="fright">
												<INPUT TYPE="submit" class="button" value="Search" onClick="return chk_RS('one');" tabindex="15">
											</div>
									
								</div><br clear="all"></div>

						</form>
							 
							<!-- Content Area -->									
						</div>
					</div>
				</div>
				</div>
			</div>
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>	
</div></div></div>

<?php
include_once("../template/rightpanel.php");
function displayShow() {
	global $rec;
	($rec['PhotoOpt']=="Y") ? $p_chked = "Checked" : $p_chked=""; 
	($rec['HoroscopeOpt']=="Y") ? $h_chked = "Checked" : $h_chked=""; 

	return '<input type=checkbox class="frmchkbox" name=PHOTO_OPT id=PHOTO_OPT value="Y" '.$p_chked.' tabindex="13"><font class="smalltxt" onclick=\'chkbox_check("PHOTO_OPT");\'>&nbsp;Photo&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=checkbox class="frmchkbox" name=HOROSCOPE_OPT id=HOROSCOPE_OPT value="Y" '.$h_chked.' tabindex="14"><font class="smalltxt" onclick=\'chkbox_check("HOROSCOPE_OPT");\'>&nbsp;Horoscope</font>';
}
echo '<script>document.smartform.keytext.focus();</script>';
include_once("../template/footer.php");
?>