<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$subdivisioncd=substr($_SESSION['UserID'],-4,4);
$category_details_query="SELECT govtcategory.govt, govtcategory.govt_description, COUNT( office.officecd ) AS OfficeCode
FROM office
INNER JOIN govtcategory ON office.govt = govtcategory.govt
WHERE office.subdivisioncd ='$subdivisioncd'
GROUP BY govtcategory.govt, govtcategory.govt_description";
$category_details_result=mysqli_query($DBLink,$category_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($category_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>