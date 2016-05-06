<?php
include("../../myDatabase.php");
$status = $_GET['status'];
$registrationNo = $_GET['registrationNo'];
$chargesCode = $_GET['chargesCode'];
$description = $_GET['description'];
$sellingPrice = $_GET['sellingPrice'];
$discount = $_GET['discount'];
$timeCharge = $_GET['timeCharge'];

$chargeBy = $_GET['chargeBy'];
$service = $_GET['service'];
$title = $_GET['title'];
$paidVia = $_GET['paidVia'];
$cashPaid = $_GET['cashPaid'];
$batchNo = $_GET['batchNo'];
$username = $_GET['username'];
$quantity = $_GET['quantity'];
$inventoryFrom = $_GET['inventoryFrom'];
$room = $_GET['room'];
$paycash = $_GET['paycash'];

$ro = new database();
$ro->getPatientProfile($registrationNo);

if( $quantity > $ro->selectNow("inventory","quantity","inventoryCode",$chargesCode) ) {
$ro->getBack("Current Stock is ".$ro->selectNow("inventory","quantity","inventoryCode",$chargesCode) ." only" );
}else {




if( $ro->getPatientRecord_senior() == "YES" && $title == "MEDICINE" && $paycash == "yes"  ) {
$totalz = ($sellingPrice * $quantity);
$discount = $totalz * 0.20;
$totalPrice = ( $totalz - $discount );
}else if( $ro->getPatientRecord_senior() == "NO" && $title == "MEDICINE" && $paycash == "yes" ) {
$totalz = ($sellingPrice * $quantity);
//---------------------------------------------------------------------------
$ipaesql=mysql_query("SELECT description FROM inventorypaexception WHERE description='$description' AND status='Active'");
$ipaecount=mysql_num_rows($ipaesql);

if($ipaecount==0){
$pasql=mysql_query("SELECT mstatus, mopd, mopdhmo, mipd FROM priceadjustments WHERE mstatus='on'");
$pacount=mysql_num_rows($pasql);
  if($pacount==0){
  $discount = $totalz * 0.05;
  }
  else{
  $discount = 0;
  }
}
else{
$discount = $totalz * 0.05;
}
//---------------------------------------------------------------------------
$totalPrice = ( $totalz - $discount );
}else {
$discount = 0;
$totalPrice = ($sellingPrice * $quantity);
}


//check autoDispense????
if( $ro->selectNow("inventory","autoDispense","inventoryCode",$chargesCode) == "yes" ) {
$currentQTY = $ro->selectNow("inventory","quantity","inventoryCode",$chargesCode); // current qty ng meds/sup sa inventory
$newQTY = ($currentQTY - $quantity); // less sa inventory as in qty after ibawas ung desired qty ng user
$ro->editNow("inventory","inventoryCode",$chargesCode,"quantity",$newQTY); // update qty sa database
$ro->addCharges_cash_autoDispense($status,$registrationNo,$chargesCode,$description,$sellingPrice,$discount,$totalPrice,$totalPrice,"0","0",$ro->getSynapseTime(),date("Y-m-d"),$username,$service,$title,$paidVia,$cashPaid,$batchNo,$quantity,$inventoryFrom,$ro->getRegistrationDetails_branch(),$room,"dispensedBy_".$username,$ro->getSynapseTime());
}else {
$ro->addCharges_cash($status,$registrationNo,$chargesCode,$description,$sellingPrice,$discount,$totalPrice,$totalPrice,"0","0",$ro->getSynapseTime(),date("Y-m-d"),$username,$service,$title,$paidVia,$cashPaid,$batchNo,$quantity,$inventoryFrom,$ro->getRegistrationDetails_branch(),$room);
}

}

