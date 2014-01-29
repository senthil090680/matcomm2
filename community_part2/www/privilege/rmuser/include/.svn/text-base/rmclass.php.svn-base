<?

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath."/conf/basefunctions.cil14");
include_once($varBaseRoot.'/conf/emailsconfig.cil14');
include_once($varBaseRoot.'/conf/domainlist.cil14');
include_once($varBaseRoot.'/conf/vars.cil14');
include_once($varRootBasePath.'/lib/clsRMDB.php');
include_once($varRootBasePath."/bmconf/bmvarsviewarren.cil14");
//include_once $varRootBasePath."/bmlib/bmgenericfunctions.cil14";
include_once($varRootBasePath."/lib/clsPrivilegeCommon.php");
include_once($varRootBasePath.'/conf/wsconf.cil14');                                    
include_once($varRootBasePath.'/lib/clsWSMemcacheClient.php');

//include_once "../config/config.cil14";

class srmclassname extends DB
{
	var $username;
	var $password;
	
	function srminit() {
		$this->username = '';
		$this->password = '';
		$this->slave  = '';
		$this->master = '';
		$this->db_host = '';
		$this->db_user = '';
		$this->db_pass = '';
	}
    // to get the debug parameters of the class  //
	function getDebugParam() {
		global $varDbIP, $varDBUserName, $varDBPassword;
        $this->db_host = $varDbIP;
		$this->db_user = $varDBUserName;
		$this->db_pass = $varDBPassword;
		$param["host"] = $this->db_host;
		$param["db_link"] = $this->db_link;
		//$param["db_resource"] = $this->resource;
		$param["db_error"] = mysql_error();
		return $param;
	}
	function srmConnect() {
		global $varDbInfo;
		//db::connect($dbhost,$dbusername,$dbpassword,$dbname);
		$objdbclass	= new srmclassname;
        $objdbclass->dbConnect('S',$varDbInfo['DATABASE']);
       
        $masterobjdbclass	= new srmclassname;
        $masterobjdbclass->dbConnect('M',$varDbInfo['DATABASE']);

        $this->db_link=$this->clsDBLink;
		$this->slave=$objdbclass;
		$this->master=$masterobjdbclass;
	}
	function srmCommunityConnect() {
		$dbname='communitymatrimony';
		global $dbhost,$dbusername,$dbpassword,$dbname;
		db::connect($dbhost,$dbusername,$dbpassword,$dbname);
	}
	
	function srmConnect1($dbhost,$dbusername,$dbpassword,$dbname) {
		db::connect($dbhost,$dbusername,$dbpassword,$dbname);
	}
	
	function InsertRmlogininfo($userid,$email,$phoneno,$mobileno,$name,$password){
		global $TABLE,$varCbsRminterfaceDbInfo;		
		/*$debug_it['err'] .= $debug_it['br'] .$InsertQuery="Insert Into ".$tbl['RMLOGININFO']." (RMUserid,Password,Name,Email,Phone,Mobile,Activate,TimeCreated) values('".$userid."','".$password."','".$name."','".$email."','".$phoneno."','".$mobileno."',1,NOW())";		
		echo $InsertQuery;
		db::insert($InsertQuery);*/

		$varInsertFields	= array("RMUserid","Password","Name","Email","Phone","Mobile","Activate","TimeCreated");
	    $varInsertVal	= array("'".$userid."'","'".$password."'","'".$name."'","'".$email."'","'".$phoneno."'","'".$mobileno."'","1",'NOW()');
	    $insertedid = $this->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'], $varInsertFields, $varInsertVal);
	   	$val=1;
		return $val;
	}

	function UpdateRmlogininfo($userid,$email,$mobileno,$name){
		echo 'Test';
		global $TABLE,$varCbsRminterfaceDbInfo;	
		/*$mobileno="91~".$mobileno;
		$debug_it['err'] .= $debug_it['br'] .$UpdateQuery="Update ".$tbl['RMLOGININFO']." set Name='".$name."',Email='".$email."',Mobile='".$mobileno."' where RMUserid='".$userid."'";		
		db::update($UpdateQuery);*/
		
		$varUpdateFields = array("Name","Email","Mobile");
	    $varUpdateVal	 = array("'".$name."'","'".$email."'","'".$mobileno."'");
	    $varUpdateCondtn	= " RMUserid='".$userid."'";
	    $this->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);


		return;
	}

	function CheckEmail($email,$userid){
		global $TABLE,$debug_it,$varCbsRminterfaceDbInfo;					

		/*$SelectQuery="Select count(Email) as CountEmail from ".$tbl['RMLOGININFO']." where Email='".$email."'";	
		if($userid != "") {
			$SelectQuery .= " and RMUserid != '".$userid."'";
		}*/

		$varActFields	= array("count(Email)");
		$varActCondtn	= " where Email='".$email."'";

		if($userid != "") {
			$varActCondtn .= " and RMUserid != '".$userid."'";
		}

		$userid		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
			
		//$debug_it['err'] .= $debug_it['br'] .$SelectQuery;
		//db::select($SelectQuery);	
		//$userid = db::fetchArray();

		$Emailcount=$userid[0]['count(Email)'];
	   	return $Emailcount;
	}

	function SelectRmusers($user_remove){
		global $TABLE,$varCbsRminterfaceDbInfo;	
		/*$SelectQuery = "Select Name, RMUserid from ".$tbl['RMLOGININFO']." where Activate=1";
		if($user_remove != "") {
			$SelectQuery .=" and RMUserid NOT IN ('".$user_remove."')";
		}
		$debug_it['err'] .= $debug_it['br'] .$SelectQuery;
		db::select($SelectQuery);*/
		$varActFields	= array("Name","RMUserid");
		$varActCondtn	= " where Activate=1";
		if($user_remove != "") {
			$varActCondtn.=" and RMUserid NOT IN ('".$user_remove."')";
		}
		$row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,0);

		while($userlist = mysql_fetch_assoc($row)){
			$userlistarr[$userlist['RMUserid']] = $userlist['Name'];			
		}
	   	return $userlistarr;
	}



	function ExistingRmusers(){
		global $TABLE,$varCbsRminterfaceDbInfo;	
		/*$debug_it['err'] .= $debug_it['br'] .$FindQuery="Select count(RMUserid) as tot, RMUserid from ".$tbl['RMMEMBERINFO']." group by RMUserid";
		$total = db::select($FindQuery);*/

		$varActFields	= array("count(RMUserid)","RMUserid");
	    $varActCondtn	= " group by RMUserid";
	    $cnt		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
		$row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,0);
        
		if(!empty($cnt)) {			
			while($rmuserlist = mysql_fetch_assoc($row)){				
					$rmuserlistarr[$rmuserlist['RMUserid']] = $rmuserlist['count(RMUserid)'];				
			}
			return $rmuserlistarr;
		}
	}	

	function Generateuserid($Fieldname,$CCode){
		global $TABLE,$debug_it,$varCbsRminterfaceDbInfo;

		//$debug_it['err'] .= $debug_it['br'] . $query="Select max(SUBSTRING(".$Fieldname.",7,length(RMUserid))+1) as Usercount from ".$TABLE['RMLOGININFO']." where SUBSTRING(".$Fieldname.",1,6)='".$CCode."'";
		//$tot = db::select($query);

		$varActFields	= array("max(SUBSTRING(".$Fieldname.",7,length(RMUserid))+1)");
		$varActCondtn	= " where SUBSTRING(".$Fieldname.",1,6)='".$CCode."'";
		$userid		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
		
		 if(!empty($userid)) {
			//$userid = db::fetchArray('MYSQL_ASSOC');
			return $userid[0]['max(SUBSTRING(RMUserid,7,length(RMUserid))+1)'];
		}
	}

	function unsegregatedmem(){
		global $TABLE,$varCbsRminterfaceDbInfo,$DBNAME, $MERGETABLE;

		 /*$debug_it['err'] .= $debug_it['br'] .$memberquery="Select MatriId from ".$DBNAME['RMINTERFACE'].".".$tbl['RMMEMBERINFO']." where RMUserid=''";
		 $tot = db::select($memberquery);*/

		 $varActFields	= array("MatriId");
		 $varActCondtn	= " where RMUserid=''";
		 $row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
		 $result		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,0);

		 if(!empty($row)) {
			$inc = 0;
			while($member = mysql_fetch_assoc($result)) {
				$memberarr[$inc] = $member['MatriId'];
				$inc++;
			}	
			return $memberarr;
		}
	}

	function unsegregatedmember($rmuser){
		global $varCbsRminterfaceDbInfo,$TABLE,$DBNAME, $MERGETABLE;

		 /*$debug_it['err'] .= $debug_it['br'] .$memberquery="Select MatriId,PrivStatus from ".$DBNAME['RMINTERFACE'].".".$tbl['RMMEMBERINFO']." where RMUserid='".$rmuser."'";
		 $tot = db::select($memberquery);*/
         
		 $varActFields	= array("MatriId","PrivStatus");
		 $varActCondtn	= " where RMUserid='".$rmuser."'";
		 $row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
		 $result		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,0);

		 if(!empty($row)) {
			$inc = 0;
			while($member = mysql_fetch_assoc($result)) {
				$memberarr[$inc] = $member['MatriId'];
				$inc++;
			}	
			return $memberarr;
		}
	}
	function findbywhomprofilecreated($mids){
		global $varDbInfo, $MERGETABLE, $debug_it,$varTable;

		/* $debug_it['err'] .= $debug_it['br'] .$memberquery="Select MatriId, ByWhom from ".$DBNAME['MATRIMONYMS'] .".". $MERGETABLE['MATRIMONYPROFILE']." where MatriId IN ('".$mids."')";*/

		/*$debug_it['err'] .= $debug_it['br'] .$memberquery="Select MatriId from ".$DBNAME['COMMUNITYMATRIMONY'] .".". $varTable['MEMBERINFO']." where MatriId IN ('".$mids."')";
		$tot = db::select($memberquery);*/

		$varActFields	= array("MatriId","Profile_Created_By");
		$varActCondtn	= " where MatriId IN ('".$mids."')";
		$tot		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
		$rows		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,0);
			
		 if(!empty($tot)) {
			while($bywhomlist = mysql_fetch_assoc($rows)) {
				$bywhomarr[$bywhomlist['MatriId']] = $bywhomlist['Profile_Created_By'];
			}	
			return $bywhomarr;
		}
	}

	function UpdateRmusers($rmuser,$matriid){
		global $TABLE,$varCbsRminterfaceDbInfo;
		if(($rmuser != "") && ($matriid != "")) { 
			/*$debug_it['err'] .= $debug_it['br'] .$Updatequery="update ".$tbl['RMMEMBERINFO']." set RMUserid = '".$rmuser."',RMassignDate=now() where MatriId IN ('".$matriid."')";
			db::update($Updatequery);*/
			$varUpdateFields	=array("RMUserid","RMassignDate");
			$varUpdateVal	= array("'".$rmuser."'",'now()');
			$varUpdateCondtn	= " MatriId IN ('".$matriid."')";
			$this->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

		}
	}	

	function selectRmuserdetail($rmuser){
		/*global $tbl,$debug_it;	
		$debug_it['err'] .= $debug_it['br'] .$SelectQuery = "Select Email,Phone,Mobile,Name from ".$tbl['RMLOGININFO']." where RMUserid='".$rmuser."'";		
		db::select($SelectQuery);		
		$rmuserlist = db::fetchArray('MYSQL_ASSOC');*/

		global $TABLE,$varCbsRminterfaceDbInfo;
		/*$Query="Select MatriId,MemberName,ValidDays,PrivStatus,TimeCreated,ExpiryDate from ".$TABLE['RMMEMBERINFO']." where RMUserid='".$rmusername."'";
		db::select($Query);*/
		$varActFields	= array("Email","Phone","Mobile","Name");
		$varActCondtn	= " where RMUserid='".$rmuser."'";
		$rmuserlist		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
		$userlist[$rmuser]['email'] = $rmuserlist[0]['Email'];
		$userlist[$rmuser]['phone'] = $rmuserlist[0]['Phone'];
		$userlist[$rmuser]['mobile'] = $rmuserlist[0]['Mobile'];
		$userlist[$rmuser]['name'] = $rmuserlist[0]['Name'];
		return $userlist;
	}

	function srmConnById($domainid,$dbtype){		
		global $DBINFO,$DBNAME;
		//db::dbConnById(1,$domainid,$dbtype,$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
		if($dbtype=='M'){
		db::dbConnByIdMergeMaster(1,$domainid,$dbtype,$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);	
		}else if($dbtype=='S'){
		db::dbConnById(1,$domainid,$dbtype,$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);	
		}
	}

	function chkentrytype_specialpriv($mids){
		global $varDbInfo,$varTable;	
		if($mids != "") {

			/*$debug_it['err'] .= $debug_it['br'] .$SelectphonestatusQuery = "Select MatriId from ".$DOMAINTABLE[$domainlangarraylong]['MATRIMONYPROFILE']." where MatriId IN ('".$mids."') and EntryType = 'R' and SpecialPriv = 3";	
			$total = db::select($SelectphonestatusQuery);*/
			
			$varActFields	= array("MatriId");
			$varActCondtn	= " where MatriId IN ('".$mids."') and Paid_Status=1 and Special_Priv=3";
			$row		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,0);

			$inc = 0;
			while($midlist = mysql_fetch_assoc($row)) {	
				$checkedmid[$inc] = $midlist['MatriId'];
				$inc++;
			}
			return $checkedmid;
		}
	}

	function Emailbackup($mids){
		global $varDbInfo,$varTable;	
		if($mids != "") {

			/*$debug_it['err'] .= $debug_it['br'] .$SelectemailQuery = "Select Email,MatriId from ".$DOMAINTABLE[$domainlangarraylong]['LOGININFO']." where MatriId IN ('".$mids."')";	
			$total = db::select($SelectemailQuery);	*/	

            $varActFields	= array("Email","MatriId");
			$varActCondtn	= " where MatriId IN ('".$mids."')";
			$row		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'],$varActFields,$varActCondtn,0);
 
			while($emaillist = mysql_fetch_assoc($row)) {		
				$emailarr[$emaillist['MatriId']] = $emaillist['Email'];
			}
			return $emailarr;
		}
	}

	function phonestatus($mids){
		global $varDbInfo,$varTable;	
		if($mids != "") {
			/*$debug_it['err'] .= $debug_it['br'] .$SelectphonestatusQuery = "Select PhoneVerified,MatriId from ".$DOMAINTABLE[$domainlangarraylong]['MATRIMONYPROFILE']." where MatriId IN ('".$mids."')";	
			$total = db::select($SelectphonestatusQuery);*/	
			
            $varActFields	= array("Phone_Verified","MatriId");
			$varActCondtn	= " where MatriId IN ('".$mids."')";
			$row		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,0);

			while($phonestatuslist = mysql_fetch_assoc($row)) {		
				$Pstatusarr[$phonestatuslist['MatriId']] = $phonestatuslist['Phone_Verified'];
			}
			return $Pstatusarr;
		}
	}

	function assured_details($mids){
		global $varTable,$varDbInfo;	
		if($mids != "") {
			/*$debug_it['err'] .= $debug_it['br'] .$SelectQuery = "Select MatriId,PhoneNo1,ContactPerson1,Relationship1,Timetocall1 from ".$TABLE['ASSUREDCONTACT']." where MatriId IN ('".$mids."')";	
			$total = db::select($SelectQuery);*/
			$varActFields	= array("MatriId","PhoneNo1","ContactPerson1","Relationship1","Timetocall1");
			$varActCondtn	= " where MatriId IN ('".$mids."')";
			$row		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'],$varActFields,$varActCondtn,0);

			while($assuredlist = mysql_fetch_assoc($row)) {		
				$assuredarr[$assuredlist['MatriId']]['phoneno'] = $assuredlist['PhoneNo1'];
				$assuredarr[$assuredlist['MatriId']]['contactperson'] = $assuredlist['ContactPerson1'];
				$assuredarr[$assuredlist['MatriId']]['relationship'] = $assuredlist['Relationship1'];
				$assuredarr[$assuredlist['MatriId']]['timetocall'] = $assuredlist['Timetocall1'];
			}
			return $assuredarr;
		}		
	}

	function insert_backuptable($rmuserid, $matriid,$emails,$phoneverifiedstatus,$assureddetails){
		global $TABLE,$varCbsRminterfaceDbInfo;	

		if(is_array($matriid)) {
			foreach($matriid as $mid) {
				$mid = trim($mid);
				if($emails[$mid] != "" && $phoneverifiedstatus[$mid] != "") {

					/*$debug_it['err'] .= $debug_it['br'] .$insertquery = "insert into ".$TABLE['MEMBERCONTACTINFOBKUP']." (RMUserId,MatriId,PhoneNo1,ContactPerson1,Relationship1,Timetocall1,PhoneVerified,Email) values('".$rmuserid."','".$mid."','".$assureddetails[$mid]['phoneno']."','".$assureddetails[$mid]['contactperson']."','".$assureddetails[$mid]['relationship']."','".$assureddetails[$mid]['timetocall']."',".$phoneverifiedstatus[$mid].",'".$emails[$mid]."') ON DUPLICATE KEY update RMUserId='".$rmuserid."',PhoneNo1='".$assureddetails[$mid]['phoneno']."',ContactPerson1='".$assureddetails[$mid]['contactperson']."',Relationship1='".$assureddetails[$mid]['relationship']."',Timetocall1='".$assureddetails[$mid]['timetocall']."',PhoneVerified='".$phoneverifiedstatus[$mid]."',Email='".$emails[$mid]."'";					
					//$this->query = $insertquery;				
					//db::execute();
					db::insert($insertquery);*/
                    $varPrimaryVal = array("MatriId");
					$varInsertFields	= array("RMUserId","MatriId","PhoneNo1","ContactPerson1","Relationship1","Timetocall1","PhoneVerified","Email");
	                $varInsertVal	= array("'".$rmuserid."'","'".$mid."'","'".$assureddetails[$mid]['phoneno']."'","'".$assureddetails[$mid]['contactperson']."'","'".$assureddetails[$mid]['relationship']."'","'".$assureddetails[$mid]['timetocall']."'",$phoneverifiedstatus[$mid],"'".$emails[$mid]."'");
	                $this->master->insertOnDuplicate($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'], $varInsertFields, $varInsertVal, $varPrimaryVal);
				}
			}			
		}
		return;
	}

	function UpdateEmail($mids,$email){
		global $varDbInfo,$varTable;	
		if($mids != "") {
			/*$debug_it['err'] .= $debug_it['br'] .$updateemail = "update ".$DOMAINTABLE[$domainlangarraylong]['LOGININFO']." set Email = '".$email."',DateUpdated=NOW() where MatriId IN ('".$mids."')";	
			db::update($updateemail);*/
			$varUpdateFields	=array("Email","Date_Updated");
			$varUpdateVal	= array("'".$email."'","NOW()");
			$varUpdateCondtn	= "  MatriId IN ('".$mids."')";
			$this->master->update($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);


		}
	}

	function updateassureddetails($mids,$contactno,$name,$relation,$timing){
		global $varDbInfo,$varTable;	
		if(is_array($mids)) {
			foreach($mids as $matriid) {
				
				/*$debug_it['err'] .= $debug_it['br'] .$updatequery = "insert into ".$TABLE['ASSUREDCONTACT']." (MatriId,PhoneNo1,ContactPerson1,Relationship1,Timetocall1,DateConfirmed) values('".$matriid."','".$contactno."','".$name."',".$relation.",'".$timing."',NOW()) ON DUPLICATE KEY update PhoneNo1 = '".$contactno."',ContactPerson1='".$name."',Relationship1='".$relation."',Timetocall1='".$timing."'";
				db::update($updatequery);*/
				$varPrimaryVal = array("MatriId");
				$varInsertFields	= array("MatriId","PhoneNo1","ContactPerson1","Relationship1","Timetocall1","DateConfirmed");
	            $varInsertVal	= array("'".$matriid."'","'".$contactno."'","'".$name."'","'".$relation."'","'".$timing."'","NOW()");
	            $this->master->insertOnDuplicate($varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'], $varInsertFields, $varInsertVal, $varPrimaryVal);
			}
		}
	}

	function Updateprofileverified($mids){
		global $varDbInfo,$varTable;	
		if($mids != "") {
			/*$debug_it['err'] .= $debug_it['br'] .$updatephverified = "update ".$DOMAINTABLE[$domainlangarraylong]['MATRIMONYPROFILE']." set PhoneVerified = 1,DateUpdated=NOW() where MatriId IN ('".$mids."')";	
			db::update($updatephverified);*/
			$varUpdateFields	=array("Phone_Verified","Date_Updated");
			$varUpdateVal	= array("1","NOW()");
			$varUpdateCondtn	= "  MatriId IN ('".$mids."')";
			$this->master->update($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
		}
	}

	function Rmalluserdetails($from='',$limit='',$totpage=''){
		global $varCbsRminterfaceDbInfo,$TABLE;	
		$SelectQuery = "Select Id,RMUserid,Email,Phone,Mobile,Name,TimeCreated from ".$tbl['RMLOGININFO']." where Activate=1 order by Id";
		
		$varActFields	= array("Id","RMUserid","Email","Phone","Mobile","Name","TimeCreated");
		$varActCondtn	= " where Activate=1 order by Id";
		
		
		if($totpage == "totpage")  {
			$debug_it['err'] .= $debug_it['br'] .$SelectQuery;
			$rows		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
			$count = count($rows);//db::select($SelectQuery);	
			return $count;
		} else {
			$SelectQuery .= " limit ".$from.",".$limit;
			$debug_it['err'] .= $debug_it['br'] .$SelectQuery;
			//db::select($SelectQuery);
			$varActCondtn	= " where Activate=1 order by Id limit ".$from.",".$limit;
            $rows		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,0);

			while($rmuserlist = mysql_fetch_assoc($rows)) {		
				$userdetail[$rmuserlist['RMUserid']]['email'] = $rmuserlist['Email'];
				$userdetail[$rmuserlist['RMUserid']]['phone'] = $rmuserlist['Phone'];
				$userdetail[$rmuserlist['RMUserid']]['mobile'] = $rmuserlist['Mobile'];
				$userdetail[$rmuserlist['RMUserid']]['name'] = $rmuserlist['Name'];
				$userdetail[$rmuserlist['RMUserid']]['timecreated'] = $rmuserlist['TimeCreated'];
				$userdetail[$rmuserlist['RMUserid']]['id'] = $rmuserlist['Id'];
			}
			return $userdetail;
		} 
	}

	function Rmuserphlogdetails($rmuser,$fromdate,$todate,$startlimit,$endlimit){
		global $varCbsRminterfaceDbInfo,$TABLE;	
		/*$SelectQuery = "Select RMUserid,MatriId,OppositeMatriId,DateViewed from ".$tbl['RMVIEWPHONELOG']." where DATE(DateViewed) >='".$fromdate."' and DATE(DateViewed) <= '".$todate."'";
		
		if($rmuser != "all") {
			$SelectQuery .= " and RMUserid ='".$rmuser."'";
		} else {
			$SelectQuery .= " order by RMUserid";
		}
		$SelectQuery .= " limit ".$startlimit.",".$endlimit;
		$debug_it['err'] .= $debug_it['br'] .$SelectQuery;

		db::select($SelectQuery);*/	

        $varActFields	= array("RMUserid","MatriId","OppositeMatriId","DateViewed");
		$varActCondtn	= " where DATE(DateViewed) >='".$fromdate."' and DATE(DateViewed) <= '".$todate."'";
        if($rmuser != "all") {
			$varActCondtn .= " and RMUserid ='".$rmuser."'";
		} else {
			$varActCondtn .= " order by RMUserid";
		}
		$varActCondtn .= " limit ".$startlimit.",".$endlimit;

		$row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMVIEWPHONELOG'],$varActFields,$varActCondtn,0);

		$inc = 0;
		while($rmuserphloglist = mysql_fetch_assoc($row)) {		
			$memlogdetail[$rmuserphloglist['RMUserid']][$inc]['loginmid'] = $rmuserphloglist['MatriId'];
			$memlogdetail[$rmuserphloglist['RMUserid']][$inc]['viewedmid'] = $rmuserphloglist['OppositeMatriId'];
			$memlogdetail[$rmuserphloglist['RMUserid']][$inc]['date'] = $rmuserphloglist['DateViewed'];
			$inc++;
		}
		return $memlogdetail;
	}

	function totallogcount($rmuser,$fromdate,$todate){
		global $varCbsRminterfaceDbInfo,$TABLE;	
		/*$SelectQuery = "Select MatriId from ".$tbl['RMVIEWPHONELOG']." where  DATE(DateViewed) >='".$fromdate."' and  DATE(DateViewed) <= '".$todate."'";
		
		if($rmuser != "all") {
			$SelectQuery .= " and RMUserid ='".$rmuser."'";
		} else {
			$SelectQuery .= " order by RMUserid";
		}

		$debug_it['err'] .= $debug_it['br'] .$SelectQuery;
		$rmuserphlogcount = db::select($SelectQuery);*/

        $varActFields	= array("MatriId");
		$varActCondtn	= " where  DATE(DateViewed) >='".$fromdate."' and  DATE(DateViewed) <= '".$todate."'";
        if($rmuser != "all") {
			$varActCondtn .= " and RMUserid ='".$rmuser."'";
		} else {
			$varActCondtn .= " order by RMUserid";
		}
		
		$row		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMVIEWPHONELOG'],$varActFields,$varActCondtn,1);
        $rmuserphlogcount=count($row);

		return $rmuserphlogcount;
	}

	function deleteuser($id){
		global $TABLE,$varCbsRminterfaceDbInfo;	
		/*$debug_it['err'] .= $debug_it['br'] .$updateQuery = "update ".$tbl['RMLOGININFO']." set Activate = 0  where Id=".$id;		db::update($updateQuery);*/
        
		$varUpdateFields = array("Activate");
	    $varUpdateVal	 = array("0");
	    $varUpdateCondtn	= " Id='".$id."'";
	    $this->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

		return;
	}

	function findmembername($mids){
		global $varDbInfo, $varTable, $debug_it;

		 /*$debug_it['err'] .= $debug_it['br'] .$memberquery="Select MatriId, Name from ".$DBNAME['MATRIMONYMS'] .".". $MERGETABLE['MATRIMONYPROFILE']." where MatriId IN ('".$mids."')";
		 $tot = db::select($memberquery);*/
		 $varActFields	= array("MatriId","Name");
		 $varActCondtn	= " where MatriId IN ('".$mids."')";
		 $tot		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
		 $rows		= $this->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,0);

		 if(!empty($tot)) {
			while($namelist = mysql_fetch_assoc($rows)) {
				$membername[$namelist['MatriId']] = $namelist['Name'];
			}	
			return $membername;
		}
	}

/*	function sendsms($smsmessage,$mobileno){
		global $DBNAME,$TABLE,$debug_it;		
		$debug_it['err'] .= $debug_it['br'] .$InsertQuery="Insert Into ".$DBNAME['WAY2SMSDB0'].".".$TABLE['MESSAGE']." (SenderId,MobileNo,Message,SendDate)values ('BM','".$mobileno."','".$smsmessage."',NOW())";
		db::insert($InsertQuery);		
		return;
	} */

function sendsms($smsmessage,$mobileno){
		global $DBNAME,$TABLE,$debug_it;
		$content=urlencode($smsmessage);
		if (strlen($mobileno) > 10) {
            	$mobileno = substr($mobileno,2,strlen($mobileno)); }


		$varlogFile = "CBS_execlog".date('Y-m-d').'.txt';
		escapeexec("/usr/bin/php /home/profilebharat/bin/cron/sms/bmsms.php $mobileno $content",$varlogFile);

		return;
	}

	function ContactInfobkup($matriid,$profiletable,$slaveconn){
		global $tbl;
		/*$Query="Select Phone_Verified from ".$profiletable." where MatriId='".$matriid."'";
		$num=$slaveconn->select($Query);
		$row = $slaveconn->fetchArray();*/
        
		$varActFields	= array("Phone_Verified");
        $varActCondtn	= " where MatriId='".$matriid."'";
        $row		= $this->slave->select($profiletable,$varActFields,$varActCondtn,1);

		if(!empty($row) && $row[0]['Phone_Verified']>0)
			$phoneverify = $row[0]['Phone_Verified'];
		else 
			$phoneverify = 0;
		return $phoneverify;
	}

	function rmuserlist() {
		global $TABLE,$varCbsRminterfaceDbInfo;		
		/*$debug_it['err'] .= $debug_it['br'] .$SelectQuery="Select RMUserid,Name from ".$tbl['RMLOGININFO']." order by Name Asc";
		$rmuser=mysql_query($SelectQuery);*/
		$varActFields	= array("RMUserid","Name");
		$varActCondtn	= " order by Name Asc";
		$rmuser		= $this->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,0);

		return $rmuser;
	}


	function Conversionreport($rmuser,$fromdate,$todate,$startlimit,$endlimit,$db5){
		global $tbl,$debug_it;	
		
		$SelectQuery = "select MatriId from bmpayment.paymentdetails where ProductId='48' and (PaymentTime > '".$fromdate." 00:00:00' and PaymentTime < '".$todate." 23:59:59') ";
		
		$SelectQuery .= " limit ".$startlimit.",".$endlimit;
		$debug_it['err'] .= $debug_it['br'] .$SelectQuery;

		$db5->select($SelectQuery);//	print_r($db5);
		$inc = 0;
		while($rmuserphloglist = $db5->fetchArray('MYSQL_ASSOC')) {		
			$memlogsdetail[$rmuserphloglist['MatriId']] = $rmuserphloglist['MatriId'];
			$inc++;
		} 
		$contact = "select RMUserid,MatriId,MemberName,date(ExpiryDate) as ExpiryDate from rminterface.rmmemberinfo where MatriId in ('".implode("','",$memlogsdetail)."')";
		db::select($contact);	
		while($conversionlist = db::fetchArray('MYSQL_ASSOC')) {		
			$memlogdetail[$conversionlist['MatriId']][$inc]['RMUserid'] = $conversionlist['RMUserid'];
			$memlogdetail[$conversionlist['MatriId']][$inc]['MatriId'] = $conversionlist['MatriId'];
			$memlogdetail[$conversionlist['MatriId']][$inc]['MemberName'] = $conversionlist['MemberName'];
			$memlogdetail[$conversionlist['MatriId']][$inc]['ExpiryDate'] = $conversionlist['ExpiryDate'];
			$inc++;
		} //print_r($memlogdetail);
		return $memlogdetail;
	}
	function conversioncnt($rmuser,$fromdate,$todate,$db5){
		global $tbl,$debug_it;	
		$SelectQuery = "select MatriId from bmpayment.paymentdetails where ProductId='48' and (PaymentTime > '".$fromdate." 00:00:00' and PaymentTime < '".$todate." 23:59:59') ";
 

		$debug_it['err'] .= $debug_it['br'] .$SelectQuery;

		$rmuserphlogcount = $db5->select($SelectQuery); //print_r($db5);
		return $rmuserphlogcount;
	}
	function CloseDB(){
		$this->slave->dbClose();
		$this->master->dbClose();
	}
}
?>
