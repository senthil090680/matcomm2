<?php
		function displayAstroTable($title,$matriid,$memgender,$objSlaveDB) //******pending construct data fields with Gender value....*****
		{//This function will display the html fields to get the input from the user
			global $reportlangarray, $chartformatarray, $astromethodarray,$db1,$DBNAME,$DOMAINTABLE,$domainlangmemberid,$domainimgspath,$varTable;
			$gender = "";
			if($memgender == "M")
			{
				$gender = "M";
			}
			else if($memgender == "F")
			{
				$gender = "F";
			}
			$memberidcookie	= $varGetCookieInfo['MATRIID'];
            
			//Get the details from astromatch table... if one exist...
			$varCondition				= " WHERE MatriId= ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$varFields					= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			$memAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
			$datastro       			= mysql_fetch_array($memAstroExe);

			//Get the details from horodetails table
			$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$varFields	    = array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','BirthCity','BirthState','BirthCountry','BirthLongitude','BirthLatitude');
			$varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
			$dathoro	    = mysql_fetch_array($varExecute);
            
			$Country_Id     = $dathoro['BirthCountry'];
			$varCondition	= " WHERE Country_Id='".$dathoro['BirthCountry']."'";
			$varFields	    = array('Country_Name');
			$varExecute	    = $objSlaveDB->select($varTable['HOROCOUNTRIES'], $varFields, $varCondition,0);
			$countryDet     = mysql_fetch_array($varExecute);
            $dathoro["BirthCountry"] = $countryDet["Country_Name"];

			$varCondition	= " WHERE StateId='".$dathoro['BirthState']."'";
			$varFields	    = array('StateName');
			$varExecute	    = $objSlaveDB->select($varTable['HOROINDIANSTATES'], $varFields, $varCondition,0);
			$stateDet       = mysql_fetch_array($varExecute);
            $State_Name     = $stateDet["StateName"];



			//get the name of the loginmember...
			$varFields					= array('Name');
			$varCondition	            = " WHERE MatriId =  ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$memResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
			$datlogin           		= mysql_fetch_assoc($memResult);

			if(trim($dathoro["BirthCountry"]) != "India")
			{
				$varFields					= array('Country_Id','State_Id','State_Name');
				$varCondition	            = " WHERE State_Id='".addslashes(trim($dathoro["BirthState"]))."' and Country_Id=".$Country_Id."";
				$memResult					= $objSlaveDB->select($varTable['HORONRISTATES'], $varFields, $varCondition,0);
				$astroresultset         	= mysql_fetch_assoc($memResult);
				$State_Name                 = $astroresultset["State_Name"];

				$varFields					= array('City_Name','Longitude','Latitude','Timezone');
				$varCondition	            = " WHERE State_Id=".trim($dathoro["BirthState"])." and City_Id='".trim($dathoro["BirthCity"])."'";
				$memResult					= $objSlaveDB->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
				$datastrodist         	    = mysql_fetch_assoc($memResult);
				$dathoro["BirthCity"]       = $datastrodist['City_Name'];
			}
						

			if(trim($dathoro["BirthMeridian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
			{
				if(trim($dathoro["BirthMeridian"]) == "PM")
				{
					//SINCE ITS IN PM ADD 12 HRS TO THE EXISTING HR.
					$birthhour = $dathoro["BirthHour"] + 12;
					if(trim($birthhour) == 24) 
					{
						$birthhour = trim($dathoro["BirthHour"]); //since its comes to 24 use 12 itself. otherwise use the calculated time(hr +12)
					}
				}
				else
				{
					if(trim($dathoro["BirthMeridian"]) == "AM")
					{
						//SINCE ITS 12 AM it has to be changed to 0 hrs.
						if(trim($dathoro["BirthHour"]) == "12") //AM and comes to 12 so make it as zero
							$birthhour = 0;
						else
							$birthhour = trim($dathoro["BirthHour"]);
					}
				}
			}
			else
			{
				$birthhour = trim($dathoro["BirthHour"]);	
			}

			settype($birthhour,"integer");
			if($birthhour < 10)
			{
				$birthhour = '0'.$birthhour;
			}

			$astrotable = '<div class="fleft"><div style="float:left; width:230px !important;width:232px;height:400px !important;height:415px;" class="brdr">
		<div style="float:left; width:230px; background:url('.$confValues["IMAGEURL"].'/images/live-hlp-div-bg.gif) repeat-x; margin:1 0 1 0;"><div style="margin:0 2 2 10;"><div style="width:205px;">

					<div class="bld normtxt clr">'.$title.'</font></div>

					<div class="dottedline" style="background: url('.$confValues["IMAGEURL"]."/images/dot.gif".') repeat-x 0px 3px;"><br>

					<font class="smalltxt"><b>Matrimony ID</b></font>
					<div class="smalltxt">'.$matriid.'<input type="hidden" size=25 name="'.$gender.'_REGNO" class="addtextfiled" value="'.$matriid.'"></div>
					
					<div class="smalltxt" style="padding-top:10px;"><b>Name</b></div>
					<div class="smalltxt"><input type="hidden" size=25 name="'.$gender.'_PERSON_FNAME" class="addtextfiled" value="'.$datlogin["Name"].'">'.$datlogin["Name"].'</div>

					<div class="smalltxt" style="padding-top:10px;"><b>Date of Birth</b></div>
					<div class="smalltxt">'.$dathoro["BirthDay"].'-'.$dathoro["BirthMonth"].'-'.$dathoro["BirthYear"].'<input type="hidden" NAME="'.$gender.'_BIRTH_DAY" value='.$dathoro["BirthDay"].'><input type="hidden" NAME="'.$gender.'_BIRTH_MONTH" value='.$dathoro["BirthMonth"].'><input type="hidden" NAME="'.$gender.'_BIRTH_YEAR" value='.$dathoro["BirthYear"].'></div>
					
					<div class="smalltxt " style="padding-top:10px;"><b>Time of Birth</b></div>
					<div class="smalltxt">'.$birthhour.' Hr '.$dathoro["BirthMinute"].' Min '.$dathoro["BirthSeconds"].' Sec [24 Hr]<input type="hidden" NAME="'.$gender.'_BIRTH_HOUR" value='.$dathoro["BirthHour"].'><input type="hidden" NAME="'.$gender.'_BIRTH_MIN" value='.$dathoro["BirthMinute"].'><input type="hidden" NAME="'.$gender.'_BIRTH_SEC" value='.$dathoro["BirthSeconds"].'></div>';

					$astrotable .= '<!--country selection -->
					<div class="smalltxt" style="padding-top:10px;"><b>Country of Birth</b></div>
					<div class="smalltxt">'.$dathoro["BirthCountry"].'<input type=hidden NAME="'.$gender.'_Countries" id="'.$gender.'_Countries" value="'.$dathoro["BirthCountry"].'"></div>';
					
					$astrotable .='<!--endcountry--><!--state selection -->
					
					<div class="smalltxt " style="padding-top:10px;"><b>State of Birth</b></div>
					<div class="smalltxt">'.$State_Name.'<input type="hidden" id="'.$gender.'_States" name="'.$gender.'_States" value="'.$dathoro["BirthState"].'"><input type="hidden" name="populateState" value="'.$dathoro["BirthState"].'"><input type="hidden" name="populateCity" value="'.$dathoro["BirthCity"].'"></div>';
					
					$astrotable .='<!--endstate--><!--city selection -->
					<div class="smalltxt " style="padding-top:10px;"><b>City of Birth</b></div>
					<div class="smalltxt">'.$dathoro["BirthCity"].'<input type="hidden" id="'.$gender.'_Cities" name="'.$gender.'_Cities" value="'.$dathoro["BirthCity"].'"></div>';

					$astrotable .='<div class="smalltxt " style="padding-top:10px;"><b>Time correction</b></div>
					<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_TIMECORRECTION" size="1">
					<option value="1"';
					if($datastro["TimeCorrection"] == 1)
						$astrotable .= " Selected";
					$astrotable .= '>Standard Time</option>
					<option value="2"';
					if($datastro["TimeCorrection"] == 2)
						$astrotable .= " Selected";
					$astrotable .= '>Daylight Saving</option></select>';
					if(trim($dathoro["BirthCountry"]) != "India")
						{
						$astrotable .= '&nbsp;&nbsp;<span id="ToolTipLink1" class="clr1 smalltxt" style="cursor: hand; cursor: pointer;display:inline;" onClick="popHoroDetails();">What is this?</span>';
						}
					$astrotable .= '</div></div>';
					
					//get the longitude and latitude details from horodetails table and split it and store it here for match purpose...
					//check for country. if its India then get the long and lat value from horodistrict table. If Other Country then get from horo_states and horo_cities.
					
					if(trim($dathoro["BirthCountry"]) == "India")
					{
						//get the values from horodistrict. Here v r having statename so get the state id first. 
						//now get the longitude and latitude values from horodistrict table using the stateid and district name(city)...
						if(trim($dathoro["BirthCity"]) == "Chandigarh"){ //if chandigarh then no state check needed.

							$varFields					= array('Longitude','Latitude','Country','Timezone');
							$varCondition	            = " WHERE District = '".trim($dathoro["BirthCity"])."'";
						    $memResult					= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, $varCondition,0);
						    $datastrodist         		= mysql_fetch_assoc($memResult);

						}
						else{
							$varFields					= array('Longitude','Latitude','Country','Timezone');
							$varCondition	            = " WHERE StateId = '".trim($dathoro["BirthState"])."'";
						    $memResult					= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, $varCondition,0);
						    $datastrodist         		= mysql_fetch_assoc($memResult);
							
						}

						$longarray = explode(".",$datastrodist["Longitude"]);
						$longdeg = $longarray[0]; //format 000.00E
						if(strlen($longdeg) == 1)
							$longdeg = "00".$longdeg;
						else if(strlen($longdeg) == 2)
							$longdeg = "0".$longdeg;
						
						$longmin = substr($longarray[1],0,2);
						if(strlen($longmin) == 1)
							$longmin = "0".$longmin;

						$longdir = substr($longarray[1],2,1);
						if(strlen($longdir) == 0)
							$longdir = "W"; //if no direction then W by default... (By Sashish)


						$latarray = explode(".",$datastrodist["Latitude"]);
						$latdeg = $latarray[0]; //format 00.00E
						if(strlen($latdeg) == 1)
							$latdeg = "0".$latdeg;

						$latmin = substr($latarray[1],0,2);
						if(strlen($latmin) == 1)
							$latmin = "0".$latmin;

						$latdir = substr($latarray[1],2,1);
						if(strlen($latdir) == 0)
							$latdir = "W"; //if no direction then W by default... (By Sashish)

						$timezoneval = $datastrodist["Timezone"];
					}
					else if(trim($dathoro["BirthCountry"]) == "Other Country")
					{
						//for our old other country members...
						//now get the longitude and latitude values from horodistrictothers table using the district(city) name alone
						$varFields					= array('Longitude','Latitude','Timezone');
						$varCondition	            = " WHERE city = '".trim($dathoro["BirthCity"])."'";
						$memResult					= $objSlaveDB->select($varTable['HOROALLCOUNTRIESCITIES'], $varFields, $varCondition,0);
						$datastrodist         		= mysql_fetch_assoc($memResult);
						

						$longarray = explode(".",$datastrodist["Longitude"]);
						$longdeg = $longarray[0];
						if(strlen($longdeg) == 1)
							$longdeg = "00".$longdeg;
						else if(strlen($longdeg) == 2)
							$longdeg = "0".$longdeg;

						$longmin = substr($longarray[1],0,2);
						if(strlen($longmin) == 1)
							$longmin = "0".$longmin;

						$longdir = substr($longarray[1],2,1);
						if(strlen($longdir) == 0)
							$longdir = "W"; //if no direction then W by default... (By Sashish)

						$latarray = explode(".",$datastrodist["Latitude"]);
						$latdeg = $latarray[0];
						if(strlen($latdeg) == 1)
							$latdeg = "0".$latdeg;

						$latmin = substr($latarray[1],0,2);
						if(strlen($latmin) == 1)
							$latmin = "0".$latmin;

						$latdir = substr($latarray[1],2,1);
						if(strlen($latdir) == 0)
							$latdir = "W"; //if no direction then W by default... (By Sashish)

						$timezoneval = $datastrodist["Timezone"];
					}
					else
					{
						//New Other country members ... get the state id.
						$varFields					= array('Country_Id','State_Id','State_Name');
						$varCondition	            = " WHERE State_Id='".addslashes(trim($dathoro["BirthState"]))."' and Country_Id=".$Country_Id."";
						$memResult					= $objSlaveDB->select($varTable['HORONRISTATES'], $varFields, $varCondition,0);
						$astroresultset         	= mysql_fetch_assoc($memResult);
						
                       
						foreach($astroresultset as $datastrostateid)
						{
							$varFields					= array('City_Name','Longitude','Latitude','Timezone');
							$varCondition	            = " WHERE State_Id=".trim($dathoro["BirthState"])." and City_Name='".trim($dathoro["BirthCity"])."'";
							$memResult					= $objSlaveDB->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
							$datastrodist         	    = mysql_fetch_assoc($memResult);

							
						}

						$longarray = explode(".",$datastrodist["Longitude"]);
						$longdeg = $longarray[0];
						if(strlen($longdeg) == 1)
							$longdeg = "00".$longdeg;
						else if(strlen($longdeg) == 2)
							$longdeg = "0".$longdeg;

						$longmin = substr($longarray[1],0,2);
						if(strlen($longmin) == 1)
							$longmin = "0".$longmin;

						$longdir = substr($longarray[1],2,1);
						if(strlen($longdir) == 0)
							$longdir = "W"; //if no direction then W by default... (By Sashish)

						$latarray = explode(".",$datastrodist["Latitude"]);
						$latdeg = $latarray[0];
						if(strlen($latdeg) == 1)
							$latdeg = "0".$latdeg;

						$latmin = substr($latarray[1],0,2);
						if(strlen($latmin) == 1)
							$latmin = "0".$latmin;

						$latdir = substr($latarray[1],2,1);
						if(strlen($latdir) == 0)
							$latdir = "W"; //if no direction then W by default... (By Sashish)

						$timezoneval = $datastrodist["Timezone"];
					}

					$astrotable .= '<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LONGITUDE_HOUR" readonly value = "'.$longdeg.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LONGITUDE_MIN" readonly value = "'.$longmin.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_MIN">&nbsp;<input type="hidden" name="'.$gender.'_PLACE_LONGITUDE_DIR" readonly value = "'.$longdir.'" size=3 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_DIR"><INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LATITUDE_HOUR" readonly value = "'.$latdeg.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LATITUDE_MIN" readonly value = "'.$latmin.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_MIN">&nbsp;<input type="hidden" name="'.$gender.'_PLACE_LATITUDE_DIR" readonly value = "'.$latdir.'" size=3 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_DIR"><INPUT TYPE="hidden" NAME="'.$gender.'_TIMEZONE" readonly value = "'.$timezoneval.'" size=25 class="addtextfiled" id="'.$gender.'_TIMEZONE">';

					if($memberidcookie == $matriid) //only for login member have this hidden field.
					{
						$astrotable .= '<input type="hidden" name="hidecityval" value="'.$dathoro["BirthCity"].'">';
					}
			
					//dosham included in horomatchastrovision.php
					$astrotable .= '<input type="hidden" name="'.$gender.'_BIRTH_PLACE_NAME" value="" id="'.$gender.'_BIRTH_PLACE_NAME"> <!-- used to set the place of birth -->
					<input type="hidden" name="CUSTID" value="'.$matriid.'"> <!-- used to set the login members matriid as custid -->
					<input type="hidden" name="findlogingend" id="findlogingend" value="'.$gender.'"> <!-- used to find the login mem gender for inserting into db astromatch -->';
					if(trim($dathoro["BirthMeridian"]) != "")
						$astrotable .= '<input type="hidden" name="'.$gender.'_BirthMedian" value="'.$dathoro["BirthMeridian"].'">';
					else
						$astrotable .= '<input type="hidden" name="'.$gender.'_BirthMedian" value="">';
					
			$astrotable .= '</div></div></div></div></div>';
			return $astrotable;
		}
		function displayAstroTableNew($title,$matriid,$memgender,$objSlaveDB) //******pending construct data fields with Gender value....*****
		{//This function will display the html fields to get the input from the user
			global $reportlangarray, $chartformatarray, $astromethodarray,$db2,$DBNAME,$DOMAINTABLE,$MERGETABLE,$domainlangpartnerid,$domainimgspath,$varTable;

			$gender = "";
			if($memgender == "M")
			{
				$gender = "M";
			}
			else if($memgender == "F")
			{
				$gender = "F";
			}
			$memberidcookie	= $varGetCookieInfo['MATRIID'];
			
            //Get the details from astromatch table... if one exist...  
			$varCondition				= " WHERE MatriId= ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$varFields					= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			$memAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
			$datastro       			= mysql_fetch_array($memAstroExe);

			//Get the details from horodetails table
			$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$varFields	    = array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','BirthCity','BirthState','BirthCountry','BirthLongitude','BirthLatitude');
			$varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
			$dathoro	    = mysql_fetch_array($varExecute);

			//New Code for 24hr calculation
			$birthhour = '';
			if(trim($dathoro["BirthMeridian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
			{
				if(trim($dathoro["BirthMeridian"]) == "PM")
				{
					//SINCE ITS IN PM ADD 12 HRS TO THE EXISTING HR.
					$birthhour = $dathoro["BirthHour"] + 12;
					if(trim($birthhour) == 24) 
					{
						$birthhour = trim($dathoro["BirthHour"]); //since its comes to 24 use 12 itself. otherwise use the calculated time(hr +12)
					}
				}
				else
				{

					if(trim($dathoro["BirthMeridian"]) == "AM")
					{
						//SINCE ITS 12 AM it has to be changed to 0 hrs.
						if(trim($dathoro["BirthHour"]) == 12)
							$birthhour = 0; //AM and comes to 12 so make it as zero
						else
							$birthhour = trim($dathoro["BirthHour"]);
					}
					//$birthhour = trim($dathoro["BirthHour"]);	
				}
			}
			else
			{
				$birthhour = trim($dathoro["BirthHour"]);	
			}
			//end 24hr calculation

            //get the name of the partner...
			$varFields					= array('Name');
			$varCondition	            = " WHERE MatriId =  ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$memResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
			$datlogin           		= mysql_fetch_assoc($memResult);

			$astrotable = '<div class="fleft" style="padding-left:13px !important;padding-left:0px;"><div style="float:left; width:230px;" class="brdr"><div style="float:left; width:230px; background:url('.$confValues["IMAGEURL"].'/images/live-hlp-div-bg.gif) repeat-x; margin:1 0 1 0;"><div style="margin:0 2 2 10;"><div style="width:205px;">

			<div class="bld normtxt clr">'.$title.'</font></div>

			<div class="dottedline" style="background: url('.$confValues["IMAGEURL"]."/images/dot.gif".') repeat-x 0px 3px;"><br>

			<font class="smalltxt"><b>Matrimony ID</b></font>
			<div class="smalltxt">'.$matriid.'<input type="hidden" size=25 name="'.$gender.'_REGNO" class="addtextfiled" value="'.$matriid.'"></div>

			<div class="smalltxt " style="padding-top:7px;"><b>Name</b></div>
			<div><input type="text" name="'.$gender.'_PERSON_FNAME" class="inputtext" value="'.eregi_replace(",","",$datlogin["Name"]).'" size="35"></div>

			<div class="smalltxt " style="padding-top:7px;"><b>Date of Birth</b></div>
			<div class="smalltxt"><select  style="width:40px;" class="smalltxt" NAME="'.$gender.'_BIRTH_DAY" size="1" onchange="'.strtolower($gender).'_chkdate()">';
			for($x=1;$x<=31;$x++)
			{
					//print "<option value='$x'>$x</option>";
					$astrotable .= "<option value='$x'";
						if(trim($dathoro["BirthDay"]) == $x)
							$astrotable .= " selected";
					$astrotable .= ">$x</option>";
			}
			$astrotable .= '</select>						
			<select style="width:75px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_BIRTH_MONTH" size="1" onchange="'.strtolower($gender).'_chkdate()">';
			$month=array("January","February","March","April","May","June","July","August","September","October","November","December");
			foreach($month as $key=>$value)
			{
				$mon=$key+1;
				$astrotable .= "<option value='$mon'";
					if(trim($dathoro["BirthMonth"]) == $mon)
						$astrotable .= " selected";
				$astrotable .= ">$value</option>";
			}
			$astrotable .= '</select>						
			<select style="width:55px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_BIRTH_YEAR" size="1" onchange="'.strtolower($gender).'_chkdate()">';
			$maxyear = date("Y");
			for($x=1950;$x<=$maxyear;$x++)
			{
				$astrotable .= "<option value='$x'";
					if(trim($dathoro["BirthYear"]) == $x)
						$astrotable .= " selected";
				$astrotable .= ">$x</option>";
			}
			$astrotable .= '</select></div>';
			$astrotable .= '<div class="smalltxt boldtxt" style="padding-top:7px;">Time of Birth</div>
			<div class="smalltxt"><font class="for_language"><select style="width:40px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_BIRTH_HOUR" size="1"><option value="0" selected> Hr </option>';
			for($x=0;$x<=23;$x++)
			{
				$astrotable .= "<option value='".sprintf("%'02d",$x)."'";
					if(trim($birthhour) == $x) //get the 24hr time.
						$astrotable .= " selected";
				$astrotable .= ">".sprintf("%'01d",$x)."</option>";
			}
			$astrotable .= '</select>
			<select style="width:40px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_BIRTH_MIN" size="1"><option value="0" selected> Min </option>';
			for($x=0;$x<=59;$x++)
			{
				$astrotable .= "<option value='".sprintf("%'02d",$x)."'";
					if($dathoro["BirthMinute"] == $x)
						$astrotable .= " selected";
				$astrotable .= ">".sprintf("%'01d",$x)."</option>";
			}
			$astrotable .= '</select>						
			<select style="width:40px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_BIRTH_SEC" size="1"><option value="0" selected> Sec </option>';
			for($x=0;$x<=59;$x++)
			{
				$astrotable .= "<option value='".sprintf("%'02d",$x)."'";
					if($dathoro["BirthSeconds"] == $x)
						$astrotable .= " selected";
				$astrotable .= ">".sprintf("%'01d",$x)."</option>";
			}
			$astrotable .= '</select></font> [24 Hr] </div>';
			$astrotable .= '<!--country selection -->
			<div class="smalltxt boldtxt" style="padding-top:7px;"><span id="mcounerr" class="errortxt"></span>Country of Birth</div>
			<div><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_selNewCountry" id="'.$gender.'_selNewCountry" size="1" onChange=popCountry(this.value,"'.$matriid.'")><option value=0>-Select-</option>';
			$astrotable .= getCountries($objSlaveDB);
			$astrotable .= '</select></div>';

			$astrotable .='<!--endcountry--><!--state selection -->	
			<div class="smalltxt boldtxt" style="padding-top:7px;"><span id="mstateerr" class="errortxt"></span>State of Birth</div>
			<div id="state"><select style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_lstState1" id="'.$gender.'_lstState1" size="1" onchange=popCity(this.value,"'.$gender.'")><option value="0" selected>--Select State--</option></select></div>';

			$astrotable .='<!--endstate--><!--city selection -->	
			<div class="smalltxt boldtxt" style="padding-top:7px;"><span id="mcityerr" class="errortxt"></span>City of Birth</div>
			<div id="city"><select style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_lstcity" id="'.$gender.'_lstcity" size="1" onChange="selectcity2New(\''.$gender.'\',\''.$matriid.'\');"><option value="" selected>-Select City-</option></select></div><!--endcity-->';
					
			$astrotable .='
			<div class="smalltxt " style="padding-top:7px;"><b>Time correction</b></div>
			<div><select style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_TIMECORRECTION" size="1"><option value="1"';
			if($datastro["TimeCorrection"] == 1)
				$astrotable .= " Selected";
			$astrotable .= '>Standard Time</option>
			<option value="2"';
			if($datastro["TimeCorrection"] == 2)
				$astrotable .= " Selected";
			$astrotable .= '>Daylight Saving</option></select></div></div>';

			$astrotable .= '<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LONGITUDE_HOUR" readonly value = "" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LONGITUDE_MIN" readonly value = "" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_MIN">&nbsp;<input type="hidden" name="'.$gender.'_PLACE_LONGITUDE_DIR" readonly value = "" size=3 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_DIR"><INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LATITUDE_HOUR" readonly value = "" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LATITUDE_MIN" readonly value = "" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_MIN">&nbsp;<input type="hidden" name="'.$gender.'_PLACE_LATITUDE_DIR" readonly value = "" size=3 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_DIR"><INPUT TYPE="hidden" NAME="'.$gender.'_TIMEZONE" readonly value = "" size=25 class="addtextfiled" id="'.$gender.'_TIMEZONE">';

			if($memberidcookie == $matriid) //only for login member have this hidden field.
			{
				$astrotable .= '<input type="hidden" name="hidecityval" value="'.$dathoro["BirthCity"].'">';
				$astrotable .= '<input type="hidden" name="findlogingendNew" id="findlogingendNew"  value="'.$gender.'">';
			}
			else
			{
				$astrotable .= '<input type="hidden" name="othermemberMatid" id="othermemberMatid" value="'.$matriid.'">';
			}

			$astrotable .= '<input type="hidden" name="'.$gender.'_BIRTH_PLACE_NAME" value="" id="'.$gender.'_BIRTH_PLACE_NAME"> <!-- used to set the place of birth -->
			
			<input type="hidden" name="findlogingendNew" id="findlogingendNew" value="'.$gender.'"> <!-- used to find the login mem gender for inserting into db astromatch --> <input type="hidden" name="partnervalue" id="partnervalue"  value="0"><INPUT TYPE="hidden" NAME="'.$gender.'_SELECTED_STATE" readonly value = "" id="'.$gender.'_SELECTED_STATE">';

			if(trim($dathoro["BirthMeridian"]) != "")
				$astrotable .= '<input type="hidden" name="'.$gender.'_BirthMedian" value="'.$dathoro["BirthMeridian"].'">';
			else
				$astrotable .= '<input type="hidden" name="'.$gender.'_BirthMedian" value="">';

			$astrotable .= '</div></div></div></div></div>';
			return $astrotable;
		}

		function displayAstroTableNewValue($title,$matriid,$memgender,$objSlaveDB) //******pending construct data fields with Gender value....*****
		{
			global $reportlangarray, $chartformatarray, $astromethodarray,$db2,$DBNAME,$DOMAINTABLE,$MERGETABLE,$domainlangpartnerid,$domainimgspath,$varTable;

			$gender = "";
			if($memgender == "M")
			{
				$gender = "M";
			}
			else if($memgender == "F")
			{
				$gender = "F";
			}
			$memberidcookie	= $varGetCookieInfo['MATRIID'];

			//Get the details from astromatch table... if one exist...  
			$varCondition				= " WHERE MatriId= ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$varFields					= array('MatriId','Name','TimeCorrection','Country','State','Place','Longitude','Lattitude','TimeZone','Remarks');
			$memAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
			$datastro       			= mysql_fetch_array($memAstroExe);

			 //Get the details from horodetails table
			$varCondition	= " WHERE MatriId= ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$varFields	    = array('BirthDay','BirthMonth','BirthYear','BirthHour','BirthMinute','BirthSeconds','BirthMeridian','BirthCity','BirthState','BirthCountry','BirthLongitude','BirthLatitude');
			$varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
			$dathoro	    = mysql_fetch_array($varExecute);

			$Country_Id     = $dathoro['BirthCountry'];
			$varCondition	= " WHERE Country_Id='".$dathoro['BirthCountry']."'";
			$varFields	    = array('Country_Name');
			$varExecute	    = $objSlaveDB->select($varTable['HOROCOUNTRIES'], $varFields, $varCondition,0);
			$countryDet     = mysql_fetch_array($varExecute);
            $dathoro["BirthCountry"] = $countryDet["Country_Name"];

			$varCondition	= " WHERE StateId='".$dathoro['BirthState']."'";
			$varFields	    = array('StateName');
			$varExecute	    = $objSlaveDB->select($varTable['HOROINDIANSTATES'], $varFields, $varCondition,0);
			$stateDet       = mysql_fetch_array($varExecute);
            $State_Name     = $stateDet["StateName"];

			//get the name of the partner...
			$varFields					= array('Name');
			$varCondition	            = " WHERE MatriId =  ".$objSlaveDB->doEscapeString($matriid,$objSlaveDB);
			$memResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
			$datlogin           		= mysql_fetch_assoc($memResult);

			if(trim($dathoro["BirthCountry"]) != "India")
			{
				$varFields					= array('Country_Id','State_Id','State_Name');
				$varCondition	            = " WHERE State_Id='".addslashes(trim($dathoro["BirthState"]))."' and Country_Id=".$Country_Id."";
				$memResult					= $objSlaveDB->select($varTable['HORONRISTATES'], $varFields, $varCondition,0);
				$astroresultset         	= mysql_fetch_assoc($memResult);
				$State_Name                 = $astroresultset["State_Name"];

				$varFields					= array('City_Name','Longitude','Latitude','Timezone');
				$varCondition	            = " WHERE State_Id=".trim($dathoro["BirthState"])." and City_Id='".trim($dathoro["BirthCity"])."'";
				$memResult					= $objSlaveDB->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
				$datastrodist         	    = mysql_fetch_assoc($memResult);
				$dathoro["BirthCity"]       = $datastrodist['City_Name'];
			}

			//$birthhour = 0;
			if(trim($dathoro["BirthMeridian"]) != "") //converting 12 hrs system to 24 hrs by adding 12 hr to existing hr.
			{
				if(trim($dathoro["BirthMeridian"]) == "PM")
				{
					//SINCE ITS IN PM ADD 12 HRS TO THE EXISTING HR.
					$birthhour = $dathoro["BirthHour"] + 12;
					if(trim($birthhour) == 24) 
					{
						$birthhour = trim($dathoro["BirthHour"]); //since its comes to 24 use 12 itself. otherwise use the calculated time(hr +12)
					}
				}
				else
				{

					if(trim($dathoro["BirthMeridian"]) == "AM")
					{
						//SINCE ITS 12 AM it has to be changed to 0 hrs.
						if(trim($dathoro["BirthHour"]) == 12)
							$birthhour = 0; //AM and comes to 12 so make it as zero
						else
							$birthhour = trim($dathoro["BirthHour"]);
					}
					//$birthhour = trim($dathoro["BirthHour"]);	
				}
			}
			else
			{
				$birthhour = trim($dathoro["BirthHour"]);	
			}

			settype($birthhour,"integer");
			if($birthhour < 10)
			{
				$birthhour = '0'.$birthhour;
			}

			$astrotable = '<div class="fleft"><div style="float:left; width:230px !important;width:232px;height:400px !important;height:415px;" class="brdr">
		<div style="float:left; width:230px; background:url('.$confValues["IMAGEURL"].'/images/live-hlp-div-bg.gif) repeat-x; margin:1 0 1 0;"><div style="margin:0 2 2 10;"><div style="width:205px;">
		<div class="bld normtxt clr">'.$title.'</font></div>
		<div class="dottedline" style="background: url('.$confValues["IMAGEURL"]."/images/dot.gif".') repeat-x 0px 3px;"><br>

		<font class="smalltxt"><b>Matrimony ID</b></font>
		<div class="smalltxt">'.$matriid.'<input type="hidden" size=25 name="'.$gender.'_REGNO" class="addtextfiled" value="'.$matriid.'"></div>

		<div class="smalltxt " style="padding-top:10px;"><b>Name</b></div>
		<div class="smalltxt">'.$datlogin["Name"].'<input type="hidden" size=25 name="'.$gender.'_PERSON_FNAME" class="addtextfiled" value="'.eregi_replace(",","",$datlogin["Name"]).'"></div>

		<div class="smalltxt " style="padding-top:10px;"><b>Date of Birth</b></div>
		<div class="smalltxt">'.$dathoro["BirthDay"].'-'.$dathoro["BirthMonth"].'-'.$dathoro["BirthYear"].'<input type="hidden" NAME="'.$gender.'_BIRTH_DAY" value='.$dathoro["BirthDay"].'><input type="hidden" NAME="'.$gender.'_BIRTH_MONTH" value='.$dathoro["BirthMonth"].'><input type="hidden" NAME="'.$gender.'_BIRTH_YEAR" value='.$dathoro["BirthYear"].'></div>

		<div class="smalltxt " style="padding-top:10px;"><b>Time of Birth</b></div>
		<div class="smalltxt">'.$birthhour.' Hr '.$dathoro["BirthMinute"].' Min '.$dathoro["BirthSeconds"].' Sec [24 Hr]<input type="hidden" NAME="'.$gender.'_BIRTH_HOUR" value='.$dathoro["BirthHour"].'><input type="hidden" NAME="'.$gender.'_BIRTH_MIN" value='.$dathoro["BirthMinute"].'><input type="hidden" NAME="'.$gender.'_BIRTH_SEC" value='.$dathoro["BirthSeconds"].'></div>
		<!--country selection -->
					
		<div class="smalltxt " style="padding-top:10px;"><b>Country of Birth</b></div>
		<div class="smalltxt">'.$dathoro["BirthCountry"].'<input type=hidden id="'.$gender.'_Countries" NAME="'.$gender.'_Countries" value="'.$dathoro["BirthCountry"].'"></div>';
		
		$astrotable .='<!--endcountry--><!--state selection -->	
		<div class="smalltxt " style="padding-top:10px;"><b>State of Birth</b></div>
		<div class="smalltxt">'.$State_Name.'<input type="hidden" id="'.$gender.'_States" name="'.$gender.'_States" value="'.$dathoro["BirthState"].'"></div>';
		
		$astrotable .= '<input type="hidden" name="populateState" value="'.$dathoro["BirthState"].'">';
		$astrotable .='<input type="hidden" name="populateCity" value="'.$dathoro["BirthCity"].'">';

		$astrotable .='<!--endstate--><!--city selection -->';	

		$astrotable .= '<div class="smalltxt " style="padding-top:10px;"><b>City of Birth</b></div>
		<div class="smalltxt">'.$dathoro["BirthCity"].'<input type="hidden" id="'.$gender.'_Cities" name="'.$gender.'_Cities" value="'.$dathoro["BirthCity"].'"></div><!--endcity-->';

		$astrotable .='<div class="smalltxt " style="padding-top:10px;"><b>Time correction</b></div>
			<div class="smalltxt"><select style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="'.$gender.'_TIMECORRECTION" size="1"><option value="1"';
			if($datastro["TimeCorrection"] == 1)
				$astrotable .= " Selected";
			$astrotable .= '>Standard Time</option>
			<option value="2"';
			if($datastro["TimeCorrection"] == 2)
				$astrotable .= " Selected";
			$astrotable .= '>Daylight Saving</option></select></div></div>';	

			//get the longitude and latitude details from horodetails table and split it and store it here for match purpose...
			//check for country. if its India then get the long and lat value from horodistrict table. If Other Country then get from horo_states and horo_cities.
			if(trim($dathoro["BirthCountry"]) == "India")
			{
								
				//now get the longitude and latitude values from horodistrict table using the stateid and district name(city)...
				if(trim($dathoro["BirthCity"]) == "Chandigarh"){ //if chandigarh then no state check needed.

					$varFields					= array('Longitude','Latitude','Country','Timezone');
					$varCondition	            = " WHERE District = '".trim($dathoro["BirthCity"])."'";
					$memResult					= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, $varCondition,0);
					$datastrodist         		= mysql_fetch_assoc($memResult);		
				}
				else{
					
					$varFields					= array('Longitude','Latitude','Country','Timezone');
					$varCondition	            = " WHERE StateId = '".trim($dathoro["BirthState"])."'";
					$memResult					= $objSlaveDB->select($varTable['HORODISTRICT'], $varFields, $varCondition,0);
					$datastrodist         		= mysql_fetch_assoc($memResult);
				}
				
				$longarray = explode(".",$datastrodist["Longitude"]);
				$longdeg = $longarray[0]; //format 000.00E
				if(strlen($longdeg) == 1)
					$longdeg = "00".$longdeg;
				else if(strlen($longdeg) == 2)
					$longdeg = "0".$longdeg;
				
				$longmin = substr($longarray[1],0,2);
				if(strlen($longmin) == 1)
					$longmin = "0".$longmin;

				$longdir = substr($longarray[1],2,1);
				if(strlen($longdir) == 0)
					$longdir = "W"; //if no direction then W by default... (By Sashish)


				$latarray = explode(".",$datastrodist["Latitude"]);
				$latdeg = $latarray[0]; //format 00.00E
				if(strlen($latdeg) == 1)
					$latdeg = "0".$latdeg;

				$latmin = substr($latarray[1],0,2);
				if(strlen($latmin) == 1)
					$latmin = "0".$latmin;

				$latdir = substr($latarray[1],2,1);
				if(strlen($latdir) == 0)
					$latdir = "W"; //if no direction then W by default... (By Sashish)

				$timezoneval = $datastrodist["Timezone"];
			}
			else if(trim($dathoro["BirthCountry"]) == "Other Country")
			{
				//for our old other country members...
				//now get the longitude and latitude values from horodistrictothers table using the district(city) name alone
				
				$varFields					= array('Longitude','Latitude','Timezone');
				$varCondition	            = " WHERE city = '".trim($dathoro["BirthCity"])."'";
				$memResult					= $objSlaveDB->select($varTable['HOROALLCOUNTRIESCITIES'], $varFields, $varCondition,0);
				$datastrodist         		= mysql_fetch_assoc($memResult);

				$longarray = explode(".",$datastrodist["Longitude"]);
				$longdeg = $longarray[0];
				if(strlen($longdeg) == 1)
					$longdeg = "00".$longdeg;
				else if(strlen($longdeg) == 2)
					$longdeg = "0".$longdeg;

				$longmin = substr($longarray[1],0,2);
				if(strlen($longmin) == 1)
					$longmin = "0".$longmin;

				$longdir = substr($longarray[1],2,1);
				if(strlen($longdir) == 0)
					$longdir = "W"; //if no direction then W by default... (By Sashish)

				$latarray = explode(".",$datastrodist["Latitude"]);
				$latdeg = $latarray[0];
				if(strlen($latdeg) == 1)
					$latdeg = "0".$latdeg;

				$latmin = substr($latarray[1],0,2);
				if(strlen($latmin) == 1)
					$latmin = "0".$latmin;

				$latdir = substr($latarray[1],2,1);
				if(strlen($latdir) == 0)
					$latdir = "W"; //if no direction then W by default... (By Sashish)

				$timezoneval = $datastrodist["Timezone"];
			}
			else
			{
				//New Other country members ... get the state id.
				$varFields					= array('Country_Id','State_Id','State_Name');
				$varCondition	            = " WHERE State_Id='".addslashes(trim($dathoro["BirthState"]))."' and Country_Id=".$Country_Id."";
				$memResult					= $objSlaveDB->select($varTable['HORONRISTATES'], $varFields, $varCondition,0);
				$datastrostateid         	= mysql_fetch_assoc($memResult);
                        
				$varFields					= array('City_Name','Longitude','Latitude','Timezone');
				$varCondition	            = " WHERE State_Id=".trim($dathoro["BirthState"])." and City_Name='".trim($dathoro["BirthCity"])."'";
				$memResult					= $objSlaveDB->select($varTable['HOROCITIES'], $varFields, $varCondition,0);
				$datastrodist            	= mysql_fetch_assoc($memResult);
			

				$longarray = explode(".",$datastrodist["Longitude"]);
				$longdeg = $longarray[0];
				if(strlen($longdeg) == 1)
					$longdeg = "00".$longdeg;
				else if(strlen($longdeg) == 2)
					$longdeg = "0".$longdeg;

				$longmin = substr($longarray[1],0,2);
				if(strlen($longmin) == 1)
					$longmin = "0".$longmin;

				$longdir = substr($longarray[1],2,1);
				if(strlen($longdir) == 0)
					$longdir = "W"; //if no direction then W by default... (By Sashish)

				$latarray = explode(".",$datastrodist["Latitude"]);
				$latdeg = $latarray[0];
				if(strlen($latdeg) == 1)
					$latdeg = "0".$latdeg;

				$latmin = substr($latarray[1],0,2);
				if(strlen($latmin) == 1)
					$latmin = "0".$latmin;

				$latdir = substr($latarray[1],2,1);
				if(strlen($latdir) == 0)
					$latdir = "W"; //if no direction then W by default... (By Sashish)

				$timezoneval = $datastrodist["Timezone"];
			}

			$astrotable .= '<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LONGITUDE_HOUR" readonly value = "'.$longdeg.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LONGITUDE_MIN" readonly value = "'.$longmin.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_MIN">&nbsp;<input type="hidden" name="'.$gender.'_PLACE_LONGITUDE_DIR" readonly value = "'.$longdir.'" size=3 class="addtextfiled" id="'.$gender.'_PLACE_LONGITUDE_DIR"><INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LATITUDE_HOUR" readonly value = "'.$latdeg.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_HOUR">&nbsp;<INPUT TYPE="hidden" NAME="'.$gender.'_PLACE_LATITUDE_MIN" readonly value = "'.$latmin.'" size=7 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_MIN">&nbsp;<input type="hidden" name="'.$gender.'_PLACE_LATITUDE_DIR" readonly value = "'.$latdir.'" size=3 class="addtextfiled" id="'.$gender.'_PLACE_LATITUDE_DIR"><INPUT TYPE="hidden" NAME="'.$gender.'_TIMEZONE" readonly value = "'.$timezoneval.'" size=25 class="addtextfiled" id="'.$gender.'_TIMEZONE">';

			$astrotable .= '<input type="hidden" name="'.$gender.'_BIRTH_PLACE_NAME" value="'.$dathoro["BirthCity"].'" id="'.$gender.'_BIRTH_PLACE_NAME"> <!-- used to set the place of birth -->
			
			<input type="hidden" name="findlogingendNew" id="findlogingendNew" value="'.$gender.'"> <!-- used to find the login mem gender for inserting into db astromatch --> <input type="hidden" name="partnervalue" id="partnervalue" value="1">';

			if(trim($dathoro["BirthMeridian"]) != "")
				$astrotable .= '<input type="hidden" name="'.$gender.'_BirthMedian" value="'.$dathoro["BirthMeridian"].'">';
			else
				$astrotable .= '<input type="hidden" name="'.$gender.'_BirthMedian" value="">';

			$astrotable .= '</div></div></div></div></div>';

			return $astrotable;
		}
		function getCountries($objSlaveDB) 
		{
			global $reportlangarray, $chartformatarray, $astromethodarray,$db2,$DBNAME,$DOMAINTABLE,$domainlangpartnerid,$domainimgspath,$varTable;

			$varFields					= array('Country_Id','Country_Name');
			$varCondition	            = " order by Country_Name";
			$countryResult				= $objSlaveDB->select($varTable['HOROCOUNTRIES'], $varFields, $varCondition,1);
			

			if(!empty($countryResult)) 
			{
				foreach($countryResult as $key=>$row)
				{
					if(trim($row['Country_Name']) == trim($varCountry))
					{
						$varStateOption .= "<option value=\"".$row['Country_Id']."\" selected>".$row['Country_Name']."</option>";
						$thisCountryId = trim($row['Country_Id']);
					}
					else
					{
						$varStateOption .= "<option value=\"".$row['Country_Id']."\">".$row['Country_Name']."</option>";
					}
				}
				return $varStateOption;
			}
		    else
				return '';
	}//getCountries

function checkAstroData()
{
	global $_REQUEST, $astroerrmsg,$domainimgspath;
	foreach($_POST as $ind=>$val)
	{
		if((trim($val) == "") && (trim($ind) != "hidecityval") && (trim($ind) != "populateState") && (trim($ind) != "populateCity") && (trim($ind) != "populateCityNew"))
		{
			if(($ind == "M_BIRTH_PLACE_NAME") && (trim($_POST["M_Cities"]) !=""))
				continue;
			else if(($ind == "F_BIRTH_PLACE_NAME") && (trim($_POST["F_Cities"]) !=""))
				continue;
			else if((trim($_POST["M_Countries"])=="Other Country") && (trim($_POST["M_States"])==""))
				continue;
			else if((trim($_POST["F_Countries"])=="Other Country") && (trim($_POST["F_States"])==""))
				continue;
			echo "<br><br><font class='textsmallnormal'>".$astroerrmsg[$ind]."<br><center><a href=\"javascript:history.back();\">Back</a></center></font>";
			return false;
		}
	}
	return true;
}
?>