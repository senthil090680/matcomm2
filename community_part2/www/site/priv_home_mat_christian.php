<?
#================================================================================================================
# Author 		: Dhanapal N
# Date	        : 2009-12-15
# Project		: CBS
# Filename		: livehelpno.php
#================================================================================================================
# Description   :
#================================================================================================================

$varRootBasePath	= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varRootBasePath);
include_once($varRootBasePath.'/www/site/liveno.php');
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/priv_mat_home.js" ></script>
<style>
.pm
{
  border:1px solid #000000;
  background:#FFFFFF;
  color: #000000;
  width: 68px;
  height:18px;
  font: 11px Tahoma;
  color: #000000;
}
body{
  margin: 0px;padding: 0px;
}


</style>
<center>
<table width="772" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td width="168" background="<?=$confValues['IMGSURL']?>/pm/ch-img1.jpg" height="76" valign="top"><a rel="nofollow" target="_blank" href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" style="outline:none;"><img src="<?=$confValues['IMGSURL']?>/pm/trans.gif" alt="" style="display: inline;" width="165" valign="top" border="0" height="74"></a></td>
    <td width="298" background="<?=$confValues['IMGSURL']?>/pm/ch-img2.jpg" height="76" valign="top"><a rel="nofollow" target="_blank" href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" style="outline:none;"><img src="<?=$confValues['IMGSURL']?>/pm/trans.gif" alt="" style="display: inline;" width="265" valign="top" border="0" height="74"></a></td>
    <td width="306" background="<?=$confValues['IMGSURL']?>/pm/ch-img3.jpg" height="76" valign="top">
        <div id="resultdiv" class="smalltxt clr" style="display:none;position:absolute;height:63px !important;height:75px;width:266px !important;width:300px;margin-left:0px;background-color:#FFE352;padding:5px;">
    <div style="padding-left:250px;"><a onclick="document.getElementById('resultdiv').style.display='none';" href="#"><img src="<?=$confValues['IMGSURL']?>/close.gif" border="0" /></a></div>
    <font style="font-size:14px;color:#000">Thank you for your interest. Our Relationship Manager will call you shortly.</font></div>
	<form name="frmPrivilege" method="post" action="addprivilege.php" style="margin:0px;">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td align="left" valign="top" style="padding-left:145px;font:17px arial;color:#000;height:50px !important;height:50px;padding-top:9px !important;padding-top:10px;"><? echo '<font style="color:#000;font-weight:bold;font-family:Arial;font-size:17px;">'.$varLiveHelpNo.'</font>'; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="padding-left:5px;">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" valign="top" width="73"><input type="text" name="name" class="pm" value="Name" onclick="if (this.value == 'Name') { this.value = ''; }" onfocus="if (this.value == 'Name') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'Name'; }" /></td>
                            <td align="left" valign="top" width="73"><input type="text" name="phone" class="pm" value="Phone no" onKeypress="return allowNumeric(event);" onclick="if (this.value == 'Phone no') { this.value = ''; }" onfocus="if (this.value == 'Phone no') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'Phone no'; }"/></td>
                            <td align="left" valign="top" width="79"><input type="text" name="city" class="pm" value="City" onclick="if (this.value == 'City') { this.value = ''; }" onfocus="if (this.value == 'City') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'City'; }" /></td>
                            <td align="left" valign="middle" width="58">
                            <a onclick="javascript:funAddPrivilegemat();" href="#" tabindex=4><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="58" border="0" height="16"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
       </form>
    </td>
    </tr>
</table>
</center>