<?php
//FILE INCLUDES
include_once('/home/product/community/conf/ip.inc');

//connect mysql
$mysql_connection	= mysql_connect($varDbIP['S'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

$varQuery	= "SELECT MatriId,User_Name,Email,Password FROM communitymatrimony.memberlogininfo WHERE CommunityId=2500 AND MatriId LIKE 'CHR%'";
$varResult  = mysql_query($varQuery) OR die('select_error');
$varNo		= mysql_num_rows($varResult);

//FILE NAME
$varFilename= 'userinfo.txt';
$varContent	= '';

//DELETE FILE
@unlink($varFilename);

//CREATE FILE
$varFileHandler	= fopen($varFilename,"w");

while($row = mysql_fetch_assoc($varResult)) {
	$varContent .= preg_replace("/^CHR\-/", '', $row['User_Name']).'~'.$row['MatriId'].'~'.$row['Password'].'~'.$row['Email']."\n";
}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);

mysql_close($mysql_connection) or die('error');
?>
