<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$password = $_POST['password'];
$registrationNo = $_POST['registrationNo'];

$ro = new database2();

if( $username == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else if( $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else if( $username == "" && $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else {
if( $ro->getEmployeeId_username($username,$password) != "" ) {

echo " <center><br><br><br><br><br><br><br><br> <form method='post' action='http://".$ro->getMyUrl()."/COCONUT/currentPatient/patientInterface1.php'><input type='submit' value='Proceed To Patient >>' style='border:1px solid #ff0000; background-color:transparent; height:40px; ' > <input type='hidden' name='username' value='$username' > <input type='hidden' name='registrationNo' value='$registrationNo' > </form>";

}else {
$ro->getBack("AUTHENTICATION ERROR");
}

}



?>
