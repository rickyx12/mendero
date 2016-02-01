<?php
include("../../myDatabase1.php");
$username = $_GET['username'];
$ro = new database1();


$ro->coconutDesign();

echo "<Br><Br><Br><Br>";


$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/inventory/department/searchInventory.php");
$ro->coconutHidden("username",$username);
$ro->coconutBoxStart("500","83");
echo "<br>";
echo "<table border=0>";
echo "<tr>";
echo "<td>Department&nbsp;</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("department");
echo "<option value='ER E Cart'>ER</option>";
echo "<option value='ICU E Cart'>ICU</option>";
echo "<option value='OR E Cart'>OR</option>";
echo "<option value='DR E Cart'>DR</option>";
echo "<option value='LABORATORY'>LABORATORY</option>";
echo "<option value='3A E Cart'>3A</option>";
echo "<option value='3B E Cart'>3B</option>";
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
echo "<br>";
$ro->coconutButton("Proceed");
$ro->coconutBoxStop();
$ro->coconutFormStop();

?>
