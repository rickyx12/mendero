<?php
include("myDatabase2.php");

class convenienceDB extends database2 {

public function addInventory_convenience($description,$qty,$unitCost,$price,$username,$beginningQTY) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into convenienceInventory(description,qty,unitcost,price,dateAdded,timeAdded,addedBy,beginningQTY) values('".mysql_real_escape_string($description)."','$qty','$unitCost','$price','".date("Y-m-d")."','".date("H:i:s")."','".$username."','".$beginningQTY."')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}


public function getInventoryList($username) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      



$result = mysqli_query($connection, " select inventoryNo,description,qty,unitcost,price,dateAdded,timeAdded,beginningQTY from convenienceInventory where status not like 'deletedBy_%%%%%%%%' order by description asc ") or die("Query fail: " . mysqli_error()); 

echo "<CenteR><br><Br>";

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Beginning<br>QTY");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("UnitCost");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("Date Added");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['beginningQTY']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['unitcost']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData("&nbsp;".$row['dateAdded']);
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/convenience/editInventory.php?username=$username&inventoryNo=$row[inventoryNo]&description=$row[description]&qty=$row[qty]&unitcost=$row[unitcost]&price=$row[price]'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/pencil.jpeg'></a>&nbsp;</td>";
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/convenience/deleteInv.php?inventoryNo=$row[inventoryNo]&username=$username'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a> ");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}


public function getInventoryList_viewOnly() {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      



$result = mysqli_query($connection, " select inventoryNo,description,qty,unitcost,price,dateAdded,timeAdded from convenienceInventory where status not like 'deletedBy_%%%%%%%%' order by description asc ") or die("Query fail: " . mysqli_error()); 

echo "<CenteR><br><Br>";

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("UnitCost");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("Date Added");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['unitcost']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData("&nbsp;".$row['dateAdded']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}





public function searchInventory($username,$description,$transactionNo) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      



$result = mysqli_query($connection, " select inventoryNo,description,qty,price from convenienceInventory where description like '%%%%$description%%%%%' and status not like 'deletedBy_%%%%%%' order by description asc") or die("Query fail: " . mysqli_error()); 

echo "<Br>";

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/convenience/qty.php?inventoryNo=$row[inventoryNo]&transactionNo=$transactionNo&description=$row[description]&price=$row[price]&username=$username'><font color=red size=2>Buy</font></a> ");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}



public function transactNo() {
$myFile = $this->getReportInformation("homeRoot")."/COCONUT/convenience/transactionNo.dat";
$fh = fopen($myFile, 'r');
$theData = fread($fh, 1000);
fclose($fh);

    

$myFile = $this->getReportInformation("homeRoot")."/COCONUT/convenience/transactionNo.dat";
$fh = fopen($myFile, 'w') or die("can't open file"); 
fwrite($fh, $theData+1);
fclose($fh);
}




public function addSales($inventoryNo,$transactionNo,$description,$price,$qty,$total,$dateAdded,$timeAdded,$addedBy) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into convenience_sales(inventoryNo,transactionNo,description,price,qty,total,dateAdded,timeAdded,addedBy) values('$inventoryNo','$transactionNo','$description','$price','$qty','$total','$dateAdded','$timeAdded','$addedBy')";

 
if ( $sql->query($query) ) {
//echo "A new entry has been added with the `id`";
$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/convenience/searchInventory.php?username=$addedBy&transactionNo=$transactionNo");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}



public $showSales_total;

public function showSales($transactionNo) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$date=date("Y-m-d");
$result = mysqli_query($connection, " select salesNo,description,price,qty,total from convenience_sales where transactionNo = '$transactionNo' and dateAdded = '$date' order by description asc ") or die("Query fail: " . mysqli_error()); 

echo "<Br>";

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("Total");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->showSales_total += $row['total'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData("&nbsp;".$row['total']);
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/convenience/deleteSales.php?transactionNo=$transactionNo&salesNo=$row[salesNo]'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a> ");
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<font size=2><b>TOTAL</b></font>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".$this->showSales_total);
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();
}



public $showCollectionReport_total;

public function showCollectionReport($date,$time1,$time2) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      



$result = mysqli_query($connection, " select salesNo,description,price,qty,total,timeAdded,addedBy from convenience_sales where dateAdded='$date' and (timeAdded between '$time1' and '$time2')  order by timeAdded asc ") or die("Query fail: " . mysqli_error()); 

echo "<br>$date<br>$time1 - $time2<br><Center><Br>";

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Time");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("Total");
$this->coconutTableHeader("Paid By");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->showCollectionReport_total += $row['total'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['timeAdded']);
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData("&nbsp;".$row['total']);
$this->coconutTableData("&nbsp;".$row['addedBy']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<font size=2><b>TOTAL</b></font>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".$this->showCollectionReport_total);
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();
}




public function showAddedInventory($date) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      



$result = mysqli_query($connection, " select inventoryNo,description,qty,unitcost,price,dateAdded,timeAdded,addedBy from convenienceInventory where dateAdded='$date' and status = '' order by description asc ") or die("Query fail: " . mysqli_error()); 

echo "<br>$date<br><Center><Br>";

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Time");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("UnitCost");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("Date Added");
$this->coconutTableHeader("Time Added");
$this->coconutTableHeader("Added By");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['timeAdded']);
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['unitcost']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData("&nbsp;".$row['dateAdded']);
$this->coconutTableData("&nbsp;".$row['timeAdded']);
$this->coconutTableData("&nbsp;".$row['addedBy']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<font size=2><b>TOTAL</b></font>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();
}






public $showCollectionReport_new_total;

public function showCollectionReport_new($from,$to) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      



$result = mysqli_query($connection, " select cs.dateAdded,cs.description,cs.qty,ci.unitcost,ci.price from convenience_sales cs,convenienceInventory ci where ci.inventoryNo=cs.inventoryNo and cs.dateAdded between '$from' and '$to' order by cs.dateAdded,cs.timeAdded asc ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Unitcost");
$this->coconutTableHeader("Selling Price");
$this->coconutTableHeader("Total<br>UnitCost");
$this->coconutTableHeader("Total<br>Amount");
$this->coconutTableHeader("Profit/Net");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->showCollectionReport_new_total += (($row['price'] * $row['qty']) - ($row['unitcost'] * $row['qty']));
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateAdded']);
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['unitcost']);
$this->coconutTableData("&nbsp;".$row['price']);
$this->coconutTableData("&nbsp;".($row['unitcost'] * $row['qty']));
$this->coconutTableData("&nbsp;".($row['price'] * $row['qty']));
$this->coconutTableData("&nbsp;".(($row['price'] * $row['qty']) - ($row['unitcost'] * $row['qty'])));
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<b>Total</b>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->showCollectionReport_new_total,2));
$this->coconutTableRowStop();
$this->coconutTableStop();
}






}

?>
