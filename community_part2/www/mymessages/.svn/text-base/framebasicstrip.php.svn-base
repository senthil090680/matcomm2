<?php
#=================================================================================================================
# Author 	  : Baranidharan M
# Date		  : 2010-10-25
# Project	  : MatrimonyProduct
# Filename	  : framebasicstrip.php
#=================================================================================================================
# Description : form the basic strip of member to display in messages part.
#=================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$sessPublish	= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];

$moreLink = '';
function first_photo($ph_det, $tph_det, $div_no, $div_prefix,$mem_id)
{    global $moreLink,$confValues;
	 $arrPhotos	= split('\^',$ph_det);
	 $arrTPhotos = split('\^',$tph_det);
	 $totPhotos	= count($arrPhotos);
	if($arrPhotos[0] !=''){
		$photofolder = '/'.$arrPhotos[0]{3}.'/'.$arrPhotos[0]{4}.'/';
		$varOnClick   = "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$mem_id."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
		$moreLink = '<div style="padding-top:3px;" class="clr1 smalltxt"><a onclick="'.$varOnClick.'">View Album</a></div>';
		$photoTxt = '<a onclick="'.$varOnClick.'"><img src="'.$confValues["PHOTOURL"].$photofolder.$arrPhotos[0].'" alt="" width="75" height="75"></a>';
		return $photoTxt;
	}
}

function div_photo($gen, $mem_id,$varCurrPgNo,$varMsgIndexVal,$varMsgId,$varMsgType)
{   
	global $moreLink,$confValues;
	$varOnClick = 'getViewProfile(\''.$mem_id."','".$varCurrPgNo.'\',\''.$varMsgIndexVal.'\',\''.$varMsgId.'\', \''.$varMsgType.'\',\'photo\');imageswap(\'eview\','.$varCurrPgNo.');';
	if ($gen == 'PM') {
		$photoName = "img50_pro_m";
		$moreLink='';
	}
	else if($gen == 'PF') {
	    $photoName = "img50_pro_f";
		$moreLink='';
	}
	else {
		$photoName= ($gen == 1) ? 'noimg50_m' : 'noimg50_f';
		$moreLink = '<div style="padding-top:3px;" class="clr1 smalltxt"><a onclick="'.$varOnClick.'">Request Photo</a></div>';
	}
	$photoTxt = '<a onclick="'.$varOnClick.'"><img src="'.$confValues["IMGSURL"].'/'.$photoName.'.gif" alt="" width="75" height="75"></a>';
	return $photoTxt;
}

function build_template($i,$varMsgIndexVal,$varMsgId,$varMsgType,$varResult,$varMsgVal,$varMsgTxt,$arrIconInfo)
{	
	$div_prefix	 = 'S';
	global $moreLink,$sessMatriId,$sessPublish,$sessPaidStatus,$sessGender,$confValues;

	$whole_cont	= ''; 

		if($varResult['PU'] == '1'){
		$pt_img	  = ($varResult['PT']=='2')?'premium':($varResult['PT']=='1')?'premium':'';
		
		//get online
		$onli_res = urldecode($varResult['ON']);
		$onli_div = '';$onli_msg='Within last ';
	    
		if($onli_res == 'NOW')
		{
			$onli_msg  = 'Online Right NOW!';
			$onli_link = ($sessPaidStatus=='1')?'launchIC(\''.$sessMatriId.'\',\''.$varResult['ID'].'\')' :'gotoPay(\''.$confValues["SERVERURL"].'\')';
		    $onli_div  = '<div class="fleft" style="padding:3px 5px 0px 5px;"><a onclick="javascript:'.$onli_link.';"> | <font class="clr4">Online</font> - <font class="clr1">Chat Now!</font></a></div>';
		}
		else
		{
			$onli_msg  .= $onli_res;
		} 

        /*<input type="button" onclick="sendRequest('AGR153692','1','1vp3');" value="Request Now" class="button">*/

		$arrProfDet		= split('\^~\^', urldecode($varResult['DE']));

		$ctry = $arrProfDet[10];

		//caste related info
		$cas_no_cont = ($arrProfDet[15] == '1')? '(CasteNoBar)' : '';
		$subcas_no_cont = ($arrProfDet[17] == '1')? '(SubcasteNoBar)' : '';
			
		$reli_cont  = ($arrProfDet[7] !='') ? $arrProfDet[7] : '';
		$deno_cont  = ($arrProfDet[18] !='') ? ($reli_cont!='' ? $reli_cont.', '.$arrProfDet[18] : $arrProfDet[18]) : $reli_cont;
		$caste_cont = ($arrProfDet[8] !='') ? ($deno_cont!='' ? $deno_cont.', '.$arrProfDet[8].$cas_no_cont : $arrProfDet[8].$cas_no_cont) : $deno_cont;
		$subc_cont  = ($arrProfDet[9] !='') ? ($caste_cont!='' ? $caste_cont.', '.$arrProfDet[9].$subcas_no_cont : $arrProfDet[9].$subcas_no_cont) : $caste_cont;
		$subc_cont  = ($subc_cont != '') ? '<font class="clr2"> | </font>'.$subc_cont : '';
		$ctry_stat = ($ctry != '' && $arrProfDet[11] !='' && $arrProfDet[11] !='0') ? $arrProfDet[11].', '.$ctry : $ctry;
		$ctry_st_ci= ($ctry != '' && $arrProfDet[12] !='' && $arrProfDet[12] !='0') ? $arrProfDet[12].', '.$ctry_stat : $ctry_stat;

        if($arrProfDet[3] !='Others' && $arrProfDet[3] !='') {
		 $edu_de='<font class="clr2"> | </font>'.$arrProfDet[3];
		}
		else if($arrProfDet[4] !='') {
		 $edu_de='<font class="clr2"> | </font>'.$arrProfDet[4];
		}
		else {
		 $edu_de='';
		}
		
		//$edu_de	  = ($arrProfDet[3] !='Others' && $arrProfDet[3] !='')?'<font class="clr2"> |11111 </font>'.$arrProfDet[3] : ($arrProfDet[4] !='')?'<font class="clr2"> |22222 </font>'.$arrProfDet[4] : '';
		
		//$occu_de	  = ($arrProfDet[5]!='Others' && $arrProfDet[5]!='')?'<font class="clr2"> | </font>'.$arrProfDet[5] : ($arrProfDet[6] !='')?'<font class="clr2"> | </font>'.$arrProfDet[6] : '';
		
		if($arrProfDet[5]!='Others' && $arrProfDet[5]!='') {
		 $occu_de='<font class="clr2"> | </font>'.$arrProfDet[5];
		}
		else if($arrProfDet[6] !='') {
		 $occu_de='<font class="clr2"> | </font>'.$arrProfDet[6];
		}
		else {
		 $occu_de='';
		}

		$starval='';
		
		//Horoscope & compatability 
		$horomatch = 'Average';
		$comp_div = '<div class="cleard"></div>';

		//Photo div
		$moreLink = '';
		if($varResult['PH'] == ''){	$PhotoURL = div_photo($varResult['G'], $varResult['ID'],$i,$varMsgIndexVal,$varMsgId,$varMsgType);}
		else if($varResult['PH'] == 'P') {
			if($varResult['G'] == 1) {
			  $PhotoURL = div_photo('PM', $varResult['ID'],$i,$varMsgIndexVal,$varMsgId,$varMsgType);	
			}
			else {
			  $PhotoURL = div_photo('PF', $varResult['ID'],$i,$varMsgIndexVal,$varMsgId,$varMsgType);	
			}
		}
		else {	$PhotoURL = first_photo($varResult['PH'],$varResult['TPH'],$i,$div_prefix,$varResult['ID']);	}

		//Get Conatct & Features
		$iconDet_arr  = split('\^',$varResult['RIC']);
		$img_cont_det = '';
		$img_phone_det= '';
		$img_horo_det = '';
			
		if($iconDet_arr[0]=='1' || $iconDet_arr[0]=='3'){
			 $img_phone_det = '&nbsp;<a onclick="javascript:getViewProfile(\''.$varResult['ID']."','".$i.'\',\''.$varMsgIndexVal.'\',\''.$varMsgId.'\', \''.$varMsgType.'\',\'phone\');imageswap(\'eview\','.$i.')" class="clr1"><img src="'.$confValues["IMGSURL"].'/reqphone.gif" border="0"/></a>';	
		  //$img_phone_det='&nbsp;<img src="'.$confValues["IMGSURL"].'/reqphone.gif" border="0"/>';
		}
		if($iconDet_arr[6]!='0' && $iconDet_arr[8] !='0'){$img_cont_det='<font class="smalltxt clr3"><a onclick="show_box(\'event\',\'div_box'.$i.'\');showContactHistory(\''.$sessMatriId.'\',\''.$varResult['ID'].'\',\'msgactpart'.$i.'\',\'div_box'.$i.'\',1);" class="clr1">Last Activity: </font></a><font class="smalltxt clr"> '.urldecode($iconDet_arr[7]).': '.$iconDet_arr[8].'</font>';}
		//<img src="'.$confValues["IMGSURL"].'/'.$iconDet_arr[6].'.gif">

		if($iconDet_arr[9]=='1'){
			if($sessPaidStatus == 1) {
			$img_horo_det = '&nbsp;<a onclick="window.open(\''.$confValues["IMAGEURL"].'/horoscope/viewhoroscope.php?ID='.$varResult['ID'].'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');" class="clr1"><img src="'.$confValues["IMGSURL"].'/horoscope.gif" border="0"/></a>';
			}
			else {
			 $img_horo_det = '&nbsp;<a onclick="javascript:getViewProfile(\''.$varResult['ID']."','".$i.'\',\''.$varMsgIndexVal.'\',\''.$varMsgId.'\', \''.$varMsgType.'\',\'horoscope\');imageswap(\'eview\','.$i.')" class="clr1"><img src="'.$confValues["IMGSURL"].'/horoscope.gif" border="0"/></a>';
			}
		}
		if($iconDet_arr[9]=='3'){
			if($sessPaidStatus == 1) {
			 $img_horo_det = '&nbsp;<a onclick="window.open(\''.$confValues["IMAGEURL"].'/horoscope/viewhoroscope.php?ID='.$varResult['ID'].'\',\'\',\'directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');" class="clr1"><img src="'.$confValues["IMGSURL"].'/genhoros.gif" border="0"/></a>';
			}
			else {
			 $img_horo_det = '&nbsp;<a onclick="javascript:getViewProfile(\''.$varResult['ID']."','".$i.'\',\''.$varMsgIndexVal.'\',\''.$varMsgId.'\', \''.$varMsgType.'\',\'horoscope\');imageswap(\'eview\','.$i.')" class="clr1"><img src="'.$confValues["IMGSURL"].'/genhoros.gif" border="0"/></a>';
			}
		}

		//Basicview divs integrating
		
		if($pt_img!=''){$pt_img='<img src="'.$confValues["IMGSURL"].'/'.$pt_img.'.gif" height="18" width="91" />';}
		$start_div = '<div class="normdiv bgclr2"><div id="cont'.$i.'"><div class="cleard"></div>';

		$start_div .= '<div class="fleft padtb10" id="checkdiv" style="width:30px;">';

        if($varMsgId != '')
		$start_div .= '<input type="checkbox" name="mids[]" value="'.$varMsgId.'"/>';		
		else
        $start_div .= '<input type="checkbox" name="chk_li" value="'.$varResult['ID'].'"/>';

		$start_div .= '</div><div id="mesgdiv" class="fleft padtb10">';
		
		$onclckopt = '';
		
		if($sessMatriId !=''){
			$onclckopt = '<div id="eview'.$i.'"><img src="'.$confValues["IMGSURL"].'/expview.gif" border="0" alt="" onclick="javascript:getViewProfile(\''.$varResult['ID']."','".$i.'\',\''.$varMsgIndexVal.'\',\''.$varMsgId.'\', \''.$varMsgType.'\',\'\');imageswap(\'eview\','.$i.');" style="cursor:pointer;"></div>';
		}else{
			$onclckopt = '<div id="eview'.$i.'"><img src="'.$confValues["IMGSURL"].'/expview.gif" border="0" alt="" onclick="javascript:getViewProfile(\'\', \''.$i.'\', \'\', \'\',\'\',\'\');imageswap(\'eview\','.$i.');" style="cursor:pointer;"></div>';
		}
		
		$resopt='<div id="mview'.$i.'" style="display:none;"><img src="'.$confValues["IMGSURL"].'/minview.gif" border="0" alt="" name="minview" onclick="closecollapse('.$i.');imageswap(\'mview\','.$i.');" style="cursor:pointer;"></div>';

		//start_div .= onclckopt.'><div id="vpdiv1" class="fleft">';
		$start_div .= '<div id="vpdiv2" class="fleft brdr bgclr5"><div id="smphdiv1">'.$PhotoURL.'</div><center>'.$moreLink.'</center></div><div id="vpdiv1" class="fleft">';
		
		if($checkcrawlingbotsexists == true) {
			$content_div = '<div class="normtxt clr fleft bld padb10">'.$varResult['ID'].'</div>'.$comp_div.$icon_div.$comp_div.'<div id="vpdiv4" class="normtxt clr lh13 padt5">'.$arrProfDet[0].' yrs, '.$arrProfDet[1].$subc_cont.' <font class="clr2">|</font> '.$starval.$ctry_st_ci.'  '.$edu_de.' '.$occu_de.'&nbsp;&nbsp;<a target="_blank" href="'.$confValues["SERVERURL"].'/profiledetail/index.php?act=fullprofilenew&id='.$varResult['ID'].'" class="clr1">Full Profile >></a></div>'.$comp_div.'<div class="fleft" style="padding-top:2px;">'.$img_cont_det.'</div></div>';
		}
		else{
			if($img_phone_det!='' || $onli_div!='' || $img_horo_det!='') {
              if($img_phone_det == '' && $img_horo_det == '')
			  $onli_div=str_replace(' | ','',$onli_div);
		      $icon_div='<div style="height:22px;"><div class="fleft lcdiv"></div><div class="bgcdiv fleft smalltxt bld"><div style="padding-top:4px;" class="fleft">'.$img_phone_det.$img_horo_det.'</div>'.$onli_div.'</div><div class="fleft rcdiv"></div></div>';
			}
		$content_div = '<div class="normtxt clr fleft bld padb10"><a class="normtxt bld clr" onMouseOver="this.className=\'normtxt bld clr1\'" onMouseOut="this.className=\'normtxt bld clr\'" target="_blank" href="'.$confValues["SERVERURL"].'/profiledetail/index.php?act=fullprofilenew&id='.$varResult['ID'].'">'.urldecode($varResult['N']).' ('.$varResult['ID'].')</a></div><div class="fright">'.$pt_img.'</div>'.$comp_div.$icon_div.$comp_div.'<div id="vpdiv4" class="normtxt clr lh16 padt5">'.$arrProfDet[0].' yrs, '.$arrProfDet[1].$subc_cont.' <font class="clr2">|</font> '.$starval.$ctry_st_ci.'  '.$edu_de.' '.$occu_de.'&nbsp;&nbsp;<a target="_blank" href="'.$confValues["SERVERURL"].'/profiledetail/index.php?act=fullprofilenew&id='.$varResult['ID'].'" class="clr1">Full Profile >></a></div>'.$comp_div.'<div class="fleft" style="padding-top:2px;">'.$img_cont_det.'</div></div></div><br clear="all">';
		}
		$photo_div	= '<div id="vpdiv2" class="fleft"><div id="smphdiv1">'.$PhotoURL.'</div><center>'.$moreLink.'</center></div></div>';
        

	    $end_div		= '<div class="cleard"></div></div><div class="cleard"></div><div class="fleft" style="overflow:auto;width:560px;background:url('.$confValues["IMGSURL"].'/viewouterbg.gif) repeat-y;"><div class="fleft tlleft" style="padding:10px 0px 10px 12px;width:420px;">';
		
		if($varMsgVal != '')
     	 $end_div .= '<img src="'.$confValues['IMGSURL'].'/'.$arrIconInfo[0].'.gif" alt="'.$arrIconInfo[1].'">&nbsp;&nbsp;<b>'.$varMsgVal.'</b><div style="padding-left:20px;" id="shortMsg'.$i.'">'.$varMsgTxt.'</div>';
        else
         $end_div .= 'Like this member? <input type="button" class="button" value="Send Message" onclick="sel(\''.$varResult['ID'].'\',\''.$varResult['G'].'\','.$i.',\'1\');" />';

		 $end_div .='</div><div class="fright tlright" style="width:100px;padding-top:15px;padding-right:12px;">'.$onclckopt.$resopt.'</div><div class="cleard"></div><div id="viewpro'.$i.'"></div><div class="cleard"></div><div style="height:7px;" class="bgclr2"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="7"></div></div></div><div class="cleard"></div><div style="height:10px;"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="10"></div><div class="cleard"></div><div class="dotsep2"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="1"></div><div class="cleard"></div><div style="height:10px;"><img src="'.$confValues["IMGSURL"].'/trans.gif" height="10"></div>';
	   
        $end_div .= '<div id="div_box'.$i.'" class="frdispdiv vishid posabs brdr1 bgclr2" style="padding:10px !important;padding:10px;padding-left:0px;width=570px;"><div id="msgactpart'.$i.'" class="tlleft"></div></div>';

		$whole_cont .= $start_div . $content_div . $end_div;


		}//publish1
		else{
			$start_div  = '<div class="normdiv bgclr2"><div class=""><div id="mesgdiv" class="padtb10"><div style="padding-top:25px;text-align:center;height:50px;" class="smalltxt bld brdr">';
			
			$unavmsg_cont='';
			if($varResult['PU']=='2'){
			$unavmsg_cont= 'This profile '.$varResult['ID'].' is hidden.';
			}else if($varResult['PU']=='3'){
			$unavmsg_cont= 'This profile '.$varResult['ID'].' is suspended.';
			}else if($varResult['PU']=='4'){
			$unavmsg_cont= 'This profile '.$varResult['ID'].' is rejected.';
			}else if($varResult['PU']=='D'){
			$unavmsg_cont= 'This profile '.$varResult['ID'].' has been deleted.';
			}else if($varResult['PU']=='TD'){
			$unavmsg_cont= 'This profile '.$varResult['ID'].' is currently unavailable.';
			}

			$end_div = '</div></div></div></div><br clear="all">';
		
			$whole_cont .= $start_div.$unavmsg_cont.$end_div;
		    //$whole_cont='';
		}
		
	return $whole_cont;
}

?>