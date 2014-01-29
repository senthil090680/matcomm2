<?php
/****************************************************************************************************
File	: mutualmatchhome.php
Author	: Senthilnathan.M
Date	: 27-March-2008
*****************************************************************************************************
Description	:Mutual match for myhome
*****************************************************************************************************/
$DOCROOTPATH	 = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($DOCROOTPATH);

//INCLUDE THE FILES
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";

if($COOKIEINFO['LOGININFO']['MEMBERID'] == ""){
echo '<div class="smalltxt" style="padding-left:8px;">You are either logged off or your session timed out. <a href="http://'.$GETDOMAININFO['domainmodule'].'/login/login.php" class="clr1">Click here</a> to login.</div><br clear="all">';
exit;
}

//INCLUDE THE FILES
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTPATH."/inbox/basictemplate.php";
include_once $DOCROOTPATH."/search/smartquery.php";

$varCurrPg	= 1;
$varMatriId	= $COOKIEINFO['LOGININFO']['MEMBERID'];
$varPaidSt	= $COOKIEINFO['LOGININFO']['ENTRYTYPE'];
$varOppGen	= $COOKIEINFO['LOGININFO']['GENDER']=='M'?'F':'M';
$varDbError	= '';
$varDesc	= "Displayed below are members whose profile matches with your partner preference.";
$objSlave		= new db();
#$objSlave->dbConnById(2,$varMatriId,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
$objSlave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);

if(!$objSlave->error)
{
	//$varTempCount	= $COOKIEINFO['LOGININFO']['PROFILEMATCHCNT'];
	$varOppositeId	= $COOKIEINFO['LOGININFO']['PROFILEMATCHID'];
}
else
{
	$varDbError = $ERRORMSG;
}

if($varDbError == ''){
?>
<!-- Content Area -->
<div style=" width:508px; ">
	<!--{ View Nav -->			
	<div style="float:left; width:508px; height:50px;">
	<div style="float:left; width:1px; height:50px;background:url(http://<?=$GETDOMAININFO['domainnameimgs'];?>/bmimages/inner-tab-border1.gif);"></div>
	<div style="float:left; width:506px; height:50px; background-image:url('http://<?=$GETDOMAININFO['domainnameimgs'];?>/bmimages/inner-tab-bg.gif');">
<!--	<div style="float:right;">
		<div class="fleft innvtablftbg"></div>
			<div class="fleft innvtabrightbg">
			<div class="mediumtxt middiv-pad2">
				<div class="fleft smalltxt boldtxt" style="padding:4px;">View</div>
				<div class="fleft">
				<div id="useracticons">
					<div id="useracticonsimgs" style="float: left; text-align: middle; ">
						<div id="view6n" style="float:left; display:none;"><div class="useracticonsimgs sixviewon"></div></div>
						<div id="view6f" style="float:left; display:block;"><a href="javascript:;" onclick="javascript:match_open_view(6);hidetip();" style="cursor:pointer;"><div class="useracticonsimgs sixview" onmouseout="hidetip();" onmouseover="showhint('Displays up to 6 profiles' ,this,event,'170');"></div></a></div>

						<div id="view4n" style="float:left; display:none"><div class="useracticonsimgs fourviewon"></div></div>
						<div id="view4f" style="float:left; display:block;"><a href="javascript:;" onclick="javascript:match_open_view(4);hidetip();" style="cursor:pointer;"><div class="useracticonsimgs fourview" onmouseout="hidetip();" onmouseover="showhint('Displays up to 4 profiles' ,this,event,'170');"></div></a></div>

						<div id="view2n" style="float:left; display:none;"><div class="useracticonsimgs twoviewon"></div></div>
						<div id="view2f" style="float:left; display:block;"><a href="javascript:;" onclick="javascript:match_open_view(2);hidetip();" style="cursor:pointer;"><div class="useracticonsimgs twoview" onmouseout="hidetip();" onmouseover="showhint('Displays up to 2 profiles' ,this,event,'170');"></div></a></div>

						<div id="viewbn" style="float:left; display:block;"><div class="useracticonsimgs basicviewon" onmouseout="hidetip();" onmouseover="showhint('Displays a single profile' ,this,event,'170');"></div></div>	
						<div id="viewbf" style="float:left; display:none;"><a href="javascript:;" onclick="javascript:match_open_view(1);hidetip();" style="cursor:pointer;"><div class="useracticonsimgs basicview" onmouseout="hidetip();" onmouseover="showhint('Displays a single profile' ,this,event,'170');"></div></a></div>
					</div>
				</div>
				</div>
			</div>
		</div><br clear="all">
	</div>-->
	</div>
	<div class="fleft inntabbr1"></div>
	</div><br clear="all">
	<!-- View Nave }-->
	<!--{ Inner div -->
	<div style=" width:508px;" >
		<div class="fleft inntabbr2"></div>
		<div style="width:506px;float:left;" class="smalltxt">	
			<div style="float:right;padding-top:15px;height:40px;z-index:-1;">
				<?	
				
				if($varOppositeId !=''){ ?>

				
				<div class="fright" id="showall" style="padding-right:5px;">
					<a href="http://<?=$GETDOMAININFO['domainmodule']?>/search/mutualmatchall.php?viewtype=1&a=N&req=Pre"  class="smalltxt clr1 boldtxt" >Show all</A>
				</div>

				 <div id="matchpaging" class="fright" style="padding-right:15px;display:none;"></div>
			<div id="imgdiv"  class="fright" style="padding-right:15px;display:block;" ></div>
				<?	} ?>
			</div>
		</div>
		<div class="fleft inntabbr2"></div>
	</div>
	<?if($varOppositeId !=''){?>
	<div style="width:506px;" class="smalltxt">
	<div style="padding:0px 0px 5px 10px;"><?=$varDesc?></div>
	</div>
	<? } ?>
	<!--{ Basic View Template -->
	<?	if($varOppositeId !='') {
		$i = 0;
		if($varPaidSt != 'F') {
		$varProButton = '<div class="vdotline"><div class="smalltxt phnextpadding fleft"> <a href="javascript:void(0)" 
			onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',550,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/inbox/inbcontact.php?ID='.$varOppositeId.'\',\'\',\'dispcontent\',\'\',\'\')"><div class="pntr">Type your message</div></a></div><div style="padding: 7px;"class="smalltxt fright"><input type="button" onclick="javascript:fade(\'M'.$i.'\', \'fadediv\',\'dispdiv\',550,\'\',\'\', \'http://'.$GETDOMAININFO['domainmodule'].'/inbox/inbcontact.php?ID='.$varOppositeId.'\',\'\',\'dispcontent\',\'\',\'\');" class="button button-border" value="Send Mail"/></div></div>';
		} else {
		$varProButton = '<div class="vdotline"><div class="smalltxt phnextpadding fleft"><a href="javascript:void(0)" 
			onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',534,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/expressinterest/geteioptions.php?t='.$varOppositeId.'\',\'\',\'dispcontent\',\'\',\'\')"><div class="fleft pntr">Select your message</div><div class="exp_downarrow_icon fleft pntr"></div></a></div><div class="smalltxt fright" style="padding: 7px;"><input value="Express Interest" class="button button-border" onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',534,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/expressinterest/geteioptions.php?t='.$varOppositeId.'\',\'\',\'dispcontent\',\'\',\'\')" type="button"></div></div>';
		}

		$varIdInfo	= recDisplayArray($varOppositeId, $objSlave);
		$varArr		= basicView($varOppositeId, 1, $objSlave, 'Y', 'M', '', $varIdInfo);
		$objSlave->dbClose();

		$varDivStyle	 = ($varIdInfo[$varOppositeId]["BookmarkedId"] == "Y") ? 'none' : 'block';
		
		$varShortListDiv = '<a class="clr1" onclick="javascript:try{fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/memberlist/bookmark.php?divname=shortlistM'.$i.'&divname_1=ignoreM'.$i.'&shlink=linkbk_'.$i.'&type=b&bookmarkedid='.$varOppositeId.'&operation=a\',\'\',\'dispcontent\',\'\',\'\');}catch(e){}" href="javascript:void(0)">Shortlist</a>';

		$varTopContent	 = '<div id="M'.$i.'" class="fleft middiv2"><div class="fright"><div class="smalltxt"><div class="fleft"		id="linkbk_'.$i.'" style="display:'.$varDivStyle.'">'.$varShortListDiv.'</div>
		&nbsp;&nbsp;&nbsp;<a class="clr1" target="_blank" href="http://'.$GETDOMAININFO['domainmodule'].'/search/smartsearch.php?t=S&DISPLAY_FORMAT=one&ID='.$varOppositeId.'&SEARCH_TYPE=SIMILAR&GENDER='.$varOppGen.'">Similar Profiles</a></div></div></div><br clear="all">';

		$varBViewCont	= $varTopContent;
		$varBViewCont  .= $varArr[$varOppositeId."_0"];
		$varBViewCont  .= $varProButton;
		$varBViewCont  .= "<br clear=\"all\">";
		echo $varBViewCont;
		
	?>
	<!-- Basic View Template End }-->							
	<? }else { ?>
		<div class="smalltxt" style="padding-left:12px;padding-bottom:10px !important;padding-bottom:1px;"><b>Currently there are no profiles in this folder.</b></div>
	<?}?>
	<!--{ replied inner div --> 	
</div>
 <img src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/bmimages/trans.gif" height="1" onload="javascript:matchhomejs('<?=$varTempCount?>','<?=$varCurrPg?>','mutualmatchmain.php','Pre','1')"> 
<!-- Content Area -->
<?}else{ echo '<div style="padding:20px 0px 0px 0px"><font class="smalltxt">'.$varDbError.'</font></div>';}?>