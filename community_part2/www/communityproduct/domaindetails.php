<?php

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath	= '/home/product/community';

//INCLUDE FILES
include_once($varRootBasePath.'/lib/clsDB.php');

//CREATE OBJECT
$objDB = new DB;

//CONNECT DATABASE
$objDB->dbConnect('M','communityproduct');


//VARIABLE DECLARATION
$varDomainId	= $_POST["domainId"];


$varCondition	= " WHERE ActiveStatus='Y' AND Id=".$varDomainId;
$varFields 		= array('Id','DomainName','CategoryId','DomainKey','MatriIdPrefix','DomainFolder');
$varExecute		= $objDB->select('domaininfo',$varFields,$varCondition,0);
$varDomainInfo	= mysql_fetch_array($varExecute);

$objDB->dbClose();
?>
<form name="domainDetails" method="post" action="execute.php">
<input type="hidden" name="domainId" value="<?=$varDomainId?>">


	Domain Name : <?=$varDomainInfo["DomainName"]?><br><br>
	Domain Key : <?=$varDomainInfo["DomainKey"]?><br><br>
	Domain Prefix : <?=$varDomainInfo["MatriIdPrefix"]?><br><br>
	Domain Folder : <?=$varDomainInfo["DomainFolder"]?><br><br>
	<input type="submit" name="go" value="Install">
</form>