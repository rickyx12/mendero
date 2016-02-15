<?php
include("../../myDatabase.php");

$ro = new database();
$ro->coconutDesign();
echo "<br><br><br><Br>";
$ro->coconutFormStart("get","inventoryPerDept.php");
$ro->coconutBoxStart("500","120");
echo "<Br>";
echo "<table>";
echo "<Tr>";
echo "<td>Dept</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("dept");
$ro->showOption_group("inventory","inventoryLocation");
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";

echo "<Tr>";
echo "<td>Type</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("inventoryType");
echo "<option>medicine</option>";
echo "<option>supplies</option>";
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
