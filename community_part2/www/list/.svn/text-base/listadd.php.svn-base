<?php
//Base Path
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

// Include the files
include_once $varRootBasePath."/conf/config.cil14";
include_once $varRootBasePath."/conf/cookieconfig.cil14";
include_once $varRootBasePath."/conf/dbinfo.cil14";
include_once $varRootBasePath."/lib/clsDB.php";
include_once($varRootBasePath.'/lib/clsMemcacheDB.php');


//Object Declaration
$objSlaveDb		= new DB;
$objMasterDb	= new DB;
$objMasterDb->dbConnect('M', $varDbInfo['DATABASE']);
$objSlaveDb->dbConnect('S', $varDbInfo['DATABASE']);

//Variable Declaration
$varSessionId	= mysql_real_escape_string($varGetCookieInfo['MATRIID']);
$varSessGender	= $varGetCookieInfo['GENDER'];
$varSessValStat	= $varGetCookieInfo['PUBLISH'];
$varSessPdStat	= $varGetCookieInfo['PAIDSTATUS'];

//VARIABLE DECLARATION
$varMemberId	= mysql_real_escape_string($_REQUEST["id"]);
$varPurpose		= $_REQUEST["purp"];

$varDivNo		= $_REQUEST["divno"];
$varThruSrch	= $_REQUEST['thrusearch'];
$arrMemberId	= split('~+',trim($varMemberId,'~'));
$varAllMemberIds= "'".join($arrMemberId,"','")."'";
$varMemTable	= $varTable['MEMBERINFO'];
$varDispMsg		= '';

function countList($varTotCnt) {
	global $varPurpose,$varSessPdStat,$confValues;
	$varReturn	= '';	

	if($varPurpose=='shortlist' && $varSessPdStat==0 && $varTotCnt > $confValues['FMSHORTLISTCNT']) {
		$varReturn = 'Sorry, as a free member you can add favorites a maximum of '.$confValues['FMSHORTLISTCNT'].' profiles only. To add more profiles in favorite list, become a premium member right away. <a href="../payment" target="_blank" class="clr1">Click here </a> to upgrade to premium membership.';
	} elseif($varPurpose=='shortlist' && $varSessPdStat==1 && $varTotCnt > $confValues['PMSHORTLISTCNT']) {
		$varReturn = 'You have exceeded the number of members you can favorite.';
	} elseif($varPurpose=='block' && $varSessPdStat==0 && $varTotCnt > $confValues['FMBLOCKLISTCNT']) {
		$varReturn = 'Sorry, as a free member you can block only 1 profile. To block more profiles, you must become a premium member. <a href="../payment" target="_blank" class="clr1">Click here </a> to upgrade to premium membership.';
	} elseif($varPurpose=='block' && $varSessPdStat==1 && $varTotCnt > $confValues['PMBLOCKLISTCNT']) {
		$varReturn = 'You have exceeded the number of members you can block.';
	}
	return $varReturn;
}

//CONTROL STATEMENT
if ($varSessionId == "") {  $varDispMsg = 'Your session has expired or you have logged out. <br>Please <a href="'.$confValues['SERVERURL'].'/login/"  class="clr1">Click here</a> to login again.'; }//if
elseif($varSessValStat==0 || $varSessValStat=="") { $varDispMsg = 'Sorry, as your profile is under validation, you will not be able to use this feature. It may take 24 hours for validating your profile. However if you become a paid member right away you can use this feature.'; }
elseif($varSessValStat==3 || $varSessValStat==4) { $varDispTxt = ($varSessValStat==3)? 'suspended': 'rejected';$varDispMsg = 'Sorry, as your profile is '.$varDispTxt.', you will not be able to use this feature.'; }
else {
	$varMemFields	= array('Nick_Name','Gender','Name');
	$varMemCondtn	= " WHERE MatriId IN($varAllMemberIds)";
	$varMemInf		= $objSlaveDb->select($varMemTable,$varMemFields,$varMemCondtn,1);
	$varOppGender	= $varMemInf[0]['Gender'];
	$varMemName		= $varMemInf[0]['Nick_Name'] ? $varMemInf[0]['Nick_Name'] : $varMemInf[0]['Name'];
	if($varSessGender==$varOppGender) { $varDispMsg = 'Sorry, you can '.$varPurpose.' profiles of the opposite gender only.'; }
	elseif($varMemName==""){ $varDispMsg = 'Sorry, <b>this profile </b>&nbsp; cannot be found.'; }
}

if($varDispMsg==""){ 
	switch($varPurpose){
		case 'shortlist':
			//MEMCATCH FOR BOOKMARKED MEMBER
			$varProfileBookMarkMCKey = 'ProfileBookMarks_'.$varSessionId;
			$varGetProfileBookMark = Cache::getData($varProfileBookMarkMCKey);
			$arrBookMarked = explode(',', $varGetProfileBookMark);
			if(!in_array($varMemberId,$arrBookMarked)) {
				$varGetProfileBookMark = $varGetProfileBookMark.','.$varMemberId;
				Cache::setData($varProfileBookMarkMCKey,$varGetProfileBookMark);
			}
			$varFields		= array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Date_Updated');
			$varTblName		= $varTable['BOOKMARKINFO'];$varListField='Bookmarked';
			$varTitle = "Add to favourites";
			$varStatField = 'ProfilesBookmarked';
			break;
		case 'ignore':
			$varFields		= array('MatriId', 'Opposite_MatriId', 'Ignored', 'Date_Updated');
			$varTblName		= $varTable['IGNOREINFO'];break;
		case 'block':
			//MEMCATCH FOR BLOCKED MEMBER
			$varProfileBlockMCKey   = 'ProfileBlocks_'.$varSessionId;
			$varGetProfileBlock = Cache::getData($varProfileBlockMCKey);
			$arrBlocked = explode(',', $varGetProfileBlock);
			if(!in_array($varMemberId,$arrBlocked)) {
				$varGetProfileBlock = $varGetProfileBlock.','.$varMemberId;
				Cache::setData($varProfileBlockMCKey,$varGetProfileBlock);
			}
			
			$varFields		= array('MatriId', 'Opposite_MatriId', 'Blocked', 'Date_Updated');
			$varTblName		= $varTable['BLOCKINFO'];$varListField='Blocked';
			$varTitle ="Block Member";
			$varStatField = 'ProfilesBlocked';
			break;
	}

	//$varAlreadyCondition	= " WHERE MatriId='".$varSessionId."' AND Opposite_MatriId IN (".$varAllMemberIds.") AND ".$varListField."=1";
	$varAlreadyCondition	= " WHERE MatriId=".$objSlaveDb->doEscapeString($varSessionId,$objSlaveDb)." AND ".$varListField."=1";
	$varAlreadyFields		= array('Opposite_MatriId');
	$varSelAlreadyProfile	= $objSlaveDb->select($varTblName,$varAlreadyFields,$varAlreadyCondition,1);
	$arrAlreadyListed		= array();
	foreach($varSelAlreadyProfile as $key=>$res) {
		$arrAlreadyListed[$key]=$varSelAlreadyProfile[$key]['Opposite_MatriId'];
	}

	//print_r($arrMemberId);
	//print_r($arrAlreadyListed);
	$arrToBeList	= array_diff($arrMemberId,$arrAlreadyListed);
	$varTotalListCnt= sizeof($arrAlreadyListed) + sizeof($arrToBeList);

	//checking alloted count exit or ot
	$varDispMsg = countList($varTotalListCnt);
    
	if($varDispMsg =='' ) {
		foreach($arrToBeList as $varSingleId) {
			if($varSingleId != '') {
				$varFieldsVal	= array($objMasterDb->doEscapeString($varSessionId,$objMasterDb), "'".$varSingleId."'", 1, 'NOW()');
				if($_COOKIE['rmusername']){
					$AppendRmuser = array('RM_UserId');
					$_COOKIE['rmusername'] = $objMasterDb->doEscapeString($_COOKIE['rmusername'],$objMasterDb);
					$AppendRmuserVal = array("'".$_COOKIE['rmusername']."'");
					$FinalvarUpdateFields = array_merge($varFields,$AppendRmuser);
					$FinalvarUpdateVal    = array_merge($varFieldsVal,$AppendRmuserVal);
					$objMasterDb->insert($varTblName, $FinalvarUpdateFields, $FinalvarUpdateVal);
			    }else{
					$objMasterDb->insert($varTblName, $varFields, $varFieldsVal);
				}
				$objMasterDb->insertOnDuplicate($varTable['MEMBERACTIONINFO'], $varFields, $varFieldsVal,"");
			}
		}

        // Update Member statistics table //
		$varStatFields = array($varStatField,'DateUpdated');
        $varStatFieldsValues = array($varTotalListCnt,'NOW()');
		$varSatCond = " MatriId =".$objMasterDb->doEscapeString($varSessionId,$objMasterDb);
		$varUpdateAct	= $objMasterDb->update($varTable['MEMBERSTATISTICS'],$varStatFields,$varStatFieldsValues,$varSatCond);

		$varAlreadyListStr	= join(array_diff($arrMemberId,$arrToBeList),", ");
		$varAddedListedStr	= join($arrToBeList,", ");
		
		//rename from shortlist to favorites
		if($varPurpose=='shortlist'){
			$varPurpose = 'favourites';
		}

		if($varAlreadyListStr != '') {
			$varDispMsg	.= "<b>".$varAlreadyListStr."</b> already in ".$varPurpose." list";
		}
		if($varAddedListedStr != '') {
			if(count($arrToBeList) > 1)
			$varListedMsg	= "You have successfully added these members to your ".$varPurpose." list";
			else
			$varListedMsg	= "You have successfully added this member to your ".$varPurpose." list";

			$varDispMsg	   .= ($varDispMsg=='')?$varListedMsg:'<BR><BR>'.$varListedMsg;
		}
		$varDispMsg	.= '^yes^';
	}
}

if($varTitle!=''){
	$varTitleHeading ="<div><b>".$varTitle."</b></div><div class='linesep'><img src='".$confValues['IMGSURL']."/trans.gif' height=1 width=1/></div><br clear='all'>";
} else {
	$varTitleHeading='';
}

include_once($varRootBasePath."/www/login/updatemessagescookie.php");
setMessagesCookie($varSessionId,$objSlaveDb);

if($varThruSrch == 1) {
	echo "<div class='fright tlright'><img src='".$confValues['IMGSURL']."/close.gif' class='pntr' onclick='hidediv(\"listalldiv\")'/></div><br clear='all'>".$varDispMsg."<br clear='all'><div class='fright'><input type='button' class='button' value='Close' onClick='hidediv(\"listalldiv\")'></div></div><br clear='all'>";
} else {
	echo "<div class='fright tlright'><img src='".$confValues['IMGSURL']."/close.gif' class='pntr' onclick='hide_box_div(\"div_box$varDivNo\");'/></div><br clear='all'>";
	echo $varTitleHeading.$varDispMsg."<br clear='all'><div class='fright'><input type='button' class='button' value='Close' onClick='hide_box_div(\"div_box$varDivNo\");'></div>";
}
//echo $varDispMsg;

//UNSET OBJECT
$objMasterDb->dbClose();
$objSlaveDb->dbClose();
unset($objMasterDb);
unset($objSlaveDb);
?>