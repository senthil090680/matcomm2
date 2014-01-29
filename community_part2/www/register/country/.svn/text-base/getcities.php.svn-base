<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-08-04
# End Date		: 2008-08-04
# Project		: MatrimonyProduct
# Module		: Registration - Basic
#=============================================================================================================

//PATH INCLUDES
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
$varCountry	= trim($_REQUEST['countryid']);
$varState	= trim($_REQUEST['stateid']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/cityarray.inc");

if($varCountry!="" && $varState!="")
{
	if($varCountry==98)
	{
	$statename	= $residingCityStateMappingList[$varState];
	}
	elseif($varCountry==162)
	{
	$statename	= $residingPakiCityStateMappingList[$varState];
	}

	$cityarray	= $$statename;
	asort($cityarray);
	$options	='';
	while(list($ind,$val)=each($cityarray))
	{
		$options .= $ind."~".$val."~";
	}
	$options = substr($options,0,-1);
	echo $options;
	
}
else
{
	echo '0~-Select-';
}
?>