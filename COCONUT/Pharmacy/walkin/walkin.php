<?php
include("../../../myDatabase2.php");
$username = $_GET['username'];
$ro = new database2();
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
    
if (document.addCharge.description.value.length==0)
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
xmlhttp.open("GET","walkinSearch.php?description="+document.addCharge.description.value,true);
xmlhttp.send();
}





var charges = 'Search';
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
echo  "<body onload='DisplayTime();'>";
echo "<form name='addCharge'>";
echo "&nbsp;<input type=text name='description' autocomplete='off' id='charges' style='   
	background:#FFFFFF no-repeat 4px 4px;
	padding:4px 4px 4px 2px;
	border:1px solid #CCCCCC;
	width:400px;
	height:25px;' class='txtBox'
	onfocus='SetMsg(this, true);'
    	onblur='SetMsg(this,false);'
	onkeyup='showResult();' 
	value=''
>";
echo "<p id='curTime'></p>";
echo "</form>";
echo "<div id='livesearch'></div>";
echo "</body>";
?>