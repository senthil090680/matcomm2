<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varRootBasePath	= '/home/product/community';
include_once($varRootBasePath."/lib/clsDomain.php");

//OBJECT INITIALIZATION
$objDomainInfo	= new domainInfo;
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//VARIABLE DECLARATION
$varField			= trim($_REQUEST['field']);
$varReligionId		= trim($_REQUEST['religionId']);
$varCasteId			= trim($_REQUEST['casteId']);
$varCommunityId = trim($_REQUEST['communityId']);

$arrCasteList		= array();		
$varCasteOnBlur		='';

//Caste List for each religion
if ($varReligionId >0 && $varField=='religion') {
	
	if($objDomainInfo->useCaste()) {
		$varCasteMandatory	= $objDomainInfo->isCasteMandatory();
		if($varCasteMandatory==1) {
			$varCasteOnBlur='onBlur="casteChk();"';
		}
		if($varReligionId >0 && $varField=='religion') {	
		  $arrCasteList	= $objDomainInfo->getCasteOptionsForReligion($varReligionId);
		}
		$varCasteCount	= count($arrCasteList);

		if ($varCasteCount > 0) {
		
			$varContent		= "<select size=\"1\" name=\"caste\" tabindex=\"26\" class=\"srchselect\" ".$varCasteOnBlur." onChange=\"casteOthersChk();funCaste('');\">";

			$varContent		.= '<option value="0">--- Select ---</option>';

			foreach($arrCasteList as $k=>$v) {
			  if($k == $varCasteId)
              $varContent		.= '<option value="'.$k.'" selected>'.$v.'</option>';
			  else
			  $varContent		.= '<option value="'.$k.'">'.$v.'</option>';
			}
			$varContent		.= '</select>';
			$varContent		= $varCasteCount.'~'.$varContent;
		} else {
			$varContent		="<input type=\"text\" class=\"inputtext\" tabindex=\"26\" size=\"35\" style=\"width:215px;\" name=\"casteText\" ".$varCasteOnBlur.">";
			$varContent		= '0~'.$varContent;
		}

	} else { $varContent		= '0~0'; }

}
echo trim($varContent);
?>