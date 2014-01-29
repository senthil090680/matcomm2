<?php
# Author	:	A.Anbalagan
# Date		:	06/02/2010
# Desc		:	File to retrieve array details from CBS server (To be put in the cbs server)
# Filename	:	responsecbsarray.php
#---------------------------------------------------------------------------------------------
#$_POST['DOMAINNAME']='iyer';
#$_POST['DEPVARE']='DEPVARE';

if(isset($_POST['DOMAINNAME']) && !empty($_POST['DOMAINNAME'])) {

$domainName=$_POST['DOMAINNAME'];

include("/home/product/community/conf/vars.cil14");
include("/home/product/community/domainslist/".$domainName."/conf.cil14");

$strName=strtoupper($domainName);

	if($_POST['MARITALLISTDEP']=='CBSMARITAL') { #marital depentence list
		if(isset($arrMaritalList)) {
		$responseVar[$strName.$_POST['MARITALLISTDEP']]= $arrMaritalList;
		}
	}
	if($_POST['RELIGIONLIST']=='CBSRELIGION') { #religion list
		if(isset($arrReligionList)) {
		$responseVar[$strName.$_POST['RELIGIONLIST']]= $arrReligionList;
		}
	}
	if($_POST['ARRDENOMINATIONLIST']=='CBSDENOMINATION') { #denomination list
		if(isset($arrDenominationList)) {
		$responseVar[$strName.$_POST['ARRDENOMINATIONLIST']]= $arrDenominationList;
		}
	}
	if($_POST['ARRCASTELIST']=='CBSCASTE') { #caste depentence list
		if(isset($arrCasteList)) {
		$responseVar[$strName.$_POST['ARRCASTELIST']]= $arrCasteList;
		}
	}
	if($_POST['ARRSUBCASTETRIMMED']=='CBSSUBCASTET') { #subcastet list
		
		if(isset($arrSubcasteList)) {
		$responseVar[$strName.'ARRSUBCASLIST']= $arrSubcasteList; //for reg
		}
		if(isset($arrSubCasteTrimmed)) {
		$responseVar[$strName.$_POST['ARRSUBCASTETRIMMED']]= $arrSubCasteTrimmed;
		}
	}
	if($_POST['DEPVARE']=='DEPVARE') {
		if(isset($_FeatureMaritalStatus)){ 
		$checkDoamincofig[MaritalStatus]=$_FeatureMaritalStatus;
		}
		if(isset($_FeatureReligion)) {
		$checkDoamincofig[Religion]=$_FeatureReligion;
		}
		if(isset($_FeatureDenomination)) {
		$checkDoamincofig[Denomination]=$_FeatureDenomination;
		}
		if(isset($_FeatureCaste)) {
		$checkDoamincofig[Caste]=$_FeatureCaste;
		}
		if(isset($_FeatureCasteTxt)) {
		$checkDoamincofig[CasteTxt]=$_FeatureCasteTxt;
		}
		if(isset($_FeatureSubcaste)) {
		$checkDoamincofig[Subcaste]=$_FeatureSubcaste;
		}
		if(isset($_FeatureSubcasteTxt)) {
		$checkDoamincofig[SubcasteTxt]=$_FeatureSubcasteTxt;
		}
		if(isset($_FeatureGothram)) {
		$checkDoamincofig[domainGothram]=$_FeatureGothram;
		}
		if(isset($_FeatureGothramTxt)) {
		$checkDoamincofig[GothramTxt]=$_FeatureGothramTxt;
		}
		if(isset($_FeatureStar)) {
		$checkDoamincofig[FeatureStar]=$_FeatureStar;
		}
		if(isset($_FeatureRaasi)) {
		$checkDoamincofig[FeatureRaasi]=$_FeatureRaasi;
		}
		if(isset($_LabelCaste)) {
		$checkDoamincofig[LabelCaste]=$_LabelCaste;
		}
		if(isset($_LabelSubcaste)) {
		$checkDoamincofig[LabelSubcaste]=$_LabelSubcaste;
		}
		if(isset($_LabelDenomination)) {
		$checkDoamincofig[LabelDenomination]=$_LabelDenomination;
		}
		$domainWise=$domainName."checkDomain";
		$responseVar[$domainWise]=$checkDoamincofig;
	}

}
print(json_encode($responseVar));
?>
