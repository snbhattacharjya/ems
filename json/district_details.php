<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$district_details_query="SELECT districtcd AS DistrictCode, district AS District FROM district ORDER BY districtcd";
$district_details_result=mysqli_query($DBLink,$district_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($district_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
