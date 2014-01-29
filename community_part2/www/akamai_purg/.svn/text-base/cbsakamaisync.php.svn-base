<?php
//FILE INCLUDES
$varServerBasePath	= '/home/product/community';
include_once($varServerBasePath.'/conf/dbinfo.inc');
include_once($varServerBasePath.'/conf/config.inc');
include_once($varServerBasePath."/conf/basefunctions.inc");
include_once($varServerBasePath.'/conf/domainlist.inc');

ini_set('display_errors',1);

if($_POST['submit'] == 'submit') {
	$value	= $_POST['field'];
	if($value==""){
		echo "<h4>Please enter file name</h4>";
		exit;
	}

	//$arrPrefixDomainList = array('AGR'=>'agarwalmatrimony.com', 'IYR'=>'iyermatrimony.com');

	$arrPassedValue = explode(",",$value);
	$varCnt = count($arrPassedValue);

	for($i=0; $i<$varCnt; $i++) {
		$varPurgeValue = trim($arrPassedValue[$i]);
		foreach($arrPrefixDomainList as $varPrefix=>$varDomainName){
			$file="http://imgs.".$varDomainName.$varPurgeValue;
			if (trim($varPurgeValue)!='') {
				$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
				$output=escapeexec("perl /home/product/community/bin/akamaisync.pl --user bmimgpur --pwd 49972d --file $file", $varlogFile);
				$output=str_replace("\n","<BR>",$output);
				echo $file."<BR>".$output."<HR>--";
			}
		}
	}
} else {
?>
<table align="center">
	<form name="akamaiform" method="post" action="cbsakamaisync.php" onSubmit="return chkForm();">
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