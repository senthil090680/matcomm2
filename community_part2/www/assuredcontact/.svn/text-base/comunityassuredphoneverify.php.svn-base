<?php
header('Content-type: text/xml');
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//file includes
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsRegister.php');


//OBJECT DECLARTION
$objRegister	= new clsRegister;

//CONNECT DATABASE
$objRegister->dbConnect('M',$varDbInfo['DATABASE']);


/* testing this line to remove when live */
$status = 1;
$phone = substr(trim("DDDAAA009884783142"),6);
/* testing this line to remove when live */

if((isset($_REQUEST['STATUS']))&&(isset($_REQUEST['PHONE']))){
  $status = trim($_REQUEST['STATUS']);
  $phone = substr(trim($_REQUEST['PHONE']),6);// Have to check with the dialler team and provide this url to them
}

if(empty($status)||empty($phone)){
  echo show_output('FAILURE');
  //exit; teting uncomment this line when live
}


$varCondition	= " WHERE PhoneNo=".$objRegister->doEscapeString($phone,$objRegister)." AND HOUR(sec_to_time(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(DateInserted)))<23 ORDER BY DateInserted DESC LIMIT 1";
$varFields		= array('MatriId');
$varResults		= $objRegister->select($varTable['ASSUREDCLICKTOCALLLOG'],$varFields,$varCondition,1);
$varMatriId	= $varResults[0]['MatriId'];

if(count($varResults)<1){
  echo show_output('FAILURE');
  //exit; teting uncomment this line when live
}else{
	if($status==1){
		fnPhoneVerify($varMatriId);
	}
}



//echo "hai dsf";exit;

function show_output($msg){
  return "<?xml version='1.0' encoding='UTF-8'?><pinphonevalidation><response>".$msg."</response></pinphonevalidation>";
}


function fnPhoneVerify($sMatriId){
  global $objRegister,$varTable;
	$varCondition	= " WHERE MatriId=".$objRegister->doEscapeString($sMatriId,$objRegister);
	$varFields		= array('PinNo','MatriId','PhoneNo1','ContactPerson1','Relationship1','Timetocall1','Description','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','ThruRegistration','VerifiedFlag','VerificationSource');
	$varBeforeValidationResults		= $objRegister->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varFields,$varCondition,1);

	if(count($varBeforeValidationResults)>0){
		$varPinNo			= trim($varBeforeValidationResults[0]['PinNo']);
		$varMatriId			= trim($varBeforeValidationResults[0]['MatriId']);
		$varPhoneNo1		= trim($varBeforeValidationResults[0]['PhoneNo1']);
		$varCntPeron		= trim($varBeforeValidationResults[0]['ContactPerson1']);
		$varRelationship	= trim($varBeforeValidationResults[0]['Relationship1']);
		$varTimetocall		= trim($varBeforeValidationResults[0]['Timetocall1']);
		$varDescription		= trim($varBeforeValidationResults[0]['Description']);
		$varTimeGenerated	= trim($varBeforeValidationResults[0]['TimeGenerated']);
		$varCtryCode		= trim($varBeforeValidationResults[0]['CountryCode']);
		$varAreaCode		= trim($varBeforeValidationResults[0]['AreaCode']);
		$varLandlineno		= trim($varBeforeValidationResults[0]['PhoneNo']);
		$varMobileno		= trim($varBeforeValidationResults[0]['MobileNo']);
		$varThruRegistration= trim($varBeforeValidationResults[0]['ThruRegistration']);
		$varVerifiedFlag	= trim($varBeforeValidationResults[0]['VerifiedFlag']);
		$varVeriSource		= trim($varBeforeValidationResults[0]['VerificationSource']);

		if($varVeriSource=='0' || $varVeriSource=='')
		  $varVeriSource=1;

		$varFields = array('MatriId','PinNo','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','TimeGenerated','DateConfirmed','VerifiedFlag','Description','VerificationSource','ThruRegistration');

		$varFieldsValues = array($objRegister->doEscapeString($varMatriId,$objRegister),$objRegister->doEscapeString($varPinNo,$objRegister),$objRegister->doEscapeString($varCtryCode,$objRegister),$objRegister->doEscapeString($varAreaCode,$objRegister),$objRegister->doEscapeString($varLandlineno,$objRegister),$objRegister->doEscapeString($varMobileno,$objRegister),$objRegister->doEscapeString($varPhoneNo1,$objRegister),"'1'",$objRegister->doEscapeString($varCntPeron,$objRegister),$objRegister->doEscapeString($varRelationship,$objRegister),$objRegister->doEscapeString($varTimetocall,$objRegister),$objRegister->doEscapeString($varTimeGenerated,$objRegister),"NOW()",$objRegister->doEscapeString($varVerifiedFlag,$objRegister),$objRegister->doEscapeString($varDescription,$objRegister),$objRegister->doEscapeString($varVeriSource,$objRegister),$objRegister->doEscapeString($varThruRegistration,$objRegister));

		$varResult=$objRegister->insertOnDuplicate($varTable['ASSUREDCONTACT'],$varFields,$varFieldsValues, $varMatriId);

		if($varResult==true)
	      echo show_output('SUCCESS');
		else
	      echo show_output('FAILURE');

		$varCondition		= "MatriId='".$varMatriId."'";
		//testing uncomment the below line
		//$rec_aff_count=$objRegister->delete($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varCondition); 
		$rec_aff_count=1;
		if($rec_aff_count==1){
			$varFields			= array('UsedStatus');
			$varFieldsValues	= array("'0'");
			$varCondition		= "PinNo='".$varPinNo."'";
			$res=$objRegister->update($varTable['ASSUREDCONTACTPINNOSERIES'],$varFields,$varFieldsValues,$varCondition);

		}
		$varCondition		= "MatriId='".$varMatriId."'";
		//testing uncomment the below line
		//$rec_aff_count=$objRegister->delete($varTable['ASSUREDCLICKTOCALLLOG'],$varCondition);
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
		$rec_aff_count=$objRegister->update($varTable['MEMBERINFO'],$varFields,$varFieldsValues,$varCondition);
		
		//MEMBERTOOL LOGIN
		$varType  = 1;
		$varField = $phoneverifiedflag;
		shell_exec('php /home/product/community/www/membertoollog/membertoolcheck.php '.escapeshellarg($varMatriId)." ".escapeshellarg($varType)." ".escapeshellarg($varField).' &' ); 
			


	}


}

?>