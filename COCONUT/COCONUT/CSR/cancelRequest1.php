<?php
include("../../myDatabase2.php");
$verificationNo = $_POST['verificationNo'];
$username = $_POST['username'];
$batchNo = $_POST['batchNo'];
$ro = new database2();

$ro->editNow("inventoryManager","verificationNo",$verificationNo,"status","cancelled");
$ro->editNow("inventoryManager","verificationNo",$verificationNo,"dispensedDate",date("Y-m-d"));

$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/CSR/showRequest.php?username=$username&batchNo=$batchNo");

?>
