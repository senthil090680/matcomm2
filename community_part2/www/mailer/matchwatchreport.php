<?php
#=============================================================================================================
# Author 		: N Jeyakumar
# Start Date	: 2008-11-19
# End Date		: 2008-11-19
# Project		: MatrimonyProduct
# Module		: Mailer
#=============================================================================================================
//FILE INCLUDES
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.cil14');
include_once($varServerBasePath.'/conf/config.cil14');
include_once($varServerBasePath.'/conf/cityarray.cil14');
include_once($varServerBasePath.'/conf/emailsconfig.cil14');
include_once($varServerBasePath.'/conf/domainlist.cil14');
include_once($varServerBasePath.'/conf/mwdomainlist.cil14');
include_once($varServerBasePath.'/lib/clsDB.php');


//OBJECT DECLARATION
$objDB = new DB;

//CONNECT DB
$objDB->dbConnect('S2',$varMatchwatchDbInfo['DATABASE']);
if($objDB->clsErrorCode!='') {
	echo $objDB->clsErrorCode;
	exit;
}

$mwdate = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-2,date("Y")));

$starttime = "$mwdate "."00:00:00";
$endtime = "$mwdate "."23:59:59";
$totalliveprofilesresAll=0;

//get total no of mails
$funCondition			= "";
$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_1';
$totalmailsresAll_1		= $objDB->numOfRecords($varMatchwatchMailTbl, 'MatriId', $funCondition);	

$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_2';
$totalmailsresAll_2		= $objDB->numOfRecords($varMatchwatchMailTbl, 'MatriId', $funCondition);	

$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_3';
$totalmailsresAll_3		= $objDB->numOfRecords($varMatchwatchMailTbl, 'MatriId', $funCondition);	

$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_4';
$totalmailsresAll_4		= $objDB->numOfRecords($varMatchwatchMailTbl, 'MatriId', $funCondition);	

$totalmailsresAll		= $totalmailsresAll_1+$totalmailsresAll_2+$totalmailsresAll_3+$totalmailsresAll_4;

//get total no of new profiles
$funCondition			= "WHERE Publish=1 AND  Profile_Published_On >= '".$starttime."' AND Profile_Published_On <= '".$endtime."'";
$varMWMemberInfoTbl		= 'cbsmatchwatch.'.$varTable['MEMBERINFO'];
$totalnewprofilesresAll	= $objDB->numOfRecords($varMWMemberInfoTbl, 'MatriId', $funCondition);	

$arrRestrictedCommId	= array(2000);
foreach($arrMatriIdPre as $key=>$val) {
	if(in_array($key, $arrCommunityIdSet1)) {
		$varDialyMatchWatchTable = 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_1'];
		$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_1';
	} else if(in_array($key, $arrCommunityIdSet2)) {
		$varDialyMatchWatchTable = 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_2'];
		$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_2';
	} else if(in_array($key, $arrCommunityIdSet3)) {
		$varDialyMatchWatchTable = 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_3'];
		$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_3';
	} else if(in_array($key, $arrCommunityIdSet4)) {
		$varDialyMatchWatchTable = 'cbsmatchwatch.'.$varTable['DAILYMATCHWATCH_4'];
		$varMatchwatchMailTbl	= 'cbsmatchwatch.matchwatchmail_4';
	}

	//get total no of mails for particular domain
	$funCondition			= "WHERE CommunityId=".$key;
	$totalmailsres		= $objDB->numOfRecords($varMatchwatchMailTbl, 'MatriId', $funCondition);	

	//get total no of new profiles for particular domain
	$funCondition			= "WHERE CommunityId=".$key." AND Publish=1 AND  Profile_Published_On >= '".$starttime."' AND Profile_Published_On <= '".$endtime."'";
	$totalnewprofilesres	= $objDB->numOfRecords($varMWMemberInfoTbl, 'MatriId', $funCondition);	

	//get total no of old profiles for particular domain
	$funCondition			= "WHERE CommunityId=".$key." AND Publish=1";
	$totalliveprofilesres	= $objDB->numOfRecords($varDialyMatchWatchTable, 'MatriId', $funCondition);	

	$arrReport[$key]["mails"]	= $totalmailsres;
	$arrReport[$key]["profs"]	= $totalnewprofilesres;
	$arrReport[$key]["live"]	= $totalliveprofilesres;
	$arrReport[$key]["dmoain"]	= $arrPrefixDomainList[$arrMatriIdPre[$key]];
	
	$totalliveprofilesresAll += $totalliveprofilesres;
}

$i=0;
$content =' <TABLE cellpadding=5 cellspacing=1 style="border:1px solid #6600CC;font:12px arial;">
  <TR style="background:#6600CC;font-weight:bold;color:#FFFFFF;">
	<TD>Domain</TD>
	<TD>Total Live Profiles</TD>
	<TD>Mails Sent</TD>
	<TD>New Profiles</TD>
  </TR>';
 foreach($arrReport as $domainid => $data) {
	$content .= '<TR style="background:';
	if($i%2 == 0)
		$content .='#F0E1FF';
	else 
		$content .='#FFFFFF';
	$content .= '"><TD>'.ucfirst($data['dmoain']).'</TD>
	<TD>'.$data['live'].'</TD>
	<TD>'.$data['mails'].'</TD>
	<TD>'.$data['profs'].'</TD>
  </TR>';
	$i++;
 }
 $content .= '<TR style="background:#000099;color:#FFFFFF;">
	<TD>Total</TD>
	<TD>'.$totalliveprofilesresAll.'</TD>
	<TD>'.$totalmailsresAll.'</TD>
	<TD>'.$totalnewprofilesresAll.'</TD>
  </TR>
  </TABLE>';

$headers = "From: Communitymatrimony <info@communitymatrimony.com>\n";
$headers .= "X-Mailer: PHP mailer\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$to="mahadevan@bharatmatrimony.com,jshree@bharatmatrimony.com,shankar@consim.com,kannan@consim.com,mohanasundaram@consim.com,sai@bharatmatrimony.com,parul@consim.com,jeyakumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com,ashokkumar@bharatmatrimony.com";
$subject="[CommunityMatchwatch Delivery Report][".date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-1,date("Y")))."]";
mail($to,$subject,$content,$headers);
echo "mail sent to ".$to;

/*$headers = "From: Communitymatrimony <info@communitymatrimony.com>\n";
$headers .= "X-Mailer: PHP mailer\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$to="greennjk@gmail.com";
$subject="[Matchwatch][Delivery Report][".date('d-m-Y')."]";
mail($to,$subject,$content,$headers);
echo "mail sent to ".$to;*/
?>
