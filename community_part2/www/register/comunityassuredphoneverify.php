<?php
header('Content-type: text/xml');
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//file includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');
include_once($varBaseRootPath."/lib/clsValidateInsert.php");

//OBJECT DECLARTION
$objDB	= new DB;

//CONNECT DATABASE
$objDB->dbConnect('M',$varDbInfo['DATABASE']);

if((isset($_REQUEST['STATUS']))&&(isset($_REQUEST['PHONE']))){
  $status = trim($_REQUEST['STATUS']);
  $phone = substr(trim($_REQUEST['PHONE']),6);// Have to check with the dialler team and provide this url to them
}

if(empty($status)||empty($phone)){
  echo show_output('FAILURE');
  exit; 
}

$varCondition	= " WHERE PhoneNo =".$objDB->doEscapeString($phone,$objDB)." AND HOUR(sec_to_time(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(DateInserted)))<23 ORDER BY DateInserted DESC LIMIT 1";
$varFields		= array('MatriId');
$varResults		= $objDB->select($varTable['ASSUREDCLICKTOCALLLOG'],$varFields,$varCondition,1);
$varMatriId	= $varResults[0]['MatriId'];

if(count($varResults)<1){
  echo show_output('FAILURE');
  exit; 
}else{
	if($status==1){
		fnPhoneVerify($varMatriId);
	}
}




function show_output($msg){
  return "<?xml version='1.0' encoding='UTF-8'?><pinphonevalidation><response>".$msg."</response></pinphonevalidation>";
}


function fnPhoneVerify($sMatriId){
  global $objDB,$varTable;

	$varCondition	= " WHERE MatriId=".$objDB->doEscapeString($sMatriId,$objDB)."";
	$varFields		= array('PinNo','MatriId','PhoneNo1','ContactPerson1','Relationship1','Timetocall1','Description','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','ThruRegistration','VerifiedFlag','VerificationSource');
	$varBeforeValidationResults		= $objDB->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varFields,$varCondition,1);

	if(count($varBeforeValidationResults)>0){
		$varPinNo			= $varBeforeValidationResults[0]['PinNo'];
		$varMatriId			= $varBeforeValidationResults[0]['MatriId'];
		$varPhoneNo1		= $varBeforeValidationResults[0]['PhoneNo1'];
		$varCntPeron		= $varBeforeValidationResults[0]['ContactPerson1'];
		$varRelationship	= $varBeforeValidationResults[0]['Relationship1'];
		$varTimetocall		= $varBeforeValidationResults[0]['Timetocall1'];
		$varDescription		= $varBeforeValidationResults[0]['Description'];
		$varTimeGenerated	= $varBeforeValidationResults[0]['TimeGenerated'];
		$varCtryCode		= $varBeforeValidationResults[0]['CountryCode'];
		$varAreaCode		= $varBeforeValidationResults[0]['AreaCode'];
		$varLandlineno		= $varBeforeValidationResults[0]['PhoneNo'];
		$varMobileno		= trim($varBeforeValidationResults[0]['MobileNo']);
		$varThruRegistration= $varBeforeValidationResults[0]['ThruRegistration'];
		$varVerifiedFlag	= $varBeforeValidationResults[0]['VerifiedFlag'];
		$varVeriSource		= $varBeforeValidationResults[0]['VerificationSource'];

		if($varVeriSource=='0' || $varVeriSource=='')
		  $varVeriSource=1;

		$varFields = array('MatriId','PinNo','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','TimeGenerated','DateConfirmed','VerifiedFlag','Description','VerificationSource','ThruRegistration');

		$varFieldsValues = array("'".$varMatriId."'","'".$varPinNo."'","'".$varCtryCode."'","'".$varAreaCode."'","'".$varLandlineno."'","'".$varMobileno."'","'".$varPhoneNo1."'","'1'","'".$varCntPeron."'","'".$varRelationship."'","'".$varTimetocall."'","'".$varTimeGenerated."'","NOW()","'".$varVerifiedFlag."'","'".$varDescription."'","'".$varVeriSource."'","'".$varThruRegistration."'");

		$varResult=$objDB->insertOnDuplicate($varTable['ASSUREDCONTACT'],$varFields,$varFieldsValues, $varMatriId);

		if($varResult==true){
	      echo show_output('SUCCESS');
		}else{
	      echo show_output('FAILURE');
		  exit;
		}

        $varCondition		= "MatriId=".$objDB->doEscapeString($varMatriId,$objDB)."";
		$rec_aff_count=$objDB->delete($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varCondition); 
		$rec_aff_count=1;
		if($rec_aff_count==1){
			$varFields			= array('UsedStatus');
			$varFieldsValues	= array("'0'");
			$varCondition		= "PinNo='".$varPinNo."'";
			$res=$objDB->update($varTable['ASSUREDCONTACTPINNOSERIES'],$varFields,$varFieldsValues,$varCondition);

		}

        		
		$varCondition		= "MatriId=".$objDB->doEscapeString($varMatriId,$objDB)."";
		$rec_aff_count=$objDB->delete($varTable['ASSUREDCLICKTOCALLLOG'],$varCondition);
	    if((strlen($varCntPeron) > 0)&&($varRelationship>0)&&(strlen($varTimetocall) > 0)){
			$phoneverifiedflag=1;
	    }else {
			  if($varThruRegistration=='1')
				$phoneverifiedflag=3;
			  else
				$phoneverifiedflag=2;
	    }
		$varFields			= array('Phone_Verified','Date_Updated');
		$varFieldsValues	= array("'".$phoneverifiedflag."'","NOW()");
		$rec_aff_count=$objDB->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
	
		//MEMBERTOOL LOGIN
		$varType  = 1;
		$varField = $phoneverifiedflag;

		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
		$varnewCmd  = 'php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &';

		escapeexec($varnewCmd,$varlogFile);
	
	}


}
?>