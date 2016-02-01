<?php
include("../../myDatabase.php");
$username = $_GET['username'];
$module = $_GET['module'];
$charges = $_GET['charges'];

$cuz = new database();

mysql_connect($cuz->myHost(),$cuz->getUser(),$cuz->getPass());
mysql_select_db($cuz->getDB());

echo "
<style type='text/css'>
<!--
.style1 {font-family: Arial;font-size: 14px;color: #000000;font-weight: bold;}
.style2 {font-family: Arial;font-size: 14px;color: #FF0000;font-weight: bold;}
.style3 {text-decoration: none;font-family: Arial;font-size: 12px;color: #000000;font-weight: bold;}
.style4 {font-family: Arial;font-size: 14px;color: #000000;font-weight: bold;}
.style5 {font-family: Arial;font-size: 14px;color: #000000;}
.style6 {font-family: Arial;font-size: 14px;color: #FFFFFF;font-weight: bold;}
.style7 {font-family: Arial;font-size: 12px;color: #000000;font-weight: bold;}
.style8 {font-family: Arial;font-size: 10px;color: #000000;font-weight: bold;}
.table1Left {border-left: 1px solid #000000;}
.table1Right {border-right: 1px solid #000000;}
.table1Left1Right {border-left: 1px solid #000000;border-right: 1px solid #000000;}
.table1Bottom {border-bottom: 1px solid #000000;}
.table1Bottom1Left {border-bottom: 1px solid #000000;border-left: 1px solid #000000;}
.table1Bottom1Right {border-bottom: 1px solid #000000;border-right: 1px solid #000000;}
.table1Bottom1Left1Right {border-bottom: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;}
.table1Top {border-top: 1px solid #000000;}
.table1Top1Bottom {border-top: 1px solid #000000;border-bottom: 1px solid #000000;}
.table2Top2Bottom {border-top: 2px solid #000000;border-bottom: 2px solid #000000;}
.table2Bottom {border-bottom: 2px solid #000000;}
.table1Top1Bottom1Left {border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-left: 1px solid #000000;}
.table1Top1Bottom1Right {border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;}
.table1Top1Bottom1Left1Right {border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;}
.doubleUnderline {text-decoration:underline;border-bottom: 1px solid #000;font-family: Arial;font-size: 14px;color: #000000;}
tr:hover { background-color:#66FF00;}
-->
</style>

<table width='auto' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='auto' bgcolor='#0066FF' class='table2Top2Bottom'><div align='center' class='style6'>&nbsp;Description&nbsp;</di></td>
    <td width='100' bgcolor='#0066FF' class='table2Top2Bottom'><div align='center' class='style6'>&nbsp;OP Price&nbsp;</di></td>
    <td width='100' bgcolor='#0066FF' class='table2Top2Bottom'><div align='center' class='style6'>OP Price Less 20%&nbsp;</di></td>
    <td width='100' bgcolor='#0066FF' class='table2Top2Bottom'><div align='center' class='style6'>&nbsp;IP Price&nbsp;</di></td>
    <td width='100' bgcolor='#0066FF' class='table2Top2Bottom'><div align='center' class='style6'>&nbsp;IP Price Less 20%&nbsp;</di></td>
  </tr>
";

if(($module=='ER')||($module=='ADMITTING')){
$asql=mysql_query("SELECT chargesCode, Description, OPD, WARD FROM availableCharges WHERE Description LIKE '$charges%%%%' AND (Category='LABORATORY' OR Category='RADIOLOGY') ORDER BY Description");
}
else{
$asql=mysql_query("SELECT chargesCode, Description, OPD, WARD FROM availableCharges WHERE Description LIKE '$charges%%%%' AND Category='$module' ORDER BY Description");
}
$acount=mysql_num_rows($asql);
if($acount!=0){
while($afetch=mysql_fetch_array($asql)){
$Description=$afetch['Description'];
$OPD=$afetch['OPD'];
$WARD=$afetch['WARD'];

echo "
  <tr>
    <td class='table1Bottom1Left' valign='top'><div align='left' class='style5'>&nbsp;".strtoupper($Description)."&nbsp;</di></td>
    <td class='table1Bottom1Left' valign='top'><div align='right' class='style5'>&nbsp;".number_format($OPD,2)."&nbsp;</di></td>
    <td class='table1Bottom1Left' valign='top'><div align='right' class='style5'>&nbsp;".number_format(($OPD*.8),2)."&nbsp;</di></td>
    <td class='table1Bottom1Left' valign='top'><div align='right' class='style5'>&nbsp;".number_format($WARD,2)."&nbsp;</di></td>
    <td class='table1Bottom1Left1Right' valign='top'><div align='right' class='style5'>&nbsp;".number_format(($WARD*.8),2)."&nbsp;</di></td>
  </tr>
";
}
}
echo "
</table>

";

?>
