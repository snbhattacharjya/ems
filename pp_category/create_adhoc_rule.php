<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv="ALL";
$basic_pay=$_POST['BasicPay'];
$grade_pay=$_POST['GradePay'];
$qualification=$_POST['Qualification'];
$remarks=$_POST['Remarks'];
$desg=$_POST['Designation'];
$gender=$_POST['Gender'];
$age="< 60";
$post_stat_from=$_POST['FromPostStat'];
$post_stat_to=$_POST['ToPostStat'];

$govt_clause='ALL';

$officecd_clause='ALL';

$qualification_query=$mysqli->prepare("SELECT qualificationcd FROM qualification WHERE qualification = ?") or die(json_encode(array("Status"=>$mysqli->error)));
$qualification_query->bind_param("s",$qualification) or die(json_encode(array("Status"=>$qualification_query->error)));
$qualification_query->execute() or die(json_encode(array("Status"=>$qualification_query->error)));
$qualification_query->bind_result($qualification) or die(json_encode(array("Status"=>$qualification_query->error)));
$qualification_query->fetch() or die(json_encode(array("Status"=>$qualification_query->error)));
$qualification_query->close();

$qualification_clause="'".$qualification."'";
$not_qualification=0; 
if(strlen($qualification_clause) > 50)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Qualification Selection is too long")));

$desg_clause="'".$desg."'";
$not_designation=0;
if(strlen($desg_clause) > 200)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Designation Selection is too long")));

$remarks_clause="'".$remarks."'";
$not_remarks=0;
if(strlen($remarks_clause) > 50)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Remarks Selection is too long")));
		
$basic_pay_clause=str_replace('-',' - ',$basic_pay);
$grade_pay_clause=str_replace('-',' - ',$grade_pay);

$rule_id_query=$mysqli->prepare("SELECT MAX(RuleID) FROM pp_post_rules") or die(json_encode(array("Status"=>$mysqli->error)));
$rule_id_query->execute() or die(json_encode(array("Status"=>$rule_id_query->error)));
$rule_id_query->bind_result($rule_id) or die(json_encode(array("Status"=>$rule_id_query->error)));
$rule_id_query->fetch() or die(json_encode(array("Status"=>$rule_id_query->error)));
$rule_id_query->close();

if(is_null($rule_id))
	$rule_id=1;
else
	$rule_id = $rule_id + 1;

$set_rule_query=$mysqli->prepare("INSERT INTO pp_post_rules (RuleID, Subdivision, OfficeCategory, Office, BasicPay, GradePay, Qualification, NotQualification, Designation, NotDesignation, Remarks, NotRemarks, Gender, Age, PostStatFrom, PostStatTo) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
$set_rule_query->bind_param("isssssssssssssss",$rule_id,$subdiv,$govt_clause,$officecd_clause,$basic_pay_clause,$grade_pay_clause,$qualification_clause,$not_qualification,$desg_clause,$not_designation,$remarks_clause,$not_remarks,$gender,$age,$post_stat_from,$post_stat_to) or die(json_encode(array("Status"=>$set_rule_query->error)));
$set_rule_query->execute() or die(json_encode(array("Status"=>$set_rule_query->error)));
$set_rule_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success","RuleID"=>$rule_id));
?>