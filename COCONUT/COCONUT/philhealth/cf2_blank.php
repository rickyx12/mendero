<?php
include("../../myDatabase.php");

$ro = new database();



?>


<?php

echo "

<style type='text/css'> 
 
BODY {
	PADDING-RIGHT: 0px;
	PADDING-LEFT: 0px;
	PADDING-BOTTOM: 0px;
	MARGIN: 0px;
	background-color:;	
 
}
.style1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size:small;
}
.style3 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 45px;}
.style5 {font-size: x-small}

.style55 {font-size: medium; font-family: Geneva, Arial, Helvetica, sans-serif; }
.style56 {font-size: medium}
.style58 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: small; font-style: italic; }
.style60 {font-size: small; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
.style65 {font-size: 12px}
.style69 {font-size: 10px}

.labelz {
font-size:13px;
}

.pan {
font-size:10px;
}

.panData {
font-size:14px;
}

.pin {
font-size:17px;
}

.pinData {
padding:35px 0px 25px 0px;
}

.birth {
font-size:18px;
}

.checkBox {
	border: 1px solid #000;
}

.daysClaimed {
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 25px;
	border-color:white black black black;
	text-align:center;
}

.daysClaimed1{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 20px;
	border-color:white black black white;
	text-align:center;
}


.death {
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 13px;
	border-color:white black black black;
	text-align:center;
}

.death1{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 13px;
	border-color:white black black white;
	text-align:center;
}


.hospitalName{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 440px;
	border-color:white white black white;
	font-size:15px;

}


.patientName{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 740px;
	border-color:white white black white;
	font-size:17px;

}


.phicTable{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 110px;
	border-color:white white white white;
	font-size:17px;
	text-align:center;
}


.phicTableRemarks{
	border: 1px solid #000;
	color: #000;
	height: 28px;
	width: 170px;
	border-color:white white white white;
	font-size:15px;
	text-align:center;
}

#phicRow:hover {
background-color:yellow;
color:black;
}


.icd10{
	border: 1px solid #000;
	color: #000;
	height: 20px;
	width: 215px;
	border-color:white white black white;
	font-size:15px;
	padding:2px 2px 2px 2px;
}

.admissionDiagnosis{
	border: 1px solid #000;
	color: #000;
	height: auto;
	width: 235px;
	border-color:white white white white;
	font-size:15px;

}


.finalDiagnosis{
	border: 1px solid #000;
	color: #000;
	height: auto;
	width: 565px;
	border-color:white white white white;
	font-size:15px;

}


.box{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 25px;
	border-color:white black black black;
	font-size:18px;
	text-align:center;
}

.panz{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 20px;
	border-color:white black black black;
	font-size:15px;
	text-align:center;
}

.panz1{
	border: 1px solid #000;
	color: #000;
	height: 18px;
	width: 20px;
	border-color:white black black white;
	font-size:15px;
	text-align:center;
}

</style> 


";



echo "

<table width='860' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='465' rowspan='4'><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/logoclaims.jpg' width='261' height='90'/></td>
    <td width='448'><div align='left'><span class='style1'>This Form may be reproduced and is NOT FOR SALE</span></div></td>
  </tr>
  <tr>
    <td><div align='center' class='style3'>CF2</div></td>
  </tr>
  <tr>
    <td><div align='center'><span class='style5'>(Claim Form)<br />
      Revised February 2010</span><br />
    </div></td>
  </tr>
  <tr>
    <td><img src='http://".$ro->getMyUrl()."/COCONUT/myImages/Graphic2.jpg' width='416' height='32' /><br /></td>
  </tr>
</table>
";


echo "


<table width='860' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td><span class='style1'><font size=1><b>IMPORTANT REMINDERS</b></font></span></td>
  </tr>
  <tr>
    <td><span class='style1'><font size=1>PLEASE WRITE IN CAPITAL <b>LETTERS</b>&nbsp;AND <b>CHECK</b> THE APPROPRIATE BOXES.</font></span></td>
  </tr>
  <tr>
    <td><font size=1>For local confinement, this form together with CF1 and other supporting documents should be filed within <b>60 DAYS</b> from date of discharge. </font>   </td>
  </tr>
  <tr>
    <td class='style1'><font size=1>All information required in this form are necessary and claim forms with incomplete information shall not be processed.</font></td>
  </tr>
  <tr>
    <td><span class='style1'><font size=1>FALSE/INCORRECT INFORMATION OR MISREPRESENTATION SHALL BE SUBJECT TO CRIMINAL, CIVIL OR ADMINISTRATIVE LIABILITIES</font></span></td>
  </tr>
</table>

";

echo "

<br />
<table width='860' border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
  <tr>
    <td><div align='center' style='border:1px #000 solid;'><font size=3><b>PART 1 - PROVIDER INFORMATION &nbsp;&nbsp;&nbsp;(Institutional Health Care Provider to fill out items 1 to 13)</b></font></font> </div></td>
  </tr>
</table>
<br><table width='860' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='115'><span class='style7'><font size=2>1. Name of Facility:</font></span></td>
    <td width='725'><input class='hospitalName' type=text value='".$ro->getReportInformation("hmoSOA_name")."' ></td>
  </tr>
  <tr>
    <td><span class='style7'><font size=2>2. Address:</font></span></td>
    <td><input type=text class='hospitalName' value='".$ro->getReportInformation("hmoSOA_address")."'></td>
  </tr>
</table>
";
$pinNo = preg_split ("/\-/", $ro->getRegistrationDetails_PIN());  //kkuning ung phic pin No
echo "
<table width='860' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='190'><span class='style7'><font size=1>3. PhilHealth Accreditation No.(PAN):</font> </span><br /><font size=1><b>
( Institutional Health Care Provider )</b></font></td>
    <td>
<input type=text class='panz' maxlength=1 value='".substr($ro->getReportInformation("PAN"),-9,1)."'><input type=text class='panz1' maxlength=1 value='".substr($ro->getReportInformation("PAN"),-8,1)."'><input type=text maxlength=1 class='panz1' value='".substr($ro->getReportInformation("PAN"),-7,1)."'><input type=text class='panz1' maxlength=1 value='".substr($ro->getReportInformation("PAN"),-6,1)."'><input type=text maxlength=1 class='panz1' value='".substr($ro->getReportInformation("PAN"),-5,1)."'><input type=text maxlength=1 class='panz1' value='".substr($ro->getReportInformation("PAN"),-4,1)."'><input type=text maxlength=1 class='panz1' value='".substr($ro->getReportInformation("PAN"),-3,1)."'><input type=text maxlength=1 class='panz1' value='".substr($ro->getReportInformation("PAN"),-2,1)."'><input type=text maxlength=1 class='panz1' value='".substr($ro->getReportInformation("PAN"),-1,1)."'>
&nbsp;</td>
<Td width='240'><font size=2>4.Category of Facility:</font></td>
  </tr>
<tr>
<Td><Font size='1'>5.PhilHealth Identification No.(PIN):</font><br><font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


( Member )</font></td>
<td>";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],0,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],1,1)."'>-";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],2,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],3,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],4,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],5,1)."' ><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],6,1)."' ><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],7,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],8,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],9,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],10,1)."'>-<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],11,1)."'>";


//echo "<u><font size=3>".$ro->getRegistrationDetails_PIN()."</font></u>";

///CATEGORY OF FACILITY

if($ro->getReportInformation("Facility") == "T-L4/L3") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility' checked><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}else if($ro->getReportInformation("Facility") == "ASC") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility' checked><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}else if($ro->getReportInformation("Facility") == "RHU") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility' checked><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}else if($ro->getReportInformation("Facility") == "S-L2") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility' ><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility' checked><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}else if($ro->getReportInformation("Facility") == "FDC") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility' ><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility' checked><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";

}else if($ro->getReportInformation("Facility") == "TB-DOTS") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility' ><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility' checked><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}else if($ro->getReportInformation("Facility") == "P-L1") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility' ><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility' checked><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}else if($ro->getReportInformation("Facility") == "MCP") {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox class='checkBox' name='facility'><font size=2>ASC</font>&nbsp;&nbsp;<input type=checkbox name='facility' ><font size=2>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>FDC</font>
&nbsp;<input type=checkbox name='facility'><font size=2>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox name='facility'><font size=2>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name='facility' checked><font size=2>MCP</font>
&nbsp;<input type=checkbox name='facility'><font size=2>__________</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}
else {
echo "
<Td>&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' class='checkBox' name='facility'><font size=1>T-L4/L3</font>&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' class='checkBox' name='facility'><font size=1>ASC</font>&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility' ><font size=1>RHU</font><br>
&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility'><font size=1>S-L2</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility'><font size=1>FDC</font>
&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility'><font size=1>TB-DOTS</font><br>
&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility'><font size=1>P-L1</font>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility'><font size=1>MCP</font>
&nbsp;<input type=checkbox style='outline: 1px solid #000000;' name='facility' checked><font size=1><u>&nbsp;".$ro->getReportInformation("Facility")."&nbsp;</u></font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(OTHERS)</font>
</tD>
</tr>
</table>
";
}
//END OF "CATEGORY OF FACILITY"

echo "

<Table width='860' align='center' border=0>
<tr>
<Td width='271'><font size=2>6. Name of Patient:</font></tD>
</tr>
<Tr>
<td><input type=text value='".$ro->getPatientRecord_lastName().", ".$ro->getPatientRecord_firstName()." ".$ro->getPatientRecord_middleName()."' class='patientName'><br><font size=1>Last Name</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>First Name</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>Middle Name</font></td>
</tr>
</table>
";
$bday = preg_split ("/\_/", $ro->getPatientRecord_Birthdate()); 

echo "<br>";
echo "<table width='860' align='center' border=0>";
echo "<tr>";
echo "<Td width='110'><font size=2>. Date of Birth:</font></td>";
echo "<tD width='170'>";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],0,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],1,1)."'>-";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],2,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],3,1)."'>-<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'>";
echo "</td>";


/********
if(strlen($bday[1]) > 1) {
echo "-<u>|".substr($bday[1],-2)."|".substr($bday[1],2)."</u>-<u>|".substr($bday[2],-4,1)."|".substr($bday[2],-3,1)."|".substr($bday[2],-2,1)."|".substr($bday[2],-1,1)."|</u></td>";
}else {
echo "-<u>|0|".substr($bday[1],-1)."|</u>-<u>|".substr($bday[2],-4,1)."|".substr($bday[2],-3,1)."|".substr($bday[2],-2,1)."|".substr($bday[2],-1,1)."|</u><br>&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>(month-day-year)</font></td>";
}
*********/


//echo "<Td width='2%'>&nbsp;</td>";
echo "<td>&nbsp;<Font size=2>8.Age: </font><input type=text maxlength=3 class='box' value='".$ro->getPatientRecord_Age()."'>&nbsp;
&nbsp;&nbsp;
<font size=2>Year/s</font>
<input type=checkbox style='outline: 1px solid #000000;'>&nbsp;&nbsp;
<font size=2>Month/s</font>
<input type=checkbox style='outline: 1px solid #000000;'>&nbsp;&nbsp;
<font size=2>Day/s</font>
<input type=checkbox style='outline: 1px solid #000000;'>&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size=2>Sex:</font>";

echo "<input type=checkbox style='outline: 1px solid #000000;' ><font size=2>Male</font>";
echo "&nbsp;&nbsp;<input type=checkbox style='outline: 1px solid #000000;'><font size=2>Female</font>";


echo "</td>";
echo "</tr>";
echo "</table>";

$dateRegistered = preg_split ("/\_/", $ro->getRegistrationDetails_dateRegistered()); 
$timeRegistered = preg_split ("/\:/", $ro->getRegistrationDetails_timeRegistered()); 
$dateUnregistered = preg_split ("/\_/", $ro->getRegistrationDetails_dateUnregistered()); 
$timeUnregistered = preg_split ("/\:/", $ro->getRegistrationDetails_timeUnregistered()); 
echo "<br><table width='860' border='0' align='center' cellpadding='0' cellspacing='0'>";
echo "<tr>";
echo "<td width='37%'><font size=2>10. Confinement Period</font></td>";
echo "</tr>";
echo "<tr><td>&nbsp;</td></tr>";
echo "<tr>";
echo "<td width='35%'><font size=2>a.Date Admitted</font>";
echo "&nbsp;&nbsp;<font size=3>";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],0,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],1,1)."'>-";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],2,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],3,1)."'>-<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'>";
echo "</td>";
echo "<td width='32%'><font size=2>b.Time Admitted</font>&nbsp;&nbsp;";
echo " <input maxlength=3 type=text class='daysClaimed' value=''> AM &nbsp;&nbsp;&nbsp;<input maxlength=3 type=text class='daysClaimed' value=''> PM ";
echo "<td>";
echo "<td width='50%'><font size=2>e.No. of Days Claimed</font>&nbsp;<input maxlength=3 type=text class='daysClaimed' value=''></tD>";
echo "</tr>";

echo "<tr><td>&nbsp;<tr>";
echo "<tr>";
echo "<Td width='20%'><font size=2>c.Date Discharged</font>&nbsp;&nbsp;<font size=3>"; 
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],0,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],1,1)."'>-";
echo "<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],2,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],3,1)."'>-<input type=text maxlength=1 class='panz' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'><input type=text maxlength=1 class='panz1' value='".substr($pinNo[0],11,1)."'>";
echo "</td>";
echo "<td width='15%'><font size=2>d.Time Discharged</font>&nbsp;&nbsp;<font size=3>";
echo " <input maxlength=3 type=text class='daysClaimed' value=''> AM &nbsp;&nbsp;<input maxlength=3 type=text class='daysClaimed' value=''> PM ";
echo "</td>";
echo "<Td></td>";

echo "<td>";
echo "<font size=2>f.In case of Death</font>&nbsp;";
echo "<input type=text maxlength=1 class='death'><input type=text maxlength=1 class='death1'>-";
echo "<input type=text maxlength=1 class='death'><input type=text maxlength=1 class='death1'>-";
echo "<input type=text maxlength=1 class='death'><input type=text maxlength=1 class='death1'><input type=text maxlength=1 class='death1'><input type=text maxlength=1 class='death1'>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=1>Specify Date&nbsp;&nbsp;&nbsp;(month-day-year)</font>";
echo "</td>";
echo "</tr>";
echo "</table>";

//$ro->phic_DrugsMeds("1",$registrationNo);
//$ro->phic_OTHERS($registrationNo);
echo "
<br>
<table width='860' border='1' align='center' cellpadding='2' cellspacing='0' bordercolor='#000000' >
  <tr>
    <td width='314' class='style55'><font size=2> 11. Health Care Provider Services</font></td>
    <td width='115' class='style7'><div align='center' class='style56'><font size=2>Actual Charges</font></div></td>
    <td width='111' class='style7'><div align='center' class='style56'><font size=2>Philhealth Benefits</font></div></td>
    <td width='164' class='style7'><div align='center' class='style56'><font size=2>For PhilHealth Use Only(Adjustments/Remarks)</font></div></td>
  </tr>
  <tr id='phicRow'>
    <td class='style55'><font size=2> a. Room And Board&nbsp;&nbsp;Private</font>	 
      <label>
      <input type='checkbox' style='outline: 1px solid #000000;' name='checkbox10' id='checkbox10' />
    <font size=2>Ward</font> 
    <input type='checkbox' style='outline: 1px solid #000000;' name='checkbox11' id='checkbox11' />
    </label></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><input class='phicTableRemarks' type=text value=''></td>
  </tr>
  <tr id='phicRow'>
    <td class='style55'><font size=2> b. Drugs and Medicines (Part II for details)</font> </td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><input class='phicTableRemarks' type=text value=''></td>
  </tr>
  <tr id='phicRow'>
    <td class='style55'> <font size=2>c.X-ray/Lab./Supplies &amp; Others (Part III for Details)</font></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><input class='phicTableRemarks' type=text value=''></td>
  </tr>
  <tr id='phicRow'>
    <td class='style55'><font size=2> d. Operating Room Fee</font></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><input class='phicTableRemarks' type=text value=''></td>
  </tr>
  <tr id='phicRow'>
    <td class='style55'>&nbsp;<font size=2><b>TOTAL</b></font></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></div></td>
    <td class='style55'><input class='phicTableRemarks' type=text value=''></td>
  </tr>
  <tr id='phicRow'>
    <td class='style7'><p class='style56'><font size=2>e. Benefit Package</font></p>    </td>
    <td class='style55'><input class='phicTable' type=text value=''></td>
    <td class='style55'><div align='center'><input class='phicTable' type=text value=''></td>
    <td class='style55'><input class='phicTableRemarks' type=text value=''></td>
  </tr>
</table>

";
	

echo "
<br>
<table width='860' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='385' class='style7'><font size=2>12. Case Type*</font> 
      <label>
      <input type='checkbox' style='outline: 1px solid #000000;' name='checkbox12' id='checkbox12' />
      <font size=2>A</font>
      <input type='checkbox' style='outline: 1px solid #000000;' name='checkbox13' id='checkbox13' />

      <font size=2>B</font>
      <input type='checkbox' style='outline: 1px solid #000000;' name='checkbox14' id='checkbox14' />
      <font size=2>C</font>
      <input type='checkbox' style='outline: 1px solid #000000;' name='checkbox15' id='checkbox15' />
    <font size=2>D</font>    <br />
    <span class='style5'><font size=1>*This is only applicable for claims with fee for service payment mechanism</font></span><br />
    </label></td>";
//$ro->getPatientICD_code($registrationNo);


echo "<td width='499' class='style7'><font size=1>13. Complete ICD-10 Code/s:</font><input type=text value='' class='icd10'></td>";
 
echo "</tr>
</table>

";

echo "
<br>
<table width='860' border='0' align='center' cellpadding='0' cellspacing='0' >
  <tr>
    <td width='884' class='style5'><font size=2><b>(Professional Health Care Providers to fill out items 14 to 16)</b></font></td>
  </tr>
</table>
<table width='860' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
  <tr>
    <td width='236'><font size=2> 14. Admission Diagnosis</font><br>"; 
echo "<div style='border:1px solid #000000; width:232px; height:100px; border-color:white white white white;'>";
echo "<textarea style='width:275px; height:100px; border-color:transparent transparent transparent transparent;'></textarea>";
echo "</div>";
echo "</td>";
echo "<td width='488'><font size=2> 15.Complete Final Diagnosis</font><br>"; 
echo "<div style='border:1px solid #000000; width:482px; height:100px; border-color:white white white white;'>";
//$ro->getPatientICD_diagnosis($registrationNo);
echo "<textarea style='width:575px; height:100px; border-color:transparent transparent transparent transparent;'></textarea>";
echo "</div>";
echo "</td>
  </tr>
</table>

";
echo "<br>";
echo "<table width='860' border='0' align='center' cellpadding='0' cellspacing='0' >";
echo "<tr>";
echo "<td><font size=2>16. Professional Fees/Charges</font></td>";
echo "</tr>";
echo "</table>";
echo "<table width='730' border='1' align='center' cellpadding='0' cellspacing='0' >";
echo "<tr>";
echo "<Td width='27%'>&nbsp;<font size=1>a.Name of Professional<br>b.PhilHealth Accreditation No.</font>&nbsp;</td>";
echo "<td width='14%'>&nbsp;<font size=1>c.Number of Visits / RVS Code<br>d.Inclusive Dates (mm-dd-yyyy)
</font></td>";
echo "<td width='22%'>&nbsp;<font size=1>e.Total Actual PF Charges</font>&nbsp;</td>";
echo "<td width='18%'>&nbsp;<font size=1>f.PhilHealth Benefit</font>&nbsp;</td>";
echo "<td width='18%'>&nbsp;<font size=1>g.Amount paid by members</font>&nbsp;</td>";
echo "<td width='18%'>&nbsp;<font size=1>h.Signature<Br>i.Date Signed</font>&nbsp;</td>";
echo "<td width='18%'>&nbsp;<font size=1>For PhilHealth Use Only</font>&nbsp;</td>";
echo "</tr>";
$ro->phicProfessionalFee("");
echo "<table>";


?>
