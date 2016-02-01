<?php
include("../../../myDatabase.php");
$chargesCode = $_GET['chargesCode'];
$description = $_GET['description'];
$service = $_GET['services'];
$category = $_GET['category'];
$opd = $_GET['opdprice'];
$ward = $_GET['wardprice'];
$soloward = $_GET['solowardprice'];
$semiprivate = $_GET['semiprivateprice'];
$private = $_GET['privateprice'];
$subCategory = $_GET['subCategory'];
$hmo = $_GET['hmo'];
$unitCost = $_GET['unitCost'];

if( $category == "LABORATORY" ) {
$reagent1 = $_GET['reagent1'];
$reagent2 = $_GET['reagent2'];
$reagent3 = $_GET['reagent3'];
$reagent4 = $_GET['reagent4'];
$reagent5 = $_GET['reagent5'];
}else { }


$ro = new database();

$ro->editNow("availableCharges","chargesCode",$chargesCode,"Description",$description);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"Service",$service);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"Category",$category);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"OPD",$opd);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"HMO",$hmo);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"WARD",$ward);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"SOLOWARD",$soloward);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"SEMIPRIVATE",$semiprivate);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"PRIVATE",$private);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"subCategory",$subCategory);
$ro->editNow("availableCharges","chargesCode",$chargesCode,"unitCost",$unitCost);

if( $category == "LABORATORY" ) {
$ro->editNow("availableCharges","chargesCode",$chargesCode,"reagents",$reagent1."-".$reagent2."-".$reagent3."-".$reagent4."-".$reagent5);
}else { }


?>

