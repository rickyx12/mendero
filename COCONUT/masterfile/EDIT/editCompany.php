<?php
include("../../../myDatabase.php");
$username = $_GET['username'];
$companyNo = $_GET['companyNo'];
$companyName = $_GET['companyName'];
$companyAddress = $_GET['companyAddress'];
$rate1 = $_GET['rate1'];
$rate2 = $_GET['rate2'];
$rate3 = $_GET['rate3'];
$rate4 = $_GET['rate4'];
$show = $_GET['show'];
$desc = $_GET['desc'];


$ro = new database();
?>

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
</script>


<?php

echo "<script type='text/javascript'>";
echo "
var company = 'Company Name';
function SetCompanyName (txt,active) {
    if (txt == null) return;
    
 
    if (active) {
        if (txt.value == company) txt.value = '';                     
    } else {
        if (txt.value == '') txt.value = company;
    }
}

window.onload=function() { SetCompanyName(document.getElementById('companyNamez', false)); }



var address = 'Company Address';
function SetCompanyAddress (txt,active) {
    if (txt == null) return;
    
 
    if (active) {
        if (txt.value == address) txt.value = '';                     
    } else {
        if (txt.value == '') txt.value = address;
    }
}

window.onload=function() { SetCompanyAddress(document.getElementById('companyAddress', false)); }

var rate = '0.00';
function SetRate (txt,active) {
    if (txt == null) return;
    
 
    if (active) {
        if (txt.value == rate) txt.value = '';                     
    } else {
        if (txt.value == '') txt.value = rate;
    }
}

window.onload=function() { SetRate(document.getElementById('companyRate', false)); }


";
echo "</script>";

echo "<style type='text/css'>";

echo ".txtBox {
	border: 1px solid #CCC;
	color: #999;
	height:30px;
	width: 300px;
	padding:4px 4px 4px 2px;
}


.rate {
	border: 1px solid #CCC;
	color: #999;
	height:30px;
	width: 100px;
	padding:4px 4px 4px 2px;
}

.companyAddress {
	border: 1px solid #CCC;
	color: #999;
	height:80px;
	width: 300px;
	padding:4px 4px 4px 2px;
}

";
echo "</style>";

/*
echo "<table id='headz' border=0 bgcolor='#3b5998' width='100%'>
<td>&nbsp;&nbsp;<font size=5 color=white><b>Company Registration</b></font></td></table>";
*/
echo "<br>";
echo "<center><div style='border:1px solid #000000; width:500px; height:370px; border-color:black black black black;'>";
echo "<br><Br>";
echo "<form method='get' action='editCompany1.php'>";
echo "<input type=hidden name='username' value='$username'>";
echo "<input type=hidden name='companyNo' value='$companyNo'>";
echo "<input type=hidden name='show' value='$show'>";
echo "<input type=hidden name='desc' value='$desc'>";
echo "<input type=text name='companyName' class='txtBox' id='companyNamez' value='$companyName' 
onfocus='SetCompanyName(this, true);'
onblur='SetCompanyName(this,false);'
 >";
echo "<br><br>";
echo "<textarea class='companyAddress' id='companyAddress' name='companyAddress'
onfocus='SetCompanyAddress(this, true);'
onblur='SetCompanyAddress(this,false);'
>$companyAddress</textarea>";

echo "<br><br>";
echo "<table border=0 cellpadding=0 cellspacing=0>";
echo "<tr>";
echo "<td width='18%'>";
echo "<font size=2>Rate 1:</font>&nbsp;";
echo "</td>";
echo "<td width='74%'>";
echo "<input type=text name='rate1' class='rate' id='companyRate' value='$rate1' 
onfocus='SetRate(this, true);'
onblur='SetRate(this,false);'
  >";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='18%'>";
echo "<font size=2>Rate 2:</font>&nbsp;";
echo "</td>";
echo "<td width='74%'>";
echo "<input type=text name='rate2' class='rate' id='companyRate' value='$rate2' 
onfocus='SetRate(this, true);'
onblur='SetRate(this,false);'
 >";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='18%'>";
echo "<font size=2>Rate 3:</font>&nbsp;";
echo "</td>";
echo "<td width='74%'>";
echo "<input type=text name='rate3' class='rate' id='companyRate' value='$rate3' 
onfocus='SetRate(this, true);'
onblur='SetRate(this,false);'
 >";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='18%'>";
echo "<font size=2>Rate 4:</font>&nbsp;";
echo "</td>";
echo "<td width='74%'>";
echo "<input type=text name='rate4' class='rate' id='companyRate' value='$rate4' 
onfocus='SetRate(this, true);'
onblur='SetRate(this,false);'
 >";
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td>Type</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("type");
echo "<option value='hmo'>HMO</option>";
echo "<option value='company'>Company</option>";
echo "<option value='insurance'>Insurance</option>";
echo "<option value='pronote'>Pronote</option>";
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";


echo "</table>";
echo "<br><input type=submit value='Add Company' style='border:1px solid #000000; background:#3b5998 no-repeat 4px 4px; color:white;'>";
echo "</form>";
echo "</div>";

?>
