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
//error_reporting(E_ALL);
//ini_set('display_errors','1');
	$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
	include_once($varRootBasePath.'/conf/config.cil14');
///	include_once($varRootBasePath.'/conf/ip.cil14');
//	include_once($varRootBasePath.'/conf/dbinfo.cil14');
	//include_once($varRootBasePath."/lib/clsDB.php");

	//include_once($varRootBasePath.'/www/privilege/include/rmclass.php');

	if(@$_GET['MEMID_RMINTER']!=""){$rmmemid=@$_GET['MEMID_RMINTER'];}else{$rmmemid=@$_GET['MEMID'];} 	

   if(($_GET['MEMID_RMINTER']!="")or($_GET['MEMID'])){	

		if(!$sender){
			//$sender=$rmclass->slave;
		}
		/*echo 'rmmemid='.$rmmemid;
		$objDBHeader	= new DB;
		$objDBHeader->dbConnect('S',$varDbInfo['DATABASE']);
		$varFields		= array('MatriId','Name','Nick_Name');
		$varCondition	= " WHERE MatriId='".$rmmemid."'";
		$varRecordCount	= $objDBHeader->numOfRecords($varTable['MEMBERINFO'], 'MatriId', $varCondition);

		if ($varRecordCount=='1') {
			$varExecute			= $objDBHeader->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
			$varMemberInfo		= mysql_fetch_assoc($varExecute);
			$varMemberMatriId	= $varSelectLoginInfo1["MatriId"];
			$varNickName		= $varSelectLoginInfo1["Nick_Name"];
			$varName			= $varSelectLoginInfo1["Name"];
			$varMemberName		= $varNickName ? $varNickName : $varName;
			$varMemberName		= ucwords(strtolower($varMemberName));
		}
		$objDBHeader->dbClose();
		UNSET($objDBHeader);*/

			//$varMemberMatriId	= 'AGR100200';
			//$varMemberName		= ucwords(strtolower('test'));

		if($varAct=="rmprofiledetails"){
			//$profile =1;
			if($profile ==1){
				$msgname = "You are currently viewing the profile of (&nbsp;".$varMemberMatriId."/". $varMemberName."&nbsp;)";
			}
			else if($profile ==2){
				$msgname = "You are currently searching for a suitable alliance for (&nbsp;".$varMemberMatriId."/". $varMemberName."&nbsp;)";
			}
			else if($profile ==3){
				$msgname = "You are currently viewing the short listed profiles of  (&nbsp;".$varMemberMatriId."/". $varMemberName."&nbsp;)";
			}
		}else if($varAct=="rmprofileview"){
			if($profile ==1){
				$msgname = "You are currently viewing the profile of (&nbsp;".$varMemberMatriId ."/". $varMemberName."&nbsp;)";
			}
			else if($profile ==2){
				$msgname = "You are currently searching for a suitable alliance for (&nbsp;".$varMemberMatriId ."/". $varMemberName."&nbsp;)";
			}
			else if($profile ==3){
				$msgname = "You are currently viewing the short listed profiles of  (&nbsp;".$varMemberMatriId ."/". $varMemberName."&nbsp;)";
			}
		}else if($varAct=="rmlistall"){
			$msgname = "You are currently viewing the short listed profiles of  (&nbsp;".$varMemberMatriId ."/". $varMemberName."&nbsp;)";
		}
		else {
			$msgname ="(&nbsp;".$varMemberMatriId ."/". $varMemberName."&nbsp;)";
		}
   }
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$confValues["PRODUCTNAME"]?>.Com</title>

<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<script> var imgs_url = '<? echo $confValues["IMGSURL"];?>';</script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/hintbox.js" ></script>
</head>
<body>
<table cellpadding="0" cellspacing="0" width="778" align="center" class="brdr">
	<tr>
		<td height="60" style="padding-left:15px;"><a href="<?=$confValues["SERVERURL"]?>/privilege/mainindex.php"><img src="<?=$confValues["IMGSURL"]?>/logo/community_logo.gif" border="0"></a>
		 </td>
	</tr>
	<tr>
		<td width="770">
			<table cellpadding="0" cellspacing="0" width="100%" align="center" style="border-bottom:1px solid #cbcbcb;">
				<tr>
					<td align="right" width="770">
						<table cellpadding="0" border="0" width="100%" cellspacing="0" align="right">
						<? if ($sessRMUsername!='') {
							if ($_REQUEST["print"]!='yes') {
							include_once($varRootBasePath.'/www/privilege/addheader.php'); 
						}
						} ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>