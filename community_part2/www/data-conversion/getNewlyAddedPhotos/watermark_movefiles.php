<?php
//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/domainlist.cil14');
include_once($varBaseRoot."/lib/clsCropping.php");

//ini_set('display_errors', 0);
//OBJECT DECLERATION
$objCrop	= new Cropping;

$varFileName		= $varBaseRoot.'/www/data-conversion/getNewlyAddedPhotos/FinalPhotosList.txt';
$arrFileContents	= file($varFileName);
$varPhotosCnt		= count($arrFileContents);

for($i=0; $i<$varPhotosCnt; $i++){
	$varPhotoName		= trim($arrFileContents[$i],"\n");
	$arrPhotoinfo		= split('\.', $varPhotoName);
	$varMatriIdPrefix	= substr($varPhotoName, 0, 3);
	$varFolderName		= $arrFolderNames[$varMatriIdPrefix];

	$varWatermark 		= '';
	$varSourcePath		= '';
	$varWatermark 		= $varBaseRoot."/www/images/watermark/".$varFolderName."_wm.png";
	$varSourcePath		= $varBaseRoot.'/www/membersphoto/'.$varFolderName.'/'.$varPhotoName{3}.'/'.$varPhotoName{4}.'/'.$varPhotoName;
	
	if($varPhotoName!='' && file_exists($varSourcePath) && file_exists($varWatermark)){
		list($varPhotoWidth,$varPhotoHeight)	= getimagesize($varSourcePath);

		if($varPhotoWidth>=150 & $varPhotoHeight>=150 && ($arrPhotoinfo[1]=='jpg'|| $arrPhotoinfo[1]=='jpeg' || $arrPhotoinfo[1]=='gif' || $arrPhotoinfo[1]=='png')){
			$objCrop->funWaterImg($varSourcePath,$varWatermark,$varSourcePath,$arrPhotoinfo[1]);
		}
	}
}

//Move Files
$varDate		= date("dmY");
$varDateTime	= date("dmYHis");
$varSourceDir	= $varRootPath.'/data-conversion/getNewlyAddedPhotos';
$varDesDir		= $varRootPath.'/data-conversion/getNewlyAddedPhotos/backupfiles/'.$varDate;

@mkdir($varDesDir);
copy($varSourceDir.'/FinalPhotosList.txt', $varDesDir.'/FinalPhotosList_'.$varDateTime.'.txt');

//UNSET OBJ
unset($objCrop);
?>
