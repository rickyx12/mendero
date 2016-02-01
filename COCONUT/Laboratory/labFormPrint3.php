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
.couriernew12orange {font-family: "Courier New";font-size: 12px;color: #000000;}
.couriernew12orangebold {font-family: "Courier New";font-weight: bold;font-size: 12px;color: #000000;}
.couriernew13black {font-family: "Courier New";font-size: 13px;color: #000000;}
.couriernew13blackbold {font-family: "Courier New";font-weight: bold;font-size: 13px;color: #000000;}
.couriernew14black {font-family: "Courier New";font-size: 14px;color: #000000;}
.couriernew14blackbold {font-family: "Courier New";font-weight: bold;font-size: 14px;color: #000000;}
.astyle {text-decoration: none;}
.table1Bottom {border-bottom: 1px solid #000000;}
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

echo "
<div align='left'>
  <table width='345' border='0' cellpadding='0' cellspacing='0' bordercolor='#000000'>
    <tr>
      <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0' bordercolor='#000000'>
        <tr>
          <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr>
              <td height='6' colspan='6'></td>
            </tr>
            <tr>
              <td width='80'><div align='left' class='couriernew11black'>&nbsp;Patient ID</div></td>
              <td width='6'><div align='center' class='couriernew11black'>:</div></td>
              <td width='75'><div align='left' class='couriernew13blackbold'><u>".$ro->getRegistrationDetails_patientNo()."</u></div></td>
              <td width='35'><div align='left' class='couriernew11black'>Date</div></td>
              <td width='6'><div align='center' class='couriernew11black'>:</div></td>
              <td width='auto'><div align='right' class='couriernew10blackbold'><u>".date("m/d/Y - H:i:s")."</u>&nbsp;</div></td>
            </tr>
            <tr>
              <td height='6' colspan='6'></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr>
              <td height='10'><div align='left' class='couriernew12black'>&nbsp;Patient Name:</div></td>
            </tr>
            <tr>
              <td width='auto'><div align='left' class='couriernew14blackbold'>&nbsp;<u>".$ro->getPatientRecord_lastName().", ".$ro->getPatientRecord_firstName()." ".$ro->getPatientRecord_middleName()."&nbsp;</u></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr>
              <td height='10' colspan='6'></td>
            </tr>
            <tr>
              <td width='45'><div align='left' class='couriernew12black'>&nbsp;B-Date</div></td>
              <td width='6'><div align='center' class='couriernew12black'>:</div></td>
              <td width='196'><div align='left' class='couriernew12blackbold'><u>".$ro->getPatientRecord_birthDate()."</u></div></td>
              <td width='50'><div align='left' class='couriernew12black'>Age/Sex</div></td>
              <td width='6'><div align='center' class='couriernew12black'>:</div></td>
              <td width='auto'><div align='right' class='couriernew12blackbold'><u>$age/".strtoupper($ro->getPatientRecord_Gender())."</u>&nbsp;</div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr>
              <td height='6' colspan='3'></td>
            </tr>
            <tr>
              <td width='55'><div align='left' class='couriernew12black'>&nbsp;Physician</div></td>
              <td width='6'><div align='center' class='couriernew12black'>:</div></td>
              <td width='auto'><div align='left' class='couriernew12blackbold'><u>".$ro->getAttendingDoc($registrationNo,"ATTENDING")."</u></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr>
              <td height='6' colspan='3'></td>
            </tr>
            <tr>
              <td width='30'><div align='left' class='couriernew12black'>&nbsp;Room</div></td>
              <td width='6'><div align='center' class='couriernew12black'>:</div></td>
              <td width='auto'><div align='left' class='couriernew12blackbold'><u>".$ro->getRegistrationDetails_room()."</u>&nbsp;</div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr>
              <td height='20'></td>
            </tr>
            <tr>
              <td><div align='center'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                  <td width='auto'><div align='left' class='couriernew10blackbold'>&nbsp;Description&nbsp;</div></td>
                </tr>
";

$asql=mysql_query("SELECT description,timeCharge,remarks,chargeBy,status FROM patientCharges WHERE registrationNo = '$registrationNo' AND departmentStatus = '' AND title = 'LABORATORY' AND status NOT LIKE 'DELETED_%%%%%%' AND dateCharge='$dateCharge' ");
while($afetch=mysql_fetch_array($asql)){
echo "
                <tr>
                  <td valign='top'><div align='left' class='couriernew14blackbold'>&nbsp;".$afetch['description']."&nbsp;</div></td>
                </tr>
";

if($afetch['remarks']!=""){
echo "
                <tr>
                  <td valign='top'><div align='left' class='couriernew11black'>&nbsp;(".$afetch['remarks'].")&nbsp;</div></td>
                </tr>
";
}
}

echo "
              </table></div></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
";
?>

</body>
</html>
