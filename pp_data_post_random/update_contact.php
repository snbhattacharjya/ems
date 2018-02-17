<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
 
$emp_code=$_POST['EmpCode'];
$email=$_POST['Email'];
$phone=$_POST['Phone'];
$mobile=$_POST['Mobile'];
$status=$_POST['Status'];

if($status == 'NEW'){
    $update_contact_query=$mysqli->prepare("UPDATE personnel_new SET email = ?, resi_no = ?, mob_no = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
}
else if($status == 'OLD'){
    $update_contact_query=$mysqli->prepare("UPDATE personnel SET email = ?, resi_no = ?, mob_no = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
}

$update_contact_query->bind_param("ssss",$email,$phone,$mobile,$emp_code) or die(json_encode(array("Status"=>$update_contact_query->error)));

$update_contact_query->execute() or die(json_encode(array("Status"=>$update_contact_query->error)));

$update_contact_query->close();
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>