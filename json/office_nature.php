<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$Nature_details_query="SELECT institutecd AS NatureCode, institute AS Nature FROM institute ORDER BY institutecd";

$nature_details_result=mysqli_query($DBLink,$Nature_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($nature_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
