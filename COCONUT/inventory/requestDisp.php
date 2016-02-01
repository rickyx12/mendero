<?php
include("../../myDatabase2.php");
$inventoryCode = $_GET['inventoryCode'];
$verificationNo = $_GET['verificationNo'];

$inventoryCount = count($inventoryCode);
$verificationCount = count($verificationNo);

$username = $_GET['username'];
$ro = new database2();


for( $i=0,$v=0;$i<$inventoryCount,$v<$verificationCount;$i++,$v++ ) {
$description = $ro->selectNow("inventoryManager","description","verificationNo",$verificationNo[$v]);
$generic = $ro->selectNow("inventory","genericName","inventoryCode",$inventoryCode[$i]);
$unitcost = $ro->selectNow("inventory","unitcost","inventoryCode",$inventoryCode[$i]);
$date = date("Y-m-d");
$month = date("m");
$day = date("d");
$year = date("Y");
$expiration = $ro->selectNow("inventory","expiration","inventoryCode",$inventoryCode[$i]);
$serverTime = $ro->getSynapseTime();
$inventoryLocation = $ro->selectNow("inventoryManager","requestingDepartment","verificationNo",$verificationNo[$i]);
$branch = "Consolacion";
$inventoryType = $ro->selectNow("inventory","inventoryType","inventoryCode",$inventoryCode[$i]);
$transition = " Issued By ".$ro->selectNow("inventoryManager","requestTo_department","verificationNo",$verificationNo[$v])." / Issued Staff $username";
$remarks = "requestitionNo_$verificationNo[$v] / from inventoryCode of $inventoryCode[$i]";
$quantity = $ro->selectNow("inventoryManager","quantity","verificationNo",$verificationNo[$v]);
$currentQTY = $ro->getCurrentQTY($inventoryCode[$i]) - $quantity;
$requestingUser = $ro->selectNow("inventoryManager","requestingUser","verificationNo",$verificationNo[$v]);

$invqty=$ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode[$i]);

if($quantity>$invqty){
}
else{
if( $inventoryType == "medicine" ) {
$ro->addNewMedicine1($description,$generic,$unitcost,$quantity,$expiration,$requestingUser,$date,$serverTime,$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$ro->selectNow("inventory","Added","inventoryCode",$inventoryCode[$i]),$inventoryCode[$i]);
}else {
$ro->addNewMedicine1($description,$generic,$unitcost,$quantity,$expiration,$requestingUser,$date,$serverTime,$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$ro->selectNow("inventory","unitcost","inventoryCode",$inventoryCode[$i]),$inventoryCode[$i]);
}

$timezone = "Asia/Manila";
date_default_timezone_set ($timezone);
$ro->editNow("inventoryManager","verificationNo",$verificationNo[$v],"dateIssued",date("Y-m-d"));
$ro->editNow("inventoryManager","verificationNo",$verificationNo[$v],"timeIssued",date("H:i:s"));
$ro->editNow("inventoryManager","verificationNo",$verificationNo[$v],"issuedBy",$username);
$ro->editNow("inventoryManager","verificationNo",$verificationNo[$v],"status","dispensed");
$ro->editNow("inventoryManager","verificationNo",$verificationNo[$v],"quantityIssued",$quantity);

$newQTY = ( $ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode[$i]) - $quantity );
$ro->editNow("inventory","inventoryCode",$inventoryCode[$i],"quantity",$newQTY);
$ro->editNow("inventoryManager","verificationNo",$verificationNo[$v],"status","Received");


//$ro->addNewMedicine1($description,$generic,$unitcost,$quantity,$expiration,$addedBy,$date,$time,$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$ro->selectNow("inventory","Added","inventoryCode",$inventoryCode));

}
}


?>
