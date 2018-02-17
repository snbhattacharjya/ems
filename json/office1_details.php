<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$office_details_query="SELECT officecd AS OfficeCode, office AS Office FROM office ORDER BY officecd";
$office_details_result=mysql_query($office_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($office_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>