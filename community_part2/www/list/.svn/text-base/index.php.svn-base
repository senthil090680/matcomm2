<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPaidStatus	 	= $varGetCookieInfo["PAIDSTATUS"];
$sessPublish	 	= $varGetCookieInfo["PUBLISH"];

//Redirecting page if session is empty
if(trim($sessMatriId)=="") { header('Location:'.$confValues['SERVERURL']);}

$varAct		= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
?>
<html>
<head>
	<title><?=$confPageValues['PAGETITLE']?></title>
	<meta name="description" content="<?=$confPageValues['PAGEDESC']?>">
	<meta name="keywords" content="<?=$confPageValues['KEYWORDS']?>">
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<? if (in_array($confValues['DOMAINCASTEID'],$arrCSSFolder)) { ?>
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<? } ?>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/opacity.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/contact.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/conceptRTE.js"></script>
	<script language="javascript">
	var cook_id = '<?=$sessMatriId?>', cook_paid = '<?=$sessPaidStatus?>', cook_publish='<?=$sessPublish?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url = '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url = '<?=$confValues["SERVERURL"]?>';
	var rspgcnt = 'search';
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
</head>

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
			<div class="innerdiv">
				<?php include_once('../template/leftpanel.php'); ?>
				<?php
					if($varAct != "")
						{
							$varAct	= preg_replace("'\.\./'", '', $varAct);
							if(file_exists($varAct.'.php')){ include_once($varAct.'.php'); }//if
							else{ include_once('listshowall.php'); }
						}else{ include_once('listshowall.php'); }
				?>
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
</center>
</body>
</html>