<?php
include("../../../myDatabase1.php");
$username = $_GET['username'];
$registrationNo = $_GET['registrationNo'];

$ro = new database1();

echo "<script type='text/javascript' src='/ckeditor/ckeditor.js'></script>";

$ro->coconutDesign();

$startDate = preg_split ("/\-/", $ro->selectNow("promisorryNote","startDate","registrationNo",$registrationNo)); 

if( $startDate[1] == "01" ) {
$startDate_word = "Jan";
}else if( $startDate[1] == "02" ) {
$startDate_word = "Feb";
}else if( $startDate[1] == "03" ) {
$startDate_word = "Mar";
}else if( $startDate[1] == "04" ) {
$startDate_word = "Apr";
}else if( $startDate[1] == "05" ) {
$startDate_word = "May";
}else if( $startDate[1] == "06" ) {
$startDate_word = "Jun";
}else if( $startDate[1] == "07" ) {
$startDate_word = "Jul";
}else if( $startDate[1] == "08" ) {
$startDate_word = "Aug";
}else if( $startDate[1] == "09" ) {
$startDate_word = "Sep";
}else if( $startDate[1] == "10" ) {
$startDate_word = "Oct";
}else if( $startDate[1] == "11" ) {
$startDate_word = "Nov";
}else if( $startDate[1] == "12" ) {
$startDate_word = "Dec";
}else { }



$ro->coconutFormStart("post","editPromisorry1.php");
echo "<table border=0>";
echo "<tr>";
echo "<td>Date&nbsp;</tD>";
echo "<td>";
$ro->coconutTextBox("startDate",$ro->selectNow("promisorryNote","startDate","registrationNo",$registrationNo));
echo "</td>";
echo "</tr>";




echo "<tr>";
echo "<td>Due Date&nbsp;</tD>";
echo "<td>";
$ro->coconutTextBox("dueDate",$ro->selectNow("promisorryNote","dueDate","registrationNo",$registrationNo));
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Balance&nbsp;</td>";
echo "<td>";
$ro->coconutTextBox_short("balance",$ro->selectNow("promisorryNote","amount","registrationNo",$registrationNo));
echo "</td>";
echo "</tr>";
echo "</table>";
$ro->coconutHidden("registrationNo",$registrationNo);
$ro->coconutHidden("username",$username);
echo "<br>";

echo "<textarea id='promisorryNote' name='promisorryNote'>"; 
echo $ro->selectNow("promisorryNote","note","registrationNo",$registrationNo);
echo "</textarea>";

?>

<script type="text/javascript">
			
			CKEDITOR.replace( 'promisorryNote',
	{
		enterMode : CKEDITOR.ENTER_BR,
		skin : 'office2003'
	});
		

</script>

<?php

echo "<Br>";

if( $username == "viewOnly" ) {

}else {
$ro->coconutButton("Proceed");
}
$ro->coconutFormStop();

?>

