<?php
include("../../../myDatabase2.php");
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$title = $_GET['title'];

$ro = new database2();


echo "<br><br><center><font size=5>$title</font>";
echo "<br>";
echo "<font size=4>($date1 to $date2)</font>";

$ro->monthlyCashCollection_disbursement_details($date1,$date2,$title);


?>