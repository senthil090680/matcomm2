<?php
#=============================================================================================================
# Author 		: Baranidharan
# Start Date	: 2010-03-15
# End Date		: 2010-03-19
# Project		: Consim Leads
# Module		: Showing leads
#=============================================================================================================

//ini_set("display_errors", E_ALL);
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $varRootBasePath. '/conf/cookieconfig.inc';
include_once $varRootBasePath. '/www/cl/leads.inc';



if(!$varGetCookieInfo['MATRIID']) {
  echo "No Matri Id";
}
else { // matriid available
  $varMatriId=$varGetCookieInfo['MATRIID'];

  include_once $varRootBasePath .'/www/cl/leads.class.php';
  $objLeads = new Leads($reqType);
  $varRequest = $objLeads->getUserInfo($varMatriId, 'getoffer');
  if(!$objLeads->clsErrorCode) { // no db error
    $varResponse = $objLeads->sendCurlRequest($varUrl, $varRequest);
    if($varResponse) { // response available
      echo 'Sponsered Ads:<br>';
      if($reqType == 'xml') {
        $arrRes = get_object_vars(new SimpleXMLElement($varResponse, LIBXML_NOCDATA));
      }
      else if($reqType == 'json') {
        $arrRes = get_object_vars(json_decode($varResponse));
      }

      foreach($adCategory as $value) {
        $val = preg_replace("/[\s\W]/", "", $value);
        echo $value ."<br />";
        if($arrRes[$val]->ads == 1 && $reqType == 'xml') {
          echo "<a href='". urldecode($arRes[$val]->ad->link) ."' target='_blank' >";
          echo $arrRes[$val]->ad->teaser_text;
          //echo "<img src='". urldecode($arrRes[$val]->ad->teaser_image) ."' />";
          echo "</a>";
          echo " ";
        }
        else { // multiple xml response
          for($i=0; $i<$arrRes[$val]->ads; $i++) { // multiple xml / json response
            echo "<a href='". urldecode($arrRes[$val]->ad[$i]->link) ."' target='_blank' >";
            echo $arrRes[$val]->ad[$i]->teaser_text;
            //echo "<img src='". urldecode($arrRes[$val]->ad[$i]->teaser_image) ."' />";
            echo "</a>";
            echo " ";
          } // multiple xml / json response for
        } // multiple xml response else
        echo "<a href='". urldecode($arrRes[$val]->more) ."' target='_blank' >More...</a><br /><br />";
      }

    } // response available if
  } // no db error if
} // matriid available else
