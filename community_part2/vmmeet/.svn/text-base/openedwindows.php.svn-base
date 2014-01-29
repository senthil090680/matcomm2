<?php  

$thefile = "openedwindows.htm"; /* Our filename as defined earlier */
echo $towrite = $_REQUEST["win"];  /* window names that  we'll write to the file */
$openedfile = fopen($thefile, "w");

if($towrite !="") {

	if(fwrite($openedfile, $towrite)){
	echo "sucess";
	}
	else{
	echo "fail";
	}

}


?>
