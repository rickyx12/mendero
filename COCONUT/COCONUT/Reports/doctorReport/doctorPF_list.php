<?php
include("../../../myDatabase.php");
$username = $_GET['username'];
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$month1 = $_GET['month1'];
$day1 = $_GET['day1'];
$year1 = $_GET['year1'];
$show = $_GET['show'];

$ro = new database();

echo "<center><font size=5>Doctor's PF Listing</font></center>";
echo "<center><font size=3>OPD</font></center>";
echo "<center><font size=3>( $month $day, $year - $month1 $day1, $year1 )</font></center>";

$ro->getDoctorPFReport("OPD",$username,$month,$day,$year,$month1,$day1,$year1,$show);

?>
