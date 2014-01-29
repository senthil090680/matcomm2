<?php
/****************************************************************************************************
File		: smartadvancesearch.php
Author		: Andal.V
Date		: 20-Dec-2007
*****************************************************************************************************
Description	: This advance search form	 
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
?>



<?if(trim($COOKIEINFO['LOGININFO']['MEMBERID'])!="") {
   if(trim($_REQUEST['RMIID'])=="rmi"){
		include_once("rmsmartsavesearch.php");
   } else {
   	   include_once("smartsavesearch.php");
   }
}
include_once("smartform.php");

$xml_filename = $DOCROOTBASEPATH."/bmconf/bmvarsregularsearchlabel.inc";
require_once "parsexml.php";

include_once("smartsubdomains.php");

$data['langid']= array_search($GETDOMAININFO['domainnameshort'], $GLOBALS['DOMAINNAME']);
$domain_name=smartGetDomainPrefixName();

if((in_array($common_server_name,$bharat_subdomains)) && isset($_COOKIE["yahoo_domain"]) && ($domain_name == "yahoo.bharat")) {
	$rec['Language'] = $_COOKIE["yahoo_domain"];
}
elseif($domain_name!="bharat" && $_GET['sid']== "") {
	$rec['Language']=$data['langid'];
}

$rec['StAge']=18;$rec['EndAge']=40;
$rec['StHeight']=0;$rec['EndHeight']=count($SHOWHEIGHT);

if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID'] != "") {	
	dataFromMatchWatch();	
} 

if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID'] != "") {
	$save_arr = getSaveSearchNames(trim($_REQUEST['RMIID']));
	$save_search_names = $save_arr[0];
	$save_search_count = $save_arr[1];
	$save_search_dropdown = $save_arr[2];
}

if(isset($_GET['sid']) && $COOKIEINFO['LOGININFO']['MEMBERID']!="") {
	$rec = populateSaveSearchContent();
}

if(isset($COOKIEINFO['LOGININFO']['MEMBERID'])) {
	$urdu = $COOKIEINFO['LOGININFO']['MEMBERID']{0};
}

$js_br = getBrowserDetails();

function formatPostValues() {
	global $rec;
	$rec['Language'] = $_POST['LANGUAGE'];
	$rec['Gender'] = $_POST['GENDER'];
	$rec['MaritalStatus'] = $_POST['MARITAL_STATUS'];
	$rec['HaveChildren'] = $_POST['HAVECHILDREN'];
	$rec['StAge'] = $_POST['STAGE'];
	$rec['EndAge'] = $_POST['ENDAGE'];
	$rec['StHeight'] = $_POST['STHEIGHT'];
	$rec['EndHeight'] = $_POST['ENDHEIGHT'];
	$rec['Religion'] = $_POST['RELIGION1'];
	$rec['Caste'] = $_POST['CASTE1'];
	$rec['SubCaste'] = $_POST['SUBCASTE'];
	$rec['Manglik'] = $_POST['MANGLIK'];
	$rec['EatingHabits'] = $_POST['EATINGHABITS'];
	$rec['MotherTongue'] = $_POST['MOTHERTONGUE1'];
	$rec['PhysicalStatus'] = $_POST['PHYSICAL_STATUS'];
	$rec['Education'] = $_POST['EDUCATION1'];
	$rec['OccupationCategory'] = $_POST['OCCCAT'];
	$rec['OccupationSelected'] = 	$_POST['OCCUPATION1'];
	$rec['Citizenship'] = $_POST['CITIZENSHIP1'];
	$rec['Country'] = $_POST['COUNTRY1'];
	$rec['ResidingIndia'] = $_POST['RESIDINGINDIA1'];
	$rec['ResidingDistrict'] = $_POST[''];
	$rec['ResidingUSA'] = $_POST['RESIDINGUSA1'];
	$rec['ResidentStatus'] = $_POST['RESIDENTSTATUS1'];
	$rec['Keywords'] = $_POST['KEYWORDS'];
	$rec['Days'] = $_POST['DAYS'];
	$rec['PostedAfter'] = $_POST[''];
	$rec['DateOpt'] = $_POST['DATE_OPT'];
	$rec['PhotoOpt'] = $_POST['PHOTO_OPT'];
	$rec['HoroscopeOpt'] = $_POST['HOROSCOPE_OPT'];
	$rec['IgnoreOpt'] = $_POST['IGNORE_OPT'];
	$rec['ContactOpt'] = $_POST['CONTACT_OPT'];
	$rec['DisplayFormat'] = $_POST['DISPLAY_FORMAT'];
	$res_state_arr=split("~",$_POST['RESIDINGSTATE1']);

	$result_india='';
	$result_usa='';
	foreach($res_state_arr as $val)
	{
		$india_val=substr($val,0,2);
		$usa_val=substr($val,0,3);
		if($india_val=98)
		{
		$result_ind_val=substr($val,2,strlen($val));
		$result_india.=$result_ind_val."~";
		}
		if($usa_val==222)
		{
		$result_usa_val=substr($val,3,strlen($val));	
		$result_usa.=$result_usa_val."~";
		}

	}
	$rec['ResidingIndia']=removeLastChar($result_india);
	$rec['ResidingUSA']=removeLastChar($result_usa);
	$res_city_arr=split("~",$_POST['RESIDINGCITY1']);
	$city_india='';
	foreach($res_city_arr as $val)
	{
		$india_val=substr($val,0,2);
		if($india_val=98)
		{
		$ind_city_val=substr($val,2,strlen($val));
		$city_india.=$ind_city_val."~";
		}
	}
	$rec['ResidingDistrict']=removeLastChar($city_india);
	$rec['Star']=$_POST['STAR'];
	$rec['Drinking']=$_POST['DRINKING'];
	$rec['Smoking']=$_POST['SMOKING'];
}

function genSaveSearchJsArray() {
	global $rec, $RESIDINGINDIANAMES, $RESIDINGUSANAMES, $CITY,$COUNTRYHASH;
		echo "var selected_country=new Array();";
		echo "var selected_ind_states=new Array();";	
		echo "var selected_usa_states=new Array();";	
		echo "var selected_ind_dist=new Array();";	
		if(isset($rec['Country']))
		{
			$Country=explode("~",$rec['Country']);
			if($Country)
			{		
			$cnt_val="selected_country=[";
						
				foreach($Country as $Country_val)
				{		
				$cnt_val.="'".$Country_val."',";						
				}
			echo removeLastChar($cnt_val)."];";
					
			$st_ind_val="selected_ind_states=[";
			$st_usa_val="selected_usa_states=[";	
			if($rec['ResidingIndia'])
				{
					$st_ind=explode("~",$rec['ResidingIndia']);
				
						foreach($st_ind as $val)
						{					
						$st_ind_val.="'98".$val."',";
						}
	
					
					$district_ind_val="selected_ind_dist=[";	
					if($rec['ResidingDistrict'])
					{							
					$dist_ind=explode("~",$rec['ResidingDistrict']);
						foreach($dist_ind as $val)
						{						
							$district_ind_val.="'98".$val."',";
						}
					
					}
					echo removeLastChar($district_ind_val)."];";
				}
				if($rec['ResidingUSA'])
				{
					$st_usa=explode("~",$rec['ResidingUSA']);
						foreach($st_usa as $val)
						{						
							$st_usa_val.="'222".$val."',";
						}
				}
			echo removeLastChar($st_ind_val)."];";
			echo removeLastChar($st_usa_val)."];";			
			} 
	}
}

function genCountryBasedStates() {
	global $RESIDINGUSANAMES,$RESIDINGINDIANAMES;

	echo "states=new Array();";
	echo "cities=new Array();";
	$india_states = "states[98]=[";
	foreach($RESIDINGINDIANAMES as $k=>$v) {
		$india_states .= "'".$v."|98".$k."',";
		echo genStateBasedCities("98",$k);
	}
	echo removeLastChar($india_states)."];";

	$usa_states = "states[222]=[";
	foreach($RESIDINGUSANAMES  as $k=>$v) {
		$usa_states .= "'".$v."|222".$k."',";
	}
	echo removeLastChar($usa_states)."];";
}

function genStateBasedCities($countryid,$stateid) {
	global $STATEVSCITY, $CITY;

	$citites = "cities['".$countryid.$stateid."']=[";
	$va=$STATEVSCITY[$stateid];  
	foreach($STATEVSCITY[$stateid] as $v) {
		$city_val = $CITY[$v];
		$citites .= "'".$city_val."|".$countryid.$v."',";
	} 
	echo removeLastChar($citites)."];";
}

function removeLastChar($str='',$replace_char=',') {
	$str = preg_replace("/".$replace_char."$/","",$str); 
	return $str;
}

$tit=($_REQUEST['typ']=="ad") ? "Advanced" : "Regular";
$PAGEVARS['PAGETITLE']= smartGetPageTitle()." Matrimony - ".$tit." Search";
include_once("../../template/headertop.php");
?>

<style type="text/css">
.iconclass{position: absolute;visibility:visible;-moz-opacity: 0.80; opacity:0.80;filter: alpha(opacity=80);}
</style>
<script>
<?php
if(isset($save_search_count)) {
	echo "var Jsg_save_search_count=".$save_search_count.";";
}
?>
</script>

<SCRIPT LANGUAGE="JavaScript" src="http://<?=$GETDOMAININFO['domainmodule'];?>/search/savesearchjs.php"></SCRIPT>

<script>
var js_br = "<?=$js_br?>",Jsg_memberid="<?=$COOKIEINFO['LOGININFO']['MEMBERID']?>",Jsg_loggedin_gender="<?=$COOKIEINFO['LOGININFO']['GENDER']?>";
<?=genCountrybasedStates();?>
<?=genSaveSearchJsarray();?>
</script>
<script language="javascript">wload=1;</script> 
<script language="javascript" src="http://imgs.tamilmatrimony.com/scripts/hintbox.js"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/common.js" language="javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/rmsearchcommon.js" language="javascript"></script>
<script language=javascript src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/rmsearchcommonform.js"></script>


<?php
if(trim($_REQUEST['RMIID'])=="rmi"){ 
echo "<div id='rmheader' style='display:none;border:1px solid #000000;'>";
include_once("../../template/header.php"); 
echo "</div></div></div></div>";
}else{include_once("../../template/header.php"); }	?>

<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
	<form name="MatriForm" method="post">
	<div class="fleft middiv" style="padding: 0px 0px 0px 0px;">
		<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">

				<div class="fleft">
					<div class="tabcurbg fleft">
						<div class="fleft">
							<div class="fleft tabclrleft"></div>
							<div class="fleft tabclrrtsw"><div class="tabpadd"><font class="mediumtxt1 boldtxt clr4"><?=$tit;?> Search</font>&nbsp;</div></div>
						</div>
					</div>					
					<div class="fleft tr-3"></div>
				</div> 

				<div class="middiv1">
				<div class="bl">
				<div class="br">
					<div id="middlediv" style="padding: 10px 0px 0px 13px;">
					   	<div class="content" style="padding:5px 15px 5px 5px;">
						<? /* if(trim($_REQUEST['RMIID'])!="rmi"){ echo search_form_title_content();}else{echo "&nbsp;";} */?>

						<? echo search_form_title_content(); ?>
						</div> 
					
						<!-- Content Area -->	
						<?=hiddenFields()?>							
						<div style="width:517px; border:1px solid #CAD6AE; padding-bottom:5px;">
							 <div class="fleft" style="background-color:#E0EDC2;BORDER-bottom: #CAD6AE 1px solid;">
								<div class="mediumtxt boldtxt middiv-pad fleft">Basic Search Criteria</div>
								<div class="fright middiv-pad"><font class="smalltxt1">All fields marked with&nbsp;<font class="clr1 mediumtxt boldtxt">*</font>&nbsp;are mandatory.&nbsp;</font></div>
							</div><br clear="all">

							<div>						
								<?=displayGender("Looking For",$rec,1,2,"document.MatriForm");?>

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<?=displayAge($rec['StAge'],$rec['EndAge'],3,4);?>	

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
								<?php if(!isset($rec['EndHeight'])) {								
									$rec['EndHeight']=count($SHOWHEIGHT);
								}
								echo displayHeight($rec['StHeight'],$rec['EndHeight'],5,6);
								?>
								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Marital Status&nbsp;<font class="clr1 mediumtxt boldtxt">*</font></div>

								<div style="padding-left:14px;" class="smalltxt"><?=displayMaritalStatus();?></div>
						
								<?php if($_REQUEST['typ']=='ad') {?>		
								<div style="padding:5px 0px 5px 14px;display:none;" id="havechild_id1"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
								<div class="mediumtxt boldtxt" id="havechild_id2" style="padding-top:5px;padding-left:14px;display:none;">Have Children</div>
								<div style="padding-left:14px;display:none;" id="havechild_id3" class="smalltxt"><?=displayHaveChildren();?></div>
								<?php }?>
								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
								<?=addRemoveTwoLiner();?>								

								<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Regional Sites</div>

								<div style="padding: 0px 14px 0px 14px;">
									<div style="float:left;"><?$lang_arr=FillLeftRightSelectBox('LANGUAGE1','LANGUAGE','Language','SEARCHLANGUAGEDOMAIN1'); echo $lang_arr['left'];?></div>
									<?=dispButtons('LANGUAGE1','LANGUAGE');?>
									<div style="float:left;"><?=$lang_arr['right'];?></div><br clear="all">
								</div>
							</div>
						
							<?php if($_REQUEST['typ']=='ad') {?>

							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

							<div class="mediumtxt boldtxt" style="padding-top:5px; padding-left:14px;">Mother tongue</div>
							<div style="padding-left:14px;" class="smalltxt">
								<div style="float:left;"><?$mt_arr=FillLeftRightSelectBox('MOTHERTONGUE','MOTHERTONGUE1','MotherTongue','SEARCHMOTHERTONGUEHASH');?><?=$mt_arr['left'];?></div>
								
								<?=dispButtons('MOTHERTONGUE','MOTHERTONGUE1');?>
								<div style="float:left;"><?=$mt_arr['right'];?></div><br clear="all">
							</div>
										
							<?php }?>										
							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

							<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Religion</div>
							<div style="padding-left:14px;"><?=displayReligion();?></div>
							
							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
							
							<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Caste / Division</div>
							<div style="padding-left:14px;">
								<div style="float:left;"><?$c_arr=FillLeftRightSelectBox('CASTE','CASTE1','Caste','SEARCHCASTEHASH','SEARCHMUSLIMCASTEHASH');?> <?=$c_arr['left'];?></div>
								
								<?=dispButtons('CASTE','CASTE1');?>
								<div style="float:left;"><?=$c_arr['right'];?></div><br clear="all">
							</div>
										
							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

							<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Sub caste</div>
							<div style="padding-left:14px;" class="smalltxt">Try partial name or all possible spellings to get profiles from a particular sub-caste. Eg: Bisa Agarwal<br><input type=text name=SUBCASTE size=34 maxlength=60 value="<?=$rec['SubCaste'];?>" class="inputtext"></div>
										
							<?php if($_REQUEST['typ']!='ad') { ?>
							<div><? echo DispCitizenship();echo DispCountry();echo DispEducation();?></div><br clear="all">

							<?	}?>

							<?php if($_REQUEST['typ']=='ad') {?>
							<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
							<div class="mediumtxt boldtxt" style="padding-top:5px;padding-left:14px;">Physical status</div>
							<div style="padding-left:14px;" class="smalltxt"><?=displayPhysicalStatus();?></div>
							<?php }?>						
						</div>
						<!-- Content Area - End-->
						
						<?php if($_REQUEST['typ']=='ad') {?>
						<div style="width:517px; padding-top:10px;">
							<div style="padding-bottom:10px;">
								<div class="bigtxt clr3" style="float:left;cursor:hand;" onclick="view_all('viewall');">Add more search criteria</div><div class="smalltxt fright" id="viewall"></div><br clear="all">
							</div>

							<div>								
								<!-location-start-!>								
								<div style="width:517px;">		
									<div style="background-color:#E0EDC2;height:25px;">
										<div style="border-top:1px solid #CAD6AE;border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;padding-top:5px;"><a href="javascript:srchblocking('locblock-off','loc-img','')"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/hob-minus-icon.gif" width="12" id="loc-img" height="12" hspace="5"></a> <a href="javascript:srchblocking('locblock-off','loc-img','')" class="mediumtxt boldtxt">Location</a></div>
									</div>

									<div style="border-top:1px solid #CAD6AE;border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;">
										<div id="locblock-off" style="display:none;width:515px;background-color:#ffffff">
											<div style="width:515px;">
												<div style="width:515px;">
													<?=DispCitizenship();?>
													<?=DispCountry();?>

													<div style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Resident status</font></div>
									
													<div style="padding:0px 0px 0px 14px ;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><?=displayResidentStatus();?></div>

													<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>													
													
													<!-- RESIDING STaTE --->												

													<div style="padding:0px 0px 5px 14px;" id="state_id2"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><font class="mediumtxt boldtxt">State</font>&nbsp;<font class="smalltxt">(India & USA only)</font></div>	
													<div style="padding-left:14px;" class="errortxt fleft" id="stateerr"></div>
													
													<div id="state_id3" style="padding:0px 0px 5px 14px;">
													<div class="fleft" style="padding:0px 0px 5px 0px;">			
														<div style="float:left;" class="smalltxt"><select style="width:200px;" class="inputtext" NAME="RESIDINGSTATE[]" id="RESIDINGSTATE" size="5" multiple ondblclick="country_moveOptions(document.MatriForm.RESIDINGSTATE, document.MatriForm.RESIDINGSTATE1,'RESIDINGSTATE');"></select></div>
														<div style="float:left;text-align:center;">
														<?=dispButtons('RESIDINGSTATE','RESIDINGSTATE1','country_moveOptions','country_moveOptions2');?>

														</div>
														<div style="float:left;"><select style="width:200px;" class="inputtext" NAME="RESIDINGSTATE1[]" id="RESIDINGSTATE1" size="5" multiple ondblclick="country_moveOptions2(document.MatriForm.RESIDINGSTATE1, document.MatriForm.RESIDINGSTATE);"></select></div>
													</div><br clear="all"></div> 													
													<!-- RESIDING STaTE -->

													<!-- RESIDING CITy -->										
													<div style="padding: 0px 0px 5px 14px;" id="city_id1">
													<div style="padding:0px 0px 5px 0px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div></div>

													<div style="padding-left:14px;" id="city_id2"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><font class="mediumtxt boldtxt">City</font></div>
																			
													<div id="city_id3">
													<div style="width:515px;float:left;padding-left:14px; padding-bottom:5px;">
														<div style="float:left;" class="smalltxt"><select style="width:200px;" class="inputtext" NAME="RESIDINGCITY[]" id="RESIDINGCITY" size="5" multiple ondblclick="moveOptions(document.MatriForm.RESIDINGCITY, document.MatriForm.RESIDINGCITY1);"></select></div>

														<?=dispButtons('RESIDINGCITY','RESIDINGCITY1');?>

														<div style="float:left;"><select style="width:200px;" class="inputtext" NAME="RESIDINGCITY1[]" id="RESIDINGCITY1" size="5" multiple ondblclick="moveOptions1(document.MatriForm.RESIDINGCITY1, document.MatriForm.RESIDINGCITY);"></select></div>
													</div><br clear="all"></div>									

													<!-- RESIDING CITy -->												
												</div>
											</div>
										</div>
									</div>		
								</div>								
								<!-location-end-!>

								<!-Horoscope-!>
								<div style="width:517px;">
									<div style="background-color:#E0EDC2;height:25px;">
										<div style="border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;padding-top:5px;"><a href="javascript:srchblocking('astblock-off','ast-img','')"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/hob-minus-icon.gif" width="12" id="ast-img" height="12" hspace="5"></a> <a href="javascript:srchblocking('astblock-off','ast-img','')" class="mediumtxt boldtxt">Horoscope</a></div>
									</div>

									<div style="border-top:1px solid #CAD6AE;border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;">
										<div id="astblock-off" style="display:none;width:515px;background-color:#ffffff">
											<div style="width:515px;">
												<div style="width:515px;">
													<div style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="0" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Star</font></div>
														
													<div style="padding-left:14px;">
														<div style="float:left"><?$stararr=FillLeftRightSelectBox('STAR','STAR1','Star','SEARCHCOMMONSTARHASH1'); echo $stararr['left'];?></div>

														<?=dispButtons('STAR','STAR1');?>

														<div style="float:left"><?=$stararr['right'];?></div><br clear="all">
													</div>
														
													<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

													<div style="padding-left:14px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Manglik</font></div>
														
													<div style="padding-left:14px; padding-bottom:5px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><?=displayManglik();?></div>						
																			
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-Horoscope-!>
								
								<!-Education-Occupation-!>								
								<div style="width:517px;">		
									<div style="background-color:#E0EDC2;height:25px;">
										<div style="border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;padding-top:5px;"><a href="javascript:srchblocking('edublock-off','edu-img','')"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/hob-minus-icon.gif" width="12" id="edu-img" height="12" hspace="5"></a> <a href="javascript:srchblocking('edublock-off','edu-img','')" class="mediumtxt boldtxt">Education/Occupation</a></div>
									</div>									
									
									<div style="border-top:1px solid #CAD6AE;border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;">
										<div id="edublock-off" style="display:none;width:515px;background-color:#ffffff">
											<div style="width:515px;">
												<div style="width:515px;">
													<?php }?>
													<?php if($_REQUEST['typ']=='ad') {?>
													<?=DispEducation();?>												
													
													<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

													<div style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Occupation category</font></div>
															
													<div style="width:515px;float:left;padding-left:14px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><?=displayOccCat();?></div><br clear="all">

													<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

													<div style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Occupation</font></div>
															
													<div style="float:left; padding-left:14px; padding-bottom:5px;">
														<div style="float:left;"><?php $occ_arr=FillLeftRightSelectBox('OCCUPATION','OCCUPATION1','OccupationSelected','SEARCHOCCUPATIONLIST');?><?php echo $occ_arr['left'];?></div>

														<div style="float:left;text-align:center;">

															<?=dispButtons('OCCUPATION','OCCUPATION1');?>

														</div>
														<div style="float:left;"><?=$occ_arr['right'];?></div>		
													</div><br clear="all">															
												</div>
											</div>
										</div>
									</div>
								</div>  								
								<!-Education-Occupation-!>

								<!-Lifestyle-!>
								<div style="width:517px;">
									<div style="background-color:#E0EDC2;height:25px;">
										<div style="border-left:1px solid #CAD6AE;border-right:1px solid #CAD6AE;padding-top:5px;"><a href="javascript:srchblocking('lifeblock-off','life-img','')"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/hob-minus-icon.gif" width="12" id="life-img" height="12" hspace="5"></a> <a href="javascript:srchblocking('lifeblock-off','life-img','')" class="mediumtxt boldtxt">Lifestyle</a></div>
									</div>

									<div style="border:1px solid #CAD6AE;border-top:0px;">
										<div id="lifeblock-off" style="display:none;width:515px;background-color:#ffffff">
											<div style="width:515px;">
												<div style="width:515px;">
													<div style="width:150px;float:left;padding-left:14px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Eating habits</font></div>
														
													<div style="width:350px;float:left;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><?=displayEatingHabits()?></font></div><br clear="all">

													<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

													<div style="width:150px;float:left;padding-left:14px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Drinking</font></div>
														
													<div style="width:350px;float:left;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><?=displayDrinking();?></div><br clear="all">

													<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

													<div style="width:150px;float:left;padding-left:14px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Smoking</font></div>
														
													<div style="width:350px;float:left;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><?=displaySmoking()?></div><br clear="all">				
												</div>
											</div>
										</div>
									</div>
								</div> 
								<!-Lifestyle-!>												
							</div>
						</div>

						<?php } ?>

						<div>
							<div><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="5"></div>
							<div class="bigtxt clr3" style="padding-top:5px;">Show results based on:</div>
							<div><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="5"></div>
							
							<div style="border: 1px solid #CAD6AE;width:517px;">
								<div><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="5"></div>
								<div class="mediumtxt boldtxt fleft" style="padding-left:14px;">Date posted</div>
								<div class="errortxt fleft" id="dateerr" style="padding-left:14px;"></div>
								<br clear="all">
								<div style="padding-left:10px;"><?=displayWhenPosted();?></div>

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								 <?//RM Interface
									 if($_REQUEST['RMIID']!="rmi") {?>
										<div class="mediumtxt boldtxt" style="padding-left:14px;">Search by</div>
										<div style="padding-left:10px;"	><?=displaySearchBy();?></div>

										<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
									 <?}else{echo "<input type='hidden' name='DATE_OPT' value='C'>";}?>

								
								<div class="mediumtxt boldtxt" style="padding-left:14px;">Show profiles with</div>
								<div style="padding-bottom:7px; padding-left:10px;"><?=displayShow();?></div>
																							
								<?if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {?>
								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<div class="mediumtxt boldtxt" style="padding-left:14px;">Don't show</div>
								<div style="padding-left:10px;"><?=displayDontShow();?></div> 
							
								<?php } ?>

								<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

								<div class="fright" style="padding-right:18px;padding-bottom:5px;">
								<?php if($COOKIEINFO['LOGININFO']['MEMBERID'] != "") { 
								?>
								<a href="javascript:;" onclick="return savesrch_overlay(this, 'srch_savecontent');" class="smalltxt clr1"><span id="savesrch_label"><?php if($save_search_count==3 && $_GET['sid']=="") { echo "Saved search"; } else { echo "Save this search"; }?></span></a><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1">
								<?php } ?>
								<INPUT TYPE="submit" class="button" value="Search" onClick="return validate('<?echo trim($_REQUEST['RMIID']);?>');"></div><br clear="all">
								<input type="hidden" name="search_name" >
								</form>
		
								<?php if($COOKIEINFO['LOGININFO']['MEMBERID'] != "") {  
									if($_REQUEST['RMIID']!="rmi") { //RM Interface?>
											<div style="padding:0px 0px 5px 14px;"><div class="vdotline1" style="width:485px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>

											<div class="smalltxt" style="padding-left:14px; padding-right:18px; text-align:justify;">You have the option of saving the above search criteria to avoid selecting it each time.<br>You can save upto 3 search criteria.</div><br clear="all">

											<!--  <div  id="srch_savecontent" style="position:absolute; display:none;background: url(<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/save-srch-bg.gif) no-repeat;width:269px;height:130px;"> -->

									<?} 
								
									?>
									<div  id="srch_savecontent" style="margin-top:-75px;position:absolute; display:none;">
											<div style="background: url(<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/save-srch-bg1.gif) no-repeat;width:267px;padding-top:13px;">

											<div style="background: url(<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/save-srch-bg2.gif) bottom right;width:267px; height:200px;margin:0px;">

												<form name="ss1" id="ss1" method="post" onSubmit="return savevalidate('<?echo trim($_REQUEST['RMIID']);?>');" style="margin:0px;padding:0px;">

												<div style="width: 235px; margin: 0px; padding:7px 0 0 0px;" class="fleft">
													<div style="padding: 0 10px 0px 15px;">
														<div style="padding-bottom:5px; width: 203px;">
															<div class="errortxt fleft" id="saveeerr"></div>
															<div id="savedsrch_divname">
																<?php if($save_search_count==3 && $_GET['sid']=="") {
																	echo "<div class=\"smalltxt boldtxt\">Saved Search<br>";
																	echo $save_search_dropdown; 
																	echo "</div>";
																} else {?>
																	<div class="smalltxt boldtxt">Save Search<br><input type="text" name="search_name" id="search_name" class="inputtext" value="<?=$rec['SearchName'];?>" size="35" maxlength="10" ><font class="smalltxt1">(Example: My Search)</font><br>
																	<?if(trim($_REQUEST['RMIID'])=="rmi") {?>
																	<textarea  name="savecomments" id="savecomments" cols="20" rows="4" style="width:200px;" class="inputtext "onKeyUp="limitText(this,100);"></textarea>
																	<span id="errsavecomm" class="errortxt fleft"></span>
																	<?}?>
																	</div>
																<?php } ?>
																<div align="right" <?php if($save_search_count==3 && $_GET['sid']=="") { ?> style="padding-top:10px;" <?php } else { ?>style="padding-top:2px;" <?php } ?>>
																<?php if($save_search_count==3 && $_GET['sid']=="") { ?>
																<input class="button" value="Search" type="button" onclick="javascript:savesearchsubmit(document.ss1.search_name.value,'<?echo trim($_REQUEST['RMIID']);?>');">
																<?php } else { ?>
																<input class="button" value="Save & Search" type="submit">
																<?php } ?></div>
															</div>
														</div>
													</div>
												</div>

												<div class="fright">
													<div class="fleft" style="padding: 0px 10px 0px 0px;"><a href="#" onclick="savesrch_overlayclose('srch_savecontent'); return false" class="smalltxt clr1"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/close-icon.gif" alt="" border="0" height="12" width="12"></a></div>
												</div>

												</form><br clear="all" />
											</div>  </div>
										</div>	 <br clear="all" />



									
								<?php } ?>		 
							</div><br clear="all">
						</div>

					</div> 

				</div>
				</div>
				</div>

			</div>		
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
		</div>
	</div>	
</div></div>

<?php
if($COOKIEINFO['LOGININFO']['MEMBERID'] != "" && $save_search_names!="") {
	echo '<div class="fleft">';

	//RM Interface
	//if(trim($_REQUEST['RMIID'])!="rmi"){
		include_once("displaysavesearch.php");
	//}
}

//RM Interface
if(trim($_REQUEST['RMIID'])=="rmi"){
	echo "<div id='rmheader' style='display:none;border:1px solid #000000;'>";
	include_once("../../template/rightpanel.php");
	echo "</div>";
}else{
	include_once("../../template/rightpanel.php");
}

if($COOKIEINFO['LOGININFO']['MEMBERID'] != "" && $save_search_names!="") {
	echo "</div>";
} 

if($rec['OccupationCategory']==4 || $rec['OccupationCategory']==5) {
	?>
	<script language="javascript">
		document.MatriForm.OCCUPATION.readonly=true;
		document.MatriForm.OCCUPATION1.readonly=true;
	</script>
	<?
}

function displayLangLables() {
	global $sid, $save_search_names, $COOKIEINFO,$data;	

	$lang_content = '<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="99%">';
	if($COOKIEINFO['LOGININFO']['MEMBERID']!="" && $save_search_names!="") {
		$lang_content .= '<tr class="textsmallnormal"><td valign="top" "colspan=2" align="right" style="padding-bottom:2px;">'.$save_search_names.'&nbsp;</td></tr>';
	}
	$lang_content .= '</table>';
	return $lang_content;
}

function displayHaveChildren() {
	global $rec;
	if(isset($rec['MaritalStatus']))
	{
		$MARIT = explode("~",$rec['MaritalStatus']);
		if(count($MARIT)==1)
		{
		$disabled='';
		if($MARIT[0]==0)
			$disabled="disabled";
		}
	}

	if(isset($rec['HaveChildren'])) {
		$hc_0_chk = "";
		$hc_1_chk = "";
		$hc_2_chk = "";
		$hc_3_chk = "";
		switch($rec['HaveChildren']) {
			case 0: $hc_0_chk = "Checked"; break;
			case 1: $hc_1_chk = "Checked"; break;
			case 2: $hc_2_chk = "Checked"; break;
			case 3: $hc_3_chk = "Checked"; break;
			default: $hc_0_chk = "Checked";
		}
		$t = "<input type=radio class='frmelements' name='HAVECHILDREN' id='HAVECHILDREN0' value='0' ".$disabled." ".$hc_0_chk."><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN0','radio');\">Doesn't matter&nbsp;</font><input type=radio class='frmelements' name='HAVECHILDREN'  id='HAVECHILDREN1'  value='1' ".$disabled." ".$hc_1_chk."><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN1','radio');\">No&nbsp;</font><input type=radio class='frmelements' name='HAVECHILDREN'  id='HAVECHILDREN2' value='2' ".$disabled." ".$hc_2_chk."><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN2','radio');\"> Yes, living together &nbsp;</font><input type=radio class='frmelements' name='HAVECHILDREN' id='HAVECHILDREN3' value='3' ".$disabled." ".$hc_3_chk."><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN3','radio');\"> Yes, not living together</font>";
	}
	else {
		$t = "<input type=radio class='frmelements' name='HAVECHILDREN' id='HAVECHILDREN0' value='0' checked disabled><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN0','radio');\">Doesn't matter&nbsp;</font><input type=radio class='frmelements' name='HAVECHILDREN'  id='HAVECHILDREN1'  value='1' disabled><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN1','radio');\">No&nbsp;</font><input type=radio class='frmelements' name='HAVECHILDREN'  id='HAVECHILDREN2' value='2' disabled><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN2','radio');\"> Yes, living together &nbsp;</font><input type=radio class='frmelements' name='HAVECHILDREN' id='HAVECHILDREN3' value='3' disabled><font class='smalltxt' onclick=\"chkbox_check('HAVECHILDREN3','radio');\"> Yes, not living together</font>";
	}
	return $t;
}

function displayPhysicalStatus() {
	global $rec, $lpdoesmatter, $lpnormal, $lpdisabled;
	if(isset($rec['PhysicalStatus'])) {
		$ps_0_chk = "";
		$ps_1_chk = "";
		$ps_2_chk = "";
		switch ($rec['PhysicalStatus']) {
			case 0: $ps_0_chk = "checked"; break;
			case 1: $ps_1_chk = "checked"; break;
			case 2: $ps_2_chk = "checked"; break;
		}
		$ps = '<input type=radio class="frmelements" name=PHYSICAL_STATUS id=PHYSICAL_STATUS1 value="2" '.$ps_2_chk.'><font class="smalltxt" onclick=\'chkbox_check("PHYSICAL_STATUS1","radio");\'>Doesn\'t matter &nbsp;&nbsp;&nbsp;</font> <input type=radio class="frmelements" name=PHYSICAL_STATUS id=PHYSICAL_STATUS2 value="0" '.$ps_0_chk.'><font class="smalltxt" onclick=\'chkbox_check("PHYSICAL_STATUS2","radio");\'>'.$lpnormal.' &nbsp;&nbsp;&nbsp;</font> <input type=radio class="frmelements" name=PHYSICAL_STATUS id=PHYSICAL_STATUS3 value="1"  '.$ps_1_chk.'><font class="smalltxt" onclick=\'chkbox_check("PHYSICAL_STATUS3","radio");\'>Physically Challenged&nbsp; </font>';
	}
	else {
		$ps = '<input type=radio class="frmelements" name=PHYSICAL_STATUS id=PHYSICAL_STATUS1 value=2><font class="smalltxt" onclick=\'chkbox_check("PHYSICAL_STATUS1","radio");\'>Doesn\'t matter &nbsp;&nbsp;</font> <input type=radio class="frmelements" name=PHYSICAL_STATUS id=PHYSICAL_STATUS2 value=0 checked><font class="smalltxt" onclick=\'chkbox_check("PHYSICAL_STATUS2","radio");\'>'.$lpnormal.' &nbsp;&nbsp;</font> <input type=radio class="frmelements" name=PHYSICAL_STATUS id=PHYSICAL_STATUS3 value=1><font class="smalltxt" onclick=\'chkbox_check("PHYSICAL_STATUS3","radio");\'>Physically Challenged</font>';
	}
	return $ps;
}

function displayOccCat() {
	global $rec;	
	$occ = '<select class="inputtext" style="width:200px;" NAME="OCCCAT" id="OCCCAT" onchange=catchange_ajax(this.value,"'.$GETDOMAININFO['domainnameshort'].'")>';
	$occ .= selectArrayHash('SEARCHOCCUPATIONCATEGORY',$rec['OccupationCategory']).'</select>';
	return $occ;
}

function displayResidentStatus() {
	global $rec;
	$res = '<SELECT class="inputtext" style="width:200px;" NAME="RESIDENTSTATUS1">';
	if(isset($rec['ResidentStatus'])) {
		$residentstatus=explode("~",$rec['ResidentStatus']);
	}
	else {
		$residentstatus="";
	}
	$res .= selectMultipleLeftControl('SEARCHRESIDENTSTATUSHASH',$residentstatus).'</select>';
	return $res;
}

function displayManglik() {
	global $rec, $urdu;
	$man="";
	if($urdu=='U') {
		$man = "<input type=hidden name=MANGLIK id=MANGLIK0 value='0'>";
	}
	else {
		$man_0_chk = "";
		$man_1_chk = "";
		$man_2_chk = "";
		switch ($rec['Manglik']) {
			case 0:
			$man_0_chk = "Checked";
			break;
			case 1:
			$man_1_chk = "Checked";
			break;
			case 2:
			$man_2_chk = "Checked";
			break;
		}
	}
	$man .= '<input type=radio class="frmelements" name=MANGLIK id=MANGLIK1 value="0" checked ><font class="smalltxt" onclick="chkbox_check(\'MANGLIK1\',\'radio\');">Doesn\'t matter</font>&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=MANGLIK id=MANGLIK2 value="2" '.$man_2_chk.'><font class="smalltxt" onclick="chkbox_check(\'MANGLIK2\',\'radio\');">No</font>&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=MANGLIK id=MANGLIK3 value="1" '.$man_1_chk.'><font class="smalltxt" onclick="chkbox_check(\'MANGLIK3\',\'radio\');">Yes</font>&nbsp;</font>&nbsp;';
	return $man;
}

function displayEatingHabits() {
	global $rec, $lenonveg, $leveg,$leatinghabits;
	$eh_0_chk = "";
	$eh_1_chk = "";
	$eh_2_chk = "";
	if(isset($rec['EatingHabits'])) {
		switch ($rec['EatingHabits']) {
			case 0:
				$eh_0_chk = "Checked";
				break;
			case 1:
				$eh_1_chk = "Checked";
				break;
			case 2:
				$eh_2_chk = "Checked";
				break;
			}
	}
	$eh = '<input type=radio class="frmelements" name=EATINGHABITS id=EATINGHABITS0 value="0" checked ><font class="smalltxt"  onclick="chkbox_check(\'EATINGHABITS0\',\'radio\');">Doesn\'t matter</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=EATINGHABITS id=EATINGHABITS1 value="1" '.$eh_1_chk.'><font class="smalltxt" onclick="chkbox_check(\'EATINGHABITS1\',\'radio\');">'.$leveg.'</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=EATINGHABITS id=EATINGHABITS2 value="2" '.$eh_2_chk.'><font class="smalltxt" onclick="chkbox_check(\'EATINGHABITS2\',\'radio\');">'.$lenonveg.'</font>&nbsp;</font>';	
	return $eh;
}

function displayDrinking() {
	global $rec, $leatinghabits;
	$dr_0_chk = "";
	$dr_1_chk = "";
	$dr_2_chk = "";
	$dr_3_chk = "";
	if(isset($rec['Drinking'])) {
		switch ($rec['Drinking']) {
			case 0:
				$dr_0_chk = "Checked";
				break;
			case 1:
				$dr_1_chk = "Checked";
				break;
			case 2:
				$dr_2_chk = "Checked";
				break;
			case 3:
				$dr_3_chk = "Checked";
				break;			
		}
	}
	$dr = '<input type=radio class="frmelements" name=DRINKING id=DRINKING0 value="0"  checked ><font class="smalltxt" onclick="chkbox_check(\'DRINKING0\',\'radio\');">Doesn\'t matter</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=DRINKING id=DRINKING1 value="1" '.$dr_1_chk.'  ><font class="smalltxt" onclick="chkbox_check(\'DRINKING1\',\'radio\');">No</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=DRINKING id=DRINKING2 value="2" '.$dr_2_chk.'><font class="smalltxt" onclick="chkbox_check(\'DRINKING2\',\'radio\');">Social Drinker</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=DRINKING id=DRINKING3 value="3" '.$dr_3_chk.'><font class="smalltxt" onclick="chkbox_check(\'DRINKING3\',\'radio\');">Regular Drinker</font>&nbsp;';
	return $dr;
}

function displaySmoking() {
	global $rec;
	$sm_0_chk = "";
	$sm_1_chk = "";
	$sm_2_chk = "";
	$sm_3_chk = "";
	if(isset($rec['Smoking'])) {
		switch($rec['Smoking']) {
			case 0:
				$sm_0_chk = "Checked";
				break;
			case 1:
				$sm_1_chk = "Checked";
				break;
			case 2:
				$sm_2_chk = "Checked";
				break;
			case 3:
				$sm_3_chk = "Checked";
				break;
			
		}
	}
	$sm = '<input type=radio class="frmelements" name=SMOKING id=SMOKING0 value="0"  checked ><font class="smalltxt" onclick="chkbox_check(\'SMOKING0\',\'radio\');">Doesn\'t matter</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=SMOKING id=SMOKING1 value="1" '.$sm_1_chk.'><font class="smalltxt" onclick="chkbox_check(\'SMOKING1\',\'radio\');">No</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=SMOKING id=SMOKING2 value="2" '.$sm_2_chk.'><font class="smalltxt" onclick="chkbox_check(\'SMOKING2\',\'radio\');">Social Smoker</font>&nbsp;&nbsp;&nbsp;<input type=radio class="frmelements" name=SMOKING id=SMOKING3 value="3" '.$sm_3_chk.'><font class="smalltxt" onclick="chkbox_check(\'SMOKING3\',\'radio\');">Regular Smoker</font>&nbsp;';
	return $sm;
}

function displayWhenPosted() {
	global $rec;
	if(isset($rec['PostedAfter'])) {
		$date = explode("-",$rec['PostedAfter']);
	}
	if(isset($rec['Days']) && $rec['Days']=='P') {
		$wh = "<input type=radio class='frmelements' name=DAYS id=days1 value='A'><font class='smalltxt' onclick=\"chkbox_check('days1','radio');\">All</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DAYS id=days2 value='P' checked><font class='smalltxt' onclick=\"chkbox_check('days2','radio');\">Posted after</font>&nbsp;";
	}
	else {
		$wh = "<input type=radio class='frmelements' name=DAYS id=days1 value='A' checked><font class='smalltxt' onclick=\"chkbox_check('days1','radio');\">All</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DAYS id=days2 value='P'><font class='smalltxt' onclick=\"chkbox_check('days2','radio');\">Posted after</font>&nbsp;";
	}

	$wh .= '<select class="inputtext" style="width:75px;font-family:Verdana, arial, Verdana, sans-serif;" NAME="ST_MONTH" size="1" onchange="chkbox_check(\'days2\',\'radio\');" id="savemonth">'.selectArrayHash('SHOWMONTH',$date[1]).'</select>&nbsp;';

	$wh .= '<select class="inputtext" style="width:50px;font-family:Verdana, arial, Verdana, sans-serif" NAME="ST_DAY" size="1" onchange="chkbox_check(\'days2\',\'radio\');" id="saveday">'.selectArrayHash('SHOWDAY',$date[2]).'</select>&nbsp;';

	$wh .= '<select class="inputtext" style="width:65px;font-family:Verdana, arial, Verdana, sans-serif;" NAME="ST_YEAR" size="1" onchange="chkbox_check(\'days2\',\'radio\');" id="saveyear">';

	for($j=0;$j<=2;$j++) {
		$year=date("Y")-$j;
		if($date[0]==$year) {
			$selected="selected";
		}
		else{ 
			$selected=""; 
		}
		$wh .= "<option value=\"$year\" $selected>".$year."</option>";
	}
	$wh .= '</select>';
	return $wh;
}

function displaySearchBy() {
	global $rec;
	if(isset($rec['DateOpt'])) {
		switch($rec['DateOpt']) {
			case "U":
			$sb = "<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT1 value=\"U\" checked><font class='smalltxt' onclick=\"chkbox_check('DATE_OPT1','radio');\">Date updated</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT2 value=\"L\">Last login";
			break;
			case "C":
			$sb = "<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT1 value=\"U\"><font class='smalltxt' onclick=\"chkbox_check('DATE_OPT1','radio');\">Date updated</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT2 value=\"L\">Last login";
			break;
			case "L":
			$sb = "<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT1 value=\"U\"><font class='smalltxt' onclick=\"chkbox_check('DATE_OPT1','radio');\">Date updated</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT2 value=\"L\" checked>Last login";
			break;
			default:
			$sb = "<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT1 value=\"U\" checked><font class='smalltxt' onclick=\"chkbox_check('DATE_OPT1','radio');\">Date updated</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT2 value=\"L\">Last login";
		}
	}
	else {
		$sb = "<input type=radio class='frmelements' name=DATE_OPT value=\"U\" id=DATE_OPT1 checked><font class='smalltxt' onclick=\"chkbox_check('DATE_OPT1','radio');\">Date updated</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class='frmelements' name=DATE_OPT id=DATE_OPT2 value=\"L\"><font class='smalltxt' onclick=\"chkbox_check('DATE_OPT2','radio');\">Last login</font>";
	}
	//$sb .= "<select style=\"width:100px;\" class=\"smalltxt\" NAME=\"DATE_OPT\" size=\"1\" onchange=\"chkbox_check('DATE_OPT2','radio');\"><option value=\"1\">Active within</option><option value=\"2\" >Less than 1 week</option><option value=\"3\" >1 week to 1 month</option><option value=\"4\" >1 to 3 months</option><option value=\"5\" >Over 3 months</option></select>";
	return $sb;
}

function displayShow() {
	global $rec, $lprofileswithphoto, $lprofileswithhoroscope;
	($rec['PhotoOpt']=="Y") ? $p_chked = "Checked" : $p_chked=""; 
	($rec['HoroscopeOpt']=="Y") ? $h_chked = "Checked" : $h_chked=""; 

	return '<input type=checkbox  class="frmchkbox" name=PHOTO_OPT id=PHOTO_OPT value="Y" '.$p_chked.'><font class="smalltxt" onclick=\'chkbox_check("PHOTO_OPT");\'>&nbsp;Photo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=checkbox  class="frmchkbox" name=HOROSCOPE_OPT id=HOROSCOPE_OPT value="Y" '.$h_chked.'><font class="smalltxt" onclick=\'chkbox_check("HOROSCOPE_OPT");\'>&nbsp;Horoscope</font>';
}

function displayDontShow() {
	global $rec, $lprofilesalreadycontacted, $lignoredprofiles;
	($rec['IgnoreOpt']=="Y") ? $i_chked = "Checked" : $i_chked="";
	($rec['ContactOpt']=="Y") ? $c_chked = "Checked" : $c_chked="";

	return '<input type=checkbox  class="frmchkbox" name=IGNORE_OPT id=IGNORE_OPT value="Y" '.$i_chked.'><font class="smalltxt" onclick=\'chkbox_check("IGNORE_OPT");\'>&nbsp;'.$lignoredprofiles.'&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox  class="frmchkbox" id=CONTACT_OPT name=CONTACT_OPT value="Y" '.$c_chked.'><font class="smalltxt" onclick=\'chkbox_check("CONTACT_OPT");\'>&nbsp;'.$lprofilesalreadycontacted.'</font>';
}

function displayDisplayFormat() {
	global $rec, $js_br, $lthumbnail, $lbasicview;
	$sb = '<select style="width:100px;" class="inputtext" NAME="DISPLAY_FORMAT" size="1"><option value="one" selected>Single View</option><option value="two">Two view</option><option value="four">Four View</option><option  value="six">Six View</option></select>';
	return $sb;
}

function hiddenFields() {
	global $sid,$COOKIEINFO,$rec;
	$bmsHiddenField = createBmsHiddenField();

	if($_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]==$COMMONVARS['SMART_DEBUG_VAL'] && $_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]!="") {
	$hiden = '<input type=hidden name="'.$COMMONVARS['SMART_DEBUG_PARAM'].'" value="'.$COMMONVARS['SMART_DEBUG_VAL'].'">'; 
	}	
	if($_REQUEST['typ']=="ad") {
		$ST="ADVANCESEARCH" ;
		$Save_type="A";
	} else {
		$ST="REGULARSEARCH";
		$Save_type="R";
	}
	
	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID'] != "") {	
		$hiden.='<input type="hidden" name="ppage" value='.$rec['StAge'].'>';	
	}
	return $hiden.'<input type=hidden name="randid" value=""><input type=hidden name=but_save value=""><input type="hidden" name=SEARCH_TYPE value="'.$ST.'"><input type=hidden name=SAVE_TYPE value="'.$Save_type.'"><input type=hidden name=SEARCH_ID value="'.$sid.'"><input type=hidden name="DISPLAY_FORMAT" value="one">'.$bmsHiddenField;
}

function dispButtons($v1,$v2,$fun_left='',$fun_right='') {
	global $COMMONVARS;
	$v1 = "document.MatriForm.".$v1;
	$v2 = "document.MatriForm.".$v2;
	if($fun_left=="")$fun_left="moveOptions";
	if($fun_right=="")$fun_right="moveOptions1";
	?>
	<div style="float:left;text-align:center;">
		<div style="padding:15px 7px 0px 7px;">
			<input type="button" class="button" style="width:71px !important; width:65px;" Value="Add" onclick="<?=$fun_left?>(<?=$v1;?>,<?=$v2;?>);"><br>
			<img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5"><br>
			<input type="button" class="button" style="width:71px !important; width:65px;" Value="Remove" onClick="<?=$fun_right?>(<?=$v2;?>, <?=$v1;?>);"> 
		</div>
	</div>
	<?php 
}

function DispCitizenship(){
	global $COMMONVARS;
		?>
		<div style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Citizenship</font></div>						
		<div style="padding-left:14px;">
			<div style="float:left;"><?$cit_arr=FillLeftRightSelectBox('CITIZENSHIP','CITIZENSHIP1','Citizenship','SEARCHCOUNTRYHASH');echo $cit_arr['left'];?></div>
			<?=dispButtons('CITIZENSHIP','CITIZENSHIP1');?>
			<div style="float:left;"><?=$cit_arr['right'];?></div>		
		</div>						
		<br clear="all">
		<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
	<?php			 
}

function DispEducation() {
	global $COMMONVARS;
	?>
		<div style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Education</font></div>
					
		<div style="padding-left:14px;">
		<div style="float:left"><?$edu_arr=FillLeftRightSelectBox('EDUCATION','EDUCATION1','Education','SEARCHEDUCATIONHASH');echo $edu_arr['left'];?></div>
		<?=dispButtons('EDUCATION','EDUCATION1');?>						
		<div style="float:left"><?=$edu_arr['right'];?></div><br clear="all">
		</div>
	<?php
}

if($_REQUEST['typ']=="ad") {
	echo '<script>pop_country_state();childlivingst();</script>';
}
?>
<br clear="all">
<?
//RM Interface
if(trim($_REQUEST['RMIID'])!="rmi"){
	include_once("../../template/footer.php"); 
}
?>