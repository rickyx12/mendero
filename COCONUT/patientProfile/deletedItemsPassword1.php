<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$password = $_POST['password'];
$registrationNo = $_POST['registrationNo'];

$ro = new database2();

$asql=mysql_query("SELECT * FROM registeredUser WHERE user");

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
$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/ADMIN/pendingDelete_update.php?registrationNo=$registrationNo&username=$usernameCharges");
}else {
$ro->getBack("AUTHENTICATION ERROR");
}

}



?>
