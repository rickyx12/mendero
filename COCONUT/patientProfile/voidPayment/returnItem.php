<?php
include("../../../myDatabase2.php");
$itemNo = $_GET['itemNo'];
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$orNO = $_GET['orNO'];


$ro = new database2();
$ro->coconutDesign();
$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/patientProfile/voidPayment/returnItem1.php");
echo "<Br><br>";
$ro->coconutBoxStart("500","200");
echo "<br>";
echo "<table border=0>";
echo "<Tr>";
echo "<td>Description:&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox("description",$ro->selectNow("patientCharges","description","itemNo",$itemNo));
echo "</td>";
echo "</tr>";

echo "<Tr>";
echo "<td>QTY Return:&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox_short("qty",$ro->selectNow("patientCharges","quantity","itemNo",$itemNo));
echo "</td>";
echo "</tr>";

echo "<Tr>";
echo "<td>OR#:&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox_short_readonly("orNo",$orNO);
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br><br>";
$ro->coconutButton("Proceed");
$ro->coconutHidden("itemNo",$itemNo);
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
