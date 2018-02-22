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
$status=$_POST['Status'];

if($status == 'NEW'){
    $update_contact_query=$mysqli->prepare("UPDATE personnel_new SET present_addr1 = ?, present_addr2 = ?, perm_addr1 = ?, perm_addr2 = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
}
else if ($status == 'OLD'){
    $update_contact_query=$mysqli->prepare("UPDATE personnel SET present_addr1 = ?, present_addr2 = ?, perm_addr1 = ?, perm_addr2 = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
}
$update_contact_query->bind_param("sssss",$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$emp_code) or die(json_encode(array("Status"=>$update_contact_query->error)));

$update_contact_query->execute() or die(json_encode(array("Status"=>$update_contact_query->error)));

$update_contact_query->close();

if($status == 'OLD'){
    $update_ppds_personnel_query=$mysqli->prepare("UPDATE ppds.personnel SET present_addr1 = ?, present_addr2 = ?, perm_addr1 = ?, perm_addr2 = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
    $update_ppds_personnel_query->bind_param("sssss",$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$emp_code) or die(json_encode(array("Status"=>$update_ppds_personnel_query->error)));
    $update_ppds_personnel_query->execute() or die(json_encode(array("Status"=>$update_ppds_personnel_query->error)));
    $update_ppds_personnel_query->close();
    
     $update_ppds_personnela_query=$mysqli->prepare("UPDATE ppds.personnela SET present_addr1 = ?, present_addr2 = ?, perm_addr1 = ?, perm_addr2 = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
    $update_ppds_personnela_query->bind_param("sssss",$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$emp_code) or die(json_encode(array("Status"=>$update_ppds_personnela_query->error)));
    $update_ppds_personnela_query->execute() or die(json_encode(array("Status"=>$update_ppds_personnela_query->error)));
    $update_ppds_personnela_query->close();
}
$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>