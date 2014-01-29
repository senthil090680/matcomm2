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

//VARIABLE DECLERATIONS
$varMatriId	= $COOKIEINFO['LOGININFO']['MEMBERID'];
$varGender	= $COOKIEINFO['LOGININFO']['GENDER'];
$varPaidSt	= $COOKIEINFO['LOGININFO']['ENTRYTYPE'];
$varOppGen  = $varGender=='F' ? 'M' : 'F'; 
$varDbError	= '';
$varType	= ($_REQUEST['viewtype']=='') ? 1 : $_REQUEST['viewtype'];
$varCurrPg	= ($_REQUEST['loadpage']=='') ? 1 : $_REQUEST['loadpage'];
$varReqPg	= ($_REQUEST['req']=='') ? 'Pre' : $_REQUEST['req'];
$varAjax	= $_REQUEST['a']==''?'Y':$_REQUEST['a'];
$varStartLt	= round(($varCurrPg-1)*$varType*10);
$varTempCount	= 0;
$varTotalPages  = 0;
$varOppositeId	= array();
$varTempTable	= $DBNAME['MATRIMONYMS'].".".$TABLE['PROFILEMATCH'];
$varEndLt		= $varType*10;

//This function for form where condition 
$varNotAvailMsg = "Currently there are no profiles in this folder.";
if($varReqPg == 'Pre')
{
	$varDesc		= "Displayed below are members whose profile matches with your partner preference.";
	$varArrQuery	= genQueryPerferenceMatch('','','');
	$varWhere		= $varArrQuery[1];
	$varWhere		= $varWhere==''?"'":"' AND ".$varWhere;
	//$varTempCount	= $COOKIEINFO['LOGININFO']['PROFILEMATCHCNT'];
	$varQuery		= 'SELECT COUNT(MatriId) AS CNT FROM '.$varTempTable." WHERE MatriId<>'".$varMatriId.$varWhere;
	//print $varQuery;exit;
	$objSlave		= new db();
	#$objSlave->dbConnById(2,$varMatriId,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$objSlave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);

	if(!$objSlave->error){
	//if($varTempCount == ''){
	$objSlave->select($varQuery);
	$varTempResult	= $objSlave->fetchArray();
	$varTempCount	= $varTempResult["CNT"];
	//}
	}
	else
	{
	$varDbError = $ERRORMSG;
	}
	$PAGEVARS['PAGETITLE']="Profiles I'm looking for";
}
elseif($varReqPg == 'Pro')
{
	$varDesc		= "Displayed below are members whose partner preference matches with your profile.";
	$varArrQuery	= genQueryProfileMatch($varStartLt, $varEndLt);
	$objSlave		= new db();
	#$objSlave->dbConnById(2,$varMatriId,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$objSlave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	if($objSlave->error){
	$varDbError = $ERRORMSG;
	}
	 $varTempCount	= $varArrQuery[4];
	$PAGEVARS['PAGETITLE']="Profiles looking for me";
}
elseif($varReqPg == 'Mut')
{
	$varDesc		= "Displayed below are members whose profile and partner preference matches with your profile and partner							   preference";
	$varArrQuery	= genQueryMutualMatch($varStartLt, $varEndLt);
	$objSlave		= new db();
	#$objSlave->dbConnById(2,$varMatriId,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$objSlave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	if($objSlave->error){
	$varDbError = $ERRORMSG;
	}
	 $varTempCount	= $varArrQuery[4];
	$PAGEVARS['PAGETITLE']="Mutual Match";
}


if($varTempCount > 0 && $varDbError==''){
if($varReqPg == 'Pre')
{
	$varQuery		= 'SELECT MatriId FROM '.$varTempTable." WHERE MatriId<>'".$varMatriId.$varWhere.
					  " ORDER BY TimeCreated DESC LIMIT ". $varStartLt.','.$varEndLt; 
	$varTempReCnt	= $objSlave->select($varQuery);
	while($varTempResult	= $objSlave->fetchArray()){
	$varOppositeId[] = $varTempResult["MatriId"];
	}//while
}//if
elseif($varReqPg == 'Pro' || $varReqPg == 'Mut')
{
	$varOppositeId	= $varArrQuery[1];
}
$varTotalPages = ceil($varTempCount/$varEndLt);
}//if
if($varAjax != 'N')
{ 
	echo $varTotalPages."|~|".$varCurrPg."|~|".$varType."|~|"."mutualmatchgetall.php|~|".$varReqPg."|~|".$varTempCount."|~|"; 
}


if($varDbError==''){
?>
<div style="width:508px;">
	<!--{ View Nav -->			
	<div style="float:left; width:508px;height:50px;">
	<div style="float:left; width:1px; height:50px;background:url(http://<?=$GETDOMAININFO['domainnameimgs'];?>/bmimages/inner-tab-border1.gif);"></div>
	<div style="float:left; width:506px; height:50px; background-image:url('http://<?=$GETDOMAININFO['domainnameimgs'];?>/bmimages/inner-tab-bg.gif');">
	<div style="float:right;">
		<div class="fleft innvtablftbg"></div>
			<div class="fleft innvtabrightbg">
			<div class="mediumtxt middiv-pad2">
				<div class="fleft smalltxt boldtxt" style="padding:4px;">View</div>
				<div class="fleft">
				<div id="useracticons">
					<div id="useracticonsimgs" style="float: left; text-align: middle; ">
				
						
						<?
						if($varType==6) {
						?>
						<div id="view6n" style="float:left; display:block;">
						<div class="useracticonsimgs sixviewon" onmouseout="hidetip();" onmouseover="showhint('Displays up to 60 profiles' ,this,event,'170');"></div></div>
						<?
						}
						else {
						?>
						<div id="view6f" style="float:left; display:block;"><a  href="javascript:;" onclick="javascript:match_open_view(6);hidetip();" style="cursor:pointer;" onmouseout="hidetip();"><div class="useracticonsimgs sixview"  onmouseover="showhint('Displays up to 60 profiles' ,this,event,'170');" onmouseout="hidetip();"></div></a></div>
						<?
						}
						if($varType==4) {
						?>
						<div id="view4n" style="float:left; display:block"><div class="useracticonsimgs fourviewon" onmouseout="hidetip();" onmouseover="showhint('Displays up to 40 profiles' ,this,event,'170');"></div></div>
						<?
						}
						else {
						?>
						<div id="view4f" style="float:left; display:block;"><a  href="javascript:;" onclick="javascript:match_open_view(4);hidetip();" style="cursor:pointer;" onmouseout="hidetip();"><div class="useracticonsimgs fourview" onmouseover="showhint('Displays up to 40 profiles' ,this,event,'170');" onmouseout="hidetip();"></div></a></div>
						<?
						}
						if($varType==2) {
						?>
						<div id="view2n" style="float:left; display:block;"><div class="useracticonsimgs twoviewon" onmouseout="hidetip();" onmouseover="showhint('Displays up to 20 profiles' ,this,event,'170');"></div></div>
						<?
						}
						else {
						?>
						<div id="view2f" style="float:left; display:block;"><a  href="javascript:;" onclick="javascript:match_open_view(2);hidetip();" style="cursor:pointer;" onmouseout="hidetip();"><div class="useracticonsimgs twoview" onmouseout="hidetip();" onmouseover="showhint('Displays up to 20 profiles' ,this,event,'170');"></div></a></div>
						<?
						}
						if($varType==1) {
						?>
						<div id="viewbn" style="float:left; display:block;"><div class="useracticonsimgs basicviewon" onmouseout="hidetip();" onmouseover="showhint('Displays up to 10 profile' ,this,event,'170');"></div></div>	
						<?
						}
						else {
						?>
						<div id="viewbf" style="float:left; display:block;"><a  href="javascript:;" onclick="javascript:match_open_view(1);hidetip();" style="cursor:pointer;" onmouseout="hidetip();"><div class="useracticonsimgs basicview" onmouseout="hidetip();" onmouseover="showhint('Displays up to 10 profile' ,this,event,'170');" ></div></a></div>
						<?
						}
						?>
					</div>
				</div>
				</div>
			</div>
		</div><br clear="all">
	</div>
	</div>
	<div class="fleft inntabbr1"></div>
	</div><br clear="all">
	<!-- View Nave }-->
	<!--{ Inner div -->
	<div style=" width:508px;">
		<div class="fleft inntabbr2"></div>
		<div style="width:506px;float:left;" class="smalltxt">
			<div style="padding:8px;height:25px !important; height:43px;z-index:-1;" class="fright">
			<?if($varTempCount > 0){?>
				<div id="matchpaging"></div>
			<?}?>
			</div>
		</div>
		<div class="fleft inntabbr2"></div>
	</div>
	<?if($varTempCount > 0){?>
	<div style="width:506px;padding-left:8px" class="smalltxt"><?=$varDesc?></div>
	<?}?>
		<!--{ Basic View Template -->
		<?	if($varTempCount > 0) {
			$varIdInfo	= recDisplayArray($varOppositeId, $objSlave);
			$varArr		= basicView($varOppositeId, $varType, $objSlave, 'Y', '', '', $varIdInfo);
			$objSlave->dbClose();
			$varTotalIds	= count($varOppositeId);

			if($varType==1) {
			//Top Button (sendmail, ExpInterest)
			$varTopContent ='<div class="middiv2 smalltxt" id="disp_expdiv"><div class="fleft" style="padding-top:8px;"><input type="checkbox" name="chk2" id="chk2" onclick="botchk(\'prevnext\')"></div><div class="fleft " style="padding-top:10px;"><label for="chk2">Select All</label></div><div class="smalltxt" style="float:right; padding:5px;">';
			$varBotContent ='<div class="middiv2 smalltxt" id="disp_expdiv"><div class="fleft" style="padding-top:8px;"><input type="checkbox" name="chk2" id="chk2" onclick="botchk(\'prevnext1\')"></div><div class="fleft " style="padding-top:10px;"><label for="chk2">Select All</label></div><div class="smalltxt" style="float:right; padding:5px;">';
			
			if($varPaidSt != 'F')
			{
				$varTopContent .= '<input type="button" value="Send Mail All" class="button button-border" onclick="form_contact();">';
				$varBotContent .= '<input type="button" value="Send Mail All" class="button button-border" onclick="form_contact();">';
			}
			else
			{
				$varTopContent .= '<input type="button" value="Express Interest All" class="button button-border"											  onclick="form_express();">';
				$varBotContent .= '<input type="button" value="Express Interest All" class="button button-border"											  onclick="form_express();">';
			}
			
			$varTopContent .= '&nbsp;<input type="button" value="Forward" class="button button-border" onclick="form_forward();"></div><br clear="all"></div>';
			$varBotContent .= '&nbsp;<input type="button" value="Forward" class="button button-border" onclick="form_forward();"></div><br clear="all"></div>';

			//Top Button (sendmail, ExpInterest)
			$varBViewCont  = '<form name="photofrm" style="margin:0px;">';
			$varBViewCont .= $varTopContent;
			$varBViewCont .= '<div class="borderline"><img width="508" height="1" src="http://'.														$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif"/></div><brclear="all">';

			for($i=0;$i<$varTotalIds;$i++){
			if($varPaidSt != 'F') {
			$varProButton = '<div class="vdotline"><div class="smalltxt phnextpadding fleft"> <a href="javascript:void(0)" 
			onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',550,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/inbox/inbcontact.php?ID='.$varOppositeId[$i].'\',\'\',\'dispcontent\',\'\',\'\')"><div class="pntr">Type your message</div></a></div><div style="padding: 7px;"class="smalltxt fright"><input type="button" onclick="javascript:fade(\'M'.$i.'\', \'fadediv\',\'dispdiv\',550,\'\',\'\', \'http://'.$GETDOMAININFO['domainmodule'].'/inbox/inbcontact.php?ID='.$varOppositeId[$i].'\',\'\',\'dispcontent\',\'\',\'\');" class="button button-border" value="Send Mail"/></div></div>';
			} else {
			$varProButton = '<div class="vdotline"><div class="smalltxt phnextpadding fleft"><a href="javascript:void(0)" 
			onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',534,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/expressinterest/geteioptions.php?t='.$varOppositeId[$i].'\',\'\',\'dispcontent\',\'\',\'\')"><div class="fleft pntr">Select your message</div><div class="exp_downarrow_icon fleft pntr"></div></a></div><div class="smalltxt fright" style="padding: 7px;"><input value="Express Interest" class="button button-border" onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',534,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/expressinterest/geteioptions.php?t='.$varOppositeId[$i].'\',\'\',\'dispcontent\',\'\',\'\')" type="button"></div></div>';
			}
			
			$varDivStyle	 = ($varIdInfo[$varOppositeId[$i]]["BookmarkedId"] == "Y") ? 'none' : 'block';
		
			$varShortListDiv = '<a class="clr1" onclick="javascript:try{fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/memberlist/bookmark.php?divname=shortlist'.$i.'&divname_1=ignore'.$i.'&shlink=linkbk_'.$i.'&type=b&bookmarkedid='.$varOppositeId[$i].'&operation=a\',\'\',\'dispcontent\',\'\',\'\');}catch(e){}" href="javascript:void(0)">Shortlist</a>';

			$varCheckBox	 = '<div class="fleft"><input type="checkbox" value="'.$varOppositeId[$i].'" name="ID[]" id="STP'.$i.'"/></div><div onclick="chkbox_check(\'STP'.$i.'\');" class="fleft vc6pd-top smalltxt1">Select this profile</div>';

			$varTopContent	 = '<div id="M'.$i.'" class="fleft middiv2">'.$varCheckBox.'<div class="fright"><div class="smalltxt"><div class="fleft"	id="linkbk_'.$i.'" style="display:'.$varDivStyle.'">'.$varShortListDiv.'</div>
			&nbsp;&nbsp;&nbsp;<a class="clr1" target="_blank" href="http://'.$GETDOMAININFO['domainmodule'].'/search/smartsearch.php?t=S&DISPLAY_FORMAT=one&ID='.$varOppositeId[$i].'&SEARCH_TYPE=SIMILAR&GENDER='.$varOppGen.'">Similar Profiles</a></div></div></div><br clear="all">';

			$varBViewCont  .= $varTopContent;
			$varBViewCont  .= $varArr[$varOppositeId[$i]."_$i"];
			$varBViewCont  .= $varProButton;
			$varBViewCont  .= '<br clear="all"><div class="borderline"><img width="508" height="1" src="http://'.			$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif"/></div><br clear="all">';
			
			}//for
			$varBViewCont  .= $varBotContent.'</form>';
			echo $varBViewCont;
			}
			elseif($varType==2) {
			$j=0;
			for($i=0;$i<$varTotalIds/2;$i++) {
			echo $varArr[$varOppositeId[$j]."_$j"];
			echo '<div style="width:4px;" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="4" height="1"></div>';
			echo $varArr[$varOppositeId[$j+1]."_".($j+1)];
			echo '<br clear="all"><div style="width:506px;" height="5" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="506" height="5"></div>';
			$j=$j+2;
			}
			}
			elseif($varType==4) {
			$j =0;
			for($i=0;$i<$varTotalIds/2;$i++) {
				echo $varArr[$varOppositeId[$j]."_".$j];
				echo '<div style="width:4px;" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="4" height="1"></div>';
				echo $varArr[$varOppositeId[$j+1]."_".($j+1)];
				echo '<br clear="all"><div style="width:506px;" height="5" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="506" height="5"></div>';
				$j=$j+2;
			}
			}
			elseif($varType==6) {
			$j=0;
			for($i=0;$i<$varTotalIds/3;$i++) {
				echo $varArr[$varOppositeId[$j]."_".$j];
				echo '<div style="width:4px;" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="4" height="1"></div>';
				echo $varArr[$varOppositeId[$j+1]."_".($j+1)];
				echo '<div style="width:4px;" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="4" height="1"></div>';
				echo $varArr[$varOppositeId[$j+2]."_".($j+2)];
				echo '<br clear="all"><div style="width:506px;" height="5" class="fleft"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" width="506" height="5"></div>';
				$j=$j+3;
			}
		}
		?>
	<!-- Basic View Template End }-->							
	<div class="fright" style="padding: 10px 12px 0px 0px;">
	<div id="matchpaging1"></div>
	<div id="showall"></div>
	</div><br clear="all">
	<? }else { ?>
		<div class="smalltxt" style="padding:0px 0px 10px 10px;"><b><?=$varNotAvailMsg?></b></div>
	<? } ?>
	<!--{ replied inner div --> 	
<?php if($varAjax == 'N'){ ?>
   <img src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/bmimages/trans.gif" height="1" onload="matchalljs('<?=$varTotalPages?>','<?=$varCurrPg?>','mutualmatchgetall.php','<?=$varType?>','<?=$varReqPg?>','<?=$varTempCount?>')"> 
<?php } ?>
</div>
<?php 
}//if - check db error
else{
	echo '<div style="padding:20px 0px 0px 0px"><font class="smalltxt">'.$varDbError.'</font></div>';
}
?>