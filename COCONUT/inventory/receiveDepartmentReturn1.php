<?php
include("../../myDatabase2.php");
$returnNo = $_GET['returnNo'];
$inventoryCode = $_GET['inventoryCode'];
$returnTo = $_GET['returnTo'];
$username = $_GET['username'];
$qtyReturn = $_GET['qtyReturn'];

$ro = new database2();

//addNewMedicine($stockCardNo,$description,$generic,$unitcost,$quantity,$expiration,$addedBy,$dateAdded,$timeAdded,$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$preparation,$phic,$added,$criticalLevel,$supplier,$begCapital,$begQTY,$suppliesUNITCOST,$autoDispense,$chargingStatus)


$stockCardNo = $ro->selectNow("inventory","stockCardNo","inventoryCode",$inventoryCode);
$description = $ro->selectNow("inventory","description","inventoryCode",$inventoryCode);
$generic = $ro->selectNow("inventory","genericName","inventoryCode",$inventoryCode);
$unitcost = $ro->selectNow("inventory","unitcost","inventoryCode",$inventoryCode);
$quantity = $qtyReturn;
$expiration = $ro->selectNow("inventory","expiration","inventoryCode",$inventoryCode);
$addedBy = $username;
$dateAdded = date("Y-m-d");
$timeAdded = date("H:i:s");
$inventoryLocation = $returnTo;
$inventoryType = $ro->selectNow("inventory","inventoryType","inventoryCode",$inventoryCode);
$remarks = "return from ".$ro->selectNow("inventoryDepartmentReturn","returnFrom","returnNo",$returnNo)." accepted by ".$username;
$preparation = $ro->selectNow("inventory","preparation","inventoryCode",$inventoryCode);
$added = $ro->selectNow("inventory","Added","inventoryCode",$inventoryCode);
$criticalLevel = $ro->selectNow("inventory","criticalLevel","inventoryCode",$inventoryCode);
$supplier = $ro->selectNow("inventory","supplier","inventoryCode",$inventoryCode);
$begCapital = $ro->selectNow("inventory","beginningCapital","inventoryCode",$inventoryCode);
$begQTY = $ro->selectNow("inventory","beginningQTY","inventoryCode",$inventoryCode);
$suppliesUNITCOST = $ro->selectNow("inventory","suppliesUNITCOST","inventoryCode",$inventoryCode);
$autoDispense = $ro->selectNow("inventory","autoDispense","inventoryCode",$inventoryCode);
$chargingStatus = "Locked";


if( $qtyReturn == $ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode) ) {
$ro->editNow("inventory","inventoryCode",$inventoryCode,"status","DELETED_".$ro->selectNow("inventoryDepartmentReturn","returnBy","returnNo",$returnNo)."_".date("Y-m-d")."@".date("H:i:s"));
}else {

//new qty ng irereturn na item
$newQTY = ( $ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode) - $qtyReturn );
//edit new qty ng irereturn n item
$ro->editNow("inventory","inventoryCode",$inventoryCode,"quantity",$newQTY);

}


$ro->addNewMedicine_inventoryDepartmentReturn($stockCardNo,$description,$generic,$unitcost,$quantity,$expiration,$addedBy,$dateAdded,$timeAdded,$inventoryLocation,$inventoryType,"","",$remarks,$preparation,"",$added,$criticalLevel,$supplier,$begCapital,$begQTY,$suppliesUNITCOST,$autoDispense,$chargingStatus,$ro->selectNow("inventoryDepartmentReturn","from_inventoryCode","returnNo",$returnNo),$returnNo);

$ro->editNow("inventoryDepartmentReturn","returnNo",$returnNo,"status","received");
$ro->editNow("inventoryDepartmentReturn","returnNo",$returnNo,"receivedBy",$username);
$ro->editNow("inventoryDepartmentReturn","returnNo",$returnNo,"receivedTime",date("H:i:s"));
$ro->editNow("inventoryDepartmentReturn","returnNo",$returnNo,"receivedDate",date("Y-m-d"));

?>
