<div style="padding-left:10px;padding-bottom:10px;">
	<div class="upgrade1"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/trans.gif" height="1"></div>
	<div class="upgrade3">
		<?php if($save_search_names!="") { ?>
			<div style="margin-left:8px;text-align:left;">
				<div class="eg-bar">		
					<div class="rigpanel mediumtxt boldtxt" style="padding:5px;" id="savenam_div">Saved Search<?php if($save_search_count>1)  echo "es";?> </div>
				</div>		
			</div>	

			<div style="margin-left:8px;text-align:left;">
				<div class="eg-bar" style="border:1px solid #CCCCCC;">				
					<div style="padding:0px 5px 0px 5px;">
						<?=$save_search_names;?>		
					</div>
				</div>		
			</div>
		<?php } ?>
		<div class="upgrade2"><img src="<?=$COMMONVARS['IM_SERVER_PREFFIX']?>/bmimages/trans.gif" height="1"></div>
	</div>	
</div>