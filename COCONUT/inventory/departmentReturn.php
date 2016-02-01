<?php
include("../../myDatabase2.php");
$description = $_GET['description'];
$inventoryCode = $_GET['inventoryCode'];
$from_inventoryCode = $_GET['from_inventoryCode'];
$returnBy = $_GET['returnBy'];
$returnTime = $_GET['returnTime'];
$returnDate = $_GET['returnDate'];
$status = $_GET['status'];
$inventoryLocation = $_GET['inventoryLocation'];
$quantity = $_GET['quantity'];


$ro = new database2();
$ro->coconutDesign();


echo "<Br><bR><Br><br><center><b>Inv Code</b>&nbsp;$inventoryCode<br><font color=red>$description</font></center>";


$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/inventory/departmentReturn1.php");
$ro->coconutHidden("inventoryCode",$inventoryCode);
$ro->coconutHidden("from_inventoryCode",$from_inventoryCode);
$ro->coconutHidden("returnBy",$returnBy);
$ro->coconutHidden("returnTime",$returnTime);
$ro->coconutHidden("returnDate",$returnDate);
$ro->coconutHidden("status",$status);
$ro->coconutHidden("description",$description);

$ro->coconutBoxStart("500","150");
echo "<br>";
echo "<table border=0>";
echo "<tr>";
echo "<td>QTY&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox_short("qtyReturn",$quantity);
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Return From&nbsp;</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("returnFrom");
echo "<option value='$inventoryLocation'>$inventoryLocation</option>";
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>Return To&nbsp;</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("returnTo");
echo "<option value='".$ro->selectNow("inventory","inventoryLocation","inventoryCode",$from_inventoryCode)."'>".$ro->selectNow("inventory","inventoryLocation","inventoryCode",$from_inventoryCode)."</option>";
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";


echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
