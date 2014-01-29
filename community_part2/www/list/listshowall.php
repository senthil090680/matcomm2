<?php
#====================================================================================================
# Author 		: Senthilnathan.M
# Start Date	: 21 Jul 2008
# End Date		: 21 Jul 2008
# Project		: MatrimonyProduct
# Module		: Search  Results
#====================================================================================================
$varListType	= ($_REQUEST['listtype']=='')?'SL':$_REQUEST['listtype'];

$varDeleteLink	= ($varListType=='SL')? 'Remove from favourites' : 'Unblock';

$varlistTitleDescription	= ($varListType=='SL')? 'Listed here are profiles that you have added to your favourite list' : 'Listed here are profiles blocked by you';
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhomeresult.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/myhome.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
<div class="rpanel fleft">
	<center>
			<div class="normtxt1 clr2 padb5 fleft"><font class="clr bld">Lists</font>  
			<!-- <a class="clr1 normtxt" href="<?=$confValues['SERVERURL']?>/search/">[Modify]</a> --></div><br clear="all">
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
			<div class="smalltxt clr2 padt5"><div class="fleft"><font class="clr">Show : </font><a id="msgsl" class="clr1" href="<?=$confValues['SERVERURL']?>/list/">Favourites</a> &nbsp;|&nbsp; <a id="msgbk" class="clr1" href="<?=$confValues['SERVERURL']?>/list/index.php?listtype=BK">Blocked</a></div>
			
			<? 
			if($varGetCookieInfo['SHORTLISTCNT'] <= 0  && $varListType == 'SL') {
			   $varDeleteLink = '';$varlistTitleDescription='';
			}
			else if($varGetCookieInfo['BLOCKLISTCNT'] <= 0  && $varListType == 'BK') {
			   $varDeleteLink = '';$varlistTitleDescription='';
			}
			?>
		
			<div id="del_div" class="fright"><a id="listrequests" class="clr1" onclick="funListDeleteConfirm();"><?=$varDeleteLink;?></a></div></div><br clear="all">

			<br clear="all">
            <div class="smalltxt padb5 fleft" id="listTitleDescription"><?=$varlistTitleDescription?></div>

			<form method="post" name="buttonfrm">
			<input type="hidden" id="purp" name="purp" value="<?=$varListType?>">
			<div id="errorDivConfirm" style="display:none;background-color:#ffffff;width:540px;">
				Are you sure you want to delete these members from your List?
				<input type="button" class="button" value="Yes" onClick="funListDelete();">
				<input type="button" class="button" value="No" onClick="document.getElementById('errorDiv').style.display='none'">
			</div><br clear="all">
			
			<center><div id="errorDiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:480px;">
			</div></center><br clear="all">
			
			<div id="msgResults">
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="funListMain('<?=$varListType?>');"/>
			</div>
			</form>
			<div id="prevnext" class="padtb10">
			</div>
	</center>
</div>
<br clear="all" />