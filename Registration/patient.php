<?php
include("../myDatabase.php");
require_once('../COCONUT/authentication.php');
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$from = $_GET['from'];

/*
if  (!isset($username) ) {
header("Location:http://".$ro->getMyUrl()."/LOGINPAGE/module.php ");
}
*/

$ro = new database();

?>


<script type="text/javascript" src="http://<?php echo $ro->getMyUrl(); ?>/Registration/menu/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://<?php echo $ro->getMyUrl(); ?>/Registration/menu/jquery.fixedMenu.js"></script>
<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/Registration/menu/fixedMenu_style1.css" />

<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/flow/rickyCSS1.css" />

<script type='text/javascript'>
$("#breadcrumbs a").hover(
    function () {
        $(this).addClass("hover").children().addClass("hover");
        $(this).parent().prev().find("span.arrow:first").addClass("pre_hover");
    },
    function () {
        $(this).removeClass("hover").children().removeClass("hover");
        $(this).parent().prev().find("span.arrow:first").removeClass("pre_hover");
    }
);

        $('document').ready(function(){
            $('.menu').fixedMenu();
        });

</script>


<ol id="breadcrumbs">
   <li><a href="http://<?php echo $ro->getMyUrl(); ?>/LOGINPAGE/module.php"><font color=white>Home</font><span class="arrow"></span></a></li>
    <li><a href="#" class="odd"><font color=white>Registration</font><span class="arrow"></span></a></li>
    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/opdRegistration.php?module=REGISTRATION&from=<?php echo $from; ?>"><font color=white>Verify Patient Record</font><span class="arrow"></span></a></li>
    <li><a href="#" class="odd"><font color=white><b>Registration Form</b></font><span class="arrow"></span></a></li>
    <li><a href="#">Verify Registration<span class="arrow"></span></a></li>
   <li><a href="#" class="odd"><font color=yellow>Patient<span class="arrow"></span></a></li>
    <li>&nbsp;&nbsp;</li>
</ol>

 <div class="menu">
        <ul>
            <li>
                <a href="#">Information<span class="arrow"></span></a>
                
                <ul>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/editInformation.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" target="patientX">Registration Details</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/editVitalSign.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" target="patientX">Vital Sign</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl() ?>/COCONUT/patientProfile/editInitialDiagnosis.php?registrationNo=<?php echo $registrationNo ?>&username=<?php echo $username; ?>" target="patientX">Diagnosis</a></li>
                  
<li><a href="http://<?php echo $ro->getMyUrl() ?>/COCONUT/Reports/admissionSlip.php?registrationNo=<?php echo $registrationNo ?>" target="patientX">Admission Slip</a></li>

<li><a href="http://<?php echo $ro->getMyUrl() ?>/COCONUT/patientProfile/roomList.php?registrationNo=<?php echo $registrationNo ?>&username=<?php echo $username; ?>" target="patientX">Room's</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/individualPayment/showMeds.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" target="patientX">Individual Payment</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/Registration/recordPart2.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" target="_blank">Admission and Discharge Record</a></li>


 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/patientProfile_handler.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" target="patientX">Back To Profile</a></li>


<?php

if($ro->selectNow("registeredUser","module","username",$username) == "PHARMACY" ) {
?>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/individualPayment/showMeds.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" target="patientX">Individual Payment</a></li>
<?php
}else {
echo "";
}


?>


                </ul>
            </li>
</div>


<iframe src="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/patientProfile_handler.php?registrationNo=<?php echo $registrationNo; ?>&username=<?php echo $username; ?>" name="patientX" width="1015" height="530" style="overflow-x:hidden; border:hidden; "></iframe>


