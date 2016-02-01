<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Print Me</title>
<style type='text/css'>
.couriernew09black {font-family: "Courier New";font-size: 9px; color: #000000;}
.couriernew09blackbold {font-family: "Courier New";font-weight: bold;font-size: 9px;color: #000000;}
.couriernew10black {font-family: "Courier New";font-size: 10px; color: #000000;}
.couriernew10blackbold {font-family: "Courier New";font-weight: bold;font-size: 10px;color: #000000;}
.couriernew11black {font-family: "Courier New";font-size: 11px;color: #000000;}
.couriernew11blackbold {font-family: "Courier New";font-weight: bold;font-size: 11px;color: #000000;}
.couriernew12black {font-family: "Courier New";font-size: 12px;color: #000000;}
.couriernew12blackbold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #000000;}
.couriernew13black {font-family: "Courier New";font-size: 13px;color: #000000;}
.couriernew13blackbold {font-family: "Courier New";font-weight: bold;font-size: 13px;color: #000000;}
.couriernew14black {font-family: "Courier New";font-size: 14px;color: #000000;}
.couriernew14blackbold {font-family: "Courier New";font-weight: bold;font-size: 14px;color: #000000;}
.couriernew15black {font-family: "Courier New";font-size: 15px;color: #000000;}
.couriernew15blackbold {font-family: "Courier New";font-weight: bold;font-size: 15px;color: #000000;}
.couriernew16black {font-family: "Courier New";font-size: 16px;color: #000000;}
.couriernew16blackbold {font-family: "Courier New";font-weight: bold;font-size: 16px;color: #000000;}
.couriernew11red {font-family: "Courier New";font-size: 11px;color: #FF0000;}
.couriernew11redbold {font-family: "Courier New";font-weight: bold;font-size: 11px;color: #FF0000;}
.couriernew12red {font-family: "Courier New";font-size: 12px;color: #FF0000;}
.couriernew12redbold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #FF0000;}
.couriernew12blue {font-family: "Courier New";font-size: 12px;color: #0066FF;}
.couriernew12bluebold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #0066FF;}
.couriernew12skin {font-family: "Courier New";font-size: 12px;color: #FFCC99;}
.couriernew12skinbold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #FFCC99;}
.couriernew12white {font-family: "Courier New";font-size: 12px;color: #FFFFFF;}
.couriernew12whitebold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #FFFFFF;}
.couriernew12orange {font-family: "Courier New";font-size: 12px;color: #FF9900;}
.couriernew12orangebold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #FF9900;}
.table1Bottom {border-bottom: 1px solid #000000;}
.astyle {text-decoration: none;}
</style>
</head>

<body>
<?php
include("../../myDatabase2.php");
$ro = new database();

$registrationNo=$_GET['registrationNo'];
$dateCharge=$_GET['dateCharge'];

mysql_connect($ro->myHost(),$ro->getUser(),$ro->getPass());
mysql_select_db($ro->getDB());

$ro->getPatientProfile($registrationNo);

$birthDatefmt=date("m/d/Y", strtotime($ro->getPatientRecord_birthDate()));
$birthDate = explode("/", $birthDatefmt);

$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));

$asql=mysql_query("SELECT description, dateCharge, timeCharge, remarks, chargeBy, status FROM patientCharges WHERE registrationNo = '$registrationNo' AND departmentStatus='' AND title='LABORATORY' AND status NOT LIKE 'DELETED_%%%%%%' AND dateCharge='$dateCharge' ORDER BY dateCharge, timeCharge DESC");
$acount=mysql_num_rows($asql);

if($acount==0){
$dateCharge="";$timeCharge="";$chargeBy="";
}
else{
while($afetch=mysql_fetch_array($asql)){$dateCharge=$afetch['dateCharge'];$timeCharge=$afetch['timeCharge'];$chargeBy=$afetch['chargeBy'];}
}

$birthDatefmt=date("m/d/Y", strtotime($ro->getPatientRecord_birthDate()));
$birthDate = explode("/", $birthDatefmt);

$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));

if($ro->getRegistrationDetails_room()==""){$widthroom="150";}else{$widthroom="auto";}
if($ro->getRegistrationDetails_company()==""){$widthcom="150";}else{$widthcom="auto";}

echo "
<div align='left'>
  <table width='100%' border='0' cellpadding='0' cellspacing='0'>
    <tr>
      <td><table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='50%'><div align='left'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Patient ID</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='auto' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".$ro->getRegistrationDetails_patientNo()."</div></td>
            </tr>
          </table></div></td>
          <td width='50%'><div align='right'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Date-Time Printed</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='auto' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".date("m/d/Y H:i")."</div></td>
            </tr>
          </table></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height='6'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='auto'><div align='left'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Patient Name</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='auto' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".$ro->getPatientRecord_lastName().", ".$ro->getPatientRecord_firstName()." ".$ro->getPatientRecord_middleName()."</div></td>
            </tr>
          </table></div></td>
          <td width='auto'><div align='right'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Date-Time Requested</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='auto' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".date("m/d/Y",strtotime($dateCharge))." ".date("H:i",strtotime($timeCharge))."</div></td>
            </tr>
          </table></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height='6'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='auto'><div align='left'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Date Of Birth</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='auto' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".date("M d, Y",strtotime($ro->getPatientRecord_birthDate()))."</div></td>
            </tr>
          </table></div></td>
          <td width='auto'><div align='right'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Requested By</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='150' class='table1Bottom'><div align='left' class='couriernew15blackbold'>$chargeBy</div></td>
            </tr>
          </table></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height='6'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='auto'><div align='left'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Age</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='30' class='table1Bottom'><div align='left' class='couriernew15blackbold'>$age</div></td>
              <td width='10'></td>
              <td width='auto'><div align='left' class='couriernew13black'>Gender</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='80' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".strtoupper($ro->getPatientRecord_Gender())."</div></td>
            </tr>
          </table></div></td>
          <td width='auto'><div align='right'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Physician</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='auto' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".$ro->getAttendingDoc($registrationNo,"ATTENDING")."</div></td>
            </tr>
          </table></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height='6'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='auto'><div align='left'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Room</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='$widthroom' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".$ro->getRegistrationDetails_room()."</div></td>
            </tr>
          </table></div></td>
          <td width='auto'><div align='right'><table border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='auto'><div align='left' class='couriernew13black'>Company</div></td>
              <td width='10'><div align='center' class='couriernew13black'>:</div></td>
              <td width='$widthcom' class='table1Bottom'><div align='left' class='couriernew15blackbold'>".$ro->getRegistrationDetails_company()."</div></td>
            </tr>
          </table></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height='20'></td>
    </tr>
    <tr>
      <td><div align='left' class='couriernew15black'>REQUEST/S</div></td>
    </tr>
    <tr>
      <td height='10'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='auto'><div align='left' class='couriernew12black'>DESCRIPTION</div></td>
        </tr>
";



$asql=mysql_query("SELECT description, timeCharge, remarks, chargeBy, status FROM patientCharges WHERE registrationNo = '$registrationNo' AND departmentStatus = '' AND title = 'LABORATORY' AND status NOT LIKE 'DELETED_%%%%%%' AND dateCharge='$dateCharge' ");
while($afetch=mysql_fetch_array($asql)){
echo "
        <tr>
          <td><div align='left' class='couriernew16blackbold'>".$afetch['description']."</div></td>
        </tr>
";

if($afetch['remarks']!=""){
echo "
        <tr>
          <td valign='top'><div align='left' class='couriernew12black'>(".$afetch['remarks'].")</div></td>
        </tr>
";
}

}

echo "
      </table></td>
    </tr>
  </table></td>
</div>
";
?>

</body>
</html>
