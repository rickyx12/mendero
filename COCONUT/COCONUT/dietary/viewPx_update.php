<?php
include("../../myDatabase2.php");
$username = $_GET['username'];
$ro = new database2();

echo "<script src='http://".$ro->getMyUrl()."/jquery.js'></script>";
echo "<script type='text/javascript'>";
echo "$(document).ready(function(){ ";
echo "refreshTable();";
echo "});";
echo "function refreshTable(){";
echo  "$('#tableHolder').load('viewPx.php?username=$username', function(){";
echo  "   setTimeout(refreshTable, 4000);";
echo   "  });";
echo   " }";
echo "</script>";
echo "</head>";
echo " <body>";
echo "<center>";echo "<div id='tableHolder'></div>";
echo "</center>";
echo "</body>";
echo "</html>";
?>

