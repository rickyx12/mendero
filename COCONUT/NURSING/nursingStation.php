<?php
include("../../myDatabase.php");
$ro = new database();
$ro->coconutDesign();
$ro->coconutHeading("NURSING SERVICE","");
$ro->coconutUpperMenuStart();
//$ro->coconutUpperMenu_headingStart("Floor");
//$ro->showFloorAsUpperMenu($branch);
//$ro->coconutUpperMenu_headingMenu("","Search Patient");
$ro->coconutUpperMenu_headingStop();
//$ro->coconutUpperMenu_headingStart("Patient");
//$ro->coconutUpperMenu_headingMenu_target("http://".$ro->getMyUrl()."/COCONUT/currentPatient/patientInterface.php?username=&completeName=&module=","Search","_blank");
$ro->coconutUpperMenu_headingStop();
$ro->coconutUpperMenuStop();
$ro->coconutFrame_target("http://".$ro->getMyUrl()."/COCONUT/room/showStation.php","100%","100%","nsX");
?>
