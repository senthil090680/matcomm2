<?php
#================================================================================================================
# Author 		: Srinivasan
# Start Date	: 2009-02-19
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Register
#================================================================================================================
//ROOT DIR
$varRootBasePath = '/home/product/community';

//INCLUDED FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsBasicviewHTML.php');
include_once($varRootBasePath.'/lib/clsBasicview.php');

if ($confValues['DOMAINCONFFOLDER'] !="") {		
	include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
}//if

//OBJECT DECLARATION
$objBasicView	    = new BasicView;
$objBasicViewHTML	= new BasicViewHTML;

//Connect DB
$objBasicView->dbConnect('S', $varDbInfo['DATABASE']);

//SESSION OR COOKIE VALUES
$sessMatriId						= $varGetCookieInfo["MATRIID"];
$objBasicViewHTML->clsServerUrl		= $confValues["SERVERURL"];
$objBasicViewHTML->clsImgsUrl		= $confValues["IMGSURL"];
$objBasicViewHTML->clsPhotoUrl		= $confValues["PHOTOURL"];
$objBasicViewHTML->clsSessMatriId	= $sessMatriId?$sessMatriId:$_REQUEST['regid'];
$varDomainId						= $confValues["DOMAINCASTEID"];

$varWhereCond	       = " WHERE MatriId=".$objBasicView->doEscapeString($_REQUEST['regid'],$objBasicView)."";
$argCondition['LIMIT'] = $varWhereCond;
$varResult             = $objBasicView->selectDetails($argCondition,''); 
$varCount	           = count($varResult);


?>
	<div class="padt10 rpanelinner" style="width:560px;border:1px solid #CBCBCB">
	<? if ($varCount >'0') { ?>
	<div class="padt10 rpanelinner" style="padding-left:35px;padding-bottom: 10px">
	<?	$objBasicViewHTML->basicview($varResult,1); ?>
	</div>
	<? } else { echo 'Sorry, no matching profiles available. Refine your search to get matches'; } ?>
	</div>
	
<?
//UNSET OBJECT
$objBasicView->dbClose();
unset($objBasicView);
unset($objBasicViewHTML);
?>
