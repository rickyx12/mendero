<?php
include("../../myDatabase2.php");
$returnNo = $_GET['returnNo'];
$inventoryCode = $_GET['inventoryCode'];
$returnFrom = $_GET['returnFrom'];
$returnTo = $_GET['returnTo'];
$username = $_GET['username'];
$qtyReturn = $_GET['qtyReturn'];


$ro = new database2();

echo "<br><br><br><br><br><br>";
$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/inventory/receiveDepartmentReturn1.php");
$ro->coconutHidden("returnTo",$returnTo);
$ro->coconutHidden("username",$username);
$ro->coconutHidden("returnNo",$returnNo);
$ro->coconutHidden("inventoryCode",$inventoryCode);
$ro->coconutHidden("qtyReturn",$qtyReturn);
$ro->coconutBoxStart_red("500","70");
echo "<br>";
echo "Received Return of $qtyReturn pcs <b>".$ro->selectNow("inventory","description","inventoryCode",$inventoryCode). "</b> of  <b>$returnFrom</b>?";
echo "<br><br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();


?>
