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
$objProductFacebook->clsServerURL				= $confValues['ServerURL'];
$objProductFacebook->clsSessionMatriId			= $sessMatriId;
$objProductFacebook->clsPaidStatus				= $sessPaidStatus;
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
		$varAgeFrom		= $_REQUEST['fromAge'];
		$varAgeTo		= $_REQUEST['toAge'];
		$varPhoto		= $_REQUEST['profilePhoto'];
		$varCountry		= $_REQUEST['country'];
		$varpage		= $_REQUEST['page'];
		//echo 'gender::'.$varGender.'Religion::'.$varReligion.'AgeFrom::'.$varAgeFrom.'AgeTo::'.$varAgeTo.'Photo::'.$varPhoto.'Country::'.$varCountry.'Page::'.$varpage; 
		$varPrimary[]		= 'Gender';
		$varPrimaryValue[]	= $varGender;
		$varPrimarySymbol[] = '=';
		$varPrimary[]		= 'Age';
		$varPrimaryValue[]	= $varAgeFrom;
		$varPrimarySymbol[] = '>=';
		$varPrimary[]		= 'Age';
		$varPrimaryValue[]	= $varAgeTo;
		$varPrimarySymbol[] = '<=';
		if ($varCountry !="")
		{
			$varPrimary[]		= 'Country';
			$varPrimaryValue[]	= $varCountry;
			$varPrimarySymbol[] = '=';
		}//if
		if ($varReligion !="")
		{
			$varPrimary[]		= 'Religion';
			$varPrimaryValue[]	= $varReligion;
			$varPrimarySymbol[] = '=';
		}//if
		if ($varPhoto == 1)
		{
			$varPrimary[]		= 'Photo_Set_Status';
			$varPrimaryValue[]	= 1;
			$varPrimarySymbol[] = '=';
		}//if

		$objProductFacebook->clsPrimary				= $varPrimary;
		$objProductFacebook->clsPrimaryValue		= $varPrimaryValue;
		$objProductFacebook->clsPrimaryKey			= array('AND', 'AND', 'AND','AND','AND');
		$objProductFacebook->clsPrimarySymbol		= $varPrimarySymbol;
		
		$varSearchFormValues				= "gen=".$varGender."&rel=".$varReligion."&afr=".$varAgeFrom."&ato=".$varAgeTo."&cou=".$varCountry."&pho=".$varPhoto;
	}//else
	$varNumOfResults							= $objProductFacebook->numOfResultsM1(); 
	$varCurrentPage								= $varpage;
	$varNumOfPages								= ceil($varNumOfResults/$objProductFacebook->clsLimit);
	//echo '$varNumOfResults::'.$varNumOfResults.'$varNumOfPages::'.$varNumOfPages.'$Limit::'.$objProductFacebook->clsLimit;
?>
<script language="javascript" src="<?=$confValues['ServerURL']?>/search/includes/search-results.js"></script>
<!-- Calling Ajax Function To Display Photo Starts Here -->
<script language="javascript" src="<?=$confValues['ServerURL']?>/includes/libAjaxForSearch.js"></script>
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
	function funBookmark(argMatriId)
	{
		var varUrl = "<?php echo $confValues['ServerURL'];?>/bookmark-add/bookmarkId=" + argMatriId+"/";
		var newpopup=window.open(varUrl, "","top=300,left=300,menubar=no,toolbar=no,location=no,resizable=no,width=350,height=249,status=no,scrollbars=no,titlebar=no;");
		newpopup.focus();
	}//funBookmark

	function doProductNext(argPgNum)
	{
		document.frmProductQuickSearch.page.value = argPgNum;
		document.frmProductQuickSearch.submit();
	}//funDoNextAdvanced

	function funProtectedPhoto(argMatrId)
	{
		var funUrl = "<?php echo $confValues['ServerURL'];?>/search/protected-photo/" + argMatrId+"/";
		window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=280,status=no,scrollbars=no,titlebar=no;");
	}//funProtectedPhoto
	function funViewPhoto(argMatrId)
	{
		var funUrl = "<?php echo $confValues['ServerURL'];?>/search/view-photo/" + argMatrId+"/";
		window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=600,status=no,scrollbars=no,titlebar=no;");
	}//funViewPhoto

	function showbookmark(argUrl) {
		var newpopup=window.open("<?php echo $confValues['ServerURL'];?>/list/" + argUrl+"/", "","top=300,left=300,menubar=no,toolbar=no,location=no,resizable=no,width=310,height=125,status=no,scrollbars=no,titlebar=no;");
		newpopup.focus();
	}

	function funProfileHistory(argMatriId)
	{
		var funUrl = "<?php echo $confValues['ServerURL'];?>/messages/profile-history/" + argMatriId+"/";
		window.open(funUrl,'ProfileHistory','toolbar=no,scrollbars=yes,resizable=yes,width=500,height=200');
	}//funProfileHistory

</script>
	<!--View Similar Profiles starts here-->
	<form name="frmViewSimilarProfiles" action="index.php" target="_blank" method="post" onSubmit="return false;" style="display:none">
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
	<input type="hidden" name="displayFormat" value="T">
	<input type="hidden" name="gender" value="<?=$varGender;?>">
	<input type="hidden" name="religion" value="<?=$varReligion;?>">
	<input type="hidden" name="fromAge" value="<?=$varAgeFrom;?>">
	<input type="hidden" name="toAge" value="<?=$varAgeTo;?>">
	<input type="hidden" name="profilePhoto" value="<?=$varPhoto;?>">
	<input type="hidden" name="country" value="<?=$varCountry;?>">
	<input type="hidden" name="page" value="<?=$pageNum?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
<tr><td class="heading" style="padding:0px 5px 0px 5px">Search Results</td></tr>
<tr><td class="smalltxt" style="padding:5px 10px 15px 5px">Listed below are the profiles on MuslimMatrimonial.com that match your search criteria! Please click on the username of any profile you like to view the details.</td></tr>
</table>
<?php
if ($varNumOfResults > 0) { 
?>
<!--Search Results Tables starts here-->
<table border="0" cellpadding="0" cellspacing="0" width="570"  align="center">
	<!-- page nav starts here -->
	<tr height="25">
		<td colspan="4" valign="top" bgcolor="#F1F7E4">
			<table border="0" cellpadding="0" cellspacing="0" width="570" bgcolor="#F1F7E4" align="center">
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
					<input type="image" src="<?=$confValues['ServerURL']?>/images/contact.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//if 
				elseif($sessPaidStatus==0){
				?>
					<input type="image" src="<?=$confValues['ServerURL']?>/images/sendsalaam-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//elseif 
				 }//if?>
					</td>
					<td valign="middle" class="smallttxtnormal" align="right" style="padding-right:5px;"><?=$objProductFacebook->pageNavigation($varNumOfResults, $varCurrentPage, $varNumOfPages, "yes")?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="4" height="3"></td></tr>
	<tr><td colspan="4">
	<!-- list of results starts here -->
	<?php 
		$varTemplate = $objProductFacebook->getContentFromFile($confQuickSearch['ListTemplateThumbnail']); 
		$objProductFacebook->clsListTemplate	= $varTemplate;
		if($_REQUEST['starSearch']=='yes') {
			$varQuichSearchResults = $objProductFacebook->listSearchResult('S',$varViewSimilarMatriId);
		} else {
			$varQuichSearchResults = $objProductFacebook->listSearchResult('R');
		}
	?>
	</td></tr>
		<tr><td height="3" colspan="4"></td></tr>
		<tr height="25">
		<td colspan="4" valign="top" bgcolor="#F1F7E4">
			<table border="0" cellpadding="0" cellspacing="0" width="570" bgcolor="#F1F7E4" align="center">
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
					<input type="image" src="<?=$confValues['ServerURL']?>/images/contact.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//if 
				elseif($sessPaidStatus==0){
				?>
					<input type="image" src="<?=$confValues['ServerURL']?>/images/sendsalaam-button.gif" vspace="5" hspace="5" onClick="funConfirmMessage(this.form,this.form.searchResults,1);">
				<?php }//elseif 
				 }//if?>
					</td>
					<td valign="middle" class="smallttxtnormal" align="right" style="padding-right:5px;"><?=$objProductFacebook->pageNavigation($varNumOfResults, $varCurrentPage, $varNumOfPages, "yes")?></td>
			</tr>
			</table>
		</td>
	</tr>
	<!-- list of results ends here -->
</table>

<?php }else {?>
<table width="570" border="0" cellspacing="0" cellpadding="0" align="center" class="formborderclr" valign="top">
		<tr><td class="errorMsg" height="40" valign="middle" align="center">
		No members match with your selected criteria. Please try again.</td></tr>
		<tr><td height="10"></td></tr>
		<tr><td></td></tr>
	</table>
<?php
}
//UNSET OBJECT
unset($objProductFacebook);
?>
