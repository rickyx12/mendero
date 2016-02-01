<?php
include("../../myDatabase2.php");

$returnTo = $_GET['returnTo'];
$username = $_GET['username'];


$ro = new database2();


$ro->getListOfReturnFromDepartment($returnTo,$username);

?>
