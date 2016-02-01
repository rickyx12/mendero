<?php
include("../../myDatabase2.php");
$orNo = $_GET['orNo'];
$ro = new database2();
$ro->coconutDesign();


$ro->coconutFormStart("get","searchOR1.php");
echo "<br>";
echo "OR#:&nbsp;";
$ro->coconutTextBox("orNo",$orNo);
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
$ro->coconutButton("Search OR#");
$ro->coconutFormStop();


$ro->search_orNo($orNo);

?>
