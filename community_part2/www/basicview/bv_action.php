<?

$varRootBasePath	= '/home/product/community';

//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/messagevars.cil14");
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
$varMatriId			= trim($_REQUEST["ID"]);
$varGender			= $_REQUEST["G"];
$varCurrPgNo		= $_REQUEST["cpno"];// 1;
$varMemberInfo['Gender']	= $varGender;
$varModule			= $_REQUEST["module"];
$varSwapInt			= '1';

//OBJECT DECLARTION
$objProfileDetail	= new MemcacheDB;

//CONNECT DATABASE
$objProfileDetail->dbConnect('M',$varDbInfo['DATABASE']);

include_once($varRootBasePath.'/www/profiledetail/memberactioninfo.php');
include_once($varRootBasePath.'/www/profiledetail/profileinboxview.php');

if ($varModule=='search') {
if ($sessMatriId !="") {
//echo $varMatriId;echo "<br>";	
//echo "<br>sessPaidStatus=".$sessPaidStatus;echo "<br>";
//echo "<br>msgty=".$_REQUEST['msgty'];echo "<br>";
//echo "<br>msgfl=".$_REQUEST['msgfl'];echo "<br>";

//echo "<br>varMessageFlag==".$varMessageFlag."===".$varMessageType.'=Int Sen'.$varIntSentDate;

//if ($sessPaidStatus==0 && $varMessageType=='S' && $varMessageFlag==2){
if ($sessPaidStatus==0 && ($varMessageType=='S' || $varIntSentDate!='0000-00-00 00:00:00') && $varMessageFlag==2){

	//echo $funCMsg.'=='.$varMsgStatusContent;

	$varContent = '<div class="tlleft" id="actiondiv'.$varCurrPgNo.'"';
	$varContent .= '<center><div class="fright"><img src="'.$confValues['IMGSURL'].'/close.gif" class="pntr" onclick="selclose();"></div><br clear="all">';
	$varContent .= '<div class="padb5 tlleft"><div id="firstct'.$varCurrPgNo.'" class="disblk"><div style="padding-left:100px;">';
	//$varContent .=  $varMsgStatusContent;
	$varContent .= 'You have already sent Interest to <b>'.$varMatriId.'</b>.';
	$varContent .= '<div class="normtxt">To send message in your own words <a class="clr1 bld" href="'.$confValues['SERVERURL'].'/payment/">Become A Premium Member.</a></div>';
	$varContent .= '</div></div><br clear="all">';
	$varContent .= '</center></div>';


} else if(($sessPaidStatus==1) || ($varMessageFlag=='' && $varMessageType=='') || ($varMessageType=='R')){ 
//} else if($varDispalyMsgPart==1 || ($varMessageFlag=='' && $varMessageType=='')){ 

//SEARCH OPTIONS STARTS
#    $varSenderSideFn	= "swapdiv('0','1')";

$varContent = '<div class="padt10 tlleft" id="actiondiv'.$varCurrPgNo.'"';
$varContent .= '<center><div id="msgactpart2000" class="tlleft"><div class="fright" style="margin-right:15px;"><img src="'.$confValues['IMGSURL'].'/close.gif" class="pntr" onclick="selclose();"></div><br clear="all">';

$varContent .= '<div class="fright padb5"><div id="firstct'.$varCurrPgNo.'" class="disblk"><div style="margin-right:15px;">';
//$varContent .= '<input type="button" class="button" value="'.$varButtonName.'" onclick="showOption(\''.$varCurrPgNo.'\');'.$varSenderSideFn.';" />';
$varContent .= '</div></div></div><br clear="all">';
$varContent .= '<div id="msg1div'.$varCurrPgNo.'">';
$varContent .= '<div id="replyDiv'.$varCurrPgNo.'"></div>';

#Interest Action Area Part
$varFreeChecked = '';
$varPaidChecked	= '';
$varFreeDisabled	= '';	
if($sessPaidStatus == 0){ $varFreeChecked = 'checked'; $varFreeDisabled='disabled'; }
if($sessPaidStatus == 1){ $varPaidChecked = 'checked'; $varFreeDisabled=''; }
$varContent .= '<div class="smalltxt tlleft fleft" style="width:475px;height:100px !important;height:120px;">';
$varContent .= '<div class="smalltxt clr bld " style="padding-left:10px;"><input type="radio" name="msgtype'.$varCurrPgNo.'" id="msgtype1" '.$varFreeChecked.' onclick="swapdiv(\''.$varCurrPgNo.'\',\'2\',\''.$varSwapInt.'\');"> Send templated message</div>';
$varContent .= '<div style="height:75px !important;height:90px;width:460px;float:left;margin-top:4px;margin-left:17px;padding-top:7px;display:inline;">';
$varContent .= '<div id="radio2div'.$varCurrPgNo.'" class="disblk" style="padding-left:10px;">';
$varContent .= '<div class="fleft">';
$varContent .= '<div class="radiodiv2 lh16">';
$varContent .= '<form name="frmbvaction" method="post" style="margin:0px;">';
	foreach($arrExpressInterestList as $key=>$value){

		$varChecked = ($key == 1) ? 'Checked' : '';
		$varContent .= '<div class="fleft tlright" style="width:30px;padding-top:8px !important;padding-top:5px;display:inline"><input type="radio" class="frmelements" name="intopt'.$varCurrPgNo.'" value="'.$key.'"  id="intopt'.$key.'" '.$varChecked.'></div><div class="fleft" style="width:410px;padding-top:7px;padding-left:5px;">'.$value.'</div><br clear="all">';
	}

$varContent .= '</form></div></div></div></div></div>';

#Interest Action Area Part Ends


#Richtext Area Part-->
$varContent .= '<div class="smalltxt tlleft fleft" style="width:450px !important;width:454px;height:135px !important;height:125px;">';
$varContent .= '<div class="smalltxt clr bld" style="margin-top:10px !important;margin-top:0px;padding-left:10px;height:30px;"><input type="radio" name="msgtype'.$varCurrPgNo.'" id="msgtype2" '.$varPaidChecked.'  '.$varFreeDisabled.' onclick="swapdiv(\''.$varCurrPgNo.'\',\'1\',\''.$varSwapInt.'\');"> Send personalized message</div>';

$varContent .= '<div id="radio1div'.$varCurrPgNo.'" class="disblk tlleft" style="padding-left:5px;">';

if($sessPaidStatus == 1 && $sessPublish==1){

$varButtonVal = '<input type="button" class="button" value="Send Message" onclick="javascript:RTESubmit(\'\');"/>'; 

$varContent .= '<div style="margin-left:17px;"><iframe width="455" height="82" frameborder="0" src="'.$confValues['SERVERURL'].'/mymessages/sendmail.php?currrec='.$varCurrPgNo.'" style="margin-left:15px;" id="parentrte'.$varCurrPgNo.'" name="parentrte'.$varCurrPgNo.'" contentEditable="true"></iframe></div>';

} else if($sessPaidStatus == 1 && $sessPublish==2) {
					$varButtonVal = '<input type="button" class="button" value="Send Message" onclick="alert("hi");" />';

$varContent .= '<div class="padl25"><div><br>Currently your profile is hidden. To send message, you must <a href="'.$confValues['SERVERURL'].'/profiledetail/index.php?act=profilestatus" class="clr1">click here to unhide</a> your profile.<br></div></div>';

} else {
	
	$varButtonVal = '<input type="button" class="button" value="Send Message" onClick="javascript:sendInterestsrch('.$varCurrPgNo.');"/>';

	$varContent .= '<div style="margin-left:30px;width:459px;background:#ffffff;"><div class="normtxt" style="background:url(http://img.communitymatrimony.com/images/freember-bg.jpg) no-repeat;height:80px;"><center><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="50">To send message in your own words <a class="clr1 bld" href="'.$confValues['SERVERURL'].'/payment/">Become A Premium Member.</a></center></div>';
	$varContent .= '</div>';

}
	$varContent .= '</div>';
#Richtext Area Part Ends

	$varContent .= '</div><span style="margin-left:40px;" class="fleft errortxt" id="errorDisplay"></span>';
	$varContent .= '<div style="width:450px;float:left;margin-left:40px;display:inline;height:25px;">';
	$varContent .= '<div class="fright" id="buttonSub'.$varCurrPgNo.'">'.$varButtonVal.'</div>';
	$varContent .= '</div>';
	$varContent .= '<br clear="all">';
	$varContent .= '</div>';
	$varContent .= '</div></center></div><div class="fleft" style="height:15px;width:450px;">&nbsp;</div>';

//SEARCH OPTIONS ENDS

}
} 
echo $varContent;
}


   ?>


