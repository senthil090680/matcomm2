function dispFileMsg(cliname, sername){
	document.getElementById("upload_status").value = "file successfully uploaded";
	document.getElementById("upload_button").disabled = false;
	printMsg(document.frm.myid.value,escape("<a href='http://img.communitymatrimony.com/vmmeet/download.php?f="+sername+"'><font color=blue><b>"+cliname+"<b></font></a> file has been sent"),1);
	window.opener.sendMsg(document.frm.recpid.value+"~"+escape("<a href='http://img.communitymatrimony.com/vmmeet/download.php?f="+sername+"'><font color=blue><b>"+cliname+"<b></font></a> file received"));
}

function filesizealt(){	alert("The uploaded file exceeds the 2MB");}

function close_w(){var id = '<?php echo $recpid; ?>';window.opener.close_win(id);}

function dischatlink(){	var dmid="c-"+document.frm.recpid.value;}

function entsub(e){   
	var agt, isIe, isGecko, key;
	var keychar;
	var splcheck;
	agt = navigator.userAgent.toLowerCase();
	isIE    = ((agt.indexOf("msie")  != -1) && (agt.indexOf("opera") == -1));
	isGecko = ((agt.indexOf('gecko') != -1) && (agt.indexOf("khtml") == -1));
	if(isIE){
		key = window.event.keyCode;
		if (key == 13)
		{ addEvent();event.keyCode = 0;}
	}

	if(isGecko){
		key = e.which;
		if (key == 13)
		{addEvent();(e.which) ? e.which : 0;return false;}
	}

	keychar = String.fromCharCode(key)
	splcheck = /\'|\"/
	return !splcheck.test(keychar);
}

function IsEmpty(obj, obj_type){
	if (obj_type == "text" || obj_type == "textarea"){
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");
		if (objValue.length == 0) {
		return true;
		} else {
			return false;
		}
	}
}

function writeMsg(newMsg,stat){
	printMsg(document.frm.recpid.value,newMsg,2);
	if(stat=='b'){bflag=1;blockarea();}
}

function addEvent(){  
	if(document.getElementById('blocked').value==""){
	if(!IsEmpty(document.frm.msg,'text')){    
		printMsg(document.frm.myid.value,document.frm.msg.value,1);
		window.opener.sendMsg(document.frm.recpid.value+"~"+escape(document.frm.msg.value));
		document.frm.msg.value="";clearmsg="";
	}
	}else{
	   alert('User has been blocked you.you cant send msg until he unblock.');
	}
	document.frm.msg.focus();
}

function printMsg(id,mess,tcolor){   
	if(tcolor==1)
	{txtcolor="green";}
	else
	{txtcolor="red";}
	var ni = document.getElementById('myDiv');
	var numi = document.getElementById('theValue');
	var num = (document.getElementById("theValue").value -1)+ 2;
	numi.value = num;
	var divIdName = "my"+num+"Div";
	var newdiv = document.createElement('div');
	newdiv.setAttribute("id",divIdName);
	mess=mess.replace(/SYSMSG/,"<font color='#ff0000'><b>");
	mess=mess.replace(/CSYSMSG/,"</b></font>");
	newdiv.innerHTML ="<div class='apclass'><font color='"+txtcolor+"'><b>"+id.toUpperCase()+"</b>:</font>"+unescape(mess)+"</div>";
	ni.appendChild(newdiv);
	document.getElementById('myDiv').scrollTop = 99999;
	document.frm.msg.focus();
}

function blockmem(){ 
	var stay=confirm("Are you sure want to block this member?")
	if(stay == true){
		window.opener.addblock(document.frm.recpid.value);
		window.self.close();
	}
}

function photo_req(status,imgPath){ 
	if(status==1){
		var stay=confirm("Are you sure want to send photo request?")
	}else if(status==2){
        var stay=confirm("Are you sure want to send photo password request?")
	}else{
    stay =false;	window.open(imgPath+"/photo/viewphoto.php?ID="+document.frm.recpid.value,'','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');
	}
    
	if(stay == true){
		window.opener.send_photo_req(document.frm.recpid.value,status);
	}
}

function blockedflag(){
	document.getElementById('blocked').value='1';
}

function unblockedflag(){
	document.getElementById('blocked').value='';
}

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}

function get_name_from_path(str_filepath) {    
	var obj_re = new RegExp(/([^\/\\]+)$/);    
	var str_name = obj_re.exec(str_filepath);    
	if (str_name == null){ return null;}
	else{ return str_name[0];}
}

function jsUpload(upload_field){  
    if(document.getElementById('blocked').value==""){
    var re_text = /\.xml/i;
    var filename = upload_field.value;
    var fil = filename.substring(filename.length-3,filename.length);
    fil = fil.toLowerCase();
    if((fil.indexOf("txt") == -1) && (fil.indexOf("rtf") == -1) && (fil.indexOf("doc") == -1) && (fil.indexOf("gif") == -1)  && (fil.indexOf("png") == -1) && (fil.indexOf("jpg") == -1) && (fil.indexOf("peg") == -1))
    {alert("Invalid File");upload_field.form.reset();return false;}
    upload_field.form.submit();
	document.frm.msg.value="";clearmsg="";
	document.frm.msg.focus();
	upload_field.form.reset();
    return true;
	}else{
	alert('User has blocked you.you cant send msg until the user  unblock.');
	}
}