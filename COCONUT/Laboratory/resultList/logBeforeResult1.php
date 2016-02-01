<?php
include("../../../myDatabase2.php");
$password = $_POST['password'];
$registrationNo = $_POST['registrationNo'];
$itemNo = $_POST['itemNo'];
$chargesCode = $_POST['chargesCode'];
$username = $_POST['username'];
$date = $_POST['date'];
$result = $_POST['result'];
$remarks = $_POST['remarks'];
$morphology = $_POST['morphology'];

$ro = new database2();

if( $password == "" ) {
$ro->getBack("AUTHENTICATION ERROR");
}else {
if( $ro->getEmployeeId_passwordOnly($password) != "" ) {

echo " <center><br><br><br><br><br><br><br> <form method='post' action='addLabToPatient.php'><input type='submit' value='Click to Addd the Result >>>>>>' style='border:1px solid #ff0000; background-color:transparent; height:40px; ' ><input type='hidden' name='registrationNo' value='$registrationNo' > <input type='hidden' name='itemNo' value='$itemNo'> <input type='hidden' name='chargesCode' value='$chargesCode'> <input type='hidden' name='username' value='".$ro->getEmployeeId_passwordOnly($password)."'> <input type='hidden' name='date' value='$date'> <input type='hidden' name='result' value='$result'> <input type='hidden' name='remarks' value='$remarks'> <input type='hidden' name='morphology' value='$morphology'> </form>";

}else {
$ro->getBack("AUTHENTICATION ERROR");
}

}



?>
