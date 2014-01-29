<?php

//BASE PATH
$varRootBasePath = '/home/product/community';

//Include files
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');


// DB Connection Object //
$objSlave	= new DB;

// Connecting DB  //
$objSlave -> dbConnect('S',$varDbInfo['DATABASE']);

//  Ip Array  //
//$ipArrays = array("61.16.161.93","192.168.10.25","192.168.1.15","192.168.1.19");
/*
//Logic used by BMCRM to send the matriid to us for email id request is follows. Code created by Arun Clickjobs.com

$Mid = 'M490404';

$saltStringMid = 'xabyMatSaltChatIdym'; //This is the encryption salt string for matriId

$encMid = Mid_encrypt($Mid,$saltStringMid); //This is the vaue of MID

$saltStringPid = 'mydItahCidPmatybax'; 
$saltStringSecond = 'xytahCidPChatStryz'; 

$first_level_Str = crypt($Mid,$saltStringPid); //Crypt value for First String
$encPid = crypt($first_level_Str,$saltStringSecond); //This is the value of PId
//we will call the url like following.
//http://profile.bharatmatrimony.com/profiledetail/getemailids.php?MID=$encMid&PID=$encPid
*/

$decMid = base64_decode(trim($_REQUEST['MID']));



	
	$argMatriEmail = array('Email');
	$argCondition	= "WHERE MatriId=".$objSlave->doEscapeString($decMid,$objSlave);

	$matriNum = $objSlave -> numOfRecords($varTable['MEMBERLOGININFO'], 'Email', $argCondition);
	if($matriNum > 0)
	{
		$memDetailsResult = $objSlave -> select($varTable['MEMBERLOGININFO'],$argMatriEmail,$argCondition,0);
		if($objSlave -> clsErrorCode != "SELECT_ERR")
		{
			$memDetailsRow = mysql_fetch_assoc($memDetailsResult);
			echo $memDetailsRow['Email'];
		}
		else
		{
			$subject = "Select Error - Code - ".$objSlave -> clsErrorCode." : File - cmcrmgetemailid1.php : Line no - 56 : matriId - $decMid";
			$body = "Select Error - Code - ".$objSlave -> clsErrorCode." : File - cmcrmgetemailid1.php : Line no - 56 : matriId - $decMid<br>";
			$body .= "MatriId - $decMid : Mid - $encMid : Pid - $encPid";
			mailToSuresh($subject,$body);
		}
	}
	else
	{
		echo "MatriId does not exist";
	}
	

	//mail("suresh.a@bharatmatrimony.com","Bad request - /profiledetail/cbscrmgetemailid.php","Bad request");


function mailToSuresh($subject,$body)
{
//	mail("suresh.a@bharatmatrimony.com",$subject,$body);
}
?>
