<?php
include("../myDatabase.php");
?>

<html>
<head>
<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//   -->
</script>
</head>
<body onload="JavaScript:timedRefresh(5000);">
<p>This page will refresh every 5 seconds. This is because we're using the 'onload' event to call our function. We are passing in the value '5000', which equals 5 seconds.</p>
<p>But hey, try not to annoy your users too much with unnecessary page refreshes every few seconds!</p>
</body>
</html>

<?
$ro = new database();


$ro->gotoPage("http://www.sourcecodester.com/php/4169/synapse-hospital-system.html");

//$ro->gotoPage("http://www.youtube.com/watch?v=U7ZzjCXEwTU");

?>
