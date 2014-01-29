<?php
	$varRootBasePath	= '/home/product/community';
	include_once($varRootBasePath."/conf/dbinfo.inc");
	include_once($varRootBasePath."/conf/basefunctions.inc");
	include_once($varRootBasePath."/lib/clsDB.php");
	include_once($varRootBasePath."/lib/clsReport.php");

	$objDB		= new DB;
	$objReport	= new Report;

	$objDB->dbConnect('S2', $varDbInfo['DATABASE']);
	$varDate		= date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	$varStartDate	= $varDate.' 00:00:00';
	$varEndDate		= $varDate.' 23:59:59';
	$arrCurrency	= array('Rs'=>'Online INR','Rs.'=>'Offline INR','US$'=>'Offline USD','USD'=>'Online USD');
	$arrMobileNo	= array(1=>'9841165519',2=>'9840870642',3=>'9940238882');
	//$arrMobileNo	= array(1=>'9841165519');

	$varCountQuery	="SELECT COUNT(A.MatriId) AS COUNT FROM paymenthistoryinfo A,  memberinfo B WHERE A.MatriId=B.MatriId AND A.Date_Paid>='".$varStartDate."' AND A.Date_Paid<='".$varEndDate."' AND B.Publish<=2";
	$varExecute1	= mysql_query($varCountQuery,$objDB->clsDBLink);
	$varResults1	= mysql_fetch_array($varExecute1);
	$varTotalCount	= $varResults1["COUNT"];

	//echo '<br>'.$varCountQuery;

	$varRenewalQuery	="SELECT COUNT(OrderId) AS COUNT FROM autorenewcharge WHERE Date_Paid>='".$varStartDate."' AND Date_Paid<='".$varEndDate."' AND Payment_Status=1";
	$varExecute12	= mysql_query($varRenewalQuery,$objDB->clsDBLink);
	$varResults12	= mysql_fetch_array($varExecute12);
	$varRenewalCount= $varResults12["COUNT"];
	//echo '<br>'.$varRenewalQuery;

	$varQuery		= "SELECT A.Currency,SUM(A.Amount_Paid) AS Total FROM paymenthistoryinfo A, memberinfo B WHERE A.MatriId=B.MatriId AND A.Date_Paid>='".$varStartDate."' AND A.Date_Paid<='".$varEndDate."' AND B.Publish<=2 GROUP BY A.Currency";

	//echo '<br>'.$varQuery;


	$varExecute	= mysql_query($varQuery,$objDB->clsDBLink);

	$varContent	= '';
	while($varResults	= mysql_fetch_array($varExecute)) {

		$varCurrency	= '';
		$varAmount		= '';
		$varCurrency	= '';
		$varCurrency	= $varResults['Currency'];
		$varAmount		= $varResults['Total'];
		$varCurrency	= $arrCurrency[$varCurrency] ? $arrCurrency[$varCurrency] : $varCurrency;
		$varContent		.=	'  '.$varCurrency.' '.$varAmount.', ';

	}
	$varContent	.= ' Auto Renewal = '.$varRenewalCount.', ';
	$varContent	.= ' Total Payments = '.$varTotalCount;

	//SEND SMS
	foreach ($arrMobileNo as $varKey => $varValue ){

	$varnewCmd  = "php /home/product/community/bin/sms/cbssms.php ".$varValue." ".urlencode($varContent)." CBS";
	$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
	escapeexec($varnewCmd,$varlogFile);

	}

$varHeading				= '<table width="100%"> <tr><td> <h3>[Community Matrimony - CBS]['.strftime("%d-%B-%Y",strtotime($varDate)).'][SMS Report]</h3></td></tr></table>';
$argFrom = "webmaster";
$argFromEmailAddress  	= "admin@communitymatrimony.com";
$argTo					= "Community Matrimony report";
$argToEmailAddress 		= "sai@bharatmatrimony.com,dhanapal@bharatmatrimony.com,pradeep@bharatmatrimony.com,ashokkumar@bharatmatrimony.com";
//$argToEmailAddress 		= "dhanapal@bharatmatrimony.com";
$argSubject		   		= "[Community Matrimony - CBS]".strftime("%d-%B-%Y",strtotime($varDate))."][SMS Report]";
$argMessage		   		= $varHeading.'<br clear="all">'.$varContent.'<br><br clear="all"><table border="0" width="100%" align="center"><tr><td align="right"><font style="font-size:12px;" >Automated Report genrated by CommunityMatrimony.com</font></td></tr></table>';
$argReplyToEmailAddress = "webmaster@communitymatrimony.com";

$objReport->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress);
//echo "<br clear='all'>".$argMessage;



$objDB->dbClose();
UNSET($objDB);

?>