<?php 
//Base Root
 $varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath."/conf/cryptlist.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

if(!isset($_REQUEST["Email"])){ header("Location: /login/");exit; }

//OBJECT DECLARTION
$objCBSLogin	= new DB;

//DB CONNECTION
$objCBSLogin->dbConnect('S',$varDbInfo['DATABASE']);

$varEmail		= trim($_POST["Email"]);
$varFields		= array('MatriId','Email','Password','CommunityId');
$varCondition	= ' WHERE Email='.$objCBSLogin->doEscapeString($varEmail,$objCBSLogin);
$varExecute		= $objCBSLogin->select($varTable['MEMBERLOGININFO'], $varFields, $varCondition,0);
$varNumOfRecords= mysql_num_rows($varExecute);	
?>
<script language="javascript">
	function funEmailVerify(argMatriId,argCrypted)
	{
		document.frmEmailVerifyLogin.idEmail.value=argMatriId;
		document.frmEmailVerifyLogin.varCrypt.value=argCrypted;
		document.frmEmailVerifyLogin.submit();
	}//funChooseLogin
</script>
<form name="frmEmailVerifyLogin" method="post">
<input type="hidden" name="chooseLogin" value="yes">
<input type="hidden" name="frmLoginSubmit" value="yes">
<input type="hidden" name="act" value="cbslogincheck">
<input type="hidden" name="idEmail" value="">
<input type="hidden" name="varCrypt" value="">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr >
	  <td width="80%" align="right" class="smalltxt"> <a href="<?=$confValues['SERVERURL']?>" class="clr1">BACK</a></td>
	</tr>	
	<tr>
		<td class="smalltxt" colspan="3"><b>You have registerd with the same Email ID in the following Community Sites. Provided below is the Matrimony Id for the same. Click on the respective Matrimony ID to login.</b></td>
	</tr>	
	
	<tr>
		<td height="10px">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table width="70%" border="0" cellpadding="3" cellspacing="0"class="brdr" align="center">
				<tr  bgcolor="#EFEFEF">
					<td class="smalltxt" width="50%" align="left" style="padding-left:50px;">
					<b>Community Sites</b>
					</td>
					<td class="smalltxt" colspan="2" align="left" style="padding-left:50px;">
					<b>Matrimony Id</b>
					</td>		
				</tr>
				<?php 
					if($varNumOfRecords>0){
						while($varMultiLoginInfo	= mysql_fetch_array($varExecute)){
							$varMatriId				= $varMultiLoginInfo['MatriId'];
							$varCommunityId			= $varMultiLoginInfo['CommunityId'];
							$varSalt1				= crypt($varMatriId,CBSLOGIN1);
							$varSalt2				= crypt($varSalt1,CBSLOGIN2);
							?>		
				<tr>
					<td class="smalltxt bold" width="50%" align="left" style="padding-left:50px;">
						<?php 
							   $varDomainPrefix	= $arrMatriIdPre[$varCommunityId];
							   $varDomainName	= $arrPrefixDomainList[$varDomainPrefix];
							  echo ucfirst($varDomainName); ?>
					</td>
					<td class="smalltxt bold" align="left" style="padding-left:50px;">
						<a  href="javascript:funEmailVerify('<?=$varMatriId?>','<?=$varSalt2?>');" class="clr1">
						<?php echo $varMatriId; ?></a>
					</td>		
				</tr>
				<?php }}?>
			</table>
		</td>
	</tr>
</table>
</form>
<?php 
$objCBSLogin->dbClose();
UNSET($objCBSLogin);
?>