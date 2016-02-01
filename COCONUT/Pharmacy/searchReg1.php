<?php
include("../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$ro = new database2();
$ro->coconutDesign();


$ro->coconutFormStart("get","searchReg1.php");
echo "<br>";
echo "OR#:&nbsp;";
$ro->coconutTextBox("registrationNo",$registrationNo);
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
$ro->coconutButton("Search Registration No#");
$ro->coconutFormStop();


$ro->searchRegistrationNo($registrationNo);

?>
