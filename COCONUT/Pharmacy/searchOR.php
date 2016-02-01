<?php
include("../../myDatabase2.php");

$ro = new database2();
$ro->coconutDesign();

echo "<br>";

$ro->coconutFormStart("get","searchOR1.php");
echo "OR#:&nbsp;"; $ro->coconutTextBox("orNo","");
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
$ro->coconutButton("Search OR#");
$ro->coconutFormStop();

?>
