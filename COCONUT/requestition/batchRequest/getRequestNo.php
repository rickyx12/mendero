<?php
include("../../../myDatabase2.php");
$username = $_GET['username'];


$ro = new database2();
$ro->coconutDesign();
$ro->getRequestNo();
$myFile = $ro->getReportInformation("homeRoot")."/COCONUT/trackingNo/requestNo.dat";
$fh = fopen($myFile, 'r');
$requestNo = fread($fh, 100);
fclose($fh);
/*
echo $username;
echo "<br>";
echo $requestNo;
*/

echo "<Br><Br><Br><Br>";
$ro->coconutFormStart("get","requestHandler.php");
$ro->coconutHidden("username",$username);
$ro->coconutHidden("requestNo",$requestNo);
$ro->coconutBoxStart("500","80");
echo "<Br>";
echo "<table border=0>";
echo "<tr>";
echo "<td>My Department:&nbsp;</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("department");
echo "<option value='ER E Cart'>ER</option>";
echo "<option value='ICU E Cart'>ICU</option>";
echo "<option value='OR E Cart'>OR</option>";
echo "<option value='DR E Cart'>DR</option>";
echo "<option value='LABORATORY'>LABORATORY</option>";
echo "<option value='3A E Cart'>3A</option>";
echo "<option value='3B E Cart'>3B</option>";
echo "<option value='4A E Cart'>4A</option>";
echo "<option value='4B E Cart'>4B</option>";
echo "<option value='ICU E Cart'>ICU</option>";
echo "<option value='DR E Cart'>DR</option>";
echo "<option value='OR E Cart'>OR</option>";
echo "<option value='CSR E Cart'>CSR</option>";
echo "<option value='PHARMACY'>PHARMACY</option>";
echo "<option value='RADIOLOGY'>RADIOLOGY</option>";
echo "<option value='OR PACKAGE'>OR PACKAGE</option>";
echo "<option value='OB PACKAGE'>OB PACKAGE</option>";
echo "<option value='CARDIOLOGY E Cart'>CARDIOLOGY E Cart</option>";
echo "<option value='HEMODIALYSIS E Cart'>HEMODIALYSIS E Cart</option>";
echo "<option value='ENDOSCOPY E Cart'>ENDOSCOPY E Cart</option>";
echo "<option value='RADIOLOGY E Cart'>RADIOLOGY E Cart</option>";
echo "<option value='(MINOR OR) ER PACKAGE'>(MINOR OR) ER PACKAGE</option>";
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<Br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
