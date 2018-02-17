<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");


$subdivision_details_query="SELECT subdivisioncd AS SubdivisionCode, subdivision AS Subdivision FROM subdivision ORDER BY subdivisioncd";
$subdivision_details_result=mysql_query($subdivision_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($subdivision_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>