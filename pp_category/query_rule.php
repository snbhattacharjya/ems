<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
$rule_id=$_POST['RuleID'];

$rule_query=$mysqli->prepare("SELECT Subdivision, OfficeCategory, Office, BasicPay, GradePay, Qualification, NotQualification, Designation, NotDesignation, Remarks, NotRemarks, Gender, Age, PostStatFrom, PostStatTo FROM pp_post_rules WHERE RuleID = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$rule_query->bind_param("i",$rule_id) or die(json_encode(array("Status"=>$rule_query->error)));

$rule_query->execute() or die(json_encode(array("Status"=>$rule_query->error)));

$rule_query->bind_result($subdiv,$govt,$officecd,$basic_pay,$grade_pay,$qualification,$not_qualification,$desg,$not_designation,$remarks,$not_remarks,$gender,$age,$post_stat_from,$post_stat_to) or die(json_encode(array("Status"=>$rule_query->error)));

$rule_query->fetch() or die(json_encode(array("Status"=>$rule_query->error)));

$rule_query->close();
$mysqli->close();

$basic_pay=explode("-",$basic_pay);
$grade_pay=explode("-",$grade_pay);

$clause="personnel.personcd != ''";
$clause.=" AND personnel.basic_pay BETWEEN $basic_pay[0] AND $basic_pay[1]";
$clause.=" AND personnel.grade_pay BETWEEN $grade_pay[0] AND $grade_pay[1]";

if($qualification != 'ALL' && $not_qualification == 0)
	$clause.=" AND personnel.qualificationcd IN ($qualification)";
if($qualification != 'ALL' && $not_qualification == 1)
	$clause.=" AND personnel.qualificationcd NOT IN ($qualification)";
if($desg != 'ALL' && $not_designation == 0)
	$clause.=" AND personnel.off_desg IN ($desg)";
if($desg != 'ALL' && $not_designation == 1)
	$clause.=" AND personnel.off_desg NOT IN ($desg)";
if($remarks != 'ALL' && $not_remarks == 0)
	$clause.=" AND personnel.remarks IN ($remarks)";
if($remarks != 'ALL' && $not_remarks == 1)
	$clause.=" AND personnel.remarks NOT IN ($remarks)";
if($gender !='ALL')
	$clause.=" AND personnel.gender='".$gender."'";
if($subdiv != 'ALL')
	$clause.=" AND personnel.subdivisioncd='".$subdiv."'";
if($govt != 'ALL')
	$clause.=" AND office.govt IN ($govt)";
if($officecd != 'ALL')
	$clause.=" AND office.officecd IN ($officecd)";
if($post_stat_from != 'NA')
	$clause.="AND personnel.poststat='".$post_stat_from."'";
else
	$clause.=" AND personnel.poststat=''";

$clause.=" AND DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(personnel.dateofbirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(personnel.dateofbirth, '00-%m-%d')) < 60";

$rule_pp_query="SELECT COUNT(personnel.personcd) AS PPCount FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE $clause"; //die(json_encode(array("Status"=>$rule_pp_query)));
$rule_pp_result=mysqli_query($DBLink,$rule_pp_query) or die(json_encode(array("Status"=>mysqli_error($DBLink))));
$rule_pp_result=mysqli_fetch_assoc($rule_pp_result)or die(json_encode(array("Status"=>"Error in fetch Record Count")));

echo json_encode(array("Status"=>$rule_pp_result['PPCount']));
?>
