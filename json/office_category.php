<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$statusofoffice_details_query="SELECT govt AS CategoryCode, govt_description AS Category FROM govtcategory ORDER BY govt";

$statusofoffice_details_result=mysql_query($statusofoffice_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($statusofoffice_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>