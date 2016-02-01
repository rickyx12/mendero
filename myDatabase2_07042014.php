<?php
include("myDatabase1.php");

class database2 extends database1 {


//********************** LAB RESULT **************************//

public function listLaboratory_done($month,$day,$year) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$date = $year."-".$month."-".$day;


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT referred,savedNo,registrationNo,itemNo,chargesCode,medtech,date,time FROM labSavedResult WHERE date = '$date' and status not like 'DELETED_%%%%%%%%%%' order by time desc ");
//echo "<table border=1 cellspacing=0 rules=all>";
//echo "<tr>";
//echo "<Th>Patient</th>";
//echo "<Th>Result</th>";
//echo "<th>Realesed</th>";
//echo "</tr>";
while($row = mysql_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
echo "<tr>";
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/testDone/referredUser.php?savedNo=$row[savedNo]'><font size=2>".$this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()."</font></a></td>";

if($row['referred'] != "") {
echo "<td>&nbsp;<font size=2>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</font><br>&nbsp;<Font size=1 color=red>(Referred)</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</font></td>";
}

echo "<td>&nbsp;<font size=2>".$row['time']."</font></td>";
echo "<Td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$row[registrationNo]&itemNo=$row[itemNo]' target='_blank'><font size=2 color=red>View</font></a>&nbsp;</td>";
echo "</tr>";

  }
//echo "</table>";

}




public function listLaboratory_done_search($month,$day,$year,$name) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$date = $year."-".$month."-".$day;


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT lsr.referred,lsr.savedNo,lsr.registrationNo,lsr.itemNo,lsr.chargesCode,lsr.medtech,lsr.date,lsr.time FROM labSavedResult lsr,patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and pc.itemNo = lsr.itemNo and lsr.date = '$date' and pr.completeName like '".mysql_real_escape_string($name)."%%%%%' order by lsr.time desc ");
//echo "<table border=1 cellspacing=0 rules=all>";
//echo "<tr>";
//echo "<Th>Patient</th>";
//echo "<Th>Result</th>";
//echo "<th>Realesed</th>";
//echo "</tr>";
while($row = mysql_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
echo "<tr>";
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/testDone/referredUser.php?savedNo=$row[savedNo]'><font size=2>".$this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()."</font></a></td>";

if($row['referred'] != "") {
echo "<td>&nbsp;<font size=2>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</font><br>&nbsp;<Font size=1 color=red>(Referred)</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</font></td>";
}

echo "<td>&nbsp;<font size=2>".$row['time']."</font></td>";
echo "<Td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$row[registrationNo]&itemNo=$row[itemNo]' target='_blank'><font size=2 color=red>View</font></a>&nbsp;</td>";
echo "</tr>";

  }
//echo "</table>";

}



//**************** END OF LAB RESULT **********************************//



public function getPatientCharges_status($registrationNo,$username,$show,$desc,$status) {

$this->getPatientProfile($registrationNo);

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

.data {
font-size:12px;
}
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

if($show == "All") {
$result = mysql_query("SELECT * FROM patientCharges where registrationNo = '$registrationNo' and status = '$status' order by dateCharge,timeCharge desc ");
}else {
$result = mysql_query("SELECT * FROM patientCharges where registrationNo = '$registrationNo' and status = '$status' and description like '$desc%%%%%%' order by description asc ");
}


while($row = mysql_fetch_array($result))
  {
//$this->getMyResults($this->getResult_labNo($row['itemNo']),$username);
//$price = preg_split ("/\//", $row['sellingPrice']); 
$deptStatus = preg_split ("/\_/", $row['departmentStatus']); 
echo "<tr>";

/*********STRPOS*************/
if (strpos($row['sellingPrice'],'/') !== false) {
$price = preg_split ("/\//", $row['sellingPrice']); 
}else { 
$price[0] = $row['sellingPrice'];
$price[1] = "0.00";
} 
/***************************/

$this->patientChargez_cashUnpaid+=$row['cashUnpaid'];
$this->patientChargez_company+=$row['company'];
$this->patientChargez_phic+=$row['phic'];
$this->patientChargez_disc+=$row['discount'];
$this->patientChargez_total+=$row['total'];
$this->patientChargez_paid+=$row['cashPaid'];

$myDesc = $this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()." - ".$row['description'];


if( $row['status'] != "PAID" ) {

if( $this->selectNow("forDeletion","itemNo","itemNo",$row['itemNo']) > 0 ) {
echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}else if( $row['title'] == "Room And Board" ) {
echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}else if( $row['batchNo'] == "package" ) {
echo "<Td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/verifyDelete_pass.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&description=$myDesc&quantity=$row[quantity]&username=$username&show=$show&desc=$desc'><font size=2 color=red>Px</font></a>&nbsp;</tD>";
}else if( $this->selectNow("registrationDetails","mgh","registrationNo",$row['registrationNo']) != "") {
echo "<Td>&nbsp;<font size=2 color=red>MGH</font>&nbsp;</tD>";
}else if( $row['status'] == "Return" ) {
echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}
else {
//$myDesc = $this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()." - ".$row['description'];

echo "<td><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/verifyDelete_pass.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&description=$myDesc&quantity=$row[quantity]&username=$username&show=$show&desc=$desc'>
<img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg' />
</a></td>";

}

}else {

echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}


if($deptStatus[0] == "dispensedBy") {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']." &nbsp;(<font size=1 color=red>Dispensed @ $row[departmentStatus_time] by $deptStatus[1] </font>)</a></font>&nbsp;</td>";
}else if($this->checkIfLabResultExist($row['itemNo']) > 0 && $row['title'] == "LABORATORY" ) {

if($this->checkIfLabResultExist($row['itemNo']) > 0) {

echo "<td>&nbsp;<font class='data'><a href='#'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$row[registrationNo]&itemNo=$row[itemNo]'>(<font color=red size=1>Test Done</font>)</font></a>&nbsp;</td>";


}else {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultList.php?registrationNo=$row[registrationNo]&username=$username&chargesCode=$row[chargesCode]&itemNo=$row[itemNo]'>".$row['description']."</a></font>&nbsp;</td>";
}

}else if($this->checkIfRadResultExist($row['itemNo']) > 0 && $row['title'] == "RADIOLOGY" ) {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&description=$row[description]'>(<font color=red size=1>Test Done</font>)</font></a>&nbsp;</td>";
}else if($this->checkIfSoapExist($row['itemNo']) > 0 && $row['title'] == "PROFESSIONAL FEE" ) {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Doctor/doctorModule/soapView.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&username=$username'>(<font color=red size=1>S.O.A.P</font>)</font></a>&nbsp;</td>";
}

else if( $this->selectNow("registrationDetails","mgh","registrationNo",$row['registrationNo']) != "") {
echo "<td>&nbsp;<font class='data'><a href='#'>".$row['description']."</a></font>&nbsp;</td>";
}

else  {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a></font>&nbsp;</td>";
}


if($row['title']=="PROFESSIONAL FEE") {
echo "<td><font class='data'>".number_format($price[0],2)."</font>/<font class='data'>".$price[1]."</font>&nbsp;</td>";
}else if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES"  ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" ) { //allowed to view the price
echo "<td><font class='data'>".number_format($row['sellingPrice'],2)."</font>&nbsp;</td>";
}else { // not allowed to view the price
echo "<td><font size=2 color=red>Confidential</font></td>";
}

}
else {
echo "<td><font class='data'>".number_format($row['sellingPrice'],2)."</font>&nbsp;</td>";
}

echo "<td>&nbsp;<font class='data'>".$row['quantity']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['discount']."</font>&nbsp;</td>";


if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES" ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" ) { //allowed to view the price
echo "<td>&nbsp;<font class='data'>".number_format($row['total'],2)."</font>&nbsp;</td>";
}else { //not allowed to view the price
echo "<td><font size=2 color=red>Confidential</font></td>";
}

}else {
echo "<td>&nbsp;<font class='data'>".number_format($row['total'],2)."</font>&nbsp;</td>";
}

echo "<td>&nbsp;<font class='data'>".$row['timeCharge']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['dateCharge']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['chargeBy']."</font>&nbsp;</td>";

if($row['inventoryFrom'] != "none") {
echo "<td>&nbsp;<font class='data'>".$row['service']."</font><br><font class='data'>".$row['inventoryFrom']."</font>&nbsp;</td>";
}else if($row['inventoryFrom'] == "") {
echo "<td>&nbsp;<font class='data'>".$row['service']."</font>&nbsp;</td>";
}else if($row['title'] == "LABORATORY") {

if( $this->checkIfLabResultExist($row['itemNo']) > 0 ) {
echo "<td>&nbsp;<a href='#'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}else {
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultList.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&chargesCode=$row[chargesCode]&username=$username'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}

}else if($row['title'] == "RADIOLOGY") {
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReportSettings.php?description=$row[description]&registrationNo=$registrationNo&itemNo=$row[itemNo]&branch=$row[branch]'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}else if($row['title'] == "PROFESSIONAL FEE") {
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Doctor/doctorModule/soap.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&username=$username'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data'>".$row['service']."</font>&nbsp;</td>";
}

if($row['status']=="PAID" ) {
echo "<td>&nbsp;<font class='data' color=blue>".$row['status']."</font>&nbsp;</td>";
}
else if($row['status']=="BALANCE" || $row['status']=="APPROVED") {
echo "<td>&nbsp;<font class='data' color=red>".$row['status']."</font>&nbsp;</td>";
}
else {
echo "<td>&nbsp;<font class='data'>".$row['status']."</font>&nbsp;</td>";
}
if($row['paidVia']=="Company") {
echo "<td>&nbsp;<font class='data' color=red>".$row['paidVia']."</font>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data' color=blue>".$row['paidVia']."</font>&nbsp;</td>";
}


if($row['title'] == "PROFESSIONAL FEE") {
echo "<td>&nbsp;<center><font class='data'>".number_format($row['cashUnpaid'],2)."</font></centeR>&nbsp;</td>";
}else if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES" ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY"  ) { //allowed to view the price
echo "<td>&nbsp;<center><font class='data'>".number_format($row['cashUnpaid'],2)."</font></centeR>&nbsp;</td>";
}else { // not allowed to view the price
echo "<td> <font size=2 color=red>Confidential</font></td>";
}

}else {
echo "<td>&nbsp;<center><font class='data'>".number_format($row['cashUnpaid'],2)."</font></centeR>&nbsp;</td>";
}


if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES" ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" ) {
echo "<td>&nbsp;<center><font class='data'>".number_format($row['company'],2)."</font></center>&nbsp;</td>";
echo "<td>&nbsp;<center><font class='data'>".number_format($row['phic'],2)."</font></center>&nbsp;</td>";
}else {
echo "<td><font size=2 color=red>Confidential</font></td>";
echo "<td><font size=2 color=red>Confidential</font></td>";
}
}else {

echo "<td>&nbsp;<center><font class='data'>".number_format($row['company'],2)."</font></center>&nbsp;</td>";
echo "<td>&nbsp;<center><font class='data'>".number_format($row['phic'],2)."</font></center>&nbsp;</td>";

}

if($this->checkBalanceItem($row['itemNo']) > 0 ) {
echo "<td>&nbsp;<font class='data'>".number_format(($row['cashPaid'] + $this->getBalancePaid($row['itemNo'])),2)."</font>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data'>".$row['cashPaid']."</font>&nbsp;</td>";
}
echo "<td>&nbsp;<font class='data'>".$row['branch']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['title']."</font>&nbsp;</td>";
echo "</tr>";
  }


//row after looping d2 ippkta ung total ng "balance","Company","hmo"
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "<td><center><b>TOTAL</b></center></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" ) {
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_disc,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_total,2)."</center></td>";
}else {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}

echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" ) {

echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_cashUnpaid,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_company,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_phic,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_paid,2)."</center></td>";
}else {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

}

echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";


}


/**************************************************************************************/

public function getPatientCharges_noDialysis($registrationNo,$username,$show,$desc) {

$this->getPatientProfile($registrationNo);

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

.data {
font-size:12px;
}
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT * FROM patientCharges where registrationNo = '$registrationNo' and (title = 'MEDICINE' or title = 'SUPPLIES' or title = 'LABORATORY' or title = 'RADIOLOGY' or title = 'ECG' or title = 'NURSING-CHARGES' or title = 'MISCELLANEOUS' or title = 'OR/DR/ER FEE' or title = 'REHAB' or title = 'OXYGEN' or title='NBS') order by dateCharge,timeCharge asc ");



while($row = mysql_fetch_array($result))
  {
//$this->getMyResults($this->getResult_labNo($row['itemNo']),$username);
//$price = preg_split ("/\//", $row['sellingPrice']); 
$deptStatus = preg_split ("/\_/", $row['departmentStatus']); 
echo "<tr>";

/*********STRPOS*************/
if (strpos($row['sellingPrice'],'/') !== false) {
$price = preg_split ("/\//", $row['sellingPrice']); 
}else { 
$price[0] = $row['sellingPrice'];
$price[1] = "0.00";
} 
/***************************/

$this->patientChargez_cashUnpaid+=$row['cashUnpaid'];
$this->patientChargez_company+=$row['company'];
$this->patientChargez_phic+=$row['phic'];
$this->patientChargez_disc+=$row['discount'];
$this->patientChargez_total+=$row['total'];
$this->patientChargez_paid+=$row['cashPaid'];

$myDesc = $this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()." - ".$row['description'];
if( $this->selectNow("forDeletion","itemNo","itemNo",$row['itemNo']) > 0 ) {
echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}else if( $row['title'] == "Room And Board" ) {
echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}else if( $row['batchNo'] == "package" ) {
echo "<Td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/verifyDelete_pass.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&description=$myDesc&quantity=$row[quantity]&username=$username&show=$show&desc=$desc'><font size=2 color=red>Px</font></a>&nbsp;</tD>";
}else if( $this->selectNow("registrationDetails","mgh","registrationNo",$row['registrationNo']) != "") {
echo "<Td>&nbsp;<font size=2 color=red>MGH</font>&nbsp;</tD>";
}else if( $row['status'] == "Return" ) {
echo "<Td>&nbsp;<img src='http://".$this->getMyUrl()."/COCONUT/myImages/locked1.jpeg' />&nbsp;</tD>";
}
else {
//$myDesc = $this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()." - ".$row['description'];
echo "<td><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/verifyDelete_pass.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&description=$myDesc&quantity=$row[quantity]&username=$username&show=$show&desc=$desc'>
<img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg' />
</a></td>";
}


if($deptStatus[0] == "dispensedBy") {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']." &nbsp;(<font size=1 color=red>Dispensed @ $row[departmentStatus_time] by $deptStatus[1] </font>)</a></font>&nbsp;</td>";
}else if($this->checkIfLabResultExist($row['itemNo']) > 0 && $row['title'] == "LABORATORY" ) {

if($this->checkIfLabResultExist($row['itemNo']) > 0) {

echo "<td>&nbsp;<font class='data'><a href='#'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$row[registrationNo]&itemNo=$row[itemNo]'>(<font color=red size=1>Test Done</font>)</font></a>&nbsp;</td>";


}else {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultList.php?registrationNo=$row[registrationNo]&username=$username&chargesCode=$row[chargesCode]&itemNo=$row[itemNo]'>".$row['description']."</a></font>&nbsp;</td>";
}

}else if($this->checkIfRadResultExist($row['itemNo']) > 0 && $row['title'] == "RADIOLOGY" ) {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&description=$row[description]'>(<font color=red size=1>Test Done</font>)</font></a>&nbsp;</td>";
}else if($this->checkIfSoapExist($row['itemNo']) > 0 && $row['title'] == "PROFESSIONAL FEE" ) {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Doctor/doctorModule/soapView.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&username=$username'>(<font color=red size=1>S.O.A.P</font>)</font></a>&nbsp;</td>";
}

else if( $this->selectNow("registrationDetails","mgh","registrationNo",$row['registrationNo']) != "") {
echo "<td>&nbsp;<font class='data'><a href='#'>".$row['description']."</a></font>&nbsp;</td>";
}

else  {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a></font>&nbsp;</td>";
}


if($row['title']=="PROFESSIONAL FEE") {
echo "<td><font class='data'>".number_format($price[0],2)."</font>/<font class='data'>".$price[1]."</font>&nbsp;</td>";
}else if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES"  ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" ) { //allowed to view the price
echo "<td><font class='data'>".number_format($row['sellingPrice'],2)."</font>&nbsp;</td>";
}else { // not allowed to view the price
echo "<td><font size=2 color=red>Confidential</font></td>";
}

}
else {
echo "<td><font class='data'>".number_format($row['sellingPrice'],2)."</font>&nbsp;</td>";
}

echo "<td>&nbsp;<font class='data'>".$row['quantity']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['discount']."</font>&nbsp;</td>";


if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES" ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" ) { //allowed to view the price
echo "<td>&nbsp;<font class='data'>".number_format($row['total'],2)."</font>&nbsp;</td>";
}else { //not allowed to view the price
echo "<td><font size=2 color=red>Confidential</font></td>";
}

}else {
echo "<td>&nbsp;<font class='data'>".number_format($row['total'],2)."</font>&nbsp;</td>";
}

echo "<td>&nbsp;<font class='data'>".$row['timeCharge']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['dateCharge']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['chargeBy']."</font>&nbsp;</td>";

if($row['inventoryFrom'] != "none") {
echo "<td>&nbsp;<font class='data'>".$row['service']."</font><br><font class='data'>".$row['inventoryFrom']."</font>&nbsp;</td>";
}else if($row['inventoryFrom'] == "") {
echo "<td>&nbsp;<font class='data'>".$row['service']."</font>&nbsp;</td>";
}else if($row['title'] == "LABORATORY") {
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Results/addResults.php?description=$row[description]&registrationNo=$registrationNo&itemNo=$row[itemNo]&branch=$row[branch]'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}else if($row['title'] == "RADIOLOGY") {
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReportSettings.php?description=$row[description]&registrationNo=$registrationNo&itemNo=$row[itemNo]&branch=$row[branch]'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}else if($row['title'] == "PROFESSIONAL FEE") {
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Doctor/doctorModule/soap.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&username=$username'><font class='data'>".$row['service']."</font></a>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data'>".$row['service']."</font>&nbsp;</td>";
}

if($row['status']=="PAID" ) {
echo "<td>&nbsp;<font class='data' color=blue>".$row['status']."</font>&nbsp;</td>";
}
else if($row['status']=="BALANCE" || $row['status']=="APPROVED") {
echo "<td>&nbsp;<font class='data' color=red>".$row['status']."</font>&nbsp;</td>";
}
else {
echo "<td>&nbsp;<font class='data'>".$row['status']."</font>&nbsp;</td>";
}
if($row['paidVia']=="Company") {
echo "<td>&nbsp;<font class='data' color=red>".$row['paidVia']."</font>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data' color=blue>".$row['paidVia']."</font>&nbsp;</td>";
}


if($row['title'] == "PROFESSIONAL FEE") {
echo "<td>&nbsp;<center><font class='data'>".number_format($row['cashUnpaid'],2)."</font></centeR>&nbsp;</td>";
}else if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES" ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY"  ) { //allowed to view the price
echo "<td>&nbsp;<center><font class='data'>".number_format($row['cashUnpaid'],2)."</font></centeR>&nbsp;</td>";
}else { // not allowed to view the price
echo "<td> <font size=2 color=red>Confidential</font></td>";
}

}else {
echo "<td>&nbsp;<center><font class='data'>".number_format($row['cashUnpaid'],2)."</font></centeR>&nbsp;</td>";
}


if( $row['title'] == "MEDICINE" || $row['title'] == "SUPPLIES" ) {

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" ) {
echo "<td>&nbsp;<center><font class='data'>".number_format($row['company'],2)."</font></center>&nbsp;</td>";
echo "<td>&nbsp;<center><font class='data'>".number_format($row['phic'],2)."</font></center>&nbsp;</td>";
}else {
echo "<td><font size=2 color=red>Confidential</font></td>";
echo "<td><font size=2 color=red>Confidential</font></td>";
}
}else {

echo "<td>&nbsp;<center><font class='data'>".number_format($row['company'],2)."</font></center>&nbsp;</td>";
echo "<td>&nbsp;<center><font class='data'>".number_format($row['phic'],2)."</font></center>&nbsp;</td>";

}

if($this->checkBalanceItem($row['itemNo']) > 0 ) {
echo "<td>&nbsp;<font class='data'>".number_format(($row['cashPaid'] + $this->getBalancePaid($row['itemNo'])),2)."</font>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data'>".$row['cashPaid']."</font>&nbsp;</td>";
}
echo "<td>&nbsp;<font class='data'>".$row['branch']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font class='data'>".$row['title']."</font>&nbsp;</td>";
echo "</tr>";
  }


//row after looping d2 ippkta ung total ng "balance","Company","hmo"
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "<td><center><b>TOTAL</b></center></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" ) {
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_disc,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_total,2)."</center></td>";
}else {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}

echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

if( $this->selectNow("registeredUser","module","username",$username) == "PHILHEALTH" || $this->selectNow("registeredUser","module","username",$username) == "HMO" || $this->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $this->selectNow("registeredUser","module","username",$username) == "CASHIER" || $this->selectNow("registeredUser","module","username",$username) == "BILLING" ) {

echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_cashUnpaid,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_company,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_phic,2)."</center></td>";
echo "<td><center><font class='data' color=red>".number_format($this->patientChargez_paid,2)."</center></td>";
}else {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

}

echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";


}

/*************************************************************************************/









public $getDoctorsFee_atteding_total;
public $getDoctorsFee_atteding_cashUnpaid;
public $getDoctorsFee_atteding_phic;
public $getDoctorsFee_atteding_company;
public $getDoctorsFee_atteding_cashPaid;

public function getDoctorsFee_atteding_total() {
return $this->getDoctorsFee_atteding_total;
}
public function getDoctorsFee_atteding_cashUnpaid() {
return $this->getDoctorsFee_atteding_cashUnpaid;
}
public function getDoctorsFee_atteding_phic() {
return $this->getDoctorsFee_atteding_phic;
}
public function getDoctorsFee_atteding_company() {
return $this->getDoctorsFee_atteding_company;
}
public function getDoctorsFee_atteding_cashPaid() {
return $this->getDoctorsFee_atteding_cashPaid;
}

public function getDoctorsFee_attending($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT cashPaid,status,total,cashUnpaid,phic,company FROM patientCharges WHERE registrationNo='$registrationNo' and service='ATTENDING' and title = 'PROFESSIONAL FEE' ");

while($row = mysql_fetch_array($result))
  {
$this->getDoctorsFee_atteding_total = $row['total'];
if( $row['status'] == "UNPAID" ) {
$this->getDoctorsFee_atteding_cashUnpaid = $row['cashUnpaid'];
}else {
$this->getDoctorsFee_atteding_cashUnpaid = $row['cashPaid'];
}

$this->getDoctorsFee_atteding_phic = $row['phic'];
$this->getDoctorsFee_atteding_company = $row['company'];
$this->getDoctorsFee_atteding_cashPaid = $row['cashPaid'];
  }

}


public $getDoctorsFee_anesth_total;
public $getDoctorsFee_anesth_phic;
public $getDoctorsFee_anesth_company;
public $getDoctorsFee_anesth_cashUnpaid;
public $getDoctorsFee_anesth_cashPaid;

public function getDoctorsFee_anesth_total() {
return $this->getDoctorsFee_anesth_total;
}
public function getDoctorsFee_anesth_phic() {
return $this->getDoctorsFee_anesth_phic;
}
public function getDoctorsFee_anesth_company() {
return $this->getDoctorsFee_anesth_company;
}
public function getDoctorsFee_anesth_cashUnpaid() {
return $this->getDoctorsFee_anesth_cashUnpaid;
}
public function getDoctorsFee_anesth_cashPaid() {
return $this->getDoctorsFee_anesth_cashPaid;
}

public function getDoctorsFee_anesth($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT status,cashPaid,total,cashUnpaid,phic,company FROM patientCharges pc,Doctors d WHERE pc.chargesCode = d.doctorCode and pc.registrationNo='$registrationNo' and d.Specialization1 = 'ANESTHESIOLOGIST' and pc.title = 'PROFESSIONAL FEE' ");

while($row = mysql_fetch_array($result))
  {
$this->getDoctorsFee_anesth_total = $row['total'];
if( $row['status'] == "UNPAID" ) {
$this->getDoctorsFee_anesth_cashUnpaid = $row['cashUnpaid'];
}else {
$this->getDoctorsFee_anesth_cashUnpaid = $row['cashPaid'];
}
$this->getDoctorsFee_anesth_phic = $row['phic'];
$this->getDoctorsFee_anesth_company = $row['company']; 
$this->getDoctorsFee_anesth_cashPaid = $row['cashPaid'];   
}

}


public function addPayment_new($registrationNo,$amountPaid,$datePaid,$timePaid,$paidBy,$paymentFor,$orNo,$paidVia,$pf,$admitting,$control_datePaid,$receiptType) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO patientPayment (registrationNo,amountPaid,datePaid,timePaid,paidBy,paymentFor,orNo,paidVia,pf,admitting,control_datePaid,receiptType)
VALUES
('$registrationNo','$amountPaid','$datePaid','$timePaid','$paidBy','$paymentFor','$orNo','$paidVia','$pf','$admitting','$control_datePaid','$receiptType')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


/*
echo "<script type='text/javascript' >";
echo  "window.location='http://".$this->getMyUrl()."/COCONUT/patientProfile/patientProfile_handler.php?username=$paidBy&registrationNo=$registrationNo '";
echo "</script>";
*/
mysql_close($con);

}





public function getPF_notAdmitting($registrationNo) { 

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT sum(cashUnpaid) as total from patientCharges where registrationNo = '$registrationNo' and title = 'PROFESSIONAL FEE' and status = 'UNPAID' and service != 'ADMITTING' ");


while($row = mysql_fetch_array($result))
  {
return $row['total'];
}


}



public function getPF_Admitting($registrationNo) { 

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT sum(cashUnpaid) as total from patientCharges where registrationNo = '$registrationNo' and title = 'PROFESSIONAL FEE' and status = 'UNPAID' and service = 'ADMITTING' ");


while($row = mysql_fetch_array($result))
  {
return $row['total'];
}


}


public function deleteRoom_new($registrationNo,$itemNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

mysql_query("DELETE FROM patientCharges WHERE itemNo='$itemNo' and registrationNo='$registrationNo' ");

mysql_close($con);

}



public function getPatientRoom($registrationNo) { 

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT description,sellingPrice,quantity from patientCharges where registrationNo = '$registrationNo' and title = 'Room And Board' ");


while($row = mysql_fetch_array($result))
  {
$room = preg_split ("/\-/", $row['description']); 
echo "<td>&nbsp;<font size=2>".$room[0]." @ ".$row['sellingPrice']."/day x ".$row['quantity']."</font></td>";
}


}


public function deleteUnclearCharges($registrationNo,$title) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

mysql_query("DELETE FROM patientCharges WHERE registrationNo = '$registrationNo' and title = '$title' and departmentStatus = '' and status ='UNPAID'  ");

mysql_close($con);

}




public function sumPartial_new($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT (amountPaid + pf + admitting) as total FROM patientPayment WHERE registrationNo = '$registrationNo' ");

while($row = mysql_fetch_array($result))
  {
return $row['total'];
  }

}



public function discharged_inventory($registrationNo,$title) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(phic) as totalPHIC FROM patientCharges WHERE registrationNo = '$registrationNo' and title='$title' ");

while($row = mysql_fetch_array($result))
  {
return $row['totalPHIC'];
  }


}


public $discharged_name_medicine;
public $discharged_name_supplies;

public function discharged_name_medicine() {
return $this->discharged_name_medicine;
}
public function discharged_name_supplies() {
return $this->discharged_name_supplies;
}

public function discharged_name($month,$day,$year,$month1,$day1,$year1) {

echo "<style type='text/css'>";
echo "tr:hover { background-color:yellow;color:black;}";
echo "</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$discharged = $month."_".$day."_".$year;
$discharged1 = $month1."_".$day1."_".$year1;

$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered FROM patientRecord pr,registrationDetails rd WHERE pr.patientNo = rd.patientNo and (rd.dateUnregistered between '$discharged' and '$discharged1') order by dateUnregistered asc  ");

while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->discharged_name_medicine += $this->discharged_inventory($row['registrationNo'],"MEDICINE");
$this->discharged_name_supplies += $this->discharged_inventory($row['registrationNo'],"SUPPLIES");
$this->coconutTableData($row['dateUnregistered']);
$this->coconutTableData($row['lastName'].", ".$row['firstName']);
$this->coconutTableData(  number_format($this->discharged_inventory($row['registrationNo'],"MEDICINE"),2)  );
$this->coconutTableData(  number_format($this->discharged_inventory($row['registrationNo'],"SUPPLIES"),2)  );
$this->coconutTableRowStop();
  }


}




public function printLabRequest($registrationNo,$dateCharge) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT description,timeCharge,remarks,chargeBy,status from patientCharges WHERE registrationNo = '$registrationNo' and departmentStatus = '' and title = 'LABORATORY' and status not like 'DELETED_%%%%%%' and dateCharge = '$dateCharge' ");

echo "<table border=1 cellspacing=0>";
echo "<tr>";
echo "<th>Description</th>";
echo "<th>Time</th>";
echo "<th>Remarks</th>";
echo "<th>N.O.D</th>";
echo "</tr>";
while($row = mysql_fetch_array($result))
  {
echo "<tr>";
if( $row['status'] == "PAID" ) {
echo "<td><b>(Pd)</b>&nbsp;".$row['description']."&nbsp;</tD>";
}else {
echo "<td>&nbsp;".$row['description']."&nbsp;</tD>";
}
echo "<td>&nbsp;".$row['timeCharge']."&nbsp;</tD>";
echo "<td>&nbsp;".$row['remarks']."&nbsp;</tD>";
echo "<td>&nbsp;".$row['chargeBy']."&nbsp;</tD>";
echo "</tr>";
  }
echo "</table>";


}


public $cashCollection_name_laboratory;
public $cashCollection_name_radiology;
public $cashCollection_name_medicine;
public $cashCollection_name_supplies;
public $cashCollection_name_bloodBank;
public $cashCollection_name_nbs;
public $cashCollection_name_misc;
public $cashCollection_name_nursingCare;
public $cashCollection_name_ecg;

public function cashCollection_name_laboratory() {
return $this->cashCollection_name_laboratory;
}
public function cashCollection_name_radiology() {
return $this->cashCollection_name_radiology;
}
public function cashCollection_name_medicine() {
return $this->cashCollection_name_medicine;
}
public function cashCollection_name_supplies() {
return $this->cashCollection_name_supplies;
}
public function cashCollection_name_bloodBank() {
return $this->cashCollection_name_bloodBank;
}
public function cashCollection_name_nbs() {
return $this->cashCollection_name_nbs;
}
public function cashCollection_name_misc() {
return $this->cashCollection_name_misc;
}
public function cashCollection_name_nursingCare() {
return $this->cashCollection_name_nursingCare;
}
public function cashCollection_name_ecg() {
return $this->cashCollection_name_ecg;
}

public function cashCollection_name($month,$day,$year,$month1,$day1,$year1,$type,$control,$username) {

echo "<style type='text/css'>";
echo "tr:hover { background-color:yellow;color:black;}";
echo "</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$discharged = $month."_".$day."_".$year;
$discharged1 = $month1."_".$day1."_".$year1;

if( $control != "All" ) {
$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered FROM patientRecord pr,registrationDetails rd,patientPayment pp WHERE pr.patientNo = rd.patientNo and pp.registrationNo = rd.registrationNo and (rd.dateUnregistered between '$discharged' and '$discharged1') and rd.type='$type' and pp.paidBy = '$username' order by dateUnregistered asc  ");
}else {
$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered FROM patientRecord pr,registrationDetails rd,patientPayment pp WHERE pr.patientNo = rd.patientNo and pp.registrationNo = rd.registrationNo and (rd.dateUnregistered between '$discharged' and '$discharged1') and rd.type='$type' order by dateUnregistered asc  ");
}


while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->discharged_name_medicine += $this->discharged_inventory($row['registrationNo'],"MEDICINE");
$this->discharged_name_supplies += $this->discharged_inventory($row['registrationNo'],"SUPPLIES");

$this->cashCollection_name_laboratory += $this->getTotal("cashUnpaid","LABORATORY",$row['registrationNo']);
$this->cashCollection_name_radiology  += $this->getTotal("cashUnpaid","RADIOLOGY",$row['registrationNo']);
$this->cashCollection_name_medicine +=  $this->getTotal("cashUnpaid","MEDICINE",$row['registrationNo']);
$this->cashCollection_name_supplies +=  $this->getTotal("cashUnpaid","SUPPLIES",$row['registrationNo']);
$this->cashCollection_name_bloodBank +=  $this->getTotal("cashUnpaid","BLOODBANK",$row['registrationNo']);
$this->cashCollection_name_nbs +=  $this->getTotal("cashUnpaid","NBS",$row['registrationNo']);
$this->cashCollection_name_misc +=  $this->getTotal("cashUnpaid","MISCELLANEOUS",$row['registrationNo']);
$this->cashCollection_name_nursingCare +=  $this->getTotal("cashUnpaid","NURSING-CHARGES",$row['registrationNo']);
$this->cashCollection_name_ecg += $this->getTotal("cashUnpaid","ECG",$row['registrationNo']);

$this->coconutTableData($row['dateUnregistered']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/currentPatient/patientInterface1.php?username=&registrationNo=$row[registrationNo]' style='text-decoration:none; color:black;' target='_blank'><font size=2>".$row['lastName'].", ".$row['firstName']."</font></a>");
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","LABORATORY",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","RADIOLOGY",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","MEDICINE",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","SUPPLIES",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","BLOODBANK",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","NBS",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","MISCELLANEOUS",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","NURSING-CHARGES",$row['registrationNo']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","ECG",$row['registrationNo']),2 ));
$this->coconutTableRowStop();
  }


}





public function cashCollection_paid($registrationNo,$title,$datePaid) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(cashPaid) as cashPaid from patientCharges WHERE registrationNo = '$registrationNo' and datePaid = '$datePaid' and title='$title' ");


while($row = mysql_fetch_array($result))
  {
return $row['cashPaid'];
  }

}

public $cashCollection_name1_laboratory;
public $cashCollection_name1_radiology;
public $cashCollection_name1_medicine;
public $cashCollection_name1_supplies;
public $cashCollection_name1_bloodBank;
public $cashCollection_name1_nbs;
public $cashCollection_name1_misc;
public $cashCollection_name1_nursingCare;
public $cashCollection_name1_ecg;

public function cashCollection_name1_laboratory() {
return $this->cashCollection_name1_laboratory;
}
public function cashCollection_name1_radiology() {
return $this->cashCollection_name1_radiology;
}
public function cashCollection_name1_medicine() {
return $this->cashCollection_name1_medicine;
}
public function cashCollection_name1_supplies() {
return $this->cashCollection_name1_supplies;
}
public function cashCollection_name1_bloodBank() {
return $this->cashCollection_name1_bloodBank;
}
public function cashCollection_name1_nbs() {
return $this->cashCollection_name1_nbs;
}
public function cashCollection_name1_misc() {
return $this->cashCollection_name1_misc;
}
public function cashCollection_name1_nursingCare() {
return $this->cashCollection_name1_nursingCare;
}
public function cashCollection_name1_ecg() {
return $this->cashCollection_name1_ecg;
}

public function cashCollection_name1($month,$day,$year,$month1,$day1,$year1,$type,$control,$username) {

echo "<style type='text/css'>";
echo "tr:hover { background-color:yellow;color:black;}";
echo "</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$discharged = $month."_".$day."_".$year;
$discharged1 = $month1."_".$day1."_".$year1;


if( $control != "All" ) {
$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,pc.datePaid FROM patientCharges pc,patientRecord pr,registrationDetails rd WHERE pr.patientNo=rd.patientNo and rd.registrationNo=pc.registrationNo and (pc.datePaid between '$discharged' and '$discharged1') group by rd.registrationNo and pc.paidBy = '$username' order by pc.datePaid asc  ");
}else {
$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,pc.datePaid FROM patientCharges pc,patientRecord pr,registrationDetails rd WHERE pr.patientNo=rd.patientNo and rd.registrationNo=pc.registrationNo and (pc.datePaid between '$discharged' and '$discharged1') group by rd.registrationNo order by pc.datePaid asc  ");
}


while($row = mysql_fetch_array($result))
  {

$this->coconutTableRowStart();

$this->cashCollection_name1_laboratory += $this->cashCollection_paid($row['registrationNo'],"LABORATORY",$row['datePaid']);
$this->cashCollection_name1_radiology  += $this->cashCollection_paid($row['registrationNo'],"RADIOLOGY",$row['datePaid']);
$this->cashCollection_name1_medicine += $this->cashCollection_paid($row['registrationNo'],"MEDICINE",$row['datePaid']);
$this->cashCollection_name1_supplies += $this->cashCollection_paid($row['registrationNo'],"SUPPLIES",$row['datePaid']);
$this->cashCollection_name1_bloodBank += $this->cashCollection_paid($row['registrationNo'],"BLOODBANK",$row['datePaid']);
$this->cashCollection_name1_nbs += $this->cashCollection_paid($row['registrationNo'],"NBS",$row['datePaid']);
$this->cashCollection_name1_misc += $this->cashCollection_paid($row['registrationNo'],"MISCELLANEOUS",$row['datePaid']);
$this->cashCollection_name1_nursingCare += $this->cashCollection_paid($row['registrationNo'],"NURSING-CHARGES",$row['datePaid']);
$this->cashCollection_name1_ecg += $this->cashCollection_paid($row['registrationNo'],"ECG",$row['datePaid']);


$this->coconutTableData($row['datePaid']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/currentPatient/patientInterface1.php?username=&registrationNo=$row[registrationNo]' style='text-decoration:none; color:black;' target='_blank'><font size=2>".$row['lastName'].", ".$row['firstName']."</font></a>");
$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"LABORATORY",$row['datePaid']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"RADIOLOGY",$row['datePaid']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"MEDICINE",$row['datePaid']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"SUPPLIES",$row['datePaid']),2 ));

$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"BLOODBANK",$row['datePaid']),2 ));

$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"NBS",$row['datePaid']),2 ));

$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"MISCELLANEOUS",$row['datePaid']),2 ));

$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"NURSING-CHARGES",$row['datePaid']),2 ));
$this->coconutTableData("&nbsp;".number_format($this->cashCollection_paid($row['registrationNo'],"ECG",$row['datePaid']),2 ));

$this->coconutTableRowStop();
  }


}


public function requestCart($batchNo,$username) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT description,quantity,verificationNo FROM inventoryManager where batchNo='$batchNo' and requestingUser='$username' ");

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/requestition/batchRequest/deleteRequest.php?verificationNo=$row[verificationNo]&batchNo=$batchNo&username=$username'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg' /></a>");
$this->coconutTableRowStop();
  }
$this->coconutTableStop();

}





public function getTransmitted_selected($transmitNo) {
$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



$result = mysql_query("SELECT rd.registrationNo,rd.PIN,pr.lastName,pr.firstName,pr.age,pr.gender,rd.dateRegistered,rd.dateUnregistered,pt.registrationNo from registrationDetails rd,patientRecord pr,phicTransmit pt where pr.patientNo = rd.patientNo and pt.registrationNo = rd.registrationNo and pt.transmitNo = '$transmitNo' group by pt.registrationNo order by pr.lastName asc ");


while($row = mysql_fetch_array($result))
  {
echo "<tr>";
echo "<td><font size=3>".$row['PIN']."</font></tD>"; // header [ PHIC NUMBER ]
echo "<Td><font size=3>".$row['lastName'].", ".$row['firstName']."</font></td>"; // header [ NAME/RELATIONSHIP ] 
echo "<td><font size=3>".$row['dateRegistered']." - ".$row['dateUnregistered']."</font></tD>"; // header [ Confinement Period ]
if( $this->getPatientICD_diagnosis_transmittal_check($row['registrationNo']) > 0 ) {
$this->getPatientICD_diagnosis_transmittal($row['registrationNo']); // header [ ICD - FINAL DIAGNOSIS ] 
}else {
echo "<td>&nbsp;</td>";
}
echo "</tr>";  
}

}




public function availableForDiscount($registrationNo) {

echo "<style type='text/css'>
tr:hover { background-color:yellow; color:black; }
.data{
font-size:14px;
}
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT itemNo,description,sellingPrice FROM patientCharges WHERE registrationNo = '$registrationNo' and (title = 'LABORATORY' or title = 'MEDICINE' or title = 'RADIOLOGY' or title = 'ECG') and status = 'UNPAID' ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Price");
$this->coconutTableRowStop();
$this->coconutFormStart("get","http://".$this->getMyUrl()."/COCONUT/patientProfile/discount/discount1.php");
$this->coconutHidden("registrationNo",$registrationNo);
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<input type=checkbox name='itemNo[]' value='$row[itemNo]'>");
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['sellingPrice']);
$this->coconutTableRowStop();
  }
$this->coconutButton("Proceed");
$this->coconutFormStop();
$this->coconutTableStop();
}




public function getPatient_in_the_room($room) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.dateRegistered from patientRecord pr,registrationDetails rd WHERE rd.room = '$room' and rd.dateUnregistered = '' and pr.patientNo = rd.patientNo ");


while($row = mysql_fetch_array($result))
  {
return "&nbsp;<font size=1 color=black>".$row['lastName'].", ".$row['firstName']." </font>";
  }

}

public $listRoom_total;

public function listRoom_total() {
return $this->listRoom_total;
}

public function listRoom($floor) {

echo "<style type='text/css'>
tr:hover { background-color:yellow; color:black; }
.data{
font-size:14px;
}
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT * FROM room WHERE floor = '$floor' order by Description asc ");
/*
echo "<center>";
echo "<table border=1 cellspacing=0 rules=all width='15%'>";
echo "<tr>";
echo "<th><b>Beds</b></th>";
echo "</tr>";
*/
while($row = mysql_fetch_array($result))
  {
$descz = preg_split ("/_/", $row['Description']); 
echo "<tr>";

if( $row['status'] == "Occupied" ) {
echo "<td>&nbsp;<font size=1 color=red>".$descz[0]."</font><br>
".$this->getPatient_in_the_room($row['Description'])."
</td>";
$this->listRoom_total++;
}else {
echo "<td>&nbsp;<font size=1 color=blue>".$descz[0]."</font></tD>";
}

/*
if( $row['status'] == "Vacant" ) {
$this->coconutTableData("&nbsp;<font color=green size=1>".$row['status']."</font>");
}else {
$this->coconutTableData("&nbsp;<font color=red size=1>".$row['status']."</font>");
}
*/
//$this->coconutTableData("&nbsp;".$this->getPatient_in_the_room($row['Description'])."");
echo "</tr>";
  }
/*
echo "<Tr>";
echo "<td>&nbsp;<font size=2><b>".$this->listRoom_total." Patients</b></font></tD>";
echo "</tr>";
$this->coconutTableStop();
*/
}






public $dispensedMonitor_qty;

public function dispensedMonitor_qty() {
return $this->dispensedMonitor_qty;
}

public function dispensedMonitor($chargesCode,$month,$day,$year,$month1,$day1,$year1) {

echo "<style type='text/css'>
tr:hover { background-color:yellow; color:black; }
.data{
font-size:14px;
}
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$date = $year."-".$month."-".$day;
$date1 = $year1."-".$month1."-".$day1;

$result = mysql_query("SELECT pr.lastName,pr.firstName,pc.quantity,pc.departmentStatus_time,rd.registrationNo,pc.dispensedNo FROM patientCharges pc,registrationDetails rd,patientRecord pr WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (pc.dateCharge between '$date' and '$date1')  and pc.chargesCode = '$chargesCode' and pc.departmentStatus like 'dispensedBy_%%%%%%' ");

echo "<Br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Dispensed");
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Batch#");
$this->coconutTableHeader("Attending");
echo "</tr>";
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->dispensedMonitor_qty += $row['quantity'];
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("&nbsp;".$row['departmentStatus_time']);
$this->coconutTableData("&nbsp;".$row['registrationNo']);
$this->coconutTableData("&nbsp;".$row['dispensedNo']);
$this->coconutTableData("&nbsp;".$this->getAttendingDoc($row['registrationNo'],"Attending"));
$this->coconutTableRowStop();
  }
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<b>TOTAL</b>");
$this->coconutTableData("&nbsp;".$this->dispensedMonitor_qty);
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();
}






public $showExpenses_total;

public function showExpenses_total() {
return $this->showExpenses_total;
}

public function showExpenses($month,$day,$year,$username) {

echo "<style type='text/css'>
tr:hover { background-color:yellow; color:black; }
.data{
font-size:14px;
}
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$date = $year."-".$month."-".$day;

if( $this->selectNow("registeredUser","module","username",$username) == "ADMIN" ) {
$result = mysql_query("SELECT amount,payee,date,user,description FROM vouchers WHERE date = '$date' ");
}else {
$result = mysql_query("SELECT amount,payee,date,user,description FROM vouchers WHERE date = '$date' and user = '$username' ");
}

while($row = mysql_fetch_array($result))
  {
echo "<tr>";
$this->showExpenses_total += $row['amount'];
echo "<td>&nbsp; ".$row['payee']." </td>";
echo "<td>&nbsp; ".$row['description']."</td>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "<td>&nbsp; ".$row['user']."</td>";
echo "<td>&nbsp; ".number_format($row['amount'],2)."</td>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "</tr>";
  }
echo "<Tr>";
echo "<td><center><b>Total</b></center></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<b>".number_format($this->showExpenses_total)."</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

}









public function getPatient_OR($registrationNo) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT orNO,description,quantity,cashPaid,paidBy,datePaid FROM patientCharges WHERE registrationNo='$registrationNo' and orNO != '' and status = 'PAID' ");

echo "<br><Center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("OR#");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Paid");
$this->coconutTableHeader("Date Paid");
$this->coconutTableHeader("paidBy");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['orNO']);
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("&nbsp;".$row['cashPaid']);
$this->coconutTableData("&nbsp;".$row['datePaid']);
$this->coconutTableData("&nbsp;".$row['paidBy']);
$this->coconutTableRowStop();
  }
$this->coconutTableStop();

}






///////////  CUTOFF REPORT   //////////////////////////////



public $partial_cutoff;
public $getPartialReport_hb_cutoff;
public $getPartialReport_pf_cutoff;
public $getPartialReport_admitting_cutoff;

public function partial_cutoff() {
return $this->partial_cutoff;
}
public function getPartialReport_hb_cutoff() {
return $this->getPartialReport_hb_cutoff;
}
public function getPartialReport_pf_cutoff() {
return $this->getPartialReport_pf_cutoff;
}
public function getPartialReport_admitting_cutoff() {
return $this->getPartialReport_admitting_cutoff;
}

public function getPartialReport_cutoff($month,$day,$year,$fromTime_hour,$fromTime_minutes,$fromTime_seconds,$toTime_hour,$toTime_minutes,$toTime_seconds,$username,$status) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$dateSelected = $month."_".$day."_".$year;
$fromTimez = $fromTime_hour.":".$fromTime_minutes.":".$fromTime_seconds;
$toTimez = $toTime_hour.":".$toTime_minutes.":".$toTime_seconds;


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

if( $this->selectNow("registeredUser","module","username",$username) == "ADMIN" ) {
$result = mysql_query("SELECT rd.registrationNo,pp.paidVia,upper(pr.completeName) as completeName,pp.paymentFor,pp.paidBy,pp.datePaid,pp.amountPaid,pp.pf,pp.admitting FROM patientPayment pp,patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and pp.registrationNo = rd.registrationNo and rd.registrationNo = pc.registrationNo and pp.datePaid = '$dateSelected' and (pp.timePaid between '$fromTimez' and '$toTimez') and paymentFor in ('CUT-OFF HOSPITAL BILL') group by paymentNo order by completeName asc ");
}else {
$result = mysql_query("SELECT rd.registrationNo,pp.paidVia,upper(pr.completeName) as completeName,pp.paymentFor,pp.paidBy,pp.datePaid,pp.amountPaid,pp.pf,pp.admitting FROM patientPayment pp,patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and pp.registrationNo = rd.registrationNo and rd.registrationNo = pc.registrationNo and pp.datePaid = '$dateSelected' and (pp.timePaid between '$fromTimez' and '$toTimez') and paymentFor in ('CUT-OFF HOSPITAL BILL') and pp.paidBy='$username' group by paymentNo order by completeName asc ");
}

//$this->collection_salesTotal=0;
//$this->collection_salesUnpaid=0;
//$this->collection_salesPaid=0;
while($row = mysql_fetch_array($result))
  {
$this->partial_cutoff +=$row['amountPaid'];
$this->getPartialReport_hb_cutoff += $row['amountPaid'];
$this->getPartialReport_pf_cutoff += $row['pf'];
$this->getPartialReport_admitting_cutoff += $row['admitting'];
//$price = preg_split ("/\//", $row['sellingPrice']); 


echo "<tr>";
echo "<td>&nbsp;<font color=red>".$row['completeName']."</font>&nbsp;</td>";
echo "<td>&nbsp;".$row['paymentFor']."&nbsp;</td>";
echo "<td>&nbsp;".number_format(($row['amountPaid'] + $row['pf']) + $row['admitting'],2)."&nbsp;</td>";
//echo "<td>&nbsp;".number_format("1",2)."&nbsp;</td>";// header [QTY]
//echo "<td>&nbsp;".number_format("0",2)."&nbsp;</td>";// header [DISC]
echo "<td>&nbsp;".number_format(($row['amountPaid'] + $row['pf']) + $row['admitting'],2)."&nbsp;</td>";
//echo "<td>&nbsp;".number_format("0",2)."&nbsp;</td>"; //header [Balance]
echo "<td>&nbsp;".(($row['amountPaid']+$row['pf'])+$row['admitting'])." - (".$row['paidVia'].")&nbsp;</td>";
echo "<td>&nbsp;".$row['paidBy']."&nbsp;</td>";
echo "<tD>&nbsp;".number_format($row['amountPaid'],2)."&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($row['pf'],2)."&nbsp;</tD>";
echo "<tD>&nbsp;".$this->getAttendingDoc($row['registrationNo'],"Attending")."&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($row['admitting'],2)."&nbsp;</tD>";
//$this->collection_salesTotal+=$row['total'];
//$this->collection_salesUnpaid+=$row['cashUnpaid'];
//$this->collection_salesPaid+=$row['cashPaid'];
/*
if($row['paidVia'] == "Cash") {
$this->collection_cash += $row['cashPaid'];
}else {
$this->collection_creditCard += $row['cashPaid'];
}
*/
echo "</tr>";
  }


					
}




//////////  CUTOFF REPORT   //////////////////////////////







//check kung mei laboratory result n?
public function checkIfTitleExist($registrationNo,$title) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT title from patientCharges where registrationNo = '$registrationNo' and title = '$title'  ");

while($row = mysql_fetch_array($result))
  {
return mysql_num_rows($result);
  }

}






public function checkBalance($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT sum(cashUnpaid) as balance FROM patientCharges where registrationNo = '$registrationNo' ");



while($row = mysql_fetch_array($result))
  {
return $row['balance'];
  }

mysql_close($con);


}





public function addCashCollection($title,$amount,$date) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO cashCollection (title,amount,date,control_date)
VALUES
('$title','$amount','$date','".date("Y-m-d")."')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }

//echo "<script type='text/javascript' >";
//echo  "window.location='http://".$this->getMyUrl()."/Maintenance/addUser.php?username=$addedBy '";
//echo "</script>";

mysql_close($con);

}




public function cashCollectionDetails($month,$day,$year) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$date = $month."_".$day."_".$year;
$result = mysql_query("SELECT title,amount,collectionNo FROM cashCollection where date = '$date' order by title asc ");


$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Title");
$this->coconutTableHeader("Amount");
$this->coconutTableHeader("&nbsp;");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['title']);
$this->coconutTableData($row['amount']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/Cashier/cashCollection/cashCollectionDetails_delete.php?collectionNo=$row[collectionNo]&month=$month&day=$day&year=$year'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg' /></a>");
$this->coconutTableRowStop();
  }
$this->coconutTableStop();

mysql_close($con);


}


public $hmo_meds_qty;
public $hmo_meds_actualCharges;
public $hmo_meds_cover;

public function hmo_meds_qty() {
return $this->hmo_meds_qty;
}
public function hmo_meds_actualCharges() {
return $this->hmo_meds_actualCharges;
}
public function hmo_meds_cover() {
return $this->hmo_meds_cover;
}




public function hmo_meds_group($registrationNo,$chargesCode) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(pc.quantity) as qty,sum(pc.total) as total,sum(pc.company) as totalCover from patientCharges pc WHERE pc.registrationNo='$registrationNo' and pc.chargesCode = '$chargesCode' and pc.title = 'MEDICINE' and pc. status = 'UNPAID'   "); 

while($row = mysql_fetch_array($result))
  {
$this->hmo_meds_qty = $row['qty'];
$this->hmo_meds_actualCharges = $row['total'];
$this->hmo_meds_cover = $row['totalCover'];
  }


}




/*********HMO OTHERS********************/

public $hmo_others_qty;
public $hmo_others_actualCharges;
public $hmo_others_cover;

public function hmo_others_qty() {
return $this->hmo_others_qty;
}
public function hmo_others_actualCharges() {
return $this->hmo_others_actualCharges;
}
public function hmo_others_cover() {
return $this->hmo_others_cover;
}




public function hmo_others_group($registrationNo,$chargesCode) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(pc.quantity) as qty,sum(pc.total) as total,sum(pc.company) as totalCover from patientCharges pc WHERE pc.registrationNo='$registrationNo' and pc.chargesCode = '$chargesCode' and pc.title IN ('LABORATORY','RADIOLOGY','SUPPLIES') and pc. status = 'UNPAID'   "); 

while($row = mysql_fetch_array($result))
  {
$this->hmo_others_qty = $row['qty'];
$this->hmo_others_actualCharges = $row['total'];
$this->hmo_others_cover = $row['totalCover'];
  }


}

/*********HMO OTHERS*******************/



public $hmo_meds_total;
public $hmo_meds_excess;

public function hmo_meds_total() {
return $this->hmo_meds_total;
}




public function hmo_meds($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}


.editable{
	border: 1px solid #000;
	color: #000;
	height: 25px;
	width: 80px;
	border-color:white white white white;
	font-size:16px;
	text-align:center;
}


</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT company,phic,hmoPrice,description,chargesCode,sellingPrice FROM patientCharges where registrationNo = '$registrationNo' and title = 'MEDICINE' and status = 'UNPAID' and hmoPrice > 0 group by description order by description asc ");



while($row = mysql_fetch_array($result))
  {
$this->hmo_meds_group($registrationNo,$row['chargesCode']);
$this->hmo_meds_total += ( $row['hmoPrice'] * $this->hmo_meds_qty() );
echo "<tr>";
echo "<td>&nbsp;".$row['description']."</td>";
echo "<td>&nbsp;<input type='text' class='editable' value='".$this->hmo_meds_qty()."'>&nbsp;</tD>";
echo "<td>&nbsp;<input type='text' class='editable' value='".$row['hmoPrice']."'>&nbsp;</tD>";
echo "<td>&nbsp;<input type='text' class='editable' value='".number_format( ( $row['hmoPrice'] * $this->hmo_meds_qty() ) ,2)."'></tD>";
echo "<td>&nbsp;&nbsp;</tD>";
echo "<td>&nbsp;&nbsp;</tD>";
echo "</tr>";
  }


mysql_close($con);


}


public $hmo_others_total;

public function hmo_others_total() {
return $this->hmo_others_total;
}

public function hmo_others($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT hmoPrice,description,chargesCode,sellingPrice FROM patientCharges where registrationNo = '$registrationNo' and title IN ('LABORATORY','RADIOLOGY','SUPPLIES') and status ='UNPAID' and hmoPrice > 0 group by description order by description asc ");



while($row = mysql_fetch_array($result))
  {
$this->hmo_others_group($registrationNo,$row['chargesCode']);
$this->hmo_others_total += ( $row['hmoPrice'] * $this->hmo_others_qty() );
echo "<tr>";
echo "<td>&nbsp;".$row['description']."</td>";
echo "<td>&nbsp;".$this->hmo_others_qty()."&nbsp;</tD>";
echo "<td>&nbsp;".$row['hmoPrice']."&nbsp;</tD>";
echo "<td>&nbsp;&nbsp;".number_format( ( $row['hmoPrice'] * $this->hmo_others_qty() ) ,2)."</tD>";
echo "<td>&nbsp;&nbsp;</tD>";
echo "<td>&nbsp;&nbsp;</tD>";
echo "</tr>";
  }


mysql_close($con);


}










/**********************TRANSMITAL RECONCILE*******************************/




public function getTransmitted_reconcile($dateDischarged,$dateDischarged1,$package,$type,$switch) {

echo "<style type='text/css'>";

echo "

.member{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 130px;
	border-color:white white white white;
	font-size:13px;

}

";

echo "</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


if( $type == "All"  ) {
$result = mysql_query("SELECT pr.religion,rd.registrationNo,rd.PIN,UPPER(pr.lastName) as lastName,UPPER(pr.firstName) as firstName,pr.age,pr.gender,rd.dateRegistered,rd.dateUnregistered,pt.transmitNo from registrationDetails rd,patientRecord pr,phicTransmit pt where pr.patientNo = rd.patientNo and (rd.dateUnregistered between '$dateDischarged' and '$dateDischarged1') and pr.PHIC = 'YES' and pt.reconciled != 'yes' and pt.registrationNo = rd.registrationNo group by pt.registrationNo order by pr.lastName asc ");
}else {
$result = mysql_query("SELECT pr.religion,rd.registrationNo,rd.PIN,pr.lastName,pr.firstName,pr.age,pr.gender,rd.dateRegistered,rd.dateUnregistered,pt.transmitNo from registrationDetails rd,patientRecord pr,phicTransmit pt where pr.patientNo = rd.patientNo and (rd.dateUnregistered between '$dateDischarged' and '$dateDischarged1') and pr.phicType like '$type%' and pt.reconciled != 'yes' and pt.registrationNo = rd.registrationNo group by pt.registrationNo order by pr.lastName asc ");
}

$this->coconutFormStart("get","reconcile.php");

echo "<br>";
echo "<center>";
echo "Date Reconcile&nbsp;";
$this->coconutComboBoxStart_short("month");
echo "<option value='".date("m")."'>".date("M")."</option>";
echo "<option value='01'>Jan</option>";
echo "<option value='02'>Feb</option>";
echo "<option value='03'>Mar</option>";
echo "<option value='04'>Apr</option>";
echo "<option value='05'>May</option>";
echo "<option value='06'>Jun</option>";
echo "<option value='07'>Jul</option>";
echo "<option value='08'>Aug</option>";
echo "<option value='09'>Sep</option>";
echo "<option value='10'>Oct</option>";
echo "<option value='11'>Nov</option>";
echo "<option value='12'>Dec</option>";
$this->coconutComboBoxStop();
echo "-";
$this->coconutComboBoxStart_short("day");

for( $x=1;$x<32;$x++ ) {
echo "<option value='".date("d")."'>".date("d")."</option>";
if( $x < 10 ) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}

}
$this->coconutComboBoxStop();

echo "-";

$this->coconutTextBox_short("year",date("Y"));
echo "<center>";


echo "<br>";
echo "<center>";
echo "Checked No.";
$this->coconutTextBox("checkedNo","");
echo "</centeR>";
echo "<br>";

while($row = mysql_fetch_array($result))
  {
echo "<tr>";
echo "<td><font size=3>".$row['PIN']."</font></tD>"; // header [ PHIC NUMBER ]
echo "<Td><font size=3>".$row['lastName'].", ".$row['firstName']."</font></td>"; // header [ NAME/RELATIONSHIP ] 
echo "<td><input type='checkbox' name='registrationNo[]' value='$row[registrationNo]'></tD>";
echo "</tr>";
}
echo "<center>";
$this->coconutButton("Reconcile");
echo "</center>";
$this->coconutFormStop();


}


/**********************TRANSMITAL RECONCILE*******************************/




public function getReconciled($month,$day,$year) { 

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$date = $year."-".$month."-".$day;
$result = mysql_query("SELECT pt.checkedNo,rd.registrationNo,pr.lastName,pr.firstName,pr.middleName from patientRecord pr,registrationDetails rd,phicTransmit pt where pr.patientNo = rd.patientNo and rd.registrationNo = pt.registrationNo and pt.date = '$date' order by pr.lastName asc ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Checked#");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['registrationNo']);
$this->coconutTableData($row['lastName'].", ".$row['firstName']);
$this->coconutTableData($row['checkedNo']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/SOAoption/summary.php?registrationNo=$row[registrationNo]' target='_blank'><font size=2 color=red>View S.O.A</font></a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();


}




public function addVoucher_acct($voucherNo,$checkedNo,$paymentMode,$description,$amount,$payee,$date,$time,$accountTitle,$user) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO vouchers (voucherNo,checkedNo,paymentMode,description,amount,payee,date,time,accountTitle,user)
VALUES
('".mysql_real_escape_string($voucherNo)."','".mysql_real_escape_string($checkedNo)."','".mysql_real_escape_string($paymentMode)."','".mysql_real_escape_string($description)."','".mysql_real_escape_string($amount)."','".mysql_real_escape_string($payee)."','".mysql_real_escape_string($date)."','".mysql_real_escape_string($time)."','".mysql_real_escape_string($accountTitle)."','".mysql_real_escape_string($user)."')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }

echo "<script type='text/javascript' >";
echo "alert('Voucher Added');";
echo  "window.location='http://".$this->getMyUrl()."/COCONUT/accounting/voucher/addVoucher_acct.php?username=$user'";
echo "</script>";

mysql_close($con);

}






/************NUMBER TO WORDS****************************/


public function convert_number_to_words($number) {
   
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Qintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
}


/************NUMBER TO WORDS*****************************/








public function listVoucher($checkedNo) { 

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

if( $checkedNo == "" ) {
$result = mysql_query("SELECT controlNo,checkedNo,date,payee from vouchers limit 0,0 ");
}else if( $checkedNo == "all" ) {
$result = mysql_query("SELECT controlNo,checkedNo,date,payee from vouchers order by checkedNo asc ");
}else {
$result = mysql_query("SELECT controlNo,checkedNo,date,payee from vouchers WHERE checkedNo like '$checkedNo%%%%%' order by checkedNo asc ");
}

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Check No#");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Payee");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/accounting/voucher/printableVoucher.php?checkedNo=$row[checkedNo]' target='_blank'>".$row['checkedNo']."</a>");
$this->coconutTableData($row['payee']);
$this->coconutTableData($row['date']);
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/accounting/voucher/editVoucher.php?controlNo=$row[controlNo]'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/pencil.jpeg'></a> ");
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/accounting/voucher/deleteVoucher.php?controlNo=$row[controlNo]'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a> ");
$this->coconutTableRowStop();
}
$this->coconutTableStop();


}











public function phic_reconcillation_acct($month,$day,$year,$month1,$day1,$year1,$type) { 

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$date = $month."_".$day."_".$year;
$date1 = $month1."_".$day1."_".$year1;

if( $type == "All" ) {
$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered FROM registrationDetails rd,patientCharges pc,patientRecord pr WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (rd.dateUnregistered between '$date' and '$date1') group by rd.registrationNo order by pr.lastName asc ");
}else {
$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered FROM registrationDetails rd,patientCharges pc,patientRecord pr WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (rd.dateUnregistered between '$date' and '$date1') and rd.type = '$type' group by rd.registrationNo order by pr.lastName asc ");
}

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Discharged");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Amount");
$this->coconutTableHeader("Ref#");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Remarks");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['dateUnregistered']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/philhealth/reconciled/reconcileDetails.php?registrationNo=$row[registrationNo]' target='_blank'>".$row['lastName'].", ".$row['firstName']."</a>");
echo "<Td>&nbsp;".$this->selectNow("phicReconcile","amount","registrationNo",$row['registrationNo'])."</tD>";
echo "<Td>&nbsp;".$this->selectNow("phicReconcile","refno","registrationNo",$row['registrationNo'])."</tD>";
echo "<Td>&nbsp;".$this->selectNow("phicReconcile","date","registrationNo",$row['registrationNo'])."</tD>";
echo "<Td>&nbsp;".$this->selectNow("phicReconcile","remarks","registrationNo",$row['registrationNo'])."</tD>";
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/philhealth/reconciled/reconcileDetails_edit.php?reconcileNo=".$this->selectNow("phicReconcile","reconcileNo","registrationNo",$row['registrationNo'])."&registrationNo=$row[registrationNo]' target='_blank'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/pencil.jpeg'></a> ");
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/philhealth/reconciled/reconcileDetails_delete.php?reconcileNo=".$this->selectNow("phicReconcile","reconcileNo","registrationNo",$row['registrationNo'])."&registrationNo=$row[registrationNo]' target='_blank'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a> ");
$this->coconutTableRowStop();
}
$this->coconutTableStop();


}








public function phicReconcile($registrationNo,$refno,$amount,$remarks,$date) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO phicReconcile (registrationNo,refno,amount,remarks,date)
VALUES
('$registrationNo','$refno','$amount','$remarks','$date')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


/*
echo "<script type='text/javascript' >";
echo  "window.location='http://".$this->getMyUrl()."/COCONUT/patientProfile/patientProfile_handler.php?username=$paidBy&registrationNo=$registrationNo '";
echo "</script>";
*/
mysql_close($con);

}




public function monthlyCashCollection($title,$date,$date1) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(amount) as amountCols FROM cashCollection WHERE title = '$title' and ( date between '$date' and '$date1' ) ");

while($row = mysql_fetch_array($result))
  {
return $row['amountCols'];
  }

}



public $monthlySalesReport_laboratoryz;
public $monthlySalesReport_radiology;
public $monthlySalesReport_ecg;
public $monthlySalesReport_medicine;
public $monthlySalesReport_supplies;
public $monthlySalesReport_miscellaneous;
public $monthlySalesReport_room;
public $monthlySalesReport_nbs;
public $monthlySalesReport_cardiology;
public $monthlySalesReport_bloodBank;
public $monthlySalesReport_dialysis;
public $monthlySalesReport_oxygen;
public $monthlySalesReport_rFee;
public $monthlySalesReport_totalPerPx;
public $monthlySalesreport_totalAllPx;

public function monthlySalesReport($month,$day,$year,$month1,$day1,$year1,$type,$paidVia) {


echo "

<script type='text/javascript' src='http://".$this->getMyUrl()."/jquery.js'></script>
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$date = $year."-".$month."-".$day;
$date1 = $year1."-".$month1."-".$day;

$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered FROM patientRecord pr,registrationDetails rd WHERE pr.patientNo = rd.patientNo and (dateUnregistered between '$date' and '$date1') and rd.type='$type' order by rd.dateUnregistered,pr.lastName asc ");

?>

<script type="text/javascript">
$(function(){	   


	$("#exportToExcel").click(function() {									   
		var data='<table>'+$("#ReportTable").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='/export-to-excel/exporttoexcel.php' style='display:none' id='ReportTableData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#ReportTableData').submit().remove();
		 return false;
	});

});
</script>
<a href="#" id="exportToExcel">Export</a>
<?
//echo "<a href='#' id='exportToExcel'>Export to Excel</a>";
echo "<Table border=1 cellpadding=0 rules=all cellspacing=0 id='ReportTable' >";
$this->coconutTableRowStart();
echo "<th>Discharged</th>";
echo "<th>Patient</th>";
echo "<th>Laboratory</th>";
echo "<th>Radiology</th>";
echo "<th>ECG</th>";
echo "<th>Medicine</th>";
echo "<th>Supplies</th>";
echo "<th>Miscellaneous</th>";
echo "<th>Room</th>";
echo "<th>NBS</th>";
echo "<th>CARDIO</th>";
echo "<th>BloodBank</th>";
echo "<th>Dialysis</th>";
echo "<th>Oxygen</th>";
echo "<th>OR/DR/ER Fee</th>";
echo "<th>TOTAL</th>";
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {

$this->getMonthlySalesReport_laboratoryz += $this->getTotal($paidVia,"LABORATORY",$row['registrationNo']);
$this->getMonthlySalesReport_radiology += $this->getTotal($paidVia,"RADIOLOGY",$row['registrationNo']);
$this->getMonthlySalesReport_ecg += $this->getTotal($paidVia,"ECG",$row['registrationNo']);
$this->getMonthlySalesReport_medicine += $this->getTotal($paidVia,"MEDICINE",$row['registrationNo']);
$this->getMonthlySalesReport_supplies += $this->getTotal($paidVia,"SUPPLIES",$row['registrationNo']);
$this->getMonthlySalesReport_miscellaneous += $this->getTotal($paidVia,"MISCELLANEOUS",$row['registrationNo']);
$this->getMonthlySalesReport_room += $this->getTotal($paidVia,"Room And Board",$row['registrationNo']);
$this->getMonthlySalesReport_nbs += $this->getTotal($paidVia,"NBS",$row['registrationNo']);
$this->getMonthlySalesReport_cardiology += $this->getTotal($paidVia,"CARDIOLOGY",$row['registrationNo']);
$this->getMonthlySalesReport_bloodBank += $this->getTotal($paidVia,"BLOODBANK",$row['registrationNo']);
$this->getMonthlySalesReport_dialysis += $this->getTotal($paidVia,"DIALYSIS",$row['registrationNo']);
$this->getMonthlySalesReport_oxygen += $this->getTotal($paidVia,"OXYGEN",$row['registrationNo']);
$this->getMonthlySalesReport_rFee += $this->getTotal($paidVia,"OR/DR/ER Fee",$row['registrationNo']);


$this->getMonthlySalesReport_totalPerPx = ( 

$this->getMonthlySalesReport_laboratoryz +
$this->getMonthlySalesReport_radiology +
$this->getMonthlySalesReport_ecg +
$this->getMonthlySalesReport_medicine +
$this->getMonthlySalesReport_supplies +
$this->getMonthlySalesReport_miscellaneous +
$this->getMonthlySalesReport_room +
$this->getMonthlySalesReport_nbs +
$this->getMonthlySalesReport_cardiology +
$this->getMonthlySalesReport_bloodBank +
$this->getMonthlySalesReport_dialysis +
$this->getMonthlySalesReport_oxygen +
$this->getMonthlySalesReport_rFee 

  );


$this->getMonthlySalesReport_totalAllPx += ( 

$this->getTotal($paidVia,"LABORATORY",$row['registrationNo']) +
$this->getTotal($paidVia,"RADIOLOGY",$row['registrationNo']) +
$this->getTotal($paidVia,"ECG",$row['registrationNo']) +
$this->getTotal($paidVia,"MEDICINE",$row['registrationNo']) +
$this->getTotal($paidVia,"SUPPLIES",$row['registrationNo']) +
$this->getTotal($paidVia,"MISCELLANEOUS",$row['registrationNo']) + 
$this->getTotal($paidVia,"Room And Board",$row['registrationNo']) +
$this->getTotal($paidVia,"NBS",$row['registrationNo']) +
$this->getTotal($paidVia,"CARDIOLOGY",$row['registrationNo']) +
$this->getTotal($paidVia,"BLOODBANK",$row['registrationNo']) +
$this->getTotal($paidVia,"DIALYSIS",$row['registrationNo']) +
$this->getTotal($paidVia,"OXYGEN",$row['registrationNo']) +
$this->getTotal($paidVia,"OR/DR/ER Fee",$row['registrationNo']) 
  ) ;


$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateUnregistered']);
$this->coconutTableData($row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"LABORATORY",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"RADIOLOGY",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"ECG",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"MEDICINE",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"SUPPLIES",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"MISCELLANEOUS",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"Room And Board",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"NBS",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"CARDIOLOGY",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"BLOODBANK",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"DIALYSIS",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"OXYGEN",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;".number_format($this->getTotal($paidVia,"OR/DR/ER Fee",$row['registrationNo']),2));
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/SOAoption/summary.php?registrationNo=$row[registrationNo]' target='_blank'>".number_format( ( 

$this->getTotal($paidVia,"LABORATORY",$row['registrationNo']) +
$this->getTotal($paidVia,"RADIOLOGY",$row['registrationNo']) +
$this->getTotal($paidVia,"ECG",$row['registrationNo']) +
$this->getTotal($paidVia,"MEDICINE",$row['registrationNo']) +
$this->getTotal($paidVia,"SUPPLIES",$row['registrationNo']) +
$this->getTotal($paidVia,"MISCELLANEOUS",$row['registrationNo']) + 
$this->getTotal($paidVia,"Room And Board",$row['registrationNo']) +
$this->getTotal($paidVia,"NBS",$row['registrationNo']) +
$this->getTotal($paidVia,"CARDIOLOGY",$row['registrationNo']) +
$this->getTotal($paidVia,"BLOODBANK",$row['registrationNo']) +
$this->getTotal($paidVia,"DIALYSIS",$row['registrationNo']) +
$this->getTotal($paidVia,"OXYGEN",$row['registrationNo']) +
$this->getTotal($paidVia,"OR/DR/ER Fee",$row['registrationNo']) 
  ) ,2)."</a>");
$this->coconutTableRowStop();
  }
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<b>TOTAL</b>");
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_laboratoryz),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_radiology),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_ecg),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_medicine),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_supplies),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_miscellaneous),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_room),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_nbs),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_cardiology),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_bloodBank),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_dialysis),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_oxygen),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_rFee),2);
$this->coconutTableData("&nbsp;".number_format($this->getMonthlySalesReport_totalAllPx,2));
$this->coconutTableRowStop();
$this->coconutTableStop();

}






public $getOPD_title_total;

public function getOPD_title($month,$day,$year,$title,$user) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);
$datez = $year."-".$month."-".$day;


if( $title == "PHARMACY" ) {
$result = mysql_query("SELECT pr.lastName,pr.firstName,pc.description,pc.datePaid,pc.cashPaid FROM patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and rd.type='OPD' and (pc.title = 'MEDICINE' or pc.title = 'SUPPLIES') and pc.datePaid = '$datez' and paidBy = '$user' order by lastName asc  ");
}else {
$result = mysql_query("SELECT pr.lastName,pr.firstName,pc.description,pc.datePaid,pc.cashPaid FROM patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and rd.type='OPD' and pc.title = '$title' and pc.datePaid = '$datez' and paidBy = '$user' order by lastName asc  ");
}

echo "<br><Br><Center>$title";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Paid");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->getOPD_title_total += $row['cashPaid'];
$this->coconutTableRowStart();
$this->coconutTableData($row['lastName'].", ".$row['firstName']);
$this->coconutTableData($row['description']);
$this->coconutTableData(number_format($row['cashPaid'],2));
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("<b>TOTAL</b>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->getOPD_title_total,2));
$this->coconutTableRowStop();
$this->coconutTableStop();

}







public function insertGeneratorLog($dateStart,$timeStart,$dateStop,$timeStop,$status,$user) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO generatorCharge (dateStart,timeStart,dateStop,timeStop,status,user)
VALUES
('$dateStart','$timeStart','$dateStop','$timeStop','$status','$user')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


/*
echo "<script type='text/javascript' >";
echo  "window.location='http://".$this->getMyUrl()."/COCONUT/patientProfile/patientProfile_handler.php?username=$paidBy&registrationNo=$registrationNo '";
echo "</script>";
*/
mysql_close($con);

}



public function insertGeneratorLog_new($dateStart,$timeStart,$dateStop,$timeStop,$status,$user,$hrs) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO generatorCharge (dateStart,timeStart,dateStop,timeStop,status,user,hours)
VALUES
('$dateStart','$timeStart','$dateStop','$timeStop','$status','$user','$hrs')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


/*
echo "<script type='text/javascript' >";
echo  "window.location='http://".$this->getMyUrl()."/COCONUT/patientProfile/patientProfile_handler.php?username=$paidBy&registrationNo=$registrationNo '";
echo "</script>";
*/
mysql_close($con);

}




public $checkGenerator_total;
public function checkGenerator($month,$day,$year,$month1,$day1,$year1,$registrationNo,$username) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);
$date = $year."-".$month."-".$day;
$date1 = $year1."-".$month1."-".$day1;
$result = mysql_query("SELECT * from generatorCharge WHERE (dateStart between '$date' and '$date1' )  ");

echo "<Br><Br><br><Center>";
$this->coconutFormStart("get","http://".$this->getMyUrl()."/COCONUT/systemBiller/generatorCharge/addGeneratorCharges.php");
$this->coconutHidden("registrationNo",$registrationNo);
$this->coconutHidden("username",$username);
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Mins");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->checkGenerator_total += $row['hours'];
$this->coconutTableData("<input type=checkbox name='chargeNo[]' value='$row[chargeNo]' checked>");
$this->coconutTableData($row['dateStart']);
$this->coconutTableData($row['hours']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("");
$this->coconutTableData("<b>TOTAL</b>");
$this->coconutTableData("".$this->checkGenerator_total);
$this->coconutTableRowStop();
$this->coconutTableStop();
echo "<Br>";
$this->coconutButton("Proceed");
$this->coconutFormStop();

}



public function showGeneratorList($month,$day,$year,$username) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);
$date = $year."-".$month."-".$day;
$result = mysql_query("SELECT dateStart,timeStart,chargeNo from generatorCharge WHERE dateStart  = '$date' ");

echo "<Br><Br><br><Center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Time Start");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/systemBiller/generatorCharge/generatorSummary1.php?chargeNo=$row[chargeNo]&username=ricky' style='text-decoration:none; color:red;'>View</a>");
$this->coconutTableData($row['dateStart']);
$this->coconutTableData($row['timeStart']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableRowStop();
$this->coconutTableStop();
echo "<Br>";

}





public function addOrder($description,$sellingPrice,$unitCost,$batchNo,$dateOrder,$username,$qty,$supplier) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO orderForm (description,sellingPrice,unitcost,batchNo,dateOrder,orderBy,qty,supplier)
VALUES
('$description','$sellingPrice','$unitCost','$batchNo','$dateOrder','$username','$qty','$supplier')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


mysql_close($con);

}





//********************* RE-ORDER FORM ****************************//

public function searchReOrder($search,$searchType,$batchNo,$username) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


if( $searchType == "brand" ) {
$result = mysql_query("SELECT description,genericName,unitcost,Added,supplier from inventory WHERE description like '".$search."%%%%%%%%' and inventoryLocation = 'PHARMACY' ");
}else {
$result = mysql_query("SELECT description,genericName,unitcost,Added,supplier from inventory WHERE genericName like '$search%%%%%%%%' and inventoryLocation = 'PHARMACY' ");
}


echo "<Br><Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("<Font size=2>Brand</font>");
$this->coconutTableHeader("<font size=2>Generic</font>");
$this->coconutTableHeader("<font size=2>Unit Cost</font>");
$this->coconutTableHeader("<font size=2>Price</font>");
$this->coconutTableHeader("<font size=2>Supplier</font>");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$sp = preg_split ("/\_/", $row['Added']); 
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/availableMedicine/reOrder/reOrder_qty.php?description=$row[description]&genericName=$row[genericName]&unitcost=$row[unitcost]&sp=$sp[1]&supplier=$row[supplier]&batchNo=$batchNo&username=$username' style='text-decoration:none; color:black;'><font size=2>".$row['description']."</font></a>&nbsp;");
$this->coconutTableData("&nbsp;<font size=2>".$row['genericName']."</font>&nbsp;");
$this->coconutTableData("&nbsp;<font size=2>".$row['unitcost']."</font>&nbsp;");
$this->coconutTableData("&nbsp;<font size=2>".number_format($sp[1],2)."</font>&nbsp;");
$this->coconutTableData("&nbsp;<font size=2>".$row['supplier']."</font>&nbsp;");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
echo "<Br>";

}


public function reOrderNo() {
$myFile = $this->getReportInformation("homeRoot")."/COCONUT/trackingNo/reOrder.dat";
$fh = fopen($myFile, 'r');
$theData = fread($fh, 1000);
fclose($fh);

    

$myFile = $this->getReportInformation("homeRoot")."/COCONUT/trackingNo/reOrder.dat";
$fh = fopen($myFile, 'w') or die("can't open file"); 
fwrite($fh, $theData+1);
fclose($fh);
}




public function showOrderForm($batchNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



$result = mysql_query("SELECT batchNo,orderNo,description,unitcost,supplier,qty FROM orderForm WHERE batchNo = '$batchNo' ");



echo "<Br><Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("<Font size=2>Particulars</font>");
$this->coconutTableHeader("<font size=2>QTY</font>");
$this->coconutTableHeader("<font size=2>Unit Cost</font>");
$this->coconutTableHeader("<font size=2>Supplier</font>");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/availableMedicine/reOrder/delete.php?orderNo=$row[orderNo]&batchNo=$row[batchNo]' style='text-decoration:none; color:black;'>".$row['description']."</a>");
$this->coconutTableData("&nbsp;".$row['qty']);
$this->coconutTableData("&nbsp;".$row['unitcost']);
$this->coconutTableData("&nbsp;".$row['supplier']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();


}





//************************* END OF RE-ORDER FORM ***************************//



//**************** RADIO RESULT ****************************//

public function listRadioResult($m,$d,$y) {

echo "<style type='text/css'>

a {
text-decoration:none;
}

</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$datez = $y."-".$m."-".$d;

$result = mysql_query("SELECT rsr.refer,rsr.radioSavedNo,pr.lastName,pr.firstName,pc.description,rsr.time,rsr.itemNo,rsr.registrationNo from patientRecord pr,registrationDetails rd,patientCharges pc,radioSavedReport rsr where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and pc.itemNo = rsr.itemNo and rsr.approvedDate = '$datez' and rsr.approved = 'yes'  ");

while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();

if( $row['refer'] != "" ) {
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/testDone/referredUser_radio.php?radioSavedNo=$row[radioSavedNo]'><font size=2 color=blue>".$row['lastName'].", ".$row['firstName']."</font></a><br><font size=1 color=red>(Referred)</font>");
}else {
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/testDone/referredUser_radio.php?radioSavedNo=$row[radioSavedNo]'><font size=2 color=blue>".$row['lastName'].", ".$row['firstName']."</font></a>");
}
$this->coconutTableData("&nbsp;<font size=2 color=black>".$row['description']."</font>");
$this->coconutTableData("&nbsp;<font size=2 color=black>".$row['time']."</font>");
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&description=$row[description]' target='_blank'><font size=2 color=red>View</font></a>");
$this->coconutTableRowStop();
  }

}





public function searchRadioResult($m,$d,$y,$name) {

echo "<style type='text/css'>

a {
text-decoration:none;
}

</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$datez = $m."_".$d."_".$y;

$result = mysql_query("SELECT pr.lastName,pr.firstName,pc.description,rsr.time,rsr.itemNo,rsr.registrationNo from patientRecord pr,registrationDetails rd,patientCharges pc,radioSavedReport rsr where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and pc.itemNo = rsr.itemNo and rsr.date = '$datez' and pr.lastName like '".mysql_real_escape_string($name)."%%%%%%%%'  ");

while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<font size=2 color=blue>".$row['lastName'].", ".$row['firstName']."</font>");
$this->coconutTableData("&nbsp;<font size=2 color=black>".$row['description']."</font>");
$this->coconutTableData("&nbsp;<font size=2 color=black>".$row['time']."</font>");
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&description=$row[description]' target='_blank'><font size=2 color=red>View</font></a>");
$this->coconutTableRowStop();
  }

}



/***************** END OF RADIO RESULT *********************///




public function radioResult_onPatient($registrationNo,$username) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



$result = mysql_query("SELECT rsr.radioSavedNo,rsr.date,pc.description,rsr.itemNo FROM radioSavedReport rsr,patientCharges pc WHERE pc.registrationNo = '$registrationNo' and pc.registrationNo = rsr.registrationNo and pc.itemNo = rsr.itemNo order by pc.description asc ");



while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$registrationNo&description=$row[description]' target='_blank' style='text-decoration:none; color:black;'>".$row['radioSavedNo']."</a>");
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$registrationNo&description=$row[description]' target='_blank' style='text-decoration:none; color:black;'>".$row['description']."</a>");
$this->coconutTableData("&nbsp;".$row['date']);

if( $this->selectNow("registeredUser","module","username",$username) == "RADIOLOGY" ) {
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/masterfile/DELETE/deleteRadio.php?radioSavedNo=$row[radioSavedNo]&registrationNo=$registrationNo&username=$username'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a>");
}else {
$this->coconutTableData("&nbsp;");
}
$this->coconutTableRowStop();
}



}



////////////////////////////////////

public function deptInventory($desc,$dept) {


echo "
<style type='text/css'>
.data{
font-size:12px;
}

tr:hover{ background-color:yellow; color:black; }

</style>

";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



$result = mysql_query("SELECT description,quantity from inventory where (description like '$desc%%%%%%%' or genericName like '$desc%%%%%%%' ) and inventoryLocation='$dept' and status not like 'DELETED_%%%%%%%%%%' order by description asc  ");



echo "<center><table border=1 cellpadding=0 cellspacing=0>";
echo "<tr>";
echo "<th>Description</th>";
echo "<th>QTY</th>";
echo "</tr>";
while($row = mysql_fetch_array($result))
  {
echo "<tr>";
echo "<td>".$row['description']."</td>";
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "</tr>";
  }
echo "</table>";


}




public function getQTY_dispensed($inventoryCode) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT sum(quantity) as qtyDispensed from patientCharges WHERE chargesCode = '$inventoryCode' and (title = 'MEDICINE' or title = 'SUPPLIES') and departmentStatus like 'dispensedBy_%%%%%%%%' ");

while($row = mysql_fetch_array($result))
  {
return $row['qtyDispensed'];
}

}


public $laboratoryCensus_count;
public $laboratoryCensus_count_opd;
public $laboratoryCensus_count_ipd;
public $laboratoryCensus_count_undefined;

public function laboratoryCensus($dateFrom,$dateTo,$chargesCode) {


echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, " select upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,lsr.date,lsr.time,pc.description,rd.type from patientRecord pr 
inner join registrationDetails rd on pr.patientNo=rd.patientNo 
inner join patientCharges pc on rd.registrationNo=pc.registrationNo 
inner join labSavedResult lsr on pc.itemNo = lsr.itemNo
WHERE (lsr.date between '$dateFrom' and '$dateTo') and pc.chargesCode = $chargesCode and pc.status not like 'DELETED_%%%%%%'") or die("Query fail: " . mysqli_error()); 

echo "<br><br>";
echo "<center>";
echo "<table border=1 cellspacing=0>";
echo "<tr>";
echo "<th><font size=2>Name</font></th>";
echo "<th><font size=2>Type</font></th>";
echo "<th><font size=2>Examination</font></th>";
echo "<th><font size=2>Released</font></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
echo "<tr>";

if( $row['type'] == "IPD" ) {
$this->laboratoryCensus_count_ipd++;
}else if( $row['type'] == "OPD" ) {
$this->laboratoryCensus_count_opd++;
}else {
$this->laboratoryCensus_count_undefined ++;
}

$this->laboratoryCensus_count++;
echo "<tD>&nbsp;".$row['lastName'].", ".$row['firstName']."</tD>";
echo "<td>&nbsp;".$row['type']."</tD>";
echo "<td>&nbsp;".$row['description']."</tD>";
echo "<td>&nbsp;".$row['time']." @ ".$row['date']."</tD>";
echo "</tr>";
}

echo "<tr>";
echo "<Td>&nbsp;<b>IPD</b></tD>";
echo "<Td>&nbsp;<b>".$this->laboratoryCensus_count_ipd."</b></tD>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;<b>OPD</b></tD>";
echo "<Td>&nbsp;<b>".$this->laboratoryCensus_count_opd."</b></tD>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;<b>UNDEFINED</b></tD>";
echo "<Td>&nbsp;<b>".$this->laboratoryCensus_count_undefined."</b></tD>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;<b>TOTAL</b></tD>";
echo "<Td>&nbsp;<b>".$this->laboratoryCensus_count."</b></tD>";
echo "<Td>&nbsp;</tD>";
echo "<Td>&nbsp;</tD>";
echo "</tr>";
echo "</table>";
}


public function addBabyNow($mother,$baby) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO nbs (motherRegistrationNo,babyRegistrationNo)
VALUES
('$mother','$baby')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }

mysql_close($con);

}


public $getBabies_no=1;
public function getBabies($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select babyRegistrationNo from nbs where motherRegistrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
$this->getPatientProfile($row['babyRegistrationNo']);
echo "<font color=red>[".$this->getBabies_no++.".</font>".$this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()."<font color=red>]</font>  ";
}

}


public function countRow($table,$column) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select count($column) as cols from $table ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
return $row['cols'];
}

}



public function androidViewPatient($doctorCode) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, "select pr.lastName,pr.firstName,rd.registrationNo,pc.itemNo from patientRecord pr,registrationDetails rd,patientCharges pc,Doctors doc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and doc.doctorCode = '$doctorCode' and pc.chargesCode = doc.doctorCode and pc.dateCharge = '".date("Y-m-d")."' and rd.type='OPD' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td><center><form method='post' action='http://".$this->getMyUrl()."/COCONUT/android/doctor/viewPatient_information.php' target='rightFrame'>
<input type='hidden' name='itemNo' value='".$row['itemNo']."'>
<input type='submit' style='border:0px; border-radius:15px; height:30px; background-color:transparent; color:white; font-size:18px;' value='".$row['lastName']."'><input type='hidden' name='registrationNo' value='".$row['registrationNo']."'></form></center></td>";
echo "</tr>";
}

}




public function getAvailableCharges_mobile($charges,$registrationNo,$batchNo,$serverTime,$username,$room) {

echo "
<style type='text/css'>
a { text-decoration:none; color:white; }
tr:hover { background-color:black;}
</style>";

$this->getPatientProfile($registrationNo);

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



if($this->getRegistrationDetails_company() != "" && $this->getRegistrationDetails_type() == "OPD" ) {
$result = mysql_query("SELECT Category,chargesCode,upper(Description) as Description,(HMO) as sellingPrice,Service FROM availableCharges where Description like '$charges%%%%%' ");
}else if( $charges == "all" || $charges == "All" ) {
$result = mysql_query("SELECT Category,chargesCode,upper(Description) as Description,(OPD) as sellingPrice,Service FROM availableCharges where 1=1 order by description asc ");
}else if( $charges == "laboratory" || $charges == "lab"  ) {
$result = mysql_query("SELECT Category,chargesCode,upper(Description) as Description,(OPD) as sellingPrice,Service FROM availableCharges where 1=1 and Category = 'LABORATORY' order by description asc ");
}else if( $charges == "radiology" || $charges == "rad"  ) {
$result = mysql_query("SELECT Category,chargesCode,upper(Description) as Description,(OPD) as sellingPrice,Service FROM availableCharges where 1=1 and Category = 'RADIOLOGY' order by description asc ");
}
else if( $charges == "nbs" || $charges == "NBS"  ) {
$result = mysql_query("SELECT Category,chargesCode,upper(Description) as Description,(OPD) as sellingPrice,Service FROM availableCharges where 1=1 and Category = 'NBS' order by description asc ");
}
else {
$result = mysql_query("SELECT Category,chargesCode,upper(Description) as Description,(OPD) as sellingPrice,Service FROM availableCharges where Description like '".mysql_real_escape_string($charges)."%%%%%%%' ");
}

echo "&nbsp;  <table border=0 cellpadding=0 cellspacing=0 width='400px'>";
echo "<tr>";
echo  "<th>&nbsp;<font color=white><b>Description</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font color=white><b>Price</font></b>&nbsp;</th>";
echo "</tr>";

while($row = mysql_fetch_array($result))
  {

$senior = $row['sellingPrice'] - $row['sellingPrice'] * 0.20;
$sellingPrice = 0;
echo "<tr>";
echo "<td style='background:#transparent; color:white; font-size:23px;'><a href='http://".$this->getMyUrl()."/COCONUT/android/doctor/notifyToAdd.php?status=UNPAID&registrationNo=$registrationNo&chargesCode=$row[chargesCode]&description=$row[Description]&sellingPrice=$row[sellingPrice]&discount=0&timeCharge=$serverTime&chargeBy=$username&service=$row[Service]&title=$row[Category]&paidVia=Cash&cashPaid=0.00&batchNo=$batchNo&username=$username&quantity=1&inventoryFrom=none&room=OPD_OPD'><b>&nbsp;".$row['Description']."&nbsp;</b></a></td>";

if( $row['Category'] == "LABORATORY" ) {
$sellingPrice = $row['sellingPrice'];
if($this->getPatientRecord_senior() == "NO") {
echo "<td>&nbsp;<a href='#'><font color='white' size='4px'>".number_format($sellingPrice,2)."</font></a>&nbsp;</td>";
}else {
//$sellingPrice = $senior;
echo "<td>&nbsp;<a href='#'><font color='white' size='4px'>".number_format($sellingPrice,2)."</font></a>&nbsp;</td>";
}
}else {
$sellingPrice = $row['sellingPrice'];
echo "<td>&nbsp;<a href='#'><font color='white' size='4px'>".number_format($sellingPrice,2)."</font></a>&nbsp;</td>";
}

/*
if($this->getPatientRecord_senior() == "YES") {
$senior = $row['sellingPrice'] - $row['sellingPrice'] * $this->percentage("senior");
echo "<td>&nbsp;<a href='#'>".$senior."</a>&nbsp;</td>";
}else {
echo "";
}
*/



//e2 ung ggmitin
//echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/availableCharges/addCharges.php?status=UNPAID&registrationNo=$registrationNo&chargesCode=$row[chargesCode]&description=$row[Description]&sellingPrice=$sellingPrice&discount=0&timeCharge=$serverTime&chargeBy=$username&service=$row[Service]&title=$row[Category]&paidVia=Cash&cashPaid=0.00&batchNo=$batchNo&username=$username&quantity=1&inventoryFrom=none&room=".$room[0]."_".$room[1]."'><font color=blue>Add</font></a>&nbsp;";

/*
if($this->getRegistrationDetails_company() != "") {
echo "|&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/availableCharges/addCharges.php?status=APPROVED&registrationNo=$registrationNo&chargesCode=$row[chargesCode]&description=$row[Description]&sellingPrice=$row[sellingPrice]&discount=0&timeCharge=$serverTime&chargeBy=$username&service=Examination&title=$row[Category]&paidVia=Company&cashPaid=0.00&batchNo=$batchNo&username=$username&quantity=1&inventoryFrom=none&room=".$room[0]."_".$room[1]."'><font color=red>Company</font></a>&nbsp;";
}else {
echo "";
}

$discount =$row['sellingPrice'] * $this->percentage("senior");
if($this->getPatientRecord_senior() == "YES") {
echo "|&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/availableCharges/addCharges.php?status=UNPAID&registrationNo=$registrationNo&chargesCode=$row[chargesCode]&description=$row[Description]&sellingPrice=$row[sellingPrice]&discount=$discount&timeCharge=$serverTime&chargeBy=$username&service=Examination&title=$row[Category]&paidVia=Cash&cashPaid=0.00&batchNo=$batchNo&username=$username&quantity=1&inventoryFrom=none&room=".$room[0]."_".$room[1]."'><font color=darkgreen>Senior Disc</font></a>&nbsp;";
}else {
echo "";
}
*/

echo "</td>";
echo "</tr>";

}

}



public $showCartMobile_discount;
public $showCartMobile_total;

//iLLbas Lhat ng chinarge
public function showCartMobile($registrationNo,$batchNo,$username) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT pc.* FROM patientCharges pc where pc.registrationNo='$registrationNo' and status not like 'DELETED_%%%%%%%%' and pc.batchNo='$batchNo' order by pc.description asc  ");

echo "<div style='background:#47a3da; border-radius:15px; width:350px;'>";
echo "<table border=0 width='350px;'>";
$this->coconutTableRowStart();
echo "<th><font color='white'>Description</font></th>";
echo "<th><font color='white'>Price</font></th>";
echo "<th><font color='white'>QTY</font></th>";
$this->coconutTableRowStop();
while($row=mysql_fetch_array($result)) {
echo "<tr id='rowz'>";
$this->showCartMobile_discount += $row['discount'];
$this->showCartMobile_total += $row['total'];


$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/android/mobileECART/deleteCart.php?registrationNo=$registrationNo&batchNo=$batchNo&itemNo=$row[itemNo]&username=$username' style='text-decoration:none;'><font color='white'><b>".$row['description']."</b></font></a>");
$this->coconutTableData("<font color='white'><b>".number_format($row['total'],2)."</b></font>");
$this->coconutTableData("<font color='white'><b>".$row['quantity']."</b></font>");

echo "</tr>";
}


$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<font color='white'><b>Balance</b></font>");
$this->coconutTableData("&nbsp;<font color='white'><b>".number_format($this->showCartMobile_total,2)."</b></font>");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();



$this->coconutTableStop();
echo "</div>";
}




public function addCharges_cash_mobile($status,$registrationNo,$chargesCode,$description,$sellingPrice,$discount,$total,$cashUnpaid,$phic,$company,$timeCharge,$dateCharge,$chargeBy,$service,$title,$paidVia,$cashPaid,$batchNo,$quantity,$inventoryFrom,$branch,$room) {


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO patientCharges (status,registrationNo,chargesCode,description,sellingPrice,discount,total,cashUnpaid,phic,company,timeCharge,dateCharge,chargeBy,
service,title,paidVia,cashPaid,batchNo,quantity,inventoryFrom,branch,control_dateCharge,control_datePaid)
VALUES
('$status','$registrationNo','$chargesCode','$description','$sellingPrice','$discount','$total','$cashUnpaid','$phic','$company',
'$timeCharge','$dateCharge','$chargeBy','$service','".strip_tags($title)."','$paidVia','$cashPaid','$batchNo','$quantity','$inventoryFrom','$branch','".date("Y-m-d")."','')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


if($title == "LABORATORY" || $title == "RADIOLOGY") { 

echo "
<script type='text/javascript'>
window.location='http://".$this->getMyUrl()."/COCONUT/android/doctor/mobileAddCharges_charges.php?registrationNo=$registrationNo&username=$chargeBy&room=$room&batchNo=$batchNo';
</script>";
}else if($title == "MEDICINE") {

echo "
<script type='text/javascript'>
window.location='http://".$this->getMyUrl()."/COCONUT/android/doctor/mobileAddCharges_medicine.php?registrationNo=$registrationNo&username=$chargeBy&room=$room&batchNo=$batchNo';
</script>";

}


else {
echo "";
}
mysql_close($con);

}



public $med_sp_mobile;

public function getAvailableMedicine_mobile($searchBy,$searchDesc,$registrationNo,$batchNo,$serverTime,$username,$searchFrom,$room) {

echo "

<script type='text/javascript' src='http://".$this->getMyUrl()."/jquery.js'></script>
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:black;}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT phic,preparation,inventoryCode,description,genericName,((unitcost * ".$this->percentage("medicine").") + unitcost) as sellingPrice,quantity,unitcost,Added FROM inventory WHERE $searchBy like '$searchDesc%%%%%%%' and inventoryType = 'medicine' and inventoryLocation = '$searchFrom' and status not like 'DELETED_%%%%%' and quantity > 0 order by $searchBy asc ");

echo "<table border=0 cellpadding=0 cellspacing=0 >";
echo "<tr>";
echo "<th>&nbsp;<font color=white>Description</font>&nbsp;</th>";
echo "<th>&nbsp;<font color=white>Price</font>&nbsp;</th>";
echo "<th>&nbsp;<font color=white>QTY</font>&nbsp;</th>";
echo "<th>&nbsp;<font color=white>&nbsp;</font>&nbsp;</th>";
echo "<th>&nbsp;<font color=white>&nbsp;</font>&nbsp;</th>";
echo "<th>&nbsp;<font color=white>&nbsp;</font>&nbsp;</th>";

echo "</tr>";
while($row = mysql_fetch_array($result))
  {
echo "<tr>";
$senior = $row['sellingPrice'] * $this->percentage("senior");
$priceOption = preg_split ("/\_/", $row['Added']); 
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/android/doctor/medicineNotify.php?status=UNPAID&registrationNo=$registrationNo&chargesCode=$row[inventoryCode]&description=$row[description]&sellingPrice=".$priceOption[1]."&timeCharge=$serverTime&chargeBy=$username&service=Medication&title=MEDICINE&paidVia=Cash&cashPaid=0&batchNo=$batchNo&username=$username&inventoryFrom=$searchFrom&discount=0&room=$room' style='text-decoration:none;'><font size=3 color='white'><b><i>*".$row['description']."</i></b></font><br><font color='white'><b>".$row['genericName']."</b></font><br><font color='white'><b>".$row['preparation']."</b></font></a>&nbsp;</td>";



echo "<td>&nbsp;<font color='white'><b>".number_format($priceOption[1],2)."</b></font>&nbsp;</td>";
$this->med_sp_mobile = $priceOption[1];



echo "<td>&nbsp;<font color='white'><b>".$row['quantity']."</b></font>&nbsp;</td>";



}
echo "</table>";

}



public function addNewPlan($registrationNo,$medicine,$timing,$instruction,$indication,$qty) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into doctorsPlan(registrationNo,medicine,timing,instruction,indication,qty) values('$registrationNo','$medicine','$timing','$instruction','$indication','$qty')";
 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/android/doctor/newPlan.php?registrationNo=$registrationNo");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}


public function addNewPlan_fromCharging($registrationNo,$medicine,$timing,$instruction,$indication,$qty,$batchNo,$room,$username) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into doctorsPlan(registrationNo,medicine,timing,instruction,indication,qty) values('$registrationNo','$medicine','$timing','$instruction','$indication','$qty')";
 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/android/doctor/mobileAddCharges_medicine.php?registrationNo=$registrationNo&batchNo=$batchNo&room=$room&username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}

public function getDoctorsNewPlan($registrationNo) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select planNo,medicine,timing,instruction,indication,qty from doctorsPlan where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
echo "<tr>";
echo "<td style='width:30px;'><Center><a href='http://".$this->getMyUrl()."/COCONUT/android/doctor/deleteMeds_alert.php?planNo=$row[planNo]&registrationNo=$registrationNo'><font size=2>".$row['medicine']."</font></a></center></td>";
echo "<td style='width:15px;'><div contenteditable='true'><center><font size=2>".$row['timing']."</font></center></div></td>";
echo "<td style='width:15px;'><div contenteditable='true'><center><font size=2>".$row['instruction']."</font></center></div></td>";
echo "<td style='width:15px;'><div contenteditable='true'><center><font size=2>".$row['indication']."</font></center></div></td>";
echo "<td style='width:15px;'><div contenteditable='true'><center><font size=2>".$row['qty']."</font></center></div></td>";
echo "</tr>";
}

}


public function showAdvisedIn_SOAP_returns($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select advised from registrationDetails where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 
$x=1;
while($row = mysqli_fetch_array($result))
{
return $row['advised'];
}
}

public function doctorsMedicinePlan_SOAP_returns($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select planNo,medicine,timing,instruction,indication,qty from doctorsPlan where registrationNo = '$registrationNo'  ") or die("Query fail: " . mysqli_error()); 
$x=1;
while($row = mysqli_fetch_array($result))
{
$result_array[] = "<b>".$row['medicine']."</b><br>- ".$row['timing']."<br>- ".$row['instruction']."<br>- ".$row['indication']."<br>- ".$row['qty']."<br>";
}
return implode(",",$result_array);
}


public function checkAdvisedFromCharges($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select description from patientCharges where registrationNo = '$registrationNo' and title != 'MEDICINE' and title != 'PROFESSIONAL FEE' and status not like 'DELETED_%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
return $row['description'];
}

}

public function showAdvisedFromCharges($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select description from patientCharges where registrationNo = '$registrationNo' and title != 'MEDICINE' and title != 'PROFESSIONAL FEE' and status not like 'DELETED_%%%%%%%' ") or die("Query fail: " . mysqli_error()); 
$x=1;

if( $this->checkAdvisedFromCharges($registrationNo) != "" ) {
while($row = mysqli_fetch_array($result))
{
$result_array[] = ",<font size=2>".$row['description']."</font>";
}
return implode(",",$result_array);
}else { 
return "";
}


}




public function mobileHospitalCharges($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, "select itemNo,description from patientCharges where registrationNo = '$registrationNo' and title = '$title' and status not like 'DELETED_%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{

if( $this->selectNow("labSavedResult","itemNo","itemNo",$row['itemNo']) != "" ) {
echo "
<div style='border:1px solid #000; width:60%; background:#F8F8FF; font-size:35px;' >
<a href='http://".$this->getMyUrl()."/COCONUT/android/doctor/deleteCharges.php?itemNo=$row[itemNo]&registrationNo=$registrationNo' style='text-decoration:none; color:black;'>&nbsp;".$row['description']."</a>
<br>
<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$registrationNo&itemNo=$row[itemNo]'><font color='red' size=2>View Result</font></a>
</div>";
}else {
echo "
<div style='border:1px solid #000; width:60%; background:#F8F8FF; font-size:35px;' >
<a href='http://".$this->getMyUrl()."/COCONUT/android/doctor/deleteCharges.php?itemNo=$row[itemNo]&registrationNo=$registrationNo' style='text-decoration:none; color:black;'>&nbsp;".$row['description']."</a>
</div>";
}
}
}


public function getPatientForResult_itemizedResult($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select pc.registrationNo,pc.itemNo,pc.description from patientCharges pc,labSavedResult lsr where pc.itemNo = lsr.itemNo and lsr.registrationNo='$registrationNo'   ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
echo "
<form method='get' action='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php'>
<input type='hidden' name='registrationNo' value='$row[registrationNo]'>
<input type='submit' style='height:8%; width:30%; border:0px; color:white; font-weight:bold; border-radius:15px; background:#47a3da;' value='$row[description]'>
<input type='hidden' name='itemNo' value='$row[itemNo]'>
</form>
";
}

}



public function getPatientForResult($doctorCode) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select rd.registrationNo,pr.lastName,pr.firstName from patientRecord pr,registrationDetails rd,labSavedResult lsr,patientCharges pc where pr.patientNo=rd.patientNo and rd.registrationNo=pc.registrationNo and rd.registrationNo=lsr.registrationNo and lsr.date='".date("Y-m-d")."' and pc.chargesCode = '$doctorCode' group by rd.registrationNo order by lsr.time desc ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{

echo "<div style='border-bottom:1px solid #000;'><font size=6>".$row['lastName'].", ".$row['firstName']."</font>";
$this->getPatientForResult_itemizedResult($row['registrationNo']);
echo "</div>";
}

}




/******************NEW CF2**************************/

public function getDiagnosisForNewCF2($registrationNo) {

echo "<style type='text/css'>
.diagnosis{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 200px;
	border-color:white white black white;
	font-size:15px;

}

.icd{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 80px;
	border-color:white white black white;
	font-size:15px;

}

.relatedProcedure{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 100px;
	border-color:white white black white;
	font-size:15px;

}


.date{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 130px;
	border-color:white white black white;
	font-size:15px;

}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select icdCode,diagnosis from patientICD where registrationNo='$registrationNo' ") or die("Query fail: " . mysqli_error()); 

echo "<center><table width='840px' border='0px;'>";
echo "<tr>";
echo "<th><font size=2>Diagnosis</font></th>";
echo "<th><font size=1>ICD 10 Code/s</font></th>";
echo "<th><font size=1>Related Procedure/s (is there's any)</font></th>";
echo "<th><font size=1>RVS Code</font></th>";
echo "<th><font size=1>Date of Operation</font></th>";
echo "<th><font size=1>Laterality (check applicable boxes)</font></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
//echo "<td style='vertical-align:top;'> <input type='text' class='diagnosis' value='$row[diagnosis]'></td>";
echo "<td style='vertical-align:top; width:10%' > <div contenteditable='true' style='border-top:0px; border-left:0px; border-bottom:1px solid #000; font-size:15px;'> $row[diagnosis] </div> </td>";
//echo "<td style='vertical-align:top;'> <input type='text' class='icd' value='$row[icdCode]'> </td>";
echo "<td style='vertical-align:top;'><div contenteditable='true' style='border-top:0px; border-left:0px; border-bottom:1px solid #000;'> $row[icdCode] </div> </td>";
echo "<td> <font size=2>i.</font><input type='text' class='relatedProcedure'>
<br>
<font size=2>ii.</font><input type='text' class='relatedProcedure'>
<br>
<font size=2>iii.</font> <input type='text' class='relatedProcedure'>
<br>
<font size=2>iv.</font><input type='text' class='relatedProcedure'>
</td>";
echo "<td style='vertical-align:top;'> <input type='text' class='icd' > </td>";
echo "<td style='vertical-align:top;'> <input type='text' class='date' > </td>";
echo "<td style='vertical-align:top;'> <input type='checkbox'><font size=1>Left</font>
<input type='checkbox'><font size=1>Right</font>
<input type='checkbox'><font size=1>Both</font> </td>
</tr>";
}
echo "</table></center>";
}




public function getChargesAndPFinNewCF2($registrationNo) {

echo "
<style type='text/css'>
.box{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 20px;
	border-color:white black black black;
	font-size:15px;
	text-align:center;
}

.box1{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 20px;
	border-color:white black black white;
	font-size:15px;
	text-align:center;
}

.signature{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 250px;
	border-color:white white black white;
	font-size:15px;
	text-align:center;
}


.amountz{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 150px;
	border-color:white white black white;
	font-size:15px;
	text-align:center;
}


</style>

";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select pc.chargesCode,pc.description from patientCharges pc where pc.registrationNo = '$registrationNo' and pc.title = 'PROFESSIONAL FEE' and status not like 'DELETED_%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

echo "<table style='width:860px;' border=1px; cellspacing=0px; cellpadding=10px;  >";
echo "<tr>";
echo "<th><font size=2>Accreditation Number/Name of Accredited Health Care Professional/Date Signed</font></th>";
echo "<th><font size=2>Details</font></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
{


$phicPin0 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),0,1);
$phicPin1 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),1,1);
$phicPin2 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),2,1);
$phicPin3 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),3,1);
//-
$phicPin4 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),5,1);
$phicPin5 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),6,1);
$phicPin6 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),7,1);
$phicPin7 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),8,1);
$phicPin8 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),9,1);
$phicPin9 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),10,1);
$phicPin10 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),11,1);
//-
$phicPin11 = substr($this->selectNow("Doctors","PhilHealth_AccreditationNo","doctorCode",$row['chargesCode']),13,1);

echo "<tr>";
echo "<td width='50%'>";
echo "<center><br><font size=2><b>Accreditation No:</b> <input type='text' class='box' value='$phicPin0'><input type='text' class='box1' value='$phicPin1' ><input type='text' class='box1' value='$phicPin2' ><input type='text' class='box1' value='$phicPin3' >-<input type='text' class='box' value='$phicPin4' ><input type='text' class='box1' value='$phicPin5' ><input type='text' class='box1' value='$phicPin6' ><input type='text' class='box1' value='$phicPin7' ><input type='text' class='box1' value='$phicPin8' ><input type='text' class='box1' value='$phicPin9' ><input type='text' class='box1' value='$phicPin10' >-<input type='text' class='box' value='$phicPin11' >  </font>";
echo "<br><Br>";
echo "<input type='text' class='signature' value='$row[description]'><br><font size=1>Signature Over Printed Name</font><br>";
echo "<br>";
echo "<font size=2>Date Signed:</font> <input type='text' class='box'><input type='text' class='box1'>-<input type='text' class='box'><input type='text' class='box1'>-<input type='text' class='box'><input type='text' class='box1'><input type='text' class='box1'><input type='text' class='box1'>";
echo "</td>";
echo "<td width='50%;'>
<input type='checkbox'><font size=1>No Co-pay on top of PhilHealth Benefit</font>
<Br>
<input type='checkbox'><font size=1>With Co-pay on top of PhilHealth Benefit</font><input type='text' class='amountz'>
</td>";
echo "</tr>";
}
echo "</table>";

}




public function getTotalPF($registrationNo,$columns) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$this->laboratoryCensus_count=0;

$result = mysqli_query($connection, "select sum($columns) as total from patientCharges where registrationNo='$registrationNo' and title = 'PROFESSIONAL FEE' and status = 'UNPAID' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
return $row['total'];
}

}



public function getRoomPHIC_unpaid($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(cashUnpaid) as unpaid from patientCharges where registrationNo = '$registrationNo' and title = 'Room And Board'  ");


while($row = mysql_fetch_array($result))
  {
return $row['unpaid'];

}


}


/*****************NEW CF2**************************/




public function addReagents($referenceNo,$description,$qty,$dateIn,$user,$permanentReference) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into labReagents(referenceNo,description,qty,dateIn,user,permanentReference) values('$referenceNo','$description','$qty','$dateIn','$user','$permanentReference')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/Laboratory/addReagents.php?username=$user");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}






public function viewReagents($username) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT referenceNo,description,qty,dateIn,dateOut,user from labReagents order by dateOut desc  ");

echo "<br><Br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Reference#");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Date In");
$this->coconutTableHeader("Date Out");
$this->coconutTableHeader("User");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['referenceNo']);
$this->coconutTableData($row['description']);
$this->coconutTableData($row['qty']);
$this->coconutTableData($row['dateIn']);
$this->coconutTableData($row['dateOut']);
$this->coconutTableData($row['user']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();

}

public $getReagentsWillBeUse_referenceNo;
public function getReagentsWillBeUse_referenceNo() {
return $this->getReagentsWillBeUse_referenceNo;
}

public function getReagentsWillBeUse($permanentReferenceNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT description,referenceNo,permanentReference from labReagents where permanentReference = '$permanentReferenceNo'  ");


while($row = mysql_fetch_array($result))
{
if( $permanentReferenceNo != "none" ) {
echo "<font color='red'>Reagents:</font>".$row['description']." &nbsp;&nbsp;&nbsp; <font color=red>Lot#</font>".$row['referenceNo'];
$this->getReagentsWillBeUse_referenceNo = $row['permanentReference'];
}else {
echo "";
}


}

}



public function useReagents($itemNo,$registrationNo,$permanentNo,$date) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into labReagentsUsed(itemNo,registrationNo,permanentNo,date) values('$itemNo','$registrationNo','$permanentNo','$date')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
//$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/Laboratory/addReagents.php?username=$user");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}



public function addDiet($dietName,$dietCode,$username) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into dietList(dietCode,dietName) values('$dietCode','$dietName')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/dietary/addDiet.php?username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}



public function viewDiet($username) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT dietNo,dietName,dietCode from dietList order by dietName asc  ");

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Diet Code");
$this->coconutTableHeader("Diet");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['dietCode']);
$this->coconutTableData($row['dietName']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/dietary/editDiet.php?username=$username&dietName=$row[dietName]&dietCode=$row[dietCode]&dietNo=$row[dietNo]'>".$this->coconutImages_return("pencil.jpeg")."</a>");
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/dietary/deleteDiet.php?username=$username&dietNo=$row[dietNo]&dietName=$row[dietName]'>".$this->coconutImages_return("delete.jpeg")."</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();

}




public function viewPxForDietary($username) {


echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT pr.lastName,pr.firstName,rd.room,rd.diet,pr.Age,rd.registrationNo from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and rd.dateUnregistered = '' and rd.type='IPD' and room != 'ER_ER' and room != '' and room != 'OPD_OPD' ");

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Room");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Diet");
$this->coconutTableHeader("Age");
$this->coconutTableHeader("Doctor");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['room']);
$this->coconutTableData($row['lastName'].", ".$row['firstName']);
$this->coconutTableData($this->selectNow("dietList","dietName","dietNo",$row['diet']));
$this->coconutTableData($row['Age']);
$this->coconutTableData($this->getAttendingDoc($row['registrationNo'],"Attending"));
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}



public function countDeptRequest($title,$date) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

if( $title == "MEDICINE" || $title == "SUPPLIES" ) {
$result = mysqli_query($connection, " select count(itemNo) as totalItem from patientCharges where (title = '$title') and (dateCharge = '$date' or dateReturn = '$date') and (departmentStatus = '' or departmentStatus not like 'dispensedBy_%%%%%%') ") or die("Query fail: " . mysqli_error()); 
}else if( $title == "CSR" ) {
$result = mysqli_query($connection, " select count(verificationNo) as totalItem from inventoryManager where dateRequested = '$date' and status = 'requesting' ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " select count(itemNo) as totalItem from patientCharges where title = '$title' and dateCharge = '$date' and departmentStatus = '' ") or die("Query fail: " . mysqli_error()); 
}


while($row = mysqli_fetch_array($result))
  {
return $row['totalItem'];
}
}





public function getRequestForCSR($date,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select requestingUser,batchNo from inventoryManager where requestTo_department = 'CSR' and dateRequested = '$date' and status = 'requesting' and dispensedDate = '' group by batchNo ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/CSR/showRequest.php?batchNo=$row[batchNo]&username=$username' style='text-decoration:none; color:red;' target='patientCharges'>".$row['requestingUser']."</a>");
echo "</tr>";
}
}

public function getRequestForCSR_itemized($batchNo,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select verificationNo,batchNo,inventoryCode,description,quantity,requestingDepartment,timeRequested from inventoryManager where batchNo = '$batchNo' and status = 'requesting' and requestTo_department = 'CSR' ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Department");
$this->coconutTableHeader("Time");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
$this->coconutFormStart("get","http://".$this->getMyUrl()."/COCONUT/CSR/dispensedCSR.php");
$this->coconutHidden("username",$username);
while($row = mysqli_fetch_array($result))
{
$this->coconutTableRowStart();
$this->coconutTableData("<input type='checkbox' name='verificationNo[]' value='$row[verificationNo]_".$row['inventoryCode']."' checked>");
$this->coconutTableData($row['description']);
$this->coconutTableData($row['quantity']);
$this->coconutTableData($row['requestingDepartment']);
$this->coconutTableData($row['timeRequested']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/CSR/editItem.php?verificationNo=$row[verificationNo]&description=$row[description]&quantity=$row[quantity]&username=$username&batchNo=$row[batchNo]'>".$this->coconutImages_return("pencil.jpeg")."</a>");
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/CSR/cancelRequest.php?verificationNo=$row[verificationNo]&description=$row[description]&username=$username&batchNo=$row[batchNo]'>".$this->coconutImages_return("delete.jpeg")."</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
echo "<br>";
$this->coconutButton("Dispensed");
$this->coconutFormStop();
}





public function getCSR_dispensed($date,$username,$status) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select verificationNo,inventoryCode,description,quantity,quantityIssued,requestingDepartment,requestingUser from inventoryManager where dispensedDate = '$date' and status = '$status' ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Department");
$this->coconutTableHeader("Requested By");
if( $status == "dispensed" ) {
$this->coconutTableHeader("");
}else { }
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
{
$this->coconutTableRowStart();
$this->coconutTableData($row['description']);
$this->coconutTableData($row['quantity']);
$this->coconutTableData($row['requestingDepartment']);
$this->coconutTableData($row['requestingUser']);
if( $status == "dispensed" ) {

if( $this->selectNow("csrReturned","returnNo","verificationNo",$row['verificationNo']) == "" ) {
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/CSR/csrReturn.php?username=$username&description=$row[description]&verificationNo=$row[verificationNo]&inventoryCode=$row[inventoryCode]&qty=$row[quantity]&borrowerDepartment=$row[requestingDepartment]' style='text-decoration:none; color:red;'><font size=2>Return</font></a>");
}else {
echo "<td>&nbsp;</td>";
}

}
else { }
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}



public function addConsumed($inventoryCode,$department,$qty,$description,$date,$time,$username) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into inventoryConsumed(inventoryCode,department,qty,description,date,time,username) values('$inventoryCode','$department','$qty','$description','$date','$time','$username')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
//$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/dietary/addDiet.php?username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}



public function getConsumed($date) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select inventoryCode,department,qty,description,date,time,username from inventoryConsumed where date = '$date' ") or die("Query fail: " . mysqli_error()); 

echo "<center><br>$date";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Inventory Code");
$this->coconutTableHeader("Department");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Time");
$this->coconutTableHeader("Username");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
{
$this->coconutTableRowStart();
$this->coconutTableData($row['inventoryCode']);
$this->coconutTableData($row['department']);
$this->coconutTableData($row['description']);
$this->coconutTableData($row['qty']);
$this->coconutTableData($row['time']);
$this->coconutTableData($row['username']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}


public function csrReturnItem($verificationNo,$inventoryCode,$description,$qty,$borrowerDepartment,$borrowerUsername,$dateReturn,$timeReturn) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into csrReturned(verificationNo,inventoryCode,description,qty,borrowerDepartment,borrowerUsername,dateReturn,timeReturn) values('$verificationNo','$inventoryCode','$description','$qty','$borrowerDepartment','$borrowerUsername','$dateReturn','$timeReturn')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
//$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/dietary/addDiet.php?username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}


public function getReturnedItem($date) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select inventoryCode,borrowerDepartment,description,qty,timeReturn,borrowerUsername from csrReturned where dateReturn = '$date' ") or die("Query fail: " . mysqli_error()); 

echo "<center><br>Return Items in $date";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Inventory Code");
$this->coconutTableHeader("Department");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Time");
$this->coconutTableHeader("Return By");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
{
$this->coconutTableRowStart();
$this->coconutTableData($row['inventoryCode']);
$this->coconutTableData($row['borrowerDepartment']);
$this->coconutTableData($row['description']);
$this->coconutTableData($row['qty']);
$this->coconutTableData($row['timeReturn']);
$this->coconutTableData($row['borrowerUsername']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public function getReceivingReport($date) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select inventoryCode,inventoryType,unitcost,suppliesUNITCOST,description,quantity,expiration,Added,preparation from inventory where dateAdded = '$date' and status not like 'DELETED_%%%%%%' ") or die("Query fail: " . mysqli_error()); 

echo "<center><br>Receiving Items in $date";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Inventory Code");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Unitcost");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Preparation");
$this->coconutTableHeader("Expiration");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
{
$this->coconutTableRowStart();
$this->coconutTableData($row['inventoryCode']);
$this->coconutTableData($row['description']);

if( $row['inventoryType'] == "medicine" ) {
$this->coconutTableData($row['unitcost']);
}else {
$this->coconutTableData($row['suppliesUNITCOST']);
}

if( $row['inventoryType'] == "medicine" ) {
$pricez = preg_split ("/\_/", $row['Added']); 
$this->coconutTableData($pricez[1]);
}else {
$this->coconutTableData($row['unitcost']);
}

$this->coconutTableData($row['quantity']);
$this->coconutTableData($row['preparation']);
$this->coconutTableData($row['expiration']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}



public function getImagesPx($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select itemNo,fileName,fileUrl,fileOwner,dateUploaded from uploadedFiles where registrationNo='$registrationNo' ") or die("Query fail: " . mysqli_error()); 

echo "<center><br>Images/DICOM";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Charges");
$this->coconutTableHeader("File Name");
$this->coconutTableHeader("Uploaded By");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
{

$info = pathinfo("http://".$this->getMyUrl()."".$row['fileUrl']);


$this->coconutTableRowStart();
$this->coconutTableData("<b><i>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</i></b>");
$this->coconutTableData($row['fileName']);
$this->coconutTableData($row['fileOwner']);
$this->coconutTableData($row['dateUploaded']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/uploader/xXxdicomxXx/".$row['fileName']."' style='text-decoration:none; color:red;'><font size=2>Download</font></a>");

if ($info["extension"] == "jpg" || $info['extension'] == "jpeg" ) {
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/uploader/image.php?urlz=$row[fileUrl]' style='text-decoration:none; color:red;'><font size=2>View</font></a>");
}else {
$this->coconutTableData("");
}

$this->coconutTableRowStop();
}
$this->coconutTableStop();
}


public function sumFromPharmacy($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select sum(cashUnpaid) as totalSum from patientCharges where registrationNo='$registrationNo' and status='UNPAID' and (title = 'MEDICINE' or title = 'SUPPLIES') ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['totalSum'];
}
}


public function sumFromNotPharmacy($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select sum(cashUnpaid) as totalSumz from patientCharges where registrationNo='$registrationNo' and status='UNPAID' and (title != 'MEDICINE' and title != 'SUPPLIES') ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['totalSumz'];
}
}


/********************** R-BANNY *************************/


public function getCurrentPHIC_check_rBanny($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT sum(pc.phic) as totalPHIC FROM registrationDetails rd,patientCharges pc where rd.registrationNo = '$registrationNo' and rd.registrationNo = pc.registrationNo and pc.phic >0 and status = 'UNPAID' ");


while($row = mysql_fetch_array($result))
  {
return $row['totalPHIC'];
  }

mysql_close($con);

}

public function getMaximumTotal_rBanny($registrationNo) { //kkuhain ang maximum sa medicine 

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT pc.cashUnpaid,pc.itemNo from patientCharges pc where pc.registrationNo = '$registrationNo' and pc.status = 'UNPAID' and pc.sellingPrice > 0 and pc.phic=0 and pc.title != 'PROFESSIONAL FEE' HAVING MAX(pc.cashUnpaid) ");


while($row = mysql_fetch_array($result))
  {
return $row['cashUnpaid']."_".$row['itemNo'];
  }

}


public function update_rBanny($registrationNo,$itemNo,$total) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

mysql_query("UPDATE patientCharges SET cashUnpaid = '$total',company = 0,phic = 0
WHERE itemNo = '$itemNo' and registrationNo = '$registrationNo' ");

mysql_close($con);
}


public function getReady_rBanny($registrationNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT itemNo,total,description from patientCharges where registrationNo = '$registrationNo' and status = 'UNPAID' ");


echo "<table border=0>";
while($row = mysql_fetch_array($result))
  {
echo "<tr>";
$this->update_rBanny($registrationNo,$row['itemNo'],$row['total']);
echo "</tr>";  
}

echo "</table>";

}


/****************** R-BANNY ****************************/



public function checkIfRecordExist($lastName,$firstName,$middleName) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select patientNo from patientRecord where lastName = '$lastName' and firstName = '$firstName' and middleName = '$middleName' ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
return $row['patientNo'];
}


}



public function selectedNOD($registrationNo,$dateCharge,$from,$to) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select chargeBy from patientCharges where registrationNo=$registrationNo and (title='MEDICINE' or title='SUPPLIES') and departmentStatus not like 'dispensedBy%%%%' and dateCharge='$dateCharge' and (timeCharge between '$from' and '$to') group by chargeBy  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
echo "<option value='".$row['chargeBy']."'>".$row['chargeBy']."</option>";
}
}


public $totalRefunds;

public function totalRefunds() {
return $this->totalRefunds;
}

public function showRefunds($date) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select paymentFor,registrationNo,amountPaid,paidBy from patientPayment where datePaid = '$date' and paymentFor = 'REFUND'  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->totalRefunds += $row['amountPaid'];
echo "<tr>";
echo "<td>".$this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName()."</td>";
echo "<td>&nbsp;".$row['paymentFor']."</td>";
echo "<td>&nbsp;".number_format($row['amountPaid'],2)."</td>";
echo "<td>&nbsp;".number_format($row['amountPaid'],2)."</td>";
echo "<td>&nbsp;".number_format($row['amountPaid'],2)."</td>";
echo "<td>&nbsp;".$row['paidBy']."</td>";
echo "<td>&nbsp;".number_format($row['amountPaid'],2)."</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";
}

}




public function admissionDischargedRecord($patientNo,$registrationNo,$birthPlace,$nationality,$pxOccupation,$fathersName,$mothersName,$address,$contact1,$spouseName,$address1,$contactNo2,$admissionType,$ssc,$ws,$employerName,$dataGivenBy,$informantAddress,$patientRelation,$disposition,$result) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into patientRecord2(patientNo,registrationNo,birthPlace,nationality,pxOccupation,fathersName,mothersName,address,contact1,spouseName,address1,contact2,admissionType,socialService,ws,employerName,dataGivenBy,informantAddress,relation2patient,disposition,result) values('$patientNo','$registrationNo','$birthPlace','$nationality','$pxOccupation','$fathersName','$mothersName','$address','$contact1','$spouseName','$address1','$contactNo2','$admissionType','$ssc','$ws','$employerName','$dataGivenBy','$informantAddress','$patientRelation','$disposition','$result')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
//$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/dietary/addDiet.php?username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}




public function showIssuedRequest($date) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select description,quantity,requestingDepartment,requestingUser,issuedBy from inventoryManager where dateIssued = '$date'  ") or die("Query fail: " . mysqli_error()); 

echo "<Br><br><center>";
echo "<font size=2>Inventory Issued ($date)</font>";
echo "<Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Department");
$this->coconutTableHeader("Request By");
$this->coconutTableHeader("Issued By");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
echo "<tr>";
echo "<td>&nbsp;".$row['description']."</td>";
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td>&nbsp;".$row['requestingDepartment']."</td>";
echo "<td>&nbsp;".$row['requestingUser']."</td>";
echo "<td>&nbsp;".$row['issuedBy']."</td>";
echo "</tr>";
}
$this->coconutTableStop();

}




public function getAllPayment($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select sum(amountPaid) as totalz from patientPayment where registrationNo = '$registrationNo'  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['totalz'];
}
}


public function checkPermission($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select status from pxUnlocked where registrationNo = '$registrationNo' and status = 'Open'  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['status'];
}
}


public function showSupervisorLocked($registrationNo,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select unlockNo,timeOpen,timeClosed,dateOpen,dateClosed,supervisor,status from pxUnlocked where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Status");
$this->coconutTableHeader("Time Open");
$this->coconutTableHeader("Time Closed");
$this->coconutTableHeader("Date Open");
$this->coconutTableHeader("Time Closed");
$this->coconutTableHeader("Supervisor");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['status']);
$this->coconutTableData($row['timeOpen']);
$this->coconutTableData($row['timeClosed']);
$this->coconutTableData($row['dateOpen']);
$this->coconutTableData($row['dateClosed']);
$this->coconutTableData($row['supervisor']);
if( $row['supervisor'] == $username && $row['status'] == "Open" ) {
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/currentPatient/locked/unlock.php?unlockNo=$row[unlockNo]&username=$username&registrationNo=$registrationNo'>".$this->coconutImages_return("delete.jpeg")."</a>");
}else {
$this->coconutTableData($this->coconutImages_return("locked1.jpeg"));
}
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public function addPermission($registrationNo,$timeOpen,$dateOpen,$username) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into pxUnlocked(registrationNo,timeOpen,dateOpen,supervisor,status) values('$registrationNo','$timeOpen','$dateOpen','$username','Open')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
//$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/dietary/addDiet.php?username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}




public function returnInventory($itemNo,$registrationNo,$description,$qty,$returnDetails_nod,$returnNOD) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into returnInventory(itemNo,registrationNo,description,qty,returnDetails_nod,returnNOD) values('$itemNo','$registrationNo','$description','$qty','$returnDetails_nod','$returnNOD')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
//$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/dietary/addDiet.php?username=$username");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}



public function showReturnz($registrationNo,$username,$module,$month,$day,$year,$fromTime_hour,$fromTime_minutes,$fromTime_seconds,$toTime_hour,$toTime_minutes,$toTime_seconds,$nod) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select description,returnNo,itemNo,qty from returnInventory where registrationNo = '$registrationNo' and returnDetails_PHARMACY = ''  ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/availableMedicine/returnNow.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&returnNo=$row[returnNo]&username=$username&module=$module&month=$month&day=$day&year=$year&fromTime_hour=$fromTime_hour&fromTime_minutes=$fromTime_minutes&fromTime_seconds=$fromTime_seconds&toTime_hour=$toTime_hour&toTime_minutes=$toTime_minutes&toTime_seconds=$toTime_seconds&nod=$nod'>".$row['description']."</a>");
$this->coconutTableData($row['qty']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();


}


public $walkInSearch_price;

public function walkInSearch($description) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select description,quantity,inventoryType,Added,unitcost,inventoryCode from inventory where description like '$description%%%%%%%' or genericName like '$description%%%%%%' and status not like 'DELETED_%%%%%' and quantity > 0  ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Price");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

if( $row['inventoryType'] == "medicine" ) {
$pricez = preg_split ("/\_/", $row['Added']); 
$this->walkInSearch_price = $pricez[1];
}else {
$this->walkInSearch_price = $row['unitcost'];
}

$this->coconutTableRowStart();
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/Pharmacy/walkin/add.php?inventoryCode=$row[inventoryCode]'>".$row['description']."</a>");
$this->coconutTableData($row['quantity']);
$this->coconutTableData(number_format($this->walkInSearch_price,2));
$this->coconutTableRowStop();
}
$this->coconutTableStop();

}






public function radioApproval($physician,$username,$checkz,$doctorCode,$module) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select radioSavedNo,registrationNo,itemNo,physician from radioSavedReport where approved != 'yes' and physician = '$physician' group by itemNo ") or die("Query fail: " . mysqli_error()); 

$this->coconutFormStart("get","http://".$this->getMyUrl()."/COCONUT/radiology/checkedApproved.php");
$this->coconutHidden("username",$username);
$this->coconutHidden("doctorCode",$doctorCode);
$this->coconutHidden("module",$module);
$this->coconutHidden("checkz",$checkz);
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Procedure");
$this->coconutTableHeader("Details");
$this->coconutTableHeader("");
//$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->coconutTableRowStart();
$this->coconutTableData($this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName() );
$this->coconutTableData($this->selectNow("patientCharges","description","itemNo",$row['itemNo']));
$this->coconutTableData($this->selectNow("radioSavedReport","date","itemNo",$row['itemNo'])."@".$this->selectNow("radioSavedReport","time","itemNo",$row['itemNo']));
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output_doctor.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&description=".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."' target='_blank'><font color=red size=2>View</font></a>");
//$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/radiology/approved.php?radioSavedNo=$row[radioSavedNo]&username=$username&module=DOCTOR&doctorCode=".$this->selectNow("Doctors","doctorCode","Name",$row['physician'])."'><font color=blue size=2>Approved</font></a>");

if( $checkz == "yes" ) {
$this->coconutTableData("<input type='checkbox' name='radioSavedNo[]' value='$row[radioSavedNo]' checked>");
}else {
$this->coconutTableData("<input type='checkbox' name='radioSavedNo[]' value='$row[radioSavedNo]'>");
}

$this->coconutTableRowStop();
}
$this->coconutTableStop();
echo "<Br>";
$this->coconutButton("Approved");
$this->coconutFormStop();
}




public function radioApprovedResult($month,$day,$year,$month1,$day1,$year1,$physician,$username) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$date = $year."-".$month."-".$day;
$date1 = $year1."-".$month1."-".$day1;

$result = mysqli_query($connection, " select radioSavedNo,registrationNo,itemNo,physician from radioSavedReport where (approvedDate between '$date' and '$date1')  and physician = '$physician' ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Procedure");
$this->coconutTableHeader("Details");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->coconutTableRowStart();
$this->coconutTableData($this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName() );
$this->coconutTableData($this->selectNow("patientCharges","description","itemNo",$row['itemNo']));
$this->coconutTableData($this->selectNow("radioSavedReport","date","itemNo",$row['itemNo'])."@".$this->selectNow("radioSavedReport","time","itemNo",$row['itemNo']));
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/Reports/radiologyReport/radioReport_output.php?itemNo=$row[itemNo]&registrationNo=$row[registrationNo]&description=".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."' target='_blank'><font color=red size=2>View</font></a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();

}


public function getFirstCaseRate($icdCode) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select hospital from availableICD where icdCode = '$icdCode' limit 1 ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['hospital'];
}
}



public function countDeptIssued($month,$day,$year,$inventoryCode) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$datez = $year."-".$month."-".$day;

$result = mysqli_query($connection, " select SUM(quantityIssued) as qty from inventoryManager where dateIssued = '$datez' and inventoryCode = '$inventoryCode' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['qty'];
}
}


public function pxReturnInventory($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select description,qty,returnDetails_nod,returnNOD,returnDetails_PHARMACY,returnPHARMACY from returnInventory where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 


$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Return Details");
$this->coconutTableHeader("Return By");
$this->coconutTableHeader("Pharmacy Status");
$this->coconutTableHeader("Pharmacy Staff");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['description']);
$this->coconutTableData($row['qty']);
$this->coconutTableData($row['returnDetails_nod']);
$this->coconutTableData($row['returnNOD']);
$this->coconutTableData($row['returnDetails_PHARMACY']);
$this->coconutTableData($row['returnPHARMACY']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}





public function radiologyPF($date,$date1,$doctors) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";


$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select registrationNo,itemNo,date from radioSavedReport where physician = '$doctors' and (date between '$date' and '$date1') order by date asc ") or die("Query fail: " . mysqli_error()); 

echo "<Center><br><Br><font color=red>$doctors</font><Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Procedure");
$this->coconutTableHeader("Date");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->coconutTableRowStart();
$this->coconutTableData($this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName());
$this->coconutTableData($this->selectNow("patientCharges","description","itemNo",$row['itemNo']));
$this->coconutTableData($row['date']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}



public $receiptTypeReport_total;

public function receiptTypeReport_total() {
return $this->receiptTypeReport_total;
}

public function receiptTypeReport($date,$receiptType,$username,$from,$to) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";


$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select registrationNo,description,orNO,receiptType,cashPaid from patientCharges where datePaid = '$date' and receiptType = '$receiptType' and paidBy = '$username' and (timePaid between '$from' and '$to') and status = 'PAID' order by orNO asc ") or die("Query fail: " . mysqli_error()); 

echo "<Center><br><Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Paid");
$this->coconutTableHeader("OR#");
$this->coconutTableHeader("Type");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->receiptTypeReport_total += $row['cashPaid'];
$this->coconutTableRowStart();
$this->coconutTableData($this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName());
$this->coconutTableData($row['description']);
$this->coconutTableData(number_format($row['cashPaid'],2));
$this->coconutTableData($row['orNO']);
$this->coconutTableData($row['receiptType']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("<b>".number_format($this->receiptTypeReport_total,2)."</b>");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableRowStop();
$this->coconutTableStop();
}



public $receiptTypeReport1_total;

public function receiptTypeReport1_total() {
return $this->receiptTypeReport1_total;
}

public function receiptTypeReport1($date,$receiptType,$username,$from,$to) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";


$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select registrationNo,paymentFor,orNO,receiptType,amountPaid from patientPayment where datePaid = '$date' and receiptType = '$receiptType' and paidBy = '$username' and (timePaid between '$from' and '$to') order by orNO asc ") or die("Query fail: " . mysqli_error()); 

echo "<Center><br><Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Paid");
$this->coconutTableHeader("OR#");
$this->coconutTableHeader("Type");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->receiptTypeReport1_total += $row['amountPaid'];
$this->coconutTableRowStart();
$this->coconutTableData($this->getPatientRecord_lastName().", ".$this->getPatientRecord_firstName());
$this->coconutTableData($row['paymentFor']);
$this->coconutTableData(number_format($row['amountPaid'],2));
$this->coconutTableData($row['orNO']);
$this->coconutTableData($row['receiptType']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("<b>".number_format($this->receiptTypeReport1_total,2)."</b>");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableRowStop();
$this->coconutTableStop();
}





public function listOfLab($registrationNo,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select itemNo,registrationNo,checkerNo from core2_laboratoryResultChecker where registrationNo = '$registrationNo' and status not like 'DELETED_%%%%%%%%%%%' order by checkerNo asc ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Date Released");
$this->coconutTableHeader("Time Released");
$this->coconutTableHeader("MedTech");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($this->selectNow("patientCharges","description","itemNo",$row['itemNo']));
$this->coconutTableData( $this->selectNow("labSavedResult","date","itemNo",$row['itemNo']));
$this->coconutTableData( $this->selectNow("labSavedResult","time","itemNo",$row['itemNo']));
$this->coconutTableData( $this->selectNow("labSavedResult","medtech","itemNo",$row['itemNo']));
$this->coconutTableData( "<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/deleteResult.php?registrationNo=$registrationNo&username=$username&itemNo=$row[itemNo]'>".$this->coconutImages_return("delete.jpeg")."</a>" );
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public function request2bill($registrationNo,$dateRequest,$timeRequest,$requestBy) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into billingRequest(registrationNo,dateRequest,timeRequest,requestBy,status) values('$registrationNo','$dateRequest','$timeRequest','$requestBy','pending')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
$this->gotoPage("http://".$this->getMyUrl()."/COCONUT/patientProfile/patientProfile_right.php?username=$requestBy&registrationNo=$registrationNo");
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}



public function getRequest2bill($date,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select registrationNo,requestBy from billingRequest where dateRequest = '$date' and status = 'pending' ") or die("Query fail: " . mysqli_error()); 

echo "<font size=2 color=red>REQUEST TO BILL</font>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("N.O.D");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<form method='post' action='http://".$this->getMyUrl()."/COCONUT/currentPatient/patientInterface1.php?username=$username&registrationNo=$row[registrationNo]' target='_blank'><input type='submit' style='border:1px solid #000; color:red;' value='".$this->selectNow("patientRecord","lastName","patientNo",$this->selectNow("registrationDetails","patientNo","registrationNo",$row['registrationNo'])).", ".$this->selectNow("patientRecord","firstName","patientNo",$this->selectNow("registrationDetails","patientNo","registrationNo",$row['registrationNo']))."'>
<input type='hidden' name='registrationNo' value='$row[registrationNo]'>
<input type='hidden' name='username' value='$username'>
</form>");
$this->coconutTableData($row['requestBy']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}


public function getPxNameByAttendingDoctor($doctorCode,$date,$date1,$type) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select pc.registrationNo,rd.patientNo from patientCharges pc,registrationDetails rd where pc.registrationNo = rd.registrationNo and pc.chargesCode = '$doctorCode' and pc.title = 'PROFESSIONAL FEE' and pc.service = 'ATTENDING' and pc.status not like 'DELETED_%%%%' order by pc.pxName asc ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
$this->editNow("patientCharges","registrationNo",$row['registrationNo'],"pxName",$this->selectNow("patientRecord","lastName","patientNo",$this->selectNow("registrationDetails","patientNo","registrationNo",$row['registrationNo']))." ".$this->selectNow("patientRecord","firstName","patientNo",$this->selectNow("registrationDetails","patientNo","registrationNo",$row['registrationNo'])));
$this->editNow("patientCharges","registrationNo",$row['registrationNo'],"type",$this->selectNow("registrationDetails","type","registrationNo",$row['registrationNo']));

//if( $result->num_rows > 1 ) {
$this->getPxNameBasedOnDateCharged($date,$date1,$type,$row['registrationNo'],$row['patientNo'],$type);
//echo "1";
//}else { echo "2"; }
}

}


public function getPxChargesByHorizontal($date,$type,$registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pc.description from patientRecord pr,registrationDetails rd,patientCharges pc where pc.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and rd.patientNo = pr.patientNo and pc.dateCharge = '$date' and rd.type='$type' and pc.title='LABORATORY' and pc.status not like 'DELETED_%%%%%%' ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
$result_array[] = "<font size=2>".$row['description']."</font>";
}
return implode(",",$result_array); 

}


public function countDateLabRow($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select count(dateCharge) as totalReg from patientCharges where registrationNo = '$registrationNo' and title = 'LABORATORY' and status not like 'DELETED_%%%%%%%' group by dateCharge  ") or die("Query fail: " . mysqli_error()); 

return $result->num_rows;

}

public function countFirstDateLab($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select  min(dateCharge) as dateCharge from patientCharges where registrationNo = '$registrationNo' and title = 'LABORATORY' and status not like 'DELETED_%%%%%%%' group by dateCharge limit 1  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['dateCharge'];
}

}

public function getPxNameBasedOnDateCharged($date,$date1,$type,$registrationNo,$patientNo,$type) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pc.pxName,pc.dateCharge,pc.registrationNo from patientCharges pc WHERE pc.registrationNo = '$registrationNo' and (pc.dateCharge between '$date' and '$date1') and pc.type='$type' and pc.title='LABORATORY' and pc.status not like 'DELETED_%%%%%%' and pc.pxName != '' group by pc.dateCharge ORDER BY dateCharge asc ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
if( $this->countDateLabRow($registrationNo) > 1 ) {

if( $this->countFirstDateLab($registrationNo) == $row['dateCharge'] ) {
$this->coconutTableData("<font size=2>".$row['pxName']."</font>");
}else {
$this->coconutTableData("<font size=2 color=white>".$row['pxName']."</font>");
}

}else {
$this->coconutTableData("<font size=2>".$row['pxName']."</font>");
}
$this->coconutTableData("<font size=2>".$row['dateCharge']."</font>");
$this->coconutTableData( $this->getPxChargesByHorizontal($row['dateCharge'],$type,$registrationNo) );
$this->coconutTableRowStop();
}

}



public function getRequestedDept($inventoryCode,$date,$date1) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select description,quantityIssued,requestingDepartment,requestingUser,issuedBy,dateRequested,dateIssued from inventoryManager where inventoryCode = '$inventoryCode' and (dateIssued between '$date' and '$date1') and status = 'Received' ") or die("Query fail: " . mysqli_error()); 

echo "<br><br><Center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Dept");
$this->coconutTableHeader("Requested By");
$this->coconutTableHeader("Issued By");
$this->coconutTableHeader("dateRequested");
$this->coconutTableHeader("dateIssued");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['description']);
$this->coconutTableData($row['quantityIssued']);
$this->coconutTableData($row['requestingDepartment']);
$this->coconutTableData($row['requestingUser']);
$this->coconutTableData($row['issuedBy']);
$this->coconutTableData($row['dateRequested']);
$this->coconutTableData($row['dateIssued']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




}








?>
