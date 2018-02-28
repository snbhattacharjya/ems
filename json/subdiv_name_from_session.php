<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv=$_SESSION['Subdiv'];
$subdiv_name_query="SELECT subdivision AS SubdivisionName FROM subdivision WHERE subdivisioncd='$subdiv'";

$subdiv_name_result=mysqli_query($DBLink,$subdiv_name_query) or die(mysqli_error($DBLink));
$return=mysqli_fetch_assoc($subdiv_name_result);

echo json_encode($return);
?>
