<?php
/******************************************************************************************************/
// FILENAME		:	SEARCH_TEMPLATE.PHP
// DESCRIPTION	:	THIS PROGRAM IS FOR SHOWING THE THUMB AND BASIC VIEW OF THE SEARCH PROFILE.
//					THIS IS A COMMAN TEMPLATE.
// CREATED BY	:	HEMACHANDAN.K, ASHOK KUMAR.R		
/******************************************************************************************************/

function getDomainLang($MatriId)
{
	global $lang,$domain_language;
	
	$firstdigit=substr($MatriId,0,1);
	$dblanguage=array_search($firstdigit,$idstartletterhash);
	$host=strtolower($lang[$dblanguage]);
	$dblanguage=str_replace("matrimony","",$host);
	$dblanguage=str_replace("matrimonial","",$dblanguage);

	return $dblanguage;
}
function newdocrypt($matriid) {
	$level1 = crypt($matriid,"RPH");
	return crypt($level1,"BM");
}
//echo for_languagewise_fontsize($ln);

// SEARCH THUMB VIEW //
// THIS FUNCTION IS FOR SEARCH THUMB VIEW TO DISPLAY 2 RECORDS IN A ROW FORMAT //
function search_thumb($VALUE1='', $VALUE2='', $VALUE3='', $VALUE4='', $VALUE5) {

	global $ln;
	if ($ln!='en') {
		$width1 = 710; // When other language
		$width2 = 380; // When other language
	} else {
		$width1 = 600; // When English
		$width2 = 289; // When English
	}

?>
	<!-- Start of Search Result Matches -->
	<TABLE cellpadding="3" cellspacing="0" border="0" width="590" align="center">
	<TR>

<?
				$X=0;
				global $parent_tbl_lang, $parentdblink;
				while($ROW = $db->fetchArray()) {

					if($VALUE5==1) {
						$USR=rec_display_new($ROW[0],$INTID,$WHOIS,$parentdblink,$parent_tbl_lang); // for multidomain
					} elseif($VALUE5==2) {
						$USR=rec_display1($ROW,$INTID,$WHOIS); // for single domain
					}
					$Y=($X%2);
					echo "<td height=\"100%\" >";
					// THIS IS FOR DISPLAYING THE THUMB VIEW //
					if($USR!='') {
						if($USR=='1') {
							$p_msg="Hidden Profile $ROW[0]";
							No_record_basic($p_msg);
						} else {
							thumb_view($USR,$X);
						}
					} else {
						$p_msg="Profile Deleted or Suspended $ROW[0]";
						No_record_basic($p_msg);
					}
					if($Y==0) {
						echo "</td><td height=\"100%\">";
					}
					if($Y==1) {
						echo "</td></tr>";
					}
					$X++;
				}

		// THIS PART IS FOR CLOSING TR FOR ODD NUMBERS //
		if(($X%2)!=0) {
		} else {
			echo"</tr>";
		}
?>
	</table>
<?
}

// SEARCH BASIC VIEW //
function search_basic($VALUE1='', $VALUE2='', $VALUE3='', $VALUE4='', $VALUE5) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="padding-left:7px;">
	<tr><td valign="top" colspan="3"><img src="/images/trans.gif" width="5" height="20"></td></tr>
	<tr>
<?
	$X=0;
	while($ROW = $db->fetchArray())
	{
		if($VALUE5==2) {
			$USR=rec_display1($ROW,$INTID); // for single domain
		}
?>
		<td valign="top" bgcolor="#FFFFFF" width="590" height="100%">
		<?
			// THIS IS FOR DISPLAYING THE BASIC VIEW
			if($USR!='') {
				if($USR=='1') {
					$p_msg="Hidden Profile $ROW[0]";
					No_record_basic($p_msg);
				} else {
					basic_view($USR,$X);
				}
			} else {
				$p_msg="Profile Deleted or Suspended $ROW[0]";
				No_record_basic($p_msg);
			}
		?>
		</tr>
		<tr><td width="1" colspan="3"><img src="http://bmser.bharatmatrimony.com/images/trans.gif" width="1" height="20"></td></tr>
		<tr>
		<?
		$X++;
	}
?>
	</table>
<?
}

// This query function is for displaying with out opening connection //
function rec_display1($ROW,$INTID='',$WHOIS='') {
	Global $db, $MOTHERTONGUESTARHASH,$ln,$l_mother_tongue1,$commonstarhash;
	Global $RET_VAL;
    $ln='en';
	$RET_VAL=$ROW; // Assignin Result Set //

	$matriid=$ROW['MatriId'];

	// Profile Description //
	if (trim($ROW['ProfileDescription'])!= '' && $ln=='en') {
		$RET_VAL['ProfileDescription']=substr($ROW['ProfileDescription'],0,100);
	} else {
		$RET_VAL['ProfileDescription']= '';
	}
	$RET_VAL['Star']=getfromarryhash('COMMONSTARHASH',$ROW['Star']);
	$heightinft=calrevfloatheight($ROW['Height']);
	$heightincm=$ROW['Height'];
	$RET_VAL['ft']=$heightinft['ft'];
	$RET_VAL['inchs']=$heightinft['inchs'];
	$RET_VAL['cm']=$heightincm;

	// Country Selecting //
	$RET_VAL['country']=getfromarryhash('COUNTRYHASH',$ROW['CountrySelected']);
	// Residing Area or City or State selecting //
	if($ROW['CountrySelected']==98) { 
		$RET_VAL['state']=getfromarryhash('CITY',$RET_VAL['ResidingDistrict']); // IF INDIA ResidingDistrict
	} elseif ($ROW['CountrySelected']==222) { 
		$RET_VAL['state']=getfromarryhash('RESIDINGUSANAMES',$ROW['ResidingState']); // IF USA ResidingState
	} elseif ($ROW['CountrySelected']!=222 && $ROW['CountrySelected']!=98) { 
		$RET_VAL['state']=$ROW['ResidingArea']; // Other than India and USA ResidingArea
	}

	$RET_VAL['religion']=getfromarryhash('RELIGIONHASH',$ROW['Religion']);
	$RET_VAL['caste']=getfromarryhash('CASTEHASH',$ROW['Caste']);	
	$RET_VAL['Education'] = '';
	if ($ln=='en') {
		if($RET_VAL['SubCaste']!="") {
			$RET_VAL['SubCaste'] = ", ".wordwrap($RET_VAL['SubCaste'],26,'<br>',1);
		} 
		if($RET_VAL['Gothra']!="") {
			$RET_VAL['Gothra'] =", ".wordwrap($RET_VAL['Gothra'],26,'<br>',1);
		}
		if($ROW['Education']!="") {
			$RET_VAL['Education'] ="<br>".$ROW['Education'];
		} 
	} 

	if ($ln != 'en' && $ln != '') {
		$RET_VAL['MotherTongue'] = "$l_mother_tongue1:".getfromarryhash('MOTHERTONGUEHASH',$ROW['MotherTongue']).", ";
	} else {
		$RET_VAL['MotherTongue'] = '';
	}
	
	$RET_VAL['EducationSelected']=getfromarryhash('EDUCATIONHASH',$ROW['EducationSelected']);

	//echo $ROW['MatriId'].'-'.$ROW['OccupationCategory'].'-'.$ROW['OccupationSelected'];
	if ($ROW['OccupationSelected'] == 0) {
		$RET_VAL['OccupationSelected'] = '-';
	} else {
		$RET_VAL['OccupationSelected']=getfromarryhash('OCCUPATIONLIST',$ROW['OccupationSelected']);
	}
	$RET_VAL['OccupationCategory']=getfromarryhash('OCCUPATIONCATEGORY',$ROW['OccupationCategory']);

	getphotodetails($LANG,$db,$matriid);
		// To Display 1 2 3 select option for photo //
	//echo 'photo count'.$RET_VAL['MatriId'].'-'.$RET_VAL['photo_count'];
	
	if ($RET_VAL['PhotoProtected'] != 'Y' && $RET_VAL['PhotoAvailable']==1) {
		if ($RET_VAL['photo_count'] > 1) {
			$RET_VAL['photo123'] = "<div class=\"thumbphotolink\">";
			if ($RET_VAL['photo'] != '' && $RET_VAL['photo'] != 'NULL') {
			$RET_VAL['photo123'] .= "<a class=\"smalllink\" href=\"javascript:ph_new('".$RET_VAL['photo']."','".$RET_VAL['MatriId']."','".$RET_VAL['photoM1']."','".$RET_VAL['MatriId']."_el2')\" class=\"normaltxt1\"><font color=\"#94663E\"><u>1</u></font></a>&nbsp;";
			} 
			if ($RET_VAL['photo2'] != '' && $RET_VAL['photo2'] != 'NULL') {
			$RET_VAL['photo123'] .= "<a class=\"smalllink\" href=\"javascript:ph_new('".$RET_VAL['photo2']."','".$RET_VAL['MatriId']."','".$RET_VAL['photoM2']."','".$RET_VAL['MatriId']."_el2')\" class=\"normaltxt1\"><font color=\"#94663E\"><u>2</u></font></a>&nbsp;";
			} 
			if ($RET_VAL['photo3'] != '' && $RET_VAL['photo3'] != 'NULL') {
				$RET_VAL['photo123'] .= "<a class=\"smalllink\" href=\"javascript:ph_new('".$RET_VAL['photo3']."','".$RET_VAL['MatriId']."','".$RET_VAL['photoM3']."','".$RET_VAL['MatriId']."_el2')\" class=\"normaltxt1\"><font color=\"#94663E\"><u>3</u></font></a>&nbsp;";
			}
			$RET_VAL['photo123'] .= "</div>";
		}
	}

	$RET_VAL['HoroIcon'] = '';

	// Request Horoscope Link //
	if ( (($RET_VAL['HoroscopeAvailable']!=1) && ($RET_VAL['HoroscopeAvailable']!=2)) && ($RET_VAL['HoroscopeAvailable']!=3) ||  ($RET_VAL['HoroscopeProtected'] == 'Y')){	
		//$RET_VAL['ReqHoro'] = "<img src=\"images/bmcorangebullet.gif\" width=\"6\" height=\"6\">&nbsp;&nbsp;<a href=\"javascript:requesthorophoto('".$RET_VAL['MatriId']."','horo')\" alt=\"Request Horoscope\"  style=\"text-decoration:none\" >Horo Request</a>";
	} elseif ((($RET_VAL['HoroscopeAvailable']==1) || ($RET_VAL['HoroscopeAvailable']==2)) &&  ($RET_VAL['HoroscopeProtected'] != 'Y')) {
		//$RET_VAL['HoroIcon'] = "<a href=\"javascript:viewhoro('".strtoupper($RET_VAL['MatriId'])."')\" alt=\"View Horoscope\"><img src=\"http://bmser.bharatmatrimony.com/images/astroicon.gif\" alt=\"Horoscope\" hspace=\"5\"  width=\"16\" height=\"16\" border=\"0\"  align=\"abstop\"></a>";
	} elseif($RET_VAL['HoroscopeAvailable']==3){
	//$lang=findlang(substr($RET_VAL[MatriId],0,1));
	//$RET_VAL['HoroIcon']= "<a href=\"javascript:viewhoro_new('$RET_VAL[MatriId]','$lang')\" alt=\"View Horoscope\" class='headertxt'><img src=\"http://bmser.bharatmatrimony.com/images/astroicon.gif\" width=\"16\" height=\"16\" hspace=\"5\" vspace=\"2\" alt=\"Horoscope available\" border=\"0\" align=\"middle\"></a>";
	} else {
		$RET_VAL['HoroIcon'] = '';
	}
	// Request Photo Link //
	if ($RET_VAL['PhotoProtected'] == 'Y' || $RET_VAL['PhotoAvailable'] != 1) {	
		//$RET_VAL['ReqPhoto'] = "<img src=\"images/bmcorangebullet.gif\" width=\"6\" height=\"6\">&nbsp;&nbsp;<a href=\"javascript:requesthorophoto('".$RET_VAL['MatriId']."','photo')\" alt=\"Request Photo\"  style=\"text-decoration:none\" >Photo Request</a>";
	}

	/* Highlighting the profile for PowerPackOpted users */
		$RET_VAL['PowerPack'] = 'class=\"srchborderclr\"';
	
	//$RET_VAL['PowerPack'] = 'style=\"border:1px solid #946E4D\"';
	
	if ($RET_VAL['PowerPackOpted']==1 || $RET_VAL['PowerPackOpted']==2) {
		$RET_VAL['PowerPack'] = "class=\"powerpackborderclr\"";
	}
	return $RET_VAL; 	// FINAL RESULT RETURN //
}

// IF THE PROFILE DELETED OR SUSPENDED OR HIDDEN //
function No_record_basic($MSG="") {
	$no_rec_basic_tpl = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\"> <tr><td valign=\"top\" width=\"100%\" bgcolor=\"#FFFFFF\" class=\"srchborderclr\" align=\"Center\" style=\"padding-top:5px;padding-left:3px;padding-right:1px;padding-bottom:5px;\"><font class=\"normaltxt2\">$MSG</font></td></tr></table>";
	echo $no_rec_basic_tpl;
} 

function dateformat_func ($dttime='') {
	return	date ("d-M-Y H:i", mktime ($dttime[3],$dttime[4],0,$dttime[1],$dttime[2],$dttime[0]));
}

function getphotodetails($LANG,$db,$matriid) {
	global $RET_VAL,$photoinfo,$db;

	$RET_VAL['photo_count'] = 0;
	if($RET_VAL['PhotoAvailable']==1) {
		if($RET_VAL['PhotoProtected']=='Y') {
			$RET_VAL['photo']="http://bmser.bharatmatrimony.com/images/requestphoto75x75.gif";
			$RET_VAL['photopr']="Y";
		} else {
			$psql="select * from photoinfo where MatriId='$matriid'";
			$pnum=$db->select($psql);
			if($pnum>0) {
				$row_p=$db->fetchArray($psql);
				$digit1=$matriid;
				$RET_VAL['photo']=getphoto($row_p['ThumbImgs1'],$matriid);
				$RET_VAL['photoM1']=getphoto($row_p['ThumbImg1'],$matriid);
				if ($RET_VAL['photo'] != '') {
					$RET_VAL['photo_count'] = $RET_VAL['photo_count'] + 1;
				}
				if(($row_p['PhotoStatus2']==0)&&($row_p['PhotoStatus2']!="")&&($row_p['PhotoStatus2']!=NULL)) {
					$RET_VAL['photo2']=getphoto($row_p['ThumbImgs2'],$matriid);
					$RET_VAL['photoM2']=getphoto($row_p['ThumbImg2'],$matriid);
					if ($RET_VAL['photo2'] != '') {
						$RET_VAL['photo_count'] = $RET_VAL['photo_count'] + 1;
					}
				}
				if(($row_p['PhotoStatus3']==0)&&($row_p['PhotoStatus3']!="")&&($row_p['PhotoStatus3']!=NULL)) {
					$RET_VAL['photo3']=getphoto($row_p['ThumbImgs3'],$matriid);
					$RET_VAL['photoM3']=getphoto($row_p['ThumbImg3'],$matriid);
					if ($RET_VAL['photo3'] != '') {
						$RET_VAL['photo_count'] = $RET_VAL['photo_count'] + 1;
					}
				}
			} else {
				$RET_VAL['photo']="http://bmser.bharatmatrimony.com/images/thumbnotfound75x75.gif";
				$RET_VAL['photopr']="Y";
			}
		}
	} else {
		$RET_VAL['photo_count'] = 0;
		$RET_VAL['photo']="http://bmser.bharatmatrimony.com/images/requestphoto75x75.gif";
		$RET_VAL['photopr']="Y";
		$RET_VAL['reqphoto']="Y";
	}

}


// FOR THUMB VIEW - HTML TEMPLATE DISPLAY FOR THE PAGE //
function thumb_view($USR,$LOOP='',$IGO_LIST='') {
	global $membership_entry,$memberid,$gender,$member_id,$gender;
	global $ln,$l_years,$l_education,$l_occupation,$l_height_cms,$l_height_ft,$l_height_in,$l_star;

	$thumb_tpl = '<table border="0" cellpadding="0" cellspacing="0" width=360 '.$USR['PowerPack'].' height="100%">
	<tr>
	  <td valign="top" class="srchborderclr">
	   <table border="0" cellpadding="0" cellspacing="0" height="100%">
	   <tr>
	   <td valign="top" width="82" bgcolor="#FFFFFF" class="" align="Center" style="padding-top:5px;padding-left:3px;padding-right:1px;padding-bottom:5px;">
		<div class="thumbphotowidth1">
		  <div class="thumbphotowidth2">
			<div class="thumbphotoborder"><a href="http://bmser.bharatmatrimony.com/cgi-bin/viewprofile.php?id='.$USR['MatriId'].'&ln='.$ln.'" target="_blank" GALLERYIMG="no" oncontextmenu="return false"></a>';
if($USR['photo_count']>0){				
	
				$thumb_tpl.=' <div onmouseover="replace_image(\''.$USR['MatriId'].'_el\',0); return overlay(this,\''.$USR['MatriId'].'_el\')" onmouseout="overlayclose(\''.$USR['MatriId'].'_el\');">
					<div class="tpb">
						<a href="javascript:viewpic(\''.$USR[MatriId].'\',\''.newdocrypt($USR[MatriId]).'\')"><img src="'.$USR['photo'].'" width="75" height="75" border="0" alt="View Complete Details" vspace="2" hspace="2" id="'.$USR['MatriId'].'"></a></div> 
						<div id="'.$USR['MatriId'].'_el" class="mover">
							<div id="'.$USR['MatriId'].'_loading" style="text-align:center">
								<font class="textsmallbold">Loading...</font>
							</div>
							<en_img src="'.$USR['photoM1'].'" height="150" width="150" id="'.$USR['MatriId'].'_el2" onload="en_rep_loading(\''.$USR['MatriId'].'_loading\');" border="0">
						</div>
					</div>
				</div>'.$USR['photo123'];
}else{
	$thumb_tpl.='<div class="tpb"><img src="'.$USR['photo'].'" width="75" height="75" border="0" alt="View Complete Details" vspace="2" hspace="2" id="'.$USR['MatriId'].'"></div>'; 
}
			$thumb_tpl.='</div>
			</div>
			</td>
			<td bgcolor="#FFFFFF" valign="top" width="100%" class="textsmallnormal" STYLE="padding-left:5px;padding-right:5px;padding-top:5;line-height:16px; font-style: normal; text-align: justify; text-transform: none; color: #000000;">
				<font color="#212116"><b>BMC ID :</b> <a href="http://bmser.bharatmatrimony.com/cgi-bin/viewprofile.php?id='.$USR['MatriId'].'&ln='.$ln.'" class="linktxt" target="_blank"><b>'.$USR['MatriId'].'</b></a></font>&nbsp;&nbsp;&nbsp;'.$USR['HoroIcon'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<br><font class="for_language" style="text-align:left;">'.$USR['Age'].' '.$l_years.', '.$USR['ft'].' '.$l_height_ft.' '.$USR['inchs'].' '.$l_height_in.' / '.round($USR['cm']).' '.$l_height_cms.', '.$USR['religion'].': '.$USR['caste'].','.$USR['Star'].' ,'.$USR['state'].', '.$USR['country'].','.$USR['EducationSelected'].', '.$USR['OccupationCategory'].' </font>
				<a href="http://bmser.bharatmatrimony.com/cgi-bin/viewprofile.php?id='.$USR['MatriId'].'&ln='.$ln.'" class="linktxt" target="_blank">More</font></a></td>

				</tr>
			</table>
		</td>
	</tr>

	<tr>
	<td style="border-left: 1px solid #88865B;border-bottom: 1px solid #88865B;border-right: 1px solid #88865B;">
		<table border="0" cellpadding="2" cellspacing="0" width="100%" bgcolor="#FCEDD6">
			<tr>';
			if (trim($member_id)!='' && $gender != $USR['Gender']) {
				$thumb_tpl .= '<td valign="middle" style="border-right:1px solid #CEAE95;font:normal 11px tahoma,verdana,arial;">&nbsp;<img src="images/bmcorangebullet.gif" width="6" height="6">&nbsp;&nbsp;<a href="javascript:bookmark(\''.$USR['MatriId'].'\')" alt="Add to Favourite" style="text-decoration:none">Add to favourite </a>&nbsp;<img src="images/bmcorangebullet.gif" width="6" height="6">&nbsp;
					<a href="javascript:ignore(\''.$member_id.'\',\''.$USR['MatriId'].'\');" style="text-decoration:none" >Ignore</a>&nbsp;&nbsp;
					'.$USR['ReqHoro'].'&nbsp;&nbsp;'.$USR['ReqPhoto'].'
				</td>';
			} elseif(trim($member_id)=='') {
				$thumb_tpl .= '<td valign="middle" style="border-right:1px solid #CEAE95;font:normal 11px tahoma,verdana,arial;">&nbsp;<img src="images/bmcorangebullet.gif" width="6" height="6">&nbsp;&nbsp;<a href="#" title="Register/Login to Add to Favourite" style="text-decoration:none">Add to favourite </a>&nbsp;<img src="images/bmcorangebullet.gif" width="6" height="6">&nbsp;
					<a href="#" title="Register/Login to Ignore" style="text-decoration:none" >Ignore</a>&nbsp;&nbsp;
				</td>';
			} else {
				$thumb_tpl .= '<td valign="middle" style="font:normal 11px tahoma,verdana,arial;border-right:1px solid #CEAE95">&nbsp;</td>';
			}

		$thumb_tpl .=	'</tr>
		</table>
	</td>
	</tr>

	</table>';

	echo $thumb_tpl;

}

// FOR BASIC VIEW - HTML TEMPLATE DISPLAY FOR THE PAGE //
function basic_view($USR,$LOOP='',$IGO_LIST='',$wid,$pge) {
	global $db,$DBNAME,$TABLE,$RET_VAL,$MERGETABLE;
	global $ln,$l_years,$l_education,$l_occupation,$l_height_cms,$l_height_ft,$l_height_in,$l_star;
	global $member_id, $gender,$membership_entry,$memberid,$gender;
	global $l_age,$l_religion,$l_star,$l_education,$l_occupation,$l_location_informntion;
//	$domain_value=getDomainLang($USR['MatriId']);
$language=getDomainInfo(1,$USR['MatriId']);
$domain_value=$language["domainnameshort"];
	if($wid==""){
	$wid="690";
	}
	
$id = $USR['MatriId'];
if(($RET_VAL['PhotoAvailable']==1)&&($RET_VAL['PhotoProtected']!="Y"))
	{
	// Photo Available
$ph_sql="select MatriId,ThumbImgs1,PhotoURL1,PhotoProtected from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO']." where MatriId='$id' and (PhotoProtected='N' or PhotoProtected is NULL or PhotoProtected='') and  (PhotoStatus1=0 or PhotoStatus1=2) ";
$db->select($ph_sql);
$ph_res=$db->fetchArray();
$img_val[$ph_res['MatriId']]="http://imgs.".$domain_value."matrimony.com/photos/".substr($ph_res['MatriId'],1,1)."/".substr($ph_res['MatriId'],2,1)."/".$ph_res['ThumbImgs1'];

	}
	else
	{
$img_val[$ph_res['MatriId']]="";
	}

 $gender=$RET_VAL['Gender']; 


	?>
<div style="float:left;width:480px;">	
<?php if($img_val[$id] !="") {?>			
<div style="float:left;width:80px;"><img src="<?=$img_val[$id];?>" width="75" height="75" border="0" alt="View Complete Details" id="<?=$USR['MatriId']?>" /></div>
<?php } else {  ?>

<div id="useracticons">
	<div id="useracticonsimgs">
<div style="float:left;width:80px;"><a href="javascript:;" onClick="photo_req()"><div class="useracticonsimgs photorequest<?php echo $gender;?>"></div></a></div>

</div></div> <?php } ?>

<div class="smalltxt" style="float:left;width:380px;padding-left:5px">
<div style="float:left"><a href="http://profile.<?=$domain_value?>matrimony.com/profiledetail/viewprofile.php?id=<?=$USR['MatriId']?>" class=" matriidlink bold" target="_blank"><?=$USR['Name']?>  (<?=$USR['MatriId']?>)</a><br clear="all">
	<?=$USR['Age']?> yrs, <?=$USR['ft']?>Ft <?=$USR['inchs']?>In / <?=round($USR['cm'])?> Cms | <?=$USR['religion'];?><?=($USR['caste']!='-')?": ".$USR['caste']." " :'';?> |
	<?php if($USR['SubCaste']!="") { ?> | Subcaste: <?php echo $USR['SubCaste'];  echo "|"; } ?> <? if(trim($USR['Star'])!='-'){ ?> <b> Star </b>: <?echo $USR['Star']; echo " |";}?>  <?=$USR['state'].", ".$USR['country'];?> | <?=$USR['EducationSelected'];?> | 
	<?=$USR['OccupationSelected'];?><?=$USR['Occupation'];?></div><br clear="all">
	<!--<div class="fleft"><a href="http://bmser.<?=$domain_value?>matrimony.com/cgi-bin/viewprofile.php?id=<?=$USR['MatriId']?>&ln=<?=$ln?>" class="smalltxt clr1 fright" target="_blank">-->
	
	<div class="fleft"><a href="http://profile.<?=$domain_value?>matrimony.com/profiledetail/viewprofile.php?id=<?=$USR['MatriId']?>" class="smalltxt clr1 fright" target="_blank">
	
	
	Full Profile >></a>
</div><div class="fright"><a href="javascript:blockmem()" class="clr1 boldtxt">Block</a></div>

</div>		
</div><br clear="all">

<?php } 


function search_Photogallery($VALUE1='', $VALUE2='', $VALUE3='', $VALUE4='', $VALUE5) {

	global $ln;
	if ($ln!='en') {
		$width1 = 710; // When other language
		$width2 = 380; // When other language
	} else {
		$width1 = 600; // When English
		$width2 = 289; // When English
	}

?>
	<!-- Start of Search Result Matches -->
<table style="padding-top: 10px;" align="center" border="0" cellpadding="5" cellspacing="1" width="100%">
<tr>

<?
				$X=0;
				global $parent_tbl_lang, $parentdblink;
				while($ROW = $db->fetchArray()) {
					if($VALUE5==1) {
						$USR=rec_display_new($ROW[0],$INTID,$WHOIS,$parentdblink,$parent_tbl_lang); // for multidomain
					} elseif($VALUE5==2) {
						$USR=rec_display1($ROW,$INTID,$WHOIS); // for single domain
					}
					$Y=($X%2);
					echo "<td height=\"100%\" >";
					// THIS IS FOR DISPLAYING THE THUMB VIEW //
					if($USR!='') {
						if($USR=='1') {
							$p_msg="Hidden Profile $ROW[0]";
							No_record_basic($p_msg);
						} else {
							photo_view($USR,$X);
						}
					} else {
						$p_msg="Profile Deleted or Suspended $ROW[0]";
						No_record_basic($p_msg);
					}
					
					/*
					if($Y==0) {
						echo "</td><td height=\"100%\">";
					}
					if($Y==1) {
						echo "</td></tr>";
					}
*/
					$X++;
			// THIS PART IS FOR CLOSING TR FOR Every $ Photo 0//
			if($X!=4) {
			} else {
				echo"<td></td><tr><td></td></tr>";
				$X=0;
			}
		}

	

?>
	</table>
<?
}


////////////////////////////

// FOR THUMB VIEW - HTML TEMPLATE DISPLAY FOR THE PAGE //
function photo_view($USR,$LOOP='',$IGO_LIST='') {
	global $membership_entry,$memberid,$gender,$member_id,$gender;
	global $ln,$l_years,$l_education,$l_occupation,$l_height_cms,$l_height_ft,$l_height_in,$l_star;
	global $l_age,$l_religion,$l_star,$l_education,$l_occupation,$l_location_informntion;
	$Loc = explode(" ",$l_location_informntion);
	//$Loc=ucfirst($Loc[1]);
	$thumb_tpl = "
	<td align='center'>
		<table align='center' border='0' cellpadding='0' cellspacing='0'>
		<tbody>
			<tr><td>
			<div class='' style='float: left;'>
				<div style='background-color: rgb(255, 255, 255);' id='".$USR[MatriId]."_1' class='pd1' onmouseover='overlaychange(\"".$USR[MatriId]."_1\");return overlay(this,\"".$USR[MatriId]."_D1\")' onmouseout='overlayout(\"".$USR[MatriId]."_1\");overlayclose(\"".$USR[MatriId]."_D1\");' align='center'>
					<div class='pd'>
						<div style='padding-left: 15px;'>
							<table border='0' cellpadding='0' cellspacing='0'>
								<tbody>
									<tr><td>
										<div style='float: left;'>
											<a href='javascript:viewpic(\"".$USR[MatriId]."\")'><img src='".$USR['photo']."' alt='View Enlarge Photo' id='$USR[MatriId]_E1' border='0' height='75' hspace='2' vspace='2' width='75'></a>
										</div>
										<div style='float: left;'>
											<img src='http://bmser.bharatmatrimony.com/images/trans.gif' border='0' height='1' width='16'>
										</div>
									</td></tr>
									</tbody>
								</table>
								</div>
								<div class='smalltxtgr'>
									<font class='for_language'>";
if (trim($member_id)!='' && $gender != $USR['Gender']) {
 $thumb_tpl .= "<input name='ID' value='$USR[MatriId]' type='checkbox' id='ID$USR[MatriId]' onclick=\"pg_bookmark('$USR[MatriId]')\">&nbsp;";
	}
								$thumb_tpl .=$USR['Age']." ".$l_years." , ".$USR['ft']." '".$USR['inchs']."
									</font>
								</div>
							</div>
							<div style='left: 357px; top: 388px; display: none;' id='$USR[MatriId]_D1' class='pd2'>
								<div class='pg_bg'><div class='pg_bg1'>
									<font class='for_language'>
										<a href='http://bmser.bharatmatrimony.com/cgi-bin/viewprofile.php?id=$USR[MatriId]' target='_blank' class='linktxt'>
											<font class='smalltxtgr'>
											<font color='#ef6f1f'>
											<b style='padding-left: 5px;'>$USR[MatriId]</b>
											</font></font></a>
												$USR[HoroIcon]
												<img src='http://bmser.bharatmatrimony.com/images/trans.gif' border='0' height='16' width='1'>
														<br>
														</font>
													<div class='newcss11'><font class='for_language'><font class='smalltxtgr'><font class='for_language'><b>".$l_age."</b>
														<font class='smalltxtgr'><font class='for_language'>".$USR['Age']." ".$l_years." ,".$USR['ft']." ".$l_height_ft." ".$USR['inchs']." ".$l_height_in."  ".round($USR['cm'])." ".$l_height_cms."</font></font></font>
													</div>
												<div class='newcss11'><font class='for_language'><font class='smalltxtgr'><font class='for_language'>";
									if($USR['religion']!=''){
										$thumb_tpl.="<b>".$l_religion."</b>: ".$USR['religion'];
									}
									$thumb_tpl.=($USR['caste']!='')?", ".$USR['caste']:"";
									if(trim($USR['Star'])!='-'){
										$thumb_tpl.="<b> ".$l_star." </b>: ".$USR['Star'];
									}

									$thumb_tpl.="</font></font></font></div><div class='newcss11'><font class='for_language'><font class='smalltxtgr'><font class='for_language'><b>".ucfirst($l_location_informntion) ."</b>: ".$USR['state'].", ".$USR['country']."</font></font></font></div><div class='newcss11'><font class='for_language'><font class='smalltxtgr'><font class='for_language'><b>".$l_education."</b>: ".$USR['EducationSelected']."</font></font></font></div><div class='newcss11'><font class='for_language'><font class='smalltxtgr'><font class='for_language'><b>".$l_occupation."</b>: ".$USR['OccupationCategory']."</font></font></font></div><div class='newcss11'><font class='for_language'><font class='smalltxtgr'><font class='for_language'></font></font></font></div></div></div></div></div></div></td></tr></tbody></table></td>";

		
	echo $thumb_tpl;

}

?>