<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Matrimonials, Matrimonial, Community Brides &amp; Grooms - CommunityMatrimony</title>
<meta name="description" content="CommunityMatrimony, Exclusive Matrimony Portal from CommunityMatrimony Click here to Register FREE &amp; get FREE Matches" />
<meta name="keywords" content="Community Matrimonial, Community Matrimonials, Community Matrimony" />
<meta name="Author" content="CommunityMatrimony.com Community Matrimonial Team" />
<meta name="copyright" content="Communitymatrimony.com Matrimonials" />
<meta name="Distribution" content="general" />
<link rel="stylesheet" href="http://img.communitymatrimony.com/styles/home.css" />
<link rel="SHORTCUT ICON" href="http://img.communitymatrimony.com/images/community_icon.ico" />
</head>
<body>
<center>

<div id="maincontainer">
<div id="container">
	<div class="padt5">
		<div class="fleft"><a href="http://www.communitymatrimony.com"><img src="http://img.communitymatrimony.com/images/logo/community_logo.gif" width="380" height="40" alt="Community Matrimonials" border="0" vspace="10" /></a></div>
		<div class="cleard"></div>
	</div>
	<div class="linesep"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div><br clear="all">

	<div class="normtxt clr">
		<?php
		include_once('/home/product/community/conf/ip.cil14');
		$db_link	= mysql_connect($varDbIP['M'],$varDBUserName,$varDBPassword);
		if ($db_link) {
			$db_sel 	= mysql_select_db("communitymatrimony");
			if ($db_sel) {
				$varEmail	= $_REQUEST['email'];  //addslashes($_REQUEST['email']);
				$varQuery	= "UPDATE communitymatrimony.cbsmailerdata SET Unsubscribe=1 WHERE Email = '".mysql_real_escape_string($varEmail)."'";
				$varResult  = mysql_query($varQuery);
				echo 'You have unsubscribed successfully.';
			} else {
				echo 'Your unsubscription is not successful, due to technical problem, sorry for the inconvenience. Please try again.';
			}
		} else {
			echo 'Your unsubscription is not successful, due to technical problem, sorry for the inconvenience. Please try again.';
		}
		?>
	</div>

	<br clear="all">
	<div class="linesep"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" alt="" /></div>
	<div class="footdiv">
		<center><div class="fleft footdiv2 padtb10 opttxt">Copyright &copy; CommunityMatrimony.com 2010. All rights reserved.</div></center>
	</div>
	</div>
	</div>
</center>
</body>
</html>