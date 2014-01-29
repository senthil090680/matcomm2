<?php
/***********************************************************************************************************
 Filename		: smartsearch.php  
 Author			: Andal.V 
 ***********************************************************************************************************
 Description		: search result page
**********************************************************************************************************/

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

include_once "smartcommoninc.php";

include_once "rmsmartsavesearch.php";

if(trim($COOKIEINFO['LOGININFO']['MEMBERID'])!="" && $_REQUEST['but_save']==1) {
	$ERR_MSG = updatesavesearch();
}

if($_REQUEST['GENDER']!="") {
	$form_gender = $_REQUEST['GENDER'];
}
else {
	$form_gender = "F";
}

showCookieName();
insertActivityLog();
deleteOldCookie();

if($_POST['SEARCH_TYPE']=="ADVANCESEARCH" || $_POST['SEARCH_TYPE']=="REGULARSEARCH" || $_POST['SEARCH_TYPE']=="QUICK") {
	$frm['rs_field_array'] = array('STAGE','ENDAGE','STHEIGHT','ENDHEIGHT','EDUCATION1','OCCUPATION1','COUNTRY1','CASTE1','PHOTO_OPT','HOROSCOPE_OPT');
}
else if($_POST['SEARCH_TYPE']=="KEYWORD") {
	$frm['rs_field_array'] = array('STAGE','ENDAGE','STHEIGHT','ENDHEIGHT','PHOTO_OPT','HOROSCOPE_OPT','keytext','wdmatch','EDUCATION1','OCCUPATION1' ,'COUNTRY1','CASTE1');
}
else {
	$frm['rs_field_array'] = array();
}

formValuesValidation();

if($_POST) {
	getFormPostValues();
} 
else {
	getFormGetValues();
}

$PAGEVARS['PAGETITLE'] = smartGetPageTitle()." Matrimony - ".$data['search_type']." Search Results";
$PAGEVARS['KEYWORDS'] = smartGetPageTitle()." Matrimony - Search Results";
$PAGEVARS['PAGEDESC'] = smartGetPageTitle()." Matrimony - Search Results";

include_once("../../template/headertop.php");

echo smartGetCssFiles();
addjsfiles();
?>

<style type="text/css">
.iconclass{position: absolute;visibility:visible;-moz-opacity: 0.80; opacity:0.80;filter: alpha(opacity=80);}
.exp_downarrow_icon{background:url("<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/topnav-arrow-1.gif") no-repeat;width:8px;height:7px;margin:6px;}
.margintop2{margin-top:2px;}
</style>

<script type="text/javascript">
<?php getJsVarBasedOnSubDomain(); getDebugParameter();?>

var Jsg_one_arr=new Array(<?=$data['onearr_1'];?>,<?=$data['onearr_2'];?>,<?=$data['onearr_3'];?>); var Jsg_two_arr=new Array(<?=$data['twoarr_1'];?>,<?=$data['twoarr_2'];?>,<?=$data['twoarr_3'];?>); var Jsg_four_arr=new Array(<?=$data['fourarr_1'];?>,<?=$data['fourarr_2'];?>,<?=$data['fourarr_3'];?>); var Jsg_six_arr=new Array(<?=$data['sixarr_1'];?>,<?=$data['sixarr_2'];?>,<?=$data['sixarr_3'];?>);

var Jsg_field_array=new Array(<?=$frm['field_array_forjs']?>), Jsg_memberid="<?=$COOKIEINFO['LOGININFO']['MEMBERID']?>", Jsg_randid="<?=$_REQUEST['randid']?>", Jsg_search_type="<?=$_REQUEST['SEARCH_TYPE']?>", Jsg_c_name="<?=$data['page_preffix'].$_REQUEST['randid']?>",Jsg_dmname_prefix="<?=$GLOBALS['DOMAINMODULEPREFIX'];?>", Jsg_imgserver="http://img."+Jsg_serv_name, Jsg_me="<?=$COOKIEINFO['LOGININFO']['ENTRYTYPE']?>", Jsg_akka="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>",Jsg_srch_image="<?=$data['bmimage']?>", Jsg_div_preffix="<?=$data['page_preffix']?>",Jsg_form_gender="<?=$form_gender?>",Jsg_en_img="en_img", Jsg_loggedin_gender="<?=$COOKIEINFO['LOGININFO']['GENDER']?>",Jsg_wwwdomain_path="http://www."+Jsg_serv_name+"/",Jsg_imgs="imgs",Jsg_Mem_gen="<?=$_REQUEST['gen'];?>",Jsg_rightbanner="<?=$rightpanel_banner_array[$GETDOMAININFO['domainnameshort']]?>";

var JDoc="", Jsg_curpage="", Jsg_cb="", Jsg_divname_start="", Jsg_divname_end="", Jsg_total_pages="", Jsg_allblocks="", Jsg_tt="", Jsg_old_cpage="", Jsg_where_from="", tr_td=0, Jsg_old_tt="", Jsg_curiew="", Jsg_req_start_rec=0, J_reg_status=0, Jsg_resultperpage="", Jsg_divname_end_org="", Jsg_req=0 ,Jsg_total_records="",J_ico_arr=new Array();

<?//RM Interface?>
var Jrmi="<?=trim($_REQUEST['RMIID']);?>";

function $load_currentpage(display_type,where_from) {
	try {
	if(Jsg_req==0) {
		if(Jsg_tt!="") {
			Jsg_old_tt=Jsg_tt;
		}
		if(display_type=="two") {
			Jsg_tt="two";
		} else if(display_type=="four") {
			Jsg_tt="four";
		} else if(display_type=="six") {
			Jsg_tt="six";
		} else {
			Jsg_tt="one";
		}
		if(Jsg_old_tt=="") {
			Jsg_old_tt=Jsg_tt;
		}
		$("dyn_pages").innerHTML="";
		$loadprofiles(get_cookie_page_number(where_from),where_from);
	}
	} catch(e) { display_client_error(e,"one");	}
}
</script>
<script src="smartsearchjs.php" type="text/javascript" language="javascript"></script>
<?php
if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {?>
<script src="savesearchjs.php" type="text/javascript"></script>
<?php } ?>
<script src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/scripts/savesearch_rss_ajax.js" type="text/javascript"></script>
<a name="top"></a>
<?
/* RM Interface */
if(trim($_REQUEST['RMIID'])=="rmi"){
	echo "<div id='rmheader' style='display:none;border:1px solid #000000;'>";
	include_once("../../template/header.php"); 
	echo "</div></div></div></div></div>";
} else {
	include_once("../../template/header.php"); 
}	
?>
 
<div class="fleft" id="myphid">
<div id="useracticons"><div id="useracticonsimgs">

<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">
					<div class="fleft">
					<div class="tabcurbg fleft">
						<div class="fleft" id="sr1" style="display:block;" >
							<div class="fleft tabclrleft"></div>
							<div class="fleft tabclrright"><div class="tabpadd" onClick="show_test_div('b');"><div class="mediumtxt1 boldtxt clr4">Search results</div></div></div>
						</div>
	
				<!-- RM Interface -->
				<?	if(trim($COOKIEINFO['LOGININFO']['MEMBERID'])!="") { 
						if(trim($_REQUEST['RMIID'])!="rmi"){
					?>
						<div  class="fleft" id="rv1" style="display:block;" onClick="show_top_tabs('rv1');">
							<div class="fleft tableftsw"></div>
							<div class="fleft tabrightsw"><div class="tabpadd" ><a href="javascript:;" class="mediumtxt1 boldtxt clr3">Recently viewed profiles</a></div></div>
						</div> 
				<?}}?>

						<div class="fleft" id="sr2" onClick="show_top_tabs('sr2');" style="display:none;">
							<div class="fleft tableft"></div>
							<div class="fleft tabright"><div class="tabpadd"><a href="javascript:;" class="mediumtxt1 boldtxt clr3">Search results</a></div></div>
						</div>

				<?	if(trim($COOKIEINFO['LOGININFO']['MEMBERID'])!="") { ?>
						<div class="fleft" id="rv2" style="display:none;">
							<div class="fleft tabclrleft"></div>
							<div class="fleft tabclrrtsw"><div class="tabpadd"><a href="javascript:;" class="mediumtxt1 boldtxt clr4">Recently viewed profiles</a></div></div>
						</div>
				<? }
				   if($_POST['SEARCH_TYPE']=="ADVANCESEARCH" || $_POST['SEARCH_TYPE']=="REGULARSEARCH" || $_POST['SEARCH_TYPE']=="QUICK") { if(trim($_REQUEST['RMIID'])!="rmi"){
				   ?>
				   <div class="smalltxt" align="right"><a href="javascript:;" onClick="ajax_save_rss();" >Get your search results as a RSS feed</a>&nbsp;&nbsp;<a href="javascript:;" onClick="ajax_save_rss();" ><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/feed-icon.gif" width="15" height="15" alt="RSS Feeds" border="0" /></a></div>
				 <?php }} ?>
					</div>
				

					<div class="fleft tr-3"></div>
					</div>
				   
					<div class="middiv1">
						<div class="bl"><div class="br"><div class="middiv-pad1" id="middlediv" style="padding-top:0px;">
							
							<?php //Recently View div <!-- ================= -->?>							
							<div id="recent_div" style="display:none;padding-top:0px;">
							<br clear="all">
							</div>
							<?php //<!-- ================= -->?>

							<form name="photofrm" method="post" target="_blank" style="margin:0px;">
							
							<?php //Disp div <!-- ================= -->?>							
							<div id="disp_div" style="display:none;height:400px;"></div>
							<?php //<!-- ================= -->?>

							<?php //Search Result div <!-- ================= -->?>
							
							<div class="vc1" id="search_div" style="display:block;" >

								<div class="fleft vc1">
								<div class="fleft inntabbr1"></div>
								<div class="fleft inntabbg">
								<div class="fleft middiv3"><br clear="all"></div>	
										<div class="fleft" >
											<div class="fleft innvtablftbg"></div>
												<div class="fleft innvtabrightbg">
														<div class="mediumtxt middiv-pad2">
														<div class="fleft smalltxt boldtxt" style="padding:4px;">View</div>
														<div class="fleft">
																<div id="view6n" style="float:left; display:none;"><div class="useracticonsimgs sixviewon"></div></div>
																<div id="view6f" style="float:left; display:none;"  onClick="javascript:$load_currentpage('six','frompaging');"><div class="mediumtxt pntr" onmouseover="showhint('With this view, you can view up to 60 profiles.' ,this,event,'170');" onmouseout="hidetip();"><div class="useracticonsimgs sixview"></div></div></div>

																<div id="view4n" style="float:left; display:none"><div class="useracticonsimgs fourviewon"></div></div>
																<div id="view4f" style="float:left; display:block;" onClick="javascript:$load_currentpage('four','frompaging');"><div class="mediumtxt pntr" onmouseover="showhint('With this view, you can view up to 40 profiles.' ,this,event,'170');" onmouseout="hidetip();"><div class="useracticonsimgs fourview"></div></div></div>

																<div id="view2n" style="float:left; display:none;"><div class="useracticonsimgs twoviewon"></div></div>
																<div id="view2f" style="float:left; display:none;" onClick="javascript:$load_currentpage('two','frompaging');"><div class="mediumtxt pntr" onmouseover="showhint('With this view, you can view up to 20 profiles.' ,this,event,'170');" onmouseout="hidetip();"> <div class="useracticonsimgs twoview"></div></div></div>

																<div id="viewbn" style="float:left; display:block;"><div class="useracticonsimgs basicviewon"></div></div>													
																<div id="viewbf" style="float:left; display:none;" onClick="javascript:$load_currentpage('one','frompaging');"><div class="mediumtxt pntr" onmouseover="showhint('With this view, you can view up to 10 profiles.' ,this,event,'170');" onmouseout="hidetip();"><div class="useracticonsimgs basicview"></div></div></div>
															</div>
															</div>
												</div><br clear="all">
										</div>

									</div>
									<div class="fleft inntabbr1"></div>
									</div><br clear="all">

									<div class="vc1">
									  <div class="fleft inntabbr2"></div><div class="fleft middiv2">
									  <div class="fleft middiv3 smalltxt"><div style="padding: 0px 0px 0px 15px;" ></div></div>
									  
									  <div style="float:right;width:250px;height:32px;"><div style="padding: 10px 15px 0px 0px;z-index:-1;" id="prevnext" class="fright"></div></div></div><div class='fleft inntabbr2'></div><br clear="all">
									 </div>
									 <div id="dprofile" style="padding: 0px 10px 10px 10px;">

									 <?php
									 if(trim($COOKIEINFO['LOGININFO']['MEMBERID'])!="" && $_REQUEST['but_save']==1) { 
										 echo "<div class='smalltxt'>".$ERR_MSG."</div>";
										 $data['checksaved']=1;
									 }

									 if($ERR_MSG=="") {
										dispMsg();
									 }
									 ?>
									 
									 </div>
									 
									 <?/* <div class="smalltxt1 clr2" style="padding: 0px 10px 10px 10px;">Note: You can navigate to the previous and next page of your search results using your left and right control keys.</div>*/?>
									 <!-- RM Interface -->
									<?if(trim($_REQUEST['RMIID'])!="rmi"){echo getExpressinterestAll();}else{?>
										  <div style="display:none"><?=getExpressinterestAll();?></div>
									<?}?>

									 <div class="borderline"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/trans.gif" height="1" width="504"></div><br clear="all">
									
									<div id="dyn_pages" ></div>
									
									<div id="shbrdr" style="display:none;">
									<div><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/trans.gif" height="5" width="508"></div>
									<div class="borderline"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/trans.gif" height="1" width="504"></div><br clear="all"></div>

									 <!-- RM Interface -->
									 <?if(trim($_REQUEST['RMIID'])!="rmi"){echo getExpressinterestAll(1);}else{?>
										  <div style="display:none"><?=getExpressinterestAll(1);?></div>
									<?}?>
									
									

									<div class="vc1"><div class="fleft middiv2"><div style="float:right;width:250px;padding-bottom: 20px !important;padding-bottom: 0px;">
									<div style="float:right;padding: 5px 0px 0px 0px;" id="prevnext1"></div></div></div>
									 </div>
									</div>

							<?php //<!-- ================= -->?>
							<div id="er_div" style="display:none;"></div>
							<div id="test" style="display:none;"></div>
							</form>
						</div><br clear="all"></div></div>
					</div>

		</div>
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div></div></div>
</div>

<?php
if($COOKIEINFO['LOGININFO']['MEMBERID'] != "") {
	//For Remove the EdIt and Delete - RM Interface  
	$save_arr = getSaveSearchNames(trim($_REQUEST['RMIID']));
  	$save_search_names = $save_arr[0];
	get_savesearch_count($save_arr[1]);
	if($save_search_names!="") {
		echo '<div class="fleft" >';
		include_once("displaysavesearch.php");
	}
}

$smart_page = "smartsearch";

//RM Interface
if(trim($_REQUEST['RMIID'])=="rmi"){
	echo "<div id='rmheader' style='display:none;border:1px solid #000000;'>";
	include_once("../../template/rightpanel.php");
	echo "</div>";
}else{
	include_once("../template/rightpanel.php");
}

if($COOKIEINFO['LOGININFO']['MEMBERID'] != "" && $save_search_names!="") {
	echo "</div>";
} 

echo '<BR clear="all"/>';

//RM Interface
if(trim($_REQUEST['RMIID'])=="rmi"){
	echo "<div style='display:none;border:1px solid #000000;'><div><div><div><div><div>";
	include_once("../../template/footer.php");
	echo "</div>";
}else{
	include_once("../../template/footer.php");
}


function get_savesearch_count($s) {
	echo "<script type='text/javascript'>";
	if(isset($s)) {
		echo "var Jsg_save_search_count=".$s.";";
	}
	echo "</script>";
}

function call_ajax() {
	global $COOKIEINFO, $data, $COMMONVARS;
	if($_COOKIE[$data['page_preffix'].$_REQUEST['randid']]!="") {
		$tp = split("~",$_COOKIE[$data['page_preffix'].$_REQUEST['randid']]);
		$df = $tp[0];
	}
	else if($COOKIEINFO['LOGININFO']['DEFAULTVIEW']!="") {
		$df = $COOKIEINFO['LOGININFO']['DEFAULTVIEW'];
	}
	else {
		$df = $_REQUEST['DISPLAY_FORMAT'];
	}
	echo '<img src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/bmimages/trans.gif" onload="$load_currentpage(\''.$df.'\',\'imgonload\');" width="0" height="0" border="0" style="margin:0px;padding:0px;display:none;"/>';
}

function getExpressinterestAll($v='') {
	global $COOKIEINFO;

	$but ='<div class="middiv2 smalltxt" id="disp_expdiv'.$v.'" style="display:none;padding-bottom:3px;"><div class="fleft" style="padding-top:2px;"><input type="checkbox" name="chk2" id="chk2" onclick="$botchk(\'prevnext'.$v.'\')"></div><div class="fleft" style="padding-top:4px;"><label for="chk2">Select All</label></div><div class="smalltxt" style="float:right; padding:5px 0px 5px 5 px;">';

	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID']!= '' &&  $COOKIEINFO['LOGININFO']['GENDER']!="" &&  $COOKIEINFO['LOGININFO']['GENDER']!=$_REQUEST['GENDER']) { 	
		if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] == 'R') {
			$but.='<input type="button" value="Send Mail All" class="button button-border" title="Will send the same message to multiple profiles at a single click" onclick="$form_contact(\'photofrm\');">';
		} else if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] == 'F'){
			$but.='<input type="button" value="Express Interest All" class="button button-border" onclick="$form_express(\'photofrm\',\'f\');" title="Will send Express Interest to multiple profiles at a single click">';
		}
	}

	$but.='&nbsp;<input type="button" value="Forward" class="button button-border" onclick="$form_forward(\'photofrm\',\'f\');" title="Will forward this profile to the e-mail ID you propose">';
	return $but.'</div><br clear="all"></div>';
}	

function addjsfiles() {
	global $COOKIEINFO,$GETDOMAININFO,$COMMONVARS;
	echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/rmsearchcommon.js" type="text/javascript"></script>';
	echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/smartscjson.js" type="text/javascript"></script>';

	echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/hintbox.js" type="text/javascript"></script>';
	echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/forward.js" type="text/javascript"></script>';
	echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/referenceview.js" type="text/javascript"></script>';

	if($COOKIEINFO['LOGININFO']['MEMBERID']=="") {
		echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/hbox.js" type="text/javascript"></script>';
		echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/fadewin.js" type="text/javascript"></script>';
	}
	else {
		echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/assuredcontact.js" type="text/javascript"></script>';
		echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/rm_bookmarkrequest.js" type="text/javascript"></script>';
		echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/bmrequest.js" type="text/javascript"></script>';
		echo '<script src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/scripts/getoptionsei.js" type="text/javascript"></script>';
	}
}

function dispMsg() {	
	global $COOKIEINFO,$COMMONVARS;
	if($_REQUEST['SEARCH_TYPE']=="whos_online" || $_REQUEST['SEARCH_TYPE']=="members_online") {
		$dm='<div class="smalltxt">Displayed below are the members who match your search criteria among those currently online. Click on the <img src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/bmimages/online.gif" style="vertical-align:middle;" width="53" height="17" border="0"> icon to chat with them.&nbsp;';
		
		if($_REQUEST['SEARCH_TYPE']=="members_online" && $COOKIEINFO['LOGININFO']['MEMBERID']=="") {
			if($_REQUEST['gen']=='M') {
				$ge="F";
				$ged="Female";
			} else {
				$ge="M";
				$ged="Male";
			}
			$dm.='<a href="smartsearch.php?SEARCH_TYPE=members_online&DISPLAY_FORMAT=one&gen='.$ge.'" class="clr1">Click here to view '.$ged.' Profiles.</a>';
		}
		echo $dm.'</div>';
	} else {
		echo '<div class="smalltxt">Here are the results based on your search criteria. If you\'re looking for better results, please refine your search criteria.</div>';
	}
}

function insertActivityLog() {
	global $COOKIEINFO, $DBNAME, $DBINFO, $DOMAINTABLE, $data;

	if($_COOKIE[$data['page_preffix'].$_REQUEST['randid']]=="" && $COOKIEINFO['LOGININFO']['MEMBERID']!="") {
		$darr=getDomainInfo(1,$COOKIEINFO['LOGININFO']['MEMBERID']);

		$db_mas = new db;
		$db_mas->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'M',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYLOG']);		
		$sql = "insert into ".$DBNAME['MATRIMONYLOG'].".". $DOMAINTABLE[strtoupper($darr['domainnameshort'])]['PROFILEACTIVITYLOG']." (Matriid, LastSearch) values ('".$COOKIEINFO['LOGININFO']['MEMBERID']."', Now()) ON DUPLICATE KEY UPDATE MatriId='".$COOKIEINFO['LOGININFO']['MEMBERID']."'";
		$db_mas->insert($sql);
		if($db_mas->error) {
			$data['error_msg']="Not inserted in Activity Log.";
			$data['err_no']=1;
		}
		$db_mas->dbClose();
	}
}
?>