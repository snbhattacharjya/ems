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

if($not_qualification == 1 && $qualification_clause == 'ALL')
	die(json_encode(array()));
	
$clause="personnel.personcd != ''";
$clause.=" AND personnel.basic_pay BETWEEN $basic_pay[0] AND $basic_pay[1]";
$clause.=" AND personnel.grade_pay BETWEEN $grade_pay[0] AND $grade_pay[1]";

if($qualification_clause != 'ALL' && $not_qualification == 0){
	$clause.=" AND personnel.qualificationcd IN ($qualification_clause)";
}
else if($qualification_clause != 'ALL' && $not_qualification == 1){
	$clause.=" AND personnel.qualificationcd NOT IN ($qualification_clause)";
}

if($subdiv != 'ALL')
	$clause.=" AND personnel.subdivisioncd='".$subdiv."'";
if($govt_clause != 'ALL')
	$clause=$clause." AND office.govt IN ($govt_clause)";
if($officecd_clause != 'ALL')
	$clause=$clause." AND office.officecd IN ($officecd_clause)";
	
$desg_query="SELECT DISTINCT(off_desg) AS Designation FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE $clause ORDER BY off_desg";

$desg_result=mysql_query($desg_query,$DBLink) or die(json_encode(array("status"=>mysql_error())));
$return=array();
while($row=mysql_fetch_assoc($desg_result))
{
	$return[]=$row;
}	

echo json_encode($return);
?>