<?php
include("../../myDatabase2.php");
$batchNo = $_GET['batchNo'];
$username = $_GET['username'];
$ro = new database2();
$ro->getRequestForCSR_itemized($batchNo,$username);

?>
