<?php
include("../../../myDatabase2.php");
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];

$ro = new database2();

$month1 = "";

if( $month == "01" ) {
$month1 = "Jan";
}else if( $month == "02" ) {
$month1 = "Feb";
}else if( $month == "03" ) {
$month1 = "Mar";
}else if( $month == "04" ) {
$month1 = "Apr";
}else if( $month == "05" ) {
$month1 = "May";
}else if( $month == "06" ) {
$month1 = "Jun";
}else if( $month == "07" ) {
$month1 = "Jul";
}else if( $month == "08" ) {
$month1 = "Aug";
}else if( $month == "09" ) {
$month1 = "Sep";
}else if( $month == "10" ) {
$month1 = "Oct";
}else if( $month == "11" ) {
$month1 = "Nov";
}else if( $month == "12" ) {
$month1 = "Dec";
}else { }

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

echo "<center>";
echo "<font size=4><b>Mendero Medical Center</b></font>";
echo "<br>";
echo "<font size=3><b>Daily Cashier's Report</b></font>";
echo "<br>";
echo "DATE:&nbsp;".$month1." ".$day.", ".$year;
echo "<br>";
echo "SHIFT:&nbsp;8AM-5PM";
echo "<br><br>";
echo "<table border=0 cellspacing=0 width='100%'>";
echo "<tr>";
echo "<Td>OFFICIAL RECEIPTS</td>";
echo "<Td>FROM&nbsp;&nbsp;&nbsp;&nbsp; ".$ro->selectNow("cashCollection","fromOR","date",$year."-".$month."-".$day)."</td>";
echo "<Td>TO&nbsp;&nbsp;&nbsp;&nbsp;".$ro->selectNow("cashCollection","toOR","date",$year."-".$month."-".$day)."</td>";
echo "<tD>&nbsp;</td>";
echo "</tr>";


echo "<tr>";
echo "<Td><b>TOTAL RECEIPTS FOR THE DAY</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;<b>AMOUNT</b></tD>";
echo "</tr>";


echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;Cash(In-Patient)</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($ro->doubleSelectNow("cashCollection","amount","date",$year."-".$month."-".$day,"type","Cash_Inpatient"),2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($ro->doubleSelectNow("cashCollection","amount","date",$year."-".$month."-".$day,"type","Cash_Inpatient"),2)."</b></tD>";
echo "</tr>";


echo "<tr>";
echo "<Td>&nbsp;<b>HOSPITAL COLLECTION</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


$ro->cashCollection_mmc($year."-".$month."-".$day,"Hospital Collection");

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

$hospital = $ro->cashCollection_mmc_total();
echo "<tr>";
echo "<Td>&nbsp;Total Hospital:</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($hospital,2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($hospital,2)."</b></tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


echo "<tr>";
echo "<Td>&nbsp;<b>PHARMACY COLLECTION</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


$ro->cashCollection_mmc($year."-".$month."-".$day,"Pharmacy Collection");

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

$pharmacy = $ro->cashCollection_mmc_total();
echo "<tr>";
echo "<Td>&nbsp;Total Pharmacy:</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($pharmacy,2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($pharmacy,2)."</b></tD>";
echo "</tr>";




echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


$hospPharmacy = ($hospital + $pharmacy);

$hospitalCollection = ($hospPharmacy + $ro->doubleSelectNow("cashCollection","amount","date",$year."-".$month."-".$day,"type","Cash_Inpatient"));
echo "<tr>";
echo "<Td>&nbsp;<b>TOTAL CASH RECEIPTS</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;<b>".number_format(( $ro->doubleSelectNow("cashCollection","amount","date",$year."-".$month."-".$day,"type","Cash_Inpatient") + $hospPharmacy),2)."</b></tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


echo "<tr>";
echo "<Td>&nbsp;<b>LESS:DISBURSEMENT</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


$ro->cashCollection_mmc($year."-".$month."-".$day,"Disbursement");

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

$disbursement = $ro->cashCollection_mmc_total();
echo "<tr>";
echo "<Td>&nbsp;<b>TOTAL DISBURSEMENT</b>:</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($ro->cashCollection_mmc_total(),2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($ro->cashCollection_mmc_total(),2)."</b></tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;<b>NET CASH RECEIPTS FOR THE DAY</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($hospitalCollection - $disbursement,2)."</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;PREPARED BY:</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;<b>".$ro->selectNow("cashCollection_preparedBy","preparedBy","date",$year."-".$month."-".$day)."</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;NAME OF BILLING:&nbsp;<b>".$ro->selectNow("cashCollection_preparedBy","billingName","date",$year."-".$month."-".$day)."</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


echo "<tr>";
echo "<Td>&nbsp;SHIFT: 8AM-5PM</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "</table>";


echo "<<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->>";

echo "<br><br>";
echo "<font size=5>Receivables<br><font size=2>($year-$month-$day)</font></font>";
echo "<br><br><br>";
echo "<Table border=0 width='100%'>";
echo "<tr>";
echo "<th width='60%'>Particulars</th>";
echo "<th width='20%'>PhilHealth</th>";
echo "<th width='20%'>Company</th>";
echo "</tr>";

echo "<Tr>";
echo "<td>&nbsp;<b>LABORATORY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","LABORATORY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","LABORATORY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","LABORATORY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","LABORATORY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>BLOODBANK</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","BLOODBANK",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","BLOODBANK",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","BLOODBANK",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","BLOODBANK",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>RADIOLOGY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","RADIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","RADIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","RADIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","RADIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>MEDICINE</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","MEDICINE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","MEDICINE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","MEDICINE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","MEDICINE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>SUPPLIES</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","SUPPLIES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","SUPPLIES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","SUPPLIES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","SUPPLIES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>CARDIAC</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIAC",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","CARDIAC",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIAC",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","CARDIAC",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>CARDIOLOGY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","CARDIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","CARDIOLOGY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>ECG</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","ECG",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","ECG",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>ENDOSCOPY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","ENDOSCOPY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","ENDOSCOPY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","ENDOSCOPY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","ENDOSCOPY",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>MISCELLANEOUS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","MISCELLANEOUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","MISCELLANEOUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","MISCELLANEOUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","MISCELLANEOUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>NBS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","NBS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","NBS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","NBS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","NBS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>NITROUS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","NITROUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","NITROUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","NITROUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","NITROUS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>NURSING-CHARGES</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","NURSING-CHARGES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","NURSING-CHARGES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","NURSING-CHARGES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","NURSING-CHARGES",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>OR/DR/ER Fee</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","OR/DR/ER Fee",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","OR/DR/ER Fee",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","OR/DR/ER Fee",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","OR/DR/ER Fee",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>OTHERS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","OTHERS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","OTHERS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","OTHERS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","OTHERS",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>OXYGEN</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","OXYGEN",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","OXYGEN",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","OXYGEN",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","OXYGEN",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>PROFESSIONAL FEE</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","PROFESSIONAL FEE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","PROFESSIONAL FEE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","PROFESSIONAL FEE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","PROFESSIONAL FEE",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>PULSE OXIMETER</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","PULSE_OXIMETER",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","PULSE_OXIMETER",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","PULSE_OXIMETER",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","PULSE_OXIMETER",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";




echo "<Tr>";
echo "<td>&nbsp;<b>REHAB</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","REHAB",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","REHAB",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","REHAB",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","REHAB",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>Room</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","Room and Board",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","Room and Board",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","Room and Board",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","Room and Board",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>VENTILATOR</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","VENTILATOR",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","VENTILATOR",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","VENTILATOR",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","VENTILATOR",$year."-".$month."-".$day,$year."-".$month."-".$day),2)."</center></td>";
echo "</tr>";




echo "</table>";




?>
