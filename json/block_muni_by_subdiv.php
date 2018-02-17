<?php
session_start();
$userid=$_SESSION['UserID'];
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$municipality_details_query="SELECT blockminicd AS BlockminiCode, blockmuni AS Blockmuni FROM block_muni WHERE subdivisioncd='$subdiv'";


$municipality_details_result=mysqli_query($DBLink,$municipality_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($municipality_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>