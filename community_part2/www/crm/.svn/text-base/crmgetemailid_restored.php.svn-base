<?php
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

include_once $DOCROOTBASEPATH."/conf/dbinfo.cil14";
include_once $DOCROOTBASEPATH."/lib/clsDB.php";

$encMid = trim($_GET['MID']);
$encPid = trim($_GET['PID']);

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
		//authorized request. Proceed.
		$objdb_slave = new DB;
		$objdb_slave->dbConnect('S','communitymatrimony');

		if($objdb_slave->clsErrorCode == 'DB_CONN_ERR' || $objdb_slave->clsErrorCode == 'DB_SEL_ERR')
		{
			echo "Unable to connect the server";
		}
		else
		{
			$varGetResult = $objdb_slave->select('memberlogininfo', array('Email'), 'where MatriId='.$objdb_slave->doEscapeString($decMid,$objdb_slave).', 0');
			$varGetEmailInfo = mysql_fetch_array($varGetResult);

			if(trim($varGetEmailInfo['Email'])!='')
			{
				echo $varGetEmailInfo['Email'];
			}
			else
				echo "MatriId does not exist";
		}
	}
	else
	{
		//unauthorized request.
		echo "Unauthorized request";
	}
}
else
	echo "Bad request";
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
?>
