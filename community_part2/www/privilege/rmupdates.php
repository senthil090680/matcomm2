<?
include_once "include/rmclass.php";
$wsmemClient = new WSMemcacheClient;
$rmclass=new rmclassname();
$rmclass->init();	
$rmclass->rmConnect();
$matriid = $COOKIEINFO['LOGININFO']['MEMBERID'];
if($matriid=="") {
	$matriid=$_REQUEST['matriid'];
} 

$logininfotable     = $varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'];
$matrimonyprofiletable  = $varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];
// 1 for Fulltopartial Access 2 for partialtofull

    
    $rmEmailStatus  = 0;
	$memEmailStatus = 0;
	$varActFields	= array("RMUserid");
	$varActCondtn	= " where MatriId='".$matriid."' and RMUserid !=''";
	$getrmUserid	= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);

	if($getrmUserid[0]['RMUserid']){

		$varActFields	= array("Email");
		$varActCondtn	= " where RMUserid ='".$getrmUserid[0]['RMUserid']."'";
		$getrmEmail	= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActFields,$varActCondtn,1);
		if($getrmEmail[0]['Email']){
			$rmEmailStatus  = 1;
		}else{
			$rmEmailStatus  = 2;
		}

	}

	$varActFields	= array("Email");
	$varActCondtn	= " where MatriId='".$matriid."'";
	$getMemEmailid		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERLOGININFO'],$varActFields,$varActCondtn,1);
    if($getMemEmailid[0]['Email']){
		$memEmailStatus = 1;
	}
	if($rmEmailStatus == 0){echo $retval  = 2;exit;}
	if($rmEmailStatus == 2){echo $retval  = 3;exit;}
	if($memEmailStatus == 0){echo $retval = 4;exit;}
	

echo $retval = partialupdate($matriid,$_REQUEST['access'],$rmclass,$wsmemClient);

// retval 0 means rmuser val empty 1 means sucess 2 checking whether his/her entrytype is free 
function partialupdate($matriid,$access,$rmclass,$wsmemClient){
	if($access == 1) { $full = fulltopartial($matriid,$access,$rmclass,$wsmemClient); return $full; }
	else if($access == 2) { $partial = partialtofull($matriid,$access,$rmclass,$wsmemClient);return $partial;  } 
}

function fulltopartial($matriid,$val,$rmclass,$wsmemClient){ 
	global $rmclass,$DBCONIP,$DBINFO,$DBNAME,$TABLE,$logininfotable,$matrimonyprofiletable,$varDbInfo,$varTable,$varCbsRminterfaceDbInfo;
	
	$varActFields	= array("MatriId");
	$varActCondtn	= " where MatriId='".$matriid."' and Paid_Status=1 and Special_Priv=3";
	$rows		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
	
	$getcount = count($rows);//print_r($slaveconn);
	if($getcount >0){
		//$getrmid = "select RMUserid from rminterface.rmmemberinfo where MatriId='".$matriid."' and RMUserid !=''";

		$varActFields	= array("RMUserid");
		$varActCondtn	= " where MatriId='".$matriid."' and RMUserid !=''";
		$getrmidexec	= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,1);
		$row	= $rmclass->slave->select($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActFields,$varActCondtn,0);
		
		if(!empty($getrmidexec)){
				$row = mysql_fetch_assoc($row); 
				
					if($row['RMUserid']){
												
						$varActCondtn	= " where MatriId='".$matriid."' and RMUserid !=''";
						$getrmdetailsexec	= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'],$varActCondtn,1);
						$getrmdetailsexec1	= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'],$varActCondtn,0);
					

							if(!empty($getrmdetailsexec)){
								$rmdetailsrow = mysql_fetch_assoc($getrmdetailsexec1); 
									if($rmdetailsrow['PhoneVerified'] != 0 ) {
										
										$varUpdateFields	=array("Phone_Verified","Date_Updated","Special_Priv");
										$varUpdateVal	= array("1","Now()","4");
										$varUpdateCondtn	= " MatriId='".$matriid."'";
										$rmclass->master->update($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
                                        $wsmemClient->processRequest($matriid,"memberinfo");
										
											if($rmdetailsrow['PhoneNo1'] != ""){
												
												$tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'];
												//Added the rmdetailsrow arg in  updateassureddetails function - Jan 02
												$assureaffect = updateassureddetails($matriid,$rmdetailsrow['PhoneNo1'],$rmdetailsrow['ContactPerson1'],$rmdetailsrow['Relationship1'],$rmdetailsrow['Timetocall1'],$rmclass,$tblname,$rmdetailsrow);
											}
									}else {
										$varUpdateFields	=array("Phone_Verified","Date_Updated","Special_Priv");
										$varUpdateVal	= array("0","NOW()","4");
										$varUpdateCondtn	= " MatriId='".$matriid."'";
										$rmclass->master->update($matrimonyprofiletable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
										$wsmemClient->processRequest($matriid,"memberinfo");

									}
									if($rmdetailsrow['Email'] != ''){
										
										$EmailUpdate = EmailUpdate($matriid,$rmdetailsrow['Email'],$logininfotable,$rmclass);
									} //echo $EmailUpdate; 
									if($EmailUpdate==1){
										$getstatus = changeStatusBkuptbl($matriid,$rmclass,1);
										$varUpdateFields	= array("PrivStatus");
										$varUpdateVal	    = array("2");
										$varUpdateCondtn	= " MatriId='".$matriid."'";
										$rmclass->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
										

										$retval =1;
									}
							}  else  {
								$retval = updateprofiletable($masterconn,$matrimonyprofiletable,$rmclass,4,2,$wsmemClient);
							}
						 }	else {
								$retval = updateprofiletable($masterconn,$matrimonyprofiletable,$rmclass,4,2,$wsmemClient);
						}
					} else {
							$retval = updateprofiletable($masterconn,$matrimonyprofiletable,$rmclass,4,2,$wsmemClient);
					}
			} else $retval =0;
	return $retval; 
}// Function Closing

function partialtofull($matriid,$val,$rmclass,$wsmemClient){ 
	global $rmclass,$DBCONIP,$DBINFO,$DBNAME,$TABLE,$logininfotable,$matrimonyprofiletable,$varDbInfo,$varTable,$varCbsRminterfaceDbInfo;
	
	$varActFields	= array("MatriId");
	$varActCondtn	= " where MatriId='".$matriid."' and Paid_Status=1 and Special_Priv=4";
	$rows		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,1);
    $getcount = count($rows);

	if($getcount >0){
				
		 $varActCondtn	= " where MatriId='".$matriid."' and RMUserid !=''";
		 $getrmidexec	= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActCondtn,1);
		 $rsrow	= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'],$varActCondtn,0);


			if(!empty($getrmidexec)){
				$row = mysql_fetch_assoc($rsrow);
                  
				$varActCondtn	= " where RMUserid ='".$row['RMUserid']."'";
				$rowgetrmloginrec		= $rmclass->slave->selectAll($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMLOGININFO'],$varActCondtn,0);
                $getrmloginrec = mysql_fetch_assoc($rowgetrmloginrec);


				$varActFields	= array("Phone_Verified");
				$varActCondtn	= " where MatriId='".$matriid."'";
				$getphonedet		= $rmclass->slave->select($varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'],$varActFields,$varActCondtn,0);
                $fetchrec = mysql_fetch_assoc($getphonedet);

	
					$varActFields	= array("Email");
					$varActCondtn	= " where MatriId='".$matriid."'";
					$getmailiddet	= $rmclass->slave->select($logininfotable,$varActFields,$varActCondtn,0);
					$getemailidrec = mysql_fetch_assoc($getmailiddet);
					


					if($fetchrec['Phone_Verified'] == 1){

						$varActCondtn	= " where MatriID='".$matriid."'";
						$phonenoexec		= $rmclass->slave->selectAll($varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'],$varActCondtn,0);
						$assureddrec = mysql_fetch_assoc($phonenoexec);

						$varInsertFields	= array("RMUserId","MatriId","PhoneNo1","CountryCode","AreaCode","PhoneNo","MobileNo","ContactPerson1","Relationship1","Timetocall1","PhoneVerified","Email");
						$varInsertVal	= array("'".$row['RMUserid']."'","'".$matriid."'","'".$assureddrec['PhoneNo1']."'","'".$assureddrec['CountryCode']."'","'".$assureddrec['AreaCode']."'","'".$assureddrec['PhoneNo']."'","'".$assureddrec['MobileNo']."'","'".$assureddrec['ContactPerson1']."'","'".$assureddrec['Relationship1']."'","'".$assureddrec['Timetocall1']."'","1","'".$getemailidrec['Email']."'");
						$insertedid = $rmclass->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'], $varInsertFields, $varInsertVal);

						//$continfobkup = $rmclass->getAffectedRows(); 
						
				 }  else {
						$varInsertFields	= array("RMUserId","MatriId","PhoneNo1","ContactPerson1","Relationship1","Timetocall1","PhoneVerified","Email");
						$varInsertVal	= array("'".$row['RMUserid']."'","'".$matriid."'","''","''","''","''","0","'".$getemailidrec['Email']."'");
						$insertedid = $rmclass->master->insert($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'], $varInsertFields, $varInsertVal);


						$affectedrow = 1;//print_r($rmclass);
				}
				
				$varUpdateFields	= array("Email","Date_Updated");
				$varUpdateVal	    = array("'".$getrmloginrec['Email']."'","NOW()");
				$varUpdateCondtn	= " MatriId='".$matriid."'";
				$rmclass->master->update($logininfotable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);


				$affectedrow = 1;
				if($affectedrow == 1){
					
					if($getrmloginrec['Mobile']!="") {
					   $number = $getrmloginrec['Mobile']; 
					 } else {
					  $number  = $getrmloginrec['Phone']; 
					 }
					$mobilesep = explode("~",$number);
					$ccode     = $mobilesep[0];
					$mobileno  = $mobilesep[1];


				  	//Added the Two Fields in this Query (Countrycode,Mobile No)	- Jan 02
				    $updateassurtable = "insert into ".$varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT']." (MatriId,CountryCode,MobileNo,PhoneNo1,ContactPerson1,Relationship1,Timetocall1) values ('".$matriid."','".$ccode."','".$mobileno."','".$getrmloginrec['Mobile']."','".$getrmloginrec['Name']."',7,'office timing') ON DUPLICATE KEY update PhoneNo1='".$getrmloginrec['Mobile']."',CountryCode='".$ccode."',MobileNo='".$mobileno."',ContactPerson1='".$getrmloginrec['Name']."',Relationship1=7,Timetocall1='Office hours between 10 am to 5 pm' "; 

					$rmclass->master->ExecuteQry($updateassurtable);
					
					$db5affectedrow = 1; 
					if($db5affectedrow == 1){
						
						$varUpdateFields   = array("Phone_Verified","Date_Updated","Special_Priv");
						$varUpdateVal	   = array("1","NOW()","3");
						$varUpdateCondtn   = "  MatriId='".$matriid."'";
						$rmclass->master->update($matrimonyprofiletable, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
						$wsmemClient->processRequest($matriid,"memberinfo");

						$varUpdateFields	= array("PrivStatus");
						$varUpdateVal	    = array("1");
						$varUpdateCondtn	= "  MatriId='".$matriid."'";
						$rmclass->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

						$retval =1;
					}
				}
				
			}  else {
				    	$retval = updateprofiletable($masterconn,$matrimonyprofiletable,$rmclass,3,1,$wsmemClient);
			   }
	}else  $retval =0;
	return $retval;
}

function updateassureddetails($matriid,$phoneno,$name,$relationship,$timing,$conn,$tablename,$rmdetailsrow){
	//Added the Four Fields in this Query (Countrycode,Area Code,Phone No,Mobile No) - Jan 02
	$countrycode = $rmdetailsrow['CountryCode'];
	$areacode	 = $rmdetailsrow['AreaCode'];
	$phone		 = $rmdetailsrow['PhoneNo'];
	$mobile		 = $rmdetailsrow['MobileNo'];

	$varUpdateFields	=array("PhoneNo1","CountryCode","AreaCode","PhoneNo","MobileNo","ContactPerson1","Relationship1","Timetocall1");
	$varUpdateVal	= array("'".$phoneno."'","'".$countrycode."'","'".$areacode."'","'".$phone."'","'".$mobile."'","'".$name."'","'".$relationship."'","'".$timing."'");
	$varUpdateCondtn	= " MatriId='".$matriid."'";
	$conn->master->update($tablename, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);

	return $assuredetaffect=1;
	 
}
function EmailUpdate($matriid,$email,$tablename,$conn){
 	
	$varUpdateFields   = array("Email","Date_Updated");
	$varUpdateVal	   = array("'".$email."'","NOW()");
	$varUpdateCondtn   = " MatriId='".$matriid."'";
	$conn->master->update($tablename, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
	return $assuredetaffect=1;
}
function changeStatusBkuptbl($matriid,$conn,$status){
	global $varCbsRminterfaceDbInfo,$TABLE;
	//Added the Four Fields in this Query (Countrycode,Area Code,Phone No,Mobile No) - Jan 02
	$insertarc = "insert into ".$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUPARCHIVE']."(RMUserId,MatriId,CountryCode,AreaCode,PhoneNo,MobileNo,PhoneNo1,ContactPerson1,Relationship1,Timetocall1,PhoneVerified,Email) select RMUserId,MatriId,CountryCode,AreaCode,PhoneNo,MobileNo,PhoneNo1,ContactPerson1,Relationship1,Timetocall1,PhoneVerified,Email from ".$varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP']." where MatriId='".$matriid."'";
	
	$conn->master->ExecuteQry($insertarc);
	$continfoarc=1;
	if($continfoarc == 1){
 		
        $argTblName     = $varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['MEMBERCONTACTINFOBKUP'];
		$argCondition	= " MatriId='".$matriid."'";
		$conn->master->delete($argTblName, $argCondition);
		return $assuredetaffect=1;
	}
}
function updateprofiletable($masterconn,$tablename,$rmconn,$specprev,$privstatus,$wsmemClient){
	global $matriid,$varCbsRminterfaceDbInfo,$TABLE;
	
	$varUpdateFields	=array("Date_Updated","Special_Priv");
	$varUpdateVal	= array("NOW()",$specprev);
	$varUpdateCondtn	= " MatriId='".$matriid."'";
	$rmconn->master->update($tablename, $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
    $wsmemClient->processRequest($matriid,"memberinfo");
	$affectedrow = 1;
	if($affectedrow == 1){
		
		$varUpdateFields = array("PrivStatus");
		$varUpdateVal	 = array("'".$privstatus."'");
		$varUpdateCondtn = " MatriId='".$matriid."'";
		$rmconn->master->update($varCbsRminterfaceDbInfo['DATABASE'].".".$TABLE['RMMEMBERINFO'], $varUpdateFields, $varUpdateVal, $varUpdateCondtn);
		$affectedrows = 1;
	}
	if($affectedrows == 1) return $affectedrows;
}
?>
