<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
 
$emp_code=$_POST['EmpCode'];
$bank_cd=$_POST['BankCd'];
$branchname=$_POST['BranchName'];
$branchcd=$_POST['BranchCd'];
$bank_acc_no=$_POST['BankAccNo'];

//Checking Unique bank_acc_no
$bank_acc_query=$mysqli->prepare("SELECT COUNT(*) FROM personnel WHERE bank_acc_no = ? AND personcd != ?") or die(json_encode(array("Status"=>$mysqli->error)));
$bank_acc_query->bind_param("ss",$bank_acc_no,$emp_code) or die(json_encode(array("Status"=>$mysqli->error)));
$bank_acc_query->execute() or die(json_encode(array("Status"=>$bank_acc_query->error)));
$bank_acc_query->bind_result($check_bank_acc) or die(json_encode(array("Status"=>$bank_acc_query->error)));
$bank_acc_query->fetch() or die(json_encode(array("Status"=>$bank_acc_query->error)));
$bank_acc_query->close();

if($check_bank_acc > 0){
    die(json_encode(array("Status"=>"Fail")));
}
$update_bank_query=$mysqli->prepare("UPDATE personnel SET bank_cd = ?, branchname = ?, branchcd = ?, bank_acc_no = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_bank_query->bind_param("sssss",$bank_cd,$branchname,$branchcd,$bank_acc_no,$emp_code) or die(json_encode(array("Status"=>$update_bank_query->error)));

$update_bank_query->execute() or die(json_encode(array("Status"=>$update_bank_query->error)));

$update_bank_query->close();
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>