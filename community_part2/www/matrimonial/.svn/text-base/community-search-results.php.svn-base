<?php
#================================================================================================================
# Author 		: Senthilnathan
# Start Date	: 2009-02-19
# End Date		: 2009-02-19
# Project		: MatrimonyProduct
# Module		: Search - RSS Feed Search
#================================================================================================================
//ROOT DIR
$varRootBasePath = '/home/product/community';

//INCLUDED FILES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath.'/conf/bmdomainmap.cil14');
include_once($varRootBasePath.'/lib/clsBasicviewHTML.php');
include_once($varRootBasePath.'/lib/clsBasicview.php');

if ($confValues['DOMAINCONFFOLDER'] !="") {		
	include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
}//if

//error_reporting(E_ALL);
//ini_set('display_errors','1');

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
$objBasicViewHTML->clsSessMatriId	= $sessMatriId;
$varDomainId						= $confValues["DOMAINCASTEID"];


$varCommunityCategory	= trim($_REQUEST['cat']);
$varCommunityWhere		= '';
$varTitle = '';
if ($varDomainId==2500 && $varCommunityCategory !="" && preg_match("/denomination\/.+/", $varCommunityCategory)) {
	$arrDenominationList = array(3=>"Adventist",4=>"Anglican",5=>"Apostolic",6=>"Assyrian",7=>"Assembly of God (AG)",8=>"Baptist",9=>"Born Again",10=>"Brethren",11=>"Calvinist",12=>"Catholic",13=>"Church of God",14=>"CSI",15=>"Congregational",16=>"Evangelical",17=>"Jacobites",18=>"Jehovah's Witnesses",19=>"Jewish",20=>"Latin Catholic",21=>"Latter Day Saints",22=>"Lutheran",23=>"Malankara",24=>"Marthoma",25=>"Melkite",26=>"Mennonite",27=>"Methodist",28=>"Moravian",29=>"Orthodox Christian",30=>"Pentecost",31=>"Protestant",32=>"Presbyterian",33=>"Seventh-day Adventist",34=>"Syro Malabar",35=>"Syrian Christian"); 
	$arrCommunityCategory	= explode("/",$varCommunityCategory);
	$arrSplitFieldValue		= explode("-",$arrCommunityCategory[1]);
	$varDenomination		= trim(ucwords(strtolower($arrSplitFieldValue[0])));
	$varSelectedValue		= array_keys($arrDenominationList, $varDenomination);
	if($varSelectedValue[0] !='' && is_numeric($varSelectedValue[0])){
		$varCommunityWhere		= " AND ".$arrCommunityCategory[0]."=".$varSelectedValue[0];
	}
	$varTitle				= $varDenomination;
}//if

	$domainarr		= explode('/',$confValues['DOMAINCONFFOLDER']);
	$domainname		= ucwords($domainarr[1]);
    
	$cat_marr       = array('Grooms','Groom','Boys','Boy');
	$cat_farr       = array('Brides','Bride','Girls','Girl');
    $kwords         = $_REQUEST['cat'];
	$kwordarr       = explode(' ',$kwords);
	if($kwordarr[2]=='site' || $kwordarr[2]=='sites'){
       $kwordarr[1] = $kwordarr[1].' '.$kwordarr[2];
       $kwordarr[2] = $kwordarr[3]; 
	   unset($kwordarr[3]);
	}
	
	$varCont = '';
	$varWhereCondF	= 'WHERE '.$varWhereClause.$varCommunityWhere.' AND Age >=18 AND Gender=2 AND Publish=1';
	$varWhereCondM	= 'WHERE '.$varWhereClause.$varCommunityWhere.' AND Age >=21 AND Gender=1 AND Publish=1';
	if($sessMatriId!=''){
	$varWhereCondF  .= " AND MatriId<>".$objBasicView->doEscapeString($sessMatriId,$objBasicView);
	$varWhereCondM	.= " AND MatriId<>".$objBasicView->doEscapeString($sessMatriId,$objBasicView);
	}
	$varWhereCondF  .= ' ORDER BY Photo_Rank,Last_Login DESC LIMIT 6';
	$varWhereCondM  .= ' ORDER BY Photo_Rank,Last_Login DESC LIMIT 6';
	$argConditionMale['LIMIT'] = $varWhereCondM;
	$argConditionFeMale['LIMIT'] = $varWhereCondF;

	$varMaleProcess		= 'yes';
	$varFeMaleProcess	= 'yes';
	$varMaleCount		= '0';
	$varFeMaleCount		= '0';

    $sessGender='';
	if(in_array($kwordarr[1],$cat_marr)==1){
		$sessGender=2;
	}elseif(in_array($kwordarr[1],$cat_farr)==1){
		$sessGender=1;
	}
    
	if ($sessGender !=""){
			if ($sessGender=='1') { $varMaleProcess ='no';  }
			elseif ($sessGender=='2') { $varFeMaleProcess ='no';  }
	}//if

	if ($varMaleProcess=='yes') {
		$varMaleRes = $objBasicView->selectDetails($argConditionMale,''); 
		$varMaleCount	= count($varMaleRes);
	}

	if ($varFeMaleProcess=='yes') { 
		$varFeMaleRes	= $objBasicView->selectDetails($argConditionFeMale,''); 
		$varFeMaleCount	= count($varFeMaleRes);
	}

//Get BM Mapping Domain
$varCBSDomain = substr($confValues['DOMAINNAME'], 1);
$varBMMappingDomain	= $arrLangArray[$arrBMDomainMap[$varCBSDomain]];
$varBMLink	= '';
if($varBMMappingDomain != ''){ 
	$varBMMappingDomain = 'www.'.$varBMMappingDomain.'matrimony.com'; 
	$varBMLink	= '<a target="_blank" class="clr1" href="http://'.$varBMMappingDomain.'">'.$varBMMappingDomain.'</a>  <font class="bld"> | </font> ';
}
?>
<div class="rpanel fleft">

	<div class="normtxt1 clr2 padb5"><font class="clr bld"><h1 style="color:#000000;font-size:18px;"><?=$varTitle ? $varTitle.' matrimonials' : $website_heading?></h1></font></div>
    
	<?php if($breadcrumb){ ?>
	<div class="linesep" style="margin-top:5px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="normtxt1 clr2 padb5" style="margin-top:5px;margin-bottom:5px;"><?=$breadcrumb;?><font class="clr" style="font-size:11px;"><?=$varTitle ? $varTitle.' matrimonials' : $website_heading?></font></div>
	<? }?>
    <div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<form style="margin: 0px; padding: 0px;" name="RSearchForm" action="/search/index.php" method="post">
	<input type="hidden" name="<?=$varFormName?>" value="<?=$varSelectedValue[0]?>">
	<input type="hidden" name="gender" value="1">
	<input type="hidden" name="randId" value="">
	<input type="hidden" name="srchType" value="2">
	<input type="hidden" name="saveSrch" value="">
	<input type="hidden" name="srchId" value="">
	<input type="hidden" name="act" value="srchresult">
	<input type="hidden" name="page" value="1">
	<input type="hidden" name="redirectjspath" id="redirectjspath" value="/search/index.php">

		<div class="padt10 rpanelinner">
		<? if ($varFeMaleCount > '0' || $varMaleCount >'0') { ?>

			<? if ($varFeMaleCount > '0') { ?>
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld" style="font-size:14px;"><?=$varTitle ? $varTitle : $domainname?> Brides</font></div>
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>

			<?	$objBasicViewHTML->basicview($varFeMaleRes); ?>

		</div>

		<? if ($sessMatriId =="") { ?>
		<div class="rpanelinner padt10"><div class="fright"><input type="button" value="Register Free" class="button" onClick="document.location.href='<?=$confValues['SERVERURL']?>/register'" /> &nbsp; <input type="button" value="More Brides" class="button" onClick="funCommunity('2');" /></div>
		</div>  <br clear="all">

        <!--<div class="rpanelinner"><img src="<?=$confValues['SERVERURL']?>/mailer/images/dot-line.gif" height="1" width="500" /></div> -->
		<? }
		}
		?>


		<? if ($varMaleCount > '0') { ?>
		<div class="padt10 rpanelinner">
			<div class="normtxt clr2 padb5 padt10"><font class="clr bld" style="font-size:14px;"><?=$varTitle ? $varTitle : $domainname?> Grooms</font></div>
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
            <?	$objBasicViewHTML->basicview($varMaleRes); ?>
		</div>

		<? if ($sessMatriId =="") { ?>
		<div class="rpanelinner padt10"><div class="fright"><input type="button" value="Register Free" class="button" onClick="document.location.href='<?=$confValues['SERVERURL']?>/register'" /> &nbsp; <input type="button" value="More Grooms" class="button" onClick="funCommunity('1');" /></div>
		</div><br clear="all">

        <? }
			echo '<br clear="all">';
       	} 
		echo '<div style="font:bold 14px arial;color:#636163">Related Sites</div><div class="fleft" style="margin-top:5px;">';
		echo $varBMLink;
		$varPropertyDomainLink = '';
		$arrPropertiesLink = array('Delhi', 'Mumbai', 'Bangalore', 'Chennai', 'Hyderabad', 'Kerala', 'Pune', 'Kolkata', 'Ahmedabad', 'Chandigarh');

		foreach($arrPropertiesLink as $varSingleVal){
			$varPropertyDomainLink .= '<a target="_blank" class="clr1" href="http://'.strtolower($varSingleVal).'.indiaproperty.com">'.$varSingleVal.' properties&nbsp;</a>  <font class="bld"> | </font>';

		}
		echo rtrim($varPropertyDomainLink,' <font class="bld"> | </font>');
		echo '</div>';

	 } else { echo 'Sorry, no matching profiles available. Refine your search to get matches'; } ?>
        </div><br clear="all"><br>

	</form>

<?
//UNSET OBJECT
$objBasicView->dbClose();
unset($objBasicView);
unset($objBasicViewHTML);
?>
<SCRIPT LANGUAGE="JAVASCRIPT">
function funCommunity(argGen){
	document.RSearchForm.gender.value=argGen;
	document.RSearchForm.submit();
}//funCommunity
</SCRIPT>