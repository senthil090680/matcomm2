<?php
#================================================================================================================
# Author 	: Srinivasan
# Date		: 18-May-2010
# Project	: MatrimonyProduct
# Filename	: horomatchcheckdetails.php
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

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessGender		= $varGetCookieInfo["GENDER"];

//OBJECT INITIALIZATION
$objHoroscope	= new Horoscope;
$objSlaveDB		= new MemcacheDB;
$objMasterDB	= new MemcacheDB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
//$objHoroscope->dbConnect('S', $varDbInfo['DATABASE']);
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

echo '<script src="'.$confValues["IMAGEURL"].'/scripts/horomatchcheckdetails.js" language="javascript"></script>';

if((isset($sessMatriId))) 
{

	$loginmember = $sessMatriId;
	$partnerid = $_GET["partnerId"]; //for querystring.
	
	if(!$objSlaveDB->clsErrorCode){
	//Finding the gender of both login and pid.

	$varFields					= array('Gender');
	$varCondition	            = " WHERE MatriId = ".$objSlaveDB->doEscapeString($loginmember,$objSlaveDB);
	$memResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
	$memResultArr       		= mysql_fetch_assoc($memResult);
		
	$varCondition	            = " WHERE MatriId = ".$objSlaveDB->doEscapeString($partnerid,$objSlaveDB);
	$partResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
	$partResultArr      		= mysql_fetch_assoc($partResult);
	
    //Check whether the login member has horoscope details in the horodetails table.
	$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($loginmember,$objSlaveDB);
	$varFields	    = array('MatriId','BirthCity','BirthDay','BirthMonth','BirthYear','BirthLongitude','BirthLatitude');
	$varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
	$memHoroDet	    = mysql_fetch_array($varExecute);

    
	if(empty($memResultArr) || trim($memHoroDet["BirthCity"]) == "0" || trim($memHoroDet["BirthDay"]) == 0 || trim($memHoroDet["BirthMonth"]) == 0 || trim($memHoroDet["BirthYear"]) == 0 || trim($memHoroDet["BirthCity"]) == "" || trim($memHoroDet["BirthLongitude"]) == "" || trim($memHoroDet["BirthLatitude"]) == "")
	{	
		
		header("Location: ".$confValues["IMAGEURL"]."/horoscope/?act=addhoroscope");
	}
	else
	{
		$varCondition	     = " WHERE MatriId= ".$objSlaveDB->doEscapeString($loginmember,$objSlaveDB);
		$varFields	         = array('MatriId');
		$memAstroDet	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,1);
		
		if(!empty($memAstroDet))
		{
			//subscribed.. check whether the match count available...
			$varCondition	     = " WHERE MatriId= ".$objSlaveDB->doEscapeString($loginmember,$objSlaveDB);
		    $varFields	         = array('TotalMatchNos','NumbersLeft');
		    $memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
			$memAstroDetails	 = mysql_fetch_array($memAstroExe);
			$totalcnt            = $memAstroDetails["NumbersLeft"];
		    
			//check whether this member has already matched this partner...
			$alreadyExist = 0;
            $varCondition	     = " where MatriId= ".$objSlaveDB->doEscapeString($loginmember,$objSlaveDB)." and PartnerId=  ".$objSlaveDB->doEscapeString($partnerid,$objSlaveDB);
		    $varFields	         = array('MatriId');
		    $memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
			$memMatchDetails     = mysql_fetch_array($memMatchExe);
			//print_r($memMatchDetails);//exit;
			
			if(!empty($memMatchDetails))
				$alreadyExist = 1;
			if($totalcnt > 0 || $alreadyExist == 1) //if count > 0 or if the member has already matched then allow...
			{
				//echo "<script>location.href='".$confValues["IMAGEURL"]."/horoscope/index.php?act=matchhoroscope&partnerId=".$partnerid."&pidflag=1"."'</script>";
				echo "<script>
			    opener.location.href='".$confValues["IMAGEURL"]."/horoscope/index.php?act=matchhoroscope&partnerId=".$partnerid."&pidflag=1"."';
			    self.close();</script>";
			}
			else
			{
				
			    echo "<script>expopupcnt('".$confValues['SERVERURL']."',".$memAstroDetails["TotalMatchNos"].");</script>";
				echo "<script>
			    opener.location.href='".$confValues['SERVERURL']."/payment/index.php?act=additionalpayment&astro=1';
			    self.close();</script>";
				
				
			}
		}//pay count end..
		else
		{   
			//member has not subscribed...
			echo "<script>opener.location.href='".$confValues['SERVERURL']."/payment/index.php?act=additionalpayment&astro=1';self.close();</script>";
		}
	}

	

		
	}
	else{
?>
  <div class="smalltxt" style="margin-left:5px;">
    <div class="mediumtxt1 boldtxt" style="padding-left:25px;padding-right:10px;">DB Connection Error</div>
  </div>
<?php
	}
}//cookie end
else
{
	header ("location:".$confValues['SERVERURL']."/login/index.php?act=login");
}
?>
<?php
if(is_object($objSlaveDB)){
	$objSlaveDB ->dbClose(); // Slave Connection Closed Here...
	$objMasterDB->dbClose(); // Master Connection Closed Here...
}
?>