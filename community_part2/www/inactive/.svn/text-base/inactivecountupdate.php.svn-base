<?
$varRootBasePath = '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARATION
$objDBInactiveMaster = new DB;

//DB CONNECTION
$objDBInactiveMaster->dbConnect('M',$varInactiveDbInfo['DATABASE']);

$varCommunityId	= trim($_SERVER['argv'][1]);

//SELECT MATRIID FROM MEMBERINFO TABLE FROM CBSINACTIVE DATABASE
$varFields			= array('MatriId');
$varCondition		= " WHERE CommunityId=".$objDBInactiveMaster->doEscapeString($varCommunityId,$objDBInactiveMaster);
$varSelectMatriId	= $objDBInactiveMaster->select($varTable['MEMBERINFO'],$varFields,$varCondition,0);

  while($varRow = mysql_fetch_assoc($varSelectMatriId)) {
	$varMatriId	= $varRow['MatriId'];
	//echo '\n'.$varMatriId;
   	//execute php file from backend which is used for deleting msges in receiver side and sender side
	$varCmd	= "php ".$varRootBasePath."/bin/deleteprofile_step1.php ".$varMatriId;
	shell_exec($varCmd);

  }
$objDBInactiveMaster->dbClose();
?>