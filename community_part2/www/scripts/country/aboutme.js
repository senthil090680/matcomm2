function HaveChildnp(){
  var frmProfile=document.frmProfile;
  var marSt = frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value;
  var childLW = frmProfile.noOfChildren.options[frmProfile.noOfChildren.selectedIndex].value;
  if(childLW > 0){ if(marSt == 1){
    if ( (frmProfile.childLivingWithMe[0].checked || frmProfile.childLivingWithMe[1].checked) && (!frmProfile.childLivingWithMe[0].checked || !frmProfile.childLivingWithMe[1].checked) ){
      frmProfile.childLivingWithMe[0].checked=false;frmProfile.childLivingWithMe[1].checked=false;
      frmProfile.childLivingWithMe[0].disabled=true;frmProfile.childLivingWithMe[1].disabled=true;
    }
  }}
  if(marSt == 1){
  frmProfile.noOfChildren.disabled=true;frmProfile.childLivingWithMe[0].disabled=true;
  frmProfile.childLivingWithMe[1].disabled=true;
    }else if ( marSt > 1){
    frmProfile.noOfChildren.disabled=false;
    frmProfile.childLivingWithMe[0].disabled=false;frmProfile.childLivingWithMe[1].disabled=false;
  }
  if(marSt == 1 && frmProfile.childLivingWithMe[0].checked || frmProfile.childLivingWithMe[1].checked){
  frmProfile.childLivingWithMe[0].disabled=true;frmProfile.childLivingWithMe[1].disabled=true;
  }
  if(childLW == 0){
  frmProfile.childLivingWithMe[0].disabled=true;frmProfile.childLivingWithMe[1].disabled=true;
    }else if ( childLW >=1 && marSt > 1){
  frmProfile.childLivingWithMe[0].disabled=false;frmProfile.childLivingWithMe[1].disabled=false;
  }
}

function onKGS() {
	if (!(document.frmProfile.weightLbs.value=="0")){document.frmProfile.weightLbs.value="0";}
}
	
function onLBS() {
	if (!(document.frmProfile.weightKgs.value=="0")){document.frmProfile.weightKgs.value="0";}		
}

function chkIncomeDet() {
	var frmProfile = document.frmProfile;
	if(frmProfile.annualIncomeCurrency.selectedIndex!=0){
		 if(frmProfile.annualIncome.value == '') {
			$('income').innerHTML="Please enter annual income amount";frmProfile.annualIncome.focus();return false;
		  }else {$('income').innerHTML="";}
	}
}

function aboutmeValidate() {
	var frmProfile = document.frmProfile;
    var communityId = frmProfile.communityId.value;

	if(frmProfile.maritalstatusfeature.value == 1){
		if(frmProfile.maritaltxtfeature.value == 1) { //hidden value
		} else if(frmProfile.maritaltxtfeature.value > 1){ //drop down values
			if(frmProfile.maritalStatus.selectedIndex == 0){
				$('mstatus').innerHTML="Please select the marital status of the prospect";frmProfile.maritalStatus.focus();return false;
			} else { $('mstatus').innerHTML=""; }

			if(frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value > 1 && frmProfile.noOfChildren.selectedIndex == 0 ){
				$('mstatus').innerHTML="Please select the number of children";frmProfile.noOfChildren.focus();return false;
			} else { $('mstatus').innerHTML=""; }

			if(frmProfile.maritalStatus.options[frmProfile.maritalStatus.selectedIndex].value > 1 && frmProfile.noOfChildren.options[frmProfile.noOfChildren.selectedIndex].value >= 1 && !frmProfile.childLivingWithMe[0].checked && !frmProfile.childLivingWithMe[1].checked) {
				$('mstatus').innerHTML="Please indicate whether the child/children is/are living with you";frmProfile.childLivingWithMe[0].focus();
				return false;
			} else { $('mstatus').innerHTML=""; }
		}
	}
    
    if(frmProfile.heightFeet.selectedIndex==0 && frmProfile.heightCms.selectedIndex==0){
		$('height').innerHTML="Please select the height of the prospect";frmProfile.heightFeet.focus();return false;
	}else{
		$('height').innerHTML="";
	}

	if (parseInt(document.frmProfile.appearanceFeature.value)==1) {
		if (!frmProfile.appearance[0].checked && !frmProfile.appearance[1].checked) {
			document.getElementById('spanappearance').innerHTML="Select the appearance of the prospect";
			frmProfile.appearance[0].focus();
			return false;
		} else { document.getElementById('spanappearance').innerHTML=""; }
	}

	if(frmProfile.mothertonguefeature.value == 1){
		if(frmProfile.mothertonguetxtfeature.value == 1) { //hidden value
		} else if(frmProfile.mothertonguetxtfeature.value > 1){ //drop down values
			if(frmProfile.motherTongue.selectedIndex == 0){
				$('mothertong').innerHTML="Please select the mother tongue of the prospect";frmProfile.motherTongue.focus();return false;
			} else {
				$('mothertong').innerHTML="";
			}

			//chkOthers();

			if(document.frmProfile.motherTongue.value == 9997) {
				if(frmProfile.motherTongueTxt.value == '') {
					$('mothertong').innerHTML="Please enter the mother tongue of the prospect";frmProfile.motherTongueTxt.focus();return false;
				} else {
					$('mothertong').innerHTML="";
				}
			}
		} else { //text box value
			if(frmProfile.motherTongueTxt.value == '') {
				$('mothertong').innerHTML="Please enter the mother tongue of the prospect";frmProfile.motherTongueTxt.focus();return false;
			} else {
				$('mothertong').innerHTML="";
			}
		}
	}

	if (parseInt(document.frmProfile.religionfeature.value)==1 && parseInt(document.frmProfile.religionOption.value)>1 ) {
	var religionId = document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
	if (religionId == 0) {
	 document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
	 document.frmProfile.religion.focus();return false;
	}
	else if(religionId == 23 && document.frmProfile.religionOthers.value == '') {
	  document.getElementById('religionspan').innerHTML="Enter the religion of the prospect";
	  document.frmProfile.religionOthers.focus();return false;
	}
	else { document.getElementById('religionspan').innerHTML=''; }
	}

	if (parseInt(document.frmProfile.castefeature.value)==1) {

	if (parseInt(document.frmProfile.casteOption.value)==1) {} else {
		
		if (parseInt(document.frmProfile.casteOption.value)>1) {

            var casteId = parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value);
		    
			if(casteId == 9997) {
			  if (document.frmProfile.casteOthers.value=="") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
					document.frmProfile.casteOthers.focus();
					return false;
			  }
			  else { document.getElementById('castespan').innerHTML=''; }
			}
			else { document.getElementById('castespan').innerHTML=''; }
		}
	}
   }
 
	if (frmProfile.educationCategory.selectedIndex==0)
     {document.getElementById('educationcategoryspan').innerHTML="Select the education category of the prospect";frmProfile.educationCategory.focus();return false;}	
    else{document.getElementById('educationcategoryspan').innerHTML="";}
   
    if (frmProfile.occupation.selectedIndex==0)
     {document.getElementById('occupationspan').innerHTML="Select the occupation of the prospect";frmProfile.occupation.focus();return false;}	
     else{document.getElementById('occupationspan').innerHTML="";}

    if(frmProfile.occupation.options[frmProfile.occupation.selectedIndex].value != 888) {
		if (parseInt(document.frmProfile.empinfeature.value)==1) {
			if (parseInt(document.frmProfile.employedinOption.value)>1) {
				if ( IsEmpty(document.frmProfile.employmentCategory,'radio')) {
				  document.getElementById('employmentCategoryspan').innerHTML="Select the employment category of the prospect";
				  frmProfile.employmentCategory[0].focus();
				  return false;}
				else{document.getElementById('employmentCategoryspan').innerHTML=""; }
			}
		}

		var inCurr = document.frmProfile.annualIncomeCurrency.options[document.frmProfile.annualIncomeCurrency.selectedIndex].value;

		if (inCurr==0) {
			document.getElementById('annualincomespan').innerHTML="Select the currency type";
			document.frmProfile.annualIncomeCurrency.focus();
			return false;
		} else { document.getElementById('annualincomespan').innerHTML=""; }

		if (IsEmpty(document.frmProfile.annualIncome,'text')) {

			document.getElementById('amountspan').innerHTML="Enter a valid income";frmProfile.annualIncome.focus();return false;

		} else { document.getElementById('amountspan').innerHTML=""; }

		if (!(IsEmpty(document.frmProfile.annualIncome,'text'))) {

			if(!ValidateNo(document.frmProfile.annualIncome.value,'1234567890 ,.'))
			{document.getElementById('amountspan').innerHTML="Enter a valid income";frmProfile.annualIncome.focus();return false;}	
			else { document.getElementById('amountspan').innerHTML=""; }
		 }
   }
   
   if(frmProfile.country.value == 0){
		$('loccountry').innerHTML="Please select the country of living of the prospect";frmProfile.country.focus();return false;
	}else{
		$('loccountry').innerHTML="";
	}

	var cntry = frmProfile.country.value;
	if(cntry == 98 || cntry == 222 || cntry==195 || cntry==162) {
		if(frmProfile.residingState.selectedIndex == 0 ){
			if(cntry==195){
			$('locresidingstate').innerHTML="Please select the district of the prospect";frmProfile.residingState.focus();	
			return false;
			}else{
			$('locresidingstate').innerHTML="Please select the resident state of the prospect";frmProfile.residingState.focus();
			return false;
				}
			

		}else{
			$('locresidingstate').innerHTML="";
		}
	} else {
		if(frmProfile.residingState.value == '' ){
			$('locresidingstate').innerHTML="Please enter the resident state of the prospect";frmProfile.residingState.focus();
			return false;
		}else{
			$('locresidingstate').innerHTML="";
		}
	}

	if(cntry == 98 || cntry==162) {
		if(frmProfile.residingCity.selectedIndex == 0 ){
			$('locresidingcity').innerHTML="Please select the residing city of the prospect";frmProfile.residingCity.focus();
			return false;
		}else{
			$('locresidingcity').innerHTML="";
		}
	} else {
		if(frmProfile.residingCity.value == '' ){
			$('locresidingcity').innerHTML="Please enter the residing city of the prospect";
			frmProfile.residingCity.focus();
			return false;
		}else{
			$('locresidingcity').innerHTML="";
		}
	}


   var countryId;
   countryId = document.frmProfile.country.options[document.frmProfile.country.selectedIndex].value;
   if (countryId!=98) {
	if(frmProfile.citizenship.selectedIndex == 0){
		$('loccitizenship').innerHTML="Please select the citizenship of the prospect";frmProfile.citizenship.focus();return false;
	}else{$('loccitizenship').innerHTML="";}
   }
	if(frmProfile.residentStatus.selectedIndex == 0 && communityId != 2006){
		$('locresident').innerHTML="Please select the resident status of the prospect";frmProfile.residentStatus.focus();
		return false;
	}else {$('locresident').innerHTML="";}  
	
	if((IsEmpty(frmProfile.DESCDET,'textarea'))){
		$('aboutmyselfspan').innerHTML="Please enter your description.";frmProfile.DESCDET.focus();return false;
	}else{$('aboutmyselfspan').innerHTML="";}

	if (frmProfile.DESCDET.value.length<50) {
		$('aboutmyselfspan').innerHTML="Please enter a profile description in not less than 50 characters";
		document.frmProfile.DESCDET.focus();
		return false;
	} else { $('aboutmyselfspan').innerHTML=""; }
}

function onCMS() {
	if (!(document.frmProfile.heightFeet.value=="0"))
	{document.frmProfile.heightFeet.value="0";}
}
	
function onFEET() {
	if (!(document.frmProfile.heightCms.value=="0"))
	{document.frmProfile.heightCms.value="0";}
}

function heightChk(){
	var frmProfile = this.document.frmProfile;
	if (frmProfile.heightFeet.selectedIndex==0 && frmProfile.heightCms.selectedIndex==0) {
		$('height').innerHTML="Please select the height of the prospect";
		return;
	} else {
		$('height').innerHTML=" ";
	}
}

function checkEmployment() {
	if ( IsEmpty(document.frmProfile.employmentCategory,'radio')) {
	document.getElementById('employmentCategoryspan').innerHTML="Select the employment category of the prospect";
	return false;}
	else{document.getElementById('employmentCategoryspan').innerHTML=""; }
}

var objOccupationCall;
function ajaxOccupationCall(url) {
	var varEmploymentIn = "";
	var varOccupationId = frmProfile.occupationid.value; 
	for (var i=0; i < frmProfile.employmentCategory.length; i++) {

		if (frmProfile.employmentCategory[i].checked) {
			varEmploymentIn	= frmProfile.employmentCategory[i].value;break;
		}
	}
	if (varEmploymentIn!=5) {
	   objOccupationCall = AjaxCall();
	   var parameters	=  "selectedEmploymentIn="+varEmploymentIn+"&selectedOccupationId="+varOccupationId+"&display=state&rand="+Math.random();
	   objOccupationCall.onreadystatechange = regOccupationList;
	   objOccupationCall.open('POST', url, true);
	   objOccupationCall.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   objOccupationCall.setRequestHeader("Content-length", parameters.length);
	   objOccupationCall.setRequestHeader("Connection", "close");
	   objOccupationCall.send(parameters);
	   return objOccupationCall;	
	}
}

function regOccupationList() {

	if (objOccupationCall.readyState == 4 && objOccupationCall.status == 200) {
		document.getElementById('occdiv').innerHTML	= objOccupationCall.responseText;
	}
}

function occupationChk() {
		var frmProfile = document.frmProfile;
		var inCurr = document.frmProfile.annualIncomeCurrency.options[document.frmProfile.annualIncomeCurrency.selectedIndex].value;

		if (inCurr==0) {
			document.getElementById('annualincomespan').innerHTML="Select the currency type";
			return false;
		} else { document.getElementById('annualincomespan').innerHTML=""; }
	
		if (!(IsEmpty(document.frmProfile.annualIncome,'text'))) {

			if(!ValidateNo(document.frmProfile.annualIncome.value,'1234567890 ,.'))
			{document.getElementById('amountspan').innerHTML="Enter a valid income";frmProfile.annualIncome.focus();return false;}	
			else{document.getElementById('amountspan').innerHTML="";}
		}
}

function amountChk() {
	var frmProfile = this.document.frmProfile;
	if (!(IsEmpty(document.frmProfile.annualIncome,'text')))
	{
		if (frmProfile.annualIncomeCurrency.value==0)
		{document.getElementById('annualincomespan').innerHTML="Select the currency type";return;}	
		else{document.getElementById('annualincomespan').innerHTML=" ";}

		if(!ValidateNo(document.frmProfile.annualIncome.value,'1234567890,.'))
		{document.getElementById('amountspan').innerHTML="Enter a valid income";return;}	
		else{document.getElementById('amountspan').innerHTML=" ";}
	}
}


function countryChk() {
	 var frmProfile = document.frmProfile;
	 var countryId = parseInt( frmProfile.country.options[frmProfile.country.selectedIndex].value);
	if ( countryId == 0 || countryId == "" ) {
		$('loccountry').innerHTML="Please select the country of living of the prospect";
		return;
	} else {
		$('loccountry').innerHTML="";
		if (countryId != 98) {
			document.getElementById('showCitizenship').style.display="block";
	    } 
		else { document.getElementById('showCitizenship').style.display="none"; }
		modifystate(frmProfile.country.value);
        
	}
  	//makerequest(document.frmProfile.country.options[document.frmProfile.country.selectedIndex].value);
}

function funSrilankanReside(countryId) {  // Residing state Lable change for Srilankan 
  if(countryId==195){ 
	  document.getElementById('residspan').innerHTML="District<font class=\"clr3\">*</font>";
	  document.getElementById('residcitydist').innerHTML="Residing City<font class=\"clr3\">*</font>";
    }
	else{
	  document.getElementById('residspan').innerHTML="Residing state<font class=\"clr3\">*</font>";
	  document.getElementById('residcitydist').innerHTML="Residing City / District<font class=\"clr3\">*</font>";
	}
}

var state_request = false;
function modifystate(cval) {	
	if(cval>0 && cval!=null) {
		state_request = AjaxCall();
		var url="../profiledetail/country/getstates.php?countryid="+cval; //Mano
		state_request.onreadystatechange = processResponseState;
		state_request.open('GET', url, true);
		state_request.send(null);
	} else {}
}

function processResponseState() {
	if (state_request.readyState == 4) {
		if (state_request.status == 200) {
			$("statecitydiv").innerHTML = '';
			$("statecitydiv").innerHTML = state_request.responseText;
			 // Residing state Lable change for Srilankan 
   var countryId = parseInt( frmProfile.country.options[frmProfile.country.selectedIndex].value);
	if(countryId==195){funSrilankanReside(countryId);
	} 
	else{
		document.getElementById('residspan').innerHTML="Residing state<font class=\"clr3\">*</font>";
		document.getElementById('residcitydist').innerHTML="Residing City / District<font class=\"clr3\">*</font>";
	}
		}
	}
}

var ccode_request = false;
function modrequestnew(cvalue,svalue) {	
	if(cvalue>0 && cvalue!=null && svalue>0 && svalue!=null) {
		ccode_request = AjaxCall();
		var url="../register/country/getcities.php?countryid="+cvalue+"&stateid="+svalue; //Mano
       	ccode_request.onreadystatechange = processResponsenew;
		ccode_request.open('GET', url, true);
		ccode_request.send(null);
	} else {
		
		emptyCitySel();
	}
}

function emptyCitySel() {
	var citysel = $('residingCity');
	
	if (citysel.length>0) {
		for(i=citysel.length;i>=0;i--) {
			citysel.remove(i);
		}
	}
	var y=document.createElement('option');
	y.value='0';
	y.text='-Select-';
	try {
		citysel.add(y,null); // standards compliant
	} catch(ex) {
		citysel.add(y); // IE only
	}
}

function processResponsenew() {
	
	if (ccode_request.readyState == 4) {
		if (ccode_request.status == 200) { 
			var citysel = $('residingCity');
			var listValues = ccode_request.responseText;
			listValueArray = listValues.split('~');
			var y;
			for(i=0;i<listValueArray.length;i=i+2) {
			  y=document.createElement('option');
			  y.value=listValueArray[i];
			  y.text=listValueArray[i+1];
			  try {
				citysel.add(y,null); // standards compliant
			  } catch(ex) {
				citysel.add(y); // IE only
			  }
			}
		}
	}
	else
	{
		emptyCitySel();
	}
}

var countrycode_request=false;
function makerequest(cvalue) {
	if(cvalue>0 && cvalue!=null) {
		countrycode_request = AjaxCall();
		var url="../register/countrycode.php?country="+cvalue; //Mano
		countrycode_request.onreadystatechange = processResponse;
		countrycode_request.open('GET', url, true);
		countrycode_request.send(null);
	}
}

function processResponse() {
	if (countrycode_request.readyState == 4) {
		if (countrycode_request.status == 200) {
			document.frmProfile.countryCode.value=countrycode_request.responseText;
		}
	}
}

// function to handle occupation selection in dropdown box //
function selectOccupation(occupationValue) {
  if(occupationValue == 888) {
	frmProfile.occupationInDetail.value='';   
   frmProfile.annualIncome.value='';
   frmProfile.annualIncomeCurrency.selectedIndex = 0;
   frmProfile.occupationInDetail.disabled = true;
   EnableDisableEmployedIn(true);
   frmProfile.annualIncomeCurrency.disabled=true;
   frmProfile.annualIncome.disabled=true;
   document.getElementById('employmentCategoryspan').innerHTML="";
   document.getElementById('annualincomespan').innerHTML="";
   document.getElementById('amountspan').innerHTML="";
  }
  else {
   frmProfile.occupationInDetail.disabled = false;
   EnableDisableEmployedIn(false);
   frmProfile.annualIncomeCurrency.disabled=false;
   frmProfile.annualIncome.disabled=false;
  }
}

 // function to disable whole employedin category radio buttons //
 function EnableDisableEmployedIn(flgStatus) {
   for(var i=0;i < frmProfile.employmentCategory.length;i++) {
    frmProfile.employmentCategory[i].disabled = flgStatus;
	if(flgStatus == true) {
	  frmProfile.employmentCategory[i].checked = false;
	}
   }
 }

function religiousChk() {
	var frmProfile = this.document.frmProfile;
	if (parseInt(frmProfile.religiousfeature.value)==1 && parseInt(frmProfile.religiousOption.value)>1 ) {
		if (parseInt(frmProfile.religious.options[frmProfile.religious.selectedIndex].value)== 0) {
			document.getElementById('religiousspan').innerHTML="Select the religious values of the prospect";
			return false;
		} else {
			document.getElementById('religiousspan').innerHTML='';
		}

	}
}

function ethnicityChk() {
	var frmProfile = this.document.frmProfile;
	if (parseInt(frmProfile.ethinicityfeature.value)==1 && parseInt(frmProfile.ethnicityOption.value)>1 ) {
		if (parseInt(frmProfile.ethnicity.options[frmProfile.ethnicity.selectedIndex].value)== 0) {
			document.getElementById('ethnicityspan').innerHTML="Select the ethnicity of the prospect";
			return false;
		} else {
			document.getElementById('ethnicityspan').innerHTML='';
		}

	}
}

function religionChk() {
	var frmProfile = this.document.frmProfile;
	if(document.getElementById('casteDivText') != null) {
	  document.getElementById('casteDivText').style.display='none';
	}
	if (parseInt(frmProfile.religionfeature.value)==1 && parseInt(frmProfile.religionOption.value)>1 ) {
		if (parseInt(frmProfile.religion.options[frmProfile.religion.selectedIndex].value)== 0) {
			document.getElementById('religionspan').innerHTML="Select the religion of the prospect";
			return;
		} else {
			document.getElementById('religionspan').innerHTML='';
		}
	}
}

function casteChk() {

	if (parseInt(document.frmProfile.castefeature.value)==1) {
		
	 if (parseInt(document.frmProfile.casteOption.value)==1) {} else {
		
		if (parseInt(document.frmProfile.casteOption.value)>1) {
            var casteId = parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value);
			if (casteId == 0) {
			document.getElementById('castespan').innerHTML="Select the "+document.frmProfile.castelabel.value+" of the prospect";
			return;
			}
			else if(casteId == 9997) {
			  if (document.frmProfile.casteOthers.value=="") {
					document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
					//document.frmProfile.casteOthers.focus();
					return;
			  }
			  else { document.getElementById('castespan').innerHTML=''; }
			}
			else { document.getElementById('castespan').innerHTML=''; }
		}
	 }
   }
}

function casteOthersChk(){
	var casteId =  parseInt(document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value);
    document.getElementById('castespan').innerHTML='';
	var communityId = frmProfile.communityId.value;
	if (casteId== 9997) {
	        document.getElementById('casteDivText').style.display='block';
			if (document.frmProfile.casteOthers.value=="" && communityId != 2004) {
			document.getElementById('castespan').innerHTML="Enter the "+document.frmProfile.castelabel.value+" of the prospect";
			return;

		} else {  document.getElementById('castespan').innerHTML=""; }

	} else { document.getElementById('casteDivText').style.display='none'; }
}

//***********************************************
var objSubCaste;
function funCaste(argCasteId){
	var casteId;
	if(document.frmProfile.casteOthers != undefined) {
	  document.frmProfile.casteOthers.value='';
	}
	// added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //

	if (argCasteId=='') {
		casteId = document.frmProfile.caste.options[document.frmProfile.caste.selectedIndex].value;
	} else { casteId = argCasteId; }
}//funCaste

function populateSubCasteList() {
	if (objSubCaste.readyState == 4 && objSubCaste.status == 200) {
		var subCasteList = objSubCaste.responseText.split('~');
		document.frmProfile.subCasteOption.value	= subCasteList[0];
		document.getElementById('subCasteDivId').innerHTML	= subCasteList[1];
	}
	funGothramChk();
}


//***************************************************************
var objCaste;
function funReligion(){

    // added by barani //
      communityId = document.frmProfile.communityId.value;
	// end by barani //

	var casteId = 0;
	var casteFeature = document.frmProfile.castefeature.value;
	var casteOption = document.frmProfile.casteOption.value;
	var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
	var relOpt		= document.frmProfile.religionOption.value;
    
   if(casteFeature == 1) {
   document.getElementById('castespan').innerHTML='';
   }
   document.frmProfile.religionOthers.value ='';
   if(religionId == 23) {
	 document.getElementById('religionDivText').style.display = "inline";
     document.getElementById('casteBlockDivId').style.display ='none';
   }
   else if(religionId == 2 || religionId == 6) {
     document.getElementById('religionDivText').style.display = "none";
     document.getElementById('casteBlockDivId').style.display ='none';
   }
   else {
     document.getElementById('religionDivText').style.display = "none";

	if (casteOption==1) { casteId = document.frmProfile.caste.value; }

	//Caste Label Changes
	if ((religionId=='10') || (religionId=='11') || (religionId=='20' ) || (religionId=='21' ) || (religionId=='22' ))  { document.getElementById('branchDiv').innerHTML='Clan';  } 
	else if ((religionId=='3') || (religionId=='12') || (religionId=='13' ) || (religionId=='14' )) { document.getElementById('branchDiv').innerHTML='Denomination';  } 
	else if (religionId=='7') { document.getElementById('branchDiv').innerHTML='Branch';  } 
	else { 
		if (document.getElementById('branchDiv')) { document.getElementById('branchDiv').innerHTML='Caste'; } 
	} 

	if (religionId > 0) {
		objCaste = AjaxCall();
		var parameters	= "religionId="+religionId+"&communityId="+communityId+"&field=religion&rand="+Math.random();
		var stateURL	= '/register/country/populatecaste.php';
		objCaste.onreadystatechange = populateCasteList;
		objCaste.open('POST', stateURL, true);
		objCaste.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objCaste.setRequestHeader("Content-length", parameters.length);
		objCaste.setRequestHeader("Connection", "close");
		objCaste.send(parameters);
		return objCaste;
	}//if
  }
}//funCaste

function religionOthersChk() {
 var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;
 var religionText= document.frmProfile.religionOthers.value;

 if(religionId == 23 && religionText=='') {
  document.getElementById('religionspan').innerHTML="Enter the religion of the prospect";
  }
 else {
  document.getElementById('religionspan').innerHTML="";
 }
}

function populateCasteList() {
	if (objCaste.readyState == 4 && objCaste.status == 200) {
		var casteList = objCaste.responseText.split('~');
		document.getElementById('casteBlockDivId').style.display ='inline';
		document.frmProfile.casteOption.value	= casteList[0];
		document.getElementById('casteDivId').innerHTML	= casteList[1];
		if(casteList[0] == 0 && casteList[1] == 0) {
		 document.getElementById('casteBlockDivId').style.display ='none';
		}
	}
}

function funEditReligion(){

    // added by barani //
	 var frmProfile = this.document.frmProfile;
      communityId = document.frmProfile.communityId.value;
	// end by barani //
 
	var casteId = 0;
	var casteOption = document.frmProfile.casteOption.value;
	var religionId	= document.frmProfile.religion.options[document.frmProfile.religion.selectedIndex].value;

	if (casteOption==1) { casteId = document.frmProfile.caste.value; }

	//Caste Label Changes
	if ((religionId=='10') || (religionId=='11') || (religionId=='20' ) || (religionId=='21' ) || (religionId=='22' ))  { document.getElementById('branchDiv').innerHTML='Clan';  } 
	else if ((religionId=='3') || (religionId=='12') || (religionId=='13' ) || (religionId=='14' )) { document.getElementById('branchDiv').innerHTML='Denomination';  } 
	else if (religionId=='7') { document.getElementById('branchDiv').innerHTML='Branch';  } 
	else { 
		if (document.getElementById('branchDiv')) { document.getElementById('branchDiv').innerHTML='Caste'; } 
	}

}//funCaste

function motherTongueOther(selVal){
	if(selVal=="9997"){
			document.getElementById("motherTongueBranchDiv").style.display="block"; 
			document.frmProfile.motherTongueTxt.focus();
	}
	else{ document.frmProfile.motherTongueTxt.value="";
		  document.getElementById("motherTongueBranchDiv").style.display="none";
	}
}

function motherothersChk(){
 if(frmProfile.motherTongueTxt.value==""){
	 document.getElementById('mothertong').innerHTML="Enter the mother tongue of the prospect";
	return;
}
 else{document.getElementById('mothertong').innerHTML="";}
}

function placeofbirthChk() {
  var frmProfile = this.document.frmProfile;

	var countryId	= parseInt(frmProfile.placeofbirth.options[frmProfile.placeofbirth.selectedIndex].value);
	if ( countryId == 0 || countryId=="" ) {
		document.getElementById('placeofbirthspan').innerHTML="Select the place of birth of the prospect";
		return;

	} else { document.getElementById('placeofbirthspan').innerHTML=""; }
}