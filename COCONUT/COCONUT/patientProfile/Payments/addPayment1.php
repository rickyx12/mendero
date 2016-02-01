<?php
include("../../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$paymentFor = $_GET['paymentFor'];
$amountPaid = $_GET['amountPaid'];
$pf = $_GET['pf'];
$admitting = $_GET['admitting'];
//$datePaid = $_GET['datePaid'];
$orNo = $_GET['orNo'];
$paidVia = $_GET['paidVia'];
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$receiptType = $_GET['receiptType'];
$creditCardNo = $_GET['creditCardNo'];

$ro = new database2();
$m="";
if( $month == "Jan" ) {
$m = "01";
}else if( $month == "Feb" ) {
$m = "02";
}else if( $month == "Mar" ) {
$m = "03";
}else if( $month == "Apr" ) {
$m = "04";
}else if( $month == "May" ) {
$m = "05";
}else if( $month == "Jun" ) {
$m = "06";
}else if( $month == "Jul" ) {
$m = "07";
}else if( $month == "Aug" ) {
$m = "08";
}else if( $month == "Sep" ) {
$m = "09";
}else if( $month == "Oct" ) {
$m = "10";
}else if( $month == "Nov" ) {
$m = "11";
}else if( $month == "Dec" ) {
$m = "12";
}else { }

$datePaid = $year."-".$month."-".$day;

$timezone = "Asia/Manila";
date_default_timezone_set ($timezone);

$ro->addPayment_new($registrationNo,$amountPaid,$datePaid,date("H:i:s"),$username,$paymentFor,$orNo,$paidVia,$pf,$admitting,$year."-".$month."-".$day,$receiptType,$ro->ENCRYPT_DECRYPT($creditCardNo));

?>
