<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$export_office_query=$mysqli->prepare("INSERT INTO ppds.office (SELECT officecd, office_unique_id, officer_desg, office, address1, address2, postoffice, pin, blockormuni_cd, policestn_cd, govt, email, phone, mobile, fax, tot_staff, male_staff, female_staff, assemblycd, pccd, subdivisioncd, districtcd, institutecd, officetype, usercode, posted_date FROM ems.office)") or die(json_encode(array("Status"=>$mysqli->error)));

$export_office_query->execute() or die(json_encode(array("Status"=>$export_office_query->error)));
$office_rows=$export_office_query->affected_rows;
$export_office_query->close();

$export_personnel_query=$mysqli->prepare("INSERT INTO ppds.personnel (SELECT personcd, officecd, officer_name, off_desg, present_addr1, present_addr2, perm_addr1, perm_addr2, dateofbirth, gender, scale, basic_pay, grade_pay, workingstatus, email, resi_no, mob_no, qualificationcd, languagecd, epic, acno, slno, partno, poststat, assembly_temp, assembly_off, assembly_perm, districtcd, subdivisioncd, bank_acc_no, bank_cd, '001', branchname, branchcd, remarks, pgroup, upload_file, usercode, posted_date, 0 FROM ems.personnel WHERE personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_marked))") or die(json_encode(array("Status"=>$mysqli->error)));

$export_personnel_query->execute() or die(json_encode(array("Status"=>$export_personnel_query->error)));
$personnel_rows=$export_personnel_query->affected_rows;
$export_personnel_query->close();

echo json_encode(array("Status"=>"Success","OfficeCount"=>$office_rows,"PersonnelCount"=>$personnel_rows));
?>