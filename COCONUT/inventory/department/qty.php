<?php
include("../../../myDatabase2.php");
$inventoryCode = $_GET['inventoryCode'];
$department = $_GET['department'];
$description = $_GET['description'];
$date = $_GET['date'];
$time = $_GET['time'];
$username = $_GET['username'];

$ro = new database2();
$ro->coconutDesign();


echo "<br><br><br><br><center><font size=2 color=red>$description</font></center>";
$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/inventory/department/inventoryLog.php");
$ro->coconutHidden("inventoryCode",$inventoryCode);
$ro->coconutHidden("department",$department);
$ro->coconutHidden("description",$description);
$ro->coconutHidden("date",$date);
$ro->coconutHidden("time",$time);
$ro->coconutHidden("username",$username);
$ro->coconutBoxStart("500","85");
echo "<br>";
echo "<table border=0>";
echo "<Tr>";
echo "<td>QTY:&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox_short("qty","1");
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();


?>
