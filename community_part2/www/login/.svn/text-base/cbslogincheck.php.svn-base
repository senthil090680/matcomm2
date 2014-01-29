<?
#====================================================================================================
# File			: index.php
# Author		: Dhanapal N, Naresh S
# Date			: 15-July-2008
# Module		: CommunityMatrimony Login
#********************************************************************************************************/
//BASE ROOT
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/cryptlist.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

//OBJECT DECLARTION
$objCBSLogin	= new DB;

//DB CONNECTION
$objCBSLogin->dbConnect('S',$varDbInfo['DATABASE']);

$varCBSDomainName	= '';
$varCheckLogin		= '0';
$varMatriId			= strtoupper(strtolower(trim($_POST["idEmail"])));
$varPassword		= addslashes(trim($_POST["password"]));
$varMatriIdPrefix	= substr($varMatriId,0,3);
$varCBSDomainName	= $arrPrefixDomainList[$varMatriIdPrefix];
$varAct				= 'login';
$varErrorMessage	= 'Invalid Matrimony ID OR Incorrect Password';

if ($varMatriId !=''){
	$varCryptedData			= $_POST["varCrypt"];
	$varCbsCryptSalt        = crypt($varMatriId,CBSLOGIN1);
	$varCbsCryptSecondSalt  = crypt($varCbsCryptSalt,CBSLOGIN2);
	if (($_POST['chooseLogin']=='yes')&&($varCbsCryptSecondSalt==$varCryptedData)) {  
		$varCondition = " WHERE  MatriId='".$varMatriId."'";

	} else {
		if (strpos(strtolower($varMatriId), '@')) { $varPrimary = 'Email';  } else { $varPrimary = 'MatriId'; }//else
		$varCondition = ' WHERE '.$varPrimary."=".$objCBSLogin->doEscapeString($varMatriId,$objCBSLogin)." AND Password=".$objCBSLogin->doEscapeString($varPassword,$objCBSLogin);
	}
	
	$varCheckLogin = $objCBSLogin->numOfRecords($varTable['MEMBERLOGININFO'], 'MatriId', $varCondition);
	
   // TO GET MATRIID IF GIVEN INPUT IS EMAIL
	if ($varPrimary == 'Email' && $varCheckLogin==1) {
			$varFields		= array('MatriId','CommunityId');
			$varExecute		= $objCBSLogin->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
			$varSelectLoginInfo1 = mysql_fetch_assoc($varExecute);			
			$varMatriId			 = $varSelectLoginInfo1["MatriId"];			
		    $varCommunityId      = $varSelectLoginInfo1["CommunityId"];
	} 
  
	if ($varCheckLogin>1) { $varCBSRedirect	= 'index.php?act=cbsverifymoreemail'; }
	else if($varCheckLogin == 1){
		if($varPrimary == 'Email'){
			$varEmailDomainPrefix = $arrMatriIdPre[$varCommunityId];
			$varCBSDomainName   = $arrPrefixDomainList[$varEmailDomainPrefix];			
		}
		$varCBSRedirect		  = 'http://www.'.$varCBSDomainName.'/login/';
		UNSET($_POST["act"]);
	}
?>
	<form name="frmCBSEmailLogin" method="post" action="<?=$varCBSRedirect?>">
		<?php if ($varCheckLogin==1) {?>
		<input type="hidden" name="act" value="logincheck">
			<? foreach ($_POST as $varKey => $varValue) { ?>
				<input type="hidden" name="<?=$varKey?>" value="<?=$varValue?>">
			<?	}
		}else if ($varCheckLogin>1){?>
		<input type="hidden" name="Email" value="<?=strtolower($varMatriId);?>">
		<?php }?>
	</form>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" border="0" />
<script>document.frmCBSEmailLogin.submit();</script>
<?
}
$objCBSLogin->dbClose();
UNSET($objCBSLogin);
?>