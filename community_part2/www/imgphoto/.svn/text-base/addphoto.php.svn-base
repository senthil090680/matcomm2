<?
#================================================================================================================
   # Author 		: Senthilnathan
   # Date			: 15-Apr-2009
   # Project		: MatrimonyProduct
   # Filename		: addphoto.php
#================================================================================================================
   # Description	: PhotoManagement - Managephoto
#================================================================================================================
//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
//include_once($varRootBasePath."/lib/clsPhoto.php");
include_once($varRootBasePath."/lib/clsMemcacheDB.php");

//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessGender		= $varGetCookieInfo['GENDER'];
$sessPaidStatus	= $varGetCookieInfo['PAIDSTATUS'];

//Object initialization
//$objMasterDB	= new Photo;
$objMasterDB	= new MemcacheDB;

//CONNECTION DECLARATION
$varMasterConn	= $objMasterDB->dbConnect('M', $varDbInfo['DATABASE']);

//SETING MEMCACHE KEY
$varOwnProfileMCKey= 'ProfileInfo_'.$sessMatriId;

//CHECK PHOTOS 
$varEmptyImg	= ($sessGender == 1) ? 'addph-male' : 'addph-female';
$varCSSImg		= ($sessGender == 1) ? 'photoaddm' : 'photoaddf';
$varEmptyImg	= $confValues['IMGSURL'].'/'.$varEmptyImg;

if($sessPaidStatus ==1){
$varFields		= array('MatriId','BM_MatriId','User_Name','Name','Nick_Name','Age','Dob','Gender','Height','Height_Unit','Weight','Weight_Unit','Body_Type','Appearance','Complexion','Eye_Color','Hair_Color','Physical_Status','Blood_Group','Marital_Status','No_Of_Children','Children_Living_Status','Education_Category','Education_Detail','Employed_In','Occupation','Occupation_Detail','Income_Currency','Annual_Income','Religion','Denomination','CommunityId','CasteId','CasteText','Caste_Nobar','SubcasteId','SubcasteText','Subcaste_Nobar','Mother_TongueId','Mother_TongueText','Star','Raasi','GothramId','GothramText','Chevvai_Dosham','Horoscope_Match','Religious_Values','Ethnicity','Resident_Status','Country','Citizenship','Residing_State','Residing_Area','Residing_City','Residing_District','Contact_Address','Contact_Phone','Contact_Mobile','About_Myself','Eating_Habits','Smoke','Drink','Profile_Viewed','Profile_Created_By','Profile_Referred_By','Publish','Last_Login','Photo_Set_Status','Protect_Photo_Set_Status','Filter_Set_Status','Video_Set_Status','Partner_Set_Status','Family_Set_Status','Interest_Set_Status','Phone_Verified','Phone_Protected','Video_Protected','Horoscope_Available','Horoscope_Protected','Reference_Set_Status','Profile_Verified','Voice_Available','Video_Set_Status','Pending_Modify_Validation','Paid_Status','Special_Priv','Date_Created','Date_Updated');
$varCondition	= " WHERE MatriId = ".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB)." AND ".$varWhereClause;
$arrMInfoDet	= $objMasterDB->select($varTable['MEMBERINFO'], $varFields, $varCondition, 0, $varOwnProfileMCKey);
$varProPhStatus	= $arrMInfoDet['Protect_Photo_Set_Status'];
if($varProPhStatus == 1){
	$varaddpassDIV			= 'none';
	$varunprotectpassDIV	= 'block';
	$varcontentdiv1			= 'none';
	$varcontentdiv2			= 'block';
}else{
	$varaddpassDIV			= 'block';
	$varunprotectpassDIV	= 'none';
	$varcontentdiv1			= 'block';
	$varcontentdiv2			= 'none';
}
}

$varCondition	= "WHERE MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB)." AND (Normal_Photo1!='' OR Normal_Photo2!='' OR Normal_Photo3!='' OR Normal_Photo4!='' OR Normal_Photo5!='' OR Normal_Photo6!='' OR Normal_Photo7!='' OR Normal_Photo8!='' OR Normal_Photo9!='' OR Normal_Photo10!='')";
$varTotRecords	= $objMasterDB->numOfRecords($varTable['MEMBERPHOTOINFO'], 'MatriId', $varCondition);

$varAllPhFlag	= 0;
$varNoOfPhotos	= 0;
if($varTotRecords > 0){
$varFields		= array('Normal_Photo1', 'Photo_Status1', 'Normal_Photo2', 'Photo_Status2', 'Normal_Photo3', 'Photo_Status3', 'Normal_Photo4', 'Photo_Status4', 'Normal_Photo5', 'Photo_Status5', 'Normal_Photo6', 'Photo_Status6', 'Normal_Photo7', 'Photo_Status7', 'Normal_Photo8', 'Photo_Status8', 'Normal_Photo9', 'Photo_Status9', 'Normal_Photo10', 'Photo_Status10');
$varCondition	= "WHERE MatriId=".$objMasterDB->doEscapeString($sessMatriId,$objMasterDB);
$varPhotoRes	= $objMasterDB->select($varTable['MEMBERPHOTOINFO'], $varFields, $varCondition, 1);

//Photo display content
$varPhotoCont	= '';

$varPhotoPath	= $confValues['PHOTOURL'].'/'.$sessMatriId{3}.'/'.$sessMatriId{4}.'/';
$varPhotoCrop75	= $confValues['PHOTOIMGURL'].'/crop75/';

$varValidatedPh	= 0;
for($i=1; $i<=10; $i++){
	$varField1	= 'Normal_Photo'.$i;
	$varField2	= 'Photo_Status'.$i;
	if($varPhotoRes[0][$varField1]!='' && $varPhotoRes[0][$varField2]==1){
	$varValidatedPh++;
	$varNoOfPhotos++;
	$varPhoto		= $varPhotoPath.$varPhotoRes[0][$varField1];
	$varPhotoCont  .= '<div style="width: 60px;" class="fleft" id="div'.$i.'"><div><img height="50" width="50" style="border: 1px solid rgb(211, 211, 211);" src="'.$varPhoto.'"></div><div style="text-align: center; padding-right: 3px;" class="smalltxt"><a class="clr1 pntr" onclick="phodelete('.$i.');" href="javascript:;">Delete</a></div>';
	$varPhotoCont  .= ($varValidatedPh>1)?'<div style="text-align: center;" class="errortxt"><a href="javascript:;" onclick="funPhotoSwap('.$i.');" class="clr1 pntr">Make default</a></div>' : '';
	$varPhotoCont  .='</div>';
	$varPhotoCont  .= ($varNoOfPhotos == 5) ? '<br clear="all"><br clear="all">' : '';
	}else if($varPhotoRes[0][$varField1]!='' && ($varPhotoRes[0][$varField2]==0 || $varPhotoRes[0][$varField2]==2)){
	$varNoOfPhotos++;
	$varPhoto		= $varPhotoCrop75.$varPhotoRes[0][$varField1];
	$varPhotoCont  .= '<div style="width: 60px;" class="fleft" id="div'.$i.'"><div><img height="50" width="50" style="border: 1px solid rgb(211, 211, 211);" src="'.$varPhoto.'"></div><div style="text-align: center; padding-right: 3px;" class="smalltxt"><a href="javascript:;" onclick="phodelete('.$i.');"  class="clr1 pntr">Delete</a></div><div style="text-align: center;" class="errortxt">Pending<br> Validation</div></div>';
	$varPhotoCont  .= ($varNoOfPhotos == 5) ? '<br clear="all"><br clear="all">' : '';
	}/*else if($varPhotoRes[0][$varField1]==''){
	$varPhotoCont  .= '<div style="width: 60px;" class="fleft" id="div'.$i.'"><div class="fleft"><div style="display: block;"><div class="useracticonsimgs '.$varCSSImg.'"><div class="phototalign"></div></div></div></div></div>';
	}*/
}

$varIcon	= ($sessGender==1) ? 'm' : 'f';
$varPhotoCont  .= ($varNoOfPhotos<10)?'<div style="width: 60px;" class="fleft" id="div'.($varNoOfPhotos+1).'"><img height="50" width="50" style="border: 1px solid rgb(211, 211, 211);" src="'.$confValues['IMGSURL'].'/noimg50_'.$varIcon.'.gif"></div>':'';

$varPhotoCont  .= '<br clear="all"><br clear="all">';

}

$varTitle		= ($varAllPhFlag==1)? 'Manage' : 'Add';
?>
	<div class="rpanel fleft">
		<? include_once('../profiledetail/settingsheader.php');?>
		<center>
			<div class="padt10">
			<div style="width:500px;">
				<form method="post" name="addphoto" enctype="multipart/form-data" onSubmit="return validateFile();" style="padding:0px;margin:0px;">
				<div class="fleft padt10 smalltxt lh20 tlleft"><font class="normtxt">Did you know that profiles with photos get 20 times more response?</font><br>
				Add upto 10 photos and see the difference.						
				</div><br clear="all"/>
				<div class="fleft padt10 smalltxt">
						<?=$varPhotoCont;?>
				</div><br clear="all"/>
				<div id="confirm" class="disnon">
					<div class="brdr pad10 alerttxt">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="hidediv('confirm');"> </div><br clear="all">
					Are you sure you want to delete this photo?<br clear="all"><br clear="all">
					<div class="fright padb10">
					<input type="hidden" name="curphotono" value="">
					<input type="button" class="button" onClick="afterDelconfirm();" value="Yes">
					<input type="button" class="button" value="No" onclick="hidediv('confirm');"></div><br clear="all">
					</div>
				</div>
				<div id="cmsggout" class="disnon">
					<div class="brdr pad10 alerttxt">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="reloadPage();"> </div><br clear="all">
					<div class="tlcenter padb10" id="confirmmsg"></div><br clear="all">
					</div>
				</div> <br clear="all">
				<div class="fleft padt5">
				<?if($varPhotoRes[0]['Normal_Photo10']=='') {?>
				<div class="smalltxt fleft tlleft" style="width:100px;">Add more pictures</div>
				<div class="fleft tlleft">					
					<input type="file" accept="image/gif, image/jpeg" name="newphoto" style="width: 250px;" id="newphoto"/> <input type="submit" class="button" value="Upload Photo"/><br/><span id="errdiv" class="errortxt"></span>
					<input name="frmAddPhotoSubmit" id="frmAddPhotoSubmit" type="hidden" value="yes">
					<input name="action" id="action" type="hidden" value="">
					<input name="photono" id="photono" type="hidden">
					<input name="act" id="act" type="hidden" value="photoadd">
					<input type="hidden" value="add" id="actionval" name="actionval"/>
				</div><br clear="all">
				
				<div class="padt10 opttxt lh11 tlleft">
					Note that you can add up to 10 photos to your profile. <? if($sessPaidStatus == 0) { ?>As a free member, you can view only 1 photo posted by members. To view all the photographs the members have posted, you must become a premium member. <a class="clr1" href="<?=$confValues['SERVERURL']?>/payment">Click here to PAY NOW.</a><? } ?>
				</div>
				<? } else {?>
				<div class="padt10 opttxt lh11 tlleft">
					You're allowed to upload a maximum of 10 photos only. If you want to add more photos, please delete any existing photo and add a new photo in place of it.
				</div>
				<? } ?>
				
				</form>
				</div><br clear="all"/>
				<?if($varPhotoRes[0]['Normal_Photo10']=='') {?>
				<br>
				<div class="obrdr obg tlleft smalltxt lh13" style="padding:15px;">
				<font class="normtxt bld">Other ways to add your photo</font><br><br>
				<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/emailicon.gif" align="left" /></div><div class="fleft" style="padding-top:4px;">&nbsp;<b>E-mail your photos to</b> <a href="mailto:photo@<?=$varDomainPart2?>.com" class="clr1 bld">photo@<?=$varDomainPart2?>.com</a></div><br clear="all">
				<font class="opttxt" style="color:#000;">If your photo is not in GIF/JPG format or if the image size is more than 2MB, e-mail your photos to us and we will upload it absolutely FREE!</font><br><br>
				
				<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/photoicon.gif" align="left" /></div><div class="fleft" style="padding-top:4px;">&nbsp;<b>Send your photos through post</b></div><br clear="all">
				<font class="opttxt" style="color:#000;">Kindly mention your matrimony ID at the back of the photo and send them by post to any of our offices across the world. We will upload your photo absolutely FREE. If you want your photos back, enclose a self-addressed envelope with prepaid postage.</font></div>
				<? } ?>
			
			<? if($sessPaidStatus == 1 && $varNoOfPhotos>0){ ?>
				<br>
				<div style="padding: 10px 0px 0px;display:<?=$varcontentdiv1?>" id="contentdiv1" class="tlleft"><font class="smalltxt">If you do not want to show your photos to all members, you can protect it with a password. <br> Only members with whom you share your password can view your photos.</div>
				<br>
				<div id="addpass" style="display:<?=$varaddpassDIV?>;float:left;" class="brdr pad10">
					<form name="frmPhotoProtect">
					<div style="float: left; width: 455px;">
						<div class="smalltxt" style="float: left;">Enter Photo Password </div>
						<div class="smalltxt" style="float: left; padding-left: 30px;">Confirm Photo Password</div>
						<br clear="all">
						<div style="float: left;"><input name="pass" maxlength="8" size="20" class="inputtext" type="password"></div>
						<div style="float: left; padding-left: 5px;"><input name="repass" maxlength="8" size="20" class="inputtext" type="password"></div>
						<div style="float:left; padding-left:5px;padding-bottom:10px;"><input value="Protect" class="button" onclick="validate(this.form, 'result');" type="button"></div>						
					</div>
					</form>
					<span class="errortxt fleft tlleft" id="result"></span>
				</div>
				<div id="unprotectpass" class="brdr" style="padding:15px 0px 0px 18px;display:<?=$varunprotectpassDIV;?>;float:left;">
					<form name="frmRemoveProtect">
					<div style="float: left; width: 455px;">
						<div class="normtxt bld tlleft">Protect photo</div>
						<div class="smalltxt fleft">Your photo has been protected. You can unprotect it any time.</div><br clear="all">
						<div style="padding: 10px 10px 10px 0px;" class="fright"><input id="opt" value="remove" type="hidden"><input value="Unprotect" class="button" onclick="funRemovePwd();" type="button">&nbsp;&nbsp;<input type="button" onclick="load_changediv();" class="button" value="Change Password"></div>
					</div>
					</form>
				</div>
				<div id="changepwd" class="brdr" style="padding:15px 0px 0px 18px;float:left;display:none;">
					<form name="frmChgPhotoProtect">
					<div style="float: left; width: 455px;" class="tlleft">
						<div class="smalltxt bld">Protect photo with password</div>
						<div class="smalltxt">Only members to whom you give the photo password can access your photo.</div><br clear="all">
						
						<div class="smalltxt bld">Change Password</div>
						<div class="smalltxt" style="padding-top: 1px; float: left;">Enter Photo Password</div>
						<div class="smalltxt" style="float: left; padding-left: 25px; padding-top: 1px;">Confirm Photo Password</div>
						<br clear="all">
						<div class="fleft"><input name="pass" value="" maxlength="8" size="20" class="inputtext" type="password"></div>
						<div class="fleft" style="padding: 0px 0px 0px 5px;"><input name="repass" maxlength="8" value="" size="20" class="inputtext" type="password"></div>
						<div class="fleft" style="padding-left: 5px;padding-bottom:10px;"><input id="opt" value="add" type="hidden"><input onclick="validate(this.form, 'chgresult');" value="Protect" class="button" type="button"></div>
					</div>
					</form>
					<span class="errortxt tlleft fleft" id="chgresult"></span>
				</div><br clear="all">
				<div class="fleft tlleft opttxt">
					Note : Your photo password must be different from your profile and horoscope password.
				</div><br clear="all"><br clear="all">
			</div>
			<?}?>
		</div>
		</center>
	</div><br clear="all">