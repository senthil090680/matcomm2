<?
//Function to select all tools count for profiles viewed and not contacted
function selectalltoolscount($sessMatriId,$reqTypeVal,$varCommunityId){
	global $varSphinx,$varMISphinxIdxName;

	//getTotal count for preferred,matchwatch,recommend
	$varMSTotalKey			= 'MS_total_display_'.$sessMatriId;	
	$arrMatchSumamryTotal = Cache::getData($varMSTotalKey);

	$varStartLt=0; 
	if($reqTypeVal==1) { //preferred
		$varNoOfProfilesDisplay	= $arrMatchSumamryTotal['viewednotcontacted']['preferred'];
	} else if($reqTypeVal==2) { //recommended
		$varNoOfProfilesDisplay	= $arrMatchSumamryTotal['viewednotcontacted']['recommended'];
	} else if($reqTypeVal==3) { //matchwatch
		$varNoOfProfilesDisplay	= $arrMatchSumamryTotal['viewednotcontacted']['matchwatch'];
	}

	$arrViewedAndNotContactedForTools = getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,3,$varNoOfProfilesDisplay,'');

	$viewedNotContactedIds	= array_keys($arrViewedAndNotContactedForTools['ids']);

	$sphinxObj	= new sphinxdb();  
	$ip			= $varSphinx['IP'];
	$port		= $varSphinx['PORT'];
	$sphinxObj	= $sphinxObj->SphinxConnect($ip,$port, SPH_MATCH_FULLSCAN,3000);

	$photoresult	= toolsMatchSummaryCount($sphinxObj, $sessMatriId, $viewedNotContactedIds, $varStartLt, "1", '1',   $varNoOfProfilesDisplay);

	$phoneresult	= toolsMatchSummaryCount($sphinxObj, $sessMatriId, $viewedNotContactedIds, $varStartLt, "1", '3',   $varNoOfProfilesDisplay);

	$horoscoperesult= toolsMatchSummaryCount($sphinxObj, $sessMatriId, $viewedNotContactedIds, $varStartLt, "1", '2',   $varNoOfProfilesDisplay);
	
	$result=array();
	if($photoresult[0] > 0) {
		$result['photo'][0]		= $photoresult[0];
		$result['photo'][1]		= $photoresult[1];
	} else {
		$result['photo'][0]		= 0;
		$result['photo'][1]		= '';
	}

	if($phoneresult[0] > 0) {
		$result['phone'][0]		= $phoneresult[0];
		$result['phone'][1]		= $phoneresult[1];
	} else {
		$result['phone'][0]		= 0;
		$result['phone'][1]		= '';
	}

	if($horoscoperesult[0] > 0) {
		$result['horoscope'][0]		= $horoscoperesult[0];
		$result['horoscope'][1]		= $horoscoperesult[1];
	} else {
		$result['horoscope'][0]		= 0;
		$result['horoscope'][1]		= '';
	}
	/*$result['photo']		= ($photoresult[0] > 0)?$photoresult[0]:'0';
	$result['phone']		= ($phoneresult[0] > 0)?$phoneresult[0]:'0';
	$result['horoscope']	= ($horoscoperesult[0] > 0)?$horoscoperesult[0]:'0';*/

	return $result;
}
/*
function selecttoolsid($sessMatriId,$reqTypeVal,$varCommunityId){
	global $varSphinx,$varMISphinxIdxName;

	//getTotal count for preferred,matchwatch,recommend
	$varMSTotalKey			= 'MS_total_display_'.$sessMatriId;	
	$arrMatchSumamryTotal = Cache::getData($varMSTotalKey);

	$varStartLt=0; 
	if($reqTypeVal==1) { //preferred
		$varNoOfProfilesDisplay	= $arrMatchSumamryTotal['viewednotcontacted']['preferred'];
	} else if($reqTypeVal==2) { //recommended
		$varNoOfProfilesDisplay	= $arrMatchSumamryTotal['viewednotcontacted']['recommended'];
	} else if($reqTypeVal==3) { //matchwatch
		$varNoOfProfilesDisplay	= $arrMatchSumamryTotal['viewednotcontacted']['matchwatch'];
	}

	$arrViewedAndNotContactedForTools = getResultsfromSphinx($varMISphinxIdxName, '', $varCommunityId,2,3,$varNoOfProfilesDisplay);

	$viewedNotContactedIds	= array_keys($arrViewedAndNotContactedForTools['ids']);

	$sphinxObj	= new sphinxdb();  
	$ip			= $varSphinx['IP'];
	$port		= $varSphinx['PORT'];
	$sphinxObj	= $sphinxObj->SphinxConnect($ip,$port, SPH_MATCH_FULLSCAN,3000);

	$photoresult	= toolsMatchSummaryCount($sphinxObj, $sessMatriId, $viewedNotContactedIds, $varStartLt, "1", '1',   $varNoOfProfilesDisplay);

	$phoneresult	= toolsMatchSummaryCount($sphinxObj, $sessMatriId, $viewedNotContactedIds, $varStartLt, "1", '3',   $varNoOfProfilesDisplay);

	$horoscoperesult= toolsMatchSummaryCount($sphinxObj, $sessMatriId, $viewedNotContactedIds, $varStartLt, "1", '2',   $varNoOfProfilesDisplay);
	
	$result['photoid']		= ($photoresult[0] > 0)?$photoresult[1]:'';
	$result['phoneid']		= ($phoneresult[0] > 0)?$phoneresult[1]:'';
	$result['horoscopeid']	= ($horoscoperesult[0] > 0)?$horoscoperesult[1]:'';
	return $result;
}*/
?>