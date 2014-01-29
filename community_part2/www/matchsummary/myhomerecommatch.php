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
include_once($varRootBasePath.'/lib/clsSrchBasicView.php');
include_once($varRootBasePath."/www/matchsummary/getpartnerdtls.php");

//Object Decleration
$objSrchBasicView	= new SrchBasicView();
$objMasterDB		= new SrchBasicView();

//DB Connection
$objSrchBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

if($sessMatriId==''){
	echo $displaythisonscreen="<br>You are either logged off or your session is timed out. <a href=".$confValues['SERVERURL']."/login/login.php class=\"linktxt\"> Click here</a> to login.<br><br>";
	exit;
}

$_POST["photoOpt"]=1; // for photo enabled ids
$_POST["protectphotoOpt"]=1; // for protect photo

//get recommended count for Yet to be viewed
if($varGetCookieInfo['PARTNERSTATUS']==1) {
	$arrReturn1	= getExcludeFields($arrTotalFields,$arrMatchwatchExludeFields);
	$arrReturn2	= getExcludeFields($arrTotalFields,$arrRecommendedExcludeFields);

	if(count($arrReturn1)==0 && count($arrReturn2)==0) {
		$arrYetToBeViewed['totalcnt'] = 0;
		$arrViewedAndNotContacted['totalcnt'] = 0;
	} else {
		$arrResult = array_diff($arrReturn2, $arrReturn1);
		if(count($arrResult)==0) {
			$arrYetToBeViewed['totalcnt'] = 0;
			$arrViewedAndNotContacted['totalcnt'] = 0;
		} else {
			$arrExludeFields	= $arrResult;
			$varExludeFields	= implode("|",$arrExludeFields);
			$_POST["excludefields"]	= $varExludeFields;
			$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,2, '', '');
			$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,2, '', '');
		}
	}

} else {
	$arrReturn1	= getExcludeFields($arrTotalFields,$arrRecommendedExcludeFields);

	if(count($arrReturn1)==0) {
		$arrYetToBeViewed['totalcnt'] = 0;
		$arrViewedAndNotContacted['totalcnt'] = 0;
	} else {
		$arrExludeFields	= $arrReturn1;
		$varExludeFields	= implode("|",$arrExludeFields);
		$_POST["excludefields"]	= $varExludeFields;
		$arrYetToBeViewed		= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,2, '', '');
		$arrViewedAndNotContacted= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,2, '', '');
	}
}

//print_r($arrYetToBeViewed);
//print_r($arrViewedAndNotContacted);exit;
//$varRecomProfileTotalCount	= $arrYetToBeViewed['totalcnt'] + $arrViewedAndNotContacted['totalcnt'];


$arrGetCount = null;
$varMSTotalDisplayKey	= 'MS_total_display_'.$sessMatriId;
$arrGetCount = Cache::getData($varMSTotalDisplayKey);

$varRecomProfileTotalCount	= $arrGetCount['yettobeviewed']['recommended'] + $arrGetCount['viewednotcontacted']['recommended'];
if($varRecomProfileTotalCount >3){
	if($arrYetToBeViewed['totalcnt']>0) {
		$arrCommonMatch = $arrYetToBeViewed;
	} else if($arrViewedAndNotContacted['totalcnt']>0) {
		$arrCommonMatch = $arrViewedAndNotContacted;
	}
//print_r($arrCommonMatch);
	if ($arrCommonMatch['totalcnt']<4) {
		return '';
	}
	?>
	<div style="width:550px;float:left;height:20px;">&nbsp;</div>
	<div style="width:550px;border:1px solid #CBCBCB;float:left;height:250px;">
		<div class="mymgnt10">
			<div style="width:525px;float:left;">
			 <div class="fleft bld" style="margin-left:25px;display:inline;">Recommended Matches</div>
			<div class="fright smalltxt">Not matching? <a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=partnerinfodesc" class="clr1 smalltxt">Edit Partner Preference</a></div>
			</div>
			<div style="height:10px !important;height:10px;width:500px;float:left;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
             <div style="width:550px;float:left;">
				<div align="center" class="fleft" style="width:25px;margin-top:60px;">&nbsp;</div>
                <div style="width:499px;float:left;border:1px solid #CBCBCB;padding-bottom:5px;height:180px;">
                    <div class="mymgnt10" style="margin-left:20px;">
						<? foreach ( $arrCommonMatch['ids'] as $doc => $docinfo ) {
						$varMatriId = $arrCommonMatch['ids'][$doc]['MatriId'];
						$varAge = $arrCommonMatch['ids'][$doc]['Age'];

						$varHeightId = $objSrchBasicView->getHeightInFeet($arrCommonMatch['ids'][$doc]['Height']);
						$varHeight = str_replace("cm"," Cms",$varHeightId);

						$varCountryId = $arrCommonMatch['ids'][$doc]['Country'];
						if($varCountryId==98) {
							$varStateId = $arrCommonMatch['ids'][$doc]['Residing_State'];
							$varLocStr = ucfirst($residingCityStateMappingList[$varStateId]);
						} else {
							$varLocStr = ucfirst($arrCountryList[$varCountryId]);
						}

						//get photo name
						$argFields		= array('Normal_Photo1');
						//$argCondition	= "WHERE MatriId='".$varMatriId."'";
						$argCondition	= "WHERE MatriId=".$objSrchBasicView->doEscapeString($varMatriId,$objSrchBasicView);
						$varPhotoResSet	= $objSrchBasicView->select($varTable['MEMBERPHOTOINFO'],$argFields,$argCondition,0);
						$varPhotoRes	= mysql_fetch_assoc($varPhotoResSet);
						$varPhotoName	= $varPhotoRes["Normal_Photo1"];
						?>
						<div style="width:119px;float:left;">
							<div align="center" style="width:100px;">
								<div align="center"><img src="<?=$confValues['PHOTOURL']?>/<?=$varMatriId{3}?>/<?=$varMatriId{4}?>/<?=$varPhotoName?>" width="75" height="75" style="border:0px;"/></div>
								<div class="bld smalltxt"><?=$varMatriId?></div>
								<div class="smalltxt"><?=$varAge?> yrs, </div>
								<div class="smalltxt"><?=$varHeight?>, </div>
								<div class="smalltxt"><?=$varLocStr?></div>
								<div class="smalltxt"><a href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=fullprofilenew&id=<?=$varMatriId?>" class="clr1">Full Profile >></a></div>
							</div>
						</div>
						<?}?>
					</div>
				</div>

			</div>

			<div style="width:525px;float:left;margin-top:5px;">
			 <div class="fleft smalltxt" style="margin-left:25px;display:inline;">To send an e-mail, chat or call these matches,<a href="/payment/" class="clr1"> become a Premium Member.</a></div>
			<div class="fright smalltxt"><!--<a href="#" class="clr1 smalltxt">More >></a>--></div>
			</div>
		</div>
	</div>
<? unset($objSrchBasicView);
unset($objMasterDB);
} else {
	echo "";
}?>