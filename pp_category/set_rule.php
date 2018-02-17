<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv=$_POST['subdiv'];
$govt=$_POST['govt'];
$officecd=$_POST['officecd'];
$basic_pay=explode(';',$_POST['basic_pay']);
$grade_pay=explode(';',$_POST['grade_pay']);
$qualification=$_POST['qualification'];
$not_qualification=$_POST['not_qualification'];
$desg=$_POST['desg'];
$not_designation=$_POST['not_designation'];
$gender=$_POST['gender'];
$age=$_POST['age'];
$remarks=$_POST['remarks'];
$not_remarks=$_POST['not_remarks'];
$post_stat_from=$_POST['post_stat_from'];
$post_stat_to=$_POST['post_stat_to'];

$govt_clause='';
for($i = 0; $i < count($govt); $i++){
	if($govt[$i] != 'ALL')
		$govt_clause.="'".$govt[$i]."',";
	else{
		$govt_clause='ALL';
		break;
	}
}

$govt_clause=rtrim($govt_clause,',');

$officecd_clause='';
for($i = 0; $i < count($officecd); $i++){
	if($officecd[$i] != 'ALL')
		$officecd_clause.="'".$officecd[$i]."',";
	else{
		$officecd_clause='ALL';
		break;
	}
}

$officecd_clause=rtrim($officecd_clause,',');

if(strlen($officecd_clause) > 200)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Maximum Fifteen (15) Offices can be selected at One Time")));

$qualification_clause='';
for($i = 0; $i < count($qualification); $i++){
	if($qualification[$i] != 'ALL')
		$qualification_clause.="'".$qualification[$i]."',";
	else{
		$qualification_clause='ALL';
		break;
	}
}

$qualification_clause=rtrim($qualification_clause,',');
if(strlen($qualification_clause) > 50)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Qualification Selection is too long")));

if($not_qualification == 1 && $qualification_clause == 'ALL')
	die(json_encode(array("Status"=>"Error in Qulification Selection!!!")));
	
$desg_clause='';
for($i = 0; $i < count($desg); $i++){
	if($desg[$i] != 'ALL')
		$desg_clause.="'".$desg[$i]."',";
	else{
		$desg_clause='ALL';
		break;
	}
}

$desg_clause=rtrim($desg_clause,',');
if(strlen($desg_clause) > 200)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Designation Selection is too long")));

if($not_designation == 1 && $desg_clause == 'ALL')
	die(json_encode(array("Status"=>"Error in Designation Selection!!!")));

$remarks_clause='';
for($i = 0; $i < count($remarks); $i++){
	if($remarks[$i] != 'ALL')
		$remarks_clause.="'".$remarks[$i]."',";
	else{
		$remarks_clause='ALL';
		break;
	}
}

$remarks_clause=rtrim($remarks_clause,',');
if(strlen($remarks_clause) > 50)
	die(json_encode(array("Status"=>"Error in Saving Rule !!! Remarks Selection is too long")));

if($not_remarks == 1 && $remarks_clause == 'ALL')
	die(json_encode(array("Status"=>"Error in Remarks Selection!!!")));
	
$basic_pay_clause=$basic_pay[0].'-'.$basic_pay[1];
$grade_pay_clause=$grade_pay[0].'-'.$grade_pay[1];

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
echo json_encode(array("Status"=>"Rule Saved Successfully"));
?>