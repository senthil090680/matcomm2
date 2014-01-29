<?php
//ROOT VARIABLES
$varServerRoot	= $_SERVER['DOCUMENT_ROOT'];
$varBaseRoot	= dirname($varServerRoot);

//INCLUDED FILES
include_once($varBaseRoot.'/conf/config.cil14');
include_once($varBaseRoot.'/conf/cookieconfig.cil14');
include_once($varBaseRoot.'/conf/dbinfo.cil14');
include_once($varBaseRoot.'/lib/clsBasicview.php');
include_once($varBaseRoot.'/lib/clsMessage.php');
include_once($varBaseRoot.'/www/mymessages/framebasicstrip.php');

//Variable Decleration
$sessMatriId	= $varGetCookieInfo["MATRIID"];
$sessPP			= $_COOKIE['partnerInfo'];
$varMsgOption	= $_REQUEST['tabId']!='' ? $_REQUEST['tabId'] : 'RMALL';

if($sessMatriId != ''){
//Basic view variables
$varPageNo		= $_REQUEST['Page'] != '' ? $_REQUEST['Page'] : 1;
$varNoOfRec		= 10;
$varViews		= 1;
$arrRecItems	= array('RMUNREAD'=>array('0', 'Date_Received'), 'RMREAD'=>array('1', 'Date_Read'), 'RMREPLIED'=>array('2', 'Date_Replied'), 'RMDECLINED'=>array('3', 'Date_Declined'), 'RIPENDING'=>array('0', 'Date_Received'), 'RIACCEPTED'=>array('1', 'Date_Acted'), 'RIDECLINED'=>array('3', 'Date_Acted'), 'RRPHOTO'=>array('1', 'RequestDate'), 'RRPHONE'=>array('3','RequestDate'), 'RRHOROSCOPE'=>array('5', 'RequestDate'), 'RMALL'=>array('A', 'Date_Received'), 'RIALL'=>array('A', 'Date_Received'), 'RRALL'=>array('A', 'RequestDate'));
$arrMsgIndexVal	= array('M'=>1, 'I'=>2, 'R'=>3);

//Object Decleration
$objBasicView	= new BasicView();
$objMessage		= new Message();

//Connect DB
$objBasicView->dbConnect('M', $varDbInfo['DATABASE']);
$objBasicView->clsSessPartnerPref	= $sessPP;
$objBasicView->clsSessMatriId	= $sessMatriId;

$varMsgStatusAvail	= array_key_exists($varMsgOption, $arrRecItems);

if($varMsgStatusAvail){
	$varTableName	= '';
	$varWhereCond	= '';
	$varPrimaryKey	= '';
	$varFields		= array();
	$varMsgOptionVal= $varMsgOption{1};
	$varMsgIndexVal	= $arrMsgIndexVal[$varMsgOptionVal];
	//Get Table name
	switch($varMsgOptionVal){
		case 'M':
			$varPrimaryKey	= 'Mail_Id';
			$varOrderBy		= $arrRecItems[$varMsgOption][1];
			$varFields		= array('Mail_Id', 'Opposite_MatriId', 'Mail_Message AS Msg_Det', 'Status', $varOrderBy, 'Date_Received AS Received_Date');
			$varTableName	= $varTable['MAILRECEIVEDINFO'];
			if($arrRecItems[$varMsgOption][0] == 'A'){
				$varWhereCond = "MatriId=".$objBasicView->doEscapeString($sessMatriId,$objBasicView)." AND Status<4";
			}else{
				$varWhereCond = "MatriId=".$objBasicView->doEscapeString($sessMatriId,$objBasicView)." AND Status=".$arrRecItems[$varMsgOption][0];
			}
			break;

		case 'I':
			$varPrimaryKey	= 'Interest_Id';
			$varOrderBy		= $arrRecItems[$varMsgOption][1];
			$varFields		= array('Interest_Id', 'Opposite_MatriId', 'Interest_Option AS Msg_Det', 'Status', $varOrderBy,'Date_Received AS Received_Date');
			$varTableName	= $varTable['INTERESTRECEIVEDINFO'];
			if($arrRecItems[$varMsgOption][0] == 'A'){
				$varWhereCond = "MatriId=".$objBasicView->doEscapeString($sessMatriId,$objBasicView)." AND Status<4";
			}else{
				$varWhereCond = "MatriId=".$objBasicView->doEscapeString($sessMatriId,$objBasicView)." AND Status=".$arrRecItems[$varMsgOption][0];
			}
			break;

		case 'R':
			$varPrimaryKey	= 'RequestId';
			$varOrderBy		= $arrRecItems[$varMsgOption][1];
			$varFields		= array('RequestId', 'SenderId AS Opposite_MatriId', 'RequestFor AS Msg_Det', 'RequestDate','RequestDate AS Received_Date');
			$varTableName	= $varTable['REQUESTINFORECEIVED'];
			if($arrRecItems[$varMsgOption][0] == 'A'){
				$varWhereCond = "ReceiverId=".$objBasicView->doEscapeString($sessMatriId,$objBasicView)." AND Delete_Status=0";
			}else{
				$varWhereCond = "ReceiverId=".$objBasicView->doEscapeString($sessMatriId,$objBasicView)." AND Delete_Status=0 AND RequestFor=".$arrRecItems[$varMsgOption][0];
			}
			break;
	}

	$varTotalRecs	= 0;
	$varTotalPgs	= 0;
	if($varWhereCond != ''){
	$varWhereCond	= "WHERE ".$varWhereCond; 
	$varTotalRecs	= $objBasicView->numOfRecords($varTableName, $varPrimaryKey, $varWhereCond);
	}
	$varMsgCont	= '';
	if($varTotalRecs > 0){
		$varTotalPgs  = ceil($varTotalRecs / $varNoOfRec);
		$varPageNo	  = ($varTotalPgs >= $varPageNo) ? $varPageNo : 1;
		$varStartRec  = ($varPageNo-1)*$varNoOfRec;
		$varWhereCond.= ' ORDER BY '.$varOrderBy.' DESC LIMIT '.$varStartRec.', '.$varNoOfRec;
		$varResDet	  = $objBasicView->select($varTableName, $varFields, $varWhereCond, 0);
		$arrMsgDet	  = array();
		while($row = mysql_fetch_assoc($varResDet)){
			$arrOppMatriIds[]	= $row['Opposite_MatriId'];
			$arrMsgDet[$row[$varPrimaryKey]]['MsgId']			= $row[$varPrimaryKey];
			$arrMsgDet[$row[$varPrimaryKey]]['Opposite_MatriId']= strtoupper($row['Opposite_MatriId']);
			$arrMsgDet[$row[$varPrimaryKey]]['Msg_Det']			= $row['Msg_Det'];
			$arrMsgDet[$row[$varPrimaryKey]]['Status']			= $row['Status'];
			$arrMsgDet[$row[$varPrimaryKey]]['Date_Rec']		= $row[$varOrderBy];
			$varReceivedDate									= $row['Received_Date'];
		}
		
		//Basic View Related Functionality Starts Here
		$arrOppMatriIds	= array_unique($arrOppMatriIds);
		$varNoOfOppIds	= count($arrOppMatriIds);
		$varBVMatriIds	= "'".join("', '", $arrOppMatriIds)."'";
		$varWhereCond	= 'WHERE MatriId IN('.$varBVMatriIds.')';
		$varCondition['CNT']	= $varWhereCond;
		$varCondition['LIMIT']	= $varWhereCond;

		//Get BV Information
		$arrBVResult	= $objBasicView->selectDetails($varCondition, 'Y');

		if($varNoOfOppIds > $arrBVResult['TOT_CNT'])
		{
			unset($arrBVResult['TOT_CNT']);
			$varTotMissedIdsDet = array();
			$arrMissedIds = array_diff($arrOppMatriIds, $objBasicView->clsBVMatriIds);
			$varDelIds	  = "'".join("', '", $arrMissedIds)."'";
			$varDelIdsDet = $objBasicView->getDeletedIdsDet($varDelIds);

			if(count($arrMissedIds) > count($objBasicView->clsDelMatriIds))
			{
				$varTotMissedIds	= array_diff($arrMissedIds, $objBasicView->clsDelMatriIds);
							
				foreach($varTotMissedIds as $singVal)
				{
					$varTotMissedIdsDet[$singVal]['PU'] = 'TD';
				}
			}
			$arrMergedIds1	= array_merge($varDelIdsDet, $varTotMissedIdsDet);
			$arrMergedIds2	= array_merge($arrMergedIds1, $arrBVResult);
			$arrBVResult	= $arrMergedIds2;
		}else{ 
			unset($arrBVResult['TOT_CNT']);
		}

		//FRAMING BASIC VIEW
		$varBviewHTML	= '';
		$varMsgArrList	= array('M'=>'Message', 'I'=>'Interest', 'R'=>'Request');
		$arrMsgIconInfo	= array(0=>array('unread', 'unread'), 1=>array('read', 'read'), 2=>array('reply', 'replied'), 3=>array('decline', 'declined'));
		$arrIntIconInfo	= array(0=>array('unread', 'pending'), 1=>array('accept', 'accept'), 3=>array('decline', 'declined'));
		$arrReqIconInfo	= array(1=>array('reqphoto', 'photo'), 3=>array('reqphone', 'phone'), 5=>array('horoscope', 'horoscope'));

		$i = 0;
		foreach($arrMsgDet as $varMsgId=>$arrSinMsgDet)
		{
			$varCurrOppId	= $arrMsgDet[$varMsgId]['Opposite_MatriId'];
			$varCurrMsgDet	= $arrMsgDet[$varMsgId]['Msg_Det'];
			$varCurrStatus	= $arrMsgDet[$varMsgId]['Status'];
			$varCurrDtSent	= $arrMsgDet[$varMsgId]['Date_Rec'];
			$arrCurrBVDet	= $arrBVResult[$varCurrOppId];
			
			$varIconImg	= '';
			$varClass	= '';
			$varMsgTxt	= '';
			$varImgAlt	= '';
			switch($varMsgOptionVal){

				case 'M':
					$varCurrMsgDet	= explode('----- Original Message -----', strip_tags(preg_replace("/\n/", '<BR>',$varCurrMsgDet)));
					$varMsgTxtShort		= (strlen($varCurrMsgDet[0]) > 67)? substr($varCurrMsgDet[0], 0, 60).' ...' : $varCurrMsgDet[0];
					$varMsgTxt	=	stripslashes(str_replace('\n', '<br>',$varMsgTxtShort));
					if($varCurrStatus == 0){$varClass	= 'bld';}
					$arrIconInfo	= $arrMsgIconInfo[$varCurrStatus];
					break;

				case 'I':	
					$varMsgTxtShort	= substr($arrExpressInterestList[$varCurrMsgDet], 0, 60).' ...'; 
					$varMsgTxt	=	stripslashes(str_replace('\n', '<br>',$varMsgTxtShort));
					if($varCurrStatus == 0){$varClass	= 'bld';}
					$arrIconInfo	= $arrIntIconInfo[$varCurrStatus];
					break;

				case 'R':	
					$varClass	= 'bld';
					$varMsgTxt	= 'You have received a '.$arrRequestList[$varCurrMsgDet].' request'; 
					//$varMsgTxt = 'This member has requested you to add '.$arrRequestList[$varCurrMsgDet].' on '.$objMessage->getDaysTextInfo($varCurrDtSent);
					$arrIconInfo= $arrReqIconInfo[$varCurrMsgDet];
					break;
			}
			
			if($varMsgOptionVal != 'R') {
			  $varOnClick = 'show_box(\'event\',\'div_box'.$i.'\');showProfileInboxView(\''.$arrCurrBVDet['ID']."','".$varMsgIndexVal.'\',\''.$varMsgId.'\',\'R\',\'msgactpart'.$i.'\',\'div_box'.$i.'\',\''.$i.'\');';
              $varMsgTxt.='&nbsp;&nbsp;<a onclick="'.$varOnClick.'" class="clr1 smalltxt">More>></a>';
			}else {
              if($varCurrMsgDet == 1 && $varGetCookieInfo['PHOTOSTATUS']==0){
				$varMsgTxt .= '&nbsp;&nbsp;<input type="button" class="button" value="Add Photo" onclick="javascript:window.location.href=\''.$confValues['IMAGEURL'].'/photo/\';">';
			  }else if($varCurrMsgDet == 3 && $varGetCookieInfo['PHONEVERIFIED']==0){
			      $varMsgTxt .= '&nbsp;&nbsp;<input type="button" class="button" value="Add Phone" onclick="javascript:window.location.href=\''.$confValues['SERVERURL'].'/profiledetail/index.php?act=primaryinfo\';">';
			  }else if($varCurrMsgDet == 5 && $varGetCookieInfo['HOROSCOPESTATUS']==0){
			    $varMsgTxt .= '&nbsp;&nbsp;<input type="button" class="button" value="Add Horoscope" onclick="window.location.href=\''.$confValues['IMAGEURL'].'/horoscope/\';">';
			  }
			}
			
			if($varCurrDtSent == "0000-00-00 00:00:00"){
					$varCurrDtSent	=	$varReceivedDate;
			}

			$varCurrDtSent = date("d-M-Y",strtotime($varCurrDtSent));
			$varBviewHTML .= build_template($i,$varMsgIndexVal,$varMsgId,'R',$arrCurrBVDet,$varMsgArrList[$varMsgOptionVal]." received on $varCurrDtSent",$varMsgTxt."",$arrIconInfo);
			$i++;
		}
		print $varMsgOption.'#^~^#'.$varViews.'#^~^#'.$varTotalRecs.'#^~^#'.$varTotalPgs.'#^~^#'.$varPageNo.'#^~^#/mymessages/new_msg_ctrl.php#^~^#'.$varBviewHTML.'#^~^#'.$varMsgCont;
	}else{
		print $varMsgOption.'#^~^#1#^~^#0#^~^#0#^~^#0#^~^#/mymessages/new_msg_ctrl.php#^~^##^~^#'.$varMsgCont;
	}
}else{ print '1'; }
}else{ print '0'; }

//Unset Object
$objBasicView->dbClose();
$objMessage->dbClose();
unset($objBasicView);
unset($objMessage);
?>