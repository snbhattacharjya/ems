<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$venue_assembly=$_POST['venue_assembly'];
$venue_name=$_POST['venue_name'];
$address1=$_POST['address1'];
$address2=$_POST['address2'];
$rooms=$_POST['rooms'];
$capacity=$_POST['capacity'];

for($i = 1; $i <= $rooms; $i++){
    $max_venue_query=$mysqli->prepare("SELECT MAX(CONVERT(MID(venue_cd,-2), UNSIGNED INTEGER)) FROM training_venue WHERE subdivisioncd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
    $max_venue_query->bind_param("s",$subdiv) or die(json_encode(array("Status"=>$max_venue_query->error)));
    $max_venue_query->execute() or die(json_encode(array("Status"=>$max_venue_query->error)));
    $max_venue_query->bind_result($max_id) or die(json_encode(array("Status"=>$$max_venue_query->error)));
    $max_venue_query->fetch() or die(json_encode(array("Status"=>$max_venue_query->error)));
    $max_venue_query->close();
    if(isset($max_id)){
        $venue_id=$subdiv.str_pad(($max_id+1), 2, '0', STR_PAD_LEFT);
    }
    else{
        $venue_id=$subdiv.'01';
    }
    
    $room_name=$venue_name.", Room No. - ".$i;
    $add_venue_query=$mysqli->prepare("INSERT INTO training_venue (venue_cd, subdivisioncd, venuename, venue_base_name, venueaddress1, venueaddress2, maximumcapacity, assemblycd) VALUES (?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $add_venue_query->bind_param("ssssssis",$venue_id,$subdiv,$room_name,$venue_name,$address1,$address2,$capacity,$venue_assembly) or die(json_encode(array("Status"=>$add_venue_query->error)));
    $add_venue_query->execute() or die(json_encode(array("Status"=>$add_venue_query->error)));
    $add_venue_query->close();
}

echo json_encode(array("Status"=>"Success"));
?>

