<?
error_reporting(0);
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']); 
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc";
include_once $DOCROOTBASEPATH."/bmconf/bmvarsviewarren.inc";

$db = new db();
$db->connect($DBCONIP['DB14'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ONLINESWAYAMVARAM']);


$idstartletterhash=array(7=>"B",6=>"R",5=>"G",8=>"P",10=>"H",9=>"S",4=>"K",3=>"E",2=>"T",1=>"M",14=>"D",12=>"C",13=>"A",11=>"Y",15=>"U");
$lang=array(1=>"TamilMatrimony",2=>"TeluguMatrimony",3=>"KeralaMatrimony",4=>"KannadaMatrimony",5=>"GujaratiMatrimony",6=>"MarathiMatrimony",7=>"BengaliMatrimony",8=>"PunjabiMatrimony",9=>"SindhiMatrimony",10=>"HindiMatrimony",11=>"OriyaMatrimony",12=>"ParsiMatrimony",13=>"AssameseMatrimony",14=>"MarwadiMatrimony",15=>"UrduMatrimony");
function getDomainLang($MatriId)
{
	global $lang,$idstartletterhash;
	
	
	 $firstdigit=substr($MatriId,0,1);
	$dblanguage=array_search($firstdigit,$idstartletterhash);
	$host=strtolower($lang[$dblanguage]);
	$dblanguage=str_replace("matrimony","",$host);
	$dblanguage=str_replace("matrimonial","",$dblanguage);

	return $dblanguage;
}

include_once "chatfunctions.php";
$member_id=$_COOKIE['Memberid'];
$password=$_COOKIE['password'];
$gender=$_COOKIE['Gender'];
$evid=trim($_REQUEST['evid']);
include_once"timertip.php";
$language=getDomainInfo(1,$member_id);
$domain_language=$language["domainnameshort"];
$domain_value=getDomainLang($member_id);
$openfire_server = "http://192.168.3.5:9090";

if($gender == 'M') {

 $sex = 'female';
}
else {

$sex = 'male';

}





//Jabber Insertion

 $profile_query= "select MatriId,Language,Age,Height,Religion,Caste,SubCaste,CasteNoBar,ResidingState,CountrySelected,Education,EducationSelected,OccupationSelected,OccupationCategory,ResidingArea,ResidingDistrict,ResidingCity,Occupation,PhotoAvailable,Citizenship,MaritalStatus,EntryType from ".$DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE']." where MatriId = '$member_id '";
$profile_count=$db->select($profile_query);
if($profile_count>0){
$profile_res_array=$db->getResultArray("MYSQL_ASSOC");
   
	$i= 0;
       

	   //for chat link display fro paid/free members
       /* $entry_type = $profile_res_array[$i]['EntryType'];
		if($entry_type == "F") {
		$class = "linktxt_blk";
		}
		else
		{
		$class = "linktxt";
		}*/
     $class = "linktxt";

	 if($profile_res_array[$i]['Name']!="") 	{
		 $view_name = $profile_res_array[$i]['Name'];
	}
		
	else { 
		 $view_name = "-";
			
		}


 if($profile_res_array[$i]['Age']!="") 	{
		 $view_age = $profile_res_array[$i]['Age'];
	}
		
	else { 
		 $view_name = "-";
			
		}



 if($profile_res_array[$i]['Height']!="") 	{
		 $view_height = str_replace(" ","_",$profile_res_array[$i]['Height']);
	}
		
	else { 
		 $view_height = "-";
			
		}


	$View_Religion = getfromarryhash ('RELIGIONHASH',$profile_res_array[$i]['Religion']);

if($View_Religion !="") 	{
		 $View_Religion = str_replace(" ","_",$View_Religion);
	}
		
	else { 
		 $View_Religion = "-";
			
		}



	$View_Caste = getfromarryhash ('CASTEHASH',$profile_res_array[$i]['Caste']);
	
	
	 if($View_Caste!="") 	{
		 $View_Caste = str_replace(" ","_",$View_Caste);
	}
		
	else { 
		 $View_Caste = "-";
			
		}



	
	$View_SubCaste = $profile_res_array[$i]['SubCaste'];
	
	 if($View_SubCaste!="") 	{
		 $View_SubCaste = str_replace(" ","_",$View_SubCaste);
	}
		
	else { 
		 $View_SubCaste = "-";
			
		}


	$View_State = getfromarryhash ('RESIDINGINDIANAMES',$profile_res_array[$i]['ResidingState']);

 if($View_State!="") 	{
		 $View_State = str_replace(" ","_",$View_State);
	}
		
	else { 
		 $View_State = "-";
			
		}


	$View_ResidingCity =  $profile_res_array[$i]['ResidingCity'];

 if($View_ResidingCity!="") 	{
		 $View_ResidingCity = str_replace(" ","_",$View_ResidingCity);
	}
		
	else { 
		 $View_ResidingCity = "-";
			
		}



	$View_Education = $profile_res_array[$i]['Education'];


 if($View_Education!="") 	{
		 $View_Education = str_replace(" ","_",$View_Education);
		 $View_Education = str_replace(",","__",$View_Education);
	}
		
	else { 
		 $View_Education = "-";
			
		}



	$View_Citizenship = getfromarryhash ('COUNTRYHASH',$profile_res_array[$i]['Citizenship']);


 if($View_Citizenship!="") 	{
		 $View_Citizenship = str_replace(" ","_",$View_Citizenship);
	}
		
	else { 
		 $View_Citizenship = "-";
			
		}




    $View_Country = getfromarryhash ('COUNTRYHASH',$profile_res_array[$i]['CountrySelected']);


 if($View_Country!="") 	{
		 $View_Country =  str_replace(" ","_",$View_Country);
	}
		
	else { 
		 $View_Country = "-";
			
		}



    $View_Marital = getfromarryhash ('MARITALSTATUSHASH',$profile_res_array[$i]['MaritalStatus']); 

 if($View_Marital!="") 	{
		 $View_Marital =  str_replace(" ","_",$View_Marital);
	}
		
	else { 
		 $View_Marital = "-";
			
		}


 $ph_sql="select MatriId,ThumbImgs1,PhotoURL1,PhotoProtected from ".$DBNAME['MATRIMONYMS'].".".'photoinfo'." where (PhotoProtected='N' or PhotoProtected is NULL or PhotoProtected='') and  MatriId = '$member_id' ";

$img_count = $db->select($ph_sql);

if($img_count>0){


while($ph_res=$db->fetchArray()){			
 $view_img = "http://imgs.".$domain_value."matrimony.com/photos/".substr($ph_res['MatriId'],1,1)."/".substr($ph_res['MatriId'],2,1)."/".$ph_res['ThumbImgs1'];
}

}

else {

$view_img = "-";

}



$user_name = $member_id;
$password = $password;

$details ="~".$View_Marital.'~'.$view_age.'~'.$view_height.'~'.$View_Religion.'~'.$View_Caste.'~'.$View_SubCaste.'~'.$View_Citizenship.'~'.
$View_Education.'~'.$View_Country.'~'.$View_State.'~'.$View_ResidingCity.'~'.$view_img;

$details = str_replace("'","_",$details);

if($gender == 'M') {

 $full_geder= 'male';
}
else {

$full_geder= 'female';

}


 $insert=file_get_contents("$openfire_server/plugins/userService/userservice?type=add&secret=3YUmKcB9&username=".	$user_name."&password=".$password."&name=".$user_name."&email=".$details."&groups=$evid~$full_geder");

 
}

//




//echo "http://192.168.3.5:9090/plugins/presence/status?jid=all@".$evid.'~'.$sex."&type=text";

$data = file_get_contents($openfire_server."/plugins/presence/status?jid=all@".$evid.'~'.$sex."&type=text");
$data = str_replace('[','',$data);
$data = str_replace(']','',$data);
$data = trim($data);





$EventInfo=get_event_info($evid);
$event_date=$EventInfo['event_date'];
$event_title=$EventInfo['EventTitle'];
$event_starttime=strtolower($EventInfo['event_starttime']);
$event_endtime=strtolower($EventInfo['event_endtime']);
$event_endtimeval=$EventInfo['EventEndTime'];
//if($member_id==""){
//header("location:login.php?evid=$evid");
//}else{
//$endtime_val=date("H:i:s");




?>







<html>
<head>
<META name="description" content="Indian Matrimony - Free Matrimonial - Register for FREE, Bharatmatrimony.com - Free matrimonials add your profile.">
<META name="keywords" content="Indian matrimony, free matrimonial, Add Profile, matrimonials, Telugu, tamil, sindhi, assamese, gujarati, malayalee, hindu, christian, muslim, register profile, matrimonial, add profile, success stories, search profiles, matrimonial website, Indian matrimony, marwadi, oriya, kannada, hindi, Free matrimonials, matrimony, desi match maker, match maker, online matrimony">
<TITLE>Indian Matrimony - Free Matrimonial - Register for FREE</TITLE>
<!-- Jabber client script files-->
<script language="JavaScript" type="text/javascript" src="js/sha1.js"></script>
<script language="JavaScript" type="text/javascript" src="js/xmlextras.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCPacket.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCHttpPollingConnection.js"></script>
<script language="JavaScript" type="text/javascript" src="js/JSJaCHttpBindingConnection.js"></script>

<script language="JavaScript" type="text/javascript" src="omm_search.js"></script>




<style>
.linktxt_blk	{ 
	 display: none;
	}

</style>


<style type="text/css">
#chattooltip{position: absolute;width: 200px;border: 1px solid #E3B79C;padding: 5px;background-color: white;visibility: hidden;z-index: 100;line-height:15px;
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}
</style>
<link rel="stylesheet" href="http://imgs.bharatmatrimony.com/bmstyles/bmstyle.css">


<style>
ul#ommlist {margin:0;padding:0;list-style-type:none;width:auto; display:block;}
ul#ommlist li{ margin:0;background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-gbullet.gif) no-repeat center left; display: float; padding: 5px 5px 2px 10px;margin-top:px;}
</style>
<link rel="stylesheet" href="http://imgs.bharatmatrimony.com/bmstyles/global-style.css"></head>
<body>
<input type="hidden" name="message_cnt" value="" id="message_cnt">
<input type="hidden" value="<?php echo strtolower($_COOKIE['username']);?>" id="username" name="username">
<input type="hidden" value="<?php echo $_COOKIE['password'];?>" id="password" name="password">
<input type="hidden" value="<?php echo $evid;?>" id="evid" name="evid">
<center>
<div id="maincontainer">
	<div id="container">
		
		<div id="rndcorner" class="fleft">
		<div style="float:left;width:772px;">

			<!-- Content Area-1-->
			<div style="width:761px;padding-top:5px;">
			<div class="middiv-pad">		
					<div class="bl"><div class="br"><div class="tl"><div class="tr">
					<div  style="padding:0px 15px 0px 15px !important;padding:1px 15px 0px 15px;">
						<div class="fleft" style="padding-bottom:15px !important;padding-bottom:0px;">
						 <div class="fleft " style="padding: 15px 25px 0px 25px;">
							<div style="background: url(http://<?=$_SERVER[SERVER_NAME];?>/images/omm-top-img.gif) no-repeat; width:470px; height:134px;"></div>
						 </div>
						 
						 <div class="fleft dotline smalltxt" style="padding: 20px 0px 30px 20px;margin-top:20px">
							<div style="width:180px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-orng-arrow.gif" width="4" height="7" hspace="5"/>It is a Virtual Swayamvar<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="8" hspace="5"/><br/>
							<img src="http://imgs.bharatmatrimony.com/bmimages/hp-orng-arrow.gif" width="4" height="7" hspace="5"/>Connect with members of your <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;community from across the world<br/><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="8" hspace="5"/><br/>
							<img src="http://imgs.bharatmatrimony.com/bmimages/hp-orng-arrow.gif" width="4" height="7" hspace="5"/>Chat and Interact real time 
							</div>

						 </div><br clear="all">			
					   </div>
					</div><br clear="all">					
					</div></div>	</div></div>
			</div></div>
			<!-- Content Area-1 }-->
	</div></div>

	<div id="rndcorner" class="fleft">
		<div style="float:left;width:772px;background-color:#EEE">
			<div style="padding-right:25px;" class="fright clr">10 days to Online Matrimony Meet</div><br clear="al">
			<!-- Content Area-1-->
			<div style="width:761px;padding-top:5px;">
			<div class="middiv-pad">		
					<div class="bl"><div class="br"><div class="tl"><div class="tr">
					<div class=" smalltxt clr" style="padding:5px 15px 0px 15px;">
						<div style="padding:15px;">
								<!--{ Content -->
								<div id='tmarea'>
						
								

								
								<!--count down area-->
								<div style="width:680px;line-height:17px;text-align:left;padding-bottom:5px;text-align:right"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="250" height="1"><a href="vmlogout.php?evid=<?=$evid?>" class="linktxt">logout</a></div>
								
								<div style="padding-top:10px;padding-bottom:10px;width:630px;text-align:center">
									
									
									<font style="font-family:arial;font-size:20px;color:#4091C6"><b>Welcome to the <?=$event_title?> Online Matrimony Meet<font style="font-family:arial;font-size:14px;"><sup><b>&copy;</sup></b></font></b></font><br>
									<font style="font-family:verdana;font-size:11px;color:#4091C6">
								</font>
								</div>
								<!--count down area-->
								
								<div style="padding-bottom:10px;"><div style="background-color:#FDEAF0;width:680px"><img src="images/trans.gif" width="1" height="1"></div></div>
								
								
								<table border="0" cellpadding="0" cellspacing="0" width="630" align="center">
								<tr><td valign="top" colspan="3" style="line-height:15px"><font class="normaltxt1">The list of all participating members is displayed below. Please use the scroll to see the complete list of participants. You can search among the participants and identify potential prospects that match your partner criteria and chat with them.</font><br></td></tr>
								
								
								
								
								
								<tr><td valign="top" colspan="3"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="10"></td></tr>
								<tr>
								<td valign="top" width="200">
								<div style='width:230;background-color:#FBEED6;height:20px' ><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="3"><br><font class="normaltxt1">&nbsp;&nbsp;<font color="#9a440d">Do not click <b>refresh</b> while the chat is on</font></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								<div style='width:230;background-color:#FBEED6;height:20px' id="page_link">
								
								
								<!--<font class='normaltxt1'><b><a href="javascript:PagingAjaxCall('20','40','null')" class="linktxt">>></a></b></font>&nbsp;&nbsp;&nbsp;-->
								
								
								</div>
								<div style='width:230;background-color:#FBEED6;height:20px' id="total_users">
								
								</div>
								<input type="hidden" name="start" id="start" value="">
								<input type="hidden" name="end" id="end" value="">
								
								
								
								
								<div id="show_all" style='width:200;background-color:#FBEED6;height:20px;display:none'><font color="#9a440d"><b><a href="javascript:first_call(0,20)" class='linktxt'>Show All</a></b> </font></div>
								
								</td>
								
								
								
								<td valign="top"></td>
								<td valign="middle" bgcolor="#FBEED6" height="20" width="385" class="tbborder" style="border-bottom:0px">
								<font class="normaltxt1"><font color="#9A440D"><b>&nbsp;&nbsp;Search</b></font></font>
								</td>
								</tr>
								<tr>
								<td valign="top" style="border:1px solid #CFE396;width:363px">
									<div id='stripFilter' class="normaltxt1" style='width:360;background-color:#FBEED6;display:none'>Showing results matching your criteria. <a href="javascript:showAllList()" class="linktxt">Click here</a> to view all members online.</div>
									<!--Member Listing-->
									<div id="presence_pane" style="display:none;">
									
									<div style="width:200;height:400px;overflow:auto;" id="searchiResp" name="searchiResp" >
									
									</div>
									<form name="frmUserAct" method="post">
								<input type="hidden" name="ini_chat" value="">
								<input type="hidden" name="send_msg" value="">
								<input type="hidden" name="block_chat" value="">
								<input type="hidden" name="unblock_chat" value="">
								
								<input type="hidden" name="stored_users" id="stored_users" value="">
								<input type="hidden" name="left_users" id="left_users" value="">
								
								
								</form>
								<script language="javascript" type="text/javascript">
									  <!--
									  
								var popWin = new Array();
								var cur_id = '<?php echo $member_id?>';
								var domain_value ='<?php echo $domain_value;?>';
								var data ='<?php echo  $data;?>';
								var evid = '<?php echo $evid; ?>';
								var openfire_server = "192.168.3.5";
								var css_class = '<?php echo $class;?>';
								var opposite_gender='<?php echo $sex;?>';;
								var online_users = new Array();
								
								function htmlEnc(str) {
								  if (!str)
									return null;
								
								  str = str.replace(/&/g,"&amp;");
								  str = str.replace(/</g,"&lt;");
								  str = str.replace(/>/g,"&gt;");
								  str = str.replace(/\"/g,"&quot;");
									str = str.replace(/\n/g,"<br />");
								  return str;
								}
								
								
								var xhr=null; 
								function vm_createajax()
								{
												if (window.XMLHttpRequest) {
													return new XMLHttpRequest();
												} else if(window.ActiveXObject) {
													return new ActiveXObject("Microsoft.XMLHTTP");
												} else {
													alert('Status: Cound not create XmlHttpRequest Object.  Consider upgrading your browser.');
												}
								}
								
								xhr=vm_createajax();
								function AjaxCall(evid,opposite_gender)
								{   		
									if (xhr.readyState == 4 || xhr.readyState == 0) 
									{
									xhr.open('GET', "getdata.php?evid="+evid+"&opposite_gender="+opposite_gender, true);
									xhr.onreadystatechange =launchmsg;
									xhr.send(null);
									}
								
								}
								
								function launchmsg()
								{
									if(xhr.readyState  == 4)
									{
										if(xhr.status  ==200) { //alert(xhr.responseText);
										addingUserArray(xhr.responseText)}
										else 
										{alert("Error code " + xhr.status);}
									}
								}
								
								 function addingUserArray(data)
									{	
										
											 
											 
										 var initialReqData = data.split(',');
										 
										 for(var k=0;k<initialReqData.length;k++)
										{
								
											online_users[k] = initialReqData[k];
											
										
										}
								
									   first_call(0,20);
									   //Total User count
									   document.getElementById("total_users").innerHTML = "<font class='normaltxt1'><b>Total Users("+online_users.length+")</b></font>"; 
									}
									AjaxCall(evid,opposite_gender);
								
								
								 
								
								   
									//Initial user display 0 - 20
									
								
								   function first_call(startRecord,endRecord)
									{   
									   
									   var html ='';
										var online= online_users.toString();
										
										document.getElementById('show_all').style.display = "none";
										document.getElementById('searchiResp').innerHTML = "";
												
								
										if(online_users.length < endRecord )
										{
								
											 document.getElementById("page_link").innerHTML = "";
								
										}
										else if(online_users.length > endRecord && startRecord == 0 )
										{
								
										document.getElementById("page_link").innerHTML = '<font class="normaltxt1"><b><a href="javascript:PagingAjaxCall(\'20\',\'40\',\'null\')" class="linktxt">>></a></b></font>&nbsp;&nbsp;&nbsp;';
								
								
										}
										else
										{
								
								
										}
										
									   startRecord =parseInt(startRecord);
									   endRecord =parseInt(endRecord);
										
										 if(online != '' || online != 'null') { 
												
												for(var i=startRecord;i<endRecord;i++)
												{
												
													   if(endRecord > online_users.length)
														{
								
															  endRecord = online_users.length;
								
														}
								
								
												if(online_users[i] != "") 
													
												{ 
												var first_array = online_users[i].split("#");
												matriId = first_array[0];
								
												var  evid ='<?php echo $evid;?>';
								
												details = first_array[1].split('~');
													
													
													if(details[12] == "-" || details[12] == "" )
													{
								
													details[12] = "http://<?=$_SERVER[SERVER_NAME];?>/images/camera_icon.gif";
													}
												
												if(document.getElementById('stored_users').value == '')  {
								
													document.getElementById('stored_users').value = matriId;            
								
												}
												else { 
								
														   var str=matriId;
								
															if(document.getElementById('stored_users').value.search(str)==-1) { 
								
															document.getElementById('stored_users').value = document.getElementById('stored_users').value+'~'+matriId;
															}
										 
													  
												}
								
												matriId = (matriId).replace(/^\s*|\s*$/g,'');
								
												online_users[i] = (online_users[i]).replace(/^\s*|\s*$/g,'');
										  
												if(matriId !=""  ) {  
													
								
												  document.getElementById("message_cnt").value = eval(parseInt(document.getElementById("message_cnt").value) + 1);
								
													html += "<div id='M-"+matriId+"'>";
													html += "<span id='"+matriId+"'><a href='"+details[12]+"' class='linktxt' target='_blank' onmouseover=ddrivetipImg('"+details[12]+"','','75') onmouseout=hideddrivetip('"+details[12]+"')><img src='"+details[12]+"' width='19' height='14' border='0' ></a>&nbsp;&nbsp;<a href='http://bmser."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId+"' class='linktxt' target='_blank' onmouseover=ddrivetip('"+online_users[i]+"') onmouseout=hideddrivetip('"+online_users[i]+"')><b><font color='#FF3333'>"+matriId+"</font></b></a>&nbsp;&nbsp;"+details[2]+"yrs&nbsp;&nbsp;"+ details[3]+
																	"cm&nbsp;&nbsp;</span>";
													//chat
													html += "<span id='ch-"+matriId+"'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='"+css_class+"'>Chat</a></b>&nbsp;&nbsp;</span>";
													//left the chat
													html += "<span id='lg-"+matriId+"' style='display:none'><font color='#FF0000'><b>left the chat</b></font>&nbsp;&nbsp;</span>";
													//blocked
													html += "<span id='bb-"+matriId+"' style='display:none'><font color='#FF0000'><b>blocked</b></font></span>";
													//Unblock
													html += "<span id='bl-"+matriId+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='linktxt'>Unblock</a></span>";
													html += "</div>";
								
													document.getElementById('searchiResp').innerHTML = html; 
								
													}
												
												
												}
													
												
												}
								
								   
										
										   }
											
								
									}
								
								function handleMessage(aJSJaCPacket) {  
									
									
									var html = '';
										
									var to_name = aJSJaCPacket.getFrom();
									
									var name =to_name.split("@");
									var msg = aJSJaCPacket.getBody(); 
									msg = (msg).replace(/^\s*|\s*$/g,'');
									
									var winind = name[0];
									var id = name[0];
									var evid = document.getElementById("evid").value;
								
								var str="#";
								if(msg.search(str)==-1){ 
								
								var winstat=openPop(winind,id,msg,evid);
								  
								}
								
								else {  
									
										  
											var split_msg = msg.split("$#");
											matriId = split_msg[0].split('@');
											details = split_msg[1].split('~');
											if(details[12] == "-" || details[12] == "")
												{
								
													details[12] = "http://<?=$_SERVER[SERVER_NAME];?>/images/camera_icon.gif";
												}
								
										original_msg1 =  msg.split('@');
								
										original_msg2 =    msg.split('$#');
								
								
								
										var original = original_msg1[0]+"#"+original_msg2[1];
								
										   
											if(split_msg[2] == "logged out!") {
								
											
								
											 matriId = split_msg[0].split('@');
								
											  matriId[0] = (matriId[0]).replace(/^\s*|\s*$/g,'');
											
											
											document.getElementById(eval("'"+"bl-"+matriId[0]+"'")).style.display = 'none';
											document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = 'none';
											document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = '';
											
										  
											
											
											//To replace loggedout id			
											var replace_id = matriId[0];
											var stored_id = document.getElementById('stored_users').value;
											document.getElementById('stored_users').value = stored_id.replace(replace_id, "");
											
										 
										  
										  //To add left users 
								
											if(document.getElementById('left_users').value == '')  {   
								
													document.getElementById('left_users').value = matriId[0];
								
											}
											else  {
								
													
													document.getElementById('left_users').value = document.getElementById('left_users').value +"~"+matriId[0];
								
											}
											
										   //  Removing element from array
											var online = online_users.toString();
								
											for(var i=0;i<=online_users.length-1;i++) {			
													if(online_users[i].search(matriId[0]) != -1) {   
													online_users[i] = 'null';
													}
								
											}
								
										   //
								
											}
											else 	{
								
											//for new array addition
										
											var online = online_users.toString();  
								
											original_msg1 =  msg.split('@');
											original_msg2 =    msg.split('$#');
											
											
											var original = original_msg1[0]+"#"+original_msg2[1];
											
											if(online.search(msg) == -1)
											{  
													
								
								
													 if(online.search("null") == -1)
													 {  
														  //alert('push');
														   online_users.push(original);
								
														//Total User count
														document.getElementById("total_users").innerHTML = "<font class='normaltxt1'><b>Total Users("+online_users.length+")</b></font>"; 
															 //If new user comes under searched criteria
															 if(document.getElementById("show_all").style.display!="none")
															{
															 searchInitiate();
															}
								
													 }
													 else
													{
														 // alert("replace");
															for (var i=0;i<online_users.length-1;i++)
															{
															if(online_users[i]=="null")
															{
															
															
																 online_users[i]=original;
																	   
															break;
															}
															}
								
								
															//If new user comes under searched criteria
																		if(document.getElementById("show_all").style.display!="none")
																		{
																		searchInitiate();
																		}
													}
								
											}
												
											//
								
											
												if(document.getElementById('stored_users').value == '')  {   
								
													document.getElementById('stored_users').value = matriId[0];
													document.getElementById("message_cnt").value = 1;
								
													 if(matriId !=""  && (online=="" || online_users.length < 20)) { 
												   
													
													if(document.getElementById('left_users').value.search(matriId[0])==-1){ 
								
													html += "<div id='M-"+matriId[0]+"'>";
													//matriid
													html += "<span id='"+matriId[0]+"'><a href='"+details[12]+"' class='linktxt' target='_blank' onmouseover=ddrivetipImg('"+details[12]+"','','75') onmouseout=hideddrivetip('"+details[12]+"')><img src='"+details[12]+"' width='19' height='14' border='0' ></a>&nbsp;&nbsp;<a href='http://bmser."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId[0]+"' class='linktxt' target='_blank' onmouseover=ddrivetip('"+original+"') onmouseout=hideddrivetip('"+original+"')><b><font color='#FF3333'>"+matriId[0]+"</font></b></a>&nbsp;&nbsp;"+details[2]+"yrs&nbsp;&nbsp;"+ details[3]+
													"cm&nbsp;&nbsp;</span>";
													//Chat
													html += "<span id='ch-"+matriId[0]+"'><a href=\"javascript:openchat('c-"+matriId[0]+"','"+evid+"');\" class='"+css_class+"'>Chat</a></b>&nbsp;&nbsp;</span>";
													 //left chat
													html += "<span id='lg-"+matriId[0]+"' style='display:none'><font color='#FF0000'><b>left the chat</b></font>&nbsp;&nbsp;</span>";
													//blocked
													html += "<span id='bb-"+matriId[0]+"' style='display:none'><font color='#FF0000'><b>blocked</b></font></span>";
													//unblock
													html += "<span id='bl-"+matriId[0]+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId[0]+"','"+evid+"');\" class='linktxt'>Unblock</a></span>";
													 html += "</div>";
													document.getElementById('searchiResp').innerHTML += html;
													}
													else {
								
													 document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = '';
													document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = 'none';
								
													}
								
								
								
								
								
													}
								
												
								
								
								
								
												}
												else {
								
													
														   var str=matriId[0];
								
															if(document.getElementById('stored_users').value.search(str)==-1) { 
								
															document.getElementById('stored_users').value = document.getElementById('stored_users').value+'~'+matriId[0];
															
															id = matriId[0];
								 
																	if(matriId !="" && (online=="" || online_users.length < 20  || document.getElementById("message_cnt").value <20)) { 
								
																	if(document.getElementById('left_users').value.search(matriId[0])==-1){ 
								
													document.getElementById("message_cnt").value=eval(parseInt(document.getElementById("message_cnt").value) + 1);
								
								
													html += "<div id='M-"+matriId[0]+"'>";
													//matriid
													html += "<span id='"+matriId[0]+"'><a href='"+details[12]+"' class='linktxt' target='_blank' onmouseover=ddrivetipImg('"+details[12]+"','','75') onmouseout=hideddrivetip('"+details[12]+"')><img src='"+details[12]+"' width='19' height='14' border='0' ></a>&nbsp;&nbsp;<a href='http://bmser."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId[0]+"' class='linktxt' target='_blank' onmouseover=ddrivetip('"+original+"') onmouseout=hideddrivetip('"+original+"')><b><font color='#FF3333'>"+matriId[0]+"</font></b></a>&nbsp;&nbsp;"+details[2]+"yrs&nbsp;&nbsp;"+ details[3]+
													"cm&nbsp;&nbsp;</span>";
													//Chat
													html += "<span id='ch-"+matriId[0]+"'><a href=\"javascript:openchat('c-"+matriId[0]+"','"+evid+"');\" class='"+css_class+"'>Chat</a></b>&nbsp;&nbsp;</span>";
													 //left chat
													html += "<span id='lg-"+matriId[0]+"' style='display:none'><font color='#FF0000'><b>left the chat</b></font>&nbsp;&nbsp;</span>";
													//blocked
													html += "<span id='bb-"+matriId[0]+"' style='display:none'><font color='#FF0000'><b>blocked</blocked></span>";
													//unblock
													html += "<span id='bl-"+matriId[0]+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId[0]+"','"+evid+"');\" class='linktxt'>Unblock</a></span>";
													html += "</div>";
													document.getElementById('searchiResp').innerHTML += html;
													}
													else {
								
													 document.getElementById(eval("'"+"ch-"+matriId[0]+"'")).style.display = '';
													document.getElementById(eval("'"+"lg-"+matriId[0]+"'")).style.display = 'none';
								
													}
																	
																	
																	
																	
																	}
								
															}
														  
												}
											
											
											
										
											
											}
								
								
								}
									
								
									if(msg == 'blocked**omm')
									{     
										
										 popWin[winind].blockedflag();
										 msg = "<font color='#0000FF'>This user has been blocked you!!</font>";
										 popWin[winind].setTimeout("writeMsg('"+escape(msg)+"',' ')",1000);
										
										document.getElementById(eval("'"+"ch-"+winind+"'")).style.display = 'none';
										document.getElementById(eval("'"+"bb-"+winind+"'")).style.display = '';
								
										//popWin[winind].close();
								
								
									}
									else if(msg == 'unblocked**omm')
									{    
										
										 popWin[winind].unblockedflag();
										 msg = "<font color='#006600'>This user has been unblocked you.Now you can chat!!</font>";
										 popWin[winind].setTimeout("writeMsg('"+escape(msg)+"',' ')",1000);
								
												document.getElementById(eval("'"+"ch-"+winind+"'")).style.display = '';
												document.getElementById(eval("'"+"bb-"+winind+"'")).style.display = 'none';
								
										//popWin[winind].close();
									}	
									else
									{         
											if(winstat==true )
											{ 
											
											popWin[winind].setTimeout("writeMsg('"+escape(msg)+"',' ')",1000);
											}
									}
									
									
								}
								function chk(matriid)
								{
									if((!popWin[matriid]) || (popWin[matriid].closed))
									{return false;}
									else{return true;}
								}
								function openPop(matriId,id,firstmsg,evid)
								{   
									if((matriId!="") && (matriId!=null))
									{
										if(chk(matriId)==true)
										{
											popWin[matriId].focus();
											return true;
										}
										else
										{   
											addwin(id);
											//var myurl='chatwindow.php?to='+to;
											var myurl="chatwindow.php?recpid="+id+"&msg="+escape(firstmsg)+"&evid="+evid;
								
											popWin[matriId]=window.open(myurl,matriId,"menubar=0,resizable=0,width=498,height=365");
								
											return false;
										}
									}
								}
								function addwin(id)
								{
									if(document.frmUserAct.ini_chat.value!=""){document.frmUserAct.ini_chat.value+="/"+id;}else{document.frmUserAct.ini_chat.value=id;}
								}
								
								function openchat(mid,evid)
								{       
									   
										
									var matid=mid.split('-');
									if(matid[0]!='u')
									{
										var winind=matid[1];
										openPop(winind,matid[1],'',evid);
									}
									else
									{
											
												
													//document.getElementById(uid).innerHTML="<a href=\"javascript:openchat('"+uid+"','"+evid+"')\" //class='linktxt'>Chat</font>";
													document.getElementById(eval("'"+"bl-"+matid[1]+"'")).style.display = 'none';
													document.getElementById(eval("'"+"ch-"+matid[1]+"'")).style.display = '';
													var id=matid[1];
													var unblock_msg = id+"~"+"unblocked**omm";
													sendMsg(unblock_msg);
										
										
									}
									
									
								}
								
								//this function is called from child window
								
								//Block member start**********************************************************
								function addblock(id)
								{   
									
								
									  
										document.getElementById(eval("'"+"bl-"+id+"'")).style.display = '';
										document.getElementById(eval("'"+"ch-"+id+"'")).style.display = 'none';
										var block_msg = id+"~"+"blocked**omm";
										sendMsg(block_msg);
										//popWin[id].close();
								
								
								}
								//Block member end**********************************************************
								
								function sendMsg(newMsg)
								{  
								  
									var newVal =newMsg.split("~");
									sendTo = newVal[0];
									msg = unescape(newVal[1]);
									
									var aMsg = new JSJaCMessage();
									aMsg.setTo(sendTo+"@"+openfire_server);
									aMsg.setBody(msg); 
									
									con.send(aMsg);
								
									startTime = new Date().getTime();
									
									
								}
								
								
								function handleEvent(aJSJaCPacket) {
									document.getElementById('iResp').innerHTML += "IN (raw):<br/>" +htmlEnc(aJSJaCPacket.xml()) + '<hr noshade size="1"/>';
								}
								
								function handleConnected() { 
									
									document.getElementById('presence_pane').style.display = '';
										
									con.send(new JSJaCPresence());
								}  
								
								
								function handleError(e) {
									//document.getElementById('login_err').innerHTML = "Couldn't connect. Please try again...<br />"+ 
										//htmlEnc("Code: "+e.getAttribute('code')+"\nType: "+e.getAttribute('type')+"\nCondition: "+e.firstChild.nodeName); 
								
								alert("Couldn't connect. Please try again...<br />"+"Error Code: "+e.getAttribute('code')+"\nType: "+e.getAttribute('type')+"\nCondition: "+e.firstChild.nodeName+"<br />"+"Please Contact Administrator");
								
								
								}
								
								function doLogin() {  
								
									try {
								
										// setup args for contructor
										oArgs = new Object();
										oArgs.httpbase = "http://matrimonymeet.bharatmatrimony.com/http-bind/";
										oArgs.timerval = 2000;
								
										if (typeof(oDbg) != 'undefined')
											oArgs.oDbg = oDbg;
										
											con = new JSJaCHttpBindingConnection(oArgs);
								
										con.registerHandler('message',handleMessage);
										con.registerHandler('iq',handleEvent);
										con.registerHandler('onconnect',handleConnected);
										con.registerHandler('onerror',handleError);
										// setup args for connect method
										oArgs = new Object();
										oArgs.domain = openfire_server;
										oArgs.username = document.getElementById('username').value;
										oArgs.resource = 'BM_Messenger';
										oArgs.pass = document.getElementById('password').value;
										con.connect(oArgs);
										
									} catch (e) {
										//document.getElementById('login_err').innerHTML = e.toString();
									} finally {
										return false;
									}
								}
								 
								
								function init() {
									
									//Jabber entry call
									doLogin();
								
								
								
									if (typeof(Debugger) == 'function') {
										oDbg = new Debugger(4,'simpleclient');
										oDbg.start();
									}
								}
								onload = init;
								
								onunload = function() { 
								
								
								if (typeof(con) != 'undefined' && con.disconnect) con.disconnect(); 
								
								
								};
								
								
								
											//-->
										
								</script>
									<script language="javascript">
								
								var xmlHttp
								
								function PagingAjaxCall(start,end,search)
								{
									//To reset message count per page
									document.getElementById("message_cnt").value ="";
								xmlHttp=GetXmlHttpObject()
								if (xmlHttp==null)
								{
								alert ("Your browser does not support AJAX!");
								return;
								}
								
								if(search=="" || search=="null")
								{
								first_call(start,end);
								var url="paging.php?start="+start+"&end="+end+"&total="+online_users.length+"&search=null";
								
								}
								else
								{
								showSearchResults(search,start,end);
								var url="paging.php?start="+start+"&end="+end+"&total="+online_users.length+"&search="+search; 
								
								}
								//alert(url);
								xmlHttp.onreadystatechange=stateChanged;
								
								xmlHttp.open("GET",url,true);
								xmlHttp.send(null);
								//document.getElementById('siteLoader').style.display = 'block';
								
								}
								function stateChanged()
								{
								if (xmlHttp.readyState==4)
								{          //alert(xmlHttp.responseText);
										document.getElementById("page_link").innerHTML = xmlHttp.responseText; 
								
								}
								
								}
								
								function GetXmlHttpObject()
								{
								var xmlHttp=null;
								try
								{
								// Firefox, Opera 8.0+, Safari
								xmlHttp=new XMLHttpRequest();
								}
								catch (e)
								{
								// Internet Explorer
								try
								{
								xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
								}
								catch (e)
								{
								xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
								}
								}
								
								return xmlHttp;
								
								}
								
								</script>
								
								
									</div>
									<!--Member Listing-->	
								</td>
								<td valign="top"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="10" height="1"></td>
								<td valign="top" class="tbborder" width="385">
								<!--Search Form-->
									<? include_once "chatsearchform.php";?>
								<!--Search Form-->
								</td></tr></table>
								</div>
							<!-- content }-->	
						</div>						 
					</div><br clear="all">					
					</div></div>	</div></div>
			</div></div>
			<!-- Content Area-1 }-->
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div></div>

	</div>
</div><br clear="all">
</center>
</body>
<div id="chattooltip"></div>
  

<script>
var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["chattooltip"] : document.getElementById? document.getElementById("chattooltip") : "";

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(msg_str){  
					
					
				//alert(msg_str);
					var tip_msg = msg_str.split("#");
					tip_details = tip_msg[1].split('~');
				    age = tip_details[2];
                    height = tip_details[3];
                    religion  = tip_details[4];
                    caste  = tip_details[5];
                    subcaste  = tip_details[6];
                   tip_location  = tip_details[7]+tip_details[8]+tip_details[9];
                   education = tip_details[7];

				

chattooltip.innerHTML="<font style='font-family:verdana;font-size:11px'><b><font color='#E45103'>"+tip_msg[0]+"</font><br>Age: </b>"+age+"yrs <b>Height: </b>"+height+"<br><b>Religion: </b>"+religion+"-"+caste+"-"+subcaste+"<br><b>Location: </b>"+
tip_location+"<br><b>Education: </b>"+education+"<br><b>Occupation: </b>"+'--'+"</font>";

//alert(chattooltip.innerHTML);
if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
	//memdet="<div><img src='http://imgs.bharatmatrimony.com/bmimages/loading_new.gif'></div>";
	//tipobj.innerHTML=memdet;
	enabletip=true
	return false
	}

}
function ddrivetipImg(thetext, thecolor, thewidth){
				chattooltip.innerHTML="<IMG src='"+thetext+"' border='0'>";

if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
	//memdet="<div><img src='http://imgs.bharatmatrimony.com/bmimages/loading_new.gif'></div>";
	//tipobj.innerHTML=memdet;
	enabletip=true
	return false
	}

}
function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+75+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint-10+"px"
else
tipobj.style.top=curY+offsetypoint-10+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}
document.onmousemove=positiontip;



/* function ss() {  
var online = online_users.toString();
alert(online);
 



}*/

//setInterval("ss();", 5000);





function searchInitiate() {

		
		
		if(document.getElementById('SUBCASTE').value == "")
	     {

           var subcaste = 'Any';
		 
		 }
	
	var basicQuery=subcaste+"~"+document.getElementById('CITIZENSHIP1').value;




	var heightQuery = document.getElementById('STHEIGHT').value+'~'+document.getElementById('ENDHEIGHT').value;
     var ageQuery = document.getElementById('STAGE').value+'~'+document.getElementById('ENDAGE').value;
	var countryQuery;

	 //alert(document.getElementById('COUNTRY1').value);

		var r = new Array();
		var COUNTRY1 = document.getElementById('COUNTRY1');
		for (var i = 0; i < COUNTRY1.options.length; i++)
		if (COUNTRY1.options[i].selected)
		r[r.length] = COUNTRY1.options[i].value;
        
		countryQuery = "";
		for(var a=0;a<r.length;a++)
     	{
             

            if(a != r.length-1) {
			 countryQuery += r[a]+"~" ;

			}
			else
            {

              countryQuery += r[a];
                 
			}


	    }
         
      var eduQuery;

       var EDUCATION1 = document.getElementById('EDUCATION1');
       var r = new Array();
		for (var i = 0; i < EDUCATION1.options.length; i++)
		if (EDUCATION1.options[i].selected)
		r[r.length] = EDUCATION1.options[i].value;
        
		eduQuery = "";
		for(var a=0;a<r.length;a++)
     	{
             

            if(a != r.length-1) {
			 eduQuery += r[a]+"~" ;

			}
			else
            {

              eduQuery += r[a];
                 
			}


	    }
         

           var maritalQuery='';


			if(document.getElementById("MARITAL_STATUS1").checked != false)
			{

			maritalQuery =  document.getElementById("MARITAL_STATUS1").value+'~';

			}
			 if(document.getElementById("MARITAL_STATUS2").checked != false)
			{

			maritalQuery +=  document.getElementById("MARITAL_STATUS2").value+'~';

			}
			 if(document.getElementById("MARITAL_STATUS3").checked != false)
			{

			maritalQuery +=  document.getElementById("MARITAL_STATUS3").value+'~';

			}
			 if(document.getElementById("MARITAL_STATUS4").checked != false)
			{

			maritalQuery +=  document.getElementById("MARITAL_STATUS4").value+'~';

			}
			 if(document.getElementById("MARITAL_STATUS5").checked != false)
			{

			maritalQuery +=  document.getElementById("MARITAL_STATUS5").value+'~';

			}


	
		
	    maritalQuery = maritalQuery.substring(0,maritalQuery.length-1);
		
		
		var wPhotoQuery = 'no';

        
          if(document.getElementById("PHOTO_OPT").checked != false)
			{

			wPhotoQuery =  'Yes';

			}

var rQuery = "false";

 /*var RELIGION = document.getElementById('RELIGION');
       var r = new Array();
		for (var i = 0; i < RELIGION.options.length; i++)
		if (RELIGION.options[i].selected)
		r[r.length] = RELIGION.options[i].value;
        
		rQuery = "";
		for(var a=0;a<r.length;a++)
     	{
             

            if(a != r.length-1) {
			 rQuery += r[a]+"~" ;

			}
			else
            {

              rQuery += r[a];
                 
			}


	    }*/

		var citizenQuery = "any";

var CITIZENSHIP1 = document.getElementById('CITIZENSHIP1');
       var r = new Array();
		for (var i = 0; i < CITIZENSHIP1.options.length; i++)
		if (CITIZENSHIP1.options[i].selected)
		r[r.length] = CITIZENSHIP1.options[i].value;
        
		citizenQuery = "";
		for(var a=0;a<r.length;a++)
     	{
             

            if(a != r.length-1) {
			 citizenQuery += r[a]+"~" ;

			}
			else
            {

              citizenQuery += r[a];
                 
			}


	    }


var subcasteQuery = "any";

if(document.getElementById("SUBCASTE").value!="")
	{

subcasteQuery = document.getElementById("SUBCASTE").value;
	}

var search = "";
	

search = searchMembers( online_users, rQuery, ageQuery, heightQuery, citizenQuery, countryQuery, eduQuery, maritalQuery, wPhotoQuery, subcasteQuery)

if(search == "null")
{

document.getElementById('searchiResp').innerHTML="No Records Found";
document.getElementById('page_link').innerHTML="";


}
else
{

PagingAjaxCall(0,20,search);

}
document.getElementById('show_all').style.display="";


}


function showSearchResults(search,startRecord,endRecord)
{

    
		search = search.toString();
		startRecord =parseInt(startRecord);

		endRecord =parseInt(endRecord);
		str_search = search.split(',');
    

     if(search!="") {
document.getElementById('searchiResp').innerHTML = "";
	for(var i=startRecord;i<endRecord;i++)
    {   

		 if(endRecord > online_users.length)
					{

                          endRecord = online_users.length;

					}
 
               var html ='';
			   search_array = online_users[str_search[i]];

                
				var first_array = search_array.split("#");
				matriId = first_array[0];




				var  evid ='<?php echo $evid;?>';

				details = first_array[1].split('~');
				   	if(details[12] == "-" || details[12] == "")
				{

                    details[12] = "http://<?=$_SERVER[SERVER_NAME];?>/images/camera_icon.gif";
				}

				if(matriId !=""  ) {  
					html += "<div id='M-"+matriId+"'>";
					html += "<span id='"+matriId+"'><a href='"+details[12]+"' class='linktxt' target='_blank' onmouseover=ddrivetipImg('"+details[12]+"','','75') onmouseout=hideddrivetip('"+details[12]+"')><img src='"+details[12]+"' width='19' height='14' border='0' ></a>&nbsp;&nbsp;<a href='http://bmser."+domain_value+"matrimony.com/profiledetail/viewprofile.php?id="+matriId+"' class='linktxt' target='_blank' onmouseover=ddrivetip('"+search_array+"') onmouseout=hideddrivetip('"+search_array+"')><b><font color='#FF3333'>"+matriId+"</font></b></a>&nbsp;&nbsp;"+details[2]+"yrs&nbsp;&nbsp;"+ details[3]+
									"cm&nbsp;&nbsp;</span>";
					//chat
					html += "<span id='ch-"+matriId+"'><a href=\"javascript:openchat('c-"+matriId+"','"+evid+"');\" class='"+css_class+"'>Chat</a></b>&nbsp;&nbsp;</span>";
					//left the chat
					html += "<span id='lg-"+matriId+"' style='display:none'><font color='#FF0000'><b>left the chat</b></font>&nbsp;&nbsp;</span>";
					//blocked
					html += "<span id='bb-"+matriId+"' style='display:none'><font color='#FF0000'><b>blocked</b></font></span>";
					//Unblock
					html += "<span id='bl-"+matriId+"' style='display:none'><a href=\"javascript:openchat('u-"+matriId+"','"+evid+"');\" class='linktxt'>Unblock</a></span>";
					html += "</div>";

					document.getElementById('searchiResp').innerHTML += html;

					}

	}
		   }





}




//For idle test

var startTime;
var endTime;
var intId;


intId = setInterval("detectIdle()", 60000);


function detectIdle(){ 

endTime = new Date().getTime();
if( ( endTime - startTime ) > 15000)
{
	clearInterval(intId);
     sendDummyMsg();
      startTime = new Date().getTime();
   //  window.clearInterval( intId );
   intId = setInterval("detectIdle()", 5000);
}
    endTime = 0;
return;
}

function sendDummyMsg() { 

newMsg = 'dclient'+'~'+'dummy_msg';


sendMsg(newMsg);
startTime = new Date().getTime();
}





//setInterval("alert(document.getElementById('message_cnt').value)","10000")








</script>
</html><script src="http://server.bharatmatrimony.com/campaign/Aff_client_track.php?matriid=M1366899"></script>

