<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Aging of Accounts</title>
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
	color: #000000;
	background-color: #FFFFFF;
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

$username=$_GET['username'];

echo "
<div align='center'>
  <table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
    <tr>
      <form id='Select' name='Select' method='get' action='HMOComAAByHMOCom.php'>
	  <td bgcolor='#FFCC33'><div align='center'>
	    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td height='80' align='center' valign='middle'><div align='center'>
              <select name='companyName' class='textfield01'>
                <option selected='selected'>-Select HMO/Company-</option>
";

$asql=mysql_query("SELECT companyName FROM Company ORDER BY companyName");
while($afetch=mysql_fetch_array($asql)){
$companyName=$afetch['companyName'];

echo "
				<option>$companyName</option>
";
}

echo "
              </select>
              <select name='type' class='textfield01'>
                <option>IPD</option>
                <option>OPD</option>
              </select>
              <input name='Submit' type='submit' class='button01' value='Submit' />
            </div></td>
          </tr>
        </table>
	  </div></td>
        <input type='hidden' name='username' value='$username' />
	  </form>
    </tr>
  </table>
</div>
";
?>
</body>
</html>
