<?php
include("../../../myDatabase2.php");
$inventoryCode = $_GET['inventoryCode'];
$department = $_GET['department'];
$description = $_GET['description'];
$date = $_GET['date'];
$time = $_GET['time'];
$username = $_GET['username'];
$qty = $_GET['qty'];

$ro = new database2();

$newQTY = ( $ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode) - $qty );

$ro->editNow("inventory","inventoryCode",$inventoryCode,"quantity",$newQTY);

$ro->addConsumed($inventoryCode,$department,$qty,$description,$date,$time,$username);

echo "<script>alert('$qty pcs of $description is now Consumed and deducted to the inventory ')</script>";

$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/inventory/department/searchInventory.php?username=$username&department=$department");

?>
