<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$user_id = $_SESSION['UserID'];

if($user_id != 'ADMIN' || $user_id != 'ppcell_hug'){
	$subdiv = $_SESSION['Subdiv'];
	$subdivision_details_query="SELECT subdivisioncd AS SubdivisionCode, subdivision AS Subdivision FROM subdivision WHERE subdivisioncd = '$subdiv' ORDER BY subdivisioncd";
}
else{
	$subdivision_details_query="SELECT subdivisioncd AS SubdivisionCode, subdivision AS Subdivision FROM subdivision ORDER BY subdivisioncd";
}

$subdivision_details_result=mysqli_query($DBLink,$subdivision_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($subdivision_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
