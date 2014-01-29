<?php
/****************************************************************************************************
File		: smartmembersonline.php
Author		: Bakkiyaraj
Date		: 20-Dec-2007
*****************************************************************************************************
Description	: 
			members online form	 
********************************************************************************************************/

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvars.inc");
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once($DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearch.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc");

include_once($DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearchformarren.inc");

$xml_filename = $DOCROOTBASEPATH."/bmconf/bmvarsregularsearchlabel.inc";
require_once "parsexml.php";

include_once("smartsubdomains.php");
include_once("smartform.php");

$data['langid'] = array_search($GETDOMAININFO['domainnameshort'], $GLOBALS['DOMAINNAME']);
$domain_name=smartGetDomainPrefixName();

if($domain_name!="bharat" && $_GET['sid']== "") {
	$rec['Language']=$data['langid'];
}

if(isset($COOKIEINFO['LOGININFO']['MEMBERID'])) {
	$urdu = $COOKIEINFO['LOGININFO']['MEMBERID']{0};
}
$rec['StAge']=18;$rec['EndAge']=40;
$rec['StHeight']=0;$rec['EndHeight']=count($SHOWHEIGHT);

if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID'] != "") {	
	dataFromMatchWatch();
}
$PAGEVARS['PAGETITLE']= smartGetPageTitle()." Matrimony - Members Online";
include_once("../template/headertop.php");
?>
<style type="text/css">
.iconclass{position: absolute;visibility:visible;-moz-opacity: 0.80; opacity:0.80;filter: alpha(opacity=80);}
</style>
<script>var Jsg_memberid="<?=$COOKIEINFO['LOGININFO']['MEMBERID']?>",Jsg_loggedin_gender="<?=$COOKIEINFO['LOGININFO']['GENDER']?>";</script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/searchcommon.js" language="javascript"></script>
<script language=javascript src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/searchcommonform.js"></script>
<script language="javascript">
function changereligion_ajax(sval,dm) {
	if(sval!="") {		
		http_for_religionandcaste = $getHTTPObject();		
		var url = "ajaxlangversionrelcaste.php?domain="+dm+"&rid="+sval;		

		http_for_religionandcaste.open("GET", url, true);
		http_for_religionandcaste.onreadystatechange = function() {
			if(http_for_religionandcaste.readyState==4) {
				var selectboxes = http_for_religionandcaste.responseText;
				document.MatriForm.CASTE1.length=0;
				$("caste_div").innerHTML="";
				$("caste_div").innerHTML = selectboxes;
			}
		}
		http_for_religionandcaste.send(null);
	}
}
</script>

<?php
include_once("../template/header.php");
?>

<form name="MatriForm" method="post" style="margin:0px;">
<input type="hidden" name=SEARCH_TYPE value="whos_online">
<input type=hidden name="DISPLAY_FORMAT" value="one">
 <input type="hidden" name="ppage" value=<?=$rec['StAge'];?>>
<?=createBmsHiddenField();?>
<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
	
		<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">
						<div class="fleft">
								<div class="tabcurbg fleft">
								<div class="fleft">
									<div class="fleft tabclrleft"></div>
									<div class="fleft tabclrrtsw"><div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Members Online Search</font>&nbsp;</div></div>
								</div>
								</div>

								<div class="fleft tr-3"></div>
							</div>

				<div class="middiv1">
				<div class="bl">
					<div class="br">
						<div style="padding: 10px 0px 0px 13px;">
							
							<div style="padding: 0px 2px 7px 4px;" class="smalltxt"><?=memberSearchContent();?></div>
							<!-- Content Area -->	

							<div style="width:517px;BORDER: #CAD6AE 1px solid;">
							 <div class="fleft" style="background-color:#E0EDC2;BORDER-bottom: #CAD6AE 1px solid;">
								<div class="mediumtxt boldtxt middiv-pad fleft">Basic Search Criteria</div>
								<div class="fright middiv-pad"><font class="smalltxt1">All fields marked with&nbsp;<font class="clr1 mediumtxt boldtxt">*</font>&nbsp;are mandatory.&nbsp;</font></div>
							</div><br clear="all">

								<div>
								<?=displayGender("Looking For",$rec,1,2,"document.MatriForm");?>

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<?=displayAge($rec['StAge'], $rec['EndAge']);?>

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<?php
								echo displayHeight($rec['StHeight'],$rec['EndHeight']);
								?>								

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<div class="mediumtxt boldtxt fleft" style="padding-top:5px;padding-left:14px;"><a name="msf"></a><div class="fleft">Marital Status&nbsp;<font class="clr1 mediumtxt boldtxt">*</font></div></div>
								<div id="maritalerr" class="errortxt fleft" style="display:none;padding-left:9px;padding-top:4px;"></div>
								<br clear="all">
								<div style="padding-left:14px;" class="smalltxt"><?=displayMaritalStatus();?></div>


								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<?=addRemoveTwoLiner();?>
								<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Regional Sites</div>
								<div style="padding: 0px 14px 0px 14px;">
									<div style="float:left;"><?$lang_arr=FillLeftRightSelectBox('LANGUAGE1','LANGUAGE','Language','SEARCHLANGUAGEDOMAIN1'); echo $lang_arr['left'];?></div>
									<?=dispButtons('LANGUAGE1','LANGUAGE');?>
									<div style="float:left;"><?=$lang_arr['right'];?></div><br clear="all">
								</div>	

							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

										<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Religion</div>
										<div style="padding-left:14px;"><?=displayReligion();?>	
										</div>

							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

							<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Caste / Division</div>
							<div style="padding-left:14px;">
								<div style="float:left;"><?$c_arr=FillLeftRightSelectBox('CASTE','CASTE1','Caste','SEARCHCASTEHASH','SEARCHMUSLIMCASTEHASH');?> <?=$c_arr['left'];?></div>								
								<?=dispButtons('CASTE','CASTE1');?>
								<div style="float:left;"><?=$c_arr['right'];?></div><br clear="all">
							</div>

							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

										<div><? echo DispCountry();?></div><br clear="all">

									</div>
								</div>
				
			<div><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="10"></div>

			<div style="width:517px;BORDER: #CAD6AE 1px solid; " >
				<div class="mediumtxt boldtxt" style="padding-top:3px;padding-left:14px;">Show profiles with</div>			
				<div style="float:left;padding-top:2px;padding-left:14px;padding-bottom:3px"><?=displayShow();?></div><br clear="all">	
			 </div>
			 <div class="fright" style="padding:10px;">
					<INPUT TYPE="submit" class="button" value="Search" onClick="return members_frmvalidate()">
				</div><br clear="all"> 
			</div><br clear="all">
			<!-- Content Area -->									
						</div>
					</div>
				</div>
				
			</div>
	<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b></form>
</div></div></div>

<?php
include_once("../template/rightpanel.php");

function displayMaritalStatus_old() {
	global $COOKIEINFO, $rec, $lmaritalstatus1, $label;
	$label = "<font class='mediumtxt'>".$lmaritalstatus1."</font>";
	switch($rec['MaritalStatus']) {
		case 0: $ms_0_chk = "Checked"; break;
		case 1: $ms_1_chk = "Checked"; break;
		case 2: $ms_2_chk = "Checked"; break;
		case 3: $ms_3_chk = "Checked"; break;
		default: $ms_0_chk = "Checked";
	}
	$chk .= "<input type=radio class='frmelements' name=MARITAL_STATUS[] value='1' id=\"MARITAL_STATUS0\" ".$ms_0_chk." onclick=\"$BN('maritalerr','n');\"><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS0','radio');$BN('maritalerr','n');\">Unmarried&nbsp;</font><input type=radio class='frmelements' name=MARITAL_STATUS[]  value='2' id=\"MARITAL_STATUS1\" ".$ms_1_chk." onclick=\"$BN('maritalerr','n');\"><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS1','radio');$BN('maritalerr','n');\"> Widow/Widower&nbsp;</font><input type=radio class='frmelements' name=MARITAL_STATUS[]  value='3' id=\"MARITAL_STATUS2\" ".$ms_2_chk." onclick=\"$BN('maritalerr','n');\"> <font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS2','radio');$BN('maritalerr','n');\">Divorced &nbsp;</font><input type=radio class='frmelements' name=MARITAL_STATUS[]  value='4' id=\"MARITAL_STATUS3\"  ".$ms_3_chk." onclick=\"$BN('maritalerr','n');\"><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS3','radio');$BN('maritalerr','n');\"> Separated</font>";	
	return $chk;
}


function displayShow() {
	global $rec, $lprofileswithphoto, $lprofileswithhoroscope;
	($rec['PhotoOpt']=="Y") ? $p_chked = "Checked" : $p_chked=""; 
	($rec['HoroscopeOpt']=="Y") ? $h_chked = "Checked" : $h_chked=""; 

	return '<input type=checkbox class="frmchkbox" name=PHOTO_OPT id=PHOTO_OPT value="Y" '.$p_chked.'><font class="smalltxt" onclick=\'chkbox_check("PHOTO_OPT");\'>Photo&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=checkbox class="frmchkbox" name=HOROSCOPE_OPT id=HOROSCOPE_OPT value="Y" '.$h_chked.'><font class="smalltxt" onclick=\'chkbox_check("HOROSCOPE_OPT");\'>Horoscope</font>';
}

function displayDisplayFormat() {
	global $rec, $selectbox_fontfamily, $selectbox_fontsize, $lthumbnail, $lbasicview;
	$sb = '<select style="width:100px;" class="inputtext" NAME="DISPLAY_FORMAT" size="1"><option value="one" selected>Single View</option><option value="two">Two view</option><option value="four">Four View</option><option  value="six">Six View</option></select>';
	return $sb;
}

function dispButtons($v1,$v2) {
	global $COMMONVARS;
	$v1 = "document.MatriForm.".$v1;
	$v2 = "document.MatriForm.".$v2;
?>
	<div style="float:left;text-align:center;">
	<div style="padding:15px 7px 0px 7px;">
	<input type="button" class="button" style="width:71px !important; width:65px;" Value="Add" onclick="moveOptions(<?=$v1;?>,<?=$v2;?>);">
	<br><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5"><br><input type="button" class="button" Value="Remove" onClick="moveOptions1(<?=$v2;?>, <?=$v1;?>);"> </div>
	</div>
<?php 
}
?>
<br clear="all">
<?
include_once("../template/footer.php");
?>