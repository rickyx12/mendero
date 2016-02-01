<?php
include("../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$lastName = $_GET['lastName'];
$firstName = $_GET['firstName'];
$status = $_GET['status'];
$station = $_GET['station'];

$ro = new database();

$ro->coconutDesign();

echo "<br><br><br>";

echo "<center><font color=red size=2>To edit the status of [".strtoupper($lastName." ".$firstName)."] enter your username and password</font></center>";
$ro->coconutFormStart("post","nurseStationStatus1.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("station",$station);
$ro->coconutBoxStart("500","160");
echo "<br>";
echo "<table border=0>";
echo "<tr>";
echo "<Td>Username&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox("username","");
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<Td>Password&nbsp;</td>";
echo "<td>".$ro->coconutPasswordBox_return("password","")."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Status</td>";
echo "<Td>";
$ro->coconutComboBoxStart_long("status");
echo "<option value='".$status."'>$status</option>";
echo "<option value='Admitted'>Admitted</option>";
echo "<option value='For Discharge'>For Discharge</option>";
echo "<option value='Discharged'>Discharged</option>";
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";

echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
