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
	die(json_encode(array()));

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
	die(json_encode(array()));

if($not_qualification == 1 && $qualification_clause == 'ALL')
	die(json_encode(array()));
	
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
	die(json_encode(array()));

if($not_designation == 1 && $desg_clause == 'ALL')
	die(json_encode(array()));
	
$clause="personnel.personcd != ''";
$clause.=" AND personnel.basic_pay BETWEEN $basic_pay[0] AND $basic_pay[1]";
$clause.=" AND personnel.grade_pay BETWEEN $grade_pay[0] AND $grade_pay[1]";

if($qualification_clause != 'ALL' && $not_qualification == 0)
	$clause.=" AND personnel.qualificationcd IN ($qualification_clause)";
if($qualification_clause != 'ALL' && $not_qualification == 1)
	$clause.=" AND personnel.qualificationcd NOT IN ($qualification_clause)";
if($desg_clause != 'ALL' && $not_designation == 0)
	$clause.=" AND personnel.off_desg IN ($desg_clause)";
if($desg_clause != 'ALL' && $not_designation == 1)
	$clause.=" AND personnel.off_desg NOT IN ($desg_clause)";
if($gender !='ALL')
	$clause.=" AND personnel.gender='".$gender."'";
if($subdiv != 'ALL')
	$clause.=" AND personnel.subdivisioncd='".$subdiv."'";
if($govt_clause != 'ALL')
	$clause.=" AND office.govt IN ($govt_clause)";
if($officecd_clause != 'ALL')
	$clause.=" AND office.officecd IN ($officecd_clause)";

$clause.=" AND DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(personnel.dateofbirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(personnel.dateofbirth, '00-%m-%d')) < 60";
	
$remarks_query="SELECT remarks.remarks_cd AS RemarksCode, remarks.remarks AS RemarksName, COUNT(*) AS PPCount FROM (personnel INNER JOIN office ON personnel.officecd=office.officecd) INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd WHERE $clause GROUP BY remarks.remarks_cd, remarks.remarks ORDER BY remarks.remarks_cd";

$remarks_result=mysql_query($remarks_query,$DBLink) or die(json_encode(array("status"=>mysql_error())));
$return=array();
while($row=mysql_fetch_assoc($remarks_result))
{
	$return[]=$row;
}	

echo json_encode($return);
?>