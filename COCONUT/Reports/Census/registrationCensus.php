<?php
include("../../../myDatabase.php");

$fromMonth = $_GET['fromMonth'];
$fromDay = $_GET['fromDay'];
$fromYear = $_GET['fromYear'];
$toMonth = $_GET['toMonth'];
$toDay = $_GET['toDay'];
$toYear = $_GET['toYear'];
$type = $_GET['type'];
$dept = $_GET['dept'];
$username = $_GET['username'];
$ro = new database();

echo "
<style type='text/css'>
.style1 {font-family: Arial;font-size: 20px;font-weight: bold;color: #000000;}
.style2 {font-family: Arial;font-size: 14px;font-weight: bold;color: #000000;}
.style3 {font-family: Arial;font-size: 14px;font-weight: bold;color: #FFFFFF;}
.style4 {font-family: Arial;font-size: 16px;color: #000000;}
.style5 {font-family: Arial;font-size: 14px;color: #000000;}
.button01 {font-family: Arial;font-size: 16px;font-weight: bold;color: #000000;background-color: #FFFFFF;border: 1px solid #000000;}
.button02 {font-family: Arial;font-size: 16px;font-weight: bold;color: #FF0000;background-color: #FFFFFF;border: 1px solid #000000;}
.button03 {font-family: Arial;font-size: 16px;border: 0;padding: 0;display: inline;background: none;color: #000000;}
#rowz:hover {
background-color:yellow;
}
</style>
";

echo "<center>";
//echo "<font size=6>".$ro->getReportInformation("hmoSOA_name")."</font>";
//echo "<br><font size=3>".$ro->getReportInformation("hmoSOA_address")."</font>";
//echo "<Br><font size=3>($branch)</font>";

echo "<center><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/mendero.png' width='60%' height='20%'></center>";

echo "<span class='style1'>Registration Census For $type</span>";
echo "<br><span class='style5'>($fromMonth $fromDay, $fromYear - $toMonth $toDay, $toYear)</span>";


//$ro->censusRegistered($fromMonth,$fromDay,$fromYear,$toMonth,$toDay,$toYear,$type,$dept,$username);



$con = mysql_connect($ro->myHost,$ro->username,$ro->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($ro->database, $con);

$fromRegistered = $fromYear."-".$fromMonth."-".$fromDay;
$toRegistered = $toYear."-".$toMonth."-".$toDay;

if( $dept != "" ) {
if($type == "IPD") {
$result = mysql_query("SELECT upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,upper(pr.middleName) as middleName,rd.*,pr.Age,pr.Gender,pr.phic FROM patientRecord pr,registrationDetails rd WHERE rd.patientNo = pr.patientNo and (dateRegistered between '$fromRegistered' and '$toRegistered' ) and rd.type in ('IPD','ER','OR/DR','ICU') and rd.registeredFrom='$dept' order by dateRegistered,timeRegistered asc ");
}else {
$result = mysql_query("SELECT upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,upper(pr.middleName) as middleName,rd.*,pr.Age,pr.Gender,pr.phic FROM patientRecord pr,registrationDetails rd WHERE rd.patientNo = pr.patientNo and (dateRegistered between '$fromRegistered' and '$toRegistered') and rd.type='$type' and rd.registeredFrom='$dept' order by dateRegistered,timeRegistered asc ");
}
}else {

if($type == "IPD") {
$result = mysql_query("SELECT upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,upper(pr.middleName) as middleName,rd.*,pr.Age,pr.Gender,pr.phic FROM patientRecord pr,registrationDetails rd WHERE rd.patientNo = pr.patientNo and (dateRegistered between '$fromRegistered' and '$toRegistered' ) and rd.type in ('IPD','ER','OR/DR','ICU') order by dateRegistered,timeRegistered asc ");
}else {
$result = mysql_query("SELECT upper(pr.lastName) as lastName,upper(pr.firstName) as firstName,upper(pr.middleName) as middleName,rd.*,pr.Age,pr.Gender,pr.phic FROM patientRecord pr,registrationDetails rd WHERE rd.patientNo = pr.patientNo and (dateRegistered between '$fromRegistered' and '$toRegistered') and rd.type='$type' order by dateRegistered,timeRegistered asc ");
}

}


echo "<br>";
$ro->coconutTableStart();
$ro->coconutTableRowStart();
$ro->coconutTableHeader("<span class='style3'>Name</span>");
$ro->coconutTableHeader("<span class='style3'>Age</span>");
$ro->coconutTableHeader("<span class='style3'>Gender</span>");
//$ro->coconutTableHeader("<span class='style3'>Service</span>");
$ro->coconutTableHeader("<span class='style3'>PHIC</span>");
$ro->coconutTableHeader("<span class='style3'>Insurance</span>");
$ro->coconutTableHeader("<span class='style3'>Attending</span>");
$ro->coconutTableHeader("<span class='style3'>Room</span>");
$ro->coconutTableHeader("<span class='style3'>Registered</span>");
$ro->coconutTableHeader("<span class='style3'>Registered By</span>");
$ro->coconutTableHeader("");
$ro->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
if($row['firstName']=="N/A"){
}
else{
echo "<Tr id='rowz'>";
$ro->censusRegistered_patient += 1;
$ro->coconutTableData("<span class='style4'>".$row['lastName']." ".$row['firstName']." ".$row['middleName']."</span>");
$ro->coconutTableData("<span class='style4'>".$row['Age']."</span>");
$ro->coconutTableData("<span class='style4'>".strtoupper($row['Gender'])."</span>");
//$ro->coconutTableData("<span class='style4'>".$ro->selectNow("Doctors","Specialization1","Name",$ro->getAttendingDoc($row['registrationNo'],"ATTENDING"))."</span>");

if( $row['phic'] == "YES" ) {
$ro->coconutTableData("<span class='style4'>NH</span>");
}else {
$ro->coconutTableData("<span class='style4'>NN</span>");
}
$ro->coconutTableData("<span class='style4'>".$row['Company']."</span>");
$ro->coconutTableData("<span class='style4'>".$ro->getAttendingDoc($row['registrationNo'],"ATTENDING")."</span>");
$ro->coconutTableData("<span class='style4'>".$type=$ro->selectNow("registrationDetails","room","registrationNo",$row['registrationNo'])."</span>");
$ro->coconutTableData("<span class='style4'>".$row['timeRegistered']."@".$row['dateRegistered']."</span>");
$ro->coconutTableData("<span class='style4'>".$row['registeredBy']."</span>");
$ro->coconutTableData("<a href='http://".$ro->getMyUrl()."/COCONUT/Reports/Census/registrationCensusDelete.php?username=$username&registrationNo=$row[registrationNo]&fromMonth=$fromMonth&fromDay=$fromDay&fromYear=$fromYear&toMonth=$toMonth&toDay=$toDay&toYear=$toYear&type=$type&dept=$dept'><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/delete.jpeg'></a>");
echo "</tr>";

  }
}
$ro->coconutTableData("<span class='style2'>TOTAL PATIENT</span>");
$ro->coconutTableData("<span class='style2'>".$ro->censusRegistered_patient."</span>");
$ro->coconutTableData("");
$ro->coconutTableData("");
$ro->coconutTableData("");
$ro->coconutTableData("");
$ro->coconutTableData("");
$ro->coconutTableData("");
$ro->coconutTableStop();


?>
