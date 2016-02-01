<?php
include("../../myDatabase.php");
$requestingDepartment = $_GET['requestingDepartment'];
$requestingBranch = $_GET['requestingBranch'];
$requestTo_department = $_GET['requestTo_department'];
$requestTo_branch = $_GET['requestTo_branch'];
$username = $_GET['username'];
$checkz = $_GET['checkz'];
$ro = new database();


if( $checkz == "yes" ) {
echo "<center><a href='http://".$ro->getMyUrl()."/COCONUT/availableMedicine/showRequestList.php?requestingDepartment=$requestingDepartment&requestingBranch=$requestingBranch&requestTo_department=$requestTo_department&requestTo_branch=$requestTo_branch&username=$username&checkz=no'><font color=red>Uncheck All</font></a></center>";
}else {
echo "<center><a href='http://".$ro->getMyUrl()."/COCONUT/availableMedicine/showRequestList.php?requestingDepartment=$requestingDepartment&requestingBranch=$requestingBranch&requestTo_department=$requestTo_department&requestTo_branch=$requestTo_branch&username=$username&checkz=yes'><font color=blue>Check All</font></a></center>";
}


$ro->showRequestList($requestingDepartment,$requestingBranch,$requestTo_department,$requestTo_branch,$username,$checkz);

?>
