<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

$emp_code=$_POST['EmpCode'];
$officer_name=$_POST['OfficerName'];
$desg=$_POST['Desg'];
$poststat=$_POST['PostStat'];
$gender=$_POST['Gender'];

$update_personal_query=$mysqli->prepare("UPDATE personnel_counting SET officer_name = ?, off_desg = ?, gender = ?, poststat = ?, posted_date = CURRENT_TIMESTAMP WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_personal_query->bind_param("sssss",$officer_name,$desg,$gender,$poststat,$emp_code) or die(json_encode(array("Status"=>$update_personal_query->error)));

$update_personal_query->execute() or die(json_encode(array("Status"=>$update_personal_query->error)));

$update_personal_query->close();


$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>