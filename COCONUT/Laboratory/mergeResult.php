<?php
include("../../myDatabase2.php");
$registrationNo = $_POST['registrationNo'];
$itemNo = $_POST['itemNo'];

$ro = new database2();

$desc = $ro->selectNow("patientCharges","description","itemNo",$itemNo);

echo "  <input type='button' value='<< Back To Result list' onclick='history.go(-1)' style='border:1px solid #ff0000; background-color:transparent; height:40px; ' > ";


echo "<center><br>".$desc."<br><br>";
$ro->mergeLabResult($registrationNo,$desc,$itemNo);



?>
