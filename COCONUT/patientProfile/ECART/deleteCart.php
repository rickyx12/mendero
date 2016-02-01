<?php
include("../../../myDatabase.php");
$itemNo = $_GET['itemNo'];
$batchNo = $_GET['batchNo'];
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$remarks = $_GET['remarks'];

$ro = new database();



if( strpos($ro->selectNow("patientCharges","departmentStatus","itemNo",$itemNo),'dispensedBy_') !== false ) {
echo "<script type='text/javascript'>alert('You cannot delete that meds/sup here its already dispensed pls return instead in Medicine menu');</script>";
}
else {

if( $ro->selectNow("inventory","autoDispense","inventoryCode",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo)) == "yes" ) {
//echo "<script type='text/javascript'>alert('You cannot delete that meds/sup here its already dispensed pls return instead in Medicine menu');</script>";
$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/patientProfile/itemDepartment.php?itemNo=$itemNo&username=$username&return=ecart");
}
else{
$title=$ro->selectNow("patientCharges","title","itemNo",$itemNo);

//$ro->deleteNow("patientCharges","itemNo",$itemNo);
//$ro->editNow("patientCharges","itemNo",$itemNo,"status","DELETED_".$username."[".date("Y-m-d")."@".$ro->getSynapseTime()."]");
if(($title=="LABORATORY")||($title=="RADIOLOGY")){

if($remarks==''){
echo "<font size='4' color='red'><b>Please input your reason.</b></font>";
echo "<META HTTP-EQUIV='Refresh'CONTENT='3;URL=http://".$ro->getMyUrl()."/COCONUT/patientProfile/ECART/reasonBeforeDeleteCart.php?registrationNo=$registrationNo&batchNo=$batchNo&username=$username&itemNo=$itemNo'>";
}
else{
$ro->editNow("patientCharges","itemNo",$itemNo,"pendingDelete","PENDING_".$username."_".date("Y-m-d")."_".$ro->getSynapseTime());
$datetime=date("YmdHis");
$rem=$remarks."_".$datetime;
$ro->editNow("patientCharges","itemNo",$itemNo,"deleteRemarks",$remarks);
echo "<font size='4' color='red'><b>Notify supervisor to delete the charge completely.</b></font>";
echo "<META HTTP-EQUIV='Refresh'CONTENT='4;URL=http://".$ro->getMyUrl()."/COCONUT/patientProfile/ECART/showCart_update.php?registrationNo=$registrationNo&batchNo=$batchNo&username=$username'>";
}

}
else{
$ro->editNow("patientCharges","itemNo",$itemNo,"status","DELETED_".$username."[".date("Y-m-d")."@".$ro->getSynapseTime()."]");
$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/patientProfile/ECART/showCart_update.php?registrationNo=$registrationNo&batchNo=$batchNo&username=$username");
}

}



}


?>
