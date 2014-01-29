<?php
include_once "chatfunctions.php";
$evid=trim($_REQUEST['evid']);
$EventInfo=get_event_info($evid);
$event_date=$EventInfo['event_date'];
$event_title=$EventInfo['EventTitle'];
$event_starttime=strtolower($EventInfo['event_starttime']);
$event_endtime=strtolower($EventInfo['event_endtime']);

echo '<div style="padding-bottom:10px;"><div style="background-color:#FDEAF0;width:750px"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div></div>
<div style="width:750px;text-align:left;line-height:15px"><font class="normaltxt1">Thank you for participating in the Online Matrimony Meet for'.$event_title.'We hope it has helped you in locating your ideal partner.This information will be available only for 7 days from the close of event. Good luck.<br><br>We appreciate your co-operation and response to the Online Matrimony Meet. Please mail your feedback to <a href="mailto:onlinematrimonymeet@bharatmatrimony.com" class="linktxt">onlinematrimonymeet@bharatmatrimony.com</a><br></div><BR><BR>';
?>