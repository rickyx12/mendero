<?php
include("../../../myDatabase1.php");
$username = $_GET['username'];
$registrationNo = $_GET['registrationNo'];
$chargesCode = $_GET['chargesCode'];
$itemNo = $_GET['itemNo'];

$ro = new database1();

$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/Laboratory/mergeResult.php");
echo "<input type='submit' value='<< M E R G E >>' style='border:1px solid #000;' >";
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("itemNo",$itemNo);
$ro->coconutFormStop();
echo "<Br>";
$ro->getLabFormList($username,$registrationNo,$itemNo,$chargesCode);



?>
