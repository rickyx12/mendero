<?php
include("../../myDatabase2.php");
$username = $_GET['username'];
$ro = new database2();

$ro->coconutDesign();


$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/dietary/addDiet1.php");
$ro->coconutHidden("username",$username);
echo "<Br><br>";
$ro->coconutBoxStart("600","100");
echo "<Br>";
echo "<table border=0>";

echo "<tr>";
echo "<td>Diet Code</td>";
echo "<Td>";
$ro->coconutTextBox("dietCode","");
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Diet</td>";
echo "<Td>";
$ro->coconutTextBox("dietName","");
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<Br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();

?>
