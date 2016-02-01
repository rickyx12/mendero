<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$password = $_POST['password'];
$registrationNo = $_POST['registrationNo'];
$status = $_POST['status'];
$station = $_POST['station'];
$timeDischarged = date("H:i:s");

$ro = new database2();

if( $username == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else if( $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else if( $username == "" && $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else {
if( $ro->getEmployeeId_username($username,$password) != "" ) {

if( $status == "Discharged" ) {
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"timeDischargedFromNS",$timeDischarged);
}else { }

$ro->editNow("registrationDetails","registrationNo",$registrationNo,"nurseStationStatus",$status);



echo " <center><br><br><br><br><br><br>Patient Updated <br>$status: $timeDischarged <br><br> <form method='post' action='showStationRoom.php'><input type='submit' value='<< Back To Patient List' style='border:1px solid #ff0000; background-color:transparent; height:40px; ' ><input type='hidden' name='station' value='$station' > </form>";

}else {
$ro->getBack("AUTHENTICATION ERROR");
}

}



?>
