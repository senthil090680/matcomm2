<?php
		if ($sessMatriId !='') {
			if($sessGender!=$varMemberInfo['Gender']) {
				if ($varMatriId !="" && $sessMatriId !="") {
					$funBookmark	= 0;
					$funIgnored		= 0;
					$funBlocked		= 0;

					//check member action is available or not
					$argCondition	= "WHERE MatriId=".$objProfileDetail->doEscapeString($sessMatriId,$objProfileDetail)." AND Opposite_MatriId =".$objProfileDetail->doEscapeString($varMatriId,$objProfileDetail);
					$varCheckAction	= $objProfileDetail->numOfRecords($varTable['MEMBERACTIONINFO'],'MatriId',$argCondition);

					if($varCheckAction > 0) {
						$argFields		= array('MatriId', 'Opposite_MatriId', 'Bookmarked', 'Ignored', 'Blocked','Mail_Id_Sent','Mail_Id_Received','Interest_Id_Sent','Interest_Id_Received','Interest_Received_Date', 'Interest_Sent_Date', 'Mail_Sent_Date', 'Mail_Received_Date', 'Receiver_Replied_Date', 'Receiver_Declined_Date', "IF(Interest_Received_Date>Interest_Sent_Date AND Interest_Received_Date>Mail_Received_Date AND Interest_Received_Date>Mail_Sent_Date AND Interest_Received=1 AND Interest_Received_Date>Receiver_Replied_Date AND Interest_Received_Date>Receiver_Declined_Date,Interest_Received_Status,'N') AS IntRec", "IF(Interest_Sent_Date>Interest_Received_Date AND Interest_Sent_Date>Mail_Received_Date AND Interest_Sent_Date>Mail_Sent_Date AND Interest_Sent=1 AND Interest_Sent_Date>Receiver_Replied_Date AND Interest_Sent_Date>Receiver_Declined_Date,Interest_Sent_Status,'N') AS IntSen", "IF(Mail_Sent_Date>Interest_Received_Date AND Mail_Sent_Date>Mail_Received_Date AND Mail_Sent_Date>Interest_Sent_Date AND Mail_Sent=1 AND Mail_Sent_Date>=Receiver_Replied_Date AND Mail_Sent_Date>Receiver_Declined_Date,Mail_Sent_Status,'N') AS MsgSen", "IF(Mail_Received_Date>Interest_Received_Date AND Mail_Received_Date>Mail_Sent_Date AND Mail_Received_Date>Interest_Sent_Date AND Mail_Received=1 AND Mail_Received_Date>Receiver_Replied_Date AND Mail_Received_Date>Receiver_Declined_Date,Mail_Received_Status,'N') AS MsgRec", "IF(Receiver_Replied_Date>Interest_Received_Date AND Receiver_Replied_Date>Mail_Sent_Date AND Receiver_Replied_Date>Interest_Sent_Date AND Receiver_Replied=1 AND Receiver_Replied_Date>Mail_Received_Date AND Receiver_Replied_Date>Receiver_Declined_Date,'Y','N') AS MsgRep", "IF(Receiver_Declined_Date>Interest_Received_Date AND Receiver_Declined_Date>Mail_Sent_Date AND Receiver_Declined_Date>Interest_Sent_Date AND Receiver_Declined=1 AND Receiver_Declined_Date>Mail_Received_Date AND Receiver_Declined_Date>Receiver_Replied_Date,'Y','N') AS MsgDec");
						$funIconResult	= $objProfileDetail->select($varTable['MEMBERACTIONINFO'],$argFields,$argCondition,0);

						while($row = mysql_fetch_array($funIconResult)) {
							$funBookmark	= $row['Bookmarked'];
							$funIgnored		= $row['Ignored'];
							$funBlocked		= $row['Blocked'];
							$varIntSentDate	= $row['Interest_Sent_Date'];
							
							if ($row['IntRec'] != 'N') {
								$varContactIconStatus	= 1; //intreceived
								$varCIconImage			= ($row['IntRec']==0)?"unread":($row['IntRec']==1?"accept":"decline");
								$_REQUEST['msgfl']		= 2;
								$_REQUEST['msgid']		= $row['Interest_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Interest_Received_Date'];
								$funCMsg				= 'Interest received';
							} elseif ($row['IntSen'] != 'N') {
								$varContactIconStatus	= 1; //intsent
								$varCIconImage			= ($row['IntSen']==0)?"unread":($row['IntSen']==1?"accept":"decline");
								$_REQUEST['msgfl']		= 2;
								$_REQUEST['msgid']		= $row['Interest_Id_Sent'];
								$_REQUEST['msgty']		= "S";
								$funCDate				= $row['Interest_Sent_Date'];
								$funCMsg				= 'Interest sent';
							} elseif ($row['MsgRep'] == 'Y') {
								$varContactIconStatus	= 1; //msgaccept
								$varCIconImage			= 'reply';
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Receiver_Replied_Date'];
								$funCMsg				= 'Message replied';
							} elseif($row['MsgDec'] == 'Y') {
								$varContactIconStatus	= 1; //msgdecline
								$varCIconImage			= 'decline';
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Receiver_Declined_Date'];
								$funCMsg				= 'Message declined';
							} elseif ($row['MsgRec'] != 'N') {
								$varContactIconStatus	= 1; //sgrecd
								$varCIconImage			= ($row['MsgRec']==0)?"unread":"read";
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Received'];
								$_REQUEST['msgty']		= "R";
								$funCDate				= $row['Mail_Received_Date'];
								$funCMsg				= 'Message received';
							} elseif ($row['MsgSen'] != 'N') {
								$varContactIconStatus	= 1; //msgsent
								$varCIconImage			= ($row['MsgSen']==0)?"unread":($row['MsgSen']==1?"read":($row['MsgSen']==2?"reply":"decline"));
								$_REQUEST['msgfl']		= 1;
								$_REQUEST['msgid']		= $row['Mail_Id_Sent'];
								$_REQUEST['msgty']		= "S";
								$funCDate				= $row['Mail_Sent_Date'];
								$funCMsg				= 'Message sent';
							} else {
								$varContactIconStatus = 0;
								$varCIconImage = '';
							}
						}
					}
				}//if
				
				if($funBookmark==0 && $funBlocked==0) {
					$varBookMarkClass	= "disblk fleft pad3";
					$varBlockedClass	= "disblk fleft pad3";
					$varBarDivClass		= "disblk fleft pad3";
				} else {
					$varBarDivClass		= "disnon";
				}

				if ($funBookmark==1) {
					$varBookMarkClass	= "disnon";
				} else {
					$varBookMarkClass	= "disblk fleft pad3";
				}

				if ($funBlocked==1) { 
					$varBlockedClass	= "disnon";
				}else{
					$varBlockedClass	= "disblk fleft pad3";
				}
			}
		}//if

?>