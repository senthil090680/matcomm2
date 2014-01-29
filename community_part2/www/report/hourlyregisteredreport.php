<?php
$varReportRootBasePath	= '/home/product/community';

//FILE INCLUDES
include_once($varReportRootBasePath."/conf/config.inc");
include_once($varReportRootBasePath."/conf/dbinfo.inc");
include_once($varReportRootBasePath."/conf/vars.inc");
include_once($varReportRootBasePath."/lib/clsDB.php");
include_once($varReportRootBasePath.'/lib/clsReport.php');

//OBJECT DECLARATION
$objSlaveDB			= new DB;
$objReport	        = new Report;

$varSlaveConn		= $objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);
?>

<script language="javascript" src="<?=$confValues['JSPATH'];?>/calenderJS.js"></script>
<link rel="stylesheet" href="<?=$confValues['CSSPATH'];?>/calendar.css">
	<form name="frmDailyReport" method="post">
		<input type="hidden" name="frmDailyReportSubmit" value="yes">
		<input type="hidden" name="manual" value="<?=($_REQUEST['manual']=='yes')?'yes':'no';?>">
		<table>
		<tr><td colspan="2"><h3> Daily Report: CommunityMatrimony.com<h3> </td></tr>
		<tr>
			<td class="grtxtbold1" valign=middle style="padding-left:5px;" align='left'><font style="font-family: MS sans-serif, Arial, Verdana, Helvetica; font-size: 15px"><b>Select Report Date</b><br>(YYYY-mm-dd)</font></td><td  valign=middle  align='left' class="smalltxt"><input type='text' class='smalltxt' name='fromdate' value="<?=date('Y-m-d');?>" /><a
			href="javascript:displayDatePicker('fromdate', false, 'ymd', '-');"><img src="<?=$confValues['IMGSURL'];?>/cal.gif" align="absMiddle"
			border="0"></a></td><td><input type="submit" value="submit" name="submit"></td>
		</tr>
		</table>
	</form>

<?php
$varDate= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));

if($_REQUEST['frmDailyReportSubmit'] == 'yes' || $varDate)
{
	if($_REQUEST['fromdate'] == '')
	$_REQUEST['fromdate']=$varDate;

    $varFields		= array("extract(HOUR FROM Date_Created) as HOUR","COUNT(extract(HOUR FROM Date_Created)) as COUNT");

	$varCondition	= " WHERE Date_Created >= '".$_REQUEST['fromdate']." 00:00:00' AND Date_Created <= '".$_REQUEST['fromdate']." 23:59:59' AND BM_MatriId = '' GROUP BY HOUR";

    //$varCondition	= " WHERE DATE(Date_Created) = '".$_REQUEST['fromdate']."' and BM_MatriId = '' GROUP BY HOUR";
    $varExecute		= $objSlaveDB->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);

	$varMessage			= '<table width="400" border = "1" cellspace="2" style="background-color:#E9EAC8;" align="center"><tr style="font: normal 11:px verdana,tahoma;padding-bottom:15px;background-color:#73C03B;"><td colspan="2" align="center"><b>Duration :</b>'.$_REQUEST['fromdate'].'</td></tr><tr style="font: normal 15:px verdana,tahoma;padding-bottom:15px;"><td  align="center"><B>Hours</b></td><td  align="center"><b>Count</b></td></tr>';
    
	$varCountResult=array();
	while($row = mysql_fetch_assoc($varExecute))
	{
	  array_push($varCountResult,$row);
	}
    
    for($i=0; $i<24;$i++)
    {
	   $varTempValue=0;$varTempArray=array();
	   foreach($varCountResult as $key=>$value)
	   {  
		 if(($value['HOUR'] == $i))
		 {
		    array_push($varTempArray,$value['COUNT']);
		    $varTempValue=1;
		    break;
		 }
		 else
		 {
		    $varTempValue=0;
		 }
	   }
       if($varTempValue==1)
	   {
          $varMessage.='<tr style="font: normal 11px verdana,tahoma;padding-bottom:15px;padding-top:10px;" ><td width="50%" align="center">'.$i.'-'.($i+1).'</td><td width="50%" align="center">'.$varTempArray[0].'</td></tr>';
		  $varTotal+=$varTempArray[0];
	   }
	   else
	   {
		  $varMessage.='<tr style="font: normal 11px verdana,tahoma;padding-bottom:15px;padding-top:10px;" ><td width="50%" align="center">'.$i.'-'.($i+1).'</td><td width="50%" align="center">0</td></tr>';
	   }

    }

	$varTotal=($varTotal=='')?0:$varTotal;
	$varMessage.='<tr style="font: normal 15:px verdana,tahoma;padding-bottom:15px;"><td align="center"><b>Total</b></td><td align="center"><b>'.$varTotal.'</b></td></tr></table>';
	$varMessage		=  '<h3>Hourly based registration count on '.$_REQUEST['fromdate'].'</h3>'.$varMessage;
    $varSubject 	=  'Hourly based registration count on '.$_REQUEST['fromdate'];
    echo $varMessage;
    //$varMailSend=$objReport->sendEmail("Communitymatrimony.Com","admin@communitymatrimonial.com","Support","dhanapal.n@gmail.com",$varSubject,$varMessage,"support@communitymatrimonial.com");

$argFrom = "webmaster";
$argFromEmailAddress  	= "admin@communitymatrimony.com";
$argTo					= "Community Matrimony report";

	$argToEmailAddress 		= "nazir@bharatmatrimony.com,ashokkumar@bharatmatrimony.com,dhanapal@bharatmatrimony.com";
	$argSubject		   		= "[Community Matrimony - CBS][".$_REQUEST['fromdate']."][Hourly Profiles Report]";
//$argMessage		   		= $varHeading.'<br clear="all">'.$varProfileDetails.'<br clear="all">'.$varPaymentDetails.'<br clear="all">'.$varCountryList.'<br><br clear="all"><table border="0" width="100%" align="center"><tr><td align="right"><font style="font-size:12px;" >Automated Report genrated by CommunityMatrimony.com</font></td></tr></table>';
$argReplyToEmailAddress = "webmaster@communitymatrimony.com";

$varMailSend			= $objReport->sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$varMessage,$argReplyToEmailAddress);



	if ($varMailSend == 'yes')
	  echo "<br clear='all'><b>Email has been Sent Successfully</b>";
    else
	  echo "<br clear='all'><b>Email was unable to send</b>";
}
?>