<?php
#=====================================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-02
# Project	  : MatrimonyProduct
# Filename	  : familyinfodesc.php
#=====================================================================================================================================
# Description : display information of family info. It has family info form and update function family information.
#=====================================================================================================================================
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/tblfields.inc');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];

//OBJECT DECLARTION
$objDBSlave	= new MemcacheDB;
$objCommon	= new clsCommon;
$objDomain	= new domainInfo;

//CONNECT DATABASE
$objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//Domain Related information
$varReligiousFeature	= $objDomain->useReligiousValues();
$varEthnicityFeature	= $objDomain->useEthnicity();

//VARIABLE DECLARATION
$varUpdatePrimary	= $_REQUEST['familyinfosubmit'];

// Array for showing religious value option 
$varReligiosValueforReligion = array("2","10","11","20","21","22","23");

if($varUpdatePrimary == 'yes') {
	$objDBMaster = new MemcacheDB;
	$objDBMaster->dbConnect('M',$varDbInfo['DATABASE']);

	$varEditedReligiousValues	= $_REQUEST["religiousvalues"];
	$varEditedEthnicity			= $_REQUEST["ethnicity"];

	$varEditedFamilyValue		= $_REQUEST["familyValue"];
	$varEditedFamilyType		= $_REQUEST["familyType"];
	$varEditedFamilyStatus		= $_REQUEST["familyStatus"];
	$varEditedFatherOccupation	= addslashes(strip_tags(trim($_REQUEST["fatherOccupation"])));
	$varEditedMotherOccupation	= addslashes(strip_tags(trim($_REQUEST["motherOccupation"])));
	$varEditedFamilyOrigin		= addslashes(strip_tags(trim($_REQUEST["ancestralOrigin"])));
	$varEditedBrothers			= $_REQUEST["brothers"];
	$varEditedMarriedBrothers	= $_REQUEST["marriedBrothers"];
	$varEditedSisters			= $_REQUEST["sisters"];
	$varEditedMarriedSisters	= $_REQUEST["marriedSisters"];
	$varEditedFamilyDescription = addslashes(strip_tags(trim($_REQUEST["familyDescription"])));

	if($sessMatriId != '')
	{
		//find member has family info or not
		$argFields				= array('MatriId');
		$argCondition			= "WHERE MatriId='".$sessMatriId."'";
		$varChkMemberResultSet	= $objDBSlave->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
		$varChkMemberInfo		= mysql_fetch_array($varChkMemberResultSet);

		if($varChkMemberInfo['MatriId'] == '')
		{
			$argFields 			= array('MatriId');
			$argFieldsValues	= array("'".$sessMatriId."'");
			$varInsertedId		= $objDBMaster->insert($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues);
		}

		//Direct updatation for array field
		$argFields 			= array('Family_Value','Family_Type','Family_Status','Brothers','Brothers_Married','Sisters','Sisters_Married','Date_Updated');
		$argFieldsValues	= array("'".$varEditedFamilyValue."'","'".$varEditedFamilyType."'","'".$varEditedFamilyStatus."'","'".$varEditedBrothers."'","'".$varEditedMarriedBrothers."'","'".$varEditedSisters."'","'".$varEditedMarriedSisters."'",'NOW()');
		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues,$argCondition);

		$argFields 			= array('Family_Set_Status','Religious_Values','Ethnicity');
		$argFieldsValues	= array(1,"'".$varEditedReligiousValues."'","'".$varEditedEthnicity."'");
		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		// NOT VALIDATED MEMBER COMMIT OTHER DETAILS DIRECTLY
		if($sessPublish == 0 || $sessPublish == 4) 
		{
			$argFields 			= array('Father_Occupation','Mother_Occupation','Family_Origin','About_Family');
			$argFieldsValues	= array("'".$varEditedFatherOccupation."'","'".$varEditedMotherOccupation."'","'".$varEditedFamilyOrigin."'","'".$varEditedFamilyDescription."'");
			$argCondition		= "MatriId = '".$sessMatriId."'";
			$varUpdateId		= $objDBMaster->update($varTable['MEMBERFAMILYINFO'],$argFields,$argFieldsValues,$argCondition);

			if($sessPublish == 4) {
				$argFields		= array('Publish');
				$argFieldsValues= array('0');
				$varUpdateId	= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition);
			}
		}
		else
		{
			if(trim($_REQUEST['oldfatocc']) != trim($varEditedFatherOccupation) || trim($_REQUEST['oldmotocc']) != trim($varEditedMotherOccupation) || trim($_REQUEST['oldorigin']) != trim($varEditedFamilyOrigin) || trim($_REQUEST['oldmyfamily']) != trim($varEditedFamilyDescription)) 
			{
				$argFields 			= array('MatriId');
				$argFieldsValues	= array("'".$sessMatriId."'");
				$varInsertedId		= $objDBMaster->insertIgnore($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues);

				$argFields 			= array('Date_Updated');
				$argFieldsValues	= array('NOW()');

				if(trim($_REQUEST['oldfatocc']) != $varEditedFatherOccupation) {
					array_push($argFields,'Father_Occupation');
					array_push($argFieldsValues,"'".$varEditedFatherOccupation."'");
				}

				if(trim($_REQUEST['oldmotocc']) != $varEditedMotherOccupation) {
					array_push($argFields,'Mother_Occupation');
					array_push($argFieldsValues,"'".$varEditedMotherOccupation."'");
				}

				if(trim($_REQUEST['oldorigin']) != $varEditedFamilyOrigin) {
					array_push($argFields,'Family_Origin');
					array_push($argFieldsValues,"'".$varEditedFamilyOrigin."'");
				}

				if(trim($_REQUEST['oldmyfamily']) != $varEditedFamilyDescription) {
					array_push($argFields,'About_Family');
					array_push($argFieldsValues,"'".$varEditedFamilyDescription."'");
				}
				
				$argCondition		= "MatriId = '".$sessMatriId."'";
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERUPDATEDINFO'],$argFields,$argFieldsValues,$argCondition);

				$argFields 			= array('Pending_Modify_Validation','Family_Set_Status');
				$argFieldsValues	= array(1,1);
				$argCondition		= "MatriId = '".$sessMatriId."'";
				$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);
			}
		}

		$argFields 			= array('Date_Updated','Time_Posted');
		$argFieldsValues	= array('NOW()','NOW()');
		$argCondition		= "MatriId = '".$sessMatriId."'";
		$varUpdateId		= $objDBMaster->update($varTable['MEMBERINFO'],$argFields,$argFieldsValues,$argCondition,$varOwnProfileMCKey);

		$objDBMaster	->dbClose();
	}
} else {

	$argMemFields		= $arrMEMBERINFOfields;
	$argMemCondition	= "WHERE MatriId='".$sessMatriId."' AND ".$varWhereClause;
	$varMemberDetail	= $objDBSlave->select($varTable['MEMBERINFO'],$argMemFields,$argMemCondition,0,$varOwnProfileMCKey);

	$argFields						= array('Family_Value','Family_Type','Family_Status','Father_Occupation','Mother_Occupation','Family_Origin','Brothers','Brothers_Married','Sisters','Sisters_Married','About_Family');
	$argCondition					= "WHERE MatriId='".$sessMatriId."'";
	$varMemberFamilyInfoResultSet	= $objDBSlave->select($varTable['MEMBERFAMILYINFO'],$argFields,$argCondition,0);
	$varMemberInfo					= mysql_fetch_array($varMemberFamilyInfoResultSet);
}
$objDBSlave->dbClose();
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/familyinfo.js"></script>

	<? include_once('settingsheader.php');?><center>
	<div class="padt10" >
			<?if($varUpdatePrimary == 'yes') { ?>
			<div class='fleft' style='width:480px;'>
				Your family details have been modified successfully.
				<br><br><font class='errortxt'><b>Any text changes will have to be validated before it is updated on your profile. It usually takes 24 hours.</b></font>
			</div>
			<? } else { ?>
			<form method='post' name='frmProfile' onSubmit='return familyValidate()' style="padding:0px;margin:0px;">
			<input type='hidden' name='act' value='familyinfodesc'>
			<input type='hidden' name='familyinfosubmit' value='yes'>
			<input type='hidden' name='oldfatocc' value='<?=trim($varMemberInfo['Father_Occupation'])?>'>
			<input type='hidden' name='oldmotocc' value='<?=trim($varMemberInfo['Mother_Occupation'])?>'>
			<input type='hidden' name='oldorigin' value='<?=trim($varMemberInfo['Family_Origin'])?>'>
			<input type='hidden' name='oldmyfamily' value='<?=trim($varMemberInfo['About_Family'])?>'>
			<input type="hidden" name="religiousfeature" value="<?=$varReligiousFeature?>">
			<input type="hidden" name="ethnicityfeature" value="<?=$varEthnicityFeature?>">

		<div class="fright opttxt"><span class="clr3">*</span> Mandatory</div><br clear="all">

			<div class="smalltxt fleft tlright pfdivlt" >Family Value<span class="clr3">*</span></div>
			<div class="fleft pfdivrt tlleft">
				<? foreach($arrFamilyValuesList as $key=>$value){
					$varChecked = ($key == $varMemberInfo['Family_Value'])?'checked':'';
					echo '<input type="radio" class="frmelements" name=familyValue value="'.$key.'"  id="familyValue'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
				}?><br><span id='familyvaluespan' class='errortxt'></span>
			</div><br clear="all"/>

			<div class="smalltxt fleft tlright pfdivlt" >Family Type<span class="clr3">*</span></div>
			<div class="fleft pfdivrt tlleft" >
				<? foreach($arrFamilyType as $key=>$value){
					$varChecked = ($key == $varMemberInfo['Family_Type'])?'checked':'';
					echo '<input type="radio" class="frmelements" name=familyType value="'.$key.'"  id="familyType'.$key.'" '.$varChecked.'><font class="smalltxt" style="padding-right: 10px;">'.$value.'</font>';
				}?>
			</div><span id='familytypespan' class='errortxt'></span><br><br clear="all"/>

			<div class="pfdivlt smalltxt fleft tlright">Family Status<font class="clr3">*&nbsp;</font></div>
			<div class="pfdivrt smalltxt fleft tlleft">
				<select name="familyStatus" tabindex="<?=$varTabIndex++?>" class="srchselect" onblur="ChkEmpty(familyStatus, 'select','familystatusspan','Please select the family status of the prospect');">
				<?=$objCommon->getValuesFromArray($arrFamilyStatus, "--- Select ---", "0", $varMemberInfo['Family_Status']);?>
				</select><br><span id="familystatusspan" class="errortxt"></span></div><br clear="all"/>
			
			<div class="smalltxt fleft tlright pfdivlt" >Ancestral / Family Origin</div>
			<div class="fleft pfdivrt tlleft" >
				<input type=text name=ancestralOrigin size=32 maxlength=40 class='inputtext' value='<?=$varMemberInfo['Family_Origin']?>'>
			</div><br clear="all"/>
             
			
          
			<? if(in_array($varMemberDetail['Religion'], $varReligiosValueforReligion)){
		    
			if($varReligiousFeature) { 
				$arrRetReligiousValues	= $objDomain->getReligiousValuesOption();
				$varSizeReligiousValues	= sizeof($arrRetReligiousValues);
				?>
				<input type="hidden" name="religioustxtfeature" value="<?=$varSizeReligiousValues;?>">
				<?
				if($varSizeReligiousValues==1) {?>
					<input type="hidden" name="religiousvalues" value="<?=key($arrRetReligiousValues)?>">
				<?} else {?>
					<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getReligiousValuesLabel()?></div>
					<div class="fleft pfdivrt tlleft">
						<select name='religiousvalues' class='srchselect'>
						
							<?=$objCommon->getValuesFromArray($arrRetReligiousValues, "- Select -", "0", $varMemberDetail['Religious_Values']);?>
						</select>
						<br><span id="religiousspan" class="errortxt"></span>
					</div><br clear="all"/>
				<? } 
			}  } ?>

			<?if($varEthnicityFeature) { 
				$arrRetEthnicity	= $objDomain->getEthnicityOption();
				$varSizeEthnicity	= sizeof($arrRetEthnicity);
				?>
				<input type="hidden" name="ethnicitytxtfeature" value="<?=$varSizeEthnicity;?>">
				<?
				if($varSizeEthnicity==1) {?>
					<input type="hidden" name="ethnicity" value="<?=key($arrRetEthnicity)?>">
				<?} else {?>
					<div class="smalltxt fleft tlright pfdivlt" ><?=$objDomain->getEthnicityLabel()?></div>
					<div class="fleft pfdivrt tlleft">
						<select name='ethnicity' class='srchselect'>
							<?=$objCommon->getValuesFromArray($arrRetEthnicity, "- Select -", "0", $varMemberDetail['Ethnicity']);?>
						</select>
						<br><span id="ethnicityspan" class="errortxt"></span>
					</div><br clear="all"/>
				<? } 
			} ?>

			<div class="smalltxt fleft tlright pfdivlt" >Mother's Occupation</div>
			<div class="fleft pfdivrt tlleft" >
				<input type=text name=motherOccupation size=32 maxlength=40 class='inputtext' value='<?=$varMemberInfo['Mother_Occupation']?>'>
			</div><br clear="all"/>
			
			<div class="smalltxt fleft tlright pfdivlt"  >Father's Occupation</div>
			<div class="fleft pfdivrt tlleft" >
				<input type=text name=fatherOccupation size=32 maxlength=40 class='inputtext' value='<?=$varMemberInfo['Father_Occupation']?>'>
			</div><br clear="all"/>

			<!-- <div class="smalltxt  fleft tlright" >No. of Siblings</div>
			<div class="fleft  " >&nbsp;<select size="1"  name="" class="smalltxt select1"><option selected="" value="0">--Select--</option></select></div><br clear="all"/> -->

			<div class="smalltxt fleft tlright pfdivlt" >No. of Brothers</div>
			<div class="fleft pfdivrt tlleft" >
				<select class='inputtext' NAME='brothers' size='1'>
					<option value=0 <?=$varMemberInfo['Brothers'] == 0 ? 'selected' : '';?>>- Select -</option>
					<option value=1 <?=$varMemberInfo['Brothers'] == 1 ? 'selected' : '';?>>1</option>
					<option value=2 <?=$varMemberInfo['Brothers'] == 2 ? 'selected' : '';?>>2</option>
					<option value=3 <?=$varMemberInfo['Brothers'] == 3 ? 'selected' : '';?>>3</option>
					<option value=4 <?=$varMemberInfo['Brothers'] == 4 ? 'selected' : '';?>>4</option>
					<option value=5 <?=$varMemberInfo['Brothers'] == 5 ? 'selected' : '';?>>5</option>
					<option value=6 <?=$varMemberInfo['Brothers'] == 6 ? 'selected' : '';?>>6</option>
				</select>
			</div><span id='brothersspan' class='errortxt'></span><br>	<br clear="all"/>

			<div class="smalltxt fleft tlright pfdivlt" >Brothers Married</div>
			<div class="fleft pfdivrt tlleft" >
				<select class='inputtext' NAME='marriedBrothers' size='1'>
					<option value=0 <?=$varMemberInfo['Brothers_Married'] == 0 ? 'selected' : '';?>>- Select -</option>
					<option value=1 <?=$varMemberInfo['Brothers_Married'] == 1 ? 'selected' : '';?>>1</option>
					<option value=2 <?=$varMemberInfo['Brothers_Married'] == 2 ? 'selected' : '';?>>2</option>
					<option value=3 <?=$varMemberInfo['Brothers_Married'] == 3 ? 'selected' : '';?>>3</option>
					<option value=4 <?=$varMemberInfo['Brothers_Married'] == 4 ? 'selected' : '';?>>4</option>
					<option value=5 <?=$varMemberInfo['Brothers_Married'] == 5 ? 'selected' : '';?>>5</option>
					<option value=6 <?=$varMemberInfo['Brothers_Married'] == 6 ? 'selected' : '';?>>6</option>
				</select>
			</div><span id='marriedbrothersspan' class='errortxt'></span><br><br clear="all"/>

			<div class="smalltxt fleft tlright pfdivlt" >No. of Sisters</div>
			<div class="fleft pfdivrt tlleft" >
				<select class='inputtext' NAME='sisters' size='1'>
					<option value=0 <?=$varMemberInfo['Sisters'] == 0 ? 'selected' : '';?>>- Select -</option>
					<option value=1 <?=$varMemberInfo['Sisters'] == 1 ? 'selected' : '';?>>1</option>
					<option value=2 <?=$varMemberInfo['Sisters'] == 2 ? 'selected' : '';?>>2</option>
					<option value=3 <?=$varMemberInfo['Sisters'] == 3 ? 'selected' : '';?>>3</option>
					<option value=4 <?=$varMemberInfo['Sisters'] == 4 ? 'selected' : '';?>>4</option>
					<option value=5 <?=$varMemberInfo['Sisters'] == 5 ? 'selected' : '';?>>5</option>
					<option value=6 <?=$varMemberInfo['Sisters'] == 6 ? 'selected' : '';?>>6</option>
				</select>
			</div><span id='sistersspan' class='errortxt'></span><br><br clear="all"/>

			<div class="smalltxt fleft tlright pfdivlt" >Sisters Married</div>
			<div class="fleft pfdivrt tlleft" >
				<select class='inputtext' NAME='marriedSisters' size='1'>
					<option value=0 <?=$varMemberInfo['Sisters_Married'] == 0 ? 'selected' : '';?>>- Select -</option>
					<option value=1 <?=$varMemberInfo['Sisters_Married'] == 1 ? 'selected' : '';?>>1</option>
					<option value=2 <?=$varMemberInfo['Sisters_Married'] == 2 ? 'selected' : '';?>>2</option>
					<option value=3 <?=$varMemberInfo['Sisters_Married'] == 3 ? 'selected' : '';?>>3</option>
					<option value=4 <?=$varMemberInfo['Sisters_Married'] == 4 ? 'selected' : '';?>>4</option>
					<option value=5 <?=$varMemberInfo['Sisters_Married'] == 5 ? 'selected' : '';?>>5</option>
					<option value=6 <?=$varMemberInfo['Sisters_Married'] == 6 ? 'selected' : '';?>>6</option>
				</select>
			</div><span id='marriedsistersspan' class='errortxt'></span><br><br clear="all"/>

			<div class="smalltxt fleft tlright pfdivlt" >Few lines about my family</div>
			<div class="fleft pfdivrt tlleft"><div class="fleft"><textarea name="familyDescription" class='tareareg' style="width:200px;resize: none;"><?=$varMemberInfo['About_Family']?></textarea></div>
			<div class="fleft opttxt pad3 lh13" style="width:140px;">Use this space to talk about your parents and siblings.</div>
			</div>
			<br clear="all"/>		

			<div class="tlright padr20 padt10">
			<input type="submit" class="button" value="Save"> &nbsp; <input type="reset" class="button" value="Reset"></div>
			<? } ?>
		</div><br>
</center>