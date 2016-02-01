<?php
include("../../myDatabase2.php");

$verificationNo = $_POST['verificationNo'];
$inventoryCode = $_POST['inventoryCode'];
$description = $_POST['description'];
$qty = $_POST['qty'];
$borrowerDepartment = $_POST['borrowerDepartment'];
$returnBy = $_POST['returnBy'];

$ro = new database2();
$newQTY = ( $ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode) + $qty );
$ro->editNow("inventory","inventoryCode",$inventoryCode,"quantity",$newQTY);
$ro->csrReturnItem($verificationNo,$inventoryCode,$description,$qty,$borrowerDepartment,$returnBy,date("Y-m-d"),$ro->getSynapseTime());

echo "<br><Br><Br><center><font color=red>$description Returned</font>";

?>
