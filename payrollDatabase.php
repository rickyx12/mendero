<?php
include("myDatabase2.php");

class payroll extends database2 {


public function listEmployee($username) { 

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT employeeID,completeName from registeredUser group by completeName order by completeName asc ");

while($row = mysql_fetch_array($result))
  {
echo "<tr>";
echo "<td>&nbsp;<a href='http://".$this->getMyUrl()."/COCONUT/payroll/employeeDetails.php?employeeID=$row[employeeID]&username=$username' target='rightFrame' style='text-decoration:none; color:black;'><font size=2>".$row['completeName']."</font></a></tD>";
echo "</tr>";
}

}




public function getExemptionAmount($amount,$monthType,$status) { 

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT MAX(amount) as exemption from contribution_withholdingTax WHERE amount < $amount and monthType = '$monthType' and status = '$status' ");

while($row = mysql_fetch_array($result))
  {
return $row['exemption'];
}

}






public $getPossibleExemption_statusBracket;
public $getPossibleExemption_status;
public $getPossibleExemption_monthType;
public $getPossibleExemption_baseTax;


public function getPossibleExemption_statusBracket() {
return $this->getPossibleExemption_statusBracket;
}
public function getPossibleExemption_status() {
return $this->getPossibleExemption_status;
}
public function getPossibleExemption_monthType() {
return $this->getPossibleExemption_monthType;
}
public function getPossibleExemption_baseTax() {
return $this->getPossibleExemption_baseTax;
}

public function getPossibleExemption($amount,$status,$monthType) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT status,monthType,statusBracket,exemption from contribution_withholdingTax WHERE status = '$status' and monthType = '$monthType' and amount = $amount  ");

while($row = mysql_fetch_array($result))
  {
$this->getPossibleExemption_statusBracket = $row['statusBracket'];
$this->getPossibleExemption_status = $row['status'];
$this->getPossibleExemption_monthType = $row['monthType'];
$this->getPossibleExemption_baseTax = $row['exemption'];
}

}





public function getPhilHealthContribution($amount) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT employeeShare from contribution_phic WHERE $amount between salaryRange1 and salaryRange2 ");

while($row = mysql_fetch_array($result))
  {
return $row['employeeShare'];
}

}




public function getPhilHealth_employerContribution($amount) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT employeeShare from contribution_phic WHERE $amount between salaryRange1 and salaryRange2 ");

while($row = mysql_fetch_array($result))
  {
return $row['employeeShare'];
}

}




public function getSSSContribution($amount) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT EE from contribution_sss WHERE $amount between range1 and range2 ");

while($row = mysql_fetch_array($result))
  {
return $row['EE'];
}

}


public function getSSS_employerContribution($amount) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT ER from contribution_sss WHERE $amount between range1 and range2 ");

while($row = mysql_fetch_array($result))
  {
return $row['ER'];
}

}


public function getHDMFContribution($amount) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT employeeShare from contribution_hdmf WHERE $amount between grossPayRange and grossPayRange1 ");

while($row = mysql_fetch_array($result))
  {
return ($amount * $row['employeeShare']);
}

}


public function getHDMF_employerContribution($amount) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT employerShare from contribution_hdmf WHERE $amount between grossPayRange and grossPayRange1 ");

while($row = mysql_fetch_array($result))
  {
return ($amount * $row['employerShare']);
}

}






public function insertEmployeePayroll($empId,$salary,$overtime,$holiday,$nsd,$late,$absences,$sss,$phic,$pagibig,$withholdingTax,$gross,$deduction,$net,$monthType,$payFrom,$payTo,$timeGenerated,$dateGenerated,$username,$sssEmployerShare,$phicEmployerShare,$pagibigEmployerShare) {

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);

$sql="INSERT INTO employeePayroll (empID,salary,overtime,holiday,nsd,late,absences,sss,phic,pagibig,withholdingTax,gross,deduction,net,monthType,payFrom,payTo,timeGenerated,dateGenerated,username,sssEmployerShare,philhealthEmployerShare,pagibigEmployerShare)
VALUES
('$empId','$salary','$overtime','$holiday','$nsd','$late','$absences','$sss','$phic','$pagibig','$withholdingTax','$gross','$deduction','$net','$monthType','$payFrom','$payTo','$timeGenerated','$dateGenerated','$username','$sssEmployerShare','$phicEmployerShare','$pagibigEmployerShare')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }

/*
echo "<script type='text/javascript' >";
echo "alert('$doctorName was Successfully Added to the List of Doctor');";
echo  "window.location='http://".$this->getMyUrl()."/COCONUT/Doctor/addNewDoctor.php?username=$username '";
echo "</script>";
*/

mysql_close($con);

}




public function getPayrollList($empID,$username) { 

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT payrollNo,monthType,payFrom,payTo,timeGenerated,dateGenerated from employeePayroll WHERE empID = '$empID' and status not like 'DELETED%%%%%%%%%%%%%' order by payrollNo desc ");

$this->coconutTableStart();
$this->coconutTableRowStart();
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableHeader("");
$this->coconutTableHeader("Month Type");
$this->coconutTableHeader("Pay From");
$this->coconutTableHeader("Pay To");
$this->coconutTableHeader("Time Generated");
$this->coconutTableHeader("Date Generated");

$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData("<a href='/COCONUT/payroll/payslip.php?payrollNo=$row[payrollNo]&empID=$empID&username=$username' style='text-decoration:none;' target='_blank'><font size=3 color=red>Payslip</font></a>");
$this->coconutTableData("<a href='/COCONUT/payroll/payrollInfo.php?payrollNo=$row[payrollNo]&empID=$empID&username=$username' style='text-decoration:none;'><font size=3 color=red>View</font></a>");
$this->coconutTableData("<a href='/COCONUT/payroll/deletePayroll.php?payrollNo=$row[payrollNo]&empID=$empID&username=$username' style='text-decoration:none;'><font size=3 color=red>Delete</font></a>");
$this->coconutTableData($row['monthType']);
$this->coconutTableData($row['payFrom']);
$this->coconutTableData($row['payTo']);
$this->coconutTableData($row['timeGenerated']);
$this->coconutTableData($row['dateGenerated']);
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}






public function sssContribution($username) { 

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT * from contribution_sss order by sssID asc  ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();


$this->coconutTableHeader("From");
$this->coconutTableHeader("To");
$this->coconutTableHeader("Salary Credit");
$this->coconutTableHeader("ER");
$this->coconutTableHeader("EE");
$this->coconutTableHeader("total");
$this->coconutTableHeader("EC/ER");
$this->coconutTableHeader("");
//$this->coconutTableHeader("");


$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData(number_format($row['range1'],2));
$this->coconutTableData(number_format($row['range2'],2));
$this->coconutTableData(number_format($row['monthlySalaryCredit'],2));
$this->coconutTableData(number_format($row['ER'],2));
$this->coconutTableData(number_format($row['EE'],2));
$this->coconutTableData(number_format($row['total'],2));
$this->coconutTableData(number_format($row['EC_ER'],2));
$this->coconutTableData("<a href='/COCONUT/payroll/editSSS.php?sssID=$row[sssID]&range1=$row[range1]&range2=$row[range2]&monthlySalaryCredit=$row[monthlySalaryCredit]&ER=$row[ER]&EE=$row[EE]&total=$row[total]&EC_ER=$row[EC_ER]&username=$username' style='text-decoration:none;'>".$this->coconutImages_return("pencil.jpeg")."</a>");
//$this->coconutTableData("<a href='#' style='text-decoration:none;'>".$this->coconutImages_return("delete.jpeg")."</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public function phicContribution($username) { 

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT * from contribution_phic order by phicID asc  ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();


$this->coconutTableHeader("Bracket");
$this->coconutTableHeader("From");
$this->coconutTableHeader("To");
$this->coconutTableHeader("Salary Base");
$this->coconutTableHeader("Monthly Premium");
$this->coconutTableHeader("Employee Share");
$this->coconutTableHeader("Employer Share");
$this->coconutTableHeader("");
//$this->coconutTableHeader("");


$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData(number_format($row['salaryBracket'],0));
$this->coconutTableData(number_format($row['salaryRange1'],2));
$this->coconutTableData(number_format($row['salaryRange2'],2));
$this->coconutTableData(number_format($row['salaryBase'],2));
$this->coconutTableData(number_format($row['totalMonthlyPremium'],2));
$this->coconutTableData(number_format($row['employeeShare'],2));
$this->coconutTableData(number_format($row['employerShare'],2));
$this->coconutTableData("<a href='/COCONUT/payroll/editPHIC.php?username=$username&phicID=$row[phicID]&salaryBracket=$row[salaryBracket]&salaryRange1=$row[salaryRange1]&salaryRange2=$row[salaryRange2]&salaryBase=$row[salaryBase]&totalMonthlyPremium=$row[totalMonthlyPremium]&employeeShare=$row[employeeShare]&employerShare=$row[employerShare]' style='text-decoration:none;'>".$this->coconutImages_return("pencil.jpeg")."</a>");
//$this->coconutTableData("<a href='#' style='text-decoration:none;'>".$this->coconutImages_return("delete.jpeg")."</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}





public function pagibigContribution($username) { 

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT * from contribution_hdmf order by hdmfNo asc  ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();


$this->coconutTableHeader("From");
$this->coconutTableHeader("To");
$this->coconutTableHeader("Employee Share");
$this->coconutTableHeader("Employer Share");
$this->coconutTableHeader("");
//$this->coconutTableHeader("");


$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData(number_format($row['grossPayRange'],2));
$this->coconutTableData(number_format($row['grossPayRange1'],2));
$this->coconutTableData(number_format($row['employeeShare'],2));
$this->coconutTableData(number_format($row['employerShare'],2));
$this->coconutTableData("<a href='/COCONUT/payroll/editHDMF.php?hdmfNo=$row[hdmfNo]&grossPayRange=$row[grossPayRange]&grossPayRange1=$row[grossPayRange1]&employeeShare=$row[employeeShare]&employerShare=$row[employerShare]&username=$username' style='text-decoration:none;'>".$this->coconutImages_return("pencil.jpeg")."</a>");
//$this->coconutTableData("<a href='#' style='text-decoration:none;'>".$this->coconutImages_return("delete.jpeg")."</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public function withholdingTax($username) { 

echo "
<style type='text/css'>
tr:hover { background-color:yellow;color:black;}

a { text-decoration:none; color:black; }
</style>";

$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT * from contribution_withholdingTax order by status,monthType asc  ");

echo "<center>";
$this->coconutTableStart();
$this->coconutTableRowStart();


$this->coconutTableHeader("Month Type");
$this->coconutTableHeader("Status");
$this->coconutTableHeader("Amount");
$this->coconutTableHeader("Exemption");
$this->coconutTableHeader("Status Bracket");
$this->coconutTableHeader("");
//$this->coconutTableHeader("");


$this->coconutTableRowStop();
while($row = mysql_fetch_array($result))
  {
$this->coconutTableRowStart();
$this->coconutTableData($row['monthType']);
$this->coconutTableData($row['status']);
$this->coconutTableData(number_format($row['amount'],2));
$this->coconutTableData(number_format($row['exemption'],2));
$this->coconutTableData($row['statusBracket']);
$this->coconutTableData("<a href='/COCONUT/payroll/editWTAX.php?taxNo=$row[taxNo]&username=$username&monthType=$row[monthType]&status=$row[status]&amount=$row[amount]&exemption=$row[exemption]&statusBracket=$row[statusBracket]' style='text-decoration:none;'>".$this->coconutImages_return("pencil.jpeg")."</a>");
//$this->coconutTableData("<a href='#' style='text-decoration:none;'>".$this->coconutImages_return("delete.jpeg")."</a>");
$this->coconutTableRowStop();
}
$this->coconutTableStop();
}




public $monthlyReport_total;
public function monthlyReport($column,$from,$to) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT ($column) as amount,ru.completeName from employeePayroll ep,registeredUser ru WHERE ru.employeeID = ep.empID and ep.dateGenerated between '$from' and '$to' and ep.status not like 'DELETED_%%%%%%%%' ");

while($row = mysql_fetch_array($result))
  {
echo "<tr>";
$this->monthlyReport_total += $row['amount'];
echo "<td>&nbsp;".$row['completeName']."</tD>";
echo "<td>&nbsp;".number_format($row['amount'],2)."</tD>";
echo "</tr>";
}
echo "<tr>";
echo "<td>&nbsp;<b>Total</b></td>";
echo "<td>&nbsp;".number_format($this->monthlyReport_total,2)."</td>";
echo "</tr>";
}




public $payrollMonthly_sss;
public $payrollMonthly_phic;
public $payrollMonthly_hdmf;
public $payrollMonthly_wTax;
public $payrollMonthly_gross;
public $payrollMonthly_deduction;
public $payrollMonthly_net;

public function payrollMonthly($from,$to) { 


$con = mysql_connect($this->myHost,$this->username,$this->password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($this->database, $con);


$result = mysql_query("SELECT ru.completeName,ep.sss,ep.phic,ep.pagibig,ep.withholdingTax,ep.gross,ep.deduction,ep.net from employeePayroll ep,registeredUser ru WHERE ep.empID = ru.employeeID and ep.dateGenerated between '$from' and '$to' and ep.status not like 'DELETED_%%%%%%%' order by ru.completeName asc ");

while($row = mysql_fetch_array($result))
  {
echo "<tr>";

$this->payrollMonthly_sss += $row['sss'];
$this->payrollMonthly_phic += $row['phic'];
$this->payrollMonthly_hdmf += $row['pagibig'];
$this->payrollMonthly_wTax += $row['withholdingTax'];
$this->payrollMonthly_gross += $row['gross'];
$this->payrollMonthly_deduction += $row['deduction'];
$this->payrollMonthly_net += $row['net'];

echo "<td>&nbsp;".$row['completeName']."&nbsp;</td>";
echo "<td>&nbsp;".number_format($row['sss'],2)."&nbsp;</td>";
echo "<td>&nbsp;".number_format($row['phic'],2)."&nbsp;</tD>";
echo "<td>&nbsp;".number_format($row['pagibig'],2)."&nbsp;</td>";
echo "<td>&nbsp;".number_format($row['withholdingTax'],2)."&nbsp;</td>";
echo "<td>&nbsp;".number_format($row['gross'],2)."&nbsp;</td>";
echo "<td>&nbsp;".number_format($row['deduction'],2)."&nbsp;</td>";
echo "<tD>&nbsp;".number_format($row['net'],2)."&nbsp;</td>";
echo "</tr>";
}
echo "<tr>";
echo "<td>&nbsp;<b>Total</b></td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_sss,2)."</td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_phic,2)."</td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_hdmf,2)."</td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_wTax,2)."</td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_gross,2)."</td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_deduction,2)."</td>";
echo "<td>&nbsp;".number_format($this->payrollMonthly_net,2)."</td>";
echo "</tr>";
}





}


?>
