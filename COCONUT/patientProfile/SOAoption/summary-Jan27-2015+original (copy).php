<?php
include("../../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];


$ro = new database2();
$ro->getPatientProfile($registrationNo);

$cashz=0;
$phicz=0;
$company=0;
$gt=0;


$hospitalBill_cash=0;
$hospitalBill_phic=0;
$hospitalBill_company=0;
$hospitalBill_gt=0;

$pf_cash=0;
$pf_phic=0;
$pf_company=0;
$pf_gt=0;

$room = preg_split ("/\-/", $ro->getRegistrationDetails_room()); 
$room1 = preg_split ("/\_/",$room[0]); 
$roomRate = $ro->selectNow("room","rate","Description",$ro->getRegistrationDetails_room());

?>

<script type="text/javascript">
function printF(printData)
{
	var a = window.open ('',  '',"status=1,scrollbars=1, width=auto,height=auto");
	a.document.write(document.getElementById(printData).innerHTML.replace(/<a\/?[^>]+>/gi, ''));
	a.document.close();
	a.focus();
	a.print();
	a.close();
}
</script>
<style type="text/css">
<!--
.txtSize {
	font-family: "Times New Roman";
	font-size: 13px;
	color: #000000;
}
.style2 {
	font-family: Arial;
	font-size: 12px;
	font-weight: bold;
	color: #000000;
}
-->
</style>
<a href="#" onClick="printF('printData')" style="text-decoration:none; color:black;">PRINT</a>
<div id='printData' class='style1'>
<?

echo "<center><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/mendero.png' width='45%' height='12%'></center>";

//echo "<center><div style='border:0px solid #000000; width:700px; height:auto; border-color:black black black black;'>";
echo "";
//echo "<center><font size=5><b><a href='#' style='color:#000; text-decoration:none;'>".$ro->getReportInformation("hmoSOA_name")."</a></b></font>";
//echo "<br><font size=2>".$ro->getReportInformation("hmoSOA_address")."</font>";
echo "<center>";
echo "<table border=0>";
echo "<tr>";
echo "<td><span class='txtSize'>Patient#:</span>&nbsp;</td><td><span class='txtSize'>".$ro->getRegistrationDetails_patientNo()."</span></td>";
echo "<td>&nbsp;&nbsp;<span class='txtSize'>Registration#:</span>&nbsp;</td><td>&nbsp;<span class='txtSize'>".$ro->getRegistrationDetails_registrationNo()."</span></td>";

echo "<td>&nbsp;<span class='txtSize'>Room:</span>&nbsp;<span class='txtSize'>".$room1[0]."</span></td>";

echo "</tr>";
echo "<tr>";
echo "<td><span class='txtSize'>Name:</span>&nbsp;</td><td>&nbsp;<a href='#' style='text-decoration:none; font-size:12px; color:black;'>".$ro->getPatientRecord_lastName().", ".$ro->getPatientRecord_firstName()."</a></td>";
echo "<td align='left'>&nbsp;&nbsp;<span class='txtSize'>Physician:</span> </td><td>&nbsp;<span class='txtSize'>".$ro->getAttendingDoc($registrationNo,"Attending")."</span></td>";
echo "<td>&nbsp;<span class='txtSize'>Case:".$ro->selectNow("registrationDetails","privateORhouse_case","registrationNo",$registrationNo)."</span></td>";
echo "</tr>";

echo "<tr>";
echo "<Td><span class='txtSize'>Admitted:</span>&nbsp;</td><td>&nbsp;<span class='txtSize'>".$ro->getRegistrationDetails_dateRegistered()."@".$ro->getRegistrationDetails_timeRegistered()."</span></td>";

//echo "<td>CaseType:</td><TD>".$ro->getRegistrationDetails_caseType()."</tD>";
echo "<Td align='left'>&nbsp;&nbsp;<span class='txtSize'>Discharged:</span>&nbsp;</td><td>&nbsp;<span class='txtSize'>".$ro->getRegistrationDetails_dateUnregistered()."@".$ro->getRegistrationDetails_timeUnregistered()."</span></td>";
echo "</tr>";


if( $ro->selectNow("registrationDetails","LimitHMO","registrationNo",$registrationNo) != "" ) {
$hmoLimit = number_format($ro->selectNow("registrationDetails","LimitHMO","registrationNo",$registrationNo),2);
}else {

if( $ro->selectNow("Company","type","companyName",$ro->getRegistrationDetails_company()) == "insurance" ) {//check kung insurance..
$hmoLimit=number_format(2000,2);
}else {
$hmoLimit="";
}

}



if( $ro->selectNow("registrationDetails","company","registrationNo",$registrationNo) != "" ) {
echo "<tr>";
echo "<td><span class='txtSize'>Company:</span></td>";
echo "<td><span class='txtSize'>".$ro->getRegistrationDetails_company()." - $hmoLimit</span> </td>";
echo "<td>&nbsp;</td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
}else {
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
}


if( $ro->selectNow("registrationDetails","package","registrationNo",$registrationNo) != "" ) {
 $package = $ro->selectNow("registrationDetails","package","registrationNo",$registrationNo); 
 $splitPackage = preg_split ("/\_/", $package); 

echo "<tr>";
if( $ro->getPatientRecord_phic() == "NO" ) {
echo "<Td><span class='txtSize'>Package:</td><td>&nbsp;".$splitPackage[1]." - ".$splitPackage[2]."</span></td>";
}else {
echo "<Td><span class='txtSize'>Package:</td><td>&nbsp;".$splitPackage[1]." - ".$splitPackage[2]."</span></td>";
}
echo "</tr>";
}else { }


//echo "<tr>";
//echo "<Td>".$ro->coconutText("Company").":&nbsp;</td><td>&nbsp;".$ro->getRegistrationDetails_company()."</td>";
//echo "<td>&nbsp;</tD>";
//echo "<Td>".$ro->coconutText("Fx Diagnosis:").":&nbsp;</td><td>&nbsp;".$ro->getRegistrationDetails_finalDiagnosis()."</td>";
//echo "</tr>";

//echo "<tr>";
//echo "<Td>".$ro->coconutText("Room").":&nbsp;</td>";
//echo $ro->getPatientRoom($registrationNo);
//echo "<Td>".$ro->coconutText("Discharged").":&nbsp;</td><td>&nbsp;".$ro->getRegistrationDetails_dateUnregistered()."</td>";
//echo "</tr>";

/*
echo "<tr>";
echo "<Td>".$ro->coconutText("Age")."</tD><td>&nbsp;".$ro->getPatientRecord_age()."</tD>";
echo "<tD>&nbsp;</tD>";
echo "<Td>".$ro->coconutText("Room:")."</tD><td>".$ro->getRegistrationDetails_room()."</tD>";
echo "<td>Case:</td>";
echo "<td>".$ro->selectNow("registrationDetails","privateORhouse_case","registrationNo",$registrationNo)."</td>";
echo "</tr>";
*/
//echo "<tr>";
//echo "<td>".$ro->coconutText("Att.Doctor")."</tD><td>&nbsp;<font size=2>".$ro->getAttendingDoc($registrationNo,"Attending")."</font></td>";
//echo "<td></td>";
//echo "<td>".$ro->coconutText("Admitting Doc")."</td><tD>&nbsp;<font size=2>".$ro->getAttendingDoc($registrationNo,"Admitting")."</font></tD>";
//echo "</tr>";


echo "<tr>";
echo "<td><span class='txtSize'>Address:</span>&nbsp;</tD>";
echo "<tD><span class='txtSize'>".$ro->getPatientRecord_address()."</span></tD>";
echo "</tr>";
echo "</table>";

/*
echo "<table border=0>";
echo "<td><span class='txtSize'>Address:</span>&nbsp;</tD>";
echo "<tD><span class='txtSize'>".$ro->getPatientRecord_address()."</span></tD>";
echo "</table>";
*/



echo "".$ro->checkAllReturns_notification($registrationNo)."<br>".$ro->checkForDispense_notification($registrationNo);
echo "<table border=1 cellpadding=1 cellspacing=0 rules=all>";
echo "<tr>";
echo "<th>&nbsp;Particular&nbsp;</th>";
echo "<th>&nbsp;Actual&nbsp;</th>";
echo "<th>&nbsp;PhilHealth&nbsp;</th>";
echo "<th>&nbsp;Company&nbsp;</th>";
echo "<th>&nbsp;Cash&nbsp;</th>";
echo "</tr>";


echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Room</span> &nbsp;</td>";
if( $ro->getTotal("total","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","Room And Board",$registrationNo),2); echo"</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","Room And Board",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","Room And Board",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



  ////////////// PHIC ROOM
if( $ro->getTotal("phic","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white>'"; echo number_format($ro->getTotal("phic","Room And Board",$registrationNo),2); echo"</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","Room And Board",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","Room And Board",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


 ////////COMPANY ROOM
if( $ro->getTotal("company","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>".number_format($ro->getTotal("company","Room And Board",$registrationNo),2)."</span>&nbsp;</td>";
$company+=$ro->getTotal("company","Room And Board",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","Room And Board",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}



/*******************************************
  ////////////// PHIC ROOM
if( $ro->getTotal("phic","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","Room And Board",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","Room And Board",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","Room And Board",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
******************************************/



if( $ro->getTotal("cashUnpaid","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","Room And Board",$registrationNo),2); echo"</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","Room And Board",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","Room And Board",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";



echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Medicines</span>&nbsp;</td>";

if( $ro->getTotal("total","MEDICINE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","MEDICINE",$registrationNo),2); echo"</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","MEDICINE",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","MEDICINE",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}


   /////// PHIC MEDICINE
if( $ro->getTotal("phic","MEDICINE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","MEDICINE",$registrationNo),2); echo"</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","MEDICINE",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","MEDICINE",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ////// COMPANY MEDICINE
if( $ro->getTotal("company","MEDICINE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","MEDICINE",$registrationNo),2); echo"</span>&nbsp;</td>";
$company+=$ro->getTotal("company","MEDICINE",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","MEDICINE",$registrationNo);
}else {
echo "<Td>&nbsp;</tD>";
}

/********************************
   /////// PHIC MEDICINE
if( $ro->getTotal("phic","MEDICINE",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","MEDICINE",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","MEDICINE",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","MEDICINE",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}

*********************************/



if( $ro->getTotal("cashUnpaid","MEDICINE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","MEDICINE",$registrationNo),2); echo"</span>&nbsp;</td>";
$cashz+=$ro->getTotal("cashUnpaid","MEDICINE",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","MEDICINE",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Supplies</span>&nbsp;</td>";
if( $ro->getTotal("total","SUPPLIES",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","SUPPLIES",$registrationNo),2); echo"</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","SUPPLIES",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","SUPPLIES",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}


      ////// PHIC SUPPLIES
if( $ro->getTotal("phic","SUPPLIES",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","SUPPLIES",$registrationNo),2); echo"</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","SUPPLIES",$registrationNo); //stiop
$hospitalBill_phic += $ro->getTotal("phic","SUPPLIES",$registrationNo);
}else {
echo "<tD>&nbsp;</td>";
}


    ////// COMPANY SUPPLIES
if( $ro->getTotal("company","SUPPLIES",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","SUPPLIES",$registrationNo),2); echo"</span>&nbsp;</td>";
$company+=$ro->getTotal("company","SUPPLIES",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","SUPPLIES",$registrationNo);
}else {
echo "<tD>&nbsp;</td>";
}


/*********************************
      ////// PHIC SUPPLIES
if( $ro->getTotal("phic","SUPPLIES",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","SUPPLIES",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","SUPPLIES",$registrationNo); //stiop
$hospitalBill_phic += $ro->getTotal("phic","SUPPLIES",$registrationNo);
}else {
echo "<tD>&nbsp;</td>";
}
********************************/


if( $ro->getTotal("cashUnpaid","SUPPLIES",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","SUPPLIES",$registrationNo),2); echo"</span>&nbsp;</td>";
$cashz+=$ro->getTotal("cashUnpaid","SUPPLIES",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","SUPPLIES",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Laboratory</span>&nbsp;</td>";
if( $ro->getTotal("total","LABORATORY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","LABORATORY",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","LABORATORY",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","LABORATORY",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}



        /////// PHIC LABORATORY
if( $ro->getTotal("phic","LABORATORY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","LABORATORY",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","LABORATORY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","LABORATORY",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



          ///// COMPANY LABORATORY
if( $ro->getTotal("company","LABORATORY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","LABORATORY",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","LABORATORY",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","LABORATORY",$registrationNo);
}else {
echo "<Td>&nbsp;</tD>";
}



/****************************************
        /////// PHIC LABORATORY
if( $ro->getTotal("phic","LABORATORY",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","LABORATORY",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","LABORATORY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","LABORATORY",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
****************************************/



if( $ro->getTotal("cashUnpaid","LABORATORY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","LABORATORY",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz+=$ro->getTotal("cashUnpaid","LABORATORY",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","LABORATORY",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}
echo "</tr>";


echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Radiology</span>&nbsp;</td>";
if( $ro->getTotal("total","RADIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","RADIOLOGY",$registrationNo),2); echo"</font>&nbsp;</td>";
$gt+=$ro->getTotal("total","RADIOLOGY",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","RADIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}



   ///////////////// PHIC RADIOLOGY
if( $ro->getTotal("phic","RADIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","RADIOLOGY",$registrationNo),2); echo"</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","RADIOLOGY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","RADIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}



  //////// COMPANY RADIOLOGY
if( $ro->getTotal("company","RADIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","RADIOLOGY",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","RADIOLOGY",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","RADIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}


/****************************************
   ///////////////// PHIC RADIOLOGY
if( $ro->getTotal("phic","RADIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","RADIOLOGY",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","RADIOLOGY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","RADIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}
****************************************/


if( $ro->getTotal("cashUnpaid","RADIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","RADIOLOGY",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","RADIOLOGY",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","RADIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";



/************ECG************************/
if( $ro->checkIfTitleExist($registrationNo,"ECG") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>ECG</span>&nbsp;</td>";
if( $ro->getTotal("total","ECG",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","ECG",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","ECG",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","ECG",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}



   ///////////////// PHIC ECG
if( $ro->getTotal("phic","ECG",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","ECG",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","ECG",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","ECG",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}



  //////// COMPANY ECG
if( $ro->getTotal("company","ECG",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","ECG",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","ECG",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","ECG",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}


//CASH ECG
if( $ro->getTotal("cashUnpaid","ECG",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","ECG",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","ECG",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","ECG",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";


}else { }

/**************************************/





/************ENDOSCOPY************************/
if( $ro->checkIfTitleExist($registrationNo,"ENDOSCOPY") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>ENDOSCOPY</span>&nbsp;</td>";
if( $ro->getTotal("total","ENDOSCOPY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","ENDOSCOPY",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","ENDOSCOPY",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","ENDOSCOPY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}



   ///////////////// PHIC ENDOSCOPY
if( $ro->getTotal("phic","ENDOSCOPY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","ENDOSCOPY",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","ENDOSCOPY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","ENDOSCOPY",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}



  //////// COMPANY ENDOSCOPY
if( $ro->getTotal("company","ENDOSCOPY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","ENDOSCOPY",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","ENDOSCOPY",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","ENDOSCOPY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}


//CASH ENDOSCOPY
if( $ro->getTotal("cashUnpaid","ENDOSCOPY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","ENDOSCOPY",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","ENDOSCOPY",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","ENDOSCOPY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";


}else { }

/**************************************/






/************CARDIOLOGY************************/
if( $ro->checkIfTitleExist($registrationNo,"CARDIOLOGY") > 0 ) {
echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>CARDIOLOGY</span>&nbsp;</td>";
if( $ro->getTotal("total","CARDIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","CARDIOLOGY",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","CARDIOLOGY",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","CARDIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}



   ///////////////// PHIC CARDIOLOGY
if( $ro->getTotal("phic","CARDIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","CARDIOLOGY",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","CARDIOLOGY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","CARDIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}



  //////// COMPANY CARDIOLOGY
if( $ro->getTotal("company","CARDIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","CARDIOLOGY",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","CARDIOLOGY",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","CARDIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}


/****************************************
   ///////////////// PHIC RADIOLOGY
if( $ro->getTotal("phic","RADIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","RADIOLOGY",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","RADIOLOGY",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","RADIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</td>";
}
****************************************/

//CASH ECG
if( $ro->getTotal("cashUnpaid","CARDIOLOGY",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","CARDIOLOGY",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","CARDIOLOGY",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","CARDIOLOGY",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";


}else { }

/**************CARDIOLOGY************************/









/*
echo "<tr>";
echo "<td>&nbsp;Nursing Charges&nbsp;</td>";
if( $ro->getTotal("total","NURSING-CHARGES",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","NURSING-CHARGES",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","NURSING-CHARGES",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","NURSING-CHARGES",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   /////////// PHIC NURSING-CHARGES
if( $ro->getTotal("phic","NURSING-CHARGES",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","NURSING-CHARGES",$registrationNo),2); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","NURSING-CHARGES",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","NURSING-CHARGES",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



    ////////// COMPANY NURSING-CHARGES
if( $ro->getTotal("company","NURSING-CHARGES",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","NURSING-CHARGES",$registrationNo),2); echo"&nbsp;</td>";
$company+=$ro->getTotal("company","NURSING-CHARGES",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","NURSING-CHARGES",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/********************************************

   /////////// PHIC NURSING-CHARGES
if( $ro->getTotal("phic","NURSING-CHARGES",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","NURSING-CHARGES",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","NURSING-CHARGES",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","NURSING-CHARGES",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*******************************************/

/*
if( $ro->getTotal("cashUnpaid","NURSING-CHARGES",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","NURSING-CHARGES",$registrationNo),2); echo"&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","NURSING-CHARGES",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","NURSING-CHARGES",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";
*/


echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Miscellaneous</span>&nbsp;</td>";
if( $ro->getTotal("total","MISCELLANEOUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","MISCELLANEOUS",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","MISCELLANEOUS",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","MISCELLANEOUS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



    ///////// PHIC MISCELLANEOUS
if( $ro->getTotal("phic","MISCELLANEOUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","MISCELLANEOUS",$registrationNo),2); echo"</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","MISCELLANEOUS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","MISCELLANEOUS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


      ////// COMPANY MISCELLANEOUS
if( $ro->getTotal("company","MISCELLANEOUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","MISCELLANEOUS",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","MISCELLANEOUS",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","MISCELLANEOUS",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/****************************************
    ///////// PHIC MISCELLANEOUS
if( $ro->getTotal("phic","MISCELLANEOUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","MISCELLANEOUS",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","MISCELLANEOUS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","MISCELLANEOUS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
***************************************/



if( $ro->getTotal("cashUnpaid","MISCELLANEOUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","MISCELLANEOUS",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","MISCELLANEOUS",$registrationNo);
$hospitalBill_cash +=  $ro->getTotal("cashUnpaid","MISCELLANEOUS",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";









/*

echo "<tr>";
echo "<td>&nbsp;Others&nbsp;</td>";
if( $ro->getTotal("total","OTHERS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","OTHERS",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","OTHERS",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","OTHERS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


   /////////// PHIC OTHERS
if( $ro->getTotal("phic","OTHERS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","OTHERS",$registrationNo),2); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","OTHERS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","OTHERS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


   ////// COMPANY OTHERS
if( $ro->getTotal("company","OTHERS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","OTHERS",$registrationNo),2); echo"&nbsp;</td>";
$company+=$ro->getTotal("company","OTHERS",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","OTHERS",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/****************************************************
   /////////// PHIC OTHERS
if( $ro->getTotal("phic","OTHERS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","OTHERS",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","OTHERS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","OTHERS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
***************************************************/


/*
if( $ro->getTotal("cashUnpaid","OTHERS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","OTHERS",$registrationNo),2); echo"&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","OTHERS",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","OTHERS",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

*/


///////////////OR/DR/ER FEE

if( $ro->checkIfTitleExist($registrationNo,"OR/DR/ER FEE") ) {

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>OR/DR/ER/ICU Fee</span>&nbsp;</td>";
if( $ro->getTotal("total","OR/DR/ER FEE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","OR/DR/ER FEE",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","OR/DR/ER FEE",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","OR/DR/ER FEE",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


  //////// PHIC OR/DR/ER
if( $ro->getTotal("phic","OR/DR/ER FEE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","OR/DR/ER FEE",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","OR/DR/ER Fee",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","OR/DR/ER FEE",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


   ////// COMPANY OR/DR/ER 
if( $ro->getTotal("company","OR/DR/ER FEE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","OR/DR/ER FEE",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","OR/DR/ER FEE",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","OR/DR/ER FEE",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/*******************************************
  //////// PHIC OR/DR/ER
if( $ro->getTotal("phic","OR/DR/ER Fee",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","OR/DR/ER Fee",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","OR/DR/ER Fee",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","OR/DR/ER Fee",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*******************************************/


if( $ro->getTotal("cashUnpaid","OR/DR/ER FEE",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","OR/DR/ER FEE",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","OR/DR/ER FEE",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","OR/DR/ER FEE",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else { }

///////////OR/DR/ER FEEE




if( $ro->selectNow("reportHeading","information","reportName","rehab") == "Activate" ) {


/////REHAB START

if( $ro->checkIfTitleExist($registrationNo,"REHAB") ) {

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>Rehab</span>&nbsp;</td>";
if( $ro->getTotal("total","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","REHAB",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","REHAB",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY REHAB
if( $ro->getTotal("company","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","REHAB",$registrationNo),2); echo "</span>&nbsp;</td>";

$company+=$ro->getTotal("company","REHAB",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","REHAB",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","REHAB",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","REHAB",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","REHAB",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";



/////REHAB END

}else { }

}else {

}





if( $ro->checkIfTitleExist($registrationNo,"OXYGEN") > 0  ) {

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>OXYGEN</span>&nbsp;</td>";
if( $ro->getTotal("total","OXYGEN",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","OXYGEN",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","OXYGEN",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","OXYGEN",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC OXYGEN
if( $ro->getTotal("phic","OXYGEN",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","OXYGEN",$registrationNo),2); echo "</span></font>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","OXYGEN",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","OXYGEN",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY OXYGEN
if( $ro->getTotal("company","OXYGEN",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","OXYGEN",$registrationNo),2); echo "</span>&nbsp;</td>";

$company+=$ro->getTotal("company","OXYGEN",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","OXYGEN",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","OXYGEN",$registrationNo) > 0 ) {
echo "<td>&nbsp; <span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","OXYGEN",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","OXYGEN",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","OXYGEN",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else { }






if( $ro->checkIfTitleExist($registrationNo,"NITROUS") > 0  ) {

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>NITROUS</span>&nbsp;</td>";
if( $ro->getTotal("total","NITROUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","NITROUS",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","NITROUS",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","NITROUS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC OXYGEN
if( $ro->getTotal("phic","NITROUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","NITROUS",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","NITROUS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","NITROUS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY OXYGEN
if( $ro->getTotal("company","NITROUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","NITROUS",$registrationNo),2); echo "</span>&nbsp;</td>";
$company+=$ro->getTotal("company","NITROUS",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","NITROUS",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","NITROUS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","NITROUS",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","NITROUS",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","NITROUS",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else { }






/////////  GENERATOR CHARGE  /////////


//if( $ro->checkIfTitleExist($registrationNo,"GENERATOR_CHARGE") > 0  ) {

/*
echo "<tr>";
echo "<td>&nbsp;<a href='http://".$ro->getMyUrl()."/COCONUT/systemBiller/generatorCharge/checkGenerator.php?registrationNo=$registrationNo&username=$username' style='text-decoration:none; color:black;'>Generator</a>&nbsp;</td>";
if( $ro->getTotal("total","GENERATOR_CHARGE",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","GENERATOR_CHARGE",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","GENERATOR_CHARGE",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","GENERATOR_CHARGE",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}

*/

/*   
///////////////// PHIC GENERATOR
if( $ro->getTotal("phic","GENERATOR_CHARGE",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","GENERATOR_CHARGE",$registrationNo),2); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","GENERATOR_CHARGE",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","GENERATOR_CHARGE",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}

*/
/*
    ///////////// COMPANY GENERATOR
if( $ro->getTotal("company","GENERATOR_CHARGE",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","GENERATOR_CHARGE",$registrationNo),2); echo"&nbsp;</td>";

$company+=$ro->getTotal("company","GENERATOR_CHARGE",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","GENERATOR_CHARGE",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}
*/

/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/

/*
if( $ro->getTotal("cashUnpaid","GENERATOR_CHARGE",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","GENERATOR_CHARGE",$registrationNo),2); echo"&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","GENERATOR_CHARGE",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","GENERATOR_CHARGE",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";
*/
//}else { }


//////// GENERATOR CHARGE //////







if( $ro->selectNow("reportHeading","information","reportName","dialysis") == "Activate" ) {

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>DIALYSIS</span>&nbsp;</td>";
if( $ro->getTotal("total","DIALYSIS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","DIALYSIS",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","DIALYSIS",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","DIALYSIS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC DIALYSIS
if( $ro->getTotal("phic","DIALYSIS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<font color='white'>"; echo number_format($ro->getTotal("phic","DIALYSIS",$registrationNo),2); echo "</font>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","DIALYSIS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","DIALYSIS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY DIALYSIS
if( $ro->getTotal("company","DIALYSIS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","DIALYSIS",$registrationNo),2); echo"&nbsp;</td>";

$company+=$ro->getTotal("company","DIALYSIS",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","DIALYSIS",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","DIALYSIS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","DIALYSIS",$registrationNo),2); echo"&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","DIALYSIS",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","DIALYSIS",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else {

}



if( $ro->selectNow("reportHeading","information","reportName","nbs") == "Activate" ) {



////////////NBS START

if( $ro->checkIfTitleExist($registrationNo,"NBS") > 0 ) {

echo "<tr>";
echo "<td>&nbsp;NBS/HEPA B/BCG&nbsp;</td>";
if( $ro->getTotal("total","NBS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","NBS",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","NBS",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","NBS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC NBS
if( $ro->getTotal("phic","NBS",$registrationNo) > 0 ) {
echo "<td>&nbsp;<font color='white'>"; echo number_format($ro->getTotal("phic","NBS",$registrationNo),2); echo "</font>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","NBS",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","NBS",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY NBS
if( $ro->getTotal("company","NBS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","NBS",$registrationNo),2); echo"&nbsp;</td>";

$company+=$ro->getTotal("company","NBS",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","NBS",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","NBS",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","NBS",$registrationNo),2); echo"&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","NBS",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","NBS",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else { }


/////////////NBS END





}else {

}




//////////////CARDIAC

if( $ro->checkIfTitleExist($registrationNo,"CARDIAC") > 0 ) {

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>CARDIAC</span>&nbsp;</td>";
if( $ro->getTotal("total","CARDIAC",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","CARDIAC",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","CARDIAC",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","CARDIAC",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC NBS
if( $ro->getTotal("phic","CARDIAC",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","CARDIAC",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","CARDIAC",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","CARDIAC",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY NBS
if( $ro->getTotal("company","CARDIAC",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","CARDIAC",$registrationNo),2); echo"</span>&nbsp;</td>";

$company+=$ro->getTotal("company","CARDIAC",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","CARDIAC",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","CARDIAC",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","CARDIAC",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","CARDIAC",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","CARDIAC",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else { }

/////////////CARDIAC














//////////////BLOODBANK

if( $ro->checkIfTitleExist($registrationNo,"BLOODBANK") > 0  ) {
echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>BLOODBANK</span>&nbsp;</td>";
if( $ro->getTotal("total","BLOODBANK",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class-'txtSize'>"; echo number_format($ro->getTotal("total","BLOODBANK",$registrationNo),2); echo "</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","BLOODBANK",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","BLOODBANK",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC NBS
if( $ro->getTotal("phic","BLOODBANK",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","BLOODBANK",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","BLOODBANK",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","BLOODBANK",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY NBS
if( $ro->getTotal("company","BLOODBANK",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","BLOODBANK",$registrationNo),2); echo "</span>&nbsp;</td>";

$company+=$ro->getTotal("company","BLOODBANK",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","BLOODBANK",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","BLOODBANK",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","BLOODBANK",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","BLOODBANK",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","BLOODBANK",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else {  }

/////////////BLOOD BANK











//////////////VENTILATOR

if( $ro->checkIfTitleExist($registrationNo,"VENTILATOR") > 0  ) {
echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>VENTILATOR</span>&nbsp;</td>";
if( $ro->getTotal("total","VENTILATOR",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","VENTILATOR",$registrationNo),2); echo"</span> &nbsp;</td>";
$gt+=$ro->getTotal("total","VENTILATOR",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","VENTILATOR",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC VENTILATOR
if( $ro->getTotal("phic","VENTILATOR",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","VENTILATOR",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","VENTILATOR",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","VENTILATOR",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY VENTILATOR
if( $ro->getTotal("company","VENTILATOR",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","VENTILATOR",$registrationNo),2); echo "</span>&nbsp;</td>";

$company+=$ro->getTotal("company","VENTILATOR",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","VENTILATOR",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","VENTILATOR",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","VENTILATOR",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","VENTILATOR",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","VENTILATOR",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else {  }

/////////////VENTILATOR









//////////////PULSE OXIMETER

if( $ro->checkIfTitleExist($registrationNo,"PULSE_OXIMETER") > 0  ) {
echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'>PULSE OXIMETER</span>&nbsp;</td>";
if( $ro->getTotal("total","PULSE_OXIMETER",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("total","PULSE_OXIMETER",$registrationNo),2); echo"</span>&nbsp;</td>";
$gt+=$ro->getTotal("total","PULSE_OXIMETER",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","PULSE_OXIMETER",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



   ///////////////// PHIC PULSE_OXIMETER
if( $ro->getTotal("phic","PULSE_OXIMETER",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><font color='white'>"; echo number_format($ro->getTotal("phic","PULSE_OXIMETER",$registrationNo),2); echo "</font></span>&nbsp;</td>";
$phicz+=$ro->getTotal("phic","PULSE_OXIMETER",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","PULSE_OXIMETER",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


    ///////////// COMPANY PULSE_OXIMETER
if( $ro->getTotal("company","PULSE_OXIMETER",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("company","PULSE_OXIMETER",$registrationNo),2); echo "</span>&nbsp;</td>";

$company+=$ro->getTotal("company","PULSE_OXIMETER",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","PULSE_OXIMETER",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}


/**********************************************
   ///////////////// PHIC REHAB
if( $ro->getTotal("phic","REHAB",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","REHAB",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","REHAB",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","REHAB",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
*********************************************/


if( $ro->getTotal("cashUnpaid","PULSE_OXIMETER",$registrationNo) > 0 ) {
echo "<td>&nbsp;<span class='txtSize'>"; echo number_format($ro->getTotal("cashUnpaid","PULSE_OXIMETER",$registrationNo),2); echo "</span>&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","PULSE_OXIMETER",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","PULSE_OXIMETER",$registrationNo);
}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";

}else {  }

/////////////VENTILATOR












/*
echo "<tr>";
echo "<td>&nbsp;<font size=2>Room @ ".$ro->getQTY_room($registrationNo)." day(s)</font> &nbsp;</td>";
if( $ro->getTotal("total","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","Room And Board",$registrationNo),2); echo"&nbsp;</td>";
$gt+=$ro->getTotal("total","Room And Board",$registrationNo);
$hospitalBill_gt += $ro->getTotal("total","Room And Board",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}



  ////////////// PHIC ROOM
if( $ro->getTotal("phic","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","Room And Board",$registrationNo),2); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","Room And Board",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","Room And Board",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}


 ////////COMPANY ROOM
if( $ro->getTotal("company","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","Room And Board",$registrationNo),2); echo"&nbsp;</td>";
$company+=$ro->getTotal("company","Room And Board",$registrationNo);
$hospitalBill_company += $ro->getTotal("company","Room And Board",$registrationNo);
}else {
echo "<tD>&nbsp;</tD>";
}



/*******************************************
  ////////////// PHIC ROOM
if( $ro->getTotal("phic","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","Room And Board",$registrationNo),0); echo"&nbsp;</td>";
$phicz+=$ro->getTotal("phic","Room And Board",$registrationNo);
$hospitalBill_phic += $ro->getTotal("phic","Room And Board",$registrationNo);
}else {
echo "<Td>&nbsp;</td>";
}
******************************************/


/*
if( $ro->getTotal("cashUnpaid","Room And Board",$registrationNo) > 0 ) {
echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","Room And Board",$registrationNo),2); echo"&nbsp;</td>";
$cashz += $ro->getTotal("cashUnpaid","Room And Board",$registrationNo);
$hospitalBill_cash += $ro->getTotal("cashUnpaid","Room And Board",$registrationNo);


}else {
echo "<td>&nbsp;</tD>";
}
echo "</tr>";
*/

echo "<tr>";
echo "<td>&nbsp;<span class='txtSize'><b>Hospital Bill</b></span></td>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_gt,2)."</b></span></tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_phic,2)."</b></span></tD>";
echo "<tD>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_company,2)."</b></span></tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_cash,2)."</b></span></tD>";
echo "</tr>";




$ro->getPatientDoc_setter($registrationNo);

echo "<tr>";
echo "<td>&nbsp;&nbsp;<br></td>";
if( $ro->getTotal("total","PROFESSIONAL FEE",$registrationNo) > 0 ) {
//echo "<td>&nbsp;"; echo number_format($ro->getTotal("total","PROFESSIONAL FEE",$registrationNo),0); echo"&nbsp;</td>";
echo "<Td>&nbsp;</tD>";
$pf_gt+=$ro->getPatient_total();
}else {
echo "<Td>&nbsp;</td>";
}





   ///////// COMPANY PROFESSIONAL FEE
if( $ro->getTotal("company","PROFESSIONAL FEE",$registrationNo) > 0 ) {
//echo "<td>&nbsp;"; echo number_format($ro->getTotal("company","PROFESSIONAL FEE",$registrationNo),0); echo"&nbsp;</td>";
$pf_company+=$ro->getPatient_company();
}else {
echo "<tD>&nbsp;</tD>";
}



    /////////////// PHIC PROFESSIONAL FEE
if( $ro->getTotal("phic","PROFESSIONAL FEE",$registrationNo) > 0 ) {
//echo "<td>&nbsp;"; echo number_format($ro->getTotal("phic","PROFESSIONAL FEE",$registrationNo),0); echo"&nbsp;</td>";
$pf_phic+=$ro->getPatient_phic();
}else {
echo "<Td>&nbsp;</td>";
}



if( $ro->getTotal("cashUnpaid","PROFESSIONAL FEE",$registrationNo) > 0 ) {
//echo "<td>&nbsp;"; echo number_format($ro->getTotal("cashUnpaid","PROFESSIONAL FEE",$registrationNo),0); echo"&nbsp;</td>";
$pf_cash += $ro->getPatient_cashUnpaid();
}else {
echo "<td>&nbsp;</tD>";
}

echo "<td></td>";


echo "</tr>";



//$ro->getPatientDoc($registrationNo);
//$gross = (  $cashz - $ro->getPaymentHistory_showUp_returnPaid() );
//$disc = $ro->getRegistrationDetails_discount() * $gross;


echo "<tr>";
echo "<td><span class='txtSize'><b>Professional Fee</b></span></tD>";
echo "<td>&nbsp;<b></b></tD>";
echo "<td>&nbsp;<b></b></tD>";
echo "<td>&nbsp;<b></b></tD>";
//echo "<td>&nbsp;<b>".$pf_phic."</b></tD>";
echo "<td>&nbsp;<b></b></tD>";
echo "<tr>";



$ro->getPatientDoc($registrationNo);



echo "<tr>";
echo "<td><b></b></tD>";
echo "<td><span class='txtSize'><center><b>".$pf_gt."</b></center></span></tD>";
echo "<td><span class='txtSize'><center><b>".$pf_phic."</b></center></span></tD>";
echo "<td><span class='txtSize'><center><b>".$pf_company."</b></center></span></tD>";
//echo "<td>&nbsp;<b>".$pf_phic."</b></tD>";
echo "<td><span class='txtSize'><center><b>".$pf_cash."</b></center></span></tD>";
echo "<tr>";

echo "<tr>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<tr>";


if( $ro->selectNow("registrationDetails","package","registrationNo",$registrationNo) != "" ) {
$package = $ro->selectNow("registrationDetails","package","registrationNo",$registrationNo); 
$splitPackage = preg_split ("/\_/", $package); 
}else {
$package = "0_0_0"; 
$splitPackage = preg_split ("/\_/", $package); 
}
echo "<Tr>";
echo "<td>&nbsp;<span class='txtSize'><b>Total</b></span></tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_gt + $pf_gt,2)."</b></span>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_phic + $pf_phic,2)."</b></span>&nbsp;</tD>";

echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_company + $pf_company ,2)."</b></span>&nbsp;</tD>";
//echo "<td>&nbsp;<b>".number_format($hospitalBill_phic + $pf_phic,2)."</b>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($hospitalBill_cash + $pf_cash ,2)."</b></span>&nbsp;</tD>";
echo "</tr>";

$companyDiscount = $ro->selectNow("registrationDetails","companyDiscount","registrationNo",$registrationNo);

echo "<Tr>";
echo "<td>&nbsp;<span class='txtSize'>Discount</span> </tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";

if( $companyDiscount != "" ) {
echo "<td>&nbsp;<span class='txtSize'>".number_format($companyDiscount,2)."</span>&nbsp;</tD>";
}else {
echo "<td>&nbsp;</tD>";
}

if( $ro->getRegistrationDetails_discount() != "" ) {
echo "<td>&nbsp;<span class='txtSize'>".number_format(( $ro->getRegistrationDetails_discount()),2)."</span>&nbsp;</tD>";
}else {
echo "<td>&nbsp;<span class='txtSize'>0.00</span>&nbsp;</tD>";
}
echo "</tr>";
//}


$gross = (  $cashz - $ro->getPaymentHistory_showUp_returnPaid() );
$disc = $ro->getRegistrationDetails_discount() * $gross;

$grandTotalCompany = ($hospitalBill_company + $pf_company);
$grandTotalCompany1 = ($grandTotalCompany - $companyDiscount);
$grandTotalPHIC = ($hospitalBill_phic + $pf_phic);

echo "<Tr>";
echo "<td>&nbsp;<span class='txtSize'><b>Grand Total</b></span></tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize'>".number_format($grandTotalPHIC,2)."</span></tD>";

if( $grandTotalCompany1 != "" ) {
echo "<td>&nbsp;<span class='txtSize'>".number_format($grandTotalCompany1,2)."</span></tD>";
}else {
echo "<td>&nbsp;</tD>";
}

echo "<td>&nbsp;<span class='txtSize'><b>".number_format(($gross - $ro->getRegistrationDetails_discount()  ) + $pf_cash,2)."</b></span>&nbsp;</tD>";
echo "</tr>";



$grandTotalz = ($gross - $ro->getRegistrationDetails_discount()  ) + $pf_cash;

//$ro->getPaymentHistory_showUp_returnPaid_setter($registrationNo);
//$netTotal = (  ( ($gross - $ro->getRegistrationDetails_discount()   ) - $ro->getPaymentHistory_showUp_returnPaid() ) -  $ro->sumPartial($registrationNo) );
//if( $netTotal < 0 ) $netTotal=0; 

//echo "<Tr>";
//echo "<td>&nbsp;<b>Payment's</b></tD>";
//echo "<td>&nbsp;</tD>";
//echo "<td>&nbsp;</tD>";
//echo "<td>&nbsp;</tD>";
//echo "<td>&nbsp;<b>".number_format( $ro->getPaymentHistory_showUp_returnPaid() ,2)."</b>&nbsp;</tD>";
//echo "</tr>";

//$paidz1 = (( $ro->sumPartial_new($registrationNo,"amountPaid") + $ro->sumPartial_new($registrationNo,"pf")) + $ro->sumPartial_new($registrationNo,"admitting") );


$ro->descPartialPayment($registrationNo,$username); //ipakita ung payment ng px na cash
$ro->getCompanyPayment($registrationNo,$ro->getRegistrationDetails_company()); //ipakita ung payment ng px s company
$ro->getPHICPayment($registrationNo); //ipakita ung payment ng px sa phic


echo "<Tr>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;</tD>";
//echo "<td>&nbsp;<b>".number_format( $ro->sumPartial_new($registrationNo) ,2)."</b>&nbsp;</tD>";
echo "</tr>";
$refund = $ro->doubleSelectNow("patientPayment","amountPaid","registrationNo",$registrationNo,"paymentFor","REFUND");
echo "<tr>";
echo "<Td>&nbsp;<span class='txtSize'><b>REFUND</b></span></td>";
echo "<TD></tD>";
echo "<td></td>";
echo "<td></td>";
echo "<TD><span class='txtSize'>".number_format($refund,2)."</span></tD>";
echo "</tr>";

$totalCompanyPayment = ( ($ro->getCompanyPayment_total + $ro->getCompanyPayment_discount) + $ro->getCompanyPayment_tax() );

echo "<Tr>";
echo "<td>&nbsp;<span class='txtSize'><b>Balance</b></span></tD>";
echo "<td>&nbsp;</tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format(($grandTotalPHIC - $ro->getPHICPayment_total()),2)."</b></span></tD>";
echo "<td>&nbsp;<span class='txtSize'><b>".number_format($grandTotalCompany1 - $totalCompanyPayment,2)."</b></span></tD>";
$paidz = ( $ro->sumPartial_new($registrationNo,"amountPaid"));

//$remainBalance = ( $grandTotalz - $ro->sumPartial_new($registrationNo) );
$remainBalance = ( $grandTotalz - $ro->descPartialPayment_total() );

if( $remainBalance > 0 ) {
echo "<td>&nbsp;<span class='txtSize'><b>".number_format( $remainBalance,2)."</b></span>&nbsp;</tD>";
}else {
echo "<td>&nbsp;<span class='txtSize'><b>".number_format( $remainBalance + $refund ,2)."</b></span>&nbsp;</tD>";
}

echo "</tr>";


echo "</table>";
//echo "<font size=2>Payment's</font>";
//$ro->getPaymentHistory_showUp($registrationNo);
echo "
<Table border=0>
<td>
__________________________<br><font size=2>Signature over Printed Name</font><br><font size=3>Informant & Relationship:___________________________</font></font>
</tD>
<tD width='40%'>&nbsp;</tD>


</table>
<Br>
<Table width='110%'>
<tD>
<font size=2><u>Tina Marie Mansueto</u><Br><b>Billing Section</b></font>
</tD>


<tD>


<font size=2><u>Tina Marie Mansueto</u><Br><b>Cashier</b></font>
</tD>
</table>
<Br>



<font size=2>".date("M_d_Y")."@".date("H:i:s")."</font>

<br>";
$ro->coconutBoxStop();
?>
</div>
