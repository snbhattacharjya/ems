<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
/*
$personcd = mysqli_real_escape_string(htmlspecialchars($_POST['personcd']));
$officecd = mysqli_real_escape_string(htmlspecialchars($_POST['officecd']));
$officer_name = mysqli_real_escape_string(htmlspecialchars($_POST['officer_name']));
$off_desg = mysqli_real_escape_string(htmlspecialchars($_POST['off_desg']));
$adharno = mysqli_real_escape_string(htmlspecialchars($_POST['adharno']));
$present_addr1 = mysqli_real_escape_string(htmlspecialchars($_POST['present_addr1']));
$present_addr2 = mysqli_real_escape_string(htmlspecialchars($_POST['present_addr2']));
$perm_addr1 = mysqli_real_escape_string(htmlspecialchars($_POST['perm_addr1']));
$perm_addr2 = mysqli_real_escape_string(htmlspecialchars($_POST['perm_addr2']));
$dateofbirth = mysqli_real_escape_string(htmlspecialchars($_POST['dateofbirth']));
$gender = mysqli_real_escape_string(htmlspecialchars($_POST['gender']));
$scale = mysqli_real_escape_string(htmlspecialchars($_POST['scale']));
$basic_pay = mysqli_real_escape_string(htmlspecialchars($_POST['basic_pay']));
$grade_pay = mysqli_real_escape_string(htmlspecialchars($_POST['grade_pay']));
$workingstatus = mysqli_real_escape_string(htmlspecialchars($_POST['workingstatus']));
$email = mysqli_real_escape_string(htmlspecialchars($_POST['email']));
$resi_no = mysqli_real_escape_string(htmlspecialchars($_POST['resi_no']));
$mob_no = mysqli_real_escape_string(htmlspecialchars($_POST['mob_no']));
$qualificationcd = mysqli_real_escape_string(htmlspecialchars($_POST['qualificationcd']));
$languagecd = mysqli_real_escape_string(htmlspecialchars($_POST['languagecd']));
$epic = mysqli_real_escape_string(htmlspecialchars($_POST['epic']));
$acno = mysqli_real_escape_string(htmlspecialchars($_POST['acno']));
$slno = mysqli_real_escape_string(htmlspecialchars($_POST['slno']));
$partno = mysqli_real_escape_string(htmlspecialchars($_POST['partno']));
$poststat = mysqli_real_escape_string(htmlspecialchars($_POST['poststat']));
$assembly_temp = mysqli_real_escape_string(htmlspecialchars($_POST['assembly_temp']));
$assembly_off = mysqli_real_escape_string(htmlspecialchars($_POST['assembly_off']));
$assembly_perm = mysqli_real_escape_string(htmlspecialchars($_POST['assembly_perm']));
$districtcd = mysqli_real_escape_string(htmlspecialchars($_POST['districtcd']));
$subdivisioncd = mysqli_real_escape_string(htmlspecialchars($_POST['subdivisioncd']));
$bank_acc_no = mysqli_real_escape_string(htmlspecialchars($_POST['bank_acc_no']));
$bank_cd = mysqli_real_escape_string(htmlspecialchars($_POST['bank_cd']));
$branchname = mysqli_real_escape_string(htmlspecialchars($_POST['branchname']));
$branchcd = mysqli_real_escape_string(htmlspecialchars($_POST['branchcd']));
$remarks = mysqli_real_escape_string(htmlspecialchars($_POST['remarks']));
$pgroup = mysqli_real_escape_string(htmlspecialchars($_POST['pgroup']));
$upload_file = mysqli_real_escape_string(htmlspecialchars($_POST['upload_file']));
$usercode = mysqli_real_escape_string(htmlspecialchars($_POST['usercode']));
$posted_date = mysqli_real_escape_string(htmlspecialchars($_POST['posted_date']));
$f_cd = mysqli_real_escape_string(htmlspecialchars($_POST['f_cd']));
$image = mysqli_real_escape_string(htmlspecialchars($_POST['image']));
$signature = mysqli_real_escape_string(htmlspecialchars($_POST['signature']));

$personnel_export_query=$mysqli->prepare("INSERT INTO personnel_web (personcd,officecd,officer_name,off_desg,adharno,present_addr1,present_addr2,perm_addr1,perm_addr2,dateofbirth,gender,scale,basic_pay ,grade_pay,workingstatus,email,resi_no,mob_no,qualificationcd,languagecd,epic,acno,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,districtcd,subdivisioncd,bank_acc_no,bank_cd,branchname,branchcd,remarks,pgroup,upload_file,usercode,posted_date,f_cd,image,signature) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die($mysqli->error);

$personnel_export_query->bind_param("ssssssssssssiisssssssssssssssssssssssisiss",$personcd,$officecd,$officer_name,$off_desg,$adharno,$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$dateofbirth,$gender,$scale,$basic_pay,$grade_pay,$workingstatus,$email,$resi_no,$mob_no,$qualificationcd,$languagecd,$epic,$acno,$slno,$partno,$poststat,$assembly_temp,$assembly_off,$assembly_perm,$districtcd,$subdivisioncd,$bank_acc_no,$bank_cd,$branchname,$branchcd,$remarks,$pgroup,$upload_file,$usercode,$posted_date,$f_cd,$image,$signature) or die($personnel_export_query->error);
$personnel_export_query->execute() or die($personnel_export_query->error);*/

echo json_encode(array("Status"=>"Success"));
?>
