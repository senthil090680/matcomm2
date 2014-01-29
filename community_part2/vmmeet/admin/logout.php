<?php
$cookieexpire = $_SERVER['SERVER_NAME'];
$cookieexpire = str_replace(array("www","bmser"),"",$cookieexpire);
setcookie("adminusername"," ",time()-6000,"/",$cookieexpire);
setcookie("adminpassword"," ",time()-6000,"/",$cookieexpire);
header('Location:index.php');
?>
