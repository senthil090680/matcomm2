<?php
/***********************************************************************************
File	: bouceedemail.php
AUTHOR  : Senthilnathan.M
Date	: 01-MAR-2008
************************************************************************************ 
DESCRIPTION : This page is for Logged member have bounced email id.
************************************************************************************/
$DOCROOTPATH	 = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($DOCROOTPATH); 

//INCLUDE THE FILES
include_once $DOCROOTBASEPATH."/bmconf/bminit.inc";

$varMatriId		= $COOKIEINFO['LOGININFO']['MEMBERID'];
if($varMatriId	== '')
header('Location:http://'.$GETDOMAININFO['domainmodule'].'/login/login.php');

//INCLUDE THE FILES
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc";
include_once $DOCROOTBASEPATH."/bmlib/bmsearchfunctions.inc";
include_once $DOCROOTPATH."/search/smartquery.php";

//Style Variables
$div4class="fleft tabclrleft";
$divnext4class="fleft tabclrright";
$text4class="mediumtxt1 boldtxt clr4";

$div5class="fleft tableftsw";
$divnext5class="fleft tabright";
$text5class="mediumtxt1 boldtxt clr3";

$div6class="fleft tableft";
$divnext6class="fleft tabrightsw";
$text6class="mediumtxt1 boldtxt clr3";

//VARIABLE DECLERATIONS
$varMatriId	= $COOKIEINFO['LOGININFO']['MEMBERID']; 
$varType	= ($_REQUEST['viewtype']=='')?1:$_REQUEST['viewtype'];
$varReqPg	= ($_REQUEST['req']=='') ? 'Pre' : $_REQUEST['req'];
$varCurrPg	= 1;
$varStartLt	= 0;
$varDbError	= '';
$varEndLt	= $varType*10;
$varTempCount	= 0;
$varTotalPages  = 0;
$varOppositeId	= array();
$varTempTable	= $DBNAME['MATRIMONYMS'].".".$TABLE['PROFILEMATCH'];
$varNotAvailMsg = "Currently there are no profiles in this folder.";
$PAGEVARS['PAGETITLE']="Alliances Bharatmatrimony Recommends - ".ucfirst($GETDOMAININFO['domainnamelong']);
if($varReqPg == 'Pre')
{
	 //$varTempCount	= $COOKIEINFO['LOGININFO']['PROFILEMATCHCNT'];
	$varEnableDiv	= 6;
	//if($varTempCount == ''){
	$varArrQuery	= genQueryPerferenceMatch();
	$varWhere		= $varArrQuery[1];
	$varQuery		= 'SELECT COUNT(MatriId) AS CNT FROM '.$varTempTable." WHERE MatriId<>'".$varMatriId."' AND ".										  $varWhere;
	$objSlave		= new db();
	#$objSlave->dbConnById(2,$varMatriId,'S',$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	$objSlave->connect($DBCONIP['PROFILEMATCH'],$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONYMS']);
	if(!$objSlave->error){
	$objSlave->select($varQuery);
	$varTempResult	= $objSlave->fetchArray();
	$varTempCount	= $varTempResult["CNT"];
	$objSlave->dbClose();
	}
	else
	{
		$varDbError	= $ERRORMSG;
	}
	//}
}
elseif($varReqPg == 'Pro')
{
	$varArrQuery	= genQueryProfileMatch($varStartLt, $varType);
	 $varTempCount	= $varArrQuery[4];
	$varEnableDiv	= 7;
}
elseif($varReqPg == 'Mut')
{
	$varArrQuery	= genQueryMutualMatch($varStartLt, $varType);
	 $varTempCount	= $varArrQuery[4];
	$varEnableDiv	= 8;
}
?>

<? include_once("../template/headertop.php");?>
<!--include your own javascript -->
<?include_once("../template/header.php"); ?>
<script src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/bmrequest.js" type="text/javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/bookmarkrequest.js?rn=123" type="text/javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/forward.js" type="text/javascript"></script>
<script src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/getoptionsei.js" type="text/javascript"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/matchwatchall.js"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/ST_common.js"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/myhometab.js"></script> 
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/matchwatch.js?rn=123"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/hintbox.js"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/referenceview.js"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/assuredcontact.js"></script>
<script language="javascript" src="http://<?=$GETDOMAININFO['domainnameimgs']?>/scripts/enlarge.js"></script>
	<!--{ middle area -->
	<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">
						<div class="fleft">
								<div class="tabcurbg fleft">
								<!--{ tab button none -->
								<div class="fleft">
									<div id="div4class" class="<?=$div4class?>"></div>
										<div id="divnext4class" class="<?=$divnext4class?>">
											<div class="tabpadd"><a href="javascript:;" onclick="myhometab('/search/mutualmatchgetall.php?req=Pre&a=N','matcharea',6)" id="text4class" class="<?=$text4class?>" onmouseout="hidetip();" onmouseover="showhint('Displays the list of members whose profile matches your partner preference.' ,this,event,'185');">Profiles I'm looking for</a> </div>
										</div>
								</div>
								<div class="fleft">
									<div id="div5class" class="<?=$div5class?>"></div>
										<div id="divnext5class" class="<?=$divnext5class?>">
											<div  class="tabpadd"><a href="javascript:;" id="text5class" onclick="myhometab('/search/mutualmatchgetall.php?req=Pro&a=N','matcharea',7)" class="<?=$text5class?>" onmouseout="hidetip();" onmouseover="showhint('Displays the list of members whose partner preference matches your profile.' ,this,event,'185');">Profiles looking for me</a> </div>
										</div>
								</div>
								<div class="fleft">
									<div  id="div6class" class="<?=$div6class?>"></div>
										<div  id="divnext6class" class="<?=$divnext6class?>">
											<div class="tabpadd"><a href="javascript:;" onclick="myhometab('/search/mutualmatchgetall.php?req=Mut&a=N','matcharea',8)"  id="text6class" class="<?=$text6class?>" onmouseout="hidetip();" onmouseover="showhint('Displays the list of members whose partner preference matches with your profile and your partner preference matches with their profile.' ,this,event,'185');">Mutual Match</a></div>
										</div>
								</div>							
								<!-- tab button none }-->								
								</div>

								<div class="fleft tr-3"></div>
							</div>

				<!-- Content Area -->

				<div class="middiv1">
				<div class="bl">
					<div class="middiv-pad1">
							<div class="vc1" id="matchtabs">
							 <div id='matchdummyarea' style="padding-top:0px;"></div>
							 <div id='matcharea'>
							<? if($varDbError != ''){?>
							<div class="poppadding poppadding1"><font class="smalltxt">
							<?=$varDbError;?></font></div>
							
							<?}
							else if(($varTempCount > 0) && ($varDbError == '')){ 
							echo "<script>myhometab('/search/mutualmatchgetall.php?req=".$varReqPg."&a=N','matcharea',".$varEnableDiv.")</script>";
							echo '<script>Ma_File_Name = "mutualmatchgetall.php";Ma_Tot_Records='.$varTotalPages.';					Ma_View_Type="'.$_GET['viewtype'].'";	</script>';
							
							
							}else{
							echo "<script>myhometab('/search/mutualmatchgetall.php?req=".$varReqPg."&a=N','matcharea',".$varEnableDiv.")</script>";	
							?>
							<div style=" width:504px; height:60px">
							<div class="smalltxt" style="padding-top:40px;padding-left:5px;"><b><?=$varNotAvailMsg;?></b></div>
							</div><br clear="all">
							<? }//else ?>
							</div>
							</div>				
					</div>
				</div>
				</div>
				<!-- Content Area -->
			</div>
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>
<!-- middle area }-->
<? include_once("../template/rightpanel.php"); ?>
<br clear="all">
<? include_once("../template/footer.php"); ?>