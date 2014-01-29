<?php
/*************************************************************************
	File  : prcase2splittxt.php
	Author: Iyyappan. N
	Date  : 17Jun2010
*************************************************************************
Description : prcase2splittxt file is used for spliting text file for live 
and test and also regarding the file size
*************************************************************************/

/*********************  INCLUDE FILES  ***********************************/
include_once "/home/cbsmailmanager/config/config.php";
$BasePath  =  "/home/cbsmailmanager/prcase2matchwatch/mailtext/";
ini_set("memory_limit","1024M");

$prcasegender = strtoupper($_SERVER['argv'][1]);
$MailerType	  = $_SERVER['argv'][2];
$Content      = "";

$date = date('Y-m-d h:i:s A');

	$ReportHeaders  =  "";
	$ReportHeaders .= "From: mailmanager@communitymatrimony.com\n";
	$ReportHeaders .= "X-Mailer: PHP mailer\n";
	$ReportHeaders .= "Content-type: text/html; charset=iso-8859-1\n";

if($prcasegender=="" && $MailerType="") {
	echo "Please enter the condition for Gender,MailerType Eg:filename.php Gender MailerType";
	exit;
}

/***************************  Initialization  *******************************/
 if($MailerType == 'test'){
	 $TestFileName = "testingids.txt";
	 $TxtFileName   = $BasePath.$TestFileName;
 } elseif($MailerType == 'live') {
	 $liveFileName  ="prcase".$prcasegender.'-'.date('dMy');
	 $TxtFileName   = $BasePath.$liveFileName.'.txt';
 } else {
	echo "Please enter the valid condition for mailer Type[Test,live] Eg:filename.php mailtype";
	exit;
 }

/****************************  Getting file	***********************************/
if(file_exists($TxtFileName)) {
	$BlockedIds = '';
	$StartTime  = date("Y-m-d h:m:s");
	$ReportPath = $MAILMANAGER_ROOTPATH."prcase2matchwatch/reports/";
	
	/**************************  File Spliting  **********************************/
	if($MailerType=='live') {
		shell_exec("cat '$TxtFileName' | wc -l",$sOut);
		if($sOut[0] > 800000) {
			$arrAlphabets = range('a','z');
			$arrSplitedText = array();
			$iAlpCnt = count($arrAlphabets);
			for($i=0;$i<$iAlpCnt;$i++) {
			  for($j=0;$j<$iAlpCnt;$j++) {
				array_push($arrSplitedText,$arrAlphabets[$i].$arrAlphabets[$j]);
			  }
			}
			$spfname=$liveFileName."_SPT_";
			$dir=1;

			shell_exec("split -l  800000 $TxtFileName ".$MAILMANAGER_ROOTPATH."prcase2matchwatch/mailtext/$spfname");
			shell_exec("ls ".$MAILMANAGER_ROOTPATH."prcase2matchwatch/mailtext/$spfname*|wc -l",$out);
			for($i=0;$i<$out[0];$i++) {
				$sSplitFile = "$spfname".$arrSplitedText[$i];
				$sSplitFiletxt=$sSplitFile.".txt"; 
				shell_exec("mv ".$MAILMANAGER_ROOTPATH."prcase2matchwatch/mailtext/$sSplitFile ".$MAILMANAGER_ROOTPATH."prcase2matchwatch/mailtext/$sSplitFiletxt");
			}
			$sentmail = "";
			$filesplitted="";
			for($i=0;$i<$out[0];$i++) {  //for each splited file... read the contents
				$sSplitFile = "$spfname".$arrSplitedText[$i];
				$fname=$sSplitFile.".txt"; 
				$sentmail = $sentmail."nohup php ".$MAILMANAGER_ROOTPATH."prcase2matchwatch/prcase2sendmail.php".escapeshellarg($fname)." > ".$ReportPath."Splog$prcasegender-".date('dMy')."-".($i+1).".txt & \n";
				$filesplitted = $filesplitted.$fname."\n";	
			}
			shell_exec ($sentmail);
		} else { // for live without split
			$fname=$liveFileName.".txt";
			$sentmail ="nohup php ".$MAILMANAGER_ROOTPATH."prcase2matchwatch/prcase2sendmail.php ".escapeshellarg($fname)." > ".$ReportPath."Usplog$prcasegender-".date('dMy').".txt & ";
			shell_exec ($sentmail);
			$filesplitted='N/A';
		}
		$Subject = "Prcase2basicview Mailer Triggered";
		$Content="<HTML><BODY><table border=1 style='font:normal 12px arial;color:#000000;'><tr><td bgcolor=#DADADA>Prcase2basicview mailer Triggered on </td><td> ".$date." </td></tr><tr><td bgcolor=#DADADA> Base filename with path </td><td> ".$TxtFileName." </td></tr><tr><td bgcolor=#DADADA>List of Splitted Files  </td><td> ".$filesplitted."<br /></td></tr><tr><td bgcolor=#DADADA>Send Mail</td><td> ".$sentmail."<br /></td></tr></table></BODY></HTML>";

		mail('mail2ifan@gmail.com',$Subject,$Content,$ReportHeaders);
	} else {  // for testing
		$fname=$TestFileName;
		$testing = "Testlog-".date('dMy').".txt";
		if(file_exists($ReportPath.$testing)) {
			unlink($ReportPath.$testing);
			echo "file deleted and recreated";
		}
		$sentmail ="nohup php prcase2sendmail.php ".escapeshellarg($fname)."  > ".$ReportPath."Testlog$prcasegender-".date('dMy').".txt & ";
		shell_exec ($sentmail);

		$Subject = "Prcase2basicview Mailer Testing Done";
		$Content="<HTML><BODY><table border=1 style='font:normal 12px arial;color:#000000;'><tr><td bgcolor=#DADADA>Prcase2basicview mailer Triggered on </td><td> ".$date." </td></tr><tr><td bgcolor=#DADADA> Test FileName : </td><td> ".$fname." </td></tr></table></BODY></HTML>";

		mail('mail2ifan@gmail.com',$Subject,$Content,$ReportHeaders);
	}
} else { //If File not found
	echo "\nInput file - $TxtFileName does not exist! Pls check.";
	$Subject = "Prcase2basicview Mailer - Failed to Read File";
	$Content="<HTML><BODY><table border=1 style='font:normal 12px arial;color:#000000;'><tr><td bgcolor=#DADADA>Prcase2basicview mailer Triggered on </td><td> ".$date." </td></tr><tr><td colspan=2 > Input File : ".$TxtFileName." does not exist! Pls check </td></tr></table></BODY></HTML>";

	mail('mail2ifan@gmail.com',$Subject,$Content,$ReportHeaders);
}

?>