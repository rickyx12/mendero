<?php
include("../../myDatabase2.php");
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];

$ro = new database2();
$ro->getPatientProfile($registrationNo);
$ro->setPatientRecord($ro->getRegistrationDetails_patientNo());
echo "
<style type='text/css'>
.informationLabel {
font-size:15px;
font-weight:bold;
}

.initialDiagnosis {
	border: 1px solid #CCC;
	color: #000;
	height:80px;
	width: 350px;
	padding:4px 4px 4px 2px;
}


</style>";

$room = preg_split ("/\_/",$ro->getRegistrationDetails_room()); 

echo "<br>";
if($ro->getRegistrationDetails_dateUnregistered() == "" ) {
echo "<a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/discharged/discharge_new.php?registrationNo=$registrationNo&protoType=Discharged&room=".$ro->getRegistrationDetails_room()."&username=$username'><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/unlock.jpeg'></a>&nbsp;&nbsp;<font size=2 color=red><b>".$ro->getRegistrationDetails_type()."</b></font><br>";
}else {
echo "<a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/discharged/discharged.php?registrationNo=$registrationNo&protoType=Undischarged&room=&username=$username'><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/locked1.jpeg'></a>&nbsp;&nbsp;<font size=2 color=red><b>".$ro->getRegistrationDetails_type()."</b></font><br>";
}

//echo "<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/verified.jpeg'>";

echo "<b><i><font color=blue size=5>".$ro->selectNow("registrationDetails","privateORhouse_case","registrationNo",$registrationNo)."</font></i></b><br>";


echo "<font class='informationLabel'>Patient No:</font>&nbsp;".$ro->getRegistrationDetails_patientNo();

if( $ro->getRegistrationDetails_type() != "OPD" ) {
echo "<br><font class='informationLabel'>Registration No:</font>&nbsp;<font color=red>Admission-".$ro->getRegistrationDetails_registrationNo()."</font>";
}else {
echo "<br><font class='informationLabel'>Registration No:</font>&nbsp;<font color='blue'>Outpatient-".$ro->getRegistrationDetails_registrationNo()."</font>";
}
echo "<br><font class='informationLabel'>Attending:</font>&nbsp;<font color=blue>".$ro->getAttendingDoc($registrationNo,"ATTENDING")."</font>";
echo "<br><font class='informationLabel'>Age:</font>&nbsp;".$ro->getPatientRecord_age();
echo "<br><font class='informationLabel'>Gender:</font>&nbsp;".$ro->getPatientRecord_gender();
echo "<br><font class='informationLabel'>Civil Status:</font>&nbsp;".$ro->getPatientRecord_civilStatus();
echo "<br><font class='informationLabel'>Birth Date:</font>&nbsp;".$ro->getPatientRecord_Birthdate();
echo "<br><font class='informationLabel'>Contact No#:</font>&nbsp;".$ro->getPatientRecord_contactNo();
echo "<br><font class='informationLabel'>Senior:</font>&nbsp;".$ro->getPatientRecord_senior();
echo "<br><font class='informationLabel'>Senior ID#:</font>&nbsp;".$ro->selectNow("registrationDetails","seniorID","registrationNo",$registrationNo);
echo "<br><font class='informationLabel'>PhilHealth:</font>&nbsp;".$ro->getPatientRecord_phic()." <a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/Payments/phicPayment_selection.php?registrationNo=$registrationNo&username=$username' style='text-decoration:none;'><font color='red' size=2>[Payment]</font></a>";
echo "<br><font class='informationLabel'>Religion:</font>&nbsp;".$ro->getPHICtype_patientRecord();
if( $ro->selectNow("registrationDetails","verified","registrationNo",$registrationNo) != "" && $ro->selectNow("registrationDetails","certified","registrationNo",$registrationNo) == "" ) {
echo "<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/verified.jpeg'>";
}else if( $ro->selectNow("registrationDetails","verified","registrationNo",$registrationNo) == "" && $ro->selectNow("registrationDetails","certified","registrationNo",$registrationNo) != "" ) {
echo "<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/certified.jpeg'>";
}else if( $ro->selectNow("registrationDetails","verified","registrationNo",$registrationNo) != "" && $ro->selectNow("registrationDetails","certified","registrationNo",$registrationNo) != "" ) {
echo "<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/verified.jpeg'>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<img src='http://".$ro->getMyUrl()."/COCONUT/myImages/certified.jpeg'>";
}else { echo ""; }
echo "<br><font class='informationLabel'>Company:</font>&nbsp;".$ro->getRegistrationDetails_company()." <a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/Payments/companyPayment_selection.php?registrationNo=$registrationNo&username=$username&companyName=".$ro->getRegistrationDetails_company()."&columnToGet=company' style='text-decoration:none;'><font color='red' size=2>[Payment]</font></a>";

if( $ro->selectNow("registrationDetails","company1","registrationNo",$registrationNo) != "" ) {
echo "<br><font class='informationLabel'>Company1:</font>&nbsp;".$ro->selectNow("registrationDetails","company1","registrationNo",$registrationNo)."<a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/Payments/companyPayment_selection.php?registrationNo=$registrationNo&username=$username&companyName=".$ro->selectNow("registrationDetails","company1","registrationNo",$registrationNo)."&columnToGet=company1' style='text-decoration:none;'><font color='red' size=2>[Payment]</font></a>";
}else { }
if( $ro->selectNow("registrationDetails","company2","registrationNo",$registrationNo) != "" ) {
echo "<br><font class='informationLabel'>Company2:</font>&nbsp;".$ro->selectNow("registrationDetails","company2","registrationNo",$registrationNo)."<a href='http://".$ro->getMyUrl()."/COCONUT/patientProfile/Payments/companyPayment_selection.php?registrationNo=$registrationNo&username=$username&companyName=".$ro->selectNow("registrationDetails","company2","registrationNo",$registrationNo)."&columnToGet=company2' style='text-decoration:none;'><font color='red' size=2>[Payment]</font></a>";
}else { }

echo "<br><font class='informationLabel'>Mother's Name:</font>&nbsp;".$ro->selectNow("patientRecord","mothersName","patientNo",$ro->getRegistrationDetails_patientNo());
echo "<br><font class='informationLabel'>Father's Name:</font>&nbsp;".$ro->selectNow("patientRecord","fathersName","patientNo",$ro->getRegistrationDetails_patientNo());
echo "<br><font class='informationLabel'>Spouse Name:</font>&nbsp;".$ro->selectNow("patientRecord","spouseName","patientNo",$ro->getRegistrationDetails_patientNo());
echo "<br><font class='informationLabel'>Informant:</font>&nbsp;".$ro->selectNow("registrationDetails","informant","registrationNo",$ro->getRegistrationDetails_registrationNo());
echo "<br><font class='informationLabel'>Relationship:</font>&nbsp;".$ro->selectNow("registrationDetails","relationship","registrationNo",$ro->getRegistrationDetails_registrationNo());
echo "<br><font class='informationLabel'>Time Registered:</font>&nbsp;".$ro->getRegistrationDetails_timeRegistered();
echo "<br><font class='informationLabel'>Date Registered:</font>&nbsp;".$ro->reformatDate($ro->getRegistrationDetails_dateRegistered());
echo "<br><font class='informationLabel'>Registered From:</font>&nbsp;".$ro->selectNow("registrationDetails","registeredFrom","registrationNo",$registrationNo);
echo "<br><font class='informationLabel'>Case Type:</font>&nbsp;<a href='#' style='text-decoration:none; color:black;'>".$ro->getRegistrationDetails_caseType()."</a>";
echo "<br><font class='informationLabel'>Diet</font>&nbsp;".$ro->selectNow("dietList","dietName","dietNo",$ro->selectNow("registrationDetails","diet","registrationNo",$registrationNo));
//selectNow($table,$cols,$identifier,$identifierData)
echo "<br><font class='informationLabel'>Room:</font>&nbsp;".$room[0];
echo "<br><font class='informationLabel'>Address:</font>&nbsp;".$ro->getPatientRecord_address();
echo "<br><font class='informationLabel'>Registered By:</font>&nbsp;".$ro->getRegistrationDetails_registeredBy();




if( $ro->selectNow("nbs","motherRegistrationNo","motherRegistrationNo",$registrationNo) != "" ) {
echo "<br>".$ro->coconutImages_return("mother.jpeg");
$ro->getBabies($registrationNo);
echo "<br><a href='/COCONUT/patientProfile/nbs/searchBaby.php?registrationNo=$registrationNo&username=$username' style='text-decoration:none;'><font class='informationLabel' color=red>[+1 Baby]</font></a>&nbsp;";
}else if( $ro->selectNow("nbs","motherRegistrationNo","babyRegistrationNo",$registrationNo) != "" ) {

echo "<br> ".$ro->coconutImages_return("mother.jpeg")."  - <font color=blue>".$ro->selectNow("patientRecord","lastName","patientNo",$ro->selectNow("registrationDetails","patientNo","registrationNo", $ro->selectNow("nbs","motherRegistrationNo","babyRegistrationNo",$registrationNo) )).", ".$ro->selectNow("patientRecord","firstName","patientNo",$ro->selectNow("registrationDetails","patientNo","registrationNo", $ro->selectNow("nbs","motherRegistrationNo","babyRegistrationNo",$registrationNo) ))."</font>&nbsp;";

}
else {
echo "<br><a href='/COCONUT/patientProfile/nbs/searchBaby.php?registrationNo=$registrationNo&username=$username' style='text-decoration:none;'><font class='informationLabel' color=blue>[Add Baby]</font></a>&nbsp;";
}



if( $ro->selectNow("reportHeading","information","reportName","Credit Limit") == "Activate" and $ro->selectNow("registrationDetails","type","registrationNo",$registrationNo) == "IPD" ) {
echo "<br><font class='informationLabel' color=blue>Allowed Balance:</font>&nbsp;".$ro->selectNow("registrationDetails","LimitCASH","registrationNo",$registrationNo);

echo "<br><font class='informationLabel' color=red>Current Balance:</font>&nbsp;".$ro->may_naibayad_naba_ang_patient($registrationNo);

}else { }


if($ro->getRegistrationDetails_dateUnregistered() != "") {
echo "<br><font class='informationLabel'>Time Discharged:</font>&nbsp;".$ro->getRegistrationDetails_timeUnregistered();
echo "<br><font class='informationLabel'>Discharged:</font>&nbsp;".$ro->reformatDate($ro->getRegistrationDetails_dateUnregistered());
}else {
echo "";
}



if( $ro->selectNowLast("billingRequest","status","registrationNo",$registrationNo) == "pending" ) {

if( $ro->selectNowLast("billingRequest","status","registrationNo",$registrationNo) == "pending" ) {
echo "<br><br>";
$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/billing/cancelRequest2bill.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutButton("Cancel Request to Bill");
$ro->coconutFormStop();

if( $ro->selectNow("registeredUser","module","username",$username) == "CASHIER" ) {
$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/billing/finalBill.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutButton("Final Bill");
$ro->coconutFormStop();
}else { }


}else {
echo "<br><br>";
$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/billing/request2bill.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutButton("Request to Bill");
$ro->coconutFormStop();
}
}else if($ro->selectNowLast("billingRequest","status","registrationNo",$registrationNo) == "completed") {
echo "<center><font color=blue>Final Bill Completed </font></center>";
}
else { 

echo "<br><br>";
$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/billing/request2bill.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutButton("Request to Bill");
$ro->coconutFormStop();

}

/*
if( $ro->selectNow("registeredUser","module","username",$username) == "CASHIER" && $ro->selectNowLast("billingRequest","status","registrationNo",$registrationNo) == "complete" ) {
$ro->coconutFormStart("post","http://".$ro->getMyUrl()."/COCONUT/billing/finalBill.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutButton("Final Bill");
$ro->coconutFormStop();
}else { 
echo "<center><font color=blue>Final Bill Completed </font></center>";
}
*/

$ro->coconutFormStart("post","removePending.php");
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
$ro->coconutButton("REMOVE PENDING MEDICINE/SUPPLIES");
$ro->coconutFormStop();


echo "<font size=2 color=red><b>VITAL SIGN</b></font>";
echo "<br><font class='informationLabel'>Height:</font>&nbsp;".$ro->getRegistrationDetails_height();
echo "<br><font class='informationLabel'>Weight:</font>&nbsp;".$ro->getRegistrationDetails_weight();
echo "<br><font class='informationLabel'>Blood Pressure:</font>&nbsp;".$ro->getRegistrationDetails_bloodPressure();
echo "<br><font class='informationLabel'>Temperature:</font>&nbsp;".$ro->getRegistrationDetails_temperature();
echo "<br><font class='informationLabel'>Pulse Rate:</font>&nbsp;".$ro->getRegistrationDetails_pulse();
echo "<br><font class='informationLabel'>Respiratory Rate:</font>&nbsp;".$ro->getRegistrationDetails_respiratory();

echo "<br><br><font class='informationLabel'>Chief Complaint:</font><br><textarea class='initialDiagnosis' readonly>".$ro->getRegistrationDetails_initialDiagnosis()."</textarea>";

echo "<br><br><font class='informationLabel'>Initial Diagnosis:</font><br><textarea class='initialDiagnosis' readonly>".$ro->getRegistrationDetails_IxDx()."</textarea>";


?>
