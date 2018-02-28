<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$office_details_query="SELECT officecd AS OfficeCode, office AS Office FROM office ORDER BY officecd";
$office_details_result=mysqli_query($DBLink,$office_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($office_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
