<?php
	function displayMaritalStatus() {
	global $COOKIEINFO, $rec;
	$ms_1_chk = "Checked";	
	if(isset($rec['MaritalStatus'])) {
		$MARIT = explode("~",$rec['MaritalStatus']);
		$ms_1_chk ="";
		$ms_2_chk ="";
		$ms_3_chk ="";
		$ms_4_chk ="";
		($MARIT[0]==0) ? $ms_0_chk = "Checked" : $ms_0_chk ="";
		if($MARIT[0]!=0) {
			foreach($MARIT as $key=>$val) {
				if($val==1) 
					$ms_1_chk = "Checked";
				if($val==2) 
						$ms_2_chk = "Checked";
				if($val==3) 
						$ms_3_chk = "Checked";
				if($val==4) 
						$ms_4_chk = "Checked";

			}
		}
	}
	 
	$chk .= "<input type=checkbox name=MARITAL_STATUS[] value='0'  class='frmchkbox' id=\"MARITAL_STATUS0\" ".$ms_0_chk." onClick=\"return childlivingstany();\"><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS0',''); childlivingstany();\">&nbsp;Any&nbsp;&nbsp;&nbsp;</font><input type=checkbox class='frmchkbox' name=MARITAL_STATUS[] value='1'  id=\"MARITAL_STATUS1\" ".$ms_1_chk." onClick=\"return childlivingst();\"><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS1',''); childlivingst();\">&nbsp;Unmarried&nbsp;&nbsp;&nbsp;</font><input type=checkbox class='frmchkbox'  name=MARITAL_STATUS[]  value='2' id=\"MARITAL_STATUS2\" onClick=\"return childlivingst();\" ".$ms_2_chk."><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS2','');childlivingst();\">&nbsp;Widow/Widower&nbsp;&nbsp;&nbsp;</font><input type=checkbox class='frmchkbox'  name=MARITAL_STATUS[]  value='3' id=\"MARITAL_STATUS3\" onClick=\"return childlivingst();\" ".$ms_3_chk."><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS3','');childlivingst();\">&nbsp;Divorced &nbsp;&nbsp;&nbsp;</font><input type=checkbox class='frmchkbox'  name=MARITAL_STATUS[]  value='4' id=\"MARITAL_STATUS4\" onClick=\"return childlivingst();\" ".$ms_4_chk."><font class='smalltxt' onclick=\"chkbox_check('MARITAL_STATUS4','');childlivingst();\">&nbsp;Separated</font>";	
	return $chk;
} 

function dataFromMatchWatch() {
	global $DOMAINTABLE,$COOKIEINFO,$DBINFO,$DBNAME,$GETDOMAININFO,$rec;
	$db_slave = new db;	
	$db_slave->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$db_slave->select("select StAge, EndAge, StHeight, EndHeight from ".$DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['MATCHWATCH']." where MatriId='".$COOKIEINFO['LOGININFO']['MEMBERID']."'");
	$row = $db_slave->fetchArray();

	if($row['StAge']<18 &&  $COOKIEINFO['LOGININFO']['GENDER']=='M') {
		$row['StAge']=18;		
	}
	if($row['StAge']==18 && $row['EndAge']<18 &&  $COOKIEINFO['LOGININFO']['GENDER']=='M')
		$row['EndAge']=18;
	if($row['StAge']<21 &&  $COOKIEINFO['LOGININFO']['GENDER']=='F') {
		$row['StAge']=21;		
	}
	if($row['StAge']==21 && $row['EndAge']<21 &&  $COOKIEINFO['LOGININFO']['GENDER']=='F')
		$row['EndAge']=21;
	
	$rec['StAge']=$row['StAge'];
	$rec['EndAge']=$row['EndAge'];
	return;
}
function matchWatchHeight() {
	global $HEIGHTSRCHHASH,$rec;
	dataFromMatchWatch();	
	$stheight=floor(array_search($rec['StHeight'], $HEIGHTSRCHHASH)); 
	$endheight=ceil(array_search($rec['EndHeight'], $HEIGHTSRCHHASH)); 	
		if($stheight==0) {
			$first=0;
			foreach($HEIGHTSRCHHASH as $k=>$v) {
				if($first==0) {
						if($v>$rec['StHeight']) {	
							$val=$k;						
							$first=1;								
						}
				}
			} 
			$rec['StHeight']=$val; 
		} else {
			$rec['StHeight']=$stheight;
		}	
		if($endheight==0) {
			$second=0;
			foreach($HEIGHTSRCHHASH as $key=>$valu) {
				if($second==0) {
						if($valu>$rec['EndHeight']) {	
							$value=$key;						
							$second=1;								
						}
				}
			} 
			$rec['EndHeight']=$value; 	     
		}
		else {
			$rec['EndHeight']=$endheight;
		}
}

function search_form_title_content() {
	if($_REQUEST['typ']=="ad") {
		return "This is a very detailed search and will give you specific narrowed down results. In case you're looking for broader results that match your criteria, try <a href='search.php?RMIID=rmi' class='smalltxt clr1'>regular search</a>.";
	} else {
		return "This is a general search based on a few important criteria one would look for in a partner. <br><br>If you want very specific and accurate results, for e.g. you want to find prospects from a particular <b>state, city, star, education, occupation and lifestyle</b>, you can try the <a href='search.php?typ=ad&RMIID=rmi' class='smalltxt clr1'>advanced search</a>.";
	}
}

function memberSearchContent() {
	global $COMMONVARS;
	echo 'Search among members who are currently <img src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/bmimages/online.gif" style="vertical-align:middle;">.';
}

function keywordsearchContent() {
	echo '<div class="content" style="padding-left:3px;">Find profiles based on keywords. This search will get results based on keywords found in the profile description of members.</div><div class="smalltxt1 clr2" style="padding: 4px 0px 0px 3px;">Example: Software Engineer, Brahmin Iyer, Loves pets, Cricket... </div>';
}

function addRemoveTwoLiner() {
?>
	<div class="smalltxt1 clr2" style="padding: 0px 10px 6px 14px;">To add to list - double click the item on the left or click on the item and then click <font style="font-family: bold;">'Add'</font>. To remove from list - double click the item on the right or click on the item and then click <B>'Remove'.</B></div>
<?
}

function FillLeftRightSelectBox($leftcontrol,$rightcontrol,$recfieldname,$leftarrname1='',$leftarrname2='') {
	global $rec,$urdu,$SEARCHOCCUPATIONNAME,$SEARCHOCCUPATIONLIST,$SEARCHJOB1,$SEARCHJOB2,$SEARCHJOB3;
		$leftflag="";$rightflag="";				
		if($recfieldname=='Country' || $recfieldname=='Citizenship' || $recfieldname=='Education' || $recfieldname=='Caste' || $recfieldname=='OccupationSelected') {
			$leftflag=false;
		} else if($recfieldname=='Star') {
			$leftflag=0;$rightflag=0;
		}
		$contrl_arr['left']="";
		if(isset($rec[$recfieldname]) && $rec[$recfieldname]!="") {
			$var_array=explode("~",$rec[$recfieldname]);
		} else {
			$var_array="";
		}
		
		if($recfieldname=='OccupationSelected') {
			if(trim($rec['OccupationCategory'])!="") {
				$leftarrname1=$SEARCHOCCUPATIONNAME[$rec['OccupationCategory']];
			}	
			$contrl_arr['left'].= '<span id="occ_div">';				
		}	
		if($recfieldname=='Caste') {
			$contrl_arr['left'].='<div id="caste_div">';
		}
	
		if($recfieldname=='Country') {
			$contrl_arr['left'].='<select style="width:200px;" NAME="'.$leftcontrol.'[]" id="'.$leftcontrol.'" size="5" multiple class="inputtext" ondblclick="country_moveOptions(document.MatriForm.'.$leftcontrol.', document.MatriForm.'.$rightcontrol.',\'COUNTRY\');">';
		}
		else {
			$contrl_arr['left'].='<select style="width:200px;" NAME="'.$leftcontrol.'[]" id="'.$leftcontrol.'" size="5" multiple class="inputtext" ondblclick="moveOptions(document.MatriForm.'.$leftcontrol.', document.MatriForm.'.$rightcontrol.');">';	
		}

		if($recfieldname=='Caste' && $urdu=='U') {
			$contrl_arr['left'] .= selectMultipleLeftControl($leftarrname2,$var_array,$leftflag);
		}
		else {
			$contrl_arr['left'].=selectMultipleLeftControl($leftarrname1,$var_array,$leftflag);			
		}

		$contrl_arr['left'].='</select>';		

		if($recfieldname=='Caste') {
			$contrl_arr['left'].='</div>';
		}
		if($recfieldname=='OccupationSelected') {
			$contrl_arr['left'].='</span>';
		}
		if($recfieldname=='Country') {
			$contrl_arr['right'].= '<select size="5"  NAME="'.$rightcontrol.'[]" id="'.$rightcontrol.'" MULTIPLE class="inputtext" style="width:200px;" ondblclick="country_moveOptions1(document.MatriForm.'.$rightcontrol.', document.MatriForm.'.$leftcontrol.',\'COUNTRY\');">';
		}
		else {
			$contrl_arr['right'].= '<select size="5"  NAME="'.$rightcontrol.'[]" id="'.$rightcontrol.'" MULTIPLE class="inputtext" style="width:200px;" ondblclick="moveOptions1(document.MatriForm.'.$rightcontrol.', document.MatriForm.'.$leftcontrol.');">';
		}
			
		if($recfieldname=='Caste' && $urdu=='U') {
			$contrl_arr['right'].=selectMultipleRightControl($leftarrname2,$var_array,$rightflag);
		} else {
			$contrl_arr['right'].=selectMultipleRightControl($leftarrname1,$var_array,$rightflag);
		}		

		$contrl_arr['right'].='</select>';
		return $contrl_arr;
}

function displayAge($stage,$endage,$tab1='',$tab2=''){
	global $GENDER,$COOKIEINFO;	
?>
		<div class="mediumtxtbld" style="padding-top:6px;padding-left:14px;"><a name="agf"></a><div class="fleft"><B>Age</B><font class="clr1 mediumtxt boldtxt">*</font></div><div id="ageerr" class="errortxt fleft" style="display:none;padding-left:9px;"></div></div><br clear="all"><div style="padding-left:14px;"><font class="smalltxt">From</font>&nbsp;&nbsp;<input type="text" name="STAGE" tabindex="<?=$tab1;?>" size=2 maxlength=2  value="<?=$stage;?>" class="inputtext" onBlur="validateAge(this.form,'ageerr');" >&nbsp;&nbsp;&nbsp;<font class="smalltxt">to</font>&nbsp;&nbsp;<input type="text" name="ENDAGE" size=2 maxlength=2 value="<?=$endage;?>"  tabindex="<?=$tab2;?>" class="inputtext" onBlur="validateAge(this.form,'ageerr');"><font class="smalltxt">&nbsp;years</font></div>
<?
}

function displayGender($label,$rec,$tab1,$tab2,$frm) {
	global $COOKIEINFO, $rec;
	$m_checked="";
	$f_checked="";

	$gen='<div class="mediumtxt boldtxt" style="padding-top:6px;padding-left:14px;"><a name="gdf"></a><div class="fleft">'.$label.'&nbsp;<font class="clr1 mediumtxt boldtxt">*</font></div><div id="gendererr" class="errortxt fleft" style="display:none;padding-left:9px;"></div></div><br clear="all">';

	if($COOKIEINFO['LOGININFO']['ENTRYTYPE']!='') {
		if(isset($rec['Gender'])) {
			if($rec['Gender']=='F') { $f_checked="Checked"; } 
			else { $m_checked="Checked"; }
		}
		else if($COOKIEINFO['LOGININFO']['GENDER']=='F') { $m_checked="Checked";}
		else { $f_checked="Checked"; }
	}
	if(isset($rec['Gender'])) {
			if($rec['Gender']=='F') { $f_checked="Checked"; } 
			else { $m_checked="Checked"; }
	}
	else if($COOKIEINFO['LOGININFO']['GENDER']=='F') { $m_checked="Checked";}
	else { $f_checked="Checked"; }	
	return $gen."<div style='padding-left:14px;'><input type='radio' class='frmelements' name='GENDER' value='F' $f_checked id='f_gender' tabindex=".$tab1." onBlur=\"validateGender(this.form,'gendererr');\" onclick=\"checkGenderAge(this.form);\" >&nbsp;<font class='smalltxt' onclick=\"chkbox_check('f_gender','radio');checkGenderAge(".$frm.");\" >Female&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type='radio' class='frmelements'  name='GENDER' value='M' id='m_gender' $m_checked onBlur=\"validateGender(this.form,'gendererr');\" tabindex=".$tab2." onclick=\"checkGenderAge(this.form);\">&nbsp;<font class='smalltxt' onclick=\"chkbox_check('m_gender','radio');checkGenderAge(".$frm.");\">Male</font></div>";
}

function displayHeight($stheight_val,$endheight_val,$tab1='',$tab2='') {		
?>
		<div class="mediumtxtbld" style="padding-top:6px;padding-left:14px;"><a name="htf"></a><div class="fleft"><B>Height</B>&nbsp;<font class="clr1 mediumtxt boldtxt">*</font></div><div id="heighterr" class="errortxt fleft" style="display:none;padding-left:9px;"></div></div><br clear="all"><div style="padding-left:14px;">
			<select class="inputtext" NAME="STHEIGHT" size="1" onBlur="validateHeight(this.form,'heighterr')" tabindex="<?=$tab1;?>" style="width:110px;"><?=selectArrayHash('SHOWHEIGHT',$stheight_val);?></select>&nbsp;
			<font class="mediumtxt"> &nbsp;to&nbsp; </font>
			<select class="inputtext" NAME="ENDHEIGHT" size="1" onBlur="validateHeight(this.form,'heighterr')" tabindex="<?=$tab2;?>"><?=selectArrayHash('SHOWHEIGHT',$endheight_val);?></select> 
		</div>
<? }

function DispCountry() {
	global $COMMONVARS;
	?>
	<div class="fleft" style="padding-left:10px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><font class="mediumtxt boldtxt" style="padding-left:5px;">Country living in</font></div>
	<div style="padding-left:14px;" class="errortxt fleft" id="countryerr"></div>	
	<br clear="all">

		<div style="padding-left:14px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5" /><br><div style="float:left;">
		<?$country_arr=FillLeftRightSelectBox('COUNTRY','COUNTRY1','Country','SEARCHCOUNTRYHASH'); echo $country_arr['left'];?></div>
		<div style="float:left;text-align:center;">
		<div style="padding:15px 7px 0px 7px;">
		<input type="button" style="width:71px !important; width:65px;" Value="Add" class="button" onclick="country_moveOptions(document.MatriForm.COUNTRY, document.MatriForm.COUNTRY1,'COUNTRY');">
		<br><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="5"><br>
		<input type="button" class="button" style="width:71px !important; width:65px;" Value="Remove" onClick="country_moveOptions1(document.MatriForm.COUNTRY1, document.MatriForm.COUNTRY);">  </div>
		</div>
		<div style="float:left;"><?=$country_arr['right'];?></div><br clear="all">
		</div>
		<div style="padding:5px 0px 5px 14px;"><div class="vdotline1" style="width:492px;"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmimages/trans.gif" width="1" height="1"></div></div>
<?php 
} 

function displayReligion() {
	global $rec, $urdu,$GETDOMAININFO;
	$r = '<select style="width:200px;" NAME="RELIGION1" id="RELIGION1" onChange=changereligion_ajax(this.value,"'.$GETDOMAININFO['domainnameshort'].'"); class="inputtext">';
	if($urdu=='U') {
		$r .= selectArrayHash('SEARCHMUSLIMRELIGIONHASH',$rec['Religion']);
	}
	else {
		$r .= selectArrayHash('SEARCHRELIGIONHASH',$rec['Religion']);
	}
	$r .= '</select>';
	return $r;
}
?>