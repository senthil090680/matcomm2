<?php
function insertUpdateMatch($argConn, $argFields, $argFlag) {
	global $DBNAME, $TABLE;
	
	$argFlag = strtoupper($argFlag);

	if($argConn=='')
		return 'DB Connection Error';

	else if(!is_array($argFields))
		return 'Fields is not an array';

	else if(trim($argFields['MatriId']) == '')
		return 'MatriId is empty';

	else if($argFlag != 'I' && $argFlag != 'U' && $argFlag != 'D')
		return 'send Insert/Update/Delete Flag';

	
	if($argFlag == 'I' || $argFlag == 'U')
	{
		$funArrFields	= array('Language', 'MatriId', 'Age', 'Gender', 'MaritalStatus', 'Height', 'SpecialCase', 'MotherTongue', 'Religion', 'Caste', 'Dosham', 'EatingHabits', 'EducationSelected', 'CountrySelected', 'ResidingState', 'MatchLanguage', 'MatchMaritalStatus', 'StAge', 'EndAge', 'StHeight', 'EndHeight', 'PhysicalStatus', 'MatchMotherTongue', 'MatchReligion', 'MatchCaste', 'Manglik', 'EatingHabitsPref', 'MatchEducation', 'MatchCountry', 'MatchIndianStates', 'MatchUSStates', 'DateUpdated');

		$funFilteredValues = array();
		foreach($argFields as $key=>$val)
		{
			if(in_array($key,$funArrFields))
			{
				$funFilteredValues[$key] = $val;
			}
		}//for

		$funQuery	= 'INSERT INTO '.$DBNAME['MATRIMONYMS'].".".$TABLE['PROFILEMATCH'].' SET ';

		$funFields  = '';
		foreach($funFilteredValues as $fieldName=>$value) {
			$funFields .= $fieldName."='".preg_replace('/~/',',',$value)."', "; 
		}
		$funFields	= chop($funFields, ', ');
		$funQuery  .= $funFields.' ON DUPLICATE KEY UPDATE '.$funFields;
		//$argConn->insert($funQuery);
		//if($argConn->getAffectedRows()) {
			return true;
		//}
		//else {
		//return false;
		//}
	}
	else if($argFlag == 'D')
	{
		$funQuery	= 'DELETE FROM '.$DBNAME['MATRIMONYMS'].'.'.$TABLE['PROFILEMATCH']." WHERE MatriId='".$argFields['MatriId']."'";
		$argConn->del($funQuery);
	}
}
?>
