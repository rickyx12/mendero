<?php
include("../../../myDatabase.php");
$itemNo = $_GET['itemNo'];
$batchNo = $_GET['batchNo'];
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];

$ro = new database();

echo "
<form name='Delete' method='get' action='deleteCart.php'>
<input type='hidden' name='itemNo' value='$itemNo' />
<input type='hidden' name='batchNo' value='$batchNo' />
<input type='hidden' name='registrationNo' value='$registrationNo' />
<input type='hidden' name='username' value='$username' />
<font color='red' size='3'>Reason to Delete:</font>
<br />
<input type='text' size='30' name='remarks' placeholder='Input reason here.'><input type='submit' name='Submit' value='Submit' />
</form>
";

//$ro->gotoPage("http://".$ro->getMyUrl()."/COCONUT/patientProfile/ECART/showCart_update.php?registrationNo=$registrationNo&batchNo=$batchNo&username=$username");

?>
