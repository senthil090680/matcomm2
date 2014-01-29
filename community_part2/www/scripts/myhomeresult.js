var sr_vi_ty='';
var objMyHomeAjax, myhome_tot_recs, myhome_tot_pg, myhome_cur_pg, myhome_curr_file, myhome_pre_vi='1', myhome_opt; 
var load_sm	= '<div class="fright"><img src="'+imgs_url+'/small-loading.gif" height="25" width="80"></div>';


function myhome_paging_cont()
{
	if(myhome_tot_pg > 0) {
	$("prevnext").innerHTML = myhome_displayLink();
    $("prevnext1").innerHTML = myhome_displayLink();
	}
}

function nextjs(){
iconpage = parseInt(myhome_cur_pg)+1;
msg_loadprofiles(iconpage);
}

function prevjs(){
iconpage = parseInt(myhome_cur_pg)-1;
msg_loadprofiles(iconpage);
}

function funMain(opt){
changeStyle(opt);
var arrSubdivision = new Array();
var arrSubdivisionDescription = new Array();
arrSubdivision['RMALL']= 'Received Messages - All', arrSubdivision['RMUNREAD']='Received - Unread Messages', arrSubdivision['RMREAD']='Received - Read Messages', arrSubdivision['RMREPLIED']='Received - Replied by me', arrSubdivision['RMDECLINED']='Received - Declined by me', arrSubdivision['SMALL']='Sent - All Messages', arrSubdivision['SMUNREAD']='Sent - Unread Messages', arrSubdivision['SMREAD']='Sent - Read Messages', arrSubdivision['SMREPLIED']='Sent - Replied by members', arrSubdivision['SMDECLINED']='Sent - Declined by members', arrSubdivision['RIALL']='Received - All Interests', arrSubdivision['RIPENDING']='Received - Reply Pending', arrSubdivision['RIACCEPTED']='Received - Accepted by me', arrSubdivision['RIDECLINED']='Received - Declined by me', arrSubdivision['SIALL']='Sent - All Interests', arrSubdivision['SIPENDING']='Sent - Pending Interests', arrSubdivision['SIACCEPTED']='Sent - Accepted Interests', arrSubdivision['SIDECLINED']= 'Sent - Declined Interests', arrSubdivision['RRALL']='Received - All Requests', arrSubdivision['RRPHOTO']='Received - Photo Requests', arrSubdivision['RRPHONE']='Received - Phone Requests', arrSubdivision['RRHOROSCOPE']='Received - Horoscope Requests', arrSubdivision['SRALL']='Sent - All Requests', arrSubdivision['SRPHOTO']='Sent - Photo Requests', arrSubdivision['SRPHONE']='Sent - Phone Requests', arrSubdivision['SRHOROSCOPE']='Sent - Horoscope Requests';

arrSubdivisionDescription['RMALL']= 'Listed below are the messages that you have received',
arrSubdivisionDescription['RMUNREAD']='Listed below are the messages that have not been read by you', 
arrSubdivisionDescription['RMREAD']='Listed below are the messages read by you',
arrSubdivisionDescription['RMREPLIED']='Listed below are the messages that you have replied to',
arrSubdivisionDescription['RMDECLINED']='Listed below are the messages declined by you',
arrSubdivisionDescription['SMALL']='Listed below are your messages that you have sent',
arrSubdivisionDescription['SMUNREAD']='Listed below are your messages that have not been read by members', 
arrSubdivisionDescription['SMREAD']='Listed below are your messages read by members', 
arrSubdivisionDescription['SMREPLIED']='Listed below are your messages replied by members',
arrSubdivisionDescription['SMDECLINED']='Listed below are your messages declined by members', 
arrSubdivisionDescription['RIALL']='Listed below are the Interests that you have received', 
arrSubdivisionDescription['RIPENDING']='Listed below are the Interests that you have not responded to',
arrSubdivisionDescription['RIACCEPTED']='Listed below are the Interests accepted by you',
arrSubdivisionDescription['RIDECLINED']='Listed below are the Interests declined by you',
arrSubdivisionDescription['SIALL']='Listed below are your Interests that you have sent',
arrSubdivisionDescription['SIPENDING']='Listed below are your Interests that have not been responded to by members', 
arrSubdivisionDescription['SIACCEPTED']='Listed below are your Interests that have been accepted by members', 
arrSubdivisionDescription['SIDECLINED']= 'Listed below are your Interests that have been declined by members', 
arrSubdivisionDescription['RRALL']='Listed here are the requests sent by members',
arrSubdivisionDescription['RRPHOTO']='Listed here are the photo requests sent by members', 
arrSubdivisionDescription['RRPHONE']='Listed here are the phone number requests sent by members', 
arrSubdivisionDescription['RRHOROSCOPE']='Listed here are the horoscope requests sent by members',
arrSubdivisionDescription['SRALL']='Listed here are the requests sent by you',
arrSubdivisionDescription['SRPHOTO']='Listed here are the photo requests sent by you', 
arrSubdivisionDescription['SRPHONE']='Listed here are the phone number requests sent by you',
arrSubdivisionDescription['SRHOROSCOPE']='Listed here are the horoscope requests sent by you';

titleTxt = (arrSubdivision[opt] == null) ? '' : arrSubdivision[opt];
titleTxtDescription = (arrSubdivisionDescription[opt] == null) ? '' : arrSubdivisionDescription[opt];
$('msgtitle').innerHTML= titleTxt;
$('msgtitleDescription').innerHTML= titleTxtDescription;
url = (opt.substring(0,1) == 'R') ? '/mymessages/new_msg_ctrl.php' : '/mymessages/new_msg_ctrl_sent.php';
$('msgtype').value = opt.substring(0,2);
funMyHome(url, opt, 1);
}


function changeStyle(selectedId) {
  for (var id in msgTypes) {
     if(id == selectedId) {
	   document.getElementById(id).innerHTML='<font class="clr5">'+msgTypes[id]+'</font>';
	 }
	 else {
	   document.getElementById(id).innerHTML='<a class="clr1" href="javascript:;" onclick="funMain(\''+id+'\');">'+msgTypes[id]+'</a>';
	 }
  }
}

function funListMain(opt){
if(opt=='SL'){$('msgsl').className='clr bld';}else{$('msgsl').className='clr1';}
if(opt=='IG'){$('msgig').className='clr bld';}else{$('msgig').className='clr1';}
if(opt=='BK'){$('msgbk').className='clr bld';}else{$('msgbk').className='clr1';}
url = '/list/list_ctrl.php';
funMyHome(url, opt, 1);
}

function chkDivHight(){
	if(myhome_tot_recs > 8){
		rem_recs = myhome_tot_recs-((myhome_cur_pg-1)*10);
		if(rem_recs<10 && myhome_opt!='HOME'){$('msgResults').style.height='430px';}else{$('msgResults').style.height='';}
	}else{
		if(myhome_opt!='HOME'){$('msgResults').style.height='430px';}
	}
}

function myhome_displayLink() {
	startPageNum= parseInt(myhome_cur_pg);
	endPageNum  = parseInt(myhome_tot_pg);

	if(startPageNum <=0) {
		startPageNum=1;
	}
	
	nextPageNum		= startPageNum+1;
	previousPageNum	= startPageNum-1;
	if(nextPageNum > endPageNum) { nextPageNum=0; } 
	if(previousPageNum < 0) { previousPageNum=0; }
	
	var prevdiv_cont  = (previousPageNum == 0) ? 'previnact' : 'prevact';
	var prevdiv_js    = (previousPageNum == 0) ? '' : ' onclick="prevjs();"';
	var nextdiv_cont  = (nextPageNum == 0) ? 'nextinact' : 'nextact';
	var nextdiv_js    = (nextPageNum == 0) ? '' : ' onclick="nextjs();"';

	prevdiv_cont = '<div class="fright"><div class="'+prevdiv_cont+'"'+prevdiv_js+'> < </div><div class="spacing">&nbsp;</div>';
	nextdiv_cont = '<div class="'+nextdiv_cont+'"'+nextdiv_js+'> > </div></div>';

	dividedval	= Math.ceil(startPageNum/5);
	startdisppg = ((dividedval-1)*5)+1;
	enddisppg	= (dividedval)*5;
	inner_cont='';
	for(i=startdisppg; i<=enddisppg; i++)
	{
		if(i == startPageNum){
		inner_cont += '<div class="pagingact"> '+i+' </div><div class="spacing">&nbsp;</div>';
		}else if(i <= endPageNum){
		inner_cont += '<div class="paginginact" onclick="msg_loadprofiles('+i+');"> '+i+' </div><div class="spacing">&nbsp;</div>';
		}else{
		inner_cont += '<div class="nopaging"> '+i+' </div><div class="spacing">&nbsp;</div>';
		}
	}
	paging_content = prevdiv_cont+inner_cont+nextdiv_cont;
	return paging_content;
}

function msg_loadprofiles(page_no)
{
	var dispPg	= parseInt(page_no);
	var totPg	= parseInt(myhome_tot_pg);
	if(dispPg>0 && dispPg<=totPg){
		prev_divno = '';
		myhome_cur_pg	= dispPg;
		$('prevnext').innerHTML = load_sm;
		$('prevnext1').innerHTML = load_sm;
		getMyhomeResult(myhome_curr_file, myhome_opt);
	}
}

function getMyhomeResult(filename, tabName)
{
	$('prevnext').innerHTML = load_sm;
    $('prevnext1').innerHTML = load_sm;
	url		= ser_url+filename+'?rno='+Math.random();
	param	= 'tabId='+tabName+'&Page='+myhome_cur_pg+'&view='+sr_vi_ty;
	objMyHomeAjax = AjaxCall();
	AjaxPostReq(url, param, MyHomeMsgDisp, objMyHomeAjax);
}

function MyHomeMsgDisp(){
	var restxt;
	if(objMyHomeAjax.readyState == 4)
	{
		if(objMyHomeAjax.responseText != '0' && objMyHomeAjax.responseText != '1'){	
		restxt		= (objMyHomeAjax.responseText).split('#^~^#');
		myhome_opt	= restxt[0];
		sr_vi_ty	= restxt[1];
		myhome_tot_recs		= restxt[2];
		myhome_tot_pg		= restxt[3];
		myhome_cur_pg		= restxt[4];
		myhome_curr_file	= restxt[5];
		myhome_json_bv_arr	= restxt[6];
		myhome_msgcont_det	= restxt[7];
		restxt = '';

		//chkDivHight();
		//$('messagebar').innerHTML	= myhome_msgcont_det;
		
		if(myhome_tot_recs > 0){
		if(myhome_opt != 'HOME'){myhome_paging_cont();
		//$('del_div').style.display = 'block';
		}
		$('msgResults').innerHTML = myhome_json_bv_arr;
		}else{
		if(myhome_opt != 'HOME'){
		//$('del_div').style.display = 'none';
		$('prevnext').innerHTML = '';
        $('prevnext1').innerHTML = '';
		}
		if(myhome_opt == 'BK' || myhome_opt == 'SL') {
			$('msgResults').innerHTML = 'Currently there are no profiles in this folder';
		}else{
			msgOptTxt ='message';
			if(myhome_opt.substring(1,2)=='M'){
				msgOptTxt = 'message';
			}else if(myhome_opt.substring(1,2)=='I'){
				msgOptTxt = 'interest';
			}else if(myhome_opt.substring(1,2)=='R'){
				msgOptTxt = 'request';
			}

			$('msgResults').innerHTML = 'Currently there are no '+msgOptTxt+'s in this folder';
		}
		}
		//if(myhome_opt!='ALL') { funUpdateCookie(); }
		}else if(objMyHomeAjax.responseText == '0'){ 
			sess_out();
		}else if(objMyHomeAjax.responseText == '1'){
			msg_prob_txt();
		}
	}
}

function myhome_disp_view(views)
{
	var pre_div  = 'view'+myhome_pre_vi+'n';
	var pre_fdiv = 'view'+myhome_pre_vi+'f';
	var cur_div  = 'view'+views+'n';
	var cur_fdiv = 'view'+views+'f';

	if(myhome_tot_recs > 0){
	
	/*$(pre_div).style.display = "none";
	$(pre_fdiv).style.display = "block";
	$(cur_div).style.display = "block";
	$(cur_fdiv).style.display = "none";*/
	myhome_pre_vi = views;
	sr_vi_ty = views;
	prev_divno = '';
    getMyhomeResult(myhome_curr_file, myhome_opt); }
}

function sess_out(){
	$('prevnext').innerHTML = '';$('msgResults').innerHTML = '  You are either logged off or your session timed out.<a href="'+ser_url+'" class="smalltxt clr1"> Click here</a> to login.';
    $('prevnext1').innerHTML = '';$('msgResults').innerHTML = '  You are either logged off or your session timed out.<a href="'+ser_url+'" class="smalltxt clr1"> Click here</a> to login.';
}

function msg_prob_txt(){
	$('prevnext').innerHTML = '';$('msgResults').innerHTML = '  Given url is worng or technical issue.';
    $('prevnext1').innerHTML = '';$('msgResults').innerHTML = '  Given url is worng or technical issue.';
}

function selectAll(action){
	if(action == 'yes')
	 mult_chk(document.buttonfrm);
	else
    mult_unchk(document.buttonfrm);
}

function gotoPay(ser_url) {
  window.location.href = ser_url+'/payment/';
}
