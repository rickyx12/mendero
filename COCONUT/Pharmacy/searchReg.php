<?php
include("../../myDatabase2.php");

$ro = new database2();
$ro->coconutDesign();

echo "<br>";

$ro->coconutFormStart("get","searchReg1.php");
echo "Registration No:&nbsp;"; $ro->coconutTextBox("registrationNo","");
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
$ro->coconutButton("Search Registration No#");
$ro->coconutFormStop();

?>
