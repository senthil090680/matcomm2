var ie4=document.all
var ns6=document.getElementById&&!document.all
var horizontaloffset=13,verticaloffset=12,iconfirst = 1,vurl,purl,hurl,murl,veriprourl,inturl,viurl,vhref,phref,hhref,mhref,veriprohref,inthref,vihref,videohref,vclass,pclass,hclass,mclass,veriproclass,intclass,viclass,vocurl,pocurl,hocurl,mocurl,veriproocurl,intocurl,viocurl,dhurl,icw,ich; 
var imgdomainurl=new Array(); 
imgdomainurl["M"]="tamil";imgdomainurl["T"]="telugu";imgdomainurl["E"]="kerala";imgdomainurl["K"]="kannada";imgdomainurl["G"]="gujarati";imgdomainurl["R"]="marathi";imgdomainurl["B"]="bengali";imgdomainurl["P"]="punjabi";imgdomainurl["S"]="sindhi";imgdomainurl["H"]="hindi";imgdomainurl["Y"]="oriya";imgdomainurl["C"]="parsi";imgdomainurl["A"]="assamese";imgdomainurl["D"]="marwadi";imgdomainurl["U"]="urdu";
var memberid=HGetmemberid();  
function HGetmemberid(){
	var cookary,cmemid;
	if(GetCookie("LOGININFO")!=null && GetCookie("LOGININFO")!=""){
		cookary=GetCookie("LOGININFO").split("^");
		cmemid = cookary[0];
	}else {	cmemid = ""; }
	return cmemid;
}
function getpos(what, offsettype){
	var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
	var parentEl=what.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}
function fadeurlreplace(url,scpurl,fdw,fdh,mdivid){
 	if(giveReqlink == ''){
		url = url+"&innerfade=false";
		var fadefun = 'fade("rndcorner","fdivname","dispdiv","fdivw","fdivh","","fadeurl","fadesurl","dispcontent","","")';
	}
	else {url = url+"&innerfade=true";
		var fadefun = 'innerfade("fadeurl","fdivw","")';
	} 
	var resfade = fadefun.replace(/fadeurl/g,url);
	if(mdivid!=null && mdivid!="") resfade = resfade.replace(/rndcorner/g,mdivid);
	else resfade = resfade.replace(/rndcorner/g,"rndcorner");

	if(scpurl!=null && scpurl!="") resfade = resfade.replace(/fadesurl/g,scpurl);
	else resfade = resfade.replace(/fadesurl/g,"");

	if(fdw!=null && fdw!="") resfade = resfade.replace(/fdivw/g,fdw);
	else resfade = resfade.replace(/fdivw/g,"500");

	if(fdh!=null && fdh!="") resfade = resfade.replace(/fdivh/g,fdh);
	else resfade = resfade.replace(/fdivh/g,"");

	return resfade;
}
function iconview(parent,child,domainurl,imgpathurl,viewid,phoneVal,horoVal,matrirefVal,veriprofileVal,voiceVal,intreceivedVal,videoVal,mfdivid){
try{
if(wload==1){
		var p = $(parent);
		var idiv = document.createElement('div');
		var icname;
		//var imgdurl=imgdomainurl[viewid.substring(0,1)];
		var imgdurl=DOMAINARRAY['domainnamebmimg'];
		idiv.setAttribute("id",child);
		idiv.className="iconclass";
		idiv.style.width="168px";
		//document.body.appendChild(idiv);
		$('maincontainer').appendChild(idiv);
		var c = $(child);
		  p["phone_parent"]     = p.id;
		  c["phone_parent"]     = p.id;
		  p["phone_child"]      = c.id;
		  c["phone_child"]      = c.id;
		  p["phone_position"]   = "x";
		  c["phone_position"]   = "x";
		  var hrefurl="javascript:;";
		  if(phoneVal=="Y" || phoneVal=="PY"){
			 pocurl = fadeurlreplace('/assuredcontact/assuredphoneverifywork.php?ID='+viewid,'','580','',''+mfdivid+'');
			 purl = '<div style="padding-top:0px;">';
			 if(phoneVal=="PY"){
				purl+='<img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/protect-icon.gif" width="9" height="9" style="vertical-align:middle" border="0" hspace="5" /alt="" > ';
			 }
			 purl+='<a href=\''+hrefurl+'\' onClick=\''+pocurl+'\' class=\'clr1\'>View Phone Number</a></div>';
			 pclass = '<div class="useracticonsimgs phone"><a href=\''+hrefurl+'\' onClick=\''+pocurl+'\' class=\'clr1 pntr\'><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="20" height="16" border="0"/></a></div>';
		  }
		  if(phoneVal=="N"){
			 pocurl = fadeurlreplace('/request/bmrequestfor.php?OID='+viewid+'&RID=3&rand='+genNumbers(),'','','',''+mfdivid+'');
			 if(memberid){
				 phref = 'href=\''+hrefurl+'\' onClick=\''+pocurl+'\'';
			 }else{
				phref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=rpn&fname=/profiledetail/viewprofile.php?id='+viewid+'\'';
			 }
			 if(memberid!=viewid) {
				purl = '<div style="padding-top:0px;"><a '+phref+' class="clr1">Request Phone Number</a></div>';
				pclass = '<div class="useracticonsimgs pphone"><a '+phref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="20" height="16" border="0"/></a></div>';
			 }else{
				purl=''; pclass=''; }
		  }
		  if(horoVal.substring(1,2)=="Y"){
			 hurl='<div style="padding-top:2px;">';
			 hocurl = 'window.open("http://'+imgdurl+'/cgi-bin/horoview.php?ID='+viewid+'&PID='+viewid+'","horowindow","directories=no,width=720,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=295,left=200")';
			 if(horoVal.substring(2,3)=="P"){
				hurl+='<img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/protect-icon.gif" width="9" height="9" style="vertical-align:middle" border="0" hspace="5" /alt="" > ';
				if(memberid){
					//hocurl = fadeurlreplace('/horoscope/fileserverhoroview.php?protect=1&ID='+viewid+'&PID='+viewid,'','750','','horodiv');
					hurl+='<a href=\'javascript:;\' onClick=\''+hocurl+'\' class="clr1">View Horoscope</a></div>';
					dhurl='<a href=\'javascript:;\' onClick=\''+hocurl+'\' class="clr1 pntr">';
				}
				else{
					hurl+='<a href=\'/login/loginform.php?mid='+viewid+'&frompg=vh&fname=/profiledetail/viewprofile.php?id='+viewid+'\' class="clr1">View Horoscope</a></div>';
					dhurl='<a href=\'/login/loginform.php?mid='+viewid+'&frompg=vh&fname=/profiledetail/viewprofile.php?id='+viewid+'\' class="clr1 pntr">';
				}
			 }else{
				 //hocurl = fadeurlreplace('/horoscope/fileserverhoroview.php?ID='+viewid+'&PID='+viewid,'','750','','horodiv');
				 hurl+='<a href=\'javascript:;\' onClick=\''+hocurl+'\' class="clr1">View Horoscope</a></div>';
				 dhurl='<a href=\'javascript:;\' onClick=\''+hocurl+'\' class="clr1 pntr">';
			 }
			 if(horoVal.substring(0,1)=="G")
				hclass = '<div class="useracticonsimgs horogen">'+dhurl+'<img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="18" height="16" border="0"/></a></div>';
			 else
				hclass = '<div class="useracticonsimgs horo">'+dhurl+'<img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="18" height="14" border="0"/></a></div>';
		  }
		  if(horoVal.substring(1,2)=="N"){
			 hocurl = fadeurlreplace('/request/bmrequestfor.php?OID='+viewid+'&RID=2&rand='+genNumbers(),'','','',''+mfdivid+'');
			 if(memberid){
				 hhref = 'href=\''+hrefurl+'\' onClick=\''+hocurl+'\'';
			 }else{
				hhref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=rh&fname=/profiledetail/viewprofile.php?id='+viewid+'\'';
			 }
			if(memberid!=viewid) {
			 hurl = '<div style="padding-top:2px;"><a '+hhref+' class="clr1">Request Horoscope</a></div>';
			 if(horoVal.substring(0,1)=="G")
				hclass = '<div class="useracticonsimgs phorogen"><a '+hhref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="18" height="16" border="0"/></a></div>';
			 else
				hclass = '<div class="useracticonsimgs phoro"><a '+hhref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="18" height="14" border="0"/></a></div>';
			}
			else{ hurl=''; hclass=''; }
		  }
		  if(matrirefVal=="Y"){
			 mocurl = fadeurlreplace('/reference/referenceview.php?matid='+viewid,'','','',''+mfdivid+'');
			 if(memberid){
				 mhref = 'href=\''+hrefurl+'\' onClick=\''+mocurl+'\'';
			 }else{
				mhref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=vr&fname=/profiledetail/viewprofile.php?id='+viewid+'&pge=view1\'';
			 }
			 murl = '<div style="padding: 2px 0px 0px 2px;"><a '+mhref+' class="clr1">View Reference</a></div>';
			 mclass = '<div class="useracticonsimgs matriref"><a '+mhref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="14" height="14" border="0"/></a></div>';
		  }
		  if(matrirefVal=="N"){
			 mocurl = fadeurlreplace('/request/bmrequestreferenceandvoice.php?id='+viewid+'&rid=7&rand='+genNumbers(),'','','',''+mfdivid+'');
			 if(memberid){
				 mhref = 'href=\''+hrefurl+'\' onClick=\''+mocurl+'\'';
			 }else{
				mhref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=rr&fname=/profiledetail/viewprofile.php?id='+viewid+'\'';
			 }
			 if(memberid!=viewid) {
			 murl = '<div style="padding: 2px 0px 0px 2px;"><a '+mhref+' class="clr1">Request Reference</a></div>';
			 mclass = '<div class="useracticonsimgs pmatriref"><a '+mhref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="14" height="14" border="0"/></a></div>';
			 }
			 else{ murl = ''; mclass =''; }
		  }
		  if(veriprofileVal=="Y"){
			 veriproocurl = fadeurlreplace('/veriprofile/veriprofile-view.php?ID='+viewid,'','','',''+mfdivid+'');
			 if(memberid){
				 veriprohref = 'href=\''+hrefurl+'\' onClick=\''+veriproocurl+'\'';
			 }else{
				veriprohref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=vvr&fname=/profiledetail/viewprofile.php?id='+viewid+'&pge=view1\'';
			 }
			 veriprourl = '<div style="padding-top:2px;"><a '+veriprohref+' class="clr1">View Verification</a></div>';
			 veriproclass = '<div class="useracticonsimgs veriprofile"><a '+veriprohref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="16" height="17" border="0"/></a></div>';
		  }
		  if(veriprofileVal=="N"){
			 veriproocurl = fadeurlreplace('/request/bmrequestfor.php?OID='+viewid+'&RID=5&rand='+genNumbers(),'','','',''+mfdivid+'');
			 if(memberid){
				 veriprohref = 'href=\''+hrefurl+'\' onClick=\''+veriproocurl+'\'';
			 }else{
				veriprohref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=rv&fname=/profiledetail/viewprofile.php?id='+viewid+'\'';
			 }
			 if(memberid!=viewid) {
			 veriprourl = '<div style="padding-top:2px;"><a '+veriprohref+' class="clr1">Request Verification</a></div>';
			 veriproclass = '<div class="useracticonsimgs pveriprofile"><a '+veriprohref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="16" height="17" border="0"/></a></div>';
			 //veriproclass = '<div class="useracticonsimgs pveriprofile" style="padding-top:2px;"></div>';
			 }
			 else{ veriprourl = '';	veriproclass =''; }
		  }
		  if(voiceVal=="Y"){
			 vocurl = fadeurlreplace('/voicematrimony/voicepopup.php?ID='+viewid,'','','',''+mfdivid+'');
			 vurl = '<div style="padding-top:2px;height:20px;"><a href=\''+hrefurl+'\' onClick=\''+vocurl+'\' class="clr1">Listen to Voice Profile</a></div>';
			 vclass = '<div class="useracticonsimgs voice"><a href=\''+hrefurl+'\' onClick=\''+vocurl+'\' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="20" height="20" border="0"/></a></div>';
		  }
		  if(voiceVal=="N"){
			 vocurl = fadeurlreplace('/request/bmrequestreferenceandvoice.php?id='+viewid+'&rid=8&rand='+genNumbers(),'','','',''+mfdivid+'');
			 if(memberid){
				 vhref = 'href=\''+hrefurl+'\' onClick=\''+vocurl+'\'';
			 }else{
				vhref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=rvv&fname=/profiledetail/viewprofile.php?id='+viewid+'\'';
			 }
			 if(memberid!=viewid) {
			 vurl = '<div style="padding-top:2px;height:20px;"><a '+vhref+' class="clr1">Request Voice Profile</a></div>';
			 vclass = '<div class="useracticonsimgs pvoice"><a '+vhref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="20" height="20" border="0"/></a></div>';
			 }
			 else{ vurl = ''; vclass =''; }
		  }
		  if(intreceivedVal!="N"){
			 intocurl = fadeurlreplace('/profiledetail/profilenotes.php?ID='+viewid,'','','',''+mfdivid+'');
			 inturl = '<div style="padding-top:0px;"><a href=\''+hrefurl+'\' onClick=\''+intocurl+'\' class="clr1">View Contact History</a></div>';
			 if(intreceivedVal=="IR") { icname = 'intreceived'; icw='18'; ich='15';}
			 if(intreceivedVal=="IS") { icname = 'intsent'; icw='19'; ich='15';}
			 if(intreceivedVal=="MS") { icname = 'msgsent'; icw='19'; ich='12';}
			 if(intreceivedVal=="MR") { icname = 'msgrecd'; icw='19'; ich='12';}
			 if(intreceivedVal=="MP") { icname = 'msgaccept'; icw='20'; ich='15';}
			 if(intreceivedVal=="MD") { icname = 'msgdecline'; icw='20'; ich='15';}
			 intclass = '<div style="padding-top:2px;"><div class="useracticonsimgs '+icname+'"><a href=\''+hrefurl+'\' onClick=\''+intocurl+'\' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="'+icw+'" height="'+ich+'" border="0"/></a></div></div>';
		  }
		  if(intreceivedVal=="N"){ inturl = ''; intclass = '';  }
		  if(videoVal=="Y" || videoVal=="YP"){
			 viocurl = fadeurlreplace('/video/video-view-protect.php?matriId='+viewid,'','550','',''+mfdivid+'');
			  if(memberid){
				 videohref = 'href=\''+hrefurl+'\' onClick=\''+viocurl+'\'';
			 }else{
				videohref = 'href=\'/login/loginform.php?mid='+viewid+'&frompg=vv&fname=/profiledetail/viewprofile.php?id='+viewid+'&pge=view1\'';
			 }
			 viurl = '<div style="padding-top:0px;">';
			 if(videoVal.substring(1,2)=="P")
				  viurl+='<img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/protect-icon.gif" width="9" height="9" style="vertical-align:middle;" border="0"  hspace="5" /alt="" > ';
			 viurl+='<a '+videohref+' class="clr1">View Video</a></div>';
			 viclass = '<div style="padding-top:2px;"><div class="useracticonsimgs video"><a '+videohref+' class="clr1 pntr"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="19" height="11" border="0"/></a></div></div>';
		  }
		  if(videoVal=="N"){ viurl = ''; viclass = '';  }
		  c.innerHTML='<div class="icon-menu1"><div class="icon-menu2 fleft"><div style="width:130px;text-align:right;" class="fleft"><div style="padding: 2px 0px 8px 5px;" class="smalltxt">'+purl+''+hurl+''+murl+''+veriprourl+''+vurl+''+inturl+''+viurl+'</div></div><div class="fleft" style="padding: 2px 0px 8px 5px;"><div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">	  <div>'+pclass+'</div><div style="padding-top:2px;">'+hclass+'</div><div style="padding:2px 0px 0px 2px">'+mclass+'</div><div style="padding-top:2px;">'+veriproclass+'</div><div style="">'+vclass+'</div>'+intclass+''+viclass+'</div></div></div></div></div>';
		 if(iconfirst==1){
			 var left=findPosX(p)-168+p.offsetWidth+horizontaloffset;
			 var top=findPosY(p)-verticaloffset;
			 c.style.position   = "absolute";
			 c.style.top        = top +'px';
             c.style.left       = left+'px';
             c.style.visibility = "visible";
		  }else{
			  c.style.position   = "absolute";
			  c.style.visibility = "hidden";
		  }
		  p.onmouseover = icon_show;
		  p.onmouseout  = icon_hide;
		  c.onmouseover = icon_show;
		  c.onmouseout  = icon_hide;
		}
   }
	catch(e) { alert(e);alert(e.message);alert(e.type);}
}
function icon_show_aux(parent, child){
  var par = $(parent);
  var cld = $(child );
  var left=findPosX(par)-168+par.offsetWidth+horizontaloffset;
  var top=findPosY(par)-verticaloffset;
  cld.style.position   = "absolute";
  cld.style.top        = top +'px';
  cld.style.left       = left+'px';
  cld.style.visibility = "visible";
}
function icon_show(){
  var par = $(this["phone_parent"]);
  var cld = $(this["phone_child" ]);
  icon_show_aux(par.id, cld.id);
  clearTimeout(cld["phone_timeout"]);
}
function icon_hide(){
  var par = $(this["phone_parent"]);
  var cld = $(this["phone_child" ]);
  cld["phone_timeout"] = setTimeout("document.getElementById('"+cld.id+"').style.visibility = 'hidden'", 333);
}
function getdivobj(obj) { 
	if(document.getElementById) { 
		if($(obj)!=null) { return $(obj) } else  { return ""; }
	} else if(document.all) { 
		if(document.all[obj]!=null) { return document.all[obj] } else  { return ""; }
	} 
}
var imgborderwidth=0; 
function PhTravs(which,request,imgpath,fullimgpath,imgcid,imgnavid,currentindex,pgview,bigimgid,opmemid,domainurl,moverchk){
 	var imgconid = $_obj(imgcid);
	var imgnid = $_obj(imgnavid);  
	var flg;
	var imgpathurl = DOMAINARRAY['domainnameimgs']; 

    if( ($_obj('giveReqlink').value != null) && ($_obj('giveReqlink').value != 'undefined') && $_obj('ST_pw').value == '75' && $_obj('ST_ph').value == '75')
		giveReqlink = ($_obj('giveReqlink').value);

	if( ($_obj('ST_pw') != null) && ($_obj('ST_ph') != null) ){
		var ST_pw = $_obj('ST_pw').value;
		var ST_ph = $_obj('ST_ph').value;
	}
	if(arguments[12]!=null) {
		var ST_pw = arguments[12];
		var ST_ph = arguments[12];
	}

	if(opmemid.match("BMC")) flg=1;
	if(request==""){
		numberslide=new Array()
		numberslide = imgpath.split("^");
		bimgary = new Array()
		bimgary = fullimgpath.split("^");
		var imghtml="",pagenavhtml="",imgcount;
		currentindex=(which=="")? 0 : parseInt(which)
		imgcount=eval(currentindex+1);
		var imgL=getpos(imgconid, "left")+80;
		var imgT=getpos(imgconid, "top");
		if(ST_img=="" || ST_img==null) var ST_img="img";
		if(ST_pw=="" || ST_pw==null) var ST_pw="75";
		if(ST_ph=="" || ST_ph==null) var ST_ph="75";
		var mode=(which>="0")? "" : "initial"
		var which=(mode=="initial")? numberslide[0] : numberslide[which]
		var bigimg=(mode=="initial")? bimgary[0] : bimgary[currentindex]
		imghtml='<a href="javascript:;" onClick=\'window.open("'+domainurl+'","","directories=no,width=900,height=750,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0")\' style="cursor: pointer;">';
		if(ST_pw=="75" && moverchk=="Y"){
			imghtml+='<'+ST_img+' src="'+which+'" width="'+ST_pw+'" height="'+ST_ph+'" border="0" onmouseover="overimg(\''+bigimg+'\',\''+bigimgid+'\',\''+imgL+'\',\''+imgT+'\');" onmouseout="overout(\''+bigimgid+'\');">';
		}else if(ST_pw=="75"){
			imghtml+='<'+ST_img+' src="'+which+'" width="'+ST_pw+'" height="'+ST_ph+'" border="0">';
		}else{
			if(($_obj('photo_print').value != null) && ($_obj('photo_print').value != 'undefined') && $_obj('photo_print').value == '1'){
				imghtml+='<div style="width:150px;border:0px;height:150px;background-image:url('+which+')"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" width="'+ST_pw+'" border=0 height="'+ST_ph+'"></div>';				
			}else{
				imghtml+='<'+ST_img+' src="'+which+'" width="'+ST_pw+'" height="'+ST_ph+'" border="0">';
			}		

		}
		imghtml+='</a>';
	}
	else if(request=="RM"){
		var recurl = fadeurlreplace('/request/bmrequestfor.php?OID='+opmemid+'&RID=1&rand='+genNumbers(),'','','','');
		imghtml='<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;"><div style="float:left;">';
		if(flg!=1){
		 if(memberid){
			imghtml+='<a href="javascript:;" onClick=\''+recurl+'\' style="cursor: pointer;">';
		 }else{
			imghtml+='<a href="/login/loginform.php?mid='+opmemid+'&frompg=rp&fname=/profiledetail/viewprofile.php?id='+opmemid+'" style="cursor: pointer;">';
		 }
		}
		if(ST_pw=="150")
			imghtml+='<div class="useracticonsimgs photombig"></div>';
		else
			imghtml+='<div class="useracticonsimgs photorequestm"></div>';
		if(flg!=1)
		imghtml+='</a>';
		imghtml+='</div></div></div>';
	}
	else if(request=="RF"){
		var recurl = fadeurlreplace('/request/bmrequestfor.php?OID='+opmemid+'&RID=1&rand='+genNumbers(),'','','','');
		imghtml='<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;"><div style="float:left;">';
		if(flg!=1){
		 if(memberid){
			imghtml+='<a href="javascript:;" onClick=\''+recurl+'\' style="cursor: pointer;">';
		 }else{
			imghtml+='<a href="/login/loginform.php?mid='+opmemid+'&frompg=rp&fname=/profiledetail/viewprofile.php?id='+opmemid+'" style="cursor: pointer;">';
		 }
		}
		if(ST_pw=="150")
			imghtml+='<div class="useracticonsimgs photofbig"></div>';
		else
			imghtml+='<div class="useracticonsimgs photorequestf"></div>';
		if(flg!=1) imghtml+='</a>';
		imghtml+='</div></div></div>';
	}
	else if(request=="AM"){
		var recurl = '/profiledetail/tools.php?add=photo';
		imghtml='<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;"><div style="float:left;">';
		if(flg!=1)
		imghtml+='<a href="'+recurl+'" style="cursor: pointer;">';
		if(ST_pw=="150")
			imghtml+='<div class="useracticonsimgs photoaddmbig"></div>';
		else
			imghtml+='<div class="useracticonsimgs photorequestm"></div>';
		if(flg!=1) imghtml+='</a>';
		imghtml+='</div></div></div>';
	}
	else if(request=="AF"){
		var recurl = '/profiledetail/tools.php?add=photo';
		imghtml='<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;"><div style="float:left;">';
		if(flg!=1)
		imghtml+='<a href="'+recurl+'" style="cursor: pointer;">';
		if(ST_pw=="150")
			imghtml+='<div class="useracticonsimgs photoaddfbig"></div>';
		else
			imghtml+='<div class="useracticonsimgs photorequestf"></div>';
		if(flg!=1) imghtml+='</a>';
		imghtml+='</a></div></div></div>';
	}
	else {
		imghtml='<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;"><div style="float:left;">';
		 if(memberid){
			imghtml+='<a href="javascript:;" onClick=\'window.open("'+domainurl+'","","directories=no,width=900,height=750,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0")\' style="cursor: pointer;">';
		 }else{
			imghtml+='<a href="/login/loginform.php?mid='+opmemid+'&frompg=vp&fname=/profiledetail/viewprofile.php?id='+opmemid+'" style="cursor: pointer;">';
		 }
		if(ST_pw=="150")
			imghtml+='<div class="useracticonsimgs photopasswdbig"></div>';
		else
			imghtml+='<div class="useracticonsimgs photoprotected"></div>';
		imghtml+='</a></div></div></div>';
	}
	if (mode=="initial" && request==""){ 
		imgconid.innerHTML = imghtml;
		if(numberslide.length > 1 && pgview=="Y" && arguments[12] == null) {
			imgnid.innerHTML = '<div style="padding:5px 0px 0px 15px;"><div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle; "><div style="float:left;padding-top:4px;"><div class="useracticonsimgs phnavlftoff"></div></div><div style="float:left;padding: 0px 3px 2px 3px;" class="smalltxt">1 of '+numberslide.length+' </div><div style="float:left;padding-top:4px;"><a href="javascript:;" onClick="javascript:goforward(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+numberslide.length+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\')" style="cursor: pointer;"><div class="useracticonsimgs phnavrigon"></div></a></div></div></div></div>';
		}else if(numberslide.length > 1 && pgview=="Y" && arguments[12] != null){
			imgnid.innerHTML = '<div style="padding:5px 0px 0px 15px;"><div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle; "><div style="float:left;padding-top:4px;"><div class="useracticonsimgs phnavlftoff"></div></div><div style="float:left;padding: 0px 3px 2px 3px;" class="smalltxt">1 of '+numberslide.length+' </div><div style="float:left;padding-top:4px;"><a href="javascript:;" onClick="javascript:goforward(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+numberslide.length+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\',150)" style="cursor: pointer;"><div class="useracticonsimgs phnavrigon"></div></a></div></div></div></div>';
		}
	}
	else if(request==""){
		imgconid.innerHTML=imghtml
		imgcount = currentindex+1;
		if(pgview=="Y") {
			pagenavhtml = '<div style="padding:5px 0px 0px 15px;"><div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle; "><div style="float:left;padding-top:4px;">';
			var middivval='</div><div style="float:left;padding: 0px 3px 2px 3px;" class="smalltxt">'+imgcount+' of '+numberslide.length+' </div><div style="float:left;padding-top:4px;">';

			if(imgcount == numberslide.length && arguments[12] == null) 
				pagenavhtml +='<a href="javascript:;" onClick="javascript:goback(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\')" style="cursor: pointer;"><div class="useracticonsimgs phnavlfton"></div></a>'+middivval+'<div class="useracticonsimgs phnavrigoff"></div></div>';		
			else if(imgcount == numberslide.length && arguments[12] != null) 
				pagenavhtml +='<a href="javascript:;" onClick="javascript:goback(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\',150)" style="cursor: pointer;"><div class="useracticonsimgs phnavlfton"></div></a>'+middivval+'<div class="useracticonsimgs phnavrigoff"></div></div>';	
			else if(imgcount == 1 && arguments[12] == null)
				pagenavhtml +='<div class="useracticonsimgs phnavlftoff"></div>'+middivval+'<a href="javascript:;" onClick="javascript:goforward(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+numberslide.length+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\')" style="cursor: pointer;"><div class="useracticonsimgs phnavrigon"></div></a></div>';
			else if(imgcount == 1 && arguments[12] != null)
				pagenavhtml +='<div class="useracticonsimgs phnavlftoff"></div>'+middivval+'<a href="javascript:;" onClick="javascript:goforward(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+numberslide.length+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\',150)" style="cursor: pointer;"><div class="useracticonsimgs phnavrigon"></div></a></div>';
			else if(arguments[12] == null)
				pagenavhtml +='<a href="javascript:;" onClick="javascript:goback(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\')" style="cursor: pointer;"><div class="useracticonsimgs phnavlfton"></div></a>'+middivval+'<a href="javascript:;" onClick="javascript:goforward(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+numberslide.length+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\')" style="cursor: pointer;"><div class="useracticonsimgs phnavrigon"></div></a></div>';
			else if(arguments[12] != null)
				pagenavhtml +='<a href="javascript:;" onClick="javascript:goback(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\',150)" style="cursor: pointer;"><div class="useracticonsimgs phnavlfton"></div></a>'+middivval+'<a href="javascript:;" onClick="javascript:goforward(\''+request+'\',\''+imgpath+'\',\''+fullimgpath+'\',\''+imgcid+'\',\''+imgnavid+'\',\''+currentindex+'\',\''+pgview+'\',\''+bigimgid+'\',\''+numberslide.length+'\',\''+opmemid+'\',\''+domainurl+'\',\''+moverchk+'\',150)" style="cursor: pointer;"><div class="useracticonsimgs phnavrigon"></div></a></div>';
				pagenavhtml +='</div></div></div>';
			$_obj(imgnavid).innerHTML=pagenavhtml;
		}
	}
	else{ imgconid.innerHTML = imghtml; }
}
function goforward(request,imgpath,fullimgpath,imgcid,imgnavid,cindex,pgview,bigimgid,imglen,opmemid,domainurl,moverchk){

crindex = eval(cindex)+1;
if (crindex<imglen && arguments[12] == null)
PhTravs(crindex,request,imgpath,fullimgpath,imgcid,imgnavid,crindex,pgview,bigimgid,opmemid,domainurl,moverchk)
else if (crindex<imglen && arguments[12] != null)
	PhTravs(crindex,request,imgpath,fullimgpath,imgcid,imgnavid,crindex,pgview,bigimgid,opmemid,domainurl,moverchk,arguments[12])
}
function goback(request,imgpath,fullimgpath,imgcid,imgnavid,crindex,pgview,bigimgid,opmemid,domainurl,moverchk){ 
if (crindex!=0 && arguments[11] == null)
PhTravs(eval(crindex-1),request,imgpath,fullimgpath,imgcid,imgnavid,crindex,pgview,bigimgid,opmemid,domainurl,moverchk)
else if (crindex!=0 && arguments[11] != null)
PhTravs(eval(crindex-1),request,imgpath,fullimgpath,imgcid,imgnavid,crindex,pgview,bigimgid,opmemid,domainurl,moverchk,arguments[11])
}
function overimg(timg,tmbid,imgL,imgT){
	var oimgid = $(tmbid);
	if($(tmbid)!=null){
		oimgid.style.position="absolute";
		oimgid.style.visibility = "visible";
		oimgid.style.left = imgL;
		oimgid.style.top = imgT;
		oimgid.innerHTML='<img src="'+timg+'" width="150" height="150">';
	}
}
function overout(tmbid){ $(tmbid).style.visibility = "hidden"; }
var bmchocurl,bmchurl,bmchclass;
function bmciconview(parent,child,viewid,horoVal){
	try{
		var p = $(parent);
		var idiv = document.createElement('div');
		idiv.setAttribute("id",child);
		idiv.className="iconclass";
		idiv.style.width="168px";
		document.body.appendChild(idiv);
		var c = $(child);
		horizontaloffset=horizontaloffset+2;
		  p["phone_parent"]     = p.id;
		  c["phone_parent"]     = p.id;
		  p["phone_child"]      = c.id;
		  c["phone_child"]      = c.id;
		  p["phone_position"]   = "x";
		  c["phone_position"]   = "x";
		  if(horoVal.substring(1,2)=="Y"){
			bmchocurl = fadeurlreplace('/horoscope/bmchoroview.php?viewid='+viewid,'','750','','horodiv');
			bmchurl = '<div style="padding-top:2px;"><a href=\'javascript:;\' onClick=\''+bmchocurl+'\' class="clr1">View Horoscope</a></div>';
			 if(horoVal.substring(0,1)=="G")
				bmchclass = '<div class="useracticonsimgs horogen"></div>';
			 else
				bmchclass = '<div class="useracticonsimgs horo"></div>';
		  }
		  c.innerHTML='<div class="icon-menu1"><div class="icon-menu2 fleft"><div style="width:130px;text-align:right;" class="fleft"><div style="padding: 2px 0px 8px 5px;" class="smalltxt">'+bmchurl+'</div></div><div class="fleft" style="padding: 2px 0px 8px 5px;"><div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;"><div style="padding-top:2px;">'+bmchclass+'</div></div></div></div></div></div>';
		 if(iconfirst==1){
			 var left=findPosX(p)-168+p.offsetWidth+horizontaloffset;
			 var top=findPosY(p)-verticaloffset;
			 c.style.position   = "absolute";
			 c.style.top        = top +'px';
             c.style.left       = left+'px';
             c.style.visibility = "visible";
		  }else{
			  c.style.position   = "absolute";
			  c.style.visibility = "hidden";
		  }
		  p.onmouseover = icon_show;
		  p.onmouseout  = icon_hide;
		  c.onmouseover = icon_show;
		  c.onmouseout  = icon_hide;
		}
	catch(e) { alert(e); }
}
function horopwdvalidate(FormName) { var PhotoForm = eval('document.' + FormName); if ( PhotoForm.PASSWORD.value == "" ) { document.getElementById("pwderr").innerHTML="Please enter Password";PhotoForm.PASSWORD.focus(); return false;	}else{document.getElementById("pwderr").innerHTML="&nbsp";} return true; } 

/* Newly Added Below Function for show View similar profiles after sent PM/EI */

function viewSimilarProfiles(senderId,receiverId,preferenceSet,gender){
	var curDomain=document.domain;
	if(preferenceSet == 1){
		//var url = 'http://'+curDomain+'/search/viewpartprefprofiles.php';
		var url = 'http://'+curDomain+'/profiledetail/similarprofiles.php';

		var parameters = 'matriid='+senderId+'&count=2&partnerpref=1&gender='+gender;
	} else {
		var url = 'http://'+curDomain+'/profiledetail/similarprofiles.php';
		var parameters = 'matriid='+receiverId+'&count=2&partnerpref=0&gender='+gender;
 	}			
	ajobj=createajax_opac();
	MakePostRequest_opac(url,parameters,'showPartnerPreference',ajobj);

 }

function showPartnerPreference(){
		$("showviewsimilarprofiles").innerHTML="<div style='text-align:center;'><img src=\"http://imgs.tamilmatrimony.com/bmimages/small_loading.gif \"></div>";
		if(ajobj.readyState==4){ 
			if(ajobj.status==200) {
				if(parent.document.getElementById("dispcontent_1")){
  					parent.document.getElementById("dispcontent_1").innerHTML = $("inboxresult").innerHTML;
					parent.document.getElementById("iframename").style.display='none';
					parent.document.getElementById("showviewsimilarprofiles").innerHTML=ajobj.responseText;
				}else {
					document.getElementById("showviewsimilarprofiles").innerHTML=ajobj.responseText;
				}
			}else{ 
				alert('There was a problem with the request.');
			}
		}
}