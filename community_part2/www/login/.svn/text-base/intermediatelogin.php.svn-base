<?
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/".$confValues['DOMAINCONFFOLDER']."/conf.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsCryptDetail.php");
include_once($varRootBasePath."/lib/clsDB.php");

/* Campaign LMS Click track call statements */
/* Query string parameters */
$varCampTrackId	 = addslashes(strip_tags(trim($_REQUEST['trackid'])));
$varCampType	 = addslashes(strip_tags(trim($_REQUEST['type'])));
$varCampFormFeed = addslashes(strip_tags(trim($_REQUEST['formfeed'])));

/* Campaign LMS Click Track */
if ($varCampTrackId!="" && $varCampFormFeed=='y') {
 echo "<script src=\"http://campaign.bharatmatrimony.com/cbstrack/clicktrack.php?trackid=".$varCampTrackId."&type=".$varCampType."&formfeed=y\"></script>";
}

if($_REQUEST) {
	if(CryptDetail::revlink()=="Success") {

	//VARIABLE DECLARATION
	$varRedirect	= trim($_REQUEST["redirect"]);
	$varFDMatriId	= base64_decode(trim($_REQUEST["sde"]));
	$varMatriId		= base64_decode($varFDMatriId);
	if ($varRedirect=="") { $varRedirect = $confValues['SERVERURL'].'/profiledetail/index.php?ts=1'; }

	if($varGetCookieInfo["MATRIID"]==$varMatriId) {

		$varRedirect = $confValues['SERVERURL']."/login/index.php?act=logincheck&redirect=".$varRedirect;
		header("Location: ".$varRedirect);exit;

	} else {

			$db = new DB;
			$db->dbConnect('S',$varDbInfo['DATABASE']);

			$argFields				= array('MatriId','Password','Email_Status');
			$argCondition			= " WHERE MatriId=".$db->doEscapeString($varMatriId,$db);
			$varMemberLoginInfoRes	= $db->select($varTable['MEMBERLOGININFO'],$argFields,$argCondition,0);
			$varMemberLoginInfo		= mysql_fetch_assoc($varMemberLoginInfoRes);

			if($varMemberLoginInfo['MatriId']!='') {

				$varMatriId		= $varMemberLoginInfo['MatriId'];
				$varPswd		= $varMemberLoginInfo['Password'];
				$varEmailStatus	= $varMemberLoginInfo['Email_Status'];

				if($varEmailStatus==1) { //disable auto-login feature
					header("location:".$confValues['SERVERURL']."/login/index.php?act=login&redirect=".$varRedirect);exit;
				} else { //enable auto-login feature
?>
		<form name="frmLogin" method="post" action="index.php?act=logincheck">
			<input type="hidden" name="frmLoginSubmit" value="yes">
			<input type="hidden" name="redirect" value="<?=$varRedirect?>">
			<input type="hidden" name="idEmail" value="<?=$varMatriId?>">
			<input type="hidden" name="password" value="<?=$varPswd?>">
		</form>
		<img src="<?=$confValues['IMGSURL']?>/trans.gif" onLoad="document.frmLogin.submit();">
					<?
			}
			} else {
				header("location:".$confValues['SERVERURL']);
			}
			$db->dbClose();
			UNSET($db);
		}
	} else {
		header("location:".$confValues['SERVERURL']);
	}
} else {
	header("location:".$confValues['SERVERURL']);
}
?>