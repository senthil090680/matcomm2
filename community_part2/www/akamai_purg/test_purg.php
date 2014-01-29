<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Mariyappan
/* Date	        : 12 January 2011
/* Project		: Community Product Matrimony
/* Filename		: test_purg.php
/* ______________________________________________________________________________________________________________________*/
/* Description   :
/* ______________________________________________________________________________________________________________________*/

/* FILE INCLUDES */
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.inc');
include_once($varServerBasePath.'/conf/config.inc');
include_once($varServerBasePath.'/conf/domainlist.inc');

$countFile=1;
$currTime=time();

$varPurgFilePath = $varServerBasePath."/www/akamai_purg/purgfiles/";

if (isset($_POST['submit'])) {

	$valueArr=array();
    $valueArr=explode("\n",trim($_POST['field']));
	echo "RANDOM FILE NAME <B>$currTime</B> <HR>";

	foreach($valueArr as $value) {
		$countFlag=1;
		$myFile = $varPurgFilePath.$currTime."_".$countFile.".txt";
		echo "<b>$countFile). $myFile</b> <HR>";
		$fh = fopen($myFile, 'w') or die("can't open file");

	foreach($arrPrefixDomainList as $varPrefix=>$varDomainName) {

		$file="http://imgs.".$varDomainName.$value;
		$stringData='';
		if ($value!='') {


			if(($countFlag%5)==0)
			{
            echo $countFlag.") ".$file."<HR>";
            $stringData.=$file.PHP_EOL;
            fwrite($fh, $stringData);
            fclose($fh);
			$countFile++;
		    $myFile = $varPurgFilePath.$currTime."_".$countFile.".txt";
			echo "<b>$countFile). $myFile</b> <HR>";
            $fh = fopen($myFile, 'w') or die("can't open file");
			}
			else
			{
            echo $countFlag.") ".$file."<BR>";
			$stringData.=$file.PHP_EOL;
            fwrite($fh, $stringData);
			}

			}
      $countFlag++;
	  if ($countFile==3) {
		  exit;
	  }

	}
 echo "<hr>";
 fclose($fh);
 $countFile++;

 }

 for($i=1;$i<$countFile;$i++) {
      $myFile = $varPurgFilePath.$currTime."_".$i.".txt";
 	  echo "$i) /home/product/community/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $myFile --email mariyappan.c@bharatmatrimony.com <br>";
 }

} else {
?>
<table align="center">
	<form name="akamaiform" method="post" action="test_purg.php" onSubmit="return chkForm();">
	<tr><td align="center">
		File name: <textarea name="field"></textarea><br>
		<input type="submit" name="submit" value="submit">
	</td></tr>
	</form>
</table>

<script language="javascript">
function chkForm() {
	if(document.akamaiform.field.value=='') {
		alert("Please enter file name");
		return false;
	}

	return true;
}
</script>
<? } ?>