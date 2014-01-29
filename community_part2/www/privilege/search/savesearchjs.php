var http, http_for_religionandcaste;

function ajax_country_selected(countryid) {	
	try {
		var http_for_statelist = $getHTTPObject();
		var url = "ajaxlangversionrelcaste.php?stype=statelist&domain=bharat&countryid="+countryid;
		http_for_statelist.open("GET", url, true);
		http_for_statelist.onreadystatechange = function() {
			if(http_for_statelist.readyState==4) {
				var prev_div_val = $("state_div").innerHTML;
				$("state_div").innerHTML = prev_div_val+'<span id="span_st_'+countryid+'">'+http_for_statelist.responseText+'</span>';
			}
		} 
		http_for_statelist.send(null);
	} catch (e) {}
}

function ajax_state_selected(stateid) {	
	try {
		var http_for_citylist = $getHTTPObject();
		var url = "ajaxlangversionrelcaste.php?stype=citylist&domain=bharat&stateid="+stateid;
		http_for_citylist.open("GET", url, true);
		http_for_citylist.onreadystatechange = function() {
			if(http_for_citylist.readyState==4) {
				var prev_div_val = $("city_div").innerHTML;
				$("city_div").innerHTML = prev_div_val+'<span id="span_ct_'+stateid+'">'+http_for_citylist.responseText+'</span>';
			}
		} 
		http_for_citylist.send(null);
	} catch (e) {}
}

function deletesavedsearch_ajax(sval, saved_divname) {
	if(sval!="") {		
		fade('myphid','fadediv','dispdiv','400','','', 'searchresultpop.php?getp=sd&sval='+sval+'&saved_divname='+saved_divname,'','dispcontent','','');
	}
}

function delsavesearchajaxreq(sval, saved_divname) {	
	http_for_savedsearch = $getHTTPObject();		
	var url = "smartsavesearch.php?delete_search_id="+sval;
	http_for_savedsearch.open("GET", url, true);
	http_for_savedsearch.onreadystatechange = function() {
		if(http_for_savedsearch.readyState==4) {					
			var restext = http_for_savedsearch.responseText;
			$("contd").innerHTML = restext;					
			$(saved_divname).style.display = "none";
			$("yesnodiv").style.display = "none";
			$("clsdiv").style.display = "block";
			Jsg_save_search_count--;
			if(Jsg_save_search_count==0) {
				$(saved_divname).innerHTML ="No Saved Search available.";
				$(saved_divname).style.display = "block";
			}
								
			if(Jsg_save_search_count>1)
				$("savenam_div").innerHTML="Saved Searches";
			else
				$("savenam_div").innerHTML="Saved Search";
			if($("savesrch_label")) {
				if(Jsg_save_search_count < 3) {
					$("savesrch_label").innerHTML="Save this search";
					$("savedsrch_divname").innerHTML="<div class=\"smalltxt boldtxt\">Save Search<br><input type=\"text\" name=\"search_name\" id=\"search_name\" class=\"inputtext\" value=\"<?=$rec['SearchName'];?>\" size=\"35\" maxlength=\"10\" ><font class=\"smalltxt1\">(Example: My Search)</font></div><div align=\"right\" style=\"padding-top:2px;\"><input class=\"button\" value=\"Save & Search\" type=\"submit\"></div>";
				}
				else {
					$("savesrch_label").innerHTML="Saved search";
				}
			}
			
		}
	}
	http_for_savedsearch.send(null);
}

function catchange_ajax(sval,dm) {
	try {
		if(sval!="") 
			{
			var http_for_occlist = $getHTTPObject();
			var url = "ajaxlangversionrelcaste.php?domain="+dm+"&stype=occlist&sid="+sval;
			
			http_for_occlist.open("GET", url, true);
			http_for_occlist.onreadystatechange = function() {
				if(http_for_occlist.readyState==4) {
					document.MatriForm.OCCUPATION1.length=0;
					$("occ_div").innerHTML="";
					$("occ_div").innerHTML =http_for_occlist.responseText;
				}
			} 
			http_for_occlist.send(null);
		}
		else {
			document.MatriForm.OCCUPATION.readonly= true;
		}
	} catch (e) {}
}

function changereligion_ajax(sval,dm) {
	if(sval!="") {
		
		http_for_religionandcaste = $getHTTPObject();		
		var url = "ajaxlangversionrelcaste.php?domain="+dm+"&rid="+sval;		

		http_for_religionandcaste.open("GET", url, true);
		http_for_religionandcaste.onreadystatechange = function() {
			if(http_for_religionandcaste.readyState==4) {
				var selectboxes = http_for_religionandcaste.responseText;
				document.MatriForm.CASTE1.length=0;
				$("caste_div").innerHTML="";
				$("caste_div").innerHTML = selectboxes;
			}
		}
		http_for_religionandcaste.send(null);
	}
}
