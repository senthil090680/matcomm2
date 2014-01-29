<?php
#================================================================================================================
# Author 	: Dhanapal
# Date		: 08-June-2009
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
#================================================================================================================

//FILE INCLUDES
$varServerRoot		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varServerRoot);
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath."/conf/cityarray.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsSearch.php');

//VARIABLE DECLARATION
$varCountry	= trim($_REQUEST['country']);
$varState	= trim($_REQUEST['state']);
$varDisplay	= trim($_REQUEST['display']);
$varTabIndex= trim($_REQUEST['tabIndex']);
$varSelectedCity = trim($_REQUEST['selectedCity']);


//OBJECT DECLARTION
$objCommon	= new clsCommon;
$objSearch	= new Search;

//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function getValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue)
	{
		$funOptions	="";
		if($argNullOptionName !="")
		{ 
			$funSelectedItem = ($argSelectedValue=='' || $argSelectedValue == '0') ? "selected" : "";
			$funOptions .= '<option value="'.$argNullOptionValue.'" '.$funSelectedItem.'>'.$argNullOptionName.'</option>'; 
		}//if
		foreach($argArrName as $funIndex => $funValues)
		{
			$funSelectedItem = ($argSelectedValue!='' && $argSelectedValue==$funIndex) ? "selected" : "";
			$funOptions .= '<option value="'.$funIndex.'" '.$funSelectedItem.'>'.$funValues.'</option>';
		}//for

		echo $funOptions;

	}

if ($varCountry!="" && $varDisplay == 'state') {
	$varStateList = '';

	if (($varCountry == "98")||($varCountry == "222")) {

		if($varCountry == "98") {
			$stateList = $arrResidingStateList; 
			$varStateList .= "<select class=\"srchselect\" name=\"residingState\" size=\"1\" tabindex=\"".$varTabIndex++."\" onChange=\"ajaxCityCall('".$confValues['SERVERURL']."/register/regstatecity.php','".$varTabIndex."');residingstateChk();\" onblur=\"residingstateChk();\"><option value=\"0\">--- Select ---</option>";
			
		}
		elseif($varCountry == "222") { 
			$stateList = $arrUSAStateList;
			$varStateList .= "<select class=\"srchselect\" name=\"residingState\" size=\"1\" tabindex=\"".$varTabIndex++."\" onChange=\"residingstateChk();\" onblur=\"residingstateChk();\"><option value=\"0\">--- Select ---</option>";
		}
		
		asort($stateList);
		foreach($stateList as $varIndex => $varValue) {
			$varStateList .= '<option value="'.$varIndex.'" '.$funSelectedItem.'>'.$varValue.'</option>';
		}//for
		$varStateList .= '</select><br><!-- Email Bubble out div--><div id="embubdiv" style="z-index:1001;margin-left:215px;display:none;"><span class="posabs" style="width:153px;height:62px;background:url(\'http://img.communitymatrimony.com/images/email_img.gif\') no-repeat;padding-top:1px;padding-left:21px;"><span class="smalltxt clr3 tlleft" style="width:120px;padding-left:2px;">Will not be revealed to members. It is purely for<br> helping us communicate<br> with you.</span></span></div><!-- Email Bubble out div--><span id="residingstatespan" class="errortxt"></span>';

	} else {

		$varStateList .= '<input type="text" class="inputtext" name="residingState" size="37" tabindex=\"'.$varTabIndex++.'\" maxlength="40" value="" onblur="residingstateChk();"><br><!-- Email Bubble out div--><div id="embubdiv" style="z-index:1001;margin-left:215px;display:none;"><span class="posabs" style="width:153px;height:62px;background:url(\'http://img.communitymatrimony.com/images/email_img.gif\') no-repeat;padding-top:1px;padding-left:21px;"><span class="smalltxt clr3 tlleft" style="width:120px;padding-left:2px;">Will not be revealed to members. It is purely for<br> helping us communicate<br> with you.</span></span></div><!-- Email Bubble out div--><span id="residingstatespan" class="errortxt"></span>';
		
		//&nbsp;&nbsp;<font class="normaltxt1"><font color="#FF6600"></font></font>';
	}
	echo $varStateList;
}

if ($varDisplay == 'city') {

	if ($varCountry == "98") { 
		$stateList = $$residingCityStateMappingList[$varState];
		asort($stateList);
		$varTabIndex++;
		$varCityList	.= '<select name="residingCity" size="1" tabindex="'.$varTabIndex++.'" class="srchselect"  onBlur="residingcityChk();"><option value="0">--- Select ---</option>';
		foreach($stateList as $varIndex => $varValue) {
			$varCityList .= '<option value="'.$varIndex.'" '.$funSelectedItem.'>'.$varValue.'</option>';
		}//for
		$varCityList	.= '</select><br><span id="residingcityspan" class="errortxt"></span>';

	} else {

		$varCityList	.= '<input type="text" class="inputtext" name="residingCity" tabindex="'.$varTabIndex++.'" id="residingCity" size="37" maxlength="40" onBlur="residingcityChk();"><br><span id="residingcityspan" class="errortxt"></span>';
	}

	echo $varCityList;
}
if ($varDisplay == 'cityinter') {	
	 $tilted=explode('~',$varState);
     $stateList=array();		
     foreach($tilted as $value){
		$stateList = $stateList + $$residingCityStateMappingList[$value];
	 }
		
echo '<div class="srchdivlt smalltxt fleft tlright">Residing India City</div><div class="srchdivrt smalltxt fleft"><div class="fleft"><select class="srchselect" id="residingCityTemp" name="residingCityTemp[]" ondblclick="moveOptions(this.form.residingCityTemp, this.form.residingCity)" size="4" multiple tabindex="'.$varTabIndex++.'">';
getValuesFromArray($stateList, "Select residing India City", "0", "");
echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(this.form.residingCityTemp, this.form.residingCity)"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(this.form.residingCity, this.form.residingCityTemp)"></div><div class="fleft"><select class="srchselect" size="4" multiple id="residingCity" name="residingCity[]" tabindex="11" ondblclick="moveOptions(this.form.residingCity, this.form.residingCityTemp)"></select></div><br clear="all"><font class=\'opttxt\'>Hold CTRL key to select multiple items.</font></div>';
}

if ($varDisplay == 'cityeditinter') {	
	 $tilted=explode('~',$varState);
     $stateList=array();		
     foreach($tilted as $value){
	 $stateList = $stateList + $$residingCityStateMappingList[$value];
	 }		

echo '<div class="srchdivlt smalltxt fleft tlright">Residing India City</div><div class="srchdivrt smalltxt fleft"><div class="fleft"><select class="srchselect" id="residingCityTemp" name="residingCityTemp[]" ondblclick="moveOptions(document.getElementById(\'residingCityTemp\'), document.getElementById(\'residingCity\'));fnAnyChk(document.frmProfile.residingCityTemp,document.frmProfile.residingCity);" size="4" multiple tabindex="'.$varTabIndex++.'">';
getValuesFromArray($stateList, "Any", "0", "");
echo '</select></div><div class="fleft padlr10 padt5"><input type="button" value=" > " class="button" onclick="moveOptions(document.getElementById(\'residingCityTemp\'), document.getElementById(\'residingCity\'));fnAnyChk(document.frmProfile.residingCityTemp,document.frmProfile.residingCity);"><br><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="5" /><br><input type="button" value=" < " class="button" onclick="moveOptions(document.getElementById(\'residingCity\'), document.getElementById(\'residingCityTemp\'));"></div><div class="fleft"><select class="srchselect" size="4" multiple id="residingCity" name="residingCity[]" tabindex="11" ondblclick="moveOptions(this, document.getElementById(\'residingCityTemp\'));">';

echo $objSearch->getOpionalValues($varSelectedCity, $stateList);

echo'</select></div><br clear="all"><font class=\'opttxt fleft\'>Hold CTRL key to select multiple items.</font></div>';
} 
?>