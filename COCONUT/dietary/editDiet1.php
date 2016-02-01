<?php
include("../../myDatabase2.php");
$username = $_POST['username'];
$dietNo = $_POST['dietNo'];
$dietCode = $_POST['dietCode'];
$dietName = $_POST['dietName'];
$ro = new database2();

$ro->editNow("dietList","dietNo",$dietNo,"dietCode",$dietCode);
$ro->editNow("dietList","dietNo",$dietNo,"dietName",$dietName);

$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/dietary/viewDiet.php?username=$username");

?>
