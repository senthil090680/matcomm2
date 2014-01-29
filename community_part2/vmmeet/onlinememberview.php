<?php  
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']); 


include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc"; 
include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";
$member_id=trim($_COOKIE['Memberid']);
$gender=trim($_COOKIE['Gender']);
$evid=trim($_REQUEST['evid']);
$search_type = $_REQUEST["SEARCH_TYPE"];

$block_msg=trim($_REQUEST['block_chat']);
$unblock_msg=trim($_REQUEST['unblock_chat']);

$language=getDomainInfo(1,$member_id);
$domain_value=$language["domainnameshort"];
include_once"dosearchfunction.php";

$db = new db();
$db->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ONLINESWAYAMVARAM']);

if($block_msg!=""){
$block_msge=explode("/",$block_msg);
foreach ($block_msge as $blk)
	{
    block_chat_member($member_id,$blk,$evid);
    }
}

/*Block Messages Funtion*/
function block_chat_member($from,$to,$evid){
global $db,$DBNAME,$TABLE;

$from = ucfirst($from);
$to = ucfirst($to);
 $block_sql="insert into ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." (SenderId,ReceiverId,BlockStatus,EventId,BlockDate) Values ('$from','$to','1',$evid,now()) ON DUPLICATE KEY UPDATE BlockStatus=1,BlockDate=now()";
$db->insert($block_sql);
}

if($unblock_msg!=""){

$unblock_msge=explode("/",$unblock_msg);
foreach ($unblock_msge as $unblk)
	{
    unblock_chat_member($member_id,$unblk,$evid);
    }
}
/*UnBlock Messages Funtion*/
function unblock_chat_member($from,$to,$evid){
global $db,$DBNAME,$TABLE;
$from = ucfirst($from);
$to = ucfirst($to);
  $unblock_sql="Update ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." set BlockStatus=0 where SenderId='$from' and ReceiverId='$to' and EventId=$evid";
$db->update($unblock_sql);
}



//Gende check
//if($gender == 'M'){
$data = file_get_contents("http://192.168.3.5:9090/plugins/presence/status?jid=all@female&type=text");
//}
//else{
//$data = file_get_contents("http://192.168.3.130:9090/plugins/presence/status?jid=all@male&type=text");
//}


$data = str_replace('[','',$data);
$data = str_replace(']','',$data);
$data = trim($data);

$exp = explode(',',strtoupper($data)); 


foreach($exp as $val){  
   $matrimonymeetid = "'".ucfirst(trim($val))."',".$matrimonymeetid;
}

//Do search
if( $search_type == "DOSEARCH"){  

   if($gender == 'M') {   
   $sex = 'F';
   }
   else {
   $sex = 'M';
   }

  $profile_query= "select MatriId from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE']." where Gender='M'"; 
$_REQUEST['EDUCATION1']=explode("~",$_REQUEST["EDUCATION1"]);
$_REQUEST['COUNTRY1']=explode("~",$_REQUEST["COUNTRY1"]);
$SearchQueryReturn = do_search();
$profile_query .= $SearchQueryReturn[0];
$profile_count=$db->select($profile_query);
$profile_res_array=$db->getResultArray("MYSQL_ASSOC");
foreach($profile_res_array as $profile_res){
  $val = $profile_res['MatriId'];
if (preg_match("'".$profile_res['MatriId']."'", $matrimonymeetid)) {
      $val = $profile_res['MatriId'];
	  $searchid = "'".ucfirst(trim($val))."',".$searchid;
}
 
}
}
if($searchid !="") {
  $matrimonymeetid = substr(trim($searchid),0,-1);
 }
 else{
 $matrimonymeetid = substr(trim($matrimonymeetid),0,-1);
 
 }

 

 $html .= '<table border="0" cellpadding="0" cellspacing="0" width="340">';

$profile_query= "select MatriId,Language,Age,Height,Religion,Caste,SubCaste,CasteNoBar,ResidingState,CountrySelected,Education,EducationSelected,OccupationSelected,OccupationCategory,ResidingArea,ResidingDistrict,ResidingCity,Occupation,PhotoAvailable from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE']." where MatriId in($matrimonymeetid) and MatriId!='$member_id'";
$profile_count=$db->select($profile_query);
if($profile_count>0){
$profile_res_array=$db->getResultArray("MYSQL_ASSOC");
foreach($profile_res_array as $profile_res){
extract($profile_res);

 $ph_sql="select MatriId,ThumbImgs1,PhotoURL1,PhotoProtected from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO']." where (PhotoProtected='N' or PhotoProtected is NULL or PhotoProtected='') and  MatriId in ($matrimonymeetid)";
$db->select($ph_sql);
while($ph_res=$db->fetchArray()){			
$img_val[$ph_res['MatriId']]="http://imgs.".$domain_value."matrimony.com/photos/".substr($ph_res['MatriId'],1,1)."/".substr($ph_res['MatriId'],2,1)."/".$ph_res['ThumbImgs1'];
}
$block_query= "SELECT ReceiverId from  ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." WHERE SenderId='$member_id' and ReceiverId='$MatriId' and BlockStatus=1 and EventId=$evid";
$db->select($block_query);
while($block_res=$db->fetchArray()){
 $block_id[]=$block_res['ReceiverId'];
}
$sendblock_query= "SELECT SenderId from  ".$DBNAME['ONLINESWAYAMVARAM'].".".$TABLE['ONLINESWAYAMVARAMCHATSTATUS']." WHERE SenderId='$MatriId' and ReceiverId='$member_id' and BlockStatus=1 and EventId=$evid";
$db->select($sendblock_query);
while($sendblock_res=$db->fetchArray()){
$sendblock_id[]=$sendblock_res['SenderId'];
}
$heightcal = calrevfloatheight($Height);
$feetis = $heightcal['ft'];
$inchis = $heightcal['inchs'];
if ($feetis == 0){
$view_feet="-";
}else{
$view_feet=$feetis." Ft ".$inchis." In ";
}
$View_Religion = getfromarryhash ('RELIGIONHASH',$Religion);
$View_Caste = getfromarryhash ('CASTEHASH',$Caste);
if($SubCaste!=''){$sub_caste=$SubCaste;}else{$sub_caste="#";}
$View_Country = getfromarryhash ('COUNTRYHASH',$CountrySelected);
if ($CountrySelected == 98 || $CountrySelected == 222) {
if ($CountrySelected == 98) {
$View_State = getfromarryhash ('RESIDINGINDIANAMES',$ResidingState);
} elseif ($CountrySelected == 222) {
$View_State = getfromarryhash ('RESIDINGUSANAMES',$ResidingState);
}
} else {
$View_State = ((trim($ResidingArea)!='')?trim($ResidingArea):'-');
}
if ($CountrySelected == 98 ) {
$View_City = getfromarryhash ('CITY',$ResidingDistrict);
} else {
$View_City = ((trim($ResidingCity)!='')?trim($ResidingCity):'-');
}
// Education checking //
$View_Education = getfromarryhash ('EDUCATIONHASH',$EducationSelected);

// EducationinDetail checking //
$View_EducationDetail = ((trim($Education))?trim($Education):'-');
// Employeed in checking //
$View_Employeedin = getfromarryhash ('OCCUPATIONCATEGORY',$OccupationCategory);
// Residing State checking //
$View_OccupationSelected = getfromarryhash ('OCCUPATIONLIST',$OccupationSelected);
if ($OccupationSelected == 0) {
$View_OccupationSelected = '-'; 
}
// Residing State checking //
//$photo_part="<a href='".$img_val[$MatriId]."' class='linktxt' target='_blank' onmouseover=ddrivetip('".$img_val[$MatriId]."') onmouseout=hideddrivetip('".$img_val[$MatriId]."')><b>PH</b></a>&nbsp;&nbsp;&nbsp;&nbsp;";
$ph_sql1="select PhotoProtected from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['PHOTOINFO']." where MatriId='$MatriId'";
$db->select($ph_sql1);
$ph_res1=$db->fetchArray();

if($PhotoAvailable==1 && $ph_res1['PhotoProtected']!="Y"){ 
$photo_part="&nbsp;&nbsp;<a href='".$img_val[$MatriId]."' class='linktxt' target='_blank' onmouseover=ddrivetipImg('".$img_val[$MatriId]."','','75') onmouseout=hideddrivetip('".$img_val[$MatriId]."')><img src=".$img_val[$MatriId]." border=0 width='19' height='14'></a>";
}else{
$photo_part="&nbsp;&nbsp;<img src='http://<?=$_SERVER[SERVER_NAME];?>/images/camera_icon.gif' width='19' height='14'>";
}


if(in_array($MatriId,$block_id)){
 $html .= "<tr class='normaltxt1'><td valign='top' width='10%'>".$photo_part."</td><td  width='30%'><a href='http://bmser.".$domain_value."matrimony.com/profiledetail/viewprofile.php?id=".$MatriId."' class='linktxt' target='_blank' onmouseover=ddrivetip('".$MatriId."') onmouseout=hideddrivetip('".$MatriId."')><b><font color='#FF3333'>".$MatriId."</font></b></a></td><td  width='15%'>$Age yrs</td><td width='20%'>$view_feet</td><td width='25%'><span id='c-".$MatriId."'><a href=javascript:openchat('u-".$MatriId."','".$evid."') class='linktxt'>Unblock</a></span></td></tr><tr><td colspan='5' valign='top'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='5'></td></tr><tr bgcolor='#CFE396'><td  colspan='5' valign='top'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></td></tr><tr><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='5'></td></tr><tr><td colspan='5'><div id=".$MatriId." style='display:none'>".$MatriId."~".$Age."~".$view_feet."~".$View_Religion."~".$View_Caste."~".$sub_caste."~".$View_Country."~".$View_State."~".$View_City."~".$View_Education."~".$View_OccupationSelected."</div></td></tr>";
}else if(in_array($MatriId,$sendblock_id)){ 
 $html .="<tr class='normaltxt1'><td valign='top' width='10%'>".$photo_part."</td><td  width='30%'><a href='http://bmser.".$domain_value."matrimony.com/profiledetail/viewprofile.php?id=".$MatriId."' class='linktxt' target='_blank' onmouseover=ddrivetip('".$MatriId."') onmouseout=hideddrivetip('".$MatriId."')><b><font color='#FF3333'>".$MatriId."</font></b></a></td><td width='15%'>$Age yrs</td><td  width='20%'>$view_feet</td><td width='25%'>Blocked</font></td></tr><tr><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='5'></td></tr><tr bgcolor='#CFE396'><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></td></tr><tr><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='5'></td></tr><tr><td colspan='5'><div id=".$MatriId." style='display:none'>".$MatriId."~".$Age."~".$view_feet."~".$View_Religion."~".$View_Caste."~".$sub_caste."~".$View_Country."~".$View_State."~".$View_City."~".$View_Education."~".$View_OccupationSelected."</div></td></tr>";
}else{

$MatriId = strtolower($MatriId);


 $html .="<tr ><td valign='top'  width='10%'>".$photo_part."</td><td width='30%'><a href='http://bmser.".$domain_value."matrimony.com/profiledetail/viewprofile.php?id=".$MatriId."' class='linktxt' target='_blank' onmouseover=ddrivetip('".$MatriId."') onmouseout=hideddrivetip('".$MatriId."')><b><font color='#FF3333'>".$MatriId."</font></b></a></td><td width='15%'>$Age yrs</td><td  width='20%'>$view_feet</td><td  width='25%'><span id='c-".$MatriId."'><a href=javascript:openchat('c-".$MatriId."','".$evid."') class='linktxt'>Chat</a></span></td></tr><tr><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='5'></td></tr><tr bgcolor='#CFE396'><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='1'></td></tr><tr><td valign='top' colspan='5'><img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' width='1' height='5'></td></tr><tr><td colspan='5'><div id=".$MatriId." style='display:none'>".$MatriId."~".$Age."~".$view_feet."~".$View_Religion."~".$View_Caste."~".$sub_caste."~".$View_Country."~".$View_State."~".$View_City."~".$View_Education."~".$View_OccupationSelected."</div></td></tr>";

}
}
 $html .= "</table>";

}
echo $html;

$db->dbClose();
?>