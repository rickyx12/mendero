<?php
include("../../myDatabase2.php");

$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];

$ro = new database();

mysql_connect($ro->myHost(),$ro->getUser(),$ro->getPass());
mysql_select_db($ro->getDB());

$ro->coconutDesign();

echo "<br><br><br>";

echo "<center><font color=red size=2>To view Pending Deleted Items. Enter your username and Password.</font>";
$ro->coconutFormStart("post","deletedItemsPassword1.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
echo "<br>";
echo "<table border=0>";
echo "<tr>";
echo "<Td>Username&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox("username","");
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<Td>Password&nbsp;</td>";
echo "<td>".$ro->coconutPasswordBox_return("password","")."</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();
echo "</center>";

?>
