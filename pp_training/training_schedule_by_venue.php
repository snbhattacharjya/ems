<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$venue_base_name=$_POST['venue_base_name'];

if(!isset($_SESSION['Subdiv'])){
    $training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_schedule.training_dt, training_schedule.training_time, training_schedule.post_status, training_schedule.no_pp FROM training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE training_venue.venue_base_name = ? ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    $training_schedule_venue_query->bind_param("s",$venue_base_name) or die($training_schedule_venue_query->error);
}
else{
    $training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_schedule.training_dt, training_schedule.training_time, training_schedule.post_status, training_schedule.no_pp FROM training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE training_venue.venue_base_name = ? AND training_venue.subdivisioncd = ? ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    $training_schedule_venue_query->bind_param("ss",$venue_base_name, $_SESSION['Subdiv']) or die($training_schedule_venue_query->error);
}

$training_schedule_venue_query->execute() or die($training_schedule_venue_query->error);
$training_schedule_venue_query->bind_result($venue_code,$venue_name,$training_date,$training_time,$post_status,$no_pp) or die($training_schedule_venue_query->error);
$return=array();
while($training_schedule_venue_query->fetch())
{
	$return[]=array("VenueID"=>$venue_code,"VenueName"=>$venue_name,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time,"PostStatus"=>$post_status,"PPCount"=>$no_pp);
}	
echo json_encode($return);
?>