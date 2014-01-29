<?php
#=====================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-01
# Project	  : MatrimonyProduct
# Filename	  : fullprofile.php
#=====================================================================================================================
# Description : display other member profile view and print profile.
#=====================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/privilege.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath.'/conf/tblfields.cil14');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];

//REQUEST VARIABLES
$varCurrPgNo		= 0;
$arrPhotoDetail		= array();

//OBJECT DECLARATION
$objProfileDetail		= new MemcacheDB;
$objProfileDetailMaster	= new MemcacheDB;
$objProfileOtherDtl		= new ProfileDetail;
$objDomain				= new domainInfo;

$objProfileDetail-> dbConnect('S',$varDbInfo['DATABASE']);
$objProfileDetailMaster-> dbConnect('M',$varDbInfo['DATABASE']);


function givePhotoHoroName($arrTotPhotoDetail,$varMatriId) {
	$arrPhotoHoroName	= array();
	if(sizeof($arrTotPhotoDetail)>0) {
		$arrPhotoDetail		= explode('~',$arrTotPhotoDetail);
		$arrThumbPhotoName	= explode('^',$arrPhotoDetail[0]);//Thumb small Photo
		$arrPhotoStatus		= explode('^',$arrPhotoDetail[1]);//Photo Status
		$arrNormalPhotoName	= explode('^',$arrPhotoDetail[2]);//Normal Photo
		$varHoroscopeURL	= $arrPhotoDetail[3];//Horoscope
		
		if(sizeof($arrThumbPhotoName)>0) {
			$varSinglePhoto	= $arrThumbPhotoName[0];
		} else {
			$varSinglePhoto	= '';
		}

		$arrPhotoHoroName[]	= $varSinglePhoto;
		$arrPhotoHoroName[]	= $varHoroscopeURL;
	}

	return $arrPhotoHoroName;
}

$varMatriId 			= ($_REQUEST['id']!='')?strtoupper(trim($_REQUEST['id'])):$sessMatriId;
$varCondition			= " WHERE MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND ".$varWhereClause;
$varCheckProfileId		= $objProfileDetail->numOfRecords($varTable['MEMBERINFO'],'MatriId',$varCondition);



if($sessMatriId!='') {
	if($varCheckProfileId==0) {
		$varCondition		= " WHERE User_Name=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND ".$varWhereClause;
		$varFields			= array('MatriId');
		$varSelProfileId	= $objProfileDetail->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);
		$varMatriId			=  $varSelProfileId[0]['MatriId'];
		$varMatriId != ''?$varCheckProfileId=1:$varCheckProfileId=0;
	}

	//SETING MEMCACHE KEY
	$varOwnProfileMCKey		= 'ProfileInfo_'.$sessMatriId;
	$varOppositeProfileMCKey= 'ProfileInfo_'.$varMatriId;
	
	if($varCheckProfileId > 0 ) {
		
		$varCurrentDate		= date('Y-m-d H:i:s');

		include_once('profiledetail.php');
		
		//INSERT RECORD INTO memberprofileviewedinfo
		if ($sessMatriId !='' && $sessGender!=$varMemberInfo['Gender']) {
			$varViewedFields		= array('MatriId','Opposite_MatriId','Date_Viewed');
			$varViewFieldsVal		= array($objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail),$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail),"'".$varCurrentDate."'");
			$objProfileDetailMaster	-> insert($varTable['MEMBERPROFILEVIEWEDINFO'], $varViewedFields, $varViewFieldsVal);
		}
	
		#GETTING LOGIN INFORMATION FOR SELECTED PROFILEh
		$argFields				= array('ml.MatriId','ml.User_Name','ml.Email','mi.Paid_Status','mi.Valid_Days','mi.Last_Payment');
		$argTables				= $varTable['MEMBERLOGININFO']." as ml,".$varTable['MEMBERINFO']." as mi";
		$argCondition			= "WHERE ml.MatriId = mi.MatriId AND ml.MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail)." AND mi.MatriId=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
		$varLoginInfoResultSet	= $objProfileDetail->select($argTables,$argFields,$argCondition,0);
		$varLoginInfo			= mysql_fetch_assoc($varLoginInfoResultSet);

		$varUserName			= $varLoginInfo['User_Name'];
		$varPaidDate			= $varLoginInfo['Last_Payment'];
		$varValidDays			= $varLoginInfo['Valid_Days'];

		//GETTING BOOKMARKED,IGNORED,BLOCKED INFORMATION FOR THE SELECTED PROFILE
		$varBookMarkClass		= "disnon";
		$varBarDivClass			= "disnon";
		$varBlockedClass		= "disnon";
		$varContactIconStatus	= 0;

		//MEMBERACTION INFO TABLE, split & included this code for search & view profile displaying purpose...
		include_once($varRootBasePath.'/www/profiledetail/memberactioninfo.php');
		
		//Checking Values For Profile
		if ((($sessMatriId != $varMatriId) ||$sessMatriId == "")) {
			if($varPublish == 0) {
				$varFilterMessage = "Sorry, this member's profile does not exist. ";
			} else if($varPublish == 2) {
				$varFilterMessage = "MatriId <b>".$varMatriId."</b> is hidden and cannot be viewed by others.";
			} else if($varPublish == 3) {
				$varFilterMessage = "Sorry, this member's profile has been suspended. ";
			} else if($varPublish == 4) {
				$varFilterMessage = "Sorry, this member's profile does not exist. ";
			} else if($sessGender == $varMemberInfo['Gender']) {
				$varFilterMessage = "Sorry! You cannot view profiles of your gender.";
			}
		}

		if($varFilterMessage=='') {
			$varAlertMsg='';
			//getting Photo Part
			if($varMatriId == $sessMatriId) {
				$arrPhotoDetail		= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
				$arrPhotoHoroDetail	= givePhotoHoroName($arrPhotoDetail,$varMatriId);
				if($arrPhotoHoroDetail[0]!= '') {
					if($varPhotoStatus == 1) {
						$varPhotoPath	= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
						$varSinglePhoto	= $varPhotoPath."/".$arrPhotoHoroDetail[0];
					} else {
						$varSinglePhoto = $confValues['PHOTOURL']."/crop150/".$arrPhotoHoroDetail[0];
						$varAlertMsg	= "Under validation";
					}
					$varOnClick			= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					$varPhotoDispalyPart = '<a onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} else {
					$varReqImg		=($varGenderCode==1)?"img150_phnotadd_m.gif":"img150_phnotadd_f.gif";
					$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
					$varPhotoDispalyPart = '<img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" />';
				} 
			} else {
				if($varPhotoStatus == 1 && $varProtectPhotoStatus==1) {
					$varPhotoType	= ($varGenderCode==1)?"img150_pro_m.gif":"img150_pro_f.gif";
					$varSinglePhoto	= $confValues['IMGSURL']."/".$varPhotoType;
					$varOnClick   = "window.open('".$confValues['SERVERURL']."/photo/photoviewpassword.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					
					$varPhotoDispalyPart = '<a title="View photo" alt="View photo" onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} else if($varPhotoStatus == 1) {
					$arrPhotoDetail		= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
					$arrPhotoHoroDetail	= givePhotoHoroName($arrPhotoDetail,$varMatriId);
					$varPhotoPath	= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
					$varSinglePhoto	= $varPhotoPath."/".$arrPhotoHoroDetail[0];
					$varOnClick			= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					$varPhotoDispalyPart = '<a title="View photo" alt="View photo" onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} else {
					$varReqImg		=($varGenderCode==1)?"img150_phnotadd_m.gif":"img150_phnotadd_f.gif";
					$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
					$varOnClick		= 'show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'1\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';
					$varPhotoDispalyPart = '<a alt="Request Photo" title="Request Photo" onclick="'.$varOnClick.'"><img src="'.$varSinglePhoto.'" width="150" height="150" border="0" alt="" /></a>';
				} 
			}

			//getting Horoscope Part
			//check Horoscope feature available or not
			$varHoroFeature		= $objDomain->useHoroscope();
			if($varHoroFeature == 1) {
				if($varMatriId == $sessMatriId && ($varSameUser==1 || $varUploadMsg!='' || $varHoroAvailable==1 || $varHoroAvailable==3)) {
						$varHoroOnClick = $confValues['IMAGEURL'].'/horoscope/viewhoroscope.php?ID='.$varMatriId;
						$varHoroImg	= ($varHoroAvailable==3 || $varSameUser==1)?'genhoros.gif':'horoscope.gif';
						
						$varHoroOnLink ='window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');';
						$varHoroIconPart	= '<a href="#" onClick="window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varHoroImg.'"></a>';
				} else {
					if($varHoroAvailable==1 || $varHoroAvailable==3) {
						$varHoroImg	= ($varHoroAvailable==3)?'genhoros.gif':'horoscope.gif';
						if($sessPaidStatus==1) {
							$varHoroOnClick = $confValues['IMAGEURL'].'/horoscope/viewhoroscope.php?ID='.$varMatriId;
							$varHoroOnLink = 'window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');';
							$varHoroIconPart	= '<a alt="Horoscope" title="Horoscope" href="#" onClick="window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varHoroImg.'"></a>';
						} else {
							$varHoroOnClick ='show_box(event,\'div_box'.$varCurrPgNo.'\');displayAlert(\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',\'5\');';
							$varHoroOnLink ='show_box(event,\'div_box'.$varCurrPgNo.'\');displayAlert(\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',\'5\');';
							$varHoroIconPart	= '<a href="#" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');displayAlert(\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',\'5\');"><img border="0" src="'.$confValues['IMGSURL'].'/'.$varHoroImg.'"></a>';
						}
					} else {
						$varHoroOnClick ='show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'5\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';
						$varHoroOnLink ='show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'5\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';
						$varHoroscopePart	= '<div class="fleft pad3"><a alt="Request Horoscope" title="Request Horoscope" class="clr1 normtxt" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'5\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);">Horoscope</a></div>';
					}
				}
			}


			//getting Phono No Part
			if($varMatriId != $sessMatriId) {
				if($varPhoneVerified==0 || $varPhoneVerified==2) {
					$varPhonePart	= '<div class="fleft pad3"><a alt="Request Phone" title="Request Phone" class="clr1 normtxt" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');sendRequest(\''.$varMatriId.'\',\'3\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);">Phone Number</a></div>';
				} else if($varPhoneVerified==1 || $varPhoneVerified==3) {
					if($sessPaidStatus==1) {
						$varPhoneIconPart	= '<a alt="Phone" title="Phone" href="#phpart"><img border="0" src="'.$confValues['IMGSURL'].'/reqphone.gif"/></a>';
					} else {
						$varPhoneIconPart	= '<a alt="Phone" title="Phone" onClick="show_box(event,\'div_box'.$varCurrPgNo.'\');displayAlert(\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',\'3\');"><img border="0" src="'.$confValues['IMGSURL'].'/reqphone.gif"/></a>';
					}
				}
			} else if($varMatriId == $sessMatriId) {
				$varPhoneIconPart	= '<a alt="Phone" title="Phone" href="#phpart"><img border="0" src="'.$confValues['IMGSURL'].'/reqphone.gif"/></a>';
			}
			?>
			<?php
			
			if($_REQUEST['htype']==1 || $_REQUEST['htype']==2){
				$htype=$_REQUEST['htype'];
			}else{
				$horocomparray=array(19,31,47,48);
				if(in_array($varGetCookieInfo['MOTHERTONGUE'],$horocomparray)){
					$htype=2;
				}else{
					$htype=1;
				}
			}
			?>

			<script language="javascript">var cook_id	  = '<?=$sessMatriId?>',cook_un	  = '<?=$sessUsername?>', cook_paid = '<?=$sessPaidStatus?>', cook_gender = '<?=$sessGender?>', imgs_url= '<?=$confValues["IMGSURL"]?>', img_url	= '<?=$confValues["IMGURL"]?>', pho_url = '<?=$confValues["PHOTOURL"]?>', ser_url	= '<?=$confValues["SERVERURL"]?>', VPRefresh=true,curroppid='<?=$_REQUEST['id']?>';</script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/ajax.js" ></script>
				<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js"></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/cookie.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
				<script language="javascript" src="<?=$confValues['JSPATH']?>/opacity.js" ></script>
				<script language="javascript">
				
function showdivs(divid,link,pref)
{
	var i;
	var divid1,link1;
	var cl="",cl1="";
	for(i=1;i<=18;i++)
	{
		if(pref=="sc"){divid1="cdv"+i;link1="clk"+i;cl="clr5";cl1="clr1";}
		else if(pref=="sa"){divid1="dv"+i;link1="lk"+i;cl="smalltxt clr1 bld";cl1="smalltxt clr1";}
		if(link==link1){document.getElementById(divid1).style.display="block";document.getElementById(link1).className=cl;}
		else {
				if(document.getElementById(divid1))
					{document.getElementById(divid1).style.display="none";}
				if(document.getElementById(link1))
					{document.getElementById(link1).className=cl1;}
		     }
	}

	if(document.getElementById('corpdiv')){hidediv('corpdiv');imgdisp('plus');}

	if(pref=='sa')
	{document.getElementById('tfree').innerHTML="Toll Free No. 1-800-3000-2222.";}
	else {document.getElementById('tfree').innerHTML="+91-44-39115022.";}

}

function imgdisp(iname)
{
	if(iname=='plus')
		{document.getElementById('iconp').style.display='block';
		 document.getElementById('iconm').style.display='none';
	    }
	else {document.getElementById('iconm').style.display='block';
		  document.getElementById('iconp').style.display='none';
		}
}

function sel()
	{
	//document.getElementById('lightpic').style.display='block';
	//document.getElementById('fade').style.display='block';
	
	$('div_box0').style.visibility='visible';
	document.getElementById('div_box0').style.display='block';
	document.getElementById('fade').style.display='block';
	ll();floatdiv('div_box0',lpos,100).floatIt();
	}
function selclose()
	{
	//document.getElementById('lightpic').style.display='none';
	document.getElementById('fade').style.display='none';
	document.getElementById('div_box0').style.display='none';
	//if($('div_box0') && $('div_box0').style.visibility=='visible')
	//	document.getElementById('div_box0').style.visibility='hidden';
	}
</script>
                <div class="rpanel fleft normtxt">
							<?=$varContactIconPart?>
                            <div style="width:558px;float:left;">
                                <div class="bld clr fleft" style="font-size:15px;font-weight:bold;">
  								<? echo ($checkcrawlingbotsexists == false)? $varDisplayName.' ('.$varMatriId.')':$varMatriId;?>
  								<div id="horomatchdiv-<?=$varCurrPgNo?>" style="font-weight:normal;"></div>
  								</div><br clear="all">
																
								<div align="left" class="smalltxt clr2 fleft padt5">
								<?if($varPaid_status==1) {?>
								<div class="fleft"><img src="<?=$confValues['IMGURL']?>/images/premium.gif" /></div><div class="fleft">-&nbsp;</div>
								<?}?>
                                <div class="fleft">Active: <?=$varLastLogin;?></div>
								</div>
								
                                <div class="fright"><div id="favdiv" class="<?=$varBookMarkClass?> fleft"><a title="Add to favourites"  alt="Add to favourites" class="clr1 smalltxt" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd1('shortlist','<?=$varMatriId?>','favdiv','div_box<?=$varCurrPgNo?>','msgactpart<?=$varCurrPgNo?>','<?=$varCurrPgNo?>');">Add to favourites</a>&nbsp; |&nbsp;</div>

											<? if ($varPartialFlag =='0') { ?>

											<!-- <div id="bardiv" class="<?=$varBarDivClass?> fleft">|</div> -->
											<div id="blockdiv" class="<?=$varBlockedClass?> fleft"><a title="Block Member" alt="Block Member" class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd1('block','<?=$varMatriId?>','blockdiv','div_box<?=$varCurrPgNo?>','msgactpart<?=$varCurrPgNo?>','<?=$varCurrPgNo?>');"><font style="font-size:11px;padding-left:2px;">Block Member</font></a>&nbsp; |&nbsp;</div><div class="fleft" style="padding-top:3px;"><a alt="Print" title="Print" class="clr1 smalltxt" href="<?=$confValues['SERVERURL']?>/profiledetail/fullprofile.php?id=<?=$varMatriId?>" target="_blank">Print</a></div>
											</div>
                            </div>

                                <div style="width:558px;margin-top:1px;height:210px !important;height:210px;" class="bgclr2 fleft">
                                <div class="bgclr5 mymgnt10 mymgnl10 fleft" style="width:157px;height:180px !important;height:190px;padding-top:8px;padding-left:8px;display:inline">
                                    <div id="nfvpdiv2" class="fleft">
    								<div><?=$varPhotoDispalyPart?></div>
    								<div align="center" class="smalltxt"><?=$varAlertMsg?></div>

									<?if($varPhotoStatus == 1 && $varProtectPhotoStatus!=1) {?>
									<div align="center" style="padding-top:5px;"><a title="View photo" alt="View photo" onclick="<?=$varOnClick;?>" class="clr1">View Album</a></div>
									<?} else {
										if($sessMatriId != $varMatriId && $varProtectPhotoStatus!=1 && $varPhotoStatus != 1) {?>
									<div align="center" style="padding-top:5px;"><a title="Request photo" alt="Request photo" onclick="<?=$varOnClick;?>" class="clr1">Request photo</a></div>
									<? } else if($sessMatriId == $varMatriId ){
										$varAddOnClick = $confValues['IMAGEURL']."/photo/index.php?act=addphoto";
											?>
										<div align="center" style="padding-top:0px;"><a title="Add photos" alt="Add photos" href="<?=$varAddOnClick;?>" class="clr1">Add photos</a></div>
									<?} }?>
                                </div>
                                </div>
                                <div class="fleft" style="width:375px;float:left;">
                                <div style="height:128px !important;height:128px;" class="fleft">
                                <div id="nfvpdiv4" class="normtxt clr" style="padding-left:10px;margin-top:18px;width:355px;"><?if($varAge != '0'){ echo $varAge.' yrs';}if($varMemberInfo['Height'] != '0.00'){ echo ', '.$varHeight;}?> <?if($varRelSubcaste!=''){ echo '<font class="clr2">|</font> '.$varRelSubcaste; }?>  <font class="clr2">|</font> <?if($varStar!=0){ echo $varStar.','; }?> <?if($varResidingCity != ''){ echo $varResidingCity.', ';} if($varResidingState != '0'){ echo $varResidingState.', ';} if($varCountryname != ''){ echo $varCountryname;}?> <font class="clr2">|</font> <?if($varEducation != ''){ echo $varEducation;}?>  <?if($Occupation!=''){echo '<font class="clr2">|</font> '.$Occupation;}?> </div>

                                <? if($varPhoneIconPart!='' || $varHoroIconPart!='' || ($varLastLogin=='NOW' && $sessMatriId != $varMatriId) ) {  ?>
								   <div style="height: 22px;padding-left:10px;margin-top:10px;"><div class="fleft lcdiv"></div><div class="bgcdiv fleft smalltxt bld">
								   <div class="fleft" style="padding-top: 3px;">
								   <?=$varPhoneIconPart?>
								   <?=$varHoroIconPart?>
								   </div>
                                  <!-- Online Chat starts here -->
                                  <div class="fleft">
								  <?
								   if ($varPartialFlag=='0') {
									  if ($varLastLogin=='NOW' && $sessMatriId != $varMatriId ) {
									      if($varPhoneIconPart!='' || $varHoroIconPart!='') { ?>
											|
											<? }
											if($sessPaidStatus == '1') { $varChat = "href=\"javascript:;\" onClick=\"launchIC('$sessMatriId','$varMatriId');\""; }
											else { $varChat = ' href="'.$confValues['SERVERURL'].'/payment/" target="_blank"'; } ?><a <?=$varChat?> class="pntr"><font class="clr4">Online</font> - <font class="clr1">Chat Now!</font></a>
                                   <? } } ?>
                                   </div>

								  <!-- Online Chat ends here -->
  								 </div>
                                 <div class="fleft rcdiv"></div>
								 </div>
								 <?}?>

                                   <? if($sessMatriId !=$varMatriId) {

                                        //if(($varHoroAvailable==1 || $varHoroAvailable==3) && $sessPaidStatus==0) {
											?>
										<!-- <div class="fleft">
											<div class="fleft pad3" style="padding-left:10px;">Horoscope :</div>
												<div class="fleft pad3"> <a class="clr1 bld" href="/payment/index.php">Pay NOW</a> to view horoscope.</div>
										</div> -->
										<? //} ?>

                                    <?
										if($varContactIconStatus==1) {
											$varOnClick1	='show_box(event,\'div_box'.$varCurrPgNo.'\');showContactHistory(\''.$sessMatriId.'\',\''.$varMatriId.'\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';

											echo $varContactIconPart = '<div style="padding-top: 15px;" class="vpdiv3 fleft"><font class="normtxt clr" style="padding-left:12px;"><a alt="Last Activity" title="Last Activity" class="clr1" onclick="'.$varOnClick1.'">Last Activity</a> :</font><font class="smalltxt clr"> '.$funCMsg.': '.date('d-M-y', strtotime($funCDate)).'</font></div>';
										} ?>

									<? } ?>
                                     </div>

                                     <div style="width:375px;padding-left:13px;float:left;height:22px;">
                                     <? if($sessMatriId !=$varMatriId) {?>
									  <div class="normtxt clr fleft">
										<? if(($varHoroAvailable==0 && $varHoroFeature==1) || ($varPhoneVerified==0)) { 
												echo "<div class='fleft bld' style='padding-top:3px;'>Request :</div>";
												if($varHoroAvailable==0) {
													echo $varHoroscopePart;
												}
												if(($varHoroAvailable==0 && $varHoroFeature==1) && $varPhoneVerified==0){
													echo "<div class='fleft' style='padding-top:3px;'>&nbsp;|&nbsp;</div>";
												}
												echo $varPhonePart;
											} ?>
									 </div>
									<? } ?>
                                    </div>

                                    <? if($sessMatriId !=$varMatriId) {
                                      ?>
                                    <div class="bgclr5" style="height:41px;margin-left:10px;margin-top:7px;width:365px;float:left;display:inline">
                                      <div class="mymgnt10 mymgnl10 bld normtxt" style="float:left;display:inline">Like this member? </div>
                                        <div class="fright" style="margin-top:10px;margin-right:10px;display:inline">
                                      	<?if($varContactIconStatus!=1) {?>
                                      	<input type="button" class="button" value="Send Message" onclick="sel();getOldCont();showOption('<?=$varCurrPgNo?>');" />
                                      	<?} else {?>
                                      		<input type="button" class="button" value="Send Message" onclick="sel();getOldCont();" />
                                      	<?}?>
                                      	</div>
                                      </div>
                                    <?}}?>
							   </div>
                                <!--<div style="width:500px;float:left;margin-top:10px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>-->
                                </div>

								<!--<div id="lightpic" class="frdispdiv" style="width: 560px;overflow:auto;">-->
								
								<div id="div_box0" class="frdispdiv vishid bgclr2 brdr1" style="width: 500px !important;width: 525px;overflow:auto;padding:10px;">
								
									<div id="msgactpart0" class="tlleft bgclr2">
										<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="selclose();" class="pntr"></div><br clear="all">
										<center>
										<?include('profileinboxview.php'); ?>
										</center>
										<div class="fleft" style="height:15px;width:150px;margin-top:10px;">&nbsp;</div>
									</div>
								</div>

                              <!--<div style="width:558px;float:left;height:10px;">&nbsp;</div>-->
                            </div>
                            <!--<div style="width:558px;float:left;height:5px;">&nbsp;</div>-->
							
							<!-- message action div starts-->
                            <!-- <div id="div_box<?=$varCurrPgNo?>" style="padding:10px;position:absolute;top:290px;" class="frdispdiv vishid posabs brdr1 bgclr2">
      							<div id="msgactpart<?=$varCurrPgNo?>" class="tlleft bgclr2"></div>
      						</div> -->

							<!-- message action div starts-->

							<!-- ashtakoota horoscope action div starts-->

							<div id="horid" class="posabs vishid">
								<div id="hormsgid" class="brdr tlleft" style="background-color:#EEEEEE;">
								<div class="rpanelinner padtb10">
									<div class="fright tlright" style="padding-right:10px;"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>)"/></div><br clear="all">
									<div id="horomatchcontentdiv-<?=$varCurrPgNo?>"></div>
								</div>
								</div>
							</div>
							<!-- horoscope action div starts-->
                            <!--<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>-->
                            <?
								if ($varPartialFlag =='0') {
								if($sessMatriId !='' && $sessGender!=$varMemberInfo['Gender'] && $sessMatriId !=$varMatriId && $sessPublish>=0 && $sessPublish<=2) { ?>

                            <!--<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>--><br clear="all"/>
							<? } } ?>
                            <div style="width:558px;float:left;margin-top:16px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
                            <div style="width:558px;float:left;">

                            <div class="fnt15 bld clr" name="about">About Member</div><br clear="all"/>
							<?if($varProfileCreatedBy!='') {?>
							<div id="procre" class="nfvpdiv5 padtb3 fleft padbt10">Profile created by</div>
                            <div class="fleft">:</div>
							<div id="par" class="padl fleft padbt10"><?=$varProfileCreatedBy?></div><br clear="all"/>
							<?}?>

							<div id="probas" class="nfvpdiv5 padtb3 fleft padbt10">Basic Information</div>
                             <div class="fleft">:</div>
							<div id="bas" class="nfvpdiv5a fleft padl padbt10"><?=$varBasicStr?></div><br clear="all"/>

							<div id="probel" class="nfvpdiv5 padtb3 fleft padbt10">Cultural Background</div>
                            <div class="fleft">:</div>
							<div id="bel" class="nfvpdiv5a fleft padl padbt10"><?=$varBeliefsStr?></div><br clear="all"/>

							<div id="procar" class="nfvpdiv5 padtb3 fleft padbt10">Career </div>
                            <div class="fleft">:</div>
							<div id="car" class="nfvpdiv5a fleft padl padbt10"><?=$varCareerStr_EduLong?></div><br clear="all"/>

							<div id="proloc" class="nfvpdiv5 padtb3 fleft padbt10">Location</div>
                            <div class="fleft">:</div>
							<div id="loc" class="nfvpdiv5a fleft padl padbt10"><?=$varLocationStr?></div><br clear="all"/>

							<div id="proabme" class="nfvpdiv5 padtb3 fleft padbt10">Few lines about me</div>
                            <div class="fleft">:</div>
							<div id="flines" class="nfvpdiv5a fleft padl padbt10" style="word-wrap: break-word;"><?=$varAboutmySelf?></div>
							<br clear="all"/>	<br clear="all"/>
                             </div>

                            <div style="width:558px;float:left;">

                            <div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
  							<div style="display:none;" id="cdv3"></div>
  							<div class="fnt15 bld clr" name="life">Lifestyle<a name="life"></a></div><br clear="all"/>
  							<?if($varHabitsStr=='' && $varInterestSetStatus==0) { echo "<div class='fleft' >Lifestyle information not provided.</div><br clear='all'/>";} else {?>
  							<?if($varHabitsStr!='') { ?>
  							<div class="nfvpdiv5 padtb3 fleft padbt10">Habits<a name="photo"></a> </div>
                              <div class="fleft">:</div>
  							<div class="nfvpdiv5a fleft padl padbt10"><?=$varHabitsStr?></div><br clear="all"/>
  							<? } if($varInterest!='') {?>
  							<div class="nfvpdiv5 padtb3 fleft padbt10">Interests </div>
                              <div class="fleft">:</div>
  							<div class="nfvpdiv5a fleft padl padbt10"><?=$varInterest?>...</div><br clear="all"/>
  							<? } if($varHobbies!='') {?>
  							<div class="nfvpdiv5 padtb3 fleft padbt10">Hobbies</div>
                              <div class="fleft">:</div>
  							<div class="nfvpdiv5a fleft padl padbt10"><?=$varHobbies?></div><br clear="all"/>
  							<? } if($varFavouriteStr!='') {?>
  							<div class="nfvpdiv5 padtb3 fleft padbt10">Favourites </div>
                              <div class="fleft">:</div>
  							<div class="nfvpdiv5a fleft padl padbt10"><?=$varFavouriteStr?>...</div><br clear="all"/>
  							<? }}?>

                             </div>


                            <div style="width:558px;float:left;">
                             <br clear="all">
							<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
                            <div class="fnt15 bld clr" name="family">Family <a name="family"></a></div><br clear="all"/>
                            <?if($varFamilySetStatus==0) { echo "<div class='fleft '>Family information not provided.
</div><br clear='all'/>";}               else {?>
							<? if($varFamilyValue!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Family value</div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varFamilyValue?></div><br clear="all"/>
							<? } if($varFamilyType!='' || $varFamilyStatus != '') {
								$commaSeparator = "";
								$varFamilyTypeAndStatus = "";
								if ($varFamilyType!='') {
									$varFamilyTypeAndStatus = $varFamilyType;
									$commaSeparator = ", ";
								}
								if ($varFamilyStatus != '') {
									$varFamilyTypeAndStatus .= $commaSeparator.$varFamilyStatus;
								}
							?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Family Type & Status</div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varFamilyTypeAndStatus?></div><br clear="all"/>
							<? } if($varFamilyOrigin!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Ancestral Origin </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varFamilyOrigin?></div><br clear="all"/>
							<? } if($varReligiousValues!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Religious values </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varReligiousValues?></div><br clear="all"/>
							<? } if($varEthnicity!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Ethnicity </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varEthnicity?></div><br clear="all"/>
							<? } if($varParenstOccStr!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Parents Occupation </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varParenstOccStr?></div><br clear="all"/>
							<? } if($varSiblingsStr!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Siblings </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=trim($varSiblingsStr,', ')?></div><br clear="all"/>
							<? } if($varAboutFamily!='') {?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Few lines about my family </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10" style="word-wrap: break-word;"><?=$varAboutFamily?></div><br clear="all"/>
							<? }} ?>
                             </div>

                             <div style="width:558px;float:left">
                                <br clear="all">
							<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							<div style="display:none;" id="cdv5"></div>
							<div class="fnt15 bld clr padbt10" name="partner">Partner Preference<a name="partner"></a></div>
                            <?if($varPartnerSetStatus==0) { echo "<div class='fleft'>Partner preference not provided.</div><br clear='all'/>";}
                             else {?>
							<div class="padtb5 ">I want to marry someone who meets most of my preferences which I have noted here.</div>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Basic partner preference </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padbt10 padl"><?=trim($varPartnerBasicStr,', ')?></div><br clear="all"/>

							<?if($varPartnerBeliefs!=''){?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Cultural Background </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varPartnerBeliefs?></div><br clear="all"/>
							<?}?>

							<div class="nfvpdiv5 padtb3 fleft padbt10">Career </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varPartnerCareerStr?></div><br clear="all"/>

							<div class="nfvpdiv5 padtb3 fleft padbt10">Location </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=$varPartnerLocStr?></div><br clear="all"/>

							<?if($varPartnerHabits!='') { ?>
							<div class="nfvpdiv5 padtb3 fleft padbt10">Lifestyle </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a fleft padl padbt10"><?=trim($varPartnerHabits,', ');?></div><br clear="all"/>
							<? } ?>

							<?if($varPartnerDescription!='') { ?>
							<div class="nfvpdiv5 padtb3 fleft ">Few lines about my partner </div>
                            <div class="fleft">:</div>
							<div class="nfvpdiv5a  fleft padl" style="word-wrap: break-word;"><?=$varPartnerDescription?></div><br clear="all"/>
							<? }} ?><br clear="all">
                             </div>
                              <div style="width:558px;float:left;">

                                <? if($varPhoneVerified!=0 && $varPhoneVerified!=2 || $sessMatriId == $varMatriId) {?>
							<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
							<a name="phpart"></a>
							<div style="display:none;" id="cdv6"></div>
							<div class="fnt15 bld clr  padb10">Phone No.</div>
							<?}?>
                            <?if(($varPhoneVerified==1 || $varPhoneVerified==3) && $sessPaidStatus==0) { ?>
							<div id='<?=$varCurrPgNo?>vp8' class="fleft ">
								<div class="fleft" >
									<div class="fleft smalltxt" style="width:40px; padding-top:3px;">Phone :</div>
									<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/blurimg.gif" alt="" /></div><div class="fleft" style="padding-top:3px;"> &nbsp;&nbsp;<a class="clr1 bld smalltxt" href="/payment/index.php">Pay NOW</a> to view phone number.</div>
								</div><br clear="all">
                             </div>
							<? } ?>

                            <?if(($varMatriId == $sessMatriId) || (($varMatriId != $sessMatriId) && $sessPaidStatus==1 && ($varPhoneVerified==1 || $varPhoneVerified==3))) { ?>

								<div id='<?=$varCurrPgNo?>vp8' class="fleft">
								<?if($varMatriId == $sessMatriId) { ?>
									<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8','<?=$varCurrPgNo?>','fpn');">
								<?} else {
									if($varPhoneProtected==1){?>
									<div id="phmsg" class="disblk" style='padding-left:25px'>
									This member has protected the phone number. To view the phone number, contact this member by sending a personalised message.
									</div><br clear="all">
									<?} else { ?>
									<div id="phmsg" class="fleft smalltxt">
										Are you sure you want to view this member's phone number?<br clear="all"><br clear="all">
										<div class="fleft">
											<input type="button" onClick="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8','<?=$varCurrPgNo?>','fpn');" value="Yes" class="button">
											<input type="button" onClick="" value="No" class="button">
										</div><br clear="all">
									</div><br clear="all"><br clear="all"><br clear="all">
								<?}}?>
							</div><br clear="all"/>

							<? } ?>
                              </div>

                        <br clear="all"/><br clear="all"/><br clear="all"/><br clear="all"/>
						<div id="fade" class="bgfadediv"></div>

		<?}
	} else {
		$varFilterMessage = "Sorry, this member's profile does not exist.";
	}
} else {
	$varFilterMessage = "Sorry, registered member only can view full profile.";
}

if($varGetCookieInfo['HOROSCOPESTATUS']>1 && $varHoroAvailable>1){
?>
	<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="javascript:showhoromatch('horomatchdiv-<?=$varCurrPgNo?>','<?=$sessMatriId?>','<?=$varMatriId?>','<?=$htype?>','msgactpart<?=$varCurrPgNo?>');">
<?
}?>
<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="javascript:getOldCont();">
<!-- <script> getOldCont();</script> -->

<?
//UNSET OBJECTS
$objProfileDetail->dbClose();
unset($objProfileDetail);

if($varFilterMessage!='') {?>
    <div class="brdr tlcenter pad10" style="width:550px !important;width:568px;float:left;position:absolute">
		<?=$varFilterMessage?>
	</div>

<?}?>
