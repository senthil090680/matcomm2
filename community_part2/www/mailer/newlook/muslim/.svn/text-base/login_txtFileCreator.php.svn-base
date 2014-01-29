<?php
//FILE INCLUDES
include_once('/home/product/community/conf/ip.inc');

//connect mysql
$mysql_connection	= mysql_connect($varDbIP['S'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("communitymatrimony") or die('db_selection_error');

$varQuery	= "SELECT MatriId,Email,Password FROM communitymatrimony.memberlogininfo WHERE CommunityId=2503 AND MatriId LIKE 'MUS%'";
$varResult  = mysql_query($varQuery) OR die('select_error');
$varNo		= mysql_num_rows($varResult);

//FILE NAME
$varFilename= 'login-user-info.txt';
$varContent	= '';

//DELETE FILE
@unlink($varFilename);

//CREATE FILE
$varFileHandler	= fopen($varFilename,"w");

while($row = mysql_fetch_assoc($varResult)) {
	$varContent .= $row['MatriId'].'~'.$row['Password'].'~'.$row['Email']."\n";
}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);

mysql_close($mysql_connection) or die('error');
?>
