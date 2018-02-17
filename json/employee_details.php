<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$employee_details_query="SELECT personcd AS PersonCode,officer_name AS OfficerName,off_desg AS OfficerDesignation FROM employee ORDER BY personcd";

$employee_details_result=mysql_query($employee_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($employee_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>