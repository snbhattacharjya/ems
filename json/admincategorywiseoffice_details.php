<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$category_details_query="SELECT office.subdivisioncd,govtcategory.govt, govtcategory.govt_description, COUNT( office.officecd ) AS OfficeCode FROM office INNER JOIN govtcategory ON office.govt = govtcategory.govt GROUP BY office.subdivisioncd,govtcategory.govt";
$category_details_result=mysqli_query($DBLink,$category_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($category_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>