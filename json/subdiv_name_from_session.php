<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv=$_SESSION['Subdiv'];
$subdiv_name_query="SELECT subdivision AS SubdivisionName FROM subdivision WHERE subdivisioncd='$subdiv'";

$subdiv_name_result=mysql_query($subdiv_name_query,$DBLink) or die(mysql_error());
$return=mysql_fetch_assoc($subdiv_name_result);

echo json_encode($return);
?>