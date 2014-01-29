/* FILENAME:smartsearchjs.php | AUTHORS: saravanann@bharatmatrimony.com / andal@bharatmatrimony.com | DESC: BM results related AJAX   */
/**************************************************************************************************************************************/
var Jsg_fade='0~0',Jsg_sc=0,Jsg_reg_form=0,ST_pw=75,ST_ph=75,Jsg_c_pro=0;Jsg_da=new Array(); Jsg_da['B']='bengali';Jsg_da['R']='marathi';Jsg_da['G']='gujarati';Jsg_da['P']='punjabi';Jsg_da['H']='hindi';Jsg_da['S']='sindhi';Jsg_da['K']='kannada';Jsg_da['E']='kerala';Jsg_da['T']='telugu';Jsg_da['M']='tamil';Jsg_da['D']='marwadi';Jsg_da['C']='parsi';Jsg_da['A']='assamese';Jsg_da['Y']='oriya';Jsg_da['U']='urdu';var no_rec_err="Sorry, we couldn't find any results to suit your search criteria. Perhaps your search was too specific? Try choosing broader categories. If after refining your search criteria you continue to face similar problems, kindly clear your cache or refresh your browser.";

function display_client_error(err_msg,e) { //last errno twenty
	Jsg_req=0;var dd=$("disp_div");var fnam='';
	if(e=="abort") {
		dd.innerHTML='<font onclick="javascript:$load_currentpage(\'one\',\'imgonload\')">Sorry, Server response time is very low. Please <font class="clr1">click here</font> to try again.</font>';
	} else if(e=='five' || e=='six' || e=='ten') {
		if(Jsg_search_type=='KEYWORD') fnam='smartkeywordsearch.php';
		else if(Jsg_search_type=='REGULARSEARCH') fnam='search.php';
		else if(Jsg_search_type=='whos_online') fnam='membersonlinesearch.php';
		else fnam='search.php?typ=ad';
		dd.innerHTML="Please resubmit the form. <a href="+fnam+" class='clr1'>click here</a>";
		$BN('search_div','n');
	} else {
		dd.innerHTML=no_rec_err;
	}
	//var Debug_http=new $getHTTPObject();
	//Debug_http.open("GET",uncache('searchsendmail.php?err_msg='+err_msg+'&e='+e), true); Debug_http.send(null);
	$BN('disp_div','b');dd.style.height='800px';
	$BN('search_div','n');
}

function get_cookie_page_number(where_from) {
	if(where_from=='imgonload') {
		var coo=$readCookie(Jsg_c_name).split('~');
		if(coo!='err') { return coo[1];} 
		else { $createCookie(Jsg_c_name,Jsg_tt+'~1~'+Jsg_old_tt);return 'one';}
	} else {
		var newcp=Math.ceil(parseInt(((Jsg_curpage-1)*parseInt((eval("Jsg_"+Jsg_old_tt+"_arr[2]")))+1)/(eval("Jsg_"+Jsg_tt+"_arr[2]"))))+1;
		if(newcp==0 || newcp=='') newcp=1;
		$createCookie(Jsg_c_name,Jsg_tt+'~'+newcp+'~'+Jsg_old_tt);
		return newcp;
	}
}

function search_reg_form(t) {
	if(Jsg_memberid=='' && Jsg_where_from!='imgonload' && t!='showresult' && Jsg_total_pages>5 && (Jsg_curpage%5)==0) {		window.open(Jsg_wwwdomain_path+'register/addmatrimony.php?frompg=search','reg_form','fullscreen=yes,directories=yes,location=yes,menubar=yes,resizable=yes,scrollbars=yes,status=yes,toolbar=yes,titlebar=yes');
	displayNone(Jsg_divname_end_org);
	}
}

function check_next_div(check_div_page) {

	try { var cdiv=$(Jsg_div_preffix+check_div_page);
	if(cdiv=='') {
		(arguments[1])?t=arguments[1]:t='s';
		//search_reg_form(t);
		if(Jsg_where_from!='imgonload') {
			loading_divs("<img src='"+Jsg_akka+"/bmimages/small_loading.gif'>","load"); 
		}

		var divname_tp=Math.floor(parseInt(check_div_page/Jsg_pp_req));
		if((check_div_page % Jsg_pp_req)==0) divname_tp--;

		Jsg_divname_start=parseInt((divname_tp*Jsg_pp_req)+1);
		Jsg_divname_end=parseInt((divname_tp*Jsg_pp_req)+Jsg_pp_req);

		if((Jsg_divname_end_org < Jsg_divname_end) || Jsg_divname_end_org=='') { Jsg_divname_end_org=Jsg_divname_end;}

		(Jsg_where_from=='imgonload' || Jsg_search_type=='members_online' || Jsg_search_type=='whos_online') ? append_total_url='total_record=true&' : append_total_url='';

		var paramsinurl=append_total_url+'DISPLAY_FORMAT='+Jsg_tt+'&randid='+Jsg_randid+'&cpage='+check_div_page;
		document.smartform.DISPLAY_FORMAT.value=Jsg_tt;
		Jajax_http.open('POST',Jsg_requesturl+uncache(paramsinurl),true);		

		Jajax_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');
		Jajax_http.send(fields_for_post());Jsg_req=1;

		requestTimer=setTimeout(function() { Jajax_http.abort();display_client_error('','abort');},300000);
		$BN('search_div','b');
		$BN('disp_div','n');
		Jajax_http.onreadystatechange=$serverResponse;
	} } catch(e) { display_client_error(e,'five');}
}

function display_server_error(t) {
	loading_divs('');if(t=='')t=no_rec_err;
	if($('chkboxes_cont')!='') {
		$BN('chkboxes_cont','n');		
	}
	var dd=$('disp_div');dd.innerHTML=Decode_it(t);dd.style.height='800px'; $BN('disp_div','b'); 
	$BN('search_div','n');
}

function $serverResponse() {
	try{ if(Jajax_http.readyState!=4) return;
	if(Jajax_http.readyState==4 && Jajax_http.status==200) {
		Jsg_req=0;clearTimeout(requestTimer);
		var dyn_pages='',html_content='',reccheck=1,recnum_start=0,recnum_end=Jsg_resultperpage;
		var getjprofiles=(Jajax_http.responseText).split('#~^*^~#');

		if(Jsg_d_param==Jsg_d_val && Jsg_d_param!="") {
			$BN('test','b');
			$("test").innerHTML="<textarea style='width:300px;height:50px;'>"+getjprofiles[4]+"</textarea>"; 
		}

		if($IsNumeric(getjprofiles[0].substring(0,1))==1) { /* unexpected */
			display_client_error(getjprofiles[0],'ten');return;
		} else if(getjprofiles[0]>1) { /* negative */
			display_server_error(getjprofiles[1]);return;
		} else if(getjprofiles[0]==1) { /* positive */
			$BN('dprofile','b');			
			$('dprofile').innerHTML='<p class="smalltxt">'+Decode_it(getjprofiles[1])+'</p>';
		}

		JDoc=JSON.parse(getjprofiles[3],'');
		dyn_pages=$('dyn_pages');

		if(Jsg_where_from=='imgonload' || Jsg_search_type=='members_online' || Jsg_search_type=='whos_online') {
			dyn_pages.innerHTML='';
			Jsg_total_records=parseInt(getjprofiles[2]);

			if($IsNumeric(Jsg_total_records)==1) { 
				display_server_error(getjprofiles[1]);return;
			} else {
				if(Jsg_total_records==0) {
					display_server_error(getjprofiles[1]);return;
				}
				Jsg_total_pages=Math.ceil(Jsg_total_records/parseInt(Jsg_resultperpage));
				Jsg_allblocks=Math.ceil(Jsg_total_pages/Jsg_pp_req);
			}
		} else {
			if(Jsg_old_tt!=Jsg_tt) {
				Jsg_total_pages=Math.ceil(Jsg_total_records/parseInt(Jsg_resultperpage));
				Jsg_allblocks=Math.ceil(Jsg_total_pages/Jsg_pp_req);
			}
		}

		if(Jsg_search_type=='KEYWORD' && Jsg_total_records>0) {
			bms_pop_checkbox(JDoc.profiles['chks']);
		}

		assign_tr_td();

		for(var z=Jsg_divname_start;z<=Jsg_divname_end;z++) {
			var cdiv=$(Jsg_div_preffix+z);
			
			if(z<=Jsg_total_pages && cdiv=='') {
				newdiv=document.createElement('div');
				newdiv.setAttribute('id',Jsg_div_preffix+z);newdiv.setAttribute('style','display:none;');
				var running_block=parseInt(((Math.ceil(z/Jsg_pp_req))-1)*(Jsg_resultperpage*Jsg_pp_req));

				html_content='';
				for(i=parseInt(recnum_start);i<parseInt(recnum_end);i++) { 
					if((running_block+parseInt(i))>=Jsg_total_records) break; 

					if(JDoc.profiles[i]==null || JDoc.profiles[i]=="null" || JDoc.profiles[i]=="undefined" || JDoc.profiles[i]==undefined ) break;

					//if(JDoc.profiles[i].MId=="") break;

					assign_vars();/*re-assign vars*/

					split_raw_json(z,i);/*split json as arrays*/

					html_content=html_content+srch_display_template(z,i)+divider_content(i);
				}
				newdiv.innerHTML=html_content;
				dyn_pages.appendChild(newdiv);
			}
			reccheck++;recnum_start=((reccheck-1)*Jsg_resultperpage);recnum_end=(reccheck*Jsg_resultperpage);
		}

		$replace_image(Jsg_div_preffix+Jsg_curpage,1);displayNone(Jsg_divname_end_org);

		if(Jsg_tt=='one' && Jsg_total_pages>1 && Jsg_sc==0) {add_shortcut();SC_first('firsttime');}

		if(Jsg_total_pages>=1) {
			loading_divs($displayLink(5));
		} else { 
			loading_divs('');
		}
		if(Jsg_search_type=='members_online' || Jsg_search_type=='whos_online') {
			$BN(Jsg_div_preffix+Jsg_curpage,'b');
		}
	}
	} catch(e) { display_client_error(e,'six');} 
}

function $replace_image(d,t) {
	var cdiv=$(d);var tpimage=cdiv.innerHTML;
	if(tpimage!="" && cdiv!="") {
		cdiv.innerHTML=tpimage.replace(eval("/"+Jsg_srch_image+"/gi"),'img');
	}
}

function split_raw_json(z,i) {
	try {
	J_Mid=JDoc.profiles[i].MId;
	J_Name=JDoc.profiles[i].N;
	J_Photos=JDoc.profiles[i].P;
	J_ico_arr=JDoc.profiles[i].ICO.split('^');
	J_compbar_per=JDoc.profiles[i].PP;
	J_LastLogin=JDoc.profiles[i].LE;
	J_LL_array=J_LastLogin.split('^');
	J_Desc=JDoc.profiles[i].TD;
	J_Enlarge=JDoc.profiles[i].EP;
	J_classname=get_borderclass_name(parseInt(J_ico_arr[10]));
	} catch(e) { display_client_error(e,'eleven');} 
}

function getuppericon(cpro) {
	var up='';
	Jsg_ei_con_link=get_express_interest_link(J_ico_arr[12],cpro);
	if(J_ico_arr[10]==2) {
		up='<div class="useracticonsimgs clssupr" style="float:left;padding: 0px 0px 0px 3px;" title="Classic Super Member"></div>';
	}	

	up+='<div id="innerbookmark'+cpro+'" style="float:left;padding:2px 0px 0px 3px;">';

	if(J_ico_arr[6]=='Y') {
		up+='<a href="javascript:;" onclick="javascript:fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'/memberlist/bookmark.php?divname=innerbookmark'+cpro+'&divname_1=innerignored'+cpro+'&type=b&bookmarkedid='+J_Mid+'&shlink=linkbk_'+cpro+'&operation=a\',\'\',\'dispcontent\',\'\',\'\');" class="clr1"><div class="useracticonsimgs shortlist pntr" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your Shortlist"></div></a>&nbsp;';
	}
	up+='</div>';
	
	up+='<div id="innerignored'+cpro+'" style="float:left">';
	if(J_ico_arr[8]=='Y') {
		up+='<div class="useracticonsimgs ignore" style="float:left;padding: 0px 0px 0px 3px;" title="This member is currently in your Ignore List" ></div>';
	}
	up+='</div>';

	up+='<div id="innerblock'+cpro+'" style="float:left;">';
	if(J_ico_arr[7]=='Y') {
		up+='<div class="useracticonsimgs profiledeclined fleft" style="padding: 0px 0px 0px 3px;" title="This member is currently in your Block List"></div>&nbsp;';
	}
	up+='</div>';	
	if(J_ico_arr[13]=='Y') {
		up+=get_health_link(cpro);
	}
	up+=get_online_link(J_ico_arr[11]);	
	var pre_str='<div class="fleft">';

	if(Jrmi!="rmi"){ pre_str+=up; } 

	return pre_str+'</div><br clear="all">';		  
}

function srch_display_template(p,i) {
try {
	var sub_content='',mouse_over_cont='',ph_content='';
	var ph_array=new Array();ph_array[0]='',ph_array[1]='';

	var cpro=parseInt((Jsg_divname_start-1)*10)+(i+1);
	ph_content=firsttime_photo('M'+cpro,1,J_Mid,'SI'+cpro,'BI'+cpro,'PT'+cpro,J_Photos,J_Enlarge,1,'intial',J_LL_array[2]);
	ph_array=ph_content.split('~');

	if(Jsg_tt=='one') {
		var comp_bar='';
		if(J_ico_arr[12]!=3 && J_ico_arr[12]!=0 && J_ico_arr[12]!='') {
			var comp_link="<a href='javascript:;' onclick=\"javascript:fade('M"+cpro+"','fadediv','dispdiv','450','','','smartcompatibilitystatus.php?ID="+J_Mid+"&N="+J_Name+"&s="+J_compbar_per+"','','dispcontent','','');\" class='smalltxt clr1'>";
			var comp_status="Compatibility status - "+J_compbar_per+"%";
			var comp_img="<img src='"+Jsg_akka+"/bmimages/smart_pp_bar_"+J_compbar_per+".gif' width='100' height='12' border='0' title='Indicates how compatible you are with this member'>";
			if(Jrmi=="rmi") {
				comp_bar=comp_status+"&nbsp;"+comp_img;
		   } else {
				comp_bar=comp_link+comp_status+"</a>&nbsp;"+comp_link+comp_img+"</a>";
		   }
		}
		var do_name=Jsg_dmname_prefix+Jsg_da[J_Mid.substring(0,1)]+"matrimony.com";
		var domainnamebmimg=Jsg_imgs+"."+DOMAINARRAY['domainnameshort']+"matrimony.com";

		sub_content='<a id="P'+cpro+'"></a><div class="fleft middiv2" id="M'+cpro+'" style="padding-top:0px;"><div class="fleft">'+get_chekcbox('STP'+cpro+'','fn')+'</div><div class="fleft vc6pd-top smalltxt1" onClick="chkbox_check(\'STP'+cpro+'\');">Select this profile</div><div class="fright"><div class="smalltxt">'+view_bookmark_similarprofile(cpro)+'</div></div></div><br clear="all"/><div class="'+J_classname+'"><div class="vcpad"><div class="vc-dl"><div class="smalltxt clr1">'+comp_bar+'</div><div style="padding-top:7px;"><div class="fleft"><div id="SI'+cpro+'">'+ph_array[0]+'</div><div id="BI'+cpro+'"></div><div id="PT'+cpro+'">'+ph_array[1]+'</div></div><div class="fleft vc1-wt"><div class="vc-padl"><div class="smalltxt"><div class="fleft" ><span id="SC'+cpro+'" class="errortxt"></span>'+view_profile(J_Name,'Mid')+'&nbsp;</div>'+getuppericon(cpro)+'<span class="smalltxt1 clr2">Active: '+Decode_it(J_LL_array[0])+' </span><br/>'+Decode_it(J_Desc)+'&nbsp;&nbsp;&nbsp;&nbsp;'+view_profile('','')+'</div></div></div></div></div>';	
		if(Jrmi!="rmi"){
			sub_content=sub_content+'<div class="fleft dotline" style="height:105px;margin:3px 10px 0px 0px;"></div><div class="fleft icon"><div id="I'+cpro+'" onMouseover="javascript:iconview(\'I'+cpro+'\',\'icondiv_'+J_Mid+'\',\''+do_name+'\',\''+domainnamebmimg+'\',\''+J_Mid+'\',\''+J_ico_arr[0]+'\',\''+J_ico_arr[1]+'\',\''+J_ico_arr[2]+'\', \''+J_ico_arr[3]+'\',\''+J_ico_arr[4]+'\',\''+J_ico_arr[9]+'\',\''+J_ico_arr[5]+'\',\'M'+cpro+'\');">'+get_right_icons()+'</div></div>';
		}
		sub_content=sub_content+'<br clear="all"/></div>'+Jsg_ei_con_link+'</div><br clear="all"/><div class="borderline"><img src="'+Jsg_akka+'/bmimages/trans.gif" height="1" width="504"></div><br clear="all"/>';

		return sub_content;
	} else if(Jsg_tt=='six') {
		sub_content='<div class="'+J_classname+'"><div class="vcpad"><div class="vc6-dl"><div class="vc6pd-top"><div class="fleft">';
		sub_content+='<div id="SI'+cpro+'">'+ph_array[0]+'</div>';
		sub_content+='</div><div class="fleft vc6-wt"><div class="smalltxt vc4-padl">'+view_profile(J_Name,'Mid')+' <br/>'+Decode_it(J_Desc)+'<br/>'+view_profile('','')+'</div></div></div></div></div></div>';
		return sub_content;
	} else if(Jsg_tt=='two') {
		sub_content='<div class="'+J_classname+'"><div class="vcpad"><div class="vc2-dl"><div class="vcpd-top"><div class="fleft"><div id="SI'+cpro+'">'+ph_array[0]+'</div><div id="PT'+cpro+'">'+ph_array[1]+'</div></div><div class="fleft vc2-wt"><div class="smalltxt clr2 vc-padl"><div class="fleft">'+view_profile(J_Name,'Mid')+'</div><br clear="all"/>'+Decode_it(J_Desc)+'<br/>'+view_profile('','')+'</div></div></div></div></div></div>';
		return sub_content;
	} else if(Jsg_tt=='four') {
		sub_content='<div class="'+J_classname+'"><div class="vcpad"><div class="vc2-dl"><div class="vcpd-top"><div class="fleft">'+ph_array[0]+'</div><div class="fleft vc2-wt"><div class="smalltxt vc4-padl">'+view_profile(J_Name,'Mid')+' <br/>'+Decode_it(J_Desc)+'<br/>'+view_profile('','')+'</div></div></div></div></div></div>';
		return sub_content;
	}
	} catch(e) { display_client_error(e,'tweleve');} 
}

function fields_for_post() {
	var field_arr_val='',d='',data2='';
	for(field_arr_val=0;field_arr_val<Jsg_field_array.length;field_arr_val++) { d='';
		if(Jsg_field_array[field_arr_val]!=undefined && Jsg_field_array[field_arr_val]!='undefined') {
			if(Jsg_search_type=='KEYWORD') {
				if(Jsg_field_array[field_arr_val]=='keytext') { /* for keyword search text box */ d=Jsg_field_array[field_arr_val]+"="+escape(eval("document.smartform."+Jsg_field_array[field_arr_val]+".value"))+"&";
				} else {
					var ftp=eval("document.smartform."+Jsg_field_array[field_arr_val]+".value");
					if(ftp!="undefined" && ftp!=undefined) {
						d=Jsg_field_array[field_arr_val]+"="+ftp+"&";
					}
				}
			}
			else {
				d=Jsg_field_array[field_arr_val]+"="+eval("document.smartform."+Jsg_field_array[field_arr_val]+".value")+"&";
			}
		} data2=data2+d;
	} return data2;
}

function $form_contact(f) {
	var a;a=findchk(',',f);
	if(a=='') { fade('myphid','fadediv','dispdiv','400','','','searchresultpop.php?getp=sendm','','dispcontent','',''); } 
	else { fade('myphid','fadediv','dispdiv',550,'','','/inbox/inbcontact.php?ID='+a,'','dispcontent','',''); }
}

function $form_express(f) {
	var s;s=findchk('~',f);	
	if(s=='') { fade('myphid','fadediv','dispdiv','400','','','searchresultpop.php?getp=exp&t='+arguments[1],'','dispcontent','',''); }
	if(Jsg_memberid!='') {
		if(s!=='') { fade('horodiv','fadediv','dispdiv',534,'','', '/expressinterest/geteioptions.php?all=1&t='+s,'','dispcontent','',''); }
	} else {		
		eval("document."+f+".action=Jsg_wwwdomain_path+'register/addmatrimony.php?frompg=ei&fname=expressinterest/expressids.php?ID='+s");
		eval("document."+f+".submit()");
	}
}

function $form_forward(f) {
	var a;a=findchk(',',f);
	if(a=='') { fade('myphid','fadediv','dispdiv','400','','','searchresultpop.php?getp=fwd&t='+arguments[1],'','dispcontent','',''); }
	else { fade('horodiv','fadediv','dispdiv',550,'','', '/profiledetail/bmredirect.php?id='+a,'','dispcontent','',''); }
}

function get_pp_ppp(wherefrom) {
	if(Jsg_search_type=='whos_online' || Jsg_search_type=='members_online') {
		Jsg_resultperpage=eval("Jsg_"+Jsg_tt+"_arr[2]"); Jsg_pp_req=1;
	} else if(wherefrom=="imgonload") {
		Jsg_resultperpage=eval("Jsg_"+Jsg_tt+"_arr[2]"); Jsg_pp_req=eval("Jsg_"+Jsg_tt+"_arr[1]");
	} else if(wherefrom=="frompaging") {
		Jsg_resultperpage=eval("Jsg_"+Jsg_tt+"_arr[2]"); Jsg_pp_req=eval("Jsg_"+Jsg_tt+"_arr[0]");
	} 
	
}
function change_dtype(dt) {
	if(Jsg_req!=0) { return; }
	var tp='';
	get_pp_ppp(arguments[1]);
	if(Jsg_search_type=='whos_online' || Jsg_search_type=='members_online') {
		tp='<div class="smalltxt">Displayed below are the members who match your search criteria among those currently online. Click on the <img src="'+Jsg_akka+'/bmimages/online.gif" width="53" height="17" border="0" style="vertical-align:bottom;">&nbsp;&nbsp;icon to chat with them.&nbsp;';
		if(Jsg_search_type=='members_online' && Jsg_memberid=='') {			
			var ge="",ged="";
			if(Jsg_Mem_gen=='M') { ge="F"; ged="Female"; } 
			else { ge="M"; ged="Male"; }
			tp+='<a href="smartsearch.php?SEARCH_TYPE=members_online&DISPLAY_FORMAT=one&gen='+ge+'" class="clr1">Click here to view '+ged+' Profiles.</a>';
		} tp+='</div>';
	} else {
		tp='<div class="smalltxt">Here are the results based on your search criteria. If you\'re looking for better results, please refine your search criteria.</div>';
	}
	switch(Jsg_tt) {
		case 'one':
		if(arguments[1]!='imgonload') { $('dprofile').innerHTML=tp; }
		$BN('viewbn','b'); $BN('view6f','b'); $BN('view2f','b'); $BN('view4f','b'); $BN('disp_expdiv','b'); $BN('disp_expdiv1','b'); $BN('viewbf','n'); $BN('view6n','n'); $BN('view2n','n'); $BN('view4n','n'); $BN('shbrdr','n');
		break;

		case 'six':
		$('dprofile').innerHTML=tp;
$BN('viewbf','b'); $BN('view2f','b');$BN('view4f','b');$BN('view6n','b');$BN('view2n','n');$BN('view4n','n');$BN('viewbn','n');$BN('view6f','n');$BN('shbrdr','b');$BN('disp_expdiv','n');$BN('disp_expdiv1','n');
		break;

		case 'four':
		$('dprofile').innerHTML=tp;
$BN('view2f','b');$BN('view4n','b');$BN('viewbf','b');$BN('view6f','b');$BN('viewbn','n');$BN('view2n','n');$BN('view4f','n');$BN('view6n','n');$BN('shbrdr','b');$BN('disp_expdiv','n');$BN('disp_expdiv1','n');
		break;

		case 'two':
		$('dprofile').innerHTML=tp;
$BN('view6f','b');$BN('view2n','b');$BN('viewbf','b');$BN('view4f','b');$BN('viewbn','n');$BN('view2f','n');$BN('view4n','n');$BN('view6n','n');$BN('disp_expdiv','n');$BN('disp_expdiv1','n');$BN('shbrdr','b');
		break;
	}
}

function photo_paging(enpid,maindiv,cp,pmid,cid,bigimgid,pid,imgpath,fullpath,paging,alldivs) {
try {
	var next='',pre='';
	next_cp=cp+1;if(next_cp > alldivs) { next_cp=0;}
	previous_cp=cp-1;if(previous_cp < 0) { previous_cp=0;}

	var pre='<div style="padding:5px 0px 0px 15px;">';
	var inter='<div class="phnumpadd smalltxt fleft" style="padding-top:1px;">'+cp+'&nbsp;of&nbsp;'+alldivs+'</div>';

	if(alldivs>1) { 
		if(previous_cp!=0) {
			pre+='<div class="fleft vc6pd-top"><a href="javascript:;" onClick="javascript:firsttime_photo(\''+maindiv+'\','+previous_cp+',\''+pmid+'\',\''+cid+'\',\''+bigimgid+'\',\''+pid+'\',\''+imgpath+'\',\''+fullpath+'\','+paging+',\'\',\''+enpid+'\');"><div class="useracticonsimgs phnavlfton"></div></a></div>';
		} else {
			pre+='<div class="fleft vc6pd-top"><div class="useracticonsimgs phnavlftoff"></div></div>';
		}

		if(next_cp!=0) { 
			next='<div class="fleft vc6pd-top"><a href="javascript:;" onClick="javascript:firsttime_photo(\''+maindiv+'\','+next_cp+',\''+pmid+'\',\''+cid+'\',\''+bigimgid+'\',\''+pid+'\',\''+imgpath+'\',\''+fullpath+'\','+paging+',\'\',\''+enpid+'\');"><div class="useracticonsimgs phnavrigon"></div></a></div>';
		} else { 
			next='<div class="fleft vc6pd-top"><div class="useracticonsimgs phnavrigoff"></div></div>';
		}
	} return pre+inter+next+'</div>';
	} catch(e) { display_client_error(e,'thirteen');} 
}

function firsttime_photo(maindiv,cp,fmid,cid,bigimgid,pid,imgpath,fullpath,paging,intial,enpid) {
try {
	var f=fmid.substring(0,1),m='',imag='img',ph_paging='';
	var phstart='<div style="float:left;">';
	var phend='</div></a></div>~';
	var protect="";
	var lf="<a href='/login/loginform.php?mid="+fmid+"&frompg=rp&fname=/profiledetail/viewprofile.php?id="+fmid+"' target='_blank'>";

	if(imgpath=='PF' || imgpath=='PM') {
		protect=1;
	}

	var memdomain=Jsg_da[fmid.substring(0,1)];

	var pp="<a href='javascript:;' onclick=\"javascript:window.open('"+Jsg_imgserver+"/photo/viewphoto.php?photono="+cp+"&ID="+fmid+"&PID="+enpid+"','','directories=no,width=900,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');\">";
	

	if(imgpath=='RM') {
		if(Jsg_memberid=='') {
			return phstart+lf+"<div class='useracticonsimgs photorequestm'>"+phend;
		} else {
  			if(Jrmi=="rmi") {
				var rmi_photo=phstart+"<div class='useracticonsimgs photorequestm'></div></div>~";
				return rmi_photo;
			}else{
				return phstart+"<a href='javascript:;' onclick=\"javascript:fade('"+cid+"','fadediv','dispdiv','520','','','/request/bmrequestfor.php?OID="+fmid+"&RID=1&rand="+Math.random(9999)+"','','dispcontent','','');\"><div class='useracticonsimgs photorequestm'>"+phend;
			}
		}
	} else if(imgpath=='RF') {
		if(Jsg_memberid=='') {
			return phstart+lf+"<div class='useracticonsimgs photorequestf'>"+phend;
		} else {
   			if(Jrmi=="rmi") {
				var rmi_photo=phstart+"<div class='useracticonsimgs photorequestf'></div></div>~";
				return rmi_photo;
			}else{
				return phstart+"<a href='javascript:;' onclick=\"javascript:fade('"+cid+"','fadediv','dispdiv','520','','','/request/bmrequestfor.php?OID="+fmid+"&RID=1&rand="+Math.random(9999)+"','','dispcontent','','');\"><div class='useracticonsimgs photorequestf'>"+phend;
			}
		}
	} else if(imgpath=='PF' || imgpath=='PM') {
		if(Jsg_memberid=='') {
			return phstart+"<a href='/login/loginform.php?mid="+fmid+"&frompg=vp&fname=/profiledetail/viewprofile.php?id="+fmid+"' target='_blank'><div class='useracticonsimgs photoprotected'>"+phend;
		} else {
			return phstart+pp+'<div class="useracticonsimgs photoprotected">'+phend;
		}
	} else {
		if(Jsg_tt=='one') {
			en_numberslide=get_img_src(fmid,fullpath);
			var enp=(cp<=1) ? en_numberslide[0] : en_numberslide[(cp-1)];
			m=" onmouseover=\"search_overlayimg('"+enp+"','"+bigimgid+"','"+cid+"');\" onmouseout=\"javascript:$BN('"+bigimgid+"','n');\" ";
		}

		numberslide=get_img_src(fmid,imgpath);
		var p=(cp<=1) ? numberslide[0] : numberslide[(cp-1)];

		if(intial=='intial' && Jsg_tt=='one') {
			imag=Jsg_srch_image;
		}

		imghtml=pp+"<"+imag+" src='"+p+"' width='"+ST_pw+"' height='"+ST_ph+"' border=0 alt='' "+m+" id='"+fmid+"_n2'/></a>";
		
		if(paging==1 && numberslide.length>1) {
			ph_paging=photo_paging(enpid,maindiv,parseInt(cp),fmid,cid,bigimgid,pid,imgpath,fullpath,paging,parseInt(numberslide.length),'');
		}

		if(intial=='intial') {
			return imghtml+'~'+ph_paging;
		} else {
			$(cid).innerHTML=imghtml;
			$(pid).innerHTML=ph_paging;
		}
	}
	} catch(e) { display_client_error(e,'fourteen');} 
}

function search_overlayimg(timg,tmbid,cid) {
	var o=$(tmbid);
	if(o!='') {
		o.style.position='absolute'; $BN(tmbid,'b');
		o.style.left=parseInt(getpos($(cid),'left'))+80;o.style.top=parseInt(getpos($(cid),'top'));
		o.innerHTML='<img src="'+timg+'" width="150" height="150">';
	}
}

function $displayLink(pn) {
try{var first=Math.floor(pn / 2);
	Jsg_curpage=parseInt(Jsg_curpage);
	startPageNum=Jsg_curpage - first;
	endPageNum=Jsg_curpage+(pn - first-1);

	if(startPageNum <=0) {
		endPageNum=endPageNum+Math.abs(startPageNum -1);
		startPageNum=1;
	}
	if(endPageNum > Jsg_total_pages) {
		startPageNum=startPageNum - (endPageNum - Jsg_total_pages);
		if(startPageNum <=0) { startPageNum=1;} 
		endPageNum=Jsg_total_pages;
	}
	nextPageNum=Jsg_curpage+1;
	if(nextPageNum > Jsg_total_pages) { nextPageNum=0;} 
	previousPageNum=Jsg_curpage-1;
	if(previousPageNum < 0) { previousPageNum=0;}

	var inter=eval("Jsg_"+Jsg_tt+"_arr[2]");
	var sp=((Jsg_curpage-1)*inter)+1;

	var ofnumber=(sp+inter)-1;
	if(ofnumber>Jsg_total_records)ofnumber=Jsg_total_records;
	var pretext="Prev";
	var nexttext="Next";

	var inter_content='<div class="smalltxt phnumpadd fleft boldtxt clr2" style="margin-top:2px;"><font class="clr6" >'+sp+'</font>&nbsp;-&nbsp;'+ofnumber+'&nbsp;of&nbsp;'+Jsg_total_records+'</div>';

	var next_content='',pre_content='';
	if(Jsg_total_pages>1) {
		if(previousPageNum!=0) {
			pre_content="<div style='float:left;padding-top:2px;'><a href='#top' onclick='javascript:$loadprofiles("+previousPageNum+",\"frompaging\");' class='pntr'><div class='fleft useracticonsimgs prfnavlfton' style='margin-top:2px;'></div><div class='fleft clr6' style='margin: 0px 3px 0px 3px;vertical-align:top;'>"+pretext+"</div></a></div>";
		} else {
			pre_content='<div style="float:left;padding-top:2px;"><div class="fleft useracticonsimgs prfnavlftoff" style="margin-top:2px;"></div><div class="fleft clr2" style="margin: 0px 3px 0px 3px;vertical-align:top;">'+pretext+'</div></div>';
		}

		if(nextPageNum!=0) {
			next_content="<div style='float:left;padding-top:2px;'><a href='#top' onclick='javascript:$loadprofiles("+nextPageNum+",\"frompaging\");' class='pntr'><div class='fleft clr6' style='padding: 0px 3px 0px 3px;'>"+nexttext+"</div><div class='fleft useracticonsimgs prfnavrigon' style='margin-top:2px;'></div></a></div>";
		} else { 
			next_content='<div style="float:left;padding-top:2px;"><div class="fleft clr2" style="padding: 0px 3px 0px 3px;">'+nexttext+'</div><div class="fleft useracticonsimgs prfnavrigoff" style="margin-top:2px;"></div></div>';
		}
	} return pre_content+inter_content+next_content;
	} catch(e) { display_client_error(e,'twentyone');}
}

function search_rotatebanner() {
	if($('bannerdiv')) {
		$('bannerdiv').innerHTML='<div class="upgrade1"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" height="1"></div><div class="upgrade3" style="text-align:center"><iframe src="http://c2.zedo.com/jsc/c2/ff2.html?n=570;c='+Jsg_rightbanner+';s=64;d=7;w=160;h=600" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=160 height=600></iframe><div class="upgrade2"><img src="http://'+DOMAINARRAY['domainnameimgs']+'/bmimages/trans.gif" height="1"></div></div>';
	}
}

function $loadprofiles(page,where_from) {
	try {
	change_dtype(Jsg_tt,where_from);
	Jsg_old_cpage=Jsg_curpage;
	if(page=='' || page==NaN || page==0 || page=='one') page=1;

	Jsg_curpage=page;Jsg_where_from=where_from;
	search_reg_form('s');	
	var paging_content=$displayLink(5);
	if(where_from=='imgonload') {
		$('dyn_pages').innerHTML="<center><br/><br/><img src='"+Jsg_akka+"/bmimages/loading-icon.gif'><br/><br/></center>";
	}

	var dis_flag=0;
	Jsg_cb=Math.ceil(Jsg_curpage/Jsg_pp_req);

	if(Jsg_where_from=='frompaging') {
		var cdiv=$(Jsg_div_preffix+Jsg_curpage);

		if(cdiv=='') {dis_flag=1;check_next_div(Jsg_curpage);}
		else if(Jsg_search_type!='members_online' && Jsg_search_type!='whos_online') {
			if(Jsg_curpage>3 && (Jsg_curpage < Jsg_old_cpage)) {
				var cdiv1=$(Jsg_div_preffix+Jsg_curpage-1);
				if(cdiv1=='') {
					dis_flag=1;$replace_image(Jsg_div_preffix+Jsg_curpage,1);displayNone(Jsg_divname_end_org);
					if(Jsg_total_pages>1) { loading_divs(paging_content); } check_next_div(Jsg_curpage-1);
				}
			}
			if((Jsg_cb < Jsg_allblocks) && (Jsg_curpage > Jsg_old_cpage)) { 
				var cdiv2=$(Jsg_div_preffix+(Jsg_curpage+1));
				if(cdiv2=='' && Jsg_curpage < (Jsg_total_pages-1)) {
					dis_flag=1;$replace_image(Jsg_div_preffix+Jsg_curpage,1);displayNone(Jsg_divname_end_org);
					if(Jsg_total_pages>1) { loading_divs(paging_content);} check_next_div(Jsg_curpage+1);
				}
			} 
		}
		if(Jsg_tt=='one') { SC_reset(arguments[2]);}

	} else { dis_flag=1;check_next_div(Jsg_curpage);}

	if(dis_flag==0) {
		$replace_image(Jsg_div_preffix+Jsg_curpage,1);displayNone(Jsg_divname_end_org);
		if(Jsg_total_pages>1) { loading_divs(paging_content);}
	}
	$createCookie(Jsg_c_name,Jsg_tt+'~'+Jsg_curpage+'~'+Jsg_old_tt);
	search_rotatebanner();
	successrightrandom();
	if(Jsg_where_from=='frompaging' && Jsg_subdomain==false) { $botchk('');}
	} catch(e) { display_client_error(e,'fifteen');} 
}

function get_express_interest_link(t,cpro) {
	if(Jrmi=="rmi"){
		return '';
	} 
	switch(parseInt(t)) {
		case 0: return '<div class="vdotline"><div class="smalltxt phnextpadding fleft"></div><div class="smalltxt fright" style="padding:7px;"><input type="button" value="Register FREE to contact this member" class="button button-border" onclick=\'javascript:document.photofrm.action=Jsg_wwwdomain_path+"register/addmatrimony.php?mid='+J_Mid+'&fname=/profiledetail/viewprofile.php?id='+J_Mid+'";document.photofrm.submit();\' target="_blank"></div></div>';break;

		case 1: return "<div class='vdotline'><div class='smalltxt phnextpadding fleft'><a href='javascript:;' onClick=\" javascript:fade('M"+cpro+"','fadediv','dispdiv',534,'','','http://"+Jsg_dmname_prefix+Jsg_serv_name+"/expressinterest/geteioptions.php?t="+J_Mid+"','','dispcontent','','')\"><div class='fleft' style='padding-top:3px;'><div class='fleft pntr'>Select your message</div><div class='exp_downarrow_icon fleft pntr' ></div></div></a></div><div class='smalltxt fright' style='padding:7px;'><input type='button' value='Express Interest' class='button button-border' title=\"It\'s a free service. Go ahead and do it\" onClick=\" javascript:fade('M"+cpro+"','fadediv','dispdiv',534,'','','http://"+Jsg_dmname_prefix+Jsg_serv_name+"/expressinterest/geteioptions.php?t="+J_Mid+"','','dispcontent','','')\"></div></div>";break;

		case 2: return "<div class='vdotline'><div class='smalltxt phnextpadding fleft'><a href='javascript:;' onClick=\"javascript:fade('M"+cpro+"','fadediv','dispdiv',550,'','','http://"+Jsg_dmname_prefix+Jsg_serv_name+"/inbox/inbcontact.php?ID="+J_Mid+"','','dispcontent','','');\"><div class='pntr' style='padding-top:2px;'>Type your message</div></a></div><div class='smalltxt fright' style='padding:7px;'><input type='button' value='Send Mail' class='button button-border' title='Send a personalised message to member' onClick=\"javascript:fade('M"+cpro+"','fadediv','dispdiv',550,'','','http://"+Jsg_dmname_prefix+Jsg_serv_name+"/inbox/inbcontact.php?ID="+J_Mid+"','','dispcontent','','');\"></div></div>";break;
		
		case 3: return "<div class='vdotline'><div class='smalltxt phnextpadding fleft'></div><div class='smalltxt fright' style='padding:7px;'><input type='button' value='Forward' class='button button-border'  title='Will forward this profile to the e-mail ID you propose' onclick=\"javascript:fade('myphid','fadediv','dispdiv',550,300,'','/profiledetail/bmredirect.php?id="+J_Mid+"','','dispcontent','','');\"></div></div>";break;
	}	
}

function get_online_link(t) {
	var online_img='<img src="'+Jsg_akka+'/bmimages/online.gif" width="53" height="17" border="0">',ol='';

	if(parseInt(t)>0) {
		var tp=J_Mid+"_"+Jsg_form_gender;
		if(Jsg_memberid!='' && Jsg_loggedin_gender==Jsg_form_gender) return online_img;
		switch(parseInt(t)) {
			case 1: ol="<a href='javascript:;' onclick=\"javascript:launchIC('"+Jsg_memberid+"','"+tp+"')\">";break;

			case 2: ol="<a href='"+Jsg_wwwdomain_path+"payments/paymentoptions.php?2_"+J_Mid+"' target='_blank'>";break;

			case 3: ol="<a href='/login/loginform.php?mid="+J_Mid+"&frompg=c&fname=/profiledetail/viewprofile.php?id="+J_Mid+"' target='_blank'>";break;
		} 
		return '<div class="fleft" style="padding: 0px 3px 0px 0px">'+ol+online_img+"</a></div>";
	} else { return ''; }
}

function get_health_link(cpro) {
	var ic="<div class='fleft' style='padding: 0px 3px 0px 0px'>";
	if(Jsg_memberid!='') {		
	ic+="<a  href='javascript:;' onclick=\"javascript:fade('M"+cpro+"','fadediv','dispdiv','725','','','/healthprofile/healthprofile-view.php?ID="+J_Mid+"','','dispcontent','','');\">";
	} else {
	ic+="<a href='/login/loginform.php?mid="+J_Mid+"&frompg=hp&fname=/profiledetail/viewprofile.php?id="+J_Mid+"' target='_blank'>";
	}	
	return ic+"<div class='useracticonsimgs health pntr' style='float:left;padding: 0px 0px 0px 3px;' title='View Health Profile'></div></a></div>";
}

function view_bookmark_similarprofile(cpro) {
	var tp='';
	if(Jsg_memberid!='' && Jsg_loggedin_gender!=Jsg_form_gender) {
		var s="block";
		if(J_ico_arr[6]=='Y') { s="none"; }
		var shortlist_st='<div class="fleft" id="linkbk_'+cpro+'" style="display:'+s+'">';
		var shortlist_en='Shortlist</a></div>&nbsp;&nbsp;&nbsp;';
	    if(Jrmi!="rmi"){ 
			tp=shortlist_st+'<a href="javascript:;" onClick="javascript:fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'/memberlist/bookmark.php?divname=innerbookmark'+cpro+'&divname_1=innerignored'+cpro+'&type=b&bookmarkedid='+J_Mid+'&shlink=linkbk_'+cpro+'&operation=a\',\'\',\'dispcontent\',\'\',\'\');" class="clr1">'+shortlist_en;
		} else {
			tp=shortlist_st+'<a href="javascript:;" onClick="javascript:fade(\'viewprofilemaindiv\',\'fadediv\',\'photo\',\'400\',\'\',\'\',\'/privilege/rm_bookmark.php?divname=innerbookmark'+cpro+'&divname_1=innerignored'+cpro+'&type=b&RMIID=rmi&bookmarkedid='+J_Mid+'&shlink=linkbk_'+cpro+'&operation=a\',\'\',\'dispcontent\',\'\',\'\');" class="clr1">'+shortlist_en;
		}

	}
	 if(Jrmi!="rmi"){ 
		tp+="<a href='/search/smartsearch.php?t=S&DISPLAY_FORMAT="+Jsg_tt+"&ID="+J_Mid+"&SEARCH_TYPE=SIMILAR&GENDER="+Jsg_form_gender+"' target='_blank' class='clr1'>Similar Profiles</a>";
	}
    return tp;
}

function view_profile(c,t) {
	if(t=='Mid') {
		if(Jrmi=="rmi") {
			var str="<a href='/profiledetail/viewprofile.php?id="+J_Mid+"&print=yes&MEMID="+Jrmi+"' target='_blank' class='matriidlink bold'>";
		} else {
		   	var str="<a href='/profiledetail/viewprofile.php?id="+J_Mid+"' target='_blank' class='matriidlink bold'>";
		}
		if(Jsg_tt!='six') {
			str+=Decode_it(c);
		}
		str+=" ("+J_Mid+")</a>";
		return str;
	} else {
		if(Jrmi=="rmi") {
			return "<a href='/profiledetail/viewprofile.php?id="+J_Mid+"&print=yes&MEMID="+Jrmi+"' target='_blank' class='smalltxt clr1 fright'>Full&nbsp;Profile&nbsp;>></a>";
		} else {
			return "<a href='/profiledetail/viewprofile.php?id="+J_Mid+"' target='_blank' class='smalltxt clr1 fright'>Full&nbsp;Profile&nbsp;>></a>";
		}
	}
}

function get_right_icons() {
	var ico='',tp='';
	if(J_ico_arr[0]=='PY' || J_ico_arr[0]=='Y') {
		tp='<div class="useracticonsimgs phone">'+get_trans_image(16,20,0);
	} else {
		tp='<div class="useracticonsimgs pphone">'+get_trans_image(16,20,0);
	}
	ico='<div>'+tp+'</div></div>';

	tp='';
	if(J_ico_arr[1]=='GYP' || J_ico_arr[1]=='GY' ) {
		tp='<div class="useracticonsimgs horogen">'+get_trans_image(16,18,0);
	} else if(J_ico_arr[1]=='UYP' || J_ico_arr[1]=='UY' ) {
		tp='<div class="useracticonsimgs horo">'+get_trans_image(14,18,0);
	} else {
		tp='<div class="useracticonsimgs phorogen">'+get_trans_image(16,18,0);
	}
	ico+='<div style="padding-top:2px;">'+tp+'</div></div>';	


	tp='';
	if(J_ico_arr[2]=='Y') { 
		tp='<div class="useracticonsimgs matriref">'+get_trans_image(14,14,0); 
	} else {
		tp='<div class="useracticonsimgs pmatriref">'+get_trans_image(14,14,0);
	}
	ico+='<div style="padding:2px 0px 0px 2px">'+tp+'</div></div>';

	tp='';
	if(J_ico_arr[3]=='Y') {
		tp='<div class="useracticonsimgs veriprofile">'+get_trans_image(17,16,0); 
	} else {
		tp='<div class="useracticonsimgs pveriprofile">'+get_trans_image(17,16,0);
	}
	ico+='<div style="padding-top:2px;">'+tp+'</div></div>';

	tp='';
	if(J_ico_arr[4]=='Y') {
		tp='<div class="useracticonsimgs voice">'+get_trans_image(20,20,0) ;
	} else { 
		tp='<div class="useracticonsimgs pvoice">'+get_trans_image(20,20,0);
	}
	ico+= '<div>'+tp+'</div></div>';

	tp='';	
	if(J_ico_arr[9]=='IR') {
		tp='<div class="useracticonsimgs intreceived">'+get_trans_image(15,18,0);
	} else if(J_ico_arr[9]=='IS') {
	   tp='<div class="useracticonsimgs intsent">'+get_trans_image(15,19,0);
	} else if(J_ico_arr[9]=='MS') {
	   tp='<div class="useracticonsimgs msgsent">'+get_trans_image(12,19,0);
	 } else if(J_ico_arr[9]=='MR') {
	 tp='<div class="useracticonsimgs msgrecd">'+get_trans_image(12,19,0);
    } else if(J_ico_arr[9]=='MP') {
		tp='<div class="useracticonsimgs msgaccept">'+get_trans_image(15,20,0);
	} else if(J_ico_arr[9]=='MD') {
		tp='<div class="useracticonsimgs msgdecline">'+get_trans_image(15,20,0);
	}
	if(tp!='') {
		ico+='<div style="padding-top:2px;">'+tp+'</div></div>';
	}
	if(J_ico_arr[5]=='YP' || J_ico_arr[5]=='Y') { 
		ico+='<div style="padding-top:2px;"><div class="useracticonsimgs video">'+get_trans_image(11,19,0)+'</div></div>';
	} return ico; 
}

function show_top_tabs(d) {	
	if(Jsg_req==0) {
		if(d=='sr2') {
			$BN('sr1','b'); $BN('sr2','n');
			if(Jsg_memberid!="") {
				$BN('rv1','b'); $BN('rv2','n');
			}
			if($('disp_div').innerHTML!='') { $BN('disp_div','b');}
			show_test_div('b');
		} else if(d=='rv1') {
			$BN('sr1','n'); $BN('sr2','b');
			$BN('rv1','n'); $BN('rv2','b');
			if($('disp_div').style.display=='block') { $BN('disp_div','n');}
			show_test_div('n');
		}
	}
}

function show_test_div(t) {	
	if(t=='n') {			
		$BN('recent_div','b');
		$('recent_div').innerHTML="<center><br/><br/><br/><br/><br/><br/><br/><br/><img src='"+Jsg_akka+"/bmimages/loading-icon.gif'><br/><br/></center>";
		Jajax_http.open('GET',uncache('lastviewprofile.php?'),true);
		Jajax_http.send(null); Jsg_req=1;
		Jajax_http.onreadystatechange=dispRecentlydiv;	
		$BN('search_div','n');
	}
	if(t=='b') {
		$BN('recent_div','n');
		if($('disp_div').style.display=='none') {
			$BN('search_div','b');
		}
	}
}
function dispRecentlydiv() {
	if(Jajax_http.readyState==4) {
		if(Jajax_http.status==200) {	
			$('recent_div').innerHTML=Jajax_http.responseText;					
			Jsg_req=0;
		}
    }
}

function reset_hidelmnt() { 
	$BN('div_C','n');$BN('div_O','n');
	$BN('div_E','n');$BN('div_Ca','n');
	$('E').src=Jsg_coll;$('O').src=Jsg_coll;$('C').src=Jsg_coll;$('Ca').src=Jsg_coll;	
	$createCookie(Jsg_c_name,Jsg_tt+'~1~'+Jsg_old_tt);
	document.smartform.update_cbs.value=0;
}

function check_alreadyexists() {
try {
	var sf=document.smartform;var STAGE=sf.STAGE.value;var ENDAGE=sf.ENDAGE.value;
	var STHEIGHT= sf.STHEIGHT.value;var ENDHEIGHT=sf.ENDHEIGHT.value;var PHOTO_OPT='',HOROSCOPE_OPT='',wd='';
	if(sf.PHOTO_OPT1.checked==true) PHOTO_OPT='Y';if(sf.HOROSCOPE_OPT1.checked==true) HOROSCOPE_OPT='Y';

	if(Jsg_search_type=="KEYWORD") {
		var kt=sf.keytext.value;
		for(var i=0;i<sf.wdmatch1.length;i++) { if(sf.wdmatch1[i].checked==true) { wd=sf.wdmatch1[i].value;} }
	}

	if(sf.tex_tot.value=='') {
		sf.tex_tot.value=STAGE+"~#^$^#~"+ENDAGE+"~#^$^#~"+sf.keytext.value+"~#^$^#~"+wd+"~#^$^#~"+STHEIGHT+"~#^$^#~"+ENDHEIGHT+"~#^$^#~"+PHOTO_OPT+"~#^$^#~"+HOROSCOPE_OPT;
	} else {
		var t=sf.tex_tot.value; 
		if(t!="") {
			var ar=t.split("~#^$^#~");
			if(ar[0]==STAGE && ar[1]==ENDAGE && ar[2]==kt && ar[3]==wd && ar[4]==STHEIGHT && ar[5]==ENDHEIGHT && ar[6]==PHOTO_OPT && ar[7]==HOROSCOPE_OPT ) {
				document.smartform.update_cbs.value=1;
			} else {
				sf.tex_tot.value=STAGE+"~#^$^#~"+ENDAGE+"~#^$^#~"+kt+"~#^$^#~"+wd+"~#^$^#~"+STHEIGHT+"~#^$^#~"+ENDHEIGHT+"~#^$^#~"+PHOTO_OPT+"~#^$^#~"+HOROSCOPE_OPT;
				reset_hidelmnt();
			}			 
		}
	}
	} catch(e) { display_client_error(e,'sixteen');} 
}

function bms_pop_checkbox(rsp) {
try {
	if(rsp=="") return;
	var faced_arr=new Array();faced_arr[0]='COUNTRY_cb';faced_arr[1]='CASTE_cb';faced_arr[2]='EDUCATION_cb';faced_arr[3]='OCCUPATION_cb';
	var faced_val=new Array();faced_val[0]='C';faced_val[1]='Ca';faced_val[2]='E';faced_val[3]='O',html='<br>';
	var reclimit=0,edu_det='',caste_det='',m=0,numrec='',server_res='',first ='',tp='',frm=document.smartform;
	if(frm.update_cbs.value==0) {
		var f_count=0;
		for(var v=0;v<faced_val.length;v++) {
			cont_det='';
			var d=faced_arr[v]+'_div',tpk='sp_'+faced_val[v];			
			f_val=eval('rsp.'+faced_val[v]).split('~');

			if(f_val.length>1) {
				cont_det+="<div class='smalltxt'><input type='checkbox' id='"+faced_arr[v]+"any' name='"+faced_arr[v]+"any' value='0' checked onclick=\"bms_check_any('"+faced_arr[v]+"','any');\"'><span  onclick=\"chkbox_check('"+faced_arr[v]+"any');bms_check_any('"+faced_arr[v]+"','any');\">Any</span>";

				for(m=0;m<f_val.length;m++) {
					if(f_val[m]!='') {  
						var ch_va=f_val[m].split('^');
						cont_det+="<div class='smalltxt'><input type='checkbox' id='"+faced_val[v]+"_"+ch_va[1]+"' name='"+faced_arr[v]+"'  value='"+ch_va[1]+"' onclick=\"bms_check_any('"+faced_arr[v]+"');\"><span id='sp_"+ch_va[1]+"' onclick=\"chkbox_check('"+faced_val[v]+"_"+ch_va[1]+"'); bms_check_any('"+faced_arr[v]+"');\">"+ch_va[0]+"</span></div>";
					}
				}
				$(d).innerHTML=cont_det;
				$BN(tpk,'b');
				f_count++;
			} else {
				$BN(tpk,'n');				
			}
		}
		frm.update_cbs.value=1;		
		(f_count==0) ? $BN('chkboxes_cont','n') : $BN('chkboxes_cont','b');
	}
	} catch(e) { display_client_error(e,'seventeen');} 
}

function bms_check_any(fe) {
try {
	var frm=document.smartform,arg='',checked=0,count=0;	
	if(arguments[1]) { arg=arguments[1];}
	if(arg=='any') {
		if(eval("frm."+fe+"any.checked==true")) {
			if(eval("frm."+fe+"!=null")) {
				var cnt=eval("frm."+fe+".length");
				if(cnt>0) {
					for(var i=0;i<cnt;i++) { eval('frm.'+fe+'['+i+'].checked=false');}
				} else {
					eval("frm."+fe+".checked=false");	
				}
			}
		}
	} else {
		var cnt=eval("frm."+fe+".length");
		for(var i=0;i<cnt;i++) { if(eval('frm.'+fe+'['+i+'].checked==true')){count++;break;} }
		(count==0) ? eval("frm."+fe+"any.checked=true") : eval("frm."+fe+"any.checked=false");
	}
	} catch(e) { display_client_error(e,'eightteen');} 
}

function confirmInterestAll(cid,t,p,c) {
try {
	var cnt=0,chk_value="";		
	if(cid!='') {
		eval("document.frmlastview."+cid+".checked=true");cnt=1;
	} else {
		var cdiv=$('last_checkdiv');
		if(cdiv!='') {
			var ckBx=cdiv.getElementsByTagName('input');
			for(i=0;i<ckBx.length;i++) {
				if(ckBx[i].getAttribute('type')=='checkbox') { 
					if(ckBx[i].checked==true) {
						cnt++;
						chk_value+=ckBx[i].value+"~";													
					}
				} 
			}
		}	
	}	
	if(arguments[3]!="") chk_value=arguments[3];
	document.frmlastview.chk_val.value=chk_value;
	if(cnt>0) {
		fade('myphid','fadediv','dispdiv','400','','', 'searchresultpop.php?getp=lv&t='+t+'&chk_value='+chk_value+'&p='+p+'&c='+c,'','dispcontent','','');
	} else {
		fade('myphid','fadediv','dispdiv','400','','','searchresultpop.php?getp=rect&t='+t,'','dispcontent','','');			
	}
	} catch(e) { display_client_error(e,'nineteen');} 
}

function deleteRecentlyviewed(i,c) {		
try {
	call_unchk();
	lv_count=document.frmlastview.lv_count.value;
	if(Jsg_req==0) {
		Jajax_http.open('POST',uncache('dellastviewprofile.php?'),true);
		Jajax_http.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');
		Jajax_http.send('chk_val='+document.frmlastview.chk_val.value);	
		Jsg_req=1;
		Jajax_http.onreadystatechange=delLastviewdiv;			
		if(c!='') {			
			for (var j=0;j<=c;j++) {	
				if($("basicview_"+j)!="") {
					$BN("basicview_"+j,'n');
					lv_count--;
					document.frmlastview.lv_count.value=lv_count;
				}
			}			
			$BN("selall_1",'n');$BN("selall_2",'n');
			$BN("shwcont",'b'); $BN("intdiv",'n');
		} else {		
			$BN("basicview_"+i,'n');				
			lv_count--;
			document.frmlastview.lv_count.value=lv_count;
			if(lv_count==0) {			
				$BN("selall_1",'n');$BN("selall_2",'n');
				$BN("shwcont",'b'); $BN("intdiv",'n');
			}
		}
	}
		} catch(e) { display_client_error(e,'twenty');} 
}

function delLastviewdiv(){
	if($("contd")!="") {		
		$("contd").innerHTML = "Member Id deleted successfully. ";								
	}
	if($("yesnodiv")!="")  $BN('yesnodiv','n');
	if($("clsdiv")!="") $BN('clsdiv','b');
	Jsg_req=0;
}
var Jajax_http=new $getHTTPObject();
function get_trans_image(h,w,b) { return "<img src='"+Jsg_akka+"/bmimages/trans.gif' height='"+h+"' width='"+w+"' border='"+b+"'>"; }