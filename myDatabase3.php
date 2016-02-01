<?php
include("myDatabase2.php");


class database3 extends database2 {



public function inventoryListToExcel($type) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT description,genericName,quantity from inventory where status not like 'DELETED%%%%%' and quantity > 0 and inventoryType = '$type' order by description asc ") or die("Query fail: " . mysqli_error()); 

echo "<table border=1 cellspacing=0 cellpadding=1 id='ReportTable'>";
echo "<tr>";
echo "<th>Brand Name</th>";
echo "<th>Generic</th>";
echo "<th>QTY (system)</th>";
echo "<th>QTY (on hand)</th>";
echo "<th>Variance</th>";
echo "<th>Adjusted QTY</th>";
echo "<th>Unitcost</th>";
echo "<th>Total Cost</th>";
echo "</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>&nbsp;".$row['description']."</td>";

echo "<td>&nbsp;".$row['genericName']."</td>";

echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
}
echo "</table>";
}








}




















?>
