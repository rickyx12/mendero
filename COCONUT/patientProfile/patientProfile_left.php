<?php
include("../../myDatabase2.php");
//require_once('../authentication.php');
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];

$ro = new database2();

$ro->getBatchNo();
$myFile = $ro->getReportInformation("homeRoot")."/COCONUT/trackingNo/batchNo.dat";
$fh = fopen($myFile, 'r');
$batchNo = fread($fh, 100);
fclose($fh);


echo "

<style type='text/css'>
a 
{ 
text-decoration:none;
color:black;
font-weight:bold;
 }
ul { list-style-type:none; }
display: block;
</style>

";

$ro->getPatientProfile($registrationNo);

if($ro->selectNow("registeredUser","module","username",$ro->getRegistrationDetails_registeredBy()) == "MI") {
echo "<br><hr><font size=2 color=blue>".$ro->getPatientRecord_lastName()." ".$ro->getPatientRecord_firstName()." ".$ro->getPatientRecord_middleName().".</font><hr>";
}else {
echo "<br><hr>

<font size=2 color=red>".htmlentities($ro->getPatientRecord_lastName())." ".htmlentities($ro->getPatientRecord_firstName())." ".htmlentities($ro->getPatientRecord_middleName())."</font>

<hr>";
}


echo "<ul>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientProfile_right.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username' target='rightFrame'><font size=2>Information</font></a></li>";


if($ro->getRegistrationDetails_caseType() != "") {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/phicLimit/show_phicLimit.php?registrationNo=$registrationNo&casetype=".$ro->getRegistrationDetails_caseType()."' target='rightFrame'><font size=2>Credit Limit</font></a></li>";
}else {
echo "";
}


/*
if($ro->getRegistrationDetails_room() != "OPD_OPD") {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/creditLimit/viewCreditLimit.php?registrationNo=$registrationNo&username=$username' target='rightFrame'><font size=2>Credit Limit</font></a></li>";
}else {
echo "";
}
*/

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientCharges.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&show=All&desc=' target='rightFrame'><font size=2>Charges</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=PROFESSIONAL FEE&username=$username&show=&desc=' target='rightFrame'><font size=2>Doctor</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=LABORATORY&username=$username&show=&desc=' target='rightFrame'><font size=2>Laboratory</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=RADIOLOGY&username=$username&show=&desc=' target='rightFrame'><font size=2>Radiology</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=ENDOSCOPY&username=$username&show=&desc=' target='rightFrame'><font size=2>Endoscopy</font></a></li>";


echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=MEDICINE&username=$username&show=&desc=' target='rightFrame'><font size=2>Medicine</font></a></li>";

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=SUPPLIES&username=$username&show=&desc=' target='rightFrame'><font size=2>Supplies</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=MISCELLANEOUS&username=$username&show=&desc=' target='rightFrame'><font size=2>Miscellaneous</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=OR/DR/ER Fee&username=$username&show=&desc=' target='rightFrame'><font size=2>OR/DR/ER/ICU Fee</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=Oxygen&username=$username&show=&desc=' target='rightFrame'><font size=2>Oxygen</font></a></li>";



//check if rehab is activated 
if( $ro->selectNow("reportHeading","information","reportName","rehab") == "Activate" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=REHAB&username=$username&show=&desc=' target='rightFrame'><font size=2>Rehab</font></a></li>";
}else { }

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=OTHERS&username=$username&show=&desc=' target='rightFrame'><font size=2>Others</font></a></li>";

if($ro->getRegistrationDetails_room() != "OPD_OPD") { // enable room
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientChargesTitle.php?registrationNo=$registrationNo&title=Room And Board&username=$username&show=&desc=' target='rightFrame'><font size=2>Room</font></a></li>";
}else { //disable room
echo "";
}
echo "</ul>";

echo "<ul>";



/////////// LOCKED ACCOUNT KAPAG CONSUMED NA UNG LIMIT ////////////////////////

if( $ro->selectNow("registrationDetails","mgh","registrationNo",$registrationNo) == "" ) { // enable charges kung hindi pa MGH

if( $ro->getRegistrationDetails_type() == "OR/DR" || $ro->getRegistrationDetails_type() == "OPD" ) {

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";

}else {

$totalBalanceNow = ( $ro->getTotal("cashUnpaid","",$registrationNo) - $ro->getAllPayment($registrationNo) );

if( $ro->getRegistrationDetails_company() != "" ) { //kpg may hmo

if( $ro->selectNow("registrationDetails","LimitHMO","registrationNo",$registrationNo) != "" ) { //meron hmo limit

if( $totalBalanceNow >= $ro->selectNow("registrationDetails","LimitHMO","registrationNo",$registrationNo) ) { //mas mataas n ung total balance kaysa sa hmo limit


if( $ro->selectNow("registeredUser","module","username",$username) == "PHARMACY" || $ro->selectNow("registeredUser","module","username",$username) == "CASHIER" ) { //kpg pharmacy or cashier pwede mag charge
echo "<li>".$ro->coconutImages_return("locked1.jpeg")."<a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2 color=red>Charges Cart</font></a></li>";
}else {

if( $ro->checkPermission($registrationNo) != "" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";
}else {
 //kpg ndi pharmacy or cashier ndi pde mag charge
echo $ro->coconutImages_return("locked1.jpeg")."<font size=2 color=blue>[LOCKED ACCOUNT]</font><br><font size=2 color=red>".$ro->selectNow("registrationDetails","LimitHMO","registrationNo",$registrationNo)." Limit of ".$ro->getRegistrationDetails_company()." for this Patient is Already Consumed</font>";
}

}


}else { //mas mababa pa ung total balance ng patient kaysa sa limit ng hmo
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";
}

}else { 

//code sa walang limit n hmo 
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";

}




}else if( $ro->getPatientRecord_phic() == "YES" ) {

if( $totalBalanceNow <= 7000 ) { //kpg PHIC set LIMIT to 7000
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";
}else {
if( $ro->checkPermission($registrationNo) != "" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";
}else if( $ro->selectNow("registeredUser","module","username",$username) == "CASHIER" || $ro->selectNow("registeredUser","module","username",$username) == "PHARMACY" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'>".$ro->coconutImages_return("locked1.jpeg")."<font size=2 color=red>Charges Cart</font></a></li>";
}else {
echo $ro->coconutImages_return("locked1.jpeg")."<font size=2 color=blue>[LOCKED ACCOUNT]</font><br><font size=2 color=red>7,000 Limit for this Patient is Already Consumed</font>";
}

}

}else { //kpg walang PHIC at HMO set LIMIT to 5000


if( $totalBalanceNow <= 5000 ) { //kpg PHIC set LIMIT to 5000

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";

}else {

if( $ro->checkPermission($registrationNo) != "" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";
}else if( $ro->selectNow("registeredUser","module","username",$username) == "CASHIER" || $ro->selectNow("registeredUser","module","username",$username) == "PHARMACY" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/chargesCartPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'>".$ro->coconutImages_return("locked1.jpeg")."<font size=2 color=red>Charges Cart</font></a></li>";
}else {
echo $ro->coconutImages_return("locked1.jpeg")."<font size=2 color=blue>[LOCKED ACCOUNT]</font><br><font size=2 color=red>5,000 Limit for this Patient is Already Consumed</font>";
}

}


}

}

}else { }

/////////// LOCKED ACCOUNT KAPAG CONSUMED NA UNG LIMIT ////////////////////////


//temporary habang hindi ko p inimplement ung locked account
//echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/ECART/cartHandler.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username&room=".$ro->getRegistrationDetails_room()."&batchNo=$batchNo' target='rightFrame'><font size=2>Charges Cart</font></a></li>";




echo "</ul>";
echo "<ul>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/soaOption.php?registrationNo=$registrationNo&username=$username' target='rightFrame'><font size=2>S.O.A</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/Doctor/doctorModule/soapListed.php?registrationNo=$registrationNo&username=$username' target='rightFrame'><font size=2>S.O.A.P</font></a></li>";
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/uploader/viewImages.php?registrationNo=$registrationNo&username=$username' target='rightFrame'><font size=2>Dicom</font></a></li>";

//echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/Results/Radiology/radioResult_list.php?registrationNo=$registrationNo&username=$username' target='rightFrame'><font size=2>Radio Results</font></a></li>";

//echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientNotes/viewNote.php?noteType=Comments&username=$username&registrationNo=".$ro->getRegistrationDetails_registrationNo()."' target='rightFrame'><font size=2>Comments</font></a></li>";

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/paidItems.php?status=UNPAID&username=$username&registrationNo=".$ro->getRegistrationDetails_registrationNo()."' target='rightFrame'><font size=2>Unpaid</font></a></li>";

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/paidItems.php?status=PAID&username=$username&registrationNo=".$ro->getRegistrationDetails_registrationNo()."' target='rightFrame'><font size=2>Paid</font></a></li>";

$asql=mysql_query("SELECT pendingDelete FROM patientCharges WHERE registrationNo='".$ro->getRegistrationDetails_registrationNo()."' AND pendingDelete LIKE 'PENDING_%%%%'");
$acount=mysql_num_rows($asql);

if($acount==0){
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/deletedItemsPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username' target='rightFrame'><font size=2>Pending Delete</font></a></li>";
}
else{
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/deletedItemsPassword.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."&username=$username' target='rightFrame'><font size=2 color=red>Pending Delete</font></a></li>";
}

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/oldRecord/showRecord.php?patientNo=".$ro->getRegistrationDetails_patientNo()."&username=$username' target='rightFrame'><font size=2>Record's</font></a></li>";

if( $ro->selectNow("registeredUser","module","username",$username) == "LABORATORY" ) {
echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/Laboratory/resultList/listOfLab.php?username=$username&registrationNo=".$ro->getRegistrationDetails_registrationNo()."' target='rightFrame'><font size=2>Lab Result</font></a></li>";
}else { }

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/patientOR.php?registrationNo=".$ro->getRegistrationDetails_registrationNo()."' target='rightFrame'><font size=2>OR#</font></a></li>";

echo "</ul>";


?>
