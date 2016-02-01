<?php
include("../../myDatabase2.php");
$inventoryCode = $_GET['inventoryCode'];
$description = $_GET['description'];
$from_inventoryCode = $_GET['from_inventoryCode'];
$qtyReturn = $_GET['qtyReturn'];
$returnBy = $_GET['returnBy'];
$returnTime = $_GET['returnTime'];
$returnDate = $_GET['returnDate'];
$returnFrom = $_GET['returnFrom'];
$returnTo = $_GET['returnTo'];
$status = $_GET['status'];


$ro = new database2();

$ro->inventoryDepartmentReturn($inventoryCode,$from_inventoryCode,$qtyReturn,$returnBy,$returnTime,$returnDate,$status,$returnFrom,$returnTo);

echo "<br><br><br><br><center><b>$description</b> is now in the list of return. <b>$returnTo</b> need to confirm before the <b>$description</b> will transfer to their inventory</center>";

?>
