<?php
include("../../../myDatabase2.php");
$registrationNo = $_POST['registrationNo'];
$itemNo = $_POST['itemNo'];
$chargesCode = $_POST['chargesCode'];
$username = $_POST['username'];
$date = $_POST['date'];
$result = $_POST['result'];
$remarks = $_POST['remarks'];
$morphology = $_POST['morphology'];

$ro = new database();
$ro->getPatientProfile($registrationNo);
$ro->coconutDesign();

echo "<br><br><br>";

echo "<center><font color=red size=2>To Add the Result of [".strtoupper($ro->getPatientRecord_lastName()." ".$ro->getPatientRecord_firstName())."] enter your password</font></center>";
$ro->coconutFormStart("post","logBeforeResult1.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("itemNo",$itemNo);
$ro->coconutHidden("chargesCode",$chargesCode);
$ro->coconutHidden("username",$username);
$ro->coconutHidden("date",$date);
$ro->coconutHidden("result",$result);
$ro->coconutHidden("remarks",$remarks);
$ro->coconutHidden("morphology",$morphology);
$ro->coconutBoxStart("500","85");
echo "<br>";
echo "<table border=0>";
echo "<tr>";
echo "<Td>Password&nbsp;</td>";
echo "<td>".$ro->coconutPasswordBox_return("password","")."</td>";
echo "</tr>";

echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
