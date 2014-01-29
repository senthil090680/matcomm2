<?php
/****************************************************************************************************
File		: inbreceived.php
Author		: Suresh Babu S.M, Kumaran K.M
Date		: 13-Dec-2007
*****************************************************************************************************
Description	: 
	This page has the functionalities of Mail Received Bharatmatrimony.com My Messages Menu.
********************************************************************************************************/

// Include the files //
$DOCROOTPATH	 = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($DOCROOTPATH);

include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearchformarren.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";

// This function will called from inbox, expinterest, rss/community, etc. //
function ma_basicView($matriid, $type, $dbslave='', $righticon='Y', $matchwatch='', $paidstatus, $chkBox='N') {
	$usrArray = ma_recDisplayArray($matriid, $dbslave);
	if($type==1) {
		$templateArray = ma_singleViewTemplate($matriid, $usrArray, $righticon, $matchwatch, $paidstatus, $chkBox);
	}
	elseif($type==2) {
		$templateArray = ma_twoViewTemplate($matriid, $usrArray);
	}
	elseif($type==4) {
		$templateArray = ma_fourViewTemplate($matriid, $usrArray);
	}
	elseif($type==6) {
		$templateArray = ma_sixViewTemplate($matriid, $usrArray);
	}
	return $templateArray;
}

function ma_singleViewTemplate($matriid, $usrArray, $righticon='Y', $matchwatch='', $paidstatus, $chkBox) {
	Global $GETDOMAININFO,$formattedArr;
	$templateArr = array();
	for($i=0;$i<count($matriid);$i++) {
		if(is_array($matriid)) {
			$userid = $matriid[$i];
		}
		else {
			$userid = $matriid;
		}
		$getdomain = getDomainInfo(1, $userid);

		//Speical Icons
		$onlineimg = ($usrArray[$userid]["online"] == "Y") ? '<img src="'.$getdomain["domainnameimgs"].'bmimages/online.gif" width="54" height="18" border="0" alt="">' : '';
		$classicsuper = ($usrArray[$userid]["SpecialPriv"] == 2) ? '<div class="useracticonsimgs clssupr"></div>' : '';
		$bookmarkdiv = ($usrArray[$userid]["BookmarkedId"] == "Y") ? '<a href="javascript:;" onclick="fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/memberlist/bookmark.php?type=b&divname=innerbookmark'.$i.'&divname_1=innerignored'.$i.'&bookmarkedid='.$userid.'&shlink=linkbk_'.$i.'&operation=a\',\'http://'.$GETDOMAININFO['domainnameimgs'].'/scripts/bookmark.js\',\'dispcontent\',\'\',\'\');"><div class="useracticonsimgs shortlist"></div></a>' : '';
		$blockdiv = ($usrArray[$userid]["BlockedId"] == "Y") ? '<div class="useracticonsimgs profiledeclined"></div>' : '';
		$ignorediv = ($usrArray[$userid]["IgnoredId"] == "Y") ? '<a href="javascript:;" onclick="fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/memberlist/bookmarkshow.php?type=i&divname=ignore'.$matchwatch.$i.'&bookmarkedid='.$userid.'&operation=a\',\'http://'.$GETDOMAININFO['domainnameimgs'].'/scripts/bookmark.js\',\'dispcontent\',\'\',\'\');"><div class="useracticonsimgs ignore"></div></a>' : '';

		if($usrArray[$userid]['Gender'] == "F") {
			$PhotoOpt = "F";
		}
		else {
			$PhotoOpt = "M";
		}
		//Photo Traverse
		if($usrArray[$userid]['ThumbImg']) {
			$photoScript = 'PhTravs(\'\',\'\',\''.$usrArray[$userid]["photo"].'\',\''.$usrArray[$userid]["ThumbImg"].'\',\'imagecontainer'.$matchwatch.$i.'\',\'backforthbuttons'.$matchwatch.$i.'\',\'\',\'Y\',\'imgpreview'.$matchwatch.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['photopr'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'P'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$matchwatch.$i.'\',\'backforthbuttons'.$matchwatch.$i.'\',\'\',\'N\',\'imgpreview'.$matchwatch.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['reqphoto'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$matchwatch.$i.'\',\'backforthbuttons'.$matchwatch.$i.'\',\'\',\'N\',\'imgpreview'.$matchwatch.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		else {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$matchwatch.$i.'\',\'backforthbuttons'.$matchwatch.$i.'\',\'\',\'N\',\'imgpreview'.$matchwatch.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}

		//Right Icon view
		if($usrArray[$userid]['phone'] == "Y") {
			$phonediv = '<div style=\'\'><div class=\'useracticonsimgs phone\'></div></div>';
		}
		else {
			$phonediv = '<div style=\'\'><div class=\'useracticonsimgs pphone\'></div></div>';
		}
		if($usrArray[$userid]['horoscope'] == "GY") {
			$horodiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs horogen\'></div></div>';
		}
		else if($usrArray[$userid]['horoscope'] == "UY") {
			$horodiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs horo\'></div></div>';
		}
		else {
			$horodiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs phorogen\'></div></div>';
		}
		if($usrArray[$userid]['reference'] == "Y") {
			$referencediv = '<div style=\'padding:2px 0px 0px 2px;\'><div class=\'useracticonsimgs matriref\'></div></div>';
		}
		else {
			$referencediv = '<div style=\'padding:2px 0px 0px 2px;\'><div class=\'useracticonsimgs pmatriref\'></div></div>';
		}
		if($usrArray[$userid]['verification'] == "Y") {
			$verificationdiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs veriprofile\'></div></div>';
		}
		else {
			$verificationdiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs pveriprofile\'></div></div>';
		}
		if($usrArray[$userid]['voice'] == "Y") {
			$voicediv = '<div style=\'\'><div class=\'useracticonsimgs voice\'></div></div>';
		}
		else {
			$voicediv = '<div style=\'\'><div class=\'useracticonsimgs pvoice\'></div></div>';
		}
		//Last Action for contact history
		if($usrArray[$userid]['LastAction'] == "IR") {
			$ladiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs intreceived\'></div></div>';
		}
		else if($usrArray[$userid]['LastAction'] == "IS") {
			$ladiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs intsent\'></div></div>';
		}
		else if($usrArray[$userid]['LastAction'] == "MS") {
			$ladiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs msgsent\'></div></div>';
		}
		else if($usrArray[$userid]['LastAction'] == "MR") {
			$ladiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs msgrecd\'></div></div>';
		}
		else if($usrArray[$userid]['LastAction'] == "MP") {
			$ladiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs msgaccept\'></div></div>';
		}
		else if($usrArray[$userid]['LastAction'] == "MD") {
			$ladiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs msgdecline\'></div></div>';
		}
		else {
			$ladiv = '';
		}
		if($usrArray[$userid]['video'] == "Y") {
			$videodiv = '<div style=\'padding-top:2px;\'><div class=\'useracticonsimgs video\'></div></div>';
		}
		else {
			$videodiv = '';
		}
		$basicViewContent = urldecode(formatTitleValue($usrArray[$userid]['Age'], $usrArray[$userid]['Height'], $formattedArr['Religion'], $formattedArr['Caste'], $usrArray[$userid]['SubCaste'], '', '', '', $usrArray[$userid]['CountrySelected'], $usrArray[$userid]['ResidingDistrict'], $usrArray[$userid]['ResidingState'], $usrArray[$userid]['ResidingArea'], '', $formattedArr['Country'], $formattedArr['Education'], $usrArray[$userid]['Education'], $formattedArr['Occupation'], $formattedArr['Height'], $usrArray[$userid]['Occupation'],"one"));

		if($usrArray[$userid] == 1) {
			$templateArr[$userid."_".$i] = '<div style="float:left;border:1px solid #CFCFCF;">
				<div style=" width:504px; height:120px; text-align:center;">
					<div class="smalltxt" style="padding-top:50px;"><b>Matrimony Id '.$userid.' is hidden</b></div>
				</div>
			</div><br clear="all">';
		}
		else if($usrArray[$userid] == 0) {
			$templateArr[$userid."_".$i] = '<div style="float:left;border:1px solid #CFCFCF;">
				<div style=" width:504px; height:120px; text-align:center;">
					<div class="smalltxt" style="padding-top:50px;"><b>Matrimony Id '.$userid.' is suspended or deleted</b></div>
				</div>
			</div><br clear="all">';
		}
		else {
			if($paidstatus != 'F') {
				$varProButton = '<div class="vdotline"><div class="smalltxt phnextpadding fleft"> <a href="javascript:void(0)" 
				onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',550,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/inbox/inbcontact.php?ID='.$userid.'\',\'\',\'dispcontent\',\'\',\'\')"><div class="pntr">Type your message</div></a></div><div style="padding: 7px;"class="smalltxt fright"><input type="button" onclick="javascript:fade(\'M'.$i.'\', \'fadediv\',\'dispdiv\',550,\'\',\'\', \'http://'.$GETDOMAININFO['domainmodule'].'/inbox/inbcontact.php?ID='.$userid.'\',\'\',\'dispcontent\',\'\',\'\');" class="button button-border" value="Send Mail"/></div></div>';
			} else {
				$varProButton = '<div class="vdotline"><div class="smalltxt phnextpadding fleft"><a href="javascript:void(0)" 
				onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',534,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/expressinterest/geteioptions.php?t='.$userid.'\',\'http://'.$GETDOMAININFO['domainnameimgs'].'/scripts/getoptionsei.js\',\'dispcontent\',\'\',\'\')"><div class="fleft pntr">Select your message</div><div class="exp_downarrow_icon fleft pntr"></div></a></div><div class="smalltxt fright" style="padding: 7px;"><input value="Express Interest" class="button button-border" onclick=" javascript:fade(\'M'.$i.'\',\'fadediv\',\'dispdiv\',534,\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/expressinterest/geteioptions.php?t='.$userid.'\',\'http://'.$GETDOMAININFO['domainnameimgs'].'/scripts/getoptionsei.js\',\'dispcontent\',\'\',\'\')" type="button"></div></div>';
			}
			
			$varDivStyle	 = ($usrArray[$userid]["BookmarkedId"] == "Y") ? 'none' : 'block'; 
			$varShortListDiv = '<a class="clr1" onclick="javascript:try{fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'http://'.$GETDOMAININFO['domainmodule'].'/memberlist/bookmark.php?divname=innerbookmark'.$i.'&divname_1=innerignored'.$i.'&shlink=linkbk_'.$i.'&type=b&bookmarkedid='.$userid.'&operation=a\',\'http://'.$GETDOMAININFO['domainnameimgs'].'/scripts/bookmark.js\',\'dispcontent\',\'\',\'\');}catch(e){}" href="javascript:void(0)">Shortlist</a>';

			$varCheckBox	 = ($chkBox == 'N')?'':'<div class="fleft"><input type="checkbox" value="'.$userid.'" name="ID[]" id="STP'.$i.'"/></div><div onclick="chkbox_check(\'STP'.$i.'\');" class="fleft vc6pd-top smalltxt1">Select this profile</div>';

			$templateArr[$userid."_".$i] = '<div id="M'.$i.'" class="fleft middiv2">'.$varCheckBox.'
				<div class="fright"><div class="smalltxt"><div class="fleft" id="linkbk_'.$i.'" style="display:'.$varDivStyle.'">'.$varShortListDiv.'</div>
				&nbsp;&nbsp;&nbsp;<a class="clr1" target="_blank" href="http://'.$GETDOMAININFO['domainmodule'].'/search/smartsearch.php?t=S&DISPLAY_FORMAT=one&ID='.$userid.'&SEARCH_TYPE=SIMILAR&GENDER='.$usrArray[$userid]['Gender'].'">Similar Profiles</a></div></div></div><br clear="all">';

			$templateArr[$userid."_".$i] .= '<div id="bview'.$i.'" class="'.$usrArray[$userid]["color"].'">
				<div class="vcpad">
					<div class="vc-dl">
						<div class="smalltxt clr1" title="Indicates how compatible you are with this member"><a href="javascript:fade(\''.$hidediv.'\',\'fadediv\',\'dispdiv\',\'450\',\'\',\'\',\'/search/smartcompatibilitystatus.php?ran='.genRandom().'&ID='.$userid.'&N='.$usrArray[$userid]["Name"].'&s='.$usrArray[$userid]["CompChart"].'\',\'\',\'dispcontent\',\'\',\'\');" class="smalltxt clr1">Compatibility status	- '.$usrArray[$userid]["CompChart"].'%</a> <a href="javascript:fade(\''.$hidediv.'\',\'fadediv\',\'dispdiv\',\'450\',\'\',\'\',\'/search/smartcompatibilitystatus.php?ran='.genRandom().'&ID='.$userid.'&N='.$usrArray[$userid]["Name"].'&s='.$usrArray[$userid]["CompChart"].'\',\'\',\'dispcontent\',\'\',\'\');" class="smalltxt clr1"><img src="http://'.$getdomain["domainnameimgs"].'/bmimages/smart_pp_bar_'.$usrArray[$userid]["CompChart"].'.gif" width="100" height="12" border="0" alt="" ></a></div>
						<div class="vcpd-top">
							<div class="fleft">
							<div id="imagecontainer'.$matchwatch.$i.'"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" onload="'.$photoScript .'"></div>
							<div id="imgpreview'.$matchwatch.$i.'"></div>
							<div id="backforthbuttons'.$matchwatch.$i.'"></div>
							</div>
							<div class="fleft vc1-wt">
								<div class="vc-padl">
									<div class="smalltxt">
										<div class="fleft"><a href="/profiledetail/viewprofile.php?id='.$userid.'" target="_blank" class=" matriidlink bold">'.strToTitle($usrArray[$userid]["Name"]).' ('.$userid.')</a></div>
										<div id="useracticons">
											<div id="useracticonsimgs" style="float: left;">
												<div class="fleft" style="padding: 0px 0px 0px 5px" title="Classic Super Member">
												'.$classicsuper.'
												</div>
												<div id="innerbookmark'.$i.'" class="fleft" style="padding: 2px 0px 0px 5px" title="This member is currently in your Shortlist">'.$bookmarkdiv.'</div>
												<div id="innerignored'.$i.'" class="fleft" style="padding: 0px 0px 0px 5px" title="This member is currently in your Ignore List"">'.$ignorediv.'</div>
												<div class="fleft" style="padding: 0px 0px 0px 0px" title="This member is currently in your Block List">'.$blockdiv.'</div>
												<div style="float:left;" style="padding: 0px 0px 0px 5px">'.$onlineimg.'</div>
											</div>
										</div><br clear="all">
										<div class="fleft"><font class="smalltxt clr2">Active:  '.getLastLoginInfo($usrArray[$userid]["LastLogin"],$usrArray[$userid]["TimeCreated"]).'</font></div> 
										<br clear="all">
										'.$basicViewContent.' &nbsp; <a href="/profiledetail/viewprofile.php?id='.$userid.'" class="smalltxt clr1 fright" target="_blank">Full&nbsp;Profile&nbsp;>></a>
									</div>
								</div>   
							</div>
						</div>
					</div>';
					if($righticon == "Y") {
						$templateArr[$userid."_".$i] .='<div class="fleft dotline" style="height:105px;margin:3px 10px 0px 0px;"></div>
						<div class="fleft icon">
							<!--{ Icon -->
							<div id="useracticons">
								<div id="useracticonsimgs" style="float: left; text-align: middle;">
									<div id="mainicon'.$matchwatch.$i.'" onMouseover="iconview(\'mainicon'.$matchwatch.$i.'\',\'icondiv'.$matchwatch.$i.'\',\''.$GETDOMAININFO["domainmodule"].'\',\''.$getdomain["domainnameimgs"].'\',\''.$userid.'\',\''.$usrArray[$userid]['phone'].'\',\''.$usrArray[$userid]['horoscope'].'\',\''.$usrArray[$userid]['reference'].'\',\''.$usrArray[$userid]['verification'].'\',\''.$usrArray[$userid]['voice'].'\',\''.$usrArray[$userid]['LastAction'].'\',\''.$usrArray[$userid]['video'].'\',\''.$hidediv.'\')">'.$phonediv.''.$horodiv.''.$referencediv.''.$verificationdiv.''.$voicediv.''.$ladiv.''.$videodiv.'					
									</div>
								</div>
							</div>
							<!-- Icon }-->
						</div>';
					}
				$templateArr[$userid."_".$i] .= '</div><br clear="all"></div><br clear="all">';
				$templateArr[$userid."_".$i] .= $varProButton;
		}
	}
	return $templateArr;
}

function ma_twoViewTemplate($matriid, $usrArray) {
	Global $GETDOMAININFO,$formattedArr;
	$templateArr = array();
	for($i=0;$i<count($matriid);$i++) {
		if(is_array($matriid)) {
			$userid = $matriid[$i];
		}
		else {
			$userid = $matriid;
		}
		$getdomain = getDomainInfo(1, $userid);
		if($usrArray[$userid]['Gender'] == "F") {
			$PhotoOpt = "F";
		}
		else {
			$PhotoOpt = "M";
		}
		if($usrArray[$userid]['ThumbImg']) {
			$photoScript = 'PhTravs(\'\',\'\',\''.$usrArray[$userid]["photo"].'\',\''.$usrArray[$userid]["ThumbImg"].'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'Y\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['photopr'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['reqphoto'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'P'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		else {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}

		$basicViewContent = urldecode(formatTitleValue($usrArray[$userid]['Age'], $usrArray[$userid]['Height'], $formattedArr['Religion'], $formattedArr['Caste'], $usrArray[$userid]['SubCaste'], '', '', '', $usrArray[$userid]['CountrySelected'], $usrArray[$userid]['ResidingDistrict'], $usrArray[$userid]['ResidingState'], $usrArray[$userid]['ResidingArea'], '', $formattedArr['Country'], $formattedArr['Education'], $usrArray[$userid]['Education'], $formattedArr['Occupation'], $formattedArr['Height'], $usrArray[$userid]['Occupation'],"two"));

		if($usrArray[$userid] == 1) {
			$templateArr[$userid."_".$i] = '<div class="fleft"><div class="vcpad" style="float:left;border:0px solid #CFCFCF;">
				<div class="vc2-dl" style="text-align:center;">
					<div class="smalltxt" style="padding-top:25px;"><b>Matrimony Id '.$userid.' is hidden</b></div>
				</div><br clear="all">
			</div></div>';
		}
		else if($usrArray[$userid] == 0) {
			$templateArr[$userid."_".$i] = '<div class="fleft"><div class="vcpad" style="float:left;border:0px solid #CFCFCF;">
				<div class="vc2-dl" style="text-align:center;">
					<div class="smalltxt" style="padding-top:25px;"><b>Matrimony Id '.$userid.' is suspended or deleted</b></div>
				</div><br clear="all">
			</div></div>';
		}
		else {
			$templateArr[$userid."_".$i] = '<div class="'.$usrArray[$userid]["color1"].'">
				<div class="vcpad">
					<div class="vc2-dl">
						<div class="vcpd-top">
							<div class="fleft">
								<div id="imagecontainer'.$i.'"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" onload="'.$photoScript.'">
								</div>
								<div id="imgpreview'.$i.'"></div>
								<div id="backforthbuttons'.$i.'"></div>
							</div>
							<div class="fleft vc2-wt">
								<div class="smalltxt clr2 vc-padl"><div class="fleft"><a href="/profiledetail/viewprofile.php?id='.$userid.'" target="_blank" class=" matriidlink bold">'.strtoupper($usrArray[$userid]["Name"]).'  ('.$userid.')</a> </div><br clear="all">
								'.$basicViewContent.'.<br>
								<a href="/profiledetail/viewprofile.php?id='.$userid.'" class="smalltxt clr1 fright" target="_blank">Full&nbsp;Profile&nbsp;>></a> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
	}
	return $templateArr;
}

function ma_fourViewTemplate($matriid, $usrArray) {
	Global $GETDOMAININFO,$formattedArr;
	$templateArr = array();
	for($i=0;$i<count($matriid);$i++) {
		if(is_array($matriid)) {
			$userid = $matriid[$i];
		}
		else {
			$userid = $matriid;
		}
		$getdomain = getDomainInfo(1, $userid);
		if($usrArray[$userid]['Gender'] == "F") {
			$PhotoOpt = "F";
		}
		else {
			$PhotoOpt = "M";
		}
		if($usrArray[$userid]['ThumbImg']) {
			$photoScript = 'PhTravs(\'\',\'\',\''.$usrArray[$userid]["photo"].'\',\''.$usrArray[$userid]["ThumbImg"].'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['photopr'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['reqphoto'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'P'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		else {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		
		$basicViewContent = urldecode(formatTitleValue($usrArray[$userid]['Age'], $usrArray[$userid]['Height'], $formattedArr['Religion'], $formattedArr['Caste'], $usrArray[$userid]['SubCaste'], '', '', '', $usrArray[$userid]['CountrySelected'], $usrArray[$userid]['ResidingDistrict'], $usrArray[$userid]['ResidingState'], $usrArray[$userid]['ResidingArea'], '', $formattedArr['Country'], $formattedArr['Education'], $usrArray[$userid]['Education'], $formattedArr['Occupation'], $formattedArr['Height'], $usrArray[$userid]['Occupation'],"four"));

		if($usrArray[$userid] == 1) {
			$templateArr[$userid."_".$i] = '<div class="vcpad" style="float:left;border:0px solid #CFCFCF;">
				<div class="vc2-dl" style="text-align:center;">
					<div class="smalltxt" style="padding-top:25px;"><b>Matrimony Id '.$userid.' is hidden</b></div>
				</div><br clear="all">
			</div>';
		}
		else if($usrArray[$userid] == 0) {
			$templateArr[$userid."_".$i] = '<div class="vcpad" style="float:left;border:0px solid #CFCFCF;">
				<div class="vc2-dl" style="text-align:center;">
					<div class="smalltxt" style="padding-top:25px;"><b>Matrimony Id '.$userid.' is suspended or deleted</b></div>
				</div><br clear="all">
			</div>';
		}
		else {
			$templateArr[$userid."_".$i] = '<div class="'.$usrArray[$userid]["color1"].'">
				<div class="vcpad">
					<div class="vc2-dl">
						<div class="vcpd-top">
							<div class="fleft">
								<div id="imagecontainer'.$i.'"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" onload="'.$photoScript .'" width="75" height="75"></div>
								<div id="imgpreview'.$i.'"></div>
								<div id="backforthbuttons'.$i.'"></div>
							</div>
							<div class="fleft vc2-wt">
								<div class="smalltxt vc4-padl"><a href="/profiledetail/viewprofile.php?id='.$userid.'" target="_blank" class=" matriidlink bold">'.strtoupper($usrArray[$userid]["Name"]).'  ('.$userid.')</a> <br>
								'.$basicViewContent.' <br>
								<a href="/profiledetail/viewprofile.php?id='.$userid.'" class="smalltxt clr1 fright" target="_blank">Full&nbsp;Profile&nbsp;>></a> 
								</div>   
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
	}
	return $templateArr;
}

function ma_sixViewTemplate($matriid, $usrArray) {
	Global $GETDOMAININFO,$formattedArr;
	$templateArr = array();
	for($i=0;$i<count($matriid);$i++) {
		if(is_array($matriid)) {
			$userid = $matriid[$i];
		}
		else {
			$userid = $matriid;
		}
		$getdomain = getDomainInfo(1, $userid);
		if($usrArray[$userid]['Gender'] == "F") {
			$PhotoOpt = "F";
		}
		else {
			$PhotoOpt = "M";
		}
		if($usrArray[$userid]['ThumbImg']) {
			$photoScript = 'PhTravs(\'\',\'\',\''.$usrArray[$userid]["photo"].'\',\''.$usrArray[$userid]["ThumbImg"].'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['photopr'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		elseif($usrArray[$userid]['reqphoto'] == "Y") {
			$photoScript = 'PhTravs(\'\',\'P'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}
		else {
			$photoScript = 'PhTravs(\'\',\'R'.$PhotoOpt.'\',\'\',\'\',\'imagecontainer'.$i.'\',\'backforthbuttons'.$i.'\',\'\',\'N\',\'imgpreview'.$i.'\',\''.$userid.'\',\''.$getdomain["domainmodule"].'\')';
		}

		$basicViewContent = urldecode(formatTitleValue($usrArray[$userid]['Age'], $usrArray[$userid]['Height'], $formattedArr['Religion'], $formattedArr['Caste'], $usrArray[$userid]['SubCaste'], '', '', '', $usrArray[$userid]['CountrySelected'], $usrArray[$userid]['ResidingDistrict'], $usrArray[$userid]['ResidingState'], $usrArray[$userid]['ResidingArea'], '', $formattedArr['Country'], $formattedArr['Education'], $usrArray[$userid]['Education'], $formattedArr['Occupation'], $formattedArr['Height'], $usrArray[$userid]['Occupation'],"six"));

		if($usrArray[$userid] == 1) {
			$templateArr[$userid."_".$i] = '<div class="vcpad" style="float:left;border:0px solid #CFCFCF;">
				<div class="vc6-dl" style="text-align:center;">
					<div class="smalltxt" style="padding-top:25px;"><b>Matrimony Id '.$userid.' is hidden</b></div>
				</div><br clear="all">
			</div>';
		}
		else if($usrArray[$userid] == 0) {
			$templateArr[$userid."_".$i] = '<div class="vcpad" style="float:left;border:0px solid #CFCFCF;">
				<div class="vc6-dl" style="text-align:center;">
					<div class="smalltxt" style="padding-top:25px;"><b>Matrimony Id '.$userid.' is suspended or deleted</b></div>
				</div><br clear="all">
			</div>';
		}
		else {
			$templateArr[$userid."_".$i] = '<div class="'.$usrArray[$userid]["color2"].'">
				<div class="vcpad">
					<div class="vc6-dl">
						<div class="vcpd-top">
							<div class="fleft">
								<div id="imagecontainer'.$i.'"><img src="http://'.$GETDOMAININFO['domainnameimgs'].'/bmimages/trans.gif" onload="'.$photoScript .'">
								</div>
								<div id="imgpreview'.$i.'"></div>
								<div id="backforthbuttons'.$i.'"></div>
							</div>
							<div class="fleft vc6-wt">
								<div class="smalltxt vc4-padl"><a href="/profiledetail/viewprofile.php?id='.$userid.'" target="_blank" class=" matriidlink bold"><font class="bold">('.$userid.') </font></a><br>
								'.$basicViewContent.' <br><a href="/profiledetail/viewprofile.php?id='.$userid.'" class="smalltxt clr1 fright" target="_blank">Full&nbsp;Profile&nbsp;>></a> 
								</div>   
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
	}
	return $templateArr;
}

function ma_recDisplayArray($matriid, $dbslave='') {
	Global $COMMONVARS, $COOKIEINFO, $DBINFO, $DBNAME, $MERGETABLE;  
	Global $language, $ln, $formattedArr;
	$usrArr = array();
	$memberid = $COOKIEINFO['LOGININFO']['MEMBERID'];
	$gender = $COOKIEINFO['LOGININFO']['GENDER'];
	$membership_entry = $COOKIEINFO['LOGININFO']['MEMBERSHIPENTRY'];
	$language = $COOKIEINFO['LOGININFO']['LANGUAGE'];
	if($dbslave=='') {
		$dbslave = new db();
		$dbslave->dbConnById(2,$matriid,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYLOG']);
		if($dbslave->error) $ERRORFLAG = 1;
	}
	$proftable = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE'];
	$phototable = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO'];
	if(is_array($matriid)) {
		$matriid = implode(",",$matriid);
		$matriid = str_replace(",","','",$matriid);
	}
	$profquery = "select Name,Language,MatriId,EntryType,SpecialPriv,Age,Gender,MaritalStatus,SpecialCase,MotherTongue,InCms,Height,Religion,Caste,SubCaste,CasteNoBar,Dosham,Star,EatingHabits,EducationSelected,Education,OccupationSelected,Occupation,Citizenship,CountrySelected,ResidentStatus,ResidingState,ResidingArea,ResidingCity,ResidingDistrict,PhoneVerified,PhotoAvailable,PhotoProtected,HoroscopeAvailable,HoroscopeProtected,VideoAvailable,VoiceAvailable,VideoProtected,LastLogin,ProfileVerified,TimeCreated from ".$proftable." where MatriId in ('$matriid') and Validated=1 and Authorized=1 and Status=0";
	$profcount = $dbslave->select($profquery);
	if($profcount > 0) { // If record exists for given matriid
		$resultrow  = $dbslave->getResultArray();
		$pp_val = 0;
		foreach($resultrow as $profresult) {
			$matriid = $profresult['MatriId'];
			$domain_info = getDomainInfo(1,$matriid);
			$img_link = "http://".$domain_info['domainnameimgs'];
			$img_domain_url = "http://".$domain_info['domainnameimg'];
			$usrArr[$profresult['MatriId']]['MatriId'] = $matriid;
			$usrArr[$profresult['MatriId']]['Name'] = $profresult['Name'];

			// Basic View Content
			stripslashes(extract($profresult));
			$formattedArr = formatDbValues($Height, $ResidingState, $ResidingDistrict, $Caste, $Religion, $EducationSelected, $MaritalStatus, $CountrySelected, $MotherTongue, $OccupationSelected, $Language, $Star, $Occupation,$CasteNoBar);

			$usrArr[$profresult['MatriId']]['Age'] = $Age;
			$usrArr[$profresult['MatriId']]['Gender'] = $Gender;
			$usrArr[$profresult['MatriId']]['Height'] = $Height;
			$usrArr[$profresult['MatriId']]['CountrySelected'] = $CountrySelected;
			$usrArr[$profresult['MatriId']]['ResidingDistrict'] = $ResidingDistrict;
			$usrArr[$profresult['MatriId']]['ResidingState'] = $ResidingState;
			$usrArr[$profresult['MatriId']]['ResidingArea'] = $ResidingArea;
			$usrArr[$profresult['MatriId']]['SubCaste'] = $SubCaste;
			$usrArr[$profresult['MatriId']]['Education'] = $Education;
			$usrArr[$profresult['MatriId']]['Occupation'] = $Occupation;
			$usrArr[$profresult['MatriId']]['LastLogin'] = $profresult['LastLogin'];
			$usrArr[$profresult['MatriId']]['TimeCreated'] = $profresult['TimeCreated'];
			//Compatability Chart
			$pp_val = getPpBarValues($profresult['Age'], $profresult['Height'],$profresult['MaritalStatus'],$profresult['SpecialCase'], $profresult['MotherTongue'],$profresult['Religion'],$profresult['Dosham'],$profresult['Caste'],$profresult['EatingHabits'],$profresult['EducationSelected'],$profresult['Citizenship'], $profresult['CountrySelected'], $profresult['ResidingState'], $profresult['ResidentStatus']);
			$usrArr[$profresult['MatriId']]['CompChart'] = $pp_val;

			if($profresult['PhotoAvailable']==1) {
				if($profresult['PhotoProtected']=='Y') {
					$res1 = $img_link."/images/protectedphotoimg-75x75.gif";
					$usrArr[$profresult['MatriId']]['Photo_altmsg'] = "alt='Photo Protected'";
					$res2 = "Y";
				} else {
					$photocount = $dbslave->select("select * from ".$phototable." where MatriId='$matriid'");
					if($photocount>0) {
						$row_p = $dbslave->fetchArray();
						$digit1 = $matriid;
						$res1 = $img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs1'];
						//checking first photo
						if($row_p['PhotoStatus1']==0 && $row_p['PhotoStatus1']!="" && $row_p['ThumbImg1'] !='' && $row_p['ThumbImgs1']!= '') { 
							$usrArr[$profresult['MatriId']]['photo'] = $img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs1'];
							$usrArr[$profresult['MatriId']]['ThumbImg'] = $img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg1'];
							//checking second photo
							if($row_p['PhotoStatus2']==0 && $row_p['PhotoStatus2']!="" && $row_p['ThumbImg2'] !='' && $row_p['ThumbImgs2']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs2'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg2'];
							}
							if($row_p['PhotoStatus3']==0 && $row_p['PhotoStatus3']!=""  && $row_p['ThumbImg3'] !='' && $row_p['ThumbImgs3']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^". $img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs3'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg3'];
							}
							if($row_p['PhotoStatus4']==0 && $row_p['PhotoStatus4']!=""  && $row_p['ThumbImg4'] !='' && $row_p['ThumbImgs4']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs4'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg4'];
							}
							if($row_p['PhotoStatus5']==0 && $row_p['PhotoStatus5']!=""  && $row_p['ThumbImg5'] !='' && $row_p['ThumbImgs5']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs5'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg5'];
							}
							if($row_p['PhotoStatus6']==0 && $row_p['PhotoStatus6']!=""  && $row_p['ThumbImg6'] !='' && $row_p['ThumbImgs6']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs6'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg6'];
							}
							if($row_p['PhotoStatus7']==0 && $row_p['PhotoStatus7']!=""  && $row_p['ThumbImg7'] !='' && $row_p['ThumbImgs7']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs7'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg7'];
							}
							if($row_p['PhotoStatus8']==0 && $row_p['PhotoStatus8']!=""  && $row_p['ThumbImg8'] !='' && $row_p['ThumbImgs8']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs8'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg8'];
							}
							if($row_p['PhotoStatus9']==0 && $row_p['PhotoStatus9']!=""  && $row_p['ThumbImg9'] !='' && $row_p['ThumbImgs9']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs9'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg9'];
							}
							if($row_p['PhotoStatus10']==0 && $row_p['PhotoStatus10']!=""  && $row_p['ThumbImg10'] !='' && $row_p['ThumbImgs10']!= '') {
								$usrArr[$profresult['MatriId']]['photo'] = $usrArr[$profresult['MatriId']]['photo'] . "^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImgs10'];
								$usrArr[$profresult['MatriId']]['ThumbImg'] = $usrArr[$profresult['MatriId']]['ThumbImg'] ."^".$img_link."/photos/".$digit1{1}."/".$digit1{2}."/".$row_p['ThumbImg10'];
							}
						}
					} 
					else {
						$usrArr[$profresult['MatriId']]['photo'] = $img_link."/images/thumbnotfound75x75.gif";
						$usrArr[$profresult['MatriId']]['photopr'] = "Y";
					}
				}
			} 
			else {
				$usrArr[$profresult['MatriId']]['photo'] = $img_link."/images/requestphoto75x75.gif";
				$usrArr[$profresult['MatriId']]['Photo_altmsg'] = "alt='Request Photo'";
				$usrArr[$profresult['MatriId']]['photopr'] = "Y";	
				$usrArr[$profresult['MatriId']]['reqphoto'] = "Y";
			}

			//Template color
			if($profresult['EntryType']=='R') {
				$usrArr[$profresult['MatriId']]['SpecialPriv'] = $profresult['SpecialPriv'];
				// Classic Plus
				if($profresult['SpecialPriv']=='1') {
					$usrArr[$profresult['MatriId']]['color'] = "vc1 vcp";
					$usrArr[$profresult['MatriId']]['color1'] = "vc2 vcp fleft";
					$usrArr[$profresult['MatriId']]['color2'] = "vc6 vcp fleft";
				} 
				// Classic Super
				else if($profresult['SpecialPriv']=='2') {
					$usrArr[$profresult['MatriId']]['color'] = "vc1 vcs";
					$usrArr[$profresult['MatriId']]['color1'] = "vc2 vcs fleft";
					$usrArr[$profresult['MatriId']]['color2'] = "vc6 vcs fleft";
				} 
				else { 
					$usrArr[$profresult['MatriId']]['color'] = "vc1 vc"; 
					$usrArr[$profresult['MatriId']]['color1'] = "vc2 vc fleft";
					$usrArr[$profresult['MatriId']]['color2'] = "vc6 vc fleft";
				}
			} 
			else {
				$usrArr[$profresult['MatriId']]['color'] = "vc1 vc"; 
				$usrArr[$profresult['MatriId']]['color1'] = "vc2 vc fleft";
				$usrArr[$profresult['MatriId']]['color2'] = "vc6 vc fleft";
			}

			//horscope
			if($profresult['HoroscopeAvailable']==1) { //manually uploaded - Globe icon
				$usrArr[$profresult['MatriId']]['horoscope'] = "UY";
			} 
			else if($profresult['HoroscopeAvailable']==2) { //support validated horo - comp icon
				$usrArr[$profresult['MatriId']]['horoscope'] = "GY";
			}
			else if($profresult['HoroscopeAvailable']==3) { //computer generated - comp icon
				$usrArr[$profresult['MatriId']]['horoscope'] = "GY";
			}
			else {
				$usrArr[$profresult['MatriId']]['horoscope'] = "GN";
			}

			//Video
			if($profresult['VideoAvailable']==1) {
				if($profresult['VideoProtected']=='Y') {
					$usrArr[$profresult['MatriId']]['video'] = "Y";
				} 
				else {
					$usrArr[$profresult['MatriId']]['video'] = "Y";
				}
			} 
			else {
				$usrArr[$profresult['MatriId']]['video'] = "N";
			}

			//phone verified
			if($profresult['PhoneVerified']==1) {
				$usrArr[$profresult['MatriId']]['phone'] = "Y";
			}
			else {
				$usrArr[$profresult['MatriId']]['phone'] = "N";
			}
			
			//Voice
			if($profresult['VoiceAvailable']==1) {
				$usrArr[$profresult['MatriId']]['voice'] = "Y";
			}
			else {
				$usrArr[$profresult['MatriId']]['voice'] = "N";
			}
			
			//Reference
			if($profresult['ReferenceAvailable']==1) {
				$usrArr[$profresult['MatriId']]['reference'] = "Y";
			}
			else {
				$usrArr[$profresult['MatriId']]['reference'] = "N";
			}

			//Verification
			if(($profresult['ProfileVerified']==1) || ($profresult['ProfileVerified']==4) || ($profresult['ProfileVerified']==6) || ($profresult['ProfileVerified']==9) || ($profresult['ProfileVerified']==5) || ($profresult['ProfileVerified']==6) || ($profresult['ProfileVerified']==8)) {
				$usrArr[$profresult['MatriId']]['verification'] = "Y";
			}
			else {
				$usrArr[$profresult['MatriId']]['verification'] = "N";
			}

			$usrArr[$profresult['MatriId']]['LastAction'] = "N"; //set default
			
			// Profile notes checking //
			if($memberid!="" && $profresult['Gender']!=$gender) {
				$icon_row = lastAction($memberid,$matriid,$dbslave);
				// Bookmark Icon Checking //
				if ($icon_row['Bookmarked'] == 1) {
					$usrArr[$profresult['MatriId']]['BookmarkedId'] = "Y";
				} 
				else {
					$usrArr[$profresult['MatriId']]['BookmarkedId'] = "N";
				}
				// Blocked Icon Checking //
				if ($icon_row['Blocked'] == 1) {
					$usrArr[$profresult['MatriId']]['BlockedId'] = "Y";
				}
				else {
					$usrArr[$profresult['MatriId']]['BlockedId'] = "N";
				}
				// Ignore Icon Checking //
				if ($icon_row['Ignored'] == 1) {
					$usrArr[$profresult['MatriId']]['IgnoredId'] = "Y";
				} 
				else {
					$usrArr[$profresult['MatriId']]['IgnoredId'] = "N";
				}

				// Last Action //
				if ($icon_row['IntRec'] == 'Y') {
					$usrArr[$profresult['MatriId']]['LastAction'] = "IR";
				} 
				elseif ($icon_row['IntSen'] == 'Y') {
					$usrArr[$profresult['MatriId']]['LastAction'] = "IS";
				} 
				elseif ($icon_row['MsgSen'] == 'Y') {
					$usrArr[$profresult['MatriId']]['LastAction'] = "MS";
				} 
				elseif ($icon_row['MsgRec'] == 'Y') {
					$usrArr[$profresult['MatriId']]['LastAction'] = "MR";
				} 
				elseif ($icon_row['MsgRep'] == 'Y') {
					$usrArr[$profresult['MatriId']]['LastAction'] = "MP";
				} 
				elseif($icon_row['MsgDec'] == 'Y') {
					$usrArr[$profresult['MatriId']]['LastAction'] = "MD";
				} 
				else {
					$usrArr[$profresult['MatriId']]['LastAction'] = "N";
				}
			}
			// Member online status checking //
			if($_REQUEST['SEARCH_TYPE']!='WHOS_ONLINE') {
				$online_filepath = "/home/bharat/messenger/$matriid.txt";
				if (file_exists($online_filepath)) {
					$usrArr[$profresult['MatriId']]['online'] = 'Y';
				} else {
					$usrArr[$profresult['MatriId']]['online'] = 'N';
				}
			} 
			else {
				$usrArr[$profresult['MatriId']]['online'] = 'Y'; // Set as online here for DB3 Connection ( MembersOnline and Who's Online )
			}
		}
	} 
	else { // If no record exists for given matri id 
		$sqlstat1 = "select MatriId,Status from  ".$proftable." where MatriId in ('$matriid') and Validated=1 and Authorized=1 and Status=1";
		$num_sql1 = $dbslave->select($sqlstat1);
		if($num_sql1>0) {
			$usrArr[$profresult['MatriId']] = "1"; // To say given matriid is hidden status
		} else {
			$usrArr[$profresult['MatriId']] = "0";  // To say given matriid is suspended or deleted status
		}
	}
	return $usrArr; // Result resource return here
}

?>