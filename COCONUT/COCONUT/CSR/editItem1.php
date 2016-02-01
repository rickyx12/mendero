<?php
include("../../myDatabase2.php");
$verificationNo = $_POST['verificationNo'];
$quantity = $_POST['quantity'];
$username = $_POST['username'];
$batchNo = $_POST['batchNo'];
$ro = new database2();

$ro->editNow("inventoryManager","verificationNo",$verificationNo,"quantity",$quantity);
$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/CSR/showRequest.php?username=$username&batchNo=$batchNo");

?>
