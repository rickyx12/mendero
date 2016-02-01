<?php
include("../../myDatabase.php");
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$month1 = $_GET['month1'];
$day1 = $_GET['day1'];
$year1 = $_GET['year1'];
$module = $_GET['module'];
$username = $_GET['username'];
$type = $_GET['type'];

$ro = new database();

echo "
<style type='text/css'>
.style1 {font-family: Arial;font-size: 14px;color: #000000;font-weight: bold;}
.style2 {font-family: Arial;font-size: 14px;color: #000000;}
.style3 {font-family: Arial;font-size: 14px;color: #FF0000;}
</style>";
echo "<div class='style1'>";
echo "Sales Report";
echo "<Br>";
echo $year."-".$month."-".$day." to ".$year1."-".$month1."-".$day1;
echo "<br>";
echo $type;
echo "<br><br>";
echo "</div>";

$ro->getSalesReport($month,$day,$year,$month1,$day1,$year1,$username,$module,$type);




?>
