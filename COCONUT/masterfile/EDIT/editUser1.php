<?php
include("../../../myDatabase.php");
$username = $_POST['username'];
$user = $_POST['user'];
$password = $_POST['password'];
$module = $_POST['module'];
$branch = $_POST['branch'];
$completeName = $_POST['completeName'];
$employeeID = $_POST['employeeID'];
$show = $_POST['show'];
$station = $_POST['station'];
$position = $_POST['position'];
$ro = new database();

$ro->editNow("registeredUser","employeeID",$employeeID,"username",$user);
$ro->editNow("registeredUser","employeeID",$employeeID,"password",$password);
$ro->editNow("registeredUser","employeeID",$employeeID,"module",$module);
$ro->editNow("registeredUser","employeeID",$employeeID,"branch",$branch);
$ro->editNow("registeredUser","employeeID",$employeeID,"station",$station);
$ro->editNow("registeredUser","employeeID",$employeeID,"completeName",$completeName);
$ro->editNow("registeredUser","employeeID",$employeeID,"position",$position);

echo "
<script type='text/javascript'>
window.location='http://".$ro->getMyUrl()."/COCONUT/masterfile/user.php?username=$username&show=$show';
</script>


";

?>
