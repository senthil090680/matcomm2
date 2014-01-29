<?php
ini_set("memory_limit","1024M");

//ROOT PATH
$varRootPath	= $_SERVER['DOCUMENT_ROOT'];
if($varRootPath ==''){
	$varRootPath = '/home/product/community/www';
}
$varBaseRoot = dirname($varRootPath);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/conf/dbainfo.cil14');
include_once($varBaseRoot.'/conf/domainlist.cil14');
include_once($varBaseRoot."/lib/clsDataConversion.php");

//Create txt file for get photos from BM db
$varBMPhotoFile	= $varRootPath.'/data-conversion/getNewlyAddedPhotos/bm-photos-list.txt';
$varProductFile	= $varRootPath.'/data-conversion/getNewlyAddedPhotos/product-photos-list.txt';
$varProtectFile	= $varRootPath.'/data-conversion/getNewlyAddedPhotos/photo-protect-info.txt';


//Delete photo based txt files
@unlink($varBMPhotoFile);
@unlink($varProductFile);
@unlink($varProtectFile);

$varBMPhotoFileHandler = fopen($varBMPhotoFile,'a');
$varProductFileHandler = fopen($varProductFile,'a');
$varProtectFileHandler = fopen($varProtectFile,'a');

//OBJECT DECLARTION
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

$varBMTable		= $varDbaInfo['DATABASE'].'.bm_photoinfo_missed';
$varBMCond		= "WHERE DateUpdated>='2009-06-27 00:00:00'";
$varNoOfRecs	= $objDC->numOfRecords($varBMTable, 'MatriId', $varBMCond);

if($varNoOfRecs > 0){
	$varNoOfTimes   = ceil($varNoOfRecs/1000);
	
	for($II=0; $II<$varNoOfTimes; $II++){
		$varStartRec	= $II*1000;
		$varBMFields	= array('MatriId', 'PhotoURL1', 'PhotoURL2', 'PhotoURL3', 'PhotoURL4', 'PhotoURL5', 'PhotoURL6', 'PhotoURL7', 'PhotoURL8', 'PhotoURL9', 'PhotoURL10', 'ThumbImgs1', 'ThumbImgs2', 'ThumbImgs3', 'ThumbImgs4', 'ThumbImgs5', 'ThumbImgs6', 'ThumbImgs7', 'ThumbImgs8', 'ThumbImgs9', 'ThumbImgs10', 'ThumbImg1','ThumbImg2','ThumbImg3', 'ThumbImg4','ThumbImg5','ThumbImg6', 'ThumbImg7','ThumbImg8','ThumbImg9', 'ThumbImg10', 'PhotoStatus1', 'PhotoStatus2', 'PhotoStatus3', 'PhotoStatus4', 'PhotoStatus5', 'PhotoStatus6', 'PhotoStatus7', 'PhotoStatus8', 'PhotoStatus9', 'PhotoStatus10', 'PhotoDescription1', 'PhotoDescription2', 'PhotoDescription3', 'PhotoDescription4', 'PhotoDescription5', 'PhotoDescription6', 'PhotoDescription7', 'PhotoDescription8', 'PhotoDescription9', 'PhotoDescription10', 'PhotoProtected', 'Photo_ProtectedPassword', 'Horoscope_ProtectedPassword', 'HoroscopeDescription', 'HoroscopeURL', 'HoroscopeStatus', 'HoroscopeProtected', 'DateUpdated');
		$varBMCond		= "WHERE DateUpdated>='2009-06-27 00:00:00' ORDER BY MatriId LIMIT ".$varStartRec.',1000';
		$varSelPhotoInfoDet	  = $objDC->select($varBMTable, $varBMFields, $varBMCond, 0);
	
		while($row=mysql_fetch_assoc($varSelPhotoInfoDet)){
			$varBMMatriId	= $row['MatriId'];

			$varTempCond	= "WHERE BM_MatriId='".$varBMMatriId."'";
			$varTempTable	= $varDbaInfo['DATABASE'].'.missedphotoids';
			$varTempFields	= array('MatriId', 'BM_MatriId');

			$varSelTempDet	= $objDC->select($varTempTable, $varTempFields, $varTempCond, 1);
			
			$varCount		= count($varSelTempDet);
			
			$varAlreadyTaken= 0;
			for($i=0; $i<$varCount; $i++){
			$varCommMatriId		  = $varSelTempDet[$i]['MatriId'];
			$varDateUpdated		  = $row['DateUpdated'];
			$varProtectPasswd     = $row['Photo_ProtectedPassword'];
			$varPhotoProtStatus   = $row['PhotoProtected'];
						
			//Text file contents for bm-photos-list.txt & product-photos-list.txt 
			$varBMPhotosTxtContent		= '';
			$varProductPhotosTxtContent	= '';
			$varProtectPhotoTxtContent  = '';
						
			//Get BM photo path
			$varBMDomainFolder = $varLangArray[strtoupper($varBMMatriId{0})];
			$varNormalPath	= $varBMDomainFolder.'/www/photos/'.$varBMMatriId{1}.'/'.$varBMMatriId{2}.'/';
			$varSourcePath	= $varBMDomainFolder.'/www/photosorg/'.$varBMMatriId{1}.'/'.$varBMMatriId{2}.'/';
			$varSourcePath2	= $varBMDomainFolder.'/www/photosorg/';

			for($j=1; $j<=10; $j++)
			{
				$varNormalPhoto	= $row['ThumbImgs'.$j];
				$varPhotoStatus	= $row['PhotoStatus'.$j]; //0-validated, 1-pending, 2-changed, 

				//Change photo status
				$varPhotoStatus	= ($varPhotoStatus==0 || $varPhotoStatus==2)? 1 : 0; 
				
				if($varNormalPhoto!= '' && $varPhotoStatus==1)
				{
					$varPhotoDesc		= $row['PhotoDescription'.$j];
					$varArrPhotoTypes	= array('NL','TS','TB');
					
					foreach($varArrPhotoTypes as $varPhotoType)
					{
						$varBMPhotoName	= '';
						switch($varPhotoType)
						{
							case 'NL': 
								$varBMPhotoName		= $varNormalPhoto;
								break;
							case 'TS': 
								$varThumbSmallPhoto	= 'ThumbImg'.$j;
								$varBMPhotoName		= $row[$varThumbSmallPhoto];
								break;
							case 'TB':
								$varThumbBigPhoto	= 'PhotoURL'.$j;
								$varBMPhotoName		= $row[$varThumbBigPhoto];
								break;
						}//switch

						if($varPhotoType == 'NL' && $varAlreadyTaken == 0){
						$varBMPhotosTxtContent   .= $varNormalPath.$varBMPhotoName."\n";
						}else if($varAlreadyTaken == 0){
						$varBMPhotosTxtContent   .= $varSourcePath.$varBMPhotoName."\n";
						$varBMPhotosTxtContent   .= $varSourcePath2.$varBMPhotoName."\n";
						}

						$varProductPhotosTxtContent.= $varBMPhotoName.'~'.$varCommMatriId.'~'.$varPhotoType.'~'.$j.'~'.$varPhotoStatus.'~'.$varPhotoDesc."\n";
					}//foreach
				}//if
			}//for

			$varAlreadyTaken = 1;
			

			//SAVE PHOTO PROTECT PASSWORD
			if($varProtectPasswd != '' && $varPhotoProtStatus=='Y')
			{
				$varProtectPhotoTxtContent = $varCommMatriId.'~'.$varBMMatriId.'~'.$varProtectPasswd."\n";
				fwrite($varProtectFileHandler, $varProtectPhotoTxtContent);
			}//if

			if($varBMPhotosTxtContent != '')
			fwrite($varBMPhotoFileHandler, $varBMPhotosTxtContent);

			if($varProductPhotosTxtContent != '')
			fwrite($varProductFileHandler, $varProductPhotosTxtContent);
		}//for
		}//while
	}//for
}

//UNSET OBJ
$objDC->dbClose();
unset($objDC)
?>
