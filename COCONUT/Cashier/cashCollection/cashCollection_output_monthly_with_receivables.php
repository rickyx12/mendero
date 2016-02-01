<?php
include("../../../myDatabase2.php");
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$month1 = $_GET['month1'];
$day1 = $_GET['day1'];
$year1 = $_GET['year1'];

$ro = new database2();

$date1 = $year."-".$month."-".$day;
$date2 = $year1."-".$month1."-".$day1;

$monthWord1 = "";
$monthWord2 = "";

if( $month == "01" ) {
$monthWord1 = "Jan";
}else if( $month == "02" ) {
$monthWord1 = "Feb";
}else if( $month == "03" ) {
$monthWord1 = "Mar";
}else if( $month == "04" ) {
$monthWord1 = "Apr";
}else if( $month == "05" ) {
$monthWord1 = "May";
}else if( $month == "06" ) {
$monthWord1 = "Jun";
}else if( $month == "07" ) {
$monthWord1 = "Jul";
}else if( $month == "08" ) {
$monthWord1 = "Aug";
}else if( $month == "09" ) {
$monthWord1 = "Sep";
}else if( $month == "10" ) {
$monthWord1 = "Oct";
}else if( $month == "11" ) {
$monthWord1 = "Nov";
}else if( $month == "12" ) {
$monthWord1 = "Dec";
}else { }


if( $month1 == "01" ) {
$monthWord2 = "Jan";
}else if( $month1 == "02" ) {
$monthWord2 = "Feb";
}else if( $month1 == "03" ) {
$monthWord2 = "Mar";
}else if( $month1 == "04" ) {
$monthWord2 = "Apr";
}else if( $month1 == "05" ) {
$monthWord2 = "May";
}else if( $month1 == "06" ) {
$monthWord2 = "Jun";
}else if( $month1 == "07" ) {
$monthWord2 = "Jul";
}else if( $month1 == "08" ) {
$monthWord2 = "Aug";
}else if( $month1 == "09" ) {
$monthWord2 = "Sep";
}else if( $month1 == "10" ) {
$monthWord2 = "Oct";
}else if( $month1 == "11" ) {
$monthWord2 = "Nov";
}else if( $month1 == "12" ) {
$monthWord2 = "Dec";
}else { }

echo "
<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";

echo "<center>";
echo "<font size=4><b>Mendero Medical Center</b></font>";
echo "<br>";
echo "<font size=3><b>Monthly Cashier's Report</b></font>";
echo "<br>";
echo "<b><i>".$date1." to ".$date2."</b></i>";
//echo "<br>";
//echo "SHIFT:&nbsp;8AM-5PM";
echo "<br><br>";
echo "<table border=0 cellspacing=0 width='100%'>";
/*
echo "<tr>";
echo "<Td>OFFICIAL RECEIPTS</td>";
echo "<Td>FROM&nbsp;&nbsp;&nbsp;&nbsp; ".$ro->selectNow("cashCollection","fromOR","date",$year."-".$month."-".$day)."</td>";
echo "<Td>TO&nbsp;&nbsp;&nbsp;&nbsp;".$ro->selectNow("cashCollection","toOR","date",$year."-".$month."-".$day)."</td>";
echo "<tD>&nbsp;</td>";
echo "</tr>";
*/

echo "<tr>";
echo "<Td><b>TOTAL RECEIPTS</b></td>";
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
echo "<tD>&nbsp;".number_format($ro->cashCollection_mmc_customTotal_monthly($date1,$date2,"Cash_Inpatient"),2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($ro->cashCollection_mmc_customTotal_monthly($date1,$date2,"Cash_Inpatient"),2)."</b></tD>";
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


$ro->cashCollection_mmc_monthly($date1,$date2,"Hospital Collection");

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";


echo "<tr>";
echo "<Td>&nbsp;Total Cash:</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($ro->cashCollection_mmc_monthly_total(),2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($ro->cashCollection_mmc_monthly_total(),2)."</b></tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

$hospitalCollection = ($ro->cashCollection_mmc_monthly_total() + $ro->cashCollection_mmc_customTotal_monthly($date1,$date2,"Cash_Inpatient"));
echo "<tr>";
echo "<Td>&nbsp;<b>TOTAL CASH RECEIPTS</b></td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;<b>".number_format($hospitalCollection,2)."</b></tD>";
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


$ro->cashCollection_mmc_monthly($date1,$date2,"Disbursement");

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

$disbursement = $ro->cashCollection_mmc_monthly_total();
echo "<tr>";
echo "<Td>&nbsp;<b>TOTAL DISBURSEMENT</b>:</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;".number_format($ro->cashCollection_mmc_monthly_total(),2)."</tD>";
echo "<tD>&nbsp;<b>".number_format($ro->cashCollection_mmc_monthly_total(),2)."</b></tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;</td>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "<tD>&nbsp;</tD>";
echo "</tr>";

echo "<tr>";
echo "<Td>&nbsp;<b>NET CASH RECEIPTS<br> ($date1 to $date2)</b></td>";
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
/*
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
*/
echo "</table>";



echo "<<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->>";

$laboratoryTotal="";
$laboratory_phic="";
$laboratory_company="";

$bloodBankTotal="";
$bloodBank_phic="";
$bloodBank_company="";

$radiologyTotal="";
$radiology_phic="";
$radiology_company="";

$medicineTotal="";
$medicine_phic="";
$medicine_company="";

$suppliesTotal="";
$supplies_phic="";
$supplies_company="";

$cardiacTotal="";
$cardiac_phic="";
$cardiac_company="";

$cardiologyTotal="";
$cardiology_phic="";
$cardiology_company="";

$ecgTotal="";
$ecg_phic="";
$ecg_company="";

$endoscopyTotal="";
$endoscopy_phic="";
$endoscopy_company="";

$miscellaneousTotal="";
$miscellaneous_phic="";
$miscellaneous_company="";

$nbsTotal="";
$nbs_phic="";
$nbs_company="";

$nitrousTotal="";
$nitrous_phic="";
$nitrous_company="";

$nursingChargesTotal="";
$nursingCharges_phic="";
$nursingCharges_company="";

$or_drTotal="";
$or_dr_phic="";
$or_dr_company="";

$othersTotal="";
$others_company="";
$others_phic="";

$oxygenTotal="";
$oxygen_company="";
$oxygen_phic="";

$professionalFeeTotal="";
$professionalFee_company="";
$professionalFee_phic="";

$pulseOximeterTotal="";
$pulseOximeter_company="";
$pulseOximeter_phic="";

$rehabTotal="";
$rehab_company="";
$rehab_phic="";

$roomTotal="";
$room_company="";
$room_phic="";

$ventilatorTotal="";
$ventilator_company="";
$ventilator_phic="";

echo "<br><br>";
echo "<font size=5>Receivables</font><br><font size=2>($date1 to $date2)</font>";
echo "<br><br><br>";
echo "<Table border=0 width='100%'>";
echo "<tr>";
echo "<th width='55%'></th>";
echo "<th width='15%'>PhilHealth</th>";
echo "<th width='15%'>Company</th>";
echo "<th width='15%'></th>";
echo "</tr>";

echo "<Tr>";
echo "<td>&nbsp;<b>LABORATORY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","LABORATORY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","LABORATORY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","LABORATORY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","LABORATORY",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","LABORATORY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","LABORATORY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","LABORATORY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","LABORATORY",$date1,$date2)),2)."</center></td>";


$laboratory_phic = ( $ro->get_total_phic_or_company_notInventory("phic","OPD","LABORATORY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","LABORATORY",$date1,$date2));

$laboratory_company = ( $ro->get_total_phic_or_company_notInventory("company","OPD","LABORATORY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","IPD","LABORATORY",$date1,$date2));

$laboratoryTotal = ( $laboratory_phic + $laboratory_company );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>BLOODBANK</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","BLOODBANK",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","BLOODBANK",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","BLOODBANK",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","BLOODBANK",$date1,$date2)),2)."</center></td>";

echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","BLOODBANK",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","BLOODBANK",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","IPD","BLOODBANK",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","BLOODBANK",$date1,$date2)),2)."</center></td>";


$bloodBank_company = ($ro->get_total_phic_or_company_notInventory("company","IPD","BLOODBANK",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","BLOODBANK",$date1,$date2));

$bloodBank_phic = ($ro->get_total_phic_or_company_notInventory("phic","IPD","BLOODBANK",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","BLOODBANK",$date1,$date2));

$bloodBankTotal = ( $bloodBank_phic + $bloodBank_company );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>RADIOLOGY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","RADIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","RADIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","OPD","RADIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","RADIOLOGY",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","RADIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","RADIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","RADIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","RADIOLOGY",$date1,$date2)),2)."</center></td>";


$radiology_company = ($ro->get_total_phic_or_company_notInventory("company","IPD","RADIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","RADIOLOGY",$date1,$date2));


$radiology_phic = ($ro->get_total_phic_or_company_notInventory("phic","IPD","RADIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","RADIOLOGY",$date1,$date2));

$radiologyTotal = ( $radiology_company + $radiology_phic );


echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>MEDICINE</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","MEDICINE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","MEDICINE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","MEDICINE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","MEDICINE",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","MEDICINE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","MEDICINE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","MEDICINE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","MEDICINE",$date1,$date2)),2)."</center></td>";


$medicine_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","MEDICINE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","MEDICINE",$date1,$date2) );

$medicine_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","MEDICINE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","MEDICINE",$date1,$date2) );

$medicineTotal = ( $medicine_company + $medicine_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>SUPPLIES</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","SUPPLIES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","SUPPLIES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","SUPPLIES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","SUPPLIES",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","SUPPLIES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","SUPPLIES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","SUPPLIES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","SUPPLIES",$date1,$date2)),2)."</center></td>";

$supplies = ($ro->get_total_phic_or_company_notInventory("company","IPD","SUPPLIES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","SUPPLIES",$date1,$date2));


$supplies_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","SUPPLIES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","SUPPLIES",$date1,$date2) );

$supplies_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","SUPPLIES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","SUPPLIES",$date1,$date2) );

$suppliesTotal = ( $supplies_company + $supplies_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>CARDIAC</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIAC",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","CARDIAC",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","CARDIAC",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIAC",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIAC",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","CARDIAC",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","CARDIAC",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIAC",$date1,$date2)),2)."</center></td>";


$cardiac_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","CARDIAC",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","CARDIAC",$date1,$date2) );

$cardiac_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIAC",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIAC",$date1,$date2) );

$cardiacTotal = ( $cardiac_company + $cardiac_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>CARDIOLOGY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","CARDIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","CARDIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIOLOGY",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","CARDIOLOGY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","CARDIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIOLOGY",$date1,$date2)),2)."</center></td>";


$cardiology_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","CARDIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","CARDIOLOGY",$date1,$date2) );

$cardiology_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","CARDIOLOGY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","CARDIOLOGY",$date1,$date2) );

$cardiologyTotal = ( $cardiology_company + $cardiology_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>ECG</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","ECG",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","ECG",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","ECG",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","ECG",$date1,$date2)),2)."</center></td>";


$ecg_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","ECG",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","ECG",$date1,$date2) );

$ecg_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","ECG",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","ECG",$date1,$date2) );

$ecgTotal = ( $ecg_company + $ecg_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>ENDOSCOPY</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","ENDOSCOPY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","ENDOSCOPY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","ENDOSCOPY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","ENDOSCOPY",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","ENDOSCOPY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","ENDOSCOPY",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","ENDOSCOPY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","ENDOSCOPY",$date1,$date2)),2)."</center></td>";


$endoscopy_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","ENDOSCOPY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","ENDOSCOPY",$date1,$date2) );

$endoscopy_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","ENDOSCOPY",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","ENDOSCOPY",$date1,$date2) );

$endoscopyTotal = ( $endoscopy_company + $endoscopy_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>MISCELLANEOUS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","MISCELLANEOUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","MISCELLANEOUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","MISCELLANEOUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","MISCELLANEOUS",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","MISCELLANEOUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","MISCELLANEOUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","IPD","MISCELLANEOUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","MISCELLANEOUS",$date1,$date2)),2)."</center></td>";


$miscellaneous_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","MISCELLANEOUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","MISCELLANEOUS",$date1,$date2) );

$miscellaneous_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","MISCELLANEOUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","MISCELLANEOUS",$date1,$date2) );

$miscellaneousTotal = ( $miscellaneous_company + $miscellaneous_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>NBS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","NBS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","NBS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","NBS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","NBS",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","NBS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","NBS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","NBS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","NBS",$date1,$date2)),2)."</center></td>";


$nbs_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","NBS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","NBS",$date1,$date2) );

$nbs_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","NBS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","NBS",$date1,$date2) );

$nbsTotal = ( $nbs_company + $nbs_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>NITROUS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","NITROUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","NITROUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","OPD","NITROUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","NITROUS",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","NITROUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","NITROUS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","IPD","NITROUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","NITROUS",$date1,$date2)),2)."</center></td>";


$nitrous_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","NITROUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","NITROUS",$date1,$date2) );

$nitrous_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","NITROUS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","NITROUS",$date1,$date2) );

$nitrousTotal = ($nitrous_company + $nitrous_phic);

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>NURSING-CHARGES</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","NURSING-CHARGES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","NURSING-CHARGES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","NURSING-CHARGES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","NURSING-CHARGES",$date1,$date2)),2)."</center></td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","NURSING-CHARGES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","NURSING-CHARGES",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","NURSING-CHARGES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","NURSING-CHARGES",$date1,$date2)),2)."</center></td>";


$nursingCharges_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","NURSING-CHARGES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","NURSING-CHARGES",$date1,$date2) );

$nursingCharges_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","NURSING-CHARGES",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","NURSING-CHARGES",$date1,$date2) );

$nursingChargesTotal = ( $nursingCharges_company + $nursingCharges_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>OR/DR/ER Fee</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","OR/DR/ER Fee",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","OR/DR/ER Fee",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","OPD","OR/DR/ER Fee",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","OR/DR/ER Fee",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","OR/DR/ER Fee",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","OR/DR/ER Fee",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","IPD","OR/DR/ER Fee",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","OR/DR/ER Fee",$date1,$date2)),2)."</center></td>";

$or_dr_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","OR/DR/ER Fee",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","OR/DR/ER Fee",$date1,$date2) );

$or_dr_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","OR/DR/ER Fee",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","OR/DR/ER Fee",$date1,$date2) );

$or_drTotal = ( $or_dr_company + $or_dr_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>OTHERS</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","OTHERS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","OTHERS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","OPD","OTHERS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","OTHERS",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","OTHERS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","OTHERS",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","OTHERS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","OTHERS",$date1,$date2)),2)."</center></td>";


$others_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","OTHERS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","OTHERS",$date1,$date2) );

$others_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","OTHERS",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","OTHERS",$date1,$date2) );

$othersTotal = ( $others_company + $others_phic );


echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>OXYGEN</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","OXYGEN",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","OXYGEN",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","OXYGEN",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","OXYGEN",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","OXYGEN",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","OXYGEN",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","OXYGEN",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","OXYGEN",$date1,$date2)),2)."</center></td>";


$oxygen_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","OXYGEN",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","OXYGEN",$date1,$date2) );

$oxygen_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","OXYGEN",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","OXYGEN",$date1,$date2) );

$oxygenTotal = ( $oxygen_company + $oxygen_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>PROFESSIONAL FEE</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","PROFESSIONAL FEE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","PROFESSIONAL FEE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","PROFESSIONAL FEE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","PROFESSIONAL FEE",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","PROFESSIONAL FEE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","PROFESSIONAL FEE",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","PROFESSIONAL FEE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","PROFESSIONAL FEE",$date1,$date2)),2)."</center></td>";

$professionalFee_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","PROFESSIONAL FEE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","PROFESSIONAL FEE",$date1,$date2) );

$professionalFee_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","PROFESSIONAL FEE",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","PROFESSIONAL FEE",$date1,$date2) );

$professionalFeeTotal = ( $professionalFee_company + $professionalFee_phic );

echo "</tr>";


echo "<Tr>";
echo "<td>&nbsp;<b>PULSE OXIMETER</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","PULSE_OXIMETER",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","PULSE_OXIMETER",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","PULSE_OXIMETER",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","PULSE_OXIMETER",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","PULSE_OXIMETER",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","PULSE_OXIMETER",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","IPD","PULSE_OXIMETER",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","PULSE_OXIMETER",$date1,$date2)),2)."</center></td>";

$pulseOximeter_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","PULSE_OXIMETER",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","PULSE_OXIMETER",$date1,$date2) );

$pulseOximeter_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","PULSE_OXIMETER",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","PULSE_OXIMETER",$date1,$date2) );

$pulseOximeterTotal = ( $pulseOximeter_company + $pulseOximeter_phic );

echo "</tr>";




echo "<Tr>";
echo "<td>&nbsp;<b>REHAB</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","REHAB",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","REHAB",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","OPD","REHAB",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","REHAB",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","REHAB",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","REHAB",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","REHAB",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","REHAB",$date1,$date2)),2)."</center></td>";


$rehab_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","REHAB",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","REHAB",$date1,$date2) );

$rehab_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","REHAB",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","REHAB",$date1,$date2) );

$rehabTotal = ( $rehab_company + $rehab_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>Room</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","Room and Board",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","Room and Board",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","OPD","Room and Board",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","Room and Board",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","Room and Board",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","Room and Board",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","Room and Board",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","Room and Board",$date1,$date2)),2)."</center></td>";

$room_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","Room and Board",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","Room and Board",$date1,$date2) );

$room_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","Room and Board",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","Room and Board",$date1,$date2) );

$roomTotal = ( $room_company + $room_phic );

echo "</tr>";



echo "<Tr>";
echo "<td>&nbsp;<b>VENTILATOR</b></td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Outpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","OPD","VENTILATOR",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","OPD","VENTILATOR",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format(($ro->get_total_phic_or_company_notInventory("company","OPD","VENTILATOR",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","VENTILATOR",$date1,$date2)),2)."</center></td>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;&nbsp;Inpatient</td>";
echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("phic","IPD","VENTILATOR",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format($ro->get_total_phic_or_company_notInventory("company","IPD","VENTILATOR",$date1,$date2),2)."</center></td>";

echo "<td><center>".number_format( ($ro->get_total_phic_or_company_notInventory("company","IPD","VENTILATOR",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","IPD","VENTILATOR",$date1,$date2)),2)."</center></td>";


$ventilator_company = ( $ro->get_total_phic_or_company_notInventory("company","IPD","VENTILATOR",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("company","OPD","VENTILATOR",$date1,$date2) );

$ventilator_phic = ( $ro->get_total_phic_or_company_notInventory("phic","IPD","VENTILATOR",$date1,$date2) + $ro->get_total_phic_or_company_notInventory("phic","OPD","VENTILATOR",$date1,$date2) );

$ventilatorTotal = ( $ventilator_company + $ventilator_phic );

echo "</tr>";


$grandTotal = ( $laboratoryTotal + $bloodBankTotal + $radiologyTotal + $medicineTotal + $suppliesTotal + $cardiacTotal +$cardiologyTotal + $ecgTotal + $endoscopyTotal + $miscellaneousTotal + $nbsTotal + $nitrousTotal + $nursingChargesTotal + $or_drTotal + $othersTotal + $pulseOximeterTotal + $rehabTotal + $roomTotal + $ventilatorTotal);

$companyGT = ( $laboratory_company + $bloodBank_company + $radiology_company + $medicine_company + $supplies_company + $cardiac_company + $cardiology_company + $ecg_company + $endoscopy_company + $miscellaneous_company + $nbs_company + $nitrous_company + $nursingCharges_company + $or_dr_company + $others_company + $pulseOximeter_company + $rehab_company + $room_company + $ventilator_company);

$phicGT = ( $laboratory_phic + $bloodBank_phic + $radiology_phic + $medicine_phic + $supplies_phic + $cardiac_phic + $cardiology_phic + $ecg_phic + $endoscopy_phic + $miscellaneous_phic + $nbs_phic + $nitrous_phic + $nursingCharges_phic + $or_dr_phic + $others_phic + $pulseOximeter_phic + $rehab_phic + $room_phic + $ventilator_phic);


echo "<tr>";
echo "<tr>";
echo "<td>&nbsp;<b>HOSPITAL</b></td>";
echo "<td>&nbsp;".number_format($phicGT,2)."</td>";
echo "<td>&nbsp;".number_format($companyGT,2)."</td>";
echo "<td>&nbsp;<font color=red>".number_format($grandTotal,2)."</font></td>";
echo "</tr>";
echo "</tr>";

echo "<tr>";
echo "<tr>";
echo "<td>&nbsp;<b>PROFESSIONAL FEE</b></td>";
echo "<td>&nbsp;".number_format($professionalFee_phic,2)."</td>";
echo "<td>&nbsp;".number_format($professionalFee_company,2)."</td>";
echo "<td>&nbsp;".number_format($professionalFeeTotal,2)."</td>";
echo "</tr>";
echo "</tr>";


echo "</table>";


?>
