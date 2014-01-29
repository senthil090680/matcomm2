<?php
/****************************************************************************************************
File		: loadsummary.php
Author		: Jeyakumar N
*****************************************************************************************************
Description	: Display MatchSummary on the Home Page
******************************************************************************************************/
//error_reporting(E_ALL);
//ini_set("display_errors","1");

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/ip.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/conf/domainlist.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath."/lib/sphinxapi.php"); 
include_once($varRootBasePath.'/lib/clsCache.php');
include_once($varRootBasePath."/conf/sphinxclass.cil14");
include_once($varRootBasePath."/conf/sphinxgenericfunction.cil14");
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varRootBasePath."/www/matchsummary/getpartnerdtls.php");

//Object Decleration
$objSrchBasicView = new DB();
$objMasterDB	= new DB();

//DB Connection
$objSrchBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);


function makecomma($input) {
   // This function is written by some anonymous person - I got it from Google
   if(strlen($input)<=2)
   { return $input; }
   $length=substr($input,0,strlen($input)-2);
   $formatted_input = makecomma($length).",".substr($input,-2);
   return $formatted_input;
}

function formatInIndianStyle($num) {
   // This is my function
   $pos = strpos((string)$num, ".");
   if ($pos === false) { $decimalpart="00";}
   else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

   if(strlen($num)>3 & strlen($num) <= 12){
               $last3digits = substr($num, -3 );
               $numexceptlastdigits = substr($num, 0, -3 );
               $formatted = makecomma($numexceptlastdigits);
               $stringtoreturn = $formatted.",".$last3digits ;
   }elseif(strlen($num)<=3){
               $stringtoreturn = $num ;
   }elseif(strlen($num)>12){
               $stringtoreturn = number_format($num, 0);
   }

   if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}

   return $stringtoreturn;
}

if($sessMatriId==''){
	echo $displaythisonscreen="<br>You are either logged off or your session is timed out. <a href=".$confValues['SERVERURL']."/login/login.php class=\"linktxt\"> Click here</a> to login.<br><br>";
	exit;
}

//Yet to be viewed
//get preferred count for Yet to be viewed
if($varGetCookieInfo['PARTNERSTATUS']==0) {
	$arrProfileOutput['yettobeviewed']['preferred']	= 0;
	$arrProfileOutput['viewednotcontacted']['preferred'] = 0;
} else {
	$_POST["excludefields"]	= '';
	$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,1, '', '');
	$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,1, '', '');
	$arrProfileOutput['yettobeviewed']['preferred']		= $arrYetToBeViewed['totalcnt'];
	$arrProfileOutput['viewednotcontacted']['preferred']= $arrViewedAndNotContacted['totalcnt'];
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
		$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,1, '', '');
		$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,1, '', '');
		$arrProfileOutput['yettobeviewed']['matchwatch'] = $arrYetToBeViewed['totalcnt'];
		$arrProfileOutput['viewednotcontacted']['matchwatch']= $arrViewedAndNotContacted['totalcnt'];
	}

} else {
	$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,1, '', '');
	$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,1, '', '');
	$arrProfileOutput['yettobeviewed']['matchwatch'] = $arrYetToBeViewed['totalcnt'];
	$arrProfileOutput['viewednotcontacted']['matchwatch']= $arrViewedAndNotContacted['totalcnt'];
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
			$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,1, '', '');
			$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,1, '', '');
			$arrProfileOutput['yettobeviewed']['recommended'] = $arrYetToBeViewed['totalcnt'];
			$arrProfileOutput['viewednotcontacted']['recommended']= $arrViewedAndNotContacted['totalcnt'];
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
		$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,1, '', '');
		$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,1, '', '');
		$arrProfileOutput['yettobeviewed']['recommended'] = $arrYetToBeViewed['totalcnt'];
		$arrProfileOutput['viewednotcontacted']['recommended']= $arrViewedAndNotContacted['totalcnt'];
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

$arrProfileOutput['total_yettobeviewed']			= $arrProfileOutput['yettobeviewed']['preferred'] + $arrProfileOutput['yettobeviewed']['recommended'] + $arrProfileOutput['yettobeviewed']['matchwatch'];

$arrProfileOutput['total_viewednotcontacted']			= $arrProfileOutput['viewednotcontacted']['preferred'] + $arrProfileOutput['viewednotcontacted']['recommended'] + $arrProfileOutput['viewednotcontacted']['matchwatch'];

$profiletotalcount	= $arrProfileOutput['total_viewednotcontacted'] + $arrProfileOutput['total_yettobeviewed'];

$varMSTotalDisplayKey	= 'MS_total_display_'.$sessMatriId;

Cache::setData($varMSTotalDisplayKey,$arrProfileOutput,0,39600);

if($profiletotalcount >0){
	if($arrProfileOutput['yettobeviewed']['preferred'] > 0){
		$yettobeviewedurl = $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=1&req=1&randid=".rand();
	}
	else if($arrProfileOutput['yettobeviewed']['recommended'] > 0){
		$yettobeviewedurl = $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=1&req=2&randid=".rand();	
	}
	else if($arrProfileOutput['yettobeviewed']['matchwatch'] > 0){
		$yettobeviewedurl = $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=1&req=3&randid=".rand();	
	}




	if($arrProfileOutput['viewednotcontacted']['preferred'] > 0){
		$viewednotcontactedurl = $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=1&randid=".rand();
	}
	else if($arrProfileOutput['viewednotcontacted']['recommended'] > 0){
		$viewednotcontactedurl = $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=2&randid=".rand();	
	}
	else if($arrProfileOutput['viewednotcontacted']['matchwatch'] > 0){
		$viewednotcontactedurl = $confValues['SERVERURL']."/matchsummary/index.php?act=msummaryshowall&viewtype=2&req=3&randid=".rand();	
	}
	?>
	<div class="clr bld normtxt">Matching Profiles</div>
	<div class="dotsep2 mymgnt10"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="normtxt" style="padding-top:10px;">
	<div style="height:22px;width:278px;padding-top:2px;" class="fleft normtxt"><font class="bld myclr fntsize"><?=formatInIndianStyle($arrProfileOutput['total_yettobeviewed']);?></font>&nbsp;&nbsp;Yet to be viewed
	<? if($arrProfileOutput['total_yettobeviewed'] > 0){?> - <a href="<?=$yettobeviewedurl?>" class="normtxt clr1">View Now</a><?}?></div>
	<div style="width:18px;height:20px;" class="fleft versep">&nbsp;</div>
	<div class="fleft normtxt" style="padding-top:2px;"><font class="bld myclr fntsize"><?=formatInIndianStyle($arrProfileOutput['total_viewednotcontacted']);?></font>&nbsp;&nbsp;Viewed & not contacted
	<? if($arrProfileOutput['total_viewednotcontacted'] > 0){?> - <a href="<?=$viewednotcontactedurl?>" class="normtxt clr1">Contact Now</a><?}?></div>
	</div>
	<div class="dotsep2 mymgnt10 fleft" style="width:560px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<? unset($objMasterDB);
} else{
	echo "";
}?>