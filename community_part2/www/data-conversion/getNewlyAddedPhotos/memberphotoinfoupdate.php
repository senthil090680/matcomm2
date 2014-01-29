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
include_once($varBaseRoot.'/conf/dbainfo.cil14');
include_once($varBaseRoot.'/lib/clsDataConversion.php');

//Object Decleration
$objDC = new DataConversion;

//Connect DB
$objDC->dbConnect($varDbaServer, $varDbaInfo['USERNAME'], $varDbaInfo['PASSWORD'], $varDbaInfo['DATABASE']);

$varCommTable	= $varDbaInfo['DATABASE'].'.comm_memberphotoinfo_missed';
$varNoOfRecs	= $objDC->numOfRecords($varCommTable, 'MatriId', '');

if($varNoOfRecs > 0){
	$varNoOfTimes   = ceil($varNoOfRecs/1000);
	
	//File Creation
	$varFileName = 'FinalPhotosList.txt';
	@unlink($varFileName);
	$varFileHand = fopen($varFileName, 'a');

	for($II=0; $II<$varNoOfTimes; $II++){
		$varStartRec	= $II*1000;
		$varFields		= array('Photo_Id', 'MatriId', 'Normal_Photo1', 'Description1', 'Thumb_Small_Photo1', 'Thumb_Big_Photo1', 'Photo_Status1', 'Normal_Photo2', 'Description2', 'Thumb_Small_Photo2', 'Thumb_Big_Photo2', 'Photo_Status2', 'Normal_Photo3', 'Description3', 'Thumb_Small_Photo3', 'Thumb_Big_Photo3', 'Photo_Status3', 'Normal_Photo4', 'Description4', 'Thumb_Small_Photo4', 'Thumb_Big_Photo4', 'Photo_Status4', 'Normal_Photo5', 'Description5', 'Thumb_Small_Photo5', 'Thumb_Big_Photo5', 'Photo_Status5', 'Normal_Photo6', 'Description6', 'Thumb_Small_Photo6', 'Thumb_Big_Photo6', 'Photo_Status6', 'Normal_Photo7', 'Description7', 'Thumb_Small_Photo7', 'Thumb_Big_Photo7', 'Photo_Status7', 'Normal_Photo8', 'Description8', 'Thumb_Small_Photo8', 'Thumb_Big_Photo8', 'Photo_Status8', 'Normal_Photo9', 'Description9', 'Thumb_Small_Photo9', 'Thumb_Big_Photo9', 'Photo_Status9', 'Normal_Photo10', 'Description10', 'Thumb_Small_Photo10', 'Thumb_Big_Photo10', 'Photo_Status10', 'Photo_Protected', 'Photo_Protect_Password', 'Photo_Date_Updated', 'HoroscopeURL', 'HoroscopeDescription', 'HoroscopeStatus', 'Horoscope_Date_Updated', 'Horoscope_Protected', 'Horoscope_Protected_Password');
		$varCond		= ' ORDER BY Photo_Id ASC LIMIT '.$varStartRec.', 1000';
		$varPhotoDet	= $objDC->select($varCommTable, $varFields, $varCond, 0);

		while($row=mysql_fetch_assoc($varPhotoDet)){
		$arrFinalValues = array();
		$arrCopiedPhotos= array();
		$kk =0;
		for($k=1; $k<=10; $k++){
			$varNLField	= 'Normal_Photo'.$k;
			$varTSField	= 'Thumb_Small_Photo'.$k;
			$varTBField	= 'Thumb_Big_Photo'.$k;
			$varStField	= 'Photo_Status'.$k;
			$varDecField= 'Description'.$k;

			$varFiledVal1= $row[$varNLField];
			$varFiledVal2= $row[$varTSField];
			$varFiledVal3= $row[$varTBField];
			$varFiledVal4= $row[$varStField];
			$varFiledVal5= $row[$varDecField];

			if($varFiledVal1!='' && $varFiledVal2!='' && $varFiledVal3!='' && $varFiledVal4 ==1){
				$arrFinalValues[$kk]['Normal_Photo']		= $varFiledVal1;
				$arrFinalValues[$kk]['Thumb_Small_Photo']	= $varFiledVal2;
				$arrFinalValues[$kk]['Thumb_Big_Photo']		= $varFiledVal3;
				$arrFinalValues[$kk]['Photo_Status']		= 1;
				$arrFinalValues[$kk]['Description']			= addslashes($varFiledVal5);
				$kk++;

				$arrCopiedPhotos[] = $varFiledVal1;
				$arrCopiedPhotos[] = $varFiledVal2;
				$arrCopiedPhotos[] = $varFiledVal3;
			}
		}

		$varUpdateCond	= 'Photo_Id='.$row['Photo_Id']." AND MatriId='".$row['MatriId']."'";
		
		$varFieldsVal	= array($row['Photo_Id'], "'".$row['MatriId']."'", "'".$arrFinalValues[0]['Normal_Photo']."'", "'".$arrFinalValues[0]['Description']."'", "'".$arrFinalValues[0]['Thumb_Small_Photo']."'", "'".$arrFinalValues[0]['Thumb_Big_Photo']."'", "'".$arrFinalValues[0]['Photo_Status']."'",  "'".$arrFinalValues[1]['Normal_Photo']."'", "'".$arrFinalValues[1]['Description']."'", "'".$arrFinalValues[1]['Thumb_Small_Photo']."'", "'".$arrFinalValues[1]['Thumb_Big_Photo']."'", "'".$arrFinalValues[1]['Photo_Status']."'", "'".$arrFinalValues[2]['Normal_Photo']."'", "'".$arrFinalValues[2]['Description']."'", "'".$arrFinalValues[2]['Thumb_Small_Photo']."'", "'".$arrFinalValues[2]['Thumb_Big_Photo']."'", "'".$arrFinalValues[2]['Photo_Status']."'", "'".$arrFinalValues[3]['Normal_Photo']."'", "'".$arrFinalValues[3]['Description']."'", "'".$arrFinalValues[3]['Thumb_Small_Photo']."'", "'".$arrFinalValues[3]['Thumb_Big_Photo']."'", "'".$arrFinalValues[3]['Photo_Status']."'", "'".$arrFinalValues[4]['Normal_Photo']."'", "'".$arrFinalValues[4]['Description']."'", "'".$arrFinalValues[4]['Thumb_Small_Photo']."'", "'".$arrFinalValues[4]['Thumb_Big_Photo']."'", "'".$arrFinalValues[4]['Photo_Status']."'", "'".$arrFinalValues[5]['Normal_Photo']."'", "'".$arrFinalValues[5]['Description']."'", "'".$arrFinalValues[5]['Thumb_Small_Photo']."'", "'".$arrFinalValues[5]['Thumb_Big_Photo']."'", "'".$arrFinalValues[5]['Photo_Status']."'", "'".$arrFinalValues[6]['Normal_Photo']."'", "'".$arrFinalValues[6]['Description']."'", "'".$arrFinalValues[6]['Thumb_Small_Photo']."'", "'".$arrFinalValues[6]['Thumb_Big_Photo']."'", "'".$arrFinalValues[6]['Photo_Status']."'", "'".$arrFinalValues[7]['Normal_Photo']."'", "'".$arrFinalValues[7]['Description']."'", "'".$arrFinalValues[7]['Thumb_Small_Photo']."'", "'".$arrFinalValues[7]['Thumb_Big_Photo']."'", "'".$arrFinalValues[7]['Photo_Status']."'", "'".$arrFinalValues[8]['Normal_Photo']."'", "'".$arrFinalValues[8]['Description']."'", "'".$arrFinalValues[8]['Thumb_Small_Photo']."'", "'".$arrFinalValues[8]['Thumb_Big_Photo']."'", "'".$arrFinalValues[8]['Photo_Status']."'", "'".$arrFinalValues[9]['Normal_Photo']."'", "'".$arrFinalValues[9]['Description']."'", "'".$arrFinalValues[9]['Thumb_Small_Photo']."'", "'".$arrFinalValues[9]['Thumb_Big_Photo']."'", "'".$arrFinalValues[9]['Photo_Status']."'", "'".$row['Photo_Protected']."'", "'".$row['Photo_Protect_Password']."'", "'".$row['Photo_Date_Updated']."'", "'".$row['HoroscopeURL']."'", "'".addslashes($row['HoroscopeDescription'])."'", "'".$row['HoroscopeStatus']."'", "'".$row['Horoscope_Date_Updated']."'", "'".$row['Horoscope_Protected']."'", "'".$row['Horoscope_Protected_Password']."'");
	
		$objDC->update($varCommTable, $varFields, $varFieldsVal, $varUpdateCond);
		fwrite($varFileHand, join("\n", $arrCopiedPhotos)."\n");
		}
	}
	fclose($varFileHand);
}

//UNSET OBJECT
$objDC->dbClose();
unset($objDC);
?>
