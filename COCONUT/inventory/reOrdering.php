<?php
include("../../myDatabase2.php");

$ro = new database2();

$ro->reOrderingWithSpecifiedQTY("PHARMACY","11","50");

echo "<br><hr><br>";

$ro->reOrderingWithSpecifiedQTY("PHARMACY","2","10");

echo "<br><hr><br>";

$ro->reOrderingWithSpecifiedQTY("PHARMACY","1","1");


?>
