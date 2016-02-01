<?php
include("../../myDatabase2.php");
$username = $_GET['username'];
$ro = new database2();
echo "<center>";
$ro->viewDiet($username);

?>


