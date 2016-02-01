<?php
include("../../myDatabase2.php");
$verificationNo = $_GET['verificationNo'];
$description = $_GET['description'];
$quantity = $_GET['quantity'];
$username = $_GET['username'];
$batchNo = $_GET['batchNo'];
$ro = new database2();
$ro->coconutDesign();



echo "<Br><br><br>";
$ro->coconutFormStart("post","editItem1.php");
$ro->coconutHidden("verificationNo",$verificationNo);
$ro->coconutHidden("username",$username);
$ro->coconutHidden("batchNo",$batchNo);
$ro->coconutBoxStart("500","100");
echo "<Br>";
echo "<table border=0>";
echo "<tr>";
echo "<td>Description</td>";
echo "<td>";
$ro->coconutTextBox_readonly("description",$description);
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<Td>QTY</td>";
echo "<td>";
$ro->coconutTextBox_short("quantity",$quantity);
echo "</td>";
echo "</tr>";

echo "</table>";
echo "<Br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
