<?php
include("../../myDatabase2.php");
$returnNo = $_GET['returnNo'];
$returnTo = $_GET['returnTo'];
$username = $_GET['username'];
$ro = new database2();

$ro->editNow("inventoryDepartmentReturn","returnNo",$returnNo,"status","cancelled_".$username."_[".date("Y-m-d")."@".date("H:i:s")."]");


?>
