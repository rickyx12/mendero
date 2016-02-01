<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$dietName = $_POST['dietName'];
$dietCode = $_POST['dietCode'];
$ro = new database2();

$ro->addDiet($dietName,$dietCode,$username);

?>
