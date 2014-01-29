<?php
#====================================================================================================
# File			: index.php
# Author		: Rohini
# Date			: 15-July-2008
#*****************************************************************************************************
# Description	:
#********************************************************************************************************/
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/srchcontent.cil14");
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath."/conf/basefunctions.cil14");

$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if($varAct == "logout"){ clearCookie(); }//if

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
$sessHoroscopeAvailable	= $varGetCookieInfo["HOROSCOPESTATUS"];
$sessMotherTongue= $varGetCookieInfo["MOTHERTONGUE"];

//FOR PRIVILEGE PURPOSE..
$varPartialFlag	= '0';
?>
<head>
	<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony - Find <?=ucfirst($arrDomainInfo[$varDomain][2])?> Brides & Grooms</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony, the Perfect Place to search for a  <?=ucfirst($arrDomainInfo[$varDomain][2])?> partner. View 1000s of profiles from <?=ucfirst($arrDomainInfo[$varDomain][2])?> community. Register Now for Free!">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
	<style>.facetdot{ margin-left:15px;width:160px;background:url(<?=$confValues['IMGSURL'];?>/dotbg2.gif) repeat-x;height:1px;}</style>
	<script language="javascript">
	//<!--
	var cook_id = '<?=$sessMatriId?>', cook_publish='<?=$sessPublish?>',cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';
	//-->
	</script>

    <script>
function stylechange(vl)
{
	if(vl==0)
	{$('conall').style.display='none';
 	 $('conall1').style.display='block';
	}
	else
	{$('conall').style.display='block';$('conall1').style.display='none';}
}

function sel(ID,G,cpno,load){
	$('fade').style.display='block';
	$('lightpic').style.display='block';
	viewrec = cpno;
	curroppid = ID;
	ll();floatdiv('lightpic',lpos,100).floatIt();

	var url		= ser_url+'/basicview/bv_action.php?rno='+Math.random();
	param	= 'ID='+ID+'&G='+G+'&cpno='+cpno+'&module=search';

	if(load == '1'){
		$('lightpic').innerHTML = '';
		$('lightpic').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';}

	objAjax = AjaxCall();
	AjaxPostReq(url, param, actionScript,objAjax);

}//sel

function selclose()
 {
 $('lightpic').style.display='none';
 $('fade').style.display='none';
 }


function actionScript(){

	if(objAjax.readyState == 4) {
		//alert(objAjax.responseText);
		$('lightpic').innerHTML = '';
		$('lightpic').innerHTML = objAjax.responseText;
		//$('lightpic').innerHTML = objAjax.responseText;
		//alert(objAjax.responseText);

	}//if

}//actionScript

</script>


	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/facet.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/matchsummary.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/srchbasicview.js" ></script>

	<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/searchpaging.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/srchbasicview.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/priv_mat.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/opacity.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/animatedcollapse.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js"></script>

	<script>
	function stylechange(vl)
	{
		if(vl==0)
		{$('conall').style.display='none';
		 $('conall1').style.display='block';
		}
		else
		{$('conall').style.display='block';$('conall1').style.display='none';}
	}

	function sel(ID,G,cpno,load){
		$('fade').style.display='block';
		$('lightpic').style.display='block';
		viewrec = cpno;
		curroppid = ID;
		ll();floatdiv('lightpic',lpos,100).floatIt();

		var url		= ser_url+'/basicview/bv_action.php?rno='+Math.random();
		param	= 'ID='+ID+'&G='+G+'&cpno='+cpno+'&module=search';

		if(load == '1'){
			$('lightpic').innerHTML = '';
			$('lightpic').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';}

		objAjax = AjaxCall();
		AjaxPostReq(url, param, actionScript,objAjax);

	}//sel

	function selclose()
	 {
	 $('lightpic').style.display='none';
	 $('fade').style.display='none';
	 }


	function actionScript(){

		if(objAjax.readyState == 4) {
			//alert(objAjax.responseText);
			$('lightpic').innerHTML = '';
			$('lightpic').innerHTML = objAjax.responseText;
			//$('lightpic').innerHTML = objAjax.responseText;
			//alert(objAjax.responseText);

		}//if

	}//actionScript

	</script>
</head>
<body>
<center>
<!-- main body starts here -->
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/header.php");
	}
?>
<div id="maincontainer">
	<div id="container">
		<div class="main">
			<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
					include_once($confValues['HEADERTEMPLATEPATH']."/header.php");
				}
			?>
			<div class="innerdiv" id="centerpartdiv">
			<?php
				if($varAct == 'msummaryshowall'){
					echo '<div style="float:left;width:210px;">
					<div style="float:left;width:210px;" id="sidemenupart"></div>
					<div class="fleft" style="margin-top:10px;border: 1px solid #DBDBDB;width:190px;"><div style="margin-top:15px;margin-bottom:15px;" align="center"><iframe src="http://c1.zedo.com/jsc/c1/ff2.html?n=1405;c=1837;s=355;d8=;d5=;da=;d6=;d2=;d7=;d4=;d9=;d=7;w=160;h=600" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=160 height=600></iframe></div></div></div>';

				}else{	include_once('../template/leftpanel.php'); }

				if($varAct != "")
				{
					$varAct	= preg_replace("'\.\./'", '', $varAct);
					if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
					else{ include_once('msummaryshowall.php'); }
				}else{ include_once('msummaryshowall.php'); }
			?>
			<br clear="all" />
			<br clear="all" />
			</div>
			<?
				if($arrDomainInfo[$varDomain][2]!="defence")
				{
					include_once('../template/footer.php');
				}
			?>
		</div>
	</div>
</div><div id="fade" class="bgfadediv"></div>
<div id="lightpic" class="frdispdiv bgclr2 brdr1" style="width:570px;padding:10px;"></div>
<?
	if($arrDomainInfo[$varDomain][2] == "defence")
	{
		include_once($confValues['HEADERTEMPLATEPATH']."/footer.php");
	}
?>
</body>
</html>