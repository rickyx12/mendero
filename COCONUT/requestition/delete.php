<?php
include("../../myDatabase.php");
$verificationNo = $_GET['verificationNo'];
$requestingDepartment = $_GET['requestingDepartment'];
$requestingBranch = $_GET['requestingBranch'];
$requestTo_department = $_GET['requestTo_department'];
$requestTo_branch = $_GET['requestTo_branch'];
$username = $_GET['username'];

$ro = new database();

$ro->editNow("inventoryManager","verificationNo",$verificationNo,"status","DELETED_".$username);

$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/availableMedicine/showRequestList.php?requestingDepartment=$requestingDepartment&requestingBranch=$requestingBranch&requestTo_department=$requestTo_department&requestTo_branch=$requestTo_branch&username=$username");

?>
