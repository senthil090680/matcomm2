<?php
require_once('header.php');
require_once('navinc.php');
//OBJECT DECLARATION
$objProductFacebook = new QuickSearch;
?>
<table border="0" cellpadding="0" cellspacing="10" width="600">
   <tr><td valign="Top" class="grtxtbold1"><font class="heading">Search</font></td></tr>
	<tr>
		<td valign="top" class="textsmall">Use our varied search tools to find the partner of your choice. You could do a general search or a detailed search or search by specific criteria. We have created a fast and easy way to help you get matching results. Remember to try all of them.</div></td>
	</tr>
	<tr>
		<td valign="top">
			<table bgcolor=#FFFFFF border="0" cellspacing=0 cellpadding="0" width="590" align="center">
				<tr>
					<td valign="top">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td valign="top" class="formborderclr" style="padding-left:2px;padding-right:5px;">
									<table border="0" cellpadding="0" cellspacing="0" width="280" height="14">
										<tr><td valign="top"><img src="<?=$confServerURL?>/images/trans.gif" width="5" height="14"></td></tr>
										<tr><td valign="middle" style="background:url(<?=$confServerURL?>/images/srch-advanced-icon.gif) no-repeat" width="278" height="30"><a href="advanced-search.php" class="linktxt">Advanced Search</a></td></tr>
									</table><div style="padding-left:5px;padding-top:5px;padding-bottom:5px;text-align:justify;width:280px;"  class="smalltxt">Are you looking for someone in particular? To find that special person you need to add a detailed description of your future partner.<br><a href="advanced-search.php" class="grsearchtxt">Click here</a></div>
										<table border="0" cellpadding="0" cellspacing="0" width="280">
											<tr><td valign="top"><img src="<?=$confServerURL?>/images/trans.gif" width="5" height="5"></td></tr>
											<tr><td valign="middle" style="background:url(<?=$confServerURL?>/images/srch-byid-icon.gif) no-repeat" width="278" height="30" class="linktxt" style="padding-bottom:5px;">Username Search</td></tr>
										</table>
										<div style="padding-left:0px;padding-top:5px;padding-bottom:5px;text-align:justify;width:280px;"  class="smalltxt">Find a member using their username.</div>
										<table border="0" cellpadding="5" cellspacing="0" width="275" align="center" class="myprofsubbg">
											<form name="frmViewProfileById" method="post" action="<?=$confServerURL?>/search/index.php?act=profile-view" onSubmit="return funViewProfileId();" target='_blank'>
											<input type="hidden" name="searchbyid" value="yes">
											<tr>
												<td valign="middle" class="smalltxt"><b>Enter username</b></td>
												<td valign="middle"><input type="text" size="15" name="matrimonyId" class="addtextfiled"></td>
											</tr>
											<tr>
												<td valign="middle" colspan="2" align="right"><input type="image" src="<?=$confServerURL?>/images/mm_search_buttom.gif"  hspace="17"></td>
											</tr>
										</form>
										<tr><td height="1" bgcolor="#FFFFFF" colspan="2"></td></tr>
										</table>
										<!-- Username Ends Here -->
									</td>
									<td valign="top"><img src="<?=$confServerURL?>/images/trans.gif" width="12" height="5"></td>
									<td valign="top" style="padding-left:5px;padding-right:5px;" class="formborderclr">
										<table border="0" cellpadding="0" cellspacing="0" width="270">
										<tr><td height="30" align="left" style="padding-top:5px;font-family:Verdana,MS Sans serif,Arial,Helvetica,sans-serif;font-size:12px;color:#286769;font-weight:bold;">Quick Search</td></tr>
										<tr><td>
										<form name="frmProductFacebook" method="post" action="facebook-search-results.php">
										<input type="hidden" name="frmProductFacebookSubmit" value="yes">
										<table border="0" cellpadding="0" cellspacing="8" width="270" align="center" class="myprofsubbg">
											<tr><td colspan="2" height="3"></td></tr>
											<tr>
												<td class="smalltxt" style="width: 78px;">Gender</td>
												<td class="smalltxt"><input type="radio" name="gender" value="2" <?php if(($sessGender==1 && $sessMatriId !="") || $sessMatriId =="") { echo "checked"; }?> class="addtextfiled">Female <input type="radio" name="gender" value="1" <?php if(($sessGender==2) && ($sessMatriId !="")) { echo "checked"; }?>  class="addtextfiled">Male </td>
											</tr>
											<tr>
												<td class="smalltxt">Age</td>
												<td class="smalltxt">
													<input type="text" name="fromAge" value="<?=$sessGender==2 ? '21' : '18';?>" size="2" class="addtextfiled"> To <input type="text" name="toAge" value="30" size="2" class="addtextfiled">
												</td>
											</tr>
											<tr>
												<td class="smalltxt">Country</td>
												<td>
													<select name="country" style="width: 110px; height: 18px;" class="addtextfiled">
														<?=$objProductFacebook->getValuesFromArray($varArrCountryList, "Any", "", '');?>					
													</select>

												</td>
											</tr>
											<tr>
												<td class="smalltxt">Sect</td>
												<td>
													<select name="religion" style="width: 110px; height: 18px;" class="addtextfiled">
													<?=$objProductFacebook->getValuesFromArray($varArrReligionList, "Any", "", '');?></select>
												</td>
											</tr>
											<tr>
												<td class="smalltxt">With Photo</td>
												<td><input type="checkbox" name="profilePhoto" value="1" checked="checked" class="addtextfiled"/></td>
											</tr>
											<tr>
												<td class="smalltxt" align="center"><input type="hidden" name="page" value="1"></td>
												<td class="smalltxt" align="center"><input type="image" src="<?=$confServerURL?>/images/mm_search_buttom.gif"></td>
											</tr>
										</form>
										</table>
										<table>
										<tr><td valign="top"> <img src="<?=$confServerURL?>/images/trans.gif" width="1" height="5"></td></tr>
										</table>
										<!-- whos online ends here -->
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top"> <img src="<?=$confServerURL?>/images/trans.gif" width="1" height="14"></td>
		</tr>
</table><br>
