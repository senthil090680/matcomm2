function UpdateAccess(accesss,matriid)
{
  var xmlHttp = getXMLHttp();
 
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      //alert(xmlHttp.responseText);
      HandleResponse(xmlHttp.responseText,matriid);
    }
  }

  xmlHttp.open("GET", accesss, true);
  xmlHttp.send(null);
}


function getXMLHttp()
{
  var xmlHttp

  try
  {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    //Internet Explorer
    try
    {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e)
      {
        alert("Your browser does not support AJAX!")
        return false;
      }
    }
  }
  return xmlHttp;
}

function HandleResponse(response,matriid)
{ 
  var msg_access='';
  if(response==0) {
	msg_access="Update Faillure on "+matriid+" Id.<br><br> <a href='javascript:location.reload(true)'>  Back</a>";
	head = "Conversion";
  }

  if(response==1) {
	msg_access="Successfully Updated on "+matriid+" Id.<br><br> <a href='javascript:location.reload(true)'>Back</a>";
	head = "Conversion";
  }
  if(response==2) {
	msg_access="Update Faillure on "+matriid+" Id. ("+matriid+" yet to assigned to RM)<br><br> <a href='javascript:location.reload(true)'>Back</a>";
	head = "Conversion";
  }
  if(response==3) {
	msg_access="Update Faillure on "+matriid+" Id. (Assigned RM Email Id is Empty)<br><br> <a href='javascript:location.reload(true)'>Back</a>";
	head = "Conversion";
  }
  if(response==4) {
	msg_access="Update Faillure on "+matriid+" Id. (Member Email Id is Empty)<br><br> <a href='javascript:location.reload(true)'>Back</a>";
	head = "Conversion";
  }
   document.getElementById('rmaccessarea1').style.display= "block";
   document.getElementById('allvalue').style.display= "none";
   document.getElementById('rmaccessarea2').innerHTML= head;
   document.getElementById('rmaccessarea').innerHTML = msg_access;


}

