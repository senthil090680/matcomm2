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
.pm{border:1px solid #000000;background:#FFFFFF;color: #000000;width: 64px;height:18px;font: 11px Tahoma;color: #000000;}
body{
  margin: 0px;padding: 0px;
}
</style>
<center>
<table width="772" border="0" cellpadding="0" cellspacing="0" style="margin:0 0 0 0px;">
	<tr>
    <td width="302" background="<?=$confValues['IMGSURL']?>/pm/cbs-img1.jpg" height="76" valign="top"><a rel="nofollow" target="_blank" href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" style="outline:none;"><img src="<?=$confValues['IMGSURL']?>/pm/trans.gif" alt="" style="display: inline;" width="300" valign="top" border="0" height="74"></a></td>
    <td width="317" background="<?=$confValues['IMGSURL']?>/pm/cbs-img2.jpg" height="76" valign="top">
    <div id="resultdiv" class="smalltxt clr" style="display:none;position:absolute;height:63px !important;height:75px;width:266px !important;width:276px;margin-left:0px;background-color:#C3462E;padding:5px;">
    <div style="padding-left:250px;"><a onclick="document.getElementById('resultdiv').style.display='none';" href="#"><img src="<?=$confValues['IMGSURL']?>/close.gif" border="0" /></a></div>
    <font style="font-size:14px;color:#fff">Thank you for your interest. Our Relationship Manager will call you shortly.</font></div>
	<form name="frmPrivilege" method="post" style="margin:0px;">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td align="left" valign="top" style="padding-left:140px;font:17px arial;color:#fff;height:55px !important;height:54px;padding-top:9px !important;padding-top:10px;"><? echo '<font style="color:#fff;font-weight:bold;font-family:Arial;font-size:17px;">'.$varLiveHelpNo.'</font>'; ?><!--<iframe src="/site/livehelpnochristian.php" frameborder="0" style="width:160px !important;width:160px;height:25px !important;height:20px;" align="left"></iframe>--></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="padding-left:10px;">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" valign="top" width="69"><input type="text" name="name" class="pm" tabindex=1 value="Name" onclick="if (this.value == 'Name') { this.value = ''; }" onfocus="if (this.value == 'Name') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'Name'; }" /></td>
                            <td align="left" valign="top" width="69"><input type="text" name="phone" class="pm" tabindex=2 value="Phone no" onKeypress="return allowNumeric(event);" onclick="if (this.value == 'Phone no') { this.value = ''; }" onfocus="if (this.value == 'Phone no') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'Phone no'; }"/></td>
                            <td align="left" valign="top" width="69"><input type="text" name="city" class="pm" value="City" tabindex=3 onclick="if (this.value == 'City') { this.value = ''; }" onfocus="if (this.value == 'City') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'City'; }" /></td>
                            <td align="left" valign="middle" width="58"><a href="#"  onclick="javascript:funAddPrivilegemat();" tabindex=4><img src="<?=$confValues['IMGSURL']?>/pm/submit.jpg" width="58" height="16" alt="" border="0" /></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
		</form>
    </td>
    <td width="153" background="<?=$confValues['IMGSURL']?>/pm/cbs-img3.jpg" height="76" valign="top"><a rel="nofollow" target="_blank" href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" style="outline:none;"><img src="<?=$confValues['IMGSURL']?>/pm/trans.gif" alt="" style="display: inline;" width="150" valign="top" border="0" height="74"></a></td>
    </tr>
</table>
</center>