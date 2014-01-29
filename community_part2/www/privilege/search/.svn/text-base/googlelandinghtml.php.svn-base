<?php
/****************************************************************************************************
File		: googlelanding.php
Author		: Andal.V
Date		: 20-Dec-2007
*****************************************************************************************************
Description	: 
			Google landing Page.This page created for SEO. This will be in search.bharatmatrimony.com
********************************************************************************************************/
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);
error_reporting(0);
include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvars.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc");

$data['dmarr']= getDomainInfo();
$domain_cap_name=ucfirst($data['dmarr']['domainnameshort'])."Matrimony";

$keyword_caps=ucwords($_REQUEST['keytext']);

$desc="$keyword_caps Matrimonials, $keyword_caps Bride, $keyword_caps Groom, $keyword_caps Marriage Site, $keyword_caps Matrimonial";

$redirect="http://bmser.bharatmatrimony.com/register/partneradd.php";	

function randommatchQuote($keyword_caps) {
	$th="Your ".$keyword_caps." Search Ends Here!";
   $f=array(0=>"Searching Someone In Your Caste?",1=>"Marry An Ideal Life Partner",2=>$th);
   $k =rand(0,2);
   return $f[$k];
}

$jsg_br=getBrowserDetails();
$PAGEVARS['PAGETITLE']=$desc;
$PAGEVARS['PAGEDESC']=$desc;
$PAGEVARS['CSSPATH']="http://imgs.bharatmatrimony.com/bmstyles";
?>
<base href="http://www.bharatmatrimony.com/">
<html>
<head>
<title><?=$PAGEVARS['PAGETITLE']?></title>
<meta name="description" content="<?=$PAGEVARS['PAGEDESC']?>">
<link rel="stylesheet" href="<?=$PAGEVARS['CSSPATH']?>/home.css">
<link rel="stylesheet" href="<?=$PAGEVARS['CSSPATH']?>/bmstyle.css">
<link rel="stylesheet" href="<?=$PAGEVARS['CSSPATH']?>/smartsearchcss.css">
<meta name="robots" content="noarchive,noindex,nofollow" />
<noscript><div style="padding:10 10 10 10;"><font class="normaltxt1">It appears that your browser does not support JavaScript, or you have it disabled.  This site is best viewed with JavaScript enabled.<p>If JavaScript is disabled in your browser, please turn it back on then reload this page.<p>Or, if your browser does not support JavaScript.<?php echo $desc;?></p></font></div></noscript>
<style>
.hidetext{font:normal 11px verdana;display:none;}
</style>

<script language="javascript" src="<?=$PAGEVARS['JSPATH'];?>/common.js"></script>
<script language="Javascript">
<!--
	function validate() {
		var MatriForm = this.document.MatriForm;
		var age =parseInt( MatriForm.AGE.value);
		if(IsEmpty(MatriForm.NAME,'text')) {
			alert("Please enter Bride/Groom Name");
			MatriForm.NAME.value="";
			MatriForm.NAME.focus( );
			return false;
		}
		if(IsEmpty(MatriForm.AGE,'text')) {
			alert( "Please enter Age" );
			MatriForm.AGE.focus( );
			return false;
		}
		if ( age < 21 && MatriForm.GENDER[0].checked == true){
				alert( "Invalid Age " +  MatriForm.AGE.value + ".  Minimum age allowed is 21" );
				MatriForm.AGE.focus( );
			return false;} 
		if ( age < 18 && MatriForm.GENDER[1].checked == true){
				alert( "Invalid Age " +  MatriForm.AGE.value + ".  Minimum age allowed is 18" );
				MatriForm.AGE.focus( );
			return false;
			}
		if ( age < 18 && !(MatriForm.GENDER[1].checked == true) && !(MatriForm.GENDER[1].checked == true)){
				alert( "Invalid Age " +  MatriForm.AGE.value + ".  Minimum age allowed is 18" );
				MatriForm.AGE.focus( );
			return false;} 
		if( !CompareValue( MatriForm.AGE.value, "0123456789" )){
			alert("Invalid Age " + MatriForm.AGE.value);
			MatriForm.AGE.focus( );
			return false;}
		else {
			if ( age < 18 )	{
				alert( "Invalid Age " +  MatriForm.AGE.value + ".  Minimum age allowed is 18" );
				MatriForm.AGE.focus( );
				return false;} 
			if ( age > 70 )	{
				alert( "Invalid Age " +  MatriForm.AGE.value + ".  Maximum age allowed is 70" );
				MatriForm.AGE.focus( );
				return false;} 
		}
		
		if ( !MatriForm.GENDER[0].checked && !MatriForm.GENDER[1].checked){
			alert( "Please select Gender" );
			MatriForm.GENDER[0].focus( );
			return false;}

		if ( MatriForm.GENDER[0].checked && MatriForm.AGE.value < 21) {
			alert( "You must be atleast 21 yrs old to register" );
			MatriForm.AGE.focus( );
			return false;}
		
		if ( MatriForm.MARITAL_STATUS.selectedIndex == 0 ) {
			alert( "Please select Marital Status" );	
			MatriForm.MARITAL_STATUS.focus( );
			return false;}
	
		if(IsEmpty(MatriForm.EMAIL,'text')) {
			alert ('Please enter E-mail id');
			MatriForm.EMAIL.focus();
			return false;	}
		if (ValidateEmail(MatriForm.EMAIL.value) == false) {
			MatriForm.EMAIL.focus();
			return false;
		}
	}

//function to bookmark the page..
function bookmark(title){
	var url=window.location.href;
	  if ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4)) {
		window.external.AddFavorite(url,title);
	  } else {
		alert("Press CTRL+D (Netscape) or CTRL+T (Opera) to bookmark");
        }
}

function getHTTPObject() {
	var xmlhttp; try { xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");  } catch (e) { try { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { xmlhttp=false; } } 
	if(!xmlhttp && typeof XMLHttpRequest !=undefined) { try { xmlhttp=new XMLHttpRequest(); } catch (e) { xmlhttp=false; } }
	if(!xmlhttp) { display_error_message(e,"noajax"); return; } else { return xmlhttp; }
}

var jsg_http=new getHTTPObject();

function call_plug() {
	window.external.AddSearchProvider("http://search.bharatmatrimony.com/bmsearch.xml");	
	url="http://search.bharatmatrimony.com/cgi-bin/google_bmsearch_plugin.php?plu=1";	
	jsg_http.open("GET", url, true);	
	jsg_http.onreadystatechange=function() { };
	jsg_http.send(null);
}
//  -->
</script>
</head>
<?php
echo $BODYSTART;
echo $BODYALIGNMENT;
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>
<td valign="top" width="778">
<table border="0" cellpadding="0" cellspacing="0" width="778">
<tr>
	<td colspan="5" height="95">
	<table border="0" cellpadding="0" cellspacing="0" width="778">
	<tr>
		<td width="200"><img src="http://imgs.communitymatrimony.com/images/logo/community_logo.gif"  alt="<?=$keyword_caps;?> Marriage Site" border="0">
		</td><td align="right"><?php if($jsg_br=="F") {?><div><font onClick="call_plug()" class="linktxt2 cstyle" >Click here to Add Bharat Matrimony Search Plugin&nbsp;&nbsp;</font><br/><br/></div><?php }?><font style='font: normal 12px arial,verdana;color:#FE7313;'>Register FREE! Search, Chat & Marry&nbsp;&nbsp;&nbsp;</font>
		</td>
	</tr>
	<tr>
	<td>
	<div style="float:left;height:20px;padding-bottom:4px;padding-top:2px;text-align:middle;"><font class="smalltxtgr">&nbsp;&nbsp;&nbsp;<font class="linktxt2">Bharat Matrimony</font>&nbsp;>&nbsp;<font class="linktxt2" title="Search, Chat & Marry">Search</font>&nbsp;>&nbsp;</font><font class="smalltxtgr"><b><?=$_REQUEST['keytext'];?></b></font>	
	</div>
	</td>
	<td align="right" valign="bottom" style="padding-right:20px;padding-bottom:0px;">
	<div style="float:right;height:20px;padding-bottom:4px;padding-top:2px;text-align:right;">
		<script>
		var tit="<?=$keyword_caps;?>";
		if(tit==''){
			tit="Bharat";
		}
		tit+=" Matrimony";
		if (navigator.appName == "Netscape" || navigator.appName == "Opera") {document.write("<font style='font: normal 12px arial,verdana;color:#FE7313;'>Press CTRL+D to bookmark</font>");
		} else {
		document.write('<a href="javascript: void(0)"  class="hpnormaltxt" onclick=\'bookmark(tit);\'><font style="font: normal 12px arial,verdana;color:#FE7313;">Bookmark This Page</font></a>');
		}
		</script>	
		</div>
	</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td valign="bottom"><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-top-lt-curve.gif" width="24" height="26" border="0" alt=""></td>
	<td rowspan="2" width="346" height="440" bgcolor="#FDD564" valign="bottom">
		<div style="font:normal 24px arial,verdana,tahoma;margin-top:13;text-align:top;">Looking for a suitable<br><font class="hidetext"><?echo $keyword_caps;?></font> bride or groom?</div>
		<div class="textsmallnormal" style="margin-top:5px;margin-right:10px;text-align:left;margin-bottom:0px;"><br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1" border="0" alt=""><br></div>
		<div style="text-align:left;"><img src="http://imgs.bharatmatrimony.com/bmimages/bharat_google_model.jpg" width="300" height="261" border="0" alt="<?php echo $keyword_caps;?> Matrimonials"></div>
	</td>
	<td rowspan="2" ><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-top-middle.gif" width="60" height="440" border="0" alt="<?php echo $keyword_caps;?>"></td>
	<td rowspan="2" width="320" height="440" bgcolor="#FDB913" valign="top">
			<table border="0" cellpadding="2" cellspacing="0" width="263" height="207" align="center" style="border: 1px solid #ffffff;margin-top:17px;margin-left:5px;font:normal 11px verdana;" bgcolor="#FFDA6A">
														
					<form method="POST" action="<?echo $redirect;?>" name="MatriForm" onsubmit="document.cookie='popunder=yes';return validate();">
					<tr><td valign="middle" colspan="2"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5"></td></tr>
					<tr><td valign="middle" colspan="2" align="center"><font style="font: bold 18px arial,verdana;color:#FF4E00"><b>Register FREE Now!</b></font></td></tr>
					<tr><td valign="middle" colspan="2"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="5"></td></tr>
						<tr>
							<td valign="middle"><font class="textsmall"><font color="#000000">&nbsp;Name</font></td>

							<td valign="top"><input type="text" name="NAME" size="15" class="addtextfiled"></td>
						</tr>
						<tr>
							<td valign="top"><font class="textsmall"><font color="#000000">&nbsp;Age</font></font></td>
							<td valign="top"><input type="text" name="AGE" size="2" maxlength="2" class="addtextfiled"></td>
						</tr>		
						<tr>
							<td valign="top"><font class="textsmall"><font color="#000000">&nbsp;Gender</font></font></td>

							<td valign="top"><font class="textsmall"><input type="radio" name="GENDER" value="M">&nbsp;Male</font>&nbsp;&nbsp;<font class="textsmall"><input type="radio" name="GENDER" value="F">&nbsp;Female</font></td>
						</tr>		
						<tr>
							<td valign="top"><font class="textsmall"><font color="#000000">&nbsp;Marital Status</font></font></td>
							<td valign="top"><font face="arial, verdana" size="2">
							<SELECT class="textsmall" style="width:128px;" NAME="MARITAL_STATUS" size="1">
							<option value=0 selected>- Select -</option>
   							 <option value=1>UnMarried</option>
							  <option value=2>Widow / Widower</option>
							  <option value=3>Divorced</option>
							  <option value=4>Separated</option>
						  </select></font>
							</td>
						</tr>				
						<tr>
							<td valign="top"><font class="textsmall"><font color="#000000">&nbsp;E-mail</font></font></td>
							<td valign="top"><input type="text" name="EMAIL" size="15" class="addtextfiled"></td>
						</tr>		
						<tr>
							<td></td>
							<td valign="top" style="padding-bottom:10px;padding-top:3px;padding-left:25px;"><input type=image src="http://imgs.bharatmatrimony.com/bmimages/button-submit.gif" name=submit border="0" alt="<? echo $keyword_caps;?> Matrimonial - Register Free & Marry"></td>		
						</tr>
						<input type="hidden" name="title" value="<?=$desc;?>">
						<input type="hidden" name="seakeywd" value="<?=$keyword_caps;?>">
					</form>
					</table>
			<div class="textsmallnormal" style="margin-top:14px;margin-left:5px;line-height:15px;width:310px;text-align:left;"><font style="font: bold 20px arial,verdana;color:#ffffff">Success Story</font>	<br><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="10" border="0" alt=""><br>Hi to all. My heartfelt thanks goes to BharatMatrimony.com where I found my life partner. I met her once and at the first sight I found my soul mate. We had exchanged lots of thoughts and decided to fix up the family meeting. Also, both of our families are happy with it. On 3rd December we got engaged. Once again thanks to BharatMatrimony.com.  <br><br><b>- Varsha and Kiran</b>
			 </div>
	</td>
	<td valign="bottom"><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-top-rt-curve.gif" width="28" height="26" border="0" alt=""></td>
</tr>
<tr>
	<td bgcolor="#FDD564" height="414"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="414" border="0" alt=""></td>
	<td bgcolor="#FDB913" height="414"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="414" border="0" alt=""></td>
</tr>
<tr>
	<td><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-why-lt-curve.gif" width="24" height="61" border="0" alt=""></td>
	<td colspan="3"><div class="textsmallnormal"><font style="font: bold 18px arial,verdana;color:#F47C23">Why BharatMatrimony.com?</font><br>
	</div></td>
	<td><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-why-rt-curve.gif" width="28" height="61" border="0" alt=""></td>
</tr>
<tr>
	<td colspan="5">
	<div align="center" >
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="778">
		<tr>
			<td width="5" height="180" align="left"><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-why-left.gif" width="5" height="180" border="0" alt=""></td>
			<td valign="top" background="http://imgs.bharatmatrimony.com/bmimages/midtblbg.gif" width="252" height="180px" >
							<div class="fleft smalltxt" style="padding-left:10px; padding-top:10px;width:242px !important; width:252px;">
							<div class="rigpanel mediumtxt boldtxt" style="padding-bottom:5px;">Most Awarded and Recognized Portal</div>
							<div class="fleft" style="padding:0px 5px 0px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> Limca Book of Records</div> <br clear="all">
							<div class="fleft" style="padding:4px 5px 0px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> PCWorld's 'Best Indian Matrimony Website<br>&nbsp;&nbsp;&nbsp; 2007'</div> <br clear="all">
							<div class="fleft" style="padding:4px 5px 0px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> NASSCOM's Top 100 IT Innovators - 2 years <br>&nbsp;&nbsp;&nbsp;&nbsp;in a row</div> <br clear="all">
							<div class="fleft" style="padding:4px 5px 0px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> Leader in Online Matrimony - JuxtConsult - <br>&nbsp;&nbsp;&nbsp;&nbsp;2008</div> <br clear="all">
							<div class="fleft" style="padding:4px 5px 0px 0px;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> Most Visited - Alexa, ComScore & <br>&nbsp;&nbsp;&nbsp;&nbsp;TrafficEstimate </div>							
							</div>						
			</td>
			<td width="5"></td>
			<td valign="top" background="http://imgs.bharatmatrimony.com/bmimages/midtblbg.gif" width="252" height="180px" >
							<div class="fleft smalltxt" style="padding-top:10px; padding-left:10px; width:232px !important;width:242px;">
							<div class="rigpanel mediumtxt boldtxt fleft">Most Trusted Since 1997</div><br clear="all" />
							<div style="padding:10px 0px 5px 0px; text-align:left;">We are always committed to offer services that deepen the trust of our members. </div>	
							<div style="padding-top:10px; text-align:left;"><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> Detailed Manual Screening of every Profile <br><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> Verified Profile & Contact Information <br><img src="http://imgs.bharatmatrimony.com/bmimages/hp-grey-arrow.gif" width="4" height="7" border="0" alt="" hspace="3" /> Highest level of Privacy & Security </div>
							</div>				
			</td>
			<td width="5"></td>
			<td valign="top" background="http://imgs.bharatmatrimony.com/bmimages/midtblbg.gif" width="252" height="180px"  >

							<div class="fleft mediumtxt" style="padding-left:10px; padding-top:10px;">
							<div class="rigpanel mediumtxt boldtxt">Over a decade of innovation in <br />online matrimony.</div>
							<div style="padding-top:5px;padding-bottom:5px;" class="smalltxt">Constantly innovating and strengthening <br />our leadership position. </div>
							<div class="rigpanel mediumtxt boldtxt">Only to serve you better</div>
							<?php trackingUrl();?>
							</div>

			</td>
			<td width="6" height="180"><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-why-right.gif" width="6" height="180" border="0" alt=""></td>
		</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="778">
		<tr><td colspan="7"><img src="http://imgs.bharatmatrimony.com/bmimages/google-lp-why-bottom.gif" width="778" height="22" border="0" alt=""></td></tr>
	</table>
	</div>
	</td>
</tr>
</table>

<script language="javascript" type="text/javascript">
<!--
function veriPopUp(){sealWin=window.open("https://seal.verisign.com/splash?form_file=fdf/splash.fdf&dn=BHARATMATRIMONY.COM&lang=en","win",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=535,height=450');self.name = "mainWin";}
-->
</script>
<div style="width: 778px;">
		<div style="width: 130px;float: left; padding-top: 5px; text-align: left;">

					<div style="width: 130px; float: left; text-align: left;">
					<img src='http://imgs.bharatmatrimony.com/bmimages/footer-isologo-new.gif' width='130' height='69' hspace='8' vspace='3' border='0' alt='ISO Certified Company' />

					</div>
		</div>
		<div style="width: 525px;float: left; text-align: left;">
					<div style="width: 525px; float: left; text-align: left;">
						<div class="medium" style="float: middle; text-align: middle; margin-left: 100px;" style="color: #666666;">
								<div style="margin: 5pt 0pt 6px 55px;"><a href="http://www.bharatmatrimony.com/termscond.shtml" target="_blank" class="hpnormaltxt" title="Terms and Conditions"><font color="#999999">Terms and Conditions</font></a>&nbsp;|&nbsp;<a href="http://www.bharatmatrimony.com/privacy.shtml" target="_blank" class="hpnormaltxt" title="Privacy Policy"><font color="#999999">Privacy Policy</font></a>
								<br>
								<br>
								<font style='font: normal 12px arial,verdana;color:#FE7313;align:center;' ><?php echo randommatchQuote($keyword_caps);?></font></div>							
						</div>					
					</div>
					
		</div>
		<div style="width: 87px;float: left; text-align: left;"><div style="width: 87px; float: left; text-align: left;"><a href="javascript:veriPopUp()"><img src="http://imgs.bharatmatrimony.com/bmimages/footer-verisignlogo.gif" width="87" height="58" hspace="8" vspace="3" border="0" alt="VeriSign" /></a></div></div>

</div>
<div style="width: 778px;"><div style="margin: 5pt 0pt 5px 2px;"><img src="http://imgs.bharatmatrimony.com/bmimages/footer-line.gif" width="759" height="1" alt="" /></div></div>
<div style="margin: 5pt 10pt 5px 1px;text-align:center;" class="hpnormaltxt"><script language="javascript" src="http://imgs.bharatmatrimony.com/bmjs/copyright.js" type="text/javascript"></script></div></td>
</tr>
</table>
<?php
echo $BODYCLOSE;
function trackingUrl() {
	global $COMMONVARS;
	if($_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]==$COMMONVARS['SMART_DEBUG_VAL'] && $_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]!="") {
		print_r($_REQUEST);
	}
	if($_REQUEST['referredby']!="") {	
	?>
	<img width=0 height=0 border='0' src="http://server.bharatmatrimony.com/campaign/tracking.php?section=google_New&siteurlsite=Google_New&domain=15&landing=partneradd.php&creative=google_new_28feb08&referredby=<?=$_REQUEST['referredby'];?>">
	<?
	} else if($_SERVER['HTTP_REFERER']=="" && $_REQUEST['referredby']=="") { ?><img src="http://server.bharatmatrimony.com/campaign/tracking.php?section=Google_Bookmark&siteurlsite=google_text_track&domain=15&landing=www.bharatmatrimony.com&creative=bookmark&referredby=74210000" width="0" height="0" border='0'><? 
	} else if($_REQUEST['fromwhere']=="plugin" && $_REQUEST['referredby']=="") { ?><img src="http://server.bharatmatrimony.com/campaign/tracking.php?section=google_plugin&siteurlsite=google_nri_contexual&domain=15&landing=googlelanding.shtml&creative=bm_google_plugin_13feb08&referredby=73900001" width="0" height="0" border='0'><? 
	}  else { ?>
	<img width=0 height=0 border='0'src="http://server.bharatmatrimony.com/campaign/tracking.php?section=google_New&siteurlsite=Google_New&domain=15&landing=partneradd.php&creative=google_new_28feb08&referredby=98600000">		
 <? }
}
?>