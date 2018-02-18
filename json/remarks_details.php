<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$remarks_details_query="SELECT remarks_cd AS RemarksCode, remarks AS RemarksName FROM remarks ORDER BY remarks_cd";

$remarks_details_result=mysqli_query($DBLink,$remarks_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($remarks_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>