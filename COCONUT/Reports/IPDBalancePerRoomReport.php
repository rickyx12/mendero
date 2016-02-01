<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PATIENT ACCOUNTS STATUS REPORT</title>
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
	color: #000000;
}
.style4 {
	font-family: Arial;
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
.style5 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #0033FF;
}
.style6 {
	font-family: Arial;
	font-size: 12px;
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

$fm=$_GET['fm'];
$fd=$_GET['fd'];
$fy=$_GET['fy'];
$tm=$_GET['tm'];
$td=$_GET['td'];
$ty=$_GET['ty'];
$floor=$_GET['floor'];

$fdate=$fy."-".$fm."-".$fd;
$fdatestr=strtotime($fdate);
$fdatefmt=date("M. d, Y",$fdatestr);

$tdate=$ty."-".$tm."-".$td;
$tdatestr=strtotime($tdate);
$tdatefmt=date("M. d, Y",$tdatestr);

echo "
<div align='center'>
<span class='style1'>PATIENT ACCOUNTS STATUS REPORT</span>
<br />
<span class='style3'>$fdatefmt - $tdatefmt</span>
<br />
<span class='style3'>$floor</span>
<br /><br />
<table width='98%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td height='1' colspan='11' bgcolor='#000000'></td>
  </tr>
  <tr>
    <td width='6%' height='35' class='style4'><div align='left'>Reg No.</div></td>
    <td width='20%' height='35' class='style4'><div align='left'>Patient's Name</div></td>
    <td width='8%' height='35' class='style4'><div align='center'>Adm. Date</div></td>
    <td width='11%' height='35' class='style4'><div align='center'>Room</div></td>
    <td width='11%' height='35' class='style4'><div align='center'>Company</div></td>
    <td width='7%' height='35' class='style4'><div align='center'>Credit Line</div></td>
    <td width='7%' height='35' class='style4'><div align='right'>PHIC</div></td>
    <td width='7%' height='35' class='style4'><div align='right'>Company</div></td>
    <td width='7%' height='35' class='style4'><div align='right'>Total Bill</div></td>
    <td width='7%' height='35' class='style4'><div align='right'>Deposit</div></td>
    <td width='9%' height='35' class='style4'><div align='right'>Balance After</div></td>
  </tr>
  <tr>
    <td height='1' colspan='11' bgcolor='#000000'></td>
  </tr>
";

$totalBalance=0;
$asql=mysql_query("SELECT rd.registrationNo, rd.Company, rd.dateRegistered, rd.dateUnregistered, rd.room, rd.LimitHMO, pr.lastName, pr.firstName, pr.middleName FROM registrationDetails rd, patientRecord pr WHERE rd.patientNo=pr.patientNo AND (rd.dateRegistered BETWEEN '$fdate' AND '$tdate') AND rd.dateUnregistered='' AND (rd.type='IPD' OR rd.type='OR/DR' OR rd.type='ICU' OR rd.type='OB-Package')  ORDER BY pr.lastName");
while($afetch=mysql_fetch_array($asql)){
$room=$afetch['room'];

//$zsql=mysql_query("SELECT description FROM patientCharges WHERE registrationNo='$registrationNo'");
//while($zfetch=mysql_fetch_array($zsql)){$room=$zfetch['description'];}

$bsql=mysql_query("SELECT floor FROM room WHERE Description='$room' AND floor='$floor'");
$bcount=mysql_num_rows($bsql);

if($bcount!=0){
$registrationNo=$afetch['registrationNo'];
$Company=$afetch['Company'];
$dateRegistered=$afetch['dateRegistered'];
$dateUnregistered=$afetch['dateUnregistered'];
$LimitHMO=$afetch['LimitHMO'];
$lastName=$afetch['lastName'];
$firstName=$afetch['firstName'];
$middleName=$afetch['middleName'];

$patient=$lastName.", ".$firstName." ".$middleName;
$patientfmt=strtoupper($patient);

$csql=mysql_query("SELECT SUM(discount) AS sumdiscount, SUM(total) AS sumtotal, SUM(cashUnpaid) AS sumcashUnpaid, SUM(phic) AS sumphic, SUM(company) AS sumcompany, SUM(cashPaid) AS sumcashPaid FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%'");
while($cfetch=mysql_fetch_array($csql)){$sumtotal=$cfetch['sumtotal']; $sumcashUnpaid=$cfetch['sumcashUnpaid']; $sumphic=$cfetch['sumphic']; $sumcompany=$cfetch['sumcompany']; $sumcashPaid=$cfetch['sumcashPaid'];}

$zsql=mysql_query("SELECT SUM(discount) AS sumdiscount, SUM(total) AS sumtotal, SUM(cashUnpaid) AS sumcashUnpaid, SUM(phic) AS sumphic, SUM(company) AS sumcompany, SUM(cashPaid) AS sumcashPaid FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%' AND title='MEDICINE' AND departmentStatus=''");
while($zfetch=mysql_fetch_array($zsql)){$zsumtotal=$zfetch['sumtotal']; $zsumcashUnpaid=$zfetch['sumcashUnpaid']; $zsumphic=$zfetch['sumphic']; $zsumcompany=$zfetch['sumcompany']; $zsumcashPaid=$zfetch['sumcashPaid'];}

$ysql=mysql_query("SELECT SUM(discount) AS sumdiscount, SUM(total) AS sumtotal, SUM(cashUnpaid) AS sumcashUnpaid, SUM(phic) AS sumphic, SUM(company) AS sumcompany, SUM(cashPaid) AS sumcashPaid FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%' AND title='SUPPLIES' AND departmentStatus=''");
while($yfetch=mysql_fetch_array($ysql)){$ysumtotal=$yfetch['sumtotal']; $ysumcashUnpaid=$yfetch['sumcashUnpaid']; $ysumphic=$yfetch['sumphic']; $ysumcompany=$yfetch['sumcompany']; $ysumcashPaid=$yfetch['sumcashPaid'];}

$sumtotalfmt=number_format(($sumtotal-$zsumtotal-$ysumtotal),2,'.',',');
$sumcashUnpaidfmt=number_format(($sumcashUnpaid-$zsumcashUnpaid-$ysumcashUnpaid),2,'.',',');
$sumphicfmt=number_format(($sumphic-$zsumphic-$ysumphic),2,'.',',');
$sumcompanyfmt=number_format(($sumcompany-$zsumcompany-$ysumcompany),2,'.',',');
$sumcashPaidfmt=number_format(($sumcashPaid-$zsumcashPaid-$ysumcashPaid),2,'.',',');

$dsql=mysql_query("SELECT SUM(amountPaid) AS sumPaid FROM patientPayment WHERE registrationNo='$registrationNo'");
while($dfetch=mysql_fetch_array($dsql)){$sumPaid=$dfetch['sumPaid'];}

$esql=mysql_query("SELECT discount FROM registrationDetails WHERE registrationNo='$registrationNo'");
while($efetch=mysql_fetch_array($esql)){$ediscount=$efetch['discount'];}

$sumPaidfmt=number_format($sumPaid,2,'.',',');

$trueBalance=$sumcashUnpaid-$sumPaid-$ediscount-$zsumcashUnpaid-$ysumcashUnpaid;
$trueBalancefmt=number_format($trueBalance,2,'.',',');

$totalBalance+=$trueBalance;

if($trueBalance>=5000){$class1="style6";}else{$class1="style3";}

echo "
  <tr>
    <td height='30' class='$class1'><div align='left'>$registrationNo</div></td>
    <td height='30' class='$class1'><div align='left'>$patientfmt</div></td>
    <td height='30' class='$class1'><div align='center'>$dateRegistered</div></td>
    <td height='30' class='$class1'><div align='center'>$room</div></td>
    <td height='30' class='$class1'><div align='center'>$Company</div></td>
    <td height='30' class='$class1'><div align='center'>$LimitHMO</div></td>
    <td height='30' class='$class1'><div align='right'>$sumphicfmt</div></td>
    <td height='30' class='$class1'><div align='right'>$sumcompanyfmt</div></td>
    <td height='30' class='$class1'><div align='right'>$sumcashUnpaidfmt</div></td>
    <td height='30' class='style5'><div align='right'>$sumPaidfmt</div></td>
    <td height='30' class='$class1'><div align='right'>$trueBalancefmt</div></td>
  </tr>
";
}
else{
if($room==''){
$registrationNo=$afetch['registrationNo'];
$Company=$afetch['Company'];
$dateRegistered=$afetch['dateRegistered'];
$dateUnregistered=$afetch['dateUnregistered'];
$LimitHMO=$afetch['LimitHMO'];
$lastName=$afetch['lastName'];
$firstName=$afetch['firstName'];
$middleName=$afetch['middleName'];

$patient=$lastName.", ".$firstName." ".$middleName;
$patientfmt=strtoupper($patient);

$csql=mysql_query("SELECT SUM(discount) AS sumdiscount, SUM(total) AS sumtotal, SUM(cashUnpaid) AS sumcashUnpaid, SUM(phic) AS sumphic, SUM(company) AS sumcompany, SUM(cashPaid) AS sumcashPaid FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%'");
while($cfetch=mysql_fetch_array($csql)){$sumtotal=$cfetch['sumtotal']; $sumcashUnpaid=$cfetch['sumcashUnpaid']; $sumphic=$cfetch['sumphic']; $sumcompany=$cfetch['sumcompany']; $sumcashPaid=$cfetch['sumcashPaid'];}

$zsql=mysql_query("SELECT SUM(discount) AS sumdiscount, SUM(total) AS sumtotal, SUM(cashUnpaid) AS sumcashUnpaid, SUM(phic) AS sumphic, SUM(company) AS sumcompany, SUM(cashPaid) AS sumcashPaid FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%' AND title='MEDICINE' AND departmentStatus=''");
while($zfetch=mysql_fetch_array($zsql)){$zsumtotal=$zfetch['sumtotal']; $zsumcashUnpaid=$zfetch['sumcashUnpaid']; $zsumphic=$zfetch['sumphic']; $zsumcompany=$zfetch['sumcompany']; $zsumcashPaid=$zfetch['sumcashPaid'];}

$ysql=mysql_query("SELECT SUM(discount) AS sumdiscount, SUM(total) AS sumtotal, SUM(cashUnpaid) AS sumcashUnpaid, SUM(phic) AS sumphic, SUM(company) AS sumcompany, SUM(cashPaid) AS sumcashPaid FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%' AND title='SUPPLIES' AND departmentStatus=''");
while($yfetch=mysql_fetch_array($ysql)){$ysumtotal=$yfetch['sumtotal']; $ysumcashUnpaid=$yfetch['sumcashUnpaid']; $ysumphic=$yfetch['sumphic']; $ysumcompany=$yfetch['sumcompany']; $ysumcashPaid=$yfetch['sumcashPaid'];}

$sumtotalfmt=number_format(($sumtotal-$zsumtotal-$ysumtotal),2,'.',',');
$sumcashUnpaidfmt=number_format(($sumcashUnpaid-$zsumcashUnpaid-$ysumcashUnpaid),2,'.',',');
$sumphicfmt=number_format(($sumphic-$zsumphic-$ysumphic),2,'.',',');
$sumcompanyfmt=number_format(($sumcompany-$zsumcompany-$ysumcompany),2,'.',',');
$sumcashPaidfmt=number_format(($sumcashPaid-$zsumcashPaid-$ysumcashPaid),2,'.',',');


$dsql=mysql_query("SELECT SUM(amountPaid) AS sumPaid FROM patientPayment WHERE registrationNo='$registrationNo'");
while($dfetch=mysql_fetch_array($dsql)){$sumPaid=$dfetch['sumPaid'];}

$esql=mysql_query("SELECT discount FROM registrationDetails WHERE registrationNo='$registrationNo'");
while($efetch=mysql_fetch_array($esql)){$ediscount=$efetch['discount'];}

$sumPaidfmt=number_format($sumPaid,2,'.',',');

$trueBalance=$sumcashUnpaid-$sumPaid-$ediscount-$zsumcashUnpaid-$ysumcashUnpaid;
$trueBalancefmt=number_format($trueBalance,2,'.',',');

$totalBalance+=$trueBalance;

if($trueBalance>=5000){$class1="style6";}else{$class1="style3";}

echo "
  <tr>
    <td height='30' class='$class1'><div align='left'>$registrationNo</div></td>
    <td height='30' class='$class1'><div align='left'>$patientfmt</div></td>
    <td height='30' class='$class1'><div align='center'>$dateRegistered</div></td>
    <td height='30' class='$class1'><div align='center'>$room</div></td>
    <td height='30' class='$class1'><div align='center'>$Company</div></td>
    <td height='30' class='$class1'><div align='center'>$LimitHMO</div></td>
    <td height='30' class='$class1'><div align='right'>$sumphicfmt</div></td>
    <td height='30' class='$class1'><div align='right'>$sumcompanyfmt</div></td>
    <td height='30' class='$class1'><div align='right'>$sumcashUnpaidfmt</div></td>
    <td height='30' class='style5'><div align='right'>$sumPaidfmt</div></td>
    <td height='30' class='$class1'><div align='right'>$trueBalancefmt</div></td>
  </tr>
";
}
else{
//Blank
}
}
}


$totalBalancefmt=number_format($totalBalance,2,'.',',');

echo "
  <tr>
    <td height='1' colspan='11' bgcolor='#000000'></td>
  </tr>
  <tr>
    <td height='35' colspan='10' class='style4'><div align='right'>TOTAL ======================================================&gt; </div></td>
    <td height='35' class='style4'><div align='right'>$totalBalancefmt</div></td>
  </tr>
  <tr>
    <td height='1' colspan='11' bgcolor='#000000'></td>
  </tr>
</table>
</div>
";

?>
</body>
</html>
