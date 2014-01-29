<?
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include "include/rmheader.php";
include_once "include/rmclass.php";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14"; // This includes MySQL Class details
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14"; // This includes all common functions
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.cil14"; 
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";//This includes all common functions
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmfilter.cil14"; // This includes all common functions

$senderdomaininfo = getDomainInfo(1,$_REQUEST['MEMID']);
$senderdomainname =strtoupper($senderdomaininfo['domainnameshort']);
$senderdomainnamelong = $senderdomaininfo['domainmodule'];
$bmsersender = $senderdomaininfo['domainmodule'];	

if($_REQUEST['MEMID']!= ''){
	$sender = new db();
	$logintable            = $MERGETABLE['LOGININFO'];
	$sender->dbConnById(2, $_REQUEST['MEMID'] ,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYLOG']);
	
	//$sender->query = "select Password from ". $DBNAME['MATRIMONYMS'].".".$logintable." where MatriId='".$_REQUEST['MEMID']."'";
	//$sender->execute($selqry); 

	$selqry = "select Password from ". $DBNAME['MATRIMONYMS'].".".$logintable." where MatriId='".$_REQUEST['MEMID']."'";
	$sender->select($selqry); 
	$row = $sender->fetchArray();
	//echo $row['Password'];
	$timestamp = time();
	
	$pass = crypt($row['Password'],SALT);
	 echo $memLoginPage = "http://".$GETDOMAININFO['domainmodule']."/login/memlogin.php?ID=".$_REQUEST['MEMID']."&PASSWORD=".$pass."&TL=".$timestamp."&RUSER=1&GOTO1=search/search.php?MEMID=".$_REQUEST['MEMID'];
?>

</table>
<IFRAME WIDTH="780" height="1400" style="padding-left:115px;" src="<?=$memLoginPage?>" frameborder="0"> </IFRAME>

<? } else if($_REQUEST['mid']!= ''){
		
 ?>

	<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
		 		<td width="100%" style="padding-left:20px;"> 
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							   <td valign="top" align="left" height="30" colspan="4"><span class="normaltext3">Member List</span></td>
					    </tr>
						<tr>
								<td width="200" class="tdleft"><span class="normaltext2"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/privilege/rmpartial.php?MEMID=<?=$_REQUEST['mid']?>">Profile View</a></span></td>
								 
						</tr>
						 	<tr>
								<td width="200" class="tdleft"><span class="normaltext2"><a href="http://<?=$GETDOMAININFO['domainmodule']?>/privilege/memcomunicate.php?MEMID=<?=$_REQUEST['mid']?>">Member Communication</a></span></td>
								 
						</tr>
						 
						
					   <tr><td height="50">&nbsp;</td></tr>
				</table>	
			</td>
		</table>
	</td>
</tr>
 <?
 }
	include_once "include/rmfooter.php"; 
?>
</body>
</html>
	
