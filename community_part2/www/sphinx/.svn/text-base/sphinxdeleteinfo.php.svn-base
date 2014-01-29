<?

//FILE PATH
include_once('/home/product/community/lib/sphinxapi.php');
include_once('/home/product/community/conf/sphinxclass.cil14');
include_once("/home/product/community/conf/sphinxgenericfunction.cil14");

if($sessGender!=''){
	$varMatriId		= $sessMatriId;
	$varGender		= $sessGender;
	$varCommunityId = $varSelectMemberInfo["CommunityId"];
} else {
	$argCondition		= "WHERE MatriId='".$varMatriId."'";
	$argFields 			= array('Gender','CommunityId');
	$varResultArray		= $objMailManager->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
	$varMemberRes		= mysql_fetch_assoc($varResultArray);
	$varGender			= $varMemberRes["Gender"];
	$varCommunityId		= $varMemberRes["CommunityId"];
}

/* UPDATE STATUS TO SPHINX TABLE */
$arrFields			= array('deleted');
$arrFieldsValues	= array('1');
$varIndexName		= 'sphinxmemberinfo_'.$varCommunityId.'_'.$varGender;
fnUpdateSphinx($varMatriId,$varIndexName,$arrFields,$arrFieldsValues);

?>