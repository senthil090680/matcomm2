<?php
#====================================================================================================
# Author 		: Gokilavanan
# Date	        : 31-03-2011
# Project		: Community Matrimony Product
# Filename	    : phoneviewedbyme.php
# Description   : It's list in search result format, the "Phone viewed by" the Logged in Member
#====================================================================================================
if($sessMatriId != ''){
?>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchresults.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/searchpaging.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchbasicview.js"></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/srchviewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/viewprofile.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/list.js" ></script>
<div class="rpanel fleft">
	<center>
		<div class="padt10">
			<div class="normtxt1 clr2 padb5 fleft"><font class="clr bld">Phone Numbers Viewed By Me</font></div><br clear="all">
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><div class="cleard"></div>
			<div class="smalltxt clr2 padt5 fleft tlleft" id="srtopbt">
				<?if($sessMatriId != '' || 1){ ?>
				<font class="clr">Select : </font>
				<a class="clr1" href="javascript:;" onclick="chkAllTxt();">All</a> &nbsp|&nbsp;
				<a class="clr1"  href="javascript:;" onclick="chkNoneTxt();">None</a>
				<br><br>
				<div class="smalltxt padb5 fleft clr" id="listTitleDescription">Listed here are the members whose phone number you have viewed.</div>
			</div>
            <? } ?>
			<form method="post" name="buttonfrm">
			<div id="srinnertopbt">
				<?if($sessMatriId != ''){ ?>
				<div id="checkdiv" class="fleft" style="width:30px;">&nbsp;<div class="disnon"> <input type="checkbox" id="chk_all" name="chk_all" onclick="selectall(this.form, 'chk_all');"/> </div></div>
				<div id="mesgdiv" class="fleft">
					<div class="smalltxt clr2 padb5"><a class="clr1" onclick="sendListId('block','chk_all');">Block</a> &nbsp;|&nbsp; <a class="clr1" onclick="sendListId('shortlist','chk_all');">Favourites</a></div>
				</div><br clear="all">
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
				<? } ?>
			</div>

			<!-- Error throw div -->
			<center>
			<div id="listalldiv" class="brdr tlleft pad10" style="display:none;background-color:#EEEEEE;width:500px;">
			</div>
			</center><br clear="all">
			<!-- Error throw div -->

			<div id="serResArea">
				<img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" onload="getResult('PVBM');"/>
			</div><br clear="all"><br clear="all">
			</form>
			<div id="prevnext" class="padtb10">
			</div>
		</div>
	</center>
<br clear="all" />
</div>
<? }?>