<?

//////////Commununity Files//////////////
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
//include_once($varBaseRoot.'/conf/emailsconfig.cil14');
//include_once($varBaseRoot.'/conf/domainlist.cil14');
//include_once($varBaseRoot.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsRMDB.php');
//include_once $varRootBasePath."/bmlib/bmgenericfunctions.cil14";
include_once $varRootBasePath."/lib/clsPrivilegeCommon.php";
include_once($varRootBasePath.'/conf/wsconf.cil14');                                    
include_once($varRootBasePath.'/lib/clsWSMemcacheClient.php');
/////////////////////////////////////////
class rmclassname extends DB
{
	var $username;
	var $password;
	var $slave;
	var $master;
	
	function init() {
		$this->username = '';
		$this->password = '';
		$this->slave  = '';
		$this->master = '';
	}

	function rmConnect() {
		/*$dbname='cbsrminterface';
		global $dbhost,$dbusername,$dbpassword,$dbname;
		db::connect($dbhost,$dbusername,$dbpassword,$dbname);*/

		$objdbclass	= new rmclassname;
        $objdbclass->dbConnect('S',$varDbInfo['DATABASE']);

        $masterobjdbclass	= new rmclassname;
        $masterobjdbclass->dbConnect('M',$varDbInfo['DATABASE']);

		$this->slave=$objdbclass;
		$this->master=$masterobjdbclass;
        
	}

	function loginvalidation(){
		global $TABLE,$varCbsRminterfaceDbInfo;
		/*$Query="Select RMUserid from  ".$TABLE['RMLOGININFO']."  where RMUserid='".$this->username."' and Password='".$this->password."'  and Activate=1";*/

		$varActFields	= array("RMUserid");
		$varActCondtn	= " where RMUserid='".$this->username."' and Password='".$this->password."'  and Activate=1";
		$varActInf		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
        if(!empty($varActInf)){
			$lastadid=1;
		}else{
			$lastadid=0;
		}
		
		return $lastadid;
	}
	
	function getrmid(){
		global $TABLE,$varCbsRminterfaceDbInfo;
		/*echo $Query="Select RMUserid from  ".$TABLE['RMLOGININFO']."  where  Email='".$this->username."' and Password='".$this->password."'  and Activate=1";
		$lastadid = db::select($Query);
		$row = db::fetchArray();*/
		$varActFields	= array("RMUserid");
		$varActCondtn	= " where  Email='".$this->username."' and Password='".$this->password."'  and Activate=1";
		$varActInf		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
		return $varActInf[0]['RMUserid'];
	}


	function Getmemberpassword($username){
		global $TABLE,$varCbsRminterfaceDbInfo;
		/*$Query="Select Password from  ".$TABLE['RMLOGININFO']."  where RMUserid='".$username."'";
		$lastadid = db::select($Query);
		$userid = db::fetchArray();
		$Password=$userid['Password'];*/
		$varActFields	= array("Password");
		$varActCondtn	= " where RMUserid='".$username."'";
		$varActInf		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);

	   	return $varActInf[0]['Password'];
	}
	
	function Showmembername($rmid){
		global $TABLE,$varCbsRminterfaceDbInfo;
		/*$Query="Select Name from  ".$TABLE['RMLOGININFO']."  where RMUserid='".$rmid."'";
		$lastadid = db::select($Query);
		$row = db::fetchArray();*/
		$varActFields	= array("Name");
		$varActCondtn	= " where RMUserid='".$rmid."'";
		$row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
		return $row[0]['Name'];
	}


	function Showmemberlist($rmusername){
		global $TABLE,$varCbsRminterfaceDbInfo;
		/*$Query="Select MatriId,MemberName,ValidDays,PrivStatus,TimeCreated,ExpiryDate from ".$TABLE['RMMEMBERINFO']." where RMUserid='".$rmusername."'";
		db::select($Query);*/
		$varActFields	= array("MatriId","MemberName","ValidDays","PrivStatus","ExpiryDate","TimeCreated");
		$varActCondtn	= " where RMUserid='".$rmusername."'";
		$rows		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
		
		$cnt=0;
		foreach($rows as $key=>$searchlist){
			$searchlistarr[$cnt][0] = $searchlist['MatriId'];
			$searchlistarr[$cnt][1] = $searchlist['MemberName'];
			$searchlistarr[$cnt][2] = $searchlist['ValidDays'];
			$searchlistarr[$cnt][3] = $searchlist['PrivStatus'];
			$searchlistarr[$cnt][4] = $searchlist['TimeCreated'];
			$searchlistarr[$cnt][5] = $searchlist['ExpiryDate'];
			$cnt++;
		}
		return $searchlistarr;
	}

	function InsertRmlogininfo($userid,$email,$phoneno,$mobileno,$password){
		global $TABLE;		
		$InsertQuery="Insert Into ".$TABLE['RMLOGININFO']." (RMUserid,Password,Email,Phone,Mobile,Activate,TimeCreated) values('".$userid."','".$password."','".$email."','".$phoneno."',".$mobileno.",1,NOW())";		
		db::insert($InsertQuery);		
	   	return;
	}

	function RMUserlog($rmuserid,$matriid,$privstatus){
		global $TABLE,$varCbsRminterfaceDbInfo;	
		/*$InsertQuery="Insert Into ".$TABLE['RMMEMBERLOG']." (RMUserid,MatriId,PrivStatus,TimeLogin) values('$rmuserid','$matriid',$privstatus,NOW())";		
		db::insert($InsertQuery);	*/
		$varInsertFields	= array("RMUserid","MatriId","PrivStatus","TimeLogin");
	    $varInsertVal	= array("'".$rmuserid."'","'".$matriid."'",$privstatus,'NOW()');
	    $insertedid = $this->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERLOG'], $varInsertFields, $varInsertVal);

	}	

	function ContactInfobkup($matriid,$profiletable,$slaveconn){
		global $TABLE;
		/*$Query="Select Phone_Verified from ".$profiletable." where MatriId='".$matriid."'";
		$num=$slaveconn->select($Query);
		$row = $slaveconn->fetchArray();*/
        
		$varActFields	= array("Phone_Verified");
	    $varActCondtn	= " where MatriId='".$matriid."'";
	    $row		= $slaveconn->select($profiletable,$varActFields,$varActCondtn,1);

		if(!empty($row))
			$phoneverify = $row[0]['Phone_Verified'];
		else 
			$phoneverify = 2;
		return $phoneverify;
	}
	
	function RMPhoneSummary($matriid,$rmuser,$from,$to){
	 global $TABLE;	
	 $Query="select OppositeMatriId,RmUserId,MatriId,DateViewed from ".$TABLE['RMVIEWPHONELOG']." where MatriId='$matriid' and RmUserId='$rmuser' and date(DateViewed)>=$from and $to<=date(DateViewed)"; 
	 $execute=mysql_query($Query);
	 return $execute;
	}

	function RMPhoneSumByLimit($matriid,$rmuser,$from,$to,$start,$end){
	 global $TABLE;	
	 $Query="select OppositeMatriId,RmUserId,MatriId,DateViewed from ".$TABLE['RMVIEWPHONELOG']." where MatriId='$matriid' and RmUserId='$rmuser' and date(DateViewed)>=$from and $to<=date(DateViewed) limit $start,$end"; 
	 $execute=mysql_query($Query);
	 return $execute;
	}

	//Partner Preference
	function userlist($rmuser) {
		global $TABLE;	
		 $UserSql="Select MatriId from ".$TABLE['RMMEMBERINFO']." where RMUserid='".$rmuser."' order by MatriId";
		 db::select($UserSql);
		while($searchlist = db::fetchArray()){
			$generateqry.="'".$searchlist['MatriId']."',";
			
		}
		 return $generateqry;
	}

	function userpartnerlist($matrilist) { //Return the user preference status for matriid
		 global $DBNAME,$TABLE,$varTable;
		 /*$Sql="Select MatriId,PartnerPrefSet from ".$DBNAME['MATRIMONYMS'].".".$TABLE['MATRIMONYPROFILE']." where MatriId IN(".substr($matrilist,0,strlen($matrilist)-1).") order by MatriId";*/

		 $Sql="Select MatriId,Partner_Set_Status from ".$DBNAME['COMMUNITYMATRIMONY'].".".$varTable['MEMBERINFO']." where MatriId IN(".substr($matrilist,0,strlen($matrilist)-1).") order by MatriId";
		 db::select($Sql);
		 $cnt=0;
		while($partner = db::fetchArray()){
				$partnerarr[$cnt][0] = $partner['MatriId'];
				$partnerarr[$cnt][1] = $partner['Partner_Set_Status'];
				$cnt++;
		}
		return $partnerarr;

	}

	function mempartnerpref($rmuserid,$matriid,$message){ 
		 global $TABLE,$varCbsRminterfaceDbInfo;	

		 /*$InsertQuery="Insert Into ".$TABLE['MEMPARTNERPREF']." (RMUserid,MatriId,Message,Status,TimeCreated) values('".$rmuserid."','".$matriid."','".mysql_real_escape_string($message)."',1,NOW())";		
		 db::insert($InsertQuery);*/

         $varInsertFields	= array("RMUserid","MatriId","Message","Status","TimeCreated");
	     $varInsertVal	= array("'".$rmuserid."'","'".$matriid."'","'".mysql_real_escape_string($message)."'",1,'NOW()');
	     $insertedid = $this->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'], $varInsertFields, $varInsertVal);

         
		 //$this->sendmailtopartner($rmuserid,$matriid,$message);
		 return;
	}

	function sendmailtopartner($rmuserid,$matriid,$message) {	//send the mail partner preference member
	  global $TABLE,$DBNAME;
	  
	  $arrBasicView=fnMailerBasicView($matriid);
	  
	  $sHtFeet = trim($arrBasicView["HeightInFeet"]);
	  $sHtIn = trim($arrBasicView["HeightInInchs"]);
	  $sHtCm = trim($arrBasicView["HeightInCms"]);

	  $sReligion = trim($arrBasicView["Religion"]);
	  $sCaste = trim($arrBasicView["Caste"]);
	  $sSubCaste = trim($arrBasicView["SubCaste"]);

	  $sEducation = trim($arrBasicView["Education"]);
	  $sOccupation = trim($arrBasicView["Occupation"]);
	  $sOccupation1 = trim($arrBasicView["Occupation1"]);

	  $sProfileUrl = "http://".$arrBasicView["Lang"]."/profiledetail/viewprofile.php?id=$matriid";

	  if($sHtFeet!="" && $sHtIn!="" && $sHtCm!="")
		$sHeight = $sHtFeet." Ft ".$sHtIn." In / ".$sHtCm." Cms";
	  elseif($sHtFeet!="" && $sHtIn==""&& $sHtCm!="")
		$sHeight = $sHtFeet." Ft / ".$sHtCm." Cms";
	  elseif($sHtFeet=="" && $sHtIn!=""&& $sHtCm!="")
		$sHeight = $sHtIn." In / ".$sHtCm." Cms";
	  elseif($sHtFeet!="" && $sHtIn!=""&& $sHtCm=="")
		$sHeight = $sHtFeet." Ft ".$sHtIn." In";
	  elseif($sHtFeet!="" && $sHtIn==""&& $sHtCm=="")
		$sHeight = $sHtFeet." Ft";

	  if($sReligion!="" && $sCaste!="" && $sSubCaste!="")
		$sReligious = $sReligion.", ".$sCaste.", ".$sSubCaste;
	  elseif($sReligion!="" && $sCaste!="" && $sSubCaste=="")
		$sReligious = $sReligion.", ".$sCaste;
	  elseif($sReligion!="" && $sCaste=="" && $sSubCaste=="")
		$sReligious = $sReligion;
	  elseif($sReligion!="" && $sCaste=="" && $sSubCaste!="")
		$sReligious = $sReligion.", ".$sSubCaste;

	  $sEduOcc = trim($arrBasicView["EducationSelected"]);

	  if($sEducation!="")
			$sEduOcc .= ", ".$sEducation;
	  if($sOccupation!="")
			$sEduOcc .= ", ".$sOccupation;
	  if($sOccupation1!="")
			$sEduOcc .= ", ".$sOccupation1;

	  if(substr($sEduOcc,0,1)==",")
		$sEduOcc = trim(substr($sEduOcc,1));

	   $mailermsg_top="<span style='font:normal 13px arial;'>Dear <b>".ucwords($arrBasicView["Name"]).",</b><br><br></span><span style='font:normal 12px arial;'>This is a copy of the e-mail that I am going to send to your matching profiles on your behalf. I need your confirmation before I send the e-mail. To confirm, please reply to this e-mail.<br><br></span>";

      $filename="/home/profilebharat/www/mailers/privilege/partnerpref.html";
	  //open html mailer
	  $handle = fopen($filename, "r");
	  $filecontents = fread($handle, filesize($filename));
	  $mailermsg = $filecontents;
	  fclose($handle);

	  
	   	$mailermsg = eregi_replace("#PHOTOURL",$arrBasicView["Photo"],$mailermsg);
		$mailermsg = eregi_replace("#NAME",ucwords($arrBasicView["Name"]),$mailermsg);
		$mailermsg = eregi_replace("#OPPNAME",ucwords($arrBasicView["Name"]),$mailermsg);
		$mailermsg = eregi_replace("#OPPMATRIID",ucwords($matriid),$mailermsg);
		$mailermsg = eregi_replace("#AGE",$arrBasicView["Age"],$mailermsg);
		$mailermsg = eregi_replace("#HEIGHT",$sHeight,$mailermsg);
		$mailermsg = eregi_replace("#RELIGIOUS",$sReligious,$mailermsg);
		$mailermsg = eregi_replace("#COUNTRY",$arrBasicView["state"],$mailermsg);
		$mailermsg = eregi_replace("#EDUOCC",$sEduOcc,$mailermsg);
		$mailermsg = eregi_replace("#PROFILEURL",$sProfileUrl,$mailermsg);
		$mailermsg = eregi_replace("#MATRIID",$matriid,$mailermsg);
	  
	    //RM Details
	

		$mailermsg = eregi_replace("#MESSAGE",$message,$mailermsg);

		$Query="Select Email from  ".$DBNAME['MATRIMONYMS'].".".$TABLE['LOGININFO']."  where MatriId='".$matriid."'";
		$lastadid = db::select($Query);
		$matriemail = db::fetchArray();
		$toemail=$matriemail['Email'];
		
		$Query="Select Email from  ".$TABLE['MEMBERCONTACTINFOBKUP']."  where MatriId='".$matriid."'";
		$lastadid = db::select($Query);
		$rmuserdet = db::fetchArray();
		if($rmuserdet['Email']!=""){$useremail=$rmuserdet['Email'];} 
		
		$Query="Select Name,Email,Mobile from  ".$TABLE['RMLOGININFO']."  where RMUserid='".$rmuserid."'";
		$lastadid = db::select($Query);
		$rmuserdet = db::fetchArray();
		
		$mailermsg = eregi_replace("<<EMAIL>>",$toemail,$mailermsg);
		$mailermsg = eregi_replace("#RMNAME",ucwords($rmuserdet["Name"]),$mailermsg);
		$mailermsg = eregi_replace("#RMEMAIL",$rmuserdet["Email"],$mailermsg);
		$mailermsg = eregi_replace("#RMPHONE",$rmuserdet["Mobile"],$mailermsg);
		$mailermsg = eregi_replace("#RMTIME","9:00 AM TO 06:00PM",$mailermsg);
	    $prevurl="http://www.bharatmatrimony.com/payments/privilege-service.php";
	    $mailermsg = eregi_replace("#PREVURL",$prevurl,$mailermsg);


		  $from = "info@communitymatrimony.com";
		  $from = preg_replace("/\r/", "", $from); 
		  $from = preg_replace("/\n/", "", $from);

		  $from_header = "MIME-Version: 1.0\n";
		  $from_header .= "Content-type: text/html; charset=iso-8859-1\n";
		  $from_header .= "From: CommunityMatrimony.com <info@communitymatrimony.com>\n";
		  $from_header .= "Reply-To: ".$rmuserdet["Email"]." \n";
		  
		  putenv("MAILUSER=bharat"); 
		  putenv("MAILHOST=server.bharatmatrimony.com");
		  if($useremail==""){$useremail=$toemail;}
		  $useremail = preg_replace("/\r/", "", $useremail); 
		  $useremail = preg_replace("/\n/", "", $useremail);
		  $subtxt=$arrBasicView["Name"]." has been specially chosen for you  by our Relationship Manager";
		  $mailermsg=$mailermsg_top.$mailermsg;
		  $useremail.=",srinivasan.c@bharatmatrimony.com";
		  $stat=mail($useremail, $subtxt, $mailermsg, $from_header, "-fbharat@server.bharatmatrimony.com"); //mail sending function...
		  $stat=mail($rmuserdet["Email"], $subtxt, $mailermsg, $from_header, "-fbharat@server.bharatmatrimony.com"); //mail sending function...
	}

	function getpartnerstatus($matrilist) {  //get the partner status for matriid
		 global $DBNAME,$TABLE;
		 $Sql="Select MatriId,Status,TimeCreated,ScheduleDate from ".$DBNAME['RMINTERFACE'].".".$TABLE['MEMPARTNERPREF']." where MatriId IN(".substr($matrilist,0,strlen($matrilist)-1).") order by MatriId";
		 db::select($Sql);
		 $cnt=0;
		while($partner = db::fetchArray()){
				$partnerarr[$partner['MatriId']] = $partner['Status']."$".$partner['TimeCreated']."$".$partner['ScheduleDate'];
		}
		return $partnerarr;

	}

	function GetMessage($matriid) {	 //Get the shedule msg for the matriid
	    global $varCbsRminterfaceDbInfo,$TABLE;
		 /*$Sql="Select Message from ".$DBNAME['RMINTERFACE'].".".$TABLE['MEMPARTNERPREF']." where MatriId='".$matriid."' order by MatriId";
		 db::select($Sql);
		 $message = db::fetchArray();*/
		 $varFields			= array('Message');
		 $varCondition		= " where MatriId='".$matriid."' order by MatriId";
		 $message			= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMPARTNERPREF'], $varFields, $varCondition,1);
		 $message=$message[0]['Message'];
		 return $message;
	}

	function mempartnerprefschedule($rmuserid,$matriid,$message,$schdate){
		 global $TABLE;	
		 $Update="update ".$TABLE['MEMPARTNERPREF']." set Message='".mysql_real_escape_string($message)."',ScheduleDate='".$schdate."',Status=2 where MatriId='".$matriid."'";
		 $lastdid=db::update($Update);
		 return;
	}

	function getschedulemem($rmuserid) {
		  global $TABLE,$DBNAME;	
		   $Sql="Select MatriId from ".$DBNAME['RMINTERFACE'].".".$TABLE['MEMPARTNERPREF']." where RMUserId='".$rmuserid."' and Status=2";

	}

	function genQueryProfileMatch($memberid,$db6slave) {
		global $DBCONIP,$DBINFO,$DBNAME,$TABLE,$data,$GETDOMAININFO;

		$dbprofilematch = $DBNAME['MATRIMONYMS'].".".$TABLE['PROFILEMATCH'];
		
		
		$q = "select MatriId,Gender,Height,Age,Language,Religion,Maritalstatus,Caste,MotherTongue,SpecialCase,Dosham,Educationselected,Eatinghabits,CountrySelected,ResidingState from ".$dbprofilematch." where MatriId='".$memberid."'";

		$data['genQueryWhoIsLookingForMe_query_1'] = $q;

		dispDebugValue($q);

		$db6slave->query = $q;
		$db6slave->select($db6slave->query);
		$num_selected_rows = $db6slave->getNumRows();

		if($num_selected_rows >= 1 ) {
			$row =  $db6slave->fetchArray(); // Iamlookingfor Query Genration //

			$cquery = "Select count(MatriId) FROM ".$dbprofilematch." where";
			$mquery = "Select MatriId FROM ".$dbprofilematch." where";

			$query  = ' Authorized=1 AND Validated=1 AND Status=0 AND';

			if($row['Gender']=='M')
				$query .= " (Gender='F')";
			else
				$query .= " (Gender='M')";

			$query .= " AND (StHeight <= ".$row['Height']." AND EndHeight >= ".$row['Height'].") AND (StAge <= ".$row['Age']." AND EndAge >= ".$row['Age'].")  ";
			
			if(trim($row['Language']) != "" ) {			
				$query .= " AND ( matchLanguage = ".$row['Language']." or  matchlanguage like '%".$row['Language'].",%' or   matchlanguage like '%,".$row['Language']."%' or matchLanguage = 0  )";
			}

			if(trim($row['Maritalstatus']) != "" ) {			
				$query .= " AND ( MatchMaritalStatus = ".$row['Maritalstatus']." or  MatchMaritalStatus like '%".$row['Maritalstatus'].",%' or  MatchMaritalStatus like '%,".$row['Maritalstatus']."%'  or MatchMaritalStatus = 0 )";
			}

			if(trim($row['Religion']) != "" ) {			
				$query .= " AND ( MatchReligion = ".$row['Religion']." or  MatchReligion like '%".$row['Religion'].",%' or  MatchReligion like '%,".$row['Religion']."%' or  MatchReligion = 0 )";
			}

			if(trim($row['Caste']) != "" && $row['Caste'] != "0" ) {
				$query .= " AND ( MatchCaste = ".$row['Caste']." or  MatchCaste like '%".$row['Caste'].",%' or  MatchCaste like '%,".$row['Caste']."%' or  MatchCaste = 0 )";
			}	

			if(trim($row['MotherTongue']) != "" ) {
				$query .= " AND ( MatchMotherTongue = ".$row['MotherTongue']." or  MatchMotherTongue like '%".$row['MotherTongue'].",%'  or  MatchMotherTongue like '%,".$row['MotherTongue']."%' or  MatchMotherTongue = 0 )";
			}
			
			if(trim($row['Dosham']) != ""  && trim($row['Dosham']) != '3') {
				$query .= "  AND ( Manglik = ".$row['Dosham']." or Manglik = 0 )";
			}

			if(trim($row['Educationselected']) != "" ) {
				$query .= " AND ( MatchEducation = ".$row['Educationselected']." or  MatchEducation like '%".$row['Educationselected'].",%' or  MatchEducation like '%,".$row['Educationselected']."%' or  MatchEducation = 0  )";
			}

			if(trim($row['Eatinghabits']) != ""  && trim($row['Eatinghabits']) != '0') {
					$query .= "  AND ( EatinghabitsPref = ".$row['Eatinghabits']."  or EatinghabitsPref = 0 )";
			} 

			if(trim($row['SpecialCase']) != "" && trim($row['SpecialCase']) != '0' ) {
					$query .= "  AND ( PhysicalStatus = ".$row['SpecialCase']." or PhysicalStatus = 0 ) ";
			} 

			if(trim($row['CountrySelected']) != "" ) {
				$query .= " AND ( MatchCountry = ".$row['CountrySelected']." or  MatchCountry like '%".$row['CountrySelected'].",%'  or  MatchCountry like '%,".$row['CountrySelected']."%' or  MatchCountry = 0 )";
			}

			if(strstr($row['CountrySelected'],"98")!="" && strstr($row['ResidingState'],'0')=="")	{
				$query .= " AND ( MatchIndianStates = ".$row['ResidingState']." or  MatchIndianStates like '%".$row['ResidingState'].",%'  or  MatchIndianStates like '%,".$row['ResidingState']."%' or  MatchIndianStates = 0  )";
			}

			if(strstr($row['CountrySelected'],"222")!="" && strstr($row['MatchUSStates'],'0') =="")	{
				$query .= " AND ( MatchUSStates = ".$row['ResidingState']." or  MatchUSStates like '%".$row['ResidingState'].",%' or  MatchUSStates like '%,".$row['ResidingState']."%' or  MatchUSStates = 0 )";
			}

			$orderBy	= ' ORDER BY TimeCreated DESC';
			$SearchQueryReturn[1] = $cquery.$query;
			$SearchQueryReturn[0] = $mquery.$query.$orderBy;

			dispDebugValue($SearchQueryReturn);
			$qry[0] = "";
		} 
		else {
			$qry[0] = '';
			$qry[1] = '';
			$qry[2] = '';
			$qry[4] = 0;
			dispDebugValue($qry);	
			return $qry;
		}

		$db6slave->select($SearchQueryReturn[1]);

		return $qry;
	}
	  function ExecuteQry($query){
          //print "<br>".$query; exit;
		  if (!mysql_query($query,$this->clsDBLink))
			{
				$this->clsErrorCode		= "INSERT_ERR";
				$this->ErrorLog(mysql_error(), $funQuery);
			} else { return mysql_affected_rows($this->clsDBLink); }//else
	  }

	  function CloseDB(){
		$this->slave->dbClose();
		$this->master->dbClose();
	}
}
?>
