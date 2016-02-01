<?php
include("../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$itemNo = $_GET['itemNo'];
$savedNo = $_GET['savedNo'];
$itemNoOfResult = $_GET['itemNoOfResult'];

$ro = new database2();


$ro->connectedResult($registrationNo,$itemNo,$savedNo,$itemNoOfResult);

?>
