<?
include_once "include/rmclass.php";

function getPhonenumber($matriid,$phonenotable,$conn,$check){
	global $tbl; 
	/*$Query="Select * from ".$phonenotable." where MatriId='".$matriid."'";
	$num=$conn->select($Query);  		
	$row = $conn->fetchArray();*/

	$varActCondtn	= " where MatriId='".$matriid."'";
    $row		    = $conn->selectAll($phonenotable,$varActCondtn,1);
	
   	if($check ==1){
			   $getval  = $row['PhoneNo1'];
		}
		else if($check ==2){
			if($row['MobileNo'] == '') {
				if(($row['CountryCode'] != '') || ($row['AreaCode'] != '') || ($row['PhoneNo'] != '')) {
					$getval  = $row['CountryCode']."/".$row['AreaCode']."/".$row['PhoneNo'];
			   }
			} else {
				 $getval  = $row['MobileNo'];
			}
		}
	
	return $getval;

}

if(isset($_REQUEST['matriid'])){
$phonedet = 0;
$matriid=$_REQUEST['matriid'];
$rmclass=new srmclassname();
$rmclass->srminit();
$rmclass->srmConnect();


/*$senderdomaininfo = getDomainInfo(1,$matriid);
$senderdomainname =strtoupper($senderdomaininfo['domainnameshort']);
$senderdomainnamelong = $senderdomaininfo['domainmodule'];
$senderprofiletable   = $DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[$senderdomainname]['MATRIMONYPROFILE'];*/
$senderprofiletable   = $varDbInfo['DATABASE'].".".$varTable['MEMBERINFO'];


//$slaveconn->dbConnById(2, $matriid,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
//$slaveconn=new srmclassname();
//$slaveconn->srmCommunityConnect();


$contact=$rmclass->ContactInfobkup($matriid,$senderprofiletable,$slaveconn);
if($contact != 0){
	$val =1;
	//$db5 = new db();
	//$db5->connect($DBCONIP['DB5'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['ASSUREDCONTACT']);
	$tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACT'];

	$getval = getPhonenumber($matriid,$tblname,$rmclass->slave,$val);
	$phonedet = 1;
}
else if ($contact == 0){
   $val =2;
   $tblname = $varDbInfo['DATABASE'].".".$varTable['ASSUREDCONTACTBEFOREVALIDATION'];
   //$db5 = $slaveconn;
   $getval = getPhonenumber($matriid,$tblname,$rmclass->slave,$val);
   $phonedet = 1;
}
else {
	 $phonedet = 1;
}
echo "<div class=\"normaltext2\">".str_replace("~","-",$getval)."</div>";
} 
?>