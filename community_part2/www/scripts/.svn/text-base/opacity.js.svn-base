var lpos;
function llcom()
{
	//lpos=document.body.clientWidth/2 - parseInt(document.getElementById('lightpic').style.width)/2;
	lpos=document.body.clientWidth/2 - (570)/2;
	var htp=document.getElementById('maincontainer').offsetHeight;
	if(navigator.appName=="Netscape")
		{ 
			document.getElementById('fade').style.width=document.body.offsetWidth+'px';
			document.getElementById('fade').style.height=document.body.offsetHeight+125+'px';
		}
	else {
	document.getElementById('fade').style.width=document.body.offsetWidth-24+'px';
	document.getElementById('fade').style.height=document.body.scrollHeight+'px';
	}
}
function ll()
{
	//lpos=document.body.clientWidth/2 - parseInt(document.getElementById('div_box0').style.width)/2;
	lpos=document.body.clientWidth/2 - (570)/2;
	var htp=document.getElementById('maincontainer').offsetHeight;
	if(navigator.appName=="Netscape")
		{ 
			document.getElementById('fade').style.width=document.body.offsetWidth+'px';
			document.getElementById('fade').style.height=document.body.offsetHeight+125+'px';
		}
	else {
	document.getElementById('fade').style.width=document.body.offsetWidth-24+'px';
	document.getElementById('fade').style.height=document.body.scrollHeight+'px';
	}
}
function llMsg(globaldivid)
{
	//lpos=document.body.clientWidth/2 - parseInt(document.getElementById(globaldivid).style.width)/2;
	lpos=document.body.clientWidth/2 - (570)/2;
	
	if(navigator.appName=="Netscape")
		{ 
			document.getElementById('fade').style.width=document.body.offsetWidth+'px';
			document.getElementById('fade').style.height=document.body.offsetHeight+125+'px';
		}
	else {
	document.getElementById('fade').style.width=document.body.offsetWidth-24+'px';
	document.getElementById('fade').style.height=document.body.scrollHeight+'px';
	}
    
}
var ns = (navigator.appName.indexOf("Netscape") != -1);
var d = document;
function floatdiv(id, sx, sy)
{
	var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	if(d.layers)el.style=el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};

	el.floatIt=function()
	{
		var pX, pY;
		pX = (this.sx >= 0) ? 0 : ns ? innerWidth :
		document.documentElement && document.documentElement.clientWidth ?
		document.documentElement.clientWidth : document.body.clientWidth;
		pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ?
		document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0)
		pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ?
		document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/8;
		this.sP(this.cx, this.cy);
		setTimeout(this.id + "_obj.floatIt()", 1);
	}
	return el;
}