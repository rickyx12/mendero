<?php
include("../../../myDatabase.php");
$registrationNo = $_GET['registrationNo'];
$batchNo = $_GET['batchNo'];
$username = $_GET['username'];
$room = $_GET['room'];

$ro = new database();

$ro->getPatientProfile($registrationNo);

echo "
<style type='text/css'>
a {
text-decoration:none;
color:white;
}

#rowz:hover {
background-color:black;
}
body {
background-color:#3b5998;
}
</style>

";

echo "<body>";
echo "<table border=0>";
echo "<tr>";


echo "<td id='rowz'>&nbsp;<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/19.gif'><a href='http://".$ro->getMyUrl()."/COCONUT/availableCharges/searchCharges.php?registrationNo=$registrationNo&username=$username&room=$room&batchNo=$batchNo' target='selectedFrame'>Charges</a>&nbsp;</td>";

echo "<td id='rowz'>&nbsp;<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/19.gif'><a href='http://".$ro->getMyUrl()."/COCONUT/Doctor/searchDoctor.php?registrationNo=$registrationNo&username=$username&room=$username&batchNo=$batchNo' target='selectedFrame'>Doctor</a>&nbsp;</td>";


echo "<td id='rowz'>&nbsp;<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/19.gif'><a href='http://".$ro->getMyUrl()."/COCONUT/availableMedicine/searchMedicine.php?registrationNo=$registrationNo&username=$username&inventoryFrom=PHARMACY&room=$room&batchNo=$batchNo' target='selectedFrame'>Medicine</a>&nbsp;</td>";

echo "<td id='rowz'>&nbsp;<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/19.gif'><a href='http://".$ro->getMyUrl()."/COCONUT/availableSupplies/searchSupplies.php?registrationNo=$registrationNo&username=$username&inventoryFrom=PHARMACY&batchNo=$batchNo' target='selectedFrame'>Supplies</a>&nbsp;</td>";


if( $ro->getRegistrationDetails_type() == "IPD" ) {
echo "<td id='rowz'>&nbsp;<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/19.gif'><a href='http://".$ro->getMyUrl()."/COCONUT/availableMisc/showMisc.php?registrationNo=$registrationNo&username=$username&inventoryFrom=PHARMACY&batchNo=$batchNo&room=$room' target='selectedFrame'>Misc</a>&nbsp;</td>";
}else {

}

echo "</tr>";
echo "</table>";
echo "</body>";
?>
