<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

$emp_code=$_POST['EmpCode'];
$scale=$_POST['Scale'];
$basic_pay=$_POST['BasicPay'];
$grade_pay=$_POST['GradePay'];
$emp_group=$_POST['EmpGroup'];

$update_salary_query=$mysqli->prepare("UPDATE personnel SET scale = ?, basic_pay = ?, grade_pay = ?, emp_group = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_salary_query->bind_param("siiss",$scale,$basic_pay,$grade_pay,$emp_group,$emp_code) or die(json_encode(array("Status"=>$update_salary_query->error)));

$update_salary_query->execute() or die(json_encode(array("Status"=>$update_salary_query->error)));

$update_salary_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>
