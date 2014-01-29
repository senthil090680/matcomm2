<?php
$evid				= trim($_REQUEST['evid']);
$EventInfo			= get_event_info($evid);
$event_date			= $EventInfo['event_date'];
$event_title		= $EventInfo['EventTitle'];
$event_starttime	= $EventInfo['EventStartTime'];
$event_endtime		= $EventInfo['EventEndTime'];



//echo $evid."<br>".$EventInfo."<br>".$event_date."<br>".$event_title."<br>".$event_starttime."<br>".$event_endtime;
// a START time value
$start=date("H:i:s");
//$start ='10:10:10';
// an END time value
$end=$event_endtime;

// what is the time difference between $end and $start?
if( $diff=@get_time_difference($start, $end) )
{
 $timertip=sprintf( '%02d:%02d:%02d', $diff['hours'], $diff['minutes'],$diff);
}
else
{
  $timertip="";
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

?>