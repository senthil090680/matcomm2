<?php
$varRootBasePath	= '/home/product/community';

include_once($varRootBasePath."/lib/sphinxapi.php"); 
include_once($varRootBasePath."/conf/sphinxclass.cil14");
include_once($varRootBasePath."/conf/sphinxgenericfunction.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/ip.cil14");
include_once($varRootBasePath.'/lib/clsCache.php');

function updateOnlineStatus($argMatriIdDets, $argGender){
	global $arrCommuniyId,$varSphinxIP;

	foreach($varSphinxIP as $sphinxkey=>$sphinxvalue){

		$s = new sphinxdb();
		$SphinxObjectTempDB	= $s->SphinxConnect($sphinxkey, $sphinxvalue, 'SPH_MATCH_FULLSCAN', '30');

		if($SphinxObjectTempDB!='-1' ) {
			foreach($argMatriIdDets as $varKey=>$varVal){
				$varMatriIdPre		= substr($varKey, 0, 3);
				$varCommunityId		= $arrCommuniyId[$varMatriIdPre];
				$arrSphinxIdxName	= getSphinxIndexName($varCommunityId, $argGender);
				$varSphinxIdxName	= $arrSphinxIdxName['sphinxmemberinfo'];
				$varDocumentId		= ConvertToSphinxMatriIdFormat($varKey);
				$s->UpdateAttributes($varSphinxIdxName,array("onlinestatus"),array($varDocumentId=>array($varVal)));
			}
		}

		unset($s);
	}
}

//Online status update part for male ids
$arrMaleMatriIdDets	= Cache::getData('SPHX_ONLINE_DETAIL_MALE');
$arrEmptyVal	= array();
Cache::deleteData('SPHX_ONLINE_DETAIL_MALE');
Cache::setData('SPHX_ONLINE_DETAIL_MALE', $arrEmptyVal);

//Online status update part for female ids
$arrFemaleMatriIdDets=Cache::getData('SPHX_ONLINE_DETAIL_FEMALE');	
Cache::deleteData('SPHX_ONLINE_DETAIL_FEMALE');
Cache::setData('SPHX_ONLINE_DETAIL_FEMALE', $arrEmptyVal);

Cache::deleteData('SPHX_ROTATEINDEX_ON'); //SPHX_INDEX_ON key used for whether index is run or not.

$arrCommuniyId	= array_flip($arrMaleMatriIdDets);
if($arrMaleMatriIdDets!='' && count($arrMaleMatriIdDets)>0){ updateOnlineStatus($arrMaleMatriIdDets,1); }

$arrCommuniyId	= array_flip($arrFemaleMatriIdDets);
if($arrFemaleMatriIdDets!='' && count($arrFemaleMatriIdDets)>0){ updateOnlineStatus($arrFemaleMatriIdDets,2); }

?>