var viewrec,objAjax1,prev_divno='',previnnerdiv='',curroppid='', curinnerno='';  var VPRefresh='';
var collapse;
var tempdiv;
var tempdiv1;
var imname='mview';

function intDecCall(vmsgid, currvno, decfl){
	curinnerno = currvno;
	url		= ser_url+'/mymessages/interestdecline.php?rno='+Math.random();
	param	= 'iid='+vmsgid+'&currno='+currvno;
	param += '&declineopt=1&frmDecSubmit=yes';
	/*if(decfl=='1'){
	decopt = getRadioValue(document.frmDec.declinedopt);
	param += '&declineopt='+decopt+'&frmDecSubmit=yes';
	}*/
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
	if(VPRefresh=='') {
		txtdivname = 'msgdispdiv'+viewrec;
		if($(txtdivname))
		$(txtdivname).style.display="none";
	}
}

function gotomsgrec(){
	window.location.href	= ser_url+'/mymessages/';
}

function intAccCall(vmsgid, currvno){
	curinnerno = currvno;
	url		= ser_url+'/mymessages/interestaccept.php?rno='+Math.random();
	param	= 'iid='+vmsgid+'&currno='+currvno;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
	if(VPRefresh=='') {
		txtdivname = 'msgdispdiv'+viewrec;
		if($(txtdivname))
		$(txtdivname).style.display="none";
	}
}

function sendreminder(msgfl, vmsgid, currvno){
	curinnerno = currvno;
	url		= ser_url+'/mymessages/sendreminder.php?rno='+Math.random();
	param	= 'msgfl='+msgfl+'&msgid='+vmsgid+'&currno='+currvno;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,msgCallRes,objAjax1);
}

function msgCallRes()
{
	innerresdiv = 'msgactpart'+curinnerno;
	if(objAjax1.readyState == 4 && objAjax1.status==200){
	$(innerresdiv).innerHTML = objAjax1.responseText;
	replyDiv = 'replyDiv'+curinnerno;
	if(VPRefresh==''){
		if($(replyDiv))
		{$(replyDiv).style.display = 'none';}
	}
	}else{
	$(innerresdiv).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function reloadMsg(){
}

function getViewProfile(viewid, viewrecno, msgfl, msgid, msgty,defaultTab)
{
	var fpconfirm=0;
	if(defaultTab == undefined)
	defaultTab='';	

	//if($('shortMsg'+viewrecno))
	//$('shortMsg'+viewrecno).style.display="none"; 

	if(viewrecno==50000) {
		fpconfirm=1;
	} else {
		fpconfirm=0;
	}
	if(prev_divno==''){
		prev_divno = viewrecno;
	}else{
		prevcont_div = 'cont'+prev_divno;
		prevviewpro_div = 'viewpro'+prev_divno;
		imageswap('mview',prev_divno);
		$(prevcont_div).style.display="block";
		$(prevviewpro_div).style.display="none";
		prev_divno = viewrecno;
	}

	//for inner div like interst decline pg
	if(previnnerdiv!=''){hide_box_div(previnnerdiv);};

	cont_div	= 'cont'+viewrecno;
	viewpro_div = 'viewpro'+viewrecno;

	viewrec     = viewrecno;
	if(viewid!='' && cook_id!=''){
	curroppid = viewid;
	if($(viewpro_div).innerHTML!=''){
		$(viewpro_div).style.display="block";
		if(defaultTab == 'phone')
        $(viewrecno+'vtab8').onclick();
		else if(defaultTab == 'photo')
        $(viewrecno+'vtab3').onclick();
		else if(defaultTab == 'horoscope')
        $(viewrecno+'vtab4').onclick();
		else
		$(viewrecno+'vtab2').onclick();
	}else{
	url		= ser_url+'/profiledetail/viewprofile.php?fpconfirm='+fpconfirm+'&rno='+Math.random();
	param	= 'id='+viewid+'&msgid='+msgid+'&msgfl='+msgfl+'&cpno='+viewrecno+'&msgty='+msgty+'&defaultTab='+defaultTab;
	objAjax1 = AjaxCall();
	AjaxPostReq(url,param,srchViewDisp,objAjax1);

	}
	}else{
		if(cook_id==''){
		$(viewpro_div).innerHTML = '<div class="brdr pad10 rpanelinner" style="width:"><div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_alert();closeViewDisp('+viewrec+');" href="javascript:;" class="pntr" /></div><br clear="all"/>Register free to view full profile details and to contact this member.<br clear="all"><a href="'+ser_url+'/register/" class="clr1">Click here to Register</a> or <a href="'+ser_url+'/login/" class="clr1">Login NOW.</a><div class="padt10">&nbsp;</div></div>';
		}else if(viewid==''){
		$(viewpro_div).innerHTML = '<div class="brdr pad10 rpanelinner" style="width:"><div class="fright"><img src="'+imgs_url+'/close.gif" onclick="hide_alert();closeViewDisp('+viewrec+');" href="javascript:;" class="pntr" /></div><br clear="all"/>Profile is not available.<div class="padt10">&nbsp;</div></div>';
		}
	$(viewpro_div).style.height="120px";
	$(viewpro_div).style.display="block";
	}
	//alert(tempdiv.offsetHeight);
}

function hide_alert(){
	cont_div = 'cont'+viewrec;
	viewpro_div = 'viewpro'+viewrec;
	$(cont_div).style.display="block";
	$(viewpro_div).style.display="none";
}

function srchViewDisp()
{
	cont_div = 'cont'+viewrec;
	viewpro_div = 'viewpro'+viewrec;

	if(objAjax1.readyState == 4){	
	$(viewpro_div).innerHTML = objAjax1.responseText;
	tempdiv=$("viewpro"+viewrec);
	//alert(tempdiv.offsetHeight);
	$(viewpro_div).style.display="block";
	} else {
		$(viewpro_div).innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
}

function closeViewDisp(currrecno)
{
	cont_div = 'cont'+currrecno;
	viewpro_div = 'viewpro'+currrecno;
	$(cont_div).style.display="block";
	$(viewpro_div).style.display="none";
	imageswap("mview",currrecno);
}

function opencollapse(num)
{
	var i=num;
	var currentdiv="viewpro"+i;
    //setInterval('alert(tempdiv.offsetHeight);',2000);
	//$(currentdiv).style.height=tempdiv.offsetHeight+"px";
	//fadeIn(currentdiv);
	/*if(navigator.appName=='Netscape')
	{
		$(currentdiv).style.height=tempdiv.offsetHeight+"px";
	}
    else {
		$(currentdiv).style.height=tempdiv.offsetHeight+"px";
	}*/
	fadeIn(currentdiv);
	//$(currentdiv).style.height="320px";
	//collapse=new animatedcollapse(currentdiv, 500, false);
	//collapse.slideit();
}

function closecollapse(num)
{
	var i=num;
	var currentdiv="viewpro"+i;
	closeViewDisp(num);
}

function imageswap(dn,num)
{
	if($(dn+'0'))
	{
	if(dn=="eview"){$('mview'+num).style.display="block";$('eview'+num).style.display="none";}
	if(dn=="mview"){$('eview'+num).style.display="block";$('mview'+num).style.display="none";}
	}
}

function Fader(el, fadeIn)
      {
        var me = this;
        this.el = (typeof(el) == "object")?el:(typeof(el) == "string")?document.getElementById(el):null;
        this.fadeIn = fadeIn;
        this.doFade = doFade;
        this.setOpacity = setOpacity;
        this.showElement = showElement;
        this.opacity = 0;
        
        this.doFade();
        
        function setOpacity()
        {
          if (typeof(this.el.style.opacity) != null) this.el.style.opacity = this.opacity / 100;
          if (typeof(this.el.style.filter) != null) this.el.style.filter = "alpha(opacity=" + this.opacity + ")";
          this.opacity += (this.fadeIn)?1:-1;
        }
        
        function showElement(show)
        {
          if (this.el && this.el.style) this.el.style.display = (show)?"block":(this.fadeIn)?"block":"none";
        }
        
        function doFade()
        {
                                   
          this.showElement(true);
          if (this.fadeIn)
          {
            this.opacity = 0;
            this.setOpacity();
            
            for (var i=0; i<=100; i++)
            {
              var newFunc = function() { me.setOpacity(); };
              setTimeout(newFunc, 8*i);
            }
          }
          else
          {
            this.opacity = 100;
            this.setOpacity();
            
            for (var i=0; i<=100; i++)
            {
              var newFunc = function() { me.setOpacity(); };
              setTimeout(newFunc, 8*i);
            }
          }
          
          var newFunc = function () { me.showElement(); };
          
          setTimeout(newFunc, 810);
        }
      }

      function fade(obj, fadeIn)
      {
        if (obj) new Fader(obj, fadeIn);
      }
      
      function fadeIn(objID)
      {
        fade(objID, true);
      }
      
      function fadeOut(objID)
      {
        fade(objID, false);
      }