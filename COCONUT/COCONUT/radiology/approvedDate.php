<?php
include("../../myDatabase2.php");
$doctorCode = $_GET['doctorCode'];
$username = $_GET['username'];
$module = $_GET['module'];
$ro = new database2();

$ro->coconutDesign();

echo "<br><Br><br>";

$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/radiology/viewApproved.php");
$ro->coconutHidden("physician",$ro->selectNow("Doctors","Name","doctorCode",$doctorCode));
$ro->coconutHidden("doctorCode",$doctorCode);
$ro->coconutHidden("username",$username);
$ro->coconutHidden("module",$module);
$ro->coconutBoxStart("500","120");
echo "<Br>";
echo "<Table border=0>";

echo "<Tr>";
echo "<td>";
$ro->coconutComboBoxStart_short("month");
echo "<option value='01'>Jan</option>";
echo "<option value='02'>Feb</option>";
echo "<option value='03'>Mar</option>";
echo "<option value='04'>Apr</option>";
echo "<option value='05'>May</option>";
echo "<option value='06'>Jun</option>";
echo "<option value='07'>Jul</option>";
echo "<option value='08'>Aug</option>";
echo "<option value='09'>Sep</option>";
echo "<option value='10'>Oct</option>";
echo "<option value='11'>Nov</option>";
echo "<option value='12'>Dec</option>";
$ro->coconutComboBoxStop();

echo "-";

$ro->coconutComboBoxStart_short("day");

for( $x=1;$x<32;$x++ ) {

if( $x<10 ) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}

}

$ro->coconutComboBoxStop();

echo "-";
$ro->coconutTextBox_short("year",date("Y"));
echo "</td>";
echo "</tr>";




echo "<Tr>";
echo "<td>";
$ro->coconutComboBoxStart_short("month1");
echo "<option value='01'>Jan</option>";
echo "<option value='02'>Feb</option>";
echo "<option value='03'>Mar</option>";
echo "<option value='04'>Apr</option>";
echo "<option value='05'>May</option>";
echo "<option value='06'>Jun</option>";
echo "<option value='07'>Jul</option>";
echo "<option value='08'>Aug</option>";
echo "<option value='09'>Sep</option>";
echo "<option value='10'>Oct</option>";
echo "<option value='11'>Nov</option>";
echo "<option value='12'>Dec</option>";
$ro->coconutComboBoxStop();

echo "-";

$ro->coconutComboBoxStart_short("day1");

for( $x=1;$x<32;$x++ ) {

if( $x<10 ) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}

}

$ro->coconutComboBoxStop();

echo "-";
$ro->coconutTextBox_short("year1",date("Y"));
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();
?>
