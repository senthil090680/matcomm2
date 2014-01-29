<?php
#==========================================================================================================
# Author 		: Dhanapal, Srinivasan
# Date	        : 01 Jan 2010
# Project		: Community Matrimony RM Interface
# Filename		: rmheader.php
#==========================================================================================================
# Description   : Main
#==========================================================================================================

//INCLUDE FILES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/www/privilege/include/rmclass.php');

if(isset($_POST['submit']))
{
	$rmclass=new rmclassname();
	$rmclass->init();
	$rmclass->rmConnect();
	$rmclass->username=mysql_escape_string($_POST['adusername']);
	$rmclass->password=mysql_escape_string($_POST['adpassword']);
	$affectrows=$rmclass->loginvalidation();
    $pos = strpos($rmclass->username, '@'); 
	   	if($affectrows>=1){
			 if($pos === false){ //echo 'Inn';exit;
				setcookie("rmusername", $_POST['adusername'], time()+3600);
				header("location:mainindex.php?act=rmhome");exit;
			 }else{echo 'Else';exit;
			     $getid=$rmclass->getrmid();
				 setcookie("rmusername", $getid, time()+3600);
				 header("location:mainindex.php?act=rmhome");exit;
			 }
	} else { $varAct='login'; $Message="Invalid Username/Password";  }

	$rmclass->dbClose();
	UNSET($rmclass);
}
?>