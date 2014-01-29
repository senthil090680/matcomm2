var parameters,message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
function closeParent(){	window.parent.close();}
function expopupcnt(dblanguage,cnt){
	var mywindow1=window.open('','test',"location=0,status=0,scrollbars=0,toolbar=0,menubar=0,width=400,height=200");
	mywindow1.document.write("<html><head></head><link rel='stylesheet' href='/styles/bmstyle.css'><body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0'>");
	mywindow1.document.write("<table border='0' cellpadding='0' cellpadding='0' width='100%' class='brownpopclr' height='100%'>");
	mywindow1.document.write("<tr><td>&nbsp;</td></tr>");
	mywindow1.document.write("<tr><td valign='top'>");
	mywindow1.document.write("<p style='font-family:verdana;font-size:11px;line-height:17px;padding-left:15px;padding-right:15px' align='justify'>");
	mywindow1.document.write("Sorry, the maximum number of Astro Matches allowed is "+cnt+". If you want to do more Astro Matches, you must renew your subscription. <br><br><a href='"+dblanguage+"/payment/index.php?act=additionalpayment&astro=1' target='_blank' onClick='javascript: window.parent.close();');>Click here</a> to subscribe to AstroMatch.</font>");
	mywindow1.document.write("</td></tr>");
	mywindow1.document.write("<tr><td align='right'><a href='javascript: window.close();' class='linktxt'><font color='#000000'>Close</font></a>&nbsp;&nbsp;</td></tr>");
	mywindow1.document.write("</table></body></html>");
	mywindow1.moveTo(200,200);
	window.parent.close();
}
function popHoroDetails(){
	var mywindow1=window.open('','test',"location=0,status=0,scrollbars=0,toolbar=0,menubar=0,width=450,height=342");
	mywindow1.document.write("<html><head></head><link rel='stylesheet' href='http://imgs.bharatmatrimony.com/bmstyles/bmstyle.css'><body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0'>");
	mywindow1.document.write("<table border='0' cellpadding='0' cellpadding='0' width='100%' class='brownpopclr'>");
	mywindow1.document.write("<tr><td valign='top'>");
	mywindow1.document.write("<p style='font-family:verdana;font-size:11px;line-height:17px;' align='justify'>");
	mywindow1.document.write("<ul class='normaltxt1'><li><b>Standard Time</b><br>Standard time is universal time set in different locations within a time zone. The time without day light saving is also called standard time.<br><br><li><b>Daylight Saving</b><br>In countries with high latitudes, day duration changes drastically from about 6 hours in winter to 18 hours in summer.  In Northern latitude May and June are longer, whereas in Southern latitude December and January are longer as they have summer at this time. In summer the sun rises very early. To take the advantage of sun light, the clocks are advanced by one hour during summer for about six months and it is set back to original position during winter. This advanced time is called \"summer time\" or \"day light saving time\".  At some places the correction is done for 2 hours and it is called as \"double summer time\".<br><br><li><b>Time Correction</b><br>Since the above adjustment is artificial, only to save light, it is subtracted before doing any astronomical calculation.  By selecting the time correction, you can help our system convert it to standard time before generating your horoscope.");
	mywindow1.document.write("</td></tr>");
	mywindow1.document.write("<tr><td align='right'><a href='javascript: window.close();' class='linktxt'><font color='#000000'>Close</font></a>&nbsp;&nbsp;</td></tr>");
	mywindow1.document.write("</table></body></html>");
	mywindow1.moveTo(100,100);
}
function handle_response_cityvaluesNew(){
try{
	if(http.readyState==4) {
		next_data = "";
		var next_data = http.responseText;
		var longladArray = next_data.split("~");
		var logingender = document.frm.findlogingendNew.value;
		document.getElementById(logingender+"_PLACE_LONGITUDE_HOUR").value = longladArray[1]; //longitude_deg
		document.getElementById(logingender+"_PLACE_LONGITUDE_MIN").value = longladArray[2]; //longitude_min
		document.getElementById(logingender+"_PLACE_LONGITUDE_DIR").value = longladArray[3]; //longitude_dir
		document.getElementById(logingender+"_PLACE_LATITUDE_HOUR").value = longladArray[4]; //latitude_deg
		document.getElementById(logingender+"_PLACE_LATITUDE_MIN").value = longladArray[5]; //latitude_min
		document.getElementById(logingender+"_PLACE_LATITUDE_DIR").value = longladArray[6]; //latitude_dir
		document.getElementById(logingender+"_TIMEZONE").value = longladArray[7]; //timezone
		document.getElementById(logingender+"_BIRTH_PLACE_NAME").value = longladArray[0]; //login member's birth place
	}
}
catch(e) {}
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

function trackcityvaluesNew(country,states,cities,gender,memid){
	http="";
	http=false;
	http=null;
	http = createRequestObject2();
	if(country == 87){
		var url = "horomatchloadlonglad.php?country="+country+"&states="+states+"&city="+cities+"&gender="+gender+"&memid="+memid;
	}
	else{
		var url = "horomatchloadlongladnew.php?country="+country+"&states="+states+"&city="+cities+"&gender="+gender+"&memid="+memid;
	}
	http.onreadystatechange = handle_response_cityvaluesNew;	
	http.open("GET", url, true);
	http.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    http.send(null);
}
function selectcity2New(gender,memid){
	var country = document.getElementById(gender+"_selNewCountry").value;
	var state = document.getElementById(gender+"_lstState1").value;
	var citi = document.getElementById(gender+"_lstcity").value;
	trackcityvaluesNew(country,state,citi,gender,memid);
}
function opendiv(){
	document.getElementById('advopt').style.display="none";
	document.getElementById('advopt1').style.display="block";
}
function hclosediv(){
	document.getElementById('advopt1').style.display="none";
	document.getElementById('advopt').style.display="block";
}
function ch_method(){
	if (document.frm.REPORT_CHART_FORMAT.options[document.frm.REPORT_CHART_FORMAT.selectedIndex].value==0)
	{document.frm.METHOD.value="S2";}

	if (document.frm.REPORT_CHART_FORMAT.options[document.frm.REPORT_CHART_FORMAT.selectedIndex].value==3)
	{document.frm.METHOD.value="S1";}
	
	if ((document.frm.REPORT_CHART_FORMAT.options[document.frm.REPORT_CHART_FORMAT.selectedIndex].value==1) || (document.frm.REPORT_CHART_FORMAT.options[document.frm.REPORT_CHART_FORMAT.selectedIndex].value==2))
	{document.frm.METHOD.value="S3";}
}
var mycnt=0,refreshcnt=0,http;
function createRequestObject() {
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) { }
	} else if (window.ActiveXObject) { // IE
		try { http_request = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {
			try { http_request = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
		}
	}
	if (!http_request) { return false; }
	return http_request;
}
function createRequestObject2() {
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) { }
	} else if (window.ActiveXObject) { // IE
		try { http_request = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) {
			try { http_request = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { }
		}
	}
	if (!http_request) { return false; }
	return http_request;
}
function processpage(){
	/*gender = document.frm.findlogingend.value;
	var form = document.frm,M_Countries_val,M_States_val,M_Cities_val,F_Countries_val,F_States_val,F_Cities_val;

	if($("M_Countries").value!="" && $("M_Countries").value!=null)
		M_Countries_val=form.M_Countries.value;
	else
		M_Countries_val=form.M_selNewCountry.value;

	if($("M_States").value!="" && $("M_States").value!=null)
		M_States_val=form.M_States.value;
	else
		M_States_val=form.M_lstState1.value;

	if($("M_Cities").value!="" && $("M_Cities").value!=null)
		M_Cities_val=form.M_Cities.value;
	else
		M_Cities_val=form.M_lstcity.value;

	if($("F_Countries").value!="" && $("F_Countries").value!=null)
		F_Countries_val=form.F_Countries.value;
	else
		F_Countries_val=form.F_selNewCountry.value;

	if($("F_States").value!="" && $("F_States").value!=null)
		F_States_val=form.F_States.value;
	else
		F_States_val=form.F_lstState1.value;

	if($("F_Cities").value!="" && $("F_Cities").value!=null)
		F_Cities_val=form.F_Cities.value;
	else
		F_Cities_val=form.F_lstcity.value;
	parameters="findlogingend="+form.findlogingend.value+"&M_REGNO="+form.M_REGNO.value+"&M_PERSON_FNAME="+form.M_PERSON_FNAME.value+"&M_BIRTH_DAY="+form.M_BIRTH_DAY.value+"&M_BIRTH_MONTH="+form.M_BIRTH_MONTH.value+"&M_BIRTH_YEAR="+form.M_BIRTH_YEAR.value+"&M_BIRTH_HOUR="+form.M_BIRTH_HOUR.value+"&partnervalue="+form.partnervalue.value+"&M_BirthMedian="+form.M_BirthMedian.value+"&M_BIRTH_MIN="+form.M_BIRTH_MIN.value+"&M_BIRTH_SEC="+form.M_BIRTH_SEC.value+"&M_TIMECORRECTION="+form.M_TIMECORRECTION.value+"&M_Countries="+M_Countries_val+"&M_States="+M_States_val+"&M_BIRTH_PLACE_NAME="+form.M_BIRTH_PLACE_NAME.value+"&M_Cities="+M_Cities_val+"&M_PLACE_LONGITUDE_HOUR="+form.M_PLACE_LONGITUDE_HOUR.value+"&M_PLACE_LONGITUDE_MIN="+form.M_PLACE_LONGITUDE_MIN.value+"&M_PLACE_LATITUDE_HOUR="+form.M_PLACE_LATITUDE_HOUR.value+"&M_PLACE_LATITUDE_MIN="+form.M_PLACE_LATITUDE_MIN.value+"&M_PLACE_LONGITUDE_DIR="+form.M_PLACE_LONGITUDE_DIR.value+"&M_PLACE_LATITUDE_DIR="+form.M_PLACE_LATITUDE_DIR.value+"&M_TIMEZONE="+form.M_TIMEZONE.value+"&F_REGNO="+form.F_REGNO.value+"&F_PERSON_FNAME="+form.F_PERSON_FNAME.value+"&F_BIRTH_DAY="+form.F_BIRTH_DAY.value+"&F_BIRTH_MONTH="+form.F_BIRTH_MONTH.value+"&F_BIRTH_YEAR="+form.F_BIRTH_YEAR.value+"&F_BIRTH_HOUR="+form.F_BIRTH_HOUR.value+"&F_BirthMedian="+form.F_BirthMedian.value+"&F_BIRTH_HOUR="+form.F_BIRTH_HOUR.value+"&F_BIRTH_MIN="+form.F_BIRTH_MIN.value+"&F_BIRTH_SEC="+form.F_BIRTH_SEC.value+"&F_TIMECORRECTION="+form.F_TIMECORRECTION.value+"&F_Countries="+F_Countries_val+"&F_States="+F_States_val+"&F_BIRTH_PLACE_NAME="+form.F_BIRTH_PLACE_NAME.value+"&F_Cities="+F_Cities_val+"&F_PLACE_LONGITUDE_HOUR="+form.F_PLACE_LONGITUDE_HOUR.value+"&F_PLACE_LONGITUDE_MIN="+form.F_PLACE_LONGITUDE_MIN.value+"&F_PLACE_LATITUDE_HOUR="+form.F_PLACE_LATITUDE_HOUR.value+"&F_PLACE_LATITUDE_MIN="+form.F_PLACE_LATITUDE_MIN.value+"&F_PLACE_LONGITUDE_DIR="+form.F_PLACE_LONGITUDE_DIR.value+"&F_PLACE_LATITUDE_DIR="+form.F_PLACE_LATITUDE_DIR.value+"&F_TIMEZONE="+form.F_TIMEZONE.value+"&CUSTID="+form.CUSTID.value+"&REPORT_CHART_FORMAT="+form.REPORT_CHART_FORMAT.value+"&REPORT_LANGUAGE="+form.REPORT_LANGUAGE.value+"&REPORT_TYPE="+form.REPORT_TYPE.value+"&METHOD="+form.METHOD.value+"&KUJADOSHA="+form.KUJADOSHA.value+"&PAPASAMYA="+form.PAPASAMYA.value+"&DASASANDHI="+form.DASASANDHI.value;
	var fade_url = "http://"+form.domurl.value+"/horoscope/horomatchcomposexml.php";
	if(gender == "M"){
		if(checkValues()){
			document.body.scrollTop=0;
			fade('horodiv','fdivname','dispdiv','700','530','frm',fade_url,'','astomatch','POST','');
			return true;
		}
		else
			return false;
	} //end Male
	else if(gender == "F"){
		if(checkValues()){
			document.body.scrollTop=0;
			fade('horodiv','fdivname','dispdiv','700','530','frm',fade_url,'','astomatch','POST','');
			return true;
		}
		else
			return false;
	}*/
	gender = document.frm.findlogingend.value;
	
		if(gender == "M")
		{
			if(checkValues())
			{
				document.frm.submit();
				return true;
			}
			else
				return false;
		} //end Male
		else if(gender == "F")
		{
			if(checkValues())
			{
				document.frm.submit();
				return true;
			}
			else
				return false;
		}
} //end function 
function checkValues(){
	var Mgen=document.frm.findlogingend.value;
	var Fgen=document.frm.findlogingendNew.value; //for partner always take this one...
	var partnervalue = document.frm.partnervalue.value;
	if(partnervalue == 1){return true;}
	else{
		if(eval("document.frm."+Fgen+"_selNewCountry.options[document.frm."+Fgen+"_selNewCountry.selectedIndex].value") == "0"){
			$('mcounerr').innerHTML="Please select the partner country<br>";
			eval("document.frm."+Fgen+"_selNewCountry.focus()");
			return false;
		}$('mcounerr').innerHTML="&nbsp";
		if(eval("document.frm."+Fgen+"_SELECTED_STATE.value") == ""){
			$("mstateerr").innerHTML="Please select the partner state<br>";
			eval("document.frm."+Fgen+"_lstState1.focus()");
			return false;
		}$('mstateerr').innerHTML="&nbsp";
		if(eval("document.frm."+Fgen+"_PLACE_LONGITUDE_HOUR.value") == ""){
			$('mcityerr').innerHTML="Pleas select the partner city<br>";
			eval("document.frm."+Fgen+"_lstcity.focus()");
			return false;
		}
		else{ $('mcityerr').innerHTML="&nbsp"; return true; }
	}
	if(eval("document.frm."+Fgen+"_PLACE_LONGITUDE_HOUR.value") == ""){
		$('mcityerr').innerHTML="Pleas select the partner city<br>";
		eval("document.frm."+Fgen+"_lstcity.focus()");
		return false;
	}
	else{ $('mcityerr').innerHTML="&nbsp"; return true; }
}
function maxMe(){ self.moveTo(10,10); }
function expopupcnt(dblanguage,cnt){
var mywindow1=window.open('','test',"location=0,status=0,scrollbars=0,toolbar=0,menubar=0,width=550,height=71");
mywindow1.document.write("<html><head></head><link rel='stylesheet' href='http://imgs.bharatmatrimony.com/bmstyles/bmstyle.css'><body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0'>");
mywindow1.document.write("<table border='0' cellpadding='0' cellpadding='0' width='100%' class='brownpopclr'>");
mywindow1.document.write("<tr><td valign='top'>");
mywindow1.document.write("<p style='font-family:verdana;font-size:11px;line-height:17px;' align='justify'>");
mywindow1.document.write("Sorry, the maximum number of Astro Matches allowed is "+cnt+". If you want to do more Astro Matches, you must renew your subscription. <br><a href='"+dblanguage+"/payment/index.php?act=additionalpayment&astro=1'); target='_blank' >Click here</a> to subscribe to AstroMatch.</font>");
mywindow1.document.write("</td></tr>");
mywindow1.document.write("<tr><td align='right'><a href='javascript: window.close();' class='linktxt'><font color='#000000'>Close</font></a>&nbsp;&nbsp;</td></tr>");
mywindow1.document.write("</table></body></html>");
mywindow1.moveTo(200,200);
mywindow1.resizeTo(500,135);
window.parent.close();
}
function expopupsub(dblanguage){
var mywindow1=window.open('','test',"location=0,status=0,scrollbars=0,toolbar=0,menubar=0,width=550,height=71");
mywindow1.document.write("<html><head></head><link rel='stylesheet' href='http://imgs.bharatmatrimony.com/bmstyles/bmstyle.css'><body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0'>");
mywindow1.document.write("<table border='0' cellpadding='0' cellpadding='0' width='100%' class='brownpopclr'>");
mywindow1.document.write("<tr><td valign='top'>");
mywindow1.document.write("<p style='font-family:verdana;font-size:11px;line-height:17px;' align='justify'>");
mywindow1.document.write("Sorry, AstroMatch is a Paid Service. <a href='"+dblanguage+"/payment/index.php?act=additionalpayment&astro=1' target='_blank' onClick='javascript: window.close();');>Click here</a> to subscribe to AstroMatch.</font>");
mywindow1.document.write("</td></tr>");
mywindow1.document.write("<tr><td align='right'><a href='javascript: window.close();' class='linktxt'><font color='#000000'>Close</font></a>&nbsp;&nbsp;</td></tr>");
mywindow1.document.write("</table></body></html>");
mywindow1.moveTo(200,200);
mywindow1.resizeTo(500,90);
window.parent.close();
}
function expopupgender(){
var mywindow1=window.open('','test',"location=0,status=0,scrollbars=0,toolbar=0,menubar=0,width=550,height=71");
mywindow1.document.write("<html><head></head><link rel='stylesheet' href='http://imgs.bharatmatrimony.com/bmstyles/bmstyle.css'><body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0'>");
mywindow1.document.write("<table border='0' cellpadding='0' cellpadding='0' width='100%' class='brownpopclr'>");
mywindow1.document.write("<tr><td valign='top'>");
mywindow1.document.write("<p style='font-family:verdana;font-size:11px;line-height:17px;' align='justify'>");
mywindow1.document.write("Sorry, matching horoscopes of the same gender is not permitted on our site.");
mywindow1.document.write("</td></tr>");
mywindow1.document.write("<tr><td align='right'><a href='javascript: window.close();' class='linktxt'><font color='#000000'>Close</font></a>&nbsp;&nbsp;</td></tr>");
mywindow1.document.write("</table></body></html>");
mywindow1.moveTo(200,200);
mywindow1.resizeTo(500,102);
window.parent.close();
}
function resizeToSmall(){
	self.moveTo(200,200);
	self.resizeTo(500,90);
}
function popCountry(con,matriid){ //new function
	http="";
	http=false;
	http=null;
	http = createRequestObject();
	if(con == 87){ 
		var url = "horoloadstates.php?ID="+matriid;
		http.onreadystatechange = handle_response_state;
	}
	else{
		var url = "horoloadstatesnew.php?ID="+matriid+"&cntry="+con;
		http.onreadystatechange = handle_response_state;
	}
	http.open("GET", url, true);
	http.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    http.send(null);
}
function handle_response_state() {
	if(http.readyState==4) {
		//alert(http.responseText);
		next_data = "";
		var next_data = http.responseText;
		var Fgen=document.frm.findlogingendNew.value; //for partner always take this one...
		document.getElementById("state").innerHTML = "<select name='"+Fgen+"_lstState1' id='"+Fgen+"_lstState1' style='width:206px;font-family: arial, Verdana, sans-serif;font-size : 8pt' onChange=popCity(this.value,'"+Fgen+"')><option Value=0>-Select-</option>"+next_data+"</select>";
	}
}
function popCity(state,gender) {
	var mid = document.getElementById("othermemberMatid");
	var matriid = mid.value;
	http="";
	http=false;
	http=null;
	http = createRequestObject();
	var country_val = document.getElementById(gender+"_selNewCountry").value;
	document.getElementById(gender+"_SELECTED_STATE").value = state;
	
	if(country_val == 87){
		var url = "horoloadcities.php?ID="+matriid+"&SID="+state;
		http.onreadystatechange = handle_response_city;
	}
	else{
		var url = "horoloadcitiesnew.php?ID="+matriid+"&SID="+state;
		http.onreadystatechange = handle_response_city;
	}
	http.open("GET", url, true);
	http.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    http.send(null);
}
function handle_response_city() {
	try{
		if(http.readyState==4) {
			next_data = "";
			var next_data = http.responseText;
			var Fgen=document.frm.findlogingendNew.value; //for partner always take this one...
			var partner_MatriID = document.frm.othermemberMatid.value;
			document.getElementById("city").innerHTML = '<select name="'+Fgen+'_lstcity" id="'+Fgen+'_lstcity" style="width:206px;font-family: arial, Verdana, sans-serif;font-size : 8pt" onChange="selectcity2New(\''+Fgen+'\',\''+partner_MatriID+'\');"><option Value=0>-Select-</option>'+next_data+'</select>';
		}
       }
       catch(e) { }
}
function redirectMe(lang){
	window.location.href=""+lang+"/payment/index.php?act=additionalpayment&astro=1";
}
window.onbeforeunload = function (event) {
	var flagHid = document.getElementById('isPageLoaded');
	if(flagHid!=null){
		if(flagHid.value != "1"){
		var alert_text = "Your horoscope is being matched.";
		var browser=navigator.appName;
		var bAgt = navigator.userAgent.toLowerCase();
		var is_opr = (bAgt.indexOf("opera") != -1);
		var is_msie = (bAgt.indexOf("msie") != -1) && document.all && !is_opr;
		var is_msie5 = (bAgt.indexOf("msie 5") != -1) && document.all && !is_opr;
		if(is_msie || is_msie5 ||!event){ event=window.event; }
		if(event){
			if(is_msie || is_msie5){ event.returnValue=alert_text;	}
			return alert_text;
			}
		}
	}
};
function hidediv(){
	var d = document.getElementById('mydiv');	
	d.style.display = "none";
	var flagHid = document.getElementById('isPageLoaded');
	flagHid.value = "1";
}