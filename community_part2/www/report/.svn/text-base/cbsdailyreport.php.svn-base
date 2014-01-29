<?php
$varReportRootBasePath	= '/home/product/community';
include_once($varReportRootBasePath."/conf/config.inc");
include_once($varReportRootBasePath."/conf/dbinfo.inc");
include_once($varReportRootBasePath."/lib/clsDB.php");
include_once($varReportRootBasePath."/conf/vars.inc");
include_once($varReportRootBasePath."/lib/clsReport.php");
//FILE INCLUDES

//OBJECT DECLARATION
$objReport			= new Report;
$objSlaveDB			= new DB;

$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE DECLARATION
/*$objReport->clsTable		= "memberinfo";
$objReport->clsPrimary		= array('Date_Created','Date_Created');
$objReport->clsPrimarySymbol= array('>=','<=');
$objReport->clsPrimaryKey	= array('AND','AND','AND');
$objReport->clsCountField	= "MatriId";*/

if ($_REQUEST['manual'] == 'yes') {
?>
<script language="javascript" src="<?=$confValues['JSPATH'];?>/calenderJS.js"></script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/calender.css">
	<form name="frmDailyReport" method="post">
		<input type="hidden" name="frmDailyReportSubmit" value="yes">
		<input type="hidden" name="manual" value="<?=($_REQUEST['manual']=='yes')?'yes':'no';?>">
		<table>
		<tr><td colspan="2"><h3> Daily Report: CommunityMatrimony.com<h3> </td></tr>
		<tr>
			<td class="grtxtbold1" valign=middle style="padding-left:5px;" align='left'><font style="font-family: MS sans-serif, Arial, Verdana, Helvetica; font-size: 15px"><b>Select Report Date</b><br>(YYYY-mm-dd)</font></td><td  valign=middle  align='left' class="smalltxt"><input type='text' class='smalltxt' name='fromdate' value="<?=date('Y-m-d');?>" /><a
			href="javascript:displayDatePicker('fromdate', false, 'ymd', '-');"><img src="<?=$confValues['IMGSURL'];?>/calbtn.gif" align="absMiddle"
			border="0"></a></td><td><input type="submit" value="submit" name="submit"></td>
		</tr>
		</table>
	</form>
<?
}

if ($_REQUEST['frmDailyReportSubmit'] == 'yes' ) {
	$varDate			= $_REQUEST['fromdate'];
} else {
	//$varDate				= date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")-3, date("Y")));
	$varDate				= date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
}
$varStartDate				= $varDate.' 00:00:00';
$varEndDate					= $varDate.' 23:59:59';
//BM TO CBS PROFILES COPIED
$varCondition				= " WHERE BM_MatriId!='' AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varCopiedFromBM		= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET TOTAL PROFILES COUNT
$varCondition				= " WHERE Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varTotalProfiles			= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET PENDING VALIDATION COUNT
$varCondition				= " WHERE Publish = 0 AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varPendingProfiles			= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET ADDED PROFILES COUNT
$varCondition				= " WHERE Publish = 1  AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varAddedProfiles			= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET HIDDEN PROFILES COUNT
$varCondition				= " WHERE Publish = 2  AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varHiddenProfiles			= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET SUSPENDED PROFILES COUNT
$varCondition				= " WHERE Publish = 3  AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varSuspendedProfiles		= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET REJECTED PROFILES COUNT
$varCondition				= " WHERE Publish = 4  AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
$varRejectedProfiles		= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET PAID PEOFILES COUNT
$varCondition				= " WHERE  Date_Paid >='".$varStartDate."' AND Date_Paid <='".$varEndDate."'";
//$varPaidProfiles			= $objSlaveDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
$varPaidProfiles			= $objReport->numOfPaidProfiles($varDate);

//GET DIRECT CBS PAID PROFILE COUNT
$varCondition				= " WHERE  BM_MatriId='' AND Date_Paid >='".$varStartDate."' AND Date_Paid <='".$varEndDate."'";
//$varPaidProfiles			= $objSlaveDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
$varDirCBSPaidProfiles			= $objReport->numOfPaidProfiles($varDate,'N');

//GET BM COPIED PAID PROFILE COUNT
$varCondition				= " WHERE BM_MatriId!='' AND Date_Paid >='".$varStartDate."' AND Date_Paid <='".$varEndDate."'";
//$varPaidProfiles			= $objSlaveDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
$varFromBMPaidProfiles			= $objReport->numOfPaidProfiles($varDate,'Y');

$varCondition				= " WHERE  (Publish = 1 OR Publish = 2) AND Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'  GROUP BY Gender ORDER BY Gender ASC";
$varFields					= array('GENDER' ,'COUNT(MatriId) AS CNT');
$varGenderInfo				= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);

//$varCondition				= " WHERE Publish = 1 OR Publish = 2 GROUP BY Gender ORDER BY Gender ASC";
//$varFields					= array('GENDER' ,'COUNT(Gender) AS CNT');
//$varTotalInfo				= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);

$varCondition				= " WHERE Last_Login >='".$varStartDate."' AND Last_Login <='".$varEndDate."' AND Date_Created!=Last_Login ";
$varLoginInfo				= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//$varCondition				= " WHERE Publish = 1  AND Last_Login >='".$varStartDate."' AND Last_Login <='".$varEndDate."'";
//$varLoginInfo				= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);

//GET PAID PROFILES DETAILS INFO
$varFields				= array('MatriId','Amount_Paid','Date_Paid','Currency');
$varPaymentHistoryInfo	= $objReport->getPaidProfileDetails($varDate);
//$varPaymentHistoryInfo	= $objSlaveDB->select($varTable['PAYMENTHISTORYINFO'], $varFields, $varCondition, 0);
//print "<br>PAYMENT ".$varPaymentHistoryInfo;
//print_r($varPaymentHistoryInfo);
$varDisplayPaymenyInfo	 = '';
$varDisplayPaymenyInfo	.= '<tr>';
$varDisplayPaymenyInfo	.= '<td class="smalltxt" width="5%"><b>S.No</b></td>';
//$varDisplayPaymenyInfo	.= '<td class="smalltxt" width="20%"><b>Username</b></td>';
$varDisplayPaymenyInfo	.= '<td class="smalltxt" width="20%"><b>MatriId</b></td>';
$varDisplayPaymenyInfo	.= '<td class="smalltxt" width="20%"><b>Country</b></td>';
//$varDisplayPaymenyInfo	.= '<td class="smalltxt" width="20%"><b>Citizenship</b></td>';
$varDisplayPaymenyInfo	.= '<td class="smalltxt"><b>Amount Paid</b></td>';
$varDisplayPaymenyInfo	.= '</tr>';
$varDisplayPaymenyInfo	.= '<tr><td class="smalltxt" height="25" colspan="6"><hr></td></tr>';

$j=1;

while ($varSelectPaymentInfo	= mysql_fetch_array($varPaymentHistoryInfo)) {
	$varMatriId					= $varSelectPaymentInfo['MatriId'];
	$varCondition				= " WHERE  MatriId ='".$varMatriId."'";
	$varCheckProfileCount		= $objSlaveDB->numOfRecords($varTable['MEMBERINFO'], $argPrimary='MatriId', $varCondition);
	if ($varCheckProfileCount==1)
	{
		$varFields				= array('User_Name','Country','Citizenship');
		$varSelectContactInfo	= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	}//if
	else
	{
		$varFields				= array('User_Name','Country','Citizenship','Date_Deleted','Date_Created');
		$varSelectContactInfo	= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0);
	}//else
	$varMemberInfo			 = mysql_fetch_array($varSelectContactInfo);
	$varDisplayPaymenyInfo	.= '<tr>';
	$varDisplayPaymenyInfo	.= '<td class="smalltxt">'.$j.'</td>';
	//$varDisplayPaymenyInfo	.= '<td class="smalltxt">'.$varMemberInfo['User_Name'].'</td>';
	$varDisplayPaymenyInfo	.= '<td class="smalltxt">'.$varMatriId.'</td>';
	$varDisplayPaymenyInfo	.= '<td class="smalltxt">'.$arrCountryList[$varMemberInfo["Country"]].'</td>';
	//$varDisplayPaymenyInfo	.= '<td class="smalltxt">'.$arrCountryList[$varMemberInfo["Citizenship"]].'</td>';
	$varDisplayPaymenyInfo	.= '<td class="smalltxt"><b>'.$varSelectPaymentInfo["Currency"].'</b> '.$varSelectPaymentInfo["Amount_Paid"].'</td>';
	$varDisplayPaymenyInfo	.= '</tr>';

	$j++;
}


//GROUP BY CURRENCY TOTAL AMOUNT PAID
$varresultoftotalsum	= $objReport->getPaidTotalSum($varDate);

//SALAAM SENT COUNT
$varCondition			= " WHERE Date_Sent >='".$varStartDate."' AND Date_Sent <='".$varEndDate."'";
$varSalaamSent			= $objSlaveDB->numOfRecords($varTable['INTERESTSENTINFO'], $argPrimary='Interest_Id', $varCondition);

//$varCondition			= " WHERE Date_Created >='".$varStartDate."' AND Date_Created <='".$varEndDate."'";
//$varPaidProfiles		= $objSlaveDB->numOfRecords($varTable['PAYMENTHISTORYINFO'], $argPrimary='OrderId', $varCondition);
//$varPaidProfiles		= $objReport->numOfResults();

//MAIL SENT COUNT
$varCondition			= " WHERE Date_Sent >='".$varStartDate."' AND Date_Sent <='".$varEndDate."'";
$varMailSent			= $objSlaveDB->numOfRecords($varTable['MAILSENTINFO'], $argPrimary='Mail_Id', $varCondition);

$varProfileDetails	= '';
$varProfileDetails	.='<table border="0" cellpadding="2" cellspacing="1" align="left" width="25%" style="font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px;">';

$varProfileDetails	.='<tr>
	<td class="smalltxt"><b>Total Profiles :</b> </td>
	<td class="smalltxt"  align="right" >'.($varTotalProfiles).'</td>
</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" colspan="2"><hr></td></tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200">Profiles copied from BM to CBS: </td>
	<td class="smalltxt" align="right" >'.$varCopiedFromBM.'</td>
</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt">Direct CBS Registered Profiles :</td>
	<td class="smalltxt"  align="right" >'.($varTotalProfiles - $varCopiedFromBM).'</td>
</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" height="25" colspan="2">&nbsp;&nbsp;</td>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" colspan="2"><b>Membership Details :</b> </td>
</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" colspan="2"><hr></td></tr>';
$varProfileDetails	.='<tr>
		<td class="smalltxt">Total Paid Profiles : </td>
		<td class="smalltxt"  align="right" >'.$varPaidProfiles.'</td>
	</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" colspan="2"><hr></td></tr>';
$varProfileDetails	.='<tr>
		<td class="smalltxt">Direct CBS Paid Profiles : </td>
		<td class="smalltxt"  align="right" >'.$varDirCBSPaidProfiles.'</td>
	</tr>';
$varProfileDetails	.='<tr>
		<td class="smalltxt">BM Copied Paid Profiles : </td>
		<td class="smalltxt"  align="right" >'.$varFromBMPaidProfiles.'</td>
	</tr>';
//<td class="smalltxt"  align="right" >'.(($varTotalProfiles - $varCopiedFromBM)-$varPaidProfiles).'</td>
//$varProfileDetails	.='<tr>
//		<td class="smalltxt">Free Profiles : </td>
//		<td class="smalltxt"  align="right" >'.($varTotalProfiles -$varPaidProfiles).'</td>
//	</tr>';

$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" height="25" colspan="2">&nbsp;&nbsp;</td>';
	$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" colspan="2"><b>By Status</b></td>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" colspan="2"><hr></td></tr>';
//<td class="smalltxt"  align="right" >'.(($varAddedProfiles+$varHiddenProfiles)-$varCopiedFromBM).'</td>
$varProfileDetails	.='<tr>
	<td class="smalltxt">Profiles Validated:</td>
	<td class="smalltxt"  align="right" >'.(($varAddedProfiles+$varHiddenProfiles)).'</td>
</tr>';
$varProfileDetails	.='<tr>
		<td class="smalltxt">Pending Validation : </td>
		<td class="smalltxt"  align="right" >'.$varPendingProfiles.'</td>
	</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt">Suspended Profiles :</td>
	<td class="smalltxt"  align="right" >'.$varSuspendedProfiles.'</td>
</tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt">Rejected Profiles : </td>
	<td class="smalltxt"  align="right" >'.$varRejectedProfiles.'</td>
</tr>';


$varProfileDetails	.='<tr>
	<td class="smalltxt" width="250" height="25" colspan="2">&nbsp;&nbsp;</td>';
 $varProfileDetails	.='<tr><td class="smalltxt" height="15" colspan="2"><b> Gender Details [For Validated Only]</b> </td></tr>';
$varProfileDetails	.='<tr>
	<td class="smalltxt" width="200" colspan="2"><hr></td></tr>';
while ($varGenderDetInfo	= mysql_fetch_array($varGenderInfo)) {
	$varGender	= ($varGenderDetInfo['GENDER']==1)?"Male":"Female";
	$varProfileDetails	.='<tr>
		<td class="smalltxt">'.$varGender.'</td>
		<td class="smalltxt"  align="right" >'.$varGenderDetInfo['CNT'].'</td>
	</tr>';
}
$varProfileDetails	.='<tr><td class="smalltxt" height="25"></td></tr>';
$varProfileDetails	.='<tr><td class="smalltxt"><b>Total Login Members :</b></td><td align="right">'.$varLoginInfo.'</td></tr>';

$varProfileDetails	.='<tr><td class="smalltxt" height="25"></td></tr>';
$varProfileDetails	.='<tr><td class="smalltxt" colspan="2"> <b> Message & Interest Count :</b></td></tr>';
$varProfileDetails	.='<tr><td class="smalltxt" colspan="2"><hr></td></tr>';
$varProfileDetails	.='<tr>
		<td class="smalltxt" >Express Interest Sent : </td>
		<td class="smalltxt"  align="right" >'.$varSalaamSent.'</td>
	</tr>
	<tr>
	<td class="smalltxt">Message Sent: </td>
	<td class="smalltxt boldtxt"  align="right" >'.$varMailSent.'</td>
	</tr><tr><td class="smalltxt" height="15"></td></tr>';
$varProfileDetails	.='</table>';

if ($varPaidProfiles > 0 ) {
	 $varPaymentDetails	=  '';
	 //width="70%"
	 $varPaymentDetails	.=  '<table border="0" cellpadding="2" cellspacing="1" align="left"  bgcolor=#FFFFFF style="font-family: Verdana, MS Sans serif, Arial, Helvetica, sans-serif; font-size: 11px;">
	<tr><td class="smalltxt" height="25"></td></tr>
	<tr>
		<td class="smalltxt" colspan="5"><b>Payment Details : ('.$varPaidProfiles.'</b>)</td>
	</tr>
	<tr><td class="smalltxt" height="25" colspan="6"><hr></td></tr>';
	$varPaymentDetails	.= $varDisplayPaymenyInfo;
	$varPaymentDetails	.= '<tr><td class="smalltxt" height="25" colspan="6"><hr></td></tr>
	<tr><td colspan="0" height="5"  valign="middle" align="right" class="smalltxt"><b>Total&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;</b></td><td class="smalltxt"><b>';
	//for($i=0;$i<count($varTotalAmountSumInfo);$i++){
	while ($varTotalAmountSumInfo = mysql_fetch_array($varresultoftotalsum)) {
		$varPaymentDetails	.= '';
		if (trim($varTotalAmountSumInfo["Amount_Paid"]) > 0) {
			$varCurrency		= trim($varTotalAmountSumInfo["Currency"]);
			$varAmount			= trim($varTotalAmountSumInfo["Amount_Paid"]);
			$varPaymentDetails	.= $varCurrency." ".$varAmount."<br>";
		}
	}
	$varPaymentDetails	.='</b></td></tr>';
	if (count($varTotalAmountSumInfo)==2)
		$varPaymentDetails	.= '<tr><td class="smalltxt" height="25" colspan="6">&nbsp&nbsp;</td></tr>';
	$varPaymentDetails	.= '<tr><td colspan="6"><hr></td></tr></table>';
} else {
	$varPaymentDetails ="<br><b> No paid profile on ".$varDate;
}
$varStartDate		= $varDate.' 00:00:00';
$varEndDate			= $varDate.' 23:59:59';
//$varList			= $objReport->getCountryListInfo($varStartDate,$varEndDate,$arrCountryList);
//$varCountryList		= '<br><br><br><b>Country List<b><br>';
//$varCountryList		.='<table width="100%"><tr><td align="left"> <table border="0" cellpadding="2" cellspacing="1" align="left" width="30%" bgcolor=#FFFFFF class="smalltxt" style="font-family:Verdana,MS Sans serif,Arial,Helvetica,sans-serif;font-size: 11px;" ><tr><td class="smalltxt" height="25" colspan="2" ><hr></td></tr><tr><td class="smalltxt"  align="left"> <b>Country </b> </td><td class="smalltxt" align="left"><b>No.of Profiles</b></td></tr><tr><td colspan="2" class="smalltxt" height="25"><hr></td></tr>'.$varList.'<tr><td colspan="2" class="smalltxt" height="25"><hr></td></tr><tr><td colspan="2" class="smalltxt" height="25" valign="basline" align="right"></td></tr></table></td></tr></table>';
$varHeading				= '<table width="100%"> <tr><td> <h3>[Community Matrimony - CBS]['.strftime("%d-%B-%Y",strtotime($varDate)).'][Daily Report]</h3></td></tr></table>';
$argFrom = "webmaster";
$argFromEmailAddress  	= "admin@communitymatrimony.com";
$argTo					= "Community Matrimony report";
//$argToEmailAddress 		= "jmuruga@consim.com,jshree@bharatmatrimony.com,sai@bharatmatrimony.com,vishnu@consim.com,rohit@bharatmatrimony.com,gaurav.misra@bharatmatrimony.com,ashokkumar@bharatmatrimony.com";
$argToEmailAddress 		= "jmuruga@consim.com,sai@bharatmatrimony.com,ashokkumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com,jshree@bharatmatrimony.com,jebamony@consim.com,vijayasunitha@bharatmatrimony.com";
$argSubject		   		= "[Community Matrimony - CBS]".strftime("%d-%B-%Y",strtotime($varDate))."][Daily Report]";
$argMessage		   		= $varHeading.'<br clear="all">'.$varProfileDetails.'<br clear="all">'.$varPaymentDetails.'<br clear="all">'.$varCountryList.'<br><br clear="all"><table border="0" width="100%" align="center"><tr><td align="right"><font style="font-size:12px;" >Automated Report genrated by CommunityMatrimony.com</font></td></tr></table>';
$argReplyToEmailAddress = "webmaster@communitymatrimony.com";

$varMailSend			= $objReport->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage,$argReplyToEmailAddress);
echo "<br clear='all'>".$argMessage;
if ($varMailSend == 'yes')
	echo "<br clear='all'><br><br><br><br><br><b>Email Send Successfully</b>";
else
	echo "<br clear='all'><br><br><br><br><br><br><b>Email was unable to send</b>";

?>