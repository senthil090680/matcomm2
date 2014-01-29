<?php
function getFacetingMoreContent($argEleName, $argArrVals, $argLbl, $argDivName, $argCofArr, $arrDispType, $argOldVal){
	global $arrFacetNotSpecified, $varImgsURL, $arrFaceting;
	if($argCofArr !=''){
	global $$argCofArr;
	$funConfArr = $$argCofArr;
	}
	
	//Getting old submitted values
	$arrOldVals = array();
	if($argOldVal!=''){
		if(preg_match("/~/", $argOldVal)){
			$arrOldVals = split('~', $argOldVal);
		}else{
			$arrOldVals[] = $argOldVal;
		}
	}

	$funMoreCont = '<form name="frmMoreFacet">';
	if($argDivName=='MoreAge'){
		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;">
                            <div style="padding-left: 15px;" class="dline">
                                <div class="wleft frmlabel bld clr normtxt1" style="height:25px;"><label>'.$argLbl.'</label></div>
                                <div class="smalltxt">
								 <input type="text" class="inputtext" maxlength="2" size="2" value="'.$arrOldVals[0].'" id="ageFrom" name="ageFrom">
								&nbsp;to&nbsp;
								<input type="text" class="inputtext" maxlength="2" size="2" value="'.$arrOldVals[1].'" id="ageTo" name="ageTo">&nbsp;Years
								<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span>
								</div>
                            </div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'separate\')" value="Submit" class="button"></div>
					</div>';
	}else if($argDivName=='MorePhysicalStatus'){
		$funMoreCont   .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;">
                            <div style="padding-left: 15px;" class="dline">
                                <div class="wleft frmlabel bld clr normtxt1" style="height:25px;"><label>'.$argLbl.'</label></div>
                                <div class="smalltxt">';
		$funPhyChkfl = 0;
		foreach($argArrVals as $funKey=>$funVal){
			if($funVal > 0){
			$funPhyChk = in_array($funKey, $arrOldVals) ? 'checked' : '';
			if($funPhyChkfl==0 && $funPhyChk!=''){$funPhyChkfl=1;}
			$funMoreCont   .= '<input type="radio" class="textfield" value="'.$funKey.'" id="physicalStatus" name="physicalStatus" '.$funPhyChk.'>'.$funConfArr[$funKey].' ('.$funVal.')';
			}
		}
		$funPhyChk = ($funPhyChkfl==0)? 'checked' : '';
		$funMoreCont   .= '<input type="radio" class="textfield" value="2" id="physicalStatus" name="physicalStatus" '.$funPhyChk.'>'.$funConfArr[2];
		$funMoreCont   .= '<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span>
								</div>
                            </div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'physicalChk\')" value="Submit" class="button"></div>
					</div>';
	}else if($argDivName=='MoreProfileType'){
		$funPhotoChk	= $arrOldVals[0]==1 ? 'checked' : '';
		$funHoroChk		= $arrOldVals[1]==1 ? 'checked' : '';
		$funMoreCont   .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;">
                            <div style="padding-left: 15px;" class="dline">
                                <div class="wleft frmlabel bld clr normtxt1" style="height:25px;"><label>'.$argLbl.'</label></div>
                                <div class="smalltxt">';
		if($argArrVals[0] > 0){
		$funMoreCont   .= '<input type="checkbox" class="textfield" value="1" id="photoOpt" name="photoOpt" '.$funPhotoChk.'>With Photo ('.$argArrVals[0].')&nbsp;&nbsp;';
		}
		if($argArrVals[1] > 0 && $arrFaceting['Star']==1){
		$funMoreCont   .= '<input type="checkbox" class="textfield" value="1" id="horoscopeOpt" name="horoscopeOpt" '.$funHoroChk.'>With Horoscope ('.$argArrVals[1].')';
		}
		$funMoreCont   .= '	<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span>
								</div>
                            </div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'profiletypechk\')" value="Submit" class="button"></div>
					</div>';

	}else if($argDivName=='MoreActive'){
		$funActiveTxt = array('Members are currently online now', 'Members have been active the last one week', 'Members have been active the last one month', 'Members have been active for more than a month');
		$funMoreCont   .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;">
                            <div style="padding-left: 15px;" class="dline">
                                <div class="wleft frmlabel bld clr normtxt1" style="height:25px;"><label>'.$argLbl.'</label></div>
                                <div class="smalltxt">';
		foreach($argArrVals as $funKey=>$funVal){
			if($funVal > 0){
			$funMoreCont   .= '<input type="radio" class="textfield" value="'.$funKey.'" id="activeOpt" name="activeOpt" '.$funPhotoChk.'>'.$funActiveTxt[$funKey].' ('.$funVal.')<br clear="all">';
			}
		}

		$funMoreCont   .= '<span id="'.$argEleName.'err" class="errortxt"></span>
								</div>
                            </div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'activeChk\')" value="Submit" class="button"></div>
					</div><br clear="all"><div class="opttxt" style="padding-left:13px;">Note: There maybe a slight difference in the members online count as members keep logging on and off.</div>';

	}else if($argDivName=='MoreHeight'){
		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;"><div style="padding-left: 15px;" class="dline"><div class="wleft frmlabel bld normtxt1 clr" style="height:25px;"><label>'.$argLbl.'</label></div><div class="smalltxt"><select name="heightFrom" id="heightFrom" class="srchselect1">';
		foreach($funConfArr as $key=>$val){
			if($key==$arrOldVals[0])
				$funMoreCont .= '<option value="'.$key.'" selected>'.$val.'</option>';
			else
				$funMoreCont .= '<option value="'.$key.'">'.$val.'</option>';
		}
		$funMoreCont .= '</select>&nbsp;to&nbsp;<select name="heightTo" id="heightTo" class="srchselect1">';
		foreach($funConfArr as $key=>$val){
			if($key==$arrOldVals[1])
				$funMoreCont .= '<option value="'.$key.'" selected>'.$val.'</option>';
			else
				$funMoreCont .= '<option value="'.$key.'">'.$val.'</option>';
		}
		$funMoreCont .= '</select><br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span></div></div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'separate\')" value="Submit" class="button"></div>
					</div>';
	}else if($argDivName=='MoreAnnualIncome'){
		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;"><div style="padding-left: 15px;" class="dline"><div class="wleft frmlabel bld normtxt1 clr" style="height:25px;"><label>'.$argLbl.'</label></div><div class="smalltxt"><div class="fleft" id="ann"><select name="annualIncome" id="annualIncome" class="srchselect1" onchange="faceannuIncome(\'frmMoreFacet\', \'\')">';
		$arrOldVals[0] = $arrOldVals[0]>0 ? $arrOldVals[0] : 1;
		$arrOldVals[1] = $arrOldVals[1]>0 ? $arrOldVals[1] : 3;
		foreach($funConfArr as $key=>$val){
			if($key==$arrOldVals[0])
				$funMoreCont .= '<option value="'.$key.'" selected>'.$val.'</option>';
			else
				$funMoreCont .= '<option value="'.$key.'">'.$val.'</option>';
		}
		$funMoreCont .= '</select></div><div id="ann1" class="fleft" style="display:block;">&nbsp;to&nbsp;<select name="annualIncome1" id="annualIncome1" class="srchselect1" onchange="faceannuIncome1(\'frmMoreFacet\')">';
		foreach($funConfArr as $key=>$val){
			if($key==$arrOldVals[1])
				$funMoreCont .= '<option value="'.$key.'" selected>'.$val.'</option>';
			else
				$funMoreCont .= '<option value="'.$key.'">'.$val.'</option>';
		}
		$funMoreCont .= '</select></div><br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span></div></div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'annualIncomeChk\')" value="Submit" class="button"></div>';
		$funMoreCont .= '<img src="'.$varImgsURL.'/trans.gif" width="1" height="1" onload="faceannuIncome(\'frmMoreFacet\', \'\')">';
		$funMoreCont .= '</div>';
	}else if($argDivName == 'MoreResidingCity'){
		global $residingCityStateMappingList, $arrCityStateMapping;

		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;"><div style="padding-left: 15px;" class="dline"><div class="wleft frmlabel normtxt1 clr bld" style="height:25px;"><label>'.$argLbl.'</label></div><div class="smalltxt"><div class="fleft"><select id="'.$argEleName.'Temp" name="'.$argEleName.'Temp" class="srchselect1" size="5" multiple ondblclick="moveOptions(this.form.'.$argEleName.'Temp, this.form.'.$argEleName.')">';
		$funOppSelected = '';
		foreach($argArrVals as $key=>$cnt){
			$varCurrStateName = $residingCityStateMappingList{$arrCityStateMapping[$key]};
			global $$varCurrStateName;
			$arrCurrState = $$varCurrStateName;
			$varOptionLbl = $arrCurrState[$key]!='' ? $arrCurrState[$key] : '';
			$varOptionVal = $arrCityStateMapping[$key].'#'.$key;
			if($varOptionLbl != ''){
				if(in_array($varOptionVal, $arrOldVals)){
				$funOppSelected .= '<option value="'.$varOptionVal.'">'.$varOptionLbl.' ('.$cnt.')</option>';
				}else{
				$funMoreCont .= '<option value="'.$varOptionVal.'">'.$varOptionLbl.' ('.$cnt.')</option>';
				}
			}
		}
		$funMoreCont .= '</select></div><div class="fleft" style="margin-left:5px;margin-right:5px;margin-top:18px;"><input type="button" onclick="moveOptions(this.form.'.$argEleName.'Temp, this.form.'.$argEleName.')" class="button" value=" &gt; "><br><img width="1" height="5" src="http://img.muslimmatrimony.com/images/trans.gif"><br><input type="button" onclick="moveOptions(this.form.'.$argEleName.', this.form.'.$argEleName.'Temp)" class="button" value=" &lt; "></div><div class="fleft"><select name="'.$argEleName.'" id="'.$argEleName.'" class="srchselect1" size="5" ondblclick="moveOptions(this.form.'.$argEleName.', this.form.'.$argEleName.'Temp)" multiple >'.$funOppSelected.'</select></div>';
		$funMoreCont .= '<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span></div></div>
						<div style="width:420px;float:left;margin-top:10px;"><div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'MultiSelectbox\')" value="Submit" class="button"></div></div>
					</div>';
	}else if($arrDispType == 'Selectbox'){
		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;"><div style="padding-left: 15px;" class="dline"><div class="wleft frmlabel normtxt1 clr bld" style="height:25px;"><label>'.$argLbl.'</label></div><div class="smalltxt"><select name="'.$argEleName.'" id="'.$argEleName.'" class="srchselect1">';
		foreach($argArrVals as $key=>$cnt){
			$funSelected = '';
			if(in_array($key, $arrOldVals)){$funSelected = 'selected';}
			$varOptionLbl	= $funConfArr[$key]!='' ? $funConfArr[$key] : '';	
			if($varOptionLbl != ''){
			$funMoreCont .= '<option value="'.$key.'" '.$funSelected.'>'.$varOptionLbl.' ('.$cnt.')</option>';
			}
		}
		$funMoreCont .= '</select>';
		$funMoreCont .= '<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span></div></div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'Selectbox\')" value="Submit" class="button"></div>
					</div>';
	}else if($arrDispType == 'MultiSelectbox'){
		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;"><div style="padding-left: 15px;" class="dline"><div class="wleft frmlabel normtxt1 clr bld" style="height:25px;"><label>'.$argLbl.'</label></div><div class="smalltxt"><div class="fleft"><select id="'.$argEleName.'Temp" name="'.$argEleName.'Temp" class="srchselect1" size="5" ondblclick="moveOptions(this.form.'.$argEleName.'Temp, this.form.'.$argEleName.')" multiple >';
		$funOppSelected = '';
		foreach($argArrVals as $key=>$cnt){
			$varOptionLbl	= $funConfArr[$key]!='' ? $funConfArr[$key] : '';
			if($varOptionLbl != ''){
				if(in_array($key, $arrOldVals)){
				$funOppSelected .= '<option value="'.$key.'">'.$varOptionLbl.' ('.$cnt.')</option>';
				}else{
				$funMoreCont .= '<option value="'.$key.'">'.$varOptionLbl.' ('.$cnt.')</option>';
				}
			}
		}
		$funMoreCont .= '</select></div><div class="fleft" style="display:inline;margin-left:5px;margin-right:5px;margin-top:18px;"><input type="button" onclick="moveOptions(this.form.'.$argEleName.'Temp, this.form.'.$argEleName.')" class="button" value=" &gt; "><br><img width="1" height="5" src="http://img.muslimmatrimony.com/images/trans.gif"><br><input type="button" onclick="moveOptions(this.form.'.$argEleName.', this.form.'.$argEleName.'Temp)" class="button" value=" &lt; "></div><div class="fleft"><select name="'.$argEleName.'" class="srchselect1" size="5" onclick="moveOptions(this.form.'.$argEleName.', this.form.'.$argEleName.'Temp)" multiple >'.$funOppSelected.'</select></div>';
		$funMoreCont .= '<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span></div></div>
						<div style="width:425px;float:left;"><div style="padding: 10px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'MultiSelectbox\')" value="Submit" class="button"></div></div>
					</div>';
	}else if($arrDispType == 'Checkbox'){
		ksort($argArrVals);
		$funMoreCont .= '<div id="'.$argDivName.'" style="padding: 0px 0px 15px;">
							<div style="padding-left: 15px;" class="dline"><div class="wleft frmlabel normtxt1 clr bld" style="height:25px;"><label>'.$argLbl.'</label></div>
								<div class="smalltxt">';
		$i= 1;
		foreach($argArrVals as $key=>$cnt){
			$funChecked = '';
			if(in_array($key, $arrOldVals)){$funChecked = 'checked';}
			$varOptionLbl	= ($funConfArr[$key]=='' && in_array($argEleName, $arrFacetNotSpecified)) ? 'Not specified' : $funConfArr[$key];
			if($varOptionLbl != ''){
			if($i==4){ $i=1; $funMoreCont .= '<br clear="all">';}
			$funMoreCont .= '<input type="checkbox" value="'.$key.'" class="textfield" id="'.$argEleName.'" name="'.$argEleName.'[]" '.$funChecked.'>'.$varOptionLbl.' ('.$cnt.')&nbsp;&nbsp;';
			$i++;
			}
		}
		$funMoreCont .= '<br clear="all"><span id="'.$argEleName.'err" class="errortxt"></span></div></div>
						<div style="padding: 3px 20px 10px 0px;" class="fright"><input type="button" onclick="moreSubmit(\''.$argEleName.'\',\'Checkbox\')" value="Submit" class="button"></div>
		</div></form>';

	}
	return $funMoreCont;
}
?>