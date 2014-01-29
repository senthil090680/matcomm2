<?php
# Author	:	A.Anbalagan
# Date		:	06/02/2010
# Desc		:	File to retrieve array details from CBS server (To be put in the cbs server)
# Filename	:	responsecbsfamilyinfoarray.php
#---------------------------------------------------------------------------------------------
//FAMILY RELATED ARRAYS
include("/home/product/community/conf/vars.cil14");

	if($_POST['FAMILYVALUESLIST']=='FAMILYVALUES') { #marital depentence list
		if(isset($arrFamilyValuesList)) {
		$responseVar[$_POST['FAMILYVALUESLIST']]= $arrFamilyValuesList;
		}
	}
	if($_POST['ARRFAMILYTYPE']=='FAMILYTYPE') { #religion list
		if(isset($arrFamilyType)) {
		$responseVar[$_POST['ARRFAMILYTYPE']]= $arrFamilyType;
		}
	}
	if($_POST['ARRFAMILYSTATUS']=='FAMILYSTATUS') { #denomination list
		if(isset($arrFamilyStatus)) {
		$responseVar[$_POST['ARRFAMILYSTATUS']]= $arrFamilyStatus;
		}
	}
	if($_POST['ARRNUMSIBLINGS']=='NUMSIBLINGS') { #caste depentence list
		if(isset($arrNumSiblings)) {
		$responseVar[$_POST['ARRNUMSIBLINGS']]= $arrNumSiblings;
		}
	}

print(json_encode($responseVar));
?>
