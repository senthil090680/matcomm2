<?php
/****************************************************************************************************
File	: horoscopematch.php
Author	: Raja P
Date	: 04-Jan-2010
*****************************************************************************************************
Description : Bulhoroscope compatibilty & AshtaKootaDashakoota Match
****************************************************************************************************/

// http://profile.tamilmatrimony.com/horoscope/horoscopematch.php?loginid=M1299441&htype=1&partnerid=M755559~M1161338
// http://www.agarwalmatrimony.com/horoscope/horoscopematch.php?loginid=AGR100156&htype=1&partnerid=AGR102240

// FILE INCLUDES

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/cookieconfig.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/lib/clsDB.php");

// SESSION VARIABLES
//$sessMatriId	= $varGetCookieInfo['MATRIID'];
$memberid	=	strtoupper(trim($_REQUEST['loginid']));
$partnerids	=	strtoupper(trim($_REQUEST['partnerid']));
$matchids	=	explode("~",$partnerids);
if(trim($_REQUEST['htype'])==1){
	$ashtamatch=1;
}elseif(trim($_REQUEST['htype'])==2){
	$dashamatch=1;
}
sort($matchids);

if(trim($memberid)!='') {

	$objProfileDetail = new db();
	$objProfileDetail->dbConnect('S', $varDbInfo['DATABASE']);
	if(!$objProfileDetail->error) {		
		if(count($matchids)==0) {
			echo 'ERR'; //Matching Ids Missing
			exit;
		}
		//check whether the member is having a computer generated horoscope.
		$varFields			= array('Horoscope_Available','Gender');
		$varCondition		= " WHERE MatriId=".$objProfileDetail->doEscapeString($memberid,$objProfileDetail);
		$varResult			= $objProfileDetail->select($varTable['MEMBERINFO'], $varFields, $varCondition,0);
		$row				= mysql_fetch_assoc($varResult);
		$horo_avail			= $row['Horoscope_Available'];
		if($row['Gender']==1){
			$membergender='M';
		}else{
			$membergender='F';
		}
		$numbersleft=0;
		if($horo_avail > 1) { //consider only 2 or 3

			$varCondition	= " WHERE MatriId=".$objProfileDetail->doEscapeString($memberid,$objProfileDetail);
			$varPhHoroCount	= $objProfileDetail->numOfRecords($varTable['ASTROMATCHPACKAGEDET'],'MatriId',$varCondition);
			
			if($varPhHoroCount>0) {
				$varFields			= array('NumbersLeft','TotalMatchNos');
				$varResult			= $objProfileDetail->select($varTable['ASTROMATCHPACKAGEDET'], $varFields, $varCondition,0);
				$astropackdet		= mysql_fetch_assoc($varResult);				
				$numbersleft=$astropackdet['NumbersLeft'];
				$totalnumbers=$astropackdet['TotalMatchNos'];
				$alreadydone=$totalnumbers-$numbersleft;				
			}
			// Master Data
			$varFields			= array('PlanetPositions','StarCheck','KujaCheck','DasaCheck','PapaCheck');
			$varResult			= $objProfileDetail->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
			$masterdata			= mysql_fetch_assoc($varResult);
			$masterdata['StarCheck']=($masterdata['StarCheck']==0)?'1':$masterdata['StarCheck'];
			$masterdata['KujaCheck']=($masterdata['KujaCheck']==0)?'1':$masterdata['KujaCheck'];
			$masterdata['DasaCheck']=($masterdata['DasaCheck']==0)?'1':$masterdata['DasaCheck'];
			$masterdata['PapaCheck']=($masterdata['PapaCheck']==0)?'1':$masterdata['PapaCheck'];
			$masterdata['PlanetPositions']=trim($masterdata['PlanetPositions']);	

			if(trim($masterdata['PlanetPositions'])=='') {
				echo 'ERR';
				exit;
			}

			// Slave Data	
			$matriid_text_array=array();
			foreach ($matchids as $matchid) {		
				if(trim($matchid)!='') {
					$matriid_text_array[]="'".$matchid."'";
				}
			}
			$matriid_text=implode($matriid_text_array,',');
			$varFields			= array('MatriId','PlanetPositions');
			$varCondition		= " WHERE MatriId in($matriid_text)";
			if($matriid_text!='') {
				$varResult			= $objProfileDetail->select($varTable['HORODETAILS'], $varFields, $varCondition,0);
				while($dathoro=mysql_fetch_assoc($varResult)){
					if(trim($dathoro['PlanetPositions'])!='') {
							$slavedata[$dathoro['MatriId']]=$dathoro['PlanetPositions'];
					}
				}
			}

			////////////////////////////////////////////////////////////////////////
			
			//$normalxml=framenormalxml();
			//$normalxmlresponse=getHoroCompatibility($normalxml);
			//$senddatanormal=showResult($normalxmlresponse,0);

			if($ashtamatch==1){
				$ashtaxml=frameashtadashaxml(1);
				$ashtaxmlresponse=getHoroCompatibility($ashtaxml);
				if($ashtaxmlresponse!=''){
					$senddataashta=showResult($ashtaxmlresponse,1);
					if($senddataashta!=''){
						echo $senddataashta;
					}else{
						echo 'ERR';
					}
				}else{
					echo 'ERR';
				}
			}elseif($dashamatch==1){
				$dashaxml=frameashtadashaxml(2);
				$dashaxmlresponse=getHoroCompatibility($dashaxml);
				if($dashaxmlresponse!=''){
				$senddatadasha=showResult($dashaxmlresponse,2);
				if($senddatadasha!=''){
					echo $senddatadasha;
				}else{
					echo 'ERR';
				}
				}else{
					echo 'ERR';
				}
			}else{
				echo 'ERR';
			}
		}else{
			echo 'ERR';
		}
	}else{
		echo 'ERR';
	}
}else{
	echo 'ERR';
}



function framenormalxml(){	
	global $masterdata,$slavedata,$membergender,$memberid;
	$PlanetPositions=trim($masterdata['PlanetPositions']);	
	$masterxmlmdata= "<PDATA><CNT>#SCOUNTER#</CNT><OPT><SCHK>".$masterdata['StarCheck']."</SCHK><PCHK>".$masterdata['PapaCheck']."</PCHK><KCHK>".$masterdata['KujaCheck']."</KCHK><DCHK>".$masterdata['DasaCheck']."</DCHK></OPT><MDATA><SEX>".$membergender."</SEX><DATA><1>$memberid".$masterdata['PlanetPositions']."</DATA></MDATA>#SDATA#</PDATA>";	
	$inc=0;	
	foreach($slavedata as $slavekey=>$slavevalue){
		$inc++;
		$slavexmldata.="<DATA$inc><1>$slavekey".$slavevalue."</DATA$inc>";
	}
	$slavexmldata='<SDATA>'.$slavexmldata.'</SDATA>';
	$finalxmldata = str_replace("#SDATA#",$slavexmldata,$masterxmlmdata);
	$finalxmldata = str_replace("#SCOUNTER#",$inc,$finalxmldata);	
	return $finalxmldata;
}

function frameashtadashaxml($ashtadasha) {	
	global $masterdata,$slavedata,$membergender,$memberid;
	$splitstarval='';
	$startpartarray=explode("<8>",$masterdata['PlanetPositions']);
	$splitstararray=explode("<9>",$startpartarray[1]);
	$splitstarval=$splitstararray[0];
	$masterxmlmdata="<PDATA><KOOTA>$ashtadasha</KOOTA><CNT>#SCOUNTER#</CNT><MDATA><SEX>$membergender</SEX><DATA><1>$memberid<2>$splitstarval</DATA></MDATA>#SDATA#</PDATA>";
	$inc=0;	
	foreach($slavedata as $slavekey=>$slavevalue){
		$inc++;
		$splitstarval='';
		$startpartarray=explode("<8>",$slavevalue);
		$splitstararray=explode("<9>",$startpartarray[1]);		
		$splitstarval=$splitstararray[0];
		$slavexmldata.="<DATA$inc><1>$slavekey<2>".$splitstarval."</DATA$inc>";	
	}
	$slavexmldata='<SDATA>'.$slavexmldata.'</SDATA>';
	$finalxmldata = str_replace("#SDATA#",$slavexmldata,$masterxmlmdata);
	$finalxmldata = str_replace("#SCOUNTER#",$inc,$finalxmldata);	
	return $finalxmldata;
}

function getHoroCompatibility($bulkcompatxml)
{
	global $HOROSERVER;
	//$url='http://'.$HOROSERVER['HORO64'].'/SMEXE/ProfileMatch.exe';	
	//$url="http://65.60.57.146/SMEXE/ProfileMatchAstaDasa.exe";
	$url="http://65.60.57.146/SMEXE/ProfileMatchasta.exe";
	$c1=curl_init();
	//echo $bulkcompatxml;
	curl_setopt($c1, CURLOPT_URL,$url);
	curl_setopt($c1, CURLOPT_HEADER, 0);
	curl_setopt($c1, CURLOPT_POST, 1);
	curl_setopt($c1, CURLOPT_TIMEOUT, 10);
	//echo $bulkcompatxml;
	curl_setopt($c1, CURLOPT_POSTFIELDS,"data=".$bulkcompatxml);
	curl_setopt($c1, CURLOPT_RETURNTRANSFER, 1);
	$output= urldecode(curl_exec($c1));	
	$info = curl_getinfo($c1);
	//http://in2.php.net/manual/en/function.curl-getinfo.php
	if($info['http_code']!=200) {		
		$output=getHoroCompatibilityAlt($bulkcompatxml);
	}
	return $output;
}

function getHoroCompatibilityAlt($bulkcompatxml)
{
	global $HOROSERVER;
	//$url='http://'.$HOROSERVER['HORO32'].'/SMEXE/ProfileMatch.exe';	
	//$url="http://65.60.57.146/SMEXE/ProfileMatchAstaDasa.exe";
	$url="http://65.60.57.146/SMEXE/ProfileMatchasta.exe";
	$c1=curl_init();
	curl_setopt($c1, CURLOPT_URL,$url);
	curl_setopt($c1, CURLOPT_HEADER, 0);
	curl_setopt($c1, CURLOPT_POST, 1);
	curl_setopt($c1, CURLOPT_TIMEOUT, 10);
	curl_setopt($c1, CURLOPT_POSTFIELDS,"data=".$bulkcompatxml);
	curl_setopt($c1, CURLOPT_RETURNTRANSFER, 1);
	$output= urldecode(curl_exec($c1));		
	$info = curl_getinfo($c1);
	if($info['http_code']!=200) {
		$output='';
	}
	return $output;
}

function showResult($str,$ashtakootavalue)
{
	global $pointsarray,$retpercent;
	$pointsarray=array();
	if(!($xml = simplexml_load_string($str))) {
		echo 'ERR';
		exit;
	}
	$totalrec = $xml->xpath('/ODATA/CNT');
	$mid = $xml->xpath("/ODATA/MREGNO");
	$matriid = $mid[0];
	$disparray=array();
	$dispcont='';
	$poorcounter=0;
	$averagecounter=0;
	$goodcounter=0;
	$excellentcounter=0;
	for($i=1;$i<=$totalrec[0];$i++)
	{
		if($ashtakootavalue==1 || $ashtakootavalue==2){
			$pper = $xml->xpath("/ODATA/RESULTDATA/DATA$i/TOT");
		}else{
			$pper = $xml->xpath("/ODATA/RESULTDATA/DATA$i/PPER");
		}		
		$mresult = $xml->xpath("/ODATA/RESULTDATA/DATA$i/MRESULT");	
		$rno = $xml->xpath("/ODATA/RESULTDATA/DATA$i/RNO");			
		$pointsarr=$xml->xpath("/ODATA/RESULTDATA/DATA$i/POINTS");			
		$retpercent=$pper[0];		
		$pointsarray=explode(',',$pointsarr[0]);
		if($ashtakootavalue==1){
			frameashtahtml();
			$disparray[]='~'.$rno[0].'~'.$retpercent.'~'.urlencode(base64_encode($pointsarr[0])).'~Horoscope Match: '.showCommentashta($retpercent).' ('.$retpercent.'/36)';
		}elseif($ashtakootavalue==2){
			framedashahtml();
			$disparray[]='~'.$rno[0].'~'.$retpercent.'~'.urlencode(base64_encode($pointsarr[0])).'~Horoscope Match: '.showCommentdasha($retpercent).' ('.$retpercent.'/44)';
		}else{
			$disparray[]=$rno[0].'~'.$retpercent.'~'.$mresult[0];
		}
		if($mresult[0]==0){
			$poorcounter++;
		}else if($mresult[0]==1){
			$averagecounter++;
		}else if($mresult[0]==2){
			$goodcounter++;
		}else if($mresult[0]==3){
			$excellentcounter++;
		}
	}

	$dispcont=implode("|",$disparray);
	if($dispcont!=''){
		if($ashtakootavalue==1){
			//$ashtahtml=frameashtahtml();
			//$dispcont=$dispcont.'~'.$ashtahtml;
		}elseif($ashtakootavalue==2){
			//$ashtahtml=frameashtahtml();
			//$dispcont=$dispcont.'~'.$ashtahtml;
		}
	}
	return $dispcont;
}

function showCommentashta($val){
	if($val > 23)
		return 'Good';
	else if($val >= 18 && $val <= 23)
		return 'Satisfactory';
	else if($val < 18)
		return 'Not Ok';
}

function showCommentdasha($val){
	if($val > 32)
		return 'Good';
	else if($val >= 22 && $val <= 32)
		return 'Average';
	else if($val < 22)
		return 'Not Ok';
}

function showComment($val){
	if($val == 0)
		return 'Poor';
	else if($val == 1)
		return 'Average';
	else if($val == 2)
		return 'Good';
	else if($val == 3)
		return 'Excellent';
}

function frameashtahtml(){
	global $confValues,$retpercent,$pointsarray,$partnerids,$numbersleft,$alreadydone,$varGetCookieInfo;
	foreach($pointsarray as $value) {
		$totalvalue=$totalvalue+$value;
	}
?>
<div style="padding:0px;"><font class="clr bld normtxt">Horoscope Match:</font> <font class="clr3 bld normtxt"><?=showCommentashta($retpercent)?> (<?=$retpercent?>/36)</font></div><br clear="all">
								<div class="normtxt lh20" style="padding:0px;">
										<?
							if($varGetCookieInfo['PAIDSTATUS']==1){
							
							echo 'Given below is the matching status based on the Ashtakoota - North Indian system of matching. A score of 18 and above is considered desirable.<br />Ashtakoota uses 8 key factors to analyze the levels of compatibility between two people.';							

							}else{

							echo 'The Ashtakoota is a North Indian format of matching and uses 8 key factors to analyze the levels of compatibility between a male and female, the higher the score the better the compatibility. A score of 18 and above is considered desirable.';
							}
							?>
								
		
		</div><br clear="all">
								
								<? if($varGetCookieInfo['PAIDSTATUS']==1){ ?>
								<div style="width:420px;background-color:#ffffff;" class="tlleft">
									<div style="padding:10px 15px;" class="normtxt clr bld">Ashtakoota Matching</div>
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:7px;" class="normxt clr bld tlleft fleft">Koot</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:30px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="30" width="1" /></div>
									<div style="width:124px !important;width:139px;padding-left:15px;padding-top:7px;" class="normxt clr bld tlleft fleft">Marks gained</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:30px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="30" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:7px;" class="normxt bld tlleft fleft">Area of life</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Varna</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[0]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Work</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Vashya</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[1]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Dominance</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Tara</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[2]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Destiny</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Yoni</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[3]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Mentality</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Grahamaitri</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[4]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Compatibility</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Gana</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[5]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Guna level</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Bhakoot</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[6]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Love</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Nadi</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:104px !important;width:139px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[7]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:115px !important;width:130px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Health</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="padding:10px 15px;" class="normtxt clr bld">Total marks out of 36<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="55" /><?=$totalvalue?></div>
								</div><? } ?>
								<br clear="all">
								<?php
								if($numbersleft>0 && $varGetCookieInfo['PAIDSTATUS']==1) {
								?>
								
								<div class="normtxt lh20" style="padding:0px 15px;">Horoscope matching already done - <?=$alreadydone?><br/>Horoscope matching balance - <?=$numbersleft?><br><a target="_blank" href="<?=$confValues['IMAGEURL']?>/horoscope/horomatchcheckdetails.php?partnerId=<?=$partnerids?>" class="clr1">Click here to view detailed horoscope matching report</a>.</div>

								<? }else{ ?>
								
								<div class="normtxt lh20" style="padding:0px 15px;">To view a detailed horoscope matching report you must subscribe to AstroMatch-Real time horoscope matching service<br><a target="_blank" href="<?=$confValues['SERVERURL']?>/payment/index.php?act=additionalpayment&astro=1" class="clr1">Click here to subscribe</a>.</div>

								<? } ?>
<?

}

function framedashahtml(){
	global $confValues,$retpercent,$pointsarray,$partnerids,$numbersleft,$alreadydone,$varGetCookieInfo;
	foreach($pointsarray as $value) {
		$totalvalue=$totalvalue+$value;
	}
?>
<div style="padding:0px"><font class="clr bld normtxt">Horoscope Match:</font> <font class="clr3 bld normtxt"><?=showCommentdasha($retpercent)?> (<?=$retpercent?>/44)</font></div><br clear="all">
						<div class="normtxt lh20" style="padding:0px;">
								<?
							if($varGetCookieInfo['PAIDSTATUS']==1){
							
							echo 'Given below is the matching status based on the Dashakoota - South Indian system of matching. A score of 22 and above is considered desirable.<br />Dashakoota uses 10 key factors to analyze the levels of compatibility between two people.';							

							}else{

							echo 'The Dashakoota is a South Indian format of matching and uses 10 key factors to analyze the levels of compatibility between a male and female, the higher the score the better the compatibility. A score of 22 and above is considered desirable';
							}
							?>
								
								</div><br clear="all">
					
								<?php if($varGetCookieInfo['PAIDSTATUS']==1){ ?>

								<div style="width:420px;background-color:#ffffff;" class="tlleft">
									<div style="padding:10px 15px;" class="normtxt clr bld">Dashakoota Matching</div>
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:7px;" class="normxt clr bld tlleft fleft">Koot</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:30px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="30" width="1" /></div>
									<div style="width:94px !important;width:109px;padding-left:15px;padding-top:7px;" class="normxt clr bld tlleft fleft">Marks gained</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:30px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="30" width="1" /></div>
									<div style="width:125px !important;width:140px;padding-left:15px;padding-top:7px;" class="normxt bld tlleft fleft">Area of life</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Dinam</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[0]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Luck</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Ganam</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[1]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Wealth</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Mahendram</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[2]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Attachment / Well being</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Sthree Deergham</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[3]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">General welfare</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Yoni</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[4]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Sexual</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Rasi</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[5]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Growth of Family</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Rashyadhipathy</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[6]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Food</div><br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Vashyam</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[7]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Posterity</div><br clear="all">
									
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Rajju</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[8]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Felicity in marriage</div><br clear="all">

									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Vedhai</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[9]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Sons</div><br clear="all">

									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="padding:10px 15px;" class="normtxt clr bld">Other Considerations</div><br clear="all">

									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Gender</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[10]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft"></div><br clear="all">

									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Gothram</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[11]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft"></div><br clear="all">

									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="width:134px !important;width:149px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft">Caste</div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:74px !important;width:109px;padding-left:35px;padding-top:3px;" class="normxt fleft"><?=$pointsarray[12]?></div>
									<div class="fleft" style="width:1px;background:url('<?=$confValues['IMGSURL']?>/versep.gif');height:20px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="20" width="1" /></div>
									<div style="width:135px !important;width:150px;padding-left:15px;padding-top:3px;" class="normxt tlleft fleft"></div>													
									
									<br clear="all">
									<div class="dotsep2"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" /></div>
									<div style="padding:10px 15px;" class="normtxt clr bld">Total marks out of 44<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="55" /><?=$totalvalue?></div>
								</div><? } ?>
								<br clear="all">
								<?php
								if($numbersleft>0 && $varGetCookieInfo['PAIDSTATUS']==1){
								?>
								
								<div class="normtxt lh20" style="padding:0px 15px;">Horoscope matching already done - <?=$alreadydone?><br/>Horoscope matching balance - <?=$numbersleft?><br><a target="_blank" href="<?=$confValues['IMAGEURL']?>/horoscope/horomatchcheckdetails.php?partnerId=<?=$partnerids?>" class="clr1">Click here to view detailed horoscope matching report</a>.</div>

								<? }else{ ?>
								
								<div class="normtxt lh20" style="padding:0px 15px;">To view a detailed horoscope matching report you must subscribe to AstroMatch-Real time horoscope matching service<br><a target="_blank" href="<?=$confValues['SERVERURL']?>/payment/index.php?act=additionalpayment&astro=1" class="clr1">Click here to subscribe</a>.</div>

								<? } ?>
								
<?

}

?>