<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv=$_POST['subdiv'];

$venue_details_query=$mysqli->prepare("SELECT DISTINCT venue_base_name FROM training_venue WHERE subdivisioncd = ? ORDER BY venue_base_name") or die($mysqli->error);

$venue_details_query->bind_param("s",$subdiv) or die($venue_details_query->error);

$venue_details_query->execute() or die($venue_details_query->error);
$venue_details_query->bind_result($venue_base_name) or die($venue_details_query->error);
$return=array();
while($venue_details_query->fetch())
{
	$return[]=array("VenueBaseName"=>$venue_base_name);
}	
echo json_encode($return);
?>