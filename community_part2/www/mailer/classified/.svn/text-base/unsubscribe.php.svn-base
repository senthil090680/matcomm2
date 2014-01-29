<?php
#================================================================================================================
   # Author 		: K.Lakshmanan
   # Date			: 08-02-2010
   # Project		: unsubscribe.php
#================================================================================================================
   # Description	: TO unsubscribte from the given mail Id
#================================================================================================================



$path='/home/product/community/';
require_once($path.'lib/clsDB.php');

$email=trim($_GET['emailid']);
$varTable['CBSCLASSFIEDMAIL']='cbsclassfiedmaillist';
$varDbInfo['CLASSIFIEDMAILER']='classifiedmailer';

$db=new DB();
$db->dbConnect('M',$varDbInfo['CLASSIFIEDMAILER']);

$argFields=array('Unsubscribe');
$argFieldsValue=array('1');
$argCondition= "  EmailId=".$db->doEscapeString($email,$db);

$db->update($varTable['CBSCLASSFIEDMAIL'], $argFields, $argFieldsValue, $argCondition); //To Update the status for Unsubscribe

?>

<HTML>
<HEAD><TITLE>Unsubscription</TITLE></HEAD>
<BODY>
<table align="center" width=750 cellspacing=0 cellpadding=0 border=0 style="border-top:1px solid #5D310F;border-left:1px solid #5D310F;border-right:1px solid #5D310F;border-bottom:1px solid #5D310F;">
<tr>
<td valign="top">
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" width="748">
	<tr>
		<td valign="bottom">
		<center><img src="http://imgs.communitymatrimony.com/images/logo/community_logo.gif" width="380" height="40" vspace="5" align="absmiddle" hspace="10"></center><br clear="all">
		<P STYLE="padding-left:165px;padding-right:3px;padding-top:10px;font-family: Verdana, MS Sans serif, Arial, Helvetica; font-size: 15px; font-style: normal; text-align: justify; text-transform: none; color: #000000;"><b>You have been unsubscribed from our Mailing List.</b></font></td>
	</tr>
</table>
</td></tr></table>
</BODY>
</HTML>