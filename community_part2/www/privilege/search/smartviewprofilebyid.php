<?php
/****************************************************************************************************
File		: smartadvancesearch.php
Author		: Andal.V
Date		: 20-Dec-2007
*****************************************************************************************************
Description	: 
			This advance search form	 
********************************************************************************************************/

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvars.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearch.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc");

include_once($DOCROOTBASEPATH."/bmconf/bmvarssearcharrincen.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearchformarren.inc");

$xml_filename = $DOCROOTBASEPATH."/bmconf/bmvarsregularsearchlabel.inc";
require_once "parsexml.php";

include_once("smartsubdomains.php");

$domain_name = smartGetDomainPrefixName();

if($domain_name!="bharat" && $_GET['sid']== "") {
	$rec['Language'] = array_search($GETDOMAININFO['domainnameshort'], $GLOBALS['DOMAINNAME']);
}

$PAGEVARS['PAGETITLE']= smartGetPageTitle()." Matrimony - View Profile By Id";
include_once("../template/headertop.php");
?>

<link rel="stylesheet" href="<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmstyles/useractions-sprites.css">

<style type="text/css">
@import url("<?=$COMMONVARS['IM_SERVER_PREFFIX'];?>/bmstyles/global-style.css");
.iconclass{position: absolute;visibility:visible;-moz-opacity: 0.80; opacity:0.80;filter: alpha(opacity=80);}
</style>
<script src="http://<?=$GETDOMAININFO['domainnameimgs'];?>/scripts/searchcommon.js" language="javascript"></script>
<script language=javascript>
function IsEmpty_view(obj, obj_type)
	{
		if (obj_type == "text")	
		{
			var objValue;
			objValue = obj.value.replace(/\s+$/,"");	
				if (objValue.length == 0) 
				{
				return true;
				}
				else {return false;}
		}
}
function validateViewId() {
	var MatriForm = this.document.MatriForm;
	if(IsEmpty_view(MatriForm.BMID, 'text')){
		$("viewproerr").innerHTML="Please enter Matrimony ID.";			
		//MatriForm.BMID.focus();		
		return false;
	}
	else{
		$("viewproerr").innerHTML="";	
		return true;
	}
}
function frmvalidate()
	{ 
	if(!validateViewId()) {
		return false;
	}
	document.MatriForm.action="/profiledetail/viewprofile.php";
	//document.MatriForm.submit();
	return true;
	}

</script>
<?php
include_once("../template/header.php");
?>
<div id="useracticons"><div id="useracticonsimgs" style="float: left; text-align: middle;">
<form name="MatriForm" method="post" onsubmit="return frmvalidate();">
		<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">
						<div class="fleft">
								<div class="tabcurbg fleft">
								<div class="fleft">
									<div class="fleft tabclrleft"></div>
									<div class="fleft tabclrrtsw"><div class="tabpadd"><font class="mediumtxt1 boldtxt clr4">Search By Member ID </font>&nbsp;</div></div>
								</div>
								</div>

								<div class="fleft tr-3"></div>
							</div>

				<div class="middiv1">
				<div class="bl">
					<div class="br">
							<div style="padding: 10px 0px 10px 14px;">
							<div style="padding: 10px 0px 5px 1px;"><font class="smalltxt">Enter the Matrimony ID of the member whose profile you would like to see.</font></div>
							<!-- Content Area -->	


						<div style="width:517px; border:1px solid #CAD6AE;background-color:#E0EDC2;padding-bottom:15px;">
							<div class="mediumtxt fleft" style="padding:7 0 0 5px;">Matrimony ID</div>
							<div style="padding:5 0 0 5px;" class="fleft"><input type=text name=BMID size=22 maxlength=60 value="" class="inputtext" onBlur="validateViewId();"></div>
							<div style="padding:5 0 0 10px;" class="fleft"><INPUT TYPE="submit" class="button" value="View Profile"></div>
						<br clear="all">
						<div style="padding-left:82px;" class="errortxt fleft" id="viewproerr"></div>
						</div>

						<?/*
						<div style="width:517px;BORDER: #CAD6AE 1px solid;">
							<div>
								<div class="middiv-pad1" style="background-color:#E0EDC2;BORDER: #CAD6AE 1px solid;">
									<div class="mediumtxtbld" style="padding-top:3px;padding-left:14px;float:left;">Matrimony ID</div>
									<div style="padding-left:10px;float:left;"><input type=text name=BMID size=22 maxlength=60 value="" class="inputtext"></div>
									<div>&nbsp;<INPUT TYPE="submit" class="button" value="View Profile" onClick="return frmvalidate();"></div>		
								</div>
							</div>
						</div>
						-->*/?>

					</div>	<BR><BR>
			<!-- Content Area -->									
						</div>
					</div>
				 </div>
			</div>
	<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>
</form></div></div>
<?php
include_once("../template/rightpanel.php");
include_once("../template/footer.php");
?>