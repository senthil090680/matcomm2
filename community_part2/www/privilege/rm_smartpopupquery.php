<?php
/********************************************************************************************************
	File		: smartpopupquery.php
	Author		: Padmalatha.P
	Date		: 2-March-2008
	*****************************************************************************************************
	Description	:
			Used to Bookmark/Ignore & View,Add,Del,Update MatriIds..,
*********************************************************************************************************/
//$error_mail_to = "padmalatha@bharatmatrimony.com";

//Include the files .,
$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($DOCROOTPATH);
include_once $DOCROOTBASEPATH."/bmconf/bminit.cil14";
include_once $DOCROOTBASEPATH."/bmconf/bmvars.cil14";
include_once $DOCROOTBASEPATH."/bmlib/bmgenericfunctions.cil14";	// For getDomainInfo().,
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.cil14";
//$_COOKIE['rmusername'];
// Checking Cookie Set.,
if(!(isset($_COOKIE['LOGININFO']['MEMBERID']))) {
		//header('Location: http://'.$GETDOMAININFO['domainmodule'].'/login/login.php');
		echo"<div style='padding: 5px 10px 5px 10px;'><div class='smalltxt divborder' style='padding: 5px 10px 5px 10px;'>Your session has expired or you have loggedout please <a href=\"http://".$GETDOMAININFO['domainmodule']."/login/login.php\" class='clr1'>Click here to login again.</A></div></div>";
		exit;
	}

//Common Variables.,
	$bookmarked_id ="";
	$operation="";
	$pop_type="";
	$comments="";

	$memberid="";
	$entry="";
	$validate_status="";
	$membership_gender="";

	$domainarray_mid	= array();			//getDomainInfo() Logged.,
	$domainarray_bid	= array();			//getDomainInfo() Opp.,

	$db_slave="";							//Class for Connections.,
	$db_master="";							//Class for Connections.,
	$db_master_cross="";					//Class for Connections.,

	$dbprofilenotestable="";
	$dbbookmarkedtable	="";
	$dbignoredtable		="";
	$dbprofilenotestable_cross	="";
	$did_search ="";

// Checking Cookie Set.,
	/*if(!(isset($_COOKIE['LOGININFO']['MEMBERID']))) {
		header('Location: http://'.$_SERVER["SERVER_NAME"].'/login/loginform.php?frompg=m');
	}*/

//Posted Items.,
$bookmarked_id	= trim($_REQUEST['bookmarked_id']);
$operation		= trim($_REQUEST['op']);
$pop_type		= trim($_REQUEST['type']);
$comments		= addslashes(trim($_REQUEST['comments']));
$did_search = trim($_REQUEST['did']);
$did_ig = $_REQUEST['did_ig'];

$did_link = $_REQUEST['divlink'];
//Domain Info.,
//$domainarray_mid  = getDomainInfo(1,'M1000937');
$domainarray_mid  = getDomainInfo(1,$COOKIEINFO['LOGININFO']['MEMBERID']);		//Logged Member..,
$domainarray_bid  = getDomainInfo(1,$bookmarked_id);							//Opp. Member.,


$dbprofilenotestable= $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['PROFILENOTES'];
$dbbookmarkedtable	= $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['RMBOOKMARKED'];
$dbignoredtable		= $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['IGNORED'];	$dbprofilenotestable_cross = $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_bid['domainnameshort'])]['PROFILENOTES'];
$dbprofiletable_cross = $DBNAME['MATRIMONYMS'].".".$MERGETABLE['MATRIMONYPROFILE'];
$dbprofiletable		= $DBNAME['MATRIMONYMS'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['MATRIMONYPROFILE'];


$loginstatstable	= $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_mid['domainnameshort'])]['PROFILESTATS'];

//$receiverstatstable		= $DBNAME['MATRIMONY'].".".$DOMAINTABLE[strtoupper($domainarray_bid['domainnameshort'])]['PROFILESTATS'];
//Cookie Variables..,

 $memberid			=	$COOKIEINFO['LOGININFO']['MEMBERID'];
 $entry= $COOKIEINFO['LOGININFO']['ENTRYTYPE'];  
 $validate_status	=   $COOKIEINFO['LOGININFO']['VALIDATED'];
 $membership_gender	=	$COOKIEINFO['LOGININFO']['GENDER'];
 $icon_disp = "<div class=\"useracticonsimgs shortlist fleft\" style=\"padding: 0px 0px 0px 3px;\"></div>";
 //print_r($COOKIEINFO);
 //echo $COOKIEINFO['LOGININFO']['VALIDATED'];
// exit;
$servername=$DOCROOTBASEPATH;
/*echo"xyz".$domaininfoarr['domainnameweb'];
  $url = ereg_replace("bmser.","www.",$servername);
  $url = "http:/".$url."/paymentoptions.shtml";*/

  if($pop_type == "b")
	{
	$val ="Shortlist Member";
	}
	else if($pop_type == "i")
	{
		$val ="Ignore Member";
	}

echo executeQuery($bookmarked_id,$memberid,$comments,$operation,$entry,$validate_status,$membership_gender,$pop_type);

function executeQuery($bookmarked_id,$memberid,$comments,$operation,$entry,$validatestatus,$gender,$pop_type){
//Connections.,
global $DBINFO,$DBNAME,$db_slave,$db_master,$db_master_cross;				
//Tables.,	
global $dbprofilenotestable,$dbbookmarkedtable,$dbignoredtable,$dbprofilenotestable_cross,$dbprofiletable,$dbprofiletable_cross,$loginstatstable;

global $MAX_FREE_BOOKMARK,$MAX_PAID_BOOKMARK,$MAX_PAID_IGNORE,$MAX_FREE_IGNORE;				//Constants.,
global $domainarray_mid, $did_search ,$did_ig,$val;
$htmldom = $domainarray_mid['domainnamelong'].'.com';


if($memberid=="" || strlen($memberid)==0 )	{
		return  "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>$val</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>Sorry, <b>Matrimony Id</b>&nbsp; cannot be found.</div></div></div></div><div class='fright' style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
}else if($bookmarked_id=='' || strlen($bookmarked_id)==0  )	{
	return  "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>$val</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>Sorry, <b>Matrimony Id</b>&nbsp; is misssing.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
}else if($validatestatus=='' || $validatestatus==0)	{
	return "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>$val</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>Sorry, as your profile is under validation, you will not be able to use this feature. It may take 24 hours for validating your profile. However if you become a paid member right away you can use this feature. <A href=\"http://".$domainarray_mid['domainnameweb']."/payments/paymentoptions.php\" target=\"_blank\" class='clr1'>Click here to become a paid member.</A></div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
}else{
 //Get Connections for both MID & BID on Slave/Master.,


if($domainarray_mid['domainnameshort']==$domainarray_bid['domainnameshort']){
	$db_slave = new db();
	$db_master = new db();

	$db_slave->dbConnById(2,$memberid,"S",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	$db_master->dbConnById(2,$memberid,"M",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	$db_master_cross = $db_master;

}
else{
	$db_slave		= new db();
	$db_master		= new db();
	$db_master_cross= new db();

	$db_slave->dbConnById(2,$memberid,"S",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	$db_master->dbConnById(2,$memberid,"M",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
	$db_master_cross->dbConnById(2,$bookmarked_id,"M",$DBINFO['USERNAME'],$DBINFO['PASSWORD'],$DBNAME['MATRIMONY']);
}


//Check Connections for both MID & BID on Slave/Master.,
if($db_slave->error)			return false;
else if($db_master->error)		return false;
else if($db_master_cross->error)return false;

 //Switch on Cases.,
 	switch($operation){
	case "v":
			if($pop_type=='b'){
			$sel_comment_query="select Comments from ".$dbbookmarkedtable." where BookmarkedId ='".$bookmarked_id."' and MatriId ='".$memberid."' ";
				$pop_val="Bookmarked";
			}else if($pop_type=='i'){
			$sel_comment_query="select Comments from ".$dbignoredtable." where IgnoredId ='".$bookmarked_id."' AND MatriId ='".$memberid."' ";
				$pop_val="Ignored";
			}

			if($db_slave->select($sel_comment_query)>0){
				//print_r($db_slave);
				$row = $db_slave->fetchArray($sel_comment_query);
				$comments=stripslashes($row['Comments']);
				return $operation."~#~".$comments;
				$db_slave->dbClose();
			}else if($db_slave->select($sel_comment_query)==0){ //print_r($db_slave);
				return $operation."~#~"."norec";
			}else{
				return errorRet($sel_comment_query,$entry,$memberid,$bookmarked_id);
			}
			break;
	case "a":
		
			if($pop_type=='b'){
	           $sel_gender_query="select Name,Gender from ".$dbprofiletable_cross." where MatriId='".$bookmarked_id."'";

				 if($db_slave->select($sel_gender_query)){//print_r($db_slave);
						$row1	= $db_slave->fetchArray();
						$bookmarked_name = $row1['0'];
							if($row1['Gender']==$gender){
								if($gender=='F'){
									$lfor="Male";
								}else if($gender=='M'){
										$lfor="Female";
								}
								return "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Shortlist Member</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>Sorry, you can shortlist profiles of the opposite gender only.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
				}else{
					$count_query="select count(MatriId) as cnt from ".$dbbookmarkedtable." where MatriId='$memberid'";
					$stchk=$db_slave->select($count_query);//print_r($db_slave);
						if($stchk){
							$rowchk = $db_slave->fetchArray($count_query);
						}else{
							return errorRet($count_query,$entry,$memberid,$bookmarked_id);
						}

						$ing_query="select MatriId from ".$dbignoredtable." where MatriId='$memberid' and IgnoredId='$bookmarked_id'";
						if($stchk){
							$rc2 = $db_slave->select($ing_query);//print_r($db_slave);
						}else{
							return errorRet($ing_query,$entry,$memberid,$bookmarked_id);
						}
                   
						if(($entry=="F") && ($rowchk['cnt'] >= $MAX_FREE_BOOKMARK)){
							return $msg="<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Shortlist Member</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>Sorry, as a free member you can shortlist a maximum of 50 profiles only. To shortlist more profiles, become a paid member right away.<A href=\"http://".$domainarray_mid['domainnameweb']."/payments/paymentoptions.php\" target=\"_blank\" class='clr1'><br>Click here</A>to upgrade to paid membership.</div></div></div></div><div class='fright' style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
						}else if($rowchk['cnt'] >= $MAX_PAID_BOOKMARK){
							return $msg="<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Shortlist Member</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>You have exceeded the number of members you can shortlist.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
						}else if($rc2==0){
						$rec = insertBookQuery($dbbookmarkedtable,$dbprofilenotestable,$db_master,$db_master_cross,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable);
				}else{
					
					?><div >
                      <div style='padding: 0px 20px 0px 20px;'>
					  <font class='mediumtxt boldtxt clr3'>Shortlist Member</font>
                      <div style='border: 1px solid #ccc;'>
                      <div style='padding:10px;'>
                      <div class='smalltxt'>Sorry, to shortlist this member you must first remove member from your Ignore List. <A href="javascript:confirmdelBk('igdel','b','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');" class="clr1">Click here</A> to delete from the Ignore List and add into Shortlist.</A>
					  </div>
                    </div>
               </div>
          </div>
          <div class='fright'  style='padding-top:5px;padding-right:20px;'>
	      <input type="hidden" value="<?=$comments?>" id="delcomments">
	      <input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div>
       </div>
					
				  <?
				   }
				   if($rec == 1)
					 {         
					  // $val= "Shortlisted";
					   
					 ?>
						<?
						 /*echo$firec="<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Member Shortlisted</font><div style='padding:2px;'></div><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>".strToTitle($bookmarked_name)."</b>&nbsp;($bookmarked_id)&nbsp;has been successfully added to your Shortlist.</div></div></div></div><div class='fright' style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";*/
						 echo $firec="<div style='padding: 0px 20px 0px 20px;'><div id='useracticons'><div id='useracticonsimgs'><div class='fleft mediumtxt boldtxt clr3' >Member Shortlisted</div><div class='fleft' style='padding-left:5px;'><div class=\"useracticonsimgs shortlist fleft\" style=\"padding: 0px 0px 0px 3px;\"></div></div></div></div><br clear='all'><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>".strToTitle($bookmarked_name)."</b>&nbsp;($bookmarked_id)&nbsp;has been successfully added to your Shortlist.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:close_div();'></div></div>";
						?>
						<!--<img src="" onload="showbookicon()">-->
						<img src="http://<?=$domainarray_mid['domainnameimgs']?>/bmimages/trans.gif" height="1" onload="showbookicon('b','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');">
						<?
						
					}
					}
			}else{
					return errorRet($sel_gender_query,$entry,$memberid,$bookmarked_id);
				}
			 }else if($pop_type=='i'){
				 $sel_gender_query="select Name,Gender from $dbprofiletable_cross where MatriId='$bookmarked_id'";
				 if($db_slave->select($sel_gender_query)){//print_r($db_slave);
						$row1 = $db_slave->fetchArray($sel_gender_query);
						$bookmarked_name = $row1['0'];
						if($row1['Gender']==$gender){
							if($gender=='F'){
							$lfor="Male";
							}
							else if($gender=='M'){
							$lfor="Female";
							}
							return "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Member Ignored</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>Sorry, you can ignore profiles of the opposite gender only.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
						}else{
						$count_query="select count(MatriId) as cnt from ".$dbignoredtable." where MatriId='$memberid'";
							$stchk=$db_slave->select($count_query);//print_r($db_slave);
							if($stchk){
							  $rowchk=$db_slave->fetchArray($count_query);
							}else{
								return errorRet($count_query,$entry,$memberid,$bookmarked_id);
							}

						$ing_query="select MatriId from ".$dbbookmarkedtable." where MatriId='$memberid' and BookmarkedId='$bookmarked_id'";
							if($stchk){
								$rc2=$db_slave->select($ing_query);//print_r($db_slave);
							}else{
								return errorRet($ing_query,$entry,$memberid,$bookmarked_id);
							}

							if(($entry=="F") && ($rowchk['cnt'] >= $MAX_FREE_IGNORE)){
								return $msg="<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Ignore  Member</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>Sorry, as a free member you can ignore a maximum of 20 profiles only. To ignore more profiles, become a paid member right away.<A href=\"http://".$domainarray_mid['domainnameweb']."/payments/paymentoptions.php\" target=\"_blank\" class=\"clr1\">Click here </A> to upgrade to paid membership.</div></div></div></div><div class='fright' style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
							}else if($rowchk['cnt'] >= $MAX_PAID_IGNORE){
								return $msg="<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Ignore  Member</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>Sorry, you have exceeded the number of members you can ignore.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
							}else if($rc2==0){
							 $rec =insertIgnQuery($dbignoredtable,$dbprofilenotestable,$db_master,$db_master_cross,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable);
							}else{
								?>	<!-- <br clear="all"> -->
									 <div >
                                      <div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Ignore  Member</font><div style='padding:2px;'></div>
                                      <div style='border: 1px solid #ccc;'>
                                       <div style='padding:10px;'>
                                       <div class='smalltxt'>Sorry, to ignore this member you must first remove member from your Shortlist.<A href="javascript:;" onclick="confirmdelBk('igdel','i','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');" class="clr1">Click here</A> to delete from the Shortlist and add into Ignore List.</div>
                                    </div>
                               </div>
                            </div>
                            <div class='fright'  style='padding-top:5px;padding-right:20px;'>
	                        <input type="hidden" value="<?=$comments?>" id="delcomments">
	                        <input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div>
                         </div>
								<?
							}
								 

						}
						if($rec ==1)
							{
							$val="Ignored";
									?>
													<!--  <?
							 echo$firec=" <div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Member Ignored fgbcf</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been successfully added to your Ignore List.</div></div></div></div><div class='fright' style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";?> -->
							 <?
							 echo$firec="<div style='padding: 0px 20px 0px 20px;'><div id='useracticons'><div id='useracticonsimgs'><div class='fleft mediumtxt boldtxt clr3' >Member Ignored</div><div class='fleft' style='padding-left:5px;'><div class=\"useracticonsimgs ignore fleft\" style=\"padding: 0px 0px 0px 3px;\"></div></div></div></div><br clear='all'><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been successfully added to your Ignore List.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";?>

							
							 <img src="http://<?=$domainarray_mid['domainnameimgs']?>/bmimages/trans.gif" height="1" onload="showbookicon('i','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');">
						   <?
							}
					}else{
						return errorRet($sel_gender_query,$entry,$memberid,$bookmarked_id);
					}
			 }
			 break;
			case "u":
				$sel_gender_query="select Name,Gender from ".$dbprofiletable_cross." where MatriId='".$bookmarked_id."'";
            $db_slave->select($sel_gender_query);//print_r($db_slave);
		    $row1	= $db_slave->fetchArray();
		    $bookmarked_name = $row1['0'];
					if($pop_type=='b'){
					$update_query="update ".$dbbookmarkedtable."  set Comments='$comments' , TimeBookmarked =now() where MatriId ='$memberid' and BookmarkedId ='$bookmarked_id'";
					$res=$db_master->update($update_query);//print_r($db_master);
					if(!$res){
					return errorRet($update_query,$entry,$memberid,$bookmarked_id);
					}else{
					if($res == 1)
					{
					?><!--<div class="fleft smalltxt" style='padding-left:15px;'><a href="#" onclick="confirmdelBk('d','b','<?=$bookmarked_id?>');" class="clr1">Delete</a></div>-->
					<?
					echo $firec ="<div style='padding: 0px 20px 0px 20px;'><div id='useracticons'><div id='useracticonsimgs'><div class='fleft mediumtxt boldtxt clr3' >Member Shortlisted</div><div class='fleft' style='padding-left:5px;'><div class=\"useracticonsimgs shortlist fleft\" style=\"padding: 0px 0px 0px 3px;\"></div></div></div></div><br clear='all'><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been sucessfully updated.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
							}
							}
							}
					else if($pop_type=='i'){
					$update_query="update ".$dbignoredtable."  set Comments='$comments' , TimeIgnored =now() where MatriId ='$memberid' and IgnoredId ='$bookmarked_id'";
					$res = $db_master->update($update_query);//print_r($db_master);
					if(!$res){
					return errorRet($update_query,$entry,$memberid,$bookmarked_id);
					}else
							//return true;
					if($res == 1)
					{
					?><!--<div class="fleft smalltxt" style='padding-left:15px;'><a href="#" onclick="confirmdelBk('d','i','<?=$bookmarked_id?>');" class="clr1">Delete</a></div><br clear="all">-->
					<?
					/*echo $firec ="<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Member Ignored</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been sucessfully updated.</div></div></div></div><div class='fright' style='padding-right:10px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";*/
					echo $firec ="<div style='padding: 0px 20px 0px 20px;'><div id='useracticons'><div id='useracticonsimgs'><div class='fleft mediumtxt boldtxt clr3' >Member Ignored</div><div class='fleft' style='padding-left:5px;'><div class=\"useracticonsimgs ignore fleft\" style=\"padding: 0px 0px 0px 3px;\"></div></div></div></div><br clear='all'><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt'>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been sucessfully updated.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";
					}
					}
					break;
			case "d":
					    $sel_gender_query="select Name,Gender from ".$dbprofiletable_cross." where MatriId='".$bookmarked_id."'";
            $db_slave->select($sel_gender_query);//print_r($db_slave);
		    $row1	= $db_slave->fetchArray();
		    $bookmarked_name = $row1['0'];
			
			if($pop_type=='b'){//echo"type deletion";
							$delete_query="delete from ".$dbbookmarkedtable." where MatriId ='$memberid' and BookmarkedId ='$bookmarked_id' ";
							$db_master->del($delete_query);//print_r($db_master);
							$res=$db_master->getAffectedRows();
							if(!$res){	return errorRet($delete_query,$entry,$memberid,$bookmarked_id);	}

							$pro_up_query="update ".$dbprofilenotestable." set Bookmarked=0,DateUpdated=now() where MatriId='".$memberid."' and PartnerId='".$bookmarked_id."'";
							$db_master->update($pro_up_query);//print_r($db_master);
							$pro_res=$db_master->getAffectedRows();
							if(!$pro_res){	return errorRet($pro_up_query,$entry,$memberid,$bookmarked_id);		}

							$pro_up_query_cross="update ".$dbprofilenotestable_cross." set BookmarkedbyPartnerId=0,DateUpdated=now() where MatriId='".$bookmarked_id."' and PartnerId='".$memberid."'";
							$db_master_cross->update($pro_up_query_cross);//print_r($db_master_cross);
							$pro_res_1 = $db_master_cross->getAffectedRows();
							if(!$pro_res_1){	return errorRet($pro_up_query_cross,$entry,$memberid,$bookmarked_id);	}

							$updatestats="update ".$loginstatstable." set ProfilesBookmarked =ProfilesBookmarked-1,DateUpdated=now() where MatriId='".$memberid."' and ProfilesBookmarked>0";
							$db_master->update($updatestats);
							//print_r($db_master);
							$updatestats_res=$db_master->getAffectedRows();
							if(!$updatestats_res){	return errorRet($pro_up_query,$entry,$memberid,$bookmarked_id);		}

							/*$updatestatsrec="update ".$receiverstatstable." set ProfilesBookmarked =ProfilesBookmarked-1,DateUpdated=now() where MatriId='".$bookmarked_id."' and ProfilesBookmarked >0";
							$db_master->update($updatestatsrec);
							print_r($db_master);
							$updatestatsrec_res=$db_master->getAffectedRows();
							if(!$updatestatsrec_res){	return errorRet($pro_up_query,$entry,$memberid,$bookmarked_id);		}*/

							if($res && $pro_res && $pro_res_1){
								//return true;
								echo "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Deleted from Shortlist</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>".strToTitle($bookmarked_name)."</b>&nbsp;($bookmarked_id)&nbsp;has been successfully deleted from your Shortlist.</div></div></div></div><div class='fright' style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";?>
                               <img src="http://<?=$domainarray_mid['domainnameimgs']?>/bmimages/trans.gif" height="1" onload="showbookicon('db','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');">
							   <?
							}
						}else if($pop_type=='i'){
							$delete_query="delete from ".$dbignoredtable." where MatriId ='$memberid' and IgnoredId ='$bookmarked_id' ";
							$db_master->del($delete_query);//print_r($db_master);
							$res=$db_master->getAffectedRows();
							if(!$res){	return errorRet($delete_query,$entry,$memberid,$bookmarked_id);	}

							$pro_up_query="update ".$dbprofilenotestable." set Ignored=0,DateUpdated=now() where MatriId='".$memberid."' and PartnerId='".$bookmarked_id."'";
							$db_master->update($pro_up_query);//print_r($db_master);
							$pro_res=$db_master->getAffectedRows();
							if(!$pro_res){	return errorRet($pro_up_query,$entry,$memberid,$bookmarked_id);	}

							$pro_up_query_cross="update ".$dbprofilenotestable_cross." set IgnoredbyPartnerId=0,DateUpdated=now() where MatriId='".$bookmarked_id."' and PartnerId='".$memberid."'";
							$db_master_cross->update($pro_up_query_cross);//print_r($db_master_cross);
							$pro_res_1 = $db_master_cross->getAffectedRows();
							if(!$pro_res_1){	return errorRet($pro_up_query_cross,$entry,$memberid,$bookmarked_id);	}

							$updatestats="update ".$loginstatstable." set ProfilesIgnored=ProfilesIgnored-1,DateUpdated=now() where MatriId='".$memberid."' and ProfilesIgnored>0";
							$db_master->update($updatestats);
							//print_r($db_master);
							$updatestats_res=$db_master->getAffectedRows();
							if(!$updatestats_res){	return errorRet($pro_up_query,$entry,$memberid,$bookmarked_id);		}

							/*$updatestatsrec="update ".$receiverstatstable." set ProfilesIgnored  =ProfilesIgnored  -1,DateUpdated=now() where MatriId='".$bookmarked_id."' and ProfilesIgnored  >0";
							$db_master->update($updatestatsrec);
							$updatestatsrec_res=$db_master->getAffectedRows();
							if(!$updatestatsrec_res){	return errorRet($pro_up_query,$entry,$memberid,$bookmarked_id);		}*/

							if($res && $pro_res && $pro_res_1){
								//return true;
                               echo "<div ><div style='padding: 0px 20px 0px 20px;'><font class='mediumtxt boldtxt clr3'>Deleted from Ignore List</font><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>".strToTitle($bookmarked_name)."</b>&nbsp;($bookmarked_id)&nbsp;has been successfully deleted from your Ignore List.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";?>
				  <img src="http://<?=$domainarray_mid['domainnameimgs']?>/bmimages/trans.gif" height="1"onload="showbookicon('di','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');">
							   <?
							}
						}
						break;
			case "igdel":
				$sel_gender_query="select Name,Gender from ".$dbprofiletable_cross." where MatriId='".$bookmarked_id."'";
            $db_slave->select($sel_gender_query);//print_r($db_slave);
		    $row1	= $db_slave->fetchArray();
		    $bookmarked_name = $row1['0'];



						if($pop_type=='b'){
					    $delete_query="delete from ".$dbignoredtable." where MatriId='$memberid' and IgnoredId='$bookmarked_id'";
						$res = $db_master->del($delete_query);//print_r($db_master);
						if(!$res){
						return errorRet($delete_query,$entry,$memberid,$bookmarked_id);
						}
					    $finrec=deligAddbookQuery($dbbookmarkedtable,$dbprofilenotestable,$db_master,$db_master_cross,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable);
						if($finrec== 1)
				            {
							echo "<div style='padding: 0px 20px 0px 20px;'><div id='useracticons'><div id='useracticonsimgs'><div class='fleft mediumtxt boldtxt clr3' >Member Shortlisted</div><div class='fleft' style='padding-left:5px;'><div class=\"useracticonsimgs shortlist fleft\" style=\"padding: 0px 0px 0px 3px;\"></div></div></div></div><br clear='all'><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been successfully added to your  Shortlist.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";?> 
							<img src="http://<?=$domainarray_mid['domainnameimgs']?>/bmimages/trans.gif" height="1" onload="showbookicon('b','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');">
							<?
				            }
							}

						else{
						$delete_query="delete from ".$dbbookmarkedtable." where MatriId='$memberid' and BookmarkedId='$bookmarked_id'";
						$res = $db_master->del($delete_query);//print_r($db_master);
						if(!$res){
						return errorRet($delete_query,$entry,$memberid,$bookmarked_id);
						}
						$finrec=delbookAddIgQuery($dbignoredtable,$dbprofilenotestable,$db_master,$db_master_cross,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable);
						if($finrec ==1)
							{
                            echo "<div style='padding: 0px 20px 0px 20px;'><div id='useracticons'><div id='useracticonsimgs'><div class='fleft mediumtxt boldtxt clr3' >Member Ignored</div><div class='fleft' style='padding-left:5px;'><div class=\"useracticonsimgs ignore fleft\" style=\"padding: 0px 0px 0px 3px;\"></div></div></div></div><br clear='all'><div style='padding:2px;'></div><div style='border: 1px solid #ccc;'><div style='padding:10px;'><div class='smalltxt '>".strToTitle($bookmarked_name)."&nbsp;($bookmarked_id)&nbsp;has been successfully added to your  Ignore List.</div></div></div></div><div class='fright'  style='padding-top:5px;padding-right:20px;'><input type='button' class='button' value='Close' onclick='javascript:parent.close_div();'></div></div>";?>
							<img src="http://<?=$domainarray_mid['domainnameimgs']?>/bmimages/trans.gif" height="1" onload="showbookicon('i','<?=$bookmarked_id?>','<?=$did_search?>','<?=$did_ig?>','<?=$_REQUEST['divlink']?>');"><?
							}
						}
				break;
		}
	}
}

function errorRet($query,$entry,$memberid,$bookmarked_id){
global $error_mail_to;
//$query_err="err"."##<br>";
$query_err= "<div style='padding: 0px 20px 0px 20px;'><div class='smalltxt divborder' style='padding:10px;'>There may be a problem with database or matrimonyid.</div></div>";/*<!--Please<a href=\"http://".$GETDOMAININFO['domainmodule']."/login/login.php\" class='clr1'>Click here to login again.</A> -->*/
mail($error_mail_to, "Bookmark / Ignore Query Error", "\n\n Bookmarked By : ".$memberid." \n\n Membership Entry: ".$entry." \n\n Bookmarked Id: ".$bookmarked_id."\n\nQuery: ".$query."\n\nQuery Error: ".$query_err."\n\n User IP: ".$_SERVER['REMOTE_ADDR']."\n\n Date: ".date("l dS of F Y h:i:s A"));
return $query_err;
}

function insertBookQuery($dbbookmarkedtable,$dbprofilenotestable,$dblink,$db_cross_link,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable=''){				//function insert into bookmark table

 $query="insert into ".$dbbookmarkedtable." values ('".$_COOKIE['rmusername']."','$memberid','$bookmarked_id',now(),'".stripslashes($comments)."') on duplicate key update Comments='$comments', TimeBookmarked =now() ";
$dblink->insert($query);
$res = $dblink->getAffectedRows();//print_r($dblink);
if($dblink->error!='')	{	 return errorRet($query,$entry,$memberid,$bookmarked_id);	}

/*$pro_que="insert into ".$dbprofilenotestable." (MatriId,PartnerId,Bookmarked,DateUpdated) values ('$memberid','$bookmarked_id',1,now()) on duplicate key update Bookmarked=1 , DateUpdated=now()";
$dblink->insert($pro_que);//print_r($dblink);
$pro_res = $dblink->getAffectedRows();
if($dblink->error!='')	{		return errorRet($pro_que,$entry,$memberid,$bookmarked_id);	}

$pro_que_1="insert into ".$dbprofilenotestable_cross." (MatriId,PartnerId,BookmarkedbyPartnerId,DateUpdated) values ('$bookmarked_id','$memberid',1,now()) on duplicate key update BookmarkedbyPartnerId=1 , DateUpdated=now()";
$db_cross_link->insert($pro_que_1);//print_r($db_cross_link);
$pro_res_1= $db_cross_link->getAffectedRows();
if($db_cross_link->error!='')	{		return errorRet($pro_que_1,$entry,$memberid,$bookmarked_id);	}

$loginstatsentry="insert into ".$loginstatstable." (MatriId,ProfilesBookmarked,DateUpdated) values ('$memberid',1,now()) on duplicate key update ProfilesBookmarked=ProfilesBookmarked+1";
$dblink->insert($loginstatsentry);
//print_r($dblink);
$loginstatsentryres = $dblink->getAffectedRows();
if($dblink->error!='')	{		return errorRet($loginstatsentryres,$entry,$memberid,$bookmarked_id);	}

/*$receiverstatsentry="insert into ".$receiverstatstable." (MatriId,ProfilesBookmarked,DateUpdated) values ('$bookmarked_id',1,now()) on duplicate key update ProfilesBookmarked=ProfilesBookmarked+1";
$dblink->insert($receiverstatsentry);
$receiverstatsentryres = $dblink->getAffectedRows();
if($dblink->error!='')	{		return errorRet($receiverstatsentryres,$entry,$bookmarked_id);	}*/

if($res)
{//echo"sucess";
	return true;
}
}

function insertIgnQuery($dbignoredtable,$dbprofilenotestable,$dblink,$db_cross_link,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable){		//function insert to ignore table

$query="insert into ".$dbignoredtable." values ('$memberid','$bookmarked_id',now(),'$comments') on duplicate key update Comments='$comments' , TimeIgnored=now() ";
$dblink->insert($query);//print_r($dblink);
$res = $dblink->getAffectedRows();
if($dblink->error!='')	{	 return errorRet($query,$entry,$memberid,$bookmarked_id);	}

$pro_que="insert into ".$dbprofilenotestable." (MatriId,PartnerId,Ignored,DateUpdated) values ('$memberid','$bookmarked_id',1,now()) on duplicate key update Ignored=1,DateUpdated=now()";
$dblink->insert($pro_que);//print_r($dblink);
$pro_res = $dblink->getAffectedRows();
if($dblink->error!='')	{		return errorRet($pro_que,$entry,$memberid,$bookmarked_id);	}

$pro_que_1="insert into ".$dbprofilenotestable_cross." (MatriId,PartnerId,IgnoredbyPartnerId,DateUpdated) values ('$bookmarked_id','$memberid',1,now()) on duplicate key update IgnoredbyPartnerId=1,DateUpdated=now()";
$db_cross_link->insert($pro_que_1);//print_r($db_cross_link);
$pro_res_1 = $db_cross_link->getAffectedRows();
if($db_cross_link->error!='')	{		return errorRet($pro_que_1,$entry,$memberid,$bookmarked_id);	}

$loginstatsentry="insert into ".$loginstatstable." (MatriId,ProfilesIgnored ,DateUpdated) values ('$memberid',1,now()) on duplicate key update ProfilesIgnored=ProfilesIgnored+1";
	$dblink->insert($loginstatsentry);//print_r($dblink);
	$loginstatsentryres = $dblink->getAffectedRows();
	if($dblink->error!='')	{		
		return errorRet($loginstatsentryres,$entry,$memberid,$bookmarked_id);	
	}

	/*$receiverstatsentry="insert into ".$receiverstatstable." (MatriId,ProfilesIgnored ,DateUpdated) values ('$bookmarked_id',1,now()) on duplicate key update ProfilesIgnored =ProfilesIgnored +1";
	$db_cross_link->insert($receiverstatsentry);
	$receiverstatsentryres = $db_cross_link->getAffectedRows();
	if($dblink->error!='')	{
		return errorRet($receiverstatsentryres,$entry,$bookmarked_id);	
	}*/


if($res && $pro_res && $pro_res_1){
	return true;
}
}

function deligAddbookQuery($dbbookmarkedtable,$dbprofilenotestable,$dblink,$db_cross_link,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable){

	$query="insert into ".$dbbookmarkedtable." values ('$memberid','$bookmarked_id',now(),'$comments')  on duplicate key update Comments='$comments', TimeBookmarked =now() ";
	$res = $dblink->insert($query);//print_r($dblink);
	if($dblink->error!='')	{
	 return errorRet($query,$entry,$memberid,$bookmarked_id);
	}
	$pro_que="insert into ".$dbprofilenotestable." (MatriId,PartnerId,Bookmarked,DateUpdated) values ('$memberid','$bookmarked_id',1,now()) on duplicate key update Bookmarked=1,Ignored=0,DateUpdated=now()";
	$pro_res = $dblink->insert($pro_que);//print_r($dblink);
	if($dblink->error!='')	{
		return errorRet($pro_que,$entry,$memberid,$bookmarked_id);
	}
	$pro_que_1="insert into ".$dbprofilenotestable_cross." (MatriId,PartnerId,BookmarkedbyPartnerId,DateUpdated) values ('$bookmarked_id','$memberid',1,now()) on duplicate key update BookmarkedbyPartnerId=1,IgnoredbyPartnerId=0,DateUpdated=now()";
	$pro_res_1 = $db_cross_link->insert($pro_que_1);//print_r($db_cross_link);
	if($db_cross_link->error!='')	{
		return errorRet($pro_que_1,$entry,$memberid,$bookmarked_id);
	}

	$loginstatsentry="insert into ".$loginstatstable." (MatriId,ProfilesBookmarked ,DateUpdated) values ('$memberid',1,now()) on duplicate key update ProfilesBookmarked=ProfilesBookmarked+1";
	$dblink->insert($loginstatsentry);//print_r($dblink);
	$loginstatsentryres = $dblink->getAffectedRows();
	if($dblink->error!='')	{		
		return errorRet($loginstatsentryres,$entry,$memberid,$bookmarked_id);	
	}

	$updatestats="update ".$loginstatstable." set ProfilesIgnored=ProfilesIgnored-1,DateUpdated=now() where MatriId='".$memberid."' and ProfilesIgnored>0";
	$dblink->update($updatestats);
	//print_r($dblink);
	$updatestats_res=$dblink->getAffectedRows();
							
 //	if($res && $pro_res && $pro_res_1)
		return true;
}

function delbookAddIgQuery($dbignoredtable,$dbprofilenotestable,$dblink,$db_cross_link,$dbprofilenotestable_cross,$entry,$memberid,$bookmarked_id,$comments,$loginstatstable){

$query="insert into ".$dbignoredtable." values ('$memberid','$bookmarked_id',now(),'$comments') on duplicate key update Comments='$comments' , TimeIgnored=now() ";
$res  = $dblink->insert($query);//print_r($dblink);
if($db_master->error!='')	{
 return errorRet($query,$entry,$memberid,$bookmarked_id);
}
$pro_que="insert into ".$dbprofilenotestable." (MatriId,PartnerId,Ignored,DateUpdated) values ('$memberid','$bookmarked_id',1,now()) on duplicate key update Bookmarked=0,Ignored=1,DateUpdated=now()";
$pro_res = $dblink->insert($pro_que);//print_r($dblink);
if($db_master->error!='')	{
	return errorRet($pro_que,$entry,$memberid,$bookmarked_id);
}
$pro_que_1="insert into ".$dbprofilenotestable_cross." (MatriId,PartnerId,IgnoredbyPartnerId,DateUpdated) values ('$bookmarked_id','$memberid',1,now()) on duplicate key update BookmarkedbyPartnerId=0,IgnoredbyPartnerId=1,DateUpdated=now()";
$pro_res_1 =  $db_cross_link->insert($pro_que_1);//print_r($db_cross_link);
if($db_cross_link->error!='')	{
	return errorRet($pro_que_1,$entry,$memberid,$bookmarked_id);
}
$loginstatsentry="insert into ".$loginstatstable." (MatriId,ProfilesIgnored ,DateUpdated) values ('$memberid',1,now()) on duplicate key update ProfilesIgnored=ProfilesIgnored+1";
$dblink->insert($loginstatsentry);//print_r($dblink);
$loginstatsentryres = $dblink->getAffectedRows();
if($dblink->error!='')	{		
		return errorRet($loginstatsentryres,$entry,$memberid,$bookmarked_id);	
}

$updatestats="update ".$loginstatstable." set ProfilesBookmarked=ProfilesBookmarked-1,DateUpdated=now() where MatriId='".$memberid."' and ProfilesBookmarked>0";
$dblink->update($updatestats);
//print_r($dblink);
$updatestats_res=$dblink->getAffectedRows();

//	if($res && $pro_res && $pro_res_1)
	return true;
}
?>
