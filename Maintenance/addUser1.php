<?php
include("../myDatabase.php");

$username = $_POST['username'];
$usernamez = $_POST['usernamez']; // LOGINUSER
$password = $_POST['password'];
$module = $_POST['module'];
$branch = $_POST['branch'];
$completeName = $_POST['completeName'];
$position = $_POST['position'];


$ro = new database();



$ro->LogIn($username,$password,$module);

if($ro->getUserName()=="" && $ro->getUserPassword()=="" && $ro->getUserModule()=="" ) {
//$ro->addUser($username,$enc->encrypt($password),$module,$branch,$completeName);
$ro->addUser($username,$password,$module,$branch,$completeName,$position);
echo "
<script type='text/javascript'>
alert('".strtoupper($username)." NOW HAS AN ACCESS IN ".strtoupper($module)."');
window.location='http://".$ro->getMyUrl()."/Maintenance/addUser.php?usernamez=$usernamez';
</script>
";
}
else {

echo "
<script type='text/javascript'>
alert('USERNAME IS ALREADY IN USED.');
history.back();
</script>
";
}


?>
