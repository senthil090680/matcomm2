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

$encMid = trim($_POST['MID']);
$encPid = trim($_POST['PID']);

if(($encMid != '') && ($encPid != ''))
{
	$saltStringMid = 'omrt14793'; //This is the encryption salt string for matriId
	$decMid = Mid_decrypt($encMid,$saltStringMid); //We will get the original MatriId

	//Then will follow the following process REVERSLY after getting original MatriId $decMid.
	$decsaltStringPid = 'yiwe946';
	$decsaltStringSecond = 'dfhjce594';

	$dec_first_level_Str = crypt($decMid,$decsaltStringPid); //Crypt value for First String
	$decPid = crypt($dec_first_level_Str,$decsaltStringSecond); //This is the value of PId
	//Compare the $decPid with GET pid value.
	if($decPid == $encPid)
	{
		$argMatriEmail = array('Email');
		$argCondition	= "WHERE MatriId=".$objSlave->doEscapeString($decMid,$objSlave);

		$matriNum = $objSlave->numOfRecords($varTable['MEMBERLOGININFO'], 'Email', $argCondition);
		if($matriNum > 0)
		{
			$memDetailsResult = $objSlave->select($varTable['MEMBERLOGININFO'],$argMatriEmail,$argCondition,0);
			if($objSlave -> clsErrorCode != "SELECT_ERR")
			{
				$memDetailsRow = mysql_fetch_assoc($memDetailsResult);
				echo $memDetailsRow['Email'];
			}
			else
			{
				$subject = "Select Error - Code - ".$objSlave -> clsErrorCode." : File - __FILE__ : Line no - __LINE__";
				$body = "Select Error - Code - ".$objSlave -> clsErrorCode." : File - __FILE__ : Line no - __LINE__ <br>";
				$body .= "MatriId - $decMid : Mid - $encMid : Pid - $encPid";
				mailToSuresh($subject,$body);
			}
		}
		else
		{
			echo "MatriId does not exist";
		}
	}
	else
	{
		$subject = "Unauthorized request - File - __FILE__ Line no - __LINE__";
		$body = "Unauthorized request - File - __FILE__ Line no - __LINE__ <br>";
		$body .= "MatriId - $decMid : Mid - $encMid : Pid - $encPid";
		mailToSuresh($subject,$body);
		//unauthorized request.
	}
}
else
{
	$subject = "Bad request : File - __FILE__ : Line no - __LINE__";
	$body = "Bad request : File - __FILE__ : Line no - __LINE__ <br>";
	$body .= "MatriId - $decMid : Mid - $encMid : Pid - $encPid";
	mailToSuresh($subject,$body);
}

	//mail("suresh.a@bharatmatrimony.com","Bad request - /profiledetail/cbscrmgetemailid.php","Bad request");
/***************Functions Used For Encrytion********/

function Mid_encrypt($string, $key)
{
        $result = '';
        for($i=0; $i<strlen($string); $i++)
        {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)+ord($keychar));
                $result.=$char;
        }
        return base64_encode($result);
}

function Mid_decrypt($string, $key)
{
        $result = '';
        $string = base64_decode($string);
        for($i=0; $i<strlen($string); $i++)
        {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)-ord($keychar));
                $result.=$char;
        }
        return $result;
}
/*************End of Encryption Function*********/

function mailToSuresh($subject,$body)
{
	mail("suresh.a@bharatmatrimony.com",$subject,$body);
}
?>
