<?php 
    $start           = $_REQUEST['start'];
	$end             = $_REQUEST['end'];
	//$end=$start+19;
	$search_total    = $_REQUEST['total'];
	$search          = $_REQUEST['search'];
	
	$evid            = $_REQUEST['evid'];
    $opposite_gender = $_REQUEST['opposite_gender'];
    $openfire        = $_REQUEST['openfire'];

    if($search!="" && $search!="null") {
    $total = $search_total;
    }
	else {
	//$total = file_get_contents("http://".$openfire.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=count");
	$total=$_REQUEST['total'];
	//echo "URL <BR>" . "http://".$openfire.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=count<BR>";

	}
//echo "<BR>PAGING : START : $start END : $end TOTAL : $total<br>";

     //Prev link
	if($start>1)
	{
		// Not the first page show previous link
		
		$startVal = $start-2;
		$endVal =  $start-1;
	/*	if($end < 40)
		{
		$endVal =  20;
		}
	*/
		if($startVal > 0)
		{
		 $html = "<font class='clr1'><b><a href='javascript:;' onClick='PagingAjaxCall(".'"'.$startVal.'"'.",".'"'.$endVal.'"'.",".'"'.$search.'"'.")' class='clr1'><<</a></b></font>&nbsp;&nbsp;&nbsp;";
		 echo $html = str_replace("\n","",$html);
		}
    }

   //Next Link
   $startVal = $start+2;

   if(($end < ($total)) && ($total >2)&& ($startVal <$total)){
		//$startVal = $start+20;
		// 
		if($end+2 > $total) {
			$endVal = $total;
		} else {
			$endVal = $end+2;
		}

	 $html = "<font class='clr1'><b><a href='javascript:;'onClick='PagingAjaxCall(".'"'.$startVal.'"'.",".'"'.$endVal.'"'.",".'"'.$search.'"'.")' class='clr1'>>></a></b></font>&nbsp;&nbsp;&nbsp;";
	 echo $html = str_replace("\n","",$html);

  }
  if($total !=0) { 
  echo "<font class='smalltxt boldtxt'><b>".$start." to ".$end."</b></font>"; 
  }
 
 //echo "<BR>SERVER ADDRESS : ".$_SERVER['SERVER_ADDR']."<BR>count :$total";
?>
