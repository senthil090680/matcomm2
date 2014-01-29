<?php
# Author	:	A.Anbalagan
# Date		:	06/02/2010
# Desc		:	File to retrieve array details from CBS server (To be put in the cbs server)
# Filename	:	responsecbsarray.php
#---------------------------------------------------------------------------------------------
include('/home/product/community/conf/vars.cil14');
include('/home/product/community/conf/domainlist.cil14');
include('/home/product/community/conf/ppinfo.cil14');
$responseVar='';
$i=0;
if($_POST['DOMAINFOLDER']=='CBSFOLDER') { #domain folder name

	$responseVar[$_POST['DOMAINFOLDER']]= $arrFolderNames;
}
if($_POST['DOMAINLIST']=='CBSDOMAINNAME') { #domain list

	$responseVar[$_POST['DOMAINLIST']]= $arrPrefixDomainList;
}
if($_POST['MOTHERTONGUELIST']=='CBSMOTHERTONGUE') { #mother tongue list

	$responseVar[$_POST['MOTHERTONGUELIST']]= $arrMotherTongueList;
}
if($_POST['HEIGHTLIST']=='CBSHEIGHT') { #height list

	$responseVar[$_POST['HEIGHTLIST']]= $arrHeightList;
}

if($_POST['HEIGHTFEETLIST']=='CBSHEIGHTFEET') { #height list

	$responseVar[$_POST['HEIGHTFEETLIST']]= $arrHeightFeetList;
}

if($_POST['PARHEIGHTLIST']=='CBSPARHEIGHT') { #height list

	$responseVar[$_POST['PARHEIGHTLIST']]= $arrParHeightList;
}
if($_POST['EDUCATIONLIST']=='CBSEDUCATION') { #education list

	$responseVar[$_POST['EDUCATIONLIST']]= $arrEducationList;
	$responseVar['EDUCATIONSUBLIST']= $arrEducationSubList;
	$responseVar['EDUCATIONMAPPING']= $arrEducationMapping;
}
if($_POST['GOTHRAMLIST']=='CBSGOTHRAM') { #gothram list

	$responseVar[$_POST['GOTHRAMLIST']]= $arrGothramList;
}
if($_POST['CASTEGOTHRAMMAPLIST']=='CBSCASTEGOTHRAMMAP') { #caste gothram map list
	
	$responseVar[$_POST['CASTEGOTHRAMMAPLIST']]= $arrCasteGothramMap;
}
if($_POST['MARITALLIST']=='CBSMARITAL') { #marital list

	$responseVar[$_POST['MARITALLIST']]= $arrMaritalList;
}

if($_POST['STAR']=='CBSSTAR') { #star list
	$responseVar[$_POST['STAR']]= $arrStarList;
}
if($_POST['RASI']=='CBSRASI') { #rai list
	$responseVar[$_POST['RASI']]= $arrRaasiList;
}
if($_POST['EDUIN']=='CBSEDUIN') { #emp in list
	$responseVar[$_POST['EDUIN']]= $arrEmployedInList;
}
if($_POST['OCCLIST']=='CSBOCCLIST') { #occupation list
	$responseVar['OCCUPATIONLIST']=$arrTotalOccupationList;
	$responseVar['OCCUPATIONGROUPLIST']=$arrGroupOccupationList;
}
if($_POST['INCOMCURR']=='CBSINCOMCURR') { #income list
	$responseVar[$_POST['INCOMCURR']]= $arrSelectCurrencyList;
}
print(json_encode($responseVar));
?>
