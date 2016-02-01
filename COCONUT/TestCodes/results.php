<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.text01 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #000000;
}
.text02 {
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

$SelectedNoOfDays=$_GET['SelectedNoOfDays'];


echo "
<div align='left'>
  <table width='800' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
    <tr>
      <td width='110' class='text01'><div align='center'>Patient No. </div></td>
      <td width='110' class='text01'><div align='center'>Registration No. </div></td>
      <td width='347' class='text01'><div align='center'>Patient</div></td>
      <td width='130' class='text01'><div align='center'>Date Discharged </div></td>
      <td width='91' class='text01'><div align='center'>Days</div></td>
    </tr>
";

$pdate=date("Y-m-d");

$date = new DateTime($pdate);
$dateInterval="P".$SelectedNoOfDays."D";
$date->sub(new DateInterval($dateInterval));
$newdate=$date->format('Y-m-d') . "\n";

echo $newdate;

$asql=mysql_query("SELECT rd.patientNo, rd.registrationNo, rd.dateUnregistered, pr.lastName, pr.firstName, pr.middleName FROM registrationDetails rd, patientRecord pr WHERE rd.patientNo=pr.patientNo AND rd.company NOT LIKE '' AND (rd.dateUnregistered BETWEEN '$newdate' AND '$pdate') ORDER BY rd.dateUnregistered DESC");
while($afetch=mysql_fetch_array($asql)){
$patientNo=$afetch['patientNo'];
$registrationNo=$afetch['registrationNo'];
$dateUnregistered=$afetch['dateUnregistered'];
$lastName=$afetch['lastName'];
$firstName=$afetch['firstName'];
$middleName=$afetch['middleName'];

$patient=$lastName.", ".$firstName." ".$middleName;
$dateUnregisteredstr=strtotime($dateUnregistered);
$dateUnregisteredfmt=date("M. d, Y",$dateUnregisteredstr);

$now=time();
$your_date=strtotime($dateUnregistered);
$datediff=$now-$your_date;
$daysaged=floor($datediff/(60*60*24));

echo "
    <tr>
      <td class='text02'><div align='center'>$patientNo</div></td>
      <td class='text02'><div align='center'>$registrationNo</div></td>
      <td class='text02'><div align='left'>&nbsp;$patient</div></td>
      <td class='text02'><div align='center'>$dateUnregisteredfmt</div></td>
      <td class='text02'><div align='center'>$daysaged Days</div></td>
    </tr>
";
}

echo "
  </table>
</div>
";

?>
</body>
</html>
