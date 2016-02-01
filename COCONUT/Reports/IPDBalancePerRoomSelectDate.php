<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Select Date</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial;
	font-size: 16px;
	font-weight: bold;
	color: #000000;
}
.style2 {
	font-family: Arial;
	font-size: 16px;
	font-weight: bold;
	color: #FF6600;
}
.style3 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.style4 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #0033FF;
}
.style5 {
	font-family: Arial;
	font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.textfield01 {
	font-family: Arial;
	font-size: 14px;
	font-weight: bold;
	color: #000000;
	background-color: #FFFFFF;
	border: 1px solid #000000;
}
.button01 {
	font-family: Arial;
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
	background-color: #0066FF;
	border: 1px solid #000000;
}
.button02 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #FF0000;
	background-color: #FFFFFF;
	border: 1px solid #000000;
}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}
//-->
</script>
</head>

<body>
<?php
include("../../myDatabase.php");
$cuz = new database();

mysql_connect($cuz->myHost(),$cuz->getUser(),$cuz->getPass());
mysql_select_db($cuz->getDB());

$day=date("d");
$month=date("m");
$year=date("Y");

echo "
<div align='center'>
  <table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
    <tr>
      <form id='Select' name='Select' method='get' action='IPDBalancePerRoomReport.php'>
	  <td bgcolor='#FFCC33'><div align='center'>
	    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td height='80' align='center' valign='bottom'><div align='center'>
              <table border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td><div align='left' class='style1'>From</div></td>
                  <td><div align='left'>
";

if($month=='01'){$fm1="selected='selected'"; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='02'){$fm1=""; $fm2="selected='selected'"; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='03'){$fm1=""; $fm2=""; $fm3="selected='selected'"; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='04'){$fm1=""; $fm2=""; $fm3=""; $fm4="selected='selected'"; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='05'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5="selected='selected'"; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='06'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6="selected='selected'"; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='07'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7="selected='selected'"; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='08'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8="selected='selected'"; $fm9=""; $fm10=""; $fm11=""; $fm12="";}
else if($month=='09'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9="selected='selected'"; $fm10=""; $fm11=""; $fm12="";}
else if($month=='10'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10="selected='selected'"; $fm11=""; $fm12="";}
else if($month=='11'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11="selected='selected'"; $fm12="";}
else if($month=='12'){$fm1=""; $fm2=""; $fm3=""; $fm4=""; $fm5=""; $fm6=""; $fm7=""; $fm8=""; $fm9=""; $fm10=""; $fm11=""; $fm12="selected='selected'";}

echo "
				    <select name='fm' class='textfield01'>
				      <option value='01' $fm1>Jan</option>
				      <option value='02' $fm2>Feb</option>
				      <option value='03' $fm3>Mar</option>
				      <option value='04' $fm4>Apr</option>
				      <option value='05' $fm5>May</option>
				      <option value='06' $fm6>Jun</option>
				      <option value='07' $fm7>Jul</option>
				      <option value='08' $fm8>Aug</option>
				      <option value='09' $fm9>Sep</option>
				      <option value='10' $fm10>Oct</option>
				      <option value='11' $fm11>Nov</option>
				      <option value='12' $fm12>Dec</option>
				    </select>
				    <select name='fd' class='textfield01'>
";

for($z=1;$z<=31;$z++){
if($z<10){$y="0".$z;}else{$y=$z;}
if($y==$day){$fsd="selected";}else{$fsd="";}

echo ";
				      <option $fsd>$y</option>
";
}


echo "
				    </select>
				    <select name='fy' class='textfield01'>
";

for($a=1990;$a<$year;$a++){
echo "
				      <option>$a</option>
";
}

echo "
				      <option selected='selected'>$year</option>
";

for($b=($year+1);$b<=($year+10);$b++){
echo "
				      <option>$b</option>
";
}

echo "
				    </select>
                  </div></td>
                </tr>
                <tr>
                  <td><div align='left' class='style1'>To</div></td>
                  <td><div align='left'>
";

if($month=='01'){$tm1="selected='selected'"; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='02'){$tm1=""; $tm2="selected='selected'"; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='03'){$tm1=""; $tm2=""; $tm3="selected='selected'"; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='04'){$tm1=""; $tm2=""; $tm3=""; $tm4="selected='selected'"; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='05'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5="selected='selected'"; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='06'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6="selected='selected'"; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='07'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7="selected='selected'"; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='08'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8="selected='selected'"; $tm9=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='09'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9="selected='selected'"; $tm10=""; $tm11=""; $tm12="";}
else if($month=='10'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10="selected='selected'"; $tm11=""; $tm12="";}
else if($month=='11'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11="selected='selected'"; $tm12="";}
else if($month=='12'){$tm1=""; $tm2=""; $tm3=""; $tm4=""; $tm5=""; $tm6=""; $tm7=""; $tm8=""; $tm9=""; $tm10=""; $tm11=""; $tm12="selected='selected'";}

echo "
                  	<select name='tm' class='textfield01'>
				      <option value='01' $tm1>Jan</option>
				      <option value='02' $tm2>Feb</option>
				      <option value='03' $tm3>Mar</option>
				      <option value='04' $tm4>Apr</option>
				      <option value='05' $tm5>May</option>
				      <option value='06' $tm6>Jun</option>
				      <option value='07' $tm7>Jul</option>
				      <option value='08' $tm8>Aug</option>
				      <option value='09' $tm9>Sep</option>
				      <option value='10' $tm10>Oct</option>
				      <option value='11' $tm11>Nov</option>
				      <option value='12' $tm12>Dec</option>
				    </select>
				    <select name='td' class='textfield01'>
";

for($x=1;$x<=31;$x++){
if($x<10){$w="0".$x;}else{$w=$x;}
if($w==$day){$tsd="selected";}else{$tsd="";}

echo ";
				      <option $tsd>$w</option>
";
}

echo "
				    </select>
				    <select name='ty' class='textfield01'>
";

for($c=1990;$c<$year;$c++){
echo "
				      <option>$c</option>
";
}

echo "
				      <option selected='selected'>$year</option>
";

for($d=($year+1);$d<=($year+10);$d++){
echo "
				      <option>$d</option>
";
}

echo "
				    </select>
                  </div></td>
                </tr>
                <tr>
                  <td><div align='left' class='style1'>Room</div></td>
                  <td><div align='left'>
                    <select name='floor' class='textfield01'>
                      <option selected='selected'>-Select Floor-</option>
";

$asql=mysql_query("SELECT floor FROM room GROUP BY floor ORDER BY floor");
while($afetch=mysql_fetch_array($asql)){
$floor=$afetch['floor'];

echo "
                      <option>$floor</option>
";
}

/*
echo "
                      <option>All Floors</option>
";
*/

echo "
                      <option value=''>No Room</option>
                    </select>
                  </div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td height='80' align='center' valign='top'><div align='center'>
              <input name='Submit' type='submit' class='button01' value='Submit' />
            </div></td>
          </tr>
        </table>
	  </div></td>
	  </form>
    </tr>
  </table>
</div>
";
?>
</body>
</html>
