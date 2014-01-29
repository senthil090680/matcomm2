
var expancount;
var shcount;
var browserName=navigator.appName;
var url;
var hrightnav,spdivh;
url=location.href;
var findstr=url.indexOf('www.');
if(findstr == -1)
{
if (browserName=="Netscape") {expancount=21;shcount=45;} 
}
else
{if (browserName=="Netscape") {expancount=36;shcount=45;} }

if (browserName=="Microsoft Internet Explorer")  {expancount=61;shcount=61;} 

function makeequal1(id1,id2)
{
	if (document.getElementById(id1))
	{
	var div1h=document.getElementById(id1).offsetHeight;
	var div2h=document.getElementById(id2).offsetHeight;
	spdivh=$('spacedivmid').offsetHeight;
	if(div1h > div2h){
		document.getElementById('spacedivmid').style.height=document.getElementById('spacedivmid').offsetHeight + (div1h - div2h)+expancount;	
	}
	else if(div1h < div2h){
		document.getElementById(id1).style.height=div1h+(div2h - div1h)-shcount;
	}
	else{
			document.getElementById(id1).style.height=div1h+(div2h - div1h);
		}
	}
}