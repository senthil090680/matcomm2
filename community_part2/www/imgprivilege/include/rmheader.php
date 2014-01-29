 <?php
#==========================================================================================================
# Author 		: Dhanapal, Srinivasan
# Date	        : 01 Jan 2010
# Project		: Community Matrimony RM Interface
# Filename		: rmheader.php
#==========================================================================================================
# Description   : Global and Configuration Variables
#==========================================================================================================

	//INCLUDE FILES
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
	include_once($varRootBasePath.'/conf/config.cil14');
	include_once($varRootBasePath.'/www/privilege/include/rmclass.php');

	$sessRMUsername = $_COOKIE['rmusername'];
		
	if(@$_GET['MEMID_RMINTER']!=""){$rmmemid=@$_GET['MEMID_RMINTER'];}else{$rmmemid=@$_GET['MEMID'];} 	

   if(($_GET['MEMID_RMINTER']!="")or($_GET['MEMID'])){	
		if(!$sender){
			$sender=$rmclass->slave;
		}
		$matrimonyprofile   = $varTable['MEMBERINFO'];
		//$rmmemid='AGR100200';
		$varActFields	= array("MatriId","Name");
		$varActCondtn	= " where MatriId='".$rmmemid."'";

		$rows		= $sender->select($varDbInfo['DATABASE'].".".$matrimonyprofile,$varActFields,$varActCondtn,1);
		
        // echo $_SERVER['SCRIPT_NAME'];
		if($_SERVER['SCRIPT_NAME']=="/privilege/rmprofiledetails.php"){
			//$profile =1;
			if($profile ==1){
				$msgname = "You are currently viewing the profile of (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
			}
			else if($profile ==2){
				$msgname = "You are currently searching for a suitable alliance for (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
			}
			else if($profile ==3){
				$msgname = "You are currently viewing the short listed profiles of  (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
			}
		}else if($_SERVER['SCRIPT_NAME']=="/privilege/rmprofileview.php"){
			if($profile ==1){
				$msgname = "You are currently viewing the profile of (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
			}
			else if($profile ==2){
				$msgname = "You are currently searching for a suitable alliance for (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
			}
			else if($profile ==3){
				$msgname = "You are currently viewing the short listed profiles of  (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
			}
		}else if($_SERVER['SCRIPT_NAME']=="/privilege/rmlistall.php"){
			$msgname = "You are currently viewing the short listed profiles of  (&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
		}
		else {
			$msgname ="(&nbsp;".$rows[0]['MatriId'] ."/". $rows[0]['Name']."&nbsp;)";
		}
   }

?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$confValues["PRODUCTNAME"]?>.Com</title>
<head><link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css"></head>
<body>
<table border="1" cellpadding="0" cellspacing="0" width="778" align="center">
	<tr>
		<td bgcolor="#ffffff"  align="left" valign="top"><a href="<?=$confValues["SERVERURL"]?>/privilege/rmindex.php"><img src="<?=$confValues["IMGSURL"]?>/logo/community_logo.gif" border="0"></a>
		 </td>
	</tr>