var str;
function funDoorStep() {
	var frm = this.document.doorStep;

	if (document.doorStep.category.options[document.doorStep.category.selectedIndex].value==0){
		$('categoryspan').innerHTML="Please select category";
		frm.category.focus();
		return false;
	} else { $('categoryspan').innerHTML=""; }

	if(IsEmpty(frm.matriId,"text")) {
	$('matriidspan').innerHTML="Please enter MatriID";
	return false;
	} else { $('matriidspan').innerHTML=""; }

	str= document.doorStep.matriId.value;
	var str1=(str.substring(0,3));
	var str2=(str.substring(3,13));
	

	if(( !ValidateNo( str1, "ABCDEFGHIJKLMNOPQRSTUVWXYZ" )) || (!ValidateNo( str2, "0123456789" )) ){
		$('matriidspan').innerHTML="Please enter Correct MatriId";
		return false;
	} else { $('matriidspan').innerHTML=""; }

	if (document.doorStep.city.options[document.doorStep.city.selectedIndex].value==0){
	$('cityspan').innerHTML="Please select city";
	frm.city.focus();
	return false;
	} else { $('cityspan').innerHTML=""; }

	if(IsEmpty(frm.contactPerson,"text")) {
	$('conpersonspan').innerHTML="Please enter contact person name";
	frm.contactPerson.focus();
	return false;
	} else { $('conpersonspan').innerHTML=""; }

	if(IsEmpty(frm.contactNumber,"text")) {
	$('connumberspan').innerHTML="Please enter the contact phone number";
	frm.contactNumber.focus();
	return false;
	} else { $('connumberspan').innerHTML=""; }

	if( !ValidateNo( document.doorStep.contactNumber.value, "0123456789" ) ){

		$('connumberspan').innerHTML="Please enter valid contact phone number";
		return false;
	} else { $('connumberspan').innerHTML=""; }

	if(IsEmpty(frm.todate,"text")) {
		$('fromdatespan').innerHTML="Please select a date";
		frm.todate.focus();
		return false;
	} else { $('fromdatespan').innerHTML=""; }
	
		
	if (document.doorStep.fromTime.options[document.doorStep.fromTime.selectedIndex].value==0){
		$('fromspan').innerHTML="Please Select From Time";
		frm.fromTime.focus();
		return false;
	} else { $('fromspan').innerHTML=""; }
	if (document.doorStep.toTime.options[document.doorStep.toTime.selectedIndex].value==0){
		$('fromspan').innerHTML="Please Select To Time";
		frm.toTime.focus();
		return false;
	} else { $('fromspan').innerHTML=""; }
	if((document.doorStep.fromTime.options[document.doorStep.fromTime.selectedIndex].value)>=(document.doorStep.toTime.options[document.doorStep.toTime.selectedIndex].value)){
	$('fromspan').innerHTML="Please select a 'to time' that comes after the 'from time' on the same day. i.e. From 10am to 8pm";
	return false;
	}else { $('fromspan').innerHTML=""; }

	
	if((varGivenYear==servyear)&&(varGivenMonth==servmonth)&&(varonlyDate==servdate)){
		Selectedtime=document.doorStep.fromTime.options[document.doorStep.fromTime.selectedIndex].value;
		Selectedcorrecttime=Selectedtime.split(':');
		selectedmatchtime=Selectedcorrecttime[0];
		if(selectedmatchtime <= servhour){
			$('fromspan').innerHTML="The time you have selected has passed. Please select a future time.";
			frm.fromTime.focus();
			return false;
		}
	}else { $('fromspan').innerHTML=""; }

	return true;

}//funDoorStep

function funCategory(){

	var frm = this.document.doorStep;
	if (document.doorStep.category.options[document.doorStep.category.selectedIndex].value==0){
		$('categoryspan').innerHTML="Please select category";
		//frm.category.focus();
		return;
	} else { $('categoryspan').innerHTML=""; }
}

function funMatriID(){
	var frm = this.document.doorStep;
	if(IsEmpty(frm.matriId,"text")) {
	$('matriidspan').innerHTML="Please enter MatriID";
	return ;
	} else { $('matriidspan').innerHTML=""; }

	str= document.doorStep.matriId.value;
	var str1=(str.substring(0,3));
	var str2=(str.substring(3,13));

	if((!ValidateNo(str1, "ABCDEFGHIJKLMNOPQRSTUVWXYZ" )) || (!ValidateNo( str2, "0123456789" ))){
		$('matriidspan').innerHTML="Please enter Correct MatriId";
		frm.matriId.focus();
		return ;
	} else { $('matriidspan').innerHTML=""; }
}

function funCity() {
	if (document.doorStep.city.options[document.doorStep.city.selectedIndex].value==0){
	$('cityspan').innerHTML="Please select city";
	return;
	} else { $('cityspan').innerHTML=""; }
}

function funPerson() {
	var frm = this.document.doorStep;
	if(IsEmpty(frm.contactPerson,"text")) {
	$('conpersonspan').innerHTML="Please enter contact person name";
	return;
	} else { $('conpersonspan').innerHTML=""; }
}

function funConNumber() {
	var frm = this.document.doorStep;
	if(IsEmpty(frm.contactNumber,"text")) {
	$('connumberspan').innerHTML="Please enter the contact phone number";
	return;
	} else { $('connumberspan').innerHTML=""; }

	if( !ValidateNo( document.doorStep.contactNumber.value, "0123456789" ) ){

		$('connumberspan').innerHTML="Please enter valid contact phone number";
		return;
	} else { $('connumberspan').innerHTML=""; }
}


function funFromTime(){
	var frm = this.document.doorStep;
	var varGivenDate     = frm.todate.value;
	var varGivenFullDate = varGivenDate.split('-');
	var varGivenYear     = varGivenFullDate[0];
	var varGivenMonth    = varGivenFullDate[1];
	var varonlyDate      = varGivenFullDate[2];
	if (document.doorStep.fromTime.options[document.doorStep.fromTime.selectedIndex].value==0){
		$('fromspan').innerHTML="Please Select From Time";
		//frm.category.focus();
		return;
	}else { $('fromspan').innerHTML=""; }
	
	if((varGivenYear==servyear)&&(varGivenMonth==servmonth)&&(varonlyDate==servdate)){
		Selectedtime=document.doorStep.fromTime.options[document.doorStep.fromTime.selectedIndex].value;
		Selectedcorrecttime=Selectedtime.split(':');
		selectedmatchtime=Selectedcorrecttime[0];
		if(selectedmatchtime <= servhour){
			$('fromspan').innerHTML="The time you have selected has passed. Please select a future time.";
			return;
		}
	}else { $('fromspan').innerHTML=""; }
}

function funToTime(){
	var frm = this.document.doorStep;
	if (document.doorStep.toTime.options[document.doorStep.toTime.selectedIndex].value==0){
		$('fromspan').innerHTML="Please Select To Time";
		//frm.category.focus();
		return;		
	} 
	else if((document.doorStep.fromTime.options[document.doorStep.fromTime.selectedIndex].value)>=(document.doorStep.toTime.options[document.doorStep.toTime.selectedIndex].value)){
	$('fromspan').innerHTML="Please select a 'to time' that comes after the 'from time' on the same day. i.e. From 10am to 8pm";
	return;
	}else { $('fromspan').innerHTML=""; }
}