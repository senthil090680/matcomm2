<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Text File Creation for VMM Mailer.
#=============================================================================================================
$varRootBasePath = '/home/product/community'; 
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/cityarray.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

$ReportHeaders  =  "";
$ReportHeaders .= "From: info@communitymatrimony.com\n";
$ReportHeaders .= "X-Mailer: PHP mailer\n";
$ReportHeaders .= "Content-type: text/html; charset=iso-8859-1\n";
$ReportHeaders .= "Sender: Communitymatrimony.com<info@communitymatrimony.com>\n";

//OBJECT DECLARATION
$objSlave = new DB;
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);

$todate    = date('Y-m-d')." 23:59:59"; 
$fromdate  = date("Y-m-d", mktime(0, 0, 0, date('m')-6, date('d'), date('Y')))." 00:00:00";
$totalcastecount='';

$EventTitleArr = array(107=>'Hindu - Lohana',113=>'Hindu - Maheshwari',237=>'Hindu - Vokkaliga',99=>'Hindu - Kunbi');
$EventDateArr  = array(107=>'2010-07-17',113=>'2010-07-17',237=>'2010-07-18',99=>'2010-07-18');
$EventStartTimeArr= array(107=>'10:00:00',113=>'17:00:00',237=>'10:00:00',99=>'17:00:00');
$EventEndTimeArr  = array(107=>'12:00:00',113=>'19:00:00',237=>'12:00:00',99=>'19:00:00');
$EventIdArr       = array(107=>'1',113=>'2',237=>'3',99=>'4');

$varCondition		= " where  CommunityId IN (107,113,237,99) group by CommunityId";
$varFields			=  array('count(CommunityId)','CommunityId');
$comm_count	        = $objSlave->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);


ini_set('display_errors',1);
error_reporting(E_ALL);


/**************  WHILE LOOP EXECUTE THE NO OF PRCASE2 MEMBER CASTE **************/
while($casterow = mysql_fetch_assoc($comm_count)){
	
	$varCondition1		= " where  CommunityId =".$casterow['CommunityId']." AND (Publish=1 OR Publish=2)";
    $varFields1			= array('MatriId','Paid_Status','Country','Name','Religion','CasteId');
    $memberExe	        = $objSlave->select($varTable['MEMBERINFO'],$varFields1,$varCondition1,0);

	$totalcastecount.=($casterow['CommunityId']."~".$casterow['count(CommunityId)']."<br>");

	/***************  WHILE LOOP GET THE DETAILS OF PRCASE2	MEMBERS  **************/
	$tot=1;
	$recordbasicview ='';
	$recordprcase    ='';
	while($memberDet = mysql_fetch_assoc($memberExe)){

		$communityId        = $casterow['CommunityId'];
		$PaidStatus         = $memberDet['Paid_Status']?'R':'F';
		$Name               = $memberDet['Name'];
		$Caste              = $memberDet['CasteId'];

		$varCondition2		= " where  MatriId ='".$memberDet['MatriId']."'";
        $varFields2			= array('MatriId','Email');
        $memberLoginExe	    = $objSlave->select($varTable['MEMBERLOGININFO'],$varFields2,$varCondition2,1);

		$recordprcase.=$tot."~~".trim($memberDet['MatriId'])."~~".trim($PaidStatus)."~~".trim($memberDet['Country'])."~~".$Name."~~".$memberLoginExe[0]['Email']."~~".$Caste."~~".$memberDet['Religion']."~~".$EventTitleArr[$Caste]."~~".$EventDateArr[$Caste]."~~".$EventStartTimeArr[$Caste]."~~".$EventEndTimeArr[$Caste]."~~".$EventIdArr[$Caste]."~~".trim($communityId)."\n";

		
	$tot++;		
	}
	    //echo "<br>Total : ".$tot;
	    $filepath = "/home/product/community/vmmeet/www/mailers/vmmdata/";
		//echo $filepath.'VMM-'.date('dMy').".txt";exit;
		$file     = fopen($filepath.'VMM-'.date('dMy').".txt","a+");
		fwrite($file,$recordprcase."\r\n");	
	
}
$objSlave->dbClose();

$Subject = "VMM Mailer - Community And Count";
$Content="<HTML><BODY><table border=1 style='font:normal 12px arial;color:#000000;'><tr><td bgcolor=#DADADA>VMM mailer Caste And Count </td><td> ".$totalcastecount." </td></tr></table></BODY></HTML>";

mail('srinivasan.c@bharatmatrimony.com',$Subject,$Content,$ReportHeaders);
echo "Count Mail sent success ";