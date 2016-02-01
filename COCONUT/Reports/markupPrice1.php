<?php
include("../../myDatabase.php");
$inventoryCode = $_POST['inventoryCode'];
$markup = $_POST['markup'];

$ro = new database();

for($a=0,$b=0;$a<count($inventoryCode),$b<count($markup);$a++,$b++) {
$ro->editNow("inventory","inventoryCode",$inventoryCode[$a],"unitcost",$markup[$b]);
}

$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/Reports/markupPrice.php");

?>