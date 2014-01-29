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
include_once($varRootBasePath."/www/matchsummary/getfpcond.php");

//Object Decleration
$objSrchBasicView	= new SrchBasicView();
$objMasterDB		= new SrchBasicView();

//DB Connection
$objSrchBasicView->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);


$arrFPDetailResult	= getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,1,2, '', 'fp');

if($arrFPDetailResult['fptotalcnt']>0){
	?>
	<div class="fright wdth192" style="display:inline">
		<div style="background:url(<?=$confValues['IMGSURL']?>/fp_bg_rp.gif) no-repeat;height:45px;width:192px;"></div>
		<div class="padtb10" style="background-color:#4DC8F1;">
			<center>
			<div style="background-color:#D1F0FA;width:164px;padding-bottom:10px;">
				<? foreach ( $arrFPDetailResult['fpids'] as $doc => $docinfo ) {
						$varMatriId = $arrFPDetailResult['fpids'][$doc]['MatriId'];
						$varAge = $arrFPDetailResult['fpids'][$doc]['Age'];

						$varHeightId = $objSrchBasicView->getHeightInFeet($arrFPDetailResult['fpids'][$doc]['Height']);
						//$varHeight = str_replace("cm"," Cms",$varHeightId);
						
						$varCasteName	 = $arrCasteList[$arrFPDetailResult['fpids'][$doc]['CasteId']];
						$varEducationDet = $arrEducationDisplay[$arrFPDetailResult['fpids'][$doc]['Education_Category']];

						//get photo name
						$argFields		= array('Thumb_Small_Photo1');
						$argCondition	= "WHERE MatriId=".$objSrchBasicView->doEscapeString($varMatriId,$objSrchBasicView);
						$varPhotoResSet	= $objSrchBasicView->select($varTable['MEMBERPHOTOINFO'],$argFields,$argCondition,0);
						$varPhotoRes	= mysql_fetch_assoc($varPhotoResSet);
						$varPhotoName	= $varPhotoRes["Thumb_Small_Photo1"];

						//get name
						$argFields		= array('Nick_Name','Name','Residing_Area','Residing_City');
						$argCondition	= "WHERE MatriId=".$objSrchBasicView->doEscapeString($varMatriId,$objSrchBasicView);
						$varNameResSet	= $objSrchBasicView->select($varTable['MEMBERINFOSEARCH'],$argFields,$argCondition,0);
						$varNameRes		= mysql_fetch_assoc($varNameResSet);
						$varDispName	= $varNameRes["Nick_Name"]!=''?$varNameRes["Nick_Name"]:$varNameRes["Name"];

						//location detail
						$varCountryId = $arrFPDetailResult['fpids'][$doc]['Country'];
						if($varCountryId==98) {
							$varStateId		= $arrFPDetailResult['fpids'][$doc]['Residing_State'];
							$varStateName	= ucfirst($residingCityStateMappingList[$varStateId]);
							$varCityId		= $arrFPDetailResult['fpids'][$doc]['Residing_District'];
							$varCityName	= ucfirst(${$residingCityStateMappingList[$varStateId]}[$varCityId]);
							$varLocStr		= $varCityName.',<BR>'.$varStateName.',<BR>'.ucfirst($arrCountryList[$varCountryId]);
						} else {
							$varLocStr = ucfirst($arrCountryList[$varCountryId]);
						}
				}
				?>
				<div style="padding:7px 0px;"><img src="<?=$confValues['PHOTOURL']?>/<?=$varMatriId{3}?>/<?=$varMatriId{4}?>/<?=$varPhotoName?>" width="150" height="150" /></div>
				<div class="normtxt bld padtb5"><?=$varDispName?> (<?=$varMatriId?>)</div>
				<div class="normtxt"><?=$varAge?> yrs, <?=$varHeightId?><br><?=$varCasteName?> | <?=$varLocStr?> | <?=$varEducationDet?></div>
				<div class="padtb5"><a class="smalltxt clr1" href="<?=$confValues['SERVERURL']?>/profiledetail/index.php?act=fullprofilenew&id=<?=$varMatriId?>">Full Profile >></a></div>
			</div>
			<div class="normtxt padtb5" style="color:#ffffff;">Want to feature your profile?</div>
			<div style="background:url(<?=$confValues['IMGSURL']?>/fpbg_btimg.gif) no-repeat;height:45px;width:192px;padding-top:7px;"><a href="<?=$confValues['SERVERURL']?>/payment/index.php?act=profilehightlight" class="normtxt clr1">Subscribe to<br> Profile Highlighter</a></div>
			</center>
		</div>
    </div>
<? unset($objSrchBasicView);
unset($objMasterDB);
} else { 
	if($confValues['DOMAINCASTEID']=='2503') {
		$varRPFPDummyBannerName = 'feaprobanner_rp_mm.gif';
		$varRPFPTrackDtl = 'trackid=00510001012&formfeed=y';
	} else if($confValues['DOMAINCASTEID']=='2500') {
		$varRPFPDummyBannerName = 'feaprobanner_rp_cm.gif';
		$varRPFPTrackDtl = 'trackid=00510001011&formfeed=y';
	} else {
		$varRPFPDummyBannerName = 'feaprobanner_rp_cbs.gif';
		$varRPFPTrackDtl = 'trackid=00510001010&formfeed=y';
	} ?>
	<div class="fright wdth192" style="display:inline">
	<a href="<?=$confValues['SERVERURL']?>/payment/index.php?act=profilehightlight&<?=$varRPFPTrackDtl?>"><img src="<?=$confValues['IMGSURL']?>/<?=$varRPFPDummyBannerName?>"/></a>
	</div>
<?}?>
 <div class="fright wdth192" style="margin-top:5px;display:inline">
	&nbsp;
</div>