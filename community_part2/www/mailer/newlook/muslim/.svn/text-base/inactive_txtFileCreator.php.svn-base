<?php
//FILE INCLUDES
include_once('/home/product/muslim/conf/ip.inc');

//connect mysql
$mysql_connection	= mysql_connect($varDbIP['S'],$varDBUserName,$varDBPassword) or die('connection_error');
$mysql_select_db	= mysql_select_db("mmatrimony") or die('db_selection_error');

$varQuery	= " SELECT A.User_Name,A.Email FROM mmatrimony.memberlogininfo A, mmatrimony.memberinfo B  WHERE A.MatriId=B.MatriId AND B.Date_Created < '2009-04-12 00:00:00' AND B.Last_Login < '2009-04-12 00:00:00' ";
$varResult  = mysql_query($varQuery) OR die('select_error');
$varNo		= mysql_num_rows($varResult);

//FILE NAME
$varFilename= 'inactive_user.txt';
$varContent	= '';

//DELETE FILE
@unlink($varFilename);

//CREATE FILE
$varFileHandler	= fopen($varFilename,"w");

while($row = mysql_fetch_assoc($varResult)) {
	$varContent .= $row['User_Name'].'~'.$row['Email']."\n";
}
fwrite($varFileHandler,$varContent);
fclose($varFileHandler);

mysql_close($mysql_connection) or die('error');
?>
