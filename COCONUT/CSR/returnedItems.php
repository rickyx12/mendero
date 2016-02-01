<?php
include("../../myDatabase2.php");

$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];

$ro = new database2();
$datez = $year."-".$month."-".$day;
$ro->getReturnedItem($datez);

?>
