<?php
#================================================================================================================
# Author 		: S Anand, N Dhanapal, M Senthilnathan & S Rohini
# Start Date	: 2006-06-19
# End Date		: 2006-06-21
# Project		: MatrimonyProduct
# Module		: Search
#================================================================================================================
class QuickSearch
{
	//[Class Public] MEMBER DECLARATION
	public $clsTable				= "memberinfo";
	public $clsSelectedField		= "MatriId";
	public $clsPrimary				= array();
	public $clsPrimaryValue			= array();
	public $clsPrimaryKey			= array(); 			//add, or
	public $clsPrimarySymbol		= array(); 			// =, <=, >=, <
	public $clsPrimaryValueIsArr	= array(); 			//IN or (=, <=, >=, <)
	public $clsFields				= array('*');
	public $clsFieldsToDisplay		= array();
	public $clsFieldsValues			= array();
	public $clsOrderBy				= array();
	public $clsOrder				= array('DESC'); 	//asc, desc
	public $clsGroup				= array();
	public $clsDisplayTitle			= "yes"; 			//"yes" or "no"
	public $clsStart				= 0;
	public $clsLimit				= 20;
	public $clsRowColor				= "no"; 			//"yes" or "no"
	public $clsListTemplate			= ""; 				//to read 'templates/list.tpl' template file
	public $clsViewTemplate			= ""; 				//to read 'templates/view' template file
	public $clsPlaceHolders			= array();
	public $clsPlaceHoldersValues	= array();

	//[Class Private] MEMBER DECLARATION
	public $clsTextConversion		= array();
	public $clsServerURL			= "";
	public $clsImagePath			= 'http://img.muslimmatrimonial.com/membersphoto';
	public $clsRequestPhotoImage	= "requestphoto75x75.gif";			// request photo image
	public $clsNoPhotoImage			= 'nophotofoundimg.gif';
	public $clsProtectedPhotoImage	= "protectedphotoimg-75x75.gif";	// protected photo image
	public $clsFolderName			= "";							// photo folder
	public $clsPhoneImage			= "phone-verified-icon-new.gif";	// phone icon simbol
	public $clsHoroscopeImage		= "horo-gen-icon.gif";				// phone icon simbol
	public $clsDisplayFormat		= "B";								// display format
	public $clsAllowNumOfRows		= "3";								// saved search
	public $clsNoOfImages			= 3;								//Totoal No of Photos
	public $clsProtectedStatus		= "no";								//Protected Status
	public $clsIgnoredProfiles		= "no";								//To ignore Ignored Profiles
	public $clsCurrentSession		= "";								//Member's Current Session Id
	public $clsFavoritesIcon		= "../../images/bookmark-icon-new.gif";
	public $clsIgnoreIcon			= "../../images/ignored-icon-new.gif";
	public $clsBlockIcon			= "../../images/profileblock-icon-new.gif";
	public $clsPaidStatus			= 0;
	public $clsArrowImage			= "view-options-arrow.gif";
	public $clsSessionMatriId		= "";
	public $clsSessionGender		= "";
	public $clsCountField			= ""; //for getting number of results
	public $clsAllowedLimit			= "yes";
	public $clsValidatedPhotos		= 0;
	static $clsSpanId				= 0;
	public $clsArrPhotoResultSet	= array();
	public $clsArrListResultSet		= array();

	//FOR Messages
	public $clsCheckBoxName			= 'interestSent';
	public $clsInterestActivity1	= 'Send a Reminder';	// Send a Reminder Words
	public $clsInterestActivity2	= 'Delete';	// send a Reminder Words
	public $clsInterestActivity3	= '';	
	public $clsDisplayMsgFlag		= '';
	public $clsLinkSymbol			= 'no';
	public $clsMailAction			= 'inbox';	// send a Reminder Words
	public $clsFormName				= 'frmMessageReceived';	// form name
	public $clsPrimaryGroupStart	= 0.1;
	public $clsPrimaryGroupEnd		= 0.1;
	public $clsDeleteFlag			= 0;
	public $clsMemberYouContacted	= 'MatriId';
	public $clsDeclinedMessage		= 'My Declined Message';
	public $clsPendingMsg			= 'Sent on: ';
	public $clsAcceptMsg			= 'Accepted on: ';
	public $clsDisplayMessage		= '';
	public $clsNoOfPhotoRecords		= '';
	public $clsPhotoProtected		= '';
	public $clsFilename				= '';

	#------------------------------------------------------------------------------------------------------------
	//INSERT NEW RECORDS
	function addQuickSearch()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 		= "";
		$funDisplay 	= "";
		$funNoOfFields	= count($this->clsFields);
		$funQuery .= "INSERT INTO ".$this->clsTable." SET ";
		for($i=0;$i<$funNoOfFields;$i++)
		{
			if($i<($funNoOfFields-1))
			{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."', "; }//if
			else{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."' "; }//else
		}//for
		mysql_query($funQuery) or die(mysql_error());
		$retDisplay = "yes";

		return $retDisplay;
	}//addQuickSearch
	#------------------------------------------------------------------------------------------------------------
	
	//UPDATE VALUES FOR THE SELECTED RECORD
	function updateQuickSearch()
	{
		global $mod,$act,$errMessages;

		$funQuery 		= "";
		$funDisplay 	= "";
		$funNumOfFields	= count($this->clsFields);
		$funPrimary		= count($this->clsPrimary);
		$funQuery .= "UPDATE ".$this->clsTable." SET ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1))
			{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."', "; }//if
			else{ $funQuery .= $this->clsFields[$i]." = '".str_replace("'","''",stripslashes($this->clsFieldsValues[$i]))."' "; }//else

		}//for
		$funQuery 	.= "WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue; }//else
		}//for
		//print "<br><br>".$funQuery;
		mysql_query($funQuery) or die(mysql_error());
		$retDisplay = mysql_affected_rows();

		return $retDisplay;
	}//updateQuickSearch
	#----------------------------------------------------------------------------------------------------------
	function updateMyMessageCount()
	{
		global $mod,$act;
		
		$funQuery 		= "";
		$funDisplay 	= "";
		$funNumOfFields = count($this->clsFields);
			
		$funQuery .= "UPDATE ".$this->clsTable." SET ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<$funNumOfFields-1)
			{ $funQuery .= $this->clsFields[$i]." = ".$this->clsFieldsValues[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." = ".$this->clsFieldsValues[$i]; }//else

		}//for
		$funQuery 	.= " WHERE MatriId = '".$this->clsPrimaryValue[0]."'";
		//print "<br><br>".$funQuery;
		mysql_query($funQuery) or die(mysql_error());
		
	}//updateMyMessageCount
	#----------------------------------------------------------------------------------------------------------
	
	//DELETE THE SELECTED RECORD
	function deleteQuickSearch()
	{
		global $mod,$act,$errMessages;

		$funQuery 		= "";
		$funDisplay 	= "";
		$funPrimary		= count($this->clsPrimary);
		$funQuery.="DELETE FROM ".$this->clsTable." WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue; }//else
		}//for
		//print "<br><br>".$funQuery;
		mysql_query($funQuery) or die(mysql_error());
		$funDisplay = 'yes';

		return $funDisplay;		
	}//deleteQuickSearch
	#------------------------------------------------------------------------------------------------------------
	//DISPLAY RESULTS
	function displayThumbnailQuickResults($funQuery)
	{
			global $mod,$act,$errMessages;
		//print "<br>$funQuery<br><br>";
		$funNumOfPlaceHolders	= count($this->clsPlaceHolders);
		$resQuery				= mysql_query($funQuery);
		$funNumOfRows			= mysql_num_rows($resQuery);
		$funArrResultSet		= array();
		$funArrListMatriIds		= '';
		$funArrPhotoMatriIds	= '';
		
		if($funNumOfRows > 0)
		{
			$funFlag=0;
			$j=0;
			while($row = mysql_fetch_object($resQuery))
			{
				$funArrResultSet[$j]['MatriId']				= $row->MatriId;
				$funArrResultSet[$j]['Age']					= $row->Age;
				$funArrResultSet[$j]['Religion']			= $row->Religion;
				$funArrResultSet[$j]['Last_Login']			= $row->Last_Login;
				$funArrResultSet[$j]['Height']				= $row->Height.'~'.$row->Height_Unit;
				$funArrResultSet[$j]['Subcaste']			= $row->Subcaste;
				$funArrResultSet[$j]['Caste_Or_Division']	= $row->Caste_Or_Division;
				$funArrResultSet[$j]['Occupation']			= $row->Occupation.'~'.$row->Occupation_Detail;
				$funArrResultSet[$j]['Username']			= $row->Username;
				$funArrResultSet[$j]['About_Myself']		= $row->About_Myself;
				$funArrResultSet[$j]['Residing_City']		= $row->Country.'~'.$row->Residing_State;
				$funArrResultSet[$j]['Education_Category']	= $row->Education_Category.'~'.$row->Education_Detail;

				//PHOTO STATUS 
				$funPhotoStatus	= ($row->Photo_Set_Status == 1)?(($row->Protect_Photo_Set_Status==1)?2:1):0;
				$funArrResultSet[$j]['Photo']				= $funPhotoStatus;
				if($funPhotoStatus == 1)
				{
					$funArrPhotoMatriIds	.= "'".$row->MatriId."', ";
				}//if

				$funArrListMatriIds	.= "'".$row->MatriId."', ";
				$j++;
			}//while
			
			$funArrPhotoMatriIds		= chop($funArrPhotoMatriIds,", ");
			$funArrListMatriIds			= chop($funArrListMatriIds,", ");

			//SELECT PHOTO
			if ($funArrPhotoMatriIds !="")
			{
				$funPhotoQuery			= 'SELECT MatriId, Normal_Photo1,Photo_Status1,Thumb_Small_Photo1, Normal_Photo2,Photo_Status2,Thumb_Small_Photo2,Normal_Photo3,Photo_Status3,Thumb_Small_Photo3 FROM memberphotoinfo WHERE MatriId IN('.$funArrPhotoMatriIds.')';
				//print "<br><br>".$funPhotoQuery;
				$funExecute	= mysql_query($funPhotoQuery);
				$jj=0;
				while ($funPhotoResultset	= mysql_fetch_assoc($funExecute))
				{
					$this->clsArrPhotoResultSet[$jj]["MatriId"]			= $funPhotoResultset["MatriId"];
					$this->clsArrPhotoResultSet[$jj]["Normal_Photo1"]	= $funPhotoResultset["Normal_Photo1"];
					$this->clsArrPhotoResultSet[$jj]["Photo_Status1"]	= $funPhotoResultset["Photo_Status1"];
					$this->clsArrPhotoResultSet[$jj]["Thumb_Small_Photo1"]	= $funPhotoResultset["Thumb_Small_Photo1"];
					$this->clsArrPhotoResultSet[$jj]["Normal_Photo2"]	= $funPhotoResultset["Normal_Photo2"];
					$this->clsArrPhotoResultSet[$jj]["Photo_Status2"]	= $funPhotoResultset["Photo_Status2"];
					$this->clsArrPhotoResultSet[$jj]["Thumb_Small_Photo2"]	= $funPhotoResultset["Thumb_Small_Photo2"];
					$this->clsArrPhotoResultSet[$jj]["Normal_Photo3"]	= $funPhotoResultset["Normal_Photo3"];
					$this->clsArrPhotoResultSet[$jj]["Photo_Status3"]	= $funPhotoResultset["Photo_Status3"];
					$this->clsArrPhotoResultSet[$jj]["Thumb_Small_Photo3"]	= $funPhotoResultset["Thumb_Small_Photo3"];
					$jj++;
				}
			}//if

			//SELECT PHOTO
			if ($funArrListMatriIds !="" && $this->clsSessionMatriId !="")
			{
				$funListQuery			= "SELECT Opposite_MatriId,Bookmarked,Ignored,Blocked FROM memberactioninfo WHERE MatriId='".$this->clsSessionMatriId."'  AND Opposite_MatriId IN(".$funArrListMatriIds.")";
				//print "<br><br>".$funListQuery;//exit;
				$funExecute	= mysql_query($funListQuery);
				$jj=0;
				while ($funListResultSet	= mysql_fetch_assoc($funExecute))
				{
					$this->clsArrListResultSet[$jj]["Bookmarked"]		= $funListResultSet["Bookmarked"];
					$this->clsArrListResultSet[$jj]["Ignored"]			= $funListResultSet["Ignored"];
					$this->clsArrListResultSet[$jj]["Blocked"]			= $funListResultSet["Blocked"];
					$this->clsArrListResultSet[$jj]["Opposite_MatriId"]	= $funListResultSet["Opposite_MatriId"];
					$jj++;
				}
				
			}//if

			//SELECT CONTACT SUMMARY
			$this->clsArrContactResultSet = array();
			if ($funArrListMatriIds !="" && $this->clsSessionMatriId !="")
			{
				$funContactQuery	= "SELECT Opposite_MatriId FROM memberactioninfo  WHERE MatriId = '".$this->clsSessionMatriId."' AND Opposite_MatriId IN (".$funArrListMatriIds .') AND (Mail_Sent=1 OR Mail_Received=1 OR Interest_Sent=1 OR Interest_Received=1)';

				//print "<br><br>".$funContactQuery;
				$funExecute	= mysql_query($funContactQuery);
				
				while ($funContactResultSet	= mysql_fetch_assoc($funExecute))
				{
					$varContactMatriId = "'".$funContactResultSet["Opposite_MatriId"]."'";
					$this->clsArrContactResultSet[$varContactMatriId] = 1;
				}
			}//if

			$varArrMatriIds	= explode(',',$funArrListMatriIds);
			
			for($k=0; $k<$j; $k++)
			{
				$funTemplateXerox = $this->clsListTemplate;
				if($this->clsDisplayFormat=='P') {
				$varHeightfeetInchs = $this->getHeightUnit($funArrResultSet[$k][$this->clsPlaceHoldersValues[5]]);
				$varHeightfeets = explode(' ',$varHeightfeetInchs);
				$varHeightFeetRep = str_replace('ft',"'",$varHeightfeets[0]);
				$varHeightinchRep = $varHeightfeets[1]!='/'?str_replace('in','"',$varHeightfeets[1]):'';
				$varHeightfeet = ','.$varHeightFeetRep.$varHeightinchRep;
				} 
				
				for($i=0;$i<$funNumOfPlaceHolders;$i++)
				{
					if(in_array($this->clsPlaceHoldersValues[$i], $this->clsTextConversion))
					{
						$funPlaceHolderValue = $this->clsPlaceHoldersValues[$i];
						$funValue = $this->getActualValueFromArray($this->clsPlaceHolders[$i], $funArrResultSet[$k][$funPlaceHolderValue]); 
					}//if
					else{ $funValue = $funArrResultSet[$k][$funPlaceHolderValue]; }//else
					
					$funTemplateXerox = str_replace($this->clsPlaceHolders[$i], $funValue, $funTemplateXerox);
					if($this->clsDisplayFormat=='P') {
					$funTemplateXerox = str_replace('<--HEIGHT-FEET-->', $varHeightfeet, $funTemplateXerox);
					}
				}//for

				$varContactedCnt	= $this->clsArrContactResultSet[$varArrMatriIds[$k]];
				if($varContactedCnt==1 && $this->clsSessionMatriId !="")
				{
					$varContactSummary = "<div style='background:#F1F7E4;width:100%;padding:5px 0px 10px 0px;text-align:right;height:10px;'><a href=\"javascript:funProfileHistory(".$varArrMatriIds[$k].");\" class=\"grsearchtxt\">Contact Summary</a>&nbsp;&nbsp;</div>";
				}
				else
					$varContactSummary = "";
				$funTemplateXerox = str_replace('<--CONTACT-SUMMARY-->', $varContactSummary, $funTemplateXerox);

				if ($this->clsDisplayFormat=='T')
				{
					if ($funFlag%2==0) { echo "<tr><td width='49%' colspan='2'>".$funTemplateXerox."</td>";
					}//if
					else
					{
						echo "<td width='48%' colspan='2'>".$funTemplateXerox."</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
					}//if
				}
				
				if ($this->clsDisplayFormat=='P')
				{
					if ($funFlag%4==0) { echo "<tr><td colspan='4' height='10'></td></tr><tr><td width='24%'>".$funTemplateXerox."</td>";
					}//if
					else
					{
						echo "<td width='24%'>".$funTemplateXerox."</td>";
					}//if
				}

				if ($this->clsDisplayFormat=='B')
				{ echo "<tr><td>".$funTemplateXerox."</td></tr><tr><td>&nbsp;</td></tr>"; }//if
				$funFlag++;
			}//for
		}//if
		else
		{
			$funDisplay	.= '<tr><td height="10"></td></tr>';
			$funDisplay .= '<tr><td align="center" class="errorMsg">Sorry No Results Found.</td></tr>';
			$funDisplay	.= '<tr><td height="20"></td></tr>';
			echo $funDisplay;
		}//else
		//echo '<br><br>';
	}//displayThumbnailQuickResults
	#----------------------------------------------------------------------------------------------------------
	//GET DATE FORMAT [DATE-MONTH-YEAR]
	function getDateMothYear($argFormat,$argDateTime,$argOppositeId='')
	{
		if (trim($argDateTime) =="0000-00-00 00:00:00" || trim($argDateTime) == "")
			$retDateValue="";
		else
		{ $retDateValue = date($argFormat,strtotime($argDateTime)); }//if
		if($argOppositeId != '')
		{
			$funGetMyListInfo	= $this->checkMyListProfiles($argOppositeId);
			$retDateValue	   .= '&nbsp;&nbsp;'.$funGetMyListInfo;
		}//if
		return $retDateValue;
	}	
	#----------------------------------------------------------------------------------------------------------
	//GET DATE FORMAT [DATE-MONTH-YEAR]
	function getDateMonthYear($argFormat,$argDateTime)
	{
		if (trim($argDateTime) =="0000-00-00 00:00:00" || trim($argDateTime) == "")
			$retDateValue="";
		else
		{ $retDateValue = date($argFormat,strtotime($argDateTime)); }//if
		return $retDateValue;
	}	
	#----------------------------------------------------------------------------------------------------------

	//MEMBER Contact DETAILS
	function getContactDetCnt($argOppositeMatriId)
	{
		$funQuery	= "SELECT Count(MatriId) as Cnt FROM memberactioninfo  WHERE MatriId = '".$this->clsSessionMatriId."' AND Opposite_MatriId = ".$argOppositeMatriId ." AND (Mail_Sent=1 OR Mail_Received=1 OR Interest_Sent=1 OR Interest_Received=1)";
		//print"<br><br>".$funQuery;
		$resQuery	= mysql_query($funQuery);
		$retDisplay	= mysql_fetch_array($resQuery);
		return $retDisplay['Cnt'];
		
	}//getContactIdInfo
	#----------------------------------------------------------------------------------------------------------
	//DISPLAY PHOTOS (*ND 20070306)
function getPhoto($argPhotoStatus,$argOppositeId)
	{
		$funPhotoStatus		= $argPhotoStatus;
		$funOppositeId		= $argOppositeId;
		$funPhotoPath		= '';
		$funPhotoPaging		= '';
		$funGetMyListInfo	= '';
		$funPhotoIndexValue = '';
		
		if($this->clsDisplayFormat=='P')
		{
			$jj = 0;
			foreach($this->clsArrPhotoResultSet as $funSingleId)
			{
				$funPhotoIndexValue = array_search($funOppositeId, $funSingleId);
				if($funPhotoIndexValue != '')
					break;
				$jj++;
			}
			$funPhotoURL	= $this->clsImagePath.'/'.$funOppositeId{1}.'/'.$funOppositeId{2}.'/';
			$retPhoto		= $funPhotoURL.$this->clsArrPhotoResultSet[$jj]['Normal_Photo1'];
		}
		else {

		if ($funPhotoStatus==2)
		{
			$funPhotoPath	.= '<a href="javascript: funProtectedPhoto(\''.$argOppositeId.'\');" GALLERYIMG="no" oncontextmenu="return false">';
			$funPhotoPath	.= '<img src='.$this->clsImagePath;
			$funPhotoPath	.= '/'.$this->clsProtectedPhotoImage.' border="0" width="75" height="75" vspace="2" hspace="2"></a>'; // Display Protectd Photo.
		}//if
		else if ($funPhotoStatus==1)
		{
			$jj = 0;
			foreach($this->clsArrPhotoResultSet as $funSingleId)
			{
				$funPhotoIndexValue = array_search($funOppositeId, $funSingleId);
				if($funPhotoIndexValue != '')
					break;
				$jj++;
			}
			
			$funArrPhotoName[0][0]	= $this->clsArrPhotoResultSet[$jj]['Normal_Photo1'];
			$funArrPhotoName[0][1]	= $this->clsArrPhotoResultSet[$jj]['Normal_Photo2'];
			$funArrPhotoName[0][2]	= $this->clsArrPhotoResultSet[$jj]['Normal_Photo3'];
			$funArrPhotoName[1][0]	= $this->clsArrPhotoResultSet[$jj]['Photo_Status1'];
			$funArrPhotoName[1][1]	= $this->clsArrPhotoResultSet[$jj]['Photo_Status2'];
			$funArrPhotoName[1][2]	= $this->clsArrPhotoResultSet[$jj]['Photo_Status3'];
			$funArrPhotoName[2][0]	= $this->clsArrPhotoResultSet[$jj]['Thumb_Small_Photo1'];
			$funArrPhotoName[2][1]	= $this->clsArrPhotoResultSet[$jj]['Thumb_Small_Photo2'];
			$funArrPhotoName[2][2]	= $this->clsArrPhotoResultSet[$jj]['Thumb_Small_Photo3'];
			
			$funPhotoURL	= '/'.$funOppositeId{1}.'/'.$funOppositeId{2}.'/';
			$this->clsSpanId++;
			$this->clsValidatedPhotos	= 0;
			
			for ($i=0;$i<3;$i++)
			{
				$funPhotoName		= $funArrPhotoName[0][$i];
				$funPhotoStatus		= $funArrPhotoName[1][$i];
				$funPhotoThumbSmall	= $funArrPhotoName[2][$i];
				if ($funPhotoStatus==1 || $funPhotoStatus==2)
				{
					$funPhotoFlag		= 0;
					if(!file_exists($this->clsImagePath.$funPhotoURL.$funPhotoName))
					{
						$funPhotoFlag		= 1;
					}
					//DISPLAY DEFAULT PHOTO
					if ($this->clsValidatedPhotos==0)
					{
						$funPhotoPath	= '<div    onmouseover="javascript:funFullPhotoDisplay('.$this->clsSpanId.');" onmouseout="javascript:funFullPhotoHide('.$this->clsSpanId.');">';
						//$funPhotoPath	.= '<a href="index.php?act=profile-view&matrimonyId='.$funOppositeId.'" target="_blank" GALLERYIMG="no" oncontextmenu="return false">';
						$funPhotoPath	.= '<a href="javascript: funViewPhoto(\''.$funOppositeId.'\');" GALLERYIMG="no" oncontextmenu="return false">';
						$funPhotoPath	.= '<img src='.$this->clsImagePath;
						$funPhotoPath	.= $funPhotoURL.$funPhotoName.' border="0" width="75" height="75" vspace="2" hspace="2" id="id'.$this->clsSpanId.'">';
						$funPhotoPath	.= '</a></div>';
						//MouseOver Image
						$funPhotoPath	.= '<div id="enlargephotodivid'.$this->clsSpanId.'" style="display:none;position:absolute;margin:-65px 0px 0px 80px;border:1px solid #C8BC85;width:154px;height:154px;background-color:#ffffff;padding:0px !important;padding:2px"><img src="'.$this->clsImagePath.$funPhotoURL.$funPhotoThumbSmall.'" height="150" width="150"  border="0" style="padding:2px"></div>';
					}//if
					
					//DISPLAY PHOTO PAGING
					$funPhotoPaging	.= '<a href="javascript: ';
					$funPhotoPaging	.= "funShowPhoto('".$this->clsSpanId."','".$funPhotoURL.$funPhotoName."','".$funPhotoFlag."');\" class='smallttxtnormal'>";
					$funPhotoPaging	.= '<font color="#94663e"><u>'.++$this->clsValidatedPhotos.'</u></font></a> ';
				}//if
			}//for
		}//else if
		else
		{
			if($this->clsSessionMatriId=="")
			{
				$funPhotoPath	.= '<a href="../profiles/'.$funOppositeId.'/request-photo/">';
			}//if
			else
			{
				$funPhotoPath		.= '<a href="javascript: ';
				$funPhotoPath		.= "showrequest('".$funOppositeId."');\">";

				//$funGetMyListInfo	= $this->checkMyListProfiles($funOppositeId);
			}
			$funPhotoPath	.= '<img src='.$this->clsImagePath.'/'.$this->clsRequestPhotoImage.' border="0">';
			$funPhotoPath	.= '<b>'.$funPhotoOrder.'</b></a> ';
		}//else

		//RETURN PHOTO AND PHOTO PAGING
		$retPhoto	.= '<div style="border:1px solid #C8BC85;">'.$funPhotoPath.'</div>';

		if ($this->clsValidatedPhotos > 1){
			$retPhoto	.= '<div style="padding-left:22px;padding-right:1px;">';
			$retPhoto	.= $funPhotoPaging;
			$retPhoto	.= '</div>';
		}//if
		}//else
		//$retPhoto		.= $funGetMyListInfo;
		//echo $funPhotoPath;
		return $retPhoto;
	}//getPhoto


	/*function getPhoto($argPhotoStatus,$argOppositeId)
	{
		$funPhotoStatus		= $argPhotoStatus;
		$funOppositeId		= $argOppositeId;
		$funPhotoPath		= '';
		$funPhotoPaging		= '';
		$funGetMyListInfo	= '';
		$funPhotoIndexValue = '';
		if($this->clsDisplayFormat=='P')
		{
			$jj = 0;
			foreach($this->clsArrPhotoResultSet as $funSingleId)
			{
				$funPhotoIndexValue = array_search($funOppositeId, $funSingleId);
				if($funPhotoIndexValue != '')
					break;
				$jj++;
			}
			$funPhotoURL	= $this->clsImagePath.'/'.$funOppositeId{1}.'/'.$funOppositeId{2}.'/';
			$retPhoto		= $funPhotoURL.$this->clsArrPhotoResultSet[$jj]['Normal_Photo1'];
		}
		else {

		if ($funPhotoStatus==2)
		{
			//$funPhotoPath	.= '<a href="index.php?act=profile-view&matrimonyId='.$argOppositeId.'" target="_blank" GALLERYIMG="no" oncontextmenu="return false">';
			$funPhotoPath	.= '<a href="javascript: funProtectedPhoto(\''.$argOppositeId.'\');" GALLERYIMG="no" oncontextmenu="return false" target="_blank">';
			$funPhotoPath	.= '<img src='.$this->clsImagePath;
			$funPhotoPath	.= '/'.$this->clsProtectedPhotoImage.' border="0" width="75" height="75" vspace="2" hspace="2"></a>'; // Display Protectd Photo.
		}//if
		else if ($funPhotoStatus==1)
		{
			$jj = 0;
			foreach($this->clsArrPhotoResultSet as $funSingleId)
			{
				$funPhotoIndexValue = array_search($funOppositeId, $funSingleId);
				if($funPhotoIndexValue != '')
					break;
				$jj++;
			}
					
			$funArrPhotoName[0][0]	= $this->clsArrPhotoResultSet[$jj]['Normal_Photo1'];
			$funArrPhotoName[0][1]	= $this->clsArrPhotoResultSet[$jj]['Normal_Photo2'];
			$funArrPhotoName[0][2]	= $this->clsArrPhotoResultSet[$jj]['Normal_Photo3'];
			$funArrPhotoName[1][0]	= $this->clsArrPhotoResultSet[$jj]['Photo_Status1'];
			$funArrPhotoName[1][1]	= $this->clsArrPhotoResultSet[$jj]['Photo_Status2'];
			$funArrPhotoName[1][2]	= $this->clsArrPhotoResultSet[$jj]['Photo_Status3'];
			$funArrPhotoName[2][0]	= $this->clsArrPhotoResultSet[$jj]['Thumb_Small_Photo1'];
			$funArrPhotoName[2][1]	= $this->clsArrPhotoResultSet[$jj]['Thumb_Small_Photo2'];
			$funArrPhotoName[2][2]	= $this->clsArrPhotoResultSet[$jj]['Thumb_Small_Photo3'];
			
			$funPhotoURL	= '/'.$funOppositeId{1}.'/'.$funOppositeId{2}.'/';
			$this->clsSpanId++;
			$this->clsValidatedPhotos	= 0;
			for ($i=0;$i<3;$i++)
			{
				$funPhotoName		= $funArrPhotoName[0][$i];
				$funPhotoStatus		= $funArrPhotoName[1][$i];
				$funPhotoThumbSmall	= $funArrPhotoName[2][$i];
				if ($funPhotoStatus==1 || $funPhotoStatus==2)
				{
					$funPhotoFlag		= 0;
					//$this->clsImagePath	= '../membersphoto';
					if(!file_exists($this->clsImagePath.$funPhotoURL.$funPhotoName))
					{
						$funPhotoFlag		= 1;
						//$this->clsImagePath	= $this->clsServerPath;
					}

					//DISPLAY DEFAULT PHOTO
					if ($this->clsValidatedPhotos==0)
					{
						$funPhotoPath	= '<div    onmouseover="javascript:funFullPhotoDisplay('.$this->clsSpanId.');" onmouseout="javascript:funFullPhotoHide('.$this->clsSpanId.');">';
						//$funPhotoPath	.= '<a href="index.php?act=profile-view&matrimonyId='.$funOppositeId.'" target="_blank" GALLERYIMG="no" oncontextmenu="return false">';
						$funPhotoPath	.= '<a href="javascript: funViewPhoto(\''.$funOppositeId.'\');" GALLERYIMG="no" oncontextmenu="return false">';
						$funPhotoPath	.= '<img src='.$this->clsImagePath;
						$funPhotoPath	.= $funPhotoURL.$funPhotoName.' border="0" width="75" height="75" vspace="2" hspace="2" id="id'.$this->clsSpanId.'">';
						$funPhotoPath	.= '</a></div>';
						//MouseOver Image
						$funPhotoPath	.= '<div id="enlargephotodivid'.$this->clsSpanId.'" style="display:none;position:absolute;margin:-65px 0px 0px 80px;border:1px solid #C8BC85;width:154px;height:154px;background-color:#ffffff;padding:0px !important;padding:2px"><img src="'.$this->clsImagePath.$funPhotoURL.$funPhotoThumbSmall.'" height="150" width="150"  border="0" style="padding:2px"></div>';
					}//if
					
					//DISPLAY PHOTO PAGING
					$funPhotoPaging	.= '<a href="javascript: ';
					$funPhotoPaging	.= "funShowPhoto('".$this->clsSpanId."','".$funPhotoURL.$funPhotoName."','".$funPhotoFlag."');\"  class=\"smallttxtnormal\">";
					$funPhotoPaging	.= '<font color="#94663E"><u>'.++$this->clsValidatedPhotos.'</u></font></a> ';
				}//if
			}//for
		}//else if
		else
		{
			if($this->clsSessionMatriId=="")
			{
				$funPhotoPath	.='<a href="../profiles/'.$funOppositeId.'/request-photo/" target="_blank">';
			}//if
			else
			{
				$funPhotoPath		.= '<a href="javascript: ';
				$funPhotoPath		.= "showrequest('".$funOppositeId."');\">";
			}
			$funPhotoPath	.= '<img src='.$this->clsImagePath.'/'.$this->clsRequestPhotoImage.' border="0">';
			$funPhotoPath	.= '<b>'.$funPhotoOrder.'</b></a> ';
		}//else

		//RETURN PHOTO AND PHOTO PAGING
		$retPhoto	.= '<div style="border:1px solid #C8BC85;">'.$funPhotoPath.'</div>';

		if ($this->clsValidatedPhotos > 1){
			$retPhoto	.= '<div style="padding-left:22px;padding-right:1px;">';
			$retPhoto	.= $funPhotoPaging;
			$retPhoto	.= '</div>';
		}//if
		//$retPhoto		.= $funGetMyListInfo;
		}
		return $retPhoto;
	}//getPhoto*/
	#----------------------------------------------------------------------------------------------------------
	//GET HEIGHT FORMAT
	function getHeightUnit($argHeight)
	{
		global $varArrHeightFeetList;
		$retHeightCmsFeet='';
		$funHeightandUnit	= $argHeight;
		$funSplitValue		= explode("~",$funHeightandUnit);
		$funHeight			= $funSplitValue[0];
		$funHeightUnit		= $funSplitValue[1];
		if ($funHeightUnit=='cm')
		{
			$funConvertFeetInch	= round(($funHeight/2.54));
			$funConvertFeet		= floor(($funConvertFeetInch /12))."ft ";
			$funConvertInchs	= ($funConvertFeetInch %12)."in";
			$retHeightCmsFeet	.= $funConvertFeet." ".$funConvertInchs;

			$funSplitCm			= explode(".",$funHeight);
			$retHeightCmsFeet	.= " / ".$funSplitCm[0]." Cms";

		}//if
		if ($funHeightUnit!='cm')
		{
			if((trim($funHeight)=='167.64') || (trim($funHeight)=='167.74'))
				$retHeightCmsFeet	.= '5ft 6in';
			else
				$retHeightCmsFeet	.= $varArrHeightFeetList[trim($funHeight)];
			$retHeightCmsFeet	.= " / ".floor($funHeight)."Cms";
		}
		return $retHeightCmsFeet;
	}//getHeightUnit
	#----------------------------------------------------------------------------------------------------------
	//Get Actual Value From Array
	function getActualValueFromArrayMsgs($argPlaceHolder, $argPlaceHolderValue,$argMsgFile)
	{
		global $varOppositeMatriId,$varArrReligionList, $varArrCasteDivisionList, $varArrResidingStateList,$varArrResidingUSAStateList, $varArrCountryList, $varArrEducationCategoryList,$varArrOccupationList,$varArrSendSalamList,$varArrDeclinedList;
		global $varViewSimilarProfile,$varMessageId,$varOnlineUser,$varUsername;
		//print"<br>$argPlaceHolder  ====  $argPlaceHolderValue";
		
		switch($argPlaceHolder)
		{ 
			Case '<--AGE-->'			: return $argPlaceHolderValue; break;

			Case '<--MESSAGE-ID-->'		: $varMessageId = $argPlaceHolderValue; return $varMessageId; break;

			Case '<--HEIGHT-->'			: return $this->getHeightUnit($argPlaceHolderValue); break;

			Case '<--MATRIMONY-ID-->'	: $varOppositeMatriId	 = $argPlaceHolderValue;
										  $varViewSimilarProfile = '';
										  return $argPlaceHolderValue;break;

			Case '<--USERNAME-->'		: $varUsername = $argPlaceHolderValue;
										  return $argPlaceHolderValue; break;

			Case '<--PHOTOS-->'			: return $this->getPhoto($argPlaceHolderValue,$varOppositeMatriId); 							  break;

			Case '<--INTEREST-MSG-->'	:  if($argMsgFile=='MS' || $argMsgFile=='MR')
										  { $retMessgae = '<a 										  href="javascript:funDisplayMailMessageFace(\''.$varMessageId."','". $varUsername."','".$this->clsDisplayMsgFlag.'\');" class="grsearchtxt">'.substr(strip_tags($argPlaceHolderValue),0,70) .'..</a>';
										  }//if
										  else
										  {$retMessgae = $varArrSendSalamList[$argPlaceHolderValue];}//else
										  return $retMessgae;break;

			Case '<--FULL-MESSAGE-->'	: return $argPlaceHolderValue;break;

			Case '<--DECLINED-MSG-->'	: $DeclinedMessage = $argPlaceHolderValue ?  
										 '<tr height="20"><td valign="middle"  class="normaltxt1">&nbsp;<b>'.$this->clsDeclinedMessage.' : </b>'. 							  $varArrDeclinedList[$argPlaceHolderValue].'</td></tr>' : "";
										  return $DeclinedMessage; break;

			Case '<--RECEIVED-DATE-->'	: $funReceivedDate = $this->getDateMothYear('d-M-Y 																					H:i',$argPlaceHolderValue); 
										  return $funReceivedDate?$this->clsPendingMsg.$funReceivedDate:"";
										  break;
			Case '<--ACCEPTED-DATE-->': 
				$funAcceptedDate = $this->getDateMothYear('d-M-Y',$argPlaceHolderValue);
				return $funAcceptedDate ? $this->clsAcceptMsg.$funAcceptedDate : "";break;
			
			Case '<--DECLINED-DATE-->': 
				$funDeclinedDate = $this->getDateMothYear('d-M-Y H:i',$argPlaceHolderValue); 
				return $funDeclinedDate ? $this->clsDeclinedMsg.$funDeclinedDate : "";break;

			Case '<--SENT-DATE-->': return $this->getDateMothYear('d-M-Y',$argPlaceHolderValue); break;
			Case '<--READ-DATE-->': 
				$funReadDate	= $this->getDateMothYear('d-M-Y',$argPlaceHolderValue);
				$funReadDate	= $funReadDate ? "Read Date ".$funReadDate : "";
			return  $funReadDate; break;

			Case '<--INTEREST-ACTIVITY1-->': $funFirst = '<a class ="grSearchtxt" href="javascript: funSendReminder(\''.$varMessageId.'\');"><font color="#007A00">'.$this->clsInterestActivity1.'</font></a>';
			return $this->clsInterestActivity1 ? $funFirst : ""; break;

			Case '<--INTEREST-ACTIVITY2-->': $funSecond = '<a class ="grSearchtxt" href="javascript: funDeleteConfirm(\''.$varMessageId.'\',\''.$this->clsDeleteFlag.'\');"><font color="#007A00">'.$this->clsInterestActivity2.'</font></a>';
			if ($this->clsLinkSymbol=="yes") { $funSecond = '<font color="#007A00"> | </font> '.$funSecond; }//if
			return $this->clsInterestActivity2 ? $funSecond : ""; break;

			Case '<--INTEREST-ACTIVITY3-->': $funFirst = '<a class ="grSearchtxt" href="javascript:'. $this->clsInterestActivity3.'(\''.$varMessageId.'\');"><font color="#007A00">'.$this->clsInterestActivity1.'</font></a>';
			return $this->clsInterestActivity1 ? $funFirst : ""; break;

			Case '<--RELIGION-->'	:
			$varViewSimilarProfile .= "'".$argPlaceHolderValue."',";
			if ($argPlaceHolderValue==3) {$varReligion = "Sect"; }//if
			else { $varReligion = $varArrReligionList[$argPlaceHolderValue];}
			return $varReligion; break;
			Case '<--SUB-CASTE-->'	: 
			$funSubCaste	= is_numeric($argPlaceHolderValue) ? $varArrCasteDivisionList[$argPlaceHolderValue] : $argPlaceHolderValue;
			return  $funSubCaste !="" ? " : $funSubCaste" : " : Not Specified"; break;
			Case '<--CITY-->'		:
			$varSplitStateCountry	= explode("~",$argPlaceHolderValue);
			$varCountry				= $varSplitStateCountry[0];
			$argPlaceHolderValue	= $varSplitStateCountry[1];
			$varViewSimilarProfile .= "'".$argPlaceHolderValue."',"."'".$varOppositeMatriId."'";
			if ($varCountry=="98"){ $funCity = $varArrResidingStateList[$argPlaceHolderValue]; }//if
			else if ($varCountry=="222"){ $funCity = $varArrResidingUSAStateList[$argPlaceHolderValue]; }//else if
			else { $funCity	= $argPlaceHolderValue; }//else
			return $funCity ? $funCity."," : "";
			break;
			Case '<--COUNTRY-->'	: return $varArrCountryList[$argPlaceHolderValue]; break;
			Case '<--EDUCATION-->'	:
			$varArrEducation = split('~',$argPlaceHolderValue);
			if($varArrEducation[1] == '')
			{
				$varArrEducation[1] ='Not specified';
			}
			return $varArrEducation[0]!=10?$varArrEducationCategoryList[$varArrEducation[0]]:$varArrEducation[1];
			break;
			Case '<--OCCUPATION-->'	: 
			$varArrOccupation = split('~',$argPlaceHolderValue);
			return $varArrOccupation[0]!=60?ltrim($varArrOccupationList[$varArrOccupation[0]],"&nbsp;&nbsp;"):$varArrOccupation[1]; 
			break;
			Case '<--DESCRIPTION-->': return $this->clsDisplayFormat==B ? substr($argPlaceHolderValue,0,150)."..." : "";
			break;

			Case '<--SIMILAR-PROFILE-URL-->': return $this->getViewProfilelink($varViewSimilarProfile); break;

			Case '<--LAST-LOGIN-->' : return $this->getDateMothYear('d-M-Y',$argPlaceHolderValue); break;
			Case '<--LAST-ACTION-->' : return $this->getLastActionInfo($varOppositeMatriId); break;
			Case '<--ADD-NOTES-->'	 :
								$funName	= 'addNotes';
								$funStatus	= 'Add notes';
								if($argPlaceHolderValue !='')
								{
									$funName	= 'editNotes';
									$funStatus	= 'View notes';
								}
								return "<a href=\"javascript:".$funName."('". $varMessageId."');\" class=\"grsearchtxt\">".$funStatus.'</a>'; break;
			Case '<--ACTIVITY-LINK-->' : return $this->getActivityLinkMsgs($varOppositeMatriId); break;
			Case '<--ONLINE-->' : return $this->getOnlineLink($varOppositeMatriId,$argPlaceHolderValue); 
			Default					: return "-"; break;
		}//swith
	}//getActualValueFromArray
	#----------------------------------------------------------------------------------------------------------
	
	function getActivityLinkMsgs($argOppositeMatriId)
	{

		$funActivityLink='';
		$funArrowImage = '<img src="../'.$this->clsImagePath.'/'.$this->clsArrowImage.'" align="absmiddle" border="0" hspace="3">';
		#------------------------------------------------------------------------------------------------------
		#Paid Users
		if ($this->clsPaidStatus=="1" && $this->clsSessionMatriId !="")
		{
			$funActivityLink = " <a href=\"javascript: funContactFace('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Send Mail</a>";
			$funActivityLink .= '<img src="images/trans.gif" width="5">';
			$funActivityLink .= "<a href=\"javascript: funBookmark('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Favorites</a>";
			$funActivityLink .= '<img src="images/trans.gif" width="5">';
			$funActivityLink .= "<a href=\"javascript: funIgnore('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Ignore</a>";
		}//if

		#----------------------------------------------------------------------------------------------------
		#Free Users
		if ($this->clsPaidStatus=="0" && $this->clsSessionMatriId !="")
		{
			$funActivityLink  = "<a href=\"javascript: showInterest('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Send a Salaam</a>";
			$funActivityLink .= '<img src="images/trans.gif" width="5">';
			$funActivityLink .= "<a href=\"javascript: funBookmark('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Favorites</a>";
			$funActivityLink .= "<a href=\"javascript: funIgnore('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'> ".$funArrowImage."Ignore</a>";
		}//if
		return $funActivityLink;

	}//getActivityLink
	#----------------------------------------------------------------------------------------------------------

	function getLastActionInfo($argOppositeMatriId)
	{
		$funLastActionInfo	= "";
		$funLastActionInfo	= "<a href=\"javascript:funProfileHistoryFace('".$argOppositeMatriId."');\" class=\"grsearchtxt\">Last Action</a>";
		return $funLastActionInfo;
	}//getLastActionInfo


	#------------------------------------------------------------------------------------------------------------
	//Get Actual Value From Array
	function getActualValueFromArray($argPlaceHolder, $argPlaceHolderValue)
	{
		global $varOppositeMatriId, $varArrReligionList, $varArrCasteDivisionList, $varArrResidingStateList, $varArrResidingUSAStateList, $varArrCountryList, $varArrEducationCategoryList, $varArrOccupationList, $varOnlineUser, $sessPaidStatus, $varMatriId, $varViewSimilarProfile;

		switch($argPlaceHolder)
		{ 
			Case '<--AGE-->'			: return $argPlaceHolderValue; break;

			Case '<--HEIGHT-->'			: return $this->getHeightUnit($argPlaceHolderValue); break;

			Case '<--MATRIMONY-ID-->'	: $varOppositeMatriId=$argPlaceHolderValue;
										  $varViewSimilarProfile		= '';
										  return $argPlaceHolderValue;
										  break;

			Case '<--PHOTOS-->'		    : return $this->getPhoto($argPlaceHolderValue,$varOppositeMatriId); break;

			Case '<--USERNAME-->'		: return $argPlaceHolderValue; break;

			Case '<--RELIGION-->'		: $varViewSimilarProfile .= "'".$argPlaceHolderValue."',";
										  if ($argPlaceHolderValue==3) {$varReligion = "Sect Not Specified"; }//if
										  else { $varReligion = $varArrReligionList[$argPlaceHolderValue];}
										  return $varReligion;
										  break;

			Case '<--SUB-CASTE-->'		: $funSubCaste	= is_numeric($argPlaceHolderValue) ? 		 									  $varArrCasteDivisionList[$argPlaceHolderValue]:$argPlaceHolderValue;
										  return $funSubCaste !="" ? " , $funSubCaste" : " ";
										  break;

			Case '<--CITY-->'			: $varSplitStateCountry	= explode("~",$argPlaceHolderValue);
										  $varCountry			= $varSplitStateCountry[0];
										  $argPlaceHolderValue	= $varSplitStateCountry[1];
										  $varViewSimilarProfile .= "'".$argPlaceHolderValue."',"."'".$varOppositeMatriId."'";
										  if ($varCountry=="98")
										  { $funCity = $varArrResidingStateList[$argPlaceHolderValue]; }//if
										  else if ($varCountry=="222")
										  {$funCity = $varArrResidingUSAStateList[$argPlaceHolderValue]; }//else if
										  else { $funCity	= $argPlaceHolderValue; }//else
										  return $funCity ? $funCity.", ".$varArrCountryList[$varCountry] : $varArrCountryList[$varCountry];
										  break;

			Case '<--EDUCATION-->'		: $varArrEducation = split('~',$argPlaceHolderValue);
										  return $varArrEducation[0]==10 ? ($varArrEducation[1]!=''?$varArrEducation[1]:'Not Specified') : $varArrEducationCategoryList[$varArrEducation[0]];
										  break;

			Case '<--OCCUPATION-->'		: $varArrOccupation = split('~',$argPlaceHolderValue);
										  return $varArrOccupation[0]==60 ? ($varArrOccupation[1]!=''?$varArrOccupation[1]:'Not Specified') : ltrim($varArrOccupationList[$varArrOccupation[0]],"&nbsp;&nbsp;");
										  break;

			Case '<--DESCRIPTION-->'	: 
										  return $this->clsDisplayFormat=='B' ? substr($argPlaceHolderValue,0,100)."..." : ""; break;

			Case '<--LAST-LOGIN-->'		: return $this->getDateMothYear('d-M-Y',$argPlaceHolderValue,$varOppositeMatriId); break;

			Case '<--ACTIVITY-LINK-->'	: return $this->getActivityLink($varOppositeMatriId); break;

			Case '<--ONLINE-->'			: return $this->getOnlineLink($varOppositeMatriId,$argPlaceHolderValue);
										  break;

			Case '<--SIMILAR-PROFILE-URL-->': return $this->getViewProfilelink($varViewSimilarProfile); break;

			Default						: return "-"; break;

		}//swith
	}//getActualValueFromArray
	#------------------------------------------------------------------------------------------------------------
	function getViewProfilelink($argViewSimilarProfile)
	{
		
		$funServerUrl			= $this->clsServerURL;
		$funViewProfileArg		= explode(',',$argViewSimilarProfile);
		//print_r($funViewProfileArg);
		$varViewSimilarLink		= $funServerUrl.'/fcbkmatrimony/facebook-search-results.php?starSearch=yes&page=1&gender='.($this->clsSessionGender==2?1:2).'&religion='.trim($funViewProfileArg[0],"'").'&city='.trim($funViewProfileArg[1],"'").'&viewSimilarMatriId='.trim($funViewProfileArg[2],"'");
		return $varViewSimilarLink;
	}
	#------------------------------------------------------------------------------------------------------------
	//GENERATE Online Link
	function getOnlineLink($argMatriId,$argPlaceHolderValue)
	{
		$funFileStatus = $this->getOnlinetime($argMatriId);
		//echo $funFileStatus;
		if ($funFileStatus=='yes')
		{
			//echo $filename;
			if ($this->clsPaidStatus==0 && $this->clsSessionMatriId!="")
			{
				$argPlaceHolderValue =  '<a href="../payment/payment-options.php?matrimonyId='.$argMatriId.'" class="onlinetxt">Online</a>';
			}//if
			elseif($this->clsSessionMatriId=="") 
			{
				$argPlaceHolderValue =  '<b><a href="../registration/index.php?act=intermediate-login&req=payment&matrimonyId='.$argMatriId.'" class="onlinetxt">Online</a></b>';
			}
			else
			{
				$argPlaceHolderValue = '<a href="javascript:openindex();"class="onlinetxt">Online</a>';
			}
			return $argPlaceHolderValue;
		}//if
	}//getOnlineLink
	#------------------------------------------------------------------------------------------------------------
	
	//GENERATE Online Time
	function getOnlinetime($argMatriId)
	{
		$funFileExists  = '';
		$funFileName	= '../onlineUsers/'.$argMatriId.".txt";
		if (file_exists($funFileName)) { $funLastAceessTime = date ("H:i", filemtime($funFileName)); }//if
		if ($funLastAceessTime !="")
		{
			$funGetCookieTime	= explode(":",$funLastAceessTime);
			$funGetCurrentTime  = explode(":",date('H:i'));
			$funCookieMinute	= (($funGetCookieTime[0] * 60) + $funGetCookieTime[1]);
			$funCurrentMinute	= (($funGetCurrentTime[0] * 60) + $funGetCurrentTime[1]);
			$funTotalMinute		= ($funCurrentMinute - $funCookieMinute);
			#TO UPDATE THE CURRENT
			if ($funTotalMinute <= 15)
			{
				//touch($funFileName); 
				$funFileExists = 'yes';
			}//if
			else $funFileExists = 'no';
		}//if
		return $funFileExists;
	}//getOnlinetime
	#----------------------------------------------------------------------------------------------------------
	//GENERATE Online MatriIds
	function getOnlineMatriId()
	{
		$funFolder = '../onlineUsers/';
		$funInnerFiles = $this->list_files($funFolder);
		return $funInnerFiles;

	}//getOnlineMatriId
	#----------------------------------------------------------------------------------------------------------
	//List all Online Text Filess
	function list_files($argFolder) 
	{
		$funInnerMatriId='';
		if ($a = glob($argFolder . '*')) 
		{
			foreach($a as $funFiles) 
			{
				if (is_file($funFiles)) 
				{
					$funInnerFiles = str_replace($argFolder,'',$funFiles);
					$funFileMatriId = str_replace('.txt','',$funInnerFiles);
					$funFileStatus = $this->getOnlinetime($funFileMatriId);
					if($funFileStatus=='yes')
					{ 
						$funInnerMatriId .= "'".str_replace('.txt','',$funInnerFiles)."',"; }
				 }
			}
		}//if
		return $funInnerMatriId;
	}//list_files
	#----------------------------------------------------------------------------------------------------------
	//GENERATE QUERY FOR LIST RECORDS
	function listSearchResult($argPurpose,$varViewSimilarMatriId="")	
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funDisplay 		= "";
		$funPrimary			= count($this->clsPrimary);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funNumOfGroup		= count($this->clsGroup);
		$funNumOfFields 	= count($this->clsFields);
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= "FROM memberinfo WHERE Publish=1 AND ";
		if ($argPurpose =='S')
		{ $funQuery .= "MatriId <> '".$varViewSimilarMatriId."' AND ";}
		if ($this->clsSessionMatriId !="")
		{ $funQuery .= "MatriId NOT IN ('".$this->clsSessionMatriId."') AND ";}
		for($i=0;$i<$funPrimary;$i++)
		{
			$funQuery			.= $this->clsPrimary[$i]." ";
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if($this->clsPrimaryValueIsArr[$i] == 'yes'){ $funQuery .= $this->getArrPrimaryValue($i); }//if
			else{ $funQuery .= $this->clsPrimarySymbol[$i].$funPrimaryValue." "; }//else

			if($i<($funPrimary-1)){ $funQuery .= $this->clsPrimaryKey[$i]." "; }//if
		}//for
		if($this->clsWhosOnline == "yes")
		{
			$funOnlineMatriId = $this->getOnlineMatriId(); 
			if($funOnlineMatriId!='') {
				$funOnlineMatriIds= substr($funOnlineMatriId,0,-1);
				//echo $funOnlineMatriIds;
				$funQuery .= " AND MatriId  IN (".$funOnlineMatriIds.")";
			}//if
			else { $funQuery .= " AND MatriId=''"; }//else
		}//if
		if($this->clsDisplayFormat=='P') { $funQuery .= " AND Photo_Set_Status=1 AND Protect_Photo_Set_Status=0 "; }


		if($this->clsIgnoredProfiles == "yes")
		{
			$funQuery .= "AND MatriId NOT IN (SELECT Opposite_MatriId FROM ignoreinfo WHERE MatriId = '".$this->clsCurrentSession."') ";
		}//if
		if($this->clsContactedProfiles == "yes")
		{
			$funQuery .= "AND MatriId NOT IN (SELECT Opposite_MatriId FROM memberactioninfo WHERE MatriId = '".$this->clsCurrentSession."') ";
		}//if
		
		if($funNumOfGroup > 0)
		{
			$funQuery .= "GROUP BY ";
			for($i=0;$i<$funNumOfGroup;$i++)
			{
				if($i<($funNumOfGroup-1)){ $funQuery .= $this->clsTable.".".$this->clsGroup[$i].", "; }//if
				else{ $funQuery .= $this->clsTable.".".$this->clsGroup[$i]." "; }//else
			}//for
		}//if
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= "ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if
		$funQuery .= " LIMIT ".$this->clsStart.",".$this->clsLimit;
		//print "<br><br>".$funQuery;

		//DISPLAY RESULTS BY USING THUMBNAIL TEMPLATE
		$funDisplay = $this->displayThumbnailQuickResults($funQuery);

		return $funDisplay;
	}//listSearchResult
	#----------------------------------------------------------------------------------------------------------
	//GENERATE Primary Value as an Array
	function getArrPrimaryValue($argI)
	{
		$funPrimaryValueIsArr = count($this->clsPrimaryValue[$argI]);
		$funQuery .= "IN(";
		for($j=0;$j<$funPrimaryValueIsArr;$j++)
		{
			if ($this->clsPrimaryValue[$argI][$j] !="")
			{
				$funPrimaryValue	= $this->clsPrimaryValue[$argI][$j];
				$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

				if($j<($funPrimaryValueIsArr-1)){ $funQuery .= $funPrimaryValue.','; }//if
				else{ $funQuery .= $funPrimaryValue; }//if
			}//if
		}//for
		$funQuery .= ") ";
		$funCheckComma		= trim($funQuery);
		$funCheckLastChar	= substr($funCheckComma,-2,1);
		if ($funCheckLastChar === ",") { $funQuery = substr($funCheckComma,0,strlen($funCheckComma)-2) . ") "; }//if

		return $funQuery;
	}//getArrPrimaryValue
	#----------------------------------------------------------------------------------------------------------
	//MEMBER LAST ACTION DETAILS
	function getLastConactCount($argMatriId, $argYouContacted='no')
	{
		if($argYouContacted == 'no')
		{
			$funQuery	= 'SELECT Opposite_MatriId, Date_Received,Status,1 as I FROM interestreceivedinfo WHERE MatriId = \''. $argMatriId. '\' UNION SELECT Opposite_MatriId, Date_Received,Status,2 as I FROM mailreceivedinfo WHERE MatriId = \''. $argMatriId.'\' ORDER BY Date_Received DESC LIMIT 0,1';
		}
		else
		{
			$funQuery	= 'SELECT Opposite_MatriId, Date_Sent,Status,1 as I FROM interestsentinfo WHERE MatriId = \''. $argMatriId. '\' UNION SELECT Opposite_MatriId, Date_Sent,Status,2 as I FROM mailsentinfo WHERE MatriId = \''. $argMatriId.'\' ORDER BY Date_Sent DESC LIMIT 0,1';
		}//else
		//print"<br><br>".$funQuery;
		$resQuery	= mysql_query($funQuery);
		$retDisplay	= mysql_fetch_array($resQuery);
		return $retDisplay;
		
	}//getLastConactCount

	#----------------------------------------------------------------------------------------------------------
	//SELECT VALUES OF THE SELECTED RECORD
	function selectListSearchResult()
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funDisplay 		= "";
		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= "FROM ".$this->clsTable." WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue; }//else
		}//for
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= "ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if
	
		$resQuery		= mysql_query($funQuery);
		$funNumOfFields	= count($this->clsFields);
		while($row = mysql_fetch_array($resQuery))
		{
			for($i=0;$i<$funNumOfFields;$i++)
			{ $funArrResult[$this->clsFields[$i]] = trim($row[$this->clsFields[$i]]); }//for
		}//while
		$retDisplay = $funArrResult;

		return $retDisplay;
	}//selectListSearchResult
	#----------------------------------------------------------------------------------------------------------
	//SELECT MULTIPLE VALUES OF THE SELECTED RECORD
	function multiSelectListSearchResult()
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funDisplay 		= "";
		$funNumOfFields 	= count($this->clsFields);
		$funPrimary			= count($this->clsPrimary);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= "FROM ".$this->clsTable." WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue." "; }//else
		}//for
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= "ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if
		if (($this->clsAllowedLimit=="yes")|| ($this->clsLimit !='' && $this->clsStart != '')) 
		{ $funQuery .= "LIMIT ".$this->clsStart.",".$this->clsLimit; }//if
		
		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$j=0;
		$funNumOfFields	= count($this->clsFields);
		while($row = mysql_fetch_array($resQuery))
		{
			for($i=0;$i<$funNumOfFields;$i++)
			{ $funArrResult[$j][$this->clsFields[$i]] = trim($row[$this->clsFields[$i]]); }//for
			$j++;
		}//while
		$retDisplay = $funArrResult;

		return $retDisplay;
	}//multiSelectListSearchResult
	#------------------------------------------------------------------------------------------------------------
	//TO GET NUMBER OF RESULTS
	function numOfResults()
	{
		global $mod,$act,$errMessages;
		
		$funQuery 			= "";
		$funPrimary			= count($this->clsPrimary);
		
		$funQuery .= "SELECT COUNT(".$this->clsCountField.") AS ".$this->clsCountField." FROM ".$this->clsTable." WHERE ";
		for($i=0;$i<$funPrimary;$i++)
		{
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";
			if ($i==$this->clsPrimaryGroupStart){ $funQuery .= "("; }//if
			$funPrimarySymbol = $this->clsPrimarySymbol[$i]? $this->clsPrimarySymbol[$i] : '=';
			if($i<($funPrimary-1)) 
			{ $funQuery .= $this->clsPrimary[$i].$funPrimarySymbol.$funPrimaryValue." ". 	$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i].$funPrimarySymbol.$funPrimaryValue; }//else
			
			if ($i==$this->clsPrimaryGroupEnd) $funQuery .= ")";
		}//for

		//print "<br><br>".$funQuery;
		$resQuery		= mysql_query($funQuery);
		$row			= mysql_fetch_array($resQuery);
		$retDisplay	= $row[$this->clsCountField];

		return $retDisplay;
	}//numOfResults
	#----------------------------------------------------------------------------------------------------------//CHECK FILTER SETTINGS
	function selectFilterInfo($argArrName,$argSelectedValue)
	{
			$funretValue = "no";
			$funArrSelectedValue = explode("~", $argArrName);
			if (in_array($argSelectedValue, $funArrSelectedValue))
			{
				$funretValue = "yes";
			}//if
			return $funretValue;

	}//selectFilterInfo

	#----------------------------------------------------------------------------------------------------------

	//GET CONTENT FROM THE GIVEN FILE
	function getContentFromFile($argFileName)
	{
		if(!$funFP = fopen($argFileName, "r"))
		{ echo 'Error: Please check file permission or file name.'; }//if
		
		if(filesize($argFileName) > 0)
		{
			if(!$funFileContent = fread($funFP, filesize($argFileName)))
			{ echo 'Error: Please check file permission or file name.'; }//if
		}//if
		else { echo "File doesn't contain any text"; }//else
		fclose($funFP);
		$retFileContent = trim($funFileContent);
		
		return $retFileContent;
	}//getContentFromFile
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function getValuesFromArray($argArrName, $argNullOptionName, $argNullOptionValue, $argSelectedValue)
	{
		$funOptions	="";	
		if($argNullOptionName !="")
		{ $funOptions .= '<option value="'.$argNullOptionValue.'">'.$argNullOptionName.'</option>'; }//if
		foreach($argArrName as $funIndex => $funValues)
		{
			$funSelectedItem = $argSelectedValue==$funIndex ? "selected" : "";
			$funOptions .= '<option value="'.$funIndex.'" '.$funSelectedItem.'>'.$funValues.'</option>';
		}//for
		
		echo $funOptions;
		
	}//getValuesFromArray
	#------------------------------------------------------------------------------------------------------------
	function generateArrayFromFormValues($argArrName)
	{
		$funArrayCount	= count($argArrName);
		$funArrayElements = "";

		for($i=0;$i<$funArrayCount;$i++)
		{ 
			if ($argArrName[$i] !="") { $funArrayElements	.= $argArrName[$i]."~"; }//if
		}

		$retArrayElements = substr($funArrayElements,0,-1);

		return $retArrayElements;

	}//generateArrayFromFormValues
	#------------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function displaySelectedValuesFromArray($argArrName,$argSelectedValue)
	{
		$funOptions	="";
		$funArrSelectedValue = explode("~", $argSelectedValue);
		foreach($argArrName as $funIndex => $funValues)
		{
			if($funIndex != "none")
			{
				if (in_array($funIndex, $funArrSelectedValue))
				{ $funOptions .= $funValues.", "; }//if
			}//if
		}//foreach
		echo rtrim($funOptions,', ');

	}//displaySelectedValuesFromArray
	#------------------------------------------------------------------------------------------------------------
	//Number Of Results Model I
	function numOfResultsM1()
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funDisplay 		= "";
		$funPrimary			= count($this->clsPrimary);
		$funQuery			.= "SELECT COUNT(MatriId) AS COUNT FROM memberinfo WHERE Publish=1 AND ";
		if ($this->clsSessionMatriId !="") { $funQuery .= "MatriId NOT IN ('".$this->clsSessionMatriId."') AND ";}
		for($i=0;$i<$funPrimary;$i++)
		{
			$funQuery			.= $this->clsPrimary[$i]." ";
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";
			if($this->clsPrimaryValueIsArr[$i] == 'yes'){ $funQuery .= $this->getArrPrimaryValue($i); }//if
			else{ $funQuery .= $this->clsPrimarySymbol[$i].$funPrimaryValue." "; }//else
			if($i<($funPrimary-1)){ $funQuery .= $this->clsPrimaryKey[$i]." "; }//if
		}//for

		if($this->clsWhosOnline == "yes")
		{
			$funOnlineMatriId = $this->getOnlineMatriId(); 
			if($funOnlineMatriId!='') {
				$funOnlineMatriIds= substr($funOnlineMatriId,0,-1);
				//echo $funOnlineMatriIds;
				$funQuery .= " AND MatriId  IN (".$funOnlineMatriIds.")";
			}//if
			else { $funQuery .= " AND MatriId=''"; }//else
		}//if

		if($this->clsIgnoredProfiles == "yes")
		{
			$funQuery .= "AND MatriId NOT IN (SELECT Opposite_MatriId FROM ignoreinfo WHERE MatriId = '".$this->clsCurrentSession."') ";
		}
		if($this->clsContactedProfiles == "yes")
		{
			$funQuery .= "AND MatriId NOT IN (SELECT Opposite_MatriId FROM memberactioninfo WHERE MatriId = '".$this->clsCurrentSession."') ";
		}


		//print "<br><br>".$funQuery;		
		$funArrQuery		= mysql_query($funQuery);
		$funCount			= mysql_fetch_array($funArrQuery);
		$retNoOfResults		= $funCount["COUNT"];

		return $retNoOfResults;
	}//numOfResultsM1
	#----------------------------------------------------------------------------------------------------------
	//Check Ignored,Block,Decline Profiles
	function checkMyListProfiles($argOppositeMatriId)
	{
		$funCheckBookMark	= '';
		$funCheckIgnore		= '';
		$funCheckBlock		= '';
		$jj = 0;
		
		foreach($this->clsArrListResultSet as $funSingleId)
		{
			$funListIndexValue = array_search($argOppositeMatriId, $funSingleId);
			if($funListIndexValue != '')
				break;
			$jj++;
		}
		if($funListIndexValue != '')
		{
			$funCheckBookMark		= $this->clsArrListResultSet[$jj]["Bookmarked"];
			$funCheckIgnore			= $this->clsArrListResultSet[$jj]["Ignored"];
			$funCheckBlock			= $this->clsArrListResultSet[$jj]["Blocked"];
		}
		
		if ($funCheckBookMark=="1") 
		{
			$funMyListInfo		= '<a href="javascript:void(0);" onClick="javascript:showbookmark(\'show-bookmarkmessage.php?id='.$argOppositeMatriId.'\'); return false;"><img src="'.$this->clsFavoritesIcon.'" title="Favorite Profile" border="0"></a>';
		}//if
		if ($funCheckIgnore=="1")
		{ 
			$funMyListInfo		= '<a href="javascript:void(0);" onClick="javascript:showbookmark(\'show-ignoremessage.php?id='.$argOppositeMatriId.'\'); return false;"><img src="'.$this->clsIgnoreIcon.'" title="Ignored Profile" border="0"></a>';
		}//if
		if ($funCheckBlock=="1")
		{ 
			$funMyListInfo	   .= '<img title="Blocked Profile" src='.$this->clsBlockIcon.' border="0"> '; 
		}//if
		$retMyListInfo	= $funMyListInfo;

		return $retMyListInfo;
	}//checkMyListProfiles
	#----------------------------------------------------------------------------------------------------------
	//Check Ignored,Block,Decline Profiles
	function checkMyListViewProfile($argOppMatriId,$argMatriId)
	{
		$funCheckBookMark	= '';
		$funCheckIgnore		= '';
		$funCheckBlock		= '';
		if ($argOppMatriId !="" && $argMatriId !="")
		{
			$funListQuery			= "SELECT Opposite_MatriId,Bookmarked,Ignored,Blocked FROM memberactioninfo WHERE MatriId='".$argMatriId."'  AND Opposite_MatriId ='".$argOppMatriId."'";
			//print "<br><br>".$funListQuery;
			$funExecute	= mysql_query($funListQuery);
			while($row = mysql_fetch_array($funExecute))
			{
				$funBookmark	= $row["Bookmarked"];
				$funIgnored		= $row["Ignored"];
				$funBlocked		= $row["Blocked"];
				$funOppMatriId	= $row["Opposite_MatriId"];
				
			}//while
		}//if
		
		if ($funBookmark=="1") 
		{
			$funMyListInfo		= '<a href="javascript:void(0);" onClick="javascript:showbookmark(\'show-bookmarkmessage.php?id='.$argOppMatriId.'\'); return false;"><img src="'.$this->clsFavoritesIcon.'" title="Favorite Profile" border="0"></a>';
		}//if
		if ($funIgnored=="1")
		{ 
			$funMyListInfo		= '<a href="javascript:void(0);" onClick="javascript:showbookmark(\'show-ignoremessage.php?id='.$argOppMatriId.'\'); return false;"><img src="'.$this->clsIgnoreIcon.'" title="Ignored Profile" border="0"></a>';
		}//if
		if ($funBlocked=="1")
		{ 
			$funMyListInfo	   .= '<img title="Blocked Profile" src='.$this->clsBlockIcon.' border="0"> '; 
		}//if
		$retMyListInfo	= $funMyListInfo;

		return $retMyListInfo;
	}//checkMyListProfiles
	#------------------------------------------------------------------------------------------------------------	//get Activity Link
	function getActivityLink($argOppositeMatriId)
	{
		$funActivityLink='';
		$funMatriIdGender = $this->getGender($this->clsSessionMatriId);
		$funOppMatriIdGender = $this->getGender($argOppositeMatriId);
		$funOppMatriIdName = $this->getUsername($argOppositeMatriId);
		$funArrowImage = '<img src="../images/'.$this->clsArrowImage.'" align="absmiddle" border="0" hspace="3">';
		if($this->clsWhosOnline== "yes") {
			if ($this->clsSessionMatriId=="")
			{
				$funActivityLink = $funArrowImage.'<a href="../registration/index.php?act=intermediate-login&req=payment&matrimonyId='.$argOppositeMatriId.'" align="absmiddle" class="grsearchtxt" align="absmiddle"  target="_blank">Chat</a>';
			}//
			#Paid Users
			if ($this->clsPaidStatus=="1" && $this->clsSessionMatriId !="" &&  ($funMatriIdGender!=$funOppMatriIdGender))
			{
				$funActivityLink = $funArrowImage.' <a href="javascript: funChat(\''.$funOppMatriIdName.'\');" class="grsearchtxt" align="absmiddle"  target="_blank">Chat</a>';
			}
			#Free Users
			if ($this->clsPaidStatus=="0" && $this->clsSessionMatriId !="" &&  ($funMatriIdGender!=$funOppMatriIdGender))
			{
				$funActivityLink = $funArrowImage.' <a href="../payment/payment-options.php" class="grsearchtxt" align="absmiddle"  target="_blank">Chat</a>';
			}
		} else {
		#Guest Users
		if ($this->clsSessionMatriId=="")
		{
			$funDisplayText = 'Register FREE to contact this member';
			$funActivityLink = '<a href="../registration/index.php?act=intermediate-login&req=payment&matrimonyId='.$argOppositeMatriId.'" align="absmiddle" class="grsearchtxt" align="absmiddle" target="_blank">'.$funArrowImage.$funDisplayText.'</a>';
		}

		#Paid Users
		/*if ($this->clsPaidStatus=="1" && $this->clsSessionMatriId !="" && ($funMatriIdGender!=$funOppMatriIdGender))
		{
			$funActivityLink = '<a href="../my-messages/profile-contact.php?id='.$argOppositeMatriId.'" align="absmiddle" class="grsearchtxt" align="absmiddle" target="_blank">'.$funArrowImage.'Send Mail</a>';
			$funActivityLink .= '<img src="../images/trans.gif" width="5">';
			$funActivityLink .= '<a href="../my-list/bookmark-add.php?bookMarkId='.$argOppositeMatriId.'" align="absmiddle" class="grsearchtxt" align="absmiddle" target="_blank">'.$funArrowImage.'Add to Favorites</a>';
		}

		#Free Users
		if ($this->clsPaidStatus=="0" && $this->clsSessionMatriId !="" && ($funMatriIdGender!=$funOppMatriIdGender))
		{*/
			/*if($this->getOfferExists($this->clsSessionMatriId)==1 && $this->getContactCount($this->clsSessionMatriId)<10)
			{
				$funActivityLink	= " <a href=\"javascript: funContact('".$argOppositeMatriId."');\" class='grsearchtxt' align='abstop'>".$funArrowImage."Send Mail</a>";
			}//if
			else
			{*/
				
				/*$funActivityLink = '<a href="../my-messages/interest-add.php?mid='.$argOppositeMatriId.'" align="absmiddle" class="grsearchtxt" align="absmiddle" target="_blank">'.$funArrowImage.'Send a Salaam</a>';
			//}//else

			$funActivityLink .= '<img src="../images/trans.gif" width="5">';
			$funActivityLink .= '<a href="../my-list/bookmark-add.php?bookMarkId='.$argOppositeMatriId.'" align="absmiddle" class="grsearchtxt" align="absmiddle" target="_blank">'.$funArrowImage.'Add to Favorites</a>';
		}*/
		#Paid Users
		if ($this->clsPaidStatus=="1" && $this->clsSessionMatriId !="" && ($funMatriIdGender!=$funOppMatriIdGender))
		{
			$funActivityLink = " <a href=\"javascript: funContact('".$argOppositeMatriId."');\" class='grsearchtxt' align='abstop'>".$funArrowImage."Send Mail</a>";
			$funActivityLink .= '<img src="../images/trans.gif" width="5">';
			$funActivityLink .= "<a href=\"javascript: funBookmark('".$argOppositeMatriId."');\" class='grsearchtxt' align='abstop'>".$funArrowImage."Add to Favorites</a>";
		}

		#Free Users
		if ($this->clsPaidStatus=="0" && $this->clsSessionMatriId !="" && ($funMatriIdGender!=$funOppMatriIdGender))
		{
			/*if($this->getOfferExists($this->clsSessionMatriId)==1 && $this->getContactCount($this->clsSessionMatriId)<10)
			{
				$funActivityLink	= " <a href=\"javascript: funContact('".$argOppositeMatriId."');\" class='grsearchtxt' align='abstop'>".$funArrowImage."Send Mail</a>";
			}//if
			else
			{*/
				$funActivityLink	= " <a href=\"javascript: showInterest('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Send a Salaam</a>";
			//}//else

			$funActivityLink .= '<img src="../images/trans.gif" width="5">';
			$funActivityLink .= "<a href=\"javascript: funBookmark('".$argOppositeMatriId."');\" class='grsearchtxt' align='absmiddle'>".$funArrowImage."Add to Favorites</a>";
		}

		}
		return $funActivityLink;
	}//getActivityLink
	#------------------------------------------------------------------------------------------------------------

	//Page Navigation
	function pageNavigation($argNumOfResults, $argCurrentPage, $argNumOfPages, $argAllowBgColor)
	{
		#Previous
		if($argCurrentPage > 1)
		{ echo '<img src="'.$this->clsServerURL.'/images/prev-arrow.gif" align="absmiddle"> <a href="javascript:doProductNext('.($argCurrentPage-1).');" title="Previous" class="grsearchtxt">Previous</a> | '; }
		#Next
		if($argCurrentPage < $argNumOfPages)
		{ echo '<a href="javascript:doProductNext('.($argCurrentPage+1).');" title="Next" class="grsearchtxt">Next</a>&nbsp;<img src="'.$this->clsServerURL.'/images/next-arrow.gif" align="absmiddle">'; }

	}//pageNavigation
	#------------------------------------------------------------------------------------------------------------
	function listForPaymentDetails($argMatriId)
	{
		global $mod,$act,$errMessages;
		$funQuery 			= "";
		$funDisplay 		= "";
		$funArrResult		= array();
		$funQuery .= "SELECT User_Name,Country,Residing_State,Contact_Address,Date_Created FROM memberinfo WHERE MatriId='".$argMatriId."'";
		$resQuery		= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($resQuery);
		if($funNumOfRows>0)
			$funArrResult = mysql_fetch_array($resQuery);
		else
			$funArrResult = array();
		$retDisplay = $funArrResult;

		return $retDisplay;
	}//listForPaymentDetails
	#------------------------------------------------------------------------------------------------------------
	function getcountrycode() 
	{
		if (getenv(HTTP_X_FORWARDED_FOR)) { $IPADDRESS = getenv(HTTP_X_FORWARDED_FOR); }//if
		else { $IPADDRESS = getenv(REMOTE_ADDR); }//else
		//$IPADDRESS="72.3.235.37";     //for US test
		//$IPADDRESS="203.196.153.7";   //for India test
		$pointer = fopen("http://www.muslimmatrimonial.com/cgi-bin/getip2country.cgi?IP=$IPADDRESS", "r");
		if ($pointer) 
		{
			while (!feof($pointer)) { $countryname = fgets($pointer, 256);}
			return $countryname;
			fclose($pointer);
		}
	}//getcountrycode
	#------------------------------------------------------------------------------------------------------------	
	//DISPLAY Contact Count for offer pupose -->31 jan 2007-->rohini
	/*function getOfferExists($argMatriId)
	{
		$funQuery = "SELECT Count(MatriId) AS OfferExist FROM memberofferinfo WHERE MatriId='".$argMatriId."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["OfferExist"];
	}//getOfferExists
	#------------------------------------------------------------------------------------------------------------	

	//DISPLAY Contact Count for offer pupose -->31 jan 2007-->rohini
	function getContactCount($argMatriId)
	{
		$funQuery		= "SELECT Contact_Count FROM memberofferinfo WHERE MatriId='".$argMatriId."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["Contact_Count"];
	}//getContactCount*/
	#------------------------------------------------------------------------------------------------------------
	function listCommSearchResultWithPhoto($argGender)
	{
		global $mod,$act,$errMessages;

		$funQuery 			= "";
		$funDisplay 		= "";
		$funFieldsToDisplay	= "";
		$funPrimary			= count($this->clsPrimary);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funNumOfGroup		= count($this->clsGroup);
		$funNumOfFields		= count($this->clsFields);
		$funQuery .= "SELECT ";
		//if ($funNumOfFields > 0) { $funQuery .= " DISTINCT(mli.MatriId), "; }//if
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= " FROM memberinfo, memberlogininfo as mli WHERE mli.MatriId = memberinfo.MatriId AND  memberinfo.Photo_Set_Status=1 AND Publish=1 AND Gender=".$argGender." AND ";

		if ($this->clsSessionMatriId !="")
		{ $funQuery .= "mli.MatriId NOT IN ('".$this->clsSessionMatriId."') AND ";}

		for($i=0;$i<$funPrimary;$i++)
		{

			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i].$this->clsPrimarySymbol[$i].$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i].$this->clsPrimarySymbol[$i].$funPrimaryValue." "; }//else
		}//for
		if($funNumOfGroup > 0)
		{
			$funQuery .= "GROUP BY ";
			for($i=0;$i<$funNumOfGroup;$i++)
			{
				if($i<($funNumOfGroup-1)){ $funQuery .= $this->clsTable.".".$this->clsGroup[$i].", "; }//if
				else{ $funQuery .= $this->clsTable.".".$this->clsGroup[$i]." "; }//else
			}//for
		}//if
		$funQuery .= " ORDER BY RAND()";
		$funQuery .= " LIMIT ".$this->clsStart.",".$this->clsLimit;
		
	//	print "<br><br>".$funQuery;

		//DISPLAY RESULTS BY USING THUMBNAIL TEMPLATE
		$funNumOfPlaceHolders	= count($this->clsPlaceHolders);
		$resQuery				= mysql_query($funQuery);
		$funNumOfRows			= mysql_num_rows($resQuery);
		if($funNumOfRows > 0)
		{
			$funFlag=0;
			while($row = mysql_fetch_object($resQuery))
			{
				$funTemplateXerox = $this->clsListTemplate;
				for($i=0;$i<$funNumOfPlaceHolders;$i++)
				{
					$funPlaceHolderValue = $this->clsPlaceHoldersValues[$i];
					
					if(in_array($this->clsPlaceHoldersValues[$i], $this->clsTextConversion))
					{ $funValue = $this->getActualValueFromArray($this->clsPlaceHolders[$i], $row->$funPlaceHolderValue); }//if
					else{ $funValue = $row->$funPlaceHolderValue; }//else
					$funTemplateXerox = str_replace($this->clsPlaceHolders[$i], $funValue, $funTemplateXerox);
				}//for
				$funDisplayTemplate = $funTemplateXerox; 

				echo "<table><tr><td><div width='295' align='center'>".$funDisplayTemplate."</div></td></tr><tr><td>&nbsp;</td></tr></table>"; 
				$funFlag++;
			}//while
			if($this->clsMoreProfiles == "yes")
			{
				echo '<tr><td><table border="0" cellpadding="2" cellspacing="2" width="550">';
				echo '<tr><td align="right"><a href="index.php" class="grsearchtxt"><b>More Profiles...</b></a></td></tr>';
				echo '</table></td></tr>';
			}//if
		}//if
		else
		{
			$funDisplay	.= '<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center">';
			$funDisplay .= '<tr><td align="center" class="errorMsg"><br>'.$errMessages['Zero_Result'].'<br></td></tr>';
			echo $funDisplay .= '</table>';
		}//else		return $funDisplay;

	}//listCommSearchResultWithPhoto
	#------------------------------------------------------------------------------------------------------------

	function listMuslimGenSearchResultWithPhoto($argGender)
	{
		global $mod,$act,$errMessages;

		$funQuery 			= "";
		$funDisplay 		= "";
		$funFieldsToDisplay	= "";
		$funNumOfFields		= count($this->clsFields);
		$funQuery .= "SELECT ";
		//if ($funNumOfFields > 0) { $funQuery .= " DISTINCT(mli.MatriId), "; }//if
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for
		$funQuery .= " FROM memberinfo, memberlogininfo as mli WHERE mli.MatriId = memberinfo.MatriId AND memberinfo.Photo_Set_Status=1 AND Publish=1 AND Gender=".$argGender;
		
		if ($this->clsSessionMatriId !="")
		{ $funQuery .= " AND mli.MatriId NOT IN ('".$this->clsSessionMatriId."')";}
		
		if($this->clsWhosOnline == "yes")
		{
			$funOnlineMatriId = $this->getOnlineMatriId(); 
			if($funOnlineMatriId!='') {
				$funOnlineMatriIds= substr($funOnlineMatriId,0,-1);
				//echo $funOnlineMatriIds;
				$funQuery .= " AND mli.MatriId  IN (".$funOnlineMatriIds.")";
			}//if
			else { $funQuery .= " AND mli.MatriId=''"; }//else
		}//if

		$funQuery .= " ORDER BY rand()";
		$funQuery .= " LIMIT ".$this->clsStart.",".$this->clsLimit;
		//print "<br><br>".$funQuery;

		//DISPLAY RESULTS BY USING THUMBNAIL TEMPLATE
		$funNumOfPlaceHolders	= count($this->clsPlaceHolders);
		$resQuery				= mysql_query($funQuery);
		$funNumOfRows			= mysql_num_rows($resQuery);
		if($funNumOfRows > 0)
		{
			$funFlag=0;
			while($row = mysql_fetch_object($resQuery))
			{
				$funTemplateXerox = $this->clsListTemplate;
				for($i=0;$i<$funNumOfPlaceHolders;$i++)
				{
					$funPlaceHolderValue = $this->clsPlaceHoldersValues[$i];
					
					if(in_array($this->clsPlaceHoldersValues[$i], $this->clsTextConversion))
					{ $funValue = $this->getActualValueFromArray($this->clsPlaceHolders[$i], $row->$funPlaceHolderValue); }//if
					else{ $funValue = $row->$funPlaceHolderValue; }//else
					$funTemplateXerox = str_replace($this->clsPlaceHolders[$i], $funValue, $funTemplateXerox);
				}//for
				$funDisplayTemplate = $funTemplateXerox; 

				echo "<table><tr><td><div width='295' align='center'>".$funDisplayTemplate."</div></td></tr><tr><td>&nbsp;</td></tr></table>"; 
				$funFlag++;
			}//while
			if($this->clsMoreProfiles == "yes")
			{
				echo '<tr><td><table border="0" cellpadding="2" cellspacing="2" width="550">';
				echo '<tr><td align="right"><a href="index.php" class="grsearchtxt"><b>More Profiles...</b></a></td></tr>';
				echo '</table></td></tr>';
			}//if
		}//if
		else
		{
			$funDisplay	.= '<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center">';
			$funDisplay .= '<tr><td align="center" class="errorMsg"><br>'.$errMessages['Zero_Result'].'<br></td></tr>';
			echo $funDisplay .= '</table>';

		}//else		return $funDisplay;
	}//listMuslimGenSearchResultWithPhoto
	#------------------------------------------------------------------------------------------------------------
	function getpaymenthrs($dateCreated)
	{
		$endtime=time();
		// the start time can change to =strtotime($endtime);
		$starttime=strtotime($dateCreated);
		//$endtime can be any format as well as it can be converted to secs

		$timediff = $endtime-$starttime;
		   $days=intval($timediff/86400);
		   $remain=$timediff%86400;
		   $hours=intval($remain/3600);
		   $remain=$remain%3600;
		   $mins=intval($remain/60);
		   $secs=$remain%60;

		//this code is copied from the other note!thx to that guy!
		if($days==0 && $hours < 12)
			$retvalue = 'yes';
		else
			$retvalue = 'no';
		return $retvalue;
	}
	#------------------------------------------------------------------------------------------------------------
	function updateProfileViewedCount($argMatriId)
	{
		$funQuery		= "UPDATE memberinfo SET Profile_Viewed = (Profile_Viewed + 1) WHERE MatriId='".$argMatriId."'";
		//print "<br><br>".$funQuery;
		$funArrQuery	= mysql_query($funQuery);
		return true;
	}//updateProfileViewedCount
	#------------------------------------------------------------------------------------------------------------
	//CHECK PAID MEMBERS VALID DAYS
	function dateDiff($argDateSeparator, $argCurrentDate, $argPaidDate)
	{
		$VarArrPaidDate		= explode($argDateSeparator, $argPaidDate);
		$VarArrCurrentDate	= explode($argDateSeparator, $argCurrentDate);
		$VarStartDate		= gregoriantojd($VarArrPaidDate[0], $VarArrPaidDate[1], $VarArrPaidDate[2]);
		$VarEndDate			= gregoriantojd($VarArrCurrentDate[0], $VarArrCurrentDate[1], $VarArrCurrentDate[2]);
		return $VarEndDate - $VarStartDate;

	}//dateDiff
	#------------------------------------------------------------------------------------------------------------
	//DISPLAY Email
	function getGender($argMatriId)
	{
		$funQuery		= "SELECT Gender FROM memberinfo WHERE MatriId='".$argMatriId."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["Gender"];
	}//getUsername
	#------------------------------------------------------------------------------------------------------------
	//DISPLAY Email
	function getUsername($argMatriId)
	{
		$funQuery		= "SELECT User_Name FROM memberinfo WHERE MatriId='".$argMatriId."'";
		$funArrQuery	= mysql_query($funQuery);
		$funResult		= mysql_fetch_array($funArrQuery);
		return $funResult["User_Name"];
	}//getUsername
	#------------------------------------------------------------------------------------------------------------
	//LIST THE SELECTED RECORDS
	function listMyMessage($argFile)
	{
		global $mod,$act;
		
		$funQuery 			= "";
		$funDisplay 		= "";
		$funNumOfFields 	= count($this->clsFields);
		$funFieldsToDisplay = count($this->clsFieldsToDisplay);
		$funNumOfOrderBy	= count($this->clsOrderBy);
		$funPrimary			= count($this->clsPrimary);
		
		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for

		$funQuery .= " FROM ".$this->clsTable." as eii WHERE "; //eii.".$this->clsMemberYouContacted."=memberinfo.MatriId AND ";
		
		for($i=0;$i<$funPrimary;$i++)
		{
			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if ($i==$this->clsPrimaryGroupStart){ $funQuery .= "("; }//if
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i]."=".$funPrimaryValue; }//else
			if ($i==$this->clsPrimaryGroupEnd) $funQuery .= ")";
		}//for
		
		if($funNumOfOrderBy > 0)
		{
			$funQuery  .= " ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1))
				{
					$funQuery   .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; 
				}//if
				else
				{
					$funQuery   .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; 
				}//else
			}//for
		}//if
		$funQuery	.= " LIMIT ".$this->clsStart.",".$this->clsLimit;
		
		
		//print "<br><br>".$funQuery;
		$this->displayThumbnailMyMessages($funQuery, $funFieldsToDisplay, $funNumOfFields,$argFile);
		
	}//listMyMessage
	#------------------------------------------------------------------------------------------------------------
	//DISPLAY RESULTS
	function displayThumbnailMyMessages($funQuery,$argActionDate,$argActionStatus,$argFile)
	{
		global $mod,$act;
		//print"<br><br>$funQuery";
		$funNumOfPlaceHolders	= count($this->clsPlaceHolders);
		$resQuery				= mysql_query($funQuery);
		$funNumOfRows			= mysql_num_rows($resQuery);
		$funArrResultSet		= array();
		$funArrListMatriIds		= '';
		$funArrPhotoMatriIds	= '';
		$funRepeatedMatriIds	= array(); 
		$funMsgFile				= $argFile;
		if($funNumOfRows > 0)
		{
			$funFlag = 0;
			$j = 0;
			while($row = mysql_fetch_object($resQuery))
			{
				//FOR AVOIDING REPEATED MatriIds
				if(!in_array($row->Exp_MatriId,$funRepeatedMatriIds))
				{
					$funRepeatedMatriIds[] = $row->Exp_MatriId;
				}//if

				//CHECK WEB PAGE NAME(messaage-sent / message-recived)
				$funArrResultSet[$j]['MatriId']			= $row->Exp_MatriId;
				$funArrResultSet[$j]['Date_Updated']	= $row->Exp_Date_Updated;
				
				if($funMsgFile=='MS' || $funMsgFile=='MR')
				{
					$funArrResultSet[$j]['Mail_Id']			= $row->Mail_Id;
					$funArrResultSet[$j]['InterestMessage']	= $row->InterestMessage;
					$funArrResultSet[$j]['Date_Read']		= $row->Date_Read;
					$funArrResultSet[$j]['Date_Declined']	= $row->Date_Declined;
					$funArrResultSet[$j]['Date_Deleted']	= $row->Date_Deleted;
					$funArrResultSet[$j]['Notes']			= $row->Notes;
				}//if
				else
				{
					$funArrResultSet[$j]['Interest_Id']		= $row->Interest_Id;
					$funArrResultSet[$j]['Interest_Option']	= $row->Interest_Option;
					$funArrResultSet[$j]['Declined_Option']	= $row->Declined_Option;
					$funArrResultSet[$j]['Date_Accepted']	= $row->Date_Accepted;
				}//else
			$j++;
			}//while

			$funMatriIdsList = '';
			foreach($funRepeatedMatriIds as $funSingleId)
			{
				$funMatriIdsList .= "'".$funSingleId."',";
			}
			$funMatriIdsList = chop($funMatriIdsList,',');
			
			$funQuery	= 'SELECT MatriId, Age, Religion, Country, Last_Login, Height, Height_Unit, Country,Residing_State, Subcaste, About_Myself, Education_Category,Education_Detail,Occupation, Occupation_Detail, User_Name As Username, IF (Photo_Set_Status=1,IF (Protect_Photo_Set_Status=1,2,1),0) AS Photo, Publish FROM memberinfo WHERE MatriId IN ('.$funMatriIdsList.')';
			//print"<br><br>$funQuery";
			$resQuery	= mysql_query($funQuery);
			
			$funAvailableIds = array();
			while($row = mysql_fetch_object($resQuery))
			{
				if($row->Publish == 1 || $row->Publish == 0)
				{
					if($row->Photo == 1)
					{
						$funArrPhotoMatriIds .= "'".$row->MatriId."', ";
					}
					$funArrListMatriIds	.= "'".$row->MatriId."', ";	
				}//if

				$funAvailableIds[]= $row->MatriId;
				$funArrInfo[$row->MatriId]['MatriId']		= $row->MatriId;
				$funArrInfo[$row->MatriId]['Age']			= $row->Age;				$funArrInfo[$row->MatriId]['Religion']		= $row->Religion;
				$funArrInfo[$row->MatriId]['Country']		= $row->Country;
				$funArrInfo[$row->MatriId]['Last_Login']	= $row->Last_Login;
				$funArrInfo[$row->MatriId]['Height']		= $row->Height.'~'.$row->Height_Unit;
				$funArrInfo[$row->MatriId]['Residing_City'] = $row->Country.'~'.$row->Residing_State;
				$funArrInfo[$row->MatriId]['Subcaste']		= $row->Subcaste;
				$funArrInfo[$row->MatriId]['About_Myself']	= $row->About_Myself;
				$funArrInfo[$row->MatriId]['Education_Category']	= 																				$row->Education_Category.'~'.$row->Education_Detail;
				$funArrInfo[$row->MatriId]['Occupation']	= $row->Occupation.'~'.$row->Occupation_Detail;
				$funArrInfo[$row->MatriId]['Username']		= $row->Username;
				$funArrInfo[$row->MatriId]['Photo']			= $row->Photo;
				$funArrInfo[$row->MatriId]['Publish']		= $row->Publish;
			}//while

			$funMissedIds	= array_diff($funRepeatedMatriIds ,$funAvailableIds);
	
			if(count($funMissedIds) > 0)
			{
				$funMissedList = '';
				foreach($funMissedIds	as $funSingleMissedId)
				{
					$funMissedList = "'".$funSingleMissedId."',";
				}//foreach
				$funMissedList = chop($funMissedList,',');
				
				$funQuery	= 'SELECT MatriId,User_Name FROM memberdeletedinfo WHERE MatriId IN ('. $funMissedList.')';
				//print"<br><br>".$funQuery;
				$resQuery	= mysql_query($funQuery);
				
				while($row = mysql_fetch_object($resQuery))
				{
					$funArrInfo[$row->MatriId]['Publish']	= ''; 
					$funArrInfo[$row->MatriId]['User_Name']	= $row->User_Name;
					$funArrInfo[$row->MatriId]['MatriId']	= $row->MatriId; 
				}
			}//if

			$funTotalNoOfRecs	= count($funArrResultSet);
			
			for($kk=0 ;$kk<$funTotalNoOfRecs; $kk++)
			{
				$funMatriId	= $funArrResultSet[$kk]['MatriId'];
				
				if($funMatriId == $funArrInfo[$funMatriId]['MatriId'])
				{
				$funArrResultSet[$kk]['Age']			= $funArrInfo[$funMatriId]['Age'];
				$funArrResultSet[$kk]['Religion']		= $funArrInfo[$funMatriId]['Religion'];
				$funArrResultSet[$kk]['Country']		= $funArrInfo[$funMatriId]['Country'];
				$funArrResultSet[$kk]['Last_Login']		= $funArrInfo[$funMatriId]['Last_Login'];
				$funArrResultSet[$kk]['Height']			= $funArrInfo[$funMatriId]['Height'];
				$funArrResultSet[$kk]['Residing_City']	= $funArrInfo[$funMatriId]['Residing_City'];
				$funArrResultSet[$kk]['Subcaste']		= $funArrInfo[$funMatriId]['Subcaste'];
				$funArrResultSet[$kk]['About_Myself']	= $funArrInfo[$funMatriId]['About_Myself'];
				$funArrResultSet[$kk]['Education_Category']	= $funArrInfo[$funMatriId]['Education_Category'];
				$funArrResultSet[$kk]['Occupation']		= $funArrInfo[$funMatriId]['Occupation'];
				$funArrResultSet[$kk]['Username']		= $funArrInfo[$funMatriId]['Username'];
				$funArrResultSet[$kk]['Photo']			= $funArrInfo[$funMatriId]['Photo'];
				$funArrResultSet[$kk]['Publish']		= $funArrInfo[$funMatriId]['Publish'];
				}//if
			}//for
		
			$funRepeatedMatriIds	= array();
			$funArrPhotoMatriIds	= chop($funArrPhotoMatriIds,", ");
			$funArrListMatriIds		= chop($funArrListMatriIds,", ");
			
			//SELECT PHOTO
			if ($funArrPhotoMatriIds !="")
			{
				$funPhotoQuery			= 'SELECT MatriId, Normal_Photo1, Photo_Status1, Normal_Photo2, Photo_Status2, Normal_Photo3, Photo_Status3 FROM memberphotoinfo WHERE MatriId IN('.$funArrPhotoMatriIds.')';
				//print "<br><br>".$funPhotoQuery;//exit;
				$funExecute	= mysql_query($funPhotoQuery);
				$jj=0;
				while($funPhotoResultset = mysql_fetch_assoc($funExecute))
				{
					$this->clsArrPhotoResultSet[$jj]["MatriId"]			= $funPhotoResultset["MatriId"];
					$this->clsArrPhotoResultSet[$jj]["Normal_Photo1"]	= $funPhotoResultset["Normal_Photo1"];
					$this->clsArrPhotoResultSet[$jj]["Photo_Status1"]	= $funPhotoResultset["Photo_Status1"];
					$this->clsArrPhotoResultSet[$jj]["Normal_Photo2"]	= $funPhotoResultset["Normal_Photo2"];
					$this->clsArrPhotoResultSet[$jj]["Photo_Status2"]	= $funPhotoResultset["Photo_Status2"];
					$this->clsArrPhotoResultSet[$jj]["Normal_Photo3"]	= $funPhotoResultset["Normal_Photo3"];
					$this->clsArrPhotoResultSet[$jj]["Photo_Status3"]	= $funPhotoResultset["Photo_Status3"];
					$jj++;
				}
			}//if

			//SELECT PHOTO
			if ($funArrListMatriIds !="" && $this->clsSessionMatriId !="")
			{
				$funListQuery			= "SELECT Opposite_MatriId,Bookmarked,Ignored,Blocked FROM memberactioninfo WHERE MatriId='".$this->clsSessionMatriId."'  AND Opposite_MatriId IN(".$funArrListMatriIds.")";
				//print "<br><br>".$funListQuery;//exit;
				$funExecute	= mysql_query($funListQuery);
				$jj=0;
				while ($funListResultSet	= mysql_fetch_assoc($funExecute))
				{
					$this->clsArrListResultSet[$jj]["Bookmarked"]	= $funListResultSet["Bookmarked"];
					$this->clsArrListResultSet[$jj]["Ignored"]		= $funListResultSet["Ignored"];
					$this->clsArrListResultSet[$jj]["Blocked"]		= $funListResultSet["Blocked"];
					$this->clsArrListResultSet[$jj]["Opposite_MatriId"]	= $funListResultSet["Opposite_MatriId"];
					$jj++;
				}
				
			}//if
									
			for($k=0; $k<$j; $k++)
			{
				if($funArrResultSet[$k]['Publish'] == 1 || $funArrResultSet[$k]['Publish'] == '0')
				{
					$funTemplateXerox = $this->clsListTemplate;

					for($i=0;$i<$funNumOfPlaceHolders;$i++)
					{
						if(in_array($this->clsPlaceHoldersValues[$i], $this->clsTextConversion))
						{
							$funPlaceHolderValue = $this->clsPlaceHoldersValues[$i];
							$funValue = $this->getActualValueFromArrayMsgs($this->clsPlaceHolders[$i], $funArrResultSet[$k][$funPlaceHolderValue],$funMsgFile); }//if
						else
						{ 
							$funValue = $funArrResultSet[$k][$funPlaceHolderValue]; 
						}//else
						
						$funTemplateXerox = str_replace($this->clsPlaceHolders[$i], $funValue, $funTemplateXerox);
					}//for
					$funTemplateXerox = str_replace('<--ACTION-STATUS-->',$argActionStatus, $funTemplateXerox);
					$funTemplateXerox = str_replace('<--ACTION-DATE-->', $argActionDate, $funTemplateXerox);
					if ($this->clsDisplayFormat=='T')
					{
						if($act != 'my-matrimony')
						{
							if ($funFlag%2==0)
							{
								echo "<tr><td width='50%'>".$funTemplateXerox."</td>";
								if ($funNumOfRows==1){ echo '</tr><tr><td colspan="2">&nbsp;</td></tr>';}
							}//if
							else
							{
								echo "<tr><td width='50%'>".$funTemplateXerox."</td></tr><tr><td colspan='2'>&nbsp;</td></tr>";
							}//else
						}//if
						else
						{
							if ($funFlag%2==0)
							{
								echo $funTemplateXerox;
							}//if
							else
							{
								echo $funTemplateXerox;
							}//else
						}
					}//if
					if ($this->clsDisplayFormat=='B')
					{ echo "<tr><td>".$funTemplateXerox."</td></tr><tr><td>&nbsp;</td></tr>"; }//if
				}//if
				elseif($funArrResultSet[$k]['Publish'] == 2 || $funArrResultSet[$k]['Publish'] == 3 || $funArrResultSet[$k]['Publish'] == '' || $funArrResultSet[$k]['Publish'] == 4)
				{
					echo "<tr><td>";
					$funHiddenMatriId		= $funArrResultSet[$k]['MatriId'];
					if( $funArrResultSet[$k]['Interest_Id'] == '')
					{
						$funContactId	= $funArrResultSet[$k]['Mail_Id']; 
					}
					else
					{
						$funContactId	= $funArrResultSet[$k]['Interest_Id'];
					}

					$funHideProfileInfo1	= $this->getContentFromFile('templates/hide-profile.tpl');
					$funHideProfileInfo2	= str_replace("<--CHECKBOX-NAME-->",$this->clsCheckBoxName,$funHideProfileInfo1);
					
					if($this->clsFilename == 'yes')
					{
						$funHideProfileInfo3 = str_replace("<--CONTACT-ID-->",'',$funHideProfileInfo2);
					}
					else
					{
						$funHideProfileInfo3 = str_replace("<--CONTACT-ID-->",$funContactId,$funHideProfileInfo2);
					}
					$funHideProfile4 = str_replace("<--DELETE-LINK-->","javascript:funDeleteSingleRecord('".$funContactId."');", $funHideProfileInfo3);
					$funHideProfile5 = str_replace("<--MESSAGE-TEXT-->",$this->clsCommandsText,$funHideProfile4);
					if ($funArrResultSet[$k]['Publish'] == 2)
					{
						$funDisplaycText	= "hidden";
						$funHiddenUsername	= $funArrResultSet[$k]['Username'];
					}//if
					elseif($funArrResultSet[$k]['Publish'] == 3)
					{
						$funDisplaycText	= "suspended";
						$funHiddenUsername	= $funArrResultSet[$k]['Username']; 
					}//else
					elseif($funArrResultSet[$k]['Publish'] == 4)
					{
						$funDisplaycText	= "rejected";
						$funHiddenUsername	= $funArrResultSet[$k]['Username']; 
					}//else
					else
					{
						$funDisplaycText	= "deleted";
						$funHiddenUsername	= $funArrResultSet[$k]['Username'];
					}//if

					$funHideProfile7 = str_replace("<--USERNAME-->",$funHiddenUsername,$funHideProfile5);
					$funHideProfile8 = str_replace("<--MESSAGE-->",'',$funHideProfile7);
					$funHideProfile9 = str_replace("<--DISPLAY-TEXT-->",$funDisplaycText,$funHideProfile8);
					echo $funHideProfile9;
					echo "</td></tr><tr><td>&nbsp;</td></tr>";

				}//elseif
			}//for
		}//if
		//echo '<br>';
	}//displayThumbnailMyMessages
	#----------------------------------------------------------------------------------------------------------
	//LIST THE SELECTED RECORDS
	function listMail($argStatus)
	{
		global $mod,$act;
		
		$funQuery 			= "";
		$funDisplay 		= "";
		$funNumOfFields 		= count($this->clsFields);
		$funFieldsToDisplay 	= count($this->clsFieldsToDisplay);
		$funNumOfOrderBy		= count($this->clsOrderBy);
		$funPrimary				= count($this->clsPrimary);

		$funQuery .= "SELECT ";
		for($i=0;$i<$funNumOfFields;$i++)
		{
			if($i<($funNumOfFields-1)){ $funQuery .= $this->clsFields[$i].", "; }//if
			else{ $funQuery .= $this->clsFields[$i]." "; }//else
		}//for

		$funQuery .= " FROM mailreceivedinfo WHERE ";

		for($i=0;$i<$funPrimary;$i++)
		{

			$funPrimaryValue	= $this->clsPrimaryValue[$i];
			$funPrimaryValue	= is_numeric($funPrimaryValue) ? $funPrimaryValue : "'".$funPrimaryValue."'";

			if ($i==$this->clsPrimaryGroupStart){ $funQuery .= "("; }//if
			if($i<($funPrimary-1))
			{ $funQuery .= $this->clsPrimary[$i].$this->clsPrimarySymbol[$i].$funPrimaryValue." ".$this->clsPrimaryKey[$i]." "; }//if
			else{ $funQuery .= $this->clsPrimary[$i].$this->clsPrimarySymbol[$i].$funPrimaryValue; }//else
			if ($i==$this->clsPrimaryGroupEnd) $funQuery .= ")";
		}//for
		
		if($funNumOfOrderBy > 0)
		{
			$funQuery .= " ORDER BY ";
			for($i=0;$i<$funNumOfOrderBy;$i++)
			{
				if($i<($funNumOfOrderBy-1)){ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i].", "; }//if
				else{ $funQuery .= $this->clsOrderBy[$i]." ".$this->clsOrder[$i]." "; }//else
			}//for
		}//if
		$funQuery .= "LIMIT ".$this->clsStart.",".$this->clsLimit;
		
		//print "<br><br>".$funQuery;
		
		$resQuery		= mysql_query($funQuery);
		$funNumOfRows	= mysql_num_rows($resQuery);
		
		if($argStatus==0)
			$funDisplay		.= '<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#FFFFFF">';
		else
			$funDisplay		.= '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';

		
		if($funNumOfRows > 0)
		{
			$funRecordNo	= 0; 
			$funMsgResult	= '';
			$funMatriIdsList= '';
			$funArrMatriIds = array();
			while($row = mysql_fetch_object($resQuery))
			{
				$funMsgResult[$funRecordNo]['Mail_Follow_Up']	= $row->Mail_Follow_Up;
				$funMsgResult[$funRecordNo]['Mail_Id']			= $row->Mail_Id;
				$funMsgResult[$funRecordNo]['Opposite_MatriId']	= $row->Opposite_MatriId;
				$funMsgResult[$funRecordNo]['Mail_Message']		= $row->Mail_Message;
				$funMsgResult[$funRecordNo]['Date_Received']	= $row->Date_Received;

				if(!in_array($row->Opposite_MatriId,$funArrMatriIds))
				{
					$funArrMatriIds[]	= $row->Opposite_MatriId;
					//MatriIds List For Get Username
					$funMatriIdsList   .= "'".$row->Opposite_MatriId."',";
				}
				$funRecordNo++;
			}
			
			$funMatriIdsList = chop($funMatriIdsList,",");
			
			// Get User_Name From memberlogininfo Query
			$funMLIQuery	 = 'SELECT MatriId,User_Name FROM memberlogininfo WHERE MatriId 																		IN('.$funMatriIdsList.')'; 
			//print"<br><br>$funMLIQuery";
			$funMLIResult	= mysql_query($funMLIQuery);
			$funMLIUsername	= array();
			
			while($row = mysql_fetch_assoc($funMLIResult))
			{
				$funMLIUsername[$row['MatriId']]['User_Name'] = $row['User_Name'];
			}
			
			if(count($funArrMatriIds) != count($funMLIUsername))
			{
				//Get User_Name From memberdeletedinfo Query
				$funMDIQuery	 = 'SELECT MatriId,User_Name FROM memberdeletedinfo WHERE MatriId 																		IN('.$funMatriIdsList.')'; 
				//print"<br><br>$funMDIQuery";
				$funMDIResult	 = mysql_query($funMDIQuery);
				$funMDIUsername	 = array();
				
				while($row = mysql_fetch_assoc($funMDIResult))
				{
					$funMDIUsername[$row['MatriId']]['User_Name'] = $row['User_Name'];
				}
				$funMLIUsername	= array_merge($funMLIUsername, $funMDIUsername);
			}

			for($i=0; $i<$funNumOfRows; $i++)
			{
				if($argStatus==0)
					$funDisplay .= '<tr class="resultBgColorOdd">';
				else
					$funDisplay .= '<tr class="resultBgColorEven">';
				
				$funDisplay .= '<td align="left" width="40"><input type="checkbox" name="searchResults" value="'.$funMsgResult[$i]['Mail_Id'].'">';

				if ($funMsgResult[$i]['Mail_Follow_Up']==1){ $funDisplay .= '<img src="images/in-flag.gif" border="0">'; }//if
				$funDisplay .= '</td>';
				
				$funUsername = $funMLIUsername[$funMsgResult[$i]['Opposite_MatriId']]['User_Name'];

				if($row->Redirect_To != ""){ $funLink = '&nbsp;<a href="http://'.$row->Redirect_To; }//if
				else
				{
				$funLink = '&nbsp;<a href="../search/index.php?act=profile-view&matrimonyId='.$funMsgResult[$i]['Opposite_MatriId']; 
				$funLink1= "&nbsp;<a href=\"javascript:funDisplayMailMessageFace('".$funMsgResult[$i]['Mail_Id']."','". $funUsername."','".$this->clsDisplayMsgFlag."');\"";
				$funLink1.= ' class="navlinktxt1">';
				}//else
				$funLink .= '" class="navlinktxt1" target="_blank">';

				
				$funMsgResult[$i]['Mail_Message'] = strip_tags($funMsgResult[$i]['Mail_Message']);
				
				if(strlen($funMsgResult[$i]['Mail_Message'])>40)
				{
					$funCovertedMessage = substr($funMsgResult[$i]['Mail_Message'],0,40)."...";
				}
				else
				{
					$funCovertedMessage = $funMsgResult[$i]['Mail_Message']."...";
				}

				$funDisplay .= '<td width="100" class="grtxt">'.$funLink.$funUsername.'</a></td><td width="280" class="grtxt" align="left">'.$funLink1.$funCovertedMessage.'</a></td><td width="150" class="grtxt" align="center">'.date("d-M-Y", strtotime($funMsgResult[$i]['Date_Received'])).'</td>';
					
				$funDisplay .= '</tr>';
				
				if($argStatus!=0)
					$funDisplay .= '<tr><td class="grebg3" height="1" colspan="'.($funNumOfFields+1).'"></td></tr>';
				$j++;
			}//for
			$funDisplay .= '</table>';
		}//if
		else
		{
			$funDisplay	= "no";
		}//else

		$retDisplay = $funDisplay;
		
		return $retDisplay;
		
	}//listMail
	#----------------------------------------------------------------------------------------------------------
	//GENERATE OPTIONS FOR SELECTION/LIST BOX FROM AN ARRAY
	function sendEmail($argFrom,$argFromEmailAddress,$argTo,$argToEmailAddress,$argSubject,$argMessage)
	{
		$funValue		= "";
		$funheaders		= "MIME-Version: 1.0\n";
		$funheaders		.= "Content-type: text/html; charset=iso-8859-1\n";
		$funheaders		.= "From:".$argFrom."<".$argFromEmailAddress.">\n";
		$argheaders		= $funheaders;
		
		if (mail($argToEmailAddress, $argSubject, $argMessage, $argheaders))
		{
			$funValue = 'yes';
		}

		$retValue = $funValue;

		return $retValue;	
	}
	#----------------------------------------------------------------------------------------------------------
}//QuickSearch
?>