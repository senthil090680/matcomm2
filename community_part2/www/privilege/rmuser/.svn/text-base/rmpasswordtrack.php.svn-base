<?php
/****************************************************************************************************
File		: rmuseradminindex.php
Author	: Chitra.S
Date		: 06-Aug-2008
*****************************************************************************************************
Description	:
	This is Rmuser addition & segregation home page
********************************************************************************************************/

// Includes header information
/*$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14"; // This includes MySQL Class details
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14"; // This includes all common functions
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";//This includes all common functions
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmfilter.cil14"; // This includes all common functions*/
ini_set('display_errors',1);
error_reporting(E_ALL);

include_once "include/rmuserheader.php";
include_once "include/common_vars.php";
include_once "include/rmclass.php";

    $rmlogininfo = new srmclassname();
	$rmlogininfo->srminit();
	$rmlogininfo->srmConnect();
	$rmuserlist=$rmlogininfo->rmuserlist();

?>
 <script language="javascript" src="js/ajax.js"></script>
 <script language="javascript" src="js/common_validation.js"></script>
<tr>
	<td>
			<form name="passwordtrack" method="post">
			<table cellpadding="0" cellspacing="0" width="100%" style="padding:5px 5px 5px 10px;">
				  <tr>
						 <td width="350" colspan="3"><span class="normaltext3"><b>RM Password Tracking</b></span></td>
				  </tr>
				  <tr>
						<td colspan="3">&nbsp;</td>
				  </tr>
				  <tr>
						 <td width="150" class="normaltext2">RM User Id</td>
						 <td width="10" class="normaltext2">:</td>
						 <td class="normaltext2">
							<select name="userid" class="normaltext2">
								   <option value="">-- Choose the RM User Id --</option>
								   <option value="All">All</option>
								   <? while($rmuser=mysql_fetch_array($rmuserlist)) { ?>
									<option value="<?=$rmuser['RMUserid'];?>"><? echo strtotitle($rmuser['Name'])."(&nbsp;".strtoupper($rmuser['RMUserid'])."&nbsp;)";?></option>
								   <? } ?>
							</select>
							&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="submit" onclick="return ajax_validation('passwordlist');">
						</td>
				  </tr>
				  <tr>
						<td colspan="3" height="20">&nbsp;</td>
				  </tr>
				  <tr>
						 <td colspan="3"><div id="passwordlist"></div> </td>
				  </tr>
				  <tr>
						<td colspan="3" height="200">&nbsp;</td>
				  </tr>
			</table>
			</form>
	</td>
 </tr>
 </table>

 <?include_once "include/rmfooter.php"; ?>