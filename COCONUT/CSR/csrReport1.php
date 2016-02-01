<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$month = $_POST['month'];
$day =  $_POST['day'];
$year = $_POST['year'];
$ro = new database2();

$datez = $year."-".$month."-".$day;
echo "<Br><center>($datez)";

echo "<Br><br>Dispensed";
$ro->getCSR_dispensed($datez,$username,"dispensed");

echo "<br><br>Cancelled";
$ro->getCSR_dispensed($datez,$username,"cancelled");
?>
