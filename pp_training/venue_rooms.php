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
    $venue_room_details_query=$mysqli->prepare("SELECT venue_cd, venuename, maximumcapacity FROM training_venue WHERE venue_base_name = ? ORDER BY venue_cd") or die($mysqli->error);
    $venue_room_details_query->bind_param("s",$venue_base_name) or die($venue_room_details_query->error);
}
else{
    $venue_room_details_query=$mysqli->prepare("SELECT venue_cd, venuename, maximumcapacity FROM training_venue WHERE venue_base_name = ? AND subdivisioncd = ? ORDER BY venue_cd") or die($mysqli->error);
    $venue_room_details_query->bind_param("ss",$venue_base_name, $_SESSION['Subdiv']) or die($venue_room_details_query->error);
}

$venue_room_details_query->execute() or die($venue_room_details_query->error);
$venue_room_details_query->bind_result($venue_code,$venue_name,$venue_capacity) or die($venue_room_details_query->error);
$return=array();
while($venue_room_details_query->fetch())
{
	$return[]=array("VenueID"=>$venue_code,"VenueName"=>$venue_name,"VenueCapacity"=>$venue_capacity);
}	
echo json_encode($return);
?>