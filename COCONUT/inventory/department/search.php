<?php
include("../../../myDatabase2.php");
$description = $_GET['description'];
$department = $_GET['department'];
$username = $_GET['username'];

$ro = new database2();


$ro->deptInventory($description,$department,$username);


?>
