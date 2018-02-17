<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
 
$emp_code=$_POST['EmpCode'];
$Qualification=$_POST['Qualification'];
$Language=$_POST['Language'];
$Remarks=$_POST['Remarks'];
$WorkingStatus=$_POST['WorkingStatus'];
$status=$_POST['Status'];

if($status == 'NEW'){
$update_additional_query=$mysqli->prepare("UPDATE personnel SET qualificationcd = ?, languagecd = ?, remarks = ?, workingstatus = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_additional_query->bind_param("sssss",$Qualification,$Language,$Remarks,$WorkingStatus,$emp_code) or die(json_encode(array("Status"=>$update_additional_query->error)));

$update_additional_query->execute() or die(json_encode(array("Status"=>$update_additional_query->error)));

$update_additional_query->close();
$mysqli->close();
}
echo json_encode(array("Status"=>"Success"));
?>