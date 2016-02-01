<?php
include("../../../myDatabase1.php");
$registrationNo = $_POST['registrationNo'];
$username = $_POST['username'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$month_due = $_POST['month_due'];
$day_due = $_POST['day_due'];
$year_due = $_POST['year_due'];
$promisorryNote = $_POST['promisorryNote'];
$balance = $_POST['balance'];

$ro = new database1();

$startDate = $year."-".$month."-".$day;
$dueDate = $year_due."-".$month_due."-".$day_due;

$ro->addPromisorryNote($registrationNo,$balance,$promisorryNote,$startDate,$dueDate,$username);


header("Location: /COCONUT/patientProfile/patientProfile_handler.php?registrationNo=$registrationNo&username=$username");

?>
