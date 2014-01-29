<?php
/*
#=============================================================================================================
# Author  : M Baranidharan
# Start Date : 2010-03-16
# End Date  : 2010-03-19
# Project  : Consim Leads
# Module  : Class file contains methods needed for consim leads 
#=============================================================================================================
*/
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath. '/conf/dbinfo.inc');
include_once($varRootBasePath. '/lib/clsDB.php');
include_once($varRootBasePath. '/conf/vars.inc');
include_once($varRootBasePath. '/conf/cityarray.inc');

class Leads extends DB {

  private $reqType;

  public function __construct($argType) {
    $this->reqType = $argType;
  }

  public function getUserInfo($varMatriId, $varType) {
    global $varDbInfo, $varTable,$residingCityStateMappingList,$arrCountryList,$arrOccupationList;
    $this->dbConnect('S', $varDbInfo['DATABASE']);
    if(!$this->clsErrorCode) {
      $argFields = array('MatriId', 'Name', 'Gender', 'Age','Dob','Annual_Income', 'Occupation', 'Residing_State','Residing_District','Residing_City', 'Country', 'Phone_Verified', 'Email_Verified');
      $argCondition = " WHERE MatriId = '".$varMatriId."'";
      $varExecute = $this->select($varTable['MEMBERINFO'], $argFields, $argCondition, 0);
      if(!$this->clsErrorCode) {
        $varUserInfo = mysql_fetch_assoc($varExecute);
       // if($varType == 'getoffer') {
		  if($varUserInfo['Country'] == 98) {
		    global ${$residingCityStateMappingList[$varUserInfo['Residing_State']]};

            $arrTempCity = ${$residingCityStateMappingList[$varUserInfo['Residing_State']]};
		    $varUserInfo['Residing_City'] = $arrTempCity[$varUserInfo['Residing_District']];
          }
		  $varUserInfo['Gender'] = ($varUserInfo['Gender'] == 2 )?'Female':'Male';
		  $varUserInfo['Country'] = $arrCountryList[$varUserInfo['Country']];
		  $varUserInfo['Occupation'] = $arrOccupationList[$varUserInfo['Occupation']];		  
		  
		  if($varUserInfo['Phone_Verified']) {
		     $argFields = array('PhoneNo1');
             $argCondition = " WHERE MatriId = '".$varMatriId."'";
             $varExecute = $this->select($varTable['ASSUREDCONTACT'], $argFields, $argCondition, 0);
             $varResRow=mysql_fetch_assoc($varExecute);
			 $varTemp = explode('~',$varResRow['PhoneNo1']);
             $varCount=count($varTemp);
             if($varCount == 2) {
                $varUserInfo['Phone_Verified'] = $varTemp[1];
            	$varUserInfo['Std']=$varUserInfo['Landline']='';
             }
             else if($varCount == 3) {
                $varUserInfo['Phone_Verified'] = '';
	            $varUserInfo['Std'] = $varTemp[1];
	            $varUserInfo['Landline'] = $varTemp[2];
             }
             else {
                $varUserInfo['Phone_Verified']=$varUserInfo['Std']=$varUserInfo['Landline']='';
             }
		  }
         
		  if($varUserInfo['Email_Verified']) {
		     $argFields = array('Email');
             $argCondition = " WHERE MatriId = '".$varMatriId."'";
             $varExecute = $this->select($varTable['MEMBERLOGININFO'], $argFields, $argCondition, 0);
			 $varResRow=mysql_fetch_assoc($varExecute);
			 $varUserInfo['Email_Verified'] = $varResRow['Email'];
		  }
		  foreach($varUserInfo as $key => $value) {
			if(!$value) { 
              $value=" "; 
            }
            $varUserInfo[$key] = $value;
          }

        //}

        if($this->reqType == 'xml') {
          $response = '<?xml version="1.0" ?>
          <response>
          <matriid>'. $varUserInfo['MatriId'] .'</matriid>
          <fields>
          <Gender><![CDATA['. $varUserInfo['Gender'] .']]></Gender>
          <Age><![CDATA['. $varUserInfo['Age'] .']]></Age>
          <Annualincome><![CDATA['. (int)$varUserInfo['Annual_Income'] .']]></Annualincome>
          <Designation><![CDATA['. $varUserInfo['Occupation'] .']]></Designation>
          <City><![CDATA['. $varUserInfo['Residing_City'] .']]></City>
          <Country><![CDATA['. $varUserInfo['Country'] .']]></Country>
          <Name><![CDATA['. $varUserInfo['Name'] .']]></Name>
          <Phone><![CDATA['. $varUserInfo['Phone_Verified'] .']]></Phone>
          <Email><![CDATA['. $varUserInfo['Email_Verified'] .']]></Email>
          <Dob><![CDATA['. $varUserInfo['Dob'] .']]></Dob>
		  <Std><![CDATA['. $varUserInfo['Std'] .']]></Std>
		  <Landline><![CDATA['. $varUserInfo['Landline'] .']]></Landline>
          </fields>
          </response>';
        }
        else if($this->reqType == 'json') {
          $arReq['matriid'] = $varUserInfo['MatriId'];
          $arReq['fields']['Gender'] = $varUserInfo['Gender'];
          $arReq['fields']['Age'] = $varUserInfo['Age'];
          $arReq['fields']['Annualincome'] = (int)$varUserInfo['Annualincome'];
          $arReq['fields']['Designation'] = $varUserInfo['Occupation'];
          $arReq['fields']['City'] = $varUserInfo['Residing_City'];
          $arReq['fields']['Country'] = $varUserInfo['Country'];
          $arReq['fields']['Name'] = $varUserInfo['Name'];
          $arReq['fields']['Phone'] = $varUserInfo['Phone_Verified'];
          $arReq['fields']['Email'] = $varUserInfo['Email_Verified'];
          $arReq['fields']['Dob'] = $varUserInfo['Dob'];
          $arReq['fields']['Std'] = $varUserInfo['Std'];
          $arReq['fields']['Landline'] = $varUserInfo['Landline'];
		  $response = json_encode($arReq);
        }

        return $response;
      }
    }
  }

  public function sendCurlRequest($varUrl, $varRequest) {
    $postFields['qry'] = $varRequest;
    //$url = "http://192.168.2.200/consimleads/www/?req=wsapi";
    $con = curl_init($varUrl);

    curl_setopt ($con, CURLOPT_POST, true);
    curl_setopt ($con, CURLOPT_POSTFIELDS, $postFields);

    curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($con, CURLOPT_TIMEOUT, 30);
    //curl_setopt($con, CURLOPT_USERPWD, $varTwitterUserName.':'.$varTwitterPassword);

    $varResponse = curl_exec($con);
    curl_close($con);
    return $varResponse;
  }

}

?>
