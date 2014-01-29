
<script>
var xhr=null; 
function vm_createajax()
{
				if (window.XMLHttpRequest) {
					return new XMLHttpRequest();
				} else if(window.ActiveXObject) {
					return new ActiveXObject("Microsoft.XMLHTTP");
				} else {
					alert('Status: Cound not create XmlHttpRequest Object.  Consider upgrading your browser.');
				}
}

xhr=vm_createajax();
function AjaxCall(evid,opposite_gender)
{   		
	if (xhr.readyState == 4 || xhr.readyState == 0) 
	{
	xhr.open('GET', "getdata.php?evid="+evid+"&opposite_gender="+opposite_gender, true);
	xhr.onreadystatechange =launchmsg;
	xhr.send(null);
	}

}

function launchmsg()
{
	if(xhr.readyState  == 4)
	{
		if(xhr.status  ==200) { //alert(xhr.responseText);
		test(xhr.responseText);}
		else 
		{alert("Error code " + xhr.status);}
	}
}

function test(dataobj) 
{
	if(dataobj!=null && dataobj!="")
	alert(dataobj); 
}
AjaxCall("8","male");
</script>
