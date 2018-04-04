<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$subdiv=$_POST['subdiv'];
$govt=$_POST['govt'];
$officecd=$_POST['officecd'];

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

$clause="personnel.personcd != ''";

if($subdiv != 'ALL')
	$clause=$clause." AND personnel.subdivisioncd='".$subdiv."'";
if($govt_clause != 'ALL')
	$clause=$clause." AND office.govt IN ($govt_clause)";
if($officecd_clause != 'ALL')
	$clause=$clause." AND office.officecd IN ($officecd_clause)";

$pay_query="SELECT MAX(basic_pay) AS MaxBasic, MAX(grade_pay) AS MaxGrade, MIN(basic_pay) AS MinBasic, MIN(grade_pay) AS MinGrade FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE $clause";

$pay_result=mysqli_query($DBLink,$pay_query) or die(mysqli_error($DBlink));
//$return=array();
$row=mysqli_fetch_assoc($pay_result);

//$return[]=$row;

echo json_encode($row);
?>
