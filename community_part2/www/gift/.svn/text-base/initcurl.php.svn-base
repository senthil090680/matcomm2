<?php
#====================================================================================================
# Author 		: Mariyappan C
# Start Date	: 01 March 2011
# Project		: MatrimonyProduct
# Module		: MatrimonyGift - API
#====================================================================================================

# BASE ROOT
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
# FILE INCLUDES
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");



# Decryption Key
 $varKey           =  'M10u2S78ru0G8aIV276el';

# Decryption function
function dodecrypt($key,$string) {
        $result = '';
        $string = base64_decode(gzinflate(base64_decode($string)));
        for($i=0; $i<strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)-ord($keychar));
                $result.=$char;
        }
        return $result;
}


//ERROR MESSAGE
$varErrorMsg        = "Failure~Matrimony Id/Email or Password is invalid";

# DEFINE AUTHENTICATIONS

define('ACCESS_USER','matrimonygifts');
define('ACCESS_PASS','m@TriM0nyg1ft$');


if(isset($_SERVER['PHP_AUTH_USER']) && trim($_SERVER['PHP_AUTH_USER']) == ACCESS_USER && isset($_SERVER['PHP_AUTH_PW']) && trim($_SERVER['PHP_AUTH_PW']) == ACCESS_PASS) {
     

//OBJECT DECLARTION
$objSlaveDB  = new DB;

//DB CONNECTION
$objSlaveDB->dbConnect('S',$varDbInfo['DATABASE']);


//REQUEST FROM CURL 
$varMatriId  = dodecrypt($varKey,$_POST['LOGIN_ID']);
$varPassword = dodecrypt($varKey,$_POST['LOGIN_PASSWORD']);

//DOMAIN CHECK
$varMatriId			= strtoupper(strtolower(trim($varMatriId)));
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];



if($varCBSDomainName!="") {


	//WHERE CONDITIONS
    $argCondition = " WHERE MatriId=".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB)." AND Password=".$objSlaveDB->doEscapeString($varPassword,$objSlaveDB).""; 
    $argFields    = array('MatriId','email');
    $varExecute   = $objSlaveDB->select($varTable['MEMBERLOGININFO'], $argFields, $argCondition,0);
	$varSelectLoginInfo1= mysql_fetch_assoc($varExecute);
    $varEmailId   = $varSelectLoginInfo1["email"];
	if($varSelectLoginInfo1["MatriId"]) {

		//GET EMAIL        
        $argFields    = array('User_Name','MatriId','Name','Nick_Name','Gender','Status');
        $argCondition = " WHERE MatriId = ".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB)."";
        $varExecute   = $objSlaveDB->select($varTable['MEMBERINFO'], $argFields, $argCondition,0);
        $varSelectLoginInfo = mysql_fetch_assoc($varExecute); 

        //GET PROFILE DETAILS 
        $varName       = $varSelectLoginInfo["Name"];
	    $varNickName   = $varSelectLoginInfo["Nick_Name"];
        $varGender     = $varSelectLoginInfo['Gender'];
	    $varStatus     = $varSelectLoginInfo['Status']; 
	   
        //CHECK PROFILE STATUS  
        if($varStatus==0) { // Profile Not Validated
		    $argFields       = array('CountryCode','AreaCode','PhoneNo','MobileNo');
		    $argCondition    = " WHERE MatriId = ".$objSlaveDB->doEscapeString($varMatriId,$objSlaveDB)."";
            $varExecute      = $objSlaveDB->select($varTable['ASSUREDCONTACTBEFOREVALIDATION'], $argFields,  $argCondition,0);
            $varSelectContactInfo = mysql_fetch_assoc($varExecute);
            $varCountryCode  = $varSelectContactInfo["CountryCode"];
		    $varAreaCode     = $varSelectContactInfo["AreaCode"];
		    $varPhoneNo      = $varSelectContactInfo["PhoneNo"];
		    $varMobileNo     = $varSelectContactInfo["MobileNo"];
        } else { // Profile Validated
		    $argFields            = array('CountryCode','AreaCode','PhoneNo','MobileNo');
		    $argCondition         = " WHERE MatriId = '".$varMatriId."'";
		    $varExecute           = $objSlaveDB->select($varTable['ASSUREDCONTACT'], $argFields, $argCondition,0);
		    $varSelectContactInfo = mysql_fetch_assoc($varExecute);
		    $varCountryCode       = $varSelectContactInfo["CountryCode"];
		    $varAreaCode          = $varSelectContactInfo["AreaCode"];
		    $varPhoneNo           = $varSelectContactInfo["PhoneNo"];
		    $varMobileNo          = $varSelectContactInfo["MobileNo"];
       }

    //DISPLAY OUTPUT  
	$varMatriDetails="Success~$varNickName~$varEmailId~$varAreaCode~$varPhoneNo~$varCountryCode~$varMobileNo";
    echo $varMatriDetails;

    $objSlaveDB->dbClose();
    UNSET($objSlaveDB);

   } else {
	  echo "$varErrorMsg";
    }

 } else {
	  echo "$varErrorMsg";
  }

} else {
     echo "Authuntication Failed";
  }

?>