<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
 
$emp_code=$_POST['EmpCode'];
$AssemblyTemp=$_POST['AssemblyTemp'];
$AssemblyPerm=$_POST['AssemblyPerm'];
$AssemblyOff=$_POST['AssemblyOff'];
$status=$_POST['Status'];

if($status == 'NEW'){
$update_assembly_query=$mysqli->prepare("UPDATE personnel_new SET assembly_temp = ?, assembly_perm = ?, assembly_off = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_assembly_query->bind_param("ssss",$AssemblyTemp,$AssemblyPerm,$AssemblyOff,$emp_code) or die(json_encode(array("Status"=>$update_assembly_query->error)));

$update_assembly_query->execute() or die(json_encode(array("Status"=>$update_assembly_query->error)));

$update_assembly_query->close();
$mysqli->close();
}
echo json_encode(array("Status"=>"Success"));
?>