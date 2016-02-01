<?php
include("../../../myDatabase2.php");
$itemNo = $_GET['itemNo'];
$countItem = count($itemNo);
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];

$ro = new database2();

for( $x=0;$x<$countItem;$x++ ) {
$ro->editNow("room","Description",$ro->selectNow("patientCharges","chargesCode","itemNo",$itemNo[$x]),"status","Vacant");
$ro->editNow("patientCharges","itemNo",$itemNo[$x],"status","Discharged");
}

$ro->EditNow("registrationDetails","registrationNo",$registrationNo,"dateUnregistered",date("Y-m-d"));
$ro->EditNow("registrationDetails","registrationNo",$registrationNo,"timeUnregistered",$ro->getSynapseTime());
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"mgh",$username);
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"unregisteredBy",$username);
$ro->editNow("registrationDetails","registrationNo",$registrationNo,"mgh_date",date("Y-m-d")."@".$ro->getSynapseTime());


echo "<center><br><Br><Br><font color=red>Patient Discharged</font>";

?>
