<?php
#================================================================================================================
# Author 		: S Rohini
# Start Date	: 2007-08-23
# End Date		: 2007-08-23
# Project		: MatrimonyProduct
# Module		: Search - Advance Search Facebook
#================================================================================================================
//FILE INCLUDES
require_once('header.php');
require_once('navinc.php');

//OBJECT DECLARTION
$objProductFacebook = new QuickSearch;

//VARIABLE DECLARTIONS
$objProductFacebook->clsTable			= "searchsavedinfo";
$objProductFacebook->clsFields			= array('Search_Id','Search_Name','Search_Type');
$objProductFacebook->clsPrimary			= array('MatriId');
$objProductFacebook->clsPrimaryValue	= array($sessMatriId);

//DISPLAY SAVED SEARCH
if ($sessMatriId !="")
{
	if (count($varSavedSearchInfo) > 0)
	{
		$varDisplaySavedSearches='';
		for($i=0;$i<count($varSavedSearchInfo);$i++)
		{
			$varSavedInfo	= trim($varSavedSearchInfo[$i]);
			if ($varSavedInfo !="")
			{
				$varSelectInfo	= explode('|',$varSavedInfo);
				for($j=0;$j<count($varSelectInfo);$j++)
				{
					$varSearchId	= $varSelectInfo[$j];
					$varSearchType	= $varSelectInfo[$j+1];
					$varSearchName	= $varSelectInfo[$j+2];
					$varDisplaySavedSearches .= '<a href="javascript: funSavedSearch('.$varSearchId.','.$varSearchType.');" class="grsearchtxt"><b>'.$varSearchName.'</b></a>&nbsp;&nbsp;';
				}//for
			}//if
		}//for
	}//if

}//if
//GET YEARS
function getYears()
{
	$varEndYear		= date("Y");
	$varStartYear	= ($varEndYear-2);
	for ($i=$varStartYear;$i<=$varEndYear;$i++)
	{
		$funDisplay .= '<option value="'.$i.'">'.$i.'</option>';
	}//for
	$retValues = $funDisplay;
	return $retValues;
}//getYears
?>
<!--Form starts here-->
<form name="frmAdvancedSearch" method="post" onSubmit="return validate();" action="facebook-search-results.php">
<input type="hidden" name="act" value="facebook-search-results">
<input type="hidden" name="maritalStatus" value="">
<input type="hidden" name="savedId" value="">
<input type="hidden" name="savedSearchCount" value="<?=$varNoOfRecords;?>">
<input type="hidden" name="frmSavedSearchSubmit" value="no">
<input type="hidden" name="subDomain" value="<?=$vatSubDomain?>">
<!--Heading Table starts here-->
<table border="0" cellpadding="0" cellspacing="0" width="600">
	<tr>
		<td valign="top"><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Advanced Search</font></div></td>
		<td align="right" class="smalltxt"><a href="index.php" class="grtxt" style="text-decoration:underline;">More search options</a></td>
		<td width="5"></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="600" align="center" bgcolor="#FFFFFF">
	<? if (count($varSavedSearchInfo) > 0) { ?>
	<tr><td align="right" class="smalltxt">Your saved searches are: <?=$varDisplaySavedSearches;?></td></tr>
	<? }//if ?>
	<tr><td valign="top"><img src="<?=$confServerURL?>/images/blank.gif" height="12"></td></tr>
	<?php if ($sessMatriId !="") { ?>
	<? }//if ?>
	<tr><td valign="top" class="memonlnull"><img src="<?=$confServerURL?>/images/blank.gif" height="2"></td></tr>
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" width="100%" border="0">
				<tr>
					<td width="29" valign="top"><img src="<?=$confServerURL?>/images/blank.gif" width="19"></td>
					<td width="526" valign="top">
						<table cellspacing="0" cellpadding="6" width="530" border="0">
							<form name="AdvSearch" action="<?=$confServerURL?>/nikah-search/mm_searchres_thumb.php" method="post" onsubmit="return advsearchvalid();">
								<tr><td height="30" valign="middle" class="serboxtitle1" align="justify"><font class="smalltxt">&nbsp;Are you looking for someone in particular? To find that special person you need to add a &nbsp;detailed description of your future partner.</font></td></tr>
						</table>
						<table cellspacing="0" cellpadding="0" width="526" border="0" class="serboxtitle2">
							<tr bgcolor="#FFFFFF">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="3" colspan width="10"></td>
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="3" width="110"></td>
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="3" width="400"></td>
							</tr>
							<tr>
								<td height="17" colspan="3" class="serboxtitle"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="10"><font class="serboxtitletxt"><font size="2">Basic Details</font></font></td>
							</tr>
							<!--Looking For Gender And Age group starts-->
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="4"></td></tr>
							<tr><td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td><td height="10" colspan="2" class="smalltxt"><font class="smallbold3"><strong>*</strong></font> marked fields are mandatory</td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Looking for starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt"><b>Looking for</b> <font class="smallbold3"><strong>*</strong></font></td>
								<td>
									<input type="radio" name="gender" value="2" <?php if(($sessGender==1) || ($sessMatriId =="")) { echo "checked"; }?> onClick="funLookingBride();">Female
									<input type="radio" name="gender" value="1" <?php if(($sessGender==2) && ($sessMatriId !="")) { echo "checked"; }?> onClick="funLookingGroom();"> Male
									&nbsp;&nbsp;Age&nbsp;&nbsp;<input type="text" size="2" maxlength="2" name="ageFrom" value="<?=$sessGender==2 ? '21' : '18';?>" style="width:25px;font-family: Verdana;font-size : 8pt">&nbsp;&nbsp;To&nbsp;&nbsp;<input type="text" size="2" maxlength="2" name="ageTo" value="30" style="width:25px;font-family: Verdana;font-size : 8pt">
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Looking for ends here -->
							<!-- Marital status starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt"><b>Marital status</b></td>
								<td class="smalltxt">
									<input type="checkbox" value="" checked name="lookingStatus" onClick="funMaritalStatusAny()"><label for="any">&nbsp;&nbsp;Any</label>
									<input type="checkbox" name="lookingStatus" value="1" onClick="funMaritalStatus()"><label for="maritalStatus1">&nbsp;&nbsp;Unmarried</label>
									<input type="checkbox" name="lookingStatus" value="2" onClick="funMaritalStatus()"><label for="maritalStatus2">&nbsp;&nbsp;Separated</label><br>
									<input type="checkbox" name="lookingStatus" value="3" onClick="funMaritalStatus()"><label for="maritalStatus3">&nbsp;&nbsp;Widow/Widower</label>
									<input type="checkbox" name="lookingStatus" value="4" onClick="funMaritalStatus()"><label for="maritalStatus4">&nbsp;&nbsp;Divorced</label>
									<input type="checkbox" name="lookingStatus" value="5" onClick="funMaritalStatus()"><label for="maritalStatus5">&nbsp;&nbsp;Married
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Marital status ends here -->
							<!-- Height starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt"><b>Height</b></td>
								<td class="smalltxt">
									<select class="combobox" name="heightFrom">
									<?=$objProductFacebook->getValuesFromArray($varArrHeightFeetList, "", "", "121.92");?>
									</select> &nbsp;&nbsp; To 
									<select class="combobox" name="heightTo">
									<?=$objProductFacebook->getValuesFromArray($varArrHeightFeetList, "", "", "241.3");?>
									</select>
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Height ends here -->

							<!-- Mother Tongue starts here -->
							<tr>
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt"><b>Native language</b></td>
								<td class="smalltxt">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
										<td valign="top">
											<select style="width:190px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="arrMotherTongue" multiple size="5">
											<?=$objProductFacebook->getValuesFromArray($varArrMotherTongueList, "Any", "", '');?>
											</select>
										</td>
										<td valign="middle" width="50" align="center">
											<input type="button" name="but1" style="background:url(<?=$confServerURL?>/images/add_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.arrMotherTongue, this.form.motherTongue);"><br><br><input type="button" name="but2" style="background:url(<?=$confServerURL?>/images/remove_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.motherTongue, this.form.arrMotherTongue);"> 
										</td>
										<td valign="top">
											<select class="combobox" style="width:150px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" name="motherTongue[]" id="motherTongue" multiple size="5"></select>
										</td>
									</tr>
								</table>
							</td> 
						</tr>
						<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
						<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
						<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
						<!-- Mother Tongu ends here -->

							<!-- Religion starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt"><b>Sect</b></td>
								<td class="smalltxt">
								<?php if ($vatSubDomain=="malaysia") {
									echo '<input type="hidden" name="arrReligion" value="1">';
									echo '<b>Sunni</b>'; }else { ?> 
									<table border="0" cellpadding="0" cellspacing="0"><tr>
										<td valign="top">
											<select style="width:190px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="arrReligion" multiple size="5">
											<?=$objProductFacebook->getValuesFromArray($varArrReligionList, "Any", "", '');?>
											</select>
										</td>
										<td valign="middle" width="50" align="center">
										<input type="button" name="but1" style="background:url(<?=$confServerURL?>/images/add_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.arrReligion, this.form.religion);"><br><br><input type="button" name="but2" style="background:url(<?=$confServerURL?>/images/remove_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.religion, this.form.arrReligion);"> 
										</td>
										<td valign="top">
											<select class="combobox" style="width:150px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" name="religion[]" id="religion" multiple size="5"></select>
										</td></tr>
									</table>
								<?php }//if?>
								</td> 
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Religion ends here -->

							<!-- Caste / Division starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt"><b>Division</b></td>
								<td class="smalltxt">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr><td valign="top">
											<select style="width:190px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" name="arrCaste" class="combobox" multiple size="5">
											<? print $varArrCasteDivisionList;?>	<?=$objProductFacebook->getValuesFromArray($varArrCasteDivisionList, "Any", "", '');?>
											</select>
										</td>
										<td valign="middle" width="50" align="center">
											<input type="button" name="but1" style="background:url(<?=$confServerURL?>/images/add_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.arrCaste, this.form.caste);"><br><br><input type="button" name="but2" style="background:url(<?=$confServerURL?>/images/remove_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.caste, this.form.arrCaste);">
										</td>
										<td valign="top">
											<select class="combobox" style="width:150px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" name="caste[]" id="caste" multiple size="5"></select>
										</td>
									</tr></table>
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Caste / Division ends here -->
							<!-- Education starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Education</b></td>
								<td class="smalltxt">
									<table border="0" cellpadding="0" cellspacing="0">
									<tr><td valign="top">
								<select style="width:190px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="arrEducation" multiple size="5">
									<?=$objProductFacebook->getValuesFromArray($varArrPartnerEducationList, "Any", "", '');?>
								</select>
								</td>
								<td valign="middle" width="50" align="center">
									<input type="button" name="but1" style="background:url(<?=$confServerURL?>/images/add_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.arrEducation, this.form.education);"><br><br><input type="button" name="but2" style="background:url(<?=$confServerURL?>/images/remove_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.education, this.form.arrEducation);">
								</td>
								<td valign="top">
									<select style="width:150px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="education[]" id="education" multiple size="5"></select>
								</td>
								</tr></table></td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Education ends here -->
							<!-- Citizenship starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Citizenship</b></td>
								<td class="smalltxt">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr><td valign="top">
											<select style="width:190px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="arrCitizenship" multiple size="5">
											<?=$objProductFacebook->getValuesFromArray($varArrCountryList, "Any", "", '');?></select>
										</td>
										<td valign="middle" width="50" align="center">
										<input type="button" name="but1" style="background:url(<?=$confServerURL?>/images/add_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.arrCitizenship, this.form.citizenship);"><br><br><input type="button" name="but2" style="background:url(<?=$confServerURL?>/images/remove_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.citizenship, this.form.arrCitizenship);"></td>
										<td valign="top">
											<select style="width:150px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="citizenship[]" id="citizenship" multiple size="5"></select>
										</td>
									</tr></table>
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Citizenship ends here -->
							<!-- Country Living in starts here -->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Country living in</b></td>
								<td class="smalltxt">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr><td valign="top">
											<select style="width:190px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="arrCountry" multiple size="5">
												<?=$objProductFacebook->getValuesFromArray($varArrCountryList, "Any", "", '');?>
											</select>
										</td>
										<td valign="middle" width="56" align="center">
											<input type="button" name="but1" style="background:url(<?=$confServerURL?>/images/add_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.arrCountry, this.form.country);"><br><br><input type="button" name="but2" style="background:url(<?=$confServerURL?>/images/remove_button.gif) no-repeat;width:56px;border:0" onClick="moveOptions(this.form.country, this.form.arrCountry);">
										</td>
										<td valign="top">
											<select style="width:150px;font-family: Verdana, arial, Verdana, sans-serif;font-size : 8pt" class="combobox" name="country[]" id="country" multiple size="5"></select>
										</td>
									</tr></table>
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!-- Country Living in ends here -->
							<!--When Posted starts here--->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>When posted</b></td>
								<td class="smalltxt">
									<input type="radio" name="postedOn" value="" onClick="funPostedAll();" checked>All
									<input type="radio" name="postedOn" value="2" onClick="funPostedAfter();">Posted after
									<select style="FONT-SIZE: 9pt; WIDTH: 75px; FONT-FAMILY: MS Sans serif, arial, Verdana, sans-serif" name="postedMonth" class="combobox" onChange="funPostedAfter();">
										<option value="">-Month-</option>
										<option value="01">January</option>
										<option value="02">February</option>
										<option value="03">March</option>
										<option value="04">April</option> 
										<option value="05">May</option>
										<option value="06">June</option>
										<option value="07">July</option> 
										<option value="08">August</option>
										<option value="09">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
									<select style="FONT-SIZE: 8pt; WIDTH: 55px; FONT-FAMILY: arial, Verdana, sans-serif" name="postedDay" class="combobox" onChange="funPostedAfter();">
										<option value="1" selected>-Date-</option>
										<option value="01">1</option>
										<option value="02">2</option>
										<option value="03">3</option>
										<option value="04">4</option>
										<option value="05">5</option>
										<option value="06">6</option>
										<option value="07">7</option>
										<option value="08">8</option>
										<option value="09">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
									<select style="FONT-SIZE: 8pt; WIDTH: 65px; FONT-FAMILY: arial, Verdana, sans-serif" name="postedYear" class="combobox" onChange="funPostedAfter();">
										<option value="">-Year-</option>
										<?=$varDOBYear=getYears()?>
									</select>
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!--When Posted ends here--->
							<!--Search By starts here--->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Search by</b></td>
								<td class="smalltxt">
									<input type="radio" name="searchBy" value="1" checked>Date updated
									<input type="radio" name="searchBy" value="2">Date created
									<input type="radio" name="searchBy" value="3">Last login
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!--Search By ends here--->
							<!--Profiles with Photo & Horoscope starts here--->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Show</b></td>
								<td class="smalltxt">
								<input type="checkbox" name="showPhoto[]" value="1">Profiles with photo
								</td>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							</tr>
							<!--Profiles with Photo & Horoscope ends here--->
							<?php if ($sessMatriId !="") { ?>
							<!--Display format starts here--->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Don't show</b></td>
								<td class="smalltxt">
									<input type="checkbox" name="donotShow[]" value="1">Ignored profiles<input type="checkbox" name="donotShow[]" value="2">Profiles already contacted</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!--Display format ends here--->
							<?  }//if ?>
							<!--Display format starts here--->
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top"><b>Display format</b></td>
								<td class="smalltxt">
									<select size="1" name="displayFormat" class="combobox">
										<?php if($js_br=="I" || $js_br=="F") { ?>
										<option value="P">Photo Gallery</option>
										<? } ?>
										<option  value="B" selected>Basic view</option> 
										<option value="T">Thumbnail view</option>
									</select>
								</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<!--Display format ends here--->
				<?php if ($sessMatriId !="") { ?>
					<tr><td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="8"></td>
					<td height="10" colspan="2">
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr><td height="25" valign="middle"><a href="javascript:srchblocking('savesearchblock-off','savesearch-img','')"><img src="<?=$confServerURL?>/home/images/collapsed.gif" id="savesearch-img" border="0" hspace="5"></a> <a href="javascript:srchblocking('savesearchblock-off','savesearch-img','')" class="textsmallbold">Saved Search Form</a></td></tr>
						<tr>
						<td align="left"  valign="top">
						<div id="savesearchblock-off" style="display: none;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr class="smalltxt">
								<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
								<td class="smalltxt" valign="top" colspan="2">You have the option of saving the above search criteria to avoid selecting it each time. You can save upto 3 search criteria</td>
							</tr>
							<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
							<tr class="smalltxt"><td colspan="3">
								<table width="100%"><tr>
									<td class="smalltxt" align="left" valign="middle" width="150">&nbsp;<b>Enter search name</b></td><td width="250"><input type="text" class="smalltxt" name="saveName" size="15" value=""> &nbsp;<font class="smalltxt">(Example: With photo)</td><td><input type="image" src="<?=$confServerURL?>/images/save_search.gif" onClick="return funSaveSearch();"></font></td></tr>
								</table>
							</td></tr>
						</table>
						</div>
					</td></tr>
					</table>
					</td></tr>
					<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
					<tr><td height="1" colspan="3" bgcolor="#FFFFFF"><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="4"></td></tr>
					<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>

					<!--<tr class="smalltxt">
						<td><img src="<?=$confServerURL?>/images/blank.gif" height="4" width="10"></td>
						<td class="smalltxt" valign="top" colspan="2">You have the option of saving the above search criteria to avoid selecting it each time. You can save upto 3 search criteria</td>
					</tr>
					<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
					<tr class="smalltxt"><td colspan="3">
					<table width="100%"><tr>
						<td class="smalltxt" align="left" valign="middle" width="150">&nbsp;&nbsp;&nbsp;&nbsp;<b>Enter search name</b></td><td width="250"><input type="text" class="smalltxt" name="saveName" size="15" value=""> &nbsp;<font class="smalltxt">(Example: With photo)</td><td><?php if ($sessMatriId !="") { ?><input type="image" src="<?=$confServerURL?>/images/save_search.gif" onClick="return funSaveSearch();"><? }//if?></font></td>
					</tr></table>
					</td>
					</tr>-->
				<?php }//if?>
					<tr><td height="10" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
					<tr>
						<td><img src="<?=$confServerURL?>/images/blank.gif" height="1" width="21"></td>
						<td colspan="2" class="smalltxt" align="center">
						<input type="image" src="<?=$confServerURL?>/images/search.gif" onClick="return validate();"></td>
					</tr>
					<tr><td height="15" colspan="3"><img src="<?=$confServerURL?>/images/blank.gif" height="10" width="4"></td></tr>
				</table>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
<!--from ends here-->
<input type="hidden" name="page" value="1">
</form>
<br><script language="javascript">funLookingBride();</script>

<?php
//UNSET OBJECT
unset($objProductFacebook);
?>