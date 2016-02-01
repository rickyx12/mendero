<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HMO/Company Aging Of Accounts</title>
<style type="text/css">
<!--
.text01 {
	font-family: Arial;
	font-size: 16px;
	font-weight: bold;
	color: #000000;
}
.text02 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #000000;
}
.text03 {
	font-family: Arial;
	font-size: 12px;
	color: #000000;
}
-->
</style>
</head>

<body>
<?php
mysql_connect("localhost","root","cebu01");
mysql_select_db("Coconut");

echo "
<div align='center'><span class='text01'>Aging of Accounts</span>
  <br />
  <br />
  <table width='98%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
    <tr>
      <td width='3%' height='30' class='text02'><div align='center'>No.</div></td>
      <td width='8%' class='text02'><div align='center'>Patient No.</div></td>
      <td width='8%' class='text02'><div align='center'>Registration No. </div></td>
      <td width='16%' class='text02'><div align='center'>Patient Name </div></td>
      <td width='9%' class='text02'><div align='center'>Date Discharged </div></td>
      <td width='10%' class='text02'><div align='center'>HMO/Company</div></td>
      <td width='10%' class='text02'><div align='center'>Balance</div></td>
      <td width='6%' class='text02'><div align='center'>30 Below </div></td>
      <td width='6%' class='text02'><div align='center'>31-45</div></td>
      <td width='6%' class='text02'><div align='center'>46-60</div></td>
      <td width='6%' class='text02'><div align='center'>61-90</div></td>
      <td width='6%' class='text02'><div align='center'>91-120</div></td>
      <td width='6%' class='text02'><div align='center'>121 Up</div></td>
    </tr>
";

/*$pdate=date("Y-m-d");

$date = new DateTime($pdate);
$dateInterval="P".$SelectedNoOfDays."D";
$date->sub(new DateInterval($dateInterval));
$newdate=$date->format('Y-m-d') . "\n";

echo $newdate;*/

$num=0;
$asql=mysql_query("SELECT rd.patientNo, rd.registrationNo, rd.Company, rd.dateUnregistered, pr.lastName, pr.firstName, pr.middleName FROM registrationDetails rd, patientRecord pr WHERE rd.patientNo=pr.patientNo AND rd.company NOT LIKE '' ORDER BY rd.dateUnregistered DESC");
while($afetch=mysql_fetch_array($asql)){
$registrationNo=$afetch['registrationNo'];

//$bsql=mysql_query("SELECT registrationNo FROM companyPayment WHERE registrationNO='$registrationNo' AND paymentFor='HOSPITAL BILL' AND status LIKE ''");
//$bcount=mysql_num_rows($bsql);

//if($bcount>0){
$num++;
$patientNo=$afetch['patientNo'];
$Company=$afetch['Company'];
$dateUnregistered=$afetch['dateUnregistered'];
$lastName=$afetch['lastName'];
$firstName=$afetch['firstName'];
$middleName=$afetch['middleName'];

$patient=$lastName.", ".$firstName." ".$middleName;
$patientfmt=strtoupper($patient);
$dateUnregisteredstr=strtotime($dateUnregistered);
$dateUnregisteredfmt=date("M. d, Y",$dateUnregisteredstr);

$now=time();
$your_date=strtotime($dateUnregistered);
$datediff=$now-$your_date;
$daysaged=floor($datediff/(60*60*24));

if($daysaged<=30){$a=$daysaged; $b=''; $c=''; $d=''; $e=''; $f='';}
else if(($daysaged>30)&&($daysaged<=45)){$a=''; $b=$daysaged; $c=''; $d=''; $e=''; $f='';}
else if(($daysaged>45)&&($daysaged<=60)){$a=''; $b=''; $c=$daysaged; $d=''; $e=''; $f='';}
else if(($daysaged>60)&&($daysaged<=90)){$a=''; $b=''; $c=''; $d=$daysaged; $e=''; $f='';}
else if(($daysaged>90)&&($daysaged<=120)){$a=''; $b=''; $c=''; $d=''; $e=$daysaged; $f='';}
else if($daysaged>120){$a=''; $b=''; $c=''; $d=''; $e=''; $f=$daysaged;}

$csql=mysql_query("SELECT SUM(company) AS totcomp FROM patientCharges WHERE registrationNo='$registrationNo' AND status NOT LIKE 'DELETED%%'");
while($cfetch=mysql_fetch_array($csql)){$totcomp=$cfetch['totcomp'];}

$totcompfmt=number_format($totcomp,2,'.',',');

echo "
    <tr>
      <td height='20' class='text03'><div align='center'>$num</div></td>
      <td class='text03'><div align='center'>$patientNo</div></td>
      <td class='text03'><div align='center'>$registrationNo</div></td>
      <td class='text03'><div align='center'>&nbsp;$patientfmt</div></td>
      <td class='text03'><div align='center'>$dateUnregistered</div></td>
      <td class='text03'><div align='center'>$Company</div></td>
      <td class='text03'><div align='center'>$totcompfmt</div></td>
      <td class='text03'><div align='center'>$a</div></td>
      <td class='text03'><div align='center'>$b</div></td>
      <td class='text03'><div align='center'>$c</div></td>
      <td class='text03'><div align='center'>$d</div></td>
      <td class='text03'><div align='center'>$e</div></td>
      <td class='text03'><div align='center'>$f</div></td>
    </tr>
";
//}
//else{
//Blank
//}

}

echo "
  </table>
</div>
";
?>
</body>
</html>
