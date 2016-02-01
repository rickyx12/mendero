<?php
include("../../myDatabase2.php");
$registrationNo = $_POST['registrationNo'];
$count = count($registrationNo);
$username = $_POST['username'];

$ro = new database2();


for( $x=0;$x<$count;$x++ ) {

$ro->EditNow("registrationDetails","registrationNo",$registrationNo[$x],"dateUnregistered",date("Y-m-d"));
$ro->EditNow("registrationDetails","registrationNo",$registrationNo[$x],"timeUnregistered",$ro->getSynapseTime());
$ro->editNow("registrationDetails","registrationNo",$registrationNo[$x],"mgh",$username);
$ro->editNow("registrationDetails","registrationNo",$registrationNo[$x],"unregisteredBy",$username);
$ro->editNow("registrationDetails","registrationNo",$registrationNo[$x],"mgh_date",date("Y-m-d")."@".$ro->getSynapseTime());

}


echo "<center><br><Br><Br><font color=red>Patient Discharged</font>";

?>
