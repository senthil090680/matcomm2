<?
$varRootBasePath	= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varRootBasePath);
include_once($varRootBasePath.'/www/site/liveno.php');
?>
<style>
.pm{border:1px solid #312C10; background:#FBE251; color: #000000; width: 156px; height:16px;font: 11px Tahoma;color: #000000;}
</style>
<center>
<table width="560" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td width="560" background="<?=$confValues['IMGSURL']?>/pm1.jpg" height="63" align="right"><a href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" rel="nofollow" target="_blank"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="150" height="61" alt="" border="0" /></a></td></tr>
    <tr><td width="560" background="<?=$confValues['IMGSURL']?>/pm2.jpg" height="70" valign="top"><a href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" rel="nofollow" target="_blank"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="556" height="68" alt="" border="0" /></a></td></tr>
    <tr><td width="560" background="<?=$confValues['IMGSURL']?>/pm3.jpg" height="42" valign="top"><a href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" rel="nofollow" target="_blank"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="556" height="40" alt="" border="0" /></a></td></tr>
    <tr>
    <td width="560" valign="top">
    <table width="560" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" width="275" background="<?=$confValues['IMGSURL']?>/pml4.jpg" style="padding-left:50px;" height="189" valign="top">
			<a href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" rel="nofollow" target="_blank"><img src="<?=$confValues['IMGSURL']?>/pmimg.jpg" width="224" height="110" alt="" border="0"></a><br><a href="http://www.privilegematrimony.com/?domain=<?=$varDomain?>&banmemid=<?=$varGetCookieInfo['MATRIID']?>" rel="nofollow" target="_blank"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="220" height="69" alt="" border="0" /></a>
            </td>
            <td align="left" width="235" background="<?=$confValues['IMGSURL']?>/pmr4.jpg" height="189" valign="top">
				<div id="resultdiv" class="smalltxt clr" style="display:none;position:absolute;margin-top:90px;height:89px !important;height:102px;width:158px !important;width:168px;margin-left:1px;background-color:#FFE352;padding:5px;"><div class="fright"><a onclick="document.getElementById('resultdiv').style.display='none';"><img src="<?=$confValues['IMGSURL']?>/close.gif" border="0" /></a></div><br>Thank you for your interest. Our Relationship Manager will call you shortly.</div>
                <form name="frmPrivilege" method="post" style="margin:0px;">
				<table cellpadding="0" cellspacing="0" style="padding-left:8px">
                  <tr>
                    <td align="left" valign="top" style="padding-left:15px !important;padding-left:22px;padding-top:20px;font:17px arial;color:#FFFFFF;height:97px;"><? echo '<font style="color:#fff;font-weight:bold;font-family:Arial;font-size:17px;">'.$varLiveHelpNo.'</font>'; ?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" height="22"><input type="text" name="name" class="pm" value="Name" tabindex=1 onclick="if (this.value == 'Name') { this.value = ''; }" onfocus="if (this.value == 'Name') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'Name'; }" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" height="22"><input type="text" name="phone" class="pm" value="Phone number" tabindex=2 onKeypress="return allowNumeric(event);" onclick="if (this.value == 'Phone number') { this.value = ''; }" onfocus="if (this.value == 'Phone number') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'Phone number'; }" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" height="22"><input type="text" name="city" class="pm" value="City" tabindex=3 onclick="if (this.value == 'City') { this.value = ''; }" onfocus="if (this.value == 'City') { this.value = ''; }" onblur="if (this.value == '') { this.value = 'City'; }" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" style="padding-left:53px !important;padding-left:60px;">
					<a onclick="javascript:funAddPrivilege();" tabindex=4><img src="<?=$confValues['IMGSURL']?>/trans.gif" alt="" width="64" border="0" height="21"></a></td>
                  </tr>
                </table>
				</form>
            </td>
          </tr>
        </table>
    </td></tr>
    <tr><td width="560" background="<?=$confValues['IMGSURL']?>/pm5.jpg" height="21" valign="top"></td></tr>
</table>
</center>