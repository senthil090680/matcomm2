<?
/*
	****************************************************************************************************************
	Description:
	This file is used to Split the phoneno and mobileno field into separate field for india...
	Modification History
	****************************************************************************************************************
	Version				Date				Author					Remarks
	****************************************************************************************************************
	(0.1				03/10/2008			Hameed.J		Initial version)
	*****************************************************************************************************************/
	#Supress notice errors alone
	error_reporting(E_ALL);
	//$DOCROOTBASEPATH = '/home/testbharat/';
	$DOCROOTBASEPATH = '/home/profilebharat/';
	include_once $DOCROOTBASEPATH."bmconf/bmvars.cil14";
	include_once $DOCROOTBASEPATH."bmconf/bminit.cil14"; // This includes all common functions
	include_once $DOCROOTBASEPATH."bmconf/bmip.cil14";
	include_once $DOCROOTBASEPATH."bmconf/bmdbinfo.cil14";
	include_once $DOCROOTBASEPATH."bmlib/bmsqlclass.cil14";
	include_once $DOCROOTBASEPATH."bmlib/bmgenericfunctions.cil14"; 
	ini_set("memory_limit","1024M");

	//$TABLE['ASSUREDCONTACT'] = 'assuredcontact';
	//$TABLE['ASSUREDCONTACTBEFOREVALIDATION'] = 'assuredcontactbeforevalidation';

	$db14 = new db();
	$db14->connect($DBCONIP['DB14'], $DBINFO['USERNAME'], $DBINFO['PASSWORD'], $DBNAME['RMINTERFACE']);

	
	// Query for assured contact before validation starts 
	//$selectQry = "select MatriId,PhoneNo1 from ".$DBNAME['RMINTERFACE'].".".$TABLE['ASSUREDCONTACTBEFOREVALIDATION'];
	//$tblname = $TABLE['ASSUREDCONTACTBEFOREVALIDATION'];
	// Query for assured contact before validation ends
	
	// Query for assured contact after validation starts
	$selectQry = "select MatriId,PhoneNo1 from ".$DBNAME['RMINTERFACE']."."."memberContactInfobkuparchive"." where (PhoneNo='' and MobileNo='' and PhoneNo1<>'')";

	$tblname ="memberContactInfobkuparchive";
	// Query for assured contact after validation ends
	$affCnt = $db14->select($selectQry);
	$resultphonenos = $db14->getResultArray();

	foreach($resultphonenos as $resultph)
	{
		$phno = $resultph['PhoneNo1'];
		$mid = $resultph['MatriId']; 
		echo $mid."\n";

		if($phno != '')
		{
			$phno = $resultph['PhoneNo1'];
			$splitnos = explode('~',$phno);

			// Phone no split up for INDIA starts

			if($splitnos[0] == 91)
			{
				$countrycode = '';
				$mobileno = '';
				$areacode = '';
				$phoneno = '';

				if(count($splitnos) == 2)
				{
					$countrycode = trim($splitnos[0]);
					$mobileno = trim($splitnos[1]); 
					$updatetbl = "update ".$DBNAME['RMINTERFACE'].".".$tblname." set CountryCode='".$countrycode."',MobileNo='".$mobileno."' where MatriId='$mid'";
					$db14->update($updatetbl);
				}
				else if(count($splitnos) > 2 )
				{
					$countrycode = trim($splitnos[0]);
					$areacode = trim($splitnos[1]);
					
					if($areacode != '') 
					{
						$phoneno = trim($splitnos[2]);
						$updatetbl = "update ".$DBNAME['RMINTERFACE'].".".$tblname." set CountryCode='".$countrycode."',AreaCode='".$areacode."',PhoneNo='".$phoneno."'  where MatriId='$mid'";
					}
					else 
					{
						$mobileno = trim($splitnos[2]);
						$updatetbl = "update ".$DBNAME['RMINTERFACE'].".".$tblname." set CountryCode='".$countrycode."',AreaCode='".$areacode."',MobileNo='".$mobileno."'  where MatriId='$mid'";
					}
					$db14->update($updatetbl);
				}
			}
			// Phone no split up for INDIA ends
			// Country Code with more than 3 digits if already exist starts
			else if(strlen(trim($splitnos[0])) > 3){
				  $countrycode = '';
				  $areacode = '';
				  $phoneno = '';
				  $mobno = '';
				  $split1 = '';
				if(count($splitnos) == 3)
				{
					$areacode = trim($splitnos[0]);
					$areaval = trim($splitnos[1]);
					if(trim($areaval)!='')
						$split1 = trim($splitnos[1]);
					else
						$split1 = trim($splitnos[2]);
				}

				  if(strlen($split1) <7)
				  {
					$phoneno = trim($split1); 
				  }
				  else if(strlen($split1) >= 7)
				  {
					$mobno = trim($split1);
				  }
					$updatetbl = "update ".$DBNAME['RMINTERFACE'].".".$tblname." set AreaCode='".$areacode."',PhoneNo='".$phoneno."',MobileNo='".$mobno."'  where MatriId='$mid'";
					$db14->update($updatetbl);
			}
			// Country Code with more than 3 digits if already exist ends
			// Phone no split up for OTHER COUNTRIES starts

			else {
				$countrycode = '';
				$areacode = '';
				$phoneno = '';
				$mobno = '';
				$split1 = '';
				$split2 = '';
			if(count($splitnos) == 3)
			{
				$countrycode = trim($splitnos[0]);
				$split1 = strlen(trim($splitnos[1]));
				$split2 = strlen(trim($splitnos[2]));
				
				// for Areacode split
				$areacode = trim($splitnos[1]);
				/*if($split1 > 2 && $split1 <= 5){
					$areacode = $splitnos[1]; 
				}
				else{
					$areacode = $splitnos[1];
				}*/

				// for Phoneno split
				if($split2 >=5 && $split2 <7){
					$phoneno = trim($splitnos[2]); 
				}
				else{
					$phoneno='';
				}
				// for Mobileno split
				if($split2 >=7){
					$mobno = trim($splitnos[2]); 
				}
				else{
					$mobno ='';
				}
			}
			else if(count($splitnos) == 2)
			{
				$countrycode = trim($splitnos[0]);
				$split1 = strlen(trim($splitnos[1]));
				
				// for Phoneno split
				if($split1 >=5 && $split1 <7){
					$phoneno = trim($splitnos[1]); 
				}
				else{
					$phoneno='';
				}
				// for Mobileno split
				if($split1 >=7){
					$mobno = trim($splitnos[1]); 
				}
				else{
					$mobno ='';
				}
			}
				$updatetbl = "update ".$DBNAME['RMINTERFACE'].".".$tblname." set CountryCode='".$countrycode."',AreaCode='".$areacode."',PhoneNo='".$phoneno."',MobileNo='".$mobno."'  where MatriId='$mid'";
				$db14->update($updatetbl);
			}
			// Phone no split up for OTHER COUNTRIES ends
		}
	}
 
	echo "Updation Completed successfully";
	$db14->dbClose();
?>