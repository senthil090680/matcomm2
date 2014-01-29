<?php
#=============================================================================================================
# Author 		: Baranidharan
# Start Date	: 2010-03-15
# End Date		: 2010-03-19
# Project		: Consim Leads
# Module		: Sending user details to leads submission page
#=============================================================================================================

//ini_set("display_errors", E_ALL);
//$_REQUEST['uid']='AGR102299';
include_once 'leads.inc';

$rType = $_REQUEST['reqtype'];

if(!$_REQUEST['uid']) {
  if($rType == 'xml') {
    $varResponse = "<?xml version='1.0' ?><response><error>NO userid</error></response>";
  }
  else if($rType == 'json') {
    $response['error'] = 'NO userid';
    $varResponse = json_encode($response);
  }
}
else {
  $varMatriId=base64_decode($_REQUEST['uid']);
  $varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
  include_once $varRootBasePath .'/www/cl/leads.class.php';
  $objLeads = new Leads($rType);
  $varResponse = $objLeads->getUserInfo($varMatriId, 'index');
  if($objLeads->clsErrorCode) {
    if($rType == 'xml') {
      $varResponse = "<?xml version='1.0' ?><response><error>Database Connection Failed</error></response>";
    }
    else if($rType == 'json') {
      $response['error'] = 'Database Connection Failed';
      $varResponse = json_encode($response);
    }
  }
}


echo $varResponse;
