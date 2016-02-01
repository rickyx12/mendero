<?php
include("../../myDatabase.php");
$username = $_GET['username'];
$registrationNo = $_GET['registrationNo'];

$ro = new database();
$ro->getRequestToDeletePending($username,$registrationNo);

?>
