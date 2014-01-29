<?
include_once($varServerRoot.'/matchsummary/msummarytools.php');
$varCountDisplayKey	= 'MS_total_display_'.$sessMatriId;
$varProfileType	= $_REQUEST['req'];
$varViewType	= $_REQUEST['viewtype'];

if($_POST["wc"]==''){
	$varPurpose = 1;

	//Yet to be viewed
	//get preferred count for Yet to be viewed
	if($varGetCookieInfo['PARTNERSTATUS']==0) {
		$arrProfileOutput['yettobeviewed']['preferred']	= 0;
		$arrProfileOutput['viewednotcontacted']['preferred'] = 0;
	} else {
		$_POST["excludefields"]	= '';
		if($varViewType==1) {
		$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
		$arrProfileOutput['yettobeviewed']['preferred']		= $arrYetToBeViewed['totalcnt'];
		} else if($varViewType==2) {
		$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
		$arrProfileOutput['viewednotcontacted']['preferred']= $arrViewedAndNotContacted['totalcnt'];

		//get tools count
		$arrPrefToolsAdded = selectalltoolscount($sessMatriId,1,$varDomainId); //preferred

		//echo 'preferred ';
		$addedToolsKey	= 'MSPrefToolsAdded_'.$sessMatriId;
		Cache::setData($addedToolsKey, $arrPrefToolsAdded);

		$arrPrefToolsCount = Cache::getData($addedToolsKey);
		//print_r(Cache::getData($addedToolsKey));
		//echo '<BR>';

		$varPrefAddedPhotoCnt	= $arrPrefToolsCount['photo'][0];
		$varPrefAddedPhoneCnt	= $arrPrefToolsCount['phone'][0];
		$varPrefAddedHoroscopeCnt= $arrPrefToolsCount['horoscope'][0];
		}
	}

	//get matchwatch count for Yet to be viewed
	if($varGetCookieInfo['PARTNERSTATUS']==1) {
		$arrExludeFields	= getExcludeFields($arrTotalFields,$arrMatchwatchExludeFields);

		if(count($arrExludeFields)==0) {
			$arrProfileOutput['yettobeviewed']['matchwatch'] = 0;
			$arrProfileOutput['viewednotcontacted']['matchwatch'] = 0;
		} else {
			$varExludeFields	= implode("|",$arrExludeFields);
			$_POST["excludefields"]	= $varExludeFields;

			if($varViewType==1) {
			$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
			$arrProfileOutput['yettobeviewed']['matchwatch'] = $arrYetToBeViewed['totalcnt'];
			} else if($varViewType==2) {
			$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
			$arrProfileOutput['viewednotcontacted']['matchwatch']= $arrViewedAndNotContacted['totalcnt'];

			//get tools count
			$arrMatchToolsAdded = selectalltoolscount($sessMatriId,1,$varDomainId); //matchwatch

			//echo 'matchwatch ';
			$addedToolsKey	= 'MSMatchToolsAdded_'.$sessMatriId;
			Cache::setData($addedToolsKey, $arrMatchToolsAdded);
			$arrMatchToolsCount = Cache::getData($addedToolsKey);
			//print_r(Cache::getData($addedToolsKey));
			//echo '<BR>';

			$varMatchAddedPhotoCnt	= $arrMatchToolsCount['photo'][0];
			$varMatchAddedPhoneCnt	= $arrMatchToolsCount['phone'][0];
			$varMatchAddedHoroscopeCnt= $arrMatchToolsCount['horoscope'][0];
			}
		}

	} else {
		if($varViewType==1) {
		$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
		$arrProfileOutput['yettobeviewed']['matchwatch'] = $arrYetToBeViewed['totalcnt'];
		} else if($varViewType==2) {
		$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
		$arrProfileOutput['viewednotcontacted']['matchwatch']= $arrViewedAndNotContacted['totalcnt'];

		//get tools count
		$arrMatchToolsAdded = selectalltoolscount($sessMatriId,1,$varDomainId); //matchwatch

		//echo 'matchwatch ';
		$addedToolsKey	= 'MSMatchToolsAdded_'.$sessMatriId;
		Cache::setData($addedToolsKey, $arrMatchToolsAdded);
		$arrMatchToolsCount = Cache::getData($addedToolsKey);
		//print_r(Cache::getData($addedToolsKey));
		//echo '<BR>';

		$varMatchAddedPhotoCnt	= $arrMatchToolsCount['photo'][0];
		$varMatchAddedPhoneCnt	= $arrMatchToolsCount['phone'][0];
		$varMatchAddedHoroscopeCnt= $arrMatchToolsCount['horoscope'][0];
		}
	}

	//get recommended count for Yet to be viewed
	if($varGetCookieInfo['PARTNERSTATUS']==1) {
		$arrReturn1	= getExcludeFields($arrTotalFields,$arrMatchwatchExludeFields);
		$arrReturn2	= getExcludeFields($arrTotalFields,$arrRecommendedExcludeFields);

		if(count($arrReturn1)==0 && count($arrReturn2)==0) {
			$arrProfileOutput['yettobeviewed']['recommended'] = 0;
			$arrProfileOutput['viewednotcontacted']['recommended'] = 0;
		} else {
			$arrResult = array_diff($arrReturn2, $arrReturn1);

			if(count($arrResult)==0) {
				$arrProfileOutput['yettobeviewed']['recommended'] = 0;
				$arrProfileOutput['viewednotcontacted']['recommended'] = 0;
			} else {
				$arrExludeFields	= $arrResult;
				$varExludeFields	= implode("|",$arrExludeFields);
				$_POST["excludefields"]	= $varExludeFields;

				if($varViewType==1) {
				$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
				$arrProfileOutput['yettobeviewed']['recommended'] = $arrYetToBeViewed['totalcnt'];
				} else if($varViewType==2) {
				$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
				$arrProfileOutput['viewednotcontacted']['recommended']= $arrViewedAndNotContacted['totalcnt'];

				//get tools count
				$arrRecomToolsAdded = selectalltoolscount($sessMatriId,1,$varDomainId); //recommended

				//echo 'recommended ';
				$addedToolsKey	= 'MSRecomToolsAdded_'.$sessMatriId;
				Cache::setData($addedToolsKey, $arrRecomToolsAdded);
				$arrRecomToolsCount = Cache::getData($addedToolsKey);
				//print_r(Cache::getData($addedToolsKey));
				//echo '<BR>';

				$varRecomAddedPhotoCnt	= $arrRecomToolsCount['photo'][0];
				$varRecomAddedPhoneCnt	= $arrRecomToolsCount['phone'][0];
				$varRecomAddedHoroscopeCnt= $arrRecomToolsCount['horoscope'][0];
				}
			}
		}

	} else {
		$arrReturn1	= getExcludeFields($arrTotalFields,$arrRecommendedExcludeFields);

		if(count($arrReturn1)==0) {
			$arrProfileOutput['yettobeviewed']['recommended'] = 0;
			$arrProfileOutput['viewednotcontacted']['recommended'] = 0;
		} else {
			$arrExludeFields	= $arrReturn1;
			$varExludeFields	= implode("|",$arrExludeFields);
			$_POST["excludefields"]	= $varExludeFields;

			if($varViewType==1) {
			$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
			$arrProfileOutput['yettobeviewed']['recommended'] = $arrYetToBeViewed['totalcnt'];
			} else if($varViewType==2) {
			$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,$varViewType,$varPurpose, '', '');
			$arrProfileOutput['viewednotcontacted']['recommended']= $arrViewedAndNotContacted['totalcnt'];

			//get tools count
			$arrRecomToolsAdded = selectalltoolscount($sessMatriId,1,$varDomainId); //recommended

			//echo 'recommended ';
			$addedToolsKey	= 'MSRecomToolsAdded_'.$sessMatriId;
			Cache::setData($addedToolsKey, $arrRecomToolsAdded);
			$arrRecomToolsCount = Cache::getData($addedToolsKey);
			//print_r(Cache::getData($addedToolsKey));
			//echo '<BR>';

		
			$varRecomAddedPhotoCnt	= $arrRecomToolsCount['photo'][0];
			$varRecomAddedPhoneCnt	= $arrRecomToolsCount['phone'][0];
			$varRecomAddedHoroscopeCnt= $arrRecomToolsCount['horoscope'][0];
			}
		}
	}

	//Count checking
	if($varGetCookieInfo['PARTNERSTATUS']==1) {
		//yet to be viewed
		if($arrProfileOutput['yettobeviewed']['preferred']==$arrProfileOutput['yettobeviewed']['recommended'] || $arrProfileOutput['yettobeviewed']['preferred']==$arrProfileOutput['yettobeviewed']['matchwatch']) {
			$arrProfileOutput['yettobeviewed']['recommended']	= 0;
			$arrProfileOutput['yettobeviewed']['matchwatch']	= 0;
		}
		if($arrProfileOutput['yettobeviewed']['matchwatch']==$arrProfileOutput['yettobeviewed']['recommended']) {
			$arrProfileOutput['yettobeviewed']['recommended']	= 0;
		}

		//viewed not contacted
		if($arrProfileOutput['viewednotcontacted']['preferred']==$arrProfileOutput['viewednotcontacted']['recommended'] || $arrProfileOutput['viewednotcontacted']['preferred']==$arrProfileOutput['viewednotcontacted']['matchwatch']) {
			$arrProfileOutput['viewednotcontacted']['recommended']	= 0;
			$arrProfileOutput['viewednotcontacted']['matchwatch']	= 0;
		}
		if($arrProfileOutput['viewednotcontacted']['matchwatch']==$arrProfileOutput['viewednotcontacted']['recommended']) {
			$arrProfileOutput['viewednotcontacted']['recommended']	= 0;
		}
	} else {
		//yet to be viewed
		if($arrProfileOutput['yettobeviewed']['matchwatch']==$arrProfileOutput['yettobeviewed']['recommended']) {
			$arrProfileOutput['yettobeviewed']['recommended']	= 0;
		}

		//viewed not contacted
		if($arrProfileOutput['viewednotcontacted']['matchwatch']==$arrProfileOutput['viewednotcontacted']['recommended']) {
			$arrProfileOutput['viewednotcontacted']['recommended']	= 0;
		}
	}

	Cache::setData($varCountDisplayKey,$arrProfileOutput,0,39600);
}

$arrProfileOutputOnly = Cache::getData($varCountDisplayKey);

if($varViewType==1) {
	$varPreferredCount		= $arrProfileOutputOnly['yettobeviewed']['preferred'];
	$varRecommendedCount	= $arrProfileOutputOnly['yettobeviewed']['recommended'];
	$varMatchwatchCount		= $arrProfileOutputOnly['yettobeviewed']['matchwatch'];
	$preferredmatchurl		= $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=1&req=1&randid=".rand();
	$recommendedmatchurl	= $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=1&req=2&randid=".rand();
	$matchwatchurl			= $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=1&req=3&randid=".rand();
} else if($varViewType==2) {
	$varPreferredCount		= $arrProfileOutputOnly['viewednotcontacted']['preferred'];
	$varRecommendedCount	= $arrProfileOutputOnly['viewednotcontacted']['recommended'];
	$varMatchwatchCount		= $arrProfileOutputOnly['viewednotcontacted']['matchwatch'];
	$preferredmatchurl		= $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=1&randid=".rand();
	$recommendedmatchurl	= $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=2&randid=".rand();
	$matchwatchurl			= $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=3&randid=".rand();
}

$varTotalCount	= $varPreferredCount + $varRecommendedCount + $varMatchwatchCount;

if($varProfileType==1) {
	$varPreClass = 'fleft prf-act';
	$varPreClrClass	= 'clr5';

	$varAddedPhotoCnt	= ($varPrefAddedPhotoCnt>0)?'<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=1&vat=p&randid='.rand().'">Photo Added&nbsp;('.$varPrefAddedPhotoCnt.')</a>':'';

	$varPhoneAddedContent = '<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=1&vat=pn&randid='.rand().'">Phone Added&nbsp;('.$varPrefAddedPhoneCnt.')</a>';
	$varAddedPhoneCnt	= ($varPrefAddedPhoneCnt>0)?(($varPrefAddedPhotoCnt>0)?'&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;'.$varPhoneAddedContent:$varPhoneAddedContent):'';
	
	$varHoroscopeAddedContent = '<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=1&vat=h&randid='.rand().'">Horoscope Added&nbsp;('.$varPrefAddedHoroscopeCnt.')</a>';
	$varAddedHoroscopeCnt= ($varPrefAddedHoroscopeCnt>0)?(($varPrefAddedPhotoCnt>0 || $varPrefAddedPhoneCnt>0)?'&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;'.$varHoroscopeAddedContent:$varHoroscopeAddedContent):'';

	$varTabMessage	= 'Listed here are profiles that exactly match your <a class="clr1" href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=partnerinfodesc">Partner Preference</a>. These profiles are tagged as "Preferred Matches".';

} else {
	$varPreClass = 'fleft prf-noact';
	$varPreClrClass	= 'clr1';
}

if($varProfileType==2) {
	$varRecomClass = 'fleft prf-act';
	$varRecomClrClass	= 'clr5';

	$varAddedPhotoCnt	= ($varRecomAddedPhotoCnt>0)?'<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=2&vat=p&randid='.rand().'">Photo Added&nbsp;('.$varRecomAddedPhotoCnt.')</a>':'';

	$varPhoneAddedContent = '<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=2&vat=pn&randid='.rand().'">Phone Added&nbsp;('.$varRecomAddedPhoneCnt.')</a>';
	$varAddedPhoneCnt	= ($varRecomAddedPhoneCnt>0)?(($varRecomAddedPhotoCnt>0)?'&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;'.$varPhoneAddedContent:$varPhoneAddedContent):'';
	
	$varHoroscopeAddedContent = '<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=2&vat=h&randid='.rand().'">Horoscope Added&nbsp;('.$varRecomAddedHoroscopeCnt.')</a>';
	$varAddedHoroscopeCnt= ($varRecomAddedHoroscopeCnt>0)?(($varRecomAddedPhotoCnt>0 || $varRecomAddedPhoneCnt>0)?'&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;'.$varHoroscopeAddedContent:$varHoroscopeAddedContent):'';

	$varTabMessage	= 'Listed here are additional profiles recommended by us which is apart from your Preferred Matches & MatchWatch Profiles.';

} else {
	$varRecomClass = 'fleft prf-noact';
	$varRecomClrClass	= 'clr1';
}

if($varProfileType==3) {
	$varMatchwatchClass = 'fleft prf-act';
	$varMatchwatchClrClass	= 'clr5';

	$varAddedPhotoCnt	= ($varMatchAddedPhotoCnt>0)?'<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=3&vat=p&randid='.rand().'">Photo Added&nbsp;('.$varMatchAddedPhotoCnt.')</a>':'';

	$varPhoneAddedContent = '<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=3&vat=pn&randid='.rand().'">Phone Added&nbsp;('.$varMatchAddedPhoneCnt.')</a>';
	$varAddedPhoneCnt	= ($varMatchAddedPhoneCnt>0)?(($varMatchAddedPhotoCnt>0)?'&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;'.$varPhoneAddedContent:$varPhoneAddedContent):'';
	
	$varHoroscopeAddedContent = '<a class="clr1" href="http://www.muslimmatrimony.com/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=3&vat=h&randid='.rand().'">Horoscope Added&nbsp;('.$varMatchAddedHoroscopeCnt.')</a>';
	$varAddedHoroscopeCnt= ($varMatchAddedHoroscopeCnt>0)?(($varMatchAddedPhotoCnt>0 || $varMatchAddedPhoneCnt>0)?'&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;'.$varHoroscopeAddedContent:$varHoroscopeAddedContent):'';

	$varTabMessage	= 'Listed here are profiles based on your <a class="clr1" href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=partnerinfodesc">MatchWatch criteria</a> which is apart from your Preferred Matches.';

} else {
	$varMatchwatchClass = 'fleft prf-noact';
	$varMatchwatchClrClass	= 'clr1';
}
?>

<div class="wdth560 fleft">
	<div class="wdth560 fleft padbt10">
		<div class="fleft bld fnt17">
			<?if($varViewType==1) {?>Profiles yet to be viewed (<?=$varTotalCount?>)<?} elseif($varViewType==2) {?>Profiles viewed & not contacted (<?=$varTotalCount?>)<?}?>
		</div>
		<div class="fright"><a href="../profiledetail/" class="smalltxt clr1"><< Back to My Home</a></div>
	</div>
	<div class="wdth560 fleft">
		<div class="<?=$varPreClass?>">
			<center>
				<?if($varPreferredCount>0) {?>
					<a href="<?=$preferredmatchurl?>"><div class="<?=$varPreClrClass?> normtxt pdt8">Preferred Matches<br /><font class="clr">(<?=$varPreferredCount?>)</font></div></a>
				<?} else {?>
					<div class="clr normtxt pdt8">Preferred Matches<br /><font class="clr">(<?=$varPreferredCount?>)</font></div>
				<?}?>
			</center>
		</div>
		<div class="fleft" style="width:10px;">&nbsp;</div>
		<div class="<?=$varMatchwatchClass?>">
			<center>
				<?if($varMatchwatchCount>0) {?>
					<a href="<?=$matchwatchurl?>"><div class="<?=$varMatchwatchClrClass?> normtxt pdt8">MatchWatch Profiles <br /><font class="clr">(<?=$varMatchwatchCount?>)</font></div></a>
				<?} else {?>
					<div class="clr normtxt pdt8">MatchWatch Profiles <br /><font class="clr">(<?=$varMatchwatchCount?>)</font></div>
				<?}?>
			</center>
		</div>
		<div class="fleft" style="width:10px;">&nbsp;</div>
		<div class="<?=$varRecomClass?>">
			<center>
				<?if($varRecommendedCount>0) {?>
					<a href="<?=$recommendedmatchurl?>"><div class="<?=$varRecomClrClass?> normtxt pdt8">Recommended Matches <br /><font class="clr">(<?=$varRecommendedCount?>)</font></div></a>
				<?} else {?>
					<div class="clr normtxt pdt8">Recommended Matches <br /><font class="clr">(<?=$varRecommendedCount?>)</font></div>
				<?}?>
			</center>
		</div>
	</div>
	<?if($varViewType==2) {?>
	 <div class="wdth560 fleft" style="padding-top:2px;">
		<div class="fleft clr smalltxt">
			<?//$varAddedPhotoCnt?>
			<?//$varAddedHoroscopeCnt?>
			<?//$varAddedPhoneCnt?>
		</div>
	</div>
	<?}?>
	<div class="wdth560 fleft smalltxt" style="padding-top:10px;">
		<?=$varTabMessage?>
	</div>
	<div class="mymgnt10 dotsep2 wdth560 fleft"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" /></div>

	<div id="feaResArea">
	</div>

	<?if($varTotalCount>0){?>
	<div class="clr wdth560">
		<div class="wdth560 fleft smalltxt padtb5">
			<div class="smalltxt clr fleft" id="srtopbt">
				<div class="fleft">Select:&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="mult_chk(document.buttonfrm);" class="clr1">All</a>&nbsp;&nbsp;<font class="clr">|</font>&nbsp;&nbsp;<a href="javascript:;" onclick="mult_unchk(document.buttonfrm);" class="clr1">None</a></div>
			</div>
			<div id="actionpartdiv" class="fright">
				<div class="clr fleft">Action:&nbsp;&nbsp;<a onclick="sendListId('block','chk_all');" class="clr1">Block</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="sendListId('shortlist','chk_all');" class="clr1">Add To Favourites</a></div><div id="conall" class="fleft disblk" style="width:64px;">&nbsp;|&nbsp;&nbsp;<a onclick="chkMsgSelIds();" class="clr1">Contact All</a></div>
				
				<div id="conall1" class="fleft disnon" style="width:64px;">&nbsp;<font class="clr">|</font>&nbsp;&nbsp;<a class="clr5" onclick="showdiv('contalldiv');stylechange(0);">Contact All</a></div>
			</div>
		</div>
	</div>
	<div class="dotsep2 wdth560 fleft mymgnb10"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" /></div>
	<?}?>
	<div class="cleard"></div>
	<!-- Error throw div -->
	<center><div id="listalldiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
	</div></center><div class="cleard"></div>
	<!-- Error throw div -->
</div>
