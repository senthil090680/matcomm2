<?php
#=============================================================================================================
# Author 		: Srinivasan
# Start Date	: 2010-05-28
# End Date		: 2010-05-28
# Project		: MatrimonyProduct
# Module		: Currency convertion
#=============================================================================================================


//FILE INCLUDES
$varRootBasePath = '/home/product/community';
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath."/conf/vars.inc");
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT INITIALIZATION
$objMasterDB	= new DB;

//CONNECTION DECLARATION
$objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

class YahooFinanceConverter
{
	CONST YAHOO_URL = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=%s%s=X';
	public static function yahoo_convert($a,$from,$to)
	{
		$fo = @fopen(sprintf(self::YAHOO_URL,$from,$to), 'r');
		if ($fo)
		{
			$response = fgets($fo, 4096);
			fclose($fo);
			$array = explode(',',$response);
			if(strval($array[1]) > 0) 
			{ 
				$rateobtained=strval($a)*strval($array[1]);
				//$rate=number_format(ceil($rateobtained),4);
				$rate=ceil($rateobtained);
				return $rate;
			}
		}
		return false;
	}
}
//$INCOMECURRENCYHASH=array_unique($INCOMECURRENCYHASH);
//foreach($dbarray as $thisdb)
//{
	
	foreach($INCOMECURRENCYHASH as $currencyind => $currencyval)
	{
		$rates = YahooFinanceConverter::yahoo_convert(1,$currencyval,'INR');
		if($rates===false) 
		{
			echo "\nCan't process the conversion - $currencyval";
			    $varPrimaryVal      = array("BaseCurrency");
				$varInsertFields	= array("BaseCurrency","ConvertedINRvalue");
				$varInsertVal	    = array($currencyind,"1");
				$objMasterDB->insertOnDuplicate($varTable['CURRENCYCONVERSIONRATES'], $varInsertFields, $varInsertVal, $varPrimaryVal);
		} 
		else 
		{
			if(((is_int($rates) || is_float($rates)) && $rates>0))
			{
				//$rates = number_format($rates,3);
				$rates = ceil($rates);
				
				echo "<br>"."$currencyval to INR : ".$rates;
				if($rates==0)
					$rates=1;
				$varPrimaryVal      = array("BaseCurrency");
				$varInsertFields	= array("BaseCurrency","ConvertedINRvalue");
				$varInsertVal	    = array($currencyind,"'".$rates."'");
				$objMasterDB->insertOnDuplicate($varTable['CURRENCYCONVERSIONRATES'], $varInsertFields, $varInsertVal, $varPrimaryVal);
			}
		}
	}
	$objMasterDB->dbClose();
	
//}

    
?>