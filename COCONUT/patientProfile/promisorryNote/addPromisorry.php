<?php
include("../../../myDatabase1.php");
$username = $_GET['username'];
$registrationNo = $_GET['registrationNo'];

$ro = new database1();

echo "<script type='text/javascript' src='/ckeditor/ckeditor.js'></script>";

$ro->coconutDesign();


$ro->coconutFormStart("post","insertPromisorry.php");
echo "<table border=0>";
echo "<tr>";
echo "<td>Date&nbsp;</tD>";
echo "<td>";
$ro->coconutComboBoxStart_short("month");
echo "<option value='".date("m")."'>".date("M")."</option>";
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

echo "&nbsp;";

$ro->coconutComboBoxStart_short("day");
echo "<option value='".date("d")."'>".date("d")."</option>";
for($x=1;$x<32;$x++) {
if($x < 10) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}
}
$ro->coconutComboBoxStop();

echo "&nbsp;";

$ro->coconutTextBox_short("year",date("Y"));

echo "</td>";
echo "</tr>";




echo "<tr>";
echo "<td>Due Date&nbsp;</tD>";
echo "<td>";
$ro->coconutComboBoxStart_short("month_due");
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

echo "&nbsp;";

$ro->coconutComboBoxStart_short("day_due");
for($x=1;$x<32;$x++) {
if($x < 10) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}
}
$ro->coconutComboBoxStop();

echo "&nbsp;";

$ro->coconutTextBox_short("year_due",date("Y"));

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Balance&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox_short("balance","");
echo "</td>";
echo "</tr>";
echo "</table>";
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
echo "<br>";

echo "<textarea id='promisorryNote' name='promisorryNote'>"; 

echo "</textarea>";

?>

<script type="text/javascript">
			
			CKEDITOR.replace( 'promisorryNote',
	{
		enterMode : CKEDITOR.ENTER_BR,
		skin : 'office2003'
	});
		

</script>

<?php

echo "<Br>";
$ro->coconutButton("Proceed");
$ro->coconutFormStop();

?>

