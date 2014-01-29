function validateForm() { 
	var addressfrm = document.addressform;
	//Name
	if(addressfrm.name.value == "") {
		$("errorname").innerHTML = "Enter your name";
		addressfrm.name.value = "";
		addressfrm.name.focus();
		return false;
	}
	if(!isHtmlTag(addressfrm.name.value)) {
		$("name").innerHTML = "Please avoid HTML tags and url links";
		addressfrm.name.value = "";
		addressfrm.name.focus();
		return false;
	}
	if(!isUrl(addressfrm.name.value)) {
		$("name").innerHTML = "Please avoid HTML tags and url links";
		addressfrm.name.value = "";
		addressfrm.name.focus();
		return false;
	}
	$("errorname").innerHTML = "";

//Mobile
	$("errorphone").innerHTML = "";
	if(addressfrm.countryCode.value == ""  && addressfrm.phoneNo.value == ""  && addressfrm.areaCode.value == "" ) {
	if(addressfrm.mobileNo.value == "") {
	
			$("errormobile").innerHTML = "Enter your phone number";
			addressfrm.mobileNo.value = "";
			addressfrm.mobileNo.focus();
			return false;
	}	
	}
	$("errormobile").innerHTML = "";
	if(addressfrm.countryCode.value == ""){
			$("errorphone").innerHTML = "Enter your country code";
			addressfrm.countryCode.value = "";
			addressfrm.countryCode.focus();
			return false;
	}
	if(addressfrm.areaCode.value == ""){
			$("errorphone").innerHTML = "Enter your area code";
			addressfrm.areaCode.value = "";
			addressfrm.areaCode.focus();
			return false;
	}
	if(addressfrm.phoneNo.value == ""){
			$("errorphone").innerHTML = "Enter your phone number";
			addressfrm.phoneNo.value = "";
			addressfrm.phoneNo.focus();
			return false;
	}
	
	$("errorphone").innerHTML = "";
	//address
	if(addressfrm.address.value == "") {
		$("erroraddress").innerHTML = "Enter your address";
		addressfrm.address.focus();
		return false;
	}
	return true;
}

function isUrl(str) { 
	if(str.match("http://")!=null){return false;}
	else if(str.match("https://")!=null){return false;}
	else if(str.match("www.")!=null){return false;}
	else{return true;}
}

function isHtmlTag(str) {
	if(str.match(/([\<])([^\>]{1,})*([\>])/i)!=null){return false;} else{return true;}
}
