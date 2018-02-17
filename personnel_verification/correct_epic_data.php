<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
 
$emp_code=$_POST['EmpCode'];
$EpicNo=$_POST['EpicNo'];
$PartNo=$_POST['PartNo'];
$SlNo=$_POST['SlNo'];
$AcNo=$_POST['AcNo'];
	
$update_epic_query=$mysqli->prepare("UPDATE personnel SET epic = ?, partno = ?, slno = ?, acno = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_epic_query->bind_param("sssss",$EpicNo,$PartNo,$SlNo,$AcNo,$emp_code) or die(json_encode(array("Status"=>$update_epic_query->error)));

$update_epic_query->execute() or die(json_encode(array("Status"=>$update_epic_query->error)));

$update_epic_query->close();
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>