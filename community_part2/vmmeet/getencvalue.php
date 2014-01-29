<?php 
  $matriid = $_GET['matriid'];
  $type    = $_GET['type'];
 
function fle_encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
	$char = substr($string, $i, 1);
	$keychar = substr($key, ($i % strlen($key))-1, 1);
	$char = chr(ord($char)+ord($keychar));
	$result.=$char;
	}
	return base64_encode($result);
	}

function fle_decrypt($string, $key) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
		 $char = substr($string, $i, 1);
		 $keychar = substr($key, ($i % strlen($key))-1, 1);
		 $char = chr(ord($char)-ord($keychar));
		 $result.=$char;
		}
		return $result;
	}
    if($type =='enc')
	echo $encrypted_matid    = fle_encrypt($matriid,'ec3hk4bo1u6n4ce19');
	else
	echo $decrypted_matid    = fle_decrypt($matriid,'ec3hk4bo1u6n4ce19');


?>