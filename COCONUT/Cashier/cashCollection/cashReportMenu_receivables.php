<?php
include("../../../myDatabase.php");
$ro = new database();

?>

<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/myCSS/coconutCSS.css" />

<style type="text/css">
a { text-decoration:none; color:red; }

.button{
	border: 1px solid #fff;
	color: #000;
	height: 28px;
	width: 381px;
	border-color:blue blue blue blue;
	font-size:15px;
	text-align:center;
	background-color:white;
}


.button1{
	border: 1px solid #fff;
	color: #000;
	height: 28px;
	width: 381px;
	border-color:red red red red;
	font-size:15px;
	text-align:center;
	background-color:white;
}

.button:hover {
background-color:yellow;
color:black;
}

.button1:hover {
background-color:yellow;
color:black;
}


</style>


<?php


echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br><center><div style='border:1px solid #000000; width:495px; height:auto; border-color:black black black black;'>";
echo "<br>";

echo "<form method='get' action='http://".$ro->getMyUrl()."/COCONUT/ADMIN/cashCollection_output_date_receivables.php' target='_blank'>";
echo "<input type=submit value='Daily Cash Collection Report' class='button'>";
echo "</form>";

echo "<form method='get' action='http://".$ro->getMyUrl()."/COCONUT/Cashier/cashCollection/cashCollection_output_monthlyDate_receivables.php' target='_blank'>";
echo "<input type=submit value='Monthly Cash Collection Report' class='button1'>";
echo "</form>";

echo "<Br>";
echo "</div>";

?>
