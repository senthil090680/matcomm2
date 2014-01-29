<?php
/**********************************/
/*Name:Thavaprkash.S.             */
/*Date:June 04-2010		          */
/**********************************/
include_once($varRootBasePath.'/conf/com_phonefunction.inc');
include_once($varRootBasePath.'/conf/vars.inc');

/* begin thava edited for auto click to call on June 04-2010*/

	$varCondition	= " WHERE MatriId='".$sessMatriId."'";
	$varFields		= array('Password');
	$varResults		= $objRegister->select($varTable['MEMBERLOGININFO'],$varFields,$varCondition,1);
	$varPassword	= $varResults[0]['Password'];

	//DELETE memberpartlyinfo INFO
	if ($varPartlyId !="" && $sessMatriId!="") {
		$varCondition		= "Member_Id='".$varPartlyId."'";
		$objRegister->delete($varTable['MEMBERPARTLYINFO'],$varCondition);
	}
?>

<div class="fleft normtxt1 clr bld padb5">Congrats, you have successfully registered on <?=$varUcDomain?> Matrimony!</div>
<br clear="all" />
<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
<br clear="all" /> 
<center>
 <div class="padtb10 normtxt clr">
	<div class="bld padl25 fleft">Your login details</div><br clear="all">
	<div class="fleft padl25 tlleft" style="width:85px;padding-top:5px;padding-bottom:5px;">User ID</div>
	<div class="fleft padl25 tlleft" style="padding-top:5px;padding-bottom:5px;">:</div>
	<div class="fleft pdl10" style="padding-top:5px;padding-bottom:5px;"><?=$sessMatriId?></div><br clear="all">
	<div class="fleft padl25 tlleft" style="width:85px;padding-top:5px;padding-bottom:5px;">Password:</div>
	<div class="fleft padl25 tlleft" style="padding-top:5px;padding-bottom:5px;">:</div>
	<div class="fleft pdl10 tlleft" style="padding-top:5px;padding-bottom:5px;"><?=$varPassword?></div><br clear="all">
	<div class="fleft padl25">(Please use it henceforth to login to the site.)</div><br clear="all"><br>
	<div class="dotsep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<br clear="all" />
    <div class="fleft padl25 tlleft pfdivlt">
	<input type="button" class="button" value="Continue" onClick="document.location.href='/profiledetail/'">
	</div><br clear="all" 
	/>
	</div>
</center>
</div>
<br clear="all" />
		<div class="normtxt fright padr20"><a class="clr1" href="index.php?act=intermediateregister">Skip this page</a></div><br clear="all">
</center>

<!-- end thava edited for congrates on June 04-2010 -->
