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
	
$mark_pp_exempt_query=$mysqli->prepare("INSERT INTO personnel_exempt_marked (personcd, reason, UserID) VALUES(?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));

$mark_pp_exempt_query->bind_param("sss",$personcd,$reason,$userid) or die(json_encode(array("Status"=>$mark_pp_exempt_query->error)));

$mark_pp_exempt_query->execute() or die(json_encode(array("Status"=>$mark_pp_exempt_query->error)));

$mark_pp_exempt_query->close();
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>