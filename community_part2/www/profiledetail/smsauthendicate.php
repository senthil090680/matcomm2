<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-04
# Project	  : MatrimonyProduct
# Filename	  : phoneauthendicate.php
#=====================================================================================================================================
# Description : this file called from thru SMS
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//VARIABLE DECLARATION
$varMobileNum = trim($_GET['MOB']);

//OBJECT DECLARTION
$objDBSlave	= new DB;
$objDBMaster= new DB;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

if(strlen($varMobileNum) > 10) { $varMobileNum = substr($varMobileNum,2); }

//CHECK PHONE NO IS CORRECT OR NOT
$argCondition	= "WHERE PhoneNo1 LIKE '%~".$varMobileNum."'";
$varRecordAvail	= $objDBSlave->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriId',$argCondition);

if($varRecordAvail == 1) {
	//FETCHING RECORD FROM assuredcontactbeforevalidation
	$argCondition	= "WHERE PhoneNo1 LIKE '%~".$varMobileNum."'";
	$argFields		= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','ContactPerson1','Relationship1','Timetocall1','Description','VerificationSource','ThruRegistration');
	$varContactInfoResultSet	= $objDBSlave->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argFields,$argCondition,0);
	$varContactInfoResult		= mysql_fetch_assoc($varContactInfoResultSet);

	$varPinNo				= $varContactInfoResult['PinNo'];
	$varMatriId				= $varContactInfoResult['MatriId'];
	$varTimeGenerated		= $varContactInfoResult['TimeGenerated'];
	$varCountryCode			= $varContactInfoResult['CountryCode'];
	$varAreaCode			= $varContactInfoResult['AreaCode'];
	$varPhoneNo				= $varContactInfoResult['PhoneNo'];
	$varMobileNo			= $varContactInfoResult['MobileNo'];
	$varSelectedPhoneNo		= $varContactInfoResult['PhoneNo1'];
	$varPhoneStatus			= 1;
	$varContactPerson		= $varContactInfoResult['ContactPerson1'];
	$varRelationship		= $varContactInfoResult['Relationship1'];
	$varTimetocall			= $varContactInfoResult['Timetocall1'];
	$varDescription			= $varContactInfoResult['Description'];
	$varVerificationSource	= 5; //thru SMS
	$varThruRegistration	= $varContactInfoResult['ThruRegistration'];

	//CHECK MASTER ENTRY IS THERE OR NOT
	$argCondition			= "WHERE MatriId =".$objDBSlave->doEscapeString($varMatriId,$objDBSlave);
	$varMasterRecordAvail	= $objDBSlave->numOfRecords($varTable['ASSUREDCONTACT'],'MatriId',$argCondition);

	if($varMasterRecordAvail == 1) {
		$varVerificationSource	= 5;
		
		//UPDATE INTO MASTER TABLE
		$argFields 			= array('PinNo','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','DateConfirmed','Description','VerificationSource','ThruRegistration');
		$argFieldsValues	= array("'".$varPinNo."'","'".$varTimeGenerated."'","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varSelectedPhoneNo."'","'".$varPhoneStatus."'","'".$varContactPerson."'","'".$varRelationship."'","'".$varTimetocall."'","NOW()","'".$varDescription."'","'".$varVerificationSource."'","'".$varThruRegistration."'");
		$argCondition		= " MatriId = ".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
		$varInsertId		= $objDBMaster->update($varTable['ASSUREDCONTACT'],$argFields,$argFieldsValues,$argCondition);
	} else {
		//INSERT INTO MASTER TABLE
		$argFields			= array('PinNo','MatriId','TimeGenerated','CountryCode','AreaCode','PhoneNo','MobileNo','PhoneNo1','PhoneStatus1','ContactPerson1','Relationship1','Timetocall1','DateConfirmed','VerifiedFlag','Description','VerificationSource','ThruRegistration');
		$argFieldsValues	= array("'".$varPinNo."'",$objDBMaster->doEscapeString($varMatriId,$objDBMaster),"'".$varTimeGenerated."'","'".$varCountryCode."'","'".$varAreaCode."'","'".$varPhoneNo."'","'".$varMobileNo."'","'".$varSelectedPhoneNo."'","'".$varPhoneStatus."'","'".$varContactPerson."'","'".$varRelationship."'","'".$varTimetocall."'","NOW()","'".$varVerifiedFlag."'","'".$varDescription."'","'".$varVerificationSource."'","'".$varThruRegistration."'");
		$varInsertId		= $objDBMaster->insert($varTable['ASSUREDCONTACT'],$argFields,$argFieldsValues);
	}

	if($varInsertId >= 0) {
		$globalMailer1Flag = 0;

		//for members who are coming for verified phone 1st mailer
		if((trim($varContactPerson) == '') && (trim($varRelationship) == 0) && (trim($varTimetocall) == '')){
			$globalMailer1Flag = 1; //member trying to verify from the first mailer using the ph no and pin no
		}
	
		// update verified_mast table //
		//contact details empty so set verifisource as 6
		if($globalMailer1Flag == 1){
			$argFields 			= array('PhoneStatus1','VerifiedFlag','DateConfirmed','VerificationSource');
			$argFieldsValues	= array("1","1","'NOW()'","6");
			$argCondition		= " MatriId = ".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varInsertId		= $objDBMaster->update($varTable['ASSUREDCONTACT'],$argFields,$argFieldsValues,$argCondition);
		}else{
			$argFields 			= array('PhoneStatus1','VerifiedFlag','DateConfirmed','VerificationSource');
			$argFieldsValues	= array("1","1","'NOW()'","5");
			$argCondition		= " MatriId = ".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varInsertId		= $objDBMaster->update($varTable['ASSUREDCONTACT'],$argFields,$argFieldsValues,$argCondition);
		}

		//UPDATE meberinfo TABLE

		//contact details empty so set phoneverified=2
		if($globalMailer1Flag == 1){
			/*if($dattemp["ThruRegistration"] == '1') { $varPhoneVerified=3; }
			else { $varPhoneVerified=2; }*/
			$varPhoneVerified=1;
			$argFields 		= array('Phone_Verified','Date_Updated');
			$argFieldsValues= array("'".$varPhoneVerified."'","NOW()");
			$argCondition	= "MatriId=".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
		}else{
			$argFields 		= array('Phone_Verified','Date_Updated');
			$argFieldsValues= array("1","NOW()");
			$argCondition	= "MatriId=".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
		}

		echo "Congrats! Your number has been verified and will be on your BharatMatrimony profile. Thank you for using this service.";

		if($varInsertId >= 0) {
			//DELETE FROM Temporary table (assuredcontactbeforevalidation)
			$argCondition	= "MatriId=".$objDBMaster->doEscapeString($varMatriId,$objDBMaster);
			$varDeleteId	= $objDBMaster->delete($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argCondition);

			//UPDATE UsedStatus=0 IN assuredcontactpinnoseries table
			if($varDeleteId > 0) {
				$argFields 		= array('UsedStatus');
				$argFieldsValues= array(0);
				$argCondition	= "PinNo='".$varPinNo."'";
				$varUpdateId	= $objDBMaster->update($varTable['ASSUREDCONTACTPINNOSERIES'],$argFields,$argFieldsValues,$argCondition);
			}
		}
	} else {
		/*echo "Congrats! Your number has been verified and will be on your BharatMatrimony profile. Thank you for using this service.";
		putenv("MAILUSER=bharat"); 
		putenv("MAILHOST=server.bharatmatrimony.com");
		$from = "info@bharatmatrimony.com";
		$from_header = "MIME-Version: 1.0\n";
		$from_header .= "Content-type: text/plain; charset=iso-8859-1\n";
		$from_header .= "From: $from <$from>\n";
		$from_header .= "Reply-To: info@bharatmatrimony.com <info@bharatmatrimony.com>\n";
		//insert the id failed in sms validation 
		$dblink14 = new db();
		$dblink14->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ASSUREDCONTACT']);
		$sqlsmsvalidfail = "insert into assuredcontact.assuredcontactsmsvalidationfailed(ContactNo,DateUpdated) values('".trim($_GET['MOB'])."',NOW()) on duplicate key update DateUpdated=NOW()";
		$ressmsvalidfail = $dblink14->insert($sqlsmsvalidfail);
		$dblink14->dbClose();
		//end sms validation*/
	}

} else {
	//CHECK MASTER TABLE HAS ENTRY FOR THIS PHONE NO
	$argCondition	= "WHERE PhoneNo1 LIKE '%~".$varMobileNum."'";
	$varCntOfRec	= $objDBSlave->numOfRecords($varTable['ASSUREDCONTACT'],'MatriId',$argCondition);

	/*// check in master for any record. //
	$sql_phone_mast = "select MatriId from ".$assuredcontacttable." where PhoneNo1 like '%~".$mobile_num."'";
	$resultmast = $db_standalone->select($sql_phone_mast);
	if($resultmast>0){
	echo "Congrats! Your number has been verified and will be on your BharatMatrimony profile. Thank you for using this service.";
	} else {
		echo "Sorry! You need to enter your primary phone details online and then confirm your phone number through SMS.";
		//insert the id failed in sms validation
		$assuredcontactsmsfail = $DBNAME['ASSUREDCONTACT'].".".$TABLE['ASSUREDCONTACTSMSVALIDATIONFAILED'];
		$dblink14 = new db();
		$dblink14->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ASSUREDCONTACT']);
		$sqlsmsvalidfail = "insert into assuredcontact.assuredcontactsmsvalidationfailed(ContactNo,DateUpdated) values('".trim($_GET['MOB'])."',NOW()) on duplicate key update DateUpdated=NOW()";
		$ressmsvalidfail = $dblink14->insert($sqlsmsvalidfail);
		$dblink14->dbClose();
		//end sms validation
	}
	$db_standalone->dbClose();*/
}
?>