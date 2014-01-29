window.onbeforeunload = function (event) {
var alert_text = rettxt();
	var browser=navigator.appName;
	var bAgt = navigator.userAgent.toLowerCase();
	var is_opr = (bAgt.indexOf("opera") != -1);
	var is_msie = (bAgt.indexOf("msie") != -1) && document.all && !is_opr;
	var is_msie5 = (bAgt.indexOf("msie 5") != -1) && document.all && !is_opr;

	if(is_msie || is_msie5 ||!event)
	{event=window.event;}

	if(event)
	{
		if(is_msie || is_msie5)
		{event.returnValue=alert_text;}
		return alert_text;
	}
}


function rettxt()
{
	if (bflag==0)
	{var txt="Your chat has been closed.";}
	else
	{var txt="You successfully block this member.";}
	return txt
}

window.onunload =function ()
{
	if(bflag==0)
	{
		window.opener.addclosed(rpid);
		window.opener.document.getElementById(matid).innerHTML="<a href=\"javascript:openchat('"+matid+"','"+evid+"')\" class='linktxt'>Chat</a>";
	}
}