<?php
include("../../myDatabase2.php");
$username = $_GET['username'];
$dietNo = $_GET['dietNo'];
$dietName = $_GET['dietName'];
$ro = new database2();


$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/dietary/deleteDiet1.php");
$ro->coconutHidden("username",$username);
$ro->coconutHidden("dietNo",$dietNo);
echo "<Br><br>";
$ro->coconutBoxStart_red("400","70");
echo "<Br>";
echo "<font color=red>Delete $dietName?</font>";
echo "<br><Br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();



?>
