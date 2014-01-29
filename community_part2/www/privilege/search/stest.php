<?php


$viewid = "H1973092";
$pid1=crypt($viewid,"RPH");
$pid2=crypt($pid1,"BM");
$PID=urlencode ($pid2);
echo $PID;

echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/>";

echo urlencode(crypt(crypt($viewid,"RPH"),"BM"));

?>