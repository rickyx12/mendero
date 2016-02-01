<?php
include("../../../myDatabase2.php");
$itemNo = $_GET['itemNo'];
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$qty = $_GET['qty'];
$orNo = $_GET['orNo'];

$ro = new database2();
$ro->getPatientProfile($registrationNo);

if( $ro->doubleSelectNow("patientCharges","quantity","itemNo",$itemNo,"registrationNo",$registrationNo) < $qty ) {
echo "<script> alert('Pls Return a quantity that will not more than ".$ro->doubleSelectNow("patientCharges","quantity","itemNo",$itemNo,"registrationNo",$registrationNo)."'); window.back();</script>";
}else {

if( $ro->selectNow("patientCharges","quantity","itemNo",$itemNo) == $qty ) {

$ro->editNow("patientCharges","itemNo",$itemNo,"status","DELETED_".$username."[".date("Y-m-d")."@".date("H:i:s")."]-(return)");

}else {

$deductedQTY = ( $ro->selectNow("patientCharges","quantity","itemNo",$itemNo) - $qty );

$discountedPriceEachItem = ($ro->selectNow("patientCharges","cashPaid","itemNo",$itemNo) / $ro->selectNow("patientCharges","quantity","itemNo",$itemNo));
$discountEachItem = ($ro->selectNow("patientCharges","discount","itemNo",$itemNo) / $ro->selectNow("patientCharges","quantity","itemNo",$itemNo));

$ro->editNow("patientCharges","itemNo",$itemNo,"total",($discountedPriceEachItem * $deductedQTY));
$ro->editNow("patientCharges","itemNo",$itemNo,"discount",($discountEachItem * $deductedQTY));
$ro->editNow("patientCharges","itemNo",$itemNo,"cashPaid",($discountedPriceEachItem * $deductedQTY));
$ro->editNow("patientCharges","itemNo",$itemNo,"quantity",$deductedQTY);

}

$ro->returnInventory_pharmacy($itemNo,$registrationNo,$ro->selectNow("patientCharges","description","itemNo",$itemNo),$qty,date("Y-m-d")."@".date("H:i:s"),$username);

$ro->addVoidPayment($registrationNo."_".$ro->getPatientRecord_lastName().", ".$ro->getPatientRecord_firstName(),$itemNo."_".$ro->selectNow("patientCharges","description","itemNo",$itemNo),$ro->selectNow("patientCharges","cashPaid","itemNo",$itemNo),date("H:i:s"),date("Y-m-d"),$username,$orNo);

$newQTY = ($ro->selectNow("inventory","quantity","inventoryCode",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo)) + $qty);
$ro->editNow("inventory","inventoryCode",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo),"quantity",$newQTY);

}


$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientProfile_handler.php?registrationNo=$registrationNo&username=$username");

?>
