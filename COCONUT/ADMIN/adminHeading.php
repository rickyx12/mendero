<?php
include("../../myDatabase.php");
require_once('../authentication.php');

$username = $_SESSION['username'];
$module = $_SESSION['module'];

$ro = new database();

/*
if ( (!isset($username) && !isset($module)) ) {
header("Location:http://".$ro->getMyUrl()."/LOGINPAGE/module.php ");
}
*/
?>

<html>
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/flow/rickyCSS1.css" />
        <script type="text/javascript" src="http://<?php echo $ro->getMyUrl() ?>/Registration/menu/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="http://<?php echo $ro->getMyUrl() ?>/Registration/menu/jquery.fixedMenu.js"></script>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl();?>/Registration/menu/fixedMenu_style1.css" />

<?php
//hmoSOA.php

echo "
<script type='text/javascript'>

        $('document').ready(function(){
            $('.menu').fixedMenu();

        });


$('#breadcrumbs a').hover(
    function () {
        $(this).addClass('hover').children().addClass('hover');
        $(this).parent().prev().find('span.arrow:first').addClass('pre_hover');
    },
    function () {
        $(this).removeClass('hover').children().removeClass('hover');
        $(this).parent().prev().find('span.arrow:first').removeClass('pre_hover');
    }
);


var username = 'Search Patient';
function SetMsg(txt,active) {
    if (txt == null) return;
    
    if (active) {
        if (txt.value == username) txt.value = '';                     
    } else {
        if (txt.value == '') txt.value = username;
    }
}

window.onload=function() { SetMsg(document.getElementById('searchPatient', false)); }
</script>

<style type='text/css'>
.txtBox {
	border: 1px solid #CCC;
	color: #999;
	height: 50px;
	width: 350px;
}
</style>

";

?>
</head>
<body>
<ol id="breadcrumbs">
        <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/ADMIN/initializeAdmin.php"><font color=white>Home</font><span class="arrow"></span></a></li>
        <li><a href="#" class='odd'><font color=yellow><?php echo $_SESSION['module']; ?></font><span class="arrow"></span></a></li>

    <li>&nbsp;&nbsp;</li>
</ol>


    <div class="menu">
        <ul>
   

            <li>
                <a href="#">Convenience<span class="arrow"></span></a>
                
                <ul>
               <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/ADMIN/viewConvenienceInv.php" target="departmentX">Inventory</a></li>
		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/convenience/reportShift.php?username=<?php echo $username; ?>" target="departmentX">Collection Report</a></li>
		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/convenience/convenienceCollection_date.php?username=<?php echo $username; ?>" target="departmentX">Monthly Collection Report</a></li>
               
		 </ul>
            </li>


 		 <li>
                <a href="#">MMC Reports<span class="arrow"></span></a>
                
                <ul>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashierReport/reportShift.php?module=<?php echo $module; ?>&username=<?php echo $username; ?>&reportName=Collection&status=PAID" target="_blank">Collection Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/soaSummaryDate.php" target="departmentX">Discharged Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/adminSoaDate.php" target="departmentX">Discharged Report w/ SOA</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashCollection/cashReportMenu.php" target="departmentX">Cash Collection</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashCollection/cashCollection_output_monthlyDate_receivables.php" target="departmentX">Cash Collection & Receivables</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Laboratory/labCensus/selectDoctor.php?title=LABORATORY" target="departmentX">20% Rebates in Laboratory</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashierReport/receiptTypeReportDate.php?receiptType=medicine&username=<?php echo $username; ?>" target="departmentX">Pharmacy Medicine Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashierReport/receiptTypeReportDate.php?receiptType=hospital&username=<?php echo $username; ?>" target="departmentX">Pharmacy Hospital Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/inventoryReport/selectShift.php?module=<?php echo $module; ?>&username=<?php echo $username; ?>&reportName=Current Usages&branch=<?php echo $ro->getUserBranch_username($username,$module);  ?>" target="departmentX" >Pharmacy Dispensed Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/oxygenReport.php" target="departmentX">Oxygen Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/reportWithOR_date.php" target="departmentX">Cash Sales of Medicine and Supplies Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/monthlyRangeDoctor.php?username=<?php echo $username; ?>&title=PROFESSIONAL FEE&service=ATTENDING" target="departmentX">Top 20 Attending Doctor </a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/monthlyRangeDoctor.php?username=<?php echo $username; ?>&title=PROFESSIONAL FEE&service=ATTENDING" target="departmentX">Top 20 Admitting Doctor </a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/patientProfile/promisorryNote/promisorryNoteReport.php?username=<?php echo $username; ?>" target="departmentX">Promisorry Note Report </a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Pharmacy/inventory_newSearching1.php?username=<?php echo $username; ?>" target="departmentX">Search Inventory</a></li>

<li><a href="../../Forms/DeletedChargesReportSD.php?username=<?php echo $username; ?>" target="departmentX">Deleted Charges Report</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/inventory/reOrdering.php" target="departmentX">Re Ordering</a></li>

<li><a href="../../Forms/SearchOR.php?search=None&type=Payments&username=<?php echo $username; ?>" target="departmentX">Search O.R.</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/inventory/inventoryPerDeptSelect.php" target="departmentX">Inventory Per Dept</a></li>

                </ul>
            	</li>


            <li>
                <a href="#">Financial<span class="arrow"></span></a>
                <ul>
<?php //admin_reportRange.php?module=&username=&reportName=Laboratory ?>

                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/billing/selectType.php?module=<?php echo $module; ?>&username=<?php echo $username; ?>&reportName=Laboratory" target="departmentX">Cash (Paid)</a></li>

<? //cash collection
/*
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/ADMIN/cashCollection_date.php" target="departmentX">Cash Collection</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashCollection/cashCollection_output_monthlyDate.php" target="departmentX">Montly Cash Collection</a></li>
*/
?>

<?
/*
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashierReport/reportShift.php?module=<?php echo $module; ?>&username=<?php echo $username; ?>&reportName=Collection&status=PAID" target="_blank">Collection Report</a></li>

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Cashier/cashCollection/selectOption.php?username=<?php echo $username; ?>" target="_blank">Cash Collection</a></li>

*/
?>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/hmoSOA_type.php?username=<?php echo $username; ?>&reportName=Remittance" target="departmentX">Company (Receivable)</a></li>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Company/companyPaymentReport.php?username=<?php echo $username; ?>&reportName=Remittance" target="departmentX">Company (Posted Payment)</a></li>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Company/getRefNo.php?username=<?php echo $username; ?>&reportName=Remittance" target="departmentX">Company (Via RefNo)</a></li>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/companySummary/selectCutoff.php?username=<?php echo $username; ?>&reportName=Remittance" target="departmentX">Company Summary (Receivable)</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Company/AgingOfAccountsMenu.php?username=<?php echo $username; ?>" target="departmentX">Aging of Accounts (Company)</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/IPDBalancePerRoomSelectDate.php" target="departmentX">Admitted Balance</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/philhealth/phicReceivables/dateCovered.php?username=<?php echo $username; ?>" target="departmentX">PhilHealth (Receivable)</a></li
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/doctorReport/selectType.php?username=<?php echo $username; ?>" target="departmentX">Doctor's PF</a></li>



                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/doctorReport/selectShiftBranch.php?username=<?php echo $username; ?>" target="departmentX">Doctor's PF Summary</a></li>
                     <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/markupPrice.php" target="departmentX">Add 50% Markup in Supplies</a></li>

<?php     
  /*         
    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/philhealth/transmitalShift.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">PhilHealth Transmital</a></li>
                            <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/philhealth/transmittedShift.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">PhilHealth Transmitted</a></li>  
*/
?>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/ADMIN/voidPayment_shift.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Void Payments</a></li>

 </ul>
           </li>    



            <li>
                <a href="#">Census<span class="arrow"></span></a>
                
                <ul>

<?
/*
		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/Census/selectShift.php?username=<?php echo $username; ?>&switch=1" target="departmentX">Departamental Patient Census</a></li>

		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/Census/selectShift.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Departamental Examination Census</a></li>
*/
?>		
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/Census/selectShift_registered.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Registration Census</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/Census/selectShift.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Summary Laboratory Census</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/toDischarge.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Mass Discharge</a></li>


                </ul>
            </li>


 <li>
                <a href="#">Search<span class="arrow"></span></a>
                <ul>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchCharges.php?username=<?php echo $username; ?>&title=LABORATORY&show=search" target="departmentX">Laboratory Charges</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchCharges.php?username=<?php echo $username; ?>&title=RADIOLOGY&show=search" target="departmentX">Radiology Charges</a></li>


                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchInventory.php?username=<?php echo $username; ?>&inventoryType=medicine&branch=All&show=search" target='departmentX'>Medicine</a></li>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchInventory.php?username=<?php echo $username; ?>&inventoryType=supplies&branch=All&show=search" target='departmentX'>Supplies</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchInventory.php?username=<?php echo $username; ?>&inventoryType=PHARMACY&branch=All&show=search" target='departmentX'>Pharmacy</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchDoctor.php?username=<?php echo $username; ?>&show=search" target='departmentX'>Doctor</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchDoctorService.php?username=<?php echo $username; ?>&show=search" target='departmentX'>Doctor Service</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchService.php?username=<?php echo $username; ?>&show=search" target='departmentX'>Charges Service</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchCompany.php?username=<?php echo $username; ?>&show=search" target='departmentX'>Company</a></li>
                    <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/maintenance/searchUser.php?username=<?php echo $username; ?>&show=search" target='departmentX'>User</a></li>

<?php

echo  ' <li>
<form method="post" action="/COCONUT/currentPatient/patientInterface.php" target="_blank">
<input type="hidden" name="username" value="'.$username.'">
<input type="hidden" name="module" value="'.$module.'">
<input type="hidden" name="patientSearch" value="">
<input type="submit" value="Search Patient">
</form>
</li>';

?>

</ul>
</li>   


            <li>
                <a href="#">Admitted Patient<span class="arrow"></span></a>
                
                <ul>
<?php   //$ro->showFloorAsUpperMenu_admin($username,$module);    

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/billing/billingStation.php?username=$username&module=ADMIN&branch=Consolacion&floor=2nd floor' target='departmentX'>2nd floor</a></li>";

echo "<li><a href='http://".$ro->getMyUrl()."/COCONUT/billing/billingStation.php?username=$username&module=ADMIN&branch=Consolacion&floor=3rd floor' target='departmentX'>3rd floor</a></li>";

      ?>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/ADMIN/discharged_cutoff.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Discharged Patient</a></li>    
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Company/currentAdmitted.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Admitted</a></li>  
  
        </ul>
	</li>


 <li>
                <a href="#">Accounting<span class="arrow"></span></a>
                
                <ul>
		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/voucher/addVoucher_acct.php?username=<?php echo $username; ?>" target="departmentX">Add Voucher</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/voucher/searchVoucher.php?username=<?php echo $username; ?>" target="_blank">View Voucher</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/voucher/voucherList.php?username=<?php echo $username; ?>&checkedNo=" target="departmentX">Search Voucher</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/voucher/showVoucher_date.php?username=<?php echo $username; ?>" target="departmentX">View Voucher By Date</a></li>

		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/cashDisbursement/disbursementShift.php?username=<?php echo $username; ?>" target="departmentX">Cash Disbursement</a></li>
		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/trialBalance/selectTrialBalance.php" target="departmentX">Trial Balance</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/accounting/profitANDloss/month.php?username=<?php echo $username; ?>" target="departmentX">Profit And Loss</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/Reports/cashReport_date.php?username=<?php echo $username; ?>" target="_blank">Chart of Accounts</a></li>


                </ul>
            </li>


 <li>
                <a href="#">Chart<span class="arrow"></span></a>
                
                <ul>
 <li><a href="#" target="departmentX"><font color=red>Financial</font></a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/pieChart/selectShift_revenue.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Daily Collection Chart</a></li>     

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleHorizontalChart/selectShift_revenue.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Monthly Collection Chart</a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift_revenue.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Annual Collection Chart</a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleBarChart/selectShift_expenses.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Monthly Expenses Chart</a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift_expenses.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Annual Expenses Chart</a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleHorizontalChart/selectShift_receivables.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Monthly PhilHealth Receivables Chart</a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift_phicReceivables.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Annual PhilHealth Receivables Chart</a></li> 


 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleHorizontalChart/selectShift_discount.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Monthly Discount Chart</a></li> 

 <li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift_discount.php?username=<?php echo $username; ?>&module=<?php echo $module; ?>" target="departmentX">Annual Discount Chart</a></li> 

		<li><a href="#" target="departmentX"><font color=red>Census</font></a></li>

		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/selectShift.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Registration Census Daily Chart</a></li>

		<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleBarChart/selectShift.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Registration Census Monthly Chart</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Registration Census Annual Chart</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/pieChart/selectShift_genderCensus.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Gender Census Daily Chart</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleBarChart/selectShift_monthlyRegistrationType.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Gender Census Monthly Chart</a></li>
<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift_genderCensus.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Gender Census Annual Chart</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleBarChart/selectShift_senior.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Senior Census Monthly Chart</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/multipleLineChart/selectShift_senior.php?username=<?php echo $username; ?>&switch=2" target="departmentX">Senior Census Annual Chart</a></li>

 <li><a href="#" target="departmentX"><font color=red>OPD Top 20 Highest Sale's</font></a></li> 

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift.php?username=<?php echo $username; ?>&title=MEDICINE" target="departmentX">Medicine</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift.php?username=<?php echo $username; ?>&title=SUPPLIES" target="departmentX">Supplies</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift.php?username=<?php echo $username; ?>&title=LABORATORY" target="departmentX">Laboratory</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift.php?username=<?php echo $username; ?>&title=RADIOLOGY" target="departmentX">Radiology</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift.php?username=<?php echo $username; ?>&title=PROFESSIONAL FEE" target="departmentX">Doctor</a></li>

 <li><a href="#" target="departmentX"><font color=red>IPD Top 20 Highest Sale's</font></a></li> 

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_ipd.php?username=<?php echo $username; ?>&title=MEDICINE" target="departmentX">Medicine</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_ipd.php?username=<?php echo $username; ?>&title=SUPPLIES" target="departmentX">Supplies</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_ipd.php?username=<?php echo $username; ?>&title=LABORATORY" target="departmentX">Laboratory</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_ipd.php?username=<?php echo $username; ?>&title=RADIOLOGY" target="departmentX">Radiology</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_ipd.php?username=<?php echo $username; ?>&title=PROFESSIONAL FEE" target="departmentX">Doctor</a></li>

 <li><a href="#" target="departmentX"><font color=red>Fast Moving Items</font></a></li> 

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_fastMoving.php?username=<?php echo $username; ?>&title=MEDICINE" target="departmentX">Medicine</a></li>

<li><a href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/graphicalReport/bestSelling/selectShift_fastMoving.php?username=<?php echo $username; ?>&title=SUPPLIES" target="departmentX">Supplies</a></li>

                </ul>
            </li>





    </div>



<iframe src="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/ADMIN/requestDelete_update.php?username=<?php echo $username; ?>" width="100%" height="540"  name="departmentX" border=1 frameborder=no></iframe>

</body>
</html>
