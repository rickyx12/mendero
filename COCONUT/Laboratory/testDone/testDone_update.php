<?php
include("../../../myDatabase.php");
$ro = new database();


echo " 
 <html>
<head>
<script type='text/javascript'>
function RefreshTable()
{
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById('tablediv').innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open('GET','testDone.php',true);
xmlhttp.send();

window.setTimeout(function(){ RefreshTable()},11000);
}

</script>
</head>
<body onload=RefreshTable()>
    <div id=tablediv></div>
</body>
</html>";


?>
