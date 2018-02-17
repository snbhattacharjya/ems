<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv=$_POST['subdiv'];

$venue_details_query=$mysqli->prepare("SELECT DISTINCT training_schedule.training_dt, DATE_FORMAT(DATE(training_schedule.training_dt),'%D-%b-%Y (%a)') FROM training_schedule INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd WHERE training_venue.subdivisioncd = ? ORDER BY training_dt") or die($mysqli->error);

$venue_details_query->bind_param("s",$subdiv) or die($venue_details_query->error);

$venue_details_query->execute() or die($venue_details_query->error);
$venue_details_query->bind_result($training_date,$date_format) or die($venue_details_query->error);
$return=array();
while($venue_details_query->fetch())
{
	$return[]=array("TrainingDate"=>$training_date,"DateFormat"=>$date_format);
}	
echo json_encode($return);
?>