<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

$emp_code=$_POST['EmpCode'];
$BlockMuniTemp=$_POST['BlockMuniTemp'];
$BlockMuniPerm=$_POST['BlockMuniPerm'];
$BlockMuniOff=$_POST['BlockMuniOff'];

$update_blockmuni_query=$mysqli->prepare("UPDATE personnel SET blockmuni_temp = ?, blockmuni_perm = ?, blockmuni_off = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_blockmuni_query->bind_param("ssss",$BlockMuniTemp,$BlockMuniPerm,$BlockMuniOff,$emp_code) or die(json_encode(array("Status"=>$update_blockmuni_query->error)));

$update_blockmuni_query->execute() or die(json_encode(array("Status"=>$update_blockmuni_query->error)));

$update_blockmuni_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>
