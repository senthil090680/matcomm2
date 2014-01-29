<?php
/****************************************************************************************************
File	: inbreceived.php
Author	: Suresh Babu S.M, Kumaran K.M
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

$domaininfoarr = getDomainInfo();

if(!(isset($_COOKIE['LOGININFO']['MEMBERID']))) {
	echo "hai";exit;
	header ("Location: http://".$domaininfoarr['domainmodule']."/login/login.php");
	exit;
}
$PAGEVARS['PAGETITLE']="Shortlist - ".ucfirst($domaininfoarr['domainnamelong']);
$BREADCRUMB = "<a href='../index.php'>Home</a> >> List";

if($_GET["type"] == 2) {
	$func = "clickTab(4,6,'sectab');cookieChecker('IL');";
}
else if($_GET["type"] == 3) {
	$func = "clickTab(5,6,'sectab');cookieChecker('BL');";
}
else {
	//$_REQUEST['MEMID_RMINTER'] value get from rminterface
		$func = "getshortlist_rm('".$_REQUEST['MEMID_RMINTER']."')";
	
}
 include_once $DOCROOTPATH."/template/headertop.php";	?>
<script language="javascript">
	var Jrmi="<?echo $_REQUEST['MEMID_RMINTER'];?>";
</script>
<?
if($_REQUEST['MEMID_RMINTER']!=""){ ?>
<!-- Header Starting -->
	<div id="rmheader" style="display:none;border:1px solid #000000;">
<?include_once("../template/header.php"); ?>
</div></div></div></div><!-- Header Ending -->
<?}else{include_once("../template/header.php"); }?> 
<link rel="stylesheet" href="http://<?=$domaininfoarr['domainnameimgs']?>/bmstyles/global-style.css">
<link rel="stylesheet" href="http://<?=$domaininfoarr['domainnameimgs']?>/bmstyles/message.css">
<link rel="stylesheet" href="http://<?=$domaininfoarr['domainnameimgs']?>/bmstyles/useractions-sprites.css">
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/div-opacity.js" type="text/javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/hintbox.js" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/ST_common.js" type="text/javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/ajax.js" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/inbreq.js?rn=123" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/bmrequest.js" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/assuredcontact.js" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/rm_bookmarkrequest.js" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/rm_bookmark.js" type="text/javascript"></script>
  <script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/referenceview.js" type="text/javascript"></script>
<script src="http://<?=$domaininfoarr['domainnameimgs']?>/scripts/enlarge.js" type="text/javascript"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/menutabber.js" ></script>

<div id="myphid" class="fleft" style="border:0px solid #FF0000;">
<div class="fleft middiv">
	<!-- Main Area Starts Here -->	
	<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<div class="middiv-pad">
			<div class="fleft">
				<? if($_REQUEST['MEMID_RMINTER']==""){?><div class="tabcurbg fleft">
				
					<!--{ tab button none -->
					<div class="fleft">
						<div class="fleft tableft"></div>
						<div class="fleft tabright">
							<div class="tabpadd"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/inbox/inbviewall.php?rq=N&viewtype=1&ajax=No&inbcat=recd" class="mediumtxt1 boldtxt clr3" onmouseover="showhint('Displays all the messages that you have received and sent to members.',this,event,'225');" onmouseout="hidetip();">Messages</a></div>
						</div>
					</div>
					<div class="fleft">
						<div class="fleft tableft"></div>
						<div class="fleft tabright">
							<div class="tabpadd"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/expressinterest/expshowall.php?page=recnew&view=1&expfolder=recd" class="mediumtxt1 boldtxt clr3" onmouseover="showhint('Displays all the express interests you have received and sent.',this,event,'200');" onmouseout="hidetip();">Interests</a></div>
						</div>
					</div>
					<div class="fleft">
						<div class="fleft tableft"></div>
						<div class="fleft tabright">
							<div class="tabpadd"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/request/reqviewall.php?rq=<?=$rq;?>&request=yes&sall=yes" class="mediumtxt1 boldtxt clr3" onmouseover="showhint('Displays all the requests you have received and sent.' ,this,event,'170');" onmouseout="hidetip();">Requests</a></div>
						</div>
					</div>
					<div class="fleft">
						<div class="fleft tabclrleft"></div>
						<div class="fleft tabclrright">
							<div class="tabpadd"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/memberlist/listviewall.php" class="mediumtxt1 boldtxt clr4" onmouseover="showhint('Displays the members you\'ve shortlisted, ignored and blocked.' ,this,event,'200');" onmouseout="hidetip();">Lists</a></div>
						</div>
					</div>
					<div class="fleft">
						<div class="fleft tableft"></div>
						<div class="fleft tabrightsw">
							<div class="tabpadd"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/assuredcontact/phoneshowall.php?page=recnew&view=1&phonefolder=recd" class="mediumtxt1 boldtxt clr3" onmouseover="showhint('Displays the members who viewed your profile and phone number.' ,this,event,'200');" onmouseout="hidetip();">Views</a></div>
						</div>
					</div>
			
					<!-- tab button none }-->
				</div>	<? } ?>
				<div class="fleft tr-3"></div>
			</div>
			<!-- Content Area -->
			<div class="middiv1">
				<div class="bl">
					<div class="br">
						<div id="middlediv">
							<div style="display:none">
								<img src="http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/trans.gif"   onload="<?=$func?>">
							</div>
							<div  class="smalltxt" id="mailalert" style="padding-left:10px;">
								<div style="float:left; width:521px;">
									<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-tab-border1.gif); width:1px; height:50px;"></div>
									<div style="float:left; width:519px; height:50px; background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-tab-bg.gif) repeat-x;">
										<div id="sectab1" style="float:left;padding-left:0px;"><div id="sectablink1_inactive" style="display:none;"></div><div id="sectablink1_active" style="display:none;"></div></div>
										<div id="sectab2" style="float:left;padding-left:0px;"><div id="sectablink2_inactive" style="display:none;"></div><div id="sectablink2_active" style="display:none;"></div></div>
										<div id="sectab6" style="float:left;padding-left:0px;"><div id="sectablink6_inactive" style="display:none;"></div><div id="sectablink6_active" style="display:none;"></div></div>
										<!-- tab1 - start-->
										<div id="sectab3" style="float:left;padding-left:5px;">
											<div id="sectablink3_inactive" style="float:left; display:none;">	
												<div style="padding:5px 8px 0px 8px;" class="mediumtxt"><a href="javascript:void(0)" onclick="clickTab(3,6,'sectab');cookieChecker('SL');" onmouseover="showhint('Displays list of profiles that you have short-listed.',this,event,'170');" onmouseout="hidetip();">Shortlist</a></div>
											</div>
											<div id="sectablink3_active" style="float:left;padding-left:5px; display:block;">
												<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-bg1.gif); width:5px; height:26px"></div>
												<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-bg2.gif) no-repeat top right;height:26px;">
													<div style="padding:5px 8px 0px 3px;" class="mediumtxt" onmouseover="showhint('Displays list of profiles that you have short-listed.',this,event,'170');" onmouseout="hidetip();">Shortlist</div>
													<div style="margin-top:6px; padding-left:18px;"><img src="http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-down-arrow.gif" width="11" height="7" border="0" alt=""></div>
												</div>						
											</div>
										</div>
										<!-- tab1 - ends-->
								<? if($_REQUEST['MEMID_RMINTER']==""){?>

										<!-- tab2 - start-->
										<div id="sectab4" style="float:left;">
											<div id="sectablink4_inactive" style="float:left; display:block;">	
												<div style="padding:5px 8px 0px 8px;" class="mediumtxt"><a href="javascript:void(0)" onclick="clickTab(4,6,'sectab');cookieChecker('IL');" onmouseover="showhint('Displays list of profiles that you have ignored.',this,event,'170');" onmouseout="hidetip();">Ignore List</a></div>
											</div>
											<div id="sectablink4_active" style="float:left; display:none;">
												<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-bg1.gif); width:5px; height:26px"></div>
												<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-bg2.gif) no-repeat top right;height:26px;">
													<div style="padding:5px 8px 0px 3px;" class="mediumtxt" onmouseover="showhint('Displays list of profiles that you have ignored.',this,event,'170');" onmouseout="hidetip();">Ignore List</div>
													<div style="margin-top:6px; padding-left:25px;"><img src="http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-down-arrow.gif" width="11" height="7" border="0" alt=""></div>
												</div>						
											</div>
										</div>
										<!-- tab2 - ends-->

										<!-- tab3 - start-->
										<div id="sectab5" style="float:left;">
											<div id="sectablink5_inactive" style="float:left; display:block;">				
												<div style="padding:5px 8px 0px 8px;" class="mediumtxt">
												<a href="javascript:void(0)" onclick="clickTab(5,6,'sectab');cookieChecker('BL');" onmouseover="showhint('Displays list of profiles that you have blocked.',this,event,'170');" onmouseout="hidetip();">Block List</a></div>
											</div>
											<div id="sectablink5_active" style="float:left; display:none;">
												<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-bg1.gif); width:5px; height:26px"></div>
												<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-bg2.gif) no-repeat top right;height:26px;">
													<div style="padding:5px 8px 0px 3px;" class="mediumtxt" onmouseover="showhint('Displays list of profiles that you have blocked.',this,event,'170');" onmouseout="hidetip();">Block List</div>
													<div style="margin-top:6px; padding-left:22px;"><img src="http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-mtab-down-arrow.gif" width="11" height="7" border="0" alt=""></div>
												</div>						
											</div>
										</div>	
										<!-- tab3 - ends-->
										<? } ?>
									</div>
									<div style="float:left;background:url(http://<?=$GETDOMAININFO['domainnameimgs']?>/bmimages/inner-tab-border1.gif); width:1px; height:50px;"></div>
								</div><br clear="all">
								<div style="width:521px;" >
								<div class="fleft inntabbr2"></div>
									<div style="width:519px;" class="fleft">
								
										<!-- Stab1 - Start-->
										<div id="sectab_content_3" style="display:block;height:100px">
										</div>
										<!-- Stab1 - End-->

										<!-- Stab2 - Start-->
										<div id="sectab_content_4" style="width:490px;display:none;height:100px">
										</div>
										<!-- Stab2 - End-->

										<!-- Stab3 - Start-->
										<div id="sectab_content_5" style="width:490;display:none;height:100px">
										</div>
										<!-- Stab3 - End-->
										<div id="sectab_content_6" style="width:490;display:none;"></div><div id="sectab_content_1" style="width:490;display:none;"></div><div id="sectab_content_2" style="width:490;display:none;"></div>
									</div>

								<div class="fleft inntabbr2"></div>
							</div>
							</div>
						</div><br clear="all">
					</div>
				</div>
			</div>
			<!-- Content Area -->
		</div><br clear="all">
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>
	<!-- Main Area Starts Here }-->
</div>
<?

if($_REQUEST['MEMID_RMINTER']!=""){?>
<div id="rmheader" style="display:none;border:1px solid #000000;">
<?include_once("../template/rightpanel.php"); ?>
 <?}else{include_once("../template/rightpanel.php"); }?>
</div>
<?
 /*if($_REQUEST['MEMID_RMINTER']!=""){ 
	echo "<div style='display:none;border:1px solid #000000;'><div><div><div><div><div>";
	
	//include_once("../template/footer.php");
	echo "</div>";echo "<script>setwload();</script>";
}else{include_once("../template/footer.php"); }*/
// include_once("../template/footer.php");
 ?><!--<br clear="all">-->
<!-- </div>  -->
</div> <!-- Dont Delete this div -->
<br clear="all">
<div><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" height="10" width="10"></div>
<? 
$clientwidth=800;
if($clientwidth==1024){	
	include_once"footer1024.php";
}else{
	include_once"footer800.php";
} ?>
<!-- </div> -->
</div>
</div>
<script>
setwload();
var url=location.href;
var findstr=url.indexOf('www.');
if(findstr != -1){
if($('spacedivmid') && rp_equaldiv!="2")
{makeequal1('middlediv','rightnavh');}
}
</script>
</center>
</body>
</html>