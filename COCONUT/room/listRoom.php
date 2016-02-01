<?php
include("../../myDatabase2.php");

$ro = new database2();

echo "";
echo "<table border='1' cellspacing='0' rules='all' width='auto'>";
echo "<tr>";
echo "<th><b>Beds</b></th>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;<B>4th Floor</b></td>";
$ro->listRoom("4th floor");
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;<B>3rd Floor</b></td>";
$ro->listRoom("3rd floor");
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;<B>2nd Floor</b></td>";
$ro->listRoom("2nd floor");
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<font size=2><b>".$ro->listRoom_total." Patients</b></font></tD>";
echo "</tr>";

echo "</table>";
?>
