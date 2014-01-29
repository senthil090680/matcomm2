<?php
$evid=trim($_GET['evid']);
$cookieexpire = $_SERVER['SERVER_NAME'];
$cookieexpire = str_replace(array("www","bmser"),"",$cookieexpire);
setcookie("Memberid"," ",time()-6000,"/",$cookieexpire);
setcookie("password"," ",time()-6000,"/",$cookieexpire);
setcookie("Gender"," ",time()-6000,"/",$cookieexpire);


header('Location:vmlogin.php?evid='.$evid.'');
?>
