<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$venue_capacity=$_POST['venue_capacity'];
$venue_cd=$_POST['venue_cd'];
   
$update_venue_query=$mysqli->prepare("UPDATE training_venue SET maximumcapacity = ? WHERE venue_cd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
$update_venue_query->bind_param("is",$venue_capacity,$venue_cd) or die(json_encode(array("Status"=>$update_venue_query->error)));
$update_venue_query->execute() or die(json_encode(array("Status"=>$update_venue_query->error)));
$update_venue_query->close();

echo json_encode(array("Status"=>"Success"));
?>

