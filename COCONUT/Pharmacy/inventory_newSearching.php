<?php
include("../../myDatabase2.php");
$description = $_GET['description'];
$username = $_GET['username'];
$ro = new database2();

$ro->searchInventory_fewColumns($description,$username);

?>
