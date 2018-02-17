<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
 
$emp_code=$_POST['EmpCode'];
$officer_name=$_POST['OfficerName'];
$desg=$_POST['Desg'];
$status=$_POST['Status'];

if($status == 'NEW'){
    $poststat=$_POST['PostStat'];
    $gender=$_POST['Gender'];
    $dob=$_POST['Dob'];
    
    $update_personal_query=$mysqli->prepare("UPDATE personnel_new SET officer_name = ?, off_desg = ?, gender = ?, dateofbirth = ?, poststat = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_personal_query->bind_param("ssssss",$officer_name,$desg,$poststat,$gender,$dob,$emp_code) or die(json_encode(array("Status"=>$update_personal_query->error)));
}
else if($status == 'OLD'){
    $update_personal_query=$mysqli->prepare("UPDATE personnel SET officer_name = ?, off_desg = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$update_personal_query->bind_param("sss",$officer_name,$desg,$emp_code) or die(json_encode(array("Status"=>$update_personal_query->error)));
}
$update_personal_query->execute() or die(json_encode(array("Status"=>$update_personal_query->error)));

$update_personal_query->close();

if($status == 'OLD'){
    $update_ppds_personnel_query=$mysqli->prepare("UPDATE ppds.personnel SET officer_name = ?, off_desg = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
    $update_ppds_personnel_query->bind_param("sss",$officer_name,$desg,$emp_code) or die(json_encode(array("Status"=>$update_ppds_personnel_query->error)));
    $update_ppds_personnel_query->execute() or die(json_encode(array("Status"=>$update_ppds_personnel_query->error)));
    $update_ppds_personnel_query->close();
    
     $update_ppds_personnela_query=$mysqli->prepare("UPDATE ppds.personnela SET officer_name = ?, off_desg = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
    $update_ppds_personnela_query->bind_param("sss",$officer_name,$desg,$emp_code) or die(json_encode(array("Status"=>$update_ppds_personnela_query->error)));
    $update_ppds_personnela_query->execute() or die(json_encode(array("Status"=>$update_ppds_personnela_query->error)));
    $update_ppds_personnela_query->close();
}
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>