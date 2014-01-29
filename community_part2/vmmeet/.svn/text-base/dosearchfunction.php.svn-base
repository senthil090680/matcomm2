<?php
$member_id=$_COOKIE['Memberid'];
$gender=$_COOKIE['Gender'];
// Functions //


function do_search () {
	global  $member_id, $dblink, $membership_entry,$gender;
	$heightsrchhash=array (1=>"121.92",2=>"124.46",3=>"127.00",4=>"129.54",5=>"132.08",6=>"134.62",7=>"137.16",8=>"139.70",9=>"142.24",10=>"144.78",11=>"147.32",12=>"149.86",13=>"152.40",14=>"154.94",15=>"157.48",16=>"160.02",17=>"162.56",18=>"165.10",19=>"167.74",20=>"170.18",21=>"172.72",22=>"175.26",23=>"177.80",24=>"180.34",25=>"182.88",26=>"185.42",27=>"187.96",28=>"190.50",29=>"193.04",30=>"195.58",31=>"198.12",32=>"200.66",33=>"203.20",34=>"205.74",35=>"208.28",36=>"210.82",37=>"213.36",38=>"215.90",39=>"218.44",40=>"220.98",41=>"223.52",42=>"226.06",43=>"228.60",44=>"231.14",45=>"233.68",46=>"236.22",47=>"238.76",48=>"241.30");

	// Variable declaration of post fields...
	$Search_Type		= trim($_REQUEST['SEARCH_TYPE']);
	$Gender				= trim($gender);
	$StAge				= trim($_REQUEST['STAGE']);
	$EndAge				= trim($_REQUEST['ENDAGE']);
	$StHeight			= trim($_REQUEST['STHEIGHT']);
	$EndHeight			= trim($_REQUEST['ENDHEIGHT']);
	$SubCaste			= trim($_REQUEST['SUBCASTE']);
	$PhotoAvailable		= trim($_REQUEST['PHOTO_OPT']);

	// Query assigning starts...
	$SearchQuery = " ";
	// Gender checking...
	/*if (trim($Gender) != '' && trim($Gender) != '0') {
		$SearchQuery .= " Gender != '$Gender' ";
	}*/

	// Marital Status checking...
	if (is_array($_REQUEST['MARITAL_STATUS'])) {
		$chkzero = 0;
		foreach($_REQUEST['MARITAL_STATUS'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$MaritalStatus = " MaritalStatus=1 or MaritalStatus=2 or MaritalStatus=3 or MaritalStatus=4 ";
				break;
			} else {
				$MaritalStatus .= " MaritalStatus = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$MaritalStatus = substr ($MaritalStatus, 0, strlen($MaritalStatus)-3);
		}
	} elseif (trim($_REQUEST['MARITAL_STATUS']) != '') {
		if ($_REQUEST['MARITAL_STATUS'] > 0 ) {
			$MaritalStatus = " MaritalStatus = '". $_REQUEST['MARITAL_STATUS'] . "' ";
		} elseif (trim($_REQUEST['MARITAL_STATUS']) == 0) {
			$MaritalStatus = " MaritalStatus=1 or MaritalStatus=2 or MaritalStatus=3 or MaritalStatus=4 ";
		}
	}

	// MaritalStatus checking...
	if (trim($MaritalStatus) != '') {
		$SearchQuery .= " and ($MaritalStatus) ";
	}

	// HavingChildren checking...
	
	// Age checking...
	if (trim($StAge) != '' && trim($EndAge) != '') {
		$SearchQuery .= " and Age >= '$StAge' and Age <= '$EndAge' ";
	}

	// Height Checking...
	if ($StHeight != '' && $EndHeight != '') {
		$stheight1=floor($heightsrchhash[$StHeight]);
		$endheight1=ceil($heightsrchhash[$EndHeight]);
		$SearchQuery .= " and Height >= $stheight1 and Height <= $endheight1 ";
	}

	// PHYSICAL_STATUS checking...
	//if PhysicalStatus=2 it is doesnt matter. dont form query for specialcase 
	
	// SubCaste checking...
	if (trim($SubCaste) != '') {
		$SearchQuery .= " and SubCaste like '%$SubCaste%' ";
	}
	// Education checking...
	if (is_array($_REQUEST['EDUCATION1'])) {
		$chkzero = 0;
		foreach($_REQUEST['EDUCATION1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$EducationSelected = "";
				break;
			} else {
				$EducationSelected .= " EducationSelected = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$EducationSelected = substr ($EducationSelected, 0, strlen($EducationSelected)-3);
		}
	} elseif (trim($_REQUEST['EDUCATION1']) != '') {
		if ($_REQUEST['EDUCATION1'] > 0 ) {
			$EducationSelected = " EducationSelected = '". $_REQUEST['EDUCATION1'] . "' ";
		} elseif (trim($_REQUEST['EDUCATION1']) == 0) {
			$EducationSelected = "";
		}
	}

	// EducationSelected checking...
	if (trim($EducationSelected) != '') {
		$SearchQuery .= " and ($EducationSelected) ";
	}

	// Citizenship checking...
	if (is_array($_REQUEST['CITIZENSHIP1'])) {
		$chkzero = 0;
		foreach($_REQUEST['CITIZENSHIP1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$Citizenship = "";
				break;
			} else {
				if (count($_REQUEST['CITIZENSHIP1']) > 30) {
					$error_msg = "CITIZENSHIP";
				}
				$Citizenship .= " Citizenship = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$Citizenship = substr ($Citizenship, 0, strlen($Citizenship)-3);
		}
	} elseif (trim($_REQUEST['CITIZENSHIP1']) != '') {
		if ($_REQUEST['CITIZENSHIP1'] > 0 ) {
			$Citizenship = " Citizenship = '". $_REQUEST['CITIZENSHIP1'] . "' ";
		} elseif (trim($_REQUEST['CITIZENSHIP1']) == 0) {
			$Citizenship = "";
		}
	}

	// Citizenship checking...
	if (trim($Citizenship) != '') {
		$SearchQuery .= " and ($Citizenship) ";
	}

	// CountrySelected checking...
	if (is_array($_REQUEST['COUNTRY1'])) {
		$chkzero = 0;
		$countryindia = 0;
		$countryus = 0;
		$othercountry = 0;
		$iscountry = '';
		foreach($_REQUEST['COUNTRY1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$CountrySelected = "";
				$iscountry = 'any';
				break;
			} else {
				if (count($_REQUEST['COUNTRY1']) > 30) {
					$error_msg = "COUNTRY";
				}
				if ($val == 98 || $val == 222) {
				if ($val == 98) {
					$countryindia = 1;
				} 
				if ($val == 222) {
					$countryus = 1;
				}
				} else {
					$CountrySelected .= " CountrySelected = '$val' or ";
					$othercountry = 1;
				}
			}
		}
		if ($chkzero != 1) {
			$CountrySelected = substr ($CountrySelected, 0, strlen($CountrySelected)-3);
		}
	} elseif (trim($_REQUEST['COUNTRY1']) != '') {
		if ($_REQUEST['COUNTRY1'] > 0 ) {
			$CountrySelected = " CountrySelected = '". $_REQUEST['COUNTRY1'] . "' ";
		} elseif (trim($_REQUEST['COUNTRY1']) == 0) {
			$CountrySelected = "";
		}
	}

	if ($countryindia == 1) {
	// ResidingIndia checking...
	if (is_array($_REQUEST['RESIDINGINDIA1'])) {
		$chkzero = 0;
		foreach($_REQUEST['RESIDINGINDIA1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$ResidingState = "";
				break;
			} else {
				if (count($_REQUEST['RESIDINGINDIA1']) > 30) {
					$error_msg = "RESIDING IN INDIA";
				}
				$ResidingState .= " ResidingState = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$ResidingState = substr ($ResidingState, 0, strlen($ResidingState)-3);
		}
	} elseif (trim($_REQUEST['RESIDINGINDIA1']) != '') {
		if ($_REQUEST['RESIDINGINDIA1'] > 0 ) {
			$ResidingState = " ResidingState = '". $_REQUEST['RESIDINGINDIA1'] . "' ";
		} elseif (trim($_REQUEST['RESIDINGINDIA1']) == 0) {
			$ResidingState = "";
		}
	}

	// ResidingIndia checking...
	if (trim($ResidingState) != '') {
		if ($othercountry == 1) {
			$indiaSearchQuery = " or (CountrySelected =98 and ($ResidingState)) ";
		} else {
			$indiaSearchQuery = " (CountrySelected =98 and ($ResidingState)) ";
		}
	} else {
		if ($othercountry == 1) {
			$indiaSearchQuery = " or (CountrySelected =98) ";
		} else {
			$indiaSearchQuery = " (CountrySelected =98) ";
		}
	}
	}

	if ($countryus == 1) {
	// Residingusa checking...
	if (is_array($_REQUEST['RESIDINGUSA1'])) {
		$chkzero = 0;
		foreach($_REQUEST['RESIDINGUSA1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$ResidingUsState = "";
				break;
			} else {
				if (count($_REQUEST['RESIDINGUSA1']) > 30) {
					$error_msg = "RESIDING IN USA";
				}
				$ResidingUsState .= " ResidingState = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$ResidingUsState = substr ($ResidingUsState, 0, strlen($ResidingUsState)-3);
		}
	} elseif (trim($_REQUEST['RESIDINGUSA1']) != '') {
		if ($_REQUEST['RESIDINGUSA1'] > 0 ) {
			$ResidingUsState = " ResidingState = '". $_REQUEST['RESIDINGUSA1'] . "' ";
		} elseif (trim($_REQUEST['RESIDINGUSA1']) == 0) {
			$ResidingUsState = "";
		}
	}

	// RESIDINGUSA checking...
	if (trim($ResidingUsState) != '') {
		if ($othercountry == 1 || $countryindia == 1) {
			$usSearchQuery = " or (CountrySelected = 222 and ($ResidingUsState)) ";
		} else {
			$usSearchQuery = " (CountrySelected = 222 and ($ResidingUsState)) ";
		}
	} else {
		if ($othercountry == 1 || $countryindia == 1) {
			$usSearchQuery = " or (CountrySelected = 222) ";
		} else {
			$usSearchQuery = " (CountrySelected = 222) ";
		}
	}
	}

	// Country checking...
	if (trim($CountrySelected) != '') {
		if ($countryindia != 1 && $countryus != 1) {
			$SearchQuery .= " and ($CountrySelected) ";
		} else {
			$SearchQuery .= " and ($CountrySelected".$indiaSearchQuery.$usSearchQuery.") ";
		}
	} else {
		if ($_REQUEST['COUNTRY1'] != '') {
			if ($iscountry != 'any') {
				$SearchQuery .= " and ($CountrySelected".$indiaSearchQuery.$usSearchQuery.") ";
			}
		}
	}

	// RESIDENTSTATUS checking...
	if (is_array($_REQUEST['RESIDENTSTATUS1'])) {
		$chkzero = 0;
		foreach($_REQUEST['RESIDENTSTATUS1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$ResidentStatus = "";
				break;
			} else {
				$ResidentStatus .= " ResidentStatus = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$ResidentStatus = substr ($ResidentStatus, 0, strlen($ResidentStatus)-3);
		}
	} elseif (trim($_REQUEST['RESIDENTSTATUS1']) != '') {
		if ($_REQUEST['RESIDENTSTATUS1'] > 0 ) {
			$ResidentStatus = " ResidentStatus = '". $_REQUEST['RESIDENTSTATUS1'] . "' ";
		} elseif (trim($_REQUEST['RESIDENTSTATUS1']) == 0) {
			$ResidentStatus = "";
		}
	}

	// RESIDENTSTATUS checking...
	if (trim($ResidentStatus) != '') {
		$SearchQuery .= " and ($ResidentStatus) ";
	}

	if ($indiaSearchQuery != '') {
	// City checking...
	if (is_array($_REQUEST['CITY1'])) {
		$chkzero = 0;
		foreach($_REQUEST['CITY1'] as $key => $val) {
			if ($val == 0) {
				$chkzero = 1;
				$City = "";
				break;
			} else {
				if (count($_REQUEST['CITY1']) > 30) {
					$error_msg = "CITY";
				}
				$City .= " ResidingDistrict = '$val' or ";
			}
		}
		if ($chkzero != 1) {
			$City = substr ($City, 0, strlen($City)-3);
		}
	} elseif (trim($_REQUEST['CITY1']) != '') {
		if ($_REQUEST['CITY1'] > 0 ) {
			$City = " ResidingDistrict = '". $_REQUEST['CITY1'] . "' ";
		} elseif (trim($_REQUEST['CITY1']) == 0) {
			$City = "";
		}
	}

	// City checking...
	if (trim($City) != '') {
		$SearchQuery .= " and ($City) ";
	}
	}

	// With OtherCity checking...
	if ($CountrySelected != '' || $usSearchQuery != '') {
		if (trim($OtherCity) != '') {
			$SearchQuery .= " and ResidingCity like '$OtherCity%' ";
		}
	}

	// With Photo checking...
	if ($PhotoAvailable != '' && $PhotoAvailable == 'Y') {
		$SearchQuery .= " and PhotoAvailable = '1' ";
		if (trim($_REQUEST['SEARCH_TYPE']) == "QUICK") {
			$SearchQuery .= " and (PhotoProtected is NULL or PhotoProtected = 'N' or PhotoProtected = '') ";
		}
	}

	// Includes Status, Validated, Authorized in query...
      $SearchQuery .= " and Status=0 and Validated=1 and Authorized=1 ";

	// Posted Date Checking...

	if ($Days != '') {
		if ($Days == 'P') {
			if ($StDay < 10) {
				$StDay = '0'.$StDay;
			}
			if ($StMonth < 10) {
				$StMonth = '0'.$StMonth;
			}
			$PostedDate = $StYear."-".$StMonth."-".$StDay;
		}

		if ($Days == 'A' && $DateOpt == 'C') {
			$OrderBy = " TimeCreated desc ";
		} elseif ($Days == 'P' && $DateOpt == 'C') {
			$SearchQuery .= " and DATE_FORMAT(TimeCreated, '%Y-%m-%d') > '$PostedDate'  ";
			$OrderBy = " TimeCreated desc ";
		} elseif ($Days == 'A' && $DateOpt == 'U') {
			if ($membership_entry != '' && $membership_entry == 'F') {
				$OrderBy = " LastLogin desc ";
			} else {
				$OrderBy = " TimePosted desc ";
			}
		} elseif ($Days == 'P' && $DateOpt == 'U') {
			if ($membership_entry != '' && $membership_entry == 'F') {
				$SearchQuery .= " and DATE_FORMAT(TimePosted, '%Y-%m-%d') > '$PostedDate'  ";
				$OrderBy = " LastLogin desc ";
			} else {
				$SearchQuery .= " and DATE_FORMAT(TimePosted, '%Y-%m-%d') > '$PostedDate'  ";
				$OrderBy = " TimePosted desc ";
			}
		}elseif($Days == 'A' && $DateOpt == 'L') {
			$OrderBy = " LastLogin desc ";
		} elseif ($Days == 'P' && $DateOpt == 'L') {
			$SearchQuery .= " and DATE_FORMAT(LastLogin, '%Y-%m-%d') > '$PostedDate'  ";
			$OrderBy = " LastLogin desc ";
		} else {
			$OrderBy = " LastLogin desc ";
		}
	} else {
		if ($membership_entry != '' && $membership_entry == 'F') {
			$OrderBy = " LastLogin desc ";
		} else {
			$OrderBy = " TimePosted desc ";
		}
	}
	// Limiting and Order By the Query...
	 $SearchQuery .= " order by $OrderBy ";
	// Framed Search Query is return here...
	$SearchQueryReturn[0] = $SearchQuery;
	$SearchQueryReturn[1] = $error_msg;
	
	return $SearchQueryReturn;
}
?>