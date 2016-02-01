<?php
include("../../myDatabase2.php");
$fromMonth = $_GET['fromMonth'];
$fromDay = $_GET['fromDay'];
$fromYear = $_GET['fromYear'];
$toMonth = $_GET['toMonth'];
$toDay = $_GET['toDay'];
$toYear = $_GET['toYear'];
$username = $_GET['username'];
$type = $_GET['type'];

$ro = new database2();

$date1 = $fromYear."-".$fromMonth."-".$fromDay;
$date2 = $toYear."-".$toMonth."-".$toDay;

echo "$date1 to $date2<br><br><center>";
$ro->toDischarge($date1,$date2,$username,$type);


?>
