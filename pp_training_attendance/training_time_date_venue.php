<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$training_venue=$_POST['training_venue'];
$training_date=$_POST['training_date'];

$venue_details_query=$mysqli->prepare("SELECT DISTINCT training_schedule.training_time FROM training_schedule INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd WHERE training_venue.venue_base_name = ? AND training_schedule.training_dt = ? ORDER BY training_time") or die($mysqli->error);

$venue_details_query->bind_param("ss",$training_venue,$training_date) or die($venue_details_query->error);

$venue_details_query->execute() or die($venue_details_query->error);
$venue_details_query->bind_result($training_time) or die($venue_details_query->error);
$return=array();
while($venue_details_query->fetch())
{
	$return[]=array("TrainingTime"=>$training_time);
}	
echo json_encode($return);
?>