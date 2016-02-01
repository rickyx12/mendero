<?php
include("myDatabase1.php");

class database2 extends database1 {


public $myHost;
public $username;
public $password;
public $database;

public function __construct() {
  $this->myHost = $_SERVER['DB_HOST'];
  $this->username = $_SERVER['DB_USER'];
  $this->password = $_SERVER['DB_PASS'];
  $this->database = $_SERVER['DB_DB'];
}

function ENCRYPT_DECRYPT($Str_Message) {
    $Len_Str_Message=STRLEN($Str_Message);
    $Str_Encrypted_Message="";
    FOR ($Position = 0;$Position<$Len_Str_Message;$Position++){
        // long code of the function to explain the algoritm
        //this function can be tailored by the programmer modifyng the formula
        //to calculate the key to use for every character in the string.
        $Key_To_Use = (($Len_Str_Message+$Position)*230); // (+5 or *3 or ^2)

        //after that we need a module division because can´t be greater than 255
        //$Key_To_Use = (255+$Key_To_Use) % 255;
	$Key_To_Use = (168+$Key_To_Use) % 168;

        $Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1);
        $Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted);
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
        $Encrypted_Byte = CHR($Xored_Byte);
        $Str_Encrypted_Message .= $Encrypted_Byte;
       
        //short code of  the function once explained
        //$str_encrypted_message .= chr((ord(substr($str_message, $position, 1))) ^ ((255+(($len_str_message+$position)+1)) % 255));
    }
    RETURN $Str_Encrypted_Message;
}


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

if( $this->checkIfLabResultMergeExist($row['itemNo']) == "" ) {
echo "<td>&nbsp;<font class='data'><a href='#'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$row[registrationNo]&itemNo=$row[itemNo]'>(<font color=red size=1>Test Done</font>)</font></a>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='data'><a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/editCharges.php?itemNo=$row[itemNo]&username=$username&show=$show&desc=$desc'>".$row['description']."</a><br>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$registrationNo&itemNo=".$this->selectNow("core2_laboratoryResultChecker","itemNoOfResult","itemNo",$row['itemNo'])."'>(<font color=red size=1>Test Done</font>)</font></a>&nbsp;</td>";
}



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
echo "<td>&nbsp;<font class='data'>".$row['orNO']."</font>&nbsp;</td>";
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


public function addPayment_new($registrationNo,$amountPaid,$datePaid,$timePaid,$paidBy,$paymentFor,$orNo,$paidVia,$pf,$admitting,$control_datePaid,$receiptType,$creditCardNo) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO patientPayment (registrationNo,amountPaid,datePaid,timePaid,paidBy,paymentFor,orNo,paidVia,pf,admitting,control_datePaid,receiptType,creditCardNo)
VALUES
('$registrationNo','$amountPaid','$datePaid','$timePaid','$paidBy','$paymentFor','$orNo','$paidVia','$pf','$admitting','$control_datePaid','$receiptType','$creditCardNo')";

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



public $getPatientRoomCount;

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
$this->getPatientRoomCount++;
echo "<tr>";
if( $this->getPatientRoomCount == 1 ) {
echo "<td>Room</td>";
}else {
echo "<td><font color=white>Room</font></td>";
}
echo "<td>&nbsp;<font size=2>".$room[0]." @ ".$row['sellingPrice']."/day x ".$row['quantity']."</font><br></td>";
echo "</tr>";

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

$result = mysql_query("SELECT itemNo,description,sellingPrice,chargeBy,dateCharge,timeCharge FROM patientCharges WHERE registrationNo = '$registrationNo' and (title = 'LABORATORY' or title = 'MEDICINE' or title = 'RADIOLOGY' or title = 'ECG' or title = 'CARDIOLOGY') and status = 'UNPAID' and discount < 1 ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("Date/Time");
$this->coconutTableHeader("Charged By");
$this->coconutTableRowStop();
$this->coconutFormStart("get","http://".$this->getMyUrl()."/COCONUT/patientProfile/discount/discount1.php");
$this->coconutHidden("registrationNo",$registrationNo);
while($row = mysql_fetch_array($result))
  {

$datetime=$row['dateCharge']." ".$row['timeCharge'];

$this->coconutTableRowStart();
$this->coconutTableData("<input type=checkbox name='itemNo[]' value='$row[itemNo]'>");
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['sellingPrice']);
$this->coconutTableData("&nbsp;".$datetime);
$this->coconutTableData("&nbsp;".$row['chargeBy']);

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





public function addCashCollection($title,$amount,$date,$type,$fromOR,$toOR) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO cashCollection (title,amount,date,control_date,type,fromOR,toOR)
VALUES
('$title','$amount','$date','".date("Y-m-d")."','$type','$fromOR','$toOR')";

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

$date = $year."-".$month."-".$day;
$result = mysql_query("SELECT title,amount,type,fromOR,toOR,collectionNo FROM cashCollection where date = '$date' order by title asc ");


$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Title");
$this->coconutTableHeader("Amount");
$this->coconutTableHeader("OR#");
$this->coconutTableHeader("Type");
$this->coconutTableHeader("&nbsp;");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['title']);
$this->coconutTableData($row['amount']);
$this->coconutTableData("<font size=2>".$row['fromOR']."-".$row['toOR']."</font>");
$this->coconutTableData($row['type']);
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

public function deptInventory($desc,$dept,$username) {


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



$result = mysql_query("SELECT inventoryCode,description,quantity from inventory where (description like '$desc%%%%%%%' or genericName like '$desc%%%%%%%' ) and inventoryLocation='$dept' and status not like 'DELETED_%%%%%%%%%%' order by description asc  ");



echo "<center><table border=1 cellpadding=0 cellspacing=0>";
echo "<tr>";
echo "<th>Description</th>";
echo "<th>QTY</th>";
echo "<th></th>";
echo "</tr>";
while($row = mysql_fetch_array($result))
  {
echo "<tr>";
echo "<td>".$row['description']."</td>";
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/inventory/department/qty.php?inventoryCode=$row[inventoryCode]&department=$dept&description=$row[description]&date=".date("Y-m-d")."&time=".date("H:i:s")."&username=$username' style='color:red; font-size:13px; text-decoration:none;'>Add&nbsp;</a></td>";
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

$result = mysqli_query($connection, " select description,quantity,requestingDepartment,requestingUser,issuedBy,timeRequested,timeIssued from inventoryManager where dateIssued = '$date'  ") or die("Query fail: " . mysqli_error()); 

echo "<Br><br><center>";
echo "<font size=2>Inventory Issued ($date)</font>";
echo "<Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Department");
$this->coconutTableHeader("Request By");
$this->coconutTableHeader("Time Requested");
$this->coconutTableHeader("Issued By");
$this->coconutTableHeader("Time Issued");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
echo "<tr>";
echo "<td>&nbsp;".$row['description']."</td>";
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td>&nbsp;".$row['requestingDepartment']."</td>";
echo "<td>&nbsp;".$row['requestingUser']."</td>";
echo "<td>&nbsp;".$row['timeRequested']."</td>";
echo "<td>&nbsp;".$row['issuedBy']."</td>";
echo "<td>&nbsp;".$row['timeIssued']."</td>";
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



public function returnInventory_pharmacy($itemNo,$registrationNo,$description,$qty,$returnDetails_nod,$returnNOD) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into returnInventory(itemNo,registrationNo,description,qty,returnDetails_nod,returnNOD,returnDetails_PHARMACY,returnPHARMACY) values('$itemNo','$registrationNo','$description','$qty','$returnDetails_nod','$returnNOD','".date("Y-m-d")."@".date("H:i:s")."','$returnDetails_nod')";

 
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

$result = mysqli_query($connection, " select description,returnNo,itemNo,qty,returnDetails_nod,returnNOD from returnInventory where registrationNo = '$registrationNo' and returnDetails_PHARMACY = ''  ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Returned By");
$this->coconutTableHeader("Returned Date-Time");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/availableMedicine/returnNow.php?registrationNo=$registrationNo&itemNo=$row[itemNo]&returnNo=$row[returnNo]&username=$username&module=$module&month=$month&day=$day&year=$year&fromTime_hour=$fromTime_hour&fromTime_minutes=$fromTime_minutes&fromTime_seconds=$fromTime_seconds&toTime_hour=$toTime_hour&toTime_minutes=$toTime_minutes&toTime_seconds=$toTime_seconds&nod=$nod'>".$row['description']."</a>");
$this->coconutTableData($row['qty']);
$this->coconutTableData($row['returnNOD']);
$this->coconutTableData($row['returnDetails_nod']);
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

if( $this->selectNow("registeredUser","module","username",$username) == "ADMIN" ) {
$result = mysqli_query($connection, " select registrationNo,description,orNO,receiptType,cashPaid,quantity from patientCharges where datePaid = '$date' and receiptType = '$receiptType' and (timePaid between '$from' and '$to') and status = 'PAID' order by orNO asc ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " select registrationNo,description,orNO,receiptType,cashPaid,quantity from patientCharges where datePaid = '$date' and receiptType = '$receiptType' and paidBy = '$username' and (timePaid between '$from' and '$to') and status = 'PAID' order by orNO asc ") or die("Query fail: " . mysqli_error()); 
}

echo "<Center><br><Br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
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
$this->coconutTableData($row['quantity']);
$this->coconutTableData(number_format($row['cashPaid'],2));
$this->coconutTableData($row['orNO']);
$this->coconutTableData($row['receiptType']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("");
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
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$registrationNo&itemNo=$row[itemNo]' style='color:black; text-decoration:none;'>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</a>");
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


public function getPxNameByAttendingDoctor($doctorCode,$date,$date1,$type,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select pc.registrationNo,rd.patientNo from patientCharges pc,registrationDetails rd where pc.registrationNo = rd.registrationNo and pc.chargesCode = '$doctorCode' and pc.title = 'PROFESSIONAL FEE' and pc.service = 'ATTENDING' and pc.status not like 'DELETED_%%%%' order by pc.pxName asc ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
$this->editNow("patientCharges","registrationNo",$row['registrationNo'],"pxName",$this->selectNow("patientRecord","lastName","patientNo",$this->selectNow("registrationDetails","patientNo","registrationNo",$row['registrationNo']))." ".$this->selectNow("patientRecord","firstName","patientNo",$this->selectNow("registrationDetails","patientNo","registrationNo",$row['registrationNo'])));
$this->editNow("patientCharges","registrationNo",$row['registrationNo'],"type",$this->selectNow("registrationDetails","type","registrationNo",$row['registrationNo']));

//if( $result->num_rows > 1 ) {
$this->getPxNameBasedOnDateCharged($date,$date1,$type,$row['registrationNo'],$row['patientNo'],$type,$title);
//echo "1";
//}else { echo "2"; }
}

}


public $getPxChargesByHorizontal_total;
public $getPxChargesByHorizontal_grandTotal;

public function getPxChargesByHorizontal_grandTotal() {
return $this->getPxChargesByHorizontal_grandTotal;
}

public function getPxChargesByHorizontal($date,$type,$registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pc.description,total from patientRecord pr,registrationDetails rd,patientCharges pc where pc.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and rd.patientNo = pr.patientNo and pc.dateCharge = '$date' and rd.type='$type' and pc.title='$title' and pc.status not like 'DELETED_%%%%%' ") or die("Query fail: " . mysqli_error()); 

$this->getPxChargesByHorizontal_total = 0;
while($row = mysqli_fetch_array($result))
  {
$result_array[] = "<font size=2>".$row['description']."</font> - <font size=2 color=red>".number_format($row['total'],2)."</font>";
$this->getPxChargesByHorizontal_total += $row['total'];
$this->getPxChargesByHorizontal_grandTotal += $row['total'];
}
return implode(",",$result_array); 

}


public function countDateLabRow($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select count(dateCharge) as totalReg from patientCharges where registrationNo = '$registrationNo' and title = '$title' and status not like 'DELETED_%%%%%%' group by dateCharge  ") or die("Query fail: " . mysqli_error()); 

return $result->num_rows;

}

public function countFirstDateLab($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select  min(dateCharge) as dateCharge from patientCharges where registrationNo = '$registrationNo' and title = '$title' and status not like 'DELETED_%%%%%%' group by dateCharge limit 1  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['dateCharge'];
}

}

public $getPxNameBasedOnDateCharged_rebateTotal;

public function getPxNameBasedOnDateCharged_rebateTotal() {
return $this->getPxNameBasedOnDateCharged_rebateTotal;
}

public function getPxNameBasedOnDateCharged($date,$date1,$type,$registrationNo,$patientNo,$type,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pc.pxName,pc.dateCharge,pc.registrationNo from patientCharges pc WHERE pc.registrationNo = '$registrationNo' and (pc.dateCharge between '$date' and '$date1') and pc.type='$type' and pc.title='$title' and pc.status not like 'DELETED_%%%%%%' and pc.pxName != '' group by pc.dateCharge ORDER BY dateCharge asc ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
if( $this->countDateLabRow($registrationNo,$title) > 1 ) {

if( $this->countFirstDateLab($registrationNo,$title) == $row['dateCharge'] ) {
$this->coconutTableData("<font size=2>".$row['pxName']."</font>");
}else {
$this->coconutTableData("<font size=2 color=white>".$row['pxName']."</font>");
}

}else {
$this->coconutTableData("<font size=2>".$row['pxName']."</font>");
}
$this->coconutTableData("<font size=2>".$row['dateCharge']."</font>");
echo "<td width='40%'>". $this->getPxChargesByHorizontal($row['dateCharge'],$type,$registrationNo,$title)."</td>";

$this->coconutTableData(number_format(($this->getPxChargesByHorizontal_total),2));
$this->coconutTableData( number_format(($this->getPxChargesByHorizontal_total * 0.05 ),2));
$this->getPxNameBasedOnDateCharged_rebateTotal += ( $this->getPxChargesByHorizontal_total * 0.05 );
$this->coconutTableRowStop();
}

}




public function getRequestedDept($inventoryCode,$date,$date1) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$qty=0;
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
$qty+=$row['quantityIssued'];
}
$this->coconutTableRowStart();
$this->coconutTableHeader("TOTAL QUANTITY");
$this->coconutTableHeader($qty);
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
$this->coconutTableStop();
}


public function getRoomForDischarged($registrationNo,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select itemNo,description from patientCharges where registrationNo='$registrationNo' and title = 'Room And Board' and status = 'UNPAID' ") or die("Query fail: " . mysqli_error()); 

echo "<br><br><Center>";
$this->coconutFormStart("get","discharge_new1.php");
$this->coconutHidden("registrationNo",$registrationNo);
$this->coconutHidden("username",$username);
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Description");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<input type='checkbox' name='itemNo[]' value='$row[itemNo]' checked>");
$this->coconutTableData($row['description']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
echo "<br><br>";
$this->coconutButton("Discharged");
$this->coconutFormStop();

}


public function checkAllReturns($registrationNo,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select itemNo from patientCharges where status = 'Return' and registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

if( $result->num_rows > 0 ) {
echo "<font color=red>Unable to Discharge There are pending returns.</font>";
$this->showReturnsBeforeDischarge($registrationNo);
}else {
$this->getRoomForDischarged($registrationNo,$username);
}

}


public function checkAllReturns_notification($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select itemNo from patientCharges where status = 'Return' and registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

if( $result->num_rows > 0 ) {
return "<font color=red size=4>Patient has a pending returns</font>";
}else { }

}

public function checkForDispense_notification($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select itemNo from patientCharges where status = 'UNPAID' and departmentStatus ='' and registrationNo = '$registrationNo' and (title = 'MEDICINE' or title = 'SUPPLIES') ") or die("Query fail: " . mysqli_error()); 

if( $result->num_rows > 0 ) {
return "<font color=red size=4>Patient has a pending meds/sup to dispense</font>";
}else { }

}


public function showReturnsBeforeDischarge($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select  description from patientCharges where status = 'Return' and registrationNo = '$registrationNo'  ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableRowStop();
}

}


public function removePending($registrationNo,$username) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

mysql_query("UPDATE patientCharges SET status = 'DELETED_PENDING_".$username."[".date("Y-m-d")."]'
WHERE registrationNo = '$registrationNo' and (title = 'MEDICINE' or title = 'SUPPLIES') and departmentStatus = '' ");

mysql_close($con);
}


public $getPatientChargesForNewSOA_total_total;
public $getPatientChargesForNewSOA_total_disc;
public $getPatientChargesForNewSOA_total_cashUnpaid;
public $getPatientChargesForNewSOA_total_company;
public $getPatientChargesForNewSOA_total_phic;

public $getPatientChargesForNewSOA_inventory_total_total;
public $getPatientChargesForNewSOA_inventory_total_disc;
public $getPatientChargesForNewSOA_inventory_total_cashUnpaid;
public $getPatientChargesForNewSOA_inventory_total_company;
public $getPatientChargesForNewSOA_inventory_total_phic;




public function getPatientChargesForNewSOA_total_total() {
return $this->getPatientChargesForNewSOA_total_total;
}
public function getPatientChargesForNewSOA_total_disc() {
return $this->getPatientChargesForNewSOA_total_disc;
}
public function getPatientChargesForNewSOA_total_cashUnpaid() {
return $this->getPatientChargesForNewSOA_total_cashUnpaid;
}
public function getPatientChargesForNewSOA_total_company() {
return $this->getPatientChargesForNewSOA_total_company;
}
public function getPatientChargesForNewSOA_total_phic() {
return $this->getPatientChargesForNewSOA_total_phic;
}


public function getPatientChargesForNewSOA_inventory_total_total() {
return $this->getPatientChargesForNewSOA_inventory_total_total;
}
public function getPatientChargesForNewSOA_inventory_total_disc() {
return $this->getPatientChargesForNewSOA_inventory_total_disc;
}
public function getPatientChargesForNewSOA_inventory_total_cashUnpaid() {
return $this->getPatientChargesForNewSOA_inventory_total_cashUnpaid;
}
public function getPatientChargesForNewSOA_inventory_total_company() {
return $this->getPatientChargesForNewSOA_inventory_total_company;
}
public function getPatientChargesForNewSOA_inventory_total_phic() {
return $this->getPatientChargesForNewSOA_inventory_total_phic;
}

public function getPatientChargesForNewSOA($registrationNo,$mode) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


if( $mode == "inventory" ) {
$result = mysqli_query($connection, " SELECT pc.chargesCode,pc.quantity,pc.description,pc.quantity,pc.sellingPrice,pc.dateCharge,pc.discount,pc.total,pc.cashPaid,pc.company,pc.phic,pc.cashUnpaid,pc.title,rd.* from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.status = 'UNPAID' and (pc.title = 'MEDICINE' or pc.title = 'SUPPLIES') and departmentStatus like 'dispensedBy%%%%%%%%%' order by pc.title asc   ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " SELECT pc.chargesCode,pc.quantity,pc.description,pc.quantity,pc.sellingPrice,pc.dateCharge,pc.discount,pc.total,pc.cashPaid,pc.company,pc.phic,pc.cashUnpaid,pc.title,rd.* from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and (pc.status = 'UNPAID' or pc.status = 'Discharged') and (pc.title != 'MEDICINE' and pc.title != 'SUPPLIES') order by pc.title asc   ") or die("Query fail: " . mysqli_error()); 
}


while($row = mysqli_fetch_array($result))
  {

if( $mode == "inventory" ) {
$this->getPatientChargesForNewSOA_inventory_total_total += $row['total'];
$this->getPatientChargesForNewSOA_inventory_total_disc += $row['discount'];
$this->getPatientChargesForNewSOA_inventory_total_cashUnpaid += $row['cashUnpaid'];
$this->getPatientChargesForNewSOA_inventory_total_company += $row['company'];
$this->getPatientChargesForNewSOA_inventory_total_phic += $row['phic'];
}else{
$this->getPatientChargesForNewSOA_total_total += $row['total'];
$this->getPatientChargesForNewSOA_total_disc += $row['discount'];
$this->getPatientChargesForNewSOA_total_cashUnpaid += $row['cashUnpaid'];
$this->getPatientChargesForNewSOA_total_company += $row['company'];
$this->getPatientChargesForNewSOA_total_phic += $row['phic'];
}

echo "<tr>";
echo "<td>&nbsp;".$row['dateCharge']."</td>";
//admission kit change to miscellaneous kpag ang title ay miscellaneous
if( $row['description'] == "admission kit" ) {
echo "<td>&nbsp;<font class='heading' color=red>Miscellaneous</font>&nbsp;</td>";
}else {
echo "<td>&nbsp;<font class='heading'>".$row['description']."</font>&nbsp;</td>";
}
echo "<td>&nbsp;".$row['quantity']."</td>";
echo "<td>&nbsp;".$row['sellingPrice']."</td>";
echo "<td>&nbsp;".$row['discount']."</td>";
echo "<td>&nbsp;".$row['total']."</td>";
echo "<td>&nbsp;".$row['cashUnpaid']."</td>";
echo "<td>&nbsp;".$row['company']."</td>";
echo "<td>&nbsp;".$row['phic']."</td>";
echo "</tr>";
}

}





public function checkIfTitleExist_newDetailed($registrationNo,$title) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$result = mysql_query("SELECT title from patientCharges where registrationNo = '$registrationNo' and title = '$title' ");

while($row = mysql_fetch_array($result))
  {
return mysql_num_rows($result);
  }

}


public $newDetailed_inventory_total;
public $newDetailed_inventory_phic;
public $newDetailed_inventory_company;
public $newDetailed_inventory_discount;

public function newDetailed_inventory_total() {
return $this->newDetailed_inventory_total;
}

public function newDetailed_inventory_phic() {
return $this->newDetailed_inventory_phic;
}

public function newDetailed_inventory_company() {
return $this->newDetailed_inventory_company;
}

public function newDetailed_inventory_discount() {
return $this->newDetailed_inventory_discount;
}

public function newDetailed_inventory($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.phic,pc.company,pc.discount from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and departmentStatus != '' and status != 'PAID' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

$this->newDetailed_inventory_total=0;
$this->newDetailed_inventory_phic=0;
$this->newDetailed_inventory_company=0;
$this->newDetailed_inventory_discount=0;

while($row = mysqli_fetch_array($result))
  {

if( $row['status'] == "UNPAID" ) {
$this->newDetailed_inventory_total += $row['cashUnpaid'];
$this->newDetailed_inventory_phic += $row['phic'];
$this->newDetailed_inventory_company += $row['company'];
$this->newDetailed_inventory_discount += $row['discount'];
}else { }

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['discount']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";

if( $row['status'] == 'UNPAID' ) {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".$row['cashUnpaid']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['phic']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['company']."</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}


echo "</tr>";
}

}




public $newDetailed_inventory_package_total;
public $newDetailed_inventory_package_phic;
public $newDetailed_inventory_package_company;

public function newDetailed_inventory_package_total() {
return $this->newDetailed_inventory_package_total;
}

public function newDetailed_inventory_package_phic() {
return $this->newDetailed_inventory_package_phic;
}

public function newDetailed_inventory_package_company() {
return $this->newDetailed_inventory_package_company;
}

public function newDetailed_inventory_package($registrationNo,$title,$condition) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.phic,pc.company from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and departmentStatus != '' and pc.inventoryFrom $condition 'OB PACKAGE' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

$this->newDetailed_inventory_package_total=0;
$this->newDetailed_inventory_package_phic=0;
$this->newDetailed_inventory_package_company=0;

while($row = mysqli_fetch_array($result))
  {

if( $row['status'] == "UNPAID" ) {
$this->newDetailed_inventory_package_total += $row['cashUnpaid'];
$this->newDetailed_inventory_package_phic += $row['phic'];
$this->newDetailed_inventory_package_company += $row['company'];
}else { }

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>0.00</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";

if( $row['status'] == 'UNPAID' ) {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".$row['cashUnpaid']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['phic']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['company']."</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}


echo "</tr>";
}

}


public $newDetailed_inventory_company1_total;
public $newDetailed_inventory_company1_phic;
public $newDetailed_inventory_company1_company;
public $newDetailed_inventory_company1_company1;

public function newDetailed_inventory_company1_total() {
return $this->newDetailed_inventory_company1_total;
}

public function newDetailed_inventory_company1_phic() {
return $this->newDetailed_inventory_company1_phic;
}

public function newDetailed_inventory_company1_company() {
return $this->newDetailed_inventory_company1_company;
}

public function newDetailed_inventory_company1_company1() {
return $this->newDetailed_inventory_company1_company1;
}


public function newDetailed_inventory_company1($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.phic,pc.company,pc.company1 from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and departmentStatus != '' and status != 'PAID' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

$this->newDetailed_inventory_company1_total=0;
$this->newDetailed_inventory_company1_phic=0;
$this->newDetailed_inventory_company1_company=0;
$this->newDetailed_inventory_company1_company1=0;

while($row = mysqli_fetch_array($result))
  {

if( $row['status'] == "UNPAID" ) {
$this->newDetailed_inventory_company1_total += $row['cashUnpaid'];
$this->newDetailed_inventory_company1_phic += $row['phic'];
$this->newDetailed_inventory_company1_company += $row['company'];
$this->newDetailed_inventory_company1_company1 += $row['company1'];
}else { }

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";

if( $row['status'] == 'UNPAID' ) {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".$row['cashUnpaid']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['phic']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['company']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['company1']."</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}


echo "</tr>";
}

}






public $newDetailed_total;
public $newDetailed_phic;
public $newDetailed_company;
public $newDetailed_discount;

public function newDetailed_total() {
return $this->newDetailed_total;
}

public function newDetailed_phic() {
return $this->newDetailed_phic;
}

public function newDetailed_company() {
return $this->newDetailed_company;
}

public function newDetailed_discount() {
return $this->newDetailed_discount;
}

public function newDetailed($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.phic,pc.company,pc.discount from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and status != 'PAID' and pendingDelete = '' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

$this->newDetailed_total=0;
$this->newDetailed_phic=0;
$this->newDetailed_company=0;
$this->newDetailed_discount=0;

while($row = mysqli_fetch_array($result))
  {
if( $row['status'] == "UNPAID" || $row['status'] == "Discharged" ) {
$this->newDetailed_total += $row['cashUnpaid'];
$this->newDetailed_phic += $row['phic'];
$this->newDetailed_company += $row['company'];
$this->newDetailed_discount += $row['discount'];
}else { }

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['discount']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";

if(( $row['status'] == 'UNPAID' ) || ( $row['status'] == 'Discharged' ) ){
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".number_format($row['cashUnpaid'],2)."</font></td>";
echo "<td>&nbsp;<font size=2>".number_format($row['phic'],2)."</font></td>";
echo "<td>&nbsp;<font size=2>".number_format($row['company'],2)."</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".number_format($row['total'],2)."</font></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}

echo "</tr>";
}

}


public $newDetailed_company1_total;
public $newDetailed_company1_phic;
public $newDetailed_company1_company;
public $newDetailed_company1_company1;

public function newDetailed_company1_total() {
return $this->newDetailed_company1_total;
}

public function newDetailed_company1_phic() {
return $this->newDetailed_company1_phic;
}

public function newDetailed_company1_company() {
return $this->newDetailed_company1_company;
}

public function newDetailed_company1_company1() {
return $this->newDetailed_company1_company1;
}




public function newDetailed_company1($registrationNo,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.phic,pc.company,pc.company1 from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and status != 'PAID' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

$this->newDetailed_company1_total=0;
$this->newDetailed_company1_phic=0;
$this->newDetailed_company1_company=0;
$this->newDetailed_company1_company1=0;

while($row = mysqli_fetch_array($result))
  {
if( $row['status'] == "UNPAID" || $row['status'] == "Discharged" ) {
$this->newDetailed_company1_total += $row['cashUnpaid'];
$this->newDetailed_company1_phic += $row['phic'];
$this->newDetailed_company1_company += $row['company'];
$this->newDetailed_company1_company1 += $row['company1'];
}else { }

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";

if( $row['status'] == 'UNPAID' ) {
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".$row['cashUnpaid']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['phic']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['company']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['company1']."</font></td>";
}else {
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
}

echo "</tr>";
}

}




public function newDetailed_discounted($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.phic,pc.company,pc.discount from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and status != 'PAID' and pc.discount > 0 order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

$this->newDetailed_total=0;
$this->newDetailed_phic=0;
$this->newDetailed_company=0;

while($row = mysqli_fetch_array($result))
  {
if( $row['status'] == "UNPAID" || $row['status'] == "Discharged" ) {
$this->newDetailed_total += $row['cashUnpaid'];
$this->newDetailed_phic += $row['phic'];
$this->newDetailed_company += $row['company'];
}else { }

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['discount']."</font></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";

echo "</tr>";
}

}





public $transferToCompany1_total;
public $transferToCompany1_cash;
public $transferToCompany1_company;
public $transferToCompany1_phic;
public $transferToCompany1_company1;

public function transferToCompany1($registrationNo,$mode,$category) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


if( $category != "" ) {

if( $mode == "cash2company1" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title='$category' and cashUnpaid > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company1_to_cash" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title='$category' and company1 > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company2company1" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title='$category' and company > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company1_to_company" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title='$category' and company1 > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "phic2company1" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title='$category' and phic > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company1_to_phic" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title = '$category' and company1 > 0 ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and title='$category'  ") or die("Query fail: " . mysqli_error()); 
}


}else {

if( $mode == "cash2company1" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and cashUnpaid > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company1_to_cash" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and company1 > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company2company1" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and company > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company1_to_company" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and company1 > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "phic2company1" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and phic > 0 ") or die("Query fail: " . mysqli_error()); 
}else if( $mode == "company1_to_phic" ) {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo' and company1 > 0 ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " select  itemNo,description,sellingPrice,quantity,total,cashUnpaid,phic,company,company1 from patientCharges where (status = 'UNPAID' or status = 'Discharged') and registrationNo = '$registrationNo'  ") or die("Query fail: " . mysqli_error()); 
}

}


$this->coconutFormStart("get","transferNow.php");
$this->coconutHidden("registrationNo",$registrationNo);
$this->coconutHidden("mode",$mode);
echo "<center><br><font color=red>$mode</font>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Total");
$this->coconutTableHeader("CASH");
$this->coconutTableHeader("PHIC");
$this->coconutTableHeader("COMPANY");
$this->coconutTableHeader($this->selectNow("registrationDetails","company1","registrationNo",$registrationNo));
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->transferToCompany1_total += $row['total'];
$this->transferToCompany1_cash += $row['cashUnpaid'];
$this->transferToCompany1_company += $row['company'];
$this->transferToCompany1_phic += $row['phic'];
$this->transferToCompany1_company1 += $row['company1'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<input type='checkbox' name='itemNo[]' value='".$row['itemNo']."' checked=checked>");
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/additionalCompany/editCharges.php?itemNo=$row[itemNo]&description=$row[description]&cashUnpaid=$row[cashUnpaid]&company=$row[company]&phic=$row[phic]&company1=$row[company1]' style='text-decoration:none; color:black;'>".$row['description']."</a>");
$this->coconutTableData("&nbsp;".$row['sellingPrice']);
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("&nbsp;".$row['total']);
$this->coconutTableData("&nbsp;".$row['cashUnpaid']);
$this->coconutTableData("&nbsp;".$row['phic']);
$this->coconutTableData("&nbsp;".$row['company']);
$this->coconutTableData("&nbsp;".$row['company1']);
$this->coconutTableRowStop();
}
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;".number_format($this->transferToCompany1_total,2)."</td>";
echo "<td>&nbsp;".number_format($this->transferToCompany1_cash,2)."</td>";
echo "<td>&nbsp;".number_format($this->transferToCompany1_phic,2)."</td>";
echo "<td>&nbsp;".number_format($this->transferToCompany1_company,2)."</td>";
echo "<td>&nbsp;".number_format($this->transferToCompany1_company1,2)."</td>";
echo "</tr>";

$this->coconutTableStop();
echo "<Br>";
$this->coconutButton("Proceed");
$this->coconutFormStop();

}




public $getLaboratoryReport_paid_total;
public $getLaboratoryReport_paid_discount;

public function getLaboratoryReport_paid_total() {
return $this->getLaboratoryReport_paid_total;
}

public function getLaboratoryReport_paid_discount() {
return $this->getLaboratoryReport_paid_discount;
}

public function getLaboratoryReport_paid($from,$to,$title) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,pc.description,rd.room,pc.cashPaid,pc.discount,pr.Senior,pc.chargeBy,pc.datePaid from patientRecord pr,registrationDetails rd,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (pc.datePaid between '$from' and '$to') and pc.title='$title' and pc.status = 'PAID' order by datePaid asc   ") or die("Query fail: " . mysqli_error()); 

echo "<Br><br><font size=4>Paid via Cash</font>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Room");
$this->coconutTableHeader("Amt Pd");
$this->coconutTableHeader("Disc");
$this->coconutTableHeader("Senior");
$this->coconutTableHeader("chargeBy");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->getLaboratoryReport_paid_total += $row['cashPaid'];
$this->getLaboratoryReport_paid_discount += $row['discount'];

$this->coconutTableRowStart();
$this->coconutTableData($row['datePaid']);
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData($row['description']);
$this->coconutTableData($row['room']);
$this->coconutTableData(number_format($row['cashPaid'],2));
if( $row['discount'] > 0 ) {
$this->coconutTableData(number_format($row['discount'],2));
}else {
$this->coconutTableData("&nbsp;");
}
$this->coconutTableData($row['Senior']);
$this->coconutTableData($row['chargeBy']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<B>TOTAL</b>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_paid_total,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_paid_discount,2));
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();

}


public $getLaboratoryReport_discharged_total;
public $getLaboratoryReport_discharged_phic;
public $getLaboratoryReport_discharged_company;
public $getLaboratoryReport_discharged_company1;
public $getLaboratoryReport_discharged_cashUnpaid;

public function getLaboratoryReport_discharged($from,$to,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.dateUnregistered,rd.room,rd.registrationNo from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and rd.type='IPD' and (rd.dateUnregistered between '$from' and '$to') order by dateUnregistered asc  ") or die("Query fail: " . mysqli_error()); 


echo "<br><br><font size=4>Paid via Discharged</font>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Discharged");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Room");
$this->coconutTableHeader("Cash");
$this->coconutTableHeader("PHIC");
$this->coconutTableHeader("Company");
$this->coconutTableHeader("Company1");
$this->coconutTableHeader("Total");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->getLaboratoryReport_discharged_total += $this->getTotal("total","LABORATORY",$row['registrationNo']);
$this->getLaboratoryReport_discharged_phic += $this->getTotal("phic","LABORATORY",$row['registrationNo']);
$this->getLaboratoryReport_discharged_company += $this->getTotal("company","LABORATORY",$row['registrationNo']);
$this->getLaboratoryReport_discharged_company1 += $this->getTotal("company1","LABORATORY",$row['registrationNo']);
$this->getLaboratoryReport_discharged_cashUnpaid += $this->getTotal("cashUnpaid","LABORATORY",$row['registrationNo']);


$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateUnregistered']);
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['room']);

if( $this->getTotal("cashUnpaid","LABORATORY",$row['registrationNo']) > 0 ) {
$this->coconutTableData("&nbsp;".number_format($this->getTotal("cashUnpaid","LABORATORY",$row['registrationNo']),2));
}else {
$this->coconutTableData("&nbsp;");
}

if( $this->getTotal("phic","LABORATORY",$row['registrationNo']) > 0 ) {
$this->coconutTableData("&nbsp;".number_format($this->getTotal("phic","LABORATORY",$row['registrationNo']),2));
}else {
$this->coconutTableData("&nbsp;");
}

if( $this->getTotal("company","LABORATORY",$row['registrationNo']) > 0 ) {
$this->coconutTableData("&nbsp;".number_format($this->getTotal("company","LABORATORY",$row['registrationNo']),2));
}else {
$this->coconutTableData("&nbsp;");
}

if( $this->getTotal("company1","LABORATORY",$row['registrationNo']) > 0 ) {
$this->coconutTableData("&nbsp;".$this->getTotal("company1","LABORATORY",$row['registrationNo']));
}else {
$this->coconutTableData("&nbsp;");
}

$this->coconutTableData("&nbsp;".number_format($this->getTotal("total","LABORATORY",$row['registrationNo']),2));
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_discharged_cashUnpaid,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_discharged_phic,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_discharged_company,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_discharged_company1,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_discharged_total,2));
$this->coconutTableRowStop();
$this->coconutTableStop();

}


public $getLaboratoryReport_unpaid_cashUnpaid;
public $getLaboratoryReport_unpaid_phic;
public $getLaboratoryReport_unpaid_company;
public $getLaboratoryReport_unpaid_company1;

public function getLaboratoryReport_unpaid($from,$to,$title) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,pc.description,pc.cashUnpaid,pc.phic,pc.company,rd.room,pc.company1,pc.dateCharge from patientRecord pr,registrationDetails rd,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and rd.dateUnregistered != '' and (pc.dateCharge between '$from' and '$to') and pc.title='$title' and status = 'UNPAID' order by dateCharge asc ") or die("Query fail: " . mysqli_error()); 


echo "<br><br>UNPAID";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Room");
$this->coconutTableHeader("CASH");
$this->coconutTableHeader("PHIC");
$this->coconutTableHeader("Company");
$this->coconutTableHeader("Company1");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->getLaboratoryReport_unpaid_cashUnpaid += $row['cashUnpaid'];
$this->getLaboratoryReport_unpaid_phic += $row['phic'];
$this->getLaboratoryReport_unpaid_company += $row['company'];
$this->getLaboratoryReport_unpaid_company1 += $row['company1'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateCharge']);
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['room']);
if( $row['cashUnpaid'] > 0 ) {
$this->coconutTableData("&nbsp;".$row['cashUnpaid']);
}else {
$this->coconutTableData("&nbsp;");
}

if( $row['phic'] > 0 ) {
$this->coconutTableData("&nbsp;".$row['phic']);
}else {
$this->coconutTableData("&nbsp;");
}
if( $row['company'] > 0 ) {
$this->coconutTableData("&nbsp;".$row['company']);
}else {
$this->coconutTableData("&nbsp;");
}

$this->coconutTableData("&nbsp;".$row['company1']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_unpaid_cashUnpaid,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_unpaid_phic,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_unpaid_company,2));
$this->coconutTableData("&nbsp;".number_format($this->getLaboratoryReport_unpaid_company1,2));
$this->coconutTableRowStop();
$this->coconutTableStop();

}



public function prePackage_selection($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select packageName,package_phicPrice,packagePrice from hospitalPackage group by packageName  ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {

echo "<option value='".$row['packageName']."_".$row['packagePrice']."_".$row['package_phicPrice']."'>".$row['packageName']."-".$row['packagePrice']."_".$row['package_phicPrice']."</option>";


}

}



public $oxygenReport_total;

public function oxygenReport($from,$to) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,pc.description,pc.sellingPrice,pc.quantity,pc.total,pc.dateCharge,rd.room from patientRecord pr,registrationDetails rd,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (pc.dateCharge between '$from' and '$to') and pc.title = 'OXYGEN' and status = 'UNPAID' order by pc.dateCharge,pr.lastName  ") or die("Query fail: " . mysqli_error()); 


echo "<Br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Room");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Total");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->oxygenReport_total += $row['total'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateCharge']);
$this->coconutTableData("&nbsp;".$row['lastName'].",".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['room']);
$this->coconutTableData("&nbsp;".$row['description']);
$this->coconutTableData("&nbsp;".$row['sellingPrice']);
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("&nbsp;".$row['total']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<b>TOTAL</b>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->oxygenReport_total,2));
$this->coconutTableRowStop();
$this->coconutTableStop();

}








public function soaSummary_payType($registrationNo,$paymentType) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(amountPaid) as payment from patientPayment where registrationNo='$registrationNo' and paymentFor = '$paymentType' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['payment'];
}

}

public $soaSummary_actual=0;
public $soaSummary_phic=0;
public $soaSummary_company=0;
public $soaSummary_pf=0;
public $soaSummary_deposit=0;
public $soaSummary_cash=0;

public function soaSummary($from,$to) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.registrationNo,rd.dateUnregistered from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and (rd.dateUnregistered between '$from' and '$to') and rd.type = 'IPD' order by rd.dateUnregistered,pr.lastName asc ") or die("Query fail: " . mysqli_error()); 

echo "<br><Br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Discharged");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Actual");
$this->coconutTableHeader("PHIC");
$this->coconutTableHeader("HMO");
$this->coconutTableHeader("PF");
$this->coconutTableHeader("Deposit");
$this->coconutTableHeader("CASH");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$actual = $this->getTotal("total","",$row['registrationNo']);
$phic = $this->getTotal("phic","",$row['registrationNo']);
$company = $this->getTotal("company","",$row['registrationNo']) + $this->getTotal("company1","",$row['registrationNo']);;
$pf = $this->getTotal("cashUnpaid","PROFESSIONAL FEE",$row['registrationNo']);
$deposit = $this->soaSummary_payType($row['registrationNo'],"DEPOSIT");
$cash = $this->soaSummary_payType($row['registrationNo'],"HOSPITAL BILL");

$this->soaSummary_actual += $this->getTotal("total","",$row['registrationNo']);
$this->soaSummary_phic += $this->getTotal("phic","",$row['registrationNo']);
$this->soaSummary_company += $this->getTotal("company","",$row['registrationNo']) + $this->getTotal("company1","",$row['registrationNo']);
$this->soaSummary_pf += $this->getTotal("cashUnpaid","PROFESSIONAL FEE",$row['registrationNo']);
$this->soaSummary_deposit += $this->soaSummary_payType($row['registrationNo'],"DEPOSIT");
$this->soaSummary_cash += $this->soaSummary_payType($row['registrationNo'],"HOSPITAL BILL");

$this->coconutTableRowStart();
$this->coconutTableData($row['registrationNo']);
$this->coconutTableData($row['dateUnregistered']);
$this->coconutTableData(strtoupper($row['lastName'].", ".$row['firstName']));
$this->coconutTableData(number_format($actual,2));
$this->coconutTableData(number_format($phic,2));
$this->coconutTableData(number_format($company,2));
$this->coconutTableData(number_format($pf,2));
$this->coconutTableData(number_format($deposit,2));
$this->coconutTableData(number_format($cash,2));
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<b>TOTAL</b>");
$this->coconutTableData("&nbsp;".number_format($this->soaSummary_actual,2));
$this->coconutTableData("&nbsp;".number_format($this->soaSummary_phic,2));
$this->coconutTableData("&nbsp;".number_format($this->soaSummary_company,2));
$this->coconutTableData("&nbsp;".number_format($this->soaSummary_pf,2));
$this->coconutTableData("&nbsp;".number_format($this->soaSummary_deposit,2));
$this->coconutTableData("&nbsp;".number_format($this->soaSummary_cash,2));
$this->coconutTableRowStop();
$this->coconutTableStop();
}



public function adminSOA($date,$fromTime,$toTime) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.registrationNo from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and rd.dateUnregistered = '$date' and (rd.timeUnregistered between '$fromTime' and '$toTime') and rd.type = 'IPD' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
echo "<td><form method='get' action='http://".$this->getMyUrl()."/COCONUT/patientProfile/SOAoption/summary.php' target='selection1'>
<input type='hidden' name='registrationNo' value='".$row['registrationNo']."'>
<input type='hidden' name='username' value='x'>
<input type='submit' style='width:100%; height:100px;' value='".strtoupper($row['lastName'].", ".$row['firstName'])."'>
</form>
</td>";
$this->coconutTableRowStop();
}

}


public $cashCollection_mmc_total;

public function cashCollection_mmc_total() {
return $this->cashCollection_mmc_total;
}

public function cashCollection_mmc($date,$type) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select title,amount from cashCollection where date='$date' and type='$type'  ") or die("Query fail: " . mysqli_error()); 

$this->cashCollection_mmc_total=0;

while($row = mysqli_fetch_array($result))
  {
$this->cashCollection_mmc_total += $row['amount'];
echo "<tr>";
echo "<td>".$row['title']."</td>";
echo "<td>&nbsp;</td>";
echo "<td>".number_format($row['amount'],2)."</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";
}

}



public function addNameToCashCollection($preparedBy,$billingName,$date) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into cashCollection_preparedBy(preparedBy,billingName,date) values('$preparedBy','$billingName','$date')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}




public $reportWithOR_totalProfit;
public $reportWithOR_totalUnitcost;
public $reportWithOR_totalAmount;


public function reportWithOR($from,$to) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pc.datePaid,pc.orNO,pc.description,pc.quantity,i.unitcost,i.suppliesUNITCOST,i.Added,i.inventoryType from patientCharges pc,inventory i where pc.chargesCode = i.inventoryCode and (pc.datePaid between '$from' and '$to') and pc.status = 'PAID' and (pc.title = 'MEDICINE' or pc.title = 'SUPPLIES') order by pc.datePaid,pc.orNO asc ") or die("Query fail: " . mysqli_error()); 

echo "<font size=3 color=red>Cash Sales of Medicine and Supplies <Br> ( $from to $to )</font>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Date");
$this->coconutTableHeader("OR#");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Unitcost");
$this->coconutTableHeader("Selling Price");
$this->coconutTableHeader("Total<br>Unit Cost");
$this->coconutTableHeader("Total<br>Amount");
$this->coconutTableHeader("Profit/Net");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
if( $row['inventoryType'] == "medicine" ) {
$sprice = preg_split ("/\_/", $row['Added']); //selling price ng medicine
$sp = $sprice[1];
$uc = $row['unitcost'];
}else {
$sp = $row['unitcost']; //selling price ng supplies
$uc = $row['suppliesUNITCOST'];
}

$this->reportWithOR_totalUnitcost += ( $uc * $row['quantity'] );
$this->reportWithOR_totalAmount += ( $sp * $row['quantity'] );
$this->reportWithOR_totalProfit += ($sp * $row['quantity']) - ($uc * $row['quantity']);

$this->coconutTableRowStart();
$this->coconutTableData($row['datePaid']);
$this->coconutTableData($row['orNO']);
$this->coconutTableData($row['description']);
$this->coconutTableData($row['quantity']);
$this->coconutTableData($uc);
$this->coconutTableData($sp);
$this->coconutTableData($uc * $row['quantity']);
$this->coconutTableData($sp * $row['quantity']);
$this->coconutTableData( ($sp * $row['quantity']) - ($uc * $row['quantity']) );
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("<b>TOTAL</b>");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("".number_format($this->reportWithOR_totalUnitcost,2));
$this->coconutTableData("".number_format($this->reportWithOR_totalAmount,2));
$this->coconutTableData(number_format($this->reportWithOR_totalProfit,2));
$this->coconutTableRowStop();

$this->coconutTableStop();
}





public $dischargeWithCompanyAndPHIC_total;
public $dischargeWithCompanyAndPHIC_company;
public $dischargeWithCompanyAndPHIC_phic;

public function dischargeWithCompanyAndPHIC($date1,$date2,$type) {

echo "
<style type='text/css'>
a { text-decoration:none; color:white; }
tr:hover { background-color:yellow;}
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

if( $type == "company" ) {
$result = mysqli_query($connection, " select upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,rd.dateRegistered,rd.dateUnregistered,rd.Company,sum(pc.company) as company,rd.registrationNo from registrationDetails rd,patientRecord pr,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (rd.dateUnregistered between '$date1' and '$date2') and rd.Company != '' and rd.type = 'IPD' group by pc.registrationNo order by rd.timeUnregistered asc") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " select upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,rd.dateRegistered,rd.dateUnregistered,rd.Company,pr.PHIC,sum(pc.phic) as phic,rd.registrationNo from registrationDetails rd,patientRecord pr,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (rd.dateUnregistered between '$date1' and '$date2') and pr.PHIC = 'YES' and rd.type = 'IPD' group by pc.registrationNo order by rd.timeUnregistered asc") or die("Query fail: " . mysqli_error()); 
}


$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Name");
$this->coconutTableHeader("Admitted");
$this->coconutTableHeader("Discharged");
if( $type == "company" ) {
$this->coconutTableHeader("Company");
}else {
$this->coconutTableHeader("PhilHealth");
}
$this->coconutTableHeader("Amount");
$this->coconutTableHeader("Attendiing Doc.");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->dischargeWithCompanyAndPHIC_total += 1;

if( $type == "company" ) {
$this->dischargeWithCompanyAndPHIC_company += $row['company'];
}else {
$this->dischargeWithCompanyAndPHIC_phic += $row['phic'];
}

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['dateRegistered']);
$this->coconutTableData("&nbsp;".$row['dateUnregistered']);
if( $type == "company" ) {
$this->coconutTableData("&nbsp;".$row['Company']);
$this->coconutTableData("&nbsp;".number_format($row['company'],2));
}else {
$this->coconutTableData("&nbsp;".$row['PHIC']);
$this->coconutTableData("&nbsp;".number_format($row['phic'],2));
}
$this->coconutTableData("&nbsp;".$this->getAttendingDoc($row['registrationNo'],"ATTENDING"));
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<font size=3><b>TOTAL PATIENT</b></font>");
$this->coconutTableData("&nbsp;<b>".$this->dischargeWithCompanyAndPHIC_total."</b>");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
if( $type == "company" ) {
$this->coconutTableData("&nbsp;<b>".number_format($this->dischargeWithCompanyAndPHIC_company)."</b>");
}else {
$this->coconutTableData("&nbsp;<b>".number_format($this->dischargeWithCompanyAndPHIC_phic)."</b>");
}

$this->coconutTableRowStop();
$this->coconutTableStop();
}

public $segregatedRoom_total;

public function segregatedRoom($date1,$date2,$roomType) {

echo "
<style type='text/css'>
a { text-decoration:none; color:white; }
tr:hover { background-color:yellow;}
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.room,rd.dateRegistered,rd.dateUnregistered from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and (rd.dateUnregistered between '$date1' and '$date2') and rd.room like '$roomType%%%%%%%%%%' order by pr.lastName asc ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Room");
$this->coconutTableHeader("Confinement");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->segregatedRoom_total += 1;

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['room']);
$this->coconutTableData("&nbsp;".$row['dateRegistered']." to ".$row['dateUnregistered']);
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<b>Total</b>");
$this->coconutTableData("&nbsp;<b>".$this->segregatedRoom_total."</b>");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();
}






public $cashCollection_mmc_monthly_total;

public function cashCollection_mmc_monthly_total() {
return $this->cashCollection_mmc_monthly_total;
}

public function cashCollection_mmc_monthly($date,$date1,$type) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select title,sum(amount) as amount from cashCollection where (date between '$date' and '$date1') and type='$type' group by title  ") or die("Query fail: " . mysqli_error()); 

$this->cashCollection_mmc_monthly_total=0;

while($row = mysqli_fetch_array($result))
  {
$this->cashCollection_mmc_monthly_total += $row['amount'];
echo "<tr>";
echo "<td><a href='http://".$this->getMyUrl()."/COCONUT/Cashier/cashCollection/monthlyDisbursement_details.php?date1=$date&date2=$date1&title=$row[title]' target='_blank' style='text-decoration:none; color:black;'>".$row['title']."</a></td>";
echo "<td>&nbsp;</td>";
echo "<td>".number_format($row['amount'],2)."</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";
}

}

public function cashCollection_mmc_customTotal_monthly($date,$date1,$type) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(amount) as total from cashCollection where (date between '$date' and '$date1') and type='$type'  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
{
return $row['total'];
}

}






/***************** MONTHLY COLLECTION *********************************/

public $partial_monthly;
public $getPartialReport_hb_monthly;
public $getPartialReport_pf_monthly;
public $getPartialReport_admitting_monthly;

public $getPartialReport_hospital_monthly;
public $getPartialReport_medicine_monthly;

public function partial_monthly() {
return $this->partial_monthly;
}
public function getPartialReport_hb_monthly() {
return $this->getPartialReport_hb_monthly;
}
public function getPartialReport_pf_monthly() {
return $this->getPartialReport_pf_monthly;
}
public function getPartialReport_admitting_monthly() {
return $this->getPartialReport_admitting_monthly;
}
public function getPartialReport_hospital_monthly() {
return $this->getPartialReport_hospital_monthly;
}
public function getPartialReport_medicine_monthly() {
return $this->getPartialReport_medicine_monthly;
}



public function getPartialReport_monthly($date1,$date2) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT rd.registrationNo,pp.paidVia,upper(pr.completeName) as completeName,pp.paymentFor,pp.paidBy,pp.datePaid,pp.amountPaid,pp.pf,pp.admitting,pp.receiptType FROM patientPayment pp,patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and pp.registrationNo = rd.registrationNo and rd.registrationNo = pc.registrationNo and (pp.datePaid between '$date1' and '$date2') and paymentFor not in ('REFUND') group by paymentNo order by completeName asc ");



while($row = mysql_fetch_array($result))
  {
$this->partial_monthly+=$row['amountPaid'];
$this->getPartialReport_hb_monthly += $row['amountPaid'];
$this->getPartialReport_pf_monthly += $row['pf'];
$this->getPartialReport_admitting_monthly += $row['admitting'];

if( $row['receiptType'] == "medicine" ) {
$this->getPartialReport_medicine_monthly += $row['amountPaid'];
}else if( $row['receiptType'] == "hospital" ) {
$this->getPartialReport_hospital_monthly += $row['amountPaid'];
}else { }

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




public $collection_salesTotal_monthly;
public $collection_salesUnpaid_monthly;
public $collection_salesPaid_monthly;
public $collection_cash_monthly;
public $collection_creditCard_monthly;
public $collection_medicine_monthly;
public $collection_hospital_monthly;

public function collection_salesTotal_monthly() {
return $this->collection_salesTotal_monthly;
}

public function collection_salesUnpaid_monthly() {
return $this->collection_salesUnpaid_monthly;
}

public function collection_salesPaid_monthly() {
return $this->collection_salesPaid_monthly;
}

public function collection_cash_monthly() {
return $this->collection_cash_monthly;
}

public function collection_creditCard_monthly() {
return $this->collection_creditCard_monthly;
}

public function collection_medicine_monthly() {
return $this->collection_medicine_monthly;
}

public function collection_hospital_monthly() {
return $this->collection_hospital_monthly;
}


//COLLLECTION REPORT CASHIER
public function getCashierReport_monthly($date1,$date2) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



$result = mysql_query("SELECT upper(pr.completeName) as completeName,pc.description,pc.sellingPrice,pc.quantity,pc.title,pc.orNO,receiptType,pc.discount,pc.total,pc.cashUnpaid,pc.cashPaid,pc.paidBy,pc.paidVia FROM patientRecord pr,registrationDetails rd,patientCharges pc WHERE pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (pc.datePaid between '$date1' and '$date2') and (pc.status='PAID') group by pc.itemNo order by pc.title,completeName asc ");

$this->collection_salesTotal_monthly=0;
$this->collection_salesUnpaid_monthly=0;
$this->collection_salesPaid_monthly=0;
while($row = mysql_fetch_array($result))
  {

$price = preg_split ("/\//", $row['sellingPrice']); 

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['completeName']."</font>&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font>&nbsp;<br><font size=2 color=red>OR#:".$row['orNO']."</font></td>";
echo "<td>&nbsp;<font size=2>".$price[0]."</font>&nbsp;</td>";
//echo "<td>&nbsp;".number_format($row['quantity'],2)."&nbsp;</td>";
//echo "<td>&nbsp;".number_format($row['discount'],2)."&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".number_format($row['total'],2)."</font>&nbsp;</td>";
//echo "<td>&nbsp;".number_format($row['cashUnpaid'],2)."&nbsp;</td>";
echo "<td>&nbsp;<font size=2>".number_format($row['cashPaid'],2)." - (".$row['paidVia'].")</font>&nbsp;</td>";
echo "<td>&nbsp;<a href='#'><font size=2>".$row['paidBy']."</font></a>&nbsp;</td>";

echo "<td>&nbsp;<font size=2>".number_format($row['cashPaid'],2)."</font>&nbsp;</td>";
$this->collection_salesTotal_monthly+=$row['total'];
$this->collection_salesUnpaid_monthly+=$row['cashUnpaid'];
$this->collection_salesPaid_monthly+=$row['cashPaid'];

if($row['paidVia'] == "Cash") {
$this->collection_cash_monthly += $row['cashPaid'];
}else {
$this->collection_creditCard_monthly += $row['cashPaid'];
}

if( $row['receiptType'] == "medicine" ) {
$this->collection_medicine_monthly += $row['cashPaid'];
}else if( $row['receiptType'] == "hospital" ) {
$this->collection_hospital_monthly += $row['cashPaid'];
}
else {

}


echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";  

}



}



public $othersPartial_monthly;

public function othersPartial_monthly() {
return $this->othersPartial_monthly;
}

public function getOthersPartialReport_monthly($date1,$date2) {

echo "
<style type='text/css'>
tr:hover { background-color:yellow; color:black;}
a { text-decoration:none; color:black; }
</style>";


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);



$result = mysql_query("SELECT * FROM patientPayment pp WHERE (pp.datePaid between '$date1' and '$date2') and paymentFor not in ('BILLED') and registrationNo like 'manual_%%%%%%' group by paymentNo order by registrationNo asc ");




//$this->collection_salesTotal=0;
//$this->collection_salesUnpaid=0;
//$this->collection_salesPaid=0;
while($row = mysql_fetch_array($result))
  {
$this->othersPartial_monthly+=$row['amountPaid'];
$px = preg_split ("/\_/", $row['registrationNo']); 

echo "<tr>";
echo "<td>&nbsp;<font color=red>".$px[1]."</font>&nbsp;</td>";
echo "<td>&nbsp;".$row['paymentFor']."&nbsp;</td>";
echo "<td>&nbsp;".$row['amountPaid']."&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<td>&nbsp;".number_format($row['amountPaid'],2)."&nbsp;</td>";
echo "<td>&nbsp;".$row['paidBy']."&nbsp;</td>";
echo "<td>&nbsp;".number_format($row['amountPaid'],2)."&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
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
echo "<tr>";
echo "<td>&nbsp;<B>TOTAL</b></tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;<B>".number_format($this->othersPartial_monthly,2)."</b></tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;<B>".number_format($this->othersPartial_monthly,2)."</b></tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "</tr>";

}




public $showExpenses_total_monthly;

public function showExpenses_total_monthly() {
return $this->showExpenses_total_monthly;
}

public function showExpenses_monthly($date1,$date2) {

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


$result = mysql_query("SELECT amount,payee,date,user,description FROM vouchers WHERE (date between '$date1' and '$date2') ");


while($row = mysql_fetch_array($result))
  {
echo "<tr>";
$this->showExpenses_total_monthly += $row['amount'];
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
echo "<td>&nbsp;<b>".number_format($this->showExpenses_total_monthly)."</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

}




public $totalRefunds_monthly;

public function totalRefunds_monthly() {
return $this->totalRefunds_monthly;
}

public function showRefunds_monthly($date1,$date2) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select paymentFor,registrationNo,amountPaid,paidBy from patientPayment where (datePaid between '$date1' and '$date2') and paymentFor = 'REFUND'  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
$this->getPatientProfile($row['registrationNo']);
$this->totalRefunds_monthly += $row['amountPaid'];
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




/******************** END OF MONTHLY COLLLECTION ***********************/



public function getTopDoctors($date1,$date2,$service) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select pc.description,count(rd.registrationNo) as totalPx,pc.chargesCode from registrationDetails rd,patientCharges pc,patientRecord pr where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (rd.dateRegistered between '$date1' and '$date2') and pc.title = 'PROFESSIONAL FEE' and pc.service = '$service' and rd.type = 'IPD' and pc.status = 'UNPAID' group by pc.chargesCode order by totalPx desc limit 20  ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Doctor");
$this->coconutTableHeader("No. Of Px");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
echo "<tr>";
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/graphicalReport/bestSelling/monthlyRangeDoctor2.php?date1=$date1&date2=$date2&service=$service&chargesCode=$row[chargesCode]' target='selection1'>".$row['description']."</a>");
$this->coconutTableData($row['totalPx']);
echo "</tr>";
}
$this->coconutTableStop();
}




public $getTopDoctors_with_px_total;

public function getTopDoctors_with_px($date1,$date2,$service,$chargesCode) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.dateRegistered from registrationDetails rd,patientCharges pc,patientRecord pr where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and (rd.dateRegistered between '$date1' and '$date2') and pc.title = 'PROFESSIONAL FEE' and pc.service = '$service' and rd.type = 'IPD' and pc.status = 'UNPAID' and pc.chargesCode = '$chargesCode' order by pr.lastName ") or die("Query fail: " . mysqli_error()); 

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Name");
$this->coconutTableHeader("Admitted");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->getTopDoctors_with_px_total += 1;

echo "<tr>";
$this->coconutTableData(strtoupper($row['lastName']).",".strtoupper($row['firstName']));
$this->coconutTableData($row['dateRegistered']);
echo "</tr>";
}
echo "<tr>";
$this->coconutTableData("<b>Total Patients</b>");
$this->coconutTableData("<b>".$this->getTopDoctors_with_px_total."</b>");
echo "</tr>";
$this->coconutTableStop();
}



public $monthlyCashCollection_disbursement_details_total;


public function monthlyCashCollection_disbursement_details($date1,$date2,$title) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT title,amount,date FROM cashCollection WHERE title = '$title' AND (date between '$date1' and '$date2') AND type = 'Disbursement' ") or die("Query fail: " . mysqli_error()); 

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Title");
$this->coconutTableHeader("Amount");
$this->coconutTableHeader("Date");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->monthlyCashCollection_disbursement_details_total += $row['amount'];

echo "<tr>";
$this->coconutTableData($row['title']);
$this->coconutTableData(number_format($row['amount'],2));
$this->coconutTableData($row['date']);
echo "</tr>";
}
echo "<tr>";
$this->coconutTableData("<b>TOTAL</b>");
$this->coconutTableData("<b>".number_format($this->monthlyCashCollection_disbursement_details_total,2)."</b>");
echo "</tr>";
$this->coconutTableStop();
}





public $getCompanyPayment_total;
public $getCompanyPayment_discount;
public $getCompanyPayment_tax;

public function getCompanyPayment_total() {
return $this->getCompanyPayment_total;
}
public function getCompanyPayment_discount() {
return $this->getCompanyPayment_discount;
}
public function getCompanyPayment_tax() {
return $this->getCompanyPayment_tax;
}

public function getCompanyPayment($registrationNo,$company) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

.txtSize {
	font-family: 'Times New Roman';
	font-size: 13px;
	color: #000000;
.Arial10Red {font-family: Arial;font-size: 10px;color: #FF0000;}
.Arial10Blue {font-family: Arial;font-size: 10px;color: #0066FF;}
.Arial11White {font-family: Arial;font-size: 11px;color: #FFFFFF;}
.Arial11Black {font-family: Arial;font-size: 11px;color: #000000;}
.Arial11BlackBold {font-family: Arial;font-size: 11px;color: #000000;}
.Arial11BlackBoldNoDeco {font-family: Arial;font-size: 11px;font-weight: bold;color: #000000;}
.Arial14Black {font-family: Arial;font-size: 14px;color: #000000;}
.Arial14BlackBold {font-family: Arial;font-size: 14px;font-weight: bold;color: #000000;}
}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

//$result = mysqli_query($connection, " SELECT refNo,amountPaid,tax,discount,company,datePaid,postBy,paymentFor,doctor,itemNo from companyPayment where registrationNo = '$registrationNo' and company = '$company' and status not like 'DELETED%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

$result = mysqli_query($connection, " SELECT refNo,amountPaid,tax,discount,company,datePaid,postBy,paymentFor,doctor,itemNo from companyPayment where registrationNo = '$registrationNo' and status not like 'DELETED%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {

$this->getCompanyPayment_total += $row['amountPaid'];
$this->getCompanyPayment_discount += $row['discount'];
$this->getCompanyPayment_tax += $row['tax'];

echo "<tr>";
if( $row['paymentFor'] == "HOSPITAL BILL" ) {
echo "<td><div align='left'><span class='Arial11BlackBold'>&nbsp;".$row['company']."&nbsp;<br>&nbsp;".$row['paymentFor']."&nbsp;</span><br><span class='Arial10Blue'>&nbsp;REF#".$row['refNo']." w/ tax=$row[tax]&nbsp;</span><br><span class='Arial10Blue'>&nbsp;Disc=$row[discount]&nbsp;</span></div></td>";
}else {
echo "<td><div align='left'><span class='Arial11BlackBold'>&nbsp;".$row['company']."&nbsp;<br>&nbsp;".$row['doctor']."&nbsp;<br>&nbsp;".$row['paymentFor']."&nbsp;</span><br><span class='Arial10Blue'>&nbsp;REF#".$row['refNo']." w/ tax=$row[tax]&nbsp;</span><br><span class='Arial10Blue'>&nbsp;Disc=$row[discount]&nbsp;</span></div></td>";
}

echo "<td></td>";
echo "<td></td>";
echo "<td><div align='right'><span class='Arial11Black'>".number_format(($row['amountPaid']),2)."&nbsp;</span></div></td>";
echo "<td></td>";
echo "</tr>";
}

}



public function addCompanyPayment($refNo,$checkNo,$registrationNo,$amount,$tax,$discount,$company,$date,$postBy,$paymentFor,$doctor,$itemNo,$companyName,$columnToGet) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into companyPayment(refNo,checkNo,registrationNo,amountPaid,tax,discount,company,datePaid,postBy,dateEncoded,paymentFor,doctor,itemNo,companyName,columnToGet) values('$refNo','$checkNo','$registrationNo','$amount','$tax','$discount','$company','$date','$postBy','".date("Y-m-d")."','$paymentFor','$doctor','$itemNo','$companyName','$columnToGet')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}




public $viewCompanyPayment_total;

public function viewCompanyPayment($registrationNo,$username) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

.txtSize1 {
	font-family: 'Arial';
	font-size: 13px;
	color: #FFFFFF;
}

.txtSize2 {
	font-family: 'Arial';
	font-size: 13px;
	color: 000000;
}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT paymentNo,refNo,checkNo,amountPaid,tax,discount,company,datePaid,postBy,paymentFor,doctor,itemNo,columnToGet from companyPayment where registrationNo = '$registrationNo' and status = '' order by paymentFor,datePaid asc ") or die("Query fail: " . mysqli_error()); 

echo "<br><br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("<span class='txtSize1'>Ref#</span>");
$this->coconutTableHeader("<span class='txtSize1'>Check#</span>");
$this->coconutTableHeader("<span class='txtSize1'>Payment For</span>");
$this->coconutTableHeader("<span class='txtSize1'>Payables</span>");
$this->coconutTableHeader("<span class='txtSize1'>Amount Paid</span>");
$this->coconutTableHeader("<span class='txtSize1'>Tax</span>");
$this->coconutTableHeader("<span class='txtSize1'>Discount</span>");
$this->coconutTableHeader("<span class='txtSize1'>Balance</span>");
$this->coconutTableHeader("<span class='txtSize1'>Company</span>");
$this->coconutTableHeader("<span class='txtSize1'>Date Paid</span>");
$this->coconutTableHeader("Post By");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->viewCompanyPayment_total += $row['amountPaid'];

echo "<tr>";
$this->coconutTableData("<span class='txtSize2'>".$row['refNo']."</span>");
$this->coconutTableData("<span class='txtSize2'>".$row['checkNo']."</span>");

if( $row['paymentFor'] == "HOSPITAL BILL" ) {
$this->coconutTableData("<span class='txtSize2'>".$row['paymentFor']."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize2'>".number_format($this->summaryCompany_hospitalBill($registrationNo,$row['columnToGet']),2)."</span>");
}else {
$this->coconutTableData("<span class='txtSize2'>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize2'>".number_format($this->summaryCompany_professionalFee($registrationNo,$row['itemNo'],$row['columnToGet']),2)."</span>");
}


$this->coconutTableData("<span class='txtSize2'>".number_format($row['amountPaid'],2)."</span>");
$this->coconutTableData("<span class='txtSize2'>".$row['tax']."</span>");
$this->coconutTableData("<span class='txtSize2'>".$row['discount']."</span>");

$val=$row['tax'] + $row['discount'];

if( $row['paymentFor'] == "HOSPITAL BILL" ) {
$this->coconutTableData("&nbsp;<span class='txtSize2'>".number_format((( $this->summaryCompany_hospitalBill($registrationNo,$row['columnToGet']) - $this->summaryCompanyPayment_hospitalBill($registrationNo) )* (-0)),2)."</span>");
}else {
$this->coconutTableData("&nbsp;<span class='txtSize2'>".number_format(( $this->summaryCompany_professionalFee($registrationNo,$row['itemNo'],$row['columnToGet']) - $this->summaryCompanyPayment_professionalFee($registrationNo,$row['itemNo']) ),2)."</span>");
}



$this->coconutTableData("<span class='txtSize2'>".$row['company']."</span>");
$this->coconutTableData("<span class='txtSize2'>".$row['datePaid']."</span>");
$this->coconutTableData("<span class='txtSize2'>".$row['postBy']."</span>");
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/Payments/deleteCompanyPayment.php?paymentNo=$row[paymentNo]&registrationNo=$registrationNo&refNo=$row[refNo]&amountPaid=$row[amountPaid]&datePaid=$row[datePaid]&username=$username'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a> ");
echo "</tr>";
}

echo "<tr>";
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
echo "</tr>";


$this->coconutTableStop();
}



public function addPHICPayment($refNo,$checkNo,$registrationNo,$amount,$tax,$date,$postBy,$paymentFor,$itemNo) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into phicPayment(refNo,checkNo,registrationNo,amountPaid,tax,datePaid,postBy,dateEncoded,paymentFor,itemNo) values('$refNo','$checkNo','$registrationNo','$amount','$tax','$date','$postBy','".date("Y-m-d")."','".$paymentFor."','".$itemNo."')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}


public $viewPHICPayment_total;

public function viewPHICPayment($registrationNo,$username) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT phicPaymentNo,refNo,checkNo,amountPaid,tax,datePaid,postBy,paymentFor,itemNo from phicPayment where registrationNo = '$registrationNo' and status = '' ") or die("Query fail: " . mysqli_error()); 

echo "<br><br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Ref#");
$this->coconutTableHeader("Check#");
$this->coconutTableHeader("Payment For");
$this->coconutTableHeader("Amount Paid");
$this->coconutTableHeader("Tax");
$this->coconutTableHeader("Date Paid");
$this->coconutTableHeader("Post By");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->viewPHICPayment_total += $row['amountPaid'];

echo "<tr>";
$this->coconutTableData($row['refNo']);
$this->coconutTableData($row['checkNo']);

if( $row['paymentFor'] == "HOSPITAL BILL" ) {
$this->coconutTableData($row['paymentFor']);
}else {
$this->coconutTableData($this->selectNow("patientCharges","description","itemNo",$this->selectNow("phicPayment","itemNo","phicPaymentNo",$row['phicPaymentNo'])));
}
$this->coconutTableData(number_format($row['amountPaid'],2));
$this->coconutTableData($row['tax']);
$this->coconutTableData($row['datePaid']);
$this->coconutTableData($row['postBy']);
$this->coconutTableData(" <a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/Payments/deletePHICPayment.php?phicPaymentNo=$row[phicPaymentNo]&registrationNo=$registrationNo&refNo=$row[refNo]&amountPaid=$row[amountPaid]&datePaid=$row[datePaid]&username=$username'><img src='http://".$this->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a> ");
echo "</tr>";
}

echo "<tr>";
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
echo "</tr>";

echo "<tr>";
$this->coconutTableData("<b>TOTAL</b>");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("&nbsp;<b>".number_format($this->viewPHICPayment_total,2)."</b>");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
$this->coconutTableData("");
echo "</tr>";

$this->coconutTableStop();
}


public $getPHICPayment_total;

public function getPHICPayment_total() {
return $this->getPHICPayment_total;
}

public function getPHICPayment($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}
.txtSize {
	font-family: 'Times New Roman';
	font-size: 13px;
	color: #000000;
.Arial10Red {font-family: Arial;font-size: 10px;color: #FF0000;}
.Arial10Blue {font-family: Arial;font-size: 10px;color: #0066FF;}
.Arial11White {font-family: Arial;font-size: 11px;color: #FFFFFF;}
.Arial11Black {font-family: Arial;font-size: 11px;color: #000000;}
.Arial11BlackBold {font-family: Arial;font-size: 11px;color: #000000;}
.Arial11BlackBoldNoDeco {font-family: Arial;font-size: 11px;font-weight: bold;color: #000000;}
.Arial14Black {font-family: Arial;font-size: 14px;color: #000000;}
.Arial14BlackBold {font-family: Arial;font-size: 14px;font-weight: bold;color: #000000;}
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT refNo,amountPaid,tax,datePaid,postBy from phicPayment where registrationNo = '$registrationNo' and status not like 'DELETED%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {

$this->getPHICPayment_total += ($row['amountPaid']+$row['tax']);

echo "<tr>";
echo "<td><div align='left'><span class='Arial11BlackBold'>&nbsp;PhilHealth&nbsp;</span><br><span class='Arial10Blue'>&nbsp;REF#".$row['refNo']." w/ tax=$row[tax]&nbsp;</span></td>";
echo "<td></td>";
echo "<td><div align='right'><span class='Arial11Black'>&nbsp;".number_format($row['amountPaid'])."&nbsp;</span></div></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
}

}



public function getCashPayment_details($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(amountPaid) as paid from patientPayment where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
return $row['paid'];
}

}



public $getCompanyPayment_details_paid;
public $getCompanyPayment_details_tax;
public $getCompanyPayment_details_discount;

public function getCompanyPayment_details_paid() {
return $this->getCompanyPayment_details_paid;
}

public function getCompanyPayment_details_tax() {
return $this->getCompanyPayment_details_tax;
}

public function getCompanyPayment_details_discount() {
return $this->getCompanyPayment_details_discount;
}

public function getCompanyPayment_details($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(amountPaid) as paid,sum(tax) as tax,sum(discount) as discount from companyPayment where registrationNo = '$registrationNo' and status not like 'DELETED%%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
$this->getCompanyPayment_details_paid = $row['paid'];
$this->getCompanyPayment_details_tax = $row['tax'];
$this->getCompanyPayment_details_discount = $row['discount'];
}

}


public $getPHICPayment_details_paid;
public $getPHICPayment_details_tax;


public function getPHICPayment_details_paid() {
return $this->getPHICPayment_details_paid;
}

public function getPHICPayment_details_tax() {
return $this->getPHICPayment_details_tax;
}


public function getPHICPayment_details($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(amountPaid) as paid,sum(tax) as tax from phicPayment where registrationNo = '$registrationNo' and status not like 'DELETED%%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {
$this->getPHICPayment_details_paid = $row['paid'];
$this->getPHICPayment_details_tax = $row['tax'];
}

}



public function summaryCompanyPayment_hospitalBill($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(amountPaid+tax) as paid from companyPayment where registrationNo = '$registrationNo' and paymentFor = 'HOSPITAL BILL' and status not like 'DELETED%%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {

return $row['paid'];

}

}

public function summaryCompany_hospitalBill($registrationNo,$cols) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum($cols) as company from patientCharges where registrationNo = '$registrationNo' and status not like 'DELETED%%%%%%%' and title != 'PROFESSIONAL FEE' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['company'];
}

}


public function summaryCompanyPayment_professionalFee($registrationNo,$itemNo) { //payment pf

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(cp.amountPaid) as paidPF from companyPayment cp,patientCharges pc where cp.registrationNo = '$registrationNo' and pc.registrationNo = '$registrationNo' and pc.itemNo = '$itemNo' and pc.itemNo = cp.itemNo and cp.paymentFor = 'PROFESSIONAL FEE' and cp.status not like 'DELETED%%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['paidPF'];
}

}


public function summaryCompany_professionalFee($registrationNo,$itemNo,$cols) { //payables pf

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum($cols) as company from patientCharges where registrationNo = '$registrationNo' and status not like 'DELETED%%%%%%%' and title = 'PROFESSIONAL FEE' and itemNo = '$itemNo' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['company'];
}

}





public $companyPaymentReport_total;
public $companyPaymentReport_discount;
public $companyPaymentReport_tax;

public function companyPaymentReport($datePaid,$datePaid1,$dateSource) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

.txtSize {
	font-family: 'Times New Roman';
	font-size: 13px;
	color: #FFFFFF;
}


.txtSize1 {
	font-family: 'Arial';
	font-size: 13px;
	color: #000000;
}

.txtSizeDate {
	font-family: 'Arial';
	font-size: 11px;
	color: #000000;
}

.txtSize_hbBalance {
	font-family: 'Arial';
	font-size: 13px;
	color: #FF0000;
}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT pr.lastName,pr.firstName,rd.registrationNo,cp.company,cp.amountPaid,cp.datePaid,cp.tax,cp.discount,cp.refNo,cp.checkNo,cp.postBy,cp.paymentFor,cp.itemNo,cp.columnToGet from patientRecord pr,registrationDetails rd,companyPayment cp where pr.patientNo = rd.patientNo and rd.registrationNo = cp.registrationNo and (cp.$dateSource between '$datePaid' and '$datePaid1') and cp.status not like 'DELETED%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 


$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("<span class='txtSize'>Ref#</span>");
$this->coconutTableHeader("<span class='txtSize'>Check#</span>");
$this->coconutTableHeader("<span class='txtSize'>Reg#</span>");
$this->coconutTableHeader("<span class='txtSize'>Patient</span>");
$this->coconutTableHeader("<span class='txtSize'>Company</span>");
$this->coconutTableHeader("<span class='txtSize'>Payment For</span>");
$this->coconutTableHeader("<span class='txtSize'>Payables</span>");
$this->coconutTableHeader("<span class='txtSize'>AmountPaid</span>");
$this->coconutTableHeader("<span class='txtSize'>Tax</span>");
$this->coconutTableHeader("<span class='txtSize'>Disc</span>");
$this->coconutTableHeader("<span class='txtSize'>Balance</span>");
$this->coconutTableHeader("<span class='txtSize'>Date Posted</span>");
$this->coconutTableHeader("<span class='txtSize'>User</span>");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->companyPaymentReport_total += $row['amountPaid'];
$this->companyPaymentReport_tax += $row['tax'];
$this->companyPaymentReport_discount += $row['discount'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<span class='txtSize1'
>".$row['refNo']."</font></span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['checkNo']."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['registrationNo']."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".strtoupper($row['lastName']).", ".strtoupper($row['firstName'])."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['company']."</span>");

if( $row['paymentFor'] == "HOSPITAL BILL" ) {
$this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['paymentFor']."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".number_format($this->summaryCompany_hospitalBill($row['registrationNo'],$row['columnToGet']),2)."</span>");
}else {
$this->coconutTableData("&nbsp;<span class='txtSize1'>".$this->selectNow("patientCharges","description","itemNo",$row['itemNo'])."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".number_format($this->summaryCompany_professionalFee($row['registrationNo'],$row['itemNo'],$row['columnToGet']),2)."</span>");
}

$this->coconutTableData("&nbsp;<span class='txtSize1'>".number_format($row['amountPaid'],2)."</span>");
( $row['tax'] != "" ) ? $this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['tax']."</span>") : $this->coconutTableData("");
( $row['discount'] != "" ) ? $this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['discount']."</span>") : $this->coconutTableData("");


if( $row['paymentFor'] == "HOSPITAL BILL" ) {
$this->coconutTableData("&nbsp;<span class='txtSize_hbBalance'>".number_format(( $this->summaryCompany_hospitalBill($row['registrationNo'],$row['columnToGet']) - $this->summaryCompanyPayment_hospitalBill($row['registrationNo']) ),2)."</span>");
}else {
$this->coconutTableData("&nbsp;<span class='txtSize_hbBalance'>".number_format(( $this->summaryCompany_professionalFee($row['registrationNo'],$row['itemNo'],$row['columnToGet']) - $this->summaryCompanyPayment_professionalFee($row['registrationNo'],$row['itemNo']) ),2)."</span>");
}


$this->coconutTableData("<span class='txtSizeDate'>".$this->reformatDate($row['datePaid'])."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize1'>".$row['postBy']."</span>");

}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->companyPaymentReport_total,2));
($this->companyPaymentReport_tax != "") ? $this->coconutTableData("&nbsp;".number_format($this->companyPaymentReport_tax,2)) : $this->coconutTableData("&nbsp;");
($this->companyPaymentReport_discount != "") ? $this->coconutTableData("&nbsp;".number_format($this->companyPaymentReport_discount,2)) : $this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();

}



public $currentAdmittedPatient_inventory_cash;
public $currentAdmittedPatient_inventory_phic;
public $currentAdmittedPatient_inventory_company;

public function currentAdmittedPatient_inventory_cash() {
return $this->currentAdmittedPatient_inventory_cash;
}
public function currentAdmittedPatient_inventory_phic() {
return $this->currentAdmittedPatient_inventory_phic;
}
public function currentAdmittedPatient_inventory_company() {
return $this->currentAdmittedPatient_inventory_company;
}


public function currentAdmittedPatient_inventory($room) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(pc.cashUnpaid) as cash,sum(pc.phic) as phic,sum(pc.company) as company from patientRecord pr,registrationDetails rd,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and rd.room = '$room' and rd.type = 'IPD' and rd.dateUnregistered = '' and (pc.status = 'UNPAID' or pc.status = 'Return') and (pc.title = 'MEDICINE' or pc.title = 'SUPPLIES') and pc.departmentStatus like 'dispensedBy%%%%%%%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
$this->currentAdmittedPatient_inventory_cash = $row['cash'];
$this->currentAdmittedPatient_inventory_phic = $row['phic'];
$this->currentAdmittedPatient_inventory_company = $row['company'];
}

}




public $currentAdmittedPatient_name;
public $currentAdmittedPatient_registrationNo;
public $currentAdmittedPatient_dateRegistered;
public $currentAdmittedPatient_cashUnpaid;
public $currentAdmittedPatient_phic;
public $currentAdmittedPatient_company;
public $currentAdmittedPatient_registrationDetailsCompany;

public function currentAdmittedPatient_name() {
return $this->currentAdmittedPatient_name;
}
public function currentAdmittedPatient_registrationNo() {
return $this->currentAdmittedPatient_registrationNo;
}
public function currentAdmittedPatient_dateRegistered() {
return $this->currentAdmittedPatient_dateRegistered;
}
public function currentAdmittedPatient_cashUnpaid() {
return $this->currentAdmittedPatient_cashUnpaid;
}
public function currentAdmittedPatient_phic() {
return $this->currentAdmittedPatient_phic;
}
public function currentAdmittedPatient_company() {
return $this->currentAdmittedPatient_company;
}
public function currentAdmittedPatient_registrationDetailsCompany() {
return $this->currentAdmittedPatient_registrationDetailsCompany;
}

public function currentAdmittedPatient($room) {

$this->currentAdmittedPatient_name = "";
$this->currentAdmittedPatient_registrationNo = "";
$this->currentAdmittedPatient_dateRegistered = "";

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT pr.lastName,pr.firstName,rd.Company,rd.registrationNo,rd.dateRegistered,sum(pc.cashUnpaid) as cash,sum(pc.phic) as phic,sum(pc.company) as company from patientRecord pr,registrationDetails rd,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and rd.room = '$room' and rd.type = 'IPD' and rd.dateUnregistered = '' and (pc.status = 'UNPAID' or pc.status='Discharged') and (pc.title != 'MEDICINE' and pc.title != 'SUPPLIES') ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
$this->currentAdmittedPatient_name = strtoupper($row['lastName'])." ".strtoupper($row['firstName']);
$this->currentAdmittedPatient_registrationNo = $row['registrationNo'];
$this->currentAdmittedPatient_dateRegistered = $row['dateRegistered'];
$this->currentAdmittedPatient_cashUnpaid = $row['cash'];
$this->currentAdmittedPatient_phic = $row['phic'];
$this->currentAdmittedPatient_company = $row['company'];
$this->currentAdmittedPatient_registrationDetailsCompany = $row['Company'];
}

}

public function currentAdmitted($floor) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT Description from room where floor = '$floor' order by Description asc ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {

$cashAdmitted = 0;

$this->currentAdmittedPatient($row['Description']);
$this->currentAdmittedPatient_inventory($row['Description']);

$cashAdmitted= (( $this->currentAdmittedPatient_cashUnpaid() + $this->currentAdmittedPatient_inventory_cash() ) - $this->getTotalPatientPayment($this->currentAdmittedPatient_registrationNo()));

//$cashAdmitted= (( $this->currentAdmittedPatient_cashUnpaid()  ) );


$currentAdmitted_cash = $cashAdmitted;

$currentAdmitted_phic = ( $this->currentAdmittedPatient_phic() + $this->currentAdmittedPatient_inventory_phic() );

$currentAdmitted_company = ( $this->currentAdmittedPatient_company() + $this->currentAdmittedPatient_inventory_company() );

$this->coconutTableRowStart();
$this->coconutTableData("<font size=2>".$row['Description']."</font>");
$this->coconutTableData("<font size=2>".$this->currentAdmittedPatient_registrationNo()."</font>");
$this->coconutTableData("<font size=2>".$this->currentAdmittedPatient_name()."</font>");
$this->coconutTableData("<font size=2>".$this->currentAdmittedPatient_dateRegistered()."</font>");
$this->coconutTableData("<font size=2>".$this->currentAdmittedPatient_registrationDetailsCompany()."</font>");
( $currentAdmitted_cash > 0 ) ? $this->coconutTableData("<font size=2>".number_format($currentAdmitted_cash,2)."</font>") : $this->coconutTableData("");
( $currentAdmitted_phic > 0 ) ? $this->coconutTableData("<font size=2>".number_format($currentAdmitted_phic,2)."</font>") : $this->coconutTableData("");
( $currentAdmitted_company > 0 ) ? $this->coconutTableData("<font size=2>".number_format($currentAdmitted_company,2)."</font>") : $this->coconutTableData("");
$this->coconutTableRowStop();
}

}




public function getCompanyPaymentViaRefNo($refNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}
.style1 {font-family: Arial;font-size: 10px;color: #FFFFFF;font-weight: bold;}
.style2 {font-family: Arial;font-size: 10px;color: #000000;}
.style3 {font-family: Arial;font-size: 10px;color: #000000;font-weight: bold;}
</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$totap=0;
$tottx=0;
$totds=0;
$result = mysqli_query($connection, " SELECT pr.lastName,pr.firstName,rd.Company,cp.checkNo,cp.amountPaid,cp.tax,cp.discount,cp.datePaid,cp.postBy from patientRecord pr,registrationDetails rd,companyPayment cp where pr.patientNo = rd.patientNo and rd.registrationNo = cp.registrationNo and cp.refNo = '$refNo' and cp.status not like 'DELETED%%%%%%' ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("<span class='style1'>Patient</span>");
$this->coconutTableHeader("<span class='style1'>Company</span>");
$this->coconutTableHeader("<span class='style1'>Check#</span>");
$this->coconutTableHeader("<span class='style1'>Amount Pd</span>");
$this->coconutTableHeader("<span class='style1'>Tax</span");
$this->coconutTableHeader("<span class='style1'>Discount</span>");
$this->coconutTableHeader("<span class='style1'>Date</span>");
$this->coconutTableHeader("<span class='style1'>Post By</span>");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<span class='style2'>".strtoupper($row['lastName']).", ".strtoupper($row['firstName'])."</span>");
$this->coconutTableData("<span class='style2'>".$row['Company']."</span>");
$this->coconutTableData("<span class='style2'>".$row['checkNo']."</span>");
$this->coconutTableData("<span class='style2'>".number_format($row['amountPaid'],2)."</span>");
( $row['tax'] != "" ) ? $this->coconutTableData("<span class='style2'>".number_format($row['tax'],2)."</span>") : $this->coconutTableData("");
( $row['discount'] != "" ) ? $this->coconutTableData("<span class='style2'>".number_format($row['discount'],2)."</span>") : $this->coconutTableData("");
$this->coconutTableData("<span class='style2'>".$row['datePaid']."</span>");
$this->coconutTableData("<span class='style2'>".$row['postBy']."</span>");
$this->coconutTableRowStop();

$totap+=$row['amountPaid'];
$tottx+=$row['tax'];
$totds+=$row['discount'];

}


$this->coconutTableRowStart();
echo "
<td colspan='3'><span class='style3'>&nbsp;TOTAL</span></td>
<td><span class='style3'>&nbsp;".number_format($totap,2)."</span></td>
<td><span class='style3'>&nbsp;".number_format($tottx,2)."</span></td>
<td><span class='style3'>&nbsp;".number_format($totds,2)."</span></td>
<td colspan='2'><b></b></td>
";
$this->coconutTableRowStop();


$this->coconutTableStop();
}





public $promisorryNoteReport_total;


public function promisorryNoteReport($date,$date1) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT pr.lastName,pr.firstName,rd.registrationNo,rd.dateRegistered,rd.dateUnregistered,pn.amount,pn.startDate,pn.dueDate,pn.postedBy from patientRecord pr,registrationDetails rd,promisorryNote pn where pr.patientNo = rd.patientNo and rd.registrationNo = pn.registrationNo and (pn.startDate between '$date' and '$date1') order by startDate asc ") or die("Query fail: " . mysqli_error()); 


echo "<Br><br><center>Date Encoded Between <font color=red>$date</font> and <font color=red>$date1</font><br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Admitted");
$this->coconutTableHeader("Discharged");
$this->coconutTableHeader("Balance");
$this->coconutTableHeader("Date Encoded");
$this->coconutTableHeader("Due Date");
$this->coconutTableHeader("Encoded By");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->promisorryNoteReport_total += $row['amount'];

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['registrationNo']);
$this->coconutTableData("&nbsp;".$row['lastName'].", ".$row['firstName']);
$this->coconutTableData("&nbsp;".$row['dateRegistered']);
$this->coconutTableData("&nbsp;".$row['dateUnregistered']);
$this->coconutTableData("&nbsp;".number_format($row['amount'],2));
$this->coconutTableData("&nbsp;".$row['startDate']);
$this->coconutTableData("&nbsp;".$row['dueDate']);
$this->coconutTableData("&nbsp;".$row['postedBy']);
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/patientProfile/promisorryNote/noteChecker.php?registrationNo=$row[registrationNo]&username=viewOnly' target='_blank'><font size=2 color=red>View Note</font></a>");
$this->coconutTableRowStop();
}
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->promisorryNoteReport_total,2));
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();
$this->coconutTableStop();

}




/*******************new detailed opd**************************/

public $newDetailed_inventory_opd_total;
public $newDetailed_inventory_opd_discount;
public $newDetailed_inventory_opd_cashUnpaid;
public $newDetailed_inventory_opd_cashPaid;

public function newDetailed_inventory_opd_total() {
return $this->newDetailed_inventory_opd_total;
}

public function newDetailed_inventory_opd_discount() {
return $this->newDetailed_inventory_opd_discount;
}


public function newDetailed_inventory_opd_cashUnpaid() {
return $this->newDetailed_inventory_opd_cashUnpaid;
}

public function newDetailed_inventory_opd_cashPaid() {
return $this->newDetailed_inventory_opd_cashPaid;
}

public function newDetailed_inventory_opd($registrationNo,$title) {

$this->newDetailed_inventory_opd_total = 0;
$this->newDetailed_inventory_opd_discount = 0;
$this->newDetailed_inventory_opd_cashUnpaid = 0;
$this->newDetailed_inventory_opd_cashPaid = 0;

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.cashPaid,pc.discount from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and status not like 'DELETED%%%%%' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {

$this->newDetailed_inventory_opd_total += $row['total'];
$this->newDetailed_inventory_opd_discount += $row['discount'];
$this->newDetailed_inventory_opd_cashUnpaid += $row['cashUnpaid'];
$this->newDetailed_inventory_opd_cashPaid += $row['cashPaid'];

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['discount']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['cashUnpaid']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['cashPaid']."</font></td>";
echo "</tr>";
}

}


public $newDetailed_opd_total;
public $newDetailed_opd_discount;
public $newDetailed_opd_cashUnpaid;
public $newDetailed_opd_cashPaid;

public function newDetailed_opd_total() {
return $this->newDetailed_opd_total;
}

public function newDetailed_opd_discount() {
return $this->newDetailed_opd_discount;
}

public function newDetailed_opd_cashUnpaid() {
return $this->newDetailed_opd_cashUnpaid;
}

public function newDetailed_opd_cashPaid() {
return $this->newDetailed_opd_cashPaid;
}

public function newDetailed_opd($registrationNo,$title) {

$this->newDetailed_opd_total = 0;
$this->newDetailed_opd_discount = 0;
$this->newDetailed_opd_cashUnpaid = 0;
$this->newDetailed_opd_cashPaid = 0;

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " SELECT pc.status,pc.dateCharge,pc.itemNo,pc.description,pc.quantity,pc.sellingPrice,pc.total,pc.cashUnpaid,pc.cashPaid,pc.discount from patientCharges pc,registrationDetails rd WHERE rd.registrationNo = '$registrationNo' and pc.registrationNo = rd.registrationNo and pc.title = '$title' and pc.status not like 'DELETED%%%%%' order by pc.dateCharge asc   ") or die("Query fail: " . mysqli_error()); 


while($row = mysqli_fetch_array($result))
  {

$this->newDetailed_opd_total += $row['total'];
$this->newDetailed_opd_discount += $row['discount'];
$this->newDetailed_opd_cashUnpaid += $row['cashUnpaid'];
$this->newDetailed_opd_cashPaid += $row['cashPaid'];

echo "<tr>";
echo "<td>&nbsp;<font size=2>".$row['dateCharge']."</font></td>";
//echo "<td>&nbsp;<font size=2>".$row['itemNo']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['description']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['quantity']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['sellingPrice']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['total']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['cashUnpaid']."</font></td>";
echo "<td>&nbsp;<font size=2>".$row['cashPaid']."</font></td>";
echo "</tr>";
}

}


/************************************************************/




public function getInpatientPaymentSummary($registrationNo,$paymentFor) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(amountPaid) as amountPd from patientPayment where registrationNo = '$registrationNo' and paymentFor = '$paymentFor' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['amountPd'];
}

}


public function getInpatientPaymentSummary_pf($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(pf) as pf from patientPayment where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['pf'];
}

}


public function getEmployeeId_username($username,$password) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select employeeID from registeredUser where username = '$username' and password = '$password' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['employeeID'];
}

}

public function getEmployeeId_passwordOnly($password) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select username from registeredUser where password = '$password' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['username'];
}

}

public function showAllStation() {

echo "

<style type='text/css'>
a { text-decoration:none; color:red; }

.button{
	border: 1px solid #fff;
	color: #000;
	height: 28px;
	width: 381px;
	border-color:blue blue blue blue;
	font-size:15px;
	text-align:center;
	background-color:;
}

.button:hover {
background-color:yellow;
color:black;
}

.button1:hover {
background-color:yellow;
color:black;
}


</style>

";


$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select station from room group by station ") or die("Query fail: " . mysqli_error()); 


echo "<center><br><br><br>";
while($row = mysqli_fetch_array($result))
  {
echo "<form method='post' action='http://".$this->getMyUrl()."/COCONUT/room/showStationRoom.php'><input class='button' type='submit' value='$row[station]'><input type='hidden' name='station' value='$row[station]'></form>";
}

}



public function summaryPayment($registrationNo) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(amountPaid) as pd from patientPayment where registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['pd'];
}

}


public $showRoomUnderStation_patient_lastName;
public $showRoomUnderStation_patient_firstName;
public $showRoomUnderStation_patient_registrationNo;
public $showRoomUnderStation_patient_dateRegistered;
public $showRoomUnderStation_patient_dateUnregistered;
public $showRoomUnderStation_patient_nurseStationStatus;
public $showRoomUnderStation_patient_company;
public $showRoomUnderStation_patient_phic;

public function showRoomUnderStation_patient_lastName() {
return $this->showRoomUnderStation_patient_lastName;
}

public function showRoomUnderStation_patient_firstName() {
return $this->showRoomUnderStation_patient_firstName;
}

public function showRoomUnderStation_patient_registrationNo() {
return $this->showRoomUnderStation_patient_registrationNo;
}

public function showRoomUnderStation_patient_dateRegistered() {
return $this->showRoomUnderStation_patient_dateRegistered;
}

public function showRoomUnderStation_patient_dateUnregistered() {
return $this->showRoomUnderStation_patient_dateUnregistered;
}

public function showRoomUnderStation_patient_nurseStationStatus() {
return $this->showRoomUnderStation_patient_nurseStationStatus;
}

public function showRoomUnderStation_patient_company() {
return $this->showRoomUnderStation_patient_company;
}

public function showRoomUnderStation_patient_phic() {
return $this->showRoomUnderStation_patient_phic;
}


public function showRoomUnderStation_patient_setter($room) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,pr.PHIC,rd.registrationNo,rd.dateRegistered,rd.nurseStationStatus,rd.Company,rd.dateUnregistered from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and (rd.dateUnregistered = '' or rd.nurseStationStatus != 'Discharged' or rd.nurseStationStatus != '') and rd.nurseStationStatus = 'Admitted' and rd.room = '$room'  ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
$this->showRoomUnderStation_patient_lastName = $row['lastName'];
$this->showRoomUnderStation_patient_firstName = $row['firstName'];
$this->showRoomUnderStation_patient_registrationNo = $row['registrationNo'];
$this->showRoomUnderStation_patient_dateRegistered = $row['dateRegistered'];
$this->showRoomUnderStation_patient_dateUnregistered = $row['dateUnregistered'];
$this->showRoomUnderStation_patient_nurseStationStatus = $row['nurseStationStatus'];
$this->showRoomUnderStation_patient_company = $row['Company'];
$this->showRoomUnderStation_patient_phic = $row['PHIC'];
}

}


public function showRoomUnderStation($station) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}


.txtSize {
	font-family: 'Times New Roman';
	font-size: 13px;
	color: #000000;
}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select Description from room where station='$station' order by Description asc ") or die("Query fail: " . mysqli_error()); 

echo "<b><i><a href='http://".$this->getMyUrl()."/COCONUT/room/showStation.php' style='text-decoration:none;'>$station</a></i></b><Br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Room#");
$this->coconutTableHeader("Name of Patient");
$this->coconutTableHeader("Attending Physician");
$this->coconutTableHeader("Date Admitted");
$this->coconutTableHeader("Px Status");
$this->coconutTableHeader("Running Bill");
$this->coconutTableHeader("Account Status");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->showRoomUnderStation_patient_lastName = "";
$this->showRoomUnderStation_patient_firstName = "";
$this->showRoomUnderStation_patient_registrationNo = "";
$this->showRoomUnderStation_patient_dateRegistered = "";
$this->showRoomUnderStation_patient_dateUnregistered = "";
$this->showRoomUnderStation_patient_nurseStationStatus = "";
$this->showRoomUnderStation_patient_company = "";

$this->showRoomUnderStation_patient_setter($row['Description']);
$totalBalanceNow = ( $this->getTotal("cashUnpaid","",$this->showRoomUnderStation_patient_registrationNo) - $this->getAllPayment($this->showRoomUnderStation_patient_registrationNo) );


$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<span class='txtSize'>".$row['Description']."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize'><a href='http://".$this->getMyUrl()."/COCONUT/room/patientLogin.php?registrationNo=".$this->showRoomUnderStation_patient_registrationNo."&lastName=".$this->showRoomUnderStation_patient_lastName."&firstName=".$this->showRoomUnderStation_patient_firstName."' target='_blank' style='text-decoration:none;'>".strtoupper($this->showRoomUnderStation_patient_lastName()." ".$this->showRoomUnderStation_patient_firstName())."</a></span>");
$this->coconutTableData("&nbsp;<span class='txtSize'>".strtoupper($this->getAttendingDoc($this->showRoomUnderStation_patient_registrationNo(),"ATTENDING"))."</span>");
$this->coconutTableData("&nbsp;<span class='txtSize'>".$this->showRoomUnderStation_patient_dateRegistered()."</span>");



$this->coconutTableData("&nbsp;<span class='txtSize'><a href='http://".$this->getMyUrl()."/COCONUT/room/nurseStationStatus.php?registrationNo=".$this->showRoomUnderStation_patient_registrationNo."&lastName=".$this->showRoomUnderStation_patient_lastName."&firstName=".$this->showRoomUnderStation_patient_firstName."&status=".$this->showRoomUnderStation_patient_nurseStationStatus."&station=$station'>".$this->showRoomUnderStation_patient_nurseStationStatus."</a></span>");


if( $this->showRoomUnderStation_patient_registrationNo != "" ) {
echo "<td>&nbsp;<span class='txtSize'>".number_format((($this->getTotal_nursingModule("cashUnpaid","",$this->showRoomUnderStation_patient_registrationNo) + $this->getTotal_nursingModule("cashUnpaid","MEDICINE",$this->showRoomUnderStation_patient_registrationNo) + $this->getTotal_nursingModule("cashUnpaid","SUPPLIES",$this->showRoomUnderStation_patient_registrationNo)) - $this->summaryPayment($this->showRoomUnderStation_patient_registrationNo) ),2)."</span></td>";
}else {
echo "<td>&nbsp;</td>";
}

//STATUS
if( $this->showRoomUnderStation_patient_company != "" ) { //kpg may hmo
if( $this->selectNow("registrationDetails","LimitHMO","registrationNo",$this->showRoomUnderStation_patient_registrationNo) != "" ) { // with hmo limit

if( $totalBalanceNow >= $this->selectNow("registrationDetails","LimitHMO","registrationNo",$this->showRoomUnderStation_patient_registrationNo) ) {
$this->coconutTableData("&nbsp;<span class='txtSize'><font color=red>[LOCKED]</font></span>");
}else {
$this->coconutTableData("&nbsp;");
}

}else {
$this->coconutTableData("&nbsp;");
}
}else if( $this->showRoomUnderStation_patient_phic == "YES" ) { //kpg may phic

if( $totalBalanceNow >= 7000 ) {
$this->coconutTableData("&nbsp;<span class='txtSize'><font color=red>[LOCKED]</font></span>");
}else {
$this->coconutTableData("&nbsp;");
}

}
else {

if( $totalBalanceNow >= 5000 ) { //kpg walang hmo at phic
$this->coconutTableData("&nbsp;<span class='txtSize'><font color=red>[LOCKED]</font></span>");
}else {
$this->coconutTableData("&nbsp;");
}
}

$this->coconutTableRowStop();
}
$this->coconutTableStop();

}



public function mergeLabResult($registrationNo,$desc,$itemNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}


.txtSize {
	font-family: 'Times New Roman';
	font-size: 13px;
	color: #000000;
}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pc.itemNo,pc.description,lsr.date,lsr.time,lsr.medtech,pc.status,lsr.savedNo,lsr.itemNo from patientCharges pc,labSavedResult lsr where pc.itemNo = lsr.itemNo and pc.registrationNo = '$registrationNo' and pc.status not like 'DELETED%%%%%%' ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Description");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Time");
$this->coconutTableHeader("Medtech");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
if( $row['status'] == "PAID" ) {
$this->coconutTableData("&nbsp;".$row['description']."<b>(Pd)</b>");
}else {
$this->coconutTableData("&nbsp;".$row['description']);
}
$this->coconutTableData("&nbsp;".$row['date']);
$this->coconutTableData("&nbsp;".$row['time']);
$this->coconutTableData("&nbsp;".$row['medtech']);
$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/resultList/resultForm_output.php?registrationNo=$registrationNo&itemNo=$row[itemNo]' target='_blank' style='text-decoration:none; size:10px; color:red;'>View Result</a>");

$this->coconutTableData("&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Laboratory/mergeResult1.php?registrationNo=$registrationNo&itemNo=$itemNo&savedNo=$row[savedNo]&itemNoOfResult=$row[itemNo]' style='text-decoration:none; size:10px; color:blue;'>Merge $desc</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}





public function connectedResult($registrationNo,$itemNo,$savedNo,$itemNoOfResult) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into core2_laboratoryResultChecker(registrationNo,itemNo,savedNoOfResult,itemNoOfResult) values('$registrationNo','$itemNo','$savedNo','$itemNoOfResult')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}




public function get_total_phic_or_company_notInventory($cols,$type,$title,$date1,$date2) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

if( $type == "OPD" ) {
$result = mysqli_query($connection, " select sum(pc.".$cols.") as cols from registrationDetails rd,patientCharges pc where rd.registrationNo = pc.registrationNo and (pc.dateCharge between '$date1' and '$date2') and rd.type = '$type' and pc.title = '$title' and status not like 'DELETED%%%%%%' ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " select sum(pc.".$cols.") as cols from registrationDetails rd,patientCharges pc where rd.registrationNo = pc.registrationNo and (rd.dateUnregistered between '$date1' and '$date2') and rd.type = '$type' and pc.title = '$title' and status not like 'DELETED%%%%%%' ") or die("Query fail: " . mysqli_error()); 
}

while($row = mysqli_fetch_array($result))
  {
return $row['cols'];
}

}


public function stockCard_quantityRequesition($inventoryCode) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select sum(quantityIssued) as qty from inventoryManager where inventoryCode = '$inventoryCode' and status = 'Received' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['qty'];
}

}

public function stockCard_quantityOut($stockCardNo,$inventoryCode) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(pc.quantity) as qtyOUT from patientCharges pc,inventory i where i.stockCardNo = '$stockCardNo' and i.inventoryCode = pc.chargesCode and pc.chargesCode = '$inventoryCode' and pc.departmentStatus like 'dispensedBy_%%%%%%' and pc.status not like 'DELETED%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['qtyOUT'];
}

}


public function viewStockCard($stockCardNo,$inventoryType,$show) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

if( $show == "all" ) {
$result = mysqli_query($connection, " SELECT inventoryCode,dateAdded,beginningQTY,unitcost,Added,addedBy,inventoryLocation,quantity,status,inventoryType,suppliesUNITCOST from inventory where stockCardNo = '$stockCardNo' order by dateAdded desc ") or die("Query fail: " . mysqli_error()); 
}else {
$result = mysqli_query($connection, " SELECT inventoryCode,dateAdded,beginningQTY,unitcost,Added,addedBy,inventoryLocation,quantity,status,inventoryType,suppliesUNITCOST from inventory where stockCardNo = '$stockCardNo' and inventoryLocation = '$show' order by dateAdded desc ") or die("Query fail: " . mysqli_error()); 
}


$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Date Added");
$this->coconutTableHeader("Inv Code");
$this->coconutTableHeader("UnitCost");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("QTY In");
$this->coconutTableHeader("QTY Out");
$this->coconutTableHeader("Remaining");
$this->coconutTableHeader("Location");
$this->coconutTableHeader("User");
$this->coconutTableHeader("Status");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

if( $row['inventoryType'] == "medicine" ) {
$price = preg_split ("/\_/", $row['Added']); 
$price1 = $price[1];
$unitCost = $row['unitcost'];
}else {
$price = $row['unitcost'];
$price1 = $price; 
$unitCost = $row['suppliesUNITCOST'];
}


$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateAdded']);
$this->coconutTableData("&nbsp;".$row['inventoryCode']);
$this->coconutTableData("&nbsp;".$unitCost);
$this->coconutTableData("&nbsp;".$price1);
$this->coconutTableData("&nbsp;".$row['beginningQTY']);
$this->coconutTableData("&nbsp;". ($this->stockCard_quantityOut($stockCardNo,$row['inventoryCode']) + $this->stockCard_quantityRequesition($row['inventoryCode'])) );
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("&nbsp;".$row['inventoryLocation']);
$this->coconutTableData("&nbsp;".$row['addedBy']);
$this->coconutTableData("&nbsp;".$row['status']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();

}



public function searchInventory_fewColumns($description,$username) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select inventoryCode,stockCardNo,description,quantity,genericName,dateAdded,inventoryLocation,inventoryType from inventory where (description like '$description%%%%%%%' or genericName like '$description%%%%%%%%') and status not like 'DELETED%%%%%' order by dateAdded desc ") or die("Query fail: " . mysqli_error()); 

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Encoded");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Location");
$this->coconutTableHeader("&nbsp;");
$this->coconutTableHeader("&nbsp;");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$row['dateAdded']);
$this->coconutTableData("&nbsp;".$row['description']."<br>&nbsp;<font size=2>".$row['genericName']."<font>");
$this->coconutTableData("&nbsp;".$row['quantity']);
$this->coconutTableData("&nbsp;".$row['inventoryLocation']);

echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/Pharmacy/monitoring/monitoringHead.php?inventoryCode=$row[inventoryCode]' target='_blank'><i><font size=2 color=red>Patient</font></i></a>&nbsp;</td>";

if( $row['stockCardNo'] > 0 ) {
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/inventory/stockCard.php?stockCardNo=$row[stockCardNo]&inventoryType=$row[inventoryType]&show=all' target='_blank' style='color:blue; text-decoration:none;'><font size=2 color='blue'><i>Stock Card</i></a>");
}else {
echo "<td>&nbsp;</td>";
}


$this->coconutTableRowStop();
}
$this->coconutTableStop();
}



public $search_orNo_price;
public $search_orNo_discount;
public $search_orNo_total;
public $search_orNo_payment;


public function search_orNo($orNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.registrationNo,pc.description,pc.sellingPrice,pc.quantity,pc.discount,pc.total,pc.cashPaid,pc.datePaid,pc.timePaid,pc.orNO from patientRecord pr,registrationDetails rd,patientCharges pc where pr.patientNo = rd.patientNo and rd.registrationNo = pc.registrationNo and pc.orNO = '$orNo' ") or die("Query fail: " . mysqli_error()); 


echo "<br><br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("OR#");
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("Price");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Disc");
$this->coconutTableHeader("Total");
$this->coconutTableHeader("Payment");
$this->coconutTableHeader("Time Pd");
$this->coconutTableHeader("Date Pd");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {

$this->search_orNo_price += $row['sellingPrice'];
$this->search_orNo_discount += $row['discount'];
$this->search_orNo_total += $row['total'];
$this->search_orNo_payment += $row['cashPaid'];

$this->coconutTableRowStart();
$this->coconutTableData("<font color=blue>".$row['orNO']."</font>");
$this->coconutTableData("<font color=red>".$row['registrationNo']."</font>");
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/room/patientLogin.php?registrationNo=$row[registrationNo]&lastName=$row[lastName]&firstName=$row[firstName]' style='text-decoration:none;'>".$row['lastName'].", ".$row['firstName']."</a>");
$this->coconutTableData($row['description']);
$this->coconutTableData(number_format($row['sellingPrice'],2));
$this->coconutTableData($row['quantity']);
$this->coconutTableData(number_format($row['discount'],2));
$this->coconutTableData(number_format($row['total'],2));
$this->coconutTableData(number_format($row['cashPaid'],2));
$this->coconutTableData($row['timePaid']);
$this->coconutTableData($row['datePaid']);
$this->coconutTableRowStop();
}

$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;<b>Total</b>");
$this->coconutTableData("&nbsp;".number_format($this->search_orNo_price,2));
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;".number_format($this->search_orNo_discount,2));
$this->coconutTableData("&nbsp;".number_format($this->search_orNo_total,2));
$this->coconutTableData("&nbsp;".number_format($this->search_orNo_payment,2));
$this->coconutTableData("&nbsp;");
$this->coconutTableData("&nbsp;");
$this->coconutTableRowStop();

$this->coconutTableStop();

}





public function companyPaymentSelection($registrationNo,$username,$companyName,$columnToGet) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select description,itemNo,chargesCode,sellingPrice,company from patientCharges where registrationNo='$registrationNo' and title = 'PROFESSIONAL FEE' and status = 'UNPAID' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {

echo "<form method='post' action='http://".$this->getMyUrl()."/COCONUT/patientProfile/Payments/companyPayment_pf.php'>";
$this->coconutHidden("registrationNo",$registrationNo);
$this->coconutHidden("username",$username);
$this->coconutHidden("amount",$row['company']);
$this->coconutHidden("doctorName",$row['description']);
$this->coconutHidden("itemNo",$row['itemNo']);
$this->coconutHidden("companyName",$companyName);
$this->coconutHidden("columnToGet",$columnToGet);
echo "<input type=submit value='$row[description]' class='button'>
</form>";

}

}



public function phicPaymentSelection($registrationNo,$username) {

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select description,itemNo,chargesCode,sellingPrice,phic from patientCharges where registrationNo='$registrationNo' and title = 'PROFESSIONAL FEE' and status = 'UNPAID' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {

echo "<form method='post' action='http://".$this->getMyUrl()."/COCONUT/patientProfile/Payments/phicPayment_pf.php'>";
$this->coconutHidden("registrationNo",$registrationNo);
$this->coconutHidden("username",$username);
$this->coconutHidden("amount",$row['phic']);
$this->coconutHidden("itemNo",$row['itemNo']);
echo "<input type=submit value='$row[description]' class='button'>
</form>";

}

}



public function reOrdering_quantityOut($inventoryCode) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(pc.quantity) as qtyOUT from patientCharges pc,inventory i where i.inventoryCode = pc.chargesCode and pc.chargesCode = '$inventoryCode' and pc.departmentStatus like 'dispensedBy_%%%%%%' and pc.status not like 'DELETED%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['qtyOUT'];
}

}



public function reOrdering_quantityOutFromDept($inventoryCode) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT sum(i.beginningQTY) as qtyOUT1 from inventory i where i.from_inventoryCode = '$inventoryCode' and i.status not like 'DELETED%%%%%' ") or die("Query fail: " . mysqli_error()); 

while($row = mysqli_fetch_array($result))
  {
return $row['qtyOUT1'];
}

}



public $reOrderingWithSpecifiedQTY_no;

public function reOrderingWithSpecifiedQTY($dept,$qtyStart,$qtyEnd) {

$this->reOrderingWithSpecifiedQTY_no=0;

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

.txtSize1 {
	font-family: 'Arial';
	font-size: 13px;
	color: #FFFFFF;
}

.txtSize2 {
	font-family: 'Arial';
	font-size: 13px;
	color: 000000;
}

</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query(" SELECT inventoryCode,description,genericName,quantity,criticalLevel,inventoryType,dateAdded,beginningQTY FROM inventory where (quantity between '$qtyStart' and '$qtyEnd') and status not like 'DELETED_%%%%%%%' and inventoryLocation = '$dept' and dateAdded like '2015%%%%%%' order by quantity desc");

echo "<center>";
echo "<br><span class='txtSize2'>QTY between $qtyStart to $qtyEnd</span><br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("<span class='txtSize1'>#</span>");
$this->coconutTableHeader("<span class='txtSize1'>Code</span>");
$this->coconutTableHeader("<span class='txtSize1'>Encoded</span>");
$this->coconutTableHeader("<span class='txtSize1'>Particulars</span>");
$this->coconutTableHeader("<span class='txtSize1'>QTY In</span>");
$this->coconutTableHeader("<span class='txtSize1'>QTY Out</span>");
$this->coconutTableHeader("<span class='txtSize1'>Remaining</span>");
$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {

$this->reOrderingWithSpecifiedQTY_no++;

$this->coconutTableRowStart();
echo "<td>&nbsp;<span class='txtSize2'>".$this->reOrderingWithSpecifiedQTY_no."</span>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize2'>".$row['inventoryCode']."</span>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize2'>".$row['dateAdded']."</span>&nbsp;</tD>";
if( $row['inventoryType'] == "medicine" ) {
echo "<td>&nbsp;<span class='txtSize2'>".$row['description']."<br>&nbsp;<font color=red>".$row['genericName']."</font></span>&nbsp;</tD>";
}else {
echo "<td>&nbsp;<span class='txtSize2'>".$row['description']."</span>&nbsp;</tD>";
}
echo "<td>&nbsp;<span class='txtSize2'>".$row['beginningQTY']."</span>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize2'>".($this->reOrdering_quantityOut($row['inventoryCode']) + $this->reOrdering_quantityOutFromDept($row['inventoryCode']))."</span>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize2'>".$row['quantity']."</span>&nbsp;</tD>";
$this->coconutTableRowStop();
  }

$this->coconutTableStop();

}






public function inventoryDepartmentReturn($inventoryCode,$from_inventoryCode,$qtyReturn,$returnBy,$returnTime,$returnDate,$status,$returnFrom,$returnTo) {

/* make your connection */
$sql = new mysqli($this->myHost,$this->username,$this->password,$this->database);
 
/* we will just create an insert query here, and use it,
normally this would be done by form submission or other means */
$query = "insert into inventoryDepartmentReturn(inventoryCode,from_inventoryCode,qtyReturn,returnBy,returnTime,returnDate,status,returnFrom,returnTo) values('$inventoryCode','$from_inventoryCode','$qtyReturn','$returnBy','$returnTime','$returnDate','$status','$returnFrom','$returnTo')";

 
if ( $sql->query($query) ) {
   //echo "A new entry has been added with the `id`";
} else {
    echo "There was a problem:<br />$query<br />{$sql->error}";
}
 
/* close our connection */
$sql->close();
}




public function getListOfReturnFromDepartment($returnTo,$username) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT returnNo,inventoryCode,from_inventoryCode,qtyReturn,returnBy,returnTime,returnDate,returnFrom,returnTo from inventoryDepartmentReturn where returnTo = '$returnTo' and status = 'return' ") or die("Query fail: " . mysqli_error()); 

echo "<br><br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("Time");
$this->coconutTableHeader("Date");
$this->coconutTableHeader("Return By");
$this->coconutTableHeader("Return From");
$this->coconutTableHeader("&nbsp;");
$this->coconutTableHeader("&nbsp;");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$this->selectNow("inventory","description","inventoryCode",$row['inventoryCode']));
$this->coconutTableData("&nbsp;".$row['qtyReturn']);
$this->coconutTableData("&nbsp;".$row['returnTime']);
$this->coconutTableData("&nbsp;".$row['returnDate']);
$this->coconutTableData("&nbsp;".$row['returnBy']);
$this->coconutTableData("&nbsp;".$row['returnFrom']);
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/inventory/receiveDepartmentReturn.php?returnNo=$row[returnNo]&inventoryCode=$row[inventoryCode]&returnFrom=$row[returnFrom]&returnTo=$returnTo&username=$username&qtyReturn=$row[qtyReturn]' style='text-decoration:none; color:blue; font-size:14px;'>Receive</a>");
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/inventory/cancelDepartmentReturn.php?returnNo=$row[returnNo]&inventoryCode=$row[inventoryCode]&returnFrom=$row[returnFrom]&returnTo=$returnTo&username=$username' style='text-decoration:none; color:red; font-size:14px;'>Cancel</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public function getListOfReturnFromDepartmentReport($date,$returnTo) {


echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      

$result = mysqli_query($connection, " SELECT inventoryCode,qtyReturn,returnFrom,receivedTime,receivedDate from inventoryDepartmentReturn where status = 'received' and returnTo = '$returnTo' and receivedDate = '$date' ") or die("Query fail: " . mysqli_error()); 

echo "<br><br><br><center>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Particulars");
$this->coconutTableHeader("QTY");
$this->coconutTableHeader("From");
$this->coconutTableHeader("Charge Status");
$this->coconutTableHeader("Time Received");
$this->coconutTableHeader("Date Received");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;".$this->selectNow("inventory","description","inventoryCode",$row['inventoryCode']));
$this->coconutTableData("&nbsp;".$row['qtyReturn']);
$this->coconutTableData("&nbsp;".$row['returnFrom']);
$this->coconutTableData("&nbsp;".$this->selectNow("inventory","chargeControl","inventoryCode",$row['inventoryCode']));
$this->coconutTableData("&nbsp;".$row['receivedTime']);
$this->coconutTableData("&nbsp;".$row['receivedDate']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}






public function toDischarge($from,$to,$username,$type) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.registrationNo,rd.Company,rd.dateRegistered,rd.dateUnregistered,rd.type from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and rd.type = '$type' and (rd.dateRegistered between '$from' and '$to') and rd.dateUnregistered = '' order by rd.Company desc ") or die("Query fail: " . mysqli_error()); 


$this->coconutFormStart("post","http://".$this->getMyUrl()."/COCONUT/Reports/toDischarge2.php");
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Company");
$this->coconutTableHeader("Admitted");
$this->coconutTableHeader("Discharged");
$this->coconutTableHeader("Type");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutHidden("username",$username);
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;<input type='checkbox' name='registrationNo[]' value='$row[registrationNo]' checked>");
$this->coconutTableData("&nbsp;".$row['registrationNo']);
$this->coconutTableData("&nbsp;".strtoupper($row['lastName']).", ".strtoupper($row['firstName']));
$this->coconutTableData("&nbsp;".$row['Company']);
$this->coconutTableData("&nbsp;".$row['dateRegistered']);
$this->coconutTableData("&nbsp;".$row['dateUnregistered']);
$this->coconutTableData("&nbsp;".$row['type']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
$this->coconutButton("Proceed");
$this->coconutFormStop();
}



public function searchRegistrationNo($registrationNo) {

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

$connection = mysqli_connect($this->myHost,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, " select pr.lastName,pr.firstName,rd.registrationNo,rd.registeredFrom from patientRecord pr,registrationDetails rd where pr.patientNo = rd.patientNo and rd.registrationNo = '$registrationNo' ") or die("Query fail: " . mysqli_error()); 


echo "<center><br><br>";
$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("Reg#");
$this->coconutTableHeader("Patient");
$this->coconutTableHeader("Registered From");
$this->coconutTableRowStop();
while($row = mysqli_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("&nbsp;$registrationNo");
$this->coconutTableData("<a href='http://".$this->getMyUrl()."/COCONUT/room/patientLogin.php?registrationNo=$row[registrationNo]&lastName=$row[lastName]&firstName=$row[firstName]' style='text-decoration:none;'>".$row['lastName'].", ".$row['firstName']."</a>");
$this->coconutTableData("&nbsp;".$row['registeredFrom']."");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}





public function readyForMarkup() {

echo "<style>

.matrix {
font-family:courier;
}

tr:hover { background-color:yellow; color:black;}
a {  border_bottom:10px; color:black; }

</style>";

$connection = mysqli_connect($this->host,$this->username,$this->password,$this->database);      


$result = mysqli_query($connection, "select inventoryCode,description,unitcost from inventory where inventoryType = 'supplies' ") or die("Query fail: " . mysqli_error());

$this->coconutFormStart("post","http://".$this->getMyUrl()."/COCONUT/Reports/markupPrice1.php");
echo "<table border=1 cellspacing=0 cellpadding=1>";
echo "<tr>";
echo "<th></th>";
echo "<th></th>";
echo "<th>Inv#</th>";
echo "<th>Description</th>";
echo "<th>Price</th>";
echo "<th>w/ Markup</th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<th><input type='checkbox' name='inventoryCode[]' value='$row[inventoryCode]'></th>";
echo "<th><input type='checkbox' name='markup[]' value='".(($row['unitcost'] * .50) + $row['unitcost'])."'></th>";
echo "<td>".$row['inventoryCode']."</td>";
echo "<td>".$row['description']."</td>";
echo "<td>".$row['unitcost']."</td>";
echo "<td>".(($row['unitcost'] * .50) + $row['unitcost'])."</td>";
echo "</tr>";
}
echo "</table>";
$this->coconutButton("Proceed");
$this->coconutFormStop();
}




}








?>
