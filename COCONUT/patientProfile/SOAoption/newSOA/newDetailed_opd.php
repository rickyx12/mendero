<?php
include("../../../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$show = $_GET['show'];

$ro = new database2();
$ro->getPatientProfile($registrationNo);
$ro->soap_setter($registrationNo);
?>

<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/myCSS/coconutCSS.css" />

<?php

$medicineTotal = 0;
$suppliesTotal = 0;
$laboratoryTotal = 0;
$radiologyTotal = 0;
$miscTotal = 0;
$bloodBankTotal = 0;
$ecgTotal = 0;
$cardiologyTotal = 0;
$ordrTotal = 0;
$rehabTotal = 0;
$oxygenTotal = 0;
$nitrousTotal = 0;
$dialysisTotal = 0;
$nbsTotal = 0;
$cardiacTotal = 0;
$ventilatorTotal = 0;
$endoscopyTotal = 0;
$pulseOximeterTotal = 0;
$pfTotal = 0;


$medicineBalance = 0;
$suppliesBalance = 0;
$laboratoryBalance = 0;
$radiologyBalance = 0;
$miscBalance = 0;
$bloodBankBalance = 0;
$ecgBalance = 0;
$cardiologyBalance = 0;
$ordrBalance = 0;
$rehabBalance = 0;
$oxygenBalance = 0;
$nitrousBalance = 0;
$dialysisBalance = 0;
$nbsBalance = 0;
$cardiacBalance = 0;
$ventilatorBalance = 0;
$endoscopyBalance = 0;
$pulseOximeterBalance = 0;
$pfBalance = 0;


$medicinePaid = 0;
$suppliesPaid = 0;
$laboratoryPaid = 0;
$radiologyPaid = 0;
$miscPaid = 0;
$bloodBankPaid = 0;
$ecgPaid = 0;
$cardiologyPaid = 0;
$ordrPaid = 0;
$rehabPaid = 0;
$oxygenPaid = 0;
$nitrousPaid = 0;
$dialysisPaid = 0;
$nbsPaid = 0;
$cardiacPaid = 0;
$ventilatorPaid = 0;
$endoscopyPaid = 0;
$pulseOximeterPaid = 0;
$pfPaid = 0;


$medicineDiscount = 0;
$suppliesDiscount = 0;
$laboratoryDiscount = 0;
$radiologyDiscount = 0;
$miscDiscount = 0;
$bloodBankDiscount = 0;
$ecgDiscount = 0;
$cardiologyDiscount = 0;
$ordrDiscount = 0;
$rehabDiscount = 0;
$oxygenDiscount = 0;
$nitrousDiscount = 0;
$dialysisDiscount = 0;
$nbsDiscount = 0;
$cardiacDiscount = 0;
$ventilatorDiscount = 0;
$endoscopyDiscount = 0;
$pulseOximeterDiscount = 0;
$pfDiscount = 0;



echo "<style type='text/css'>
a { text-decoration:none; color:black; }
tr:hover { background-color:yellow;color:black;}

</style>";


echo "<center><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/mendero.png' width='50%' height='25%'></center>";

echo "<br><center><div style='border:0px solid #000000; width:825px; height:auto; border-color:black black black black;'>";
//echo "<font size=4><b>".$ro->getReportInformation("hmoSOA_name")."</b></font><br>";
//echo "<font size=2>".$ro->getReportInformation("hmoSOA_address")."</font><br>";
//echo "<font size=2>".$ro->getRegistrationDetails_branch()."</font><br>";
echo "<table border=0>";
echo "<tr>";
echo "<td><font class='labelz'><b>Name:</b></font></td><td><font size=2>".$ro->getPatientRecord_completeName()."</font></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<Td><font class='labelz'><b>Registration#:</b></font></td>";
echo "<td><font size=2>".$ro->getRegistrationDetails_registrationNo()."</td>";
echo "</tr>";
echo "<tr>";
echo "<Td><font class='labelz'><B>Age:</b></td>";
echo "<Td><font size=2>".$ro->getPatientRecord_age()." yrs Old</font></td>";
echo "<Td>&nbsp;</td>";
echo "<td><font class='labelz'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Senior:</b></font></td>";
echo "<td><font size=2>".$ro->getPatientRecord_senior()."</font></td>";
echo "</tr>";
echo "<tr>";
echo "<Td><font class='labelz'><b>Company:</b></font></td>";
echo "<td><font size=2>".$ro->getRegistrationDetails_company()."</font></tD>";
echo "<td><font class='labelz'>Diagnosis:</font></td>";
echo "<tD><font class='labelz'>".$ro->soap_assessmentz()." &nbsp;&nbsp; ".$ro->selectNow("registrationDetails","finalDiagnosis","registrationNo",$registrationNo)."</font></tD>";
echo "</tr>";
echo "</table>";
echo "<hr>";

echo "<Table border=0 cellpadding=0 cellspacing=0>";
echo "<tr>";
echo  "<th>&nbsp;<font class='heading'><b>DATE</b></font>&nbsp;</th>";
//echo  "<th>&nbsp;<font class='heading'><b>Ref#</b></font>&nbsp;</th>";
echo "<th width='30%'>&nbsp;<font class='heading'><b>Particulars</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font class='heading'><b>QTY</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font class='heading'><b>Price</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font class='heading'><b>Disc</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font class='heading'><b>Total</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font class='heading'><b>Balance</b></font>&nbsp;</th>";
echo  "<th>&nbsp;<font class='heading'><b>Paid</b></font>&nbsp;</th>";
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

/*********************MEDICINE*********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"MEDICINE") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Medicine</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_inventory_opd($registrationNo,"MEDICINE");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_inventory_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_inventory_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_inventory_opd_cashUnpaid,2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_inventory_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$medicineTotal += $ro->newDetailed_inventory_opd_total();
$medicineBalance += $ro->newDetailed_inventory_opd_cashUnpaid();
$medicinePaid += $ro->newDetailed_inventory_opd_cashPaid();
$medicineDiscount += $ro->newDetailed_inventory_opd_discount();
}else { }
/********************MEDICINE************************/


/*********************SUPPLIES*********************/
if( $ro->checkIfTitleExist_newDetailed($registrationNo,"SUPPLIES") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Supplies</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_inventory_opd($registrationNo,"SUPPLIES");

echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_inventory_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_inventory_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_inventory_opd_cashUnpaid,2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_inventory_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";;
$suppliesTotal += $ro->newDetailed_inventory_opd_total();
$suppliesBalance += $ro->newDetailed_inventory_opd_cashUnpaid();
$suppliesPaid += $ro->newDetailed_inventory_opd_cashPaid();
$suppliesDiscount += $ro->newDetailed_inventory_opd_discount();
}else { }
/************************SUPPLIES****************************/


/*****************LABORATORY*********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"LABORATORY") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Laboratory</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"LABORATORY");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$laboratoryTotal += $ro->newDetailed_opd_total();
$laboratoryBalance += $ro->newDetailed_opd_cashUnpaid();
$laboratoryPaid += $ro->newDetailed_opd_cashPaid();
$laboratoryDiscount += $ro->newDetailed_opd_discount();
}else { }
/******************LABORATORY**********************/


/*****************RADIOLOGY************************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"RADIOLOGY") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Radiology</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"RADIOLOGY");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$radiologyTotal += $ro->newDetailed_opd_total();
$radiologyBalance += $ro->newDetailed_opd_cashUnpaid();
$radiologyPaid += $ro->newDetailed_opd_cashPaid();
$radiologyDiscount += $ro->newDetailed_opd_discount();
}else { }
/********************RADIOLOGY**********************/


/******************MISCELLANEOUS*********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"MISCELLANEOUS") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Miscellaneous</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"MISCELLANEOUS");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$miscTotal += $ro->newDetailed_opd_total();
$miscBalance += $ro->newDetailed_opd_cashUnpaid();
$miscPaid += $ro->newDetailed_opd_cashPaid();
$miscDiscount += $ro->newDetailed_opd_discount();
}else { }

/***************MISCELLANEOUS*********************/

/*************BLOODBANK*********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"BLOODBANK") > 0 ) {

echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Blood Bank</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"BLOODBANK");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$bloodBankTotal += $ro->newDetailed_opd_total();
$bloodBankBalance += $ro->newDetailed_opd_cashUnpaid();
$bloodBankPaid += $ro->newDetailed_opd_cashPaid();
$bloodBankDiscount += $ro->newDetailed_opd_discount();
}else { }

/*************BLOODBANK*********************/




/****************ECG************************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"ECG") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>ECG</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"ECG");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$ecgTotal += $ro->newDetailed_opd_total();
$ecgBalance += $ro->newDetailed_opd_cashUnpaid();
$ecgPaid += $ro->newDetailed_opd_cashPaid();
$ecgDiscount += $ro->newDetailed_opd_discount();
}else { }

/***************ECG************************/




/*****************CARDIOLOGY****************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"CARDIOLOGY") > 0 ) {

echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Cardiology</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"CARDIOLOGY");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$cardiologyTotal += $ro->newDetailed_opd_total();
$cardiologyBalance += $ro->newDetailed_opd_cashUnpaid();
$cardiologyPaid += $ro->newDetailed_opd_cashPaid();
$cardiologyDiscount += $ro->newDetailed_opd_discount();
}else { }

/*******************CARDIOLOGY**************************/



/*******************OR/DR/ER FEE************************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"OR/DR/ER Fee") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>OR/DR/ER Fee</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"OR/DR/ER FEE");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$ordrTotal += $ro->newDetailed_opd_total();
$ordrBalance += $ro->newDetailed_opd_cashUnpaid();
$ordrPaid += $ro->newDetailed_opd_cashPaid();
$ordrDiscount += $ro->newDetailed_opd_discount();
}else { }

/*******************OR/DR/ER FEE************************/



/*******************REHAB**********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"REHAB") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Rehab</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"REHAB");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$rehabTotal += $ro->newDetailed_opd_total();
$rehabBalance += $ro->newDetailed_opd_cashUnpaid();
$rehabPaid += $ro->newDetailed_opd_cashPaid();
$rehabDiscount += $ro->newDetailed_opd_discount();
}else { }

/**********************REHAB****************************/


/***********************OXYGEN*************************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"OXYGEN") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Oxygen</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"OXYGEN");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$oxygenTotal += $ro->newDetailed_opd_total();
$oxygenBalance += $ro->newDetailed_opd_cashUnpaid();
$oxygenPaid += $ro->newDetailed_opd_cashPaid();
$oxygenDiscount += $ro->newDetailed_opd_discount();
}else { }

/**********************OXYGEN*****************************/



/***********************NITROUS***********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"NITROUS") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>NITROUS</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"NITROUS");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$nitrousTotal += $ro->newDetailed_opd_total;
$nitrousBalance += $ro->newDetailed_opd_cashUnpaid();
$nitrousPaid += $ro->newDetailed_opd_cashPaid();
$nitrousDiscount += $ro->newDetailed_opd_discount();
}else { }

/*****************NITROUS************************/



/******************DIALYSIS********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"DIALYSIS") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Dialysis</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"DIALYSIS");

echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$dialysisTotal += $ro->newDetailed_opd_total();
$dialysisBalance += $ro->newDetailed_opd_cashUnpaid();
$dialysisPaid += $ro->newDetailed_opd_cashPaid();
$dialysisDiscount += $ro->newDetailed_opd_discount();
}else { }

/*******************DIALYSIS************************/


/******************NBS***********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"NBS") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>NBS</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"NBS");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$nbsTotal += $ro->newDetailed_opd_total();
$nbsBalance += $ro->newDetailed_opd_cashUnpaid();
$nbsPaid += $ro->newDetailed_opd_cashPaid();
$nbsDiscount += $ro->newDetailed_opd_discount();
}else { }
/**************NBS**************************/



/********************CARDIAC***********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"CARDIAC") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Cardiac</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"CARDIAC");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$cardiacTotal += $ro->newDetailed_opd_total();
$cardiacBalance += $ro->newDetailed_opd_cashUnpaid();
$cardiacPaid += $ro->newDetailed_opd_cashPaid();
$cardiacDiscount += $ro->newDetailed_opd_discount();
}else { }

/**********************CARDIAC**********************/

/********************VENTILATOR********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"VENTILATOR") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Ventilator</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"VENTILATOR");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$ventilatorTotal += $ro->newDetailed_opd_total();
$ventilatorBalance += $ro->newDetailed_opd_cashUnpaid();
$ventilatorPaid += $ro->newDetailed_opd_cashPaid();
$ventilatorDiscount += $ro->newDetailed_opd_discount();
}else { }
/****************VENTILATOR***********************/





/********************ENDOSCOPY*******************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"ENDOSCOPY") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Endoscopy</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"ENDOSCOPY");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".$ro->newDetailed_opd_cashPaid()."</b></font></td>";
echo "</tr>";
$endoscopyTotal += $ro->newDetailed_opd_total();
$endoscopyBalance += $ro->newDetailed_opd_cashUnpaid();
$endoscopyPaid += $ro->newDetailed_opd_cashPaid();
$endoscopyDiscount += $ro->newDetailed_opd_discount();
}else { }
/****************ENDOSCOPY***********************/




/******************PULSE_OXIMETER*******************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"PULSE_OXIMETER") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Pulse Oximeter</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"PULSE_OXIMETER");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$pulseOximeterTotal += $ro->newDetailed_opd_total();
$pulseOximeterBalance += $ro->newDetailed_opd_cashUnpaid();
$pulseOximeterPaid += $ro->newDetailed_opd_cashPaid();
$pulseOximeterDiscount += $ro->newDetailed_opd_discount();
}else { }

/********************PULSE_OXIMETER**********************/


/****************PF**********************/

if( $ro->checkIfTitleExist_newDetailed($registrationNo,"PROFESSIONAL FEE") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<font size=2><b>Professional Fee</b></font></td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

$ro->newDetailed_opd($registrationNo,"PROFESSIONAL FEE");


echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Total=></b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_discount(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_total(),2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($ro->newDetailed_opd_cashUnpaid(),2)."</b></font></td>";
echo "<td>&nbsp;<font size=2><b>".number_format($ro->newDetailed_opd_cashPaid(),2)."</b></font></td>";
echo "</tr>";
$pfTotal += $ro->newDetailed_opd_total();
$pfBalance += $ro->newDetailed_opd_cashUnpaid();
$pfPaid += $ro->newDetailed_opd_cashPaid();
$pfDiscount += $ro->newDetailed_opd_discount();
}else { }

/***********************PF***********************/

$grandTotal = ( $medicineTotal + $suppliesTotal + $laboratoryTotal + $radiologyTotal + $miscTotal + $bloodBankTotal + $ecgTotal + $cardiologyTotal + $ordrTotal + $rehabTotal + $oxygenTotal + $nitrousTotal + $dialysisTotal + $nbsTotal + $cardiacTotal + $ventilatorTotal + $endoscopyTotal + $pulseOximeterTotal + $pfTotal);

$balanceTotal = ( $medicineBalance + $suppliesBalance + $laboratoryBalance + $radiologyBalance + $miscBalance + $bloodBankBalance + $ecgBalance + $cardiologyBalance + $ordrBalance + $rehabBalance + $oxygenBalance + $nitrousBalance + $dialysisBalance + $nbsBalance + $cardiacBalance + $ventilatorBalance + $endoscopyBalance + $pulseOximeterBalance + $pfBalance);

$paidTotal = ( $medicinePaid + $suppliesPaid + $laboratoryPaid + $radiologyPaid + $miscPaid + $bloodBankPaid + $ecgPaid + $cardiologyPaid + $ordrPaid + $rehabPaid + $oxygenPaid + $nitrousPaid + $dialysisPaid + $nbsPaid + $cardiacPaid + $ventilatorPaid + $endoscopyPaid + $pulseOximeterPaid + $pfPaid);

$discountTotal = ( $medicineDiscount + $suppliesDiscount + $laboratoryDiscount + $radiologyDiscount + $miscDiscount + $bloodBankDiscount + $ecgDiscount + $cardiologyDiscount + $ordrDiscount + $rehabDiscount + $oxygenDiscount + $nitrousDiscount + $dialysisDiscount + $nbsDiscount + $cardiacDiscount + $ventilatorDiscount + $endoscopyDiscount + $pulseOximeterDiscount + $pfDiscount);

echo "<tr>";
echo "<td>&nbsp;</td>";
//echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;</td>";
echo "<td>&nbsp;<font size=2><b>Grand Total</b></font></td>";
echo "<td><font size=2><b>".number_format($discountTotal,2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($grandTotal,2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($balanceTotal,2)."</b></font></td>";
echo "<td><font size=2><b>".number_format($paidTotal,2)."</b></font></td>";
echo "</tr>";

echo "</table>";
echo "<br>";
echo "</div>";
