<?php
include("../../myDatabase1.php");


$ro = new database1();
$ro->coconutDesign();
echo "<br><br>";
$ro->coconutFormStart("get","addPackage1.php");
$ro->coconutBoxStart("500","120");
echo "<Br>";
echo "<table border=0>";
echo "<tr>";
echo "<Td>Package Name&nbsp;</tD>";
echo "<td>";
$ro->coconutTextBox("packageName","");
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<Td>Price&nbsp;</tD>";
echo "<td>";
$ro->coconutTextBox("packagePrice","");
echo "</td>";
echo "</tr>";

echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
