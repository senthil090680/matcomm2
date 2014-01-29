<?php
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/vars.cil14");
include_once($varRootBasePath.'/'.$confValues['DOMAINCONFFOLDER'].'/conf.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsSearch.php");
include_once($varRootBasePath.'/lib/clsBasicviewCommon.php');
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/lib/clsCache.php');

//SESSION OR COOKIE VALUES
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessGender		= $varGetCookieInfo["GENDER"];
$varDomainId	= $confValues['DOMAINCASTEID'];

//OBJECT DECLARTION
$objDomainInfo	= new domainInfo;
$objCommon		= new clsCommon;
$objSearch		= new Search;
$objBasicComm	= new BasicviewCommon;

//SORT CONF ARRAYS
asort($arrEducationList);
asort($arrCountryList);
asort($arrTotalOccupationList);

//VARIABLE DECLARATION
$varCurrentDate	= date('Y-m-d H:i:s');
$varSrchType	= trim($_POST["srchType"]);
$varSrchName	= trim($_POST["searchName"]);
$varOldSrchName	= trim($_POST["oldsrchName"]);
$varSrchId		= trim($_REQUEST["srchId"]);
$varSaveSrch	= trim($_POST["saveSrch"]);
$varSrchOldWC	= trim($_POST["wc"]);
$varSrchFWC		= trim($_POST["fwc"]);
$varSrchfwcEnab	= trim($_POST["fwcEnab"]);
$varSrchNewWC	= trim($_POST["newval"]);

$varDomainName	= $confValues['DOMAINNAME'];
$varErrorMsg	= "";
$varContIds		= "";
$objSearch->formDefaultValues();


$varMStAge	= $objDomainInfo->getMStartAge();
$varMEdAge	= $objDomainInfo->getMEndAge();
$varFMStAge	= $objDomainInfo->getFStartAge();
$varFMEdAge	= $objDomainInfo->getFEndAge();

if($_POST['gender'] == 1 || $sessGender==2){
$varOppGen	= 1;
$varMaleChk = 'checked';
$varStAge	= $varMStAge;
$varEdAge	= $varMEdAge;
}else{
$varFemaleChk= 'checked';
$varOppGen	= 2;
$varStAge	= $varFMStAge;
$varEdAge	= $varFMEdAge;
}

//Gender based occupation changes for Defence matrimony
if($varDomainId == 2006){
	asort($arrMaleDefenceOccupationList);
	asort($arrFemaleDefenceOccupationList);
	$arrTotalOccupationList = $varOppGen==2 ? $arrFemaleDefenceOccupationList : ($varOppGen==1 ? $arrMaleDefenceOccupationList : $arrFemaleDefenceOccupationList);
}

//DB Connection
$objSearch->dbConnect('M', $varDbInfo['DATABASE']);

$varFaceAdded = 0;
if($varSrchOldWC!='' && $varSrchNewWC!=''){
	$varSrchOldWC = $objBasicComm->decryptData($varSrchOldWC);
	$arrOldValues = $objBasicComm->getTempPostValues($varSrchOldWC);
	$arrMoreVals    = split('#\^#', $varSrchNewWC);
	foreach($arrMoreVals as $varSinMoreVal){
		if($varSinMoreVal!='' && preg_match("/=/", $varSinMoreVal)){
		$arrNewVal	= split('=', $varSinMoreVal);
		$arrOldValues[$arrNewVal[0]] = trim($arrNewVal[1], '~');

		if($arrNewVal[0]=='country'){
			if($arrOldValues['residingState']!='' || $arrOldValues['residingCity']!=''){
				unset($arrOldValues['residingState']); unset($arrOldValues['residingCity']);
			}
		}else if($arrNewVal[0]=='residingState'){
			//Check India or US State
			$arrFaceStates = split('~', $arrNewVal[1]);
			$varINDEnal = 0;
			$varUSAEnal = 0;
			
			foreach($arrFaceStates as $sinFaceState){
				if($sinFaceState>100){$varUSAEnal = 1;}else{$varINDEnal = 1;}
			}
			
			if($varINDEnal==1 || $varUSAEnal==1){
				if($varINDEnal==1){$arrOldCountries[]=98;}
				if($varUSAEnal==1){$arrOldCountries[]=222;}
				$varModifiedCtry = join('~', $arrOldCountries);
				$arrOldValues['country'] = $varModifiedCtry;
			}else{
				$arrOldValues['country'] = '';
			}

			if($arrOldValues['residingCity']!=''){
				unset($arrOldValues['residingCity']);
			}
		}else if($arrNewVal[0]=='residingCity'){
			//Check India or US State
			$arrFaceCities = split('~', $arrNewVal[1]);
			$varINDEnal = 0;
			$varUSAEnal = 0;
			
			$arrStateDet = array();
			foreach($arrFaceCities as $sinFaceState){
				$arrCityDet = split('#', $sinFaceState);
				$arrStateDet[$arrCityDet[0]]='';
			}
			$arrSelectedStates = array_keys($arrStateDet);
			
			if(count($arrSelectedStates)>0){
				$arrOldValues['residingState'] = join('~', $arrSelectedStates);
				$arrOldValues['country'] = '98';
			}
		}
		}
		$varFaceAdded = 1;
	}
	$varResponse = '';
	foreach($arrOldValues as $key=>$val){

		$varResponse .= $key.'='.$val.'#^#';
	}
	$varResponse = trim($varResponse, '#^#');
	$varCondition['LIMIT']	= $objBasicComm->encryptData($varResponse);
}else if($varSrchfwcEnab == 0){
	if($varSaveSrch == 'yes' && $varSrchName!='' && preg_match("/^[a-zA-Z0-9\\s]{1,14}$/", $varSrchName))
		$varResponse =  $objSearch->putSaveSrchData();
	else if(is_numeric($varSrchId))
		$varResponse = $objSearch->saveSearch($varSrchId) ;
	else if(strlen($_POST['ID'])>=9)
		$varResponse = $objSearch->viewSimilarProfile($_POST['ID']);
	else
		$varResponse = $objSearch->regSearch();

	//for saved search resubmit / refersh error
	if($objSearch->clsSearchErr==1){
		$varErrorMsg  = $varResponse;
		$varResponse = $objSearch->regSearch();
	}
	$varCondition['LIMIT']	= $objBasicComm->encryptData($varResponse);
}else if($varSrchfwcEnab == 1){
	$varSrchOldWC=='';
	$varCondition['LIMIT']	= $varSrchFWC;
}

$varFirstWC	= ($varSrchOldWC=='') ? $varCondition['LIMIT'] : $_POST["fwc"];

include_once($varRootBasePath.'/www/indiaproperty/propertydtls.php');

//UNSET OBJECT
$objSearch->dbClose();
unset($objBasicComm);
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/search.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/searchpaging.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchbasicview.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/priv_mat.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/opacity.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/animatedcollapse.js" ></script>
<script>
function stylechange(vl)
{
	if(vl==0)
	{$('conall').style.display='none';
 	 $('conall1').style.display='block';
	}
	else
	{$('conall').style.display='block';$('conall1').style.display='none';}
}

function sel(ID,G,cpno,load){
	$('fade').style.display='block';
	$('lightpic').style.display='block';
	viewrec = cpno;
	curroppid = ID; 
	ll();floatdiv('lightpic',lpos,50).floatIt();
    if(cook_id == '') {
	 // show login box //
	 document.frmLogin.reset();
	 document.getElementById('redirect').value='../profiledetail/index.php?act=fullprofilenew&id='+ID;
	}
	else {
	  var url		= ser_url+'/basicview/bv_action.php?rno='+Math.random();
	  param	= 'ID='+ID+'&G='+G+'&cpno='+cpno+'&module=search';

	  if(load == '1'){
		$('lightpic').innerHTML = '';
		$('lightpic').innerHTML = '<div style="text-align:center;"><img src="'+imgs_url+'/loading-icon.gif" height="38" width="45"></div>';}

	  objAjax = AjaxCall();
	  AjaxPostReq(url, param, actionScript,objAjax);
    }
}//sel

function selclose()
 {
 $('lightpic').style.display='none';
 $('fade').style.display='none';
 }


function actionScript(){

	if(objAjax.readyState == 4) {
		//alert(objAjax.responseText);
		$('lightpic').innerHTML = '';
		$('lightpic').innerHTML = objAjax.responseText;
		//$('lightpic').innerHTML = objAjax.responseText;
		//alert(objAjax.responseText);
	}//if
}//actionScript

</script>

<script>
	var MStAge=<?=$varMStAge;?>, MEdAge=<?=$varMEdAge;?>, FMStAge=<?=$varFMStAge;?>, FMEdAge=<?=$varFMEdAge;?>, selGender=<?=($_POST['gender']!='')? $_POST['gender'] : $varOppGen;?>;
	var rspgcnt = 'search';
</script>
<div id="srchrescenpart" style="float:left;width:560px !important;width:560px;">
 <div style="position:relative;width:560px;">
	<div style="width:560px;float:left">
		<div class="normtxt1 clr fnt17 bld fleft" style="width:200px;">Search Results</div>
	    <div class="fright" style="width:360px;">
		<div  class="fright" style="line-height: 11px;width:95px;padding-top:4px;">
			<a title="India Property - Indian Real Estate" alt="India Property - Indian Real Estate" style="text-decoration: none;" href="<?=$varIPLink?>" target="_blank" class="clr1 fright pntr"><b>New Properties</b><br>in <?=$varIPName?></a>
		</div>
		<div class="fright" style="font-size: 25px; line-height: 18px;padding-left:10px;padding-top:5px;">
			<a title="India Property - Indian Real Estate" alt="India Property - Indian Real Estate" style="text-decoration: none;" href="<?=$varIPLink?>" target="_blank" class="clr1 fleft pntr"><?=$varIPNewProjects?></a>
		</div>
		<div class="fright" style="width:105px;">
		<a title="India Property - Indian Real Estate" alt="India Property - Indian Real Estate" style="text-decoration: none;" href="<?=$varIPLink?>" target="_blank" class="smalltxt clr1 fright pntr"><img height="26" width="95" src="<?=$confValues["IMGSURL"]?>/homeimg/ip-logo-small.gif"></a>
	    </div>
	</div>
</div><br clear="all"><br>

	<div id="feaResArea">
	</div>

	<div class="smalltxt clr2 padtb5 fleft" id="srtopbt">
		<?if($sessMatriId != '' && $objSearch->clsSearchErr==0){ ?>
		<font class="clr">Select: </font>
		<a class="clr1" href="javascript:;" onclick="mult_chk(document.buttonfrm);">All</a> &nbsp|&nbsp;
		<a class="clr1"  href="javascript:;" onclick="mult_unchk(document.buttonfrm);">None</a>
		<? } ?>
	</div>
	<?if($sessMatriId != '' && $objSearch->clsSearchErr==0){ ?>
		<div id="actionpartdiv" class="fright padtb5">
			<div class="smalltxt clr2"><div class="fleft"><?if ($varPartialFlag=='0') { ?><font class="clr">Action:</font> <a class="clr1" onclick="sendListId('block','chk_all');">Block </a> &nbsp;|&nbsp; <? } ?><a class="clr1" onclick="sendListId('shortlist','chk_all');">Add to favourites</a>&nbsp;</div><div id="conall" class="fleft disblk" style="width:63px;">&nbsp;|&nbsp; <a class="clr1" onclick="chkMsgSelIds();">Contact all</a></div><div id="conall1" class="fleft disnon" style="width:63px;">&nbsp;<font class="clr">|</font>&nbsp; <a class="clr5" onclick="showdiv('contalldiv');stylechange(0);">Contact all</a></div> </div>
		</div>
	<? } ?><br clear="all"><br clear="all"><div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
	<!-- Error throw div -->
	<center><div id="listalldiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
	</div></center><div class="cleard"></div>
	<!-- Error throw div -->

	<center>
	<form name='frmSearchConds' id="frmSearchConds" action="" method="post" style="margin:0px;padding:0px;">
		<input type="hidden" name="htype_search" Value="<?=$_REQUEST['htype_search']?>">
		<input type="hidden" name="wc" Value="<?=$varCondition['LIMIT']?>">
		<input type="hidden" name="fwc" Value="<?=$varFirstWC;?>">
		<input type="hidden" name="fwcEnab" Value="0">
		<input type="hidden" name="faceAdded" Value="<?=$varFaceAdded;?>">
		<input type="hidden" name="srchId" Value="<?=$objSearch->clsNewSavedSrchId;?>">
		<input type="hidden" name="srchName" Value="<?=$varSrchName;?>">
		<input type="hidden" name="oldsrchName" Value="<?=$varOldSrchName;?>">
		<input type="hidden" name="srchType" Value="<?=$varSrchType;?>">
		<input type="hidden" name="casteTxt" Value="<?=$_POST['casteTxt'];?>">
		<input type="hidden" name="subcasteTxt" Value="<?=$_POST['subcasteTxt'];?>">
		<input type="hidden" name="gothramTxt" Value="<?=$_POST['gothramTxt'];?>">
		<input type="hidden" name="gender" Value="<?=$varOppGen;?>">
		<input type="hidden" name="newval" Value="">
		<input type="hidden" name="disppgval" Value="1">
		<input type="hidden" name="act" Value="srchresult">
	</form>

	<div class="padt10">
		<div id='search_div'>
		<form name="buttonfrm" method="post" target="_blank" style="margin:0px;">
		<div id="srinnertopbt">
			<div id="total_div" class="fleft bld myclr fntsize padtb10"></div>
			<div id="prevnext" class="padtb5 fright" style="width:350px;"></div><br clear="all">
		</div>
		
		<?
			if($varDomainId==2503 || $varDomainId==2500){
			$topvalue='top:60px !important;top:60px;';
			}else if($varDomainId==2006){
			$topvalue='top:40px !important;top:40px;';
			}else {
			$topvalue='top:60px !important;top:60px;';
			}
		?>

		<div id="contalldiv" class="disnon brdr1 tlleft pad10 posabs bgclr2" style="width:540px !important;width:560px;left:0px;<?=$topvalue?>">
			<div class="fright tlright"><img onclick="hidediv('contalldiv');stylechange(1);" class="pntr" src="<?=$confValues['IMGSURL']?>/close.gif"/></div><br clear="all">
			<?include_once($varRootBasePath.'/www/search/contactall.php');?>
		</div>
		
		<div>
		<?php
		if($objSearch->clsSearchErr == 1){
			$objSearch->clsSearchErr = 0;
			echo '<font class="smalltxt errortxt">'.$varErrorMsg.'</font><BR><BR>';
		}
		?>
		</div>
		<div id="serResArea">
			<?if($objSearch->clsSearchErr == 0){?>
			<img src='<?=$confValues['IMGSURL']?>/trans.gif' width="1" height="1" onload="getResult('1');">
			<?}else{ echo '<font class="smalltxt">'.$varResponse.'</font><BR><BR>';}?>
		</div>
		</form><br clear="all" />
		<div id="prevnext1" class="padtb10"></div>
		</div><br clear="all" />
		<div id='viewprof_div'></div>
	</div>
	</div><br clear="all" /><br clear="all" />
</div>
<div id="fade" class="bgfadediv"></div>
<div id="lightpic" class="frdispdiv bgclr2 brdr1" style="width:520px;padding:10px;">

<? if($sessMatriId == '') { ?>
<div class="fright"><img class="pntr" src="http://img.communitymatrimony.com/images/close.gif" onclick="document.getElementById('fade').style.display='none';document.getElementById('lightpic').style.display='none';" /></div><br clear="all"><center><div style="width:504px;" class="tlleft">
            <div style="width:504px;float:left;">
                <div style="width:497px;height:193px;" class="bgclr2 fleft">
                <div style="width:450px;" class="mgnt17 mgnl23 fleft disline">
                    <div class="clr bld wdth450">Already a Member? Login</div>
                    <div class="dotsep3 mymgnt10 wdth450 hgt17"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" /></div>
                   <form name="frmLogin" method="post" action="../login/index.php?act=logincheck">
					<div class="wdth450">
                      <div style="width:398px;">
                          <div class="hgt33">
                              <div class="fleft wdth126"><div class="fright">Matrimony ID / Email</div></div>
                              <div class="fleft wdth15">&nbsp;</div>
                              <div class="fleft wdth156"><input type="text" name="idEmail" class="inptxtbor" /></div>
                              <div class="fleft">&nbsp;</div>
                          </div>
                          <div class="hgt33">
                              <div class="fleft wdth126"><div class="fright">Password</div></div>
                              <div class="fleft wdth15">&nbsp;</div>
                              <div class="fleft wdth156"><input type="password" name="password" class="inptxtbor" /></div>
                              <div class="fleft wdth98 padt5"><a href="../login/index.php?act=forgotpwd" class="clr7 smalltxt">Forgot Password?</a></div>
                          </div>
                          <div class="hgt33">
                              <div class="fleft wdth290"><div class="fright"><input type="submit" class="button1" value="Submit" /> </div></div>
                          </div>
						  <input type="hidden" name="frmLoginSubmit" value="yes">
						  <input type="hidden" name="redirect" id="redirect" value="">
						  </form>
                      </div>
                    </div>
                    <div class="dotsep3 wdth450 hgt10"><img src="http://img.communitymatrimony.com/images/trans.gif" height="1" width="1" /></div>
                    <div class="clr wdth450">Not a Member?&nbsp;<a href="../register" class="clr7 bld">Register FREE</a></div>
                </div>
            </div>
            </div>
        </div></center>
<? } ?>
</div>
</div>

<?php
unset($objSearch);
unset($objDomainInfo);
unset($objCommon);
?>