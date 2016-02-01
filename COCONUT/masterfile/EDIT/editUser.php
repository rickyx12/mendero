<?php
include("../../../myDatabase.php");
$username = $_GET['username'];
$user = $_GET['user'];
$password = $_GET['password'];
$module = $_GET['module'];
$branch = $_GET['branch'];
$completeName = $_GET['completeName'];
$employeeID = $_GET['employeeID'];
$show = $_GET['show'];
$position = $_GET['position'];

if($position=="Supervisor"){
$pos="Yes";
}
else{
$pos="No";
}

$ro = new database();

?>

<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/flow/rickyCSS1.css" />

<style type='text/css'>
.labelz {
font-size:13px;
}

.txtBox {
	border: 1px solid #000;
	color: #000;
	height: 30px;
	width: 320px;
	padding:4px 4px 4px 5px;
}

.comboBox {
	border: 1px solid #000;
	color: #000;
	height: 30px;
	width: 320px;
	padding:4px 4px 4px 5px;
}

</style>

<script type='text/javascript'>
$("#breadcrumbs a").hover(
    function () {
        $(this).addClass("hover").children().addClass("hover");
        $(this).parent().prev().find("span.arrow:first").addClass("pre_hover");
    },
    function () {
        $(this).removeClass("hover").children().removeClass("hover");
        $(this).parent().prev().find("span.arrow:first").removeClass("pre_hover");
    }
);
</script>


<?php

echo "<br><center><div style='border:1px solid #000000; width:500px; height:277px; border-color:black black black black;'>";
echo "<form method='post' action='editUser1.php'>";
echo "<input type=hidden name='username' value='$username'>";
echo "<input type=hidden name='employeeID' value='$employeeID'>";
echo "<input type=hidden name='show' value='$show'>";
echo "<Br><br>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
<td><font class='labez'>Username</font>&nbsp;</td>
<td><input type=text name='user' class='txtBox' value='$user'></td>
</tr>

<tr>
<td><font class='labez'>Password</font>&nbsp;</td>
<td><input class='txtBox' type='password' name='password' value='$password'></td>
</tr>
<tr>
<td><font class='labez'>Module</font>&nbsp;</td>
<td>
<select name='module' class='comboBox'>
<option></option>
";

$asql=mysql_query("SELECT name FROM module WHERE status='on' ORDER BY name");
while($afetch=mysql_fetch_array($asql)){
if($module==$afetch['name']){$sel="selected='selected'";}else{$sel="";}
echo "
<option $sel>".$afetch['name']."</option>
";
}

echo "
</select></td>
</tr>
<tr>
<td>Branch</td>
<td><select name='branch' class='comboBox'>
";
echo "<option value='$branch'>$branch</option>";
$ro->getBranch();
echo "</select></td>
</tr>

<Tr>
<td>Name:</td>
<td><input type=text name='completeName' class='txtBox' value='$completeName'></td>
</tr>

<Tr>
<td>Station:</td>
<td><select name='station' class='comboBox'>
<option value='$station'>$station</option>
<option value='3A Station'>3A Station</option>
<option value='3B Station'>3B Station</option>
<option value='CFI'>CFI</option>
<option value='ER'>ER</option>
<option value='ICU'>ICU</option>
<option value='NICU'>NICU</option>
<option value='Nursery'>Nursery</option>
<option value='OR/DR'>OR/DR</option>
<option value='PICU'>PICU</option>
</select></td>
</tr>

<tr>
<Td>Supervisor/Head:&nbsp;</tD>
<td>
<select name='position' class='comboBox'>
<option value='$position'>$pos</option>
<option value=''>No</option>
<option value='Supervisor'>Yes</option>
</select>
</td>
</tr>

</table>";
echo "<br><input type=submit value='Proceed' style='border:1px solid #000; background-color:#3b5998; color:white'>";
echo "</div>";
echo "</form>";


?>
