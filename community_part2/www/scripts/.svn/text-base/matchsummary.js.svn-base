var sr_tot_recs, sr_tot_pg, sr_cur_pg=0, curr_file, json_arr, sr_vi_ty='', pre_vi='1',checkcrawlingbotsexists; 
var load_sm	= '<div class="fright"><img src="'+imgs_url+'/small-loading.gif" height="25" width="80"></div>';

function nextjs(){
	iconpage = parseInt(sr_cur_pg)+1;
		sr_loadprofiles(iconpage);
		sr_loadprofiles(iconpage);
}

function prevjs(){
iconpage = parseInt(sr_cur_pg)-1;
sr_loadprofiles(iconpage);
}

function sr_paging_cont()
{
	if(sr_tot_pg > 0) {
	pagingval = sr_displayLink();
	$("prevnext").innerHTML = pagingval;
	$("prevnext1").innerHTML = pagingval;
	}
}
function prevjs(){
iconpage = parseInt(sr_cur_pg)-1;
sr_loadprofiles(iconpage);
}

function sr_displayLink() {
	startPageNum= parseInt(sr_cur_pg);
	endPageNum  = parseInt(sr_tot_pg);

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
		inner_cont += '<div class="paginginact" onclick="sr_loadprofiles('+i+');"> '+i+' </div><div class="spacing">&nbsp;</div>';
		}else{
		inner_cont += '<div class="nopaging"> '+i+' </div><div class="spacing">&nbsp;</div>';
		}
	}
	paging_content = prevdiv_cont+inner_cont+nextdiv_cont;
	return paging_content;
	
}
function sr_loadprofiles(page_no)
{

	sr_cur_pg = page_no;
	document.body.scrollTop= 60;
	$("prevnext").innerHTML = load_sm;
	$("prevnext1").innerHTML = load_sm;
	prev_divno = '';
	getMatchResult('');
}
function getMatchResult(lo_arg)
{
	var srchFrm	= document.frmSearchConds;
	url		= ser_url+'/matchsummary/ms_ctrl.php?rno='+Math.random();
	if(lo_arg == '1'){
		param	= 'wc='+srchFrm.wc.value+'&profiletype='+srchFrm.profiletype.value+'&viewtype='+srchFrm.viewtype.value+'&excludefields='+srchFrm.excludefields.value+'&vat='+srchFrm.vat.value+'&Page='+sr_cur_pg+'&faceAdd='+srchFrm.faceAdded.value;
		//srchFrm.srchId.value = '';srchFrm.srchName.value='';srchFrm.srchType.value='';
		param += '&casteTxt='+srchFrm.casteTxt.value+'&subcasteTxt='+srchFrm.subcasteTxt.value+'&gothramTxt='+srchFrm.gothramTxt.value; 
	}else if(curr_file != ''){
		if(curr_file == '/matchsummary/ms_ctrl.php'){
		param	= 'wc='+srchFrm.wc.value+'&profiletype='+srchFrm.profiletype.value+'&viewtype='+srchFrm.viewtype.value+'&excludefields='+srchFrm.excludefields.value+'&vat='+srchFrm.vat.value+'&Page='+sr_cur_pg+'&faceAdd='+srchFrm.faceAdded.value;
		param += '&casteTxt='+srchFrm.casteTxt.value+'&subcasteTxt='+srchFrm.subcasteTxt.value+'&gothramTxt='+srchFrm.gothramTxt.value; 
		} 
	}

	//$("prevnext").innerHTML = load_sm;
	//$("prevnext1").innerHTML = load_sm;
	if(lo_arg == '1'){
		//$('matchResults').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
		$('serResArea').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';
	}
	objAjax = AjaxCall();
	AjaxPostReq(url, param, 'searchResDisp',objAjax);
}

function searchResDisp()
{
	var restxt;
	if(objAjax.readyState == 4)
	{
		restxt		= (objAjax.responseText).split('#^~^#');

		sr_vi_ty	= restxt[0];
		sr_tot_recs	= restxt[1];
		sr_tot_pg	= restxt[2];
		sr_cur_pg	= restxt[3];
		curr_file	= restxt[4];
		if(sr_tot_recs > 0){
		curr_disp_recs = parseInt(sr_tot_recs)-(parseInt(sr_cur_pg-1)*10);
		json_arr	= eval(restxt[5]);
		facet_cont  = restxt[6];
		restxt		= '';
		build_template('serResArea', 'Srh');

		sr_paging_cont();
		if(curr_disp_recs<4){
			$('prevnext').style.display = 'none';
		}else{
			$('prevnext').style.display = 'block';
		}
		if(facet_cont != ''){
			$("sidemenupart").innerHTML = facet_cont;
			$("sidemenupart").className = 'lpanel fleft';
		}
		$("srinnertopbt").style.display = 'block';
		$("srtopbt").style.display = 'block';
		}else{
		if(restxt[6] == 'MPHV'){
			$('serResArea').innerHTML = '<br><br><font class="smalltxt">Currently there are no profiles in this folder.</font><br><br><br><br>';
		}else{
			$('serResArea').innerHTML = '<br><br><div class="pad10 brdr rpanel smalltxt" style="width:540px;background-color:#EEEEEE">Sorry, we couldn\'t find any results to suit your search criteria. Perhaps your search was too specific? Try choosing broader categories.</div><br><br><br><br>';		
		}
		$("prevnext").innerHTML = '';
		$("prevnext1").innerHTML = '';
		$("srinnertopbt").style.display = 'none';
		$("srtopbt").style.display = 'none';
		}
		if($("ipsrchdiv")!=''){$("ipsrchdiv").style.display = 'block';}
	}
}

function getMatchSummaryCount() {
	var argurl=ser_url+"/matchsummary/loadsummary.php";
	ajaxobj=AjaxCall();
	postval='';
	AjaxPostReq(argurl,postval,msummaryDisp,ajaxobj);
}

function msummaryDisp() {
	if (ajaxobj.readyState == 4 && ajaxobj.status == 200) {
		$('msummary').innerHTML = ajaxobj.responseText;
        if(ajaxobj.responseText != '') { 
		 getRecomSummary();
		}
	} else {
		$('msummary').innerHTML = "<div style='text-align:center;'><img src='http://img.communitymatrimony.com/images/loading-icon.gif'  height='38' width='45'/></div>";
	}
}

function getRecomSummary() {
	var argurl=ser_url+"/matchsummary/myhomerecommatch.php";
	ajaxobj1=AjaxCall();
	postval='';
	AjaxPostReq(argurl,postval,recomsummaryDisp,ajaxobj1);
}

function recomsummaryDisp() {
	if (ajaxobj1.readyState == 4 && ajaxobj1.status == 200) {
		$('recomsummary').innerHTML = ajaxobj1.responseText;
	} else {
		$('recomsummary').innerHTML = "<div style='text-align:center;'><img src='http://img.communitymatrimony.com/images/loading-icon.gif' height='38' width='45'/></div>";
	}
}