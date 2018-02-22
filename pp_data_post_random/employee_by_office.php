<?php
session_start();

$office=$_POST['officecd'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$emp_office_query="SELECT personcd AS PersonCode, officer_name AS OfficerName, off_desg AS Desg, gender AS Gender, dateofbirth AS DOB, present_addr1 AS PresentAddress1, present_addr2 AS PresentAddress2, perm_addr1 AS PermanentAddress1, perm_addr2 AS PermanentAddress2, email AS Email, resi_no AS Phone, mob_no AS Mobile, scale AS Scale, basic_pay AS BasicPay, grade_pay AS GradePay, qualificationcd AS Qualification, workingstatus AS WorkingStatus, languagecd AS Language, remarks AS Remarks, bank_cd AS Bank, branchname AS Branch, branchcd AS IFSC, bank_acc_no AS AccountNo, epic AS EPIC, partno AS PartNo, slno AS SlNo, acno AS ACNO, assembly_temp AS PresentAssembly, assembly_perm AS PermanentAssembly, assembly_off AS PostingAssembly, poststat AS PostStat, 'OLD' AS Status FROM personnel WHERE officecd='$office' ORDER BY personcd";

$emp_office_result=mysql_query($emp_office_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($emp_office_result))
{
	$return[]=$row;
}
/*
$emp_new_office_query="SELECT personcd AS PersonCode, officer_name AS OfficerName, off_desg AS Desg, gender AS Gender, dateofbirth AS DOB, present_addr1 AS PresentAddress1, present_addr2 AS PresentAddress2, perm_addr1 AS PermanentAddress1, perm_addr2 AS PermanentAddress2, email AS Email, resi_no AS Phone, mob_no AS Mobile, scale AS Scale, basic_pay AS BasicPay, grade_pay AS GradePay, qualificationcd AS Qualification, workingstatus AS WorkingStatus, languagecd AS Language, remarks AS Remarks, bank_cd AS Bank, branchname AS Branch, branchcd AS IFSC, bank_acc_no AS AccountNo, epic AS EPIC, partno AS PartNo, slno AS SlNo, acno AS ACNO, assembly_temp AS PresentAssembly, assembly_perm AS PermanentAssembly, assembly_off AS PostingAssembly, poststat AS PostStat, 'NEW' AS Status FROM personnel_new WHERE officecd='$office' ORDER BY personcd";

$emp_new_office_result=mysql_query($emp_new_office_query,$DBLink) or die(mysql_error());

while($row=mysql_fetch_assoc($emp_new_office_result))
{
	$return[]=$row;
}*/	
echo json_encode($return);
?>