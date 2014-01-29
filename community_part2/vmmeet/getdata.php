<?php 
  $evid= $_GET['evid'];
  $opposite_gender =  $_GET['opposite_gender'];
  $openfire = $_GET['openfire'];

//echo "http://".$openfire.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=text";
if($openfire=='172.22.0.103'){
$data = file_get_contents("http://".$openfire.":9092/plugins/presence/status?jid=all@$evid~$opposite_gender&type=text");
}else{
$data = file_get_contents("http://".$openfire.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=text");
}

$data = str_replace('[','',$data);
$data = str_replace(']','',$data);
$data = trim($data);

echo $data;
?>