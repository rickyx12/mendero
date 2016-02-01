<?php
include("../../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$itemNo = $_GET['itemNo'];
$dateIn = $_GET['dateIn'];
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];

$ro = new database2();
$dateOut = $year."-".$month."-".$day;


$out = new DateTime($dateOut);
$in = new DateTime($dateIn);

$days = $out->diff($in)->d;

$ro->editNow("patientCharges","itemNo",$itemNo,"quantity",$days);
$ro->editNow("patientCharges","itemNo",$itemNo,"total", $ro->selectNow("patientCharges","sellingPrice","itemNo",$itemNo) * $days );
$ro->editNow("patientCharges","itemNo",$itemNo,"cashUnpaid", $ro->selectNow("patientCharges","sellingPrice","itemNo",$itemNo) * $days );
$ro->editNow("patientCharges","itemNo",$itemNo,"phic","0");
$ro->editNow("patientCharges","itemNo",$itemNo,"company","0");

echo "Room Completed!";

?>
