<?php
include("../../myDatabase2.php");
$returnNo = $_GET['returnNo'];
$itemNo = $_GET['itemNo'];
$username = $_GET['username'];
$registrationNo = $_GET['registrationNo'];
$module = $_GET['module'];
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$fromTime_hour = $_GET['fromTime_hour'];
$fromTime_minutes = $_GET['fromTime_minutes'];
$fromTime_seconds = $_GET['fromTime_seconds'];
$toTime_hour = $_GET['toTime_hour'];
$toTime_minutes = $_GET['toTime_minutes'];
$toTime_seconds = $_GET['toTime_seconds'];
$nod = $_GET['nod'];


$ro = new database2();

$returnQTY = $ro->selectNow("returnInventory","qty","returnNo",$returnNo);
$newQTY = ( $ro->selectNow("patientCharges","quantity","itemNo",$itemNo) - $returnQTY );
$invQTY =( $ro->selectNow("inventory","quantity","inventoryCode",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo)) + $returnQTY );


if( $ro->selectNow("registrationDetails","dateUnregistered","registrationNo",$registrationNo) != "" ) {
echo "<br><br><br><Br><center><font color=red>Cannot Return.<br>The Patient is discharged<Br>This is to prevent possible changes in the S.O.A</font>";
}else {

if( $ro->selectNow("returnInventory","qty","returnNo",$returnNo) == $ro->selectNow("patientCharges","quantity","itemNo",$itemNo) ) {
$ro->editNow("patientCharges","itemNo",$itemNo,"status","DELETED_".$username);
$ro->editNow("inventory","inventoryCode",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo),"quantity",$invQTY);
$ro->editNow("returnInventory","returnNo",$returnNo,"returnDetails_PHARMACY",date("Y-m-d")."@".$ro->getSynapseTime());
$ro->editNow("returnInventory","returnNo",$returnNo,"returnPHARMACY",$username);
}else {

$ro->editNow("returnInventory","returnNo",$returnNo,"returnDetails_PHARMACY",date("Y-m-d")."@".$ro->getSynapseTime());
$ro->editNow("returnInventory","returnNo",$returnNo,"returnPHARMACY",$username);


$ro->editNow("patientCharges","itemNo",$itemNo,"quantity",$newQTY);
$ro->editNow("patientCharges","itemNo",$itemNo,"total",($ro->selectNow("patientCharges","sellingPrice","itemNo",$itemNo) * $newQTY));
$ro->editNow("patientCharges","itemNo",$itemNo,"cashUnpaid",($ro->selectNow("patientCharges","sellingPrice","itemNo",$itemNo) * $newQTY));



$ro->editNow("inventory","inventoryCode",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo),"quantity",$invQTY);
$ro->editNow("patientCharges","itemNo",$itemNo,"status","UNPAID");
$ro->editNow("patientCharges","itemNo",$itemNo,"departmentStatus","dispensedBy_".$username);



$regNo = $ro->selectNow("patientCharges","registrationNo","itemNo",$itemNo);
$chargeCodez = $ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo);
$desc = $ro->selectNow("patientCharges","description","itemNo",$itemNo);
$sp = $ro->selectNow("patientCharges","sellingPrice","itemNo",$itemNo);
$disc = $ro->selectNow("patientCharges","discount","itemNo",$itemNo);
$totz = ($ro->selectNow("patientCharges","sellingPrice","itemNo",$itemNo) * $returnQTY);
$excess = $ro->selectNow("patientCharges","cashUnpaid","itemNo",$itemNo);
$phicx = $ro->selectNow("patientCharges","phic","itemNo",$itemNo);
$companyx = $ro->selectNow("patientCharges","company","itemNo",$itemNo);
$timeChargex = $ro->selectNow("patientCharges","timeCharge","itemNo",$itemNo);
$dateChargex = $ro->selectNow("patientCharges","dateCharge","itemNo",$itemNo);
$chargeByx = $ro->selectNow("patientCharges","chargeBy","itemNo",$itemNo);
$servicex = $ro->selectNow("patientCharges","service","itemNo",$itemNo);
$titlex = $ro->selectNow("patientCharges","title","itemNo",$itemNo);
$paidViax = $ro->selectNow("patientCharges","paidVia","itemNo",$itemNo);
$cashPaidx = $ro->selectNow("patientCharges","cashPaid","itemNo",$itemNo);
$batchNox = $ro->selectNow("patientCharges","batchNo","itemNo",$itemNo);
$inventoryFromx = $ro->selectNow("patientCharges","inventoryFrom","itemNo",$itemNo);
$branch="Consolacion";
$dispensedBy = $ro->selectNow("patientCharges","departmentStatus","itemNo",$itemNo);


$ro->addCharges_return("DELETED_".$username."@".date("Y-m-d"),$regNo,$chargeCodez,$desc,$sp,$disc,$totz,$excess,$phicx,$companyx,$timeChargex,$dateChargex,$chargeByx,$servicex,$titlex,$paidViax,$cashPaidx,$batchNox,$returnQTY,$inventoryFromx,$branch,"Return From Item#:$itemNo",$dispensedBy);



}

$ro->gotoPage("http://".$ro->getMyUrl()."/Department/patientDepartmentProfile.php?registrationNo=$registrationNo&module=$module&username=$username&month=$month&day=$day&year=$year&fromTime_hour=$fromTime_hour&fromTime_minutes=$fromTime_minutes&fromTime_seconds=$fromTime_seconds&toTime_hour=$toTime_hour&toTime_minutes=$toTime_minutes&toTime_seconds=$toTime_seconds&nod=$nod");

}

?>
