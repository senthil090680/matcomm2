<?php

//FILE INCLUDES
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
include_once($varRootBasePath.'/lib/clsDomain.php');
include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/conf/vars.cil14');
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath.'/conf/ppinfo.cil14');
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');
include_once($varRootBasePath.'/lib/clsSrchBasicView.php');
include_once($varRootBasePath.'/www/sphinx/sphinxgetprofile.php');

//SESSION OR COOKIE VALUES
$sessMatriId		= $varGetCookieInfo["MATRIID"];
$sessGender			= $varGetCookieInfo["GENDER"];
$sessPublish		= $varGetCookieInfo["PUBLISH"];
$sessPaidStatus		= $varGetCookieInfo["PAIDSTATUS"];
$sessGothramId		= $varGetCookieInfo['GOTHRAM'];

//OBJECT DECLARATION
$objProfileDetail	= new MemcacheDB;
$objDomain			= new domainInfo;
$objSearchView		= new SrchBasicView;

$varMatriId			= trim($_REQUEST['id']);

// DB CONNECTION
$objProfileDetail-> dbConnect('S',$varDbInfo['DATABASE']);

//EDUCATION MAPING
function similareducation($gender,$education) {
	global $arrPPMaleEducation,$arrPPFemaleEducation;
	if($gender==1) {
		$mapeducation = $arrPPMaleEducation[$education];
	} else {
		$mapeducation = $arrPPFemaleEducation[$education];
	}
	return $mapeducation ;
}

//MEMBER PHOTO URL
function getPhoto($argOppositeId) {
	global $varTable,$confValues,$objProfileDetail;
	$funPhotoPath	= array();
	$funOppositeId	= $argOppositeId;
	$funFields		= array('MatriId','Normal_Photo1');
	$funCondition	= "WHERE MatriId IN ('".join("', '", $argOppositeId)."')";
	
	$resPhotoIdsDet	= $objProfileDetail->select($varTable['MEMBERPHOTOINFO'], $funFields, $funCondition, 0);
	while($row = mysql_fetch_assoc($resPhotoIdsDet)) {
		$funPhotoPath[$row['MatriId']]       = $confValues['PHOTOURL'].'/'.$row['MatriId']{3}.'/'.$row['MatriId']{4}.'/'.$row["Normal_Photo1"];
	}
	return $funPhotoPath;
}

//LOGIN MEMBER DETAILS
$sessFilds = array('Age','Gender','Height','Education_Category','GothramId');
$sessCondition = "where matriid=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail);
$arrSessFields = $objProfileDetail->select($varTable['MEMBERINFO'], $sessFilds, $sessCondition, 0);
while($arrRes = mysql_fetch_assoc($arrSessFields)) {
	$varSessAge			= $arrRes["Age"];
	$varSessGender		= $arrRes["Gender"];
	$varSessHeight		= $arrRes["Height"];
	$varSessEducation	= $arrRes["Education_Category"];
}

$varMemberFields = array('MatriId','CommunityId','Age','Gender','Height','Education_Category','Religion','CasteId','Mother_TongueId','GothramId','Country','Physical_Status','Residing_Area','Photo_Set_Status ');
$varCondition = "where matriid=".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);

$arrSelectFields = $objProfileDetail->select($varTable['MEMBERINFO'], $varMemberFields, $varCondition, 0); 

while($arrGetRes = mysql_fetch_assoc($arrSelectFields)) {
	$matriid			= $arrGetRes['MatriId']; 
	$communityid		= $arrGetRes['CommunityId'];    
	$age				= $arrGetRes['Age'];              
	$gender				= $arrGetRes['Gender'];           
	$height				= $arrGetRes['Height'];       
	$educationcategory  = $arrGetRes['Education_Category'];
	$religion			= $arrGetRes['Religion'];
	$casteid			= $arrGetRes['CasteId'];
	$mothertongueid		= $arrGetRes['Mother_TongueId'];
	$gothramid			= $arrGetRes['GothramId'];
	$country			= $arrGetRes['Country'];     
	$physicalstatus 	= $arrGetRes['Physical_Status'];  
	$residingarea		= $arrGetRes['Residing_Area'];    
	$photostatus		= $arrGetRes['Photo_Set_Status'];
	
	//AGE CONDITION
	if($age !='') {
		if($gender==1) { //MALE
			$startAge	= ($age-2);
			$varStAge	= ($startAge > 21 && $startAge > $varSessAge) ? $startAge : $varSessAge;
			$toAge		= ($age+2);
			$varToAge	= ($toAge > $varSessAge)? $toAge:$varSessAge ;
		} else { // FEMALE
			$varStAge	= $age-2;
			$varStAge	= ($varStAge > 18 && $varStAge < $varSessAge ) ? $varStAge : $varSessAge;
			$toAge		= ($age+2);
			$varToAge	= ($toAge < $varSessAge)? $toAge:$varSessAge ;
		}
	}
	
	//HEIGHT CONDITION
	if($height!='') {
		if($gender==1) { //MALE
			$startHeight = ($height - 15);
			$varStHeight = ($startHeight > $varSessHeight ) ? $startHeight : $varSessHeight;
			$toHeight    = $height+15;
			$varToHeight = ($toHeight > $varSessHeight)? $toHeight:$varSessHeight;
		} else { //FEMALE
			$startHeight = ($height - 15);
			$varStHeight = ($startHeight > 121.91 && $startHeight < $varSessHeight ) ? $startHeight : $varSessHeight;
			$toHeight    = ($height + 15);
			$varToHeight = ($toHeight < $varSessHeight)? $toHeight:$varSessHeight;
		}
	}
	
	//GOTHRAM ID
	$varGothram = $objDomain->useGothram();
	if($varGothram==1) {
		$gothram = $sessGothramId;
	} else {
		$gothram = 0;
	}
	
	//EDUCATION MAPPING
 	$education = similareducation($gender,$varSessEducation); 

	//*********** SPHINX QUERY ***************************//
	$arrForSphinx['matriid']		= $matriid;
	$arrForSphinx['gender']			= $gender;
	$arrForSphinx['ageFrom']		= $varStAge;
	$arrForSphinx['ageTo']			= $varToAge;
	$arrForSphinx['heightFrom']		= $varStHeight;
	$arrForSphinx['heightTo']		= $varToHeight;
	$arrForSphinx['motherTongue']	= $mothertongueid;
	$arrForSphinx['religion']		= $religion;
	$arrForSphinx['caste']			= $casteid;
	$arrForSphinx['gothram']		= $gothram;
	$arrForSphinx['physicalStatus'] = $physicalstatus;
	$arrForSphinx['country']		= $country;
	$arrForSphinx['education']		= $education;
		
	$varResultArray = getSimilerProfiles($arrForSphinx,$communityid,$gender);

    $totalRecord = count($varResultArray);

	if($totalRecord >=4 && $varSessGender!=$gender) { ?>
	<div style="width:192px;height:380px;" class="fright">
        <div style="width:192px;border:1px solid #CBCBCB;float:left;">
        <div class="bld smalltxt mymgnt5" style="height:20px;">You might also be interested in</div>
        <div style="width:178px;border:1px solid #CBCBCB;padding-top10px;float:left;margin-left:6px;display:inline;">
           <div style="width:178px;margin-top:10px;float:left;">
		<?		      
			//PHOTO URL
			$arrOppId=array_keys($varResultArray);
			$arrPhotoDet = getPhoto($arrOppId);
			
			$varPhotoNo=0;
			foreach ($varResultArray as $val) {
				$varMatriId		= $val['MatriId'];
				$varAge			= $val['Age'];
				$arrHeight		= $objSearchView->getHeightInFeet($val['Height']);
				$varHeight      = explode('/',$arrHeight);
				$varCountry		= $val['Country'];
				$varState		= ($varCountry==98)? $arrResidingStateList[$val['Residing_State']] : $arrCountryList[$val['Country']];
				$varPhotourl    = $arrPhotoDet[$varMatriId];  //PHOTO URL
			
				if($varPhotoNo==0 || $varPhotoNo==2){?>
				 <div>
				 <?}?>
			   <div align="center" style="width:88px;float:left;">
                    <div align="center"><a href="/profiledetail/index.php?act=fullprofilenew&id=<?=$varMatriId?>"><img src="<?=$varPhotourl?>" width="74" height="75" style="border:0px;"/></a></div>
                    <div class="bld smalltxt"><?=$varMatriId;?></div>
                    <div class="smalltxt"><?=$varAge;?> yrs, </div>
                    <div class="smalltxt"><?=$varHeight[0];?></div>
                    <div class="smalltxt"><?=($varState!='')?$varState : '&nbsp;';?></div>
                    <div class="smalltxt" style="height:25px;"><a href="/profiledetail/index.php?act=fullprofilenew&id=<?=$varMatriId?>" target="_blank" class="clr1">Full Profile >></a></div><div class="cleard"></div>
               </div>
			  <? if($varPhotoNo==1 || $varPhotoNo==3){	?>
				 </div><br clear="all">
				 <?	}
    				$varPhotoNo++;
				}?>
			</div>
		 </div>
		 <div style="width:192px;height:7px;float:left;">&nbsp;</div>
		</div>
        
	</div><br clear="all"><br clear="all">
<?
   }
}

?>