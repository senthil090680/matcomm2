function isNoEmpty(eleobj,str)
{
	var strng;

	strng=eleobj.value;

	if (strng == '') {
	  alert('Please enter '+str);
	  eleobj.focus();
	  return false;
	}
	return true;
}

//Validating more than 1 mail addresses separated by comma
function isEmailAddresses(eleobj,str) {

	var strng;

	strng=eleobj.value;
	
	var mailaddresses=strng.split(',');

	if(!isNoEmpty(eleobj,str))
		return false;

    var emailFilter=/^.+@.+\..{2,3}$/;

	for(var cnt=0;cnt<mailaddresses.length;cnt++)
	{
		if (!(emailFilter.test(mailaddresses[cnt]))) 
		{ 
		   alert('Please enter Valid '+str);
		   eleobj.focus();
		   return false;
		}
		else 
		{
	//test email for illegal characters
		   var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
			 if (mailaddresses[cnt].match(illegalChars)) 
			{
			  alert('The '+str+' contains illegal characters');
			  eleobj.focus();
			  return false;
		   }
		}
	}
	return true;    
}

//To validate Email addresses
function isEmailAddress(eleobj,str) {

	var strng;

	strng=eleobj.value;

	if(!isNoEmpty(eleobj,str))
		return false;

    var emailFilter=/^.+@.+\..{2,3}$/;

    if (!(emailFilter.test(strng))) { 
       alert('Please enter a Valid '+str);
	   eleobj.focus();
	   return false;
    }
    else {
//test email for illegal characters
       var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
         if (strng.match(illegalChars)) {
		  alert('The '+str+' contains illegal characters');
		  eleobj.focus();
		  return false;
       }
    }
	return true;    
}

// phone number - 

function isPhoneNumber(eleobj,str) {

	var strng;

	strng=eleobj.value;

	if(!isNoEmpty(eleobj,str))
		return false;
	
	var expr=/^[0-9+-]*$/;

	if (strng.length < 10) {
	   alert('Please enter Valid '+str);
	   eleobj.focus();
	   return false;
	}
	else if(!expr.test(strng))
	{
		alert('Please enter Valid '+str);
		eleobj.focus();
		return false;
	}   
	return true;
}

function isContactNumber(eleobj,str) {

	var strng;

	strng=eleobj.value;

	if(!isNoEmpty(eleobj,str))
		return false;
	
	var expr=/^[0-9+-]*$/;

	if(!expr.test(strng))
	{
		alert('Please enter the Valid '+str);
		eleobj.focus();
		return false;
	}   
	return true;
}

// password Checking, minimum 4 chars and no special chars.

function isValidPassword(eleobj,str) 
{
	var strng;

	strng=eleobj.value;

	if(!isNoEmpty(eleobj,str))
		return false;

	var illegalChars = /[\W_]/; // allow only letters and numbers
    
	if (strng.length < 4) {
	   alert('The '+str+' should have minimum 4 charachters');
	   eleobj.focus();
	   return false;
	}
	else if (illegalChars.test(strng)) {
	 alert('The '+str+' should not have special characters');
	  eleobj.focus();
	  return false;
	} 
	return true;    
}    

//To check drop down option box is selected
function isselectChecked(eleobj,str)
{
	var len,flag;

	if(eleobj.options[0].selected)
	{
	  alert('Please Select '+str);
	  eleobj.focus();
	  return false;
	}
	return true;
}


