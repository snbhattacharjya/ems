<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

$emp_code=$_POST['EmpCode'];
$present_addr1=$_POST['PresentAddr1'];
$present_addr2=$_POST['PresentAddr2'];
$perm_addr1=$_POST['PermAddr1'];
$perm_addr2=$_POST['PermAddr2'];
$email=$_POST['Email'];
$phone=$_POST['Phone'];
$mobile=$_POST['Mobile'];


$update_contact_query=$mysqli->prepare("UPDATE personnel SET present_addr1 = ?, present_addr2 = ?, perm_addr1 = ?, perm_addr2 = ?, email = ?, resi_no = ?, mob_no = ?, posted_date = CURRENT_TIMESTAMP WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_contact_query->bind_param("ssssssss",$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$email,$phone,$mobile,$emp_code) or die(json_encode(array("Status"=>$update_contact_query->error)));

$update_contact_query->execute() or die(json_encode(array("Status"=>$update_contact_query->error)));

$update_contact_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>
