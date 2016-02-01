<?php
include("../../myDatabase2.php");
$returnNo = $_GET['returnNo'];
$inventoryCode = $_GET['inventoryCode'];
$returnFrom = $_GET['returnFrom'];
$returnTo = $_GET['returnTo'];
$username = $_GET['username'];

$ro = new database2();

$ro->coconutDesign();

echo "<br><br><br><br><br><br>";
$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/inventory/cancelDepartmentReturn1.php");
$ro->coconutHidden("returnTo",$returnTo);
$ro->coconutHidden("username",$username);
$ro->coconutHidden("returnNo",$returnNo);
$ro->coconutBoxStart_red("500","70");
echo "<br>";
echo "Cancel Return of <b>".$ro->selectNow("inventory","description","inventoryCode",$inventoryCode). "</b> in  <b>$returnFrom</b>?";
echo "<br><br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();


?>
