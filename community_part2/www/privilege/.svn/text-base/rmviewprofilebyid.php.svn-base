<?php

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

$varMatriId					 = $_REQUEST['matriid'];//;
$varGetCookieInfo["MATRIID"] = $varMatriId;

include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");

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
	<script language="javascript">var cook_id	  = '<?=$sessMatriId?>',cook_publish='<?=$sessPublish?>',cook_un	  = '<?=$sessUsername?>', cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>';</script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
	<script>
		var ajaxobj=false;
		function showTwitterUp(matid) {
			var argurl="/profiledetail/example1.php";
			var postval = "matriid="+matid;
			ajaxobj=AjaxCall();
			AjaxPostReq(argurl,postval,populateTwitter,ajaxobj);
		}

		function populateTwitter() {
			if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
				document.getElementById('twitterdiv').innerHTML	= ajaxobj.responseText;
			}
		}
	</script>
</head>
<body>
<? include_once($varRootBasePath.'/www/profiledetail/fullprofilenew.php'); ?>
</body>
</html>