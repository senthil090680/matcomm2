var ajobj;var wload=0;
function createajax()
{
	var ajobj=null;
	if (window.XMLHttpRequest) // Mozilla, Safari,...
	{ajobj = new XMLHttpRequest();} 
	
	else if (window.ActiveXObject) // IE
	{ 
            try {ajobj = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) 
			{
                try {ajobj = new ActiveXObject("Microsoft.XMLHTTP");} catch (e) {}
            }
     }
	else 
	{
		//if (ajobj==null)
		//{alert("Your browser doesn't support AJAX.");}
		return false;
	}
	return  ajobj;
}

function MakePostRequest(url,parameters,functionname)
{
	//var ajobj=false;
    var ajobj = createajax();
	eval("ajobj.onreadystatechange = "+functionname+";");
	ajobj.open('POST', url, true);
	ajobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajobj.setRequestHeader("Content-length", parameters.length);
	ajobj.setRequestHeader("Connection", "close");
	ajobj.send(parameters);
	return ajobj;
}

function MakeGetRequest(url,functionname)
{
	var ajobj = createajax();
	if(functionname!=null && functionname!="")
	{eval("ajobj.onreadystatechange = "+functionname+";");}
	ajobj.open('GET', url, true);
	ajobj.send(null);
	return ajobj;
}

//For opactiy only

function createajax_opac()
{
	var ajobj_opac=null;
	if (window.XMLHttpRequest) // Mozilla, Safari,...
	{ajobj_opac = new XMLHttpRequest();} 
	
	else if (window.ActiveXObject) // IE
	{ 
            try {ajobj_opac = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) 
			{
                try {ajobj_opac = new ActiveXObject("Microsoft.XMLHTTP");} catch (e) {}
            }
     }
	else 
	{
		if (ajobj_opac==null)
		{alert("Your browser doesn't support AJAX.");}
		return false;
	}
	return  ajobj_opac;
}

function MakePostRequest_opac(url,parameters,functionname,post_user_obj)
{
	if(functionname!=null && functionname!="")
	{post_user_obj.onreadystatechange = eval(functionname);}
	post_user_obj.open('POST', url, true);
	post_user_obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	post_user_obj.setRequestHeader("Content-length", parameters.length);
	post_user_obj.setRequestHeader("Connection", "close");
	post_user_obj.send(parameters);
}

function MakeGetRequest_opac(url,functionname,get_user_obj)
{
	if(functionname!=null && functionname!="")
	{get_user_obj.onreadystatechange=eval(functionname);}
	get_user_obj.open('GET', url, true);
	get_user_obj.send(null);
}

//For opactiy only End

function genNumbers() {
  var d=new Date();
  var rand_flag = "sr"+d.getSeconds()+"we";
  return rand_flag;
}

function $(obj) {
   if(document.getElementById) {
        if(document.getElementById(obj)!=null) {
            return document.getElementById(obj)
        } else {
           return "";
       }
    } else if(document.all) {
        if(document.all[obj]!=null) {
            return document.all[obj]
        } else  {
          return "";
       }
    }
} 

function $_obj(obj) {
   if(document.getElementById) {
        if(document.getElementById(obj)!=null) {
            return document.getElementById(obj)
        } else {
           return "";
       }
    } else if(document.all) {
        if(document.all[obj]!=null) {
            return document.all[obj]
        } else  {
          return "";
       }
    }
} 
/*position find*/
function showSelectBoxes(){
	if(document.getElementsByTagName != 'undefined')
		{
			var selects = document.getElementsByTagName("select");
			for (i = 0; i != selects.length; i++) {
				selects[i].style.visibility = "visible";
			}
		}
		else {
			 //ele = eval("document." + form + ".elements");
			 ele = document.forms.elements;
			for (e = 0; e < ele.length; e++)
			{
				if (ele[e].type == "select-one")
				{
					ele[e].style.visibility = "visible";
				}
			}
		}
}

function hideSelectBoxes(form){
	if(document.getElementsByTagName != 'undefined')
	{
		var selects = document.getElementsByTagName("select");
		for (i = 0; i != selects.length; i++) {
			selects[i].style.visibility = "hidden";
		}
	}
	else {
		ele = document.forms.elements;
		for (e = 0; e < ele.length; e++)
		{
			if (ele[e].type == "select-one")
			{
				ele[e].style.visibility = "hidden";
			}
		}
	}
}

function findPosX(obj)
{
 var curleft = 0;
 if(obj.offsetParent)
 while(1) 
 {
  curleft += obj.offsetLeft;
  if(!obj.offsetParent)break;
  obj = obj.offsetParent;
  }
  else if(obj.x)
  curleft += obj.x;
  return curleft;
}

function findPosY(obj)
{
 var curtop = 0;
 if(obj.offsetParent)
 while(1)
 {
	curtop += obj.offsetTop;
    if(!obj.offsetParent)break;
    obj = obj.offsetParent;
  }
  else if(obj.y)curtop += obj.y;
  return curtop;
}
/*position find*/

/*Get cookie value*/
function GetCookie(name)
{
var cname = name + "=";
var dc = document.cookie;
	if (dc.length > 0)
	{ 
		begin = parseInt(dc.indexOf(cname));
		if (begin >= 0)
		{
			begin += cname.length;
			end = dc.indexOf(";", begin);
			if (end == -1) end = dc.length;
			return unescape(dc.substring(begin, end));
		}
	}
return null;
}

function findloc()
{
	loc=location.href;
	loc=loc.toLowerCase();
	loc=loc.substring(0,(loc.indexOf('.com/')))
	dm=loc.substring(loc.indexOf('.'),loc.length)
	dm=dm+".com"
	return dm
}
function setCookie(c_name,value)
{document.cookie = c_name + "=" + escape(value)+";DOMAIN="+findloc()+";PATH=/";}
function CallAlert()
{
	setCookie('swf_ck','null');
}
/*Get cookie value*/
function setwload(){wload=1;}
//window.onload=setwload