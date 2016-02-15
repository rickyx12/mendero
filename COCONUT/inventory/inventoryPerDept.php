<?php
include("../../myDatabase3.php");
$dept = $_GET['dept'];
$inventoryType = $_GET['inventoryType'];

$ro = new database3();


echo "<b>Dept:</b>&nbsp;".$dept;
echo "<br>";
echo "<b>Inventory Type:</b>&nbsp;".$inventoryType;
echo "<Br><br>";
$ro->inventoryReportDepartment($dept,$inventoryType);

?>
