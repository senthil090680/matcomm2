function Validation(){		
		
		var rmuseraddition;
		
		rmuseraddition=document.rmuseraddition;

		if(!isNoEmpty(document.getElementById("userid"),' userId'))
		return false;
		
		if(!isNoEmpty(document.getElementById("name"),' name'))
		return false;	
		
		if(!isEmailAddress(document.getElementById("email"),' emailId'))
		return false;	
		
		if(!isOfficialEmailAddress(document.getElementById("email")))
		return false;		

		//if(!isContactNumber(document.getElementById("areacode"),' areacode'))
		//return false;	

		//if(!isContactNumber(document.getElementById("phoneno"),' phoneno'))
		//return false;	

		if(!isPhoneNumber(document.getElementById("mobileno"),' mobileno'))
		return false;		

		return true;
}

 function isOfficialEmailAddress(eleobj) {

	var emaillist=eleobj.value.split('@');
	if((emaillist[1] != "bharatmatrimony.com") && (emaillist[1] != "consim.com")) {
		alert("Please enter official Email Id (bharatmatrimony or consim Id)");
		eleobj.focus();
		return false;
	}
	return true;
 }

 function rmuseridvalidation(){		

		if(!isNoEmpty(document.getElementById("rmuserid"),'rmuserid'))
		return false;		

		return true;
}

function delete_chk(){
	if (confirm("Are you sure you want to delete?")){
		return true;
	} else{
		return false;
	}
}