<?php
#================================================================================================================
# Author 	: Srinivasan
# Date		: 18-May-2010
# Project	: MatrimonyProduct
# Filename	: addhoroscope.php
# Used For  : horoscope match details
#================================================================================================================
//FILE INCLUDES
$varServerRoot		= $_SERVER['DOCUMENT_ROOT'];
$varRootBasePath	= dirname($varServerRoot);
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");
include_once "horomatchfunctions.php";


//SESSION VARIABLES
$sessMatriId	= $varGetCookieInfo['MATRIID'];
$sessPaidStatus	= $varGetCookieInfo["PAIDSTATUS"];
//$sessPaidStatus	= 1;

//OBJECT INITIALIZATION
$objSlaveDB	= new DB;

//CONNECTION DECLARATION
$objSlaveDB->dbConnect('S', $varDbInfo['DATABASE']);

//VARIABLE
$varPartnerId	= $_REQUEST['partnerId'];

//INCLUDE SCRIPT FILE
echo '<script src="'.$confValues["IMAGEURL"].'/scripts/horomatchcheckdetails.js" language="javascript"></script>';


if ($sessPaidStatus==1) {

/*$varCondition				= " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields					= array('MatriId');
$memAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
$memAstroDetails			= mysql_fetch_array($memAstroExe);
if(!empty($memAstroDetails))
		$memberhas = 1;*/

//Check the gender.
$varFields					= array('Gender');

$varCondition	            = " WHERE MatriId = ".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$memResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
$memResultArr       		= mysql_fetch_assoc($memResult);
$membergender               = trim($memResultArr["Gender"]);
if($membergender==1)$membergender="M";
else $membergender="F";
			
// selecting the datafor preselecting horomatch setting starts
$varCondition	= " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
$varFields	= array('StarCheck','KujaCheck','DasaCheck','PapaCheck');
$varExecute	= $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
$varMyInfo	= mysql_fetch_array($varExecute);
$stchk1 = $varMyInfo['StarCheck'];
if($stchk1 == 1){$stchk = "S1";}
elseif($stchk1 == 2){$stchk = "S2";}
elseif($stchk1 == 3){$stchk = "S3";}
elseif($stchk1 == 4){$stchk = "S4";}
$kjchk = "K".$varMyInfo['KujaCheck'];
$Daschk = $varMyInfo['DasaCheck'];
if($Daschk == 0){$Daschk = "D00";}
elseif($Daschk == 1){$Daschk = "D03";}
elseif($Daschk == 2){$Daschk = "D06";}
$Papchk = "P".$varMyInfo['PapaCheck'];	


/*$varCondition				= " WHERE MatriId='".$varPartnerId."'";
$varFields					= array('MatriId');
$partAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
$partAstroDetails			= mysql_fetch_array($partAstroExe);
if(!empty($partAstroDetails))
		$partnerhas = 1;*/

//Check the gender.
$varFields					= array('Gender');
$varCondition	            = " WHERE MatriId = ".$objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB);
$partResult					= $objSlaveDB->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
$partResultArr       		= mysql_fetch_assoc($partResult);
$partnergender              = trim($partResultArr["Gender"]);
if($partnergender==1)$partnergender="M";
else $partnergender="F";

$domainarr  = explode('/',$confValues['DOMAINCONFFOLDER']);
$domainname = ucwords($domainarr[1]);
?>
<!--Quick Links-->
<div class="normtxt1 clr2 padb5"><font class="clr bld">AstroMatch</font></div>
	<div class="linesep"><img src="<?=$confValues["IMAGEURL"];?>/images/trans.gif" width="1" height="1"></div><br clear="all">

<!-- Content Area -->
<div style="width:543px;">
	<div class="bl"><div class="br">
	 <div style="padding:0px 17px 10px 17px;">

	 <div style="padding:0px 15px 10px 15px;">
	 	<!-- Middle form start -->
		<form name="frm"  method="post" action="index.php?act=horomatchcomposexml" accept-charset="ISO-8859-1" style="margin:0px;">
        <?php 
		if($membergender == $partnergender) 
		{
		echo "<script>expopupgender();</script>";
		echo '<div><table border="0" cellpadding="5" cellspacing="0"  align="left">
		<tr><td valign="top" width="20"><br></td>
			<td valign="middle" class="smalltxt"><br>Sorry, matching horoscopes of the same gender is not permitted on our site.</td></tr></table></div>';
		$exitstatus = 1;
		}
		else
		{
		
		$varCondition	     = " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
		$varFields	         = array('TotalMatchNos','NumbersLeft');
		$memAstroExe	     = $objSlaveDB->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
		$memAstroDetails	 = mysql_fetch_array($memAstroExe);
		$totalcnt            = $memAstroDetails["NumbersLeft"];

		if(!empty($memAstroDetails))
		{
			//check whether this member has already matched this partner...
			$alreadyexist = 0;
			$varCondition	     = " where MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB)." and PartnerId= ".$objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB);
		    $varFields	         = array('MatriId');
		    $memMatchExe	     = $objSlaveDB->select($varTable['ASTROMATCHPARTNER'], $varFields, $varCondition,0);
			$memMatchDetails     = mysql_fetch_array($memMatchExe);

			if(!empty($memMatchDetails))
				$alreadyexist = 1;

			//subscribed.. check whether the match count available...
			
			if($totalcnt > 0 || $alreadyexist == 1) //if count > 0 or if the member has already matched then allow...
			{
		  ?>
		  <div class='normtxt clr lh16'>
		  <div class='bld normtxt clr'>Real Time Horoscope Matching</div>
		  <div style="text-align:justify; padding:7px 0px 0px 0px;">Now you can do real time horoscope matching with a prospective life partner to find out how compatible you are as a couple. You can get your reports in 3 different formats (North, South and West) and also in 6 different languages English, Tamil, Malayalam, Hindi, Kannada and Telugu. More languages will be added shortly.</div>
          <div style="text-align:justify; padding:10px 0px 0px 0px;">AstroMatch is based on place, date and time of birth. <?=$domainname;?>Matrimony has these details only for those members who have generated their horoscope through our system.</div>

		  <div style="text-align:justify; padding:10px 0px 0px 0px;">
		    <div style="float:left;"><img src="<?=$confValues["IMAGEURL"]."/images/genhoros.gif";?>"  hspace="3" align="absbottom" alt="Scanned horoscope"></div>
			<div style="float:left; width:440px; text-align:justify; padding-left:5px;">Denotes that member has generated a horoscope through <?=$domainname;?>Matrimony which means you can do an instant AstroMatch.</div>
		  </div>

		  <div style="float:left; padding:12px 0px 0px 0px;">
			<div style="float:left;"><img src="<?=$confValues["IMAGEURL"]."/images/horoscope.gif";?>"  hspace="3" alt="Computer generated horoscope"></div>
			<div style="float:left; width:440px; text-align:justify; padding-left:5px;">Denotes that member has added a scanned horoscope. In this case <?=$domainname;?>Matrimony does not have their place, date and time of birth details. To match against this member you need to enter his/her details, which maybe available in the scanned horoscope or you can request member for their details.</div>

		 </div><br clear="all">

		  <div style="padding:12px 0px 0px 0px;">
		  <div style="padding:2px 0px 2px 10px; background-color:#efefef;" class="brdr">Currently you have <?php echo $totalcnt; ?> AstroMatches remaining</div></div>
		  <div id="newdiv" style="padding:12px 0px 0px 0px;" class="fleft"> 
		  <?php
			$title = "Your details";
			$varCondition				= " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
			$varFields					= array('MatriId');
			$memAstroExe				= $objSlaveDB->select($varTable['ASTROMATCH'], $varFields, $varCondition,0);
			$memAstroDetails			= mysql_fetch_array($memAstroExe);
			

			if(!empty($memAstroDetails))
			{
				//This is to check whether the member has horodetails to give height for the html table in horomatchfunctions.php
				$varCondition	= " WHERE MatriId=".$objSlaveDB->doEscapeString($sessMatriId,$objSlaveDB);
				$varFields	    = array('MatriId','BirthCity','BirthDay','BirthMonth','BirthYear','BirthLongitude','BirthLatitude');
				$varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
				$memHoroDet	    = mysql_fetch_array($varExecute);
				
				//Display form if any of these values are zero.
				if(trim($memHoroDet["BirthDay"])==0 || trim($memHoroDet["BirthMonth"])==0 || trim($memHoroDet["BirthYear"])==0 || trim($memHoroDet["BirthCity"])=="0" || trim($memHoroDet["BirthLongitude"])=="" || trim($memHoroDet["BirthLatitude"])=="")
				{   
					
					echo displayAstroTable($title,$sessMatriId,$membergender,$objSlaveDB); //display-fields with values
				}
				else
				{   
					echo displayAstroTable($title,$sessMatriId,$membergender,$objSlaveDB); //display-fields with 
				}

			}
			else
			{       
					echo displayAstroTable($title,$sessMatriId,$membergender,$objSlaveDB);
			}
		  ?>
		  </div>
		  <div class="fleft" width="13"><img src="<?=$confValues["IMAGEURL"]."/images/trans.gif";?>" width="13" height="1"></div>
		  <div class="fleft" style="padding:12px 0px 0px 0px;">

		 <?php
			$title = "Partner details";
			$varCondition	= " WHERE MatriId=".$objSlaveDB->doEscapeString($varPartnerId,$objSlaveDB);
			$varFields	    = array('MatriId','BirthCity','BirthDay','BirthMonth','BirthYear','BirthLongitude','BirthLatitude');
			$varExecute	    = $objSlaveDB->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
			$datastro	    = mysql_fetch_array($varExecute);

			if(!empty($datastro))
			{
				//This member has applied for horoscope.
				//Display form if any of these values are zero.
				if(trim($datastro["BirthDay"])==0 || trim($datastro["BirthMonth"])==0 || trim($datastro["BirthYear"])==0 || trim($datastro["BirthCity"])=="0" || trim($datastro["BirthLongitude"])=="" || trim($datastro["BirthLatitude"])=="")
				{
				echo displayAstroTableNew($title,$varPartnerId,$partnergender,$objSlaveDB);
				}
				else
				{//display the values without form.						
				echo displayAstroTableNewValue($title,$varPartnerId,$partnergender,$objSlaveDB);
				}
			}
			else
			{
				//This member has not applied yet.
				echo displayAstroTableNew($title,$varPartnerId,$partnergender,$objSlaveDB);
			}
		  ?>
          </div>
		  <?php
			}// end totalcnt check
			else
			{
				echo "<script>expopupcnt('".$confValues['SERVERURL']."',".$datastropack["TotalMatchNos"].");</script>";
				$exitstatus = 1;
			}
		   }//db5 payment check end.
			else
			{
			echo "<script>resizeToSmall();</script>";
			echo "<script>expopupsub('".$confValues['SERVERURL']."');</script>";
			$exitstatus = 1;
			}
			echo "</div><br clear=all>";
			}//end gender check
		?>
		  
<!--Middle form end -->
<?php if($exitstatus == 0) { ?>
<div>
<div style="width:481px;">
<div style="padding-top:10px;"><font class="mediumtxt "><b>Report Type</b></font></div>

<div class="dottedline" style="background: url('<?=$confValues["IMAGEURL"]."/images/dot.gif";?>') repeat-x 0px 3px;">

		
		
		<?php
		$astrotable .='
		<div style="float:left;width:260px;"><div class="smalltxt" style="padding-top:10px;"><b>Report Type</b></div><div class="smalltxt">
		<select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="REPORT_TYPE" size="1">
		 <option value="1" selected>Soulmate Porutham Detailed</option>
		 <option value="0" >Soulmate Porutham Summary</option></select></div></div>	
		<div style="float:left;">					
			<div class="smalltxt " style="padding-top:10px;"><b>Report Language</b></div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="REPORT_LANGUAGE" size="1">';

		$astrotable .='<option  value="ENG"';
			if("ENG" == $reportlangarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>English</option>
			<option  value="MAL"';
			if("MAL" == $reportlangarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>Malayalam</option>
			<option  value="TAM"';
			if("TAM" == $reportlangarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>Tamil</option> 

			<option  value="HIN"';
			if("HIN" == $reportlangarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>Hindi</option> 

			<option  value="KAN"';
			if("KAN" == $reportlangarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>Kannada</option> 

			<option  value="TEL"';
			if("TEL" == $reportlangarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>Telugu</option> ';

			$astrotable .='</select></div>						
		</div> <br clear="all">
		<div><img src="'.$confValues["IMAGEURL"]."/images/trans.gif".'" width="5"></div>

		<div style="float:left;width:260px;">
			<div class="smalltxt " style="padding-top:10px;"><b>Chart Format</b></div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="REPORT_CHART_FORMAT" size="1" onchange="ch_method()">
			<option value="0"';
			if(0 == $chartformatarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>South Indian</option>
			<option value="1"';
			if(1 == $chartformatarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>North Indian</option>
			<option value="2"';
			if(2 == $chartformatarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>East Indian</option>
			<option value="3"';
			if(3 == $chartformatarray[$domainlangpartnerid])
				$astrotable .=" Selected";
		$astrotable .= '>Kerala</option>
			<option value="1" >South Indian</option>
		</select></div>
		</div>
		<div style="float:left;">					
			<div class="smalltxt " style="padding-top:10px;"><b>Method</b></div>
			<div class="smalltxt">';
			if($stchk1 == 0) {
				$astrotable .='<select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="METHOD" size="1"><option  value="S1"';
				if("S1" == $astromethodarray[strtolower($domainlangmemberid)])
				$astrotable .=" Selected";
				$astrotable .= '>Kerala System</option>
				<option  value="S2"';
				if("S2" == $astromethodarray[strtolower($domainlangmemberid)])
				$astrotable .=" Selected";
				$astrotable .= '>TamilNadu System</option>
				<option  value="S3"';
				if("S3" == $astromethodarray[strtolower($domainlangmemberid)])
				$astrotable .=" Selected";
				$astrotable .= '>GunaMilan System</option>';
				$astrotable .= '</select>';
			}else{
				$astrotable .='<select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="METHOD" size="1"><option  value="S1"';
				if($stchk == "S1")
				$astrotable .=" Selected";
				$astrotable .= '>Kerala System</option>
				<option  value="S2"';
				if($stchk == "S2")
				$astrotable .=" Selected";
				$astrotable .= '>TamilNadu System</option>
				<option  value="S3"';
				if($stchk == "S3")
				$astrotable .=" Selected";
				$astrotable .= '>GunaMilan System</option>
				<option  value="S4"';
				if($stchk == "S4")
				$astrotable .=" Selected";
				$astrotable .= '>North Indian</option>';
				$astrotable .= '</select>';
			}
			$astrotable .='</div>						
		</div><br clear="all">
	</div>
	<div><img src="'.$confValues["IMAGEURL"]."/images/trans.gif".'" width="10"></div>

<div class="brdr" id="advopt"><div style="background-color:#EFEFEF;padding-left:5px;padding-top:5px;padding-bottom:5px;"><font class="smalltxt boldtxt"><b>Would you like to compare more fields like KujaDosha, PapaSamya and DasaSandhi?</b></font><br><a href="javascript:opendiv()" class="clr1"><font class="smalltxt">For In-depth Horoscope Match, Click here</font></a></div></div>';
 $astrotable .='<div id="advopt1" style="display:none;">
	<div style="background-color:#EFEFEF;padding-left:5px;padding-top:5px;padding-bottom:5px;" class="brdr"><font class="smalltxt "><b>Would you like to compare more fields like KujaDosha, PapaSamya and DasaSandhi?</b></font><br><a href="javascript:hclosediv()" class="clr1"><font class="smalltxt">For In-depth Horoscope Match, click here</font></a></div>

	<div style="float:left;width:260px;"><div class="smalltxt " style="padding-top:10px;"><b>KujaDosha</b></div><div class="smalltxt">
		
		<select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="KUJADOSHA" size="1">
		 <option value="K0"';
		if($kjchk == "K0")
		$astrotable .=" Selected";
		$astrotable .= '>No KujaDosha Check</option>
			<option value="K1"';
		if($kjchk == "K1")
		$astrotable .=" Selected";
		$astrotable .= '>Ordinary Check</option>
			<option value="K2"';
		if($kjchk == "K2")
		$astrotable .=" Selected";
		$astrotable .= '>Strict Check</option>
		</select>
		</div></div>	
	
		<div class="fleft">					
			<div class="smalltxt " style="padding-top:10px;"><b>PapaSamya</b></div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="PAPASAMYA" size="1">
			<option value="P0"';
		if($Papchk == "P0")
		$astrotable .=" Selected";
		$astrotable .= '>No PapaSamya Check</option>
			<option value="P1"';
		if($Papchk == "P1")
		$astrotable .=" Selected";
		$astrotable .= '>Ordinary Check</option>';
		$astrotable .='</select></div>						
		</div><br clear="all">
	
		<div style="float:left;">
			<div class="smalltxt " style="padding-top:10px;"><b>DasaSandhi</b></div>
			<div class="smalltxt"><select  style="width:206px;font-family:Verdana, arial, Verdana, sans-serif;font-size:8pt" NAME="DASASANDHI" size="1" onchange="ch_method()">
			<option value="D00"';
			if($Daschk == "D00")
			$astrotable .=" Selected";
			$astrotable .= '>No DasaSandhi Check</option>
			<option value="D03"';
			if($Daschk == "D03")
			$astrotable .=" Selected";
			$astrotable .= '>Ordinary Check</option>
			<option value="D06"';
			if($Daschk == "D06")
			$astrotable .=" Selected";
			$astrotable .= '>Strict Check</option>
			</select></div>						
		</div>';
	$astrotable .='</div></div><br clear="all">';

		echo $astrotable;
	?>
	<div class="fright" style="padding-top:10px;"><input type="hidden" name="domurl" value="PROFILE.TAMILMATRIMONY.COM"><INPUT TYPE="button" value="Match Horoscope" name="next" onclick="processpage();" class="button"></div><br clear="all">
	<?php 
	} //end exitstatus check 
    $objSlaveDB->dbClose(); // Slave Connection Closed Here...

}

else
{
?>
	<div><table border="0" cellpadding="5" cellspacing="0"  align="left">
		<tr>
			<td valign="top" width="20"><br><img src="<?=$confValues["IMAGEURL"]."/images/warndelicon.gif";?>" hspace="5" vspace="2"></td>
			<td valign="middle" class="smalltxt"><bR><br>You are either logged off or your session timed out. <a href="<?=$confValues['SERVERURL']."/login/index.php?act=login";?>" class="linktxt">Click here</a> to login.</td>
		</tr>
   </table></div>
<?php
}
?>

</form>
</div>
</div><br clear="all">
</div></div>	
</div>	</div>
<!-- Content Area -->
</div>	
</div>

