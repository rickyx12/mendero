<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$password = $_POST['password'];
$registrationNo = $_POST['registrationNo'];
$room = $_POST['room'];
$batchNo = $_POST['batchNo'];

$ro = new database2();

if( $username == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else if( $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else if( $username == "" && $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else {
if( $ro->getEmployeeId_username($username,$password) != "" ) {
echo "LOADING...";
echo "<br>";
$usernameCharges = $ro->selectNow("registeredUser","username","employeeID",$ro->getEmployeeId_username($username,$password));
$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/patientProfile/ECART/cartHandler.php?registrationNo=$registrationNo&room=$room&batchNo=$batchNo&username=$usernameCharges");
}else {
$ro->getBack("AUTHENTICATION ERROR");
}

}



?>
