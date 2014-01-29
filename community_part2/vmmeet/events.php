<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Login
#=============================================================================================================
ini_set('display_errors',1);
error_reporting(E_ALL);
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES

include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0


// Page Variables If Required (eg. $PAGEVARS['PAGETITLE'] = 'View Profile - BharatMatrimony';)
$PAGEVARS['PAGETITLE']="Events - ".ucfirst('Agarwal');
$PAGEVARS['KEYWORDS']="===================Sample================";
$PAGEVARS['PAGEDESC']="===================Sample================";
$BREADCRUMB="<a href='/index.html'>Home</a> >> Privacy Policy"; // Examples like this
$PAGEVARS[BODYONLOAD]="";

?>
<? include_once("$DOCROOTPATH/template/headertop.php"); ?> 

<?include_once("$DOCROOTPATH/template/header.php");  ?>
<script language=javascript src="http://imgs.tamilmatrimony.com/scripts/fadewin.js"></script>
<script src="http://imgs.tamilmatrimony.com/scripts/div-opacity.js"></script>
<script language="javascript" src="http://imgs.bharatmatrimony.com/scripts/menutabber.js" type="text/javascript"></script>
<div id="myphid" class="fleft" style="border:0px solid #FF0000;">
<div class="fleft middiv">


	<!--{ middle area -->
	
	<div id="rndcorner" class="fleft middiv">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
			<div class="middiv-pad">
						<div class="fleft">
								<div class="tabcurbg fleft"> 

									<!--{ tab button none -->
									<div id="sectab1" class="fleft">									
										<div id="sectablink1_inactive" class="fleft" style="display:none;">
											<div class="fleft tableft"></div>
											<div class="fleft tabright"><div class="tabpadd"><a href="javascript:void(0)" onclick="clickTab(1,2,'sectab')" class="mediumtxt boldtxt clr3">Matrimony Meets</a></div></div>
										</div>
										<div id="sectablink1_active" class="fleft" style="display:block;">
											<div class="fleft tabclrleft"></div>
											<div class="fleft tabclrright"><div class="tabpadd"><font class="mediumtxt boldtxt clr4">Matrimony Meets</font></div></div>
										</div>
									</div> 
									<div id="sectab2" class="fleft">
										<div id="sectablink2_inactive" class="fleft" style="display:block;">
											<div class="fleft tableftsw"></div>
											<div class="fleft tabrightsw"><div class="tabpadd"><a href="javascript:void(0)" onclick="clickTab(2,2,'sectab')" class="mediumtxt boldtxt clr3">Online Matrimony Meets</a> </div></div>
										</div>
										<div id="sectablink2_active" class="fleft" style="display:none;">
											<div class="fleft tabclrleft"></div>
											<div class="fleft tabclrrtsw"><div class="tabpadd"><font class="mediumtxt boldtxt clr4">Online Matrimony Meets</font> </div></div>
										</div>
										
									</div>
									<!-- tab button none }-->

								</div>

								<div class="fleft tr-3"></div>
							</div>

				<!-- Content Area -->
				
				<br>
				<div class="middiv1">
				<div class="bl">
					<div class="br">
						<div class="middiv-pad1">
					
							  <!-- <div class="middiv2" class="smalltxt"> -->

							  <div id="sectab_content_1" class="smalltxt" style="display:block">
							  <div class="smalltxt" style="padding:10px 0px 10px 0px;">BharatMatrimony conducts 'Matrimony Meets' that create a platform for prospective brides and grooms and their parents to meet and interact. </div>

							  <div class="fleft" style="width:508px;">
								<div class="innertabbr1 fleft"></div>
								<div style="float:left; width:506px; height:50px; background:url(http://imgs.bharatmatrimony.com/bmimages/inner-tab-bg.gif) repeat-x;">
									<div style="float:left;padding-left:15px;">
										<div style="float:left; display:block;">
											<div class="innermtabbg1 fleft"></div>
											<div class="innermtabbg2 fleft">
												<div style="padding:5px 10px 0px 5px;" class="mediumtxt boldtxt ">Forthcoming Meets</div>
												<div style="margin-top:6px; padding-left:55px;"><img src="http://imgs.bharatmatrimony.com/bmimages/inner-mtab-down-arrow.gif" width="11" height="7" border="0" alt=""></div>
											</div>						
										</div>
									</div>
						    	</div>
								<div class="fleft innertabbr1"></div>
							  </div>
							    <div style="width:508px;">
									<div class="fleft innertabbr2"></div>
									<div style="float:left; width:506px;">
									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 10px 0px 10px 0px;">Name of the meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 10px 0px 10px 10px;" class="boldtxt">Community</div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 10px 0px 10px 10px;" class="boldtxt">Venue</div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 10px 0px 10px 10px;" class="boldtxt">Date</div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Kapu Meet </div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Kapu</div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Vizag </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">17-05-2008</div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Gowda Meet </div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Gowda </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Mysore </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">30-05-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Lingayath Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Lingayath </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Bangalore  </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">22-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>
									
									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Nadar Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Nadar </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Madurai  </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">28-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Hindi Agarwal Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Hindi Agarwal </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Jaipur   </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">25-05-2008  </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>
									
									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Hindi Brahmin Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Hindi Brahmin  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Delhi    </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">25-05-2008  </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Hindi Agarwal Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Hindi Agarwal </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Chandigarh </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">29-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Brahmin Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Brahmin  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Bhubaneswar </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">08-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Kayastha Meet </div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Kayastha  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Kolkata </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">22-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Patel Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Patel  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Surat </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">18-05-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Billava Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 10px 0px 10px 10px;">Billava  - Kanada -<br> (as a special case)  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 20px 10px;">Mumbai </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 20px 10px;" class="clr1">25-05-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Vaishnav Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Vaishnav  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Valsad </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">15-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:160px;padding: 15px 0px 15px 0px;">Gujarathi - Vaishnav Meet</div>
									<div class="fleft dotline" style="width:145px;"><div style="padding: 15px 0px 15px 10px;">Gujarathi -Vaishnav  </div></div>
									<div class="fleft dotline" style="width:90px;"><div style="padding: 15px 0px 15px 10px;">Mumbai </div></div>
									<div class="fleft dotline" style="width:85px;"><div style="padding: 15px 0px 15px 10px;" class="clr1">29-06-2008 </div></div><br clear="all">
									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>


									</div>
									<div class="fleft innertabbr2"></div>
							  </div>
							  </div>


							  <!-- Online Matrimony Meet -->
							  <div id="sectab_content_2" class="smalltxt" style="display:none">
							  <div class="smalltxt" style="padding:10px 0px 10px 0px;">BharatMatrimony has pioneered 'Online Matrimony Meets', where you can meet prospects from your own community online and interact.</div>

							  <div class="fleft" style="width:508px;">
								<div class="innertabbr1 fleft"></div>
								<div style="float:left; width:506px; height:50px; background:url(http://imgs.bharatmatrimony.com/bmimages/inner-tab-bg.gif) repeat-x;">
									<div style="float:left;padding-left:15px;">
										<div style="float:left; display:block;">
											<div class="innermtabbg1 fleft"></div>
											<div class="innermtabbg2 fleft">
												<div style="padding:5px 10px 0px 5px;" class="mediumtxt boldtxt ">Forthcoming Meets</div>
												<div style="margin-top:6px; padding-left:55px;"><img src="http://imgs.bharatmatrimony.com/bmimages/inner-mtab-down-arrow.gif" width="11" height="7" border="0" alt=""></div>
											</div>						
										</div>
									</div>
						    	</div>
								<div class="fleft innertabbr1"></div>
							  </div>
							  <div style="width:508px;">
									<div class="fleft innertabbr2"></div>
									<div style="float:left; width:506px;">
									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Name of the meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 10px 0px 10px 10px;" class="boldtxt">Community</div></div>
									<div class="fleft dotline boldtxt" style="width:150px;padding: 10px 0px 10px 2px;"><center>Date & time</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Christian Kerala<br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 10px 0px 10px 10px;">Christian - Catholic<br>Christian - Orthodox</div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>07-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Christian Kerala<br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 20px 0px 16px 10px;">Christian - Protestant</div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>08-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Christian Telugu <br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 20px 0px 16px 10px;">Christian </div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>08-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Christian Tamil<br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 10px 0px 10px 10px;">Christian - Catholic<br>Christian - Protestant</div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>14-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Buddhist <br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 20px 0px 16px 10px;">Buddhist </div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>15-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Jain<br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 20px 0px 16px 10px;">Jain </div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>15-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>

									<div style="padding:0px 10px 0px 10px;" class="smalltxt">
										<div class="fleft boldtxt" style="width:150px;padding: 10px 0px 10px 0px;">Sikh<br>Matrimony Meet</div>
									<div class="fleft dotline" style="width:180px;"><div style="padding: 20px 0px 16px 10px;">Sikh </div></div>
									<div class="fleft dotline clr1" style="width:150px;padding: 20px 0px 16px 2px;"><center>21-06-2008</center></div><br clear="all">

									<div class="borderline"><img src="http://imgs.bharatmatrimony.com/bmimages/trans.gif" width="1" height="1"></div>
									</div>


									</div>
									<div class="fleft innertabbr2"></div>
							  </div>	
							  </div>

					<br clear="all" /><br>
								
						</div>
					</div>
				</div>
				</div>
				<!-- Content Area -->
			</div>

			<!-- Content Area -->


		
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>	
	<!-- middle area }-->
	<br clear="all"><br>

	<br clear="all">
		
	
	</div>

	<!--{middle area }-->
<? include_once("$DOCROOTPATH/template/rightpanel.php"); ?>
</div>
<? include_once("$DOCROOTPATH/template/footer.php"); ?>