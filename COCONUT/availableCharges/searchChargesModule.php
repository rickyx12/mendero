<?php
include("../../myDatabase.php");
$username = $_GET['username'];
$module = $_GET['module'];

$ro = new database();

/*
$ro->getBatchNo();
$myFile = "/opt/lampp/htdocs/COCONUT/trackingNo/batchNo.dat";
$fh = fopen($myFile, 'r');
$batchNo = fread($fh, 100);
fclose($fh);
*/

?>

<script src="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/serverTime/serverTime.js"></script>
<script type='text/javascript'>

function showResult()
{
    
if (document.addCharge.availableCharges.value.length==0)
  {
  document.getElementById("livesearch").innerHTML="";
  document.getElementById("livesearch").style.border="0px";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
    document.getElementById("livesearch").style.border="0px solid #A5ACB2";
    }
  }
xmlhttp.open("GET","searchAvailableChargesNowModule.php?username="+document.addCharge.username.value+"&module="+document.addCharge.module.value+"&charges="+document.addCharge.availableCharges.value,true);
xmlhttp.send();
}





var charges = 'Input Search Here';
function SetMsg (txt,active) {
    if (txt == null) return;
    
 
    if (active) {
        if (txt.value == charges) txt.value = '';                     
    } else {
        if (txt.value == '') txt.value = charges;
    }
}

window.onload=function() { SetMsg(document.getElementById('charges', false)); }

</script>


<?php
if(($module=='LABORATORY')||($module=='RADIOLOGY')||($module=='ER')||($module=='ADMITTING')){
if($module=='ER'){$mod="LABORATORY & RADIOLOGY";}else{$mod=$module;}
echo  "<body onload='DisplayTime();'>";
echo "<form name='addCharge'>";
echo "<span style='font-family: Arial;font-size: 14px;color: #0066FF;font-weight: bold;'>SEARCH $mod CHARGES</span><br />";
echo "&nbsp;<input type=text name='availableCharges' id='charges' style='background:#FFFFFF no-repeat 4px 4px;padding:4px 4px 4px 2px;border:1pxsolid #CCCCCC;width:400px;height:25px;' class='txtBox'onfocus='SetMsg(this, true);' onblur='SetMsg(this,false);' onkeyup='showResult();' value='' placeholder='Input Search Here' />";
echo "<p id='curTime'></p>";
echo "<input type=hidden name='username' value='$username'>";
echo "<input type=hidden name='module' value='$module'>";
echo "</form>";
echo "<div id='livesearch'></div>";
echo "</body>";
}
?>
