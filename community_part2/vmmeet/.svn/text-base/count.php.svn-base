<?php 
  $evid= $_REQUEST['evid'];
  $opposite_gender =  $_REQUEST['opposite_gender'];
 $openfire = $_REQUEST['openfire'];

//echo "http://".$openfire.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=text";
$data = file_get_contents("http://".$openfire.":9090/plugins/presence/status?jid=all@$evid~$opposite_gender&type=count");

$data = trim($data);

if(trim($_REQUEST['currentpage']) != ''){
	$currentpage = $_REQUEST['currentpage'];
	$fromrequest=$currentpage;
}else{
	$currentpage = 1;
}

$numberofpage = ceil($data/2);

if($data > 0 && $data > 2)
{
	if($currentpage != $numberofpage)
	{
		$next = $currentpage + 1;
		$stval=(2*($next -1))+1;
		
		if($currentpage<$numberofpage){$endval=$stval+1; if($endval>$data) $endval=$data;}else{$endval=$data;}
		//echo "VALUES : cUR : $currentpage NO : $numberofpage START VAL : $stval END : $endval";
		$next_but= "<a class='clr1' href=\"javascript:PagingAjaxCall('".$stval."','".$endval."','null');next_count();\">>></a>";
		
	}
	if($currentpage > 1)
	{
		$prev = $currentpage - 1;
		//$prev_but='<a href="http://profile.tamilmatrimony.com/login/paging.php?total='.$data.'&currentpage='.$prev.'">Previous</a>';
		$endval=(2*($prev)-1)+1;
		$startval=$endval-1;
		$prev_but="<a class='clr1' href=\"javascript:PagingAjaxCall('".$startval."','".$endval."','null');prev_count();\"><<</a>";
	}
}
$thispagestartval=($currentpage-1)*2+1;
$thispageendval=$thispagestartval+1;
if($thispageendval > $data)
{
$thispageendval=$data;
}
echo "<font class='smalltxt boldtxt'><b>Total Users(".$data.")</b></font>~".$next_but."~".$prev_but."~".$currentpage."~".$thispagestartval."~".$thispageendval;
?>