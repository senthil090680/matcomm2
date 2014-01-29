<?php
/********************************************************************************************************************
 FILENAME			: lastviewprofile.PHP  
 AUTHOR				: Andal.V	
 Date				: 03-Jan-2008
 DESCRIPTION		: It displays the recently viewed profile by the member
*********************************************************************************************************************/

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmpagenav.inc";
include_once $DOCROOTPATH."/inbox/basictemplate.php"; // basic template function location...
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";


if($COOKIEINFO['LOGININFO']['MEMBERID']==''){
	$redirect_domain = str_replace("bmser.","",strtolower($_SERVER['SERVER_NAME']));
	header("location:http://www.".$redirect_domain."/addmatrimony.shtml");
	exit();
}

$dontdisp=0;
if($COOKIEINFO['LOGININFO']['MEMBERID']!="") {
	$db_slave = new db;				$db_slave->dbConnById(2,$COOKIEINFO['LOGININFO']['MEMBERID'],"S",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);	
	if($db_slave->error) {
		echo "We are currently experiencing technical difficulties. Please try again later.";
		$dontdisp=1;		
	 }
}
$disp=0;
if($dontdisp!=1) {
?>

<div style="margin:0px;padding:0px;">
<form name="frmlastview" method="post" style="margin:0px;">
<input type="hidden" name="chk_val" value="">
	<div style="width:508px;" id="intdiv">	
	
	<?php
	$query="select distinct(MatriId) from ".$DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($GETDOMAININFO['domainnameshort'])]['VIEWHISTORY']." where ViewerId = '". $COOKIEINFO['LOGININFO']['MEMBERID']."' order by DateViewed Desc limit 20";
	$NUM=$db_slave->select($query);

	if($NUM>0) {
	

		$resultrow = $db_slave->getResultArray();
		if($resultrow)  {
		foreach($resultrow as $row) {

		$matid.= "'".$row[0]."' , ";
		}
	

		$select="select MatriId from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE']." where  Status=0 and Validated=1 and Authorized=1 and MatriId IN ( ".substr ($matid, 0, strlen($matid)-3).")  ";
		$number=$db_slave->select($query);

		$resrow = $db_slave->getResultArray();
	 if($number>0) {

		if($resrow) {
			foreach($resrow as $row) {
				$senid[] = $row[0];
		}	
	?>
<input type="hidden" name="lv_count" value="<?=$number;?>">
	 <div style="float:left; width:508px; height:50px;" > 
		<div style="float:left; width:1px; height:50px;background:url(<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/inner-tab-border1.gif);"></div>
		<div style="float:left; width:506px; height:50px; background-image:url('<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/inner-tab-bg.gif');">&nbsp;</div>
		 <div style="float:left;background:url(<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/inner-tab-border1.gif);width:1px; height:50px;"></div>
	 </div> 
	
	<div style=" width:508px;" class="smalltxt">
		<div style="float:left; background:url(<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/inner-tab-border2.gif);width:1px; height:33px;"></div>
		<div style=" width:506px;" class="fleft smalltxt">
			<div style="padding: 4px 10px 0px 10px;" >Displayed below are the most recently viewed profiles.<br/><br/></div>
		</div>
		<div style="float:left; background:url(<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/inner-tab-border2.gif);width:1px; height:33px;"></div>
	</div>	
	
	<?php	


		
		
		$usrArr = basicView($senid, 1, $db_slave, 'Y', '', 'nohidden');

		if($number>1) {
			echo disp_selectall('CONTACTTOP','t',count($usrArr),1);
		}
		else {
			echo '<div class="borderline"><img src="'.$COMMONVARS['IM_SERVER_PREFFIX'].'/bmimages/trans.gif" height="1" width="508"></div><br clear="all"/>';
		}

		echo '<div id="last_checkdiv">';

		
			
			for($i=0;$i<count($usrArr);$i++) {
				if($usrArr[$senid[$i]."_".$i]!="") {
					$disp=1;

				?>

				<div id="basicview_<?=$i?>">
				<div class="borderline"><img src="http://<?=$domaininfoarr['domainnameimgs']?>/bmimages/trans.gif" height="1" width="508"></div><br clear="all">
				<div class="fleft middiv2">
				<div class="fleft"><input type="checkbox"  name="last_cb[]" value="<?=$senid[$i];?>" id="last_cb<?=$senid[$i];?>" onClick="chkbox_select('last_cb<?=$senid[$i];?>');"></div> 
				<div class="fleft vc6pd-top smalltxt1"><font for="last_cb<?=$senid[$i];?>" onclick="chkbox_check('last_cb<?=$senid[$i];?>')">Select this profile</font></div>
				<div class="fright">
				<div class="fleft smalltxt" style="padding-left:10px;"><a href="javascript:;" class="clr1" onclick='confirmInterestAll("last_cb<?=$senid[$i];?>","s",<?=$i;?>,"");'>Delete</a></div>
				</div>
				</div><br clear="all">
			
				<?php
				echo $usrArr[$senid[$i]."_".$i];
				echo getExpLink($senid[$i],$i+1);
				echo '<br clear="all"></div>';
				}
			}
	}
		}
	?>

	</div>
	<div class="borderline"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/trans.gif" height="1" width="508"></div>	

	<?php 
		if($number>1) {
			echo disp_selectall('CONTACTBOT','b',count($usrArr),2);
		}
		echo "</div>";
	}
	} 	
	$db_slave->dbClose();
	?>

	</div>		
	
</form>
</div>

<?php 
}
?>
<?php ($disp==1)? $none="none" : $none="block"; ?>
<div id="shwcont" style="display:<?=$none;?>">Currently there are no profiles in your Recently viewed list.<br clear="all"></div><br clear="all">
<?

function disp_selectall($ch,$t,$c,$i) {
	global $COOKIEINFO;

	$but ='<div id="selall_'.$i.'" class="middiv2 smalltxt" style="padding-bottom:0px;"><div class="fleft" style="padding-top:6px;"><input type="checkbox"  name="'.$ch.'" id="'.$ch.'" value="1" onclick="checkAllTOP(\''.$t.'\');"></div><div class="fleft" style="padding-top:8px;"><label for="'.$ch.'">Select All</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirmInterestAll(\'\',\'f\',\'0\','.$c.');" class="clr1">Delete All</a></div><div class="smalltxt" style="float:right; padding-bottom:5px;padding-top:5px;"><div class="smalltxt" style="float:left; padding:2px;">';

	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID']!= '' ) { 	
		if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] == 'R') {
			$but.='<input type="button" value="Send Mail All" class="button button-border" onclick="$form_contact(\'frmlastview\');" title="Will send the same message to multiple profiles at a single click">';
		} else if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] == 'F'){
			$but.='<input type="button" value="Express Interest All" class="button button-border" onclick="$form_express(\'frmlastview\',\'f\');">';
		}
	}

	$but.='&nbsp;<input type="button" value="Forward" class="button button-border" onclick="$form_forward(\'frmlastview\',\'f\');" title="Will forward this profile to the e-mail ID you propose"></div>';
	return $but.'</div></div><br clear="all">'; 
}

function getExpLink($MID,$cpro) {
	global $COOKIEINFO,$GETDOMAININFO,$GLOBALS;

	if(isset($COOKIEINFO['LOGININFO']['MEMBERID']) && $COOKIEINFO['LOGININFO']['MEMBERID']!= '') { 	
		if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] == 'R') {
			return "<div class='vdotline'><div class='smalltxt phnextpadding fleft pntr' onClick=\"javascript:fade('M".$cpro."','fadediv','dispdiv',550,'','','http://".$GLOBALS['DOMAINMODULEPREFIX'].$GETDOMAININFO['domainnameshort']."matrimony.com/inbox/inbcontact.php?ID=".$MID."','','dispcontent','','');\">Type your message</div><div class='smalltxt fright' style='padding:7px;'><input type='button' value='Send Mail' class='button button-border'  title='Send a personalised message to member'		onClick=\"javascript:fade('M".$cpro."','fadediv','dispdiv',550,'','','http://".$GLOBALS['DOMAINMODULEPREFIX'].$GETDOMAININFO['domainnameshort']."matrimony.com/inbox/inbcontact.php?ID=".$MID."','','dispcontent','','');\"></div></div>";
		} else if($COOKIEINFO['LOGININFO']['ENTRYTYPE'] == 'F') {
			return "<div class='vdotline'><div class='smalltxt phnextpadding fleft'><a href='javascript:void(0)' onClick=\" javascript:fade('M".$cpro."','fadediv','dispdiv',534,'','','http://".$GLOBALS['DOMAINMODULEPREFIX'].$GETDOMAININFO['domainnameshort']."matrimony.com/expressinterest/geteioptions.php?t=".$MID."','".$COMMONVARS['IM_SERVER_PREFFIX']."/scripts/getoptionsei.js','dispcontent','','')\"><div class='fleft'>Select your message</div><div class='exp_downarrow_icon fleft' ></div></a></div><div class='smalltxt fright' style='padding:7px;'><input type='button' value='Express Interest' class='button button-border' onClick=\" javascript:fade('M".$cpro."','fadediv','dispdiv',534,'','','http://".$GLOBALS['DOMAINMODULEPREFIX']. $GETDOMAININFO['domainnameshort']."matrimony.com/expressinterest/geteioptions.php?t=".$MID."','".$COMMONVARS['IM_SERVER_PREFFIX']."/scripts/getoptionsei.js','dispcontent','','')\"></div></div>"; 
		}		
	}
}
?>