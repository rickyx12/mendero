<?php
include("../../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$itemNo = $_GET['itemNo'];
$countz = count($itemNo);
$orNO = $_GET['orNO'];
$receiptType = $_GET['receiptType'];

$ro = new database1();

$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];

$m="";
if( $month == "01" ) {
$m = "01";
}else if( $month == "02" ) {
$m = "02";
}else if( $month == "03" ) {
$m = "03";
}else if( $month == "04" ) {
$m = "04";
}else if( $month == "05" ) {
$m = "05";
}else if( $month == "06" ) {
$m = "06";
}else if( $month == "07" ) {
$m = "07";
}else if( $month == "08" ) {
$m = "08";
}else if( $month == "09" ) {
$m = "09";
}else if( $month == "10" ) {
$m = "10";
}else if( $month == "11" ) {
$m = "11";
}else if( $month == "12" ) {
$m = "12";
}else { }

$datePaid = $year."-".$month."-".$day;

mysql_connect($ro->myHost(),$ro->getUser(),$ro->getPass());
mysql_select_db($ro->getDB());

$asql=mysql_query("SELECT orNO FROM patientCharges WHERE orNO='$orNO' AND status NOT LIKE 'DELETED_%%%%'");
$acount=mysql_num_rows($asql);

if($acount==0){
for($x=0;$x<$countz;$x++) {

$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"cashPaid",$ro->doubleSelectNow("patientCharges","cashUnpaid","itemNo",$itemNo[$x],"registrationNo",$registrationNo)); // kuhain ang total price at ilagay sa cashPaid cols

$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"cashUnpaid","0"); // gwen 0 ang cashUnpaid cols

$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"status","PAID"); // tagged as PAID

$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"datePaid",$datePaid); 
$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"control_datePaid",$year."-".$m."-".$day); 

$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"timePaid",$ro->getSynapseTime()); 

$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"paidBy",$username); // gwen 0 ang cashUnpaid cols

/*
$newQty = ( $ro->selectNow("inventory","quantity","inventoryCode", $ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo[$x])) - $ro->selectNow("patientCharges","quantity","itemNo",$itemNo[$x]) ); 

$ro->editNow("inventory","inventoryCode",$ro->doubleSelectNow("patientCharges","chargesCode","itemNo",$itemNo[$x],"registrationNo",$registrationNo),"quantity",$newQty);
*/
//$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"departmentStatus","dispensedBy_".$username); 

//$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"departmentTime",$ro->getSynapseTime()); 


$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"orNO",$orNO); 
$ro->doubleEditNow("patientCharges","itemNo",$itemNo[$x],"registrationNo",$registrationNo,"receiptType",$receiptType); 

}

$ro->getPatientProfile($registrationNo);

if( $ro->getPatientRecord_firstName() == "N/A" && $ro->getPatientRecord_middleName() == "N/A" ) {
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"dateUnregistered",date("Y-m-d"));
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"timeUnregistered",$ro->getSynapseTime() );
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"mgh","Synapse System");
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"mgh_date",date("Y-m-d"));
$ro->gotoPage("/COCONUT/patientProfile/individualPayment/checkBalance.php?registrationNo=$registrationNo&username=$username");
}else  { 

$ro->gotoPage("/COCONUT/patientProfile/individualPayment/checkBalance.php?registrationNo=$registrationNo&username=$username");

}

}
else{

echo "
<style type='text/css'>
<!--
.style1 {font-family: Arial;font-size: 14px;color: #FF0000;font-weight: bold;}
-->
</style>
";

echo "<div align='center' class='style1'><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />Duplicate OR Number. Input another OR Number!</div>";

echo "<META HTTP-EQUIV='Refresh'CONTENT=2;URL=http:showSelectedMeds.php?registrationNo=$registrationNo&username=$username";

for($x=0;$x<$countz;$x++) {
echo "&itemNo[]=".$itemNo[$x]."";
}

echo ">";

}


?>
