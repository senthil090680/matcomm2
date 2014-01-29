//var imgpath=DOMAINARRAY['domainnameimgs'];
var lastrequesturl="";var incdiv="";var opstate=0;var newdiv_width;var newdiv_height;var winh;var over;var overdiv;var dheight=0;var topedge;var content="";var fade_recal_obj;var inf_recal_obj;
var user_maindiv;var user_fdivname;var user_dispdiv;var user_dispdivw;var user_dispdivh;var user_frmname;var user_url;var user_sfile;var user_dispcontent;var user_method;var user_updatefun;var optotmsg;var inclfun="";var ajobj_new=null;var inf_ajobj=null;
var tout;var acount=0;var inf_acount=0;var giveReqlink = '';

var ie4=document.all
var ns6=document.getElementById&&!document.all

var is_IE=navigator.appVersion.toLowerCase().indexOf('msie');
var is_IE7=false;
if (is_IE!=-1){var ie_ver=navigator.appVersion.substr(is_IE+5,1);if(ie_ver>=7 && ie_ver<8){is_IE7=true;}}
var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;  
var is_safari = navigator.userAgent.toLowerCase().indexOf('safari') > -1; 
var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1; 
var is_konqueror = navigator.userAgent.toLowerCase().indexOf('konqueror') > -1; 
var is_apple= navigator.userAgent.toLowerCase().indexOf('applewebkit') > -1; 

function iecompattest(){return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body}

function dhidebanner()
{
	if($('bannerdiv')){$('bannerdiv').style.display="none";}
	if($('logoutbannerdiv')){$('logoutbannerdiv').style.display="none";}
	if($('highresbannerdiv')){$('highresbannerdiv').style.display="none";}
}

function dshowbanner()
{
	if($('bannerdiv')){$('bannerdiv').style.display="block";}
	if($('logoutbannerdiv')){$('logoutbannerdiv').style.display="block";}
	if($('highresbannerdiv')){$('highresbannerdiv').style.display="block";}
}

function fade(maindiv,fdivname,dispdiv,dispdivw,dispdivh,frmname,url,sfile,dispcontent,method,updatefun)
{
try{ 
if(wload==1){
		if(dispcontent=="" || dispcontent==null)
		{dispcontent='dispcontent';}
		user_maindiv=maindiv;user_fdivname=fdivname;user_dispdiv=dispdiv;user_dispdivw=dispdivw;user_dispdivh=dispdivh;user_frmname=frmname;user_url=url;user_sfile=sfile;user_dispcontent=dispcontent;user_method=method;user_updatefun=updatefun;
		dheight=dispdivh;
		
		hideSelectBoxes();
		dhidebanner();

		var newdiv= document.createElement('div');
		 newdiv.setAttribute("id",'fadediv');
		 newdiv.className="fadediv";
		 newdiv.style.display='block';
		 
		 if( document.body && ( document.body.scrollWidth || document.body.scrollHeight ) ) 
		{newdiv_width = document.body.scrollWidth+'px';newdiv_height = document.body.scrollHeight+'px';}
		 else if( document.body.offsetWidth ) 
		{
		 newdiv_width = document.body.offsetWidth+'px';
		 newdiv_height= document.body.offsetHeight+'px';    
		 } else 
		{newdiv_width='100%';newdiv_height='100%';}

		newdiv.style.width=newdiv_width;
		newdiv.style.height=newdiv_height;

		document.body.appendChild(newdiv)       

		newdiv.style.top=document.body.offsetTop;
		newdiv.style.left=document.body.offsetLeft;

		 fade1(dispdiv,dispdivw,dispdivh,frmname,url,sfile,dispcontent,method,updatefun);
  }
}
	catch(e) { alert(e); }
}

function confing_url(url)
{
	if(url.indexOf("?")==-1){url=url+"?trand="+genNumbers();}else{url=url+"&trand="+genNumbers();}return url;
}

function fade1(dispdiv,dispdivw,dheight,frmname,url,sfile,dispcontent,method,updatefun)
{
	try{

		over=$('fadediv');
		overdiv=document.createElement('div');
		overdiv.setAttribute("id",dispdiv);
		overdiv.className="dispdiv";
		overdiv.style.width=dispdivw+"px";
		document.body.appendChild(overdiv);
		
		content="<div id='"+dispcontent+"' style='background-color:white;overflow:auto;width:"+(parseInt(dispdivw)-25)+"' class='smalltxt' ><center><img src='http://"+imgpath+"/bmimages/loading-icon.gif' border='0'></center></div>";
		optotmsg="<table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr><td valign='top'><div class='opa'><img src='http://"+imgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></div></td><td valign='top' background='http://"+imgpath+"/bmimages/pop-top-tile.gif' width='"+parseInt(dispdivw-22)+"' height='11'><img src='http://"+imgpath+"/bmimages/trans.gif' width='"+parseInt(dispdivw-22)+"' height='11'></td><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%' style='padding-bottom:20px;'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:;\" onclick=\"closediv('"+dispdiv+"','"+frmname+"','"+sfile+"','"+updatefun+"','"+dispcontent+"')\" style='cursor:ponter'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'>"+content+"</td><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+imgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>	<td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";
		overdiv.innerHTML="<table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr><td valign='top'><div class='opa'><img src='http://"+imgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></div></td><td valign='top' background='http://"+imgpath+"/bmimages/pop-top-tile.gif' width='"+parseInt(dispdivw-22)+"' height='11'><img src='http://"+imgpath+"/bmimages/trans.gif' width='"+parseInt(dispdivw-22)+"' height='11'></td><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%' style='padding-bottom:20px;'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:;\" onclick=\"load_close('"+dispdiv+"','"+frmname+"','"+sfile+"','"+updatefun+"','"+dispcontent+"')\" style='cursor:ponter'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'><div id='"+dispcontent+"'><center><img src='http://"+imgpath+"/bmimages/loading-icon.gif' border='0'></center></div></td><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+dispdivw+"'><tr><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+imgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>	<td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";
		overdiv.innerHTML=optotmsg;
		overdiv.style.display='block';

		winh=window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
		overdiv.style.left=(document.body.offsetWidth-dispdivw)/2+"px";
		overdiv.style.top=topedge+parseInt(winh/4)+"px";

		if(url!=null && url!="")
		{
			lastrequesturl=url;
			url=confing_url(url)
	
			if(method=="POST")
			{
				acount=0;
				ajobj_new=createajax_opac();
				MakePostRequest_opac(url,parameters,"storeContents",ajobj_new);
			}
			else
			{
				acount=0;
				ajobj_new=createajax_opac();
				MakeGetRequest_opac(url,"storeContents",ajobj_new);	
			}
			
			if (is_firefox==false){fade_recal_obj = setTimeout("fade_callbackurl();",30000);}
		}
	}
	catch(e) { alert(e); }
}

function storeContents()
{	
try{
	if(window.opera || is_chrome==true || is_safari==true || is_konqueror==true || is_apple==true || is_IE7==true || is_firefox==true)
	{
		if (ajobj_new.readyState == 4) 
		{	
			clearTimeout(fade_recal_obj);
			if (ajobj_new.status == 200) 
			{
			if(ajobj_new.responseText!=null && ajobj_new.responseText!="")
			{overdiv.innerHTML="";overdiv.innerHTML=optotmsg;$(user_dispcontent).innerHTML=ajobj_new.responseText;
			incdiv=$(user_dispcontent);divheight(incdiv.offsetHeight);}
			}	 
		}
	}
	else
	{
		if (ajobj_new.readyState == 4 && acount>3) 
		{
			clearTimeout(fade_recal_obj);acount=0;
			if (ajobj_new.status == 200) 
			{
				if(ajobj_new.responseText!=null && ajobj_new.responseText!="")
				{
				overdiv.innerHTML="";overdiv.innerHTML=optotmsg;
				$(user_dispcontent).innerHTML=ajobj_new.responseText;
				incdiv=$(user_dispcontent);divheight(incdiv.offsetHeight);
				}
			} 
	   }
	   acount++;
	}
 } catch (e) {}
}



/*main fade call back start*/
function fade_callbackurl() {ajobj_new.abort();fade_recallobj();}

function fade_recallobj()
{
	//alert("call");
	clearTimeout(fade_recal_obj);
	$(user_dispcontent).innerHTML="&nbsp;&nbsp;<font color='#ff0000'> Request timed out.</font> <a href='javascript:fade_callobj_back();' class='smalltxt clr1'>Click here</a> <font color='#000000'>to try again.</font><br><br> &nbsp;&nbsp;If you continue to face the problem there could be an issue with your <br>&nbsp;&nbsp;Internet connection.";
	acount=0;
	tout=createajax_opac();var tourl=user_url.indexOf('?');
	if(tourl!=-1)	{toout_url=user_url.substr(0,user_url.indexOf('?'));toout_url=toout_url.replace('http://','');}
	else
	{toout_url=user_url.replace('http://','');}

	var touturl=confing_url("/iptracking.php?fname="+toout_url);
	MakeGetRequest_opac(touturl," ",tout);	
}

function fade_callobj_back()
{
	$(user_dispcontent).innerHTML="<center><img src='http://"+imgpath+"/bmimages/loading-icon.gif' border='0'></center>";
	if(user_method=="POST")
	{var url=confing_url(user_url);MakePostRequest_opac(url,parameters,storeContents,ajobj_new);}
	else
	{var url=confing_url(user_url);MakeGetRequest_opac(url,"storeContents",ajobj_new);}

	fade_recal_obj = setTimeout(function() {ajobj_new.abort();fade_recallobj();},30000);
}
/*main fade call back start*/

function removeDiv(e) {e=$(e);e.parentNode.removeChild(e);}

function closediv(dispdiv,frmname,sfile,updatefun,dispcontent)
{
	try{
		if(giveReqlink == 'Y') giveReqlink = '';
		var d2=$('fadediv');
		var d3=$(user_dispdiv);
		var d4=$(user_dispcontent);
		d4.innerHTML="";
		removeDiv(user_dispcontent);
		document.body.removeChild(d3);
		removeDiv('fadediv');
		if(user_updatefun!=null && user_updatefun!="")
		{eval(user_updatefun+"()");}
		content="";
		dshowbanner();
		showSelectBoxes();
	}
	catch(e) { alert(e); }
}

function close_div()
{
try{
	if(giveReqlink == 'Y') giveReqlink = '';
	var d2=$('fadediv');
	var d3=$(user_dispdiv);
	var d4=$(user_dispcontent);
	d4.innerHTML="";
	removeDiv(user_dispcontent);
	document.body.removeChild(d3);
	removeDiv('fadediv');
	if(user_updatefun!=null && user_updatefun!=""){eval(user_updatefun+"()");}
	dshowbanner();
	showSelectBoxes();
  }
	catch(e) { alert(e); }
}

function load_close()
{
try{
	var d2=$('fadediv');
	var d3=$(user_dispdiv);
	document.body.removeChild(d3);
	removeDiv('fadediv');
	if(user_updatefun!=null && user_updatefun!=""){eval(user_updatefun+"()");}
	dshowbanner();
	showSelectBoxes();
  }
	catch(e) { alert(e); }
}

function divheight(h)
{
	var seth=h;
	if (dheight!=0)
	{
		seth=dheight;
		if(winh>seth){incdiv.style.height=dheight+"px";overdiv.style.top=topedge+(winh-seth)/4+"px";}
		if(seth>winh){overdiv.style.top=topedge+25+"px";}	
	}
	else
	{
		seth=overdiv.offsetHeight;
		if(winh>seth){overdiv.style.top=topedge+(winh-seth)/3+"px";}
		else if(seth>winh){overdiv.style.top=topedge+25+"px";}
	}
}

var infdispdivw;var infwinh; var cal_infurl;

function innerfade(infurl,infwidth,infclosefun)
{
	hideSelectBoxes();
	inclfun=infclosefun;
	infdispdivw=infwidth;
	cal_infurl=infurl;
	var exfade=document.getElementById(user_dispdiv);
	var infdiv= document.createElement('div');
	infdiv.setAttribute("id",'infdivover');
	infdiv.className="fadediv";
	
	infdiv.style.width = exfade.offsetWidth+'px';
	infdiv.style.height= exfade.offsetHeight+'px';    
	exfade.appendChild(infdiv)
	infdiv.style.display='block';
	
	var infdisp= document.createElement('div');
	infdisp.setAttribute("id",'infdiv');
	infdisp.className="dispdiv";
	
	document.body.appendChild(infdisp)
	infwinh=window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
	infdisp.style.left=(document.body.offsetWidth- infwidth)/2+"px";
	infdisp.style.top=topedge+parseInt(infwinh/4)+"px";
	infdisp.style.width =infwidth+'px';
	
	infdisp.innerHTML="<center><img src='http://"+imgpath+"/bmimages/loading-icon.gif' border='0'></center>";
	infdisp.style.display='block';
	inf_ajobj=createajax_opac();

	var url=confing_url(infurl);
	MakeGetRequest_opac(url,infContents,inf_ajobj);
	inf_recal_obj = setTimeout("inf_callbackurl();",30000);
}

/*inf fade call back start*/
function inf_callbackurl() {inf_ajobj.abort();inf_recallobj();}

function inf_recallobj()
{
	$('infdiv').innerHTML="<table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><div class='opa'><img src='http://"+imgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></div></td><td valign='top' background='http://"+imgpath+"/bmimages/pop-top-tile.gif' width='"+parseInt(infdispdivw-22)+"' height='11'><img src='http://"+imgpath+"/bmimages/trans.gif' width='"+parseInt(infdispdivw-22)+"' height='11'></td><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%' style='padding-bottom:20px;'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:infclose()\" style='cursor:pointer'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'><font class='smalltxt'>&nbsp;&nbsp;<font color='#ff0000'> Request timed out.</font> <a href='javascript:fade_callobj_back();' class='smalltxt clr1'>Click here</a> <font color='#000000'>to try again.</font><br><br> &nbsp;&nbsp;If you continue to face the problem there could be an issue with your <br>&nbsp;&nbsp;Internet connection.</font></td><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+imgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>	<td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";
	inf_acount=0;
}

function inf_callobj_back()
{
	$('infdiv').innerHTML="<table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><div class='opa'><img src='http://"+imgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></div></td><td valign='top' background='http://"+imgpath+"/bmimages/pop-top-tile.gif' width='"+parseInt(infdispdivw-22)+"' height='11'><img src='http://"+imgpath+"/bmimages/trans.gif' width='"+parseInt(infdispdivw-22)+"' height='11'></td><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%' style='padding-bottom:20px;'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:infclose()\" style='cursor:pointer'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'><center><img src='http://"+imgpath+"/bmimages/loading-icon.gif' border='0'></center></td><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+imgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>	<td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";

	var url=confing_url(cal_infurl);MakeGetRequest_opac(url,"infContents",inf_ajobj);
	inf_recal_obj = setTimeout("inf_callbackurl();",30000);
}
/*inf fade call back start*/

function infContents()
{
	if(window.opera || is_chrome==true || is_safari==true || is_konqueror==true || is_apple==true || is_IE7==true || is_firefox==true)
	{
		if (inf_ajobj.readyState == 4) 
		{
		 clearTimeout(inf_recal_obj);
		 if (inf_ajobj.status == 200) 
		{
			 inf_acount=0;
			if(inf_ajobj.responseText!=null && inf_ajobj.responseText!="")
			{
			$('infdiv').innerHTML="<table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><div class='opa'><img src='http://"+imgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></div></td><td valign='top' background='http://"+imgpath+"/bmimages/pop-top-tile.gif' width='"+parseInt(infdispdivw-22)+"' height='11'><img src='http://"+imgpath+"/bmimages/trans.gif' width='"+parseInt(infdispdivw-22)+"' height='11'></td><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%' style='padding-bottom:20px;'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:infclose()\" style='cursor:pointer'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'><div id='infcont'>"+inf_ajobj.responseText+"</div></td><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+imgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>	<td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";
			infdivheight($('infdiv').offsetHeight,infwinh);
			}
		} 
			 
	   }

	}
	else
	{
		if (inf_ajobj.readyState == 4 && inf_acount>3) 
		{
		 clearTimeout(inf_recal_obj);
		 if (inf_ajobj.status == 200) 
		{
			 inf_acount=0;
			if(inf_ajobj.responseText!=null && inf_ajobj.responseText!="")
			{
			$('infdiv').innerHTML="<table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><div class='opa'><img src='http://"+imgpath+"/bmimages/pop-top-left-crv.gif' width='11' height='11'></div></td><td valign='top' background='http://"+imgpath+"/bmimages/pop-top-tile.gif' width='"+parseInt(infdispdivw-22)+"' height='11'><img src='http://"+imgpath+"/bmimages/trans.gif' width='"+parseInt(infdispdivw-22)+"' height='11'></td><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-top-right-crv.gif' width='11' height='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"' bgcolor='white'><tr><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-left-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td><td valign='top' width='100%' style='padding-bottom:20px;'><div style='float: right; text-align: middle;padding-top:5px;padding-right:5px;padding-bottom:5px;'><a href=\"javascript:infclose()\" style='cursor:pointer'><img src='http://"+imgpath+"/bmimages/close-icon.gif' width='12' height='12' border='0'></a></div><br clear='all'><div id='infcont'>"+inf_ajobj.responseText+"</div></td><td valign='top' width='11' background='http://"+imgpath+"/bmimages/pop-right-tile.gif'><img src='http://"+imgpath+"/bmimages/trans.gif' width='11'></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='"+infdispdivw+"'><tr><td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-left-crv.gif' width='11' height='11'></td>	<td valign='top' background='http://"+imgpath+"/bmimages/pop-bot-tile.gif' width='100%' height='11'></td>	<td valign='top'><img src='http://"+imgpath+"/bmimages/pop-bot-right-crv.gif' width='11' height='11'></td></tr></table>";
			infdivheight($('infdiv').offsetHeight,infwinh);
			}
		} 
			 
	   }
		inf_acount++;
		}
}

function infdivheight(h,infwin)
{var seth=h;if(infwin>seth){$('infdiv').style.top=topedge+(infwin-seth)/3+"px";}else if(seth>infwin){$('infdiv').style.top=topedge+25+"px";}}
function infclose(){removeDiv('infdivover');removeDiv('infdiv');showSelectBoxes();if(inclfun!=null && inclfun!=""){eval(inclfun+"()");}}
function chngheight(divid,divheight){$(divid).style.height=divheight+"px";}
function IFheight(divid,divheight){$(divid).height=divheight+"px";}
function loadicon(ifraobj){$(ifraobj).style['visibility'] = 'visible';}