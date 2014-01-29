<?php
#=====================================================================================================================
# Author 	  : Jeyakumar N
# Date		  : 2008-09-01
# Project	  : MatrimonyProduct
# Filename	  : viewprofile.php
#=====================================================================================================================
# Description : display other member profile view and print profile. It includes Icon list, photo display, right icon list and profile                  description
#=====================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/cookieconfig.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/messagevars.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsProfileDetail.php');
include_once($varRootBasePath."/conf/privilege.cil14");
include_once($varRootBasePath.'/lib/clsBasicview.php');
include_once($varRootBasePath.'/www/mymessages/framebasicstrip.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];

//REQUEST VARIABLES
$varCurrPgNo		= $_REQUEST['cpno']?$_REQUEST['cpno']:0;
$varDefaultTab		= $_REQUEST['defaultTab'];

$varFPconfirm  = $_REQUEST['fpconfirm'];

//OBJECT DECLARATION
$objProfileDetail		= new MemcacheDB;
$objProfileDetailMaster	= new MemcacheDB;
$objProfileOtherDtl		= new ProfileDetail;
$objDomain				= new domainInfo;
$objBasicView	        = new BasicView();

$objProfileDetail-> dbConnect('S',$varDbInfo['DATABASE']);
$objProfileDetailMaster-> dbConnect('M',$varDbInfo['DATABASE']);

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
			$varViewFieldsVal		= array($objProfileDetailMaster->doEscapeString($sessMatriId,$objProfileDetailMaster),$objProfileDetailMaster->doEscapeString($varMatriId,$objProfileDetailMaster),"'".$varCurrentDate."'");
			$objProfileDetailMaster	-> insert($varTable['MEMBERPROFILEVIEWEDINFO'], $varViewedFields, $varViewFieldsVal);
		}

		#GETTING LOGIN INFORMATION FOR SELECTED PROFILE
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

		if ($sessMatriId !='') {
			if($sessGender!=$varMemberInfo['Gender']) {
				if ($varMatriId !="" && $sessMatriId !="") {
					$funBookmark	= 0;
					$funIgnored		= 0;
					$funBlocked		= 0;

					//check member action is available or not
					$argCondition	= "WHERE MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId =".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
					$varCheckAction	= $objProfileDetail->numOfRecords($varTable['MEMBERACTIONINFO'],'MatriId',$argCondition);

					if($varCheckAction > 0) {
						$argFields		= array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Ignored', 'Blocked','Interest_Received_Date', 'Interest_Sent_Date', 'Mail_Sent_Date', 'Mail_Received_Date', 'Receiver_Replied_Date', 'Receiver_Declined_Date',"IF(Interest_Received_Date>Interest_Sent_Date AND Interest_Received_Date>Mail_Received_Date AND Interest_Received_Date>Mail_Sent_Date AND Interest_Received=1 AND Interest_Received_Date>Receiver_Replied_Date AND Interest_Received_Date>Receiver_Declined_Date,Interest_Received_Status,'N') AS IntRec", "IF(Interest_Sent_Date>Interest_Received_Date AND Interest_Sent_Date>Mail_Received_Date AND Interest_Sent_Date>Mail_Sent_Date AND Interest_Sent=1 AND Interest_Sent_Date>Receiver_Replied_Date AND Interest_Sent_Date>Receiver_Declined_Date,Interest_Sent_Status,'N') AS IntSen", "IF(Mail_Sent_Date>Interest_Received_Date AND Mail_Sent_Date>Mail_Received_Date AND Mail_Sent_Date>Interest_Sent_Date AND Mail_Sent=1 AND Mail_Sent_Date>=Receiver_Replied_Date AND Mail_Sent_Date>Receiver_Declined_Date,Mail_Sent_Status,'N') AS MsgSen", "IF(Mail_Received_Date>Interest_Received_Date AND Mail_Received_Date>Mail_Sent_Date AND Mail_Received_Date>Interest_Sent_Date AND Mail_Received=1 AND Mail_Received_Date>Receiver_Replied_Date AND Mail_Received_Date>Receiver_Declined_Date,Mail_Received_Status,'N') AS MsgRec", "IF(Receiver_Replied_Date>Interest_Received_Date AND Receiver_Replied_Date>Mail_Sent_Date AND Receiver_Replied_Date>Interest_Sent_Date AND Receiver_Replied=1 AND Receiver_Replied_Date>Mail_Received_Date AND Receiver_Replied_Date>Receiver_Declined_Date,'Y','N') AS MsgRep", "IF(Receiver_Declined_Date>Interest_Received_Date AND Receiver_Declined_Date>Mail_Sent_Date AND Receiver_Declined_Date>Interest_Sent_Date AND Receiver_Declined=1 AND Receiver_Declined_Date>Mail_Received_Date AND Receiver_Declined_Date>Receiver_Replied_Date,'Y','N') AS MsgDec");
						$funIconResult	= $objProfileDetail->select($varTable['MEMBERACTIONINFO'],$argFields,$argCondition,0);

						while($row = mysql_fetch_array($funIconResult)) {
							$funBookmark	= $row['Bookmarked'];
							$funIgnored		= $row['Ignored'];
							$funBlocked		= $row['Blocked'];
							
							if ($row['IntRec'] != 'N') {
								$varContactIconStatus	= 1; //intreceived
								$varCIconImage			= ($row['IntRec']==0)?"unread":($row['IntRec']==1?"accept":"decline");
								$funCDate				= $row['Interest_Received_Date'];
								$funCMsg				= 'Interest received';
							} elseif ($row['IntSen'] != 'N') {
								$varContactIconStatus	= 1; //intsent
								$varCIconImage			= ($row['IntSen']==0)?"unread":($row['IntSen']==1?"accept":"decline");
								$funCDate				= $row['Interest_Sent_Date'];
								$funCMsg				= 'Interest sent';
							} elseif ($row['MsgRep'] == 'Y') {
								$varContactIconStatus	= 1; //msgaccept
								$varCIconImage			= 'reply';
								$funCDate				= $row['Receiver_Replied_Date'];
								$funCMsg				= 'Message replied';
							} elseif($row['MsgDec'] == 'Y') {
								$varContactIconStatus	= 1; //msgdecline
								$varCIconImage			= 'decline';
								$funCDate				= $row['Receiver_Declined_Date'];
								$funCMsg				= 'Message declined';
							} elseif ($row['MsgRec'] != 'N') {
								$varContactIconStatus	= 1; //sgrecd
								$varCIconImage			= ($row['MsgRec']==0)?"unread":"read";
								$funCDate				= $row['Mail_Received_Date'];
								$funCMsg				= 'Message received';
							} elseif ($row['MsgSen'] != 'N') {
								$varContactIconStatus	= 1; //msgsent
								$varCIconImage			=  ($row['MsgSen']==0)?"unread":($row['MsgSen']==1?"read":($row['MsgSen']==2?"reply":"decline"));
								$funCDate				= $row['Mail_Sent_Date'];
								$funCMsg				= 'Message sent';
							} else {
								$varContactIconStatus = 0;
								$varCIconImage = '';
							}
						}
					}
				}//if
				
				if($funBookmark==0 && $funBlocked==0) {
					$varBookMarkClass	= "disblk fleft pad3";
					$varBlockedClass	= "disblk fleft pad3";
					$varBarDivClass		= "disblk fleft pad3";
				} else {
					$varBarDivClass		= "disnon";
				}

				if ($funBookmark==1) {
					$varBookMarkClass	= "disnon";
				} else {
					$varBookMarkClass	= "disblk fleft pad3";
				}

				if ($funBlocked==1) { 
					$varBlockedClass	= "disnon";
				}else{
					$varBlockedClass	= "disblk fleft pad3";
				}
			}
		}//if

		if($varContactIconStatus==1) {
			$varOnClick			= 'show_box(event,\'div_box'.$varCurrPgNo.'\');showContactHistory(\''.$sessMatriId.'\',\''.$varMatriId.'\',\'msgactpart'.$varCurrPgNo.'\',\'div_box'.$varCurrPgNo.'\',1);';
			$varContactIconPart = '<div style="padding-bottom: 5px;" class="vpdiv3 fleft"><font class="smalltxt"><a class="clr1" onclick="'.$varOnClick.'">Last Activity: </a></font><a onclick="'.$varOnClick.'"></a><font class="smalltxt clr"> '.$funCMsg.': '.date('d-M-y', strtotime($funCDate)).'</font></div>';
		}
		

		//Checking Values For Profile
		if ((($sessMatriId != $varMatriId) ||$sessMatriId == "")) {
			if($varPublish == 0) {
				$varFilterMessage = "Sorry, this member's profile is currently under validation.";
			} else if($varPublish == 2) {
				$varFilterMessage = "MatriId <b>".$varMatriId."</b> is hidden and cannot be viewed by others.";
			} else if($varPublish == 3) {
				$varFilterMessage = "Sorry, this member's profile has been suspended.";
			} else if($varPublish == 4) {
				$varFilterMessage = "Sorry, this member's profile has been rejected.";
			} else if($sessGender == $varMemberInfo['Gender']) {
				$varFilterMessage = "Sorry! You cannot view profiles of your gender.";
			}
		}

		if($varFilterMessage=='') {
			
			//For getting total tab
			$varTotaltab	= 4;
			$varMissedTab	= '';
			$varPhtoTabAvail= 1;

			//check Horoscope feature available or not
			$VarHoroFeature	= $objDomain->useHoroscope();
			if($VarHoroFeature==1) {
				$varTotaltab++;
			} else {
				$varMissedTab.='4~';
				$varHoroscopeMsg='';
			}

			if($varHabitsStr!='' || $varInterestSetStatus==1) {$varTotaltab++;} else { $varMissedTab.='5~';}
			if($varFamilySetStatus==1){$varTotaltab++;} else { $varMissedTab.='6~';}
			if($varPartnerSetStatus==1){$varTotaltab++;} else { $varMissedTab.='7~';}
			$varMissedTab	= trim($varMissedTab,'~');

			if($varPhHoroCount>0) {
				//Photo Part Starts
				if($sessPaidStatus == 0) {
					$varPayNowImg	= ($varGenderCode==1)?"img50_pnow_m.gif":"img50_pnow_f.gif";
				}

				if($varPhotoStatus == 0 && $varPhoneHorosope['Normal_Photo1']!='') {
					$varReqImg			=($varGenderCode==1)?"img85_phundval_m.gif":"img85_phundval_f.gif";
					$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
					$varOnClick			= '';
					$varPhotoMsg		= '';

					if($varMatriId != $sessMatriId) { 
					$varPhtoTabAvail	= 0;
					$varTotaltab--;	//Photo tab is not coming in view profile. So decreased one value in total tab
					$varMissedTab		='3~'.$varMissedTab; //missed tab already trimmed. So I added ~ before missed tab value
					$varMissedTab		= trim($varMissedTab,'~');
					}
				} else if($varPhotoStatus == 0 && $varPhoneHorosope['Normal_Photo1']=='') {
					$varReqImg			=($varGenderCode==1)?"img85_phnotadd_m.gif":"img85_phnotadd_f.gif";
					$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
					$varPhotoMsg		= '<div class="normtxt">This member has not added photo. If you would like to view this member\'s photo, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'1\',\''.$varCurrPgNo.'vp3\');"></div></div>';
					$varOnClick		= "slidemtab('".$varCurrPgNo."','".$varCurrPgNo."vp3',".$varTotaltab.",'".$varMissedTab."');";
				} else {
					if($varMatriId == $sessMatriId) { 
						$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
						$varOnClick		= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
					} else if($varMatriId != $sessMatriId){ //FOR OTHER MEMBERS VIEWING MEMBERS PHOTO
						if($varPhotoStatus == 1 && $varProtectPhotoStatus==1) {
							$varReqImg		= "img85_pro.gif";
							$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
							$varOnClick		= "slidemtab('".$varCurrPgNo."','".$varCurrPgNo."vp3',".$varTotaltab.",'".$varMissedTab."');";
						} else if($varPhotoStatus == 1) {
							$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
							$varOnClick		= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
						}
					}
				}
				//Photo Parts Ends

				if($varHoroAvailable==0 && $varPhoneHorosope['HoroscopeURL']!='') {
					$varHoroscopeMsg	= '<div class="normtxt">'.$varMatriId.' horoscope is under validation. Please revisit this member\'s profile after a few hours<br clear="all"><br clear="all"></div>';
				} else if($varHoroAvailable==0 && $varPhoneHorosope['HoroscopeURL']=='') {
					$varHoroscopeMsg	= '<div class="normtxt">This member has not added horoscope. If you would like to view this member\'s horoscope, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'5\',\''.$varCurrPgNo.'vp4\');"></div></div>';
				}
			} else {
				$varReqImg			=($varGenderCode==1)?"img85_phnotadd_m.gif":"img85_phnotadd_f.gif";
				$varSinglePhoto		= $confValues['IMGSURL']."/".$varReqImg;
				$varPhotoMsg		= '<div class="normtxt">This member has not added photo. If you would like to view this member\'s photo, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'1\',\''.$varCurrPgNo.'vp3\');"></div></div>';

				$varHoroscopeMsg	= '<div class="normtxt">This member has not added horoscope. If you would like to view this member\'s horoscope, you can request member to add it.<br clear="all"><br clear="all"><div class="fright padr20"><input type="button" class="button" value="Request Now" onClick="sendRequest(\''.$varMatriId.'\',\'5\',\''.$varCurrPgNo.'vp4\');"></div></div>';
			}

			//Photo Part Starts
			if((($varPhotoStatus == 1 && $varProtectPhotoStatus==1) && ($varMatriId != $sessMatriId)) || ($varPhotoStatus == 0 && $varPhHoroCount==0)) {
				$varOnClick		= "slidemtab('".$varCurrPgNo."','".$varCurrPgNo."vp3',".$varTotaltab.",'".$varMissedTab."');";
			}
			//Photo Parts Ends

			//Horoscope Parts Starts
			if(sizeof($varPhotoDetail)==0 && $varMatriId == $sessMatriId) {
				$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(1,$varMatriId,$varDbInfo['DATABASE'],$varTable);
			} else if(($varMatriId != $sessMatriId) && ($varHoroAvailable!=0) && (sizeof($varPhotoDetail)==0)){ 
				//FOR OTHER MEMBERS VIEWING MEMBERS HOROSCOPE
				$varPhotoDetail	= $objProfileOtherDtl->photoDisplay(2,$varMatriId,$varDbInfo['DATABASE'],$varTable);
			}
			//Horoscope Parts Ends

			if(sizeof($varPhotoDetail)>0) {
				$varPhotoPath		= $confValues['PHOTOURL']."/".$varMatriId{3}."/".$varMatriId{4};
				$arrPhotoDetail		= explode('~',$varPhotoDetail);
				$arrThumbPhotoName	= explode('^',$arrPhotoDetail[0]);//Thumb small Photo
				$arrPhotoStatus		= explode('^',$arrPhotoDetail[1]);//Photo Status
				$arrNormalPhotoName	= explode('^',$arrPhotoDetail[2]);//Normal Photo
				$varHoroscopeURL	= $arrPhotoDetail[3];//Horoscope
				if($arrThumbPhotoName[0] != '') {
					$varPhotoCount		= sizeof($arrThumbPhotoName);
				}
				if($varPhotoCount>0) { 
					if($varMatriId != $sessMatriId) {
						if($varProtectPhotoStatus==1) { 
							$varReqImg		= "img85_pro.gif";
							$varSinglePhoto	= $confValues['IMGSURL']."/".$varReqImg;
						} else { 
							$varSinglePhoto	= $varPhotoPath."/".$arrThumbPhotoName[0];
							$varStrArg		= "'".$arrThumbPhotoName[0]."',".$varMatriId{3}.",".$varMatriId{4};
						}
					} else if($varMatriId == $sessMatriId) {
						if($varPhotoStatus==0) { 
							$varSinglePhoto	= $confValues['PHOTOURL']."/crop150/".$arrThumbPhotoName[0];
							$varOnClick		= "window.open('".$confValues['IMGURL']."/photo/viewphoto.php?ID=".$varMatriId."','','directories=no,width=600,height=600,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0');";
						} else { 
							$varSinglePhoto	= $varPhotoPath."/".$arrThumbPhotoName[0];
							$varStrArg		= "'".$arrThumbPhotoName[0]."',".$varMatriId{3}.",".$varMatriId{4};
						}
					}
				}
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

			<!-- get twitter id-->
     		<!-- <img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" style="display:none;" onload="getothertwitterid('<?=$varCurrPgNo?>','<?=$varMatriId?>','<?=$sessPaidStatus?>')"> -->
			<!-- get twitter id-->
			<?php
			if($varGetCookieInfo['HOROSCOPESTATUS']>1 && $varHoroAvailable>1){
			?><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" onload="javascript:showhoromatch('horomatchdiv-<?=$varCurrPgNo?>','<?=$sessMatriId?>','<?=$varMatriId?>','<?=$htype?>','msgactpart<?=$varCurrPgNo?>');">
			<?php } ?>
            
			<?php
			if( $varFPconfirm ==1) {
				$varClassName = "viewdivouter feaproviewoutbg";
			} else {
				$varClassName = "viewdivouter viewoutbg";
			}?>

			<div id="VPmain<?=$varCurrPgNo?>" class="<?=$varClassName?>">
			    
				<? if($_REQUEST['msgid'] != '') { ?>
				<? if ($varPartialFlag =='0') { if($sessMatriId !='' && $sessGender!=$varMemberInfo['Gender'] && $sessMatriId !=$varMatriId && $sessPublish>=0 && $sessPublish<=2) { ?>
						<!--<center><div class="dotsep2" style="width:500px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="2"></div></center>
						<center>-->
							<? //include_once('profileinboxview.php');?><!--</center> <br clear="all"/>--> <? } } ?>
				<? } ?>

				<div class="viewdivouter" style="height:180px;">
					<div style="width:29px;" class="fleft padt75 tlright" id="prev"><a href="javascript:;" onclick="slideclick('<?=$varCurrPgNo?>','prev',<?=$varTotaltab?>,'<?=$varMissedTab?>');"><img src="<?=$confValues['IMGSURL']?>/ltabarrow.gif" width="19" height="48" class="pntr" /></a>&nbsp;</div>
					<div style="width:500px;" class="fleft" id="vpdivres">
						<!-- <div class="viewdiv1 fright tlright padt10"><a href="<?=$confValues['SERVERURL']?>/profiledetail/fullprofile.php?id=<?=$varMatriId?>" target="_blank"><img src="<?=$confValues['IMGSURL']?>/print.gif" class="pntr" /></a> &nbsp; <?if("$varCurrPgNo"!='' && $_GET['act'] != 'viewprofile'){?><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>);imageswap('mview',<?=$varCurrPgNo?>);"/><?}?></div><br clear="all"> -->
						<center>
						<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div><div class="cleard"></div>
						<div class="viewdiv1 vnormtxt clr2 padtb10">
							<center>
							<!--<a class="<?=($varDefaultTab=='')?'clr bld':'clr1'?>" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp1',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp1','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab1">Basic Info</a>&nbsp;|&nbsp;-->
							<a class="<?=($varDefaultTab=='')?'clr5':'clr1'?>" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp2',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp2','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab2">About Me</a> &nbsp;|&nbsp; 
							<?if($varPhtoTabAvail==1) {?><a class="<?=($varDefaultTab=='photo')?'clr5':'clr1'?>" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp3',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp3','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab3">Photos</a> &nbsp;|&nbsp; <?}?>
							<?if($VarHoroFeature==1) {?><a class="<?=($varDefaultTab=='horoscope')?'clr5':'clr1'?>" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp4',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp4','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab4">Horoscope</a> &nbsp;|&nbsp; <?}?>
							<?if($varHabitsStr!='' || $varInterestSetStatus==1) { ?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp5',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp5','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab5">Lifestyle</a> &nbsp;|&nbsp; <?}?>
							<?if($varFamilySetStatus==1){?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp6',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp6','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab6">Family</a> &nbsp;|&nbsp; <?}?>
							<?if($varPartnerSetStatus==1){?><a class="clr1" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp7',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp7','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab7">My Partner</a> &nbsp;|&nbsp; <?}?>
							<a class="<?=($varDefaultTab=='phone')?'clr5':'clr1'?>" onclick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp8',<?=$varTotaltab?>,'<?=$varMissedTab?>');VPsetHeight('VPmain<?=$varCurrPgNo?>', '<?=$varCurrPgNo?>vp8','<?=$varCurrPgNo?>');" id="<?=$varCurrPgNo?>vtab8">Phone</a></center>
						</div>
						<div class="cleard"></div>
						<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div><div class="cleard"></div>
						<!-- message action div starts-->
					<!-- 	<div id="div_box<?=$varCurrPgNo?>" class="frdispdiv brdr1 bgclr2 vishid posabs" style="padding:10px;">
							<div id="msgactpart<?=$varCurrPgNo?>" class="tlleft"></div>
						</div> -->
						<!-- message action div starts-->
							
						<!-- ashtakoota horoscope action div starts-->
						<div id="horid" class="posabs vishid">
							<div id="hormsgid" class="brdr tlleft" style="background-color:#EEEEEE;">
							<div class="rpanelinner padtb10">
								<div class="fright tlright" style="padding-right:10px;"><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>);"/></div><br clear="all">
								<div id="horomatchcontentdiv-<?=$varCurrPgNo?>"></div>
							</div>
							</div>
						</div>
						<!-- horoscope action div starts-->

						<div id="<?=$varCurrPgNo?>twitmain" class="disnon">
						<center>
							<div class="fleft pad5 brdr"><img src="<?=$confValues['IMGSURL']?>/twit_img.gif" /></div><div class="fleft normtxt1 clr1 tlleft bld" style="padding-top:5px;padding-left:10px;"><? echo ($checkcrawlingbotsexists == false)?$varDisplayName:''; ?><font class="clr">'s<br>Twitter Updates</font><div id="<?=$varCurrPgNo?>twitteriddiv"></div></div><br clear="all"/><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br>
							<div id="<?=$varCurrPgNo?>twitterdiv" class="fleft posabs brdr smalltxt tlleft" style="height:140px !important;height:183px; width:460px! important;width:500px; background-color:#FFFFFF; overflow:auto;padding:20px;">
							</div>
						</center>
						</div>

						<div id="<?=$varCurrPgNo?>vp2" class="<?=($varDefaultTab=='')?'padtb10 viewdiv1 disblk':'padt10 viewdiv1 disnon'?>" style="overflow:hidden;">
							<?if($varProfileCreatedBy!='') {?>
							<div id="procre" class="tlright vpdiv5 padtb3 fleft">Profile created by :</div>
							<div id="par" class="vpdiv5a padl310 fleft"><?=$varProfileCreatedBy?></div><br clear="all"/>
							<?}?>

							<div id="probas" class="tlright vpdiv5 padtb3 fleft">Basic Information :</div>
							<div id="bas" class="vpdiv5a padl310 fleft"><?=$varBasicStr?></div><br clear="all"/>

							<div id="probel" class="tlright vpdiv5 padtb3 fleft">Cultural Background :</div>
							<div id="bel" class="vpdiv5a padl310 fleft"><?=$varBeliefsStr?></div><br clear="all"/>

							<div id="procar" class="tlright vpdiv5 padtb3 fleft">Career :</div>
							<div id="car" class="vpdiv5a padl310 fleft"><?=$varCareerStr_EduLong?></div> 

							<div id="proloc" class="tlright vpdiv5 padtb3 fleft">Location :</div>
							<div id="loc" class="vpdiv5a padl310 fleft"><?=$varLocationStr?></div>

							<div id="proabme" class="tlright vpdiv5 padtb3 fleft">Few lines about me :</div>
							<div id="flines" class="vpdiv5a padl310 fleft"><?=$varAboutmySelf?></div>
						</div>

						<div id="<?=$varCurrPgNo?>vp3" class="<?=($varDefaultTab=='photo')?'padtb10 viewdiv1 disblk':'padt10 viewdiv1 disnon'?>" style="overflow:hidden;">
							<? if($varPhotoStatus == 0 && $varMatriId != $sessMatriId) { 
								echo $varPhotoMsg;  
							} else if($varPhotoStatus == 1 && $varProtectPhotoStatus==1 && $varMatriId != $sessMatriId) {
									$varReqImg		= "img50_pro.gif";
									$varStrArg		= $confValues['IMGSURL']."/".$varReqImg; ?>
								<div class="vpphdiv padtb3 fleft">
									<div class="photodiv1 fleft"><a><img src="<?=$varStrArg?>" width="50" height="50"/></a></div>
								</div><br clear="all">
								<div class="normtxt">
									To view the photo of this member, you require a password. Please enter the password below. If you do not have the password, please send an e-mail request to the member <br>and get the password.<br clear="all"><br clear="all">
									Enter photo password: <input type="password" class="inputtext" id="password" name="password">&nbsp;&nbsp;&nbsp;<input type="button" class="button" name="" onClick="getPhotoView('<?=$varMatriId?>');" value="Submit"><br clear="all">
									<span id="protecterror" class="errortxt"></span>
								</div>
								<div id="photodiv">
								</div>
							<? } else if($varPhotoCount>0) {?>
								<div class="vpphdiv padtb3 fleft">
									<?$varFMPhotoCnt	= $confValues['FMPHOTOCNT']-1;
									for($i=0;$i<$varPhotoCount;$i++) {
										if($varMatriId == $sessMatriId) {
											if($arrPhotoStatus[$i] == 1) {
												$varPhotoStr	= $varPhotoPath."/".$arrNormalPhotoName[$i];
												$varStrArg		= "'".$arrThumbPhotoName[$i]."',".$varMatriId{3}.",".$varMatriId{4}.",".$varCurrPgNo;

												echo '<div class="photodiv1 fleft"><a><img src="'.$varPhotoStr.'" width="50" height="50" onClick="displayBigPhoto('.$varStrArg.');"/></a></div>';
											} else {
												$varPhotoStr	= $confValues['PHOTOURL']."/crop75/".$arrNormalPhotoName[$i];
												$varStrArg		= "'crop150/".$arrThumbPhotoName[$i]."',".$varCurrPgNo;
												echo '<div class="photodiv1 fleft"><a><img src="'.$varPhotoStr.'" width="50" height="50" onClick="displayBigCropPhoto('.$varStrArg.');"/></a><div>under validation</div></div>';
											}

										} else if($varMatriId != $sessMatriId) {
											//For Opposite MatriId
											$varPhotoStr	= $varPhotoPath."/".$arrNormalPhotoName[$i];
											$varStrArg		= "'".$arrThumbPhotoName[$i]."',".$varMatriId{3}.",".$varMatriId{4}.",".$varCurrPgNo;
											
											if($sessPaidStatus==0 && $i > $varFMPhotoCnt) {
												$varReqImg	= $confValues['IMGSURL']."/".$varPayNowImg;
												echo '<div class="photodiv1 fleft"><a href="'.$confValues['SERVERURL'].'/payment/index.php"  target="_blank"><img src="'.$varReqImg.'" width="50" height="50"/></a></div>';
											} else {
												echo '<div class="photodiv1 fleft"><a><img src="'.$varPhotoStr.'" width="50" height="50" onClick="displayBigPhoto('.$varStrArg.');"/></a></div>';
											}
										}
										if($i==4) {
											echo '<br clear="all"/>';
										}
									}?>
								</div>
								<div class="vpphdiv1 padtb3 fleft">
									<div id="bigviewphoto<?=$varCurrPgNo?>">
										<?
											if($varPhotoStatus==0) {
												$varFirstPhotoStr	= $confValues['PHOTOURL']."/crop150/".$arrThumbPhotoName[0];
											} else {
												$varFirstPhotoStr	= $varPhotoPath."/".$arrThumbPhotoName[0];
											}
										?>
										<img src="<?=$varFirstPhotoStr?>" width="150" height="150" />
									</div>
								</div>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp4" class="<?=($varDefaultTab=='horoscope')?'padtb10 viewdiv1 disblk':'padt10 viewdiv1 disnon'?>" style="overflow:hidden;">
							<?if($varHoroAvailable == 0 && $varMatriId != $sessMatriId) { 
								echo $varHoroscopeMsg;
							} else if(($varHoroAvailable == 1 || $varHoroAvailable==3) && $varHoroProtected==1 && $varMatriId != $sessMatriId) {
									$varReqImg		= "img50_pro.gif";
									$varStrArg		= $confValues['IMGSURL']."/".$varReqImg; ?>
								<div class="vpphdiv padtb3 fleft">
									<div class="photodiv1 fleft"><a><img src="<?=$varStrArg?>" width="50" height="50"/></a></div>
								</div><br clear="all">
								<div class="normtxt">
									To view the horoscope of this member, you require a password. Please enter the password below. If you do not have the password, please send an e-mail request to the member <br>and get the password.<br clear="all"><br clear="all">
									Enter horoscope password: <input type="password" class="inputtext" id="horopass" name="horopass">&nbsp;&nbsp;&nbsp;<input type="button" class="button" name="" onClick="getHoroscopeView('<?=$varMatriId?>');" value="Submit"><br clear="all">
									<span id="horoprotecterror" class="errortxt"></span>
								</div>
								<div id="horodiv">
								</div>
							<? } else if($varHoroscopeURL!='') { 
									$varHoroOnClick = $confValues['IMAGEURL'].'/horoscope/viewhoroscope.php?ID='.$varMatriId;
									if($sessPaidStatus == 0 && ($varMatriId != $sessMatriId) && ($varHoroAvailable==1 || $varHoroAvailable==3)) { 
										$varViewButton		= '<input type="button" class="button" name="" value="Pay now to view Horoscope" onClick="window.open(\''.$confValues['SERVERURL'].'/payment/\');">';
										$varHoroTimeOfBirth	= '<img src="'.$confValues['IMGSURL'].'/blurimg.gif" alt="" />';
										$varHoroTimeZone	= '<img src="'.$confValues['IMGSURL'].'/blurimg.gif" alt="" />';
									} else { 
										$varViewButton		= '<input type="button" class="button" name="" value="View Horoscope" onClick="window.open(\''.$varHoroOnClick.'\',\'\',\'directories=no,width=650,height=650,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=no,top=0\');">';
										$varHoroTimeOfBirth	= $varHoroBirthTimeStr.', Standard Time';
										$varHoroTimeZone	= '(Hrs. Mins):'.$varTimeZone;
									}

									if($varUploadMsg!=''){
										echo '<div class="normtxt">'.$varUploadMsg.'</div><br clear="all"><br clear="all">';
									} else if($varHoroAvailable==1) {
										echo '<div class="normtxt">This member has uploaded a scanned horoscope.</div><br clear="all"><br clear="all">';
									} else if($varHoroAvailable==3) { ?>
									<div class="tlright vpdiv5 padtb3 fleft">Name :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varName?></div><br clear="all"/>

									<div class="tlright vpdiv5 padtb3 fleft">Date of Birth :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varHoroBirthDateStr?></div><br clear="all"/>

									<div class="tlright vpdiv5 padtb3 fleft">Time of Birth :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varHoroTimeOfBirth?></div><br clear="all"/>

									<div class="tlright vpdiv5 padtb3 fleft">Time Zone :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varHoroTimeZone?> </div> 
										
									<div class="tlright vpdiv5 padtb3 fleft">Time Correction :</div>
									<div class="vpdiv5a padl310 fleft">Standard Time</div>

									<div class="tlright vpdiv5 padtb3 fleft">Place of Birth :</div>
									<div class="vpdiv5a padl310 fleft"><?=$varCityName?></div>
								<? } ?>
								<div class="fright padr20">
									<?=$varViewButton?>
								</div><br clear="all"/>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp5" class="padtb10 viewdiv1 disnon" style="overflow:hidden;">
							<?if($varHabitsStr!='') { ?>
							<div class="tlright vpdiv5 padtb3 fleft">Habits :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varHabitsStr?></div><br clear="all"/>
							<? } if($varInterest!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Interests :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varInterest?>...</div><br clear="all"/>
							<? } if($varHobbies!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Hobbies :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varHobbies?></div><br clear="all"/>
							<? } if($varFavouriteStr!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Favourites :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varFavouriteStr?>...</div> 
							<? }?>
						</div>

						<div id="<?=$varCurrPgNo?>vp6" class="padtb10 viewdiv1 disnon" style="overflow:hidden;">
							<? if($varFamilyValue!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Family value :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varFamilyValue?></div><br clear="all"/>
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
							<div class="tlright vpdiv5 padtb3 fleft">Family type & status :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varFamilyTypeAndStatus?></div><br clear="all"/>
							<? } if($varFamilyOrigin!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Ancestral Origin :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varFamilyOrigin?></div><br clear="all"/>
							<? } if($varReligiousValues!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Religious values :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varReligiousValues?></div><br clear="all"/>
							<? } if($varEthnicity!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Ethnicity :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varEthnicity?></div><br clear="all"/>
							<? } if($varParenstOccStr!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Parents Occupation :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varParenstOccStr?></div><br clear="all"/>
							<? } if($varSiblingsStr!='') {?>
							<div class="tlright vpdiv5 padtb3 fleft">Siblings :</div>
							<div class="vpdiv5a padl310 fleft"><?=trim($varSiblingsStr,', ')?></div> 
							<? } if($varAboutFamily!='') {?>	
							<div class="tlright vpdiv5 padtb3 fleft">Few lines about my family :</div>
							<div class="vpdiv5a padl310 fleft"><?=$varAboutFamily?></div>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp7" class="padtb10 viewdiv1 disnon" style="overflow:hidden;">
							<div class="padtb3">I want to marry someone who meets most of my preferences which I have noted here.</div>
							<div class="tlright vpdiv6 padtb3 fleft">Basic Information :</div>
							<div class="vpdiv6a padl310 fleft"><?=trim($varPartnerBasicStr,', ')?></div><br clear="all"/>

							<?if($varPartnerBeliefs!=''){?>
							<div class="tlright vpdiv6 padtb3 fleft">Cultural Background :</div>
							<div class="vpdiv6a padl310 fleft"><?=$varPartnerBeliefs?></div><br clear="all"/>
							<?}?>
							
							<div class="tlright vpdiv6 padtb3 fleft">Career :</div>
							<div class="vpdiv6a padl310 fleft"><?=$varPartnerCareerStr?></div><br clear="all"/>

							<div class="tlright vpdiv6 padtb3 fleft">Location :</div>
							<div class="vpdiv6a padl310 fleft"><?=$varPartnerLocStr?></div> 
							
							<?if($varPartnerHabits!='') { ?>
							<div class="tlright vpdiv6 padtb3 fleft">Lifestyle :</div>
							<div class="vpdiv6a padl310 fleft"><?=trim($varPartnerHabits,', ');?></div>
							<? } ?>

							<?if($varPartnerDescription!='') { ?>
							<div class="tlright vpdiv6 padtb3 fleft">Few lines about my partner :</div>
							<div class="vpdiv6a padl310 fleft"><?=$varPartnerDescription?></div>
							<? } ?>
						</div>

						<div id="<?=$varCurrPgNo?>vp8" class="<?=($varDefaultTab=='phone')?'padtb10 viewdiv1 disblk':'padt10 viewdiv1 disnon'?>" style="overflow:hidden;">
							<?if($varMatriId == $sessMatriId) { ?>
							<img src="<?=$confValues['IMGSURL']?>/trans.gif" onload="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8','<?=$varCurrPgNo?>','vp');">
							<? } else {
									if($varPhoneVerified==1 || $varPhoneVerified==3) {
										if($varPhoneProtected==1) {
											if($sessPaidStatus==1) { ?>
												<center>
													<div class="padtb3 fleft"><br><br>
														<div class="fleft pad3">This member has protected the phone number. To view the phone number, contact this member by sending a personalised message.</div>
													</div>
												</center><br clear="all"/>
											<? } else { ?>
												<center>
													<div class="padtb3 fleft"><br><br>
														<div class="fleft pad3">This member has protected the phone number. To view the phone number,  <a class="clr1 bld" href="/payment/index.php">Pay NOW</a></div>
													</div>
												</center><br clear="all"/>
											<? }
										} else {
											if($sessPaidStatus==1) { ?>
												<div id="phmsg" class="disblk">
													Are you sure you want to view this member's phone number?<br clear="all"><br clear="all">
													<div class="fright padr20">
														<input type="button" onClick="getPhoneView('<?=$varMatriId?>','<?=$varCurrPgNo?>vp8','<?=$varCurrPgNo?>','vp');" value="Yes" class="button">
														<input type="button" onClick="slidemtab('<?=$varCurrPgNo?>','<?=$varCurrPgNo?>vp1',<?=$varTotaltab?>,'<?=$varMissedTab?>');" value="No" class="button">
													</div>
												</div>
											<? } else { ?>
												<center>
													<div class="padtb3 padl25"><br>
														<div class="fleft pad3">Phone Number :</div>
														<div class="fleft"><img src="<?=$confValues['IMGSURL']?>/blurimg.gif" alt="" /></div>
														<div class="fleft pad3"> <a class="clr1 bld" href="/payment/index.php">Pay NOW</a> to view phone number.</div>
													</div>
												</center><br clear="all"/>
											<? }
										}
									} else { ?>
										<div class="normtxt">
											This member has not added phone number. If you would like to view this member's phone number, you can request member to add it.<br clear="all"><br clear="all">
											<div class="fright padr20"><input type="button" class="button" name="" value="Request Now"onClick="sendRequest('<?=$varMatriId?>','3','<?=$varCurrPgNo?>vp8');"></div>
										</div>
										
									<? }
								} ?>
						</div><div class="cleard"></div>
						<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div><div class="cleard"></div>
						
						
						<div id="<?=$varCurrPgNo?>twitmain" class="disnon" >
						<center>
							<div class="fleft pad5 brdr"><img src="<?=$confValues['IMGSURL']?>/twit_img.gif" /></div><div class="fleft normtxt1 clr1 tlleft bld" style="padding-top:5px;padding-left:10px;"><? echo ($checkcrawlingbotsexists == false)?$varDisplayName:''; ?><font class="clr">'s<br>Twitter Updates</font><div id="<?=$varCurrPgNo?>twitteriddiv"></div></div><br clear="all"/><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br>
							<div id="<?=$varCurrPgNo?>twitterdiv" class="fleft posabs brdr smalltxt tlleft" style="height:140px !important;height:183px; width:460px! important;width:500px; background-color:#FFFFFF; overflow:auto;padding:20px;">
							</div>
						</center>
						</div>
						
					
						<div class="smalltxt fright padtb5"><div id="favdiv" class="<?=$varBookMarkClass?>"><a class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd1('shortlist','<?=$varMatriId?>','favdiv','div_box<?=$varCurrPgNo?>','msgactpart<?=$varCurrPgNo?>','<?=$varCurrPgNo?>');">Add to Favourites</a></div> <? if ($varPartialFlag=='0') { ?>	
						<div id="bardiv" class="<?=$varBarDivClass?>"> | </div>
						<div id="blockdiv" class="<?=$varBlockedClass?>"><a class="clr1" onClick="show_box(event,'div_box<?=$varCurrPgNo?>');lisatadd1('block','<?=$varMatriId?>','blockdiv','div_box<?=$varCurrPgNo?>','msgactpart<?=$varCurrPgNo?>','<?=$varCurrPgNo?>');">Block Member</a></div><!-- <div class="fleft" style="padding-top:3px;" id="<?=$varCurrPgNo?>twitterlinkdiv">&nbsp;|&nbsp; <a class="clr1" onClick="showTwitterUp('<?=$varCurrPgNo?>','<?=$varMatriId?>');">Twitter Updates</a></div> --> <? } ?></div>
						<div class="cleard"></div>
					</div>
					<div style="width:24px;" class="fleft padt75 tlright" id="nxt"><a href="javascript:;" onclick="slideclick('<?=$varCurrPgNo?>','nxt',<?=$varTotaltab?>,'<?=$varMissedTab?>');" ><img src="<?=$confValues['IMGSURL']?>/rtabarrow.gif" width="20" height="48" class="pntr" /></a></div>
				</div></center>
			<div><br clear="all">
			<!-- <center>
			<div class="linesep viewdiv1"><img src="images/trans.gif" height="1" width="1" /></div></center> -->
		</div>
	</div>
		<?}
	} else {
		$varFilterMessage = "Sorry, this member's profile does not exist.";
	}
} else {
	$varStyle = "style='display:none'";
	$varFilterMessage = "Register free to view full profile details and to contact this member.<br clear='all'/><a class='clr1' href='".$confValues['SERVERURL']."/register/'>Click here to Register</a> or <a class='clr1' href='".$confValues['SERVERURL']."/login/'>Login NOW.</a>";
}

//CLOSE DB
$objProfileDetail->dbClose();
$objProfileDetailMaster->dbClose();

//UNSET OBJECTS
unset($objProfileDetail);
unset($objProfileDetailMaster);

if($varFilterMessage!='') {?>
		<div class="rpanelinner brdr pad10">
			<div class="fright tlright" <?=$varStyle?>><img src="<?=$confValues['IMGSURL']?>/close.gif" class="pntr" onclick="closeViewDisp(<?=$varCurrPgNo?>);"/></div><br clear="all">
			<?=$varFilterMessage?>
		</div>
<?}?>