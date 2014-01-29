<?

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once "include/rmclass.php";

$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
$rmclass->username=$_GET['rmuserid'];
$rmclass->password=base64_decode($_GET['rmpass']);
$numrows=$rmclass->loginvalidation();

if($numrows==0){
	header("location:http://www.communitymatrimony.com/privilege/mainindex.php");
}

$varMemidRminter	= $_REQUEST['MEMID_RMINTER'];
$varMatriIdPrefix	= substr($varMemidRminter,0,3);
$varDomainName		= $arrPrefixDomainList[$varMatriIdPrefix];

$varActFields	= array("Password");
$varActCondtn	= " where MatriId='".$varMemidRminter."'";
$rows		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'],$varActFields,$varActCondtn,1);
$pass=$rows[0]['Password'];

setcookie("rmusername", $_GET['rmuserid'],"0","/",'www.'.$varDomainName);

$url=$_GET['path'];

if($_GET['img_path']){
setcookie("rmusername", $_GET['rmuserid'],"0","/",'image.'.$varDomainName);
header("location:mainindex.php?act=rmsendmail&MEMID_RMINTER=".$_GET['MEMID_RMINTER']."&val=1&p=1");
exit;
}


if($url=="") {
$memLoginPage='http://www.'.$varDomainName."/login/index.php?act=logincheck&idEmail=".$varMemidRminter."&password=".$pass."&RMIID=rmi&RMIUID=".$_GET['rmuserid']."&frmLoginSubmit=yes";
setcookie("partialflag","0","0","/",'.'.$varDomainName);
$enc_url=base64_encode($memLoginPage);
header("location:rmprofileview.php?ps=$enc_url&MEMID_RMINTER=$varMemidRminter&d=$senderdomainname");	
}else{
setcookie("partialflag","1","0","/",'.'.$varDomainName);
$memLoginPage='http://www.'.$varDomainName."/login/index.php?act=logincheck&idEmail=".$varMemidRminter."&password=".$pass."&RMIID=rmi&frmLoginSubmit=yes&redirect=".$senderdomainname."/".$url;

$enc_url=base64_encode($memLoginPage);
header("location:rmprofileview.php?ps=$enc_url&MEMID_RMINTER=$varMemidRminter&d=$senderdomainname&c=1&p=1");
 }

?>


