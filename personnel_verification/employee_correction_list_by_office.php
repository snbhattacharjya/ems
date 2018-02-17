<?php
session_start();
$officecd=$_POST['officecd'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
//die("SELECT personcd, officer_name, off_desg, mob_no, bank_cd, branchname, branchcd, bank_acc_no, epic, acno, partno, slno FROM personnel WHERE officecd = $officecd ORDER BY personcd");
$emp_office_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, mob_no, bank_cd, branchname, branchcd, bank_acc_no, epic, acno, partno, slno FROM personnel WHERE officecd = ? ORDER BY personcd") or die($mysqli->error);
$emp_office_query->bind_param("s",$officecd) or die($emp_office_query->error);
$emp_office_query->execute() or die($emp_office_query->error);
$emp_office_query->bind_result($personcd,$officer_name,$off_desg,$mob_no,$bank_cd,$branchname,$branchcd,$bank_acc_no,$epic,$acno,$partno,$slno) or die($emp_office_query->error);

$return=array();
while($emp_office_query->fetch() )
{
    $return[]=array("PersonCode"=>$personcd,"OfficerName"=>$officer_name,"Desg"=>$off_desg,"Mobile"=>$mob_no,"Bank"=>$bank_cd,"Branch"=>$branchname,"IFSC"=>$branchcd,"AccountNo"=>$bank_acc_no,"EPIC"=>$epic,"ACNO"=>$acno,"PARTNO"=>$partno,"SLNO"=>$slno);
}	
$emp_office_query->close();
$mysqli->close();
echo json_encode($return);
?>