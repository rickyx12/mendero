<?php
include("../../myDatabase.php");
$description = $_POST['description'];
$generic = $_POST['generic'];
$unitcost = $_POST['unitcost'];
$quantity = $_POST['quantity'];
$date = $_POST['date'];
$addedBy = $_POST['addedBy'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$time = $_POST['serverTime'];
$inventoryLocation = $_POST['inventoryLocation'];
$inventoryType = $_POST['inventoryType'];
$branch = $_POST['branch'];
$transition = $_POST['transition'];
$remarks = $_POST['remarks'];
$preparation = $_POST['preparation'];
$phic = $_POST['phic'];
$additional = $_POST['additional'];
$pricing = $_POST['pricing'];
$criticalLevel = $_POST['criticalLevel'];
$supplier = $_POST['supplier'];
$phicPrice = $_POST['phicPrice'];
$companyPrice = $_POST['companyPrice'];
$autoDispense = $_POST['autoDispense'];
$chargingStatus = $_POST['chargingStatus'];
$stockCardNo = $_POST['stockCardNo'];
$status = $_POST['status'];

$ro = new database();


$begCapital = ( $unitcost * $quantity );
$expiration = $year."-".$month."-".$day;

$pricingOption;


if( $inventoryType == "medicine" && $additional == "" ) {
echo "<script type='text/javascript'>alert('Pls input the price of medicine.');history.back(-1);</script>";
}else {


if( $status == "new" ) {

$ro->addInventoryStockCard($stockCardNo,$description,$generic,date("Y-m-d"),$addedBy,$inventoryType);

if( $inventoryType == "supplies" ) {
$ro->addNewMedicine($stockCardNo,$description,$generic,$pricing,$quantity,$expiration,$addedBy,$date,$ro->getSynapseTime(),$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$preparation,$phic,"",$criticalLevel,$supplier,$begCapital,$quantity,$unitcost,$autoDispense,$chargingStatus);
}else {
$ro->addNewMedicine($stockCardNo,$description,$generic,$unitcost,$quantity,$expiration,$addedBy,$date,$ro->getSynapseTime(),$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$preparation,$phic,$pricing."_".$additional,$criticalLevel,$supplier,$begCapital,$quantity,"",$autoDispense,$chargingStatus);
}

}else {

if( $inventoryType == "supplies" ) {
$ro->addNewMedicine($stockCardNo,$description,$generic,$pricing,$quantity,$expiration,$addedBy,$date,$ro->getSynapseTime(),$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$preparation,$phic,"",$criticalLevel,$supplier,$begCapital,$quantity,$unitcost,$autoDispense,$chargingStatus);
}else {
$ro->addNewMedicine($stockCardNo,$description,$generic,$unitcost,$quantity,$expiration,$addedBy,$date,$ro->getSynapseTime(),$inventoryLocation,$inventoryType,$branch,$transition,$remarks,$preparation,$phic,$pricing."_".$additional,$criticalLevel,$supplier,$begCapital,$quantity,"",$autoDispense,$chargingStatus);
}

}



}

?>
