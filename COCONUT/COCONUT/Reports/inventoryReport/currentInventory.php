<?php
include("../../../myDatabase.php");

$module = $_GET['module'];
$branch = $_GET['branch'];
$username = $_GET['username'];
$ro = new database();


$ro->getMasterListInventory("all","","medicine",$username,$branch);

?>
