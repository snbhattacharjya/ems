<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$Nature_details_query="SELECT institutecd AS NatureCode, institute AS Nature FROM institute ORDER BY institutecd";

$nature_details_result=mysql_query($Nature_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($nature_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>