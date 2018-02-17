<?php
session_start();
$userid=$_SESSION['UserID'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

//die(array("Status"=>"Fail"));
$personcd=$_POST['personcd'];
$training_type='01';
	
$mark_training1_absent_query=$mysqli->prepare("INSERT INTO personnel_training_absent (personcd, training_type, training_venue, training_date, training_time, UserID) (SELECT personnel.personcd, ?, training_venue.venue_cd, training_schedule.training_dt, training_schedule.training_time, ? FROM (personnel INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd WHERE personnel.personcd = ?)") or die(json_encode(array("Status"=>$mysqli->error)));

$mark_training1_absent_query->bind_param("sss",$training_type,$userid,$personcd) or die(json_encode(array("Status"=>$mark_training1_absent_query->error)));

$mark_training1_absent_query->execute() or die(json_encode(array("Status"=>$mark_training1_absent_query->error)));

$mark_training1_absent_query->close();
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>