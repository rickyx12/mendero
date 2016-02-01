<?php
include("../../../myDatabase.php");
$registrationNo = $_GET['registrationNo'];

$ro = new database();
$ro->getPatientProfile($registrationNo);
$ro->coconutFormStart("get","registrationCensusDelete1.php");
$ro->coconutHidden("registrationNo",$registrationNo);
echo "<Br><Br><br><br><br><Br>";
$ro->coconutBoxStart_red("600","120");
echo "<br>	";
echo "<font size=3 color=red>You are about to delete the record of ".$ro->getPatientRecord_lastName().", ".$ro->getPatientRecord_firstName()." <br>with a registration No#: ".$registrationNo." and register by ".$ro->getRegistrationDetails_registeredBy()."</font>";
echo "<br><br>";
$ro->coconutButton("Delete");
$ro->coconutBoxStop();
$ro->coconutFormStop();


?>
