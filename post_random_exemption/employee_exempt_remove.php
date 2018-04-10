<?php
session_start();
$userid=$_SESSION['UserID'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
//die(array("Status"=>"Fail")); 
$personcd=$_POST['personcd'];

$employee_exempt_remove_query=$mysqli->prepare("DELETE FROM personnel_exempt_post_random WHERE personcd = ? AND UserID = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$employee_exempt_remove_query->bind_param("ss",$personcd,$userid) or die(json_encode(array("Status"=>$employee_exempt_remove_query->error)));

$employee_exempt_remove_query->execute() or die(json_encode(array("Status"=>$employee_exempt_remove_query->error)));

$employee_exempt_remove_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>
