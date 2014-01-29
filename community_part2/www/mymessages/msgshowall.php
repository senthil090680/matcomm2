<?php
#====================================================================================================
# Author 		: Senthilnathan.M
# Project		: MatrimonyProduct
# Module		: Mymessages
//Received - Msg
//RMUNREAD - Unread, RMREAD - Read, RMREPLIED - Replied, RMDECLINED - declined

//Sent - Msg
//SMUNREAD - Unread, SMREAD - Read, SMREPLIED - Replied, SMDECLINED - declined

//Received - Interest
//RIPENDING - Pending, RIACCEPTED - Accept, RIDECLINED - declined

//Sent - Interest
//SIPENDING - Pending, SIACCEPTED - Accept, SIDECLINED - declined

//Received - Request
//RRPHOTO - Photo, RRPHONE - Phone, RRHOROSCOPE - Horoscope

//Sent - Request
//SRPHOTO - Photo, SRPHONE - Phone, SRHOROSCOPE - Horoscope
#====================================================================================================
$varRequestedPg		= $_REQUEST['part']!='' ? $_REQUEST['part'] : 'RMALL';
$varReqMainPg		= $varRequestedPg{0};
$varReqSubPg		= $varRequestedPg{1};

$arrMailRecStatus	= array('RMUNREAD'=>'Unread', 'RMREAD'=>'Read', 'RMREPLIED'=>'Replied', 'RMDECLINED'=>'Declined');
$arrMailSentStatus	= array('SMUNREAD'=>'Unread', 'SMREAD'=>'Read', 'SMREPLIED'=>'Replied', 'SMDECLINED'=>'Declined');
$arrIntRecStatus	= array('RIPENDING'=>'Pending', 'RIACCEPTED'=>'Accepted', 'RIDECLINED'=>'Declined');
$arrIntSentStatus	= array('SIPENDING'=>'Pending', 'SIACCEPTED'=>'Accepted', 'SIDECLINED'=>'Declined');
$arrReqRecStatus	= array('RRPHOTO'=>'Photo', 'RRPHONE'=>'Phone', 'RRHOROSCOPE'=>'Horoscope');
$arrReqSentStatus	= array('SRPHOTO'=>'Photo', 'SRPHONE'=>'Phone', 'SRHOROSCOPE'=>'Horoscope');

$arrSort = array();
if($varReqMainPg == 'S'){
	$varTabsValue	= 'Sent';
	$varOppLinkTxt	= 'Received Folder &raquo;';
	$varOppLinkVal	= 'RMALL';
	if($varReqSubPg == 'M'){
		$arrSort	= $arrMailSentStatus;
		$varAllLinkVal  = 'SMALL';
	}else if($varReqSubPg == 'I'){
		$arrSort	= $arrIntSentStatus;
		$varAllLinkVal  = 'SIALL';
	}else if($varReqSubPg == 'R'){
		$arrSort	= $arrReqSentStatus;
		$varAllLinkVal  = 'SRALL';
	}
	
}else{
	$varReqMainPg	= 'R';
	$varTabsValue	= 'Received'; 
	$varOppLinkTxt	= 'Sent Folder &raquo;';
	$varOppLinkVal	= 'SMALL';

	if($varReqSubPg == 'M'){
		$arrSort	= $arrMailRecStatus;
		$varAllLinkVal  = 'RMALL';
	}else if($varReqSubPg == 'I'){
		$arrSort	= $arrIntRecStatus;
		$varAllLinkVal  = 'RIALL';
	}else if($varReqSubPg == 'R'){
		$arrSort	= $arrReqRecStatus;
		$varAllLinkVal  = 'RRALL';
	}
	
}

// barani //

$varReceivedMessageLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part=RMALL" class="clr1">Received</a>' ;
$varSentMessageLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part=SMALL" class="clr1">Sent</a>' ;
$varReceivedInterestLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part=RIALL" class="clr1">Received</a>' ;
$varSentInterestLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part=SIALL" class="clr1">Sent</a>' ;
$varReceivedRequestLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part=RRALL" class="clr1">Received</a>' ;
$varSentRequestLink = '<a href="'.$confValues['SERVERURL'].'/mymessages/?part=SRALL" class="clr1">Sent</a>' ;

switch($varReqMainPg.$varReqSubPg){
		case 'RM' :
			$varReceivedMessageLink	= '<font class="clr5">Received</font>';
			break;
		case 'SM' :
			$varSentMessageLink= '<font class="clr5">Sent</font>';
			break;
		case 'RI' :
			$varReceivedInterestLink	= '<font class="clr5">Received</font>';
			break;
        case 'SI' :
			$varSentInterestLink	= '<font class="clr5">Sent</font>';
			break;
        case 'RR' :
			$varReceivedRequestLink	= '<font class="clr5">Received</font>';
			break;
        case 'SR' :
			$varSentRequestLink	= '<font class="clr5">Sent</font>';
			break;
}

// barani //


?>
<script language="javascript"> var msgTypes=new Array;
<?php 
echo "msgTypes['$varAllLinkVal']='All';\n";;
foreach($arrSort as $key => $value){
     echo "msgTypes['$key']='".$value."';\n";
}
?>
</script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/animatedcollapse.js" ></script>

<div class="rpanel fleft">
	<!-- message part start here -->

	<div class="clr wdth560">
           <div class="wdth560 fleft"><font class="fnt15"><b>Messages:</b></font>&nbsp;<?=$varReceivedMessageLink?>&nbsp;|&nbsp;<?=$varSentMessageLink?><font class="clr pdl37 fnt15"><b>Interests:</b></font>&nbsp;<?=$varReceivedInterestLink?>&nbsp;|&nbsp;<?=$varSentInterestLink?><font class="clr pdl37 fnt15"><b>Requests:</b></font>&nbsp;<?=$varReceivedRequestLink?>&nbsp;|&nbsp;<?=$varSentRequestLink?></div>
           <div class="dotsep2 hgt20 wdth560 fleft mymgnt10"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="1" width="1" /></div>
           <div class="wdth560 fleft">
                <div class="fleft"><font class="fnt15"><b><div class="normtxt1 bld padb5 fleft" id="msgtitle"></div></b></font></div>
                <div class="fright clr">Show:&nbsp;&nbsp;<span id="<?=$varAllLinkVal?>"><a href="javascript:;" onclick="funMain('<?=$varAllLinkVal;?>');" class="clr1">All</a></span>
				<?php		
		        foreach($arrSort as $varKey=>$varVal){
			      echo '&nbsp;&nbsp;|&nbsp;&nbsp;<span id="'.$varKey.'"><a class="clr1" href="javascript:;" onclick="funMain(\''.$varKey.'\');">'.$varVal.'</a></span>';
		        }
		        ?> 
				</div>
				<br clear="all">
<div class="smalltxt padb5 fleft" id="msgtitleDescription"></div>
           </div>
           <div class="mymgnt10 dotsep2 wdth560 fleft"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="1" width="1" /></div>
        </div>
       <div class="clr wdth560">
           <div class="wdth560 fleft smalltxt mymgnt10">
                <div class="fleft clr">Select:&nbsp;<a class="clr1" onclick="selectAll('yes');">All</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="clr1" onclick="selectAll('no');">None</a>&nbsp;&nbsp;&nbsp;&nbsp;Action:&nbsp;&nbsp;<a class="clr1"  onclick="delMsg();">Delete</a></div>
                <div id="prevnext"></div>
           </div>
           <div class="mymgnt10 dotsep2 wdth560 fleft"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="1" width="1" /></div>
        </div>
	<div class="cleard" style="height:15px;"><img src="<?=$confValues["IMGSURL"]?>/trans.gif" height="15" width="1"" /></div>
	<center>
	<div id="deldiv" style="width:480px;"></div>
	</center><input type="hidden" name="msgtype" id="msgtype" value=""><br clear="all">
	<!--<div class="normtxt1 bld padb5 fleft" id="msgtitle"></div>-->

	<!-- message part end here -->
    	<center>
		<form name="buttonfrm">
		<div id="msgResults">
			<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="funMain('<?=$varRequestedPg?>');"/>
		</div><br clear="all">
		<div id="prevnext1" class="padtb10"></div>

		</form>
	</center>
<br clear="all" />
</div>
