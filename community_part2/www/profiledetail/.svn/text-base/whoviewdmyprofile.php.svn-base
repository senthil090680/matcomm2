<?php
#====================================================================================================
# Author 		: Gokilavanan
# Start Date	: 2011-03-05
# End Date		: 2011-04-27
# Project		: MatrimonyProduct
# Module		: Who viewed my profile - Count ony we are displaying
#====================================================================================================

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/lib/clsProfileDetail.php");

if($sessMatriId != ''){ ?>

<div class="rpanel fleft">
	<center>
		<div class="padt10">
			<div class="normtxt1 clr2 padb5 fleft"><font class="clr bld">Who Viewed My Profile</font></div><br clear="all">
			<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><div class="cleard"></div>
			<div class="smalltxt clr2 padt5 fleft tlleft" id="srtopbt">
				<br>
				<div class="alerttxt fleft "> <?=$varGetCookieInfo['VIEWSPROFILEBYOTHERCNT']?> Member(s) Viewed Your Profile</div><br clear="all"/>
				<div class="normtxt clr padt10" style="text-align:justify">Note: We consider it as a violation of privacy to disclose the identity of those members who have viewed your profile because viewing a profile does not necessarily mean that the member is interested in you.</div>
			</div>
            <div id="prevnext" class="padtb10">
			</div>
		</div>
	</center>
<br clear="all" />
</div>
<? } ?>