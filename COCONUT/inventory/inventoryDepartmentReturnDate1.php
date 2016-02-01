<?php
include("../../myDatabase2.php");
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$module = $_GET['module'];

$ro = new database2();

$date = $year."-".$month."-".$day;

$ro->getListOfReturnFromDepartmentReport($date,$module);


?>
