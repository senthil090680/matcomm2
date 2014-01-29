var tempX = 0;
var tempY = 0;
if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
	BROWSERTAG = 1;
 var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
 if (ieversion>=8)
	BROWSERTAG = 2;
 else if (ieversion>=7)
	BROWSERTAG = 2;
 else if (ieversion>=6)
	BROWSERTAG = 1;
 else if (ieversion>=5)
	BROWSERTAG = 1;
} else {
	BROWSERTAG = 2;
}	
moreAjaxObj = false;

function faceannuIncome(formobj,flag){
	var sf=eval("this.document."+formobj);
	var ann1sel = parseInt(sf.annualIncome.selectedIndex);
	if(sf.annualIncome.options[ann1sel].value>=0.5 && sf.annualIncome.options[ann1sel].value<101){
		$('ann1').style.display = 'block';
		$('annualIncomeerr').style.display = 'none';
		if(flag==''){sf.annualIncome1.options[ann1sel+1].selected = true;}
		return faceannuIncome1(formobj);
	}else{
		$('ann1').style.display = 'none';
		$('annualIncomeerr').style.display = 'none';
		return true;
	}
}

function faceannuIncome1(formobj){
	var sf=eval("this.document."+formobj);
	if(parseFloat(sf.annualIncome.options[sf.annualIncome.selectedIndex].value) >= parseInt(sf.annualIncome1.options[sf.annualIncome1.selectedIndex].value)){
		$('annualIncomeerr').style.display = 'block';
		$('annualIncomeerr').innerHTML = 'Sorry, invalid annual income range.';
		return false;
	}else{
		$('annualIncomeerr').innerHTML = '';
		$('annualIncomeerr').style.display = 'none';
		return true;
	}
}

function showMore(facetpart, f_cur_obj){
	var marTop;
	var srchFrm	= document.frmSearchConds;
	var dispPg  = srchFrm.disppgval.value;
	$('more_opt').style.display="block";
	var x=$(f_cur_obj);
	var f_more_top=findPosY(x);
	if(BROWSERTAG == 1)
		marTop = tempY;
	else
		marTop = tempY;

	$('more_opt').style.top=f_more_top+10+"px";
	if(dispPg == '1'){
		moreAjaxUrl = ser_url+"/sphinx/faceting_more.php?&rand="+Math.random();
		param = 'wc='+srchFrm.wc.value+'&srchby='+facetpart;
		param += '&casteTxt='+srchFrm.casteTxt.value+'&subcasteTxt='+srchFrm.subcasteTxt.value+'&gothramTxt='+srchFrm.gothramTxt.value; 
	}else if(dispPg == '2'){
		param	= 'wc='+srchFrm.wc.value+'&profiletype='+srchFrm.profiletype.value+'&viewtype='+srchFrm.viewtype.value+'&excludefields='+srchFrm.excludefields.value+'&vat='+srchFrm.vat.value+'&srchby='+facetpart;
		param += '&casteTxt='+srchFrm.casteTxt.value+'&subcasteTxt='+srchFrm.subcasteTxt.value+'&gothramTxt='+srchFrm.gothramTxt.value; 
		moreAjaxUrl = ser_url+"/sphinx/msfaceting_more.php?&rand="+Math.random();
	}
	
	moreAjaxObj = AjaxCall();
	AjaxPostReq(moreAjaxUrl, param, loadMoreOpts, moreAjaxObj);
}

function loadMoreOpts(){
	if(moreAjaxObj.readyState==4){
			if(moreAjaxObj.responseText == "")
				closeMore();
			$('facetMoreContainer').innerHTML = moreAjaxObj.responseText;
	}else{
		$('facetMoreContainer').innerHTML = '<div align="center"><img src="'+imgs_url+'/moreloading.gif" border="0"></div>';
	}
}

function closeMore(){
	$('more_opt').style.display="none";
	$('facetMoreContainer').innerHTML = "<div align='center'><img src='"+imgs_url+"/moreloading.gif' border='0'></div>";
}

function moreSubmit(mName, mType){
	
	mpostVal = '';
	if(mType=='separate'){
		eleNameFrom = eval('document.frmMoreFacet.'+mName+'From');
		eleNameTo   = eval('document.frmMoreFacet.'+mName+'To');
		if(mName=='age'){
			CondStAge = (selGender==1) ?  MStAge : FMStAge;
			if(eleNameFrom.value>=CondStAge && eleNameTo.value<=70){
				mpostVal = 'ageFrom='+eleNameFrom.value+'#^#ageTo='+eleNameTo.value;
			}else{
				$(mName+'err').innerHTML  = 'Sorry, invalid age (Min. age is '+CondStAge+'. Max. age is 70).';
				return false;
			}
		}else if(mName=='height'){
			mheightVal1 = 0;
			cntVal = eleNameFrom.length;
			for(i=0; i<cntVal; i++){
				if(eleNameFrom.options[i].selected== true){
					mheightVal1 = eleNameFrom.options[i].value;break;
				}
			}

			for(i=0; i<cntVal; i++){
				if(eleNameTo.options[i].selected== true){
					mheightVal2 = eleNameTo.options[i].value;break;
				}
			}
			if(mheightVal1>=121.92 && mheightVal2<=241.30 && mheightVal1<=mheightVal2){
				mpostVal = 'heightFrom='+mheightVal1+'#^#heightTo='+mheightVal2;
			}else{
				$(mName+'err').innerHTML  = 'Sorry, invalid height range.';
				return false;
			}
		}
	}else if(mName=='annualIncome'){
		eleNameFrom = eval('document.frmMoreFacet.'+mName);
		eleNameTo   = eval('document.frmMoreFacet.'+mName+'1');
		mannualVal = 0;
		mannualVal1= 0;
		cntVal = eleNameFrom.length;
		for(i=0; i<cntVal; i++){
			if(eleNameFrom.options[i].selected== true){
				mannualVal = parseFloat(eleNameFrom.options[i].value);break;
			}
		}

		for(i=0; i<cntVal; i++){
			if(eleNameTo.options[i].selected== true){
				mannualVal1 = parseFloat(eleNameTo.options[i].value);break;
			}
		}
		if(mannualVal>0.49 && mannualVal1<=101 && mannualVal<mannualVal1){
			mpostVal = mannualVal+'~'+mannualVal1;
		}else if(mannualVal==101){
			mpostVal = mannualVal+'~';
		}else if(mannualVal==0.49){
			mpostVal = mannualVal+'~';
		}else{
			$(mName+'err').innerHTML  = 'Sorry, invalid annual income range.';
			return false;
		}
	}else if(mType=='profiletypechk'){
		var phoChk = 0; horoChk=0;
		if(document.frmMoreFacet.photoOpt != null){
			if(document.frmMoreFacet.photoOpt.checked == true){
				mpostVal = 'photoOpt=1#^#';
				phoChk = 1;
			}else{
				mpostVal = 'photoOpt=0#^#';
			}
		}
		if(document.frmMoreFacet.horoscopeOpt != null){
			if(document.frmMoreFacet.horoscopeOpt.checked == true){
				mpostVal += 'horoscopeOpt=1';
				horoChk = 1;
			}else{
				mpostVal += 'horoscopeOpt=0';
			}
		}

		/*if(phoChk==0 && horoChk==0){
			$(mName+'err').innerHTML  = 'Sorry, please select any of the given option.';
			return false;
		}*/
	}else if(mType=='activeChk'){
		radCnt = document.frmMoreFacet.activeOpt.length;
		for(i=0; i<radCnt; i++){
			if(document.frmMoreFacet.activeOpt[i].checked == true){
				mpostVal = document.frmMoreFacet.activeOpt[i].value;
			}
		}

		if(mpostVal == ''){
			$(mName+'err').innerHTML  = '&nbsp;&nbsp;Sorry, please select any of the given option.';
			return false;
		}
	}else if(mType=='physicalChk'){
		radCnt = document.frmMoreFacet.physicalStatus.length;
		for(i=0; i<radCnt; i++){
			if(document.frmMoreFacet.physicalStatus[i].checked == true){
				mpostVal = document.frmMoreFacet.physicalStatus[i].value;
			}
		}

		if(mpostVal == ''){
			$(mName+'err').innerHTML  = '&nbsp;&nbsp;Sorry, please select the physical status.';
			return false;
		}
	}else if(mType=='Selectbox'){
		eleName = eval('document.frmMoreFacet.'+mName);
		cntVal = eleName.length;
		for(i=0; i<cntVal; i++){
			if(eleName.options[i].selected== true){
				mpostVal = eleName.options[i].value;break;
			}
		}

		if(mpostVal == ''){
			$(mName+'err').innerHTML  = 'Sorry, please select any of the given option.';
			return false;
		}
	}else if(mType=='MultiSelectbox'){
		eleName = eval('document.frmMoreFacet.'+mName);
		cntVal = eleName.length;
		for(i=0; i<cntVal; i++){

			if(eleName.options[i].value!=''){
				mpostVal += eleName.options[i].value+'~';
			}
		}

		if(mpostVal == ''){
			$(mName+'err').innerHTML  = 'Sorry, please select any of the given option.';
			return false;
		}
	}else if(mType=='Checkbox'){
		eleName = eval('document.frmMoreFacet.'+mName);
		cntVal = eleName.length;
		for(i=0; i<cntVal; i++){
			if(eleName[i].checked== true){
				mpostVal += eleName[i].value+'~';
			}
		}

		if(mpostVal==''){
			if(eleName.checked== true){
				mpostVal += eleName.value;
			}
		}

		if(mpostVal == ''){
			$(mName+'err').innerHTML  = '&nbsp;Sorry, please select any of the given option.';
			return false;
		}
	}

	if(mName!='' && mpostVal!=''){
		submitFrmFacet(mName, mpostVal);
	}
}

function submitFrmFacet(eleName, eleVal){
	if(eleName=='age' || eleName=='height' || eleName=='profiletype'){
		document.frmSearchConds.newval.value = eleVal;
	}else if(eleName=='annualIncome'){
		var annualVal = new Array();
		annualVal = eleVal.split('~');
		document.frmSearchConds.newval.value = 'annualIncome='+annualVal[0]+'#^#annualIncome1='+annualVal[1];
	}else{ 
		document.frmSearchConds.newval.value = eleName+'='+eleVal;
	}
	document.frmSearchConds.submit();
}