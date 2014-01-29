<?php

 if($gender == 'M') {
 $sex = 'female';
 }
 else {
 $sex = 'male';
 }

//Jabber Insertion
$varCondition		= " where MatriId = '$member_id'";
$varFields			=  array('MatriId','Name','communityId','Age','Height','Religion','CasteId','SubcasteId','Caste_Nobar','Residing_State','Country','Education_Category','Education_Detail','Occupation_Detail','Residing_Area','Residing_District','Residing_City','Occupation','Photo_Set_Status','Protect_Photo_Set_Status','Citizenship','Marital_Status','Paid_Status');
$profile_res_array	= $objSlave->select($varTable['MEMBERINFO'],$varFields,$varCondition,1);

$arrEducationList		 = array(1=>"Bachelors - Engineering/ Computers",2=>"Masters - Engineering/ Computers",3=>"Bachelors - Arts/ Science/ Commerce/ Others",4=>"Masters - Arts/ Science/ Commerce/ Others",5=>"Management - BBA/ MBA/ Others",6=>"Medicine - General/ Dental/ Surgeon/ Others",7=>"Legal - BL/ ML/ LLB/ LLM/ Others",8=>"Service - IAS/ IPS/ Others",9=>"Phd",10=>"Diploma",11=>"Higher Secondary/ Secondary");

if(!empty($profile_res_array)){
$i= 0;

//for chat link display fro paid/free members
$entry_type  = $profile_res_array[$i]['Paid_Status']?'R':'F';
if($entry_type == "F") {
 $url = "http://www.".$varDomainName."/payment/";
}
else
{
$url = "chat";
}
	if($profile_res_array[$i]['Name']!="") 	{
		$view_name = $profile_res_array[$i]['Name'];
		$view_name = str_replace(",","_",$view_name);
		$view_name = str_replace("&","_",$view_name);
		$view_name = str_replace("#","_",$view_name);
		$view_name = str_replace("~","_",$view_name);
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

 $view_height =$profile_res_array[$i]['Height']; 
 if($view_height!="") 	{
		 $view_height = str_replace(" ","_",$view_height);
	}
	else { 
		 $view_height = "-";
		}
$view_height  = trim($view_height );

//$View_Religion = getfromarryhash ('RELIGIONHASH',$profile_res_array[$i]['Religion']);
$View_Religion = $arrReligionList[$profile_res_array[$i]['Religion']];

if($View_Religion !="") 	{
		 $View_Religion = str_replace(" ","_",$View_Religion);
	}
	else { 
		 $View_Religion = "-";
	   	}

	//$View_Caste = getfromarryhash ('CASTEHASH',$profile_res_array[$i]['CasteId']);
	 $View_Caste = $arrReligionCasteMap[$profile_res_array[$i]['Religion']][$profile_res_array[$i]['CasteId']];
	 if($View_Caste!="") 	{
		$View_Caste = str_replace(" ","_",$View_Caste);
		$View_Caste = str_replace(",","_",$View_Caste);
		$View_Caste = str_replace("&","_",$View_Caste);
		$View_Caste = str_replace("#","_",$View_Caste);
		$View_Caste = str_replace("~","_",$View_Caste);
	}
	else { 
		 $View_Caste = "-";
		}
	
	$View_SubCaste = $arrGetSubcasteOption[$profile_res_array[$i]['SubcasteId']];
	 if($View_SubCaste!="") 	{
		 $View_SubCaste = str_replace(" ","_",$View_SubCaste);
		 $View_SubCaste = str_replace(",","_",$View_SubCaste);
		$View_SubCaste = str_replace("&","_",$View_SubCaste);
		$View_SubCaste = str_replace("#","_",$View_SubCaste);
		$View_SubCaste = str_replace("~","_",$View_SubCaste);
	}
	else { 
		 $View_SubCaste = "-";
		}
    if($profile_res_array[$i]['Country'] == "98" ) {
	// Profile Country Living in is India. Take from ResidingState
	//$View_State = getfromarryhash ('RESIDINGINDIANAMES',$profile_res_array[$i]['Residing_State']); 
	$View_State = $arrResidingStateList[$profile_res_array[$i]['Residing_State']];
	$View_StateSta = $residingCityStateMappingList[$profile_res_array[$i]['Residing_State']];
	}
	elseif($profile_res_array[$i]['Country']=="222") {
	// Profile Country Living in is USA. Take from ResidingState
    	//$View_State = getfromarryhash ('RESIDINGUSANAMES',$profile_res_array[$i]['Residing_State']); 
		$View_State = $arrUSAStateList[$profile_res_array[$i]['Residing_State']]; 
		
		}
	  else  {
	// Profile Country living in is anything else take ResidingArea
        	$View_State = $profile_res_array[$i]['Residing_Area']; 
			}

		if($View_State!="") 	{
		 $View_State = str_replace(" ","_",$View_State);
		 $View_State = str_replace(",","_",$View_State);
		$View_State = str_replace("&","_",$View_State);
		$View_State = str_replace("#","_",$View_State);
		$View_State = str_replace("~","_",$View_State);
	}
	else { 
		 $View_State = "-";
		}

    if($profile_res_array[$i]['Country'] == "98") { 
    // If ResidingCity is India then take ResidingDistrict.
	//$View_ResidingCity =  getfromarryhash ('CITY',$profile_res_array[$i]['Residing_District']); 
	  $varCityArr		= ${$View_StateSta};
	  $View_ResidingCity =  $varCityArr[$profile_res_array[$i]['Residing_District']];
	}
	else {
	// For Other countries take ResidingCity
     	$View_ResidingCity = $profile_res_array[$i]['Residing_City']; 
		}
    if($View_ResidingCity!="") 	{
		$View_ResidingCity = str_replace(" ","_",$View_ResidingCity);
		$View_ResidingCity = str_replace(",","_",$View_ResidingCity);
		$View_ResidingCity = str_replace("&","_",$View_ResidingCity);
		$View_ResidingCity = str_replace("#","_",$View_ResidingCity);
		$View_ResidingCity = str_replace("~","_",$View_ResidingCity);
	}
	else { 
		 $View_ResidingCity = "-";
		}

//$View_Education = getfromarryhash ('EDUCATIONHASH',$profile_res_array[$i]['Education_Category']);
 $View_Education = $arrEducationList[$profile_res_array[$i]['Education_Category']];
 if($View_Education!="") 	{
		$View_Education = str_replace(" ","_",$View_Education);
		$View_Education = str_replace(",","_",$View_Education);
		$View_Education = str_replace("&","_",$View_Education);
		$View_Education = str_replace("#","_",$View_Education);
		$View_Education = str_replace("~","_",$View_Education);
	}
	else { 
		 $View_Education = "-";
		}
//$View_Citizenship = getfromarryhash ('COUNTRYHASH',$profile_res_array[$i]['Citizenship']);
  $View_Citizenship = $arrCountryList[$profile_res_array[$i]['Citizenship']];

 if($View_Citizenship!="") 	{
		$View_Citizenship = str_replace(" ","_",$View_Citizenship);
		$View_Citizenship = str_replace(",","_",$View_Citizenship);
		$View_Citizenship = str_replace("&","_",$View_Citizenship);
		$View_Citizenship = str_replace("#","_",$View_Citizenship);
		$View_Citizenship = str_replace("~","_",$View_Citizenship);
	}
	else { 
		 $View_Citizenship = "-";
		 }

//$View_Country = getfromarryhash ('COUNTRYHASH',$profile_res_array[$i]['Country']);
 $View_Country = $arrCountryList[$profile_res_array[$i]['Country']];

 if($View_Country!="") 	{
		$View_Country = str_replace(" ","_",$View_Country);
		$View_Country = str_replace(",","_",$View_Country);
		$View_Country = str_replace("&","_",$View_Country);
		$View_Country = str_replace("#","_",$View_Country);
		$View_Country = str_replace("~","_",$View_Country);
	}
	else { 
		 $View_Country = "-";
		}

//$View_Marital = getfromarryhash ('MARITALSTATUSHASH',$profile_res_array[$i]['Marital_Status']); 
$View_Marital = $arrMaritalList[$profile_res_array[$i]['Marital_Status']]; 

if($View_Marital!="") 	{
$View_Marital =  str_replace(" ","_",$View_Marital);
}
else { 
$View_Marital = "-";
}

/*$View_Occupationtext = $profile_res_array[$i]['Occupation']; 
$View_OccupationSelected = $OCCUPATIONLIST [$profile_res_array[$i]['Occupation_Detail']];*/
$View_Occupationtext = $arrOccupationList[$profile_res_array[$i]['Occupation']]; 
$View_OccupationSelected = $profile_res_array[$i]['Occupation_Detail']; 
		 if(trim($View_OccupationSelected)!="") 	{

		 $View_Occupation = str_replace(" ","_",$View_OccupationSelected);
		 if(trim($View_Occupationtext)!="")
			 {
			 // Appending Occupation in detail
			 $View_Occupation.="_".str_replace(" ","_",$View_Occupationtext);
			 }
		$View_Occupation = str_replace(",","_",$View_Occupation);
		$View_Occupation = str_replace("&","_",$View_Occupation);
		$View_Occupation = str_replace("#","_",$View_Occupation);
		$View_Occupation = str_replace("~","_",$View_Occupation);
	}
	else { 
		 $View_Occupation = "-";
		}


if(($profile_res_array[$i]['Photo_Set_Status'] == 1)&&($profile_res_array[$i]['Protect_Photo_Set_Status'] == 0))
	{
// PhotoAvailable and Not Protected

$varCondition		= " where MatriId = '$member_id' and (Photo_Protected=0 or Photo_Protected is NULL or Photo_Protected='') and  (Photo_Status1=0 or Photo_Status1=1)";
$varFields			=  array('MatriId','Normal_Photo1','Thumb_Small_Photo1','Photo_Protected');
$img_count	        = $objSlave->select($varTable['MEMBERPHOTOINFO'],$varFields,$varCondition,1);

if(!empty($img_count)){

if(trim($img_count[0]['Normal_Photo1'])!="")
	{

	$varMatriIdPrefix	= substr($member_id, 0, 3);
	$varCommunityFolder	= $arrFolderNames[$varMatriIdPrefix];
	//Communitymatrimony photo path
	$view_img			= 'http://img.'.$varDomainName.'/membersphoto/'.$varCommunityFolder.'/'.$member_id{3}.'/'.$member_id{4}.'/'.$img_count[0]['Normal_Photo1'];
	}
	else
	{
		// Thumb url empty display blank
		$view_img = "-";
	}
}
else {
$view_img = "-";
}
	}
	else
	{
// Photo Available = 0
$view_img = "-";
	}
$user_name = $member_id;
$password = $password;
// Append details for posting
$details ="~".$View_Marital.'~'.$view_age.'~'.$view_height.'~'.$View_Religion.'~'.$View_Caste.'~'.$View_SubCaste.'~'.$View_Citizenship.'~'.
$View_Education.'~'.$View_Country.'~'.$View_State.'~'.$View_ResidingCity.'~'.$view_img.'~'.$View_Occupation;

$details = str_replace("&","and",$details);
$details = str_replace("'","_",$details);
$details = str_replace(" ","_",$details);
$details = str_replace(",","_",$details);
$details = trim($details);

if($gender == 'M') {
 $full_geder= 'male';
}
else {
$full_geder= 'female';
}

//Jabber Insertion
//$insert=file_get_contents("$openfire_server/plugins/userService/userservice?type=add&secret=3YUmKcB9&username=".$user_name."&password=".$password."&name=".$user_name."&email=".$details."&groups=$evid~$full_geder");

$POSTURL="$openfire_server/plugins/userService/userservice";
$POSTVARS="type=add&secret=mWJUdOHH&username=".$user_name."&password=".$password."&name=".$evid."&email=".$details."&groups=$evid~$full_geder";
//$POSTVARS="type=add&secret=mWJUdOHH&username=".$user_name."&password=".$user_name."&name=".$evid."&email=".$details."&groups=$evid~$full_geder";
//echo "usr ser : ".$POSTVARS;exit;
 $ch="";
 $ch = curl_init($POSTURL);
 curl_setopt($ch, CURLOPT_POST,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTVARS);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
 curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
 $insert = curl_exec($ch);


// Check for user OK or existing already.  
 if((stristr($insert,"ok")==FALSE)&&(stristr($insert,"UserAlreadyExistsException")==FALSE))
 {
 header("Location:vmlogin.php?evid=$evid&errorcode=5");
 exit;
 }

}
?>