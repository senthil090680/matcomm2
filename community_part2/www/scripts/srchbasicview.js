var moreLink='';

function Decode_it(encoded) {
	try{ if(encoded!='' && encoded!=undefined) {
	var HEXCHARS="0123456789ABCDEFabcdef"; var plaintext=''; var i=0;
	while (i < encoded.length) {
		var ch=encoded.charAt(i);
		if(ch=="+") { plaintext+=" "; i++; } 
		else if(ch=="%") {
			if(i < (encoded.length-2) && HEXCHARS.indexOf(encoded.charAt(i+1)) !=-1 && HEXCHARS.indexOf(encoded.charAt(i+2)) !=-1) {
				plaintext+=unescape(encoded.substr(i,3)); i+=3;
			} else { plaintext+="%[ERROR]"; i++; }
		} else { plaintext+=ch; i++; }
	} return plaintext;
	} } catch(e) { }
}

function first_photo(ph_det, tph_det, div_no, div_prefix,mem_Id)
{
	var arrPhotos	= ph_det.split('^');
	var arrTPhotos	= tph_det.split('^');
	var totPhotos	= arrPhotos.length;
	if(arrPhotos[0] !=''){
		photofolder = '/'+arrPhotos[0].substring(3,4)+'/'+arrPhotos[0].substring(4,5)+'/';
		varOnClick = (cook_id=='')?'sel(\''+mem_Id+'\',\'\','+div_no+',\'1\');':'window.open(\''+varConfArr['domainimage']+'/photo/viewphoto.php?ID='+mem_Id+'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');';
		photoTxt = '<a onClick="'+varOnClick+'"><img src="'+pho_url+photofolder+arrTPhotos[0]+'" alt="" width="150" height="150"></a>';
		moreLink = '<div style="padding-top:3px;" class="clr1 smalltxt"><a onClick="'+varOnClick+'">View Album</a></div>';
		return photoTxt;
	}
	
}

function div_photo(gen, mem_id,i)
{
	varOnClick = (cook_id=='')?'sel(\''+mem_id+'\',\'\','+i+',\'1\');':'javascript:getViewProfile(\''+mem_id+"','"+i+'\',\'\',\'\',\'\',\'photo\');opencollapse('+i+');imageswap(\'eview\','+i+');';
	if (gen == 'PM') {
		photoName = "img50_pro_m";
		moreLink = '';
	}
	else if(gen == 'PF') {
	    photoName = "img50_pro_f";
		moreLink = '';
	}
	else {
		photoName= (gen == 1) ? 'noimg50_m' : 'noimg50_f';
		moreLink = '<div style="padding-top:3px;" class="clr1 smalltxt"><a onClick="'+varOnClick+'">Request Photo</a></div>';
	}
	photoTxt = '<a onClick="'+varOnClick+'"><img src="'+imgs_url+'/'+photoName+'.gif" alt="" width="150" height="150"></a>';
	
	return photoTxt;
}
function gotoPay(){
	window.location.href = ser_url+'/payment/';
}
function build_template(resdiv, mod_name)
{	
	var div_prefix	 = 'S';
	
	var rows	= json_arr.length;
	var img_gap = '<br clear="all"><div style="height:4px;"><img src="'+imgs_url+'/trans.gif" height="4"></div>';
	var img_gap1= '<div style="width:4px;" class="fleft"><img src="'+imgs_url+'/trans.gif" width="4"></div>';
	whole_cont	= ''; 
	for(var i=0; i<rows; i++)
	{
		if(sr_vi_ty == '1'){
		if(json_arr[i]['PU'] == '1'){
		var pt_img	  = (json_arr[i]['PT']=='2')?'premium':(json_arr[i]['PT']=='1')?'premium':'';
		
		//get online
		onli_res = Decode_it(json_arr[i]['ON']);
		onli_div = '';onli_msg='Within last ';
		 if(onli_res == 'NOW')
		{
			onli_msg  = 'Online Right NOW!';
			onli_link = (cook_id=='')?'sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');':((cook_paid=='1')?'launchIC(\''+cook_id+'\',\''+json_arr[i]['ID']+'\')' : 'gotoPay()');
			onli_div  = '<div class="fleft" style="padding:3px 5px 0px 5px;"> | <a onclick="'+onli_link+';"><font class="clr4">Online</font> - <font class="clr1">Chat Now!</font></a></div>';
		}
		else
		{
			onli_msg  += onli_res;
		} 

		decoded_DE = Decode_it(json_arr[i]['DE']);
		pro_arr = (decoded_DE).split('^~^');
		
		ctry = pro_arr[10];

		//caste related info
		cas_no_cont = (pro_arr[15] == '1')? '(CasteNoBar)' : '';
		subcas_no_cont = (pro_arr[17] == '1')? '(SubcasteNoBar)' : '';
			
		reli_cont  = (pro_arr[7] !='') ? pro_arr[7] : '';
		deno_cont  = (pro_arr[18] !='') ? (reli_cont!='' ? reli_cont+', '+pro_arr[18] : pro_arr[18]) : reli_cont;
		caste_cont = (pro_arr[8] !='') ? (deno_cont!='' ? deno_cont+', '+pro_arr[8]+cas_no_cont : pro_arr[8]+cas_no_cont) : deno_cont;
		subc_cont  = (pro_arr[9] !='') ? (caste_cont!='' ? caste_cont+', '+pro_arr[9]+subcas_no_cont : pro_arr[9]+subcas_no_cont) : caste_cont;
		subc_cont  = (subc_cont != '') ? '<font class="clr2"> | </font>'+subc_cont : '';
		ctry_stat = (ctry != '' && pro_arr[11] !='' && pro_arr[11] !='0') ? pro_arr[11]+', '+ctry : ctry;
		ctry_st_ci= (ctry != '' && pro_arr[12] !='' && pro_arr[12] !='0') ? pro_arr[12]+', '+ctry_stat : ctry_stat;
		edu_de	  = (pro_arr[3]!='Others' && pro_arr[3]!='') ? '<font class="clr2"> | </font>'+pro_arr[3] : (pro_arr[4] !='')? '<font class="clr2"> | </font>'+pro_arr[4] : '';
		occu_de	  = (pro_arr[5]!='Others' && pro_arr[5]!='') ? '<font class="clr2"> | </font>'+pro_arr[5] : (pro_arr[6] !='')? '<font class="clr2"> | </font>'+pro_arr[6] : '';
		
		starval='';
		//starval	  = pro_arr[16]==''?'':pro_arr[16]+', ';
		
		//Horoscope & compatability 
		horomatch = 'Average';
		comp_div = '<div class="cleard"></div>';
		/*if(json_arr[i]['PP'] != '0' && json_arr[i]['G'] != cook_gender)
		{
			comp_div = '<br clear="all"><div id="vpdiv4" class="smalltxt clr padtb5">Profile Match: <font class="clr1">'+json_arr[i]['PP']+'%</font>&nbsp; &nbsp; &nbsp; &nbsp;Horoscope Match: <font class="clr1">'+horomatch+'</font></div>';
		}*/

		//Photo div
		moreLink = '';
		if(json_arr[i]['PH'] == ''){	PhotoURL = div_photo(json_arr[i]['G'], json_arr[i]['ID'],i);}
		else if(json_arr[i]['PH'] == 'P') {
			if(json_arr[i]['G'] == 1) {
			  PhotoURL = div_photo('PM', json_arr[i]['ID'],i);
			}
			else {
			  PhotoURL = div_photo('PF', json_arr[i]['ID'],i);
			}
		}
		else {	PhotoURL = first_photo(json_arr[i]['PH'],json_arr[i]['TPH'],i,div_prefix,json_arr[i]['ID']);	}

		//Get Conatct & Features
		iconDet_arr  = (json_arr[i]['RIC']).split('^')
		img_cont_det = '';
		img_phone_det= '';
		img_horo_det = '';
		
		
		if(iconDet_arr[0]=='1' || iconDet_arr[0]=='3'){ 
		  if(cook_id!='') {
			   img_phone_det = '&nbsp;<a onclick="javascript:getViewProfile(\''+json_arr[i]['ID']+"','"+i+'\',\'\',\'\',\'\',\'phone\');opencollapse('+i+');imageswap(\'eview\','+i+');" class="clr1"><img src="'+imgs_url+'/reqphone.gif" border="0"/></a>';	
			   //img_phone_det='&nbsp;<img src="'+imgs_url+'/reqphone.gif" border="0"/>';
		   }
		   else {
		       img_phone_det = '&nbsp;<a onclick="sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');" class="clr1"><img src="'+imgs_url+'/reqphone.gif" border="0"/></a>';	
		   }
		}
        
		if(iconDet_arr[6]!='0' && iconDet_arr[8] !='0'){
		   if(cook_id!='') {
			img_cont_det='<font class="smalltxt clr3"><a onclick="show_box(\'event\',\'div_box'+i+'\');showContactHistory(\''+cook_id+'\',\''+json_arr[i]['ID']+'\',\'msgactpart'+i+'\',\'div_box'+i+'\',1);" class="clr1">Last Activity: </font></a><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';
			//img_cont_det='<font class="smalltxt clr3">Last Activity: </font><img src="'+imgs_url+'/'+iconDet_arr[6]+'.gif"><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';
	 	   }
		   else {
		    img_cont_det='<font class="smalltxt clr3"><a onclick="sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');" class="clr1">Last Activity: </font></a><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';
		   }
		}
		
        
		//Horoscope Part 
        image_url = varConfArr['domainimage'];

		if(iconDet_arr[9]=='1'){
            if(cook_id=='') {
			  img_horo_det = '&nbsp;<a onclick="sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
			else if(cook_paid == 1) {
			  img_horo_det = '&nbsp;<a onclick="window.open(\''+image_url+'/horoscope/viewhoroscope.php?ID='+json_arr[i]['ID']+'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');" class="clr1"><img src="'+imgs_url+'/horoscope.gif" border="0"/></a>';
			}
			else {
			  img_horo_det = '&nbsp;<a onclick="javascript:getViewProfile(\''+json_arr[i]['ID']+"','"+i+'\',\'\',\'\', \'\',\'horoscope\');opencollapse('+i+');imageswap(\'eview\','+i+');" class="clr1"><img src="'+imgs_url+'/horoscope.gif" border="0"/></a>';
			}
		 }
		 if(iconDet_arr[9]=='3'){
			if(cook_id=='') {
              img_horo_det = '&nbsp;<a onclick="sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
			else if(cook_paid == 1) {
			  img_horo_det = '&nbsp;<a onclick="window.open(\''+image_url+'/horoscope/viewhoroscope.php?ID='+json_arr[i]['ID']+'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
			else {
			  img_horo_det = '&nbsp;<a onclick="javascript:getViewProfile(\''+json_arr[i]['ID']+"','"+i+'\',\'\',\'\', \'\',\'horoscope\');opencollapse('+i+');imageswap(\'eview\','+i+');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
		 }
		
		

		//if(iconDet_arr[9]=='1'){img_horo_det='&nbsp;<img src="'+imgs_url+'/horoscope.gif" border="0"/>';}
		//if(iconDet_arr[9]=='3'){img_horo_det='&nbsp;<img src="'+imgs_url+'/genhoros.gif" border="0"/>';}

		//Basicview divs integrating
		
		if(pt_img!=''){pt_img='<img src="'+imgs_url+'/'+pt_img+'.gif" height="18" width="91" />';}
		//start_div = '<div class="normdiv"><div id="cont'+i+'" onmouseover="this.className=\'hoverdiv\';" onmouseout="this.className=\'\';"><div class="rpanelinner" style="border-top:1px solid #cbcbcb;"><div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div><div class="fright">'+pt_img+'</div></div><div class="cleard"></div><div class="fleft padtb10" id="checkdiv" style="width:30px;">';
		start_div = '<div class="normdiv bgclr2"><div id="cont'+i+'"><div class="cleard"></div><div class="fleft padtb10" id="checkdiv" style="width:30px;">';

		//var view_url = ser_url + '/login/?redirect='+ser_url+'/profiledetail/index.php?act=fullprofilenew~id='+json_arr[i]['ID'];
		var view_url = 'onclick="sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');"';
		if(cook_id !=''){
		start_div += '<input type="checkbox" name="chk_sr" value="'+json_arr[i]['ID']+'"/>';
		var view_url = 'href="'+ser_url+'/profiledetail/index.php?act=fullprofilenew&id='+json_arr[i]['ID']+'"';
		}
		//start_div += '</div><div id="mesgdiv" class="fleft padtb10" style="z-index:2001;"';
		start_div += '</div><div id="mesgdiv" class="fleft padt10">';
		
		onclckopt = '';
		if(cook_id !=''){
			onclckopt = '<div id="eview'+i+'"><img src="'+imgs_url+'/expview.gif" border="0" alt="" onclick="javascript:getViewProfile(\''+json_arr[i]['ID']+"', \'"+i+'\', \'\', \'\',\'\');fpconfirm=0;opencollapse('+i+');imageswap(\'eview\','+i+');" style="cursor:pointer;"></div>';
		}else{
			//onclckopt = '<div id="eview'+i+'"><img src="'+imgs_url+'/expview.gif" border="0" alt="" onclick="javascript:getViewProfile(\'\', \''+i+'\', \'\', \'\',\'\');opencollapse('+i+');imageswap(\'eview\','+i+');" style="cursor:pointer;"></div>';
		    onclckopt = '<div id="eview'+i+'"><img src="'+imgs_url+'/expview.gif" border="0" alt="" onclick="sel(\''+json_arr[i]['ID']+'\',\'\','+i+',\'1\');" style="cursor:pointer;"></div>';
		}
		
		resopt='<div id="mview'+i+'" style="display:none;"><img src="'+imgs_url+'/minview.gif" border="0" alt="" name="minview" onclick="closecollapse('+i+');imageswap(\'mview\','+i+');" style="cursor:pointer;"></div>';


		/*onclckopt = '';
		if(cook_paid!='' && cook_id !=''){
			onclckopt = 'onclick="javascript:getViewProfile(\''+json_arr[i]['ID']+"', \'"+i+'\', \'\', \'\',\'\')"';
		}else{
			onclckopt = 'onclick="javascript:getViewProfile(\'\', \''+i+'\', \'\', \'\',\'\')"';
		}*/
		
		//start_div += onclckopt+'><div id="vpdiv1" class="fleft">';
		start_div += '<div id="vpdiv2" class="fleft brdr bgclr5"><div id="smphdiv1">'+PhotoURL+'</div><center>'+moreLink+'</center></div><div id="vpdiv1" class="fleft"><div style="height:145px;">';
		
		if(checkcrawlingbotsexists == true) {
			content_div = '<div class="normtxt clr fleft bld padb10"><a class="normtxt bld clr" onMouseOver="this.className=\'normtxt bld clr1\'" onMouseOut="this.className=\'normtxt bld clr\'" target="_blank" '+view_url+'>'+json_arr[i]['ID']+'</a></div>'+comp_div+icon_div+comp_div+'<div id="vpdiv4" class="normtxt clr lh13 padt5">'+pro_arr[0]+' yrs, '+pro_arr[1]+subc_cont+' <font class="clr2">|</font> '+starval+ctry_st_ci+'  '+edu_de+' '+occu_de+'&nbsp;&nbsp;<a '+view_url+' target="_blank" class="clr1 smalltxt">Full Profile >></a></div>'+comp_div+'<div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div></div><div style="width:100%;"><center><div style="background-color:#ffffff;overflow:auto;"><div class="fleft bld tlleft" style="padding:10px 0px 10px 12px;">Like this member? <input type="button" class="button" value="Send Message" onclick="sel(\''+json_arr[i]['ID']+'\',\''+json_arr[i]['G']+'\','+i+',\'1\');" /></div><div class="fright tlright" style="padding-top:15px;padding-right:12px;">'+onclckopt+resopt+'</div></div></center></div></div><div id="div_box'+i+'" class="frdispdiv vishid posabs brdr1 bgclr2" style="padding:10px !important;padding:10px;padding-left:0px;"><div id="msgactpart'+i+'" class="tlleft"></div></div>';
		}
		else{
			icon_div = '';
			if(img_phone_det!='' || onli_div!='' || img_horo_det!=''){
				if(img_phone_det == '' && img_horo_det == '')
			    onli_div=onli_div.replace(' | ','');
			icon_div='<div style="height:22px;"><div class="fleft lcdiv"></div><div class="bgcdiv fleft smalltxt bld"><div style="padding-top:4px;" class="fleft">'+img_phone_det+img_horo_det+'</div>'+onli_div+'</div><div class="fleft rcdiv"></div></div>';
			}
		content_div = '<div class="normtxt clr fleft bld padb10"><a class="normtxt bld clr" onMouseOver="this.className=\'normtxt bld clr1\'" onMouseOut="this.className=\'normtxt bld clr\'" target="_blank" '+view_url+'>'+Decode_it(json_arr[i]['N'])+' ('+json_arr[i]['ID']+')</a></div><div class="fright">'+pt_img+'</div>'+comp_div+icon_div+comp_div+'<div id="vpdiv4" class="normtxt clr lh20 padt5">'+pro_arr[0]+' yrs, '+pro_arr[1]+subc_cont+' <font class="clr2">|</font> '+starval+ctry_st_ci+'  '+edu_de+' '+occu_de+'&nbsp;&nbsp;<a '+view_url+' target="_blank" class="clr1 smalltxt">Full Profile >></a></div>'+comp_div+'<div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div></div><div style="width:100%;"><div style="width:100% !important;width:350px;background-color:#ffffff;overflow:auto;"><div class="fleft bld tlleft" style="padding:10px 0px 10px 12px;">Like this member? <input type="button" class="button" value="Send Message" onclick="sel(\''+json_arr[i]['ID']+'\',\''+json_arr[i]['G']+'\','+i+',\'1\');" /></div><div class="fright tlright" style="width:100px;padding-top:15px;padding-right:12px;">'+onclckopt+resopt+'</div></div></div></div><div id="div_box'+i+'" class="frdispdiv vishid posabs brdr1 bgclr2" style="padding:10px !important;padding:10px;padding-left:0px;"><div id="msgactpart'+i+'" class="tlleft"></div></div>';
		}
		photo_div	= '<div id="vpdiv2" class="fleft"><div id="smphdiv1">'+PhotoURL+'</div><center>'+moreLink+onli_div+'</center></div>';

	/*	end_div		= '</div><div class="cleard"></div></div><div class="cleard"></div><div class="fleft viewoutbg" style="overflow:auto;width:560px;"><div class="fleft bld tlleft" style="padding:10px 0px 10px 12px;width:420px;">Like this member? <input type="button" class="button" value="Send Message" onclick="sel(\''+json_arr[i]['ID']+'\',\''+json_arr[i]['G']+'\','+i+',\'1\');" /></div><div class="fright tlright" style="width:100px;padding-top:15px;padding-right:12px;">'+onclckopt+resopt+'</div><div class="cleard"></div><div id="viewpro'+i+'"></div><div class="cleard"></div><div style="height:7px;" class="bgclr2"><img src="'+imgs_url+'/trans.gif" height="7"></div></div></div><div class="cleard"></div><div style="height:10px;"><img src="'+imgs_url+'/trans.gif" height="10"></div><div class="cleard"></div><div class="dotsep2"><img src="'+imgs_url+'/trans.gif" height="1"></div><div class="cleard"></div><div style="height:10px;"><img src="'+imgs_url+'/trans.gif" height="10"></div>';*/

		end_div		= '</div><div class="cleard"></div></div><div class="cleard"></div><div class="fleft viewoutbg" style="overflow:auto;width:560px;"><div class="cleard"></div><div id="viewpro'+i+'"></div><div class="cleard"></div><div style="height:7px;" class="bgclr2"><img src="'+imgs_url+'/trans.gif" height="7"></div></div></div><div class="cleard"></div><div style="height:10px;"><img src="'+imgs_url+'/trans.gif" height="10"></div><div class="cleard"></div><div class="dotsep2"><img src="'+imgs_url+'/trans.gif" height="1"></div><div class="cleard"></div><div style="height:10px;"><img src="'+imgs_url+'/trans.gif" height="10"></div>';
		
		whole_cont += start_div + content_div + end_div;


		}//publish1
		else{
			//start_div  = '<div class="normdiv"><div onmouseout="this.className=\'\';" onmouseover="this.className=\'hoverdiv\';" class=""><div id="mesgdiv" class="padtb10"><div style="padding-top:25px;text-align:center;height:50px;" class="smalltxt bld brdr">';
			start_div  = '<div class="normdiv bgclr2"><div class=""><div id="mesgdiv" class="padt10"><div style="padding-top:25px;text-align:center;height:50px;" class="smalltxt bld brdr">';
			
			unavmsg_cont='';
			if(json_arr[i]['PU']=='2'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is hidden.';
			}else if(json_arr[i]['PU']=='3'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is suspended.';
			}else if(json_arr[i]['PU']=='4'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is rejected.';
			}else if(json_arr[i]['PU']=='D'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' has been deleted.';
			}else if(json_arr[i]['PU']=='TD'){
			unavmsg_cont= 'This profile '+json_arr[i]['ID']+' is currently unavailable.';
			}

			end_div = '</div></div></div></div><br clear="all">';
			whole_cont += start_div+unavmsg_cont+end_div;
		}

		}//view 1
		else if(sr_vi_ty == '2'){}//view 2
		else if(sr_vi_ty == '4'){}//view 4
		else if(sr_vi_ty == '6'){}//view 6
	}
	$(resdiv).innerHTML = whole_cont;
}


function build_template_fetprof(resdiv, mod_name)
{	
	var div_prefix	 = 'S';
	
	var jj		= 50000;
	var rows	= fp_json_arr.length;
	var img_gap = '<br clear="all"><div style="height:4px;"><img src="'+imgs_url+'/trans.gif" height="4"></div>';
	var img_gap1= '<div style="width:4px;" class="fleft"><img src="'+imgs_url+'/trans.gif" width="4"></div>';
	whole_cont	= ''; 
	for(var i=0; i<rows; i++)
	{
		if(sr_vi_ty == '1'){
		if(fp_json_arr[i]['PU'] == '1'){
		var pt_img	  = (fp_json_arr[i]['PT']=='2')?'premium':(fp_json_arr[i]['PT']=='1')?'premium':'';
		
		//get online
		onli_res = Decode_it(fp_json_arr[i]['ON']);
		onli_div = '';onli_msg='Within last ';
		 if(onli_res == 'NOW')
		{
			onli_msg  = 'Online Right NOW!';
			onli_link = (cook_id=='')?'sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');':((cook_paid=='1')?'launchIC(\''+cook_id+'\',\''+fp_json_arr[i]['ID']+'\')' : 'gotoPay()');
			onli_div  = '<div class="fleft" style="padding:3px 5px 0px 5px;"> | <a onclick="'+onli_link+';"><font class="clr4">Online</font> - <font class="clr1">Chat Now!</font></a></div>';
		}
		else
		{
			onli_msg  += onli_res;
		} 

		decoded_DE = Decode_it(fp_json_arr[i]['DE']);
		pro_arr = (decoded_DE).split('^~^');
		
		ctry = pro_arr[10];

		//caste related info
		cas_no_cont = (pro_arr[15] == '1')? '(CasteNoBar)' : '';
		subcas_no_cont = (pro_arr[17] == '1')? '(SubcasteNoBar)' : '';
			
		reli_cont  = (pro_arr[7] !='') ? pro_arr[7] : '';
		deno_cont  = (pro_arr[18] !='') ? (reli_cont!='' ? reli_cont+', '+pro_arr[18] : pro_arr[18]) : reli_cont;
		caste_cont = (pro_arr[8] !='') ? (deno_cont!='' ? deno_cont+', '+pro_arr[8]+cas_no_cont : pro_arr[8]+cas_no_cont) : deno_cont;
		subc_cont  = (pro_arr[9] !='') ? (caste_cont!='' ? caste_cont+', '+pro_arr[9]+subcas_no_cont : pro_arr[9]+subcas_no_cont) : caste_cont;
		subc_cont  = (subc_cont != '') ? '<font class="clr2"> | </font>'+subc_cont : '';
		ctry_stat = (ctry != '' && pro_arr[11] !='' && pro_arr[11] !='0') ? pro_arr[11]+', '+ctry : ctry;
		ctry_st_ci= (ctry != '' && pro_arr[12] !='' && pro_arr[12] !='0') ? pro_arr[12]+', '+ctry_stat : ctry_stat;
		edu_de	  = (pro_arr[3]!='Others' && pro_arr[3]!='') ? '<font class="clr2"> | </font>'+pro_arr[3] : (pro_arr[4] !='')? '<font class="clr2"> | </font>'+pro_arr[4] : '';
		occu_de	  = (pro_arr[5]!='Others' && pro_arr[5]!='') ? '<font class="clr2"> | </font>'+pro_arr[5] : (pro_arr[6] !='')? '<font class="clr2"> | </font>'+pro_arr[6] : '';
		
		starval='';
		//starval	  = pro_arr[16]==''?'':pro_arr[16]+', ';
		
		//Horoscope & compatability 
		horomatch = 'Average';
		comp_div = '<div class="cleard"></div>';
		/*if(fp_json_arr[i]['PP'] != '0' && fp_json_arr[i]['G'] != cook_gender)
		{
			comp_div = '<br clear="all"><div id="vpdiv4" class="smalltxt clr padtb5">Profile Match: <font class="clr1">'+fp_json_arr[i]['PP']+'%</font>&nbsp; &nbsp; &nbsp; &nbsp;Horoscope Match: <font class="clr1">'+horomatch+'</font></div>';
		}*/

		//Photo div
		moreLink = '';
		if(fp_json_arr[i]['PH'] == ''){	PhotoURL = div_photo(fp_json_arr[i]['G'], fp_json_arr[i]['ID'],jj);}
		else if(fp_json_arr[i]['PH'] == 'P') {
			if(fp_json_arr[i]['G'] == 1) {
			  PhotoURL = div_photo('PM', fp_json_arr[i]['ID'],jj);
			}
			else {
			  PhotoURL = div_photo('PF', fp_json_arr[i]['ID'],jj);
			}
		}
		else {	PhotoURL = first_photo(fp_json_arr[i]['PH'],fp_json_arr[i]['TPH'],jj,div_prefix,fp_json_arr[i]['ID']);	}

		//Get Conatct & Features
		iconDet_arr  = (fp_json_arr[i]['RIC']).split('^')
		img_cont_det = '';
		img_phone_det= '';
		img_horo_det = '';
		
		
		if(iconDet_arr[0]=='1' || iconDet_arr[0]=='3'){ 
		  if(cook_id!='') {
			   img_phone_det = '&nbsp;<a onclick="javascript:getViewProfile(\''+fp_json_arr[i]['ID']+"','"+jj+'\',\'\',\'\',\'\',\'phone\');opencollapse('+jj+');imageswap(\'eview\','+jj+');" class="clr1"><img src="'+imgs_url+'/reqphone.gif" border="0"/></a>';	
			   //img_phone_det='&nbsp;<img src="'+imgs_url+'/reqphone.gif" border="0"/>';
		   }
		   else {
		       img_phone_det = '&nbsp;<a onclick="sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');" class="clr1"><img src="'+imgs_url+'/reqphone.gif" border="0"/></a>';	
		   }
		}
        
		if(iconDet_arr[6]!='0' && iconDet_arr[8] !='0'){
		   if(cook_id!='') {
			img_cont_det='<font class="smalltxt clr3"><a onclick="show_box(\'event\',\'div_box'+jj+'\');showContactHistory(\''+cook_id+'\',\''+fp_json_arr[i]['ID']+'\',\'msgactpart'+jj+'\',\'div_box'+jj+'\',1);" class="clr1">Last Activity: </font></a><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';
			//img_cont_det='<font class="smalltxt clr3">Last Activity: </font><img src="'+imgs_url+'/'+iconDet_arr[6]+'.gif"><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';
	 	   }
		   else {
		    img_cont_det='<font class="smalltxt clr3"><a onclick="sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');" class="clr1">Last Activity: </font></a><font class="smalltxt clr"> '+Decode_it(iconDet_arr[7])+': '+iconDet_arr[8]+'</font>';
		   }
		}
		
        
		//Horoscope Part 
        image_url = varConfArr['domainimage'];

		if(iconDet_arr[9]=='1'){
            if(cook_id=='') {
			  img_horo_det = '&nbsp;<a onclick="sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
			else if(cook_paid == 1) {
			  img_horo_det = '&nbsp;<a onclick="window.open(\''+image_url+'/horoscope/viewhoroscope.php?ID='+fp_json_arr[i]['ID']+'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');" class="clr1"><img src="'+imgs_url+'/horoscope.gif" border="0"/></a>';
			}
			else {
			  img_horo_det = '&nbsp;<a onclick="javascript:getViewProfile(\''+fp_json_arr[i]['ID']+"','"+jj+'\',\'\',\'\', \'\',\'horoscope\');opencollapse('+jj+');imageswap(\'eview\','+jj+');" class="clr1"><img src="'+imgs_url+'/horoscope.gif" border="0"/></a>';
			}
		 }
		 if(iconDet_arr[9]=='3'){
			if(cook_id=='') {
              img_horo_det = '&nbsp;<a onclick="sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
			else if(cook_paid == 1) {
			  img_horo_det = '&nbsp;<a onclick="window.open(\''+image_url+'/horoscope/viewhoroscope.php?ID='+fp_json_arr[i]['ID']+'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
			else {
			  img_horo_det = '&nbsp;<a onclick="javascript:getViewProfile(\''+fp_json_arr[i]['ID']+"','"+jj+'\',\'\',\'\', \'\',\'horoscope\');opencollapse('+jj+');imageswap(\'eview\','+jj+');" class="clr1"><img src="'+imgs_url+'/genhoros.gif" border="0"/></a>';
			}
		 }
		
		

		//if(iconDet_arr[9]=='1'){img_horo_det='&nbsp;<img src="'+imgs_url+'/horoscope.gif" border="0"/>';}
		//if(iconDet_arr[9]=='3'){img_horo_det='&nbsp;<img src="'+imgs_url+'/genhoros.gif" border="0"/>';}

		//Basicview divs integrating
		
		if(pt_img!=''){pt_img='<img src="'+imgs_url+'/'+pt_img+'.gif" height="18" width="91" />';}
		//start_div = '<div class="normdiv"><div id="cont'+jj+'" onmouseover="this.className=\'hoverdiv\';" onmouseout="this.className=\'\';"><div class="rpanelinner" style="border-top:1px solid #cbcbcb;"><div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div><div class="fright">'+pt_img+'</div></div><div class="cleard"></div><div class="fleft padtb10" id="checkdiv" style="width:30px;">';
		start_div = '<div class="dotsep2"><img src="'+imgs_url+'/trans.gif" height="1"></div><div class="cleard"></div><div style="height:10px;"><img src="'+imgs_url+'/trans.gif" height="10"></div><div class="cleard"></div><div class="normdiv feaprotopbg"><div class="fleft" style="padding-left:210px;padding-top:12px;color:#ffffff;">Want to feature your profile?</div><div class="fright" style="padding-top:12px;padding-right:12px;"><a href="'+ser_url+'/payment/index.php?act=profilehightlight" class="clr1">Subscribe to profile Highlighter</a></div></div>';
		start_div += '<div class="normdiv feaprobgclr" style="overflow:auto;"><div id="cont'+jj+'"><div class="cleard"></div><div class="fleft padtb10" id="checkdiv" style="width:30px;">';

		//var view_url = ser_url + '/login/?redirect='+ser_url+'/profiledetail/index.php?act=fullprofilenew~id='+fp_json_arr[i]['ID'];
		var view_url = 'onclick="sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');"';
		if(cook_id !=''){
		//start_div += '<input type="checkbox" name="chk_sr" value="'+fp_json_arr[i]['ID']+'"/>';
		var view_url = 'href="'+ser_url+'/profiledetail/index.php?act=fullprofilenew&id='+fp_json_arr[i]['ID']+'"';
		}
		//start_div += '</div><div id="mesgdiv" class="fleft padtb10" style="z-index:2001;"';
		start_div += '</div><div id="mesgdiv" class="fleft padtb10">';
		
		onclckopt = '';
		if(cook_id !=''){
			onclckopt = '<div id="eview'+jj+'"><img src="'+imgs_url+'/expview.gif" border="0" alt="" onclick="javascript:getViewProfile(\''+fp_json_arr[i]['ID']+"', \'"+jj+'\', \'\', \'\',\'\');opencollapse('+jj+');imageswap(\'eview\','+jj+');" style="cursor:pointer;"></div>';
		}else{
			//onclckopt = '<div id="eview'+jj+'"><img src="'+imgs_url+'/expview.gif" border="0" alt="" onclick="javascript:getViewProfile(\'\', \''+jj+'\', \'\', \'\',\'\');opencollapse('+jj+');imageswap(\'eview\','+jj+');" style="cursor:pointer;"></div>';
		    onclckopt = '<div id="eview'+jj+'"><img src="'+imgs_url+'/expview.gif" border="0" alt="" onclick="sel(\''+fp_json_arr[i]['ID']+'\',\'\','+jj+',\'1\');" style="cursor:pointer;"></div>';
		}
		
		resopt='<div id="mview'+jj+'" style="display:none;"><img src="'+imgs_url+'/minview.gif" border="0" alt="" name="minview" onclick="closecollapse('+jj+');imageswap(\'mview\','+jj+');" style="cursor:pointer;"></div>';


		/*onclckopt = '';
		if(cook_paid!='' && cook_id !=''){
			onclckopt = 'onclick="javascript:getViewProfile(\''+fp_json_arr[i]['ID']+"', \'"+jj+'\', \'\', \'\',\'\')"';
		}else{
			onclckopt = 'onclick="javascript:getViewProfile(\'\', \''+jj+'\', \'\', \'\',\'\')"';
		}*/
		
		//start_div += onclckopt+'><div id="vpdiv1" class="fleft">';
		start_div += '<div id="vpdiv2" class="fleft brdr bgclr5"><div id="smphdiv1">'+PhotoURL+'</div><center>'+moreLink+'</center></div><div id="vpdiv1" class="fleft">';
		
		if(checkcrawlingbotsexists == true) {
			content_div = '<div class="normtxt clr fleft bld padb10"><a class="normtxt bld clr" onMouseOver="this.className=\'normtxt bld clr1\'" onMouseOut="this.className=\'normtxt bld clr\'" target="_blank" '+view_url+'>'+fp_json_arr[i]['ID']+'</a></div>'+comp_div+icon_div+comp_div+'<div id="vpdiv4" class="normtxt clr lh13 padt5">'+pro_arr[0]+' yrs, '+pro_arr[1]+subc_cont+' <font class="clr2">|</font> '+starval+ctry_st_ci+'  '+edu_de+' '+occu_de+'&nbsp;&nbsp;<a '+view_url+' target="_blank" class="clr1 smalltxt">Full Profile >></a></div>'+comp_div+'<div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div></div><div id="div_box'+jj+'" class="frdispdiv vishid posabs brdr1 bgclr2" style="padding:10px !important;padding:10px;padding-left:0px;"><div id="msgactpart'+jj+'" class="tlleft"></div></div>';
		}
		else{
			icon_div = '';
			if(img_phone_det!='' || onli_div!='' || img_horo_det!=''){
				if(img_phone_det == '' && img_horo_det == '')
			    onli_div=onli_div.replace(' | ','');
			icon_div='<div style="height:22px;"><div class="fleft lcdiv"></div><div class="bgcdiv fleft smalltxt bld"><div style="padding-top:4px;" class="fleft">'+img_phone_det+img_horo_det+'</div>'+onli_div+'</div><div class="fleft rcdiv"></div></div>';
			}
		content_div = '<div class="normtxt clr fleft bld padb10"><a class="normtxt bld clr" onMouseOver="this.className=\'normtxt bld clr1\'" onMouseOut="this.className=\'normtxt bld clr\'" target="_blank" '+view_url+'>'+Decode_it(fp_json_arr[i]['N'])+' ('+fp_json_arr[i]['ID']+')</a></div><div class="fright">'+pt_img+'</div>'+comp_div+icon_div+comp_div+'<div id="vpdiv4" class="normtxt clr lh20 padt5">'+pro_arr[0]+' yrs, '+pro_arr[1]+subc_cont+' <font class="clr2">|</font> '+starval+ctry_st_ci+'  '+edu_de+' '+occu_de+'&nbsp;&nbsp;<a '+view_url+' target="_blank" class="clr1 smalltxt">Full Profile >></a></div>'+comp_div+'<div class="fleft" style="padding-top:2px;">'+img_cont_det+'</div></div><div id="div_box'+jj+'" class="frdispdiv vishid posabs brdr1 bgclr2" style="padding:10px !important;padding:10px;padding-left:0px;"><div id="msgactpart'+jj+'" class="tlleft"></div></div>';
		}
		photo_div	= '<div id="vpdiv2" class="fleft"><div id="smphdiv1">'+PhotoURL+'</div><center>'+moreLink+onli_div+'</center></div>';

		end_div		= '</div><div class="cleard"></div></div><div class="cleard"></div><div class="fleft feaproviewoutbg" style="overflow:auto;width:560px;"><div class="fleft bld tlleft" style="padding:10px 0px 10px 12px;width:420px;">Like this member? <input type="button" class="button" value="Send Message" onclick="sel(\''+fp_json_arr[i]['ID']+'\',\''+fp_json_arr[i]['G']+'\','+jj+',\'1\');" /></div><div class="fright tlright" style="width:100px;padding-top:15px;padding-right:12px;">'+onclckopt+resopt+'</div><div class="cleard"></div><div id="viewpro'+jj+'"></div><div class="cleard"></div><div style="height:7px;" class="feaprobgclr"><img src="'+imgs_url+'/trans.gif" height="7"></div></div></div><div class="cleard"></div><div style="height:5px;"><img src="'+imgs_url+'/trans.gif" height="5"></div><div class="cleard"></div>';
		
		whole_cont += start_div + content_div + end_div;


		}//publish1

		}//view 1
	}
	$(resdiv).innerHTML = whole_cont;
}