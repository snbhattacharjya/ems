<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$employee_details_query="SELECT personcd AS PersonCode,officer_name AS OfficerName,off_desg AS OfficerDesignation FROM employee ORDER BY personcd";

$employee_details_result=mysqli_query($DBLink,$employee_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($employee_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>