<?php
session_start();
$userid=$_SESSION['UserID'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

//die(array("Status"=>"Fail"));
$personcd=$_POST['personcd'];
$reason=$_POST['reason'];
	
$mark_pp_exempt_query=$mysqli->prepare("INSERT INTO personnel_exempt_post_random (personcd, reason, booked, UserID) (SELECT personcd, ?, booked, ? FROM personnel WHERE personcd = ?)") or die(json_encode(array("Status"=>$mysqli->error)));

$mark_pp_exempt_query->bind_param("sss",$reason,$userid,$personcd) or die(json_encode(array("Status"=>$mark_pp_exempt_query->error)));

$mark_pp_exempt_query->execute() or die(json_encode(array("Status"=>$mark_pp_exempt_query->error)));

$mark_pp_exempt_query->close();
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>