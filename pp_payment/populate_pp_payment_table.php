<?php
session_start();
if(!isset($_SESSION['UserID']))
    die(json_encode(array("Status"=>"Login Expired!. Please Login again to continue")));
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$pr_party=$_POST['pr_party'];
$pr_reserve=$_POST['pr_reserve'];

$p1_party=$_POST['p1_party'];
$p1_reserve=$_POST['p1_reserve'];

$p2_party=$_POST['p2_party'];
$p2_reserve=$_POST['p2_reserve'];

$p3_party=$_POST['p3_party'];
$p3_reserve=$_POST['p3_reserve'];

$pp_payment_query=$mysqli->prepare("DELETE FROM personnel_payment") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->close();

$rows=0;

$poststat="PR";
$booked="P";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$pr_party,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="PR";
$booked="R";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$pr_reserve,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="P1";
$booked="P";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p1_party,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="P1";
$booked="R";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p1_reserve,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="P2";
$booked="P";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p2_party,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="P2";
$booked="R";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p2_reserve,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="PA";
$booked="P";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p2_party,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="PA";
$booked="R";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p2_reserve,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="PB";
$booked="P";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p2_party,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="PB";
$booked="R";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p2_reserve,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="P3";
$booked="P";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p3_party,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

$poststat="P3";
$booked="R";
$pp_payment_query=$mysqli->prepare("INSERT INTO personnel_payment(personcd, officer_name, poststat, mob_no, bank_name, branch_name, ifsc, bank_acc_no, pay_amount) (SELECT personnel.personcd, personnel.officer_name, personnel.poststat, personnel.mob_no, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, ? FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE personnel.booked = ? AND personnel.poststat = ?)") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_payment_query->bind_param("iss",$p3_reserve,$booked,$poststat) or die(json_encode(array("Status"=>$pp_payment_query->error)));
$pp_payment_query->execute() or die(json_encode(array("Status"=>$pp_payment_query->error)));
$rows+=$pp_payment_query->affected_rows;
$pp_payment_query->close();

echo json_encode(array("Status"=>"Success","RecordCount"=>$rows));
?>