<?php
session_start();

$personcd=$_POST['EmpCode'];
$poststat=$_POST['PostStat'];

if($poststat == 'CA1'){
    $poststat_ppds = 'P2';
}
else if($poststat == 'CA3'){
    die(json_encode(array("Status"=>"Fail")));
}
else if($poststat == 'CS'){
    $poststat_ppds = 'P1';
}
else if($poststat == 'CMO'){
    $poststat_ppds = 'PR';
}
else{
    die(json_encode(array("Status"=>"Fail")));
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$emp_export_query=$mysqli_countppds->prepare("INSERT INTO personnel_counting (SELECT * FROM ems.personnel_counting WHERE personcd = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$emp_export_query->bind_param("s",$personcd) or die(json_encode(array("Status"=>$emp_export_query->error)));
$emp_export_query->execute() or die(json_encode(array("Status"=>$emp_export_query->error)));
$emp_export_query->close();

$emp_export_query=$mysqli_countppds->prepare("INSERT INTO personnel (SELECT personcd, officecd, officer_name, off_desg, present_addr1, present_addr2, perm_addr1, perm_addr2, dateofbirth, gender, scale, basic_pay, grade_pay, workingstatus, email, resi_no, mob_no, qualificationcd, languagecd, epic, acno, slno, partno, ?, assembly_temp, assembly_off, assembly_perm, districtcd, subdivisioncd, bank_acc_no, bank_cd, '001', branchname, branchcd, remarks, pgroup, upload_file, usercode, posted_date, 1 FROM personnel_counting WHERE personcd = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$emp_export_query->bind_param("ss",$poststat_ppds,$personcd) or die(json_encode(array("Status"=>$emp_export_query->error)));
$emp_export_query->execute() or die(json_encode(array("Status"=>$emp_export_query->error)));
$emp_export_query->close();

$emp_export_query=$mysqli_countppds->prepare("INSERT INTO personnela (personcd, officecd, officer_name, off_desg, present_addr1, present_addr2, perm_addr1, perm_addr2, dateofbirth, gender, scale, basic_pay, grade_pay, workingstatus, email, resi_no, mob_no, qualificationcd, languagecd, epic, acno, slno, partno, poststat, assembly_temp, assembly_off, assembly_perm, districtcd, subdivisioncd, forsubdivision, bank_acc_no, bank_cd, branchcd, remarks, pgroup, upload_file, usercode, posted_date) (SELECT personcd, officecd, officer_name, off_desg, present_addr1, present_addr2, perm_addr1, perm_addr2, dateofbirth, gender, scale, basic_pay, grade_pay, workingstatus, email, resi_no, mob_no, qualificationcd, languagecd, epic, acno, slno, partno, poststat, assembly_temp, assembly_off, assembly_perm, districtcd, subdivisioncd, subdivisioncd, bank_acc_no, bank_cd, '001', remarks, pgroup, upload_file, usercode, posted_date FROM personnel WHERE personcd = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$emp_export_query->bind_param("s",$personcd) or die(json_encode(array("Status"=>$emp_export_query->error)));
$emp_export_query->execute() or die(json_encode(array("Status"=>$emp_export_query->error)));
$emp_export_query->close();

$mysqli_countppds->close();
echo json_encode(array("Status"=>"Success"));
?>