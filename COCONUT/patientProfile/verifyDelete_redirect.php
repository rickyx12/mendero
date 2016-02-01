<?php
include("../../myDatabase.php");
$registrationNo = $_GET['registrationNo'];
$itemNo = $_GET['itemNo'];
$description = $_GET['description'];
$quantity = $_GET['quantity'];
$username = $_GET['username'];
$show = $_GET['show'];
$desc = $_GET['desc'];


$ro = new database();


?>
<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/myCSS/coconutCSS.css" />

<?php
echo "<br><br><br><Br><br>";

if($ro->getTitle($itemNo) == "MEDICINE" || $ro->getTitle($itemNo) == "SUPPLIES" ) {

echo "<center><div style='border:1px solid #ff0000; width:400px; height:120px;	'>";
echo "<br><center><font size=2 color=red>Are you sure you want to return <br>$description?</font></center>";

}else {

if($ro->getTitle($itemNo)=="LABORATORY" || $ro->getTitle($itemNo)=="RADIOLOGY"){
}
else{
echo "<center><div style='border:1px solid #ff0000; width:400px; height:110px;	'>";
echo "<br><center><font size=2 color=red>Are you sure you want to delete <br>$description?</font></center>";
echo "<Br>";
}

}


if(($ro->getTitle($itemNo)=="MEDICINE" || $ro->getTitle($itemNo)=="SUPPLIES") && ($ro->getChargesStatus($itemNo) == 0 )) {
echo "<form method='get' action='http://".$ro->getMyUrl()."/COCONUT/availableCharges/deletePatientCharges_redirect.php'>
<input type=hidden name='itemNo' value='$itemNo'>
<input type=hidden name='registrationNo' value='$registrationNo'>";

echo "
<input type=text name='quantity' value='$quantity' style='width:70px; border:1px solid #ff0000; padding:2px 2px 2px 10px; ' ><br><br>";

echo "
<input type=hidden name='username' value='$username'>
<input type=hidden name='show' value='$show'>
<input type=hidden name='desc' value='$desc'>
<input type=submit value='Yes' style='border:1px solid #ff0000; background-color:transparent;'>
</form>
";
}else {

if($ro->getTitle($itemNo)=="LABORATORY" || $ro->getTitle($itemNo)=="RADIOLOGY"){
echo "<center><div style='border:1px solid #ff0000; width:500px; height:130px;	'>";
echo "<br><center><font size=2 color=red>Input Reason for deleting<br>$description.</font></center>";
//echo "<Br>";
echo "<form method='get' action='http://".$ro->getMyUrl()."/COCONUT/availableCharges/deletePatientCharges_redirect.php'>
<input type=hidden name='itemNo' value='$itemNo'>
<input type=hidden name='registrationNo' value='$registrationNo'>
<input type=hidden name='quantity' value='$quantity'>
<input type=hidden name='username' value='$username'>
<input type=hidden name='show' value='$show'>
<input type=hidden name='desc' value='$desc'>
<input type='text' name='remarks' value='' placeholder='Type reason here.' size='30' /><br><br>
<input type=submit value='Delete' style='border:1px solid #ff0000; background-color:transparent;'>
</form>
";
}
else{
echo "<form method='get' action='http://".$ro->getMyUrl()."/COCONUT/availableCharges/deletePatientCharges_redirect.php'>
<input type=hidden name='itemNo' value='$itemNo'>
<input type=hidden name='registrationNo' value='$registrationNo'>";

echo "
<input type=hidden name='quantity' value='$quantity'>";

echo "
<input type=hidden name='username' value='$username'>
<input type=hidden name='show' value='$show'>
<input type=hidden name='desc' value='$desc'>
<input type=submit value='Yes' style='border:1px solid #ff0000; background-color:transparent;'>
</form>
";
}

}


echo "</div></center>";


?>
