<?php
require_once('header.php');
require_once('navinc.php');
//OBJECT DECLARATION
$objProductFacebook = new QuickSearch;

//VARIABLE DECLARTION
if($_REQUEST['page'] == ""){ ($_REQUEST['pg'] == "")? $pageNum = 1 : $pageNum = $_REQUEST['pg']; }//if
else{ $pageNum = $_REQUEST['page']; }//else

$objProductFacebook->clsLimit					= $confQuickSearch['Limit'];
$objProductFacebook->clsFields					= $confQuickSearch['Fields'];
$objProductFacebook->clsRequestPhotoImage		= $confSearch['RequestPhotoImage'];
$objProductFacebook->clsProtectedPhotoImage		= $confSearch['ProtectedPhotoImage'];
$objProductFacebook->clsPlaceHolders			= $confSearch['PlaceHolders'];
$objProductFacebook->clsPlaceHoldersValues		= $confSearch['PlaceHoldersValues'];
$objProductFacebook->clsTextConversion			= $confSearch['TextConversion'];
$objProductFacebook->clsOrderBy					= array('Date_Updated');
$objProductFacebook->clsStart					= ($pageNum-1) * $objProductFacebook->clsLimit;
$objProductFacebook->clsServerURL				= $confServerURL;
$objProductFacebook->clsSessionMatriId			= $sessMatriId;
$objProductFacebook->clsPaidStatus				= $sessPaidStatus;
$objProductFacebook->clsSessionGender			= $sessGender;
$varSaveName									= trim($_REQUEST["saveName"]);
$varDonotShow									= $_REQUEST['donotShow'];
$varShowPhoto									= $_REQUEST['showPhoto'];
?>
<?php
	if($_REQUEST['starSearch']=='yes') {
		$varGender		= $_REQUEST['gender'];
		$varReligion	= $_REQUEST['religion'];
		$varCity		= $_REQUEST['city'];
		$varViewSimilarMatriId	=	$_REQUEST['viewSimilarMatriId'];
		$varpage		= $_REQUEST['page'];
		if($varGender != "")
		{
			$varPrimary[]			= 'Gender';
			$varPrimarySymbol[]		= '=';
			$varPrimaryValue[]		= $varGender;
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]		= 'AND';
		}//if
		if($varReligion != "")
		{
			$varArrReligion			= $varReligion;
			if (!is_array($varArrReligion))
			{ 
				if (strpos($varArrReligion, "~") === false){ $varArrReligion	= array($varArrReligion); }//if
				else{ $varArrReligion	= explode("~",$varArrReligion); }//else
			}
			$varArrayReligionList		= $objProductFacebook->generateArrayFromFormValues($varArrReligion);// 
			if ($varArrayReligionList !="")
			{
				$varPrimary[]			= 'Religion';
				$varPrimarySymbol[]		= '=';
				$varPrimaryValue[]		= $varArrReligion; //returns array
				$varPrimaryValueIsArr[] = "yes";
				$varPrimaryKey[]		= 'AND';
			}//if
		}//if
		if($varCity != "")
		{
			$varPrimary[]				= 'Residing_State';// Modify to State *ND (20061209)
			$varPrimarySymbol[]			= '=';
			$varPrimaryValue[]			= $varCity;// for view similar profiles
			$varPrimaryValueIsArr[]		= "no";
			$varPrimaryKey[]			= 'AND';
		}
		$objProductFacebook->clsPrimaryValue		= $varPrimaryValue;
		$objProductFacebook->clsPrimary				= $varPrimary;
		$objProductFacebook->clsPrimaryKey			= $varPrimaryKey;
		$objProductFacebook->clsPrimarySymbol		= $varPrimarySymbol;
		$objProductFacebook->clsPrimaryValueIsArr	= $varPrimaryValueIsArr;
		
	} else {	
		$varGender		= $_REQUEST['gender'];
		$varReligion	= $_REQUEST['religion'];
		$varAgeFrom		= $_REQUEST['fromAge']?$_REQUEST['fromAge']:$_REQUEST['ageFrom'];
		$varAgeTo		= $_REQUEST['toAge']?$_REQUEST['toAge']:$_REQUEST['ageTo'];
		$varPhoto		= $_REQUEST['profilePhoto'];
		$varCountry		= $_REQUEST['country'];
		$varpage		= $_REQUEST['page'];

		if($varGender != "")
		{
			$varPrimary[]			= 'Gender';
			$varPrimarySymbol[]		= '=';
			$varPrimaryValue[]		= $varGender;
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]		= 'AND';
		}//if
		if($_REQUEST['maritalStatus'] != "" && $_REQUEST['maritalStatus'] != "~")
		{
			$varMaritalStatus		= substr($_REQUEST['maritalStatus'], 0, -1);
			$varPrimary[]			= 'Marital_Status';
			$varPrimarySymbol[]		= '=';
			$varPrimaryValue[]		= split("~",$varMaritalStatus);
			$varPrimaryValueIsArr[] = "yes"; //returns array
			$varPrimaryKey[]		= 'AND';
		}//if
		if($varAgeFrom != "")
		{
			$varPrimary[]			= 'Age';
			$varPrimarySymbol[]		= '>=';
			$varPrimaryValue[]		= $varAgeFrom;
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]		= 'AND';	
			$varPrimary[]			= 'Age';
			$varPrimarySymbol[]		= '<=';
			$varPrimaryValue[]		= $varAgeTo;
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]		= 'AND';
		}//if
		if($_REQUEST['heightFrom'] != "")
		{
			$varPrimary[]			= 'Height';
			$varPrimarySymbol[]		= '>=';
			$varPrimaryValue[]		= floor($_REQUEST['heightFrom']);
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]		= 'AND';	
			$varPrimary[]			= 'Height';
			$varPrimarySymbol[]		= '<=';
			$varPrimaryValue[]		= ceil($_REQUEST['heightTo']);
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]		= 'AND';
		}//if
		if($_REQUEST['motherTongue'] != "")
		{
			$varArrMotherTongue		= $_REQUEST['motherTongue'];
			if (!is_array($varArrMotherTongue))
			{ 
				if (strpos($varArrMotherTongue, "~") === false)
				{ $varArrMotherTongue = array($varArrMotherTongue); }//if
				else
				{ $varArrMotherTongue = explode("~",$varArrMotherTongue); }//else
			}
			$varArrayMotherTongueList = $objProductFacebook->generateArrayFromFormValues($varArrMotherTongue);
			if ($varArrayMotherTongueList !="")
			{
				$varPrimary[]			= 'Mother_Tongue';
				$varPrimarySymbol[]		= '=';
				$varPrimaryValue[]		= $varArrMotherTongue;
				$varPrimaryValueIsArr[] = "yes"; //returns array
				$varPrimaryKey[]		= 'AND';
			}//if
		}//if
		if($varReligion != "")
		{
			$varArrReligion = $varReligion;
			if (!is_array($varArrReligion))
			{ 
				if (strpos($varArrReligion, "~") === false)
				{ $varArrReligion = array($varArrReligion); }//if
				else
				{ $varArrReligion = explode("~",$varArrReligion); }//else
			}
			$varArrayReligionList = $objProductFacebook->generateArrayFromFormValues($varArrReligion);
			if ($varArrayReligionList !="")
			{
				$varPrimary[]		= 'Religion';
				$varPrimarySymbol[] = '=';
				$varPrimaryValue[]	= $varArrReligion;
				$varPrimaryValueIsArr[] = "yes"; //returns array
				$varPrimaryKey[]	= 'AND';
			}//if
		}//if
		if($_REQUEST['caste'] != "")
		{
			$varArrCaste = $_REQUEST['caste'];
			if (!is_array($varArrCaste))
			{ 
				if (strpos($varArrCaste, "~") === false)
				{ $varArrCaste = array($varArrCaste); }//if
				else
				{ $varArrCaste = explode("~",$varArrCaste); }//else
			}
			$varArrayCasteList = $objProductFacebook->generateArrayFromFormValues($varArrCaste);
			if ($varArrayCasteList !="")
			{
				$varPrimary[]		= 'Subcaste'; //returns array
				$varPrimarySymbol[] = '=';
				$varPrimaryValue[]	= $varArrCaste;
				$varPrimaryValueIsArr[] = "yes";
				$varPrimaryKey[]	= 'AND';
			}//if
		}//if
		if($_REQUEST['education'] != ""  && $_REQUEST['education'] !=0)
		{
			$varArrEducation = $_REQUEST['education'];
			if (!is_array($varArrEducation))
			{ 
				if (strpos($varArrEducation, "~") === false)
				{ $varArrEducation = array($varArrEducation); }//if
				else
				{ $varArrEducation = explode("~",$varArrEducation); }//else
			}
			$varArrayEducationList = $objProductFacebook->generateArrayFromFormValues($varArrEducation);
			if ($varArrayEducationList !="")
			{
				$varPrimary[]		= 'Education_Category'; //returns array
				$varPrimarySymbol[] = '=';
				$varPrimaryValue[]	= $varArrEducation;
				$varPrimaryValueIsArr[] = "yes";
				$varPrimaryKey[]	= 'AND';
			}//if
		}//if
		if($_REQUEST['citizenship'] != "")
		{
			$varArrCitizenship = $_REQUEST['citizenship'];
			if (!is_array($varArrCitizenship))
			{ 
				if (strpos($varArrCitizenship, "~") === false)
				{ $varArrCitizenship = array($varArrCitizenship); }//if
				else
				{ $varArrCitizenship = explode("~",$varArrCitizenship); }//else
			}
			$varArrayCitizenshipList = $objProductFacebook->generateArrayFromFormValues($varArrCitizenship);
			if ($varArrayCitizenshipList  !="")
			{
				$varPrimary[]		= 'Citizenship'; //returns array
				$varPrimarySymbol[] = '=';
				$varPrimaryValue[]	= $varArrCitizenship;
				$varPrimaryValueIsArr[] = "yes";
				$varPrimaryKey[]	= 'AND';
			}//if
		}//if
		if($varCountry != "")
		{
			$varArrCountry = $varCountry;
			if (!is_array($varArrCountry))
			{ 
				if (strpos($varArrCountry, "~") === false)
				{ $varArrCountry = array($varArrCountry); }//if
				else
				{ $varArrCountry = explode("~",$varArrCountry); }//else
			}
			$varArrayCountryList = $objProductFacebook->generateArrayFromFormValues($varArrCountry);
			if ($varArrayCountryList !="")
			{
				$varPrimary[]		= 'Country'; //returns array
				$varPrimarySymbol[] = '=';
				$varPrimaryValue[]	= $varArrCountry;
				$varPrimaryValueIsArr[] = "yes";
				$varPrimaryKey[]	= 'AND';
			}//if
		}//if

		//echo 'gender::'.$varGender.'Religion::'.$varReligion.'AgeFrom::'.$varAgeFrom.'AgeTo::'.$varAgeTo.'Photo::'.$varPhoto.'Country::'.$varCountry.'Page::'.$varpage; 
		if($_REQUEST["postedOn"] != "" && $_REQUEST["postedYear"] !="" && $_REQUEST["postedMonth"] !="" && $_REQUEST["postedDay"] !="")
		{
			$varPostedOn		= $_REQUEST["postedYear"]."-".$_REQUEST["postedMonth"]."-".$_REQUEST["postedDay"];
			$varPrimary[]		= "Date_Created";
			$varPrimarySymbol[] = '>';
			$varPrimaryValue[]	= $varPostedOn.' 23:59:59';
			$varPrimaryValueIsArr[] = "no";
			$varPrimaryKey[]	= 'AND';
		}//if

		if ($varShowPhoto[0]==1  || $_REQUEST['displayFormat']=='P' || $varPhoto == 1)
		{
			$varPrimary[]		= 'Photo_Set_Status'; //returns array
			$varPrimarySymbol[] = '=';
			$varPrimaryValue[]	= 1;
			$varPrimaryValueIsArr[] = "1";
			$varPrimaryKey[]	= 'AND';
		}//if


		if($_REQUEST['searchBy'] != "")
		{
			$varSearchBy = $_REQUEST['searchBy'];
			if ($varSearchBy == 1) { $varOrderBy = 'memberbasicinfo.Date_Updated'; }//if
			else if ($varSearchBy == 2){ $varOrderBy = 'mli.Date_Created'; }//else if
			else{  $varOrderBy = 'mli.Last_Login'; }//else
			$objRegularSearch->clsOrderBy = array($varOrderBy);
		}//if

		//SAVE SEARCH
		if ($varSaveName !="" && $_REQUEST["savedSearchCount"] < 3 && $_REQUEST["frmSavedSearchSubmit"]=="yes")
		{
			$objProductFacebook->clsTable		= "searchsavedinfo";
			$objProductFacebook->clsCountField	= 'Search_Id';
			$varSavedId							= $_REQUEST["savedId"];
			$objProductFacebook->clsPrimary		= array('MatriId');
			$objProductFacebook->clsPrimaryValue	= array($sessMatriId);
			$varNumOfResults					= $objProductFacebook->numOfResults();

			$varArrayPhotoHoroscopeList			= $objProductFacebook->generateArrayFromFormValues($_REQUEST["showPhoto"]);
			$varArrayDonotShowList				= $objProductFacebook->generateArrayFromFormValues($_REQUEST["donotShow"]);
			if ($_REQUEST["postedOn"]==2)
			{ $varPostedOn = $_REQUEST["postedYear"]."-".$_REQUEST["postedMonth"]."-".$_REQUEST["postedDay"]; }//if
			else {$varPostedOn = "";}//else 
			$objProductFacebook->clsFields = array('MatriId','Search_Name','Gender','Marital_Status','Age_From','Age_To','Height_From','Height_To','Religion','Mother_Tongue','Caste_Or_Division','Education','Citizenship','Country','Posted_Date','Search_By','Show_Photo_Horoscope','Show_Ignore_AlreadyContact','Display_Format','Search_Type','Date_Updated');
			$objProductFacebook->clsFieldsValues = array($sessMatriId,$varSaveName,$_REQUEST["gender"],$varMaritalStatus,$_REQUEST["ageFrom"],$_REQUEST["ageTo"],$_REQUEST["heightFrom"],$_REQUEST["heightTo"],$varArrayReligionList,$varArrayMotherTongueList,$varArrayCasteList,$varArrayEducationList,$varArrayCitizenshipList,$varArrayCountryList,$varPostedOn,$_REQUEST['searchBy'],$varArrayPhotoHoroscopeList,$varArrayDonotShowList,$_REQUEST["displayFormat"],2,$varCurrentDate);
			if ($_REQUEST["frmAdvancedSearchEdit"]=="yes")
			{
				$varSavedId							= $_REQUEST["savedId"];
				$objProductFacebook->clsPrimary		= array('Search_Id');
				$objProductFacebook->clsPrimaryKey	= array('AND');
				$objProductFacebook->clsPrimaryValue	= array($varSavedId);
				$objProductFacebook->updateQuickSearch(); }//if
			else
			{
				if ($varNumOfResults < 3)
				{
					$objProductFacebook->clsPrimary		= array('MatriId','Search_Name');
					$objProductFacebook->clsPrimaryKey	= array('AND','AND');
					$objProductFacebook->clsPrimaryValue	= array($sessMatriId,$varSaveName);
					$varCheckSearchName					= $objProductFacebook->numOfResults();
					//echo $varCheckSearchName;exit;
					if ($varCheckSearchName==0) { $objProductFacebook->addQuickSearch(); }//if
					else { $varErrorMessage	= 'You have already saved with this name, Please try with different name.';}
				}
				else { $varErrorMessage	= 'You have reached the Maximum limit for saving search.';}
			}//else

			//Tracking File Call here
			echo '<script language="javascript" src="reset-search-cookie.php"></script>';
		}//if

		//concentrate on horoscope
		$objProductFacebook->clsPrimaryValue		= $varPrimaryValue;
		$objProductFacebook->clsPrimary			= $varPrimary;
		$objProductFacebook->clsPrimaryKey		= $varPrimaryKey;
		$objProductFacebook->clsPrimarySymbol	= $varPrimarySymbol;
		$objProductFacebook->clsPrimaryValueIsArr= $varPrimaryValueIsArr;
		$varDisplayFormat						= $_REQUEST['displayFormat'];
		$objProductFacebook->clsDisplayFormat	= $varDisplayFormat ? $varDisplayFormat : 'B';
		$varIgnoredProfile						= $varDonotShow[0] ? $varDonotShow[0] : $varDonotShow[1];
		$varContactedProfile					= $varDonotShow[1] ? $varDonotShow[1] : $varDonotShow[0];

		if($varIgnoredProfile == 1){ $objProductFacebook->clsIgnoredProfiles = "yes"; }//if
		if($varContactedProfile == 2){ $objProductFacebook->clsContactedProfiles = "yes"; }//if

		$varSearchFormValues				= "gen=".$varGender."&rel=".$varReligion."&afr=".$varAgeFrom."&ato=".$varAgeTo."&cou=".$varCountry."&pho=".$varPhoto;
	}//else

	$varNumOfResults							= $objProductFacebook->numOfResultsM1(); 
	$varCurrentPage								= $varpage;
	$varNumOfPages								= ceil($varNumOfResults/$objProductFacebook->clsLimit);
	//echo '$varNumOfResults::'.$varNumOfResults.'$varNumOfPages::'.$varNumOfPages.'$Limit::'.$objProductFacebook->clsLimit;

	//CHECK DISPLAY FORMAT
	if($objProductFacebook->clsDisplayFormat == 'B')
	{ $varTemplate = $objProductFacebook->getContentFromFile($confAdvancedSearch['ListTemplateBasic']); }//if
	else if($objProductFacebook->clsDisplayFormat == 'P')
	{ $varTemplate = $objProductFacebook->getContentFromFile($confAdvancedSearch['ListPhotoGallery']); }//if
	else{ $varTemplate = $objProductFacebook->getContentFromFile($confAdvancedSearch['ListTemplateThumbnail']); }//else
	$objProductFacebook->clsListTemplate	= $varTemplate;

?>
<script language="javascript" src="<?=$confServerURL?>/search/includes/search-results.js"></script>
<script language="javascript" src="<?=$confServerURL?>/includes/libAjaxForSearch.js"></script>

<script language="javascript">
	var argPlaceHolderId;
	var argPlaceHolderEnlargephotoId;
	var argPlaceHolderMemDetails;
	var argPlaceHolderMemDetailsDiv;
	var argPlaceHolderOrder;
	function funShowPhoto(argMatriId,argPhotoName)
	{
		var argPhotoSplit = argPhotoName.split("_");
		var argPhotoMatriId = argPhotoSplit[0].split("/");
		argPlaceHolderId="id"+argMatriId;
		document.getElementById(argPlaceHolderId).src = "<?php echo $confValues['PhotoReadURL'];?>/membersphoto/"+argPhotoName;
		argPlaceHolderOrder = "enlargephotodivid"+argMatriId;
		document.getElementById(argPlaceHolderOrder).innerHTML = "<img src='"+"<?php echo $confValues['PhotoReadURL'];?>/membersphoto/"+argPhotoSplit[0]+"_Thumb_Small_"+argPhotoSplit[2].toLowerCase()+"' style='padding:2px;width:150px;height:150px;' align='center'>";
	}//showPhoto
	function funFullPhotoDisplay(argMatriId)
	{
		argPlaceHolderEnlargephotoId = "enlargephotodivid"+argMatriId;
		document.getElementById(argPlaceHolderEnlargephotoId).style.display="block";
	}//showPhoto
	function funFullPhotoHide(argMatriId)
	{
		argPlaceHolderEnlargephotoId = "enlargephotodivid"+argMatriId;
		document.getElementById(argPlaceHolderEnlargephotoId).style.display="none";
	}//showPhoto
	
	function funMemInfoDisplay(argMatriId)
	{
		argPlaceHolderMemDetails = "txt"+argMatriId;
		argPlaceHolderMemDetailsDiv = argMatriId+"pd";
		document.getElementById(argPlaceHolderMemDetailsDiv).style.background = "#E8EBC9";
		document.getElementById(argPlaceHolderMemDetails).style.display="block";
	}//showPhoto
	function funMemInfoHide(argMatriId)
	{
		argPlaceHolderMemDetails = "txt"+argMatriId;
		argPlaceHolderMemDetailsDiv = argMatriId+"pd";
		document.getElementById(argPlaceHolderMemDetailsDiv).style.background = "#FFFFFF";
		document.getElementById(argPlaceHolderMemDetails).style.display="none";
	}//showPhoto
	function funContact(argMatriId)
	{
		var funFormName			= document.frmViewSimilarProfiles;
		var funGender			= funFormName.gender.value;
		var funOppositeGender	= funFormName.sessGender.value;
		if (funGender==funOppositeGender)
		{
			alert("You can send mail only to members of the opposite Gender");
		}//if
		else
		{
			var funUrl = "<?php echo $confValues['ServerURL'];?>/messages/profile-contact/" + argMatriId+"/";
			window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=565,height=524,status=no,scrollbars=no,titlebar=no;");
		}//else
	}//funContct
function doProductNext(argPgNum)
{
	document.frmProductQuickSearch.page.value = argPgNum;
	document.frmProductQuickSearch.submit();
}//funDoNextAdvanced

function funShowThumbnailFacebook()
{
	document.frmProductQuickSearch.displayFormat.value="T";
	document.frmProductQuickSearch.submit();
}//funViewProfiles
function funShowPhotoGalleryFacebook()
{
	document.frmProductQuickSearch.displayFormat.value="P";
	document.frmProductQuickSearch.submit();
}//funViewProfiles

function funShowBasicFacebook()
{
	document.frmProductQuickSearch.displayFormat.value="B";
	document.frmProductQuickSearch.submit();
}//funShowBasic

</script>
	<!--View Similar Profiles starts here-->
	<form name="frmViewSimilarProfiles" action="index.php" target="_blank" method="post" onSubmit="return false;">
	<input type="hidden" name="act" value="star-search-results">
	<input type="hidden" name="displayFormat" value="T">
	<input type="hidden" name="gender" value="<?=$varGender;?>">
	<input type="hidden" name="religion">
	<input type="hidden" name="caste">
	<input type="hidden" name="star">
	<input type="hidden" name="city">
	<input type="hidden" name="viewSimilarMatriId">
	<input type="hidden" name="page">
	<input type="hidden" name="paidStatus" value="<?=$sessPaidStatus;?>">
	<input type="hidden" name="sessGender" value="<?=$sessGender;?>">
	</form>
	<!--View Similar Profiles ends here-->

	<!--form starts here-->
	<form name="frmProductQuickSearch" method="post" onSubmit="return false;">
	<input type="hidden" name="matriIds" value="">
	<input type="hidden" name="displayFormat" value="<?=$objProductFacebook->clsDisplayFormat;?>">
	<input type="hidden" name="gender" value="<?=$varGender;?>">
	<input type="hidden" name="religion" value="<?=$varReligion;?>">
	<input type="hidden" name="fromAge" value="<?=$varAgeFrom;?>">
	<input type="hidden" name="toAge" value="<?=$varAgeTo;?>">
	<input type="hidden" name="profilePhoto" value="<?=$varPhoto;?>">
	<input type="hidden" name="page" value="<?=$pageNum?>">
	<input type="hidden" name="maritalStatus" value="<?=$_REQUEST["maritalStatus"];?>">
	<input type="hidden" name="heightFrom" value="<?=$_REQUEST["heightFrom"];?>">
	<input type="hidden" name="heightTo" value="<?=$_REQUEST["heightTo"];?>">
	<input type="hidden" name="religion" value="<?=$varArrayReligionList;?>">
	<input type="hidden" name="motherTongue" value="<?=$varArrayMotherTongueList;?>">
	<input type="hidden" name="caste" value="<?=$varArrayCasteList;?>">
	<input type="hidden" name="education" value="<?=$varArrayEducationList;?>">
	<input type="hidden" name="citizenship" value="<?=$varArrayCitizenshipList;?>">
	<input type="hidden" name="country" value="<?=$varArrayCountryList;?>">
	<input type="hidden" name="postedOn" value="<?=$_REQUEST["postedOn"];?>">
	<input type="hidden" name="postedMonth" value="<?=$_REQUEST["postedMonth"];?>">
	<input type="hidden" name="postedDay" value="<?=$_REQUEST["postedDay"];?>">
	<input type="hidden" name="postedYear" value="<?=$_REQUEST["postedYear"];?>">
	<input type="hidden" name="searchBy" value="<?=$_REQUEST["searchBy"];?>">
	<input type="hidden" name="city" value="<?=$_REQUEST["city"];?>">
	<input type="hidden" name="showPhoto[]" value="<?=$_REQUEST["showPhoto"][0]?>">
	<input type="hidden" name="donotShow[0]" value="<?=$varIgnoredProfile?>">
	<input type="hidden" name="donotShow[1]" value="<?=$varContactedProfile?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td><div style="padding-left:3px;padding-top:5px;padding-bottom:10px;"><font class="heading">Search Results</font></div></td></tr>
<tr><td class="smalltxt" align="left"><b><font color="red"><?=$varErrorMessage;?></font></b></td></tr>
<tr><td class="smalltxt" align="left" height="10"></td></tr>
<?php if ($varNumOfResults > 0) { ?>
<!--Search Results Tables starts here-->
	<tr>
		<td valign="top" align="right">
			<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="right">
				<tr>
					<td valign="top" width="150"><spacer width="450" height="21"></spacer></td>
					<td valign="top"></td>
					<td valign="top" width="10"><spacer width="10" height="21"></spacer></td>
					<td valign="top" width="72">
					<?php
						if ($objProductFacebook->clsDisplayFormat=='B')
						{
							?>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
							<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Basic View</font></div>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
						<?php
						}//if
						else
						{
							?>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
							<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none"><a href="javascript: funShowBasicFacebook()" style="text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Basic View</font></a></div>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
							<?php
						}//else
					?>
				</td>
				<td valign="top" width="102">
					<?php
						if ($objProductFacebook->clsDisplayFormat=='T')
						{
							?>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-on.gif" width="5" height="21"></div>
							<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Thumbnail View</font></div>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-on.gif" width="5" height="21"></div>
						<?php
						}//if
						else
						{
							?>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-leftcur-off.gif" width="5" height="21"></div>
							<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none"><a href="javascript: funShowThumbnailFacebook()" style="text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Thumbnail View</font></a></div>
							<div style="float:left"><img src="<?=$confServerURL?>/images/tab-rightcur-off.gif" width="5" height="21"></div>
							<?php
						}//else
					?>
					</td>
					<?php if($js_br=="I"  || $js_br=="F") { ?>
				<td valign="top" width="102">
					<?php
						if ($objProductFacebook->clsDisplayFormat=='P')
						{
							?>
							<div style="float:left"><img src="<?=$confServerURL?>/search/images/tab-leftcur-on.gif" width="5" height="21"></div>
							<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-on.gif);height:21;text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Photo Gallery</font></div>
							<div style="float:left"><img src="<?=$confServerURL?>/search/images/tab-rightcur-on.gif" width="5" height="21"></div>
						<?php
						}//if
						else
						{
							?>
							<div style="float:left"><img src="<?=$confServerURL?>/search/images/tab-leftcur-off.gif" width="5" height="21"></div>
							<div style="float:left;background-image: url(<?=$confServerURL?>/images/tab-midtile-off.gif);height:21;text-decoration:none"><a href="javascript: funShowPhotoGalleryFacebook()" style="text-decoration:none"><img src="<?=$confServerURL?>/images/trans.gif" width="1" height="4" border="0"><br><font style="font-family:verdana;font-size:11px;color:#ffffff;text-decoration:none">Photo Gallery</font></a></div>
							<div style="float:left"><img src="<?=$confServerURL?>/search/images/tab-rightcur-off.gif" width="5" height="21"></div>
							<?php
						}//else
					?>
					</td>
					<? } ?>
				</tr>
				<tr bgcolor="#FFFFFF"><td valign="top" height="1"><spacer type="block" align="left" width="100" height="1"></td></tr>
			</table>
		</td>
	</tr>	
	<!-- page nav starts here -->
	<!--Express Interest & Forward & Paging Table starts here-->
	<tr height="25" bgcolor="#F1F7E4">
		<td colspan="2" valign="top" bgcolor="#F1F7E4">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F1F7E4">
			<tr height="22">
					<td valign="middle" width="10">
					<?php if ($sessMatriId !="") { ?>
						<input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.searchResults,this.form.checkName,'0');">
					<? }//php?>
					</td>
					<td valign="top" align="left">
					<?php if ($sessMatriId !="") { 
				if($sessPaidStatus==1) {
				?>
					<input type="image" src="<?=$confServerURL?>/images/contact.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//if 
				elseif($sessPaidStatus==0){
				?>
					<input type="image" src="<?=$confServerURL?>/images/sendsalaam-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//elseif 
				 }//if?>
					</td>
					<td valign="middle" class="smallttxtnormal" align="right" style="padding-right:5px;"><?=$objProductFacebook->pageNavigation($varNumOfResults, $varCurrentPage, $varNumOfPages, "yes")?></td>
			</tr>
		</table>
	</td></tr>
	<? }//if?>
	<!--Express Interest & Forward & Paging Table ends here-->
</table>
<!--Heading Table ends here-->
<!--Search Results Tables starts here-->
<?php if ($varNumOfResults>0) { ?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr><td colspan="2">&nbsp;</td></tr>
	<?php $objProductFacebook->clsFields				= $confAdvancedSearch['Fields']; ?>
	<tr><td colspan="2">
	<!-- list of results starts here -->
	<?php 
		if($_REQUEST['starSearch']=='yes') {
			$varQuichSearchResults = $objProductFacebook->listSearchResult('S',$varViewSimilarMatriId);
		} else {
			$varQuichSearchResults = $objProductFacebook->listSearchResult('R');
		}
	?>
	</td></tr>
</table>
<?php }else {?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="formborderclr" valign="top">
	<tr><td class="errorMsg" height="40" valign="middle" align="center">
	No members match with your selected criteria. <a href="javascript:history.back();" class="smalltxt2"><u><b>Click here to try again</b></u></a></td></tr>
	<tr><td height="10"></td></tr>
	<tr><td></td></tr>
</table>
<? }//else?>
<!--Search Results Tables starts here-->
<!--Express Interest & Forward & Paging Table starts here-->
<?php if ($varNumOfResults > 0) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="5" colspan="2"></td></tr>
	<tr height="25"><td colspan="2" valign="top" bgcolor="#F1F7E4">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F1F7E4">
			<tr height="22">
					<td valign="middle" width="10">
						<?php if ($sessMatriId !="") { ?>
						<input type="checkbox" name="checkName" value="1" onclick="funCheckAll(this.form.searchResults,this.form.checkName,'1');">
						<?php }//if?>
					</td>
					<td valign="top" align="left">
						<?php if ($sessMatriId !="") { 
				if($sessPaidStatus==1) {
				?>
					<input type="image" src="<?=$confServerURL?>/images/contact.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//if 
				elseif($sessPaidStatus==0){
				?>
					<input type="image" src="<?=$confServerURL?>/images/sendsalaam-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//elseif 
				 }//if?>
					</td>
					<td valign="middle" class="smallttxtnormal" align="right" style="padding-right:5px;"><?=$objProductFacebook->pageNavigation($varNumOfResults, $varCurrentPage, $varNumOfPages, "yes")?></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>&nbsp;</td></tr>
</table><br>
<? }//if?>
<!--Express Interest & Forward & Paging Table ends here-->
<!--From ends here-->
</form>
<?php
//UNSET OBJECT
unset($objProductFacebook);
?>
