function getHTTPObject(){
	var ajobj=null;
 	if (window.XMLHttpRequest) {
           ajobj = new XMLHttpRequest();            
        } else if (window.ActiveXObject) {
            try {
                ajobj = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajobj = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }
		else
			return false
	return  ajobj;
}

function ajax_action(objId, matriid){
	 try
	 {
		
		 httpObject = getHTTPObject();
		 if (httpObject != null) {
			var midlist=document.getElementById('mids').value.split(', ');
			for(var i=0;i<midlist.length;i++) {
				document.getElementById(midlist[i]).innerHTML = '';
			}
			document.getElementById(objId).innerHTML= "Loading...";
			urlpath="ajaxgetphonenumber.php?matriid="+matriid;		
			
			httpObject.open("GET", uncache(urlpath), true);
			httpObject.send(null);
			httpObject.onreadystatechange = function() {
								 
				if(httpObject.readyState == 4){
					//alert(httpObject.responseText);
					document.getElementById(objId).innerHTML=httpObject.responseText;
				}
			}
		}
	 }
	 catch (e)
	 {
			 alert(e);
	 }
		
	 return false;
}

function uncache(url)
{
	return url + '&time=' + (new Date()).getTime();
} 

function ajax_validation(objId){
	 try
	 {
		if(document.forms.passwordtrack.userid.value=="") {
			alert("Choose the RM User Id");
			return false;		
		}  else {
		 showhidden(objId);
		 httpObject = getHTTPObject();
		 if (httpObject != null) {
			
			urlpath="rmpasswordlist.php?rmuser="+document.forms.passwordtrack.userid.value;		
			
			httpObject.open("GET", uncache(urlpath), true);
			httpObject.send(null);
			httpObject.onreadystatechange = function() {
								 
				if(httpObject.readyState == 4){
					document.getElementById(objId).innerHTML=httpObject.responseText;
				}
			}
		}
		}
	 }
	 catch (e)
	 {
			 alert(e);
	 }
		
	 return false;
}

function paging_ajax(objId,rmuserid,page){
	 try
	 {
		showhidden(objId);
		 httpObject = getHTTPObject();
		 if (httpObject != null) {
			
			urlpath="rmpasswordlist.php?rmuser="+rmuserid+"&start="+page;		
			
			httpObject.open("GET", uncache(urlpath), true);
			httpObject.send(null);
			httpObject.onreadystatechange = function() {
								 
				if(httpObject.readyState == 4){
					document.getElementById(objId).innerHTML=httpObject.responseText;
				}
			}
		}
	 }
	 catch (e)
	 {
			 alert(e);
	 }
		
	 return false;
}
function showhidden(id){
	if(document.getElementById(id)){
		 document.getElementById(id).innerHTML="Loading...";
	}
}

function showzonalmem(){
var httpObjects;
	if(httpObjects.readyState == 4){
		alert(httpObjects.responseText);
	    document.getElementById('passwordlist').innerHTML=httpObjects.responseText;
	}
}

function deleteRecord(objId){
var chkval ="";
 var num_checkboxes = document.forms[0].elements.length;  
var rmuser = document.getElementById("rmuser").value;
 try {
	for(i = 0; i < num_checkboxes; i++)  {  
	  if(document.forms[0].elements[i].type == 'checkbox')  {   
        if(document.forms[0].elements[i].checked == true ){
			if(chkval==""){ 
			   chkval=document.forms[0].elements[i].value;
		    }else{ 
			  chkval=chkval+"~"+document.forms[0].elements[i].value;
		   }
		}
	
     }  
  } 

  if(chkval == "") {alert("Please Select MatriId"); return false;}
		 showhidden(objId);
		
		 httpObject = getHTTPObject();
		 if (httpObject != null) {
			
			urlpath="rmdelete.php?rmids="+chkval+"&rmuser="+rmuser;		
			
			httpObject.open("GET", uncache(urlpath), true);
			httpObject.send(null);
			httpObject.onreadystatechange = function() {
								 
				if(httpObject.readyState == 4){ //alert(document.getElementById('karthik').innerHTML);
				//document.getElementById('karthik').style.display='none';
				document.getElementById('disp').style.display='block';
 					document.getElementById('karthik').innerHTML=httpObject.responseText;
				}
			}
		}
		
	 }
	 catch (e)
	 {
			 alert(e);
	 }
		
	 return false;
}