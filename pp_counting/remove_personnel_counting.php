<?php
session_start();

$personcd=$_POST['EmpCode'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$emp_office_query=$mysqli->prepare("DELETE FROM personnel_counting WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
$emp_office_query->bind_param("s",$personcd) or die(json_encode(array("Status"=>$emp_office_query->error)));
$emp_office_query->execute() or die(json_encode(array("Status"=>$emp_office_query->error)));

$emp_office_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>