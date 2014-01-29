<form name="login" method="post">
<input type="hidden" name="act" value="rmlogincheck">
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr><td colspan="2"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="50"></td></tr>
	<tr>
		<td width="250">&nbsp;</td>
		<td width="260">
				<table width="260" cellpadding="0" cellspacing="0" align="center" class="brdr">
					<tr>
						   <td height="25" align="left" style="background-color:#efefef;" colspan="3"><span class="normtxt1 bld">&nbsp;Login</span></td>
					</tr>
					<tr><td height="20"></td></tr>
					<?if($Message!=""){?>
					 <tr><td height="25" colspan="3" valign="top" align="center"><span class="smalltxt clr3"><?=$Message;?></span></td></tr>
					<?}?>
					<tr>
							<td width="130" style="padding-right:5px;" align="right"><span class="normtxt">Username</span></td>
							<td width="10"><span class="normalText1">:</span></td>
							<td width="150" style="padding-left:5px;padding-right:5px;"><input type="text" name="adusername" value="" style="width:130px;" class="normtxt"></td>
					</tr>
					<tr><td height="8"></td></tr>
					 <tr>
							<td width="130" style="padding-right:5px;" align="right"><span class="normtxt">Password</span></td>
							<td width="10"><span class="normalText1">:</span></td>
							<td width="150" style="padding-left:5px;padding-right:5px;"><input type="password" name="adpassword" value="" style="width:130px;" class="normtxt"></td>
					</tr>
					<tr><td height="8"></td></tr>
					<tr>
							<td colspan="3" style="padding-left:95px;padding-right:5px;">
							<input type="submit" name="submit" value="Submit" class="button"></td>
					</tr>
					<tr><td height="20"></td></tr>
				</table>
		</td>
		<td width="270">&nbsp;</td>
	</tr>
	<tr><td><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="50"></td></tr>
</table>
<script>document.login.adusername.focus();</script> 