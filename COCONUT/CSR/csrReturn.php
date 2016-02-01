<?php
include("../../myDatabase2.php");
$username = $_GET['username'];
$description = $_GET['description'];
$verificationNo = $_GET['verificationNo'];
$inventoryCode = $_GET['inventoryCode'];
$qty = $_GET['qty'];
$borrowerDepartment = $_GET['borrowerDepartment'];


$ro = new database2();
$ro->coconutDesign();
echo "<Br><br>";
$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/CSR/csrReturn1.php");
$ro->coconutHidden("verificationNo",$verificationNo);
$ro->coconutHidden("inventoryCode",$inventoryCode);
echo "<center><font>Return Details</font>";
$ro->coconutBoxStart("500","180");
echo "<Br><table border=0>";
echo "<tr>";
echo "<tD>Description</td>";
echo "<Td>";
$ro->coconutTextBox("description",$description);
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<tD>QTY</td>";
echo "<Td>";
$ro->coconutTextBox_short("qty",$qty);
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<tD>From</td>";
echo "<Td>";
$ro->coconutTextBox_readonly("borrowerDepartment",$borrowerDepartment);
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<tD>Return By</td>";
echo "<Td>";
$ro->coconutTextBox("returnBy","");
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();
?>
