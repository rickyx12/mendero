<?php
include("../../myDatabase2.php");
$verificationNo = $_GET['verificationNo'];
$countVerification = count($verificationNo);
$username = $_GET['username'];
$ro = new database2();

for( $x=0;$x<$countVerification;$x++ ) {
$identifier = preg_split ("/\_/", $verificationNo[$x]);  // $identifier[0]=verificationNo, identifier[1]=inventoryCode
//echo $verificationNo[$x];//verificationNo na galing sa inventoryManager table [serve as unique identifier]


if( $ro->selectNow("inventory","quantity","inventoryCode",$identifier[1]) >= $ro->selectNow("inventoryManager","quantity","verificationNo",$identifier[0]) ) { //double check kung mas mataas p ung in stock qty
$newQTY = ( $ro->selectNow("inventory","quantity","inventoryCode",$identifier[1]) - $ro->selectNow("inventoryManager","quantity","verificationNo",$identifier[0]) );
$ro->editNow("inventory","inventoryCode",$identifier[1],"quantity",$newQTY);
$generic = "";
$pricing = $ro->selectNow("inventory","unitcost","inventoryCode",$identifier[1]);
$expiration= "";
//addNewMedicine($description,$generic,$unitcost,$quantity,$expiration,$addedBy,$dateAdded,$timeAdded,$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$preparation,$phic,$added,$criticalLevel,$supplier,$begCapital,$begQTY,$suppliesUNITCOST)
$ro->addNewMedicine($ro->selectNow("inventoryManager","description","verificationNo",$identifier[0]),$generic,$pricing,$ro->selectNow("inventoryManager","quantity","verificationNo",$identifier[0]),$expiration,$ro->selectNow("inventoryManager","requestingUser","verificationNo",$identifier[0]),date("Y-m-d"),$ro->getSynapseTime(),$ro->selectNow("inventoryManager","requestingDepartment","verificationNo",$identifier[0]),$ro->selectNow("inventory","inventoryType","inventoryCode",$identifier[1]),"Consolacion","requestition","from inventoryCode:".$identifier[1]." issued by:".$username,"","","","","","",$ro->selectNow("inventoryManager","quantity","verificationNo",$identifier[0]),$ro->selectNow("inventory","suppliesUNITCOST","inventoryCode",$identifier[1]),"yes"); //insert to inventory table

$ro->editNow("inventoryManager","verificationNo",$identifier[0],"status","dispensed");
$ro->editNow("inventoryManager","verificationNo",$identifier[0],"dispensedDate",date("Y-m-d"));
}else {
echo "<font color=red>Sorry... ".$ro->selectNow("inventoryManager","description","verificationNo",$identifier[0])." Cannot be dispensed because there's only ".$ro->selectNow("inventory","quantity","inventoryCode",$identifier[1])." in stock</font> ";
}

}

?>
