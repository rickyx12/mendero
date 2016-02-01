<?php
include("../../myDatabase2.php");
$stockCardNo = $_GET['stockCardNo'];
$inventoryType = $_GET['inventoryType'];
$show = $_GET['show'];
$ro = new database2();
$ro->coconutDesign();

echo "Stock Card#:&nbsp;<b>($stockCardNo)</b><Br>Brand Name:&nbsp;<b>".$ro->selectNow("inventoryStockCard","description","stockCardNo",$stockCardNo)."</b><Br>Generic Name:&nbsp;<b>".$ro->selectNow("inventoryStockCard","genericName","stockCardNo",$stockCardNo)."</b>";
echo "<br>";
$ro->coconutFormStart("get","http://".$ro->getMyUrl()."/COCONUT/inventory/stockCard.php");
$ro->coconutHidden("stockCardNo",$stockCardNo);
$ro->coconutHidden("inventoryType",$inventoryType);
echo "<select name='show' onchange='this.form.submit()' style='border:1px solid #ff0000; width:140px;'>";
echo "<option value='$show'>$show</option>";
echo "<option value='PHARMACY'>PHARMACY</option>";
echo "<option value='ER E Cart'>ER E Cart</option>";
echo "<option value='OR E Cart'>OR E Cart</option>";
echo "<option value='DR E Cart'>DR E Cart</option>";
echo "<option value='3A E Cart'>3A E Cart</option>";
echo "<option value='3B E Cart'>3B E Cart</option>";
echo "<option value='ICU E Cart'>ICU E Cart</option>";
echo "<option value='ENDOSCOPY E Cart'>ENDOSCOPY E Cart</option>";
echo "<option value='HEMODIALYSIS E Cart'>HEMODIALYSIS E Cart</option>";
echo "<option value='CARDIOLOGY E Cart'>CARDIOLOGY E Cart</option>";
echo "<option value='RADIOLOGY E Cart'>RADIOLOGY E Cart</option>";
echo "<option value='CSR'>CSR</option>";
echo "<option value='PICU'>PICU</option>";
echo "<option value='OB PACKAGE'>OB Package</option>";
echo "<option value='OR PACKAGE'>OR Package</option>";
echo "<option value='(MINOR OR) ER PACKAGE'>(Minor) ER Package</option>";
echo "<option value='all'>All</option>";
$ro->coconutComboBoxStop();
$ro->coconutFormStop();

echo "<center><br><br>";
$ro->viewStockCard($stockCardNo,$inventoryType,$show);

?>
