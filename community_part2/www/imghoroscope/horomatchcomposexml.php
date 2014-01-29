<?php
#================================================================================================================
# Author 	: Srinivasan
# Date		: 18-May-2010
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
# Used For  : horoscope match details
#================================================================================================================
//FILE INCLUDES
$varRootBasePath	= '/home/product/community';

include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/horoscope.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");
include_once($varRootBasePath."/lib/clsHoroscope.php");

//include_once($varRootBasePath."/www/profiledetail/settingsheader.php");
include_once "horomatchfunctions.php";


//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessGender		= $varGetCookieInfo["GENDER"];

//OBJECT INITIALIZATION
$objSlaveDB		= new MemcacheDB;
$objMasterDB	= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//HORO URL
$callpage="http://www.astrovisiononline.com/BharathMatrimony/test/";

$varDomainPrefix	= substr($sessMatriId,0,3);
$varFolderName		= $arrFolderNames[$varDomainPrefix];


//INCLUDE SCRIPT FILE
echo '<script src="'.$confValues["IMAGEURL"].'/scripts/horomatchcheckdetails.js" language="javascript"></script>';
$varHoroURL	= 'http://image.communitymatrimony.com/membershoroscope/'.$varFolderName.'/'.$sessMatriId{3}.'/'.$sessMatriId{4}.'/';

//check for cookie
if(isset($sessMatriId)) 
{
  $findlogingend = $_POST["findlogingend"];
  $mregno        = $_POST['M_REGNO'];
  $mpersonfname  = eregi_replace(","," ",trim($_POST['M_PERSON_FNAME']));
  $mbirthday     = $_POST['M_BIRTH_DAY'];
  $mbirthmonth	 = $_POST['M_BIRTH_MONTH'];
  $mbirthyear	 = $_POST['M_BIRTH_YEAR'];
  $mbirthhour	 = $_POST['M_BIRTH_HOUR'];
  $varPartnerId  = $_POST['F_REGNO'];

  

  if(trim($findlogingend) != "F" || trim($_POST["partnervalue"]) == 1) //other member is a male so no 24 hrs conversion. becoz already v r displaying  time in 24hrs in the form for the male member. But if v r display the values for the partner v need to do the 24 hr conversion.
  {
    if(trim($_POST["M_BirthMedian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
    {
      if(trim($_POST["M_BirthMedian"]) == "PM")
      {
        //SINCE ITS IN PM ADD 12 HRS TO THE EXISTING HR.
        $mbirthhour = $mbirthhour + 12;
        if(trim($mbirthhour) == 24)
        {
          $mbirthhour = trim($_POST['M_BIRTH_HOUR']); //since its comes to 24 use 12 itself. otherwise use the calculated time(hr +12)
        }
      }
    }

    if(trim($_POST["M_BirthMedian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
    {
      if(trim($_POST["M_BirthMedian"]) == "AM")
      {
        //SINCE ITS 12 AM it has to be changed to 0 hrs.
        if(trim($mbirthhour) == 12)
          $mbirthhour = 0;
      }
    }
  }

  $mbirthmin			= $_POST['M_BIRTH_MIN'];
  $mbirthsec			= $_POST['M_BIRTH_SEC'];
  $mtimecorrection		= $_POST['M_TIMECORRECTION'];
  $mcountries			= $_POST['M_Countries'];
  $mstates				= $_POST['M_States'];
  $mbirthplacename		= $_POST['M_BIRTH_PLACE_NAME'];
  if(trim($mbirthplacename) == "")
    $mbirthplacename	= $_POST["M_Cities"];
  $mplacelongitudehour	= $_POST['M_PLACE_LONGITUDE_HOUR'];
  $mplacelongitudemin	= $_POST['M_PLACE_LONGITUDE_MIN'];
  $mplacelatitudehour	= $_POST['M_PLACE_LATITUDE_HOUR'];
  $mplacelatitudemin	= $_POST['M_PLACE_LATITUDE_MIN'];
  $mplacelongitudedir	= $_POST['M_PLACE_LONGITUDE_DIR'];
  $mplacelatitudedir	= $_POST['M_PLACE_LATITUDE_DIR'];
  $mtimezone			= $_POST['M_TIMEZONE'];

  $fregno				= $_POST['F_REGNO'];
  $fpersonfname			= eregi_replace(","," ",trim($_POST['F_PERSON_FNAME']));
  $fbirthday			= $_POST['F_BIRTH_DAY'];
  $fbirthmonth			= $_POST['F_BIRTH_MONTH'];
  $fbirthyear			= $_POST['F_BIRTH_YEAR'];
  $fbirthhour			= $_POST['F_BIRTH_HOUR'];

  if(trim($findlogingend) != "M" || trim($_POST["partnervalue"]) == 1) //other member is a female so no 24 hrs conversion. becoz already v r displaying  time in 24hrs in the form for this female member. But if v r display the values for the partner v need to do the 24 hr conversion.
  {
    if(trim($_POST["F_BirthMedian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
    {
      if(trim($_POST["F_BirthMedian"]) == "PM")
      {
        //SINCE ITS IN PM ADD 12 HRS TO THE EXISTING HR.
        $fbirthhour = $fbirthhour + 12;
        if(trim($fbirthhour) == 24) 
        {
          $fbirthhour = trim($_POST['F_BIRTH_HOUR']); //since its comes to 24 use 12 itself. otherwise use the calculated time(hr +12)
        }
      }
    }

    if(trim($_POST["F_BirthMedian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
    {
      if(trim($_POST["F_BirthMedian"]) == "AM")
      {
        //SINCE ITS 12 AM it has to be changed to 0 hrs
        if(trim($fbirthhour) == 12) 
          $fbirthhour = 0;
      }
    }
  }

  $fbirthmin			= $_POST['F_BIRTH_MIN'];
  $fbirthsec			= $_POST['F_BIRTH_SEC'];
  $ftimecorrection		= $_POST['F_TIMECORRECTION'];
  $fcountries			= $_POST['F_Countries'];
  $fstates				= $_POST['F_States'];
  $fbirthplacename		= $_POST['F_BIRTH_PLACE_NAME'];
  if(trim($fbirthplacename) == "")
    $fbirthplacename = $_POST["F_Cities"];

  $fplacelongitudehour	= $_POST['F_PLACE_LONGITUDE_HOUR'];
  $fplacelongitudemin	= $_POST['F_PLACE_LONGITUDE_MIN'];
  $fplacelatitudehour	= $_POST['F_PLACE_LATITUDE_HOUR'];
  $fplacelatitudemin	= $_POST['F_PLACE_LATITUDE_MIN'];
  $fplacelongitudedir	= $_POST['F_PLACE_LONGITUDE_DIR'];
  $fplacelatitudedir	= $_POST['F_PLACE_LATITUDE_DIR'];
  $ftimezone			= $_POST['F_TIMEZONE'];
  $custid				= $_POST['CUSTID'];
  $reportchartformat	= '1';//$_POST['REPORT_CHART_FORMAT'];
  $reportlanguage		= $_POST['REPORT_LANGUAGE'];
  $reporttype			= $_POST['REPORT_TYPE'];
  $method				= $_POST['METHOD'];
  $kujadosha			= $_POST['KUJADOSHA'];
  $papasamya			= $_POST['PAPASAMYA'];
  $dasasandhi			= $_POST['DASASANDHI'];

  //Male
  settype($mplacelongitudehour,"integer");
  if  ($mplacelongitudehour <10 )
  {
    $mplacelongitudehour = '00' .$mplacelongitudehour ;
  }
  else if(($mplacelongitudehour >10) && ($mplacelongitudehour <100))
  {
  $mplacelongitudehour = '0'.$mplacelongitudehour ;
  }
  settype($mplacelongitudemin,"integer");
  if($mplacelongitudemin < 10 )
  {
    $mplacelongitudemin = '0'.$mplacelongitudemin;
  }
  settype($mplacelatitudehour,"integer");
  if ($mplacelatitudehour < 10)
  {
    $mplacelatitudehour ='0'.$mplacelatitudehour ;
  }
  settype($mplacelatitudemin,"integer");
  if($mplacelatitudemin < 10)
  {
    $mplacelatitudemin = '0'.$mplacelatitudemin ;
  }

  //Female
  settype($fplacelongitudehour,"integer");
  if  ($fplacelongitudehour <10 )
  {
    $fplacelongitudehour = '00' .$fplacelongitudehour ;
  }
  else if(($fplacelongitudehour >10) && ($fplacelongitudehour <100))
  {
  $fplacelongitudehour = '0'.$fplacelongitudehour ;
  }
  settype($fplacelongitudemin,"integer");
  if($fplacelongitudemin < 10 )
  {
    $fplacelongitudemin = '0'.$fplacelongitudemin;
  }
  settype($fplacelatitudehour,"integer");
  if ($fplacelatitudehour < 10)
  {
    $fplacelatitudehour ='0'.$fplacelatitudehour ;
  }
  settype($fplacelatitudemin,"integer");
  if($fplacelatitudemin < 10)
  {
    $fplacelatitudemin = '0'.$fplacelatitudemin ;
  }

  //new coding
  settype($mbirthhour,"integer");
  if($mbirthhour < 10)
  {
    $mbirthhour = '0'.$mbirthhour ;
  }
  settype($mbirthmin,"integer");
  if($mbirthmin < 10)
  {
    $mbirthmin = '0'.$mbirthmin ;
  }
  settype($mbirthsec,"integer");
  if($mbirthsec < 10)
  {
    $mbirthsec = '0'.$mbirthsec ;
  }

  settype($fbirthhour,"integer");
  if($fbirthhour < 10)
  {
    $fbirthhour = '0'.$fbirthhour ;
  }
  settype($fbirthmin,"integer");
  if($fbirthmin < 10)
  {
    $fbirthmin = '0'.$fbirthmin ;
  }
  settype($fbirthsec,"integer");
  if($fbirthsec < 10)
  {
    $fbirthsec = '0'.$fbirthsec ;
  }
  //end new coding

  $mtzone=substr($mtimezone,0,5);
  if(trim($mtzone) == 0)
    $mtzone = '00:00';
  $mtzdir =substr($mtimezone,5,1);
  if(trim($mtzdir) == "")
    $mtzdir = "W";

  $ftzone=substr($ftimezone,0,5);
  if(trim($ftzone) == 0)
    $ftzone = '00:00';
  $ftzdir =substr($ftimezone,5,1);
  if(trim($ftzdir) == "")
    $ftzdir = "W";

  //MALE
  $mplacelongitude = $mplacelongitudehour."~".$mplacelongitudemin."~".$mplacelongitudedir;
  $mplacelatitude  = $mplacelatitudehour."~".$mplacelatitudemin."~".$mplacelatitudedir;
  $mremarks = addslashes(trim($_POST["M_remarks"]));
  //FEMALE
  $fplacelongitude = $fplacelongitudehour."~".$fplacelongitudemin."~".$fplacelongitudedir;
  $fplacelatitude  = $fplacelatitudehour."~".$fplacelatitudemin."~".$fplacelatitudedir;
  $fremarks = addslashes(trim($_POST["F_remarks"]));

  //finding login member's gender for storing in db.
  $findlogingend   = $_POST["findlogingend"];

    $strtext =  "<DATA><BOYDATA><REGNO>$mregno</REGNO><NAME>$mpersonfname</NAME><DAY>$mbirthday</DAY><MONTH>$mbirthmonth</MONTH><YEAR>$mbirthyear</YEAR><TIME24HR>$mbirthhour.$mbirthmin.$mbirthsec</TIME24HR><CORR>$mtimecorrection</CORR><PLACE>$mbirthplacename</PLACE><LONG>$mplacelongitudehour.$mplacelongitudemin</LONG><LAT>$mplacelatitudehour.$mplacelatitudemin</LAT><LONGDIR>$mplacelongitudedir</LONGDIR><LATDIR>$mplacelatitudedir</LATDIR><TZONE>$mtzone</TZONE><TZONEDIR>$mtzdir</TZONEDIR></BOYDATA><GIRLDATA><REGNO>$fregno</REGNO><NAME>$fpersonfname</NAME><DAY>$fbirthday</DAY><MONTH>$fbirthmonth</MONTH><YEAR>$fbirthyear</YEAR><TIME24HR>$fbirthhour.$fbirthmin.$fbirthsec</TIME24HR><CORR>$ftimecorrection</CORR><PLACE>$fbirthplacename</PLACE><LONG>$fplacelongitudehour.$fplacelongitudemin</LONG><LAT>$fplacelatitudehour.$fplacelatitudemin</LAT><LONGDIR>$fplacelongitudedir</LONGDIR><LATDIR>$fplacelatitudedir</LATDIR><TZONE>$ftzone</TZONE><TZONEDIR>$ftzdir</TZONEDIR></GIRLDATA><OPTIONS><CUSTID>$custid</CUSTID><CHARTSTYLE>$reportchartformat</CHARTSTYLE><LANGUAGE>$reportlanguage</LANGUAGE><REPTYPE>1</REPTYPE><REPDMN>community</REPDMN><HOROURL>".$varHoroURL."</HOROURL><PSETTINGS><METHOD>$method</METHOD><KUJADOSHACHECK>$kujadosha</KUJADOSHACHECK><PAPASAMYA>$papasamya</PAPASAMYA><DASACHECK>$dasasandhi</DASACHECK></PSETTINGS></OPTIONS></DATA>";  
	
	if(trim($findlogingend) == "M")
    {
      $loginmemberid = $mregno;
      $partnerid     = $fregno;
    }
    else if(trim($findlogingend) == "F")
    {
      $loginmemberid = $fregno;
      $partnerid     = $mregno;
    }
    $loginhas   = '';
    $partnerhas = '';

?>
<div class="normtxt1 clr2 padb5"><font class="clr bld">AstroMatch</font></div>
	<div class="linesep"><img src="<?=$confValues["IMAGEURL"];?>/images/trans.gif" width="1" height="1"></div><br clear="all">

<!-- Content Area -->
<div style="width:543px;">
  <div class="bl"><div class="br">
   <div style="padding:0px 17px 10px 17px;">
   <div style="padding:0px 15px 10px 15px;">
   <!-- Middle form start -->
<?
    if($objSlaveDB->error || $objMasterDB->error){
	
?>
  <div class="smalltxt" style="margin-left:5px;">
    <div class="mediumtxt1 boldtxt" style="padding-left:25px;padding-right:10px;"><?=$ERRORMSG?></div>
  </div>
<?php
}else{
	
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/useractivity-sprites.css">

<?
     
	$varCondition	     = " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
	$varFields	         = array('TotalMatchNos','NumbersLeft');
	$memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
	$memAstroDetails	 = mysql_fetch_array($memAstroExe);
	$totalcnt            = $memAstroDetails["NumbersLeft"];
	
    if(!empty($memAstroDetails)){

      //check whether this member has already matched this partner...
      $alreadyexist = 0;
	  $varCondition	     = " where MatriId= ".trim($objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB))." and PartnerId=".trim($objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB));
	  $varFields	         = array('MatriId');
	  $memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
	  $memMatchDetails     = mysql_fetch_array($memMatchExe);

      if(!empty($memMatchDetails))
        $alreadyexist = 1;

      if($totalcnt > 0 || $alreadyexist == 1) //if count > 0 or if the member has already matched then allow...
      {
      //check whether data is available for both login member and partner
      //checking loginmember - for login member check in astromatch table...
      	$varCondition				= " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varFields					= array('MatriId');
		$memAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
		$memAstroDetails			= mysql_fetch_array($memAstroExe);
        
        if(!empty($memAstroDetails)) //data exist for the login member so...
          $loginhas = 1;
        else
          $loginhas = 0;

		//checking partner - for partner check in horodetails table becoz that is the master table for the partner.
		$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($VarPartnerId,$objSlaveDB);
	    $varFields	    = array('MatriId');
	    $varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
	    $resastropart    = mysql_fetch_array($varExecute);

        if(!empty($resastropart)) //data exist for the login member so...
          $partnerhas = 1;
        else
          $partnerhas = 0;


        if($loginhas == 0 && $partnerhas == 0)
        {
          //updating the astropackagedet table for each comparision... decrement by one.
      	  $varCondition	     = " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		  $varFields	     = array('TotalMatchNos','NumbersLeft');
		  $memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
		  $memAstroDetails	 = mysql_fetch_array($memAstroExe);
		  $totalcnt          = $memAstroDetails["NumbersLeft"];

          if($totalcnt > 0 || $alreadyexist == 1) //if count > 0 or if the member has already matched then allow...
          {
            $varCondition	     = " where MatriId= ".trim($objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB))." and PartnerId=".trim($objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB));
			$varFields	         = array('MatriId');
		    $memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
			$rescheckcnt         = mysql_fetch_array($memMatchExe);

            if(empty($rescheckcnt)) //this combination does not exist so decrement the count. else don't decre
            {
              //updating the astropackdet table
              $newTotal=$totalcnt - 1;
			  $argFields			= array('NumbersLeft');
			  $argFieldsValues		= array($newTotal);
			  $argCondition			= "MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
			  $varUpdateId			= $objMasterDB->update($varTable['ASTROMATCHPACKAGEDET'],$argFields,$argFieldsValues,$argCondition);
            }

            if($findlogingend == "M")
            {
             
			  $argFields		= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');

			  $argFieldsValues= array($objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($mpersonfname,$objMasterDB),$objMasterDB->doEscapeString($mtimecorrection,$objMasterDB),$objMasterDB->doEscapeString($mcountries,$objMasterDB),$objMasterDB->doEscapeString($mstates,$objMasterDB),$objMasterDB->doEscapeString($mbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($mplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($mplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($mtimezone,$objMasterDB),$objMasterDB->doEscapeString($mremarks,$objMasterDB));
			  $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCH'],$argFields,$argFieldsValues);
			 
			  $argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
			  
			  $argFieldsValues= array($objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"NOW()");

			  $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

            }
            else if($findlogingend == "F")
            {
              $argFields		= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			  
			  $argFieldsValues= array($objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($fpersonfname,$objMasterDB),$objMasterDB->doEscapeString($ftimecorrection,$objMasterDB),$objMasterDB->doEscapeString($fcountries,$objMasterDB),$objMasterDB->doEscapeString($fstates,$objMasterDB),$objMasterDB->doEscapeString($fbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($fplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($fplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($ftimezone,$objMasterDB),$objMasterDB->doEscapeString($fremarks,$objMasterDB));

			  $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCH'],$argFields,$argFieldsValues);

			  $argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
			  
			  $argFieldsValues= array($objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"NOW()");
			   
			  $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

            }
            
            //Send to astrovision...
            $astrourl = $callpage."inserttodb.php?data=".$strtext;
            echo '<script> var astrourl="http://'.$_SERVER["SERVER_NAME"].'/horoscope/horomatchonlinepost.php?xdata='.$strtext.'";';

            echo 'function detectPopupBlocker() {';
            echo 'var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");';
            echo 'if (!myTest) {';
            echo 'alert("A popup blocker was detected.");';
            echo '} else {';
            echo 'myTest.close();';
            echo '} }';
            echo 'window.onload = detectPopupBlocker;';

              echo " var mywin002=window.open(astrourl,'mywindow1','location=0,status=0,scrollbars=0,toolbar=0,menubar=0,resizable=0,width=680,height=600'); ";
              echo " mywin002.moveTo(200,200);</script>";

            //final msg...
            echo "<br><div class='bld normtxt clr'>Congratulations, your AstroMatch has been successfully created.</div><br><div class='normtxt clr lh16'>&nbsp;Your results are displayed in a separate popup with \"Print\" option. <br>Horoscope Compatibility is still believed to play a major role in deciding the future of a couple's happy and prosperous marriage life.</div></font>";
          }
          else
          {
            echo "<br><font class='smalltxt'>Sorry! You have exhausted your limit of matching ".$datastropack["TotalMatchNos"]." horoscopes.</font>";
            $exitstatus = 1;
          }
          //end astropackagedet updation
        }
        else if($loginhas == 1 && $partnerhas == 0)
        {
          //updating the astropackagedet table for each comparision... decrement by one.
		  $varCondition	     = " WHERE MatriId= ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		  $varFields	     = array('TotalMatchNos','NumbersLeft');
		  $memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
		  $memAstroDetails	 = mysql_fetch_array($memAstroExe);
		  $totalcnt          = $memAstroDetails["NumbersLeft"];

          if($totalcnt > 0 || $alreadyexist == 1) //if count > 0 or if the member has already matched then allow...
          {
			$varCondition	     = " where MatriId= ".trim($objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB))." and PartnerId=".trim($objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB));
			$varFields	         = array('MatriId');
			$memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
			$rescheckcnt         = mysql_fetch_array($memMatchExe);

            if(empty($rescheckcnt)) //this combination does not exist so decrement the count. else don't decre
            {
              //updating the astropackdet table
              $newTotal=$totalcnt-1; 
			  $argFields			= array('NumbersLeft');
			  $argFieldsValues		= array($newTotal);
			  $argCondition			= "MatriId= ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
			  $varUpdateId			= $objMasterDB->update($varTable['ASTROMATCHPACKAGEDET'],$argFields,$argFieldsValues,$argCondition);
            }

            //things to do...
            //echo "<br>store login member details and send a request mailer to the partner";
			
            if($findlogingend == "M")
            {
              $argFields			= array('Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			  
			  $argFieldsValues		= array($objMasterDB->doEscapeString($mpersonfname,$objMasterDB),$objMasterDB->doEscapeString($mtimecorrection,$objMasterDB),$objMasterDB->doEscapeString($mcountries,$objMasterDB),$objMasterDB->doEscapeString($mstates,$objMasterDB),$objMasterDB->doEscapeString($mbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($mplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($mplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($mtimezone,$objMasterDB),$objMasterDB->doEscapeString($mremarks,$objMasterDB));
			  $argCondition			= "MatriId= ".$objMasterDB->doEscapeString($mregno,$objMasterDB);
			  $varUpdateId			= $objMasterDB->update($varTable['ASTROMATCH'],$argFields,$argFieldsValues,$argCondition);

			  $argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
			  
			  $argFieldsValues= array($objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"now()");
			  $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

            }
            else if($findlogingend == "F")
            {
              $argFields			= array('Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			  
			  $argFieldsValues		= array($objMasterDB->doEscapeString($fpersonfname,$objMasterDB),$objMasterDB->doEscapeString($ftimecorrection,$objMasterDB),$objMasterDB->doEscapeString($fcountries,$objMasterDB),$objMasterDB->doEscapeString($fstates,$objMasterDB),$objMasterDB->doEscapeString($fbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($fplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($fplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($ftimezone,$objMasterDB),$objMasterDB->doEscapeString($fremarks,$objMasterDB));
			  $argCondition			= "MatriId= ".$objMasterDB->doEscapeString($mregno,$objMasterDB);
			  $varUpdateId			= $objMasterDB->update($varTable['ASTROMATCH'],$argFields,$argFieldsValues,$argCondition);
              $argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
			  
			  $argFieldsValues= array($objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"now()");
			  $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

            }
            
            //Send to astrovision...
            $astrourl = $callpage."inserttodb.php?data=".$strtext;
            
            echo '<script> var astrourl="http://'.$_SERVER["SERVER_NAME"].'/horoscope/horomatchonlinepost.php?xdata='.$strtext.'";';

              echo 'function detectPopupBlocker() {';
              echo 'var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");';
              echo 'if (!myTest) {';
              echo 'alert("A popup blocker was detected.");';
              echo '} else {';
              echo 'myTest.close();';
              echo '} }';
              echo 'window.onload = detectPopupBlocker;';

            echo " var mywin002=window.open(astrourl,'mywindow1','location=0,status=0,scrollbars=0,toolbar=0,menubar=0,resizable=0,width=680,height=600'); ";
            echo " mywin002.moveTo(200,200);</script>";
            //final msg...
            echo "<br><div class='bld normtxt clr'>Congratulations, your AstroMatch has been successfully created.</div>&nbsp;<br><div class='normtxt clr lh16'>Your results are displayed in a separate popup with \"Print\" option. <br>Horoscope Compatibility is still believed to play a major role in deciding the future of a couple's happy and prosperous marriage life.</div></font>";
          }
          else
          {
            echo "<br><font class='smalltxt'>Sorry! You have exhausted your limit of matching ".$datastropack["TotalMatchNos"]." horoscopes.</font>";
            $exitstatus = 1;
          }
          //end astropackagedet updation
        }
        else if($loginhas == 0 && $partnerhas == 1)
        {
          if(checkAstroData())
          {
            //updating the astropackagedet table for each comparision... decrement by one.

			$varCondition	     = " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
			$varFields	         = array('TotalMatchNos','NumbersLeft');
			$memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
			$memAstroDetails	 = mysql_fetch_array($memAstroExe);
			$totalcnt            = $memAstroDetails["NumbersLeft"];

            if($totalcnt > 0 || $alreadyexist == 1) //if count > 0 or if the member has already matched then allow...
            {
             
			  $varCondition	     = " where MatriId= ".trim($objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB))." and PartnerId=".trim($objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB));
  			  $varFields	     = array('MatriId');
			  $memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
			  $rescheckcnt       = mysql_fetch_array($memMatchExe);

              if(empty($rescheckcnt)) //this combination does not exist so decrement the count. else don't decre
              {
                          
				//updating the astropackdet table
                $newTotal=$totalcnt-1;  
				$argFields			= array('NumbersLeft');
				$argFieldsValues	= array($newTotal);
				$argCondition		= "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
				$varUpdateId		= $objMasterDB->update($varTable['ASTROMATCHPACKAGEDET'],$argFields,$argFieldsValues,$argCondition);
              }

              //things to do...
              if($findlogingend == "M"){
               
				$argFields		= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');

				$argFieldsValues= array($objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($mpersonfname,$objMasterDB),$mtimecorrection,$objMasterDB->doEscapeString($mcountries,$objMasterDB),$objMasterDB->doEscapeString($mstates,$objMasterDB),$objMasterDB->doEscapeString($mbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($mplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($mplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($mtimezone,$objMasterDB),$objMasterDB->doEscapeString($mremarks,$objMasterDB));
				$varInsertId	= $objMasterDB->insert($varTable['ASTROMATCH'],$argFields,$argFieldsValues);


				$argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
				
				$argFieldsValues= array($objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"now()");
				$varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

              }
              else if($findlogingend == "F")
              {
              	$argFields		= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			    
				$argFieldsValues= array($objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($fpersonfname,$objMasterDB),$ftimecorrection,$objMasterDB->doEscapeString($fcountries,$objMasterDB),$objMasterDB->doEscapeString($fstates,$objMasterDB),$objMasterDB->doEscapeString($fbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($fplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($fplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($ftimezone,$objMasterDB),$objMasterDB->doEscapeString($fremarks,$objMasterDB));
			    $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCH'],$argFields,$argFieldsValues);


			    $argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
			    
				$argFieldsValues= array($objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"now()");
			    $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

              }
              
              //Send to astrovision...
              $astrourl = $callpage."inserttodb.php?data=".$strtext;
              
              echo '<script> var astrourl="http://'.$_SERVER["SERVER_NAME"].'/horoscope/horomatchonlinepost.php?xdata='.$strtext.'";';

              echo 'function detectPopupBlocker() {';
              echo 'var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");';
              echo 'if (!myTest) {';
              echo 'alert("A popup blocker was detected.");';
              echo '} else {';
              echo 'myTest.close();';
              echo '} }';
              echo 'window.onload = detectPopupBlocker;';
              echo " var mywin002=window.open(astrourl,'mywindow1','location=0,status=0,scrollbars=0,toolbar=0,menubar=0,resizable=0,width=680,height=600'); ";
              echo " mywin002.moveTo(200,200);</script>";

              //final msg...
              echo "<br><div class='bld normtxt clr'>Congratulations, your AstroMatch has been successfully created.</div><br><div class='normtxt clr lh16'>&nbsp;Your results are displayed in a separate popup with \"Print\" option. <br>Horoscope Compatibility is still believed to play a major role in deciding the future of a couple's happy and prosperous marriage life.</div></font>";
            }
            else
            {
              echo "<br><font class='smalltxt'>Sorry! You have exhausted your limit of matching ".$datastropack["TotalMatchNos"]." horoscopes.</font>";
              $exitstatus = 1;
            }
            //end astropackagedet updation
          }//end checkAstroData()
        }
        else if($loginhas == 1 && $partnerhas == 1)
        {
          if(checkAstroData())
          {
            //updating the astropackagedet table for each comparision... decrement by one.
			$varCondition	     = " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
			$varFields	         = array('TotalMatchNos','NumbersLeft');
			$memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
			$memAstroDetails	 = mysql_fetch_array($memAstroExe);
			$totalcnt            = $memAstroDetails["NumbersLeft"];

            if($totalcnt > 0 || $alreadyexist == 1) //if count > 0 or if the member has already matched then allow...
            {
			  $varCondition	     = " where MatriId= ".trim($objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB))." and PartnerId=".trim($objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB));
			  $varFields	         = array('MatriId');
			  $memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
			  $rescheckcnt         = mysql_fetch_array($memMatchExe);

              if(empty($rescheckcnt)) //this combination does not exist so decrement the count. else don't decre
              {
                
				//updating the astropackdet table
                $newTotal=$totalcnt-1;
				$argFields			= array('NumbersLeft');
				$argFieldsValues	= array($newTotal);
				$argCondition		= "MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
				$varUpdateId		= $objMasterDB->update($varTable['ASTROMATCHPACKAGEDET'],$argFields,$argFieldsValues,$argCondition);
              }

              //things to do...
              if($findlogingend == "M"){

                $argFields			= array('Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			    
				$argFieldsValues		= array($objMasterDB->doEscapeString($mpersonfname,$objMasterDB),$objMasterDB->doEscapeString($mtimecorrection,$objMasterDB),$objMasterDB->doEscapeString($mcountries,$objMasterDB),$objMasterDB->doEscapeString($mstates,$objMasterDB),$objMasterDB->doEscapeString($mbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($mplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($mplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($mtimezone,$objMasterDB),$objMasterDB->doEscapeString($mremarks,$objMasterDB));
			    $argCondition			= "MatriId= ".$objMasterDB->doEscapeString($mregno,$objMasterDB);
			    $varUpdateId			= $objMasterDB->update($varTable['ASTROMATCH'],$argFields,$argFieldsValues,$argCondition);

				$argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
				
				$argFieldsValues= array($objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"now()");
				$varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

              }else if($findlogingend == "F"){
               
				$argFields			= array('Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			    
				$argFieldsValues		= array($objMasterDB->doEscapeString($fpersonfname,$objMasterDB),$objMasterDB->doEscapeString($ftimecorrection,$objMasterDB),$objMasterDB->doEscapeString($fcountries,$objMasterDB),$objMasterDB->doEscapeString($fstates,$objMasterDB),$objMasterDB->doEscapeString($fbirthplacename,$objMasterDB),$objMasterDB->doEscapeString($fplacelongitude,$objMasterDB),$objMasterDB->doEscapeString($fplacelatitude,$objMasterDB),$objMasterDB->doEscapeString($ftimezone,$objMasterDB),$objMasterDB->doEscapeString($fremarks,$objMasterDB));
			    $argCondition			= "MatriId= ".$objMasterDB->doEscapeString($mregno,$objMasterDB);
			    $varUpdateId			= $objMasterDB->update($varTable['ASTROMATCH'],$argFields,$argFieldsValues,$argCondition);

                $argFields		= array('MatriId','PartnerId','ReportType','ReportLanguage','ChartFormat','Method','KujaDosha','PapaSamya','DasaSandhi','DateRequested');
			    
				$argFieldsValues= array($objMasterDB->doEscapeString($fregno,$objMasterDB),$objMasterDB->doEscapeString($mregno,$objMasterDB),$objMasterDB->doEscapeString($reporttype,$objMasterDB),$objMasterDB->doEscapeString($reportlanguage,$objMasterDB),$objMasterDB->doEscapeString($reportchartformat,$objMasterDB),$objMasterDB->doEscapeString($method,$objMasterDB),$objMasterDB->doEscapeString($kujadosha,$objMasterDB),$objMasterDB->doEscapeString($papasamya,$objMasterDB),$objMasterDB->doEscapeString($dasasandhi,$objMasterDB),"now()");
			    $varInsertId	= $objMasterDB->insert($varTable['ASTROMATCHPARTNER'],$argFields,$argFieldsValues);

              }
              
              //Send to astrovision...
              $astrourl = $callpage."inserttodb.php?data=".$strtext;
              echo '<script> var astrourl="http://'.$_SERVER["SERVER_NAME"].'/horoscope/horomatchonlinepost.php?xdata='.$strtext.'";';
              echo 'function detectPopupBlocker() {';
              echo 'var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");';
              echo 'if (!myTest) {';
              echo 'alert("A popup blocker was detected.");';
              echo '} else {';
              echo 'myTest.close();';
              echo '} }';
              echo 'window.onload = detectPopupBlocker;';

              echo " var mywin002=window.open(astrourl,'mywindow1','location=0,status=0,scrollbars=0,toolbar=0,menubar=0,resizable=0,width=680,height=600'); ";
              echo " mywin002.moveTo(200,200);</script>";

              //final msg...
              echo "<br><div class='bld normtxt clr'>Congratulations, your AstroMatch has been successfully created.</div>&nbsp;<br><div class='normtxt clr lh16'>Your results are displayed in a separate popup with \"Print\" option. <br>Horoscope Compatibility is still believed to play a major role in deciding the future of a couple's happy and prosperous marriage life.</div></font>";
            }else{
              echo "<br><font class='smalltxt'>Sorry! You have exhausted your limit of matching ".$datastropack["TotalMatchNos"]." horoscopes.</font>";
              $exitstatus = 1;
            }
            //end astropackagedet updation
          } //end checkAstroData().
        } //end 1,1 check
      }//end count check end..
      else
      {
        echo "<br><font class='smalltxt'>Sorry, the maximum number of Astro Matches allowed is ".$datastropack["TotalMatchNos"].". If you want to do more Astro Matches, you must renew your subscription. <a href='#' onClick=redirectMe('".$confValues['SERVERURL']."');>Click here</a> to subscribe to AstroMatch.</font>";
      }
    }
    else
    {
      echo "<br><font class='smalltxt'>Sorry, AstroMatch is a Paid Service. <a href='#' onClick=redirectMe('".$confValues['SERVERURL']."');>Click here</a> to subscribe to AstroMatch.</font>";
    }
  }

  $objSlaveDB->dbClose();
  $objMasterDB->dbClose();
  
}else{
?>
  <table border="0" width="600" cellpadding="5" cellspacing="0">
    <tr>
      <td valign="top" width="20"><br><img src="http://<?php echo $domainnameimgs; ?>/bmimages/warndelicon.gif" hspace="5" vspace="2"></td>
      <td valign="middle" class="smalltxt"><br><br>You are either logged off or your session timed out. <a href='http://<?php echo $_SERVER['SERVER_NAME'];?>"/login/loginform.php' target='_blank'>Click here</a> to login.</td>
    </tr>
  </table>
<?php
}
?>
</div><br clear="all">
</div></div>  
</div>  </div>
<!-- Content Area -->
</div>  
     <b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>