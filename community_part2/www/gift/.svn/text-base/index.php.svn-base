<?php
#====================================================================================================
# Author 		: Mariyappan C
# Start Date	: 01 March 2011
# End Date		: 01 March 2011
# Project		: MatrimonyProduct
# Module		: MatrimonyGift - API
#====================================================================================================


define('ACCESS_USER','matrimonygifts');
define('ACCESS_PASS','m@TriM0nyg1ft$');


function doencrypt($key,$string) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)+ord($keychar));
                $result.=$char;
        }
        return base64_encode(gzdeflate(base64_encode($result)));
}

if(isset($_POST['btnSubmit']))
{
	$varKey           =  'M10u2S78ru0G8aIV276el';

	$varUserName      =  doencrypt($varKey,trim($_POST['txtUserName']));

	$varPassword      =  doencrypt($varKey,trim($_POST['txtPassword']));

    $varPostMessage   =  "&LOGIN_ID=$varUserName";

	$varPostMessage  .=  "&LOGIN_PASSWORD=$varPassword";

	$varCurlUrl       = "http://www.communitymatrimony.com/gift/initcurl.php";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $varCurlUrl);

	curl_setopt($ch,CURLOPT_POSTFIELDS,$varPostMessage);

	curl_setopt($ch, CURLOPT_USERPWD, ACCESS_USER .':'. ACCESS_PASS);

	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	$output= curl_exec($ch);	

    curl_close($ch); 

	echo $output;
}
else{
?>
<html>
<head><title>BMGift</title></head>
<body>
<form name="bmgift" id="bmgift" method="post">
<table border='0'><tr>
<td>Enter MatriId:</td>
<td><input type="text" name="txtUserName" id="txtUserName"></td>
</tr>
<tr><td>Enter Password:</td>
<td><input type="password" name="txtPassword" id="txtPassword"></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
</td>
</tr>
</table>
</form>
</body>
</html>
<? }?>
