<?php
include("../../myDatabase2.php");
$verificationNo = $_GET['verificationNo'];
$description = $_GET['description'];
$username = $_GET['username'];
$batchNo = $_GET['batchNo'];
$ro = new database2();
$ro->coconutDesign();


$ro->coconutFormStart("post","cancelRequest1.php");
$ro->coconutHidden("verificationNo",$verificationNo);
$ro->coconutHidden("username",$username);
$ro->coconutHidden("batchNo",$batchNo);
echo "<Br><Br><br>";
$ro->coconutBoxStart_red("500","70");
echo "<Br>";
echo "<font color=red>Cancel $description???</font>";
echo "<Br><br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();


?>
