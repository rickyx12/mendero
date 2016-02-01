<?php
include("../../myDatabase2.php");
$station = $_POST['station'];

$ro = new database2();

$ro->showRoomUnderStation($station);

?>
