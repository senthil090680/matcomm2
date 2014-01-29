<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-19
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================

$varRootBasePath	= '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/cityarray.cil14');

if ($confValues['DOMAINCONFFOLDER'] !="") {

	include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");

}//if

//$domainarr  = explode('/',$confValues['DOMAINCONFFOLDER']);
//$domainname = ucwords($domainarr[1]);
$domainname = $varUcDomain;


//NEW KEYWOEDS
$newKeyWords = array('Bride','Brides','Boy','Boys','Girl','Girls','Groom','Grooms','Matrimony','Matrimonial','Matrimonials','Marriage','Matrimonial site','Matrimonial sites');


?>
<style type="text/css">
.und {color:#000000;text-decoration:underline;}
a.und:hover{text-decoration:underline;}
</style>
<div class="rpanel fleft">
	<div class="normtxt1 clr padb5"><font class="clr bld"><h1 style="color:#000000;font-size:18px;"><?=$website_heading;?></h1></font><a name="top"></a></div>
	<div class="linesep"><img width="1" height="1" src="<?=$confValues['IMGSURL']?>/trans.gif"/></div>
	<div class="smalltxt clr padt5">View Matrimonial Profiles by :</div>
	<div class="smalltxt clr2 padt5">
		<?
                    $val = $domainname;
					$castelist='<ul>';
					for($i=0;$i<14;$i++){
					$link_val = $val."+".$newKeyWords[$i];
					$show_val = $val." ".$newKeyWords[$i];
                    $link_val = str_replace(array('Matrimonial sites','Matrimonial site'),array('Matrimonial+sites','Matrimonial+site'),$link_val);
					$castelist.='<li><a href="'.$confValues['SERVERURL'].'/matrimonials/'.$link_val.'" class="smalltxt und" title="'.$show_val.'">'.$show_val.'</a> &nbsp; </li>';
					}
					echo $castelist.='</ul>';

		?>
		</div><br clear="all">
	</div>
