<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$module = $_POST['module'];
$ro = new database2();

$ro->getTotalRequest("departmentX",$username,$module,$ro->getUserBranch_username($username,$module));
echo "<font color=red>(".$ro->allRequest().")</font>";


?>
