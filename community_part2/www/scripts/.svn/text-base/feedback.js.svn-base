function validateFeedback()
{ 
  var feedfrm = document.feedbackform;
//Name
  if(feedfrm.fbName.value == ""){
	 $("name").innerHTML = "Enter your name";
	 feedfrm.fbName.value = "";
	 feedfrm.fbName.focus();
     return false;
	}
  if(!isHtmlTag(feedfrm.fbName.value))
	{
     $("name").innerHTML = "Please avoid HTML tags and url links";
	 feedfrm.fbName.value = "";
	 feedfrm.fbName.focus();
     return false;
	}
  if(!isUrl(feedfrm.fbName.value))
	{
     $("name").innerHTML = "Please avoid HTML tags and url links";
	 feedfrm.fbName.value = "";
	 feedfrm.fbName.focus();
     return false;
	}
//phone
  if(feedfrm.fbPhone.value != "")
	{ 
	 if(!isHtmlTag(feedfrm.fbPhone.value))
		{
		 $("phoneno").innerHTML = "Please avoid HTML tags and url links";
		 feedfrm.fbPhone.value = "";
		 feedfrm.fbPhone.focus();
		 return false;
		}
	  if(!isUrl(feedfrm.fbPhone.value))
		{
		 $("phoneno").innerHTML = "Please avoid HTML tags and url links";
		 feedfrm.fbPhone.value = "";
		 feedfrm.fbPhone.focus();
		 return false;
	    }
    }
//email 
	if(feedfrm.fbEmail.value == ""){
	 $("email").innerHTML = "Enter your e-mail ID";
     $("phoneno").innerHTML="";
	 feedfrm.fbEmail.value = "";
	 feedfrm.fbEmail.focus();
     return false;
	}
	if(!ValidateEmail(feedfrm.fbEmail.value)) {
		   $("email").innerHTML = "Invalid e-mail ID";
		   $("phoneno").innerHTML="";
		   feedfrm.fbEmail.focus();
		   return false;
	}

//suggestions or feedback
    if(feedfrm.fbFeedback.value == "") {
	 $("feedback").innerHTML = "Enter your suggestions or feedback";
	 $("email").innerHTML = "";
	 $("sysdetail").innerHTML = "";
	 feedfrm.fbFeedback.focus();
     return false;
	}
return true;
}

function isUrl(str)
{ if(str.match("http://")!=null){return false;}
  else if(str.match("https://")!=null){return false;}
  else if(str.match("www.")!=null){return false;}
  else{return true;}
}

function isHtmlTag(str)
{
if(str.match(/([\<])([^\>]{1,})*([\>])/i)!=null){return false;} else{return true;}
}
