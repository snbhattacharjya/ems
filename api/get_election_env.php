<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$env_details_query="SELECT * FROM environment";
$env_details_result=mysqli_query($DBLink,$env_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($env_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
