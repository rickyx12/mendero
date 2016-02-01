<?php
include("../../../myDatabase.php");
$registrationNo = $_GET['registrationNo'];

$ro = new database();

$ro->deleteNow("registrationDetails","registrationNo",$registrationNo);

echo "<center><Br><br><Br><br><font color=red size=5>Successfully Deleted</font>";


?>
