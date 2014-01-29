<?php
	
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
$varRootBasePath	= '/home/product/community';

//INCLUDE FILES
include_once($varRootBasePath.'/lib/clsDB.php');

//CREATE OBJECT
$objDB = new DB;

//CONNECT DATABASE
$objDB->dbConnect('M','communityproduct');

$varCondition	= " WHERE ActiveStatus=0";
$varFields 		= array('Id','DomainName');
$varExecute		= $objDB->select('domaininfo',$varFields,$varCondition,0);



	$varDomainList	= '';	
	while($varDomainInfo = mysql_fetch_array($varExecute)){

		$varDomainList	.= '<option value="'.$varDomainInfo["Id"].'">'.$varDomainInfo["DomainName"].'</option>';
	
	}//foreach




$objDB->dbClose();
?>
<form name="domainForm" method="post" action="domaindetails.php">
<br><br>
Select Domain : <select name="domainId">
					<option value="">Select Domain Name</option>
					<?=$varDomainList?>
				</select>
				<input type="submit" name="go" value="Next >>">
</form>