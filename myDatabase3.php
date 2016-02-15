<?php
include("myDatabase2.php");


class database3 extends database2 {

public $myHost;
public $username;
public $password;
public $database;

public function __construct() {
  $this->myHost = $_SERVER['DB_HOST'];
  $this->username = $_SERVER['DB_USER'];
  $this->password = $_SERVER['DB_PASS'];
  $this->database = $_SERVER['DB_DB'];
}


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



public function inventoryReportDepartment($dept,$inventoryType) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT description,genericName,unitcost,Added,suppliesUNITCOST,quantity,expiration,dateAdded from inventory where inventoryType = '$inventoryType' and inventoryLocation = '$dept' and quantity > 0 and status not like 'DELETED%%%%%%' order by genericName,description asc ") or die("Query fail: " . mysqli_error()); 

echo "<table border=1 cellspacing=0 cellpadding=1 id='ReportTable'>";
echo "<tr>";
if($inventoryType == "medicine") {
echo "<th>Generic</th>";
echo "<th>Brand Name</th>";
echo "<th>QTY</th>";
echo "<th>Unitcost</th>";
echo "<th>Price</th>";
echo "<th>Encoded</th>";
echo "<th>Expiration</th>";
echo "</tr>";
}else {
echo "<th>Description</th>";
echo "<th>QTY</th>";
echo "<th>Unitcost</th>";
echo "<th>Price</th>";
echo "<th>Encoded</th>";
echo "<th>Expiration</th>";
}
while($row = mysqli_fetch_array($result))
{
$price = preg_split ("/\_/", $row['Added']); 
echo "<tr>";
if($inventoryType == "medicine") {
echo "<td>&nbsp;".$row['genericName']."</td>";
echo "<td>&nbsp;".$row['description']."</td>";
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td>&nbsp;".$row['unitcost']."</td>";
echo "<td>&nbsp;".$price[1]."</td>";
echo "<td>&nbsp;".$row['dateAdded']."</td>";
echo "<td>&nbsp;".$row['expiration']."</td>";
}else {
echo "<td>&nbsp;".$row['description']."</td>";
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td>&nbsp;".$row['suppliesUNITCOST']."</td>";
echo "<td>&nbsp;".$row['unitcost']."</td>";
echo "<td>&nbsp;".$row['dateAdded']."</td>";
echo "<td>&nbsp;".$row['expiration']."</td>";
}
echo "</tr>";
}
echo "</table>";
}







}




















?>
