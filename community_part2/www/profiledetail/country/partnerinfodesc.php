<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-08
# Project	  : MatrimonyProduct
# Filename	  : partnerinfodesc.php
#=====================================================================================================================================
# Description : display information of partner info. It has partner info form and update function partner information.
#=====================================================================================================================================

$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath."/conf/cookieconfig.inc");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsSearch.php');
include_once($varRootBasePath.'/conf/tblfields.inc');
include_once($varRootBasePath.'/conf/cityarray.inc');
include_once($varRootBasePath.'/www/search/srchcommonfuns.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;
$objSearch	= new Search;
$objDomain	= new domainInfo;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['editpartner'];

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
function displaySelectedValuesFromArray($argArrName,$argSelectedValue) {
	$funArrSelectedValue	= explode("~", $argSelectedValue);
	if($argSelectedValue == 0 || $argSelectedValue == '') { $varSelectec = 'selected';}
	$funOptions				= '<option value="0" '.$varSelectec.'>Any</option>';
	foreach($argArrName as $funIndex => $funValues)
	{
		if (in_array($funIndex, $funArrSelectedValue))
		{ $funOptions .= '<option value="'.$funIndex.'"  selected>'.$funValues.'</option>';}
		else
		{ $funOptions .= '<option value="'.$funIndex.'">'.$funValues.'</option>';}
	}//for
	return $funOptions;

}//displaySelectedValuesFromArray

$argFields						= array('Age_From','Age_To','Looking_Status','Have_Children','Height_From','Height_To','Weight_From','Weight_To','Physical_Status','Education','Religion','Denomination','CommunityId','CasteId','SubcasteId','Chevvai_Dosham','Citizenship','Country','Resident_India_State','Resident_District','Resident_USA_State','Resident_Srilanka_State','Resident_Pakistan_State','Resident_Pakistan_District','Resident_Status','Mother_Tongue','Partner_Description','Eating_Habits','Drinking_Habits','Smoking_Habits','Employed_In','Occupation','GothramId','Star','Raasi','IncludeOtherReligion','StIncome','EndIncome');
$argCondition = "WHERE MatriId='".$sessMatriId."'";
$varMemberPartnerInfoResultSet	= $objDBSlave->select($varTable['MEMBERPARTNERINFO'],$argFields,$argCondition,0);
$varMemberInfo					= mysql_fetch_array($varMemberPartnerInfoResultSet);
$argCondition				= "WHERE MatriId='".$sessMatriId."' AND ".$varWhereClause;
$argFields 					= $arrMEMBERINFOfields;
$varSelectPartnerInfoRes	= $objDBSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0,$varOwnProfileMCKey);

//CHECK USER HAS FROMAGE AND end AGE FOR PARTNER PREFERENCE TABLE
	$varCommunityId				= $varSelectPartnerInfoRes['CommunityId'];
	$varGender					= $varSelectPartnerInfoRes['Gender'];
	$funPartnerStartAge			= $varMemberInfo['Age_From'];
	$funPartnerEndAge			= $varMemberInfo['Age_To'];
	$funPartnerStartHeight		= $varMemberInfo['Height_From'];
	$funPartnerEndHeight		= $varMemberInfo['Height_To'];
	$arrMaritalChecked			= explode("~",$varMemberInfo["Looking_Status"]);
	$varHaveChildStatus			= $varMemberInfo['Have_Children'];
	$varPhysicalStatus			= $varMemberInfo['Physical_Status'];
	$varMotherTongueString		= $varMemberInfo["Mother_Tongue"];
	$varReligionString			= $varMemberInfo["Religion"];
	$varDenominationString		= $varMemberInfo["Denomination"];
	$varCasteString				= $varMemberInfo["CasteId"];
	$varSubCasteString			= $varMemberInfo["SubcasteId"];
	//$varManglikStatus			= $varMemberInfo["Chevvai_Dosham"];
	$varManglikStatus			= explode("~",$varMemberInfo["Chevvai_Dosham"]);	
	$varEatStatus				= explode("~",$varMemberInfo["Eating_Habits"]);	
	//$varEatStatus				= $varMemberInfo["Eating_Habits"];
	$varSmokeStatus				= explode("~",$varMemberInfo["Smoking_Habits"]);
    $varDrinkStatus				= explode("~",$varMemberInfo["Drinking_Habits"]);
	//$varSmokeStatus			= $varMemberInfo["Smoking_Habits"];
	//$varDrinkStatus			= $varMemberInfo["Drinking_Habits"];
	$varEduString				= $varMemberInfo["Education"];
	$varCitizenshipString		= $varMemberInfo["Citizenship"];
	$varCountryString			= $varMemberInfo["Country"];
	$varResidingIndiaString		= $varMemberInfo["Resident_India_State"];
	$varResidingUSAString		= $varMemberInfo["Resident_USA_State"];
	$varResidingSrilankaString	= $varMemberInfo["Resident_Srilanka_State"]; 
	$varResidingPakistanString	= $varMemberInfo["Resident_Pakistan_State"];       //For Pakistan
	$varResidentPakDistrictString= $varMemberInfo["Resident_Pakistan_District"];  // For pakistan dist
	$varResidentString			= $varMemberInfo["Resident_Status"];
	$varResidentDistrictString  = $varMemberInfo["Resident_District"];
	$varEmployedInString        = $varMemberInfo["Employed_In"];
	$varOccupationString        = $varMemberInfo["Occupation"];
	$varGothramString           = $varMemberInfo["GothramId"];
	$varStarString              = $varMemberInfo["Star"];
	$varRaasiString             = $varMemberInfo["Raasi"];
	 $varStIncome				= $varMemberInfo["StIncome"];
	 $varEndIncome				= $varMemberInfo["EndIncome"];
	$varIncludeOtherReligion	= $varMemberInfo["IncludeOtherReligion"];
	 $arrcoun					= explode("~",$varMemberInfo["Country"]);
	//print_r($arrcoun);	
	$stat=0;	
	if(in_array(98,$arrcoun)){
		$stat=1;
	}	

$objDBSlave->dbClose();

//Getting start age for male & female
$varMaleStartAge	= $objDomain->getMStartAge();
$varFemaleStartAge	= $objDomain->getFStartAge();

//getting size of marital status option and used in javascript
$varSizeMaritalStatus	= 0;
$varMStatusFeature		= $objDomain->useMaritalStatus(); 
if($varMStatusFeature == 1) {
	$arrRetMaritalStatus	= $objDomain->getMaritalStatusOption();
	if($varSelectPartnerInfoRes['Gender'] == 1 && $varCommunityId==2503) {
		unset($arrRetMaritalStatus[5]);
	} else if($varSelectPartnerInfoRes['Gender'] == 2 && $varCommunityId==2006) {
		unset($arrRetMaritalStatus[6]);
	}
	$varSizeMaritalStatus	= sizeof($arrRetMaritalStatus);
}
$varTabIndex = 1;

?>
<script>
<?php echo genCountrybasedStates();?>
var starmtage=<?=$varMaleStartAge?>,starfmtage=<?=$varFemaleStartAge?>,mstatuscnt=<?=$varSizeMaritalStatus?></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/<?=$_IncludeFolder?>partnerinfo.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/register.js" ></script>
<style>.srchselect {width: 180px;}</style>
		<? include_once('settingsheader.php');?>
		<center>
			<div class="padt10">
				<?if($varUpdatePrimary == 'yes') { ?>
				<div class='fleft'>
					Your Partner preference has been modified successfully.
					<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
				</div>
				<? } else { ?>
				<form method='post' name='frmProfile' id='frmProfile' onSubmit='return PartnerValidate();' style="padding:0px;margin:0px;">
				<input type='hidden' name='act' value='addedpartnerdesc'>
				<input type='hidden' name='partnerinfosubmit' value='yes'>
				<input type='hidden' name='oldpartnerdesc' value='<?=trim($varMemberInfo['Partner_Description'])?>'>
				<input type='hidden' name='genderval' value='<?=$varGender?>'>
				<input type="hidden" name="district" id="district" value="<?=$varResidentDistrictString?>">
				<input type="hidden" name="pakistanDistrict" id="pakistanDistrict" value="<?=$varResidentPakDistrictString?>">
				<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">
				<div class="normtxt clr bld fleft padl25 tlleft padb10">Basic Information<br clear="all"/>
				<font class="smalltxt notbld"> Here you can customize your partner preference. You will receive matches by e-mail based on the highlighted fields (<img src="http://img.communitymatrimony.com/images/prmok.jpg" />) below which form your MatchWatch criteria. Profiles that exactly match your partner preference are tagged as "Preferred Profile."</font></div>
				<? if($varMStatusFeature==1) {
					if($varSizeMaritalStatus>1) {
					?>
						<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomain->getMaritalStatusLabel()?></div>
						<div class="fleft pfdivrt tlleft" >
							<input type='checkbox' name='lookingStatus[]' id='lookingStatus' value='0' <?if(in_array(0,$arrMaritalChecked)){ echo "checked";}?> onClick='maritalstpartner(1);partnerHaveChildnp();'>Any &nbsp;
							<? $i=1; foreach($arrRetMaritalStatus as $key=>$value){
								$varChecked = (in_array($key,$arrMaritalChecked))?'checked':'';
								echo '<input type="checkbox" name="lookingStatus[]" value="'.$key.'"  id="lookingStatus" '.$varChecked.' onClick="maritalstpartner(2);partnerHaveChildnp();"><font class="smalltxt" style="padding-right: 5px;">'.$value.'</font>';
								if($i==3) {echo "<BR>";}
								$i++;
							}?><br><span id='mstatus' class='errortxt'></span>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="lookingStatus[]" value="<?=key($arrRetMaritalStatus)?>">
					<? }
				 } ?>
				 <div id="hchild" >
				 <div class="smalltxt fleft tlright srchdivlt">Have Children</div>
				 <div class="fleft pfdivrt tlleft" >
					<? $index=1; foreach($arrPartnerChilrenLivingStatusList as $key=>$value){
						$varChecked = ($key == $varHaveChildStatus)?'checked':'';
						if($index > 3) echo "<br>";
						echo '<input type="radio" name=partnerHavechild value="'.$key.'"  id="partnerHavechild'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					$index++;}?>
				 </div><br clear="all"/>
				 </div>
				
				<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Age</div>
				<div class="fleft pfdivrt tlleft smalltxt">From <input type=text name=fromAge size=2 maxlength=2 value='<?=$funPartnerStartAge?>' class='inputtext'> &nbsp; to &nbsp; <input type=text name=toAge size=2 maxlength=2 value='<?=$funPartnerEndAge?>' class='inputtext'> yrs<br><span id='stage' class='errortxt'></span>
				</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Height</div>
				<div class="fleft pfdivrt tlleft smalltxt">From 
					<select class='inputtext' name='heightFrom' size='1'>
					<?=$objCommon->getValuesFromArray($arrHeightList, "", "", $funPartnerStartHeight);?>
					</select>&nbsp;&nbsp; To
					<select class='inputtext' NAME='heightTo' size='1'>
					<?=$objCommon->getValuesFromArray($arrHeightList, "", "", $funPartnerEndHeight);?>
					</select>
					<br><span id='stheight' class='errortxt'></span>
				</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Physical Status</div>
				<div class="fleft pfdivrt tlleft" >
					<? $index=1; foreach($arrPhysicalStatusList as $key=>$value){
						$varChecked = ($key == $varPhysicalStatus)?'checked':'';
						if($index > 3) echo "<br>";
						echo '<input type="radio" name=physicalStatus value="'.$key.'"  id="physicalStatus'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
					$index++;}?>
				</div><br clear="all"/>
               
				<? if($objDomain->useMotherTongue()) {
					$arrRetMotherTongue	= $objDomain->getMotherTongueOption();
					$varSizeMotherTongue= sizeof($arrRetMotherTongue);
					if($varSizeMotherTongue>1) {
						$arrRetMotherTongue	= $objCommon->changingArray($arrRetMotherTongue);
					?>
						<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomain->getMotherTongueLabel()?></div>
						<div class="fleft srchdivrt tlleft" ><div class="fleft"><select class='srchselect' id="motherTongueTemp" NAME='motherTongueTemp[]' ondblclick="moveOptions(this.form.motherTongueTemp, this.form.motherTongue);fnAnyChk(document.frmProfile.motherTongueTemp,document.frmProfile.motherTongue);" size='4' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetMotherTongue,"");?>
							</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.motherTongueTemp, this.form.motherTongue);fnAnyChk(document.frmProfile.motherTongueTemp,document.frmProfile.motherTongue);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.motherTongue, this.form.motherTongueTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="motherTongue" name="motherTongue[]" tabindex="11" ondblclick="moveOptions(this.form.motherTongue, this.form.motherTongueTemp)"><? if(isset($varMotherTongueString) && $varMotherTongueString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varMotherTongueString, $arrRetMotherTongue); }?></select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="motherTongue[]" value="<?=key($arrRetMotherTongue)?>">
					<? }
				 } ?>
				
				<div class="normtxt clr bld fleft padl25 padt10">Cultural Background</div><br clear="all"/>
				
				<? if($objDomain->useReligion()) {
					$arrRetReligion	= $objDomain->getReligionOption();
					$varSizeReligion= sizeof($arrRetReligion);
					if($varSizeReligion>1) {
					?>
						<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomain->getReligionLabel()?></div>
						<div class="fleft srchdivrt tlleft" ><div class="fleft">
							<select class='srchselect' id='religionTemp' NAME='religionTemp[]' ondblclick="moveOptions(this.form.religionTemp,this.form.religion);fnAnyChk(document.frmProfile.religionTemp,document.frmProfile.religion);" size='4' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetReligion,"");?>
							</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.religionTemp, this.form.religion);fnAnyChk(document.frmProfile.religionTemp,document.frmProfile.religion);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.religion, this.form.religionTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="religion" name="religion[]" tabindex="11" ondblclick="moveOptions(this.form.religion, this.form.religionTemp)">
							<? if(isset($varReligionString) && $varReligionString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varReligionString, $arrRetReligion); }?>
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="religion[]" value="<?=key($arrRetReligion)?>">
					<? }
				 } ?>

				<? 	
				 $isReligion = $objDomain->useReligion();
				if($isReligion==1 && $varCommunityId !=2500 && $varCommunityId !=2503 && $varCommunityId !=2502 && $varCommunityId !=2501 && $varCommunityId !=2504 && $varCommunityId !=2007 && $varCommunityId !=2008){
				$isMoreReligion = $objDomain->getReligionOption();   
					if(count($isMoreReligion) > 1){
						if($varIncludeOtherReligion==1){
						echo '<div ><input type="checkbox" name="IncludeOtherReligion" value="1" checked>Include matching profile from other religion also</div>';
						}else{
							echo '<div ><input type="checkbox" name="IncludeOtherReligion" value="1">Include matching profile from other religion also</div>';
						}
					}else{
						echo '<input type="hidden" name="IncludeOtherReligion" value="0">';
					}
					$showBr = '<br clear="all"/>';
				}else{
					$showBr = '';
				}?>

				 <? if($objDomain->useDenomination()) {
					$arrRetDenomination	= $objDomain->getDenominationOption();
					$varSizeDenomination= sizeof($arrRetDenomination);
					if($varSizeDenomination>1) {
					?>
						<div class="smalltxt fleft tlright srchdivlt"><?=$showBr;?><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomain->getDenominationLabel()?></div>
						<div class="fleft srchdivrt tlleft" ><div class="fleft">
							<select class='srchselect' id="denominationTemp" NAME='denominationTemp[]' ondblclick="moveOptions(this.form.denominationTemp, this.form.denomination);fnAnyChk(document.frmProfile.denominationTemp,document.frmProfile.denomination);" size='4' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetDenomination,"");?>
							</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.denominationTemp, this.form.denomination);fnAnyChk(document.frmProfile.denominationTemp,document.frmProfile.denomination);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.denomination, this.form.denominationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="denomination" name="denomination[]" tabindex="11" ondblclick="moveOptions(this.form.denomination, this.form.denominationTemp)">
							<? if(isset($varDenominationString) && $varDenominationString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varDenominationString, $arrRetDenomination);} ?>
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="denomination[]" value="<?=key($arrRetDenomination)?>">
					<? }
				 } ?>

				<? if($objDomain->useCaste() && $objDomain->isCasteMandatory() == 1) {
					$arrRetCaste	= $objDomain->getCasteOption();
					$varSizeCaste	= sizeof($arrRetCaste);
					if($varSizeCaste>1) {
						$arrRetCaste= $objCommon->changingArray($arrRetCaste);
						unset($arrRetCaste['9998']);
					?>
						<div class="smalltxt fleft tlright srchdivlt"><?=$showBr;?><?=$objDomain->getCasteLabel()?></div>
						<div class="fleft srchdivrt tlleft" ><div class="fleft">
							<select class='srchselect' id="casteDivisionTemp" NAME='casteDivisionTemp[]' ondblclick="moveOptions(this.form.casteDivisionTemp, this.form.casteDivision);fnAnyChk(document.frmProfile.casteDivisionTemp,document.frmProfile.casteDivision);" size='4' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetCaste,"");?>
							</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.casteDivisionTemp, this.form.casteDivision);fnAnyChk(document.frmProfile.casteDivisionTemp,document.frmProfile.casteDivision);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.casteDivision, this.form.casteDivisionTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="casteDivision" name="casteDivision[]" tabindex="11" ondblclick="moveOptions(this.form.casteDivision, this.form.casteDivisionTemp)">
							<? if(isset($varCasteString) && $varCasteString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varCasteString, $arrRetCaste);} ?>
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="casteDivision[]" value="<?=key($arrRetCaste)?>">
					<? }
				 } ?>

				<? if($objDomain->useSubcaste() && $objDomain->isSubcasteMandatory() == 1) {
					$arrRetSubcaste	= $objDomain->getSubcasteOption();
					$varSizeSubcaste= sizeof($arrRetSubcaste);
					if($varSizeSubcaste>1) {
						$arrRetSubcaste	= $objCommon->changingArray($arrRetSubcaste);
						unset($arrRetSubcaste['9998']);
					?>
						<div class="smalltxt fleft tlright srchdivlt"><?=$showBr;?><?=$objDomain->getSubcasteLabel()?></div>
						<div class="fleft srchdivrt tlleft" ><div class="fleft">
							<select class='srchselect' id="subCasteTemp" NAME='subCasteTemp[]' ondblclick="moveOptions(this.form.subCasteTemp, this.form.subCaste);fnAnyChk(document.frmProfile.subCasteTemp,document.frmProfile.subCaste);" size='4' MULTIPLE >
								<?=displaySelectedValuesFromArray($arrRetSubcaste,"");?>
							</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.subCasteTemp, this.form.subCaste);fnAnyChk(document.frmProfile.subCasteTemp,document.frmProfile.subCaste);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.subCaste, this.form.subCasteTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="subCaste" name="subCaste[]" tabindex="11" ondblclick="moveOptions(this.form.subCaste, this.form.subCasteTemp)">
							<? if(isset($varSubCasteString) && $varSubCasteString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varSubCasteString, $arrRetSubcaste);} ?>
							</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
						</div><br clear="all"/>
					<? } else { ?>
						<input type="hidden" name="subCaste[]" value="<?=key($arrRetSubcaste)?>">
					<? }
				 } ?>
                
               
              <?if($objDomain->useStar()) { ?>
				<div class="smalltxt fleft tlright srchdivlt"><?=$objDomain->getStarLabel();?></div>
				<div class="fleft srchdivrt tlleft"><div class="fleft">
					<select class='srchselect' id="starTemp" name='starTemp[]' ondblclick="moveOptions(this.form.starTemp, this.form.star);fnAnyChk(document.frmProfile.starTemp,document.frmProfile.star);" size='4' multiple>
				    <?=displaySelectedValuesFromArray($arrGetStarOption = $objDomain->getStarOption(),"");?>
					</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.starTemp, this.form.star);fnAnyChk(document.frmProfile.starTemp,document.frmProfile.star);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.star, this.form.starTemp)"></div><div class="fleft">
					<select class="srchselect" size="4" multiple id="star" name="star[]" tabindex="11" ondblclick="moveOptions(this.form.star, this.form.starTemp)">
					<? if(isset($varStarString) && $varStarString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varStarString, $arrGetStarOption);} ?>
					</select></div>
				</div><br clear="all"/>
			  <? } ?>
			
              
                 <? if($objDomain->useGothram()) {
			        $varCasteId = $varSelectPartnerInfoRes['CasteId'];
					$arrRetGothram	= $objDomain->getGothramOptionsForCaste($varCasteId);
					$varSizeGothram	= sizeof($arrRetGothram);
		            if($varSizeGothram > 1) {
					  ?>
						<div class="smalltxt fleft tlright srchdivlt" ><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomain->getGothramLabel()?></div>
						<div class="fleft srchdivrt tlleft">
							<div class="fleft"><select name='gothramTemp[]' ondblclick="moveOptions(this.form.gothramTemp, this.form.gothram);fnAnyChk(document.frmProfile.gothramTemp,document.frmProfile.gothram);" id='gothramTemp' size='4' multiple  class='srchselect'><?=displaySelectedValuesFromArray($arrRetGothram,"");?>
							</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.gothramTemp, this.form.gothram)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.gothram, this.form.gothramTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="gothram" name="gothram[]" tabindex="11" ondblclick="moveOptions(this.form.gothram, this.form.gothramTemp)">
							<? if(isset($varGothramString) && $varGothramString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varGothramString, $arrRetGothram);} ?>
							</select></div></div><br clear="all"/>
		        			<? } ?>
					<?  } ?>
				
					<? if($objDomain->useDosham()) {
					 $arrRetDosham	= $objDomain->getDoshamOption();
					unset($arrRetDosham['3']);
					 $varSizeDosham	= sizeof($arrRetDosham);
					if($varSizeDosham>1) {
					?>
						<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;<?=$objDomain->getDoshamLabel()?></div>
						<div class="fleft srchdivrt tlleft" >
						<input type="checkbox" name="manglik[]" id="manglik" value='0'<?if(in_array(0,$varManglikStatus)){ echo "checked";}?>><font class='smalltxt'>Doesn't matter &nbsp; &nbsp;</font>
					<? foreach($arrRetDosham as $key=>$value){
						$varChecked = (in_array($key,$varManglikStatus))?'checked':'';
						echo '<input type="checkbox" name="manglik[]" value="'.$key.'"  id="manglik" '.$varChecked.'><font class="smalltxt" style="padding-right: 25px;">'.$value.'</font>';
					}?>
					</div><br clear="all"/>
					<? }  else { ?>
						<input type="hidden" name="manglik" value="<?=key($arrRetDosham)?>">
					<? }
				 } ?>
				
				<div class="normtxt clr bld fleft padl25 padt10">Career</div><br clear="all"/>
				
				<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Education in Detail</div>
				<div class="fleft srchdivrt tlleft" ><div class="fleft"><select class='srchselect' id="educationTemp" name='educationTemp[]' size='4' ondblclick="moveOptions(this.form.educationTemp, this.form.education);fnAnyChk(document.frmProfile.educationTemp,document.frmProfile.education);" multiple >
						<?=displaySelectedValuesFromArray($arrEducationList,"");?>
					</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.educationTemp, this.form.education);fnAnyChk(document.frmProfile.educationTemp,document.frmProfile.education);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.education, this.form.educationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="education" name="education[]" tabindex="11" ondblclick="moveOptions(this.form.education, this.form.educationTemp)">
					<? if(isset($varEduString) && $varEduString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varEduString, $arrEducationList);} ?>
					</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
                               
				<? if($confValues["DOMAINCASTEID"] == 2006 && $varGender==1) {
					$arrTotalOccupationList = $arrFemaleDefenceOccupationList;
				} else if($confValues["DOMAINCASTEID"] == 2006 && $varGender==2) {
					$arrTotalOccupationList = $arrDefenceOccupationList;
				}?>
				<div class="smalltxt fleft tlright srchdivlt">Occupation</div>
				<div class="fleft srchdivrt tlleft" ><div class="fleft"><select class='srchselect' id="occupationTemp" name='occupationTemp[]' ondblclick="moveOptions(this.form.occupationTemp, this.form.occupation);fnAnyChk(document.frmProfile.occupationTemp,document.frmProfile.occupation);" size='4' multiple ><?=displaySelectedValuesFromArray($arrTotalOccupationList,"");?>
					</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.occupationTemp, this.form.occupation);fnAnyChk(document.frmProfile.occupationTemp,document.frmProfile.occupation);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.occupation, this.form.occupationTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="occupation" name="occupation[]" tabindex="11" ondblclick="moveOptions(this.form.occupation, this.form.occupationTemp)">
					<? if(isset($varOccupationString) && $varOccupationString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varOccupationString,$arrTotalOccupationList);} ?>
					</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
 
             
				<div class="normtxt clr bld fleft padl25 padt10">Location</div><br clear="all"/>
                <? if($confValues["DOMAINCASTEID"] == 2006) { ?><div class="fleft">
				   <select class='srchselect' id="citizenship" name='citizenship[]' multiple size='4' style="display:none">
						<option value="98" selected>India</option>
					</select></div>
				<? } else { ?>
				<div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Citizenship</div>
				<div class="fleft srchdivrt tlleft" ><div class="fleft"><select class='srchselect' id="citizenshipTemp" name='citizenshipTemp[]' ondblclick="moveOptions(this.form.citizenshipTemp, this.form.citizenship);fnAnyChk(document.frmProfile.citizenshipTemp,document.frmProfile.citizenship);" multiple size='4'>
						<?=displaySelectedValuesFromArray($arrCountryList,"");?>
					</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.citizenshipTemp, this.form.citizenship);fnAnyChk(document.frmProfile.citizenshipTemp,document.frmProfile.citizenship);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.citizenship, this.form.citizenshipTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="citizenship" name="citizenship[]" tabindex="11" ondblclick="moveOptions(this.form.citizenship, this.form.citizenshipTemp)">
					<? if(isset($varCitizenshipString) && $varCitizenshipString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{echo $objSearch->getOpionalValues($varCitizenshipString,$arrCountryList);} ?>
					</select></div><br clear="all"><font class='opttxt'>Hold CTRL key to select multiple items.</font>
				</div><br clear="all"/>
				<? } ?>
                <?if($confValues["DOMAINCASTEID"]!=2006){?>
			<div class="srchdivlt smalltxt fleft tlright"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Country Living In </div>
			<div class="srchdivrt smalltxt fleft tlleft">
			<div class="fleft"><select name="countryLivingInTemp[]" id="countryLivingInTemp" size="4" multiple class="srchselect" ondblclick="moveOptions(this.form.countryLivingInTemp, this.form.countryLivingIn);changeincome();fnCountryAnyChk(document.frmProfile.countryLivingInTemp,document.frmProfile.countryLivingIn,document.getElementById('countryLivingIn').value);"> <?=$objCommon->getValuesFromArray($arrCountryList, "Any", "0", "");?></select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button"  onclick="moveOptions(this.form.countryLivingInTemp, this.form.countryLivingIn);changeincome();fnCountryAnyChk(document.frmProfile.countryLivingInTemp,document.frmProfile.countryLivingIn,document.getElementById('countryLivingIn').value);"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="change_state1();moveOptions(this.form.countryLivingIn, this.form.countryLivingInTemp);changeincome();"></div><div class="fleft"><select class="srchselect" size="4" multiple id="countryLivingIn" name="countryLivingIn[]" ondblclick="change_state1();moveOptions(this.form.countryLivingIn, this.form.countryLivingInTemp);changeincome();">
			<?	if(isset($varCountryString) && $varCountryString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{$varCtryReturnVal = $objSearch->getOpionalValues2($varCountryString, $arrCountryList, 'country');}	?>
			</select></div><br clear="all"/><font class='opttxt'>Hold CTRL key to select multiple items.</font>
			</div>
			<?}else{?>
			<div class="srchdivlt smalltxt fleft tlright">Country Living In</div>
			<div class="srchdivrt smalltxt fleft" style="width:60px">India</div>
			<div class="smalltxt fleft tlleft" style="display:none">
			<div class="fleft"><select name="countryLivingInTemp[]" id="countryLivingInTemp" size="4" multiple ondblclick="moveOptions(this.form.countryLivingInTemp,this.form.countryLivingIn);changeincome();	fnCountryAnyChk(document.frmProfile.countryLivingInTemp,document.frmProfile.countryLivingIn,
			document.getElementById('countryLivingInTemp').value);"> <?=$objCommon->getValuesFromArray($arrCountryList, "Any", "0", "");?></select>
			</div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button"  onclick="moveOptions(this.form.countryLivingInTemp, this.form.countryLivingIn);changeincome();fnCountryAnyChk(document.frmProfile.countryLivingInTemp,document.frmProfile.countryLivingIn,document.getElementById('countryLivingInTemp').value);"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="change_state1();moveOptions(this.form.countryLivingIn, this.form.countryLivingInTemp);changeincome();"></div><div class="fleft"><select size="4" multiple id="countryLivingIn" name="countryLivingIn[]" ondblclick="change_state1();moveOptions(this.form.countryLivingIn, this.form.countryLivingInTemp);changeincome();">
			<?	$varCtryReturnVal = $objSearch->getOpionalValues2('98', $arrCountryList, 'country');	?>
			</select></div>
			</div>
			<?}?> 
			<br clear="all">	

			<div id="indstate" >
				<div class="srchdivlt smalltxt fleft tlright"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing India State</div>
				<div class="srchdivrt smalltxt fleft tlleft">
				<div class="fleft"><select id="residingIndiaTemp" name="residingIndiaTemp[]"   size="4" ondblclick="moveOptions(this.form.residingIndiaTemp, this.form.residingIndia);change_citycount();fnStateAnyChk(document.frmProfile.residingIndiaTemp,document.frmProfile.residingIndia,<?=$varTabIndex++?>);" multiple class="srchselect">
						<?=displaySelectedValuesFromArray($arrResidingStateList,"");?>				
				</select>
				</div>	
				<div class="fleft padlr10 padt5">
				<input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingIndiaTemp, this.form.residingIndia);change_citycount();fnStateAnyChk(document.frmProfile.residingIndiaTemp,document.frmProfile.residingIndia,<?=$varTabIndex++?>);"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br>
				<input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingIndia, this.form.residingIndiaTemp);ajaxEditInterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex++?>,'');change_citycount();"></div>
			
			<div class="fleft"><select class="srchselect" size="4" multiple name="residingIndia[]" id="residingIndia" ondblclick="moveOptions(this.form.residingIndia, this.form.residingIndiaTemp);ajaxEditInterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php',<?=$varTabIndex++?>,'');change_citycount();">
  			<?php  
			if(isset($varResidingIndiaString) && $varResidingIndiaString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{$varStatReturnVal = $objSearch->getOpionalValues($varResidingIndiaString, $arrResidingStateList);}
			?>
			</select></div><br clear="all"/><font class='opttxt'>Hold CTRL key to select multiple items.</font>
    		</div>
	    	<br clear="all">
	    	</div>

			<!-- Srilanka state details  -->
			<div id="srilankastate" >
				<div class="srchdivlt smalltxt fleft tlright"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing Srilanka State</div>
				<div class="srchdivrt smalltxt fleft tlleft">
				<div class="fleft"><select id="residingSrilankaTemp" name="residingSrilankaTemp[]"   size="4" ondblclick="moveOptions(this.form.residingSrilankaTemp, this.form.residingSrilanka);fnAnyChk(document.frmProfile.residingSrilankaTemp,document.frmProfile.residingSrilanka);" multiple class="srchselect"><?=displaySelectedValuesFromArray($arrResidingSrilankanList,"");?>				
				</select></div>	
				<div class="fleft padlr10 padt5">
				<input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingSrilankaTemp, this.form.residingSrilanka);fnAnyChk(document.frmProfile.residingSrilankaTemp,document.frmProfile.residingSrilanka);"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br>
				<input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingSrilanka, this.form.residingSrilankaTemp);"></div>
			
			<div class="fleft"><select class="srchselect" size="4" multiple name="residingSrilanka[]" id="residingSrilanka" ondblclick="moveOptions(this.form.residingSrilanka, this.form.residingSrilankaTemp);">
			<?php  
			if(isset($varResidingSrilankaString) && $varResidingSrilankaString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{$varStatReturnVal = $objSearch->getOpionalValues($varResidingSrilankaString, $arrResidingSrilankanList);}
			?>
  			</select></div><br clear="all"/><font class='opttxt'>Hold CTRL key to select multiple items.</font>
    		</div>
	    	<br clear="all">
	    	</div>
			<div id="cityEditInterList">
			</div>
	

			<div id="usstate">
			<div class="srchdivlt smalltxt fleft tlright"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing USA State</div>
			<div class="srchdivrt smalltxt fleft tlleft">
			<div class="fleft"><select id="residingUSATemp" name="residingUSATemp[]" size="4" ondblclick="moveOptions(this.form.residingUSATemp, this.form.residingUSA);fnAnyChk(document.frmProfile.residingUSATemp,document.frmProfile.residingUSA);" multiple class="srchselect"><?=displaySelectedValuesFromArray($arrUSAStateList,"");?>
			</select></div>			
			<div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingUSATemp, this.form.residingUSA);fnAnyChk(document.frmProfile.residingUSATemp,document.frmProfile.residingUSA);"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingUSA, this.form.residingUSATemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple name="residingUSA[]" id="residingUSA" ondblclick="moveOptions(this.form.residingUSA, this.form.residingUSATemp)">
  			<?php  
			if(isset($varResidingUSAString) && $varResidingUSAString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{$varStatReturnVal = $objSearch->getOpionalValues($varResidingUSAString, $arrUSAStateList);}
			?>
			</select></div><br clear="all"/><font class='opttxt'>Hold CTRL key to select multiple items.</font>
    		</div>
	    	<br clear="all">
	    	</div>
			
			<!-- Pakistani state and city maping -->
			<div id="pakistanstate" >
				<div class="srchdivlt smalltxt fleft tlright"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Residing Pakistan State</div>
				<div class="srchdivrt smalltxt fleft tlleft">
				<div class="fleft"><select id="residingPakistanTemp" name="residingPakistanTemp[]"   size="4" ondblclick="moveOptions(this.form.residingPakistanTemp, this.form.residingPakistan);change_citycount1();fnStateAnyChk(document.frmProfile.residingPakistanTemp,document.frmProfile.residingPakistan,<?=$varTabIndex++?>,'pak');" multiple class="srchselect"><?=displaySelectedValuesFromArray($arrResidingPakistaniList,"");?>				
				</select></div><div class="fleft padlr10 padt5">
				<input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingPakistanTemp, this.form.residingPakistan);change_citycount1();fnStateAnyChk(document.frmProfile.residingPakistanTemp,document.frmProfile.residingPakistan,<?=$varTabIndex++?>,'pak');"><br><img src="<?=$confValues['IMGSURL'].'/trans.gif';?>" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingPakistan, this.form.residingPakistanTemp);ajaxEditPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php',<?=$varTabIndex++?>,'');change_citycount1();"></div>
			
			<div class="fleft"><select class="srchselect" size="4" multiple name="residingPakistan[]" id="residingPakistan" ondblclick="moveOptions(this.form.residingPakistan, this.form.residingPakistanTemp);ajaxEditPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php',<?=$varTabIndex++?>,'');change_citycount1();">
  			<?php  
			if(isset($varResidingPakistanString) && $varResidingPakistanString==0){echo $objSearch->getOpionalValues(0, array(0=>'Any'));}else{$varStatReturnVal = $objSearch->getOpionalValues($varResidingPakistanString, $arrResidingPakistaniList);}
			?>
			</select></div><br clear="all"/><font class='opttxt'>Hold CTRL key to select multiple items.</font>
    		</div>
	    	<br clear="all">
	    	</div>
			<div id="cityPakistanList"></div>

		<br clear="all">
		</div><br clear="all">
		<div class="normtxt clr bld fleft padl25 padt10">Lifestyle - Habits</div><br clear="all"/>
				<?php if(sizeof($arrEatingHabitsList)>1){?><div class="smalltxt fleft tlright srchdivlt"><img src="http://img.communitymatrimony.com/images/prmok.jpg" />&nbsp;&nbsp;Food</div>
				<div class="fleft tlleft srchdivrt">
				<div style="width:130px;" class="fleft"><input type="checkbox" name="eatingHabits[]" id="eatingHabits" value='0'<?if(in_array(0,$varEatStatus)){ echo "checked";}?> onClick="eatingHabitschk(1);"><font class="smalltxt" style="padding-left:10px;">Doesn't matter&nbsp;</font></div>
				<? $i=1;foreach($arrEatingHabitsList as $key=>$value){
					$varChecked = (in_array($key,$varEatStatus))?'checked':'';
					echo '<div style="width:130px;" class="fleft"><input type="checkbox" name="eatingHabits[]" value="'.$key.'"  id="eatingHabits" '.$varChecked.' onClick="eatingHabitschk(2);"><font class="smalltxt" style="padding-left: 10px;">'.$value.'</font></div>';
					//if($i==3) {echo "<BR>";}
					$i++;
				}?>					
				</div><br clear="all"/>
				<? } else { ?>
					<input type="hidden" name="eatingHabits[]" value="<?=key($arrEatingHabitsList)?>">
				<? } ?>
				<div class="smalltxt fleft tlright srchdivlt">Smoking</div>
				<div class="fleft tlleft" style="padding:5px 0px 5px 5px;width:420px;" >
				<div style="width:130px;" class="fleft"><input type="checkbox" name="smokingHabits[]" id="smokingHabits" value='0'<?if(in_array(0,$varSmokeStatus)){ echo "checked";}?> onClick="smokingHabitschk(1);"><font class='smalltxt' style="padding-left:10px;">Doesn't matter &nbsp; &nbsp;</font></div>
					<? foreach($arrSmokeList as $key=>$value){
						$varChecked = (in_array($key,$varSmokeStatus))?'checked':'';
						echo '<div style="width:130px;" class="fleft"><input type="checkbox" name="smokingHabits[]" value="'.$key.'"  id="smokingHabits" '.$varChecked.' onClick="smokingHabitschk(2);"><font class="smalltxt" style="padding-left: 10px;">'.$value.'</font></div>';
					}?>
					<!--<input type=radio name=smokingHabits value='0'<?if($varSmokeStatus == 0){ echo "checked";}?>><font class='smalltxt'>Doesn't matter &nbsp; &nbsp;</font>
					<? foreach($arrSmokeList as $key=>$value){
						$varChecked = ($key == $varSmokeStatus)?'checked':'';
						echo '<input type="radio" name=smokingHabits value="'.$key.'"  id="smokingHabits'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 25px;">'.$value.'</font>';
					}?>-->
				</div><br clear="all"/>

				<div class="smalltxt fleft tlright srchdivlt">Drinking</div>
				<div class="fleft tlleft" style="padding:5px 0px 5px 5px;width:420px;">
				<div style="width:130px;" class="fleft"><input type="checkbox" name="drinkingHabits[]" id="drinkingHabits" value='0'<?if(in_array(0,$varDrinkStatus)){ echo "checked";}?> onClick="drinkingHabitschk(1);"><font class='smalltxt' style="padding-left:10px;">Doesn't matter &nbsp; &nbsp;</font></div>
					<? foreach($arrDrinkList as $key=>$value){
						$varChecked = (in_array($key,$varDrinkStatus))?'checked':'';
						echo '<div style="width:130px;" class="fleft"><input type="checkbox" name="drinkingHabits[]" value="'.$key.'"  id="drinkingHabits" '.$varChecked.' onClick="drinkingHabitschk(2);"><font class="smalltxt" style="padding-left:10px;">'.$value.'</font></div>';
					}?>
					<!--<input type=radio name=drinkingHabits value='0'<?if($varDrinkStatus == 0){ echo "checked";}?>><font class='smalltxt'>Doesn't matter &nbsp; &nbsp;</font>
					<? foreach($arrDrinkList as $key=>$value){
						$varChecked = ($key == $varDrinkStatus)?'checked':'';
						echo '<input type="radio" name=drinkingHabits value="'.$key.'"  id="drinkingHabits'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 25px;">'.$value.'</font>';
					}?>-->
				</div><br clear="all"/>
				
				
				<div id="inddiv">
				<div class="srchdivlt smalltxt fleft tlright">Annual Income</div>
				<div class="srchdivlt1 smalltxt fleft" id="incomeList" style="padding-left:5px;">
					<select name="FROMINCOME" id="FROMINCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onchange="return annualincomevalidation();">
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEINRHASH, "", "", $varStIncome);?></select>
				</div>
				<div class="srchdivlt1 smalltxt fleft" id="annualincometo" style="padding-left:40px;">
					<select name="TOINCOME" id="TOINCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onblur="return amountrange();" >
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEINRHASH, "", "", $varEndIncome);?></select><br><span id="stincome" class="errortxt"></span>
				</div>
				</div>
			  
				<div id="otherdiv" style="display:none">
				<div class="srchdivlt smalltxt fleft tlright">Annual Income</div>
				<div class="srchdivlt1 smalltxt fleft" id="incomeusList" style="padding-left:5px;">
					<select name="FROMUSCOME" id="FROMUSCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onchange="return annualincomevalidation();">
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEDOLLARHASH, "", "",$varStIncome);?></select>
				</div>
				<div class="srchdivlt1 smalltxt fleft" id="annualuscometo" style="display:none;padding-left:40px;">
					<select name="TOUSCOME" id="TOUSCOME" tabindex="<?=$varTabIndex++?>" class="inputtext" style="width:180px" onblur="return amountrange();">
					<?=$objCommon->getValuesFromArray($ANNUALINCOMEDOLLARHASH, "", "", $varEndIncome);?></select><br><span id="stuscome" class="errortxt"></span>
				</div>
				</div>
				
				<br clear="all"/>

				
			<div class="normtxt fleft tlright srchdivlt bld">Few lines about my partner</div>
				<div class="fleft pfdivrt tlleft" ><textarea style="resize:none;" class="tareareg" name="partnerDescription"><?=$varMemberInfo['Partner_Description']?></textarea><br />
				</div><br clear="all">				

				<div class="tlright padr20 padt10">
					<input type="submit" class="button" value="Save"> &nbsp;
					<input type="reset" class="button" value="Reset">
				</div><br clear="all"><br>
				</form>
				<? } ?>
			</div>
		</center>
<script>
function maritalstpartner(status){
    var frmProfile = document.frmProfile;

	if(status==1){
	var i;
		if (frmProfile.lookingStatus[0].checked) {		
			for(i=1; i<=mstatuscnt; i++) {
				frmProfile.lookingStatus[i].checked=false;
			}
		}
    }else{
		frmProfile.lookingStatus[0].checked=false;
	}
}
function eatingHabitschk(status){
    var frmProfile = document.frmProfile;

	if(status==1){
	var i;
		if (frmProfile.eatingHabits[0].checked) {		
			for(i=1; i<=4; i++) {
				frmProfile.eatingHabits[i].checked=false;
			}
		}
    }else{
		frmProfile.eatingHabits[0].checked=false;
	}
}
function smokingHabitschk(status){
    var frmProfile = document.frmProfile;

	if(status==1){
	var i;
		if (frmProfile.smokingHabits[0].checked) {		
			for(i=1; i<=3; i++) {
				frmProfile.smokingHabits[i].checked=false;
			}
		}
    }else{
		frmProfile.smokingHabits[0].checked=false;
	}
}
function drinkingHabitschk(status){
    var frmProfile = document.frmProfile;

	if(status==1){
	var i;
		if (frmProfile.drinkingHabits[0].checked) {		
			for(i=1; i<=3; i++) {
				frmProfile.drinkingHabits[i].checked=false;
			}
		}
    }else{
		frmProfile.drinkingHabits[0].checked=false;
	}
}
function GetAllValues(selobj){
  var myArray="";
  var numlen=selobj.options.length;
  for(var i=0; i<selobj.options.length; i++){
    myArray += selobj.options[i].value + "~";
  }
  myArray=myArray.substring(0,myArray.length-1);
  return myArray;
}

function changeincome() {
	var counval=document.getElementById('countryLivingIn');
    var arrCountry=new Array();
	for(var i=0; i<counval.options.length; i++){
		arrCountry[i]=counval.options[i].value;
   }      
	if(checkValueInArray(arrCountry,98) == true){
		document.getElementById('inddiv').style.display='block';
		document.getElementById('otherdiv').style.display='none';
		document.getElementById('indstate').style.display='block';
		document.getElementById('FROMINCOME').value='0';
		document.getElementById('annualincometo').style.display="none";
	} else {
		document.getElementById('inddiv').style.display='none';
		document.getElementById('otherdiv').style.display='block';
		document.getElementById('FROMUSCOME').value='0';
		document.getElementById('annualuscometo').style.display="none";
	}

	if(checkValueInArray(arrCountry,195) == true){
		document.getElementById('srilankastate').style.display='block';
	} else {
		document.getElementById('srilankastate').style.display='none';
	}

	if(checkValueInArray(arrCountry,162) == true){
		document.getElementById('pakistanstate').style.display='block';
	} else {
		document.getElementById('pakistanstate').style.display='none';
	}

	if(checkValueInArray(arrCountry,222) == true)
		document.getElementById('usstate').style.display='block';
}

function change_state1(){
	var counval=document.getElementById('countryLivingIn');
	var counvalindex=counval.selectedIndex;
	
	if($("countryLivingIn").options[counvalindex].value==98){
		document.getElementById('indstate').style.display='none';
		document.getElementById('cityEditInterList').style.display='none';
	}
	if($("countryLivingIn").options[counvalindex].value==222){
		document.getElementById('usstate').style.display='none';
	}
	if($("countryLivingIn").options[counvalindex].value==162){
		document.getElementById('pakistanstate').style.display='none';
		document.getElementById('cityPakistanList').style.display='none';
	}
}
 
function change_citycount(){
	  var citycount1=document.getElementById('residingIndia');
	  var residingcount1=citycount1.options.length;
	  var statevalindex=citycount1.selectedIndex;
	  
	  if((residingcount1 > 0)&& ($("residingIndia").options[statevalindex].value!=0)){
            document.getElementById('cityEditInterList').style.display='block';           
	  }else {
            document.getElementById('cityEditInterList').style.display='none';
       }
}

function change_citycount1(){
	  var citycount1=document.getElementById('residingPakistan');
	  var residingcount1=citycount1.options.length;
	  var statevalindex=citycount1.selectedIndex;
	  
	  if((residingcount1 > 0)&& ($("residingPakistan").options[statevalindex].value!=0)){
            document.getElementById('cityPakistanList').style.display='block';           
	  }else {
            document.getElementById('cityPakistanList').style.display='none';
       }
}

function changeincomedefault(StIncome,EndIncome) {	
	var ind_annual_notin=new Array(0,1,29);
	var us_annual_notin=new Array(0,1,16);	
	var counval=document.getElementById('countryLivingIn');
	var arrCountry=new Array();
	for(var i=0; i<counval.options.length; i++){
		arrCountry[i]=counval.options[i].value;
	}

	if(checkValueInArray(arrCountry,98) == true){
		document.getElementById('otherdiv').style.display='none';
		document.getElementById('inddiv').style.display='block';
		document.getElementById('FROMINCOME').value = StIncome;
		document.getElementById('TOINCOME').value = EndIncome;
		document.getElementById('annualincometo').style.display="block";		
	} else {
		document.getElementById('inddiv').style.display='none';
		document.getElementById('otherdiv').style.display='block';
		document.getElementById('FROMUSCOME').value = StIncome;
		document.getElementById('TOUSCOME').value = EndIncome;
		document.getElementById('annualuscometo').style.display="block";		
	}
	if(checkValueInArray(ind_annual_notin,StIncome) == true){
		document.getElementById('TOINCOME').style.display="none";
	}
	if(checkValueInArray(us_annual_notin,StIncome) == true) {
		document.getElementById('TOUSCOME').style.display="none";
	}	
}
changeincomedefault('<?=$varStIncome;?>','<?=$varEndIncome;?>');

function partnerHaveChildnp()
{	
	for(var i=0; i < document.frmProfile.lookingStatus.length; i++){
	  if(document.frmProfile.lookingStatus[i].checked){
		 if(document.frmProfile.lookingStatus[i].value==1){
			 document.getElementById('hchild').style.display='none';
		 }
		 else{
			 document.getElementById('hchild').style.display='block';
		 }
      }
	}
}

function HaveChildnp(looking)
{	
	var looking_val = looking.split('~');	
	for (var i=0; i <looking_val.length; i++){
	   	 if(looking_val[i]==1){
			 document.getElementById('hchild').style.display='none';
		 }else{
			 document.getElementById('hchild').style.display='block';
		 }
	}	
}
HaveChildnp('<?=$varMemberInfo["Looking_Status"];?>');

var selectedCountries = '<?=$varMemberInfo["Country"];?>';
var selectedStates = '<?=$varMemberInfo["Resident_India_State"];?>';
var selectedPakistanStates = '<?=$varMemberInfo["Resident_Pakistan_State"];?>';

var arrCountry = selectedCountries.split('~');
if(checkValueInArray(arrCountry,98) == true)
document.getElementById('indstate').style.display='block';
else
document.getElementById('indstate').style.display='none';

if(checkValueInArray(arrCountry,222) == true)
document.getElementById('usstate').style.display='block';
else
document.getElementById('usstate').style.display='none';

if(checkValueInArray(arrCountry,195) == true)
document.getElementById('srilankastate').style.display='block';
else
document.getElementById('srilankastate').style.display='none';

if(checkValueInArray(arrCountry,162) == true)
document.getElementById('pakistanstate').style.display='block';
else
document.getElementById('pakistanstate').style.display='none';


if(selectedStates!=''&& selectedStates!=0 && checkValueInArray(arrCountry,98) == true) {	
	ajaxEditInterCityCall('<?=$confValues['SERVERURL']?>/register/regstatecity.php','<?=$varTabIndex?>','<?=$varResidentDistrictString?>');
}else{	
	document.getElementById('cityEditInterList').style.display='none';
}

if(selectedPakistanStates!=''&& selectedPakistanStates!=0 && checkValueInArray(arrCountry,162) == true) {	
	
	ajaxEditPakistanCityCall('<?=$confValues['SERVERURL']?>/register/country/regstatecity.php','<?=$varTabIndex?>','<?=$varResidentPakDistrictString?>');
} else {	
	document.getElementById('cityPakistanList').style.display='none';
}


function annualincomevalidation(){
  var ind_annual_notin=new Array(0,1,29);
  var us_annual_notin=new Array(0,1,16);
  var counval=GetAllValues(document.getElementById('countryLivingIn'));
  var stincomevals=document.getElementById('FROMINCOME').value;
  var stuscomevals=document.getElementById('FROMUSCOME').value;
  var array=new Array();
  var stat,showhide=0,hideshow=0;
  var RsFlag=0, iRightLen=$("countryLivingIn").length;
  for(i=0; i < iRightLen; i++){
    if($("countryLivingIn").options[i].value==98 || $("countryLivingIn").options[i].value==0)
      RsFlag=1;
  }
  if(RsFlag==1)
    stat=1;
  else
    stat=0;

  if(checkValueInArray(arrCountry,98) == true)
  
  if(counval==0){stat=1;}
  if(stat==1){
    array=ind_annual_notin;
  }else{
    array=us_annual_notin;
  }
  
  for(var i=0;i<array.length;i++){
	  if(checkValueInArray(ind_annual_notin,stincomevals) == true){
		   showhide=1;
	  }
	  if(checkValueInArray(us_annual_notin,stuscomevals) == true){
		   hideshow=1;
	  }
  }
 
  var countryarrr = new Array();
  var countryarrr = counval.split('~');
 
  if(checkValueInArray(countryarrr,98) == true){
	   if(showhide==1){
		document.getElementById('annualincometo').style.display="none";
		document.getElementById('TOINCOME').value=0;
	  }else{
		document.getElementById('annualincometo').style.display="block";
		document.getElementById('TOINCOME').style.display="block";
		document.getElementById('TOINCOME').value=0;
	  }
  }
  if(checkValueInArray(countryarrr,98) == false){
	  if(hideshow==1){
		document.getElementById('annualuscometo').style.display="none";	
		document.getElementById('TOUSCOME').value=0;
	  }else{		  
		document.getElementById('annualuscometo').style.display="block";
		document.getElementById('TOUSCOME').style.display="block";
		document.getElementById('TOUSCOME').value=0;
	  }
  }
  return false;
}
</script>