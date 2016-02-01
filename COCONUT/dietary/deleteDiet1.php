<?php
include("../../myDatabase2.php");
$dietNo = $_POST['dietNo'];
$username = $_POST['username'];
$ro = new database2();

$ro->deleteNow("dietList","dietNo",$dietNo);
$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/dietary/viewDiet.php?username=$username");

?>
